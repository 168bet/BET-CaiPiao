<?php
if(!defined('PHPYOU')) {
	exit('Access Denied');
}

$usernn=$_SESSION['username'];
unset($_SESSION['username']);

mysql_query( "delete from tj where username='".$usernn."' ", $conn );
echo "<meta http-equiv=refresh content=\"0;URL=index.php\">";exit;
?>