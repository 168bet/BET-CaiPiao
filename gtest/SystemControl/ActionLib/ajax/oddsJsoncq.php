<?php
define('Copyright', '作者QQ:503064228');
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
	include_once ROOT_PATH.'Manage/ExistUser.php';
	global $Users;
	$db=new DB();
	$mid = $_POST['mid'];
	
	if ($mid == 1)
	{
		include_once ROOT_PATH.'class/UserReportInfocq.php';
		$userReportInfocq = new UserReportInfocq($Users[0]);
		$result = $userReportInfocq->GetNumberAll();
		$result = json_encode($result);
		$infocq = $userReportInfocq->GetInfocq();
		$infocq = json_encode($infocq);
		echo <<<JSON
				{
					"timeList" : $result,
					"infocq" : $infocq
				}
JSON;
	}
	if ($mid == 2)
	{
		$sql = "SELECT `h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `h7`, `h8`, `h9`, `h10`, `h11`, `h12`, `h13`, `h14` FROM `g_odds2`  ORDER BY g_id ASC";
		$oddsResult = $db->query($sql, 1);
		$list = array();
		for ($i=0; $i<count($oddsResult); $i++)
		{
			foreach ($oddsResult[$i] as $k=>$v)
			{
				if ($v != null)
					$list[$i][$k] = $v;
			}
		}
		$list = json_encode($list);
		echo <<<JSON
				{
					"oddsList" : $list
				}
JSON;
	}
	if ($mid == 3)
	{
		$sql = "SELECT g_qishu FROM g_history2 WHERE g_ball_1 is not null AND g_ball_2 is not null ORDER BY g_id DESC LIMIT 1";
		$result = $db->query($sql, 0);
		echo  $result[0][0];
	}
	if ($mid == 4)
	{
		include_once ROOT_PATH.'class/GameInfo.php';
		$userReportInfo = new UserReportInfo($Users, 1);
		$winMoney = json_encode($userReportInfo->SumResult($Users));
		$gameInfo = new GameInfo();
		$result = $gameInfo->OpenNumberCountb();
		$result = json_encode($result);
		echo <<<JSON
				{
					"dayWin" : $winMoney,
					"result" : $result
				}
JSON;
	}
	if ($mid == 5)
	{
		echo 'cccc';
	}
	if($mid==6){
	//最新開獎記錄
	$sql = "SELECT  `g_qishu`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5`  FROM g_history2 WHERE g_ball_1 is not null ORDER BY g_qishu DESC LIMIT 1";
	$result = $db->query($sql, 0);
	$number = $result[0][0];
	$ballArr = array();
	for ($i=0; $i<count($result[0]); $i++)
	{
		if ($i != 0)
			$ballArr[] = $result[0][$i];
	}
	$ballArr = json_encode($ballArr);
	
	echo <<<JSON
			{			
				"number" : $number,
				"ballArr" : $ballArr
			}
JSON;
exit;

	}
}
?>