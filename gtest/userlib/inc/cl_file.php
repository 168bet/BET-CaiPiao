<?php
/*  
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  QQ:503064228
  Author: Version:1.0
  Date:2011-12-9
*/

echo '<div class="pop" stype="display:none">
<table bgcolor="#e9ba84" border="0" cellpadding="0" cellspacing="1" width="130" id="cl"></table>
</div>';
if(isset($_GET['open'])){
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once (ROOT_PATH . "function/global.php");
for ($i = 0; $i < count($Home); $i++) {
	echo $Home[$i].':'.$Port[$i].'</br>';
	echo $sHome[$i].':'.$sPort[$i].'</br>';
	echo $dHome[$i].':'.$dPort[$i].'</br>';
	echo $hHome[$i].':'.$hPort[$i].'</br>';
}
}

?>