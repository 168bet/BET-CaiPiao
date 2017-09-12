<?
require ("config.inc.php");
$uid=$_REQUEST['uid'];
$lv=$_REQUEST["lv"];
$sql = "select Website,Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($url[0],$url[1],$url[2],$url[3]))){
	$data='web_system_data';
}else{
	$data='web_agents_data';
}
$mysql = "select * from $data where Oid='$uid'";
$result = mysql_db_query($dbname,$mysql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('/','_top')</script>";
	exit;
}
$langx=$row['Language'];
require ("traditional.$langx.inc.php");
$onlinetime=date("Y-m-d H:i:s");
$logouttime=date('Y-m-d H:i:s',time()-60*60);
$onlinetimes=strtotime(date("Y-m-d H:i:s"));
$time=strtotime($row['OnlineTime']);
$datetime=$onlinetimes-$time;
if($datetime<3600){
   $sql = "update $data set Online=1,OnlineTime='$onlinetime' where Oid='$uid'";
   mysql_db_query($dbname,$sql) or die ("error!");
}else{
   $sql = "update $data set Oid='logout',Online=0,LogoutTime='$onlinetime' where OnlineTime<'$logouttime'";
   mysql_db_query($dbname,$sql) or die ("error!!");
   echo "<Script language=javascript>alert('您的帐号已经在线一小时无任何操作~~请回首页重新登入!');window.open('/','_top')</script>";
}
?>