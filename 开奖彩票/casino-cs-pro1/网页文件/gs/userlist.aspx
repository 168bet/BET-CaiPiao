<%@ Page language="c#" Codebehind="userlist.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.userlist" %>
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
			<FONT face="宋体">
				<TABLE id="Table1" style="HEIGHT: 63px" cellSpacing="0" cellPadding="0" width="776" border="0">
					<TR>
						<TD style="WIDTH: 637px; HEIGHT: 6px" colSpan="3">会员&nbsp; 股东
							<asp:DropDownList id="DropDownListGd" runat="server" OnSelectedIndexChanged="DropDownListGd_SelectedIndexChanged"
								AutoPostBack="True"></asp:DropDownList>
							&nbsp;&nbsp; 总代理
							<asp:DropDownList id="DropDownListZdl" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListZdl_SelectedIndexChanged"></asp:DropDownList>&nbsp;代理商
							<asp:DropDownList id="DropDownListDls" runat="server" OnSelectedIndexChanged="DropDownListDls_SelectedIndexChanged"
								AutoPostBack="True"></asp:DropDownList>&nbsp;<FONT face="宋体">状态</FONT>
							<asp:dropdownlist id="DropDownListAccountStatus" runat="server" OnSelectedIndexChanged="DropDownListAccountStatus_SelectedIndexChanged"
								AutoPostBack="True">
								<asp:ListItem Value="">全部</asp:ListItem>
								<asp:ListItem Value="1" Selected="True">启用</asp:ListItem>
								<asp:ListItem Value="0">停用</asp:ListItem>
							</asp:dropdownlist>&nbsp;
							<asp:DropDownList id="DropDownListPage" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListPage_SelectedIndexChanged"></asp:DropDownList>
							<asp:Label id="LabelPage" runat="server">Label</asp:Label>&nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT class="Text" onclick="javascript:self.location.href='useradd.aspx';" type="button"
								value="新  增">
						</TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="宋体"><asp:datagrid id="DataGrid1" runat="server" HeaderStyle-HorizontalAlign="Center" HeaderStyle-CssClass="pinkheader"
									Width="100%" AutoGenerateColumns="False" AllowSorting="True" OnPageIndexChanged="DataGrid1_PageIndexChanged" OnSortCommand="DataGrid1_SortCommand"
									ItemStyle-Height="22" OnItemDataBound="DataGrid1_ItemDataBound" BorderColor="Black" AllowCustomPaging="True">
									<ItemStyle Height="22px"></ItemStyle>
									<HeaderStyle Wrap="False" HorizontalAlign="Center" CssClass="addmember" ForeColor="White" BackColor="#0099FF"></HeaderStyle>
									<Columns>
										<asp:TemplateColumn HeaderText="会员帐号">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# kygl(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "username").ToString()) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="userpass" ReadOnly="True" HeaderText="密码">
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="truename" SortExpression="truename" ReadOnly="True" HeaderText="名称">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:BoundColumn DataField="dlsname" ReadOnly="True" HeaderText="代理商">
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
										<asp:BoundColumn DataField="MoneySort" ReadOnly="True" HeaderText="货币代码">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
										</asp:BoundColumn>
										<asp:TemplateColumn SortExpression="usemoney" HeaderText="信用额度">
											<HeaderStyle Width="60px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Right"></ItemStyle>
											<ItemTemplate>
												<%# MyTeam.Functions.MyFunc.NumBerFormat(DataBinder.Eval(Container.DataItem, "usemoney").ToString(),true) %>
											</ItemTemplate>
										</asp:TemplateColumn>
										<asp:BoundColumn DataField="regtime" SortExpression="regtime" ReadOnly="True" HeaderText="新增日期" DataFormatString="{0:yyyy-MM-dd HH:mm:ss}">
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
											<HeaderStyle Width="100px"></HeaderStyle>
											<ItemStyle HorizontalAlign="Center"></ItemStyle>
											<ItemTemplate>
												<%# kygl(DataBinder.Eval(Container.DataItem, "userid").ToString(),DataBinder.Eval(Container.DataItem, "dlsid").ToString(),DataBinder.Eval(Container.DataItem, "isuseable").ToString()) %>
											</ItemTemplate>
										</asp:TemplateColumn>
									</Columns>
									<PagerStyle Visible="False" HorizontalAlign="Right" Position="Top" Mode="NumericPages"></PagerStyle>
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
