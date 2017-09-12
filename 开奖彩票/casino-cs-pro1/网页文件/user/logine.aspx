<%@ Page language="c#" Codebehind="Login.aspx.cs" AutoEventWireup="false" Inherits="newball.user.Login" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE></TITLE>
<META http-equiv=content-type content="text/html; charset=gb2312">
<SCRIPT language=JavaScript src="js/function-no-status-msg.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/function-no-copying.js"></SCRIPT>
<SCRIPT>if(self == top) location='http://3stara.net'
;</SCRIPT>

<META http-equiv=Content-Type content="text/html; charset=big5">
<SCRIPT language=JavaScript>
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</SCRIPT>

<STYLE type=text/css>.style1 {
	COLOR: #ffffff
}
BODY {
	MARGIN-TOP: 50px
}
</STYLE>
<LINK href="css/mem_index.css" type=text/css rel=stylesheet>
<META content="MSHTML 6.00.3790.279" name=GENERATOR></HEAD>
<BODY text=#000000 bgColor=#ffffff leftMargin=0 topMargin=0 marginwidth="0">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD align=middle>
      <TABLE cellSpacing=0 cellPadding=0 width=776 border=0>
        <TBODY>
        <TR>
          <TD><IMG height=44 src="images/index_ph000.jpg" width=161></TD>
          <TD>&nbsp;</TD>
          <TD vAlign=bottom>
            <TABLE cellSpacing=0 cellPadding=0 width=270 border=0>
              <TBODY>
              <TR>
                <TD width="82"><A 
                  href="Logint.aspx"><IMG 
                  src="images/index_tw2.gif" border=0 width="71" height="25"></A></TD>
                <TD width="69"><A 
                  href="Login.aspx"><IMG 
                  src="images/index_cn2.gif" border=0></A></TD>
                <TD width="102"><A 
                  href="Logine.aspx"><IMG 
                  src="images/index_us2.gif" border=0 width="50" height="25"></A></TD>
                <TD width="17">&nbsp;</TD>
              </TR></TBODY></TABLE></TD>
          <TD>&nbsp;</TD></TR>
        <TR>
          <TD><IMG height=69 src="images/index_ph011.jpg" width=161></TD>
          <TD><IMG height=69 src="images/index_ph012.jpg" width=148></TD>
          <TD align=left><IMG height=69 src="images/login_tw.jpg" 
            width=125></TD>
          <TD>&nbsp;</TD></TR>
        <TR>
          <TD><IMG height=175 src="images/index_ph021.jpg" width=161></TD>
          <TD><IMG height=175 src="images/index_ph022.jpg" width=148></TD>
          <TD vAlign=top align=middle width=270 
          background=images/index_ph023b.jpg>
            <TABLE class=login cellSpacing=0 cellPadding=0 width=266 border=0>
            <FORM id="Form1" runat="server">
              <TBODY>
              <TR>
                <TD  align="right">username:</TD>
                <TD width="150"><INPUT 
                                style="BORDER-RIGHT: #aaaeaf 1px solid; BORDER-TOP: #aaaeaf 1px solid; PADDING-LEFT: 3px; FONT-SIZE: 11px; BORDER-LEFT: #aaaeaf 1px solid; WIDTH: 120px; COLOR: mediumblue; BORDER-BOTTOM: #aaaeaf 1px solid; FONT-FAMILY: arial; HEIGHT: 18px" 
                                maxLength=12 name=TextBoxUserName> </TD>
              <TR>
                <TD align="right">password:</TD>
                <TD><INPUT 
                                style="BORDER-RIGHT: #aaaeaf 1px solid; BORDER-TOP: #aaaeaf 1px solid; PADDING-LEFT: 3px; FONT-SIZE: 11px; BORDER-LEFT: #aaaeaf 1px solid; WIDTH: 120px; COLOR: mediumblue; BORDER-BOTTOM: #aaaeaf 1px solid; FONT-FAMILY: arial; HEIGHT: 18px" 
                                type=password maxLength=15 name=TextBoxUserPass> 
              </TD></TR>
              <TR>
                <TD>&nbsp;</TD>
                <TD><INPUT class=za_button type=submit value=确定 name=fr_login> 
                </TD></TR></FORM></TABLE></TD>
          <TD><IMG height=175 src="images/index_ph024.jpg" 
        width=197></TD></TR></TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=776 border=0>
        <TBODY>
        <TR>
          <TD height=60>
            <TABLE class=tab-about cellSpacing=0 cellPadding=0 width=400 
            border=0>
              <TBODY>
              <TR class=dot><!--<td><a href="http://tp168.net/app/member/index_data/about.php?uid=44565d7470ae0b2&langx=zh-tw">關於我們</a></td>
                <td><a href="http://tp168.net/app/member/index_data/roul.php?uid=44565d7470ae0b2&langx=zh-tw">規則說明</a></td>
                <td><a href="http://tp168.net/app/member/index_data/week_game.php?uid=44565d7470ae0b2&langx=zh-tw">一周賽事</a></td>-->
                <TD><A 
href="http://tp168.net/app/member/index_data/contact.php?uid=549d6d3c5d20d7be&amp;langx=en-us">Contact us</A></TD>
              </TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD align=middle height=47>Copyright by fy333 Online Corporation. Better view and performance with IE 6.0 1027*768 or above.<U><FONT color=#ff3333>vip@wi168.com</FONT></U></TD>
        </TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
