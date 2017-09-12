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
$teamcount=$_REQUEST['teamcount'];
$gold=$_REQUEST['gold'];
$active=$_REQUEST['active'];
$wagerDatas=$_REQUEST['wagerDatas'];
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
}else{
$memrow = mysql_fetch_array($result);
$langx=$memrow['Language'];
$opentype=$memrow['OpenType'];
$pay_type =$memrow['Pay_Type'];
$memname=$memrow['UserName'];
$hmoney=$memrow['Money'];
$agents=$memrow['Agents'];
$world=$memrow['World'];
$corprator=$memrow['Corprator'];
$super=$memrow['Super'];
$admin=$memrow['Admin'];
$w_ratio=$memrow['ratio'];
$w_current=$memrow['CurType'];
$username=$memrow['UserName'];
$HMoney=$memrow['Money'];
require ("../include/traditional.$langx.inc.php");

$wagerDatas_array=explode("|",$wagerDatas);

$rates=1;
$i=1;
for ($i=0;$i<$teamcount;$i++){
	 $data_array=explode(",",$wagerDatas_array[$i]);
	 $mid=$data_array[0];
	 $type=$data_array[1]; 
	 $rates=$rates*$data_array[5];
	 if($type!=""){
        $mysql = "select * from `match_sports` where Type='OP' and `M_Start`>now() and MID='$mid' and Cancel!=1 and Open=1 and MB_Team!='' and MB_Team_tw!='' and MB_Team_en!=''";
        $result = mysql_query($mysql);
        $cou=mysql_num_rows($result);
        $row = mysql_fetch_array($result);
        if($cou==0){
           echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
           exit();
        }else{
        $username=$memrow['UserName'];
        $HMoney=$memrow['Money'];
        if ($HMoney < $gold){
		    echo "<script language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
	  	    exit();
        }	
         //取出多种语言的主队名称，并去掉其中的“主”和“中”字样
        $w_mb_team=filiter_team(trim($row['MB_Team']));
        $w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));	
        $w_mb_team_en=filiter_team(trim($row['MB_Team_en']));
	
        $w_tg_team=filiter_team(trim($row['TG_Team']));
        $w_tg_team_tw=filiter_team(trim($row['TG_Team_tw']));
        $w_tg_team_en=filiter_team(trim($row['TG_Team_en']));
	
         //取出当前字库的主客队伍名称
        $s_mb_team=filiter_team($row[$mb_team]);
        $s_tg_team=filiter_team($row[$tg_team]);
	
         //联盟处理:生成写入数据库的联盟样式和显示的样式，二者有区别
		$w_league=$row['M_League'];
		$w_league_tw=$row['M_League_tw'];
		$w_league_en=$row['M_League_en'];
		$league=$row[$m_league];
			
		//根据下注的类型进行处理：构建成新的数据格式，准备写入数据库
		
		$bet_type=$teamcount."串1";
		$bet_type_tw=$teamcount."串1";
		$bet_type_en=$teamcount."Parlay1";
		$caption=$Order_OP.$Order_Mix_Parlay_betting_order;
		$turn_rate="OP_Turn_PR";
		$turn="OP_Turn_PR";
	    switch($type){
		case 'MH':
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$place=$s_mb_team;
			$w_m_rate=num_rate($open,$row['MB_P_Win_Rate']);
			$Mtype='MH';
			$sign   = 'VS.';
			$m_place='MH';
			$mmid="(".$row['MB_MID'].")";
			break;
		case 'MC':
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;		
			$place=$s_tg_team;
			$w_m_rate=num_rate($open,$row['TG_P_Win_Rate']);	
			$Mtype='MC';
			$sign   = 'VS.';
			$m_place='MC';
			$mmid="(".$row['TG_MID'].")";
			break;
		case 'MN':
			$w_m_place="和局";
			$w_m_place_tw="和局";
			$w_m_place_en="flat";
			$place=$Draw;
			$w_m_rate=num_rate($open,$row['M_P_Flat_Rate']);
			$Mtype='MN';
			$sign   = 'VS.';
			$m_place='MN';
			$mmid="";
			break;
		case 'PRH':
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$place=$s_mb_team;
			$w_m_rate=change_rate($open,$row["MB_P_LetB_Rate"]);
			if ($row['ShowTypeP']=='C'){
			$w_team=$w_mb_team;
			$w_mb_team=$w_tg_team;
			$w_tg_team=$w_team;
			$w_team_tw=$w_mb_team_tw;
			$w_mb_team_tw=$w_tg_team_tw;
			$w_tg_team_tw=$w_team_tw;
			$w_team_en=$w_mb_team_en;
			$w_mb_team_en=$w_tg_team_en;
			$w_tg_team_en=$w_team_en;
			$team=$s_mb_team;
			$s_mb_team=$s_tg_team;
			$s_tg_team=$team;			
			}
			$Mtype='RH';
			$sign=$row['M_P_LetB'];
			$m_place=$row['M_P_LetB'];
			$mmid="(".$row['MB_MID'].")";
			break;
		case 'PRC':
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$place=$s_tg_team;
			$w_m_rate=change_rate($open,$row["TG_P_LetB_Rate"]);
			if ($row['ShowTypeP']=='C'){
			$w_team=$w_mb_team;
			$w_mb_team=$w_tg_team;
			$w_tg_team=$w_team;
			$w_team_tw=$w_mb_team_tw;
			$w_mb_team_tw=$w_tg_team_tw;
			$w_tg_team_tw=$w_team_tw;
			$w_team_en=$w_mb_team_en;
			$w_mb_team_en=$w_tg_team_en;
			$w_tg_team_en=$w_team_en;
			$team=$s_mb_team;
			$s_mb_team=$s_tg_team;
			$s_tg_team=$team;			
			}
			$Mtype='RC';
			$sign=$row['M_P_LetB'];
			$m_place=$row['M_P_LetB'];
			$mmid="(".$row['TG_MID'].")";
			break;	
		case 'POUC':
			$w_m_place=$row["MB_P_Dime"];
			$w_m_place=str_replace('O','大&nbsp;',$w_m_place);
			$w_m_place_tw=$row["MB_P_Dime"];
			$w_m_place_tw=str_replace('O','大&nbsp;',$w_m_place_tw);
			$w_m_place_en=$row["MB_P_Dime"];
			$place=$row['MB_P_Dime'];
			if ($langx=="zh-cn"){
	            $place=str_replace('O','大&nbsp;',$place);
		    }else if ($langx=="zh-tw"){
		         $place=str_replace('O','大&nbsp;',$place);
		    }else if ($langx=="en-us" or $langx=="th-tis"){
			     $place=str_replace('O','over&nbsp;',$place);
			}
			$w_m_rate=change_rate($open,$row['MB_P_Dime_Rate']);
			$Mtype='OUH';
			$sign='VS.';
			$m_place=$row['MB_P_Dime'];
			$mmid="(".$row['MB_MID'].")";
			break;
		case 'POUH':
			$w_m_place=$row["TG_P_Dime"];
			$w_m_place=str_replace('U','小&nbsp;',$w_m_place);
			$w_m_place_tw=$row["TG_P_Dime"];
			$w_m_place_tw=str_replace('U','小&nbsp;',$w_m_place_tw);
			$w_m_place_en=$row["TG_P_Dime"];	
			$place=$row['TG_P_Dime'];
		    if ($langx=="zh-cn"){
		        $place=str_replace('U','小&nbsp;',$place);
		    }else if ($langx=="zh-tw"){
		        $place=str_replace('U','小&nbsp;',$place);
			}else if ($langx=="en-us" or $langx=="th-tis"){
			    $place=str_replace('U','under&nbsp;',$place);
			 }
			$w_m_rate=change_rate($open,$row['TG_P_Dime_Rate']);
			$Mtype='OUC';
			$sign='VS.';
			$m_place=$row['TG_P_Dime'];
			$mmid="(".$row['TG_MID'].")";												
			break;
		case 'PO':
			$w_m_place='单';
			$w_m_place_tw='單';
			$w_m_place_en='odd';		
			$place="(".$o.")";
			$w_m_rate=num_rate($open,$row["S_P_Single_Rate"]);
			$Mtype='ODD';
			$sign   = 'VS.';
			$m_place='ODD';
			$mmid="(".$row['MB_MID'].")";
			break;
		case 'PE':
			$w_m_place='双';
			$w_m_place_tw='雙';
			$w_m_place_en='even';
			$place='('.$e.')';
			$w_m_rate=num_rate($open,$row["S_P_Double_Rate"]);	
			$Mtype='EVEN';
			$sign   = 'VS.';
			$m_place='EVEN';
			$mmid="(".$row['TG_MID'].")";
			break;
		case 'HPMH':
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$place=$s_mb_team;
			$w_m_rate=num_rate($open,$row['MB_P_Win_Rate_H']);
			$Mtype='VMH';
			$sign   = 'VS.';
			$m_place='VMH';
			$mmid="(".$row['MB_MID'].")";
			break;
		case 'HPMC':
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;		
			$place=$s_tg_team;
			$w_m_rate=num_rate($open,$row['TG_P_Win_Rate_H']);	
			$Mtype='VMC';
			$sign   = 'VS.';
			$m_place='VMC';
			$mmid="(".$row['TG_MID'].")";
			break;
		case 'HPMN':
			$w_m_place="和局";
			$w_m_place_tw="和局";
			$w_m_place_en="flat";
			$place=$Draw;
			$w_m_rate=num_rate($open,$row['M_P_Flat_Rate_H']);
			$Mtype='VMN';
			$sign   = 'VS.';
			$m_place='VMN';
			$mmid="";
			break;
		case 'HPRH':
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$place=$s_mb_team;
			$w_m_rate=change_rate($open,$row["MB_P_LetB_Rate_H"]);
			if ($row['ShowTypeHP']=='C'){
			$w_team=$w_mb_team;
			$w_mb_team=$w_tg_team;
			$w_tg_team=$w_team;
			$w_team_tw=$w_mb_team_tw;
			$w_mb_team_tw=$w_tg_team_tw;
			$w_tg_team_tw=$w_team_tw;
			$w_team_en=$w_mb_team_en;
			$w_mb_team_en=$w_tg_team_en;
			$w_tg_team_en=$w_team_en;
			$team=$s_mb_team;
			$s_mb_team=$s_tg_team;
			$s_tg_team=$team;			
			}
			$Mtype='VRH';
			$sign=$row['M_P_LetB_H'];
			$m_place=$row['M_P_LetB_H'];
			$mmid="(".$row['MB_MID'].")";
			break;
		case 'HPRC':
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$place=$s_tg_team;
			$w_m_rate=change_rate($open,$row["TG_P_LetB_Rate_H"]);
			if ($row['ShowTypeHP']=='C'){
			$w_team=$w_mb_team;
			$w_mb_team=$w_tg_team;
			$w_tg_team=$w_team;
			$w_team_tw=$w_mb_team_tw;
			$w_mb_team_tw=$w_tg_team_tw;
			$w_tg_team_tw=$w_team_tw;
			$w_team_en=$w_mb_team_en;
			$w_mb_team_en=$w_tg_team_en;
			$w_tg_team_en=$w_team_en;
			$team=$s_mb_team;
			$s_mb_team=$s_tg_team;
			$s_tg_team=$team;			
			}
			$Mtype='VRC';
			$sign=$row['M_P_LetB_H'];
			$m_place=$row['M_P_LetB_H'];
			$mmid="(".$row['TG_MID'].")";
			break;	
		case 'HPOUC':
			$w_m_place=$row["MB_P_Dime_H"];
			$w_m_place=str_replace('O','大&nbsp;',$w_m_place);
			$w_m_place_tw=$row["MB_P_Dime_H"];
			$w_m_place_tw=str_replace('O','大&nbsp;',$w_m_place_tw);
			$w_m_place_en=$row["MB_P_Dime_H"];
			$place=$row['MB_P_Dime_H'];
			if ($langx=="zh-cn"){
	            $place=str_replace('O','大&nbsp;',$place);
		    }else if ($langx=="zh-tw"){
		        $place=str_replace('O','大&nbsp;',$place);
		    }else if ($langx=="en-us" or $langx=="th-tis"){
			    $place=str_replace('O','over&nbsp;',$place);
			}
			$w_m_rate=change_rate($open,$row['MB_P_Dime_Rate_H']);
			$Mtype='VOUH';
			$sign='VS.';
			$m_place=$row["MB_P_Dime_H"];
			$mmid="(".$row['MB_MID'].")";
			break;
		case 'HPOUH':
			$w_m_place=$row["TG_P_Dime_H"];
			$w_m_place=str_replace('U','小&nbsp;',$w_m_place);
			$w_m_place_tw=$row["TG_P_Dime_H"];
			$w_m_place_tw=str_replace('U','小&nbsp;',$w_m_place_tw);
			$w_m_place_en=$row["TG_P_Dime_H"];	
			$place=$row['TG_P_Dime_H'];
		    if ($langx=="zh-cn"){
		        $place=str_replace('U','小&nbsp;',$place);
		    }else if ($langx=="zh-tw"){
		        $place=str_replace('U','小&nbsp;',$place);
		    }else if ($langx=="en-us" or $langx=="th-tis"){
			    $place=str_replace('O','under&nbsp;',$place);
			}
			$w_m_rate=change_rate($open,$row['TG_P_Dime_Rate_H']);
			$Mtype='VOUC';
			$sign='VS.';
			$m_place=$row["TG_P_Dime_H"];
			$mmid="(".$row['TG_MID'].")";												
			break;	
		}	
		
		if ($type=='HPMH' or $type=='HPMC' or $type=='HPMN' or $type=='HPRH' or $type=='HPRC' or $type=='HPOUH' or $type=='HPOUC'){
		     $title="<FONT COLOR=#BB0000>-&nbsp;[$Order_1st_Half]</FONT>";
			 $title_cn="-&nbsp;<font color=#666666>[上半]</font>";
			 $title_tw="-&nbsp;<font color=#666666>[上半]</font>";
			 $title_en="-&nbsp;<font color=#666666>[1st Half]</font>";
		}else{
		 	 $title="";
			 $title_cn="";
			 $title_tw="";
			 $title_en="";
		}
		$date=date('m-d',strtotime($row["M_Date"]));
		$lines=$lines.$row['M_League']."&nbsp;".$date."<br>";
		$lines=$lines.$w_mb_team."&nbsp;<FONT color=#CC0000>".$sign."</FONT>&nbsp;".$w_tg_team."<br>";
		$lines=$lines."<FONT color=#cc0000>".$mmid."&nbsp;".$w_m_place."&nbsp;".$title_cn."</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".number_format($w_m_rate,2)."</b></FONT><br>";
		
		$lines_tw=$lines_tw.$row['M_League_tw']."&nbsp;".$date."<br>";
		$lines_tw=$lines_tw.$w_mb_team_tw."&nbsp;<FONT color=#CC0000>".$sign."</FONT>&nbsp;".$w_tg_team_tw."<br>";
		$lines_tw=$lines_tw."<FONT color=#cc0000>".$mmid."&nbsp;".$w_m_place_tw."&nbsp;".$title_tw."</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".number_format($w_m_rate,2)."</b></FONT><br>";
		
		$lines_en=$lines_en.$row['M_League_en']."&nbsp;".$date."<br>";
		$lines_en=$lines_en.$w_mb_team_en."&nbsp;<FONT color=#CC0000>".$sign."</FONT>&nbsp;".$w_tg_team_en."<br>";
		$lines_en=$lines_en."<FONT color=#cc0000>".$mmid."&nbsp;".$w_m_place_en."&nbsp;".$title_en."</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".number_format($w_m_rate,2)."</b></FONT><br>";
			
		$betplace=$betplace.$league."&nbsp;".$title."<br>";
		$betplace=$betplace.$s_mb_team."&nbsp;<FONT color=#CC0000>".$sign."</FONT>&nbsp;".$s_tg_team."<br>";
		$betplace=$betplace."<FONT color=#cc0000>".$mmid."&nbsp;".$place."</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".number_format($w_m_rate,2)."</b></FONT><br><br>";
		$m_gid[]=$mid;
		$m_rate[]=$w_m_rate;
		$ktype[]=$Mtype;
		$show_type[]=$row['ShowTypeP'];
		$r_place[]=$m_place;
	   }
	 }
}
$gid=implode(",",$m_gid);
$gtype=implode(",",$ktype);
$w_m_rate=implode(",",$m_rate);
$grape=implode(",",$r_place);
$showtype=implode(",",$show_type);
$gwin=round($gold*$rates-$gold,2);
$ptype='PR';
$line=8;
$date=$row["M_Date"];
$bettime=date('Y-m-d H:i:s');
$betid=strtoupper(substr(md5(time()),0,rand(17,20)));
$ip_addr = get_ip();

$turn_rate="OP_Turn_PR";
$turn="OP_Turn_PR";
	
$msql = "select OP_Turn_PR as M_turn from web_member_data where UserName='$memname'";
$result = mysql_query($msql);
$mrow = mysql_fetch_array($result);
$m_turn=$mrow['M_turn']+0;

$asql = "select OP_Turn_PR as A_turn from web_agents_data where UserName='$super'";
$result = mysql_query($asql);
$arow = mysql_fetch_array($result);
$a_rate=$arow['A_turn']+0;

$bsql = "select OP_Turn_PR as B_turn from web_agents_data where UserName='$corprator'";
$result = mysql_query($bsql);
$brow = mysql_fetch_array($result);
$b_rate=$brow['B_turn']+0;

$csql = "select OP_Turn_PR as C_turn from web_agents_data where UserName='$world'";
$result = mysql_query($csql);
$crow = mysql_fetch_array($result);
$c_rate=$crow['C_turn']+0;

$dsql = "select OP_Turn_PR as D_turn from web_agents_data where UserName='$agents'";
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

$sql = "INSERT INTO web_report_data	(ID,MID,Active,LineType,Mtype,M_Date,BetTime,BetScore,Middle,Middle_tw,Middle_en,BetType,BetType_tw,BetType_en,M_Place,M_Rate,M_Name,Gwin,TurnRate,OpenType,ShowType,Agents,World,Corprator,Super,Admin,A_Rate,B_Rate,C_Rate,D_Rate,A_Point,B_Point,C_Point,D_Point,BetIP,Ptype,Gtype,CurType,Ratio,BetID,MB_MID,TG_MID,Pay_Type,Orderby,MB_Ball,TG_Ball) values ('$id','$gid','$active','$line','$gtype','$date','$bettime','$gold','$lines','$lines_tw','$lines_en','$bet_type','$bet_type_tw','$bet_type_en','$grape','$w_m_rate','$memname','$gwin','$m_turn','$opentype','$showtype','$agents','$world','$corprator','$super','$admin','$a_rate','$b_rate','$c_rate','$d_rate','$a_point','$b_point','$c_point','$d_point','$ip_addr','$ptype','OP','$w_current','$w_ratio','$betid','$w_mb_mid','$w_tg_mid','$pay_type','$order','$mb_ball','$tg_ball')";
mysql_query($sql) or die ("操作失败!");
$ouid=mysql_insert_id();
$havemoney=$HMoney-$gold;
$sql = "update web_member_data set Money='$havemoney' where UserName='$memname'";
mysql_query($sql) or die ("操作失败!!");

if ($active==66){
	$caption=str_replace($Order_Other,$Order_Other.$Order_Early_Market,$caption);
}
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
       <p class="team"><?=$betplace?></p>
       <p><?=$Order_Bet_Amount?><?=$gold?></p>
       <p><?=$Order_Estimated_Payout?><FONT id=pc color=#cc0000><?=$gwin?></FONT></p>
      </div>
       <p class="foot">
        <input type="BUTTON" name="FINISH" value="<?=$Order_Quit?>" onClick="self.location='/app/member/select.php?uid=<?=$uid?>'" class="no"> 
      &nbsp;&nbsp; <input type="BUTTON" name="PRINT" value="<?=$Order_Print?>" onClick="window.print()" class="yes">
       </p>
  </div>  
</body>
</html>
<?
mysql_close();
}
?>
