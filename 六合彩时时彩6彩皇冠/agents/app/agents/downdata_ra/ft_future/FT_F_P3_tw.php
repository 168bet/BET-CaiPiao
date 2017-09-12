<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$mysql = "select datasite_tw,Uid_tw,udp_fu_pr from web_system_data where ID=1";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$uid =$row['Uid_tw'];
$site=$row['datasite_tw'];
$settime=$row['udp_fu_pr'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_future/index.php?rtype=p3&uid=$uid&langx=zh-tw&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/FT_future/body_var.php?rtype=p3&uid=$uid&langx=zh-tw&mtype=3");

$a = array(
"if(self == top)",
"<script>",
"\n\n"
);
$b = array(
"",
"",
""
);
unset($matches);
unset($datainfo);
$msg = str_replace($a,$b,$html_data);
preg_match_all("/new Array\((.+?)\);/is",$msg,$matches);
//echo $meg;
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
	$datainfo=explode(",",$messages);
	$MID=$datainfo[0];		
	$sql = "update match_sports set ShowTypeP='$datainfo[7]',M_P_LetB='$datainfo[8]',MB_P_LetB_Rate='$datainfo[9]',TG_P_LetB_Rate='$datainfo[10]',MB_P_Dime='$datainfo[11]',TG_P_Dime='$datainfo[12]',MB_P_Dime_Rate='$datainfo[13]',TG_P_Dime_Rate='$datainfo[14]',S_P_Single_Rate='$datainfo[15]',S_P_Double_Rate='$datainfo[16]',MB_P_Win_Rate='$datainfo[17]',TG_P_Win_Rate='$datainfo[18]',M_P_Flat_Rate='$datainfo[19]',ShowTypeHP='$datainfo[61]',M_P_LetB_H='$datainfo[62]',MB_P_LetB_Rate_H='$datainfo[63]',TG_P_LetB_Rate_H='$datainfo[64]',MB_P_Dime_H='$datainfo[65]',TG_P_Dime_H='$datainfo[66]',MB_P_Dime_Rate_H='$datainfo[68]',TG_P_Dime_Rate_H='$datainfo[67]',MB_P_Win_Rate_H='$datainfo[96]',TG_P_Win_Rate_H='$datainfo[97]',M_P_Flat_Rate_H='$datainfo[98]',P3_Show=1 where MID=$datainfo[0]";
	mysql_query($sql) or die ("操作失敗!");		
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
      讓過關數據接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁體 <?=$cou?>" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
