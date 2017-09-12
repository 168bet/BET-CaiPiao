<?php

//error_reporting(0);

error_reporting(E_ALL ^ E_NOTICE);



@set_magic_quotes_runtime(0);



@header("content-Type: text/html; charset=gbk");



define('PHPYOU_VER', 'v1.1');

define('PHPYOU',__FILE__ ? getdirname(__FILE__).'/' : './');



function pr($a) {

	echo '<pre style=\'text-align:left\'>';

	print_r($a);

	echo '</pre>';

}



//北京时间

if(function_exists('date_default_timezone_set')) {

	@date_default_timezone_set('Etc/GMT-8');

}

$timestamp = time();



unset($_ENV,$HTTP_ENV_VARS,$_REQUEST,$HTTP_POST_VARS,$HTTP_GET_VARS,$HTTP_POST_FILES,$HTTP_COOKIE_VARS);

if(!get_magic_quotes_gpc()){

	Add_S($_POST);

	Add_S($_GET);

	Add_S($_COOKIE);

}

Add_S($_FILES);



// 允许程序在 register_globals = off 的环境下工作

if (!ini_get("register_globals")) {

    extract($_GET,EXTR_SKIP);

    extract($_POST,EXTR_SKIP);

}







//rewrite支持检查

$rewrite_enable = $_FCACHE['settings']['ifrewrite'];

if($rewrite_enable){

    if (function_exists('apache_get_modules')) {

	    $apache_mod = apache_get_modules();

	    if (!in_array('mod_rewrite',$apache_mod)) {

		    $rewrite_enable = 0;

	    }

    }

}



session_start();

//登陆验证，后台使用

$admin_info = '';

if ($_SESSION['jxadmin666'] && $_SESSION['flag']) {

	if($_SESSION['jxadmin666']){

	    $admin_info = 1;

	}

}





//登陆验证，代理使用

$admin_info1 = '';

if ($_SESSION['kauser'] && $_SESSION['lx']) {

	if($_SESSION['kauser']){

	    $admin_info1 = 1;

	}

}





//登陆验证，前台使用

$admin_info2 = '';

if ($_SESSION['username']) {

	if($_SESSION['username']){

	    $admin_info2 = 1;

	}

}







//连接数据库



if ( function_exists( "date_default_timezone_set" ) )

{

		date_default_timezone_set( "Asia/Shanghai" );

}





$conn = mysql_pconnect( "localhost", "root", "123456" );
//mysql_pconnect

//mysql_connect

mysql_select_db( "rawvip" );

mysql_query( "SET NAMES 'GBK'" );



//获取系统目录

function getdirname($path){

	if(strpos($path,'\\')!==false){

		return substr($path,0,strrpos($path,'\\'));

	}elseif(strpos($path,'/')!==false){

		return substr($path,0,strrpos($path,'/'));

	}else{

		return '/';

	}

}



//字符转意

function Add_S(&$array){

	foreach($array as $key=>$value){

		if(!is_array($value)){

			$array[$key]=addslashes($value);

		}else{

			Add_S($array[$key]);

		}

	}

}





//提交确认

function SubmitCheck($var = ""){

	//if (empty($_POST[$var]))

	if (empty($_POST)){

		return false;

	}



	if($_SERVER['REQUEST_METHOD'] == 'POST' && (empty($_SERVER['HTTP_REFERER']) ||

			preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST']))){

		return true;

	}

	else{

		return false;

	}

}



$ip=$_SERVER["REMOTE_ADDR"];

$usernamess="游客";

$lxtj=0;



if ($_SESSION['jxadmin666']!=""){$usernamess=$_SESSION['jxadmin666'];

$lxtj=3;}



if ($_SESSION['kauser']!=""){$usernamess=$_SESSION['kauser'];

$lxtj=2;}

if ($_SESSION['username']!=""){$usernamess=$_SESSION['username'];

$lxtj=1;}

 $text=date("Y-m-d H:i:s");





$ddf=date( "Y-m-d H:i:s",time()-200);

mysql_query( "delete from tj where adddate<'".$ddf."'", $conn );



$result = mysql_query("select count(*) from tj  where    ip='".$ip."' and username='".$usernamess."' order by id desc");

$num = mysql_result($result,"0");

if($num!=0){

 $exe=mysql_query("update tj set adddate='".$text."',zt='".$lxtj."',username='".$usernamess."' where username='".$usernamess."' and ip='".$ip."' ");

}else{

$sql="INSERT INTO  tj set addate='".$text."',adddate='".$text."',username='".$usernamess."',zt='".$lxtj."',ip='".$ip."'";

$exe=mysql_query($sql) or  die("数据库修改出错");

}


$q=1117;  
if ($usernamess!="客户"){

mysql_query( "delete from tj where ip='".$ip."' and zt=0 ", $conn );

}


$str="and|select|update|from|where|order|by|*|delete|'|insert|into|values|create|table|database";  //非法字符 
$arr=explode("|",$str);//数组非法字符，变单个 
foreach ($_REQUEST as $key=>$value){
	for($i=0;$i<sizeof($arr);$i++){
		if (substr_count(strtolower($_REQUEST[$key]),$arr[$i])>0){       //检验传递数据是否包含非法字符 
		    echo "<script>window.open('/','_top')</script>";
            exit; //退出不再执行后面的代码
		}
	} 
}
?>

