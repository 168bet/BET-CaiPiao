<%@ Page language="c#" Codebehind="dlslist.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.dlslist" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>zdllist</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="5" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="����">
				<TABLE id="Table1" style="HEIGHT: 63px" cellSpacing="0" cellPadding="0" width="776" border="0">
					<TR>
						<TD colSpan="3">
							������&nbsp;&nbsp; �ɶ�:
							<asp:DropDownList ID="DropDownListGd" Runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListGd_SelectedIndexChanged"></asp:DropDownList>&nbsp; 
							�ܴ���:
							<asp:DropDownList id="DropDownListZdl" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListZdl_SelectedIndexChanged"></asp:DropDownList>&nbsp;
							<FONT face="����">״��&nbsp;</FONT>
							<asp:dropdownlist id="DropDownListAccountStatus" runat="server" OnSelectedIndexChanged="DropDownListAccountStatus_SelectedIndexChanged"
								AutoPostBack="True">
								<asp:ListItem Value="">ȫ��</asp:ListItem>
								<asp:ListItem Selected="True" Value="1">����</asp:ListItem>
								<asp:ListItem Value="0">ͣ��</asp:ListItem>
							</asp:dropdownlist><FONT face="����">&nbsp;</FONT><asp:dropdownlist id="DropDownListPage" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListPage_SelectedIndexChanged"></asp:dropdownlist><asp:label id="LabelPage" runat="server">Label</asp:label><FONT face="����">&nbsp;&nbsp;&nbsp;
							</FONT><INPUT class="Text" onclick="javascript:self.location.href='dlsadd.aspx';" type="button"
								value="��  ��"></TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="����"><asp:datagrid id="DataGrid1" runat="server" HeaderStyle-HorizontalAlign="Center" HeaderStyle-ForeColor="#ffffff"
									HeaderStyle-CssClass="pinkheader" Width="100%" AutoGenerateColumns="False" AllowSorting="True" OnPageIndexChanged="DataGrid1_PageIndexChanged"
									OnSortCommand="DataGrid1_SortCommand" ItemStyle-Height="22" OnItemDataBound="DataGrid1_ItemDataBound" BorderColor="Black"
									BorderWidth="1px">
									<ItemStyle Height="22px"></ItemStyle>
									<HeaderStyle HorizontalAlign="Center" ForeColor="White" CssClass="pinkheader"></HeaderStyle>
									<Columns>
										<asp:BoundColumn DataField="zdlname" SortExpression="zdlname" ReadOnly="True" HeaderText="�ܴ���">
											<HeaderStyle Width="80px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn HeaderText="�������ʺ�">
											<HeaderStyle Width="100px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# kygl(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "username").ToString()) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="truename" SortExpression="truename" ReadOnly="True" HeaderText="����������">
											<HeaderStyle Width="100px"></HeaderStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn SortExpression="usemoney" HeaderText="���ö��">
											<HeaderStyle HorizontalAlign="Center" Width="80px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Right"></ItemStyle>
											<ItemTemplate>
												<%# MyTeam.Functions.MyFunc.NumBerFormat(DataBinder.Eval(Container.DataItem, "usemoney").ToString(),true) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:TemplateColumn SortExpression="memcount" HeaderText="��Աͳ��">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# MyTeam.Functions.MyFunc.DefaultValue(DataBinder.Eval(Container.DataItem, "memcount").ToString(),"0")%>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="regtime" SortExpression="regtime" ReadOnly="True" HeaderText="����ʱ��" DataFormatString="{0:yyyy-MM-dd HH:mm:ss}">
											<HeaderStyle Width="120px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn HeaderText="״��">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# AccountStatus(DataBinder.Eval(Container.DataItem, "isuseable").ToString())%>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:TemplateColumn HeaderText="����">
											<HeaderStyle Width="160px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# kygl(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "zdlid").ToString(),DataBinder.Eval(Container.DataItem, "isuseable").ToString()) %>
												<!--<%# OpItem(DataBinder.Eval(Container.DataItem, "isuseable").ToString(),DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "zdlid").ToString())%>
												/ <a href=dlsmsg.aspx?id=<%# DataBinder.Eval(Container.DataItem, "userid")%>&zid=<%# DataBinder.Eval(Container.DataItem, "zdlid")%>>��ϸ����</a><%# DelItem(MyTeam.Functions.MyFunc.DefaultValue(DataBinder.Eval(Container.DataItem, "memcount").ToString().Trim(),"0"),DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "zdlid").ToString()) %>-->
											</ItemTemplate>
										</asp:TemplateColumn>
									</Columns>
									<PagerStyle HorizontalAlign="Right" Position="Top" Mode="NumericPages"></PagerStyle>
								</asp:datagrid></FONT></TD>
					</TR>
					<TR>
						<TD style="WIDTH: 200px"></TD>
						<TD width="300">
							<asp:TextBox id="TextBoxSortField" runat="server" Visible="False"></asp:TextBox>
							<asp:Label id="LabelCount" runat="server" Width="144px">Label</asp:Label></TD>
						<TD width="276"></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
		&nbsp;
	</body>
</HTML>
