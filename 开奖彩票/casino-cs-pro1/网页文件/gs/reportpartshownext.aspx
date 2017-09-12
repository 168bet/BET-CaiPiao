<%@ Page language="c#" Codebehind="reportpartshownext.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.reportpartshownext" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>reportpartshownext</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body topmargin="1" leftmargin="2">
		<form id="Form1" method="post" runat="server" action="<%=pathStr%>">
			<table id="tableBarMenu" cellSpacing="0" cellPadding="4" width="950" border="0" runat="server">
				<tr>
					<td>
						&nbsp;&nbsp;注单：<A href="javascript:window.history.back();">-返回</A>&nbsp;&nbsp;&nbsp;<A href="javascript:window.location.reload();">-更新</A>&nbsp;&nbsp;&nbsp;<A href="javascript:window.print();">-打印</A>
						&nbsp;&nbsp;&nbsp;
						<select id="selectpage" name="selectpage" onChange="self.Form1.submit()" runat="server">
							<option value="0" selected>0</option>
						</select>/<label id="sumpages" runat="server">0</label>页
					</td>
				</tr>
			</table>
			<table id="tableCredit" cellSpacing="0" cellPadding="0" width="950" border="0" runat="server">
				<tr>
					<td width="100%"></td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
