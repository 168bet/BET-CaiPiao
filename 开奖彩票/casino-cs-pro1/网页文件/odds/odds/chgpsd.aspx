<%@ Page language="c#" Codebehind="chgpsd.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.odds.chgpsd" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>chgpsd</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="3" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="宋体">
				<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="300" border="0">
					<TR>
						<TD colSpan="3">修改密码</TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="3" width="350" bgColor="#000000" border="0">
								<TR class="blueheader">
									<TD align="center" colSpan="2">修改密码</TD>
								</TR>
								<TR bgColor="#ffffff">
									<TD style="WIDTH: 109px">旧密码</TD>
									<TD>
										<asp:TextBox id="TextBoxOldPsd" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></TD>
								</TR>
								<TR bgColor="#ffffff">
									<TD style="WIDTH: 109px">新密码</TD>
									<TD>
										<asp:TextBox id="TextBoxUserPass1" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox><FONT color="red">(不修改不用填)</FONT></TD>
								</TR>
								<TR bgColor="#ffffff">
									<TD style="WIDTH: 109px">确认密码</TD>
									<TD>
										<asp:TextBox id="TextBoxUserPass2" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox><FONT color="red">(不修改不用填)</FONT></TD>
								</TR>
								<TR bgColor="#ffffff">
									<TD align="center" colSpan="2">
										<asp:Button id="ButtonOk" runat="server" CssClass="text" Text=" 确定 "></asp:Button>&nbsp;
										<asp:Button id="ButtonCancel" runat="server" CssClass="text" Text=" 取消 "></asp:Button></TD>
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
