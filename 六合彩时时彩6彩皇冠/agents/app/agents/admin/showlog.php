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
$name=$_REQUEST['name'];
$seconds=$_REQUEST["seconds"];
$page=$_REQUEST["page"];
$date_start=$_REQUEST['date_start'];
require ("../include/traditional.$langx.inc.php");

$mysql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
if ($seconds==''){
	$seconds=180;
}
if ($date_start=='') {
	$date_start=date('m-d');
}
if ($page==''){
	$page=0;
}
$sql = "select * from web_mem_log_data where UserName='$name' and  LoginTime like '%$date_start%' order by LoginTime desc ";
$result = mysql_db_query($dbname, $sql);
$cou=mysql_num_rows($result);
$page_size=50;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
//echo $mysql;
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if ($cou==0){
	$page_count=1;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<script> 
function sbar(st){
	st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
	st.style.backgroundColor='';
}
function onLoad() {
    var obj_seconds = document.getElementById('seconds');
    obj_seconds.value = '<?=$seconds?>';
	var obj_date_start = document.getElementById('date_start');
    obj_date_start.value = '<?=$date_start?>';
	var obj_page = document.getElementById('page');
    obj_page.value = '<?=$page?>';
}
var second="<?=$seconds?>" 
function auto_refresh(){
	if (second==1){
		window.location.href='showlog.php?uid=<?=$uid?>&langx=<?=$langx?>&name=<?=$name?>&date_start=<?=$date_start?>&seconds=<?=$seconds?>&page=<?=$page?>'; //刷新页面
	}else{
		second-=1
		curmin=Math.floor(second)
		curtime=curmin+"秒自动更新"
		ShowTime.innerText=curtime
		setTimeout("auto_refresh()",1000)
	}
}
</script>
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad();auto_refresh()">
<form name="myFORM" action="" method=POST>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="140">&nbsp;线上数据－<font color="#CC0000">日志</font><font color="#CC0000">&nbsp;</font></td>
      <td width="226" class="m_tline">
      <select class="za_select" onChange="document.myFORM.submit();" name="seconds">
        <option value="10">10秒</option>
        <option value="30">30秒</option>
        <option value="60">60秒</option>
        <option value="90">90秒</option>
        <option value="120">120秒</option>
        <option value="180">180秒</option>
      </select>&nbsp;&nbsp;&nbsp;<span id=ShowTime></span></td>
      <td class="m_tline" width="35">日期:</td>
      <td class="m_tline" width="139">
	  <select class=za_select onchange=document.myFORM.submit(); name=date_start>
			  <option value=""></option> 
<?
$dd = 24*60*60;
$t = time();
$aa=0;
$bb=0;
for($i=0;$i<=10;$i++)
{
	$today=date('m-d',$t);
	if ($date_start==date('m-d',$t)){
		echo "<option value='$today' selected>".date('Y-m-d',$t)."</option>";	
	}else{
		echo "<option value='$today'>".date('Y-m-d',$t)."</option>";	
	}
$t -= $dd;
}
?>
	  </select></td>
      <td class="m_tline" width="137">
	  <select class=za_select onchange=document.myFORM.submit(); name=page>
              <?
		      for($i=0;$i<$page_count;$i++){
			      echo "<option value='$i'>".($i+1)."</option>";
		         }
		      ?>
      </select>
	   / <?=$page_count?>  <?=$Mem_Page?>	  </td>
      <td class="m_tline" width="288"><a href="javascript:history.go( -1 );">回上一頁</a></td>
               
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td> 
    </tr> 
</table> 
  <table width="774" border="0" cellspacing="0" cellpadding="0"> 
    <tr>  
      <td width="774" height="4"></td> 
    </tr> 
    <tr> 
      <td ></td> 
    </tr> 
  </table>
  
<table id="glist_table" border="0" cellspacing="1" cellpadding="0" class="m_tab" width="975">
  <tr class="m_title">
    <td width="51">序 号</td> 
    <td width="69">帐 号</td>
    <td width="69">级 别</td>
    <td width="139">活动时间</td>
    <td width="543">活动内容</td>
    <td width="97">登陆IP</td>
  </tr>
<?
$i=1;
if ($row = mysql_fetch_array($result)){
do
{
$username=$row['UserName'];
if(substr($username,0,1)=='a'){
   $level='公司';
}else if(substr($username,0,1)=='b'){
   $level='股东';
}else if(substr($username,0,1)=='c'){
   $level='总代理';
}else if(substr($username,0,1)=='d'){
   $level='代理商';
}
?>
  <tr class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this)>
    <td width="51"><?=$i?></td> 
    <td width="69"><?=$row["UserName"]?></td>
    <td width="69"><?=$level?></td>
    <td width="139"><font color="#CC0000"><?=$row["LoginTime"]?></font></td>
    <td width="543" align="left"><?=$row["ConText"]?></td>
    <td width="97"><?=$row["LoginIP"]?></td>
  </tr>
<?
$i++;
}
while ($row=mysql_fetch_array($result));
}else{
    	echo "<tr height=20><td colspan=9 ><font color=#FFFFFF><div align=center>现在没有代理在线</div></font></td></tr>";
}
?>
</table>
</form>
</body>
</html>