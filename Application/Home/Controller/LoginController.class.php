<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller{
	public function login(){
		if(IS_POST)
		{
			$model = D('Admin');
			if($model -> create($_POST,4))
			{
				$ret = $model -> login();
			if($ret ===TRUE){
				$this -> success('登录成功',U('Index/index'));
			exit;
			}
			elseif ($ret ==-1)
				$this -> error('用户名不存在!');
			elseif($ret == -2)
				$this -> error('密码错误!');	
		}
		else
			$this->error($model->getError());
		}
		$this->display();	
	}
	public function logout(){
		$model = D('Admin');
		$model->logout();
		$this->success('清除登录状态成功,跳转到登录页面',U('login'));
		exit;
	}
	public function chkImg(){
		$Verify = new \Think\Verify();
		$Verify->entry();
	}
}