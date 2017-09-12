<?
session_start();
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
require ("../include/config.inc.php");
include "../include/login_session.php";
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$action=$_REQUEST['action'];
$mtype=$_REQUEST['mtype'];
require ("../include/traditional.$langx.inc.php");
$mysql="Select PassWord,EditDate from web_member_data where Oid='$uid'";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$password=$row['PassWord'];
$editdate=$row['EditDate'];
if ($action==1){
	$pasd=strtolower($_REQUEST["password"]);
	$date=date("Y-m-d");
	$todaydate=strtotime(date("Y-m-d"));
	$editdate=strtotime($editdate);
	$time=($todaydate-$editdate)/86400;
	$mysql="update web_member_data set PassWord='$pasd',EditDate='$date' where Oid='$uid'";
	mysql_db_query($dbname,$mysql) or die ("操作失败!");
	if ($time>30){
	    echo "<Script language=javascript>alert('已成功的变更了您的密码~~请回首页重新登入');top.location.href='".BROWSER_IP."';;window.close();</script>";
	}else{
	    echo "<Script language=javascript>alert('已成功的变更了您的密码~~请回首页重新登入');opener.top.location='".BROWSER_IP."';window.close();</script>";	
	}
}
		
?>
<html>
<head>
<title>Please Key in Password</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
<style type="text/css">
<!--
html, body { margin:0; padding-top:2px;text-align:center;}
em{width:65px;white-space: nowrap;color:#000;text-align:right;font-size: 12px;}
-->
</style>
</head>

<body id="CHG" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<script>
var str_meta = "<?=$charset?>";
var LS = "c";
var pass = "<?=$password?>";
</script>
<script language="JavaScript" src="/js/<?=$langx?>.js"></script>
<script language="JavaScript" src="/js/mem_chk_pass.js"></script>
<div class="chg"><h4><?=$Chg_Please_Key_in_Password?></h4>
	<form method=post onSubmit="return SubChk();">
		<input type="hidden" name="action" value="1">
		<input type="hidden" name="uid" value="<?=$uid?>">
		<input type="hidden" name="flag" value="1">
		<div class="chg_bg">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<p><em><?=$Chg_Password?>&nbsp;</em><input type=PASSWORD name="password" value="<?=$password?>" size=10 maxlength=12 class="txt"></p>
						<p><em><?=$Chg_Confirm_Password?>&nbsp;</em><input type=PASSWORD name="REpassword" value="<?=$password?>" size=10 maxlength=12 class="txt"></p></td>
					<td valign="bottom" nowrap>
						<input type=submit name="OK" value="<?=$Chg_Submit?>" class="yes">
						<input type=button name="cancel" value="<?=$Chg_Cancel?>" class="no" onClick="javascript:window.close();"><br>
					</td>
				</tr>
			</table>
			<hr color="#993300" noshade>
			<font color="#CC0000">
				<p align="left">1.<?=$Chg_Password_must_involve_numbers_and_letters?></p>
				<p align="left">2.<?=$Chg_Password_must_include_6_12_words?></p><br>
			</font>
		</div>
	</form>
</div>
</body>
</html>