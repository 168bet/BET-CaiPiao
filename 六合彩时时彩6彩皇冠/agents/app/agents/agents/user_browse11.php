<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../../agents/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");
require ("../../agents/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];

include ("../../agents/include/online.php");
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
$sql = "select ID,Level,UserName,SubUser,SubName from $web where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$name=$row['UserName'];
$passw=$row['Level'];
$subUser=$row['SubUser'];
if ($subUser==0){
	$name=$row['UserName'];
}else{
	$name=$row['SubName'];
}
switch ($lv){
case 'A':
    $Title=$Mem_Super;
	$Caption=$Mem_Manager;
	$level='M';
	$lower='B';
	$class='#ED4E41';
	$bgcolor='#D72415';
	$user='Admin';
	$check="(UserName='$name' or Admin='$name' or Super='$name' or Corprator='$name' or World='$name') and";
	$agents="Admin='$name' and Level='A' and subuser=0 ";
	$data='web_agents_data';
	break;
case 'B':
    $Title=$Mem_Corprator;
	$Caption=$Mem_Super;
	$level='A';
	$lower='C';
	$class='#429CCD';
	$bgcolor='0E75B0';
	$user='Super';
	$check="(UserName='$name' or Admin='$name' or Super='$name' or Corprator='$name' or World='$name') and";
	$agents="(Admin='$name' or Super='$name') and Level='B' and subuser=0 ";
	$data='web_agents_data';
	break;
case 'C':
    $Title=$Mem_World;
	$Caption=$Mem_Corprator;
	$level='B';
	$lower='D';
	$class='#CD9A99';
	$bgcolor='976061';
	$user='Corprator';
	$check="(UserName='$name' or Admin='$name' or Super='$name' or Corprator='$name' or World='$name') and";
	$agents="(Admin='$name' or Super='$name' or Corprator='$name') and Level='C' and subuser=0 ";
	$data='web_agents_data';
	break;
case 'D':
    $Title=$Mem_Agents;
	$Caption=$Mem_World;
	$level='C';
	$lower='MEM';
	$class='#86C0A6';
	$bgcolor='4B8E6F';
	$user='World';
	$check="(UserName='$name' or Admin='$name' or Super='$name' or Corprator='$name' or World='$name') and";
	$agents="(Admin='$name' or Super='$name' or Corprator='$name' or World='$name') and Level='D' and subuser=0 ";
	$data='web_agents_data';
	break;
case 'MEM':
    $Title=$Mem_Member;
	$Caption=$Mem_Agents;
	$level='D';
	$class='#FEF5B5';
	$bgcolor='E3D46E';
    $user='Agents';
	$check="(UserName='$name' or Admin='$name' or Super='$name' or Corprator='$name' or World='$name') and";
	$agents="(Admin='$name' or Super='$name' or Corprator='$name' or World='$name' or Agents='$name')";
	$data='web_member_data';
	break;
}
$loginfo='查看'.$Title.'';
$enable=$_REQUEST["enable"];
$disable=$_REQUEST["disable"];
$suspend=$_REQUEST["suspend"];
$logout=$_REQUEST["logout"];
$sort=$_REQUEST["sort"];
$active=$_REQUEST["active"];
$orderby=$_REQUEST["orderby"];
$active_id=$_REQUEST["active_id"];
$username=$_REQUEST["name"];
$page=$_REQUEST["page"];
$search=$_REQUEST["search"];


if ($enable==""){
	$enable='ALL';
}

if ($sort==""){
	$sort='ADDDATE';
}

if ($orderby==""){
	$orderby='DESC';
}

if ($page==''){
	$page=0;
}
if ($search!=''){
    $search="and (UserName like '%$search%' or AddDate like '%$search%' or Alias like '%$search%')";
	$num=512;
}else{
	$search="";
	$num=50;
}
if ($enable=="Y"){
	$status="and Status='0'";
}else if ($enable=="S"){
	$status="and Status='1'";
}else if ($enable=="N"){
	$status="and Status='2'";
}
$agdata="(Super='$username' or Corprator='$username' or World='$username')";
$memdata="(super='$username' or Corprator='$username' or World='$username' or Agents='$username')";
switch ($active){
case "Y":
    $loginfo='开通'.$Title.':'.$username.'';
	$mysql="update web_agents_data set EditType='1' where id=$active_id";
	mysql_db_query($dbname,$mysql);	
	break;
case "N":
    $loginfo='关闭'.$Title.':'.$username.'';
	$mysql="update web_agents_data set EditType='0' where id=$active_id";
	mysql_db_query($dbname,$mysql);	
	break;
case "enable":
    $loginfo='启用'.$Title.':'.$username.'';
	$mysql="update web_agents_data set Oid='logout',Status=0,LogoutTime=now() where id=$active_id and UserName='$username'";
	mysql_db_query($dbname,$mysql);
	$mysql="update web_agents_data set Oid='logout',Status=0,LogoutTime=now() where $agdata";
	mysql_db_query($dbname,$mysql);
	$mysql="update web_member_data set Oid='logout',Status=0,LogoutTime=now() where id=$active_id and UserName='$username'";
	mysql_db_query($dbname, $mysql);
	$mysql="update web_member_data set Oid='logout',Status=0,LogoutTime=now() where $memdata";
	mysql_db_query($dbname, $mysql);	
	break;	
case "suspend":
    $loginfo='冻结'.$Title.':'.$username.'';
	$mysql="update web_agents_data set Oid='logout',Status=1,LogoutTime=now() where id=$active_id and UserName='$username'";
	mysql_db_query($dbname,$mysql);	
	$mysql="update web_agents_data set Oid='logout',Status=1,LogoutTime=now() where $agdata";
	mysql_db_query($dbname,$mysql);
	$mysql="update web_member_data set Oid='logout',Status=1,LogoutTime=now() where id=$active_id and UserName='$username'";
	mysql_db_query($dbname, $mysql);
	$mysql="update web_member_data set Oid='logout',Status=1,LogoutTime=now() where $memdata";
	mysql_db_query($dbname, $mysql);
	break;	
case "disable":
    $loginfo='停用'.$Title.':'.$username.'';
	$mysql="update web_agents_data set Oid='logout',Status=2,LogoutTime=now() where id=$active_id and UserName='$username'";
	mysql_db_query($dbname,$mysql);
	$mysql="update web_agents_data set Oid='logout',Status=2,LogoutTime=now() where $agdata";
	mysql_db_query($dbname,$mysql);
	$mysql="update web_member_data set Oid='logout',Status=2,LogoutTime=now() where id=$active_id and UserName='$username'";
	mysql_db_query($dbname, $mysql);
	$mysql="update web_member_data set Oid='logout',Status=2,LogoutTime=now() where $memdata";
	mysql_db_query($dbname, $mysql);	
	break;
case "logout":
    $loginfo='踢线'.$Title.':'.$username.'';
	$mysql="update web_member_data set Oid='logout',Online=0,LogoutTime=now() where id=$active_id";
	mysql_db_query($dbname, $mysql);	
	break;
case "del":
	$mysql="SELECT web_report_data.m_name from web_report_data,web_member_data WHERE (web_member_data.UserName=web_report_data.m_name) and web_member_data.ID='$active_id'";
	$result=mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou>0){
		echo wterror("此会员已有投注纪录，无法进行删除！！");
		exit();
	}else{
	    $loginfo='删除'.$Title.':'.$username.'';	
		$sql="delete from $data where ID='$active_id'";
		mysql_db_query($dbname,$sql);
		$mysql="update web_agents_data set Count=Count-1 where UserName='".$_REQUEST['aguser']."'";
		mysql_db_query($dbname,$mysql) or die ("操作失败!");
	}
	break;	
}

$parents_id=$_REQUEST['parents_id'];
if ($parents_id==''){
	$sql = "select * from $data where $agents $status $search order by ".$sort." ".$orderby;
}else{
	$sql = "select * from $data where $agents $status and $user='$parents_id'  order by ".$sort." ".$orderby;
	$loginfo='查看'.$Caption.''.$parents_id.'的下线';
}
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
$page_size=50;
$page_count=ceil($cou/$page_size);
$offset=$page*50;
$mysql=$sql."  limit $offset,$num;";
//echo $mysql;
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if ($cou==0){
	$page_count=1;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8 ">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_title_ag {  background-color: <?=$class?>; text-align: center; height:25px}
.m_tab_ag {  padding-top: 3px; padding-right: 2px; padding-left: 2px}
-->
</style>

<script type="text/javascript" src="/js/agents/user_search.js" ></script>
<SCRIPT Language="javaScript">
<!--
function CheckEditY(str)
{
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 if(confirm("<?=$Mem_Confirm?> ( 开启修改注单功能 ) <?=$Title?> ?"))
  document.location=str+"&enable_s="+enable_s+"&page="+page;
}

function CheckEditN(str)
{
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 if(confirm("<?=$Mem_Confirm?> ( 关闭修改注单功能 ) <?=$Title?> ?"))
  document.location=str+"&enable_s="+enable_s+"&page="+page;
}
function CheckOnline(str)
{
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 if(confirm("<?=$Mem_Confirm?> ( 离线 ) <?=$Title?> ?"))
  document.location=str+"&enable_s="+enable_s+"&page="+page;
}
function CheckSTOP(str)
{
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 if(confirm("<?=$Mem_Confirm?> (<?=$Mem_Disable?> /<?=$Mem_Enable?> ) <?=$Title?> ?"))
  document.location=str+"&enable_s="+enable_s+"&page="+page;
}
function CheckDEL(str)
{
 if(confirm("<?=$Mem_Confirm?> <?=$Mem_Delete?> <?=$Title?> ?"))
  document.location=str;
}
function CheckSUSPEND(str)
{
 if(confirm("<?=$Mem_Confirm?> <?=$Mem_Suspend?> <?=$Title?> ?"))
  document.location=str;
}
function CheckWINLOSS_EN(str)
{
 if(confirm("<?=$Mem_Confirm?> <?=$Mem_Percent?><?=$Mem_Edit?><?=$Mem_Enable?> / <?=$Mem_Percent?><?=$Mem_Edit?><?=$Mem_Disable?> <?=$Title?> ?"))
  document.location=str;
}
//更改sort
function changeSort(str) {
	sort = document.myFORM.sort.value;
	orderby = document.myFORM.orderby.value;
	if(str == sort) {
		if(orderby == "ASC") {
			orderby = "DESC";
		} else {
			orderby = "ASC";
		}
	} else {
		sort = str;
		orderby = "ASC";
	}

	document.myFORM.sort.value = sort;
	document.myFORM.orderby.value = orderby;
	document.myFORM.submit();
}
function sbar(st){st.style.backgroundColor='#E0E0E0';}
function cbar(st){st.style.backgroundColor='';}

function line_open(tid,name,alias,phone,address) {
    var obj_win = document.getElementById('line_type');
    obj_win.style.top = document.body.scrollTop+event.clientY+25;
    obj_win.style.left = document.body.scrollLeft+event.clientX-100;
    var obj = document.getElementById("user_name");
    obj.innerHTML=name;
	var obj = document.getElementById("user_alias");
    obj.innerHTML=alias;
	var obj = document.getElementById("user_phone");
    obj.innerHTML=phone;
	var obj = document.getElementById("user_address");
    obj.innerHTML=address;
    obj_win.style.display = "block";
    obj_win.style.backgroundColor='#AACC00';
}
function line_close() {
    var obj_win = document.getElementById("line_type");
    obj_win.style.display = "none";
}

//負水盤開關

function change_line_open(tid,name,sub_value) {
    var obj_win = document.getElementById('change_line_type');
    obj_win.style.top = document.body.scrollTop+event.clientY+10;
    obj_win.style.left = document.body.scrollLeft+event.clientX-100;
    var obj = document.getElementById('line_'+sub_value);
    obj.checked = true;
    var obj = document.getElementById("user_name");
    obj.innerHTML=name;
    document.line_type.tid.value=tid;
	document.line_type.name.value=name;
    obj_win.style.display = "block";
    obj_win.style.backgroundColor='#AACC00';
}

function change_line_close() {
    var obj_win = document.getElementById("change_line_type");
    obj_win.style.display = "none";
}

function LogoutMEM(url) {
    var page = document.all.page.value;
    document.location = url+"&page="+page;
}
function onLoad() {
    var obj_enable = document.getElementById('enable');
    obj_enable.value = '<?=$enable?>';
    var obj_page = document.getElementById('page');
    obj_page.value = '<?=$page?>';
    var obj_sort=document.getElementById('sort');
    obj_sort.value='<?=$sort?>';
    var obj_orderby=document.getElementById('orderby');
    obj_orderby.value='<?=$orderby?>';
}
// -->
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()"; onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="myFORM" action="" method=POST>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline"> 
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
            <td>&nbsp;&nbsp;<?=$Title?><?=$Mem_Manager?></td>
            <td style="display:">&nbsp;&nbsp;<?=$Mem_Select?><?=$Caption?> :</td>
            <td style="visibility='visible'"><font color="Red">&nbsp;</font>
            <select name="parents_id" onChange="self.myFORM.submit()" class="za_select">
              <option label="<?=$Mem_All?>" value=""><?=$Mem_All?></option>
			  <?
	          $mysql = "select UserName,Alias from web_agents_data where $check subuser=0 and Status=0 and Level='$level'";
	          $aresult = mysql_db_query($dbname,$mysql);
				while ($arow = mysql_fetch_array($aresult)){
					if ($parents_id==$arow['UserName']){
						echo "<option value=".$arow['UserName']." selected>".$arow['UserName']."===".$arow['Alias']."</option>";				
						$sel_agents=$arow['UserName'];
					}else{
						echo "<option value=".$arow['UserName'].">".$arow['UserName']."===".$arow['Alias']."</option>";
					
					}
				}
				?>
              </select>
            </td>
            <td>
              <select name="enable" onChange="self.myFORM.submit()" class="za_select">
              <option label="<?=$Mem_All?>" value="ALL" selected="selected"><?=$Mem_All?></option>
              <option label="<?=$Mem_Enable?>" value="Y"><?=$Mem_Enable?></option>
			  <option label="<?=$Mem_Suspend?>" value="S"><?=$Mem_Suspend?></option>
              <option label="<?=$Mem_Disable?>" value="N"><?=$Mem_Disable?></option>
              </select>
            </td>
            <td >-- <?=$Mem_Method?> :</td>
            <td > 
              <select name="sort" onChange="myFORM.search.value='';self.myFORM.submit();" class="za_select">
			  <option label="<?=$Title?><?=$Mem_Account?>" value="USERNAME"><?=$Title?><?=$Mem_Account?></option>
              <option label="<?=$Title?><?=$Mem_Name?>" value="ALIAS"><?=$Title?><?=$Mem_Name?></option>
              <option label="<?=$Mem_Add?><?=$Mem_Date?>" value="ADDDATE"><?=$Mem_Add?><?=$Mem_Date?></option>

              </select>
              <select name="orderby" onChange="self.myFORM.submit()" class="za_select">
              <option label="<?=$Mem_ASC?>" value="ASC"><?=$Mem_ASC?></option>
              <option label="<?=$Mem_DESC?>" value="DESC"><?=$Mem_DESC?></option>

              </select>
            </td>
            <td >-- <?=$Mem_Totalpage?> :</td>
            <td > 
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
              <?
		      for($i=0;$i<$page_count;$i++){
			      echo "<option value='$i'>".($i+1)."</option>";
		         }
		      ?>
              </select>
            </td>
            <td > / <?=$page_count?>  <?=$Mem_Page?></td>
            <td><input type=BUTTON name="btn_search" value="<?=$Mem_Search?>" onClick="showSearchDlg();" class="za_button"></td>
			<td><input type="hidden" name="search" value=""></input></td>
            <td > 
<?
if($lv!='MEM'){
?>		
			   -- <input type=BUTTON name="append" value="<?=$Mem_Add?>" onClick="document.location='user_add.php?uid=<?=$uid?>&action=browse_add&lv=<?=$lv?>&langx=<?=$langx?>'" class="za_button">
<?
}else{
?>		   
			   -- <input type=BUTTON name="append" value="<?=$Mem_Add?>" onClick="document.location='mem_add.php?uid=<?=$uid?>&action=browse_add&lv=<?=$lv?>&langx=<?=$langx?>'" class="za_button">
<?
}
?>
            </td>
          </tr>
        </table>
    </td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
if ($cou==0){
?>
<table width="975" border="0" cellspacing="1" cellpadding="0"  bgcolor="<?=$bgcolor?>" class="m_tab_ag">
    <tr class="m_title_ag"> 
      <td height="30" align=center><?=$mem_nomem?></td>
    </tr>
  </table>
<?
}else{
?>
  <table width="975" border="0" cellspacing="1" cellpadding="0"  bgcolor="<?=$bgcolor?>" class="m_tab_ag">
    <tr class="m_title_ag"> 
      <td width="70" ><?=$Caption?> <?=$Mem_Account?></td>
      <td width="70"><a name="alias" href="javascript:changeSort('ALIAS')">登陆帐号</a></td>
      <td width="95"><a name="username" href="javascript:changeSort('USERNAME')"><?=$Title?> <?=$Mem_Account?></a></td>
      <td width="80"><?=$Mem_Money?></td>
      <td width="80"><?=$Mem_Credit?></td>
	  <td width="60">
<?
if($lv=='MEM'){
?>
                     <?=$Mem_Member?> <?=$Mem_Line_Type?>
<?
}else{
?>
                     <?=$Mem_Lower?> <?=$Mem_Total?> 
<?
}
?>	  </td>
      <td width="130"><a name="new_date" href="javascript:changeSort('NEW_DATE')"><?=$Mem_Add?> <?=$Mem_Date?></a></td>
      <td width="60"><?=$Mem_Account?><?=$Mem_Status?></td>
<?
if ($passw=='M' and $lv!='MEM'){
?>
      <td width="50">改单</td>
<?
}
?>
<?
if ($lv=='MEM'){
?>
      <td width="50">在线</td>
<?
}
?>     
      <td width="269"><?=$Mem_Function?></td>
    </tr>	
<?
while ($row = mysql_fetch_array($result)){	
$id=$row['ID'];	
$username=$row['UserName'];
$linetype=$row['LineType'];
?>
        <tr  class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this) > 
      <td><?=$row[$user]?></td>
      <td>
	  <? if($passw=='M'){?>
	  <a href="javascript:" onClick="line_open('<?=$id?>','<?=$username?>','<?=$row['Alias']?>','<?=$row['Phone']?>','<?=$row['Address']?>');"><?=$row['LoginName']?><br><?=$row['Alias']?></a>
      <? }else{ ?>
      <?=$row['LoginName']?><br><?=$row['Alias']?>
      <? } ?>
      </td>
      <td>
<? 
if($lv=='MEM'){
?>
          <?=$row['UserName']?>
<?
}else{
?>
          <A HREF='user_browse.php?uid=<?=$uid?>&lv=<?=$lower?>&enable=ALL&parents_id=<?=$username?>&langx=<?=$langx?>'><?=$row['UserName']?></a>
<?
}
?> 
<? 
if($passw=='M' or $passw=='A'){
?>
          <br><SPAN STYLE='background-color: Yellow;'><?=$row['PassWord']?></SPAN>
<?
}
?>
	  </td>
      <td align="right"><?=number_format($row['Money'],0)?></td>
      <td align="right"><?=number_format($row['Credit'],0)?></td>
      <td><?=$row['Count']?><?=$row['OpenType']?></td>
      <td>
<?
$todaytime=time();
$addtime=strtotime($row['AddDate']);
$time=($todaytime-$addtime)/86400;
if($time<30){
?>
          <SPAN STYLE="background-color: rgb(255,255,0);"><?=$row['AddDate']?></SPAN>
<?
}else{
?>    
          <?=$row['AddDate']?>
<?
}
?>	  
          <br><?=$row['LoginTime']?>
	  </td>
      <td>
<?
if ($row['Status']==0){
?>
          <?=$Mem_Enable?>
<?
}else if ($row['Status']==1){
?>
          <SPAN STYLE='background-color: Yellow;'><?=$Mem_Suspend?></SPAN>
<?
}else if ($row['Status']==2){
?>
          <SPAN STYLE='background-color: Red;'><?=$Mem_Disable?></SPAN>
<?
}
?>
      </td>
<?
if ($passw=='M' and $lv!='MEM'){
?>
      <td align="center">
<?
if ($row['EditType']==0){
?>
<a href="javascript:CheckEditY('user_browse.php?uid=<?=$uid?>&active=Y&lv=<?=$lv?>&active_id=<?=$id?>&name=<?=$username?>&langx=<?=$langx?>')"><SPAN STYLE='color: #000;'>否</SPAN></a>
<?
}else{
?>
<a href="javascript:CheckEditN('user_browse.php?uid=<?=$uid?>&active=N&lv=<?=$lv?>&active_id=<?=$id?>&name=<?=$username?>&langx=<?=$langx?>')"><SPAN STYLE='color: #F00;'>是</SPAN></a>
<?
}
?>  
      </td>
<?
}
?> 
<?
if ($lv=='MEM'){
?>
      <td align="center">
<?
if ($row['Online']==1){
?>
<a href="javascript:CheckOnline('user_browse.php?uid=<?=$uid?>&active=logout&lv=<?=$lv?>&active_id=<?=$id?>&name=<?=$username?>&langx=<?=$langx?>')"><SPAN STYLE='color: #F00;'>在线</SPAN></a>
<?
}else{
?>
离线
<?
}
?>  
      </td>
<?
}
?>    
      <td align="left">
<?
if($lv!='MEM'){
?>
          <a href=user_edit.php?uid=<?=$uid?>&lv=<?=$lv?>&action=browse_edit&parents_id=<?=$id?>&name=<?=$username?>&enable=ALL&line=ND&langx=<?=$langx?>><?=$Mem_Edit?></a> /   
          <a href=user_set.php?uid=<?=$uid?>&lv=<?=$lv?>&parents_id=<?=$id?>&name=<?=$username?>&langx=<?=$langx?> ><?=$Mem_Details?><?=$Mem_Settings?></a> / 
<?
}else{
?>
          <a href=mem_edit.php?uid=<?=$uid?>&lv=<?=$lv?>&action=browse_edit&parents_id=<?=$id?>&name=<?=$username?>&enable=ALL&line=ND&langx=<?=$langx?>><?=$Mem_Edit?></a> /   
          <a href=mem_set.php?uid=<?=$uid?>&lv=<?=$lv?>&parents_id=<?=$id?>&name=<?=$username?>&langx=<?=$langx?> ><?=$Mem_Details?><?=$Mem_Settings?></a> / 		  
<?
}
?>		   
<?
if ($row['Status']==0){
?>		  
          <a href="javascript:CheckSTOP('user_browse.php?uid=<?=$uid?>&active=disable&lv=<?=$lv?>&active_id=<?=$id?>&name=<?=$username?>&langx=<?=$langx?>')"><?=$Mem_Disable?></a> / 
          <A HREF="javascript:CheckSUSPEND('user_browse.php?uid=<?=$uid?>&active=suspend&lv=<?=$lv?>&active_id=<?=$id?>&name=<?=$username?>&langx=<?=$langx?>')"><?=$Mem_Suspend?></a> / 
<?
}else{
?>
          <a href="javascript:CheckSTOP('user_browse.php?uid=<?=$uid?>&active=enable&lv=<?=$lv?>&active_id=<?=$id?>&name=<?=$username?>&langx=<?=$langx?>')"><?=$Mem_Enable?></a> / 
          <font color="gray"><?=$Mem_Suspend?></font> / 		  
<?
}
?>		  	  
<?
if($lv=='MEM'){
?>
          <a href="javascript:CheckOnline('user_browse.php?uid=<?=$uid?>&active=logout&lv=<?=$lv?>&active_id=<?=$id?>&name=<?=$username?>&langx=<?=$langx?>')"><?=$Mem_Kick?></a>	  
<?
}
?>
<?
if($passw=='M'){
?>          
          <a href="javascript:CheckDEL('user_browse.php?uid=<?=$uid?>&langx=<?=$langx?>&active=del&lv=<?=$lv?>&active_id=<?=$id?>&name=<?=$username?>&aguser=<?=$row[$user]?>')"><?=$Mem_Delete?></a>
<?
}
?>	  


  </td> 
  </tr>
<?
}
?> 
  </table>
<?
}
?>
  <BR>
  <table  border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">
  <tr class="m_cen">
  	<td><?=$Mem_Add?> <?=$Mem_Date?></td>
  	<td><SPAN STYLE="background-color: rgb(255,255,0);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</SPAN></td>
  	<td><?=$Mem_Add?><?=$Mem_Account?><?=$Mem_month?></td>
  </tr>
  <tr class="m_cen">
  	<td><?=$Mem_Account?> <?=$Mem_Status?></td>
  	<td><SPAN STYLE="background-color: rgb(255,0,0);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</SPAN></td>
  	<td><?=$Mem_Disable?></td>
  </tr>
  </table>
</form>

<!--快速查詢跳出視窗-->
<div id="searchDlg" style="display: none;position: absolute;">
    <table border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
      <tr>
        <td bgcolor="#FFFFFF">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix" >
            <tr bgcolor="0163A2">
              <td><font color="#FFFFFF"><?=$Mem_Search?></font><font color="#FFFFFF" id="eo_title"></font></td>
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
              <td><?=$Mem_Query?><?=$Mem_Term?></td>
              <td>
              	<select name="dlg_option" class="za_select">
					<option label="<?=$Title?><?=$Mem_Mame?>" value="ALIAS"><?=$Title?><?=$Mem_Mame?></option>
					<option label="<?=$Title?><?=$Mem_Account?>" value="USERNAME" selected="selected"><?=$Title?><?=$Mem_Account?></option>
					<option label="<?=$Mem_Add?><?=$Mem_Date?>" value="NEW_DATE"><?=$Mem_Add?><?=$Mem_Date?></option>

              	</select>
              </td>
            </tr>
            <tr bgcolor="#000000">
              <td colspan="2" height="1"></td>
            </tr>
            <tr bgcolor="#A4C0CE">
            <td><?=$Mem_Keyword?></td>
              <td>
                <input type=text id="dlg_text" value="" class="za_text" size="15" maxlength="15">
              </td>
            </tr>
            <tr bgcolor="#000000">
              <td colspan="2" height="1"></td>
            </tr>
            <tr>
              <td align="center" colspan="2">
                <input type="submit" id="dlg_ok" value="<?=$Mem_Query?>" class="za_button" onClick="submitSearchDlg();">
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
</div>
<!--会员资料-->
<div id="line_type" style="display: none;position: absolute;">
<table width="300" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
      <tr>
        <td bgcolor="#FFFFFF">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix">
            <tr bgcolor="0163A2">
              <td width="100%"><font color="#FFFFFF">--资料--</font></td>
              <td align="right" valign="top"><a style="cursor:hand;" onClick="line_close();"><img src="/images/agents/top/edit_dot.gif" width="16" height="14"></a></td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix" >
            <tr>
               <td width="25%"><?=$Mem_Account?>：</td><td align="left"><div id="user_name"></div></td>
            </tr>
            <tr>
               <td width="25%">真实姓名：</td><td align="left"><div id="user_alias"></div></td>
            </tr>
            <tr>	  
               <td width="25%">电话号码：</td><td align="left"><div id="user_phone"></div></td>
            </tr>
            <tr>
               <td width="25%">联系方式：</td><td align="left"><div id="user_address"></div></td>
            </tr>
          </table>
        </td>
      </tr>
</table>
</div>
<!--負水盤開關-->
<div id="change_line_type" style="display: none;position: absolute;">
<table width="250" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
      <tr>
        <td bgcolor="#FFFFFF">
          <table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix">
            <tr bgcolor="0163A2">
              <td width="100%"><font color="#FFFFFF"><?=$Mem_Normal_Negative?><?=$Mem_Settings?>--</font></td>
              <td align="right" valign="top">
                <a style="cursor:hand;" onClick="change_line_close();">
                  <img src="/images/agents/top/edit_dot.gif" width="16" height="14">
                </a>
              </td>
            </tr>
			</table>
          <table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix" >
            <tr>
            <td width="20%"><?=$Mem_Account?>：</td><td align="left"><div id="user_name"></div></td>
            </tr>
          </table>		  
    <table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix" >
      <tr bgcolor="#000000">	  
        <td colspan="4" height="1"></td>
      </tr>
         <tr>
        <form name='line_type' method="POST" action="change_line_type_act.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>">
        <td align="left" colspan="4">
            <input type="hidden" name="tid" value=""></input>
			<input type="hidden" name="name" value=""></input>
            <input type="radio" id="line_Normal" name="line_type" value="1"><?=$Mem_Normal?>
		    <input type="radio" id="line_Negative" name="line_type" value="2"><?=$Mem_Negative?>
		    <input type="radio" id="line_Both" name="line_type" value="0"><?=$Mem_Both?>
		    <input type="submit" value="<?=$Mem_Confirm?>">
       	</td>
		</form>
         </tr>
    </table>
          </table>
        </td>
      </tr>
    </table>
</div>
</body>
</html>
<?
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$name',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>