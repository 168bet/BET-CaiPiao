<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/cheCookie.php';
include_once ROOT_PATH.'class/AutoLet.php';
global $user, $UserOut, $stratGame, $endGame;
$ConfigModel= configModel("`g_mix_money`, `g_web_lock`,`g_kg_game_lock`, `g_odds_ratio_b1`,`g_odds_ratio_b2`,`g_odds_ratio_b3`,`g_odds_ratio_b4`,`g_odds_ratio_b5`,`g_odds_ratio_c1`,`g_odds_ratio_c2`,`g_odds_ratio_c3`,`g_odds_ratio_c4`,`g_odds_ratio_c5`");
$dateTime = date('Y-m-d H:i:s');
if ( $dateTime < $stratGame || $dateTime > $endGame)
{
	back('開盤時間為：'.$stratGame.'--'.$endGame);exit;
}

if ($ConfigModel['g_kg_game_lock'] !=1 || $ConfigModel['g_web_lock'] !=1)
	exit(alert_href('抱歉！盤口未開放。', '../left.php'));
	
if ($user[0]['g_look'] == 2) 
	exit(back($UserOut));

if ($_SERVER["REQUEST_METHOD"] != "POST") 
	exit("PostError");

$action = $_POST['actions']; //提交類型
//$gtypes = $_POST['gtypes'];
if (true)
{
	unset($_SESSION['guid_code']);
	$gtypes = '廣東快樂十分';
	$ListArr = array();
	$odds = 0; 					//賠率
	$countBiShu = 0; 			//總筆數
	$countZhuEr = 0; 			//總注額
	$countKeYinEr = 0; 		//可贏額
	$gMoney = 0;				//剩餘可用金額
	$number_1 = 0; 			//期數
	
	if ($action == 'fn')
	{
		$types = base64_decode($_POST['types']); 										//下注遊戲玩法
		$number_1 = $_POST['number_1']; 													//下注期數
		$number_2 = base64_decode($_POST['number_2']); 						//下注號碼
		$money = $_POST['money']; 															//下注金額
		if (!Matchs::isNumber($money) || $money < $ConfigModel['g_mix_money'])
			exit(alert_href('抱歉！您的下注金額錯誤。', '../left.php'));
		$result = GetUserXianEr ($types, $number_2, $user[0]['g_name']); 	//當前用戶退水列表
		$max = GetUser_s ($result, $user,$types,$number_2);													//當前用戶、單注限額、單號限額、單號已下、 單期限額、單期已下
			$winm=$user[0]['g_money_yes']-$user[0]['g_money'];		
			if($max['HuiYuan_XianH']!=0){
		if($max['HuiYuan_XianH']<$winm)
		exit(alert_href("抱歉！您的限红額度為".$max['HuiYuan_XianH'], '../left.php'));	
		}
		$gMoney = $max['KeYongEr'] - $money; 											//可用金額
		$is_Number = isNumber($types, $number_2, $number_1); 				//驗證提交的期數是否已經封盤
		if ($is_Number === 2) 
			exit(alert_href('抱歉！第 '.$number_1.' 期已經封盤', '../left.php'));
		if (!$is_Number) 
			exit("NumberError"); 																	//驗證號碼是否非法提交
		isUserMoney ($money, $max,$money); 															//驗證下注金額是否大於可用金額
		$countBiShu = 1;																				//總筆數
		$countZhuEr = $money;																	//總注額
		$h = $_POST['hid'];
		$odds = GetOdds ($types, $h); 														//賠率
		if ($types=='總和、龍虎'){
			$odds = setodds($h, $odds, $ConfigModel, $user, 1);
		} else {
			$odds = setodds($h, $odds, $ConfigModel, $user, 0);
		}
		$ListArr[0]['g_s_nid'] = $user[0]['g_nid'];											//外鍵
		$ListArr[0]['g_mumber_type'] = $user[0]['g_mumber_type'];				//會員類型
		$ListArr[0]['g_nid'] = $user[0]['g_name'];											//帳號
		$ListArr[0]['g_date'] = date('Y-m-d H:i:s');											//下注時間
		$ListArr[0]['g_type'] = $gtypes;															//彩票類型
		$ListArr[0]['g_qishu'] = $number_1;													//下注期數
		$ListArr[0]['g_mingxi_1'] = $types;  													//明細1 例如：		第一球
		$ListArr[0]['g_mingxi_1_str'] = null;													//字符串明細_1 	標明連碼用的
		$ListArr[0]['g_mingxi_2'] = $number_2;												//明細2 				下注號碼
		$ListArr[0]['g_mingxi_2_str'] = null;													//字符串明細_2 	標明連碼用的		
		$ListArr[0]['g_odds'] = $odds;															//賠率
		$ListArr[0]['g_jiner'] = $money;															//下注金額
		/*$floorMoney = (100 - $result[0]['g_panlu']) / 100;
		$ListArr[0]['g_tueishui'] = $money * $floorMoney;	*/							//代理退水
		
		/**
		 * 重寫個級別退水及占成
		 */
		$DtnArray = SumRankDistribution ($user, $money, $number_2, $types);
		$g_pan=$user[0]['g_panlu'];
		if($g_pan=="A"){
		$ListArr[0]['g_tueishui'] = $result[0]['g_panlu_a']; 		//會員退水
		}
		if($g_pan=="B"){
		$ListArr[0]['g_tueishui'] = $result[0]['g_panlu_b']; 		//會員退水
		}
		if($g_pan=="C"){
		$ListArr[0]['g_tueishui'] = $result[0]['g_panlu_c']; 		//會員退水
		}
		$ListArr[0]['g_pan'] = $user[0]['g_panlu'];
		$ListArr[0]['g_tueishui_1'] = $DtnArray['tueishui_1']; 		//代理退水
		$ListArr[0]['g_tueishui_2'] = $DtnArray['tueishui_2']; 	//總代理退水
		$ListArr[0]['g_tueishui_3'] = $DtnArray['tueishui_3']; 	//股東退水
		$ListArr[0]['g_tueishui_4'] = $DtnArray['tueishui_4']; 	//公司退水
		$ListArr[0]['g_distribution'] = $DtnArray['distribution_1']; 			//代理占成
		$ListArr[0]['g_distribution_1'] = $DtnArray['distribution_2'];	 	//總代理占成
		$ListArr[0]['g_distribution_2'] = $DtnArray['distribution_3']; 		//股東占成
		$ListArr[0]['g_distribution_3'] = $DtnArray['distribution_4']; 		//公司占成
		$ListArr[0]['g_distribution_4'] =100- ($DtnArray['distribution_4']+$DtnArray['distribution_3']+$DtnArray['distribution_2']+$DtnArray['distribution_1']); 		//公司占成
		$ListArr[0]['KeYongEr'] = $gMoney;
		$ListArr[0]['nowjiner'] = $gMoney;//jia可用金額
		$tuiShui = sumTuiSui ($ListArr[0]);
		$_tuiShui = $ListArr[0]['g_jiner'] * $tuiShui;
		$ListArr[0]['KeYing'] = $ListArr[0]['g_jiner'] * $ListArr[0]['g_odds'] - $ListArr[0]['g_jiner'] + $_tuiShui;
		$ListArr[0]['id'] = postForms ($ListArr[0]);
		if ($ListArr[0]['id'] == null) exit(alert_href("抱歉！{$ListArr[0]['g_mingxi_1']}『{$ListArr[0]['g_mingxi_2']}』下註失敗！", '../left.php'));
		upUserKyYongEr ($ListArr[0]['KeYongEr'], $ListArr[0]['g_nid']);
	}
	else if ($action == 'fn1') //alert提交
	{
		$s_number = $_POST['s_number'];
		$s_type = $_POST['s_type'];
		$s_ball_arr = $_POST['s_ball'];
		$s_money_arr = $_POST['s_money'];
		$s_hid_arr = $_POST['s_hid'];
		$count_money = 0;
		//循環判斷
		for ($i=0; $i<count($s_money_arr); $i++)
		{
			$is_Number = isNumber($s_type, $s_ball_arr[$i], $s_number); 
			if ($is_Number === 2)
				exit(alert_href('抱歉！第 '.$s_number.' 期已經封盤', '../left.php'));
			if (!$is_Number)
				exit("NumberError");
			$count_money += $s_money_arr[$i];
			$s = $i+1;
		}
		$countBiShu = $s;													//總筆數
		$countZhuEr = $count_money;								//總注額
		$number_1 = $s_number;
		if (!Matchs::isNumber($countZhuEr) || $countZhuEr < $ConfigModel['g_mix_money'])
			exit(alert_href('抱歉！您的下注金額錯誤。', '../left.php'));
		for ($i=0; $i<count($s_ball_arr); $i++)
		{
			$result = GetUserXianEr ($s_type, $s_ball_arr[$i], $user[0]['g_name']); 				//當前用戶退水列表
			$max = GetUser_s ($result, $user,$s_type,$s_ball_arr[$i]);																	//當前用戶、單注限額、單號限額、單號已下、 單期限額、單期已下
				$winm=$user[0]['g_money_yes']-$user[0]['g_money'];	
				if($max['HuiYuan_XianH']!=0){	
		if($max['HuiYuan_XianH']<$winm)
		exit(alert_href("抱歉！您的限红額度為".$max['HuiYuan_XianH'], '../left.php'));	
		}
			for ($k=0; $k<count($s_money_arr); $k++)
			{
			isUserMoney ($s_money_arr[$k], $max,$countZhuEr); 																//驗證下注金額是否大於可用金額
			}
			$odds = GetOdds ($s_type, $s_hid_arr[$i]); 														//賠率
			if ($s_type=='總和、龍虎'){
				$odds = setodds($s_hid_arr[$i], $odds, $ConfigModel, $user, 1);
			} else {
				$odds = setodds($s_hid_arr[$i], $odds, $ConfigModel, $user, 0);
			}
			$ListArr[$i]['g_s_nid'] = $user[0]['g_nid'];											//外鍵
			$ListArr[$i]['g_mumber_type'] = $user[0]['g_mumber_type'];		//會員類型
			$ListArr[$i]['g_nid'] = $user[0]['g_name'];															//帳號
			$ListArr[$i]['g_date'] = date('Y-m-d H:i:s');														//下注時間
			$ListArr[$i]['g_type'] = $gtypes;																		//彩票類型
			$ListArr[$i]['g_qishu'] = $s_number;																	//下注期數
			$ListArr[$i]['g_mingxi_1'] = $s_type;  																//明細1 例如：		第一球
			$ListArr[$i]['g_mingxi_1_str'] = null;																	//字符串明細_1 	標明連碼用的
			$ListArr[$i]['g_mingxi_2'] = $s_ball_arr[$i];														//明細2 				下注號碼
			$ListArr[$i]['g_mingxi_2_str'] = null;																	//字符串明細_2 	標明連碼用的		
			$ListArr[$i]['g_odds'] = $odds;																			//賠率
			$ListArr[$i]['g_jiner'] = $s_money_arr[$i];															//下注金額
			/*$floorMoney = (100 - $result[0]['g_panlu']) / 100;
			$ListArr[$i]['g_tueishui'] = sprintf("%.2f", $s_money_arr[$i] * $floorMoney);*/		//退水
			$DtnArray = SumRankDistribution ($user, $s_money_arr[$i], $s_ball_arr[$i], $s_type);
			$g_pan=$user[0]['g_panlu'];
		if($g_pan=="A"){
		$ListArr[$i]['g_tueishui'] = $result[0]['g_panlu_a']; 		//會員退水
		}
		if($g_pan=="B"){
		$ListArr[$i]['g_tueishui'] = $result[0]['g_panlu_b']; 		//會員退水
		}
		if($g_pan=="C"){
		$ListArr[$i]['g_tueishui'] = $result[0]['g_panlu_c']; 		//會員退水
		}
		$ListArr[$i]['g_pan'] = $user[0]['g_panlu'];
			//$ListArr[$i]['g_tueishui'] = $result[0]['g_panlu']; 		//會員退水
			$ListArr[$i]['g_tueishui_1'] = $DtnArray['tueishui_1']; 		//代理退水
			$ListArr[$i]['g_tueishui_2'] = $DtnArray['tueishui_2']; 	//總代理退水
			$ListArr[$i]['g_tueishui_3'] = $DtnArray['tueishui_3']; 	//股東退水
			$ListArr[$i]['g_tueishui_4'] = $DtnArray['tueishui_4']; 	//公司退水
			$ListArr[$i]['g_distribution'] = $DtnArray['distribution_1']; 			//代理占成
			$ListArr[$i]['g_distribution_1'] = $DtnArray['distribution_2'];	 	//總代理占成
			$ListArr[$i]['g_distribution_2'] = $DtnArray['distribution_3']; 		//股東占成
			$ListArr[$i]['g_distribution_3'] = $DtnArray['distribution_4']; 		//公司占成
			$ListArr[$i]['g_distribution_4'] =100- ($DtnArray['distribution_4']+$DtnArray['distribution_3']+$DtnArray['distribution_2']+$DtnArray['distribution_1']); 		//公司占成
			$gMoney = $max['KeYongEr'] - $count_money; 												//可用金額
			$ListArr[$i]['KeYongEr'] = $gMoney;
			$ListArr[$i]['nowjiner'] = $gMoney;//jia可用金額
			$tuiShui = sumTuiSui ($ListArr[$i]);
			$_tuiShui = $ListArr[$i]['g_jiner'] * $tuiShui;
			$ListArr[$i]['KeYing'] = $ListArr[$i]['g_jiner'] * $ListArr[$i]['g_odds'] - $ListArr[$i]['g_jiner'] + $_tuiShui; //可贏額
			$ListArr[$i]['id'] = postForms ($ListArr[$i]);
			if ($ListArr[$i]['id'] == null) exit(alert_href("抱歉！{$ListArr[$i]['g_mingxi_1']}『{$ListArr[$i]['g_mingxi_2']}』下註失敗，請與上級管理聯繫！", '../left.php'));
		}
		upUserKyYongEr ($gMoney, $ListArr[0]['g_nid']);		
	}
	else if ($action == 'fn2') //連碼提交
	{
		$s_type = base64_decode($_POST['s_type']);
		$s_number = base64_decode($_POST['s_number']);
		$s_ball = base64_decode($_POST['s_ball']);
		$s_ball_arr = explode('、', $s_ball);
		$s_money = $_POST['s_money'];
		if (!Matchs::isNumber($s_money) || $s_money < $ConfigModel['g_mix_money'])
			exit(alert_href('抱歉！您的下注金額錯誤。', '../left.php'));
		//循環判斷
		for ($i=0; $i<count($s_ball_arr); $i++)
		{
			$is_Number = isNumber($s_type, $s_ball_arr[$i], $s_number);
			if ($is_Number === 2) exit(alert_href('抱歉！第 '.$s_number.' 期已經封盤', '../left.php'));
			if (!$is_Number) exit("NumberError");
		}
		$hi = 'h'.trim(strtr($s_type, "t"," "));
		$stringList = GetGameType($s_type);
		$results = subArr ($s_ball_arr, $stringList['count']); //復式計算、返回值、【總組數】、【總個數】、【號碼個數】
		$number_1 = $s_number; //期數
		$countBiShu = 1; //總筆數
		$countZhuEr = $results[0] * $s_money; //總下注金額
		$odds = GetOdds ('連碼', $hi); //賠率
		$odds = setodds($hi, $odds, $ConfigModel, $user, 2);
		
		$result = GetUserXianEr ($stringList['type'], null, $user[0]['g_name']); 				//當前用戶退水列表
		$max = GetUser_s ($result, $user,$stringList['type'],null);																	//當前用戶、單注限額、單號限額、單號已下、 單期限額、單期已下
			$winm=$user[0]['g_money_yes']-$user[0]['g_money'];	
			if($max['HuiYuan_XianH']!=0){	
		if($max['HuiYuan_XianH']<$winm)
		exit(alert_href("抱歉！您的限红額度為".$max['HuiYuan_XianH'], '../left.php'));	
		}
		isUserMoney ($countZhuEr, $max,$countZhuEr); 																	//驗證下注金額是否大於可用金額
		$gMoney = $max['KeYongEr'] - $countZhuEr; 													//可用金額
		$ListArr[0]['g_s_nid'] = $user[0]['g_nid'];											//外鍵
		$ListArr[0]['g_mumber_type'] = $user[0]['g_mumber_type'];		//會員類型
		$ListArr[0]['g_nid'] = $user[0]['g_name'];															//帳號
		$ListArr[0]['g_date'] = date('Y-m-d H:i:s');															//下注時間
		$ListArr[0]['g_type'] = $gtypes;																			//彩票類型
		$ListArr[0]['g_qishu'] = $s_number;																	//下注期數
		$ListArr[0]['g_mingxi_1'] = $stringList['type'];  													//明細1 例如：		第一球
		$ListArr[0]['g_mingxi_1_str'] = $results[0];														//字符串明細_1 	標明連碼、共多少組
		$ListArr[0]['g_mingxi_2'] = $s_ball;																	//明細2 				下注號碼
		$ListArr[0]['g_mingxi_2_str'] = null;																	//字符串明細_2 	標明連碼	
		$ListArr[0]['g_odds'] = $odds;																			//賠率
		$ListArr[0]['g_jiner'] = $s_money;																		//下注金額
		$DtnArray = SumRankDistribution ($user, $s_money, null, $stringList['type']);
		$g_pan=$user[0]['g_panlu'];
		if($g_pan=="A"){
		$ListArr[0]['g_tueishui'] = $result[0]['g_panlu_a']; 		//會員退水
		}
		if($g_pan=="B"){
		$ListArr[0]['g_tueishui'] = $result[0]['g_panlu_b']; 		//會員退水
		}
		if($g_pan=="C"){
		$ListArr[0]['g_tueishui'] = $result[0]['g_panlu_c']; 		//會員退水
		}
		$ListArr[0]['g_pan'] = $user[0]['g_panlu'];
		//$ListArr[0]['g_tueishui'] = $result[0]['g_panlu']; 		//會員退水
		$ListArr[0]['g_tueishui_1'] = $DtnArray['tueishui_1']; 		//代理退水
		$ListArr[0]['g_tueishui_2'] = $DtnArray['tueishui_2']; 	//總代理退水
		$ListArr[0]['g_tueishui_3'] = $DtnArray['tueishui_3']; 	//股東退水
		$ListArr[0]['g_tueishui_4'] = $DtnArray['tueishui_4']; 	//公司退水
		$ListArr[0]['g_distribution'] = $DtnArray['distribution_1']; 			//代理占成
		$ListArr[0]['g_distribution_1'] = $DtnArray['distribution_2'];	 	//總代理占成
		$ListArr[0]['g_distribution_2'] = $DtnArray['distribution_3']; 		//股東占成
		$ListArr[0]['g_distribution_3'] = $DtnArray['distribution_4']; 		//公司占成
		$ListArr[0]['g_distribution_4'] =100- ($DtnArray['distribution_4']+$DtnArray['distribution_3']+$DtnArray['distribution_2']+$DtnArray['distribution_1']); 		//公司占成
		$tuiShui = sumTuiSui ($ListArr[0]);
		$_tuiShui = $countZhuEr * $tuiShui;
		$ListArr[0]['KeYing'] = $countZhuEr * $ListArr[0]['g_odds'] - $countZhuEr + $_tuiShui; 		//可贏額
		$ListArr[0]['nowjiner'] = $gMoney;//jia可用金額
		$ListArr[0]['id'] = postForms ($ListArr[0]);
		if ($ListArr[0]['id'] == null) exit(alert_href("抱歉！{$ListArr[0]['g_mingxi_1']}『{$ListArr[0]['g_mingxi_2']}』下註失敗，請與上級管理聯繫！", '../left.php'));
		upUserKyYongEr ($gMoney, $ListArr[0]['g_nid']);
	}
	else if ($action == 'fn3') //雙面提交
	{
		$number_1 = $_POST['s_number'];
		$sm_arr = $_POST['sm_arr'];
		$sm_arr = explode('|', $sm_arr, -1);
		//$number_arr = array();
		for ($i=0; $i<count($sm_arr); $i++){
			$sm_arr[$i] = explode(',', $sm_arr[$i]);
		}
		
		for ($i=0; $i<count($sm_arr); $i++){
			if (!Matchs::isNumber($sm_arr[$i][3]))
				exit(alert_href('抱歉！您的下注金額錯誤。', '../left.php'));
			$is_Number = isNumber($sm_arr[$i][0], $sm_arr[$i][1], $number_1);
			if ($is_Number === 2) exit(alert_href('抱歉！第 '.$number_1.' 期已經封盤', '../left.php'));
			if (!$is_Number) exit("NumberError");
			$countZhuEr += $sm_arr[$i][3];
			$countBiShu ++;
		}
		
		$max = null;
		for ($i=0; $i<count($sm_arr); $i++){
			$result = GetUserXianEr ($sm_arr[$i][0], $sm_arr[$i][1], $user[0]['g_name']); 	//當前用戶退水列表
			$max = GetUser_s ($result, $user,$sm_arr[$i][0], $sm_arr[$i][1]);																			//當前用戶、單注限額、單號限額、單號已下、 單期限額、單期已下
				$winm=$user[0]['g_money_yes']-$user[0]['g_money'];	
				if($max['HuiYuan_XianH']!=0){	
		if($max['HuiYuan_XianH']<$winm)
		exit(alert_href("抱歉！您的限红額度為".$max['HuiYuan_XianH'], '../left.php'));	
		}
			for ($k=0; $k<count($sm_arr); $k++){
			isUserMoney ($sm_arr[$k][3], $max,$countZhuEr); 				
			}
																	//驗證下注金額是否大於可用金額
		}
		
		for ($i=0; $i<count($sm_arr); $i++){
			$odds = GetOdds ($sm_arr[$i][0], $sm_arr[$i][1]); 														//賠率
			$hv = sresult ($sm_arr[$i][1]);
			if ($sm_arr[$i][0]=='總和、龍虎'){
				$odds = setodds($hv, $odds, $ConfigModel, $user, 1);
			} else {
				$odds = setodds($hv, $odds, $ConfigModel, $user, 0);
			}
			$ListArr[$i]['g_s_nid'] = $user[0]['g_nid'];															//外鍵
			$ListArr[$i]['g_mumber_type'] = $user[0]['g_mumber_type'];					//會員類型
			$ListArr[$i]['g_nid'] = $user[0]['g_name'];															//帳號
			$ListArr[$i]['g_date'] = date('Y-m-d H:i:s');															//下注時間
			$ListArr[$i]['g_type'] = $gtypes;																				//彩票類型
			$ListArr[$i]['g_qishu'] = $number_1;																		//下注期數
			$ListArr[$i]['g_mingxi_1'] = $sm_arr[$i][0];  																		//明細1 例如：		第一球
			$ListArr[$i]['g_mingxi_1_str'] = null;																	//字符串明細_1 	標明連碼用的
			$ListArr[$i]['g_mingxi_2'] = $sm_arr[$i][1];														//明細2 				下注號碼
			$ListArr[$i]['g_mingxi_2_str'] = null;																	//字符串明細_2 	標明連碼用的		
			$ListArr[$i]['g_odds'] = $odds;																			//賠率
			$ListArr[$i]['g_jiner'] = $sm_arr[$i][3];															//下注金額
			$DtnArray = SumRankDistribution ($user, $sm_arr[$i][3], $sm_arr[$i][1], $sm_arr[$i][0]);
			/* 退水修正*/
			$result = GetUserXianEr ($sm_arr[$i][0], $sm_arr[$i][1], $user[0]['g_name']);
			$g_pan=$user[0]['g_panlu'];
		if($g_pan=="A"){
		$ListArr[$i]['g_tueishui'] = $result[0]['g_panlu_a']; 		//會員退水
		}
		if($g_pan=="B"){
		$ListArr[$i]['g_tueishui'] = $result[0]['g_panlu_b']; 		//會員退水
		}
		if($g_pan=="C"){
		$ListArr[$i]['g_tueishui'] = $result[0]['g_panlu_c']; 		//會員退水
		}
		$ListArr[$i]['g_pan'] = $user[0]['g_panlu'];
			//$ListArr[$i]['g_tueishui'] = $result[0]['g_panlu']; 		//會員退水
			$ListArr[$i]['g_tueishui_1'] = $DtnArray['tueishui_1']; 		//代理退水
			$ListArr[$i]['g_tueishui_2'] = $DtnArray['tueishui_2']; 	//總代理退水
			$ListArr[$i]['g_tueishui_3'] = $DtnArray['tueishui_3']; 	//股東退水
			$ListArr[$i]['g_tueishui_4'] = $DtnArray['tueishui_4']; 	//公司退水
			$ListArr[$i]['g_distribution'] = $DtnArray['distribution_1']; 			//代理占成
			$ListArr[$i]['g_distribution_1'] = $DtnArray['distribution_2'];	 	//總代理占成
			$ListArr[$i]['g_distribution_2'] = $DtnArray['distribution_3']; 		//股東占成
			$ListArr[$i]['g_distribution_3'] = $DtnArray['distribution_4']; 		//公司占成
			$ListArr[$i]['g_distribution_4'] =100- ($DtnArray['distribution_4']+$DtnArray['distribution_3']+$DtnArray['distribution_2']+$DtnArray['distribution_1']); 		//公司占成
			$gMoney = $max['KeYongEr'] - $countZhuEr; 												//可用金額
			$ListArr[$i]['KeYongEr'] = $gMoney;
			$ListArr[$i]['nowjiner'] = $gMoney;//jia可用金額
			$tuiShui = sumTuiSui ($ListArr[$i]);
			$_tuiShui = $ListArr[$i]['g_jiner'] * $tuiShui;
			$ListArr[$i]['KeYing'] = $ListArr[$i]['g_jiner'] * $ListArr[$i]['g_odds'] - $ListArr[$i]['g_jiner'] + $_tuiShui; //可贏額
			$ListArr[$i]['id'] = postForms ($ListArr[$i]);
			if ($ListArr[$i]['id'] == null) 
				exit(alert_href("抱歉！{$ListArr[$i]['g_mingxi_1']}『{$ListArr[$i]['g_mingxi_2']}』下註失敗", '../left.php'));
		}
		upUserKyYongEr ($gMoney, $ListArr[0]['g_nid']);		
	}
	else
	{
		exit("DataProceError");
	}
new AutoLet($number_1, $ListArr);
}
else
{
	alert_href('系統繁忙中，請稍後5秒后在進行下注。', '../left.php');
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" oncontextmenu="return false">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/left.css" rel="stylesheet" type="text/css">
<script src="/js/jquery.js" type="text/javascript"></script>
<style type="text/css">
body {background-color:#FFEFE2}
</style>
</head>
<body>
<INPUT value=<?php echo $number_1?> type=hidden name=number> 
<DIV id=orderResult>
<TABLE class="t1 bg_white dataArea">
<THEAD style="VISIBILITY: hidden">
<TR>
<TD></TD>
<TD></TD>
<TD></TD></TR></THEAD>
<TBODY id=s-list>

                        	 <?php 
                        	 if ($action == 'fn' || $action == 'fn1' || $action == 'fn3') //單筆循環投注單
                        	 {
	                        	 for ($i=0; $i<count($ListArr); $i++)
	                        	 {
	                        	 	$nn = $ListArr[$i]['g_mingxi_1'] == '總和、龍虎' ? $ListArr[$i]['g_mingxi_2'] : $ListArr[$i]['g_mingxi_1'].'『'.$ListArr[$i]['g_mingxi_2'].'』';
		                        	 echo '<TR>
<TD colSpan=3>
<P>註單號：<SPAN class=greener>'.$ListArr[$i]['id'].'</SPAN></P>
<P class=text-i-em3><SPAN class=bluer>'.$nn.'</SPAN>&nbsp; @ <B class=red>'.$ListArr[$i]['g_odds'].'</B></P>
<P>下註額：<SPAN class=black>'.$ListArr[$i]['g_jiner'].'</SPAN></P>
<P>可贏額：<SPAN class=black>'.$ListArr[$i]['KeYing'].'</SPAN></P></TD></TR>';
	                        	  }
                        	 }
                        	 else if ($action == 'fn2') //複式組合注單
                        	 {
                        	 	echo '<TR><TD colSpan=3><P>註單號：<SPAN class=greener>'.$ListArr[0]['id'].'</SPAN></P>';
                        	 	echo '<P class=text-i-em3><SPAN class=bluer>'.$stringList['type'].'</SPAN>&nbsp; @  &nbsp;<B class=red>'.$odds.'</B></P>';
                        	 	echo '<P class=text-i-em3><SPAN class=black>復式『 '.$results[0].'組 』</SPAN></P>';
                        	 	echo '<P style="TEXT-INDENT: 0px" class=text-i-em3><SPAN class=black>'.$s_ball.'</SPAN></P>';
                        	 	echo '<P>分組：<SPAN style="PADDING-LEFT: 1em" class=black>'.$results[0].'组</SPAN></P>';
                        	 	echo '<P>下註額：<SPAN class=black>'.$countZhuEr.'</SPAN></P>';
                        	 	echo '<P>可贏額：<SPAN class=black>'.$ListArr[0]['KeYing'].'</SPAN></P></SPAN></TD></TR>';

                        	 	echo ' <TR><TH class=db-bg>ID</TH><TH class=db-bg>號碼組合</TH><TH class=db-bg>下註額</TH></TR>';
                        	 	for ($i=0; $i<count($results[1]); $i++)
                        	 	{
                        	 		$s = $i+1;
                        	 		echo '<TR><TD>'.$s.'</TD><TD>'.$results[1][$i].'</TD><TD>'.$s_money.'</TD></TR>';
                        	 	}                        	 	
                        	 }
                        	 ?>
							 </TBODY>
							 <TFOOT>
<TR>
<TD style="WIDTH: 75px" class="inner_text td_h" colSpan=2>下註筆數</TD>
<TD style="WIDTH: 147px" class=db-bg><SPAN class="black suc_zhus"><?php echo $countBiShu?>筆</SPAN></TD></TR>
<TR>
<TD style="WIDTH: 75px" class="inner_text td_h" colSpan=2>總計註額</TD>
<TD class=db-bg><B class="reder suc_t_amount"><?php echo $countZhuEr?></B></TD></TR></TFOOT></TABLE></DIV>

                      
				<script language="javascript" src="../../webssc/js/touzhu.js?112"></script>
</body>
</html>