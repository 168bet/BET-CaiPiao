<%@ Page language="c#" Codebehind="userlist.aspx.cs" AutoEventWireup="false" Inherits="newball.gd.userlist" %>
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
				<TABLE id="Table1" style="HEIGHT: 63px" cellSpacing="0" cellPadding="0" width="860" border="0">
					<TR>
						<TD style="WIDTH: 637px; HEIGHT: 8px" colSpan="3">��Ա&nbsp; �ɶ�:
							<asp:Label id="LabelGd" runat="server">Label</asp:Label>&nbsp; �ܴ���
							<asp:DropDownList id="DropDownListZdl" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListZdl_SelectedIndexChanged"></asp:DropDownList>&nbsp; 
							������
							<asp:DropDownList id="DropDownListDls" runat="server" OnSelectedIndexChanged="DropDownListDls_SelectedIndexChanged"
								AutoPostBack="True"></asp:DropDownList>&nbsp;<FONT face="����"> ״̬</FONT>
							<asp:dropdownlist id="DropDownListAccountStatus" runat="server" OnSelectedIndexChanged="DropDownListAccountStatus_SelectedIndexChanged"
								AutoPostBack="True">
								<asp:ListItem Value="">ȫ��</asp:ListItem>
								<asp:ListItem Value="1" Selected="True">����</asp:ListItem>
								<asp:ListItem Value="0">ͣ��</asp:ListItem>
							</asp:dropdownlist><FONT face="����">&nbsp;</FONT>
							<asp:dropdownlist id="DropDownListPage" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListPage_SelectedIndexChanged"></asp:dropdownlist><asp:label id="LabelPage" runat="server">Label</asp:label><FONT face="����">&nbsp;&nbsp;&nbsp;
							</FONT><INPUT class="Text" onclick="javascript:self.location.href='useradd.aspx';" type="button"
								value="��  ��"></TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="����"><asp:datagrid id="DataGrid1" runat="server" HeaderStyle-HorizontalAlign="Center" HeaderStyle-CssClass="pinkheader"
									Width="100%" AutoGenerateColumns="False" AllowSorting="True" OnPageIndexChanged="DataGrid1_PageIndexChanged" OnSortCommand="DataGrid1_SortCommand"
									HeaderStyle-Height="25" ItemStyle-Height="22" OnItemDataBound="DataGrid1_ItemDataBound" BorderColor="Black">
									<ItemStyle Height="22px"></ItemStyle>									
									<HeaderStyle Wrap="False" HorizontalAlign="Center" Height="25px" CssClass="addmember" ForeColor="White" BackColor="#0099FF"></HeaderStyle>
									<Columns>
										<asp:TemplateColumn HeaderText="��Ա�ʺ�">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# kygl(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "username").ToString()) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="truename" SortExpression="truename" ReadOnly="True" HeaderText="����">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="dlsname" ReadOnly="True" HeaderText="������">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="pltype" ReadOnly="True" HeaderText="��������">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="usertype" ReadOnly="True" HeaderText="����/�ֽ�">
											<HeaderStyle Width="70px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="MoneySort" ReadOnly="True" HeaderText="����">
											<HeaderStyle Width="30px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn SortExpression="usemoney" HeaderText="���ö��">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Right"></ItemStyle>
											<ItemTemplate>
												<%# MyTeam.Functions.MyFunc.NumBerFormat(DataBinder.Eval(Container.DataItem, "usemoney").ToString(),true) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="regtime" SortExpression="regtime" ReadOnly="True" HeaderText="��������" DataFormatString="{0:yyy-MM-dd HH:mm:ss}">
											<HeaderStyle HorizontalAlign="Center" Width="120px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn HeaderText="״��">
											<HeaderStyle Width="30px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# AccountStatus(DataBinder.Eval(Container.DataItem, "isuseable").ToString())%>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:TemplateColumn HeaderText="����">
											<HeaderStyle Width="150px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# kygl(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "dlsid").ToString(),DataBinder.Eval(Container.DataItem, "isuseable").ToString()) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="jsdatetime" SortExpression="jsdatetime" ReadOnly="True" HeaderText="����ʱ��"
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
						<TD width="437" style="WIDTH: 437px">
							<asp:TextBox id="TextBoxSortField" runat="server" Visible="False"></asp:TextBox></TD>
						<TD width="276">
							<asp:Label id="LabelCount" runat="server" Width="144px">Label</asp:Label></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
	</body>
</HTML>
