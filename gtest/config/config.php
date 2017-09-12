<?php
/* 
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  作者QQ:503064228
  Author: Version:1.0
  Date:2011-12-07 09:28:32
*/
include_once ROOT_PATH.'class/DB.php';

//前臺域名
$Home[0] = '127.0.0.1';
$Home[1] = 'shengshi999.com';
$Home[2] = '';
$Home[3] = '';
$Home[4] = '';
$Home[5] = '';
$Home[6] = '';
$Home[7] = '';
$Home[8] = '';
$Home[9] = '';

//前臺端口
$Port[0] = '81';
$Port[1] = '80';
$Port[2] = '5566';
$Port[3] = '5566';
$Port[4] = '5566';
$Port[5] = '';
$Port[6] = '';
$Port[7] = '';
$Port[8] = '';
$Port[9] = '';


//代理域名
$dHome[0] = '103.208.33.118';
$dHome[1] = '';
$dHome[2] = '';
$dHome[3] = '';
$dHome[4] = '';
$dHome[5] = '';
$dHome[6] = '';
$dHome[7] = '';
$dHome[8] = '';
$dHome[9] = '';

//代理端口
$dPort[0] = '82';
$dPort[1] = '';
$dPort[2] = '';
$dPort[3] = '';
$dPort[4] = '';
$dPort[5] = '';
$dPort[6] = '';
$dPort[7] = '';
$dPort[8] = '';
$dPort[9] = '';


//导航域名
$hHome[0] = '103.208.33.118';
$hHome[1] = '';
$hHome[2] = '';
$hHome[3] = '';
$hHome[4] = '';
$hHome[5] = '';
$hHome[6] = '';
$hHome[7] = '';
$hHome[8] = '';
$hHome[9] = '';

//导航端口
$hPort[0] = '80';
$hPort[1] = '';
$hPort[2] = '';
$hPort[3] = '';
$hPort[4] = '';
$hPort[5] = '';
$hPort[6] = '';
$hPort[7] = '';
$hPort[8] = '';
$hPort[9] = '';


//後臺域名
$sHome[0] = '127.0.0.1';
$sHome[1] = 'shengshi999_ht.com';
$sHome[2] = '';
$sHome[3] = '';
$sHome[4] = '';
$sHome[5] = '';
$sHome[6] = '';
$sHome[7] = '';
$sHome[8] = '';
$sHome[9] = '';

//後臺端口
$sPort[0] = '80';
$sPort[1] = '80';
$sPort[2] = '5566';
$sPort[3] = '5566';
$sPort[4] = '';
$sPort[5] = '';
$sPort[6] = '';
$sPort[7] = '';
$sPort[8] = '';
$sPort[9] = '';




$db=new DB();
$resultTime = $db->query('select g_open_time_gd,g_open_time_gx,g_open_time_cq,g_open_time_pk,g_open_time_jx,g_open_time_nc,g_open_time_k3 from g_config limit 1',1);


//每天盤口開啟時間
$stratGame = date('Y-m-d').' '.$resultTime[0]['g_open_time_gd'];

//每天盤口關閉時間
$endGame = date('Y-m-d').' 22:30:00';


//每天盤口開啟時間
$stratGamegx = date('Y-m-d').' '.$resultTime[0]['g_open_time_gx'];

//每天盤口關閉時間
$endGamegx = date('Y-m-d').' 21:25:00';


//每天盤口開啟時間
$stratGamecq = date('Y-m-d').' '.$resultTime[0]['g_open_time_cq'];

//每天盤口關閉時間
$endGamecq = date( "Y-m-d ", mktime(0, 0, 0, date('m'), date('d')+1, date('Y'))).' 01:55';

//每天盤口開啟時間
$stratGamejx = date('Y-m-d').' '.$resultTime[0]['g_open_time_jx'];

//每天盤口關閉時間
$endGamejx = date('Y-m-d').' 23:00:00';


//每天盤口開啟時間
$stratGamenc = date('Y-m-d').' '.$resultTime[0]['g_open_time_nc'];

//每天盤口關閉時間
$endGamenc = date( "Y-m-d ", mktime(0, 0, 0, date('m'), date('d')+1, date('Y'))).' 01:58';


//每天盤口開啟時間
$stratGamepk = date('Y-m-d').' '.$resultTime[0]['g_open_time_pk'];

//每天盤口關閉時間
$endGamepk = date('Y-m-d').' 23:57:00';

//每天盤口開啟時間
$stratGamek3 = date('Y-m-d').' '.$resultTime[0]['g_open_time_k3'];

//每天盤口關閉時間
$endGamek3 = date('Y-m-d').' 22:10:00';

$oncontextmenu = 'oncontextmenu="return false"';




?>