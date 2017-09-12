<?php
define("Copyright", "作者QQ:12345678908");
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/");
set_time_limit(0);
include_once (ROOT_PATH . "function/global.php");

$ConfigModel = configModel("*");

//if ($_SERVER["SERVER_NAME"] != '127.0.0.3') exit;
		
	$ac = $_REQUEST['ac'];
	$x_qs=$_REQUEST['qs'];
	$x_num=$_REQUEST['num'];
	$type=$_REQUEST['type'];
	if($x_qs!=""&&$x_num!=""){
		$List=array();
		$List['openResult']=explode(",",$x_num);
		$List['openTerm']=$x_qs;
	}
	switch($type){
		case 'ssc' :
		$tbname='g_history2';
		break;
		case 'pk' :
		$tbname='g_history6';
		break;
		case 'klsf' :
		$tbname='g_history';
		break;
		case 'k3' :
		$tbname='g_history7';//g_history3
		break;
		case 'k8' :
		$tbname='g_history4';
		break;
		default :
		$tbname='error_table';
		break;
	}
	$db = new DB();
	if (!$db->query("SHOW TABLES LIKE '%{$tbname}%';", 0)){
		exit('table not exists.');
	}
	
	switch ($ac)
	{
		case "read" :     //读取下一期的期数跟秒数,网页版采集不需要用到此功能
			if($type=='ssc'){
				getNumberList_s();
			}elseif($type=='pk'){
				getNumberList_pk();
			}elseif($type=='k3'){
				getNumberList_k3();
			}elseif($type=='k8'){
				getNumberList_k8();
			}else{
				getNumberList();
			}
			break;
		case "set" :    //删除后台开过的期数,显示前台下注的期数,$db->query("UPDATE `g_kaipan2` SET `g_lock` = 2 WHERE `g_qishu` = '{当前期数加1}'  ", 2);$db->query("DELETE FROM `g_kaipan2` WHERE g_qishu <= '{当前期数}'   ", 2);
			if($type=='ssc'){
				setNumberAndPlanning_s();
			}elseif($type=='pk'){
				setNumberAndPlanning_pk();
			}elseif($type=='k3'){
				setNumberAndPlanning_k3();
			}elseif($type=='k8'){
				setNumberAndPlanning_k8();
			}else{
				setNumberAndPlanning();
			}
			break;
		case "open" : //软件采集自动开奖
			if($type=='ssc'){
				//if($ConfigModel['g_automatic_open_result_lock2']==1){
					echo "ok";
					setBall_s($List, $x_qs);
				//}
			}elseif($type=='pk'){
				//if($ConfigModel['g_automatic_open_result_lock6']==1){
					setBall_pk($List, $x_qs);
				//}
			}elseif($type=='k3'){
				//if($ConfigModel['g_automatic_open_result_lock3']==1){
					setBall_k3($List, $x_qs);
				//}
			}elseif($type=='k8'){
				if($ConfigModel['g_automatic_open_result_lock4']==1){
					setBall_k8($List, $x_qs);
				}
			}else{
				//if($ConfigModel['g_automatic_open_result_lock']==1){
					setBall($List, $x_qs);
				//}
			}
			break;
		case "auto" : //手动开奖
			if($type=='ssc'){
				autokj_ssc($List, $x_qs);
			}elseif($type=='pk'){
				autokj_pk($List, $x_qs);
			}elseif($type=='k3'){
				autokj_k3($List, $x_qs);
			}elseif($type=='k8'){
				autokj_k8($List, $x_qs);
			}else{
				autokj($List, $x_qs);
			}
			break;
	}


//////////////////////////auto/////////////////////////////
function autokj($List, $_number)
{
	//已獲取到號碼
	$date = date('Y-m-d H:i');
	$db = new DB();
	if (!$db->query("SELECT `g_id` FROM `g_history` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 1 and `g_ball_1` is  null LIMIT 1", 0)){
		$db->query("INSERT INTO `g_history` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$_number}', '{$date}', 1) ", 2);
	}
	$list = $List['openResult'];
	$set = "`g_ball_1` = '{$list[0]}', `g_ball_2` = '{$list[1]}', `g_ball_3` = '{$list[2]}', `g_ball_4` = '{$list[3]}', `g_ball_5` = '{$list[4]}', `g_ball_6` = '{$list[5]}', `g_ball_7` = '{$list[6]}', `g_ball_8` = '{$list[7]}' ";
	$db->query("UPDATE `g_history` SET {$set} WHERE g_qishu = '{$_number}' LIMIT 1 ", 2);
	
	global $ConfigModel;
	//結算
	if ($ConfigModel['g_automatic_money_lock'] == 1)
	{
		//結算
		$Amount = new SumAmount($_number);
		$Amount->ResultAmount();
	}
	exit("success");
}

function autokj_ssc($List, $_number)
{
	//已獲取到號碼
	$date = date('Y-m-d H:i');
	$db = new DB();
	if (!$db->query("SELECT `g_id` FROM `g_history2` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 2 and `g_ball_1` is  null LIMIT 1", 0)){
		$db->query("INSERT INTO `g_history2` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$_number}', '{$date}', 2) ", 2);
	}
	$list = $List['openResult'];
	$set = "`g_ball_1` = '{$list[0]}', `g_ball_2` = '{$list[1]}', `g_ball_3` = '{$list[2]}', `g_ball_4` = '{$list[3]}', `g_ball_5` = '{$list[4]}' ";
	$db->query("UPDATE `g_history2` SET {$set} WHERE g_qishu = '{$_number}' LIMIT 1 ", 2);
	
	global $ConfigModel;
	if ($ConfigModel['g_automatic_money_lock'] == 1)
	{
		//結算
		$Amount = new SumAmountcq($number);
		$Amount->ResultAmount();
	}
	exit("success");
}

function autokj_pk($List, $_number)
{
	//已獲取到號碼
	$date = date('Y-m-d H:i');
	$db = new DB();
	if (!$db->query("SELECT `g_id` FROM `g_history6` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 6 and `g_ball_1` is  null LIMIT 1", 0)){
		$db->query("INSERT INTO `g_history6` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$_number}', '{$date}', 6) ", 2);
	}
	$list = $List['openResult'];
	$set = " `g_ball_1` = '{$list[0]}', `g_ball_2` = '{$list[1]}', `g_ball_3` = '{$list[2]}', `g_ball_4` = '{$list[3]}', `g_ball_5` = '{$list[4]}', `g_ball_6` = '{$list[5]}', `g_ball_7` = '{$list[6]}', `g_ball_8` = '{$list[7]}', `g_ball_9` = '{$list[8]}', `g_ball_10` = '{$list[9]}'  ";
	$db->query("UPDATE `g_history6` SET {$set} WHERE g_qishu = '{$_number}' LIMIT 1 ", 2);
	
	global $ConfigModel;
	if ($ConfigModel['g_automatic_money_lock'] == 1)
	{
		//結算
		$Amount = new SumAmountpk($number);
		$Amount->ResultAmount();
	
	}
	exit("success");
}

function autokj_k3($List, $_number)
{
	//已獲取到號碼
	$date = date('Y-m-d H:i');
	$db = new DB();
	if (!$db->query("SELECT `g_id` FROM `g_history7` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 9 and `g_ball_1` is  null LIMIT 1", 0)){
		$db->query("INSERT INTO `g_history7` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$_number}', '{$date}', 9) ", 2);
	}
	$list = $List['openResult'];
	$set = "`g_ball_1` = '{$list[0]}', `g_ball_2` = '{$list[1]}', `g_ball_3` = '{$list[2]}' ";
	$db->query("UPDATE `g_history7` SET {$set} WHERE g_qishu = '{$_number}' LIMIT 1 ", 2);
	
	global $ConfigModel;
	//結算
	if ($ConfigModel['g_automatic_money_lock'] == 1)
	{
		//結算
		$Amountk3 = new SumAmountgx($number);
		$Amountk3->ResultAmount();
	}
	exit("success");
}
function autokj_k8($List, $_number)
{
	//已獲取到號碼
	$date = date('Y-m-d H:i');
	$db = new DB();
	if (!$db->query("SELECT `g_id` FROM `g_history4` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 4 and `g_ball_1` is  null LIMIT 1", 0)){
		$db->query("INSERT INTO `g_history4` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$_number}', '{$date}', 4) ", 2);
	}
	$list = $List['openResult'];
	$set = "`g_ball_1` = '{$list[0]}', `g_ball_2` = '{$list[1]}', `g_ball_3` = '{$list[2]}', `g_ball_4` = '{$list[3]}', `g_ball_5` = '{$list[4]}', `g_ball_6` = '{$list[5]}', `g_ball_7` = '{$list[6]}', `g_ball_8` = '{$list[7]}', `g_ball_9` = '{$list[8]}', `g_ball_10` = '{$list[9]}', `g_ball_11` = '{$list[10]}', `g_ball_12` = '{$list[11]}', `g_ball_13` = '{$list[12]}', `g_ball_14` = '{$list[13]}', `g_ball_15` = '{$list[14]}', `g_ball_16` = '{$list[15]}', `g_ball_17` = '{$list[16]}', `g_ball_18` = '{$list[17]}', `g_ball_19` = '{$list[18]}', `g_ball_20` = '{$list[19]}' ";
	$db->query("UPDATE `g_history4` SET {$set} WHERE g_qishu = '{$_number}' LIMIT 1 ", 2);
	
	global $ConfigModel;
	//結算
	if ($ConfigModel['g_automatic_money_lock'] == 1)
	{
		//結算
		$Amountk8 = new SumAmountkb($number);
		$Amountk8->ResultAmount();
	}
	exit("success");
}
/**
 * 讀取未開獎、已開盤的期數
 * Enter description here ...
 */
function getNumberList ()
{
	global $ConfigModel;
	//if ($ConfigModel['g_automatic_open_number_lock']==1)
	//{
		$db = new DB();
		$number = null;
		$endTime =null;
	if($_REQUEST['qs']!=""){
			$result = $db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan` WHERE  g_qishu='".$_REQUEST['qs']."'  LIMIT 1", 1);
			if ($result)
			{
				$number = $result[0]['g_qishu'];
				$endTime = strtotime($result[0]['g_open_date']) - time();
			}else{
				$number = $_REQUEST['qs'];
				$endTime = 0;
				$db->query("UPDATE `g_kaipan` SET `g_lock` = 2 WHERE g_open_date>=now() order by g_qishu LIMIT 1 ", 2);
			}
	}else{
			$db->query("delete from `g_kaipan` WHERE g_open_date<now() ", 2);
		$result = $db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan` WHERE `g_lock` = 2 and g_open_date>=now() ORDER BY g_qishu LIMIT 1", 1);
		if ($result)
		{
			$number = $result[0]['g_qishu'];
			$endTime = strtotime($result[0]['g_open_date']) - time();
		}
		else
		{
		
				$db->query("UPDATE `g_kaipan` SET `g_lock` = 2 WHERE g_open_date>=now() order by g_qishu LIMIT 1 ", 2);
			
			
			if(!$db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan` WHERE `g_lock` = 2 and g_open_date>=now() ORDER BY g_qishu LIMIT 1", 1)){
				$insertday=time()<strtotime(date("Y-m-d 22:30:00"))?0:1;
				insertnumber($insertday, $ConfigModel["g_close_time"]);
				//InsertNumber ();
				getNumberList ();
			}else{
				getNumberList ();
			}
		}
	}
	//}
	echo trim($number)."|".$endTime;
	exit;
}

function getNumberList_s ()
{
	global $ConfigModel;
	//	if ($ConfigModel['g_automatic_open_number_lock']==1)	{//自动开盘
		$db = new DB();
		$number = null;
		$endTime =null;
	if($_REQUEST['qs']!=""){
			$result = $db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan2` WHERE  g_qishu='".$_REQUEST['qs']."'  LIMIT 1", 1);
			if ($result)
			{
				$number = $result[0]['g_qishu'];
				$endTime = strtotime($result[0]['g_open_date']) - time();
			
			}else{
				$number = $_REQUEST['qs'];
				$endTime = 0;
				$db->query("UPDATE `g_kaipan2` SET `g_lock` = 2 WHERE g_open_date>=now() order by g_qishu LIMIT 1 ", 2);
			}//result
	}else{//qs-else
			$db->query("delete from `g_kaipan2` WHERE g_open_date<now() ", 2);
		$result = $db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan2` WHERE `g_lock` = 2 and g_open_date>=now() ORDER BY g_qishu LIMIT 1", 1);
		if ($result)
		{
			$number = $result[0]['g_qishu'];
			$endTime = strtotime($result[0]['g_open_date']) - time();
		}
		else
		{
				$db->query("UPDATE `g_kaipan2` SET `g_lock` = 2 WHERE g_open_date>=now() order by g_qishu LIMIT 1 ", 2);
			
			
			if(!$db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan2` WHERE `g_lock` = 2 and g_open_date>=now() ORDER BY g_qishu LIMIT 1", 1)){
			
				InsertNumbers('09:50:00', 0, 10, 24, 143, $ConfigModel['g_close_time']);//写新期数
				getNumberList_s ();
			}else{
				getNumberList_s ();
			}//if last qi  //不断反检查
		}//else
	}//qs-else

	echo trim($number)."|".$endTime;
	exit;
}
function getNumberList_pk ()
{
	global $ConfigModel;
	//if ($ConfigModel['g_automatic_open_number_lock']==1)	{//自动开盘

		$db = new DB();
		$number = null;
		$endTime =null;
	if($_REQUEST['qs']!=""){
			$result = $db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan6` WHERE  g_qishu='".$_REQUEST['qs']."'  LIMIT 1", 1);
			if ($result)
			{
				$number = $result[0]['g_qishu'];
				$endTime = strtotime($result[0]['g_open_date']) - time();
			
			}else{
				$number = $_REQUEST['qs'];
				$endTime = 0;//g_open_date>=now()
				$number=$_REQUEST['qs']+1;
			    $nums=$number-1;
				$db->query("UPDATE `g_kaipan6` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}' ", 2);
				$db->query("DELETE FROM `g_kaipan6` WHERE g_qishu <= '{$nums}'  ", 2);
		}
		echo $number."2success北京赛车開啟下一期期數/刪除開獎時間已經結束的期數".$nums;
	}else{
			$db->query("delete from `g_kaipan6` WHERE g_open_date<now() ", 2);
		$result = $db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan6` WHERE `g_lock` = 2 and g_open_date>=now() ORDER BY g_qishu LIMIT 1", 1);
		if ($result)
		{
			$number = $result[0]['g_qishu'];
			$endTime = strtotime($result[0]['g_open_date']) - time();
		}
		else
		{
				$db->query("UPDATE `g_kaipan6` SET `g_lock` = 2 WHERE g_open_date>=now() order by g_qishu LIMIT 1 ", 2);
			
			
			if(!$db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan6` WHERE `g_lock` = 2 and g_open_date>=now() ORDER BY g_qishu LIMIT 1", 1)){
				$insertday=time()<strtotime(date("Y-m-d 23:57:00"))?0:1;
				$did = 373380;
             	if ("2014-02-07" <= date("Y-m-d")) {
	        	$day = (((strtotime(date("Y-m-d")) - strtotime("2013-07-20")) / 3600 / 24) + 1) - 8;
               	}
             	else if ("2014-01-30" <= date("Y-m-d")) {
         		$day = ((strtotime("2014-01-30") - strtotime("2013-07-20")) / 3600 / 24) + 1;
               	}
             	else {
           		$day = ((strtotime(date("Y-m-d")) - strtotime("2013-07-20")) / 3600 / 24) + 1;
               	}

	            $numberpk = $did + (179 * $day);
	            insertnumberpk($numberpk, $insertday);
				getNumberList_pk ();
			}else{
				getNumberList_pk ();
			}
		}
	}
	//自动开盘}
	echo trim($number)."|".$endTime;
	exit;
}

function getNumberList_k3 ()
{
	global $ConfigModel;
	//if ($ConfigModel['g_automatic_open_number_lock']==1)//
	//{
		$db = new DB();
		$number = null;
		$endTime =null;
	if($_REQUEST['qs']!=""){
			$result = $db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan7` WHERE  g_qishu='".$_REQUEST['qs']."'  LIMIT 1", 1);
			if ($result)
			{
				$number = $result[0]['g_qishu'];
				$endTime = strtotime($result[0]['g_open_date']) - time();
			}else{
				$number = $_REQUEST['qs'];
				$endTime = 0;
				$db->query("UPDATE `g_kaipan7` SET `g_lock` = 2 WHERE g_open_date>=now() order by g_qishu LIMIT 1 ", 2);
			}
	}else{
			$db->query("delete from `g_kaipan7` WHERE g_open_date<now() ", 2);
		$result = $db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan7` WHERE `g_lock` = 2 and g_open_date>=now() ORDER BY g_qishu LIMIT 1", 1);
		if ($result)
		{
			$number = $result[0]['g_qishu'];
			$endTime = strtotime($result[0]['g_open_date']) - time();
		}
		else
		{
		
				$db->query("UPDATE `g_kaipan7` SET `g_lock` = 2 WHERE g_open_date>=now() order by g_qishu LIMIT 1 ", 2);
			
			
			if(!$db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan7` WHERE `g_lock` = 2 and g_open_date>=now() ORDER BY g_qishu LIMIT 1", 1)){
				$insertday=time()<strtotime(date("Y-m-d 22:10:00"))?0:1;
				insertnumbergx("08:30", $insertday, 10, 1, 82, $ConfigModel["g_close_time"]);
				getNumberList_k3();
			}else{
				getNumberList_k3 ();
			}
		}
	}
	//}
	echo trim($number)."|".$endTime;
	exit;
}

function getNumberList_k8 ()
{
	global $ConfigModel;
	//if ($ConfigModel['g_automatic_open_number_lock']==1)
	//{
		$db = new DB();
		$number = null;
		$endTime =null;
	if($_REQUEST['qs']!=""){
			$result = $db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan4` WHERE  g_qishu='".$_REQUEST['qs']."'  LIMIT 1", 1);
			if ($result)
			{
				$number = $result[0]['g_qishu'];
				$endTime = strtotime($result[0]['g_open_date']) - time();
			}else{
				$number = $_REQUEST['qs'];
				$endTime = 0;
				$db->query("UPDATE `g_kaipan4` SET `g_lock` = 2 WHERE g_open_date>=now() order by g_open_date LIMIT 1 ", 2);
			}
	}else{
			$db->query("delete from `g_kaipan4` WHERE g_open_date<now() ", 2);
		$result = $db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan4` WHERE `g_lock` = 2 and g_open_date>=now() ORDER BY g_open_date LIMIT 1", 1);
		if ($result)
		{
			$number = $result[0]['g_qishu'];
			$endTime = strtotime($result[0]['g_open_date']) - time();
		}
		else
		{
		
				$db->query("UPDATE `g_kaipan4` SET `g_lock` = 2 WHERE g_open_date>=now() order by g_open_date LIMIT 1 ", 2);
			
			
			if(!$db->query("SELECT `g_qishu`,  `g_open_date` FROM `g_kaipan4` WHERE `g_lock` = 2 and g_open_date>=now() ORDER BY g_open_date LIMIT 1", 1)){
				$insertday=time()<strtotime(date("Y-m-d 23:55:00"))?0:1;
				$did = 612998;
		
			if ("2014-02-07" <= date("Y-m-d")) {
				$day = (((strtotime(date("Y-m-d")) - strtotime("2014-01-27")) / 3600 / 24) + $insertday) - 8;
			}
			else if ("2014-01-30" <= date("Y-m-d")) {
				$day = ((strtotime("2014-01-30") - strtotime("2014-01-27")) / 3600 / 24) + $insertday;
			}
			else {
				$day = ((strtotime(date("Y-m-d")) - strtotime("2014-01-27")) / 3600 / 24) + $insertday;
			}

			$number = $did + (179 * $day);
			insertnumberkb($number, $insertday);
			
				if(time()>strtotime(date("Y-m-d 23:55:00"))){//add
			$url = "http://www.bclc.com/services/keno/default.asmx/getNextDraw";
			$str2 = file_get_contents($url);
			$str2 = str_replace("<draw>", "^", $str2);
			$str2 = str_replace("</draw>", "^", $str2);
			$str2_arr = explode("^", $str2);
			$did = trim($str2_arr[1]);

			if (date("H") == "23") {
				$feng = $did + 2;
				$day = 1;
			}
			else {
				$feng = $did - floor(((date("H") * 60) + date("i")) / 4);
				$day = 0;
			}
					  
				setk8_add($feng, $day);
				}
				getNumberList_k8();
			}else{
				getNumberList_k8 ();
			}
		}
	}
	//}
	echo trim($number)."|".$endTime;
	exit;
}
/**
 * 設置下一期開獎信息
 */
function setNumberAndPlanning ()
{
	$db = new DB();
	$result = $db->query("SELECT `g_qishu` FROM `g_kaipan` WHERE `g_lock` = 2 ORDER BY g_qishu DESC LIMIT 1 ", 1);
	
	if ($result)
	{
		$date = date('Y-m-d H:i');
		$nums = $result[0]['g_qishu'];
		$lastNum = mb_substr($nums, -2);
		//將開獎時間已經結束的期數添加到歷史記錄
		if (!$db->query("SELECT `g_id` FROM `g_history` WHERE `g_qishu` = '{$nums}' AND `g_game_id` = 1 LIMIT 1", 0))
			//$db->query("INSERT INTO `g_history` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$nums}', '{$date}', 1) ", 2);//5如果找不到下注期数，那么把下注期数的期数跟开奖时间写入到history表里！这句就会导致出错，注释之！
		
		if ($lastNum < 84)
		{
			/**
			 * 開啟下一期期數
			 * 刪除開獎時間已經結束的期數
			 */
			/* $number = $nums+1;
			if ($db->query("UPDATE `g_kaipan` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}'  ", 2))
				$db->query("DELETE FROM `g_kaipan` WHERE g_qishu = '{$nums}' AND `g_lock` = 2  ", 2);
		}
		exit("success123"); */
		$number=$_REQUEST['qs']+1;
			$nums=$number-1;
				$db->query("UPDATE `g_kaipan` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}'  ", 2);
				$db->query("DELETE FROM `g_kaipan` WHERE g_qishu <= '{$nums}'   ", 2);
		}
		$number=$_REQUEST['qs']+1;
			$nums=$number-1;
				$db->query("UPDATE `g_kaipan` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}'  ", 2);
				$db->query("DELETE FROM `g_kaipan` WHERE g_qishu <= '{$nums}'   ", 2);
		exit($number."success广东快乐十分開啟下一期期數/刪除開獎時間已經結束的期數".$nums);
	}
}

function setNumberAndPlanning_s ()
{
	$db = new DB();
	$result = $db->query("SELECT `g_qishu` FROM `g_kaipan2` WHERE `g_lock` = 2 ORDER BY g_qishu DESC LIMIT 1 ", 1);
	
	if ($result)
	{
		$date = date('Y-m-d H:i');
		$nums = $result[0]['g_qishu'];
		$lastNum = mb_substr($nums, -2);
		//將開獎時間已經結束的期數添加到歷史記錄
		if (!$db->query("SELECT `g_id` FROM `g_history2` WHERE `g_qishu` = '{$nums}' AND `g_game_id` = 2 LIMIT 1", 0))
			//$db->query("INSERT INTO `g_history2` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$nums}', '{$date}', 2) ", 2);////1如果找不到下注期数，那么把下注期数的期数跟开奖时间写入到history表里！这句就会导致出错，注释之！
		
		if ($lastNum != 23)
		{
			/**
			 * 開啟下一期期數
			 * 刪除開獎時間已經結束的期數
			 */
			$number = mb_substr($nums, -3) == 120 ? date( "Ymd", mktime(0, 0, 0, date('m'), date('d'), date('Y'))).'001' : $nums+1;
			$number=$_REQUEST['qs']+1;
			$nums=$number-1;
				$db->query("UPDATE `g_kaipan2` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}'  ", 2);
				$db->query("DELETE FROM `g_kaipan2` WHERE g_qishu <= '{$nums}'   ", 2);
		}
		$number=$_REQUEST['qs']+1;
			$nums=$number-1;
				$db->query("UPDATE `g_kaipan2` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}'  ", 2);
				$db->query("DELETE FROM `g_kaipan2` WHERE g_qishu <= '{$nums}'   ", 2);
		exit($number."success重庆时时彩開啟下一期期數/刪除開獎時間已經結束的期數".$nums);
	}
}

function setNumberAndPlanning_pk ()
{
	$db = new DB();
	$result = $db->query("SELECT `g_qishu`,`g_open_date` FROM `g_kaipan6` WHERE `g_lock` = 2 ORDER BY g_qishu DESC LIMIT 1 ", 1);
	
	if ($result)
	{
		$date = date('Y-m-d H:i');
		$nums = $result[0]['g_qishu'];
		//將開獎時間已經結束的期數添加到歷史記錄
		if (!$db->query("SELECT `g_id` FROM `g_history6` WHERE `g_qishu` = '{$nums}' AND `g_game_id` = 6 LIMIT 1", 0))
			//$db->query("INSERT INTO `g_history6` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$nums}', '{$date}', 6) ", 2);//2如果找不到下注期数，那么把下注期数的期数跟开奖时间写入到history表里！这句就会导致出错，注释之！
		
		if (mb_substr($result[0]['g_open_date'],-8) != '23:58:00')
		{
			/**
			 * 開啟下一期期數
			 * 刪除開獎時間已經結束的期數
			 */
				$number=$nums+1;
				$number=$_REQUEST['qs']+1;
			    $nums=$number-1;
				$db->query("UPDATE `g_kaipan6` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}' ", 2);
				$db->query("DELETE FROM `g_kaipan6` WHERE g_qishu <= '{$nums}'  ", 2);
		}
		//$number=$nums+1;
				$number=$_REQUEST['qs']+1;
			    $nums=$number-1;
				$db->query("UPDATE `g_kaipan6` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}' ", 2);
				$db->query("DELETE FROM `g_kaipan6` WHERE g_qishu <= '{$nums}'  ", 2);
		exit($number."success北京赛车開啟下一期期數/刪除開獎時間已經結束的期數".$nums);
	}
}

function setNumberAndPlanning_k3 ()
{
	$db = new DB();
	$result = $db->query("SELECT `g_qishu`,`g_open_date` FROM `g_kaipan7` WHERE `g_lock` = 2 ORDER BY g_qishu DESC LIMIT 1 ", 1);
	
	if ($result)
	{
		$date = date('Y-m-d H:i');
		$nums = $result[0]['g_qishu'];
		$lastNum = mb_substr($nums, -2);
		//將開獎時間已經結束的期數添加到歷史記錄
		if (!$db->query("SELECT `g_id` FROM `g_history7` WHERE `g_qishu` = '{$nums}' AND `g_game_id` = 9 LIMIT 1", 0))
			//$db->query("INSERT INTO `g_history7` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$nums}', '{$date}', 9) ", 2);//3如果找不到下注期数，那么把下注期数的期数跟开奖时间写入到history表里！这句就会导致出错，注释之！
		if ($lastNum < 82)
		{
			/**
			 * 開啟下一期期數
			 * 刪除開獎時間已經結束的期數
			 */
			/* $number = $nums+1;
			if ($db->query("UPDATE `g_kaipan7` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}'  ", 2))
				$db->query("DELETE FROM `g_kaipan7` WHERE g_qishu = '{$nums}' AND `g_lock` = 2  ", 2);
		}
		exit("success123"); */
		$number=$_REQUEST['qs']+1;
			    $nums=$number-1;
				$db->query("UPDATE `g_kaipan7` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}' ", 2);
				$db->query("DELETE FROM `g_kaipan7` WHERE g_qishu <= '{$nums}'  ", 2);
		}
		$number=$_REQUEST['qs']+1;
			    $nums=$number-1;
				$db->query("UPDATE `g_kaipan7` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}' ", 2);
				$db->query("DELETE FROM `g_kaipan7` WHERE g_qishu <= '{$nums}'  ", 2);
		echo $number."success江苏快三開啟下一期期數/刪除開獎時間已經結束的期數".$nums;
	}
}

function setNumberAndPlanning_k8 ()
{
	$db = new DB();
	$result = $db->query("SELECT `g_qishu`,`g_open_date` FROM `g_kaipan4` WHERE `g_lock` = 2 ORDER BY g_open_date DESC LIMIT 1 ", 1);
	
	if ($result)
	{
		$date = date('Y-m-d H:i');
		$nums = $result[0]['g_qishu'];
		//將開獎時間已經結束的期數添加到歷史記錄
		if (!$db->query("SELECT `g_id` FROM `g_history4` WHERE `g_qishu` = '{$nums}' AND `g_game_id` = 4 LIMIT 1", 0))
			//$db->query("INSERT INTO `g_history4` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$nums}', '{$date}', 4) ", 2);//4如果找不到下注期数，那么把下注期数的期数跟开奖时间写入到history表里！这句就会导致出错，注释之！
		
		if (mb_substr($result[0]['g_open_date'],-8) != '23:55:00')
		{
			/**
			 * 開啟下一期期數
			 * 刪除開獎時間已經結束的期數
			 */
				/* $number=$nums+1;
				$db->query("UPDATE `g_kaipan4` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}' ", 2);
				$db->query("DELETE FROM `g_kaipan4` WHERE g_qishu = '{$nums}' AND `g_lock` = 2  ", 2);
		}
		exit("success"); */
		$number=$_REQUEST['qs']+1;
			    $nums=$number-1;
				$db->query("UPDATE `g_kaipan4` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}' ", 2);
				$db->query("DELETE FROM `g_kaipan4` WHERE g_qishu <= '{$nums}'  ", 2);
		}
		$number=$_REQUEST['qs']+1;
			    $nums=$number-1;
				$db->query("UPDATE `g_kaipan4` SET `g_lock` = 2 WHERE `g_qishu` = '{$number}' ", 2);
				$db->query("DELETE FROM `g_kaipan4` WHERE g_qishu <= '{$nums}'  ", 2);
		echo $number."success北京快乐八開啟下一期期數/刪除開獎時間已經結束的期數".$nums;
	}
}

function setBall($List, $_number)
{
	//已獲取到號碼
	$db = new DB();
	$date = date('Y-m-d H:i');
	if (!$db->query("SELECT `g_id` FROM `g_history` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 1 LIMIT 1", 0)){
		$db->query("INSERT INTO `g_history` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$_number}', '{$date}', 1) ", 2);
	}
	if ($db->query("SELECT `g_id` FROM `g_history` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 1 and `g_ball_1` is  null LIMIT 1", 0)){
	$list = $List['openResult'];
	$set = "`g_ball_1` = '{$list[0]}', `g_ball_2` = '{$list[1]}', `g_ball_3` = '{$list[2]}', `g_ball_4` = '{$list[3]}', `g_ball_5` = '{$list[4]}', `g_ball_6` = '{$list[5]}', `g_ball_7` = '{$list[6]}', `g_ball_8` = '{$list[7]}' ";
	$db->query("UPDATE `g_history` SET {$set} WHERE g_qishu = '{$_number}' LIMIT 1 ", 2);

	//還原賠率
	initializeOdds();
	
	//降賠率
	global $ConfigModel;
/*	if ($ConfigModel['g_odds_execution_lock'] == 1 && mb_substr($_number, -2) < 84&&$ConfigModel['g_up_odds_mix']>0)
	{
		$AutomaticOdds = new AutomaticOdds($ConfigModel['g_up_odds_mix'], $ConfigModel['g_odds_num'], $ConfigModel['g_odds_str']);
		$AutomaticOdds->UpExecution();
	}*/
	if (($ConfigModel["g_odds_execution_lock"] == 1) && (mb_substr($_number, -2) < 84)) {
		$AutomaticOdds = new AutomaticOdds($ConfigModel["g_up_odds_mix"], $ConfigModel["g_odds_num"], $ConfigModel["g_odds_str"]);
		$AutomaticOdds->UpExecution();
	}

	//結算
	inventory ($_number, $ConfigModel);
	}
	exit("success广东快乐十分当前期数跟号码写入成功");
}

function setBall_s($List, $_number)
{
	//已獲取到號碼
	$db = new DB();
	$date = date('Y-m-d H:i');
	if (!$db->query("SELECT `g_id` FROM `g_history2` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 2  LIMIT 1", 0)){
		$db->query("INSERT INTO `g_history2` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$_number}', '{$date}', 2) ", 2);
	}
	if ($db->query("SELECT `g_id` FROM `g_history2` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 2 and `g_ball_1` is  null LIMIT 1", 0)){
	$list = $List['openResult'];
	$set = "`g_ball_1` = '{$list[0]}', `g_ball_2` = '{$list[1]}', `g_ball_3` = '{$list[2]}', `g_ball_4` = '{$list[3]}', `g_ball_5` = '{$list[4]}' ";
	$db->query("UPDATE `g_history2` SET {$set} WHERE g_qishu = '{$_number}' LIMIT 1 ", 2);
	
	//還原賠率
	initializeOddscq();

	global $ConfigModel;
	//結算
	inventory_s ($_number, $ConfigModel);
	//降賠率
	if (($ConfigModel["g_odds_execution_lock"] == 1) && (mb_substr($_number, -2) != 23)) {
		$AutomaticOddscq = new AutomaticOddscq($ConfigModel["g_up_odds_mix_cq"], $ConfigModel["g_odds_num_cq"], $ConfigModel["g_odds_str_cq"]);
		$AutomaticOddscq->UpExecution();
	}
	}
	exit("success重庆时时彩当前期数跟号码写入成功");
}


function setBall_pk($List, $_number)
{
	//已獲取到號碼
	$db = new DB();
	$date = date('Y-m-d H:i');
	if (!$db->query("SELECT `g_id` FROM `g_history6` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 6  LIMIT 1", 0)){
		$db->query("INSERT INTO `g_history6` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$_number}', '{$date}', 6) ", 2);
	}
	if ($db->query("SELECT `g_id` FROM `g_history6` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 6 and `g_ball_1` is  null LIMIT 1", 0)){
	$list = $List['openResult'];
	$set = "`g_ball_1` = '{$list[0]}', `g_ball_2` = '{$list[1]}', `g_ball_3` = '{$list[2]}', `g_ball_4` = '{$list[3]}', `g_ball_5` = '{$list[4]}', `g_ball_6` = '{$list[5]}', `g_ball_7` = '{$list[6]}', `g_ball_8` = '{$list[7]}', `g_ball_9` = '{$list[8]}', `g_ball_10` = '{$list[9]}' ";
	$db->query("UPDATE `g_history6` SET {$set} WHERE g_qishu = '{$_number}' LIMIT 1 ", 2);
	
	//還原賠率
    initializeoddspk();
	global $ConfigModel;
	//結算
	inventory_pk ($_number, $ConfigModel);
	//降賠率
	$result = $db->query("SELECT `g_open_date` FROM `g_kaipan6` WHERE DATEDIFF(`g_open_date`,CURDATE())=0 LIMIT 1 ", 1);
	if ($ConfigModel['g_odds_execution_lock'] == 1)
	{
		$AutomaticOddspk = new AutomaticOddspk($ConfigModel['g_up_odds_mix_pk'], $ConfigModel['g_odds_num_pk'], $ConfigModel['g_odds_str_pk']);
		$AutomaticOddspk->UpExecution();
	}
	}
	exit("success");
}

function setBall_k3($List, $_number)
{
	//已獲取到號碼
	$db = new DB();
	$date = date('Y-m-d H:i');
	
	if (!$db->query("SELECT `g_id` FROM `g_history7` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 9  LIMIT 1", 0)){
		$db->query("INSERT INTO `g_history7` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$_number}', '{$date}', 9) ", 2);
	}
	if ($db->query("SELECT `g_id` FROM `g_history7` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 9 and `g_ball_1` is  null LIMIT 1", 0)){
	$list = $List['openResult'];
	$set = "`g_ball_1` = '{$list[0]}', `g_ball_2` = '{$list[1]}', `g_ball_3` = '{$list[2]}'";
	$db->query("UPDATE `g_history7` SET {$set} WHERE g_qishu = '{$_number}' LIMIT 1 ", 2);
	
	//還原賠率
	//initializeOddsk3();
	initializeoddsgx();

	global $ConfigModel;
	//結算
	inventory_k3 ($_number, $ConfigModel);
	//降賠率
	$result = $db->query("SELECT `g_open_date` FROM `g_kaipan7` WHERE DATEDIFF(`g_open_date`,CURDATE())=0 LIMIT 1 ", 1);
	/*if ($ConfigModel['g_odds_execution_lock'] == 1 && count($result)>0&&$ConfigModel['g_up_odds_mix_k3']>0)
	{
		$AutomaticOddsk3 = new AutomaticOddsk3($ConfigModel['g_up_odds_mix_k3'], $ConfigModel['g_odds_num_k3'], $ConfigModel['g_odds_str_k3']);
		$AutomaticOddsk3->UpExecution();
	}*/
	}
	exit("success江苏快三当前期数".$_number."跟号码写入成功");
}
function setBall_k8($List, $_number)
{
	//已獲取到號碼
	$db = new DB();
	$date = date('Y-m-d H:i');
	if (!$db->query("SELECT `g_id` FROM `g_history4` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 4  LIMIT 1", 0)){
		$db->query("INSERT INTO `g_history4` (`g_qishu`, `g_date`, `g_game_id`) VALUES ('{$_number}', '{$date}', 4) ", 2);
	}
	if ($db->query("SELECT `g_id` FROM `g_history4` WHERE `g_qishu` = '{$_number}' AND `g_game_id` = 4 and `g_ball_1` is  null LIMIT 1", 0)){
	$list = $List['openResult'];
	$set = "`g_ball_1` = '{$list[0]}', `g_ball_2` = '{$list[1]}', `g_ball_3` = '{$list[2]}', `g_ball_4` = '{$list[3]}', `g_ball_5` = '{$list[4]}', `g_ball_6` = '{$list[5]}', `g_ball_7` = '{$list[6]}', `g_ball_8` = '{$list[7]}', `g_ball_9` = '{$list[8]}', `g_ball_10` = '{$list[9]}', `g_ball_11` = '{$list[10]}', `g_ball_12` = '{$list[11]}', `g_ball_13` = '{$list[12]}', `g_ball_14` = '{$list[13]}', `g_ball_15` = '{$list[14]}', `g_ball_16` = '{$list[15]}', `g_ball_17` = '{$list[16]}', `g_ball_18` = '{$list[17]}', `g_ball_19` = '{$list[18]}', `g_ball_20` = '{$list[19]}' ";
	$db->query("UPDATE `g_history4` SET {$set} WHERE g_qishu = '{$_number}' LIMIT 1 ", 2);
	
	//還原賠率
	//initializeOddsk8();
	initializeoddskb();

	global $ConfigModel;
	//結算
	inventory_k8 ($_number, $ConfigModel);
	//降賠率
	$result = $db->query("SELECT `g_open_date` FROM `g_kaipan4` WHERE DATEDIFF(`g_open_date`,CURDATE())=0 LIMIT 1 ", 1);
	/*if ($ConfigModel['g_odds_execution_lock'] == 1 && count($result)>0&&$ConfigModel['g_up_odds_mix_k8']>0)
	{
		$AutomaticOddsk8 = new AutomaticOddsk8($ConfigModel['g_up_odds_mix_k8'], $ConfigModel['g_odds_num_k8'], $ConfigModel['g_odds_str_k8']);
		$AutomaticOddsk8->UpExecution();
	}*/
	if ($ConfigModel["g_odds_execution_lock"] == 1) {
		$AutomaticOddsk8 = new AutomaticOddskb($ConfigModel["g_up_odds_mix_kb"], $ConfigModel["g_odds_num_kb"], $ConfigModel["g_odds_str_kb"]);
		$AutomaticOddsk8->UpExecution();
	}
	}
	exit("success北京快乐八当前期数".$_number."跟号码写入成功");
}
/**
 * 結算報表
 * @param int 已經開獎的期數
 * Enter description here ...
 */
function inventory ($number, $ConfigModel)
{
	if ($ConfigModel['g_automatic_money_lock'] == 1)
	{
		//結算
		//$Amount = new SumAmount($number);
		//$Amount->ResultAmount();
		$Amount = new SumAmount($number);
		$Amount->ResultAmount();
	}
	
	if (mb_substr($number, -2) == 84)
	{
		//金額還原
		//$Amount->RestoreMoney($ConfigModel['g_restore_money_lock']);
		
		//加載期數
		//InsertNumber($ConfigModel['g_insert_number_day'], $ConfigModel['g_close_time']);
		insertnumber($ConfigModel["g_insert_number_day"], $ConfigModel["g_close_time"]);
		//數據庫備份
		/*$dateTime = date('YmdHis');
		$mysqlDataBak = new MysqlDataBak($BakPassWord, $dateTime);
		$mysqlDataBak->FormatTables();*/
	}
}

function inventory_s ($number, $ConfigModel)
{
	if ($ConfigModel['g_automatic_money_lock'] == 1)
	{
		//結算
		$Amount = new SumAmountcq($number);
		$Amount->ResultAmount();
	
	}
	if (mb_substr($number, -2) == 23)
	{
		insertNumbers('09:50:00', $ConfigModel['g_insert_number_day'], 10, 24, 143, $ConfigModel['g_close_time']);
	}
}
function inventory_pk ($number, $ConfigModel)
{
	if ($ConfigModel['g_automatic_money_lock'] == 1)
	{
		//結算
		$Amount = new SumAmountpk($number);
		$Amount->ResultAmount();

	}
	$db = new DB();
	$result = $db->query("SELECT `g_open_date` FROM `g_kaipan6` WHERE g_open_date>=now() LIMIT 1 ", 1);
	if (!$result)
	{
		$insertday=time()<strtotime(date("Y-m-d 23:57:00"))?0:1;
		$did = 373380;
             	if ("2014-02-07" <= date("Y-m-d")) {
	        	$day = (((strtotime(date("Y-m-d")) - strtotime("2013-07-20")) / 3600 / 24) + 1) - 8;
               	}
             	else if ("2014-01-30" <= date("Y-m-d")) {
         		$day = ((strtotime("2014-01-30") - strtotime("2013-07-20")) / 3600 / 24) + 1;
               	}
             	else {
           		$day = ((strtotime(date("Y-m-d")) - strtotime("2013-07-20")) / 3600 / 24) + 1;
               	}

	            $numberpk = $did + (179 * $day);
	            insertnumberpk($numberpk, $insertday);
	}
}

function inventory_k3 ($number, $ConfigModel)
{
	if ($ConfigModel['g_automatic_money_lock'] == 1)
	{
		//結算
		//$Amountk3 = new SumAmountk3($number);
		//$Amountk3->ResultAmount();
		$Amountk3 = new SumAmountgx($number);
		$Amountk3->ResultAmount();
	}
	
	if (mb_substr($number, -2) == 82)
	{
		//金額還原
		//$Amount->RestoreMoney($ConfigModel['g_restore_money_lock']);
		
		//加載期數
		//InsertNumber_k3($ConfigModel['g_insert_number_day'], $ConfigModel['g_close_time']);
		insertnumbergx("08:30", $ConfigModel['g_insert_number_day'], 10, 1, 82, $ConfigModel["g_close_time"]);
		//數據庫備份
		/*$dateTime = date('YmdHis');
		$mysqlDataBak = new MysqlDataBak($BakPassWord, $dateTime);
		$mysqlDataBak->FormatTables();*/
	}
}

function inventory_k8 ($number, $ConfigModel)
{
	if ($ConfigModel['g_automatic_money_lock'] == 1)
	{
		//結算
		//$Amount = new SumAmountk8($number);
		//$Amount->ResultAmount();
		$Amount = new SumAmountkb($number);
		$Amount->ResultAmount();
	
	}
	if (time()<strtotime(date("Y-m-d 09:00:00"))&&time()>strtotime(date("Y-m-d 06:00:00")))
	{
		//金額還原
		RestoreMoney($ConfigModel['g_restore_money_lock']);
	}
	$db = new DB();
	$result = $db->query("SELECT `g_open_date` FROM `g_kaipan4` WHERE g_open_date>=now() LIMIT 1 ", 1);
	if (!$result)
	{
		$insertday=time()<strtotime(date("Y-m-d 23:55:00"))?0:1;
			$did = 612998;
		
			if ("2014-02-07" <= date("Y-m-d")) {
				$day = (((strtotime(date("Y-m-d")) - strtotime("2014-01-27")) / 3600 / 24) + $insertday) - 8;
			}
			else if ("2014-01-30" <= date("Y-m-d")) {
				$day = ((strtotime("2014-01-30") - strtotime("2014-01-27")) / 3600 / 24) + $insertday;
			}
			else {
				$day = ((strtotime(date("Y-m-d")) - strtotime("2014-01-27")) / 3600 / 24) + $insertday;
			}

			$number = $did + (179 * $day);
			insertnumberkb($number, $insertday);
			
				if(time()>strtotime(date("Y-m-d 23:55:00"))){//add
			$url = "http://www.bclc.com/services/keno/default.asmx/getNextDraw";
			$str2 = file_get_contents($url);
			$str2 = str_replace("<draw>", "^", $str2);
			$str2 = str_replace("</draw>", "^", $str2);
			$str2_arr = explode("^", $str2);
			$did = trim($str2_arr[1]);

			if (date("H") == "23") {
				$feng = $did + 0;
				$day = 1;
			}
			else {
				$feng = $did - floor(((date("H") * 60) + date("i")) / 4);
				$day = 0;
			}
					  
						setk8_add($feng, $day);

					
				}//if
	}
}

function setk8_add($num,$day){
		insertnumberkb2($num, $day);
}
?>