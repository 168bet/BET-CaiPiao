<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/BS_browse/index.php?rtype=hr&uid=$uid&langx=zh-tw&mtype=3");
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
for($page_no=0;$page_no<8;$page_no++)
{
$filename="".$site."/app/member/BS_browse/body_var.php?rtype=hr&uid=$uid&langx=zh-tw&mtype=3");

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
preg_match_all("/Array\((.+?)\);/is",$meg,$matches);
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++)
    {
	$messages=$matches[0][$i];
	$messages=str_replace(");",")",$messages);
	$messages=str_replace("cha(9)","",$messages);
	$datainfo=eval("return $messages;");
	
	$sql = "update match_sports set ShowTypeH='$datainfo[7]',M_LetB_HR='$datainfo[8]',MB_LetB_Rate_HR='$datainfo[9]',TG_LetB_Rate_HR='$datainfo[10]',MB_Dime_HR='$datainfo[11]',TG_Dime_HR='$datainfo[12]',MB_Dime_Rate_HR='$datainfo[14]',TG_Dime_Rate_HR='$datainfo[13]',MB_Win_HR='$datainfo[15]',TG_Win_HR='$datainfo[16]',M_Flat_HR='$datainfo[17]',HR_Show=1 where MID=$datainfo[0]-1";		
	mysql_query($sql) or die ("操作失敗!");
	//echo $sql;
}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
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
		curtime=curmin+"秒後自動獲取本頁最新數據!" 
	else 
		curtime=cursec+"秒後自動獲取本頁最新數據!" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 

window.onload=beginrefresh 
file://--> 
</script>
<table width="135" height="100" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="110" height="110" align="center">
       上半場數據正在接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁體" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
