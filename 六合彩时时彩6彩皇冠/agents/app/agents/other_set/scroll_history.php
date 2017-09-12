<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include "../include/address.mem.php";
require ("../include/config.inc.php");
$uid=$_REQUEST["uid"];
$lv=$_REQUEST['lv'];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$sql = "select * from web_agents_data where Oid='$uid' and LoginName='$loginname' and Status<=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$username=$row['UserName'];
require ("../include/traditional.$langx.inc.php");
?>

<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
  
<table width="485" border="0" cellspacing="1" cellpadding="0"  bgcolor="2A73AC" class="m_tab">
  <tr>
    <tr><?=$scroll_Caption?></tr>
  <tr class="m_title_bk" > 
    <td width="40"  align="center"><?=$Messageid?></td>
    <td width="65"  align="center"><?=$Times?></td>
    <td><?=$Scroll_Message?></td>
  </tr>
	<?
	$sql="select Date,$message as Message from web_marquee_data where Level='MEM' order by ID desc";
	$result = mysql_db_query($dbname,$sql);
	$icount=1;
	while ($row = mysql_fetch_array($result)){
	$time=strtotime($row['Date']);
	$times=date("y-m-d",$time);
	?>
  <tr class="m_cen"> 
      <td align="center"><?=$icount?></td>
      <td align="center"><?=$times?></td>
      <td align="left"><font color="#CC0000"><?=$row['Message']?></font></td>
  </tr>
<?
$icount=$icount+1;
 if($icount>20) 
    {   break;   } 
}
mysql_close();
?> 
</table>
</body>
</html>
