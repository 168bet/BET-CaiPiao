<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

require ("../../agents/include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$lv=$_REQUEST["lv"];
$username = $_REQUEST['username'];
require ("../../agents/include/traditional.$langx.inc.php");

if($lv=='MEM'){
$data='web_member_data';
}else{
$data='web_agents_data';
}
$sql = "select * from $data where UserName='$username'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if ($cou<=0){
	echo "<SCRIPT language='javascript'>alert('$Mem_Account_Available!!');</script>";
}else{
	echo "<SCRIPT language='javascript'>alert('$Mem_Account_NO_Available!!');</script>";
}
?>