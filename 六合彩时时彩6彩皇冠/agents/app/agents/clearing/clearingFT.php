<?
include ("../include/address.mem.php");
require ("../include/config.inc.php");
require ("../include/define_function.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_system_data where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$date=date('Y-m-d');
$gtype=$_REQUEST['gtype'];
$gid=$_REQUEST['gid'];
$mb_in_score=$_REQUEST['mb_inball'];
$tg_in_score=$_REQUEST['tg_inball'];
$mb_in_score_v=$_REQUEST['mb_inball_v'];
$tg_in_score_v=$_REQUEST['tg_inball_v'];
//需直接传递过来比分：上半和全场，可根据实际情况分别分批传递
?>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<META content="Microsoft FrontPage 4.0" name=GENERATOR>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<form name="myform" method="post" action="../score/finish_score.php?uid=<?=$uid?>&gid=<?=$gid?>&gtype=<?=$gtype?>&langx=<?=$langx?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="m_tline" width="150">&nbsp;&nbsp;日期：<?=$date?></td>
    <td class="m_tline" width="200">主队：上半场:<font color=red>(<?=$mb_in_score_v?>)</font>全场:<font color=red>(<?=$mb_in_score?>)</font></td>
    <td class="m_tline" width="613">客队：上半场:<font color=red>(<?=$tg_in_score_v?>)</font>全场:<font color=red>(<?=$tg_in_score?>)</font></td>
    <td width="32"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="3" height="4"></td>
  </tr>
</table>
<table width="975" border="0" cellspacing="1" cellpadding="0" class="m_tab">
        <tr class="m_title"> 
          <td width="30" align="center">发布</td>
          <td width="90" align="center">投注时间</td>
          <td width="80" align="center">用户名称</td>
          <td width="100" align="center">球赛种类</td>
          <td width="355" align="center">內容</td>
          <td width="70" align="center">投注</td>
          <td width="100" align="center">占成结果</td>
          <td width="40" align="center">退水</td>
          <td width="100" align="center">实际金额</td>
        </tr>
<?
$field_count=0;
$mysql="select ID,Active,M_Name,LineType,OpenType,BetTime,OddsType,ShowType,Mtype,Gwin,TurnRate,BetType,M_Place,M_Rate,$middle as Middle,BetScore,A_Rate,B_Rate,C_Rate,D_Rate,A_Point,B_Point,C_Point,D_Point,Pay_Type,Checked from web_report_data where FIND_IN_SET($gid,MID)>0 and (Active=1 or Active=11) and LineType!=8 and Cancel!=1 and Checked=0 order by linetype,mtype";
$result = mysql_query($mysql);
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
		case 21:
			$graded=win_chk_rb($mb_in_score,$tg_in_score,$row['Mtype']);
			break;
		case 31:
			$graded=win_chk_vrb($mb_in_score_v,$tg_in_score_v,$row['Mtype']);
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
		$agent=$g_res*1+1*$row['D_Rate']/100*$row['BetScore']*abs($graded);//公司退水帐目
			
		if($mb_in_score<0 and $mb_in_score_v<0){
	       if ($row['Checked']==0){	
		       if ($row['Pay_Type']==1){
				   $cash=$row['BetScore'];
				   $mysql="update web_member_data set Money=Money+$cash where UserName='$user'";
				   mysql_query($mysql) or die ("error!");
		       }
	  	   }		
           $sql="update web_report_data set VGOLD='0',M_Result='0',D_Result='0',C_Result='0',B_Result='0',A_Result='0',T_Result='0',Cancel=1,Checked=1,Confirmed='$mb_in_score' where MID='$gid' and (active=1 or active=11) and LineType!=8";
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
		$mysql="update match_sports set Score=1 where Type='FT' and MID='$gid'";
		mysql_query($mysql) or die ("error!!");

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
?> 
        <tr class="m_cen"> 
          <td><input type="checkbox" name="check<?=$field_count?>" value="ON" checked></td>
          <td><font color="#cc0000"><?=$times?></font></td>
          <td><?=$row['M_Name']?><br><font color="#cc0000"><?=$row['OpenType']?></font>&nbsp;&nbsp;<font color="#cc0000"><?=$row['TurnRate']?></font></td>
          <td><?=$Mnu_Soccer?><?=$row['BetType']?><?=$Odds?><br><font color="#0000CC"><?=show_voucher($row['LineType'],$row['ID'])?></font></td>
          <td align="right"><?=$row['Middle']?></td>
          <td align="right"><?=$row['BetScore']?></td>
          <td><?=$d_point?>/<?=$c_point?>/<?=$b_point?>/<?=$a_point?></td>
          <td><?=$turn?></td>
          <td width="100" height="22"><p align="center">
          <input name="txtres<?=$field_count?>" size="10" value="<?=$g_res+$turn?>" class="za_text">
          <input type="hidden" name="agents<?=$field_count?>" size="8" value="<?=$agents?>" class="za_text">
          <input type="hidden" name="world<?=$field_count?>" size="8" value="<?=$world?>" class="za_text">
          <input type="hidden" name="corprator<?=$field_count?>" size="8" value="<?=$corprator?>" class="za_text">
          <input type="hidden" name="paytype<?=$field_count?>" size="8" value="<?=$row['pay_type']?>" class="za_text">
          <input type="hidden" name="username<?=$field_count?>" size="8" value="<?=$row['memname']?>" class="za_text">
          <input type="hidden" name="betscore<?=$field_count?>" size="8" value="<?=$row['BetScore']?>" class="za_text">
          <input type="hidden" name="txtnum<?=$field_count?>" size="8" value="<?=$row['id']?>" class="za_text">
          </p></td>
        </tr>
<?
$field_count=$field_count+1;
}
?>
  </table>
<p align="center">　<br>
<input type="submit" value=" 提 交 " name="subject" class="za_button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       
<input type="reset" value=" 返 回 " name="cancel" class="za_button">
<input type="hidden" name="mb_inball" value="<?=$mb_in_score?>">   
<input type="hidden" name="tg_inball" value="<?=$tg_in_score?>">   
<input type="hidden" name="tg_inball_v" value="<?=$tg_in_score_v?>">   
<input type="hidden" name="mb_inball_v" value="<?=$mb_in_score_v?>">   
<input type="hidden" name="gtype" value="<?=$gtype?>">
<input type="hidden" name="gid" value="<?=$gid?>">  
</form>       
</BODY>
</html>
