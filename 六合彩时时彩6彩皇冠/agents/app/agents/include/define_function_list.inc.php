<?
function pdate(){
	$rq = array("2009-12-28","2010-01-25","2010-02-22","2010-03-22","2010-04-19","2010-05-17","2010-06-14","2010-07-12","2010-08-09","2010-09-06","2010-10-04","2010-11-01","2010-11-29","2010-12-26");
	$moon=date('n');
	if (date('Y-m-d')<$rq[$moon]){
	    $period[0]=date('Y_n');
		$period[1]=$rq[$moon-1];
		$lssue_0=explode("-",$rq[$moon]);
		$d_0=mktime(0,0,0,$lssue_0[1],$lssue_0[2],$lssue_0[0]);
		$period[2]=date('Y-m-d',$d_0-24*60*60);
		$period[3]=$rq[$moon-2];
		$lssue_1=explode("-",$rq[$moon-1]);
		$d_1=mktime(0,0,0,$lssue_1[1],$lssue_1[2],$lssue_1[0]);
		$period[4]=date('Y-m-d',$d_1-24*60*60);
	}else{
	    $period[0]=date('Y_n',time()+720*60*60);
		$period[1]=$rq[$moon];
		$lssue_0=explode("-",$rq[$moon+1]);
		$d_0=mktime(0,0,0,$lssue_0[1],$lssue_0[2],$lssue_0[0]);
		$period[2]=date('Y-m-d',$d_0-24*60*60);
		$period[3]=$rq[$moon-1];
		$lssue_1=explode("-",$rq[$moon]);
		$d_1=mktime(0,0,0,$lssue_1[1],$lssue_1[2],$lssue_1[0]);
		$period[4]=date('Y-m-d',$d_1-24*60*60);
	}
	return $period;
}
function wterror($msg){
	$test=$test."<html>";
	$test=$test."<head>";
	$test=$test."<title>error</title>";
	$test=$test."<meta http-equiv=Content-Type content=text/html; charset=utf-8>";
	$test=$test."<STYLE> A:visit { color=#6633cc; text-decoration: none ;}";
	$test=$test."tr {  font-family: Arial; font-size: 12px; color: #CC0000}";
	$test=$test.".b_13set {  font-size: 15px; font-family: Arial; color: #FFFFFF; padding-top: 2px; padding-left: 5px}";
	$test=$test.".b_tab {  border: 1px #000000 solid; background-color: #D2D2D2}";
	$test=$test.".b_back {  height: 20px; padding-top: 5px; color: #FFFFFF; cursor: hand; padding-left: 50px}";
	$test=$test."a:link {  color: #0000FF}";
	$test=$test."a:hover {  color: #CC0000}";
	$test=$test."a:visited {  color: #0000FF}";
	$test=$test."</STYLE>";
	$test=$test."</head>";
	$test=$test."<body text=#000000 leftmargin=0 topmargin=10 bgcolor=535E63 vlink=#0000FF alink=#0000FF>";
	$test=$test."<table width=600 border=0 cellspacing=0 cellpadding=0 align=center>";
	$test=$test."  <tr>";
	$test=$test."    <td width=36><img src=/images/agents/control/error_p11.gif width=36 height=63></td>";
	$test=$test."    <td background=/images/agents/control/error_p12b.gif>&nbsp;</td>";
	$test=$test."    <td width=160><img src=/images/agents/control/error_p13.gif width=160 height=63></td>";
	$test=$test."  </tr>";
	$test=$test."</table>";
	$test=$test."<table width=598 border=0 cellspacing=0 cellpadding=0 align=center class=b_tab>";
	$test=$test."  <tr bgcolor=#000000> ";
	$test=$test."    <td ><img src=/images/agents/control/error_dot.gif width=23 height=22></td>";
	$test=$test."    <td class=b_13set width=573>错&nbsp;误&nbsp;讯&nbsp;息</td>";
	$test=$test."  </tr>";
	$test=$test."  <tr> ";
	$test=$test."    <td colspan=2 align=center><br>";
	$test=$test."      $msg<BR><br>";
	$test=$test."      &nbsp; </td>";
	$test=$test."  </tr>";
	$test=$test."  <tr> ";
	$test=$test."    <td colspan=2>";
	$test=$test."      <table width=598 border=0 cellspacing=0 cellpadding=0 bgcolor=A0A0A0>";
	$test=$test."        <tr>";
	$test=$test."          <td>&nbsp;</td>";
	$test=$test."          <td background=/images/agents/control/error_p3.gif width=120><a href='javascript:history.go(-1)';><span class=b_back>回上一页</span></a></td>";
	$test=$test."        </tr>";
	$test=$test."      </table>";
	$test=$test."    </td>";
	$test=$test."  </tr>";
	$test=$test."</table>";
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
		$show_voucher='CS'.($id+$ouid);
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
function change_current($c_type){
	switch(trim($c_type)){
	case 'HKD':
		$change_current=$mem_radio_HKD;
		break;
	case 'USD':
		$change_current=$mem_radio_USD;
		break;
	case 'MYR':
		$change_current=$mem_radio_MYR;
		break;
	case 'SGD':
		$change_current=$mem_radio_SGD;
		break;
	case 'THB':
		$change_current=$mem_radio_THB;
		break;
	case 'GBP':
		$change_current=$mem_radio_GBP;
		break;
	case 'JPY':
		$change_current=$mem_radio_JPY;
		break;
	case 'EUR':
		$change_current=$mem_radio_EUR;
		break;
	case 'RMB':
		$change_current='$mem_current';
		break;
	case '':
		$change_current='$mem_current';
		break;
	}
	return $change_current;
}
?>