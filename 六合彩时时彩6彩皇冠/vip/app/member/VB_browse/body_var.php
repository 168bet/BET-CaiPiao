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
	echo "<script>window.open('$site/','_top')</script>";
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
<HEAD><TITLE>排球變數值</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<SCRIPT language=JavaScript>
<!--
if(self == top) location='/app/member/'
parent.flash_ior_set='Y';
parent.minlimit_VAR='';
parent.maxlimit_VAR='';
parent.username='<?=$memname?>';
parent.maxcredit='<?=$credit?>';
parent.code='人民币(RMB)';
parent.uid='<?=$uid?>';
parent.msg='<?=$mem_msg?>';
parent.ltype='3';
parent.str_even = '<?=$str_even?>';
parent.str_submit = '<?=$str_submit?>';
parent.str_reset = '<?=$str_reset?>';
parent.langx='<?=$langx?>';
parent.rtype='<?=$rtype?>';
parent.mtype='3';
parent.sel_lid='<?=$league_id?>';
<?php 
switch ($rtype){
case "r":
	$mysql = "select MID,M_Date,M_Time,M_Type,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_MID,TG_MID,ShowTypeR,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Win_Rate,TG_Win_Rate,MB_Dime_Rate,TG_Dime_Rate,MB_Dime,TG_Dime,S_Single_Rate,S_Double_Rate from `match_sports` where Type='VB' and `M_Start` > now( ) AND `M_Date` ='$m_date' and S_Show=1 and $mb_team!='' order by M_Start,$mb_team,MB_MID desc";	
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
	echo "parent.t_page=$page_count;\n";	
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
	    $MB_Win_Rate=num_rate($open,$row["MB_Win_Rate"]);
		$TG_Win_Rate=num_rate($open,$row["TG_Win_Rate"]);
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);				
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);
		$S_Single_Rate=num_rate($open,$row['S_Single_Rate']);
		$S_Double_Rate=num_rate($open,$row['S_Double_Rate']);
				
		if ($row['M_Type']==1){
			echo "parent.GameFT[$K]= Array('$row[MID]','$date<br>$row[M_Time]<br><font color=red>Running Ball</font>','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$MB_Win_Rate','$TG_Win_Rate','','$o','$e','$S_Single_Rate','$S_Double_Rate');\n";
		}else{
			echo "parent.GameFT[$K]= Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$MB_Win_Rate','$TG_Win_Rate','','$o','$e','$S_Single_Rate','$S_Double_Rate');\n";
		}
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
    $curl->set_referrer("".$site."/app/member/VB_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	$html_data=$curl->fetch_url("".$site."/app/member/VB_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=3");
	preg_match_all("/new Array\((.+?)\);/is",$html_data,$matches);
	$cou=sizeof($matches[0]);
	echo "parent.retime=60;\n";
	echo "parent.str_renew = '$second_auto_update';\n";
	echo "parent.t_page=0.6;\n";
	echo "parent.gamount=$cou;\n";
	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace("new Array(","",$messages);
	    $messages=str_replace(");","",$messages);
	    $messages=str_replace("'","",$messages);
	    $datainfo=explode(",",$messages);
		
		$opensql = "select * from `match_sports` where Type='VB' and  MID='$datainfo[0]'";
	    $openresult = mysql_db_query($dbname,$opensql);
	    $openrow=mysql_fetch_array($openresult);
		if($openrow['Open']==1){
		$sql = "update match_sports set ShowTypeRB='$datainfo[7]',M_LetB_RB='$datainfo[8]',MB_LetB_Rate_RB='$datainfo[9]',TG_LetB_Rate_RB='$datainfo[10]',MB_Dime_RB='$datainfo[11]',TG_Dime_RB='$datainfo[12]',TG_Dime_Rate='$datainfo[13]',MB_Dime_Rate_RB='$datainfo[14]',MB_Ball='$datainfo[18]',TG_Ball='$datainfo[19]',Eventid='$datainfo[31]',Hot='$datainfo[32]',Play='$datainfo[33]',RB_Show=1 where MID='$datainfo[0]' and Type='VB'";
		mysql_db_query($dbname,$sql) or die(error);
		
		if ($datainfo[9]<>''){
			$datainfo[9]=change_rate($open,$datainfo[9]);
			$datainfo[10]=change_rate($open,$datainfo[10]);
		}
		if ($datainfo[13]<>''){
			$datainfo[13]=change_rate($open,$datainfo[13]);
			$datainfo[14]=change_rate($open,$datainfo[14]);
		}
		$datainfo[19]=$datainfo[19]+0;
		$datainfo[18]=$datainfo[18]+0;		
		echo "parent.GameFT[$K]= new Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]');\n";
		$K=$K+1;
		}
	}
	break;
case "pd":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,ShowTypeR from `match_sports` where Type='VB' and `M_Start` > now( ) AND `M_Date` ='$m_date' and PD_Show=1 and MB2TG1!=0 and $mb_team<>'' order by M_Start,MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		echo "parent.GameFT[$K]= Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]');\n";
		$K=$K+1;	
	}
	break;
case "p":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_P_Win_Rate,TG_P_Win_Rate,MB_MID,TG_MID,ShowTypeP from `match_sports` where Type='VB' and `M_Start` > now( ) AND `M_Date` ='$m_date' and P_Show=1 and $mb_team<>'' order by M_Start,MID";	
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
	$mysql = "select MID,M_Date,M_Time,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeP,M_P_LetB,MB_P_LetB_Rate,TG_P_LetB_Rate,MB_P_Dime,TG_P_Dime,MB_P_Dime_Rate,TG_P_Dime_Rate from `match_sports` where Type='VB' and  `M_Start` > now( ) AND `M_Date` ='$m_date' and PR_Show=1 and $mb_team<>'' order by M_Start,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$MB_P_LetB_Rate=change_rate($open,$row['MB_P_LetB_Rate']);
		$TG_P_LetB_Rate=change_rate($open,$row['TG_P_LetB_Rate']);
		$MB_P_Dime_Rate=change_rate($open,$row['MB_P_Dime_Rate']);
	    $TG_P_Dime_Rate=change_rate($open,$row['TG_P_Dime_Rate']);		
		$mb_team=trim($row['MB_Team']);		
		
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
//
 function onLoad()
 {
  if(top.SI2_mem_index.mem_order.location == 'about:blank')
   top.SI2_mem_index.mem_order.location = '/app/member/select.php?uid=<?=$uid?>&langx=<?=$langx?>';
  if(parent.retime > 0)
   parent.retime_flag='Y';
  else
   parent.retime_flag='N';
  parent.loading_var = 'N';
  if(parent.loading == 'N' && parent.ShowType != '')
  {
   parent.ShowGameList();
   parent.body_browse.document.all.LoadLayer.style.display = 'none';
  }
 }
 
 function onUnLoad()
 {
  x = parent.body_browse.pageXOffset;
  y = parent.body_browse.pageYOffset;
  parent.body_browse.scroll(x,y);
  obj_layer = parent.body_browse.document.getElementById('LoadLayer');
  obj_layer.style.display = 'block';
 }
 
// -->
</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad()" onUnLoad="onUnLoad()">
</body>
</html>
