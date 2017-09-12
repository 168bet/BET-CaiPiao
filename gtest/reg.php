<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
include_once ROOT_PATH.'class/UserModel.php';
$uid=$_GET['id'];

	$db = new DB();
	$sql = "SELECT * FROM `g_rank` WHERE `g_uid` = '{$uid}' ";
	$result = $db->query($sql, 1);
	$lname=$result[0]['g_name'];
	if ($_SERVER["REQUEST_METHOD"] == 'POST')
{
	$sql = "SELECT * FROM `g_rank` WHERE `g_uid` = '{$_POST['uid']}' ";
	if($result = $db->query($sql, 1)){
	
if(!isset($_POST['hz'])||$_POST['hz']==""||strlen($_POST['hz'])<11) exit(back("手机号码为11位！"));
if(!is_numeric($_POST['hz']))  exit(back("手机号码应为全数字！"));
if(!isset($_POST['hm'])||$_POST['hm']==""||strlen($_POST['hm'])<5) exit(back("会员名称最少5位！"));
if(!isset($_POST['hm'])||$_POST['hma']==""||strlen($_POST['hma'])<5) exit(back("密码最少6位！"));
if(!isset($_POST['hm'])||$_POST['hma']==""||$_POST['hma2']!=$_POST['hma']) exit(back("两次输入密码不一致！"));


	$userModel = new UserModel();
	$uname=$_POST['hm'];
	$sql = "SELECT * FROM `g_user` WHERE `g_name` = '{$uname}' ";
	if($result = $db->query($sql, 1)){
	back("会员账号已经存在！");
	}else{
	
	$sid = 1;
	$s = $lname;
	$s_Name = $uname;
	$s_F_Name = $_POST['hm'];
	$s_Pwd = $_POST['hma'];
	$s_phone = $_POST['hz'];
	$s_money = 0;
	$s_Size_KY = 0;
	$s_pan = 'A';
	$s_select = $_POST['select'];
	$loid = 9;
	
	$p_result = $userModel->GetUserModel(null, $s);
	
	if ($p_result[0]['g_login_id'] == 48)
		{
			$nid = $p_result[0]['g_nid'].'%';
			$validMoney = $p_result[0]['g_money'] - $userModel->SumMoney($nid, true);
		}
		else 
		{
			$nid = $p_result[0]['g_nid'].UserModel::Like();
			$validMoney = $p_result[0]['g_money'] - $userModel->SumMoney($nid);
		}
		if ($s_money > $validMoney)exit(back('上級可用餘額：'.$validMoney));
		if ($s_Size_KY > $p_result[0]['g_distribution'])exit(back('最高占成率：'.$p_result[0]['g_distribution']));
		$s_Nid = $p_result[0]['g_nid'];
	}
	$userList = array();
	$userList['s_L_Name'] = $s;
	$userList['g_nid'] = $s_Nid;
	$userList['g_login_id'] = $loid;
	$userList['g_name'] = $s_Name;
	$userList['g_f_name'] = $s_F_Name;
	$userList['g_phone'] = $s_phone;
	$userList['g_mumber_type'] = $sid;
	$userList['g_password'] = sha1($s_Pwd);
	$userList['g_money'] = $s_money;
	$userList['g_money_yes'] = $s_money;
	$userList['g_distribution'] = $s_Size_KY;
	$userList['g_xianhong'] = 0;
	
	//为会员分配盘口
	for($i=0;$i<count($s_pan);$i++){
	$s_panlus=$s_panlus.strtoupper($s_pan[$i]).',';
	}
	$s_panl=strtoupper($s_pan[0]);
	$userList['g_panlus'] = strtoupper($s_panlus);
	$userList['g_panlu'] = strtoupper($s_panl);
	
	
	$userList['g_xianer'] = 1000000;
	$userList['g_out'] = 0;
	$userList['g_look'] = 1;
	$userList['g_ip'] = UserModel::GetIP();
	$userList['g_date'] = date("Y-m-d H:i:s");
	$userList['g_uid'] = md5(uniqid(time(),true));
	
	$userModel->AddMumberUser($userList);
	alert_href('注册成功！', 'index.php');
	exit;
}else{
back("该上级代理不存在！");
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE><?php echo $Title?> - - Welcome</TITLE>
<META charset=utf-8>
<META content=IE=edge,chrome=1 http-equiv=X-UA-Compatible>
<link rel=”icon” href=”/favicon.ico” mce_href=”/favicon.ico” type=”image/x-icon”>
<link rel=”shortcut icon” href=”/favicon.ico” mce_href=”/favicon.ico” type=”image/x-icon”> 

<SCRIPT language=javascript src="/js/jquery.js"></SCRIPT>

<SCRIPT language=javascript>
		var LoginPic = new Array();
		LoginPic[0]='/Manage/images/logo/logo1.jpg';
		LoginPic[1]='/Manage/images/logo/logo2.jpg';
		LoginPic[2]='/Manage/images/logo/logo3.jpg';
		LoginPic[3]='/Manage/images/logo/logo4.jpg';
		LoginPic[4]='/Manage/images/logo/logo5.jpg';
		LoginPic[5]='/Manage/images/logo/logo6.jpg';
		</SCRIPT>

<SCRIPT language=javascript src="/webssc/js/login.js"></SCRIPT>
<script>
function checksubmit(){
var re=checkpass();
re=checkhz();
re=checkhm();
re=checkpa1();
return re;
}

function checkpass(){
var password2=document.getElementById("hma2");
var password=document.getElementById("hma");
if(password2.value!=password.value){
$("#t4").html("两次密码不一样");
return false;
}else{
$("#t4").html("");
}
}

function checkhz(){
var hz=document.getElementById("hz");
if(hz.value.length<11){
$("#t1").html("手机号码为11位数字！");
return false;
}else{
$("#t1").html("");
}
}

function checkhm(){
var hm=document.getElementById("hm");
if(hm.value.length<5){
$("#t2").html("會員账号最少5位");
return false;
}else{
$("#t2").html("");
}
}

function checkpa1(){
var hma=document.getElementById("hma");
if(hma.value.length<6){
$("#t3").html("密码最少6位");
return false;
}else{
$("#t3").html("");
}
}
</script>
<STYLE type=text/css>BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
DIV {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
FORM {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
INPUT {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
IMG {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
P {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
BODY {
	FONT: 14px/1.231 Verdana, Arial, Helvetica, sans-serif; COLOR: #333333
}
A {
	COLOR: #dd2405; TEXT-DECORATION: underline
}
.pager {
	POSITION: relative; MARGIN: 0px auto; WIDTH: 1003px; HEIGHT: 600px
}
.bg {
	POSITION: absolute; LINE-HEIGHT: 0; FONT-SIZE: 0px; TOP: 0px
}
.bg IMG {
	BORDER-BOTTOM: 0px; BORDER-LEFT: 0px; WIDTH: 1003px; BORDER-TOP: 0px; BORDER-RIGHT: 0px
}
.lo {
	POSITION: absolute; TOP: 198px; LEFT: 220px
}
.login {
	Z-INDEX: 2; BORDER-BOTTOM: #e9ac08 5px solid; BORDER-LEFT: #e9ac08 5px solid; PADDING-BOTTOM: 0px; MARGIN: 10px; PADDING-LEFT: 22px; WIDTH: 490px; PADDING-RIGHT: 22px; BACKGROUND: #fff9d7; HEIGHT: 290px; BORDER-TOP: #e9ac08 5px solid; BORDER-RIGHT: #e9ac08 5px solid; PADDING-TOP: 0px
}
.opacity {
	Z-INDEX: 1; FILTER: alpha(opacity=50); WIDTH: 564px; BACKGROUND: white; HEIGHT: 318px; opacity: 0.5
}
TABLE {
	MARGIN-TOP: 8px; BORDER-SPACING: 0; WIDTH: 100%; BORDER-COLLAPSE: collapse; VERTICAL-ALIGN: middle
}
CAPTION {
	HEIGHT: 39px; COLOR: #c40c00; FONT-SIZE: 16px; FONT-WEIGHT: bold
}
CAPTION P {
	POSITION: relative; LINE-HEIGHT: 0; BOTTOM: 2px; HEIGHT: 0px; FONT-SIZE: 0px; BORDER-TOP: #ffc84e 1px solid
}
CAPTION SPAN {
	Z-INDEX: 2; POSITION: relative; PADDING-BOTTOM: 0px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; BACKGROUND: #fff9d7; TOP: 10px; PADDING-TOP: 0px
}
TH {
	PADDING-BOTTOM: 7px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 7px
}
TD {
	PADDING-BOTTOM: 7px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 7px
}
TH {
	TEXT-ALIGN: right; PADDING-LEFT: 4px; WIDTH: 31%
}
INPUT {
	BORDER-BOTTOM: #9b9b9b 1px solid; BORDER-LEFT: #9b9b9b 1px solid; LINE-HEIGHT: 20px; WIDTH: 151px; HEIGHT: 20px; BORDER-TOP: #9b9b9b 1px solid; BORDER-RIGHT: #9b9b9b 1px solid
}
.sbt {
	BORDER-BOTTOM: #dd6005 1px solid; BORDER-LEFT: #dd6005 1px solid; PADDING-BOTTOM: 1px; PADDING-LEFT: 1px; WIDTH: 150px; PADDING-RIGHT: 1px; BACKGROUND: #ffaa6c; HEIGHT: 55px; BORDER-TOP: #dd6005 1px solid; BORDER-RIGHT: #dd6005 1px solid; PADDING-TOP: 1px
}
.sbt INPUT {
	BORDER-BOTTOM: 0px; BORDER-LEFT: 0px; WIDTH: 150px; BACKGROUND: #ff740f; HEIGHT: 55px; COLOR: white; FONT-SIZE: 18px; BORDER-TOP: 0px; CURSOR: pointer; FONT-WEIGHT: bold; BORDER-RIGHT: 0px
}
.vcode INPUT {
	WIDTH: 80px
}
.vcode IMG {
	HEIGHT: 22px; VERTICAL-ALIGN: top
}
.vbanben {
	LINE-HEIGHT: 20px; FONT-SIZE: 13px
}
.vbanben INPUT {
	FLOAT: left
}
.vbanben LABEL {
	FLOAT: left
}
#shenjiban {
	BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; WIDTH: 15px; BORDER-TOP: medium none; BORDER-RIGHT: medium none
}
#chuantongban {
	BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; WIDTH: 15px; BORDER-TOP: medium none; BORDER-RIGHT: medium none
}
</STYLE>
</head>

<body onLoad="loadbg()">

<input type="hidden" value="<?php echo base64_encode(ROOT_PATH)?>"/><DIV class=pager>
<DIV id=bg class=bg></DIV>
<form action="" method="post" onsubmit="return checksubmit();" class="lo login " id="reg">
<input type="hidden" name="uid" id="uid" value="<?php echo$uid?>" />
<TABLE>
<CAPTION><SPAN>会员注册</SPAN> 
<P></P></CAPTION>
<TBODY>
<TR>
<TH>上级代理：</TH>
<TD><?php echo$result[0]['g_name'];?></TD>
</TR>
<TR>
<TH>會員账号：</TH>
<TD><input type="text" name="hm" id="hm"  onblur="checkhm()" /> </TD>
<td><span class="STYLE4" id="t2"> </span></td></TR>
<TR>
<TH>手机号码：</TH>
<TD><input type="text" name="hz" id="hz" onblur="checkhz()" maxlength="11" /></TD>
<TD><span class="STYLE4" id="t1"> </span></TD></TR>
<TR>
<TH>登陸密碼：</TH>
<TD><input type="password" name="hma" id="hma"  onblur="checkpa1()" /></TD>
<TD><span class="STYLE4" id="t3"> </span></TD></TR>
<TR>
<TH>密碼确认：</TH>
<TD><input type="password" name="hma2" id="hma2" onblur="checkpass()" /></TD>
<TD><span class="STYLE4" id="t4"> </span></TD></TR>
<TR>
<TH></TH>
<TD>
<DIV class=sbt><input type="submit" value="注册" /></DIV></TD></TR>
<TR>
</TBODY></TABLE></FORM>
<DIV class="lo opacity"></DIV></DIV>

</body>
</html>
