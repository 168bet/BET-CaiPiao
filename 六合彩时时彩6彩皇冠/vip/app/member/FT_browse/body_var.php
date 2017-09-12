<?
session_start();
header("Expires: Mon, 26 Jul 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

require ("../include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/curl_http.php");
include "../include/login_session.php";

$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
$league_id=$_REQUEST['league_id'];
$page_no=$_REQUEST['page_no'];
$showtype=$_REQUEST['showtype'];
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
$open=$row['OpenType'];
$memname=$row['UserName'];
$credit=$row['Money'];

if ($league_id=='' and $showtype!='hgft'){
	$num=60;
}else{
	$num=60;
}
if ($page_no==''){
    $page_no=0;
}
$m_date=date('Y-m-d');
$date=date('m-d');
$K=0;
?>
<HEAD>
<TITLE>足球變數值</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<SCRIPT language=JavaScript>
<!--
parent.flash_ior_set='Y';
parent.minlimit_VAR='3';
parent.maxlimit_VAR='10';
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
<?php 
switch ($rtype){
case "r":
	$mysql="select MID,M_Time,M_Type,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,MB_Win_Rate,TG_Win_Rate,M_Flat_Rate,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,TG_Dime,MB_Dime_Rate,TG_Dime_Rate,S_Single_Rate,S_Double_Rate,ShowTypeHR,M_LetB_H,MB_LetB_Rate_H,TG_LetB_Rate_H,MB_Dime_H,TG_Dime_H,MB_Dime_Rate_H,TG_Dime_Rate_H,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H,PD_Show,HPD_Show,T_Show,F_Show,Eventid,Hot,Play from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date` ='$m_date' and `S_Show`=1 and $mb_team!='' and `Open`=1 order by M_Start,$m_league,$mb_team,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=180;\n";
	echo "parent.str_renew = '$second_auto_update';\n";
	echo "parent.game_more=1;\n";
	echo "parent.str_more='$more';\n";
	echo "parent.t_page=$page_count;\n";	
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
	    $MB_Win_Rate=num_rate($open,$row["MB_Win_Rate"]);
		$TG_Win_Rate=num_rate($open,$row["TG_Win_Rate"]);
		$M_Flat_Rate=num_rate($open,$row["M_Flat_Rate"]);
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);				
		$S_Single_Rate=num_rate($open,$row['S_Single_Rate']);
		$S_Double_Rate=num_rate($open,$row['S_Double_Rate']);
		
		$MB_Win_Rate_H=num_rate($open,$row["MB_Win_Rate_H"]);
		$TG_Win_Rate_H=num_rate($open,$row["TG_Win_Rate_H"]);
		$M_Flat_Rate_H=num_rate($open,$row["M_Flat_Rate_H"]);
		$MB_LetB_Rate_H=change_rate($open,$row['MB_LetB_Rate_H']);
		$TG_LetB_Rate_H=change_rate($open,$row['TG_LetB_Rate_H']);
		$MB_Dime_Rate_H=change_rate($open,$row["MB_Dime_Rate_H"]);
		$TG_Dime_Rate_H=change_rate($open,$row["TG_Dime_Rate_H"]);				
		
		if ($row['HPD_Show']==1 and $row['PD_Show']==1 and $row['T_Show']==1 and $row['F_Show']==1){
		    $show=4;
		}else if ($row['PD_Show']==1 and $row['T_Show']==1 and $row['F_Show']==1){
		    $show=3;
		}else{
		    $show=0;
		}
		if ($row['M_Type']==1){
			$Running="<br><font color=red>Running Ball</font>";
		}else{	
			$Running="";
		}
		echo "parent.GameFT[$K]=new Array('$row[MID]','$date<br>$row[M_Time]$Running','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$MB_Win_Rate','$TG_Win_Rate','$M_Flat_Rate','$o','$e','$S_Single_Rate','$S_Double_Rate','$row[MID]','$row[ShowTypeHR]','$row[M_LetB_H]','$MB_LetB_Rate_H','$TG_LetB_Rate_H','$row[MB_Dime_H]','$row[TG_Dime_H]','$TG_Dime_Rate_H','$MB_Dime_Rate_H','$MB_Win_Rate_H','$TG_Win_Rate_H','$M_Flat_Rate_H','$show','$row[Eventid]','$row[Hot]','$row[Play]');\n";		
	$K=$K+1;	
	}
	break;
case "hr":
	$mysql = "select MID,M_Time,M_Type,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H,ShowTypeHR,M_LetB_H,MB_LetB_Rate_H,TG_LetB_Rate_H,MB_Dime_Rate_H,TG_Dime_Rate_H,MB_Dime_H,TG_Dime_H from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date` ='$m_date' and $mb_team!='' and `H_Show`=1 and `Open`=1 order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.str_renew = '$manual_update';\n";	
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
	    $MB_Win_Rate_H=num_rate($open,$row["MB_Win_Rate_H"]);
		$TG_Win_Rate_H=num_rate($open,$row["TG_Win_Rate_H"]);
		$M_Flat_Rate_H=num_rate($open,$row["M_Flat_Rate_H"]);
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate_H"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate_H"]);				
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate_H']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate_H']);
		if ($row['M_Type']==1){
			$Running="<br><font color=red>Running Ball</font>";
		}else{	
			$Running="";
		}
		echo "parent.GameFT[$K]=new Array('$row[MID]','$date<br>$row[M_Time]$Running','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[TG_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[ShowTypeHR]','$row[M_LetB_H]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime_H]','$row[TG_Dime_H]','$TG_Dime_Rate','$MB_Dime_Rate','$MB_Win_Rate_H','$TG_Win_Rate_H','$M_Flat_Rate_H');\n";
		$K=$K+1;	
	}
	break;
case "re":
	$mysql = "select datasite,datasite_tw,datasite_en,Uid,Uid_tw,Uid_en from web_system_data where ID=1";
	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
	switch($langx)	{
	case "zh-tw":
		$suid=$row['Uid_tw'];
		$site=$row['datasite_tw'];
		break;
	case "zh-cn":
		$suid=$row['Uid'];
		$site=$row['datasite'];
		break;
	case "en-us":
		$suid=$row['Uid_en'];
		$site=$row['datasite_en'];
		break;
	case "th-tis":
		$suid=$row['Uid_en'];
		$site=$row['datasite_en'];
		break;
	}
	$curl = &new Curl_HTTP_Client();
	$curl->store_cookies("cookies.txt"); 
	$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	$curl->set_referrer("".$site."/app/member/FT_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/FT_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	preg_match_all("/new Array\((.+?)\);/is",$html_data,$matches);
	//echo $html_data;
	$cou=sizeof($matches[0]);
	echo "parent.retime=60;\n";
	echo "parent.str_renew = '$second_auto_update';\n";
	echo "parent.gamount=$cou;\n";
	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace("new Array(","",$messages);
	    $messages=str_replace(");","",$messages);
	    $messages=str_replace("'","",$messages);
	    $datainfo=explode(",",$messages);
				
		$opensql = "select * from `match_sports` where  MID='$datainfo[0]' and `Type`='FT'";
		//echo $opensql;
	    $openresult = mysql_db_query($dbname,$opensql);
	    $openrow=mysql_fetch_array($openresult);
		if ($openrow['Open']==1){
		$sql = "update `match_sports` set ShowTypeRB='$datainfo[7]',M_LetB_RB='$datainfo[8]',MB_LetB_Rate_RB='$datainfo[9]',TG_LetB_Rate_RB='$datainfo[10]',MB_Dime_RB='$datainfo[11]',TG_Dime_RB='$datainfo[12]',MB_Dime_Rate_RB='$datainfo[14]',TG_Dime_Rate_RB='$datainfo[13]',ShowTypeHRB='$datainfo[21]',M_LetB_RB_H='$datainfo[22]',MB_LetB_Rate_RB_H='$datainfo[23]',TG_LetB_Rate_RB_H='$datainfo[24]',MB_Dime_RB_H='$datainfo[25]',TG_Dime_RB_H='$datainfo[26]',MB_Dime_Rate_RB_H='$datainfo[28]',TG_Dime_Rate_RB_H='$datainfo[27]',MB_Ball='$datainfo[18]',TG_Ball='$datainfo[19]',MB_Card='$datainfo[29]',TG_Card='$datainfo[30]',MB_Red='$datainfo[31]',TG_Red='$datainfo[32]',MB_Win_Rate_RB='$datainfo[33]',TG_Win_Rate_RB='$datainfo[34]',M_Flat_Rate_RB='$datainfo[35]',MB_Win_Rate_RB_H='$datainfo[36]',TG_Win_Rate_RB_H='$datainfo[37]',M_Flat_Rate_RB_H='$datainfo[38]',Eventid='$datainfo[39]',Hot='$datainfo[40]',Play='$datainfo[41]',RB_Show=1,S_Show=0 where MID=$datainfo[0] and `Type`='FT'";
		//echo $sql;
		mysql_db_query($dbname,$sql) or die("error");	
		if ($datainfo[9]!=''){
			$datainfo[9]=change_rate($open,$datainfo[9]);
			$datainfo[10]=change_rate($open,$datainfo[10]);
		}
		if ($datainfo[13]!=''){
			$datainfo[13]=change_rate($open,$datainfo[13]);
			$datainfo[14]=change_rate($open,$datainfo[14]);
		}			
		if ($datainfo[23]!=''){
		    $datainfo[23]=change_rate($open,$datainfo[23]);
			$datainfo[24]=change_rate($open,$datainfo[24]);
		}
		if ($datainfo[28]!=''){
		    $datainfo[28]=change_rate($open,$datainfo[28]);
			$datainfo[27]=change_rate($open,$datainfo[27]);
		}
		$datainfo[19]=$datainfo[19]+0;
		$datainfo[18]=$datainfo[18]+0;			
		echo "parent.GameFT[$K]=new Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]','$datainfo[38]','$datainfo[39]','$datainfo[40]','$datainfo[41]','$datainfo[42]');\n";
		$K=$K+1;
		
		if ($gmid==''){
			$gmid=$datainfo[0];
		}else{
			$gmid=$gmid.','.$datainfo[0];
		}
		}
	}
	$sql="update `match_sports` set RB_Show=0 where RB_Show=1 and locate(MID,'$gmid')<1";
	mysql_db_query($dbname,$sql) or die ("abc!");
	break;
case "pd":
	$mysql = "select MID,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,UP5,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowTypeR from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date` ='$m_date' and PD_Show=1 and `MB2TG1`!=0 and $mb_team!='' and `Open`=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		echo "parent.GameFT[$K]=new Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[UP5]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]');\n";
		$K=$K+1;	
	}
	break;
case "hpd":
	$mysql = "select MID,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB1TG0H,MB2TG0H,MB2TG1H,MB3TG0H,MB3TG1H,MB3TG2H,MB4TG0H,MB4TG1H,MB4TG2H,MB4TG3H,MB0TG0H,MB1TG1H,MB2TG2H,MB3TG3H,MB4TG4H,UP5H,MB0TG1H,MB0TG2H,MB1TG2H,MB0TG3H,MB1TG3H,MB2TG3H,MB0TG4H,MB1TG4H,MB2TG4H,MB3TG4H,ShowTypeR from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date`='$m_date' and `HPD_Show`=1 and `MB2TG1H`!=0 and $mb_team!='' and `Open`=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		echo "parent.GameFT[$K]=new Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[TG_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[ShowTypeR]','$row[MB1TG0H]','$row[MB2TG0H]','$row[MB2TG1H]','$row[MB3TG0H]','$row[MB3TG1H]','$row[MB3TG2H]','$row[MB4TG0H]','$row[MB4TG1H]','$row[MB4TG2H]','$row[MB4TG3H]','$row[MB0TG0H]','$row[MB1TG1H]','$row[MB2TG2H]','$row[MB3TG3H]','$row[MB4TG4H]','$row[UP5H]','$row[MB0TG1H]','$row[MB0TG2H]','$row[MB1TG2H]','$row[MB0TG3H]','$row[MB1TG3H]','$row[MB2TG3H]','$row[MB0TG4H]','$row[MB1TG4H]','$row[MB2TG4H]','$row[MB3TG4H]');\n";
		$K=$K+1;	
	}
	break;
case "t":
	$mysql = "select MID,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate,TG_Win_Rate,M_Flat_Rate,S_0_1,S_2_3,S_4_6,S_7UP,MB_MID,TG_MID,ShowTypeR from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date` ='$m_date' and `T_Show`=1 and `Open`=1 order by M_Start,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);	
	echo "parent.retime=0;\n";
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
	    $MB_Win_Rate=num_rate($open,$row["MB_Win_Rate"]);
		$TG_Win_Rate=num_rate($open,$row["TG_Win_Rate"]);
		$M_Flat_Rate=num_rate($open,$row["M_Flat_Rate"]);
		echo "parent.GameFT[$K]=new Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','0','0','$row[S_0_1]','$row[S_2_3]','$row[S_4_6]','$row[S_7UP]','$MB_Win_Rate','$TG_Win_Rate','$M_Flat_Rate');\n";		
		$K=$K+1;	
	}
	break;	
case "f":
	$mysql = "select MID,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MBMB,MBFT,MBTG,FTMB,FTFT,FTTG,TGMB,TGFT,TGTG,MB_MID,TG_MID,ShowTypeR from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date` ='$m_date' and `F_Show`=1 and `Open`=1 order by M_Start,MB_MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
		echo "parent.GameFT[$K]=new Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[MBMB]','$row[MBFT]','$row[MBTG]','$row[FTMB]','$row[FTFT]','$row[FTTG]','$row[TGMB]','$row[TGFT]','$row[TGTG]','Y');\n";
		$K=$K+1;	
	}
	break;
case "p3":
	$mysql = "select MID,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_MID,TG_MID,ShowTypeP,MB_P_LetB_Rate,TG_P_LetB_Rate,M_P_LetB,MB_P_Dime,TG_P_Dime,MB_P_Dime_Rate,TG_P_Dime_Rate,S_P_Single_Rate,S_P_Double_Rate,MB_P_Win_Rate,TG_P_Win_Rate,M_P_Flat_Rate,ShowTypeHP,M_P_LetB_H,MB_P_LetB_Rate_H,TG_P_LetB_Rate_H,MB_P_Dime_H,TG_P_Dime_H,MB_P_Dime_Rate_H,TG_P_Dime_Rate_H,MB_P_Win_Rate_H,TG_P_Win_Rate_H,M_P_Flat_Rate_H,PD_Show,HPD_Show,T_Show,F_Show,P3_Show from `match_sports` where `Type`='FT' and `M_Start` > now( ) AND `M_Date`='$m_date' and `P3_Show`=1 and `Open`=1 order by M_Start,$mb_team,MB_MID";
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
	if ($row['PD_Show']==1 and $row['T_Show']==1 and $row['F_Show']==1){
		$show=3;
	}else if ($row['HPD_Show']==1 and $row['PD_Show']==1 and $row['T_Show']==1 and $row['F_Show']==1){
		$show=4;
	}else{
		$show=0;
	}
	if (strlen($row['M_Time'])==5){
		$pdate=$date.'<br>0'.$row[M_Time];
	}else{
		$pdate=$date.'<br>'.$row[M_Time];
	}
		echo "parent.GameFT[$K]=new Array('$row[MID]','$pdate','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeP]','$row[M_P_LetB]','$MB_P_LetB_Rate','$TG_P_LetB_Rate','$row[MB_P_Dime]','$row[TG_P_Dime]','$MB_P_Dime_Rate','$TG_P_Dime_Rate','$S_P_Single_Rate','$S_P_Double_Rate','$MB_P_Win_Rate','$TG_P_Win_Rate','$M_P_Flat_Rate','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[UP5]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]','','$row[S_0_1]','$row[S_2_3]','$row[S_4_6]','$row[S_7UP]','$row[MBMB]','$row[MBFT]','$row[MBTG]','$row[FTMB]','$row[FTFT]','$row[FTTG]','$row[TGMB]','$row[TGFT]','$row[TGTG]','0','$row[ShowTypeHP]','$row[M_P_LetB_H]','$MB_P_LetB_Rate_H','$TG_P_LetB_Rate_H','$row[MB_P_Dime_H]','$row[TG_P_Dime_H]','$TG_P_Dime_Rate_H','$MB_P_Dime_Rate_H','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','$MB_P_Win_Rate_H','$TG_P_Win_Rate_H','$M_P_Flat_Rate_H','$show');\n";
		$K=$K+1;	
	}
	break;
}
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
window.defaultStatus="Wellcome.................";
</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad();" onUnLoad="onUnLoad()">
	<img id=im0 width=0 height=0><img id=im1 width=0 height=0><img id=im2 width=0 height=0><img id=im3 width=0 height=0><img id=im4 width=0 height=0>
<img id=im5 width=0 height=0><img id=im6 width=0 height=0>
</body>
</html>
<?
}
mysql_close();
?>
