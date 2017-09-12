<%@ Page language="c#" Codebehind="chgpwd.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.chgpwd" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>chgpwd</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link href="css/css.css" rel="stylesheet" type="text/css">
	</HEAD>
	<body>
		<form id="Form1" method="post" runat="server">
		<table border=0 ><tr><td height=10></td></tr></table>
			<table border="0" align="center" height="112" width="312" cellSpacing="1" cellPadding="0" class="tableNoBorder1">
				<tr>
					<td colspan="2" class="dlsheader"><font color="white">：：更改密码：：</font></td>
				</tr>
				<tr class=TableBody1>
					<td align="center">
						<font color="darkgray">新 密 码</font></td>
					<td align="center"><asp:TextBox runat="server" Columns="10" ID="newPwd1" TextMode="Password" CssClass="Text"></asp:TextBox></td>
				</tr>
				<tr class=TableBody1>
					<td align="center"><font color="darkgray">确认密码</font></td>
					<td align="center"><asp:TextBox runat="server" Columns="10" ID="newPwd2" TextMode="Password" CssClass="Text"></asp:TextBox></td>
				</tr>
				<tr class=TableBody1>
					<td colspan="2" align="center">
						<asp:Button ID="submit" Runat="server" BorderStyle="Solid" BorderWidth="1px" BorderColor="#888888"
							Font-Size="8" BackColor="#cccccc" Text="更 改" ForeColor="white"></asp:Button>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
