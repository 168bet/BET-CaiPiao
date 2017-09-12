<%@ Page language="c#" Codebehind="mgrConfig.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.mgrConfig" validateRequest=false codePage="936"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>mgrConfig</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<link href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body topmargin="1" leftmargin="1">
		<form id="myFORM" method="post" runat="server">
			<table cellSpacing="0" cellPadding="0" width="778" border="0" id="tabletitle" runat="server">
				<tr vAlign="middle">
					<td width="100%" height="22">
						&nbsp;公告管理&nbsp;&gt;&gt;新增&nbsp;--&nbsp; <a href='mgrconfiglist.aspx'>返回上页</a>
					</td>
				</tr>
			</table>
			<table id="tableconfig" cellSpacing="1" cellPadding="0" width="778" bgColor="#cccccc" border="0"
				runat="server">
				<tr class="blueheader" height="25">
					<td colSpan="6">新增网站公告</td>
				</tr>
				<tr>
					<td class="TableBody1" align="center" width="60" height="22">公告类型</td>
					<td class="TableBody1"><asp:dropdownlist id="le" Runat="server">
							<asp:ListItem Value="1" Selected="True">前台信息</asp:ListItem>
							<asp:ListItem Value="2" Selected="False">后台信息</asp:ListItem>
						</asp:dropdownlist></td>
					<td class="TableBody1" align="center" width="60" height="22">开赛时间</td>
					<td class="TableBody1"><asp:textbox class="Text1" id="kaisai" type="text" size="20" name="kaisai" runat="server"></asp:textbox></td>
					<td class="TableBody1" align="center" width="60" height="22">期数</td>
					<td class="TableBody1"><asp:textbox class="Text1" id="qishu" type="text" size="20" name="qishu" runat="server"></asp:textbox></td>
				</tr>
				<tr>
					<td class="TableBody1" vAlign="middle" align="center" width="60" height="22">公告内容</td>
					<td class="TableBody1" colspan="5"><asp:textbox id="content" Runat="server" Columns="80" Rows="5" TextMode="MultiLine"></asp:textbox></td>
				</tr>
				<tr>
					<td class="TableBody1" align="center" colspan="6"><asp:button id="submitbutton" Runat="server" Text="新 增" CssClass="Text"></asp:button></td>
				</tr>
			</table>
			<input id="configid" type="hidden" runat="server" NAME="configid">
		</form>
	</body>
</HTML>
