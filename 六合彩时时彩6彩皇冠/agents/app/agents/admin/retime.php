<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['gtype'];
$mysql = "select * from match_sports where mid='".$gid."' and Type='".$gtype."'";

$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$action=$_REQUEST['action'];

if ($action==1){
	$m_Date=$_REQUEST['m_date'];
	$m_Time=$_REQUEST['m_time'];
	
	$m_letb=$_REQUEST['m_letb'];
	$mb_letb_rate=$_REQUEST['mb_letb_rate'];	
	$tg_letb_rate=$_REQUEST['tg_letb_rate'];	
	
	$mb_dime=$_REQUEST['mb_dime'];
	$tg_dime=$_REQUEST['tg_dime'];	
	$mb_dime_rate=$_REQUEST['mb_dime_rate'];
	$tg_dime_rate=$_REQUEST['tg_dime_rate'];
	
	
	$m_letb_h=$_REQUEST['m_letb_h'];
	$mb_letb_rate_h=$_REQUEST['mb_letb_rate_h'];	
	$tg_letb_rate_h=$_REQUEST['tg_letb_rate_h'];
	
	$mb_dime_h=$_REQUEST['mb_dime_h'];
	$tg_dime_h=$_REQUEST['tg_dime_h'];	
	$mb_dime_rate_h=$_REQUEST['mb_dime_rate_h'];
	$tg_dime_rate_h=$_REQUEST['tg_dime_rate_h'];
	
		
	$hhmmstr=explode(":",$m_Time);
	$hh=$hhmmstr[0];
	$ap=substr($m_Time,strlen($m_Time)-1,1); 
	
	if ($ap=='p' and $hh<>12){
		$hh+=12;
	}
	$timestamp =$m_Date." ".$hh.":".substr($hhmmstr[1],0,strlen($hhmmstr[1])-1).":00";


	$mysql="update match_sports set m_start='$timestamp',M_Date='$m_Date',M_Time='$m_Time',M_LetB='$m_letb',MB_LetB_Rate='$mb_letb_rate',TG_LetB_Rate='$tg_letb_rate',MB_Dime='$mb_dime',TG_Dime='$tg_dime',MB_Dime_Rate='$mb_dime_rate',TG_Dime_Rate='$tg_dime_rate',M_LetB_H='$m_letb_h',MB_LetB_Rate_H='$mb_letb_rate_h',TG_LetB_Rate_H='$tg_letb_rate_h',MB_Dime_H='$mb_dime_h',TG_Dime_H='$tg_dime_h',MB_Dime_Rate_H='$mb_dime_rate_h',TG_Dime_Rate_H='$tg_dime_rate_h' where mid='$gid'";
	//echo $mysql;
	//exit;
	mysql_db_query($dbname,$mysql);
	echo "<SCRIPT language='javascript'>self.location='./play_game.php?uid=$uid&langx=$langx';</script>";
}
?>
<html>
<head>
<title>reports_member</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title {  background-color: #687780; text-align: center; color: #FFFFFF}
.m_title_2 { background-color: #CC0000; text-align: center; color: #FFFFFF}
-->
</style>
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language="JavaScript">
function SubChk()
{
  if (document.all.m_date.value==''){
    document.all.m_date.focus();
    alert("请输入比赛日期!!");
    return false;
  }
  if (document.all.m_time.value==''){
    document.all.m_time.focus();
    alert("请输入比赛时间!!");
    return false;
  } 
  if(!confirm("日期更改为："+document.all.m_date.value+"\n时间更改为："+document.all.m_time.value+"\n\n请确定输入是否正确?")){return false;}
}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<FORM NAME="LAYOUTFORM" onSubmit="return SubChk();" ACTION="retime.php?uid=<?=$uid?>&langx=<?=$langx?>&gid=<?=$gid?>&action=1" METHOD=POST>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="m_tline" width="965">&nbsp;线上操盘－<font color="#CC0000">比赛时间赔率变更&nbsp;</font>&nbsp;&nbsp;&nbsp;日期:<%=date_start%>~<%=date_end%> -- 下注管道:网路下注 -- <a href="javascript:history.go( -1 );">回上一頁</a>                    
      </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr> 
      <td colspan="2" height="4"></td>
    </tr>
  </table>
<table width="975" border="0" cellspacing="1" cellpadding="0" class="m_tab">
  <tr class="m_title" > 
      <td width="81"> 时间</td>
    <td width="163"> 主客队伍</td>
      <td width="90">全场盘口</td>
      <td width="90">全场赔率</td>
      <td width="90">全场大小</td>
      <td width="90">全场大小</td>
      <td width="90">半场盘口</td>
      <td width="90">半场赔率</td>
      <td width="90">半场大小</td>
      <td width="90">半场大小</td>
    </tr>
    <tr class="m_cen"> 
      <td width="81"><p align="center"><input name="m_date" type="text" size="8" class="za_text" value="<?=$row["M_Date"]?>"><br><input name="m_time" type="text" size="3" class="za_text" value="<?=$row["M_Time"]?>"></p></td>

      <td width="163" rowspan="2" align="left"><?=$row["MB_Team"]?><br><?=$row["TG_Team"]?></td>
      <td width="90"><p align="center"><input name="m_letb" type="text" size="3" class="za_text" value="<?=$row['M_LetB']?>"></p></td>
      <td width="90"><p align="center"><input name="mb_letb_rate" type="text" size="3" class="za_text" value="<?=$row["MB_LetB_Rate"]?>"><br><input name="tg_letb_rate" type="text" size="3" class="za_text" value="<?=$row["TG_LetB_Rate"]?>"></p></td>
      <td width="90"><p align="center"><input name="mb_dime" type="text" size="4" class="za_text" value="<?=$row['MB_Dime'];?>"><br><input name="tg_dime" type="text" size="4" class="za_text" value="<?=$row["TG_Dime"]?>"></p></td>
      <td width="90"><p align="center"><input name="mb_dime_rate" type="text" size="3" class="za_text" value="<?=$row['MB_Dime_Rate'];?>"><br><input name="tg_dime_rate" type="text" size="3" class="za_text" value="<?=$row['TG_Dime_Rate'];?>"></p></td>
      <td width="90"><p align="center"><input name="m_letb_h" type="text" size="3" class="za_text" value="<?=$row['M_LetB_H'];?>"></p></td>
      <td width="90"><p align="center"><input name="mb_letb_rate_h" type="text" size="3" class="za_text" value="<?=$row["MB_LetB_Rate_H"]?>"><br><input name="tg_letb_rate_h" type="text" size="3" class="za_text" value="<?=$row["TG_LetB_Rate_H"]?>"></p></td>
      <td width="90"><p align="center"><input name="mb_dime_h" type="text" size="4" class="za_text" value="<?=$row['MB_Dime_H']?>"><br><input name="tg_dime_h" type="text" size="4" class="za_text" value="<?=$row["TG_Dime_H"]?>"></p></td>
      <td width="90"><p align="center"><input name="mb_dime_rate_h" type="text" size="3" class="za_text" value="<?=$row['MB_Dime_Rate_H'];?>"><br><input name="tg_dime_rate_h" type="text" size="3" class="za_text" value="<?=$row['TG_Dime_Rate_H']?>"></p></td>
    </tr>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="15" width="100%">
  <p align="center"><br>
  <input type="submit" value=" 提 交 " name="B1" class="za_button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
  <input type="reset" value=" 重 置 " name="B2" class="za_button">
  <p align="center">　</td>
</tr>
<tr>
<td height="15" width="436">
  <p align="center">说明：比赛时间为均为<font color="#CC0000">美东</font>时间！(a表示上午，p表示下午)</td>
</tr>
</table>
 
</form>
</body>
</html>