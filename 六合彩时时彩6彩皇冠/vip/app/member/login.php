<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "./include/address.mem.php";
require ("./include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$_SESSION['langx']=$langx;
$username=$_REQUEST['username'];
$password=$_REQUEST['password'];

$mysql="select LiveID,LiveID_tw,LiveID_en from web_system_data where ID=1";
$result=mysql_db_query($dbname,$mysql);
$row=mysql_fetch_array($result);
switch($langx){
	case "zh-cn":
	   $liveid=$row['LiveID'];
	   break;
	case "zh-tw":
	   $liveid=$row['LiveID_tw'];
	   break;
	case "en-us":
	   $liveid=$row['LiveID_en'];
	   break;
}
$sql = "SELECT ID FROM `web_member_data` WHERE  UserName = '$username' AND PassWord='$password' AND LoginName= '' AND Status<2 ";
//echo $sql;exit;
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

if($_SESSION["randcode"]!=trim($_REQUEST['code']) && trim($_REQUEST['code'])!='first'){
		echo "<script>alert('LOGIN ERROR!!\\nEnter the verification code error!!');top.location.href='".BROWSER_IP."';</script>";
	    exit;
}
if ($cou==1){
	echo "<script>window.open('".BROWSER_IP."/app/member/account/chg_passwd_safe.php?uid=$uid&username=$username&password=$password&langx=$langx','_top')</script>";
	exit;
}else{
	$sql = "SELECT UserName,LoginName,Pay_Type,PassWord,Credit,LoginDate,OnlineTime,EditDate,ID,Oid FROM `web_member_data`  WHERE LoginName='$username' AND PassWord='$password' AND Status<2 "; 
	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$cou=mysql_num_rows($result);
	if ($cou==0){
	    echo "<script>alert('LOGIN ERROR!!\\nPlease check username/passwd and try again!!');top.location.href='".BROWSER_IP."';</script>";
	    exit;
	}else{
	    $str = time('s');
	    $uid=strtolower(substr(md5($str),0,10).substr(md5($username),0,10).'ra'.rand(0,9));
	    $ip_addr=get_ip();
	    $credit=$row['Credit'];
	    $date=date("Y-m-d");
	    $todaydate=strtotime(date("Y-m-d"));
	    $editdate=strtotime($row['EditDate']);

		$_SESSION['username']=$row['UserName'];
		$_SESSION['Oid']=$uid;
		$_SESSION['userid']=$row['ID'];
	    $time=($todaydate-$editdate)/86400;
		//print_r($_SESSION);exit;
	    /*if ($time>30){
	        $sql="update web_member_data set Oid='$uid',Language='$langx' where LoginName='$username' and Status<=1";
	        mysql_db_query($dbname,$sql) or die ("error!");
	        echo "<script>top.SI2_mem_index.location = '".BROWSER_IP."/app/member/account/chg_passwd.php?mtype=3&uid=$uid&langx=$langx';</script>";
	    }else{	*/
	        $datetime=strtotime(date("Y-m-d H:i:s"));
	        $onlinetime=strtotime($row['OnlineTime']);
	        if ($datetime-$onlinetime>1){
		        if ($row['LoginDate']!=$date and $row['Pay_Type']==0){//判断是现金投注还是信用额度投注，若是现金不回归额度。若是信用回归额度
			       $sql="update web_member_data set Oid='$uid',LoginDate='$date', Money='$credit',LoginTime=now(),OnlineTime=now(),Online=1,LoginIP='$ip_addr',Language='$langx',Url='".BROWSER_IP."' where LoginName='$username' and Status<=1";
		        }else{
			       $sql="update web_member_data set Oid='$uid',LoginDate='$date', LoginTime=now(),OnlineTime=now(),Online=1,LoginIP='$ip_addr',Language='$langx',Url='".BROWSER_IP."' where LoginName='$username' and Status<=1";
		        }		
			       mysql_db_query($dbname,$sql) or die ("error!");
echo "<script> 
top.uid = '$uid';
top.langx = '$langx';
top.liveid = '$liveid';
top.casino = 'SI2';
</script>";
			       echo "<script>top.SI2_mem_index.location = '".BROWSER_IP."/app/member/index.php?mtype=3&uid=$uid&langx=$langx';</script>";
		           /*echo "<script>top.SI2_mem_index.location = '".BROWSER_IP."/app/member/chk_rule.php?mtype=3&uid=$uid&langx=$langx';</script>";*/
	        }else{
		        echo "<SCRIPT language=javascript>alert('LOGIN ERROR!!\\nPlease wait 3 minute and try again!!');self.location='/app/member/index.php';</script>";
	        }
	    //}
	}
}
?>