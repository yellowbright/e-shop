<?php

// namespace Home/Controller;
// use Think/Controller;
namespace Home\Controller;
class RoleController extends \Home\Controller\IndexController{
	public function lst(){
		$model = M('Role');
		$data = $model -> select();
		$this -> assign('data',$data);
		$this -> display();
	}
	public function add(){
		if(IS_POST){
			$model=D('Role');
			if($model->create()){
				if($model->add()){
					$this->success('添加数据成功',U('lst'));
					// 注意添加exit
					exit;
				}
				else{
					// $sql=$model->getLstSql();
					$sql=$model->getLastSql();
					$this->error('添加数据失败!  <br/>'.$sql);
				}
			}else{
				$error=$model->getError();
				$this->error($error);
			}
		}
		$privilegeModel=D('Privilege');
		$priData=$privilegeModel->getPriTree();
		$this->assign('priData',$priData);
		$this->display();
	}
	public function save($id){
		$model=D('Role');
		if(IS_POST){
			if($model->create()){
				if($model->save()!==FALSE){
					$this->success('修改数据成功',U('lst'));
					// 注意添加exit
					exit;
				}
				else{
					// $sql=$model->getLstSql();
					$sql=$model->getLastSql();
					$this->error('修改数据失败!  <br/>'.$sql);
				}
			}else{
				$error=$model->getError();
				$this->error($error);
			}
		}
		$privilegeModel=D('Privilege');
		$priData=$privilegeModel->getPriTree();
		$this->assign('priData',$priData);
		$data  = $model -> find($id);
		$this -> assign('data', $data);
		$this->display();
	}
	public function del($id){
		$model = M('Role');
			$model -> delete($id);
		$this -> success('删除成功',U('lst'));
	}
	public function bdel(){
		$delid = (array)I('post.delid');
		if($delid){
			$delid =implode(',',$delid);
			$model = M('Role');
			if (!$model->autoCheckToken($_POST)){
 // 令牌验证错误
				$this->error('令牌验证错误');
 }
			$model -> delete($delid);
			}	
	$this -> success('批量删除成功',U('lst'));
	exit;
	}
}