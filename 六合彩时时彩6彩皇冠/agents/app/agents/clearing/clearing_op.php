<?php
require ("../include/config.inc.php");
require ("../include/define_function.php");
$mysql = "select * from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$settime=$row['udp_op_score'];
$time=$row['udp_op_results'];
$date=date('Y-m-d',time()-$time*60*60);
$mDate=date('Y-m-d',time()-$time*60*60);
$mmysql = "select MID,MB_MID,TG_MID,MB_Team,TG_Team,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from `match_sports` where `Type`='OP' and `M_Date` ='$mDate' and MB_Inball!='' and Score=0 order by M_Start,MID";	
$mresult1 = mysql_query($mmysql);
while ($mrow=mysql_fetch_array($mresult1)){
	   $gid=$mrow['MID'];
	   $mb_in_score=$mrow['MB_Inball'];
	   $tg_in_score=$mrow['TG_Inball'];
	   $mb_in_score_v=$mrow['MB_Inball_HR'];
	   $tg_in_score_v=$mrow['TG_Inball_HR'];	
	$mysql="select ID,Active,M_Name,LineType,OpenType,BetTime,OddsType,ShowType,Mtype,Gwin,TurnRate,BetType,M_Place,M_Rate,Middle,BetScore,A_Rate,B_Rate,C_Rate,D_Rate,A_Point,B_Point,C_Point,D_Point,Pay_Type,Checked from web_report_data where FIND_IN_SET($gid,MID)>0 and (Active=6 or Active=66) and LineType!=8 and Cancel!=1 order by LineType";
	$result = mysql_query( $mysql);
	while ($row = mysql_fetch_array($result)){
		$mtype=$row['Mtype'];
		$id=$row['ID'];
		$user=$row['M_Name'];
		switch ($row['LineType']){
		case 1:
			$graded=win_chk($mb_in_score,$tg_in_score,$row['Mtype']);
			break;
		case 2:
			$graded=odds_letb($mb_in_score,$tg_in_score,$row['ShowType'],$row['M_Place'],$row['Mtype']);
			break;
		case 3:
			$graded=odds_dime($mb_in_score,$tg_in_score,$row['M_Place'],$row['Mtype']);
			break;
		case 4:
			$graded=odds_pd($mb_in_score,$tg_in_score,$row['Mtype']);
			break;		
		case 5:
			$graded=odds_eo($mb_in_score,$tg_in_score,$row['Mtype']);
			break;	
		case 6:
			$graded=odds_t($mb_in_score,$tg_in_score,$row['Mtype']);
			break;
		case 7:
			$graded=odds_half($mb_in_score_v,$tg_in_score_v,$mb_in_score,$tg_in_score,$row['Mtype']);
			break;
		case 9:
			$score=explode('<FONT color=red><b>',$row['Middle']);
			$msg=explode("</b></FONT><br>",$score[1]);
			$bcd=explode(":",$msg[0]);
			$m_in=$bcd[0];
			$t_in=$bcd[1];
			if ($row['ShowType']=='H'){
				$mbinscore1=$mb_in_score-$m_in;
				$tginscore1=$tg_in_score-$t_in;
			}else{
				$mbinscore1=$mb_in_score-$t_in;
				$tginscore1=$tg_in_score-$m_in;
			}
			$graded=odds_letb_rb($mbinscore1,$tginscore1,$row['ShowType'],$row['M_Place'],$row['Mtype']);
			break;
		case 19:
			$score=explode('<FONT color=red><b>',$row['Middle']);
			$msg=explode("</b></FONT><br>",$score[1]);
			$bcd=explode(":",$msg[0]);
			$m_in=$bcd[0];
			$t_in=$bcd[1];
			if ($row['ShowType']=='H'){
				$mbinscore1=$mb_in_score_v-$m_in;
				$tginscore1=$tg_in_score_v-$t_in;
			}else{
				$mbinscore1=$mb_in_score_v-$t_in;
				$tginscore1=$tg_in_score_v-$m_in;
			}
			$graded=odds_letb_vrb($mbinscore1,$tginscore1,$row['ShowType'],$row['M_Place'],$row['Mtype']);
			break;	
		case 10:
			$graded=odds_dime_rb($mb_in_score,$tg_in_score,$row['M_Place'],$row['Mtype']);	
			break;
		case 20:
			$graded=odds_dime_vrb($mb_in_score_v,$tg_in_score_v,$row['M_Place'],$row['Mtype']);	
			break;
		case 11:
			$graded=win_chk_v($mb_in_score_v,$tg_in_score_v,$row['Mtype']);
			break;
		case 12:
			$graded=odds_letb_v($mb_in_score_v,$tg_in_score_v,$row['ShowType'],$row['M_Place'],$row['Mtype']);
			break;
		case 13:
			$graded=odds_dime_v($mb_in_score_v,$tg_in_score_v,$row['M_Place'],$row['Mtype']);
			break;
		case 14:
			$graded=odds_pd_v($mb_in_score_v,$tg_in_score_v,$row['Mtype']);
			break;
		}
		if ($row['M_Rate']<0){
			$num=str_replace("-","",$row['M_Rate']);
		}else if ($row['M_Rate']>0){
			$num=1;
		}
		switch ($graded){
		case 1:
			$g_res=$row['Gwin'];
			break;
		case 0.5:
			$g_res=$row['Gwin']*0.5;
			break;
		case -0.5:
			$g_res=-$row['BetScore']*0.5*$num;
			break;
		case -1:
			$g_res=-$row['BetScore']*$num;
			break;
		case 0:
			$g_res=0;
			break;
		}
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
		$agent=$g_res+$row['D_Rate']/100*$row['BetScore']*abs($graded);//公司退水帐目
		
		if($mb_in_score<0 and $mb_in_score_v<0){
	       if ($row['Checked']==0){	
		       if ($row['Pay_Type']==1){
				   $cash=$row['BetScore'];
				   $mysql="update web_member_data set Money=Money+$cash where UserName='$user'";
				   mysql_query($mysql) or die ("error!");
		       }
	  	   }		
           $sql="update web_report_data set VGOLD='0',M_Result='0',D_Result='0',C_Result='0',B_Result='0',A_Result='0',T_Result='0',Cancel=1,Checked=1,Confirmed='$mb_in_score' where MID='$gid' and (active=6 or active=66) and LineType!=8";
		}else{
	       if ($row['Checked']==0){	
		       if ($row['Pay_Type']==1){
				   $cash=$row['BetScore']+$members;
				   $mysql="update web_member_data set Money=Money+$cash where UserName='$user'";
				   mysql_query($mysql) or die ("error!");
		       }
	  	   }
		   $sql="update web_report_data set VGOLD='$vgold',M_Result='$members',D_Result='$agents',C_Result='$world',B_Result='$corprator',A_Result='$super',T_Result='$agent',Checked=1 where ID='$id'";
		}
		mysql_query($sql) or die ("error!");
		echo '<font color=white>'.$row['BetTime'].'</font><br>'.$row['M_Name'].'--<font color=red>('.$members.')</font><br>';
	}
	$mysql="update match_sports set Score=1 where Type='OP' and MID='$gid'";
	mysql_query($mysql) or die ("error!!");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>其他结算</title>
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
	<input type=button name=button value="其他刷新" onClick="window.location.reload()"></td>  
  </tr>
</table>
</body>
</html>
