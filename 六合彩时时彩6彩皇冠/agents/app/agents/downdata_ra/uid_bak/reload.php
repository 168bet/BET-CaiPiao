<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>UID接收</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<?
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$mysql = "select * from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);

$site=$row['datasite'];
$name=$row['Name'];
$passwd=$row['Passwd'];
$name_tw=$row['Name_tw'];
$passwd_tw=$row['Passwd_tw'];
$name_en=$row['Name_en'];
$passwd_en=$row['Passwd_en'];


$curl = &new Curl_HTTP_Client();
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."");
$html_date=$curl->fetch_url("".$site."/app/member/","",10);
if(!$html_date){
	echo $curl->error_msg;
	exit;
}else{
	preg_match('/name="uid" value="(.*?)">/si',$html_date,$homeUID);
	$tempUID=$homeUID[1];
}
if(!empty($tempUID)){
	$login=array();
	$login['username']=$name;
	$login['passwd']=$passwd;
	$login['langx']="zh-cn";
	$login['uid']=$tempUID;
	$html_date=$curl->send_post_data("".$site."/app/member/login.php",$login,"",10);
	if(!$html_date){
		echo $curl->error_msg;
		exit;
	}else {
		preg_match('/uid=([^;]+)&/si',$html_date,$uid);
		if($uid[1]){
			$uid=$uid[1];
			$mysql="update web_system_data set Uid='$uid'";
			mysql_query($mysql);
			echo '成功获取简体的uid: '.$uid.'<br>';
		}else {
			preg_match('/alert\(\'(.*?)\'\)/',$html_date);
			echo "简体登陆错误!\\请检查简体用户名和密码!!<br>";	
		}
	}
}

$curl = &new Curl_HTTP_Client();
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."");
$html_date=$curl->fetch_url("".$site."/app/member/","",10);
if(!$html_date){
	echo $curl->error_msg;
	exit;
}else{
	preg_match('/name="uid" value="(.*?)">/si',$html_date,$homeUID);
	$tempUID=$homeUID[1];
}
if(!empty($tempUID)){
	$login=array();
	$login['username']=$name_tw;
	$login['passwd']=$passwd_tw;
	$login['langx']="zh-tw";
	$login['uid']=$tempUID;
	$html_date=$curl->send_post_data("".$site."/app/member/login.php",$login,"",10);
	if(!$html_date){
		echo $curl->error_msg;
		exit;
	}else {
		preg_match('/uid=([^;]+)&/si',$html_date,$uid);
		if($uid[1]){
			$uid=$uid[1];
			$mysql="update web_system_data set Uid_tw='$uid'";
			mysql_query($mysql);
			echo '成功獲取繁體的uid: '.$uid.'<br>';
		}else {
			preg_match('/alert\(\'(.*?)\'\)/',$html_date);
			echo "繁體登陸錯誤!\\請檢查繁體用戶名和密碼!!<br>";	
		}
	}
}

$curl = &new Curl_HTTP_Client();
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."");
$html_date=$curl->fetch_url("".$site."/app/member/","",10);
if(!$html_date){
	echo $curl->error_msg;
	exit;
}else{
	preg_match('/name="uid" value="(.*?)">/si',$html_date,$homeUID);
	$tempUID=$homeUID[1];
}
if(!empty($tempUID)){
	$login=array();
	$login['username']=$name_en;
	$login['passwd']=$passwd_en;
	$login['langx']="en-us";
	$login['uid']=$tempUID;
	$html_date=$curl->send_post_data("".$site."/app/member/login.php",$login,"",10);
	if(!$html_date){
		echo $curl->error_msg;
		exit;
	}else {
		preg_match('/uid=([^;]+)&/si',$html_date,$uid);
		if($uid[1]){
			$uid=$uid[1];
			$mysql="update web_system_data set Uid_en='$uid'";
			mysql_query($mysql);
			echo '成功获取英文的uid: '.$uid.'<br>';
		}else {
			preg_match('/alert\(\'(.*?)\'\)/',$html_date);
			echo "英文登陆错误!\\请检查简体用户名和密码!!<br>";	
		}
	}
}

?>
<body bgcolor="#AACCCC" onLoad="TimeClose();">
<!--<script language="javascript">
var cTime=20;//这个变量是倒计时的秒数设置为10就是10秒
function TimeClose()
{
     window.setTimeout('TimeClose()',1000);//让程序每秒重复执行当前函数。
     if(cTime<=0)//判断秒数如果为0
       CloseWindow_Click();//执行关闭网页的操作
     this.ShowTime.innerHTML="倒计时"+cTime+"秒后关闭当前窗口";//显示倒计时时间
     cTime--;//减少秒数
}
function CloseWindow_Click()
{
     window.open('','_parent','');//关闭当前窗口
     window.close();
}
</script>-->
<script> 
<!-- 
var limit="600" 
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
		curtime=curmin+"秒后自动获取UID!" 
	else 
		curtime=cursec+"秒后自动获取UID!" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 

window.onload=beginrefresh 
file://--> 
</script>
<table width="150" height="100" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="150" height="100" align="center">
      <span id="ShowTime"></span><br><br>
      <input type=button name=button value="重新登陆" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>
