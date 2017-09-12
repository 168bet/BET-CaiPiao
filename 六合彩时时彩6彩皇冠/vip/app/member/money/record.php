<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
include "../include/login_session.php";
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$username=$_REQUEST['username'];
//require ("../include/traditional.$langx.inc.php");
$sql = "select Oid from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
?>
<html>
<head>
<title>History</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body<?=$css?>.css" type="text/css">
<style>
<!--
#MFT #box { width:650px;}
#MFT .news { white-space: normal!important; color:#300; text-align:left; padding:2px 4px;}
-->
</style>
</HEAD>
<BODY id="MFT" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form method="post" name="main" action="take.php?uid=<?=$uid?>&langx=<?=$langx?>" onSubmit="return VerifyData()">
<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td class="top">
  	  <h1><em>存款提款记录</em></h1>
	</td>
  </tr>
  <tr>
    <td class="mem">
      <table width="100%" border="0" cellpadding="0" cellspacing="1" class="game">
		<tr class="b_rig">
		  <td width="77" height="30" align="center">会员</td>
          <td width="100" align="center">联系电话</td>
          <td width="120" align="center">日期</td>
		  <td width="60" align="center">存储类型</td>
          <td width="60" align="center">使用币值</td>
          <td width="65" align="center">金额</td>
          <td width="160" align="center">银行资料</td>
		</tr>
<?
$mysql="select ID,Gold,Type,UserName,CurType,Date,Name,User,Phone,Contact,Bank_Account,Bank_Address from web_sys800_data where UserName='$username' order by id desc";

//echo $mysql;
$result=mysql_db_query($dbname,$mysql);
while ($myrow=mysql_fetch_array($result)){
if ($myrow['Type']=='T'){
	$type='提款';
	$name=$myrow['Name'];
}else if ($myrow['Type']=='S'){
	$type='存款';
	$name='';
}
$gold+=$myrow['Gold'];
?>
		<tr class="b_rig">
		  <td height="30" align="center"><?=$myrow['UserName']?></td>
		  <td align="center"><?=$myrow['Phone']?><br><?=$name?></td>
          <td align="center"><?=$myrow['Date']?></td>
          <td align="center"><?=$type?></td>
          <td align="center"><?=$myrow['CurType']?></td>
          <td ><?=$myrow['Gold']?></td>
          <td align="center"><?=$myrow['Bank_Account']?><br><?=$myrow['Bank_Address']?></td>
		</tr>
<?
}
?>
		<tr class="b_rig">
		  <td height="30" align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>合计:</td>
          <td bgcolor="#990000"><font color="#FFFFFF"><?=$gold?></font></td>
          <td align="center">&nbsp;</td>
		</tr>
      </table>
    </td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>
</form>
</BODY>
</HTML>
