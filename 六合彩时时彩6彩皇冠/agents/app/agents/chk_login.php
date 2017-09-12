<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("include/config.inc.php");

$langx=$_REQUEST["langx"];
$level=$_REQUEST['level'];
$username=$_REQUEST["UserName"];
$password=$_REQUEST["PassWord"];

if(strlen($_SESSION["username1"])<>'0' and strlen($_SESSION["password1"])<>'0'){
	$username=$_SESSION["username1"];
	$password=$_SESSION["password1"];
	$langx=$_SESSION["langx1"];
	$level=$_SESSION["level1"];
//print_r($_SESSION);exit;
}

$sql = "select website,Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$data='web_system_data';
}else{
	$data='web_agents_data';
}
$str = time('s');
$uid=substr(md5($username),0,6).ucfirst(substr(md5($str),0,rand(50,50))).'ag'.rand(0,1);

$ip_addr = get_ip();
$loginfo='用户登入成功';
switch ($level){
case 'M':
	$lv='管理员';
	break;
case 'A':
	$lv='公司';
	break;
case 'B':
	$lv='股东';
	break;
case 'C':
	$lv='总代理';
	break;
case 'D':
    $lv='代理商';
	break;
}

$mysql = "select * from `$data` where Level='$level' and UserName='$username' and PassWord='$password' and LoginName='' and Status<2";
//echo $mysql;exit;
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if ($cou==1){
	echo "<script>window.open('".BROWSER_IP."/app/agents/chg_ln.php?username=$username&password=$password&langx=$langx','_top')</script>";
	exit;
}else{
	$mysql = "select * from `$data` where Level='$level' and LoginName ='$username' and PassWord='$password' and Status<2";
	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
	$cou=mysql_num_rows($result);
	if ($cou==0){
	    echo "<script>alert('LOGIN ERROR!!\\nPlease check username/passwd and try again!!');window.open('".BROWSER_IP."','_top')</script>";
	    exit;
    }else{
		$user=$row['UserName'];
		$date=date("Y-m-d");
		$todaydate=strtotime(date("Y-m-d"));
		$editdate=strtotime($row['EditDate']);
		$time=($todaydate-$editdate)/86400;
		if ($time>30){
			$sql="update `$data` set Oid='$uid',Language='$langx' where LoginName='$username' and Status<2";
			mysql_db_query($dbname,$sql) or die ("操作失败!");
			echo "<script>top.bb_mem_index.location = '".BROWSER_IP."/app/agents/chg_pw.php?&uid=$uid&langx=$langx';</script>";
		}else{
			$_SESSION['langx']=$langx;
			$_SESSION['loginname']=$username;
			$_SESSION['username1']=$username;
			$_SESSION['password1']=$password;
			$_SESSION["langx1"]=$langx;
			$_SESSION["level1"]=$level;
			$_SESSION['jxadmin666']= $username;
			$_SESSION['flag'] = ",01,02,03,04,05,06,07,08,09,10,11,12,13";
    			$_SESSION['stadmin666']='1';			
			//print_r($_SESSION);
//print_r($_SESSION);exit;
			$sql="update $data set Level='$level',Oid='$uid',LoginDate='$date',LoginTime=now(),OnlineTime=now(),Language='$langx',Online='1',Url='".BROWSER_IP."',LoginIP='$ip_addr' where LoginName='".$username."'";
			mysql_db_query($dbname,$sql) or die ("操作失败!");
			$mysql="insert into web_mem_log_data(UserName,LoginIP,LoginTime,ConText,Url,Level)values('$user','$ip_addr',now(),'$loginfo','".BROWSER_IP."','$lv')";
			mysql_db_query($dbname,$mysql);
		}
	}
}
?>	
<html>
<head>
<title>web</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<frameset rows="71,*" frameborder="NO" border="0" framespacing="0"> 
 <frame name="topFrame" scrolling="NO" noresize src="header.php?uid=<?=$uid?>&lv=<?=$level?>&langx=<?=$langx?>">
 <frame name="main" src="body_home.php?uid=<?=$uid?>&lv=<?=$level?>&langx=<?=$langx?>">
</frameset> 
<noframes>
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes>
</html>