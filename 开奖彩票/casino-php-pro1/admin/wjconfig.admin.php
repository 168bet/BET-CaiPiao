<?php
require_once('wjsqlin.php');
$conf['debug']['level']=5;

/*		数据库配置		*/
$conf['db']['dsn']='mysql:host=localhost;dbname=oassc';
$conf['db']['user']='root';
$conf['db']['password']='root';
$conf['db']['charset']='utf8';
$conf['db']['prename']='ssc_';

$conf['cache']['expire']=0;
$conf['cache']['dir']='_cache/';

$conf['url_modal']=2;

$conf['action']['template']='/admin/';
$conf['action']['modals']='/admin/';

$conf['member']['sessionTime']=15*60;	// 用户有效时长

error_reporting(E_ERROR & ~E_NOTICE);
ini_set('date.timezone', 'asia/shanghai');

ini_set('display_errors', 'Off');
