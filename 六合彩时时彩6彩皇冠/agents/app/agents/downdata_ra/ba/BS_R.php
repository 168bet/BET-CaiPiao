<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/BS_browse/index.php?rtype=r&uid=$uid&langx=zh-cn&mtype=3");
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
for($page_no=0;$page_no<8;$page_no++)
{
$filename="".$site."/app/member/BS_browse/body_var.php?rtype=r&uid=$uid&langx=zh-cn&mtype=3");

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
preg_match_all("/Array\((.+?)\);/is",$meg,$matches);
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	$messages=str_replace(");",")",$messages);
	$messages=str_replace("cha(9)","",$messages);
	$datainfo=eval("return $messages;");
	$sql = "update match_sports set MB_Team='$datainfo[5]',TG_Team='$datainfo[6]',M_League='$datainfo[2]' where MID=$datainfo[0]";
mysql_query($sql) or die ("操作失败1!");
}
}
$abcd=explode("parent.msg='",$meg);
$msg_tw=explode("';",$abcd[1]);

$sql = "select msg_update from web_system_data";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if ($row['msg_update']==1 and $msg_tw[0]!=''){
	$sql="update web_system_data set msg_member='$msg_tw[0]'";
	mysql_query($sql) or die ("公告更新操作失敗!");		
}
mysql_close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
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
		curtime=curmin+"秒后自动获取本页最新数据！" 
	else 
		curtime=cursec+"秒后自动获取本页最新数据！" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 

window.onload=beginrefresh 
file://--> 
</script>
<table width="102" height="100" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="108" height="100" align="center"><br>
      单式数据正在接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="简体" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
