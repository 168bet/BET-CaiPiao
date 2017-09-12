<?
header('Content-Type: application/octet-stream');
header('Accept-Ranges: bytes');
header("Content-disposition: attachment; filename=".date('Y-m-d H-i-s').".html");

session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

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
$result_type=$_REQUEST['result_type'];
$m_name=$_REQUEST['m_name'];
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
$mysql="select UserName,Level from $web where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')<\/script>";
	exit;
}
$row = mysql_fetch_array($result);
$username=$row['UserName'];
$level=$row['Level'];
if($level=='M' or $level=='A'){
   $width=975;
}else if($level=='B'){
   $width=878;
}else if($level=='C'){
   $width=821;
}else if($level=='D'){
   $width=764;
}
$loginfo='查询会员:'.$m_name.'&nbsp;&nbsp;'.$date_start.'至'.$date_end.'报表投注明细';
switch ($pay_type){
case "0":
	$credit="block";
	$mgold="block";
	$pay_type="pay_type=0 and ";
	$Rep_pay=$mem_credit;
	break;
case "1":
	$credit="block";
	$mgold="block";
	$pay_type="pay_type=1 and ";
	$Rep_pay=$mem_money;
	break;
case "":
	$credit="block";
	$mgold="block";
	$pay_type="";
	$Rep_pay=$Rep_pay_type_all;
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
case "RE":
	$wtype=" Type='RE' and";
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
case "VRE":
	$wtype=" Type='VRE' and";
	$Content='滾球上半場讓球';
	break;
case "VROU":
	$wtype=" Type='VROU' and";
	$Content='滾球上半場大小';
	break;
case "URE":
	$wtype=" Type='URE' and";
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
	$m_result=" M_Result!='' and ";
	break;
case "N":
	$m_result=" M_Result='' and ";
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
    $cancel='and Cancel=1';
}else if ($report_kind=='E'){
    $kind=$Rep_Kind_e;
    $cancel='and Confirmed=-17';
}

if ($wtype==''){
	$awtype='';
}else{
	$awtype='&wtype='.$wtype;
}

$sql="select ID,MID,LineType,Mtype,BetIP,Active,Cancel,BetTime,OpenType,OddsType,ShowType,D_Result,M_Result,T_Result,TurnRate,M_Name,A_Point,B_Point,C_Point,D_Point,$bettype as BetType,$middle as Middle,BetScore,M_Date,M_Rate,Agents,MB_ball,TG_ball,Confirmed,Danger from web_report_data where ".$m_result.$wtype.$Active." M_Name='$m_name' and M_Date>='$date_start' and M_Date<='$date_end' $cancel order by orderby,BetTime desc";
?>
<html>
<head>
<title>reports_member</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_tline {  background-image:    url(../images/agents/top/top_03b.gif)}
tr {  font-family: "Arial"; font-size: 12px}
a:link {  text-decoration: none}
a:visited {  text-decoration: none}
.za_button {  font-family: "Arial"; font-size: 12px; height: 20px; padding-top: 1px}
.za_select {  font-family: "Arial"; font-size: 12px; height: 18px}
.m_tab {  padding-top: 3px; padding-right: 2px; padding-left: 2px; background-color: #006255}
.m_cen {  background-color: #FFFFFF; text-align: center}
.m_left {  background-color: #FFFFFF; text-align: left}
.za_text {  background-color: #FFFFFF; height: 19px; padding-right: 2px; padding-left: 2px; border: #999999; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; font-family: "Arial"; font-size: 12px}
.m_bc_ed {  background-color: f2faff; padding-left: 5px}
.m_tab_ed { padding-right: 2px; padding-top: 3px; padding-bottom: 3px ; background-color: #dcdcdc; border: 1px #000000 solid; padding-left: 2px}
.za_dot {  height: 12px; width: 12px; margin-bottom: 2px}
.m_rig { text-align: right; background-color: #FFFFFF}
.m_rig_re { background-color: #DAE9F2; text-align: right }
.m_rig_to { background-color: #990000; text-align: right ; color: #FFFFFF}

.m_title_edit { background-color: #84968b; text-align: center}
.za_text_ed { background-color: #FFFFFF; height: 18px; padding-right: 1px; padding-left: 1px; border: #000000; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; font-family: "Arial"; font-size: 12px ; width: 65px}
.m_rig_close { text-align: right; background-color: #CCCCCC}
.m_cen_top { background-color: #FFFFFF; text-align: center ; vertical-align: top }
.m_cen_top_close { background-color: #CCCCCC; text-align: center ; vertical-align: top }
.m_cen_close { background-color: #CCCCCC; text-align: center }
.m_tab_fix { padding-top: 5px; padding-right: 5px; padding-left: 5px; padding-bottom: 5px; background-color: #A4C0CE}
.m_large {  font-size: 15px}

.m_title_ft { background-color: #60A433; text-align: center; color: #FFF }
.m_title_fu { background-color: #006255; text-align: center; color: #FFF }
.m_title_bk { background-color: #385EAB; text-align: center; color: #FFF }
.m_title_bu { background-color: #455e99; text-align: center; color: #FFF }
.m_title_bs { background-color: #D36614; text-align: center; color: #FFF }
.m_title_be { background-color: #227986; text-align: center; color: #FFF }
.m_title_vb { background-color: #7D13E8; text-align: center; color: #FFF }
.m_title_vu { background-color: #613c80; text-align: center; color: #FFF }
.m_title_tn { background-color: #B8211D; text-align: center; color: #FFF }
.m_title_tu { background-color: #990000; text-align: center; color: #FFF }
.m_title_op { background-color: #D86838; text-align: center; color: #FFF }
.m_title_om { background-color: #e49e88; text-align: center; color: #FFF }
.m_title_nfs{ background-color: #FFFF66; text-align: center; color: #FFF }

/*-----tab-----*/
.m_tab_ft {background-color: #3F6B21; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_fu {background-color: #006F64; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_bk {background-color: #437FBE; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_bu {background-color: #222e4c; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_bs {background-color: #E9731C; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_be {background-color: #2A94A4; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_vb {background-color: #983FEF; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_vu {background-color: #32274a; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_tn {background-color: #E0332F; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_tu {background-color: #660000; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_op {background-color: #B75024; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_om {background-color: #a82f16; padding-top: 3px; padding-right: 2px; padding-left: 2px}
.m_tab_nfs{background-color: #e3bb00; padding-top: 3px; padding-right: 2px; padding-left: 2px}

.m_tab_top {  padding-top: 3px; padding-right: 2px; padding-left: 2px;}
.m_title {  background-color: #687780; height: 30px; text-align: center; color: #FFFFFF}
.m_title_top { background-color: #CC0000; text-align: center; color: #FFFFFF}
.m_title_report {  background-color: #687780; height: 31px; text-align: center; color: #FFFFFF}

-->
</style>
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<SCRIPT>
function sbar(st){st.style.backgroundColor='#E0E0E0';}
function cbar(st){st.style.backgroundColor='';}
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<FORM NAME="LAYOUTFORM" ACTION="" METHOD=POST>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="m_tline" width="975">&nbsp;&nbsp;<?=$Rep_Member?>:<font color="#CC0000"><?=$m_name?></font>&nbsp;&nbsp;&nbsp;&nbsp;<?=$Rep_Date?>:<?=$date_start?> ~ <?=$date_end?> -- <?=$Rep_Kind?><?=$kind?> -- <?=$Rep_pay_type?><?=$Rep_pay?> -- <?=$Rep_Wtype?><?=$Content?> -- <?=$Rep_Type?> -- <a href="javascript:history.go( -1 );"><?=$Return_Back?></a> -- <a href="./report.php?uid=<?=$uid?>&lever=<?=$lv?>&langx=<?=$langx?>"><?=$Return_report?></a> -- <A HREF='backup.php?uid=<?=$uid?>&type=<?=$type?>&casino=<?=$casino?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&date_start=<?=$date_start?>&date_end=<?=$date_end?>&lever=M&result_type=<?=$result_type?>&m_name=<?=$m_name?>&corp_ck=<?=$corp_ck?>&act=<?=$act?>&langx=<?=$langx?>'>下载报表</a></td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr> 
      <td colspan="2" height="4"></td>
    </tr>
  </table>
  <table width="<?=$width?>" border="0" cellspacing="1" cellpadding="0" class="m_tab_top" bgcolor="#000000">
    <tr class="m_title_report" > 
      <td width="44" ><?=$Rep_Time?></td>
      <td width="70"><?=$Rep_Turn_Rate?></td>
      <td width="100"><?=$Rep_Gtype?></td>
      <td width="320"><?=$Rep_Text?></td>
      <td width="85"><?=$Rep_Money?></td>
      <td width="85"><?=$Rep_Result?></td>
<?
if($level=='M' or $level=='A'){
?>
      <td width="55"><?=$Rep_Agent?><br>(<?=$Rep_Pecert?>)</td>
      <td width="55"><?=$Rep_World?><br>(<?=$Rep_Pecert?>)</td>
      <td width="55"><?=$Rep_Corprator?><br>(<?=$Rep_Pecert?>)</td>
      <td width="95">IP</td>
<?
}else if($level=='B'){
?>
      <td width="55"><?=$Rep_Agent?><br>(<?=$Rep_Pecert?>)</td>
      <td width="55"><?=$Rep_World?><br>(<?=$Rep_Pecert?>)</td>
      <td width="55"><?=$Rep_Corprator?><br>(<?=$Rep_Pecert?>)</td>
<?
}else if($level=='C'){
?>
      <td width="55"><?=$Rep_Agent?><br>(<?=$Rep_Pecert?>)</td>
      <td width="55"><?=$Rep_World?><br>(<?=$Rep_Pecert?>)</td>
<?
}else if($level=='D'){
?>
      <td width="55"><?=$Rep_Agent?><br>(<?=$Rep_Pecert?>)</td>
<?
}
?>
    </tr>
<?
$ncount=0;
$score=0;
$win=0;
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);	
while ($row = mysql_fetch_array($result)){
$agents=$row['Agents'];
$ncount+=1;
$score+=$row['BetScore'];
$twin+=$row['T_Result'];
$win+=$row['M_Result'];
$middle=$row['Middle'];
		
switch($row['Active']){
case 1:
    $active='1';
	$Title=$Mnu_Soccer;
	break;
case 11:
    $active='11';
	$Title=$Mnu_Soccer;
	break;
case 2:
    $active='2';
	$Title=$Mnu_Bask;
	break;
case 22:
    $active='22';
	$Title=$Mnu_Bask;
	break;
case 3:
    $active='3';
	$Title=$Mnu_Base;
	break;
case 33:
    $active='33';
	$Title=$Mnu_Base;
	break;
case 4:
    $active='4';
	$Title=$Mnu_Tennis;
	break;
case 44:
    $active='44';
	$Title=$Mnu_Tennis;
	break;
case 5:
    $active='5';
	$Title=$Mnu_Voll;
	break;
case 55:
    $active='55';
	$Title=$Mnu_Voll;
	break;
case 6:
    $active='6';
	$Title=$Mnu_Other;
	break;
case 66:
    $active='66';
	$Title=$Mnu_Other;
	break;
case 7:
    $active='7';
	$Title=$Mnu_Stock;
	break;
case 77:
    $active='77';
	$Title=$Mnu_Stock;
	break;
case 8:
    $active='8';
	$Title=$Mnu_Guan;
	break;
case 9:
	$Title=$Mnu_MarkSix;
	break;
}
switch ($row['OddsType']){
case 'H':
    $Odds='<BR><font color =green>'.$Rep_HK.'</font>';
	break;
case 'M':
    $Odds='<BR><font color =green>'.$Rep_Malay.'</font>';
	break;
case 'I':
    $Odds='<BR><font color =green>'.$Rep_Indo.'</font>';
	break;
case 'E':
    $Odds='<BR><font color =green>'.$Rep_Euro.'</font>';
	break;
case '':
    $Odds='';
	break;
}
$time=strtotime($row['BetTime']);
$times=date("m-d",$time).'<br>'.date("H:i:s",$time);

if($row['Danger']==1 or $row['Cancel']==1) {
$bettimes='<font color="#FFFFFF"><span style="background-color: #FF0000">'.$times.'</span></font>';
$betscore = $row['BetScore'];
}else{
$bettimes=$times;
$betscore = $row['BetScore'];
}
if ($row['ShowType']=='H' or $row['LineType']=='10' or $row['LineType']=='20'){
    $matchball=$row['MB_ball'].':'.$row['TG_ball'];
}else{
    $matchball=$row['TG_ball'].':'.$row['MB_ball'];
}	
?>
    <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
      <td align="center"><?=$bettimes?></td>
      <td align="center"><?=$row['M_Name']?><br><font color="#0000CC"><?=$row['OpenType']?></font>&nbsp;&nbsp;&nbsp;<font color="#CC0000"><?=$row['TurnRate']?></font></td>
      <td align="center"><?=$Title?><?=$row['BetType']?><?=$Odds?><br><font color="#0000CC"><?=show_voucher($row['LineType'],$row['ID'])?></font></td>
      <td>
<?
if($row['Cancel']==1){
echo "<span style=float:left;color=#0000FF>".$matchball."</span>";
}
?>
<?
if ($row['Active']==$active){	
	if ($row['LineType']==8){
		$midd=explode('<br>',$row['Middle']);
		$mid=explode(',',$row['MID']);
		$show=explode(',',$row['ShowType']);
		$mtype=explode(',',$row['Mtype']);
		for($t=0;$t<(sizeof($midd)-1)/3;$t++){
			echo $midd[3*$t].'<br>';
			$mysql="select MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where MID=".$mid[$t];
			$result1 = mysql_db_query($dbname,$mysql);
			$row1 = mysql_fetch_array($result1);
		    if ($row1["MB_Inball"]=='-1'){
	            $font_a3='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-2'){     
	            $font_a3='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';	
		    }else if ($row1["MB_Inball"]=='-3'){      
	            $font_a3='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';	
		    }else if ($row1["MB_Inball"]=='-4'){     
	            $font_a3='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-5'){     
	            $font_a3='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-6'){     
	            $font_a3='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-7'){     
	            $font_a3='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-8'){     
	            $font_a3='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-9'){     
	            $font_a3='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-10'){     
	            $font_a3='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-11'){
	            $font_a3='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-12'){     
	            $font_a3='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';	
		    }else if ($row1["MB_Inball"]=='-13'){      
	            $font_a3='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';	
		    }else if ($row1["MB_Inball"]=='-14'){     
	            $font_a3='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-15'){     
	            $font_a3='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-16'){     
	            $font_a3='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-17'){     
	            $font_a3='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-18'){     
	            $font_a3='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-19'){     
	            $font_a3='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';	  	 	  
		    }else{
		    	$font_a3='<font color="#009900"><b>'.$row1["TG_Inball"].'</b> : <b>'.$row1["MB_Inball"].'</b></font>&nbsp;';
		    	$font_a4='<font color="#009900"><b>'.$row1["MB_Inball"].'</b> : <b>'.$row1["TG_Inball"].'</b></font>&nbsp;';
		    }
			echo $midd[3*$t+1].'<br>';
		    if ($show[$t]=='C' and ($mtype[$t]=='RH' or $mtype[$t]=='RC') and $row['LineType']==8){
			    echo $font_a3;
		    }else{
			    echo $font_a4;
		    }
			echo $midd[3*$t+2].'<br>';
		}
	}else if ($row['LineType']==16){
		$midd=explode('<br>',$row['Middle']);
		for($t=0;$t<sizeof($midd)-1;$t++){
			echo $midd[$t].'<br>';
		}
			$mysql="select MB_Inball from match_sports where ID=".$row['MID'];
			$result1 = mysql_db_query($dbname,$mysql);
			$row1 = mysql_fetch_array($result1);
		    if ($row1["MB_Inball"]=='-1'){
	            $lnball='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-2'){     
	            $lnball='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-3'){      
	            $lnball='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-4'){     
	            $lnball='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-5'){     
	            $lnball='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-6'){     
	            $lnball='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-7'){     
	            $lnball='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-8'){     
	            $lnball='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-9'){     
	            $lnball='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-10'){     
	            $lnball='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-11'){
	            $lnball='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-12'){     
	            $lnball='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-13'){      
	            $lnball='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-14'){     
	            $lnball='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-15'){     
	            $lnball='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-16'){     
	            $lnball='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-17'){     
	            $lnball='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-18'){     
	            $lnball='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-19'){     
	            $lnball='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';	  	 	  
		    }else{
		    	$lnball='<font color="#009900"><b>'.$row1["MB_Inball"].'</b></font>&nbsp;';
		    }
		    if ($row1["MB_Inball"]==1){
			    echo '<font color="#009900"><b>冠军&nbsp;</b></font>';
			}else if ($row1["MB_Inball"]==0){
			    echo '<font color="#009900"><b>失败&nbsp;</b></font>';
		    }else if ($row1["MB_Inball"]<0){
			    echo $lnball;
		    }
			echo $midd[sizeof($midd)-1];
	}else{
		$midd=explode('<br>',$row['Middle']);
		for($t=0;$t<sizeof($midd)-1;$t++){
			echo $midd[$t].'<br>';
		}
		$mysql="select MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where MID=".$row['MID'];
		$result1 = mysql_db_query($dbname,$mysql);
		$row1 = mysql_fetch_array($result1);
		
        if ($row1["MB_Inball"]=='-1'){
            if($row1["MB_Inball_HR"]=='-1' and $row1["MB_Inball"]=='-1'){
	           $font_a1='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-2'){
            if($row1["MB_Inball_HR"]=='-2' and $row1["MB_Inball"]=='-2'){
	           $font_a1='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-3'){
            if($row1["MB_Inball_HR"]=='-3' and $row1["MB_Inball"]=='-3'){
	           $font_a1='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-4'){
            if($row1["MB_Inball_HR"]=='-4' and $row1["MB_Inball"]=='-4'){
	           $font_a1='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-5'){
            if($row1["MB_Inball_HR"]=='-5' and $row1["MB_Inball"]=='-5'){
	           $font_a1='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-6'){
            if($row1["MB_Inball_HR"]=='-6' and $row1["MB_Inball"]=='-6'){
	           $font_a1='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-7'){
            if($row1["MB_Inball_HR"]=='-7' and $row1["MB_Inball"]=='-7'){
	           $font_a1='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-8'){
            if($row1["MB_Inball_HR"]=='-8' and $row1["MB_Inball"]=='-8'){
	           $font_a1='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-9'){
            if($row1["MB_Inball_HR"]=='-9' and $row1["MB_Inball"]=='-9'){
	           $font_a1='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-10'){
            if($row1["MB_Inball_HR"]=='-10' and $row1["MB_Inball"]=='-10'){
	           $font_a1='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-11'){
            if($row1["MB_Inball_HR"]=='-11' and $row1["MB_Inball"]=='-11'){
	           $font_a1='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-12'){
            if($row1["MB_Inball_HR"]=='-12' and $row1["MB_Inball"]=='-12'){
	           $font_a1='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-13'){
            if($row1["MB_Inball_HR"]=='-13' and $row1["MB_Inball"]=='-13'){
	           $font_a1='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-14'){
            if($row1["MB_Inball_HR"]=='-14' and $row1["MB_Inball"]=='-14'){
	           $font_a1='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-15'){
            if($row1["MB_Inball_HR"]=='-15' and $row1["MB_Inball"]=='-15'){
	           $font_a1='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-16'){
            if($row1["MB_Inball_HR"]=='-16' and $row1["MB_Inball"]=='-16'){
	           $font_a1='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-17'){
            if($row1["MB_Inball_HR"]=='-17' and $row1["MB_Inball"]=='-17'){
	           $font_a1='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-18'){
            if($row1["MB_Inball_HR"]=='-18' and $row1["MB_Inball"]=='-18'){
	           $font_a1='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-19'){
            if($row1["MB_Inball_HR"]=='-19' and $row1["MB_Inball"]=='-19'){
	           $font_a1='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
            }  
        }else{
	           $font_a3='<font color="#009900"><b>'.$row1["TG_Inball"].'</b> : <b>'.$row1["MB_Inball"].'</b></font> &nbsp;';
	           $font_a4='<font color="#009900"><b>'.$row1["MB_Inball"].'</b> : <b>'.$row1["TG_Inball"].'</b></font>&nbsp; ';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp; ';
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp; ';
        }
		
		if ($row['LineType']==11 or $row['LineType']==12 or $row['LineType']==13 or $row['LineType']==14 or $row['LineType']==19 or $row['LineType']==20 or $row['LineType']==31){
			if ($row['ShowType']=='C' and ($row['LineType']==12 or $row['LineType']==19)){
				echo $font_a1;
			}else{
				echo $font_a2;
			}
		}else{
			if ($row['ShowType']=='C' and ($row['LineType']==2 or $row['LineType']==9)){
				echo $font_a3;
		    }else{
			    echo $font_a4;
		    }
		}
	    echo $midd[sizeof($midd)-1];
}

}else{
	echo $row['Middle'];
}
?>
	  </td>
      <td><?=number_format($betscore,0)?></td>
      <td>
<? 	
if($row['Cancel']==0){
?>	  
<?=number_format($row['M_Result'],1)?>
<?
}else{
?>
<font color=red>
<?
switch($row['Confirmed']){
case 0:
echo $zt=$Score20;
break;
case -1:
echo $zt=$Score21;
break;
case -2:
echo $zt=$Score22;
break;
case -3:
echo $zt=$Score23;
break;
case -4:
echo $zt=$Score24;
break;
case -5:
echo $zt=$Score25;
break;
case -6:
echo $zt=$Score26;
break;
case -7:
echo $zt=$Score27;
break;
case -8:
echo $zt=$Score28;
break;
case -9:
echo $zt=$Score29;
break;
case -10:
echo $zt=$Score30;
break;
case -11:
echo $zt=$Score31;
break;
case -12:
echo $zt=$Score32;
break;
case -13:
echo $zt=$Score33;
break;
case -14:
echo $zt=$Score34;
break;
case -15:
echo $zt=$Score35;
break;
case -16:
echo $zt=$Score36;
break;
case -17:
echo $zt=$Score37;
break;
case -18:
echo $zt=$Score38;
break;
case -19:
echo $zt=$Score39;
break;
case -20:
echo $zt=$Score40;
break;
case -21:
echo $zt=$Score41;
break;
}
?>
</font>
<?
}
?>
      </td>
<?
if($level=='M' or $level=='A'){
?>
      <td align="center"><?=number_format($row['D_Point'])?></td>
      <td align="center"><?=number_format($row['C_Point'])?></td>
      <td align="center"><?=number_format($row['B_Point'])?></td>
      <td align="center"><font color=#cc0000><?=$row['BetIP']?></font></td>
<?
}else if($level=='B'){
?>
      <td align="center"><?=number_format($row['D_Point'])?></td>
      <td align="center"><?=number_format($row['C_Point'])?></td>
      <td align="center"><?=number_format($row['B_Point'])?></td>
<?
}else if($level=='C'){
?>	  
      <td align="center"><?=number_format($row['D_Point'])?></td>
      <td align="center"><?=number_format($row['C_Point'])?></td>
<?
}else if($level=='D'){
?>
      <td align="center"><?=number_format($row['D_Point'])?></td>
<?
}
?>  
    </tr>
<?
}
?>
    <tr class="m_rig_re"> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td > <?=$ncount?></td>
      <td ><?=number_format($score,1)?></td>
      <td bgcolor="#000033"><font color="#FFFFFF"><?=number_format($win,1)?></font></td>
<?
if($level=='M' or $level=='A'){
?>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
<?
}else if($level=='B'){
?>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
<?
}else if($level=='C'){
?>	  
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
<?
}else if($level=='D'){
?>
      <td bgcolor="#FFFFFF">&nbsp;</td>
<?
}
?> 
    </tr>
  </table>
<table width="975" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="15"></td>
</tr>
</table>
  
<table width="695" border="0" cellspacing="1" cellpadding="0" class="m_tab_top" bgcolor="#000000">
  <tr class="m_title_top" >
    <td width="50"></td> 
    <td width="73"><?=$Rep_Turn_Rate?></td>
    <td width="113"><?=$Rep_Agent?></td>
    <td width="312"><?=$Rep_Num?></td>
      <td width="70"><?=$Rep_Money?></td>
      <td width="70"><?=$Rep_Result?></td>
    </tr>
    
  <tr class="m_rig">
    <td>&nbsp;</td> 
      <td><?=$twin-$win?></td>
      <td align="center"><?=$agents;?></td>
      <td><?=$ncount?></td>
      <td><?=number_format($score,1)?></td>
      <td><?=number_format($twin,1)?></td>
    </tr>
  </table>
</form>
</body>
</html>