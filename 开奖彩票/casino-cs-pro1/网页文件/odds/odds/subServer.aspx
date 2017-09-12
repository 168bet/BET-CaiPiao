<%@ Page language="c#" Codebehind="subServer.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.odds.subServer" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>subServer</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="3" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="宋体">
				<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="450" border="0">
					<TBODY>
						<TR>
							<TD style="WIDTH: 200px"></TD>
							<TD align="right"><asp:button id="ButtonAdd" runat="server" CssClass="text" Text="添加子服务器"></asp:button></TD>
						</TR>
						<TR>
							<TD colSpan="2"><FONT face="宋体"><asp:datagrid id="DataGrid1" runat="server" HeaderStyle-CssClass="blueheader" AutoGenerateColumns="False"
										Width="450px" OnEditCommand="EditServer" OnUpdateCommand="SaveServer" ItemStyle-Height="22" HeaderStyle-Height="25"
										ItemStyle-BackColor="#ffffff" BorderColor="Black" BorderWidth="1px" OnDeleteCommand="DelServer" OnCancelCommand="CancelServer">
										<ItemStyle Height="22px" BackColor="White"></ItemStyle>
										<HeaderStyle Height="25px" CssClass="blueheader"></HeaderStyle>
										<Columns>
											<asp:TemplateColumn HeaderText="子服务器ID">
												<HeaderStyle Width="80px"></HeaderStyle>
												<ItemStyle HorizontalAlign="Center"></ItemStyle>
												<ItemTemplate>
													<%# DataBinder.Eval(Container, "DataItem.serverid") %>
													<asp:TextBox id="TextBox1" runat="server" Text='<%# DataBinder.Eval(Container, "DataItem.serverid") %>' ReadOnly=True Visible=False>
													</asp:TextBox>
												</ItemTemplate>
												<EditItemTemplate>
													<%# DataBinder.Eval(Container, "DataItem.serverid") %>
													<INPUT class=text type=hidden value='<%# DataBinder.Eval(Container, "DataItem.serverid") %>' name=serverid>
												</EditItemTemplate>
											</asp:TemplateColumn>
											<asp:TemplateColumn HeaderText="子服务器名称">
												<ItemTemplate>
													<%# DataBinder.Eval(Container, "DataItem.servername") %>
												</ItemTemplate>
												<EditItemTemplate>
													<input name="servername" value='<%# DataBinder.Eval(Container, "DataItem.servername") %>' class=text size=30>
												</EditItemTemplate>
											</asp:TemplateColumn>
											<asp:EditCommandColumn ButtonType="LinkButton" UpdateText="更新" HeaderText="操作" CancelText="取消" EditText="编辑">
												<HeaderStyle Width="100px"></HeaderStyle>
												<ItemStyle HorizontalAlign="Center"></ItemStyle>
											</asp:EditCommandColumn>
											<asp:ButtonColumn Text="删除" CommandName="Delete">
												<HeaderStyle Width="50px"></HeaderStyle>
												<ItemStyle HorizontalAlign="Center"></ItemStyle>
											</asp:ButtonColumn>
										</Columns>
									</asp:datagrid></FONT></TD>
						</TR>
					</TBODY>
				</TABLE>
			</FONT>
		</form>
	</body>
</HTML>
