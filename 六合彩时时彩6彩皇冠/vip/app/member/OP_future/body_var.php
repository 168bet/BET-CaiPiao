<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/curl_http.php");
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
$league_id=$_REQUEST['league_id'];
$g_date=$_REQUEST['g_date'];
$page_no=$_REQUEST['page_no'];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$open    = $row['OpenType'];
$memname = $row['UserName'];
$credit  = $row['Money'];

if ($league_id==''){
	$num=60;
}else{
	$num=60;
}
if($g_date=="ALL" or $g_date=="undefined" or $g_date==""){
   $date="";
}else{
   $date="and M_Date='$g_date'";
}
if ($page_no==''){
    $page_no=0;
}
$m_date=date('Y-m-d');
$K=0;
?>
<HEAD><TITLE>其它變數值</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<SCRIPT language=JavaScript>
<!--
parent.flash_ior_set='Y';
parent.minlimit_VAR='';
parent.maxlimit_VAR='';
parent.username='<?=$memname?>';
parent.maxcredit='<?=$credit?>';
parent.code='人民幣(RMB)';
parent.uid='<?=$uid?>';
parent.msg='<?=$mem_msg?>';
parent.ltype='3';
parent.str_even = '<?=$str_even?>';
parent.str_submit = '<?=$str_submit?>';
parent.str_reset = '<?=$str_reset?>';
parent.langx='<?=$langx?>';
parent.rtype='<?=$rtype?>';
parent.sel_lid='<?=$league_id?>';
parent.g_date = 'ALL';
parent.retime=0;
<?php 
switch ($rtype){
case "r":
	$mysql = "select MID,M_Date,M_Time,M_Type,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,TG_Dime,MB_Dime_Rate,TG_Dime_Rate,MB_Win_Rate,TG_Win_Rate,M_Flat_Rate,S_Single_Rate,S_Double_Rate,ShowTypeHR,M_LetB_H,MB_LetB_Rate_H,TG_LetB_Rate_H,MB_Dime_H,TG_Dime_H,MB_Dime_Rate_H,TG_Dime_Rate_H,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H,PD_Show,HPD_Show,T_Show,F_Show,Eventid,Hot,Play from `match_sports` where Type='OM' and `M_Date` >'$m_date' and S_Show=1 and $mb_team!='' ".$date." order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num;";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.str_renew = '$manual_update';\n";
	echo "parent.game_more=1;\n";
	echo "parent.str_more='$more';\n";
	echo "parent.t_page=$page_count;\n";	
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
	    $MB_Win_Rate=num_rate($open,$row["MB_Win_Rate"]);
		$TG_Win_Rate=num_rate($open,$row["TG_Win_Rate"]);
		$M_Flat_Rate=num_rate($open,$row["M_Flat_Rate"]);	
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);				
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);
		$S_Single=num_rate($open,$row['S_Single_Rate']);
		$S_Double=num_rate($open,$row['S_Double_Rate']);
		
		$MB_Win_Rate_v=num_rate($open,$row["MB_Win_Rate_H"]);
		$TG_Win_Rate_v=num_rate($open,$row["TG_Win_Rate_H"]);
		$M_Flat_Rate_v=num_rate($open,$row["M_Flat_Rate_H"]);
		$MB_Dime_Rate_v=change_rate($open,$row["MB_Dime_Rate_H"]);
		$TG_Dime_Rate_v=change_rate($open,$row["TG_Dime_Rate_H"]);				
		$MB_LetB_Rate_v=change_rate($open,$row['MB_LetB_Rate_H']);
		$TG_LetB_Rate_v=change_rate($open,$row['TG_LetB_Rate_H']);
		
		if ($row['PD_Show']==1 and $row['T_Show']==1 and $row['F_Show']==1){
		    $show=3;
		}else if ($row['HPD_Show']==1 and $row['PD_Show']==1 and $row['T_Show']==1 and $row['F_Show']==1){
		    $show=4;
		}else{
		    $show=0;
		}
		$m_date=strtotime($row['M_Date']);
	    $dates=date("m-d",$m_date);	
		if ($row['M_Type']==1){
			echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]<br><font color=red>Running Ball</font>','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$MB_Win_Rate','$TG_Win_Rate','$M_Flat_Rate','$Odd','$Even','$S_Single','$S_Double','0','$row[ShowTypeHR]','$row[M_LetB_H]','$MB_LetB_Rate_v','$TG_LetB_Rate_v','$row[MB_Dime_H]','$row[TG_Dime_H]','$TG_Dime_Rate_v','$MB_Dime_Rate_v','$MB_Win_Rate_v','$TG_Win_Rate_v','$M_Flat_Rate_v','$show','$row[Eventid]','$row[Hot]','$row[Play]');\n";
		}else{
			echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$MB_Win_Rate','$TG_Win_Rate','$M_Flat_Rate','$Odd','$Even','$S_Single','$S_Double','0','$row[ShowTypeHR]','$row[M_LetB_H]','$MB_LetB_Rate_v','$TG_LetB_Rate_v','$row[MB_Dime_H]','$row[TG_Dime_H]','$TG_Dime_Rate_v','$MB_Dime_Rate_v','$MB_Win_Rate_v','$TG_Win_Rate_v','$M_Flat_Rate_v','$show','$row[Eventid]','$row[Hot]','$row[Play]');\n";
		}
	$K=$K+1;	
	}
	break;
case "hr":
	$mysql = "select MID,M_Date,M_Time,M_Type,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H,ShowTypeHR,M_LetB_H,MB_LetB_Rate_H,TG_LetB_Rate_H,MB_Dime_H,TG_Dime_H,MB_Dime_Rate_H,TG_Dime_Rate_H from `match_sports` where Type='OM' and `M_Date` >'$m_date' and $mb_team<>'' and H_Show=1 ".$date." order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num;";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.str_renew = '$manual_update';\n";	
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
	    $MB_Win_Rate_v=num_rate($open,$row["MB_Win_Rate_H"]);
		$TG_Win_Rate_v=num_rate($open,$row["TG_Win_Rate_H"]);
		$M_Flat_Rate_v=num_rate($open,$row["M_Flat_Rate_H"]);
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate_H"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate_H"]);				
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate_H']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate_H']);
		$m_date=strtotime($row['M_Date']);
	    $dates=date("m-d",$m_date);	
		if ($row['M_Type']==1){
		echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]<br><font color=red>Running Ball</font>','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[TG_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[ShowTypeHR]','$row[M_LetB_H]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime_H]','$row[TG_Dime_H]','$TG_Dime_Rate','$MB_Dime_Rate','$MB_Win_Rate_v','$TG_Win_Rate_v','$M_Flat_Rate_v');\n";
		}else{
		echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[TG_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[ShowTypeHR]','$row[M_LetB_H]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime_H]','$row[TG_Dime_H]','$TG_Dime_Rate','$MB_Dime_Rate','$MB_Win_Rate_v','$TG_Win_Rate_v','$M_Flat_Rate_v');\n";
		}
		$K=$K+1;	
	}
	break;
case "pd":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,UP5,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowTypeR from `match_sports` where Type='OM' and `M_Date` >'$m_date' and PD_Show=1 and MB2TG1!=0 and $mb_team<>'' ".$date." order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num;";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
		$m_date=strtotime($row['M_Date']);
	    $dates=date("m-d",$m_date);	
		echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[UP5]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]','');\n";
		$K=$K+1;	
	}
	break;
case "hpd":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB1TG0H,MB2TG0H,MB2TG1H,MB3TG0H,MB3TG1H,MB3TG2H,MB4TG0H,MB4TG1H,MB4TG2H,MB4TG3H,MB0TG0H,MB1TG1H,MB2TG2H,MB3TG3H,MB4TG4H,UP5H,MB0TG1H,MB0TG2H,MB1TG2H,MB0TG3H,MB1TG3H,MB2TG3H,MB0TG4H,MB1TG4H,MB2TG4H,MB3TG4H,ShowTypeR from `match_sports` where Type='OM' and `M_Date` >'$m_date' and HPD_Show=1 and MB2TG1H!=0 and $mb_team<>'' ".$date." order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=18;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*18;	
	$mysql=$mysql."  limit $offset,$num;";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
	    $m_date=strtotime($row['M_Date']);
	    $dates=date("m-d",$m_date);	
		echo "parent.GameFT[$K]=newnew Array('$row[MID]','$dates<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[TG_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[ShowTypeR]','$row[MB1TG0H]','$row[MB2TG0H]','$row[MB2TG1H]','$row[MB3TG0H]','$row[MB3TG1H]','$row[MB3TG2H]','$row[MB4TG0H]','$row[MB4TG1H]','$row[MB4TG2H]','$row[MB4TG3H]','$row[MB0TG0H]','$row[MB1TG1H]','$row[MB2TG2H]','$row[MB3TG3H]','$row[MB4TG4H]','$row[UP5H]','$row[MB0TG1H]','$row[MB0TG2H]','$row[MB1TG2H]','$row[MB0TG3H]','$row[MB1TG3H]','$row[MB2TG3H]','$row[MB0TG4H]','$row[MB1TG4H]','$row[MB2TG4H]','$row[MB3TG4H]');\n";
		$K=$K+1;	
	}
	break;
case "t":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate,TG_Win_Rate,M_Flat_Rate,S_0_1,S_2_3,S_4_6,S_7UP,MB_MID,TG_MID,ShowTypeR from `match_sports` where Type='OM' and `M_Date` >'$m_date' and T_Show=1 ".$date." order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num;";	
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);	
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
		$MB_Win_Rate=num_rate($open,$row["MB_Win_Rate"]);
		$TG_Win_Rate=num_rate($open,$row["TG_Win_Rate"]);
		$M_Flat_Rate=num_rate($open,$row["M_Flat_Rate"]);
		$m_date=strtotime($row['M_Date']);
	    $dates=date("m-d",$m_date);	
		echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','0','0','$row[S_0_1]','$row[S_2_3]','$row[S_4_6]','$row[S_7UP]','$MB_Win_Rate','$TG_Win_Rate','$M_Flat_Rate');\n";		
		$K=$K+1;	
	}
	break;	
case "f":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MBMB,MBFT,MBTG,FTMB,FTFT,FTTG,TGMB,TGFT,TGTG,MB_MID,TG_MID,ShowTypeR from `match_sports` where Type='OM' and `M_Date` >'$m_date' and F_Show=1 ".$date." order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num;";	
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$m_date=strtotime($row['M_Date']);
	    $dates=date("m-d",$m_date);	
		echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[MBMB]','$row[MBFT]','$row[MBTG]','$row[FTMB]','$row[FTFT]','$row[FTTG]','$row[TGMB]','$row[TGFT]','$row[TGTG]','Y');\n";
		$K=$K+1;	
	}
	break;	
case "p3":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_MID,TG_MID,ShowTypeP,MB_P_LetB_Rate,TG_P_LetB_Rate,M_P_LetB,MB_P_Dime,TG_P_Dime,MB_P_Dime_Rate,TG_P_Dime_Rate,S_P_Single_Rate,S_P_Double_Rate,MB_P_Win_Rate,TG_P_Win_Rate,M_P_Flat_Rate,ShowTypeHP,M_P_LetB_H,MB_P_LetB_Rate_H,TG_P_LetB_Rate_H,MB_P_Dime_H,TG_P_Dime_H,MB_P_Dime_Rate_H,TG_P_Dime_Rate_H,MB_P_Win_Rate_H,TG_P_Win_Rate_H,M_P_Flat_Rate_H,PD_Show,HPD_Show,T_Show,F_Show from `match_sports` where Type='OM' and `M_Start` > now( ) AND `M_Date` ='$m_date'  and P3_Show=1 and $mb_team!='' order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.game_more=1;\n";
	echo "parent.str_more='$more';\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
	$MB_P_Win_Rate=num_rate($open,$row["MB_P_Win_Rate"]);
	$TG_P_Win_Rate=num_rate($open,$row["TG_P_Win_Rate"]);
	$M_P_Flat_Rate=num_rate($open,$row["M_P_Flat_Rate"]);
	$MB_P_LetB_Rate=change_rate($open,$row['MB_P_LetB_Rate']);
	$TG_P_LetB_Rate=change_rate($open,$row['TG_P_LetB_Rate']);
	$MB_P_Dime_Rate=change_rate($open,$row['MB_P_Dime_Rate']);
	$TG_P_Dime_Rate=change_rate($open,$row['TG_P_Dime_Rate']);
	$S_P_Single_Rate=num_rate($open,$row['S_P_Single_Rate']);
	$S_P_Double_Rate=num_rate($open,$row['S_P_Double_Rate']);
		
	$MB_P_Win_Rate_H=num_rate($open,$row["MB_P_Win_Rate_H"]);
	$TG_P_Win_Rate_H=num_rate($open,$row["TG_P_Win_Rate_H"]);
	$M_P_Flat_Rate_H=num_rate($open,$row["M_P_Flat_Rate_H"]);
	$MB_P_LetB_Rate_H=change_rate($open,$row['MB_P_LetB_Rate_H']);
	$TG_P_LetB_Rate_H=change_rate($open,$row['TG_P_LetB_Rate_H']);
	$MB_P_Dime_Rate_H=change_rate($open,$row["MB_P_Dime_Rate_H"]);
	$TG_P_Dime_Rate_H=change_rate($open,$row["TG_P_Dime_Rate_H"]);				

	$mb_team=trim($row['MB_Team']);	
	$m_date=strtotime($row['M_Date']);
	$dates=date("m-d",$m_date);	
	if (strlen($row['M_Time'])==5){
		$pdate=$dates.'<br>0'.$row[M_Time];
	}else{
		$pdate=$dates.'<br>'.$row[M_Time];
	}
	if ($row['PD_Show']==1 and $row['T_Show']==1 and $row['F_Show']==1){
		$show=3;
	}else if ($row['HPD_Show']==1 and $row['PD_Show']==1 and $row['T_Show']==1 and $row['F_Show']==1){
		$show=4;
	}else{
		$show=0;
	}
		echo "parent.GameFT[$K]=new Array('$row[MID]','$pdate','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeP]','$row[M_P_LetB]','$MB_P_LetB_Rate','$TG_P_LetB_Rate','$row[MB_P_Dime]','$row[TG_P_Dime]','$MB_P_Dime_Rate','$TG_P_Dime_Rate','$S_P_Single_Rate','$S_P_Double_Rate','$MB_P_Win_Rate','$TG_P_Win_Rate','$M_P_Flat_Rate','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[UP5]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]','','$row[S_0_1]','$row[S_2_3]','$row[S_4_6]','$row[S_7UP]','$row[MBMB]','$row[MBFT]','$row[MBTG]','$row[FTMB]','$row[FTFT]','$row[FTTG]','$row[TGMB]','$row[TGFT]','$row[TGTG]','0','$row[ShowTypeHP]','$row[M_P_LetB_H]','$MB_P_LetB_Rate_H','$TG_P_LetB_Rate_H','$row[MB_P_Dime_H]','$row[TG_P_Dime_H]','$TG_P_Dime_Rate_H','$MB_P_Dime_Rate_H','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','$MB_P_Win_Rate_H','$TG_P_Win_Rate_H','$M_P_Flat_Rate_H','$show');\n";
		$K=$K+1;	
	}
	break;
}
mysql_close();
?>
function onLoad(){
	if(parent.parent.mem_order.location == 'about:blank'){
		parent.parent.mem_order.location = '/app/member/select.php?uid=<?=$uid?>&langx=<?=$langx?>';
	}
	if(parent.retime > 0)
		parent.retime_flag='Y';
	else
		parent.retime_flag='N';
	parent.loading_var = 'N';
	if(parent.loading == 'N' && parent.ShowType != ''){
		parent.ShowGameList();
		//parent.body_browse.document.all.LoadLayer.style.display = 'none';
	}
}
 
function onUnLoad(){
	x = parent.body_browse.pageXOffset;
	y = parent.body_browse.pageYOffset;
	parent.body_browse.scroll(x,y);
	//obj_layer = parent.body_browse.document.getElementById('LoadLayer');
	//obj_layer.style.display = 'block';
}
 
// -->
</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad()" onUnLoad="onUnLoad()">
</body>
</html>
