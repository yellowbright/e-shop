<?php
// namespace Home/Controller;
// use Think/Controller;
namespace Home\Controller;
class AdminController extends IndexController{
	public function lst(){
		$model = D('Admin');
		$data = $model -> search();
		$this -> assign(
			array(
				'data' => $data['data'],
				'page'=>$data['page']
				)
			);
		$this -> display();
	}
	public function add(){
		if(IS_POST){
			$model=D('Admin');
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
		$roleModel = M('Role');
		$roleData = $roleModel->select();
		$this->assign('roleData', $roleData);
		$this->display();
	}
	public function save($id){
		$model=D('Admin');
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
		$this->display();
	}
	public function del($id){
		$model = M('admin');
		if($id > 1)
			$model -> delete($id);
		$this -> success('删除成功',U('lst'));
	}
	public function bdel(){
		$delid = (array)I('post.delid');
		if($delid){	
		$delid= array_unique($delid);
		$key = array_search(1, $delid);
		if($key !== FALSE)
			unset($delid[$key]);
		if($delid){
			$delid =implode(',',$delid);
			$model = M('admin');
			if (!$model->autoCheckToken($_POST)){
 // 令牌验证错误
				$this->error('令牌验证错误');
 }
			$model -> delete($delid);
			}	
		}
	$this -> success('批量删除成功',U('lst'));
	exit;
	}
}