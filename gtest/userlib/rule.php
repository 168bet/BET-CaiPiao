<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
include_once ROOT_PATH.'function/cheCookie.php';
if($_SESSION['gameType']!=$_GET['gameType'])
$gameType=$_GET['gameType'];
else
$gameType=$_SESSION['gameType'];
markPos("前台-{$gameType}游戏规则-us");
$body=file_get_contents($gameType.'_rule.html');

echo $body;
?>