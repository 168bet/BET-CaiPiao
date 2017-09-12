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
$name=$_REQUEST["name"];
$parents_id=$_REQUEST["parents_id"];
$active=$_REQUEST["active"];
$gtype=$_REQUEST["gtype"];
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
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$agent=$row['UserName'];
	
$sql = "select * from web_agents_data where ID=$parents_id";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$username=$row["UserName"];
$admin=$row['Admin'];
$super=$row['Super'];
$corprator=$row['Corprator'];
$world=$row["World"];
$alias=$row["Alias"];

switch ($lv){
case 'A':
    $Title=$Mem_Super;
	$user="$admin";
	$ag="super='$name' and Level='B'";
	$data="web_agents_data";
	$webdata='web_system_data';
	$agname="Super='$username'";
	break;
case 'B':
    $Title=$Mem_Corprator;
	$user="$super";
	$ag="Corprator='$name' and Level='C'";
	$data="web_agents_data";
	$webdata='web_agents_data';
	$agname="Corprator='$username'";
	break;
case 'C':
    $Title=$Mem_World;
	$user="$corprator";
	$ag="World='$name' and Level='D'";
	$data="web_agents_data";
	$webdata='web_agents_data';
	$agname="World='$username'";
	break;
case 'D':
    $Title=$Mem_Agents;
	$user="$world";
	$ag="Agents='$name'";
	$data="web_member_data";
	$webdata='web_agents_data';
	$agname="Agents='$username'";
	break;
}
$loginfo='详细设置'.$Title.':'.$username;
$asql = "select * from $webdata where UserName='$user'";
$aresult = mysql_db_query($dbname,$asql);
$arow = mysql_fetch_array($aresult);

$bsql = "select * from $data where $ag";
$bresult = mysql_db_query($dbname,$bsql);
$brow = mysql_fetch_array($bresult);

if ($active=='edit_conf'){

$rscene=$arow["".$gtype."_R_Scene"];
$ouscene=$arow["".$gtype."_OU_Scene"];
$rescene=$arow["".$gtype."_RE_Scene"];
$rouscene=$arow["".$gtype."_ROU_Scene"];
$rmscene=$arow["".$gtype."_RM_Scene"];
$eoscene=$arow["".$gtype."_EO_Scene"];
$mscene=$arow["".$gtype."_M_Scene"];
$pdscene=$arow["".$gtype."_PD_Scene"];
$tscene=$arow["".$gtype."_T_Scene"];
$fscene=$arow["".$gtype."_F_Scene"];
$pscene=$arow["".$gtype."_P_Scene"];
$prscene=$arow["".$gtype."_PR_Scene"];
$p3scene=$arow["".$gtype."_P3_Scene"];
$fsscene=$arow["FS_FS_Scene"];

$rbet=$arow["".$gtype."_R_Bet"];
$oubet=$arow["".$gtype."_OU_Bet"];
$rebet=$arow["".$gtype."_RE_Bet"];
$roubet=$arow["".$gtype."_ROU_Bet"];
$rmbet=$arow["".$gtype."_RM_Bet"];
$eobet=$arow["".$gtype."_EO_Bet"];
$mbet=$arow["".$gtype."_M_Bet"];
$pdbet=$arow["".$gtype."_PD_Bet"];
$tbet=$arow["".$gtype."_T_Bet"];
$fbet=$arow["".$gtype."_F_Bet"];
$pbet=$arow["".$gtype."_P_Bet"];
$prbet=$arow["".$gtype."_PR_Bet"];
$p3bet=$arow["".$gtype."_P3_Bet"];
$fsbet=$arow["FS_FS_Bet"];

$scascene=$arow["".$gtype."_SCA_Scene"];
$scbscene=$arow["".$gtype."_SCB_Scene"];
$scaascene=$arow["".$gtype."_SCA_AOUEO_Scene"];
$scabscene=$arow["".$gtype."_SCA_BOUEO_Scene"];
$scarbgscene=$arow["".$gtype."_SCA_RBG_Scene"];
$acscene=$arow["".$gtype."_AC_Scene"];
$actscene=$arow["".$gtype."_AC_TOUEO_Scene"];
$ac6ascene=$arow["".$gtype."_AC6_AOUEO_Scene"];
$ac6bscene=$arow["".$gtype."_AC6_BOUEO_Scene"];
$ac6rbgscene=$arow["".$gtype."_AC6_RBG_Scene"];
$sxscene=$arow["".$gtype."_SX_Scene"];
$hwscene=$arow["".$gtype."_HW_Scene"];
$mtscene=$arow["".$gtype."_MT_Scene"];
$ecscene=$arow["".$gtype."_EC_Scene"];

$scabet=$arow["".$gtype."_SCA_Bet"];
$scbbet=$arow["".$gtype."_SCB_Bet"];
$scaabet=$arow["".$gtype."_SCA_AOUEO_Bet"];
$scabbet=$arow["".$gtype."_SCA_BOUEO_Bet"];
$scarbgbet=$arow["".$gtype."_SCA_RBG_Bet"];
$acbet=$arow["".$gtype."_AC_Bet"];
$actbet=$arow["".$gtype."_AC_TOUEO_Bet"];
$ac6abet=$arow["".$gtype."_AC6_AOUEO_Bet"];
$ac6bbet=$arow["".$gtype."_AC6_BOUEO_Bet"];
$ac6rbgbet=$arow["".$gtype."_AC6_RBG_Bet"];
$sxbet=$arow["".$gtype."_SX_Bet"];
$hwbet=$arow["".$gtype."_HW_Bet"];
$mtbet=$arow["".$gtype."_MT_Bet"];
$ecbet=$arow["".$gtype."_EC_Bet"];
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//

$brturna=$brow["".$gtype."_Turn_R_A"];
$brturnb=$brow["".$gtype."_Turn_R_B"];
$brturnc=$brow["".$gtype."_Turn_R_C"];
$brturnd=$brow["".$gtype."_Turn_R_D"];
$bouturna=$brow["".$gtype."_Turn_OU_A"];
$bouturnb=$brow["".$gtype."_Turn_OU_B"];
$bouturnc=$brow["".$gtype."_Turn_OU_C"];
$bouturnd=$brow["".$gtype."_Turn_OU_D"];

$breturna=$brow["".$gtype."_Turn_RE_A"];
$breturnb=$brow["".$gtype."_Turn_RE_B"];
$breturnc=$brow["".$gtype."_Turn_RE_C"];
$breturnd=$brow["".$gtype."_Turn_RE_D"];
$brouturna=$brow["".$gtype."_Turn_ROU_A"];
$brouturnb=$brow["".$gtype."_Turn_ROU_B"];
$brouturnc=$brow["".$gtype."_Turn_ROU_C"];
$brouturnd=$brow["".$gtype."_Turn_ROU_D"];

$beoturna=$brow["".$gtype."_Turn_EO_A"];
$beoturnb=$brow["".$gtype."_Turn_EO_B"];
$beoturnc=$brow["".$gtype."_Turn_EO_C"];
$beoturnd=$brow["".$gtype."_Turn_EO_D"];
$brmturn=$brow["".$gtype."_Turn_RM"];
$bmturn=$brow["".$gtype."_Turn_M"];
$bpdturn=$brow["".$gtype."_Turn_PD"];
$btturn=$brow["".$gtype."_Turn_T"];
$bfturn=$brow["".$gtype."_Turn_F"];
$bpturn=$brow["".$gtype."_Turn_P"];
$bprturn=$brow["".$gtype."_Turn_PR"];
$bp3turn=$brow["".$gtype."_Turn_P3"];
$bfsturn=$brow["FS_Turn_FS"];

$brscene=$brow["".$gtype."_R_Scene"];
$bouscene=$brow["".$gtype."_OU_Scene"];
$brescene=$brow["".$gtype."_RE_Scene"];
$brouscene=$brow["".$gtype."_ROU_Scene"];
$beoscene=$brow["".$gtype."_EO_Scene"];
$brmscene=$brow["".$gtype."_RM_Scene"];
$bmscene=$brow["".$gtype."_M_Scene"];
$bpdscene=$brow["".$gtype."_PD_Scene"];
$btscene=$brow["".$gtype."_T_Scene"];
$bfscene=$brow["".$gtype."_F_Scene"];
$bpscene=$brow["".$gtype."_P_Scene"];
$bprscene=$brow["".$gtype."_PR_Scene"];
$bp3scene=$brow["".$gtype."_P3_Scene"];
$bfsscene=$brow["FS_FS_Scene"];

$brbet=$brow["".$gtype."_R_Bet"];
$boubet=$brow["".$gtype."_OU_Bet"];
$brebet=$brow["".$gtype."_RE_Bet"];
$broubet=$brow["".$gtype."_ROU_Bet"];
$beobet=$brow["".$gtype."_EO_Bet"];
$brmbet=$brow["".$gtype."_RM_Bet"];
$bmbet=$brow["".$gtype."_M_Bet"];
$bpdbet=$brow["".$gtype."_PD_Bet"];
$btbet=$brow["".$gtype."_T_Bet"];
$bfbet=$brow["".$gtype."_F_Bet"];
$bpbet=$brow["".$gtype."_P_Bet"];
$bprbet=$brow["".$gtype."_PR_Bet"];
$bp3bet=$brow["".$gtype."_P3_Bet"];
$bfsbet=$brow["FS_FS_Bet"];

$bscaturna=$brow["".$gtype."_Turn_SCA_A"];
$bscaturnb=$brow["".$gtype."_Turn_SCA_B"];
$bscaturnc=$brow["".$gtype."_Turn_SCA_C"];
$bscaturnd=$brow["".$gtype."_Turn_SCA_D"];

$bscbturna=$brow["".$gtype."_Turn_SCB_A"];
$bscbturnb=$brow["".$gtype."_Turn_SCB_B"];
$bscbturnc=$brow["".$gtype."_Turn_SCB_C"];
$bscbturnd=$brow["".$gtype."_Turn_SCB_D"];

$bscaaturna=$brow["".$gtype."_Turn_SCA_AOUEO_A"];
$bscaaturnb=$brow["".$gtype."_Turn_SCA_AOUEO_B"];
$bscaaturnc=$brow["".$gtype."_Turn_SCA_AOUEO_C"];
$bscaaturnd=$brow["".$gtype."_Turn_SCA_AOUEO_D"];

$bscabturna=$brow["".$gtype."_Turn_SCA_BOUEO_A"];
$bscabturnb=$brow["".$gtype."_Turn_SCA_BOUEO_B"];
$bscabturnc=$brow["".$gtype."_Turn_SCA_BOUEO_C"];
$bscabturnd=$brow["".$gtype."_Turn_SCA_BOUEO_D"];

$bscarbgturna=$brow["".$gtype."_Turn_SCA_RBG_A"];
$bscarbgturnb=$brow["".$gtype."_Turn_SCA_RBG_B"];
$bscarbgturnc=$brow["".$gtype."_Turn_SCA_RBG_C"];
$bscarbgturnd=$brow["".$gtype."_Turn_SCA_RBG_D"];

$bacturna=$brow["".$gtype."_Turn_AC_A"];
$bacturnb=$brow["".$gtype."_Turn_AC_B"];
$bacturnc=$brow["".$gtype."_Turn_AC_C"];
$bacturnd=$brow["".$gtype."_Turn_AC_D"];

$bactturna=$brow["".$gtype."_Turn_AC_TOUEO_A"];
$bactturnb=$brow["".$gtype."_Turn_AC_TOUEO_B"];
$bactturnc=$brow["".$gtype."_Turn_AC_TOUEO_C"];
$bactturnd=$brow["".$gtype."_Turn_AC_TOUEO_D"];

$bac6aturna=$brow["".$gtype."_Turn_AC6_AOUEO_A"];
$bac6aturnb=$brow["".$gtype."_Turn_AC6_AOUEO_B"];
$bac6aturnc=$brow["".$gtype."_Turn_AC6_AOUEO_C"];
$bac6aturnd=$brow["".$gtype."_Turn_AC6_AOUEO_D"];

$bac6bturna=$brow["".$gtype."_Turn_AC6_BOUEO_A"];
$bac6bturnb=$brow["".$gtype."_Turn_AC6_BOUEO_B"];
$bac6bturnc=$brow["".$gtype."_Turn_AC6_BOUEO_C"];
$bac6bturnd=$brow["".$gtype."_Turn_AC6_BOUEO_D"];

$bac6rbgturna=$brow["".$gtype."_Turn_AC6_RBG_A"];
$bac6rbgturnb=$brow["".$gtype."_Turn_AC6_RBG_B"];
$bac6rbgturnc=$brow["".$gtype."_Turn_AC6_RBG_C"];
$bac6rbgturnd=$brow["".$gtype."_Turn_AC6_RBG_D"];

$bsxturna=$brow["".$gtype."_Turn_SX_A"];
$bsxturnb=$brow["".$gtype."_Turn_SX_B"];
$bsxturnc=$brow["".$gtype."_Turn_SX_C"];
$bsxturnd=$brow["".$gtype."_Turn_SX_D"];

$bhwturna=$brow["".$gtype."_Turn_HW_A"];
$bhwturnb=$brow["".$gtype."_Turn_HW_B"];
$bhwturnc=$brow["".$gtype."_Turn_HW_C"];
$bhwturnd=$brow["".$gtype."_Turn_HW_D"];

$bmtturna=$brow["".$gtype."_Turn_MT_A"];
$bmtturnb=$brow["".$gtype."_Turn_MT_B"];
$bmtturnc=$brow["".$gtype."_Turn_MT_C"];
$bmtturnd=$brow["".$gtype."_Turn_MT_D"];

$becturna=$brow["".$gtype."_Turn_EC_A"];
$becturnb=$brow["".$gtype."_Turn_EC_B"];
$becturnc=$brow["".$gtype."_Turn_EC_C"];
$becturnd=$brow["".$gtype."_Turn_EC_D"];

$bscascene=$arow["".$gtype."_SCA_Scene"];
$bscbscene=$arow["".$gtype."_SCB_Scene"];
$bscaascene=$arow["".$gtype."_SCA_AOUEO_Scene"];
$bscabscene=$arow["".$gtype."_SCA_BOUEO_Scene"];
$bscarbgscene=$arow["".$gtype."_SCA_RBG_Scene"];
$bacscene=$arow["".$gtype."_AC_Scene"];
$bactscene=$arow["".$gtype."_AC_TOUEO_Scene"];
$bac6ascene=$arow["".$gtype."_AC6_AOUEO_Scene"];
$bac6bscene=$arow["".$gtype."_AC6_BOUEO_Scene"];
$bac6rbgscene=$arow["".$gtype."_AC6_RBG_Scene"];
$bsxscene=$arow["".$gtype."_SX_Scene"];
$bhwscene=$arow["".$gtype."_HW_Scene"];
$bmtscene=$arow["".$gtype."_MT_Scene"];
$becscene=$arow["".$gtype."_EC_Scene"];

$bscabet=$arow["".$gtype."_SCA_Bet"];
$bscbbet=$arow["".$gtype."_SCB_Bet"];
$bscaabet=$arow["".$gtype."_SCA_AOUEO_Bet"];
$bscabbet=$arow["".$gtype."_SCA_BOUEO_Bet"];
$bscarbgbet=$arow["".$gtype."_SCA_RBG_Bet"];
$bacbet=$arow["".$gtype."_AC_Bet"];
$bactbet=$arow["".$gtype."_AC_TOUEO_Bet"];
$bac6abet=$arow["".$gtype."_AC6_AOUEO_Bet"];
$bac6bbet=$arow["".$gtype."_AC6_BOUEO_Bet"];
$bac6rbgbet=$arow["".$gtype."_AC6_RBG_Bet"];
$bsxbet=$arow["".$gtype."_SX_Bet"];
$bhwbet=$arow["".$gtype."_HW_Bet"];
$bmtbet=$arow["".$gtype."_MT_Bet"];
$becbet=$arow["".$gtype."_EC_Bet"];


	if ($_REQUEST["".$gtype."_R_SC"]>$rscene or $_REQUEST["".$gtype."_OU_SC"]>$ouscene or $_REQUEST["".$gtype."_RE_SC"]>$rescene or $_REQUEST["".$gtype."_ROU_SC"]>$rouscene or $_REQUEST["".$gtype."_EO_SC"]>$eoscene or $_REQUEST["".$gtype."_RM_SC"]>$rmscene or $_REQUEST["".$gtype."_M_SC"]>$mscene or $_REQUEST["".$gtype."_PD_SC"]>$pdscene or $_REQUEST["".$gtype."_T_SC"]>$tscene or $_REQUEST["".$gtype."_F_SC"]>$fscene or $_REQUEST["".$gtype."_P_SC"]>$pscene or $_REQUEST["".$gtype."_PR_SC"]>$prscene or $_REQUEST["".$gtype."_P3_SC"]>$p3scene or $_REQUEST["".$gtype."_SCA_SC"]>$scascene or $_REQUEST["".$gtype."_SCB_SC"]>$scbscene or $_REQUEST["".$gtype."_SCA_AOUEO_SC"]>$scaascene or $_REQUEST["".$gtype."_SCA_BOUEO_SC"]>$scabscene or $_REQUEST["".$gtype."_SCA_RBG_SC"]>$scarbgscene or $_REQUEST["".$gtype."_AC_SC"]>$acscene or $_REQUEST["".$gtype."_AC_TOUEO_SC"]>$actscene or $_REQUEST["".$gtype."_AC6_AOUEO_SC"]>$ac6ascene or $_REQUEST["".$gtype."_AC6_BOUEO_SC"]>$ac6bscene or $_REQUEST["".$gtype."_AC6_RBG_SC"]>$ac6rbgscene or $_REQUEST["".$gtype."_SX_SC"]>$sxscene or $_REQUEST["".$gtype."_HW_SC"]>$hwscene or $_REQUEST["".$gtype."_MT_SC"]>$mtscene or $_REQUEST["".$gtype."_EC_SC"]>$ecscene){
		echo wterror("此 $username 代理商的 单场限额 已超过 $user 代理商的 单场限额，请回上一面重新输入");
		$loginfo='详细设置'.$Title.':'.$username.'单场限额设置失败';
		$ip_addr = get_ip();
		$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$agent',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
		mysql_db_query($dbname,$mysql);
		exit();
	}
	if ($_REQUEST["".$gtype."_R_SO"]>$rbet or $_REQUEST["".$gtype."_OU_SO"]>$oubet or $_REQUEST["".$gtype."_RE_SO"]>$rebet or $_REQUEST["".$gtype."_ROU_SO"]>$roubet or $_REQUEST["".$gtype."_EO_SO"]>$eobet or $_REQUEST["".$gtype."_RM_SO"]>$rmbet or $_REQUEST["".$gtype."_M_SO"]>$mbet or $_REQUEST["".$gtype."_PD_SO"]>$pdbet or $_REQUEST["".$gtype."_T_SO"]>$tbet or $_REQUEST["".$gtype."_F_SO"]>$fbet or $_REQUEST["".$gtype."_P_SO"]>$pbet or $_REQUEST["".$gtype."_PR_SO"]>$prbet or $_REQUEST["".$gtype."_P3_SO"]>$p3bet or $_REQUEST["".$gtype."_SCA_SO"]>$scabet or $_REQUEST["".$gtype."_SCB_SO"]>$scbbet or $_REQUEST["".$gtype."_SCA_AOUEO_SO"]>$scaabet or $_REQUEST["".$gtype."_SCA_BOUEO_SO"]>$scabbet or $_REQUEST["".$gtype."_SCA_RBG_SO"]>$scarbgbet  or $_REQUEST["".$gtype."_AC_SO"]>$acbet or $_REQUEST["".$gtype."_AC_TOUEO_SO"]>$actbet or $_REQUEST["".$gtype."_AC6_AOUEO_SO"]>$ac6abet or $_REQUEST["".$gtype."_AC6_BOUEO_SO"]>$ac6bbet or $_REQUEST["".$gtype."_AC6_RBG_SO"]>$ac6rbgbet or $_REQUEST["".$gtype."_SX_SO"]>$sxbet or $_REQUEST["".$gtype."_HW_SO"]>$hwbet or $_REQUEST["".$gtype."_MT_SO"]>$mtbet or $_REQUEST["".$gtype."_EC_SO"]>$ecbet){
		echo wterror("此 $username 代理商的 单注限额 已超过 $user 代理商的 单注限额，请回上一面重新输入");
		$loginfo='详细设置'.$Title.':'.$username.'单注限额设置失败';
		$ip_addr = get_ip();
		$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$agent',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
		mysql_db_query($dbname,$mysql);
		exit();
	}
switch ($gtype){
case "FT":
if($_REQUEST['FT_Turn_R_A']<$brturna){
    $mysql="update web_agents_data set FT_Turn_R_A=".$_REQUEST['FT_Turn_R_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
    $mysql="update web_member_data set FT_Turn_R=".$_REQUEST['FT_Turn_R_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
}
if($_REQUEST['FT_Turn_R_B']<$brturnb){
    $mysql="update web_agents_data set FT_Turn_R_B=".$_REQUEST['FT_Turn_R_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
	$mysql="update web_member_data set FT_Turn_R=".$_REQUEST['FT_Turn_R_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
}
if($_REQUEST['FT_Turn_R_C']<$brturnc){
    $mysql="update web_agents_data set FT_Turn_R_C=".$_REQUEST['FT_Turn_R_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
	$mysql="update web_member_data set FT_Turn_R=".$_REQUEST['FT_Turn_R_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
}
if($_REQUEST['FT_Turn_R_D']<$brturnd){
    $mysql="update web_agents_data set FT_Turn_R_D=".$_REQUEST['FT_Turn_R_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
	$mysql="update web_member_data set FT_Turn_R=".$_REQUEST['FT_Turn_R_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
}
if($_REQUEST['FT_R_SO']<$brbet){
    $mysql="update web_agents_data set FT_R_Bet=".$_REQUEST['FT_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
	$mysql="update web_member_data set FT_R_Bet=".$_REQUEST['FT_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
}
if($_REQUEST['FT_R_SC']<$brscene){
    $mysql="update web_agents_data set FT_R_Scene=".$_REQUEST['FT_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
	$mysql="update web_member_data set FT_R_Scene=".$_REQUEST['FT_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败R!");
}
if($_REQUEST['FT_Turn_OU_A']<$bouturna){
    $mysql="update web_agents_data set FT_Turn_OU_A=".$_REQUEST['FT_Turn_OU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
	$mysql="update web_member_data set FT_Turn_OU=".$_REQUEST['FT_Turn_OU_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
}
if($_REQUEST['FT_Turn_OU_B']<$bouturnb){
    $mysql="update web_agents_data set FT_Turn_OU_B=".$_REQUEST['FT_Turn_OU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
	$mysql="update web_member_data set FT_Turn_OU=".$_REQUEST['FT_Turn_OU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
}
if($_REQUEST['FT_Turn_OU_C']<$bouturnc){
    $mysql="update web_agents_data set FT_Turn_OU_C=".$_REQUEST['FT_Turn_OU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
	$mysql="update web_member_data set FT_Turn_OU=".$_REQUEST['FT_Turn_OU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
}
if($_REQUEST['FT_Turn_OU_D']<$bouturnd){
    $mysql="update web_agents_data set FT_Turn_OU_D=".$_REQUEST['FT_Turn_OU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
	$mysql="update web_member_data set FT_Turn_OU=".$_REQUEST['FT_Turn_OU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
}
if($_REQUEST['FT_OU_SO']<$boubet){
    $mysql="update web_agents_data set FT_OU_Bet=".$_REQUEST['FT_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
	$mysql="update web_member_data set FT_OU_Bet=".$_REQUEST['FT_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
}
if($_REQUEST['FT_OU_SC']<$bouscene){
    $mysql="update web_agents_data set FT_OU_Scene=".$_REQUEST['FT_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
	$mysql="update web_member_data set FT_OU_Scene=".$_REQUEST['FT_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败OU!");
}
if($_REQUEST['FT_Turn_RE_A']<$breturna){
    $mysql="update web_agents_data set FT_Turn_RE_A=".$_REQUEST['FT_Turn_RE_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
	$mysql="update web_member_data set FT_Turn_RE=".$_REQUEST['FT_Turn_RE_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
}
if($_REQUEST['FT_Turn_RE_B']<$breturnb){
    $mysql="update web_agents_data set FT_Turn_RE_B=".$_REQUEST['FT_Turn_RE_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
	$mysql="update web_member_data set FT_Turn_RE=".$_REQUEST['FT_Turn_RE_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
}
if($_REQUEST['FT_Turn_RE_C']<$breturnc){
    $mysql="update web_agents_data set FT_Turn_RE_C=".$_REQUEST['FT_Turn_RE_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
	$mysql="update web_member_data set FT_Turn_RE=".$_REQUEST['FT_Turn_RE_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
}
if($_REQUEST['FT_Turn_RE_D']<$breturnd){
    $mysql="update web_agents_data set FT_Turn_RE_D=".$_REQUEST['FT_Turn_RE_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
	$mysql="update web_member_data set FT_Turn_RE=".$_REQUEST['FT_Turn_RE_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
}
if($_REQUEST['FT_RE_SO']<$brebet){
    $mysql="update web_agents_data set FT_RE_Bet=".$_REQUEST['FT_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
	$mysql="update web_member_data set FT_RE_Bet=".$_REQUEST['FT_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
}
if($_REQUEST['FT_RE_SC']<$brescene){
    $mysql="update web_agents_data set FT_RE_Scene=".$_REQUEST['FT_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
	$mysql="update web_member_data set FT_RE_Scene=".$_REQUEST['FT_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RE!");
}
if($_REQUEST['FT_Turn_ROU_A']<$brouturna){
    $mysql="update web_agents_data set FT_Turn_ROU_A=".$_REQUEST['FT_Turn_ROU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
	$mysql="update web_member_data set FT_Turn_ROU=".$_REQUEST['FT_Turn_ROU_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
}
if($_REQUEST['FT_Turn_ROU_B']<$brouturnb){
    $mysql="update web_agents_data set FT_Turn_ROU_B=".$_REQUEST['FT_Turn_ROU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
	$mysql="update web_member_data set FT_Turn_ROU=".$_REQUEST['FT_Turn_ROU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
}
if($_REQUEST['FT_Turn_ROU_C']<$brouturnc){
    $mysql="update web_agents_data set FT_Turn_ROU_C=".$_REQUEST['FT_Turn_ROU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
	$mysql="update web_member_data set FT_Turn_ROU=".$_REQUEST['FT_Turn_ROU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
}
if($_REQUEST['FT_Turn_ROU_D']<$brouturnd){
    $mysql="update web_agents_data set FT_Turn_ROU_D=".$_REQUEST['FT_Turn_ROU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
	$mysql="update web_member_data set FT_Turn_ROU=".$_REQUEST['FT_Turn_ROU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
}
if($_REQUEST['FT_ROU_SO']<$broubet){
    $mysql="update web_agents_data set FT_ROU_Bet=".$_REQUEST['FT_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
	$mysql="update web_member_data set FT_ROU_Bet=".$_REQUEST['FT_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
}
if($_REQUEST['FT_ROU_SC']<$brouscene){
    $mysql="update web_agents_data set FT_ROU_Scene=".$_REQUEST['FT_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
	$mysql="update web_member_data set FT_ROU_Scene=".$_REQUEST['FT_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败ROU!");
}
if($_REQUEST['FT_Turn_EO_A']<$beoturna){
    $mysql="update web_agents_data set FT_Turn_EO_A=".$_REQUEST['FT_Turn_EO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
	$mysql="update web_member_data set FT_Turn_EO=".$_REQUEST['FT_Turn_EO_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
}
if($_REQUEST['FT_Turn_EO_B']<$beoturnb){
    $mysql="update web_agents_data set FT_Turn_EO_B=".$_REQUEST['FT_Turn_EO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
	$mysql="update web_member_data set FT_Turn_EO=".$_REQUEST['FT_Turn_EO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
}
if($_REQUEST['FT_Turn_EO_C']<$beoturnc){
    $mysql="update web_agents_data set FT_Turn_EO_C=".$_REQUEST['FT_Turn_EO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
	$mysql="update web_member_data set FT_Turn_EO=".$_REQUEST['FT_Turn_EO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
}
if($_REQUEST['FT_Turn_EO_D']<$beoturnd){
    $mysql="update web_agents_data set FT_Turn_EO_D=".$_REQUEST['FT_Turn_EO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
	$mysql="update web_member_data set FT_Turn_EO=".$_REQUEST['FT_Turn_EO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
}
if($_REQUEST['FT_EO_SO']<$beobet){
    $mysql="update web_agents_data set FT_EO_Bet=".$_REQUEST['FT_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
	$mysql="update web_member_data set FT_EO_Bet=".$_REQUEST['FT_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
}
if($_REQUEST['FT_EO_SC']<$beoscene){
    $mysql="update web_agents_data set FT_EO_Scene=".$_REQUEST['FT_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
	$mysql="update web_member_data set FT_EO_Scene=".$_REQUEST['FT_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败EO!");
}
if($_REQUEST['FT_Turn_RM']<$brmturn){
    $mysql="update web_agents_data set FT_Turn_RM=".$_REQUEST['FT_Turn_RM']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RM!");
	$mysql="update web_member_data set FT_Turn_RM=".$_REQUEST['FT_Turn_RM']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RM!");
}
if($_REQUEST['FT_RM_SO']<$brmbet){
    $mysql="update web_agents_data set FT_RM_Bet=".$_REQUEST['FT_RM_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RM!");
	$mysql="update web_member_data set FT_RM_Bet=".$_REQUEST['FT_RM_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RM!");
}
if($_REQUEST['FT_RM_SC']<$brmscene){
    $mysql="update web_agents_data set FT_RM_Scene=".$_REQUEST['FT_RM_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RM!");
	$mysql="update web_member_data set FT_RM_Scene=".$_REQUEST['FT_RM_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RM!");
}
if($_REQUEST['FT_Turn_M']<$bmturn){
    $mysql="update web_agents_data set FT_Turn_M=".$_REQUEST['FT_Turn_M']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RM!");
	$mysql="update web_member_data set FT_Turn_M=".$_REQUEST['FT_Turn_M']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败RM!");
}
if($_REQUEST['FT_M_SO']<$bmbet){
    $mysql="update web_agents_data set FT_M_Bet=".$_REQUEST['FT_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败M!");
	$mysql="update web_member_data set FT_M_Bet=".$_REQUEST['FT_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败M!");
}
if($_REQUEST['FT_M_SC']<$bmscene){
    $mysql="update web_agents_data set FT_M_Scene=".$_REQUEST['FT_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败M!");
	$mysql="update web_member_data set FT_M_Scene=".$_REQUEST['FT_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败M!");
}
if($_REQUEST['FT_Turn_PD']<$bpdturn){
    $mysql="update web_agents_data set FT_Turn_PD=".$_REQUEST['FT_Turn_PD']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PD!");
	$mysql="update web_member_data set FT_Turn_PD=".$_REQUEST['FT_Turn_PD']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PD!");
}
if($_REQUEST['FT_PD_SO']<$bpdbet){
    $mysql="update web_agents_data set FT_PD_Bet=".$_REQUEST['FT_PD_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PD!");
	$mysql="update web_member_data set FT_PD_Bet=".$_REQUEST['FT_PD_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PD!");
}
if($_REQUEST['FT_PD_SC']<$bpdscene){
    $mysql="update web_agents_data set FT_PD_Scene=".$_REQUEST['FT_PD_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PD!");
	$mysql="update web_member_data set FT_PD_Scene=".$_REQUEST['FT_PD_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PD!");
}
if($_REQUEST['FT_Turn_T']<$btturn){
    $mysql="update web_agents_data set FT_Turn_T=".$_REQUEST['FT_Turn_T']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败T!");
	$mysql="update web_member_data set FT_Turn_T=".$_REQUEST['FT_Turn_T']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败T!");
}
if($_REQUEST['FT_T_SO']<$btbet){
    $mysql="update web_agents_data set FT_T_Bet=".$_REQUEST['FT_T_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败T!");
	$mysql="update web_member_data set FT_T_Bet=".$_REQUEST['FT_T_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败T!");
}
if($_REQUEST['FT_T_SC']<$btscene){
    $mysql="update web_agents_data set FT_T_Scene=".$_REQUEST['FT_T_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败T!");
	$mysql="update web_member_data set FT_T_Scene=".$_REQUEST['FT_T_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败T!");
}
if($_REQUEST['FT_Turn_F']<$bfturn){
    $mysql="update web_agents_data set FT_Turn_F=".$_REQUEST['FT_Turn_F']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败F!");
	$mysql="update web_member_data set FT_Turn_F=".$_REQUEST['FT_Turn_F']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败F!");
}
if($_REQUEST['FT_F_SO']<$bfbet){
    $mysql="update web_agents_data set FT_F_Bet=".$_REQUEST['FT_F_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败F!");
	$mysql="update web_member_data set FT_F_Bet=".$_REQUEST['FT_F_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败F!");
}
if($_REQUEST['FT_F_SC']<$bfscene){
    $mysql="update web_agents_data set FT_F_Scene=".$_REQUEST['FT_F_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败F!");
	$mysql="update web_member_data set FT_F_Scene=".$_REQUEST['FT_F_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败F!");
}
if($_REQUEST['FT_Turn_P']<$bpturn){
    $mysql="update web_agents_data set FT_Turn_P=".$_REQUEST['FT_Turn_P']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P_Turn!");
	$mysql="update web_member_data set FT_Turn_P=".$_REQUEST['FT_Turn_P']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P_Turn!");
}
if($_REQUEST['FT_P_SO']<$bpbet){
    $mysql="update web_agents_data set FT_P_Bet=".$_REQUEST['FT_P_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P_SO!");
	$mysql="update web_member_data set FT_P_Bet=".$_REQUEST['FT_P_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P_SO!");
}
if($_REQUEST['FT_P_SC']<$bpscene){
    $mysql="update web_agents_data set FT_P_Scene=".$_REQUEST['FT_P_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P_SC!");
	$mysql="update web_member_data set FT_P_Scene=".$_REQUEST['FT_P_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P_SC!");
}
if($_REQUEST['FT_Turn_PR']<$bprturn){
    $mysql="update web_agents_data set FT_Turn_PR=".$_REQUEST['FT_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PR_Turn!");
	$mysql="update web_member_data set FT_Turn_PR=".$_REQUEST['FT_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PR_Turn!");
}
if($_REQUEST['FT_PR_SO']<$bprbet){
    $mysql="update web_agents_data set FT_PR_Bet=".$_REQUEST['FT_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PR_SO!");
	$mysql="update web_member_data set FT_PR_Bet=".$_REQUEST['FT_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PR_SO!");
}
if($_REQUEST['FT_PR_SC']<$bprscene){
    $mysql="update web_agents_data set FT_PR_Scene=".$_REQUEST['FT_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PR_SC!");
	$mysql="update web_member_data set FT_PR_Scene=".$_REQUEST['FT_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败PR_SC!");
}
if($_REQUEST['FT_Turn_P3']<$bp3turn){
    $mysql="update web_agents_data set FT_Turn_P3=".$_REQUEST['FT_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P3_Turn!");
	$mysql="update web_member_data set FT_Turn_P3=".$_REQUEST['FT_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P3_Turn!");
}
if($_REQUEST['FT_P3_SO']<$bp3bet){
    $mysql="update web_agents_data set FT_P3_Bet=".$_REQUEST['FT_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P3_SO!");
	$mysql="update web_member_data set FT_P3_Bet=".$_REQUEST['FT_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P3_SO!");
}
if($_REQUEST['FT_P3_SC']<$bp3scene){
    $mysql="update web_agents_data set FT_P3_Scene=".$_REQUEST['FT_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P3_SC!");
	$mysql="update web_member_data set FT_P3_Scene=".$_REQUEST['FT_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FT代理操作失败P3_SC!");
}

	$mysql="update web_agents_data set FT_Turn_R_A=".$_REQUEST['FT_Turn_R_A'].",FT_Turn_R_B=".$_REQUEST['FT_Turn_R_B'].",FT_Turn_R_C=".$_REQUEST['FT_Turn_R_C'].",FT_Turn_R_D=".$_REQUEST['FT_Turn_R_D'].",FT_R_Bet=".$_REQUEST['FT_R_SO'].",FT_R_Scene=".$_REQUEST['FT_R_SC'].",FT_Turn_OU_A=".$_REQUEST['FT_Turn_OU_A'].",FT_Turn_OU_B=".$_REQUEST['FT_Turn_OU_B'].",FT_Turn_OU_C=".$_REQUEST['FT_Turn_OU_C'].",FT_Turn_OU_D=".$_REQUEST['FT_Turn_OU_D'].",FT_OU_Bet=".$_REQUEST['FT_OU_SO'].",FT_OU_Scene=".$_REQUEST['FT_OU_SC'].",FT_Turn_RE_A=".$_REQUEST['FT_Turn_RE_A'].",FT_Turn_RE_B=".$_REQUEST['FT_Turn_RE_B'].",FT_Turn_RE_C=".$_REQUEST['FT_Turn_RE_C'].",FT_Turn_RE_D=".$_REQUEST['FT_Turn_RE_D'].",FT_RE_Bet=".$_REQUEST['FT_RE_SO'].",FT_RE_Scene=".$_REQUEST['FT_RE_SC'].",FT_Turn_ROU_A=".$_REQUEST['FT_Turn_ROU_A'].",FT_Turn_ROU_B=".$_REQUEST['FT_Turn_ROU_B'].",FT_Turn_ROU_C=".$_REQUEST['FT_Turn_ROU_C'].",FT_Turn_ROU_D=".$_REQUEST['FT_Turn_ROU_D'].",FT_ROU_Bet=".$_REQUEST['FT_ROU_SO'].",FT_ROU_Scene=".$_REQUEST['FT_ROU_SC'].",FT_Turn_EO_A=".$_REQUEST['FT_Turn_EO_A'].",FT_Turn_EO_B=".$_REQUEST['FT_Turn_EO_B'].",FT_Turn_EO_C=".$_REQUEST['FT_Turn_EO_C'].",FT_Turn_EO_D=".$_REQUEST['FT_Turn_EO_D'].",FT_EO_Bet=".$_REQUEST['FT_EO_SO'].",FT_EO_Scene=".$_REQUEST['FT_EO_SC'].",FT_Turn_RM=".$_REQUEST['FT_Turn_RM'].",FT_RM_Bet=".$_REQUEST['FT_RM_SO'].",FT_RM_Scene=".$_REQUEST['FT_RM_SC'].",FT_Turn_M=".$_REQUEST['FT_Turn_M'].",FT_M_Bet=".$_REQUEST['FT_M_SO'].",FT_M_Scene=".$_REQUEST['FT_M_SC'].",FT_Turn_PD=".$_REQUEST['FT_Turn_PD'].",FT_PD_Bet=".$_REQUEST['FT_PD_SO'].",FT_PD_Scene=".$_REQUEST['FT_PD_SC'].",FT_Turn_T=".$_REQUEST['FT_Turn_T'].",FT_T_Bet=".$_REQUEST['FT_T_SO'].",FT_T_Scene=".$_REQUEST['FT_T_SC'].",FT_Turn_F=".$_REQUEST['FT_Turn_F'].",FT_F_Bet=".$_REQUEST['FT_F_SO'].",FT_F_Scene=".$_REQUEST['FT_F_SC'].",FT_Turn_P=".$_REQUEST['FT_Turn_P'].",FT_P_Bet=".$_REQUEST['FT_P_SO'].",FT_P_Scene=".$_REQUEST['FT_P_SC'].",FT_Turn_PR=".$_REQUEST['FT_Turn_PR'].",FT_PR_Bet=".$_REQUEST['FT_PR_SO'].",FT_PR_Scene=".$_REQUEST['FT_PR_SC'].",FT_Turn_P3=".$_REQUEST['FT_Turn_P3'].",FT_P3_Bet=".$_REQUEST['FT_P3_SO'].",FT_P3_Scene=".$_REQUEST['FT_P3_SC']." where ID='$parents_id'";
	mysql_db_query($dbname,$mysql) or die ("FT操作失败!!");
	$loginfo='详细设置'.$Title.':'.$username.' 足球详细设置成功';
	echo "<Script Language=javascript>self.location='user_set.php?uid=$uid&lv=$lv&parents_id=$parents_id&name=$name&langx=$langx';</script>";
	break;
case "BK":
if($_REQUEST['BK_Turn_R_A']<$brturna){
    $mysql="update web_agents_data set BK_Turn_R_A=".$_REQUEST['BK_Turn_R_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
    $mysql="update web_member_data set BK_Turn_R=".$_REQUEST['BK_Turn_R_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_R_B']<$brturnb){
    $mysql="update web_agents_data set BK_Turn_R_B=".$_REQUEST['BK_Turn_R_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_R=".$_REQUEST['BK_Turn_R_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_R_C']<$brturnc){
    $mysql="update web_agents_data set BK_Turn_R_C=".$_REQUEST['BK_Turn_R_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_R=".$_REQUEST['BK_Turn_R_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_R_D']<$brturnd){
    $mysql="update web_agents_data set BK_Turn_R_D=".$_REQUEST['BK_Turn_R_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_R=".$_REQUEST['BK_Turn_R_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_R_SO']<$brbet){
    $mysql="update web_agents_data set BK_R_Bet=".$_REQUEST['BK_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_R_Bet=".$_REQUEST['BK_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_R_SC']<$brscene){
    $mysql="update web_agents_data set BK_R_Scene=".$_REQUEST['BK_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
	$mysql="update web_member_data set BK_R_Scene=".$_REQUEST['BK_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
}
if($_REQUEST['BK_Turn_OU_A']<$bouturna){
    $mysql="update web_agents_data set BK_Turn_OU_A=".$_REQUEST['BK_Turn_OU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_OU=".$_REQUEST['BK_Turn_OU_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_OU_B']<$bouturnb){
    $mysql="update web_agents_data set BK_Turn_OU_B=".$_REQUEST['BK_Turn_OU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_OU=".$_REQUEST['BK_Turn_OU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_OU_C']<$bouturnc){
    $mysql="update web_agents_data set BK_Turn_OU_C=".$_REQUEST['BK_Turn_OU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_OU=".$_REQUEST['BK_Turn_OU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_OU_D']<$bouturnd){
    $mysql="update web_agents_data set BK_Turn_OU_D=".$_REQUEST['BK_Turn_OU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_OU=".$_REQUEST['BK_Turn_OU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_OU_SO']<$boubet){
    $mysql="update web_agents_data set BK_OU_Bet=".$_REQUEST['BK_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_OU_Bet=".$_REQUEST['BK_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_OU_SC']<$bouscene){
    $mysql="update web_agents_data set BK_OU_Scene=".$_REQUEST['BK_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
	$mysql="update web_member_data set BK_OU_Scene=".$_REQUEST['BK_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
}
if($_REQUEST['BK_Turn_RE_A']<$breturna){
    $mysql="update web_agents_data set BK_Turn_RE_A=".$_REQUEST['BK_Turn_RE_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_RE=".$_REQUEST['BK_Turn_RE_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_RE_B']<$breturnb){
    $mysql="update web_agents_data set BK_Turn_RE_B=".$_REQUEST['BK_Turn_RE_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_RE=".$_REQUEST['BK_Turn_RE_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_RE_C']<$breturnc){
    $mysql="update web_agents_data set BK_Turn_RE_C=".$_REQUEST['BK_Turn_RE_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_RE=".$_REQUEST['BK_Turn_RE_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_RE_D']<$breturnd){
    $mysql="update web_agents_data set BK_Turn_RE_D=".$_REQUEST['BK_Turn_RE_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_RE=".$_REQUEST['BK_Turn_RE_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_RE_SO']<$brebet){
    $mysql="update web_agents_data set BK_RE_Bet=".$_REQUEST['BK_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_RE_Bet=".$_REQUEST['BK_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_RE_SC']<$brescene){
    $mysql="update web_agents_data set BK_RE_Scene=".$_REQUEST['BK_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
	$mysql="update web_member_data set BK_RE_Scene=".$_REQUEST['BK_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
}
if($_REQUEST['BK_Turn_ROU_A']<$brouturna){
    $mysql="update web_agents_data set BK_Turn_ROU_A=".$_REQUEST['BK_Turn_ROU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_ROU=".$_REQUEST['BK_Turn_ROU_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_ROU_B']<$brouturnb){
    $mysql="update web_agents_data set BK_Turn_ROU_B=".$_REQUEST['BK_Turn_ROU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_ROU=".$_REQUEST['BK_Turn_ROU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_ROU_C']<$brouturnc){
    $mysql="update web_agents_data set BK_Turn_ROU_C=".$_REQUEST['BK_Turn_ROU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_ROU=".$_REQUEST['BK_Turn_ROU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_ROU_D']<$brouturnd){
    $mysql="update web_agents_data set BK_Turn_ROU_D=".$_REQUEST['BK_Turn_ROU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_ROU=".$_REQUEST['BK_Turn_ROU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_ROU_SO']<$broubet){
    $mysql="update web_agents_data set BK_ROU_Bet=".$_REQUEST['BK_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_ROU_Bet=".$_REQUEST['BK_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_ROU_SC']<$brouscene){
    $mysql="update web_agents_data set BK_ROU_Scene=".$_REQUEST['BK_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
	$mysql="update web_member_data set BK_ROU_Scene=".$_REQUEST['BK_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
}
if($_REQUEST['BK_Turn_EO_A']<$beoturna){
    $mysql="update web_agents_data set BK_Turn_EO_A=".$_REQUEST['BK_Turn_EO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_EO=".$_REQUEST['BK_Turn_EO_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_EO_B']<$beoturnb){
    $mysql="update web_agents_data set BK_Turn_EO_B=".$_REQUEST['BK_Turn_EO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_EO=".$_REQUEST['BK_Turn_EO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_EO_C']<$beoturnc){
    $mysql="update web_agents_data set BK_Turn_EO_C=".$_REQUEST['BK_Turn_EO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_EO=".$_REQUEST['BK_Turn_EO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_EO_D']<$beoturnd){
    $mysql="update web_agents_data set BK_Turn_EO_D=".$_REQUEST['BK_Turn_EO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_EO=".$_REQUEST['BK_Turn_EO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_EO_SO']<$beobet){
    $mysql="update web_agents_data set BK_EO_Bet=".$_REQUEST['BK_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_EO_Bet=".$_REQUEST['BK_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_EO_SC']<$beoscene){
    $mysql="update web_agents_data set BK_EO_Scene=".$_REQUEST['BK_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
	$mysql="update web_member_data set BK_EO_Scene=".$_REQUEST['BK_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
}
if($_REQUEST['BK_Turn_PR']<$bprturn){
    $mysql="update web_agents_data set BK_Turn_PR=".$_REQUEST['BK_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_PR=".$_REQUEST['BK_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_PR_SO']<$bprbet){
    $mysql="update web_agents_data set BK_PR_Bet=".$_REQUEST['BK_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_PR_Bet=".$_REQUEST['BK_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_PR_SC']<$bprscene){
    $mysql="update web_agents_data set BK_PR_Scene=".$_REQUEST['BK_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_PR_Scene=".$_REQUEST['BK_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_Turn_P3']<$bp3turn){
    $mysql="update web_agents_data set BK_Turn_P3=".$_REQUEST['BK_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_Turn_P3=".$_REQUEST['BK_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_P3_SO']<$bp3bet){
    $mysql="update web_agents_data set BK_P3_Bet=".$_REQUEST['BK_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
	$mysql="update web_member_data set BK_P3_Bet=".$_REQUEST['BK_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败1!");
}
if($_REQUEST['BK_P3_SC']<$bp3scene){
    $mysql="update web_agents_data set BK_P3_Scene=".$_REQUEST['BK_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
	$mysql="update web_member_data set BK_P3_Scene=".$_REQUEST['BK_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BK代理操作失败2!");
}
if($_REQUEST['FS_Turn_FS']<$fsrturn){
    $mysql="update web_agents_data set FS_Turn_FS=".$_REQUEST['FS_Turn_FS']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FS代理操作失败1!");
	$mysql="update web_member_data set FS_Turn_FS=".$_REQUEST['FS_Turn_FS']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FS代理操作失败1!");
}
if($_REQUEST['FS_FS_SO']<$bfsbet){
    $mysql="update web_agents_data set FS_FS_Bet=".$_REQUEST['FS_FS_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FS代理操作失败1!");
	$mysql="update web_member_data set FS_FS_Bet=".$_REQUEST['FS_FS_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FS代理操作失败1!");
}
if($_REQUEST['FS_FS_SC']<$bfsscene){
    $mysql="update web_agents_data set FS_FS_Scene=".$_REQUEST['FS_FS_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FS代理操作失败2!");
	$mysql="update web_member_data set FS_FS_Scene=".$_REQUEST['FS_FS_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("FS代理操作失败2!");
}
	$mysql="update web_agents_data set BK_Turn_R_A=".$_REQUEST['BK_Turn_R_A'].",BK_Turn_R_B=".$_REQUEST['BK_Turn_R_B'].",BK_Turn_R_C=".$_REQUEST['BK_Turn_R_C'].",BK_Turn_R_D=".$_REQUEST['BK_Turn_R_D'].",BK_R_Bet=".$_REQUEST['BK_R_SO'].",BK_R_Scene=".$_REQUEST['BK_R_SC'].",BK_Turn_OU_A=".$_REQUEST['BK_Turn_OU_A'].",BK_Turn_OU_B=".$_REQUEST['BK_Turn_OU_B'].",BK_Turn_OU_C=".$_REQUEST['BK_Turn_OU_C'].",BK_Turn_OU_D=".$_REQUEST['BK_Turn_OU_D'].",BK_OU_Bet=".$_REQUEST['BK_OU_SO'].",BK_OU_Scene=".$_REQUEST['BK_OU_SC'].",BK_Turn_RE_A=".$_REQUEST['BK_Turn_RE_A'].",BK_Turn_RE_B=".$_REQUEST['BK_Turn_RE_B'].",BK_Turn_RE_C=".$_REQUEST['BK_Turn_RE_C'].",BK_Turn_RE_D=".$_REQUEST['BK_Turn_RE_D'].",BK_RE_Bet=".$_REQUEST['BK_RE_SO'].",BK_RE_Scene=".$_REQUEST['BK_RE_SC'].",BK_Turn_ROU_A=".$_REQUEST['BK_Turn_ROU_A'].",BK_Turn_ROU_B=".$_REQUEST['BK_Turn_ROU_B'].",BK_Turn_ROU_C=".$_REQUEST['BK_Turn_ROU_C'].",BK_Turn_ROU_D=".$_REQUEST['BK_Turn_ROU_D'].",BK_ROU_Bet=".$_REQUEST['BK_ROU_SO'].",BK_ROU_Scene=".$_REQUEST['BK_ROU_SC'].",BK_Turn_EO_A=".$_REQUEST['BK_Turn_EO_A'].",BK_Turn_EO_B=".$_REQUEST['BK_Turn_EO_B'].",BK_Turn_EO_C=".$_REQUEST['BK_Turn_EO_C'].",BK_Turn_EO_D=".$_REQUEST['BK_Turn_EO_D'].",BK_EO_Bet=".$_REQUEST['BK_EO_SO'].",BK_EO_Scene=".$_REQUEST['BK_EO_SC'].",BK_Turn_PR=".$_REQUEST['BK_Turn_PR'].",BK_PR_Bet=".$_REQUEST['BK_PR_SO'].",BK_PR_Scene=".$_REQUEST['BK_PR_SC'].",BK_Turn_P3=".$_REQUEST['BK_Turn_P3'].",BK_P3_Bet=".$_REQUEST['BK_P3_SO'].",BK_P3_Scene=".$_REQUEST['BK_P3_SC'].",FS_Turn_FS=".$_REQUEST['FS_Turn_FS'].",FS_FS_Bet=".$_REQUEST['FS_FS_SO'].",FS_FS_Scene=".$_REQUEST['FS_FS_SC']." where ID='$parents_id'";
	mysql_db_query($dbname,$mysql) or die ("BK操作失败!!");
	$loginfo='详细设置'.$Title.':'.$username.' 篮球详细设置成功';
	echo "<Script Language=javascript>self.location='user_set.php?uid=$uid&lv=$lv&parents_id=$parents_id&name=$name&langx=$langx';</script>";		
	break;
case "BS":
if($_REQUEST['BS_Turn_R_A']<$brturna){
    $mysql="update web_agents_data set BS_Turn_R_A=".$_REQUEST['BS_Turn_R_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
    $mysql="update web_member_data set BS_Turn_R=".$_REQUEST['BS_Turn_R_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_R_B']<$brturnb){
    $mysql="update web_agents_data set BS_Turn_R_B=".$_REQUEST['BS_Turn_R_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_R=".$_REQUEST['BS_Turn_R_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_R_C']<$brturnc){
    $mysql="update web_agents_data set BS_Turn_R_C=".$_REQUEST['BS_Turn_R_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_R=".$_REQUEST['BS_Turn_R_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_R_D']<$brturnd){
    $mysql="update web_agents_data set BS_Turn_R_D=".$_REQUEST['BS_Turn_R_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_R=".$_REQUEST['BS_Turn_R_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_R_SO']<$brbet){
    $mysql="update web_agents_data set BS_R_Bet=".$_REQUEST['BS_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_R_Bet=".$_REQUEST['BS_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_R_SC']<$brscene){
    $mysql="update web_agents_data set BS_R_Scene=".$_REQUEST['BS_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败2!");
	$mysql="update web_member_data set BS_R_Scene=".$_REQUEST['BS_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败2!");
}
if($_REQUEST['BS_Turn_OU_A']<$bouturna){
    $mysql="update web_agents_data set BS_Turn_OU_A=".$_REQUEST['BS_Turn_OU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_OU=".$_REQUEST['BS_Turn_OU_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_OU_B']<$bouturnb){
    $mysql="update web_agents_data set BS_Turn_OU_B=".$_REQUEST['BS_Turn_OU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_OU=".$_REQUEST['BS_Turn_OU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_OU_C']<$bouturnc){
    $mysql="update web_agents_data set BS_Turn_OU_C=".$_REQUEST['BS_Turn_OU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_OU=".$_REQUEST['BS_Turn_OU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_OU_D']<$bouturnd){
    $mysql="update web_agents_data set BS_Turn_OU_D=".$_REQUEST['BS_Turn_OU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_OU=".$_REQUEST['BS_Turn_OU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_OU_SO']<$boubet){
    $mysql="update web_agents_data set BS_OU_Bet=".$_REQUEST['BS_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_OU_Bet=".$_REQUEST['BS_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_OU_SC']<$bouscene){
    $mysql="update web_agents_data set BS_OU_Scene=".$_REQUEST['BS_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败2!");
	$mysql="update web_member_data set BS_OU_Scene=".$_REQUEST['BS_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败2!");
}
if($_REQUEST['BS_Turn_RE_A']<$breturna){
    $mysql="update web_agents_data set BS_Turn_RE_A=".$_REQUEST['BS_Turn_RE_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_RE=".$_REQUEST['BS_Turn_RE_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_RE_B']<$breturnb){
    $mysql="update web_agents_data set BS_Turn_RE_B=".$_REQUEST['BS_Turn_RE_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_RE=".$_REQUEST['BS_Turn_RE_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_RE_C']<$breturnc){
    $mysql="update web_agents_data set BS_Turn_RE_C=".$_REQUEST['BS_Turn_RE_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_RE=".$_REQUEST['BS_Turn_RE_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_RE_D']<$breturnd){
    $mysql="update web_agents_data set BS_Turn_RE_D=".$_REQUEST['BS_Turn_RE_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_RE=".$_REQUEST['BS_Turn_RE_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_RE_SO']<$brebet){
    $mysql="update web_agents_data set BS_RE_Bet=".$_REQUEST['BS_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_RE_Bet=".$_REQUEST['BS_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_RE_SC']<$brescene){
    $mysql="update web_agents_data set BS_RE_Scene=".$_REQUEST['BS_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败2!");
	$mysql="update web_member_data set BS_RE_Scene=".$_REQUEST['BS_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败2!");
}
if($_REQUEST['BS_Turn_ROU_A']<$brouturna){
    $mysql="update web_agents_data set BS_Turn_ROU_A=".$_REQUEST['BS_Turn_ROU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_ROU=".$_REQUEST['BS_Turn_ROU_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_ROU_B']<$brouturnb){
    $mysql="update web_agents_data set BS_Turn_ROU_B=".$_REQUEST['BS_Turn_ROU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_ROU=".$_REQUEST['BS_Turn_ROU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_ROU_C']<$brouturnc){
    $mysql="update web_agents_data set BS_Turn_ROU_C=".$_REQUEST['BS_Turn_ROU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_ROU=".$_REQUEST['BS_Turn_ROU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_ROU_D']<$brouturnd){
    $mysql="update web_agents_data set BS_Turn_ROU_D=".$_REQUEST['BS_Turn_ROU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_ROU=".$_REQUEST['BS_Turn_ROU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_ROU_SO']<$broubet){
    $mysql="update web_agents_data set BS_ROU_Bet=".$_REQUEST['BS_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_ROU_Bet=".$_REQUEST['BS_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_ROU_SC']<$brouscene){
    $mysql="update web_agents_data set BS_ROU_Scene=".$_REQUEST['BS_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败2!");
	$mysql="update web_member_data set BS_ROU_Scene=".$_REQUEST['BS_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败2!");
}
if($_REQUEST['BS_Turn_EO_A']<$beoturna){
    $mysql="update web_agents_data set BS_Turn_EO_A=".$_REQUEST['BS_Turn_EO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_EO=".$_REQUEST['BS_Turn_EO_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_EO_B']<$beoturnb){
    $mysql="update web_agents_data set BS_Turn_EO_B=".$_REQUEST['BS_Turn_EO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_EO=".$_REQUEST['BS_Turn_EO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_EO_C']<$beoturnc){
    $mysql="update web_agents_data set BS_Turn_EO_C=".$_REQUEST['BS_Turn_EO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_EO=".$_REQUEST['BS_Turn_EO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_Turn_EO_D']<$beoturnd){
    $mysql="update web_agents_data set BS_Turn_EO_D=".$_REQUEST['BS_Turn_EO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_Turn_EO=".$_REQUEST['BS_Turn_EO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_EO_SO']<$beobet){
    $mysql="update web_agents_data set BS_EO_Bet=".$_REQUEST['BS_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
	$mysql="update web_member_data set BS_EO_Bet=".$_REQUEST['BS_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败1!");
}
if($_REQUEST['BS_EO_SC']<$beoscene){
    $mysql="update web_agents_data set BS_EO_Scene=".$_REQUEST['BS_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败2!");
	$mysql="update web_member_data set BS_EO_Scene=".$_REQUEST['BS_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败2!");
}
if($_REQUEST['BS_Turn_M']<$bmturn){
    $mysql="update web_agents_data set BS_Turn_M=".$_REQUEST['BS_Turn_M']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败M!");
	$mysql="update web_member_data set BS_Turn_M=".$_REQUEST['BS_Turn_M']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败M!");
}
if($_REQUEST['BS_M_SO']<$bmbet){
    $mysql="update web_agents_data set BS_M_Bet=".$_REQUEST['BS_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败M!");
	$mysql="update web_member_data set BS_M_Bet=".$_REQUEST['BS_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败M!");
}
if($_REQUEST['BS_M_SC']<$bmscene){
    $mysql="update web_agents_data set BS_M_Scene=".$_REQUEST['BS_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败M!");
	$mysql="update web_member_data set BS_M_Scene=".$_REQUEST['BS_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败M!");
}
if($_REQUEST['BS_Turn_PD']<$bpdturn){
    $mysql="update web_agents_data set BS_Turn_PD=".$_REQUEST['BS_Turn_PD']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PD!");
	$mysql="update web_member_data set BS_Turn_PD=".$_REQUEST['BS_Turn_PD']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PD!");
}
if($_REQUEST['BS_PD_SO']<$bpdbet){
    $mysql="update web_agents_data set BS_PD_Bet=".$_REQUEST['BS_PD_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PD!");
	$mysql="update web_member_data set BS_PD_Bet=".$_REQUEST['BS_PD_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PD!");
}
if($_REQUEST['BS_PD_SC']<$bpdscene){
    $mysql="update web_agents_data set BS_PD_Scene=".$_REQUEST['BS_PD_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PD!");
	$mysql="update web_member_data set BS_PD_Scene=".$_REQUEST['BS_PD_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PD!");
}
if($_REQUEST['BS_Turn_T']<$btturn){
    $mysql="update web_agents_data set BS_Turn_T=".$_REQUEST['BS_Turn_T']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败T!");
	$mysql="update web_member_data set BS_Turn_T=".$_REQUEST['BS_Turn_T']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败T!");
}
if($_REQUEST['BS_T_SO']<$btbet){
    $mysql="update web_agents_data set BS_T_Bet=".$_REQUEST['BS_T_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败T!");
	$mysql="update web_member_data set BS_T_Bet=".$_REQUEST['BS_T_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败T!");
}
if($_REQUEST['BS_T_SC']<$btscene){
    $mysql="update web_agents_data set BS_T_Scene=".$_REQUEST['BS_T_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败T!");
	$mysql="update web_member_data set BS_T_Scene=".$_REQUEST['BS_T_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败T!");
}
if($_REQUEST['BS_Turn_P']<$bpturn){
    $mysql="update web_agents_data set BS_Turn_P=".$_REQUEST['BS_Turn_P']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败P!");
	$mysql="update web_member_data set BS_Turn_P=".$_REQUEST['BS_Turn_P']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败P!");
}
if($_REQUEST['BS_P_SO']<$bpbet){
    $mysql="update web_agents_data set BS_P_Bet=".$_REQUEST['BS_P_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败P!");
	$mysql="update web_member_data set BS_P_Bet=".$_REQUEST['BS_P_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败P!");
}
if($_REQUEST['BS_P_SC']<$bpscene){
    $mysql="update web_agents_data set BS_P_Scene=".$_REQUEST['BS_P_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败P!");
	$mysql="update web_member_data set BS_P_Scene=".$_REQUEST['BS_P_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败P!");
}
if($_REQUEST['BS_Turn_PR']<$bprturn){
    $mysql="update web_agents_data set BS_Turn_PR=".$_REQUEST['BS_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
	$mysql="update web_member_data set BS_Turn_PR=".$_REQUEST['BS_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
}
if($_REQUEST['BS_PR_SO']<$bprbet){
    $mysql="update web_agents_data set BS_PR_Bet=".$_REQUEST['BS_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
	$mysql="update web_member_data set BS_PR_Bet=".$_REQUEST['BS_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
}
if($_REQUEST['BS_PR_SC']<$bprscene){
    $mysql="update web_agents_data set BS_PR_Scene=".$_REQUEST['BS_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
	$mysql="update web_member_data set BS_PR_Scene=".$_REQUEST['BS_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
}
if($_REQUEST['BS_Turn_P3']<$bp3turn){
    $mysql="update web_agents_data set BS_Turn_P3=".$_REQUEST['BS_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
	$mysql="update web_member_data set BS_Turn_P3=".$_REQUEST['BS_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
}
if($_REQUEST['BS_P3_SO']<$bp3bet){
    $mysql="update web_agents_data set BS_P3_Bet=".$_REQUEST['BS_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
	$mysql="update web_member_data set BS_P3_Bet=".$_REQUEST['BS_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
}
if($_REQUEST['BS_P3_SC']<$bp3scene){
    $mysql="update web_agents_data set BS_P3_Scene=".$_REQUEST['BS_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
	$mysql="update web_member_data set BS_P3_Scene=".$_REQUEST['BS_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("BS代理操作失败PR!");
}
	$mysql="update web_agents_data set BS_Turn_R_A=".$_REQUEST['BS_Turn_R_A'].",BS_Turn_R_B=".$_REQUEST['BS_Turn_R_B'].",BS_Turn_R_C=".$_REQUEST['BS_Turn_R_C'].",BS_Turn_R_D=".$_REQUEST['BS_Turn_R_D'].",BS_R_Bet=".$_REQUEST['BS_R_SO'].",BS_R_Scene=".$_REQUEST['BS_R_SC'].",BS_Turn_OU_A=".$_REQUEST['BS_Turn_OU_A'].",BS_Turn_OU_B=".$_REQUEST['BS_Turn_OU_B'].",BS_Turn_OU_C=".$_REQUEST['BS_Turn_OU_C'].",BS_Turn_OU_D=".$_REQUEST['BS_Turn_OU_D'].",BS_OU_Bet=".$_REQUEST['BS_OU_SO'].",BS_OU_Scene=".$_REQUEST['BS_OU_SC'].",BS_Turn_RE_A=".$_REQUEST['BS_Turn_RE_A'].",BS_Turn_RE_B=".$_REQUEST['BS_Turn_RE_B'].",BS_Turn_RE_C=".$_REQUEST['BS_Turn_RE_C'].",BS_Turn_RE_D=".$_REQUEST['BS_Turn_RE_D'].",BS_RE_Bet=".$_REQUEST['BS_RE_SO'].",BS_RE_Scene=".$_REQUEST['BS_RE_SC'].",BS_Turn_ROU_A=".$_REQUEST['BS_Turn_ROU_A'].",BS_Turn_ROU_B=".$_REQUEST['BS_Turn_ROU_B'].",BS_Turn_ROU_C=".$_REQUEST['BS_Turn_ROU_C'].",BS_Turn_ROU_D=".$_REQUEST['BS_Turn_ROU_D'].",BS_ROU_Bet=".$_REQUEST['BS_ROU_SO'].",BS_ROU_Scene=".$_REQUEST['BS_ROU_SC'].",BS_Turn_EO_A=".$_REQUEST['BS_Turn_EO_A'].",BS_Turn_EO_B=".$_REQUEST['BS_Turn_EO_B'].",BS_Turn_EO_C=".$_REQUEST['BS_Turn_EO_C'].",BS_Turn_EO_D=".$_REQUEST['BS_Turn_EO_D'].",BS_EO_Bet=".$_REQUEST['BS_EO_SO'].",BS_EO_Scene=".$_REQUEST['BS_EO_SC'].",BS_Turn_M=".$_REQUEST['BS_Turn_M'].",BS_M_Bet=".$_REQUEST['BS_M_SO'].",BS_M_Scene=".$_REQUEST['BS_M_SC'].",BS_Turn_PD=".$_REQUEST['BS_Turn_PD'].",BS_PD_Bet=".$_REQUEST['BS_PD_SO'].",BS_PD_Scene=".$_REQUEST['BS_PD_SC'].",BS_Turn_T=".$_REQUEST['BS_Turn_T'].",BS_T_Bet=".$_REQUEST['BS_T_SO'].",BS_T_Scene=".$_REQUEST['BS_T_SC'].",BS_Turn_P=".$_REQUEST['BS_Turn_P'].",BS_P_Bet=".$_REQUEST['BS_P_SO'].",BS_P_Scene=".$_REQUEST['BS_P_SC'].",BS_Turn_PR=".$_REQUEST['BS_Turn_PR'].",BS_PR_Bet=".$_REQUEST['BS_PR_SO'].",BS_PR_Scene=".$_REQUEST['BS_PR_SC'].",BS_Turn_P3=".$_REQUEST['BS_Turn_P3'].",BS_P3_Bet=".$_REQUEST['BS_P3_SO'].",BS_P3_Scene=".$_REQUEST['BS_P3_SC']." where ID='$parents_id'";
	mysql_db_query($dbname,$mysql) or die ("BS操作失败!");
	$loginfo='详细设置'.$Title.':'.$username.' 棒球详细设置成功';
	echo "<Script Language=javascript>self.location='user_set.php?uid=$uid&lv=$lv&parents_id=$parents_id&name=$name&langx=$langx';</script>";		
	break;
case "TN":
if($_REQUEST['TN_Turn_R_A']<$brturna){
    $mysql="update web_agents_data set TN_Turn_R_A=".$_REQUEST['TN_Turn_R_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
    $mysql="update web_member_data set TN_Turn_R=".$_REQUEST['TN_Turn_R_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_R_B']<$brturnb){
    $mysql="update web_agents_data set TN_Turn_R_B=".$_REQUEST['TN_Turn_R_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_R=".$_REQUEST['TN_Turn_R_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_R_C']<$brturnc){
    $mysql="update web_agents_data set TN_Turn_R_C=".$_REQUEST['TN_Turn_R_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_R=".$_REQUEST['TN_Turn_R_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_R_D']<$brturnd){
    $mysql="update web_agents_data set TN_Turn_R_D=".$_REQUEST['TN_Turn_R_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_R=".$_REQUEST['TN_Turn_R_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_R_SO']<$brbet){
    $mysql="update web_agents_data set TN_R_Bet=".$_REQUEST['TN_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_R_Bet=".$_REQUEST['TN_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_R_SC']<$brscene){
    $mysql="update web_agents_data set TN_R_Scene=".$_REQUEST['TN_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败2!");
	$mysql="update web_member_data set TN_R_Scene=".$_REQUEST['TN_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败2!");
}
if($_REQUEST['TN_Turn_OU_A']<$bouturna){
    $mysql="update web_agents_data set TN_Turn_OU_A=".$_REQUEST['TN_Turn_OU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_OU=".$_REQUEST['TN_Turn_OU_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_OU_B']<$bouturnb){
    $mysql="update web_agents_data set TN_Turn_OU_B=".$_REQUEST['TN_Turn_OU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_OU=".$_REQUEST['TN_Turn_OU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_OU_C']<$bouturnc){
    $mysql="update web_agents_data set TN_Turn_OU_C=".$_REQUEST['TN_Turn_OU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_OU=".$_REQUEST['TN_Turn_OU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_OU_D']<$bouturnd){
    $mysql="update web_agents_data set TN_Turn_OU_D=".$_REQUEST['TN_Turn_OU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_OU=".$_REQUEST['TN_Turn_OU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_OU_SO']<$boubet){
    $mysql="update web_agents_data set TN_OU_Bet=".$_REQUEST['TN_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_OU_Bet=".$_REQUEST['TN_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_OU_SC']<$bouscene){
    $mysql="update web_agents_data set TN_OU_Scene=".$_REQUEST['TN_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败2!");
	$mysql="update web_member_data set TN_OU_Scene=".$_REQUEST['TN_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败2!");
}
if($_REQUEST['TN_Turn_RE_A']<$breturna){
    $mysql="update web_agents_data set TN_Turn_RE_A=".$_REQUEST['TN_Turn_RE_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_RE=".$_REQUEST['TN_Turn_RE_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_RE_B']<$breturnb){
    $mysql="update web_agents_data set TN_Turn_RE_B=".$_REQUEST['TN_Turn_RE_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_RE=".$_REQUEST['TN_Turn_RE_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_RE_C']<$breturnc){
    $mysql="update web_agents_data set TN_Turn_RE_C=".$_REQUEST['TN_Turn_RE_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_RE=".$_REQUEST['TN_Turn_RE_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_RE_D']<$breturnd){
    $mysql="update web_agents_data set TN_Turn_RE_D=".$_REQUEST['TN_Turn_RE_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_RE=".$_REQUEST['TN_Turn_RE_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_RE_SO']<$brebet){
    $mysql="update web_agents_data set TN_RE_Bet=".$_REQUEST['TN_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_RE_Bet=".$_REQUEST['TN_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_RE_SC']<$brescene){
    $mysql="update web_agents_data set TN_RE_Scene=".$_REQUEST['TN_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败2!");
	$mysql="update web_member_data set TN_RE_Scene=".$_REQUEST['TN_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败2!");
}
if($_REQUEST['TN_Turn_ROU_A']<$brouturna){
    $mysql="update web_agents_data set TN_Turn_ROU_A=".$_REQUEST['TN_Turn_ROU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_ROU=".$_REQUEST['TN_Turn_ROU_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_ROU_B']<$brouturnb){
    $mysql="update web_agents_data set TN_Turn_ROU_B=".$_REQUEST['TN_Turn_ROU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_ROU=".$_REQUEST['TN_Turn_ROU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_ROU_C']<$brouturnc){
    $mysql="update web_agents_data set TN_Turn_ROU_C=".$_REQUEST['TN_Turn_ROU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_ROU=".$_REQUEST['TN_Turn_ROU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_ROU_D']<$brouturnd){
    $mysql="update web_agents_data set TN_Turn_ROU_D=".$_REQUEST['TN_Turn_ROU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_ROU=".$_REQUEST['TN_Turn_ROU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_ROU_SO']<$broubet){
    $mysql="update web_agents_data set TN_ROU_Bet=".$_REQUEST['TN_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_ROU_Bet=".$_REQUEST['TN_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_ROU_SC']<$brouscene){
    $mysql="update web_agents_data set TN_ROU_Scene=".$_REQUEST['TN_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败2!");
	$mysql="update web_member_data set TN_ROU_Scene=".$_REQUEST['TN_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败2!");
}
if($_REQUEST['TN_Turn_EO_A']<$beoturna){
    $mysql="update web_agents_data set TN_Turn_EO_A=".$_REQUEST['TN_Turn_EO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_EO=".$_REQUEST['TN_Turn_EO_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_EO_B']<$beoturnb){
    $mysql="update web_agents_data set TN_Turn_EO_B=".$_REQUEST['TN_Turn_EO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_EO=".$_REQUEST['TN_Turn_EO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_EO_C']<$beoturnc){
    $mysql="update web_agents_data set TN_Turn_EO_C=".$_REQUEST['TN_Turn_EO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_EO=".$_REQUEST['TN_Turn_EO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_Turn_EO_D']<$beoturnd){
    $mysql="update web_agents_data set TN_Turn_EO_D=".$_REQUEST['TN_Turn_EO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_Turn_EO=".$_REQUEST['TN_Turn_EO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_EO_SO']<$beobet){
    $mysql="update web_agents_data set TN_EO_Bet=".$_REQUEST['TN_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
	$mysql="update web_member_data set TN_EO_Bet=".$_REQUEST['TN_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败1!");
}
if($_REQUEST['TN_EO_SC']<$beoscene){
    $mysql="update web_agents_data set TN_EO_Scene=".$_REQUEST['TN_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败2!");
	$mysql="update web_member_data set TN_EO_Scene=".$_REQUEST['TN_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败2!");
}
if($_REQUEST['TN_Turn_M']<$bmturn){
    $mysql="update web_agents_data set TN_Turn_M=".$_REQUEST['TN_Turn_M']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败M!");
	$mysql="update web_member_data set TN_Turn_M=".$_REQUEST['TN_Turn_M']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败M!");
}
if($_REQUEST['TN_M_SO']<$bmbet){
    $mysql="update web_agents_data set TN_M_Bet=".$_REQUEST['TN_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败M!");
	$mysql="update web_member_data set TN_M_Bet=".$_REQUEST['TN_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败M!");
}
if($_REQUEST['TN_M_SC']<$bmscene){
    $mysql="update web_agents_data set TN_M_Scene=".$_REQUEST['TN_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败M!");
	$mysql="update web_member_data set TN_M_Scene=".$_REQUEST['TN_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败M!");
}
if($_REQUEST['TN_Turn_PD']<$bpdturn){
    $mysql="update web_agents_data set TN_Turn_PD=".$_REQUEST['TN_Turn_PD']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PD!");
	$mysql="update web_member_data set TN_Turn_PD=".$_REQUEST['TN_Turn_PD']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PD!");
}
if($_REQUEST['TN_PD_SO']<$bpdbet){
    $mysql="update web_agents_data set TN_PD_Bet=".$_REQUEST['TN_PD_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PD!");
	$mysql="update web_member_data set TN_PD_Bet=".$_REQUEST['TN_PD_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PD!");
}
if($_REQUEST['TN_PD_SC']<$bpdscene){
    $mysql="update web_agents_data set TN_PD_Scene=".$_REQUEST['TN_PD_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PD!");
	$mysql="update web_member_data set TN_PD_Scene=".$_REQUEST['TN_PD_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PD!");
}
if($_REQUEST['TN_Turn_P']<$bpturn){
    $mysql="update web_agents_data set TN_Turn_P=".$_REQUEST['TN_Turn_P']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P!");
	$mysql="update web_member_data set TN_Turn_P=".$_REQUEST['TN_Turn_P']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P!");
}
if($_REQUEST['TN_P_SO']<$bpbet){
    $mysql="update web_agents_data set TN_P_Bet=".$_REQUEST['TN_P_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P!");
	$mysql="update web_member_data set TN_P_Bet=".$_REQUEST['TN_P_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P!");
}
if($_REQUEST['TN_P_SC']<$bpscene){
    $mysql="update web_agents_data set TN_P_Scene=".$_REQUEST['TN_P_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P!");
	$mysql="update web_member_data set TN_P_Scene=".$_REQUEST['TN_P_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P!");
}
if($_REQUEST['TN_Turn_PR']<$bprturn){
    $mysql="update web_agents_data set TN_Turn_PR=".$_REQUEST['TN_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PR!");
	$mysql="update web_member_data set TN_Turn_PR=".$_REQUEST['TN_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PR!");
}
if($_REQUEST['TN_PR_SO']<$bprbet){
    $mysql="update web_agents_data set TN_PR_Bet=".$_REQUEST['TN_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PR!");
	$mysql="update web_member_data set TN_PR_Bet=".$_REQUEST['TN_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PR!");
}
if($_REQUEST['TN_PR_SC']<$bprscene){
    $mysql="update web_agents_data set TN_PR_Scene=".$_REQUEST['TN_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PR!");
	$mysql="update web_member_data set TN_PR_Scene=".$_REQUEST['TN_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败PR!");
}
if($_REQUEST['TN_Turn_P3']<$bp3turn){
    $mysql="update web_agents_data set TN_Turn_P3=".$_REQUEST['TN_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P3!");
	$mysql="update web_member_data set TN_Turn_P3=".$_REQUEST['TN_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P3!");
}
if($_REQUEST['TN_P3_SO']<$bp3bet){
    $mysql="update web_agents_data set TN_P3_Bet=".$_REQUEST['TN_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P3!");
	$mysql="update web_member_data set TN_P3_Bet=".$_REQUEST['TN_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P3!");
}
if($_REQUEST['TN_P3_SC']<$bp3scene){
    $mysql="update web_agents_data set TN_P3_Scene=".$_REQUEST['TN_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P3!");
	$mysql="update web_member_data set TN_P3_Scene=".$_REQUEST['TN_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("TN代理操作失败P3!");
}
	$mysql="update web_agents_data set TN_Turn_R_A=".$_REQUEST['TN_Turn_R_A'].",TN_Turn_R_B=".$_REQUEST['TN_Turn_R_B'].",TN_Turn_R_C=".$_REQUEST['TN_Turn_R_C'].",TN_Turn_R_D=".$_REQUEST['TN_Turn_R_D'].",TN_R_Bet=".$_REQUEST['TN_R_SO'].",TN_R_Scene=".$_REQUEST['TN_R_SC'].",TN_Turn_OU_A=".$_REQUEST['TN_Turn_OU_A'].",TN_Turn_OU_B=".$_REQUEST['TN_Turn_OU_B'].",TN_Turn_OU_C=".$_REQUEST['TN_Turn_OU_C'].",TN_Turn_OU_D=".$_REQUEST['TN_Turn_OU_D'].",TN_OU_Bet=".$_REQUEST['TN_OU_SO'].",TN_OU_Scene=".$_REQUEST['TN_OU_SC'].",TN_Turn_RE_A=".$_REQUEST['TN_Turn_RE_A'].",TN_Turn_RE_B=".$_REQUEST['TN_Turn_RE_B'].",TN_Turn_RE_C=".$_REQUEST['TN_Turn_RE_C'].",TN_Turn_RE_D=".$_REQUEST['TN_Turn_RE_D'].",TN_RE_Bet=".$_REQUEST['TN_RE_SO'].",TN_RE_Scene=".$_REQUEST['TN_RE_SC'].",TN_Turn_ROU_A=".$_REQUEST['TN_Turn_ROU_A'].",TN_Turn_ROU_B=".$_REQUEST['TN_Turn_ROU_B'].",TN_Turn_ROU_C=".$_REQUEST['TN_Turn_ROU_C'].",TN_Turn_ROU_D=".$_REQUEST['TN_Turn_ROU_D'].",TN_ROU_Bet=".$_REQUEST['TN_ROU_SO'].",TN_ROU_Scene=".$_REQUEST['TN_ROU_SC'].",TN_Turn_EO_A=".$_REQUEST['TN_Turn_EO_A'].",TN_Turn_EO_B=".$_REQUEST['TN_Turn_EO_B'].",TN_Turn_EO_C=".$_REQUEST['TN_Turn_EO_C'].",TN_Turn_EO_D=".$_REQUEST['TN_Turn_EO_D'].",TN_EO_Bet=".$_REQUEST['TN_EO_SO'].",TN_EO_Scene=".$_REQUEST['TN_EO_SC'].",TN_Turn_M=".$_REQUEST['TN_Turn_M'].",TN_M_Bet=".$_REQUEST['TN_M_SO'].",TN_M_Scene=".$_REQUEST['TN_M_SC'].",TN_Turn_PD=".$_REQUEST['TN_Turn_PD'].",TN_PD_Bet=".$_REQUEST['TN_PD_SO'].",TN_PD_Scene=".$_REQUEST['TN_PD_SC'].",TN_Turn_P=".$_REQUEST['TN_Turn_P'].",TN_P_Bet=".$_REQUEST['TN_P_SO'].",TN_P_Scene=".$_REQUEST['TN_P_SC'].",TN_Turn_PR=".$_REQUEST['TN_Turn_PR'].",TN_PR_Bet=".$_REQUEST['TN_PR_SO'].",TN_PR_Scene=".$_REQUEST['TN_PR_SC'].",TN_Turn_P3=".$_REQUEST['TN_Turn_P3'].",TN_P3_Bet=".$_REQUEST['TN_P3_SO'].",TN_P3_Scene=".$_REQUEST['TN_P3_SC']." where ID='$parents_id'";
	mysql_db_query($dbname,$mysql) or die ("TN操作失败21!");
	$loginfo='详细设置'.$Title.':'.$username.' 网球详细设置成功';
	echo "<Script Language=javascript>self.location='user_set.php?uid=$uid&lv=$lv&parents_id=$parents_id&name=$name&langx=$langx';</script>";		
	break;
case "VB":
if($_REQUEST['VB_Turn_R_A']<$brturna){
    $mysql="update web_agents_data set VB_Turn_R_A=".$_REQUEST['VB_Turn_R_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
    $mysql="update web_member_data set VB_Turn_R=".$_REQUEST['VB_Turn_R_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_R_B']<$brturnb){
    $mysql="update web_agents_data set VB_Turn_R_B=".$_REQUEST['VB_Turn_R_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_R=".$_REQUEST['VB_Turn_R_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_R_C']<$brturnc){
    $mysql="update web_agents_data set VB_Turn_R_C=".$_REQUEST['VB_Turn_R_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_R=".$_REQUEST['VB_Turn_R_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_R_D']<$brturnd){
    $mysql="update web_agents_data set VB_Turn_R_D=".$_REQUEST['VB_Turn_R_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_R=".$_REQUEST['VB_Turn_R_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_R_SO']<$brbet){
    $mysql="update web_agents_data set VB_R_Bet=".$_REQUEST['VB_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_R_Bet=".$_REQUEST['VB_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_R_SC']<$brscene){
    $mysql="update web_agents_data set VB_R_Scene=".$_REQUEST['VB_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败2!");
	$mysql="update web_member_data set VB_R_Scene=".$_REQUEST['VB_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败2!");
}
if($_REQUEST['VB_Turn_OU_A']<$bouturna){
    $mysql="update web_agents_data set VB_Turn_OU_A=".$_REQUEST['VB_Turn_OU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_OU=".$_REQUEST['VB_Turn_OU_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_OU_B']<$bouturnb){
    $mysql="update web_agents_data set VB_Turn_OU_B=".$_REQUEST['VB_Turn_OU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_OU=".$_REQUEST['VB_Turn_OU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_OU_C']<$bouturnc){
    $mysql="update web_agents_data set VB_Turn_OU_C=".$_REQUEST['VB_Turn_OU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_OU=".$_REQUEST['VB_Turn_OU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_OU_D']<$bouturnd){
    $mysql="update web_agents_data set VB_Turn_OU_D=".$_REQUEST['VB_Turn_OU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_OU=".$_REQUEST['VB_Turn_OU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_OU_SO']<$boubet){
    $mysql="update web_agents_data set VB_OU_Bet=".$_REQUEST['VB_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_OU_Bet=".$_REQUEST['VB_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_OU_SC']<$bouscene){
    $mysql="update web_agents_data set VB_OU_Scene=".$_REQUEST['VB_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败2!");
	$mysql="update web_member_data set VB_OU_Scene=".$_REQUEST['VB_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败2!");
}
if($_REQUEST['VB_Turn_RE_A']<$breturna){
    $mysql="update web_agents_data set VB_Turn_RE_A=".$_REQUEST['VB_Turn_RE_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_RE=".$_REQUEST['VB_Turn_RE_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_RE_B']<$breturnb){
    $mysql="update web_agents_data set VB_Turn_RE_B=".$_REQUEST['VB_Turn_RE_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_RE=".$_REQUEST['VB_Turn_RE_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_RE_C']<$breturnc){
    $mysql="update web_agents_data set VB_Turn_RE_C=".$_REQUEST['VB_Turn_RE_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_RE=".$_REQUEST['VB_Turn_RE_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_RE_D']<$breturnd){
    $mysql="update web_agents_data set VB_Turn_RE_D=".$_REQUEST['VB_Turn_RE_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_RE=".$_REQUEST['VB_Turn_RE_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_RE_SO']<$brebet){
    $mysql="update web_agents_data set VB_RE_Bet=".$_REQUEST['VB_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_RE_Bet=".$_REQUEST['VB_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_RE_SC']<$brescene){
    $mysql="update web_agents_data set VB_RE_Scene=".$_REQUEST['VB_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败2!");
	$mysql="update web_member_data set VB_RE_Scene=".$_REQUEST['VB_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败2!");
}
if($_REQUEST['VB_Turn_ROU_A']<$brouturna){
    $mysql="update web_agents_data set VB_Turn_ROU_A=".$_REQUEST['VB_Turn_ROU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_ROU=".$_REQUEST['VB_Turn_ROU_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_ROU_B']<$brouturnb){
    $mysql="update web_agents_data set VB_Turn_ROU_B=".$_REQUEST['VB_Turn_ROU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_ROU=".$_REQUEST['VB_Turn_ROU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_ROU_C']<$brouturnc){
    $mysql="update web_agents_data set VB_Turn_ROU_C=".$_REQUEST['VB_Turn_ROU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_ROU=".$_REQUEST['VB_Turn_ROU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_ROU_D']<$brouturnd){
    $mysql="update web_agents_data set VB_Turn_ROU_D=".$_REQUEST['VB_Turn_ROU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_ROU=".$_REQUEST['VB_Turn_ROU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_ROU_SO']<$broubet){
    $mysql="update web_agents_data set VB_ROU_Bet=".$_REQUEST['VB_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_ROU_Bet=".$_REQUEST['VB_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_ROU_SC']<$brouscene){
    $mysql="update web_agents_data set VB_ROU_Scene=".$_REQUEST['VB_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败2!");
	$mysql="update web_member_data set VB_ROU_Scene=".$_REQUEST['VB_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败2!");
}
if($_REQUEST['VB_Turn_EO_A']<$beoturna){
    $mysql="update web_agents_data set VB_Turn_EO_A=".$_REQUEST['VB_Turn_EO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_EO=".$_REQUEST['VB_Turn_EO_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_EO_B']<$beoturnb){
    $mysql="update web_agents_data set VB_Turn_EO_B=".$_REQUEST['VB_Turn_EO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_EO=".$_REQUEST['VB_Turn_EO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_EO_C']<$beoturnc){
    $mysql="update web_agents_data set VB_Turn_EO_C=".$_REQUEST['VB_Turn_EO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_EO=".$_REQUEST['VB_Turn_EO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_Turn_EO_D']<$beoturnd){
    $mysql="update web_agents_data set VB_Turn_EO_D=".$_REQUEST['VB_Turn_EO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_Turn_EO=".$_REQUEST['VB_Turn_EO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_EO_SO']<$beobet){
    $mysql="update web_agents_data set VB_EO_Bet=".$_REQUEST['VB_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
	$mysql="update web_member_data set VB_EO_Bet=".$_REQUEST['VB_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败1!");
}
if($_REQUEST['VB_EO_SC']<$beoscene){
    $mysql="update web_agents_data set VB_EO_Scene=".$_REQUEST['VB_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败2!");
	$mysql="update web_member_data set VB_EO_Scene=".$_REQUEST['VB_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败2!");
}
if($_REQUEST['VB_Turn_M']<$bmturn){
    $mysql="update web_agents_data set VB_Turn_M=".$_REQUEST['VB_Turn_M']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败M!");
	$mysql="update web_member_data set VB_Turn_M=".$_REQUEST['VB_Turn_M']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败M!");
}
if($_REQUEST['VB_M_SO']<$bmbet){
    $mysql="update web_agents_data set VB_M_Bet=".$_REQUEST['VB_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败M!");
	$mysql="update web_member_data set VB_M_Bet=".$_REQUEST['VB_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败M!");
}
if($_REQUEST['VB_M_SC']<$bmscene){
    $mysql="update web_agents_data set VB_M_Scene=".$_REQUEST['VB_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败M!");
	$mysql="update web_member_data set VB_M_Scene=".$_REQUEST['VB_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败M!");
}
if($_REQUEST['VB_Turn_PD']<$bpdturn){
    $mysql="update web_agents_data set VB_Turn_PD=".$_REQUEST['VB_Turn_PD']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PD!");
	$mysql="update web_member_data set VB_Turn_PD=".$_REQUEST['VB_Turn_PD']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PD!");
}
if($_REQUEST['VB_PD_SO']<$bpdbet){
    $mysql="update web_agents_data set VB_PD_Bet=".$_REQUEST['VB_PD_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PD!");
	$mysql="update web_member_data set VB_PD_Bet=".$_REQUEST['VB_PD_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PD!");
}
if($_REQUEST['VB_PD_SC']<$bpdscene){
    $mysql="update web_agents_data set VB_PD_Scene=".$_REQUEST['VB_PD_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PD!");
	$mysql="update web_member_data set VB_PD_Scene=".$_REQUEST['VB_PD_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PD!");
}
if($_REQUEST['VB_Turn_P']<$bpturn){
    $mysql="update web_agents_data set VB_Turn_P=".$_REQUEST['VB_Turn_P']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P!");
	$mysql="update web_member_data set VB_Turn_P=".$_REQUEST['VB_Turn_P']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P!");
}
if($_REQUEST['VB_P_SO']<$bpbet){
    $mysql="update web_agents_data set VB_P_Bet=".$_REQUEST['VB_P_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P!");
	$mysql="update web_member_data set VB_P_Bet=".$_REQUEST['VB_P_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P!");
}
if($_REQUEST['VB_P_SC']<$bpscene){
    $mysql="update web_agents_data set VB_P_Scene=".$_REQUEST['VB_P_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P!");
	$mysql="update web_member_data set VB_P_Scene=".$_REQUEST['VB_P_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P!");
}
if($_REQUEST['VB_Turn_PR']<$bprturn){
    $mysql="update web_agents_data set VB_Turn_PR=".$_REQUEST['VB_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PR!");
	$mysql="update web_member_data set VB_Turn_PR=".$_REQUEST['VB_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PR!");
}
if($_REQUEST['VB_PR_SO']<$bprbet){
    $mysql="update web_agents_data set VB_PR_Bet=".$_REQUEST['VB_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PR!");
	$mysql="update web_member_data set VB_PR_Bet=".$_REQUEST['VB_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PR!");
}
if($_REQUEST['VB_PR_SC']<$bprscene){
    $mysql="update web_agents_data set VB_PR_Scene=".$_REQUEST['VB_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PR!");
	$mysql="update web_member_data set VB_PR_Scene=".$_REQUEST['VB_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败PR!");
}
if($_REQUEST['VB_Turn_P3']<$bp3turn){
    $mysql="update web_agents_data set VB_Turn_P3=".$_REQUEST['VB_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P3!");
	$mysql="update web_member_data set VB_Turn_P3=".$_REQUEST['VB_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P3!");
}
if($_REQUEST['VB_P3_SO']<$bp3bet){
    $mysql="update web_agents_data set VB_P3_Bet=".$_REQUEST['VB_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P3!");
	$mysql="update web_member_data set VB_P3_Bet=".$_REQUEST['VB_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P3!");
}
if($_REQUEST['VB_P3_SC']<$bp3scene){
    $mysql="update web_agents_data set VB_P3_Scene=".$_REQUEST['VB_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P3!");
	$mysql="update web_member_data set VB_P3_Scene=".$_REQUEST['VB_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("VB代理操作失败P3!");
}
	$mysql="update web_agents_data set VB_Turn_R_A=".$_REQUEST['VB_Turn_R_A'].",VB_Turn_R_B=".$_REQUEST['VB_Turn_R_B'].",VB_Turn_R_C=".$_REQUEST['VB_Turn_R_C'].",VB_Turn_R_D=".$_REQUEST['VB_Turn_R_D'].",VB_R_Bet=".$_REQUEST['VB_R_SO'].",VB_R_Scene=".$_REQUEST['VB_R_SC'].",VB_Turn_OU_A=".$_REQUEST['VB_Turn_OU_A'].",VB_Turn_OU_B=".$_REQUEST['VB_Turn_OU_B'].",VB_Turn_OU_C=".$_REQUEST['VB_Turn_OU_C'].",VB_Turn_OU_D=".$_REQUEST['VB_Turn_OU_D'].",VB_OU_Bet=".$_REQUEST['VB_OU_SO'].",VB_OU_Scene=".$_REQUEST['VB_OU_SC'].",VB_Turn_RE_A=".$_REQUEST['VB_Turn_RE_A'].",VB_Turn_RE_B=".$_REQUEST['VB_Turn_RE_B'].",VB_Turn_RE_C=".$_REQUEST['VB_Turn_RE_C'].",VB_Turn_RE_D=".$_REQUEST['VB_Turn_RE_D'].",VB_RE_Bet=".$_REQUEST['VB_RE_SO'].",VB_RE_Scene=".$_REQUEST['VB_RE_SC'].",VB_Turn_ROU_A=".$_REQUEST['VB_Turn_ROU_A'].",VB_Turn_ROU_B=".$_REQUEST['VB_Turn_ROU_B'].",VB_Turn_ROU_C=".$_REQUEST['VB_Turn_ROU_C'].",VB_Turn_ROU_D=".$_REQUEST['VB_Turn_ROU_D'].",VB_ROU_Bet=".$_REQUEST['VB_ROU_SO'].",VB_ROU_Scene=".$_REQUEST['VB_ROU_SC'].",VB_Turn_EO_A=".$_REQUEST['VB_Turn_EO_A'].",VB_Turn_EO_B=".$_REQUEST['VB_Turn_EO_B'].",VB_Turn_EO_C=".$_REQUEST['VB_Turn_EO_C'].",VB_Turn_EO_D=".$_REQUEST['VB_Turn_EO_D'].",VB_EO_Bet=".$_REQUEST['VB_EO_SO'].",VB_EO_Scene=".$_REQUEST['VB_EO_SC'].",VB_Turn_M=".$_REQUEST['VB_Turn_M'].",VB_M_Bet=".$_REQUEST['VB_M_SO'].",VB_M_Scene=".$_REQUEST['VB_M_SC'].",VB_Turn_PD=".$_REQUEST['VB_Turn_PD'].",VB_PD_Bet=".$_REQUEST['VB_PD_SO'].",VB_PD_Scene=".$_REQUEST['VB_PD_SC'].",VB_Turn_P=".$_REQUEST['VB_Turn_P'].",VB_P_Bet=".$_REQUEST['VB_P_SO'].",VB_P_Scene=".$_REQUEST['VB_P_SC'].",VB_Turn_PR=".$_REQUEST['VB_Turn_PR'].",VB_PR_Bet=".$_REQUEST['VB_PR_SO'].",VB_PR_Scene=".$_REQUEST['VB_PR_SC'].",VB_Turn_P3=".$_REQUEST['VB_Turn_P3'].",VB_P3_Bet=".$_REQUEST['VB_P3_SO'].",VB_P3_Scene=".$_REQUEST['VB_P3_SC']." where ID='$parents_id'";
	mysql_db_query($dbname,$mysql) or die ("VB操作失败1!");
	$loginfo='详细设置'.$Title.':'.$username.' 排球详细设置成功';
	echo "<Script Language=javascript>self.location='user_set.php?uid=$uid&lv=$lv&parents_id=$parents_id&name=$name&langx=$langx';</script>";		
	break;
case "OP":
if($_REQUEST['OP_Turn_R_A']<$brturna){
    $mysql="update web_agents_data set OP_Turn_R_A=".$_REQUEST['OP_Turn_R_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
    $mysql="update web_member_data set OP_Turn_R=".$_REQUEST['OP_Turn_R_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_R_B']<$brturnb){
    $mysql="update web_agents_data set OP_Turn_R_B=".$_REQUEST['OP_Turn_R_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_R=".$_REQUEST['OP_Turn_R_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_R_C']<$brturnc){
    $mysql="update web_agents_data set OP_Turn_R_C=".$_REQUEST['OP_Turn_R_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_R=".$_REQUEST['OP_Turn_R_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_R_D']<$brturnd){
    $mysql="update web_agents_data set OP_Turn_R_D=".$_REQUEST['OP_Turn_R_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_R=".$_REQUEST['OP_Turn_R_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_R_SO']<$brbet){
    $mysql="update web_agents_data set OP_R_Bet=".$_REQUEST['OP_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_R_Bet=".$_REQUEST['OP_R_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_R_SC']<$brscene){
    $mysql="update web_agents_data set OP_R_Scene=".$_REQUEST['OP_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_R_Scene=".$_REQUEST['OP_R_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_OU_A']<$bouturna){
    $mysql="update web_agents_data set OP_Turn_OU_A=".$_REQUEST['OP_Turn_OU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_OU=".$_REQUEST['OP_Turn_OU_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_OU_B']<$bouturnb){
    $mysql="update web_agents_data set OP_Turn_OU_B=".$_REQUEST['OP_Turn_OU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_OU=".$_REQUEST['OP_Turn_OU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_OU_C']<$bouturnc){
    $mysql="update web_agents_data set OP_Turn_OU_C=".$_REQUEST['OP_Turn_OU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_OU=".$_REQUEST['OP_Turn_OU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_OU_D']<$bouturnd){
    $mysql="update web_agents_data set OP_Turn_OU_D=".$_REQUEST['OP_Turn_OU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_OU=".$_REQUEST['OP_Turn_OU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_OU_SO']<$boubet){
    $mysql="update web_agents_data set OP_OU_Bet=".$_REQUEST['OP_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_OU_Bet=".$_REQUEST['OP_OU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_OU_SC']<$bouscene){
    $mysql="update web_agents_data set OP_OU_Scene=".$_REQUEST['OP_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_OU_Scene=".$_REQUEST['OP_OU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_RE_A']<$breturna){
    $mysql="update web_agents_data set OP_Turn_RE_A=".$_REQUEST['OP_Turn_RE_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_RE=".$_REQUEST['OP_Turn_RE_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_RE_B']<$breturnb){
    $mysql="update web_agents_data set OP_Turn_RE_B=".$_REQUEST['OP_Turn_RE_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_RE=".$_REQUEST['OP_Turn_RE_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_RE_C']<$breturnc){
    $mysql="update web_agents_data set OP_Turn_RE_C=".$_REQUEST['OP_Turn_RE_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_RE=".$_REQUEST['OP_Turn_RE_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_RE_D']<$breturnd){
    $mysql="update web_agents_data set OP_Turn_RE_D=".$_REQUEST['OP_Turn_RE_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_RE=".$_REQUEST['OP_Turn_RE_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_RE_SO']<$brebet){
    $mysql="update web_agents_data set OP_RE_Bet=".$_REQUEST['OP_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_RE_Bet=".$_REQUEST['OP_RE_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_RE_SC']<$brescene){
    $mysql="update web_agents_data set OP_RE_Scene=".$_REQUEST['OP_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_RE_Scene=".$_REQUEST['OP_RE_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_ROU_A']<$brouturna){
    $mysql="update web_agents_data set OP_Turn_ROU_A=".$_REQUEST['OP_Turn_ROU_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_ROU=".$_REQUEST['OP_Turn_ROU_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_ROU_B']<$brouturnb){
    $mysql="update web_agents_data set OP_Turn_ROU_B=".$_REQUEST['OP_Turn_ROU_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_ROU=".$_REQUEST['OP_Turn_ROU_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_ROU_C']<$brouturnc){
    $mysql="update web_agents_data set OP_Turn_ROU_C=".$_REQUEST['OP_Turn_ROU_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_ROU=".$_REQUEST['OP_Turn_ROU_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_ROU_D']<$brouturnd){
    $mysql="update web_agents_data set OP_Turn_ROU_D=".$_REQUEST['OP_Turn_ROU_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_ROU=".$_REQUEST['OP_Turn_ROU_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_ROU_SO']<$broubet){
    $mysql="update web_agents_data set OP_ROU_Bet=".$_REQUEST['OP_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_ROU_Bet=".$_REQUEST['OP_ROU_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_ROU_SC']<$brouscene){
    $mysql="update web_agents_data set OP_ROU_Scene=".$_REQUEST['OP_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_ROU_Scene=".$_REQUEST['OP_ROU_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_EO_A']<$beoturna){
    $mysql="update web_agents_data set OP_Turn_EO_A=".$_REQUEST['OP_Turn_EO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_EO=".$_REQUEST['OP_Turn_EO_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_EO_B']<$beoturnb){
    $mysql="update web_agents_data set OP_Turn_EO_B=".$_REQUEST['OP_Turn_EO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_EO=".$_REQUEST['OP_Turn_EO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_EO_C']<$beoturnc){
    $mysql="update web_agents_data set OP_Turn_EO_C=".$_REQUEST['OP_Turn_EO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_EO=".$_REQUEST['OP_Turn_EO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_Turn_EO_D']<$beoturnd){
    $mysql="update web_agents_data set OP_Turn_EO_D=".$_REQUEST['OP_Turn_EO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_EO=".$_REQUEST['OP_Turn_EO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_EO_SO']<$beobet){
    $mysql="update web_agents_data set OP_EO_Bet=".$_REQUEST['OP_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_EO_Bet=".$_REQUEST['OP_EO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_EO_SC']<$beoscene){
    $mysql="update web_agents_data set OP_EO_Scene=".$_REQUEST['OP_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_EO_Scene=".$_REQUEST['OP_EO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_M']<$bmturn){
    $mysql="update web_agents_data set OP_Turn_M=".$_REQUEST['OP_Turn_M']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_M=".$_REQUEST['OP_Turn_M']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_M_SO']<$bmbet){
    $mysql="update web_agents_data set OP_M_Bet=".$_REQUEST['OP_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_M_Bet=".$_REQUEST['OP_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_M_SC']<$bmscene){
    $mysql="update web_agents_data set OP_M_Scene=".$_REQUEST['OP_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_M_Scene=".$_REQUEST['OP_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_PD']<$bpdturn){
    $mysql="update web_agents_data set OP_Turn_PD=".$_REQUEST['OP_Turn_PD']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_PD=".$_REQUEST['OP_Turn_PD']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_PD_SO']<$bpdbet){
    $mysql="update web_agents_data set OP_PD_Bet=".$_REQUEST['OP_PD_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_PD_Bet=".$_REQUEST['OP_PD_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_PD_SC']<$bpdscene){
    $mysql="update web_agents_data set OP_PD_Scene=".$_REQUEST['OP_PD_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_PD_Scene=".$_REQUEST['OP_PD_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_T']<$btturn){
    $mysql="update web_agents_data set OP_Turn_T=".$_REQUEST['OP_Turn_T']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_T=".$_REQUEST['OP_Turn_T']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_T_SO']<$btbet){
    $mysql="update web_agents_data set OP_T_Bet=".$_REQUEST['OP_T_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_T_Bet=".$_REQUEST['OP_T_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_T_SC']<$btscene){
    $mysql="update web_agents_data set OP_T_Scene=".$_REQUEST['OP_T_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_T_Scene=".$_REQUEST['OP_T_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_F']<$bfturn){
    $mysql="update web_agents_data set OP_Turn_F=".$_REQUEST['OP_Turn_F']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_F=".$_REQUEST['OP_Turn_F']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_F_SO']<$bfbet){
    $mysql="update web_agents_data set OP_F_Bet=".$_REQUEST['OP_F_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_F_Bet=".$_REQUEST['OP_F_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_F_SC']<$bfscene){
    $mysql="update web_agents_data set OP_F_Scene=".$_REQUEST['OP_F_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_F_Scene=".$_REQUEST['OP_F_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_P']<$bpturn){
    $mysql="update web_agents_data set OP_Turn_P=".$_REQUEST['OP_Turn_P']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_P=".$_REQUEST['OP_Turn_P']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_P_SO']<$bpbet){
    $mysql="update web_agents_data set OP_P_Bet=".$_REQUEST['OP_P_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_P_Bet=".$_REQUEST['OP_P_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_P_SC']<$bpscene){
    $mysql="update web_agents_data set OP_P_Scene=".$_REQUEST['OP_P_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_P_Scene=".$_REQUEST['OP_P_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_PR']<$bprturn){
    $mysql="update web_agents_data set OP_Turn_PR=".$_REQUEST['OP_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_PR=".$_REQUEST['OP_Turn_PR']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_PR_SO']<$bprbet){
    $mysql="update web_agents_data set OP_PR_Bet=".$_REQUEST['OP_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_PR_Bet=".$_REQUEST['OP_PR_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_PR_SC']<$bprscene){
    $mysql="update web_agents_data set OP_PR_Scene=".$_REQUEST['OP_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_PR_Scene=".$_REQUEST['OP_PR_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
if($_REQUEST['OP_Turn_P3']<$bp3turn){
    $mysql="update web_agents_data set OP_Turn_P3=".$_REQUEST['OP_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_Turn_P3=".$_REQUEST['OP_Turn_P3']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_P3_SO']<$bp3bet){
    $mysql="update web_agents_data set OP_P3_Bet=".$_REQUEST['OP_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
	$mysql="update web_member_data set OP_P3_Bet=".$_REQUEST['OP_P3_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败1!");
}
if($_REQUEST['OP_P3_SC']<$bp3scene){
    $mysql="update web_agents_data set OP_P3_Scene=".$_REQUEST['OP_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
	$mysql="update web_member_data set OP_P3_Scene=".$_REQUEST['OP_P3_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("OP代理操作失败2!");
}
	$mysql="update web_agents_data set OP_Turn_R_A=".$_REQUEST['OP_Turn_R_A'].",OP_Turn_R_B=".$_REQUEST['OP_Turn_R_B'].",OP_Turn_R_C=".$_REQUEST['OP_Turn_R_C'].",OP_Turn_R_D=".$_REQUEST['OP_Turn_R_D'].",OP_R_Bet=".$_REQUEST['OP_R_SO'].",OP_R_Scene=".$_REQUEST['OP_R_SC'].",OP_Turn_OU_A=".$_REQUEST['OP_Turn_OU_A'].",OP_Turn_OU_B=".$_REQUEST['OP_Turn_OU_B'].",OP_Turn_OU_C=".$_REQUEST['OP_Turn_OU_C'].",OP_Turn_OU_D=".$_REQUEST['OP_Turn_OU_D'].",OP_OU_Bet=".$_REQUEST['OP_OU_SO'].",OP_OU_Scene=".$_REQUEST['OP_OU_SC'].",OP_Turn_RE_A=".$_REQUEST['OP_Turn_RE_A'].",OP_Turn_RE_B=".$_REQUEST['OP_Turn_RE_B'].",OP_Turn_RE_C=".$_REQUEST['OP_Turn_RE_C'].",OP_Turn_RE_D=".$_REQUEST['OP_Turn_RE_D'].",OP_RE_Bet=".$_REQUEST['OP_RE_SO'].",OP_RE_Scene=".$_REQUEST['OP_RE_SC'].",OP_Turn_ROU_A=".$_REQUEST['OP_Turn_ROU_A'].",OP_Turn_ROU_B=".$_REQUEST['OP_Turn_ROU_B'].",OP_Turn_ROU_C=".$_REQUEST['OP_Turn_ROU_C'].",OP_Turn_ROU_D=".$_REQUEST['OP_Turn_ROU_D'].",OP_ROU_Bet=".$_REQUEST['OP_ROU_SO'].",OP_ROU_Scene=".$_REQUEST['OP_ROU_SC'].",OP_Turn_EO_A=".$_REQUEST['OP_Turn_EO_A'].",OP_Turn_EO_B=".$_REQUEST['OP_Turn_EO_B'].",OP_Turn_EO_C=".$_REQUEST['OP_Turn_EO_C'].",OP_Turn_EO_D=".$_REQUEST['OP_Turn_EO_D'].",OP_EO_Bet=".$_REQUEST['OP_EO_SO'].",OP_EO_Scene=".$_REQUEST['OP_EO_SC'].",OP_Turn_M=".$_REQUEST['OP_Turn_M'].",OP_M_Bet=".$_REQUEST['OP_M_SO'].",OP_M_Scene=".$_REQUEST['OP_M_SC'].",OP_Turn_PD=".$_REQUEST['OP_Turn_PD'].",OP_PD_Bet=".$_REQUEST['OP_PD_SO'].",OP_PD_Scene=".$_REQUEST['OP_PD_SC'].",OP_Turn_T=".$_REQUEST['OP_Turn_T'].",OP_T_Bet=".$_REQUEST['OP_T_SO'].",OP_T_Scene=".$_REQUEST['OP_T_SC'].",OP_Turn_F=".$_REQUEST['OP_Turn_F'].",OP_F_Bet=".$_REQUEST['OP_F_SO'].",OP_F_Scene=".$_REQUEST['OP_F_SC'].",OP_Turn_P=".$_REQUEST['OP_Turn_P'].",OP_P_Bet=".$_REQUEST['OP_P_SO'].",OP_P_Scene=".$_REQUEST['OP_P_SC'].",OP_Turn_PR=".$_REQUEST['OP_Turn_PR'].",OP_PR_Bet=".$_REQUEST['OP_PR_SO'].",OP_PR_Scene=".$_REQUEST['OP_PR_SC'].",OP_Turn_P3=".$_REQUEST['OP_Turn_P3'].",OP_P3_Bet=".$_REQUEST['OP_P3_SO'].",OP_P3_Scene=".$_REQUEST['OP_P3_SC']." where ID='$parents_id'";
	mysql_db_query($dbname,$mysql) or die ("OP操作失败1!");
	$loginfo='详细设置'.$Title.':'.$username.' 其他详细设置成功';
	echo "<Script Language=javascript>self.location='user_set.php?uid=$uid&lv=$lv&parents_id=$parents_id&name=$name&langx=$langx';</script>";
	break;
case "SIX":
if($_REQUEST['SIX_Turn_SCA_A']<$bscaturna){
    $mysql="update web_agents_data set SIX_Turn_SCA_A=".$_REQUEST['SIX_Turn_SCA_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCA!");
    $mysql="update web_member_data set SIX_Turn_SCA=".$_REQUEST['SIX_Turn_SCA_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCA!");
}
if($_REQUEST['SIX_Turn_SCA_B']<$bscaturnb){
    $mysql="update web_agents_data set SIX_Turn_SCA_B=".$_REQUEST['SIX_Turn_SCA_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA=".$_REQUEST['SIX_Turn_SCA_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SCA_C']<$bscaturnc){
    $mysql="update web_agents_data set SIX_Turn_SCA_C=".$_REQUEST['SIX_Turn_SCA_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA=".$_REQUEST['SIX_Turn_SCA_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SCA_D']<$bscaturnd){
    $mysql="update web_agents_data set SIX_Turn_SCA_D=".$_REQUEST['SIX_Turn_SCA_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA=".$_REQUEST['SIX_Turn_SCA_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_SCA_SO']<$bscabet){
    $mysql="update web_agents_data set SIX_SCA_Bet=".$_REQUEST['SIX_SCA_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCA1!");
	$mysql="update web_member_data set SIX_SCA_Bet=".$_REQUEST['SIX_SCA_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCA1!");
}
if($_REQUEST['SIX_SCA_SC']<$bscascene){
    $mysql="update web_agents_data set SIX_SCA_Scene=".$_REQUEST['SIX_SCA_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCA2!");
	$mysql="update web_member_data set SIX_SCA_Scene=".$_REQUEST['SIX_SCA_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCA2!");
}
if($_REQUEST['SIX_Turn_SCB_A']<$bscbturna){
    $mysql="update web_agents_data set SIX_Turn_SCB_A=".$_REQUEST['SIX_Turn_SCB_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB1!");
	$mysql="update web_member_data set SIX_Turn_SCB=".$_REQUEST['SIX_Turn_SCB_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB1!");
}
if($_REQUEST['SIX_Turn_SCB_B']<$bscbturnb){
    $mysql="update web_agents_data set SIX_Turn_SCB_B=".$_REQUEST['SIX_Turn_SCB_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB1!");
	$mysql="update web_member_data set SIX_Turn_SCB=".$_REQUEST['SIX_Turn_SCB_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB1!");
}
if($_REQUEST['SIX_Turn_SCB_C']<$bscbturnc){
    $mysql="update web_agents_data set SIX_Turn_SCB_C=".$_REQUEST['SIX_Turn_SCB_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB1!");
	$mysql="update web_member_data set SIX_Turn_SCB=".$_REQUEST['SIX_Turn_SCB_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB1!");
}
if($_REQUEST['SIX_Turn_SCB_D']<$bscbturnd){
    $mysql="update web_agents_data set SIX_Turn_SCB_D=".$_REQUEST['SIX_Turn_SCB_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB1!");
	$mysql="update web_member_data set SIX_Turn_SCB=".$_REQUEST['SIX_Turn_SCB_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB1!");
}
if($_REQUEST['SIX_SCB_SO']<$bscbbet){
    $mysql="update web_agents_data set SIX_SCB_Bet=".$_REQUEST['SIX_SCB_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB1!");
	$mysql="update web_member_data set SIX_SCB_Bet=".$_REQUEST['SIX_SCB_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB1!");
}
if($_REQUEST['SIX_SCB_SC']<$bscbscene){
    $mysql="update web_agents_data set SIX_SCB_Scene=".$_REQUEST['SIX_SCB_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB2!");
	$mysql="update web_member_data set SIX_SCB_Scene=".$_REQUEST['SIX_SCB_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCB2!");
}
if($_REQUEST['SIX_Turn_SCA_AOUEO_A']<$bscaaturna){
    $mysql="update web_agents_data set SIX_Turn_SCA_AOUEO_A=".$_REQUEST['SIX_Turn_SCA_AOUEO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCA_AOUEO1!");
	$mysql="update web_member_data set SIX_Turn_SCA_AOUEO=".$_REQUEST['SIX_Turn_SCA_AOUEO_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCA_AOUEO1!");
}
if($_REQUEST['SIX_Turn_SCA_AOUEO_B']<$bscaaturnb){
    $mysql="update web_agents_data set SIX_Turn_SCA_AOUEO_B=".$_REQUEST['SIX_Turn_SCA_AOUEO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCA_AOUEO1!");
	$mysql="update web_member_data set SIX_Turn_SCA_AOUEO=".$_REQUEST['SIX_Turn_SCA_AOUEO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败SCA_AOUEO1!");
}
if($_REQUEST['SIX_Turn_SCA_AOUEO_C']<$bscaaturnc){
    $mysql="update web_agents_data set SIX_Turn_SCA_AOUEO_C=".$_REQUEST['SIX_Turn_SCA_AOUEO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA_AOUEO=".$_REQUEST['SIX_Turn_SCA_AOUEO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SCA_AOUEO_D']<$bscaaturnd){
    $mysql="update web_agents_data set SIX_Turn_SCA_AOUEO_D=".$_REQUEST['SIX_Turn_SCA_AOUEO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA_AOUEO=".$_REQUEST['SIX_Turn_SCA_AOUEO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_SCA_AOUEO_SO']<$bscaabet){
    $mysql="update web_agents_data set SIX_SCA_AOUEO_Bet=".$_REQUEST['SIX_SCA_AOUEO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_SCA_AOUEO_Bet=".$_REQUEST['SIX_SCA_AOUEO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_SCA_AOUEO_SC']<$bscaascene){
    $mysql="update web_agents_data set SIX_SCA_AOUEO_Scene=".$_REQUEST['SIX_SCA_AOUEO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
	$mysql="update web_member_data set SIX_SCA_AOUEO_Scene=".$_REQUEST['SIX_SCA_AOUEO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
}
if($_REQUEST['SIX_Turn_SCA_BOUEO_A']<$bscabturna){
    $mysql="update web_agents_data set SIX_Turn_SCA_BOUEO_A=".$_REQUEST['SIX_Turn_SCA_BOUEO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA_BOUEO=".$_REQUEST['SIX_Turn_SCA_BOUEO_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SCA_BOUEO_B']<$bscabturnb){
    $mysql="update web_agents_data set SIX_Turn_SCA_BOUEO_B=".$_REQUEST['SIX_Turn_SCA_BOUEO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA_BOUEO=".$_REQUEST['SIX_Turn_SCA_BOUEO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SCA_BOUEO_C']<$bscabturnc){
    $mysql="update web_agents_data set SIX_Turn_SCA_BOUEO_C=".$_REQUEST['SIX_Turn_SCA_BOUEO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA_BOUEO=".$_REQUEST['SIX_Turn_SCA_BOUEO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SCA_BOUEO_D']<$bscabturnd){
    $mysql="update web_agents_data set SIX_Turn_SCA_BOUEO_D=".$_REQUEST['SIX_Turn_SCA_BOUEO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA_BOUEO=".$_REQUEST['SIX_Turn_SCA_BOUEO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_SCA_BOUEO_SO']<$bscabbet){
    $mysql="update web_agents_data set SIX_SCA_BOUEO_Bet=".$_REQUEST['SIX_SCA_BOUEO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_SCA_BOUEO_Bet=".$_REQUEST['SIX_SCA_BOUEO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_SCA_BOUEO_SC']<$bscabscene){
    $mysql="update web_agents_data set SIX_SCA_BOUEO_Scene=".$_REQUEST['SIX_SCA_BOUEO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败12!");
	$mysql="update web_member_data set SIX_SCA_BOUEO_Scene=".$_REQUEST['SIX_SCA_BOUEO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
}
if($_REQUEST['SIX_Turn_SCA_RBG_A']<$bscarbgturna){
    $mysql="update web_agents_data set SIX_Turn_SCA_RBG_A=".$_REQUEST['SIX_Turn_SCA_RBG_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA_RBG=".$_REQUEST['SIX_Turn_SCA_RBG_A']." where  $agname and OpenType='A'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SCA_RBG_B']<$bscarbgturnb){
    $mysql="update web_agents_data set SIX_Turn_SCA_RBG_B=".$_REQUEST['SIX_Turn_SCA_RBG_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA_RBG=".$_REQUEST['SIX_Turn_SCA_RBG_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SCA_RBG_C']<$bscarbgturnc){
    $mysql="update web_agents_data set SIX_Turn_SCA_RBG_C=".$_REQUEST['SIX_Turn_SCA_RBG_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA_RBG=".$_REQUEST['SIX_Turn_SCA_RBG_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SCA_RBG_D']<$bscarbgturnd){
    $mysql="update web_agents_data set SIX_Turn_SCA_RBG_D=".$_REQUEST['SIX_Turn_SCA_RBG_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SCA_RBG=".$_REQUEST['SIX_Turn_SCA_RBG_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_SCA_RBG_SO']<$bscarbgbet){
    $mysql="update web_agents_data set SIX_SCA_RBG_Bet=".$_REQUEST['SIX_SCA_RBG_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_SCA_RBG_Bet=".$_REQUEST['SIX_SCA_RBG_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_SCA_RBG_SC']<$bscarbgscene){
    $mysql="update web_agents_data set SIX_SCA_RBG_Scene=".$_REQUEST['SIX_SCA_RBG_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_SCA_RBG_Scene=".$_REQUEST['SIX_SCA_RBG_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC_A']<$bacturna){
    $mysql="update web_agents_data set SIX_Turn_AC_A=".$_REQUEST['SIX_Turn_AC_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC=".$_REQUEST['SIX_Turn_AC_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC_B']<$bacturnb){
    $mysql="update web_agents_data set SIX_Turn_AC_B=".$_REQUEST['SIX_Turn_AC_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC=".$_REQUEST['SIX_Turn_AC_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC_C']<$bacturnc){
    $mysql="update web_agents_data set SIX_Turn_AC_C=".$_REQUEST['SIX_Turn_AC_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC=".$_REQUEST['SIX_Turn_AC_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC_D']<$bacturnd){
    $mysql="update web_agents_data set SIX_Turn_AC_D=".$_REQUEST['SIX_Turn_AC_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC=".$_REQUEST['SIX_Turn_AC_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_AC_SO']<$bacbet){
    $mysql="update web_agents_data set SIX_AC_Bet=".$_REQUEST['SIX_AC_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_AC_Bet=".$_REQUEST['SIX_AC_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_AC_SC']<$bacscene){
    $mysql="update web_agents_data set SIX_AC_Scene=".$_REQUEST['SIX_AC_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败12!");
	$mysql="update web_member_data set SIX_AC_Scene=".$_REQUEST['SIX_AC_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败21!");
}
if($_REQUEST['SIX_Turn_AC_TOUEO_A']<$bactturna){
    $mysql="update web_agents_data set SIX_Turn_AC_TOUEO_A=".$_REQUEST['SIX_Turn_AC_TOUEO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC_TOUEO=".$_REQUEST['SIX_Turn_AC_TOUEO_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC_TOUEO_B']<$bactturnb){
    $mysql="update web_agents_data set SIX_Turn_AC_TOUEO_B=".$_REQUEST['SIX_Turn_AC_TOUEO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC_TOUEO=".$_REQUEST['SIX_Turn_AC_TOUEO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC_TOUEO_C']<$bactturnc){
    $mysql="update web_agents_data set SIX_Turn_AC_TOUEO_C=".$_REQUEST['SIX_Turn_AC_TOUEO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC_TOUEO=".$_REQUEST['SIX_Turn_AC_TOUEO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC_TOUEO_D']<$bactturnd){
    $mysql="update web_agents_data set SIX_Turn_AC_TOUEO_D=".$_REQUEST['SIX_Turn_AC_TOUEO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC_TOUEO=".$_REQUEST['SIX_Turn_AC_TOUEO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_AC_TOUEO_SO']<$bactbet){
    $mysql="update web_agents_data set SIX_AC_TOUEO_Bet=".$_REQUEST['SIX_AC_TOUEO_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_AC_TOUEO_Bet=".$_REQUEST['SIX_AC_TOUEO_SO']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_AC_TOUEO_SC']<$bactscene){
    $mysql="update web_agents_data set SIX_AC_TOUEO_Scene=".$_REQUEST['SIX_AC_TOUEO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
	$mysql="update web_member_data set SIX_AC_TOUEO_Scene=".$_REQUEST['SIX_AC_TOUEO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
}
if($_REQUEST['SIX_Turn_AC6_AOUEO_A']<$bac6aturna){
    $mysql="update web_agents_data set SIX_Turn_AC6_AOUEO_A=".$_REQUEST['SIX_Turn_AC6_AOUEO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_AOUEO=".$_REQUEST['SIX_Turn_AC6_AOUEO_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC6_AOUEO_B']<$bac6aturnb){
    $mysql="update web_agents_data set SIX_Turn_AC6_AOUEO_B=".$_REQUEST['SIX_Turn_AC6_AOUEO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_AOUEO=".$_REQUEST['SIX_Turn_AC6_AOUEO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC6_AOUEO_C']<$bac6aturnc){
    $mysql="update web_agents_data set SIX_Turn_AC6_AOUEO_C=".$_REQUEST['SIX_Turn_AC6_AOUEO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_AOUEO=".$_REQUEST['SIX_Turn_AC6_AOUEO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC6_AOUEO_D']<$bac6aturnd){
    $mysql="update web_agents_data set SIX_Turn_AC6_AOUEO_D=".$_REQUEST['SIX_Turn_AC6_AOUEO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_AOUEO=".$_REQUEST['SIX_Turn_AC6_AOUEO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_AC6_AOUEO_SO']<$bac6abet){
    $mysql="update web_agents_data set SIX_AC6_AOUEO_Bet=".$_REQUEST['SIX_AC6_AOUEO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_AC6_AOUEO_Bet=".$_REQUEST['SIX_AC6_AOUEO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_AC6_AOUEO_SC']<$bac6ascene){
    $mysql="update web_agents_data set SIX_AC6_AOUEO_Scene=".$_REQUEST['SIX_AC6_AOUEO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
	$mysql="update web_member_data set SIX_AC6_AOUEO_Scene=".$_REQUEST['SIX_AC6_AOUEO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
}
if($_REQUEST['SIX_Turn_AC6_BOUEO_A']<$bac6bturna){
    $mysql="update web_agents_data set SIX_Turn_AC6_BOUEO_A=".$_REQUEST['SIX_Turn_AC6_BOUEO_A']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_BOUEO=".$_REQUEST['SIX_Turn_AC6_BOUEO_A']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC6_BOUEO_B']<$bac6bturnb){
    $mysql="update web_agents_data set SIX_Turn_AC6_BOUEO_B=".$_REQUEST['SIX_Turn_AC6_BOUEO_B']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_BOUEO=".$_REQUEST['SIX_Turn_AC6_BOUEO_B']." where  $agname and OpenType='B'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC6_BOUEO_C']<$bac6bturnc){
    $mysql="update web_agents_data set SIX_Turn_AC6_BOUEO_C=".$_REQUEST['SIX_Turn_AC6_BOUEO_C']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_BOUEO=".$_REQUEST['SIX_Turn_AC6_BOUEO_C']." where  $agname and OpenType='C'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC6_BOUEO_D']<$bac6bturnd){
    $mysql="update web_agents_data set SIX_Turn_AC6_BOUEO_D=".$_REQUEST['SIX_Turn_AC6_BOUEO_D']." where  $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_BOUEO=".$_REQUEST['SIX_Turn_AC6_BOUEO_D']." where  $agname and OpenType='D'";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_AC6_BOUEO_SO']<$bac6bbet){
    $mysql="update web_agents_data set SIX_AC6_BOUEO_Bet=".$_REQUEST['SIX_AC6_BOUEO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_AC6_BOUEO_Bet=".$_REQUEST['SIX_AC6_BOUEO_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_AC6_BOUEO_SC']<$bac6bscene){
    $mysql="update web_agents_data set SIX_AC6_BOUEO_Scene=".$_REQUEST['SIX_AC6_BOUEO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
	$mysql="update web_member_data set SIX_AC6_BOUEO_Scene=".$_REQUEST['SIX_AC6_BOUEO_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
}
if($_REQUEST['SIX_Turn_AC6_RBG_A']<$bac6rbgturn){
    $mysql="update web_agents_data set SIX_Turn_AC6_RBG_A=".$_REQUEST['SIX_Turn_AC6_RBG_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_RBG=".$_REQUEST['SIX_Turn_AC6_RBG_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC6_RBG_B']<$bac6rbgturn){
    $mysql="update web_agents_data set SIX_Turn_AC6_RBG_B=".$_REQUEST['SIX_Turn_AC6_RBG_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_RBG=".$_REQUEST['SIX_Turn_AC6_RBG_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC6_RBG_C']<$bmturn){
    $mysql="update web_agents_data set SIX_Turn_AC6_RBG_C=".$_REQUEST['SIX_Turn_AC6_RBG_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_RBG=".$_REQUEST['SIX_Turn_AC6_RBG_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_AC6_RBG_D']<$bac6rbgturn){
    $mysql="update web_agents_data set SIX_Turn_AC6_RBG_D=".$_REQUEST['SIX_Turn_AC6_RBG_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_AC6_RBG=".$_REQUEST['SIX_Turn_AC6_RBG_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_AC6_RBG_SO']<$bac6rbgbet){
    $mysql="update web_agents_data set SIX_AC6_RBG_Bet=".$_REQUEST['SIX_AC6_RBG_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_AC6_RBG_Bet=".$_REQUEST['SIX_AC6_RBG_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_AC6_RBG_SC']<$bac6rbgscene){
    $mysql="update web_agents_data set SIX_AC6_RBG_Scene=".$_REQUEST['SIX_AC6_RBG_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
	$mysql="update web_member_data set SIX_AC6_RBG_Scene=".$_REQUEST['SIX_AC6_RBG_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
}
if($_REQUEST['SIX_Turn_SX_A']<$bsxturn){
    $mysql="update web_agents_data set SIX_Turn_SX_A=".$_REQUEST['SIX_Turn_SX_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SX=".$_REQUEST['SIX_Turn_SX_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SX_B']<$bsxturn){
    $mysql="update web_agents_data set SIX_Turn_SX_B=".$_REQUEST['SIX_Turn_SX_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SX=".$_REQUEST['SIX_Turn_SX_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SX_C']<$bsxturn){
    $mysql="update web_agents_data set SIX_Turn_SX_C=".$_REQUEST['SIX_Turn_SX_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SX=".$_REQUEST['SIX_Turn_SX_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_SX_D']<$bsxturn){
    $mysql="update web_agents_data set SIX_Turn_SX_D=".$_REQUEST['SIX_Turn_SX_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_SX=".$_REQUEST['SIX_Turn_SX_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_SX_SO']<$bsxbet){
    $mysql="update web_agents_data set SIX_SX_Bet=".$_REQUEST['SIX_SX_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_SX_Bet=".$_REQUEST['SIX_SX_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_SX_SC']<$bsxscene){
    $mysql="update web_agents_data set SIX_SX_Scene=".$_REQUEST['SIX_SX_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败12!");
	$mysql="update web_member_data set SIX_SX_Scene=".$_REQUEST['SIX_SX_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败21!");
}
if($_REQUEST['SIX_Turn_HW_A']<$bhwturn){
    $mysql="update web_agents_data set SIX_Turn_HW_A=".$_REQUEST['SIX_Turn_HW_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_HW=".$_REQUEST['SIX_Turn_HW_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_HW_B']<$bhwturn){
    $mysql="update web_agents_data set SIX_Turn_HW_B=".$_REQUEST['SIX_Turn_HW_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_HW=".$_REQUEST['SIX_Turn_HW_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_HW_C']<$bhwturn){
    $mysql="update web_agents_data set SIX_Turn_HW_C=".$_REQUEST['SIX_Turn_HW_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_HW=".$_REQUEST['SIX_Turn_HW_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_HW_D']<$bhwturn){
    $mysql="update web_agents_data set SIX_Turn_HW_D=".$_REQUEST['SIX_Turn_HW_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_HW=".$_REQUEST['SIX_Turn_HW_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_HW_SO']<$bhwbet){
    $mysql="update web_agents_data set SIX_HW_Bet=".$_REQUEST['SIX_HW_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_HW_Bet=".$_REQUEST['SIX_HW_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_HW_SC']<$bhwscene){
    $mysql="update web_agents_data set SIX_HW_Scene=".$_REQUEST['SIX_HW_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
	$mysql="update web_member_data set SIX_HW_Scene=".$_REQUEST['SIX_HW_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
}
if($_REQUEST['SIX_Turn_MT_A']<$bmtturn){
    $mysql="update web_agents_data set SIX_Turn_MT_A=".$_REQUEST['SIX_Turn_MT_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_MT=".$_REQUEST['SIX_Turn_MT_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_MT_B']<$bmtturn){
    $mysql="update web_agents_data set SIX_Turn_MT_B=".$_REQUEST['SIX_Turn_MT_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_MT=".$_REQUEST['SIX_Turn_MT_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_MT_C']<$bmtturn){
    $mysql="update web_agents_data set SIX_Turn_MT_C=".$_REQUEST['SIX_Turn_MT_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_MT=".$_REQUEST['SIX_Turn_MT_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_MT_D']<$bmtturn){
    $mysql="update web_agents_data set SIX_Turn_MT_D=".$_REQUEST['SIX_Turn_MT_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_MT=".$_REQUEST['SIX_Turn_MT_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_MT_SO']<$bmtbet){
    $mysql="update web_agents_data set SIX_MT_Bet=".$_REQUEST['SIX_MT_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_MT_Bet=".$_REQUEST['SIX_MT_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_MT_SC']<$bmtscene){
    $mysql="update web_agents_data set SIX_MT_Scene=".$_REQUEST['SIX_MT_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
	$mysql="update web_member_data set SIX_MT_Scene=".$_REQUEST['SIX_MT_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
}
if($_REQUEST['SIX_Turn_M_A']<$bmturn){
    $mysql="update web_agents_data set SIX_Turn_M_A=".$_REQUEST['SIX_Turn_M_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_M=".$_REQUEST['SIX_Turn_M_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_M_B']<$bmturn){
    $mysql="update web_agents_data set SIX_Turn_M_B=".$_REQUEST['SIX_Turn_M_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_M=".$_REQUEST['SIX_Turn_M_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_M_C']<$bmturn){
    $mysql="update web_agents_data set SIX_Turn_M_C=".$_REQUEST['SIX_Turn_M_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_M=".$_REQUEST['SIX_Turn_M_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_M_D']<$bmturn){
    $mysql="update web_agents_data set SIX_Turn_M_D=".$_REQUEST['SIX_Turn_M_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_M=".$_REQUEST['SIX_Turn_M_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_M_SO']<$bmbet){
    $mysql="update web_agents_data set SIX_M_Bet=".$_REQUEST['SIX_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_M_Bet=".$_REQUEST['SIX_M_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_M_SC']<$bmscene){
    $mysql="update web_agents_data set SIX_M_Scene=".$_REQUEST['SIX_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
	$mysql="update web_member_data set SIX_M_Scene=".$_REQUEST['SIX_M_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
}
if($_REQUEST['SIX_Turn_EC_A']<$becturn){
    $mysql="update web_agents_data set SIX_Turn_EC_A=".$_REQUEST['SIX_Turn_EC_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_EC=".$_REQUEST['SIX_Turn_EC_A']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_EC_B']<$becturn){
    $mysql="update web_agents_data set SIX_Turn_EC_B=".$_REQUEST['SIX_Turn_EC_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_EC=".$_REQUEST['SIX_Turn_EC_B']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_EC_C']<$becturn){
    $mysql="update web_agents_data set SIX_Turn_EC_C=".$_REQUEST['SIX_Turn_EC_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_EC=".$_REQUEST['SIX_Turn_EC_C']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_Turn_EC_D']<$becturn){
    $mysql="update web_agents_data set SIX_Turn_EC_D=".$_REQUEST['SIX_Turn_EC_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_Turn_EC=".$_REQUEST['SIX_Turn_EC_D']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_EC_SO']<$becbet){
    $mysql="update web_agents_data set SIX_EC_Bet=".$_REQUEST['SIX_EC_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
	$mysql="update web_member_data set SIX_EC_Bet=".$_REQUEST['SIX_EC_SO']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败1!");
}
if($_REQUEST['SIX_EC_SC']<$becscene){
    $mysql="update web_agents_data set SIX_EC_Scene=".$_REQUEST['SIX_EC_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
	$mysql="update web_member_data set SIX_EC_Scene=".$_REQUEST['SIX_EC_SC']." where $agname";
	mysql_db_query($dbname,$mysql) or die ("SIX代理操作失败2!");
}

	$mysql="update web_agents_data set SIX_Turn_SCA_A=".$_REQUEST['SIX_Turn_SCA_A'].",SIX_Turn_SCA_B=".$_REQUEST['SIX_Turn_SCA_B'].",SIX_Turn_SCA_C=".$_REQUEST['SIX_Turn_SCA_C'].",SIX_Turn_SCA_D=".$_REQUEST['SIX_Turn_SCA_D'].",SIX_SCA_Bet=".$_REQUEST['SIX_SCA_SO'].",SIX_SCA_Scene=".$_REQUEST['SIX_SCA_SC'].",SIX_Turn_SCB_A=".$_REQUEST['SIX_Turn_SCB_A'].",SIX_Turn_SCB_B=".$_REQUEST['SIX_Turn_SCB_B'].",SIX_Turn_SCB_C=".$_REQUEST['SIX_Turn_SCB_C'].",SIX_Turn_SCB_D=".$_REQUEST['SIX_Turn_SCB_D'].",SIX_SCB_Bet=".$_REQUEST['SIX_SCB_SO'].",SIX_SCB_Scene=".$_REQUEST['SIX_SCB_SC'].",SIX_Turn_SCA_AOUEO_A=".$_REQUEST['SIX_Turn_SCA_AOUEO_A'].",SIX_Turn_SCA_AOUEO_B=".$_REQUEST['SIX_Turn_SCA_AOUEO_B'].",SIX_Turn_SCA_AOUEO_C=".$_REQUEST['SIX_Turn_SCA_AOUEO_C'].",SIX_Turn_SCA_AOUEO_D=".$_REQUEST['SIX_Turn_SCA_AOUEO_D'].",SIX_SCA_AOUEO_Bet=".$_REQUEST['SIX_SCA_AOUEO_SO'].",SIX_SCA_AOUEO_Scene=".$_REQUEST['SIX_SCA_AOUEO_SC'].",SIX_Turn_SCA_BOUEO_A=".$_REQUEST['SIX_Turn_SCA_BOUEO_A'].",SIX_Turn_SCA_BOUEO_B=".$_REQUEST['SIX_Turn_SCA_BOUEO_B'].",SIX_Turn_SCA_BOUEO_C=".$_REQUEST['SIX_Turn_SCA_BOUEO_C'].",SIX_Turn_SCA_BOUEO_D=".$_REQUEST['SIX_Turn_SCA_BOUEO_D'].",SIX_SCA_BOUEO_Bet=".$_REQUEST['SIX_SCA_BOUEO_SO'].",SIX_SCA_BOUEO_Scene=".$_REQUEST['SIX_SCA_BOUEO_SC'].",SIX_Turn_SCA_RBG_A=".$_REQUEST['SIX_Turn_SCA_RBG_A'].",SIX_Turn_SCA_RBG_B=".$_REQUEST['SIX_Turn_SCA_RBG_B'].",SIX_Turn_SCA_RBG_C=".$_REQUEST['SIX_Turn_SCA_RBG_C'].",SIX_Turn_SCA_RBG_D=".$_REQUEST['SIX_Turn_SCA_RBG_D'].",SIX_SCA_RBG_Bet=".$_REQUEST['SIX_SCA_RBG_SO'].",SIX_SCA_RBG_Scene=".$_REQUEST['SIX_SCA_RBG_SC'].",SIX_Turn_AC_A=".$_REQUEST['SIX_Turn_AC_A'].",SIX_Turn_AC_B=".$_REQUEST['SIX_Turn_AC_B'].",SIX_Turn_AC_C=".$_REQUEST['SIX_Turn_AC_C'].",SIX_Turn_AC_D=".$_REQUEST['SIX_Turn_AC_D'].",SIX_AC_Bet=".$_REQUEST['SIX_AC_SO'].",SIX_AC_Scene=".$_REQUEST['SIX_AC_SC'].",SIX_Turn_AC_TOUEO_A=".$_REQUEST['SIX_Turn_AC_TOUEO_A'].",SIX_Turn_AC_TOUEO_B=".$_REQUEST['SIX_Turn_AC_TOUEO_B'].",SIX_Turn_AC_TOUEO_C=".$_REQUEST['SIX_Turn_AC_TOUEO_C'].",SIX_Turn_AC_TOUEO_D=".$_REQUEST['SIX_Turn_AC_TOUEO_D'].",SIX_AC_TOUEO_Bet=".$_REQUEST['SIX_AC_TOUEO_SO'].",SIX_AC_TOUEO_Scene=".$_REQUEST['SIX_AC_TOUEO_SC'].",SIX_Turn_AC6_AOUEO_A=".$_REQUEST['SIX_Turn_AC6_AOUEO_A'].",SIX_Turn_AC6_AOUEO_B=".$_REQUEST['SIX_Turn_AC6_AOUEO_B'].",SIX_Turn_AC6_AOUEO_C=".$_REQUEST['SIX_Turn_AC6_AOUEO_C'].",SIX_Turn_AC6_AOUEO_D=".$_REQUEST['SIX_Turn_AC6_AOUEO_D'].",SIX_AC6_AOUEO_Bet=".$_REQUEST['SIX_AC6_AOUEO_SO'].",SIX_AC6_AOUEO_Scene=".$_REQUEST['SIX_AC6_AOUEO_SC'].",SIX_Turn_AC6_BOUEO_A=".$_REQUEST['SIX_Turn_AC6_BOUEO_A'].",SIX_Turn_AC6_BOUEO_B=".$_REQUEST['SIX_Turn_AC6_BOUEO_B'].",SIX_Turn_AC6_BOUEO_C=".$_REQUEST['SIX_Turn_AC6_BOUEO_C'].",SIX_Turn_AC6_BOUEO_D=".$_REQUEST['SIX_Turn_AC6_BOUEO_D'].",SIX_AC6_BOUEO_Bet=".$_REQUEST['SIX_AC6_BOUEO_SO'].",SIX_AC6_BOUEO_Scene=".$_REQUEST['SIX_AC6_BOUEO_SC'].",SIX_Turn_AC6_RBG_A=".$_REQUEST['SIX_Turn_AC6_RBG_A'].",SIX_Turn_AC6_RBG_B=".$_REQUEST['SIX_Turn_AC6_RBG_B'].",SIX_Turn_AC6_RBG_C=".$_REQUEST['SIX_Turn_AC6_RBG_C'].",SIX_Turn_AC6_RBG_D=".$_REQUEST['SIX_Turn_AC6_RBG_D'].",SIX_AC6_RBG_Bet=".$_REQUEST['SIX_AC6_RBG_SO'].",SIX_AC6_RBG_Scene=".$_REQUEST['SIX_AC6_RBG_SC'].",SIX_Turn_SX_A=".$_REQUEST['SIX_Turn_SX_A'].",SIX_Turn_SX_B=".$_REQUEST['SIX_Turn_SX_B'].",SIX_Turn_SX_C=".$_REQUEST['SIX_Turn_SX_C'].",SIX_Turn_SX_D=".$_REQUEST['SIX_Turn_SX_D'].",SIX_SX_Bet=".$_REQUEST['SIX_SX_SO'].",SIX_SX_Scene=".$_REQUEST['SIX_SX_SC'].",SIX_Turn_HW_A=".$_REQUEST['SIX_Turn_HW_A'].",SIX_Turn_HW_B=".$_REQUEST['SIX_Turn_HW_B'].",SIX_Turn_HW_C=".$_REQUEST['SIX_Turn_HW_C'].",SIX_Turn_HW_D=".$_REQUEST['SIX_Turn_HW_D'].",SIX_HW_Bet=".$_REQUEST['SIX_HW_SO'].",SIX_HW_Scene=".$_REQUEST['SIX_HW_SC'].",SIX_Turn_MT_A=".$_REQUEST['SIX_Turn_MT_A'].",SIX_Turn_MT_B=".$_REQUEST['SIX_Turn_MT_B'].",SIX_Turn_MT_C=".$_REQUEST['SIX_Turn_MT_C'].",SIX_Turn_MT_D=".$_REQUEST['SIX_Turn_MT_D'].",SIX_MT_Bet=".$_REQUEST['SIX_MT_SO'].",SIX_MT_Scene=".$_REQUEST['SIX_MT_SC'].",SIX_Turn_M_A=".$_REQUEST['SIX_Turn_M_A'].",SIX_Turn_M_B=".$_REQUEST['SIX_Turn_M_B'].",SIX_Turn_M_C=".$_REQUEST['SIX_Turn_M_C'].",SIX_Turn_M_D=".$_REQUEST['SIX_Turn_M_D'].",SIX_M_Bet=".$_REQUEST['SIX_M_SO'].",SIX_M_Scene=".$_REQUEST['SIX_M_SC'].",SIX_Turn_EC_A=".$_REQUEST['SIX_Turn_EC_A'].",SIX_Turn_EC_B=".$_REQUEST['SIX_Turn_EC_B'].",SIX_Turn_EC_C=".$_REQUEST['SIX_Turn_EC_C'].",SIX_Turn_EC_D=".$_REQUEST['SIX_Turn_EC_D'].",SIX_EC_Bet=".$_REQUEST['SIX_EC_SO'].",SIX_EC_Scene=".$_REQUEST['SIX_EC_SC']." where ID='$parents_id'";
	mysql_db_query($dbname,$mysql) or die ("SIX操作失败1!");
	$loginfo='详细设置'.$Title.':'.$username.'六合彩详细设置成功';
	echo "<Script Language=javascript>self.location='user_set.php?uid=$uid&lv=$lv&parents_id=$parents_id&name=$name&langx=$langx';</script>";
	break;
}	
}
function turn_rate($start_rate,$rate_split,$end_rate,$sel_rate){
	$turn_rate='';
	echo $sel_rate;
	echo $end_rate;
	for($i=$start_rate;$i<$end_rate+$rate_split;$i+=$rate_split){
		if ($turn_rate==''){
			$turn_rate='<option>'.$i.'</option>';
		}else if($i==$sel_rate){
			$turn_rate=$turn_rate.'<option selected>'.$i.'</option>';
		}else{
			$turn_rate=$turn_rate.'<option>'.$i.'</option>';
		}
	}
	return $turn_rate;
}
?>
<script>var gtype_arr = new Array('FT','BK','BS','TN','VB','OP','SIX');</script>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_ag_ed {  background-color: #bdd1de; text-align: right}
-->
</style> 
<script src="/js/agents/jquery.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JAVASCRIPT">

var formname1='';

function getfname(eOBJ) {formname1=eOBJ;}

function fkbkreset() {
	if(formname1!='')
	formname1.reset();
}

function count_so(SC,SO)
{
  b=eval(SC.value)/2;
  SO.value=b;
}
function CheckKey(){
	if(event.keyCode < 48 || event.keyCode > 57){alert("僅能輸入數字 !!"); return false;}
}
</SCRIPT>
</head>
<body onBeforeUnload="fkbkreset()" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;
    <?=$Title?>
    -- <?=$Mem_Details?><?=$Mem_Settings?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$Mem_Account?>:<?=$username?>
    -- <?=$Mem_Name?>:<?=$alias?>
    -- <a href="user_browse.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>"><?=$Return_Back?></a></td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>

<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
		<td width="70">足球</td>
		<td width='57'>A</td>
		<td width='57'>B</td>
		<td width='57'>C</td>
		<td width="57">D</td>
		<td width="57">大賠率</td>
		<td width="80">單場限額</td>
		<td width="80">單注限額</td>
    </tr>
	<tr class="m_cen">
		<td align="center">快速<br>選單</td>
		<td><select name='FT_LINE_1'>
			<?
			 ($abcd=$arow["FT_Turn_R_A"] or $abcd=$arow["FT_Turn_OU_A"] or $abcd=$arow["FT_Turn_RE_A"] or $abcd=$arow["FT_Turn_ROU_A"] or $abcd=$arow["FT_Turn_EO_A"]);
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>
		<td><select name='FT_LINE_2'>
			<?
			 ($abcd=$arow["FT_Turn_R_B"] or $abcd=$arow["FT_Turn_OU_B"] or $abcd=$arow["FT_Turn_RE_B"] or $abcd=$arow["FT_Turn_ROU_B"] or $abcd=$arow["FT_Turn_EO_B"]);
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>
		<td><select name='FT_LINE_3'>
			<?
			 ($abcd=$arow["FT_Turn_R_C"] or $abcd=$arow["FT_Turn_OU_C"] or $abcd=$arow["FT_Turn_RE_C"] or $abcd=$arow["FT_Turn_ROU_C"] or $abcd=$arow["FT_Turn_EO_C"]);
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>
		<td><select name='FT_LINE_4'>
			<?
			 ($abcd=$arow["FT_Turn_R_D"] or $abcd=$arow["FT_Turn_OU_D"] or $abcd=$arow["FT_Turn_RE_D"] or $abcd=$arow["FT_Turn_ROU_D"] or $abcd=$arow["FT_Turn_EO_D"]);
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		  </select>
	  </td>
	  <td><select name='FT_LINE_BIG'>
		    <?
			 ($abcd=$arow["FT_Turn_P"] or $abcd=$arow["FT_Turn_M"] or $abcd=$arow["FT_Turn_PD"] or $abcd=$arow["FT_Turn_T"] or $abcd=$arow["FT_Turn_F"] or $abcd=$arow["FT_Turn_P"] or $abcd=$arow["FT_Turn_PR"] or $abcd=$arow["FT_Turn_P3"]);
				for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>	  </select></td>
		<td><input type="text" name="FT_SC" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
		<td><input type="text" name="FT_SO" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
<form name="FT" method="post" action=""> 
    <tr class="m_title_edit" >
      <td width="70">足球</td>
      <td width='57'>讓球</td>
      <td width='57'>大小</td>
      <td width='57'>滾球讓球</td>
      <td width="57">滾球大小</td>
      <td width="57">單雙</td>
      <td width="57">独赢</td>
      <td width="57">滾球独赢</td>
      <td width="57">波膽</td>
      <td width="57">總入球</td>
      <td width="57">半全場</td>
      <td width="57">标准過關</td>
      <td width="57">让球過關</td>
      <td width="57">混合過關</td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td ><select name='FT_Turn_R_A' class='FT_SMALL_1'>
			<?
			$abcde=$row['FT_Turn_R_A'];
			$abcd=$arow['FT_Turn_R_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td ><select name='FT_Turn_OU_A' class='FT_SMALL_1'>
			<?
			$abcde=$row['FT_Turn_OU_A'];
			$abcd=$arow['FT_Turn_OU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
	  <td ><select name='FT_Turn_RE_A' class='FT_SMALL_1'>
			<?
			$abcde=$row['FT_Turn_RE_A'];
			$abcd=$arow['FT_Turn_RE_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select>	  </td>	
      <td><select name='FT_Turn_ROU_A' class='FT_SMALL_1'>
			<?
			$abcde=$row['FT_Turn_ROU_A'];
			$abcd=$arow['FT_Turn_ROU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='FT_Turn_EO_A' class='FT_SMALL_1'>
			<?
			$abcde=$row['FT_Turn_EO_A'];
			$abcd=$arow['FT_Turn_EO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='FT_Turn_M' class='FT_BIG'>
        <?
			$abcde=$row['FT_Turn_M'];
			$abcd=$arow['FT_Turn_M'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='FT_Turn_RM' class='FT_BIG'>
			<?
			$abcde=$row['FT_Turn_RM'];
			$abcd=$arow['FT_Turn_RM'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='FT_Turn_PD' class='FT_BIG'>
			<?
			$abcde=$row['FT_Turn_PD'];
			$abcd=$arow['FT_Turn_PD'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='FT_Turn_T' class='FT_BIG'>
			<?
			$abcde=$row['FT_Turn_T'];
			$abcd=$arow['FT_Turn_T'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='FT_Turn_F' class='FT_BIG'>
			<?
			$abcde=$row['FT_Turn_F'];
			$abcd=$arow['FT_Turn_F'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='FT_Turn_P' class='FT_BIG'>
			<?
			$abcde=$row['FT_Turn_P'];
			$abcd=$arow['FT_Turn_P'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='FT_Turn_PR' class='FT_BIG'>
			<?
			$abcde=$row['FT_Turn_PR'];
			$abcd=$arow['FT_Turn_PR'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='FT_Turn_P3' class='FT_BIG'>
			<?
			$abcde=$row['FT_Turn_P3'];
			$abcd=$arow['FT_Turn_P3'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td ><select name='FT_Turn_R_B' class='FT_SMALL_2'>
			<?
			$abcde=$row['FT_Turn_R_B'];
			$abcd=$arow['FT_Turn_R_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td ><select name='FT_Turn_OU_B' class='FT_SMALL_2'>
			<?
			$abcde=$row['FT_Turn_OU_B'];
			$abcd=$arow['FT_Turn_OU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td ><select name='FT_Turn_RE_B' class='FT_SMALL_2'>
			<?
			$abcde=$row['FT_Turn_RE_B'];
			$abcd=$arow['FT_Turn_RE_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>	
      <td><select name='FT_Turn_ROU_B' class='FT_SMALL_2'>
			<?
			$abcde=$row['FT_Turn_ROU_B'];
			$abcd=$arow['FT_Turn_ROU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='FT_Turn_EO_B' class='FT_SMALL_2'>
			<?
			$abcde=$row['FT_Turn_EO_B'];
			$abcd=$arow['FT_Turn_EO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td ><select name='FT_Turn_R_C' class='FT_SMALL_3'>
			<?
			$abcde=$row['FT_Turn_R_C'];
			$abcd=$arow['FT_Turn_R_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td ><select name='FT_Turn_OU_C' class='FT_SMALL_3'>
			<?
			$abcde=$row['FT_Turn_OU_C'];
			$abcd=$arow['FT_Turn_OU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
		<td ><select name='FT_Turn_RE_C' class='FT_SMALL_3'>
			<?
			$abcde=$row['FT_Turn_RE_C'];
			$abcd=$arow['FT_Turn_RE_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>	
		<td><select name='FT_Turn_ROU_C' class='FT_SMALL_3'>
			<?
			$abcde=$row['FT_Turn_ROU_C'];
			$abcd=$arow['FT_Turn_ROU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td><select name='FT_Turn_EO_C' class='FT_SMALL_3'>
			<?
			$abcde=$row['FT_Turn_EO_C'];
			$abcd=$arow['FT_Turn_EO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td ><select name='FT_Turn_R_D' class='FT_SMALL_4'>
			<?
			$abcde=$row['FT_Turn_R_D'];
			$abcd=$arow['FT_Turn_R_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td ><select name='FT_Turn_OU_D' class='FT_SMALL_4'>
			<?
			$abcde=$row['FT_Turn_OU_D'];
			$abcd=$arow['FT_Turn_OU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td ><select name='FT_Turn_RE_D' class='FT_SMALL_4'>
			<?
			$abcde=$row['FT_Turn_RE_D'];
			$abcd=$arow['FT_Turn_RE_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>	
      <td><select name='FT_Turn_ROU_D' class='FT_SMALL_4'>
			<?
			$abcde=$row['FT_Turn_ROU_D'];
			$abcd=$arow['FT_Turn_ROU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='FT_Turn_EO_D' class='FT_SMALL_4'>
			<?
			$abcde=$row['FT_Turn_EO_D'];
			$abcd=$arow['FT_Turn_EO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單場限額</td>
	  <td ><input name=FT_R_SC type="text" value="<?=$row['FT_R_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_R_SC,document.FT.FT_R_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=FT_OU_SC type="text" value="<?=$row['FT_OU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_OU_SC,document.FT.FT_OU_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=FT_RE_SC type="text" value="<?=$row['FT_RE_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_RE_SC,document.FT.FT_RE_SO)" onKeyPress="return CheckKey();"></td>	
      <td><input name=FT_ROU_SC type="text" value="<?=$row['FT_ROU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_ROU_SC,document.FT.FT_ROU_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=FT_EO_SC type="text" value="<?=$row['FT_EO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_EO_SC,document.FT.FT_EO_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=FT_M_SC type="text" value="<?=$row['FT_M_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_M_SC,document.FT.FT_M_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=FT_RM_SC type="text" value="<?=$row['FT_RM_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_RM_SC,document.FT.FT_RM_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=FT_PD_SC type="text" value="<?=$row['FT_PD_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_PD_SC,document.FT.FT_PD_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=FT_T_SC type="text" value="<?=$row['FT_T_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_T_SC,document.FT.FT_T_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=FT_F_SC type="text" value="<?=$row['FT_F_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_F_SC,document.FT.FT_F_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=FT_P_SC type="text" value="<?=$row['FT_P_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_P_SC,document.FT.FT_P_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=FT_PR_SC type="text" value="<?=$row['FT_PR_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_PR_SC,document.FT.FT_PR_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=FT_P3_SC type="text" value="<?=$row['FT_P3_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.FT.FT_P3_SC,document.FT.FT_P3_SO)" onKeyPress="return CheckKey();"></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單注限額</td>
	  <td><input name=FT_R_SO type="text" value="<?=$row['FT_R_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=FT_R_TC value=0>
	  <td><input name=FT_OU_SO type="text" value="<?=$row['FT_OU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=FT_OU_TC value=0> 
	  <td><input name=FT_RE_SO type="text" value="<?=$row['FT_RE_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=FT_RE_TC value=0>	
      <td><input name=FT_ROU_SO type="text" value="<?=$row['FT_ROU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=FT_ROU_TC value=0> 
      <td><input name=FT_EO_SO type="text" value="<?=$row['FT_EO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=FT_EO_TC value=0>
	  <td><input name=FT_M_SO type="text" value="<?=$row['FT_M_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=FT_M_TC value=0>
	  <td><input name=FT_RM_SO type="text" value="<?=$row['FT_RM_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=FT_RM_TC value=0>
      <td><input name=FT_PD_SO type="text" value="<?=$row['FT_PD_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=FT_PD_TC value=0> 
      <td><input name=FT_T_SO type="text" value="<?=$row['FT_T_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=FT_T_TC value=0>
      <td><input name=FT_F_SO type="text" value="<?=$row['FT_F_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=FT_F_TC value=0>
      <td><input name=FT_P_SO type="text" value="<?=$row['FT_P_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=FT_P_TC value=0>
      <td><input name=FT_PR_SO type="text" value="<?=$row['FT_PR_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=FT_PR_TC value=0>
      <td><input name=FT_P3_SO type="text" value="<?=$row['FT_P3_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=FT_P3_TC value=0>     
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="13" ><input type="submit" name="ft_ch_ok" value="確定" class="za_button" onClick="getfname(document.FT)"></td> 
  </tr>
      <input type=hidden name=active value="edit_conf">
      <input type=hidden name=gtype value="FT">
  	  <input type=hidden name=id value="<?=$id?>">
  	  <input type=hidden name=parents_id value="<?=$parents_id?>">
  	  <input type=hidden name=lv value="<?=$lv?>">
</form> 
</table>
<BR>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
		<td width="70">篮球</td>
		<td width='57'>A</td>
		<td width='57'>B</td>
		<td width='57'>C</td>
		<td width="57">D</td>
		<td width="57">大賠率</td>
		<td width="80">單場限額</td>
		<td width="80">單注限額</td>
    </tr>
	<tr class="m_cen">
		<td align="center" rowspan="2">快速<br>選單</td>
		<td><select name='BK_LINE_1'>
			<? 
			 ($abcd=$arow["BK_Turn_R_A"] or $abcd=$arow["BK_Turn_OU_A"] or $abcd=$arow["BK_Turn_VR_A"] or $abcd=$arow["BK_Turn_VOU_A"] or $abcd=$arow["BK_Turn_RE_A"] or $abcd=$arow["BK_Turn_ROU_A"] or $abcd=$arow["BK_Turn_VRE_A"] or $abcd=$arow["BK_Turn_VROU_A"] or $abcd=$arow["BK_Turn_EO_A"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	    </select></td>
		<td><select name='BK_LINE_2'>
			<? 
			 ($abcd=$arow["BK_Turn_R_B"] or $abcd=$arow["BK_Turn_OU_B"] or $abcd=$arow["BK_Turn_VR_B"] or $abcd=$arow["BK_Turn_VOU_B"] or $abcd=$arow["BK_Turn_RE_B"] or $abcd=$arow["BK_Turn_ROU_B"] or $abcd=$arow["BK_Turn_VRE_B"] or $abcd=$arow["BK_Turn_VROU_B"] or $abcd=$arow["BK_Turn_EO_B"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	    </select></td>
		<td><select name='BK_LINE_3'>
			<? 
			 ($abcd=$arow["BK_Turn_R_C"] or $abcd=$arow["BK_Turn_OU_C"] or $abcd=$arow["BK_Turn_VR_C"] or $abcd=$arow["BK_Turn_VOU_C"] or $abcd=$arow["BK_Turn_RE_C"] or $abcd=$arow["BK_Turn_ROU_C"] or $abcd=$arow["BK_Turn_VRE_C"] or $abcd=$arow["BK_Turn_VROU_C"] or $abcd=$arow["BK_Turn_EO_C"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	    </select></td>
		<td><select name='BK_LINE_4'>
			<? 
			 ($abcd=$arow["BK_Turn_R_D"] or $abcd=$arow["BK_Turn_OU_D"] or $abcd=$arow["BK_Turn_VR_D"] or $abcd=$arow["BK_Turn_VOU_D"] or $abcd=$arow["BK_Turn_RE_D"] or $abcd=$arow["BK_Turn_ROU_D"] or $abcd=$arow["BK_Turn_VRE_D"] or $abcd=$arow["BK_Turn_VROU_D"] or $abcd=$arow["BK_Turn_EO_D"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
		  </select>
	    </td>
	    <td><select name='BK_LINE_BIG'>
		    <?
			 $abcd=$arow["BK_Turn_PR"];
				for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
		</select></td>
		<td><input type="text" name="BK_SC" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
		<td><input type="text" name="BK_SO" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
<form name="BK" method="post" action=""> 
    <tr class="m_title_edit" >
      <td width="70">篮球</td>
      <td width='57'>讓球</td>
      <td width='57'>大小</td>
      <td width='57'>滾球讓球</td>
      <td width="57">滾球大小</td>
      <td width="57">單雙</td>
      <td width="57">讓球過關</td>
      <td width="57">混合過關</td>
      <td width="57">冠军</td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><select name='BK_Turn_R_A' class='BK_SMALL_1'>
			<?
			$abcde=$row['BK_Turn_R_A'];
			$abcd=$arow['BK_Turn_R_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td><select name='BK_Turn_OU_A' class='BK_SMALL_1'>
			<?
			$abcde=$row['BK_Turn_OU_A'];
			$abcd=$arow['BK_Turn_OU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
	  <td><select name='BK_Turn_RE_A' class='BK_SMALL_1'>
			<?
			$abcde=$row['BK_Turn_RE_A'];
			$abcd=$arow['BK_Turn_RE_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select>	  </td>	
      <td><select name='BK_Turn_ROU_A' class='BK_SMALL_1'>
			<?
			$abcde=$row['BK_Turn_ROU_A'];
			$abcd=$arow['BK_Turn_ROU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='BK_Turn_EO_A' class='BK_SMALL_1'>
			<?
			$abcde=$row['BK_Turn_EO_A'];
			$abcd=$arow['BK_Turn_EO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='BK_Turn_PR' class='BK_BIG'>
        <?
			$abcde=$row['BK_Turn_PR'];
			$abcd=$arow['BK_Turn_PR'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='BK_Turn_P3' class='BK_BIG'>
			<?
			$abcde=$row['BK_Turn_P3'];
			$abcd=$arow['BK_Turn_P3'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='FS_Turn_FS' class='BK_BIG'>
			<?
			$abcde=$row['FS_Turn_FS'];
			$abcd=$arow['FS_Turn_FS'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><select name='BK_Turn_R_B' class='BK_SMALL_2'>
			<?
			$abcde=$row['BK_Turn_R_B'];
			$abcd=$arow['BK_Turn_R_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td><select name='BK_Turn_OU_B' class='BK_SMALL_2'>
			<?
			$abcde=$row['BK_Turn_OU_B'];
			$abcd=$arow['BK_Turn_OU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td><select name='BK_Turn_RE_B' class='BK_SMALL_2'>
			<?
			$abcde=$row['BK_Turn_RE_B'];
			$abcd=$arow['BK_Turn_RE_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>	
      <td><select name='BK_Turn_ROU_B' class='BK_SMALL_2'>
			<?
			$abcde=$row['BK_Turn_ROU_B'];
			$abcd=$arow['BK_Turn_ROU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='BK_Turn_EO_B' class='BK_SMALL_2'>
			<?
			$abcde=$row['BK_Turn_EO_B'];
			$abcd=$arow['BK_Turn_EO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td ><select name='BK_Turn_R_C' class='BK_SMALL_3'>
			<?
			$abcde=$row['BK_Turn_R_C'];
			$abcd=$arow['BK_Turn_R_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td ><select name='BK_Turn_OU_C' class='BK_SMALL_3'>
			<?
			$abcde=$row['BK_Turn_OU_C'];
			$abcd=$arow['BK_Turn_OU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
		<td ><select name='BK_Turn_RE_C' class='BK_SMALL_3'>
			<?
			$abcde=$row['BK_Turn_RE_C'];
			$abcd=$arow['BK_Turn_RE_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>	
		<td><select name='BK_Turn_ROU_C' class='BK_SMALL_3'>
			<?
			$abcde=$row['BK_Turn_ROU_C'];
			$abcd=$arow['BK_Turn_ROU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td><select name='BK_Turn_EO_C' class='BK_SMALL_3'>
			<?
			$abcde=$row['BK_Turn_EO_C'];
			$abcd=$arow['BK_Turn_EO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td ><select name='BK_Turn_R_D' class='BK_SMALL_4'>
			<?
			$abcde=$row['BK_Turn_R_D'];
			$abcd=$arow['BK_Turn_R_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td ><select name='BK_Turn_OU_D' class='BK_SMALL_4'>
			<?
			$abcde=$row['BK_Turn_OU_D'];
			$abcd=$arow['BK_Turn_OU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td ><select name='BK_Turn_RE_D' class='BK_SMALL_4'>
			<?
			$abcde=$row['BK_Turn_RE_D'];
			$abcd=$arow['BK_Turn_RE_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>	
      <td><select name='BK_Turn_ROU_D' class='BK_SMALL_4'>
			<?
			$abcde=$row['BK_Turn_ROU_D'];
			$abcd=$arow['BK_Turn_ROU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='BK_Turn_EO_D' class='BK_SMALL_4'>
			<?
			$abcde=$row['BK_Turn_EO_D'];
			$abcd=$arow['BK_Turn_EO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單場限額</td>
	  <td ><input name=BK_R_SC type="text" value="<?=$row['BK_R_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BK.BK_R_SC,document.BK.BK_R_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=BK_OU_SC type="text" value="<?=$row['BK_OU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BK.BK_OU_SC,document.BK.BK_OU_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=BK_RE_SC type="text" value="<?=$row['BK_RE_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BK.BK_RE_SC,document.BK.BK_RE_SO)" onKeyPress="return CheckKey();"></td>	
      <td><input name=BK_ROU_SC type="text" value="<?=$row['BK_ROU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BK.BK_ROU_SC,document.BK.BK_ROU_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=BK_EO_SC type="text" value="<?=$row['BK_EO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BK.BK_EO_SC,document.BK.BK_EO_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=BK_PR_SC type="text" value="<?=$row['BK_PR_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BK.BK_PR_SC,document.BK.BK_PR_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=BK_P3_SC type="text" value="<?=$row['BK_P3_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BK.BK_P3_SC,document.BK.BK_P3_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=FS_FS_SC type="text" value="<?=$row['FS_FS_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BK.FS_FS_SC,document.BK.FS_FS_SO)" onKeyPress="return CheckKey();"></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單注限額</td>
	  <td><input name=BK_R_SO type="text" value="<?=$row['BK_R_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=BK_R_TC value=0>
	  <td><input name=BK_OU_SO type="text" value="<?=$row['BK_OU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=BK_OU_TC value=0> 
	  <td><input name=BK_RE_SO type="text" value="<?=$row['BK_RE_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=BK_RE_TC value=0>	
      <td><input name=BK_ROU_SO type="text" value="<?=$row['BK_ROU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=BK_ROU_TC value=0>
      <td><input name=BK_EO_SO type="text" value="<?=$row['BK_EO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=BK_EO_TC value=0>
      <td><input name=BK_PR_SO type="text" value="<?=$row['BK_PR_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=BK_PR_TC value=0>
      <td><input name=BK_P3_SO type="text" value="<?=$row['BK_P3_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=BK_P3_TC value=0>
      <td><input name=FS_FS_SO type="text" value="<?=$row['FS_FS_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=FS_FS_TC value=0>     
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="8" ><input type="submit" name="bk_ch_ok" value="確定" class="za_button" onClick="getfname(document.BK)"></td> 
  </tr>
      <input type=hidden name=active value="edit_conf">
      <input type=hidden name=gtype value="BK">
  	  <input type=hidden name=id value="<?=$id?>">
  	  <input type=hidden name=parents_id value="<?=$parents_id?>">
  	  <input type=hidden name=lv value="<?=$lv?>">
</form> 
</table>
<BR>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed" width="560">
    <tr class="m_title_edit" >
		<td width="70">棒球</td>
		<td width='57'>A</td>
		<td width='57'>B</td>
		<td width='57'>C</td>
		<td width="57">D</td>
		<td width="57">大賠率</td>
		<td width="80">單場限額</td>
		<td width="80">單注限額</td>
    </tr>
	<tr class="m_cen">
		<td align="center" rowspan="2">快速<br>選單</td>
		<td><select name='BS_LINE_1'>
			<? 
			 ($abcd=$arow["BS_Turn_R_A"] or $abcd=$arow["BS_Turn_OU_A"] or $abcd=$arow["BS_Turn_VR_A"] or $abcd=$arow["BS_Turn_VOU_A"] or $abcd=$arow["BS_Turn_RE_A"] or $abcd=$arow["BS_Turn_ROU_A"] or $abcd=$arow["BS_Turn_VRE_A"] or $abcd=$arow["BS_Turn_VROU_A"] or $abcd=$arow["BS_Turn_EO_A"] or $abcd=$arow["BS_Turn_1X2_A"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><select name='BS_LINE_2'>
			<? 
			 ($abcd=$arow["BS_Turn_R_B"] or $abcd=$arow["BS_Turn_OU_B"] or $abcd=$arow["BS_Turn_VR_B"] or $abcd=$arow["BS_Turn_VOU_B"] or $abcd=$arow["BS_Turn_RE_B"] or $abcd=$arow["BS_Turn_ROU_B"] or $abcd=$arow["BS_Turn_VRE_B"] or $abcd=$arow["BS_Turn_VROU_B"] or $abcd=$arow["BS_Turn_EO_B"] or $abcd=$arow["BS_Turn_1X2_B"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><select name='BS_LINE_3'>
			<? 
			 ($abcd=$arow["BS_Turn_R_C"] or $abcd=$arow["BS_Turn_OU_C"] or $abcd=$arow["BS_Turn_VR_C"] or $abcd=$arow["BS_Turn_VOU_C"] or $abcd=$arow["BS_Turn_RE_C"] or $abcd=$arow["BS_Turn_ROU_C"] or $abcd=$arow["BS_Turn_VRE_C"] or $abcd=$arow["BS_Turn_VROU_C"] or $abcd=$arow["BS_Turn_EO_C"] or $abcd=$arow["BS_Turn_1X2_C"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><select name='BS_LINE_4'>
			<? 
			 ($abcd=$arow["BS_Turn_R_D"] or $abcd=$arow["BS_Turn_OU_D"] or $abcd=$arow["BS_Turn_VR_D"] or $abcd=$arow["BS_Turn_VOU_D"] or $abcd=$arow["BS_Turn_RE_D"] or $abcd=$arow["BS_Turn_ROU_D"] or $abcd=$arow["BS_Turn_VRE_D"] or $abcd=$arow["BS_Turn_VROU_D"] or $abcd=$arow["BS_Turn_EO_D"] or $abcd=$arow["BS_Turn_1X2_D"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
		  </select>
	  </td>
	  <td><select name='BS_LINE_BIG'>
		    <?
			 ($abcd=$arow["BS_Turn_P"] or $abcd=$arow["BS_Turn_M"] or $abcd=$arow["BS_Turn_PD"] or $abcd=$arow["BS_Turn_T"] or $abcd=$arow["BS_Turn_PR"]);
				for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><input type="text" name="BS_SC" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
		<td><input type="text" name="BS_SO" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
<form name="BS" method="post" action=""> 
    <tr class="m_title_edit" >
      <td width="70">棒球</td>
      <td width='57'>讓球</td>
      <td width='57'>大小</td>
      <td width='57'>滾球讓球</td>
      <td width="57">滾球大小</td>
      <td width="57">單雙</td>
      <td width="57">独赢</td>
      <td width="57">波膽</td>
      <td width="57">總入球</td>
      <td width="57">標準過關</td>
      <td width="57">讓球過關</td>
      <td width="57">混合過關</td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><select name='BS_Turn_R_A' class='BS_SMALL_1'>
			<?
			$abcde=$row['BS_Turn_R_A'];
			$abcd=$arow['BS_Turn_R_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td><select name='BS_Turn_OU_A' class='BS_SMALL_1'>
			<?
			$abcde=$row['BS_Turn_OU_A'];
			$abcd=$arow['BS_Turn_OU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
	  <td><select name='BS_Turn_RE_A' class='BS_SMALL_1'>
			<?
			$abcde=$row['BS_Turn_RE_A'];
			$abcd=$arow['BS_Turn_RE_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select>	  </td>	
      <td><select name='BS_Turn_ROU_A' class='BS_SMALL_1'>
			<?
			$abcde=$row['BS_Turn_ROU_A'];
			$abcd=$arow['BS_Turn_ROU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='BS_Turn_EO_A' class='BS_SMALL_1'>
			<?
			$abcde=$row['BS_Turn_EO_A'];
			$abcd=$arow['BS_Turn_EO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='BS_Turn_M' class='BS_BIG'>
			<?
			$abcde=$row['BS_Turn_M'];
			$abcd=$arow['BS_Turn_M'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='BS_Turn_PD' class='BS_BIG'>
			<?
			$abcde=$row['BS_Turn_PD'];
			$abcd=$arow['BS_Turn_PD'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='BS_Turn_T' class='BS_BIG'>
			<?
			$abcde=$row['BS_Turn_T'];
			$abcd=$arow['BS_Turn_T'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='BS_Turn_P' class='BS_BIG'>
			<?
			$abcde=$row['BS_Turn_P'];
			$abcd=$arow['BS_Turn_P'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='BS_Turn_PR' class='BS_BIG'>
			<?
			$abcde=$row['BS_Turn_PR'];
			$abcd=$arow['BS_Turn_PR'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='BS_Turn_P3' class='BS_BIG'>
			<?
			$abcde=$row['BS_Turn_P3'];
			$abcd=$arow['BS_Turn_P3'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><select name='BS_Turn_R_B' class='BS_SMALL_2'>
			<?
			$abcde=$row['BS_Turn_R_B'];
			$abcd=$arow['BS_Turn_R_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td><select name='BS_Turn_OU_B' class='BS_SMALL_2'>
			<?
			$abcde=$row['BS_Turn_OU_B'];
			$abcd=$arow['BS_Turn_OU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td><select name='BS_Turn_RE_B' class='BS_SMALL_2'>
			<?
			$abcde=$row['BS_Turn_RE_B'];
			$abcd=$arow['BS_Turn_RE_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>	
      <td><select name='BS_Turn_ROU_B' class='BS_SMALL_2'>
			<?
			$abcde=$row['BS_Turn_ROU_B'];
			$abcd=$arow['BS_Turn_ROU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='BS_Turn_EO_B' class='BS_SMALL_2'>
			<?
			$abcde=$row['BS_Turn_EO_B'];
			$abcd=$arow['BS_Turn_EO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
    </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><select name='BS_Turn_R_C' class='BS_SMALL_3'>
			<?
			$abcde=$row['BS_Turn_R_C'];
			$abcd=$arow['BS_Turn_R_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td><select name='BS_Turn_OU_C' class='BS_SMALL_3'>
			<?
			$abcde=$row['BS_Turn_OU_C'];
			$abcd=$arow['BS_Turn_OU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}

			}
			?>
        </select></td>
		<td><select name='BS_Turn_RE_C' class='BS_SMALL_3'>
			<?
			$abcde=$row['BS_Turn_RE_C'];
			$abcd=$arow['BS_Turn_RE_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>	
		<td><select name='BS_Turn_ROU_C' class='BS_SMALL_3'>
			<?
			$abcde=$row['BS_Turn_ROU_C'];
			$abcd=$arow['BS_Turn_ROU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td><select name='BS_Turn_EO_C' class='BS_SMALL_3'>
			<?
			$abcde=$row['BS_Turn_EO_C'];
			$abcd=$arow['BS_Turn_EO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><select name='BS_Turn_R_D' class='BS_SMALL_4'>
			<?
			$abcde=$row['BS_Turn_R_D'];
			$abcd=$arow['BS_Turn_R_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='BS_Turn_OU_D' class='BS_SMALL_4'>
			<?
			$abcde=$row['BS_Turn_OU_D'];
			$abcd=$arow['BS_Turn_OU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='BS_Turn_RE_D' class='BS_SMALL_4'>
			<?
			$abcde=$row['BS_Turn_RE_D'];
			$abcd=$arow['BS_Turn_RE_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>	
      <td><select name='BS_Turn_ROU_D' class='BS_SMALL_4'>
			<?
			$abcde=$row['BS_Turn_ROU_D'];
			$abcd=$arow['BS_Turn_ROU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='BS_Turn_EO_D' class='BS_SMALL_4'>
			<?
			$abcde=$row['BS_Turn_EO_D'];
			$abcd=$arow['BS_Turn_EO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
    </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單場限額</td>
	  <td ><input name=BS_R_SC type="text" value="<?=$row['BS_R_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_R_SC,document.BS.BS_R_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=BS_OU_SC type="text" value="<?=$row['BS_OU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_OU_SC,document.BS.BS_OU_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=BS_RE_SC type="text" value="<?=$row['BS_RE_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_RE_SC,document.BS.BS_RE_SO)" onKeyPress="return CheckKey();"></td>	
      <td><input name=BS_ROU_SC type="text" value="<?=$row['BS_ROU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_ROU_SC,document.BS.BS_ROU_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=BS_EO_SC type="text" value="<?=$row['BS_EO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_EO_SC,document.BS.BS_EO_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=BS_M_SC type="text" value="<?=$row['BS_M_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_M_SC,document.BS.BS_M_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=BS_PD_SC type="text" value="<?=$row['BS_PD_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_PD_SC,document.BS.BS_PD_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=BS_T_SC type="text" value="<?=$row['BS_T_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_T_SC,document.BS.BS_T_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=BS_P_SC type="text" value="<?=$row['BS_P_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_P_SC,document.BS.BS_P_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=BS_PR_SC type="text" value="<?=$row['BS_PR_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_PR_SC,document.BS.BS_PR_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=BS_P3_SC type="text" value="<?=$row['BS_P3_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.BS.BS_P3_SC,document.BS.BS_P3_SO)" onKeyPress="return CheckKey();"></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單注限額</td>
	  <td><input name=BS_R_SO type="text" value="<?=$row['BS_R_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=BS_R_TC value=0>
	  <td><input name=BS_OU_SO type="text" value="<?=$row['BS_OU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=BS_OU_TC value=0> 
	  <input type=hidden name=BS_VR_TC value=0>
	  <input type=hidden name=BS_VOU_TC value=0>
	  <td><input name=BS_RE_SO type="text" value="<?=$row['BS_RE_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=BS_RE_TC value=0>	
      <td><input name=BS_ROU_SO type="text" value="<?=$row['BS_ROU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=BS_ROU_TC value=0>
      <input type=hidden name=BS_VRE_TC value=0> 
      <input type=hidden name=BS_VROU_TC value=0> 
      <td><input name=BS_EO_SO type="text" value="<?=$row['BS_EO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=BS_EO_TC value=0>
	  <input type=hidden name=BS_1X2_TC value=0>
	  <td><input name=BS_M_SO type="text" value="<?=$row['BS_M_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=BS_M_TC value=0>
      <td><input name=BS_PD_SO type="text" value="<?=$row['BS_PD_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=BS_PD_TC value=0> 
      <td><input name=BS_T_SO type="text" value="<?=$row['BS_T_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=BS_T_TC value=0>
      <input type=hidden name=BS_F_TC value=0>
      <td><input name=BS_P_SO type="text" value="<?=$row['BS_P_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=BS_P_TC value=0>
      <td><input name=BS_PR_SO type="text" value="<?=$row['BS_PR_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=BS_PR_TC value=0>
      <td><input name=BS_P3_SO type="text" value="<?=$row['BS_P3_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=BS_P3_TC value=0>     
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="11"><input type="submit" name="bs_ch_ok" value="確定" class="za_button" onClick="getfname(document.BS)"></td> 
  </tr>
      <input type=hidden name=active value="edit_conf">
      <input type=hidden name=gtype value="BS">
  	  <input type=hidden name=id value="<?=$id?>">
  	  <input type=hidden name=parents_id value="<?=$parents_id?>">
  	  <input type=hidden name=lv value="<?=$lv?>">
</form> 
</table>
<BR>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed" width="560">
    <tr class="m_title_edit" >
		<td width="70">网球</td>
		<td width='57'>A</td>
		<td width='57'>B</td>
		<td width='57'>C</td>
		<td width="57">D</td>
		<td width="57">大賠率</td>
		<td width="80">單場限額</td>
		<td width="80">單注限額</td>
    </tr>
	<tr class="m_cen">
		<td align="center" rowspan="2">快速<br>選單</td>
		<td><select name='TN_LINE_1'>
		    <?
			 ($abcd=$arow["TN_Turn_R_A"] or $abcd=$arow["TN_Turn_OU_A"] or $abcd=$arow["TN_Turn_RE_A"] or $abcd=$arow["TN_Turn_ROU_A"] or $abcd=$arow["TN_Turn_EO_A"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><select name='TN_LINE_2'>
		    <?
			 ($abcd=$arow["TN_Turn_R_B"] or $abcd=$arow["TN_Turn_OU_B"] or $abcd=$arow["TN_Turn_RE_B"] or $abcd=$arow["TN_Turn_ROU_B"] or $abcd=$arow["TN_Turn_EO_B"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><select name='TN_LINE_3'>
		    <?
			 ($abcd=$arow["TN_Turn_R_C"] or $abcd=$arow["TN_Turn_OU_C"] or $abcd=$arow["TN_Turn_RE_C"] or $abcd=$arow["TN_Turn_ROU_C"] or $abcd=$arow["TN_Turn_EO_C"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><select name='TN_LINE_4'>
		    <?
			 ($abcd=$arow["TN_Turn_R_D"] or $abcd=$arow["TN_Turn_OU_D"] or $abcd=$arow["TN_Turn_RE_D"] or $abcd=$arow["TN_Turn_ROU_D"] or $abcd=$arow["TN_Turn_EO_D"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
		  </select>
	  </td>
	  <td><select name='TN_LINE_BIG'>
		    <?
			 ($abcd=$arow["TN_Turn_P"] or $abcd=$arow["TN_Turn_M"] or $abcd=$arow["TN_Turn_PD"] or $abcd=$arow["TN_Turn_PR"]);
				for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><input type="text" name="TN_SC" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
		<td><input type="text" name="TN_SO" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
<form name="TN" method="post" action=""> 
    <tr class="m_title_edit" >
      <td width="70">网球</td>
      <td width='57'>讓球</td>
      <td width='57'>大小</td>
      <td width='57'>滾球讓球</td>
      <td width="57">滾球大小</td>
      <td width="57">單雙</td>
      <td width="57">独赢</td>
      <td width="57">波膽</td>
      <td width="57">標準過關</td>
      <td width="57">讓球過關</td>
      <td width="57">混合過關</td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><select name='TN_Turn_R_A' class='TN_SMALL_1'>
			<?
			$abcde=$row['TN_Turn_R_A'];
			$abcd=$arow['TN_Turn_R_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td><select name='TN_Turn_OU_A' class='TN_SMALL_1'>
			<?
			$abcde=$row['TN_Turn_OU_A'];
			$abcd=$arow['TN_Turn_OU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
	  <td><select name='TN_Turn_RE_A' class='TN_SMALL_1'>
			<?
			$abcde=$row['TN_Turn_RE_A'];
			$abcd=$arow['TN_Turn_RE_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select>	  </td>	
      <td><select name='TN_Turn_ROU_A' class='TN_SMALL_1'>
			<?
			$abcde=$row['TN_Turn_ROU_A'];
			$abcd=$arow['TN_Turn_ROU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='TN_Turn_EO_A' class='TN_SMALL_1'>
			<?
			$abcde=$row['TN_Turn_EO_A'];
			$abcd=$arow['TN_Turn_EO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='TN_Turn_M' class='TN_BIG'>
			<?
			$abcde=$row['TN_Turn_M'];
			$abcd=$arow['TN_Turn_M'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='TN_Turn_PD' class='TN_BIG'>
			<?
			$abcde=$row['TN_Turn_PD'];
			$abcd=$arow['TN_Turn_PD'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='TN_Turn_P' class='TN_BIG'>
			<?
			$abcde=$row['TN_Turn_P'];
			$abcd=$arow['TN_Turn_P'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='TN_Turn_PR' class='TN_BIG'>
			<?
			$abcde=$row['TN_Turn_PR'];
			$abcd=$arow['TN_Turn_PR'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='TN_Turn_P3' class='TN_BIG'>
			<?
			$abcde=$row['TN_Turn_P3'];
			$abcd=$arow['TN_Turn_P3'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><select name='TN_Turn_R_B' class='TN_SMALL_2'>
			<?
			$abcde=$row['TN_Turn_R_B'];
			$abcd=$arow['TN_Turn_R_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td><select name='TN_Turn_OU_B' class='TN_SMALL_2'>
			<?
			$abcde=$row['TN_Turn_OU_B'];
			$abcd=$arow['TN_Turn_OU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td><select name='TN_Turn_RE_B' class='TN_SMALL_2'>
			<?
			$abcde=$row['TN_Turn_RE_B'];
			$abcd=$arow['TN_Turn_RE_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>	
      <td><select name='TN_Turn_ROU_B' class='TN_SMALL_2'>
			<?
			$abcde=$row['TN_Turn_ROU_B'];
			$abcd=$arow['TN_Turn_ROU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='TN_Turn_EO_B' class='TN_SMALL_2'>
			<?
			$abcde=$row['TN_Turn_EO_B'];
			$abcd=$arow['TN_Turn_EO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><select name='TN_Turn_R_C' class='TN_SMALL_3'>
			<?
			$abcde=$row['TN_Turn_R_C'];
			$abcd=$arow['TN_Turn_R_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td><select name='TN_Turn_OU_C' class='TN_SMALL_3'>
			<?
			$abcde=$row['TN_Turn_OU_C'];
			$abcd=$arow['TN_Turn_OU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
		<td><select name='TN_Turn_RE_C' class='TN_SMALL_3'>
			<?
			$abcde=$row['TN_Turn_RE_C'];
			$abcd=$arow['TN_Turn_RE_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>	
		<td><select name='TN_Turn_ROU_C' class='TN_SMALL_3'>
			<?
			$abcde=$row['TN_Turn_ROU_C'];
			$abcd=$arow['TN_Turn_ROU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td><select name='TN_Turn_EO_C' class='TN_SMALL_3'>
			<?
			$abcde=$row['TN_Turn_EO_C'];
			$abcd=$arow['TN_Turn_EO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><select name='TN_Turn_R_D' class='TN_SMALL_4'>
			<?
			$abcde=$row['TN_Turn_R_D'];
			$abcd=$arow['TN_Turn_R_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='TN_Turn_OU_D' class='TN_SMALL_4'>
			<?
			$abcde=$row['TN_Turn_OU_D'];
			$abcd=$arow['TN_Turn_OU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='TN_Turn_RE_D' class='TN_SMALL_4'>
			<?
			$abcde=$row['TN_Turn_RE_D'];
			$abcd=$arow['TN_Turn_RE_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>	
      <td><select name='TN_Turn_ROU_D' class='TN_SMALL_4'>
			<?
			$abcde=$row['TN_Turn_ROU_D'];
			$abcd=$arow['TN_Turn_ROU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='TN_Turn_EO_D' class='TN_SMALL_4'>
			<?
			$abcde=$row['TN_Turn_EO_D'];
			$abcd=$arow['TN_Turn_EO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單場限額</td>
	  <td ><input name=TN_R_SC type="text" value="<?=$row['TN_R_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.TN.TN_R_SC,document.TN.TN_R_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=TN_OU_SC type="text" value="<?=$row['TN_OU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.TN.TN_OU_SC,document.TN.TN_OU_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=TN_RE_SC type="text" value="<?=$row['TN_RE_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.TN.TN_RE_SC,document.TN.TN_RE_SO)" onKeyPress="return CheckKey();"></td>	
      <td><input name=TN_ROU_SC type="text" value="<?=$row['TN_ROU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.TN.TN_ROU_SC,document.TN.TN_ROU_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=TN_EO_SC type="text" value="<?=$row['TN_EO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.TN.TN_EO_SC,document.TN.TN_EO_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=TN_M_SC type="text" value="<?=$row['TN_M_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.TN.TN_M_SC,document.TN.TN_M_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=TN_PD_SC type="text" value="<?=$row['TN_PD_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.TN.TN_PD_SC,document.TN.TN_PD_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=TN_P_SC type="text" value="<?=$row['TN_P_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.TN.TN_P_SC,document.TN.TN_P_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=TN_PR_SC type="text" value="<?=$row['TN_PR_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.TN.TN_PR_SC,document.TN.TN_PR_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=TN_P3_SC type="text" value="<?=$row['TN_P3_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.TN.TN_P3_SC,document.TN.TN_P3_SO)" onKeyPress="return CheckKey();"></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單注限額</td>
	  <td><input name=TN_R_SO type="text" value="<?=$row['TN_R_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=TN_R_TC value=0>
	  <td><input name=TN_OU_SO type="text" value="<?=$row['TN_OU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=TN_OU_TC value=0> 
	  <td><input name=TN_RE_SO type="text" value="<?=$row['TN_RE_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=TN_RE_TC value=0>	
      <td><input name=TN_ROU_SO type="text" value="<?=$row['TN_ROU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=TN_ROU_TC value=0>
      <td><input name=TN_EO_SO type="text" value="<?=$row['TN_EO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=TN_EO_TC value=0>
	  <td><input name=TN_M_SO type="text" value="<?=$row['TN_M_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=TN_M_TC value=0>
      <td><input name=TN_PD_SO type="text" value="<?=$row['TN_PD_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=TN_PD_TC value=0> 
      <td><input name=TN_P_SO type="text" value="<?=$row['TN_P_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=TN_P_TC value=0>
      <td><input name=TN_PR_SO type="text" value="<?=$row['TN_PR_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=TN_PR_TC value=0>
      <td><input name=TN_P3_SO type="text" value="<?=$row['TN_P3_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=TN_P3_TC value=0>     
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="10" ><input type="submit" name="tn_ch_ok" value="確定" class="za_button" onClick="getfname(document.TN)"></td> 
  </tr>
      <input type=hidden name=active value="edit_conf">
      <input type=hidden name=gtype value="TN">
  	  <input type=hidden name=id value="<?=$id?>">
  	  <input type=hidden name=parents_id value="<?=$parents_id?>">
  	  <input type=hidden name=lv value="<?=$lv?>">
</form> 
</table>
<BR>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed" width="560">
    <tr class="m_title_edit" >
		<td width="70">排球</td>
		<td width='57'>A</td>
		<td width='57'>B</td>
		<td width='57'>C</td>
		<td width="57">D</td>
		<td width="57">大賠率</td>
		<td width="80">單場限額</td>
		<td width="80">單注限額</td>
    </tr>
	<tr class="m_cen">
		<td align="center" rowspan="2">快速<br>選單</td>
		<td><select name='VB_LINE_1'>
		    <?
			 ($abcd=$arow["VB_Turn_R_A"] or $abcd=$arow["VB_Turn_OU_A"] or $abcd=$arow["VB_Turn_RE_A"] or $abcd=$arow["VB_Turn_ROU_A"] or $abcd=$arow["VB_Turn_EO_A"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><select name='VB_LINE_2'>
		    <?
			 ($abcd=$arow["VB_Turn_R_B"] or $abcd=$arow["VB_Turn_OU_B"] or $abcd=$arow["VB_Turn_RE_B"] or $abcd=$arow["VB_Turn_ROU_B"] or $abcd=$arow["VB_Turn_EO_B"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><select name='VB_LINE_3'>
		    <?
			 ($abcd=$arow["VB_Turn_R_C"] or $abcd=$arow["VB_Turn_OU_C"] or $abcd=$arow["VB_Turn_RE_C"] or $abcd=$arow["VB_Turn_ROU_C"] or $abcd=$arow["VB_Turn_EO_C"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><select name='VB_LINE_4'>
		    <?
			 ($abcd=$arow["VB_Turn_R_D"] or $abcd=$arow["VB_Turn_OU_D"] or $abcd=$arow["VB_Turn_RE_D"] or $abcd=$arow["VB_Turn_ROU_D"] or $abcd=$arow["VB_Turn_EO_D"]);
				for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
		  </select>
	  </td>
	  <td><select name='VB_LINE_BIG'>
		    <?
			 ($abcd=$arow["VB_Turn_P"] or $abcd=$arow["VB_Turn_M"] or $abcd=$arow["VB_Turn_PD"] or $abcd=$arow["VB_Turn_PR"]);
				for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>
	  </select></td>
		<td><input type="text" name="VB_SC" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
		<td><input type="text" name="VB_SO" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
<form name="VB" method="post" action=""> 
    <tr class="m_title_edit" >
      <td width="70">排球</td>
      <td width='57'>讓球</td>
      <td width='57'>大小</td>
      <td width='57'>滾球讓球</td>
      <td width="57">滾球大小</td>
      <td width="57">單雙</td>
      <td width="57">独赢</td>
      <td width="57">波膽</td>
      <td width="57">標準過關</td>
      <td width="57">讓球過關</td>
      <td width="57">混合過關</td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><select name='VB_Turn_R_A' class='VB_SMALL_1'>
			<?
			$abcde=$row['VB_Turn_R_A'];
			$abcd=$arow['VB_Turn_R_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td><select name='VB_Turn_OU_A' class='VB_SMALL_1'>
			<?
			$abcde=$row['VB_Turn_OU_A'];
			$abcd=$arow['VB_Turn_OU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
	  <td><select name='VB_Turn_RE_A' class='VB_SMALL_1'>
			<?
			$abcde=$row['VB_Turn_RE_A'];
			$abcd=$arow['VB_Turn_RE_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select>	  </td>	
      <td><select name='VB_Turn_ROU_A' class='VB_SMALL_1'>
			<?
			$abcde=$row['VB_Turn_ROU_A'];
			$abcd=$arow['VB_Turn_ROU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='VB_Turn_EO_A' class='VB_SMALL_1'>
			<?
			$abcde=$row['VB_Turn_EO_A'];
			$abcd=$arow['VB_Turn_EO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='VB_Turn_M' class='VB_BIG'>
			<?
			$abcde=$row['VB_Turn_M'];
			$abcd=$arow['VB_Turn_M'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='VB_Turn_PD' class='VB_BIG'>
			<?
			$abcde=$row['VB_Turn_PD'];
			$abcd=$arow['VB_Turn_PD'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='VB_Turn_P' class='VB_BIG'>
			<?
			$abcde=$row['VB_Turn_P'];
			$abcd=$arow['VB_Turn_P'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='VB_Turn_PR' class='VB_BIG'>
			<?
			$abcde=$row['VB_Turn_PR'];
			$abcd=$arow['VB_Turn_PR'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='VB_Turn_P3' class='VB_BIG'>
			<?
			$abcde=$row['VB_Turn_P3'];
			$abcd=$arow['VB_Turn_P3'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><select name='VB_Turn_R_B' class='VB_SMALL_2'>
			<?
			$abcde=$row['VB_Turn_R_B'];
			$abcd=$arow['VB_Turn_R_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td><select name='VB_Turn_OU_B' class='VB_SMALL_2'>
			<?
			$abcde=$row['VB_Turn_OU_B'];
			$abcd=$arow['VB_Turn_OU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	    <td><select name='VB_Turn_RE_B' class='VB_SMALL_2'>
			<?
			$abcde=$row['VB_Turn_RE_B'];
			$abcd=$arow['VB_Turn_RE_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>	
        <td><select name='VB_Turn_ROU_B' class='VB_SMALL_2'>
			<?
			$abcde=$row['VB_Turn_ROU_B'];
			$abcd=$arow['VB_Turn_ROU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
        <td><select name='VB_Turn_EO_B' class='VB_SMALL_2'>
			<?
			$abcde=$row['VB_Turn_EO_B'];
			$abcd=$arow['VB_Turn_EO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><select name='VB_Turn_R_C' class='VB_SMALL_3'>
			<?
			$abcde=$row['VB_Turn_R_C'];
			$abcd=$arow['VB_Turn_R_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td><select name='VB_Turn_OU_C' class='VB_SMALL_3'>
			<?
			$abcde=$row['VB_Turn_OU_C'];
			$abcd=$arow['VB_Turn_OU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
		<td><select name='VB_Turn_RE_C' class='VB_SMALL_3'>
			<?
			$abcde=$row['VB_Turn_RE_C'];
			$abcd=$arow['VB_Turn_RE_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>	
		<td><select name='VB_Turn_ROU_C' class='VB_SMALL_3'>
			<?
			$abcde=$row['VB_Turn_ROU_C'];
			$abcd=$arow['VB_Turn_ROU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td><select name='VB_Turn_EO_C' class='VB_SMALL_3'>
			<?
			$abcde=$row['VB_Turn_EO_C'];
			$abcd=$arow['VB_Turn_EO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><select name='VB_Turn_R_D' class='VB_SMALL_4'>
			<?
			$abcde=$row['VB_Turn_R_D'];
			$abcd=$arow['VB_Turn_R_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='VB_Turn_OU_D' class='VB_SMALL_4'>
			<?
			$abcde=$row['VB_Turn_OU_D'];
			$abcd=$arow['VB_Turn_OU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='VB_Turn_RE_D' class='VB_SMALL_4'>
			<?
			$abcde=$row['VB_Turn_RE_D'];
			$abcd=$arow['VB_Turn_RE_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>	
      <td><select name='VB_Turn_ROU_D' class='VB_SMALL_4'>
			<?
			$abcde=$row['VB_Turn_ROU_D'];
			$abcd=$arow['VB_Turn_ROU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='VB_Turn_EO_D' class='VB_SMALL_4'>
			<?
			$abcde=$row['VB_Turn_EO_D'];
			$abcd=$arow['VB_Turn_EO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單場限額</td>
	  <td ><input name=VB_R_SC type="text" value="<?=$row['VB_R_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.VB.VB_R_SC,document.VB.VB_R_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=VB_OU_SC type="text" value="<?=$row['VB_OU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.VB.VB_OU_SC,document.VB.VB_OU_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=VB_RE_SC type="text" value="<?=$row['VB_RE_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.VB.VB_RE_SC,document.VB.VB_RE_SO)" onKeyPress="return CheckKey();"></td>	
      <td><input name=VB_ROU_SC type="text" value="<?=$row['VB_ROU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.VB.VB_ROU_SC,document.VB.VB_ROU_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=VB_EO_SC type="text" value="<?=$row['VB_EO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.VB.VB_EO_SC,document.VB.VB_EO_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=VB_M_SC type="text" value="<?=$row['VB_M_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.VB.VB_M_SC,document.VB.VB_M_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=VB_PD_SC type="text" value="<?=$row['VB_PD_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.VB.VB_PD_SC,document.VB.VB_PD_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=VB_P_SC type="text" value="<?=$row['VB_P_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.VB.VB_P_SC,document.VB.VB_P_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=VB_PR_SC type="text" value="<?=$row['VB_PR_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.VB.VB_PR_SC,document.VB.VB_PR_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=VB_P3_SC type="text" value="<?=$row['VB_P3_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.VB.VB_P3_SC,document.VB.VB_P3_SO)" onKeyPress="return CheckKey();"></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單注限額</td>
	  <td><input name=VB_R_SO type="text" value="<?=$row['VB_R_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=VB_R_TC value=0>
	  <td><input name=VB_OU_SO type="text" value="<?=$row['VB_OU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=VB_OU_TC value=0> 
	  <td><input name=VB_RE_SO type="text" value="<?=$row['VB_RE_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=VB_RE_TC value=0>	
      <td><input name=VB_ROU_SO type="text" value="<?=$row['VB_ROU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=VB_ROU_TC value=0>
      <td><input name=VB_EO_SO type="text" value="<?=$row['VB_EO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=VB_EO_TC value=0>
	  <td><input name=VB_M_SO type="text" value="<?=$row['VB_M_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=VB_M_TC value=0>
      <td><input name=VB_PD_SO type="text" value="<?=$row['VB_PD_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=VB_PD_TC value=0> 
      <td><input name=VB_P_SO type="text" value="<?=$row['VB_P_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=VB_P_TC value=0>
      <td><input name=VB_PR_SO type="text" value="<?=$row['VB_PR_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=VB_PR_TC value=0>
      <td><input name=VB_P3_SO type="text" value="<?=$row['VB_P3_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=VB_P3_TC value=0>     
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="10" ><input type="submit" name="tn_ch_ok" value="確定" class="za_button" onClick="getfname(document.VB)"></td> 
  </tr>
      <input type=hidden name=active value="edit_conf">
      <input type=hidden name=gtype value="VB">
  	  <input type=hidden name=id value="<?=$id?>">
  	  <input type=hidden name=parents_id value="<?=$parents_id?>">
  	  <input type=hidden name=lv value="<?=$lv?>">
</form> 
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
		<td width="70">其它</td>
		<td width='57'>A</td>
		<td width='57'>B</td>
		<td width='57'>C</td>
		<td width="57">D</td>
		<td width="57">大賠率</td>
		<td width="80">單場限額</td>
		<td width="80">單注限額</td>
    </tr>
	<tr class="m_cen">
		<td align="center">快速<br>選單</td>
		<td><select name='OP_LINE_1'>
			<?
			 ($abcd=$arow["OP_Turn_R_A"] or $abcd=$arow["OP_Turn_OU_A"] or $abcd=$arow["OP_Turn_VR_A"] or $abcd=$arow["OP_Turn_VOU_A"] or $abcd=$arow["OP_Turn_RE_A"] or $abcd=$arow["OP_Turn_ROU_A"] or $abcd=$arow["OP_Turn_VRE_A"] or $abcd=$arow["OP_Turn_VROU_A"] or $abcd=$arow["OP_Turn_EO_A"]);
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>
		<td><select name='OP_LINE_2'>
			<?
			 ($abcd=$arow["OP_Turn_R_B"] or $abcd=$arow["OP_Turn_OU_B"] or $abcd=$arow["OP_Turn_VR_B"] or $abcd=$arow["OP_Turn_VOU_B"] or $abcd=$arow["OP_Turn_RE_B"] or $abcd=$arow["OP_Turn_ROU_B"] or $abcd=$arow["OP_Turn_VRE_B"] or $abcd=$arow["OP_Turn_VROU_B"] or $abcd=$arow["OP_Turn_EO_B"]);
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>
		<td><select name='OP_LINE_3'>
			<?
			 ($abcd=$arow["OP_Turn_R_C"] or $abcd=$arow["OP_Turn_OU_C"] or $abcd=$arow["OP_Turn_VR_C"] or $abcd=$arow["OP_Turn_VOU_C"] or $abcd=$arow["OP_Turn_RE_C"] or $abcd=$arow["OP_Turn_ROU_C"] or $abcd=$arow["OP_Turn_VRE_C"] or $abcd=$arow["OP_Turn_VROU_C"] or $abcd=$arow["OP_Turn_EO_C"]);
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>
		<td><select name='OP_LINE_4'>
			<?
			 ($abcd=$arow["OP_Turn_R_D"] or $abcd=$arow["OP_Turn_OU_D"] or $abcd=$arow["OP_Turn_VR_D"] or $abcd=$arow["OP_Turn_VOU_D"] or $abcd=$arow["OP_Turn_RE_D"] or $abcd=$arow["OP_Turn_ROU_D"] or $abcd=$arow["OP_Turn_VRE_D"] or $abcd=$arow["OP_Turn_VROU_D"] or $abcd=$arow["OP_Turn_EO_D"]);
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		  </select>
	  </td>
	  <td><select name='OP_LINE_BIG'>
		    <?
			 ($abcd=$arow["OP_Turn_P"] or $abcd=$arow["OP_Turn_M"] or $abcd=$arow["OP_Turn_PD"] or $abcd=$arow["OP_Turn_T"] or $abcd=$arow["OP_Turn_F"] or $abcd=$arow["OP_Turn_PR"]);
				for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}	
			?>	  </select></td>
		<td><input type="text" name="OP_SC" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
		<td><input type="text" name="OP_SO" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
<form name="OP" method="post" action=""> 
    <tr class="m_title_edit" >
      <td width="70">其它</td>
      <td width='57'>讓球</td>
      <td width='57'>大小</td>
      <td width='57'>滾球讓球</td>
      <td width="57">滾球大小</td>
      <td width="57">單雙</td>
      <td width="57">独赢</td>
      <td width="57">波膽</td>
      <td width="57">總入球</td>
      <td width="57">半全場</td>
      <td width="57">標準過關</td>
      <td width="57">讓球過關</td>
      <td width="57">混合過關</td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><select name='OP_Turn_R_A' class='OP_SMALL_1'>
			<?
			$abcde=$row['OP_Turn_R_A'];
			$abcd=$arow['OP_Turn_R_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td><select name='OP_Turn_OU_A' class='OP_SMALL_1'>
			<?
			$abcde=$row['OP_Turn_OU_A'];
			$abcd=$arow['OP_Turn_OU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
	  <td><select name='OP_Turn_RE_A' class='OP_SMALL_1'>
			<?
			$abcde=$row['OP_Turn_RE_A'];
			$abcd=$arow['OP_Turn_RE_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select>	  </td>	
      <td><select name='OP_Turn_ROU_A' class='OP_SMALL_1'>
			<?
			$abcde=$row['OP_Turn_ROU_A'];
			$abcd=$arow['OP_Turn_ROU_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='OP_Turn_EO_A' class='OP_SMALL_1'>
			<?
			$abcde=$row['OP_Turn_EO_A'];
			$abcd=$arow['OP_Turn_EO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='OP_Turn_M' class='OP_BIG'>
			<?
			$abcde=$row['OP_Turn_M'];
			$abcd=$arow['OP_Turn_M'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='OP_Turn_PD' class='OP_BIG'>
			<?
			$abcde=$row['OP_Turn_PD'];
			$abcd=$arow['OP_Turn_PD'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='OP_Turn_T' class='OP_BIG'>
			<?
			$abcde=$row['OP_Turn_T'];
			$abcd=$arow['OP_Turn_T'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='OP_Turn_F' class='OP_BIG'>
			<?
			$abcde=$row['OP_Turn_F'];
			$abcd=$arow['OP_Turn_F'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='OP_Turn_P' class='OP_BIG'>
			<?
			$abcde=$row['OP_Turn_P'];
			$abcd=$arow['OP_Turn_P'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='OP_Turn_PR' class='OP_BIG'>
        <?
			$abcde=$row['OP_Turn_PR'];
			$abcd=$arow['OP_Turn_PR'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td rowspan="4"><select name='OP_Turn_P3' class='OP_BIG'>
			<?
			$abcde=$row['OP_Turn_P3'];
			$abcd=$arow['OP_Turn_P3'];
			for($i=$abcd;$i>=0;$i=$i-1){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><select name='OP_Turn_R_B' class='OP_SMALL_2'>
			<?
			$abcde=$row['OP_Turn_R_B'];
			$abcd=$arow['OP_Turn_R_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td><select name='OP_Turn_OU_B' class='OP_SMALL_2'>
			<?
			$abcde=$row['OP_Turn_OU_B'];
			$abcd=$arow['OP_Turn_OU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	    <td><select name='OP_Turn_RE_B' class='OP_SMALL_2'>
			<?
			$abcde=$row['OP_Turn_RE_B'];
			$abcd=$arow['OP_Turn_RE_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>	
        <td><select name='OP_Turn_ROU_B' class='OP_SMALL_2'>
			<?
			$abcde=$row['OP_Turn_ROU_B'];
			$abcd=$arow['OP_Turn_ROU_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='OP_Turn_EO_B' class='OP_SMALL_2'>
			<?
			$abcde=$row['OP_Turn_EO_B'];
			$abcd=$arow['OP_Turn_EO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><select name='OP_Turn_R_C' class='OP_SMALL_3'>
			<?
			$abcde=$row['OP_Turn_R_C'];
			$abcd=$arow['OP_Turn_R_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td><select name='OP_Turn_OU_C' class='OP_SMALL_3'>
			<?
			$abcde=$row['OP_Turn_OU_C'];
			$abcd=$arow['OP_Turn_OU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
		<td><select name='OP_Turn_RE_C' class='OP_SMALL_3'>
			<?
			$abcde=$row['OP_Turn_RE_C'];
			$abcd=$arow['OP_Turn_RE_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>	
		<td><select name='OP_Turn_ROU_C' class='OP_SMALL_3'>
			<?
			$abcde=$row['OP_Turn_ROU_C'];
			$abcd=$arow['OP_Turn_ROU_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td><select name='OP_Turn_EO_C' class='OP_SMALL_3'>
			<?
			$abcde=$row['OP_Turn_EO_C'];
			$abcd=$arow['OP_Turn_EO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><select name='OP_Turn_R_D' class='OP_SMALL_4'>
			<?
			$abcde=$row['OP_Turn_R_D'];
			$abcd=$arow['OP_Turn_R_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='OP_Turn_OU_D' class='OP_SMALL_4'>
			<?
			$abcde=$row['OP_Turn_OU_D'];
			$abcd=$arow['OP_Turn_OU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='OP_Turn_RE_D' class='OP_SMALL_4'>
			<?
			$abcde=$row['OP_Turn_RE_D'];
			$abcd=$arow['OP_Turn_RE_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>	
      <td><select name='OP_Turn_ROU_D' class='OP_SMALL_4'>
			<?
			$abcde=$row['OP_Turn_ROU_D'];
			$abcd=$arow['OP_Turn_ROU_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='OP_Turn_EO_D' class='OP_SMALL_4'>
			<?
			$abcde=$row['OP_Turn_EO_D'];
			$abcd=$arow['OP_Turn_EO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.25){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單場限額</td>
	  <td ><input name=OP_R_SC type="text" value="<?=$row['OP_R_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_R_SC,document.OP.OP_R_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=OP_OU_SC type="text" value="<?=$row['OP_OU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_OU_SC,document.OP.OP_OU_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=OP_RE_SC type="text" value="<?=$row['OP_RE_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_RE_SC,document.OP.OP_RE_SO)" onKeyPress="return CheckKey();"></td>	
      <td><input name=OP_ROU_SC type="text" value="<?=$row['OP_ROU_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_ROU_SC,document.OP.OP_ROU_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=OP_EO_SC type="text" value="<?=$row['OP_EO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_EO_SC,document.OP.OP_EO_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=OP_M_SC type="text" value="<?=$row['OP_M_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_M_SC,document.OP.OP_M_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=OP_PD_SC type="text" value="<?=$row['OP_PD_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_PD_SC,document.OP.OP_PD_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=OP_T_SC type="text" value="<?=$row['OP_T_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_T_SC,document.OP.OP_T_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=OP_F_SC type="text" value="<?=$row['OP_F_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_F_SC,document.OP.OP_F_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=OP_P_SC type="text" value="<?=$row['OP_P_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_P_SC,document.OP.OP_P_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=OP_PR_SC type="text" value="<?=$row['OP_PR_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_PR_SC,document.OP.OP_PR_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=OP_P3_SC type="text" value="<?=$row['OP_P3_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.OP.OP_P3_SC,document.OP.OP_P3_SO)" onKeyPress="return CheckKey();"></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單注限額</td>
	  <td><input name=OP_R_SO type="text" value="<?=$row['OP_R_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=OP_R_TC value=0>
	  <td><input name=OP_OU_SO type="text" value="<?=$row['OP_OU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=OP_OU_TC value=0> 
	  <td><input name=OP_RE_SO type="text" value="<?=$row['OP_RE_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=OP_RE_TC value=0>	
      <td><input name=OP_ROU_SO type="text" value="<?=$row['OP_ROU_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=OP_ROU_TC value=0>
      <td><input name=OP_EO_SO type="text" value="<?=$row['OP_EO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=OP_EO_TC value=0>
	  <td><input name=OP_M_SO type="text" value="<?=$row['OP_M_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=OP_M_TC value=0>
      <td><input name=OP_PD_SO type="text" value="<?=$row['OP_PD_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=OP_PD_TC value=0> 
      <td><input name=OP_T_SO type="text" value="<?=$row['OP_T_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=OP_T_TC value=0>
      <td><input name=OP_F_SO type="text" value="<?=$row['OP_F_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=OP_F_TC value=0>
      <td><input name=OP_P_SO type="text" value="<?=$row['OP_P_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=OP_P_TC value=0>
      <td><input name=OP_PR_SO type="text" value="<?=$row['OP_PR_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=OP_PR_TC value=0>
      <td><input name=OP_P3_SO type="text" value="<?=$row['OP_P3_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=OP_P3_TC value=0>     
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="12" ><input type="submit" name="op_ch_ok" value="確定" class="za_button" onClick="getfname(document.OP)"></td> 
  </tr>
      <input type=hidden name=active value="edit_conf">
      <input type=hidden name=gtype value="OP">
  	  <input type=hidden name=id value="<?=$id?>">
  	  <input type=hidden name=parents_id value="<?=$parents_id?>">
  	  <input type=hidden name=lv value="<?=$lv?>">
</form> 
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
		<td width="70">六合彩</td>
		<td width='57'>A</td>
		<td width='57'>B</td>
		<td width='57'>C</td>
		<td width="57">D</td>
		<td width="80">單場限額</td>
		<td width="80">單注限額</td>
    </tr>
	<tr class="m_cen">
		<td align="center">快速<br>選單</td>
		<td><select name='SIX_LINE_1'>
			<?
			 ($abcd=$arow["SIX_Turn_SCA_A"] or $abcd=$arow["SIX_Turn_SCB_A"] or $abcd=$arow["SIX_Turn_SCA_AOUEO_A"] or $abcd=$arow["SIX_Turn_SCA_BOUEO_A"] or $abcd=$arow["SIX_Turn_SCA_RBG_A"] or $abcd=$arow["SIX_Turn_AC_A"] or $abcd=$arow["SIX_Turn_AC_TOUEO_A"] or $abcd=$arow["SIX_Turn_AC6_AOUEO_A"] or $abcd=$arow["SIX_Turn_AC6_BOUEO_A"] or $abcd=$arow["SIX_Turn_AC6_RBG_A"] or $abcd=$arow["SIX_Turn_SX_A"] or $abcd=$arow["SIX_Turn_HW_A"] or $abcd=$arow["SIX_Turn_MT_A"] or $abcd=$arow["FT_Turn_M_A"] or $abcd=$arow["FT_Turn_EC_A"]);
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>
		<td><select name='SIX_LINE_2'>
			<?
			 ($abcd=$arow["SIX_Turn_SCA_B"] or $abcd=$arow["SIX_Turn_SCB_B"] or $abcd=$arow["SIX_Turn_SCA_AOUEO_B"] or $abcd=$arow["SIX_Turn_SCA_BOUEO_B"] or $abcd=$arow["SIX_Turn_SCA_RBG_B"] or $abcd=$arow["SIX_Turn_AC_B"] or $abcd=$arow["SIX_Turn_AC_TOUEO_B"] or $abcd=$arow["SIX_Turn_AC6_AOUEO_B"] or $abcd=$arow["SIX_Turn_AC6_BOUEO_B"] or $abcd=$arow["SIX_Turn_AC6_RBG_B"] or $abcd=$arow["SIX_Turn_SX_B"] or $abcd=$arow["SIX_Turn_HW_B"] or $abcd=$arow["SIX_Turn_MT_B"]);
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>
		<td><select name='SIX_LINE_3'>
			<?
			 ($abcd=$arow["SIX_Turn_SCA_C"] or $abcd=$arow["SIX_Turn_SCB_C"] or $abcd=$arow["SIX_Turn_SCA_AOUEO_C"] or $abcd=$arow["SIX_Turn_SCA_BOUEO_C"] or $abcd=$arow["SIX_Turn_SCA_RBG_C"] or $abcd=$arow["SIX_Turn_AC_C"] or $abcd=$arow["SIX_Turn_AC_TOUEO_C"] or $abcd=$arow["SIX_Turn_AC6_AOUEO_C"] or $abcd=$arow["SIX_Turn_AC6_BOUEO_C"] or $abcd=$arow["SIX_Turn_AC6_RBG_C"] or $abcd=$arow["SIX_Turn_SX_C"] or $abcd=$arow["SIX_Turn_HW_C"] or $abcd=$arow["SIX_Turn_MT_C"]);
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>
		<td><select name='SIX_LINE_4'>
			<?
			 ($abcd=$arow["SIX_Turn_SCA_D"] or $abcd=$arow["SIX_Turn_SCB_D"] or $abcd=$arow["SIX_Turn_SCA_AOUEO_D"] or $abcd=$arow["SIX_Turn_SCA_BOUEO_D"] or $abcd=$arow["SIX_Turn_SCA_RBG_D"] or $abcd=$arow["SIX_Turn_AC_D"] or $abcd=$arow["SIX_Turn_AC_TOUEO_D"] or $abcd=$arow["SIX_Turn_AC6_AOUEO_D"] or $abcd=$arow["SIX_Turn_AC6_BOUEO_D"] or $abcd=$arow["SIX_Turn_AC6_RBG_D"] or $abcd=$arow["SIX_Turn_SX_D"] or $abcd=$arow["SIX_Turn_HW_D"] or $abcd=$arow["SIX_Turn_MT_D"]);
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcd){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		  </select>
	  </td>
		<td><input type="text" name="SIX_SC" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
		<td><input type="text" name="SIX_SO" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
<form name="SIX" method="post" action=""> 
    <tr class="m_title_edit" >
      <td width="70">六合彩</td>
      <td width='57'>特码A</td>
      <td width='57'>特码B</td>
      <td width='57'>特<br>单双大小</td>
      <td width='57'>合<br>单双大小</td>
      <td width='57'>特码色波</td>
      <td width="57">正码</td>
      <td width="57">正码总<br>单双大小</td>
      <td width="57">正码1-6<br>单双大小</td>
      <td width="57">正码1-6<br>合单双大小</td>
      <td width="57">正码1-6<br>色波</td>
      <td width="57">特玛生肖</td>
      <td width="57">半波</td>
      <td width="57">多肖尾数</td>
      <td width="57">多肖</td>
      <td width="57">连码</td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td ><select name='SIX_Turn_SCA_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_SCA_A'];
			$abcd=$arow['SIX_Turn_SCA_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td ><select name='SIX_Turn_SCB_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_SCB_A'];
			$abcd=$arow['SIX_Turn_SCB_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
	  <td ><select name='SIX_Turn_SCA_AOUEO_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_SCA_AOUEO_A'];
			$abcd=$arow['SIX_Turn_SCA_AOUEO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
	  <td ><select name='SIX_Turn_SCA_BOUEO_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_SCA_BOUEO_A'];
			$abcd=$arow['SIX_Turn_SCA_BOUEO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
	  <td ><select name='SIX_Turn_SCA_RBG_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_SCA_RBG_A'];
			$abcd=$arow['SIX_Turn_SCA_RBG_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select>	  </td>	
      <td><select name='SIX_Turn_AC_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_AC_A'];
			$abcd=$arow['SIX_Turn_AC_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_AC_TOUEO_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_AC_TOUEO_A'];
			$abcd=$arow['SIX_Turn_AC_TOUEO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_AC6_AOUEO_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_AC6_AOUEO_A'];
			$abcd=$arow['SIX_Turn_AC6_AOUEO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_AC6_BOUEO_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_AC6_BOUEO_A'];
			$abcd=$arow['SIX_Turn_AC6_BOUEO_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_AC6_RBG_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_AC6_RBG_A'];
			$abcd=$arow['SIX_Turn_AC6_RBG_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_SX_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_SX_A'];
			$abcd=$arow['SIX_Turn_SX_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_HW_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_HW_A'];
			$abcd=$arow['SIX_Turn_HW_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_MT_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_MT_A'];
			$abcd=$arow['SIX_Turn_MT_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_M_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_M_A'];
			$abcd=$arow['SIX_Turn_M_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_EC_A' class='SIX_SMALL_1'>
			<?
			$abcde=$row['SIX_Turn_EC_A'];
			$abcd=$arow['SIX_Turn_EC_A'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td ><select name='SIX_Turn_SCA_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_SCA_B'];
			$abcd=$arow['SIX_Turn_SCA_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td ><select name='SIX_Turn_SCB_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_SCB_B'];
			$abcd=$arow['SIX_Turn_SCB_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
	  <td ><select name='SIX_Turn_SCA_AOUEO_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_SCA_AOUEO_B'];
			$abcd=$arow['SIX_Turn_SCA_AOUEO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
	  <td ><select name='SIX_Turn_SCA_BOUEO_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_SCA_BOUEO_B'];
			$abcd=$arow['SIX_Turn_SCA_BOUEO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
	  <td ><select name='SIX_Turn_SCA_RBG_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_SCA_RBG_B'];
			$abcd=$arow['SIX_Turn_SCA_RBG_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>	
      <td><select name='SIX_Turn_AC_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_AC_B'];
			$abcd=$arow['SIX_Turn_AC_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_AC_TOUEO_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_AC_TOUEO_B'];
			$abcd=$arow['SIX_Turn_AC_TOUEO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_AC6_AOUEO_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_AC6_AOUEO_B'];
			$abcd=$arow['SIX_Turn_AC6_AOUEO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_AC6_BOUEO_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_AC6_BOUEO_B'];
			$abcd=$arow['SIX_Turn_AC6_BOUEO_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_AC6_RBG_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_AC6_RBG_B'];
			$abcd=$arow['SIX_Turn_AC6_RBG_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_SX_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_SX_B'];
			$abcd=$arow['SIX_Turn_SX_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_HW_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_HW_B'];
			$abcd=$arow['SIX_Turn_HW_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_MT_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_MT_B'];
			$abcd=$arow['SIX_Turn_MT_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_M_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_M_B'];
			$abcd=$arow['SIX_Turn_M_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_EC_B' class='SIX_SMALL_2'>
			<?
			$abcde=$row['SIX_Turn_EC_B'];
			$abcd=$arow['SIX_Turn_EC_B'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td ><select name='SIX_Turn_SCA_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_SCA_C'];
			$abcd=$arow['SIX_Turn_SCA_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	    </select></td>
		<td ><select name='SIX_Turn_SCB_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_SCB_C'];
			$abcd=$arow['SIX_Turn_SCB_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
        </select></td>
		<td ><select name='SIX_Turn_SCA_AOUEO_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_SCA_AOUEO_C'];
			$abcd=$arow['SIX_Turn_SCA_AOUEO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td ><select name='SIX_Turn_SCA_BOUEO_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_SCA_BOUEO_C'];
			$abcd=$arow['SIX_Turn_SCA_BOUEO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td ><select name='SIX_Turn_SCA_RBG_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_SCA_RBG_C'];
			$abcd=$arow['SIX_Turn_SCA_RBG_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>	
		<td><select name='SIX_Turn_AC_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_AC_C'];
			$abcd=$arow['SIX_Turn_AC_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td><select name='SIX_Turn_AC_TOUEO_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_AC_TOUEO_C'];
			$abcd=$arow['SIX_Turn_AC_TOUEO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td><select name='SIX_Turn_AC6_AOUEO_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_AC6_AOUEO_C'];
			$abcd=$arow['SIX_Turn_AC6_AOUEO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td><select name='SIX_Turn_AC6_BOUEO_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_AC6_BOUEO_C'];
			$abcd=$arow['SIX_Turn_AC6_BOUEO_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
		</select></td>
		<td><select name='SIX_Turn_AC6_RBG_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_AC6_RBG_C'];
			$abcd=$arow['SIX_Turn_AC6_RBG_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_SX_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_SX_C'];
			$abcd=$arow['SIX_Turn_SX_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_HW_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_HW_C'];
			$abcd=$arow['SIX_Turn_HW_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_MT_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_MT_C'];
			$abcd=$arow['SIX_Turn_MT_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_M_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_M_C'];
			$abcd=$arow['SIX_Turn_M_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_EC_C' class='SIX_SMALL_3'>
			<?
			$abcde=$row['SIX_Turn_EC_C'];
			$abcd=$arow['SIX_Turn_EC_C'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td ><select name='SIX_Turn_SCA_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_SCA_D'];
			$abcd=$arow['SIX_Turn_SCA_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td ><select name='SIX_Turn_SCB_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_SCB_D'];
			$abcd=$arow['SIX_Turn_SCB_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td ><select name='SIX_Turn_SCA_AOUEO_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_SCA_AOUEO_D'];
			$abcd=$arow['SIX_Turn_SCA_AOUEO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td ><select name='SIX_Turn_SCA_BOUEO_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_SCA_BOUEO_D'];
			$abcd=$arow['SIX_Turn_SCA_BOUEO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td ><select name='SIX_Turn_SCA_RBG_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_SCA_RBG_D'];
			$abcd=$arow['SIX_Turn_SCA_RBG_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
	  </select></td>	
      <td><select name='SIX_Turn_AC_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_AC_D'];
			$abcd=$arow['SIX_Turn_AC_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_AC_TOUEO_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_AC_TOUEO_D'];
			$abcd=$arow['SIX_Turn_AC_TOUEO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_AC6_AOUEO_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_AC6_AOUEO_D'];
			$abcd=$arow['SIX_Turn_AC6_AOUEO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
      <td><select name='SIX_Turn_AC6_BOUEO_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_AC6_BOUEO_D'];
			$abcd=$arow['SIX_Turn_AC6_BOUEO_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_AC6_RBG_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_AC6_RBG_D'];
			$abcd=$arow['SIX_Turn_AC6_RBG_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_SX_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_SX_D'];
			$abcd=$arow['SIX_Turn_SX_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_HW_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_HW_D'];
			$abcd=$arow['SIX_Turn_HW_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_MT_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_MT_D'];
			$abcd=$arow['SIX_Turn_MT_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_M_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_M_D'];
			$abcd=$arow['SIX_Turn_M_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
	  <td><select name='SIX_Turn_EC_D' class='SIX_SMALL_4'>
			<?
			$abcde=$row['SIX_Turn_EC_D'];
			$abcd=$arow['SIX_Turn_EC_D'];
			for($i=$abcd;$i>=0;$i=$i-0.5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>$i</option>\n";
				}else{
					echo "<option value=$abc>$i</option>\n";
				}
			}
			?>
      </select></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單場限額</td>
	  <td ><input name=SIX_SCA_SC type="text" value="<?=$row['SIX_SCA_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_SCA_SC,document.SIX.SIX_SCA_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=SIX_SCB_SC type="text" value="<?=$row['SIX_SCB_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_SCB_SC,document.SIX.SIX_SCB_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=SIX_SCA_AOUEO_SC type="text" value="<?=$row['SIX_SCA_AOUEO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_SCA_AOUEO_SC,document.SIX.SIX_SCA_AOUEO_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=SIX_SCA_BOUEO_SC type="text" value="<?=$row['SIX_SCA_BOUEO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_SCA_BOUEO_SC,document.SIX.SIX_SCA_BOUEO_SO)" onKeyPress="return CheckKey();"></td>
	  <td><input name=SIX_SCA_RBG_SC type="text" value="<?=$row['SIX_SCA_RBG_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_SCA_RBG_SC,document.SIX.SIX_SCA_RBG_SO)" onKeyPress="return CheckKey();"></td>	
      <td><input name=SIX_AC_SC type="text" value="<?=$row['SIX_AC_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_AC_SC,document.SIX.SIX_AC_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=SIX_AC_TOUEO_SC type="text" value="<?=$row['SIX_AC_TOUEO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_AC_TOUEO_SC,document.SIX.SIX_AC_TOUEO_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=SIX_AC6_AOUEO_SC type="text" value="<?=$row['SIX_AC6_AOUEO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_AC6_AOUEO_SC,document.SIX.SIX_AC6_AOUEO_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=SIX_AC6_BOUEO_SC type="text" value="<?=$row['SIX_AC6_BOUEO_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_AC6_BOUEO_SC,document.SIX.SIX_AC6_BOUEO_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=SIX_AC6_RBG_SC type="text" value="<?=$row['SIX_AC6_RBG_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_AC6_RBG_SC,document.SIX.SIX_AC6_RBG_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=SIX_SX_SC type="text" value="<?=$row['SIX_SX_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_SX_SC,document.SIX.SIX_SX_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=SIX_HW_SC type="text" value="<?=$row['SIX_HW_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_HW_SC,document.SIX.SIX_HW_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=SIX_MT_SC type="text" value="<?=$row['SIX_MT_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_MT_SC,document.SIX.SIX_MT_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=SIX_M_SC type="text" value="<?=$row['SIX_M_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_M_SC,document.SIX.SIX_M_SO)" onKeyPress="return CheckKey();"></td>
      <td><input name=SIX_EC_SC type="text" value="<?=$row['SIX_EC_Scene']?>" size="5" maxlength="8" class="za_text" onKeyUp="count_so(document.SIX.SIX_EC_SC,document.SIX.SIX_EC_SO)" onKeyPress="return CheckKey();"></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">單注限額</td>
	  <td><input name=SIX_SCA_SO type="text" value="<?=$row['SIX_SCA_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=SIX_SCA_TC value=0>
	  <td><input name=SIX_SCB_SO type="text" value="<?=$row['SIX_SCB_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=SIX_SCB_TC value=0> 
	  <td><input name=SIX_SCA_AOUEO_SO type="text" value="<?=$row['SIX_SCA_AOUEO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=SIX_SCA_AOUEO_TC value=0>
	  <td><input name=SIX_SCA_BOUEO_SO type="text" value="<?=$row['SIX_SCA_BOUEO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=SIX_SCA_BOUEO_TC value=0>
	  <td><input name=SIX_SCA_RBG_SO type="text" value="<?=$row['SIX_SCA_RBG_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=SIX_SCA_RBG_TC value=0>	
      <td><input name=SIX_AC_SO type="text" value="<?=$row['SIX_AC_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=SIX_AC_TC value=0>
      <td><input name=SIX_AC_TOUEO_SO type="text" value="<?=$row['SIX_AC_TOUEO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=SIX_AC_TOUEO_TC value=0> 
      <td><input name=SIX_AC6_AOUEO_SO type="text" value="<?=$row['SIX_AC6_AOUEO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=SIX_AC6_AOUEO_TC value=0> 
      <td><input name=SIX_AC6_BOUEO_SO type="text" value="<?=$row['SIX_AC6_BOUEO_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=SIX_AC6_BOUEO_TC value=0>
	  <td><input name=SIX_AC6_RBG_SO type="text" value="<?=$row['SIX_AC6_RBG_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
	  <input type=hidden name=SIX_AC6_RBG_TC value=0>
      <td><input name=SIX_SX_SO type="text" value="<?=$row['SIX_SX_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=SIX_SX_TC value=0> 
      <td><input name=SIX_HW_SO type="text" value="<?=$row['SIX_HW_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=SIX_HW_TC value=0>
      <td><input name=SIX_MT_SO type="text" value="<?=$row['SIX_MT_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=SIX_MT_TC value=0>
      <td><input name=SIX_M_SO type="text" value="<?=$row['SIX_M_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=SIX_M_TC value=0>
      <td><input name=SIX_EC_SO type="text" value="<?=$row['SIX_EC_Bet']?>" size="5" maxlength="8" class="za_text" onKeyPress="return CheckKey();"></td>
      <input type=hidden name=SIX_EC_TC value=0>     
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="15" ><input type="submit" name="six_ch_ok" value="確定" class="za_button" onClick="getfname(document.SIX)"></td> 
  </tr>
      <input type=hidden name=active value="edit_conf">
      <input type=hidden name=gtype value="SIX">
  	  <input type=hidden name=id value="<?=$id?>">
  	  <input type=hidden name=parents_id value="<?=$parents_id?>">
  	  <input type=hidden name=lv value="<?=$lv?>">
</form> 
</table>
<script>
	function fast_show(e){
		//  限額
		$("input[name='"+e+"_SC']").keyup(function(){
			$("form[name='"+e+"'] input[name$='SC']").val($(this).val());
		});
		$("input[name='"+e+"_SO']").keyup(function(){
			if(parseInt($(this).val()) > parseInt($("input[name='"+e+"_SC']").val())){
				alert("單注限額不可大於單場限額");
			}else{
				$("form[name='"+e+"'] input[name$='SO']").val($(this).val());
			}
		});
		$("input[name='"+e+"_TC']").keyup(function(){
			$("form[name='"+e+"'] input[name$='TC']").val($(this).val());
		});
		//	退水
		$("select[name='"+e+"_LINE_1']").change(function(i){
//			$("form[name='"+e+"'] select[name$='WAR_1']").val($(this).val());
			$("."+e+"_SMALL_1").val($(this).val());
		});
		$("select[name='"+e+"_LINE_2']").change(function(i){
//			$("form[name='"+e+"'] select[name$='WAR_2']").val($(this).val());
			$("."+e+"_SMALL_2").val($(this).val());
		});
		$("select[name='"+e+"_LINE_3']").change(function(i){
//			$("form[name='"+e+"'] select[name$='WAR_3']").val($(this).val());
			$("."+e+"_SMALL_3").val($(this).val());
		});
		$("select[name='"+e+"_LINE_4']").change(function(i){
//			$("form[name='"+e+"'] select[name$='WAR_4']").val($(this).val());
			$("."+e+"_SMALL_4").val($(this).val());
		});
		$("select[name='"+e+"_LINE_BIG']").change(function(i){
			$("."+e+"_BIG").val($(this).val());
			$(".SP_BIG").val($(this).val());
//			$("form[name='"+e+"'] select[name*='P']").val($(this).val());
//			$("form[name='"+e+"'] select[name*='M']").val($(this).val());
//			$("form[name='"+e+"'] select[name*='PD']").val($(this).val());
//			$("form[name='"+e+"'] select[name*='T']").val($(this).val());
//			$("form[name='"+e+"'] select[name*='F']").val($(this).val());
//			$("form[name='"+e+"'] select[name*='CS']").val($(this).val());
		});
	}
	
	$(document).ready(function(){
		for(i=0;i<gtype_arr.length;i++){
			fast_show(gtype_arr[i]);
		}	
	});
</script>
</body>
</html>
<?
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$agent',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>