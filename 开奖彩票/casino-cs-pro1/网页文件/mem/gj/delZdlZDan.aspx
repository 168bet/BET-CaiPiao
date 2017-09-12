<%@ Page language="c#" Codebehind="delZdlZDan.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.gj.delZDan1" %>
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
			<table cellspacing="1" cellpadding="0" width="80%" border="0" bgcolor="#000000">
				<tr class="blueheader">
					<td colSpan="4">删除总代理注单信息</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td align="center">选择总代理</td>
					<td align="left">
						<asp:DropDownList ID="selects" Runat="server">
							<ASP:LISTITEM Selected="True" Value=""></ASP:LISTITEM>
						</asp:DropDownList>
					</td>
					<td align="center">日 期</td>
					<td>
						<asp:TextBox ID="starTime" Font-Size="10" MaxLength="10" Columns="10" Runat="server" ReadOnly="True"></asp:TextBox>
						<IMG src="../images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'delZdlZDan.starTime',true,'yyyy-mm-dd'); return false;"
							style="CURSOR: hand">到
						<asp:TextBox ID="endTime" Font-Size="10" MaxLength="10" Columns="10" Runat="server" ReadOnly="True"></asp:TextBox>
						<IMG src="../images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'delZdlZDan.endTime',true,'yyyy-mm-dd'); return false;"
							style="CURSOR: hand">
					</td>
				</tr>
				<tr align="center" bgcolor="#ffffff">
					<td colSpan="4" height="30" valign="middle">
						<asp:Button ID="submit" Text="删   除" Runat="server" CssClass="text"></asp:Button>&nbsp;&nbsp;
						<asp:Button ID="back" Text="返   回" Runat="server" CssClass="text"></asp:Button>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
