<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_future/index.php?rtype=hpd&uid=$uid&langx=zh-tw&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/FT_future/body_var.php?rtype=hpd&uid=$uid&langx=zh-tw&mtype=3");

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
unset($datainfo);
$msg = str_replace($a,$b,$html_data);
preg_match_all("/new Array\((.+?)\);/is",$msg,$matches);
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++)
{
	$messages=$matches[0][$i];
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
	$datainfo=explode(",",$messages);
	$sql = "update match_sports set MB1TG0V='$datainfo[8]',MB2TG0V='$datainfo[9]',MB2TG1V='$datainfo[10]',MB3TG0V='$datainfo[11]',MB3TG1V='$datainfo[12]',MB3TG2V='$datainfo[13]',MB4TG0V='$datainfo[14]',MB4TG1V='$datainfo[15]',MB4TG2V='$datainfo[16]',MB4TG3V='$datainfo[17]',MB0TG0V='$datainfo[18]',MB1TG1V='$datainfo[19]',MB2TG2V='$datainfo[20]',MB3TG3V='$datainfo[21]',MB4TG4V='$datainfo[22]',UP5V='$datainfo[23]',MB0TG1V='$datainfo[24]',MB0TG2V='$datainfo[25]',MB1TG2V='$datainfo[26]',MB0TG3V='$datainfo[27]',MB1TG3V='$datainfo[28]',MB2TG3V='$datainfo[29]',MB0TG4V='$datainfo[30]',MB1TG4V='$datainfo[31]',MB2TG4V='$datainfo[32]',MB3TG4V='$datainfo[33]',OVTGV='$datainfo[34]', F_VPD_Show=1 where MID=$datainfo[0]-1";
	mysql_query($sql) or die ("操作失敗1!");
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
      上半波膽數據接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="刷新" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
