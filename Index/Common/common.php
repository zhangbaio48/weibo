<?php

/**
 * 格式化打印数组
 */
function p ($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

/**
 * 异位或加密字符串
 * @param  [String]  $value [需要加密的字符串]
 * @param  [integer] $type  [加密解密（0：加密，1：解密）]
 * @return [String]         [加密或解密后的字符串]
 */
function encryption ($value, $type=0) {
	$key = md5(C('ENCTYPTION_KEY'));
	
	if (!$type) {
		return str_replace('=', '', base64_encode($value ^ $key));
	}

	$value = base64_decode($value);
	return $value ^ $key;
}

/**
 * 格式化时间
 * @param  [type] $time [要格式化的时间戳]
 * @return [type]       [description]
 */
function time_format ($time) {
	//当前时间
	$now = time();
	//今天零时零分零秒
	$today = strtotime(date('y-m-d', $now));
	//传递时间与当前时秒相差的秒数
	$diff = $now - $time;
	$str = '';
	switch ($time) {
		case $diff < 60 :
			$str = $diff . '秒前';
			break;
		case $diff < 3600 :
			$str = floor($diff / 60) . '分钟前';
			break;
		case $diff < (3600 * 8) :
			$str = floor($diff / 3600) . '小时前';
			break;
		case $time > $today :
			$str = '今天&nbsp;&nbsp;' . date('H:i', $time);
			break;
		default : 
			$str = date('Y-m-d H:i:s', $time);
	}
	return $str;
}

/**
 * 替换微博内容的URL地址、@用户与表情
 * @param  [String] $content [需要处理的微博字符串]
 * @return [String]          [处理完成后的字符串]
 */
function replace_weibo ($content) {
	if (empty($content)) return;

	//给URL地址加上 <a> 链接
	$preg = '/(?:http:\/\/)?([\w.]+[\w\/]*\.[\w.]+[\w\/]*\??[\w=\&\+\%]*)/is';
	$content = preg_replace($preg, '<a href="http://\\1" target="_blank">\\1</a>', $content);
	
	//给@用户加是 <a> 链接
	$preg = '/@(\S+)\s/is';
	$content = preg_replace($preg, '<a href="' . __APP__ . '/User/\\1">@\\1</a>', $content);
	
	//提取微博内容中所有表情文件
	$preg = '/\[(\S+?)\]/is';
	preg_match_all($preg, $content, $arr);
	//载入表情包数组文件
	$phiz = include './Public/Data/phiz.php';
	if (!empty($arr[1])) {
		foreach ($arr[1] as $k => $v) {
			$name = array_search($v, $phiz);
			if ($name) {
				$content = str_replace($arr[0][$k], '<img src="' . __ROOT__ . '/PUBLIC/Images/phiz/' . $name . '.gif" title="' . $v . '"/>', $content);
			}
		}
	}
	return str_replace(C('FILTER'), '***', $content);
}

/**
 * 往内存写入推送消息
 * @param [int] $uid  [用户ID号]
 * @param [int] $type [1：评论；2：私信；3：@用户]
 * @param [boolean] $flush  [是否清0]
 */
function set_msg ($uid, $type, $flush=false) {
	$name = '';
	switch ($type) {
		case 1 :
			$name = 'comment';
			break;

		case 2 : 
			$name = 'letter';
			break;

		case 3 : 
			$name = 'atme';
			break;
	}

	if ($flush) {
		$data = S('usermsg' . $uid);
		$data[$name]['total'] = 0;
		$data[$name]['status'] = 0;
		S('usermsg' . $uid, $data, 0);
		return;
	}

	//内存数据已存时让相应数据+1
	if (S('usermsg' . $uid)) {
		$data = S('usermsg' . $uid);
		$data[$name]['total']++;
		$data[$name]['status'] = 1;
		S('usermsg' . $uid, $data, 0);

	//内存数据不存在时，初始化用户数据并写入到内存
	} else {
		$data = array(
			'comment' => array('total' => 0, 'status' => 0),
			'letter' => array('total' =>0, 'status' => 0),
			'atme' => array('total' => 0, 'status' => 0),
			);
		$data[$name]['total']++;
		$data[$name]['status'] = 1;
		S('usermsg' . $uid, $data, 0);
	}
}
?>