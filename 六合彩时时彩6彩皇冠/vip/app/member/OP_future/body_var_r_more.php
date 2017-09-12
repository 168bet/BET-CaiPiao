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
$uid   = $_REQUEST['uid'];
$langx=$_SESSION['langx'];
$gid   = $_REQUEST['gid'];
$ltype = $_REQUEST['ltype'];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
	
$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate,TG_Win_Rate,M_Flat_Rate,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H,MB_MID,TG_MID,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,UP5,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,S_0_1,S_2_3,S_4_6,S_7UP,MBMB,MBFT,MBTG,FTMB,FTFT,FTTG,TGMB,TGFT,TGTG,MB1TG0H,MB2TG0H,MB2TG1H,MB3TG0H,MB3TG1H,MB3TG2H,MB4TG0H,MB4TG1H,MB4TG2H,MB4TG3H,MB0TG0H,MB1TG1H,MB2TG2H,MB3TG3H,MB4TG4H,UP5H,MB0TG1H,MB0TG2H,MB1TG2H,MB0TG3H,MB1TG3H,MB2TG3H,MB0TG4H,MB1TG4H,MB2TG4H,MB3TG4H from `match_sports` where Type='OP' and MID='$gid'";
$result = mysql_db_query($dbname, $mysql);
$row=mysql_fetch_array($result);
?>
<HTML>
<HEAD>
<META http-equiv=Content-Type content=text/html; charset=utf-8>
<SCRIPT>
parent.GameOther = Array('<?=$row[MID]?>','<?=$m_date?>','<?=$row[M_League]?>','<?=$row[MB_MID]?>','<?=$row[TG_MID]?>','<?=$row[MB_Team]?>','<?=$row[TG_Team]?>','<?=$row[MB_Win_Rate]?>','<?=$row[TG_Win_Rate]?>','<?=$row[M_Flat_Rate]?>','<?=$row[MB_Win_Rate_H]?>','<?=$row[TG_Win_Rate_H]?>','<?=$row[M_Flat_Rate_H]?>','','','','','','<?=$row[MID]?>','<?=$row[MB1TG0]?>','<?=$row[MB2TG0]?>','<?=$row[MB2TG1]?>','<?=$row[MB3TG0]?>','<?=$row[MB3TG1]?>','<?=$row[MB3TG2]?>','<?=$row[MB4TG0]?>','<?=$row[MB4TG1]?>','<?=$row[MB4TG2]?>','<?=$row[MB4TG3]?>','<?=$row[MB0TG0]?>','<?=$row[MB1TG1]?>','<?=$row[MB2TG2]?>','<?=$row[MB3TG3]?>','<?=$row[MB4TG4]?>','<?=$row[UP5]?>','<?=$row[MB0TG1]?>','<?=$row[MB0TG2]?>','<?=$row[MB1TG2]?>','<?=$row[MB0TG3]?>','<?=$row[MB1TG3]?>','<?=$row[MB2TG3]?>','<?=$row[MB0TG4]?>','<?=$row[MB1TG4]?>','<?=$row[MB2TG4]?>','<?=$row[MB3TG4]?>','','<?=$row[S_0_1]?>','<?=$row[S_2_3]?>','<?=$row[S_4_6]?>','<?=$row[S_7UP]?>','<?=$row[MBMB]?>','<?=$row[MBFT]?>','<?=$row[MBTG]?>','<?=$row[FTMB]?>','<?=$row[FTFT]?>','<?=$row[FTTG]?>','<?=$row[TGMB]?>','<?=$row[TGFT]?>','<?=$row[TGTG]?>','<?=$row[MB1TG0H]?>','<?=$row[MB2TG0H]?>','<?=$row[MB2TG1H]?>','<?=$row[MB3TG0H]?>','<?=$row[MB3TG1H]?>','<?=$row[MB3TG2H]?>','<?=$row[MB4TG0H]?>','<?=$row[MB4TG1H]?>','<?=$row[MB4TG2H]?>','<?=$row[MB4TG3H]?>','<?=$row[MB0TG0H]?>','<?=$row[MB1TG1H]?>','<?=$row[MB2TG2H]?>','<?=$row[MB3TG3H]?>','<?=$row[MB4TG4H]?>','<?=$row[UP5H]?>','<?=$row[MB0TG1H]?>','<?=$row[MB0TG2H]?>','<?=$row[MB1TG2H]?>','<?=$row[MB0TG3H]?>','<?=$row[MB1TG3H]?>','<?=$row[MB2TG3H]?>','<?=$row[MB0TG4H]?>','<?=$row[MB1TG4H]?>','<?=$row[MB2TG4H]?>','<?=$row[MB3TG4H]?>');
parent.show_detail();
</SCRIPT>
</HEAD>
</HTML>
