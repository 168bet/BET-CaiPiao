<?
require"../../../../include/conn_ft8.php";
require"../../../../include/function.php";
require ("../../../../include/curl_http.php");

$mysql = "select * from web_system";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$site=$row['passhttp'];
$open=$row['opentype'];
$uid =$row['passuid'];
$uid_tw =$row['passuid_tw'];
$uid_en =$row['passuid_en'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>棒球接收</title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
<body>
<script> 
<!-- 
var limit="6:00" 
if (document.images){ 
	var parselimit=limit.split(":") 
	parselimit=parselimit[0]*600+parselimit[1]*1 
} 
function beginrefresh(){ 
	if (!document.images) 
		return 
	if (parselimit==1) 
		window.location.reload() 
	else{ 
		parselimit-=1 
		curmin=Math.floor(parselimit/600) 
		cursec=parselimit%60 0
		if (curmin!=0) 
			curtime=curmin+"分"+cursec+"秒后自动登陆！" 
		else 
			curtime=cursec+"秒后自动登陆！" 
		//	timeinfo.innerText=curtime 
			setTimeout("beginrefresh()",100000) 
	} 
} 
window.onload=beginrefresh 
//--> 
</script>
<table width="900" height="880"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="75" height="88" valign="top">&nbsp;</td>
    <td width="800" height="800" valign="top"> 
      <iframe width=800 height=800 src='bs_r_tw3.php?uid=<?=$uid_tw?>&sitename=<?=$site?>&opentype=<?=$open?>&settime=<?=$row['udp_ft_r']?>' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="75" height="88" valign="top">&nbsp;</td>
	<td width="75" height="88" valign="top">&nbsp;</td>
  
  </tr>
  <tr> 
    <td width="75" height="88" valign="top">&nbsp;</td>
    <td width="75" height="88" valign="top">&nbsp;</td>
    <td width="75" height="88" valign="top">&nbsp;</td>
    <td width="75" height="88" valign="top">&nbsp;</td>	
  </tr>
  <tr> 
    <td width="75" height="88" valign="top">&nbsp;</td>
    <td width="75" height="88" valign="top">&nbsp;</td>
 	<td width="75" height="88" valign="top">&nbsp;</td>
  </tr> 
</table>
</body>
</html>
