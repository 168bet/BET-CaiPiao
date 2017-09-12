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
						&nbsp;&nbsp;�����ѯ
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a onclick="checkaction('1')" href="#">����</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a onclick="checkaction('7')" href="#">һ����</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a onclick="checkaction('3')" href="#">����һ������</a>
					</td>
					<td width="30"></td>
				</tr>
				<tr>
					<td colSpan="2" height="4"></td>
				</tr>
			</table>
			<table class="tableNoBorder1" cellSpacing="1" cellPadding="0" width="600" border="0">
				<tr height="22">
					<td align="right" width="20%" bgColor="#008080"><font color="white">��������:</font></td>
					<td width="80%" bgColor="lightsteelblue">&nbsp; 
						<input class="Text1" id="startTime" type="text" size="20" name="startTime" runat="server"><IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'myReportForm.startTime',true,'yyyy-mm-dd'); return false;" style="CURSOR: hand;"> - 
						<input class="Text1" id="endTime" type="text" size="10" name="endTime" runat="server"><IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'myReportForm.endTime',true,'yyyy-mm-dd'); return false;" style="CURSOR: hand;">	
						<select name="lt_num" class="za_select" onChange="document.myReportForm.startTime.value=this.value;document.myReportForm.endTime.value=this.value;">
              <option value="<%#  DateTime.Today.ToString("yyyy-MM-dd")%>"> ��ѡȡ���� </option>
              <%# kyglcontent %>
                         
                       
                        </select>										
					</td>
				</tr>
				<tr height="22">
					<td align="right" bgColor="#008080"><font color="white">�������:</font></td>
					<td width="80%" bgColor="lightsteelblue">&nbsp;
						<asp:dropdownlist id="reportType" Runat="server">
							<asp:ListItem Value="ledger">����</asp:ListItem>
							<asp:ListItem Value="breakdown">������</asp:ListItem>
							
						</asp:dropdownlist></td>
				</tr>
				<tr height="22">
					<td align="right" bgColor="#008080"><font color="white">����/�ֽ�:</font></td>
					<td width="80%" bgColor="lightsteelblue">&nbsp;
						<asp:dropdownlist id="tzCase" Runat="server">
							<asp:ListItem Value="all">ȫ��</asp:ListItem>
							<asp:ListItem Value="credit">����</asp:ListItem>													
						</asp:dropdownlist></td>
				</tr>
				<tr height="22">
					<td align="right" bgColor="#008080"><font color="white">Ͷע��ʽ:</font></td>
					<td width="80%" bgColor="lightsteelblue">&nbsp;
						<asp:dropdownlist id="tzType" Runat="server">
							<asp:ListItem Value="all">ȫ��</asp:ListItem>
							<asp:ListItem Value="8">�ر��</asp:ListItem>
							<asp:ListItem Value="1">�ر��:��˫</asp:ListItem>
							<asp:ListItem Value="2">�ر��:��С</asp:ListItem>
							<asp:ListItem Value="3">�ر��:������˫</asp:ListItem>
							<asp:ListItem Value="17">ɫ��</asp:ListItem>
							<asp:ListItem Value="9">����</asp:ListItem>
							<asp:ListItem Value="4">�ܺ�:��˫</asp:ListItem>
							<asp:ListItem Value="5">�ܺ�:��С</asp:ListItem>
							<asp:ListItem Value="6">����1-6:��˫</asp:ListItem>
							<asp:ListItem Value="7">����1-6:��С</asp:ListItem>
							<asp:ListItem Value="10">����1-6:ɫ��</asp:ListItem>
							<asp:ListItem Value="11">��ȫ��</asp:ListItem>
							<asp:ListItem Value="12">���ж�</asp:ListItem>
							<asp:ListItem Value="13">��ȫ��</asp:ListItem>
							<asp:ListItem Value="14">������</asp:ListItem>
							<asp:ListItem Value="15">�ش�</asp:ListItem>
							<asp:ListItem Value="16">�������</asp:ListItem>
							<asp:ListItem Value="18">��Ф</asp:ListItem>
							<asp:ListItem Value="19">һФ</asp:ListItem>							
							<asp:ListItem Value="20">��Ф</asp:ListItem>
							<asp:ListItem Value="21">�벨</asp:ListItem><asp:ListItem Value="22">���벹��</asp:ListItem>
						</asp:dropdownlist>
					</td>
				</tr>
				<tr height="28">
					<td width="100%" bgColor="white" colSpan="2">
						<table border=0 cellpadding = 0 cellspacing = 0>
							<tr><td height = 5></td></tr>
							<tr><td>&nbsp;<asp:label id="showTime2" Runat="server"></asp:label><asp:label id="showNo" Runat="server"></asp:label></td></tr>
							<tr><td height = 5></td></tr>
							<tr><td>&nbsp;<asp:Button id="searchButton" Text="�� ѯ" Runat="server" CssClass="text" />&nbsp;&nbsp; <input type="button" name="cancel" value="ȡ ��" class="text" onclick="window.history.back();"></td></tr>
							<tr><td height = 5></td></tr>
						</table>		
					</td>
				</tr>
			</table>			
		</form>
	</body>
</HTML>
