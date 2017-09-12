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
$type=$_REQUEST["type"];

require ("../include/traditional.$langx.inc.php");
//echo "asdf";exit;
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
switch ($type){
case "Currency":
	$mysql="update web_type_class set RMB_Rate=".$_REQUEST['RMB_Rate'].",RMB_Rates=".$_REQUEST['RMB_Rates'].",HKD_Rate=".$_REQUEST['HKD_Rate'].",HKD_Rates=".$_REQUEST['HKD_Rates'].",USD_Rate=".$_REQUEST['USD_Rate'].",USD_Rates=".$_REQUEST['USD_Rates'].",MYR_Rate=".$_REQUEST['MYR_Rate'].",MYR_Rates=".$_REQUEST['MYR_Rates'].",SGD_Rate=".$_REQUEST['SGD_Rate'].",SGD_Rates=".$_REQUEST['SGD_Rates'].",THB_Rate=".$_REQUEST['THB_Rate'].",THB_Rates=".$_REQUEST['THB_Rates'].",GBP_Rate=".$_REQUEST['GBP_Rate'].",GBP_Rates=".$_REQUEST['GBP_Rates'].",JPY_Rate=".$_REQUEST['JPY_Rate'].",JPY_Rates=".$_REQUEST['JPY_Rates'].",EUR_Rate=".$_REQUEST['EUR_Rate'].",EUR_Rates=".$_REQUEST['EUR_Rates']." where ID='1'";
	mysql_db_query($dbname,$mysql);
break;
}
$mysql = "select * from web_type_class  where ID='1'";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);	
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="m_tline"> 
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
            <td width="85" >&nbsp;&nbsp;<?=$Mnu_Current?></td>
          </tr>
        </table>
      </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr> 
      <td colspan="2" height="4"></td>
    </tr>

</table>
<table width="600" border="0" cellspacing="1" cellpadding="0"  class="m_tab">
  <form name=Currency action="" method=post>
  <tr class="m_title"> 
    <td width="148"><?=$Mem_currency?></td>
    <td width="148"><?=$Mem_code?></td>
    <td width="150"><?=$Mem_Today_Exchange?></td>
    <td width="149"><?=$Mem_Radioset?></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_RMB?></td>
    <td><?=$row['RMB']?></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['RMB_Rate']?>" name=RMB_Rate></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['RMB_Rates']?>" name=RMB_Rates></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_HKD?></td>
    <td><?=$row['HKD']?></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['HKD_Rate']?>" name=HKD_Rate></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['HKD_Rates']?>" name=HKD_Rates></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_USD?></td>
    <td><?=$row['USD']?></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['USD_Rate']?>" name=USD_Rate></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['USD_Rates']?>" name=USD_Rates></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_MYR?></td>
    <td><?=$row['MYR']?></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['MYR_Rate']?>" name=MYR_Rate></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['MYR_Rates']?>" name=MYR_Rates></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_SGD?></td>
    <td><?=$row['SGD']?></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['SGD_Rate']?>" name=SGD_Rate></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['SGD_Rates']?>" name=SGD_Rates></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_THB?></td>
    <td><?=$row['THB']?></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['THB_Rate']?>" name=THB_Rate></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['THB_Rates']?>" name=THB_Rates></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_GBP?></td>
    <td><?=$row['GBP']?></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['GBP_Rate']?>" name=GBP_Rate></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['GBP_Rates']?>" name=GBP_Rates></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_JPY?></td>
    <td><?=$row['JPY']?></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['JPY_Rate']?>" name=JPY_Rate></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['JPY_Rates']?>" name=JPY_Rates></td>
  </tr>
  <tr  class="m_cen" > 
    <td><?=$Mem_radio_EUR?></td>
    <td><?=$row['EUR']?></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['EUR_Rate']?>" name=EUR_Rate></td>
    <td><input class=za_text  maxLength=11 size=5 value="<?=$row['EUR_Rates']?>" name=EUR_Rates></td>
  </tr>
  <tr  class="m_cen" > 
    <td colspan="4"><input class=za_button type=submit value="确定" name=show_ok></td>
	<input type=hidden value="Currency" name=type>
    </tr>
  </form>
</table>
</body>
</html>