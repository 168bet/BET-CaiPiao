<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];
include "../include/online.php";
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$date_start=$_REQUEST['date_start'];
$agents_id=$_REQUEST['agents_id'];
$uid=$_REQUEST['uid'];
$name=$_REQUEST['name'];
$active=$_REQUEST['active'];
$page=$_REQUEST["page"];
$search=$_REQUEST["search"];
$seconds=$_REQUEST["seconds"];

$datetime=date("Y-m-d H:i:s",time()-10*86400);//10天数
$sql = "delete from web_mem_log_data where LoginTime <'$datetime'";
mysql_db_query($dbname,$sql);

if ($active==1){
	$sql = "update web_agents_data set Oid='logout',Online=0,LogoutTime=now() where UserName='$name'";
	mysql_db_query($dbname,$sql);	
	$sql = "update web_system_data set Oid='logout',Online=0,LogoutTime=now() where UserName='$name'";
	mysql_db_query($dbname,$sql);
	$sql = "delete from web_mem_log_data where UserName='$name'";
	mysql_db_query($dbname,$sql);
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
if ($search!=''){
    $search="and (UserName like '%$search%' or LoginTime like '%$search%' or Level like '%$search%')";
}
$parents_id=$_REQUEST['parents_id'];

if ($parents_id==''){
    $sql = "select * from web_mem_log_data where LoginTime like '%$date_start%' $search group by UserName order by ID desc";
}else{
    $sql = "select * from web_mem_log_data where LoginTime like '%$date_start%' and UserName='$parents_id' group by UserName order by ID desc";
}
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
$page_size=20;
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
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script type="text/javascript" src="/js/agents/user_search.js" ></script>
<script>
function sbar(st){
	st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
	st.style.backgroundColor='';
}
function OpenIP(url) { 
window.open(url,'IP','width=300,height=200');
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
		window.location.href='syslog.php?uid=<?=$uid?>&langx=<?=$langx?>&lv=<?=$lv?>&date_start=<?=$date_start?>&parents_id=<?=$parents_id?>&seconds=<?=$seconds?>&page=<?=$page?>'; //刷新页面
	}else{
		second-=1
		curmin=Math.floor(second)
		curtime=curmin+"秒自动更新"
		ShowTime.innerText=curtime
		setTimeout("auto_refresh()",1000)
	}
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad();auto_refresh()">
<form name="myFORM" action="" method=POST>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="140">&nbsp;线上数据－<font color="#CC0000">日志</font></td>
      <td width="225" class="m_tline">
      <select class="za_select" onChange="document.myFORM.submit();" name="seconds">
        <option value="10">10秒</option>
        <option value="30">30秒</option>
        <option value="60">60秒</option>
        <option value="90">90秒</option>
        <option value="120">120秒</option>
        <option value="180">180秒</option>
      </select>&nbsp;&nbsp;&nbsp;<span id="ShowTime"></span></td>         
      <td class="m_tline" width="35">日期:</td>
      <td class="m_tline" width="100">
	  <select class="za_select" onChange="document.myFORM.submit();" name="date_start">
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
      <td class="m_tline" width="35">帐户:</td>
      <td class="m_tline" width="146">
	  <select name="parents_id" onChange="self.myFORM.submit()" class="za_select">
              <option label="全部" value="">全部</option>
			  <?
	          $mysql = "select UserName,Level from web_mem_log_data where Level!='' and LoginTime like '%$date_start%' and UserName!='dan555' and UserName!='dan222' group by UserName order by ID desc";
	          $aresult = mysql_db_query($dbname,$mysql);
				while ($arow = mysql_fetch_array($aresult)){
					if ($parents_id==$arow['UserName']){
						echo "<option value=".$arow['UserName']." selected>".$arow['UserName']."===".$arow['Level']."</option>";				
						$sel_agents=$arow['UserName'];
					}else{
						echo "<option value=".$arow['UserName'].">".$arow['UserName']."===".$arow['Level']."</option>";
					}
				}
				?>
      </select></td>
      <td class="m_tline" width="75">
	  <input type=BUTTON name="btn_search" value="快速查詢" onClick="showSearchDlg();" class="za_button"></input></td>
      <td class="m_tline" width="50"><input type="hidden" name="search" value=""></td>
      <td class="m_tline" width="55">总页数:</td>
      <td class="m_tline" width="40">
	  <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
              <?
		      for($i=0;$i<$page_count;$i++){
			      echo "<option value='$i'>".($i+1)."</option>";
		         }
		      ?>
      </select></td>
      <td class="m_tline" width="64"> / <?=$page_count?>  頁</td>
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
    <td width="50">序 号</td> 
    <td width="70">帐 号</td>
    <td width="70">级 别</td>
    <td width="140">登陆时间</td>
    <td width="247">登陆网址</td>
    <td width="290">登陆IP和地区</td>
    <td width="100">操 作</td>
  </tr>
<?
$i=1;
if ($row = mysql_fetch_array($result)){
do
{
?>
  <tr class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this)>
    <td width="50"><?=$i?></td> 
    <td width="70"><?=$row["UserName"]?></td>
    <td width="70"><?=$row['Level']?></td>
    <td width="140"><font color="#CC0000"><?=$row["LoginTime"]?></font></td>
    <td width="247" align="center"><?=$row["Url"]?></td>
    <td><?=$row["LoginIP"]?>&nbsp;<script src="../online/ip.php?ip=<?=$row['LoginIP']?>"></script><!--<a href="javascript:OpenIP('../online/openip.php?ip=<?=$row["LoginIP"]?>')">查询</a>--></td>
    <td width="100"><div align="center">
	<a href="showlog.php?uid=<?=$uid?>&name=<?=$row["UserName"]?>&langx=<?=$langx?>">查看</a>&nbsp;/ 
	<a href="syslog.php?uid=<?=$uid?>&active=1&name=<?=$row["UserName"]?>&level=<?=$row["Level"]?>&langx=<?=$langx?>">&nbsp;踢线</a>
	</div></td>
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
<!--快速查詢跳出視窗-->
<div id="searchDlg" style="display: none;position: absolute;">
    <table border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
      <tr>
        <td bgcolor="#FFFFFF">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix" >
            <tr bgcolor="0163A2">
              <td><font color="#FFFFFF">快速查詢</font><font color="#FFFFFF" id="eo_title"></font></td>
              <td align="right" valign="top" ><a style="cursor:hand;" onClick="closeSearchDlg();"><img src="/images/agents/top/edit_dot.gif" width="16" height="14"></a></td>
            </tr>
          </table>
        </td>
      </tr>
 	   <tr>
 	     <td bgcolor="#FFFFFF">
          <table border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix" >
            <tr bgcolor="#000000">
              <td colspan="2" height="1"></td>
            </tr>
            <tr bgcolor="#A4C0CE">
              <td>查詢條件</td>
              <td>
              	<select name="dlg_option" class="za_select">
					<option label="管理级别" value="ALIAS">级别</option>
					<option label="管理帳號" value="USERNAME" selected="selected">帳號</option>
					<option label="登陆日期" value="NEW_DATE">日期</option>

              	</select>
              </td>
            </tr>
            <tr bgcolor="#000000">
              <td colspan="2" height="1"></td>
            </tr>
            <tr bgcolor="#A4C0CE">
            <td>關鍵字</td>
              <td>
                <input type=text id="dlg_text" value="" class="za_text" size="10" maxlength="10">
              </td>
            </tr>
            <tr bgcolor="#000000">
              <td colspan="2" height="1"></td>
            </tr>
            <tr>
              <td align="center" colspan="2">
                <input type="submit" id="dlg_ok" value="查詢" class="za_button" onClick="submitSearchDlg();">
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
</div>
</body>
</html>