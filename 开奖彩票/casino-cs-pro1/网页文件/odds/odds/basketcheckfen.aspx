<%@ Page language="c#" Codebehind="basketcheckfen.aspx.cs" AutoEventWireup="false" Inherits="odds.odds.basketcheckfen" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>GameFen</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<BODY leftMargin="1" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<table width="730" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="HEIGHT: 18px">&nbsp;</td>
					<td align="right" style="HEIGHT: 18px">
						<asp:DropDownList id="SelectDay" runat="server" AutoPostBack="True"></asp:DropDownList>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="730" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
							<tr class="blueheader">
								<td width="60">时间</td>
								<td width="60">球赛ID</td>
								<td width="150">联赛名</td>
								<td width="135">主队</td>
								<td width="135">客队</td>
								<!--<td width="90">上半场比分</td>-->
								<td width="90">全场比分</td>
							</tr>
							<%# kyglContent %>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</BODY>
</HTML>
