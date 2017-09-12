<%@ Page language="c#" Codebehind="reportshow.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.reportshow" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<html>
	<head>
		<title>reportshow</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link rel="stylesheet" href="css/css.css" type="text/css">
	</head>
	<body>
		<form id="Form1" method="post" runat="server">
			<table id="tableBarMenu" width="950" runat="server" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="m_tline">
						&nbsp;&nbsp;代理商：
					</td>
					<td width="30"><img src="images/top_04.gif" width="30" height="24"></td>
				</tr>
				<tr>
					<td colspan="2" height="4"></td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" width="950" id="tableHeader" runat="server">
				<tr class="dlsreport">
					<td>信用</td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" width="950" id="tableMiddle" class="tableNoBorder1"
				runat="server">
				<tr class="dlsheader">
					<td>现金</td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" width="950" id="tableBottom" class="tableNoBorder1"
				runat="server">
				<tr class="dlsheader">
					<td>总数</td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>
		</form>
	</body>
</html>
<!-- end page 结束翻页过程 -->