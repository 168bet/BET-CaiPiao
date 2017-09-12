<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../../agents/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$lv=$_REQUEST["lv"];
$tid=$_REQUEST["tid"];
$name=$_REQUEST["name"];
$agents=trim($_REQUEST["agents"]);
require ("../../agents/include/traditional.$langx.inc.php");

$sql = "select * from web_agents_data where UserName='$agents'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$world=$row['World'];
$corprator=$row['Corprator'];
$super=$row['Super'];
$admin=$row['Admin'];
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<SCRIPT language='javascript'>alert('请输入正确的代理商账号!!');</script>";
}else{
$mysql="update web_member_data set agents='$agents',World='$world',Corprator='$corprator',Super='$super',Admin='$admin' where ID='$tid'";
mysql_db_query($dbname,$mysql);
$rsql="update web_report_data set agents='$agents',World='$world',Corprator='$corprator',Super='$super',Admin='$admin' where M_Name='$name'";
mysql_db_query($dbname,$rsql);
}
echo "<Script Language=javascript>self.location='user_browse.php?uid=$uid&lv=$lv&langx=$langx';</script>";
?>
