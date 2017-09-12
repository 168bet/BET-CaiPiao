<?php
/**
 * 前台页面基类
 */
class WebBase extends Object{
	public $controller;
	public $action;
	public $memberSessionName='member-session-name';
	public $user;
	public $headers;
	public $page=1;
	public $title='香雨娱乐';
	public $params=array();	// 系统配置参数
	public $types;			// 彩票种类信息数组
	public $playeds;		// 玩法信息数组
    public $expire=3600;	// 读取玩法、彩票缓存
	public $urlPasswordKey='2u39g867d6yftd3y5d4!@$2#fe';//推广链接加密
	function __construct($dsn, $user='', $password=''){
	session_start();
		try{
			parent::__construct($dsn, $user, $password);
			if($_SESSION[$this->memberSessionName]){
				$this->user=unserialize($_SESSION[$this->memberSessionName]);
				$this->updateSessionTime();
			}
		}catch(Exception $e){
		}
	}
	public function getSystemSettings($expire=null){
		if($expire===null) $expire=$this->expire;
		$file=$this->cacheDir . '/systemSettings';
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

	public function getTypes(){
		if($this->types) return $this->types;
		$sql="select * from {$this->prename}type where isDelete=0 order by sort asc";
		return $this->types=$this->getObject($sql, 'id', null, $this->expire);
	}

	public function getPlayeds(){
		if($this->playeds) return $this->playeds;
		$sql="select * from {$this->prename}played ";
		return $this->playeds=$this->getObject($sql, 'id', null, $this->expire);
	}

	/**
	 * 读取系统配置参数
	 */
	public function getSystemConfig(){
		$file=$this->cacheDir .'FDJSALKFJSIDFJSKLJFFSJDafkljdasa5235465723';
		if(is_file($file) && filemtime($file)+$this->expire>$this->time){
			$this->params=unserialize(file_get_contents($file));
		}else{
			$sql="select name, value from {$this->prename}params";
			if($data=$this->getRows($sql)) foreach($data as $var){
				$this->params[$var['name']]=$var['value'];
			}
			//print_r($data);
			file_put_contents($file, serialize($this->params));
		}
	}

	public function getPl($type=null, $played=null){
		$type=intval($type);
		$played=intval($played);
		if($type==null) $type=$this->type;
		if($played==null) $played=$this->$played;

		$sql="select bonusProp, bonusPropBase from {$this->prename}played where id=?";
		//echo $sql;
		return $this->getRow($sql, $played);
	}

	/**
	 * 读取将要开奖期号
	 *
	 * @params $type		彩种ID
	 * @params $time		时间，如果没有，当默认当前时间
	 * @params $flag		如果为true，则返回最近过去的一期（一般是最近开奖的一期），如果为flase，则是将要开奖的一期
	 */
	public function getGameNo($type, $time=null){
		$type=intval($type);
		if($time===null) $time=$this->time;
		$kjTime=$this->getTypeFtime($type);
		$atime=date('H:i:s', $time+$kjTime);

		$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime>? order by actionTime limit 1";
		$return = $this->getRow($sql, $atime);

		if(!$return){
			$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionTime limit 1";
			$return =$this->getRow($sql, $atime);
			$time=$time+24*3600;
		}

		$types=$this->getTypes();
		if(($fun=$types[$type]['onGetNoed']) && method_exists($this, $fun)){
			$this->$fun($return['actionNo'], $return['actionTime'], $time);
		}

		return $return;
	}

	public function getGameLastNo($type, $time=null){
		$type=intval($type);
		if($time===null) $time=$this->time;
		$kjTime=$this->getTypeFtime($type);
		$atime=date('H:i:s', $time+$kjTime);
		$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime<=? order by actionTime desc limit 1";
		$return = $this->getRow($sql, $atime);
		if(!$return){
			$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionNo desc limit 1";
			$return =$this->getRow($sql, $atime);
			$time=$time-24*3600;
		}
		$types=$this->getTypes();
		if(($fun=$types[$type]['onGetNoed']) && method_exists($this, $fun)){
			$this->$fun($return['actionNo'], $return['actionTime'], $time);
		}
		return $return;
	}

	public function getGamenextNo($type, $time=null){
		$type=intval($type);
		if($time===null) $time=$this->time;
		$kjTime=$this->getTypeFtime($type);
		$atime=date('H:i:s', $time);
		$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime>? order by actionTime limit 1";
		$return = $this->getRow($sql, $atime);
		if(!$return){
			$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionTime limit 1";
			$return =$this->getRow($sql, $atime);
			$time=$time+24*3600;
		}
		$types=$this->getTypes();
		if(($fun=$types[$type]['onGetNoed']) && method_exists($this, $fun)){
			$this->$fun($return['actionNo'], $return['actionTime'], $time);
		}
		return $return;
	}

	public function getGameNos($type, $num=0, $time=null){
		$type=intval($type);
		if($time===null) $time=$this->time;
		$ptime=date('H:i:s', $time);

		$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime>? order by actionTime";
		if($num) $sql.=" limit $num";
		$return = $this->getRows($sql, $ptime);
		$types=$this->getTypes();
		if(($fun=$types[$type]['onGetNoed']) && method_exists($this, $fun)){
			if($return) foreach($return as $i=>$var){
				$this->$fun($return[$i]['actionNo'], $return[$i]['actionTime'], $time);

				$return[$i]['actionTime']=strtotime($return[$i]['actionTime']);
			}
		}

		if(count($return)<$num){
			$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionTime limit " . ($num-count($return));
			$return1=$this->getRows($sql);

			if(($fun=$types[$type]['onGetNoed']) && method_exists($this, $fun)){
				if($return1) foreach($return1 as $i=>$var){
					$this->$fun($return1[$i]['actionNo'], $return1[$i]['actionTime'], $time+24*3600);

					$return1[$i]['actionTime']=strtotime($return1[$i]['actionTime']);
				}
			}
			$return=array_merge($return, $return1);
		}

		return $return;
	}

	private function setTimeNo(&$actionTime, &$time=null){
		$actionTime=wjStrFilter($actionTime);
		if(!$time) $time=$this->time;
		$actionTime=date('Y-m-d ', $time).$actionTime;
	}

	public function noHdCQSSC(&$actionNo, &$actionTime, $time=null){
		$actionNo=wjStrFilter($actionNo);
		$this->setTimeNo($actionTime, $time);
		if($actionNo==0||$actionNo==120){
			//echo 999;
			$actionNo=date('Ymd-120', $time - 24*3600);
			$actionTime=date('Y-m-d 00:00', $time);
			//echo $actionTime;
		}else{
			$actionNo=date('Ymd-', $time).substr(1000+$actionNo,1);
		}
		//var_dump($actionNo);exit;
	}

	public function onHdXjSsc(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		if($actionNo>=84){
			$actionNo=date('Ymd-'.$actionNo, $time - 24*3600);
		}else{
			$actionNo=date('Ymd-', $time).substr(1000+$actionNo,1);
		}
	}

	public function noHd(&$actionNo, &$actionTime, $time=null){
		//echo $actionNo;
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('Ymd-', $time).substr(100+$actionNo,1);
	}

	public function noxHd(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		if($actionNo>84){
			$time-=24*3600;
		}

		$actionNo=date('Ymd-', $time).substr(100+$actionNo,1);
	}

	public function no0Hd(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('Ymd-', $time).substr(1000+$actionNo,1);
	}

	public function no6Hd(&$actionNo,&$actionTime,$time=null){
      $this->setTimeNo($actionTime, $time);
		$actionNo=date('Yz', $time);
		$actionNo=substr($actionNo,0,4).substr(substr($actionNo,4)+1000,1);
		if($actionTime >= date('Y-m-d H:i:s', $time)){
		}else{
			$actionTime=date('Y-m-d 21:40', $time);
		}
    }

	public function no0Hdk3(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('md', $time).substr(100+$actionNo,1);
	}

	public function no0Hdf(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('Ymd-', $time).substr(10000+$actionNo,1);
	}

	public function pai3(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('Yz', $time);
		$actionNo=substr($actionNo,0,4).substr(substr($actionNo,4)+1001,1);
		if($actionTime >= date('Y-m-d H:i:s', $time)){

		}else{
			$actionTime=date('Y-m-d 18:30', $time);
		}
	}

	public function GXklsf(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('Yz', $time).substr(100+$actionNo,1)+100;
		$actionNo=substr($actionNo,0,4).substr(substr($actionNo,4)+100000,1);
	}

	public function BJpk10(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo = 179*(strtotime(date('Y-m-d', $time))-strtotime('2007-11-11'))/3600/24+$actionNo-14;
	}
	public function Kuai8(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo = 179*(strtotime(date('Y-m-d', $time))-strtotime('2004-09-19'))/3600/24+$actionNo-77;
	}
	/**
	 * 读取当前设置的赔率
	 *
	 * @params $type		彩种ID，
	 * @params $playedId	玩法ID
	 */
	public function getBonusProp($type, $playedId){
		$sql="select value from {$this->prename}pl where type=? and playedId=?";
		return $this->getValue($sql, array($type, $playedId));
	}

	public function updateSessionTime(){
		$sql="update ssc_member_session set accessTime={$this->time} where id=?";
		$this->update($sql, $this->user['sessionId']);
	}

	public function checkLogin(){
		if($user=unserialize($_SESSION[$this->memberSessionName])) return $user;
		header('location: /index.php/user/login');
		exit('您没有登录');
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
	//获取延迟时间
	public function getTypeFtime($type){

		if($type){
				$Ftime=$this->getValue("select data_ftime from {$this->prename}type where id = ? ", $type);
			}
			if(!$Ftime) $Ftime=0;
			return intval($Ftime);
	 }
	//获取该玩法最大注数
	public function getmaxcount($playedid){
		if($playedid){
				$maxcount=$this->getValue("select maxcount from {$this->prename}played where id = ? ", $playedid);
			}
			return intval($maxcount);
	 }

	//获取该玩法名
	public function getplayedname($playedid){
		if($playedid){
				$playedname=$this->getValue("select name from {$this->prename}played where id = ? ", $playedid);
			}
			return $playedname;
	 }

	//获取最低消费金额
	public function getmincoin($playedid){
		if($playedid){
				$mincoin=$this->getValue("select minCharge from {$this->prename}played where id = ? ", $playedid);
			}
			return $mincoin;
	 }
	 //////

	 //获取当期时间
	public function getGameActionTime($type,$old=0){
		$actionNo=$this->getGameNo($type);

		if($type==1 && $actionNo['actionTime']=='00:00'){
			$actionTime=strtotime($actionNo['actionTime'])+24*3600;
		}else{
			$actionTime=strtotime($actionNo['actionTime']);
		}
		if(!$actionTime) $actionTime=$old;
		return $actionTime;
	}/////

	//获取当期期数
	public function getGameActionNo($type){
		$actionNo=$this->getGameNo($type);
		return $actionNo['actionNo'];
	}/////

	//随机函数
	public function randomkeys($length)
	{
	 $key = "";
	 $pattern='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	 $pattern1='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	 $pattern2='0123456789';
	 for($i=0;$i<$length;$i++)
	 {
	   $key .= $pattern{mt_rand(0,35)};
	 }

	 return $key;
	}

	//输出单号
	function formatwords($str){

	if($str){
		$len=strlen($str);
		for($i=0;$i<$len;$i++){
			echo "<i>".substr($str, $i, 1)."</i>";

		}
	 }
	}/////


}