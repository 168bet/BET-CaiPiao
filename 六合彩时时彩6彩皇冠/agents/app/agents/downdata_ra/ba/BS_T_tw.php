<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/BS_browse/index.php?rtype=t&uid=$uid&langx=zh-tw&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/BS_browse/body_var.php?rtype=t&uid=$uid&langx=zh-tw&mtype=3");

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
preg_match_all("/Array\((.+?)\);/is",$meg,$matches);
$cou=sizeof($matches[0]);

for($i=0;$i<$cou;$i++)
{
	$messages=$matches[0][$i];
	$messages=str_replace(");",")",$messages);
	$messages=str_replace("cha(9)","",$messages);
	$datainfo=eval("return $messages;");
	$icount=0;
	for($j=0;$j<sizeof($datainfo);$j++)		
	{
		if ($datainfo[$j]==''){
			$icount=$icount+1;
		}
	}
	if ($icount<5){
		$sql = "update match_sports set S_Single='$datainfo[8]',S_Double='$datainfo[9]',S_1_2='$datainfo[10]',S_3_4='$datainfo[11]',S_5_6='$datainfo[12]',S_19UP='$datainfo[13]',T_Show=1 where MID=$datainfo[0]";
		mysql_query($sql) or die ("�ާ@����!!");	
	}
}
mysql_close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
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
		curtime=curmin+"���۰���������̷s�ƾ�!" 
	else 
		curtime=cursec+"���۰���������̷s�ƾ�!" 
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
      �J�y�Ƽƾڥ��b����<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="�c��" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
