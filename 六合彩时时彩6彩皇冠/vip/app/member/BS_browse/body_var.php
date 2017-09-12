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
if ($page_no==''){
    $page_no=0;
}
$m_date=date('Y-m-d');
$date=date('m-d');
$K=0;
?>
<HEAD>
<TITLE>棒球變數值</TITLE>
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
<?php 
switch ($rtype){
case "r":
	$mysql="select MID,M_Date,M_Time,M_Type,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,TG_Dime,MB_Dime_Rate,TG_Dime_Rate,MB_Win_Rate,TG_Win_Rate,M_Flat_Rate,S_Single_Rate,S_Double_Rate,ShowTypeHR,M_LetB_H,MB_LetB_Rate_H,TG_LetB_Rate_H,MB_Dime_Rate_H,TG_Dime_Rate_H,MB_Dime_H,TG_Dime_H,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H,PD_Show,T_Show,Eventid,Hot,Play from `match_sports` where Type='BS' and `M_Start` > now() AND `M_Date` ='$m_date' and S_Show=1 and $mb_team!='' and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
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
		
		$MB_Win_Rate_hr=num_rate($open,$row["MB_Win_Rate_H"]);
		$TG_Win_Rate_hr=num_rate($open,$row["TG_Win_Rate_H"]);
		$M_Flat_Rate_hr=num_rate($open,$row["M_Flat_Rate_H"]);
		$MB_LetB_Rate_hr=change_rate($open,$row['MB_LetB_Rate_H']);
		$TG_LetB_Rate_hr=change_rate($open,$row['TG_LetB_Rate_H']);
		$MB_Dime_Rate_hr=change_rate($open,$row["MB_Dime_Rate_H"]);
		$TG_Dime_Rate_hr=change_rate($open,$row["TG_Dime_Rate_H"]);	
		
		if ($row['PD_Show']==1 and $row['T_Show']==1){
		    $show=2;
		}else{
		    $show=0;
		}
		if ($row['M_Type']==1){
			$Running="<br><font color=red>Running Ball</font>";
		}else{
			$Running="";
		}
		echo "parent.GameFT[$K]=new Array('$row[MID]','$date<br>$row[M_Time]$Running','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$MB_Win_Rate','$TG_Win_Rate','$M_Flat_Rate','$o','$e','$S_Single_Rate','$S_Double_Rate','$row[MID]','$row[ShowTypeHR]','$row[M_LetB_H]','$MB_LetB_Rate_hr','$TG_LetB_Rate_hr','$row[MB_Dime_H]','$row[TG_Dime_H]','$TG_Dime_Rate_hr','$MB_Dime_Rate_hr','$MB_Win_Rate_hr','$TG_Win_Rate_hr','$M_Flat_Rate_hr','$show','$row[Eventid]','$row[Hot]','$row[Play]');\n";
	$K=$K+1;	
	}
	break;
case "hr":
	$mysql = "select MID,M_Date,M_Time,M_Type,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeHR,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H,M_LetB_H,MB_LetB_Rate_H,TG_LetB_Rate_H,MB_Dime_H,TG_Dime_H,MB_Dime_Rate_H,TG_Dime_Rate_H,MB_MID,TG_MID from `match_sports` where Type='BS' and `M_Start` > now() AND `M_Date` ='$m_date' and $mb_team<>'' and H_Show=1  and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.str_renew = '$manual_update';\n";
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
	    $MB_Win_Rate_H=num_rate($open,$row["MB_Win_Rate_H"]);
		$TG_Win_Rate_H=num_rate($open,$row["TG_Win_Rate_H"]);
		$M_Flat_Rate_H=num_rate($open,$row["M_Flat_Rate_H"]);
		$MB_Dime_Rate_v=change_rate($open,$row["MB_Dime_Rate_H"]);
		$TG_Dime_Rate_v=change_rate($open,$row["TG_Dime_Rate_H"]);				
		$MB_LetB_Rate_v=change_rate($open,$row['MB_LetB_Rate_H']);
		$TG_LetB_Rate_v=change_rate($open,$row['TG_LetB_Rate_H']);
		if ($row['M_Type']==1){
			$Running="<br><font color=red>Running Ball</font>";
		}else{
			$Running="";
		}
		echo "parent.GameFT[$K]= Array('$row[MID]','$date<br>$row[M_Time]$Running','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[TG_Team]<font color=gray> - [$Order_1st_Half]</font>','$row[ShowTypeHR]','$row[M_LetB_H]','$MB_LetB_Rate_v','$TG_LetB_Rate_v','$row[MB_Dime_H]','$row[TG_Dime_H]','$TG_Dime_Rate_v','$MB_Dime_Rate_v','$MB_Win_Rate_H','$TG_Win_Rate_H','$M_Flat_Rate_H');\n";
		
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
    $curl->set_referrer("".$site."/app/member/BS_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/BS_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	preg_match_all("/new Array\((.+?)\);/is",$html_data,$matches);	
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
				
		$opensql = "select * from `match_sports` where Type='BS' and  MID='$datainfo[0]'";
		//echo $opensql;
	    $openresult = mysql_db_query($dbname,$opensql);
	    $openrow=mysql_fetch_array($openresult);
		if($openrow['Open']==1){
		$sql = "update match_sports set ShowTypeRB='$datainfo[7]',M_LetB_RB='$datainfo[8]',MB_LetB_Rate_RB='$datainfo[9]',TG_LetB_Rate_RB='$datainfo[10]',MB_Dime_RB='$datainfo[11]',TG_Dime_RB='$datainfo[12]',MB_Dime_Rate_RB='$datainfo[14]',TG_Dime_Rate_RB='$datainfo[13]',MB_Ball='$datainfo[18]',TG_Ball='$datainfo[19]',MB_Red='$datainfo[29]',TG_Red='$datainfo[30]',Eventid='$datainfo[31]',Hot='$datainfo[32]',Play='$datainfo[33]',RB_Show=1,S_Show=0 where MID=$datainfo[0] and Type='BS'";
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
		$datainfo[19]=$datainfo[19]+0;
		$datainfo[18]=$datainfo[18]+0;			
		echo "parent.GameFT[$K]=new Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]');\n";
		$K=$K+1;
		
		if ($gmid==''){
			$gmid=$datainfo[0];
		}else{
			$gmid=$gmid.','.$datainfo[0];
		}
		}
	}
	$sql="update match_sports set RB_Show=0 where RB_Show=1 and locate(MID,'$gmid')<1";
	mysql_db_query($dbname,$sql) or die ("巨ア毖!");
	break;
case "pd":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,MB_MID,TG_MID,MBPDH1,MBPDH2,MBPDH3,MBPDH4,MBPDH5,MBPDH6,MBPDH7,MBPDH8,MBPDH9,TGPDC1,TGPDC2,TGPDC3,TGPDC4,TGPDC5,TGPDC6,TGPDC7,TGPDC8,TGPDC9 from `match_sports` where Type='BS' and `M_Start` > now( ) AND `M_Date` ='$m_date' and PD_Show=1 and MBPDH1!=0 and $mb_team<>''  and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		echo "parent.GameFT[$K]= Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[MBPDH1]','$row[MBPDH2]','$row[MBPDH3]','$row[MBPDH4]','$row[MBPDH5]','$row[MBPDH6]','$row[MBPDH7]','$row[MBPDH8]','$row[MBPDH9]','$row[TGPDC1]','$row[TGPDC2]','$row[TGPDC3]','$row[TGPDC4]','$row[TGPDC5]','$row[TGPDC6]','$row[TGPDC7]','$row[TGPDC8]','$row[TGPDC9]');\n";
		$K=$K+1;	
	}
	break;		
case "t":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate,TG_Win_Rate,S_1_2,S_3_4,S_5_6,S_7_8,S_9_10,S_11_12,S_13_14,S_15_16,S_17_18,S_19UP,MB_MID,TG_MID,ShowTypeR from `match_sports` where Type='BS' and `M_Start` > now() AND `M_Date` ='$m_date' and T_Show=1 and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;
	$mysql=$mysql."  limit $offset,$num";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$MB_Win_Rate=num_rate($open,$row['MB_Win_Rate']);
		$TG_Win_Rate=num_rate($open,$row['TG_Win_Rate']);
		echo "parent.GameFT[$K]= Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','','','$row[S_1_2]','$row[S_3_4]','$row[S_5_6]','$row[S_7_8]','$row[S_9_10]','$row[S_11_12]','$row[S_13_14]','$row[S_15_16]','$row[S_17_18]','$row[S_19UP]','$MB_Win_Rate','$TG_Win_Rate','');\n";		
		$K=$K+1;	
	}
	break;
case "p":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeP,MB_P_Win_Rate,TG_P_Win_Rate,MB_MID,TG_MID from `match_sports` where Type='BS' and  `M_Start` > now() AND `M_Date` ='$m_date' and P_Show=1 and $mb_team<>'' and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
	    $MB_P_Win_Rate=num_rate($open,$row['MB_P_Win_Rate']);
		$TG_P_Win_Rate=num_rate($open,$row['TG_P_Win_Rate']);
		$mb_team=str_replace("[$bzmb]","",$row['MB_Team']);
		if (strlen(ltrim($row['M_Time']))<=5){
			$pdate=$date.'<br>0'.$row[M_Time];
		}else{
			$pdate=$date.'<br>'.$row[M_Time];
		}
		echo "parent.GameFT[$K]= Array('$row[MID]','$pdate','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$mb_team','$row[TG_Team]','$row[ShowTypeP]','$MB_P_Win_Rate','$TG_P_Win_Rate','');\n";
		$K=$K+1;	
	}
	break;
case "pr":
	$mysql = "select MID,M_Date,M_Time,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeP,M_P_LetB,MB_P_LetB_Rate,TG_P_LetB_Rate,MB_P_Dime,TG_P_Dime,MB_P_Dime_Rate,TG_P_Dime_Rate from `match_sports` where Type='BS' and `M_Start` > now() AND `M_Date` ='$m_date' and PR_Show=1 and $mb_team<>'' and Open=1 order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
	$MB_P_LetB_Rate=change_rate($open,$row['MB_P_LetB_Rate']);
	$TG_P_LetB_Rate=change_rate($open,$row['TG_P_LetB_Rate']);
	$MB_P_Dime_Rate=change_rate($open,$row['MB_P_Dime_Rate']);
	$TG_P_Dime_Rate=change_rate($open,$row['TG_P_Dime_Rate']);		
		
	if (strlen($row['M_Time'])==5){
		$pdate=$date.'<br>0'.$row[M_Time];
	}else{
		$pdate=$date.'<br>'.$row[M_Time];
	}
		echo "parent.GameFT[$K]= Array('$row[MID]','$pdate','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeP]','$row[M_P_LetB]','$MB_P_LetB_Rate','$TG_P_LetB_Rate','$row[MB_P_Dime]','$row[TG_P_Dime]','$MB_P_Dime_Rate','$TG_P_Dime_Rate');\n";
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
	parent.body_browse.document.getElementById('download').title='DownLoad 161';
}
// -->
window.defaultStatus="Wellcome................."
</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad();" onUnLoad="onUnLoad()">
	<img id=im0 width=0 height=0><img id=im1 width=0 height=0><img id=im2 width=0 height=0><img id=im3 width=0 height=0><img id=im4 width=0 height=0>
<img id=im5 width=0 height=0><img id=im6 width=0 height=0>
</body>
</html>
