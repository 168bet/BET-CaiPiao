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
					<td width="100%" height="22">&nbsp;ϵͳά��&nbsp;--&nbsp; <A href="chglists.aspx">������ҳ</A>
					</td>
				</tr>
			</table>
			<table id="tableconfig" cellSpacing="1" cellPadding="0" width="778" bgColor="#cccccc" border="0" runat="server">
				<tr class="blueheader" height="25">
					<td colSpan="2">ϵͳά������</td>
				</tr>
				<tr>
					<td class="TableBody1" vAlign="middle" align="center" width="80" height="22">ǰ̨��Ϣ</td>
					<td class="TableBody1"><asp:textbox id="frontContent" Runat="server" TextMode="MultiLine" Rows="5" Columns="80"></asp:textbox></td>
				</tr>
				<tr>
					<td class="TableBody1" vAlign="middle" align="center" width="80" height="22">��̨��Ϣ</td>
					<td class="TableBody1"><asp:textbox id="befindContent" Runat="server" TextMode="MultiLine" Rows="5" Columns="80"></asp:textbox></td>
				</tr>
				<tr>
					<td class="TableBody1" vAlign="middle" align="center" width="80" height="22">�Ƿ�ά��</td>
					<td class="TableBody1">
						ǰ̨��
						<asp:dropdownlist id="isFront" Runat="server">
							<asp:ListItem Value="0" Selected="True">��</asp:ListItem>
							<asp:ListItem Value="1">��</asp:ListItem>
						</asp:dropdownlist>
						��̨��
						<asp:dropdownlist id="isBehind" Runat="server">
							<asp:ListItem Value="0" Selected="True">��</asp:ListItem>
							<asp:ListItem Value="1">��</asp:ListItem>
						</asp:dropdownlist>
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="center" colSpan="2"><asp:button id="submitbutton" Runat="server" CssClass="Text" Text="ȷ ��"></asp:button></td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
