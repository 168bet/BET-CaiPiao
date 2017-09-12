<%@ Page language="c#" Codebehind="betting-entry.aspx.cs" AutoEventWireup="false" Inherits="newball.user.betting_entry" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<script>if(self == top) location='../';</script>
<HTML>
	<HEAD>
		<TITLE></TITLE>
		<META http-equiv="content-type" content="text/html; charset=gb2312">
		
		<LINK href="css/mem_order.css" type="text/css" rel="stylesheet">
			<SCRIPT language="JavaScript" src="js/function-no-status-msg.js"></SCRIPT>
			<SCRIPT language="JavaScript" src="js/function-no-copying.js"></SCRIPT>
			<SCRIPT language=JavaScript src="js/toFmt.js"></SCRIPT>
			<SCRIPT language=JavaScript src="js/bet-entry.js"></SCRIPT>			
			<SCRIPT>
				<%# bettype %>		
				function disableEnterKey() { if (window.event.keyCode == 13) window.event.keyCode = 0; }
				
				function doError() {
					}
				thisLanguage = 'simplified';
				
				function cancelParlayBet(thisObj){
					href_var = "action=kygl&req_matchlist="+myForm.req_matchlist.value+"&req_userbet_list="+myForm.req_userbet_list.value;//+"&req_odds_list="+myForm.req_odds_list.value;
					window.location.href = "betting-entry.aspx?req_parlay_submit=1&"+href_var+"&remove="+thisObj.id;
					//alert("?req_parlay_submit=1&"+href_var+"&remove="+thisObj.id);
				}
				
				function cancelPAHParlayBet(thisObj){
					href_var = "action=kygl&req_ahmatchlist="+myForm.req_ahmatchlist.value+"&req_ahuserbet_list="+myForm.req_ahuserbet_list.value;//+"&req_ahodds_list="+myForm.req_ahodds_list.value;
					window.location.href = "betting-entry.aspx?req_ahparlay_submit=1&"+href_var+"&remove="+thisObj.id;
				}
				
				function cancelCSParlayBet(thisObj){
					href_var = "action=kygl&req_csmatchlist="+myForm.req_csmatchlist.value+"&req_csuserbet_list="+myForm.req_csuserbet_list.value;//+"&req_ahodds_list="+myForm.req_ahodds_list.value;
					window.location.href = "betting-entry.aspx?req_csparlay_submit=1&"+href_var+"&remove="+thisObj.id;
					
				}	
				
				function cancelHTParlayBet(thisObj){
					href_var = "action=kygl&req_htmatchlist="+myForm.req_htmatchlist.value+"&req_htuserbet_list="+myForm.req_htuserbet_list.value;//+"&req_ahodds_list="+myForm.req_ahodds_list.value;
					window.location.href = "betting-entry.aspx?req_htparlay_submit=1&"+href_var+"&remove="+thisObj.id;
					
				}		

				function cancelBKPAHParlayBet(thisObj){
					href_var = "bk_req_ahmatchlist="+myForm.bk_req_ahmatchlist.value+"&bk_req_ahuserbet_list="+myForm.bk_req_ahuserbet_list.value+"&bk_req_ahodds_list="+myForm.bk_req_ahodds_list.value;
					window.location.href = "?bk_req_ahparlay_submit=1&"+href_var+"&remove="+thisObj.id;
				}
			</SCRIPT>
	</HEAD>	
	<BODY oncontextmenu=window.event.returnValue=false bgColor=#e5eaee leftMargin=0 topMargin=0 <%# Addons %> >

			<%# kyglContent %>
			
	</BODY>
</HTML>
