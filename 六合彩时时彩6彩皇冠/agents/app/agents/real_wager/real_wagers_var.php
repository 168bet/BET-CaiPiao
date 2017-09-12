<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include "../../agents/include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");
require ("../../agents/include/define_function_list.inc.php");
include ("../../agents/include/online.php");
//print_r($_REQUEST);
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$ltype=$_REQUEST['ltype'];//盘口
$gtype=$_REQUEST['gtype'];//项目
$ptype=$_REQUEST['ptype'];//类型
$page_no=$_REQUEST['page_no'];//页数
$league_id=$_REQUEST['league_id'];//联盟
$set_account=$_REQUEST['set_account'];//全部和自己
require ("../../agents/include/traditional.$langx.inc.php");

$sql = "select Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$web='web_system_data';
}else{
    $web='web_agents_data';
}
$mysql = "select ID,Level,UserName from $web where Oid='$uid' and LoginName='$loginname' and Status<2";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$row = mysql_fetch_array($result);
$userid=$row['ID'];
$username=$row['UserName'];
$level=$row['Level'];

if ($level=='M'){
	$user="and Admin='$username'";//总监
}else if ($level=='A'){
	$user="and Super='$username'";//公司
}else if ($level=='B'){
	$user="and Corprator ='$username'";//股东
}else if ($level=='C'){
	$user="and World='$username'";//总代理
}else if ($level=='D'){
	$user="and Agents='$username'";//代理商
}

$dsql = "select A_Point,B_Point,C_Point,D_Point from web_report_data where `M_Date` ='$m_date' $user";
$dresult = mysql_db_query($dbname,$dsql);
$drow=mysql_fetch_array($dresult);

if ($set_account==1){
    if ($level=='M'){
	    $Point='1';//总监
    }else if ($level=='A'){
	    $Point=$drow['A_Point']/100;//公司
	}else if ($level=='B'){
	    $Point=1-($drow['B_Point']+$drow['C_Point']+$drow['D_Point'])/100;//股东
	}else if ($level=='C'){
	    $Point=1-($drow['C_Point']+$drow['D_Point'])/100;//总代理
	}else if ($level=='D'){
	    $Point=1-($drow['D_Point']/100);//代理商
	}
}else{
    $Point='1';
}


if ($ltype==''){
	$ltype=3;
	$open='C';
}else if($ltype==1){
	$open='A';
}else if($ltype==2){
	$open='B';
}else if($ltype==3){
	$open='C';
}else if($ltype==4){
	$open='D';
}
if ($ptype==''){
	$ptype='ou';
}
if ($set_account==''){
	$set_account=0;
}
if ($league_id==''){
	$num=60;
}else{
	$num=60;
}
$m_date=date('Y-m-d');
switch ($gtype){
	case "FT":
	    $datetime="and `M_Date`='$m_date'";
		break;
	case "FU":
	    $datetime="and `M_Date`>'$m_date'";
		break;	
	case "BK":
	    $datetime="and `M_Date`='$m_date'";
		break;
	case "BU":
	    $datetime="and `M_Date`>'$m_date'";
		break;		
	case "BS":
	    $datetime="and `M_Date`='$m_date'";
		break;		
	case "BE":
	    $datetime="and `M_Date`>'$m_date'";
		break;		
	case "TN":
	    $datetime="and `M_Date`='$m_date'";
		break;
	case "TU":
	    $datetime="and `M_Date`>'$m_date'";
		break;
	case "VB":
	    $datetime="and `M_Date`='$m_date'";
		break;		
	case "VU":
	    $datetime="and `M_Date`>'$m_date'";
		break;		
	case "OP":
	    $datetime="and `M_Date`='$m_date'";
		break;
	case "OM":
	    $datetime="and `M_Date`>'$m_date'";
		break;
}
if ($ptype=='RB' or $ptype=='PL'){
	$start='and `M_Start` < now( )';
}else{
	$start='and `M_Start` > now( )';
}
if ($ptype=='PL'){
	$show="and S_Show=1";
}else{
	$show="and ".$ptype."_Show=1";
}
$mysql="SELECT $m_league as m_league FROM `match_sports` WHERE Type='".$gtype."' ".$datetime." ".$start." ".$show." group by $m_league";
$result = mysql_db_query($dbname, $mysql);
while ($row=mysql_fetch_array($result)){
	if ($totaldata==''){
		$totaldata=','.$row['m_league'].'*'.$row['m_league'];
	}else{
		$totaldata=$totaldata.','.$row['m_league'].'*'.$row['m_league'];
	}
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript"> 
if(self == top) location='/';
parent.uid='<?=$uid?>';
parent.ltype = '<?=$ltype?>';
parent.gtype = '<?=$gtype?>';
parent.stype_var = '<?=$ptype?>';
parent.aid = '<?=$userid?>';
parent.dt_now = '<?=date('Y-m-d H:i:s')?>';
parent.gmt_str = '美东时间';
parent.draw = '和局';
parent.sel_league = '';
parent.pg = '<?=$page_no?>';
parent.set_account = '<?=$set_account?>';
parent.totaldata='<?=$totaldata?>';
parent.leg_name = '<?=$league_id?>';
parent.ShowLeague('<?=$league_id?>');
parent.show_page();
<?
$K=0;
switch ($ptype){
case "S":
    $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate,TG_Win_Rate,M_Flat_Rate,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,MB_Dime_Rate,TG_Dime_Rate,S_Single_Rate,S_Double_Rate,MB_MID,TG_MID,ShowTypeR,M_Type,S_Show from match_sports where `Type`='".$gtype."' and `M_Start` > now( ) and `S_Show`=1 order by M_Start,$m_league,MB_MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
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
		
		if ($S_Double_Rate=='' or $S_Double_Rate==''){
		    $Single='';
			$Double='';
		}else{
			$Single=$Rel_Odd;
		    $Double=$Rel_Even;
		}
		$mid=$row['MID'];	
		$sql="select Mtype,LineType,A_Point,B_Point,C_Point,D_Point,BetScore FROM `web_report_data` where FIND_IN_SET($mid,MID)>0 and (LineType=1 or LineType=2 or LineType=3 or LineType=5) and OpenType='$open' ".$user." order by LineType,Mtype";
		//echo $sql;
		$res_data = mysql_db_query($dbname, $sql);
		$res_cou=mysql_num_rows($res_data);
		$n1c=0;
		$n1s=0;
		$h1c=0;
		$h1s=0;
		$c1c=0;
		$c1s=0;
		$c2c=0;
		$c2s=0;
		$h2c=0;
		$h2s=0;
		$c3c=0;
		$c3s=0;
		$h3c=0;
		$h3s=0;
		$c5c=0;
		$c5s=0;
		$h5c=0;
		$h5s=0;
		$i=1;
		while ($data=mysql_fetch_array($res_data)){
			if ($set_account==1){
				if ($level=='M'){
					$Point=1;//管理员
				}else if ($level=='A'){
					$Point=$data['A_Point']/100;//公司
				}else if ($level=='B'){
					$Point=$data['B_Point']/100;//股东
				}else if ($level=='C'){
					$Point=$data['C_Point']/100;//总代理
				}else if ($level=='D'){
					$Point=$data['D_Point']/100;//代理商
				}
			}else{
				$Point=1;
			}
			$betscore=$data['BetScore']*$Point;
			switch ($data['LineType']){
			case "1":
				if ($data['Mtype']=='MH'){
					$h1c+=$i;
					$h1s+=$betscore+0;
				}else if($data['Mtype']=='MC'){
					$c1c+=$i;
					$c1s+=$betscore+0;
				}else if($data['Mtype']=='MN'){
					$n1c+=$i;
					$n1s+=$betscore+0;
				}
				break;
			case "2":
				if ($data['Mtype']=='RH'){
					$h2c+=$i;
					$h2s+=$betscore+0;
				}else if($data['Mtype']=='RC'){
					$c2c+=$i;
					$c2s+=$betscore+0;
				}			
				break;
			case "3":
				if ($data['Mtype']=='OUC'){
					$h3c+=$i;
					$h3s+=$betscore+0;
				}else if($data['Mtype']=='OUH'){
					$c3c+=$i;
					$c3s+=$betscore+0;
				}	
				break;
			case "5":
				if ($data["Mtype"]=='ODD'){
					$h5c+=$i;
					$h5s+=$betscore+0;
				}else if($data["Mtype"]=='EVEN'){
					$c5c+=$i;
					$c5s+=$betscore+0;
				}	
				break;	
			}
		}	
		if ($row['S_Show']==1){
			$show='Y';
		}else{
			$show='N';
		}
		if ($row['M_Type']==1){
			$running='<br><font color=red>Running Ball</font>';
		}else{
			$running='';
		}
		$date=date('m-d',strtotime($row['M_Date']));
		echo "parent.GameFT[$K]=new Array('$row[MID]','$date<br>$row[M_Time]$running','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$show','$row[M_LetB]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$h2c','$c2c','$h2s','$c2s','$row[MB_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$h3c','$c3c','$h3s','$c3s','$MB_Win_Rate','$TG_Win_Rate','$M_Flat_Rate','$h1c','$c1c','$n1c','$h1s','$c1s','$n1s','$Single','$Double','$S_Single_Rate','$S_Double_Rate','$h5c','$c5c','$h5s','$c5s');\n";
		$K=$K+1;
	}
	break;
case "H":
    $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H,M_LetB_H,MB_LetB_Rate_H,TG_LetB_Rate_H,MB_Dime_H,MB_Dime_Rate_H,TG_Dime_Rate_H,MB_MID,TG_MID,ShowTypeHR,M_Type,H_Show from `match_sports` where Type='".$gtype."' and `M_Start` > now( ) and `H_Show`=1 order by M_Start,$m_league,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$MB_LetB_Rate_H=change_rate($open,$row['MB_LetB_Rate_H']);
		$TG_LetB_Rate_H=change_rate($open,$row['TG_LetB_Rate_H']);
		$MB_Dime_Rate_H=change_rate($open,$row["MB_Dime_Rate_H"]);
		$TG_Dime_Rate_H=change_rate($open,$row["TG_Dime_Rate_H"]);
		$MB_Win_Rate_H=num_rate($open,$row["MB_Win_Rate_H"]);
		$TG_Win_Rate_H=num_rate($open,$row["TG_Win_Rate_H"]);
		$M_Flat_Rate_H=num_rate($open,$row["M_Flat_Rate_H"]);
		$mid=$row['MID'];	
		$sql="select Mtype,LineType,A_Point,B_Point,C_Point,D_Point,BetScore FROM  `web_report_data` where FIND_IN_SET($mid,MID)>0 and (LineType=11 or LineType=12 or LineType=13) and OpenType='$open' ".$user." order by LineType,Mtype";
		$res_data = mysql_db_query($dbname, $sql);
		$n11c=0;
		$n11s=0;
		$h11c=0;
		$h11s=0;
		$c11c=0;
		$c11s=0;
		$c12c=0;
		$c12s=0;
		$h12c=0;
		$h12s=0;
		$c13c=0;
		$c13s=0;
		$h13c=0;
		$h13s=0;			
		$i=1;
		while ($data=mysql_fetch_array($res_data)){
			if ($set_account==1){
				if ($level=='M'){
					$Point=1;//管理员
				}else if ($level=='A'){
					$Point=$data['A_Point']/100;//公司
				}else if ($level=='B'){
					$Point=$data['B_Point']/100;//股东
				}else if ($level=='C'){
					$Point=$data['C_Point']/100;//总代理
				}else if ($level=='D'){
					$Point=$data['D_Point']/100;//代理商
				}
			}else{
				$Point=1;
			}
			$betscore=$data['BetScore']*$Point;
			switch ($data['LineType']){
			case "11":
				if ($data['Mtype']=='VMH'){
					$h11c+=$i;
					$h11s+=$betscore+0;
				}else if($data['Mtype']=='VMC'){
					$c11c+=$i;
					$c11s+=$betscore+0;
				}else if($data['Mtype']=='VMN'){
					$n11c+=$i;
					$n11s+=$betscore+0;
				}
				break;
			case "12":
				if ($data['Mtype']=='VRH'){
					$h12c+=$i;
					$h12s+=$betscore+0;
				}else if($data['Mtype']=='VRC'){
					$c12c+=$i;
					$c12s+=$betscore+0;
				}			
				break;
			case "13":
				if ($data['Mtype']=='VOUC'){
					$h13c+=$i;
					$h13s+=$betscore+0;
				}else if($data['Mtype']=='VOUH'){
					$c13c+=$i;
					$c13s+=$betscore+0;
				}	
				break;		
			}
		}	
		if ($row['H_Show']==1){
			$show='Y';
		}else{
			$show='N';
		}
		if ($row['M_Type']==1){
			$running='<br><font color=red>Running Ball</font>';
		}else{
			$running='';
		}
		$date=date('m-d',strtotime($row['M_Date']));
		echo "parent.GameFT[$K]=new Array('$row[MID]','$date<br>$row[M_Time]$running','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]<font color=gray> - [$Res_Half]</font>','$row[TG_Team]<font color=gray> - [$Res_Half]</font>','$row[ShowTypeHR]','$show','$row[M_LetB_H]','$row[M_LetB_H]','$MB_LetB_Rate_H','$TG_LetB_Rate_H','$h12c','$c12c','$h12s','$c12s','$row[MB_Dime_H]','$TG_Dime_Rate_H','$MB_Dime_Rate_H','$h13c','$c13c','$h13s','$c13s','$MB_Win_Rate_H','$TG_Win_Rate_H','$M_Flat_Rate_H','$h11c','$c11c','$n11c','$h11s','$c11s','$n11s');\n";
		$K=$K+1;	
	}
    break;
case "RB":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate_RB,TG_Win_Rate_RB,M_Flat_Rate_RB,M_LetB_RB,MB_LetB_Rate_RB,TG_LetB_Rate_RB,MB_Dime_RB,MB_Dime_Rate_RB,TG_Dime_Rate_RB,MB_Win_Rate_RB_H,TG_Win_Rate_RB_H,M_Flat_Rate_RB_H,M_LetB_RB_H,MB_LetB_Rate_RB_H,TG_LetB_Rate_RB_H,MB_Dime_RB_H,MB_Dime_Rate_RB_H,TG_Dime_Rate_RB_H,ShowTypeRB,ShowTypeHRB,M_Type,MB_Ball,TG_Ball,RB_Show,MB_MID,TG_MID from `match_sports` where Type='".$gtype."' and `M_Date` ='$m_date' and `M_Start` < now( ) and RB_Show=1 and MB_Inball='' order by M_Start,$m_league,MID";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		
		$mid=$row['MID'];
		$sql="select Mtype,LineType,A_Point,B_Point,C_Point,D_Point,BetScore FROM  `web_report_data` where FIND_IN_SET($mid,MID)>0 and (LineType=9 or LineType=10 or LineType=21 or LineType=19 or LineType=20 or LineType=31) and OpenType='$open' ".$user." order by LineType,Mtype";
		$res_data = mysql_db_query($dbname, $sql);
		$h9c=0;
		$h9s=0;
		$c9c=0;
		$c9s=0;		
		$c10c=0;
		$c10s=0;
		$h10c=0;
		$h10s=0;
		$n21c=0;
		$n21s=0;
		$h21c=0;
		$h21s=0;
		$c21c=0;
		$c21s=0;
		
		$c19c=0;
		$c19s=0;
		$h19c=0;
		$h19s=0;
		$c20c=0;
		$c20s=0;
		$h20c=0;
		$h20s=0;
		$n31c=0;
		$n31s=0;
		$h31c=0;
		$h31s=0;
		$c31c=0;
		$c31s=0;
		
		$i=1;
		while ($data=mysql_fetch_array($res_data)){
			if ($set_account==1){
				if ($level=='M'){
					$Point=1;//管理员
				}else if ($level=='A'){
					$Point=$data['A_Point']/100;//公司
				}else if ($level=='B'){
					$Point=$data['B_Point']/100;//股东
				}else if ($level=='C'){
					$Point=$data['C_Point']/100;//总代理
				}else if ($level=='D'){
					$Point=$data['D_Point']/100;//代理商
				}
			}else{
				$Point=1;
			}
			$betscore=$data['BetScore']*$Point;
			switch ($data['LineType']){
			case "9":
				if ($data['Mtype']=='RRH'){
					$h9c+=$i;
					$h9s+=$betscore+0;
				}else if($data['Mtype']=='RRC'){
					$c9c+=$i;
					$c9s+=$betscore+0;
				}
				break;
			case "10":
				if ($data['Mtype']=='ROUC'){
					$h10c+=$i;
					$h10s+=$betscore+0;
				}else if($data['Mtype']=='ROUH'){
					$c10c+=$i;
					$c10s+=$betscore+0;
				}			
				break;
			case "21":
				if ($data['Mtype']=='RMH'){
					$h21c+=$i;
					$h21s+=$betscore+0;
				}else if($data['Mtype']=='RMC'){
					$c21c+=$i;
					$c21s+=$betscore+0;
				}else if($data['Mtype']=='RMN'){
					$n21c+=$i;
					$n21s+=$betscore+0;
				}
				break;
			case "19":
				if ($data['Mtype']=='VRRH'){
					$h19c+=$i;
					$h19s+=$betscore+0;
				}else if($data['Mtype']=='VRRC'){
					$c19c+=$i;
					$c19s+=$betscore+0;
				}	
				break;
			case "20":
				if ($data['Mtype']=='VROUC'){
					$h20c+=$i;
					$h20s+=$betscore+0;
				}else if($data['Mtype']=='VROUH'){
					$c20c+=$i;
					$c20s+=$betscore+0;
				}	
				break;
			case "31":
				if ($data['Mtype']=='VRMH'){
					$h31c+=$i;
					$h31s+=$betscore+0;
				}else if($data['Mtype']=='VRMC'){
					$c31c+=$i;
					$c31s+=$betscore+0;
				}else if($data['Mtype']=='VRMN'){
					$n31c+=$i;
					$n31s+=$betscore+0;
				}
				break;
			}
		}	
		if ($row['RB_Show']=='1'){
			$show='Y';
		}else{
			$show='N';
		}
		$date=date('m-d',strtotime($row['M_Date']));
		echo "parent.GameFT[$K] = Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeRB]','$show','','','','','$h9c','$c9c','$h9s','$c9s','','','','$h10c','$c10c','$h10s','$c10s','$row[MB_Ball]','$row[TG_Ball]','$row[MID]','','','','','','$h19c','$c19c','$h19s','$c19s','','','','$h20c','$c20c','$h20s','$c20s','','','','$h21c','$h21s','$c21c','$c21s','$n21c','$n21s','','','','$h31c','$h31s','$c31c','$c31s','$n31c','$n31s');\n";
		$K=$K+1;	
	}
	break;
case "PD":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,M_Type,PD_Show from `match_sports` where Type='".$gtype."' and `M_Start` > now( ) and PD_Show=1 order by M_Start,mid";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$mid=$row['MID'];
		$sql="select LineType,A_Point,B_Point,C_Point,D_Point,BetScore FROM  `web_report_data` where FIND_IN_SET($mid,MID)>0 and LineType=4 and OpenType='$open' ".$user." order by LineType";
    	$res_data = mysql_db_query($dbname, $sql);
		$n4c=0;
		$n4s=0;
		$i=1;
		while ($data=mysql_fetch_array($res_data)){
		    if ($set_account==1){
				if ($level=='M'){
					$Point=1;//管理员
				}else if ($level=='A'){
					$Point=$data['A_Point']/100;//公司
				}else if ($level=='B'){
					$Point=$data['B_Point']/100;//股东
				}else if ($level=='C'){
					$Point=$data['C_Point']/100;//总代理
				}else if ($level=='D'){
					$Point=$data['D_Point']/100;//代理商
				}
			}else{
				$Point=1;
			}
			$betscore=$data['BetScore']*$Point;
			$n4c+=$i;
			$n4s+=$betscore+0;
		}
		if ($row['PD_Show']==1){
			$show='Y';
		}else{
			$show='N';
		}
		if ($row['M_Type']==1){
			$running='<br><font color=red>Running Ball</font>';
		}else{
			$running='';
		}
		$date=date('m-d',strtotime($row['M_Date']));
		echo "parent.GameFT[$K] = Array('$row[MID]','$date<br>$row[M_Time]$running','$row[M_League]','$row[MID]','','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$show','$n4c','$n4s');\n";
		$K=$K+1;
		}
	break;
case "HPD":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,M_Type,HPD_Show from `match_sports` where Type='".$gtype."' and `M_Start` > now( ) and HPD_Show=1 order by M_Start,mid";
    $result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$mid=$row['MID'];
		$sql="select LineType,A_Point,B_Point,C_Point,D_Point,BetScore FROM  `web_report_data` where FIND_IN_SET($mid,MID)>0 and LineType=14 and OpenType='$open' ".$user." order by LineType";
    	$res_data = mysql_db_query($dbname, $sql);
		$n14c=0;
		$n14s=0;
		$i=1;
		while ($data=mysql_fetch_array($res_data)){
		    if ($set_account==1){
				if ($level=='M'){
					$Point=1;//管理员
				}else if ($level=='A'){
					$Point=$data['A_Point']/100;//公司
				}else if ($level=='B'){
					$Point=$data['B_Point']/100;//股东
				}else if ($level=='C'){
					$Point=$data['C_Point']/100;//总代理
				}else if ($level=='D'){
					$Point=$data['D_Point']/100;//代理商
				}
			}else{
				$Point=1;
			}
			$betscore=$data['BetScore']*$Point;
			$n14c+=$i;
			$n14s+=$betscore+0;
		}
		if ($row['HPD_Show']==1){
			$show='Y';
		}else{
			$show='N';
		}
		if ($row['M_Type']==1){
			$running='<br><font color=red>Running Ball</font>';
		}else{
			$running='';
		}
		$date=date('m-d',strtotime($row['M_Date']));
		echo "parent.GameFT[$K] = Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MID]','','$row[MB_Team]<font color=gray> - [$Res_Half]</font>','$row[TG_Team]<font color=gray> - [$Res_Half]</font>','$row[ShowTypeR]','$show','$n14c','$n14s');\n";
		$K=$K+1;
		}
	break;
case "T":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,S_0_1,S_2_3,S_4_6,S_7UP,MB_MID,TG_MID,ShowTypeR,T_Show from `match_sports` where Type='".$gtype."' and `M_Start` > now( ) and T_Show=1 order by M_Start,mid";	
    $result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$S_Single_Rate=num_rate($open,$row['S_Single_Rate']);
		$S_Double_Rate=num_rate($open,$row['S_Double_Rate']);
		$mid=$row['MID'];
		$sql="select Mtype,LineType,A_Point,B_Point,C_Point,D_Point,BetScore FROM  `web_report_data` where FIND_IN_SET($mid,MID)>0 and LineType=6 and OpenType='$open' ".$user." order by LineType,Mtype";
		$res_data = mysql_db_query($dbname, $sql);
		$h51c=0;
		$h51s=0;
		$h52c=0;
		$h52s=0;
		$h53c=0;
		$h53s=0;
		$h54c=0;
		$h54s=0;
		$h55c=0;
		$h55s=0;
		$h56c=0;
		$h56s=0;
		$i=1;
		while ($data=mysql_fetch_array($res_data)){
		    if ($set_account==1){
				if ($level=='M'){
					$Point=1;//管理员
				}else if ($level=='A'){
					$Point=$data['A_Point']/100;//公司
				}else if ($level=='B'){
					$Point=$data['B_Point']/100;//股东
				}else if ($level=='C'){
					$Point=$data['C_Point']/100;//总代理
				}else if ($level=='D'){
					$Point=$data['D_Point']/100;//代理商
				}
			}else{
				$Point=1;
			}
			$betscore=$data['BetScore']*$Point;
			if ($data["Mtype"]=='0~1'){
				$h53c+=$i;
				$h53s+=$betscore+0;
			}else if($data["Mtype"]=='2~3'){
				$h54c+=$i;
				$h54s+=$betscore+0;
			}else if($data["Mtype"]=='4~6'){
				$h55c+=$i;
				$h55s+=$betscore+0;
			}else if($data["Mtype"]=='OVER'){
				$h56c+=$i;
				$h56s+=$betscore+0;
			}
		}
		if ($row['T_Show']==1){
			$show='Y';
		}else{
			$show='N';
		}
		$date=date('m-d',strtotime($row['M_Date']));
		echo "parent.GameFT[$K] = Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MID]','','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$S_Single_Rate','$h52c','$h52s','$S_Double_Rate','$h51c','$h51s','$row[S_0_1]','$h53c','$h53s','$row[S_2_3]','$h54c','$h54s','$row[S_4_6]','$h55c','$h55s','$row[S_7UP]','$h56c','$h56s');\n";
		$K=$K+1;	
	}
	break;
case "F":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_MID,TG_MID,M_Type,ShowTypeR,F_Show from `match_sports` where Type='".$gtype."' and `M_Start` > now( ) and F_Show=1 order by M_Start,mid";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$mid=$row['MID'];
		$sql="select LineType,A_Point,B_Point,C_Point,D_Point,BetScore FROM  `web_report_data` where FIND_IN_SET($mid,MID)>0 and LineType=7 and OpenType='$open' ".$user." order by LineType";
		//echo $sql;
		$res_data = mysql_db_query($dbname, $sql);
		$n7c=0;
		$n7s=0;
		$i=1;
		while ($data=mysql_fetch_array($res_data)){
		    if ($set_account==1){
				if ($level=='M'){
					$Point=1;//管理员
				}else if ($level=='A'){
					$Point=$data['A_Point']/100;//公司
				}else if ($level=='B'){
					$Point=$data['B_Point']/100;//股东
				}else if ($level=='C'){
					$Point=$data['C_Point']/100;//总代理
				}else if ($level=='D'){
					$Point=$data['D_Point']/100;//代理商
				}
			}else{
				$Point=1;
			}
			$betscore=$data['BetScore']*$Point;
			$n7c+=$i;
			$n7s+=$betscore+0;
		}
		if ($row['F_Show']==1){
			$show="Y";
		}else{
			$show="N" ;
		}
		if ($row['M_Type']==1){
			$running='<br><font color=red>Running Ball</font>';
		}else{
			$running='';
		}
		$date=date('m-d',strtotime($row['M_Date']));
		echo "parent.GameFT[$K] = Array('$row[MID]','$date<br>$row[M_Time]$running','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','$show','$n7c','$n7s');\n";
		$K=$K+1;
	}
	break;
case "P":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_MID,TG_MID,ShowTypeP,P3_Show from `match_sports` where Type='".$gtype."' and `M_Start` > now( ) and P3_Show=1 order by M_Start,mid";	
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$n1c=0;
		$n1s=0;
		$h1c=0;
		$h1s=0;
		$c1c=0;
		$c1s=0;
		$n8c=0;
		$n8s=0;
		$mid=$row['MID'];
		$sql="select MID,Mtype,LineType,D_Point,count(*) as cou,sum(BetScore) as BetScore FROM  `web_report_data` where FIND_IN_SET($mid,MID)>0 and  `M_Date` ='".$m_date."' and LineType=8 and OpenType='$open' and Agents='".$username."' group by LineType,Mtype order by LineType,Mtype";
		//echo $sql;
		$res_data = mysql_db_query($dbname, $sql);
		while ($data=mysql_fetch_array($res_data)){;
			$pdata=explode(",",$data['MID']);
			$place=explode(",",$data['Mtype']);
			$cou=count($place);
			for ($i=0;$i<$cou;$i++){
			     if ($pdata[$i]==$mid){
				     /*switch ($place[$i]){
				         case "MH":
					         $h1c=$h1c+$data["cou"]+0;
					         $h1s=$h1s+$data["BetScore"]+0;
					         break;
				         case "MC":
					         $c1c=$c1c+$data["cou"]+0;
					         $c1s=$c1s+$data["BetScore"]+0;
					         break;
				         case "MN":
					         $n1c=$n1c+$data["cou"]+0;
					         $n1s=$n1s+$data["BetScore"]+0;
					         break;
				     }*/
					 $n8c=$n8c+$data["cou"]+0;
					 $n8s=$n8s+$data["BetScore"]+0;
			     }
			}
			
		}
		if ($row['P3_Show']==1){
			$show="Y";
		}else{
			$show="N" ;
		}
		$date=date('m-d',strtotime($row['M_Date']));
		echo "parent.GameFT[$K] = Array('$row[MID]','$date<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeP]','$show','$h1c','$c1c','$n1c','$h1s','$c1s','$n1s','$n8c','$n8s');\n";
		$K=$K+1;
		}
	break;
case "PL":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowTypeR,M_Type,MB_Inball from `match_sports` where Type='".$gtype."' and `M_Date` ='$m_date' and `M_Start` < now() order by M_Start,$m_league,MB_MID";
	$result = mysql_db_query($dbname, $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=60;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*60;	
	$mysql=$mysql."  limit $offset,$num";
	//echo $mysql;	
	$result = mysql_db_query($dbname, $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);
		$mid=$row['MID'];	
		$sql="select Mtype,LineType,A_Point,B_Point,C_Point,D_Point,BetScore FROM  `web_report_data` where FIND_IN_SET($mid,MID)>0 and OpenType='$open' ".$user." order by LineType,Mtype";	
		$res_data = mysql_db_query($dbname, $sql);
		
		$h2c=0;
		$h2s=0;
		$c2c=0;
		$c2s=0;
		
		$h3c=0;
		$h3s=0;
		$c3c=0;
		$c3s=0;

		$h9c=0;
		$h9s=0;
		$c9c=0;
		$c9s=0;
		
		$h10c=0;
		$h10s=0;
		$c10c=0;
		$c10s=0;
		
		$h53c=0;
		$h53s=0;
		$c53c=0;
		$c53s=0;
		
		$i=1;
		while ($data=mysql_fetch_array($res_data)){
			if ($set_account==1){
				if ($level=='M'){
					$Point=1;//管理员
				}else if ($level=='A'){
					$Point=$data['A_Point']/100;//公司
				}else if ($level=='B'){
					$Point=$data['B_Point']/100;//股东
				}else if ($level=='C'){
					$Point=$data['C_Point']/100;//总代理
				}else if ($level=='D'){
					$Point=$data['D_Point']/100;//代理商
				}
			}else{
				$Point=1;
			}
			$betscore=$data['BetScore']*$Point;
			switch ($data["LineType"]){
			case "2":
				if ($data["Mtype"]=='RH'){
					$h2c+=$i;
					$h2s+=$betscore+0;
				}else if($data["Mtype"]=='RC'){
					$c2c+=$i;
					$c2s+=$betscore+0;
				}			
				break;
			case "3":
				if ($data["Mtype"]=='OUH'){
					$h3c+=$i;
					$h3s+=$betscore+0;
				}else if($data["Mtype"]=='OUC'){
					$c3c+=$i;
					$c3s+=$betscore+0;
				}	
				break;
			case "9":
				if ($data["Mtype"]=='RRH'){
					$h9c+=$i;
					$h9s+=$betscore+0;
				}else if($data["Mtype"]=='RRC'){
					$c9c+=$i;
					$c9s+=$betscore+0;
				}			
				break;
			case "10":
				if ($data["Mtype"]=='ROUH'){
					$h53c+=$i;
					$h53s+=$betscore+0;
				}else if($data["Mtype"]=='ROUC'){
					$c53c+=$i;
					$c53s+=$betscore+0;
				}	
				break;		
			}
		}
		if ($row['M_Type']==1){
			$running='<br><font color=red>Running Ball</font>';
		}else{
			$running='';
		}
		if ($row['MB_Inball']==''){
			$show='N';
		}else{
			$show='Y';
		}
		$date=date('m-d',strtotime($row['M_Date']));
		echo "parent.GameFT[$K]=new Array('$row[MID]','$date<br>$row[M_Time]$running','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowTypeR]','','$row[M_LetB]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$h2c','$c2c','$h2s','$c2s','$h9c','$c9c','$h9s','$c9s','$h3c','$c3c','$h3s','$c3s','','','','','','','','','','','','','','','','','','','','','','','','','','','$h53c','$c53c','$h53s','$c53s','$show');\n";
		$K=$K+1;
		}
	break;
}
?>
parent.show_page();
function onLoad(){
	if(parent.retime > 0){
		parent.retime_flag = "Y";
	}else{
		parent.retime_flag = "N";
	}
	parent.loading_var = "N";
	if(parent.loading == "N" && parent.ShowType != ""){
		parent.ShowGameList();
		obj_layer = parent.body_browse.document.getElementById("LoadLayer");
		obj_layer.style.display = "none";
	}
}
</script>
</head>
<body bgcolor="#000000" onLoad="onLoad()">
</body>
</html>
