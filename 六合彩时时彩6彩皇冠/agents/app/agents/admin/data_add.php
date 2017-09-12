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
$type=$_REQUEST['type'];
$gtype=$_REQUEST['gtype'];

$mysql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
if ($gtype=='FT'){
	$match='足球';
}else if ($gtype=='BK'){
	$match='篮球';
}else if ($gtype=='TN'){
	$match='网球';
}else if ($gtype=='VB'){
	$match='排球';
}else if ($gtype=='BS'){
	$match='棒球';
}else if ($gtype=='OP'){
	$match='其它';
}
$datetime=date("Y-m-d h:i:s");
$date=date('Y-m-d');

if($type=='data_add'){
	$sql="insert into match_sports set MID='".$_REQUEST['mid']."',Type='".$gtype."',M_Date='".$_REQUEST['date']."',M_Time='".$_REQUEST['time']."',M_Start='".$_REQUEST['start']."',MB_Team='".$_REQUEST['mb_team']."',TG_Team='".$_REQUEST['tg_team']."',MB_Team_tw='".$_REQUEST['mb_team_tw']."',TG_Team_tw='".$_REQUEST['tg_team_tw']."',MB_Team_en='".$_REQUEST['mb_team_en']."',TG_Team_en='".$_REQUEST['tg_team_en']."',M_League='".$_REQUEST['m_league']."',M_League_tw='".$_REQUEST['m_league_tw']."',M_League_en='".$_REQUEST['m_league_en']."'";
	mysql_db_query($dbname,$sql);
	echo "<SCRIPT language='javascript'>alert('新增".$match."赛事成功');self.location='play_game.php?uid=$uid&gtype=$gtype&langx=$langx';</script>";
}
?>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language=javascript>
function SubChk(){
  if (document.all.mid.value==''){
    document.all.mid.focus();
    alert("请输入相对应赛事的MID!!");
    return false;
  }
  if (document.all.date.value==''){
    document.all.date.focus();
    alert("请输入相对应赛事的日期!!");
    return false;
  }
  if (document.all.time.value==''){
    document.all.time.focus();
    alert("请输入相对应赛事的时间!!");
    return false;
  }
  if (document.all.start.value==''){
    document.all.start.focus();
    alert("请输入相对应赛事的开赛时间!!");
    return false;
  }
  if (document.all.m_league.value==''){
    document.all.m_league.focus();
    alert("请输入简体 联盟!!");
    return false;
  }
  if (document.all.mb_Team.value==''){
    document.all.mb_Team.focus();
    alert("请输入简体 主队名!!");
    return false;
  }
  if (document.all.tg_Team.value==''){
    document.all.tg_Team.focus();
    alert("请输入简体 客队名!!");
    return false;
  }
  if(!confirm("赛事 MID："+document.all.mid.value+"\n\n赛事 日期："+document.all.date.value+"\n\n赛事 时间："+document.all.time.value+"\n\n赛事 开赛时间："+document.all.start.value+"\n\n简体 联盟："+document.all.m_league.value+"\n\n简体 主队名："+document.all.mb_Team.value+"\n\n简体 主队名："+document.all.tg_Team.value+"\n\n请确定输入是否正确?")){return false;}
}
</script>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<table width="98%"  border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="m_tline" style="border-bottom: solid 1px #000;"> 
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
            <td width="100%" >&nbsp;&nbsp;说明：MID是针对赛事的标志，请把相对应的MID填写正确&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:history.go( -1 );">回上一頁</a>&nbsp;&nbsp;</font></font></td>
          </tr>
        </table>
      </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr> 
      <td colspan="2" height="4"></td>
    </tr>
</table>  
<table width="410" border="0" cellspacing="1" cellpadding="0" class="m_tab">
   <form name="MYFORM" onSubmit="return SubChk();" method="post" action="">
        <tr class="m_title">
          <td colspan="2"><font color=red><b><?=$match?></b></font>-赛事新增</td>
        </tr>
        <tr class="m_rig_re">
		  <td width="80">MID：</td>
          <td width="327" align="left"><input name="mid" type="text" size="10" maxlength="10"></td>
        </tr>
        <tr class="m_rig_re">
          <td>日期：</td>
          <td align="left"><input name="date" type="text" value="<?=$date?>" size="10" maxlength="10"></td>
        </tr>
        <tr class="m_rig_re">
          <td>时间：</td>
          <td align="left"><input name="time" type="text" size="10" maxlength="10"></td>
        </tr>
        <tr class="m_rig_re">
          <td>开赛时间：</td>
          <td align="left"><input name="start" type="text" value="<?=$datetime?>" size="15" maxlength="20"></td>
        </tr>
        <tr class="m_rig_re">
          <td rowspan="3">简体队名：</td>
          <td align="left"><input name="m_league" type="text" size="40" maxlength="50">(联盟)</td>
        </tr>
		<tr class="m_rig_re">
          <td align="left"><input name="mb_team" type="text" size="40" maxlength="50">(主队)</td>
        </tr>
        <tr class="m_rig_re">
          <td align="left"><input name="tg_team" type="text" size="40" maxlength="50">(客队)</td>
        </tr>
        <tr class="m_rig_re">
          <td rowspan="3">繁体队名：</td>
		  <td align="left"><input name="m_league_tw" type="text" size="40" maxlength="50">(联盟)</td>
        </tr>
		<tr class="m_rig_re">
          <td align="left"><input name="mb_team_tw" type="text" size="40" maxlength="50">(主队)</td>
        </tr>
        <tr class="m_rig_re">
          <td align="left"><input name="tg_team_tw" type="text" size="40" maxlength="50">(客队)</td>
        </tr>
        <tr class="m_rig_re">
          <td rowspan="3">英文队名：</td>
		  <td align="left"><input name="m_league_en" type="text" size="40" maxlength="50">(联盟)</td>
        </tr>
		<tr class="m_rig_re">
          <td align="left"><input name="mb_team_en" type="text" size="40" maxlength="50">(主队)</td>
        </tr>
        <tr class="m_rig_re">
          <td align="left"><input name="tg_team_en" type="text" size="40" maxlength="50">(客队)</td>
        </tr>
        <tr class="m_rig_re">
          <td colspan="2" align="center"><input class=za_button type="submit" name="Submit" value="提交"></td>
		<input type=hidden value="data_add" name=type>
        </tr>
	</form>	
</table>    
</BODY>
</html>