<?
session_start();
header("Expires: Mon, 26 Jul 1970 00:00:00 GMT");
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
if($userid<=0){
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';</script>\n";	
}

$type=$_REQUEST['type'];
$gnum=$_REQUEST['gnum'];
$strong=$_REQUEST['strong'];
$odd_f_type=$_REQUEST['odd_f_type'];
$error_flag=$_REQUEST['error_flag'];
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
$GMAX_SINGLE=$row['VB_R_Scene'];
$GSINGLE_CREDIT=$row['VB_R_Bet'];
$open=$row['OpenType'];
$langx=$row['Language'];
require ("../include/traditional.$langx.inc.php");
if ($error_flag==1){
	$bet_title="<tt>".$Order_Odd_changed_please_bet_again."</tt>";
}
$btset=singleset('R');
$GMIN_SINGLE=$btset[0];

$mysql = "select M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,MB_LetB_Rate,TG_LetB_Rate,M_LetB from `match_sports` where Type='VB' and `M_Start`>now() and `MID`='$gid' and Cancel!=1 and Open=1 and $mb_team!=''";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit;
}else{
	
	if ($row['M_Date']==date('Y-m-d')){
		$active=5;
		$class="OVB";
		$caption=$Order_VB.$Order_Handicap_betting_order;
	}else{
		$active=55;
		$class="OVU";
		$caption=$Order_VB.$Order_Early_Market.$Order_Handicap_betting_order;
	}
	$M_League=$row['M_League'];
	$MB_Team=$row["MB_Team"];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($MB_Team);
	$Sign=$row['M_LetB'];
	$rate=get_other_ioratio($odd_f_type,$row["MB_LetB_Rate"],$row["TG_LetB_Rate"],100);
	switch ($type){
	case "H":
		$M_Place=$MB_Team;
		$M_Rate=change_rate($open,$rate[0]);
		$mtype='RH';
		break;
	case "C":
		$M_Place=$TG_Team;
		$M_Rate=change_rate($open,$rate[1]);
		$mtype='RC';
		break;
	}
	if ($row['ShowTypeR']=='C'){
		$Team=$MB_Team;
		$MB_Team=$TG_Team;
		$TG_Team=$Team;
	}
	$havesql="select sum(BetScore) as BetScore from web_report_data where m_name='$memname' and MID='$gid' and linetype=2 and Mtype='$mtype' and (Active=5 or Active=55)";
	$result = mysql_query($havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;

    $sql = "select * from match_league where  $m_league='$M_League' and Type='VB'";
    $result = mysql_query($sql);
    $league = mysql_fetch_array($result);
    $mmb_team=explode("[",$row['MB_Team']);
    if ($mmb_team[1]==$Special0 or $mmb_team[1]==$Special1 or $mmb_team[1]==$Special2 or $mmb_team[1]==$Special3 or $mmb_team[1]==$Special4){
        $bettop=$league['CS'];
    }else{
        $bettop=$league['R'];
    }
	if ($M_Rate=='' or $M_Rate==0 or $Sign==''){
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
<title>vb_r_order</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
</head>
<script language="JavaScript" src="/js/football_order<?=$js?>.js"></script>
<body id="<?=$class?>" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="LAYOUTFORM" action="/app/member/VB_order/VB_order_finish.php" method="post" onSubmit="return false">
  <div class="ord">
    <span><h1><?=$caption?></h1></span>
    <div id="info">
      <p><?=$Order_Login_Name?><?=$memname?></p>
      <p><?=$Order_Credit_line?><?=$credit?></p>
      <p><?=$Order_Currency?><?=$curtype?></p>
      <p class="error"><?=$bet_title?><?=str_replace("<*****>",$bettop_money,$Order_There_is_a_maximum_wager_limit_on_this_game_x_restriction)?></p>
      <p class="team"><?=$M_League?>&nbsp;&nbsp;<?=date('m-d',strtotime($row["M_Date"]))?><br><?=$MB_Team?>&nbsp;<em><?=$Sign?></em>&nbsp;<?=$TG_Team?><br><em><?=$M_Place?></em>&nbsp;@&nbsp;<strong><?=$M_Rate?></strong></p>
      <p><?=$Order_Bet_Amount?><input type="text" id="gold" name="gold" size="8" maxlength="10" onKeyPress="return CheckKey()" onKeyUp="return CountWinGold()" class="txt"></p>
      <p><?=$Order_Estimated_Payout?><font id="pc">0</font></p>
      <p><?=$Order_Minimum?><?=$GMIN_SINGLE?></p>
      <p><?=$Order_Single_bet_limit?><?=$GSINGLE_CREDIT?></p>
      <p><?=$Order_Maximum?><?=$GMAX_SINGLE?></p>
  <div class="foot">
    <input type="button" name="btnCancel" value="<?=$Order_Cancel?>" onClick="self.location='../select.php?uid=<?=$uid?>'" class="no">
    <input type="button" name="Submit" value="<?=$Order_Confirm?>" onClick="CountWinGold();return SubChk();" class="yes">
  </div>

  <div id="gfoot" ></div>
  <div id="gWager" style="display: none;"></div>
  <div id="gbutton" style="display: block;position: absolute;"></div>
      
    </div>
  </div>


  <div class="ord" id="line_window" style="display: none;position: absolute;">
    <div class="chk" id="gdiv_table">
      *SHOW_STR*<br>
      <input type="button" name="wgCancel" value="<?=$Order_Cancel?>" onClick="Close_div();" class="no">
      <input type="button" name="wgSubmit" value="<?=$Order_Confirm?>" onmousedown='Sure_wager();' class="yes">
    </div>
  </div>  
<input type="hidden" name="uid" value="<?=$uid?>">
<input type="hidden" name="active" value="<?=$active?>">
<input type="hidden" name="strong" value="<?=$strong?>">
<!--input type="hidden" name="ordertype" value="1"-->
<input type="hidden" name="line_type" value="2">
<input type="hidden" name="gid" value="<?=$gid?>">
<!--<input type="hidden" name="ouid" value="{OUID}">--> 
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="gnum" value="<?=$gnum?>">
<input type="hidden" name="concede_r" value="-1">
<input type="hidden" name="radio_r" value="-50">
<input type="hidden" id="ioradio_r_h" name="ioradio_r_h" value="<?=$M_Rate?>">
<!--input type="hidden" name="ioradio_ck" value="0.84"-->
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
