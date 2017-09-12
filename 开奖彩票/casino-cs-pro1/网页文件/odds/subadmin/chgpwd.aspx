<%@ Page language="c#" Codebehind="chgpwd.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.subadmin.chgpwd" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>chgpwd</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<link href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body>
		<form id="Form1" method="post" runat="server">
			<table border="0" align="center" height="112" width="312" cellSpacing="1" cellPadding="1"
				bgcolor="#000000">
				<tr>
					<td colspan="2" align="center" class="blueheader" height="25">更改密码</td>
				</tr>
				<TR>
					<TD class="TableBody1" align="center"><FONT face="宋体">旧密码</FONT></TD>
					<TD class="TableBody1" align="center">
						<asp:TextBox id="TextBoxOldPassWord" runat="server" Width="100px" CssClass="Text" TextMode="Password"
							Columns="10"></asp:TextBox></TD>
				</TR>
				<tr>
					<td align="center" class="TableBody1">
						新密码</td>
					<td align="center" class="TableBody1"><asp:TextBox runat="server" Columns="10" ID="newPwd1" TextMode="Password" CssClass="Text" Width="100px"></asp:TextBox></td>
				</tr>
				<tr>
					<td align="center" class="TableBody1">确认密码</td>
					<td align="center" class="TableBody1"><asp:TextBox runat="server" Columns="10" ID="newPwd2" TextMode="Password" CssClass="Text" Width="100px"></asp:TextBox></td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="TableBody1">
						<asp:Button ID="submit" Runat="server" CssClass="Text" Text="更 改"></asp:Button>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
