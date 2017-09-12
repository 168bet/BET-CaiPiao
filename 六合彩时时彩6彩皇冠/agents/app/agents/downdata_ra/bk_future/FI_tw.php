<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/browse_FS/loadgame_R.php?uid=$uid&langx=zh-tw&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/browse_FS/reloadgame_R.php?uid=$uid&langx=zh-twchoice=ALL&LegGame=&pages=1&records=40&FStype=&area_id=&item_id=&rtype=fi";

$a = array(
"if(self == top)",
"<script>",
"</script>",
"\n\n",
"new Array()"
);
$b = array(
"",
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
if ($cou>0){
	$sql='update match_crown set CS_Show=0';
	mysql_query($sql) or die ("操作失败!");
}
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace("'","",$messages);
	$messages=str_replace(");","",$messages);
	$messages=iconv("BIG5","UTF-8",$messages);
	$datainfo=explode(",",$messages);
	$m_Date=date("Y-m-d",strtotime($datainfo[1]));
	$m_start=$datainfo[1];
	$Time=date("H:i",strtotime($datainfo[1]));
	if($Time=='12:00' or $Time=='00:01'){
	  $m_Time=$Time.'a';
	}else{
	  $m_Time=$Time.'p';
	}
	$ntype = '';
    $ftype = '';
	$team = '';
    $rate = '';
    $num = $datainfo[5];
    for ($s=0; $s<$num; ++$s){
         $game_num = $s * 4 + 4;		 
         $ntype .= $datainfo[$game_num + 2].",";
         $ftype .= $datainfo[$game_num + 3].",";
		 $team = $team . $datainfo[$game_num + 4].",";
         $rate .= $datainfo[$game_num + 5].",";
	}
	$gtype=$datainfo[$game_num + 6];
	$checksql = "select MID from match_crown where `MID` =$datainfo[0]";
	$checkresult = mysql_query($checksql);	
	$check=mysql_num_rows($checkresult);
	if ($check==0){
		$sql = "INSERT INTO match_crown(MID,M_Start,M_Date,M_Time,M_League_tw,MB_Team_tw,M_Item_tw,Ytype,Num,Ntype,Ftype,M_Rate,Gtype,CS_Show) VALUES ('$datainfo[0]','$m_start','$m_Date','$m_Time','$datainfo[2]','$team','$datainfo[3]','$datainfo[4]','$num','$ntype','$ftype','$rate','$gtype','1')";
		mysql_query($sql) or die ("操作失敗!");
	}else{	
		$sql="update match_crown set MB_Team_tw='$team',M_League_tw='$datainfo[2]',M_Item_tw='$datainfo[3]',M_Date='$m_Date',M_Time='$m_Time',M_Start='$m_start',Ytype='$datainfo[4]',Num='$num',Ntype='$ntype',Ftype='$ftype',M_Rate='$rate',Gtype='$gtype',CS_Show=1 where MID='".$datainfo[0]."'";
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
     金融數據接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="繁體 <?=$cou?>" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
