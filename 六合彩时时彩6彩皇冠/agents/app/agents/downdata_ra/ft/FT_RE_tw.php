<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$mysql = "select datasite_tw as datasite,Uid_tw,udp_ft_tw from web_system_data where ID=1";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$uid =$row['Uid_tw'];
$site=$row['datasite'];
$settime=$row['udp_ft_tw'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_browse/index.php?rtype=re&uid=$uid&langx=zh-tw&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/FT_browse/body_var.php?rtype=re&uid=$uid&langx=zh-tw&mtype=3");

preg_match_all("/new Array\((.+?)\);/is",$html_data,$matches);
//echo $html_data;
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
	$datainfo=explode(",",$messages);
	
	$date=explode('<br>',$datainfo[42]);
	$m_date=date('Y')."-".$date[0];
	$m_time=$date[1];
	$hhmmstr=explode(":",$m_time);
	$hh=$hhmmstr[0];
	$ap=substr($m_time,strlen($m_time)-1,1); 
	if ($ap=='p' and $hh<>12){
		$hh+=12;
	}
	$timestamp = $m_date." ".$hh.":".substr($hhmmstr[1],0,strlen($hhmmstr[1])-1).":00";
	
	$checksql = "select MID from match_sports where `MID` ='$datainfo[0]'";
	$checkresult = mysql_query($checksql);	
	$check=mysql_num_rows($checkresult);
	if($check==0){
		$sql = "INSERT INTO match_sports(MID,Type,M_Date,M_Time,M_Start,MB_Team_tw,TG_Team_tw,M_League_tw,MB_MID,TG_MID,ShowTypeRB,RB_Show) VALUES ('$datainfo[0]','FT','$m_date','$m_time','$timestamp','$datainfo[5]','$datainfo[6]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[7]','1')";
		mysql_query($sql) or die ("操作失敗!");
	}else{
		$sql = "update match_sports set Type='FT',M_Date='$m_date',M_Time='$m_time',M_Start='$timestamp',MB_Team_tw='$datainfo[5]',TG_Team_tw='$datainfo[6]',M_League_tw='$datainfo[2]',ShowTypeRB='$datainfo[7]',M_LetB_RB='$datainfo[8]',MB_LetB_Rate_RB='$datainfo[9]',TG_LetB_Rate_RB='$datainfo[10]',MB_Dime_RB='$datainfo[11]',TG_Dime_RB='$datainfo[12]',MB_Dime_Rate_RB='$datainfo[14]',TG_Dime_Rate_RB='$datainfo[13]',ShowTypeHRB='$datainfo[21]',M_LetB_RB_H='$datainfo[22]',MB_LetB_Rate_RB_H='$datainfo[23]',TG_LetB_Rate_RB_H='$datainfo[24]',MB_Dime_RB_H='$datainfo[25]',TG_Dime_RB_H='$datainfo[26]',MB_Dime_Rate_RB_H='$datainfo[28]',TG_Dime_Rate_RB_H='$datainfo[27]',RB_Show=1 where MID='$datainfo[0]'";
		mysql_query($sql) or die ("操作失敗1!");
	}
}	
mysql_close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
<body>
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
		curtime=curmin+"秒後自動獲取!" 
	else 
		curtime=cursec+"秒後自動獲取!" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 

window.onload=beginrefresh 
file://--> 
</script>
<table width="100" height="70" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="100" height="70" align="center">
      走地數據接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁体 <?=$cou?>" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
