<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
require ("../include/define_function.php");
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$gid=$_REQUEST['gid'];
$mb_in=$_REQUEST['mb_inball'];
$tg_in=$_REQUEST['tg_inball'];
$mb_in_v=$_REQUEST['mb_inball_v'];
$tg_in_v=$_REQUEST['tg_inball_v'];
$gtype=$_REQUEST['gtype'];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$mysql="update match_sports set MB_Inball='$mb_in',TG_Inball='$tg_in',MB_Inball_HR='$mb_in_v',TG_Inball_HR='$tg_in_v' where Type='".$gtype."' and MID='".$gid."'";
mysql_query($mysql) or die ("error!");
echo "<SCRIPT language='javascript'>self.location='match.php?uid=$uid&langx=$langx&gtype=$gtype';</script>";
/*echo "<SCRIPT language='javascript'>javascript:history.go( -3 );</script>";*/
?>
