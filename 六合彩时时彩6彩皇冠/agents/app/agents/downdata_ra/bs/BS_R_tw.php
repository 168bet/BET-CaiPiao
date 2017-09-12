<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$mysql = "select datasite_tw,Uid_tw,udp_ft_tw from web_system_data where ID=1";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$uid =$row['Uid_tw'];
$site=$row['datasite_tw'];
$settime=$row['udp_ft_tw'];
$m_date=date('Y-m-d');

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/BS_browse/index.php?rtype=r&uid=$uid&langx=zh-tw&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/BS_browse/body_var.php?rtype=r&uid=$uid&langx=zh-tw&mtype=3");

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
//echo $msg;
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
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
	}else{
		$m_Type=0;
	}
	$checksql = "select MID from match_sports where `MID` ='$datainfo[0]' and M_Date='$m_date'";
	$checkresult = mysql_query($checksql);	
	$check=mysql_num_rows($checkresult);
	if($check==0){
		$sql = "INSERT INTO match_sports(MID,Type,M_Start,M_Date,M_Time,MB_Team_tw,TG_Team_tw,M_League_tw,MB_MID,TG_MID,ShowTypeR,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,TG_Dime,TG_Dime_Rate,MB_Dime_Rate,MB_Win_Rate,TG_Win_Rate,S_Single_Rate,S_Double_Rate,M_Type,S_Show) VALUES ('$datainfo[0]','BS','$timestamp','$m_Date','$m_Time','$datainfo[5]','$datainfo[6]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[19]','$datainfo[20]','$m_Type','1')";
		mysql_query($sql) or die ("操作失敗!");
	}else{
		$sql = "update match_sports set Type='BS',MB_Team_tw='$datainfo[5]',TG_Team_tw='$datainfo[6]',M_Start='$timestamp',M_Date='$m_Date',M_Time='$m_Time',M_League_tw='$datainfo[2]',MB_MID='$datainfo[3]',TG_MID='$datainfo[4]',ShowTypeR='$datainfo[7]',M_LetB='$datainfo[8]',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',MB_Dime='$datainfo[11]',TG_Dime='$datainfo[12]',TG_Dime_Rate='$datainfo[13]',MB_Dime_Rate='$datainfo[14]',MB_Win_Rate='$datainfo[15]',TG_Win_Rate='$datainfo[16]',S_Single_Rate='$datainfo[19]',S_Double_Rate='$datainfo[20]',S_Show=1,M_Type='$m_Type' where MID=$datainfo[0]";
		mysql_query($sql) or die ("操作失敗!!");
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
      單式數據接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁体 <?=$cou?>" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
