<?php 
if (!defined('Copyright') && Copyright != '作者QQ:503064228')
exit('作者QQ:503064228');
if (!defined('ROOT_PATH'))
exit('invalid request');
include_once ROOT_PATH.'Manage/config/global.php';
include_once ROOT_PATH.'Manage/config/config.php';
global $ConfigModel;
if ($_SERVER["REQUEST_METHOD"] == 'POST')
{

	if (isset($_SESSION['Mcode']) && $_POST['VerifyCode'] == $_SESSION['Mcode'])
	{
		$loginName = $_POST['loginName'];
		$loginPwd = sha1($_POST['loginPwd']);

		if (!GetMsie()) exit(back($UserError));
		if (!Matchs::isString($loginName, 4, 15)) 
			exit(back($UserError));
		$UserModel = new UserModel();
		$User = $UserModel->ExistUnion($loginName, $loginPwd);
		if (!$User) exit(back($UserError));
		if (!Matchs::isNumber($User[0][0]))
		{ 
			if ($ConfigModel['g_web_lock'] != 1) 
				exit(back($ConfigModel['g_web_text']));
			$User = $UserModel->GetUserModel(null, $loginName, $loginPwd, true);
			if ($User[0]['g_s_lock'] == 3 || $User[0]['g_lock'] == 3) 
				exit(back($UserLook));
			$uniqid = md5(uniqid(time(),TRUE));
			$UserModel->UpdateGuid ($User[0]['g_login_id'], $User[0]['g_s_name'], $uniqid, true);
			$_SESSION['son'] = true;
			$_SESSION['loginId'] = $User[0]['g_login_id'];
			$_SESSION['sName'] = $User[0]['g_s_name'];
		} 
		else 
		{
			if (isset($_SESSION['son'])) unset($_SESSION['son']);
			$User = $UserModel->GetUserModel($User[0][0], $loginName, $loginPwd);
			if (!$User) exit(back($UserError));
			if ($User[0]['g_login_id'] != 89){
				if ($ConfigModel['g_web_lock'] != 1)
					exit(back($ConfigModel['g_web_text']));
				if ($User[0]['g_lock'] == 3) 
					exit(back($UserLook));
			}
			$uniqid = md5(uniqid(time(),TRUE));
			$UserModel->UpdateGuid ($User[0]['g_login_id'], $User[0]['g_name'], $uniqid);
			$_SESSION['loginId'] = $User[0]['g_login_id'];
			$_SESSION['sName'] = $User[0]['g_name'];
		}
		setcookie("manage_user", base64_encode($loginName), 0, "/");
		setcookie("manage_uid", base64_encode($uniqid), 0, "/");
		unset($_SESSION['Mcode']);
		
		$loginIp = GetIP();
		$qqWryInfo = ROOT_PATH.'tools/IpLocationApi/QQWry.Dat';
		$ip_s = ipLocation($loginIp, $qqWryInfo);
		$sql = "INSERT INTO g_login_log (g_name, g_ip, g_ip_location, g_date) VALUES ('{$loginName}','{$loginIp}','{$ip_s}',now())";
		$db=new DB();
		$db->query($sql, 2);
		if(	$_POST['banbeng']==2)
		include_once ROOT_PATH.'Manage/main.php';
		else
		include_once ROOT_PATH.'Manage/main_us.php';
		exit;
	} 
	else 
	{
		back($CodeError);
		exit;
	}
} 
else
{
	$num = array();
	for ($i=0; $i<4; $i++) 
	{
		$num[$i] = rand(0,9);
	}
	$num = join('', $num);
	$_SESSION['Mcode'] = $num;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE><?php echo $Title?> - - Welcome</TITLE>
<META charset=utf-8>
<META content=IE=edge,chrome=1 http-equiv=X-UA-Compatible>
<SCRIPT language=javascript src="/js/jquery.js"></SCRIPT>

<SCRIPT language=javascript src="/webssc/js/aglogin.js"></SCRIPT>

<STYLE type=text/css>
BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
DIV {
	PADDING-BOTTOM: 0px;
	MARGIN: 0px;
	PADDING-LEFT: 0px;
	PADDING-RIGHT: 0px;
	PADDING-TOP: 0px;
	background-image: url(../Manage/images/logo/1.jpg);
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
	POSITION: absolute; TOP: 198px; LEFT: 320px
}
.login {
	Z-INDEX: 2; BORDER-BOTTOM: #e9ac08 5px solid; BORDER-LEFT: #e9ac08 5px solid; PADDING-BOTTOM: 0px; MARGIN: 10px; PADDING-LEFT: 22px; WIDTH: 290px; PADDING-RIGHT: 22px; BACKGROUND: #fff9d7; HEIGHT: 190px; BORDER-TOP: #e9ac08 5px solid; BORDER-RIGHT: #e9ac08 5px solid; PADDING-TOP: 0px
}
.opacity {
	Z-INDEX: 1; FILTER: alpha(opacity=50); WIDTH: 364px; BACKGROUND: white; HEIGHT: 218px; opacity: 0.5
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
	TEXT-ALIGN: right; PADDING-LEFT: 4px; WIDTH: 21%
}
INPUT {
	BORDER-BOTTOM: #9b9b9b 1px solid; BORDER-LEFT: #9b9b9b 1px solid; LINE-HEIGHT: 20px; WIDTH: 151px; HEIGHT: 20px; BORDER-TOP: #9b9b9b 1px solid; BORDER-RIGHT: #9b9b9b 1px solid
}
.sbt {
	BORDER-BOTTOM: #dd6005 1px solid; BORDER-LEFT: #dd6005 1px solid; PADDING-BOTTOM: 1px; PADDING-LEFT: 1px; WIDTH: 58px; PADDING-RIGHT: 1px; BACKGROUND: #ffaa6c; HEIGHT: 55px; BORDER-TOP: #dd6005 1px solid; BORDER-RIGHT: #dd6005 1px solid; PADDING-TOP: 1px
}
.sbt INPUT {
	BORDER-BOTTOM: 0px; BORDER-LEFT: 0px; WIDTH: 58px; BACKGROUND: #ff740f; HEIGHT: 55px; COLOR: white; FONT-SIZE: 18px; BORDER-TOP: 0px; CURSOR: pointer; FONT-WEIGHT: bold; BORDER-RIGHT: 0px
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

<FORM id=login_form class="lo login " onSubmit="return validateForm()" method=post name=login_form>
<TABLE>
<CAPTION><SPAN>管理登录</SPAN> 
<P></P></CAPTION>
<TBODY>
<TR>
<TH>账&nbsp;&nbsp;&nbsp;号：</TH>
<TD><INPUT tabIndex=1 maxLength=12 type=text name=loginName valid="account"> </TD>
<TD rowSpan=2>
<DIV class=sbt><INPUT tabIndex=4 value=登录 type=submit name=submit> </DIV></TD></TR>
<TR>
<TH>密&nbsp;&nbsp;&nbsp;码：</TH>
<TD><INPUT tabIndex=2 value="" maxLength=16 type=password name=loginPwd valid="password"> </TD></TR>
<TR class=vcode>
<TH>验证码：</TH>
<TD><INPUT tabIndex=3 maxLength=12 type=text name=VerifyCode autocomplete="off"> <SPAN id=img><IMG src="/yzm.php"></SPAN></TD>
<TD><A onclick=rvcode(false) href="javascript:void(0)">看不清？</A></TD></TR>
<TR class=vbanben>
<TH></TH>
<TD><INPUT id=shenjiban value=1 CHECKED type=radio name=banbeng> <LABEL class=label for=shenjiban>新版&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</LABEL> <INPUT id=chuantongban value=2 type=radio name=banbeng> <LABEL class=label for=chuantongban>旧版</LABEL> </TD>
<TD></TD></TR>
</TBODY></TABLE></FORM>
<DIV class="lo opacity"></DIV></DIV>
<FORM method=post name=lform><INPUT value=1 type=hidden name=islogin>
</FORM>
</BODY>
</html>