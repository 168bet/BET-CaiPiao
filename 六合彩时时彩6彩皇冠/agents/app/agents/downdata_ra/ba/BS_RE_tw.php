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
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
for($page_no=0;$page_no<8;$page_no++)
{
$filename="".$site."/app/member/BS_browse/body_var.php?rtype=re&uid=$uid&langx=zh-tw&mtype=3");

preg_match_all("/Array\((.+?)\);/is",$meg,$matches);
$gmid='';
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
$messages=$matches[0][$i];
	$messages=str_replace(");","",$messages);
	$messages=str_replace("cha(9)","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace("Array(","",$messages);
	$datainfo=explode(",",$messages);
	
	$mDate=explode('<BR>',strtoupper($datainfo[1]));
	$m_Date=date("m-d");
	$m_Time=strtolower($mDate[1]);
	$hhmmstr=explode(":",$m_Time);
	$hh=$hhmmstr[0];
	$ap=substr($m_Time,strlen($m_Time)-1,1); 
	
	if ($ap=='p' and $hh<>12){
		$hh+=12;
	}
	$timestamp = date('Y')."-".$m_Date." ".$hh.":".substr($hhmmstr[1],0,strlen($hhmmstr[1])-1).":00";
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
		$sql = "INSERT INTO match_sports(MID,M_Date,M_Time,MB_Team_tw,TG_Team_tw,M_League_tw,MB_MID,TG_MID,ShowType) VALUES 
			('$datainfo[0]','$m_Date','$m_Time','$datainfo[5]','$datainfo[6]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[7]')";
		mysql_query($sql) or die ("紱釬囮啖!");
	}else{
		$sql = "update match_sports set MB_Team_tw='$datainfo[5]',TG_Team_tw='$datainfo[6]',M_League_tw='$datainfo[2]',ShowType='$datainfo[7]',Re_Show=1 where MID=$datainfo[0]";
		mysql_query($sql) or die ("紱釬囮啖1!");
	}
}
}	
$sql="update match_sports set RE_Show=0 where RE_Show=1 and locate(MID,'$gmid')<1";
mysql_query($sql) or die ("操作失敗!");
mysql_close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
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
      走地數據正在接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁体" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
