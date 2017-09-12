<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$mysql = "select * from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$open=$row['opentype'];
$site=$row['InUrl'];
$uid =$row['InUid'];
$uid_tw =$row['InUid_tw'];
$uid_en =$row['InUid_en'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>指数接收</title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
<body>
<script> 
<!-- 
var limit="6:00" 
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
<table width="100" height="70"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="100" height="70" valign="top"> 
      <iframe width=100 height=70 src='FU_R_tw.php?uid=<?=$uid_tw?>&sitename=<?=$site?>&opentype=<?=$open?>&settime=<?=$row['udp_ft_r']?>' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="100" height="70" valign="top"> 
      <iframe width=100 height=70 src='FU_R.php?uid=<?=$uid?>&sitename=<?=$site?>&opentype=<?=$open?>&settime=<?=$row['udp_ft_r']?>' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="100" height="70" valign="top">
	  <iframe width=100 height=70 src='FU_R_en.php?uid=<?=$uid_en?>&sitename=<?=$site?>&opentype=<?=$open?>&settime=<?=$row['udp_ft_r']?>' frameborder=0 scrolling="no"></iframe> 
    </td>
	<td width="100" height="70" valign="top"> 
      <iframe width=100 height=70 src='FU_PD_tw.php?uid=<?=$uid_tw?>&sitename=<?=$site?>&opentype=<?=$open?>&settime=<?=$row['udp_ft_pd']?>' frameborder=0 scrolling="no"></iframe> 
    </td>
  </tr>
</table>
</body>
</html>
