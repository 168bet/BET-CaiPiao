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
//接收传递过来的参数：其中赔率和位置需要进行判断
$gold=$_REQUEST['gold'];
$uid=$_REQUEST['uid'];
$active=$_REQUEST['active'];
$strong=$_REQUEST['strong'];
$line=$_REQUEST['line_type'];
$gid=$_REQUEST['gid'];
$type=$_REQUEST['type'];
$rtype=$_REQUEST['rtype'];
$gnum=$_REQUEST['gnum'];
$ioradio_r_h=$_REQUEST['ioradio_r_h'];
$ioradio_pd=$_REQUEST['ioradio_pd'];
$ioradio_f=$_REQUEST['ioradio_f'];
$odd_f_type=$_REQUEST['odd_f_type'];
if($userid<=0){
		header( "Content-Type:   text/html;   charset=UTF-8 ");
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';</script>\n";	
}
//下注时的赔率：应该根据盘口进行转换后，与数据库中的赔率进行比较。若不相同，返回下注。
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

$mysql = "select * from `match_sports` where `M_Start`>now() and `MID`=$gid and Cancel!=1 and Open=1 and MB_Team!='' and MB_Team_tw!='' and MB_Team_en!=''";//判断此赛程是否已经关闭：取出此场次信息
$result = mysql_query($mysql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
if($cou==0){
	echo attention("$Order_This_match_is_closed_Please_try_again",$uid,$langx);
	exit();
}else{
	//取出写入数据库的四种语言的客队名称
	$w_tg_team=$row['TG_Team'];
	$w_tg_team_tw=$row['TG_Team_tw'];
	$w_tg_team_en=$row['TG_Team_en'];
	
	//取出四种语言的主队名称，并去掉其中的“主”和“中”字样
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));
	
	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];	
	
	//取出当前字库的主客队伍名称
	$s_mb_team=filiter_team($row[$mb_team]);
	$s_tg_team=filiter_team($row[$tg_team]);
	
	//联盟处理:生成写入数据库的联盟样式和显示的样式，二者有区别
	$s_sleague=$row[$m_league];
	
	//下注时间
	$m_date=$row["M_Date"];
	$showtype=$row["ShowTypeR"];
	$bettime=date('Y-m-d H:i:s');
		
	//根据下注的类型进行处理：构建成新的数据格式，准备写入数据库
	switch ($line){
  	case 1:
	  	$bet_type='独赢';
		$bet_type_tw='獨贏';
		$bet_type_en="1x2";
		$caption=$Order_Other.$Order_1_x_2_betting_order;
		$turn_rate="OP_Turn_M";
		$turn="OP_Turn_M";
		switch ($type){
		case "H":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$s_m_place=$s_mb_team;
			$w_m_rate=num_rate($open,$row["MB_Win_Rate"]);
			$mtype='MH';
			break;
		case "C":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$s_m_place=$s_tg_team;
			$w_m_rate=num_rate($open,$row["TG_Win_Rate"]);
			$mtype='MC';
			break;
		case "N":
			$w_m_place="和局";
			$w_m_place_tw="和局";
			$w_m_place_en="Flat";
			$s_m_place=$Draw;
			$w_m_rate=num_rate($open,$row["M_Flat_Rate"]);
			$mtype='MN';
			break;
		}
		$Sign="VS.";
		$grape="";
		$gwin=($w_m_rate-1)*$gold;
		$ptype='M';
	break;
	case 2:
	  	$bet_type='让球';
		$bet_type_tw="讓球";
		$bet_type_en="Handicap";	
		$caption=$Order_Other.$Order_Handicap_betting_order;
		$turn_rate="OP_Turn_R_".$open;
		$rate=get_other_ioratio($odd_f_type,$row["MB_LetB_Rate"],$row["TG_LetB_Rate"],100);
		switch ($type){
		case "H":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$s_m_place=$s_mb_team;
			$w_m_rate=change_rate($open,$rate[0]);
			$turn_url="/app/member/OP_order/OP_order_r.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&strong=".$strong."&odd_f_type=".$odd_f_type;
			$mtype='RH';
			break;
		case "C":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$s_m_place=$s_tg_team;
			$w_m_rate=change_rate($open,$rate[1]);
			$turn_url="/app/member/OP_order/OP_order_r.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&strong=".$strong."&odd_f_type=".$odd_f_type;
			$mtype='RC';
			break;
		}
		$Sign=$row['M_LetB'];
		$grape=$Sign;
		if ($showtype=="H"){
			$l_team=$s_mb_team;
			$r_team=$s_tg_team;
			$w_l_team=$w_mb_team;
			$w_l_team_tw=$w_mb_team_tw;
			$w_l_team_en=$w_mb_team_en;
			$w_r_team=$w_tg_team;
			$w_r_team_tw=$w_tg_team_tw;
			$w_r_team_en=$w_tg_team_en;
		}else{
			$r_team=$s_mb_team;
			$l_team=$s_tg_team;
			$w_r_team=$w_mb_team;
			$w_r_team_tw=$w_mb_team_tw;
			$w_r_team_en=$w_mb_team_en;
			$w_l_team=$w_tg_team;
			$w_l_team_tw=$w_tg_team_tw;
			$w_l_team_en=$w_tg_team_en;
		}
		$s_mb_team=$l_team;
		$s_tg_team=$r_team;
		$w_mb_team=$w_l_team;
		$w_mb_team_tw=$w_l_team_tw;
		$w_mb_team_en=$w_l_team_en;
		$w_tg_team=$w_r_team;
		$w_tg_team_tw=$w_r_team_tw;
		$w_tg_team_en=$w_r_team_en;
		
		$turn="OP_Turn_R";
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
		$ptype='R';
	break;
	case 3:
		$bet_type='大小';
		$bet_type_tw="大小";
		$bet_type_en="Over/Under";
		$caption=$Order_Other.$Order_Over_Under_betting_order;
		$turn_rate="OP_Turn_OU_".$open;
		$rate=get_other_ioratio($odd_f_type,$row["MB_Dime_Rate"],$row["TG_Dime_Rate"],100);
		switch ($type){
		case "C":
			$w_m_place=$row["MB_Dime"];
			$w_m_place=str_replace('O','大&nbsp;',$w_m_place);
			$w_m_place_tw=$row["MB_Dime"];
			$w_m_place_tw=str_replace('O','大&nbsp;',$w_m_place_tw);
			$w_m_place_en=$row["MB_Dime"];
			$w_m_place_en=str_replace('O','over&nbsp;',$w_m_place_en);
			
			$m_place=$row["MB_Dime"];
			
			$s_m_place=$row["MB_Dime"];
			if ($langx=="zh-cn"){
	            $s_m_place=str_replace('O','大&nbsp;',$s_m_place);
		    }else if ($langx=="zh-tw"){
		        $s_m_place=str_replace('O','大&nbsp;',$s_m_place);
		    }else if ($langx=="en-us" or $langx=="th-tis"){
		        $s_m_place=str_replace('O','over&nbsp;',$s_m_place);
		    }
			$w_m_rate=change_rate($open,$rate[0]);
			$turn_url="/app/member/OP_order/OP_order_ou.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&odd_f_type=".$odd_f_type;
			$mtype='OUH';			
			break;
		case "H":
			$w_m_place=$row["TG_Dime"];
			$w_m_place=str_replace('U','小&nbsp;',$w_m_place);
			$w_m_place_tw=$row["TG_Dime"];
			$w_m_place_tw=str_replace('U','小&nbsp;',$w_m_place_tw);
			$w_m_place_en=$row["TG_Dime"];
			$w_m_place_en=str_replace('U','under&nbsp;',$w_m_place_en);
			
			$m_place=$row["TG_Dime"];
			
			$s_m_place=$row["TG_Dime"];
			if ($langx=="zh-cn"){
	            $s_m_place=str_replace('U','小&nbsp;',$s_m_place);
		    }else if ($langx=="zh-tw"){
		        $s_m_place=str_replace('U','小&nbsp;',$s_m_place);
		    }else if ($langx=="en-us" or $langx=="th-tis"){
		        $s_m_place=str_replace('U','under&nbsp;',$s_m_place);
		    }
			
			$w_m_rate=change_rate($open,$rate[1]);
			$turn_url="/app/member/OP_order/OP_order_ou.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&odd_f_type=".$odd_f_type;
			$mtype='OUC';		
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
		$ptype='OU';		
	break;
	case 4:
	  	$bet_type='波胆';
		$bet_type_tw="波膽";
		$bet_type_en="Correct Score";
		$caption=$Order_Other.$Order_Correct_Score_betting_order;
		$turn_rate="OP_Turn_PD";
		if($rtype!='OVH'){
		$rtype=str_replace('C','TG',str_replace('H','MB',$rtype));
		$w_m_rate=$row[$rtype];
		}else{
		$w_m_rate=$row['UP5'];
		}
		if ($rtype=="OVH"){		
			$s_m_place=$Order_Other_Score;
			$w_m_place='其它比分';
			$w_m_place_tw='其它比分';
			$w_m_place_en='Other Score';
			$Sign="VS.";
		}else{
			$M_Place="";
			$M_Sign=$rtype;
			$M_Sign=str_replace("MB","",$M_Sign);
			$M_Sign=str_replace("TG",":",$M_Sign);
			$Sign=$M_Sign."";
		}
		$grape="";
		$turn="OP_Turn_PD";
		$order='B';
		$gwin=($w_m_rate-1)*$gold;		
		$ptype='PD';		
		$mtype=$rtype;
	break;
	case 5:
		$bet_type='单双';
		$bet_type_tw="單雙";
		$bet_type_en="Odd/Even";
		$caption=$Order_Other.$Order_Odd_Even_betting_order;
		$turn_rate="OP_Turn_EO_".$open;
		switch ($rtype){
		case "ODD":
			$w_m_place='单';
			$w_m_place_tw='單';
			$w_m_place_en='odd';
			$s_m_place='('.$Order_Odd.')';
			$w_m_rate=num_rate($open,$row["S_Single"]);
			break;
		case "EVEN":
			$w_m_place='双';
			$w_m_place_tw='雙';
			$w_m_place_en='even';
			$s_m_place='('.$Order_Even.')';
			$w_m_rate=num_rate($open,$row["S_Double"]);
			break;
		}
		$Sign="VS.";
		$turn="OP_Turn_EO";
		$order='B';
		$gwin=($w_m_rate-1)*$gold;
		$ptype='EO';	
		$mtype=$rtype;
	break;
	case 6:
		$bet_type='总入球';
		$bet_type_tw="總入球";
		$bet_type_en="Total";
		$caption=$Order_Other.$Order_Total_Goals_betting_order;
		$turn_rate="OP_Turn_T";
		switch ($rtype){
		case "0~1":
			$w_m_place='0~1';
			$w_m_place_tw='0~1';
			$w_m_place_en='0~1';
			$s_m_place='(0~1)';
			$w_m_rate=$row["S_0_1"];
			break;
		case "2~3":
			$w_m_place='2~3';
			$w_m_place_tw='2~3';
			$w_m_place_en='2~3';
			$s_m_place='(2~3)';
			$w_m_rate=$row["S_2_3"];
			break;
		case "4~6":
			$w_m_place='4~6';
			$w_m_place_tw='4~6';
			$w_m_place_en='4~6';
			$s_m_place='(4~6)';
			$w_m_rate=$row["S_4_6"];
			break;
		case "OVER":
			$w_m_place='7up';
			$w_m_place_tw='7up';
			$w_m_place_en='7up';
			$s_m_place='(7up)';
			$w_m_rate=$row["S_7UP"];
			break;
		}
		$turn="OP_Turn_T";
		$Sign="VS.";
		$order='B';
		$gwin=($w_m_rate-1)*$gold;
		$ptype='T';
		$mtype=$rtype;				
	break;
	case 7:
		$bet_type='半全场';
		$bet_type_tw="半全場";
		$bet_type_en="Half/Full Time";	
		$caption=$Order_Other.$Order_Half_Full_Time_betting_order;
		$turn_rate="OP_Turn_F";
		switch ($rtype){
		case "FHH":
			$w_m_place=$w_mb_team.'&nbsp;/&nbsp;'.$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw.'&nbsp;/&nbsp;'.$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en.'&nbsp;/&nbsp;'.$w_mb_team_en;		
			$s_m_place=$row[$mb_team].'&nbsp;/&nbsp;'.$row[$mb_team];
			$w_m_rate=$row["MBMB"];
			break;
		case "FHN":
			$w_m_place=$w_mb_team.'&nbsp;/&nbsp;和局';
			$w_m_place_tw=$w_mb_team_tw.'&nbsp;/&nbsp;和局';
			$w_m_place_en=$w_mb_team_en.'&nbsp;/&nbsp;Flat';		
			$s_m_place=$row[$mb_team].'&nbsp;/&nbsp;'.$Draw;		
			$w_m_rate=$row["MBFT"];
			break;
		case "FHC":
			$w_m_place=$w_mb_team.'&nbsp;/&nbsp;'.$w_tg_team;
			$w_m_place_tw=$w_mb_team_tw.'&nbsp;/&nbsp;'.$w_tg_team_tw;
			$w_m_place_en=$w_mb_team_en.'&nbsp;/&nbsp;'.$w_tg_team_en;
			$s_m_place=$row[$mb_team].'&nbsp;/&nbsp;'.$row[$tg_team];
			$w_m_rate=$row["MBTG"];
			break;
		case "FNH":
			$w_m_place='和局&nbsp;/&nbsp;'.$w_mb_team;
			$w_m_place_tw='和局&nbsp;/&nbsp;'.$w_mb_team_tw;
			$w_m_place_en='Flat&nbsp;/&nbsp;'.$w_mb_team_en;
			$s_m_place=$Draw.'&nbsp;/&nbsp;'.$row[$mb_team];
			$w_m_rate=$row["FTMB"];
			break;
		case "FNN":
			$w_m_place='和局&nbsp;/&nbsp;和局';
			$w_m_place_tw='和局&nbsp;/&nbsp;和局';
			$w_m_place_en='Flat&nbsp;/&nbsp;Flat';
			$s_m_place=$Draw.'&nbsp;/&nbsp;'.$Draw;
			$w_m_rate=$row["FTFT"];
			break;
		case "FNC":
			$w_m_place='和局&nbsp;/&nbsp;'.$w_tg_team;
			$w_m_place_tw='和局&nbsp;/&nbsp;'.$w_tg_team_tw;
			$w_m_place_en='Flat&nbsp;/&nbsp;'.$w_tg_team_en;
			$s_m_place=$Draw.'&nbsp;/&nbsp;'.$row[$tg_team];	
			$w_m_rate=$row["FTTG"];
			break;
		case "FCH":
			$w_m_place=$w_tg_team.'&nbsp;/&nbsp;'.$w_mb_team;
			$w_m_place_tw=$w_tg_team_tw.'&nbsp;/&nbsp;'.$w_mb_team_tw;
			$w_m_place_en=$w_tg_team_en.'&nbsp;/&nbsp;'.$w_mb_team_en;
			$s_m_place=$row[$tg_team].'&nbsp;/&nbsp;'.$row[$mb_team];
			$w_m_rate=$row["TGMB"];
			break;
		case "FCN":
			$w_m_place=$w_tg_team.'&nbsp;/&nbsp;和局';
			$w_m_place_tw=$w_tg_team_tw.'&nbsp;/&nbsp;和局';
			$w_m_place_en=$w_tg_team_en.'&nbsp;/&nbsp;Flat';
			$s_m_place=$row[$tg_team].'&nbsp;/&nbsp;'.$Draw;
			$w_m_rate=$row["TGFT"];
			break;
		case "FCC":
			$w_m_place=$w_tg_team.'&nbsp;/&nbsp;'.$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw.'&nbsp;/&nbsp;'.$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en.'&nbsp;/&nbsp;'.$w_tg_team_en;
			$s_m_place=$row[$tg_team].'&nbsp;/&nbsp;'.$row[$tg_team];
			$w_m_rate=$row["TGTG"];
			break;
		}
		$Sign="VS.";
		$turn="OP_Turn_F";
		$gwin=($w_m_rate-1)*$gold;		
		$ptype='F';
		$mtype=$rtype;								
	break;	
	case 11:
	  	$bet_type='半场独赢';
		$bet_type_tw="半場獨贏";
		$bet_type_en="1st Half 1x2";
		$btype="-&nbsp;<font color=red><b>[$Order_1st_Half]</b></font>";
		$caption=$Order_Other.$Order_1st_Half_1_x_2_betting_order;
		$turn_rate="OP_Turn_M";
		$turn="OP_Turn_M";
		switch ($type){
		case "H":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$s_m_place=$row[$mb_team];
			$w_m_rate=num_rate($open,$row["MB_Win_Rate_H"]);
			$mtype='VMH';
			break;
		case "C":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$s_m_place=$row[$tg_team];
			$w_m_rate=num_rate($open,$row["TG_Win_Rate_H"]);
			$mtype='VMC';
			break;
		case "N":
			$w_m_place="和局";
			$w_m_place_tw="和局";
			$w_m_place_en="Flat";
			$s_m_place=$Draw;
			$w_m_rate=num_rate($open,$row["M_Flat_Rate_H"]);
			$mtype='VMN';
			break;
		}
		$Sign="VS.";
		$grape="";
		$gwin=($w_m_rate-1)*$gold;
		$ptype='VM';
	break;
	case 12:
		$bet_type='半场让球';
		$bet_type_tw="半場讓球";
		$bet_type_en="1st Half Handicap";
		$btype="-&nbsp;<font color=red><b>[$Order_1st_Half]</b></font>";
		$caption=$Order_Other.$Order_1st_Half_Handicap_betting_order;
		$turn_rate="OP_Turn_R_".$open;
		$rate=get_other_ioratio($odd_f_type,$row["MB_LetB_Rate_H"],$row["TG_LetB_Rate_H"],100);
		switch ($type){
		case "H":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$s_m_place=$row[$mb_team];
			$w_m_rate=change_rate($open,$rate[0]);
			$turn_url="/app/member/OP_order/OP_order_hr.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&strong=".$strong."&odd_f_type=".$odd_f_type;
			$mtype='VRH';
			break;
		case "C":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$s_m_place=$row[$tg_team];
			$w_m_rate=change_rate($open,$rate[1]);
			$turn_url="/app/member/OP_order/OP_order_hr.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&strong=".$strong."&odd_f_type=".$odd_f_type;
			$mtype='VRC';
			break;
		}
		$Sign=$row['M_LetB_H'];
		$grape=$Sign;
		if ($showtype=="H"){
			$l_team=$s_mb_team;
			$r_team=$s_tg_team;
			
			$w_l_team=$w_mb_team;
			$w_l_team_tw=$w_mb_team_tw;
			$w_l_team_en=$w_mb_team_en;
			$w_r_team=$w_tg_team;
			$w_r_team_tw=$w_tg_team_tw;
			$w_r_team_en=$w_tg_team_en;
		}else{
			$r_team=$s_mb_team;
			$l_team=$s_tg_team;
			$w_r_team=$w_mb_team;
			$w_r_team_tw=$w_mb_team_tw;
			$w_r_team_en=$w_mb_team_en;
			$w_l_team=$w_tg_team;
			$w_l_team_tw=$w_tg_team_tw;
			$w_l_team_en=$w_tg_team_en;
		}
		$s_mb_team=$l_team;
		$s_tg_team=$r_team;
		$w_mb_team=$w_l_team;
		$w_mb_team_tw=$w_l_team_tw;
		$w_mb_team_en=$w_l_team_en;
		$w_tg_team=$w_r_team;
		$w_tg_team_tw=$w_r_team_tw;
		$w_tg_team_en=$w_r_team_en;
		$turn="OP_Turn_R";
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
		$ptype='VR';
	break;
	case 13:
  		$bet_type='半场大小';
		$bet_type_tw="半場大小";
		$bet_type_en="1st Half Over/Under";
		$caption=$Order_Other.$Order_1st_Half_Over_Under_betting_order;
		$btype="-&nbsp;<font color=red><b>[$Order_1st_Half]</b></font>";
		$turn_rate="OP_Turn_OU_".$open;
		$rate=get_other_ioratio($odd_f_type,$row["MB_Dime_Rate_H"],$row["TG_Dime_Rate_H"],100);
		switch ($type){
		case "C":
			$w_m_place=$row["MB_Dime_H"];
			$w_m_place=str_replace('O','大&nbsp;',$w_m_place);
			$w_m_place_tw=$row["MB_Dime_H"];
			$w_m_place_tw=str_replace('O','大&nbsp;',$w_m_place_tw);
			$w_m_place_en=$row["MB_Dime_H"];
			$w_m_place_en=str_replace('O','over&nbsp;',$w_m_place_en);
			
			$m_place=$row["MB_Dime_H"];
			
			$s_m_place=$row["MB_Dime_H"];
			if ($langx=="zh-cn"){
	            $s_m_place=str_replace('O','大&nbsp;',$s_m_place);
		    }else if ($langx=="zh-tw"){
		        $s_m_place=str_replace('O','大&nbsp;',$s_m_place);
		    }else if ($langx=="en-us" or $langx=="th-tis"){
		        $s_m_place=str_replace('O','over&nbsp;',$s_m_place);
			}
			$w_m_rate=change_rate($open,$rate[0]);
			$turn_url="/app/member/OP_order/OP_order_hou.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&odd_f_type=".$odd_f_type;
			$mtype='VOUH';		
			break;
		case "H":
			$w_m_place=$row["TG_Dime_H"];
			$w_m_place=str_replace('U','小&nbsp;',$w_m_place);
			$w_m_place_tw=$row["TG_Dime_H"];
			$w_m_place_tw=str_replace('U','小&nbsp;',$w_m_place_tw);
			$w_m_place_en=$row["TG_Dime_H"];
			$w_m_place_en=str_replace('U','under&nbsp;',$w_m_place_en);
			
			$m_place=$row["TG_Dime_H"];
			
			$s_m_place=$row["TG_Dime_H"];
			if ($langx=="zh-cn"){
	            $s_m_place=str_replace('U','小&nbsp;',$s_m_place);
		    }else if ($langx=="zh-tw"){
		        $s_m_place=str_replace('U','小&nbsp;',$s_m_place);
		    }else if ($langx=="en-us" or $langx=="th-tis"){
		        $s_m_place=str_replace('U','under&nbsp;',$s_m_place);
			}
			$w_m_rate=change_rate($open,$rate[1]);	
			$turn_url="/app/member/OP_order/OP_order_hou.php?gid=".$gid."&uid=".$uid."&type=".$type."&gnum=".$gnum."&odd_f_type=".$odd_f_type;
			$mtype='VOUC';
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
		$ptype='VOU';		
	break;
	case 14:
	  	$bet_type='半场波胆';
		$bet_type_tw="半場波膽";
		$bet_type_en="1st Half Correct Score";
		$caption=$Order_Other.$Order_1st_Half_Correct_Score_betting_order;
		$turn_rate="OP_Turn_PD";
		if($rtype!='OVH'){
		$rtype=str_replace('C','TG',str_replace('H','MB',$rtype));
		$w_m_rate=$row[$rtype];
		}else{
		$w_m_rate=$row['UP5V'];
		}
		if ($rtype=="OVH"){		
			$s_m_place=$Order_Other_Score;
			$w_m_place='其它比分';
			$w_m_place_tw='其它比分';
			$w_m_place_en='Other Score';
			$Sign="VS.";
		}else{
			$M_Place="";
			$M_Sign=$rtype;
			$M_Sign=str_replace("MB","",$M_Sign);
			$M_Sign=str_replace("TG",":",$M_Sign);
			$Sign=$M_Sign."";
		}
		$grape="";
		$turn="OP_Turn_PD";
		$order='B';
		$gwin=($w_m_rate-1)*$gold;		
		$ptype='VPD';		
		$mtype=$rtype;
	break;
	}

	if ($line==11 or $line==12 or $line==13 or $line==14){
		$bottom1_tw="-&nbsp;<font color=#666666>[上半]</font>&nbsp;";
		$bottom1="-&nbsp;<font color=#666666>[上半]</font>&nbsp;";
		$bottom1_en="-&nbsp;<font color=#666666>[1st Half]</font>&nbsp;";
	}
	
	if ($line==2 or $line==3 or $line==12 or $line==13){
		if ($w_m_rate!=$ioradio_r_h){
		    $turn_url=$turn_url.'&error_flag=1';
		    echo "<script language='javascript'>self.location='$turn_url';</script>";
		    exit();
		}
		$oddstype=$odd_f_type;
	}else{
		$oddstype='';
	}
	$s_m_place=filiter_team(trim($s_m_place));
	
	$w_mid="<br>[".$row['MB_MID']."]vs[".$row['TG_MID']."]<br>";
	$lines=$row['M_League'].$w_mid.$w_mb_team."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team."<br>";
	$lines=$lines."<FONT color=#cc0000>$w_m_place</FONT>&nbsp;$bottom1@&nbsp;<FONT color=#cc0000><b>".$w_m_rate."</b></FONT>";	
	$lines_tw=$row['M_League_tw'].$w_mid.$w_mb_team_tw."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_tw."<br>";
	$lines_tw=$lines_tw."<FONT color=#cc0000>$w_m_place_tw</FONT>&nbsp;$bottom1_tw@&nbsp;<FONT color=#cc0000><b>".$w_m_rate."</b></FONT>";
	$lines_en=$row['M_League_en'].$w_mid.$w_mb_team_en."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_en."<br>";
	$lines_en=$lines_en."<FONT color=#cc0000>$w_m_place_en</FONT>&nbsp;$bottom1_en@&nbsp;<FONT color=#cc0000><b>".$w_m_rate."</b></FONT>";	

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

$sql = "INSERT INTO web_report_data	(ID,MID,Active,LineType,Mtype,M_Date,BetTime,BetScore,Middle,Middle_tw,Middle_en,BetType,BetType_tw,BetType_en,M_Place,M_Rate,M_Name,Gwin,TurnRate,OpenType,OddsType,ShowType,Agents,World,Corprator,Super,Admin,A_Rate,B_Rate,C_Rate,D_Rate,A_Point,B_Point,C_Point,D_Point,BetIP,Ptype,Gtype,CurType,Ratio,MB_MID,TG_MID,Pay_Type,Orderby,MB_Ball,TG_Ball) values ('$id','$gid','$active','$line','$mtype','$m_date','$bettime','$gold','$lines','$lines_tw','$lines_en','$bet_type','$bet_type_tw','$bet_type_en','$grape','$w_m_rate','$memname','$gwin','$m_turn','$open','$oddstype','$showtype','$agents','$world','$corprator','$super','$admin','$a_rate','$b_rate','$c_rate','$d_rate','$a_point','$b_point','$c_point','$d_point','$ip_addr','$ptype','OP','$w_current','$w_ratio','$w_mb_mid','$w_tg_mid','$pay_type','$order','$mb_ball','$tg_ball')";
mysql_query($sql) or die ("操作失败!");
$ouid=mysql_insert_id();
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
<meta content="MSHTML 6.00.2800.1515" name=GENERATOR>
<SCRIPT>window.setTimeout("self.location='../select.php?uid=<?=$uid?>'", 45000);</SCRIPT>
</head>
<body id="OFIN" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
  <div class="ord">
    <span><h1><?=$caption?></h1></span>
    <div id="info">
    <p><?=$Order_Login_Name?><?=$memname?></p>
  	<p><?=$Order_Credit_line?><?=$havemoney?></p>
  	<p><em><?=$Order_Bet_success?>&nbsp;<?=show_voucher($line,$ouid)?></em></p>
  	<p class="team"><?=$s_sleague?>&nbsp;<?=$btype?>&nbsp;<?=date('m-d',strtotime($row["M_Date"]))?><BR><?=$s_mb_team?>&nbsp;&nbsp;<font color=#cc0000><?=$Sign?></font>&nbsp;&nbsp;<?=$s_tg_team?><br><em><?=$s_m_place?></em>&nbsp;@&nbsp;<em><strong><?=$w_m_rate?></strong></em></p>
  	<p><?=$Order_Bet_Amount?><?=$gold?></p>
	<p><?=$Order_Estimated_Payout?><FONT id=pc color=#cc0000><?=$gwin?></FONT></p>
    </div>
    <p class="foot">
      <input type="button" name="FINISH" value="<?=$Order_Quit?>" onClick="self.location='../select.php?uid=<?=$uid?>'" class="no">
      <input type="button" name="PRINT" value="<?=$Order_Print?>" onClick="window.print()" class="yes">
    </p>
  </div>
</body>
</html>   
<?
mysql_close();
}
?>
