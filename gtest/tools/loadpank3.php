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
$ConfigModel = configModel("
`g_out_time`,
`g_automatic_open_number_lock`,
`g_up_odds_mix`,
`g_odds_execution_lock`,
`g_odds_num`,
`g_odds_str`,
`g_automatic_money_lock`,
`g_insert_number_day`,
`g_close_time`");

if ($_SERVER["SERVER_NAME"] != '127.0.0.1') exit;

InsertNumberk3();

?>