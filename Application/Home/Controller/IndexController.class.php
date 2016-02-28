<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller{
 	public function _initialize(){
 		if(!session('id'))
 			$this->error('必须先登录',U('Login/login'));
 	
 	// public function __construct()
 	// {
 	// 	parent::__construct();
 	// 	if(!session('id'))
 	// 		$this->error('必须先登录',U('Login/login'));
 	// }
 	$privilege = session('privilege');
		// 欢迎页面可以直接访问
		if(MODULE_NAME == 'Home' && CONTROLLER_NAME == 'Index')
			return TRUE;
		else 
		{
			// 循环所有的权限判断有没有当前正在访问的地址对应的权限
			foreach ($privilege as $k => $v)
			{
				if(strtoupper($v['module_name']) == strtoupper(MODULE_NAME) && 
				strtoupper($v['controller_name']) == strtoupper(CONTROLLER_NAME) && 
				strtoupper($v['action_name']) == strtoupper(ACTION_NAME))
					return TRUE;
			}
			$this->error('无权访问');
		}
	}
}