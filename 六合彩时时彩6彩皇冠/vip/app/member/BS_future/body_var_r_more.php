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
$gid   = $_REQUEST['gid'];
$langx=$_SESSION['langx'];
$uid   = $_REQUEST['uid'];
$ltype = $_REQUEST['ltype'];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
	
$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate,TG_Win_Rate,M_Flat_Rate,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H,MBPDH1,MBPDH2,MBPDH3,MBPDH4,MBPDH5,MBPDH6,MBPDH7,MBPDH8,MBPDH9,TGPDC1,TGPDC2,TGPDC3,TGPDC4,TGPDC5,TGPDC6,TGPDC7,TGPDC8,TGPDC9,S_1_2,S_3_4,S_5_6,S_7_8,S_9_10,S_11_12,S_13_14,S_15_16,S_17_18,S_19UP from `match_sports` where Type='BS' and MID='$gid'";
$result = mysql_db_query($dbname, $mysql);
$row=mysql_fetch_array($result);

?>
<HTML>
<HEAD>
<META http-equiv=Content-Type content=text/html; charset=utf-8>
<SCRIPT>
parent.GameOther = Array('<?=$row[MID]?>','<?=$m_date?>','<?=$row[M_League]?>','<?=$row[MB_MID]?>','<?=$row[TG_MID]?>','<?=$row[MB_Team]?>','<?=$row[TG_Team]?>','<?=$row[MB_Win_Rate]?>','<?=$row[TG_Win_Rate]?>','<?=$row[M_Flat_Rate]?>','<?=$row[MB_Win_Rate_H]?>','<?=$row[TG_Win_Rate_H]?>','<?=$row[M_Flat_Rate_H]?>','','','','','','<?=$row[MID]?>','<?=$row[MBPDH1]?>','<?=$row[MBPDH2]?>','<?=$row[MBPDH3]?>','<?=$row[MBPDH4]?>','<?=$row[MBPDH5]?>','<?=$row[MBPDH6]?>','<?=$row[MBPDH7]?>','<?=$row[MBPDH8]?>','<?=$row[MBPDH9]?>','<?=$row[TGPDC1]?>','<?=$row[TGPDC2]?>','<?=$row[TGPDC3]?>','<?=$row[TGPDC4]?>','<?=$row[TGPDC5]?>','<?=$row[TGPDC6]?>','<?=$row[TGPDC7]?>','<?=$row[TGPDC8]?>','<?=$row[TGPDC9]?>','<?=$row[S_1_2]?>','<?=$row[S_3_4]?>','<?=$row[S_5_6]?>','<?=$row[S_7_8]?>','<?=$row[S_9_10]?>','<?=$row[S_11_12]?>','<?=$row[S_13_14]?>','<?=$row[S_15_16]?>','<?=$row[S_17_18]?>','<?=$row[S_19UP]?>');
parent.show_detail();
</SCRIPT>
</HEAD>
</HTML>
