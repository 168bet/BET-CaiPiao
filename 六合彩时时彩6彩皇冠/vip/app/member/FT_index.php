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
$mtype=$_REQUEST['mtype'];
$langx=$_SESSION['langx'];
$showtype=$_REQUEST['showtype'];
$sql = "select * from web_member_data where oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
if ($showtype=="future" or $showtype=="hgfu"){
	$browse="FT_future";
	$index="index";
}else if($showtype=="nfs"){
	$browse="FS_browse";
	$index="loadgame_R";
}else if($showtype=="sk"){
	$browse="browse";
	$index="index";
}else{
	$browse="FT_browse";
	$index="index";
}
?>
<html>
<head>
<title>歡迎光臨投注</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
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
<frameset rows="101,*" cols="*" frameborder="NO" border="0" framespacing="0"> 
  <frame name="header" scrolling="NO" noresize src="/app/member/FT_header.php?uid=<?=$uid?>&showtype=<?=$showtype?>&langx=<?=$langx?>&mtype=<?=$mtype?>" >
  <frameset cols="240,1*" frameborder="NO" border="0" framespacing="0"> 
    <frame name="mem_order" noresize scrolling="AUTO" src="/app/member/select.php?uid=<?=$uid?>&langx=<?=$langx?>">
    <frame name="body" src="/app/member/<?=$browse?>/<?=$index?>.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>&league_id=<?=$league_id?>&showtype=<?=$showtype?>">
  </frameset>
</frameset><noframes></noframes>
<noframes><body bgcolor="#FFFFFF">

</body></noframes>
</html>
