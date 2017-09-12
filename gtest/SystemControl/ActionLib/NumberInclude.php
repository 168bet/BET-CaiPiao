<?php
/*  
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  QQ:503064228
  Author: Version:1.0
  Date:2012-02-18
*/
session_start();
if (isset($_SESSION['GameType']) && $_SESSION['GameType'] == 2){
	header('Location:/SystemControl/ActionLib/openNumbers_cq.php');
} else {
if (isset($_SESSION['GameType']) && $_SESSION['GameType'] == 3){
	header('Location:/SystemControl/ActionLib/openNumbers_gx.php');
}else if (isset($_SESSION['GameType']) && $_SESSION['GameType'] == 4){
	header('Location:/SystemControl/ActionLib/openNumbers_jx.php');
}else if(isset($_SESSION['GameType']) && $_SESSION['GameType'] == 5){
	header('Location:/SystemControl/ActionLib/openNumbers_nc.php');
}
else  if(isset($_SESSION['GameType']) && $_SESSION['GameType'] == 6){
	header('Location:/SystemControl/ActionLib/openNumbers_pk.php');
}else  if(isset($_SESSION['GameType']) && $_SESSION['GameType'] == 7){
	header('Location:/SystemControl/ActionLib/openNumbers_k3.php');
}
else{
	 header('Location:/SystemControl/ActionLib/openNumbers.php');
	 }
}
?>