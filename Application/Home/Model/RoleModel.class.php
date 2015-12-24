<?php
namespace Home\Model;
use Think\Model;
class RoleModel extends Model{
	// public function $_valicate(){
	protected $_validate=array(
	//下面4行可以放到一个中
																	array('role_name','require','角色名称不能为空',1),
																	);
	
	public function _before_insert(&$data, $option){
		$data['pri_id']=implode(',', $data['pri_id']);
	}
	protected function _before_update(&$data, $option)
	{
		$data['pri_id'] = implode(',', $data['pri_id']);
	}
}