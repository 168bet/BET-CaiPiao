<?php
require_once("../../../include/conn_ft.php");
mysql_select_db($dbname);
$url=base64_decode($_REQUEST['url']);
$updateSQL="update web_system set datasite='$url'";
mysql_query($updateSQL);
header("location:http://lotus1.kk9000.com/admin/user_manager/url_test/test_url.php");
?>