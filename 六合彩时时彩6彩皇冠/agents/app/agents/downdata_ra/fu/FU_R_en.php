<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/browse/index.php?ptype=S&gtype=FU&&uid=$uid&langx=en-us";
$html_data=$curl->fetch_url("".$site."/app/member/browse/var.php?ptype=S&rtype=&gtype=FU&pctype=&uid=$uid&langx=en-us&ltype=3";
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
//echo $msg;
preg_match_all("/gd\[(.+?)\](.+?);/is",$msg,$matches);
//拆mid
preg_match_all("/gs =(.+?);/is",$msg,$matchesGS);
$messagesGS=$matchesGS[0][0];
$messagesGS=str_replace("gs = Array(","",$messagesGS);
$messagesGS=str_replace(");","",$messagesGS);
$datainfoGS=explode(",",$messagesGS);
//拆联盟
preg_match_all("/le =(.+?);/is",$msg,$matchesLE);
$messagesLE=$matchesLE[0][0];
$messagesLE=str_replace("le = Array(","",$messagesLE);
$messagesLE=str_replace('"',"",$messagesLE);
$messagesLE=str_replace(");","",$messagesLE);
$datainfoLE=explode(",",$messagesLE);
	
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	$messages=str_replace("gd[$i] = Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
	$datainfo=explode(",",$messages);
    $team_en =$datainfo[5]; 
	$team_en=explode("不給抓不給抓不給抓",$team_en);
	$mb_team_en=$team_en[0].$team_en[1];
	/*********************/
	$mid=$datainfoGS[$i];//对应的mid
	$m_league_en=$datainfoLE[$datainfo[1]];//对应的联盟
	/********************/
	$sql = "update match_stock set MB_Team_en='$mb_team_en',M_League_en='$m_league_en' where MID='$mid'";
	//echo $sql;
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
      <input type=button name=button value="英文" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
