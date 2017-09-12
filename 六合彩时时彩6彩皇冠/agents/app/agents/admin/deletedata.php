<?
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>";
require ("../include/config.inc.php");
//print_r($_REQUEST);
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$sql = "select * from web_system_data where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['gtype'];
$date_start=$_REQUEST['date_start'];
if ($gid!='' and $gtype!=''){
	$mysql="delete from match_sports where MID='".$gid."' and  Type='".$gtype."'";
	mysql_db_query($dbname,$mysql) or die("操作失败!");
	echo "<script language='javascript'>location.href='play_game.php?gtype=$gtype&uid=$uid&date_start=$date_start&langx=$langx';</script>";
	exit();
}
?>