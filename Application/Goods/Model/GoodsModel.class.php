<?php
namespace Goods\Model;
use Think\Model;

class GoodsModel extends Model 
{
	protected $_validate = array(
				array('goods_name', 'require', '商品名称不能为空！', 1),
						array('market_price', 'require', '市场价不能为空！', 1),
						array('shop_price', 'require', '本场价不能为空！', 1),
						);
	
	public function search()
	{
		$where = 1;
		// 取出总的记录数
		$count = $this->where($where)->count();
		// 生成翻页对象
		$pageObj = new \Think\Page($count, 25);
		// 获取翻页的字符串:上一页、下一页
		$pageStr = $pageObj->show();
		// 取出当前页的数据
		$data = $this->where($where)->limit($pageObj->firstRow.','.$pageObj->listRows)->select();
		return array(
			'pageStr' => $pageStr,
			'data' => $data,
		);
	}
	
	protected function _before_insert(&$data, $option)
	{
		$data['rec_id'] = implode(',', $data['rec_id']);
		if($_FILES['logo']['error'] == 0)
		{
			/********** 上传图片 ***********/
			$upload = new \Think\Upload();// 实例化上传类
			// php.ini中
			// upload_max_filesize = 2M   -->  单个上传文件不能超过这么大
			// post_max_size = 8M   -->   整个表单中的数据不能超过8M
			// 因为PHP.INI最大2M，所以这里最大不能超过2M
			$iniMaxSize = (int)ini_get('upload_max_filesize');
			if($iniMaxSize >= 4)
				$iniMaxSize = 4;
			$upload->maxSize   =     $iniMaxSize * 1024 * 1024 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		    $upload->savePath  =     'Goods/'; // 设置附件上传（子）目录
		    // 上传文件 
		    $info   =   $upload->upload(array('logo' => $_FILES['logo']));
		    /* 生成三张缩略图的代码 */
		    $image = new \Think\Image(); 
		    // 定义图片的名字
		    // Goods/2014-19-19/121241fdsadf4.jpg
		    $logo = $info['logo']['savepath'] . $info['logo']['savename'];
		    $big_logo = $info['logo']['savepath'] . 'big_'. $info['logo']['savename'];
		    $mid_logo = $info['logo']['savepath'] . 'mid_'.$info['logo']['savename'];
		    $sm_logo = $info['logo']['savepath'] . 'sm_'.$info['logo']['savename'];
		    // 打开原图
			$image->open('./Uploads/' . $logo);
			// 如果要生成多张缩略图，要从大到小的生成
			$image->thumb(350, 350)->save('./Uploads/'.$big_logo);
			$image->thumb(130, 130)->save('./Uploads/'.$mid_logo);
			$image->thumb(50, 50)->save('./Uploads/'.$sm_logo);
			// 把图片的路径存到数据库中
		    $data['logo'] = $logo;
		    $data['big_logo'] = $big_logo;
		    $data['mid_logo'] = $mid_logo;
		    $data['sm_logo'] = $sm_logo;
		}
	}
	
	// 第一个参数：插入到数据库中的数据的数组，其中$data['id']就是刚刚插入的商品的id
	protected function _after_insert($data, $option)
	{
		// $data['id'] 就是添加完的商品的id
		$goods_id = $data['id'];
		/********************* 会员价格 *************************/
		$mpModel = M('MemberPrice');
		$ml = I('post.MemberPrice');
		// 循环每个会员价格插入到会员价格表
		foreach ($ml as $k => $v)
		{
			// 如果价格为空或0就不插入数据库
			if((int)$v == 0)
				continue ;
			$mpModel->add(array(
				'price' => $v,
				'level_id' => $k,
				'goods_id' => $goods_id,
			));
		}
		/******************* 商品属性 *****************************/
		// 商品属性
		$ga = I('post.goods_attr');
		// 商品价格
		$ap = I('post.attr_price');
		// 生成 goods_attr表模型
		$gaModel = M('GoodsAttr');
		$_i = 0;
		foreach ($ga as $k => $v)
		{
			foreach ($v as $k1 => $v1)
			{
				$gaModel->add(array(
					'goods_id' => $goods_id,
					'attr_id' => $k,
					'attr_value' => $v1,
					'attr_price' => $ap[$_i],
				));
				$_i++;
			}
		}
		/********************* 处理图片的代码 *********************/
		/********** 上传图片 ***********/
		$upload = new \Think\Upload();// 实例化上传类
		$iniMaxSize = (int)ini_get('upload_max_filesize');
		if($iniMaxSize >= 4)
			$iniMaxSize = 4;
		$upload->maxSize   =     $iniMaxSize * 1024 * 1024 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		$upload->savePath  =     'Goods/'; // 设置附件上传（子）目录
		// 上传文件 
		$info   =   $upload->upload(array('pics' => $_FILES['pics']));
		if($info !== FALSE)
		{
			$image = new \Think\Image();
			$gpModel = M('GoodsPic');
			foreach ($info as $k => $v)
			{
			    $logo = $v['savepath'] . $v['savename'];
			    $mid_logo = $v['savepath'] . 'mid_'.$v['savename'];
			    $sm_logo = $v['savepath'] . 'sm_'.$v['savename'];
			    // 打开原图
				$image->open('./Uploads/' . $logo);
				// 如果要生成多张缩略图，要从大到小的生成
				$image->thumb(350, 350)->save('./Uploads/'.$mid_logo);
				$image->thumb(50, 50)->save('./Uploads/'.$sm_logo);
				// 把图片的路径存到数据库中
				$gpModel->add(array(
					'sm_logo' => $sm_logo,
					'mid_logo' => $mid_logo,
					'logo' => $logo,
					'goods_id' => $goods_id,
				));
			}
		}
	}
	protected function _before_update(&$data, $option)
	{
		$data['rec_id'] = implode(',', $data['rec_id']);
		// 修改logo
		if($_FILES['logo']['error'] == 0)
		{
			// 如果有新图上就删除原图
			@unlink('./Uploads/'.I('post.old_logo1'));
			@unlink('./Uploads/'.I('post.old_logo2'));
			@unlink('./Uploads/'.I('post.old_logo3'));
			@unlink('./Uploads/'.I('post.old_logo4'));
			/********** 上传图片 ***********/
			$upload = new \Think\Upload();// 实例化上传类
			$iniMaxSize = (int)ini_get('upload_max_filesize');
			if($iniMaxSize >= 4)
				$iniMaxSize = 4;
			$upload->maxSize   =     $iniMaxSize * 1024 * 1024 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		    $upload->savePath  =     'Goods/'; // 设置附件上传（子）目录
		    // 上传文件 
		    $info   =   $upload->upload(array('logo' => $_FILES['logo']));
		    /* 生成三张缩略图的代码 */
		    $image = new \Think\Image(); 
		    // 定义图片的名字
		    // Goods/2014-19-19/121241fdsadf4.jpg
		    $logo = $info['logo']['savepath'] . $info['logo']['savename'];
		    $big_logo = $info['logo']['savepath'] . 'big_'. $info['logo']['savename'];
		    $mid_logo = $info['logo']['savepath'] . 'mid_'.$info['logo']['savename'];
		    $sm_logo = $info['logo']['savepath'] . 'sm_'.$info['logo']['savename'];
		    // 打开原图
			$image->open('./Uploads/' . $logo);
			// 如果要生成多张缩略图，要从大到小的生成
			$image->thumb(350, 350)->save('./Uploads/'.$big_logo);
			$image->thumb(130, 130)->save('./Uploads/'.$mid_logo);
			$image->thumb(50, 50)->save('./Uploads/'.$sm_logo);
			// 把图片的路径存到数据库中
		    $data['logo'] = $logo;
		    $data['big_logo'] = $big_logo;
		    $data['mid_logo'] = $mid_logo;
		    $data['sm_logo'] = $sm_logo;
		}
	}
	protected function _after_update($data, $option)
	{
		$goods_id = $option['where']['id'];
		/************** 处理商品属性 ********************/
		// 1.添加了新的属性
		$newGA = I('post.new_goods_attr');
		$newAP = I('post.new_attr_price');
		$gaModel = M('GoodsAttr');
		$_i = 0;
		foreach ($newGA as $k => $v)
		{
			foreach ($v as $k1 => $v1)
			{
				$gaModel->add(array(
					'goods_id' => $goods_id,
					'attr_id' => $k,
					'attr_value' => $v1,
					'attr_price' => $newAP[$_i],
				));
				$_i++;
			}
		}
		// 2. 删除原属性
		$delid = I('post.del_goodsattr_id');
		if($delid)
			$gaModel->delete($delid);
		// 3. 修改原属性
		// 商品属性
		$ga = I('post.goods_attr');
		// 商品价格
		$ap = I('post.attr_price');
		$_i = 0;
		foreach ($ga as $k => $v)
		{
			foreach ($v as $k1 => $v1)
			{
				$gaModel->where('id='.$k1)->save(array(
					'attr_value' => $v1,
					'attr_price' => $ap[$_i],
				));
				$_i++;
			}
		}
		/********************* 会员价格 *************************/
		$mpModel = M('MemberPrice');
		$ml = I('post.MemberPrice');
		// 先删除原价格
		$mpModel->where('goods_id='.$goods_id)->delete();
		// 循环每个会员价格插入到会员价格表
		foreach ($ml as $k => $v)
		{
			// 如果价格为空或0就不插入数据库
			if((int)$v == 0)
				continue ;
			$mpModel->add(array(
				'price' => $v,
				'level_id' => $k,
				'goods_id' => $goods_id,
			));
		}
		/************************** 处理图片 ************************/
		// 1. 先删除图片
		$imgId = I('post.imgId');
		// 先取出当前商品所有的图片
		$gpModel = M('GoodsPic');
		$gpData = $gpModel->where('goods_id='.$goods_id)->select();
		// 循环数据库中每一张图片
		foreach ($gpData as $k => $v)
		{
			// 判断如果表单中没有这张图片，说明图片已经被删除了
			if(empty($imgId) || !in_array($v['id'], $imgId))
			{
				// 从硬盘上删除图片
				@unlink('./Uploads/'.$v['sm_logo']);
				@unlink('./Uploads/'.$v['mid_logo']);
				@unlink('./Uploads/'.$v['logo']);
				// 从数据库中把记录也删除
				$gpModel->delete($v['id']);
			}
		}
		// 2. 上传新图片
		/********************* 处理图片的代码 *********************/
		/********** 上传图片 ***********/
		$upload = new \Think\Upload();// 实例化上传类
		$iniMaxSize = (int)ini_get('upload_max_filesize');
		if($iniMaxSize >= 4)
			$iniMaxSize = 4;
		$upload->maxSize   =     $iniMaxSize * 1024 * 1024 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		$upload->savePath  =     'Goods/'; // 设置附件上传（子）目录
		// 上传文件 
		$info   =   $upload->upload(array('pics' => $_FILES['pics']));
		if($info !== FALSE)
		{
			$image = new \Think\Image();
			foreach ($info as $k => $v)
			{
			    $logo = $v['savepath'] . $v['savename'];
			    $mid_logo = $v['savepath'] . 'mid_'.$v['savename'];
			    $sm_logo = $v['savepath'] . 'sm_'.$v['savename'];
			    // 打开原图
				$image->open('./Uploads/' . $logo);
				// 如果要生成多张缩略图，要从大到小的生成
				$image->thumb(350, 350)->save('./Uploads/'.$mid_logo);
				$image->thumb(50, 50)->save('./Uploads/'.$sm_logo);
				// 把图片的路径存到数据库中
				$gpModel->add(array(
					'sm_logo' => $sm_logo,
					'mid_logo' => $mid_logo,
					'logo' => $logo,
					'goods_id' => $goods_id,
				));
			}
		}
	}
}






















