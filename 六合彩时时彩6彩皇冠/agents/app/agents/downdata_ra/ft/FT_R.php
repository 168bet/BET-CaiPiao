<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$mysql = "select datasite,Uid,udp_ft_r from web_system_data where ID=1";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$uid =$row['Uid'];
$site=$row['datasite'];
$settime=$row['udp_ft_r'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_browse/index.php?rtype=r&uid=$uid&langx=zh-cn&mtype=3");
$allcount=0;
for($page_no=0;$page_no<10;$page_no++){
$html_data=$curl->fetch_url("".$site."/app/member/FT_browse/body_var.php?rtype=r&uid=$uid&langx=zh-cn&mtype=3&page_no=$page_no");

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
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
	$datainfo=explode(",",$messages);
	if(!empty($datainfo)){
		$sql = "update match_sports set MB_Team='$datainfo[5]',TG_Team='$datainfo[6]',M_League='$datainfo[2]' where MID=$datainfo[0]";
		mysql_query($sql) or die ("操作失败!");
	    $allcount++;
	}else{
		continue;
	}
}
}
$abcd=explode("parent.msg='",$msg);
$msg_tw=explode("';",$abcd[1]);

$sql = "select msg_update from web_system_data";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if ($row['msg_update']==1 and $msg_tw[0]!=''){
	$sql="update web_system_data set msg_system='$msg_tw[0]'";
	mysql_query($sql) or die ("公告更新操作失败!");		
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
      <input type=button name=button value="简体 <?=$allcount?>" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
