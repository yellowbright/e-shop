<?php
namespace Goods\Model;
use Think\Model;

class AttributeModel extends Model 
{
	protected $_validate = array(
				array('attr_name', 'require', '属性名称不能为空！', 1),
							);
	
	public function search()
	{
		$where = 'type_id='.(int)I('get.type_id');
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
		$data['attr_option_value'] = str_replace('，', ',', $data['attr_option_value']);
	}
	
	protected function _before_update(&$data, $option)
	{
		$data['attr_option_value'] = str_replace('，', ',', $data['attr_option_value']);
	}
}
