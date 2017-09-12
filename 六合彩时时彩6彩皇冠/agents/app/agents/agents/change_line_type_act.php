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
$linetype=$_REQUEST["line_type"];
require ("../../agents/include/traditional.$langx.inc.php");

$ip_addr = get_ip();
switch ($lv){
case 'A':
    $data='web_system_data';
	$agents="Super='$name'";
	break;
case 'B':
    $Title=$Mem_Corprator;
    $data='web_agents_data';
	$agents="Corprator='$name'";
	break;
case 'C':
    $Title=$Mem_World;
    $data='web_agents_data';
	$agents="World='$name'";
	break;
case 'D':
    $Title=$Mem_Agents;
    $data='web_agents_data';
	$agents="Agents='$name'";
	break;
case 'MEM':
    $Title=$Mem_Member;
    $data='web_agents_data';
	$agents="UserName='$name'";
	break;
}
$loginfo='更改'.$Title.':'.$name.'正负水盘设定';		
$sql = "select * from $data where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$username=$row['UserName'];
if ($lv!='MEM'){
    $mysql="update web_agents_data set LineType='$linetype' where ID='$tid' or $agents";
    mysql_db_query($dbname,$mysql);
}
    $mysql="update web_member_data set LineType='$linetype' where $agents";
    mysql_db_query($dbname,$mysql);
	$logsql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$username',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
    mysql_db_query($dbname,$logsql);
    echo "<Script Language=javascript>self.location='user_browse.php?uid=$uid&lv=$lv&langx=$langx';</script>";
	
		
?>
