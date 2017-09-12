<?
include ("../include/address.mem.php");
require ("../include/config.inc.php");
require ("../include/define_function_six.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$gid=$_REQUEST['gid'];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_system_data where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$mysql = "select * from number_result where ID='$gid'";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$num01=$row['Num_01'];
$num02=$row['Num_02'];
$num03=$row['Num_03'];
$num04=$row['Num_04'];
$num05=$row['Num_05'];
$num06=$row['Num_06'];
$num07=$row['Num_07'];
?>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<META content="Microsoft FrontPage 4.0" name=GENERATOR>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="m_tline" width="1341">&nbsp;&nbsp;日期：<?=$row['M_Date']?>&nbsp;&nbsp;六合彩第<?=$gid?>期开奖号&nbsp;&nbsp;正码：<?=$num01?> , <?=$num02?> , <?=$num03?> , <?=$num04?> , <?=$num05?> , <?=$num06?>&nbsp;&nbsp;特码：<?=$num07?></td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="975" border="0" cellspacing="1" cellpadding="0" class="m_tab">
        <tr class="m_title"> 
          <td width="80" align="center">投注时间</td>
          <td width="80" align="center">用户名称</td>
          <td width="100" align="center">球赛种类</td>
          <td width="376" align="center">內容</td>
          <td width="80" align="center">投注</td>
          <td width="100" align="center">占成结果</td>
          <td width="50" align="center">退水</td>
          <td width="100" align="center">实际金额</td>
        </tr>
<?
$field_count=0;
$mysql="select ID,Active,M_Name,LineType,OpenType,BetTime,ShowType,Mtype,Gwin,TurnRate,BetType,M_Place,M_Rate,$middle as Middle,BetScore,A_Rate,B_Rate,C_Rate,D_Rate,A_Point,B_Point,C_Point,D_Point,Pay_Type,Checked from web_report_data where FIND_IN_SET($gid,MID)>0 and Active=9 and Cancel!=1 order by LineType,Mtype";
$result = mysql_query($mysql);
	while ($row = mysql_fetch_array($result)){
		$mtype=$row['Mtype'];
		$m_place=$row['M_Place'];
		$id=$row['ID'];
		$user=$row['M_Name'];
		switch ($row['LineType']){
		case 1:
			$graded=sc_win($num07,$mtype);//特码A
			break;
		case 2:
			$graded=sc_win($num07,$mtype);//特码B
			break;
		case 3:
			$graded=ac_win($num01,$num02,$num03,$num04,$num05,$num06,$num07,$mtype);//正码总大小单双
			break;
		case 4:
			$graded=ac_6_win($num01,$num02,$num03,$num04,$num05,$num06,$mtype);//正码1-6
			break;
		case 5:
			$graded=sx_win($num07,$mtype);//生肖
			break;							
		case 6:
			$graded=hw_win($num07,$mtype);//半波
			break;	
		case 7:
			$graded=mt_win($num01,$num02,$num03,$num04,$num05,$num06,$num07,$mtype);//多肖尾数
			break;				
		case 8:
			$graded=m_win($num07,$m_place);//多肖
			break;					
		case 9:
			$graded=ec_win($num01,$num02,$num03,$num04,$num05,$num06,$num07,$mtype,$m_place);//连码
			break;
		}
		switch ($graded){
		case 1:
			$g_res=$row['BetScore']*$row['M_Rate']-$row['BetScore'];
			break;
		case -1:
			$g_res=-$row['BetScore'];
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
		
$time=strtotime($row['BetTime']);
$times=date("Y-m-d",$time).'<br>'.date("H:i:s",$time);
?> 
        <tr class="m_cen"> 
          <td><font color="#cc0000"><?=$times?></font></td>
          <td><?=$row['M_Name']?><br><font color="#cc0000"><?=$row['OpenType']?></font>&nbsp;&nbsp;<font color="#cc0000"><?=$row['TurnRate']?></font></td>
          <td><?=$betinfo?><?=$row['BetType']?><br><font color="#0000CC"><?=show_voucher($row['LineType'],$row['ID'])?></font></td>
          <td align="right"><?=$row['Middle']?></td>
          <td align="right"><?=$row['BetScore']?></td>
          <td><?=$d_point?>/<?=$c_point?>/<?=$b_point?>/<?=$a_point?></td>
          <td><?=$turn?></td>
          <td><font color="#CC0000"><?=number_format($g_res+$turn,2)?></font></td>
        </tr>
<?
$field_count=$field_count+1;
}
?>
</table>     
</BODY>
</html>
