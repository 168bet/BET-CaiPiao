<%@ Page language="c#" Codebehind="zdladd.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.zdladd" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>gdadd</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="1" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="宋体">
				<TABLE id="Table1" cellSpacing="1" cellPadding="3" width="700" border="0">
					<TR>
						<TD colSpan="3"><FONT face="宋体">
								&nbsp;添加总代理&nbsp; --<A href="javascript:history.back(1);">返回上页</A></FONT>
						</TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="3" width="100%" bgColor="#000000" border="0">
								<TR>
									<TD class="pinkheader" align="center" colSpan="2">基本资料设定</TD>
								</TR>
								<tr>
									<td class="TableBody1" style="WIDTH: 182px" align="right"><FONT face="宋体">股东:</FONT></td>
									<TD class="TableBody1">
										<asp:DropDownList ID="DropDownListGd" Runat="server" BorderWidth="1px" CssClass="Text"></asp:DropDownList>
									</TD>
								</tr>
								<TR>
									<TD class="TableBody1" style="WIDTH: 182px" align="right"><FONT face="宋体">帐号:</FONT></TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxUserName" runat="server" BorderWidth="1px" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">密码:</FONT></TD>
									<TD class="TableBody1"><FONT face="宋体" color="#ff0000">
											<asp:TextBox id="TextBoxNewpass1" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">确定密码:</FONT></TD>
									<TD class="TableBody1"><FONT face="宋体" color="#ff0000">
											<asp:TextBox id="TextBoxNewpass2" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">总代理名称:</FONT></TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxTrueName" runat="server" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">电话:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxTel" runat="server" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">帐号状态:</FONT></TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropDownListIsUseAble" runat="server">
											<asp:ListItem Value="1" Selected="True">启用</asp:ListItem>
											<asp:ListItem Value="0">停用</asp:ListItem>
										</asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">总信用额度:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxUseMoney" runat="server" CssClass="Text">0</asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">最大会员数:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxMaxMem" runat="server" CssClass="Text">0</asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="center" colSpan="2"><FONT face="宋体">
											<asp:Button id="ButtonSave" runat="server" CssClass="Text" Text="保 存"></asp:Button>&nbsp;&nbsp;
											<asp:Button id="ButtonCancel" runat="server" CssClass="Text" Text="取 消"></asp:Button></FONT></TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="宋体"></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3"></TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="宋体"></FONT></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
	</body>
</HTML>
