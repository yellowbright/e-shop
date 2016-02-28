<?php
namespace Home\Model;
use Think\Model;
class RoleModel extends Model{
	// public function $_valicate(){
	protected $_validate=array(
	//下面4行可以放到一个中
																	array('role_name','require','角色名称不能为空',1),
																	);
	
	public function search()
	{
		$where = 1;
		// 取出总的记录数
		$count = $this->where($where)->count();
		// 生成翻页对象
		$pageObj = new \Think\Page($count, 25);
		// 获取翻页的字符串:上一页、下一页
		$pageStr = $pageObj->show();
		// 取出当前页的数据
		//$data = $this->query("SELECT a.*,GROUP_CONCAT(b.pri_name) pn  FROM php28_role a LEFT JOIN php28_privilege b ON FIND_IN_SET(b.id,a.pri_id) GROUP BY a.id WHERE $where LIMIT{$pageObj->firstRow},{$pageObj->listRows}");
		$data = $this->alias('a')->field('a.*,GROUP_CONCAT(b.pri_name) pn')->join('LEFT JOIN yellow28_privilege b ON FIND_IN_SET(b.id,a.pri_id)')->group('a.id')->where($where)->limit($pageObj->firstRow.','.$pageObj->listRows)->select();
		
		return array(
			'pageStr' => $pageStr,
			'data' => $data,
		);
	}

	public function _before_insert(&$data, $option){
		$data['pri_id']=implode(',', $data['pri_id']);
	}
	protected function _before_update(&$data, $option)
	{
		$data['pri_id'] = implode(',', $data['pri_id']);
	}
}