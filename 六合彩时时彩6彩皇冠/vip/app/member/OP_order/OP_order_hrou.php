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
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$type=$_REQUEST['type'];
$gnum=$_REQUEST['gnum'];
$odd_f_type=$_REQUEST['odd_f_type'];
$error_flag=$_REQUEST['error_flag'];
if($userid<=0){
		header( "Content-Type:   text/html;   charset=UTF-8 ");
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';</script>\n";	
}
//////////////////////////////////////////////////
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
$btset=singleset('ROU');
$GMIN_SINGLE=$btset[0];
$GMAX_SINGLE=$row['FT_ROU_Scene'];
$GSINGLE_CREDIT=$row['FT_ROU_Bet'];
$open=$row['OpenType'];
$langx=$row['Language'];
require ("../include/traditional.$langx.inc.php");
if ($error_flag==1){
	$bet_title="<tt>".$Order_Odd_changed_please_bet_again."</tt>";
}
////////////////////////////////////////////////////
$mysql = "select datasite,uid from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$site=$row['datasite'];
$suid=$row['uid'];
$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_index.php?rtype=re&uid=$suid&langx=zh-cn&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/OP_order/OP_order_hrou.php?gid=$gid&uid=$suid&type=$type&gnum=$gnum&odd_f_type=$odd_f_type");
preg_match("/其他上半滚球大小交易单/Usi",$html_data,$m_temp);
if(!$m_temp){ 
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit();
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
$sgid=$gid-1;
$mysql = "select M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Dime_RB_H,TG_Dime_RB_H,MB_Dime_Rate_RB_H,TG_Dime_Rate_RB_H,MB_Ball,TG_Ball from `match_sports` where Type='OP' and `MID`='$sgid' and Cancel!=1 and Open=1 and $mb_team!=''";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit();
}else{

	$M_League=$row['M_League'];
	$MB_Team=$row["MB_Team"];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($MB_Team);
	$TG_Team=filiter_team($TG_Team);
	$rate=get_other_ioratio($odd_f_type,$row["MB_Dime_Rate_RB_H"],$row["TG_Dime_Rate_RB_H"],100);
	switch ($type){
	case "C":
		$M_Place=$row["MB_Dime_RB_H"];
		if ($langx=="zh-cn"){
	        $M_Place=str_replace('O','大&nbsp;',$M_Place);
		}else if ($langx=="zh-tw"){
		    $M_Place=str_replace('O','大&nbsp;',$M_Place);
		}else if ($langx=="en-us" or $langx=="th-tis"){
		    $M_Place=str_replace('O','over&nbsp;',$M_Place);
		}
		$M_Rate=change_rate($open,$rate[0]);
		$mtype='VROUH';
		break;
	case "H":
		$M_Place=$row["TG_Dime_RB_H"];
		if ($langx=="zh-cn"){
		    $M_Place=str_replace('U','小&nbsp;',$M_Place);
		}else if ($langx=="zh-tw"){
		    $M_Place=str_replace('U','小&nbsp;',$M_Place);
		}else if ($langx=="en-us" or $langx=="th-tis"){
		    $M_Place=str_replace('U','under&nbsp;',$M_Place);
		}
		$M_Rate=change_rate($open,$rate[1]);
		$mtype='VROUC';
		break;
	}
	$inball=$row['MB_Ball'].":".$row['TG_Ball'];
     //$tmp_id='1'.substr(rand(time(),1),0,4);
     //$ratio_id=$tmp_id.$tmp_id*$M_Rate*100;
	$ratio_id=$M_Rate;	
	$havesql="select sum(BetScore) as BetScore from web_report_data where M_Name='$memname' and MID='$sgid' and LineType=20 and Mtype='$mtype' and Active=1";
	$result = mysql_query($havesql);  
	$haverow = mysql_fetch_array($result);  
	$have_bet=$haverow['BetScore']+0;  
	 
    $sql = "select * from match_league where  $m_league='$M_League'";
    $result = mysql_query($sql);
    $league = mysql_fetch_array($result);
    $mmb_team=explode("[",$row['MB_Team']);
    if ($mmb_team[1]==$Special1){
        $bettop=$league['CS'];
    }else{
        $bettop=$league['VROU'];
    }
	
	if ($M_Rate==0 or $M_Place=='' or $M_Place=='O0' or $M_Place=='U0'){
	    echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	    exit;
	}
	
	if ($odd_f_type=='E'){
		$count=1;
	}else{
		$count=0;
	}
	if ($GSINGLE_CREDIT>=500){
	    if ($M_Rate-$count<=1){
		    $num=1;
	    }else if ($M_Rate-$count>1 and $M_Rate-$count<=1.05){
		    $num=0.95;
		}else if ($M_Rate-$count>1.05 and $M_Rate-$count<=1.1){
		    $num=0.9;
		}else if ($M_Rate-$count>1.1 and $M_Rate-$count<=1.15){
		    $num=0.85;
	    }else if ($M_Rate-$count>1.15 and $M_Rate-$count<=1.2){
		    $num=0.8;
		}else if ($M_Rate-$count>1.2 and $M_Rate-$count<=1.25){
		    $num=0.75;
		}else if ($M_Rate-$count>1.25 and $M_Rate-$count<=1.3){
		    $num=0.7;
	    }else if ($M_Rate-$count>1.3 and $M_Rate-$count<=1.35){
		    $num=0.65;
	    }else if ($M_Rate-$count>1.35 and $M_Rate-$count<=1.4){
		    $num=0.6;
		}else if ($M_Rate-$count>1.4 and $M_Rate-$count<=1.45){
		    $num=0.55;
	    }else if ($M_Rate-$count>1.45 and $M_Rate-$count<=1.5){
		    $num=0.5;
		}else if ($M_Rate-$count>1.5){
		    $num=0.45;
	    }
		$number=100;
	}else{
		$num=1;
		$number=1;
	}
	if ($bettop<$GSINGLE_CREDIT){
		$bettop_money=$bettop*$num;
	}else{
		$bettop_money=floor($GSINGLE_CREDIT*$num/$number)*$number;
	}
	$bettop_money=$GSINGLE_CREDIT;
?>
<html>
<head>
<title>op_hrou_order</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
</head>
<body id="OOP" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<script language="JavaScript" src="/js/football_order<?=$js?>.js"></script>
<form name="LAYOUTFORM" action="/app/member/OP_order/OP_order_hre_finish.php" method="post" onSubmit="return false">
  <div class="ord">
    <span><h1><?=$Order_Other?><?=$Order_1st_Half_Running_Ball_Over_Under_betting_order?></h1></span>
    <div id="info">
      <p><?=$Order_Login_Name?><?=$memname?></p>
      <p><?=$Order_Credit_line?><?=$credit?></p>
      <p><?=$Order_Currency?><?=$curtype?></p>
      <p class="error"><?=$bet_title?><?=str_replace("<*****>",$bettop_money,$Order_There_is_a_maximum_wager_limit_on_this_game_x_restriction)?></p>
      <p class="team"><?=$M_League?> - <b><font color=red>[<?=$Order_1st_Half?>]</font></b>&nbsp;<?=date('m-d',strtotime($row["M_Date"]))?><br><?=$inball?>&nbsp;<?=$MB_Team?>&nbsp;<em>VS.</em>&nbsp;<?=$TG_Team?><br><em><?=$M_Place?></em>&nbsp;@&nbsp;<strong><?=$ratio_id?><br><b>(<?=$Order_This_odd_is_the_latest?>)</b></strong></p>
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
<input type="hidden" name="line_type" value="20">
<input type="hidden" name="gid" value="<?=$gid?>"> 
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="gnum" value="<?=$gnum?>">
<input type="hidden" name="concede_h" value="1">
<input type="hidden" name="radio_h" value="100">
<input type="hidden" name="ioradio_r_h" id="ioradio_r_h" value="<?=$M_Rate?>">
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
}
mysql_close();
?>
