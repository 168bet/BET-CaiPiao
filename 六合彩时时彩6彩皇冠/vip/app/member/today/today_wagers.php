<?
session_start();
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
include "../include/login_session.php";
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
$chk_cw=$_REQUEST['chk_cw'];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid' and Status<2";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$name=$row['UserName'];
if ($chk_cw=='' or $chk_cw=='Y'){
	$chk_cw='N';
	$display='Y';
	$ncancel=" and Cancel=0 and M_Result='' ";
	$caption=$Tod_Watch_Canceled_Wagers;
}else{
	$chk_cw='Y';
	$display='N';
	$ncancel=" and Cancel=1 and M_Date='".date('Y-m-d')."'";	
	$caption=$Tod_Watch_Normal_Wagers;
}
$mDate=date('Y-m-d');
$sql = "select ID,LineType,Active,M_Date,BetTime,$middle as Middle,$bettype as BetType,BetScore,Gwin,OddsType,Cancel,Danger,Confirmed from web_report_data where M_Name='$name' ".$ncancel." order by orderby,BetTime desc";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
?>
<html>
<head>
<title>today_wagers</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body<?=$css?>.css" type="text/css">

<style type="text/css">
<!--
.b_rig_mor { background-color:#EDEDED; text-align:right }
<? if ($langx=='en-ue' or $langx=='th-tis'){ ?>
#MFT #box { width:730px;}
#MFT .explain { white-space: normal!important;}
<? } ?>
-->
</style>
<script>
function wagers_sta(cw){
	self.location='./today_wagers.php?uid=<?=$uid?>&langx=<?=$langx?>&chk_cw='+cw;
}
</script>
</head>

<body id="MFT" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td id="ad">

<span class="real_msg"><marquee scrolldelay="120"><?=$mem_msg?></marquee></span>
<p><a href="javascript://" onClick="javascript: window.open('../scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','menubar=no,status=yes,scrollbars=yes,top=150,left=200,toolbar=no,width=510,height=500')"><?=$News_History?></a></p>

</td>
  </tr>
  <tr>
    <td class="top">
  	  <h1><em><?=$Transaction_Record?></em><input type="button" value="<?=$caption?>" class="" onClick="wagers_sta('<?=$chk_cw?>');"><span class="rig"><input type="button" value="六合交易状况" class="" onClick="location.href='/app/member/six/index.php?action=h';"></span>
  	  </h1>
	</td>
  </tr>
  <tr>
    <td class="mem">
    <table border="0" cellspacing="1" cellpadding="0" class="game">
<?
if($cou==0){
?>
      <tr> 
        <td height="70" class="b_cen"><?=$Tod_text?></td>
      </tr>
<?
}else{
?>
      <tr> 
        <th width="9%"><?=$Tod_Betting_Time?></th>
        <th width="13%"><?=$Tod_Wager_No?></th>
        <th width="54%"><?=$Tod_Explain?></th>
        <th width="12%"><?=$Tod_Quinella?></th>
        <th width="12%"><?=$Tod_Estimated_Payout?></th>
      </tr>
<?
$tod_num=0;
$tod_bet=0;
$tod_win=0;
while ($row = mysql_fetch_array($result)){
$time=strtotime($row['BetTime']);
$times=date("m-d",$time).'<br>'.date("H:i:s",$time);
switch($row['Active']){
case 1:
	$Title=$Tod_Soccer;
	break;
case 11:
	$Title=$Tod_Soccer;
	break;
case 2:
	$Title=$Tod_Basketball;
	break;
case 22:
	$Title=$Tod_Basketball;
	break;
case 3:
	$Title=$Tod_Baseball;
	break;
case 33:
	$Title=$Tod_Baseball;
	break;
case 4:
	$Title=$Tod_Tennis;
	break;
case 44:
	$Title=$Tod_Tennis;
	break;
case 5:
	$Title=$Tod_VolleyBall;
	break;
case 55:
	$Title=$Tod_VolleyBall;
	break;
case 6:
	$Title=$Tod_Other;
	break;
case 66:
	$Title=$Tod_Other;
	break;
case 7:
	$Title=$Tod_Outright;
	break;
}

switch ($row['OddsType']){
case 'H':
    $Odds='<BR><font color =green>'.$Tod_HK.'</font>';
	break;
case 'M':
    $Odds='<BR><font color =green>'.$Tod_Malay.'</font>';
	break;
case 'I':
    $Odds='<BR><font color =green>'.$Tod_Indo.'</font>';
	break;
case 'E':
    $Odds='<BR><font color =green>'.$Tod_Euro.'</font>';
	break;
case '':
    $Odds='';
	break;
}
switch($row['Confirmed']){
case -1:
$zt=$Score21;
break;
case -2:
$zt=$Score22;
break;
case -3:
$zt=$Score23;
break;
case -4:
$zt=$Score24;
break;
case -5:
$zt=$Score25;
break;
case -6:
$zt=$Score26;
break;
case -7:
$zt=$Score27;
break;
case -8:
$zt=$Score28;
break;
case -9:
$zt=$Score29;
break;
case -10:
$zt=$Score30;
break;
case -11:
$zt=$Score31;
break;
case -12:
$zt=$Score32;
break;
case -13:
$zt=$Score33;
break;
case -14:
$zt=$Score34;
break;
case -15:
$zt=$Score35;
break;
case -16:
$zt=$Score36;
break;
case -17:
$zt=$Score37;
break;
case -18:
$zt=$Score38;
break;
case -19:
$zt=$Score39;
break;
case -20:
$zt=$Score40;
break;
case -21:
$zt=$Score41;
break;
}
if ($row['M_Date']>$mDate){
	$tDate='<b>'.$row['M_Date'].'</b>';
	if ($row['LineType']==7 or $row['LineType']==8){
		$middle="<font color=#000000>".$tDate."</font>&nbsp;&nbsp;&nbsp;".$row['Middle'];
	}else{
		if ($row['active']!=6){
			$data1=explode("<br>",$row['Middle']);
			$middle=$data1[0].'<br>';
			$middle=$middle."<font color=#000000>$tDate</font>&nbsp;&nbsp;&nbsp;";
			for($j=1;$j<sizeof($data1);$j++){
				$middle=$middle.$data1[$j].'<br>';
			}
		}else{
			$data1=explode("<br>",$row['Middle']);
				
			$middle="<font color=#000000>$tDate</font>&nbsp;&nbsp;&nbsp;";
			for($j=0;$j<sizeof($data1);$j++){
				$middle=$middle.$data1[$j].'<br>';
			}
		}
	}
	$mor='_mor';	
}else{
	$mor='';
	$middle=$row['Middle'];
}
if ($row['Danger']==1 or $row['LineType']==9 or $row['LineType']==19 or $row['LineType']==10 or $row['LineType']==20 or $row['LineType']==21 or $row['LineType']==31 and $row['Cancel']==0){
	if ($row['Danger']==1 and $row['Cancel']==0){
        $type="<br><font color='#FFFFFF'><span style='background-color: #FF0000'><b>&nbsp;".$Order_Pending."&nbsp;</b></span></font>";
    }else if ($row['Danger']==0 and $row['Cancel']==0){
        $type="<br><font color='#FFFFFF'><span style='background-color: #FF0000'><b>&nbsp;".$Order_Confirmed."&nbsp;</b></span></font>";
	}
	$datetime="<font color='#FFFFFF'><span style='background-color: #FF0000'>".$times."</span></font>";
}else if ($row['Danger']==0){
	$datetime=$times;
	$type='';
}
if ($row['Cancel']==1){
	$win="<font color=#cc0000><b>".$zt."</b></font>";
}else{
	$win=number_format($row['Gwin'],2);
}
?>
      <tr class="b_rig<?=$mor?>">
        <td align="center"><?=$datetime?></td>
        <td align="center"><?=$Title?><?=$row['BetType']?><?=$Odds?><br><font color="#0000CC"><?=show_voucher($row['LineType'],$row['ID'])?></font><font color="#CC0000"><B><?=$type?></B></font></td>
        <td class="explain"><?=$middle?></td>
        <td><?=$row['BetScore']?></td>
        <td><?=$win?></td>
      </tr>
<?
$tod_win=$tod_win+$row['Gwin'];
$tod_num=$tod_num+1;
$tod_bet=$tod_bet+$row['BetScore'];
$tDate='';
}
?>
      <tr class="b_rig">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?=$tod_num?></td>
        <td bgcolor="#CCCCCC"><?=$tod_bet?></td>
        <td bgcolor="#990000"><font color="#FFFFFF"><?=number_format($tod_win,2)?></font></td>
      </tr>
<?
}
?>	  
    </table> 
	</td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>


<div id="copyright"><?=$Copyright?></div>
</body>
</html>
