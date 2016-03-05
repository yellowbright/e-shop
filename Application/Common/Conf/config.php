<?php
return array(
	//track
	// 'SHOW_PAGE_TRACE' =>true,
	//'配置项'=>'配置值'
	'DB_TYPE'               =>  'MYSQL',
	'DB_HOST'               =>  '127.0.0.1', // 服务器地址
	'DB_NAME'               =>  'yellow28',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  '123456',          // 密码
	'DB_PREFIX'             =>  'yellow28_',    // 数据库表前缀
	'DB_CHARSET'            =>  'utf8',
	//令牌
	'TOKEN_ON'      =>    false,  // 是否开启令牌验证 默认关闭
	'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
	'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true

);