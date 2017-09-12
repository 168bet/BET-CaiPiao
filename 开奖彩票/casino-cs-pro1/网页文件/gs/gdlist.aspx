<%@ Page language="c#" Codebehind="gdlist.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.gdlist" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>gdlist</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="5" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<TABLE id="Table1" style="HEIGHT: 63px" cellSpacing="0" cellPadding="0" width="776" border="0">
				<TR>
					<TD style="WIDTH: 400px">股东管理:&nbsp;&nbsp;帐号状态
						<asp:dropdownlist id="DropDownListAccountStatus" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListAccountStatus_SelectedIndexChanged">
							<asp:ListItem Value="1" Selected="True">启用</asp:ListItem>
							<asp:ListItem Value="0">停用</asp:ListItem>
						</asp:dropdownlist>&nbsp;
						<asp:DropDownList id="DropDownListPage" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListPage_SelectedIndexChanged"></asp:DropDownList>
						<asp:Label id="LabelPage" runat="server">Label</asp:Label></TD>
					<TD width="100">
						<asp:TextBox id="TextBoxSortField" runat="server" Visible="False"></asp:TextBox></TD>
					<TD align="right" width="276"><input type="button" value="新  增" class="Text" onclick="javascript:self.location.href='gdadd.aspx';"></TD>
				</TR>
				<TR>
					<TD colSpan="3" valign=top><asp:datagrid id="DataGrid1" runat="server" HeaderStyle-HorizontalAlign="Center" HeaderStyle-ForeColor="#ffffff"
							HeaderStyle-BackColor="#0099cc" ItemStyle-Height="20" Width="100%" AutoGenerateColumns="False"
							AllowSorting="True" OnPageIndexChanged="DataGrid1_PageIndexChanged" OnSortCommand="DataGrid1_SortCommand"
							PageSize="20" BorderColor="Black">
							<ItemStyle Height="20px"></ItemStyle>
							<HeaderStyle HorizontalAlign="Center" ForeColor="White" BackColor="#0099FF"></HeaderStyle>
							<Columns>
								<asp:TemplateColumn HeaderText="股东帐号">
											<ItemStyle HorizontalAlign="center"></ItemStyle>
											<ItemTemplate>
												<%# kygl_href(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "username").ToString()) %>
											</ItemTemplate>
										</asp:TemplateColumn>
								<asp:BoundColumn DataField="truename" SortExpression="truename" ReadOnly="True" HeaderText="股东名称"></asp:BoundColumn>
								<asp:BoundColumn DataField="usemoney" SortExpression="usemoney" ReadOnly="True" HeaderText="信用额度"></asp:BoundColumn>
								<asp:BoundColumn DataField="memcount" SortExpression="memcount" ReadOnly="True" HeaderText="总代理统计">
									<ItemStyle HorizontalAlign="Center"></ItemStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="regtime" SortExpression="regtime" ReadOnly="True" HeaderText="新增时间" DataFormatString="{0:yyyy-MM-dd HH:mm:ss}"></asp:BoundColumn>
								<asp:TemplateColumn HeaderText="帐号状态">
									<HeaderStyle Width="100px"></HeaderStyle>
									<ItemStyle HorizontalAlign="Center"></ItemStyle>
									<ItemTemplate>
										<%# AccountStatus(DataBinder.Eval(Container.DataItem, "isuseable").ToString())%>
									</ItemTemplate>
								</asp:TemplateColumn>
								<asp:TemplateColumn HeaderText="操作">
									<HeaderStyle Width="210px"></HeaderStyle>
									<ItemStyle HorizontalAlign="center"></ItemStyle>
									<ItemTemplate>
										<%# OpItem(DataBinder.Eval(Container.DataItem, "isuseable").ToString(),DataBinder.Eval(Container.DataItem, "userid").ToString())%>
										/ <a href=gdmsg.aspx?id=<%# DataBinder.Eval(Container.DataItem, "userid")%>>详情</a>
										/ <a href="gdset.aspx?id=<%# DataBinder.Eval(Container.DataItem, "userid")%>&gid=<%# DataBinder.Eval(Container.DataItem, "gdid")%>">设定</a>
									</ItemTemplate>
								</asp:TemplateColumn>
							</Columns>
							<PagerStyle Visible="False" HorizontalAlign="Right" Position="Top" Mode="NumericPages"></PagerStyle>
						</asp:datagrid></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 200px"></TD>
					<TD width="300"></TD>
					<TD width="276"></TD>
				</TR>
			</TABLE>
		</form>
	</body>
</HTML>
