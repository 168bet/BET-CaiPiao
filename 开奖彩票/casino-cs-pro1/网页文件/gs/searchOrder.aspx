<%@ Page language="c#" Codebehind="searchOrder.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.myForm" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>������ѯ</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<link href="css/rep.css" type="text/css" rel="stylesheet">
		<script language="javascript" src="js/calendar.js" type="text/javascript"></script>
		<script src="js/hint.js"></script>
		<script>document.write(div);</script>
	</HEAD>
	<body leftMargin="3" topMargin="3" onload="CloseHint();">
		<form id="myForm" method="post" runat="server" name="myForm">
			<table cellSpacing="1" cellPadding="3" width="500" bgColor="#000000" border="0">
				<TR>
					<td class="blueheader" width="500" colSpan="2" height="22">������ѯ</td>
				</TD>
				<tr>
					<td class="TableBody1" align="right" width="100">��������</td>
					<td class="TableBody1" width="400">
						<asp:TextBox id="TextBoxStart_Date" runat="server" CssClass="text" Width="80px"></asp:TextBox><IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'myForm.TextBoxStart_Date',true,'yyyy-mm-dd'); return false;"
							style="CURSOR: hand">&nbsp;
						<asp:TextBox id="TextBoxStart_Time" runat="server" Width="60px" CssClass="text">00:00:00</asp:TextBox>~
						<asp:TextBox id="TextBoxEnd_Date" runat="server" CssClass="text" Width="80px"></asp:TextBox><IMG src="images/calendar.gif" align="absMiddle" border="0" onClick="g_Calendar.show(event,'myForm.TextBoxEnd_Date',true,'yyyy-mm-dd'); return false;"
							style="CURSOR: hand">
						<asp:TextBox id="TextBoxEnd_Time" runat="server" Width="60px" CssClass="text">23:59:59</asp:TextBox>
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right">����״̬</td>
					<td class="TableBody1">
						<asp:DropDownList id="DropDownListJs" runat="server">
							<asp:ListItem Value="">ȫ��</asp:ListItem>
							<asp:ListItem Value="1">�ѽ���</asp:ListItem>
							<asp:ListItem Value="0" Selected="True">δ����</asp:ListItem>
							<asp:ListItem Value="2">��ȡ��</asp:ListItem>
						</asp:DropDownList>
					</td>
				</tr>
				
				<tr>
					<td class="TableBody1" align="right">Ͷע��ʽ
					</td>
					<td class="TableBody1">
						<asp:DropDownList id="DropDownListTzType" runat="server">
							<asp:ListItem Selected="True" Value="">ȫ��</asp:ListItem>
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
						</asp:DropDownList>
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right">�� ��</td>
					<td class="TableBody1">
						<asp:DropDownList id="DropDownListGd" runat="server" OnSelectedIndexChanged="DropDownListGd_SelectedIndexChanged"
							AutoPostBack="True"></asp:DropDownList>
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right" style="HEIGHT: 15px">�ܴ���</td>
					<td class="TableBody1" style="HEIGHT: 15px">
						<asp:DropDownList id="DropDownListZdl" runat="server" OnSelectedIndexChanged="DropDownListZdl_SelectedIndexChanged"
							AutoPostBack="True"></asp:DropDownList>
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right">������</td>
					<td class="TableBody1">
						<asp:DropDownList id="DropDownListDls" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListDls_SelectedIndexChanged"></asp:DropDownList>
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right">�� ��
					</td>
					<td class="TableBody1">
						<asp:DropDownList id="DropDownListUser" runat="server"></asp:DropDownList>
						<asp:TextBox id="TextBoxUserName" runat="server" Width="100px" CssClass="text"></asp:TextBox>
					</td>
				</tr>
				<TR>
					<TD class="TableBody1" align="right"><FONT face="����">�� ��</FONT></TD>
					<TD class="TableBody1">
						<asp:DropDownList id="DropDownListRR" runat="server">
							<asp:ListItem Value="1" Selected="True">ȫ��</asp:ListItem>
							<asp:ListItem Value="0">Ϊ��</asp:ListItem>
							<asp:ListItem Value="w">Ӯ</asp:ListItem>
							<asp:ListItem Value="s">��</asp:ListItem>
						</asp:DropDownList></TD>
				</TR>
				<tr>
					<td class="TableBody1" align="right">������
					</td>
					<td class="TableBody1">
						<asp:TextBox id="TextBoxOrderid" runat="server" CssClass="text" Width="100px"></asp:TextBox>
					</td>
				</tr>
				<TR>
					<TD class="TableBody1" align="right"><FONT face="����">��ע�����</FONT></TD>
					<TD class="TableBody1"><FONT face="����">
							<asp:TextBox id="TextBoxTzMoney" runat="server" Width="100px" CssClass="text"></asp:TextBox></FONT></TD>
				</TR>
				<TR>
					<TD class="TableBody1" align="center" colSpan="2"><asp:button id="buttonsearch" Runat="server" Text="��  ѯ" CssClass="Text"></asp:button>&nbsp;&nbsp;&nbsp;
						<INPUT class="text" id="inputcancel" type="button" value="ȡ  ��" onclick="javascript:history.go(-1);">
					</TD>
				</TR>
			</table>
			<BR>
			<BR>
		</form>
	</body>
</HTML>
