<?php
namespace Goods\Controller;

class AttributeController extends \Home\Controller\IndexController 
{
	// 添加
	public function add($type_id)
	{
		if(IS_POST)
		{
			$model = D('Attribute');
			if($model->create())
			{
				if($model->add())
				{
					$this->success('添加成功！', U('lst', array('type_id'=>$type_id)));
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
		$this->display();
	}
	public function lst()
	{
		$model = D('Attribute');
		$data = $model->search();
		$this->assign(array(
			'data' => $data['data'],
			'page' => $data['pageStr'],
		));
		// 取出所有的类型
		$typeModel = M('Type');
		$typeData = $typeModel->select();
		$this->assign('typeData', $typeData);
		$this->display();
	}
	public function save($id, $type_id)
	{
		$model = D('Attribute');
		if(IS_POST)
		{
			if($model->create())
			{
				if($model->save() !== FALSE)
				{
					$this->success('修改成功！', U('lst', array('type_id'=>$type_id)));
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
		$data = $model->find($id);
		$this->assign('data', $data);
		$this->display();
	}
	public function del($id, $type_id)
	{
		$model = D('Attribute');
		$model->delete($id);
		$this->success('操作成功！', U('lst', array('type_id'=>$type_id)));
	}
	public function bdel($type_id)
	{
		$delid = I('post.delid');
		if($delid)
		{
			$delid = implode(',', $delid);
			$model = D('Attribute');
			$model->delete($delid);
		}
		$this->success('操作成功！', U('lst', array('type_id'=>$type_id)));
	}
}