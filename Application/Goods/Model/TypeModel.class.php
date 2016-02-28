<?php
namespace Goods\Model;
use Think\Model;

class TypeModel extends Model 
{
	protected $_validate = array(
				array('type_name', 'require', '类型名称不能为空！', 1),
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
}
