<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
global $Users, $LoginId;
if ($Users[0]['g_login_id'] != 89) if ($Users[0]['g_lock'] == 2)
	exit(back($UserOut)); //帳號已被凍結
	
//子帳號
if (isset($Users[0]['g_lock_2'])){
	if ( $Users[0]['g_s_lock'] == 2 || $Users[0]['g_lock_2'] != 1)
		exit(back($UserOut)); //帳號已被凍結
}
markPos("后台-代理退水设置");

$userModel = new UserModel();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = $_POST['name'];
	//dump($name);
	$usersModel = $userModel->GetUserModel(null, $name);
	if ($usersModel)
	{
	$Lname = mb_substr($usersModel[0]['g_nid'], 0, mb_strlen($usersModel[0]['g_nid'])-32);
		$Lname = $userModel->GetUserName_Like($Lname);
		$db = new DB();
		if ($usersModel[0]['g_login_id'] == 56){
			$Lname=$usersModel;
		} else {
			if ($Lname[0]['g_lock'] != 1) {
				exit(back('更變權限不足！'));
			}
		}
		$sList = array(0=>0, 1=>0, 2=>0);
		
		
		$LdetList = $db->query("SELECT `g_id`, `g_name`, `g_type`, `g_a_limit`, g_b_limit, g_c_limit,  `g_d_limit`, `g_e_limit`, `g_game_id` 
		FROM `g_send_back` WHERE g_name = '{$Lname[0]['g_name']}' and g_game_id = '1'  ORDER BY g_id DESC", 0);
		
	//	dump($LdetList);
		
	     for ($i=0; $i<count($LdetList); $i++) {
			$aList = $_POST['RebateAG'.($i+1)];
			$bList = $_POST['RebateBG'.($i+1)];
			$cList = $_POST['RebateCG'.($i+1)];
			$dList = $_POST['RebateEG'.($i+1)];
			$eList = $_POST['RebateFG'.($i+1)];
			if ($aList > 100) exit(back(' 退水最高不超过：100'));
			if ($bList > 100) exit(back(' 退水最高不超过：100'));
			if ($cList > 100) exit(back(' 退水最高不超过：100'));

        	if ($aList > $LdetList[$i][3])
			{
				//取A盘
				$LdetList[$i][3] = $aList;
				updateTuiShui ($db, $LdetList[$i], $usersModel, 'a', $aList);
			} 
			if ($bList > $LdetList[$i][4])
			{
				//取B盘
				$LdetList[$i][4] = $bList;
				updateTuiShui ($db, $LdetList[$i], $usersModel, 'b', $bList);
			} 
			if ($cList > $LdetList[$i][5])
			{
				//取C盘
				$LdetList[$i][5] = $cList;
				updateTuiShui ($db, $LdetList[$i], $usersModel, 'c', $cList);
			}
			
			//修改退水
			$sql = "UPDATE `g_send_back` SET `g_a_limit` = '{$aList}', `g_b_limit` = '{$bList}', `g_c_limit` = '{$cList}', `g_d_limit` = '{$dList}', `g_e_limit` = '{$eList}'
			WHERE `g_name` = '{$usersModel[0]['g_name']}' AND g_type = '{$LdetList[$i][2]}' AND g_game_id = '{$LdetList[$i][8]}' LIMIT 1";
			$db->query($sql, 2);
			
		}
		
		
		
		//重庆
			$LdetListc = $db->query("SELECT `g_id`, `g_name`, `g_type`, `g_a_limit`, g_b_limit, g_c_limit,  `g_d_limit`, `g_e_limit`, `g_game_id` 
		FROM `g_send_back` WHERE g_name = '{$Lname[0]['g_name']}' and g_game_id = '2'  ORDER BY g_id DESC", 0);
		
		//dump($LdetListc);
		
	     for ($i=0; $i<count($LdetListc); $i++) {
			$aList = $_POST['RebateAC'.($i+1)];
			$bList = $_POST['RebateBC'.($i+1)];
			$cList = $_POST['RebateCC'.($i+1)];
			$dList = $_POST['RebateEC'.($i+1)];
			$eList = $_POST['RebateFC'.($i+1)];
			if ($aList > 100) exit(back(' 退水最高不超过：100'));
			if ($bList > 100) exit(back(' 退水最高不超过：100'));
			if ($cList > 100) exit(back(' 退水最高不超过：100'));

        	if ($aList > $LdetListc[$i][3])
			{
				//取A盘
				$LdetListc[$i][3] = $aList;
				updateTuiShui ($db, $LdetListc[$i], $usersModel, 'a', $aList);
			} 
			if ($bList > $LdetListc[$i][4])
			{
				//取B盘
				$LdetListc[$i][4] = $bList;
				updateTuiShui ($db, $LdetListc[$i], $usersModel, 'b', $bList);
			} 
			if ($cList > $LdetListc[$i][5])
			{
				//取C盘
				$LdetListc[$i][5] = $cList;
				updateTuiShui ($db, $LdetListc[$i], $usersModel, 'c', $cList);
			}
			
			//修改退水
			$sql = "UPDATE `g_send_back` SET `g_a_limit` = '{$aList}', `g_b_limit` = '{$bList}', `g_c_limit` = '{$cList}', `g_d_limit` = '{$dList}', `g_e_limit` = '{$eList}'
			WHERE `g_name` = '{$usersModel[0]['g_name']}' AND g_type = '{$LdetListc[$i][2]}' AND g_game_id = '{$LdetListc[$i][8]}' LIMIT 1";
			$db->query($sql, 2);
			
		}
		
		//农场
		$LdetListx = $db->query("SELECT `g_id`, `g_name`, `g_type`, `g_a_limit`, g_b_limit, g_c_limit,  `g_d_limit`, `g_e_limit`, `g_game_id` 
		FROM `g_send_back` WHERE g_name = '{$Lname[0]['g_name']}' and g_game_id = '5'  ORDER BY g_id DESC", 0);
		
		//dump($LdetListc);
		
	     for ($i=0; $i<count($LdetListx); $i++) {
			$aList = $_POST['RebateAX'.($i+1)];
			$bList = $_POST['RebateBX'.($i+1)];
			$cList = $_POST['RebateCX'.($i+1)];
			$dList = $_POST['RebateEX'.($i+1)];
			$eList = $_POST['RebateFX'.($i+1)];
			if ($aList > 100) exit(back(' 退水最高不超过：100'));
			if ($bList > 100) exit(back(' 退水最高不超过：100'));
			if ($cList > 100) exit(back(' 退水最高不超过：100'));

        	if ($aList > $LdetListx[$i][3])
			{
				//取A盘
				$LdetListx[$i][3] = $aList;
				updateTuiShui ($db, $LdetListx[$i], $usersModel, 'a', $aList);
			} 
			if ($bList > $LdetListx[$i][4])
			{
				//取B盘
				$LdetListx[$i][4] = $bList;
				updateTuiShui ($db, $LdetListx[$i], $usersModel, 'b', $bList);
			} 
			if ($cList > $LdetListx[$i][5])
			{
				//取C盘
				$LdetListx[$i][5] = $cList;
				updateTuiShui ($db, $LdetListx[$i], $usersModel, 'c', $cList);
			}
			
			//修改退水
			$sql = "UPDATE `g_send_back` SET `g_a_limit` = '{$aList}', `g_b_limit` = '{$bList}', `g_c_limit` = '{$cList}', `g_d_limit` = '{$dList}', `g_e_limit` = '{$eList}'
			WHERE `g_name` = '{$usersModel[0]['g_name']}' AND g_type = '{$LdetListx[$i][2]}' AND g_game_id = '{$LdetListx[$i][8]}' LIMIT 1";
			$db->query($sql, 2);
			
		}
		
		
		//北京
			$LdetListb = $db->query("SELECT `g_id`, `g_name`, `g_type`, `g_a_limit`, g_b_limit, g_c_limit,  `g_d_limit`, `g_e_limit`, `g_game_id` 
		FROM `g_send_back` WHERE g_name = '{$Lname[0]['g_name']}' and g_game_id = '6'  ORDER BY g_id DESC", 0);
		
	//	dump($LdetList);
		
	     for ($i=0; $i<count($LdetListb); $i++) {
			$aList = $_POST['RebateAB'.($i+1)];
			$bList = $_POST['RebateBB'.($i+1)];
			$cList = $_POST['RebateCB'.($i+1)];
			$dList = $_POST['RebateEB'.($i+1)];
			$eList = $_POST['RebateFB'.($i+1)];
			if ($aList > 100) exit(back(' 退水最高不超过：100'));
			if ($bList > 100) exit(back(' 退水最高不超过：100'));
			if ($cList > 100) exit(back(' 退水最高不超过：100'));

        	if ($aList > $LdetListb[$i][3])
			{
				//取A盘
				$LdetListb[$i][3] = $aList;
				updateTuiShui ($db, $LdetListb[$i], $usersModel, 'a', $aList);
			} 
			if ($bList > $LdetListb[$i][4])
			{
				//取B盘
				$LdetListb[$i][4] = $bList;
				updateTuiShui ($db, $LdetListb[$i], $usersModel, 'b', $bList);
			} 
			if ($cList > $LdetListb[$i][5])
			{
				//取C盘
				$LdetListb[$i][5] = $cList;
				updateTuiShui ($db, $LdetListb[$i], $usersModel, 'c', $cList);
			}
			
			//修改退水
			$sql = "UPDATE `g_send_back` SET `g_a_limit` = '{$aList}', `g_b_limit` = '{$bList}', `g_c_limit` = '{$cList}', `g_d_limit` = '{$dList}', `g_e_limit` = '{$eList}'
			WHERE `g_name` = '{$usersModel[0]['g_name']}' AND g_type = '{$LdetListb[$i][2]}' AND g_game_id = '{$LdetListb[$i][8]}' LIMIT 1";
			$db->query($sql, 2);
			
		}
		
		//江苏	
		$LdetListj = $db->query("SELECT `g_id`, `g_name`, `g_type`, `g_a_limit`, g_b_limit, g_c_limit,  `g_d_limit`, `g_e_limit`, `g_game_id` 
		FROM `g_send_back` WHERE g_name = '{$Lname[0]['g_name']}' and g_game_id = '7'  ORDER BY g_id DESC", 0);
		
	//	dump($LdetList);
		
	     for ($i=0; $i<count($LdetListj); $i++) {
			$aList = $_POST['RebateAJ'.($i+1)];
			$bList = $_POST['RebateBJ'.($i+1)];
			$cList = $_POST['RebateCJ'.($i+1)];
			$dList = $_POST['RebateEJ'.($i+1)];
			$eList = $_POST['RebateFJ'.($i+1)];
			if ($aList > 100) exit(back(' 退水最高不超过：100'));
			if ($bList > 100) exit(back(' 退水最高不超过：100'));
			if ($cList > 100) exit(back(' 退水最高不超过：100'));

        	if ($aList > $LdetListj[$i][3])
			{
				//取A盘
				$LdetListj[$i][3] = $aList;
				updateTuiShui ($db, $LdetListj[$i], $usersModel, 'a', $aList);
			} 
			if ($bList > $LdetListj[$i][4])
			{
				//取B盘
				$LdetListj[$i][4] = $bList;
				updateTuiShui ($db, $LdetListj[$i], $usersModel, 'b', $bList);
			} 
			if ($cList > $LdetListj[$i][5])
			{
				//取C盘
				$LdetListj[$i][5] = $cList;
				updateTuiShui ($db, $LdetListj[$i], $usersModel, 'c', $cList);
			}
			
			//修改退水
			$sql = "UPDATE `g_send_back` SET `g_a_limit` = '{$aList}', `g_b_limit` = '{$bList}', `g_c_limit` = '{$cList}', `g_d_limit` = '{$dList}', `g_e_limit` = '{$eList}'
			WHERE `g_name` = '{$usersModel[0]['g_name']}' AND g_type = '{$LdetListj[$i][2]}' AND g_game_id = '{$LdetListj[$i][8]}' LIMIT 1";
			$db->query($sql, 2);
			
		}
		
		exit(alert_href('更變成功', 'Actfor.php?cid='.$_GET['cid']));
	}
	else 
	{
		exit(alert_href('用戶不存在', 'Actfor.php?cid='.$_GET['cid']));
	}
}
else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['uid']) && isset($_GET['cid']))
{
	if (!Matchs::isString($_GET['uid'], 3, 15)) exit(alert_href('用戶名不合法', 'Actfor.php?cid='.$_GET['cid']));
	$cid = $_GET['cid'];
	$uid = $_GET['uid'];
	
	$user = $userModel->GetUserModel(null, $uid);
	//$count = $userModel->SumCount($user[0]['g_nid'].UserModel::Like());
	$dateTime = date('Y-m-d H:i:s');
	$a = day();
	$stratGame = $a[0];
	$endGame = $a[1];
	$date = " `g_date` > '{$stratGame}' AND `g_date` < '{$endGame}' ";
	$db = new DB();
	if (!$db->query("SELECT g_id FROM g_zhudan WHERE {$date} AND g_s_nid LIKE '{$user[0]['g_nid']}%' LIMIT 1", 0)){
		$count = 0;
	} else {
		$count = 1;
	}
    $Lname = mb_substr($user[0]['g_nid'], 0, mb_strlen($user[0]['g_nid'])-32);
	$Lname = $userModel->GetUserName_Like($Lname);
	//dump($Lname[0]['g_name']);
	//讀取退水
	
	
	$result = $userModel->GetUserMR($uid);
	$resultC = $userModel->GetUserMRC($uid);
	$resultP = $userModel->GetUserMRP($uid);
	$resultJ = $userModel->GetUserMRJ($uid);
	$resultX = $userModel->GetUserMRX($uid);
	if ($user[0]['g_login_id']==56){
	$resultsj=$userModel->GetUserMRSJ(1);
	$resultsjC=$userModel->GetUserMRSJ(2);
	$resultsjP=$userModel->GetUserMRSJ(6);
	$resultsjJ=$userModel->GetUserMRSJ(7);
	$resultsjX=$userModel->GetUserMRSJ(5);
	}else{
	
	$Lname = mb_substr($user[0]['g_nid'], 0, mb_strlen($user[0]['g_nid'])-32);
	$Lname = $userModel->GetUserName_Like($Lname);
	$sjuid=$Lname[0]['g_name'];
	
	$resultsj = $userModel->GetUserMR($sjuid);
	$resultsjC = $userModel->GetUserMRC($sjuid);
	$resultsjP = $userModel->GetUserMRP($sjuid);
	$resultsjJ = $userModel->GetUserMRJ($sjuid);
	$resultsjX = $userModel->GetUserMRX($sjuid);
	
	
	
	}
	//dump($resultsjJ);
	if (!$result)exit(alert_href('無法讀取退水設置！請于上級聯繫', "Actfor.php?cid={$cid}"));
}

function updateTuiShui ($db, $LdetList, $usersModel, $p, $param){
	if ($usersModel[0]['g_login_id'] != 48) {
		$sql = "SELECT `g_name` FROM g_rank WHERE g_nid LIKE '{$usersModel[0]['g_nid']}%'";
		$result = $db->query($sql, 1);
		if ($result) {
			for ($i=0; $i<count($result); $i++){
				$sql = "UPDATE `g_send_back` SET g_a_limit='{$LdetList[3]}', g_b_limit='{$LdetList[4]}', g_c_limit='{$LdetList[5]}'
				WHERE g_name = '{$result[$i]['g_name']}' 
				AND  g_type='{$LdetList[2]}'
				AND g_game_id = '{$LdetList[8]}' 
				AND (g_a_limit < '{$LdetList[3]}' OR g_b_limit <'{$LdetList[4]}' OR g_c_limit <'{$LdetList[5]}') LIMIT 1 ";
				$db->query($sql, 2);
			}
		}
	}
	
	$sql = "SELECT u.g_name, p.* FROM `g_user` AS u 
				INNER JOIN g_panbiao as p ON u.g_name = p.g_nid
				WHERE u.g_nid LIKE '{$usersModel[0]['g_nid']}%'
				AND p.g_game_id = '{$LdetList[8]}' 
				AND p.g_type = '{$LdetList[2]}' AND u.g_panlu = '{$p}'";
	$result = $db->query($sql, 1);
	
	if ($result) {
		for ($i=0; $i<count($result); $i++){
		if($p=="a"){
		$parm="g_panlu_a";
		}
		if($p=="b"){
		$parm="g_panlu_b";
		}
		if($p=="c"){
		$parm="g_panlu_c";
		}
			$sql = "UPDATE `g_panbiao` SET {$parm}='{$param}' WHERE g_nid = '{$result[$i]['g_name']}' 
			AND  g_type='{$LdetList[2]}'
			AND g_game_id = '{$LdetList[8]}' LIMIT 1 ";
			$db->query($sql, 2);
		}
	}
}
?><!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Admin/temp/Css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
-->

<html>
<head><title>

</title><link href="/Css/Common.css" rel="stylesheet" type="text/css" /><link href="/Css/Style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Scripts/Jquery.js"></script>
<script type="text/javascript" src="/Scripts/Common.js"></script>

<script type="text/javascript" src="/Scripts/PublicData.js"></script>
<script type="text/javascript" src="/Scripts/Forbid.js"></script>
<script type="text/javascript">
<!--
    $(function(){
        $("#TS1_A1").val($("#RebateAG1").val());
        $("#TS1_A2").val($("#RebateBG1").val());
        $("#TS1_A3").val($("#RebateCG1").val());
        $("#TS1_A4").val($("#RebateEG1").val());
        $("#TS1_A5").val($("#RebateFG1").val());

        $("#TS2_A1").val($("#RebateAG9").val());
        $("#TS2_A2").val($("#RebateBG9").val());
        $("#TS2_A3").val($("#RebateCG9").val());
        $("#TS2_A4").val($("#RebateEG9").val());
        $("#TS2_A5").val($("#RebateFG9").val());

        $("#TS3_A1").val($("#RebateAG19").val());
        $("#TS3_A2").val($("#RebateBG19").val());
        $("#TS3_A3").val($("#RebateCG19").val());
        $("#TS3_A4").val($("#RebateEG19").val());
        $("#TS3_A5").val($("#RebateFG19").val());
        
    });
    function isCompare(obj, s, v, sint, className) {
        var sR = document.getElementById("s" + obj.id).value;
        if (!Base.patrn.Decimal.exec(obj.value) || parseFloat(obj.value) < parseFloat(sR)) {
            $(".input2").attr("disabled", "disabled");
            alert(s + " " + v + " 限制退水設置：" + sR);
            obj.focus();
            return false;
        } else if (parseFloat(obj.value) > 100) {
            $(".input2").attr("disabled", "disabled");
            alert(s + " " + v + " 退水設置已超出限定：100%");
            obj.focus();
            return false;
        } else {
            $(".input2").attr("disabled", "");
        }
        if (sint != undefined && className != undefined) {
            if (sint == 1) {
                $("." + className).val(obj.value);
            } 
        }
    }

    function isCompares(obj, s, v, sint, className) {
        var sR = document.getElementById("s" + obj.id).value;
        if (!Base.patrn.Decimal.exec(obj.value) || parseFloat(obj.value) > parseFloat(sR)) {
            $(".input2").attr("disabled", "disabled");
            alert(s + " " + v + " 設置最大值：" + sR);
            obj.focus();
            return false;
        } else {
            $(".input2").attr("disabled", "");
        }
        if (sint == 1) {
            $("." + className).val(obj.value);
        }
    }

    function showTD(strID, classID) {
        $("."+classID).css("display", "none");
        $("#"+strID).css("display", "");
    }

    function isMethod() {
        if (confirm("確定更改退水設置嗎？")) {
            $("#submit").attr("disabled","disabled");
            return true;
        }
        return false;
    }
    function Comparec() {
        var A = parseFloat($("#TS3_A1").val());
        var B = parseFloat($("#TS3_A2").val());
        var C = parseFloat($("#TS3_A3").val());
        var E = parseInt($("#TS3_A4").val());
        var F = parseInt($("#TS3_A5").val());
        for (var i = 1; i <= 26; i++) {
            if (i == 3 || i == 5|| i==6 || i==7 ) {
                $("#RebateAJ"+i).val(A > parseFloat($("#sRebateAJ"+i).val()) ? A : $("#sRebateAJ"+i).val()).addClass("inp1m");
                $("#RebateBJ"+i).val(B > parseFloat($("#sRebateBJ"+i).val()) ? B : $("#sRebateBJ"+i).val()).addClass("inp1m");
                $("#RebateCJ"+i).val(C > parseFloat($("#sRebateCJ"+i).val()) ? C : $("#sRebateCJ"+i).val()).addClass("inp1m");
                $("#RebateEJ"+i).val(E < parseFloat($("#sRebateEJ"+i).val()) ? E : $("#sRebateEJ"+i).val()).addClass("inp1m");
                $("#RebateFJ"+i).val(F < parseFloat($("#sRebateFJ"+i).val()) ? F : $("#sRebateFJ"+i).val()).addClass("inp1m");
            } else if (i >= 19) {
                $("#RebateAG"+i).val(A > parseFloat($("#sRebateAG"+i).val()) ? A : $("#sRebateAG"+i).val()).addClass("inp1m");
                $("#RebateBG"+i).val(B > parseFloat($("#sRebateBG"+i).val()) ? B : $("#sRebateBG"+i).val()).addClass("inp1m");
                $("#RebateCG"+i).val(C > parseFloat($("#sRebateCG"+i).val()) ? C : $("#sRebateCG"+i).val()).addClass("inp1m");
                $("#RebateEG"+i).val(E < parseFloat($("#sRebateEG"+i).val()) ? E : $("#sRebateEG"+i).val()).addClass("inp1m");
                $("#RebateFG"+i).val(F < parseFloat($("#sRebateFG"+i).val()) ? F : $("#sRebateFG"+i).val()).addClass("inp1m");
				
				$("#RebateAX"+i).val(A > parseFloat($("#sRebateAX"+i).val()) ? A : $("#sRebateAX"+i).val()).addClass("inp1m");
                $("#RebateBX"+i).val(B > parseFloat($("#sRebateBX"+i).val()) ? B : $("#sRebateBX"+i).val()).addClass("inp1m");
                $("#RebateCX"+i).val(C > parseFloat($("#sRebateCX"+i).val()) ? C : $("#sRebateCX"+i).val()).addClass("inp1m");
                $("#RebateEX"+i).val(E < parseFloat($("#sRebateEX"+i).val()) ? E : $("#sRebateEX"+i).val()).addClass("inp1m");
                $("#RebateFX"+i).val(F < parseFloat($("#sRebateFX"+i).val()) ? F : $("#sRebateFX"+i).val()).addClass("inp1m");
            }
        }
    }
    function Compareb() {
        var A = parseFloat($("#TS2_A1").val());
        var B = parseFloat($("#TS2_A2").val());
        var C = parseFloat($("#TS2_A3").val());
        var E = parseInt($("#TS2_A4").val());
        var F = parseInt($("#TS2_A5").val());
        for (var i = 1; i <= 31; i++) {
            if (i == 1 || i == 2) {
                $("#RebateAJ"+i).val(A > parseFloat($("#sRebateAJ"+i).val()) ? A : $("#sRebateAJ"+i).val()).addClass("inp1m");
                $("#RebateBJ"+i).val(B > parseFloat($("#sRebateBJ"+i).val()) ? B : $("#sRebateBJ"+i).val()).addClass("inp1m");
                $("#RebateCJ"+i).val(C > parseFloat($("#sRebateCJ"+i).val()) ? C : $("#sRebateCJ"+i).val()).addClass("inp1m");
                $("#RebateEJ"+i).val(E < parseFloat($("#sRebateEJ"+i).val()) ? E : $("#sRebateEJ"+i).val()).addClass("inp1m");
                $("#RebateFJ"+i).val(F < parseFloat($("#sRebateFJ"+i).val()) ? F : $("#sRebateFJ"+i).val()).addClass("inp1m");
            }
            if (i == 11 || i == 12 || i == 13 || i == 14 || i == 15) {
                $("#RebateAB"+i).val(A > parseFloat($("#sRebateAB"+i).val()) ? A : $("#sRebateAB"+i).val()).addClass("inp1m");
                $("#RebateBB"+i).val(B > parseFloat($("#sRebateBB"+i).val()) ? B : $("#sRebateBB"+i).val()).addClass("inp1m");
                $("#RebateCB"+i).val(C > parseFloat($("#sRebateCB"+i).val()) ? C : $("#sRebateCB"+i).val()).addClass("inp1m");
                $("#RebateEB"+i).val(E < parseFloat($("#sRebateEB"+i).val()) ? E : $("#sRebateEB"+i).val()).addClass("inp1m");
                $("#RebateFB"+i).val(F < parseFloat($("#sRebateFB"+i).val()) ? F : $("#sRebateFB"+i).val()).addClass("inp1m");
            }
            if (i >= 6 && i <= 8) {
                $("#RebateAC"+i).val(A > parseFloat($("#sRebateAC"+i).val()) ? A : $("#sRebateAC"+i).val()).addClass("inp1m");
                $("#RebateBC"+i).val(B > parseFloat($("#sRebateBC"+i).val()) ? B : $("#sRebateBC"+i).val()).addClass("inp1m");
                $("#RebateCC"+i).val(C > parseFloat($("#sRebateCC"+i).val()) ? C : $("#sRebateCC"+i).val()).addClass("inp1m");
                $("#RebateEC"+i).val(E < parseFloat($("#sRebateEC"+i).val()) ? E : $("#sRebateEC"+i).val()).addClass("inp1m");
                $("#RebateFC"+i).val(F < parseFloat($("#sRebateFC"+i).val()) ? F : $("#sRebateFC"+i).val()).addClass("inp1m");
            }else if (i >= 9 && i <= 12 || i >= 15 && i <= 18 || i >= 27 && i <=31 ) {
                $("#RebateAG"+i).val(A > parseFloat($("#sRebateAG"+i).val()) ? A : $("#sRebateAG"+i).val()).addClass("inp1m");
                $("#RebateBG"+i).val(B > parseFloat($("#sRebateBG"+i).val()) ? B : $("#sRebateBG"+i).val()).addClass("inp1m");
                $("#RebateCG"+i).val(C > parseFloat($("#sRebateCG"+i).val()) ? C : $("#sRebateCG"+i).val()).addClass("inp1m");
                $("#RebateEG"+i).val(E < parseFloat($("#sRebateEG"+i).val()) ? E : $("#sRebateEG"+i).val()).addClass("inp1m");
                $("#RebateFG"+i).val(F < parseFloat($("#sRebateFG"+i).val()) ? F : $("#sRebateFG"+i).val()).addClass("inp1m");
				
				$("#RebateAX"+i).val(A > parseFloat($("#sRebateAX"+i).val()) ? A : $("#sRebateAX"+i).val()).addClass("inp1m");
                $("#RebateBX"+i).val(B > parseFloat($("#sRebateBX"+i).val()) ? B : $("#sRebateBX"+i).val()).addClass("inp1m");
                $("#RebateCX"+i).val(C > parseFloat($("#sRebateCX"+i).val()) ? C : $("#sRebateCX"+i).val()).addClass("inp1m");
                $("#RebateEX"+i).val(E < parseFloat($("#sRebateEX"+i).val()) ? E : $("#sRebateEX"+i).val()).addClass("inp1m");
                $("#RebateFX"+i).val(F < parseFloat($("#sRebateFX"+i).val()) ? F : $("#sRebateFX"+i).val()).addClass("inp1m");
                if ( i== 9 || i == 10) {
                    $("#RebateAC"+i).val(A > parseFloat($("#sRebateAC"+i).val()) ? A : $("#sRebateAC"+i).val()).addClass("inp1m");
                    $("#RebateBC"+i).val(B > parseFloat($("#sRebateBC"+i).val()) ? B : $("#sRebateBC"+i).val()).addClass("inp1m");
                    $("#RebateCC"+i).val(C > parseFloat($("#sRebateCC"+i).val()) ? C : $("#sRebateCC"+i).val()).addClass("inp1m");
                    $("#RebateEC"+i).val(E < parseFloat($("#sRebateEC"+i).val()) ? E : $("#sRebateEC"+i).val()).addClass("inp1m");
                    $("#RebateFC"+i).val(F < parseFloat($("#sRebateFC"+i).val()) ? F : $("#sRebateFC"+i).val()).addClass("inp1m");
                }
            }
        }
    }

    function Comparer() {
        var A = parseFloat($("#TS1_A1").val());
        var B = parseFloat($("#TS1_A2").val());
        var C = parseFloat($("#TS1_A3").val());
        var E = parseInt($("#TS1_A4").val());
        var F = parseInt($("#TS1_A5").val());
        for (var i = 1; i <= 10; i++) {
                if (i <= 8) {
                    if (i <= 5) {
                    $("#RebateAC"+i).val(A > parseFloat($("#sRebateAC"+i).val()) ? A : $("#sRebateAC"+i).val()).addClass("inp1m");
                    $("#RebateBC"+i).val(B > parseFloat($("#sRebateBC"+i).val()) ? B : $("#sRebateBC"+i).val()).addClass("inp1m");
                    $("#RebateCC"+i).val(C > parseFloat($("#sRebateCC"+i).val()) ? C : $("#sRebateCC"+i).val()).addClass("inp1m");
                    $("#RebateEC"+i).val(E < parseFloat($("#sRebateEC"+i).val()) ? E : $("#sRebateEC"+i).val()).addClass("inp1m");
                    $("#RebateFC"+i).val(F < parseFloat($("#sRebateFC"+i).val()) ? F : $("#sRebateFC"+i).val()).addClass("inp1m");
                }
                $("#RebateAG"+i).val(A > parseFloat($("#sRebateAG"+i).val()) ? A : $("#sRebateAG"+i).val()).addClass("inp1m");
                $("#RebateBG"+i).val(B > parseFloat($("#sRebateBG"+i).val()) ? B : $("#sRebateBG"+i).val()).addClass("inp1m");
                $("#RebateCG"+i).val(C > parseFloat($("#sRebateCG"+i).val()) ? C : $("#sRebateCG"+i).val()).addClass("inp1m");
                $("#RebateEG"+i).val(E < parseFloat($("#sRebateEG"+i).val()) ? E : $("#sRebateEG"+i).val()).addClass("inp1m");
                $("#RebateFG"+i).val(F < parseFloat($("#sRebateFG"+i).val()) ? F : $("#sRebateFG"+i).val()).addClass("inp1m");
				
				$("#RebateAX"+i).val(A > parseFloat($("#sRebateAX"+i).val()) ? A : $("#sRebateAX"+i).val()).addClass("inp1m");
                $("#RebateBX"+i).val(B > parseFloat($("#sRebateBX"+i).val()) ? B : $("#sRebateBX"+i).val()).addClass("inp1m");
                $("#RebateCX"+i).val(C > parseFloat($("#sRebateCX"+i).val()) ? C : $("#sRebateCX"+i).val()).addClass("inp1m");
                $("#RebateEX"+i).val(E < parseFloat($("#sRebateEX"+i).val()) ? E : $("#sRebateEX"+i).val()).addClass("inp1m");
                $("#RebateFX"+i).val(F < parseFloat($("#sRebateFX"+i).val()) ? F : $("#sRebateFX"+i).val()).addClass("inp1m");
            }

            $("#RebateAB"+i).val(A > parseFloat($("#sRebateAB"+i).val()) ? A : $("#sRebateAB"+i).val()).addClass("inp1m");
            $("#RebateBB"+i).val(B > parseFloat($("#sRebateBB"+i).val()) ? B : $("#sRebateBB"+i).val()).addClass("inp1m");
            $("#RebateCB"+i).val(C > parseFloat($("#sRebateCB"+i).val()) ? C : $("#sRebateCB"+i).val()).addClass("inp1m");
            $("#RebateEB"+i).val(E < parseFloat($("#sRebateEB"+i).val()) ? E : $("#sRebateEB"+i).val()).addClass("inp1m");
            $("#RebateFB"+i).val(F < parseFloat($("#sRebateFB"+i).val()) ? F : $("#sRebateFB"+i).val()).addClass("inp1m");
        }
    }
    function historys() {
        location.href = "Actfor.php?cid=<?php echo $_GET['cid']?>";
    }
//-->
</script>
</head>
<body onselectstart="return false">

<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" cellpadding="0" class="Main m_1">
    <tr>
        <td width="12"><img src="/SystemControl/ActionLib/images/tab_03.gif" alt="" /></td>
         <td background="/SystemControl/ActionLib/images/tab_05.gif">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="20" align="right"><img style="margin-right:5px" src="/Css/tb.gif" width="16" height="16" alt="" /></td>
                    <td id="titleName" class="Main_Title">退水設定 -><?php if ($cid==1){echo "分公司";}else  if ($cid==2){echo "股东";}else  if ($cid==3){echo "總代理";}else {echo "代理";}?>（ &nbsp;&nbsp;&nbsp;<span style="font-weight:normal"><?php echo$uid?></span>&nbsp;&nbsp;&nbsp; ）</td>

                    <td id="F_Name" width="150" align="right"><?php if ($cid==1){echo "分公司";}else  if ($cid==2){echo "股东";}else  if ($cid==3){echo "總代理";}else {echo "代理";}?>名稱：<?php echo$uid?></td>

                </tr>
            </table>
        </td>
        <td width="16"><img src="/SystemControl/ActionLib/images/tab_07.gif" alt="" /></td>
    </tr>
    <tr>
        <td class="Main_left"></td>
        <td class="Main_conter">
        <!-- strat -->
            <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter2 az">
                <tr class="Conter_top_2">
                    <th colspan="7" background="/Css/bg_g.jpg" style="border:none">大項快速設置【注意：設置高於上級最高限制時按最高可調】</th>
                </tr>
                <tr class="Conter_top_2 Ct">
                    <td width="34%"  background="/Css/bg_g.jpg" >調整項目</td>
                    <td width="10%"  background="/Css/bg_g.jpg" >A盤</td>
                    <td width="10%"  background="/Css/bg_g.jpg" >B盤</td>
                    <td width="10%"  background="/Css/bg_g.jpg" >C盤</td>
                    <td  background="/Css/bg_g.jpg" >單註限額</td>
                    <td  background="/Css/bg_g.jpg" >單期限額</td>
                    <td width="80"  background="/Css/bg_g.jpg" >…</td>
                </tr>
                <tr class="Ct" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                    <td class="t_list_tr_1_g">特碼類(第一球、第二球、冠軍 …)</td>
                    <td class="TD_TS1"><input style="width:60px;" id="TS1_A1" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:60px;" id="TS1_A2" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:60px;" id="TS1_A3" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:90px;" id="TS1_A4" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:90px;" id="TS1_A5" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td class="TD_TS1"><input type="button" onMouseOver="this.className='input2_2'" onMouseOut="this.className='input2'" class="input2" onClick="Comparer()" value="修改" /></td>
                </tr>
                <tr class="Ct" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                    <td class="t_list_tr_1_g">兩面類(單雙、大小、龍虎 …)</td>
                    <td class="TD_TS2"><input style="width:60px;" id="TS2_A1" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:60px;" id="TS2_A2" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:60px;" id="TS2_A3" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:90px;" id="TS2_A4" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:90px;" id="TS2_A5" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td class="TD_TS2"><input type="button" name="submit" onMouseOver="this.className='input2_2'" onMouseOut="this.className='input2'" class="input2" onClick="Compareb()" value="修改" /></td>
                </tr>
                <tr class="Ct" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                    <td class="t_list_tr_1_g">連碼類(任選二、任選三 …)</td>
                    <td class="TD_TS3"><input style="width:60px;" id="TS3_A1" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:60px;" id="TS3_A2" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:60px;" id="TS3_A3" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:90px;" id="TS3_A4" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:90px;" id="TS3_A5" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td class="TD_TS3"><input type="button" name="submit" onMouseOver="this.className='input2_2'" onMouseOut="this.className='input2'" class="input2" onClick="Comparec()" value="修改" /></td>
                </tr>
            </table>
	<form action="" method="post" onSubmit="return isMethod()">
<input type="hidden" name="name" value="<?php echo$uid?>" />



            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <th style="border:none">廣東快樂十分</th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <td>交易類型</td>
                                <td>A盤</td>
                                <td>B盤</td>
                                <td>C盤</td>
                                <td>單註限額</td>
                                <td>單期限額</td>
                            </tr>
                   <?php for ($i=0;$i<1;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $result[$i]['g_type']?><input type="hidden" name="G<?php echo $i+1;?>" id="G<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAG<?php echo $i+1;?>" id="RebateAG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'A盤', '1', 'ga')" 
                                    value='<?php echo $result[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAG<?php echo $i+1;?>" id="sRebateAG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBG<?php echo $i+1;?>" id="RebateBG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'B盤', '1', 'gb')" 
                                    value='<?php echo $result[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBG<?php echo $i+1;?>" id="sRebateBG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCG1" id="RebateCG1"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'C盤', '1', 'gc')" 
                                    value='<?php echo $result[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCG<?php echo $i+1;?>" id="sRebateCG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEG<?php echo $i+1;?>" id="RebateEG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單註限額', '1', 'ge')"
                                    value='<?php echo $result[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG1" id="sRebateEG1" value="<?php echo $resultsj[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFG1" id="RebateFG1"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單期限額', '1', 'gf')"
                                    value='<?php echo $result[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG1" id="sRebateFG1" value="<?php echo $resultsj[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php }   ?>   
                            <?php for ($i=1;$i<8;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $result[$i]['g_type']?><input type="hidden" name="G<?php echo $i+1;?>" id="G<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAG<?php echo $i+1;?>" id="RebateAG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $result[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAG<?php echo $i+1;?>" id="sRebateAG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBG<?php echo $i+1;?>" id="RebateBG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $result[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBG<?php echo $i+1;?>" id="sRebateBG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCG<?php echo $i+1;?>" id="RebateCG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $result[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCG<?php echo $i+1;?>" id="sRebateCG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEG<?php echo $i+1;?>" id="RebateEG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $result[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateEG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFG<?php echo $i+1;?>" id="RebateFG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $result[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateFG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                        <?php for ($i=8;$i<12;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $result[$i]['g_type']?><input type="hidden" name="G<?php echo $i+1;?>" id="G<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAG<?php echo $i+1;?>" id="RebateAG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $result[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAG<?php echo $i+1;?>" id="sRebateAG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBG<?php echo $i+1;?>" id="RebateBG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $result[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBG<?php echo $i+1;?>" id="sRebateBG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCG<?php echo $i+1;?>" id="RebateCG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $result[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCG<?php echo $i+1;?>" id="sRebateCG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEG<?php echo $i+1;?>" id="RebateEG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $result[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateEG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFG<?php echo $i+1;?>" id="RebateFG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $result[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateFG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                      
                       
                          <?php for ($i=14;$i<18;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $result[$i]['g_type']?><input type="hidden" name="G<?php echo $i+1;?>" id="G<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAG<?php echo $i+1;?>" id="RebateAG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $result[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAG<?php echo $i+1;?>" id="sRebateAG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBG<?php echo $i+1;?>" id="RebateBG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $result[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBG<?php echo $i+1;?>" id="sRebateBG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCG<?php echo $i+1;?>" id="RebateCG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $result[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCG<?php echo $i+1;?>" id="sRebateCG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEG<?php echo $i+1;?>" id="RebateEG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $result[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateEG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFG<?php echo $i+1;?>" id="RebateFG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $result[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateFG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
					  </table>
                    </td>
                  <td valign="top">
                        <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <td>交易類型</td>
                                <td>A盤</td>
                                <td>B盤</td>
                                <td>C盤</td>
                                <td>單註限額</td>
                                <td>單期限額</td>
                            </tr>
							
                            <?php for ($i=18;$i<26;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS3"><?php echo $result[$i]['g_type']?><input type="hidden" name="G<?php echo $i+1;?>" id="G<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAG<?php echo $i+1;?>" id="RebateAG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $result[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAG<?php echo $i+1;?>" id="sRebateAG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_a_limit'];?>" />                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBG<?php echo $i+1;?>" id="RebateBG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $result[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBG<?php echo $i+1;?>" id="sRebateBG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_b_limit'];?>" />                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCG<?php echo $i+1;?>" id="RebateCG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $result[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCG<?php echo $i+1;?>" id="sRebateCG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_c_limit'];?>" />                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEG<?php echo $i+1;?>" id="RebateEG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $result[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateEG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_d_limit'];?>" />                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFG<?php echo $i+1;?>" id="RebateFG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $result[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateFG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_e_limit'];?>" />                                </td>
                            </tr>
                      <?php  } ?>   
                            <?php for ($i=26;$i<31;$i++){?>
                           <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $result[$i]['g_type']?><input type="hidden" name="G<?php echo $i+1;?>" id="G<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAG<?php echo $i+1;?>" id="RebateAG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $result[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAG<?php echo $i+1;?>" id="sRebateAG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_a_limit'];?>" />                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBG<?php echo $i+1;?>" id="RebateBG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $result[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBG<?php echo $i+1;?>" id="sRebateBG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_b_limit'];?>" />                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCG<?php echo $i+1;?>" id="RebateCG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $result[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCG<?php echo $i+1;?>" id="sRebateCG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_c_limit'];?>" />                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEG<?php echo $i+1;?>" id="RebateEG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $result[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateEG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_d_limit'];?>" />                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFG<?php echo $i+1;?>" id="RebateFG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $result[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateFG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_e_limit'];?>" />                                </td>
                          </tr>
                      <?php  } ?>   
					  
					   <?php for ($i=12;$i<14;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS4"><?php echo $result[$i]['g_type']?><input type="hidden" name="G<?php echo $i+1;?>" id="G<?php echo $i+1;?>" value="232025" /></td>
                                <td><input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAG<?php echo $i+1;?>" id="RebateAG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $result[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAG<?php echo $i+1;?>" id="sRebateAG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_a_limit'];?>" />                              </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBG<?php echo $i+1;?>" id="RebateBG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $result[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBG<?php echo $i+1;?>" id="sRebateBG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_b_limit'];?>" />                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCG<?php echo $i+1;?>" id="RebateCG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $result[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $result[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCG<?php echo $i+1;?>" id="sRebateCG<?php echo $i+1;?>" 
                                    value="<?php echo $resultsj[$i]['g_c_limit'];?>" />                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEG<?php echo $i+1;?>" id="RebateEG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $result[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateEG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_d_limit'];?>" />                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFG<?php echo $i+1;?>" id="RebateFG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $result[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $result[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateFG<?php echo $i+1;?>" value="<?php echo $resultsj[$i]['g_e_limit'];?>" />                                </td>
                            </tr>
                      <?php  } ?>   
                        </table>
                        <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $result[$i]['g_a_limit'];?></span></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <th style="border:none">重慶時時彩</th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            
                                 <?php for ($i=0;$i<1;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $resultC[$i]['g_type']?><input type="hidden" name="C<?php echo $i+1;?>" id="C<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAC<?php echo $i+1;?>" id="RebateAC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'A盤', '1', 'ca')" 
                                    value='<?php echo $resultC[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAC<?php echo $i+1;?>" id="sRebateAC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBC<?php echo $i+1;?>" id="RebateBC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'B盤', '1', 'cb')" 
                                    value='<?php echo $resultC[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBC<?php echo $i+1;?>" id="sRebateBC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCC<?php echo $i+1;?>" id="RebateCC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'C盤', '1', 'cc')" 
                                    value='<?php echo $resultC[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCC<?php echo $i+1;?>" id="sRebateCC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEC<?php echo $i+1;?>" id="RebateEC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultC[$i]['g_type']?>', '單註限額', '1', 'ce')"
                                    value='<?php echo $resultC[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateEC<?php echo $i+1;?>" value="<?php echo $resultsjC[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFC<?php echo $i+1;?>" id="RebateFC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultC[$i]['g_type']?>', '單期限額', '1', 'cf')"
                                    value='<?php echo $resultC[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateFC<?php echo $i+1;?>" value="<?php echo $resultsjC[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                         <?php for ($i=1;$i<5;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $resultC[$i]['g_type']?><input type="hidden" name="C<?php echo $i+1;?>" id="C<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAC<?php echo $i+1;?>" id="RebateAC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'A盤', '0', 'ca')" 
                                    value='<?php echo $resultC[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAC<?php echo $i+1;?>" id="sRebateAC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBC<?php echo $i+1;?>" id="RebateBC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'B盤', '0', 'cb')" 
                                    value='<?php echo $resultC[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBC<?php echo $i+1;?>" id="sRebateBC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCC<?php echo $i+1;?>" id="RebateCC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'C盤', '0', 'cc')" 
                                    value='<?php echo $resultC[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCC<?php echo $i+1;?>" id="sRebateCC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEC<?php echo $i+1;?>" id="RebateEC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultC[$i]['g_type']?>', '單註限額', '0', 'ce')"
                                    value='<?php echo $resultC[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateEC<?php echo $i+1;?>" value="<?php echo $resultsjC[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFC<?php echo $i+1;?>" id="RebateFC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultC[$i]['g_type']?>', '單期限額', '0', 'cf')"
                                    value='<?php echo $resultC[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateFC<?php echo $i+1;?>" value="<?php echo $resultsjC[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                               <?php for ($i=5;$i<7;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $resultC[$i]['g_type']?><input type="hidden" name="C<?php echo $i+1;?>" id="C<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAC<?php echo $i+1;?>" id="RebateAC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'A盤', '0', 'ca')" 
                                    value='<?php echo $resultC[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAC<?php echo $i+1;?>" id="sRebateAC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBC<?php echo $i+1;?>" id="RebateBC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'B盤', '0', 'cb')" 
                                    value='<?php echo $resultC[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBC<?php echo $i+1;?>" id="sRebateBC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCC<?php echo $i+1;?>" id="RebateCC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'C盤', '0', 'cc')" 
                                    value='<?php echo $resultC[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCC<?php echo $i+1;?>" id="sRebateCC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEC<?php echo $i+1;?>" id="RebateEC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultC[$i]['g_type']?>', '單註限額', '0', 'ce')"
                                    value='<?php echo $resultC[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateEC<?php echo $i+1;?>" value="<?php echo $resultsjC[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFC<?php echo $i+1;?>" id="RebateFC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultC[$i]['g_type']?>', '單期限額', '0', 'cf')"
                                    value='<?php echo $resultC[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateFC<?php echo $i+1;?>" value="<?php echo $resultsjC[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                            
                        </table>
                    </td>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            
                            <?php for ($i=7;$i<10;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $resultC[$i]['g_type']?><input type="hidden" name="C<?php echo $i+1;?>" id="C<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAC<?php echo $i+1;?>" id="RebateAC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'A盤', '0', 'ca')" 
                                    value='<?php echo $resultC[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAC<?php echo $i+1;?>" id="sRebateAC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBC<?php echo $i+1;?>" id="RebateBC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'B盤', '0', 'cb')" 
                                    value='<?php echo $resultC[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBC<?php echo $i+1;?>" id="sRebateBC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCC<?php echo $i+1;?>" id="RebateCC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'C盤', '0', 'cc')" 
                                    value='<?php echo $resultC[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCC<?php echo $i+1;?>" id="sRebateCC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEC<?php echo $i+1;?>" id="RebateEC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultC[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $resultC[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateEC<?php echo $i+1;?>" value="<?php echo $resultsjC[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFC<?php echo $i+1;?>" id="RebateFC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultC[$i]['g_type']?>', '單期限額', '0', 'cf')"
                                    value='<?php echo $resultC[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateFC<?php echo $i+1;?>" value="<?php echo $resultsjC[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                            
                                <?php for ($i=10;$i<13;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS4"><?php echo $resultC[$i]['g_type']?><input type="hidden" name="C<?php echo $i+1;?>" id="C<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAC<?php echo $i+1;?>" id="RebateAC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'A盤', '0', 'ca')" 
                                    value='<?php echo $resultC[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAC<?php echo $i+1;?>" id="sRebateAC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBC<?php echo $i+1;?>" id="RebateBC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'B盤', '0', 'cb')" 
                                    value='<?php echo $resultC[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBC<?php echo $i+1;?>" id="sRebateBC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultC[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCC<?php echo $i+1;?>" id="RebateCC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultC[$i]['g_type']?>', 'C盤', '0', 'cc')" 
                                    value='<?php echo $resultC[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCC<?php echo $i+1;?>" id="sRebateCC<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjC[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEC<?php echo $i+1;?>" id="RebateEC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultC[$i]['g_type']?>', '單註限額', '0', 'ce')"
                                    value='<?php echo $resultC[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateEC<?php echo $i+1;?>" value="<?php echo $resultsjC[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFC<?php echo $i+1;?>" id="RebateFC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultC[$i]['g_type']?>', '單期限額', '0', 'cf')"
                                    value='<?php echo $resultC[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateFC<?php echo $i+1;?>" value="<?php echo $resultsjC[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                            
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <th style="border:none">幸运农场</th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <td>交易類型</td>
                                <td>A盤</td>
                                <td>B盤</td>
                                <td>C盤</td>
                                <td>單註限額</td>
                                <td>單期限額</td>
                            </tr>
                   <?php for ($i=0;$i<1;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $resultX[$i]['g_type']?><input type="hidden" name="X<?php echo $i+1;?>" id="X<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAX<?php echo $i+1;?>" id="RebateAX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'A盤', '1', 'ga')" 
                                    value='<?php echo $resultX[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAX<?php echo $i+1;?>" id="sRebateAX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBX<?php echo $i+1;?>" id="RebateBX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'B盤', '1', 'gb')" 
                                    value='<?php echo $resultX[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBX<?php echo $i+1;?>" id="sRebateBX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCX1" id="RebateCX1"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'C盤', '1', 'gc')" 
                                    value='<?php echo $resultX[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCX<?php echo $i+1;?>" id="sRebateCX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEX<?php echo $i+1;?>" id="RebateEX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單註限額', '1', 'ge')"
                                    value='<?php echo $resultX[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX1" id="sRebateEX1" value="<?php echo $resultsjX[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFX1" id="RebateFX1"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單期限額', '1', 'gf')"
                                    value='<?php echo $resultX[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX1" id="sRebateFX1" value="<?php echo $resultsjX[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php }   ?>   
                            <?php for ($i=1;$i<8;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $resultX[$i]['g_type']?><input type="hidden" name="X<?php echo $i+1;?>" id="X<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAX<?php echo $i+1;?>" id="RebateAX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $resultX[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAX<?php echo $i+1;?>" id="sRebateAX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBX<?php echo $i+1;?>" id="RebateBX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $resultX[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBX<?php echo $i+1;?>" id="sRebateBX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCX<?php echo $i+1;?>" id="RebateCX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $resultX[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCX<?php echo $i+1;?>" id="sRebateCX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEX<?php echo $i+1;?>" id="RebateEX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $resultX[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateEX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFX<?php echo $i+1;?>" id="RebateFX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $resultX[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateFX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                        <?php for ($i=8;$i<12;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $resultX[$i]['g_type']?><input type="hidden" name="X<?php echo $i+1;?>" id="X<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAX<?php echo $i+1;?>" id="RebateAX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $resultX[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAX<?php echo $i+1;?>" id="sRebateAX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBX<?php echo $i+1;?>" id="RebateBX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $resultX[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBX<?php echo $i+1;?>" id="sRebateBX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCX<?php echo $i+1;?>" id="RebateCX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $resultX[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCX<?php echo $i+1;?>" id="sRebateCX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEX<?php echo $i+1;?>" id="RebateEX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $resultX[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateEX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFX<?php echo $i+1;?>" id="RebateFX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $resultX[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateFX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                      
                        <?php for ($i=14;$i<18;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $resultX[$i]['g_type']?><input type="hidden" name="X<?php echo $i+1;?>" id="X<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAX<?php echo $i+1;?>" id="RebateAX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $resultX[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAX<?php echo $i+1;?>" id="sRebateAX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBX<?php echo $i+1;?>" id="RebateBX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $resultX[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBX<?php echo $i+1;?>" id="sRebateBX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCX<?php echo $i+1;?>" id="RebateCX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $resultX[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCX<?php echo $i+1;?>" id="sRebateCX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEX<?php echo $i+1;?>" id="RebateEX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $resultX[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateEX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFX<?php echo $i+1;?>" id="RebateFX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $resultX[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateFX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                        </table>
                    </td>
                    <td valign="top">
                        <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <td>交易類型</td>
                                <td>A盤</td>
                                <td>B盤</td>
                                <td>C盤</td>
                                <td>單註限額</td>
                                <td>單期限額</td>
                            </tr>
                            
                          
                            <?php for ($i=18;$i<26;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS3"><?php echo $resultX[$i]['g_type']?><input type="hidden" name="X<?php echo $i+1;?>" id="X<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAX<?php echo $i+1;?>" id="RebateAX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $resultX[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAX<?php echo $i+1;?>" id="sRebateAX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBX<?php echo $i+1;?>" id="RebateBX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $resultX[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBX<?php echo $i+1;?>" id="sRebateBX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCX<?php echo $i+1;?>" id="RebateCX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $resultX[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCX<?php echo $i+1;?>" id="sRebateCX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEX<?php echo $i+1;?>" id="RebateEX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $resultX[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateEX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFX<?php echo $i+1;?>" id="RebateFX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $resultX[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateFX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                            <?php for ($i=26;$i<31;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $resultX[$i]['g_type']?><input type="hidden" name="X<?php echo $i+1;?>" id="X<?php echo $i+1;?>" value="232025" /></td>
                                <td><input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAX<?php echo $i+1;?>" id="RebateAX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $resultX[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAX<?php echo $i+1;?>" id="sRebateAX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_a_limit'];?>" />                              </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBX<?php echo $i+1;?>" id="RebateBX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $resultX[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBX<?php echo $i+1;?>" id="sRebateBX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_b_limit'];?>" />                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCX<?php echo $i+1;?>" id="RebateCX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $resultX[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCX<?php echo $i+1;?>" id="sRebateCX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_c_limit'];?>" />                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEX<?php echo $i+1;?>" id="RebateEX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $resultX[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateEX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_d_limit'];?>" />                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFX<?php echo $i+1;?>" id="RebateFX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $resultX[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateFX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_e_limit'];?>" />                                </td>
                            </tr>
                      <?php  } ?>   
					  
					  <?php for ($i=12;$i<14;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS4"><?php echo $resultX[$i]['g_type']?><input type="hidden" name="X<?php echo $i+1;?>" id="X<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAX<?php echo $i+1;?>" id="RebateAX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $resultX[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAX<?php echo $i+1;?>" id="sRebateAX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBX<?php echo $i+1;?>" id="RebateBX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $resultX[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBX<?php echo $i+1;?>" id="sRebateBX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultX[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCX<?php echo $i+1;?>" id="RebateCX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultX[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $resultX[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCX<?php echo $i+1;?>" id="sRebateCX<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjX[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEX<?php echo $i+1;?>" id="RebateEX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $resultX[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateEX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFX<?php echo $i+1;?>" id="RebateFX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultX[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $resultX[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateFX<?php echo $i+1;?>" value="<?php echo $resultsjX[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>   
                        </table>
				 
				 </td>
				</tr>
				
                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <th style="border:none">北京賽車(PK10)</th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                           <?php for ($i=0;$i<1;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $resultP[$i]['g_type']?><input type="hidden" name="B<?php echo $i+1;?>" id="B<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAB<?php echo $i+1;?>" id="RebateAB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'A盤', '1', 'ba')" 
                                    value='<?php echo $resultP[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAB<?php echo $i+1;?>" id="sRebateAB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBB<?php echo $i+1;?>" id="RebateBB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'B盤', '1', 'bb')" 
                                    value='<?php echo $resultP[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBB<?php echo $i+1;?>" id="sRebateBB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCB<?php echo $i+1;?>" id="RebateCB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'C盤', '1', 'bc')" 
                                    value='<?php echo $resultP[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCB<?php echo $i+1;?>" id="sRebateCB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEB<?php echo $i+1;?>" id="RebateEB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultP[$i]['g_type']?>', '單註限額', '1', 'be')"
                                    value='<?php echo $resultP[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateEB<?php echo $i+1;?>" value="<?php echo $resultsjP[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFB<?php echo $i+1;?>" id="RebateFB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultP[$i]['g_type']?>', '單期限額', '1', 'bf')"
                                    value='<?php echo $resultP[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateFB<?php echo $i+1;?>" value="<?php echo $resultsjP[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>    
                      
                       <?php for ($i=1;$i<8;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $resultP[$i]['g_type']?><input type="hidden" name="B<?php echo $i+1;?>" id="B<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAB<?php echo $i+1;?>" id="RebateAB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'A盤', '0', 'ba')" 
                                    value='<?php echo $resultP[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAB<?php echo $i+1;?>" id="sRebateAB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBB<?php echo $i+1;?>" id="RebateBB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'B盤', '0', 'bb')" 
                                    value='<?php echo $resultP[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBB<?php echo $i+1;?>" id="sRebateBB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCB<?php echo $i+1;?>" id="RebateCB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'C盤', '0', 'bc')" 
                                    value='<?php echo $resultP[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCB<?php echo $i+1;?>" id="sRebateCB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEB<?php echo $i+1;?>" id="RebateEB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultP[$i]['g_type']?>', '單註限額', '0', 'be')"
                                    value='<?php echo $resultP[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateEB<?php echo $i+1;?>" value="<?php echo $resultsjP[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFB<?php echo $i+1;?>" id="RebateFB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultP[$i]['g_type']?>', '單期限額', '0', 'bf')"
                                    value='<?php echo $resultP[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateFB<?php echo $i+1;?>" value="<?php echo $resultsjP[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>    
                      
                        
                            
                        </table>
                    </td>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            
                          <?php for ($i=8;$i<10;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $resultP[$i]['g_type']?><input type="hidden" name="B<?php echo $i+1;?>" id="B<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAB<?php echo $i+1;?>" id="RebateAB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'A盤', '0', 'ba')" 
                                    value='<?php echo $resultP[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAB<?php echo $i+1;?>" id="sRebateAB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBB<?php echo $i+1;?>" id="RebateBB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'B盤', '0', 'bb')" 
                                    value='<?php echo $resultP[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBB<?php echo $i+1;?>" id="sRebateBB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCB<?php echo $i+1;?>" id="RebateCB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'C盤', '0', 'bc')" 
                                    value='<?php echo $resultP[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCB<?php echo $i+1;?>" id="sRebateCB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEB<?php echo $i+1;?>" id="RebateEB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultP[$i]['g_type']?>', '單註限額', '0', 'be')"
                                    value='<?php echo $resultP[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateEB<?php echo $i+1;?>" value="<?php echo $resultsjP[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFB<?php echo $i+1;?>" id="RebateFB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultP[$i]['g_type']?>', '單期限額', '0', 'bf')"
                                    value='<?php echo $resultP[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateFB<?php echo $i+1;?>" value="<?php echo $resultsjP[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>    
                      
                                 
                          <?php for ($i=10;$i<15;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $resultP[$i]['g_type']?><input type="hidden" name="B<?php echo $i+1;?>" id="B<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAB<?php echo $i+1;?>" id="RebateAB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'A盤', '0', 'ba')" 
                                    value='<?php echo $resultP[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAB<?php echo $i+1;?>" id="sRebateAB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBB<?php echo $i+1;?>" id="RebateBB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'B盤', '0', 'bb')" 
                                    value='<?php echo $resultP[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBB<?php echo $i+1;?>" id="sRebateBB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCB<?php echo $i+1;?>" id="RebateCB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'C盤', '0', 'bc')" 
                                    value='<?php echo $resultP[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCB<?php echo $i+1;?>" id="sRebateCB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEB<?php echo $i+1;?>" id="RebateEB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultP[$i]['g_type']?>', '單註限額', '0', 'be')"
                                    value='<?php echo $resultP[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateEB<?php echo $i+1;?>" value="<?php echo $resultsjP[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFB<?php echo $i+1;?>" id="RebateFB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultP[$i]['g_type']?>', '單期限額', '0', 'bf')"
                                    value='<?php echo $resultP[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateFB<?php echo $i+1;?>" value="<?php echo $resultsjP[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>    
                           <?php for ($i=15;$i<16;$i++){?>
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS4"><?php echo $resultP[$i]['g_type']?><input type="hidden" name="B<?php echo $i+1;?>" id="B<?php echo $i+1;?>" value="232025" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAB<?php echo $i+1;?>" id="RebateAB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'A盤', '0', 'ba')" 
                                    value='<?php echo $resultP[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAB<?php echo $i+1;?>" id="sRebateAB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBB<?php echo $i+1;?>" id="RebateBB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'B盤', '0', 'bb')" 
                                    value='<?php echo $resultP[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBB<?php echo $i+1;?>" id="sRebateBB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultP[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCB<?php echo $i+1;?>" id="RebateCB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $resultP[$i]['g_type']?>', 'C盤', '0', 'bc')" 
                                    value='<?php echo $resultP[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCB<?php echo $i+1;?>" id="sRebateCB<?php echo $i+1;?>" 
                                    value="<?php echo $resultsjP[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEB<?php echo $i+1;?>" id="RebateEB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $resultP[$i]['g_type']?>', '單註限額', '0', 'be')"
                                    value='<?php echo $resultP[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateEB<?php echo $i+1;?>" value="<?php echo $resultsjP[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFB<?php echo $i+1;?>" id="RebateFB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $resultP[$i]['g_type']?>', '單期限額', '0', 'bf')"
                                    value='<?php echo $resultP[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateFB<?php echo $i+1;?>" value="<?php echo $resultsjP[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                      <?php  } ?>    
                         
                      
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                               <th style="border:none">江苏骰寶(快3)</th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                         <?php for ($i=0;$i<2;$i++){?>   
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $resultJ[$i]['g_type']?><input type="hidden" name="J<?php echo $i+1;?>" id="J<?php echo $i+1;?>" value="58514" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAJ<?php echo $i+1;?>" id="RebateAJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ja'"
                                    onblur="this.className='inp1 ja'" 
                                    class='inp1 ja'
                                    onchange="isCompare(this, '<?php echo $resultJ[$i]['g_type']?>', 'A盤', '0', 'ja')"
                                    value='<?php echo $resultJ[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAJ<?php echo $i+1;?>" id="sRebateAJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBJ<?php echo $i+1;?>" id="RebateBJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jb'"
                                    onblur="this.className='inp1 jb'" 
                                    class='inp1 jb'
                                    onchange="isCompare(this, '<?php echo $resultJ[$i]['g_type']?>', 'B盤', '0', 'jb')"
                                    value='<?php echo $resultJ[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBJ<?php echo $i+1;?>" id="sRebateBJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCJ<?php echo $i+1;?>" id="RebateCJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jc'"
                                    onblur="this.className='inp1 jc'" 
                                    class='inp1 jc'
                                    onchange="isCompare(this, '<?php echo $resultJ[$i]['g_type']?>', 'C盤', '0', 'jc')"
                                    value='<?php echo $resultJ[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCJ<?php echo $i+1;?>" id="sRebateCJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEJ<?php echo $i+1;?>" id="RebateEJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m je'" 
                                    onblur="this.className='inp1 je'"
                                    class='inp1 je'
                                    onchange="isCompares(this, '<?php echo $resultJ[$i]['g_type']?>', '單註限額', '1', 'je')"
                                    value='<?php echo $resultJ[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEJ<?php echo $i+1;?>" id="sRebateEJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFJ<?php echo $i+1;?>" id="RebateFJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jf'" 
                                    onblur="this.className='inp1 jf'" 
                                    class='inp1 jf'
                                    onchange="isCompares(this, '<?php echo $resultJ[$i]['g_type']?>', '單期限額', '1', 'jf')"
                                    value='<?php echo $resultJ[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFJ<?php echo $i+1;?>" id="sRebateFJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                            <?php }?>
                        
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS3">圍骰<input type="hidden" name="J3" id="J3" value="58516" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[2]['g_a_limit']?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAJ3" id="RebateAJ3"
                                    onfocus="this.className='inp1m ja'"
                                    onblur="this.className='inp1 ja'" 
                                    class='inp1 ja'
                                    onchange="isCompare(this, '圍骰', 'A盤', '0', 'ja')"
                                    value='<?php echo $resultJ[2]['g_a_limit']?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAJ3" id="sRebateAJ3" value="<?php echo $resultsjJ[2]['g_a_limit']?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[2]['g_b_limit']?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBJ3" id="RebateBJ3"
                                    onfocus="this.className='inp1m jb'"
                                    onblur="this.className='inp1 jb'" 
                                    class='inp1 jb'
                                    onchange="isCompare(this, '圍骰', 'B盤', '0', 'jb')"
                                    value='<?php echo $resultJ[2]['g_b_limit']?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBJ3" id="sRebateBJ3" value="<?php echo $resultsjJ[2]['g_b_limit']?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>">97.2</span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCJ3" id="RebateCJ3"
                                    onfocus="this.className='inp1m jc'"
                                    onblur="this.className='inp1 jc'" 
                                    class='inp1 jc'
                                    onchange="isCompare(this, '圍骰', 'C盤', '0', 'jc')"
                                    value='<?php echo $resultJ[2]['g_c_limit']?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCJ3" id="sRebateCJ3" value="<?php echo $resultsjJ[2]['g_c_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEJ3" id="RebateEJ3"
                                    onfocus="this.className='inp1m je'" 
                                    onblur="this.className='inp1 je'"
                                    class='inp1 je'
                                    onchange="isCompares(this, '圍骰', '單註限額', '0', 'je')"
                                    value='<?php echo $resultJ[2]['g_d_limit']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEJ3" id="sRebateEJ3" value="<?php echo $resultsjJ[2]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFJ3" id="RebateFJ3"
                                    onfocus="this.className='inp1m jf'" 
                                    onblur="this.className='inp1 jf'" 
                                    class='inp1 jf'
                                    onchange="isCompares(this, '圍骰', '單期限額', '0', 'jf')"
                                    value='<?php echo $resultJ[2]['g_d_limit']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFJ3" id="sRebateFJ3" value="<?php echo $resultsjJ[2]['g_e_limit'];?>" />
                                </td>
                            </tr>
                            
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS3">全骰<input type="hidden" name="J7" id="J7" value="58517" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[2]['g_a_limit']?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAJ7" id="RebateAJ7"
                                    onfocus="this.className='inp1m ja'"
                                    onblur="this.className='inp1 ja'" 
                                    class='inp1 ja'
                                    onchange="isCompare(this, '全骰', 'A盤', '0', 'ja')"
                                    value='<?php echo $resultJ[2]['g_a_limit']?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAJ7" id="sRebateAJ7" value="<?php echo $resultsjJ[2]['g_a_limit']?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[2]['g_b_limit']?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBJ7" id="RebateBJ7"
                                    onfocus="this.className='inp1m jb'"
                                    onblur="this.className='inp1 jb'" 
                                    class='inp1 jb'
                                    onchange="isCompare(this, '全骰', 'B盤', '0', 'jb')"
                                    value='<?php echo $resultJ[2]['g_b_limit']?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBJ7" id="sRebateBJ7" value="<?php echo $resultsjJ[2]['g_b_limit']?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[2]['g_c_limit']?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCJ7" id="RebateCJ7"
                                    onfocus="this.className='inp1m jc'"
                                    onblur="this.className='inp1 jc'" 
                                    class='inp1 jc'
                                    onchange="isCompare(this, '全骰', 'C盤', '0', 'jc')"
                                    value='<?php echo $resultJ[2]['g_c_limit']?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCJ7" id="sRebateCJ7" value="<?php echo $resultsjJ[2]['g_c_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEJ7" id="RebateEJ7"
                                    onfocus="this.className='inp1m je'" 
                                    onblur="this.className='inp1 je'"
                                    class='inp1 je'
                                    onchange="isCompares(this, '全骰', '單註限額', '0', 'je')"
                                    value='<?php echo $resultJ[2]['g_d_limit']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEJ7" id="sRebateEJ7" value="<?php echo $resultsjJ[2]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFJ7" id="RebateFJ7"
                                    onfocus="this.className='inp1m jf'" 
                                    onblur="this.className='inp1 jf'" 
                                    class='inp1 jf'
                                    onchange="isCompares(this, '全骰', '單期限額', '0', 'jf')"
                                    value='<?php echo $resultJ[2]['g_e_limit']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFJ7" id="sRebateFJ7" value="<?php echo $resultsjJ[2]['g_e_limit'];?>" />
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                         <?php for ($i=3;$i<4;$i++){?>   
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS4"><?php echo $resultJ[$i]['g_type']?><input type="hidden" name="J<?php echo $i+1;?>" id="J<?php echo $i+1;?>" value="58514" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAJ<?php echo $i+1;?>" id="RebateAJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ja'"
                                    onblur="this.className='inp1 ja'" 
                                    class='inp1 ja'
                                    onchange="isCompare(this, '<?php echo $resultJ[$i]['g_type']?>', 'A盤', '0', 'ja')"
                                    value='<?php echo $resultJ[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAJ<?php echo $i+1;?>" id="sRebateAJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBJ<?php echo $i+1;?>" id="RebateBJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jb'"
                                    onblur="this.className='inp1 jb'" 
                                    class='inp1 jb'
                                    onchange="isCompare(this, '<?php echo $resultJ[$i]['g_type']?>', 'B盤', '0', 'jb')"
                                    value='<?php echo $resultJ[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBJ<?php echo $i+1;?>" id="sRebateBJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCJ<?php echo $i+1;?>" id="RebateCJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jc'"
                                    onblur="this.className='inp1 jc'" 
                                    class='inp1 jc'
                                    onchange="isCompare(this, '<?php echo $resultJ[$i]['g_type']?>', 'C盤', '0', 'jc')"
                                    value='<?php echo $resultJ[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCJ<?php echo $i+1;?>" id="sRebateCJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEJ<?php echo $i+1;?>" id="RebateEJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m je'" 
                                    onblur="this.className='inp1 je'"
                                    class='inp1 je'
                                    onchange="isCompares(this, '<?php echo $resultJ[$i]['g_type']?>', '單註限額', '1', 'je')"
                                    value='<?php echo $resultJ[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEJ<?php echo $i+1;?>" id="sRebateEJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFJ<?php echo $i+1;?>" id="RebateFJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jf'" 
                                    onblur="this.className='inp1 jf'" 
                                    class='inp1 jf'
                                    onchange="isCompares(this, '<?php echo $resultJ[$i]['g_type']?>', '單期限額', '1', 'jf')"
                                    value='<?php echo $resultJ[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFJ<?php echo $i+1;?>" id="sRebateFJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                            <?php }?>
                              <?php for ($i=4;$i<6;$i++){?>   
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS3"><?php echo $resultJ[$i]['g_type']?><input type="hidden" name="J<?php echo $i+1;?>" id="J<?php echo $i+1;?>" value="58514" /></td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[$i]['g_a_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateAJ<?php echo $i+1;?>" id="RebateAJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ja'"
                                    onblur="this.className='inp1 ja'" 
                                    class='inp1 ja'
                                    onchange="isCompare(this, '<?php echo $resultJ[$i]['g_type']?>', 'A盤', '0', 'ja')"
                                    value='<?php echo $resultJ[$i]['g_a_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAJ<?php echo $i+1;?>" id="sRebateAJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_a_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[$i]['g_b_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateBJ<?php echo $i+1;?>" id="RebateBJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jb'"
                                    onblur="this.className='inp1 jb'" 
                                    class='inp1 jb'
                                    onchange="isCompare(this, '<?php echo $resultJ[$i]['g_type']?>', 'B盤', '0', 'jb')"
                                    value='<?php echo $resultJ[$i]['g_b_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBJ<?php echo $i+1;?>" id="sRebateBJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_b_limit'];?>" />
                                </td>
                                <td>
                                    <span style="width:60px;display:<?php if ($count == 0){echo "none";}?>"><?php echo $resultJ[$i]['g_c_limit'];?></span>
                                    <input style="width:60px;display:<?php if ($count > 0){echo "none";}?>" name="RebateCJ<?php echo $i+1;?>" id="RebateCJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jc'"
                                    onblur="this.className='inp1 jc'" 
                                    class='inp1 jc'
                                    onchange="isCompare(this, '<?php echo $resultJ[$i]['g_type']?>', 'C盤', '0', 'jc')"
                                    value='<?php echo $resultJ[$i]['g_c_limit'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCJ<?php echo $i+1;?>" id="sRebateCJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_c_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEJ<?php echo $i+1;?>" id="RebateEJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m je'" 
                                    onblur="this.className='inp1 je'"
                                    class='inp1 je'
                                    onchange="isCompares(this, '<?php echo $resultJ[$i]['g_type']?>', '單註限額', '0', 'je')"
                                    value='<?php echo $resultJ[$i]['g_d_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEJ<?php echo $i+1;?>" id="sRebateEJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_d_limit'];?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFJ<?php echo $i+1;?>" id="RebateFJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jf'" 
                                    onblur="this.className='inp1 jf'" 
                                    class='inp1 jf'
                                    onchange="isCompares(this, '<?php echo $resultJ[$i]['g_type']?>', '單期限額', '0', 'jf')"
                                    value='<?php echo $resultJ[$i]['g_e_limit'];?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFJ<?php echo $i+1;?>" id="sRebateFJ<?php echo $i+1;?>" value="<?php echo $resultsjJ[$i]['g_e_limit'];?>" />
                                </td>
                            </tr>
                            <?php }?>
                        </table>
                    </td>
                </tr>
                
            </table>
        <!-- end -->
        </td>
        <td class="Main_right" width="5"></td>
    </tr>
    <tr>
        <td class="Main_bottom_left"></td>
      <td background="/Css/tab_19.gif" align="center">
          <input type="submit" id="submit" name="submit" onMouseOver="this.className='input2_2'" onMouseOut="this.className='input2'" class="input2" value="保存" />
            &nbsp;&nbsp;
        <input type="button" onMouseOver="this.className='input2_2'" onMouseOut="this.className='input2'" class="input2" onClick="historys()" value="取消" />
      </td>
        <td class="Main_bottom_right"></td>
    </tr>
</table>
            </td>
            <td width="6" bgcolor="#5a5a5a"></td>
        </tr>
        <tr>
        	<td height="6" bgcolor="#5a5a5a"> </td>
            <td bgcolor="#5a5a5a"></td>
            <td height="6" bgcolor="#5a5a5a"> </td>
        </tr>
    </table>
   </form>
</body>
</html>



