<?php
if(!defined('PHPYOU')) {
	exit('Access Denied');
}

$usernn=$_SESSION['jxadmin666'];
unset($_SESSION['jxadmin666']);
unset($_SESSION['flag']);
mysql_query( "delete from tj where username='".$usernn."' ", $conn );
echo "<meta http-equiv=refresh content=\"0;URL=index.php\">";exit;
?>
