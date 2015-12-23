<?php

// namespace Home/Controller;
// use Think/Controller;
namespace Home\Controller;
class PrivilegeController extends \Home\Controller\IndexController{
	public function lst(){
		$model = D('Privilege');
		$data = $model -> getPriTree();
		$this -> assign('data' ,$data);
		$this -> display();
	}
	public function add(){
		$model=D('Privilege');
		if(IS_POST){
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
		$data=$model->getPriTree();
		$this->assign('data',$data);
		$this->display();
	}
	public function save($id){
		$model=D('Privilege');
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
		$data  = $model -> find($id);
		$this -> assign('data', $data);
		$model = D('Privilege');
		$priData = $model->getPriTree();
		$this->assign('priData', $priData);
		$this->display();
	}
	public function del($id){
		$model = D('Privilege');
		$ret=$model->getChildren($id);
		$ret[]=$id;
		$ret=implode(',',$ret);
		$model->delete($ret);	
		$this -> success('删除成功',U('lst'));
	}
	public function bdel(){
		$delid = (array)I('post.delid');
		$allChildren=array();
		$model = D('Privilege');
		if($delid){
			foreach($delid as $v){
				$ret=$model->getChildren($v);
				$ret[]=$v;
				$allChildren=array_merge($allChildren,$ret);
			}
			$allChildren=array_unique($allChildren);
			$allChildren =implode(',',$allChildren);
			$model -> delete($allChildren);
			}	
	$this -> success('批量删除成功',U('lst'));
	exit;
	}
}