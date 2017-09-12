<?
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "./include/address.mem.php";
require ("./include/config.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>歡迎光臨投注</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
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
</head>
<body style="background:url(images/bbg.gif); width:721px; height:500px;overflow:hidden" >
<div class="B_border" style="overflow:hidden" >
    <span class="B_border_t"></span>
    <div class="B_border_c">
    <div class="body_b">
    <iframe name="Sbrowse" id="Sbrowse" src="/app/member/FT_future/index.php?rtype=<?=$_REQUEST['rtype']?>&uid=<?=$_REQUEST['uid']?>&langx=<?=$_REQUEST['langx']?>&mtype=3&showtype=<?=$_REQUEST['showtype']?>" frameborder="0" width="685px;" height="460px;" style="background:url(images/bbg.gif);" scrolling="no"></iframe>
</div>
</div>
<span class="B_border_b"></span>
</div>    
</body>
</html>
