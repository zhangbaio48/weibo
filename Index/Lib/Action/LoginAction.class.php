<?php
/**
 * 注册与登录控制器
 */
Class LoginAction extends Action {

	/**
	 * 登录页面
	 */
	Public function index () {
		$this->display();
	}

	/**
	 * 注册页面
	 */
	Public function register () {
		$this->display();
	}

	/**
	 * 获取验证码
	 */
	Public function verify () {
		import('ORG.Util.Image');
		Image::buildImageVerify(4, 1, 'png');
	}

	/**
	 * 异步验证账号是否已存在
	 */
	Public function checkAccount () {
		if (!$this->isAjax()) {
			halt('页面不存在');
		}
		$account = $this->_post('account');
		$where = array('account' => $account);
		if (M('user')->where($where)->getField('id')) {
			echo 'false';
		} else {
			echo 'true';
		}
	}

	/**
	 * 异步验证昵称是否已存在
	 */
	Public function checkUname () {
		if (!$this->isAjax()) {
			halt('页面不存在');
		}
		$username = $this->_post('uname');
		$where = array('username' => $username);
		if (M('userinfo')->where($where)->getField('id')) {
			echo 'false';
		} else {
			echo 'true';
		}
	}

	/**
	 * 异步验证验证码
	 */
	Public function checkVerify () {
		if (!$this->isAjax()) {
			halt('页面不存在');
		}
		$verify = $this->_post('verify');
		if ($_SESSION['verify'] != md5($verify)) {
			echo 'false';
		} else {
			echo 'true';
		}
	}
}
?>