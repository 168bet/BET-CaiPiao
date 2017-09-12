<%@ Page language="c#" Codebehind="reportpartshownext.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.reportpartshownext" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>reportpartshownext</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body>
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
			<table class="tableNoBorder1" id="tableCredit" cellSpacing="0" cellPadding="0" width="950" border="0" runat="server">
				<tr>
					<td width="100%"></td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
