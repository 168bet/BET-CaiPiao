<%@ Register TagPrefix="webdiyer" Namespace="Wuqi.Webdiyer" Assembly="AspNetPager" %>
<%@ Page language="c#" Codebehind="CheckOrderList.aspx.cs" AutoEventWireup="false" Inherits="mem.CheckOrderList" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>CheckOrderList</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<meta http-equiv="refresh" content="180">
		<script language="javascript" src="../js/calendar.js" type="text/javascript"></script>
		<LINK href="../css/css.css" type="text/css" rel="stylesheet">
		<LINK href="../css/rep.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body topMargin="0">
		<form id="Form1" method="post" runat="server">
			<table cellSpacing="0" cellPadding="0" width="980" align="left" border="0">
				<tr>
					<td align="right">核对日期:<input class="Text1" id="inputdatetime" type="text" size="10" name="inputdatetime" runat="server">
						<IMG style="CURSOR: hand" onclick="g_Calendar.show(event,'Form1.inputdatetime',true,'yyyy-mm-dd'); return false;"
							src="images/calendar.gif" align="absMiddle" border="0">
						<asp:button id="Button1" Runat="server" CssClass="text" Text="确定"></asp:button></td>
				</tr>
				<tr>
					<td><asp:datagrid id="DataGrid1" runat="server" BorderColor="#000033" CellSpacing="0" CellPadding="1"
							Font-Size="14px" HorizontalAlign="Center" Width="980px" AutoGenerateColumns="False">
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
									<HeaderStyle Wrap="False" Width="6%"></HeaderStyle>
									<ItemStyle Wrap="False"></ItemStyle>
								</asp:BoundColumn>
								
								<asp:BoundColumn DataField="tzmoney1" HeaderText="注额金额" DataFormatString="{0:0.00}">
									<HeaderStyle Wrap="False" Width="8%"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="curpl1" HeaderText="赔率" DataFormatString="{0:0.000}">
									<HeaderStyle Wrap="False" Width="5%"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="updatetime" HeaderText="时间" DataFormatString="{0:yyyy-M-d<br>HH:mm:ss}"
									ItemStyle-HorizontalAlign="center">
									<HeaderStyle Wrap="False" Width="6%"></HeaderStyle>
									<ItemStyle Wrap="False"></ItemStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="content1" HeaderText="详细内容" ItemStyle-HorizontalAlign="Right">
									<HeaderStyle Wrap="False" Width="20%"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="tzmoney2" HeaderText="注额金额" DataFormatString="{0:0.00}">
									<HeaderStyle Wrap="False" Width="8%"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="curpl2" HeaderText="赔率" DataFormatString="{0:0.000}">
									<HeaderStyle Wrap="False" Width="5%"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="curdatetime" HeaderText="时间" DataFormatString="{0:yyyy-M-d<br>HH:mm:ss}"
									ItemStyle-HorizontalAlign="center">
									<HeaderStyle Wrap="False" Width="6%"></HeaderStyle>
									<ItemStyle Wrap="False"></ItemStyle>
								</asp:BoundColumn>								
								<asp:BoundColumn DataField="content2" HeaderText="详细内容" ItemStyle-HorizontalAlign="Right">
									<HeaderStyle Wrap="False" Width="20%"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="tzip" HeaderText="IP地址" 
									ItemStyle-HorizontalAlign="center">
									<HeaderStyle Wrap="False" Width="7%"></HeaderStyle>
									<ItemStyle Wrap="False"></ItemStyle>
								</asp:BoundColumn>
							</Columns>
						</asp:datagrid>
						<table cellSpacing="0" cellPadding="0" width="980" align="left" border="0">
							<tr>
								<td width="100%" colSpan="1"><webdiyer:aspnetpager id="pager" runat="server" CssClass="mypager" HorizontalAlign="Right" Width="100%"
										ShowInputBox="Always" SubmitButtonText="转到" InputBoxStyle="border:1px #0000FF solid;text-align:center" SubmitButtonStyle="border:1px solid #000066;height:20px;width:30px"
										PageSize="40" PagingButtonSpacing="0px" NumericButtonTextFormatString="[{0}]" Height="27px" TextAfterInputBox="页" TextBeforeInputBox="第"
										ShowCustomInfoSection="Left"></webdiyer:aspnetpager></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
