<%@ Page language="c#" Codebehind="addbfuser.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.odds.addbfuser" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>addbfuser</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="3" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="����">
				<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="300" border="0">
					<TR>
						<TD colSpan="3">��ӱȷ�Ա</TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="3" width="300" border="0" bgcolor="#000000">
								<TR class="blueheader">
									<TD colSpan="2" align="center">�ȷ�Ա��Ϣ</TD>
								</TR>
								<TR bgcolor="#ffffff">
									<TD style="WIDTH: 109px">�ȷ�Ա�ʺ�</TD>
									<TD>
										<asp:TextBox id="TextBoxUserName" runat="server" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR bgcolor="#ffffff">
									<TD style="WIDTH: 109px">�ȷ�Ա����</TD>
									<TD>
										<asp:TextBox id="TextBoxUserPass1" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></TD>
								</TR>
								<TR bgcolor="#ffffff">
									<TD style="WIDTH: 109px">ȷ������</TD>
									<TD>
										<asp:TextBox id="TextBoxUserPass2" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></TD>
								</TR>
								<TR bgcolor="#ffffff">
									<TD style="WIDTH: 109px">�ȷ�Ա����</TD>
									<TD>
										<asp:TextBox id="TextBoxTrueName" runat="server" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR bgcolor="#ffffff">
									<TD style="WIDTH: 109px">״��</TD>
									<TD>
										<asp:DropDownList id="DropDownListIsuseable" runat="server">
											<asp:ListItem Value="0" Selected="True">ͣ��</asp:ListItem>
											<asp:ListItem Value="1">����</asp:ListItem>
										</asp:DropDownList></TD>
								</TR>
								<TR bgcolor="#ffffff">
									<TD align="center" colspan="2">
										<asp:Button id="ButtonOk" runat="server" Text=" ȷ�� " CssClass="text"></asp:Button>&nbsp;
										<asp:Button id="ButtonCancel" runat="server" Text=" ȡ�� " CssClass="text"></asp:Button></TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD></TD>
						<TD></TD>
						<TD></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
	</body>
</HTML>
