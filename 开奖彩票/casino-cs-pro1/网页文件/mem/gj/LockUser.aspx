<%@ Page language="c#" Codebehind="LockUser.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.gj.LockUser" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>删除总代理注单</title>
		<meta content="True" name="vs_showGrid">
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<link rel="stylesheet" type="text/css" href="../css/css.css">
		<link href="../css/rep.css" type="text/css" rel="stylesheet">
		<script language="JavaScript" src="../js/calendar.js" type="text/JavaScript"></script>
	</HEAD>
	<body text="#000000" vlink="#cc0000" alink="#cc0000" leftmargin="8" topmargin="10">
		<form id="delZdlZDan" method="post" runat="server">
			<table cellspacing="1" cellpadding="0" width="500" border="0" bgcolor="#000000">
				<tr class="blueheader">
					<td colspan="4">琐定用户</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td align="center">请输入用户名</td>
					
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						<asp:TextBox ID="userName" Font-Size="10" MaxLength="10" Columns="10" Runat="server" ></asp:TextBox>
					</td>
					<td height="30" valign="middle">&nbsp;&nbsp;
						<asp:Button ID="submit" Text="琐   定" Runat="server" CssClass="text"></asp:Button>&nbsp;&nbsp;
						<asp:Button ID="Button1" Text="解   琐" Runat="server" CssClass="text"></asp:Button>&nbsp;&nbsp;
						<asp:Button ID="back" Text="返   回" Runat="server" CssClass="text"></asp:Button>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
