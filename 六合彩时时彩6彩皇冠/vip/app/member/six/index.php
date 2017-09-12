<?php
require_once 'conjunction.php';
require_once 'config.php';

if (ka_config("opwww")==1){
echo "<script>alert('对不起,系统维护中!');top.location.href='op.php';</script>";
exit;}

//print_r($_SESSION);
$name = NULL;
$i = 0;
for ( ;	$i < 1;	++$i	)
{
		$j = 0;
		for ( ;	$j < 4;	++$j	)
		{
				srand( ( double )microtime( ) * 1000000 );
				$randname = rand( !$j ? 1 : 0, 9 );
				$name .= $randname;
		}
}
session_start( );
$_SESSION['yzcode'] = $name;

//前台登陆验证
if (submitcheck('islogin') == 'yes' && empty($admin_info2)) {

	$user = addslashes(trim($user));
	$pass = trim($pass);
	$ycode=$_POST['ycode'];
	$code=$_POST['code'];

	if(empty($user) || empty($pass) || empty($code)){

  echo "<script>alert('用户名或密码不能为空,请反回重新输入!');window.history.go(-1);</script>";
  exit;
    }
	if($ycode!=$code){
  echo "<script>alert('对不起,输入验证码有错!');window.history.go(-1);</script>";
  exit;
    }


    $pass = md5($pass);


	 $ip=$_SERVER["REMOTE_ADDR"];


	mysql_query("Delete from tj where username='$user' and ip='".$ip."'");


	$result=mysql_query("select * from ka_mem where kauser='$user' and kapassword='$pass'");
$row=mysql_fetch_array($result);
	$pass1=$row['kapassword'];
	if ($pass1!=$pass ){
	echo "<script>alert('您输入的帐号或密码错误，请重新输入!');window.history.go(-1);</script>";
	exit;
	}

	$resultb=mysql_query("select * from tj where username='$user' ");
$rowb=mysql_fetch_array($resultb);
	if ($rowb!=""){
	echo "<script>alert('对不起,该账号已登录过,请稍候重试!');window.history.go(-1);</script>";
	exit;
	}




	$text=date("Y-m-d H:i:s");
$sql="update ka_mem set slogin='".$row['slogin']."',sip='".$row['sip']."',zlogin='".$text."',zip='".$ip."',look=look+1 where kauser='".$user."'";
$exe=mysql_query($sql) or die ($sql);

	$_SESSION['username']= $user;

	if ($row['stat']==1){
echo "<script>alert('对不起,该用户已被禁止!');top.location.href='index.php?action=logout';</script>";
exit;}

  if ($row['look']==0){
echo "<script>top.location.href='edits.php';</script>";
exit;}

	echo "<meta http-equiv=refresh content=\"0;URL=look.php\">";exit;
}

?>
<HTML>
<HEAD>


<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="images/ico.ico" rel="shortcut icon">
<title><?=ka_config(1)?>===<?=ka_config(2)?>--</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
.dndn {
	BORDER-RIGHT: #d6d3ce 0px outset; BORDER-TOP: #d6d3ce 0px outset; FONT-SIZE: 9pt; BACKGROUND: #d6d3ce; BORDER-LEFT: #d6d3ce 0px outset; BORDER-BOTTOM: #d6d3ce 0px outset
}
body,td,th {
	font-size: 12px;
	color: #333333;
}
.b-03 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #040177; FONT-STYLE: normal; FONT-FAMILY: "细明体", "新细明体"
}
.b-04 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #ffffff; FONT-STYLE: normal; FONT-FAMILY: "细明体", "新细明体"
}
.style2 {FONT-SIZE: 12px; FONT-STYLE: normal; FONT-FAMILY: "细明体", "新细明体"
}
.style3 {COLOR: #000000
}
-->
</style></HEAD><?
//已登陆

if($_SESSION['username']){
	
    if (in_array($action, array('left', 'logout', 'top','kakithe','l','list','h','k_tm','n1','k_tansave','ds','k_zt','k_zm','k_wx','k_ws','k_bb','k_sx','sm','k_sxp','k_sx4','k_sx5','k_sx6','k_gg','k_lm','n2','n3','k_tansx','k_tanlx','k_ggsave','server','k_tangg','k_lm','k_lmsave','k_tanlm','k_wbz','k_wbzsave','k_tanwbz','k_wbz6','k_wbzsave6','k_tanwbz6','kq','serverf','n55','n5','rake_bb','rake_ws','look','pz_tm','server_tm','pz_zm','server_zm','pz_zt','server_zt','pz_zm6','server_zm6','pz_sx','server_sx','pz_dd','server_dd','pz_lm','server_lm','pz_bb','server_bb','pz_ws','server_ws','pz_gg','server_gg','x1','x2','x3','x4','x5','re_pb','re_all','re_guan','re_zong','re_dai','re_mem','ka_del','ka_xxx','kawin','xt_abcd','xt_stds','xt_ds','xt_kk','xt_copy','xt_bak','pz_wx','server_wx','edit','ziedit','k_sx2','k_sx3','k_zm6','edits','k_bbb','k_qsb','k_dsdx','k_zx','k_lx2','k_lx3','k_lx4','k_lx5','zx_n1','lx_n1','stop','zderror0','k_sxt2','k_sxt2save','k_tansxt2','k_wsl','k_wslsave','k_tanwsl','n4'))) {

	if ($action!="logout" and $action!="top" ){
	require_once 'login.php';}
//	if ($iszhudan==1&&$action=="l") require_once 'zderror0.php';
//	if ($iszhudan!=1&&$action=="l") ;
//	else
	if(in_array($action,array('n55','n5','n1','n4','k_ggsave','k_lmsave','k_sxt2save','k_wslsave','k_wbzsave'))){
		if($_SESSION['username']=='guest' && $_SESSION['userid']=='0'){
			echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script language='javascript'>";
			echo "alert('请登陆后再进行投单！');location.href='../select.php?uid=$uid&langx=zh-cn';";	
			echo "location.href='../select.php?uid=".$_SESSION['Oid']."&langx=zh-cn';";
			echo "</script>";
		}
	}
	echo "<body style=\"height:8000px;\">";
   require_once $action .'.php';
   echo "</body></html>";
	exit;
    }

?>

<body scroll="no" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">




<table width="100%" cellspacing="0" border="0" cellpadding="0" height="100%">
  <tr>
    <td valign="top" height="105px"><iframe id=frmRight
      style="Z-INDEX: 1; VISIBILITY: inherit; WIDTH: 100%; HEIGHT:105px;"
      name=right src="index.php?action=top" frameborder=0 scrolling="no"></iframe></td>
  </tr>
  <tr>
    <td valign="top">
      <table id=tblTotal height="100%" cellspacing=0 cellpadding=0 width="100%"
border=0 name="tblTotal">
        <tbody>
        <tr>
    <td width="250" align=middle valign=center noWrap id=frmMenu
    name="frmMenu">
	<iframe id=mem_order
      style="Z-INDEX: 2; VISIBILITY: inherit; WIDTH: 100%; HEIGHT: 100%"
      name=mem_order src="index.php?action=left" frameborder=0 ></iframe>
	  </td>
          <td width="100%" valign="top">
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
              <tr>
                <td height="100%" valign="top">

				<iframe id=k_memr
      style="Z-INDEX: 1; VISIBILITY: inherit; WIDTH: 100%; HEIGHT: 100%"
      name=k_memr src="index.php?action=k_tm" frameborder=0></iframe></td>
              </tr>




 </table>           </td>
        </tr>
        </tbody>
      </table>
    </td>
  </tr>
</table><?php
}else{
//$uid=trim($_REQUEST['uid']);
if($uid){
	$sql = "SELECT UserNameID FROM `web_member_data`  WHERE Oid='$uid' AND Status<2 "; 
	$result=mysql_query($sql);
	$cou=@mysql_num_rows($result);
	if($cou>0){
		$row=@mysql_fetch_array($result);
		$_SESSION['username']=$row['UserName'];
		$_SESSION['Oid']=$uid;
		$_SESSION['userid']=$row['ID'];
		header("Location:index.php?uid=$uid&action=$action");
		exit;
	}
}
require_once 's.php';
exit;
}
?>