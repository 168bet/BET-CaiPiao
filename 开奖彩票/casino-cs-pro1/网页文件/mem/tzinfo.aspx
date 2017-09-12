<%@ Page language="c#" Codebehind="tzinfo.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.tzinfo" %>
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
	<body topmargin="1" leftmargin="2">
		<form id="Form1" method="post" runat="server">
			<table border="0" cellpadding="0" cellspacing="0" width="780">
				<tr>
					<td>
						&nbsp;&nbsp;注单&nbsp;&nbsp;&nbsp;&nbsp; 第
						<asp:DropDownList ID="thePages" Runat="server" AutoPostBack="True">
							<asp:ListItem Value="all">全部</asp:ListItem>
						</asp:DropDownList>/<asp:Label ID="sumPages" Runat="server"></asp:Label>页&nbsp;&nbsp;&nbsp;&nbsp; 
						-<a href="javascript:window.history.back();">返回</a>&nbsp;&nbsp; -<a href="javascript:window.location.reload();">更新</a>&nbsp;&nbsp; 
						-<a href="javascript:window.print();">打印</a>
					</td>
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
			<input type="hidden" id="ballid" runat="server" NAME="ballid"> <input type="hidden" id="marker" runat="server" NAME="marker">
			<input type="hidden" id="tzType" runat="server" NAME="tzType">
		</form>
	</body>
</HTML>
