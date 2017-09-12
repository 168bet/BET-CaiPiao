<?
session_start();
include ("../include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$loginname=$_SESSION["loginname"];
include "../include/online.php";
$datatime=date('Y-m-d H:i:s');
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
}
$row = mysql_fetch_array($result);
$user=$row['UserName'];
$edittype=$row['EditType'];
$level=$row['Level'];
if ($row['Level']=='M'){
	$n_name="";//总监
}else if ($row['Level']=='A'){
	$n_name="and Super='$user'";//公司
}else if ($row['Level']=='B'){
	$n_name="and Corprator ='$user'";//股东
}else if ($row['Level']=='C'){
	$n_name="and World='$user'";//总代理
}else if ($row['Level']=='D'){
	$n_name="and Agents='$user'";//代理商
}

$id=$_REQUEST['id'];
$gid=$_REQUEST['gid'];
$key=$_REQUEST['key'];
$confirmed=$_REQUEST['confirmed'];
$seconds=$_REQUEST["seconds"];
$date_start=$_REQUEST['date_start'];
$username=$_REQUEST['username'];
$page=$_REQUEST['page'];
$sort=$_REQUEST['sort'];
$ball=$_REQUEST['ball'];
$type=$_REQUEST['type'];
$result_type=$_REQUEST['result_type'];

if ($seconds==''){
	$seconds=180;
}
if ($username==""){
    $name='';
}else{
    $name=" and M_Name='$username'";
}
if ($date_start==""){
    $date_start=date("Y-m-d");
}
if ($page==''){
	$page=0;
}
if ($sort==''){
	$sort='BetTime';
}
if ($sort=='Cancel'){
	$cancel='and Cancel=1';
}else if ($sort=='Danger'){
	$cancel='and Danger=1';
}
if ($ball==''){
	$match='';
}else{
	$match="Active='$ball' and";
}
if ($orderby==''){
	$orderby='desc';
}
if ($result_type==''){
	$result="";
}else if ($result_type=='Y'){
	$result="and M_Result!=''";
}else if ($result_type=='N'){
	$result="and M_Result=''";
}
switch ($type){
case "M":
	$wtype=" Ptype='M' and ";
	$Content='全场獨贏';
	break;
case "R":
	$wtype=" Ptype='R' and ";
	$Content='全场讓球';
	break;
case "OU":
	$wtype=" Ptype='OU' and ";
	$Content='全场大小球';
	break;
case "EO":
	$wtype=" Ptype='EO' and ";
	$Content='全场單雙';
	break;	
case "VR":
	$wtype=" Ptype='VR' and ";
	$Content='上半場獨贏';
	break;
case "VOU":
	$wtype=" Ptype='VOU' and ";
	$Content='上半場讓球';
	break;
case "VM":
	$wtype=" Ptype='VM' and ";
	$Content='上半場大小';
	break;
case "VEO":
	$wtype=" Ptype='VEO' and ";
	$Content='上半場單雙';
	break;	
case "UR":
	$wtype=" Ptype='UR' and ";
	$Content='下半場讓球';
	break;
case "UOU":
	$wtype=" Ptype='UOU' and ";
	$Content='下半場大小';
	break;
case "UEO":
	$wtype=" Ptype='UEO' and ";
	$Content='下半場單雙';
	break;	
case "QR":
	$wtype=" Ptype='QR' and ";
	$Content='单节讓球';
	break;
case "QOU":
	$wtype=" Ptype='QOU' and ";
	$Content='单节大小';
	break;
case "QEO":
	$wtype=" Ptype='QEO' and ";
	$Content='单节單雙';
	break;
case "RM":
	$wtype=" Ptype='RM' and";
	$Content='滾球獨贏';
	break;			
case "RE":
	$wtype=" Ptype='RE' and";
	$Content='滾球讓球';
	break;
case "ROU":
	$wtype=" Ptype='ROU' and";
	$Content='滾球大小';
	break;
case "VRM":
	$wtype=" Ptype='VRM' and";
	$Content='滾球上半場獨贏';
	break;
case "VRE":
	$wtype=" Ptype='VRE' and";
	$Content='滾球上半場讓球';
	break;
case "VROU":
	$wtype=" Ptype='VROU' and";
	$Content='滾球上半場大小';
	break;
case "URE":
	$wtype=" Ptype='URE' and";
	$Content='滾球下半場讓球';
	break;
case "UROU":
	$wtype=" Ptype='UROU' and";
	$Content='滾球下半場大小球';
	break;	
case "PD":
	$wtype=" Ptype='PD' and ";
	$Content='波胆';
	break;
case "VPD":
	$wtype=" Ptype='VPD' and ";
	$Content='半场波胆';
	break;
case "T":
	$wtype=" Ptype='T' and ";
	$Content='入球数';
	break;	
case "F":
	$wtype=" Ptype='F' and ";
	$Content='半全场';
	break;
case "PC":
	$wtype=" Ptype='PC' and ";
	$Content='混合过关';
	break;
case "CS":
	$wtype=" Ptype='CS' and ";
	$Content='冠军赛';
	break;
case "":
	$wtype="";
	$Content='全部';
	break;
}
if($key=='modify'){
	$mysql="select * from web_report_data where id='$id'";
	$result = mysql_db_query($dbname, $mysql);
	$row = mysql_fetch_array($result);
	switch ($row['LineType']){
	case 2:
		switch ($row['OpenType']){
		case "A":
			$rate=1.84-$row['M_Rate'];
			break;
		case "B":
			$rate=1.88-$row['M_Rate'];
			break;
		case "C":
			$rate=1.92-$row['M_Rate'];
			break;
		case "D":
			$rate=1.94-$row['M_Rate'];
			break;			
		}
		$rate=number_format($rate,3);
		$gwin=$row['BetScore']*$rate;
		$info   =explode("<br>",$row['Middle']);
		$info_tw=explode("<br>",$row['Middle_tw']);
		$info_en=explode("<br>",$row['Middle_en']);
		
		$sid=$info[1];
		$middle=$info[0].'<br>'.$sid.'<br>'.$info[2].'<br>';
		$middle_tw=$info_tw[0].'<br>'.$sid.'<br>'.$info_tw[2].'<br>';
		$middle_en=$info_en[0].'<br>'.$sid.'<br>'.$info_en[2].'<br>';
		$team=explode("&nbsp;&nbsp;",$info[2]);
		$team_tw=explode("&nbsp;&nbsp;",$info_tw[2]);
		$team_en=explode("&nbsp;&nbsp;",$info_en[2]);
		if ($row['ShowType']=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row['Mtype']=='RH'){
				$mtype='RC';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$mtype='RH';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}	
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row['Mtype']=='RH'){
				$mtype='RC';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$mtype='RH';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}	
		}
		if ($row['MB_MID']<300000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		}else if($row['MB_MID']>800000 and $row['MB_MID']<900000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[1st]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}else if($row['MB_MID']>900000 and $row['MB_MID']<1000000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[下半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[下半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[2nd]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}else if($row['MB_MID']>300000 and $row['MB_MID']<400000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[第一节]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[第一節]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[Q1]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}else if ($row['MB_MID']>400000 and $row['MB_MID']<500000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[第二节]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[第二節]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[Q2]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}else if ($row['MB_MID']>500000 and $row['MB_MID']<600000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[第三节]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[第三節]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[Q3]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		}else if ($row['MB_MID']>600000 and $row['MB_MID']<700000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[第四节]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[第四節]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[Q4]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}	
		$mysql="update web_report_data set Mtype='$mtype',Middle='$lines2',Middle_tw='$lines2_tw',Middle_en='$lines2_en',M_Rate='$rate',Gwin='$gwin',VGOLD='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Edit=1,Cancel=0,Confirmed=0,Checked=0 where ID='$id'";
		break;
	case 3:
		switch ($row['OpenType']){
		case "A":
			$rate=1.84-$row['M_Rate'];
			break;
		case "B":
			$rate=1.88-$row['M_Rate'];
			break;
		case "C":
			$rate=1.92-$row['M_Rate'];
			break;
		case "D":
			$rate=1.94-$row['M_Rate'];
			break;
		}
		$rate=number_format($rate,3);
		$gwin=$row['BetScore']*$rate;
		$info   =explode("<br>",$row['Middle']);
		$info_tw=explode("<br>",$row['Middle_tw']);
		$info_en=explode("<br>",$row['Middle_en']);
		
		$sid=$info[1];
		$middle=$info[0].'<br>'.$sid.'<br>'.$info[2].'<br>';
		$middle_tw=$info_tw[0].'<br>'.$sid.'<br>'.$info_tw[2].'<br>';
		$middle_en=$info_en[0].'<br>'.$sid.'<br>'.$info_en[2].'<br>';

		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row['Mtype']=='OUC'){
			$mtype='OUH';
			$m_place='大&nbsp;'.$pan;
			$m_place_tw='大&nbsp;'.$pan;
			$m_place_en='over'.$pan;
			$place='O'.$pan;
		}else{
			$mtype='OUC';
			$m_place='小&nbsp;'.$pan;
			$m_place_tw='小&nbsp;'.$pan;
			$m_place_en='under'.$pan;
			$place='U'.$pan;
		}
		if ($row['MB_MID']<300000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';			
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		}else if($row['MB_MID']>800000 and $row['MB_MID']<900000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[1st]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}else if($row['MB_MID']>900000 and $row['MB_MID']<1000000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[下半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[下半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[2nd]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}else if($row['MB_MID']>300000 and $row['MB_MID']<400000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[第一节]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[第一節]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[Q1]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}else if ($row['MB_MID']>400000 and $row['MB_MID']<500000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[第二节]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[第二節]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[Q2]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}else if ($row['MB_MID']>500000 and $row['MB_MID']<600000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[第三节]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[第三節]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[Q3]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		}else if ($row['MB_MID']>600000 and $row['MB_MID']<700000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[第四节]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[第四節]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[Q4]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}
		$mysql="update web_report_data set Mtype='$mtype',Middle='$lines2',Middle_tw='$lines2_tw',Middle_en='$lines2_en',M_Place='$place',M_Rate='$rate',Gwin='$gwin',VGOLD='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Edit=1,Cancel=0,Confirmed=0,Checked=0 where ID='$id'";
		break;
	case 12:
		switch ($row['OpenType']){
		case "A":
			$rate=1.84-$row['M_Rate'];
			break;
		case "B":
			$rate=1.88-$row['M_Rate'];
			break;
		case "C":
			$rate=1.92-$row['M_Rate'];
			break;
		case "D":
			$rate=1.94-$row['M_Rate'];
			break;
		}
		$rate=number_format($rate,3);
		
		$gwin=$row['BetScore']*$rate;
		$info   =explode("<br>",$row['Middle']);
		$info_tw=explode("<br>",$row['Middle_tw']);
		$info_en=explode("<br>",$row['Middle_en']);
		
		$sid=$info[1];
		$middle=$info[0].'<br>'.$sid.'<br>'.$info[2].'<br>';
		$middle_tw=$info_tw[0].'<br>'.$sid.'<br>'.$info_tw[2].'<br>';
		$middle_en=$info_en[0].'<br>'.$sid.'<br>'.$info_en[2].'<br>';			
		$team=explode("&nbsp;&nbsp;",$info[2]);
		$team_tw=explode("&nbsp;&nbsp;",$info[2]);
		$team_en=explode("&nbsp;&nbsp;",$info[2]);
		
		if ($row['ShowType']=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row['Mtype']=='VRH'){
				$mtype='VRC';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$mtype='VRH';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}	
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row['Mtype']=='VRH'){
				$mtype='VRC';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$mtype='VRH';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}	
		}
		$lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		$lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		$lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[1st]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		$mysql="update web_report_data set Mtype='$mtype',Middle='$lines2',Middle_tw='$lines2_tw',Middle_en='$lines2_en',M_Rate='$rate',Gwin='$gwin',VGOLD='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Edit=1,Checked=0,Cancel=0,Confirmed=0 where ID='$id'";
		break;
	case 13:
		switch ($row['OpenType']){
		case "A":
			$rate=1.84-$row['M_Rate'];
			break;
		case "B":
			$rate=1.88-$row['M_Rate'];
			break;
		case "C":
			$rate=1.90-$row['M_Rate'];
			break;
		case "D":
			$rate=1.92-$row['M_Rate'];
			break;
		}
		$rate=number_format($rate,3);
		$gwin=$row['BetScore']*$rate;
		$info   =explode("<br>",$row['Middle']);
		$info_tw=explode("<br>",$row['Middle_tw']);
		$info_en=explode("<br>",$row['Middle_en']);
		$sid=$info[1];
		$middle=$info[0].'<br>'.$sid.'<br>'.$info[2].'<br>';
		$middle_tw=$info_tw[0].'<br>'.$sid.'<br>'.$info_tw[2].'<br>';
		$middle_en=$info_en[0].'<br>'.$sid.'<br>'.$info_en[2].'<br>';
		$data=explode("</font>",$info[3]);
		$data_tw=explode("</font>",$info_tw[3]);
		$data_en=explode("</font>",$info_en[3]);
		$team=explode("&nbsp;&nbsp;",$info[2]);
		$team_tw=explode("&nbsp;&nbsp;",$info_tw[2]);
		$team_en=explode("&nbsp;&nbsp;",$info_en[2]);
		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row['Mtype']=='VOUC'){
			$mtype='VOUH';
			$m_place='大&nbsp;'.$pan;
			$m_place_tw='大&nbsp;'.$pan;
			$m_place_en='over'.$pan;
			$place='O'.$pan;
		}else{
			$mtype='VOUC';
			$m_place='小&nbsp;'.$pan;
			$m_place_tw='小&nbsp;'.$pan;
			$m_place_en='under'.$pan;
			$place='U'.$pan;
		}
		$lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		$lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		$lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'&nbsp;-&nbsp;<font color=#666666>[1st]</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		$mysql="update web_report_data set Middle='$lines2',Middle_tw='$lines2_tw',Middle_en='$lines2_en',M_Place='$place',M_Rate='$rate',VGOLD='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Edit=1,Confirmed=0,Cancel=0,Gwin='$gwin',Mtype='$mtype' where ID='$id'";
		break;
	case 9:
		switch ($row['OpenType']){
		case "A":
			$rate=1.84-$row['M_Rate'];
			break;
		case "B":
			$rate=1.88-$row['M_Rate'];
			break;
		case "C":
			$rate=1.92-$row['M_Rate'];
			break;
		case "D":
			$rate=1.94-$row['M_Rate'];
			break;
		}
		$rate=number_format($rate,3);
		$gwin=$row['BetScore']*$rate;
		$info   =explode("<br>",$row['Middle']);
		$info_tw=explode("<br>",$row['Middle_tw']);
		$info_en=explode("<br>",$row['Middle_en']);
		$sid=$info[1];
		$middle=$info[0].'<br>'.$sid.'<br>'.$info[2].'<br>';
		$middle_tw=$info_tw[0].'<br>'.$sid.'<br>'.$info_tw[2].'<br>';
		$middle_en=$info_en[0].'<br>'.$sid.'<br>'.$info_en[2].'<br>';
		$team=explode("&nbsp;&nbsp;",$info[2]);
		$team_tw=explode("&nbsp;&nbsp;",$info[2]);
		$team_en=explode("&nbsp;&nbsp;",$info[2]);
		
		if ($row['ShowType']=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row['Mtype']=='RRH'){
				$otype='RRC';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$otype='RRH';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}	
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row['Mtype']=='RRH'){
				$otype='RRC';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$otype='RRH';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}	
		}
		if ($row['MB_MID']<300000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		}else if($row['MB_MID']>800000 and $row['MB_MID']<900000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[1st]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}else if($row['MB_MID']>900000 and $row['MB_MID']<1000000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[下半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[下半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[2nd]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		}
		$mysql="update web_report_data set Mtype='$otype',Middle='$lines2',Middle_tw='$lines2_tw',Middle_en='$lines2_en',M_Rate='$rate',Gwin='$gwin',vgold='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Edit=1,Confirmed=0,Cancel=0,Checked=0 where ID='$id'";
		break;
	case 19:
		switch ($row['OpenType']){
		case "A":
			$rate=1.84-$row['M_Rate'];
			break;
		case "B":
			$rate=1.88-$row['M_Rate'];
			break;
		case "C":
			$rate=1.92-$row['M_Rate'];
			break;
		case "D":
			$rate=1.94-$row['M_Rate'];
			break;
		}
		$rate=number_format($rate,3);
		$gwin=$row['BetScore']*$rate;
		$info   =explode("<br>",$row['Middle']);
		$info_tw=explode("<br>",$row['Middle_tw']);
		$info_en=explode("<br>",$row['Middle_en']);
		$sid=$info[1];
		$middle=$info[0].'<br>'.$sid.'<br>'.$info[2].'<br>';
		$middle_tw=$info_tw[0].'<br>'.$sid.'<br>'.$info_tw[2].'<br>';
		$middle_en=$info_en[0].'<br>'.$sid.'<br>'.$info_en[2].'<br>';
		$team=explode("&nbsp;&nbsp;",$info[2]);
		$team_tw=explode("&nbsp;&nbsp;",$info_tw[2]);
		$team_en=explode("&nbsp;&nbsp;",$info_en[2]);

		if($row['Active']!=3){
		if ($row['ShowType']=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row['Mtype']=='VRRH'){
				$otype='VRRC';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$otype='VRRH';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}	
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row['Mtype']=='VRRH'){
				$otype='VRRC';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$otype='VRRH';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}	
		}
		}else{
		if ($row['ShowType']=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row['Mtype']=='RRH'){
				$otype='RRC';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$otype='RRH';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}	
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row['Mtype']=='RRH'){
				$otype='RRC';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$otype='RRH';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}	
		}
		}
		$lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		$lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		$lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=gray>-[1st]</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';	
		$mysql="update web_report_data set Mtype='$otype',Middle='$lines2',Middle_tw='$lines2_tw',Middle_en='$lines2_en',M_Rate='$rate',Gwin='$gwin',vgold='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Edit=1,Confirmed=0,Cancel=0,Checked=0 where ID='$id'";
		break;
	case 10:
		switch ($row['OpenType']){
		case "A":
			$rate=1.84-$row['M_Rate'];
			break;
		case "B":
			$rate=1.88-$row['M_Rate'];
			break;
		case "C":
			$rate=1.90-$row['M_Rate'];
			break;
		case "D":
			$rate=1.92-$row['M_Rate'];
			break;
		}
		$rate=number_format($rate,3);
		$gwin=$row['BetScore']*$rate;
		$info   =explode("<br>",$row['Middle']);
		$info_tw=explode("<br>",$row['Middle_tw']);
		$info_en=explode("<br>",$row['Middle_en']);
		$sid=$info[1];
		$middle=$info[0].'<br>'.$sid.'<br>'.$info[2].'<br>';
		$middle_tw=$info_tw[0].'<br>'.$sid.'<br>'.$info_tw[2].'<br>';
		$middle_en=$info_en[0].'<br>'.$sid.'<br>'.$info_en[2].'<br>';
		
		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row['Mtype']=='ROUC'){
			$mtype='ROUH';
			$m_place='大&nbsp;'.$pan;
			$m_place_tw='大&nbsp;'.$pan;
			$m_place_en='over'.$pan;
			$place='O'.$pan;
		}else{
			$mtype='ROUC';
			$m_place='小&nbsp;'.$pan;
			$m_place_tw='小&nbsp;'.$pan;
			$m_place_en='under'.$pan;
			$place='U'.$pan;
		}
		if ($row['MB_MID']<300000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';		
		}else if($row['MB_MID']>800000 and $row['MB_MID']<900000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[1st]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		}else if($row['MB_MID']>900000 and $row['MB_MID']<1000000){
		    $lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[下半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';
		    $lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[下半]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		    $lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=#666666>[2nd]</font>&nbsp;@&nbsp;<FONT color=#CC0000><b>'.$rate.'</b></FONT>';		
		}
		$mysql="update web_report_data set Mtype='$mtype',Middle='$lines2',Middle_tw='$lines2_tw',Middle_en='$lines2_en',M_Place='$place',M_Rate='$rate',Gwin='$gwin',VGOLD='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Edit=1,Cancel=0,Confirmed=0,Checked=0 where ID='$id'";
		break;
	case 20:
		switch ($row['OpenType']){
		case "A":
			$rate=1.84-$row['M_Rate'];
			break;
		case "B":
			$rate=1.88-$row['M_Rate'];
			break;
		case "C":
			$rate=1.90-$row['M_Rate'];
			break;
		case "D":
			$rate=1.92-$row['M_Rate'];
			break;
		}
		$rate=number_format($rate,3);
		$gwin=$row['BetScore']*$rate;
		$info   =explode("<br>",$row['Middle']);
		$info_tw=explode("<br>",$row['Middle_tw']);
		$info_en=explode("<br>",$row['Middle_en']);
		$sid=$info[1];
		$middle=$info[0].'<br>'.$sid.'<br>'.$info[2].'<br>';
		$middle_tw=$info_tw[0].'<br>'.$sid.'<br>'.$info_tw[2].'<br>';
		$middle_en=$info_en[0].'<br>'.$sid.'<br>'.$info_en[2].'<br>';
		
		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if($row['Active']!=3){
		if ($row['Mtype']=='VROUC'){
			$mtype='VROUH';
			$m_place='大&nbsp;'.$pan;
			$m_place_tw='大&nbsp;'.$pan;
			$m_place_en='over'.$pan;
			$place='O'.$pan;
		}else{
			$mtype='VROUC';
			$m_place='小&nbsp;'.$pan;
			$m_place_tw='小&nbsp;'.$pan;
			$m_place_en='under'.$pan;
			$place='U'.$pan;
		}
		}else{
		if ($row['Mtype']=='ROUC'){
			$mtype='ROUH';
			$m_place='大&nbsp;'.$pan;
			$m_place_tw='大&nbsp;'.$pan;
			$m_place_en='over'.$pan;
			$place='O'.$pan;
		}else{
			$mtype='ROUC';
			$m_place='小&nbsp;'.$pan;
			$m_place_tw='小&nbsp;'.$pan;
			$m_place_en='under'.$pan;
			$place='U'.$pan;
		}
		}
		$lines2=$middle.'<FONT color=#cc0000>'.$m_place.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw=$middle_tw.'<FONT color=#cc0000>'.$m_place_tw.'</font>&nbsp;-&nbsp;<font color=#666666>[上半]</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en=$middle_en.'<FONT color=#cc0000>'.$m_place_en.'</font>&nbsp;-&nbsp;<font color=gray>-[1st]</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$mysql="update web_report_data set Mtype='$mtype',Middle='$lines2',Middle_tw='$lines2_tw',Middle_en='$lines2_en',M_Place='$place',M_Rate='$rate',Gwin='$gwin',VGOLD='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Edit=1,Cancel=0,Confirmed=0,Checked=0 where ID='$id'";
		break;

	}
	file_put_contents("edit.txt",$mysql.'/'.'['.$row['M_Name'].']'.'/'.$datatime,FILE_APPEND);
	mysql_db_query($dbname, $mysql);
	$sql='update match_sports set score=0 where mid='.$gid;
	mysql_db_query($dbname, $sql);
	echo "<script languag='JavaScript'>self.location='query.php?uid=$uid&langx=$langx&&seconds=$seconds&username=$username&date_start=$date_start&page=$page&sort=$sort&ball=$ball&type=$type'</script>";
}
//取消注单
if ($key=='cancel'){
    $rsql = "select M_Name,Pay_Type,BetScore,M_Result from web_report_data where mid='$gid' and id='$id' and Pay_Type=1";
    $rresult = mysql_db_query($dbname, $rsql);
    while ($rrow = mysql_fetch_array($rresult)){
           $username=$rrow['M_Name'];
           $betscore=$rrow['BetScore'];
           $m_result=$rrow['M_Result'];
           if ($rrow['Pay_Type']==1){//结算之后的现金返回
               if ($m_result==''){
                   $u_sql = "update web_member_data set Money=Money+$betscore where UserName='$username' and Pay_Type=1";
                   mysql_db_query($dbname,$u_sql) or die ("操作失败11!");
               }else{
                   $u_sql = "update web_member_data set Money=Money-$m_result where UserName='$username' and Pay_Type=1";
                   mysql_db_query($dbname,$u_sql) or die ("操作失败22!");
               }
           }
    }
	$sql="update web_report_data set VGOLD=0,M_Result=0,A_Result=0,B_Result=0,C_Result=0,D_Result=0,T_Result=0,Cancel=1,Confirmed='$confirmed',Danger=0,Checked=1 where id='$id'";
	mysql_db_query($dbname, $sql) or die ("操作失败!");
	echo "<script languag='JavaScript'>self.location='query.php?uid=$uid&langx=$langx&&seconds=$seconds&username=$username&date_start=$date_start&page=$page&sort=$sort&ball=$ball&type=$type'</script>";
}

//恢复注单
if ($key=='resume'){
	$rsql = "select M_Name,Pay_Type,BetScore,M_Result,Checked from web_report_data where MID='$gid' and ID='$id' and Pay_Type=1";
	$rresult = mysql_db_query($dbname, $rsql);
	while ($rrow = mysql_fetch_array($rresult)){
	       $username=$rrow['M_Name'];
	       $betscore=$rrow['BetScore'];
	       $m_result=$rrow['M_Result'];
	       if ($rrow['Pay_Type']==1){//结算之后的现金返回
			   if ($rrow['Checked']==1){
	               $cash=$betscore+$m_result;
	               $u_sql ="update web_member_data SET Money=Money-$cash where UserName='$username' and Pay_Type=1";
	               mysql_db_query($dbname,$u_sql) or die ("操作失败1!");
	            }
	       }
	}
	$sql="update web_report_data set VGOLD='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Cancel=0,Confirmed=0,Danger=0,Checked=0 where id='$id'";
	mysql_db_query($dbname, $sql);
	echo "<script languag='JavaScript'>self.location='query.php?uid=$uid&langx=$langx&&seconds=$seconds&username=$username&date_start=$date_start&page=$page&sort=$sort&ball=$ball&type=$type'</script>";
}
//恢复注单
if ($key=='del'){
	$sql="delete from web_report_data where id='$id'";
	mysql_db_query($dbname, $sql);
	echo "<script languag='JavaScript'>self.location='query.php?uid=$uid&langx=$langx&&seconds=$seconds&username=$username&date_start=$date_start&page=$page&sort=$sort&ball=$ball&type=$type'</script>";
}


$checkout=$_REQUEST['checkout'];
if ($checkout=='0'){
	$check="and M_Result=''";
}else if ($checkout==''){
	$check="";
}
$mysql="select ID,MID,Active,LineType,Mtype,Pay_Type,M_Date,BetTime,BetScore,CurType,Middle,Middle_tw,Middle_en,BetType,BetType_tw,BetType_en,M_Place,M_Rate,M_Name,Gwin,Glost,VGOLD,M_Result,A_Result,B_Result,C_Result,D_Result,T_Result,TurnRate,OpenType,OddsType,ShowType,Cancel,Ptype,MB_ball,TG_ball,Edit,Confirmed,Danger from web_report_data where $match $wtype M_Date='$date_start' $name $n_name $cancel $check $result order by $sort desc";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
$page_size=50;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$mysql."  limit $offset,$page_size;";
//echo $mysql;
$result = mysql_db_query($dbname, $mysql);
?>
<html>
<head>
<title>query</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title_re {  background-color: #577176; text-align: right; color: #FFFFFF}
.m_bc { background-color: #C9DBDF; padding-left: 7px }
-->
</style>
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language=javascript>
function CheckSTOP(str){
	if(confirm("确实取消本场注单吗?"))
		document.location=str;
	}
function CheckDEL(str){
	if(confirm("是否要删除此注单 ?"))
	document.location=str;
}
function reload(){
	location.reload();
}
function sbar(st){
	st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
	st.style.backgroundColor='';
}
function onLoad(){
	var obj_seconds = document.getElementById('seconds');
    obj_seconds.value = '<?=$seconds?>';
	var obj_page = document.getElementById('page');
	obj_page.value = '<?=$page?>';
	var obj_sort=document.getElementById('sort');
	obj_sort.value='<?=$sort?>';
	var obj_ball=document.getElementById('ball');
	obj_ball.value='<?=$ball?>';
	var obj_type=document.getElementById('type');
	obj_type.value='<?=$type?>';
	var obj_type=document.getElementById('result_type');
	obj_type.value='<?=$result_type?>';
}
var second="<?=$seconds?>" 
function auto_refresh(){
	if (second==1){
		window.location.href='query.php?uid=<?=$uid?>&langx=<?=$langx?>&lv=<?=$lv?>&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>'; //刷新页面
	}else{
		second-=1
		curmin=Math.floor(second)
		curtime=curmin+"秒"
		ShowTime.innerText=curtime
		setTimeout("auto_refresh()",1000)
	}
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0"  onLoad="onLoad();auto_refresh()">
<FORM id="myFORM" ACTION="" METHOD=POST name="myFORM"  style='margin-top:-15px;'>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="m_tline" width="75"><input name=button type=button class="za_button" onClick="location.reload()" value="手动更新"></td>
  <td class="m_tline" width="115">
  <select class="za_select" onChange="document.myFORM.submit();" name="seconds">
        <option value="10">10秒</option>
        <option value="30">30秒</option>
        <option value="60">60秒</option>
        <option value="90">90秒</option>
        <option value="120">120秒</option>
        <option value="180">180秒</option>
      </select>&nbsp;&nbsp;&nbsp;<span id=ShowTime></span></td>
  <td width="100" align="right" class="m_tline">会员帐号:&nbsp;</td>
  <td class="m_tline" width="90"><input type=TEXT name="username" size=10 value="<?=$username?>" maxlength=11 class="za_text"></td>
  <td width="80" align="right" class="m_tline">注单日期:&nbsp;</td>
  <td class="m_tline" width="100"><input type=TEXT name="date_start" size=10 value=<?=$date_start?> maxlength=11 class="za_text"></td> 
  <td class="m_tline" width="80"><input type=SUBMIT name="SUBMIT" value="确认" class="za_button"></td>
  <td class="m_tline" width="150"><?=$Rep_Bet_State?>
  <select name='result_type' onChange="self.myFORM.submit()">
  <option value=""><?=$Rel_All?></option>		
        <option value="Y"><?=$Rep_Results?></option>
        <option value="N"><?=$Rep_No_Results?></option> 
  </select>
  </td>
  <td class="m_tline" width="84">共<?=$cou?>条</td>
  <td class="m_tline" width="100">
  <select name='page' onChange="self.myFORM.submit()">
<?
if ($page_count==0){
    $page_count=1;
	}
	for($i=0;$i<$page_count;$i++){
		if ($i==$page){
			echo "<option selected value='$i'>".($i+1)."</option>";
		}else{
			echo "<option value='$i'>".($i+1)."</option>";
		}
	}
?>  
  </select> 共<?=$page_count?> 页
  </td>
  <td width="34"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
</tr>
<tr> 
<td colspan="9" height="4"></td>
</tr>
</table>
<table width="975" border="0" cellspacing="1" cellpadding="0" class="m_tab">
        <tr class="m_title">
          <td align="center">
		  <select name="sort" onChange="document.myFORM.submit();" class="za_select">
            <option value="BetTime">投注时间</option>
            <option value="Gwin">投注金额</option>
            <option value="Cancel">取消注单</option>
			<option value="Danger">危险注单</option>
          </select>		  </td>
          <td align="center">&nbsp;</td>
          <td align="center">
		  <select name="ball" onChange="self.myFORM.submit()" class="za_select">
		    <option value="">全部</option>
			<option value="1">足球</option>
			<option value="2">篮球</option>
            <option value="3">棒球</option>
			<option value="4">网球</option>
			<option value="5">排球</option>
			<option value="6">其它</option>
          </select>		  </td>
          <td align="center">
		  <select name="type" onChange="self.myFORM.submit()" class="za_select">
		    <option value="" SELECTED>全部</option>
		    <option value="M">全场獨贏</option>
		    <option value="R">全场讓球</option>
		    <option value="OU">全场大小球</option>
		    <option value="EO">全场單雙</option>
		    <option value="VM">上半場獨贏</option>
		    <option value="VR">上半場讓球</option>
		    <option value="VOU">上半場大小</option>		  
		    <option value="VEO">上半場單雙</option>
		    <option value="UR">下半場讓球</option>
		    <option value="UOU">下半場大小</option>
		    <option value="UEO">下半場單雙</option>	
		    <option value="QR">单节讓球</option>
		    <option value="QOU">单节大小</option>
		    <option value="QEO">单节單雙</option>
		    <option value="RM">滾球獨贏</option>
		    <option value="RE">滾球讓球</option>
		    <option value="ROU">滾球大小</option>
		    <option value="VRM">滾球上半場獨贏</option>
		    <option value="VRE">滾球上半場讓球</option>
		    <option value="VROU">滾球上半場大小</option>
		    <option value="URE">滾球下半場讓球</option>
		    <option value="UROU">滾球下半場大小球</option>
		    <option value="PD">波膽</option>
		    <option value="VPD">上半場波膽</option>
		    <option value="T">總入球</option>
		    <option value="F">半全場</option>
		    <option value="PC">混合過關</option>
		    <option value="CS">冠軍賽</option>
          </select>		  </td>
          <td colspan="5" align="center">&nbsp;</td>
        </tr>
        <tr class="m_title"> 
          <td width="85"align="center">投注时间</td>
          <td width="80" align="center">用户名称</td>
          <td width="110" align="center">球赛种类</td>
          <td width="300" align="center">內容</td>
          <td width="70" align="center">投注金额</td>
          <td width="70" align="center">可赢金额</td>
          <td width="80" align="center">会员结果</td>
          <td width="50" align="center">注单</td>
          <? if ($level=='M'){ ?><td width="120" align="center">功能</td><? } ?>
        </tr>
<?
while ($row = mysql_fetch_array($result)){
switch($row['Active']){
case 1:
    $active='1';
	$Title=$Mnu_Soccer;
	break;
case 11:
    $active='11';
	$Title=$Mnu_Soccer;
	break;
case 2:
    $active='2';
	$Title=$Mnu_Bask;
	break;
case 22:
    $active='22';
	$Title=$Mnu_Bask;
	break;
case 3:
    $active='3';
	$Title=$Mnu_Base;
	break;
case 33:
    $active='33';
	$Title=$Mnu_Base;
	break;
case 4:
    $active='4';
	$Title=$Mnu_Tennis;
	break;
case 44:
    $active='44';
	$Title=$Mnu_Tennis;
	break;
case 5:
    $active='5';
	$Title=$Mnu_Voll;
	break;
case 55:
    $active='55';
	$Title=$Mnu_Voll;
	break;
case 6:
    $active='6';
	$Title=$Mnu_Other;
	break;
case 66:
    $active='66';
	$Title=$Mnu_Other;
	break;
case 7:
    $active='7';
	$Title=$Mnu_Stock;
	break;
case 77:
    $active='77';
	$Title=$Mnu_Stock;
	break;
case 8:
    $active='8';
	$Title=$Mnu_Guan;
	break;
case 9:
	$Title=$Mnu_MarkSix;
	break;
}
switch ($row['OddsType']){
case 'H':
    $Odds='<BR><font color =green>'.$Rep_HK.'</font>';
	break;
case 'M':
    $Odds='<BR><font color =green>'.$Rep_Malay.'</font>';
	break;
case 'I':
    $Odds='<BR><font color =green>'.$Rep_Indo.'</font>';
	break;
case 'E':
    $Odds='<BR><font color =green>'.$Rep_Euro.'</font>';
	break;
case '':
    $Odds='';
	break;
}
$time=strtotime($row['BetTime']);
$times=date("Y-m-d",$time).'<br>'.date("H:i:s",$time);

if($row['Danger']==1 or $row['Cancel']==1) {
$bettimes='<font color="#FFFFFF"><span style="background-color: #FF0000">'.$times.'</span></font>';
}else{
$bettimes=$times;
}
if($row['Cancel']==1){
$betscore='<S><font color=#cc0000>'.number_format($row['BetScore']).'</font></S>';
}else{
$betscore=number_format($row['BetScore']);
}
if ($row['ShowType']=='H' or $row['LineType']=='10' or $row['LineType']=='20'){
    $matchball=$row['MB_ball'].':'.$row['TG_ball'];
}else{
    $matchball=$row['TG_ball'].':'.$row['MB_ball'];
}
if ($row['Edit']==0 and $level=='M'){
	$class='';
}else if ($row['Edit']==1 and $level=='M'){
	$class='bgcolor=#00FF00';
}
?>
        <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
          <td align="center"><?=$bettimes?></td>
          <td align="center"><?=$row['M_Name']?><br><font color="#CC0000"><?=$row['OpenType']?>&nbsp;&nbsp;<?=$row['TurnRate']?></font></td>
          <td align="center"><?=$Title?><?=$row['BetType_tw']?><?=$Odds?><br><font color="#0000CC"><?=show_voucher($row['LineType'],$row['ID'])?></font></td>
          <td <?=$class?>>
<?
if($row['Cancel']==1){
   echo "<span style=float:left;color=#0000FF>".$matchball."</span>";
}
?>		  
<?
if ($row['Active']==$active){
	if ($row['LineType']==8){
		$midd=explode('<br>',$row['Middle_tw']);
		$mid=explode(',',$row['MID']);
		$show=explode(',',$row['ShowType']);

		for($t=0;$t<(sizeof($midd)-1)/3;$t++){
			echo $midd[3*$t].'<br>';
			$mysql="select MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where MID=".$mid[$t];
			$result1 = mysql_db_query($dbname,$mysql);
			$row1 = mysql_fetch_array($result1);

if ($row1["MB_Inball"]=='-1'){
	     $font_a3='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
}else if ($row1["MB_Inball"]=='-2'){     
	     $font_a3='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';	
}else if ($row1["MB_Inball"]=='-3'){      
	     $font_a3='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';	
}else if ($row1["MB_Inball"]=='-4'){     
	     $font_a3='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
}else if ($row1["MB_Inball"]=='-5'){     
	     $font_a3='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';	  
}else if ($row1["MB_Inball"]=='-6'){     
	     $font_a3='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';	  
}else if ($row1["MB_Inball"]=='-7'){     
	     $font_a3='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';	  
}else if ($row1["MB_Inball"]=='-8'){     
	     $font_a3='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';	  
}else if ($row1["MB_Inball"]=='-9'){     
	     $font_a3='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';	  
}else if ($row1["MB_Inball"]=='-10'){     
	     $font_a3='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
}else if ($row1["MB_Inball"]=='-11'){
	     $font_a3='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
}else if ($row1["MB_Inball"]=='-12'){     
	     $font_a3='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';	
}else if ($row1["MB_Inball"]=='-13'){      
	     $font_a3='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';	
}else if ($row1["MB_Inball"]=='-14'){     
	     $font_a3='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
}else if ($row1["MB_Inball"]=='-15'){     
	     $font_a3='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';	  
}else if ($row1["MB_Inball"]=='-16'){     
	     $font_a3='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';	  
}else if ($row1["MB_Inball"]=='-17'){     
	     $font_a3='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';	  
}else if ($row1["MB_Inball"]=='-18'){     
	     $font_a3='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';	  
}else if ($row1["MB_Inball"]=='-19'){     
	     $font_a3='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';	  	 	  
}else{
	$font_a3='<font color="#009900"><b>'.$row1["TG_Inball"].'</b> : <b>'.$row1["MB_Inball"].'</b></font>&nbsp;';
	$font_a4='<font color="#009900"><b>'.$row1["MB_Inball"].'</b> : <b>'.$row1["TG_Inball"].'</b></font>&nbsp;';
}
			echo $midd[3*$t+1].'<br>';
		if ($show[$t]=='C' and $row['LineType']==8){
			echo $font_a3;
		}else{
			echo $font_a4;
		}
			echo $midd[3*$t+2].'<br>';
		}
	}else{
		$midd=explode('<br>',$row['Middle_tw']);
		for($t=0;$t<sizeof($midd)-1;$t++){
			echo $midd[$t].'<br>';
		}
		$mysql="select MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where MID=".$row['MID'];
		$result1 = mysql_db_query($dbname,$mysql);
		$row1 = mysql_fetch_array($result1);
		
if ($row1["MB_Inball"]=='-1'){
      if($row1["MB_Inball_HR"]=='-1' and $row1["MB_Inball"]=='-1'){
	    $font_a1='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	   }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-2'){
      if($row1["MB_Inball_HR"]=='-2' and $row1["MB_Inball"]=='-2'){
	    $font_a1='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-3'){
      if($row1["MB_Inball_HR"]=='-3' and $row1["MB_Inball"]=='-3'){
	    $font_a1='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-4'){
      if($row1["MB_Inball_HR"]=='-4' and $row1["MB_Inball"]=='-4'){
	    $font_a1='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-5'){
      if($row1["MB_Inball_HR"]=='-5' and $row1["MB_Inball"]=='-5'){
	    $font_a1='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-6'){
      if($row1["MB_Inball_HR"]=='-6' and $row1["MB_Inball"]=='-6')
	  {
	    $font_a1='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-7'){
      if($row1["MB_Inball_HR"]=='-7' and $row1["MB_Inball"]=='-7'){
	    $font_a1='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-8'){
      if($row1["MB_Inball_HR"]=='-8' and $row1["MB_Inball"]=='-8')
	  {
	    $font_a1='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-9'){
      if($row1["MB_Inball_HR"]=='-9' and $row1["MB_Inball"]=='-9')
	  {
	    $font_a1='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	   }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-10'){
      if($row1["MB_Inball_HR"]=='-10' and $row1["MB_Inball"]=='-10')
	  {
	    $font_a1='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-11'){
      if($row1["MB_Inball_HR"]=='-11' and $row1["MB_Inball"]=='-11'){
	    $font_a1='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	   }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-12'){
      if($row1["MB_Inball_HR"]=='-12' and $row1["MB_Inball"]=='-12'){
	    $font_a1='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-13'){
      if($row1["MB_Inball_HR"]=='-13' and $row1["MB_Inball"]=='-13'){
	    $font_a1='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-14'){
      if($row1["MB_Inball_HR"]=='-14' and $row1["MB_Inball"]=='-14'){
	    $font_a1='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-15'){
      if($row1["MB_Inball_HR"]=='-15' and $row1["MB_Inball"]=='-15'){
	    $font_a1='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-16'){
      if($row1["MB_Inball_HR"]=='-16' and $row1["MB_Inball"]=='-16')
	  {
	    $font_a1='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-17'){
      if($row1["MB_Inball_HR"]=='-17' and $row1["MB_Inball"]=='-17'){
	    $font_a1='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-18'){
      if($row1["MB_Inball_HR"]=='-18' and $row1["MB_Inball"]=='-18')
	  {
	    $font_a1='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	  }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	  }
}else if ($row1["MB_Inball"]=='-19'){
      if($row1["MB_Inball_HR"]=='-19' and $row1["MB_Inball"]=='-19')
	  {
	    $font_a1='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	  	$font_a3='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
        $font_a4='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	   }else{
	     $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
         $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	     $font_a3='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
         $font_a4='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	  }  
      }else{
	$font_a3='<font color="#009900"><b>'.$row1["TG_Inball"].'</b> : <b>'.$row1["MB_Inball"].'</b></font> &nbsp;';
	$font_a4='<font color="#009900"><b>'.$row1["MB_Inball"].'</b> : <b>'.$row1["TG_Inball"].'</b></font>&nbsp; ';
    $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].'</b> : <b>'.$row1["MB_Inball_HR"].'</b></font>&nbsp; ';
    $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].'</b> : <b>'.$row1["TG_Inball_HR"].'</b></font>&nbsp; ';
}
		
		if ($row['LineType']==11 or $row['LineType']==12 or $row['LineType']==13 or $row['LineType']==14 or $row['LineType']==19 or $row['LineType']==20){
			if ($row['ShowType']=='C' and ($row['LineType']==12 or $row['LineType']==19)){
				echo $font_a1;
			}else{
				echo $font_a2;
			}
		}else{
			if ($row['ShowType']=='C' and ($row['LineType']==2 or $row['LineType']==9)){
				echo $font_a3;
		    }else{
			    echo $font_a4;
		}
	}
	echo $midd[sizeof($midd)-1];
}

}else{
	echo $row['Middle_tw'];
}
?></td>
          <td><?=$betscore?></td>
          <td><?=$row['Gwin']?></td>
          <td>
<? 	
if($row['Cancel']==0){
?>	  
<?=number_format($row['M_Result'],1)?>
<?
}else{
?>
<font color=red>
<?
switch($row['Confirmed']){
case 0:
echo $zt=$Score20;
break;
case -1:
echo $zt=$Score21;
break;
case -2:
echo $zt=$Score22;
break;
case -3:
echo $zt=$Score23;
break;
case -4:
echo $zt=$Score24;
break;
case -5:
echo $zt=$Score25;
break;
case -6:
echo $zt=$Score26;
break;
case -7:
echo $zt=$Score27;
break;
case -8:
echo $zt=$Score28;
break;
case -9:
echo $zt=$Score29;
break;
case -10:
echo $zt=$Score30;
break;
case -11:
echo $zt=$Score31;
break;
case -12:
echo $zt=$Score32;
break;
case -13:
echo $zt=$Score33;
break;
case -14:
echo $zt=$Score34;
break;
case -15:
echo $zt=$Score35;
break;
case -16:
echo $zt=$Score36;
break;
case -17:
echo $zt=$Score37;
break;
case -18:
echo $zt=$Score38;
break;
case -19:
echo $zt=$Score39;
break;
case -20:
echo $zt=$Score40;
break;
case -21:
echo $zt=$Score41;
break;
}
?>
</font>
<?
}
?>		  </td>
          <td align="center">
<?
if ($level=='M'){
?>
 <a href="javascript:CheckDEL('query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=del&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>')"><font color=red><b>删除</b></font></a><br>
<?
}
?>       
<?
if ($row['Cancel']==1){
	echo '<font color=red><b>已注销</b></font><br>';
}else{
	echo '<font color=blue><b>正常</b></font><br>';
}
?>
<?
if ($edittype==1){
?>	
		  <a href="query_edit.php?uid=<?=$uid?>&langx=<?=$langx?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&username=<?=$username?>&date_start=<?=$date_start?>">修改</a><br> 
          <a href="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=modify&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>">对调</a>
<?
}
?>         
          </td>
          <? if ($level=='M'){ ?><td width="121" align="center">
<SELECT onchange=javascript:CheckSTOP(this.options[this.selectedIndex].value) size=1 name=select1>
  <option>注单处理</option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=resume&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score20?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-1&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score21?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-2&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score22?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-3&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score23?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-4&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score24?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-5&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score25?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-6&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score26?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-7&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score27?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-8&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score28?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-9&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score29?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-10&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score30?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-11&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score31?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-12&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score32?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-13&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score33?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-14&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score34?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-15&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score35?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-16&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score36?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-17&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score37?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-18&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score38?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-19&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score39?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-20&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score40?></option>
  <option value="query.php?uid=<?=$uid?>&langx=<?=$langx?>&key=cancel&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&confirmed=-21&seconds=<?=$seconds?>&username=<?=$username?>&date_start=<?=$date_start?>&page=<?=$page?>&sort=<?=$sort?>&ball=<?=$ball?>&type=<?=$type?>"><?=$Score41?></option>
</SELECT></td><? } ?>
        </tr>
<?
}
?>
</table>
</FORM>
</BODY>
</html>
<?
$ip_addr = get_ip();
$loginfo='查询注单投注明细';
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$loginname',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>