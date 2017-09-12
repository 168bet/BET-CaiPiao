<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");    
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");    
header("Cache-Control: no-store, no-cache, must-revalidate");    
header("Cache-Control: post-check=0, pre-check=0", false);    
header("Pragma: no-cache"); 
header("Content-type: text/html; charset=utf-8");

include ("../../agents/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];
require ("../../agents/include/traditional.$langx.inc.php");

$sql = "select website,Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
   $web='web_system_data';
}else{
   $web='web_agents_data';
}
switch ($lv){
case 'M':
	$user='Admin';
	break;	
case 'A':
	$user='Super';
	break;
case 'B':
	$user='Corprator';
	break;
case 'C':
	$user='World';
	break;
case 'D':
    $user='Agents';
	break;
}
$sql = "select ID,UserName,Language,SubUser,SubName from $web where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$row = mysql_fetch_array($result);
$subUser=$row['SubUser'];
if ($subUser==0){
	$name=$row['UserName'];
}else{
	$name=$row['SubName'];
}
$sql = "select ID,UserName,CurType from web_member_data where $user='$name' and Pay_Type=1";
$active=$_REQUEST['active'];
$memname=$_REQUEST['mid'];
//echo $memname;
$id=$_REQUEST['id'];
$gold=$_REQUEST['gold'];
$rtype=$_REQUEST['type'];
$date_start=$_REQUEST['date_start'];
$date_end=$_REQUEST['date_end'];
$page=$_REQUEST["page"];
if ($memname==''){
	$mem="";
}else{
	$mem="and UserName='$memname'";
}
if ($date_start==''){
	$date_start=date('Y-m-d');
}
if ($date_end==''){
	$date_end=date('Y-m-d');
}
if ($rtype==''){
	$type="";
}else{
	$type="and Type='$rtype'";
}
if ($page==''){
	$page=0;
}
$date=date('Y-m-d H:i:s');
if ($active=='Y'){
	$Sresult=mysql_db_query($dbname,"select Type from web_sys800_data where ID=".$id);
	$Srs=@mysql_fetch_array($Sresult);
	if($Srs[0]<>"T"){
	$mysql="update web_member_data set Money=Money+$gold where UserName='".$memname."'";
	mysql_db_query($dbname,$mysql);
	}
	$mysql="update web_sys800_data set Checked=1,User='$name',Date='$date' where ID=".$id;
	mysql_db_query($dbname,$mysql);
}else if ($active=='N'){
	$mysql="delete from web_sys800_data where ID=".$id;
	mysql_db_query($dbname,$mysql);
}
if ($mid==''){
	$sql="select * from web_sys800_data where $user='$name' $mem $type and AddDate>='$date_start' and AddDate<='$date_end'";
}else{
	$sql="select * from web_sys800_data where $user='$name' $mem $type and AddDate>='$date_start' and AddDate<='$date_end'";
}	
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
$page_size=50;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
//echo $mysql;
$result = mysql_db_query($dbname,$mysql);
if ($cou==0){
	$page_count=1;
}
$sql="select ID from web_sys800_data where Type='T' and Checked=0";
$noreadrs = mysql_db_query($dbname,$sql);
$noread=mysql_num_rows($noreadrs);
?>
<html>
<head>
<title>800系統</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<? if($noread>0){ ?>
<bgsound src="ring.mp3" loop="-1" volume="0" balance="0" />
<? } ?>
<script language="JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
// -->

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}

//-->
</script>
<script language="JavaScript" src="/js/agents/simplecalendar.js"></script>
<link rel="stylesheet" href="/style/agents/control_800main.css" type="text/css">
<link rel="stylesheet" href="/style/agents/control_calendar.css">
<style type="text/css">
<!--
.m_rig2 { background-color: #CCCCCC; text-align: right}
-->
</style>
</head>
<!--<base target="net_ctl_main">
<base target="_top">-->
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="D8B20C" alink="D8B20C" 
oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div id="Layer1" style="position:absolute; left:0px; top:17px; width:65px; height:40px; z-index:1; visibility: hidden" onMouseOver="MM_showHideLayers('Layer1','','show')" 
onMouseOut="MM_showHideLayers('Layer1','','hide')"> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" >
    <tr> 
      <td  class="mou"><a href="user_list_800.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>">帳戶查詢</a></td>
    </tr>
    <tr> 
      <td class="mou"  ><a href="user_edit_800.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>">存入帳戶</a></td>
    </tr>
  </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <FORM id="myFORM" ACTION="" METHOD=POST  name="FrmData">
  <tr> 
    <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
		    <td width="70" >&nbsp;&nbsp;&nbsp;<a href="user_list_800.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>" onMouseOver="MM_showHideLayers
('Layer1','','show')" onMouseOut="MM_showHideLayers('Layer1','','hide')"><font color="#990000">帳戶作業</font></a></td>
            <td width="50" >&nbsp;&nbsp;帳戶別:</td>
            <td width="49"> 
		<select name="mid" class="za_select">
		<option value="">全部</option>
<?
$msql = "select UserName,CurType from web_member_data where $user='$name' and Pay_Type=1";
$mresult = mysql_db_query($dbname,$msql);
while ($mrow = mysql_fetch_array($mresult)){
	echo "<option value=$mrow[UserName]>".$mrow['UserName']."==".$mrow['CurType']."</option>";
}
?>              </select>
            </td>
            <td width="68">&nbsp;--&nbsp;日期區間:</td>
            <td>
              <input type=TEXT name="date_start" size=10 maxlength=11 class="za_text" value="<?=$date_start?>">
              &nbsp;</td>
            <td><a href="javascript:void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) 
calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_start',true,'yyyy-mm-dd'); return false;"><img src="/images/agents/top/calendar.gif" 
name="imgCalendar" width="34" height="21" border="0"></a>&nbsp;</td>
            <td>~&nbsp;</td>
            <td>
              <input type=TEXT name="date_end" size=10 maxlength=10 class="za_text" value="<?=$date_end?>">
              &nbsp;</td>
            <td><a href="javascript:void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) 
calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_end',true,'yyyy-mm-dd'); return false;"><img src="/images/agents/top/calendar.gif" 
name="imgCalendar" width="34" height="21" border="0"></a>&nbsp;</td>
            <td width="70">&nbsp;--&nbsp;审核方式:</td>
            <td>
              <select name="type" class="za_select">
			  <option value="">全部</option>
			  <option value="S">存入</option>
			  <option value="T">提出</option>
			  <option value="O">下注</option>
			  <option value="W">贏</option>
			  <option value="L">輸</option>
			  <option value="N">和局</option>
			  <option value="M">修正</option>

              </select>
            </td>
            <td > &nbsp; 
              <input type=SUBMIT name="SUBMIT" value="查詢" class="za_button">
            </td>
            <td width="58">&nbsp;--&nbsp;總頁數:</td>
            <td> 
              <select id="page" name="page"  class="za_select" onChange="self.myFORM.submit()">
              <?
		      if ($page_count==0){
			      $page_count=1;
			  }
		      for($i=0;$i<$page_count;$i++){
			      echo "<option value='$i'>".($i+1)."</option>";
		       }
		      ?>
              </select>
            </td>
            <td> / <?=$page_count?> 頁</td>
          </tr>
        </table>
      </td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</FORM>
</table>
<table width="975" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_top">
      <table border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          <td >&nbsp;<img src="/images/agents/top/main_dot.gif" width="13" height="15">&nbsp; 
          </td>
          <td ><font color="#000099">帳戶查詢</font></td>
        </tr>
      </table>
    </td>
    <td width="221"><img src="/images/agents/800/800_title_p1.gif" width="221" height="31"></td>
  </tr>
</table>
<table width="975" border="0" cellspacing="0" cellpadding="0" class="m_tab">
  <tr>
    <td>
      <table width="960" border="1" cellspacing="2" cellpadding="0" class="m_tab_main" bordercolor="#CCCCCC">
        <tr class="m_title"> 
          <td width="80">會員帳號</td>
          <td width="90">姓名-电话</td>
          <td width="180">银行资料</td>
          <td width="50">幣別</td>
          <td width="70">金額</td>
          <td width="90">日期</td>
          <td width="80">審核帳號</td>
          <td width="140">審核日期</td>
          <td colspan="2">操作操作</td>
        </tr>
        <!-- BEGIN DYNAMIC BLOCK: row -->
<?
if ($cou==0){
?>
<tr class="m_cen"> 
          <td>目前沒有記錄</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
<?
}else{
while ($row = mysql_fetch_array($result)){
if($row['Type']=='T')
{
if($row['Checked']!=0 and $row['Gold']>0)
{
$gold-=$row['Gold'];
}
else
{
if($row['Checked']!=0)
{
$gold+=$row['Gold'];
}
//
}
}
else
{
$gold+=$row['Gold'];
}
switch($row['Type']){
case 'S':
   $type='存入';
break;
case 'T':
   $type='提出';
break;
}
?>
        <form  method=post target='_self'>
        <tr class="m_cen"> 
          <td><?=$row['UserName']?></td>
          <td><?=$row['Name']?><br><?=$row['Phone']?>&nbsp;</td>
          <td><?=$row['Bank']?><br><?=$row['Bank_Address']?><br><?=$row['Bank_Account']?>&nbsp;</td>
          <td><?=$row['CurType']?></td>

          <td align="right"><font color="<?=$row['Checked']!=0?"red":""?>"><?=$row['Type']=='T'?"-":""?><?=abs($row['Gold'])?></font></td>
          <td><?=$row['AddDate']?></td>
<?
if ($row['Checked']==0){
?>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>
<? if($row['Type']!='T'){?>
          <input type=submit name=send value='<?=$type?>審核' onClick="return confirm('確定審核此筆單')" class="za_button">

<?}else{

if($row['Gold']>0){
?>
<input type=submit name=send value='<?=$type?>審核' onClick="return confirm('確定審核此筆單')" class="za_button">
<?}else{?>
未審核
<?}}?>
          <input type=hidden name=id value=<?=$row['ID']?>>
          <input type=hidden name=mid value=<?=$row['UserName']?>>
          <input type=hidden name=gold value=<?=$row['Gold']?>>
          <input type=hidden name=type value=<?=$row['Type']?>>
          <input type=hidden name=uid value=<?=$uid?>>
          <input type=hidden name=active value=Y></td>
<?
}else{
?>
          <td><?=$row['User']?></td>
          <td><?=$row['Date']?></td>
          <td width="96"><?=$type?></td>

<?
}    
?>
<?
if ($lv=='M'){    
?>
          <td width="40" bgcolor="#3366FF" style='display:none;'><a href="user_list_800.php?uid=<?=$uid?>&langx=<?=$langx?>&id=<?=$row['ID']?>&active=N&lv=<?=$lv?>">删除
</a></td>
<?
}    
?>         
        </tr>
        </form>
<?
} 
}      
?>
        <!-- END DYNAMIC BLOCK: row -->
        <tr class="m_rig2"> 
          <td colspan="4" >總計</td>
          <td colspan="1" bgcolor="#990000"><font color="#FFFFFF"><?=$gold?></font></td>
          <td colspan="5" >&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="975" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="/images/agents/800/800_title_p21b.gif">&nbsp;</td>
    <td width="18"><img src="/images/agents/800/800_title_p22.gif" width="18" height="15"></td>
    <td width="200" class="m_foot">Copyrignt by SYTNET Online Corporation</td>
  </tr>
</table>
</body>
</html>