<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
global $Users;
if ($Users[0]['g_login_id'] != 89) exit;

if (isset($Users[0]['g_lock_1_4'])){
	if ($Users[0]['g_lock_1_4'] !=1) 
		exit(back('您的權限不足！'));
}

$db=new DB();
$userModel = new UserModel();
$RankList = $userModel->GetRankAll();
$MemberList = $userModel->GetMemberAll();

$pageNum = 50;

if (isset($_SESSION['GameType']) && $_SESSION['GameType'] == 2){
	$a = day();
	$startDate = $a[0];
	$endDate = $a[1];
	$p = '重慶時時彩';
	$link = 'UpCrystalcq.php';
} else if (isset($_SESSION['GameType']) && $_SESSION['GameType'] == 3){
	$startDate = date('Y-m-d').' 00:00';
	$endDate = date('Y-m-d').' 24:00';
	$p = '廣西快樂十分';
	$link = 'UpCrystalgx.php';
}else if(isset($_SESSION['GameType']) && $_SESSION['GameType'] == 4){
	$a = day();
	$startDate = $a[0];
	$endDate = $a[1];
	$p = '江西時時彩';
	$link = 'UpCrystaljx.php';
}else if(isset($_SESSION['GameType']) && $_SESSION['GameType'] == 5){
	$a = day();
	$startDate = $a[0];
	$endDate = $a[1];
	$p = '幸运农场';
	$link = 'UpCrystalnc.php';
}else if(isset($_SESSION['GameType']) && $_SESSION['GameType'] == 6){
	$a = day();
	$startDate = $a[0];
	$endDate = $a[1];
	$p = '北京赛车PK10';
	$link = 'UpCrystalpk.php';
}else if(isset($_SESSION['GameType']) && $_SESSION['GameType'] == 7){
	$a = day();
	$startDate = $a[0];
	$endDate = $a[1];
	$p = '江苏骰寶(快3)';
	$link = 'UpCrystalk3.php';
}else{
	$startDate = date('Y-m-d').' 00:00';
	$endDate = date('Y-m-d').' 24:00';
	$p = '廣東快樂十分';
	$link = 'UpCrystal.php';
}


if (isset($_GET['uid'])&&$_GET['uid']!="")
{

	$uid = $_GET['uid'];
	
	$where = "g_qishu = '{$uid}'";
	
	$sql = "SELECT * FROM g_zhudan WHERE {$where} AND  g_type = '{$p}' ORDER BY g_id DESC ";
	$total = $db->query($sql, 3);
	$page = new Page($total, $pageNum);
	$sql = "SELECT * FROM g_zhudan WHERE {$where} AND  g_type = '{$p}' ORDER BY g_id DESC {$page->limit} ";
	$result = $db->query($sql, 1);
	
}	
if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['g_qishu'])&&$_POST['g_qishu']!=""){
		$qishu = $_POST['g_qishu'];
	
		$where = "g_qishu = '{$qishu}'";
	
		$sql = "SELECT * FROM g_zhudan WHERE {$where} AND  g_type = '{$p}' ORDER BY g_id DESC ";
		$total = $db->query($sql, 1);
		if($total){
		for($i=0;$i<count($total);$i++){
		
		$gid=$total[$i]['g_id'];
		
		$result = $db->query("SELECT g_id, g_type, g_mumber_type, g_nid, g_mingxi_1, g_jiner, g_win FROM g_zhudan WHERE g_id = '{$gid}' LIMIT 1", 1);
		if ($result)
		{
			if ($result[0]['g_mumber_type']!=5)
			{
			
				$sql = "SELECT g_name, g_money_yes FROM g_user WHERE g_name = '{$result[0]['g_nid']}' LIMIT 1";
				$userName = $db->query($sql, 1);
				if($result[0]['g_win']<0){
				$money = $userName[0]['g_money_yes'] - $result[0]['g_win'];
				}else{
				if($result[0]['g_win']>0){
				$money = $userName[0]['g_money_yes'] - $result[0]['g_win'];
				}else
				$money = $userName[0]['g_money_yes'] - $result[0]['g_win']+$result[0]['g_jiner'];
				}
				$sql = "UPDATE g_user SET g_money_yes = '{$money}' WHERE g_name = '{$userName[0]['g_name']}' LIMIT 1";
				$db->query($sql, 2);
			
				$or = "OR g_t_id = '{$gid}'";
			}
		
			$sql = "DELETE FROM `g_zhudan` WHERE g_id = '{$gid}' {$or}";
			$db->query($sql, 2);
		
			
		}	
		}
		exit(back($delid.'# 注單撤消成功'));
		}else{
		back('当期无注单!!!');
		}
		}else{
		back('期号出错！！！');
		}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Manage/temp/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/Manage/temp/js/crystalInfo.js"></script>
<title></title>
</head>
<body>

	<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_03.gif" alt="" /></td>
                        <td background="/Manage/temp/images/tab_05.gif">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="17"><img src="/Manage/temp/images/tb.gif" width="16" height="16" /></td>
                                    <td width="89%">&nbsp;注單撤消管理</td>
									 <td width="17"><img src="/Manage/temp/images/fh.gif"/></td>
									 <td width="10%">&nbsp;<a href="/Manage/temp/CrystalInfo.php" >返回注单设置</a></td>
                                  </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/Manage/temp/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
                            <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<th colspan="6">注單撤消管理</th>
                                </tr>
                                <tr style="height:28px">
                                	<td width="189" class="bj" colspan="3">期号:</td>
                                    <td width="460" class="left_p6" colspan="2"><form action="" method="get" onsubmit="">
                                   <input class="textc" type="text" name="uid" id="uid" style="width:200px; height:22px;" value="<?php echo $_GET['uid']?>" />
								   <input type="submit" value="查询"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（输入你要撤消的注单期号。）
								   </form>
                                  </td>
								  <td align="center">
								  <form action="" method="post" onsubmit="">
								  <input type="hidden" value="<?php echo $_GET['uid']?>" name="g_qishu" id="g_qishu"/><input type="submit" value="撤消注单"/>
								  </form>
								  </td>
                                </tr>                            
								
								<tr class="tr_top">
                                	<td width="180">注單號碼/時間</td>
                                    <td width="120">下注類型</td>
                                    <td width="80">帳號</td>
                                    <td>下注明細</td>
                                    <td>會員下注</td>
                                    <td>輸贏結果</td>
                                </tr>
                                <?php if (!$result){echo'<tr><td align="center" colspan="6">暫無記錄</td></tr>';}else{
                                for ($i=0; $i<count($result); $i++){
                               			if ($result[$i]['g_mingxi_1_str'] == null) {
                               				if ($result[$i]['g_mingxi_1'] == '總和、龍虎' || $result[$i]['g_mingxi_1'] == '總和、龍虎和'){
                               					$n = $result[$i]['g_mingxi_2'];
                               				} else {
                               					$n = $result[$i]['g_mingxi_1'].'『'.$result[$i]['g_mingxi_2'].'』';
                               				}
                                		 	//$n = $result[$i]['g_mingxi_1'] == '總和、龍虎' ? $result[$i]['g_mingxi_2'] : $result[$i]['g_mingxi_1'].'『'.$result[$i]['g_mingxi_2'].'』';
                                		 	$html = '<font color="#0066FF">'.$n.'</font>@ <font color="red"><b>'.$result[$i]['g_odds'].'</b></font>';
                                		 	$SumNum = $result[$i]['g_jiner'];
                                		 } else {
                                		 	$_xMoney = $result[$i]['g_mingxi_1_str'] * $result[$i]['g_jiner'];
                                		 	$SumNum = '<font color="#009933">'.$result[$i]['g_mingxi_1_str'].'</font> x <font color="#0066FF">'.$result[$i]['g_jiner'].'</font><br />'.$_xMoney;
											$html = '<font color="#0066FF">'.$result[$i]['g_mingxi_1'].'</font>@ <font color="red"><b>'.$result[$i]['g_odds'].'</b></font><br />'.
						        				'<span style="line-height:23px">復式  『 '.$result[$i]['g_mingxi_1_str'].' 組 』</span><br/><span>'.$result[$i]['g_mingxi_2'].'</span>';
                                		 }
                                $win = $result[$i]['g_win'] != null ? $result[$i]['g_win'] : '<span style="color:#0000FF">『 未結算 』</span>';
                                ?>
                                <tr align="center" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                	<td><?php echo$result[$i]['g_id']?>#<br /><?php echo$result[$i]['g_date'].'&nbsp;'.GetWeekDay($result[$i]['g_date'],1)?></td>
                                    <td><?php echo$result[$i]['g_type']?><br /><font color="#009933"><?php echo$result[$i]['g_qishu']?>期</font></td>
                                    <td><?php echo$result[$i]['g_nid']?></td>
                                    <td><?php echo$html?></td>
                                    <td><?php echo $SumNum?></td>
                                    <td><?php echo$win?></td>
                                </tr>
                                <?php }}?>
								
								</table>
                        <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="right"><?php
						if (isset($_GET['uid'])&&$_GET['uid']!=""){
						 echo $page->fpage(array(0,1, 3,4,5,6,7));
						 }
						 ?></td>
                        <td width="16"><img src="/Manage/temp/images/tab_20.gif" alt="" /></td>
                    </tr>
                </table>
            </td>
            <td width="6" bgcolor="#5a5a5a"></td>
        </tr>
        <tr>
        	<td height="6" bgcolor="#5a5a5a"></td>
            <td bgcolor="#5a5a5a"></td>
            <td height="6" bgcolor="#5a5a5a"></td>
        </tr>
    </table>
</body>
</html>