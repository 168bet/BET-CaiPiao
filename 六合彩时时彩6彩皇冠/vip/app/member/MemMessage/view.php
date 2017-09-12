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
if ($_REQUEST['langx']=='')
	$langx="zh-cn";
else
	$langx=$_REQUEST["langx"];
$username=$_REQUEST['username'];
//require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$mysql="select * from web_member_msg where `id`='".$_GET['msgid']."' and `receive`='".$row['UserName']."'";
$result = mysql_db_query($dbname,$mysql);
$myrow = mysql_fetch_array($result);
$update = "update `web_member_msg` set `state` = '1' where `id`='".$_GET['msgid']."' and `receive`='".$row['UserName']."'";
//echo $update;
mysql_db_query($dbname,$update) or die($update.mysql_error());
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
.title a:link {
	font-size: 12px;
	color: #000;
	font-weight:normal;
}
.title a:visited {
	font-size: 12px;
	color: #000;
	font-weight:normal;
}
body {
	font-size: 12px;
}
a {
	font-size: 12px;
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #666;
}
a:active {
	color: #000;
}
</style>
<script src="day.js"></script>
<script>
function changePage(obj)
{
	window.location.replace("<?=($_SERVER['PHP_SELF']."?uid=".$uid."&langx=".$langx."&page=")?>"+obj.value);
}
</script>
</HEAD>
<BODY id="MFT" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form method="post" name="main" action="record.php?uid=<?=$uid?>&langx=<?=$langx?>&do=yes">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="500" valign="top"><table border="0" cellpadding="0" cellspacing="0" id="box">
        <tr>
          <td class="top"><h1><em>标题: <?=($myrow['title'])?></em></h1></td>
        </tr>
        <tr>
          <td style="font-size: 12px;"><br>短信内容<br>
<hr noshade><?=($myrow['content'])?><hr noshade><a href="record.php?uid=<?=$uid?>">返回</a></td>
        </tr>
        <tr>
          <td>&nbsp;</td></tr>
        <tr>
          <td id="foot">&nbsp;</td>
        </tr>
      </table>
</td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
