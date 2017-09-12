<?
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache"); 
include "./include/address.mem.php";
require ("./include/config.inc.php");
$uid=$_REQUEST['uid'];
$sql = "update web_agents_data set Oid='logout',Online=0,LogoutTime=now() where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
mysql_db_query($dbname,$sql) or die ("²Ù×÷Ê§°Ü!");
echo "<script>top.location.href='/';</script>";
?>
