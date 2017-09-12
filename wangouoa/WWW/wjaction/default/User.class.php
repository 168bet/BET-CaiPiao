<?php

@session_start();
class User extends WebBase{
	public $title='FUN娱乐平台';
	private $vcodeSessionName='ssc_vcode_session_name';

	/**
	 * 用户登录页面
	 */
	public final function login(){
		$this->display('user/login.php');
	}

	/**
	 * 用户登录页面2
	 */
	public final function loginto(){
		$this->display('user/loginto.php');
	}

	/**
	 * 用户登出操作
	 */
	public final function logout(){
		$_SESSION=array();
		if($this->user['uid']){
			$this->update("update {$this->prename}member_session set isOnLine=0 where uid={$this->user['uid']}");
		}
		header('location: /index.php/user/login');
	}

	public final function bulletin(){
		$this->display('user/bulletin.php');
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
		}elseif(preg_match('/OmniWeb\/(v*)([^\s|;]+)/i',$flag, $match)){
			//OmniWeb
			$para['browser']=$match[2];
		}elseif(preg_match('/Netscape([\d]*)\/([^\s]+)/i',$flag, $match)){
			//Netscape
			$para['browser']=$match[2];
		}elseif(preg_match('/Lynx\/([^\s]+)/i',$flag, $match)){
			//Lynx
			$para['browser']=$match[1];
		}elseif(preg_match('/360SE/i',$flag, $match)){
			//360SE
			$para['browser']='360安全浏览器';
		}elseif(preg_match('/SE 2.x/i',$flag, $match)) {
			//搜狗
			$para['browser']='搜狗浏览器';
		}else{
			$para['browser']='unkown';
		}
		//print_r($para);exit;
		return $para;
	}

	/**
	 * 用户登录检查
	 */
	public final function logined(){
		$username=wjStrFilter($_POST['username']);
		$vcode=$_POST['vcode'];
        if(!ctype_alnum($username)) throw new Exception('用户名包含非法字符,请重新输入');

		if(!isset($username)){
			throw new Exception('请输入用户名');
		}
		if(!isset($vcode)){
			throw new Exception('请输入验证码');
		}
		if($vcode!=$_SESSION[$this->vcodeSessionName]){
			throw new Exception('验证码不正确。');
		}
		$sql="select enable,username,care from {$this->prename}members where isDelete=0 and admin=0 and username=? limit 0,1";
		if(!$user=$this->getRow($sql, $username)){
			throw new Exception('用户名不正确');
		}
		if(!$user['enable']){
			throw new Exception('您的帐号被冻结，请联系管理员。');
		}
		   setcookie('username',$user['username']);
		if($user['care']){
		   setcookie('care',$user['care']);
		}else{
		   setcookie('care',"尚未设置，请尽快设置吧。");
		}
	}
	/**
	 * 用户登录检查2
	 */
	public final function loginedto(){

	    $username=wjStrFilter($_POST['username']);
        $password=wjStrFilter($_POST['password']);

		if(!ctype_alnum($username)) throw new Exception('用户名包含非法字符,请重新登陆');

		if(!$username){
			throw new Exception('请输入用户名');
		}
		if(!$password){
			throw new Exception('不允许空密码登录');
		}
		$sql="select * from {$this->prename}members where isDelete=0 and admin=0 and username=? limit 0,1";
		if(!$user=$this->getRow($sql, $username)){
			throw new Exception('用户名或密码不正确');
		}
		if(md5($password)!=$user['password']){
			throw new Exception('密码不正确');
		}
		if(!$user['enable']){
			throw new Exception('您的帐号被冻结，请联系管理员。');
		}
		$session=array(
			'uid'=>$user['uid'],
			'username'=>$user['username'],
			'session_key'=>session_id(),
			'loginTime'=>$this->time,
			'accessTime'=>$this->time,
			'loginIP'=>self::ip(true)
		);
		$session=array_merge($session, $this->getBrowser());
		if($this->insertRow($this->prename.'member_session', $session)){
			$user['sessionId']=$this->lastInsertId();
		}
		$_SESSION[$this->memberSessionName]=serialize($user);
		return $user;
	}

	/**
	 * 验证码产生器
	 */
	public final function vcode($rmt=null){
		$lib_path=$_SERVER['DOCUMENT_ROOT'].'/lib/';
		include_once $lib_path .'classes/CImage.class';
		$width=72;
		$height=24;
		$img=new CImage($width, $height);
		$img->sessionName=$this->vcodeSessionName;
		$img->printimg('png');
	}

	/**
	 * 推广注册
	 */
	public final function r($userxxx){
		if(!$userxxx){
			//throw new Exception('链接错误！');
			$this->display('team/register.php');
		}else{
			include_once $_SERVER['DOCUMENT_ROOT'].'/lib/classes/Xxtea.class';
			$userxxx=str_replace(array('-','*',''), array('+','/','='), $userxxx);
			$userxxx=base64_decode($userxxx);
			$LArry=Xxtea::decrypt($userxxx, $this->urlPasswordKey);
			$LArry=explode(",",$LArry);
			$lid=$LArry[0];
			$uid=$LArry[1];

			if(!$this->getRow("select uid from {$this->prename}members where uid=?",$uid)){
				//throw new Exception('链接失效！');
				$this->display('team/register.php');
			}else{
				$this->display('team/register.php',0,$uid,$lid);
			}
		}
	}
	public final function registered(){
		if(!$_POST)  throw new Exception('提交数据出错，请重新操作');

		//表单过滤
		$lid=intval($_POST['lid']);
		$parentId=intval($_POST['parentId']);
		$user=wjStrFilter($_POST['username']);
		$qq=wjStrFilter($_POST['qq']);
		$vcode=wjStrFilter($_POST['vcode']);
		$password=md5($_POST['password']);

		if($vcode!=$_SESSION[$this->vcodeSessionName]) throw new Exception('验证码不正确。');

		//清空验证码session
	    $_SESSION[$this->vcodeSessionName]="";

		if(!ctype_alnum($user)) throw new Exception('用户名包含非法字符');
		if(!ctype_digit($qq)) throw new Exception('QQ包含非法字符');

		$sql="select * from {$this->prename}links where lid=?";
		$linkData=$this->getRow($sql, $lid);
		if(!$_POST['lid']) $para['lid']=$lid;
		if(!$linkData) throw new Exception('不存在此注册链接。');
		if(!$parentId) throw new Exception('链接错误');
		$zczs=$this->getValue("select Value from {$this->prename}params where name='zczs'");
		$para=array(
			'username'=>$user,
			'type'=>$linkData['type'],
			'source'=>1,
			'password'=>$password,
			'parentId'=>$parentId,
			'parents'=>$this->getValue("select parents from {$this->prename}members where uid=?",$parentId),
			'fanDian'=>$linkData['fanDian'],
			'fanDianBdw'=>$linkData['fanDianBdw'],
			'coin'=>$zczs,
			'qq'=>$qq,
			'regIP'=>$this->ip(true),
			'regTime'=>$this->time
			);
        //$regtime=$this->getrow("select * from {$this->prename}members where regIP=? order by regTime DESC limit 1",ip2long($this->ip(true)));
		//$time=strtotime($this->time)-$this->iff($regtime['regTime'],$regtime['regTime'],strtotime($this->time)-24*3600-300);
		//if($time<24*3600) throw new Exception('同一IP 24小时内只能注册一次');

		if(!$para['nickname']) $para['nickname']='未设昵称';
		if(!$para['name']) $para['name']=$para['username'];
		$this->beginTransaction();
		try{
			$sql="select username from {$this->prename}members where username=?";
			if($this->getValue($sql, $para['username'])) throw new Exception('用户"'.$para['username'].'"已经存在');
			if($this->insertRow($this->prename .'members', $para)){
				$id=$this->lastInsertId();
				$sql="update {$this->prename}members set parents=concat(parents, ',', $id) where `uid`=$id";
				$this->update($sql);
				$this->commit();
				if($zczs!=0){
				return '注册成功，系统赠送您'.$zczs.'元';
				}else{
				return '注册成功';
				}
			}else{
				throw new Exception('注册失败');
			}
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
}
