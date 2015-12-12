<?php
// namespace Home/Controller;
// use Think/Controller;
namespace Home\Controller;
use Think\Controller;
class AdminController extends Controller{
	public function lst(){

	}
	public function add(){
		if(IS_POST){
			$model=D('Admin');
			if($model->create()){
				if($model->add()){
					$this->success('添加数据陈功',U('lst'));
					// 注意添加exit
					exit;
				}
				else{
					// $sql=$model->getLstSql();
					$sql=$model->getLastSql();
					$this->error('添加数据失败!  <br/>'.$sql)
				}
			}else{
				$error=$model->getError();
				$this->error($error);
			}
		}
		$this->display();
	}
	public function save(){

	}
	public function del(){

	}
	public function bdel(){

	}
}