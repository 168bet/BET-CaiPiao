<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");   
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "./include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
$str = time();
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
require ("./include/traditional.$langx.inc.php");
require ("./include/config.inc.php");

$sql = "select UserName,Admin from web_member_data where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$username=$row['UserName'];
$admin=$row['Admin'];
$cou=mysql_num_rows($result);
if($cou==0){
	setcookie('login_uid','');
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Welcome</title>
<link href="/style/member/mem_index_data.css" rel="stylesheet" type="text/css">
</head>
<SCRIPT language="JavaScript" src="/js/top.js"></SCRIPT>
<body id="RCHK">

<div id="container">
  <div id="header"><h1><span></span></h1></div>
  
  <div id="info">
  
    <?=$rule?>
	<div class="chk">
	  <form action="logout.php" method="get" name="myForm">
        <input type="hidden" name="uid" value="<?=$uid?>">
        <input type="hidden" name="langx" value="<?=$langx?>">
        <input name="submit" type="submit" style="width:80px" value="<?=$rule8?>">
      </form>
	  <form action="./FT_index.php" method="get" name="myForm">
        <input type="hidden" name="uid" value="<?=$uid?>">
        <input type="hidden" name="langx" value="<?=$langx?>">
        <input type="hidden" name="mtype" value="3">
        <input name="submit2" type="submit" style="width:80px" value="<?=$rule9?>">
      </form>
	</div>
    <br class="clear" />
    </div><!-- rule end -->
  </div>
  <!-- info end -->

</div>
<?=$rule_bottom?>
</body>
</html>
<?
$sql = "select message,message_tw from web_message_data where UserName='".$username."' ";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
$sql="select msg_member_alert,msg_member,msg_member_tw,msg_member_en from web_system_data where Admin='".$admin."' ";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
switch($langx){
case 'zh-tw':
	$talert=$row['msg_member_tw'];
	break;
case 'zh-cn':
	$talert=$row['msg_member'];
	break;
case 'en-us':
	$talert=$row['msg_member_en'];
	break;
case 'th-tis':
	$talert=$row['msg_member_tw'];
	break;
}

if ($row['msg_member_alert']==1 and $talert<>''){
	
	echo "<script>alert('$talert');</script>";
}
}else{
	switch($langx){
	case 'zh-tw':
		$talert=$row['message_tw'];
		break;
	case 'zh-cn':
		$talert=$row['message'];
		break;
	case 'en_us':
		$talert=$row['message_en'];
		break;
	case 'th-tis':
		$talert=$row['message_tw'];
		break;
	}
	if ($talert<>''){
	
		echo "<script>alert('$talert');</script>";
	}
	
}
}
mysql_close();
?>
