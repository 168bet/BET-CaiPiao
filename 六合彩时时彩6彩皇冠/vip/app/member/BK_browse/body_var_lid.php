<?
session_start();
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");

$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=trim($_REQUEST['rtype']);
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
?>
<script>var links='./body_browse.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&mtype=3';
</script>
<? if ($rtype=='re'){ ?>
<script>
<!--
var sel_gtype=parent.sel_gtype;
function onLoad(){
	if (""+eval("parent.parent."+sel_gtype+"_lid_ary_RE")=="undefined") eval("parent.parent."+sel_gtype+"_lid_ary_RE='ALL'");	
	var len =lid_form.elements.length;
	if(eval("parent.parent."+sel_gtype+"_lid_ary_RE")=='ALL'){
		lid_form.sall.checked='true';
		for (var i = 1; i < len; i++) {
			var e = lid_form.elements[i];
			if (e.id.substr(0,3)=="LID") e.checked = 'true';
		}
	}else{
		for (var i = 1; i < len; i++) {
			var e = lid_form.elements[i];
			if(e.id.substr(0,3)=="LID"&&e.type=='checkbox') {
				if(eval("parent.parent."+sel_gtype+"_lid_ary_RE").indexOf(e.id.substr(3,e.id.length)+"-",0)!=-1){
					e.checked='true';
				}
			}
		}		
	}
	
}
function selall(){
	var len =lid_form.elements.length;
	var does=true;
  	does=lid_form.sall.checked;
	for (var i = 1; i < len; i++) {
		var e = lid_form.elements[i];
		if (e.id.substr(0,3)=="LID") e.checked = does;
	} 
}
function chk_all(e){
	if(!e) lid_form.sall.checked=e;
}
function chk_league(){
	var len =lid_form.elements.length;
	var strlid='';
	var strlname='';
	var gcount=0;
	top.BK_lid='';
  	if(lid_form.sall.checked) {
  		eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary_RE']=parent.parent."+sel_gtype+"_lid_ary_RE='ALL'");
  		eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary_RE']=parent.parent."+sel_gtype+"_lname_ary_RE='ALL'");
  	}else{
		for (var i = 1; i < len; i++) {
			var e = lid_form.elements[i];
			if (e.id.substr(0,3)=="LID"&&e.type=='checkbox'&&e.checked) {
				strlid+=e.id.substr(3,e.id.length)+'-';
				strlname+=e.value+'-';
				gcount++;
			}
		}
		if(gcount>0){
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary_RE']=parent.parent."+sel_gtype+"_lid_ary_RE=strlid");
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary_RE']=parent.parent."+sel_gtype+"_lname_ary_RE=strlname");
		}else{
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary_RE']=parent.parent."+sel_gtype+"_lid_ary_RE='ALL'");
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary_RE']=parent.parent."+sel_gtype+"_lname_ary_RE='ALL'");
		}	
	}
	back();
}
function back(){
	parent.parent.leg_flag="Y";
	self.location.href=links;
}
//--></script>
<? }else{ ?>
<script>
<!--
var sel_gtype=parent.sel_gtype;
function onLoad(){
	if (""+eval("parent.parent."+sel_gtype+"_lid_ary")=="undefined") eval("parent.parent."+sel_gtype+"_lid_ary='ALL'");	
	var len =lid_form.elements.length;
	if(eval("parent.parent."+sel_gtype+"_lid_ary")=='ALL'){
		lid_form.sall.checked='true';
		for (var i = 1; i < len; i++) {
			var e = lid_form.elements[i];
			if (e.id.substr(0,3)=="LID") e.checked = 'true';
		}
	}else{
		for (var i = 1; i < len; i++) {
			var e = lid_form.elements[i];
			if(e.id.substr(0,3)=="LID"&&e.type=='checkbox') {
				if(eval("parent.parent."+sel_gtype+"_lid_ary").indexOf(e.id.substr(3,e.id.length)+"-",0)!=-1){
					e.checked='true';
				}
			}
		}		
	}
	
	
}
function selall(){
	var len =lid_form.elements.length;
	var does=true;
  	does=lid_form.sall.checked;
	for (var i = 1; i < len; i++) {
		var e = lid_form.elements[i];
		if (e.id.substr(0,3)=="LID") e.checked = does;
	} 
}
function chk_all(e){
	if(!e) lid_form.sall.checked=e;
}
function chk_league(){
	var len =lid_form.elements.length;
	var strlid='';
	var strlname='';
	var gcount=0;
	top.BK_lid='';
  	if(lid_form.sall.checked) {
  		eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_type']=parent.parent."+sel_gtype+"_lid_type='"+((top.swShowLoveI)?"3":"")+"'");
  		eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary']=parent.parent."+sel_gtype+"_lid_ary='ALL'");
  		eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary']=parent.parent."+sel_gtype+"_lname_ary='ALL'");
  	}else{
		for (var i = 1; i < len; i++) {
			var e = lid_form.elements[i];
			if (e.id.substr(0,3)=="LID"&&e.type=='checkbox'&&e.checked) {
				strlid+=e.id.substr(3,e.id.length)+'-';
				strlname+=e.value+'-';
				gcount++;
			}
		}
		if(gcount>0){
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_type']=parent.parent."+sel_gtype+"_lid_type='2'");
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary']=parent.parent."+sel_gtype+"_lid_ary=strlid");
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary']=parent.parent."+sel_gtype+"_lname_ary=strlname");
		}else{
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_type']=parent.parent."+sel_gtype+"_lid_type='"+((top.swShowLoveI)?"3":"")+"'");
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary']=parent.parent."+sel_gtype+"_lid_ary='ALL'");
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary']=parent.parent."+sel_gtype+"_lname_ary='ALL'");
		}	
	}
	back();
}
function back(){
	parent.parent.leg_flag="Y";
	self.location.href=links;
}
//--></script>
<? } ?>
<html>
<head>
<title>Select League</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body<?=$css?>.css" type="text/css">
</head>

<body id="MBK" onLoad="onLoad();" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false">
<form name='lid_form'>
	<table border="0" cellpadding="0" cellspacing="0" id="box">
		<tr>
			<td id="ad">
				<span id="real_msg"><marquee scrolldelay=\"120\"><?=$mem_msg?></marquee></span>
				<p><a href="javascript://" onClick="javascript: window.open('../scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','menubar=no,status=yes,scrollbars=yes,top=150,left=200,toolbar=no,width=510,height=500')"><?=$News_History?></a></p>
			</td>
		</tr>
		<tr>
			<td class="top">
				<h1><em><?=$Body_Select_League?> :<a href="#" onClick="chk_league();"><?=$Body_Enter?></a><a href="#" onClick="back();"><?=$Body_Back?></a></em></h1>
			</td>
		</tr>
		<tr>
			<td class="mem">
				<table border="0" cellspacing="1" cellpadding="0" class="game">
					<tr>
						<td class="league_all"><input type=checkbox value=all id=sall onClick="selall();"><?=$Body_Select_All?></td>
					</tr>
<?
switch ($rtype){
	case "all":
	    $type='S';
		break;
	case "r":
	    $type='S';
		break;
	case "rq4":
	    $type='RQ';
		break;
	case "pr":
	    $type='PR';
		break;
}
$m_date=date('Y-m-d');
if ($rtype=='re'){
	$mysql = "select distinct $m_league as M_League FROM `match_sports` WHERE `Type`='BK' and `M_Date` ='$m_date' and RB_Show=1 and MB_Inball=''";
}else{
	$mysql = "select distinct $m_league as M_League FROM `match_sports` WHERE `Type`='BK' and `M_Start` > now( ) and `M_Date` ='$m_date' and ".$type."_Show=1";
}
$result = mysql_db_query($dbname, $mysql);
$cou=mysql_num_rows($result);
while ($league=mysql_fetch_array($result)){
?>
					<tr>
						<td class="league"><input type=checkbox value="<?=$league['M_League']?>" id="LID<?=$league['M_League']?>" onClick="chk_all(this.checked);"><?=$league['M_League']?></td>
					</tr>
<?
}
?>
<?
if ($cou==0){
?>
					<tr>
						<td class="league"><input type=checkbox value="{SNAME}" id="LID{ID}" onClick="chk_all(this.checked);"></td>
					</tr>
<?
}
?>
				</table>
			</td>
		</tr>
		<tr><td id="foot"><b>&nbsp;</b></td></tr>
	</table>
</form>
</body>
</html>

<div id="copyright"><?=$Copyright?></div>