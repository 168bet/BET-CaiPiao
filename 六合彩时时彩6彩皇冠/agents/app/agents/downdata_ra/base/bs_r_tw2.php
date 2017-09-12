<?
require"../../../../include/conn_ft8.php";
require"../../../../include/function.php";
require ("../../../../include/curl_http.php");
$uid=$_REQUEST['uid'];
$settime=$_REQUEST['settime'];
$site=$_REQUEST['sitename'];
$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/browse_BS/loadgame_R.php?langx=zh-tw&uid=$uid";
$html_data=$curl->fetch_url("".$site."/app/member/browse_BS/reloadgame_R.php?langx=zh-tw&uid=$uid&LegGame=ALL&page_no=$page_no";
echo $filename;

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

//$msg = str_replace($a,$b,$html_data);
echo $msg."<br><br><br>";
preg_match_all("/new Array\(\'(.+?)\);/is",$msg,$matches);
$cou=sizeof($matches[0]);
for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
	echo $messages;
	$messages=str_replace("new Array(","",$messages);
	$messages=str_replace(")","",$messages);
	$messages=str_replace("'","",$messages);
	$datainfo=explode(",",$messages);
	$m_Date=date("m-d",strtotime($datainfo[1]));
	$m_Time=date("h:iA",strtotime($datainfo[1]));
	$m_Time=str_replace("M","",$m_Time);
	

	$mb_dime=str_replace('10+100','O9.5',$datainfo[13]);
	$mb_dime=str_replace('10+50','O9.5/10',$mb_dime);
	$mb_dime=str_replace('10+0','O10',$mb_dime);
	$mb_dime=str_replace('9+100','O8.5',$mb_dime);
	$mb_dime=str_replace('9+50','O8.8/9',$mb_dime);
	$mb_dime=str_replace('9+0','O9',$mb_dime);
    $mb_dime=str_replace('8+100','O7.5',$mb_dime);
	$mb_dime=str_replace('8+50','O7.5/8',$mb_dime);
	$mb_dime=str_replace('8+0','O8',$mb_dime);
	$mb_dime=str_replace('7+100','O6.5',$mb_dime);
	$mb_dime=str_replace('7+50','O6.5/7',$mb_dime);
	$mb_dime=str_replace('7+0','O7',$mb_dime);
	$mb_dime=str_replace('6+100','O5.5',$mb_dime);
	$mb_dime=str_replace('6+50','O5.5/6',$mb_dime);
	$mb_dime=str_replace('6+0','O6',$mb_dime);
	$mb_dime=str_replace('5+100','O4.5',$mb_dime);
	$mb_dime=str_replace('5+50','O4.5/5',$mb_dime);
	$mb_dime=str_replace('5+0','O5',$mb_dime);
	$mb_dime=str_replace('4+100','O3.5',$mb_dime);
	$mb_dime=str_replace('4+50','O3.5/4',$mb_dime);
	$mb_dime=str_replace('4+0','O4',$mb_dime);
	$mb_dime=str_replace('3+100','O2.5',$mb_dime);
	$mb_dime=str_replace('3+50','O2.5/3',$mb_dime);
	$mb_dime=str_replace('3+0','O3',$mb_dime);
	$mb_dime=str_replace('2+100','O1.5',$mb_dime);
	$mb_dime=str_replace('2+50','O1.5/2',$mb_dime);
	$mb_dime=str_replace('2+0','O2',$mb_dime);
	$mb_dime=str_replace('1+100','O0.5',$mb_dime);
	$mb_dime=str_replace('1+50','O0.5/1',$mb_dime);
	$mb_dime=str_replace('1+0','O1',$mb_dime);
	
	$tg_dime=str_replace('10+100','U9.5',$datainfo[13]);
	$tg_dime=str_replace('10+50','U9.5/10',$tg_dime);
	$tg_dime=str_replace('10+0','U10',$tg_dime);
	$tg_dime=str_replace('9+100','U8.5',$tg_dime);
	$tg_dime=str_replace('9+50','U8.8/9',$tg_dime);
	$tg_dime=str_replace('9+0','U9',$tg_dime);
    $tg_dime=str_replace('8+100','U7.5',$tg_dime);
	$tg_dime=str_replace('8+50','U7.5/8',$tg_dime);
	$tg_dime=str_replace('8+0','U8',$tg_dime);
	$tg_dime=str_replace('7+100','U6.5',$tg_dime);
	$tg_dime=str_replace('7+50','U6.5/7',$tg_dime);
	$tg_dime=str_replace('7+0','U7',$tg_dime);
	$tg_dime=str_replace('6+100','U5.5',$tg_dime);
	$tg_dime=str_replace('6+50','U5.5/6',$tg_dime);
	$tg_dime=str_replace('6+0','U6',$tg_dime);
	$tg_dime=str_replace('5+100','U4.5',$tg_dime);
	$tg_dime=str_replace('5+50','U4.5/5',$tg_dime);
	$tg_dime=str_replace('5+0','U5',$tg_dime);
	$tg_dime=str_replace('4+100','U3.5',$tg_dime);
	$tg_dime=str_replace('4+50','U3.5/4',$tg_dime);
	$tg_dime=str_replace('4+0','U4',$tg_dime);
	$tg_dime=str_replace('3+100','U2.5',$tg_dime);
	$tg_dime=str_replace('3+50','U2.5/3',$tg_dime);
	$tg_dime=str_replace('3+0','U3',$tg_dime);
	$tg_dime=str_replace('2+100','U1.5',$tg_dime);
	$tg_dime=str_replace('2+50','U1.5/2',$tg_dime);
	$tg_dime=str_replace('2+0','U2',$tg_dime);
	$tg_dime=str_replace('1+100','U0.5',$tg_dime);
	$tg_dime=str_replace('1+50','U0.5/1',$tg_dime);
	$tg_dime=str_replace('1+0','U1',$tg_dime);
	//echo $tg_dime;
	
	$checksql = "select MID from base_match where `MID` =$datainfo[0]";
	$checkresult = mysql_query($checksql);
	$check=mysql_num_rows($checkresult);
	if($check==0){
		$sql = "INSERT INTO baobao(MID,M_Start,M_League_tw,M_Date,M_Time,MB_Team_tw,TG_Team_tw,MB_MID,TG_MID,ShowType,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,TG_Dime,TG_Dime_Rate,MB_Dime_Rate,MB_Win,TG_Win,MB_OneWin,TG_OneWin,M_Type,R_Show) VALUES 
			('$datainfo[0]','$datainfo[1]','$datainfo[2]','$m_Date','$m_Time','$datainfo[4]','$datainfo[5]','$datainfo[3]','$datainfo[4]','$datainfo[6]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$mb_dime','$tg_dime','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$m_Type','1')";
		//mysql_query($sql) or die ("操作失?!");
		
	}else{
		$sql = "update baobao set M_Start=1'$datainfo[1]',M_League_tw=2'$datainfo[2]',MB_Team_tw=3'$datainfo[4]',TG_Team_tw=4'$datainfo[5]',M_Date=5'$m_Date',M_Time=6'$m_Time',ShowType=7'$datainfo[6]',M_LetB=8'$datainfo[10]',MB_LetB_Rate=9'$datainfo[11]',TG_LetB_Rate=10'$datainfo[12]',MB_Dime=11'$mb_dime',TG_Dime=12'$tg_dime',TG_Dime_Rate=13'$datainfo[14]',MB_Dime_Rate=14'$datainfo[15]',MB_Win=15'$datainfo[18]',TG_Win=16'$datainfo[19]',MB_OneWin=17'$datainfo[16]',TG_OneWin=18'$datainfo[17]',R_Show=191,M_Type=20'$m_Type' where MID=$datainfo[0]";
		
	}
	echo "<br><br>";
echo "<font color=#000000>".$sql."</font>";

//mysql_query($sql) or die ("操作失?1!");
}
}
$abcd=explode("parent.msg='",$meg);
$msg_tw=explode("';",$abcd[1]);
/*
$sql = "select msg_update from web_system";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if ($row['msg_update']==1 and $msg_tw[0]!=''){
	$sql="update web_system set msg_member='$msg_tw[0]'";
	mysql_query($sql) or die ("公告更新操作失敗!");		
}
*/
mysql_close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}
-->
</style>
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
		curtime=curmin+"秒后自??取本?最新?据！" 
	else 
		curtime=cursec+"秒后自??取本?最新?据！" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 

window.onload=beginrefresh 
file://--> 
</script>
<table width="102" height="100" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="108" height="100" align="center"><br>
      ?式?据正在接收<br>
      <span id="timeinfo"></span><br>
      <input type=button name=button value="?体" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
