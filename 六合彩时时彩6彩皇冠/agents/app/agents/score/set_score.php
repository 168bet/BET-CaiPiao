<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$action=$_REQUEST['action'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['gtype'];
$rtype=$_REQUEST['rtype'];

$sql = "select M_Date,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,M_Time,MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where Type='".$gtype."' and MID='".$gid."'";
$result = mysql_query( $sql);
$row=mysql_fetch_array($result)
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
  if (document.all.mb_inball_v.value==''){
    document.all.mb_inball_v.focus();
    alert("请输入主队上半场进球数!!");
    return false;
  }
  if (document.all.tg_inball_v.value==''){
    document.all.tg_inball_v.focus();
    alert("请输入客队上半场进球数!!");
    return false;
  }  
  if (document.all.mb_inball.value==''){
    document.all.mb_inball.focus();
    alert("请输入主队全场进球数!!");
    return false;
  }
  if (document.all.tg_inball.value==''){
    document.all.tg_inball.focus();
    alert("请输入客队全场进球数!!");
    return false;
  } 
  if(!confirm("主队半场进球数："+document.all.mb_inball_v.value+"  主队全场进球数："+document.all.mb_inball.value+"\n\n客队半场进球数："+document.all.tg_inball_v.value+"  客队全场进球数："+document.all.tg_inball.value+"\n\n请确定输入是否正确?")){return false;}
}

function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("进球数只能输入数字!!"); return false;}
	//if (isNaN(event.keyCode) == true)){alert("下注金额仅能输入数字!!"); return false;}
}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<FORM NAME="LAYOUTFORM" onSubmit="return SubChk();" ACTION="../clearing/clearing<?=$gtype?>.php?uid=<?=$uid?>&gid=<?=$gid?>&gtype=<?=$gtype?>&rtype=<?=$rtype?>&langx=<?=$langx?>" METHOD=POST>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="m_tline" width="965">&nbsp;线上操盘－<font color="#CC0000">添写比分&nbsp;</font>&nbsp;&nbsp;&nbsp;日期:<%=date_start%>~<%=date_end%> -- 下注管道:网路下注 -- <a href="javascript:history.go( -1 );">回上一頁</a>              
      </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr> 
      <td colspan="2" height="4"></td>
    </tr>
  </table>
<table width="500" border="0" cellspacing="1" cellpadding="0" class="m_tab">
  <tr class="m_title" > 
      <td width="80">时间</td>
      <td width="275">主客队伍</td>
      <td width="70">上半进球数</td>
      <td width="70">全场进球数</td>
    </tr>
  <tr class="m_rig"> 
    <td align="center" colspan="4"><?=$row['M_League']?></td>
    </tr>
  <tr class="m_cen"> 
      <td rowspan="2" width="80" align="center"><?=$row['M_Date']?><br>
      <?=$row['M_Time']?></td>
      <td width="275" rowspan="2" align="left"><?=$row['MB_Team']?><br>
      <?=$row['TG_Team']?></td>
      <td width="70" align="center"><input name="mb_inball_v" type="text" class="za_text" onKeyPress="return CheckKey()" value="<?=$row['MB_Inball_HR']?>" size="5"></td>
      <td width="70" align="center"><input name="mb_inball" type="text" class="za_text" value="<?=$row['MB_Inball']?>" size="5"></td>
    </tr>
  <tr class="m_cen"> 
      <td width="70" align="center"><input name="tg_inball_v" type="text" class="za_text" onKeyPress="return CheckKey()" value="<?=$row['TG_Inball_HR']?>"  size="5"></td>
      <td width="70" align="center"><input name="tg_inball" type="text" class="za_text" value="<?=$row['TG_Inball']?>"  size="5"></td>
    </tr>
  </table>
<table width="500" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="15" width="500" align="center"><br><input type="submit" value=" 提 交 " name="subject" class="za_button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value=" 清 除 " name="cancel" class="za_button"></td>
</tr>
</table>
</form>
</body>
</html>
