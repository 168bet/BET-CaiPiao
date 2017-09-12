<%@ Page language="c#" Codebehind="BfUser.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.odds.BfUser" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>BfUser</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="3" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="宋体">
				<TABLE id="Table1" cellSpacing="0" cellPadding="0" width="600" border="0">
					<TBODY>
						<TR>
							<TD width="250">比分员</TD>
							<TD align="right" width="350"><INPUT type="button" value=" 添加比分员 " class="text" onclick="self.location.href='addbfuser.aspx';"></TD>
						</TR>
						<TR>
							<TD colSpan="2">
								<asp:DataGrid id="DataGrid1" runat="server" Width="600px" AutoGenerateColumns="False" HeaderStyle-CssClass="blueheader"
									HeaderStyle-HorizontalAlign="Center" ItemStyle-Height="22" HeaderStyle-Height="25" BorderColor="Black"
									BorderWidth="1px">
									<ItemStyle Height="22px"></ItemStyle>
									<HeaderStyle HorizontalAlign="Center" Height="25px" CssClass="blueheader"></HeaderStyle>
									<Columns>
										<asp:BoundColumn DataField="username" ReadOnly="True" HeaderText="比分员帐号">
											<HeaderStyle Width="100px"></HeaderStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="truename" ReadOnly="True" HeaderText="名称">
											<HeaderStyle Width="100px"></HeaderStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="logintime" ReadOnly="True" HeaderText="最近登陆时间">
											<HeaderStyle Width="120px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="loginip" ReadOnly="True" HeaderText="最近登陆IP">
											<HeaderStyle Width="100px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn HeaderText="状况">
											<HeaderStyle Width="50px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# UserStatus(DataBinder.Eval(Container.DataItem, "isuseable").ToString())%>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:TemplateColumn HeaderText="操作">
											<HeaderStyle Width="130px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# UserOp(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "isuseable").ToString())%>
											</ItemTemplate>
										</asp:TemplateColumn>
									</Columns>
								</asp:DataGrid>
			</FONT>
		</form>
		</TD></TR>
		<TR>
			<TD></TD>
			<TD></TD>
		</TR>
		</TBODY></TABLE></FONT>
	</body>
</HTML>
