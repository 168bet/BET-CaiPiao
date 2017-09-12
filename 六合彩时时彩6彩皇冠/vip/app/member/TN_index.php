<?
session_start();
header("Expires: Mon, 26 Jul 1970 00:00:00 GMT");
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
$showtype=$_REQUEST['showtype'];
require ("include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where oid='$uid' and status=0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}

if ($showtype=="future"){
	$ShowType="TN_future";
	$header="future";
}else{
	$ShowType="TN_browse";
	$header="";
}
?>
<html>
<head>
<title>歡迎光臨投注</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
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
<frameset rows="101,*" cols="*" frameborder="NO" border="0" framespacing="0"> 
  <frame name="header" scrolling="NO" noresize src="/app/member/TN_header.php?uid=<?=$uid?>&showtype=<?=$header?>&langx=<?=$langx?>&mtype=<?=$mtype?>" >
  <frameset cols="240,1*" frameborder="NO" border="0" framespacing="0"> 
    <frame name="mem_order" noresize scrolling="AUTO" src="/app/member/select.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>">
    <frame name="body" src="/app/member/<?=$ShowType?>/index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>">
  </frameset>
</frameset>
<noframes><body bgcolor="#FFFFFF">
 
</body></noframes>
</html>
