<%@ Page language="c#" Codebehind="delMUser.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.gj.delMUser" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>删除会员和所有注单</title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<link rel="stylesheet" type="text/css" href="../css/css.css">
		<link href="../css/rep.css" type="text/css" rel="stylesheet">
		<script language="JavaScript" src="../js/calendar.js" type="text/JavaScript"></script>
	</HEAD>
	<body leftmargin="8" topmargin="10" text="#000000" vlink="#cc0000" alink="#cc0000">
		<form id="delUserInf" runat="server">
			<table cellSpacing="1" cellPadding="0" width="700" border="0" height="95" bgcolor="#000000">
				<tr class="blueheader">
					<td colSpan="6">删除会员和所有注单</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td align="center" height="25">会员帐户</td>
					<td align="left" height="25"><asp:textbox id="username" Runat="server" Font-Size="10" Columns="16"></asp:textbox></td>
					<td align="center" height="25">选择类型</td>
					<td align="left" height="25">
						<asp:dropdownlist id="selects" Runat="server">
							<asp:ListItem Value="1">删除会员</asp:ListItem>
							<asp:ListItem Value="2" Selected="True">删除注单</asp:ListItem>
						</asp:dropdownlist>
					</td>
					<td align="center" height="25">日 期</td>
					<td height="25">
						<asp:textbox id="starTime" Runat="server" Font-Size="10" Columns="10" MaxLength="10" ReadOnly="True"></asp:textbox>
						<IMG src="../images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'delUserInf.starTime',true,'yyyy-mm-dd'); return false;"
							style="CURSOR: hand">到
						<asp:textbox id="endTime" Runat="server" Font-Size="10" Columns="10" MaxLength="10" ReadOnly="True"></asp:textbox>
						<IMG src="../images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'delUserInf.endTime',true,'yyyy-mm-dd'); return false;"
							style="CURSOR: hand">
					</td>
				</tr>
				<tr align="center" bgcolor="#ffffff">
					<td colSpan="6" height="30" valign="middle">
						<asp:button ID="del" Text="删   除" Runat="server" CssClass="text"></asp:button>&nbsp;&nbsp;
						<asp:Button ID="back" Text="返   回" Runat="server" CssClass="text"></asp:Button>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
