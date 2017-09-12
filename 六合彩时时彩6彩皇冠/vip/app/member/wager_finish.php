<?
//--------------no cache------------------------------------------------------------------------------------
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
    header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
    header ("Pragma: no-cache");                          // HTTP/1.0
//------------------------------------------------------------------------------------------------------------    



include "./include/address.mem.php";
require ("./include/config.inc.php");

$titleStr=$_REQUEST['titleStr'];
$styleID=$_REQUEST['styleID'];
$msgStr=urldecode($_REQUEST['msgStr']);
$langx=$_REQUEST['str_meta'];
$ls=$_REQUEST['LS'];

include("include/traditional.$langx.inc.php");
switch($langx){
case 'zh-tw':
	$meta='big5';
	break;
case 'zh-cn':
	$meta='gb2312';
	break;
}
if($styleID=='BLUE'){
	$msgtext=$bet_close.rand(0,100);
	$title="Attention";
}else{
	$msgtext=$OrderSucc;
	$title=substr($order_voucher,0,8);
}
?>
<html>
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order.css" type="text/css">
</head>

<body id="<?=$styleID?>">
<div>
	<p><?=$msgtext?></p>
	<p><input type=button name="check" value=" <?=$Confirm?> " onClick="window.close();" height="20" class="yes"></p>
</div>

</body>
</html>