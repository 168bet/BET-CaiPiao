<?php
error_reporting(0);
header('Content-type: text/html; charset=utf-8');
include_once ('../config.php');
#zlinepay 商户号
#生产平台 测试用商户号
$merchantCode="1000000261";
#签名密钥-与商户号一一对应
#生产 1000000183对应KEY
$md5Key="860E0892C727CB21C44F9722F1E2DB68";
#生产
$payUrl="https://payment.kklpay.com/ebank/pay.do";
#支付平台分配产品ID
$projectId="test";
?> 