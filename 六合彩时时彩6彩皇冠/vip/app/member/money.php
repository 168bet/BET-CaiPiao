<?php
header("Content-type: text/html; charset=utf-8");
require ("include/config.inc.php");
$uid   = $_REQUEST['uid'];
$sql = "select * from web_member_data where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
	$memname=$row['UserName'];
	$langx=$row['Language'];
	$logindate=date("Y-m-d");
	if ($row['LoginDate']!=$logindate and $row['Pay_Type']==0){
		$credit=$row['Credit'];
		$sql="update web_member_data set LoginDate='$date',Money='$credit' where UserName='$memname' and Pay_Type=0";
		mysql_query($sql) or die ("error!");
	}else{
		$credit=$row['Money'];
	}
echo $credit;
 ?>