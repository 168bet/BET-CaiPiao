<%@ Page language="c#" Codebehind="gslist_reportcontent.aspx.cs" AutoEventWireup="false" Inherits="mem.gslist_reportcontent" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>reportshownext</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body topmargin="0" leftmargin="1">
		<form id="Form1" method="post" runat="server">
			<table id="tableBarMenu" cellSpacing="0" cellPadding="0" width="800" border="0" runat="server">
				<tr>
					<td height="4"></td>
				</tr>
				<tr>
					<td>
						公司&nbsp;&nbsp;<b></FONT color="gray"><%=userName%></FONT color="gray"></b>&nbsp;&nbsp;注单： 
						&nbsp;&nbsp;&nbsp;<A href="javascript:window.print();">打印</A>&nbsp;&nbsp;&nbsp;<A href="javascript:window.history.back();">返回</A>
						&nbsp;&nbsp;&nbsp;
						<select id="selectpage" name="selectpage" onChange="self.Form1.submit()" runat="server">
							<option value="0" selected>0</option>
						</select>/<label id="sumpages" runat="server">0</label>页
					</td>
				</tr>
				<tr>
					<td height="4"></td>
				</tr>
			</table>
			<table class="tableNoBorder1" id="tableContent" cellSpacing="0" cellPadding="0" width="770"
				border="0" runat="server">
				<tr>
					<td width="100%"></td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
