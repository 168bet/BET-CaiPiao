<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/browse/index.php?ptype=S&gtype=FU&&uid=$uid&langx=big5";
$html_data=$curl->fetch_url("".$site."/app/member/browse/var.php?ptype=S&rtype=&gtype=FU&pctype=&uid=$uid&langx=big5&ltype=3";
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
	echo $messages.'<br>';
	$messages=str_replace("gd[$i] = Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
	$datainfo=explode(",",$messages);
    $team_tw =$datainfo[5]; 
	$team_tw=explode("不給抓不給抓不給抓",$team_tw);
	$mb_team_tw=$team_tw[0].$team_tw[1];

	$mdate=explode('<br>',$datainfo[0]);
	$m_date=date('Y')."-".$mdate[0];
	$m_time=strtolower($mdate[1]);
	
	$hhmmstr=explode(":",$m_time);
	$hh=$hhmmstr[0];
	$ap=substr($m_time,strlen($m_time)-1,1); 
	if ($ap=='p' and $hh<>12){
		$hh+=12;
	}
	$timestamp = $m_date." ".$hh.":".substr($hhmmstr[1],0,strlen($hhmmstr[1])-1).":00";
	/*********************/
	$mid=$datainfoGS[$i];//对应的mid
	$m_league_tw=$datainfoLE[$datainfo[1]];//对应的联盟
	/********************/
	$checksql = "select MID from match_stock where `MID` ='$mid'";
	//echo $checksql;
	$checkresult = mysql_query($checksql);
	$check=mysql_num_rows($checkresult);
	if($check==0){
		$sql = "INSERT INTO match_stock(MID,M_Start,M_Date,M_Time,MB_Team_tw,M_League_tw,MB_MID,TG_MID,MB_Dime_Rate,TG_Dime_Rate,S_Single,S_Double,S_Show) VALUES ('$mid','$timestamp','$m_date','$m_time','$mb_team_tw','$m_league_tw','$datainfo[2]','$datainfo[3]','$datainfo[13]','$datainfo[14]','$datainfo[11]','$datainfo[12]','1')";
		//echo $sql.'<br>';
		mysql_query($sql) or die ("操作失敗");
	}else{
		$sql = "update match_stock set MB_Team_tw='$mb_team_tw',M_Start='$timestamp',M_Date='$m_date',M_Time='$m_time',M_League_tw='$m_league_tw',MB_Dime_Rate='$datainfo[13]',TG_Dime_Rate='$datainfo[14]',S_Single='$datainfo[11]',S_Double='$datainfo[12]',S_Show=1 where MID='$mid'";
		//echo $sql;
		mysql_query($sql) or die ("操作失敗!");
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
      <input type=button name=button value="繁体" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
