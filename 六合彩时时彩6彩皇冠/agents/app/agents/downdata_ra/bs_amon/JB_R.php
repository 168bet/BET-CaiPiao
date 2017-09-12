<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/browse_JB/loadgame_R.php?langx=zh-cn&uid=$uid";
$html_data=$curl->fetch_url("".$site."/app/member/browse_JB/reloadgame_R.php?langx=zh-cn&uid=$uid&LegGame=ALL";
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
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
//echo $msg;
preg_match_all("/new Array\(\'(.+?)\);/is",$msg,$matches);
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
	$messages = iconv("GB2312","UTF-8",$messages);
	$datainfo=explode(",",$messages);
	$datainfo[4]=str_replace('H','主',$datainfo[4]);
	$datainfo[21]=str_replace('R','右',$datainfo[21]);
	$datainfo[21]=str_replace('L','左',$datainfo[21]);
	$datainfo[22]=str_replace('L','左',$datainfo[22]);
	$datainfo[22]=str_replace('R','右',$datainfo[22]);
	$sql = "update match_sports set MB_Team='$datainfo[4]',TG_Team='$datainfo[5]',MB_Team_Name='$datainfo[21]',TG_Team_Name='$datainfo[22]',M_League='$datainfo[2]' where MID=$datainfo[0]";
    mysql_query($sql) or die ("操作失败!");
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
		curtime=curmin+"秒后自动获取!" 
	else 
		curtime=cursec+"秒后自动获取!" 
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
      单式数据接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="简体" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
