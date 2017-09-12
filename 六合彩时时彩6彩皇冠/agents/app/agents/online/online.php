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
$username=$_REQUEST['username'];
$active=$_REQUEST['active'];
$level=$_REQUEST['level'];
$lv=$_REQUEST['lv'];
$name=$_REQUEST['name'];
//exit;
//include ("../include/online.php");
if ($_REQUEST['online']!=""){
$memsql="select Online from web_member_data where Online=1";
$memresult=mysql_db_query($dbname,$memsql);
$memcou=mysql_num_rows($memresult);
echo $memcou;
exit;
}
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$date=date('Y-m-d');
if ($active==1){
	$sql = "update web_member_data set Oid='logout',Online='0',LogoutTime=now() where UserName='$username'";
	mysql_db_query($dbname,$sql);
	$sql = "update web_agents_data set Oid='logout',Online='0',LogoutTime=now() where UserName='$username'";
	mysql_db_query($dbname,$sql);

}
if($level==''){
   $level='member';
}
if($level=='member' or $level==''){
   $data='web_member_data';
}else if($level=='agents'){
   $data='web_agents_data';
}
if ($name!=''){
$n_sql="and UserName like '%$name%'";
}else{
$n_sql='';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>在线人数</title>
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<SCRIPT>
function onLoad(){
  var level = document.getElementById('level');
  level.value = '<?=$level?>';
}
function OpenIP(url) { 
window.open(url,'IP','width=300,height=200');
}
</SCRIPT>
</head>
<!--meta http-equiv="refresh" content="30; url=online.php?uid=<?=$uid?>&langx=<?=$langx?>$lv=M"-->
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
<FORM NAME="myFORM" ACTION="" METHOD=POST>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="547" class="m_tline">&nbsp;在线人数&nbsp;&nbsp;&nbsp;
	    <select class=za_select onchange=document.myFORM.submit(); name=level>
          　<option value="member">会员</option>
			<option value="agents">代理</option>
	    </select>
		&nbsp;&nbsp;&nbsp;在线帐号&nbsp;&nbsp;&nbsp;
		<input name="name" type="text" id="name" value="<?=$name?>" size="10">&nbsp;&nbsp;&nbsp;<input class=za_button type="submit" name="Submit" value="提交">	</td>
    <td width="418" class="m_tline">点击账号踢线</td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="3" height="4"></td>
  </tr>
</table>
<table width="975" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"> 
	
        <table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
          <tr  class="m_title"> 
            <td width="34">序 号</td>
            <td width="60">账 号</td>
            <td width="60">名 称</td>
            <td width="75">信用额度</td>
            <td width="75">现金额度</td>
            <td width="125">登陆时间</td>
            <td width="125">活动时间</td>
            <td width="130">登陆网址</td>
           <td width="281">登陆IP和地区</td>
          </tr>
<?
$i=1;
$sql="select * from $data where Online=1 and Oid!='logout' and LoginDate='$date' $n_sql order by id desc";
//echo $sql;
$result=mysql_db_query($dbname,$sql);
if($myrow=mysql_fetch_array($result)){
do
{
$mamname=$myrow['Memname'];

?>
          <tr class="m_cen" onMouseOut="this.style.backgroundColor=''" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgcolor="#FFFFFF"> 
            <td ><? echo $i?></td>
            <td ><a href="online.php?uid=<?=$uid?>&langx=<?=$langx?>&active=1&username=<?=$myrow["UserName"]?>&level=<?=$level?>"><? echo $myrow["UserName"]?></a></td>
            <td ><?=$myrow["Alias"]?></td>
            <td  align="right"><?=number_format($myrow["Money"],0)?></td>
            <td  align="right"><?=number_format($myrow["Credit"],0)?></td>
            <td ><?=$myrow["LoginTime"]?></td>
            <td ><?=$myrow["OnlineTime"]?></td>
            <td ><font color="#ff0000"><?=$myrow["Url"]?></font></td>
            <td ><?=$myrow["LoginIP"]?>&nbsp;&nbsp;<script src="ip.php?ip=<?=$myrow['LoginIP']?>"></script><!--<a href="javascript:OpenIP('openip.php?ip=<?=$myrow["LoginIP"]?>')">查询</a>--></td>
          </tr>
<?
$i++;
}
while ($myrow=mysql_fetch_array($result));
}else{
    	echo "<tr height=20><td colspan=9 ><font color=#FFFFFF><div align=center>无人在线</div></font></td></tr>";
}
?>
      </table>
    </td>
  </tr>
</table>
</form>
</body>
</html>
