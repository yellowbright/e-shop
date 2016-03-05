<?php
namespace Goods\Model;
use Think\Model;

class CategoryModel extends Model 
{
	protected $_validate = array(
				array('cat_name', 'require', '分类名称不能为空！', 1),
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
		$data = $this->where($where)->limit($pageObj->firstRow.','.$pageObj->listRows)->select();
		return array(
			'pageStr' => $pageStr,
			'data' => $data,
		);
	}
	
	protected function _before_insert(&$data, $option)
	{
		var_dump($data);die;
		$data['rec_id'] = implode(',', $data['rec_id']);
		if($data['attr_id'] == null)
		{
			$data['attr_id'] = '';
			return TRUE;	
		}
		/************ 先去掉数组中的0 *************/
		$data['attr_id'] = array_unique($data['attr_id']);
		// 找出0来
		$key = array_search(0, $data['attr_id']);
		if($key !== FALSE)
			unset($data['attr_id'][$key]);
		/********** 去了0之后如果数组中还有其他数就转化成字符串存到数据库中 **************/
		if($data['attr_id'])
		{
			$data['attr_id'] = implode(',', $data['attr_id']);
		}
	}
	protected function _before_update(&$data, $option)
	{
		$data['rec_id'] = implode(',', $data['rec_id']);
		if($data['attr_id'] == null)
		{
			$data['attr_id'] = '';
			return TRUE;	
		}
		/************ 先去掉数组中的0 *************/
		$data['attr_id'] = array_unique($data['attr_id']);
		// 找出0来
		$key = array_search(0, $data['attr_id']);
		if($key !== FALSE)
			unset($data['attr_id'][$key]);
		/********** 去了0之后如果数组中还有其他数就转化成字符串存到数据库中 **************/
		if($data['attr_id'])
		{
			$data['attr_id'] = implode(',', $data['attr_id']);
		}
	}
	public function getCatTree()
	{
		// 先取出所有的权限
		$data = $this->select();
		// 通过递归重新排序
		return $this->reSort($data);
	}
	public function reSort($data, $parent_id=0, $level = 0)
	{
		static $ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;
				$ret[] = $v;
				$this->reSort($data, $v['id'], $level+1);
			}
		}
		return $ret;
	}
	// 找一个权限所有子权限的ID
	public function getChildren($priId)
	{
		// 先取出所有的权限
		$data = $this->select();
		// 找出子权限的id
		return $this->_getChildren($data, $priId, TRUE);
	}
	public function _getChildren($data, $parent_id=0, $isClear = FALSE)
	{
		static $ret = array();
		// 如果是第一次进入递归先清空数组
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$ret[] = $v['id'];
				$this->_getChildren($data, $v['id']);
			}
		}
		return $ret;
	}
}
