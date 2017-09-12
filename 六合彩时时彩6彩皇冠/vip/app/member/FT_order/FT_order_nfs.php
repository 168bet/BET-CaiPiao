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
$langx=$_SESSION['langx'];
if($userid<=0){
		echo "<script>alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';</script>\n";	
}

$gid=$_REQUEST['gid'];
$rtype=$_REQUEST['rtype']; 
$wtype=$_REQUEST['wtype'];
$gametype=$_REQUEST['gametype']; 
$change=$_REQUEST['change'];

require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_query($sql);
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
$btset=singleset('FS');
$GMIN_SINGLE=$btset[0];
$GMAX_SINGLE=$row['FS_FS_Scene'];
$GSINGLE_CREDIT=$row['FS_FS_Bet'];
$open=$row['OpenType'];
if ($change==1){
	$bet_title=$nobettitle;
}
$mysql = "select M_Start,$mb_team as MB_Team,$m_league as M_League,$m_item as M_Item,mcount,Gtype,M_Rate from match_crown where `M_Start`>now() and `MID`='$gid' and $mb_team!='' and Gid='$rtype'";
$result = mysql_query($mysql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit;
}else{

	$M_League=$row['M_League'];
	$M_Item=$row['M_Item'];
	$MB_Team=$row['MB_Team'];
	$num=$row['mcount'];
	$ftype=$row['Gtype'];
	$M_Rate=$row['M_Rate'];
	/*for($i=0;$i<$num;$i++){
        if ($rtype==$ftype[$i]){
            $MB_Team=$team[$i];
            $M_Rate=num_rate($open,$rate[$i]);
        }
	}*/
	
	$havesql="select sum(BetScore) as BetScore from web_report_data where m_name='$memname' and MID='$gid' and linetype=1 and Mtype='$mtype' and Active=7";

	$result = mysql_query($havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;
	
    $sql = "select * from match_league where  $m_league='$M_League'";
    $result = mysql_query($sql);
    $league = mysql_fetch_array($result);
    $bettop=$league['CS'];
	
	if ($M_Rate==0){
	    echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	    exit;
	}
	if ($bettop<$GSINGLE_CREDIT){
		$bettop_money=$bettop;
	}else{
		$bettop_money=$GSINGLE_CREDIT;
	}
?>
<html>
<head>
<title>ft_nfs_order</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
</head>
<body id="OFS" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<script language="JavaScript" src="/js/ft_fs_order<?=$js?>.js">
</script>
<form name="LAYOUTFORM" action="/app/member/FT_order/FT_order_nfs_finish.php" method="post" onSubmit="return false">
  <div class="ord">
    <span><h1><?=$M_Item?><?=$Order_betting_order?></h1></span>
    <div id="info">
      <p><?=$Order_Login_Name?><?=$memname?></p>
      <p><?=$Order_Credit_line?><?=$credit?></p>
      <p><?=$Order_Currency?><?=$curtype?></p>
      <p class="error"><?=$Order_The_maximum_payout_is_x_per_bet?></p>
      <p class="error"><?=str_replace("<*****>",$bettop_money,$Order_There_is_a_maximum_wager_limit_on_this_game_x_restriction)?></p>
      <p class="team"><?=$M_League?>&nbsp;-&nbsp;<?=$MB_Team?>&nbsp;<?=date('m-d',strtotime($row["M_Start"]))?><br><?=$M_Item?>&nbsp;&nbsp;@&nbsp;<strong><?=$M_Rate?></strong></p>
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
<input type="hidden" name="active" value="7">
<input type="hidden" name="line_type" value="16">
<input type="hidden" name="gid" value="<?=$gid?>">
<input type="hidden" name="tid" value="122566">
<input type="hidden" id="ioradio_fs" name="ioradio_fs" value="<?=$M_Rate?>">
<input type="hidden" name="gmax_single" value="<?=$bettop_money?>">
<input type="hidden" name="gmin_single" value="<?=$GMIN_SINGLE?>">
<input type="hidden" name="singlecredit" value="<?=$GMAX_SINGLE?>">
<input type="hidden" name="singleorder" value="<?=$GSINGLE_CREDIT?>">
<input type="hidden" name="restsinglecredit" value="<?=$have_bet?>">
<input type="hidden" name="wagerstotal" value="<?=$GMAX_SINGLE?>">
<input type="hidden" name="restcredit" value="<?=$credit?>">
<input type="hidden" name="pay_type" value="<?=$pay_type?>">
<input type="hidden" name="gametype" value="<?=$gametype?>">
<input type="hidden" name="rtype" value="<?=$rtype?>">
<input type="hidden" name="wtype" value="<?=$wtype?>">
</form>
</body>
<SCRIPT LANGUAGE="JavaScript">document.all.gold.focus();</script>
</html>
<?
mysql_close();
}
?>