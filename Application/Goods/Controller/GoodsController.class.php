<?php
namespace Goods\Controller;

class GoodsController extends \Home\Controller\IndexController 
{
	// 添加
	public function add()
	{
		if(IS_POST)
		{
			set_time_limit(0);
			$model = D('Goods');
			if($model->create($_POST['Goods']))
			{
				if($model->add())
				{
					$this->success('添加成功！', U('lst'));
					exit;
				}
				else 
				{
					$sql = $model->getLastSql();
					$this->error('插入数据库失败！.<hr />SQL:'.$sql);
				}
			}
			else 
			{
				$error = $model->getError();
				$this->error($error);
			}
		}
		// 取出所有的商品类型
		$typeModel = M('Type');
		$typeData = $typeModel->select();
		$this->assign('typeData', $typeData);
		
		// 取出所有的商品品牌
		$brandModel = M('Brand');
		$brandData = $brandModel->select();
		$this->assign('brandData', $brandData);
		
		$model = D('Category');
		$catData = $model->getCatTree();
		$this->assign('catData', $catData);
		
		// 取出所有的会员级别
		$mlModel = M('MemberLevel');
		$mlData = $mlModel->select();
		$this->assign('mlData', $mlData);
		
		// 取出所有商品的推荐位
		$recModel = M('Recommend');
		$recData = $recModel->where('rec_type="商品"')->select();
		$this->assign('recData', $recData);
		
		$this->display();
	}
	public function lst()
	{
		$model = D('Goods');
		$data = $model->search();
		$this->assign(array(
			'data' => $data['data'],
			'page' => $data['pageStr'],
		));
		$this->display();
	}
	public function save($id)
	{
		$model = D('Goods');
		if(IS_POST)
		{
//			var_dump($_POST);die;
			if($model->create($_POST['Goods']))
			{
				if($model->save() !== FALSE)
				{
					$this->success('修改成功！', U('lst'));
					exit;
				}
				else 
				{
					$sql = $model->getLastSql();
					$this->error('修改数据库失败！.<hr />SQL:'.$sql);
				}
			}
			else 
			{
				$error = $model->getError();
				$this->error($error);
			}
		}
		
		// 取出所有的商品类型
		$typeModel = M('Type');
		$typeData = $typeModel->select();
		$this->assign('typeData', $typeData);
		
		// 取出所有的商品品牌
		$brandModel = M('Brand');
		$brandData = $brandModel->select();
		$this->assign('brandData', $brandData);
		
		$catModel = D('Category');
		$catData = $catModel->getCatTree();
		$this->assign('catData', $catData);
		
		// 取出所有的会员级别
		$mlModel = M('MemberLevel');
		$mlData = $mlModel->select();
		$this->assign('mlData', $mlData);
		
		$data = $model->find($id);
		$this->assign('data', $data);
		
		// 取出当前商品所有的属性
		$sql = 'SELECT a.*,b.attr_name,b.attr_type,b.attr_option_value
 FROM yellow28_goods_attr a
  LEFT JOIN yellow28_attribute b ON a.attr_id=b.id
   WHERE a.goods_id='.$id;
		$goodsAttrData = $model->query($sql);
		$this->assign('goodsAttrData', $goodsAttrData);
		
		// 取出商品的会员价格
		$mpModel = M('MemberPrice');
		$mpData = $mpModel->where('goods_id='.$id)->select();
		$this->assign('mpData', $mpData);
		
		// 取出商品的图片
		$gpModel = M('GoodsPic');
		$gpData = $gpModel->where('goods_id='.$id)->select();
		$this->assign('gpData', $gpData);
		
		// 取出所有商品的推荐位
		$recModel = M('Recommend');
		$recData = $recModel->where('rec_type="商品"')->select();
		$this->assign('recData', $recData);
		
		$this->display();
	}
	public function del($id)
	{
		$model = D('Goods');
		$model->delete($id);
		$this->success('操作成功！', U('lst'));
	}
	public function bdel()
	{
		$delid = I('post.delid');
		if($delid)
		{
			$delid = implode(',', $delid);
			$model = D('Goods');
			$model->delete($delid);
		}
		$this->success('操作成功！', U('lst'));
	}
	public function ajaxGetAttr($tid)
	{
		$attrModel = M('Attribute');
		$data = $attrModel->where('type_id='.$tid)->select();
		echo json_encode($data);
	}
	public function goodsnumber($id)
	{
		$gnModel = M('GoodsNumber');
		if(IS_POST)
		{
			// 先删除原数据
			$gnModel->where('goods_id='.$id)->delete();
			$gai = I('post.goods_attr_id');
			$gn = I('post.goods_number');
			foreach ($gn as $k => $v)
			{
				$_arr = array();
				// 循环所有的属性,取出每个属性对应的值
				foreach ($gai as $k1 => $v1)
				{
					$_arr[] = $v1[$k];
				}
				// 把ID升序排序再存
				sort($_arr);
				$_arr = implode(',', $_arr);
				$gnModel->add(array(
					'goods_id' => $id,
					'goods_number' => $v,
					'goodsattr_id' => $_arr,
				));
			}
			$this->success('设置成功！');
			exit;
		}
		// 根据商品的ID取出单选属性的信息
		$m = M();
		$sql = 'SELECT a.*,b.attr_name FROM yellow28_goods_attr a LEFT JOIN yellow28_attribute b ON a.attr_id=b.id WHERE goods_id='.$id.' AND attr_id IN(SELECT attr_id FROM yellow28_goods_attr WHERE goods_id='.$id.' GROUP BY attr_id HAVING COUNT(*) > 1);';
		$_attrData = $m->query($sql);
		// 重新处理数组结构：
		$attrData = array();
		foreach ($_attrData as $k => $v)
		{
			$attrData[$v['attr_id']][] = $v;
		}
		$this->assign('attrData', $attrData);
		// 先取出这件商品所有的库存量
		$gnData = $gnModel->where('goods_id='.$id)->select();
		$this->assign('gnData', $gnData);
		$this->display();
	}
}