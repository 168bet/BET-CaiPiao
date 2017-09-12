<?
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
$chargelogin=$_REQUEST['loginname'];
if ($chargelogin==""){
?>
<html>
<head>
<title>账户输入</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bgcolor="D59E02">
<form name="checkurl" action="" method="post">
<div align="center">
<!--------------------------------->
<div style="padding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;">
<image style="border:0px;padding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px" src="./images/bg_03.gif"></image></div><!--------------------------------->
<div style="width:962px;height:53px;float:center;"><div style="width:338px;height:53px;float:left;"><image style="border:0px;padding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;" src="./images/bg_05.gif"></image></div><div style="width:292px;height:53px;vertical-align:bottom;float:left;background-image:url(./images/bg_06.gif);"><span>用户名:&nbsp;<input name="loginname" type="text" size="20"></input></span>&nbsp;<button onclick="submit();" style="height:24px;width:54px;padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;"><image style="border:0px;padding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;" src="./images/go.jpg" ></image></button></div><div style="width:332px;height:53px;float:left;"><image style="width:332px;border:0px;align:center;padding:0px 0px 0px 0px;margin: 0px 0px 0px 0px" src="./images/bg_07.gif"></image></div>
</div>
<!--------------------------------->
<div>
<image style="border:0px;padding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px" src="./images/bg_08.gif"></image>
</div>
<!--------------------------------->
</div>
</form>
</body>
</html>
<?php
}else{

$lastdot=strripos($_SERVER['SERVER_NAME'],".");
$url_host=substr($_SERVER['SERVER_NAME'],0,$lastdot);
$lastdot=strripos($url_host,".");
$url_host_r = substr($_SERVER['SERVER_NAME'],($lastdot+1));
$url_master="http://".$url_host_r."/app/member/money/charge.php?loginname=".$chargelogin;
?>
<html>
<head>
<title>充值</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body >
<iframe id="charge" name="charge" frameborder="0" scrolling="no" width="100%" height="100%" src="<?=$url_master?>"></iframe>
</body>
</html>
<?php
}
?>