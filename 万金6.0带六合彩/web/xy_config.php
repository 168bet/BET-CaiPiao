<?php
require_once('xy_sqlin.php');
$conf['debug']['level']=5;
$conf['db']['dsn']='mysql:host=localhost;dbname=xy_yule';
$hostname='localhost';    //第三方支付引用
$dbname='xy_yule'; 
$username='wanjinyule';
$password='jo21jfoejfo23j2'; //第三方支付引用

$conf['db']['user']='root';
$conf['db']['password']='root';
$conf['db']['charset']='utf8';
$conf['db']['prename']='xy_';
$conf['cache']['expire']=0;
$conf['cache']['dir']='_cache/';
$conf['url_modal']=2;
$conf['action']['template']='xy_inc/xy_default/';
$conf['action']['modals']='xy_action/xy_default/';
$conf['member']['sessionTime']=15*60;	// 用户有效时长
error_reporting(E_ERROR & ~E_NOTICE);
ini_set('date.timezone', 'asia/shanghai');
ini_set('display_errors', 'Off');
if(strtotime(date('Y-m-d H:i:s',time()))>strtotime(date('Y-m-d',time()).' 03:00:00')){
	
	$GLOBALS['fromTime']=strtotime(date('Y-m-d').' 03:00:00');
	$GLOBALS['toTime']=strtotime(date('Y-m-d',strtotime("+1 day")).' 03:00:00');
}else{
	$GLOBALS['fromTime']=strtotime(date('Y-m-d',strtotime("-1 day")).' 03:00:00');
	$GLOBALS['toTime']=strtotime(date('Y-m-d',time()).' 03:00:00');
}
?>