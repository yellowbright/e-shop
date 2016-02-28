<?php
namespace Home\Model;
use Think\Model;
class AdminModel extends Model{
	// public function $_valicate(){
	protected $_validate=array(
		//任何时候
		array('username','require','账号不能为空',1),	
		//登录时,修改时,也就是说第4个参数为0可以变为1用两个6参数替换	
		array('rpassword','password','两次密码必须一致',0,'confirm'),
		//登录时判断
		array('password','require','密码不能为空',1,'regex',4),
		array('captcha', 'require', '验证码不能为空！', 1, 'regex', 4),
		array('captcha','chkCode','验证码不正确',1,'callback',4),
		//添加时判段
		array('username','','账号不能重复',1,'unique',1),
		array('password','require','密码不能为空',1,'regex',1),
		//修改时判断
		array('username','','账号不能重复',1,'unique',2)
	//注意标点;	
	);
	protected function _before_insert(&$data,$option){
		$data['password']=md5($data['password']);
	}
	protected function _before_update(&$data,$option){
		if(!$data['password'])
			unset($data['password']);
		else
		$data['password']=md5($data['password']);
	}
	public function search(){
		$where = 1;
		$un = (string)I('get.un');
		$id = (int)I('get.id');
		if($un){
			$where .= " AND username LIKE '%{$un}%'";
		}
		if($id)
		$where .=" AND id =".$id;
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
	public function login(){
		$password = $this->password;
		$user = $this->where("username = '{$this->username}'")->find();
		if($user){
			if($this->password==md5($password)){
				session('id',$user['id']);
				session('username',$user['username']);
				$this->putPriDataToSession($user['role_id']);
				return TRUE;
			}
			else
				return -2;
		}
		else 
			return -1;
	}

public function putPriDataToSession($role_id)
	{
		// 根据角色ID取出这个角色的权限ID
		$roleModel = M('Role');
		$roleModel->find($role_id);
		$priModel = M('Privilege');
		if($roleModel->pri_id == '*')
		{
			$priData = $priModel->select();
			session('privilege', $priData);
		}
		else 
		{
			// 根据权限的ID，取出权限对应的信息
			$priData = $priModel->select($roleModel->pri_id);
			session('privilege', $priData);
		}
	}

	public function logout(){
		session(NULL);
	}
	protected function chkCode($code){
    		$verify = new \Think\Verify();
    		return $verify->check($code);
	}
}