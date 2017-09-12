<?php
/*  
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  QQ:503064228
  Author: Version:1.0
  Date:2011-12-18
*/


define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';

	$id=$_POST['gid'];
	$name=$_POST['name'];
	$cao=$_POST['cao'];
	$db=new DB();

	if($cao==1){
	$sql = "update g_qdetail set g_state='取款已支付' where g_id='$id'";
	$db->query($sql, 2);
	
	$sql = "select * from g_qdetail where g_id='$id'";
	$result=$db->query($sql, 1);
	
	$sql = "update g_user set g_dmoney=g_dmoney-{$result[0]['g_money']} where g_name='{$name}'";
	$db->query($sql, 2);
	echo 1;
	}else{
	$sql = "update g_qdetail set g_state='取款已拒绝' where g_id='$id'";
	$db->query($sql, 2);
	
	$sql = "select * from g_qdetail where g_id='$id'";
	$result=$db->query($sql, 1);
	
	$sql = "update g_user set g_dmoney=g_dmoney-{$result[0]['g_money']},g_money_yes=g_money_yes+{$result[0]['g_money']} where g_name='{$name}'";
	$db->query($sql, 2);
	echo 2;
	}
	
?>