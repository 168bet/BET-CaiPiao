<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$rtype=$_REQUEST['rtype'];
$odd_f_type=$_REQUEST['odd_f_type'];
//print_r($_REQUEST);
$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	setcookie('login_uid','');
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$memname=$row['UserName'];
$credit=$row['Money'];
$curtype=$row['CurType'];
$pay_type=$row['Pay_Type'];
$btset=singleset('PD');
$GMIN_SINGLE=$btset[0];
$GMAX_SINGLE=$row['FT_PD_Scene'];
$GSINGLE_CREDIT=$row['FT_PD_Bet'];
$open=$row['OpenType'];
$langx=$row['Language'];
require ("../include/traditional.$langx.inc.php");

$mysql = "select M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MBPDH1,MBPDH2,MBPDH3,MBPDH4,MBPDH5,MBPDH6,MBPDH7,MBPDH8,MBPDH9,TGPDC1,TGPDC2,TGPDC3,TGPDC4,TGPDC5,TGPDC6,TGPDC7,TGPDC8,TGPDC9 from `match_sports` where `M_Start`>now() and `MID`=$gid and Cancel!=1 and Open=1 and MB_Team!='' and MB_Team_tw!='' and MB_Team_en!=''";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit;
}else{
	
	if ($row['M_Date']==date('Y-m-d')){
		$active=3;
		$class="OBS";
		$caption=$Order_BS.$Order_Correct_Score_betting_order;
	}else{
		$active=33;
		$class="OBE";
		$caption=$Order_BS.$Order_Early_Market.$Order_Correct_Score_betting_order;
	}
	$M_League=$row['M_League'];
	$MB_Team=$row["MB_Team"];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($MB_Team);
	$M_Sign="VS.";
	$Sign=str_replace("PDH","+",$rtype);
	$Sign=str_replace("PDC","+",$Sign);
	$type=$rtype{2};
	if ($type=='H'){
		$M_Place=$MB_Team.$Sign;
	}else if ($type=='C'){
		$M_Place=$TG_Team.$Sign;
	}
	$Rate=str_replace("PDH","MBPDH",$rtype);
	$Rate=str_replace("PDC","TGPDC",$Rate);
	$M_Rate=$row[$Rate];
	
	$havesql="select sum(BetScore) as BetScore from web_report_data where m_name='$memname' and MID='$gid' and linetype=4 and (Active=3 or Active=33)";
	$result = mysql_query($havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;
	
    $sql = "select * from match_league where  $m_league='$M_League' and Type='BS'";
    $result = mysql_query($sql);
    $league = mysql_fetch_array($result);
    $bettop=$league['PD'];
	
	if ($bettop<$GSINGLE_CREDIT){
		$bettop_money=$bettop;
	}else{
		$bettop_money=$GSINGLE_CREDIT;
	}
	$bettop_money=$GSINGLE_CREDIT;
?>
<html>
<head>
<title>ft_pd_order</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
</head>
<body id="<?=$class?>" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<script language="JavaScript" src="/js/ft_pd_order<?=$js?>.js"></script>
<form name="LAYOUTFORM" action="/app/member/BS_order/BS_order_finish.php" method="post" onSubmit="return false">
  <div class="ord">
    <span><h1><?=$caption?></h1></span>
    <div id="info">
      <p><?=$Order_Login_Name?><?=$memname?></p>
      <p><?=$Order_Credit_line?><?=$credit?></p>
      <p><?=$Order_Currency?><?=$curtype?></p>
      <p class="error"><?=$Order_The_maximum_payout_is_x_per_bet?><br><?=str_replace("<*****>",$bettop_money,$Order_There_is_a_maximum_wager_limit_on_this_game_x_restriction)?></p>
      <p class="team"><?=$M_League?>&nbsp;&nbsp;<?=date('m-d',strtotime($row["M_Date"]))?><br><?=$MB_Team?>&nbsp;<font color=#CC0000><?=$M_Sign?></font>&nbsp;<?=$TG_Team?><br><em><?=$M_Place?></em>&nbsp;@&nbsp;<strong><?=$M_Rate?></strong></p>
      <p><?=$Order_Bet_Amount?><input type="text" id="gold" name="gold" size="8" maxlength="10" onKeyPress="return CheckKey()" onKeyUp="return CountWinGold()" class="txt"></p>
      <p><?=$Order_Estimated_Payout?><font id="pc">0</font></p>
      <p><?=$Order_Minimum?><?=$GMIN_SINGLE?></p>
      <p><?=$Order_Single_bet_limit?><?=$GSINGLE_CREDIT?></p>
      <p><?=$Order_Maximum?><?=$GMAX_SINGLE?></p>
    <p class="foot">
      <input type="button" name="btnCancel" value="<?=$Order_Cancel?>" onClick="self.location='../select.php?uid=<?=$uid?>'" class="no">
      <input type="button" name="Submit" value="<?=$Order_Confirm?>" onClick="CountWinGold();return SubChk();" class="yes">
    </p>
<div id="gfoot"></div>      
    </div>
  </div>  
<input type="hidden" name="uid" value="<?=$uid?>">
<input type="hidden" name="active" value="<?=$active?>">
<input type="hidden" name="line_type" value="4">
<input type="hidden" name="gid" value="<?=$gid?>">
<input type="hidden" name="type" value="">
<input type="hidden" name="rtype" value="<?=$rtype?>">
<input type="hidden" name="gnum" value="">
<input type="hidden" name="concede" value="<?=$M_Sign?>">
<input type="hidden" id="ioradio_pd" name="ioradio_pd" value="<?=$M_Rate?>">
<input type="hidden" name="gmax_single" value="<?=$bettop_money?>">
<input type="hidden" name="gmin_single" value="<?=$GMIN_SINGLE?>">
<input type="hidden" name="singlecredit" value="<?=$GMAX_SINGLE?>">
<input type="hidden" name="singleorder" value="<?=$GSINGLE_CREDIT?>">
<input type="hidden" name="restsinglecredit" value="<?=$have_bet?>">
<input type="hidden" name="wagerstotal" value="<?=$GMAX_SINGLE?>">
<input type="hidden" name="restcredit" value="<?=$credit?>">
<input type="hidden" name="pay_type" value="<?=$pay_type?>">
<input type="hidden" name="odd_f_type" value="<?=$odd_f_type?>">
</form>
</body>
<SCRIPT LANGUAGE="JavaScript">document.all.gold.focus();</script>
</html>
<? 
mysql_close();
} 
?>
