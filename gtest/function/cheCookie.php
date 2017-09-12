<?php
/*  
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  作者QQ:503064228
  Author: Version:1.0
  Date:2011-12-13
*/
if (!defined('Copyright') && Copyright != '作者QQ:503064228')
exit('作者QQ:503064228');
if (!defined('ROOT_PATH'))
exit('invalid request');
include_once ROOT_PATH.'function/global.php';
include_once ROOT_PATH.'class/check.class.php';
global $Home,$Port;
$ConfigModel = configModel("`g_web_lock`");
if ($ConfigModel['g_web_lock'] != 1) 
{
	href("/");
	exit;
}
$home = $_SERVER["SERVER_NAME"];
$port = $_SERVER["SERVER_PORT"];
$lock = false;
for ($i=0; $i<count($Home); $i++)
{
	if ($home == $Home[$i] && $port == $Port[$i])
	{
		$lock = true;
		break;
	}
}
if ($lock == false)
{
	href("/");
	exit;
}

if (!isset($_COOKIE['g_user']) || !isset($_COOKIE['g_uid'])) 
{
	href("/");
	exit;
} 
else 
{
	//$name = base64_decode($_COOKIE['g_user']);
	//$uid = base64_decode($_COOKIE['g_uid']);
	$name = checkStr(base64_decode($_COOKIE['g_user']))?checkStr(base64_decode($_COOKIE['g_user'])):href_parent_ext("/");
	$uid = checkStr(base64_decode($_COOKIE['g_uid']))?checkStr(base64_decode($_COOKIE['g_uid'])):href_parent_ext("/");
	$db = new DB();
	$sql = "SELECT `g_nid`, `g_login_id`, `g_name`, `g_f_name`, `g_mumber_type`, `g_password`, `g_money`, `g_money_yes`, `g_distribution`, `g_panlu`,`g_panlus`, `g_xianer`, `g_out`, `g_count_time`, `g_look`, `g_ip`, `g_date`, `g_uid`, `g_xianhong` FROM `g_user` WHERE `g_name` = '{$name}' AND `g_uid` = '{$uid}' LIMIT 1 ";
	$user = $db->query($sql, 1);
	if (!$user)
		exit(href("/"));
	if ($user[0]['g_look'] == 3)
		exit(alert_href($UserLook,'/'));
	if ($user[0]['g_out'] == 0)
	{
		href_parent("/");
		exit;
	}
	else 
	{
		$sql = "UPDATE `g_user` SET `g_count_time`=now() WHERE `g_name`='{$name}' LIMIT 1 ";
		$db->query($sql, 2);
		if($name=='1234536'){
		alert('ddd');
		}
		$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$sql = "UPDATE `g_user` SET `g_url`='{$url}' WHERE `g_name`='{$name}' LIMIT 1 ";
		$db->query($sql, 2);
	}
}




?>