<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_future/index.php?rtype=hr&uid=$uid&langx=zh-tw&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/FT_future/body_var.php?rtype=hr&uid=$uid&langx=zh-tw&mtype=3");

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
	
	if($datainfo[9]=='' or $datainfo[10]==''){
	   $mb_letb_rate_v=$datainfo[9];
	   $tg_letb_rate_v=$datainfo[10];
	}else{
	   $mb_letb_rate_v=$datainfo[9]+1;
	   $tg_letb_rate_v=$datainfo[10]+1;
	}
	if($datainfo[13]=='' or $datainfo[14]==''){
	   $mb_dime_rate_v=$datainfo[14];
	   $tg_dime_rate_v=$datainfo[13];
	}else{
	   $mb_dime_rate_v=$datainfo[14]+1;
	   $tg_dime_rate_v=$datainfo[13]+1;	
	}
	
	$sql = "update match_sports set ShowTypeV='$datainfo[7]',M_LetB_V='$datainfo[8]',MB_LetB_Rate_V='$mb_letb_rate_v',TG_LetB_Rate_V='$tg_letb_rate_v',MB_Dime_V='$datainfo[11]',TG_Dime_V='$datainfo[12]',MB_Dime_Rate_V='$mb_dime_rate_v',TG_Dime_Rate_V='$tg_dime_rate_v',MB_Win_V='$datainfo[15]',TG_Win_V='$datainfo[16]',M_Flat_V='$datainfo[17]',F_V_Show=1 where MID=$datainfo[0]-1";
	mysql_query($sql) or die ("操作失敗!");
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
       上半場數據接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁體" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
