<?php
require_once('sqlin.php');
$conf['debug']['level']=5;

/*		���ݿ�����		*/
$conf['db']['dsn']='mysql:host=localhost;dbname=xy_yule';
$conf['db']['user']='root';
$conf['db']['password']='root';
$conf['db']['charset']='utf8';
$conf['db']['prename']='xy_';

$conf['safepass']='qq3301666096';     //��̨��½��ȫ��

$conf['cache']['expire']=0;
$conf['cache']['dir']='_cache/';     //ǰ̨����Ŀ¼
$conf['url_modal']=2;
$conf['action']['template']='wjinc/admin/';
$conf['action']['modals']='wjaction/admin/';
$conf['member']['sessionTime']=15*60;	// �û���Чʱ��
$conf['node']['access']='http://localhost:65531';	// node���ʻ���·��

error_reporting(E_ERROR & ~E_NOTICE);
ini_set('date.timezone', 'asia/shanghai');
ini_set('display_errors', 'Off');