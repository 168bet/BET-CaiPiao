<?php
class user extends Object{
	private $vcodeSessionName='vcode-session-name';
	
	function __construct($dsn, $user='', $password=''){
		session_start();
		parent::__construct($dsn, $user, $password);
	}
	
	public final function login(){
		header('content-Type: text/html;charset=utf8');
		$this->display('login8421039.php');
	}

	public final function logined(){
		header('content-Type: text/html;charset=utf8');
		$this->display('logined9574512.php');
	}
	
	public final function logout(){
		$_SESSION=array();
		$sessionname=session_name();
		if(isset($_COOKIE[$sessionname])) setcookie($sessionname, '', 0);
		session_destroy();
		header('location: /index.php/user/login');
	}

	private function getBrowser(){
		$flag=$_SERVER['HTTP_USER_AGENT'];
		$para=array();
		
		// 检查操作系统
		if(preg_match('/Windows[\d\. \w]*/',$flag, $match)) $para['os']=$match[0];
		
		if(preg_match('/Chrome\/[\d\.\w]*/',$flag, $match)){
			// 检查Chrome
			$para['browser']=$match[0];
		}elseif(preg_match('/Safari\/[\d\.\w]*/',$flag, $match)){
			// 检查Safari
			$para['browser']=$match[0];
		}elseif(preg_match('/MSIE [\d\.\w]*/',$flag, $match)){
			// IE
			$para['browser']=$match[0];
		}elseif(preg_match('/Opera\/[\d\.\w]*/',$flag, $match)){
			// opera
			$para['browser']=$match[0];
		}elseif(preg_match('/Firefox\/[\d\.\w]*/',$flag, $match)){
			// Firefox
			$para['browser']=$match[0];
		}else{
			$para['browser']='unkown';
		}
		//print_r($para);exit;
		return $para;
	}

	public final function checkLogined(){
		$username=wjStrFilter($_POST['username']);
		$vcode=wjStrFilter($_POST['vcode']);
		
		if(!ctype_alnum($username)) throw new Exception('用户名包含非法字符,请重新输入');
		
		if(!$username){
			throw new Exception('用户名不能为空');
		}

		if(strtolower($vcode)!=$_SESSION[$this->vcodeSessionName]){
			throw new Exception('验证码不正确。');
		}

		//清空验证码session
	    unset($_SESSION[$this->vcodeSessionName]);
		
		$sql="select * from {$this->prename}members where isDelete=0 and admin=1 and sb=9 and username=? LIMIT 0,1";
		if(!$user=$this->getRow($sql, $username)){
			throw new Exception('用户名不正确');
		}

		if($username!=$user['username']){
			throw new Exception('用户名不正确。');
		}
		
		if(!$user['enable']){
			throw new Exception('您的帐号被冻结，请联系管理员。');
		}
		
		if($user['admin']!=1){
			throw new Exception('您不是管理员，不能登录后台。');
		}

		if($user['sb']!=9){
			throw new Exception('您不是管理员，不能登录后台。');
		}

		setcookie('username',$username);
	}
	
	public final function checkLogin(){

		$username=wjStrFilter($_POST['username']);
		$password=wjStrFilter($_POST['password']);
		$safepass=wjStrFilter($_POST['safepass']);
		
		if(!$username){
			throw new Exception('用户名不能为空');
		}

		if(!$password){
			throw new Exception('不允许空密码登录');
		}
		global $conf;
        if($safepass !=$conf['db']['safepass']){
            throw new Exception('安全码不正确');
        }
//		if(md5($safepass)!=md5(665544)){
//			throw new Exception('安全码不正确');
//		}
		if(!ctype_alnum($username)) throw new Exception('用户名包含非法字符,请重新输入');
		
		$sql="select * from {$this->prename}members where isDelete=0 and admin=1 and sb=9 and username=?";
		if(!$user=$this->getRow($sql, $username)){
			throw new Exception('用户名或密码不正确');
		}
		
        if($username!=$user['username']){
			throw new Exception('用户名不正确。');
		}

		if(md5($password)!=$user['password']){
			throw new Exception('用户名或密码不正确');
		}
		
		if(!$user['enable']){
			throw new Exception('您的帐号被冻结，请联系管理员。');
		}
		
		if($user['admin']!=1){
			throw new Exception('您不是管理员，不能登录后台。');
		}

		if($user['sb']!=9){
			throw new Exception('您不是管理员，不能登录后台。');
		}
		
		$session=array(
			'uid'=>$user['uid'],
			'username'=>$user['username'],
			'session_key'=>md5(session_id()+5367412),
			'loginTime'=>$this->time,
			'accessTime'=>$this->time,
			'loginIP'=>self::ip(true),
			
		);
		
		$session=array_merge($session, $this->getBrowser());
		
		if($this->insertRow($this->prename.'member_session', $session)){
			$user['sessionId']=$this->lastInsertId();
		}
		$_SESSION['admin-session-name']=serialize($user);
		
		//header('location:/admin778899.php');
		return $user;
	}
	
	public final function vcode($rmt=null){
		$lib_path=$_SERVER['DOCUMENT_ROOT'].'/lib/';
		include_once $lib_path .'classes/CImage.class';
		$width=72;
		$height=24;
		$img=new CImage($width, $height);
		$img->sessionName=$this->vcodeSessionName;
		$img->printimg('png');
	}
}