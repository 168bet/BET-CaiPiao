<%@ Page language="c#" Codebehind="delGdZDan.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.gj.delGdZDan" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>ɾ���ɶ�ע��</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<link rel="stylesheet" type="text/css" href="../css/css.css">
		<link href="../css/rep.css" type="text/css" rel="stylesheet">
		<script language="JavaScript" src="../js/calendar.js" type="text/JavaScript"></script>
	</HEAD>
	<body text="#000000" vLink="#cc0000" aLink="#cc0000" leftMargin="8" topMargin="10">
		<form id="delGdZDan" method="post" runat="server">
			<table cellSpacing="1" cellPadding="0" width="80%" border="0" bgcolor="#000000">
				<tr class="blueheader">
					<td colSpan="4">ɾ���ɶ�ע����Ϣ</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td align=center>ѡ��ɶ�</td>
					<td align="left">
						<asp:dropdownlist id="selects" Runat="server">
							<asp:ListItem Value=""></asp:ListItem>
						</asp:dropdownlist></td>
					<td align=center>�� ��</td>
					<td>
						<asp:textbox id="starTime" Runat="server" Font-Size="10" MaxLength="10" Columns="10" ReadOnly=True></asp:textbox>
						<IMG src="../images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'delGdZDan.starTime',true,'yyyy-mm-dd'); return false;" style="CURSOR: hand;">��
						<asp:textbox id="endTime" Runat="server" Font-Size="10" MaxLength="10" Columns="10" ReadOnly=True></asp:textbox>
						<IMG src="../images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'delGdZDan.endTime',true,'yyyy-mm-dd'); return false;" style="CURSOR: hand;">
					</td>
				</tr>
				<tr align="center" bgcolor="#ffffff">
					<td colSpan="4" height="30" valign="middle">
						<asp:button id="del" Runat="server" Text="ɾ   ��" CssClass="text"></asp:button>&nbsp;&nbsp;
						<asp:button id="back" Runat="server" Text="��   ��" CssClass="text"></asp:button>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
