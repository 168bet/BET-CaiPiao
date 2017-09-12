<?php

require_once dirname(__FILE__).'/conjunction.php';
require_once dirname(__FILE__).'/config.php';

//管理员登陆验证

if (submitcheck('islogin') == 'yes' && empty($admin_info) && $_GET['save22']=="save22") {
	
	$user = addslashes(trim($user));
	$pass = trim($pass);
	

	if(empty($user) || empty($pass)){
       
  echo "<script>alert('用户名或密码不能为空,请反回重新输入11!');window.history.go(-1);</script>"; 
  exit;
    }

    $pass = md5($pass);
    //pr("select * from ka_admin where username='$user' and password='$pass'");exit();
    
	$result=mysql_query("select * from ka_admin where username='$user' and password='$pass'"); 
$row=mysql_fetch_array($result); 
	$pass1=$row['password'];
//	pr($row)."<br />";exit;
//	pr($pass1);exit;
	if ($pass1!=$pass ){
	echo "<script>alert('您输入的帐号或密码错误，请重新输入!');window.history.go(-1);</script>"; 
	exit;
	}
	$text=date("Y-m-d H:i:s"); 
$sql="update ka_admin set lastlogin='".$text."',look=look+1 where username='".$user."'";
$exe=mysql_query($sql) or die ($sql);	

	$_SESSION['jxadmin666']= $user;
	$_SESSION['flag'] = $row['flag'];
    $_SESSION['stadmin666']=$row['admin'];
  
	
	echo "<meta http-equiv=refresh content=\"0;URL=index.php\">";exit;
}
//已登陆
if($_SESSION['jxadmin666']){
	?>
    <HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="images/ico.ico" rel="shortcut icon">
<title>后台登陆</title>
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
-->
</style>
<link rel="stylesheet" href="images/xp.css" type="text/css">
</HEAD>
    <?
    if (in_array($action, array('kithe', 'logout', 'top','kakithe','kithe_add','kithe_edit','kaguan','kazong','kadan','kamem','kazi','admin_main','admin_add','editadmin','modify_pass','tj','right','sm','guan_add','guan_edit','zong_add','zong_edit','dan_add','dan_edit','mem_add','mem_edit','rake_tm','server','rake_update','rake_update2','rake_zm','rake_ztm','rake_zm6','rake_gg','rake_lm','rake_wbz','rake_sx','rake_wx','rake_bb','rake_ws','look','pz_tm','server_tm','pz_zm','server_zm','pz_zt','server_zt','pz_zm6','server_zm6','pz_sx','pz_sx1','server_sx','pz_dd','server_dd','pz_lm','server_lm','pz_lmg','server_lmg','pz_bb','server_bb','pz_ws','server_ws','pz_gg','server_gg','x1','x2','x3','x4','x5','re_pb','re_all','re_guan','re_zong','re_dai','re_mem','ka_del','ka_xxx','kawin','xt_abcd','xt_stds','xt_ds','xt_kk','xt_copy','xt_bak','pz_wx','server_wx','xt_nn','tm','kaaout','kaaout1','rake_mm','rake_hy','rake_mzm','rake_mzt','rake_mgg','rake_mlm','rake_mwbz','rake_mbb','rake_msx','rake_mws','rake_mwx',"xx5","ykithe",'edit','xx1','xxx5','pz_all','server_all','dy','e1','look1','tm2','rake_bbb','pz_bbb','rake_mbbb','rake_ts','pz_ts','rake_mts','pz_ztws','rake_ztws','rake_mztws','server_ztws','pz_qsb','rake_qsb','rake_mqsb','server_qsb','pz_zhx','rake_zhx','rake_zxsb','rake_mzhx','server_zhx','rake_sxx','rake_mzm6','rake_zx','rake_lx','pz_wbz','server_wbz','pz_lx','pz_lxg','pz_wsl','backup','server_bbb','server_ts','server_lx','server_lxg','server_zx','server2','rake_sxt','rake_wsl','rake_msxt','rake_mwsl','mmtop','l','list'))) {
	
	if ($action!="logout" and $action!="top" ){
	

	
	}
	
		 require_once $action .'.php';
	exit;
    }
?>
<script language="JavaScript">
function show(i){
a1.style.display = "none"; 
a4.style.display = "none"; 
a5.style.display = "none"; 
a2.style.display = "none"; 
a3.style.display = "none"; 
i.style.display = "";  
     
}	
function re_re1(bb){

re1.style.color="494949"
re2.style.color="494949"
re3.style.color="494949"
re4.style.color="494949"
re5.style.color="494949"
re6.style.color="494949"
re7.style.color="494949"
re8.style.color="494949"
re9.style.color="494949"
re10.style.color="494949"
bb.style.color="ff0000"	
	
}

function rm_rm1(bb){

rm1.style.color="494949"
rm2.style.color="494949"
rm3.style.color="494949"
rm4.style.color="494949"
rm5.style.color="494949"
rm6.style.color="494949"
rm7.style.color="494949"

bb.style.color="ff0000"	
	
}    
function rb_rb1(bb){
rb1.style.color="494949"
rb2.style.color="494949"
rb3.style.color="494949"
rb4.style.color="494949"
rb5.style.color="494949"
rb6.style.color="494949"
rb7.style.color="494949"

rb8.style.color="494949"
rb9.style.color="494949"
rb10.style.color="494949"
rb11.style.color="494949"
rb12.style.color="494949"
rb13.style.color="494949"


bb.style.color="ff0000"	
}     
 
 function rl_rl1(bb){
rl1.style.color="494949"
rl2.style.color="494949"
rl3.style.color="494949"
rl4.style.color="494949"
rl5.style.color="494949"
rl6.style.color="494949"
rl7.style.color="494949"

rl8.style.color="494949"

bb.style.color="ff0000"	
}     

function rmn_rmn1(bb){
 rmn1.style.color="494949"
rmn2.style.color="494949"
rmn3.style.color="494949"
bb.style.color="ff0000"	
}     

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_changeProp(objName,x,theProp,theValue) { //v6.0
  var obj = MM_findObj(objName);
  if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
    if (theValue == true || theValue == false)
      eval("obj."+theProp+"="+theValue);
    else eval("obj."+theProp+"='"+theValue+"'");
  }
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
</script>
<body scroll="no" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" cellspacing="0" border="0" cellpadding="0" height="100%">
  <tr>
    <td valign="top" height="65px"><iframe id=frmRight 
      style="Z-INDEX: 1; VISIBILITY: inherit; WIDTH: 100%; HEIGHT: 74" 
      name=right src="index.php?action=top" frameborder=0></iframe></td>
  </tr>
  <tr>
    <td valign="top"> 
      <table id=tblTotal height="100%" cellspacing=0 cellpadding=0 width="100%" 
border=0 name="tblTotal">
        <tbody> 
        <tr>
    
          <td width="100%" valign="top">
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
              <tr>
                <td height="100%" valign="top">
			
				<iframe id=frmRight 
      style="Z-INDEX: 1; VISIBILITY: inherit; WIDTH: 100%; HEIGHT: 100%" 
      name=right src="index.php?action=kithe" scrolling="yes" frameborder=0></iframe></td>
              </tr>
            </table>           </td>
        </tr>
        </tbody> 
      </table>
    </td>
  </tr>
</table>

<?php
}
else {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"><HEAD><TITLE>Mail System</TITLE>
<META http-equiv=content-type content="text/html; charset=gb2312">
<STYLE type=text/css>TD {
	FONT-SIZE: 12px; FONT-FAMILY: arial
}
TH {
	FONT-SIZE: 12px; COLOR: purple; FONT-FAMILY: verdana
}
BODY {
	FONT-SIZE: 12px; COLOR: black; FONT-FAMILY: arial
}
SELECT {
	FONT-SIZE: 12px; FONT-FAMILY: arial
}
A:visited {
	COLOR: white; TEXT-DECORATION: underline
}
A:hover {
	COLOR: yellow; TEXT-DECORATION: none
}
A:link {
	COLOR: white; TEXT-DECORATION: underline
}
.submenu {
	BACKGROUND-COLOR: transparent
}
.submenu TH {
	FONT-SIZE: 12px; FONT-FAMILY: arial; HEIGHT: 20px; BACKGROUND-COLOR: #996600; TEXT-ALIGN: center
}
.submenu TD {
	FONT-SIZE: 12px; BACKGROUND-COLOR: transparent
}
.title {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: white
}
.butt {
	FONT-SIZE: 12px; CURSOR: hand; COLOR: #00008b; FONT-FAMILY: arial; HEIGHT: 23px; TEXT-DECORATION: none
}
</STYLE>

<STYLE type=text/css>TD IMG {
	DISPLAY: block
}
BODY {
	BACKGROUND-IMAGE: url(images/login_bg.gif); MARGIN: 0px
}
</STYLE>
<script language="javascript">
function checks(form)
{
 if(form.user.value=="")
 {
   alert('请输入账号!');
   form.user.focus();
      return false;
 }else if(form.pass.value=="")
 {
   alert('请输入密码!');
   form.pass.focus();
      return false;
 }else return true;
}
</script>
<META content="MSHTML 6.00.6000.16825" name=GENERATOR>
</HEAD>
<BODY bgColor=#ffffff onload=document.myForm.login.focus();>
<DIV align=center>
<FORM name=myform action="index.php?save22=save22" onSubmit="return checks(this);" method=post>
<TABLE cellSpacing=0 cellPadding=0 width=812 align=center border=0>
  <TBODY>
  <TR>
    <TD><IMG height=1 alt="" src="images/spacer.gif" 
      width=175 border=0></TD>
    <TD><IMG height=1 alt="" src="images/spacer.gif" 
      width=457 border=0></TD>
    <TD><IMG height=1 alt="" src="images/spacer.gif" 
      width=180 border=0></TD>
    <TD><IMG height=1 alt="" src="images/spacer.gif" 
      width=1 border=0></TD></TR>
  <TR>
    <TD colSpan=3>　</TD>
    <TD><IMG height=29 alt="" src="images/spacer.gif" 
      width=1 border=0></TD></TR>
  <TR>
    <TD colSpan=3><IMG id=login_r2_c1 height=91 alt="" 
      src="images/login_r2_c1.jpg" width=812 border=0 
      name=login_r2_c1></TD>
    <TD><IMG height=91 alt="" src="images/spacer.gif" 
      width=1 border=0></TD></TR>
  <TR>
    <TD colSpan=3><IMG id=login_r3_c1 height=87 alt="" 
      src="images/login_r3_c1.jpg" width=812 border=0 
      name=login_r3_c1></TD>
    <TD><IMG height=87 alt="" src="images/spacer.gif" 
      width=1 border=0></TD></TR>
  <TR>
    <TD rowSpan=2><IMG id=login_r4_c1 height=351 alt="" 
      src="images/login_r4_c1.jpg" width=175 border=0 
      name=login_r4_c1></TD>
    <TD width=457 background=images/login_r4_c2.jpg 
    height=201 align="center">
      <TABLE cellSpacing=0 cellPadding=1 border=0>
        <TBODY>
        <TR>
          <TH style="PADDING-BOTTOM: 10px; TEXT-ALIGN: center" 
            colSpan=3><B>&nbsp;Manager&nbsp;</B> Login<BR></TH></TR>
        <TR>
          <TD align=middle>Username&nbsp;&nbsp;账号</TD>
          <TD align=middle>:</TD>
          <TD align=right>
			<INPUT 
            style="FONT-SIZE: 12px; COLOR: navy; FONT-FAMILY: arial" 
            maxLength=15 size=17 name=user></TD></TR>
        <TR>
          <TD align=middle>Password&nbsp;&nbsp;密码</TD>
          <TD align=middle>:</TD>
          <TD align=right>
			<INPUT 
            style="FONT-SIZE: 12px; COLOR: navy; FONT-FAMILY: arial" 
            type=password maxLength=15 size=17 name=pass></TD></TR>
        <TR>
          <TD align=middle>Language&nbsp;&nbsp;语言</TD>
          <TD align=middle>:</TD>
          <TD align=right>
			<SELECT 
            style="FONT-SIZE: 12px; WIDTH: 116px; COLOR: navy; FONT-FAMILY: arial" 
            name=fr_language size="1" onChange="window.location = '?language='+this.options[this.selectedIndex].value;"> <OPTION value=zh >简体</OPTION>
<OPTION value=tw >繁体</OPTION> </SELECT> 
        </TD></TR>
        <TR>
          <TD align=right colSpan=3><BR><INPUT class=butt type=submit value="Enter 登入" name=fr_submit> <INPUT class=butt type=reset value="Reset 重设" name=fr_back> 
          </TD></TR></TBODY></TABLE></TD>
    <TD rowSpan=2><IMG id=login_r4_c3 height=351 alt="" 
      src="images/login_r4_c3.jpg" width=180 border=0 
      name=login_r4_c3></TD>
    <TD><IMG height=201 alt="" src="images/spacer.gif" 
      width=1 border=0></TD></TR>
  <TR>
    <TD><IMG id=login_r5_c2 height=150 alt="" 
      src="images/login_r5_c2.jpg" width=457 border=0 
      name=login_r5_c2></TD>
    <TD><IMG height=150 alt="" src="images/spacer.gif" 
      width=1 border=0></TD></TR>
  <TR>
    <TD vAlign=top bgColor=#00314f colSpan=3></TD></TR></TBODY></TABLE><INPUT type=hidden value=1 name=bypass> 
<input name="jcode" type="hidden" id="jcode" value="8888">
</FORM>
</DIV></BODY></HTML>

<?php
}
?>
