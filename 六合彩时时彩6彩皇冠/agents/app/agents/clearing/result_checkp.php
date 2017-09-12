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
          <td width="100" align="center">可赢金额</td>
          <td width="50" align="center">退水</td>
          <td width="100" align="center">实际金额</td>
        </tr>
<?
$field_count=0;
$mysql="select ID,Active,M_Name,LineType,OpenType,BetTime,ShowType,Mtype,Gwin,TurnRate,BetType,M_Place,M_Rate,$middle as Middle,BetScore,A_Rate,B_Rate,C_Rate,D_Rate,A_Point,B_Point,C_Point,D_Point,Pay_Type,Checked from web_report_data where FIND_IN_SET($gid,MID)>0 and Active=9 and Cancel!=1 order by linetype,mtype";
$result = mysql_query($mysql);
while ($row = mysql_fetch_array($result)){		
$time=strtotime($row['BetTime']);
$times=date("Y-m-d",$time).'<br>'.date("H:i:s",$time);
?> 
        <tr class="m_cen"> 
          <td align="center"><font color="#CC0000"><?=$times?></font></td>
          <td align="center"><?=$row['M_Name']?><br><font color="#cc0000"><?=$row['OpenType']?></font>&nbsp;&nbsp;<font color="#cc0000"><?=$row['TurnRate']?></font></td>
          <td align="center"><?=$betinfo?><?=$row['BetType']?><br><font color="#0000CC"><?=show_voucher($row['LineType'],$row['ID'])?></font></td>
          <td><?=$row['Middle']?></td>
          <td><?=$row['BetScore']?></td>
          <td><font color="#CC0000"><?=$row['Gwin']?></font></td>
          <td align="center"><?=$row['BetScore']*$row['TurnRate']/100?></td>
          <td align="center"><?=$row['D_Point']?>/<?=$row['C_Point']?>/<?=$row['B_Point']?>/<?=$row['A_Point']?></td>
        </tr>
<?
$field_count=$field_count+1;
}
?>
</table>     
</BODY>
</html>
