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
			���붩���ţ� <input id="searchorderid" type="text" name="searchorderid" runat="server">
			<input type="submit" name="inpuSubmit" value="�� ��" id="inpuSubmit" runat="server">
			<asp:Panel Visible="False" ID="panelShow" Runat="server">
				����ID:&nbsp;&nbsp;&nbsp; <INPUT id="orderid" type="text" size="18" name="orderid" runat="server">*��Ҫ����<BR>����ID:&nbsp;&nbsp;&nbsp; <INPUT id="gameid" type="text" size="18" name="gameid" runat="server">*��Ҫ����<BR>
<HR width="100%" SIZE="1">
���ʱ�־:<INPUT id="isjz" type="text" size="18" name="isjz" runat="server"><BR>Win:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<INPUT id="win" type="text" size="18" name="win" runat="server"><BR>lose:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<INPUT id="lose" type="text" size="18" name="lose" runat="server"><BR>��ˮ����:<INPUT id="Truewin" type="text" size="18" name="Truewin" runat="server"><BR>
<HR width="100%" SIZE="1">
��ע��:&nbsp;&nbsp;&nbsp; <INPUT id="tzMoney" type="text" size="18" name="tzMoney" runat="server"><BR>��ע��ʽ:<INPUT id="tztype" type="text" size="18" name="tztype" runat="server"><BR>����:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT id="curpl" type="text" size="18" name="curpl" runat="server"><BR>����:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT id="team" type="text" size="18" name="team" runat="server"><BR>��־:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT id="Marker" type="text" size="18" name="Marker" runat="server"><BR>����:&nbsp;&nbsp;&nbsp; <INPUT id="Rqteam" type="text" size="18" name="Rqteam" runat="server"><BR>����:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<INPUT id="teamGRP" type="text" size="18" name="teamGRP" runat="server"><BR>��������:<TEXTAREA id="Orderbz" name="Orderbz" rows="5" cols="40" runat="server"></TEXTAREA><BR>����ȡ����־:<INPUT id="iscance" type="text" size="18" name="iscance" runat="server">1����0<BR>�û���ˮ����:<INPUT id="Userts" type="text" size="18" name="Userts" runat="server">%<BR>
			</asp:Panel></form>
	</body>
</HTML>
