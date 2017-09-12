<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../../agents/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");
require ("../../agents/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];
include ("../../agents/include/online.php");
require ("../../agents/include/traditional.$langx.inc.php");

$sql = "select website,Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$web='web_system_data';
}else{
	$web='web_agents_data';
}
$sql = "select * from $web where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')<\/script>";
	exit;
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$passw=$row['Level'];
$curtype=$row['CurType'];
$name=$row['UserName'];
$admin=$row['Admin'];
switch ($lv){
case 'A':
    $Title=$Mem_Super;
	$Caption=$Mem_Manager;
	$level='M';
	$data='web_system_data';
	$agents="UserName='$name'";
	break;
case 'B':
    $Title=$Mem_Corprator;
	$Caption=$Mem_Super;
	$level='A';
	$data='web_agents_data';
	$agents="(UserName='$name' or Admin='$name' or Super='$name' or Corprator='$name' or World='$name') and subuser=0";
	break;
case 'C':
    $Title=$Mem_World;
	$Caption=$Mem_Corprator;
	$level='B';
	$data='web_agents_data';
	$agents="(UserName='$name' or Admin='$name' or Super='$name' or Corprator='$name' or World='$name') and subuser=0";
	break;
case 'D':
    $Title=$Mem_Agents;
	$Caption=$Mem_World;
	$level='C';
	$data='web_agents_data';
	$agents="(UserName='$name' or Admin='$name' or Super='$name' or Corprator='$name' or World='$name') and subuser=0";
	break;
}
$loginfo='新增'.$Title.'';
$parents_id=$_REQUEST['parents_id'];
if ($parents_id!=''){
$loginfo='选择'.$Title.'上线'.$Caption.':'.$parents_id.'';
$sql = "select * from $data where UserName='$parents_id'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);

$Winloss_A=$row['A_Point'];
$Winloss_B=$row['B_Point'];
$Winloss_C=$row['C_Point'];
$Winloss_D=$row['D_Point'];
/*
$abcd=100-$Winloss_D-$Winloss_C-$Winloss_B;
if ($abcd>80){
	$abcd=80;
}
*/
if ($lv=='B'){
	$abcd=100;
}else if($lv=='D'){
	$abcd=80;
}
$sports=$row['Sports'];
$lottery=$row['Lottery'];
$world=$row['World'];
$corprator=$row['Corprator'];
$super=$row['Super'];
$admin=$row['Admin'];
$linetype=$row['LineType'];
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~足球
$FT_Turn_R_A=$row['FT_Turn_R_A'];
$FT_Turn_R_B=$row['FT_Turn_R_B'];
$FT_Turn_R_C=$row['FT_Turn_R_C'];
$FT_Turn_R_D=$row['FT_Turn_R_D'];
$FT_R_Bet=$row['FT_R_Bet'];
$FT_R_Scene=$row['FT_R_Scene'];
$FT_Turn_OU_A=$row['FT_Turn_OU_A'];
$FT_Turn_OU_B=$row['FT_Turn_OU_B'];
$FT_Turn_OU_C=$row['FT_Turn_OU_C'];
$FT_Turn_OU_D=$row['FT_Turn_OU_D'];
$FT_OU_Bet=$row['FT_OU_Bet'];
$FT_OU_Scene=$row['FT_OU_Scene'];
$FT_Turn_RE_A=$row['FT_Turn_RE_A'];
$FT_Turn_RE_B=$row['FT_Turn_RE_B'];
$FT_Turn_RE_C=$row['FT_Turn_RE_C'];
$FT_Turn_RE_D=$row['FT_Turn_RE_D'];
$FT_RE_Bet=$row['FT_RE_Bet'];
$FT_RE_Scene=$row['FT_RE_Scene'];
$FT_Turn_ROU_A=$row['FT_Turn_ROU_A'];
$FT_Turn_ROU_B=$row['FT_Turn_ROU_B'];
$FT_Turn_ROU_C=$row['FT_Turn_ROU_C'];
$FT_Turn_ROU_D=$row['FT_Turn_ROU_D'];
$FT_ROU_Bet=$row['FT_ROU_Bet'];
$FT_ROU_Scene=$row['FT_ROU_Scene'];
$FT_Turn_EO_A=$row['FT_Turn_EO_A'];
$FT_Turn_EO_B=$row['FT_Turn_EO_B'];
$FT_Turn_EO_C=$row['FT_Turn_EO_C'];
$FT_Turn_EO_D=$row['FT_Turn_EO_D'];
$FT_EO_Bet=$row['FT_EO_Bet'];
$FT_EO_Scene=$row['FT_EO_Scene'];
$FT_Turn_RM=$row['FT_Turn_RM'];
$FT_RM_Bet=$row['FT_RM_Bet'];
$FT_RM_Scene=$row['FT_RM_Scene'];
$FT_Turn_M=$row['FT_Turn_M'];
$FT_M_Bet=$row['FT_M_Bet'];
$FT_M_Scene=$row['FT_M_Scene'];
$FT_Turn_PD=$row['FT_Turn_PD'];
$FT_PD_Bet=$row['FT_PD_Bet'];
$FT_PD_Scene=$row['FT_PD_Scene'];
$FT_Turn_T=$row['FT_Turn_T'];
$FT_T_Bet=$row['FT_T_Bet'];
$FT_T_Scene=$row['FT_T_Scene'];
$FT_Turn_F=$row['FT_Turn_F'];
$FT_F_Bet=$row['FT_F_Bet'];
$FT_F_Scene=$row['FT_F_Scene'];
$FT_Turn_P=$row['FT_Turn_P'];
$FT_P_Bet=$row['FT_P_Bet'];
$FT_P_Scene=$row['FT_P_Scene'];
$FT_Turn_PR=$row['FT_Turn_PR'];
$FT_PR_Bet=$row['FT_PR_Bet'];
$FT_PR_Scene=$row['FT_PR_Scene'];
$FT_Turn_P3=$row['FT_Turn_P3'];
$FT_P3_Bet=$row['FT_P3_Bet'];
$FT_P3_Scene=$row['FT_P3_Scene'];
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~篮球
$BK_Turn_R_A=$row['BK_Turn_R_A'];
$BK_Turn_R_B=$row['BK_Turn_R_B'];
$BK_Turn_R_C=$row['BK_Turn_R_C'];
$BK_Turn_R_D=$row['BK_Turn_R_D'];
$BK_R_Bet=$row['BK_R_Bet'];
$BK_R_Scene=$row['BK_R_Scene'];
$BK_Turn_OU_A=$row['BK_Turn_OU_A'];
$BK_Turn_OU_B=$row['BK_Turn_OU_B'];
$BK_Turn_OU_C=$row['BK_Turn_OU_C'];
$BK_Turn_OU_D=$row['BK_Turn_OU_D'];
$BK_OU_Bet=$row['BK_OU_Bet'];
$BK_OU_Scene=$row['BK_OU_Scene'];
$BK_Turn_RE_A=$row['BK_Turn_RE_A'];
$BK_Turn_RE_B=$row['BK_Turn_RE_B'];
$BK_Turn_RE_C=$row['BK_Turn_RE_C'];
$BK_Turn_RE_D=$row['BK_Turn_RE_D'];
$BK_RE_Bet=$row['BK_RE_Bet'];
$BK_RE_Scene=$row['BK_RE_Scene'];
$BK_Turn_ROU_A=$row['BK_Turn_ROU_A'];
$BK_Turn_ROU_B=$row['BK_Turn_ROU_B'];
$BK_Turn_ROU_C=$row['BK_Turn_ROU_C'];
$BK_Turn_ROU_D=$row['BK_Turn_ROU_D'];
$BK_ROU_Bet=$row['BK_ROU_Bet'];
$BK_ROU_Scene=$row['BK_ROU_Scene'];
$BK_Turn_EO_A=$row['BK_Turn_EO_A'];
$BK_Turn_EO_B=$row['BK_Turn_EO_B'];
$BK_Turn_EO_C=$row['BK_Turn_EO_C'];
$BK_Turn_EO_D=$row['BK_Turn_EO_D'];
$BK_EO_Bet=$row['BK_EO_Bet'];
$BK_EO_Scene=$row['BK_EO_Scene'];
$BK_Turn_PR=$row['BK_Turn_PR'];
$BK_PR_Bet=$row['BK_PR_Bet'];
$BK_PR_Scene=$row['BK_PR_Scene'];
$BK_Turn_P3=$row['BK_Turn_P3'];
$BK_P3_Bet=$row['BK_P3_Bet'];
$BK_P3_Scene=$row['BK_P3_Scene'];
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~冠军
$FS_Turn_FS=$row['FS_Turn_FS'];
$FS_FS_Scene=$row['FS_FS_Scene'];
$FS_FS_Bet=$row['FS_FS_Bet'];
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~棒球
$BS_Turn_R_A=$row['BS_Turn_R_A'];
$BS_Turn_R_B=$row['BS_Turn_R_B'];
$BS_Turn_R_C=$row['BS_Turn_R_C'];
$BS_Turn_R_D=$row['BS_Turn_R_D'];
$BS_R_Bet=$row['BS_R_Bet'];
$BS_R_Scene=$row['BS_R_Scene'];
$BS_Turn_OU_A=$row['BS_Turn_OU_A'];
$BS_Turn_OU_B=$row['BS_Turn_OU_B'];
$BS_Turn_OU_C=$row['BS_Turn_OU_C'];
$BS_Turn_OU_D=$row['BS_Turn_OU_D'];
$BS_OU_Bet=$row['BS_OU_Bet'];
$BS_OU_Scene=$row['BS_OU_Scene'];
$BS_Turn_RE_A=$row['BS_Turn_RE_A'];
$BS_Turn_RE_B=$row['BS_Turn_RE_B'];
$BS_Turn_RE_C=$row['BS_Turn_RE_C'];
$BS_Turn_RE_D=$row['BS_Turn_RE_D'];
$BS_RE_Bet=$row['BS_RE_Bet'];
$BS_RE_Scene=$row['BS_RE_Scene'];
$BS_Turn_ROU_A=$row['BS_Turn_ROU_A'];
$BS_Turn_ROU_B=$row['BS_Turn_ROU_B'];
$BS_Turn_ROU_C=$row['BS_Turn_ROU_C'];
$BS_Turn_ROU_D=$row['BS_Turn_ROU_D'];
$BS_ROU_Bet=$row['BS_ROU_Bet'];
$BS_ROU_Scene=$row['BS_ROU_Scene'];
$BS_Turn_EO_A=$row['BS_Turn_EO_A'];
$BS_Turn_EO_B=$row['BS_Turn_EO_B'];
$BS_Turn_EO_C=$row['BS_Turn_EO_C'];
$BS_Turn_EO_D=$row['BS_Turn_EO_D'];
$BS_EO_Bet=$row['BS_EO_Bet'];
$BS_EO_Scene=$row['BS_EO_Scene'];
$BS_Turn_1X2_A=$row['BS_Turn_1X2_A'];
$BS_Turn_1X2_B=$row['BS_Turn_1X2_B'];
$BS_Turn_1X2_C=$row['BS_Turn_1X2_C'];
$BS_Turn_1X2_D=$row['BS_Turn_1X2_D'];
$BS_1X2_Bet=$row['BS_1X2_Bet'];
$BS_1X2_Scene=$row['BS_1X2_Scene'];
$BS_Turn_PD=$row['BS_Turn_PD'];
$BS_PD_Scene=$row['BS_PD_Scene'];
$BS_PD_Bet=$row['BS_PD_Bet'];
$BS_Turn_T=$row['BS_Turn_T'];
$BS_T_Scene=$row['BS_T_Scene'];
$BS_T_Bet=$row['BS_T_Bet'];	
$BS_Turn_M=$row['BS_Turn_M'];
$BS_M_Scene=$row['BS_M_Scene'];
$BS_M_Bet=$row['BS_M_Bet'];
$BS_Turn_P=$row['BS_Turn_P'];
$BS_P_Scene=$row['BS_P_Scene'];
$BS_P_Bet=$row['BS_P_Bet'];
$BS_Turn_PR=$row['BS_Turn_PR'];
$BS_PR_Scene=$row['BS_PR_Scene'];
$BS_PR_Bet=$row['BS_PR_Bet'];
$BS_Turn_P3=$row['BS_Turn_P3'];
$BS_P3_Scene=$row['BS_P3_Scene'];
$BS_P3_Bet=$row['BS_P3_Bet'];
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~网球
$TN_Turn_R_A=$row['TN_Turn_R_A'];
$TN_Turn_R_B=$row['TN_Turn_R_B'];
$TN_Turn_R_C=$row['TN_Turn_R_C'];
$TN_Turn_R_D=$row['TN_Turn_R_D'];
$TN_R_Bet=$row['TN_R_Bet'];
$TN_R_Scene=$row['TN_R_Scene'];
$TN_Turn_OU_A=$row['TN_Turn_OU_A'];
$TN_Turn_OU_B=$row['TN_Turn_OU_B'];
$TN_Turn_OU_C=$row['TN_Turn_OU_C'];
$TN_Turn_OU_D=$row['TN_Turn_OU_D'];
$TN_OU_Bet=$row['TN_OU_Bet'];
$TN_OU_Scene=$row['TN_OU_Scene'];
$TN_EO_Scene=$row['TN_EO_Scene'];
$TN_M_Scene=$row['TN_M_Scene'];
$TN_PR_Scene=$row['TN_PR_Scene'];
$TN_P_Scene=$row['TN_P_Scene'];
$TN_PD_Scene=$row['TN_PD_Scene'];
$TN_T_Scene=$row['TN_T_Scene'];
$TN_F_Scene=$row['TN_F_Scene'];
$TN_Turn_RE_A=$row['TN_Turn_RE_A'];
$TN_Turn_RE_B=$row['TN_Turn_RE_B'];
$TN_Turn_RE_C=$row['TN_Turn_RE_C'];
$TN_Turn_RE_D=$row['TN_Turn_RE_D'];
$TN_RE_Bet=$row['TN_RE_Bet'];
$TN_RE_Scene=$row['TN_RE_Scene'];
$TN_Turn_ROU_A=$row['TN_Turn_ROU_A'];
$TN_Turn_ROU_B=$row['TN_Turn_ROU_B'];
$TN_Turn_ROU_C=$row['TN_Turn_ROU_C'];
$TN_Turn_ROU_D=$row['TN_Turn_ROU_D'];
$TN_ROU_Bet=$row['TN_ROU_Bet'];
$TN_ROU_Scene=$row['TN_ROU_Scene'];
$TN_Turn_EO_A=$row['TN_Turn_EO_A'];
$TN_Turn_EO_B=$row['TN_Turn_EO_B'];
$TN_Turn_EO_C=$row['TN_Turn_EO_C'];
$TN_Turn_EO_D=$row['TN_Turn_EO_D'];
$TN_EO_Bet=$row['TN_EO_Bet'];
$TN_EO_Scene=$row['TN_EO_Scene'];
$TN_Turn_M=$row['TN_Turn_M'];
$TN_M_Bet=$row['TN_M_Bet'];
$TN_M_Scene=$row['TN_M_Scene'];
$TN_Turn_PD=$row['TN_Turn_PD'];
$TN_PD_Bet=$row['TN_PD_Bet'];
$TN_PD_Scene=$row['TN_PD_Scene'];
$TN_Turn_P=$row['TN_Turn_P'];
$TN_P_Bet=$row['TN_P_Bet'];
$TN_P_Scene=$row['TN_P_Scene'];
$TN_Turn_PR=$row['TN_Turn_PR'];
$TN_PR_Bet=$row['TN_PR_Bet'];
$TN_PR_Scene=$row['TN_PR_Scene'];
$TN_Turn_P3=$row['TN_Turn_P3'];
$TN_P3_Bet=$row['TN_P3_Bet'];
$TN_P3_Scene=$row['TN_P3_Scene'];
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~排球
$VB_Turn_R_A=$row['VB_Turn_R_A'];
$VB_Turn_R_B=$row['VB_Turn_R_B'];
$VB_Turn_R_C=$row['VB_Turn_R_C'];
$VB_Turn_R_D=$row['VB_Turn_R_D'];
$VB_R_Bet=$row['VB_R_Bet'];
$VB_R_Scene=$row['VB_R_Scene'];
$VB_Turn_OU_A=$row['VB_Turn_OU_A'];
$VB_Turn_OU_B=$row['VB_Turn_OU_B'];
$VB_Turn_OU_C=$row['VB_Turn_OU_C'];
$VB_Turn_OU_D=$row['VB_Turn_OU_D'];
$VB_OU_Bet=$row['VB_OU_Bet'];
$VB_OU_Scene=$row['VB_OU_Scene'];
$VB_Turn_RE_A=$row['VB_Turn_RE_A'];
$VB_Turn_RE_B=$row['VB_Turn_RE_B'];
$VB_Turn_RE_C=$row['VB_Turn_RE_C'];
$VB_Turn_RE_D=$row['VB_Turn_RE_D'];
$VB_RE_Bet=$row['VB_RE_Bet'];
$VB_RE_Scene=$row['VB_RE_Scene'];
$VB_Turn_ROU_A=$row['VB_Turn_ROU_A'];
$VB_Turn_ROU_B=$row['VB_Turn_ROU_B'];
$VB_Turn_ROU_C=$row['VB_Turn_ROU_C'];
$VB_Turn_ROU_D=$row['VB_Turn_ROU_D'];
$VB_ROU_Bet=$row['VB_ROU_Bet'];
$VB_ROU_Scene=$row['VB_ROU_Scene'];
$VB_Turn_EO_A=$row['VB_Turn_EO_A'];
$VB_Turn_EO_B=$row['VB_Turn_EO_B'];
$VB_Turn_EO_C=$row['VB_Turn_EO_C'];
$VB_Turn_EO_D=$row['VB_Turn_EO_D'];
$VB_EO_Bet=$row['VB_EO_Bet'];
$VB_EO_Scene=$row['VB_EO_Scene'];
$VB_Turn_M=$row['VB_Turn_M'];
$VB_M_Bet=$row['VB_M_Bet'];
$VB_M_Scene=$row['VB_M_Scene'];
$VB_Turn_PD=$row['VB_Turn_PD'];
$VB_PD_Bet=$row['VB_PD_Bet'];
$VB_PD_Scene=$row['VB_PD_Scene'];
$VB_Turn_P=$row['VB_Turn_P'];
$VB_P_Bet=$row['VB_P_Bet'];
$VB_P_Scene=$row['VB_P_Scene'];
$VB_Turn_PR=$row['VB_Turn_PR'];
$VB_PR_Bet=$row['VB_PR_Bet'];
$VB_PR_Scene=$row['VB_PR_Scene'];
$VB_Turn_P3=$row['VB_Turn_P3'];
$VB_P3_Bet=$row['VB_P3_Bet'];
$VB_P3_Scene=$row['VB_P3_Scene'];
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~其它
$OP_Turn_R_A=$row['OP_Turn_R_A'];
$OP_Turn_R_B=$row['OP_Turn_R_B'];
$OP_Turn_R_C=$row['OP_Turn_R_C'];
$OP_Turn_R_D=$row['OP_Turn_R_D'];
$OP_R_Bet=$row['OP_R_Bet'];
$OP_R_Scene=$row['OP_R_Scene'];
$OP_Turn_OU_A=$row['OP_Turn_OU_A'];
$OP_Turn_OU_B=$row['OP_Turn_OU_B'];
$OP_Turn_OU_C=$row['OP_Turn_OU_C'];
$OP_Turn_OU_D=$row['OP_Turn_OU_D'];
$OP_OU_Bet=$row['OP_OU_Bet'];
$OP_OU_Scene=$row['OP_OU_Scene'];
$OP_Turn_RE_A=$row['OP_Turn_RE_A'];
$OP_Turn_RE_B=$row['OP_Turn_RE_B'];
$OP_Turn_RE_C=$row['OP_Turn_RE_C'];
$OP_Turn_RE_D=$row['OP_Turn_RE_D'];
$OP_RE_Bet=$row['OP_RE_Bet'];
$OP_RE_Scene=$row['OP_RE_Scene'];
$OP_Turn_ROU_A=$row['OP_Turn_ROU_A'];
$OP_Turn_ROU_B=$row['OP_Turn_ROU_B'];
$OP_Turn_ROU_C=$row['OP_Turn_ROU_C'];
$OP_Turn_ROU_D=$row['OP_Turn_ROU_D'];
$OP_ROU_Bet=$row['OP_ROU_Bet'];
$OP_ROU_Scene=$row['OP_ROU_Scene'];
$OP_Turn_EO_A=$row['OP_Turn_EO_A'];
$OP_Turn_EO_B=$row['OP_Turn_EO_B'];
$OP_Turn_EO_C=$row['OP_Turn_EO_C'];
$OP_Turn_EO_D=$row['OP_Turn_EO_D'];
$OP_EO_Bet=$row['OP_EO_Bet'];
$OP_EO_Scene=$row['OP_EO_Scene'];
$OP_Turn_M=$row['OP_Turn_M'];
$OP_M_Bet=$row['OP_M_Bet'];
$OP_M_Scene=$row['OP_M_Scene'];
$OP_Turn_PD=$row['OP_Turn_PD'];
$OP_PD_Bet=$row['OP_PD_Bet'];
$OP_PD_Scene=$row['OP_PD_Scene'];
$OP_Turn_T=$row['OP_Turn_T'];
$OP_T_Bet=$row['OP_T_Bet'];
$OP_T_Scene=$row['OP_T_Scene'];
$OP_Turn_F=$row['OP_Turn_F'];
$OP_F_Bet=$row['OP_F_Bet'];
$OP_F_Scene=$row['OP_F_Scene'];
$OP_Turn_P=$row['OP_Turn_P'];
$OP_P_Bet=$row['OP_P_Bet'];
$OP_P_Scene=$row['OP_P_Scene'];
$OP_Turn_PR=$row['OP_Turn_PR'];
$OP_PR_Bet=$row['OP_PR_Bet'];
$OP_PR_Scene=$row['OP_PR_Scene'];
$OP_Turn_P3=$row['OP_Turn_P3'];
$OP_P3_Bet=$row['OP_P3_Bet'];
$OP_P3_Scene=$row['OP_P3_Scene'];
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~六合彩
$SIX_Turn_SCA_A=$row['SIX_Turn_SCA_A'];
$SIX_Turn_SCA_B=$row['SIX_Turn_SCA_B'];
$SIX_Turn_SCA_C=$row['SIX_Turn_SCA_C'];
$SIX_Turn_SCA_D=$row['SIX_Turn_SCA_D'];
$SIX_SCA_Bet=$row['SIX_SCA_Bet'];
$SIX_SCA_Scene=$row['SIX_SCA_Scene'];
$SIX_Turn_SCB_A=$row['SIX_Turn_SCB_A'];
$SIX_Turn_SCB_B=$row['SIX_Turn_SCB_B'];
$SIX_Turn_SCB_C=$row['SIX_Turn_SCB_C'];
$SIX_Turn_SCB_D=$row['SIX_Turn_SCB_D'];
$SIX_SCB_Bet=$row['SIX_SCB_Bet'];
$SIX_SCB_Scene=$row['SIX_SCB_Scene'];
$SIX_Turn_SCA_AOUEO_A=$row['SIX_Turn_SCA_AOUEO_A'];
$SIX_Turn_SCA_AOUEO_B=$row['SIX_Turn_SCA_AOUEO_B'];
$SIX_Turn_SCA_AOUEO_C=$row['SIX_Turn_SCA_AOUEO_C'];
$SIX_Turn_SCA_AOUEO_D=$row['SIX_Turn_SCA_AOUEO_D'];
$SIX_SCA_AOUEO_Bet=$row['SIX_SCA_AOUEO_Bet'];
$SIX_SCA_AOUEO_Scene=$row['SIX_SCA_AOUEO_Scene'];
$SIX_Turn_SCA_BOUEO_A=$row['SIX_Turn_SCA_BOUEO_A'];
$SIX_Turn_SCA_BOUEO_B=$row['SIX_Turn_SCA_BOUEO_B'];
$SIX_Turn_SCA_BOUEO_C=$row['SIX_Turn_SCA_BOUEO_C'];
$SIX_Turn_SCA_BOUEO_D=$row['SIX_Turn_SCA_BOUEO_D'];
$SIX_SCA_BOUEO_Bet=$row['SIX_SCA_BOUEO_Bet'];
$SIX_SCA_BOUEO_Scene=$row['SIX_SCA_BOUEO_Scene'];
$SIX_Turn_SCA_RBG_A=$row['SIX_Turn_SCA_RBG_A'];
$SIX_Turn_SCA_RBG_B=$row['SIX_Turn_SCA_RBG_B'];
$SIX_Turn_SCA_RBG_C=$row['SIX_Turn_SCA_RBG_C'];
$SIX_Turn_SCA_RBG_D=$row['SIX_Turn_SCA_RBG_D'];
$SIX_SCA_RBG_Bet=$row['SIX_SCA_RBG_Bet'];
$SIX_SCA_RBG_Scene=$row['SIX_SCA_RBG_Scene'];
$SIX_Turn_AC_A=$row['SIX_Turn_AC_A'];
$SIX_Turn_AC_B=$row['SIX_Turn_AC_B'];
$SIX_Turn_AC_C=$row['SIX_Turn_AC_C'];
$SIX_Turn_AC_D=$row['SIX_Turn_AC_D'];
$SIX_AC_Bet=$row['SIX_AC_Bet'];
$SIX_AC_Scene=$row['SIX_AC_Scene'];
$SIX_Turn_AC_TOUEO_A=$row['SIX_Turn_AC_TOUEO_A'];
$SIX_Turn_AC_TOUEO_B=$row['SIX_Turn_AC_TOUEO_B'];
$SIX_Turn_AC_TOUEO_C=$row['SIX_Turn_AC_TOUEO_C'];
$SIX_Turn_AC_TOUEO_D=$row['SIX_Turn_AC_TOUEO_D'];
$SIX_AC_TOUEO_Bet=$row['SIX_AC_TOUEO_Bet'];
$SIX_AC_TOUEO_Scene=$row['SIX_AC_TOUEO_Scene'];
$SIX_Turn_AC6_AOUEO_A=$row['SIX_Turn_AC6_AOUEO_A'];
$SIX_Turn_AC6_AOUEO_B=$row['SIX_Turn_AC6_AOUEO_B'];
$SIX_Turn_AC6_AOUEO_C=$row['SIX_Turn_AC6_AOUEO_C'];
$SIX_Turn_AC6_AOUEO_D=$row['SIX_Turn_AC6_AOUEO_D'];
$SIX_AC6_AOUEO_Bet=$row['SIX_AC6_AOUEO_Bet'];
$SIX_AC6_AOUEO_Scene=$row['SIX_AC6_AOUEO_Scene'];
$SIX_Turn_AC6_BOUEO_A=$row['SIX_Turn_AC6_BOUEO_A'];
$SIX_Turn_AC6_BOUEO_B=$row['SIX_Turn_AC6_BOUEO_B'];
$SIX_Turn_AC6_BOUEO_C=$row['SIX_Turn_AC6_BOUEO_C'];
$SIX_Turn_AC6_BOUEO_D=$row['SIX_Turn_AC6_BOUEO_D'];
$SIX_AC6_BOUEO_Bet=$row['SIX_AC6_BOUEO_Bet'];
$SIX_AC6_BOUEO_Scene=$row['SIX_AC6_BOUEO_Scene'];
$SIX_Turn_AC6_RBG_A=$row['SIX_Turn_AC6_RBG_A'];
$SIX_Turn_AC6_RBG_B=$row['SIX_Turn_AC6_RBG_B'];
$SIX_Turn_AC6_RBG_C=$row['SIX_Turn_AC6_RBG_C'];
$SIX_Turn_AC6_RBG_D=$row['SIX_Turn_AC6_RBG_D'];
$SIX_AC6_RBG_Bet=$row['SIX_AC6_RBG_Bet'];
$SIX_AC6_RBG_Scene=$row['SIX_AC6_RBG_Scene'];
$SIX_Turn_SX_A=$row['SIX_Turn_SX_A'];
$SIX_Turn_SX_B=$row['SIX_Turn_SX_B'];
$SIX_Turn_SX_C=$row['SIX_Turn_SX_C'];
$SIX_Turn_SX_D=$row['SIX_Turn_SX_D'];
$SIX_SX_Bet=$row['SIX_SX_Bet'];
$SIX_SX_Scene=$row['SIX_SX_Scene'];
$SIX_Turn_HW_A=$row['SIX_Turn_HW_A'];
$SIX_Turn_HW_B=$row['SIX_Turn_HW_B'];
$SIX_Turn_HW_C=$row['SIX_Turn_HW_C'];
$SIX_Turn_HW_D=$row['SIX_Turn_HW_D'];
$SIX_HW_Bet=$row['SIX_HW_Bet'];
$SIX_HW_Scene=$row['SIX_HW_Scene'];
$SIX_Turn_MT_A=$row['SIX_Turn_MT_A'];
$SIX_Turn_MT_B=$row['SIX_Turn_MT_B'];
$SIX_Turn_MT_C=$row['SIX_Turn_MT_C'];
$SIX_Turn_MT_D=$row['SIX_Turn_MT_D'];
$SIX_MT_Bet=$row['SIX_MT_Bet'];
$SIX_MT_Scene=$row['SIX_MT_Scene'];
$SIX_Turn_M_A=$row['SIX_Turn_M_A'];
$SIX_Turn_M_B=$row['SIX_Turn_M_B'];
$SIX_Turn_M_C=$row['SIX_Turn_M_C'];
$SIX_Turn_M_D=$row['SIX_Turn_M_D'];
$SIX_M_Bet=$row['SIX_M_Bet'];
$SIX_M_Scene=$row['SIX_M_Scene'];
$SIX_Turn_EC_A=$row['SIX_Turn_EC_A'];
$SIX_Turn_EC_B=$row['SIX_Turn_EC_B'];
$SIX_Turn_EC_C=$row['SIX_Turn_EC_C'];
$SIX_Turn_EC_D=$row['SIX_Turn_EC_D'];
$SIX_EC_Bet=$row['SIX_EC_Bet'];
$SIX_EC_Scene=$row['SIX_EC_Scene'];
}

switch ($lv){
case 'A':
	$add='a';
	$user="Level='A' and Admin='$parents_id'";
	$competence='0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,1,1,1,1,1,1,1,';
	$agent="World='$world',Corprator='$corprator',Super='$super',Admin='$parents_id'";
	break;
case 'B':
	$add='b';
	$competence='0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,1,1,1,1,1,1,';
	$user="Level='B' and Super='$parents_id'";
	$agent="World='$world',Corprator='$corprator',Super='$parents_id',Admin='$admin'";
	break;
case 'C':
	$add='c';
	$competence='0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,1,1,1,0,1,';
	$user="Level='C' and Corprator='$parents_id'";
	$agent="World='$world',Corprator='$parents_id',Super='$super',Admin='$admin'";
	break;
case 'D':
	$add='d';
	$competence='0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,1,1,0,1,';
	$user="Level='D' and World='$parents_id'";
	$agent="World='$parents_id',Corprator='$corprator',Super='$super',Admin='$admin'";
	break;
}

$keys=$_REQUEST['keys'];
if ($keys=='add'){
	$AddDate=date('Y-m-d H:i:s');//新增日期
	$username=$_REQUEST['username'];//帐号
	$password=$_REQUEST['password'];//密码
	$maxcredit=$_REQUEST['maxcredit'];//总信用额度
	$wager=$_REQUEST['wager'];// 即时注单
	$CurType=$_REQUEST['CurType'];//币别
	$alias=$_REQUEST['alias'];//名称
	$usedate=$_REQUEST['usedate'];
	if ($lv=='B'){
	    $winloss_b=$_REQUEST['winloss_b'];
	}else if($lv=='D'){	
        $winloss_d=$_REQUEST['winloss_d'];
	    $winloss_c=$_REQUEST['winloss_c'];
	    $winloss_b=$Winloss_B-$winloss_d-$winloss_c;
	    $winloss_a=100-$winloss_d-$winloss_c-$winloss_b;
	}		
	$parents_id=$_REQUEST['parents_id'];
	if ($parents_id==''){
		echo wterror("帐号名称不能为空，请回上一面重新输入");
		exit();
	}
	
$mysql="select Credit from $data where UserName='$parents_id'";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$credit=$row['Credit'];
$points=$row['Points'];
$mysql="select sum(Credit) as credit from web_agents_data where $user";
$result = mysql_db_query($dbname,$mysql);	
$row = mysql_fetch_array($result);

	if ($row['credit']+$maxcredit>$credit){
		echo wterror("目前代理商 最大信用额度为".number_format($maxcredit,0)."<br>目前总代理商 最大信用额度为".number_format($credit,0)."<br>,所属代理商累计信用额度为".number_format($row[credit],0)."<br>已超过总代理商信用额度或储蓄点数，请回上一面重新输入！");
		$loginfo='新增'.$Title.'失败';
		$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$name',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
		mysql_db_query($dbname,$mysql);
		exit();
	}
	
$mysql="select * from web_agents_data where UserName='$username'";
$result = mysql_db_query($dbname,$mysql);
$count=mysql_num_rows($result);
    if ($count>0){
		echo wterror("您输入的帐号 $username 已经有人使用了，请回上一页重新输入");
    }else{
$sql="insert into web_agents_data set ";
$sql.="Level='".$lv."',";
$sql.="UserName='".$username."',";
$sql.="PassWord='".$password."',";
$sql.="Credit='".$maxcredit."',";
$sql.="Alias='".$alias."',";
$sql.="AddDate='".$AddDate."',";
$sql.="Status='0',";
//$sql.="CurType='".$curtype."',";
$sql.="LineType='".$linetype."',";
$sql.="wager='".$wager."',";
$sql.="Competence='".$competence."',";
$sql.="UseDate='".$usedate."',";
if($lv=='C'){
   $sql.="A_Point='".$Winloss_A."',";
   $sql.="B_Point='".$Winloss_B."',";
   $sql.="C_Point='".$Winloss_C."',";
   $sql.="D_Point='".$Winloss_D."',";
}else{
   $sql.="A_Point='".$winloss_a."',";
   $sql.="B_Point='".$winloss_b."',";
   $sql.="C_Point='".$winloss_c."',";
   $sql.="D_Point='".$winloss_d."',";
}
$sql.="$agent,";
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~足球
$sql.="FT_Turn_R_A='".$FT_Turn_R_A."',";
$sql.="FT_Turn_R_B='".$FT_Turn_R_B."',";
$sql.="FT_Turn_R_C='".$FT_Turn_R_C."',";
$sql.="FT_Turn_R_D='".$FT_Turn_R_D."',";
$sql.="FT_R_Bet='".$FT_R_Bet."',";
$sql.="FT_R_Scene='".$FT_R_Scene."',";
$sql.="FT_Turn_OU_A='".$FT_Turn_OU_A."',";
$sql.="FT_Turn_OU_B='".$FT_Turn_OU_B."',";
$sql.="FT_Turn_OU_C='".$FT_Turn_OU_C."',";
$sql.="FT_Turn_OU_D='".$FT_Turn_OU_D."',";
$sql.="FT_OU_Bet='".$FT_OU_Bet."',";
$sql.="FT_OU_Scene='".$FT_OU_Scene."',";
$sql.="FT_Turn_RE_A='".$FT_Turn_RE_A."',";
$sql.="FT_Turn_RE_B='".$FT_Turn_RE_B."',";
$sql.="FT_Turn_RE_C='".$FT_Turn_RE_C."',";
$sql.="FT_Turn_RE_D='".$FT_Turn_RE_D."',";
$sql.="FT_RE_Bet='".$FT_RE_Bet."',";
$sql.="FT_RE_Scene='".$FT_RE_Scene."',";
$sql.="FT_Turn_ROU_A='".$FT_Turn_ROU_A."',";
$sql.="FT_Turn_ROU_B='".$FT_Turn_ROU_B."',";
$sql.="FT_Turn_ROU_C='".$FT_Turn_ROU_C."',";
$sql.="FT_Turn_ROU_D='".$FT_Turn_ROU_D."',";
$sql.="FT_ROU_Bet='".$FT_ROU_Bet."',";
$sql.="FT_ROU_Scene='".$FT_ROU_Scene."',";
$sql.="FT_Turn_EO_A='".$FT_Turn_EO_A."',";
$sql.="FT_Turn_EO_B='".$FT_Turn_EO_B."',";
$sql.="FT_Turn_EO_C='".$FT_Turn_EO_C."',";
$sql.="FT_Turn_EO_D='".$FT_Turn_EO_D."',";
$sql.="FT_EO_Bet='".$FT_EO_Bet."',";
$sql.="FT_EO_Scene='".$FT_EO_Scene."',";
$sql.="FT_Turn_RM='".$FT_Turn_RM."',";
$sql.="FT_RM_Bet='".$FT_RM_Bet."',";
$sql.="FT_RM_Scene='".$FT_RM_Scene."',";
$sql.="FT_Turn_M='".$FT_Turn_M."',";
$sql.="FT_M_Bet='".$FT_M_Bet."',";
$sql.="FT_M_Scene='".$FT_M_Scene."',";
$sql.="FT_Turn_PD='".$FT_Turn_PD."',";
$sql.="FT_PD_Bet='".$FT_PD_Bet."',";
$sql.="FT_PD_Scene='".$FT_PD_Scene."',";
$sql.="FT_Turn_T='".$FT_Turn_T."',";
$sql.="FT_T_Bet='".$FT_T_Bet."',";
$sql.="FT_T_Scene='".$FT_T_Scene."',";
$sql.="FT_Turn_F='".$FT_Turn_F."',";
$sql.="FT_F_Bet='".$FT_F_Bet."',";
$sql.="FT_F_Scene='".$FT_F_Scene."',";
$sql.="FT_P_Bet='".$FT_P_Bet."',";
$sql.="FT_Turn_P='".$FT_Turn_P."',";
$sql.="FT_P_Scene='".$FT_P_Scene."',";
$sql.="FT_Turn_PR='".$FT_Turn_PR."',";
$sql.="FT_PR_Bet='".$FT_PR_Bet."',";
$sql.="FT_PR_Scene='".$FT_PR_Scene."',";
$sql.="FT_Turn_P3='".$FT_Turn_P3."',";
$sql.="FT_P3_Bet='".$FT_P3_Bet."',";
$sql.="FT_P3_Scene='".$FT_P3_Scene."',";
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~篮球
$sql.="BK_Turn_R_A='".$BK_Turn_R_A."',";
$sql.="BK_Turn_R_B='".$BK_Turn_R_B."',";
$sql.="BK_Turn_R_C='".$BK_Turn_R_C."',";
$sql.="BK_Turn_R_D='".$BK_Turn_R_D."',";
$sql.="BK_R_Bet='".$BK_R_Bet."',";
$sql.="BK_R_Scene='".$BK_R_Scene."',";
$sql.="BK_Turn_OU_A='".$BK_Turn_OU_A."',";
$sql.="BK_Turn_OU_B='".$BK_Turn_OU_B."',";
$sql.="BK_Turn_OU_C='".$BK_Turn_OU_C."',";
$sql.="BK_Turn_OU_D='".$BK_Turn_OU_D."',";
$sql.="BK_OU_Bet='".$BK_OU_Bet."',";
$sql.="BK_OU_Scene='".$BK_OU_Scene."',";
$sql.="BK_Turn_RE_A='".$BK_Turn_RE_A."',";
$sql.="BK_Turn_RE_B='".$BK_Turn_RE_B."',";
$sql.="BK_Turn_RE_C='".$BK_Turn_RE_C."',";
$sql.="BK_Turn_RE_D='".$BK_Turn_RE_D."',";
$sql.="BK_RE_Bet='".$BK_RE_Bet."',";
$sql.="BK_RE_Scene='".$BK_RE_Scene."',";
$sql.="BK_Turn_ROU_A='".$BK_Turn_ROU_A."',";
$sql.="BK_Turn_ROU_B='".$BK_Turn_ROU_B."',";
$sql.="BK_Turn_ROU_C='".$BK_Turn_ROU_C."',";
$sql.="BK_Turn_ROU_D='".$BK_Turn_ROU_D."',";
$sql.="BK_ROU_Bet='".$BK_ROU_Bet."',";
$sql.="BK_ROU_Scene='".$BK_ROU_Scene."',";
$sql.="BK_Turn_EO_A='".$BK_Turn_EO_A."',";
$sql.="BK_Turn_EO_B='".$BK_Turn_EO_B."',";
$sql.="BK_Turn_EO_C='".$BK_Turn_EO_C."',";
$sql.="BK_Turn_EO_D='".$BK_Turn_EO_D."',";
$sql.="BK_EO_Bet='".$BK_EO_Bet."',";
$sql.="BK_EO_Scene='".$BK_EO_Scene."',";
$sql.="BK_Turn_PR='".$BK_Turn_PR."',";
$sql.="BK_PR_Bet='".$BK_PR_Bet."',";
$sql.="BK_PR_Scene='".$BK_PR_Scene."',";
$sql.="BK_Turn_P3='".$BK_Turn_P3."',";
$sql.="BK_P3_Bet='".$BK_P3_Bet."',";
$sql.="BK_P3_Scene='".$BK_P3_Scene."',";
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~冠军
$sql.="FS_Turn_FS='".$FS_Turn_FS."',";
$sql.="FS_FS_Scene='".$FS_FS_Scene."',";
$sql.="FS_FS_Bet='".$FS_FS_Bet."',";
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~棒球
$sql.="BS_Turn_R_A='".$BS_Turn_R_A."',";
$sql.="BS_Turn_R_B='".$BS_Turn_R_B."',";
$sql.="BS_Turn_R_C='".$BS_Turn_R_C."',";
$sql.="BS_Turn_R_D='".$BS_Turn_R_D."',";
$sql.="BS_R_Bet='".$BS_R_Bet."',";
$sql.="BS_R_Scene='".$BS_R_Scene."',";
$sql.="BS_Turn_OU_A='".$BS_Turn_OU_A."',";
$sql.="BS_Turn_OU_B='".$BS_Turn_OU_B."',";
$sql.="BS_Turn_OU_C='".$BS_Turn_OU_C."',";
$sql.="BS_Turn_OU_D='".$BS_Turn_OU_D."',";
$sql.="BS_OU_Bet='".$BS_OU_Bet."',";
$sql.="BS_OU_Scene='".$BS_OU_Scene."',";
$sql.="BS_Turn_RE_A='".$BS_Turn_RE_A."',";
$sql.="BS_Turn_RE_B='".$BS_Turn_RE_B."',";
$sql.="BS_Turn_RE_C='".$BS_Turn_RE_C."',";
$sql.="BS_Turn_RE_D='".$BS_Turn_RE_D."',";
$sql.="BS_RE_Bet='".$BS_RE_Bet."',";
$sql.="BS_RE_Scene='".$BS_RE_Scene."',";
$sql.="BS_Turn_ROU_A='".$BS_Turn_ROU_A."',";
$sql.="BS_Turn_ROU_B='".$BS_Turn_ROU_B."',";
$sql.="BS_Turn_ROU_C='".$BS_Turn_ROU_C."',";
$sql.="BS_Turn_ROU_D='".$BS_Turn_ROU_D."',";
$sql.="BS_ROU_Bet='".$BS_ROU_Bet."',";
$sql.="BS_ROU_Scene='".$BS_ROU_Scene."',";
$sql.="BS_Turn_EO_A='".$BS_Turn_EO_A."',";
$sql.="BS_Turn_EO_B='".$BS_Turn_EO_B."',";
$sql.="BS_Turn_EO_C='".$BS_Turn_EO_C."',";
$sql.="BS_Turn_EO_D='".$BS_Turn_EO_D."',";
$sql.="BS_EO_Bet='".$BS_EO_Bet."',";
$sql.="BS_EO_Scene='".$BS_EO_Scene."',";
$sql.="BS_Turn_M='".$BS_Turn_M."',";
$sql.="BS_M_Bet='".$BS_M_Bet."',";
$sql.="BS_M_Scene='".$BS_M_Scene."',";
$sql.="BS_Turn_PD='".$BS_Turn_PD."',";
$sql.="BS_PD_Bet='".$BS_PD_Bet."',";
$sql.="BS_PD_Scene='".$BS_PD_Scene."',";
$sql.="BS_Turn_T='".$BS_Turn_T."',";
$sql.="BS_T_Bet ='".$BS_T_Bet."',";	
$sql.="BS_T_Scene='".$BS_T_Scene."',";
$sql.="BS_Turn_P='".$BS_Turn_P."',";
$sql.="BS_P_Bet='".$BS_P_Bet."',";
$sql.="BS_P_Scene='".$BS_P_Scene."',";
$sql.="BS_Turn_PR='".$BS_Turn_PR."',";
$sql.="BS_PR_Bet='".$BS_PR_Bet."',";
$sql.="BS_PR_Scene='".$BS_PR_Scene."',";
$sql.="BS_Turn_P3='".$BS_Turn_P3."',";
$sql.="BS_P3_Bet='".$BS_P3_Bet."',";
$sql.="BS_P3_Scene='".$BS_P3_Scene."',";
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~网球
$sql.="TN_Turn_R_A='".$TN_Turn_R_A."',";
$sql.="TN_Turn_R_B='".$TN_Turn_R_B."',";
$sql.="TN_Turn_R_C='".$TN_Turn_R_C."',";
$sql.="TN_Turn_R_D='".$TN_Turn_R_D."',";
$sql.="TN_R_Bet='".$TN_R_Bet."',";
$sql.="TN_R_Scene='".$TN_R_Scene."',";
$sql.="TN_Turn_OU_A='".$TN_Turn_OU_A."',";
$sql.="TN_Turn_OU_B='".$TN_Turn_OU_B."',";
$sql.="TN_Turn_OU_C='".$TN_Turn_OU_C."',";
$sql.="TN_Turn_OU_D='".$TN_Turn_OU_D."',";
$sql.="TN_OU_Bet='".$TN_OU_Bet."',";
$sql.="TN_OU_Scene='".$TN_OU_Scene."',";
$sql.="TN_Turn_RE_A='".$TN_Turn_RE_A."',";
$sql.="TN_Turn_RE_B='".$TN_Turn_RE_B."',";
$sql.="TN_Turn_RE_C='".$TN_Turn_RE_C."',";
$sql.="TN_Turn_RE_D='".$TN_Turn_RE_D."',";
$sql.="TN_RE_Bet='".$TN_RE_Bet."',";
$sql.="TN_RE_Scene='".$TN_RE_Scene."',";
$sql.="TN_Turn_ROU_A='".$TN_Turn_ROU_A."',";
$sql.="TN_Turn_ROU_B='".$TN_Turn_ROU_B."',";
$sql.="TN_Turn_ROU_C='".$TN_Turn_ROU_C."',";
$sql.="TN_Turn_ROU_D='".$TN_Turn_ROU_D."',";
$sql.="TN_ROU_Bet='".$TN_ROU_Bet."',";
$sql.="TN_ROU_Scene='".$TN_ROU_Scene."',";
$sql.="TN_Turn_EO_A='".$TN_Turn_EO_A."',";
$sql.="TN_Turn_EO_B='".$TN_Turn_EO_B."',";
$sql.="TN_Turn_EO_C='".$TN_Turn_EO_C."',";
$sql.="TN_Turn_EO_D='".$TN_Turn_EO_D."',";
$sql.="TN_EO_Bet='".$TN_EO_Bet."',";
$sql.="TN_EO_Scene='".$TN_EO_Scene."',";
$sql.="TN_Turn_M='".$TN_Turn_M."',";
$sql.="TN_M_Bet='".$TN_M_Bet."',";
$sql.="TN_M_Scene='".$TN_M_Scene."',";
$sql.="TN_Turn_PD='".$TN_Turn_PD."',";
$sql.="TN_PD_Bet='".$TN_PD_Bet."',";
$sql.="TN_PD_Scene='".$TN_PD_Scene."',";
$sql.="TN_Turn_P='".$TN_Turn_P."',";
$sql.="TN_P_Bet='".$TN_P_Bet."',";
$sql.="TN_P_Scene='".$TN_P_Scene."',";
$sql.="TN_Turn_PR='".$TN_Turn_PR."',";
$sql.="TN_PR_Bet='".$TN_PR_Bet."',";
$sql.="TN_PR_Scene='".$TN_PR_Scene."',";
$sql.="TN_Turn_P3='".$TN_Turn_P3."',";
$sql.="TN_P3_Bet='".$TN_P3_Bet."',";
$sql.="TN_P3_Scene='".$TN_P3_Scene."',";
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~排球
$sql.="VB_Turn_R_A='".$VB_Turn_R_A."',";
$sql.="VB_Turn_R_B='".$VB_Turn_R_B."',";
$sql.="VB_Turn_R_C='".$VB_Turn_R_C."',";
$sql.="VB_Turn_R_D='".$VB_Turn_R_D."',";
$sql.="VB_R_Bet='".$VB_R_Bet."',";
$sql.="VB_R_Scene='".$VB_R_Scene."',";
$sql.="VB_Turn_OU_A='".$VB_Turn_OU_A."',";
$sql.="VB_Turn_OU_B='".$VB_Turn_OU_B."',";
$sql.="VB_Turn_OU_C='".$VB_Turn_OU_C."',";
$sql.="VB_Turn_OU_D='".$VB_Turn_OU_D."',";
$sql.="VB_OU_Bet='".$VB_OU_Bet."',";
$sql.="VB_OU_Scene='".$VB_OU_Scene."',";
$sql.="VB_Turn_RE_A='".$VB_Turn_RE_A."',";
$sql.="VB_Turn_RE_B='".$VB_Turn_RE_B."',";
$sql.="VB_Turn_RE_C='".$VB_Turn_RE_C."',";
$sql.="VB_Turn_RE_D='".$VB_Turn_RE_D."',";
$sql.="VB_RE_Bet='".$VB_RE_Bet."',";
$sql.="VB_RE_Scene='".$VB_RE_Scene."',";
$sql.="VB_Turn_ROU_A='".$VB_Turn_ROU_A."',";
$sql.="VB_Turn_ROU_B='".$VB_Turn_ROU_B."',";
$sql.="VB_Turn_ROU_C='".$VB_Turn_ROU_C."',";
$sql.="VB_Turn_ROU_D='".$VB_Turn_ROU_D."',";
$sql.="VB_ROU_Bet='".$VB_ROU_Bet."',";
$sql.="VB_ROU_Scene='".$VB_ROU_Scene."',";
$sql.="VB_Turn_EO_A='".$VB_Turn_EO_A."',";
$sql.="VB_Turn_EO_B='".$VB_Turn_EO_B."',";
$sql.="VB_Turn_EO_C='".$VB_Turn_EO_C."',";
$sql.="VB_Turn_EO_D='".$VB_Turn_EO_D."',";
$sql.="VB_EO_Bet='".$VB_EO_Bet."',";
$sql.="VB_EO_Scene='".$VB_EO_Scene."',";
$sql.="VB_Turn_M='".$VB_Turn_M."',";
$sql.="VB_M_Bet='".$VB_M_Bet."',";
$sql.="VB_M_Scene='".$VB_M_Scene."',";
$sql.="VB_Turn_PD='".$VB_Turn_PD."',";
$sql.="VB_PD_Bet='".$VB_PD_Bet."',";
$sql.="VB_PD_Scene='".$VB_PD_Scene."',";
$sql.="VB_Turn_P='".$VB_Turn_P."',";
$sql.="VB_P_Bet='".$VB_P_Bet."',";
$sql.="VB_P_Scene='".$VB_P_Scene."',";
$sql.="VB_Turn_PR='".$VB_Turn_PR."',";
$sql.="VB_PR_Bet='".$VB_PR_Bet."',";
$sql.="VB_PR_Scene='".$VB_PR_Scene."',";
$sql.="VB_Turn_P3='".$VB_Turn_P3."',";
$sql.="VB_P3_Bet='".$VB_P3_Bet."',";
$sql.="VB_P3_Scene='".$VB_P3_Scene."',";
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~其它
$sql.="OP_Turn_R_A='".$OP_Turn_R_A."',";
$sql.="OP_Turn_R_B='".$OP_Turn_R_B."',";
$sql.="OP_Turn_R_C='".$OP_Turn_R_C."',";
$sql.="OP_Turn_R_D='".$OP_Turn_R_D."',";
$sql.="OP_R_Bet='".$OP_R_Bet."',";
$sql.="OP_R_Scene='".$OP_R_Scene."',";
$sql.="OP_Turn_OU_A='".$OP_Turn_OU_A."',";
$sql.="OP_Turn_OU_B='".$OP_Turn_OU_B."',";
$sql.="OP_Turn_OU_C='".$OP_Turn_OU_C."',";
$sql.="OP_Turn_OU_D='".$OP_Turn_OU_D."',";
$sql.="OP_OU_Bet='".$OP_OU_Bet."',";
$sql.="OP_OU_Scene='".$OP_OU_Scene."',";
$sql.="OP_Turn_RE_A='".$OP_Turn_RE_A."',";
$sql.="OP_Turn_RE_B='".$OP_Turn_RE_B."',";
$sql.="OP_Turn_RE_C='".$OP_Turn_RE_C."',";
$sql.="OP_Turn_RE_D='".$OP_Turn_RE_D."',";
$sql.="OP_RE_Bet='".$OP_RE_Bet."',";
$sql.="OP_RE_Scene='".$OP_RE_Scene."',";
$sql.="OP_Turn_ROU_A='".$OP_Turn_ROU_A."',";
$sql.="OP_Turn_ROU_B='".$OP_Turn_ROU_B."',";
$sql.="OP_Turn_ROU_C='".$OP_Turn_ROU_C."',";
$sql.="OP_Turn_ROU_D='".$OP_Turn_ROU_D."',";
$sql.="OP_ROU_Bet='".$OP_ROU_Bet."',";
$sql.="OP_ROU_Scene='".$OP_ROU_Scene."',";
$sql.="OP_Turn_EO_A='".$OP_Turn_EO_A."',";
$sql.="OP_Turn_EO_B='".$OP_Turn_EO_B."',";
$sql.="OP_Turn_EO_C='".$OP_Turn_EO_C."',";
$sql.="OP_Turn_EO_D='".$OP_Turn_EO_D."',";
$sql.="OP_EO_Bet='".$OP_EO_Bet."',";
$sql.="OP_EO_Scene='".$OP_EO_Scene."',";
$sql.="OP_Turn_M='".$OP_Turn_M."',";
$sql.="OP_M_Bet='".$OP_M_Bet."',";
$sql.="OP_M_Scene='".$OP_M_Scene."',";
$sql.="OP_Turn_PD='".$OP_Turn_PD."',";
$sql.="OP_PD_Bet='".$OP_PD_Bet."',";
$sql.="OP_PD_Scene='".$OP_PD_Scene."',";
$sql.="OP_Turn_T='".$OP_Turn_T."',";
$sql.="OP_T_Bet='".$OP_T_Bet."',";
$sql.="OP_T_Scene='".$OP_T_Scene."',";
$sql.="OP_Turn_F='".$OP_Turn_F."',";
$sql.="OP_F_Bet='".$OP_F_Bet."',";
$sql.="OP_F_Scene='".$OP_F_Scene."',";
$sql.="OP_P_Bet='".$OP_P_Bet."',";
$sql.="OP_Turn_P='".$OP_Turn_P."',";
$sql.="OP_P_Scene='".$OP_P_Scene."',";
$sql.="OP_Turn_PR='".$OP_Turn_PR."',";
$sql.="OP_PR_Bet='".$OP_PR_Bet."',";
$sql.="OP_PR_Scene='".$OP_PR_Scene."',";
$sql.="OP_Turn_P3='".$OP_Turn_P3."',";
$sql.="OP_P3_Bet='".$OP_P3_Bet."',";
$sql.="OP_P3_Scene='".$OP_P3_Scene."',";
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~六合彩
$sql.="SIX_Turn_SCA_A='".$SIX_Turn_SCA_A."',";
$sql.="SIX_Turn_SCA_B='".$SIX_Turn_SCA_B."',";
$sql.="SIX_Turn_SCA_C='".$SIX_Turn_SCA_C."',";
$sql.="SIX_Turn_SCA_D='".$SIX_Turn_SCA_D."',";
$sql.="SIX_SCA_Bet='".$SIX_SCA_Bet."',";
$sql.="SIX_SCA_Scene='".$SIX_SCA_Scene."',";
$sql.="SIX_Turn_SCB_A='".$SIX_Turn_SCB_A."',";
$sql.="SIX_Turn_SCB_B='".$SIX_Turn_SCB_B."',";
$sql.="SIX_Turn_SCB_C='".$SIX_Turn_SCB_C."',";
$sql.="SIX_Turn_SCB_D='".$SIX_Turn_SCB_D."',";
$sql.="SIX_SCB_Bet='".$SIX_SCB_Bet."',";
$sql.="SIX_SCB_Scene='".$SIX_SCB_Scene."',";
$sql.="SIX_Turn_SCA_AOUEO_A='".$SIX_Turn_SCA_AOUEO_A."',";
$sql.="SIX_Turn_SCA_AOUEO_B='".$SIX_Turn_SCA_AOUEO_B."',";
$sql.="SIX_Turn_SCA_AOUEO_C='".$SIX_Turn_SCA_AOUEO_C."',";
$sql.="SIX_Turn_SCA_AOUEO_D='".$SIX_Turn_SCA_AOUEO_D."',";
$sql.="SIX_SCA_AOUEO_Bet='".$SIX_SCA_AOUEO_Bet."',";
$sql.="SIX_SCA_AOUEO_Scene='".$SIX_SCA_AOUEO_Scene."',";
$sql.="SIX_Turn_SCA_BOUEO_A='".$SIX_Turn_SCA_BOUEO_A."',";
$sql.="SIX_Turn_SCA_BOUEO_B='".$SIX_Turn_SCA_BOUEO_B."',";
$sql.="SIX_Turn_SCA_BOUEO_C='".$SIX_Turn_SCA_BOUEO_C."',";
$sql.="SIX_Turn_SCA_BOUEO_D='".$SIX_Turn_SCA_BOUEO_D."',";
$sql.="SIX_SCA_BOUEO_Bet='".$SIX_SCA_BOUEO_Bet."',";
$sql.="SIX_SCA_BOUEO_Scene='".$SIX_SCA_BOUEO_Scene."',";
$sql.="SIX_Turn_SCA_RBG_A='".$SIX_Turn_SCA_RBG_A."',";
$sql.="SIX_Turn_SCA_RBG_B='".$SIX_Turn_SCA_RBG_B."',";
$sql.="SIX_Turn_SCA_RBG_C='".$SIX_Turn_SCA_RBG_C."',";
$sql.="SIX_Turn_SCA_RBG_D='".$SIX_Turn_SCA_RBG_D."',";
$sql.="SIX_SCA_RBG_Bet='".$SIX_SCA_RBG_Bet."',";
$sql.="SIX_SCA_RBG_Scene='".$SIX_SCA_RBG_Scene."',";
$sql.="SIX_Turn_AC_A='".$SIX_Turn_AC_A."',";
$sql.="SIX_Turn_AC_B='".$SIX_Turn_AC_B."',";
$sql.="SIX_Turn_AC_C='".$SIX_Turn_AC_C."',";
$sql.="SIX_Turn_AC_D='".$SIX_Turn_AC_D."',";
$sql.="SIX_AC_Bet='".$SIX_AC_Bet."',";
$sql.="SIX_AC_Scene='".$SIX_AC_Scene."',";
$sql.="SIX_Turn_AC_TOUEO_A='".$SIX_Turn_AC_TOUEO_A."',";
$sql.="SIX_Turn_AC_TOUEO_B='".$SIX_Turn_AC_TOUEO_B."',";
$sql.="SIX_Turn_AC_TOUEO_C='".$SIX_Turn_AC_TOUEO_C."',";
$sql.="SIX_Turn_AC_TOUEO_D='".$SIX_Turn_AC_TOUEO_D."',";
$sql.="SIX_AC_TOUEO_Bet='".$SIX_AC_TOUEO_Bet."',";
$sql.="SIX_AC_TOUEO_Scene='".$SIX_AC_TOUEO_Scene."',";

$sql.="SIX_Turn_AC6_AOUEO_A='".$SIX_Turn_AC6_AOUEO_A."',";
$sql.="SIX_Turn_AC6_AOUEO_B='".$SIX_Turn_AC6_AOUEO_B."',";
$sql.="SIX_Turn_AC6_AOUEO_C='".$SIX_Turn_AC6_AOUEO_C."',";
$sql.="SIX_Turn_AC6_AOUEO_D='".$SIX_Turn_AC6_AOUEO_D."',";
$sql.="SIX_AC6_AOUEO_Bet='".$SIX_AC6_AOUEO_Bet."',";
$sql.="SIX_AC6_AOUEO_Scene='".$SIX_AC6_AOUEO_Scene."',";

$sql.="SIX_Turn_AC6_BOUEO_A='".$SIX_Turn_AC6_BOUEO_A."',";
$sql.="SIX_Turn_AC6_BOUEO_B='".$SIX_Turn_AC6_BOUEO_B."',";
$sql.="SIX_Turn_AC6_BOUEO_C='".$SIX_Turn_AC6_BOUEO_C."',";
$sql.="SIX_Turn_AC6_BOUEO_D='".$SIX_Turn_AC6_BOUEO_D."',";
$sql.="SIX_AC6_BOUEO_Bet='".$SIX_AC6_BOUEO_Bet."',";
$sql.="SIX_AC6_BOUEO_Scene='".$SIX_AC6_BOUEO_Scene."',";

$sql.="SIX_Turn_AC6_RBG_A='".$SIX_Turn_AC6_RBG_A."',";
$sql.="SIX_Turn_AC6_RBG_B='".$SIX_Turn_AC6_RBG_B."',";
$sql.="SIX_Turn_AC6_RBG_C='".$SIX_Turn_AC6_RBG_C."',";
$sql.="SIX_Turn_AC6_RBG_D='".$SIX_Turn_AC6_RBG_D."',";
$sql.="SIX_AC6_RBG_Bet='".$SIX_AC6_RBG_Bet."',";
$sql.="SIX_AC6_RBG_Scene='".$SIX_AC6_RBG_Scene."',";
$sql.="SIX_Turn_SX_A='".$SIX_Turn_SX_A."',";
$sql.="SIX_Turn_SX_B='".$SIX_Turn_SX_B."',";
$sql.="SIX_Turn_SX_C='".$SIX_Turn_SX_C."',";
$sql.="SIX_Turn_SX_D='".$SIX_Turn_SX_D."',";
$sql.="SIX_SX_Bet='".$SIX_SX_Bet."',";
$sql.="SIX_SX_Scene='".$SIX_SX_Scene."',";
$sql.="SIX_Turn_HW_A='".$SIX_Turn_HW_A."',";
$sql.="SIX_Turn_HW_B='".$SIX_Turn_HW_B."',";
$sql.="SIX_Turn_HW_C='".$SIX_Turn_HW_C."',";
$sql.="SIX_Turn_HW_D='".$SIX_Turn_HW_D."',";
$sql.="SIX_HW_Bet='".$SIX_HW_Bet."',";
$sql.="SIX_HW_Scene='".$SIX_HW_Scene."',";
$sql.="SIX_Turn_MT_A='".$SIX_Turn_MT_A."',";
$sql.="SIX_Turn_MT_B='".$SIX_Turn_MT_B."',";
$sql.="SIX_Turn_MT_C='".$SIX_Turn_MT_C."',";
$sql.="SIX_Turn_MT_D='".$SIX_Turn_MT_D."',";
$sql.="SIX_MT_Bet='".$SIX_MT_Bet."',";
$sql.="SIX_MT_Scene='".$SIX_MT_Scene."',";
$sql.="SIX_Turn_M_A='".$SIX_Turn_M_A."',";
$sql.="SIX_Turn_M_B='".$SIX_Turn_M_B."',";
$sql.="SIX_Turn_M_C='".$SIX_Turn_M_C."',";
$sql.="SIX_Turn_M_D='".$SIX_Turn_M_D."',";
$sql.="SIX_M_Bet='".$SIX_M_Bet."',";
$sql.="SIX_M_Scene='".$SIX_M_Scene."',";
$sql.="SIX_Turn_EC_A='".$SIX_Turn_EC_A."',";
$sql.="SIX_Turn_EC_B='".$SIX_Turn_EC_B."',";
$sql.="SIX_Turn_EC_C='".$SIX_Turn_EC_C."',";
$sql.="SIX_Turn_EC_D='".$SIX_Turn_EC_D."',";
$sql.="SIX_EC_Bet='".$SIX_EC_Bet."',";
$sql.="SIX_EC_Scene='".$SIX_EC_Scene."'";
//echo $sql;
//exit;
mysql_db_query($dbname,$sql) or die ("操作失败!!!");
$loginfo='新增'.$Title.':'.$username.' 密码:'.$password.' 名称:'.$alias.' 信用额度:'.$maxcredit.' 儲值點數:'.$maxpoints.' 上线'.$Caption.':'.$parents_id.'';
$mysql="update web_agents_data set Count=Count+1 where UserName='$parents_id'";
mysql_db_query($dbname,$mysql) or die ("操作失败!!");
echo "<script languag='JavaScript'>self.location='user_browse.php?uid=$uid&lv=$lv&langx=$langx'</script>";	
}	
}else{
$ssql="select sum(credit) as credit,sum(Points) as Points from web_agents_data where Status=0 and $user  ";
$sresult = mysql_db_query($dbname,$ssql);
$srow = mysql_fetch_array($sresult);
$esql="select sum(credit) as credit,sum(Points) as Points from web_agents_data where Status>0 and $user ";
$eresult = mysql_db_query($dbname,$esql);
$erow = mysql_fetch_array($eresult);
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_co_ed {  background-color: #D3C9CB; text-align: right}
-->
</style>
<link rel="stylesheet" href="/tpl/style/agents/autocomplete.css" type="text/css">
<script src="/js/lib/prototype.js" type="text/javascript"></script>
<script src="/js/lib/scriptaculous.js" type="text/javascript"></script>
<SCRIPT>
<!--
function LoadBody(){
document.all.num_1.selectedIndex=document.all.num_1[0];
document.all.num_2.selectedIndex=document.all.num_2[0];
document.all.num_3.selectedIndex=document.all.num_3[0];
}
function SubChk(){
    if(document.all.parents_id.value==''){ 
	document.all.parents_id.focus(); alert("<?=$Mem_Input?>:<?=$Caption?><?=$Mem_Account?>!!"); return false; }
    if(document.all.num_1.value==''){ 
	document.all.num_1.focus(); alert("<?=$Mem_alert0?>!!"); return false; }
    if(document.all.num_2.value==''){ 
	document.all.num_2.focus(); alert("<?=$Mem_alert0?>!!"); return false; }
    if(document.all.num_3.value==''){ 
	document.all.num_3.focus(); alert("<?=$Mem_alert0?>!!"); return false; }
	if(document.all.password.value=='' ){ 
	document.all.password.focus(); alert("<?=$Mem_Input?> :<?=$Mem_Password?> !!"); return false; }
	if(document.all.password.value.length < 6 ){alert('<?=$Mem_NewPassword_6_Characters?>');return false;}
	if(document.all.password.value.length > 12 ){alert('<?=$Mem_NewPassword_12_CharactersMax?>');return false;}
	var Numflag = 0;
	var Letterflag = 0;
    var pwd = document.all.password.value;
	for (idx = 0; idx < pwd.length; idx++) {
		//====== 密碼只可使用字母(不分大小寫)與數字
		if(!((pwd.charAt(idx)>= "a" && pwd.charAt(idx) <= "z") || (pwd.charAt(idx)>= 'A' && pwd.charAt(idx) <= 'Z') || (pwd.charAt(idx)>= '0' && pwd.charAt(idx) <= '9'))){
			alert("<?=$Mem_PasswordEnglishNumber_6_Characters_12_CharactersMax?>");
			return false;
		}
		if ((pwd.charAt(idx)>= "a" && pwd.charAt(idx) <= "z") || (pwd.charAt(idx)>= 'A' && pwd.charAt(idx) <= 'Z')){
			Letterflag++;
		}
		if ((pwd.charAt(idx)>= "0" && pwd.charAt(idx) <= "9")){
			Numflag++;
		}
	}
		var msg = "";
	if (Numflag == 0 || Letterflag == 0) { alert('<?=$Mem_PasswordEnglishNumber?>');return false;
	} else if (Letterflag >= 1 && Letterflag <= 3) {
		msg = "1";
	} else if (Letterflag >= 4 && Letterflag <= 8) {
		msg = "2";
	} else if (Letterflag >= 9 && Letterflag <= 11) {
		msg = "3";
	} else {
		return false;
	}
	if(document.all.passwd.value==''){ 
	document.all.passwd.focus(); alert("<?=$Mem_Input?> :<?=$Mem_Cofirm_Password?> !!"); return false; }
	if(document.all.password.value != document.all.passwd.value){ 
	document.all.password.focus(); alert("<?=$Mem_PasswordConfirmError?> !!"); return false; }
	if(document.all.alias.value==''){ 
	document.all.alias.focus(); alert("<?=$Mem_Input?> :<?=$Mem_Name?> !!"); return false; }
	if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0'){ 
	document.all.maxcredit.focus(); alert("<?=$Mem_Input?> :<?=$Mem_Credit_Amount?> !!"); return false; }
<?
if($lv=='D'){
?>
	if(document.all.winloss_d.value=='' ){ 
	document.all.winloss_d.focus(); alert("<?=$wld_percent3?>"); return false; } 
	var winloss_d,winloss_c;
	winloss_c=eval(document.all.winloss_c.value);
	winloss_d=eval(document.all.winloss_d.value); 
	if ((winloss_c+winloss_d)>80){
       alert("<?=$Mem_alert14?>");
       document.all.winloss_d.focus();
       return false;
	}
	if ((winloss_c+winloss_d)<50){
       alert("<?=$Mem_alert14?>");
       document.all.winloss_d.focus();
       return false;
	}
<?
}
?>
    document.all.keys.value = 'add';
	document.all.OK.disabled = true;
	document.all.FormsButton2.disabled = true;
	//document.myFORM.submit();
	if(!confirm("<?=$Mem_Whether_Write?> <?=$Title?> ?")){
		document.all.OK.disabled = false;
		document.all.FormsButton2.disabled = false;
		return false;
	}
	 document.all.username.value = document.all.user_count.innerHTML;
}

function CheckKey(){
	if(event.keyCode < 48 || event.keyCode > 57){alert("<?=$Mem_Enter_Numbers?>"); return false;}
}

function get_name(selectvalue)
{
	str=selectvalue.split("==",2);
	strtmp=str[0].substring(1,3);
	var user_count=document.all.user_count;
	user_count.innerHTML='<?=$add?>'+strtmp;
	}

function parents_reload(parents_id)
{
		self.location='user_add.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&action=browse_add&parents_id='+parents_id;
}
function ChkMem(){
	username=document.all.user_count.innerHTML;
	//strtmp=username.substring(0,3);
	//if(username==strtmp){
	if(username.length<6){
		document.all.user_count.focus(); alert("<?=$Mem_Input?> :<?=$Mem_Full_Account?>!!!"); return false;
	}else{
	    document.getElementById('getData').src='check_id.php?uid=<?=$uid?>&langx=<?=$langx?>&lv=<?=$lv?>&username='+username;
    }
}
function sync2username(text,li) {
	document.myFORM.parents_id.value = li.id;
	parents_reload(li.id);
}
function onload() {
		get_name(myFORM.parents_id.options[myFORM.parents_id.selectedIndex].text);
		}
//建議帳號用
function chg_username(newname) {
	document.myFORM.username.value=newname;
}
function selchg(s1,s2) {
    if (s1.selectedIndex==(s1.length-1)) {
        s2.selectedIndex = s2.length-1;
    }
}

//佔成制下拉霸更換時頁面更新
function winloss_type_change() {
//不做動作
}
function show_count(w,s) {
	//alert(w+' - '+s);
	var org_str=document.all.user_count.innerHTML;//org_str.substr(1,5)
	if (s!=''){
		switch(w){
			case 0:	document.all.user_count.innerHTML = s.substr(1,3)+org_str.substr(3,4);break;
			case 1:document.all.user_count.innerHTML = org_str.substr(0,3)+s+org_str.substr(4,3);break;
			case 2:document.all.user_count.innerHTML = org_str.substr(0,4)+s+org_str.substr(5,2);break;
			case 3:document.all.user_count.innerHTML = org_str.substr(0,5)+s+org_str.substr(6,1);break;
		}
	}
}
// -->
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onload(),LoadBody();" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<FORM NAME="myFORM" ACTION="user_add.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?> " METHOD=POST onSubmit="return SubChk()">
  <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$id?>">
  <INPUT TYPE=HIDDEN NAME="username" VALUE="">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="add">
  <INPUT TYPE=HIDDEN NAME="enable" VALUE="">
  <INPUT TYPE=HIDDEN NAME="winloss_no" VALUE="Y">
  <input type="hidden" name="s_low_order_gold" value="100">
  <input type="hidden" name="s_low_order_gold_pc" value="50">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">&nbsp;&nbsp;<?=$Caption?><?=$Mem_Manager?> --<?=$Mem_Add?> ,<?=$Mem_Edit?>
        <select name="parents_id" class="za_select" onChange="parents_reload(this.options[this.selectedIndex].value)">
        <option label="" value="" selected="selected"></option>
		<?
	    $mysql = "select UserName,Alias from $data where $agents and Status=0 and Level='$level' order by ID desc";
		//echo $mysql;
		//$loginfo='选者上线'.$Title.'';
		$aresult = mysql_db_query($dbname,$mysql);
		while ($arow = mysql_fetch_array($aresult)){
					if ($parents_id==$arow['UserName']){
						echo "<option value=".$arow['UserName']." selected>".$arow['UserName']."==".$arow['Alias']."</option>";				
						$sel_agents=$arow['UserName'];
					}else{
						echo "<option value=".$arow['UserName'].">".$arow['UserName']."==".$arow['Alias']."</option>";
					}
		}
		?>
        </select>
	    <input type='hidden' name='line' value='ND'>
		<input type='hidden' name='cha' value='N'>
		<input type='hidden' name='rent' value='N'>
		<input type='hidden' name='sp_upper' value=''>
        &nbsp;&nbsp;
        <span style="display:none">
        <b style="color:blue">佔成制: </b>
        <select name="winloss_type" onChange="winloss_type_change();" class="za_select">
          <option label="91佔成制" value="91" selected="selected">91佔成制</option>
          <option label="58佔成制" value="58">58佔成制</option>
          <option label="大股東制" value="SC58">大股東制</option>
          <option label="91A佔成制" value="91A">91A佔成制</option>
          <option label="基本佔成制" value="BASE">基本佔成制</option>
	    </select>
	    </span>
      </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr>
      <td colspan="2" height="4"></td>
    </tr>
  </table>
  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" ><?=$Mem_Basic_data?><?=$Mem_Settings?> </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"> <?=$Title?> <?=$Mem_Account?> :&nbsp;<span id=user_count></span></td>
            <td>
			  <select size="1" name="num_1" style="border-style: solid; border-width: 0" onChange="show_count(1,this.value);" class="za_select_t">
                <option value=""></option>
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
			</select>
              <select size="1" name="num_2" style="border-style: solid; border-width: 0" onChange="show_count(2,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
              <select size="1" name="num_3" style="border-style: solid; border-width: 0" onChange="show_count(3,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>&nbsp;◎<?=$Mem_Account_Rules?>：<?=$Mem_Input?><?=$Mem_Four_Number?><font color='red'><b>０～９</b></font> 
			  <input type=button name="chk" value="<?=$Mem_Check?><?=$Mem_Account?>" class="za_button" onclick='ChkMem();'></td>
          </tr>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed"><?=$Mem_Password?> :</td>
      <td>
        <input type=PASSWORD name="password" value="" size=12 maxlength=12 class="za_text">
         ◎<?=$Mem_Password_Guidelines?>：<?=$Mem_Pasread?></td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed"><?=$Mem_Cofirm_Password?> :</td>
      <td>
        <input type=PASSWORD name="passwd" value="" size=12 maxlength=12 class="za_text">      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed"><?=$Title?> <?=$Mem_Name?> :</td>
      <td><input type=TEXT name="alias" value="" size=10 maxlength=10 class="za_text"></td>
    </tr>
  </table>

  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" ><?=$Mem_Betting_data?><?=$Mem_Settings?> </td>
    </tr>	
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_Credit_Amount?> :</td>
      <td>
        <input type=TEXT name="maxcredit" value="0" size=10 maxlength=15 class="za_text" onKeyPress="return CheckKey();">
<?
$parents_id=$_REQUEST['parents_id'];
if ($parents_id!=''){
?>
        <?=$Mem_Credits_Status?> / <?=$Mem_Enable?> : <?=number_format($srow['credit'],0)?>&nbsp;&nbsp;&nbsp; <?=$Mem_Disable?> : <?=number_format($erow['credit'],0)?>&nbsp;&nbsp;&nbsp; <?=$Mem_Available?> :<?=number_format($row['Credit']-$erow['credit']-$srow['credit'],0)?>        
<?
}else{
?>
		<?=$Mem_Credits_Status?> / <?=$Mem_Enable?> : 0&nbsp;&nbsp;&nbsp; <?=$Mem_Disable?> : 0&nbsp;&nbsp;&nbsp; <?=$Mem_Available?> :0 
<?
}
?>
	 </td>
    </tr>
    <!--tr class="m_bc_ed">
      <td class="m_co_ed">使用币别 :</td>
      <td><select name="type" class="za_select" disabled>
       <option label="<?=$curtype?>" value="<?=$curtype?>" ><?=$curtype?></option>
       </select></td>
    </tr-->	
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_Instant_order?> :</td>
      <td>
        <select name="wager" class="za_select">
        <option label="<?=$Mem_Enable?>" value="1" selected="selected"><?=$Mem_Enable?></option>
        <option label="<?=$Mem_Disable?>" value="0"><?=$Mem_Disable?></option>
	    </select>      </td>
    </tr>
<?
if($lv=='B'){
?>	
        <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_Corprator?> <?=$Mem_Share?> :</td>
      <td>
       <select name="winloss_b" class="za_select">
	   <?
	    for($i=$abcd;$i>=0;$i=$i-5){
		    $abc=$i;
		    if ($i==100){
			echo "<option value=$abc selected>".($i/10).$wor_percent."</option>\n";
		    }else{
			echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";
		    }
	    }
	   ?>
	</select></td>
    </tr>
<?
}else if($lv=='D'){
?>	
        <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_World?> <?=$Mem_Share?> :</td>
      <td>
       <select name="winloss_c" class="za_select">
	   <?
	    for($i=$abcd;$i>=0;$i=$i-5){
		    $abc=$i;
		    if ($i==0){
			echo "<option value=$abc selected>".($i/10).$wor_percent."</option>\n";
		    }else{
			echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";
		    }
	    }
	   ?>
	</select>      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_Agents?> <?=$Mem_Share?> :</td>
      <td>
       <select name="winloss_d" class="za_select">
	   <?
	    for($i=$abcd;$i>=0;$i=$i-5){
		    $abc=$i;
		    if ($i==0){
			echo "<option value=$abc selected>".($i/10).$wor_percent."</option>\n";
		    }else{
			echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";
		    }
	    }
	   ?>
	</select></td>
    </tr>
<?
}
?>
<?
if ($lv=='A'){
?>
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140">使用天数 :</td>
      <td><input type=TEXT name="usedate" value="0" size=10 maxlength=15 class="za_text" onKeyPress="return CheckKey();"> （0为不限制，1为一天。）</td>
    </tr>
<?
}
?>   
          <input type=hidden name="location" value="" size=10 maxlength=10 class="za_text">
        <tr class="m_bc_ed" align="center">
      <td colspan="2">
        <input type=SUBMIT name="OK" value="<?=$Mem_Confirm?>" class="za_button">
        &nbsp; &nbsp; &nbsp;
        <input type=BUTTON name="FormsButton2" value="<?=$Mem_Cancle?>" id="FormsButton2" onClick="window.location.replace('user_browse.php?uid=<?=$uid?>&lv=<?=$lv?>&enable=Y&langx=<?=$langx?>');" class="za_button">      </td>
    </tr>
  </table>

</form>
<!--iframe name="check_frame" src="" width="0" height="0" style="display:none"></iframe-->
<iframe id="getData" src="" width=0 height=0></iframe>

</body>
</html>
<?
}
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$name',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>