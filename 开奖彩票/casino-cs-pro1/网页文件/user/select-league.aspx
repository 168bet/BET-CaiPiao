<%@ Page language="c#" Codebehind="select-league.aspx.cs" AutoEventWireup="false" Inherits="newball.select_league"   %>
<script>if(self == top) location='../';</script>
<HTML>
	<HEAD>
		<title></title>
		<LINK href="css/user.css" type="text/css" rel="stylesheet">
			<meta http-equiv="content-type" content="text/html; charset=gb2312">
			<script language="JavaScript" src="js/global-checkbox-checker.js"></script>
			<script language="JavaScript" src="js/function-no-status-msg.js"></script>
		<script language="JavaScript" src="js/function-no-copying.js"></script>
	</HEAD>
	<body>
		<form name="myForm" action="select-league.aspx?kygl=<%# kygl %>" method="post" id="myForm">
			<div class="pageTitle">
				ѡ������ - <a href="#" onClick="document.myForm.submit()">���</a> &nbsp;<a href="#" onClick="history.back()">����</a>
			</div>
			<table border="0" cellspacing="1" class="league_select" id="MainTable" runat="server">
				<tr>
					<th width="150">
						<input type="checkbox" name="fr_checkall" onClick="checkThis2('fr_league',this);">����</th></tr>
				<tr>
					<td align="left"></td>
				</tr>
			</table>
			<input type="hidden" name="action" value="<%# kygl %>"> <input type="hidden" name="fr_list">
		</form>
		<div id="footer"><%# System.Configuration.ConfigurationSettings.AppSettings["CopyRight"] %></div>
	</body>
</HTML>
