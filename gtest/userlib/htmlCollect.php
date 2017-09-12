<?php
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
include_once ROOT_PATH.'function/cheCookie.php';
$gameType=$_GET['gameType'];
//markPos("前台-{$gameType}-us");
$body=file_get_contents($gameType.'.html');
echo $body;

?>