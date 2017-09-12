<%@ Page language="c#" Codebehind="mgrConfig.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.subadmin.mgrConfig" validateRequest=false codePage="936"%>
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
					<td colSpan="8">新增网站公告</td>
				</tr>
				<tr>
					<td class="TableBody1" align="center" width="51" height="22">公告类型</td>
					<td width="78" class="TableBody1"><asp:dropdownlist id="le" Runat="server">
							<asp:ListItem Value="1" Selected="True">前台信息</asp:ListItem>
							<asp:ListItem Value="2" Selected="False">后台信息</asp:ListItem>
						</asp:dropdownlist></td>
					<td class="TableBody1" align="center" width="67" height="22">开赛时间</td>
					<td width="141" class="TableBody1"><asp:textbox class="Text1" id="kaisai" type="text" size="20" name="kaisai" runat="server"></asp:textbox></td>
					<td width="64" class="TableBody1">收特码时间
					</td>
					<td width="175" class="TableBody1">&nbsp;
						<asp:TextBox id="TUpdateTime" runat="server"></asp:TextBox></td>
					<td class="TableBody1" align="center" width="59" height="22">期数</td>
					<td width="134" class="TableBody1"><asp:textbox class="Text1" id="qishu" type="text" size="20" name="qishu" runat="server"></asp:textbox></td>
				</tr>
				<tr>
					<td class="TableBody1" vAlign="middle" align="center" width="51" height="22">公告内容</td>
					<td class="TableBody1" colspan="7"><asp:textbox id="content" Runat="server" Columns="80" Rows="5" TextMode="MultiLine"></asp:textbox></td>
				</tr>
				<tr>
					<td class="TableBody1" vAlign="middle" align="center" width="51" height="22">是否开盘</td>
					<td class="TableBody1" colspan="7"><asp:dropdownlist id="kaipan" Runat="server">
							<asp:ListItem Value="0">开盘</asp:ListItem>
							<asp:ListItem Value="1">封盘</asp:ListItem>
						</asp:dropdownlist></td>
				</tr>
				<tr>
					<td class="TableBody1" align="center" colspan="8"><asp:button id="submitbutton" Runat="server" Text="新 增" CssClass="Text"></asp:button></td>
				</tr>
			</table>
			<input id="configid" type="hidden" runat="server" NAME="configid">
		</form>
	</body>
</HTML>
