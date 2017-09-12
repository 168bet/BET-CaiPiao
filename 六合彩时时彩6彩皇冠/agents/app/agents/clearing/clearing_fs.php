<?php
require ("../include/config.inc.php");
require ("../include/define_function.php");
$mysql = "select * from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$settime=$row['udp_ft_score'];
$time=$row['udp_ft_results'];
$date=date('Y-m-d',time()-$time*60*60);
$mDate=date('Y-m-d',time()-$time*60*60);
$mmysql = "select * from `match_crown` where date_format(M_Start,'%Y-%m-%d')='$mDate'  and Score=0 order by M_Start,MID";

$mresult1 = mysql_query($mmysql);
while ($mrow=mysql_fetch_array($mresult1)){
	   $gid=$mrow['MID'];
	   $ShowType=$mrow['Gid'];
	$mysql="select ID,Active,M_Name,LineType,OpenType,BetTime,OddsType,ShowType,Mtype,Gwin,TurnRate,BetType,M_Place,M_Rate,Middle,BetScore,A_Rate,B_Rate,C_Rate,D_Rate,A_Point,B_Point,C_Point,D_Point,Pay_Type,Checked from web_report_data where FIND_IN_SET($gid,MID)>0 and FIND_IN_SET('$ShowType',ShowType)>0  and Active=7 and LineType!=8 and Cancel!=1 order by LineType";

	$result = mysql_query( $mysql);
	while ($row = mysql_fetch_array($result)){
		$mtype=$row['Mtype'];
		$id=$row['ID'];
		$user=$row['M_Name'];
		$graded=$mrow['win'];
		switch ($graded){
		case 1:
			$g_res=$row['Gwin'];
			break;
		case -1:
			$g_res=-$row['BetScore'];
			break;
		default:
			$g_res=0;
			break;
		}
		//echo $row['BetScore'];
		$vgold=abs($graded)*$row['BetScore'];
		$betscore=$row['BetScore'];
		$turn=abs($graded)*$row['BetScore']*$row['TurnRate']/100;
		$d_point=$row['D_Point']/100;
		$c_point=$row['C_Point']/100;
		$b_point=$row['B_Point']/100;
		$a_point=$row['A_Point']/100;
		
		$members=$g_res+$turn;//和会员结帐的金额
		$agents=$g_res*(1-$d_point)+(1-$d_point)*$row['D_Rate']/100*$row['BetScore']*abs($graded);//上缴总代理结帐的金额
		$world=$g_res*(1-$c_point-$d_point)+(1-$c_point-$d_point)*$row['C_Rate']/100*$row['BetScore']*abs($graded);//上缴股东结帐
		if (1-$b_point-$c_point-$d_point!=0){
		$corprator=$g_res*(1-$b_point-$c_point-$d_point)+(1-$b_point-$c_point-$d_point)*$row['B_Rate']/100*$row['BetScore']*abs($graded);//上缴公司结帐
		}else{
		$corprator=$g_res*($b_point+$a_point)+($b_point+$a_point)*$row['B_Rate']/100*$row['BetScore']*abs($graded);//和公司结帐
		}
		$super=$g_res*$a_point+$a_point*$row['A_Rate']/100*$row['BetScore']*abs($graded);//和公司结帐
		$agent=$g_res*1+1*$row['D_Rate']/100*$row['BetScore']*abs($graded);//公司退水帐目
		

	       if ($row['Checked']==0){	
		       if ($row['Pay_Type']==1){
				   $cash=$row['BetScore']+$members;
				   $mysql="update web_member_data set Money=Money+$cash where UserName='$user'";
				  // echo  $mysql."<br>";
				   mysql_query($mysql) or die ("error!");
		       }
	  	   }
		   $sql="update web_report_data set VGOLD='$vgold',M_Result='$members',D_Result='$agents',C_Result='$world',B_Result='$corprator',A_Result='$super',T_Result='$agent',Checked=1 where ID='$id'";
		   mysql_query($sql) or die ("error!");
		   //echo '<font color=white>'.$row['BetTime'].'</font><br>'.$row['M_Name'].'--<font color=red>('.$members.')</font><br>';	
	}
	$mysql="update match_crown set Score=1 where MID='$gid'";
	mysql_query($mysql) or die ("error!!");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>足球结算</title>
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
	<input type=button name=button value="足球刷新" onClick="window.location.reload()"></td>  
  </tr>
</table>
</body>
</html>
