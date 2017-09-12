<%@ Page language="c#" Codebehind="Login.aspx.cs" AutoEventWireup="false" Inherits="newball.user.Login" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE></TITLE>
<META http-equiv=content-type content="text/html; charset=gb2312">
<SCRIPT language=JavaScript src="js/function-no-status-msg.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/function-no-copying.js"></SCRIPT>
<SCRIPT>if(self == top) location='http://3stara.net'
;</SCRIPT>

<META http-equiv=Content-Type content="text/html; charset=big5">
<script language=javascript>


function new_win(html_name,winname,w,h){
  if(winname=='') winname='WINDOWS';
  if(w=='') w=640;
  if(h=='') h=480;
  //undefined
  winformat="toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width="+w+",height="+h;
  winid = window.open(html_name,winname,winformat)
}
</script>
</HEAD>
<BODY bgColor=#ffffff background="images/Globe.gif">
<STYLE type=text/css>BODY {
	FONT-SIZE: 10pt; BACKGROUND-IMAGE: url(images/Globe.gif); BACKGROUND-REPEAT: no-repeat; FONT-FAMILY: Arial, Helvetica, sans-serif
}
TH {
	FONT-WEIGHT: bold; FONT-SIZE: 10pt; FONT-FAMILY: Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #d3dce3
}
TD {
	FONT-SIZE: 10pt; FONT-FAMILY: Arial, Helvetica, sans-serif
}
TD.msgbody {
	FONT-SIZE: 10pt; FONT-FAMILY: Arial, Helvetica, sans-serif
}
FORM {
	FONT-SIZE: 10pt; FONT-FAMILY: Arial, Helvetica, sans-serif
}
H1 {
	FONT-WEIGHT: bold; FONT-SIZE: 16pt; FONT-FAMILY: Arial, Helvetica, sans-serif
}
A:link {
	FONT-SIZE: 10pt; COLOR: blue; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A:visited {
	FONT-SIZE: 10pt; COLOR: blue; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A:hover {
	FONT-SIZE: 10pt; COLOR: red; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A.msgbody:link {
	FONT-SIZE: 10pt; COLOR: blue; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A.msgbody:visited {
	FONT-SIZE: 10pt; COLOR: blue; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A.msgbody:hover {
	FONT-SIZE: 10pt; COLOR: red; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A.nav:link {
	COLOR: #000000; FONT-FAMILY: Arial, Helvetica, sans-serif
}
A.nav:visited {
	COLOR: #000000; FONT-FAMILY: Arial, Helvetica, sans-serif
}
A.nav:hover {
	COLOR: red; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.nav {
	COLOR: #000000; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.medtext {
	FONT-SIZE: 9pt
}
</STYLE>
<FONT face="Arial, Helvetica">
<P align=center><IMG
src="images/openwebmail.gif" border=0 width="233" height="122"></P>
<TABLE cellSpacing=0 cellPadding=0 width=260 align=center border=0>
  <TBODY>
  <TR>
    <TD align=left background="images/bg-titleblue.gif"
    bgColor=#002266>&nbsp;<FONT face="Arial, Helvetica" color=#ffffff
      size=3><B>网路邮局</B></FONT> </TD></TR>
  <TR>
    <TD vAlign=center align=middle bgColor=#3161bd>
      <TABLE cellSpacing=1 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD bgColor=#ffffff>
            <FORM id="Form1" runat="server"><BR>
            <TABLE cellSpacing=2 cellPadding=0 align=center border=0>
              <TBODY>
              <TR>
                <TD noWrap align=right>帐号： </TD>
                <TD align=left><INPUT onchange=focuspwd() size=12
                  name=TextBoxUserName></TD></TR>
              <TR>
                <TD align=right noWrap>密码： </TD>
                <TD align=left><INPUT type=password onchange=focuslogin()
                  size=12 name=TextBoxUserPass></TD></TR>
              <TR>
                <TD align=middle>
                  <TABLE>
                    <TBODY>
                    <TR>
                      <TD><INPUT type=submit value="登入" name=fr_login></TD></TR></TBODY></TABLE></TD>
                <TD align=middle>
                  <TABLE>
                    <TBODY>
                    <TR>
                      <TD><FONT
                  size=1>所有栏位均<BR>区分大小写</FONT></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><BR></FORM></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
<P align=center><BR>
Open
WebMail version 1.65 <BR>
</P>

<table align="center">
	<tr>
		<td><a href="Logint.aspx"><img src="images/icon_big5.jpg" border="0" width="46" height="20"></a></td>
		<td><a href="Login.aspx"><img src="images/icon_gb.jpg" border="0" width="46" height="20"></a></td>
		<!--<td><a href="javascript:new_win('contact.htm','contact','570','440')"><img src="images/e-mail.jpg" border="0" align="absmiddle"></a></td>-->
		<td>连络我们</td>
	</tr>
</table>
<SCRIPT language=JavaScript>
<!--

   document.Form1.TextBoxUserName.focus()

   function focuspwd()
   {
      document.Form1.TextBoxUserPass.focus();
      return(true);
   }

   function focuslogin()
   {
      document.Form1.TextBoxUserName.focus();
      return (true);
   }

//-->
</SCRIPT>
</FONT></BODY></HTML>