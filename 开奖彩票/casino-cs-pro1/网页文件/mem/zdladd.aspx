<%@ Page language="c#" Codebehind="zdladd.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.zdladd" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>gdadd</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="1" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="����">
				<TABLE id="Table1" cellSpacing="1" cellPadding="3" width="700" border="0">
					<TR>
						<TD colSpan="3"><FONT face="����">
								&nbsp;����ܴ���&nbsp; --<A href="javascript:history.back(1);">������ҳ</A></FONT>
						</TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="3" width="100%" bgColor="#000000" border="0">
								<TR>
									<TD class="pinkheader" align="center" colSpan="2">���������趨</TD>
								</TR>
								<tr>
									<td class="TableBody1" style="WIDTH: 182px" align="right"><FONT face="����">�ɶ�:</FONT></td>
									<TD class="TableBody1">
										<asp:DropDownList ID="DropDownListGd" Runat="server" BorderWidth="1px" CssClass="Text"></asp:DropDownList>
									</TD>
								</tr>
								<TR>
									<TD class="TableBody1" style="WIDTH: 182px" align="right"><FONT face="����">�ʺ�:</FONT></TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxUserName" runat="server" BorderWidth="1px" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">����:</FONT></TD>
									<TD class="TableBody1"><FONT face="����" color="#ff0000">
											<asp:TextBox id="TextBoxNewpass1" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">ȷ������:</FONT></TD>
									<TD class="TableBody1"><FONT face="����" color="#ff0000">
											<asp:TextBox id="TextBoxNewpass2" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">�ܴ�������:</FONT></TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxTrueName" runat="server" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">�绰:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxTel" runat="server" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">�ʺ�״̬:</FONT></TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropDownListIsUseAble" runat="server">
											<asp:ListItem Value="1" Selected="True">����</asp:ListItem>
											<asp:ListItem Value="0">ͣ��</asp:ListItem>
										</asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">�����ö��:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxUseMoney" runat="server" CssClass="Text">0</asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">����Ա��:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxMaxMem" runat="server" CssClass="Text">0</asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="center" colSpan="2"><FONT face="����">
											<asp:Button id="ButtonSave" runat="server" CssClass="Text" Text="�� ��"></asp:Button>&nbsp;&nbsp;
											<asp:Button id="ButtonCancel" runat="server" CssClass="Text" Text="ȡ ��"></asp:Button></FONT></TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="����"></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3"></TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="����"></FONT></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
	</body>
</HTML>
