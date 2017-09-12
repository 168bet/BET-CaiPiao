<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST["langx"];
$loginname=$_SESSION["loginname"];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$id=$_REQUEST['id'];
$name=$_REQUEST['name'];
$form_action=$_REQUEST['form_action'];
$action=$_REQUEST["action"];
$active=$_REQUEST["active"];
if ($form_action=='Y'){
	$msg=$_REQUEST['scoll_news'];
	$msg_tw=$_REQUEST['scoll_news_tw'];
	$msg_en=$_REQUEST['scoll_news_en'];
	$date=date('Y-m-d');
	$time=date('Y-m-d H:i:s');
	
	$sql = "select UserName from web_message_data where UserName='$name'";
	$result = mysql_db_query($dbname,$sql);	
	$cou=mysql_num_rows($result);
	if ($cou==0){
	    $mysql="insert into web_message_data(UserName,Message,Message_tw,Message_en,Time,Date) values ('$name','$msg','$msg_tw','$msg_en','$time','$date')";
	    mysql_db_query($dbname,$mysql);
	    echo "<Script language=javascript>self.location='news.php?uid=$uid&langx=$langx&action=opennews';</script>";		
	}else{
	    $mysql="update web_message_data set UserName='$name',Message='$msg',Message_tw='$msg_tw',Message_en='$msg_en',Time='$time',Date='$date' where UserName='$name'";
 	    mysql_db_query($dbname,$mysql);
	    echo "<Script language=javascript>self.location='news.php?uid=$uid&langx=$langx&action=opennews';</script>";	
	}	
}
if ($active=='del'){
	$mysql="delete from web_message_data where ID='$id'";
	mysql_db_query($dbname,$mysql);
	echo "<Script language=javascript>self.location='news.php?uid=$uid&langx=$langx&action=opennews';</script>";	
}else if  ($active=='del'){
	$mysql="delete from web_member_data where ID='$id'";
	mysql_db_query($dbname,$mysql);
	echo "<Script language=javascript>self.location='news.php?uid=$uid&langx=$langx&action=sitenews';</script>";
}else if  ($active=='edit'){
	$mysql="update web_member_data set Notes='".$_REQUEST['Notes']."',Phone='".$_REQUEST['Phone']."',Alias='".$_REQUEST['Alias']."' where ID='$id'";
	mysql_db_query($dbname,$mysql);
	echo "<Script language=javascript>self.location='news.php?uid=$uid&langx=$langx&action=sitenews';</script>";
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language="javascript">
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
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
<?
if ($action=='opennews'){
?>
<table width="800" border="0" cellpadding="0" cellspacing="1" class="m_tab">
<form method="post" name='SCROLL_FROM' action="">
    <tr class="m_title">
      <td colspan="4" align="center">系统短信</td>
    <tr class="m_cen"> 
      <td width="185" align="right">帐号:</td>
      <td width="612" colspan="3" align="left"><input name="name" type="text" value=""></td>
    <tr class="m_cen">
      <td width="185" align="right">更新简体短信息:</td>
      <td colspan="3"><textarea name="scoll_news" cols="85" rows="2" wrap="PHYSICAL"></textarea></td>
    <tr class="m_cen">
      <td align="right">更新繁体短信息:</td>
      <td colspan="3"><textarea name="scoll_news_tw" cols="85" rows="2" wrap="PHYSICAL"></textarea></td>
    <tr class="m_cen"> 
      <td align="right">更新英文短信息:</td>
      <td colspan="3"><textarea name="scoll_news_en" cols="85" rows="2" wrap="PHYSICAL"></textarea></td>
    <tr align="center" class="m_cen"> 
      <td colspan="4">
	  <input type="submit" value="确定"  name="Submit" class="za_button">
	  <input type="reset" value="取消"  name="Reset" class="za_button">
      <input type="hidden" name="form_action" value="Y">
      </td>
    </tr>
</form>
</table>
<BR>
<table width="800" border="0" cellpadding="2" cellspacing="1" class="m_tab">
	<tr class="m_title">
	  <td colspan="5">短信息</td>
	</tr>
	<tr class="m_title">
	  <td width="40">编号</td>
	  <td width="60">帐号</td>
	  <td width="80">新增时间</td>
	  <td width="554">内容</td>
	<td width="40">功能</td>
	</tr>
<?
$i=1;
$sql = "select ID,UserName,Date,$message as Message from web_message_data order by ID desc";
$result = mysql_db_query($dbname, $sql);
while ($row = mysql_fetch_array($result)){
?>
  <tr class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this)> 
      
    <td align="center"><?=$i?></td>
    <td align="center"><font color=red><?=$row['UserName']?></font></td>
    <td align="center"><?=$row['Date']?></td>
    <td align="left"><?=$row['Message']?></td>
    <td align="center"><a href="news.php?uid=<?=$uid?>&id=<?=$row['ID']?>&active=del&name=<?=$row['UserName']?>&langx=<?=$langx?>">删除</a></td>
<?
$i=$i+1;
}
?>
  </tr>
</table>
<?
}else if ($action=='sitenews'){
?>
<table width="975" border="0" cellpadding="2" cellspacing="1" class="m_tab">
	<tr class="m_title">
	  <td colspan="10">系统消息</td>
	</tr>
	<tr class="m_title">
	  <td width="30">编号</td>
	  <td width="60">名字</td>
	  <td width="80">日期</td>
	  <td width="192">内容</td>
	  <td width="90">电话号码</td>
	  <td width="80">QQ<br>Skype</td>
	  <td width="120">电邮信箱</td>
	  <td width="100">IP</td>
	  <td width="140">网址</td>
	<td width="32">功能</td>
	</tr>
<?
$i=1;
$sql = "select ID,Name,Phone,QQnum,Mail,Content,IP,Url,Date from web_contact_data  order by ID desc";//ORDER BY ID DESC ";
$result = mysql_db_query($dbname, $sql);
while ($row = mysql_fetch_array($result)){
$date=strtotime($row['Date']);
$datetime=date("Y-m-d",$date).'<br>'.date("H:i:s",$date);
?>
  <tr class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this)> 
      
    <td align="center"><?=$i?></td>
    <td align="center"><font color=red><?=$row['Name']?></font></td>
    <td align="center"><?=$datetime?></td>
	<td align="left"><textarea cols="25" rows="3" wrap="PHYSICAL"><?=$row['Content']?></textarea></td>
    <td align="center"><?=$row['Phone']?></td>
    <td align="center"><?=$row['QQnum']?></td>
    <td align="center"><?=$row['Mail']?></td>
    <td align="center"><?=$row['IP']?></td>
    <td align="center"><?=$row['Url']?></td>
    <td align="center"><a href="news.php?uid=<?=$uid?>&id=<?=$row['ID']?>&active=del&langx=<?=$langx?>">删除</a></td>
<?
$i=$i+1;
}
?>
  </tr>
</table>
<?
}
?>
</body>
</html>