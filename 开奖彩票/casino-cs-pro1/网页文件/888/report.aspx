<%@ Page language="c#" Codebehind="report.aspx.cs" AutoEventWireup="false" Inherits="newball.subuser.myReportForm" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>report</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link rel="stylesheet" href="css/css.css" type="text/css">
		<script language="javascript" src="js/calendar.js" type="text/javascript"></script>
	</HEAD>
	<body>
		<form id="myReportForm" method="post" runat="server">
			<table width="780" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="m_tline">
						&nbsp;&nbsp;报表查询
					</td>
					<td width="30"><img src="images/top_04.gif" width="30" height="24"></td>
				</tr>
				<tr>
					<td colspan="2" height="4"></td>
				</tr>
			</table>
			
			<table border="0" cellspacing="1" cellpadding="0" width="600" class="tableNoBorder1">
				<tr height="22">
					<td bgcolor="#008080" width="20%" align="right"><font color="white">日期区间:</font></td>
					<td bgcolor="lightsteelblue" width="80%">&nbsp; <input type="text" name="startTime" id="startTime" size="10" readonly class="Text1" runat="server"><a onclick="calendar(document.forms[0].startTime);return false;" href="javascript:void(0)"><img height="22" alt="" src="images/show-calendar.gif" width="34" align="absMiddle" border="0"></a>~~
						<input type="text" name="endTime" id="endTime" size="10" readonly class="Text1" runat="server"><a onclick="calendar(document.forms[0].endTime);return false;" href="javascript:void(0)"><img height="22" alt="" src="images/show-calendar.gif" width="34" align="absMiddle" border="0"></a>
					</td>
				</tr>
				<tr height="22">
					<td bgcolor="#008080" align="right"><font color="white">报表分类:</font></td>
					<td bgcolor="lightsteelblue" width="80%">&nbsp;
						<asp:DropDownList ID="reportType" Runat="server">
							<asp:ListItem Value="ledger">总帐</asp:ListItem>
							<asp:ListItem Value="breakdown">分类帐</asp:ListItem>
							<asp:ListItem Value="soccer">足球</asp:ListItem>
							<asp:ListItem Value="basketball">篮球</asp:ListItem>
						</asp:DropDownList>
					</td>
				</tr>
				<tr height="22">
					<td bgcolor="#008080" align="right"><font color="white">信用/现金:</font></td>
					<td bgcolor="lightsteelblue" width="80%">&nbsp;
						<asp:DropDownList ID="tzCase" Runat="server">
							<asp:ListItem Value="all">全部</asp:ListItem>
							<asp:ListItem Value="credit">信用</asp:ListItem>
							<asp:ListItem Value="cash">现金</asp:ListItem>
						</asp:DropDownList>
					</td>
				</tr>
				<tr height="22">
					<td bgcolor="#008080" align="right"><font color="white">投注方式:</font></td>
					<td bgcolor="lightsteelblue" width="80%">&nbsp;
						<asp:DropDownList ID="tzType" Runat="server">
							<asp:ListItem Value="all">全部</asp:ListItem>							
							<asp:ListItem Value="1X2">标准</asp:ListItem>
							<asp:ListItem Value="AH">让球</asp:ListItem>
							<asp:ListItem Value="AHHT">让球-上半场</asp:ListItem>							
							<asp:ListItem Value="CS">波胆</asp:ListItem>
							<asp:ListItem Value="HT">半/全场</asp:ListItem>
							<asp:ListItem Value="OE">单/双</asp:ListItem>
							<asp:ListItem Value="OU">大小</asp:ListItem>
							<asp:ListItem Value="OUHT">大小-上半场</asp:ListItem>
							<asp:ListItem Value="P1X2">标准过关</asp:ListItem>
							<asp:ListItem Value="PAH">混合过关</asp:ListItem>
							<asp:ListItem Value="RAH">走地-让球</asp:ListItem>
							<asp:ListItem Value="ROU">走地-大小</asp:ListItem>
							<asp:ListItem Value="TG">总入球</asp:ListItem>
							<asp:ListItem Value="EAH">早餐让球</asp:ListItem>
							<asp:ListItem Value="EOU">早餐大小</asp:ListItem>
							<asp:ListItem Value="BKAH">篮球-让球</asp:ListItem>
							<asp:ListItem Value="BKOE">篮球-单/双</asp:ListItem>
							<asp:ListItem Value="BKOU">篮球-上下</asp:ListItem>
							<asp:ListItem Value="BKPAH">篮球-混合过关</asp:ListItem>
						</asp:DropDownList>
					</td>
				</tr>
				<tr height="28">
					<td colspan="2" width="100%" bgcolor="white">&nbsp;
						<asp:Label ID="showTime1" Runat="server">*</asp:Label><asp:Label ID="showAlready" Runat="server">[]</asp:Label><br>
						&nbsp;
						<asp:Label ID="showTime2" Runat="server">*</asp:Label><asp:Label ID="showNo" Runat="server">[]</asp:Label><br>
						&nbsp;
						<asp:Button id="searchButton" Text="查 询" Runat="server" />&nbsp;&nbsp; <input type="button" name="cancel" value="取 消" onclick="window.history.back();">
					</td>
				</tr>
			</table>
		</form>		
	</body>
</HTML>
