<?php
$dbhost                                = "127.0.0.1";                 // 数据库主机名
$dbuser                                = "root";                 // 数据库用户名
$dbpass                                = "soul838866";                         // 数据库密码
$dbname                                = "rawvip";                 // 数据库名
mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname);
mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 
$str="!and|update|from|where|order|by|*|delete|'|insert|into|values|create|table|database";  //非法字符 
$arr=explode("|",$str);//数组非法字符，变单个 
foreach ($_REQUEST as $key=>$value){
	for($i=0;$i<sizeof($arr);$i++){
		if (substr_count(strtolower($_REQUEST[$key]),$arr[$i])>0){       //检验传递数据是否包含非法字符 
		    echo "Illegal Character ".$arr[$i];
            exit;
		}
	} 
} 
$sql = "select * from web_marquee_data order by ID desc limit 0,1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$msg_member=$row['Message'];
$msg_member_tw=$row['Message_tw'];
$msg_member_en=$row['Message_en'];
$define_data='lovemyself';
?>
