<%@ Page language="c#" Codebehind="system800.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.system800" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>system800</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<link href="css/css.css" type="text/css" rel="stylesheet">
		<LINK href="css/rep.css" type="text/css" rel="stylesheet">		
		<script language="javascript" src="js/calendar.js" type="text/javascript">	
		</script>
		<script language="javascript" type="text/javascript">
			function checksystem800()
			{
				if(document.system800Form.username.value == "")
				{
					alert("请选择会员帐号！");
					return false;
				}
				return true;
			}
			function appbutton_click(eventTarget, eventArgument)
			{
				if(!confirm('确定'+eventTarget.value+'！'))
					return;
				
				system800Form.action = "?sysid="+eventArgument;
				system800Form.submit();
				system800Form.action = "?";				
				return;
			}
		</script>
	</HEAD>
	<body>
		<form id="system800Form" method="post" runat="server" onsubmit="return checksystem800();">
			<table cellSpacing="0" cellPadding="0" width="800" border="0">
				<tr>
					<td colSpan="2" height="4"></td>
				</tr>
				<tr>
					<td>&nbsp;会员帐号：<asp:dropdownlist id="username" Runat="server">
							<asp:ListItem Value=""></asp:ListItem>
						</asp:dropdownlist>
						<asp:dropdownlist id="tzType" Runat="server">
							<asp:ListItem Value="全部">全部</asp:ListItem>
							<asp:ListItem Value="投注额">投注额</asp:ListItem>
							<asp:ListItem Value="赢">赢</asp:ListItem>
							<asp:ListItem Value="输">输</asp:ListItem>
							<asp:ListItem Value="和">和</asp:ListItem>
							<asp:ListItem Value="按金">按金</asp:ListItem>
							<asp:ListItem Value="现金提款">现金提款</asp:ListItem>
						</asp:dropdownlist>
																		
						&nbsp;&nbsp; 日期区间: 
						<input class="Text1" id="startTime" readOnly type="text" size="10" name="startTime" runat="server"><IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'system800Form.startTime',true,'yyyy-mm-dd'); return false;" style="CURSOR: hand;"> - 
						<input class="Text1" id="endTime" readOnly type="text" size="10" name="endTime" runat="server"><IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'system800Form.endTime',true,'yyyy-mm-dd'); return false;" style="CURSOR: hand;">&nbsp;&nbsp;&nbsp;
																													
						<asp:button id="searchButton" Runat="server" Text="查 询"></asp:button>&nbsp;&nbsp;
						 <!--第<asp:dropdownlist id="thePage" Runat="server" AutoPostBack="True"></asp:dropdownlist>页  --屏蔽翻页程序-- -->&nbsp;
						<input class="Text" onclick="window.location = 'system800add.aspx';" type="button" value="新 增" name="addbutton">
					</td>
					<td width="30"></td>
				</tr>
				<tr>
					<td colSpan="2" height="4"></td>
				</tr>
			</table>
			
			
			<!--显示table的内容-->
			<table border="0" cellpadding="0" cellspacing="0" runat="server" width="780" id="tableList">
				<tr>
					<td></td>
				</tr>
			</table>
			<!--结束table的内容-->
			
			
		</form>
	</body>
</HTML>
<!--end page 结束页面-->
