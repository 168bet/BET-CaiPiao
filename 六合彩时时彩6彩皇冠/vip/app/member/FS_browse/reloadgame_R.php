<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/curl_http.php");
include "../include/login_session.php";
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
require ("../include/traditional.$langx.inc.php");
if ($rtype=='fs'){
	$type="and Gtype!='FI'";
}else if ($rtype=='fi'){
	$type="and Gtype='FI'";
}
$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$open=$row['OpenType'];
$memname=$row['UserName'];
$credit=$row['Money'];

$m_date=date('Y-m-d');
$time=date('H:i:s');
$K=0;
?>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<script>
<?
/*$mysql="select MID,M_Start,$mb_team as MB_Team,$m_league as M_League,$m_item as M_Item,Ytype,Num,Ntype,Ftype,M_Rate,Gtype from match_crown where `M_Start` > now( ) $type order by M_Start asc ";
echo $mysql; 
$result = mysql_query( $mysql);
$cou_num=mysql_num_rows($result);*/

	$mysql = "select datasite,uid,uid_tw,uid_en from web_system_data where ID=1";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$site=$row['datasite'];
	switch($langx)	{
	case "zh-tw":
		$suid=$row['uid_tw'];
		break;
	case "zh-cn":
		$suid=$row['uid'];
		break;
	case "en-us":
		$suid=$row['uid_en'];
		break;
	case "th-tis":
		$suid=$row['uid_en'];
		break;
	}
	
	
$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/browse_FS/loadgame_R.php?rtype=fs&uid=$suid&langx=$langx&mtype=3");
$allcount=0;
$html_data=$curl->fetch_url("".$site."/app/member/browse_FS/reloadgame_R.php?uid=$suid&langx=$langx&rtype=fs");
$a = array(
"if(self == top)",
"<script>",
"</script>",
"new Array()",
"new Array();",
"\n\n"
);

$b = array(
"",
"",
"",
"",
"",
""
);
	$msg = str_replace($a,$b,$html_data);
	preg_match_all("/new Array\((.+?)\);/is",$msg,$matches);
	$cou_num=sizeof($matches[0]);
	preg_match_all("/parent.areasarray=(.+?);/is",$html_data,$areasarray);
	preg_match_all("/parent.itemsarray=(.+?);/is",$html_data,$itemsarray);
?>
parent.sessions='2';
parent.nowtime='<?=$time?>';
parent.records=40;
parent.gamount=<?=$cou_num?>;
parent.areasarray=<?=$areasarray[1][0] ?>;
parent.itemsarray=<?=$itemsarray[1][0] ?>;
parent.msg='<?=$mem_msg?>';
var ordersR=new Array();
var gidx=new Array();
var GameFT=new Array();
<?php 
/*while($row = mysql_fetch_array($result)){
	$mid = $row['MID'];
	$time = $row['M_Start'];
	$league = $row['M_League'];
	$item = $row['M_Item'];
    $ytype = $row['Ytype'];
	$num = $row['Num'];
    $num = $num + 0;
	$ntype = $row['Ntype'];
	$ftype = $row['Ftype'];
    $team = $row['MB_Team'];
	$rate = $row['M_Rate'];
	$gtype = $row['Gtype'];
	$ntype_array = explode(",",$ntype);
	$ftype_array = explode(",",$ftype);
    $team_array = explode(",",$team);
    $rate_array = explode(",",$rate);
    $str = "'$mid','$time','$league','$item','$ytype','$num'";
    for ($t = 0; $t < $num; ++$t){	
         $str .= ",'$ntype_array[$t]','$ftype_array[$t]','$team_array[$t]','$rate_array[$t]'";
    }
    $str .= ",'$gtype'";
    echo "GameFT[$K] = new Array(".$str.");"."\n";
    echo "gidx[$mid]=$K;"."\n";
	$K=$K+1;
	$str2.=",".$row['ID']."*".$lx ;
}*/
for($i=0;$i<$cou_num;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace("new Array(","",$messages);
	    $messages=str_replace(");","",$messages);
		echo "GameFT[$i] = new Array(".$messages.");"."\n";
		$datainfo=explode(",",$messages);
        echo "gidx[".$datainfo[0]."]=$i;"."\n";	
}
?>
parent.GameFT=GameFT;
parent.gidx=gidx;
parent.ordersR=ordersR;
parent.showgame_table();
parent.ShowArea('');
parent.ShowItem('');
parent.retime='180';
</script>
