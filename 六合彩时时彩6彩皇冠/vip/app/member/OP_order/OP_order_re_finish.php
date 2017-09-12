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
$strong=$_REQUEST['strong'];
$odd_f_type=$_REQUEST['odd_f_type'];
$ioradio_r_h=$_REQUEST['ioradio_r_h'];
$gold=$_REQUEST['gold'];
$active=$_REQUEST['active'];
$line=$_REQUEST['line_type'];
$restcredit=$_REQUEST['restcredit'];
if($userid<=0){
		header( "Content-Type:   text/html;   charset=UTF-8 ");
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';</script>\n";	
}
$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	setcookie('login_uid','');
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$memrow = mysql_fetch_array($result);
$langx=$memrow['Language'];
$open=$memrow['OpenType'];
$pay_type =$memrow['Pay_Type'];
$memname=$memrow['UserName'];
$agents=$memrow['Agents'];
$world=$memrow['World'];
$corprator=$memrow['Corprator'];
$super=$memrow['Super'];
$admin=$memrow['Admin'];
$w_ratio=$memrow['ratio'];
$HMoney=$memrow['Money'];
if ($HMoney < $gold){
	echo "<script language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
	exit();
}
$w_current=$memrow['CurType'];
$havemoney=$HMoney-$gold;
$memid=$memrow['ID'];
require ("../include/traditional.$langx.inc.php");

$mysql = "select datasite,uid from web_system_data where id=1";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$site=$row['datasite'];
$suid=$row['uid'];
$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_index.php?rtype=re&uid=$suid&langx=zh-cn&mtype=3");
switch ($line){
case '10':
	$html_data=$curl->fetch_url("".$site."/app/member/OP_order/OP_order_rou.php?gid=$gid&uid=$suid&type=$type&gnum=$gnum&odd_f_type=$odd_f_type");
	break;
case '9':
	$html_data=$curl->fetch_url("".$site."/app/member/OP_order/OP_order_re.php?gid=$gid&uid=$suid&type=$type&gnum=$gnum&strong=$strong&odd_f_type=$odd_f_type");
	break;
case '21':
	$html_data=$curl->fetch_url("".$site."/app/member/OP_order/OP_order_rm.php?gid=$gid&uid=$suid&type=$type&gnum=$gnum&odd_f_type=$odd_f_type");
	break;
}
preg_match("/其他滚球/Usi",$html_data,$m_temp);
if(!$m_temp){ 
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit();
}

$mysql = "select * from `match_sports` where Type='OP' and `MID`='$gid' and Open=1 and MB_Team!='' and MB_Team_tw!='' and MB_Team_en!=''";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	//echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit();
}
	//主客队伍名称
	$w_tg_team=$row['TG_Team'];
	$w_tg_team_tw=$row['TG_Team_tw'];
	$w_tg_team_en=$row['TG_Team_en'];
	
	$w_mb_team=$row['MB_Team'];
	$w_mb_team_tw=$row['MB_Team_tw'];
	$w_mb_team_en=$row['MB_Team_en'];
	
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_tg_team=filiter_team(trim($row['TG_Team']));	
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_tg_team_tw=filiter_team(trim($row['TG_Team_tw']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));
	$w_tg_team_en=filiter_team(trim($row['TG_Team_en']));
	
	//取出当前字库的主客队伍名称
	
	$s_mb_team=filiter_team($row[$mb_team]);
	$s_tg_team=filiter_team($row[$tg_team]);

	//下注时间
	$m_date=date('Y-m-d');
	$showtype=$row["ShowTypeRB"];
	$bettime=date('Y-m-d H:i:s');
	
	//联盟
	if ($row[$m_sleague]==''){
		$w_sleague=$row['M_League'];
		$w_sleague_tw=$row['M_League_tw'];
		$w_sleague_en=$row['M_League_en'];
		$s_sleague=$row[$m_league];
	}
	
	$inball=$row['MB_Ball'].":".$row['TG_Ball'];
	$inball1=$inball;
	$mb_ball = $row['MB_Ball'];
	$tg_ball = $row['TG_Ball'];
	switch ($line){
  	case 21:
	  	$bet_type='滚球独赢';
		$bet_type_tw='滾球獨贏';
		$bet_type_en="Running 1x2";
		$caption=$Order_Other.$Order_Running_1_x_2_betting_order;
		$turn_rate="OP_Turn_M";
		$turn="OP_Turn_M";
		switch ($type){
		case "H":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$s_m_place=$s_mb_team;
			$w_m_rate=num_rate($open,$row["MB_Win_RB"]);
			$turn_url="/app/member/OP_order/OP_order_rm.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&odd_f_type=".$odd_f_type;
			$w_gtype='MH';
			break;
		case "C":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$s_m_place=$s_tg_team;
			$w_m_rate=num_rate($open,$row["TG_Win_RB"]);
			$turn_url="/app/member/OP_order/OP_order_rm.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&odd_f_type=".$odd_f_type;
			$w_gtype='MC';
			break;
		case "N":
			$w_m_place="和局";
			$w_m_place_tw="和局";
			$w_m_place_en="Flat";
			$s_m_place=$Draw;
			$w_m_rate=num_rate($open,$row["M_Flat_RB"]);
			$turn_url="/app/member/OP_order/OP_order_rm.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&odd_f_type=".$odd_f_type;
			$w_gtype='MN';
			break;
		}
		$Sign="VS.";
		$grape=$type;
		$gwin=($w_m_rate-1)*$gold;
		$ptype='RM';
		break;	
	case 9:
 		$bet_type='滚球让球';
		$bet_type_tw="滾球讓球";
		$bet_type_en="Running Ball";
		$caption=$Order_Other.$Order_Running_Ball_betting_order;
		$turn_rate="OP_Turn_RE_".$open;
		$rate=get_other_ioratio($odd_f_type,$row["MB_LetB_Rate_RB"],$row["TG_LetB_Rate_RB"],100);
		switch ($type){
		case "H":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$s_m_place=$s_mb_team;
			$w_m_rate=change_rate($open,$rate[0]);
			$turn_url="/app/member/OP_order/OP_order_re.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&strong=".$strong."&odd_f_type=".$odd_f_type;
			$w_gtype='RRH';
			break;
		case "C":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$s_m_place=$s_tg_team;
			$w_m_rate=change_rate($open,$rate[1]);
			$turn_url="/app/member/OP_order/OP_order_re.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&strong=".$strong."&odd_f_type=".$odd_f_type;
			$w_gtype='RRC';
			break;
		}
		$Sign=$row['M_LetB_RB'];
		$grape=$Sign;
		if (strtoupper($showtype)=="H"){
			$l_team=$s_mb_team;
			$r_team=$s_tg_team;
			$w_l_team=$w_mb_team;
			$w_l_team_tw=$w_mb_team_tw;
			$w_l_team_en=$w_mb_team_en;
			$w_r_team=$w_tg_team;
			$w_r_team_tw=$w_tg_team_tw;
			$w_r_team_en=$w_tg_team_en;	
			$inball=$row['MB_Ball'].":".$row['TG_Ball'];
		}else{
			$r_team=$s_mb_team;
			$l_team=$s_tg_team;
			$w_r_team=$w_mb_team;
			$w_r_team_tw=$w_mb_team_tw;
			$w_r_team_en=$w_mb_team_en;
			$w_l_team=$w_tg_team;
			$w_l_team_tw=$w_tg_team_tw;
			$w_l_team_en=$w_tg_team_en;
			$inball=$row['TG_Ball'].":".$row['MB_Ball'];
			
		}
		$s_mb_team=$l_team;
		$s_tg_team=$r_team;
		$w_mb_team=$w_l_team;
		$w_mb_team_tw=$w_l_team_tw;
		$w_mb_team_en=$w_l_team_en;
		$w_tg_team=$w_r_team;
		$w_tg_team_tw=$w_r_team_tw;
		$w_tg_team_en=$w_r_team_en;
		$turn="OP_Turn_RE";
		if ($odd_f_type=='H'){
		    $gwin=($w_m_rate)*$gold;
		}else if ($odd_f_type=='M' or $odd_f_type=='I'){
		    if ($w_m_rate<0){
				$gwin=$gold;
			}else{
				$gwin=($w_m_rate)*$gold;
			}
		}else if ($odd_f_type=='E'){
		    $gwin=($w_m_rate-1)*$gold;
		}
		$ptype='RE';
		break;
	case 10:	
		$bet_type='滚球大小';
		$bet_type_tw="滾球大小";
		$bet_type_en="Running Over/Under";
		$caption=$Order_Other.$Order_Running_Ball_Over_Under_betting_order;
		$turn_rate="OP_Turn_OU_".$open;
		$rate=get_other_ioratio($odd_f_type,$row["MB_Dime_Rate_RB"],$row["TG_Dime_Rate_RB"],100);
		switch ($type){
		case "C":
			$w_m_place=$row["MB_Dime_RB"];
			$w_m_place=str_replace('O','大&nbsp;',$w_m_place);
			$w_m_place_tw=$row["MB_Dime_RB"];
			$w_m_place_tw=str_replace('O','大&nbsp;',$w_m_place_tw);
			$w_m_place_en=$row["MB_Dime_RB"];
			$w_m_place_en=str_replace('O','over&nbsp;',$w_m_place_en);
			
			$m_place=$row["MB_Dime_RB"];
			
			$s_m_place=$row["MB_Dime_RB"];
			if ($langx=="zh-cn"){
	            $s_m_place=str_replace('O','大&nbsp;',$s_m_place);
		    }else if ($langx=="zh-tw"){
		        $s_m_place=str_replace('O','大&nbsp;',$s_m_place);
		    }else if ($langx=="en-us" or $langx=='th-tis'){
		        $s_m_place=str_replace('O','over&nbsp;',$s_m_place);
			}	
			$w_m_rate=change_rate($open,$rate[0]);
			$turn_url="/app/member/OP_order/OP_order_rou.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&odd_f_type=".$odd_f_type;
			$w_gtype='ROUH';
			break;
		case "H":
			$w_m_place=$row["TG_Dime_RB"];
			$w_m_place=str_replace('U','小&nbsp;',$w_m_place);
			$w_m_place_tw=$row["TG_Dime_RB"];
			$w_m_place_tw=str_replace('U','小&nbsp;',$w_m_place_tw);
			$w_m_place_en=$row["TG_Dime_RB"];
			$w_m_place_en=str_replace('U','under&nbsp;',$w_m_place_en);
			
			$m_place=$row["TG_Dime_RB"];
			
			$s_m_place=$row["TG_Dime_RB"];
			if ($langx=="zh-cn"){
	            $s_m_place=str_replace('U','小&nbsp;',$s_m_place);
		    }else if ($langx=="zh-tw"){
		        $s_m_place=str_replace('U','小&nbsp;',$s_m_place);
		    }else if ($langx=="en-us" or $langx=='th-tis'){
		        $s_m_place=str_replace('U','under&nbsp;',$s_m_place);
			}
			$w_m_rate=change_rate($open,$rate[1]);
			$turn_url="/app/member/OP_order/OP_order_rou.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&odd_f_type=".$odd_f_type;
			$w_gtype='ROUC';
			break;
		}
		$Sign="VS.";
		$grape=$m_place;
		$turn="OP_Turn_OU";
		if ($odd_f_type=='H'){
		    $gwin=($w_m_rate)*$gold;
		}else if ($odd_f_type=='M' or $odd_f_type=='I'){
		    if ($w_m_rate<0){
				$gwin=$gold;
			}else{
				$gwin=($w_m_rate)*$gold;
			}
		}else if ($odd_f_type=='E'){
		    $gwin=($w_m_rate-1)*$gold;
		}
		$ptype='ROU';				
		break;
	}
	
	if ($gold<50){
		echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
		exit;
	}

	if ($w_m_rate=='' or $grape==''){
		//echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
		exit;
	}
	if ($w_m_rate!=$ioradio_r_h){
		$turn_url=$turn_url.'&error_flag=1';
		echo "<script language='javascript'>self.location='$turn_url';</script>";
		exit;
	}	
	if ($s_m_place=='' or $w_m_place=='' or $w_m_place_tw=='' or $w_m_place_en==''){
		echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
		exit;
	}
	if ($line==9 or $line==10){
		$oddstype=$odd_f_type;
	}else{
		$oddstype='';
	}
	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];

	$lines=$row['M_League']."<br>[".$row['MB_MID'].']vs['.$row['TG_MID']."]<br>".$w_mb_team."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines=$lines."<FONT color=#cc0000>$w_m_place</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$w_m_rate."</b></FONT>";	
	
	$lines_tw=$row['M_League_tw']."<br>[".$row['MB_MID'].']vs['.$row['TG_MID']."]<br>".$w_mb_team_tw."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_tw."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines_tw=$lines_tw."<FONT color=#cc0000>$w_m_place_tw</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$w_m_rate."</b></FONT>";
	
	$lines_en=$row['M_League_en']."<br>[".$row['MB_MID'].']vs['.$row['TG_MID']."]<br>".$w_mb_team_en."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_en."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines_en=$lines_en."<FONT color=#cc0000>$w_m_place_en</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$w_m_rate."</b></FONT>";	
	
$ip_addr = get_ip();

$msql = "select $turn as M_turn from web_member_data where UserName='$memname'";
$result = mysql_query($msql);
$mrow = mysql_fetch_array($result);
$m_turn=$mrow['M_turn']+0;

$asql = "select $turn_rate as A_turn from web_agents_data where UserName='$super'";
$result = mysql_query($asql);
$arow = mysql_fetch_array($result);
$a_rate=$arow['A_turn']+0;

$bsql = "select $turn_rate as B_turn from web_agents_data where UserName='$corprator'";
$result = mysql_query($bsql);
$brow = mysql_fetch_array($result);
$b_rate=$brow['B_turn']+0;

$csql = "select $turn_rate as C_turn from web_agents_data where UserName='$world'";
$result = mysql_query($csql);
$crow = mysql_fetch_array($result);
$c_rate=$crow['C_turn']+0;

$dsql = "select $turn_rate as D_turn from web_agents_data where UserName='$agents'";
$result = mysql_query($dsql);
$drow = mysql_fetch_array($result);
$d_rate=$drow['D_turn']+0;

$psql = "select * from web_agents_data where UserName='$agents'";
$result = mysql_query($psql);
$prow = mysql_fetch_array($result);
$a_point=$prow['A_Point']+0;
$b_point=$prow['B_Point']+0;
$c_point=$prow['C_Point']+0;
$d_point=$prow['D_Point']+0;

$max_sql = "select max(ID) max_id from web_report_data where BetTime<'$bettime'";
$max_result = mysql_query($max_sql);
$max_row = mysql_fetch_array($max_result);
$max_id=$max_row['max_id'];
$num=rand(10,50);
$id=$max_id+$num;

$sql = "INSERT INTO web_report_data	(ID,QQ83068506,danger,MID,Active,LineType,Mtype,M_Date,BetTime,BetScore,Middle,Middle_tw,Middle_en,BetType,BetType_tw,BetType_en,M_Place,M_Rate,M_Name,Gwin,TurnRate,OpenType,OddsType,ShowType,Agents,World,Corprator,Super,Admin,A_Rate,B_Rate,C_Rate,D_Rate,A_Point,B_Point,C_Point,D_Point,BetIP,Ptype,Gtype,CurType,Ratio,MB_MID,TG_MID,Pay_Type,Orderby,MB_Ball,TG_Ball) values ('$id','$inball1','1','$gid','$active','$line','$w_gtype','$m_date','$bettime','$gold','$lines','$lines_tw','$lines_en','$bet_type','$bet_type_tw','$bet_type_en','$grape','$w_m_rate','$memname','$gwin','$m_turn','$open','$oddstype','$showtype','$agents','$world','$corprator','$super','$admin','$a_rate','$b_rate','$c_rate','$d_rate','$a_point','$b_point','$c_point','$d_point','$ip_addr','$ptype','OP','$w_current','$w_ratio','$w_mb_mid','$w_tg_mid','$pay_type','$order','$mb_ball','$tg_ball')";
	mysql_query($sql) or die ("操作失败!");
	$ouid=mysql_insert_id();
	$sql = "update web_member_data set Money='$havemoney' where UserName='$memname'";
	mysql_query($sql) or die ("操作失败!!");
	mysql_close();
?>
<html>
<head>
<meta http-equiv='Content-Type' content="text/html; charset=utf-8">
<script language=javascript>
window.setTimeout('sendsubmit()',500);
function sendsubmit(){
alert('<?=$Order_Please_check_transaction_record?>');
}
</script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
<SCRIPT>window.setTimeout("self.location='../select.php?uid=<?=$uid?>'", 45000);</SCRIPT>
</head>
<body id="OFIN" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
  <div class="ord">
    <span><h1><?=$caption?></h1></span>
      <div id="info">
       <p><?=$Order_Login_Name?><?=$memname?></p>
       <p><?=$Order_Credit_line?><?=$havemoney?></p>
       <p><em><?=$Order_Bet_success?><?=show_voucher($line,$ouid)?></em></p>
       <p><center><strong><font color='#FFFFFF' style='background-color: #FF0000'>&nbsp;<?=$Order_Pending?>&nbsp;</font></strong></center></p>
       <p class="team"><?=$s_sleague?>&nbsp;<?=$btype?>&nbsp;<?=date('m-d',strtotime($row["M_Date"]))?><BR><?=$inball?>&nbsp;&nbsp;<?=$s_mb_team?>&nbsp;<font color=#cc0000><?=$Sign?></font>&nbsp;<?=$s_tg_team?><br><em><?=$s_m_place?></em>&nbsp;@&nbsp;<em><strong><?=$w_m_rate?></strong></em></p>
       <p><?=$Order_Bet_Amount?><?=$gold?></p>
       <p><?=$Order_Estimated_Payout?><FONT id=pc color=#cc0000><?=$gwin?></FONT></p>
      </div>
       <p class="foot">
        <input type="BUTTON" name="FINISH" value="<?=$Order_Quit?>" onClick="self.location='/app/member/select.php?uid=<?=$uid?>'" class="za_button"> 
      &nbsp;&nbsp; <input type="BUTTON" name="PRINT" value="<?=$Order_Print?>" onClick="window.print()" class="za_button">
       </p>
  </div> 
</body>
</html>
