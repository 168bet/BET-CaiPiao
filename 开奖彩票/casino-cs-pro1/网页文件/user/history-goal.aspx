<%@ Page language="c#" Codebehind="history-goal.aspx.cs" AutoEventWireup="false" Inherits="newball.user.history_goal" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>history-goal</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/user.css" type="text/css" rel="stylesheet">
		<SCRIPT language="JavaScript" src="js/function-no-copying.js"></SCRIPT>
	</HEAD>
	<body topMargin="0">
		<form id="Form1" method="post" runat="server">
			<TABLE class="bet_enq" cellSpacing="1" width="300">
				<TBODY>
					<TR>
						<TH colSpan="2">
							<%# kyglTeam %>
						</TH>
					</TR>
					<%# kyglList %>
				</TBODY>
			</TABLE>
		</form>
		<DIV id="footer"><%# System.Configuration.ConfigurationSettings.AppSettings["CopyRight"] %></DIV>
	</body>
</HTML>
