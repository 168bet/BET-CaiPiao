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
if($userid<=0){
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';</script>\n";	
}

$teamcount=$_REQUEST['teamcount'];
$sql = "select * from web_member_data where oid='$uid' and Status=0";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	setcookie('login_uid','');
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$langx=$row['Language'];
require ("../include/traditional.$langx.inc.php");
$pay_type=$row['Pay_Type'];
$curtype=$row['CurType'];
$open=$row['OpenType'];
$memname=$row['UserName'];
$credit=$row['Money'];
$btset=singleset('PC');
$GMIN_SINGLE=$btset[0];
$bettop=$btset[1];
$GMAX_SINGLE=$row['TN_PR_Scene'];
$GSINGLE_CREDIT=$row['TN_PR_Bet'];
$m_team=0;
for ($i=0;$i<$teamcount+1;$i++){
	 $res=$_REQUEST["game$i"];
	 if ($res!=""){
	     $gid=$_REQUEST["game_id$i"];
	     $havesql="select sum(BetScore) as BetScore from web_report_data where m_name='$memname' and FIND_IN_SET($gid,MID)>0 and linetype=8 and (Active=4 or Active=44)";
	     $result = mysql_query($havesql);
	     $haverow = mysql_fetch_array($result);
	     $score=$haverow['BetScore'];
	     if ($score==''){
		     $score=0;
	     }
	     $score1=$score1+$score;
	     if ($have_bet==''){
		     $have_bet=$haverow['BetScore']." ";
	     }else{
		     $have_bet=$have_bet.$haverow['BetScore']." ";
	     }
	     $mysql = "select MID,M_Date,M_Time,MB_MID,TG_MID,ShowTypeP,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeP,MB_P_Win_Rate,TG_P_Win_Rate from `match_sports` where Type='TN' and  `M_Start`>now() and MID='$gid' and Cancel!=1 and Open=1 and MB_Team!='' and MB_Team_tw!='' and MB_Team_en!=''";//判断赛事是否关闭
	     $result = mysql_query($mysql);
	     $cou=mysql_num_rows($result);
	     if ($cou==0){
		     echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
		     exit();
	     }
	     $row = mysql_fetch_array($result);
	     $pdate=$row['M_Date'];
	     $start=$row['M_Start'];
		 $league=$row['M_League'];
	     $s_mb_team = filiter_team($row['MB_Team']);
		 $s_tg_team = filiter_team($row['TG_Team']);
	     $mb_mid=$row['MB_MID'];
		 $tg_mid=$row['TG_MID'];
		 if($teama==$row['MB_Team']){
			echo attention("$Order_The_game_is_covered_same_teams_Please_reset_again",$uid,$langx);
			exit();
		}else{
			$teama=$row['MB_Team'];
		}
	     switch($res){
		 case 'PH':
				$rate=num_rate($open,$row['MB_P_Win_Rate']);
				$place=$s_mb_team;
				$sign   = 'VS.';
				$mmid="(".$row['MB_MID'].")";
				break;
		 case 'PC':
				$rate=num_rate($open,$row['TG_P_Win_Rate']);			
				$place=$s_tg_team;
				$sign   = 'VS.';
				$mmid="(".$row['TG_MID'].")";
				break;
	     }	 
	     $betplace=$betplace."<div id=TR$i><p class=team id=P1>".$league."-".$Mix_Parlay."<br>";
	     $betplace=$betplace.$s_mb_team."&nbsp;<FONT color=#CC0000>".$sign."</FONT>&nbsp;".$s_tg_team."<br>";
	     $betplace=$betplace."<FONT color=#cc0000>".$mmid."&nbsp;".$place."</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".number_format($rate,2)."</b></FONT>&nbsp;";
		 $betplace=$betplace."<input type=button name=delteam$i value=$Order_Delete onClick=delteams('$i') class=par></p></div>";
	     $m_team=$m_team+1;
		 $m_rate[]=$rate;
		 $m_gid[]=$gid;
		 $type[]=$res;
		 $showtype[]=$row['ShowTypeP'];
	}
}
$rate=implode(" ",$m_rate);

if ($row['M_Date']==date('Y-m-d')){
	$active=4;
	$class="OTN";
	$caption=$Order_TN.$Order_1_x_2_Parlay_betting_order;
}else{
	$active=44;
	$class="OTU";
	$caption=$Order_TN.$Order_Early_Market.$Order_1_x_2_Parlay_betting_order;
}
?>
<script>
var iorstr='<?=$rate?> ';
var minlimit='3';
var maxlimit='10';
</script>
<html>
<head>
<title>tn_p3_order</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
<script>
var scripts=new Array();
var rtype="P3";
<?
for ($i=0;$i<$m_team;$i++){
echo "scripts[$i]=new Array('$m_gid[$i]','$type[$i]','$showtype[$i]','1','0','$m_rate[$i]');";
} 
?>
</script>
</head>

<body id="<?=$class?>" onLoad="LoadSelect();" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">

<script language="JavaScript" src="/js/ft_parlay_order<?=$js?>.js"></script>
<form name="LAYOUTFORM" action="/app/member/TN_order/TN_order_p_finish.php" method="post" onSubmit="return false">
  <div class="ord">
    <span><h1><?=$caption?></h1></span>
    <div id="info">
      <p><?=$Order_Login_Name?><?=$memname?></p>
      <p><?=$Order_Credit_line?><?=$credit?></p>
      <p><?=$Order_Currency?><?=$curtype?></p>
      
      <p class="error"><?=str_replace("<*****>",$bettop,$Order_The_maximum_payout_is_x_per_bet)?><?=$bet_title?></p>
      <?=$betplace?>
      <p><?=$Order_Mode?>
      <select name="wkind" size="1" onChange="chiang_wkind()"><option value="S" selected><?=$Order_single_wager?></option></select>
      <select id="wstar" name="wstar" size="1" onChange="chiang_wstar()"></select>
      <select id="wteam" name="wteam" size="1"></select>
      </p>
      <p><?=$Order_Bet_Amount?><input type="text" id="gold" name="gold" size="8" maxlength="10" onKeyPress="return CheckKey()" onKeyUp="return CountWinGold('<?=$rate?> ',3)" class="txt"></p>
      <p><?=$Order_Estimated_Payout?><font id="pc">0</font></p>
      <p><?=$Order_Minimum?><?=$GMIN_SINGLE?></p>
      <p><?=$Order_Single_bet_limit?><?=$GSINGLE_CREDIT?></p>
      <p><?=$Order_Maximum?><?=$GMAX_SINGLE?></p>
    <p class="foot">
      <input type="button" name="btnCancel" value="<?=$Order_Cancel?>" onClick="Win_Redirect();" class="no">
      <input type="button" name="SUBMIT" value="<?=$Order_Confirm?>" onClick="CountWinGold('<?=$rate?> ',3);return CheckSubmit();" class="yes">
    </p>
<div id="gfoot"></div>      
    </div>
  </div>
<input type="hidden" name="uid" value="<?=$uid?>">
<input type="hidden" name="wid" value="">
<input type="hidden" name="active" value="<?=$active?>">
<input type="hidden" name="teamcount" value="<?=$m_team?>">
<input type="hidden" name="tcount" value="<?=$m_team?>">
<input type="hidden" name="username" value="<?=$memname?>">
<input type="hidden" name="singlecredit" value="<?=$GMAX_SINGLE?>">
<input type="hidden" name="singleorder" value="<?=$GSINGLE_CREDIT?>">
<input type="hidden" name="gmin_single" value="<?=$GMIN_SINGLE?>">
<input type="hidden" name="gmax_single" value="<?=$GMAX_SINGLE?>">
<input type="hidden" name="restcredit" value="<?=$credit?>">
<input type="hidden" name="wagerstotal" value="0">
<input type="hidden" name="pay_type" value="<?=$pay_type?>">
<input type="hidden" name="sc" value="0.0 0.0 0.0 0.0 0.0 ">
<input type="hidden" name="pdate" value="<?=$pdate?>">
<input type="hidden" id="wagerDatas" name="wagerDatas" value="">
</form>
<!--object id=closes type="application/x-oleobject" classid="clsid:adb880a6-d8ff-11cf-9377-00aa003b7a11">
    <param name="Command" value="Close"></object-->

</body>
<SCRIPT LANGUAGE="JavaScript">document.all.gold.focus();</script>
</html>
