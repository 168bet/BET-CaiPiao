<?php
error_reporting(0);
header("content-type:text/html;charset=utf-8");
include_once('../config.php');
$key = "be784699220642b8b47f5943932834da";
$parter = "1207";
$gatewayurl = 'http://gatessc.jixunpay.net/chargebank.aspx';
function writeLog($str){
	$fp = fopen("log.txt","a");
	flock($fp, LOCK_EX);
	fwrite($fp,$str ." Time: ".date("Y-m-d h:i:s")."\r\n==============================\r\n");
	flock($fp, LOCK_UN); 
	fclose($fp);	
}
?>