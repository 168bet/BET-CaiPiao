<%@ Page language="c#" Codebehind="GameFen.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.subadmin.GameFen" codePage="936" %>
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
		<a href="?">全部</a> <a href="?action=no">不正常</a> <a href="javascript:window.location.reload()">
			更新</a> <!--<a href="?action=del">删除所有注单</a>-->
		<table width="761" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
			<tr class="blueheader" align="center">
				<td width="95">类别</td>
				<td width="81">总注单数</td>
				<td width="74">已结注单</td>
				<td width="65">未结注单</td>
				<td width="74">结算</td>
			</tr>
			<%# kyglContent %>
		</table>
	</body>
</HTML>
