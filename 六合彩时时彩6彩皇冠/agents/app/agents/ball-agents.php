<?
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "./include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("./include/config.inc.php");
require ("./include/look_area.php");
$sql = "select Website from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
if ($row['Website']==1){
	echo "<script>window.open('/upup/upup.php','_top')</script>";
}
//过滤地区IP
$ip = get_ip();
$ip_arr=explode(",",$ip);
/*foreach($ip_arr as $ips){
	$ip_area = convertip($ips);
	$ip_area = iconv("GB2312","UTF-8//IGNORE",$ip_area);
	if(strstr($ip_area,'美国')){
		echo "你所在的地区已经暂停办理商务."; 
		exit;
	}
}*/
$langx = $_REQUEST['langx'];
if ($langx==''){
	$langx="zh-tw";
}
switch($langx){
case 'zh-tw':
	$a1="<a href=".BROWSER_IP."/app/agents/translate.php?set=big5&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/big5/login_tw.jpg' border=0 title='繁體中文'></a>";
	$a2="<a href=".BROWSER_IP."/app/agents/translate.php?set=gb&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/gb/login_cn.jpg'  border=0 title='简体中文'></a>";
	$a3="<a href=".BROWSER_IP."/app/agents/translate.php?set=en-us&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/us/login_us.jpg'  border=0 title='English'></a>";
	$a4="<a href=".BROWSER_IP."/app/agents/translate.php?set=th-tis&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/tis/login_tis.jpg'  border=0 title='Thailand'></a>";
	$size="5";
	$t1="請輸入帳號!!";
	$t2="請輸入密碼!!";
	$t3="請輸入檢查碼!!";
	$t4="檢查碼輸入錯誤請重新輸入!!";
	$t5="檢&nbsp;查&nbsp; 碼:";

	break;
case 'zh-cn':
	$a1="<a href=".BROWSER_IP."/app/agents/translate.php?set=big5&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/big5/login_tw.jpg' border=0 title='繁體中文'></a>";
	$a2="<a href=".BROWSER_IP."/app/agents/translate.php?set=gb&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/gb/login_cn.jpg'  border=0 title='简体中文'></a>";
	$a3="<a href=".BROWSER_IP."/app/agents/translate.php?set=en-us&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/us/login_us.jpg'  border=0 title='English'></a>";
	$a4="<a href=".BROWSER_IP."/app/agents/translate.php?set=th-tis&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/tis/login_tis.jpg'  border=0 title='Thailand'></a>";
	$size="5";
	$t1="请输入帐号!!";
	$t2="请输入密码!!";
	$t3="请输入检查码!!";
	$t4="检查码输入错误请重新输入!!";
	$t5="检 查 码:";
	break;

case 'en-us':
	$a1="<a href=".BROWSER_IP."/app/agents/translate.php?set=big5&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/big5/login_tw.jpg' border=0 title='繁體中文'></a>";
	$a2="<a href=".BROWSER_IP."/app/agents/translate.php?set=gb&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/gb/login_cn.jpg'  border=0 title='简体中文'></a>";
	$a3="<a href=".BROWSER_IP."/app/agents/translate.php?set=en-us&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/us/login_us.jpg'  border=0 title='English'></a>";
	$a4="<a href=".BROWSER_IP."/app/agents/translate.php?set=th-tis&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/tis/login_tis.jpg'  border=0 title='Thailand'></a>";
	$size="4";
	$css='_en';
	$t1="Please enter your username!";
	$t2="Please enter your password!";
	$t3="Enter the code you see below!";
	$t4="Please refill-in the correct code!!";
	$t5="Enter the<br> code shown";
	$rule_bottom="Copyright by 888royal.com Better view and performance with IE 5.0 800*600 or above ";
	break;
	
case 'th-tis':
	$a1="<a href=".BROWSER_IP."/app/agents/translate.php?set=big5&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/big5/login_tw.jpg' border=0 title='繁體中文'></a>";
	$a2="<a href=".BROWSER_IP."/app/agents/translate.php?set=gb&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/gb/login_cn.jpg'  border=0 title='简体中文'></a>";
	$a3="<a href=".BROWSER_IP."/app/agents/translate.php?set=en-us&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/us/login_us.jpg'  border=0 title='English'></a>";
	$a4="<a href=".BROWSER_IP."/app/agents/translate.php?set=th-tis&url=".BROWSER_IP."/app/agents/ball-home.php&uid=$uid><img src='/images/agents/tis/login_tis.jpg'  border=0 title='Thailand'></a>";
	$size="4";
	$css='_en';
	$t1="Please enter your username!";
	$t2="Please enter your password!";
	$t3="Enter the code you see below!";
	$t4="Please refill-in the correct code!!";
	$t5="Enter the<br> code shown";
	$rule_bottom="Copyright by 888royal.com Better view and performance with IE 5.0 800*600 or above ";
	break;
}
require ("./include/traditional.$langx.inc.php");
?>
<html>
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/style/agents/control_index.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/agents/<?=$langx?>.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
	var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
	var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
	if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function onload(){
	type= "";
	switch (type){
		case '0':
			document.all.level(0).checked='true';
			break;
		case '1':
			document.all.level(1).checked='true';
			break;
		case '2':
			document.all.level(2).checked='true';
			break;
		case '3':
			document.all.level(3).checked='true';
			break;
		default :
			document.all.level(0).checked='true';
			break;
	}

//	document.all.username.focus();
}

function chk_type(){
	if (document.all.level(0).checked) {
		LoginForm.action="chk_login.php";
	}
	if (document.all.level(1).checked) {
		LoginForm.action="chk_login.php";
	}
	if (document.all.level(2).checked) {
		LoginForm.action="chk_login.php";
	}
	if (document.all.level(3).checked) {
		LoginForm.action="chk_login.php";
	}
}
function chk_acc(){
	if(document.getElementById('UserName').value =="") {
		alert('<?=$Please_enter_your_username?>');
		document.all.UserName.focus();
		return false;
	}
	if(document.getElementById('PassWord').value =="") {
		alert('<?=$Please_enter_your_password?>');
		document.all.PassWord.focus();
		return false;
	}
	LoginForm.action;
}
function get_flash_player() {
	subWin = window.open("/tpl/corprator/activeX.html");
	subWin.focus();
}
//-->
</script>
</head>
<body bgcolor="#2f5992" onLoad="onload();">
<div class="all">
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" class="tab">
   <tr>
      <td><table width="100%"  border="0" cellpadding="0" cellspacing="0">
             <tr>
                <td width="320"><img name="ind_ph01" src="/images/ind_ph01.jpg" width="320" height="58" border="0" alt=""></td>
                <td bgcolor="#245D82"><img name="ind_ph02" src="/images/ind_ph02.jpg" width="351" height="58" border="0" alt=""></td>
             </tr>
          </table></td>
    </tr>
    <tr>
       <td><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="link_bg">
              <tr>
                 <td align="left">
                    <table border="0" cellspacing="0" cellpadding="0">
                       <tr>
                          <td width="30">&nbsp;</td>
                          <td><a href="./ball-agents.php?langx=zh-tw">繁體版</a></td>
                          <td width="11"><img name="link_icon" src="/images/link_icon.jpg" width="11" height="27" border="0" alt=""></td>
                          <td><a href="./ball-agents.php?langx=zh-cn">简体版</a></td>
                          <td width="11"><img name="link_icon" src="/images/link_icon.jpg" width="11" height="27" border="0" alt=""></td>
                          <td><a href="./ball-agents.php?langx=en-us">English</a></td>
                          <!--<td width="11"><img name="link_icon" src="/images/link_icon.jpg" width="11" height="27" border="0" alt=""></td>
                          <td><a href="./ball-agents.php?langx=jis-jp">日本語</a></td>
                          <td width="11"><img name="link_icon" src="/images/link_icon.jpg" width="11" height="27" border="0" alt=""></td>
                          <td class="no_link"><a href="./ball-agents.php?langx=lit-tu">Türkçe</a></td>-->
                       </tr>
                    </table>
                 </td>
                 <td width="96"><img name="index_top1" src="/images/index_top1.jpg" width="96" height="27" border="0" alt=""></td>
                 <td width="109"><img name="ind_ph11" src="/images/ind_ph11.jpg" width="109" height="27" border="0" alt=""></td>
              </tr>
           </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
                <td><img name="ind_logo01" src="/images/ind_logo01.jpg" width="190" height="138" border="0" alt=""></td>
                <td><img name="ind_logo02" src="/images/ind_logo02.jpg" width="130" height="138" border="0" alt=""></td>
                <td><img name="ind_ph04" src="/images/ind_ph04.jpg" width="150" height="138" border="0" alt=""></td>
                <td><img name="ind_ph05" src="/images/ind_ph05.jpg" width="150" height="138" border="0" alt=""></td>
                <td><img name="ind_ph06" src="/images/ind_ph06.jpg" width="160" height="138" border="0" alt=""></td>
             </tr>
          </table></td>
    </tr>
    <tr>
      <td><table width="100%" height="140"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FC8E00">
             <tr>
                <td class="log_but">
                <form name="LoginForm" method="post" action="" onSubmit="return chk_acc();">
                <INPUT TYPE=HIDDEN NAME="langx" VALUE="<?=$langx?>">
                <table width="380" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                      <td height="28" colspan="2" valign="middle" class="login_icon1">
					  <input name="level" type="radio" value="A">
                      總監
                      <input name="level" type="radio" value="B">
                      股東
                      <input name="level" type="radio" value="C">
                      總代理
                      <input name="level" type="radio" value="D">
                      代理商
                      </td>
                   </tr>
                   <tr>
                      <td height="28" colspan="2" valign="middle" class="login_icon2"><table border="0" cellpadding="0">
                        <tr>
                          <td width="65" align="right"><?=$Ind_UserName?></td>
                          <td><p><INPUT ID="Forms Edit Field2" TYPE=TEXT NAME="UserName" VALUE="" SIZE=10 MAXLENGTH=26 tabindex=1></p></td>
                        </tr>
                     </table></td>
                   </tr>
                   <tr>
                      <td height="28" colspan="2" valign="middle" class="login_icon2"><table border="0" cellpadding="0">
                        <tr>
                          <td width="65" align="right"><?=$Ind_PassWord?></td>
                          <td><p><INPUT ID="Forms Edit Field1" TYPE=PASSWORD NAME="PassWord" VALUE="" SIZE=10 MAXLENGTH=28 tabindex=2></p></td>
                          <td>&nbsp;&nbsp;<input class="login" name="Submit" type="image" id="Forms Button1" src="/images/button.jpg" align="middle" border="0" onClick="chk_type();"></td>
                        </tr>
                     </table></td>
                   </tr>
                </table>
                </form>
              </td>
              <td width="310" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                 <tr>
                    <td><img name="ind_ph09" src="/images/ind_ph09.jpg" width="310" height="93" border="0" alt=""></td>
                 </tr>
                 <tr>
                    <td height="25" align="center"><a href="#"><img src="/images/flowchart/zh-tw/index_log.gif" width="163" height="21" border="0" onClick="javascript:window.open('./index_data/del-history.php?langx=zh-tw','','width=797,height=587,status=yes,scrollbars=yes,resizable=yes')"></a></td>
                 </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td class="foot">版權所有 SBB-IN 有限公司 建議您以IE5.0 1024X768以上高彩模式瀏覽本站 </td>
    </tr>
  </table>
  <br>
</div>
</body>
</html>

