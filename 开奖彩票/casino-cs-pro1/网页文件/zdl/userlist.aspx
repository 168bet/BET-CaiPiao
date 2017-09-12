<%@ Page language="c#" Codebehind="userlist.aspx.cs" AutoEventWireup="false" Inherits="newball.zdl.userlist" codePage="936" %>
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
				<TABLE id="Table1" style="HEIGHT: 63px" cellSpacing="0" cellPadding="0" width="860" border="0">
					<TR>
						<TD style="WIDTH: 637px; HEIGHT: 8px" colSpan="3">会员&nbsp; 总代理:
							<asp:label id="LabelZdl" runat="server">Label</asp:label>&nbsp;&nbsp;&nbsp;代理商
							<asp:dropdownlist id="DropDownListDls" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListDls_SelectedIndexChanged"></asp:dropdownlist>&nbsp;<FONT face="宋体">
								状态</FONT>
							<asp:dropdownlist id="DropDownListAccountStatus" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListAccountStatus_SelectedIndexChanged">
								<asp:ListItem Value="">全部</asp:ListItem>
								<asp:ListItem Value="1" Selected="True">启用</asp:ListItem>
								<asp:ListItem Value="0">停用</asp:ListItem>
							</asp:dropdownlist><FONT face="宋体">&nbsp;</FONT><asp:dropdownlist id="DropDownListPage" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListPage_SelectedIndexChanged"></asp:dropdownlist><asp:label id="LabelPage" runat="server">Label</asp:label><FONT face="宋体">&nbsp;&nbsp;&nbsp;
							</FONT><INPUT class="Text" onclick="javascript:self.location.href='useradd.aspx';" type="button"
								value="新  增"></TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="宋体"><asp:datagrid id="DataGrid1" runat="server" BorderColor="Black" OnItemDataBound="DataGrid1_ItemDataBound"
									ItemStyle-Height="22" HeaderStyle-Height="25" OnSortCommand="DataGrid1_SortCommand" OnPageIndexChanged="DataGrid1_PageIndexChanged"
									AllowSorting="True" AutoGenerateColumns="False" Width="100%" HeaderStyle-CssClass="pinkheader" HeaderStyle-HorizontalAlign="Center">
									<ItemStyle Height="22px"></ItemStyle>
									<HeaderStyle Wrap="False" HorizontalAlign="Center" CssClass="addmember" Height="25" ForeColor="White" BackColor="#0099FF"></HeaderStyle>
									<Columns>
										<asp:TemplateColumn SortExpression="username" HeaderText="会员帐号">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# kygl(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "username").ToString()) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="truename" SortExpression="truename" ReadOnly="True" HeaderText="名称">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="dlsname" SortExpression="dlsname" ReadOnly="True" HeaderText="代理商">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="pltype" ReadOnly="True" HeaderText="赔率种类">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="usertype" ReadOnly="True" HeaderText="信用/现金">
											<HeaderStyle Width="70px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="MoneySort" ReadOnly="True" HeaderText="货币">
											<HeaderStyle Width="30px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn SortExpression="usemoney" HeaderText="信用额度">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Right"></ItemStyle>
											<ItemTemplate>
												<%# MyTeam.Functions.MyFunc.NumBerFormat(DataBinder.Eval(Container.DataItem, "usemoney").ToString(),true) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="regtime" SortExpression="regtime" ReadOnly="True" HeaderText="新增日期" DataFormatString="{0:yyy-MM-dd HH:mm:ss}">
											<HeaderStyle HorizontalAlign="Center" Width="120px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn HeaderText="状况">
											<HeaderStyle Width="30px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# AccountStatus(DataBinder.Eval(Container.DataItem, "isuseable").ToString())%>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:TemplateColumn HeaderText="功能">
											<HeaderStyle Width="150px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# kygl(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "dlsid").ToString(),DataBinder.Eval(Container.DataItem, "isuseable").ToString()) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="jsdatetime" SortExpression="jsdatetime" ReadOnly="True" HeaderText="结帐时间"
											DataFormatString="{0:yyyy-MM-dd HH:mm:ss}">
											<HeaderStyle Width="120px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
									</Columns>
									<PagerStyle HorizontalAlign="Right" Position="Top" Mode="NumericPages"></PagerStyle>
								</asp:datagrid></FONT></TD>
					</TR>
					<TR>
						<TD style="WIDTH: 637px"></TD>
						<TD style="WIDTH: 437px" width="437"><asp:textbox id="TextBoxSortField" runat="server" Visible="False"></asp:textbox></TD>
						<TD width="276"><asp:label id="LabelCount" runat="server" Width="144px">Label</asp:label></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
	</body>
</HTML>
