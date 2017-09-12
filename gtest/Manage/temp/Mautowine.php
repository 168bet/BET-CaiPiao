<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';

	$id=$_POST['zid'];
	$type=$_POST['type'];
	$db=new DB();
	$gwin=$type=='yes'? 1:0;
	$sql = "update g_user set g_autowin=$gwin where g_id='$id'";
	$db->query($sql, 2);
	echo $gwin+"";
?>