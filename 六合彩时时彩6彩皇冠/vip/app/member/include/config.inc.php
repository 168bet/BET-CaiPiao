<?
//if ( function_exists("date_default_timezone_set"))date_default_timezone_set ("Etc/GMT+4");
$dbhost                                = "localhost";                 // 数据库主机名
$dbuser                                = "root";                 // 数据库用户名
$dbpass                                = "123456";                         // 数据库密码
$dbname                                = "rawvip";                 // 数据库名
mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname);
mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 
$str="and|select|update|from|where|order|by|*|delete|'|insert|into|values|create|table|database";  //非法字符 
$arr=explode("|",$str);//数组非法字符，变单个 

foreach ($_REQUEST as $key=>$value){
	for($i=0;$i<sizeof($arr);$i++){
		if (substr_count(strtolower($_REQUEST[$key]),$arr[$i])>0){       //检验传递数据是否包含非法字符 
		    /*echo "<script>window.open('/','_top')</script>";
            //exit; //退出不再执行后面的代码*/
		}
	} 
}


$sql = "select Msg_System,Msg_System_tw,Msg_System_en,Replace_From,Replace_To from web_system_data where ID=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$msg_member=$row['Msg_System'];
$msg_member_tw=$row['Msg_System'];
$msg_member_en=$row['Msg_System_en'];
//112.78.104.13 / hg0088.com / hg1088.com
$arr1=explode(chr(13),trim($row['Replace_From']));
$arr2=explode(chr(13),trim($row['Replace_To']));
//print_r($arr2);
//print_r($arr1);
//$msg_member_tw=str_replace(array("112.78.104.13 /","hg0088.com","hg1088.com"),array(""," ylg111.com "," ylg222.com "),$msg_member_tw);
for($i=0;$i<=count($arr1);$i++){
	$msg_member_tw=str_replace(trim($arr1[$i]),trim($arr2[$i]),$msg_member_tw);
}
//$msg_member_tw=str_replace($arr1,$arr2,$msg_member_tw);
//echo $msg_member_tw;exit;
$sql="select id,UserName from web_member_data where Oid='".$_REQUEST['uid']."'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou>0){
	$userid=intval($row['id']);
}else{
	$userid=0;
}
//print_r($_SESSION);exit;

$_SESSION['langx']="zh-cn";
?>
