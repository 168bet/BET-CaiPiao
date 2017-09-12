<%@ Page language="c#" Codebehind="CheckBackOrderList.aspx.cs" AutoEventWireup="false" Inherits="mem.CheckBackOrderList" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>CheckOrderList</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<meta http-equiv="refresh" content="180">
		<script language="javascript" src="../js/calendar.js" type="text/javascript"></script>
		<LINK href="../css/css.css" type="text/css" rel="stylesheet">
		<link href="../css/rep.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body topmargin="0">
		<form id="Form1" method="post" runat="server">
			<table cellpadding="0" cellspacing="0" border="0" align="left" Width="1000px">
				<tr>
					<td align="right" colspan=2>
						核对日期:<input class="Text1" id="inputdatetime" type="text" size="10" name="inputdatetime" runat="server">
						<IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'Form1.inputdatetime',true,'yyyy-mm-dd'); return false;"
							style="CURSOR: hand">
						<asp:Button Text="确定" CssClass="text" Runat="server" id="Button1"></asp:Button>
					</td>
				</tr>
				<tr>
					<td valign=top>
						<table border=0 cellpadding=0 cellspacing=1 bgColor='#AAAAAA' width=500px>
							<tr align=center  class=blueheader  height=22>
								<td Width="22%">订单ID</td>
								<td Width="12%">用户名</td>
								<td Width="12%">注额金额</td>
								<td Width="12%">赔率</td>
								<td Width="14%">时间</td>
								<td Width="46%">详细内容</td>
							</tr>
							<%=htmlcontent1%>
						</table>
						<%--
						<asp:datagrid id="DataGrid1" runat="server" AutoGenerateColumns="False" Width="500px" HorizontalAlign="Center"
							Font-Size="14px" CellPadding="1" CellSpacing="0" BorderColor="#000033">
							<EditItemStyle Wrap="False"></EditItemStyle>
							<AlternatingItemStyle BackColor="#EAEAEA"></AlternatingItemStyle>
							<ItemStyle BackColor="Ivory" HorizontalAlign="Center"></ItemStyle>
							<HeaderStyle Font-Bold="True" Wrap="False" HorizontalAlign="Center" BackColor="#66ccff"></HeaderStyle>
							<Columns>
								<asp:BoundColumn DataField="orderid" ReadOnly="True" HeaderText="订单ID">
									<HeaderStyle Wrap="False" Width="10%"></HeaderStyle>
									<ItemStyle Wrap="False"></ItemStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="username" ReadOnly="True" HeaderText="用户名">
									<HeaderStyle Wrap="False" Width="8%"></HeaderStyle>
									<ItemStyle Wrap="False"></ItemStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="tzmoney" HeaderText="注额金额" DataFormatString="{0:0.00}">
									<HeaderStyle Wrap="False" Width="8%"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="curpl" HeaderText="赔率" DataFormatString="{0:0.000}">
									<HeaderStyle Wrap="False" Width="6%"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="updatetime" HeaderText="时间" DataFormatString="{0:yyyy-M-d<br>HH:mm:ss}"
									ItemStyle-HorizontalAlign="center">
									<HeaderStyle Wrap="False" Width="7%"></HeaderStyle>
									<ItemStyle Wrap="False"></ItemStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="content" HeaderText="详细内容" ItemStyle-HorizontalAlign="Right">
									<HeaderStyle Wrap="False" Width="20%"></HeaderStyle>
								</asp:BoundColumn>
							</Columns>
						</asp:datagrid>
						--%>
					</td>
										
					<td valign=top>
						<table border=0 cellpadding=0 cellspacing=1 bgColor='#AAAAAA' width=500px>
							<tr align=center  class=blueheader  height=22>
								<td Width="22%">订单ID</td>
								<td Width="12%">用户名</td>
								<td Width="12%">注额金额</td>
								<td Width="12%">赔率</td>
								<td Width="14%">时间</td>
								<td Width="46%">详细内容</td>
							</tr>
							<%=htmlcontent2%>
						</table>
						<%--
						<asp:datagrid id="DataGrid2" runat="server" AutoGenerateColumns="False" Width="500px" HorizontalAlign="Center"
							Font-Size="14px" CellPadding="1" CellSpacing="0" BorderColor="#000033">
							<EditItemStyle Wrap="False"></EditItemStyle>
							<AlternatingItemStyle BackColor="#EAEAEA"></AlternatingItemStyle>
							<ItemStyle BackColor="Ivory" HorizontalAlign="Center"></ItemStyle>
							<HeaderStyle Font-Bold="True" Wrap="False" HorizontalAlign="Center" BackColor="#66ccff"></HeaderStyle>
							<Columns>
								<asp:BoundColumn DataField="orderid" ReadOnly="True" HeaderText="订单ID">
									<HeaderStyle Wrap="False" Width="10%"></HeaderStyle>
									<ItemStyle Wrap="False"></ItemStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="username" ReadOnly="True" HeaderText="用户名">
									<HeaderStyle Wrap="False" Width="8%"></HeaderStyle>
									<ItemStyle Wrap="False"></ItemStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="tzmoney" HeaderText="注额金额" DataFormatString="{0:0.00}">
									<HeaderStyle Wrap="False" Width="8%"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="curpl" HeaderText="赔率" DataFormatString="{0:0.000}">
									<HeaderStyle Wrap="False" Width="6%"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="updatetime" HeaderText="时间" DataFormatString="{0:yyyy-M-d<br>HH:mm:ss}"
									ItemStyle-HorizontalAlign="center">
									<HeaderStyle Wrap="False" Width="7%"></HeaderStyle>
									<ItemStyle Wrap="False"></ItemStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="content" HeaderText="详细内容" ItemStyle-HorizontalAlign="Right">
									<HeaderStyle Wrap="False" Width="20%"></HeaderStyle>
								</asp:BoundColumn>					
							</Columns>
						</asp:datagrid>
						--%>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
