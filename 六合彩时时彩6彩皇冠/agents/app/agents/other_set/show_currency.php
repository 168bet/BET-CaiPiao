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
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
include ("../include/online.php");
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_agents_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$row = mysql_fetch_array($result);
$username=$row['UserName'];
$mysql = "select * from web_type_class  where ID='1'";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);

?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_co_ed {  background-color: #baccc1; text-align: right}
.m_title_set {  background-color: #86C0A6; text-align: center}
.STYLE1 {color: #FF0000}
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="LAYOUTFORM" action="" method=POST >
    <input type="HIDDEN" name="active" value="0">
    <tr> 
      <td class="m_tline"> 
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
            <td width="85" >&nbsp;&nbsp;<?=$Mnu_current?></td>
          </tr>
        </table>
      </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr> 
      <td colspan="2" height="4"></td>
    </tr>
  </form>
</table>
  <table width="600" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">
  <tr class="m_title_set"> 
    <td width="148" ><?=$Mem_currency?></td>
    <td width="148"><?=$Mem_code?></td>
    <td width="150"><?=$Mem_curradio?></td>
    <td width="149"><?=$Mem_radioset?></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_RMB?></td>
    <td><?=$row['RMB']?></td>
    <td><?=$row['RMB_Rate']?></td>
    <td><?=$row['RMB_Rates']?></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_HKD?></td>
    <td><?=$row['HKD']?></td>
    <td><?=$row['HKD_Rate']?></td>
    <td><?=$row['HKD_Rates']?></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_USD?></td>
    <td><?=$row['USD']?></td>
    <td><?=$row['USD_Rate']?></td>
    <td><?=$row['USD_Rates']?></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_MYR?></td>
    <td><?=$row['MYR']?></td>
    <td><?=$row['MYR_Rate']?></td>
    <td><?=$row['MYR_Rates']?></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_SGD?></td>
    <td><?=$row['SGD']?></td>
    <td><?=$row['SGD_Rate']?></td>
    <td><?=$row['SGD_Rates']?></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_THB?></td>
    <td><?=$row['THB']?></td>
    <td><?=$row['THB_Rate']?></td>
    <td><?=$row['THB_Rates']?></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_GBP?></td>
    <td><?=$row['GBP']?></td>
    <td><?=$row['GBP_Rate']?></td>
    <td><?=$row['GBP_Rates']?></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_JPY?></td>
    <td><?=$row['JPY']?></td>
    <td><?=$row['JPY_Rate']?></td>
    <td><?=$row['JPY_Rates']?></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_EUR?></td>
    <td><?=$row['EUR']?></td>
    <td><?=$row['EUR_Rate']?></td>
    <td><?=$row['EUR_Rates']?></td>
  </tr>
</table>
</body>
</html>
<?
$ip_addr = get_ip();
$loginfo='查询币值';
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$username',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>
