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
	$ShowType="BS_future";
	$header="future";
}else{
	$ShowType="BS_browse";
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
<frameset rows="101,*" cols="*" frameborder="NO" border="0" framespacing="0"> 
  <frame name="header" scrolling="NO" noresize src="/app/member/BS_header.php?uid=<?=$uid?>&showtype=<?=$header?>&langx=<?=$langx?>&mtype=<?=$mtype?>" >
  <frameset cols="240,1*" frameborder="NO" border="0" framespacing="0"> 
    <frame name="mem_order" noresize scrolling="AUTO" src="/app/member/select.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>">
    <frame name="body" src="/app/member/<?=$ShowType?>/index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>&league_id=">
  </frameset>
</frameset>
<noframes><body bgcolor="#FFFFFF">

</body></noframes>
</html>
