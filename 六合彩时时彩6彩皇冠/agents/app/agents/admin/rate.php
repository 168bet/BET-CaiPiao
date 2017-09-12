<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
$uid=$_REQUEST["uid"];
$lv=$_REQUEST["lv"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$type=$_REQUEST["type"];
$num=$_REQUEST["num"];
$active=$_REQUEST["active"];
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$sql = "select * from number_num";
$result = mysql_db_query($dbname,$sql);
$row=mysql_fetch_array($result);
if ($num=='SCA'){
    $Title='特码A';
}else if($num=='SCB'){
    $Title='特码B';
}else if($num=='AC'){
    $Title='正码';
}else if($num=='AC6'){
    $Title='正码1-6';
}else if($num=='GC'){
    $Title='综合';
}
$mysql = "select * from number_down";
$result = mysql_db_query($dbname,$mysql);
$down=mysql_fetch_array($result);

switch ($type){
case "SCA":
   $sql="update number_num set N_Rates_SCA_01='".$_REQUEST['N01']."',N_Rates_SCA_02='".$_REQUEST['N02']."',N_Rates_SCA_03='".$_REQUEST['N03']."',N_Rates_SCA_04='".$_REQUEST['N04']."',N_Rates_SCA_05='".$_REQUEST['N05']."',N_Rates_SCA_06='".$_REQUEST['N06']."',N_Rates_SCA_07='".$_REQUEST['N07']."',N_Rates_SCA_08='".$_REQUEST['N08']."',N_Rates_SCA_09='".$_REQUEST['N09']."',N_Rates_SCA_10='".$_REQUEST['N10']."',N_Rates_SCA_11='".$_REQUEST['N11']."',N_Rates_SCA_12='".$_REQUEST['N12']."',N_Rates_SCA_13='".$_REQUEST['N13']."',N_Rates_SCA_14='".$_REQUEST['N14']."',N_Rates_SCA_15='".$_REQUEST['N15']."',N_Rates_SCA_16='".$_REQUEST['N16']."',N_Rates_SCA_17='".$_REQUEST['N17']."',N_Rates_SCA_18='".$_REQUEST['N18']."',N_Rates_SCA_19='".$_REQUEST['N19']."',N_Rates_SCA_20='".$_REQUEST['N20']."',N_Rates_SCA_21='".$_REQUEST['N21']."',N_Rates_SCA_22='".$_REQUEST['N22']."',N_Rates_SCA_23='".$_REQUEST['N23']."',N_Rates_SCA_24='".$_REQUEST['N24']."',N_Rates_SCA_25='".$_REQUEST['N25']."',N_Rates_SCA_26='".$_REQUEST['N26']."',N_Rates_SCA_27='".$_REQUEST['N27']."',N_Rates_SCA_28='".$_REQUEST['N28']."',N_Rates_SCA_29='".$_REQUEST['N29']."',N_Rates_SCA_30='".$_REQUEST['N30']."',N_Rates_SCA_31='".$_REQUEST['N31']."',N_Rates_SCA_32='".$_REQUEST['N32']."',N_Rates_SCA_33='".$_REQUEST['N33']."',N_Rates_SCA_34='".$_REQUEST['N34']."',N_Rates_SCA_35='".$_REQUEST['N35']."',N_Rates_SCA_36='".$_REQUEST['N36']."',N_Rates_SCA_37='".$_REQUEST['N37']."',N_Rates_SCA_38='".$_REQUEST['N38']."',N_Rates_SCA_39='".$_REQUEST['N39']."',N_Rates_SCA_40='".$_REQUEST['N40']."',N_Rates_SCA_41='".$_REQUEST['N41']."',N_Rates_SCA_42='".$_REQUEST['N42']."',N_Rates_SCA_43='".$_REQUEST['N43']."',N_Rates_SCA_44='".$_REQUEST['N44']."',N_Rates_SCA_45='".$_REQUEST['N45']."',N_Rates_SCA_46='".$_REQUEST['N46']."',N_Rates_SCA_47='".$_REQUEST['N47']."',N_Rates_SCA_48='".$_REQUEST['N48']."',N_Rates_SCA_49='".$_REQUEST['N49']."',N_Rates_SCA_Red='".$_REQUEST['Red']."',N_Rates_SCA_Blue='".$_REQUEST['Blue']."',N_Rates_SCA_Green='".$_REQUEST['Green']."',N_Rates_SCA_AOver='".$_REQUEST['AOver']."',N_Rates_SCA_AUnder='".$_REQUEST['AUnder']."',N_Rates_SCA_BOver='".$_REQUEST['BOver']."',N_Rates_SCA_BUnder='".$_REQUEST['BUnder']."',N_Rates_SCA_AOdd='".$_REQUEST['AOdd']."',N_Rates_SCA_AEven='".$_REQUEST['AEven']."',N_Rates_SCA_BOdd='".$_REQUEST['BOdd']."',N_Rates_SCA_BEven='".$_REQUEST['BEven']."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$num&langx=$langx'</script>";	
   break;
case "SCB":
   $sql="update number_num set N_Rates_SCB_01='".$_REQUEST['N01']."',N_Rates_SCB_02='".$_REQUEST['N02']."',N_Rates_SCB_03='".$_REQUEST['N03']."',N_Rates_SCB_04='".$_REQUEST['N04']."',N_Rates_SCB_05='".$_REQUEST['N05']."',N_Rates_SCB_06='".$_REQUEST['N06']."',N_Rates_SCB_07='".$_REQUEST['N07']."',N_Rates_SCB_08='".$_REQUEST['N08']."',N_Rates_SCB_09='".$_REQUEST['N09']."',N_Rates_SCB_10='".$_REQUEST['N10']."',N_Rates_SCB_11='".$_REQUEST['N11']."',N_Rates_SCB_12='".$_REQUEST['N12']."',N_Rates_SCB_13='".$_REQUEST['N13']."',N_Rates_SCB_14='".$_REQUEST['N14']."',N_Rates_SCB_15='".$_REQUEST['N15']."',N_Rates_SCB_16='".$_REQUEST['N16']."',N_Rates_SCB_17='".$_REQUEST['N17']."',N_Rates_SCB_18='".$_REQUEST['N18']."',N_Rates_SCB_19='".$_REQUEST['N19']."',N_Rates_SCB_20='".$_REQUEST['N20']."',N_Rates_SCB_21='".$_REQUEST['N21']."',N_Rates_SCB_22='".$_REQUEST['N22']."',N_Rates_SCB_23='".$_REQUEST['N23']."',N_Rates_SCB_24='".$_REQUEST['N24']."',N_Rates_SCB_25='".$_REQUEST['N25']."',N_Rates_SCB_26='".$_REQUEST['N26']."',N_Rates_SCB_27='".$_REQUEST['N27']."',N_Rates_SCB_28='".$_REQUEST['N28']."',N_Rates_SCB_29='".$_REQUEST['N29']."',N_Rates_SCB_30='".$_REQUEST['N30']."',N_Rates_SCB_31='".$_REQUEST['N31']."',N_Rates_SCB_32='".$_REQUEST['N32']."',N_Rates_SCB_33='".$_REQUEST['N33']."',N_Rates_SCB_34='".$_REQUEST['N34']."',N_Rates_SCB_35='".$_REQUEST['N35']."',N_Rates_SCB_36='".$_REQUEST['N36']."',N_Rates_SCB_37='".$_REQUEST['N37']."',N_Rates_SCB_38='".$_REQUEST['N38']."',N_Rates_SCB_39='".$_REQUEST['N39']."',N_Rates_SCB_40='".$_REQUEST['N40']."',N_Rates_SCB_41='".$_REQUEST['N41']."',N_Rates_SCB_42='".$_REQUEST['N42']."',N_Rates_SCB_43='".$_REQUEST['N43']."',N_Rates_SCB_44='".$_REQUEST['N44']."',N_Rates_SCB_45='".$_REQUEST['N45']."',N_Rates_SCB_46='".$_REQUEST['N46']."',N_Rates_SCB_47='".$_REQUEST['N47']."',N_Rates_SCB_48='".$_REQUEST['N48']."',N_Rates_SCB_49='".$_REQUEST['N49']."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$num&langx=$langx'</script>";	
   break;
case "AC":
   $sql="update number_num set N_Rates_AC_01='".$_REQUEST['N01']."',N_Rates_AC_02='".$_REQUEST['N02']."',N_Rates_AC_03='".$_REQUEST['N03']."',N_Rates_AC_04='".$_REQUEST['N04']."',N_Rates_AC_05='".$_REQUEST['N05']."',N_Rates_AC_06='".$_REQUEST['N06']."',N_Rates_AC_07='".$_REQUEST['N07']."',N_Rates_AC_08='".$_REQUEST['N08']."',N_Rates_AC_09='".$_REQUEST['N09']."',N_Rates_AC_10='".$_REQUEST['N10']."',N_Rates_AC_11='".$_REQUEST['N11']."',N_Rates_AC_12='".$_REQUEST['N12']."',N_Rates_AC_13='".$_REQUEST['N13']."',N_Rates_AC_14='".$_REQUEST['N14']."',N_Rates_AC_15='".$_REQUEST['N15']."',N_Rates_AC_16='".$_REQUEST['N16']."',N_Rates_AC_17='".$_REQUEST['N17']."',N_Rates_AC_18='".$_REQUEST['N18']."',N_Rates_AC_19='".$_REQUEST['N19']."',N_Rates_AC_20='".$_REQUEST['N20']."',N_Rates_AC_21='".$_REQUEST['N21']."',N_Rates_AC_22='".$_REQUEST['N22']."',N_Rates_AC_23='".$_REQUEST['N23']."',N_Rates_AC_24='".$_REQUEST['N24']."',N_Rates_AC_25='".$_REQUEST['N25']."',N_Rates_AC_26='".$_REQUEST['N26']."',N_Rates_AC_27='".$_REQUEST['N27']."',N_Rates_AC_28='".$_REQUEST['N28']."',N_Rates_AC_29='".$_REQUEST['N29']."',N_Rates_AC_30='".$_REQUEST['N30']."',N_Rates_AC_31='".$_REQUEST['N31']."',N_Rates_AC_32='".$_REQUEST['N32']."',N_Rates_AC_33='".$_REQUEST['N33']."',N_Rates_AC_34='".$_REQUEST['N34']."',N_Rates_AC_35='".$_REQUEST['N35']."',N_Rates_AC_36='".$_REQUEST['N36']."',N_Rates_AC_37='".$_REQUEST['N37']."',N_Rates_AC_38='".$_REQUEST['N38']."',N_Rates_AC_39='".$_REQUEST['N39']."',N_Rates_AC_40='".$_REQUEST['N40']."',N_Rates_AC_41='".$_REQUEST['N41']."',N_Rates_AC_42='".$_REQUEST['N42']."',N_Rates_AC_43='".$_REQUEST['N43']."',N_Rates_AC_44='".$_REQUEST['N44']."',N_Rates_AC_45='".$_REQUEST['N45']."',N_Rates_AC_46='".$_REQUEST['N46']."',N_Rates_AC_47='".$_REQUEST['N47']."',N_Rates_AC_48='".$_REQUEST['N48']."',N_Rates_AC_49='".$_REQUEST['N49']."',N_Rates_AC_TOdd='".$_REQUEST['TOdd']."',N_Rates_AC_TEven='".$_REQUEST['TEven']."',N_Rates_AC_TOver='".$_REQUEST['TOver']."',N_Rates_AC_TUnder='".$_REQUEST['TUnder']."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$num&langx=$langx'</script>";	
   break;
case "AC6":
   $sql="update number_num set N_Rates_AC1_Red='".$_REQUEST['AC1_Red']."',N_Rates_AC2_Red='".$_REQUEST['AC2_Red']."',N_Rates_AC3_Red='".$_REQUEST['AC3_Red']."',N_Rates_AC4_Red='".$_REQUEST['AC4_Red']."',N_Rates_AC5_Red='".$_REQUEST['AC5_Red']."',N_Rates_AC6_Red='".$_REQUEST['AC6_Red']."',N_Rates_AC1_Blue='".$_REQUEST['AC1_Blue']."',N_Rates_AC2_Blue='".$_REQUEST['AC2_Blue']."',N_Rates_AC3_Blue='".$_REQUEST['AC3_Blue']."',N_Rates_AC4_Blue='".$_REQUEST['AC4_Blue']."',N_Rates_AC5_Blue='".$_REQUEST['AC5_Blue']."',N_Rates_AC6_Blue='".$_REQUEST['AC6_Blue']."',N_Rates_AC1_Green='".$_REQUEST['AC1_Green']."',N_Rates_AC2_Green='".$_REQUEST['AC2_Green']."',N_Rates_AC3_Green='".$_REQUEST['AC3_Green']."',N_Rates_AC4_Green='".$_REQUEST['AC4_Green']."',N_Rates_AC5_Green='".$_REQUEST['AC5_Green']."',N_Rates_AC6_Green='".$_REQUEST['AC6_Green']."',N_Rates_AC1_AOver='".$_REQUEST['AC1_AOver']."',N_Rates_AC2_AOver='".$_REQUEST['AC2_AOver']."',N_Rates_AC3_AOver='".$_REQUEST['AC3_AOver']."',N_Rates_AC4_AOver='".$_REQUEST['AC4_AOver']."',N_Rates_AC5_AOver='".$_REQUEST['AC5_AOver']."',N_Rates_AC6_AOver='".$_REQUEST['AC6_AOver']."',N_Rates_AC1_AUnder='".$_REQUEST['AC1_AUnder']."',N_Rates_AC2_AUnder='".$_REQUEST['AC2_AUnder']."',N_Rates_AC3_AUnder='".$_REQUEST['AC3_AUnder']."',N_Rates_AC4_AUnder='".$_REQUEST['AC4_AUnder']."',N_Rates_AC5_AUnder='".$_REQUEST['AC5_AUnder']."',N_Rates_AC6_AUnder='".$_REQUEST['AC6_AUnder']."',N_Rates_AC1_BOver='".$_REQUEST['AC1_BOver']."',N_Rates_AC2_BOver='".$_REQUEST['AC2_BOver']."',N_Rates_AC3_BOver='".$_REQUEST['AC3_BOver']."',N_Rates_AC4_BOver='".$_REQUEST['AC4_BOver']."',N_Rates_AC5_BOver='".$_REQUEST['AC5_BOver']."',N_Rates_AC6_BOver='".$_REQUEST['AC6_BOver']."',N_Rates_AC1_BUnder='".$_REQUEST['AC1_BUnder']."',N_Rates_AC2_BUnder='".$_REQUEST['AC2_BUnder']."',N_Rates_AC3_BUnder='".$_REQUEST['AC3_BUnder']."',N_Rates_AC4_BUnder='".$_REQUEST['AC4_BUnder']."',N_Rates_AC5_BUnder='".$_REQUEST['AC5_BUnder']."',N_Rates_AC6_BUnder='".$_REQUEST['AC6_BUnder']."',N_Rates_AC1_AOdd='".$_REQUEST['AC1_AOdd']."',N_Rates_AC2_AOdd='".$_REQUEST['AC2_AOdd']."',N_Rates_AC3_AOdd='".$_REQUEST['AC3_AOdd']."',N_Rates_AC4_AOdd='".$_REQUEST['AC4_AOdd']."',N_Rates_AC5_AOdd='".$_REQUEST['AC5_AOdd']."',N_Rates_AC6_AOdd='".$_REQUEST['AC6_AOdd']."',N_Rates_AC1_AEven='".$_REQUEST['AC1_AEven']."',N_Rates_AC2_AEven='".$_REQUEST['AC2_AEven']."',N_Rates_AC3_AEven='".$_REQUEST['AC3_AEven']."',N_Rates_AC4_AEven='".$_REQUEST['AC4_AEven']."',N_Rates_AC5_AEven='".$_REQUEST['AC5_AEven']."',N_Rates_AC6_AEven='".$_REQUEST['AC6_AEven']."',N_Rates_AC1_BOdd='".$_REQUEST['AC1_BOdd']."',N_Rates_AC2_BOdd='".$_REQUEST['AC2_BOdd']."',N_Rates_AC3_BOdd='".$_REQUEST['AC3_BOdd']."',N_Rates_AC4_BOdd='".$_REQUEST['AC4_BOdd']."',N_Rates_AC5_BOdd='".$_REQUEST['AC5_BOdd']."',N_Rates_AC6_BOdd='".$_REQUEST['AC6_BOdd']."',N_Rates_AC1_BEven='".$_REQUEST['AC1_BEven']."',N_Rates_AC2_BEven='".$_REQUEST['AC2_BEven']."',N_Rates_AC3_BEven='".$_REQUEST['AC3_BEven']."',N_Rates_AC4_BEven='".$_REQUEST['AC4_BEven']."',N_Rates_AC5_BEven='".$_REQUEST['AC5_BEven']."',N_Rates_AC6_BEven='".$_REQUEST['AC6_BEven']."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$num&langx=$langx'</script>";	
   break;
case "GC":
   $sql="update number_num set N_Rates_Rat='".$_REQUEST['Rat']."',N_Rates_Cow='".$_REQUEST['Cow']."',N_Rates_Tiger='".$_REQUEST['Tiger']."',N_Rates_Rabbit='".$_REQUEST['Rabbit']."',N_Rates_Liuzhou='".$_REQUEST['Liuzhou']."',N_Rates_Snake='".$_REQUEST['Snake']."',N_Rates_Horse='".$_REQUEST['Horse']."',N_Rates_Sheep='".$_REQUEST['Sheep']."',N_Rates_Monkey='".$_REQUEST['Monkey']."',N_Rates_Chicken='".$_REQUEST['Chicken']."',N_Rates_Dog='".$_REQUEST['Dog']."',N_Rates_Pig='".$_REQUEST['Pig']."',N_Rates_Red_Odd='".$_REQUEST['Red_Odd']."',N_Rates_Red_Even='".$_REQUEST['Red_Even']."',N_Rates_Red_Over='".$_REQUEST['Red_Over']."',N_Rates_Red_Under='".$_REQUEST['Red_Under']."',N_Rates_Blue_Odd='".$_REQUEST['Blue_Odd']."',N_Rates_Blue_Even='".$_REQUEST['Blue_Even']."',N_Rates_Blue_Over='".$_REQUEST['Blue_Over']."',N_Rates_Blue_Under='".$_REQUEST['Blue_Under']."',N_Rates_Green_Odd='".$_REQUEST['Green_Odd']."',N_Rates_Green_Even='".$_REQUEST['Green_Even']."',N_Rates_Green_Over='".$_REQUEST['Green_Over']."',N_Rates_Green_Under='".$_REQUEST['Green_Under']."',N_Rates_Last_Rat='".$_REQUEST['Last_Rat']."',N_Rates_Last_Cow='".$_REQUEST['Last_Cow']."',N_Rates_Last_Tiger='".$_REQUEST['Last_Tiger']."',N_Rates_Last_Rabbit='".$_REQUEST['Last_Rabbit']."',N_Rates_Last_Liuzhou='".$_REQUEST['Last_Liuzhou']."',N_Rates_Last_Snake='".$_REQUEST['Last_Snake']."',N_Rates_Last_Horse='".$_REQUEST['Last_Horse']."',N_Rates_Last_Sheep='".$_REQUEST['Last_Sheep']."',N_Rates_Last_Monkey='".$_REQUEST['Last_Monkey']."',N_Rates_Last_Chicken='".$_REQUEST['Last_Chicken']."',N_Rates_Last_Dog='".$_REQUEST['Last_Dog']."',N_Rates_Last_Pig='".$_REQUEST['Last_Pig']."',N_Rates_3_Animals='".$_REQUEST['3_Animals']."',N_Rates_4_Animals='".$_REQUEST['4_Animals']."',N_Rates_5_Animals='".$_REQUEST['5_Animals']."',N_Rates_6_Animals='".$_REQUEST['6_Animals']."',N_Rates_3_1='".$_REQUEST['3_1']."',N_Rates_3_2_2='".$_REQUEST['3_2_2']."',N_Rates_3_2_3='".$_REQUEST['3_2_3']."',N_Rates_2_1='".$_REQUEST['2_1']."',N_Rates_2_0_0='".$_REQUEST['2_0_0']."',N_Rates_2_0_2='".$_REQUEST['2_0_2']."',N_Rates_1_1='".$_REQUEST['1_1']."',N_Rates_Last_00='".$_REQUEST['Last_00']."',N_Rates_Last_01='".$_REQUEST['Last_01']."',N_Rates_Last_02='".$_REQUEST['Last_02']."',N_Rates_Last_03='".$_REQUEST['Last_03']."',N_Rates_Last_04='".$_REQUEST['Last_04']."',N_Rates_Last_05='".$_REQUEST['Last_05']."',N_Rates_Last_06='".$_REQUEST['Last_06']."',N_Rates_Last_07='".$_REQUEST['Last_07']."',N_Rates_Last_08='".$_REQUEST['Last_08']."',N_Rates_Last_09='".$_REQUEST['Last_09']."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$num&langx=$langx'</script>";	
   break; 
case "DOWNFORM":
   $sql="update number_down set 
   Num_Sum_SCA='".$_REQUEST['Num_Sum_SCA']."',Num_Down_Rate_SCA='".$_REQUEST['Num_Down_Rate_SCA']."',Num_Lowest_Rate_SCA='".$_REQUEST['Num_Lowest_Rate_SCA']."',Num_Sum_SCB='".$_REQUEST['Num_Sum_SCB']."',Num_Down_Rate_SCB='".$_REQUEST['Num_Down_Rate_SCB']."',Num_Lowest_Rate_SCB='".$_REQUEST['Num_Lowest_Rate_SCB']."',Num_Sum_SCA_AOUEO='".$_REQUEST['Num_Sum_SCA_AOUEO']."',Num_Down_Rate_SCA_AOUEO='".$_REQUEST['Num_Down_Rate_SCA_AOUEO']."',Num_Lowest_Rate_SCA_AOUEO='".$_REQUEST['Num_Lowest_Rate_SCA_AOUEO']."',Num_Sum_SCA_BOUEO='".$_REQUEST['Num_Sum_SCA_BOUEO']."',Num_Down_Rate_SCA_BOUEO='".$_REQUEST['Num_Down_Rate_SCA_BOUEO']."',Num_Lowest_Rate_SCA_BOUEO='".$_REQUEST['Num_Lowest_Rate_SCA_BOUEO']."',Num_Sum_SCA_Wave='".$_REQUEST['Num_Sum_SCA_Wave']."',Num_Down_Rate_SCA_Wave='".$_REQUEST['Num_Down_Rate_SCA_Wave']."',Num_Lowest_Rate_SCA_Wave='".$_REQUEST['Num_Lowest_Rate_SCA_Wave']."',Num_Sum_AC='".$_REQUEST['Num_Sum_AC']."',Num_Down_Rate_AC='".$_REQUEST['Num_Down_Rate_AC']."',Num_Lowest_Rate_AC='".$_REQUEST['Num_Lowest_Rate_AC']."',Num_Sum_AC_TOUEO='".$_REQUEST['Num_Sum_AC_TOUEO']."',Num_Down_Rate_AC_TOUEO='".$_REQUEST['Num_Down_Rate_AC_TOUEO']."',Num_Lowest_Rate_AC_TOUEO='".$_REQUEST['Num_Lowest_Rate_AC_TOUEO']."',Num_Sum_AC_AOUEO='".$_REQUEST['Num_Sum_AC_AOUEO']."',Num_Down_Rate_AC_AOUEO='".$_REQUEST['Num_Down_Rate_AC_AOUEO']."',Num_Lowest_Rate_AC_AOUEO='".$_REQUEST['Num_Lowest_Rate_AC_AOUEO']."',Num_Sum_AC_BOUEO='".$_REQUEST['Num_Sum_AC_BOUEO']."',Num_Down_Rate_AC_BOUEO='".$_REQUEST['Num_Down_Rate_AC_BOUEO']."',Num_Lowest_Rate_AC_BOUEO='".$_REQUEST['Num_Lowest_Rate_AC_BOUEO']."',Num_Sum_AC_Wave='".$_REQUEST['Num_Sum_AC_Wave']."',Num_Down_Rate_AC_Wave='".$_REQUEST['Num_Down_Rate_AC_Wave']."',Num_Lowest_Rate_AC_Wave='".$_REQUEST['Num_Lowest_Rate_AC_Wave']."',Num_Sum_SX='".$_REQUEST['Num_Sum_SX']."',Num_Down_Rate_SX='".$_REQUEST['Num_Down_Rate_SX']."',Num_Lowest_Rate_SX='".$_REQUEST['Num_Lowest_Rate_SX']."',Num_Sum_HW='".$_REQUEST['Num_Sum_HW']."',Num_Down_Rate_HW='".$_REQUEST['Num_Down_Rate_HW']."',Num_Lowest_Rate_HW='".$_REQUEST['Num_Lowest_Rate_HW']."',Num_Sum_EC='".$_REQUEST['Num_Sum_EC']."',Num_Down_Rate_EC='".$_REQUEST['Num_Down_Rate_EC']."',Num_Lowest_Rate_EC='".$_REQUEST['Num_Lowest_Rate_EC']."',Num_Sum_M='".$_REQUEST['Num_Sum_M']."',Num_Down_Rate_M='".$_REQUEST['Num_Down_Rate_M']."',Num_Lowest_Rate_M='".$_REQUEST['Num_Lowest_Rate_M']."',Num_Sum_MT='".$_REQUEST['Num_Sum_MT']."',Num_Down_Rate_MT='".$_REQUEST['Num_Down_Rate_MT']."',Num_Lowest_Rate_MT='".$_REQUEST['Num_Lowest_Rate_MT']."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$num&langx=$langx'</script>";	
   break; 
}

if($active=='SCA'){
   $sql="update number_num set N_Rate_SCA_01='".$row[N_Rates_SCA_01]."',N_Rate_SCA_02='".$row[N_Rates_SCA_02]."',N_Rate_SCA_03='".$row[N_Rates_SCA_03]."',N_Rate_SCA_04='".$row[N_Rates_SCA_04]."',N_Rate_SCA_05='".$row[N_Rates_SCA_05]."',N_Rate_SCA_06='".$row[N_Rates_SCA_06]."',N_Rate_SCA_07='".$row[N_Rates_SCA_07]."',N_Rate_SCA_08='".$row[N_Rates_SCA_08]."',N_Rate_SCA_09='".$row[N_Rates_SCA_09]."',N_Rate_SCA_10='".$row[N_Rates_SCA_10]."',N_Rate_SCA_11='".$row[N_Rates_SCA_11]."',N_Rate_SCA_12='".$row[N_Rates_SCA_12]."',N_Rate_SCA_13='".$row[N_Rates_SCA_13]."',N_Rate_SCA_14='".$row[N_Rates_SCA_14]."',N_Rate_SCA_15='".$row[N_Rates_SCA_15]."',N_Rate_SCA_16='".$row[N_Rates_SCA_16]."',N_Rate_SCA_17='".$row[N_Rates_SCA_17]."',N_Rate_SCA_18='".$row[N_Rates_SCA_18]."',N_Rate_SCA_19='".$row[N_Rates_SCA_19]."',N_Rate_SCA_20='".$row[N_Rates_SCA_20]."',N_Rate_SCA_21='".$row[N_Rates_SCA_21]."',N_Rate_SCA_22='".$row[N_Rates_SCA_22]."',N_Rate_SCA_23='".$row[N_Rates_SCA_23]."',N_Rate_SCA_24='".$row[N_Rates_SCA_24]."',N_Rate_SCA_25='".$row[N_Rates_SCA_25]."',N_Rate_SCA_26='".$row[N_Rates_SCA_26]."',N_Rate_SCA_27='".$row[N_Rates_SCA_27]."',N_Rate_SCA_28='".$row[N_Rates_SCA_28]."',N_Rate_SCA_29='".$row[N_Rates_SCA_29]."',N_Rate_SCA_30='".$row[N_Rates_SCA_30]."',N_Rate_SCA_31='".$row[N_Rates_SCA_31]."',N_Rate_SCA_32='".$row[N_Rates_SCA_32]."',N_Rate_SCA_33='".$row[N_Rates_SCA_33]."',N_Rate_SCA_34='".$row[N_Rates_SCA_34]."',N_Rate_SCA_35='".$row[N_Rates_SCA_35]."',N_Rate_SCA_36='".$row[N_Rates_SCA_36]."',N_Rate_SCA_37='".$row[N_Rates_SCA_37]."',N_Rate_SCA_38='".$row[N_Rates_SCA_38]."',N_Rate_SCA_39='".$row[N_Rates_SCA_39]."',N_Rate_SCA_40='".$row[N_Rates_SCA_40]."',N_Rate_SCA_41='".$row[N_Rates_SCA_41]."',N_Rate_SCA_42='".$row[N_Rates_SCA_42]."',N_Rate_SCA_43='".$row[N_Rates_SCA_43]."',N_Rate_SCA_44='".$row[N_Rates_SCA_44]."',N_Rate_SCA_45='".$row[N_Rates_SCA_45]."',N_Rate_SCA_46='".$row[N_Rates_SCA_46]."',N_Rate_SCA_47='".$row[N_Rates_SCA_47]."',N_Rate_SCA_48='".$row[N_Rates_SCA_48]."',N_Rate_SCA_49='".$row[N_Rates_SCA_49]."',N_Rate_SCA_Red='".$row[N_Rates_SCA_Red]."',N_Rate_SCA_Blue='".$row[N_Rates_SCA_Blue]."',N_Rate_SCA_Green='".$row[N_Rates_SCA_Green]."',N_Rate_SCA_AOver='".$row[N_Rates_SCA_AOver]."',N_Rate_SCA_AUnder='".$row[N_Rates_SCA_AUnder]."',N_Rate_SCA_BOver='".$row[N_Rates_SCA_BOver]."',N_Rate_SCA_BUnder='".$row[N_Rates_SCA_BUnder]."',N_Rate_SCA_AOdd='".$row[N_Rates_SCA_AOdd]."',N_Rate_SCA_AEven='".$row[N_Rates_SCA_AEven]."',N_Rate_SCA_BOdd='".$row[N_Rates_SCA_BOdd]."',N_Rate_SCA_BEven='".$row[N_Rates_SCA_BEven]."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$active&langx=$langx'</script>";	
}else if($active=='SCB'){
   $sql="update number_num set N_Rate_SCB_01='".$row[N_Rates_SCB_01]."',N_Rate_SCB_02='".$row[N_Rates_SCB_02]."',N_Rate_SCB_03='".$row[N_Rates_SCB_03]."',N_Rate_SCB_04='".$row[N_Rates_SCB_04]."',N_Rate_SCB_05='".$row[N_Rates_SCB_05]."',N_Rate_SCB_06='".$row[N_Rates_SCB_06]."',N_Rate_SCB_07='".$row[N_Rates_SCB_07]."',N_Rate_SCB_08='".$row[N_Rates_SCB_08]."',N_Rate_SCB_09='".$row[N_Rates_SCB_09]."',N_Rate_SCB_10='".$row[N_Rates_SCB_10]."',N_Rate_SCB_11='".$row[N_Rates_SCB_11]."',N_Rate_SCB_12='".$row[N_Rates_SCB_12]."',N_Rate_SCB_13='".$row[N_Rates_SCB_13]."',N_Rate_SCB_14='".$row[N_Rates_SCB_14]."',N_Rate_SCB_15='".$row[N_Rates_SCB_15]."',N_Rate_SCB_16='".$row[N_Rates_SCB_16]."',N_Rate_SCB_17='".$row[N_Rates_SCB_17]."',N_Rate_SCB_18='".$row[N_Rates_SCB_18]."',N_Rate_SCB_19='".$row[N_Rates_SCB_19]."',N_Rate_SCB_20='".$row[N_Rates_SCB_20]."',N_Rate_SCB_21='".$row[N_Rates_SCB_21]."',N_Rate_SCB_22='".$row[N_Rates_SCB_22]."',N_Rate_SCB_23='".$row[N_Rates_SCB_23]."',N_Rate_SCB_24='".$row[N_Rates_SCB_24]."',N_Rate_SCB_25='".$row[N_Rates_SCB_25]."',N_Rate_SCB_26='".$row[N_Rates_SCB_26]."',N_Rate_SCB_27='".$row[N_Rates_SCB_27]."',N_Rate_SCB_28='".$row[N_Rates_SCB_28]."',N_Rate_SCB_29='".$row[N_Rates_SCB_29]."',N_Rate_SCB_30='".$row[N_Rates_SCB_30]."',N_Rate_SCB_31='".$row[N_Rates_SCB_31]."',N_Rate_SCB_32='".$row[N_Rates_SCB_32]."',N_Rate_SCB_33='".$row[N_Rates_SCB_33]."',N_Rate_SCB_34='".$row[N_Rates_SCB_34]."',N_Rate_SCB_35='".$row[N_Rates_SCB_35]."',N_Rate_SCB_36='".$row[N_Rates_SCB_36]."',N_Rate_SCB_37='".$row[N_Rates_SCB_37]."',N_Rate_SCB_38='".$row[N_Rates_SCB_38]."',N_Rate_SCB_39='".$row[N_Rates_SCB_39]."',N_Rate_SCB_40='".$row[N_Rates_SCB_40]."',N_Rate_SCB_41='".$row[N_Rates_SCB_41]."',N_Rate_SCB_42='".$row[N_Rates_SCB_42]."',N_Rate_SCB_43='".$row[N_Rates_SCB_43]."',N_Rate_SCB_44='".$row[N_Rates_SCB_44]."',N_Rate_SCB_45='".$row[N_Rates_SCB_45]."',N_Rate_SCB_46='".$row[N_Rates_SCB_46]."',N_Rate_SCB_47='".$row[N_Rates_SCB_47]."',N_Rate_SCB_48='".$row[N_Rates_SCB_48]."',N_Rate_SCB_49='".$row[N_Rates_SCB_49]."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$active&langx=$langx'</script>";	
}else if($active=='AC'){
   $sql="update number_num set N_Rate_AC_01='".$row[N_Rates_AC_01]."',N_Rate_AC_02='".$row[N_Rates_AC_02]."',N_Rate_AC_03='".$row[N_Rates_AC_03]."',N_Rate_AC_04='".$row[N_Rates_AC_04]."',N_Rate_AC_05='".$row[N_Rates_AC_05]."',N_Rate_AC_06='".$row[N_Rates_AC_06]."',N_Rate_AC_07='".$row[N_Rates_AC_07]."',N_Rate_AC_08='".$row[N_Rates_AC_08]."',N_Rate_AC_09='".$row[N_Rates_AC_09]."',N_Rate_AC_10='".$row[N_Rates_AC_10]."',N_Rate_AC_11='".$row[N_Rates_AC_11]."',N_Rate_AC_12='".$row[N_Rates_AC_12]."',N_Rate_AC_13='".$row[N_Rates_AC_13]."',N_Rate_AC_14='".$row[N_Rates_AC_14]."',N_Rate_AC_15='".$row[N_Rates_AC_15]."',N_Rate_AC_16='".$row[N_Rates_AC_16]."',N_Rate_AC_17='".$row[N_Rates_AC_17]."',N_Rate_AC_18='".$row[N_Rates_AC_18]."',N_Rate_AC_19='".$row[N_Rates_AC_19]."',N_Rate_AC_20='".$row[N_Rates_AC_20]."',N_Rate_AC_21='".$row[N_Rates_AC_21]."',N_Rate_AC_22='".$row[N_Rates_AC_22]."',N_Rate_AC_23='".$row[N_Rates_AC_23]."',N_Rate_AC_24='".$row[N_Rates_AC_24]."',N_Rate_AC_25='".$row[N_Rates_AC_25]."',N_Rate_AC_26='".$row[N_Rates_AC_26]."',N_Rate_AC_27='".$row[N_Rates_AC_27]."',N_Rate_AC_28='".$row[N_Rates_AC_28]."',N_Rate_AC_29='".$row[N_Rates_AC_29]."',N_Rate_AC_30='".$row[N_Rates_AC_30]."',N_Rate_AC_31='".$row[N_Rates_AC_31]."',N_Rate_AC_32='".$row[N_Rates_AC_32]."',N_Rate_AC_33='".$row[N_Rates_AC_33]."',N_Rate_AC_34='".$row[N_Rates_AC_34]."',N_Rate_AC_35='".$row[N_Rates_AC_35]."',N_Rate_AC_36='".$row[N_Rates_AC_36]."',N_Rate_AC_37='".$row[N_Rates_AC_37]."',N_Rate_AC_38='".$row[N_Rates_AC_38]."',N_Rate_AC_39='".$row[N_Rates_AC_39]."',N_Rate_AC_40='".$row[N_Rates_AC_40]."',N_Rate_AC_41='".$row[N_Rates_AC_41]."',N_Rate_AC_42='".$row[N_Rates_AC_42]."',N_Rate_AC_43='".$row[N_Rates_AC_43]."',N_Rate_AC_44='".$row[N_Rates_AC_44]."',N_Rate_AC_45='".$row[N_Rates_AC_45]."',N_Rate_AC_46='".$row[N_Rates_AC_46]."',N_Rate_AC_47='".$row[N_Rates_AC_47]."',N_Rate_AC_48='".$row[N_Rates_AC_48]."',N_Rate_AC_49='".$row[N_Rates_AC_49]."',N_Rate_AC_TOver='".$row[N_Rates_AC_TOver]."',N_Rate_AC_TUnder='".$row[N_Rates_AC_TUnder]."',N_Rate_AC_TOdd='".$row[N_Rates_AC_TOdd]."',N_Rate_AC_TEven='".$row[N_Rates_AC_TEven]."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$active&langx=$langx'</script>";	
}else if($active=='AC6'){
   $sql="update number_num set N_Rate_AC1_Red='".$row[N_Rates_AC1_Red]."',N_Rate_AC2_Red='".$row[N_Rates_AC2_Red]."',N_Rate_AC3_Red='".$row[N_Rates_AC3_Red]."',N_Rate_AC4_Red='".$row[N_Rates_AC4_Red]."',N_Rate_AC5_Red='".$row[N_Rates_AC5_Red]."',N_Rate_AC6_Red='".$row[N_Rates_AC6_Red]."',N_Rate_AC1_Blue='".$row[N_Rates_AC1_Blue]."',N_Rate_AC2_Blue='".$row[N_Rates_AC2_Blue]."',N_Rate_AC3_Blue='".$row[N_Rates_AC3_Blue]."',N_Rate_AC4_Blue='".$row[N_Rates_AC4_Blue]."',N_Rate_AC5_Blue='".$row[N_Rates_AC5_Blue]."',N_Rate_AC6_Blue='".$row[N_Rates_AC6_Blue]."',N_Rate_AC1_Green='".$row[N_Rates_AC1_Green]."',N_Rate_AC2_Green='".$row[N_Rates_AC2_Green]."',N_Rate_AC3_Green='".$row[N_Rates_AC3_Green]."',N_Rate_AC4_Green='".$row[N_Rates_AC4_Green]."',N_Rate_AC5_Green='".$row[N_Rates_AC5_Green]."',N_Rate_AC6_Green='".$row[N_Rates_AC6_Green]."',N_Rate_AC1_AOver='".$row[N_Rates_AC1_AOver]."',N_Rate_AC2_AOver='".$row[N_Rates_AC2_AOver]."',N_Rate_AC3_AOver='".$row[N_Rates_AC3_AOver]."',N_Rate_AC4_AOver='".$row[N_Rates_AC4_AOver]."',N_Rate_AC5_AOver='".$row[N_Rates_AC5_AOver]."',N_Rate_AC6_AOver='".$row[N_Rates_AC6_AOver]."',N_Rate_AC1_AUnder='".$row[N_Rates_AC1_AUnder]."',N_Rate_AC2_AUnder='".$row[N_Rates_AC2_AUnder]."',N_Rate_AC3_AUnder='".$row[N_Rates_AC3_AUnder]."',N_Rate_AC4_AUnder='".$row[N_Rates_AC4_AUnder]."',N_Rate_AC5_AUnder='".$row[N_Rates_AC5_AUnder]."',N_Rate_AC6_AUnder='".$row[N_Rates_AC6_AUnder]."',N_Rate_AC1_BOver='".$row[N_Rates_AC1_BOver]."',N_Rate_AC2_BOver='".$row[N_Rates_AC2_BOver]."',N_Rate_AC3_BOver='".$row[N_Rates_AC3_BOver]."',N_Rate_AC4_BOver='".$row[N_Rates_AC4_BOver]."',N_Rate_AC5_BOver='".$row[N_Rates_AC5_BOver]."',N_Rate_AC6_BOver='".$row[N_Rates_AC6_BOver]."',N_Rate_AC1_BUnder='".$row[N_Rates_AC1_BUnder]."',N_Rate_AC2_BUnder='".$row[N_Rates_AC2_BUnder]."',N_Rate_AC3_BUnder='".$row[N_Rates_AC3_BUnder]."',N_Rate_AC4_BUnder='".$row[N_Rates_AC4_BUnder]."',N_Rate_AC5_BUnder='".$row[N_Rates_AC5_BUnder]."',N_Rate_AC6_BUnder='".$row[N_Rates_AC6_BUnder]."',N_Rate_AC1_AOdd='".$row[N_Rates_AC1_AOdd]."',N_Rate_AC2_AOdd='".$row[N_Rates_AC2_AOdd]."',N_Rate_AC3_AOdd='".$row[N_Rates_AC3_AOdd]."',N_Rate_AC4_AOdd='".$row[N_Rates_AC4_AOdd]."',N_Rate_AC5_AOdd='".$row[N_Rates_AC5_AOdd]."',N_Rate_AC6_AOdd='".$row[N_Rates_AC6_AOdd]."',N_Rate_AC1_AEven='".$row[N_Rates_AC1_AEven]."',N_Rate_AC2_AEven='".$row[N_Rates_AC2_AEven]."',N_Rate_AC3_AEven='".$row[N_Rates_AC3_AEven]."',N_Rate_AC4_AEven='".$row[N_Rates_AC4_AEven]."',N_Rate_AC5_AEven='".$row[N_Rates_AC5_AEven]."',N_Rate_AC6_AEven='".$row[N_Rates_AC6_AEven]."',N_Rate_AC1_BOdd='".$row[N_Rates_AC1_BOdd]."',N_Rate_AC2_BOdd='".$row[N_Rates_AC2_BOdd]."',N_Rate_AC3_BOdd='".$row[N_Rates_AC3_BOdd]."',N_Rate_AC4_BOdd='".$row[N_Rates_AC4_BOdd]."',N_Rate_AC5_BOdd='".$row[N_Rates_AC5_BOdd]."',N_Rate_AC6_BOdd='".$row[N_Rates_AC6_BOdd]."',N_Rate_AC1_BEven='".$row[N_Rates_AC1_BEven]."',N_Rate_AC2_BEven='".$row[N_Rates_AC2_BEven]."',N_Rate_AC3_BEven='".$row[N_Rates_AC3_BEven]."',N_Rate_AC4_BEven='".$row[N_Rates_AC4_BEven]."',N_Rate_AC5_BEven='".$row[N_Rates_AC5_BEven]."',N_Rate_AC6_BEven='".$row[N_Rates_AC6_BEven]."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$active&langx=$langx'</script>";	
}else if($active=='GC'){
   $sql="update number_num set N_Rate_Rat='".$row[N_Rates_Rat]."',N_Rate_Cow='".$row[N_Rates_Cow]."',N_Rate_Tiger='".$row[N_Rates_Tiger]."',N_Rate_Rabbit='".$row[N_Rates_Rabbit]."',N_Rate_Liuzhou='".$row[N_Rates_Liuzhou]."',N_Rate_Snake='".$row[N_Rates_Snake]."',N_Rate_Horse='".$row[N_Rates_Horse]."',N_Rate_Sheep='".$row[N_Rates_Sheep]."',N_Rate_Monkey='".$row[N_Rates_Monkey]."',N_Rate_Chicken='".$row[N_Rates_Chicken]."',N_Rate_Dog='".$row[N_Rates_Dog]."',N_Rate_Pig='".$row[N_Rates_Pig]."',N_Rate_Red_Odd='".$row[N_Rates_Red_Odd]."',N_Rate_Red_Even='".$row[N_Rates_Red_Even]."',N_Rate_Red_Over='".$row[N_Rates_Red_Over]."',N_Rate_Red_Under='".$row[N_Rates_Red_Under]."',N_Rate_Blue_Odd='".$row[N_Rates_Blue_Odd]."',N_Rate_Blue_Even='".$row[N_Rates_Blue_Even]."',N_Rate_Blue_Over='".$row[N_Rates_Blue_Over]."',N_Rate_Blue_Under='".$row[N_Rates_Blue_Under]."',N_Rate_Green_Odd='".$row[N_Rates_Green_Odd]."',N_Rate_Green_Even='".$row[N_Rates_Green_Even]."',N_Rate_Green_Over='".$row[N_Rates_Green_Over]."',N_Rate_Green_Under='".$row[N_Rates_Green_Under]."',N_Rate_Last_Rat='".$row[N_Rates_Last_Rat]."',N_Rate_Last_Cow='".$row[N_Rates_Last_Cow]."',N_Rate_Last_Tiger='".$row[N_Rates_Last_Tiger]."',N_Rate_Last_Rabbit='".$row[N_Rates_Last_Rabbit]."',N_Rate_Last_Liuzhou='".$row[N_Rates_Last_Liuzhou]."',N_Rate_Last_Snake='".$row[N_Rates_Last_Snake]."',N_Rate_Last_Horse='".$row[N_Rates_Last_Horse]."',N_Rate_Last_Sheep='".$row[N_Rates_Last_Sheep]."',N_Rate_Last_Monkey='".$row[N_Rates_Last_Monkey]."',N_Rate_Last_Chicken='".$row[N_Rates_Last_Chicken]."',N_Rate_Last_Dog='".$row[N_Rates_Last_Dog]."',N_Rate_Last_Pig='".$row[N_Rates_Last_Pig]."',N_Rate_3_Animals='".$row[N_Rates_3_Animals]."',N_Rate_4_Animals='".$row[N_Rates_4_Animals]."',N_Rate_5_Animals='".$row[N_Rates_5_Animals]."',N_Rate_6_Animals='".$row[N_Rates_6_Animals]."',N_Rate_3_1='".$row[N_Rates_3_1]."',N_Rate_3_2_2='".$row[N_Rates_3_2_2]."',N_Rate_3_2_3='".$row[N_Rates_3_2_3]."',N_Rate_2_1='".$row[N_Rates_2_1]."',N_Rate_2_0_0='".$row[N_Rates_2_0_0]."',N_Rate_2_0_2='".$row[N_Rates_2_0_2]."',N_Rate_1_1='".$row[N_Rates_1_1]."',N_Rate_Last_00='".$row[N_Rates_Last_00]."',N_Rate_Last_01='".$row[N_Rates_Last_01]."',N_Rate_Last_02='".$row[N_Rates_Last_02]."',N_Rate_Last_03='".$row[N_Rates_Last_03]."',N_Rate_Last_04='".$row[N_Rates_Last_04]."',N_Rate_Last_05='".$row[N_Rates_Last_05]."',N_Rate_Last_06='".$row[N_Rates_Last_06]."',N_Rate_Last_07='".$row[N_Rates_Last_07]."',N_Rate_Last_08='".$row[N_Rates_Last_08]."',N_Rate_Last_09='".$row[N_Rates_Last_09]."'";
   mysql_db_query($dbname,$sql);
   echo "<script languag='JavaScript'>self.location='rate.php?uid=$uid&lv=$lv&num=$active&langx=$langx'</script>";	
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language="javascript" src="/js/agents/rate_mod.js"></script>
<script language='javascript'>
function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("只能输入数字!!"); return false;}
}
function CheckCLOSE(str){
 if(confirm("确实要更新 <?=$Title?> 前台的赔率吗?"))
  document.location=str;
}
function CheckUPDATE(str){
 if(confirm("确实要更新 <?=$Title?> 后台的赔率吗?"))
  document.location=str;
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="521">&nbsp;赔率设置--&nbsp;<a href='rate.php?uid=<?=$uid?>&lv=<?=$lv?>&num=SCA&langx=<?=$langx?>' class='ah'>特码A</a>&nbsp;&nbsp;<a href='rate.php?uid=<?=$uid?>&lv=<?=$lv?>&num=SCB&langx=<?=$langx?>' class='ah'>特码B</a>&nbsp;&nbsp;<a href='rate.php?uid=<?=$uid?>&lv=<?=$lv?>&num=AC&langx=<?=$langx?>' class='ah'>正码</a>&nbsp;&nbsp;<a href='rate.php?uid=<?=$uid?>&lv=<?=$lv?>&num=AC6&langx=<?=$langx?>' class='ah'>正码1-6</a>&nbsp;&nbsp;<a href='rate.php?uid=<?=$uid?>&lv=<?=$lv?>&num=GC&langx=<?=$langx?>' class='ah'>综合</a>&nbsp;&nbsp;<a href='rate.php?uid=<?=$uid?>&lv=<?=$lv?>&num=Down&langx=<?=$langx?>' class='ah'>自动降水设置</a></td>               
      <td class="m_tline" width="426"><a href=javascript:CheckCLOSE('rate.php?uid=<?=$uid?>&lv=<?=$lv?>&active=<?=$num?>&langx=<?=$langx?>')>更新&nbsp;<?=$Title?>&nbsp;前台赔率</a></td>
      <td width="31"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td> 
    </tr> 
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
    <tr>  
      <td width="100%" height="4"></td> 
    </tr>  
</table>
<?
if ($num=='SCA'){
?>
<table border="0" cellspacing="1" cellpadding="0" width="800">
<form name="myform" method="post" onSubmit="return CheckUPDATE();" action="" >
  <tr>
    <td width="800">
<table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
  <tr class="m_cen">
      <td width="800" height="21">
		  <table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
              <tr class="m_title">
                <td height="27" colspan="15">特码A</td>
                </tr>
              <tr class="m_title">
                <td width="36" height="27">号码</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="74" >修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="70">修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="70">修改赔率</td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n01,'01');"  style="cursor:hand;"><font color=White><b>01</b></font></td>
                <td id="n01"><font color=red><b><?=$row['N_Rates_SCA_01']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N01,'01');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_01']?>" name="N01"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n11,'11');"  style="cursor:hand;"><font color=White><b>11</b></font></td>
                <th id="n11"><font color=red><b><?=$row['N_Rates_SCA_11']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N11,'11');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_11']?>" name="N11"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n21,'21');"  style="cursor:hand;"><font color=White><b>21</b></font></td>
                <td id="n21"><font color=red><b><?=$row['N_Rates_SCA_21']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N21,'21');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_21']?>" name="N21"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n31,'31');"  style="cursor:hand;"><font color=White><b>31</b></font></td>
                <td id="n31"><font color=red><b><?=$row['N_Rates_SCA_31']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N31,'31');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_31']?>" name="N31"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n41,'41');"  style="cursor:hand;"><font color=White><b>41</b></font></td>
                <td id="n41"><font color=red><b><?=$row['N_Rates_SCA_41']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N41,'41');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_41']?>" name="N41"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n02,'02');"  style="cursor:hand;"><font color=White><b>02</b></font></td>
                <td id="n02"><font color=red><b><?=$row['N_Rates_SCA_02']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N02,'02');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_02']?>" name="N02"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n12,'12');"  style="cursor:hand;"><font color=White><b>12</b></font></td>
                <th id="n12"><font color=red><b><?=$row['N_Rates_SCA_12']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N12,'12');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_12']?>" name="N12"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n22,'22');"  style="cursor:hand;"><font color=White><b>22</b></font></td>
                <td id="n22"><font color=red><b><?=$row['N_Rates_SCA_22']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N22,'22');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_22']?>" name="N22"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n32,'32');"  style="cursor:hand;"><font color=White><b>32</b></font></td>
                <td id="n32"><font color=red><b><?=$row['N_Rates_SCA_32']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N32,'32');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_32']?>" name="N32"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n42,'42');"  style="cursor:hand;"><font color=White><b>42</b></font></td>
                <td id="n42"><font color=red><b><?=$row['N_Rates_SCA_42']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N42,'42');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_42']?>" name="N42"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n03,'03');"  style="cursor:hand;"><font color=White><b>03</b></font></td>
                <td id="n03"><font color=red><b><?=$row['N_Rates_SCA_03']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N03,'03');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_03']?>" name="N03"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n13,'13');"  style="cursor:hand;"><font color=White><b>13</b></font></td>
                <th id="n13"><font color=red><b><?=$row['N_Rates_SCA_13']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N13,'13');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_13']?>" name="N13"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n23,'23');"  style="cursor:hand;"><font color=White><b>23</b></font></td>
                <td id="n23"><font color=red><b><?=$row['N_Rates_SCA_23']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N23,'23');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_23']?>" name="N23"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n33,'33');"  style="cursor:hand;"><font color=White><b>33</b></font></td>
                <td id="n33"><font color=red><b><?=$row['N_Rates_SCA_33']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N33,'33');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_33']?>" name="N33"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n43,'43');"  style="cursor:hand;"><font color=White><b>43</b></font></td>
                <td id="n43"><font color=red><b><?=$row['N_Rates_SCA_43']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N43,'43');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_43']?>" name="N43"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n04,'04');"  style="cursor:hand;"><font color=White><b>04</b></font></td>
                <td id="n04"><font color=red><b><?=$row['N_Rates_SCA_04']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N04,'04');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_04']?>" name="N04"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n14,'14');"  style="cursor:hand;"><font color=White><b>14</b></font></td>
                <th id="n14"><font color=red><b><?=$row['N_Rates_SCA_14']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N14,'14');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_14']?>" name="N14"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n24,'24');"  style="cursor:hand;"><font color=White><b>24</b></font></td>
                <td id="n24"><font color=red><b><?=$row['N_Rates_SCA_24']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N24,'24');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_24']?>" name="N24"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n34,'34');"  style="cursor:hand;"><font color=White><b>34</b></font></td>
                <td id="n34"><font color=red><b><?=$row['N_Rates_SCA_34']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N34,'34');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_34']?>" name="N34"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n44,'44');"  style="cursor:hand;"><font color=White><b>44</b></font></td>
                <td id="n44"><font color=red><b><?=$row['N_Rates_SCA_44']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N44,'44');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_44']?>" name="N44"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n05,'05');"  style="cursor:hand;"><font color=White><b>05</b></font></td>
                <td id="n05"><font color=red><b><?=$row['N_Rates_SCA_05']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N05,'05');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_05']?>" name="N05"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n15,'15');"  style="cursor:hand;"><font color=White><b>15</b></font></td>
                <th id="n15"><font color=red><b><?=$row['N_Rates_SCA_15']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N15,'15');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_15']?>" name="N15"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n25,'25');"  style="cursor:hand;"><font color=White><b>25</b></font></td>
                <td id="n25"><font color=red><b><?=$row['N_Rates_SCA_25']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N25,'25');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_25']?>" name="N25"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n35,'35');"  style="cursor:hand;"><font color=White><b>35</b></font></td>
                <td id="n35"><font color=red><b><?=$row['N_Rates_SCA_35']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N35,'35');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_35']?>" name="N35"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n45,'45');"  style="cursor:hand;"><font color=White><b>45</b></font></td>
                <td id="n45"><font color=red><b><?=$row['N_Rates_SCA_45']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N45,'45');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_45']?>" name="N45"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n06,'06');"  style="cursor:hand;"><font color=White><b>06</b></font></td>
                <td id="n06"><font color=red><b><?=$row['N_Rates_SCA_06']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N06,'06');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_06']?>" name="N06"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n16,'16');"  style="cursor:hand;"><font color=White><b>16</b></font></td>
                <th id="n16"><font color=red><b><?=$row['N_Rates_SCA_16']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N16,'16');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_16']?>" name="N16"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n26,'26');"  style="cursor:hand;"><font color=White><b>26</b></font></td>
                <td id="n26"><font color=red><b><?=$row['N_Rates_SCA_26']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N26,'26');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_26']?>" name="N26"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n36,'36');"  style="cursor:hand;"><font color=White><b>36</b></font></td>
                <td id="n36"><font color=red><b><?=$row['N_Rates_SCA_36']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N36,'36');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_36']?>" name="N36"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n46,'46');"  style="cursor:hand;"><font color=White><b>46</b></font></td>
                <td id="n46"><font color=red><b><?=$row['N_Rates_SCA_46']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N46,'46');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_46']?>" name="N46"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n07,'07');"  style="cursor:hand;"><font color=White><b>07</b></font></td>
                <td id="n07"><font color=red><b><?=$row['N_Rates_SCA_07']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N07,'07');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_07']?>" name="N07"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n17,'17');"  style="cursor:hand;"><font color=White><b>17</b></font></td>
                <th id="n17"><font color=red><b><?=$row['N_Rates_SCA_17']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N17,'17');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_17']?>" name="N17"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n27,'27');"  style="cursor:hand;"><font color=White><b>27</b></font></td>
                <td id="n27"><font color=red><b><?=$row['N_Rates_SCA_27']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N27,'27');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_27']?>" name="N27"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n37,'37');"  style="cursor:hand;"><font color=White><b>37</b></font></td>
                <td id="n37"><font color=red><b><?=$row['N_Rates_SCA_37']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N37,'37');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_37']?>" name="N37"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n47,'47');"  style="cursor:hand;"><font color=White><b>47</b></font></td>
                <td id="n47"><font color=red><b><?=$row['N_Rates_SCA_47']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N47,'47');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_47']?>" name="N47"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n08,'08');"  style="cursor:hand;"><font color=White><b>08</b></font></td>
                <td id="n08"><font color=red><b><?=$row['N_Rates_SCA_08']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N08,'08');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_08']?>" name="N08"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n18,'18');"  style="cursor:hand;"><font color=White><b>18</b></font></td>
                <th id="n18"><font color=red><b><?=$row['N_Rates_SCA_18']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N18,'18');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_18']?>" name="N18"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n28,'28');"  style="cursor:hand;"><font color=White><b>28</b></font></td>
                <td id="n28"><font color=red><b><?=$row['N_Rates_SCA_28']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N28,'28');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_28']?>" name="N28"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n38,'38');"  style="cursor:hand;"><font color=White><b>38</b></font></td>
                <td id="n38"><font color=red><b><?=$row['N_Rates_SCA_38']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N38,'38');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_38']?>" name="N38"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n48,'48');"  style="cursor:hand;"><font color=White><b>48</b></font></td>
                <td id="n48"><font color=red><b><?=$row['N_Rates_SCA_48']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N48,'48');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_48']?>" name="N48"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n09,'09');"  style="cursor:hand;"><font color=White><b>09</b></font></td>
                <td id="n09"><font color=red><b><?=$row['N_Rates_SCA_09']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N09,'09');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_09']?>" name="N09"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n19,'19');"  style="cursor:hand;"><font color=White><b>19</b></font></td>
                <th id="n19"><font color=red><b><?=$row['N_Rates_SCA_19']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N19,'19');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_19']?>" name="N19"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n29,'29');"  style="cursor:hand;"><font color=White><b>29</b></font></td>
                <td id="n29"><font color=red><b><?=$row['N_Rates_SCA_29']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N29,'29');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_29']?>" name="N29"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n39,'39');"  style="cursor:hand;"><font color=White><b>39</b></font></td>
                <td id="n39"><font color=red><b><?=$row['N_Rates_SCA_39']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N39,'39');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_39']?>" name="N39"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n49,'49');"  style="cursor:hand;"><font color=White><b>49</b></font></td>
                <td id="n49"><font color=red><b><?=$row['N_Rates_SCA_49']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N49,'49');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_49']?>" name="N49"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n10,'10');"  style="cursor:hand;"><font color=White><b>10</b></font></td>
                <td id="n10"><font color=red><b><?=$row['N_Rates_SCA_10']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N10,'10');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_10']?>" name="N10"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n20,'20');"  style="cursor:hand;"><font color=White><b>20</b></font></td>
                <th id="n20"><font color=red><b><?=$row['N_Rates_SCA_20']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N20,'20');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_20']?>" name="N20"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n30,'30');"  style="cursor:hand;"><font color=White><b>30</b></font></td>
                <td id="n30"><font color=red><b><?=$row['N_Rates_SCA_30']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N30,'30');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_30']?>" name="N30"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n40,'40');"  style="cursor:hand;"><font color=White><b>40</b></font></td>
                <td id="n40"><font color=red><b><?=$row['N_Rates_SCA_40']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N40,'40');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_40']?>" name="N40"></td>
                <td background="/images/agents/top/red.jpg"><font color=White><b>红</b></font></td>
                <td><font color=red><b><?=$row['N_Rates_SCA_Red']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_Red']?>" name="Red"></td>
              </tr>			  			  
              <tr class="m_cen">
                <td onClick="sel(this.style.background,NAOdd,'AOdd');"  style="cursor:hand;">特单</td>
                <td id="NAOdd"><font color=red><b><?=$row['N_Rates_SCA_AOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_AOdd']?>" name="AOdd"></td>
                <td onClick="sel(this.style.background,NAEven,'AEven');"  style="cursor:hand;">特双</td>
                <th id="NAEven"><font color=red><b><?=$row['N_Rates_SCA_AEven']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_AEven']?>" name="AEven"></td>
                <td onClick="sel(this.style.background,NAOver,'AOver');"  style="cursor:hand;">特大</td>
                <td id="NAOver"><font color=red><b><?=$row['N_Rates_SCA_AOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_AOver']?>" name="AOver"></td>
                <td onClick="sel(this.style.background,NAUnder,'AUnder');"  style="cursor:hand;">特小</td>
                <td id="NAUnder"><font color=red><b><?=$row['N_Rates_SCA_AUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_AUnder']?>" name="AUnder"></td>
                <td background="/images/agents/top/blue.jpg"><font color=White><b>蓝</b></font></td>
                <td><font color=red><b><?=$row['N_Rates_SCA_Blue']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_Blue']?>" name="Blue"></td>
              </tr>
              <tr class="m_cen">
                <td onClick="sel(this.style.background,NBOdd,'BOdd');"  style="cursor:hand;">合单</td>
                <td id="NBOdd"><font color=red><b><?=$row['N_Rates_SCA_BOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_BOdd']?>" name="BOdd"></td>
                <td onClick="sel(this.style.background,NBEven,'BEven');"  style="cursor:hand;">合双</td>
                <th id="NBEven"><font color=red><b><?=$row['N_Rates_SCA_BEven']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_BEven']?>" name="BEven"></td>
                <td onClick="sel(this.style.background,NBOver,'BOver');"  style="cursor:hand;">合大</td>
                <td id="NBOver"><font color=red><b><?=$row['N_Rates_SCA_BOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_BOver']?>" name="BOver"></td>
                <td onClick="sel(this.style.background,NBUnder,'BUnder');"  style="cursor:hand;">合小</td>
                <td id="NBUnder"><font color=red><b><?=$row['N_Rates_SCA_BUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_BUnder']?>" name="BUnder"></td>
                <td background="/images/agents/top/green.jpg"><font color=White><b>绿</b></font></td>
                <td><font color=red><b><?=$row['N_Rates_SCA_Green']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCA_Green']?>" name="Green"></td>
              </tr>  			  
          </table>
		  </td>
      </tr>
   <tr class="m_cen">
       <td width="800" height="21">
		  <table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
              <tr class="m_cen">
                  <td width="85" rowspan="2">请选择:</td>
                  <th width="272" rowspan="2"><a href="#" class="ags" onClick="red();">红</a> <a href="#" class="ags" onClick="green();">绿</a> <a href="#" class="ags" onClick="blue();">蓝</a> <a href="#" class="ags" onClick="single();">单</a> <a href="#" class="ags" onClick="double();">双</a> <a href="#" class="ags" onClick="maxs();">大</a> <a href="#" class="ags" onClick="mins();">小</a> <a href="#" class="ags" onClick="addsingle();">合单</a> <a href="#" class="ags" onClick="adddouble();">合双</a> <a href="#" class="ags" onClick="animal()">家禽</a> <a href="#" class="ags" onClick="fowl();">野兽</a><br>
                  头: <a href="#" class="ags" onClick="for0();">0</a> <a href="#" class="ags" onClick="for1();">1</a> <a href="#" class="ags" onClick="for2();">2</a> <a href="#" class="ags" onClick="for3();">3</a> <a href="#" class="ags" onClick="for4();">4</a>
                  <input name="check" type="hidden" id="checks2">
                  <input name="tnumber" type="hidden" id="tnumber" value="a">
				  尾: <a href="#" class="ags" onClick="end0();">0</a> <a href="#" class="ags" onClick="end1();">1</a> <a href="#" class="ags" onClick="end2();">2</a> <a href="#" class="ags" onClick="end3();">3</a> <a href="#" class="ags" onClick="end4();">4</a> <a href="#" class="ags" onClick="end5();">5</a> <a href="#" class="ags" onClick="end6();">6</a> <a href="#" class="ags" onClick="end7();">7</a> <a href="#" class="ags" onClick="end8();">8</a> <a href="#" class="ags" onClick="end9();">9</a></th>
                  <td colspan="2" ><a href="#" class="ags style8 style1" onClick="cancel(2);">特码全选</a></td>
                </tr>
                <tr class="m_cen">
                  <td width="210">赔率：
                  <input name="txtrmb" type="text" class="input" maxlength="4" id="txtrmb" size="2" ONKEYPRESS="event.returnValue=Isnum();"><input name="Submit" type="button" class="za_button" value="转送" onClick="re();"></td>
                  <td width="228"><input name="Submit" type="submit" class="za_button" value="确定">&nbsp;&nbsp;<input name="Submit22" type="reset" class="za_button" value="取消" onClick="cancel('1');"></td>
				  <input type=hidden value="SCA" name=type>
                </tr>
            </table>
		</td>
  </tr>
</table>
	</td>
  </tr>
</form>
</table>
<?
}else if ($num=='SCB'){
?>
<table border="0" cellspacing="1" cellpadding="0" width="800">
<form name="myform" method="post" onSubmit="return CheckUPDATE();" action="" >
  <tr>
    <td width="800">
<table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
  <tr class="m_cen">
      <td width="800" height="21">
		  <table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
              <tr class="m_title">
                <td height="27" colspan="15">特码B</td>
                </tr>
              <tr class="m_title">
                <td width="36" height="27">号码</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="74" >修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="70">修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n01,'01');"  style="cursor:hand;"><font color=White><b>01</b></font></td>
                <td id="n01"><font color=red><b><?=$row['N_Rates_SCB_01']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N01,'01');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_01']?>" name="N01"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n11,'11');"  style="cursor:hand;"><font color=White><b>11</b></font></td>
                <th id="n11"><font color=red><b><?=$row['N_Rates_SCB_11']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N11,'11');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_11']?>" name="N11"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n21,'21');"  style="cursor:hand;"><font color=White><b>21</b></font></td>
                <td id="n21"><font color=red><b><?=$row['N_Rates_SCB_21']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N21,'21');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_21']?>" name="N21"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n31,'31');"  style="cursor:hand;"><font color=White><b>31</b></font></td>
                <td id="n31"><font color=red><b><?=$row['N_Rates_SCB_31']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N31,'31');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_31']?>" name="N31"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n41,'41');"  style="cursor:hand;"><font color=White><b>41</b></font></td>
                <td id="n41"><font color=red><b><?=$row['N_Rates_SCB_41']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N41,'41');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_41']?>" name="N41"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n02,'02');"  style="cursor:hand;"><font color=White><b>02</b></font></td>
                <td id="n02"><font color=red><b><?=$row['N_Rates_SCB_02']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N02,'02');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_02']?>" name="N02"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n12,'12');"  style="cursor:hand;"><font color=White><b>12</b></font></td>
                <th id="n12"><font color=red><b><?=$row['N_Rates_SCB_12']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N12,'12');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_12']?>" name="N12"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n22,'22');"  style="cursor:hand;"><font color=White><b>22</b></font></td>
                <td id="n22"><font color=red><b><?=$row['N_Rates_SCB_22']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N22,'22');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_22']?>" name="N22"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n32,'32');"  style="cursor:hand;"><font color=White><b>32</b></font></td>
                <td id="n32"><font color=red><b><?=$row['N_Rates_SCB_32']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N32,'32');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_32']?>" name="N32"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n42,'42');"  style="cursor:hand;"><font color=White><b>42</b></font></td>
                <td id="n42"><font color=red><b><?=$row['N_Rates_SCB_42']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N42,'42');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_42']?>" name="N42"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n03,'03');"  style="cursor:hand;"><font color=White><b>03</b></font></td>
                <td id="n03"><font color=red><b><?=$row['N_Rates_SCB_03']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N03,'03');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_03']?>" name="N03"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n13,'13');"  style="cursor:hand;"><font color=White><b>13</b></font></td>
                <th id="n13"><font color=red><b><?=$row['N_Rates_SCB_13']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N13,'13');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_13']?>" name="N13"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n23,'23');"  style="cursor:hand;"><font color=White><b>23</b></font></td>
                <td id="n23"><font color=red><b><?=$row['N_Rates_SCB_23']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N23,'23');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_23']?>" name="N23"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n33,'33');"  style="cursor:hand;"><font color=White><b>33</b></font></td>
                <td id="n33"><font color=red><b><?=$row['N_Rates_SCB_33']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N33,'33');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_33']?>" name="N33"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n43,'43');"  style="cursor:hand;"><font color=White><b>43</b></font></td>
                <td id="n43"><font color=red><b><?=$row['N_Rates_SCB_43']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N43,'43');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_43']?>" name="N43"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n04,'04');"  style="cursor:hand;"><font color=White><b>04</b></font></td>
                <td id="n04"><font color=red><b><?=$row['N_Rates_SCB_04']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N04,'04');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_04']?>" name="N04"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n14,'14');"  style="cursor:hand;"><font color=White><b>14</b></font></td>
                <th id="n14"><font color=red><b><?=$row['N_Rates_SCB_14']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N14,'14');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_14']?>" name="N14"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n24,'24');"  style="cursor:hand;"><font color=White><b>24</b></font></td>
                <td id="n24"><font color=red><b><?=$row['N_Rates_SCB_24']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N24,'24');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_24']?>" name="N24"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n34,'34');"  style="cursor:hand;"><font color=White><b>34</b></font></td>
                <td id="n34"><font color=red><b><?=$row['N_Rates_SCB_34']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N34,'34');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_34']?>" name="N34"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n44,'44');"  style="cursor:hand;"><font color=White><b>44</b></font></td>
                <td id="n44"><font color=red><b><?=$row['N_Rates_SCB_44']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N44,'44');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_44']?>" name="N44"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n05,'05');"  style="cursor:hand;"><font color=White><b>05</b></font></td>
                <td id="n05"><font color=red><b><?=$row['N_Rates_SCB_05']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N05,'05');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_05']?>" name="N05"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n15,'15');"  style="cursor:hand;"><font color=White><b>15</b></font></td>
                <th id="n15"><font color=red><b><?=$row['N_Rates_SCB_15']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N15,'15');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_15']?>" name="N15"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n25,'25');"  style="cursor:hand;"><font color=White><b>25</b></font></td>
                <td id="n25"><font color=red><b><?=$row['N_Rates_SCB_25']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N25,'25');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_25']?>" name="N25"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n35,'35');"  style="cursor:hand;"><font color=White><b>35</b></font></td>
                <td id="n35"><font color=red><b><?=$row['N_Rates_SCB_35']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N35,'35');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_35']?>" name="N35"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n45,'45');"  style="cursor:hand;"><font color=White><b>45</b></font></td>
                <td id="n45"><font color=red><b><?=$row['N_Rates_SCB_45']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N45,'45');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_45']?>" name="N45"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n06,'06');"  style="cursor:hand;"><font color=White><b>06</b></font></td>
                <td id="n06"><font color=red><b><?=$row['N_Rates_SCB_06']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N06,'06');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_06']?>" name="N06"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n16,'16');"  style="cursor:hand;"><font color=White><b>16</b></font></td>
                <th id="n16"><font color=red><b><?=$row['N_Rates_SCB_16']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N16,'16');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_16']?>" name="N16"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n26,'26');"  style="cursor:hand;"><font color=White><b>26</b></font></td>
                <td id="n26"><font color=red><b><?=$row['N_Rates_SCB_26']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N26,'26');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_26']?>" name="N26"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n36,'36');"  style="cursor:hand;"><font color=White><b>36</b></font></td>
                <td id="n36"><font color=red><b><?=$row['N_Rates_SCB_36']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N36,'36');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_36']?>" name="N36"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n46,'46');"  style="cursor:hand;"><font color=White><b>46</b></font></td>
                <td id="n46"><font color=red><b><?=$row['N_Rates_SCB_46']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N46,'46');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_46']?>" name="N46"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n07,'07');"  style="cursor:hand;"><font color=White><b>07</b></font></td>
                <td id="n07"><font color=red><b><?=$row['N_Rates_SCB_07']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N07,'07');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_07']?>" name="N07"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n17,'17');"  style="cursor:hand;"><font color=White><b>17</b></font></td>
                <th id="n17"><font color=red><b><?=$row['N_Rates_SCB_17']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N17,'17');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_17']?>" name="N17"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n27,'27');"  style="cursor:hand;"><font color=White><b>27</b></font></td>
                <td id="n27"><font color=red><b><?=$row['N_Rates_SCB_27']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N27,'27');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_27']?>" name="N27"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n37,'37');"  style="cursor:hand;"><font color=White><b>37</b></font></td>
                <td id="n37"><font color=red><b><?=$row['N_Rates_SCB_37']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N37,'37');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_37']?>" name="N37"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n47,'47');"  style="cursor:hand;"><font color=White><b>47</b></font></td>
                <td id="n47"><font color=red><b><?=$row['N_Rates_SCB_47']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N47,'47');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_47']?>" name="N47"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n08,'08');"  style="cursor:hand;"><font color=White><b>08</b></font></td>
                <td id="n08"><font color=red><b><?=$row['N_Rates_SCB_08']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N08,'08');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_08']?>" name="N08"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n18,'18');"  style="cursor:hand;"><font color=White><b>18</b></font></td>
                <th id="n18"><font color=red><b><?=$row['N_Rates_SCB_18']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N18,'18');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_18']?>" name="N18"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n28,'28');"  style="cursor:hand;"><font color=White><b>28</b></font></td>
                <td id="n28"><font color=red><b><?=$row['N_Rates_SCB_28']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N28,'28');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_28']?>" name="N28"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n38,'38');"  style="cursor:hand;"><font color=White><b>38</b></font></td>
                <td id="n38"><font color=red><b><?=$row['N_Rates_SCB_38']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N38,'38');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_38']?>" name="N38"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n48,'48');"  style="cursor:hand;"><font color=White><b>48</b></font></td>
                <td id="n48"><font color=red><b><?=$row['N_Rates_SCB_48']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N48,'48');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_48']?>" name="N48"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n09,'09');"  style="cursor:hand;"><font color=White><b>09</b></font></td>
                <td id="n09"><font color=red><b><?=$row['N_Rates_SCB_09']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N09,'09');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_09']?>" name="N09"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n19,'19');"  style="cursor:hand;"><font color=White><b>19</b></font></td>
                <th id="n19"><font color=red><b><?=$row['N_Rates_SCB_19']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N19,'19');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_19']?>" name="N19"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n29,'29');"  style="cursor:hand;"><font color=White><b>29</b></font></td>
                <td id="n29"><font color=red><b><?=$row['N_Rates_SCB_29']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N29,'29');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_29']?>" name="N29"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n39,'39');"  style="cursor:hand;"><font color=White><b>39</b></font></td>
                <td id="n39"><font color=red><b><?=$row['N_Rates_SCB_39']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N39,'39');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_39']?>" name="N39"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n49,'49');"  style="cursor:hand;"><font color=White><b>49</b></font></td>
                <td id="n49"><font color=red><b><?=$row['N_Rates_SCB_49']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N49,'49');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_49']?>" name="N49"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n10,'10');"  style="cursor:hand;"><font color=White><b>10</b></font></td>
                <td id="n10"><font color=red><b><?=$row['N_Rates_SCB_10']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N10,'10');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_10']?>" name="N10"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n20,'20');"  style="cursor:hand;"><font color=White><b>20</b></font></td>
                <th id="n20"><font color=red><b><?=$row['N_Rates_SCB_20']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N20,'20');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_20']?>" name="N20"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n30,'30');"  style="cursor:hand;"><font color=White><b>30</b></font></td>
                <td id="n30"><font color=red><b><?=$row['N_Rates_SCB_30']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N30,'30');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_30']?>" name="N30"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n40,'40');"  style="cursor:hand;"><font color=White><b>40</b></font></td>
                <td id="n40"><font color=red><b><?=$row['N_Rates_SCB_40']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N40,'40');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_SCB_40']?>" name="N40"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>  			  
          </table>
		  </td>
      </tr>
   <tr class="m_cen">
       <td width="800" height="21">
		  <table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
              <tr class="m_cen">
                  <td width="85" rowspan="2">请选择:</td>
                  <th width="272" rowspan="2"><a href="#" class="ags" onClick="red();">红</a> <a href="#" class="ags" onClick="green();">绿</a> <a href="#" class="ags" onClick="blue();">蓝</a> <a href="#" class="ags" onClick="single();">单</a> <a href="#" class="ags" onClick="double();">双</a> <a href="#" class="ags" onClick="maxs();">大</a> <a href="#" class="ags" onClick="mins();">小</a> <a href="#" class="ags" onClick="addsingle();">合单</a> <a href="#" class="ags" onClick="adddouble();">合双</a> <a href="#" class="ags" onClick="animal()">家禽</a> <a href="#" class="ags" onClick="fowl();">野兽</a><br>
                  头: <a href="#" class="ags" onClick="for0();">0</a> <a href="#" class="ags" onClick="for1();">1</a> <a href="#" class="ags" onClick="for2();">2</a> <a href="#" class="ags" onClick="for3();">3</a> <a href="#" class="ags" onClick="for4();">4</a>
                  <input name="check" type="hidden" id="checks2">
                  <input name="tnumber" type="hidden" id="tnumber" value="a">
				  尾: <a href="#" class="ags" onClick="end0();">0</a> <a href="#" class="ags" onClick="end1();">1</a> <a href="#" class="ags" onClick="end2();">2</a> <a href="#" class="ags" onClick="end3();">3</a> <a href="#" class="ags" onClick="end4();">4</a> <a href="#" class="ags" onClick="end5();">5</a> <a href="#" class="ags" onClick="end6();">6</a> <a href="#" class="ags" onClick="end7();">7</a> <a href="#" class="ags" onClick="end8();">8</a> <a href="#" class="ags" onClick="end9();">9</a></th>
                  <td colspan="2" ><a href="#" class="ags style8 style1" onClick="cancel(2);">特码全选</a></td>
                </tr>
                <tr class="m_cen">
                  <td width="210">赔率：
                  <input name="txtrmb" type="text" class="input" maxlength="4" id="txtrmb" size="2" ONKEYPRESS="event.returnValue=Isnum();"><input name="Submit" type="button" class="za_button" value="转送" onClick="re();"></td>
                  <td width="228"><input name="Submit" type="submit" class="za_button" value="确定">&nbsp;&nbsp;<input name="Submit22" type="reset" class="za_button" value="取消" onClick="cancel('1');"></td>
				  <input type=hidden value="SCB" name=type>
                </tr>
            </table>
		</td>
  </tr>
</table>
	</td>
  </tr>
</form>
</table>
<?
}else if ($num=='AC'){
?>
<table border="0" cellspacing="1" cellpadding="0" width="800">
<form name="myform" method="post" onSubmit="return CheckUPDATE();" action="" >
  <tr>
    <td width="800">
<table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
  <tr class="m_cen">
      <td width="800" height="21">
		  <table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
              <tr class="m_title">
                <td height="27" colspan="15">正码</td>
                </tr>
              <tr class="m_title">
                <td width="36" height="27">号码</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="74" >修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="70">修改赔率</td>
                <td width="36">号码</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n01,'01');"  style="cursor:hand;"><font color=White><b>01</b></font></td>
                <td id="n01"><font color=red><b><?=$row['N_Rates_AC_01']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N01,'01');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_01']?>" name="N01"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n11,'11');"  style="cursor:hand;"><font color=White><b>11</b></font></td>
                <th id="n11"><font color=red><b><?=$row['N_Rates_AC_11']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N11,'11');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_11']?>" name="N11"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n21,'21');"  style="cursor:hand;"><font color=White><b>21</b></font></td>
                <td id="n21"><font color=red><b><?=$row['N_Rates_AC_21']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N21,'21');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_21']?>" name="N21"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n31,'31');"  style="cursor:hand;"><font color=White><b>31</b></font></td>
                <td id="n31"><font color=red><b><?=$row['N_Rates_AC_31']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N31,'31');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_31']?>" name="N31"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n41,'41');"  style="cursor:hand;"><font color=White><b>41</b></font></td>
                <td id="n41"><font color=red><b><?=$row['N_Rates_AC_41']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N41,'41');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_41']?>" name="N41"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n02,'02');"  style="cursor:hand;"><font color=White><b>02</b></font></td>
                <td id="n02"><font color=red><b><?=$row['N_Rates_AC_02']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N02,'02');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_02']?>" name="N02"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n12,'12');"  style="cursor:hand;"><font color=White><b>12</b></font></td>
                <th id="n12"><font color=red><b><?=$row['N_Rates_AC_12']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N12,'12');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_12']?>" name="N12"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n22,'22');"  style="cursor:hand;"><font color=White><b>22</b></font></td>
                <td id="n22"><font color=red><b><?=$row['N_Rates_AC_22']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N22,'22');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_22']?>" name="N22"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n32,'32');"  style="cursor:hand;"><font color=White><b>32</b></font></td>
                <td id="n32"><font color=red><b><?=$row['N_Rates_AC_32']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N32,'32');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_32']?>" name="N32"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n42,'42');"  style="cursor:hand;"><font color=White><b>42</b></font></td>
                <td id="n42"><font color=red><b><?=$row['N_Rates_AC_42']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N42,'42');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_42']?>" name="N42"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n03,'03');"  style="cursor:hand;"><font color=White><b>03</b></font></td>
                <td id="n03"><font color=red><b><?=$row['N_Rates_AC_03']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N03,'03');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_03']?>" name="N03"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n13,'13');"  style="cursor:hand;"><font color=White><b>13</b></font></td>
                <th id="n13"><font color=red><b><?=$row['N_Rates_AC_13']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N13,'13');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_13']?>" name="N13"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n23,'23');"  style="cursor:hand;"><font color=White><b>23</b></font></td>
                <td id="n23"><font color=red><b><?=$row['N_Rates_AC_23']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N23,'23');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_23']?>" name="N23"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n33,'33');"  style="cursor:hand;"><font color=White><b>33</b></font></td>
                <td id="n33"><font color=red><b><?=$row['N_Rates_AC_33']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N33,'33');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_33']?>" name="N33"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n43,'43');"  style="cursor:hand;"><font color=White><b>43</b></font></td>
                <td id="n43"><font color=red><b><?=$row['N_Rates_AC_43']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N43,'43');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_43']?>" name="N43"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n04,'04');"  style="cursor:hand;"><font color=White><b>04</b></font></td>
                <td id="n04"><font color=red><b><?=$row['N_Rates_AC_04']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N04,'04');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_04']?>" name="N04"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n14,'14');"  style="cursor:hand;"><font color=White><b>14</b></font></td>
                <th id="n14"><font color=red><b><?=$row['N_Rates_AC_14']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N14,'14');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_14']?>" name="N14"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n24,'24');"  style="cursor:hand;"><font color=White><b>24</b></font></td>
                <td id="n24"><font color=red><b><?=$row['N_Rates_AC_24']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N24,'24');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_24']?>" name="N24"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n34,'34');"  style="cursor:hand;"><font color=White><b>34</b></font></td>
                <td id="n34"><font color=red><b><?=$row['N_Rates_AC_34']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N34,'34');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_34']?>" name="N34"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n44,'44');"  style="cursor:hand;"><font color=White><b>44</b></font></td>
                <td id="n44"><font color=red><b><?=$row['N_Rates_AC_44']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N44,'44');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_44']?>" name="N44"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n05,'05');"  style="cursor:hand;"><font color=White><b>05</b></font></td>
                <td id="n05"><font color=red><b><?=$row['N_Rates_AC_05']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N05,'05');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_05']?>" name="N05"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n15,'15');"  style="cursor:hand;"><font color=White><b>15</b></font></td>
                <th id="n15"><font color=red><b><?=$row['N_Rates_AC_15']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N15,'15');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_15']?>" name="N15"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n25,'25');"  style="cursor:hand;"><font color=White><b>25</b></font></td>
                <td id="n25"><font color=red><b><?=$row['N_Rates_AC_25']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N25,'25');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_25']?>" name="N25"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n35,'35');"  style="cursor:hand;"><font color=White><b>35</b></font></td>
                <td id="n35"><font color=red><b><?=$row['N_Rates_AC_35']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N35,'35');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_35']?>" name="N35"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n45,'45');"  style="cursor:hand;"><font color=White><b>45</b></font></td>
                <td id="n45"><font color=red><b><?=$row['N_Rates_AC_45']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N45,'45');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_45']?>" name="N45"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n06,'06');"  style="cursor:hand;"><font color=White><b>06</b></font></td>
                <td id="n06"><font color=red><b><?=$row['N_Rates_AC_06']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N06,'06');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_06']?>" name="N06"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n16,'16');"  style="cursor:hand;"><font color=White><b>16</b></font></td>
                <th id="n16"><font color=red><b><?=$row['N_Rates_AC_16']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N16,'16');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_16']?>" name="N16"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n26,'26');"  style="cursor:hand;"><font color=White><b>26</b></font></td>
                <td id="n26"><font color=red><b><?=$row['N_Rates_AC_26']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N26,'26');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_26']?>" name="N26"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n36,'36');"  style="cursor:hand;"><font color=White><b>36</b></font></td>
                <td id="n36"><font color=red><b><?=$row['N_Rates_AC_36']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N36,'36');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_36']?>" name="N36"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n46,'46');"  style="cursor:hand;"><font color=White><b>46</b></font></td>
                <td id="n46"><font color=red><b><?=$row['N_Rates_AC_46']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N46,'46');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_46']?>" name="N46"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n07,'07');"  style="cursor:hand;"><font color=White><b>07</b></font></td>
                <td id="n07"><font color=red><b><?=$row['N_Rates_AC_07']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N07,'07');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_07']?>" name="N07"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n17,'17');"  style="cursor:hand;"><font color=White><b>17</b></font></td>
                <th id="n17"><font color=red><b><?=$row['N_Rates_AC_17']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N17,'17');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_17']?>" name="N17"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n27,'27');"  style="cursor:hand;"><font color=White><b>27</b></font></td>
                <td id="n27"><font color=red><b><?=$row['N_Rates_AC_27']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N27,'27');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_27']?>" name="N27"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n37,'37');"  style="cursor:hand;"><font color=White><b>37</b></font></td>
                <td id="n37"><font color=red><b><?=$row['N_Rates_AC_37']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N37,'37');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_37']?>" name="N37"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n47,'47');"  style="cursor:hand;"><font color=White><b>47</b></font></td>
                <td id="n47"><font color=red><b><?=$row['N_Rates_AC_47']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N47,'47');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_47']?>" name="N47"></td>
              </tr>
              <tr class="m_cen">
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n08,'08');"  style="cursor:hand;"><font color=White><b>08</b></font></td>
                <td id="n08"><font color=red><b><?=$row['N_Rates_AC_08']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N08,'08');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_08']?>" name="N08"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n18,'18');"  style="cursor:hand;"><font color=White><b>18</b></font></td>
                <th id="n18"><font color=red><b><?=$row['N_Rates_AC_18']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N18,'18');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_18']?>" name="N18"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n28,'28');"  style="cursor:hand;"><font color=White><b>28</b></font></td>
                <td id="n28"><font color=red><b><?=$row['N_Rates_AC_28']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N28,'28');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_28']?>" name="N28"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n38,'38');"  style="cursor:hand;"><font color=White><b>38</b></font></td>
                <td id="n38"><font color=red><b><?=$row['N_Rates_AC_38']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N38,'38');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_38']?>" name="N38"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n48,'48');"  style="cursor:hand;"><font color=White><b>48</b></font></td>
                <td id="n48"><font color=red><b><?=$row['N_Rates_AC_48']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N48,'48');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_48']?>" name="N48"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n09,'09');"  style="cursor:hand;"><font color=White><b>09</b></font></td>
                <td id="n09"><font color=red><b><?=$row['N_Rates_AC_09']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N09,'09');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_09']?>" name="N09"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n19,'19');"  style="cursor:hand;"><font color=White><b>19</b></font></td>
                <th id="n19"><font color=red><b><?=$row['N_Rates_AC_19']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N19,'19');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_19']?>" name="N19"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n29,'29');"  style="cursor:hand;"><font color=White><b>29</b></font></td>
                <td id="n29"><font color=red><b><?=$row['N_Rates_AC_29']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N29,'29');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_29']?>" name="N29"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n39,'39');"  style="cursor:hand;"><font color=White><b>39</b></font></td>
                <td id="n39"><font color=red><b><?=$row['N_Rates_AC_39']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N39,'39');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_39']?>" name="N39"></td>
                <td background="/images/agents/top/green.jpg" onClick="sel(this.style.background,n49,'49');"  style="cursor:hand;"><font color=White><b>49</b></font></td>
                <td id="n49"><font color=red><b><?=$row['N_Rates_AC_49']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N49,'49');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_49']?>" name="N49"></td>
              </tr>			  
              <tr class="m_cen">
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n10,'10');"  style="cursor:hand;"><font color=White><b>10</b></font></td>
                <td id="n10"><font color=red><b><?=$row['N_Rates_AC_10']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N10,'10');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_10']?>" name="N10"></td>
                <td background="/images/agents/top/blue.jpg" onClick="sel(this.style.background,n20,'20');"  style="cursor:hand;"><font color=White><b>20</b></font></td>
                <th id="n20"><font color=red><b><?=$row['N_Rates_AC_20']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N20,'20');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_20']?>" name="N20"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n30,'30');"  style="cursor:hand;"><font color=White><b>30</b></font></td>
                <td id="n30"><font color=red><b><?=$row['N_Rates_AC_30']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N30,'30');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_30']?>" name="N30"></td>
                <td background="/images/agents/top/red.jpg" onClick="sel(this.style.background,n40,'40');"  style="cursor:hand;"><font color=White><b>40</b></font></td>
                <td id="n40"><font color=red><b><?=$row['N_Rates_AC_40']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N40,'40');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_40']?>" name="N40"></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr class="m_cen">
                <td onClick="sel(this.style.background,NTOdd,'TOdd');"  style="cursor:hand;">总单</td>
                <td id="NTOdd"><font color=red><b><?=$row['N_Rates_AC_TOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N10,'10');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_TOdd']?>" name="TOdd"></td>
                <td onClick="sel(this.style.background,NTEven,'TEven');"  style="cursor:hand;">总双</td>
                <th id="NTEven"><font color=red><b><?=$row['N_Rates_AC_TEven']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N10,'10');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_TEven']?>" name="TEven"></td>
                <td onClick="sel(this.style.background,NTOver,'TOver');"  style="cursor:hand;">总大</td>
                <td id="NTOver"><font color=red><b><?=$row['N_Rates_AC_TOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N10,'10');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_TOver']?>" name="TOver"></td>
                <td onClick="sel(this.style.background,NTUnder,'TUnder');"  style="cursor:hand;">总小</td>
                <td id="NTUnder"><font color=red><b><?=$row['N_Rates_AC_TUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onBlur="txt(N10,'10');" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC_TUnder']?>" name="TUnder"></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>  			  
          </table>
		  </td>
      </tr>
   <tr class="m_cen">
       <td width="800" height="21">
		  <table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
              <tr class="m_cen">
                  <td width="85" rowspan="2">请选择:</td>
                  <th width="272" rowspan="2"><a href="#" class="ags" onClick="red();">红</a> <a href="#" class="ags" onClick="green();">绿</a> <a href="#" class="ags" onClick="blue();">蓝</a> <a href="#" class="ags" onClick="single();">单</a> <a href="#" class="ags" onClick="double();">双</a> <a href="#" class="ags" onClick="maxs();">大</a> <a href="#" class="ags" onClick="mins();">小</a> <a href="#" class="ags" onClick="addsingle();">合单</a> <a href="#" class="ags" onClick="adddouble();">合双</a> <a href="#" class="ags" onClick="animal()">家禽</a> <a href="#" class="ags" onClick="fowl();">野兽</a><br>
                  头: <a href="#" class="ags" onClick="for0();">0</a> <a href="#" class="ags" onClick="for1();">1</a> <a href="#" class="ags" onClick="for2();">2</a> <a href="#" class="ags" onClick="for3();">3</a> <a href="#" class="ags" onClick="for4();">4</a>
                  <input name="check" type="hidden" id="checks2">
                  <input name="tnumber" type="hidden" id="tnumber" value="a">
				  尾: <a href="#" class="ags" onClick="end0();">0</a> <a href="#" class="ags" onClick="end1();">1</a> <a href="#" class="ags" onClick="end2();">2</a> <a href="#" class="ags" onClick="end3();">3</a> <a href="#" class="ags" onClick="end4();">4</a> <a href="#" class="ags" onClick="end5();">5</a> <a href="#" class="ags" onClick="end6();">6</a> <a href="#" class="ags" onClick="end7();">7</a> <a href="#" class="ags" onClick="end8();">8</a> <a href="#" class="ags" onClick="end9();">9</a></th>
                  <td colspan="2" ><a href="#" class="ags style8 style1" onClick="cancel(2);">正码全选</a></td>
                </tr>
                <tr class="m_cen">
                  <td width="210">赔率：
                  <input name="txtrmb" type="text" class="input" maxlength="4" id="txtrmb" size="2" ONKEYPRESS="event.returnValue=Isnum();"><input name="Submit" type="button" class="za_button" value="转送" onClick="re();"></td>
                  <td width="228"><input name="Submit" type="submit" class="za_button" value="确定">&nbsp;&nbsp;<input name="Submit22" type="reset" class="za_button" value="取消" onClick="cancel('1');"></td>
				  <input type=hidden value="AC" name=type>
                </tr>
            </table>
		</td>
  </tr>
</table>
	</td>
  </tr>
</form>
</table>
<?
}else if ($num=='AC6'){
?>
<table border="0" cellspacing="1" cellpadding="0" width="800">
<form name="myform" method="post" onSubmit="return CheckUPDATE();" action="" >
  <tr>
    <td width="800">
<table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
  <tr class="m_cen">
      <td width="800" height="21">
		  <table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
              <tr class="m_title">
                <td height="27" colspan="3">正码一</td>
                <td colspan="3">正码二</td>
                <td colspan="3">正码三</td>
                <td colspan="3">正码四</td>
                <td colspan="3">正码五</td>
                <td colspan="3" >正码六</td>
                </tr>
              <tr class="m_title">
                <td width="41" height="27">号码</td>
                <td width="40">赔率</td>
                <td width="50" >修改赔率</td>
                <td width="40">号码</td>
                <td width="40">赔率</td>
                <td width="50" >修改赔率</td>
                <td width="40">号码</td>
                <td width="40">赔率</td>
                <td width="50" >修改赔率</td>
                <td width="40">号码</td>
                <td width="40">赔率</td>
                <td width="50">修改赔率</td>
                <td width="40">号码</td>
                <td width="40">赔率</td>
                <td width="50" >修改赔率</td>
                <td width="40" >号码</td>
                <td width="40" >赔率</td>
                <td width="50" >修改赔率</td>
              </tr>
              <tr class="m_cen">
                <td>单</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_AOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_AOdd']?>" name="AC1_AOdd"></td>
                <td>单</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_AOdd']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_AOdd']?>" name="AC2_AOdd"></td>
                <td>单</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_AOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_AOdd']?>" name="AC3_AOdd"></td>
                <td>单</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_AOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_AOdd']?>" name="AC4_AOdd"></td>
                <td>单</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_AOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_AOdd']?>" name="AC5_AOdd"></td>
                <td>单</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_AOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_AOdd']?>" name="AC6_AOdd"></td>
              </tr>
              <tr class="m_cen">
                <td>双</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_AEven']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_AEven']?>" name="AC1_AEven"></td>
                <td>双</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_AEven']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_AEven']?>" name="AC2_AEven"></td>
                <td>双</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_AEven']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_AEven']?>" name="AC3_AEven"></td>
                <td>双</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_AEven']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_AEven']?>" name="AC4_AEven"></td>
                <td>双</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_AEven']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_AEven']?>" name="AC5_AEven"></td>
                <td>双</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_AEven']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_AEven']?>" name="AC6_AEven"></td>
              </tr>
              <tr class="m_cen">
                <td>大</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_AOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_AOver']?>" name="AC1_AOver"></td>
                <td>大</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_AOver']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_AOver']?>" name="AC2_AOver"></td>
                <td>大</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_AOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_AOver']?>" name="AC3_AOver"></td>
                <td>大</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_AOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_AOver']?>" name="AC4_AOver"></td>
                <td>大</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_AOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_AOver']?>" name="AC5_AOver"></td>
                <td>大</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_AOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_AOver']?>" name="AC6_AOver"></td>
              </tr>
              <tr class="m_cen">
                <td>小</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_AUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_AUnder']?>" name="AC1_AUnder"></td>
                <td>小</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_AUnder']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_AUnder']?>" name="AC2_AUnder"></td>
                <td>小</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_AUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_AUnder']?>" name="AC3_AUnder"></td>
                <td>小</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_AUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_AUnder']?>" name="AC4_AUnder"></td>
                <td>小</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_AUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_AUnder']?>" name="AC5_AUnder"></td>
                <td>小</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_AUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_AUnder']?>" name="AC6_AUnder"></td>
              </tr>			  
              <tr class="m_cen">
                <td>合单</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_BOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_BOdd']?>" name="AC1_BOdd"></td>
                <td>合单</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_BOdd']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_BOdd']?>" name="AC2_BOdd"></td>
                <td>合单</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_BOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_BOdd']?>" name="AC3_BOdd"></td>
                <td>合单</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_BOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_BOdd']?>" name="AC4_BOdd"></td>
                <td>合单</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_BOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_BOdd']?>" name="AC5_BOdd"></td>
                <td>合单</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_BOdd']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_BOdd']?>" name="AC6_BOdd"></td>
              </tr>			  
              <tr class="m_cen">
                <td>合双</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_BEven']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_BEven']?>" name="AC1_BEven"></td>
                <td>合双</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_BEven']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_BEven']?>" name="AC2_BEven"></td>
                <td>合双</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_BEven']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_BEven']?>" name="AC3_BEven"></td>
                <td>合双</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_BEven']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_BEven']?>" name="AC4_BEven"></td>
                <td>合双</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_BEven']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_BEven']?>" name="AC5_BEven"></td>
                <td>合双</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_BEven']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_BEven']?>" name="AC6_BEven"></td>
              </tr>
              <tr class="m_cen">
                <td>合大</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_BOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_BOver']?>" name="AC1_BOver"></td>
                <td>合大</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_BOver']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_BOver']?>" name="AC2_BOver"></td>
                <td>合大</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_BOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_BOver']?>" name="AC3_BOver"></td>
                <td>合大</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_BOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_BOver']?>" name="AC4_BOver"></td>
                <td>合大</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_BOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_BOver']?>" name="AC5_BOver"></td>
                <td>合大</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_BOver']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_BOver']?>" name="AC6_BOver"></td>
              </tr>
              <tr class="m_cen">
                <td>合小</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_BUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_BUnder']?>" name="AC1_BUnder"></td>
                <td>合小</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_BUnder']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_BUnder']?>" name="AC2_BUnder"></td>
                <td>合小</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_BUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_BUnder']?>" name="AC3_BUnder"></td>
                <td>合小</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_BUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_BUnder']?>" name="AC4_BUnder"></td>
                <td>合小</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_BUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_BUnder']?>" name="AC5_BUnder"></td>
                <td>合小</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_BUnder']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_BUnder']?>" name="AC6_BUnder"></td>
              </tr>			  
              <tr class="m_cen">
                <td>红波</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_Red']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_Red']?>" name="AC1_Red"></td>
                <td>红波</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_Red']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_Red']?>" name="AC2_Red"></td>
                <td>红波</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_Red']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_Red']?>" name="AC3_Red"></td>
                <td>红波</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_Red']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_Red']?>" name="AC4_Red"></td>
                <td>红波</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_Red']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_Red']?>" name="AC5_Red"></td>
                <td>红波</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_Red']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_Red']?>" name="AC6_Red"></td>
              </tr>			  
              <tr class="m_cen">
                <td>蓝波</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_Blue']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_Blue']?>" name="AC1_Blue"></td>
                <td>蓝波</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_Blue']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_Blue']?>" name="AC2_Blue"></td>
                <td>蓝波</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_Blue']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_Blue']?>" name="AC3_Blue"></td>
                <td>蓝波</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_Blue']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_Blue']?>" name="AC4_Blue"></td>
                <td>蓝波</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_Blue']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_Blue']?>" name="AC5_Blue"></td>
                <td>蓝波</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_Blue']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_Blue']?>" name="AC6_Blue"></td>
              </tr>
              <tr class="m_cen">
                <td>绿波</td>
                <td><font color=red><b><?=$row['N_Rates_AC1_Green']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC1_Green']?>" name="AC1_Green"></td>
                <td>绿波</td>
                <th><font color=red><b><?=$row['N_Rates_AC2_Green']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC2_Green']?>" name="AC2_Green"></td>
                <td>绿波</td>
                <td><font color=red><b><?=$row['N_Rates_AC3_Green']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC3_Green']?>" name="AC3_Green"></td>
                <td>绿波</td>
                <td><font color=red><b><?=$row['N_Rates_AC4_Green']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC4_Green']?>" name="AC4_Green"></td>
                <td>绿波</td>
                <td><font color=red><b><?=$row['N_Rates_AC5_Green']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC5_Green']?>" name="AC5_Green"></td>
                <td>绿波</td>
                <td><font color=red><b><?=$row['N_Rates_AC6_Green']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_AC6_Green']?>" name="AC6_Green"></td>
              </tr>  			  
          </table>
		  </td>
      </tr>
   <tr class="m_cen">
       <td width="800" height="21">
		  <table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
              <tr class="m_cen">
                  <td><input name="Submit" type="submit" class="za_button" value="确定">&nbsp;&nbsp;<input name="Submit22" type="reset" class="za_button" value="取消" onClick="cancel('1');"></td>
				  <input type=hidden value="AC6" name=type>
                </tr>
            </table>
		</td>
  </tr>
</table>
	</td>
  </tr>
</form>
</table>
<?
}else if ($num=='GC'){
?>
<table border="0" cellspacing="1" cellpadding="0" width="800">
<form name="myform" method="post" onSubmit="return CheckUPDATE();" action="" >
  <tr>
    <td width="800">
<table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
  <tr class="m_cen">
      <td width="800" height="21">
		  <table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
              <tr class="m_title">
                <td height="27" colspan="3">特码生肖</td>
                <td colspan="3">半波</td>
                <td colspan="3">一肖</td>
                <td colspan="3">多肖</td>
                <td colspan="3">尾数</td>
                </tr>
              <tr class="m_title">
                <td width="36" height="27">肖号</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
                <td width="36">波号</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
                <td width="36">肖号</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
                <td width="45">多号</td>
                <td width="50">赔率</td>
                <td width="65">修改赔率</td>
                <td width="36">尾号</td>
                <td width="50">赔率</td>
                <td width="70" >修改赔率</td>
              </tr>
              <tr class="m_cen">
                <td height="30">鼠</td>
                <td><font color=red><b><?=$row['N_Rates_Rat']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Rat']?>" name="Rat"></td>
                <td>红单</td>
                <th><font color=red><b><?=$row['N_Rates_Red_Odd']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Red_Odd']?>" name="Red_Odd"></td>
                <td>鼠</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Rat']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Rat']?>" name="Last_Rat"></td>
                <td>三肖</td>
                <td><font color=red><b><?=$row['N_Rates_3_Animals']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_3_Animals']?>" name="3_Animals"></td>
                <td>0尾</td>
                <td><font color=red><b><?=$row['N_Rates_Last_00']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_00']?>" name="Last_00"></td>
              </tr>
              <tr class="m_cen">
                <td height="30">牛</td>
                <td><font color=red><b><?=$row['N_Rates_Cow']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Cow']?>" name="Cow"></td>
                <td>红双</td>
                <th><font color=red><b><?=$row['N_Rates_Red_Even']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Red_Even']?>" name="Red_Even"></td>
                <td>牛</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Cow']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Cow']?>" name="Last_Cow"></td>
                <td>四肖</td>
                <td><font color=red><b><?=$row['N_Rates_4_Animals']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_4_Animals']?>" name="4_Animals"></td>
                <td>1尾</td>
                <td><font color=red><b><?=$row['N_Rates_Last_01']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_01']?>" name="Last_01"></td>
              </tr>
              <tr class="m_cen">
                <td height="30">虎</td>
                <td><font color=red><b><?=$row['N_Rates_Tiger']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Tiger']?>" name="Tiger"></td>
                <td>红大</td>
                <th><font color=red><b><?=$row['N_Rates_Red_Over']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Red_Over']?>" name="Red_Over"></td>
                <td>虎</td>
                <td id="n23"><font color=red><b><?=$row['N_Rates_Last_Tiger']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Tiger']?>" name="Last_Tiger"></td>
                <td>五肖</td>
                <td><font color=red><b><?=$row['N_Rates_5_Animals']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_5_Animals']?>" name="5_Animals"></td>
                <td>2尾</td>
                <td><font color=red><b><?=$row['N_Rates_Last_02']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_02']?>" name="Last_02"></td>
              </tr>
              <tr class="m_cen">
                <td height="30">兔</td>
                <td><font color=red><b><?=$row['N_Rates_Rabbit']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Rabbit']?>" name="Rabbit"></td>
                <td>红小</td>
                <th><font color=red><b><?=$row['N_Rates_Red_Under']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Red_Under']?>" name="Red_Under"></td>
                <td>兔</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Rabbit']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Rabbit']?>" name="Last_Rabbit"></td>
                <td>六肖</td>
                <td><font color=red><b><?=$row['N_Rates_6_Animals']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_6_Animals']?>" name="6_Animals"></td>
                <td>3尾</td>
                <td><font color=red><b><?=$row['N_Rates_Last_03']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_03']?>" name="Last_03"></td>
              </tr>			  
              <tr class="m_cen">
                <td height="30">龙</td>
                <td><font color=red><b><?=$row['N_Rates_Liuzhou']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Liuzhou']?>" name="Liuzhou"></td>
                <td>蓝单</td>
                <th><font color=red><b><?=$row['N_Rates_Blue_Odd']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Blue_Odd']?>" name="Blue_Odd"></td>
                <td>龙</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Liuzhou']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Liuzhou']?>" name="Last_Liuzhou"></td>
                <td colspan="3" class="m_title">连码</td>
                <td>4尾</td>
                <td><font color=red><b><?=$row['N_Rates_Last_04']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_04']?>" name="Last_04"></td>
              </tr>			  
              <tr class="m_cen">
                <td height="30">蛇</td>
                <td><font color=red><b><?=$row['N_Rates_Snake']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Snake']?>" name="Snake"></td>
                <td>蓝双</td>
                <th><font color=red><b><?=$row['N_Rates_Blue_Even']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Blue_Even']?>" name="Blue_Even"></td>
                <td>蛇</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Snake']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Snake']?>" name="Last_Snake"></td>
                <td>二全中</td>
                <td><font color=red><b><?=$row['N_Rates_2_1']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_2_1']?>" name="2_1"></td>
                <td>5尾</td>
                <td><font color=red><b><?=$row['N_Rates_Last_05']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_05']?>" name="Last_05"></td>
              </tr>
              <tr class="m_cen">
                <td height="30">马</td>
                <td><font color=red><b><?=$row['N_Rates_Horse']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Horse']?>" name="Horse"></td>
                <td>蓝大</td>
                <th><font color=red><b><?=$row['N_Rates_Blue_Over']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Blue_Over']?>" name="Blue_Over"></td>
                <td>马</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Horse']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Horse']?>" name="Last_Horse"></td>
                <td>二中<br>特中特</td>
                <td><font color=red><b><?=$row['N_Rates_2_0_0']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_2_0_0']?>" name="2_0_0"></td>
                <td>6尾</td>
                <td><font color=red><b><?=$row['N_Rates_Last_06']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_06']?>" name="Last_06"></td>
              </tr>
              <tr class="m_cen">
                <td height="30">羊</td>
                <td><font color=red><b><?=$row['N_Rates_Sheep']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Sheep']?>" name="Sheep"></td>
                <td>蓝小</td>
                <th><font color=red><b><?=$row['N_Rates_Blue_Under']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Blue_Under']?>" name="Blue_Under"></td>
                <td>羊</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Sheep']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Sheep']?>" name="Last_Sheep"></td>
                <td>二中<br>特中二</td>
                <td><font color=red><b><?=$row['N_Rates_2_0_2']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_2_0_2']?>" name="2_0_2"></td>
                <td>7尾</td>
                <td><font color=red><b><?=$row['N_Rates_Last_07']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_07']?>" name="Last_07"></td>
              </tr>			  
              <tr class="m_cen">
                <td height="30">猴</td>
                <td><font color=red><b><?=$row['N_Rates_Monkey']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Monkey']?>" name="Monkey"></td>
                <td>绿单</td>
                <th><font color=red><b><?=$row['N_Rates_Green_Odd']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Green_Odd']?>" name="Green_Odd"></td>
                <td>猴</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Monkey']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Monkey']?>" name="Last_Monkey"></td>
                <td>三全中</td>
                <td><font color=red><b><?=$row['N_Rates_3_1']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_3_1']?>" name="3_1"></td>
                <td>8尾</td>
                <td><font color=red><b><?=$row['N_Rates_Last_08']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_08']?>" name="Last_08"></td>
              </tr>			  
              <tr class="m_cen">
                <td height="30">鸡</td>
                <td><font color=red><b><?=$row['N_Rates_Chicken']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Chicken']?>" name="Chicken"></td>
                <td>绿双</td>
                <th><font color=red><b><?=$row['N_Rates_Green_Even']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Green_Even']?>" name="Green_Even"></td>
                <td>鸡</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Chicken']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Chicken']?>" name="Last_Chicken"></td>
                <td>三中<br>二中二</td>
                <td><font color=red><b><?=$row['N_Rates_3_2_2']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_3_2_2']?>" name="3_2_2"></td>
                <td>9尾</td>
                <td><font color=red><b><?=$row['N_Rates_Last_09']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_09']?>" name="Last_09"></td>
              </tr>			  			  
              <tr class="m_cen">
                <td height="30">狗</td>
                <td><font color=red><b><?=$row['N_Rates_Dog']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Dog']?>" name="Dog"></td>
                <td>绿大</td>
                <th><font color=red><b><?=$row['N_Rates_Green_Over']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Green_Over']?>" name="Green_Over"></td>
                <td>狗</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Dog']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Dog']?>" name="Last_Dog"></td>
                <td>三中<br>二中三</td>
                <td><font color=red><b><?=$row['N_Rates_3_2_3']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_3_2_3']?>" name="3_2_3"></td>
                <td></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr class="m_cen">
                <td height="30">猪</td>
                <td><font color=red><b><?=$row['N_Rates_Pig']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Pig']?>" name="Pig"></td>
                <td>绿小</td>
                <th><font color=red><b><?=$row['N_Rates_Green_Under']?></b></font></th>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Green_Under']?>" name="Green_Under"></td>
                <td>猪</td>
                <td><font color=red><b><?=$row['N_Rates_Last_Pig']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_Last_Pig']?>" name="Last_Pig"></td>
                <td>特串</td>
                <td><font color=red><b><?=$row['N_Rates_1_1']?></b></font></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$row['N_Rates_1_1']?>" name="1_1"></td>
                <td></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>  			  
          </table>
		  </td>
      </tr>
   <tr class="m_cen">
       <td width="800" height="21">
		  <table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="800">
              <tr class="m_cen">
                  <td><input name="Submit" type="submit" class="za_button" value="确定">&nbsp;&nbsp;<input name="Submit22" type="reset" class="za_button" value="取消" onClick="cancel('1');"></td>
				  <input type=hidden value="GC" name=type>
                </tr>
            </table>
		</td>
  </tr>
</table>
	</td>
  </tr>
</form>
</table>
<?
}else if ($num=='Down'){

?>
<table border="0" cellspacing="1" cellpadding="0" width="400">
<form name="myform" method="post" onSubmit="return CheckUPDATE();" action="" >
  <tr>
    <td width="400">
<table border="0" width="100%" cellspacing="1" cellpadding="0" class="m_tab">
  <tr class="m_cen">
      <td width="100%" height="21">
		  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="m_tab">
              <tr class="m_title">
                <td height="27" colspan="4">降水设置</td>
                </tr>
              <tr class="m_title">
                <td width="111" height="25">类型</td>
                <td width="100">下注金额</td>
                <td width="90" >降水赔率</td>
                <td width="90" >最低赔率</td>
                </tr>
              <tr class="m_cen">
                <td height="25" align="right">特码A:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_SCA']?>" name="Num_Sum_SCA"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_SCA']?>" name="Num_Down_Rate_SCA"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_SCA']?>" name="Num_Lowest_Rate_SCA"></td>
                </tr>
              <tr class="m_cen">
                <td height="25" align="right">特码B:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_SCB']?>" name="Num_Sum_SCB"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_SCB']?>" name="Num_Down_Rate_SCB"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_SCB']?>" name="Num_Lowest_Rate_SCB"></td>
              </tr>
              <tr class="m_cen">
                <td height="25" align="right">特码单双大小:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_SCA_AOUEO']?>" name="Num_Sum_SCA_AOUEO"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_SCA_AOUEO']?>" name="Num_Down_Rate_SCA_AOUEO"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_SCA_AOUEO']?>" name="Num_Lowest_Rate_SCA_AOUEO"></td>
                </tr>
              <tr class="m_cen">
                <td height="25" align="right">特码合单双大小:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_SCA_BOUEO']?>" name="Num_Sum_SCA_BOUEO"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_SCA_BOUEO']?>" name="Num_Down_Rate_SCA_BOUEO"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_SCA_BOUEO']?>" name="Num_Lowest_Rate_SCA_BOUEO"></td>
                </tr>
              <tr class="m_cen">
                <td height="25" align="right">特码色波:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_SCA_Wave']?>" name="Num_Sum_SCA_Wave"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_SCA_Wave']?>" name="Num_Down_Rate_SCA_Wave"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_SCA_Wave']?>" name="Num_Lowest_Rate_SCA_Wave"></td>
                </tr>			  
              <tr class="m_cen">
                <td height="25" align="right">正码:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_AC']?>" name="Num_Sum_AC"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_AC']?>" name="Num_Down_Rate_AC"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_AC']?>" name="Num_Lowest_Rate_AC"></td>
                </tr>
              <tr class="m_cen">
                <td height="25" align="right">正码总单双大小:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_AC_TOUEO']?>" name="Num_Sum_AC_TOUEO"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_AC_TOUEO']?>" name="Num_Down_Rate_AC_TOUEO"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_AC_TOUEO']?>" name="Num_Lowest_Rate_AC_TOUEO"></td>
                </tr>			  
              <tr class="m_cen">
                <td height="25" align="right">正码单双大小:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_AC_AOUEO']?>" name="Num_Sum_AC_AOUEO"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_AC_AOUEO']?>" name="Num_Down_Rate_AC_AOUEO"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_AC_AOUEO']?>" name="Num_Lowest_Rate_AC_AOUEO"></td>
                </tr>
              <tr class="m_cen">
                <td height="25" align="right">正码合单双大小:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_AC_BOUEO']?>" name="Num_Sum_AC_BOUEO"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_AC_BOUEO']?>" name="Num_Down_Rate_AC_BOUEO"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_AC_BOUEO']?>" name="Num_Lowest_Rate_AC_BOUEO"></td>
                </tr>
              <tr class="m_cen">
                <td height="25" align="right">正码色波:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_AC_Wave']?>" name="Num_Sum_AC_Wave"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_AC_Wave']?>" name="Num_Down_Rate_AC_Wave"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_AC_Wave']?>" name="Num_Lowest_Rate_AC_Wave"></td>
                </tr>			  
              <tr class="m_cen">
                <td height="25" align="right">生肖:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_SX']?>" name="Num_Sum_SX"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_SX']?>" name="Num_Down_Rate_SX"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_SX']?>" name="Num_Lowest_Rate_SX"></td>
                </tr>			  
              <tr class="m_cen">
                <td height="25" align="right">半波:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_HW']?>" name="Num_Sum_HW"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_HW']?>" name="Num_Down_Rate_HW"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_HW']?>" name="Num_Lowest_Rate_HW"></td>
                </tr>
              <tr class="m_cen">
                <td height="25" align="right">多肖尾数:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_MT']?>" name="Num_Sum_MT"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_MT']?>" name="Num_Down_Rate_MT"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_MT']?>" name="Num_Lowest_Rate_MT"></td>
                </tr>
              <tr class="m_cen">
                <td height="25" align="right">多肖:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_M']?>" name="Num_Sum_M"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_M']?>" name="Num_Down_Rate_M"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_M']?>" name="Num_Lowest_Rate_M"></td>
                </tr>							  			  
              <tr class="m_cen">
                <td height="25" align="right">连码:</td>
                <td><input class="input"  maxlength="6" size="6" onKeyPress="return CheckKey()" value="<?=$down['Num_Sum_EC']?>" name="Num_Sum_EC"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Down_Rate_EC']?>" name="Num_Down_Rate_EC"></td>
                <td><input class="input"  maxlength="4" size="2" onKeyPress="return CheckKey()" value="<?=$down['Num_Lowest_Rate_EC']?>" name="Num_Lowest_Rate_EC"></td>
                </tr>  			  
          </table>
		  </td>
      </tr>
   <tr class="m_cen">
       <td width="400" height="25">
		  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="m_tab" >
              <tr class="m_cen">
                  <td><input name="Submit" type="submit" class="za_button" value="确定">&nbsp;&nbsp;<input name="Submit22" type="reset" class="za_button" value="取消" onClick="cancel('1');"></td>
				  <input type=hidden value="DOWNFORM" name=type>
                </tr>
            </table>
		</td>
  </tr>
</table>
	</td>
  </tr>
</form>
</table>
<?
}
?>
</body>
</html>