<%@ Page language="c#" Codebehind="reportShowNoJs.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.reportShowNoJs" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>reportShowNoJs</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">	
	</HEAD>
	<body topmargin=0 leftmargin=1>
		<form id="Form1" method="post" runat="server">
			<table id="tableBarMenu" cellSpacing="0" cellPadding="0" width="950" border="0" runat="server">
				<tr><td height=2></td></tr>
				<tr>
					<td>
						注单：<A href="javascript:window.location.href='report.aspx';">-返回</A>&nbsp;&nbsp;&nbsp;<A href="javascript:window.location.reload();">-更新</A>&nbsp;&nbsp;&nbsp;<A href="javascript:window.print();">-打印</A>
						&nbsp;&nbsp;&nbsp;
						<select id="selectpage" name="selectpage" onChange="self.Form1.submit()" runat="server">
							<option value="0" selected>0</option>
						</select>/<label id="sumpages" runat="server">0</label>页
					</td>
				</tr>
				<tr><td height=4></td></tr>
			</table>
			<table class="tableNoBorder1" id="tableContent" cellSpacing="0" cellPadding="0" width="950"
				border="0" runat="server">
				<tr>
					<td width="100%"></td>
				</tr>
			</table>
		</form>
	</body>
</HTML>

