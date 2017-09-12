<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>网球接收</title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
<body>
<script> 
<!-- 
var limit="10:00" 
if (document.images){ 
	var parselimit=limit.split(":") 
	parselimit=parselimit[0]*60+parselimit[1]*1 
} 
function beginrefresh(){ 
	if (!document.images) 
		return 
	if (parselimit==1) 
		window.location.reload() 
	else{ 
		parselimit-=1 
		curmin=Math.floor(parselimit/60) 
		cursec=parselimit%60 
		if (curmin!=0) 
			curtime=curmin+"分"+cursec+"秒后自动登陆！" 
		else 
			curtime=cursec+"秒后自动登陆！" 
		//	timeinfo.innerText=curtime 
			setTimeout("beginrefresh()",1000) 
	} 
} 
window.onload=beginrefresh 
//--> 
</script>
<table width="200" height="140"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="100" height="70" valign="top"> 
      <iframe width=100 height=70 src='TN_R_tw.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="100" height="70" valign="top"> 
      <iframe width=100 height=70 src='TN_R.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="100" height="70" valign="top">
	  <iframe width=100 height=70 src='TN_R_en.php' frameborder=0 scrolling="no"></iframe> 
    </td>
  </tr>
  <tr> 
    <td width="100" height="70" valign="top"> 
      <iframe width=100 height=70 src='TN_RE_tw.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="100" height="70" valign="top"> 
      <iframe width=100 height=70 src='TN_RE.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="100" height="70" valign="top">
	  <iframe width=100 height=70 src='TN_RE_en.php' frameborder=0 scrolling="no"></iframe> 
    </td>
  </tr>
  <tr> 
    <td width="100" height="70" valign="top"> 
      <iframe width=100 height=70 src='TN_PD_tw.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="100" height="70" valign="top"> 
      <iframe width=100 height=70 src='TN_P_tw.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="100" height="70" valign="top">
	  <iframe width=100 height=70 src='TN_PR_tw.php' frameborder=0 scrolling="no"></iframe> 
    </td>
  </tr>
</table>
</body>
</html>