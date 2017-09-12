<%@ Page language="c#" Codebehind="bets-enquiry.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.bets_enquiry" %>

<html>
<head>
<title>today_wagers</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="../user/css/client_LT_game.css" type="text/css">

<style type="text/css">
<!--
body {
	background-color: #E5EAEE;
}
-->
</style></head>

<SCRIPT LANGUAGE="JAVASCRIPT">
if(self == top) location = '/';
</SCRIPT>


<body leftmargin="0" topmargin="0" oncontextmenu="window.event.returnValue=false">
<table width="700" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top" bgcolor="#E5EAEE"> 
      <table width="96%" height="96" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="100%" colspan="3"><TABLE cellSpacing=1 cellPadding=0 width=500 border=0>
              <TBODY>
                <TR> 
                  <TD><table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height=5></td>
  </tr>
  
  <tr>
    <td height=5></td>
  </tr>
</table>      
</TD>
                </TR>
              </TBODY>
              <TBODY>
                <TR> 
                  <TD height=20>
                  <table class=table_banner cellSpacing=0 cellPadding=0 width="500" border=0>
                  	<tr>
                  	  <td>
                    <TABLE class=banner_set height=24 cellSpacing=0 cellPadding=0 width="100%" border=0>
                      <TBODY>
                      
                        <form name="myFORM" action="" method=GET>
                        <TR> 
                          <TD width=107 height=12>下注状况(<%# kyglName %>)</TD>
                          <TD width=441 height=12 align="right">
                      
                          </TD>
                        </TR>
                        </form>
                        
                      </TBODY>
                    </TABLE>
                      </td>
                    </tr>
                  </table>
                  </TD>
                </TR>
              </TBODY>
            </TABLE>
            <TABLE class=table_title_line cellSpacing=0 cellPadding=0 width=650 border=0>
              <TBODY>
                <TR> 
                  <TD height=5></TD>
                </TR>
                <TR> 
                  <TD><TABLE width="100%" border=1 >
                      <TBODY>
                        <TR align=middle class=tr_title_set_cen> 
                          <TD height="20" colSpan=6>日期: <%# datetime %></TD>
                        </TR>
                        <TR> 
                           <TD width=100 height="20" align="center">下注时间</TD>
                          <TD width=100 height="20" align="center">下注单号</TD>
                          <TD width=80 height="20" align="center">方式</TD>
                          <TD height="20" align="center" >内容</TD>
                          <TD width=50 height="20" align="center">下注金额</TD>
                          <TD width=50 height="20" align="center"><%# kyglTT %></TD>
                        </TR>
                        <%# kyglList %>
                        
                      </TBODY>
                    </TABLE> </TD>
                </TR>
              </TBODY>
            </TABLE> </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<BR>
			<table><tr><td align=center><%# System.Configuration.ConfigurationSettings.AppSettings["CopyRight"] %></td></tr></table>
</body>
</html>
