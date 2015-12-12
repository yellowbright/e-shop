<?php
namespace Home\Model;
use Think\Model;
class AdminModel extends Model{
	// public function $_valicate(){
	protected $_valicate=array(
		array('name','require','验证码不能为空',1),
		array('password','require','密码不能为空',1),
		array('password','','密码不能重复',1,'unique')
	//注意标点;	
	);
}