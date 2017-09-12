<%@ Page language="c#" Codebehind="list.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.list" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>list</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
	</HEAD>
	<body>
		<form id="Form1" method="post" runat="server">
			输入订单号： <input id="searchorderid" type="text" name="searchorderid" runat="server">
			<input type="submit" name="inpuSubmit" value="列 出" id="inpuSubmit" runat="server">
			<asp:Panel Visible="False" ID="panelShow" Runat="server">
				订单ID:&nbsp;&nbsp;&nbsp; <INPUT id="orderid" type="text" size="18" name="orderid" runat="server">*不要更改<BR>赛事ID:&nbsp;&nbsp;&nbsp; <INPUT id="gameid" type="text" size="18" name="gameid" runat="server">*不要更改<BR>
<HR width="100%" SIZE="1">
结帐标志:<INPUT id="isjz" type="text" size="18" name="isjz" runat="server"><BR>Win:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<INPUT id="win" type="text" size="18" name="win" runat="server"><BR>lose:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<INPUT id="lose" type="text" size="18" name="lose" runat="server"><BR>回水因数:<INPUT id="Truewin" type="text" size="18" name="Truewin" runat="server"><BR>
<HR width="100%" SIZE="1">
下注额:&nbsp;&nbsp;&nbsp; <INPUT id="tzMoney" type="text" size="18" name="tzMoney" runat="server"><BR>下注方式:<INPUT id="tztype" type="text" size="18" name="tztype" runat="server"><BR>赔率:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT id="curpl" type="text" size="18" name="curpl" runat="server"><BR>队伍:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT id="team" type="text" size="18" name="team" runat="server"><BR>标志:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT id="Marker" type="text" size="18" name="Marker" runat="server"><BR>让球方:&nbsp;&nbsp;&nbsp; <INPUT id="Rqteam" type="text" size="18" name="Rqteam" runat="server"><BR>其它:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<INPUT id="teamGRP" type="text" size="18" name="teamGRP" runat="server"><BR>订单详情:<TEXTAREA id="Orderbz" name="Orderbz" rows="5" cols="40" runat="server"></TEXTAREA><BR>订单取消标志:<INPUT id="iscance" type="text" size="18" name="iscance" runat="server">1或者0<BR>用户回水比例:<INPUT id="Userts" type="text" size="18" name="Userts" runat="server">%<BR>
			</asp:Panel></form>
	</body>
</HTML>
