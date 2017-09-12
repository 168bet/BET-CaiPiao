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
$dateTime = date('Y-m-d H:i:s');
$a = date('Y-m-d ').'23:21:00';
global $stratGamejx, $endGamejx;
if ( ($dateTime < $stratGamejx && $dateTime > $a) || $dateTime > $endGamejx)
{
	header("Location: ./right.php"); exit;
}
?>