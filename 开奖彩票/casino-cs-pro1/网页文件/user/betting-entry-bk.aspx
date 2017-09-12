<%@ Page language="c#" Codebehind="betting-entry-bk.aspx.cs" AutoEventWireup="false" Inherits="user.betting_entry_bk" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<script>if(self == top) location='../';</script>
<HTML>
	<HEAD>
		<META http-equiv="content-type" content="text/html; charset=gb2312">
		<LINK href="css/user.css" type="text/css" rel="stylesheet">
		<SCRIPT language="JavaScript" src="js/function-no-status-msg.js"></SCRIPT>
		<SCRIPT language="JavaScript" src="js/function-no-copying.js"></SCRIPT>
		<SCRIPT language=JavaScript src="js/toFmt.js"></SCRIPT>
		<SCRIPT language=JavaScript src="js/bet-entry.js"></SCRIPT>
		<SCRIPT>						
			function disableEnterKey() { if (window.event.keyCode == 13) window.event.keyCode = 0; }			
			function doError() {}
			thisLanguage = 'simplified';
			
			function cancelParlayBet(thisObj){
				href_var = "action=kygl&req_ahmatchlist="+myForm.req_ahmatchlist.value+"&req_userbet_list="+myForm.req_userbet_list.value;
				window.location.href = "betting-entry-bk.aspx?"+href_var+"&remove="+thisObj.id;
			}					
	</SCRIPT>
	</HEAD>
	
	<BODY bgColor="#ffffff" background="images/bettingbg.gif" leftmargin="3" topMargin="8" marginheight="3" <%# Addons %>>
			<%# kyglContent %>
	</BODY>
</html>
