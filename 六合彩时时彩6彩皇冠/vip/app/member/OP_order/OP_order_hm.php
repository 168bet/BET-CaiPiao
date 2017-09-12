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
$type=$_REQUEST['type'];
$gnum=$_REQUEST['gnum'];
$odd_f_type=$_REQUEST['odd_f_type'];
$change=$_REQUEST['change'];
if($userid<=0){
		header( "Content-Type:   text/html;   charset=UTF-8 ");
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';</script>\n";	
}
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
$btset=singleset('M');
$GMIN_SINGLE=$btset[0];
$GMAX_SINGLE=$row['OP_M_Scene'];
$GSINGLE_CREDIT=$row['OP_M_Bet'];
$open=$row['OpenType'];
$langx=$row['Language'];
require ("../include/traditional.$langx.inc.php");
if ($change==1){
	$bet_title=$nobettitle;
}
$mysql = "select M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H from `match_sports` where Type='OP' and `m_start`>now() and `MID`='$gid' and Cancel!=1 and Open=1 and $mb_team!=''";
$result = mysql_query($mysql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit;
}else{

	if ($row['M_Date']==date('Y-m-d')){
		$active=6;
		$class="OOP";
		$caption=$Order_Other.$Order_1st_Half_1_x_2_betting_order;
	}else{
		$active=66;
		$class="OOM";
		$caption=$Order_Other.$Order_Early_Market.$Order_1st_Half_1_x_2_betting_order;
	} 
	$M_League=$row['M_League']; 
	$MB_Team=$row["MB_Team"];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($MB_Team);	
	switch ($type){ 
	case "H": 
		$M_Place=$MB_Team; 
		$M_Rate=num_rate($open,$row["MB_Win_Rate_H"]);
		$mtype='VMH'; 
		break; 
	case "C": 
		$M_Place=$TG_Team; 
		$M_Rate=num_rate($open,$row["TG_Win_Rate_H"]);
		$mtype='VMC';
		break; 
	case "N": 
		$M_Place=$Draw;
		$M_Rate=num_rate($open,$row["M_Flat_Rate_H"]); 
		$mtype='VMN';
		break; 
	} 
	$havesql="select sum(BetScore) as BetScore from web_report_data where M_Name='$memname' and MID='$gid' and LineType=11 and Mtype='$mtype' and (Active=1 or Active=11)";
	$result = mysql_query($havesql); 
	$haverow = mysql_fetch_array($result); 
	$have_bet=$haverow['BetScore']+0; 
	
    $sql = "select * from match_league where  $m_league='$M_League' and Type='OP'";
    $result = mysql_query($sql);
    $league = mysql_fetch_array($result);
    $bettop=$league['VM'];
	
	if ($M_Rate==0){
	    echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	    exit;
	}
	if ($bettop<$GSINGLE_CREDIT){
		$bettop_money=$bettop;
	}else{
		$bettop_money=$GSINGLE_CREDIT;
	}
	$bettop_money=$GSINGLE_CREDIT;
?>
<html>
<head>
<title>op_hm_order</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
</head>
<body id="<?=$class?>" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<script language="JavaScript" src="/js/football_order<?=$js?>.js"></script>
<form name="LAYOUTFORM" action="/app/member/OP_order/OP_order_finish.php" method="post" onSubmit="return false">
  <div class="ord">
    <span><h1><?=$caption?></h1></span>
    <div id="info">
      <p><?=$Order_Login_Name?><?=$memname?></p>
      <p><?=$Order_Credit_line?><?=$credit?></p>
      <p><?=$Order_Currency?><?=$curtype?></p>
      <p class="error"><?=str_replace("<*****>",$bettop_money,$Order_There_is_a_maximum_wager_limit_on_this_game_x_restriction)?><?=$bet_title?></p>
      <p class="team"><?=$M_League?>&nbsp;-&nbsp;<FONT color=red><b>[<?=$Order_1st_Half?>]</b></font>&nbsp;<?=date('m-d',strtotime($row["M_Date"]))?><br><?=$MB_Team?>&nbsp;&nbsp;<font color=#CC0000>VS.</font>&nbsp;<?=$TG_Team?><br><em><?=$M_Place?></em>&nbsp;@&nbsp;<strong><?=$M_Rate?></strong></p>
      <p><?=$Order_Bet_Amount?><input type="text" id="gold" name="gold" size="8" maxlength="10" onKeyPress="return CheckKey()" onKeyUp="return CountWinGold1()" class="txt"></p>
      <p><?=$Order_Estimated_Payout?><font id="pc">0</font></p>
      <p><?=$Order_Minimum?><?=$GMIN_SINGLE?></p>
      <p><?=$Order_Single_bet_limit?><?=$GSINGLE_CREDIT?></p>
      <p><?=$Order_Maximum?><?=$GMAX_SINGLE?></p>
    </div>
  </div>
  <div id="gWager" style="display: none;position: absolute;"></div>
  <div id="gbutton" style="display: block;position: absolute;"></div>

  <div class="foot">
    <input type="button" name="btnCancel" value="<?=$Order_Cancel?>" onClick="self.location='../select.php?uid=<?=$uid?>'" class="no">
    <input type="button" name="Submit" value="<?=$Order_Confirm?>" onClick="CountWinGold1();return SubChk();" class="yes">
  </div>

  <div id="gfoot" style="display: block;position: absolute;"></div>

  <div class="ord" id="line_window" style="display: none;position: absolute;">
    <div class="chk" id="gdiv_table">
      *SHOW_STR*<br>
      <input type="button" name="wgCancel" value="<?=$Order_Cancel?>" onClick="Close_div();" class="no">
      <input type="button" name="wgSubmit" value="<?=$Order_Confirm?>" onmousedown='Sure_wager();' class="yes">
    </div>
  </div>  
<input type="hidden" name="uid" value="<?=$uid?>">
<input type="hidden" name="active" value="<?=$active?>">
<input type="hidden" name="line_type" value="11">
<input type="hidden" name="gid" value="<?=$gid?>"> 
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="gnum" value="<?=$gnum?>">
<input type="hidden" name="concede_h" value="1">
<input type="hidden" name="radio_h" value="100">
<input type="hidden" id="ioradio_r_h" name="ioradio_r_h" value="<?=$M_Rate?>">
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
