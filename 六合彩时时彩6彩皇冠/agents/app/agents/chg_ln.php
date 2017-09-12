<?
header("Expires: Mon, 26 Jul 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
require ("./include/config.inc.php");
include "./include/address.mem.php";

$user=$_REQUEST['username'];
$pass=$_REQUEST['password'];
$langx=$_REQUEST["langx"];
$action=$_REQUEST['action'];
require ("./include/traditional.$langx.inc.php");

if ($action==1){
	$loginname=strtolower($_REQUEST["loginname"]);
	$date=date("Y-m-d");
	$mysql="select * from web_agents_data where LoginName='$loginname'";
	$result = mysql_db_query($dbname,$mysql);
	$count=mysql_num_rows($result);
    if ($count>0){
		echo wterror("您输入的登录帐号 $passwd 已经有人使用了，请回上一页重新输入!!");
		exit;
    }else{
	    $mysql="update web_agents_data set LoginName='$loginname',EditDate='$date' where UserName='$user' and Password='$pass'";
	    mysql_db_query($dbname,$mysql) or die ("操作失败!");
	}
	echo "<Script language=javascript>alert('已成功修改登陆帐号~~请回首页重新登入');window.open('".BROWSER_IP."','_top')</script>";
}
?>
<html>
<head>
<title>变更密码</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_body.css" type="text/css">
</head>
<script language="JavaScript" src="/js/agents/<?=$langx?>.js" type="text/javascript"></script>
<script language="JavaScript" src="/js/agents/chg_long_id.js" type="text/javascript"></script>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" id="PWD">
<table width="450" border="0" align="center" cellpadding="1" cellspacing="1" class="pwd_side">
	<tr class="pwd_bg">
		<td colspan="2">
			<table border="0" cellpadding="1" cellspacing="1">
			  	<tr>
			  		<td width="400" class="pwd_title"><?=$Chg_Setting_Login_ID?></td>
					<td width="100" class="point" style="cursor:hand;" onClick="javascript:window.open('/tpl/control/<?=$langx?>/guide.html');" ><?=$Chg_Setting_Guide?></td>
			  	</tr>
		 	</table>
	 	</td>
	</tr>
	<tr>
		<td colspan="2" class="pwd_txt">
			<?=$Chg_Please_create_a_new_name_or_code_which_is_convenient_for_user_to_remember_as_your?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="pwd_txt">
			<?=$Chg_Setting_Rules?> : <?=$Chg_The_Login_ID_must_have_6_12_alphanumeric_with_at_least_2_capital_or_lowercase_letter_and_digit_0_9?>
			<br><?=$Chg_For_Example?>
		</td>
	</tr>	
	<form name="ChgPwdForm" method="post">
		<tr>
			<td width="100"align="right"   class="pwd_txt" ><?=$Chg_Login_ID?></td>
			<td width="350"class="pwd_txt">
				<input type="TEXT" name="loginname" value="" size=12 maxlength=12 class="za_text_02">
				<input type="button" name="check" id='check' value="<?=$Chg_Check?>" class="za_button" onclick='ChkAG();'>
				<font class="red_txt"><?=$Chg_Note?>：</font><?=$Chg_The_setting_cannot_be_modified?>。
			</td>
		</tr>
		<tr >
			<td colspan="2" align="center"  class="pwd_bg">
				<input type="button" value="<?=$Chg_Submit?>" onClick="return SubChk();" class="za_button_01">
				<input type="button" name="cancel" value="<?=$Chg_Cancel?>" class="za_button_01" onClick="javascript:history.go(-1);">
				<input type="hidden" name="action" value="1">
				<input type="hidden" name="uid" value="<?=$uid?>">
			</td>
		</tr>
	</form>
</table>
<table align="center">
	<tr >
		<td class="white">
			<ul><li><?=$Chg_After_completion?><font class="red_txt"><?=$Chg_agent_have_to_use_the_new_Login_ID_to_login?></font><BR><?=$Chg_and_the_original_Agent_ID_is_only_for_identification_purpose?></li></ul>
		</td>
	</tr>
</table>
<iframe id="getData" src="../../../../ok.html" width="0" height="0"></iframe>
</body>
</html>