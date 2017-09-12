<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$mysql = "select datasite_tw as datasite,Uid_tw,udp_ft_pd from web_system_data where ID=1";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$uid =$row['Uid_tw'];
$site=$row['datasite'];
$settime=$row['udp_ft_pd'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_browse/index.php?rtype=hpd&uid=$uid&langx=zh-tw&mtype=3");
$allcount=0;
for($page_no=0;$page_no<15;$page_no++){
$html_data=$curl->fetch_url("".$site."/app/member/FT_browse/body_var.php?rtype=hpd&uid=$uid&langx=zh-tw&mtype=3&page_no=$page_no");

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
		$sql = "update match_sports set MB1TG0H='$datainfo[8]',MB2TG0H='$datainfo[9]',MB2TG1H='$datainfo[10]',MB3TG0H='$datainfo[11]',MB3TG1H='$datainfo[12]',MB3TG2H='$datainfo[13]',MB4TG0H='$datainfo[14]',MB4TG1H='$datainfo[15]',MB4TG2H='$datainfo[16]',MB4TG3H='$datainfo[17]',MB0TG0H='$datainfo[18]',MB1TG1H='$datainfo[19]',MB2TG2H='$datainfo[20]',MB3TG3H='$datainfo[21]',MB4TG4H='$datainfo[22]',UP5H='$datainfo[23]',MB0TG1H='$datainfo[24]',MB0TG2H='$datainfo[25]',MB1TG2H='$datainfo[26]',MB0TG3H='$datainfo[27]',MB1TG3H='$datainfo[28]',MB2TG3H='$datainfo[29]',MB0TG4H='$datainfo[30]',MB1TG4H='$datainfo[31]',MB2TG4H='$datainfo[32]',MB3TG4H='$datainfo[33]',HPD_Show=1 where MID=$datainfo[0]-1";
		mysql_query($sql) or die ("操作失敗!");
	    $allcount++;
	}else{
		continue;
	}
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
      上半波膽數據接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁體 <?=$allcount?>" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
