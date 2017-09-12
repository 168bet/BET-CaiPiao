<?
require ("config.inc.php");
$uid=$_REQUEST['uid'];
$datetime=date('Y-m-d H:i:s',time());
$outtime=date('Y-m-d H:i:s',time()-60*30);
$sql = "update web_member_data set Online=1,OnlineTime='$datetime' where Oid='$uid'";
mysql_db_query($dbname,$sql) or die ("²Ù×÷Ê§°Ü!");
$outsql = "update web_member_data set Online=0 where OnlineTime<'$outtime'";
mysql_db_query($dbname,$outsql) or die ("²Ù×÷Ê§°Ü!");
?>
