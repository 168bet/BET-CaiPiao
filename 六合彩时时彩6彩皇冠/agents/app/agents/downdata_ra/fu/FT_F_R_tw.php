<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_future/index.php?rtype=r&uid=$uid&langx=zh-tw&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/FT_future/body_var.php?rtype=r&uid=$uid&langx=zh-tw&g_date=ALL&mtype=3");

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

preg_match_all("/new Array\((.+?)\);/is",$meg,$matches);
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
	if($datainfo[9]=='' or $datainfo[10]==''){
	   $mb_letb_rate=$datainfo[9];
	   $tg_letb_rate=$datainfo[10];
	}else{
	   $mb_letb_rate=$datainfo[9]+1;
	   $tg_letb_rate=$datainfo[10]+1;
	}
	if($datainfo[13]=='' or $datainfo[14]==''){
	   $mb_dime_rate=$datainfo[14];
	   $tg_dime_rate=$datainfo[13];
	}else{
	   $mb_dime_rate=$datainfo[14]+1;
	   $tg_dime_rate=$datainfo[13]+1;	
	}
	$checksql = "select MID from match_sports where `MID` =$datainfo[0]";
	$checkresult = mysql_query($checksql);	
	$check=mysql_num_rows($checkresult);
	if($check==0){
		$sql = "INSERT INTO match_sports(MID,M_Start,M_Date,M_Time,MB_Team_tw,TG_Team_tw,M_League_tw,MB_MID,TG_MID,ShowType,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,TG_Dime,TG_Dime_Rate,MB_Dime_Rate,MB_Win,TG_Win,M_Flat,M_Type,F_S_Show) VALUES 
			('$datainfo[0]','$timestamp','$m_Date','$m_Time','$datainfo[5]','$datainfo[6]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[7]','$datainfo[8]','$mb_letb_rate','$tg_letb_rate','$datainfo[11]','$datainfo[12]','$tg_dime_rate','$mb_dime_rate','$datainfo[15]','$datainfo[16]','$datainfo[17]','$m_Type','1')";
		mysql_query($sql) or die ("操作失敗!");
	}else{
		$sql = "update match_sports set MB_Team_tw='$datainfo[5]',TG_Team_tw='$datainfo[6]',M_Start='$timestamp',M_Date='$m_Date',M_Time='$m_Time',M_League_tw='$datainfo[2]',ShowType='$datainfo[7]',M_LetB='$datainfo[8]',MB_LetB_Rate='$mb_letb_rate',TG_LetB_Rate='$tg_letb_rate',MB_Dime='$datainfo[11]',TG_Dime='$datainfo[12]',TG_Dime_Rate='$tg_dime_rate',MB_Dime_Rate='$mb_dime_rate',MB_Win='$datainfo[15]',TG_Win='$datainfo[16]',M_Flat='$datainfo[17]',s_single='$datainfo[20]',s_double='$datainfo[21]',F_S_Show=1,M_Type='$m_Type' where MID=$datainfo[0]";
		mysql_query($sql) or die ("操作失敗1!");
	}

}
}
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
