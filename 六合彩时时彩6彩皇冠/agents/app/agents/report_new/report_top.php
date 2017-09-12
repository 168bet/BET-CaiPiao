<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../../agents/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");
require ("../../agents/include/define_function_list.inc.php");
include ("../../agents/include/online.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lever"];
$report_kind=$_REQUEST['report_kind'];
$pay_type=$_REQUEST['pay_type'];
$type=$_REQUEST['type'];
$date_start=$_REQUEST['date_start'];
$date_end=$_REQUEST['date_end'];
$gtype=$_REQUEST['gtype'];
$cancel=$_REQUEST['cancel'];
$result_type=$_REQUEST['result_type'];
$next_name=$_REQUEST['next_name'];
$corp_ck=$_REQUEST['corp_ck'];
$act=$_REQUEST['act'];

require ("../../agents/include/traditional.$langx.inc.php");
$sql = "select Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$web='web_system_data';
}else{
    $web='web_agents_data';
}
$mysql="select * from $web where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')<\/script>";
	exit;
}
$row = mysql_fetch_array($result);
$username=$row['UserName'];
switch ($lv){
case 'A':
	$Title=$Mem_Manager;
	$user='Super';
	$name="";
	break;
case 'B':
	$Title=$Mem_Super;
	$user='Corprator';
	$name="Super='$next_name' and";
	break;
case 'C':
    $Title=$Mem_Corprator;
	$user='World';
	$name="Corprator='$next_name' and";
	break;
case 'D':
    $Title=$Mem_World;
	$user='Agents';
	$name="World='$next_name' and";
	break;
case 'MEM':
    $Title=$Mem_Agents;
	$user='M_Name';
	$name="Agents='$next_name' and";
	break;
}


if ($row['SubUser']==1){
	$loginfo='子帐号:'.$username.'查询'.$Title.':'.$next_name.'&nbsp;&nbsp;'.$date_start.'至'.$date_end.'报表投注明细';
}else{
	$loginfo='查询'.$Title.':'.$next_name.'&nbsp;&nbsp;'.$date_start.'至'.$date_end.'报表投注明细';
}
switch ($pay_type){
case "0":
	$credit="block";
	$mgold="block";
	$pay_type="Pay_Type=0 and ";
	$rep_pay=$Rep_Credit;
	break;
case "1":
	$credit="block";
	$mgold="block";
	$pay_type="Pay_Type=1 and ";
	$rep_pay=$Rep_Cash;
	break;
case "":
	$credit="block";
	$mgold="block";
	$pay_type="";
	$rep_pay=$Rep_All;
	break;
}

switch ($gtype){
case "":
	$Active="";
	break;
case "FT":
	$Active=" (Active=1 or Active=11) and ";
	break;
case "BK":
	$Active=" (Active=2 or Active=22) and ";
	break;
case "BS":
	$Active=" (Active=3 or Active=33) and ";
	break;	
case "TN":
	$Active=" (Active=4 or Active=44) and ";
	break;
case "VB":
	$Active=" (Active=5 or Active=55) and ";
	break;
case "OP":
	$Active=" (Active=6 or Active=66) and ";
	break;
case "FU":
	$Active=" (Active=7 or Active=77) and ";
	break;	
case "FS":
	$Active=" Active=8 and ";
	break;
case "SIX":
	$Active=" Active=9 and ";
	break;		
}	

switch ($type){
case "M":
	$wtype=" Type='M' and ";
	$Content='全场獨贏';
	break;
case "R":
	$wtype=" Type='R' and ";
	$Content='全场讓球';
	break;
case "OU":
	$wtype=" Type='OU' and ";
	$Content='全场大小球';
	break;
case "EO":
	$wtype=" Type='EO' and ";
	$Content='全场單雙';
	break;	
case "VR":
	$wtype=" Type='VR' and ";
	$Content='上半場獨贏';
	break;
case "VOU":
	$wtype=" Type='VOU' and ";
	$Content='上半場讓球';
	break;
case "VM":
	$wtype=" Type='VM' and ";
	$Content='上半場大小';
	break;
case "VEO":
	$wtype=" Type='VEO' and ";
	$Content='上半場單雙';
	break;	
case "UR":
	$wtype=" Type='UR' and ";
	$Content='下半場讓球';
	break;
case "UOU":
	$wtype=" Type='UOU' and ";
	$Content='下半場大小';
	break;
case "UEO":
	$wtype=" Type='UEO' and ";
	$Content='下半場單雙';
	break;	
case "QR":
	$wtype=" Type='QR' and ";
	$Content='单节讓球';
	break;
case "QOU":
	$wtype=" Type='QOU' and ";
	$Content='单节大小';
	break;
case "QEO":
	$wtype=" Type='QEO' and ";
	$Content='单节單雙';
	break;
case "RM":
	$wtype=" Type='RM' and";
	$Content='滾球獨贏';
	break;			
case "RB":
	$wtype=" Type='RB' and";
	$Content='滾球讓球';
	break;
case "ROU":
	$wtype=" Type='ROU' and";
	$Content='滾球大小';
	break;
case "VRM":
	$wtype=" Type='VRM' and";
	$Content='滾球上半場獨贏';
	break;
case "VRB":
	$wtype=" Type='VRB' and";
	$Content='滾球上半場讓球';
	break;
case "VROU":
	$wtype=" Type='VROU' and";
	$Content='滾球上半場大小';
	break;
case "URB":
	$wtype=" Type='URB' and";
	$Content='滾球下半場讓球';
	break;
case "UROU":
	$wtype=" Type='UROU' and";
	$Content='滾球下半場大小球';
	break;	
case "PD":
	$wtype=" Type='PD' and ";
	$Content='波胆';
	break;
case "VPD":
	$wtype=" Type='VPD' and ";
	$Content='半场波胆';
	break;
case "T":
	$wtype=" Type='T' and ";
	$Content='入球数';
	break;	
case "F":
	$wtype=" Type='F' and ";
	$Content='半全场';
	break;
case "PC":
	$wtype=" Type='PC' and ";
	$Content='混合过关';
	break;
case "CS":
	$wtype=" Type='CS' and ";
	$Content='冠军赛';
	break;
case "":
	$wtype="";
	$Content='全部';
	break;
}

switch ($result_type){
case "":
	$m_result="";
	break;
case "Y":
	$m_result=" m_result!='' and ";
	break;
case "N":
	$m_result=" m_result='' and ";
	break;
}

if ($report_kind=='A'){
    $kind=$Rep_Kind_a;
    $cancel='';
}else if ($report_kind=='C'){
    $kind=$Rep_Kind_c;
    $cancel='';
}else if ($report_kind=='D'){
    $kind=$Rep_Kind_d;
    $cancel=' Cancel=1 and';
}else if ($report_kind=='E'){
    $kind=$Rep_Kind_e;
    $cancel=' Confirmed=-17 and';
}
	
if ($wtype==''){
	$awtype='';
}else{
	$awtype='&wtype='.$wtype;
}
$v_sql="select sum(VGOLD) as Valid from web_report_data where  ".$m_result.$wtype.$Active.$pay_type.$name.$cancel." M_Date>='$date_start' and M_Date<='$date_end'";
$v_result = mysql_db_query($dbname,$v_sql);
$v_row=mysql_fetch_array($v_result);
if ($v_row['Valid']==0){
$all_vgold=1;
}else{
$all_vgold=$v_row['Valid'];
}
$sql="select CurType,A_Point,B_Point,C_Point,D_Point,$user as name,sum(vgold) as vgold,count(*) as coun,sum(BetScore) as BetScore,sum(M_Result) as M_Result,sum(A_Result) as A_Result,sum(B_Result) as B_Result,sum(C_Result) as C_Result,sum(D_Result) as D_Result,sum(T_Result) as T_Result,sum(VGOLD) as VGOLD from web_report_data where  ".$m_result.$wtype.$Active.$pay_type.$name.$cancel." M_Date>='$date_start' and M_Date<='$date_end'";
?>
<html>
<head>
<title>reports_top</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_tab_top {  padding-top: 3px; padding-right: 2px; padding-left: 2px;}
.m_title_report_top {  background-color: #687780; height: 25px; text-align: center; color: #FFFFFF}
.m_title_report {  background-color: #687780; height: 31px; text-align: center; color: #FFFFFF}
-->
</style>
<script>
function sbar(st){st.style.backgroundColor='#E0E0E0';}
function cbar(st){st.style.backgroundColor='';}
</script>

</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="m_tline"> 
    <td width="100%">&nbsp;&nbsp;<?=$Title?>:<?=$next_name?>-- <?=$Rep_Date?>:<?=$date_start?> ~ <?=$date_end?> -- <?=$Rep_Kind?><?=$kind?> -- <?=$Rep_Pay_Type?><?=$rep_pay?> -- <?=$Rep_Wtype?><?=$Content?> -- <?=$Rep_Type?> -- <a href="javascript:history.go( -1 );"><?=$Return_Back?></a></td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>

<!-----------------↓ 信用額度資料區段 ↓------------------------->
<?
if($lv=='A'){
?>
<?
if ($credit=='block'){
	$mysql=$sql." and Pay_Type=0 group by $user order by ID asc";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$credit='none';
	}
}else{
	$credit='none';
}
?>
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab_top"  style="display: <?=$credit?>" width="975">
  <tr class="m_title_report_top" > 
    <td colspan="12"><?=$Rep_Credit?></td>
  </tr>
  <tr class="m_title_report" >
    <td width="75"><?=$Rep_Super?></td>
    <td width="48"><?=$Rep_Num?></td>
    <td width="95"><?=$Rep_Bet_Money?></td>
    <td width="95" ><?=$Rep_Actual_Betting?></td>
    <td width="95"><?=$Rep_Member?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Result?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_World?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Corprator?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Super?><?=$Rep_Result?></td>
    <td width="80"><?=$Rep_Readme?></td>
  </tr>
<?
while ($row = mysql_fetch_array($result)){
$c_betscore+=$row['BetScore'];
$c_num+=$row['coun'];
$c_m_result+=$row['M_Result'];
$c_t_result+=$row['T_Result'];		
$c_a_result+=$row['A_Result'];
$c_b_result+=$row['B_Result'];
$c_c_result+=$row['C_Result'];
$c_d_result+=$row['D_Result'];
$c_vscore+=$row['VGOLD'];
$vgold=$row['VGOLD'];
$c_vgold+=$vgold;
$gold=$row['VGOLD'];
$c_gold+=$gold;
$sgold=$row['VGOLD'];
$c_sgold+=$sgold;
?>  
    <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><a href="report_top.php?uid=<?=$uid?>&casino=<?=$casino?>&type=<?=$type?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&pay_type=0&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=B&result_type=<?=$result_type?>&result_type=<?=$result_type?>&next_name=<?=$row['name']?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>"><?=$row['BetScore']?></a></td>
    <td><?=number_format($row['VGOLD'],1)?></td>
    <td><?=number_format($row['M_Result'],1)?></td>
    <td><?=number_format($row['T_Result'],1)?></td>
    <td><?=number_format($row['D_Result'],1)?></td>
    <td><?=number_format($row['C_Result'],1)?></td>
    <td><?=number_format($row['B_Result'],1)?></td>
    <td><?=number_format($row['A_Result'],1)?></td>
    <td><?=number_format($sgold/$all_vgold,3)?>/1.000</td>
  </tr>
<?
}
?>
  <tr class="m_rig_to"> 
    <td><?=$Rep_Meter?></td>
    <td><?=$c_num?></td>
    <td><?=$c_betscore?></td>
    <td ><?=number_format($c_vgold,1)?></td>
    <td><?=number_format($c_m_result,1)?></td>
    <td><?=number_format($c_t_result,1)?></td>
    <td><?=number_format($c_d_result,1)?></td>
    <td><?=number_format($c_c_result,1)?></td>
    <td><?=number_format($c_b_result,1)?></td>
    <td><?=number_format($c_a_result,1)?></td>
    <td>0/1.000</td>
  </tr>
  <tr class="m_rig"  style="display: {TXT_SHOW0}"> 
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<!-----------------↑ 信用額度資料區段 ↑------------------------->
<?
		$c_score1=0;
		$c_num1=0;
		$c_m_result1=0;
		$c_w_result1=0;
		$c_c_result1=0;
		$c_vscore1=0;
		$c_a_result1=0;
		$c_vgold1=0;
if ($mgold=='block'){
	$mysql=$sql." and Pay_Type=1 group by $user order by ID asc";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$mgold='none';
	}
	}else{
	$mgold='block';
}
?>
<!-----------------↓ 現金資料區段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab_top"  style="display: <?=$mgold?>" width="975">
  <tr class="m_title_report_top" > 
    <td colspan="12"><?=$Rep_Cash?></td>
  </tr>
  <tr class="m_title_report" > 
    <td width="75"><?=$Rep_Super?></td>
    <td width="48"><?=$Rep_Num?></td>
    <td width="95"><?=$Rep_Bet_Money?></td>
    <td width="95" ><?=$Rep_Actual_Betting?></td>
    <td width="95"><?=$Rep_Member?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Result?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_World?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Corprator?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Super?><?=$Rep_Result?></td>
    <td width="80"><?=$Rep_Readme?></td>
  </tr>
<?
while ($row = mysql_fetch_array($result)){
$c_betscore+=$row['BetScore'];
$c_num+=$row['coun'];
$c_m_result+=$row['M_Result'];
$c_t_result+=$row['T_Result'];		
$c_a_result+=$row['A_Result'];
$c_b_result+=$row['B_Result'];
$c_c_result+=$row['C_Result'];
$c_d_result+=$row['D_Result'];
$c_vscore+=$row['VGOLD'];
$vgold=$row['VGOLD'];
$c_vgold+=$vgold;
$gold=$row['VGOLD'];
$c_gold+=$gold;
$sgold=$row['VGOLD'];
$c_sgold+=$sgold;
?>  
    <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><a href="report_top.php?uid=<?=$uid?>&casino=<?=$casino?>&type=<?=$type?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&pay_type=1&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=B&result_type=<?=$result_type?>&next_name=<?=$row['name']?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>"><?=$row['BetScore']?></a></td>
    <td><?=number_format($row['VGOLD'],1)?></td>
    <td><?=number_format($row['M_Result'],1)?></td>
    <td><?=number_format($row['T_Result'],1)?></td>
    <td><?=number_format($row['D_Result'],1)?></td>
    <td><?=number_format($row['C_Result'],1)?></td>
    <td><?=number_format($row['B_Result'],1)?></td>
    <td><?=number_format($row['A_Result'],1)?></td>
    <td><?=number_format($sgold/$all_vgold,3)?>/1.000</td>
  </tr>
<?
}
?>
  <tr class="m_rig_to"> 
    <td><?=$Rep_Meter?></td>
    <td><?=$c_num?></td>
    <td><?=$c_betscore?></td>
    <td ><?=number_format($c_vgold,1)?></td>
    <td><?=number_format($c_m_result,1)?></td>
    <td><?=number_format($c_t_result,1)?></td>
    <td><?=number_format($c_d_result,1)?></td>
    <td><?=number_format($c_c_result,1)?></td>
    <td><?=number_format($c_b_result,1)?></td>
    <td><?=number_format($c_a_result,1)?></td>
    <td>0/1.000</td>
  </tr>
  <tr class="m_rig"  style="display: {TXT_SHOW0}"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?
}else if($lv=='B'){
?>
<?
if ($credit=='block'){
	$mysql=$sql." and Pay_Type=0 group by $user order by ID asc";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$credit='none';
	}
	}else{
	$credit='none';
}
?>
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab_top"  style="display: <?=$credit?>" width="975">
  <tr class="m_title_report_top" > 
    <td colspan="12"><?=$Rep_Credit?></td>
  </tr>
  <tr class="m_title_report" > 
    <td width="75"><?=$Rep_Corprator?></td>
    <td width="48"><?=$Rep_Num?></td>
    <td width="95"><?=$Rep_Bet_Money?></td>
    <td width="95" ><?=$Rep_Actual_Betting?></td>
    <td width="95"><?=$Rep_Member?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Result?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_World?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Corprator?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Super?><?=$Rep_Deal?></td>
    <td width="80"><?=$Rep_Readme?></td>
  </tr>
<?
while ($row = mysql_fetch_array($result)){
$c_betscore+=$row['BetScore'];
$c_num+=$row['coun'];
$c_m_result+=$row['M_Result'];
$c_t_result+=$row['T_Result'];		
$c_a_result+=$row['A_Result'];
$c_b_result+=$row['B_Result'];
$c_c_result+=$row['C_Result'];
$c_d_result+=$row['D_Result'];
$c_vscore+=$row['VGOLD'];
$vgold=$row['VGOLD'];
$c_vgold+=$vgold;
$gold=$row['VGOLD'];
$c_gold+=$gold;
$sgold=$row['VGOLD'];
$c_sgold+=$sgold;
?>  
    <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><a href="report_top.php?uid=<?=$uid?>&casino=<?=$casino?>&type=<?=$type?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&pay_type=0&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=C&result_type=<?=$result_type?>&result_type=<?=$result_type?>&next_name=<?=$row['name']?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>"><?=$row['BetScore']?></a></td>
    <td><?=number_format($row['VGOLD'],1)?></td>
    <td><?=number_format($row['M_Result'],1)?></td>
    <td><?=number_format($row['T_Result'],1)?></td>
    <td><?=number_format($row['D_Result'],1)?></td>
    <td><?=number_format($row['C_Result'],1)?></td>
    <td><?=number_format($row['B_Result'],1)?></td>
    <td><?=number_format($row['A_Result'],1)?></td>
    <td><?=number_format($sgold/$all_vgold,3)?>/1.000</td>
  </tr>
<?
}
?>
  <tr class="m_rig_to"> 
    <td><?=$Rep_Meter?></td>
    <td><?=$c_num?></td>
    <td><?=$c_betscore?></td>
    <td ><?=number_format($c_vgold,1)?></td>
    <td><?=number_format($c_m_result,1)?></td>
    <td><?=number_format($c_t_result,1)?></td>
    <td><?=number_format($c_d_result,1)?></td>
    <td><?=number_format($c_c_result,1)?></td>
    <td><?=number_format($c_b_result,1)?></td>
    <td><?=number_format($c_a_result,1)?></td>
    <td>0/1.000</td>
  </tr>
  <tr class="m_rig"  style="display: {TXT_SHOW0}"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<!-----------------↑ 信用額度資料區段 ↑------------------------->
<?
		$c_score1=0;
		$c_num1=0;
		$c_m_result1=0;
		$c_w_result1=0;
		$c_c_result1=0;
		$c_vscore1=0;
		$c_a_result1=0;
		$c_vgold1=0;
if ($mgold=='block'){
	$mysql=$sql." and Pay_Type=1 group by $user order by ID asc";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$mgold='none';
	}
	}else{
	$mgold='block';
}
?>
<!-----------------↓ 現金資料區段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab_top"  style="display: <?=$mgold?>" width="975">
  <tr class="m_title_report_top" > 
    <td colspan="12"><?=$Rep_Cash?></td>
  </tr>
  <tr class="m_title_report" > 
    <td width="75"><?=$Rep_Corprator?></td>
    <td width="48"><?=$Rep_Num?></td>
    <td width="95"><?=$Rep_Bet_Money?></td>
    <td width="95" ><?=$Rep_Actual_Betting?></td>
    <td width="95"><?=$Rep_Member?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Result?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_World?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Corprator?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Super?><?=$Rep_Deal?></td>
    <td width="80"><?=$Rep_Readme?></td>
  </tr>
<?
while ($row = mysql_fetch_array($result)){
$c_betscore+=$row['BetScore'];
$c_num+=$row['coun'];
$c_m_result+=$row['M_Result'];
$c_t_result+=$row['T_Result'];		
$c_a_result+=$row['A_Result'];
$c_b_result+=$row['B_Result'];
$c_c_result+=$row['C_Result'];
$c_d_result+=$row['D_Result'];
$c_vscore+=$row['VGOLD'];
$vgold=$row['VGOLD'];
$c_vgold+=$vgold;
$gold=$row['VGOLD'];
$c_gold+=$gold;
$sgold=$row['VGOLD'];
$c_sgold+=$sgold;
?>  
    <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><a href="report_top.php?uid=<?=$uid?>&casino=<?=$casino?>&type=<?=$type?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&pay_type=1&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=C&result_type=<?=$result_type?>&next_name=<?=$row['name']?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>"><?=$row['BetScore']?></a></td>
    <td><?=number_format($row['VGOLD'],1)?></td>
    <td><?=number_format($row['M_Result'],1)?></td>
    <td><?=number_format($row['T_Result'],1)?></td>
    <td><?=number_format($row['D_Result'],1)?></td>
    <td><?=number_format($row['C_Result'],1)?></td>
    <td><?=number_format($row['B_Result'],1)?></td>
    <td><?=number_format($row['A_Result'],1)?></td>
    <td><?=number_format($sgold/$all_vgold,3)?>/1.000</td>
  </tr>
<?
}
?>
  <tr class="m_rig_to"> 
    <td><?=$Rep_Meter?></td>
    <td><?=$c_num?></td>
    <td><?=$c_betscore?></td>
    <td ><?=number_format($c_vgold,1)?></td>
    <td><?=number_format($c_m_result,1)?></td>
    <td><?=number_format($c_t_result,1)?></td>
    <td><?=number_format($c_d_result,1)?></td>
    <td><?=number_format($c_c_result,1)?></td>
    <td><?=number_format($c_b_result,1)?></td>
    <td><?=number_format($c_a_result,1)?></td>
    <td>0/1.000</td>
  </tr>
  <tr class="m_rig"  style="display: {TXT_SHOW0}"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?
}else if($lv=='C'){
?>
<?
if ($credit=='block'){
	$mysql=$sql." and Pay_Type=0 group by $user order by ID asc";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$credit='none';
	}
	}else{
	$credit='none';
}
?>
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab_top"  style="display: <?=$credit?>" width="975">
  <tr class="m_title_report_top" > 
    <td colspan="12"><?=$Rep_Credit?></td>
  </tr>
  <tr class="m_title_report" > 
    <td width="75"><?=$Rep_World?></td>
    <td width="48"><?=$Rep_Num?></td>
    <td width="95"><?=$Rep_Bet_Money?></td>
    <td width="95" ><?=$Rep_Actual_Betting?></td>
    <td width="95"><?=$Rep_Member?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Result?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_World?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Corprator?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Readme?></td>
    <td width="80"><?=$Rep_Readme?>2</td>
  </tr>
<?
while ($row = mysql_fetch_array($result)){
$c_betscore+=$row['BetScore'];
$c_num+=$row['coun'];
$c_m_result+=$row['M_Result'];
$c_t_result+=$row['T_Result'];		
$c_a_result+=$row['A_Result'];
$c_b_result+=$row['B_Result'];
$c_c_result+=$row['C_Result'];
$c_d_result+=$row['D_Result'];
$c_vscore+=$row['VGOLD'];
$vgold=$row['VGOLD'];
$c_vgold+=$vgold;
$gold=$row['VGOLD'];
$c_gold+=$gold;
$sgold=$row['VGOLD'];
$c_sgold+=$sgold;
?>  
    <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><a href="report_top.php?uid=<?=$uid?>&casino=<?=$casino?>&type=<?=$type?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&pay_type=0&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=D&result_type=<?=$result_type?>&next_name=<?=$row['name']?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>"><?=$row['BetScore']?></a></td>
    <td ><?=number_format($row['VGOLD'],1)?></td>
    <td><?=number_format($row['M_Result'],1)?></td>
    <td width="95"><?=number_format($row['T_Result'],1)?></td>
    <td width="95"><?=number_format($row['D_Result'],1)?></td>
    <td width="95"><?=number_format($row['C_Result'],1)?></td>
    <td width="95"><?=number_format($row['B_Result'],1)?></td>
    <td>&nbsp;</td>
    <td><?=number_format($sgold/$all_vgold,3)?>/1.000</td>
  </tr>
<?
}
?>
  <tr class="m_rig_to"> 
    <td><?=$Rep_Meter?></td>
    <td><?=$c_num?></td>
    <td><?=$c_betscore?></td>
    <td ><?=number_format($c_vgold,1)?></td>
    <td><?=number_format($c_m_result,1)?></td>
    <td><?=number_format($c_t_result,1)?></td>
    <td><?=number_format($c_d_result,1)?></td>
    <td><?=number_format($c_c_result,1)?></td>
    <td><?=number_format($c_b_result,1)?></td>
    <td>&nbsp;</td>
    <td>0/1.000</td>
  </tr>
  <tr class="m_rig"  style="display: {TXT_SHOW0}"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<!-----------------↑ 信用額度資料區段 ↑------------------------->
<?
		$c_score1=0;
		$c_num1=0;
		$c_m_result1=0;
		$c_w_result1=0;
		$c_c_result1=0;
		$c_vscore1=0;
		$c_a_result1=0;
		$c_vgold1=0;
if ($mgold=='block'){
	$mysql=$sql." and Pay_Type=1 group by $user order by ID asc";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$mgold='none';
	}
	}else{
	$mgold='block';
}
?>
<!-----------------↓ 現金資料區段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab_top"  style="display: <?=$mgold?>" width="975">
  <tr class="m_title_report_top" > 
    <td colspan="12"><?=$Rep_Cash?></td>
  </tr>
  <tr class="m_title_report" > 
    <td width="75"><?=$Rep_World?></td>
    <td width="48"><?=$Rep_Num?></td>
    <td width="95"><?=$Rep_Bet_Money?></td>
    <td width="95" ><?=$Rep_Actual_Betting?></td>
    <td width="95"><?=$Rep_Member?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Result?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_World?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Corprator?><?=$Rep_Deal?></td>
    <td width="95"><?=$Rep_Readme?></td>
    <td width="80"><?=$Rep_Readme?>2</td>
  </tr>
<?
while ($row = mysql_fetch_array($result)){
$c_betscore+=$row['BetScore'];
$c_num+=$row['coun'];
$c_m_result+=$row['M_Result'];
$c_t_result+=$row['T_Result'];		
$c_a_result+=$row['A_Result'];
$c_b_result+=$row['B_Result'];
$c_c_result+=$row['C_Result'];
$c_d_result+=$row['D_Result'];
$c_vscore+=$row['VGOLD'];
$vgold=$row['VGOLD'];
$c_vgold+=$vgold;
$gold=$row['VGOLD'];
$c_gold+=$gold;
$sgold=$row['VGOLD'];
$c_sgold+=$sgold;
?>  
    <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><a href="report_top.php?uid=<?=$uid?>&casino=<?=$casino?>&type=<?=$type?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&pay_type=1&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=D&result_type=<?=$result_type?>&next_name=<?=$row['name']?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>"><?=$row['BetScore']?></a></td>
    <td ><?=number_format($row['VGOLD'],1)?></td>
    <td><?=number_format($row['M_Result'],1)?></td>
    <td width="95"><?=number_format($row['T_Result'],1)?></td>
    <td width="95"><?=number_format($row['D_Result'],1)?></td>
    <td width="95"><?=number_format($row['C_Result'],1)?></td>
    <td width="95"><?=number_format($row['B_Result'],1)?></td>
    <td>&nbsp;</td>
    <td><?=number_format($sgold/$all_vgold,3)?>/1.000</td>
  </tr>
<?
}
?>
  <tr class="m_rig_to"> 
    <td><?=$Rep_Meter?></td>
    <td><?=$c_num?></td>
    <td><?=$c_betscore?></td>
    <td ><?=number_format($c_vgold,1)?></td>
    <td><?=number_format($c_m_result,1)?></td>
    <td><?=number_format($c_t_result,1)?></td>
    <td><?=number_format($c_d_result,1)?></td>
    <td><?=number_format($c_c_result,1)?></td>
    <td><?=number_format($c_b_result,1)?></td>
    <td>&nbsp;</td>
    <td>0/1.000</td>
  </tr>
  <tr class="m_rig"  style="display: {TXT_SHOW0}"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?
}else if($lv=='D'){
?>
<?
if ($credit=='block'){
	$mysql=$sql." and Pay_Type=0 group by $user order by ID asc";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$credit='none';
	}
	}else{
	$credit='none';
}
?>
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab_top"  style="display: <?=$credit?>" width="975">
  <tr class="m_title_report_top" > 
    <td colspan="13"><?=$Rep_Credit?></td>
  </tr>
  <tr class="m_title_report" > 
    <td width="75"><?=$Rep_Agent?></td>
    <td width="48"><?=$Rep_Num?></td>
    <td width="95"><?=$Rep_Bet_Money?></td>
    <td width="95" ><?=$Rep_Actual_Betting?></td>
    <td width="95"><?=$Rep_Member?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Result?></td>
    <td width="50"><?=$Rep_Agent?><br><?=$Rep_Percent?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Deal?></td>
    <td width="50"><?=$Rep_World?><br><?=$Rep_Percent?></td>
    <td width="95"><?=$Rep_World?><?=$Rep_Deal?></td>
    <td width="85"><?=$Rep_Readme?></td>
    <td width="84"  ><?=$Rep_Readme?>2</td>
  </tr>
<?
while ($row = mysql_fetch_array($result)){
$c_betscore+=$row['BetScore'];
$c_num+=$row['coun'];
$c_m_result+=$row['M_Result'];
$c_t_result+=$row['T_Result'];		
$c_a_result+=$row['A_Result'];
$c_b_result+=$row['B_Result'];
$c_c_result+=$row['C_Result'];
$c_d_result+=$row['D_Result'];
$c_vscore+=$row['VGOLD'];
$vgold=$row['VGOLD'];
$c_vgold+=$vgold;
$gold=$row['VGOLD'];
$c_gold+=$gold;
$sgold=$row['VGOLD'];
$c_sgold+=$sgold;
?>  
    <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><a href="report_top.php?uid=<?=$uid?>&casino=<?=$casino?>&type=<?=$type?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&pay_type=0&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=MEM&result_type=<?=$result_type?>&next_name=<?=$row['name']?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>"><?=$row['BetScore']?></a></td>
    <td ><?=number_format($row['VGOLD'],1)?></td>
    <td><?=number_format($row['M_Result'],1)?></td>
    <td><?=number_format($row['T_Result'],1)?></td>
    <td width="50"><?=$row['D_Point']?>%</td>
    <td width="95"><?=number_format($row['D_Result'],1)?></td>
    <td width="50"><?=$row['C_Point']?>%</td>
    <td width="95"><?=number_format($row['C_Result'],1)?></td>
    <td width="85"><?=number_format($sgold/$all_vgold,3)?>/1.000</td>
    <td><?=number_format($sgold/$all_vgold,3)?>/1.000</td>
  </tr>
<?
}
?>
  <tr class="m_rig_to"> 
    <td><?=$Rep_Meter?></td>
    <td><?=$c_num?></td>
    <td><?=$c_betscore?></td>
    <td ><?=number_format($c_vgold,1)?></td>
    <td><?=number_format($c_m_result,1)?></td>
    <td><?=number_format($c_t_result,1)?></td>
    <td>&nbsp;</td>
    <td><?=number_format($c_d_result,1)?></td>
    <td>&nbsp;</td>
    <td><?=number_format($c_c_result,1)?></td>
    <td>0/1.000</td>
    <td>0/1.000</td>
  </tr>
  <tr class="m_rig"  style="display: {TXT_SHOW0}"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<!-----------------↑ 信用額度資料區段 ↑------------------------->
<?
		$c_score1=0;
		$c_num1=0;
		$c_m_result1=0;
		$c_w_result1=0;
		$c_c_result1=0;
		$c_vscore1=0;
		$c_a_result1=0;
		$c_vgold1=0;
if ($mgold=='block'){
	$mysql=$sql." and Pay_Type=1 group by $user order by ID asc";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$mgold='none';
	}
	}else{
	$mgold='block';
}
?>
<!-----------------↓ 現金資料區段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab_top"  style="display: <?=$mgold?>" width="975">
  <tr class="m_title_report_top" > 
    <td colspan="13"><?=$Rep_Cash?></td>
  </tr>
  <tr class="m_title_report" > 
    <td width="75"><?=$Rep_Agent?></td>
    <td width="48"><?=$Rep_Num?></td>
    <td width="95"><?=$Rep_Bet_Money?></td>
    <td width="95" ><?=$Rep_Actual_Betting?></td>
    <td width="95"><?=$Rep_Member?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Result?></td>
    <td width="50"><?=$Rep_Agent?><br><?=$Rep_Percent?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Deal?></td>
    <td width="50"><?=$Rep_World?><br><?=$Rep_Percent?></td>
    <td width="95"><?=$Rep_World?><?=$Rep_Deal?></td>
    <td width="85"><?=$Rep_Readme?></td>
    <td width="84"  ><?=$Rep_Readme?>2</td>
  </tr>
<?
while ($row = mysql_fetch_array($result)){
$c_betscore+=$row['BetScore'];
$c_num+=$row['coun'];
$c_m_result+=$row['M_Result'];
$c_t_result+=$row['T_Result'];		
$c_a_result+=$row['A_Result'];
$c_b_result+=$row['B_Result'];
$c_c_result+=$row['C_Result'];
$c_d_result+=$row['D_Result'];
$c_vscore+=$row['VGOLD'];
$vgold=$row['VGOLD'];
$c_vgold+=$vgold;
$gold=$row['VGOLD'];
$c_gold+=$gold;
$sgold=$row['VGOLD'];
$c_sgold+=$sgold;
?>  
    <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><a href="report_top.php?uid=<?=$uid?>&casino=<?=$casino?>&type=<?=$type?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&pay_type=1&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=MEM&result_type=<?=$result_type?>&next_name=<?=$row['name']?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>"><?=$row['BetScore']?></a></td>
    <td ><?=number_format($row['VGOLD'],1)?></td>
    <td><?=number_format($row['M_Result'],1)?></td>
    <td><?=number_format($row['T_Result'],1)?></td>
    <td width="50"><?=$row['D_Point']?>%</td>
    <td width="95"><?=number_format($row['D_Result'],1)?></td>
    <td width="50"><?=$row['C_Point']?>%</td>
    <td width="95"><?=number_format($row['C_Result'],1)?></td>
    <td width="85"><?=number_format($sgold/$all_vgold,3)?>/1.000</td>
    <td><?=number_format($sgold/$all_vgold,3)?>/1.000</td>
  </tr>
<?
}
?>
  <tr class="m_rig_to"> 
    <td><?=$Rep_Meter?></td>
    <td><?=$c_num?></td>
    <td><?=$c_betscore?></td>
    <td ><?=number_format($c_vgold,1)?></td>
    <td><?=number_format($c_m_result,1)?></td>
    <td><?=number_format($c_t_result,1)?></td>
    <td>&nbsp;</td>
    <td><?=number_format($c_d_result,1)?></td>
    <td>&nbsp;</td>
    <td><?=number_format($c_c_result,1)?></td>
    <td>0/1.000</td>
    <td>0/1.000</td>
  </tr>
  <tr class="m_rig"  style="display: {TXT_SHOW0}"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?
}else if($lv=='MEM'){
?>
<?
if ($credit=='block'){
	$mysql=$sql." and Pay_Type=0 group by $user order by ID asc";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$credit='none';
	}
	}else{
	$credit='none';
}
?>
<table width="975" border="0" cellspacing="1" cellpadding="0" class="m_tab_top"  style="display: <?=$credit?>" bgcolor="#000000">
  <tr class="m_title_report_top"> 
    <td colspan="11"><?=$Rep_Credit?></td>
  </tr>
  <tr class="m_title_report"> 
    <td width="75"><?=$Rep_Member?></td>
    <td width="48" ><?=$Rep_Num?></td>
    <td width="95"><?=$Rep_Money?></td>
    <td width="95"><?=$Rep_Actual_Betting?></td>
    <td width="95"><?=$Rep_Member?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Money?></td>
    <td width="50"><?=$Rep_Agent?><br><?=$Rep_Percent?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Deal?></td>
    <td width="115"><?=$Rep_Current?></td>
    <td width="100"><?=$Rep_Readme?></td>
    <td width="100"><?=$Rep_Readme?>2</td>
  </tr>
<?
while ($row = mysql_fetch_array($result)){
$c_betscore+=$row['BetScore'];
$c_num+=$row['coun'];
$c_m_result+=$row['M_Result'];
$c_t_result+=$row['T_Result'];		
$c_a_result+=$row['A_Result'];
$c_b_result+=$row['B_Result'];
$c_c_result+=$row['C_Result'];
$c_d_result+=$row['D_Result'];
$c_vscore+=$row['VGOLD'];
$vgold=$row['VGOLD'];
$c_vgold+=$vgold;
$gold=$row['VGOLD'];
$c_gold+=$gold;
$sgold=$row['VGOLD'];
$c_sgold+=$sgold;
?> 
    <tr  class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><A HREF='report_member.php?uid=<?=$uid?>&type=<?=$type?>&casino=<?=$casino?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=M&result_type=<?=$result_type?>&m_name=<?=$row['name']?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>'><?=$row['BetScore']?></a></td>
    <td ><?=number_format($row['VGOLD'],1)?></td>
    <td><?=number_format($row['M_Result'],1)?></td>
    <td><?=number_format($row['T_Result'],1)?></td>
    <td><?=$row['D_Point']?>%</td>
    <td><?=number_format($row['D_Result'],1)?></td>
    <td>( <?=$row['CurType']?> )</td>
    <td>0/1.000</td>
    <td>0/1.000</td>
  </tr>
<?
}
?>
   <tr  class="m_rig_to" > 
    <td></td>
    <td ><?=$c_num?></td>
    <td ><?=$c_betscore?></td> 
    <td ><?=number_format($c_vgold,1)?></td>
    <td><font color="#FFFFFF"><?=number_format($c_m_result,1)?></font></td>
    <td><font color="#FFFFFF"><?=number_format($c_t_result,1)?></font></td>
    <td>&nbsp;</td>
    <td><?=number_format($c_d_result,1)?></td>
    <td></td>
    <td class="m_rig_to">0/1.000</td>
    <td class="m_rig_to">0/1.000</td>
  </tr>
  <tr class="m_rig"  style="display: {TXT_SHOW0}"> 
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <!--<td>{ATAX_0}</td>-->
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
		<td>&nbsp;</td> 
  </tr>
</table>
<?
		$c_score1=0;
		$c_num1=0;
		$c_m_result1=0;
		$c_w_result1=0;
		$c_c_result1=0;
		$c_vscore1=0;
		$c_a_result1=0;
		$c_vgold1=0;
if ($mgold=='block'){
	$mysql=$sql." and Pay_Type=1 group by $user order by ID asc";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$mgold='none';
	}
	}else{
	$mgold='block';
}
?>
<table width="975" border="0" cellspacing="1" cellpadding="0" class="m_tab_top"  style="display: <?=$mgold?>" bgcolor="#000000">
  <tr class="m_title_report_top">
    <td colspan="11"><?=$Rep_Cash?></td>
  </tr>
  <tr class="m_title_report"> 
    <td width="75"><?=$Rep_Member?></td>
    <td width="48" ><?=$Rep_Num?></td>
    <td width="95"><?=$Rep_Money?></td>
    <td width="95"><?=$Rep_Actual_Betting?></td>
    <td width="95"><?=$Rep_Member?></td>
    <td width="95"><?=$Rep_Agent?><?=$Rep_Money?></td>
    <td width="50"><?=$Rep_Agent?><br><?=$Rep_Percent?></td>
    <td width="95"><?=$Rep_Agent?></td>
    <td width="115"><?=$Rep_Current?></td>
    <td width="100"><?=$Rep_Readme?></td>
    <td width="100"><?=$Rep_Readme?>2</td>
  </tr>
<?
while ($row = mysql_fetch_array($result)){
$c_betscore+=$row['BetScore'];
$c_num+=$row['coun'];
$c_m_result+=$row['M_Result'];
$c_t_result+=$row['T_Result'];		
$c_a_result+=$row['A_Result'];
$c_b_result+=$row['B_Result'];
$c_c_result+=$row['C_Result'];
$c_d_result+=$row['D_Result'];
$c_vscore+=$row['VGOLD'];
$vgold=$row['VGOLD'];
$c_vgold+=$vgold;
$gold=$row['VGOLD'];
$c_gold+=$gold;
$sgold=$row['VGOLD'];
$c_sgold+=$sgold;
?> 
    <tr  class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><A HREF='report_member.php?uid=<?=$uid?>&type=<?=$type?>&casino=<?=$casino?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=M&result_type=<?=$result_type?>&m_name=<?=$row['name']?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>'><?=$row['BetScore']?></a></td>
    <td ><?=number_format($row['VGOLD'],1)?></td>
    <td><?=number_format($row['M_Result'],1)?></td>
    <td><?=number_format($row['T_Result'],1)?></td>
    <td><?=$row['D_Point']?>%</td>
    <td><?=number_format($row['D_Result'],1)?></td>
    <td>( <?=$row['CurType']?> )</td>
    <td>0/1.000</td>
    <td>0/1.000</td>
  </tr>
<?
}
?>
   <tr  class="m_rig_to" > 
    <td></td>
    <td ><?=$c_num?></td>
    <td ><?=$c_betscore?></td> 
    <td ><?=number_format($c_vgold,1)?></td>
    <td><font color="#FFFFFF"><?=number_format($c_m_result,1)?></font></td>
    <td><font color="#FFFFFF"><?=number_format($c_t_result,1)?></font></td>
    <td>&nbsp;</td>
    <td><?=number_format($c_d_result,1)?></td>
    <td></td>
    <td class="m_rig_to">0/1.000</td>
    <td class="m_rig_to">0/1.000</td>
  </tr>
  <tr class="m_rig"  style="display: {TXT_SHOW0}"> 
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <!--<td>{ATAX_0}</td>-->
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
		<td>&nbsp;</td> 
  </tr>
</table>
<?
}
?>
<!-----------------↑ 現金資料區段 ↑------------------------->
<!-----------------↓ 加總資料區段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab_top"  style="display: none" width="975">
  <tr class="m_title_report" > 
    <td colspan="10"><?=$Rep_Meter?></td>
  </tr>

  <tr class="m_rig_to"> 
    <td width="70"><?=$Rep_Meter?></td>
    <td width="50">230</td>
    <td width="130">71200.0</td>
    <td width="70">0</td>
    <td width="140">-2675.4</td>
    <td width="140">-2675.4</td>
    <td width="140">-2675.4</td>
    <td width="140">-2675.4</td>
    <td width="130">0/1.000</td>
    <td width="130">0/1.000</td>
  </tr>
<!-----------------↑ TAX ↑------------------------->
</table>
<!-----------------↑ 加總資料區段 ↑------------------------->
<!-----------------↓ 無資料訊息區段 ↓------------------------->
<?
if ($credit=='none' and $mgold=='none'){
	$nosearch='block';
}else{
	$nosearch='none';
}
?>
<table width="975" border="0" cellspacing="1" cellpadding="0" style="display: <?=$nosearch?>">
  <tr > 
    <td align=center height="30" bgcolor="#CC0000"><marquee align="middle" behavior="alternate" width="200"><font color="#FFFFFF"><?=$Rep_Cha_No_Information?></font></marquee></td>
  
  <tr> 
    <td align=center height="20" bgcolor="#CCCCCC"><a href="javascript:history.go(-1);"><?=$Rep_Leave?></a></td>
  
</table>
<!-----------------↑ 無資料區段 ↑------------------------->

</body>
</html>
<?
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$username',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>