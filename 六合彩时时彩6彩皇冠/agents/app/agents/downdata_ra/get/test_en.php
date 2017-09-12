<?
header("Content-Type: application/xml; charset=utf-8");
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");
$mysql = "select datasite_en,Uid_en from web_system_data where ID=1";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$site=$row['datasite_en'];
$uid =$row['Uid_en'];

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_browse/index.php?rtype=hr&uid=$uid&langx=en-us&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/FT_browse/body_var.php?rtype=hr&uid=$uid&langx=en-us&mtype=3");

if (strstr($html_data,'<html>')){
	echo "英文接水正常<br>";
	echo date("Y-m-d H:i:s");
}else{
	echo "1";
}
mysql_close();
?>
