<?
function attention($msg,$uid,$langx){
	$key=rand(1,199);
	if ($langx=='zh-cn'){
		$confirm='确定';
	}else if ($langx=='zh-tw'){
		$confirm='確定';
	}else if ($langx=='en-us' or $langx=='th-tis'){
		$confirm=' OK ';
	}
	$test=$test."<html>";
	$test=$test."<head>";
	$test=$test."<title>Attention</title>";
	$test=$test."<meta http-equiv=Content-Type content=text/html; charset=utf-8>";
	$test=$test."<link rel=stylesheet href=/style/member/mem_order.css type=text/css>";
	$test=$test."</head>";

	$test=$test."<body id=BLUE>";
	$test=$test."<div>";
	$test=$test."<p>$msg$key</p>";
	$test=$test."<p><input type=button name='check' value='$confirm' onClick=javascript:location='/app/member/select.php?uid=$uid' height='20' class='yes'></p>";
	$test=$test."</div>";

	$test=$test."</body>";
	$test=$test."</html>";
	return $test;
}
function wterror($msg){
	$test=$test."<html>";
	$test=$test."<head>";
	$test=$test."<title>error</title>";
	$test=$test."<meta http-equiv=Content-Type content=text/html; charset=utf-8>";
	$test=$test."<STYLE>";
	$test=$test."<!--";
	$test=$test."body { text-align:center; background-color:#535E63;}";
	$test=$test."div { width:230px; font:12px Arial, Helvetica, sans-serif; border:1px solid #333; margin:auto;}";
	$test=$test."p { color:#C00; background-color:#CCC; margin:0; padding:15px 6px;}";
	$test=$test."h1 { font-size:1.2em; margin:0; padding:4px; background-color:#000; color:#FFF;letter-spacing: 0.5em;}";
	$test=$test."span { display:block; background-color:#A0A0A0; padding:4px; margin:0;}";
	$test=$test."a:link, a:visited {  color: #FFF; text-decoration: none;}";
	$test=$test."a:hover {  color: #FF0}";
	$test=$test."-->";
	$test=$test."</STYLE>";
	$test=$test."</head>";
	$test=$test."<body text=#000000 leftmargin=0 topmargin=10 bgcolor=535E63 vlink=#0000FF alink=#0000FF>";
	$test=$test."<div>";
	$test=$test."<h1>错误讯息</h1>";
	$test=$test."<p>$msg</p>";
	$test=$test."<span><a href=javascript:history.go(-1)>&raquo; 回上一页</a></span>";
	$test=$test."</div>";
	$test=$test."</body>";
	$test=$test."</html>";
//	exit();
	return $test;
}
function show_voucher($line,$id){
require ("config.inc.php");
$sql="select OUID,DTID,PMID from web_system_data";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$ouid=$row['OUID'];
$dtid=$row['DTID'];
$pmid=$row['PMID'];
switch($line){
	case 1:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 2:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 3:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 4:
		$show_voucher='DT'.($id+$dtid);
		break;	
	case 5:
		$show_voucher='DT'.($id+$dtid);
		break;
	case 6:
		$show_voucher='DT'.($id+$dtid);
		break;
	case 7:
		$show_voucher='DT'.($id+$dtid);
		break;
	case 8:
		$show_voucher='PM'.($id+$pmid);
		break;				
	case 9:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 10:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 11:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 12:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 13:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 14:
		$show_voucher='DT'.($id+$dtid);
		break;
	case 15:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 16:
		$show_voucher='DT'.($id+$dtid);
		break;
	case 19:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 20:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 21:
		$show_voucher='OU'.($id+$ouid);
		break;
	case 31:
		$show_voucher='OU'.($id+$ouid);
		break;
	}
	return $show_voucher;
}
/*
 * 選擇多盤口時 轉換成該選擇賠率
 * @param odd_type 	選擇盤口
 * @param iorH		主賠率
 * @param iorC		客賠率
 * @param show		顯示位數
 * @return		回傳陣列 0-->H  ,1-->C
 */
function  get_other_ioratio($odd_type,$iorH,$iorC,$showior){
	$out=Array();
	if($iorH!="" ||$iorC!=""){
		$out =chg_ior($odd_type,$iorH,$iorC,$showior);
	}else{
		$out[0]=$iorH;
		$out[1]=$iorC;
	}
	return $out;
}
/**
 * 轉換賠率
 * @param odd_f
 * @param H_ratio
 * @param C_ratio
 * @param showior
 * @return
 */
function chg_ior($odd_f,$iorH,$iorC,$showior){
	$ior=Array();
	if($iorH < 3) $iorH *=1000;
	if($iorC < 3) $iorC *=1000;
	$iorH=$iorH;
	$iorC=$iorC;
	switch($odd_f){
	case "H":	//香港變盤(輸水盤)
		$ior = get_HK_ior($iorH,$iorC);
		break;
	case "M":	//馬來盤
		$ior = get_MA_ior($iorH,$iorC);
		break;
	case "I" :	//印尼盤
		$ior = get_IND_ior($iorH,$iorC);
		break;
	case "E":	//歐洲盤
		$ior = get_EU_ior($iorH,$iorC);
		break;
	default:	//香港盤
		$ior[0]=$iorH ;
		$ior[1]=$iorC ;
	}
	$ior[0]/=1000;
	$ior[1]/=1000;
	$ior[0]=Decimal_point($ior[0],$showior);
	$ior[1]=Decimal_point($ior[1],$showior);
	//$ior[0]=number(Decimal_point($ior[0],$showior),3);
	//$ior[1]=number(Decimal_point($ior[1],$showior),3);
	return $ior;
}
/**
 * 換算成輸水盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_HK_ior($H_ratio,$C_ratio){
	$out_ior=Array();
	$line="";
	$lowRatio="";
	$nowRatio="";
	$highRatio="";
    $nowType="";
	if ($H_ratio <= 1000 && $C_ratio <= 1000){
		$out_ior[0]=$H_ratio;
		$out_ior[1]=$C_ratio;
		return $out_ior;
	}
	$line=2000 - ( $H_ratio + $C_ratio );
	if ($H_ratio > $C_ratio){ 
		$lowRatio=$C_ratio;
		$nowType = "C";
	}else{
		$lowRatio = $H_ratio;
		$nowType = "H";
	}
	if (((2000 - $line) - $lowRatio) > 1000){
		//對盤馬來盤
		$nowRatio = ($lowRatio + $line) * (-1);
	}else{
		//對盤香港盤
		$nowRatio=(2000 - $line) - $lowRatio;	
	}
	if ($nowRatio < 0){
		$highRatio = (abs(1000 / $nowRatio) * 1000) ;
	}else{
		$highRatio = (2000 - $line - $nowRatio) ;
	}
	if ($nowType == "H"){
		$out_ior[0]=$lowRatio;
		$out_ior[1]=$highRatio;
	}else{
		$out_ior[0]=$highRatio;
		$out_ior[1]=$lowRatio;
	}
	return $out_ior;
}
/**
 * 換算成馬來盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_MA_ior( $H_ratio, $C_ratio){
	$out_ior=Array();
	$line="";
	$lowRatio="";
	$highRatio="";
    $nowType="";
	if (($H_ratio <= 1000 && $C_ratio <= 1000)){
		$out_ior[0]=$H_ratio;
		$out_ior[1]=$C_ratio;
		return $out_ior;
	}
	$line=2000 - ( $H_ratio + $C_ratio );
	if ($H_ratio > $C_ratio){ 
		$lowRatio = $C_ratio;
		$nowType = "C";
	}else{
		$lowRatio = $H_ratio;
		$nowType = "H";
	}
	$highRatio = ($lowRatio + $line) * (-1);
	if ($nowType == "H"){
		$out_ior[0]=$lowRatio;
		$out_ior[1]=$highRatio;
	}else{
		$out_ior[0]=$highRatio;
		$out_ior[1]=$lowRatio;
	}
	return $out_ior;
}
/**
 * 換算成印尼盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_IND_ior( $H_ratio, $C_ratio){
	$out_ior=Array();
	$out_ior = get_HK_ior($H_ratio,$C_ratio);
	$H_ratio=$out_ior[0];
	$C_ratio=$out_ior[1];
	$H_ratio /= 1000;
	$C_ratio /= 1000;
	if($H_ratio < 1){
		$H_ratio=(-1) / $H_ratio;
	}
	if($C_ratio < 1){
		$C_ratio=(-1) / $C_ratio;
	}
	$out_ior[0]=$H_ratio*1000;
	$out_ior[1]=$C_ratio*1000;
	return $out_ior;
}
/**
 * 換算成歐洲盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_EU_ior($H_ratio, $C_ratio){
	$out_ior=Array();
	$out_ior = get_HK_ior($H_ratio,$C_ratio);
	$H_ratio=$out_ior[0];
	$C_ratio=$out_ior[1];       
	$out_ior[0]=$H_ratio+1000;
	$out_ior[1]=$C_ratio+1000;
	return $out_ior;
}
/*
去正負號做小數第幾位捨去
進來的值是小數值
*/
function Decimal_point($tmpior,$show){
	$sign="";
	$sign =(($tmpior < 0)?"Y":"N");
	$tmpior = (floor(abs($tmpior) * $show + 1 / $show )) / $show;
	return ($tmpior * (($sign =="Y")? -1:1));
}
/*
 公用 FUNC
*/
function number($vals,$points){ //小數點位數
	$cmd=Array();
	$cmd=split(".",$vals);
	$length=strlen($cmd[1]);
	if (count($cmd)>1){
		for ($ii=0;$ii<($points-$length);$ii++) $vals=$vals."0";
	}else{
		$vals=$vals+".";
		for ($ii=0;$ii<$points;$ii++) $vals=$vals."0";
	}
	return $vals;
}
function change_rate($c_type,$c_rate){
	switch($c_type){
	case 'A':
		$t_rate='0.03';
		break;
	case 'B':
		$t_rate='0.01';
		break;
	case 'C':
		$t_rate='0';
		break;
	case 'D':
		$t_rate='-0.01';
		break;
	}
	if ($c_rate!='' and $c_rate!='0'){
	    $change_rate=number_format($c_rate-$t_rate,3);
	    if ($change_rate<=0 and $change_rate>=-0.03){
		    $change_rate='';
	    }
	}else{
	    $change_rate='';
	}
	return $change_rate;
}
function num_rate($c_type,$c_rate){
	switch($c_type){
	case 'A':
		$t_rate='0';
		break;
	case 'B':
		$t_rate='0';
		break;
	case 'C':
		$t_rate='0';
		break;
	case 'D':
		$t_rate='0';
		break;
	}
	if ($c_rate!=''){
	$num_rate=number_format($c_rate-$t_rate,2);
	if ($num_rate<=0){
		$num_rate='';
	}
	}else{
	$num_rate='';
	}
	return $num_rate;
}
function filiter_team($repteam){
	//$repteam=trim(str_replace(" ","",$repteam));
	$repteam=trim(str_replace("[H]","",$repteam));
	$repteam=trim(str_replace("[主]","",$repteam));
	$repteam=trim(str_replace("[中]","",$repteam));
	$repteam=trim(str_replace("[主]","",$repteam));
	$repteam=trim(str_replace("[中]","",$repteam));
	$repteam=trim(str_replace("[Home]","",$repteam));
	$repteam=trim(str_replace("[Mid]","",$repteam));
	$repteam=trim(str_replace("<font color=#990000> - [上半场]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=#990000> - [下半场]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=#990000> - [上半場]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=#990000> - [下半場]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=#990000> - [1st]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=#990000> - [2nd]</font>","",$repteam));
	
	$repteam=trim(str_replace("<font color=gray> - [上半]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [下半]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [第1节]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [第2节]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [第3节]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [第4节]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [上半]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [下半]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [第1節]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [第2節]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [第3節]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [第4節]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [1st Half]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [2nd Half]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray> - [Q1]</font>","",$repteam));	
	$repteam=trim(str_replace("<font color=gray> - [Q2]</font>","",$repteam));	
	$repteam=trim(str_replace("<font color=gray> - [Q3]</font>","",$repteam));	
	$repteam=trim(str_replace("<font color=gray> - [Q4]</font>","",$repteam));	

	$filiter_team=$repteam;
	return $filiter_team;
}
function fileter0($rate){
	for($i=1;$i<strlen($rate);$i++){
		if (substr($rate, -$i, 1)<>'0'){
			if (substr($rate, -$i, 1)=='.'){
				$fileter0=substr($rate,0,strlen($rate)-$i);
			}else{
				$fileter0=substr($rate,0,strlen($rate)-$i+1);
			}
			break;
		}
	}
	return $fileter0;
}

function singleset($ptype){
	require ("config.inc.php");
	$sql="select $ptype as P3,R,MAX from web_system_data where ID=1";
	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$p=$row['P3'];
	$pmax=$row['MAX'];
	//mysql_close();
	return array($p,$pmax);
}
?>
