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
$parents_id=$_REQUEST["parents_id"];
$parents_name=$_REQUEST["parents_name"];
$name=$_REQUEST["name"];
$keys=$_REQUEST['keys'];

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
$username=$row['UserName'];

$cmysql = "select * from web_type_class where ID='1'";
$result = mysql_db_query($dbname,$cmysql);
$crow = mysql_fetch_array($result);
	
$sql = "select * from web_member_data where ID='$parents_id' and UserName='$name' ";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
$agents=$row['Agents'];
$alias=$row['Alias'];
$money=$row['Money'];
$credit=$row['Credit'];
$curtype=$row['CurType'];
$pay_type=$row['Pay_Type'];
$opentype=$row['OpenType'];
$password=$row['PassWord'];
$Phone=$row['Phone'];
switch ($opentype){
	case "A":
		$type='A';
		break;
	case "B":
		$type='B';
		break;	
	case "C":
		$type='C';
		break;
	case "D":
		$type='D';
		break;
	}
switch ($lv){
case 'A':
	$level='A';
	$ag="(UserName='$username' or super='$username' or Corprator='$username' or World='$username') and";
	break;
case 'B':
	$level='A';
	$ag="(UserName='$username' or super='$username' or Corprator='$username' or World='$username') and";
	break;
case 'C':
	$level='B';
	$ag="(UserName='$username' or super='$username' or Corprator='$username' or World='$username') and";
	break;
case 'D':
	$level='C';
	$ag="(UserName='$username' or super='$username' or Corprator='$username' or World='$username') and";
	break;
case 'MEM':
	$level='D';
	$ag="(UserName='$username' or super='$username' or Corprator='$username' or World='$username') and";
	break;	
}
$loginfo='修改会员:'.$name.'';
if ($keys=='edit'){
	$id=$_REQUEST["id"];
	$user=$_REQUEST["username"];
	$gold=$_REQUEST["maxcredit"];//总信用额度
	$pasd=$_REQUEST["password"];//密码
	$alias=$_REQUEST["alias"];//名称
	$type=$_REQUEST['type'];//盘口
	$curtype=$_REQUEST['currency'];//币别
	$pay_type=$_REQUEST['pay_type'];//现金
	$Phone=$_REQUEST['Phone'];//mobile
	
    $asql = "select Credit from web_agents_data where UserName='$agents' and Level='D'";
	$aresult = mysql_db_query($dbname,$asql);
	$arow = mysql_fetch_array($aresult);	
	$acredit=$arow['Credit'];
		
	$bsql="select sum(Credit) as Credit from web_member_data where Agents='$agents' and UserName!='$name'";
	$bresult = mysql_db_query($dbname,$bsql);
	$brow = mysql_fetch_array($bresult);
	$bcredit=$brow['Credit'];	
	
	$money=$gold+$bcredit-$acredit;
	if ($bcredit+$gold>$acredit){
		echo wterror("此会员 $user 修改信用额度为 ".number_format($gold,0)."<br>目前代理商 $agents 最大信用额度为 ".number_format($acredit,0)."<br>所属代理商累计信用额度为 ".number_format($bcredit,0)."<br>已超过代理商信用额度 ".number_format($money,0)."<br>请回上一面重新输入");
		exit();
	}else{
		if ($type==$opentype){
			$FT_Turn_R=$row['FT_Turn_R'];
	  		$FT_Turn_OU=$row['FT_Turn_OU'];
		   	$FT_Turn_M=$row['FT_Turn_M'];
			$FT_Turn_VR=$row['FT_Turn_VR'];
	  		$FT_Turn_VOU=$row['FT_Turn_VOU'];
		   	$FT_Turn_RE=$row['FT_Turn_RE'];
			$FT_Turn_ROU=$row['FT_Turn_ROU'];
			$FT_Turn_RM=$row['FT_Turn_RM'];
			$FT_Turn_VRE=$row['FT_Turn_VRE'];
			$FT_Turn_VROU=$row['FT_Turn_VROU'];
	   		$FT_Turn_PD=$row['FT_Turn_PD'];
		   	$FT_Turn_T=$row['FT_Turn_T'];
		   	$FT_Turn_EO=$row['FT_Turn_EO'];
	   		$FT_Turn_F=$row['FT_Turn_F'];
		   	$FT_Turn_PR=$row['FT_Turn_PR'];

			$BS_Turn_R=$row['BS_Turn_R'];
	  		$BS_Turn_OU=$row['BS_Turn_OU'];
		   	$BS_Turn_M=$row['BS_Turn_M'];
			$BS_Turn_VR=$row['BS_Turn_VR'];
	  		$BS_Turn_VOU=$row['BS_Turn_VOU'];
		   	$BS_Turn_RE=$row['BS_Turn_RE'];
			$BS_Turn_ROU=$row['BS_Turn_ROU'];
	   		$BS_Turn_PD=$row['BS_Turn_PD'];
		   	$BS_Turn_T=$row['BS_Turn_T'];
		   	$BS_Turn_EO=$row['BS_Turn_EO'];
		   	$BS_Turn_PR=$row['BS_Turn_PR'];
						
			$TN_Turn_R=$row['TN_Turn_R'];
	  		$TN_Turn_OU=$row['TN_Turn_OU'];
		   	$TN_Turn_M=$row['TN_Turn_M'];
		   	$TN_Turn_RE=$row['TN_Turn_RE'];
			$TN_Turn_ROU=$row['TN_Turn_ROU'];
	   		$TN_Turn_PD=$row['TN_Turn_PD'];
		   	$TN_Turn_EO=$row['TN_Turn_EO'];
		   	$TN_Turn_P=$row['TN_Turn_P'];
			$TN_Turn_PR=$row['TN_Turn_PR'];
			
			$VB_Turn_R=$row['VB_Turn_R'];
	  		$VB_Turn_OU=$row['VB_Turn_OU'];
		   	$VB_Turn_M=$row['VB_Turn_M'];
		   	$VB_Turn_RE=$row['VB_Turn_RE'];
			$VB_Turn_ROU=$row['VB_Turn_ROU'];
	   		$VB_Turn_PD=$row['VB_Turn_PD'];
		   	$VB_Turn_EO=$row['VB_Turn_EO'];
		   	$VB_Turn_P=$row['VB_Turn_P'];
			$VB_Turn_PR=$row['VB_Turn_PR'];
						
	   		$BK_Turn_R=$row['BK_Turn_R'];
			$BK_Turn_OU=$row['BK_Turn_OU'];
		   	$BK_Turn_EO=$row['BK_Turn_EO'];
			$BK_Turn_RE=$row['BK_Turn_RE'];
			$BK_Turn_ROU=$row['BK_Turn_ROU'];
			$BK_Turn_PC=$row['BK_Turn_PC'];
			
			$OP_Turn_R=$row['OP_Turn_R'];
	  		$OP_Turn_OU=$row['OP_Turn_OU'];
		   	$OP_Turn_M=$row['OP_Turn_M'];
			$OP_Turn_VR=$row['OP_Turn_VR'];
	  		$OP_Turn_VOU=$row['OP_Turn_VOU'];
		   	$OP_Turn_RE=$row['OP_Turn_RE'];
			$OP_Turn_ROU=$row['OP_Turn_ROU'];
			$OP_Turn_VRE=$row['OP_Turn_VRE'];
			$OP_Turn_VROU=$row['OP_Turn_VROU'];
	   		$OP_Turn_PD=$row['OP_Turn_PD'];
		   	$OP_Turn_T=$row['OP_Turn_T'];
		   	$OP_Turn_EO=$row['OP_Turn_EO'];
	   		$OP_Turn_F=$row['OP_Turn_F'];
		   	$OP_Turn_PR=$row['OP_Turn_PR'];

			$FS_Turn_FS=$row['FU_Turn_FS'];
		
			$FU_Turn_OU=$row['FU_Turn_OU'];
		   	$FU_Turn_EO=$row['FU_Turn_EO'];
			$FU_Turn_PD=$row['FU_Turn_PD'];
			
			$SIX_Turn_SCA=$row['SIX_Turn_SCA'];
	  		$SIX_Turn_SCB=$row['SIX_Turn_SCB'];
		   	$SIX_Turn_SCA_AOUEO=$row['SIX_Turn_SCA_AOUEO'];
			$SIX_Turn_SCA_BOUEO=$row['SIX_Turn_SCA_BOUEO'];
	  		$SIX_Turn_SCA_RBG=$row['SIX_Turn_SCA_RBG'];
		   	$SIX_Turn_AC=$row['SIX_Turn_AC'];
			$SIX_Turn_AC_TOUEO=$row['SIX_Turn_AC_TOUEO'];
			$SIX_Turn_AC6_AOUEO=$row['SIX_Turn_AC6_AOUEO'];
			$SIX_Turn_AC6_BOUEO=$row['SIX_Turn_AC6_BOUEO'];
			$SIX_Turn_AC6_RBG=$row['SIX_Turn_AC6_RBG'];
	   		$SIX_Turn_SX=$row['SIX_Turn_SX'];
		   	$SIX_Turn_HW=$row['SIX_Turn_HW'];
		   	$SIX_Turn_MT=$row['SIX_Turn_MT'];
	   		$SIX_Turn_M=$row['SIX_Turn_M'];
		   	$SIX_Turn_EC=$row['SIX_Turn_EC'];
		}else{
			$FT_Turn_R='0';
	  		$FT_Turn_OU='0';
		   	$FT_Turn_M='0';
			$FT_Turn_VR='0';
	  		$FT_Turn_VOU='0';
		   	$FT_Turn_RE='0';
			$FT_Turn_ROU='0';
			$FT_Turn_RM='0';
			$FT_Turn_VRE='0';
			$FT_Turn_VROU='0';
	   		$FT_Turn_PD='0';
		   	$FT_Turn_T='0';
		   	$FT_Turn_EO='0';
	   		$FT_Turn_F='0';
		   	$FT_Turn_PR='0';

			$BS_Turn_R='0';
	  		$BS_Turn_OU='0';
		   	$BS_Turn_M='0';
			$BS_Turn_VR='0';
	  		$BS_Turn_VOU='0';
		   	$BS_Turn_RE='0';
			$BS_Turn_ROU='0';
	   		$BS_Turn_PD='0';
		   	$BS_Turn_T='0';
		   	$BS_Turn_EO='0';
		   	$BS_Turn_PR='0';
						
			$TN_Turn_R='0';
	  		$TN_Turn_OU='0';
		   	$TN_Turn_M='0';
		   	$TN_Turn_RE='0';
			$TN_Turn_ROU='0';
	   		$TN_Turn_PD='0';
		   	$TN_Turn_EO='0';
		   	$TN_Turn_P='0';
			$TN_Turn_PR='0';
			
			$VB_Turn_R='0';
	  		$VB_Turn_OU='0';
		   	$VB_Turn_M='0';
		   	$VB_Turn_RE='0';
			$VB_Turn_ROU='0';
	   		$VB_Turn_PD='0';
		   	$VB_Turn_EO='0';
		   	$VB_Turn_P='0';
			$VB_Turn_PR='0';
						
	   		$BK_Turn_R='0';
			$BK_Turn_OU='0';
		   	$BK_Turn_EO='0';
			$BK_Turn_RE='0';
			$BK_Turn_ROU='0';
			$BK_Turn_PR='0';
			
			$OP_Turn_R='0';
	  		$OP_Turn_OU='0';
		   	$OP_Turn_M='0';
			$OP_Turn_VR='0';
	  		$OP_Turn_VOU='0';
		   	$OP_Turn_RE='0';
			$OP_Turn_ROU='0';
			$OP_Turn_VRE='0';
			$OP_Turn_VROU='0';
	   		$OP_Turn_PD='0';
		   	$OP_Turn_T='0';
		   	$OP_Turn_EO='0';
	   		$OP_Turn_F='0';
		   	$OP_Turn_PR='0';

			$FS_Turn_FS='0';
		
			$FU_Turn_OU='0';
		   	$FU_Turn_EO='0';
			$FU_Turn_PD='0';
			
			$SIX_Turn_SCA='0';
	  		$SIX_Turn_SCB='0';
		   	$SIX_Turn_SCA_AOUEO='0';
			$SIX_Turn_SCA_BOUEO='0';
	  		$SIX_Turn_SCA_RBG='0';
		   	$SIX_Turn_AC='0';
			$SIX_Turn_AC_TOUEO='0';
			$SIX_Turn_AC6_AOUEO='0';
			$SIX_Turn_AC6_BOUEO='0';
			$SIX_Turn_AC6_RBG='0';
	   		$SIX_Turn_SX='0';
		   	$SIX_Turn_HW='0';
		   	$SIX_Turn_MT='0';
	   		$SIX_Turn_M='0';
		   	$SIX_Turn_EC='0';
		}
	
		$mysql="select sum(betscore) as BetScore from web_report_data where M_Name='$name' and M_Date='".date('Y-m-d')."'";
		$result = mysql_db_query($dbname,$mysql);
		$row = mysql_fetch_array($result);
		$betscore=$row['BetScore'];
		$cash=$gold-$betscore;
		if ($pay_type==0){
		if ($betscore==''){
			$mysql="update web_member_data set Phone='$Phone',Oid='logout',LoginTime='0000-00-00 00:00:00',Credit=$gold,Money=$gold,PassWord='$pasd',Alias='$alias',OpenType='$type',CurType='$curtype',Pay_Type='$pay_type',FT_Turn_R='$FT_Turn_R',FT_Turn_OU='$FT_Turn_OU',FT_Turn_M='$FT_Turn_M',FT_Turn_VR='$FT_Turn_VR',FT_Turn_VOU='$FT_Turn_VOU',FT_Turn_RE='$FT_Turn_RE',FT_Turn_ROU='$FT_Turn_ROU',FT_Turn_RM='$FT_Turn_RM',FT_Turn_VRE='$FT_Turn_VRE',FT_Turn_VROU='$FT_Turn_VROU',FT_Turn_PD='$FT_Turn_PD',FT_Turn_T='$FT_Turn_T',FT_Turn_EO='$FT_Turn_EO',FT_Turn_F='$FT_Turn_F',FT_Turn_PR='$FT_Turn_PR',BS_Turn_R='$BS_Turn_R',BS_Turn_OU='$BS_Turn_OU',BS_Turn_M='$BS_Turn_M',BS_Turn_VR='$BS_Turn_VR',BS_Turn_VOU='$BS_Turn_VOU',BS_Turn_RE='$BS_Turn_RE',BS_Turn_ROU='$BS_Turn_ROU',BS_Turn_PD='$BS_Turn_PD',BS_Turn_T='$BS_Turn_T',BS_Turn_EO='$BS_Turn_EO',BS_Turn_PR='$BS_Turn_PR',TN_Turn_R='$TN_Turn_R',TN_Turn_OU='$TN_Turn_OU',TN_Turn_M='$TN_Turn_M',TN_Turn_RE='$TN_Turn_RE',TN_Turn_ROU='$TN_Turn_ROU',TN_Turn_PD='$TN_Turn_PD',TN_Turn_EO='$TN_Turn_EO',TN_Turn_P='$TN_Turn_P',TN_Turn_PR='$TN_Turn_PR',VB_Turn_R='$VB_Turn_R',VB_Turn_OU='$VB_Turn_OU',VB_Turn_M='$VB_Turn_M',VB_Turn_RE='$VB_Turn_RE',VB_Turn_ROU='$VB_Turn_ROU',VB_Turn_PD='$VB_Turn_PD',VB_Turn_EO='$VB_Turn_EO',VB_Turn_P='$VB_Turn_P',VB_Turn_PR='$VB_Turn_PR',BK_Turn_R='$BK_Turn_R',BK_Turn_OU='$BK_Turn_OU',BK_Turn_EO='$BK_Turn_EO',BK_Turn_RE='$BK_Turn_RE',BK_Turn_ROU='$BK_Turn_ROU',BK_Turn_PR='$BK_Turn_PR',OP_Turn_R='$OP_Turn_R',OP_Turn_OU='$OP_Turn_OU',OP_Turn_M='$OP_Turn_M',OP_Turn_VR='$OP_Turn_VR',OP_Turn_VOU='$OP_Turn_VOU',OP_Turn_RE='$OP_Turn_RE',OP_Turn_ROU='$OP_Turn_ROU',OP_Turn_VRE='$OP_Turn_VRE',OP_Turn_VROU='$OP_Turn_VROU',OP_Turn_PD='$OP_Turn_PD',OP_Turn_T='$OP_Turn_T',OP_Turn_EO='$OP_Turn_EO',OP_Turn_F='$OP_Turn_F',OP_Turn_PR='$OP_Turn_PR',FS_Turn_FS='$FS_Turn_FS',FU_Turn_OU='$FU_Turn_OU',FU_Turn_EO='$FU_Turn_EO',FU_Turn_PD='$FU_Turn_PD',SIX_Turn_SCA='$SIX_Turn_SCA',SIX_Turn_SCB='$SIX_Turn_SCB',SIX_Turn_SCA_AOUEO='$SIX_Turn_SCA_AOUEO',SIX_Turn_SCA_BOUEO='$SIX_Turn_SCA_BOUEO',SIX_Turn_SCA_RBG='$SIX_Turn_SCA_RBG',SIX_Turn_AC='$SIX_Turn_AC',SIX_Turn_AC_TOUEO='$SIX_Turn_AC_TOUEO',SIX_Turn_AC6_AOUEO='$SIX_Turn_AC6_AOUEO',SIX_Turn_AC6_BOUEO='$SIX_Turn_AC6_BOUEO',SIX_Turn_AC6_RBG='$SIX_Turn_AC6_RBG',SIX_Turn_SX='$SIX_Turn_SX',SIX_Turn_HW='$SIX_Turn_HW',SIX_Turn_MT='$SIX_Turn_MT',SIX_Turn_M='$SIX_Turn_M',SIX_Turn_EC='$SIX_Turn_EC' where ID='$id'";
			mysql_db_query($dbname,$mysql) or die ("操作失败!");
			$loginfo='修改信用会员:'.$name.' 密码:'.$pasd.' 名称:'.$alias.' 信用额度:'.$gold.' (修改成功)';
		}else if ($betscore>=$gold){
			$mysql="update web_member_data set Phone='$Phone',Oid='logout',LoginTime='0000-00-00 00:00:00',Credit=$gold,Money=0,PassWord='$pasd',Alias='$alias',OpenType='$type',CurType='$curtype',Pay_Type='$pay_type',FT_Turn_R='$FT_Turn_R',FT_Turn_OU='$FT_Turn_OU',FT_Turn_M='$FT_Turn_M',FT_Turn_VR='$FT_Turn_VR',FT_Turn_VOU='$FT_Turn_VOU',FT_Turn_RE='$FT_Turn_RE',FT_Turn_ROU='$FT_Turn_ROU',FT_Turn_RM='$FT_Turn_RM',FT_Turn_VRE='$FT_Turn_VRE',FT_Turn_VROU='$FT_Turn_VROU',FT_Turn_PD='$FT_Turn_PD',FT_Turn_T='$FT_Turn_T',FT_Turn_EO='$FT_Turn_EO',FT_Turn_F='$FT_Turn_F',FT_Turn_PR='$FT_Turn_PR',BS_Turn_R='$BS_Turn_R',BS_Turn_OU='$BS_Turn_OU',BS_Turn_M='$BS_Turn_M',BS_Turn_VR='$BS_Turn_VR',BS_Turn_VOU='$BS_Turn_VOU',BS_Turn_RE='$BS_Turn_RE',BS_Turn_ROU='$BS_Turn_ROU',BS_Turn_PD='$BS_Turn_PD',BS_Turn_T='$BS_Turn_T',BS_Turn_EO='$BS_Turn_EO',BS_Turn_PR='$BS_Turn_PR',TN_Turn_R='$TN_Turn_R',TN_Turn_OU='$TN_Turn_OU',TN_Turn_M='$TN_Turn_M',TN_Turn_RE='$TN_Turn_RE',TN_Turn_ROU='$TN_Turn_ROU',TN_Turn_PD='$TN_Turn_PD',TN_Turn_EO='$TN_Turn_EO',TN_Turn_P='$TN_Turn_P',TN_Turn_PR='$TN_Turn_PR',VB_Turn_R='$VB_Turn_R',VB_Turn_OU='$VB_Turn_OU',VB_Turn_M='$VB_Turn_M',VB_Turn_RE='$VB_Turn_RE',VB_Turn_ROU='$VB_Turn_ROU',VB_Turn_PD='$VB_Turn_PD',VB_Turn_EO='$VB_Turn_EO',VB_Turn_P='$VB_Turn_P',VB_Turn_PR='$VB_Turn_PR',BK_Turn_R='$BK_Turn_R',BK_Turn_OU='$BK_Turn_OU',BK_Turn_EO='$BK_Turn_EO',BK_Turn_RE='$BK_Turn_RE',BK_Turn_ROU='$BK_Turn_ROU',BK_Turn_PR='$BK_Turn_PR',OP_Turn_R='$OP_Turn_R',OP_Turn_OU='$OP_Turn_OU',OP_Turn_M='$OP_Turn_M',OP_Turn_VR='$OP_Turn_VR',OP_Turn_VOU='$OP_Turn_VOU',OP_Turn_RE='$OP_Turn_RE',OP_Turn_ROU='$OP_Turn_ROU',OP_Turn_VRE='$OP_Turn_VRE',OP_Turn_VROU='$OP_Turn_VROU',OP_Turn_PD='$OP_Turn_PD',OP_Turn_T='$OP_Turn_T',OP_Turn_EO='$OP_Turn_EO',OP_Turn_F='$OP_Turn_F',OP_Turn_PR='$OP_Turn_PR',FS_Turn_FS='$FS_Turn_FS',FU_Turn_OU='$FU_Turn_OU',FU_Turn_EO='$FU_Turn_EO',FU_Turn_PD='$FU_Turn_PD',SIX_Turn_SCA='$SIX_Turn_SCA',SIX_Turn_SCB='$SIX_Turn_SCB',SIX_Turn_SCA_AOUEO='$SIX_Turn_SCA_AOUEO',SIX_Turn_SCA_BOUEO='$SIX_Turn_SCA_BOUEO',SIX_Turn_SCA_RBG='$SIX_Turn_SCA_RBG',SIX_Turn_AC='$SIX_Turn_AC',SIX_Turn_AC_TOUEO='$SIX_Turn_AC_TOUEO',SIX_Turn_AC6_AOUEO='$SIX_Turn_AC6_AOUEO',SIX_Turn_AC6_BOUEO='$SIX_Turn_AC6_BOUEO',SIX_Turn_AC6_RBG='$SIX_Turn_AC6_RBG',SIX_Turn_SX='$SIX_Turn_SX',SIX_Turn_HW='$SIX_Turn_HW',SIX_Turn_MT='$SIX_Turn_MT',SIX_Turn_M='$SIX_Turn_M',SIX_Turn_EC='$SIX_Turn_EC' where ID='$id'";
			mysql_db_query($dbname,$mysql) or die ("操作失败!!");
			$loginfo='修改信用会员:'.$name.' 密码:'.$pasd.' 名称:'.$alias.' 信用额度:'.$gold.' (修改成功)';
		}else if ($betscore<$gold){
			$mysql="update web_member_data set Phone='$Phone',Oid='logout',LoginTime='0000-00-00 00:00:00',Credit=$gold,Money=$cash,PassWord='$pasd',Alias='$alias',OpenType='$type',CurType='$curtype',Pay_Type='$pay_type',FT_Turn_R='$FT_Turn_R',FT_Turn_OU='$FT_Turn_OU',FT_Turn_M='$FT_Turn_M',FT_Turn_VR='$FT_Turn_VR',FT_Turn_VOU='$FT_Turn_VOU',FT_Turn_RE='$FT_Turn_RE',FT_Turn_ROU='$FT_Turn_ROU',FT_Turn_RM='$FT_Turn_RM',FT_Turn_VRE='$FT_Turn_VRE',FT_Turn_VROU='$FT_Turn_VROU',FT_Turn_PD='$FT_Turn_PD',FT_Turn_T='$FT_Turn_T',FT_Turn_EO='$FT_Turn_EO',FT_Turn_F='$FT_Turn_F',FT_Turn_PR='$FT_Turn_PR',BS_Turn_R='$BS_Turn_R',BS_Turn_OU='$BS_Turn_OU',BS_Turn_M='$BS_Turn_M',BS_Turn_VR='$BS_Turn_VR',BS_Turn_VOU='$BS_Turn_VOU',BS_Turn_RE='$BS_Turn_RE',BS_Turn_ROU='$BS_Turn_ROU',BS_Turn_PD='$BS_Turn_PD',BS_Turn_T='$BS_Turn_T',BS_Turn_EO='$BS_Turn_EO',BS_Turn_PR='$BS_Turn_PR',TN_Turn_R='$TN_Turn_R',TN_Turn_OU='$TN_Turn_OU',TN_Turn_M='$TN_Turn_M',TN_Turn_RE='$TN_Turn_RE',TN_Turn_ROU='$TN_Turn_ROU',TN_Turn_PD='$TN_Turn_PD',TN_Turn_EO='$TN_Turn_EO',TN_Turn_P='$TN_Turn_P',TN_Turn_PR='$TN_Turn_PR',VB_Turn_R='$VB_Turn_R',VB_Turn_OU='$VB_Turn_OU',VB_Turn_M='$VB_Turn_M',VB_Turn_RE='$VB_Turn_RE',VB_Turn_ROU='$VB_Turn_ROU',VB_Turn_PD='$VB_Turn_PD',VB_Turn_EO='$VB_Turn_EO',VB_Turn_P='$VB_Turn_P',VB_Turn_PR='$VB_Turn_PR',BK_Turn_R='$BK_Turn_R',BK_Turn_OU='$BK_Turn_OU',BK_Turn_EO='$BK_Turn_EO',BK_Turn_RE='$BK_Turn_RE',BK_Turn_ROU='$BK_Turn_ROU',BK_Turn_PR='$BK_Turn_PR',OP_Turn_R='$OP_Turn_R',OP_Turn_OU='$OP_Turn_OU',OP_Turn_M='$OP_Turn_M',OP_Turn_VR='$OP_Turn_VR',OP_Turn_VOU='$OP_Turn_VOU',OP_Turn_RE='$OP_Turn_RE',OP_Turn_ROU='$OP_Turn_ROU',OP_Turn_VRE='$OP_Turn_VRE',OP_Turn_VROU='$OP_Turn_VROU',OP_Turn_PD='$OP_Turn_PD',OP_Turn_T='$OP_Turn_T',OP_Turn_EO='$OP_Turn_EO',OP_Turn_F='$OP_Turn_F',OP_Turn_PR='$OP_Turn_PR',FS_Turn_FS='$FS_Turn_FS',FU_Turn_OU='$FU_Turn_OU',FU_Turn_EO='$FU_Turn_EO',FU_Turn_PD='$FU_Turn_PD',SIX_Turn_SCA='$SIX_Turn_SCA',SIX_Turn_SCB='$SIX_Turn_SCB',SIX_Turn_SCA_AOUEO='$SIX_Turn_SCA_AOUEO',SIX_Turn_SCA_BOUEO='$SIX_Turn_SCA_BOUEO',SIX_Turn_SCA_RBG='$SIX_Turn_SCA_RBG',SIX_Turn_AC='$SIX_Turn_AC',SIX_Turn_AC_TOUEO='$SIX_Turn_AC_TOUEO',SIX_Turn_AC6_AOUEO='$SIX_Turn_AC6_AOUEO',SIX_Turn_AC6_BOUEO='$SIX_Turn_AC6_BOUEO',SIX_Turn_AC6_RBG='$SIX_Turn_AC6_RBG',SIX_Turn_SX='$SIX_Turn_SX',SIX_Turn_HW='$SIX_Turn_HW',SIX_Turn_MT='$SIX_Turn_MT',SIX_Turn_M='$SIX_Turn_M',SIX_Turn_EC='$SIX_Turn_EC' where ID='$id'";
			mysql_db_query($dbname,$mysql) or die ("操作失败!!!");
			$loginfo='修改信用会员:'.$name.' 密码:'.$pasd.' 名称:'.$alias.' 信用额度:'.$gold.' (修改成功)';
		}
		echo "<Script Language=javascript>self.location='user_browse.php?uid=$uid&lv=$lv&langx=$langx';</script>";
		}else if ($pay_type==1){
			$mysql="update web_member_data set Phone='$Phone',Oid='logout',LoginTime='0000-00-00 00:00:00',PassWord='$pasd',Alias='$alias',OpenType='$type',CurType='$curtype',FT_Turn_R='$FT_Turn_R',FT_Turn_OU='$FT_Turn_OU',FT_Turn_M='$FT_Turn_M',FT_Turn_VR='$FT_Turn_VR',FT_Turn_VOU='$FT_Turn_VOU',FT_Turn_RE='$FT_Turn_RE',FT_Turn_ROU='$FT_Turn_ROU',FT_Turn_RM='$FT_Turn_RM',FT_Turn_VRE='$FT_Turn_VRE',FT_Turn_VROU='$FT_Turn_VROU',FT_Turn_PD='$FT_Turn_PD',FT_Turn_T='$FT_Turn_T',FT_Turn_EO='$FT_Turn_EO',FT_Turn_F='$FT_Turn_F',FT_Turn_PR='$FT_Turn_PR',BS_Turn_R='$BS_Turn_R',BS_Turn_OU='$BS_Turn_OU',BS_Turn_M='$BS_Turn_M',BS_Turn_VR='$BS_Turn_VR',BS_Turn_VOU='$BS_Turn_VOU',BS_Turn_RE='$BS_Turn_RE',BS_Turn_ROU='$BS_Turn_ROU',BS_Turn_PD='$BS_Turn_PD',BS_Turn_T='$BS_Turn_T',BS_Turn_EO='$BS_Turn_EO',BS_Turn_PR='$BS_Turn_PR',TN_Turn_R='$TN_Turn_R',TN_Turn_OU='$TN_Turn_OU',TN_Turn_M='$TN_Turn_M',TN_Turn_RE='$TN_Turn_RE',TN_Turn_ROU='$TN_Turn_ROU',TN_Turn_PD='$TN_Turn_PD',TN_Turn_EO='$TN_Turn_EO',TN_Turn_P='$TN_Turn_P',TN_Turn_PR='$TN_Turn_PR',VB_Turn_R='$VB_Turn_R',VB_Turn_OU='$VB_Turn_OU',VB_Turn_M='$VB_Turn_M',VB_Turn_RE='$VB_Turn_RE',VB_Turn_ROU='$VB_Turn_ROU',VB_Turn_PD='$VB_Turn_PD',VB_Turn_EO='$VB_Turn_EO',VB_Turn_P='$VB_Turn_P',VB_Turn_PR='$VB_Turn_PR',BK_Turn_R='$BK_Turn_R',BK_Turn_OU='$BK_Turn_OU',BK_Turn_EO='$BK_Turn_EO',BK_Turn_RE='$BK_Turn_RE',BK_Turn_ROU='$BK_Turn_ROU',BK_Turn_PR='$BK_Turn_PR',OP_Turn_R='$OP_Turn_R',OP_Turn_OU='$OP_Turn_OU',OP_Turn_M='$OP_Turn_M',OP_Turn_VR='$OP_Turn_VR',OP_Turn_VOU='$OP_Turn_VOU',OP_Turn_RE='$OP_Turn_RE',OP_Turn_ROU='$OP_Turn_ROU',OP_Turn_VRE='$OP_Turn_VRE',OP_Turn_VROU='$OP_Turn_VROU',OP_Turn_PD='$OP_Turn_PD',OP_Turn_T='$OP_Turn_T',OP_Turn_EO='$OP_Turn_EO',OP_Turn_F='$OP_Turn_F',OP_Turn_PR='$OP_Turn_PR',FS_Turn_FS='$FS_Turn_FS',FU_Turn_OU='$FU_Turn_OU',FU_Turn_EO='$FU_Turn_EO',FU_Turn_PD='$FU_Turn_PD',SIX_Turn_SCA='$SIX_Turn_SCA',SIX_Turn_SCB='$SIX_Turn_SCB',SIX_Turn_SCA_AOUEO='$SIX_Turn_SCA_AOUEO',SIX_Turn_SCA_BOUEO='$SIX_Turn_SCA_BOUEO',SIX_Turn_SCA_RBG='$SIX_Turn_SCA_RBG',SIX_Turn_AC='$SIX_Turn_AC',SIX_Turn_AC_TOUEO='$SIX_Turn_AC_TOUEO',SIX_Turn_AC6_AOUEO='$SIX_Turn_AC6_AOUEO',SIX_Turn_AC6_BOUEO='$SIX_Turn_AC6_BOUEO',SIX_Turn_AC6_RBG='$SIX_Turn_AC6_RBG',SIX_Turn_SX='$SIX_Turn_SX',SIX_Turn_HW='$SIX_Turn_HW',SIX_Turn_MT='$SIX_Turn_MT',SIX_Turn_M='$SIX_Turn_M',SIX_Turn_EC='$SIX_Turn_EC' where ID='$id'";
			mysql_db_query($dbname,$mysql) or die ("操作失败!!!!");
			$loginfo='修改现金会员:'.$name.' 密码:'.$pasd.' 名称:'.$alias.' (修改成功)';
		    echo "<Script Language=javascript>self.location='user_browse.php?uid=$uid&lv=$lv&langx=$langx';</script>";
		}
	}
}else{
	$sql = "select * from web_agents_data where ID='$id'";
	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8 ">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_co_ed {  background-color: #baccc1; text-align: right}
-->
</style>
<link rel="stylesheet" href="/tpl/style/agents/autocomplete.css" type="text/css">
<script src="/js/lib/prototype.js" type="text/javascript"></script>
<script src="/js/lib/scriptaculous.js" type="text/javascript"></script>
<SCRIPT>
<!--
function SubChk(){
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
	if(document.all.password.value.length < 6 ){alert('<?=$Mem_NewPassword_6_Characters?>');return false;}
	if(document.all.password.value.length > 12 ){alert('<?=$Mem_NewPassword_12_CharactersMax?>');return false;}
	if(document.all.password.value != document.all.passwd.value){ 
	document.all.password.focus(); alert("<?=$Mem_PasswordConfirmError?>"); return false; }
	if(document.all.alias.value==''){ 
	document.all.alias.focus(); alert("<?=$Mem_Input?> :<?=$Mem_Name?> !!"); return false; }
	if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0'){ 
	document.all.maxcredit.focus(); alert("<?=$Mem_Input?> :<?=$Mem_Credit_Amount?> !!"); return false; }
	
	document.all.OK.disabled = true;
	document.all.FormsButton2.disabled = true;
	//document.myFORM.submit();
	if(!confirm("<?=$Mem_Whether_Edit?> <?=$Mem_Member?> ?")){
		document.all.OK.disabled = false;
		document.all.FormsButton2.disabled = false;
		return false;
	}
	if (document.all.keys.value == 'add' && document.all.new_ratio.value != 1 ){
		alert('您已經改變了會員的幣值與網站設定幣值不同，\n\n所有的單場單注限額將被歸零，\n\n請重新進入詳細設定更新.');
	}
	if (document.all.keys.value == 'edit' && document.all.type.value != document.all.line_chang.value){
		alert('<?=$Mem_alert_type?>');
	}
	
}

/*function MM_show(){
	var p,obj0,obj1;
	p=document.myFORM.pay_type.value;
	obj0=credit_0.style; 
	obj1=credit_1.style;

	obj0.display=(p==1)?'none':'block';
	obj1.display=(p==0)?'none':'block';
}*/

function Chg_Mcy(a){

curr=new Array();
curr_now=new Array();
curr['RMB']=<?=$crow['RMB_Rate']?>;
curr['HKD']=<?=$crow['HKD_Rate']?>;
curr['USD']=<?=$crow['USD_Rate']?>;
curr['MYR']=<?=$crow['MYR_Rate']?>;
curr['SGD']=<?=$crow['SGD_Rate']?>;
curr['THB']=<?=$crow['THB_Rate']?>;
curr['GBP']=<?=$crow['GBP_Rate']?>;
curr['JPY']=<?=$crow['JPY_Rate']?>;
curr['EUR']=<?=$crow['EUR_Rate']?>;

curr_now['RMB']=<?=$crow['RMB_Rates']?>;
curr_now['HKD']=<?=$crow['HKD_Rates']?>;
curr_now['USD']=<?=$crow['USD_Rates']?>;
curr_now['MYR']=<?=$crow['MYR_Rates']?>;
curr_now['SGD']=<?=$crow['SGD_Rates']?>;
curr_now['THB']=<?=$crow['THB_Rates']?>;
curr_now['GBP']=<?=$crow['GBP_Rates']?>;
curr_now['JPY']=<?=$crow['JPY_Rates']?>;
curr_now['EUR']=<?=$crow['EUR_Rates']?>;


	if (document.all.ratio.value==''){
		tmp=document.all.currency.options[document.all.currency.selectedIndex].value;
		ratio=eval(curr[tmp]);
		ratio_now=eval(curr_now[tmp]);
		document.all.new_ratio.value=ratio;
	}else{
		ratio=eval(document.all.ratio.value);
		ratio_now=eval(document.all.new_ratio.value);
	}
	if (a=='mx')
	{
		tmp_count=ratio*eval(document.all.maxcredit.value);
		tmp_count=Math.round(tmp_count*100);
		tmp_count=tmp_count/100;
		document.all.mcy_mx.innerHTML=tmp_count;
	}
	if (a=='now')
	{
		document.all.mcy_now.innerHTML=ratio_now;
	}
}

function CheckKey(){
	if(event.keyCode < 48 || event.keyCode > 57){alert("<?=$Mem_Enter_Numbers?>"); return false;}
}

function get_name(selectvalue)
{
	}

function parents_reload(parents_name)
{
	}

function sync2username(text,li) {
	document.myFORM.parents_name.value = li.name;
	parents_reload(li.name);
}
function onload() {
  var obj_type = document.getElementById('type');
  obj_type.value = '<?=$type?>';
  var obj_pay_type = document.getElementById('pay_type');
  obj_pay_type.value = '<?=$pay_type?>';
  var obj_currency = document.getElementById('currency');
  obj_currency.value = '<?=$curtype?>'; 
  
	Chg_Mcy('now');
	Chg_Mcy('mx');
	//MM_show();
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

// -->
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onload();" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<FORM NAME="myFORM" ACTION="mem_edit.php?uid=<?=$uid?>&lv=<?=$lv?>&parents_id=<?=$parents_id?>&name=<?=$name?>&langx=<?=$langx?>&pay_type=<?=$pay_type?> " METHOD=POST onSubmit="return SubChk()">
  <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$parents_id?>">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="edit">
  <INPUT TYPE=HIDDEN NAME="ratio" VALUE="">
  <INPUT TYPE=HIDDEN NAME="new_ratio" VALUE=""> 
  <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
  <INPUT TYPE=HIDDEN NAME="ag_name" VALUE="">
  <INPUT TYPE=HIDDEN NAME="line_chang" VALUE="<?=$opentype?>">
  <input type=HIDDEN name="SS" value="">
  <input type=HIDDEN name="SR" value="">
  <input type=HIDDEN name="TS" value="">	
  <input type="hidden" name="s_low_order_gold" value="">
  <input type="hidden" name="s_low_order_gold_pc" value="">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">&nbsp;&nbsp;<?=$Mem_Member?><?=$Mem_Manager?> <span style="display:none">-- <?=$Mem_Edit?>
       <select name="parents_name" class="za_select" onChange="parents_reload(this.options[this.selectedIndex].value)">
       <option label="" value="" selected="selected"></option>
		<?
	    $mysql = "select UserName,Alias from web_agents_data where $ag subuser=0 and Status=0 and Level='$level'";
		$aresult = mysql_db_query($dbname,$mysql);
		while ($arow = mysql_fetch_array($aresult)){
					if ($parents_name==$arow['UserName']){
						echo "<option value=".$arow['UserName']." selected>".$arow['UserName']."==".$arow['Alias']."</option>";				
						$sel_agents=$arow['UserName'];
					}else{
						echo "<option value=".$arow['UserName'].">".$arow['UserName']."==".$arow['Alias']."</option>";
					}
		}
		?>
		</select>
	    <INPUT TYPE=HIDDEN NAME='line' VALUE='ND'>
		<INPUT TYPE=HIDDEN NAME='cha' VALUE='N'>
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
      <td colspan="2" ><?=$Mem_Basic_data?><?=$Mem_Settings?></td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_Member?> <?=$Mem_Account?> :</td>
      <td><?=$name?></td>
          </tr>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed"><?=$Mem_Password?> :</td>
      <td><input type=PASSWORD name="password" value="<?=$password?>" size=12 maxlength=12 class="za_text">
         ◎<?=$Mem_Password_Guidelines?>：<?=$Mem_Pasread?>
      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed"><?=$Mem_Cofirm_Password?> :</td>
      <td><input type=PASSWORD name="passwd" value="<?=$password?>" size=12 maxlength=12 class="za_text">
      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed"><?=$Mem_Member?> <?=$Mem_Name?> :</td>
      <td><input type=TEXT name="alias" value="<?=$alias?>" size=10 maxlength=10 class="za_text">
      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed">Mobile :</td>
      <td><input type=TEXT name="Phone" value="<?=$Phone?>" size=10 maxlength=11 class="za_text">
      </td>
    </tr>
  </table>

  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" ><?=$Mem_Betting_data?><?=$Mem_Settings?></td>
    </tr>
    <tr class="m_bc_ed"> 
      <td width="140" class="m_co_ed"><?=$Mem_Games_Available?> :</td>
      <td width="637">
       <select name="type" class="za_select">
       <option label="A<?=$Mem_Line?>" value="A">A<?=$Mem_Line?></option>
       <option label="B<?=$Mem_Line?>" value="B">B<?=$Mem_Line?></option>
       <option label="C<?=$Mem_Line?>" value="C">C<?=$Mem_Line?></option>
       <option label="D<?=$Mem_Line?>" value="D">D<?=$Mem_Line?></option>
       </select>	   	   
      </td>
    </tr>  
    <tr class="m_bc_ed"> 
      <td class="m_co_ed"><?=$Mem_Bet_Way?> :</td>
      <td>	  
       <select name="pay_type" class="za_select" onChange="MM_show()" disabled>
       <option label="<?=$Mem_Credit?>" value="0" selected="selected"><?=$Mem_Credit?></option>
       <option label="<?=$Mem_Cash?>" value="1"><?=$Mem_Cash?></option>
       </select>         
	  </td>
    </tr>	
    <tr class="m_bc_ed"> 
      <td class="m_co_ed"><?=$Mem_Currency_setup?> :</td>
      <td>
      <select name="currency" class="za_select" onChange="Chg_Mcy('now');Chg_Mcy('mx')">
       <option label="<?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_RMB?>" value="RMB" selected="selected"><?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_RMB?></option>
       <option label="<?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_HKD?>" value="HKD"><?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_HKD?></option>
       <option label="<?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_USD?>" value="USD"><?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_USD?></option>
       <option label="<?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_MYR?>" value="MYR"><?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_MYR?></option>
       <option label="<?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_SGD?>" value="SGD"><?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_SGD?></option>
       <option label="<?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_THB?>" value="THB"><?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_THB?></option>
       <option label="<?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_GBP?>" value="GBP"><?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_GBP?></option>
       <option label="<?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_JPY?>" value="JPY"><?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_JPY?></option>
       <option label="<?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_EUR?>" value="EUR"><?=$Mem_radio_RMB?>-&gt;<?=$Mem_radio_EUR?></option>
       </select>
        <?=$Mem_Today_Exchange?> :<font color="#FF0033" id="mcy_now">0</font>&nbsp;(<?=$Mem_Today_Exchange_Reference?>)		
	 </td>
    </tr>
<?
if ($pay_type==0){
?>	
    <tr id='credit_0' style="display:block" class="m_bc_ed">
      <td class="m_co_ed" ><?=$Mem_Credit_Amount?> :</td>
      <td>
        <input type=TEXT name="maxcredit" value="<?=$credit?>" size=12 maxlength=12 class="za_text" onKeyUp="Chg_Mcy('mx');" onKeyPress="return CheckKey();">&nbsp;
<?
	switch($curtype){
	case 'HKD':
		echo $Mem_radio_HKD;
		break;
	case 'USD':
		echo $Mem_radio_USD;
		break;
	case 'MYR':
		echo $Mem_radio_MYR;
		break;
	case 'SGD':
		echo $Mem_radio_SGD;
		break;
	case 'THB':
		echo $Mem_radio_THB;
		break;
	case 'GBP':
		echo $Mem_radio_GBP;
		break;
	case 'JPY':
		echo $Mem_radio_JPY;
		break;
	case 'EUR':
		echo $Mem_radio_EUR;
		break;
	case 'RMB':
		echo $Mem_radio_RMB;
		break;
	case 'NTD':
		echo $Mem_radio_NTD;
		break;
	case '':
		echo $Mem_radio_RMB;
		break;
	}
?>:<font color="#FF0033" id="mcy_mx">0</font></font>
	  </td>
    </tr>
<?
}else if ($pay_type==1){
?>
    <tr id='credit_1'  style="display:block" class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_Cash?> :</td>
      <td>
	<?=$money?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$Mem_Cash?>请到现金系统修改
	  </td>
    </tr>
<?
}
?>
    <tr class="m_bc_ed" align="center">
      <td colspan="2">
        <input type=SUBMIT name="OK" value="<?=$Mem_Confirm?>" class="za_button">
        &nbsp; &nbsp; &nbsp;
        <input type=BUTTON name="FormsButton2" value="<?=$Mem_Cancle?>" id="FormsButton2" onClick="window.location.replace('user_browse.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&enable=Y');" class="za_button">
      </td>
    </tr>
  </table>
</form>
<iframe name="check_frame" src="" width="0" height="0" style="display:none"></iframe>
</body>
</html>
<?
}
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$username',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>