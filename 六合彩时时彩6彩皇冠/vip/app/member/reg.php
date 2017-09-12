<?
session_start();
$intr=empty($_SESSION['intr'])?$_REQUEST['intr']:$_SESSION['intr'];
if(strlen($intr)<=0){
$intr='ddm999';
}
?>
<html>
<head>
<title>welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.5)">
<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.5)">
<META content="MSHTML 6.00.2900.5583" name=GENERATOR>
<link rel="stylesheet" href="/style/member/css_1.css" type="text/css">
<style type="text/css">body,td,th{font-size:13px}.STYLE10{color:#fff}</style>
<SCRIPT language=javascript>
	var xmlhttp;
	function xhr(url){
		xmlhttp=false;
		if(window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
			if(xmlhttp.overrideMimeType){
				xmlhttp.overrideMimeType('text/xml');
			}
		}else if(window.ActiveXObject){
			try{
				xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
			}catch(e){
				try{
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}catch(e){
				}
			}
		}
	if(!xmlhttp){alert('您的浏览器不支持 ajax！');return false;}
	xmlhttp.open("GET",url,true);
	xmlhttp.onreadystatechange=getreturn;xmlhttp.send(null);
}
</SCRIPT>
<SCRIPT language=javascript src="/js/zhuce.js"></SCRIPT>
<script language="Javascript">document.oncontextmenu=new Function("event.returnValue=false");document.onselectstart=new Function("event.returnValue=false");</script> 
</head>
<BODY id=zhuce_body bgcolor="#FFFFFF" leftmargin="0" topmargin="3" marginwidth="0" marginheight="0">
<table width="118" height="24" border="0" cellpadding="0" cellspacing="2">
   <tr>
     <td width="114" height="24" align="center" background="/images/f223.gif" class="STYLE10">会员注册&gt;&gt;</td>
   </tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
   <tr>
     <td align="center" bgcolor="#C45100">
     <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td height="390" valign="top" bgcolor="#FFF2AA">
          <table cellspacing="0" cellpadding="0" width="100%" border="0">
             <tr>
               <td height="274" align="left" valign="top">
<DIV id=bg_000>
<DIV id=zhuce_top>
<FORM id="form1" name="form1" onSubmit="return formsubmit(this);" action="add_reg_mem.php?keys=add" method="post">
<DIV class=zhuce_00>
<DIV class=zhuce_01>介绍人：</DIV>
<DIV class=zhuce_02><INPUT class="inpt" id="intr" type="hidden" maxLength="10" name="intr" onChange="check_intr()" value="<?=$intr?>"><?=$intr?></DIV>
</DIV>
<DIV class=zhuce_00>
<DIV class=zhuce_01>用户账号：</DIV>
<DIV class=zhuce_02><INPUT name=username class=width_00 id=zcusername onfocus=inputFocus(this,0) onblur=inputBlur(this,0) value="" maxLength=12 pd="yes"></DIV><SPAN class=zhuce_05 id=nameid><font color=#ff0000>*</font>您在网站的登录帐户,<span class="STYLE1">5-12</span>个英文或数字组成 </SPAN></DIV>
<DIV class=zhuce_00>
<DIV class=zhuce_01>用户密码：</DIV>
<DIV class=zhuce_02><INPUT class=width_00 id=pwd1 onblur=inputBlur(this,1) onfocus=inputFocus(this,1) type=password maxLength=12 name=password pd="yes"></DIV>
<SPAN class=zhuce_05><font color=#ff0000>*</font>密码由<span class="STYLE1">5-12</span>位字母、数字或符号组成</SPAN> </DIV>
<DIV class=zhuce_00>
<DIV class=zhuce_01>确认密码：</DIV>
<DIV class=zhuce_02><INPUT class=width_00 onblur=inputBlur(this,2) onfocus=inputFocus(this,2) type=password maxLength=12 name=zcpwd2 pd="yes"></DIV>
<SPAN class=zhuce_05><font color=#ff0000>*</font>再次确认密码</SPAN> </DIV>
<DIV class=zhuce_00>
<DIV class=zhuce_01>真实姓名：</DIV>
<DIV class=zhuce_02><INPUT class=width_00 onblur=inputBlur(this,3) onfocus=inputFocus(this,3) name=alias pd="yes"></DIV>
<SPAN class=zhuce_05><font color=#ff0000>*</font>名字须与您用于提款的银行户口所用名字相同</SPAN> </DIV>
<DIV class=zhuce_00>
<DIV class=zhuce_01>联系电话：</DIV>
<DIV class=zhuce_02><INPUT name=phone class=width_00 onfocus=inputFocus(this,4) onblur=inputBlur(this,4) maxlength="11" pd="yes"></DIV>
<SPAN class=zhuce_05><font color=#ff0000>*</font>请填写您的固定电话或移动手机</SPAN> </DIV>
<DIV class=zhuce_00>
<DIV class=zhuce_01>取款密码：</DIV>
<DIV class=zhuce_02><input type="text" class=width_00  name="address" id="address" maxlength="15" /></DIV><SPAN class=zhuce_05></SPAN><SPAN> </SPAN><SPAN></SPAN></DIV>
<DIV class=zhuce_00>
<DIV class=zhuce_01>备注：</DIV>
<DIV class=zhuce_02><textarea  cols="23" row="10" class="width_00"  name="notes" id="notes"></textarea></DIV><SPAN class=zhuce_05></SPAN><SPAN> </SPAN><SPAN></SPAN></DIV>

<DIV class=zhuce_00>
    <input type=HIDDEN name="agents" value="dva001">
    <input type=HIDDEN name="keys" value="add">
         
</DIV>
<DIV class=tiao_00><LABEL><INPUT id=ischeck type=checkbox value=1 name=zccheck pd="yes"></LABEL>
已经年满18岁，本人并无抵触所在国家所管辖的法律范围，且同意<A href="readme.html" target=_blank><SPAN class=red>【新2现金网条款及规则】</SPAN></A> </DIV>
<DIV class=zhuce_008>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT class=btn_2k3 type=submit value="提交注册">&nbsp;&nbsp; &nbsp;&nbsp; <INPUT name=按钮 type=button class="btn_2k3" style="CURSOR: hand" onclick=javacript:location.reload(); value="重新填写"> 
</DIV></FORM>
 
</DIV></DIV></td>
                          </tr>
                        </tbody>
                      </table>
          </td>
        </tr>
     </table>
     </td>
   </tr>
</table>
</BODY>
</html>