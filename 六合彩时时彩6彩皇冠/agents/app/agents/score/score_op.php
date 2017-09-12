<?php
require ("../include/config.inc.php");
require ('../include/curl_http.php');
require ("../include/traditional.zh-tw.inc.php");

$mysql = "select * from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$sid=$row['Uid_tw'];
$site=$row['datasite_tw'];
$settime=$row['udp_op_score'];
$time=$row['udp_op_results'];
$list_date=date('Y-m-d',time()-$time*60*60);

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/OP_index.php?uid=$sid&langx=zh-tw&mtype=3");
$html_date=$curl->fetch_url("".$site."/app/member/result/result.php?game_type=OP&list_date=$list_date&uid=$sid&langx=zh-tw");

$a = array(
"<script>",
"</script>",
'"',
"\n\n",
"<br>",
" ",
'</b></font>',
"<td>",
"<tdalign=left>",
"<fontcolor=#cc0000>",
"<fontcolor=red>",
"<b>",
"</b>",
"</a>",
"</font>"
);
$b = array(
"",
"",
"",
"",
"-",
"",
'',
"",
"",
"",
"",
"",
"",
""
);

$msg = str_replace($a,$b,$html_date);
//$msg = iconv("BIG5","UTF-8",$msg);
//echo $msg;
$data1=explode("</div>",$msg);
$m=0;
$data=explode("<trclass=b_cen>",strtolower($msg));
for ($i=1;$i<sizeof($data);$i++){
	$abcde=explode("</tr>",$data[$i]);
	for ($j=0;$j<sizeof($abcde)-1;$j++){		
		$score=explode("</td>",$abcde[$j]);
		if (sizeof($score)==6){
			//echo $abcde[$j]."<br>";
			$mid=explode("-",$score[1]);
			$tscore=explode("-",$score[3]);
			$mscore=explode("-",$score[4]);
			
			$mb_mid=$mid[0];
			$tg_mid=$mid[1];
		
            $mb_inball=trim(strip_tags($mscore[0]));
            $tg_inball=trim(strip_tags($mscore[1]));
            $mb_inball_hr=trim(strip_tags($tscore[0]));
            $tg_inball_hr=trim(strip_tags($tscore[1]));
			
			if ($tg_inball==$Score1){
				$mb_inball='-1';
				$tg_inball='-1';
			}
			if ($tg_inball_hr==$Score1){
				$mb_inball_hr='-1';
				$tg_inball_hr='-1';		
			}
			if ($tg_inball==$Score2){
				$mb_inball='-2';
				$tg_inball='-2';
			}
			if ($tg_inball_hr==$Score2){
				$mb_inball_hr='-2';
				$tg_inball_hr='-2';	
			}
			if ($tg_inball==$Score3){
				$mb_inball='-3';
				$tg_inball='-3';
			}
			if ($tg_inball_hr==$Score3){
				$mb_inball_hr='-3';
				$tg_inball_hr='-3';
			}
			if ($tg_inball==$Score4){
				$mb_inball='-4';
				$tg_inball='-4';					
			}
			if ($tg_inball_hr==$Score4){
				$mb_inball_hr='-4';
				$tg_inball_hr='-4';
			}
			if ($tg_inball==$Score5){
				$mb_inball='-5';
				$tg_inball='-5';
			}
			if ($tg_inball_hr==$Score5){
				$mb_inball_hr='-5';
				$tg_inball_hr='-5';							
			}
			if ($tg_inball==$Score6){
				$mb_inball='-6';
				$tg_inball='-6';
			}
			if ($tg_inball_hr==$Score6){
				$mb_inball_hr='-6';
				$tg_inball_hr='-6';				
			}
			if ($tg_inball=='賽事痞pk/加時'){
				$mb_inball='-7';
				$tg_inball='-7';				
			}
			if ($tg_inball_hr=='賽事痞pk/加時'){
				$mb_inball_hr='-7';
				$tg_inball_hr='-7';
			}
			if ($tg_inball==$Score8){
				$mb_inball='-8';
				$tg_inball='-8';
			}
			if ($tg_inball_hr==$Score8){
				$mb_inball_hr='-8';
				$tg_inball_hr='-8';
			}
			if ($tg_inball=='隊安錯誤'){
				$mb_inball='-9';
				$tg_inball='-9';	
			}
			if ($tg_inball_hr=='隊安錯誤'){
				$mb_inball_hr='-9';
				$tg_inball_hr='-9';			
			}
			if ($tg_inball==$Score10){
				$mb_inball='-10';
				$tg_inball='-10';
			}
			if ($tg_inball_hr==$Score10){
				$mb_inball_hr='-10';
				$tg_inball_hr='-10';							
			}
			if ($tg_inball==$Score11){
				$mb_inball='-11';
				$tg_inball='-11';
			}
			if ($tg_inball_hr==$Score11){
				$mb_inball_hr='-11';
				$tg_inball_hr='-11';				
			}
			if ($tg_inball==$Score12){
				$mb_inball='-12';
				$tg_inball='-12';				
			}
			if ($tg_inball_hr==$Score12){
				$mb_inball_hr='-12';
				$tg_inball_hr='-12';
			}
			if ($tg_inball==$Score13){
				$mb_inball='-13';
				$tg_inball='-13';
			}
			if ($tg_inball_hr==$Score13){
				$mb_inball_hr='-13';
				$tg_inball_hr='-13';
			}
			if ($tg_inball==$Score14){
				$mb_inball='-14';
				$tg_inball='-14';					
			}
			if ($tg_inball_hr==$Score14){
				$mb_inball_hr='-14';
				$tg_inball_hr='-14';
			}
			if ($tg_inball==$Score15){
				$mb_inball='-15';
				$tg_inball='-15';
			}
			if ($tg_inball_hr==$Score15){
				$mb_inball_hr='-15';
				$tg_inball_hr='-15';								
			}
			if ($tg_inball==$Score16){
				$mb_inball='-16';
				$tg_inball='-16';
			}
			if ($tg_inball_hr==$Score16){
				$mb_inball_hr='-16';
				$tg_inball_hr='-16';				
			}
			if ($tg_inball==$Score17){
				$mb_inball='-17';
				$tg_inball='-17';				
			}
			if ($tg_inball_hr==$Score17){
				$mb_inball_hr='-17';
				$tg_inball_hr='-17';
			}
			if ($tg_inball==$Score18){
				$mb_inball='-18';
				$tg_inball='-18';
			}
			if ($tg_inball_hr==$Score18){
				$mb_inball_hr='-18';
				$tg_inball_hr='-18';
			}
			if ($tg_inball==$Score19){
				$mb_inball='-19';
				$tg_inball='-19';	
			}
			if ($tg_inball_hr==$Score19){
				$mb_inball_hr='-19';
				$tg_inball_hr='-19';	
			}
						
			$sql="select MID,MB_Inball from match_sports where Type='OP' and MB_MID=".(int)$mb_mid." and M_Date='".$list_date."'";
			$result = mysql_query( $sql);
			$cou=mysql_num_rows($result);
			$row = mysql_fetch_array($result);
			if ($cou==0){
				$sql="select MID from match_sports where Type='OP' and TG_MID=".(int)$mb_mid." and M_Date='".$list_date."'";
				$result = mysql_query( $sql);
				$row = mysql_fetch_array($result);		
			}
			$mid=$row['MID'];
			if ($row['MB_Inball']==""){
			    $mysql="update match_sports set MB_Inball='$mb_inball',TG_Inball='$tg_inball',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr' where Type='OP' and M_Date='".$list_date."' and MID=".(int)$mid;
			}else if ($row['MB_Inball']<0){
			    $mysql="update match_sports set MB_Inball='$mb_inball',TG_Inball='$tg_inball',MB_Inball_HR='$mb_inball_hr',TG_Inball_HR='$tg_inball_hr',Cancel=1 where Type='OP' and M_Date='".$list_date."' and MID=".(int)$mid;				
            }else{
				$m_sql="select MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where Type='OP' and MID='".(int)$mid."' and M_Date='".$list_date."'";
				$m_result = mysql_query($m_sql);
				$m_row = mysql_fetch_array($m_result);
				$a=	$m_row['MB_Inball'].$m_row['TG_Inball'].$m_row['MB_Inball_HR'].$m_row['TG_Inball_HR'];
				$b=	trim($mb_inball).trim($tg_inball).trim($mb_inball_hr).trim($tg_inball_hr);
				if ($a!=$b){
				$check=1;
				$mysql="update match_sports set MB_Inball='".(int)$mb_inball."',TG_Inball='".(int)$tg_inball."',MB_Inball_HR='".(int)$mb_inball_hr."',TG_Inball_HR='".(int)$tg_inball_hr."',Checked='".$check."' where Type='OP' and M_Date='".$list_date."' and MID=".(int)$mid;
				}else{
				$mysql="update match_sports set MB_Inball='".(int)$mb_inball."',TG_Inball='".(int)$tg_inball."',MB_Inball_HR='".(int)$mb_inball_hr."',TG_Inball_HR='".(int)$tg_inball_hr."' where Type='OP' and M_Date='".$list_date."' and MID=".(int)$mid;
				}
			}	
			mysql_query( $mysql) or die('abc');
			$m=$m+1;
		}		
	}
}

echo '<br>目前比分以结算出'.$m;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>其他接比分</title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
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
<body>
<table width="100" height="70" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="100" height="70" align="center"><br><?=$list_date?><br><br><span id="timeinfo"></span><br>
      <input type=button name=button value="其他更新" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
