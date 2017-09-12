<%@ Page language="c#" Codebehind="vindicate.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.gj.tex" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>mgrConfig</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="../css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="1" topMargin="1">
		<form id="myFORM" method="post" runat="server">
			<table id="tabletitle" cellSpacing="0" cellPadding="0" width="778" border="0" runat="server">
				<tr vAlign="middle">
					<td width="100%" height="22">&nbsp;系统维护&nbsp;--&nbsp; <A href="chglists.aspx">返回上页</A>
					</td>
				</tr>
			</table>
			<table id="tableconfig" cellSpacing="1" cellPadding="0" width="778" bgColor="#cccccc" border="0" runat="server">
				<tr class="blueheader" height="25">
					<td colSpan="2">系统维护设置</td>
				</tr>
				<tr>
					<td class="TableBody1" vAlign="middle" align="center" width="80" height="22">前台信息</td>
					<td class="TableBody1"><asp:textbox id="frontContent" Runat="server" TextMode="MultiLine" Rows="5" Columns="80"></asp:textbox></td>
				</tr>
				<tr>
					<td class="TableBody1" vAlign="middle" align="center" width="80" height="22">后台信息</td>
					<td class="TableBody1"><asp:textbox id="befindContent" Runat="server" TextMode="MultiLine" Rows="5" Columns="80"></asp:textbox></td>
				</tr>
				<tr>
					<td class="TableBody1" vAlign="middle" align="center" width="80" height="22">是否维护</td>
					<td class="TableBody1">
						前台：
						<asp:dropdownlist id="isFront" Runat="server">
							<asp:ListItem Value="0" Selected="True">否</asp:ListItem>
							<asp:ListItem Value="1">是</asp:ListItem>
						</asp:dropdownlist>
						后台：
						<asp:dropdownlist id="isBehind" Runat="server">
							<asp:ListItem Value="0" Selected="True">否</asp:ListItem>
							<asp:ListItem Value="1">是</asp:ListItem>
						</asp:dropdownlist>
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="center" colSpan="2"><asp:button id="submitbutton" Runat="server" CssClass="Text" Text="确 定"></asp:button></td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
