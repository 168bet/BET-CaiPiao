<%@ Page language="c#" Codebehind="tzinfo.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.tzinfo" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>tzinfo</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body>
		<form id="Form1" method="post" runat="server">
			<table border="0" cellpadding="0" cellspacing="0" width="780">
				<tr>
					<td class="m_tline">
						&nbsp;&nbsp;ע��&nbsp;&nbsp;&nbsp;&nbsp; ��
						<asp:DropDownList ID="thePages" Runat="server" AutoPostBack="True">
							<asp:ListItem Value="all">ȫ��</asp:ListItem>
						</asp:DropDownList>/<asp:Label ID="sumPages" Runat="server"></asp:Label>ҳ&nbsp;&nbsp;&nbsp;&nbsp; 
						-<a href="javascript:window.history.back();">����</a>&nbsp;&nbsp; -<a href="javascript:window.location.reload();">����</a>&nbsp;&nbsp; 
						-<a href="javascript:window.print();">��ӡ</a>
					</td>
					<td width="30"><img src="images/top_04.gif" width="30" height="24"></td>
				</tr>
				<tr>
					<td colspan="2" height="4"></td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" id="showContent" runat="server" width="755">
				<tr>
					<td></td>
				</tr>
			</table>
			<input type="hidden" id="ballid" runat="server"> <input type="hidden" id="marker" runat="server">
			<input type="hidden" id="tzType" runat="server">
		</form>
	</body>
</HTML>
