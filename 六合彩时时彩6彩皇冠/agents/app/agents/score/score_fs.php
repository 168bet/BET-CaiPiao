<?php
require ("../include/config.inc.php");
require ('../include/curl_http.php');
require ("../include/traditional.zh-tw.inc.php");

$mysql = "select Uid_tw,datasite_tw,udp_ft_score,udp_ft_results from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$sid=$row['Uid_tw'];
$site=$row['datasite_tw'];
$settime=$row['udp_ft_score'];
$time=$row['udp_ft_results'];
$list_date=date('Y-m-d',time()-$time*60*60);


$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_index.php?uid=$sid&langx=zh-tw&mtype=3");
$html_date=$curl->fetch_url("".$site."/app/member/result/result.php?game_type=NFS&list_date=$list_date&uid=$sid&langx=zh-tw");

$a = array(
//"<font color=\"#CC0000\">",
"<script>",
" ",
"</script>");
$b = array(
//"",
"",
"",
""
);


$msg = str_replace($a,$b,$html_date);
//echo $msg;
$data1=explode("</div>",$msg);
$m=0;
$data=explode('<trclass="b_cen">',$msg);
for ($i=1;$i<sizeof($data);$i++){
//echo $i."---";
	$abcde=explode("</td>",$data[$i]);

	$abcd=explode('<br>',$abcde[1]);
	
	$league=$abcd[1];
	$league=str_replace('-','',$league);
	$mb_team=$abcd[2];
	$sleague=$abcd[0];
	$sleague=str_replace('<td>','',$sleague);
	$sleague=str_replace('-','',$sleague);
	
	//$sleague=substr($sleague,3);
	
	$league=str_replace('<td>','',$league);
	$league=strtoupper(trim(strtoupper($league)));

	$data1=explode('<td><fontcolor="#CC0000">',$abcde[3]);
	$win=trim(str_replace("<br></font>","",$data1[1]));
	$win=trim(str_replace("<BR>","','",strtoupper($win)));
	$win="('".$win."')";

	$sql="select id,mid from match_crown where replace(M_Item_tw,' ','') in $win and replace(MB_Team_tw,' ','')='$mb_team' and date_format(M_Start,'%Y-%m-%d')>='$list_date'";
	//echo $sql."<br><br><br>";

	$result = mysql_query( $sql);
	$id=array();
	while ($row = mysql_fetch_array($result)){
		$id[]=$row['id'];
		$mid=$row['mid'];
		$sql="update match_crown set win=-1 where mid=$mid";
		mysql_query( $sql);		
	}

	$sql="update match_crown set win=1 where id in (".implode(",",$id).")";
	@mysql_query( $sql);
	//echo $sql;

	//echo "<font color=blue>".$win."</font><br>";
	$m++;
}

echo '<br>目前比分以结算出'.$m;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>足球接比分</title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
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
		curtime=curmin+"秒后自动本页获取最新数据！" 
	else 
		curtime=cursec+"秒后自动本页获取最新数据！" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 

window.onload=beginrefresh 
file://--> 
</script>
<body>
<table width="100" height="70" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="100" height="70" align="center"><br><?=$list_date?><br><br><span id="timeinfo"></span><br>
      <input type=button name=button value="足球更新" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
