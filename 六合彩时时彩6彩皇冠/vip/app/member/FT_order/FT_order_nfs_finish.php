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
$gid=$_REQUEST['gid'];
$tid=$_REQUEST['tid'];
$gametype=$_REQUEST['gametype'];
$rtype=$_REQUEST['rtype'];
$wtype=$_REQUEST['wtype'];
$gold=$_REQUEST['gold'];
$active=$_REQUEST['active'];
$ioradio_fs=$_REQUEST['ioradio_fs'];
$line=$_REQUEST['line_type'];
$restcredit=$_REQUEST['restcredit'];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid' and Status=0 order by ID";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if ($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$memrow = mysql_fetch_array($result);
$open=$memrow['OpenType'];
$pay_type =$memrow['Pay_Type'];
$memname=$memrow['UserName'];
$agents=$memrow['Agents'];
$world=$memrow['World'];
$corprator=$memrow['Corprator'];
$super=$memrow['Super'];
$admin=$memrow['Admin'];
$HMoney=$memrow['Money'];
if ($HMoney < $restcredit){
	echo "<script language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
	exit();
}
$w_current=$memrow['CurType'];
$havemoney=$HMoney-$gold;

//判断此赛程是否已经关闭：取出此场次信息and inball=''
$mysql = "select * from match_crown where `M_Start`>now() and MID='$gid' and mshow = 'Y' and Gid='$rtype'";
$result = mysql_query($mysql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
if ($cou==0){
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit();
}else{

	//下注时间Date('Y').'-'.   $row["ShowType"]
	$m_date=date("Y-m-d",strtotime($row["M_Start"]));
	$showtype=$row["Gid"];
	$bettime=date('Y-m-d H:i:s');
	
	//联盟处理:生成写入数据库的联盟样式和显示的样式，二者有区别
	$w_sleague=$row['M_League'];
	$w_sleague_tw=$row['M_League_tw'];
	$w_sleague_en=$row['M_League_en'];
	$s_sleague=$row[$m_league];
	
	$w_sitem=$row['M_Item'];
	$w_sitem_tw=$row['M_Item_tw'];
	$w_sitem_en=$row['M_Item_en'];
	$s_sitem=$row[$m_item];
	
	//根据下注的类型进行处理：构建成新的数据格式，准备写入数据库

	$bet_type='冠军';
	$bet_type_tw="冠軍";
	$bet_type_en="Outright";
	$turn_rate="FS_Turn_FS";
	$turn="FS_Turn_FS";
	
	/*$t_mb_team=explode(",",$row['MB_Team']);
	$t_mb_team_tw=explode(",",$row['MB_Team_tw']);
	$t_mb_team_en=explode(",",$row['MB_Team_en']);
	
	$team=explode(",",$row[$mb_team]);
	$num=$row['Num'];
	$ftype=explode(",",$row['Ftype']);
	$m_rate=explode(",",$row['M_Rate']);

	for($i=0;$i<$num;$i++){
        if ($rtype==$ftype[$i]){
            $w_mb_team=$t_mb_team[$i];
			$w_mb_team_tw=$t_mb_team_tw[$i];
			$w_mb_team_en=$t_mb_team_en[$i];
			$s_mb_team=$team[$i];
            $s_m_rate=num_rate($open,$m_rate[$i]);
        }
	}*/
	
	
	$w_mb_team=$row['MB_Team'];
	$w_mb_team_tw=$row['MB_Team_tw'];
	$w_mb_team_en=$row['MB_Team_en'];
	$s_mb_team=$row[$mb_team];
	$s_m_rate=num_rate($open,$row['M_Rate']);	
	
	$gwin=($s_m_rate-1)*$gold;
	$wtype=$gametype;
	
	$lines=$row['M_League']."&nbsp;-&nbsp;".$row['M_Item']."<br>".$w_mb_team."&nbsp;&nbsp;@&nbsp;<FONT color=#CC0000><b>".$s_m_rate."</b></FONT>";	
	
	$lines_tw=$row['M_League_tw']."&nbsp;-&nbsp;".$row['M_Item_tw']."<br>".$w_mb_team_tw."&nbsp;&nbsp;@&nbsp;<FONT color=#CC0000><b>".$s_m_rate."</b></FONT>";
	
	$lines_en=$row['M_League_en']."&nbsp;-&nbsp;".$row['M_Item_en']."<br>".$w_mb_team_en."&nbsp;&nbsp;@&nbsp;<FONT color=#CC0000><b>".$s_m_rate."</b></FONT>";

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

$sql = "INSERT INTO web_report_data	(ID,QQ83068506,danger,MID,Active,LineType,Mtype,M_Date,BetTime,BetScore,Middle,Middle_tw,Middle_en,BetType,BetType_tw,BetType_en,M_Place,M_Rate,M_Name,Gwin,TurnRate,OpenType,OddsType,ShowType,Agents,World,Corprator,Super,Admin,A_Rate,B_Rate,C_Rate,D_Rate,A_Point,B_Point,C_Point,D_Point,BetIP,Ptype,Gtype,CurType,Ratio,MB_MID,TG_MID,Pay_Type,Orderby,MB_Ball,TG_Ball) values ('$id','$inball1','0','$gid','$active','$line','$w_gtype','$m_date','$bettime','$gold','$lines','$lines_tw','$lines_en','$bet_type','$bet_type_tw','$bet_type_en','$grape','$s_m_rate','$memname','$gwin','$m_turn','$open','$oddstype','$showtype','$agents','$world','$corprator','$super','$admin','$a_rate','$b_rate','$c_rate','$d_rate','$a_point','$b_point','$c_point','$d_point','$ip_addr','$wtype','FS','$w_current','$w_ratio','$w_mb_mid','$w_tg_mid','$pay_type','$order','$mb_ball','$tg_ball')";
mysql_query($sql) or die ("操作失败!");
$ouid=mysql_insert_id();
$sql = "update web_member_data set Money='$havemoney' where UserName='$memname'";
mysql_query($sql) or die ("操作失败!!");
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
<title>ft_nfs_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
<script>window.setTimeout("self.location='../select.php?uid=<?=$uid?>'", 45000);</script>
</head>
<body id="OFIN" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
  <div class="ord">
    <span><h1><?=$s_sitem?><?=$Order_betting_order?></h1></span>
    <div id="info">
      <p><?=$Order_Login_Name?><?=$memname?></p>
      <p><?=$Order_Credit_line?><?=$havemoney?></p>
      <p><em><?=$Order_Bet_success?><?=show_voucher($line,$ouid)?></em></p>
      <p class="team"><?=$s_sleague?>&nbsp;-&nbsp;<?=$s_sitem?>&nbsp;<?=date('m-d',strtotime($row["M_Start"]))?><br><?=$s_mb_team?>&nbsp;@&nbsp;<FONT COLOR="#CC0000"><B><?=$s_m_rate?></B></font></p>
      <p><?=$Order_Bet_Amount?><?=$gold?></p>
      <p><?=$Order_Estimated_Payout?><font id="pc"><?=$gwin?></font></p>
    <p class="foot">
      <input type="button" name="FINISH" value="<?=$Order_Quit?>" onClick="self.location='../select.php?uid=<?=$uid?>'" class="no">
      <input type="button" name="PRINT" value="<?=$Order_Print?>" onClick="window.print()" class="yes">
    </p>
	<div id="gfoot"></div>        
    </div>
  </div>
</body>
</html>
<?
}
mysql_close();
?>
