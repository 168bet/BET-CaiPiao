<%@ Page language="c#" Codebehind="report.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.report" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>report</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<LINK href="css/rep.css" type="text/css" rel="stylesheet">
		<script language="javascript" src="js/calendar.js" type="text/javascript"></script>	
		<script language="javascript" type="text/javascript">
			function checkaction(valday)
			{
				myReportForm.action = "?dataday="+valday;
				myReportForm.submit();
				myReportForm.action = "?";
			}
		</script>	
	</HEAD>
	<body>
		<form id="myReportForm" method="post" runat="server">
			<table cellSpacing="0" cellPadding="0" width="780" border="0">
			    <tr><td colspan=2 height=4></td></tr>
				<tr>
					<td>
						&nbsp;&nbsp;报表查询
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a onclick="checkaction('1')" href="#">昨天</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a onclick="checkaction('7')" href="#">一星期</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a onclick="checkaction('3')" href="#">星期一至今天</a>
					</td>
					<td width="30"></td>
				</tr>
				<tr>
					<td colSpan="2" height="4"></td>
				</tr>
			</table>
			<table class="tableNoBorder1" cellSpacing="1" cellPadding="0" width="600" border="0">
				<tr height="22">
					<td align="right" width="20%" bgColor="#008080"><font color="white">日期区间:</font></td>
					<td width="80%" bgColor="lightsteelblue">&nbsp; 
						<input class="Text1" id="startTime" type="text" size="20" name="startTime" runat="server"><IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'myReportForm.startTime',true,'yyyy-mm-dd'); return false;" style="CURSOR: hand;"> - 
						<input class="Text1" id="endTime" type="text" size="10" name="endTime" runat="server"><IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'myReportForm.endTime',true,'yyyy-mm-dd'); return false;" style="CURSOR: hand;">	
						<select name="lt_num" class="za_select" onChange="document.myReportForm.startTime.value=this.value;document.myReportForm.endTime.value=this.value;">
              <option value="<%#  DateTime.Today.ToString("yyyy-MM-dd")%>"> 请选取期数 </option>
              <%# kyglcontent %>
                         
                       
                        </select>										
					</td>
				</tr>
				<tr height="22">
					<td align="right" bgColor="#008080"><font color="white">报表分类:</font></td>
					<td width="80%" bgColor="lightsteelblue">&nbsp;
						<asp:dropdownlist id="reportType" Runat="server">
							<asp:ListItem Value="ledger">总帐</asp:ListItem>
							<asp:ListItem Value="breakdown">分类帐</asp:ListItem>
							
						</asp:dropdownlist></td>
				</tr>
				<tr height="22">
					<td align="right" bgColor="#008080"><font color="white">信用/现金:</font></td>
					<td width="80%" bgColor="lightsteelblue">&nbsp;
						<asp:dropdownlist id="tzCase" Runat="server">
							<asp:ListItem Value="all">全部</asp:ListItem>
							<asp:ListItem Value="credit">信用</asp:ListItem>													
						</asp:dropdownlist></td>
				</tr>
				<tr height="22">
					<td align="right" bgColor="#008080"><font color="white">投注方式:</font></td>
					<td width="80%" bgColor="lightsteelblue">&nbsp;
						<asp:dropdownlist id="tzType" Runat="server">
							<asp:ListItem Value="all">全部</asp:ListItem>
							<asp:ListItem Value="8">特别号</asp:ListItem>
							<asp:ListItem Value="1">特别号:单双</asp:ListItem>
							<asp:ListItem Value="2">特别号:大小</asp:ListItem>
							<asp:ListItem Value="3">特别号:合数单双</asp:ListItem>
							<asp:ListItem Value="17">色波</asp:ListItem>
							<asp:ListItem Value="9">正码</asp:ListItem>
							<asp:ListItem Value="4">总和:单双</asp:ListItem>
							<asp:ListItem Value="5">总和:大小</asp:ListItem>
							<asp:ListItem Value="6">正码1-6:单双</asp:ListItem>
							<asp:ListItem Value="7">正码1-6:大小</asp:ListItem>
							<asp:ListItem Value="10">正码1-6:色波</asp:ListItem>
							<asp:ListItem Value="11">三全中</asp:ListItem>
							<asp:ListItem Value="12">三中二</asp:ListItem>
							<asp:ListItem Value="13">二全中</asp:ListItem>
							<asp:ListItem Value="14">二中特</asp:ListItem>
							<asp:ListItem Value="15">特串</asp:ListItem>
							<asp:ListItem Value="16">正码过关</asp:ListItem>
							<asp:ListItem Value="18">生肖</asp:ListItem>
							<asp:ListItem Value="19">一肖</asp:ListItem>							
							<asp:ListItem Value="20">六肖</asp:ListItem>
							<asp:ListItem Value="21">半波</asp:ListItem><asp:ListItem Value="22">特码补牌</asp:ListItem>
						</asp:dropdownlist>
					</td>
				</tr>
				<tr height="28">
					<td width="100%" bgColor="white" colSpan="2">
						<table border=0 cellpadding = 0 cellspacing = 0>
							<tr><td height = 5></td></tr>
							<tr><td>&nbsp;<asp:label id="showTime2" Runat="server"></asp:label><asp:label id="showNo" Runat="server"></asp:label></td></tr>
							<tr><td height = 5></td></tr>
							<tr><td>&nbsp;<asp:Button id="searchButton" Text="查 询" Runat="server" CssClass="text" />&nbsp;&nbsp; <input type="button" name="cancel" value="取 消" class="text" onclick="window.history.back();"></td></tr>
							<tr><td height = 5></td></tr>
						</table>		
					</td>
				</tr>
			</table>			
		</form>
	</body>
</HTML>
