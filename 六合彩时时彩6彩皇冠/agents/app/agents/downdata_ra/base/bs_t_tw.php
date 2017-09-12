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
$curl->set_referrer("".$site."/app/member/browse_BS/loadgame_T.php?langx=zh-tw&uid=$uid";
$html_data=$curl->fetch_url("".$site."/app/member/browse_BS/reloadgame_T.php?langx=zh-tw&uid=$uid&LegGame=ALL&page_no=$page_no";

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
	$messages=str_replace(")","",$messages);
	$messages=str_replace("'","",$messages);
	//转码
	$messages = iconv("big5","utf-8",$messages);
	$datainfo=explode(",",$messages);
	$icount=0;
	for($j=0;$j<sizeof($datainfo);$j++)		
	{
		if ($datainfo[$j]==''){
			$icount=$icount+1;
		}
	}
	if ($icount<5){
		$sql = "update base_match set S_1_2='$datainfo[10]',S_3_4='$datainfo[11]',S_5_6='$datainfo[12]',S_7_8='$datainfo[13]',S_9_10='$datainfo[14]',S_11_12='$datainfo[15]',S_13_14='$datainfo[16]',S_15_16='$datainfo[17]',S_17_18='$datainfo[18]',S_19UP='$datainfo[19]',T_Show=1 where MID=$datainfo[0]";
		mysql_query($sql) or die ("巨ア?1!");	
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
		curtime=curmin+"笆莉セ程穝计沮!" 
	else 
		curtime=cursec+"笆莉セ程穝计沮!" 
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
      羆眔だ计沮タ钡Μ<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="羉砰" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
