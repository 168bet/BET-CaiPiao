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
						&nbsp;&nbsp;�����ѯ
					</td>
					<td width="30"><img src="images/top_04.gif" width="30" height="24"></td>
				</tr>
				<tr>
					<td colspan="2" height="4"></td>
				</tr>
			</table>
			
			<table border="0" cellspacing="1" cellpadding="0" width="600" class="tableNoBorder1">
				<tr height="22">
					<td bgcolor="#008080" width="20%" align="right"><font color="white">��������:</font></td>
					<td bgcolor="lightsteelblue" width="80%">&nbsp; <input type="text" name="startTime" id="startTime" size="10" readonly class="Text1" runat="server"><a onclick="calendar(document.forms[0].startTime);return false;" href="javascript:void(0)"><img height="22" alt="" src="images/show-calendar.gif" width="34" align="absMiddle" border="0"></a>~~
						<input type="text" name="endTime" id="endTime" size="10" readonly class="Text1" runat="server"><a onclick="calendar(document.forms[0].endTime);return false;" href="javascript:void(0)"><img height="22" alt="" src="images/show-calendar.gif" width="34" align="absMiddle" border="0"></a>
					</td>
				</tr>
				<tr height="22">
					<td bgcolor="#008080" align="right"><font color="white">�������:</font></td>
					<td bgcolor="lightsteelblue" width="80%">&nbsp;
						<asp:DropDownList ID="reportType" Runat="server">
							<asp:ListItem Value="ledger">����</asp:ListItem>
							<asp:ListItem Value="breakdown">������</asp:ListItem>
							<asp:ListItem Value="soccer">����</asp:ListItem>
							<asp:ListItem Value="basketball">����</asp:ListItem>
						</asp:DropDownList>
					</td>
				</tr>
				<tr height="22">
					<td bgcolor="#008080" align="right"><font color="white">����/�ֽ�:</font></td>
					<td bgcolor="lightsteelblue" width="80%">&nbsp;
						<asp:DropDownList ID="tzCase" Runat="server">
							<asp:ListItem Value="all">ȫ��</asp:ListItem>
							<asp:ListItem Value="credit">����</asp:ListItem>
							<asp:ListItem Value="cash">�ֽ�</asp:ListItem>
						</asp:DropDownList>
					</td>
				</tr>
				<tr height="22">
					<td bgcolor="#008080" align="right"><font color="white">Ͷע��ʽ:</font></td>
					<td bgcolor="lightsteelblue" width="80%">&nbsp;
						<asp:DropDownList ID="tzType" Runat="server">
							<asp:ListItem Value="all">ȫ��</asp:ListItem>							
							<asp:ListItem Value="1X2">��׼</asp:ListItem>
							<asp:ListItem Value="AH">����</asp:ListItem>
							<asp:ListItem Value="AHHT">����-�ϰ볡</asp:ListItem>							
							<asp:ListItem Value="CS">����</asp:ListItem>
							<asp:ListItem Value="HT">��/ȫ��</asp:ListItem>
							<asp:ListItem Value="OE">��/˫</asp:ListItem>
							<asp:ListItem Value="OU">��С</asp:ListItem>
							<asp:ListItem Value="OUHT">��С-�ϰ볡</asp:ListItem>
							<asp:ListItem Value="P1X2">��׼����</asp:ListItem>
							<asp:ListItem Value="PAH">��Ϲ���</asp:ListItem>
							<asp:ListItem Value="RAH">�ߵ�-����</asp:ListItem>
							<asp:ListItem Value="ROU">�ߵ�-��С</asp:ListItem>
							<asp:ListItem Value="TG">������</asp:ListItem>
							<asp:ListItem Value="EAH">�������</asp:ListItem>
							<asp:ListItem Value="EOU">��ʹ�С</asp:ListItem>
							<asp:ListItem Value="BKAH">����-����</asp:ListItem>
							<asp:ListItem Value="BKOE">����-��/˫</asp:ListItem>
							<asp:ListItem Value="BKOU">����-����</asp:ListItem>
							<asp:ListItem Value="BKPAH">����-��Ϲ���</asp:ListItem>
						</asp:DropDownList>
					</td>
				</tr>
				<tr height="28">
					<td colspan="2" width="100%" bgcolor="white">&nbsp;
						<asp:Label ID="showTime1" Runat="server">*</asp:Label><asp:Label ID="showAlready" Runat="server">[]</asp:Label><br>
						&nbsp;
						<asp:Label ID="showTime2" Runat="server">*</asp:Label><asp:Label ID="showNo" Runat="server">[]</asp:Label><br>
						&nbsp;
						<asp:Button id="searchButton" Text="�� ѯ" Runat="server" />&nbsp;&nbsp; <input type="button" name="cancel" value="ȡ ��" onclick="window.history.back();">
					</td>
				</tr>
			</table>
		</form>		
	</body>
</HTML>
