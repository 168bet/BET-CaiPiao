<?php

/*
 * @Description 易宝支付产品通用接口范例 
 * @V3.0
 * @Author rui.xin
 */

#	商户编号p1_MerId,以及密钥merchantKey 需要从易宝支付平台获得
require ("../include/config.inc.php");
$paysql = "select `Business`,`Keys` from web_payment_data where Switch=1 and pdomain=1";
$payresult = mysql_db_query($dbname,$paysql);
$payrow=mysql_fetch_array($payresult);
$business=$payrow['Business'];
$keys=$payrow['Keys'];

$p1_MerId	  = "$business";	#商户号
$merchantKey  = "$keys";		#商户密钥
$logName	  = "charge_YeePay_HTML.log";

?> 