<%@ Page language="c#" Codebehind="zdllist.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.zdllist" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>zdllist</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="5" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="宋体">
				<TABLE id="Table1" style="HEIGHT: 63px" cellSpacing="0" cellPadding="0" width="776" border="0">
					<TR>
						<TD style="HEIGHT: 6px" colSpan="3">总代理&nbsp; 股东:
							<asp:DropDownList ID="DropDownListGd" Runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListGd_SelectedIndexChanged"></asp:DropDownList>&nbsp; 
							&nbsp;<FONT face="宋体">状况</FONT>
							<asp:dropdownlist id="DropDownListAccountStatus" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListAccountStatus_SelectedIndexChanged">
								<asp:ListItem Value="">全部</asp:ListItem>
								<asp:ListItem Selected="True" Value="1">启用</asp:ListItem>
								<asp:ListItem Value="0">停用</asp:ListItem>
							</asp:dropdownlist><FONT face="宋体">&nbsp; </FONT>
							<asp:dropdownlist id="DropDownListPage" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListPage_SelectedIndexChanged"></asp:dropdownlist><asp:label id="LabelPage" runat="server">Label</asp:label><FONT face="宋体">&nbsp;&nbsp;&nbsp;
							</FONT><INPUT class="Text" onclick="javascript:self.location.href='zdladd.aspx';" type="button"
								value="新  增"></TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="宋体"><asp:datagrid id="DataGrid1" runat="server" BorderWidth="1px" BorderColor="Black" ItemStyle-Height="22"
									OnSortCommand="DataGrid1_SortCommand" OnPageIndexChanged="DataGrid1_PageIndexChanged" AllowSorting="True" AutoGenerateColumns="False"
									Width="100%" HeaderStyle-BackColor="#0099ff" HeaderStyle-ForeColor="#ffffff" HeaderStyle-HorizontalAlign="Center">
									<ItemStyle Height="22px"></ItemStyle>
									<HeaderStyle HorizontalAlign="Center" ForeColor="White" BackColor="#0099FF"></HeaderStyle>
									<Columns>
										<asp:TemplateColumn SortExpression="username" HeaderText="总代理帐号">
											<HeaderStyle Width="120px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# kygl_href(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "username").ToString()) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="truename" SortExpression="truename" ReadOnly="True" HeaderText="总代理名称">
											<HeaderStyle Width="120px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn SortExpression="usemoney" HeaderText="信用额度">
											<HeaderStyle Width="120px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Right"></ItemStyle>
											<ItemTemplate>
												<%# MyTeam.Functions.MyFunc.NumBerFormat(DataBinder.Eval(Container.DataItem, "usemoney").ToString(),true) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:TemplateColumn SortExpression="memcount" HeaderText="代理商统计">
											<HeaderStyle Width="80px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# MyTeam.Functions.MyFunc.DefaultValue(DataBinder.Eval(Container.DataItem, "memcount").ToString(),"0")%>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="regtime" SortExpression="regtime" ReadOnly="True" HeaderText="新增时间" DataFormatString="{0:yyyy-MM-dd HH:mm:ss}">
											<HeaderStyle HorizontalAlign="Center" Width="140px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn HeaderText="状态">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# AccountStatus(DataBinder.Eval(Container.DataItem, "isuseable").ToString())%>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:TemplateColumn HeaderText="操作">
											<HeaderStyle Width="180px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# kygl(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "isuseable").ToString()) %>
												<!--<%# OpItem(DataBinder.Eval(Container.DataItem, "isuseable").ToString(),DataBinder.Eval(Container.DataItem, "userid").ToString())%>
												/ <a href=zdlmsg.aspx?id=<%# DataBinder.Eval(Container.DataItem, "userid")%>>详细资料</a><%# DelItem(MyTeam.Functions.MyFunc.DefaultValue(DataBinder.Eval(Container.DataItem, "memcount").ToString().Trim(),"0"),DataBinder.Eval(Container.DataItem, "userid").ToString()) %>-->
											</ItemTemplate>
										</asp:TemplateColumn>
									</Columns>
									<PagerStyle Visible="False" HorizontalAlign="Right" Position="Top" Mode="NumericPages"></PagerStyle>
								</asp:datagrid></FONT></TD>
					</TR>
					<TR>
						<TD style="WIDTH: 200px"></TD>
						<TD width="300"><asp:textbox id="TextBoxSortField" runat="server" Visible="False"></asp:textbox><asp:label id="LabelCount" runat="server" Width="144px">Label</asp:label></TD>
						<TD width="276"></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
	</body>
</HTML>
