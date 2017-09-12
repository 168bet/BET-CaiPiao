<?
include ("address.mem.php");
require ("config.inc.php");
$uid=$_REQUEST['uid'];
$mysql = "select * from web_member_data where oid='$uid'";
$result = mysql_db_query($dbname,$mysql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	setcookie('login_uid','');
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$langx=$row['Language'];
require ("traditional.$langx.inc.php");
$onlinetime=date("Y-m-d H:i:s");
$logouttime=date('Y-m-d H:i:s',time()-60*60);
$onlinetimes=strtotime(date("Y-m-d H:i:s"));
$time=strtotime($row['OnlineTime']);
$datetime=$onlinetimes-$time;

$sql = "update web_member_data set Online=1,OnlineTime='$onlinetime' where Oid='$uid'";
mysql_db_query($dbname,$sql) or die ("error!");
$sql = "update web_member_data set Oid='logout',Online=0,LogoutTime='$onlinetime' where OnlineTime<'$logouttime'";
mysql_db_query($dbname,$sql) or die ("error!!");

if($datetime>3600){   
   echo "<Script language=javascript>alert('您的帐号已经在线一小时无任何操作~~请回首页重新登入!');window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
}
?>