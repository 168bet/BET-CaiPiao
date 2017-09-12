<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "include/address.mem.php";
require ("include/config.inc.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'\n;</script>";
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
$sql = "select language from web_member_data where oid='$uid' and status=0";
$showtype=$_REQUEST['showtype'];

$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
if ($showtype=="future"){
	$showtype="BK_future";
	$header="future";
}else{
	$showtype="BK_browse";
	$header="";
}
mysql_close();
require ("include/traditional.$langx.inc.php");
?>
<html>
<head>
<title>歡迎光臨投注</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
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
<frameset rows="101,*" cols="*" frameborder="NO" border="0" framespacing="0"> 
  <frame name="header" scrolling="NO" noresize src="/app/member/BK_header.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>&showtype=<?=$header?>" >
  <frameset cols="240,1*" frameborder="NO" border="0" framespacing="0"> 
    <frame name="mem_order" noresize scrolling="AUTO" src="/app/member/select.php?uid=<?=$uid?>&langx=<?=$langx?>">
    <frame name="body" src="/app/member/<?=$showtype?>/index.php?uid=<?=$uid?>&langx=<?=$langx?>&league_id=">
  </frameset>
</frameset>
<noframes><body bgcolor="#FFFFFF">

</body></noframes>
</html>
