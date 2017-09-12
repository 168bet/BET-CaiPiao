<?
require"../../../../include/conn_ft8.php";
require"../../../../include/function.php";
require ("../../../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/browse_BS/loadgame_R.php?langx=zh-cn&uid=$uid";
$html_data=$curl->fetch_url("".$site."/app/member/browse_BS/reloadgame_R.php?langx=zh-cn&uid=$uid&LegGame=ALL&page_no=$page_no";

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
preg_match_all("/new Array\(\'(.+?)\);/is",$msg,$matches);
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace(")","",$messages);
	$messages=str_replace("'","",$messages);
	//转码
	$messages = iconv("gb2312","utf-8",$messages);
	$datainfo=explode(",",$messages);
	$sql = "update base_match set MB_Team='$datainfo[4]--$datainfo[21]',TG_Team='$datainfo[5]--$datainfo[22]',M_League='$datainfo[2]' where MID=$datainfo[0]";
	echo $sql;
	mysql_query($sql) or die ("操作失敗!");
}
}
$abcd=explode("parent.msg='",$meg);
$msg_tw=explode("';",$abcd[1]);

$sql = "select msg_update from web_system";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if ($row['msg_update']==1 and $msg_tw[0]!=''){
	$sql="update web_system set msg_member_tw='$msg_tw[0]'";
	mysql_query($sql) or die ("鼠豢載陔紱釬囮!");		
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
<table width="102" height="100" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="110" height="110" align="center">
      單式數據正在接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁体" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
