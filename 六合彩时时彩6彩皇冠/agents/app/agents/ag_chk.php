<?
session_start();
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
require ("./include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$loginname=$_REQUEST['username'];
require ("./include/traditional.$langx.inc.php");
$mysql = "select LoginName from web_agents_data where LoginName='$loginname'";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if ($loginname==''){
    echo "<SCRIPT language='javascript'>alert('$Ag_Login_ID_has_not_input');</script>";
}else{
if ($cou==0){
	echo "<SCRIPT language='javascript'>alert('$Ag_You_can_using_this_ID');</script>";
}else{
	echo "<SCRIPT language='javascript'>alert('$Ag_This_ID_has_been_used');</script>";
}
}
?>