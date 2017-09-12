<%@ Page language="c#" Codebehind="mgrconfiglist.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.mgrconfiglist" codePage="936"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>mgrconfiglist</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="5" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<table cellSpacing="0" cellPadding="0" width="780" border="0">
				<tr vAlign="middle">
					<td width="100%">&nbsp;公告管理&nbsp;&nbsp; 公告类型:
						<asp:dropdownlist id="le" OnSelectedIndexChanged="le_SelectedIndexChanged" AutoPostBack="True" Runat="server">
							<asp:ListItem Value="" Selected="True">全部</asp:ListItem>
							<asp:ListItem Value="1">前台</asp:ListItem>
							<asp:ListItem Value="2">后台</asp:ListItem>
						</asp:dropdownlist>&nbsp;&nbsp;
					</td>
					<td align="right"><input onclick="javascript:self.location.href='mgrconfig.aspx';" type="button" value="新 增" class=Text
							name="addbutton">
					</td>
				</tr>
			</table>
			<table id="tablegrid" cellSpacing="1" cellPadding="0" width="780" border="0">
				<tr>
					<td><asp:datagrid id="configdatagrid" Runat="server" OnPageIndexChanged="configdatagrid_PageIndexChanged"
							AllowPaging="True" AutoGenerateColumns="False" Width="100%" ItemStyle-Height="22"
							HeaderStyle-Height="25" HeaderStyle-BackColor="#0099cc" HeaderStyle-ForeColor="#ffffff" HeaderStyle-HorizontalAlign="Center">
							<Columns>
								<asp:BoundColumn DataField="id" HeaderText="公告ID" HeaderStyle-Width=80 ItemStyle-HorizontalAlign="Center"></asp:BoundColumn>
								<asp:TemplateColumn HeaderText="公告类型" HeaderStyle-Width=100 ItemStyle-HorizontalAlign="Center">
									<ItemTemplate>
											<%# dealle(DataBinder.Eval(Container.DataItem,"le").ToString())%>
									</ItemTemplate>
								</asp:TemplateColumn>							
								<asp:TemplateColumn HeaderText="公告内容" HeaderStyle-Width=400 ItemStyle-HorizontalAlign="left">
									<ItemTemplate>
											<%# dealcontent(DataBinder.Eval(Container.DataItem,"content").ToString())%>
									</ItemTemplate>
								</asp:TemplateColumn>
								<asp:BoundColumn DataField="kaisai" HeaderText="开赛时间" HeaderStyle-Width=100 ItemStyle-HorizontalAlign="Center"></asp:BoundColumn>
								<asp:TemplateColumn HeaderText="操 作" HeaderStyle-Width=100 ItemStyle-HorizontalAlign="Center">
									<ItemTemplate>
										<a href="mgrconfig.aspx?id=<%# DataBinder.Eval(Container.DataItem,"id")%>">修改</a>&nbsp;/&nbsp;
										<a href="javascript:if(confirm('确定删除！'))window.location='mgrconfiglist.aspx?id=<%# DataBinder.Eval(Container.DataItem,"id")%>';">删除</a>
									</ItemTemplate>
								</asp:TemplateColumn>
							</Columns>
							<PagerStyle HorizontalAlign="Right" Position="Top" Mode="NumericPages"></PagerStyle>
						</asp:datagrid></td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
