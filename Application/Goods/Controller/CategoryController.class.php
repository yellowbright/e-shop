<?php
namespace Goods\Controller;

class CategoryController extends \Home\Controller\IndexController 
{
	// 添加
	public function add()
	{
		if(IS_POST)
		{
			$model = D('Category');
			if($model->create())
			{
				if($model->add())
				{
					$this->success('添加成功！', U('lst'));
					exit;
				}
				else 
				{
					$sql = $model->getLastSql();
					$this->error('插入数据库失败！.<hr />SQL:'.$sql,NULL,1000);
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
		
		$model = D('Category');
		$catData = $model->getCatTree();
		$this->assign('catData', $catData);
		
		// 取出所有商品的推荐位
		$recModel = M('Recommend');
		$recData = $recModel->where('rec_type="分类"')->select();
		$this->assign('recData', $recData);
		
		$this->display();
	}
	public function lst()
	{
		$model = D('Category');
		$data = $model->getCatTree();
		$this->assign('data', $data);
		$this->display();
	}
	public function save($id)
	{
		$model = D('Category');
		if(IS_POST)
		{
			if($model->create())
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
		
		$data = $model->find($id);
		$this->assign('data', $data);
		
		// 取出筛选属性的信息
		$attrModel = M('Attribute');
		$attrInfo = $attrModel->where("id IN({$data['attr_id']})")->select();
		$this->assign('attrInfo', $attrInfo);
		
		// 取出所有的分类制作一个下拉框
		$model = D('Category');
		$catData = $model->getCatTree();
		$this->assign('catData', $catData);
		
		// 取出所有商品的推荐位
		$recModel = M('Recommend');
		$recData = $recModel->where('rec_type="分类"')->select();
		$this->assign('recData', $recData);
		
		$this->display();
	}
	public function del($id)
	{
		$model = D('Category');
		// 先找出这个权限所有子权限的id
		$children = $model->getChildren($id);
		$children[] = $id;
		$children = implode(',', $children);
		$model->delete($children);
		$this->success('操作成功！', U('lst'));
	}
	public function bdel()
	{
		$delid = I('post.delid');
		if($delid)
		{
			$model = D('Category');
			// 所有子权限的ID
			$allChildren = array();
			// 循环每一个权限找出他们的子权限
			foreach ($delid as $id)
			{
				$_children = $model->getChildren($id);
				$allChildren = array_merge($allChildren, $_children);
				// 把父权限的ID也放到数组中
				$allChildren[] = $id;
			}	
			// 去掉数组中重复的ID
			$allChildren = array_unique($allChildren);
			$allChildren = implode(',', $allChildren);
			$model->delete($allChildren);
		}
		$this->success('操作成功！', U('lst'));
	}
	public function ajaxGetAttr($type_id)
	{
		$attrModel = M('Attribute');
		$data = $attrModel->where('type_id='.$type_id)->select();
		echo json_encode($data);
	}
}