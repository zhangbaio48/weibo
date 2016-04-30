<?php
return array(
	//数据库配置
	'DB_HOST' => '127.0.0.1',	//数据库服务器地址
	'DB_USER' => 'root',	//数据库连接用户名
	'DB_PWD' => '',	//数据库连接密码
	'DB_NAME' => 'weibo', //使用数据库名称
	'DB_PREFIX' => 'hd_',	//数据库表前缀

	'DEFAULT_THEME' => 'default',	//默认主题模版

	'URL_MODEL' => 1,

	'TOKEN_ON' => false,	//关闭令牌功能

	//用于异位或加密的KEY
	'ENCTYPTION_KEY' => 'www.houdunwang.com',
	//自动登录保存时间
	'AUTO_LOGIN_TIME' => time() + 3600 * 24 * 7,	//一个星期

	//图片上传
	'UPLOAD_MAX_SIZE' => 2000000,	//最大上传大小
	'UPLOAD_PATH' => './Uploads/',	//文件上传保存路径
	'UPLOAD_EXTS' => array('jpg', 'jpeg', 'gif', 'png'),	//允许上传文件的后缀

	//URL路由配置
	'URL_ROUTER_ON' => true,	//开启路由功能
	'URL_ROUTE_RULES' => array(	//定义路由规则
		':id\d' => 'User/index',
		'follow/:uid\d' => array('User/followList', 'type=1'),
		'fans/:uid\d' => array('User/followList', 'type=0'),
		),

	//自定义标签配置
	'TAGLIB_LOAD' => true,	//加载自定义标签库
	'APP_AUTOLOAD_PATH' => '@.TagLib',	//自动加载
	'TAGLIB_BUILD_IN' => 'Cx,Hdtags',	//加入系统标签库

	//缓存设置
	//'DATA_CACHE_SUBDIR' => true,	//开启以哈唏形式生成缓存目录
	//'DATA_PATH_LEVEL' => 2,	//目录层次
	'DATA_CACHE_TYPE' => 'Memcache',
	'MEMCACHE_HOST' => '127.0.0.1',
	'MEMCACHE_PORT' => 11211,

	//加载扩展配置
	'LOAD_EXT_CONFIG' => 'system',
);
?>