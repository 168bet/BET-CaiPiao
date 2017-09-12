<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
if($userid<=0){
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';</script>\n";	
}

$gid=$_REQUEST['gid'];
$rtype=$_REQUEST['rtype'];
$odd_f_type=$_REQUEST['odd_f_type'];
$change=$_REQUEST['change'];
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
$btset=singleset('T');
$GMIN_SINGLE=$btset[0];
$GMAX_SINGLE=$row['TN_EO_Scene']; 
$GSINGLE_CREDIT=$row['TN_EO_Bet']; 
$open=$row['OpenType'];
$langx=$row['Language'];
require ("../include/traditional.$langx.inc.php");
if ($change==1){
	$bet_title=$nobettitle;
}
$mysql = "select M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,S_Single_Rate,S_Double_Rate from `match_sports` where Type='TN' and `m_start`>now() and `MID`='$gid' and Cancel!=1 and Open=1 and $mb_team!=''";
$result = mysql_query($mysql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit;
}else{

	if ($row['M_Date']==date('Y-m-d')){
		$active=4;
		$class="OTN";
		$like=$Order_TN;
	}else{
		$active=44;
		$class="OTU";
		$like=$Order_TN.$Order_Early_Market;
	} 
	$M_League=$row['M_League'];  
	$MB_Team=$row["MB_Team"];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($MB_Team);
	switch ($rtype){ 
	case "ODD": 
		$M_Place="(".$Order_Odd.")"; 
		$M_Rate=num_rate($open,$row["S_Single_Rate"]);
		$GMAX_SINGLE=$GMAX_SINGLE; 
		$GSINGLE_CREDIT=$GSINGLE_CREDIT; 
		$caption=$Order_Odd_Even_betting_order; 
		$linetype=5; 
		break; 
	case "EVEN": 
		$M_Place="(".$Order_Even.")"; 
		$M_Rate=num_rate($open,$row["S_Double_Rate"]);
		$GMAX_SINGLE=$GMAX_SINGLE; 
		$GSINGLE_CREDIT=$GSINGLE_CREDIT; 
		$caption=$Order_Odd_Even_betting_order; 
		$linetype=5; 
		break; 
	} 
	$havesql="select sum(BetScore) as BetScore from web_report_data where m_name='$memname' and MID='$gid' and linetype='$linetype' and (Active=4 or Active=44)";
	$result = mysql_query($havesql); 
	$haverow = mysql_fetch_array($result); 
	$have_bet=$haverow['BetScore']+0; 
	
    if ($rtype=='ODD' or $rtype=='EVEN'){
        $sql = "select * from match_league where  $m_league='$M_League' and Type='TN'";
        $result = mysql_query($sql);
        $league = mysql_fetch_array($result);
        $bettop=$league['EO'];
    }
	if ($bettop<$GSINGLE_CREDIT){
		$bettop_money=$GSINGLE_CREDIT;
	}else{
		$bettop_money=$GSINGLE_CREDIT;
	}
	$bettop_money=$GSINGLE_CREDIT;
?>
<html>
<head>
<title>tn_t_order</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">

</head>
<body id="<?=$class?>" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<script language="JavaScript" src="/js/ft_pd_order<?=$js?>.js"></script>
<form name="LAYOUTFORM" action="/app/member/TN_order/TN_order_finish.php" method="post" onSubmit="return false">
  <div class="ord">
    <span><h1><?=$like?><?=$caption?></h1></span>
    <div id="info">
      <p><?=$Order_Login_Name?><?=$memname?></p>
      <p><?=$Order_Credit_line?><?=$credit?></p>
      <p><?=$Order_Currency?><?=$curtype?></p>
      <p class="error"><?=$text?><?=str_replace("<*****>",$bettop_money,$Order_There_is_a_maximum_wager_limit_on_this_game_x_restriction)?><?=$bet_title?></p>
      <p class="team"><?=$M_League?>&nbsp;&nbsp;<?=date('m-d',strtotime($row["M_Date"]))?><br><?=$MB_Team?>&nbsp;<font color=#CC0000>VS.</font>&nbsp;<?=$TG_Team?><br><em><?=$M_Place?></em>&nbsp;@&nbsp;<strong><?=$M_Rate?></strong></p>
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
<input type="hidden" name="rtype" value="<?=$rtype?>">
<input type="hidden" name="ordertype" value="1">
<input type="hidden" name="line_type" value="<?=$linetype?>">
<input type="hidden" name="gid" value="<?=$gid?>">
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
