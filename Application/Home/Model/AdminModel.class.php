<?php
namespace Home\Model;
use Think\Model;
class AdminModel extends Model{
	// public function $_valicate(){
	protected $_validate=array(
		array('username','require','账号不能为空',1),
		array('password','require','密码不能为空',1),
		array('password','','密码不能重复',1,'unique'),
		array('rpassword','password','两次密码必须一致',0,'confirm')
	//注意标点;	
	);
	protected function _before_insert(&$data,$option){
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
}