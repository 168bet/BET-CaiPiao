<?php

/*
 * @Description �ױ�֧����Ʒͨ�ýӿڷ��� 
 * @V3.0
 * @Author rui.xin
 */

#	�̻����p1_MerId,�Լ���ԿmerchantKey ��Ҫ���ױ�֧��ƽ̨���
require ("../include/config.inc.php");
$paysql = "select `Business`,`Keys` from web_payment_data where Switch=1 and pdomain=1";
$payresult = mysql_db_query($dbname,$paysql);
$payrow=mysql_fetch_array($payresult);
$business=$payrow['Business'];
$keys=$payrow['Keys'];

$p1_MerId	  = "$business";	#�̻���
$merchantKey  = "$keys";		#�̻���Կ
$logName	  = "charge_YeePay_HTML.log";

?> 