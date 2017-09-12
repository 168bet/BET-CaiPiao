<%@ Page language="c#" Codebehind="MatchOrder.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.gj.MatchOrder" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>MatchOrder</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<meta http-equiv="refresh" content="600">
	</HEAD>
	<body leftMargin="1" topMargin="1">
		<a href="MatchOrder.aspx">全部</a> <a href="MatchOrder.aspx?action=no">不正常</a> <a href="javascript:window.location.reload()">
			更新</a>
		<table width="761" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
			<tr class="blueheader" align="center">
				<td width="74">ID</td>
				
				<td width="95">类别</td>
				
				<td width="81">总注单数</td>
				<td width="74">已结注单</td>
				<td width="65">未结注单</td>
			</tr>
			<%# kyglContent %>
		</table>
	</body>
</HTML>
