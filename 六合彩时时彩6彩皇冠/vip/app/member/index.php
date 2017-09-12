<?
session_start();
$_SESSION['langx']='zh-cn';
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "include/address.mem.php";
require ("include/config.inc.php");
$str   = time();
$uid   = $_REQUEST['uid'];
$langx = $_REQUEST['langx'];
if ($langx==''){
	$langx="zh-cn";	
}

if($uid=='' || $userid==0){
	$sql = "SELECT * FROM `web_member_data` WHERE id=0 ";
	//echo $sql;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['Oid']=='' || empty($row['Oid']) || $row['Oid']=='logout'){
	    $str = time('s');
	    $uid=strtolower(substr(md5($str),0,10).substr(md5($username),0,10).'ra'.rand(0,9));
	    $ip_addr=get_ip();
	    $credit=$row['Credit'];
		$money=$
	    $date=date("Y-m-d");
	    $todaydate=strtotime(date("Y-m-d"));
	    $editdate=strtotime($row['EditDate']);
	    $time=($todaydate-$editdate)/86400;
		$datetime=strtotime(date("Y-m-d H:i:s"));
		$onlinetime=strtotime($row['OnlineTime']);
		if ($datetime-$onlinetime>1){
			if ($row['LoginDate']!=$date and $row['Pay_Type']==0){//判断是现金投注还是信用额度投注，若是现金不回归额度。若是信用回归额度
			   $sql="update web_member_data set Oid='$uid',LoginDate='$date', Money='$credit',LoginTime=now(),OnlineTime=now(),Online=1,LoginIP='$ip_addr',Language='$langx',Url='".BROWSER_IP."' where id=0 and Status<=1";
			}else{
			   $sql="update web_member_data set Oid='$uid',LoginDate='$date', LoginTime=now(),OnlineTime=now(),Online=1,LoginIP='$ip_addr',Language='$langx',Url='".BROWSER_IP."' where id=0 and Status<=1";
			}		
			   mysql_query($sql) or die ("error!");
		}
		$_SESSION['username']=$row['UserName'];
		$_SESSION['userid']=$row['ID'];		
	}else{
		$uid=$row['Oid'];
		$_SESSION['username']=$row['UserName'];
		$_SESSION['userid']='0';
		$_SESSION['Oid']=$row['Oid'];		
	}
}
//print_r($_SESSION);exit;
if($userid>0){
$sql = "select * from web_member_data where Oid='$uid' and Status<=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
$Status=$row['Status'];

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
	$mid=$row['ID'];
	$memname=$row['UserName'];
	
	$loginname=$row['LoginName'];
	$langx=$row['Language'];
	$logindate=date("Y-m-d");
	$datetime=date('Y-m-d h:i:s');
	if ($row['LoginDate']!=$logindate){
		$credit=$row['Credit'];
		$sql="update web_member_data set LoginTime='$datetime', Money='$credit' where UserName='$memname' and Pay_Type=0";
		mysql_query($sql) or die ("error!");
	}else{
		$credit=$row['Money'];
	}
}

}
$paysql = "select Address from web_payment_data where Switch=1";
$payresult = mysql_query($paysql);
$payrow=mysql_fetch_array($payresult);
$address=$payrow['Address'];
?>
 <?
 if($userid>0){
  $mysql = "select * from web_notices where (type=1 or id in (select notice_id from web_notices_to where notice_to=$mid) or (type=3 and addpople = '".$mid."') or (type=4 and reply_to_uid='".$mid."')) and (view_ids not like '%{".$memname."}%' or  view_ids is null)";
  $r = mysql_query($mysql);
  $noread = mysql_num_rows($r);
 $mysql = "select * from web_notices where (type=1 or id in (select notice_id from web_notices_to where notice_to=$mid) or (type=3 and addpople = '".$mid."') or (type=4 and reply_to_uid='".$mid."')) and (view_ids  like '%{".$memname."}%' and  view_ids is not null)";
 
  $r = mysql_query($mysql);
  $readed = mysql_num_rows($r);
 }


 ?>
<html>
<head>
<title>歡迎光臨投注</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script> 
try{	
	BK_lid_ary=top.BK_lid['BK_lid_ary'];
	BK_lid_type=top.BK_lid['BK_lid_type'];
	BK_lname_ary=top.BK_lid['BK_lname_ary'];
	BK_lid_ary_RE=top.BK_lid['BK_lid_ary_RE'];
	BK_lname_ary_RE=top.BK_lid['BK_lname_ary_RE'];
	BU_lid_ary=top.BU_lid['BU_lid_ary'];
	BU_lid_type=top.BU_lid['BU_lid_type'];
	BU_lname_ary=top.BU_lid['BU_lname_ary'];
 
}catch(E){
	initlid();
}
 
 
function initlid(){
	top.BK_lid = new Array();
	top.BU_lid = new Array();
	top.BK_lid['BK_lid_ary']= BK_lid_ary='ALL';
	top.BK_lid['BK_lid_type']= BK_lid_type='';
	top.BK_lid['BK_lname_ary']= BK_lname_ary='ALL';
	top.BK_lid['BK_lid_ary_RE']= BK_lid_ary_RE='ALL';
	top.BK_lid['BK_lname_ary_RE']= BK_lname_ary_RE='ALL';
	top.BU_lid['BU_lid_ary']= BU_lid_ary='ALL';
	top.BU_lid['BU_lid_type']= BU_lid_type='';
	top.BU_lid['BU_lname_ary']= BU_lname_ary='ALL';
}
BK_lid_ary='ALL';
BK_lid_ary_RE='ALL';
BK_lid_type='';
BK_lname_ary='ALL';
BK_lname_ary_RE='ALL';
BU_lid_ary='ALL';
BU_lid_type='';
BU_lname_ary='ALL';

</script>
<script> 
try{	
	BK_lid_ary=top.BK_lid['BK_lid_ary'];
	BK_lid_type=top.BK_lid['BK_lid_type'];
	BK_lname_ary=top.BK_lid['BK_lname_ary'];
	BK_lid_ary_RE=top.BK_lid['BK_lid_ary_RE'];
	BK_lname_ary_RE=top.BK_lid['BK_lname_ary_RE'];
	BU_lid_ary=top.BU_lid['BU_lid_ary'];
	BU_lid_type=top.BU_lid['BU_lid_type'];
	BU_lname_ary=top.BU_lid['BU_lname_ary'];
 
}catch(E){
	initlid();
}
 
 
function initlid(){
	top.BK_lid = new Array();
	top.BU_lid = new Array();
	top.BK_lid['BK_lid_ary']= BK_lid_ary='ALL';
	top.BK_lid['BK_lid_type']= BK_lid_type='';
	top.BK_lid['BK_lname_ary']= BK_lname_ary='ALL';
	top.BK_lid['BK_lid_ary_RE']= BK_lid_ary_RE='ALL';
	top.BK_lid['BK_lname_ary_RE']= BK_lname_ary_RE='ALL';
	top.BU_lid['BU_lid_ary']= BU_lid_ary='ALL';
	top.BU_lid['BU_lid_type']= BU_lid_type='';
	top.BU_lid['BU_lname_ary']= BU_lname_ary='ALL';
}
BK_lid_ary='ALL';
BK_lid_ary_RE='ALL';
BK_lid_type='';
BK_lname_ary='ALL';
BK_lname_ary_RE='ALL';
BU_lid_ary='ALL';
BU_lid_type='';
BU_lname_ary='ALL';

</script>
<script> 
 
try{	
	BS_lid_ary=top.BS_lid['BS_lid_ary'];
	BS_lid_type=top.BS_lid['BS_lid_type'];
	BS_lname_ary=top.BS_lid['BS_lname_ary'];
	BS_lid_ary_RE=top.BS_lid['BS_lid_ary_RE'];
	BS_lname_ary_RE=top.BS_lid['BS_lname_ary_RE'];
	BSFU_lid_ary=top.BSFU_lid['BSFU_lid_ary'];
	BSFU_lid_type=top.BSFU_lid['BSFU_lid_type'];
	BSFU_lname_ary=top.BSFU_lid['BSFU_lname_ary'];
 
}catch(E){
	initlid();
}
 
 
function initlid(){
	top.BS_lid = new Array();
	top.BSFU_lid = new Array();
	top.BS_lid['BS_lid_ary']= BS_lid_ary='ALL';
	top.BS_lid['BS_lid_type']= BS_lid_type='';
	top.BS_lid['BS_lname_ary']= BS_lname_ary='ALL';
	top.BS_lid['BS_lid_ary_RE']= BS_lid_ary_RE='ALL';
	top.BS_lid['BS_lname_ary_RE']= BS_lname_ary_RE='ALL';
	top.BSFU_lid['BSFU_lid_ary']= BSFU_lid_ary='ALL';
	top.BSFU_lid['BSFU_lid_type']= BSFU_lid_type='';
	top.BSFU_lid['BSFU_lname_ary']= BSFU_lname_ary='ALL';
}

</script>
<script> 
	
try{	
	FT_lid_ary=top.FT_lid['FT_lid_ary'];
	FT_lid_type=top.FT_lid['FT_lid_type'];
	FT_lname_ary=top.FT_lid['FT_lname_ary'];
	FT_lid_ary_RE=top.FT_lid['FT_lid_ary_RE'];
	FT_lname_ary_RE=top.FT_lid['FT_lname_ary_RE'];
	FU_lid_ary=top.FU_lid['FU_lid_ary'];
	FU_lid_type=top.FU_lid['FU_lid_type'];
	FU_lname_ary=top.FU_lid['FU_lname_ary'];
 
}catch(E){
	initlid();
}
function initlid(){
	top.FT_lid = new Array();
	top.FU_lid = new Array();
	top.FT_lid['FT_lid_ary']= FT_lid_ary='ALL';
	top.FT_lid['FT_lid_type']= FT_lid_type='';
	top.FT_lid['FT_lname_ary']= FT_lname_ary='ALL';
	top.FT_lid['FT_lid_ary_RE']= FT_lid_ary_RE='ALL';
	top.FT_lid['FT_lname_ary_RE']= FT_lname_ary_RE='ALL';
	top.FU_lid['FU_lid_ary']= FU_lid_ary='ALL';
	top.FU_lid['FU_lid_type']= FU_lid_type='';
	top.FU_lid['FU_lname_ary']= FU_lname_ary='ALL';
}
</script>
<script> 
	
try{	
	FT_lid_ary=top.FT_lid['FT_lid_ary'];
	FT_lid_type=top.FT_lid['FT_lid_type'];
	FT_lname_ary=top.FT_lid['FT_lname_ary'];
	FT_lid_ary_RE=top.FT_lid['FT_lid_ary_RE'];
	FT_lname_ary_RE=top.FT_lid['FT_lname_ary_RE'];
	FU_lid_ary=top.FU_lid['FU_lid_ary'];
	FU_lid_type=top.FU_lid['FU_lid_type'];
	FU_lname_ary=top.FU_lid['FU_lname_ary'];
 
}catch(E){
	initlid();
}
 
 
function initlid(){
	top.FT_lid = new Array();
	top.FU_lid = new Array();

	top.FT_lid['FT_lid_ary']= FT_lid_ary='ALL';
	top.FT_lid['FT_lid_type']= FT_lid_type='';
	top.FT_lid['FT_lname_ary']= FT_lname_ary='ALL';
	top.FT_lid['FT_lid_ary_RE']= FT_lid_ary_RE='ALL';
	top.FT_lid['FT_lname_ary_RE']= FT_lname_ary_RE='ALL';
	top.FU_lid['FU_lid_ary']= FU_lid_ary='ALL';
	top.FU_lid['FU_lid_type']= FU_lid_type='';
	top.FU_lid['FU_lname_ary']= FU_lname_ary='ALL';
}
</script>
<script> 
	
try{	
	TN_lid_ary=top.TN_lid['TN_lid_ary'];
	TN_lid_type=top.TN_lid['TN_lid_type'];
	TN_lname_ary=top.TN_lid['TN_lname_ary'];
	TN_lid_ary_RE=top.TN_lid['TN_lid_ary_RE'];
	TN_lname_ary_RE=top.TN_lid['TN_lname_ary_RE'];
	TU_lid_ary=top.TU_lid['TU_lid_ary'];
	TU_lid_type=top.TU_lid['TU_lid_type'];
	TU_lname_ary=top.TU_lid['TU_lname_ary'];
 
}catch(E){
	initlid();
}
 
 
function initlid(){
	top.TN_lid = new Array();
	top.TU_lid = new Array();
	top.TN_lid['TN_lid_ary']= TN_lid_ary='ALL';
	top.TN_lid['TN_lid_type']= TN_lid_type='';
	top.TN_lid['TN_lname_ary']= TN_lname_ary='ALL';
	top.TN_lid['TN_lid_ary_RE']= TN_lid_ary_RE='ALL';
	top.TN_lid['TN_lname_ary_RE']= TN_lname_ary_RE='ALL';
	top.TU_lid['TU_lid_ary']= TU_lid_ary='ALL';
	top.TU_lid['TU_lid_type']= TU_lid_type='';
	top.TU_lid['TU_lname_ary']= TU_lname_ary='ALL';
}

</script>
<script> 
	
try{	
	VB_lid_ary=top.VB_lid['VB_lid_ary'];
	VB_lid_type=top.VB_lid['VB_lid_type'];
	VB_lname_ary=top.VB_lid['VB_lname_ary'];
	VB_lid_ary_RE=top.VB_lid['VB_lid_ary_RE'];
	VB_lname_ary_RE=top.VB_lid['VB_lname_ary_RE'];
	VU_lid_ary=top.VU_lid['VU_lid_ary'];
	VU_lid_type=top.VU_lid['VU_lid_type'];
	VU_lname_ary=top.VU_lid['VU_lname_ary'];
 
}catch(E){
	initlid();
}
 
 
function initlid(){
	top.VB_lid = new Array();
	top.VU_lid = new Array();
	top.VB_lid['VB_lid_ary']= VB_lid_ary='ALL';
	top.VB_lid['VB_lid_type']= VB_lid_type='';
	top.VB_lid['VB_lname_ary']= VB_lname_ary='ALL';
	top.VB_lid['VB_lid_ary_RE']= VB_lid_ary_RE='ALL';
	top.VB_lid['VB_lname_ary_RE']= VB_lname_ary_RE='ALL';
	top.VU_lid['VU_lid_ary']= VU_lid_ary='ALL';
	top.VU_lid['VU_lid_type']= VU_lid_type='';
	top.VU_lid['VU_lname_ary']= VU_lname_ary='ALL';
}

</script>
<style type="text/css">
body{
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
    font-size: 12px;
    color: #ffffff;
    background: #000 url(/images/bj.jpg) repeat-x 0 0;
}
</style>
<script language="javascript">
function iFrameHeight() { 
var ifm= document.getElementById("body"); 
var subWeb = document.frames ? document.frames["body"].document : ifm.contentDocument; 
if(ifm != null && subWeb != null) { 
ifm.height = subWeb.body.scrollHeight; 
} 
} 
function iFrameHeight1() { 
var ifm= document.getElementById("mem_order"); 
var subWeb = document.frames ? document.frames["mem_order"].document : ifm.contentDocument; 
if(ifm != null && subWeb != null) { 
if(subWeb.body.scrollHeight>500){
ifm.height = subWeb.body.scrollHeight; 
}else{
ifm.height = 500; 	
}
} 
}
</script>
<script language="Javascript">
document.oncontextmenu=new Function("event.returnValue=false");
document.onselectstart=new Function("event.returnValue=false");
</script>
</head>
<body >
<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" height="130"><iframe id="header" name="header" frameborder="0" scrolling="no" width="100%" height="130px" src="/app/member/header.php?uid=<?= $uid ?>&amp;langx=<?= $langx ?>"></iframe></td>
  </tr>
</table>
<!--公告位置-开始-->
<script language="javascript">
var current = <?=time() ?>000 || 0;
/**
* 即時時間顯示
**/
function dispTime(){
    current += 1000;
    var dateObj = new Date(current);
    var Y = dateObj.getFullYear();
    var Mh = dateObj.getMonth() + 1;
    if(Mh > 12) Mh = 01;
    if(Mh < 10) Mh = '0'+Mh;
    var D = dateObj.getDate()  < 10 ? '0'+dateObj.getDate():dateObj.getDate();
    var H = dateObj.getHours() < 10 ? '0'+dateObj.getHours():dateObj.getHours();
    var M = dateObj.getMinutes() < 10 ? '0'+dateObj.getMinutes():dateObj.getMinutes();
    var S = dateObj.getSeconds() < 10 ? '0'+dateObj.getSeconds():dateObj.getSeconds();
    document.getElementById('EST_reciprocal').innerHTML = Y+'/'+Mh+'/'+D+' - '+H+':'+M+':'+S;
}
    var timerID = setInterval("dispTime()",1000);
</script>
<table width="1002" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600" align="center" style="line-height:25px;font-size:12px;vertical-align:center;">
            <tr><td width="20"></td>
              <td width="230" align="left"><div id="est_bg" class="time_text">美东时间：<span id="EST_reciprocal"></span></div></td><td width="730" ><marquee  style="vertical-align:center;line-height:14px;background: #A47340;" id="_newsMarquee"  scrolldelay="30" scrollamount="1" onMouseOver="this.stop();" onMouseOut="this.start();" > <span>
			  <?php
			  $notice_sql = "select Message,Message_tw,Message_en from web_marquee_data where Level='MEM'order by ID desc limit 1";
				$notice_result = mysql_db_query($dbname, $notice_sql);
				$notice_row = mysql_fetch_array($notice_result);
				echo $notice_row['Message'];
			  ?></span></marquee></td>
			</tr>
</table>

<!--公告位置-结束-->
<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="240" valign="top"><iframe id="mem_order" name="mem_order" frameborder="0" scrolling="no" width="240px" src="/app/member/select.php?uid=<?= $uid ?>&amp;langx=<?= $langx ?>" height="516px" onLoad="iFrameHeight1()"></iframe></td>
    <td valign="top"><iframe id="body" name="body" frameBorder=0 scrolling=no width="100%" src="/app/member/body.php?uid=<?= $uid ?>&amp;langx=<?= $langx ?>" height="416px" onLoad="iFrameHeight()"></iframe>
    </td>
  </tr>
</table>
<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="90"><iframe id="bottom" name="bottom" frameborder="0" scrolling="no" width="100%" height="90px" src="/app/member/bottom.php?uid=<?= $uid ?>&amp;langx=<?= $langx ?>"></iframe></td>
  </tr>
</table>
</body>
</html>
