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
					alert("��ѡ���Ա�ʺţ�");
					return false;
				}
				return true;
			}
			function appbutton_click(eventTarget, eventArgument)
			{
				if(!confirm('ȷ��'+eventTarget.value+'��'))
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
					<td>&nbsp;��Ա�ʺţ�<asp:dropdownlist id="username" Runat="server">
							<asp:ListItem Value=""></asp:ListItem>
						</asp:dropdownlist>
						<asp:dropdownlist id="tzType" Runat="server">
							<asp:ListItem Value="ȫ��">ȫ��</asp:ListItem>
							<asp:ListItem Value="Ͷע��">Ͷע��</asp:ListItem>
							<asp:ListItem Value="Ӯ">Ӯ</asp:ListItem>
							<asp:ListItem Value="��">��</asp:ListItem>
							<asp:ListItem Value="��">��</asp:ListItem>
							<asp:ListItem Value="����">����</asp:ListItem>
							<asp:ListItem Value="�ֽ����">�ֽ����</asp:ListItem>
						</asp:dropdownlist>
																		
						&nbsp;&nbsp; ��������: 
						<input class="Text1" id="startTime" readOnly type="text" size="10" name="startTime" runat="server"><IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'system800Form.startTime',true,'yyyy-mm-dd'); return false;" style="CURSOR: hand;"> - 
						<input class="Text1" id="endTime" readOnly type="text" size="10" name="endTime" runat="server"><IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'system800Form.endTime',true,'yyyy-mm-dd'); return false;" style="CURSOR: hand;">&nbsp;&nbsp;&nbsp;
																													
						<asp:button id="searchButton" Runat="server" Text="�� ѯ"></asp:button>&nbsp;&nbsp;
						 <!--��<asp:dropdownlist id="thePage" Runat="server" AutoPostBack="True"></asp:dropdownlist>ҳ  --���η�ҳ����-- -->&nbsp;
						<input class="Text" onclick="window.location = 'system800add.aspx';" type="button" value="�� ��" name="addbutton">
					</td>
					<td width="30"></td>
				</tr>
				<tr>
					<td colSpan="2" height="4"></td>
				</tr>
			</table>
			
			
			<!--��ʾtable������-->
			<table border="0" cellpadding="0" cellspacing="0" runat="server" width="780" id="tableList">
				<tr>
					<td></td>
				</tr>
			</table>
			<!--����table������-->
			
			
		</form>
	</body>
</HTML>
<!--end page ����ҳ��-->
