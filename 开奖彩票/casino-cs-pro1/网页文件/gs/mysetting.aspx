<%@ Page language="c#" Codebehind="mysetting.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.mysetting" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>mysetting</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link rel="stylesheet" href="css/css.css" type="text/css">
		<style type="text/css">
			TD { FONT-SIZE: 8pt; FONT-FAMILY: "Arial","宋体" }
		</style>
	</HEAD>
	<body topmargin="4">
		<form id="mySettingForm" method="post" runat="server">
			<table width="1000" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="m_tline">&nbsp;&nbsp;设定&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;公司：&nbsp;<asp:Label ID="username" Runat="server">name</asp:Label>&nbsp;&nbsp;
					</td>
					<td width="30"></td>
				</tr>
				<tr>
					<td colspan="2" height="4"></td>
				</tr>
		  </table>
			<table border="0" cellpadding="2" cellspacing="1" bgcolor="#000000" width="1000" id="myFootballTable"
				runat="server">
              <tr>
                <td height="18" colspan="15" bgcolor="white">&nbsp;&nbsp;信用额度：</td>
              </tr>
              <tr class="dlsheader" align="center" style="COLOR:#ffffff" height="22">
                <td>项目</td>
                <td>特别号</td>
                <td>特别号单双</td>
                <td>特别号大小</td>
                <td>特别号合数单双</td>
                <td>正码</td>
                <td>总和单双</td>
                <td>总和大小</td>
                <td>二全中</td>
                <td>三全中</td>
                <td>三中二</td>
                <td>二中特</td>
                <td>特串</td>
                <td>正码过关</td>
                <td>色波</td>
              </tr>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">单注限额</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">单项(号)限额</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">退水A W/L</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">退水B W/L</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">退水C W/L</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">退水D W/L</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
          </table>
			<table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="8"></td>
              </tr>
            </table>
			<TABLE id="BKTable" cellSpacing="1" cellPadding="0" width="530" bgColor="#000000" border="0"
				runat="server">
              <TR class="dlsheader">
                <TD width="68">项目</TD>
                <TD width="77">生肖</TD>
                <TD width="77">正码1-6单双</TD>
                <TD width="77">正码1-6大小</TD>
                <TD width="77">正码1-6色波</TD>
                <TD width="77">一肖</TD>
                <TD width="77">六肖</TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">单项(号)限额</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">单注限额</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">退水A W/L</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">退水B W/L</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">退水C W/L</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">退水D W/L</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
            </TABLE>
		</form>
	</body>
</HTML>
