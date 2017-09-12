<?php
/*  
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  QQ:503064228
  Author: Version:1.0
  Date:2011-12-12
*/

define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
if ($_SERVER["REQUEST_METHOD"] != "POST") {exit;}
include_once ROOT_PATH.'function/cheCookie.php';
include_once ROOT_PATH.'config/Odds.php';
//include_once ROOT_PATH.'Manage/config/config.php';
global $user;
$tid = $_POST['tid'];

if ($tid == 1)
{
	//最新开奖记录
	$db = new DB();
	$result = $db->query("SELECT `g_qishu`, `g_ball_1`, `g_ball_2`, `g_ball_3` FROM `g_history7` WHERE g_ball_1 is not null ORDER BY g_qishu DESC LIMIT 1 ", 0);
	$number = $result[0][0];
	$ballArr = array();
	for ($i=0; $i<count($result[0]); $i++)
	{
		if ($i != 0)
			$ballArr[] = $result[0][$i];
	}
	$ballArr = json_encode($ballArr);
	
	//当前用户今天输赢
	$winMoney = json_encode(getWin ($user));
	
	//雙面長龍
	global $BallStringpk,$BallString_apk;
	$results = history_resultpk(0);
	$num_arr = sum_ball_count_1_pk ($BallStringpk, $BallString_apk, $results, 2);
	arsort($num_arr);
	$num_arr = json_encode($num_arr);
	$row_1 = sum_str_s_pk ($results, 8, 25, FALSE, FALSE, 6, 0); 	//冠亚和
	$row_2 = sum_str_s_pk ($results, 8, 25, FALSE, FALSE, 2, 0);	//冠亚和大小
	$row_3 = sum_str_s_pk ($results, 8, 25, FALSE, FALSE, 4, 0);	//冠亚和单双

	
	$row_1 = json_encode($row_1);
	$row_2 = json_encode($row_2);
	$row_3 = json_encode($row_3);
	
	echo <<<JSON
			{
				"winMoney" : $winMoney,
				"number" : $number,
				"ballArr" : $ballArr,
				"num_arr" : $num_arr,
				"row_1" : $row_1,
				"row_2" : $row_2,
				"row_3" : $row_3
			}
JSON;
exit;
}
else if ($tid == 2)
{
	//獲取封盤時間、開獎時間、刷新時間
	$db = new DB();
	$result = $db->query("SELECT `g_qishu`, `g_feng_date`, `g_open_date` FROM g_kaipan7 WHERE `g_lock` = 2 LIMIT 1 ", 1);
	if ($result && Copyright)
	{
		$endTime = strtotime($result[0]['g_feng_date']) - time();
		$openTime =  strtotime($result[0]['g_open_date']) - time();
		$Phases = $result[0]['g_qishu'];
		$RefreshTime = 90; //刷新時間
		
		//取出1-8球和總和龍虎雙面賠率
		$db=new DB();
		$sql = "SELECT  h1,h2,h3,h4,h5,h6,h7,h8,h9,h10,h11,h12,h13,h14,h15,`g_type`  FROM `g_odds7` WHERE `g_type` = 'Ball_th_j' OR `g_type` = 'Ball_w_s'  OR `g_type` = 'Ball_d_s' ORDER BY g_id ASC ";
		$sresult = $db->query($sql, 1);
		$sql = "SELECT  h1,h2,h3,h4,h5,h6,h7,h8,h9,h10,h11,h12,h13,h14,h15,`g_type`   FROM `g_odds7` WHERE g_type = 'Ball_l_p' or g_type = 'Ball_d_p' ORDER BY g_id ASC ";
		$eresult = $db->query($sql, 1);
		$list = array_merge($sresult,$eresult);
		$oddsMax = 0;
		
		$arrList = array();
		for ($i=0; $i<count($list); $i++){
			$str=$list[$i]['g_type'];
			foreach ($list[$i] as $key=>$value){
				$arrList[$i][$key] = setoddsk3($key, $value,  $user, 0,$str);
			}
		}
		$arrList = json_encode($arrList);
		echo <<<JSON
			{
			"Phases" : $Phases,
			"endTime" : "$endTime",
			"openTime" : "$openTime",
			"refreshTime" : "$RefreshTime",
			"oddsList" : $arrList
			}
JSON;
	}
}
else if ($tid == 3)
{
	$db = new DB();
	$result = $db->query("SELECT `g_qishu` FROM `g_history7` WHERE g_ball_1 is not null ORDER BY g_qishu DESC LIMIT 1 ", 0);
	$number = $result[0][0];
	echo $number;
}else if($tid == 4){
	$db = new DB();
	$result = $db->query("SELECT * FROM `g_history7` WHERE g_ball_1 is not null ORDER BY g_qishu DESC LIMIT 19 ", 1);
	$number = array();
	for ($i=0; $i<count($result); $i++)
	{
			$number[] = substr($result[$i]['g_qishu'],-2);
	}
	$number = json_encode($number);
	
	$ballArr = array();
	$ball_count = array();
	$numberList = array();
	for ($i=0; $i<count($result); $i++)
	{
			$ballArr[] = "<img width=\"27\" src=\"/templates/images/4_".$result[$i]['g_ball_1'].".gif\" complete=\"complete\"/><img width=\"27\" src=\"/templates/images/4_".$result[$i]['g_ball_2'].".gif\" complete=\"complete\"/><img width=\"27\" src=\"/templates/images/4_".$result[$i]['g_ball_3'].".gif\" complete=\"complete\"/>";
			$ball_count[] = $result[$i]['g_ball_1'] + $result[$i]['g_ball_2']+ $result[$i]['g_ball_3'] ;
			$numberList[] = SubBallk3(0, $result[$i]['g_ball_1'] , $result[$i]['g_ball_2'], $result[$i]['g_ball_3']);
	}
	
	$ballArr = json_encode($ballArr);
	$ball_count = json_encode($ball_count);
	$numberList = json_encode($numberList);
	echo <<<JSON
			{
			"number" : $number,
			"ballArr" : $ballArr,
			"ball_count" : $ball_count,
			"numberList" : $numberList
			
			}
JSON;
}











?>