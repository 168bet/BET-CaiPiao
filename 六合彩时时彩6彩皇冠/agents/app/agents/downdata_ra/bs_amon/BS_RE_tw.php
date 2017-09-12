<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$mysql = "select uid,uid_tw,uid_en from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$uid =$row['uid_tw'];

$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/BS_browse/index.php?rtype=re&uid=$uid&langx=zh-tw&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/BS_browse/body_var.php?rtype=re&uid=$uid&langx=zh-tw&mtype=3");

preg_match_all("/new Array\((.+?)\);/is",$msg,$matches);
$gmid='';
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
$messages=$matches[0][$i];
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
	$messages = iconv("BIG5","UTF-8",$messages);
	$datainfo=explode(",",$messages);
	
	$mDate=explode('<BR>',strtoupper($datainfo[1]));
	$m_Date=date('Y')."-".$mDate[0];
	$m_Time=strtolower($mDate[1]);
	$hhmmstr=explode(":",$m_Time);
	$hh=$hhmmstr[0];
	$ap=substr($m_Time,strlen($m_Time)-1,1); 
	
	if ($ap=='p' and $hh<>12){
		$hh+=12;
	}
	$timestamp = $m_Date." ".$hh.":".substr($hhmmstr[1],0,strlen($hhmmstr[1])-1).":00";
	if (sizeof($mDate)>2){
		$m_Type=1;
		}
	else{
		$m_Type=0;
	}
	if ($gmid==''){
		$gmid=$datainfo[0];
	}else{
		$gmid=$gmid.','.$datainfo[0];
		//echo $gmid;
	}
	$checksql = "select MID from match_sports where `MID` ='$datainfo[0]'";
	$checkresult = mysql_query($checksql);	
	$check=mysql_num_rows($checkresult);
	if($check==0){
		$sql = "INSERT INTO match_sports(MID,M_Date,M_Time,MB_Team_tw,TG_Team_tw,M_League_tw,MB_MID,TG_MID,ShowType) VALUES 			('$datainfo[0]','$m_Date','$m_Time','$datainfo[5]','$datainfo[6]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[7]')";
		mysql_query($sql) or die ("操作失敗!");
	}else{
		$sql = "update match_sports set MB_Team_tw='$datainfo[5]',TG_Team_tw='$datainfo[6]',M_League_tw='$datainfo[2]',ShowType='$datainfo[7]',Re_Show=1 where MID=$datainfo[0]";
		mysql_query($sql) or die ("操作失敗!!");
	}
}	
$sql="update match_sports set RE_Show=0 where RE_Show=1 and locate(MID,'$gmid')<1";
mysql_query($sql) or die ("操作失敗!!!");
mysql_close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="/style/agents/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}
-->
</style>
</head>

<body bgcolor="#AACCCC">
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
      走地數據接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁体" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
