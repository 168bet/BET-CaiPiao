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
			TD { FONT-SIZE: 8pt; FONT-FAMILY: "Arial","����" }
		</style>
	</HEAD>
	<body topmargin="4">
		<form id="mySettingForm" method="post" runat="server">
			<table width="1000" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="m_tline">&nbsp;&nbsp;�趨&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;��˾��&nbsp;<asp:Label ID="username" Runat="server">name</asp:Label>&nbsp;&nbsp;
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
                <td height="18" colspan="15" bgcolor="white">&nbsp;&nbsp;���ö�ȣ�</td>
              </tr>
              <tr class="dlsheader" align="center" style="COLOR:#ffffff" height="22">
                <td>��Ŀ</td>
                <td>�ر��</td>
                <td>�ر�ŵ�˫</td>
                <td>�ر�Ŵ�С</td>
                <td>�ر�ź�����˫</td>
                <td>����</td>
                <td>�ܺ͵�˫</td>
                <td>�ܺʹ�С</td>
                <td>��ȫ��</td>
                <td>��ȫ��</td>
                <td>���ж�</td>
                <td>������</td>
                <td>�ش�</td>
                <td>�������</td>
                <td>ɫ��</td>
              </tr>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">��ע�޶�</td>
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
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">����(��)�޶�</td>
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
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">��ˮA W/L</td>
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
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">��ˮB W/L</td>
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
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">��ˮC W/L</td>
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
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">��ˮD W/L</td>
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
                <TD width="68">��Ŀ</TD>
                <TD width="77">��Ф</TD>
                <TD width="77">����1-6��˫</TD>
                <TD width="77">����1-6��С</TD>
                <TD width="77">����1-6ɫ��</TD>
                <TD width="77">һФ</TD>
                <TD width="77">��Ф</TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">����(��)�޶�</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">��ע�޶�</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">��ˮA W/L</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">��ˮB W/L</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">��ˮC W/L</TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
                <TD></TD>
              </TR>
              <tr class="TableBody1" align="center">
                <td class="dlsheader" nowrap style="FONT-SIZE: 9pt">��ˮD W/L</TD>
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
