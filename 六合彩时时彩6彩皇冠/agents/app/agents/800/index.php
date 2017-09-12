<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");  
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");    
header("Cache-Control: no-store, no-cache, must-revalidate");    
header("Cache-Control: post-check=0, pre-check=0", false);    
header("Pragma: no-cache"); 
header("Content-type: text/html; charset=utf-8");

include ("../../agents/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");
require ("../../agents/include/define_function_list.inc.php"); 

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];
require ("../../agents/include/traditional.$langx.inc.php");

$sql = "select website,Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
   $web='web_system_data';
}else{
   $web='web_agents_data';
}
switch ($lv){
case 'M':
	$user='Admin';
	break;	
case 'A':
	$user='Super';
	break;
case 'B':
	$user='Corprator';
	break;
case 'C':
	$user='World';
	break;
case 'D':
    $user='Agents';
	break;
}
$sql = "select ID,UserName,Language,SubUser,SubName from $web where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$row = mysql_fetch_array($result);
$name=$row['UserName'];
$subUser=$row['SubUser'];
if ($subUser==0){
	$name=$row['UserName'];
}else{
	$name=$row['SubName'];
}
$sql = "select * from web_member_data where $user='$name' and Pay_Type=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou<>0){
	echo "<script languag='JavaScript'>self.location='user_list_800.php?uid=$uid&lv=$lv&langx=$langx'</script>";
}else{
	echo "<script languag='JavaScript'>alert('目前还没有会员，请添加后再操作!!');history.go( -1 );</script>";
}
?>