<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'\n;</script>";
require ("../include/config.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$type=$_REQUEST["type"];
include ("../include/online.php");
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$id=$row['ID']; 
switch ($type){
case "UID":
	$mysql="update web_system_data set uid='".$_REQUEST['SC1']."',uid_tw='".$_REQUEST['SC2']."',uid_en='".$_REQUEST['SC3']."',datasite='".$_REQUEST['SC4']."',datasite_en='".$_REQUEST['SC6']."',datasite_tw='".$_REQUEST['SC5']."',Name='".$_REQUEST['Name']."',Passwd='".$_REQUEST['Passwd']."',Name_tw='".$_REQUEST['Name_tw']."',Passwd_tw='".$_REQUEST['Passwd_tw']."',Name_en='".$_REQUEST['Name_en']."',Passwd_en='".$_REQUEST['Passwd_en']."',InUid='".$_REQUEST['InUid']."',InUid_tw='".$_REQUEST['InUid_tw']."',InUid_en='".$_REQUEST['InUid_en']."',InUrl='".$_REQUEST['InUrl']."',InName='".$_REQUEST['InName']."',InPasswd='".$_REQUEST['InPasswd']."',InName_tw='".$_REQUEST['InName_tw']."',InPasswd_tw='".$_REQUEST['InPasswd_tw']."',InName_en='".$_REQUEST['InName_en']."',InPasswd_en='".$_REQUEST['InPasswd_en']."',SunUid='".$_REQUEST['SunUid']."',SunUid_tw='".$_REQUEST['SunUid_tw']."',SunUid_en='".$_REQUEST['SunUid_en']."',SunUrl='".$_REQUEST['SunUrl']."',SunName='".$_REQUEST['SunName']."',SunPasswd='".$_REQUEST['SunPasswd']."',SunName_tw='".$_REQUEST['SunName_tw']."',SunPasswd_tw='".$_REQUEST['SunPasswd_tw']."',SunName_en='".$_REQUEST['SunName_en']."',SunPasswd_en='".$_REQUEST['SunPasswd_en']."'";
	mysql_query($mysql);
	break;
case "MAX":
	$mysql="update web_system_data set R=".$_REQUEST['M1'].",OU=".$_REQUEST['M2'].",M=".$_REQUEST['M3'].",RE=".$_REQUEST['M4'].",ROU=".$_REQUEST['M5'].",PD=".$_REQUEST['M6'].",T=".$_REQUEST['M7'].",F=".$_REQUEST['M8'].",P=".$_REQUEST['M9'].",PC=".$_REQUEST['M10'].",FS=".$_REQUEST['M11'].",MAX=".$_REQUEST['M12'];
	mysql_query($mysql);
	break;
case "ST":
	$mysql="update web_system_data set Website=".(int)$_REQUEST['SC3'].",systime='".$_REQUEST['systime']."'";
	mysql_query($mysql);
	$mysql="update web_member_data set Oid='logout'";
	mysql_query($mysql);
	$mysql="update web_agents_data set Oid='logout'";
	mysql_query($mysql);
	break;
case "TM":
	$mysql="update web_system_data set systime='".$_REQUEST['SC1']."'";
	mysql_query($mysql);
	break;
case "LANGX":
	$mysql="update web_system_data set Msg_Member='".$_REQUEST['Msg_Member']."',Msg_Member_tw='".$_REQUEST['Msg_Member_tw']."',Msg_Agents='".$_REQUEST['Msg_Agents']."',Msg_Agents_tw='".$_REQUEST['Msg_Agents_tw']."',Msg_World='".$_REQUEST['Msg_World']."',Msg_World_tw='".$_REQUEST['Msg_World_tw']."',Msg_Corprator='".$_REQUEST['Msg_Corprator']."',Msg_Corprator_tw='".$_REQUEST['Msg_Corprator_tw']."' where ID='".$id."'";
	mysql_query($mysql);
	break;	
case "NOUD":
	$mysql="update web_system_data set msg_update=".$_REQUEST['set'];
	mysql_query($mysql);
	break;
case "SIX":
	$mysql="update number_num set MID='".$_REQUEST['mid']."',M_Date='".$_REQUEST['date']."',M_Time='".$_REQUEST['time']."',M_Start='".$_REQUEST['start']."'";
	mysql_query($mysql);
	break;
case "OPEN":
	$mysql="update number_num set Open=".(int)$_REQUEST['open']."";
	mysql_query($mysql);
	break;
case "NUMID":
	$mysql="update web_system_data set OUID='".$_REQUEST['ouid']."',DTID='".$_REQUEST['dtid']."',PMID='".$_REQUEST['pmid']."'";
	mysql_query($mysql);
	break;
case "Url":
	$mysql="update web_system_data set Member_Url='".$_REQUEST['member_url']."',Agent_Url='".$_REQUEST['agent_url']."',Admin_Url='".$_REQUEST['admin_url']."'";
	mysql_query($mysql);
	break;
}
$sql = "select * from number_num";
$result = mysql_query($sql);
$num = mysql_fetch_array($result);
$m_time=date('m/d/Y H:i:s',strtotime($num['M_Time']));
$m_start=date('m/d/Y H:i:s',strtotime($num['M_Start']));
$gid=$num['MID'];
if ($gid<100 and $gid>9){		 
	$mid='0'.$gid;
}else if($num<10){
	$mid='00'.$gid;
}else{
	$mid=$gid;
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language=JavaScript>
var now  = new Date("<?=date('m/d/Y H:i:s')?>");

function GetServerTime(){
    var urodz     = new Date("<?=$m_time?>");
    now.setTime(now.getTime()+250);
    days    = (urodz - now) / 1000 / 60 / 60 / 24;
    daysRound   = Math.floor(days);
    hours    = (urodz - now) / 1000 / 60 / 60 - (24 * daysRound);
    hoursRound   = Math.floor(hours);
    minutes   = (urodz - now) / 1000 /60 - (24 * 60 * daysRound) - (60 * hoursRound);
    minutesRound  = Math.floor(minutes);
    seconds   = (urodz - now) / 1000 - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) - (60 * minutesRound);
    secondsRound  = Math.round(seconds);
    //document.getElementById("date").innerHTML   = daysRound;
    //document.getElementById("time").innerHTML   = hoursRound + ":" + minutesRound + ":" + secondsRound;
    if (daysRound < 0){
        m_time.innerHTML="<b><font color=green>已经开盘</font></b>"; 
    }else{ 
        m_time.innerHTML="<b><font color=green>距离开盘时间还有"+daysRound+"天"+hoursRound+"小时"+minutesRound+"分"+secondsRound+"秒"+"</font></b>"; 
    }	
}
setInterval("GetServerTime()",250);
</script>
<script language=JavaScript>
var now  = new Date("<?=date('m/d/Y H:i:s')?>");

function GetServerStart(){
    var urodz     = new Date("<?=$m_start?>");
    now.setTime(now.getTime()+250);
    days    = (urodz - now) / 1000 / 60 / 60 / 24;
    daysRound   = Math.floor(days);
    hours    = (urodz - now) / 1000 / 60 / 60 - (24 * daysRound);
    hoursRound   = Math.floor(hours);
    minutes   = (urodz - now) / 1000 /60 - (24 * 60 * daysRound) - (60 * hoursRound);
    minutesRound  = Math.floor(minutes);
    seconds   = (urodz - now) / 1000 - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) - (60 * minutesRound);
    secondsRound  = Math.round(seconds);
    //document.getElementById("date").innerHTML   = daysRound;
    //document.getElementById("time").innerHTML   = hoursRound + ":" + minutesRound + ":" + secondsRound;
    if (daysRound < 0){
        m_start.innerHTML="<b><font color=red>已经封盘</font></b>"; 
    }else{ 
        m_start.innerHTML="<b><font color=red>距离封盘时间还有"+daysRound+"天"+hoursRound+"小时"+minutesRound+"分"+secondsRound+"秒"+"</font></b>"; 
    }	
}
setInterval("GetServerStart()",250);
</script>
<script>
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;
    <a href=system.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?> target="main" title="系统参数" onMouseOver="window.status='系统参数'; return true;" onMouseOut="window.status='';return true;">系统参数</a>&nbsp;&nbsp;
    <a href=add_notice.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?> target="main" title="系统公告" onMouseOver="window.status='系统公告'; return true;" onMouseOut="window.status='';return true;">系统公告</a>&nbsp;&nbsp;
    <a href=news.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&action=opennews target="main" title="系统短信" onMouseOver="window.status='系统短信'; return true;" onMouseOut="window.status='';return true;">系统短信</a>&nbsp;&nbsp;
    <a href=news.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&action=sitenews target="main" title="系统消息" onMouseOver="window.status='系统消息'; return true;" onMouseOut="window.status='';return true;">系统消息</a>&nbsp;&nbsp;
	<a href=../adminmsg/index.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?> target="main" title="会员消息" onMouseOver="window.status='系统公告'; return true;" onMouseOut="window.status='';return true;">会员消息</a>&nbsp;&nbsp;
    <a href="access.php?uid=<?=$uid?>&langx=<?=$langx?>&action=S">会员存款</a>&nbsp;&nbsp;
    <a href="access.php?uid=<?=$uid?>&langx=<?=$langx?>&action=T">会员提款</a>
	</td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
<form name=UID action="" method=post>
  <TR class="m_title">
    <td width=70>网站名称</td> 
    <td width=210>数据网址</td>
    <td width=210>简体UID</td>
    <td width=210>繁体UID</td>
	<td width=210>英文UID</td>
	<td width=58>&nbsp; </td>
  </TR>
  <TR class=m_cen>
      <td>新宝简体</td> 
      <td><input class=za_text  maxLength=30 size=30 value="<?=$row['datasite']?>" name=SC4></td>
      <td><input class=za_text size=30 value="<?=$row['Uid']?>" name=SC1></td>
	  <td><input class=za_text size=30 value="<?=$row['Uid_tw']?>" name=SC2></td>
	  <td><input class=za_text size=30 value="<?=$row['Uid_en']?>" name=SC3></td>
      <td width="58" rowspan="6"><input class=za_button type=submit value="确定" name=ft_ch_ok11></td>
        <input type=hidden value="UID" name=type>
  </TR>
  <TR class=m_cen>
      <td>新宝繁体</td> 
      <td><input class=za_text  maxLength=30 size=30 value="<?=$row['datasite_tw']?>" name=SC5></td>
      <td>帐号 <input class=za_text size=6 value="<?=$row['Name']?>" name=Name>密码 <input class=za_text size=6 value="<?=$row['Passwd']?>" name=Passwd></td>
	  <td>帐号 <input class=za_text size=6 value="<?=$row['Name_tw']?>" name=Name_tw>密码 <input class=za_text size=6 value="<?=$row['Passwd_tw']?>" name=Passwd_tw></td>
	  <td>帐号 <input class=za_text size=6 value="<?=$row['Name_en']?>" name=Name_en>密码 <input class=za_text size=6 value="<?=$row['Passwd_en']?>" name=Passwd_en></td>
  </TR>
  <TR class=m_cen>
      <td width="70">新宝英文</td> 
      <td width="210"><input class=za_text  maxLength=30 size=30 value="<?=$row['datasite_en']?>" name=SC6></td>
      <td width="210"></td>
	  <td width="210"></td>
	  <td width="210"></td>
  </TR>
  <!--TR class=m_cen>
      <td width="70">太阳城</td> 
      <td width="210"><input class=za_text  maxLength=30 size=30 value="<?=$row['SunUrl']?>" name=SunUrl></td>
      <td width="210"><input class=za_text size=30 value="<?=$row['SunUid']?>" name=SunUid></td>
	  <td width="210"><input class=za_text size=30 value="<?=$row['SunUid_tw']?>" name=SunUid_tw></td>
	  <td width="210"><input class=za_text size=30 value="<?=$row['SunUid_en']?>" name=SunUid_en></td>
  </TR>
  <TR class=m_cen>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td>帐号 <input class=za_text size=6 value="<?=$row['SunName']?>" name=SunName>密码 <input class=za_text size=6 value="<?=$row['SunPasswd']?>" name=SunPasswd></td>
	  <td>帐号 <input class=za_text size=6 value="<?=$row['SunName_tw']?>" name=SunName_tw>密码 <input class=za_text size=6 value="<?=$row['SunPasswd_tw']?>" name=SunPasswd_tw></td>
	  <td>帐号 <input class=za_text size=6 value="<?=$row['SunName_en']?>" name=SunName_en>密码 <input class=za_text size=6 value="<?=$row['SunPasswd_en']?>" name=SunPasswd_en></td>
  </TR-->
</form>
</table>
<br>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
  <TR class="m_title">
    <td width="300">会员-地址</td>
    <td width="300">代理-地址</td>
    <td width="300">管理-地址</td>
    <td width="70">功能</td>
  </tr>
  <form name=Url action="" method=post>
    <TR class=m_cen>
      <td><input class=za_text maxlength=100 size=50 value="<?=$row['Member_Url']?>" name=member_url></td>
      <td><input class=za_text maxlength=100 size=50 value="<?=$row['Agent_Url']?>" name=agent_url></td>
	  <td><input class=za_text maxlength=100 size=50 value="<?=$row['Admin_Url']?>" name=admin_url></td>
      <td><input class=za_button type=submit value="设定" name=url_ok></td>
          <input type=hidden value="Url" name=type>
    </TR>
  </form>
</table>
<br>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
<form name=LANGX action="" method=post>  
  <TR class="m_title"> 
    <td width=100>语种</td>
    <td>弹窗公告内容</td>
    <td width=65></td>
  </TR>
    <TR class=m_cen> 
      <td>会员简体：</td>
      <td align=right><input class=za_text  maxLength=250 size=155 value="<?=$row['Msg_Member']?>" name=Msg_Member></td>
      <td rowspan="8"><input class=za_button type=submit value="确定" name=ft_ch_ok2></td>
      <input type=hidden value="LANGX" name=type>
    </TR>
    <TR class=m_cen> 
      <td>会员繁体：</td>
      <td align=right><input class=za_text  maxlength=250 size=155 value="<?=$row['Msg_Member_tw']?>" name=Msg_Member_tw></td>
    </TR>
    <TR class=m_cen> 
      <td>代理简体：</td>
      <td align=right><input class=za_text  maxLength=250 size=155 value="<?=$row['Msg_Agents']?>" name=Msg_Agents></td>
    </TR>
    <TR class=m_cen> 
      <td>代理繁体：</td>
      <td align=right><input class=za_text  maxlength=250 size=155 value="<?=$row['Msg_Agents_tw']?>" name=Msg_Agents_tw></td>
    </TR>
    <TR class=m_cen> 
      <td>总代简体：</td>
      <td align=right><input class=za_text  maxLength=250 size=155 value="<?=$row['Msg_World']?>" name=Msg_World></td>
    </TR>
    <TR class=m_cen> 
      <td>总代繁体：</td>
      <td align=right><input class=za_text  maxlength=250 size=155 value="<?=$row['Msg_World_tw']?>" name=Msg_World_tw></td>
    </TR>
    <TR class=m_cen> 
      <td>股东简体：</td>
      <td align=right><input class=za_text  maxLength=250 size=155 value="<?=$row['Msg_Corprator']?>" name=Msg_Corprator></td>
    </TR>
    <TR class=m_cen> 
      <td>股东繁体：</td>
      <td align=right><input class=za_text  maxlength=250 size=155 value="<?=$row['Msg_Corprator_tw']?>" name=Msg_Corprator_tw></td>
    </TR>
	
  </form>
</table>
<br>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
  <form name=FTR action="" method=post>
    <TR class=m_cen> 
      <td width="60" class="m_title">系统维护：</td>
      <td width="93" > 
          <input type="radio" name="SC3" value=1 <?
if ($row['Website']==1){
		echo "checked";
}		?>
>
          是 
          <input type="radio" name="SC3" value=0 <?
if ($row['Website']==0){
		echo "checked";
}		?>
>
      否</td><td width="66" class="m_title">维护公告：</td>
      <td width="600"><input class=za_text  maxLength=300 size=120 value="<?=$row[systime]?>" name=systime></div></td>
      <td width="75"><input class=za_button type=submit value="确定" name=ft_ch_ok10></td>
<input type=hidden value="ST" name=type>
    </TR>
  </form>
</table>
<br>
</body>
</html>
