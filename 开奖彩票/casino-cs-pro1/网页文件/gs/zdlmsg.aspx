<%@ Page language="c#" Codebehind="zdlmsg.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.zdlmsg" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>gdmsg</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="1" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="����">
				<TABLE id="Table1" cellSpacing="1" cellPadding="3" width="1000" border="0">
					<TR>
						<TD colSpan="3"><FONT face="����">�ܴ���&nbsp;�޸��ܴ���
								<asp:Label id="LabelZdl" runat="server">Label</asp:Label>
								&nbsp; --<A href="zdllist.aspx">������ҳ</A></FONT></TD>
					</TR>
					<TR>
						<TD align="left" colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="3" width="60%" bgColor="#000000" border="0">
								<TR>
									<TD class="pinkheader" align="center" colSpan="2">���������趨</TD>
								</TR>
								<TR>
									<TD class="TableBody1" style="WIDTH: 150px" align="right"><FONT face="����">�ʺ�:</FONT></TD>
									<TD class="TableBody1"><asp:textbox id="TextBoxUserName" runat="server" BorderWidth="0px" ReadOnly="True" CssClass="Text"></asp:textbox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">������:</FONT></TD>
									<TD class="TableBody1"><FONT face="����" color="#ff0000"><asp:textbox id="TextBoxNewpass1" runat="server" CssClass="Text" TextMode="Password"></asp:textbox>
											<asp:textbox id="TextBoxZdlID" runat="server" Visible="False"></asp:textbox>
											<asp:textbox id="TextBoxGdID" runat="server" Visible="False"></asp:textbox>
										</FONT>
									</TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">ȷ������:</FONT></TD>
									<TD class="TableBody1"><FONT face="����" color="#ff0000"><asp:textbox id="TextBoxNewpass2" runat="server" CssClass="Text" TextMode="Password"></asp:textbox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">�ܴ�������:</FONT></TD>
									<TD class="TableBody1"><asp:textbox id="TextBoxTrueName" runat="server" CssClass="Text"></asp:textbox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">�绰:</TD>
									<TD class="TableBody1">
										<asp:textbox id="TextBoxTel" runat="server" CssClass="Text"></asp:textbox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">�ʺ�״̬:</FONT></TD>
									<TD class="TableBody1"><asp:dropdownlist id="DropDownListIsUseAble" runat="server">
											<asp:ListItem Value="1" Selected="True">����</asp:ListItem>
											<asp:ListItem Value="0">ͣ��</asp:ListItem>
										</asp:dropdownlist></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">�����ö��:</TD>
									<TD class="TableBody1"><asp:textbox id="TextBoxUseMoney" runat="server" CssClass="Text"></asp:textbox>&nbsp;
										<asp:Label id="Label1" runat="server" Width="288px">Label</asp:Label></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">����Ա��:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxMaxMem" runat="server" CssClass="Text">0</asp:TextBox><font color="red">(0Ϊ������)</font></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="center" colSpan="2"><FONT face="����"><asp:button id="ButtonModify" runat="server" CssClass="Text" Text="�� ��"></asp:button>&nbsp;&nbsp;
											<asp:button id="ButtonSave" runat="server" CssClass="Text" Text="�� ��"></asp:button>&nbsp;&nbsp;
											<asp:button id="ButtonCancel" runat="server" CssClass="Text" Text="�� ��"></asp:button></FONT></TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR height="22">
						<TD colSpan="3"><FONT face="����"></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3">
						</TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="����"></FONT></TD>
					</TR>
				</TABLE>
				<P>&nbsp;</P>
				<P>&nbsp;</P>
				<P>&nbsp;</P>
				<P>&nbsp;</P>
				<P>&nbsp;</P>
				<P>&nbsp;</P>
				<P>
			</FONT>&nbsp;</P></form>
		<script language="javascript" type="text/javascript">
	document.all.TextBoxNewpass1.value = "<%= pubshowpass%>";
	document.all.TextBoxNewpass2.value = "<%= pubshowpass%>";
		</script>
	</body>
</HTML>
