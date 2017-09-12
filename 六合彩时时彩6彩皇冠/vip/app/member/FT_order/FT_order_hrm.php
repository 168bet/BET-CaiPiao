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
require ("../include/curl_http.php");
$gid=$_REQUEST['gid'];
$langx=$_SESSION['langx'];
$uid=$_REQUEST['uid'];
$gnum=$_REQUEST['gnum'];
$type=$_REQUEST['type'];
$odd_f_type=$_REQUEST['odd_f_type'];
$error_flag=$_REQUEST['error_flag'];
if($userid<=0){
		header( "Content-Type:   text/html;   charset=UTF-8 ");
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';</script>\n";	
}
require ("../include/traditional.$langx.inc.php");
//////////////////////////////////////////////////
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
$btset=singleset('M');
$GMIN_SINGLE=$btset[0];
$GMAX_SINGLE=$row['FT_M_Scene'];
$GSINGLE_CREDIT=$row['FT_M_Bet'];
$open=$row['OpenType'];
if ($error_flag==1){
	$bet_title="<tt>".$Order_Odd_changed_please_bet_again."</tt>";
}
////////////////////////////////////////////////////
$mysql = "select datasite,uid from web_system_data";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$site=$row['datasite'];
$suid=$row['uid'];
$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_index.php?rtype=re&uid=$suid&langx=zh-cn&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/FT_order/FT_order_hrm.php?gid=$gid&uid=$suid&type=$type&gnum=$gnum&odd_f_type=$odd_f_type");
preg_match("/足球上半场滚球独赢交易单/Usi",$html_data,$m_temp);
preg_match_all("/<p class=\"team\">(.+?)<\/p>/is",$html_data,$matches);
preg_match_all("/<br>(.+?)\ /is",$matches[0][0],$matches1);
$t_inball=trim(str_replace("<br>","",$matches1[0][0]));
//print_r($matches1);exit;
//echo $t_inball;exit;
if(!$m_temp){ 
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit();
}
$sgid=$gid-1;
$mysql = "select M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Win_Rate_RB_H,TG_Win_Rate_RB_H,M_Flat_Rate_RB_H,MB_Ball,TG_Ball from `match_sports` where `MID`='$sgid' and Cancel!=1 and Open=1 and $mb_team!=''";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
}else{

	$M_League=$row['M_League']; 
	$MB_Team=$row["MB_Team"];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($MB_Team);
	$inball=$row['MB_Ball'].":".$row['TG_Ball'];
		if($inball!=$t_inball){
			echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
			exit;
		}	
	switch ($type){ 
	case "H": 
		$M_Place=$MB_Team; 
		$M_Rate=num_rate($open,$row["MB_Win_Rate_RB_H"]); 
		break; 
	case "C": 
		$M_Place=$TG_Team; 
		$M_Rate=num_rate($open,$row["TG_Win_Rate_RB_H"]); 
		break; 
	case "N": 
		$M_Place=$Draw;
		$M_Rate=num_rate($open,$row["M_Flat_Rate_RB_H"]); 
		break; 
	} 
	$havesql="select sum(BetScore) as BetScore from web_report_data where M_Name='$memname' and MID='$sgid' and LineType=31 and (Active=1 or Active=11)";
	$result = mysql_db_query($dbname,$havesql); 
	$haverow = mysql_fetch_array($result); 
	$have_bet=$haverow['BetScore']+0; 
	
    $sql = "select * from match_league where  $m_league='$M_League'";
    $result = mysql_db_query($dbname,$sql);
    $league = mysql_fetch_array($result);
    //$bettop=$league['VRM'];
	$bettop=$GSINGLE_CREDIT;
	
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
<title>ft_hrm_order</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
<script language="JavaScript" src="/js/football_order<?=$js?>.js"></script>
</head>

<body id="OFT" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="LAYOUTFORM" action="/app/member/FT_order/FT_order_hre_finish.php" method="post" onSubmit="return false">
  <div class="ord">
    <span><h1><?=$Order_FT?><?=$Order_1st_Half_Running_1_x_2_betting_order?></h1></span>
    <div id="info">
      <p><?=$Order_Login_Name?><?=$memname?></p>
      <p><?=$Order_Credit_line?><?=$credit?></p>
      <p><?=$Order_Currency?><?=$curtype?></p>
      <p class="error"><?=$bet_title?><?=str_replace("<*****>",$bettop_money,$Order_There_is_a_maximum_wager_limit_on_this_game_x_restriction)?></p>
      <p class="team"><?=$M_League?>&nbsp;-&nbsp;<b><font color=red>[<?=$Order_1st_Half?>]</font></b>&nbsp;&nbsp;<?=date('m-d',strtotime($row["M_Date"]))?><br><?=$inball?> <?=$MB_Team?>&nbsp;<font color=#CC0000>VS.</font>&nbsp;<?=$TG_Team?><br><em><?=$M_Place?></em>&nbsp;@&nbsp;<strong><?=$M_Rate?><br><b>(<?=$Order_This_odd_is_the_latest?>)</b></strong></p>
      <p><?=$Order_Bet_Amount?><input type="text" id="gold" name="gold" size="8" maxlength="10" onKeyPress="return CheckKey()" class="txt"></p>
      <p style='display:none;'><?=$Order_Estimated_Payout?><font id="pc">0</font></p>
      <p><?=$Order_Minimum?><?=$GMIN_SINGLE?></p>
      <p><?=$Order_Single_bet_limit?><?=$GSINGLE_CREDIT?></p>
      <p><?=$Order_Maximum?><?=$GMAX_SINGLE?></p>
    </div>
  </div>
  <div id="gWager" style="display: none;position: absolute;"></div>
  <div id="gbutton" style="display: block;position: absolute;"></div>

  <div class="foot">
    <input type="button" name="btnCancel" value="<?=$Order_Cancel?>" onClick="self.location='../select.php?uid=<?=$uid?>'" class="no">
    <input type="button" name="Submit" value="<?=$Order_Confirm?>" onClick="return SubChk();" class="yes">
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
<input type="hidden" name="active" value="1">
<input type="hidden" name="line_type" value="31">
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