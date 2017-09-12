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
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$showtype=$_REQUEST['showtype'];
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$langx=$_SESSION['langx'];
require ("include/traditional.$langx.inc.php");
if ($showtype=="future"){
	$ShowType="OP_future";
	$header="future";
}else{
	$ShowType="OP_browse";
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
	OP_lid_ary=top.OP_lid['OP_lid_ary'];
	OP_lid_type=top.OP_lid['OP_lid_type'];
	OP_lname_ary=top.OP_lid['OP_lname_ary'];
	OP_lid_ary_RE=top.OP_lid['OP_lid_ary_RE'];
	OP_lname_ary_RE=top.OP_lid['OP_lname_ary_RE'];
	OM_lid_ary=top.OM_lid['OM_lid_ary'];
	OM_lid_type=top.OM_lid['OM_lid_type'];
	OM_lname_ary=top.OM_lid['OM_lname_ary'];
 
}catch(E){
	initlid();
}
 
 
function initlid(){
	top.OP_lid = new Array();
	top.OM_lid = new Array();
	top.OP_lid['OP_lid_ary']= OP_lid_ary='ALL';
	top.OP_lid['OP_lid_type']= OP_lid_type='';
	top.OP_lid['OP_lname_ary']= OP_lname_ary='ALL';
	top.OP_lid['OP_lid_ary_RE']= OP_lid_ary_RE='ALL';
	top.OP_lid['OP_lname_ary_RE']= OP_lname_ary_RE='ALL';
	top.OM_lid['OM_lid_ary']= OM_lid_ary='ALL';
	top.OM_lid['OM_lid_type']= OM_lid_type='';
	top.OM_lid['OM_lname_ary']= OM_lname_ary='ALL';
}

</script>

<frameset rows="101,*" cols="*" frameborder="NO" border="0" framespacing="0"> 
  <frame name="header" scrolling="NO" noresize src="/app/member/OP_header.php?uid=<?=$uid?>&showtype=<?=$header?>&langx=<?=$langx?>&mtype=<?=$mtype?>" >
  <frameset cols="240,1*" frameborder="NO" border="0" framespacing="0"> 
    <frame name="mem_order" noresize scrolling="AUTO" src="/app/member/select.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>">
    <frame name="body" src="/app/member/<?=$ShowType?>/index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>&league_id=">
  </frameset>
</frameset><noframes></noframes>
<noframes><body bgcolor="#FFFFFF">

</body></noframes>
</html>
