<?php
namespace Goods\Model;
use Think\Model;
class BrandModel extends Model{
	// public function $_valicate(){
	protected $_validate=array(
	//下面4行可以放到一个中
																	array('brand_name','require','品牌名称不能为空',1),
																										);
	
	public function search(){
		$where = 1;
		$count      = $this->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $this->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		return array(
			'page'=>$show,
			'data' => $list
			);
	}
	protected function _before_insert(&$data, $option)
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
	    $upload->savePath  =     'Brand/'; // 设置附件上传（子）目录
	    // 上传文件 
	    $info   =   $upload->upload();
	    $data['brand_logo'] = $info['brand_logo']['savepath'] . $info['brand_logo']['savename'];
	}
	protected function _before_update(&$data, $option)
	{
		if($_FILES['brand_logo']['error'] == 0)
		{
			// 删除原图
			// @ 错误抵制符：即使有错也忽略掉
			@unlink( './Uploads/' . I('post.old_logo'));
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
		    $upload->savePath  =     'Brand/'; // 设置附件上传（子）目录
		    // 上传文件 
		    $info   =   $upload->upload();
		    $data['brand_logo'] = $info['brand_logo']['savepath'] . $info['brand_logo']['savename'];
		}
	}
	protected function _before_delete($option)
	{
		/**
		 * array
  'where' => 
    array
      'id' => int 1
  'table' => string 'php28_brand' (length=11)
  'model' => string 'Brand' (length=5)
  **********
  * array
  'where' => 
    array
      'id' => 
        array
          0 => string 'IN' (length=2)
          1 => string '1,2' (length=3)
  'table' => string 'php28_brand' (length=11)
  'model' => string 'Brand' (length=5)
		 */
		if(is_array($option['where']['id']))
		{
			// 取出所有要删除的品牌的图片
			$logos = $this->field('brand_logo')->select($option['where']['id'][1]);
			// 循环每一个图片删除
			foreach ($logos as $logo)
			{
				@unlink('./Uploads/'.$logo['brand_logo']);	
			}
		}
		else 
		{
			// 先根据ID取出图片
			$this->field('brand_logo')->find($option['where']['id']);
			@unlink('./Uploads/'.$this->brand_logo);	
		}
	}
}