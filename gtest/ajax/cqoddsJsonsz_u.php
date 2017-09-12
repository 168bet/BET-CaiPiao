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
	$db = new DB();
	//最新開獎記錄
	$sql = "SELECT  `g_qishu`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5`  FROM g_history2 WHERE g_ball_1 is not null ORDER BY g_qishu DESC LIMIT 1";
	$result = $db->query($sql, 0);
	$number = $result[0][0];
	$ballArr = array();
	$resultArr = array();
	$resultaArr = array();
	$resultbArr = array();
	$resultcArr = array();

	
	for ($i=0; $i<count($result[0]); $i++)
	{
		if ($i != 0)
			$ballArr[] = $result[0][$i];
	}
	$ballArr = json_encode($ballArr);
	$winMoney = json_encode(getWin ($user));
	$mid = 5;
	$gameInfo = new GameInfo();
	for ($i=1; $i<6; $i++)
	{
	$resultArr[$i-1] = $gameInfo->OpenNumberCount($i);
	$resultArr[$i-1] = json_encode($resultArr[$i-1]);
	
	$resultaArr[$i-1] = $gameInfo->OpenNumberCounta ($i, 0, -1);
	$resultbArr[$i-1] = $gameInfo->OpenNumberCounta ($i, 3, 0);
	$resultcArr[$i-1] = $gameInfo->OpenNumberCounta ($i, 4, 0);
	
	$resultaArr[$i-1] = json_encode($resultaArr[$i-1]);
	$resultbArr[$i-1] = json_encode($resultbArr[$i-1]);
	$resultcArr[$i-1] = json_encode($resultcArr[$i-1]);
	
	}
	
	$resultd = $gameInfo->OpenNumberCounta (null, 5, 1);
	$resulte = $gameInfo->OpenNumberCounta (null, 6, 1);
	$resultf = $gameInfo->OpenNumberCounta (null, 2, 2);
	
	$resulth = $gameInfo->OpenNumberCountb();

	$resultd = json_encode($resultd);
	$resulte = json_encode($resulte);
	$resultf = json_encode($resultf);
	$resulth = json_encode($resulth);
	echo <<<JSON
			{
				"winMoney" : $winMoney,
				"number" : $number,
				"ballArr" : $ballArr,
				"result1" : $resultArr[0],
				"result2" : $resultArr[1],
				"result3" : $resultArr[2],
				"result4" : $resultArr[3],
				"result5" : $resultArr[4],
				"result1HM" : $resultaArr[0],
				"result2HM" : $resultaArr[1],
				"result3HM" : $resultaArr[2],
				"result4HM" : $resultaArr[3],
				"result5HM" : $resultaArr[4],
				"result1DX" : $resultbArr[0],
				"result2DX" : $resultbArr[1],
				"result3DX" : $resultbArr[2],
				"result4DX" : $resultbArr[3],
				"result5DX" : $resultbArr[4],
				"result1DS" : $resultcArr[0],
				"result2DS" : $resultcArr[1],
				"result3DS" : $resultcArr[2],
				"result4DS" : $resultcArr[3],
				"result5DS" : $resultcArr[4],
				"resultZHDX": $resultd,
				"resultZHDS": $resulte,
				"resultZHLH": $resultf,
				"resultCL" : $resulth
			}
JSON;
exit;
}
else if ($tid == 2)
{
	//獲取封盤時間、開獎時間、刷新時間
	$db = new DB();
	$result = $db->query("SELECT `g_qishu`, `g_feng_date`, `g_open_date` FROM g_kaipan2 WHERE `g_lock` = 2 LIMIT 1 ", 1);
	if ($result && Copyright)
	{
		$endTime = strtotime($result[0]['g_feng_date']) - time();
		$openTime =  strtotime($result[0]['g_open_date']) - time();
		$Phases = $result[0]['g_qishu'];
		$RefreshTime = 90; //刷新時間
		
		//取出1-8球和總和龍虎雙面賠率
		$db=new DB();
		$sql = "SELECT  `h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `h7`, `h8`, `h9`, `h10`, `h11`, `h12`, `h13`, `h14`,`g_type`  FROM `g_odds2` WHERE `g_type` = 'Ball_1' OR `g_type` = 'Ball_2' OR `g_type` = 'Ball_3' OR `g_type` = 'Ball_4' OR `g_type` = 'Ball_5'   ORDER BY g_id ASC ";
		$sresult = $db->query($sql, 1);
		$sql = "SELECT `h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `h7`,`g_type`  FROM `g_odds2` WHERE g_type = 'Ball_6'  OR g_type='Ball_7' OR g_type ='Ball_8' OR g_type='Ball_9' ORDER BY g_id ASC ";
		$eresult = $db->query($sql, 1);
		$list = array_merge($sresult, $eresult);
		$oddsMax = 0;
		$ConfigModel= configModel("`g_odds_ratio_cq_b1`,`g_odds_ratio_cq_b2`,`g_odds_ratio_cq_b3`,`g_odds_ratio_cq_c1`,`g_odds_ratio_cq_c2`,`g_odds_ratio_cq_c3`");
		$arrList = array();
		for ($i=0; $i<count($list); $i++){
			$str=$list[$i]['g_type'];
			foreach ($list[$i] as $key=>$value){
			//1-5號碼
			if ($str == 'Ball_1' || $str == 'Ball_2' || $str == 'Ball_3' || $str == 'Ball_4' || $str == 'Ball_5')
			{
				if ($key != 'g_type' && $key != 'h11' &&$key != 'h12' &&$key != 'h13' &&$key != 'h14' && $value != null)
				{
					$arrList[$i][$key] = setoddscq($key, $value, $ConfigModel, $user, 0,$str);
				}
				else if ($key != 'g_type' && $value != null)
				{
					$arrList[$i][$key] = setoddscq($key, $value, $ConfigModel, $user, 1);
				}
			}
			else if ($str == 'Ball_6' && $key != 'g_type' && $value != null && Copyright)
			{
				$arrList[$i][$key] = setoddscq($key, $value, $ConfigModel, $user, 1,$str);
			}
			else if (($str == 'Ball_7'||$str == 'Ball_8'||$str == 'Ball_9') && $key != 'g_type' && $value != null)
			{
				$arrList[$i][$key] = setoddscq($key, $value, $ConfigModel, $user, 2,$str);
			}else{
				$arrList[$i][$key] = setoddscq($key, $value, $ConfigModel, $user, 0,$str);
				}
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
	$result = $db->query("SELECT `g_qishu` FROM `g_history2` WHERE g_ball_1 is not null ORDER BY g_qishu DESC LIMIT 1 ", 0);
	$number = $result[0][0];
	echo $number;
}











?>