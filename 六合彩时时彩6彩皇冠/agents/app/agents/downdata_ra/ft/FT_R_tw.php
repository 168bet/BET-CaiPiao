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

$curl->set_referrer("".$site."/app/member/FT_browse/index.php?rtype=r&uid=$uid&langx=zh-tw&mtype=3");

$allcount=0;

for($page_no=0;$page_no<10;$page_no++){

$html_data=$curl->fetch_url("".$site."/app/member/FT_browse/body_var.php?rtype=r&uid=$uid&langx=zh-tw&mtype=3&page_no=$page_no");

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

	if (!empty($datainfo)){

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

	}else{

		$m_Type=0;

	}

	$checksql = "select MID from match_sports where `MID` ='$datainfo[0]' and M_Date='$m_date'";

	$checkresult = mysql_query($checksql);	

	$check=mysql_num_rows($checkresult);

	if($check==0){

		$sql = "INSERT INTO match_sports(MID,Type,M_Start,M_Date,M_Time,MB_Team_tw,TG_Team_tw,M_League_tw,MB_MID,TG_MID,M_Type,S_Show)VALUES('$datainfo[0]','FT','$timestamp','$m_Date','$m_Time','$datainfo[5]','$datainfo[6]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$m_Type','1')";

		mysql_query($sql) or die ("操作失败!");

	}else{

		$sql = "update match_sports set Type='FT',MB_Team_tw='$datainfo[5]',TG_Team_tw='$datainfo[6]',M_Start='$timestamp',M_Date='$m_Date',M_Time='$m_Time',M_League_tw='$datainfo[2]',MB_MID='$datainfo[3]',TG_MID='$datainfo[4]',ShowTypeR='$datainfo[7]',M_LetB='$datainfo[8]',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',MB_Dime='$datainfo[11]',TG_Dime='$datainfo[12]',TG_Dime_Rate='$datainfo[13]',MB_Dime_Rate='$datainfo[14]',MB_Win_Rate='$datainfo[15]',TG_Win_Rate='$datainfo[16]',M_Flat_Rate='$datainfo[17]',S_Single_Rate='$datainfo[20]',S_Double_Rate='$datainfo[21]',ShowTypeHR='$datainfo[23]',M_LetB_H='$datainfo[24]',MB_LetB_Rate_H='$datainfo[25]',TG_LetB_Rate_H='$datainfo[26]',MB_Dime_H='$datainfo[27]',TG_Dime_H='$datainfo[28]',MB_Dime_Rate_H='$datainfo[30]',TG_Dime_Rate_H='$datainfo[29]',MB_Win_Rate_H='$datainfo[31]',TG_Win_Rate_H='$datainfo[32]',M_Flat_Rate_H='$datainfo[33]',Eventid='$datainfo[35]',Hot='$datainfo[36]',Play='$datainfo[37]',S_Show=1,M_Type='$m_Type' where MID=$datainfo[0]";	

		//echo $sql."<br>";

        mysql_query($sql) or die ("操作失敗!!");

    }

	    $allcount++;

	}else{

		continue;

	}

}

}

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
