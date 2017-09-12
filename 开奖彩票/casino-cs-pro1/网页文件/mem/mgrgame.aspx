<%@ Page language="c#" Codebehind="mgrgame.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.mgrgame" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>停赛</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<meta name="refreshname" http-equiv="refresh" content="<%=refreshtime%>">
		<link href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body text="#000000" bgColor="#ffffff" leftMargin="1" topMargin="1">
		<form id="Form1" method="post" runat="server">
<table width="776" border="0" cellpadding="3" cellspacing="1" bgcolor=#000000>
  <tr class="blueheader" height=25>
    <td width="93">时间</td>
    <td width="99">联赛</td>
    <td width="183">比赛队伍</td>
    <td width="55">走地</td>
    <td width="85">状态</td>
    <td width="218">操作</td>
  </tr>
<%# kyglContent %>
</table>
		</form>
	</body>
</HTML>
