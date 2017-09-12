<%@ Page language="c#" Codebehind="MgrOnlineMsg.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.gj.MgrOnlineMsg" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>MgrOnlineMsg</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="../css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body topMargin="5">
		<form id="Form1" method="post" runat="server">
			<FONT face="ËÎÌå">
				<TABLE id="UserEventTable" cellSpacing="0" cellPadding="0" width="776" border="0" runat="server">
					<TR>
						<TD style="WIDTH: 283px"></TD>
						<TD align="right"><INPUT type="button" value="·µ »Ø" style="WIDTH: 65px" onclick="javascript:window.location.href='MgrOnline.aspx';">
							<INPUT style="WIDTH: 65px" type="button" value="Ë¢ ÐÂ" onclick="javascript:window.location.href='mgronlinemsg.aspx?username=<%# Request.QueryString["username"].Trim()%>'"></TD>
					</TR>
					<TR>
						<TD colSpan="2"></TD>
					</TR>
					<TR>
						<TD colSpan="2"></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
	</body>
</HTML>
