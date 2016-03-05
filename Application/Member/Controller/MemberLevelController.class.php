<?php
namespace Member\Controller;

class MemberLevelController extends \Home\Controller\IndexController 
{
	// 添加
	public function add()
	{
		if(IS_POST)
		{
			$model = D('MemberLevel');
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
		$model = D('MemberLevel');
		$data = $model->search();
		$this->assign(array(
			'data' => $data['data'],
			'page' => $data['pageStr'],
		));
		$this->display();
	}
	public function save($id)
	{
		$model = D('MemberLevel');
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
		$data = $model->find($id);
		$this->assign('data', $data);
		$this->display();
	}
	public function del($id)
	{
		$model = D('MemberLevel');
		$model->delete($id);
		$this->success('操作成功！', U('lst'));
	}
	public function bdel()
	{
		$delid = I('post.delid');
		if($delid)
		{
			$delid = implode(',', $delid);
			$model = D('MemberLevel');
			$model->delete($delid);
		}
		$this->success('操作成功！', U('lst'));
	}
}