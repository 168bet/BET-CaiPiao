<?
require ("../include/config.inc.php");
require ('../include/http.class.php');
require ("../include/traditional.zh-tw.inc.php");

$gtype='BA';
$mysql = "select * from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$sid=$row['SunUid_tw'];
$site=$row['SunUrl'];
$settime=$row['udp_bs_score'];
$time=$row['udp_bs_results'];

$list_date=date('Y-m-d',time()-$time*60*60);
$base_url = "".$site."/app/member/result/result.php?langx=zh-tw&uid=$sid&game_type=$gtype";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
$filename= "".$site."/app/member/result/reload_result.php?langx=zh-tw&uid=$sid&game_type=$gtype&today_gmt=$list_date";
//echo $filename;
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
//$meg .= gzinflate(substr($msg,10));
$a = array(
"if(self == top)",
"<script>",
"</script>",
"\n\n"
);
$b = array(
"",
"",
"",
""
);
unset($matches);
unset($score);
$msg = str_replace($a,$b,$msg);
//echo $msg;
$m=0;
preg_match_all("/Array\(\'(.+?)\);/is",$msg,$matches);
$cou=sizeof($matches[0]);
for($i=0;$i<sizeof($matches[0]);$i++){
	$messages=$matches[0][$i];	
	$messages=str_replace("Array(","",$messages);
	$messages=str_replace(")","",$messages);
	$messages=str_replace("'","",$messages);
	$messages = iconv("BIG5","UTF-8//IGNORE",$messages);
	$score=explode(",",$messages);

			$mb_team=trim(strip_tags($score[5]));
			$tg_team=trim(strip_tags($score[6]));
            $mb_inball=trim(strip_tags($score[7]));
            $tg_inball=trim(strip_tags($score[8]));
            $mb_inball_hr=trim(strip_tags($score[9]));
            $tg_inball_hr=trim(strip_tags($score[10]));


			$sql="select MID,MB_Inball from match_base where MB_Team_tw='".$mb_team."' and M_Date='".$list_date."'";
			$result = mysql_query( $sql);
			$cou=mysql_num_rows($result);
			$row = mysql_fetch_array($result);
			if ($cou==0){
				$sql="select MID from match_base where MB_Team_tw='".$mb_team."' and M_Date='".$list_date."'";
				$result = mysql_query( $sql);
				$row = mysql_fetch_array($result);		
			}
			$mid=$row['MID'];
			if ($row['MB_Inball']==""){
			    $mysql="update match_base set MB_Inball='$mb_inball',TG_Inball='$tg_inball',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr' where M_Date='".$list_date."' and MID=".(int)$mid;
			}else if ($row['MB_Inball']<0){
			    $mysql="update match_base set MB_Inball='$mb_inball',TG_Inball='$tg_inball',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr',Cancel=1 where M_Date='".$list_date."' and MID=".(int)$mid;				
            }else{
				$m_sql="select MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_base where MID='".(int)$mid."' and M_Date='".$list_date."'";
				$m_result = mysql_query($m_sql);
				$m_row = mysql_fetch_array($m_result);
				$a=	$m_row['MB_Inball'].$m_row['TG_Inball'].$m_row['MB_Inball_HR'].$m_row['TG_Inball_HR'];
				$b=	trim($mb_inball).trim($tg_inball).trim($mb_inball_hr).trim($tg_inball_hr);
				if ($a!=$b){
				$check=1;
				$mysql="update match_base set MB_Inball='".(int)$mb_inball."',TG_Inball='".(int)$tg_inball."',MB_Inball_HR='".(int)$mb_inball_hr."',TG_Inball_HR='".(int)$tg_inball_hr."',Checked='".$check."'  where M_Date='".$list_date."' and MID=".(int)$mid;
				}else{
				$mysql="update match_base set MB_Inball='".(int)$mb_inball."',TG_Inball='".(int)$tg_inball."',MB_Inball_HR='".(int)$mb_inball_hr."',TG_Inball_HR='".(int)$tg_inball_hr."' where M_Date='".$list_date."' and MID=".(int)$mid;
				}
			}	
			mysql_query( $mysql) or die('abc');
			$m=$m+1;
}

echo '<br><br>目前比分以结算出'.$m;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>台棒接收比分</title>
<link href="/style/agents/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}
-->
</style>
</head>
<script> 
<!-- 
var limit="<?=$settime?>" 
if (document.images){ 
	var parselimit=limit
} 
function beginrefresh(){ 
if (!document.images) 
	return 
if (parselimit==1) 
	window.location.reload() 
else{ 
	parselimit-=1 
	curmin=Math.floor(parselimit) 
	if (curmin!=0) 
		curtime=curmin+"秒后自动本页获取最新数据！" 
	else 
		curtime=cursec+"秒后自动本页获取最新数据！" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 

window.onload=beginrefresh 
file://--> 
</script>
<body bgcolor="#AACCCC">
<table width="100" height="70" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="100" height="70" align="center"><br><?=$list_date?><br><br><span id="timeinfo"></span><br>
      <input type=button name=button value="更新" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
