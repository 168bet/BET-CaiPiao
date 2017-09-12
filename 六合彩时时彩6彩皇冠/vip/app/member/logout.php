<?
session_start();
include "./include/address.mem.php";
require ("./include/config.inc.php");
$uid=$_REQUEST['uid'];
$sql = "update web_member_data set Oid='logout',online=0,LogoutTime=now() where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
mysql_db_query($dbname,$sql) or die ("操作失败!");
echo "<script>top.location.href='".BROWSER_IP."';</script>";
?>

