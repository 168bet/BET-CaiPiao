<?
require ("../../include/config.inc.php");

require ("../../include/curl_http.php");



$mysql = "select datasite_tw as datasite,Uid_tw,udp_ft_tw from web_system_data where ID=1";

$result = mysql_query($mysql);

$row = mysql_fetch_array($result);

$uid =$row['Uid_tw'];

$site=$row['datasite'];

$settime=$row['udp_ft_tw'];

$m_date=date('Y-m-d');



$curl = &new Curl_HTTP_Client();

$curl->store_cookies("cookies.txt"); 

$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");

$curl->set_referrer("".$site."/app/member/browse_FS/loadgame_R.php?rtype=fs&uid=$uid&langx=zh-tw&mtype=3");

$allcount=0;

//for($page_no=0;$page_no<10;$page_no++){

$html_data=$curl->fetch_url("".$site."/app/member/browse_FS/reloadgame_R.php?uid=$uid&langx=zh-tw&rtype=fs");

$a = array(

"if(self == top)",

"<script>",

"</script>",
"new Array()",

"\n\n"

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

$cou=sizeof($matches[0]);


for($i=0;$i<$cou;$i++){
	$messages=$matches[0][$i];
			

	$messages=str_replace("new Array(","",$messages);

	$messages=str_replace("'","",$messages);

	$messages=str_replace(");","",$messages);

	$datainfo=explode(",",$messages);
	
	$M_Start=$datainfo[1];
	$k=sizeof($datainfo);
	$MID=$datainfo[0];
	$mshow=$datainfo[4];
	$mcount=$datainfo[5];
	$M_League=$datainfo[2];
	$MB_Team=$datainfo[3];
	$gtype=$datainfo[$k-1];

	//$lid=$lids["$league"]+0;
	$pp=($k-6)/4;


	for($t=0;$t<$pp-1;$t++)
	{
		$show2=$datainfo[4*$t+0+6];
		$tid	=$datainfo[4*$t+1+6];
		$M_Item	=$datainfo[4*$t+2+6];
		$rate	=$datainfo[4*$t+3+6];

		$sql = "select id from match_crown where `MID`='$MID' and gid='$tid'";

		$uptime=date('Y-m-d H:i:s');
		
		$checkresult = mysql_query($sql);	

		$check=mysql_num_rows($checkresult);
		
		if($check==0){		
			$sql="INSERT INTO match_crown(MID,M_Start,MB_Team_tw,M_League_tw,M_Item_tw,M_Rate,Gid,mcount,Gtype,mshow,mshow2) VALUES
			('$MID','$M_Start','$MB_Team','$M_League','$M_Item','$rate','$tid','$mcount','$gtype','$mshow','$show2')";
		}else{
			$crs=mysql_fetch_array($checkresult);
			$sql="update match_crown set uptime='$uptime',mshow='$mshow',mshow2='$show2',MB_Team_tw='$MB_Team',M_League_tw='$M_League',M_Item_tw='$M_Item',Gid='$tid',M_Rate='$rate',mcount='$mcount',M_Start='$M_Start' where id=".$crs[0];
		}
		mysql_query($sql) or die ("操作失败!");
	}
	$allcount++;
}
//}

$abcd=explode("parent.msg='",$msg);

$msg_tw=explode("';",$abcd[1]);

$sql = "select msg_update from web_system_data";

$result = mysql_query($sql);

$row = mysql_fetch_array($result);

if ($row['msg_update']==1 and $msg_tw[0]!=''){

	$sql="update web_system_data set msg_system_tw='$msg_tw[0]'";

	mysql_query($sql) or die ("公告更新操作失敗!");		

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

      <input type=button name=button value="繁體 <?=$allcount?>" onClick="window.location.reload()"></td>

  </tr>

</table>

</body>

</html>
