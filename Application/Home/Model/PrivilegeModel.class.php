<?php
namespace Home\Model;
use Think\Model;
class PrivilegeModel extends Model{
	// public function $_valicate(){
	protected $_validate=array(
	//下面4行可以放到一个中
																	array('pri_name','require','权限名称不能为空',1),
																		array('module_name','require','对应的模块名不能为空',1),
																		array('controller_name','require','对应的控制器名不能为空',1),
																		array('action_name','require','对应的方法名不能为空',1),
																										);
	

	public function getPriTree(){
		$data=$this->select();
		return $this->reSort($data);
	}

	public function reSort($data,$parent_id=0){
		static $ret =array();
		foreach($data as $k=>$v){
			if($v['parent_id']==$parent_id){
				$ret[]=$v;
				$this->reSort($data,$v['id']);
			}
		}
		return $ret;
	}
	public function getChildren($id){
		$data=$this->select();
		return $this->_getChildren($data,$id,TRUE);
	}
	public function _getChildren($data,$parId,$first=FLASE){
		static $ret=array();
		if($first)
			unset($ret);
		foreach($data as $k=>$v){
			if($v['parent_id']==$parId){
				$ret[]=$v['id'];
				$this->_getChildren($data,$parId=$v['id']);
			}
		}
		return $ret;
	}
	protected function _before_insert(&$data,$option){
		if($data['parent_id']==0){
			$data['pri_level']=0;
		}else{
		$this->field('pri_level')->find($data['parent_id']);
		$data['pri_level']=$this->pri_level+1;
		}
	}
	protected function _before_update(&$data, $option)
	{
		/****************** 计算当前这个权限的pri_level *********************/
		if($data['parent_id'] == 0)
			$data['pri_level'] = 0;
		else 
		{
			// 取出上级权限是第几级的
			$this->field('pri_level')->find($data['parent_id']); //SELECT pri_level FROM sh_privilege HWERE id= $data['parent_id']
			// 设置当前权限级别是上级+1
			$data['pri_level'] = $this->pri_level+1;
		}
		/************** 根据当前这个权限的pri_level再修改所有子权限的pri_level *************************/
		// 1. 取出所有的权限
		$priData = $this->select();
		// 第一个参数：所有的权限
		// 二个：当前权限的ID
		// 三个：当前权限的pri_level
		$this->_updateChildPriLevel($priData, $option['where']['id'], $data['pri_level']);
	}
	private function _updateChildPriLevel($priData,$parent_id,$pri_level){
		foreach($priData as $v){
			if($v['parent_id']==$parent_id){
				$this->execute("UPDATE yellow28_privilege SET pri_level=($pri_level+1) WHERE id={$v['id']}");
				// $this->execute('UPDATE php28_privilege SET pri_level ='.($parent_level+1).' WHERE id='.$v['id']);
				 // var_dump($this->getLastSql());die;
				$this->_updateChildPriLevel($priData, $v['id'], $pri_level+1);
			}
		}
	}
}