<?
session_start();
header("Expires: Mon, 26 Jul 1970 00:00:00 GMT");
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
$sql = "select UserName,Money,OpenType from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$open=$row['OpenType'];
$memname=$row['UserName'];
$credit=$row['Money'];

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
<HEAD>
<TITLE>篮球變數值</TITLE>
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
parent.rtype='<?=$rtype?>';
parent.sel_lid='<?=$league_id?>';
parent.langx='<?=$langx?>';
parent.g_date = 'ALL';
<?
switch ($rtype){
case "all":
	$mysql = "select MID,M_Date,M_Time,M_Type,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,TG_Dime,MB_Dime_Rate,TG_Dime_Rate,S_Single_Rate,S_Double_Rate,Eventid,Hot,Play from `match_sports` where Type='BU' and `M_Date` >'$m_date' and S_Show=1 and $mb_team!='' ".$date." order by M_Start,$mb_team,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;	
	$mysql=$mysql."  limit $offset,40;";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=180;\n";
	echo "parent.str_renew = '$second_auto_update';\n";
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);				
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);
		$S_Single_Rate=num_rate($open,$row['S_Single_Rate']);
		$S_Double_Rate=num_rate($open,$row['S_Double_Rate']);
		if ($S_Single_Rate==''){
		    $Single='';
		}else{
		    $Single=$o;
		}
		if ($S_Double_Rate==''){
		    $Double='';
		}else{
		    $Double=$e;		
		}
		$m_date=strtotime($row['M_Date']);
		$dates=date("m-d",$m_date);	
		if ($row['M_Type']==1){
			echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]<br><font color=red>Running Ball</font>','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$Single','$Double','$S_Single_Rate','$S_Double_Rate','0','$row[Eventid]','$row[Hot]','$row[Play]');\n";
		}else{
			echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$Single','$Double','$S_Single_Rate','$S_Double_Rate','0','$row[Eventid]','$row[Hot]','$row[Play]');\n";
		}
	$K=$K+1;	
	}
	break;
case "r":
	$mysql = "select MID,M_Date,M_Time,M_Type,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,TG_Dime,MB_Dime_Rate,TG_Dime_Rate,S_Single_Rate,S_Double_Rate,Eventid,Hot,Play from `match_sports` where Type='BU' and `M_Date` >'$m_date' and S_Show=1 and $mb_team!='' ".$date." order by M_Start,$mb_team,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;	
	$mysql=$mysql."  limit $offset,40;";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=180;\n";
	echo "parent.str_renew = '$second_auto_update';\n";
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);				
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);
		$S_Single_Rate=num_rate($open,$row['S_Single_Rate']);
		$S_Double_Rate=num_rate($open,$row['S_Double_Rate']);
		if ($S_Single_Rate==''){
		    $Single='';
		}else{
		    $Single=$o;
		}
		if ($S_Double_Rate==''){
		    $Double='';
		}else{
		    $Double=$e;		
		}
		$m_date=strtotime($row['M_Date']);
		$dates=date("m-d",$m_date);	
		if ($row['M_Type']==1){
			echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]<br><font color=red>Running Ball</font>','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$Single','$Double','$S_Single_Rate','$S_Double_Rate','0','$row[Eventid]','$row[Hot]','$row[Play]');\n";
		}else{
			echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$Single','$Double','$S_Single_Rate','$S_Double_Rate','0','$row[Eventid]','$row[Hot]','$row[Play]');\n";
		}
	$K=$K+1;	
	}
	break;
case "rq4":
	$mysql = "select MID,M_Date,M_Time,M_Type,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,TG_Dime,MB_Dime_Rate,TG_Dime_Rate,S_Single_Rate,S_Double_Rate,Eventid,Hot,Play from `match_sports` where Type='BU' and `M_Date` >'$m_date' and RQ_Show=1 and $mb_team!='' ".$date." order by M_Start,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;	
	$mysql=$mysql."  limit $offset,40;";
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=180;\n";	
	echo "parent.str_renew = '$second_auto_update';\n";
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	
	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);				
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);
		$S_Single_Rate=num_rate($open,$row['S_Single_Rate']);
		$S_Double_Rate=num_rate($open,$row['S_Double_Rate']);
		if ($S_Single_Rate==''){
		    $Single='';
		}else{
		    $Single=$o;
		}
		if ($S_Double_Rate==''){
		    $Double='';
		}else{
		    $Double=$e;		
		}
		$m_date=strtotime($row['M_Date']);
		$dates=date("m-d",$m_date);	
		if ($row['M_Type']==1){
			echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]<br><font color=red>Running Ball</font>','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$Single','$Double','$S_Single_Rate','$S_Double_Rate','0','$row[Eventid]','$row[Hot]','$row[Play]');\n";
		}else{
			echo "parent.GameFT[$K]= Array('$row[MID]','$dates<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$Single','$Double','$S_Single_Rate','$S_Double_Rate','0','$row[Eventid]','$row[Hot]','$row[Play]');\n";
		}
	$K=$K+1;	
	}
	break;
case "pr":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_MID,TG_MID,ShowTypeP,M_P_LetB,MB_P_LetB_Rate,TG_P_LetB_Rate,MB_P_Dime,TG_P_Dime,MB_P_Dime_Rate,TG_P_Dime_Rate from `match_sports` where Type='BU' and `M_Date` >'$m_date' and PR_Show=1 and $mb_team<>'' order by M_Start,MB_MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$MB_PR_LetB_Rate=change_rate($open,$row['MB_PR_LetB_Rate']);
		$TG_PR_LetB_Rate=change_rate($open,$row['TG_PR_LetB_Rate']);		
		$MB_PR_Dime_Rate=change_rate($open,$row["MB_PR_Dime_Rate"]);
		$TG_PR_Dime_Rate=change_rate($open,$row["TG_PR_Dime_Rate"]);
		$m_date=strtotime($row['M_Date']);
		$dates=date("m-d",$m_date);	

		$mb_team=trim($row['TG_Team']);		
		
		if (strlen($row['M_Time'])==5){
			$pdate=$dates.'<br>0'.$row[M_Time];
		}else{
			$pdate=$dates.'<br>'.$row[M_Time];
		}
		echo "parent.GameFT[$K]= Array('$row[MID]','$pdate','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeP]','$row[M_P_LetB]','$MB_P_LetB_Rate','$TG_P_LetB_Rate','$row[MB_P_Dime]','$row[TG_P_Dime]','$MB_P_Dime_Rate','$TG_P_Dime_Rate');\n";
		$K=$K+1;	
	}
	break;
}
mysql_close();
?>
//

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

