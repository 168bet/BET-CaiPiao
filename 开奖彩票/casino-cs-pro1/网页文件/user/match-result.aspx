<%@ Page language="c#" Codebehind="match-result.aspx.cs" AutoEventWireup="false" Inherits="newball.user.match_result" codePage="936"%>
<html>
<head>
<title>LT_result</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="css/client_LT_game.css" type="text/css">
</head>

<Script Language="JavaScript">
if(self == top) location = '/';
parent.bbnet_mem_order.location.href= 'betting-entry.aspx';
</Script>
<body bgcolor="#E5EAEE" leftmargin="0" topmargin="0" oncontextmenu="window.event.returnValue=false">
<form id="myFORM" method="post" runat="server">
<table width="546" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr><td valign="top" bgcolor="#E5EAEE">
      <table width="96%" height="96" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr><td height="100%" colspan="3"><TABLE cellSpacing=1 cellPadding=0 width=500 border=0>
              <TBODY>
                <TR>
                  <TD><table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height=5></td>
  </tr>
  <tr>
    <td><table width=100% border=0 align="left" cellpadding=2 cellspacing=0>
      <tbody>
        <tr>
          <td width=99% class=td_02 bgcolor="#CCCCCC"><font size=2>
            <marquee scrolldelay=120 class="td_02">
            <span id="Msg"><%# msg %></span>
            </marquee>
          </font>
          </td>
        </tr>
      </tbody>
    </table>
    </td>
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
                  <TD>
                  <table class=table_banner cellSpacing=0 cellPadding=0 width="500" border=0>
                  	<tr>
                  	  <td>
                      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 class="banner_set" height="24">
                        <TR bgcolor="#C1D7E5">
                          <TD width=130 height=12><a href="http://www.hkjc.com/chinese/mark6/results.asp"  target="_blank">香港马会开奖结果</a></TD>
                          <TD height="12" width="50">&nbsp; </TD>
                          <td width="200" align="right">总页数:
                            <select name="page" onChange="self.myFORM.submit()" class="zaselect_ste">
                                                       <%# pageorder %>           </td>
                        </TR>
                      </TABLE>
                      </td>
                    </tr>
                  </table>
                  </TD>
                </TR>
              
            </TABLE>
            <TABLE class=table_title_line height=8 cellSpacing=0 cellPadding=0 width=500 border=0>
              <TBODY>
                <TR>
                  <TD> <TABLE width="100%" border=1>
                      <TBODY>
                        <TR class=tr_title_set_cen>
                          <TD width="10%" rowSpan=2 bgcolor="#C1D7E5" align="center">期数</TD>
                          <TD rowSpan=2 nowrap bgcolor="#A4C6DB">
                            <div align="center">时间</div></TD>
                          <TD colSpan=8 bgcolor="#9D2E2E" class="title_00"><div align="center">彩球号码</div></TD>
                        </TR>
                        <TR class=tr_title_set_cen>
                          <TD width="9%" bgcolor="#B9C0C4" class="title_02" align="center">正码一</TD>
                          <TD width="9%" bgcolor="#B9C0C4" class="title_02" align="center">正码二</TD>
                          <TD width="9%" bgcolor="#B9C0C4" class="title_02" align="center">正码三</TD>
                          <TD width="9%" bgcolor="#B9C0C4" class="title_02" align="center">正码四</TD>
                          <TD width="9%" bgcolor="#B9C0C4" class="title_02" align="center">正码五</TD>
                          <TD width="9%" bgcolor="#B9C0C4" class="title_02" align="center">正码六</TD>
                          <TD width="9%" bgcolor="#B9C0C4" class="title_02" align="center">特别号</TD>
                          <TD width="9%" bgcolor="#B9C0C4" class="title_02" align="center">总合</TD>
                        </TR>
                         <%# kyglcontent%>
                       
                    </TABLE></TD>
                </TR>
              </TBODY>
            </TABLE></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</body>
</html>
