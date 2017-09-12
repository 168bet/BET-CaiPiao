<%@ Page language="c#" Codebehind="Online.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.online.MgrOnline" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>MgrOnline</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<meta http-equiv="refresh" content="60" url="MgrOnline.aspx?kygl=<%# kyglClass %>">
		<LINK href="../css/css.css" type="text/css" rel="stylesheet">
		<script src="../js/std.js"></script>
	</HEAD>
	<body text="#000000" vLink="#0000ff" aLink="#0000ff" bgColor="#ffffff" leftMargin="2"
		topMargin="2">
		<form name="Form1" method="post" runat="server" id="Form1">
			<TABLE id="OnlineListTable" cellSpacing="0" cellPadding="0" width="850" border="0" runat="server">				
				<TR>
					<TD nowrap>
						<asp:dropdownlist id="DropDownListShowType" runat="server" Width="104px">
							<asp:ListItem Value="0">全部</asp:ListItem>
							<asp:ListItem Value="1" Selected="True">管理员</asp:ListItem>
							<asp:ListItem Value="2">股东</asp:ListItem>
							<asp:ListItem Value="3">总代理</asp:ListItem>
							<asp:ListItem Value="4">代理商</asp:ListItem>
							<asp:ListItem Value="20">会员</asp:ListItem>
							<asp:ListItem Value="22">股东子帐户</asp:ListItem>
							<asp:ListItem Value="33">总代理子帐户</asp:ListItem>
							<asp:ListItem Value="44">代理商子帐户</asp:ListItem>
						</asp:dropdownlist><INPUT style="WIDTH: 50px" onclick="javascript:window.location.href='mgronline.aspx?kygl=<%# kyglClass %>';"
							type="button" value="刷 新">60秒刷新&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 用户查找
						<asp:TextBox id="TextBoxSelUser" runat="server" Width="80px" CssClass="text"></asp:TextBox>
						<asp:Button id="Button1" runat="server" Width="50px" Text="查找"></asp:Button>(多个用","号间隔)
					</TD>
					<td nowrap align=right>删除两天前的记录
						<asp:button id="ButtonDelEvent" runat="server" Width="50px" Text="删 除"></asp:button>
					</td>
				</TR>
				<TR>
					<TD colSpan="2" height=2></TD>
				</TR>
				<TR>
					<TD id="OnlineTableCell" align="center" colSpan="2"></TD>
				</TR>
				<TR>
					<TD align="center" colSpan="2"></TD>
				</TR>
			</TABLE>
		</form>
	</body>
</HTML>
