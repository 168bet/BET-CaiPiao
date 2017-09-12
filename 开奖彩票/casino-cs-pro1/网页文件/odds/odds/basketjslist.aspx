<%@ Page language="c#" Codebehind="basketjslist.aspx.cs" AutoEventWireup="false" Inherits="odds.odds.basketjs" %>
<HTML>
	<HEAD>
		<title>basketjslist</title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<BODY text="#000000" bgColor="#ffffff" leftMargin="1" topMargin="1">
		<form id="SubGetUNteam" name="SubGetUNteam" method="post" runat="server" action="basketjslist.aspx">
			<table width="790">
				<tr>
					<td align="right">
						<input type="hidden" name="MySelDate" value=<%= selday%>>
						<asp:Button id="ButtonJsAHgg" runat="server" Text="结算让球过关" CssClass="text"></asp:Button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<SELECT id="SelectDay" onchange="SubGetUNteam.MySelDate.value=this.value;document.SubGetUNteam.submit();"
							name="SelectDay" runat="server">
						</SELECT>
					</td>
				</tr>
			</table>
			<asp:datagrid id="DataGrid1" runat="server" Width="790px" AutoGenerateColumns="False" CellPadding="3"
				BorderWidth="1pt" BorderColor="Black">
				<Columns>
					<asp:BoundColumn DataField="sortballtime" ReadOnly="True" HeaderText="时间" DataFormatString="{0:t}">
						<HeaderStyle Width="40px" CssClass="blueheader"></HeaderStyle>
						<ItemStyle HorizontalAlign="Center"></ItemStyle>
					</asp:BoundColumn>
					<asp:BoundColumn DataField="ballid" ReadOnly="True" HeaderText="联赛ID">
						<HeaderStyle Width="40px" CssClass="blueheader"></HeaderStyle>
						<ItemStyle HorizontalAlign="Center"></ItemStyle>
					</asp:BoundColumn>
					<asp:BoundColumn DataField="matchname" ReadOnly="True" HeaderText="联赛名称">
						<HeaderStyle Width="150px" CssClass="blueheader"></HeaderStyle>
					</asp:BoundColumn>
					<asp:BoundColumn DataField="team1" ReadOnly="True" HeaderText="主队">
						<HeaderStyle Width="150px" CssClass="blueheader"></HeaderStyle>
						<ItemStyle Wrap="False"></ItemStyle>
					</asp:BoundColumn>
					<asp:BoundColumn DataField="team2" ReadOnly="True" HeaderText="客队">
						<HeaderStyle Width="140px" CssClass="blueheader"></HeaderStyle>
						<ItemStyle Wrap="False"></ItemStyle>
					</asp:BoundColumn>
					
					<asp:TemplateColumn HeaderText="全场比分">
						<HeaderStyle HorizontalAlign="Center" Width="60px" CssClass="blueheader"></HeaderStyle>
						<ItemStyle HorizontalAlign="Center"></ItemStyle>
						<ItemTemplate>
							<%# DataBinder.Eval(Container.DataItem, "fen2")%>
						</ItemTemplate>
					</asp:TemplateColumn>
					<asp:TemplateColumn HeaderText="结算" HeaderStyle-CssClass="blueheader" ItemStyle-HorizontalAlign="Center"
						HeaderStyle-Width="50">
						<ItemTemplate>
							<%# JsLink(DataBinder.Eval(Container.DataItem, "ballid").ToString()) %>
						</ItemTemplate>
					</asp:TemplateColumn>
					<asp:TemplateColumn HeaderText="状态">
						<HeaderStyle HorizontalAlign="Center" Width="100px" CssClass="blueheader"></HeaderStyle>
						<ItemStyle HorizontalAlign="Center"></ItemStyle>
						<ItemTemplate>
							<%# BallStatus(DataBinder.Eval(Container.DataItem, "iscancel").ToString(),DataBinder.Eval(Container.DataItem, "ishtcancel").ToString(),DataBinder.Eval(Container.DataItem, "isjs").ToString())%>
						</ItemTemplate>
					</asp:TemplateColumn>
					<asp:BoundColumn Visible="False" DataField="iscancel" ReadOnly="True"></asp:BoundColumn>
				</Columns>
			</asp:datagrid>
		</form>
	</BODY>
</HTML>
