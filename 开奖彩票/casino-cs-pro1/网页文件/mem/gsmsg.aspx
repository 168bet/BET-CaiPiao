<%@ Page language="c#" Codebehind="gsmsg.aspx.cs" AutoEventWireup="false" Inherits="mem.gsmsg" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>adminmsg</title>
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
						<TD colSpan="3"><FONT face="����">��˾���� &gt;&gt; �޸� --<a href="gdlist.aspx">������ҳ</a></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="3" width="100%" border="0" bgcolor="#000000">
								<TBODY>
									<TR bgcolor="#3399cc">
										<TD colSpan="2" align="center" style="COLOR: white">���������趨</TD>
									</TR>
									<TR>
										<TD style="WIDTH: 182px" align="right" class="TableBody1"><FONT face="����">�ʺ�:</FONT></TD>
										<TD class="TableBody1">
											<asp:TextBox id="TextBoxUserName" runat="server" CssClass="Text" ReadOnly="True" BorderWidth="0px"></asp:TextBox></TD>
									</TR>
									<TR>
										<TD align="right" class="TableBody1"><FONT face="����">������:</FONT></TD>
										<TD class="TableBody1"><FONT face="����" color="#ff0000">
												<asp:TextBox id="TextBoxNewpass1" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
									</TR>
									<TR>
										<TD align="right" class="TableBody1"><FONT face="����">ȷ������:</FONT></TD>
										<TD class="TableBody1"><FONT face="����" color="#ff0000">
												<asp:TextBox id="TextBoxNewpass2" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
									</TR>
									<TR>
										<TD align="right" class="TableBody1"><FONT face="����">��˾����:</FONT></TD>
										<TD class="TableBody1">
											<asp:TextBox id="TextBoxTrueName" runat="server" CssClass="Text" MaxLength="8"></asp:TextBox></TD>
									</TR>
									<TR>
										<TD class="TableBody1" align="right">�����ö��:</TD>
										<TD class="TableBody1"><asp:textbox id="TextBoxUseMoney" runat="server" CssClass="Text"></asp:textbox>&nbsp;
											<asp:Label id="Label1" runat="server" Width="288px"></asp:Label>
										</TD>
									</TR>
									<TR>
										<TD class="TableBody1" align="right">����Ա��:</TD>
										<TD class="TableBody1">
											<asp:TextBox id="TextBoxMaxMem" runat="server" CssClass="Text">0</asp:TextBox><font color="red">(0Ϊ������)</font></TD>
									</TR>
									<TR>
										<TD colSpan="2" class="TableBody1" align="center"><FONT face="����">
												<asp:Button id="ButtonModify" runat="server" Text="�� ��" CssClass="Text"></asp:Button>&nbsp;&nbsp;
												<asp:Button id="ButtonSave" runat="server" Text="�� ��" CssClass="Text"></asp:Button>&nbsp;&nbsp;
												<asp:Button id="ButtonCancel" runat="server" Text="�� ��" CssClass="Text"></asp:Button></FONT></TD>
									</TR>
									<asp:TextBox id="TextBoxGsID" runat="server" Visible="False"></asp:TextBox>
						</TD>
				</TABLE>
				</TD></TR>
				<TR>
					<TD colSpan="3"><FONT face="����"></FONT></TD>
				</TR>
				<TR>
					<TD colSpan="3"></TD>
				</TR>
				<TR>
					<TD colSpan="3"><FONT face="����"></FONT></TD>
				</TR>
				</TBODY></TABLE> </FONT>
		</form>
		<script language="javascript" type="text/javascript">
			document.all.TextBoxNewpass1.value = "<%= pubshowpass%>";
			document.all.TextBoxNewpass2.value = "<%= pubshowpass%>";
		</script>
	</body>
</HTML>
