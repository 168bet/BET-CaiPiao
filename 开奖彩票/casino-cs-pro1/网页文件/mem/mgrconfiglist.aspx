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
					<td width="100%">&nbsp;�������&nbsp;&nbsp; ��������:
						<asp:dropdownlist id="le" OnSelectedIndexChanged="le_SelectedIndexChanged" AutoPostBack="True" Runat="server">
							<asp:ListItem Value="" Selected="True">ȫ��</asp:ListItem>
							<asp:ListItem Value="1">ǰ̨</asp:ListItem>
							<asp:ListItem Value="2">��̨</asp:ListItem>
						</asp:dropdownlist>&nbsp;&nbsp;
					</td>
					<td align="right"><input onclick="javascript:self.location.href='mgrconfig.aspx';" type="button" value="�� ��" class=Text
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
								<asp:BoundColumn DataField="id" HeaderText="����ID" HeaderStyle-Width=80 ItemStyle-HorizontalAlign="Center"></asp:BoundColumn>
								<asp:TemplateColumn HeaderText="��������" HeaderStyle-Width=100 ItemStyle-HorizontalAlign="Center">
									<ItemTemplate>
											<%# dealle(DataBinder.Eval(Container.DataItem,"le").ToString())%>
									</ItemTemplate>
								</asp:TemplateColumn>							
								<asp:TemplateColumn HeaderText="��������" HeaderStyle-Width=400 ItemStyle-HorizontalAlign="left">
									<ItemTemplate>
											<%# dealcontent(DataBinder.Eval(Container.DataItem,"content").ToString())%>
									</ItemTemplate>
								</asp:TemplateColumn>
								<asp:BoundColumn DataField="kaisai" HeaderText="����ʱ��" HeaderStyle-Width=100 ItemStyle-HorizontalAlign="Center"></asp:BoundColumn>
								<asp:TemplateColumn HeaderText="�� ��" HeaderStyle-Width=100 ItemStyle-HorizontalAlign="Center">
									<ItemTemplate>
										<a href="mgrconfig.aspx?id=<%# DataBinder.Eval(Container.DataItem,"id")%>">�޸�</a>&nbsp;/&nbsp;
										<a href="javascript:if(confirm('ȷ��ɾ����'))window.location='mgrconfiglist.aspx?id=<%# DataBinder.Eval(Container.DataItem,"id")%>';">ɾ��</a>
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
