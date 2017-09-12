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
$langx=$_SESSION['langx'];
$gid=$_REQUEST['gid'];
$rtype=$_REQUEST['rtype'];
$odd_f_type=$_REQUEST['odd_f_type'];
$change=$_REQUEST['change'];
if($userid<=0){
		header( "Content-Type:   text/html;   charset=UTF-8 ");
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';</script>\n";	
}
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$memname=$row['UserName'];
$credit=$row['Money'];
$curtype=$row['CurType'];
$pay_type=$row['Pay_Type'];
$btset=singleset('F');
$GMIN_SINGLE=$btset[0];
$GMAX_SINGLE=$row['FT_F_Scene'];
$GSINGLE_CREDIT=$row['FT_F_Bet'];
$open=$row['OpenType'];
if ($change==1){
	$bet_title=$nobettitle;
}
$mysql = "select M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MBMB,MBFT,MBTG,FTMB,FTFT,FTTG,TGMB,TGFT,TGTG from `match_sports` where `M_Start`>now() and `MID`=$gid and Cancel!=1 and Open=1 and $mb_team!=''";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit;
}else{
	
	if ($row['M_Date']==date('Y-m-d')){
		$active=1;
		$class="OFT";
		$caption=$Order_FT.$Order_Half_Full_Time_betting_order;
	}else{
		$active=11;
		$class="OFU";
		$caption=$Order_FT.$Order_Early_Market.$Order_Half_Full_Time_betting_order;
	}
	$M_League=$row['M_League'];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($row["MB_Team"]);
	switch ($rtype){
	case "FHH":
		$M_Place=$MB_Team.'&nbsp;/&nbsp;'.$MB_Team;
		$M_Rate=$row["MBMB"];
		break;
	case "FHN":
		$M_Place=$MB_Team.'&nbsp;/&nbsp;'.$Draw;
		$M_Rate=$row["MBFT"];
		break;
	case "FHC":
		$M_Place=$MB_Team.'&nbsp;/&nbsp;'.$TG_Team;
		$M_Rate=$row["MBTG"];
		break;
	case "FNH":
		$M_Place=$Draw.'&nbsp;/&nbsp;'.$MB_Team;
		$M_Rate=$row["FTMB"];
		break;
	case "FNN":
		$M_Place=$Draw.'&nbsp;/&nbsp;'.$Draw;		
		$M_Rate=$row["FTFT"];
		break;
	case "FNC":
		$M_Place=$Draw.'&nbsp;/&nbsp;'.$TG_Team;		
		$M_Rate=$row["FTTG"];
		break;
	case "FCH":
		$M_Place=$TG_Team.'&nbsp;/&nbsp;'.$MB_Team;		
		$M_Rate=$row["TGMB"];
		break;
	case "FCN":
		$M_Place=$TG_Team.'&nbsp;/&nbsp;'.$Draw;
		$M_Rate=$row["TGFT"];
		break;
	case "FCC":
		$M_Place=$TG_Team.'&nbsp;/&nbsp;'.$TG_Team;
		$M_Rate=$row["TGTG"];
		break;
	}
	$havesql="select sum(BetScore) as BetScore from web_report_data where m_name='$memname' and MID='$gid' and linetype=7 and (Active=1 or Active=11)";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;
	
    $sql = "select * from match_league where  $m_league='$M_League'";
    $result = mysql_db_query($dbname,$sql);
    $league = mysql_fetch_array($result);
    //$bettop=$league['F'];
	$bettop=$GSINGLE_CREDIT;
	
	if ($bettop<$GSINGLE_CREDIT){
		$bettop_money=$bettop;
	}else{
		$bettop_money=$GSINGLE_CREDIT;
	}
	
?>
<html>
<head>
<title>ft_f_order</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
</head>
<body id="<?=$class?>" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<script language="JavaScript" src="/js/ft_f_order<?=$js?>.js"></script>
<form name="LAYOUTFORM" action="/app/member/FT_order/FT_order_finish.php" method="post" onSubmit="return false">
  <div class="ord">
    <span><h1><?=$caption?></h1></span>
    <div id="info">
      <p><?=$Order_Login_Name?><?=$memname?></p>
      <p><?=$Order_Credit_line?><?=$credit?></p>
      <p><?=$Order_Currency?><?=$curtype?></p>
      <p class="error"><?=$Order_The_maximum_payout_is_x_per_bet?></p>
      <p class="error"><?=str_replace("<*****>",$bettop_money,$Order_There_is_a_maximum_wager_limit_on_this_game_x_restriction)?><?=$bet_title?></p>
      <p class="team"><?=$M_League?>&nbsp;&nbsp;<?=date('m-d',strtotime($row["M_Date"]))?><br><?=$MB_Team?>&nbsp;<font color=#CC0000>VS.</font>&nbsp;<?=$TG_Team?><br><em><?=$M_Place?></em>&nbsp;@&nbsp;<strong><?=$M_Rate?></strong></p>
      <p><?=$Order_Bet_Amount?><input type="text" id="gold" name="gold" size="8" maxlength="10" onKeyPress="return CheckKey()" onKeyUp="return CountWinGold()" class="txt"></p>
      <p><?=$Order_Estimated_Payout?><font id="pc">0</font></p>
      <p><?=$Order_Minimum?><?=$GMIN_SINGLE?></p>
      <p><?=$Order_Single_bet_limit?><?=$GSINGLE_CREDIT?></p>
      <p><?=$Order_Maximum?><?=$GMAX_SINGLE?></p>
    </div>
    <p class="foot">
      <input type="button" name="btnCancel" value="<?=$Order_Cancel?>" onClick="self.location='../select.php?uid=<?=$uid?>'" class="no">
      <input type="button" name="Submit" value="<?=$Order_Confirm?>" onClick="CountWinGold();return SubChk();" class="yes">
    </p>
  </div>  
<input type="hidden" name="uid" value="<?=$uid?>">
<input type="hidden" name="active" value="<?=$active?>">
<input type="hidden" name="line_type" value="7">
<input type="hidden" name="gid" value="<?=$gid?>">
<input type="hidden" name="type" value="">
<input type="hidden" name="rtype" value="<?=$rtype?>">
<input type="hidden" name="gnum" value="">
<input type="hidden" id="ioradio_f" name="ioradio_f" value="<?=$M_Rate?>">
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