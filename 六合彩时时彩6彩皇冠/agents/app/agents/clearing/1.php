<?
require ("../include/config.inc.php");
require ("../include/define_function.php");
$mysql = "select * from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$settime=$row['udp_bk_score'];
$time=$row['udp_bk_results'];
$date="2011-1-11";
$mysql="select ID,MID,Active,M_Name,LineType,OpenType,BetTime,ShowType,Mtype,Gwin,TurnRate,BetType,M_Place,M_Rate,Middle,BetScore,A_Rate,B_Rate,C_Rate,D_Rate,A_Point,B_Point,C_Point,D_Point,Pay_Type,Checked from web_report_data where M_Date='$date' and LineType=8 and (Active=2 or Active=22) and cancel=0";
$result = mysql_query( $mysql);
while ($row = mysql_fetch_array($result)){
$k++;	
	$notgraded=0;
	$id=$row['ID'];
	$user=$row['M_Name'];
	$winrate=1;
	
	echo 'Time:'.$row['BetTime'].'<br>';
	echo '<br>'.$row['Middle'].'<br>';
	echo 'Mtype:'.$row['Mtype'].'<br>';
	echo 'Show:'.$row['ShowType'].'<br>';
	echo 'Place:'.$row['M_Place'].'<br>';
	$mid=explode(',',$row['MID']);
	$mtype=explode(',',$row['Mtype']);
	$rate=explode(',',$row['M_Rate']);
	$letb=explode(',',$row['M_Place']);
	$show=explode(',',$row['ShowType']);
	$cou=sizeof($mid);
	$count=0;
	for($i=0;$i<$cou;$i++){
		$sql="select MB_Inball,TG_Inball from match_sports where Type='BK' and M_Date='$date' and MID=".$mid[$i];
		$result1 = mysql_query( $sql);
		$rowr = mysql_fetch_array($result1);
		$mb_in=$rowr['MB_Inball'];
		$tg_in=$rowr['TG_Inball'];
		if ($show[$i]=='H'){
		    echo $mb_in.'-'.$tg_in.'<br>';
		}else{
		    echo $tg_in.'-'.$mb_in.'<br>';
		}
		if ($mb_in=='' or $tg_in==''){
			$graded="99";
			$notgraded=1;
			echo '<font color=white>还有未完场赛事</font><br>';
			echo '<font color=white>'.$row['BetTime'].'-'.$row['M_Name'].'</font><br><br>';
			break;
		}else if ($mb_in<0){
			$graded=88;
		}else{
			$abc=strtolower(substr($letb[$i],0,1));
			$abcd=strtolower(substr($letb[$i],0,2));
			if ($abcd=='od' or $abc=='ev'){
				$graded=odds_eo($mb_in,$tg_in,$mtype[$i]);
			}else if($abc=='o' or $abc=='u'){
			    $graded=odds_dime($mb_in,$tg_in,$letb[$i],$mtype[$i]);
			}else{
				$graded=odds_letb($mb_in,$tg_in,$show[$i],$letb[$i],$mtype[$i]);
			}
		}	
		echo $graded.'<br>';
		switch ($graded){
			case "1":
				$winrate=$winrate*($rate[$i]);
				break;
			case "-1":
				$winrate=0;
				break;
			case "0":
				$winrate=$winrate;
				break;
			case "0.5":					
				$winrate=$winrate*(($rate[$i]-1)*0.5+1);
				break;
			case "-0.5":
				$winrate=$winrate*0.5;
				break;
			case "99":
				$winrate=$winrate;
				break;
			case "88":
				$winrate=$winrate;
				break;
			}
			if ($graded==-1){
				$winrate=0;
				$notgraded=0;
				break;
		}
	}

	
	if ($notgraded==0){	
	    $g_res=$row['BetScore']*(abs($winrate)-1);	
		$vgold=$row['BetScore'];
		$turn=$row['BetScore']*$row['TurnRate']/100;
		$d_point=$row['D_Point']/100;
		$c_point=$row['C_Point']/100;
		$b_point=$row['B_Point']/100;
		$a_point=$row['A_Point']/100;

		$members=$g_res+$turn;//和会员结帐的金额
		$agents=$g_res*(1-$d_point)+(1-$d_point)*$row['D_Rate']/100*$row['BetScore'];//上缴总代理结帐的金额
		$world=$g_res*(1-$c_point-$d_point)+(1-$c_point-$d_point)*$row['C_Rate']/100*$row['BetScore'];//上缴股东结帐
		if (1-$b_point-$c_point-$d_point!=0){
		$corprator=$g_res*(1-$b_point-$c_point-$d_point)+(1-$b_point-$c_point-$d_point)*$row['B_Rate']/100*$row['BetScore'];//上缴公司结帐
		}else{
		$corprator=$g_res*($b_point+$a_point)+($b_point+$a_point)*$row['B_Rate']/100*$row['BetScore'];//和公司结帐
		}
		$super=$g_res*$a_point+$a_point*$row['A_Rate']/100*$row['BetScore'];//和公司结帐
		$agent=$g_res+$row['D_Rate']/100*$row['BetScore'];//代理商退水总帐目
		
	    if ($row['Checked']==0){	
		    if ($row['Pay_Type']==1){
				$cash=$row['BetScore']+$members;
				$mysql="update web_member_data set Money=Money+$cash where UserName='$user'";
				mysql_query($mysql) or die ("error!");
		    }
	  	}
		$sql="update web_report_data set VGOLD='$vgold',M_Result='$members',D_Result='$agents',C_Result='$world',B_Result='$corprator',A_Result='$super',T_Result='$agent',Checked=1 where ID='$id'";
		mysql_query($sql) or die ("error!");
		echo '<font color=white>'.$row['BetTime'].'--'.$row['M_Name'].'--</font><font color=red>('.$members.')</font><br><br>';	
	}else{
		$sql="update web_report_data set VGOLD='',M_Result='',D_Result='',C_Result='',B_Result='',A_Result='',T_Result='' where ID='$id'";
		mysql_query($sql) or die ("error!!");
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>篮球过关结算</title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
<script> 
<!-- 
var limit="<?=$settime?>" 
if (document.images){ 
	var parselimit=limit
} 
function beginrefresh(){ 
if (!document.images) 
	return 
if (parselimit==1) 
	window.location.reload() 
else{ 
	parselimit-=1 
	curmin=Math.floor(parselimit) 
	if (curmin!=0) 
		curtime=curmin+"秒后自动获取最新数据！" 
	else 
		curtime=cursec+"秒后自动获取最新数据！" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 

window.onload=beginrefresh 
file:
//--> 
</script>
<body>
<table width="220" height="190" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="220" height="190" align="center"><?=$date?><br><br><span id="timeinfo"></span><br>
	<input type=button name=button value="篮球过关刷新" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
