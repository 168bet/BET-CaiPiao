<?php
/**
 * 后台管理基类
 */
class AdminBase extends Object{
	private $adminSessionName='admin-session-name';
	private $user;
	public $headers;
	public $page=1;
	public $types;			// 彩票种类信息数组
	public $playeds;		// 玩法信息数组
	private $expire=3600;	// 读取玩法、彩票缓存
	public $settings;
	public $adminLogType=array(
		1=>'提现处理',
		2=>'充值确认',
		3=>'管理员充值',
		4=>'增加用户',
		5=>'修改用户',
		6=>'删除用户',
		7=>'添加管理员',
		8=>'修改管理员密码',
		9=>'删除管理员',
		10=>'修改系统设置',
		11=>'银行设置',
		12=>'彩种设置',
		13=>'玩法设置',
		14=>'等级设置修改',
		15=>'兑换订单处理',
		16=>'兑换商品操作',
		17=>'手动开奖',
		18=>'修改订单',
		19=>'清除管理员',
		20=>'添加支付接口',
	);
	function __construct($dsn, $user='', $password=''){
		session_start();
		if($_SESSION[$this->adminSessionName]){
			$this->user=unserialize($_SESSION[$this->adminSessionName]);
		}else{
			header('location: /admin778899.php/user/login');
			exit('您没有登录');
		}
		if(!$this->user['admin'] || $this->user['sb']!=9){
			header('location: /');
			exit;
		}
		try{
			parent::__construct($dsn, $user, $password);
			$sql="update ssc_member_session set accessTime={$this->time} where id=?";
			$this->update($sql, $this->user['sessionId'], $this->user['sessionId']);
		}catch(Exception $e){
		}
	}

	/**
	 * 管理员日志
	 */
	public function addLog($type,$logString, $extfield0=0, $extfield1=''){
		$log=array(
			'uid'=>$this->user['uid'],
			'username'=>$this->user['username'],
			'type'=>$type,
			'actionTime'=>$this->time,
			'actionIP'=>$this->ip(true),
			'action'=>$logString,
			'extfield0'=>$extfield0,
			'extfield1'=>$extfield1
		);
		return $this->insertRow($this->prename .'admin_log', $log);
	}
	
	public function getTypes(){
		if($this->types) return $this->types;
		$sql="select * from {$this->prename}type where isDelete=0";
		return $this->types=$this->getObject($sql, 'id', null, $this->expire);
	}
	
	public function getPlayeds(){
		if($this->playeds) return $this->playeds;
		$sql="select * from {$this->prename}played";
		return $this->playeds=$this->getObject($sql, 'id', null, $this->expire);
	}
	
	public function getSystemSettings($expire=null){
		if($expire===null) $expire=$this->expire;
		$file=$this->cacheDir . 'systemSettings';
		if($expire && is_file($file) && filemtime($file)+$expire>$this->time){
			return $this->settings=unserialize(file_get_contents($file));
		}
		$sql="select * from {$this->prename}params";
		$this->settings=array();
		if($data=$this->getRows($sql)){
			foreach($data as $var){
				$this->settings[$var['name']]=$var['value'];
			}
		}

		file_put_contents($file, serialize($this->settings));
		return $this->settings;
	}
	
	public function getUser($uid=null){
		if($uid===null) return $this->user;
		if(is_int($uid)) return $this->getRow("select * from {$this->prename}members where uid=$uid");
		if(is_string($uid)) return $this->getRow("select * from {$this->prename}members where username=?", $uid);
	}
	
	public function setUser(){
		throw new Exception('这是一个只读属性');
	}
	
	public function checkLogin(){
		if($user=unserialize($_SESSION[$this->adminSessionName])) return $user;
		header('location: /admin778899.php/user/login');
		exit('您没有登录');
	}
	
	public final function test(){
		$this->display('test.php');
	}
	
	private function setClientMessage($message, $type='Info', $showTime=3000){
		$message=trim(rawurlencode($message), '"');
		header("X-$type-Message: $message");
		header("X-$type-Message-Times: $showTime");
	}
	
	protected function info($message, $showTime=3000){
		$this->setClientMessage($message, 'Info', $showTime);
	}
	protected function success($message, $showTime=3000){
		$this->setClientMessage($message, 'Success', $showTime);
	}
	protected function warning($message, $showTime=3000){
		$this->setClientMessage($message, 'Warning', $showTime);
	}
	public function error($message, $showTime=5000){
		$this->setClientMessage($message, 'Error', $showTime);
		exit;
	}
	
	/**
	 * 用户资金变动
	 *
	 * 请在一个事务里使用
	 */
	public function addCoin($log){

		if(!isset($log['uid'])) $log['info']=$this->user['uid'];
		if(!isset($log['info'])) $log['info']='';
		if(!isset($log['coin'])) $log['coin']=0;
		if(!isset($log['type'])) $log['type']=0;
		if(!isset($log['fcoin'])) $log['fcoin']=0;
		if(!isset($log['extfield0'])) $log['extfield0']=0;
		if(!isset($log['extfield1'])) $log['extfield1']='';
		if(!isset($log['extfield2'])) $log['extfield2']='';

		$sql="call setCoin({$log['coin']}, {$log['fcoin']}, {$log['uid']}, {$log['liqType']}, {$log['type']}, '{$log['info']}', {$log['extfield0']}, '{$log['extfield1']}', '{$log['extfield2']}')";
		$this->insert($sql);

	}
	
	/**
	 * 获得某天的统计信息
	 */
	public function getDateCount($date=null){
		if(!$date) $date=strtotime(date("Y-m-d",$this->time));
		$sql="select count(*) betCount, sum(beiShu*mode*actionNum*(fpEnable+1)) betAmount, sum(bonus) zjAmount from {$this->prename}bets where kjTime between $date and $date+24*3600 and lotteryNo<>'' and isDelete=0";
		$all=$this->getRow($sql);
		$all['fanDianAmount']=$this->getValue("select sum(coin) from {$this->prename}coin_log where liqType between 2 and 3 and actionTime between $date and $date+24*3600");
		$all['brokerageAmount']=$this->getValue("select sum(coin) from {$this->prename}coin_log where liqType in(50,51,52,53) and actionTime between $date and $date+24*3600");

		return $all;
	}
	
}