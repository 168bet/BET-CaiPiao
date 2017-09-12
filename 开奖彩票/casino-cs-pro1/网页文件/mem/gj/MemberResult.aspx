<%@ Page language="c#" Codebehind="MemberResult.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.gj.MemberResult" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>MemberResult</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta http-equiv="refresh" content="180">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<LINK href="../css/css.css" type="text/css" rel="stylesheet">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
	</HEAD>
	<body leftMargin="3" topMargin="3">
		<table width="970" border="0" cellpadding="3" cellspacing="1">
			<tr>
				<td colspan="2"><%# kyglContent1 %></td>
			</tr>
			<tr>
				<td width="485" valign="top">
					<table width="99%" border="0" cellpadding="1" cellspacing="1" class="bet_enq">
						<tr>
							<th width=50>时间</th>
							<th width=90>方式</th>
							<th width=250>详情(已结帐注单)</th>
							<th width=50>注额</th>
							<th width=50>结果</th>
						</tr>
						<%# kyglContent2 %>
					</table>
				</td>
				<td width="485" align="right" valign="top">
					<table width="99%" border="0" cellpadding="1" cellspacing="1" class="bet_enq">
						<tr>
							<th width=50>时间</th>
							<th width=90>方式</th>
							<th width=250>详情(未结帐注单)</th>
							<th width=50>注额</th>
							<th width=50>结果</th>
						</tr>
						<%# kyglContent3 %>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</body>
</HTML>
