<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$id=$_REQUEST["id"];
$type=$_REQUEST['type'];
$page=$_REQUEST["page"];
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$action=$_REQUEST['action'];
if ($action=='ok'){
	$mysql="update match_league set R='".$_REQUEST['r']."',OU='".$_REQUEST['ou']."',VR='".$_REQUEST['vr']."',VOU='".$_REQUEST['vou']."',M='".$_REQUEST['m']."',VM='".$_REQUEST['vm']."',RB='".$_REQUEST['rb']."',ROU='".$_REQUEST['rou']."',VRB='".$_REQUEST['vrb']."',VROU='".$_REQUEST['vrou']."',RM='".$_REQUEST['rm']."',VRM='".$_REQUEST['vrm']."',EO='".$_REQUEST['eo']."',PD='".$_REQUEST['pd']."',T='".$_REQUEST['t']."',F='".$_REQUEST['f']."',CS='".$_REQUEST['cs']."' where ID='$id'";
	mysql_db_query($dbname,$mysql);
	echo "<SCRIPT language='javascript'>self.location='./league.php?uid=$uid&langx=$langx&type=$type&page=$page';</script>";
}
$mysql = "select * from match_league where ID='$id'";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language="JavaScript">
function SubChk(){
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
<FORM NAME="myFORM" onSubmit="return SubChk();" ACTION="" METHOD=POST>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="m_tline" width="965">&nbsp;联盟单注限制&nbsp;--&nbsp;<font color="#CC0000">单注修改</font>&nbsp;--&nbsp;<a href="javascript:history.go( -1 );">回上一頁</a>                    
      </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr> 
      <td colspan="2" height="4"></td>
    </tr>
</table>
<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab" width="975">
  <tr class="m_title" >
    <td>ID</td>
    <td colspan="2">赛事联盟</td>
    <td>类型</td>
    <td>单注限制</td>
    <td>类型</td>
    <td>单注限制</td>
    <td>类型</td>
    <td>单注限制</td>
    <td>类型</td>
    <td>单注限制</td>
  </tr>
  <tr class="m_left" > 
      <td width="45" rowspan="4" align="center"><?=$row["ID"]?></td>
      <td colspan="2" rowspan="3"><?=$row["M_League"]?></td>
      <td width="80">全场让球</td>
      <td width="80"><input name="r" size="5" maxlength="7" class="za_text" value="<?=$row['R'];?>"></td>
      <td width="80">全场滚球让球</td>
      <td width="80"><input name="rb" size="5" maxlength="7" class="za_text" value="<?=$row['RB'];?>"></td>
      <td width="80">全场独赢</td>
      <td width="80"><input name="m" size="5" maxlength="7" class="za_text" value="<?=$row['M'];?>"></td>
      <td width="80">单双</td>
      <td width="80"><input name="eo" size="5" maxlength="7" class="za_text" value="<?=$row['EO'];?>"></td>
    </tr>
  
  <tr class="m_left">
    <td>全场大小球</td>
    <td><input name="ou" size="5" maxlength="7" class="za_text" value="<?=$row['OU']?>"></td>
    <td>全场滚球大小</td>
    <td><input name="rou" size="5" maxlength="7" class="za_text" value="<?=$row["ROU"]?>"></td>
    <td>上半独赢</td>
    <td><input name="vm" size="5" maxlength="7" class="za_text" value="<?=$row['VM'];?>"></td>
    <td>波胆</td>
    <td><input name="pd" size="5" maxlength="7" class="za_text" value="<?=$row['PD'];?>"></td>
  </tr>
  <tr class="m_left">
    <td>上半让球</td>
    <td><input name="vr" size="5" maxlength="7" class="za_text" value="<?=$row['VR'];?>"></td>
    <td>上半滚球让球</td>
    <td><input name="vrb" size="5" maxlength="7" class="za_text" value="<?=$row['VRB'];?>"></td>
    <td>全场滚球独赢</td>
    <td><input name="rm" size="5" maxlength="7" class="za_text" value="<?=$row['RM'];?>"></td>
    <td>总入球</td>
    <td><input name="t" size="5" maxlength="7" class="za_text" value="<?=$row['T'];?>"></td>
  </tr>
  <tr class="m_left">
    <td width="198" align="right">特殊类</td>
    <td width="80"><input name="cs" size="5" maxlength="7" class="za_text" value="<?=$row['CS'];?>"></td>
    <td>上半大小球</td>
    <td><input name="vou" size="5" maxlength="7" class="za_text" value="<?=$row['VOU'];?>"></td>
    <td>上半滚球大小</td>
    <td><input name="vrou" size="5" maxlength="7" class="za_text" value="<?=$row['VROU'];?>"></td>
    <td>上半滚球独赢</td>
    <td><input name="vrm" size="5" maxlength="7" class="za_text" value="<?=$row['VRM'];?>"></td>
    <td>半全场</td>
    <td><input name="f" size="5" maxlength="7" class="za_text" value="<?=$row['F'];?>"></td>
  </tr>
  
  <tr class="m_cen">
    <td height="15" colspan="11"><br>
      <input type="submit" value=" 提 交 " name="B1" class="za_button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value=" 清 除 " name="B2" class="za_button">
  　  </td>
      <input type=hidden value="ok" name=action>
    </tr>
  <tr class="m_cen">
    <td colspan="11">说明</td>
    </tr>
</table>
</form>
</body>
</html>