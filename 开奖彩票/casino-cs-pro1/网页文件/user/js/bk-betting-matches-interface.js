/*-----------------------------------------------------------------------------------------------------/
	Javascript for betting matches interface
	Author	: Ben Foo
	Updates	: 18/07/2003 Eugene - Hide overunder column when sysparameter overunder = off
						   		- Added Comments
			  01/08/2003 Eugene	- Fix odds2 hiding
			  13/08/2003 Ben	- Add danger feature
			  109/2003 SM		- Add the (o) at the over/under column
			  12/12/2003 Seng   - Add the simplified language
/-----------------------------------------------------------------------------------------------------*/

/* Draw Title */
function dT(title, type, refresh, size)
{

	setLanguageCaption();

	document.writeln('<div class="pageTitle" align=left>'+title+' <span id="countdown" style="font-weight:bold">&nbsp;</span> <a href="?gt='+type+'" target="_self">'+refresh+'</a> <a href="select-league.aspx?kygl=BKAH" target="_self">'+select_league_cap+'</a></div>');
}

/* Draw Table Title */
function dTT(matchname, time, homeaway, singlebtwin, ahhandicap, bigsmall, browser, minute, connection)
{
	document.writeln('<table class="bet_screen" cellspacing=1>');
	document.writeln('	<tr>');
	//document.writeln('		<th width=10%>'+matchname+'</th>');
	document.writeln('		<th width=10% nowrap>'+time+'</th>');
	document.writeln('		<th width=25%>'+homeaway+'</th>');
	document.writeln('		<th width=25%>'+ahhandicap+'</th>');
	document.writeln('		<th width=25%>'+bigsmall+'</th>');
	document.writeln('		<th width=15%>'+singlebtwin+'</th>');
	document.writeln('	</tr>');
	
	document.writeln('	<tr id="timeout" style="display:none"><td><br>'+browser+' <span id="minute">0</span> '+minute+'.<br><br>'+connection+'<br><br></td></tr>');
}



/* Draw League Title */
function dLT(leagueindex, league){
	document.writeln('<tr><td class="league" colspan=6 id="lea'+leagueindex+'">'+league+'</td></tr>');
}

/* Draw Main */
//function dM(matchindex, matchdate, teama, homeaway, teamb, favourite, handicap, odds, odds2, ouhandicap, outype, ouodds, closingtime, rb2, ouodds2, danger, odd_cap, even_cap, oeodds, oeodds2){
function dM(matchindex, matchdate, team1, homeaway, team2, xenial, giveup, giveup1, giveup2, bigsmall1, bigpl, smallpl, bsingle, btwin, matchname, matchcolor)
{
	var setting_danger_highlight = 'style="background-color:#ffc4c4"';
	
	danger_tr_class = 'class="nodanger"';
	danger_class = 'wager'

	
	/* Print handicap wager */
	document.writeln('<tr id="tr'+matchindex+'a" '+danger_tr_class+' >');
	
	//document.writeln('	<td rowspan=2 bgcolor="'+ matchcolor +'">'+matchname+'</td>');
	document.writeln('	<td rowspan=2 nowrap>'+matchdate+'</td>');
	document.writeln('	<td rowspan=2 class="team"><span style="color:red; font: '+font_style+';">'+team1+'&nbsp;'+homeaway+'&nbsp;</span><br>'+team2+'</td>');
	
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	
	/* Print 让球 */
	if(xenial == 'H'){
		document.writeln('		<tr>');
		document.writeln('		<td class="hdp" id="hdp'+matchindex+'a">'+giveup+'</td>');
		document.writeln('		<td class="odds" id="odds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,bkah" target="bettingLeftFrame">'+giveup1+'</a></td>');
		document.writeln('		</tr>');
	}else{
		document.writeln('		<tr>');
		document.writeln('		<td class="hdp" id="hdp'+matchindex+'a">&nbsp;</td>');
		document.writeln('		<td class="odds" id="odds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,bkah" target="bettingLeftFrame">'+giveup1+'</a></td>');
		document.writeln('		</tr>');
	}
	document.writeln('		</table>');
	document.writeln('	</td>');	
	
	/* Print 大小*/
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	document.writeln('			<tr>');
	document.writeln('			<td class="hdp">'+bigsmall1+'</td>');
	document.writeln('			<td class="odds" id="oeodds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,bkoe" target="bettingLeftFrame">'+bigpl+'</a></td>');
	document.writeln('			</tr>');
	document.writeln('		</table>');
	document.writeln('	</td>');
	
	//print 单
	document.writeln('<td class="odds" id="dsodds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,bkds" target="bettingLeftFrame">'+bsingle+'</a></td>');
	document.writeln('</tr>');
	
	
	
	document.writeln('<tr id="tr'+matchindex+'b" '+danger_tr_class+' >');

	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');	
	if(xenial == 'H'){
		document.writeln('		<tr>');
		document.writeln('			<td class="hdp" id="hdp'+matchindex+'b">&nbsp;</td>');
		document.writeln('			<td class="odds" id="odds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,bkah" target="bettingLeftFrame">'+giveup2+'</a></td>');
		document.writeln('		</tr>');
	}else{
		document.writeln('		<tr>');
		document.writeln('			<td class="hdp" id="hdp'+matchindex+'b">'+giveup+'</td>');
		document.writeln('			<td class="odds" id="odds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,bkah" target="bettingLeftFrame">'+giveup2+'</a></td>');
		document.writeln('		</tr>');
	}	
	document.writeln('		</table>');
	document.writeln('	</td>');
		
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	document.writeln('			<tr>');
	document.writeln('			<td class="hdp" id="oehdp'+matchindex+'b">&nbsp;</td>');
	document.writeln('			<td class="odds" id="oeodds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,bkoe" target="bettingLeftFrame">'+smallpl+'</a></td>');
	document.writeln('			</tr>');
	document.writeln('		</table>');
	document.writeln('	</td>');
	
	//双
	document.writeln('<td class="odds" id="dsodds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,bkds" target="bettingLeftFrame">'+btwin+'</a></td>');

	document.writeln('</tr>');
	document.writeln('<tr id="sp'+matchindex+'"><td colspan=6 class="spacer"></td></tr>');
}





//上半场

function dMU(matchindex, matchdate, team1, homeaway, team2, xenial, giveup, giveup1, giveup2, bigsmall1, bigpl, smallpl, bsingle, btwin, matchname, matchcolor)
{
	var setting_danger_highlight = 'style="background-color:#ffc4c4"';
	
	danger_tr_class = 'class="nodanger"';
	danger_class = 'wager'

	
	/* Print handicap wager */
	document.writeln('<tr id="tr'+matchindex+'a" '+danger_tr_class+' >');
	
	//document.writeln('	<td rowspan=2 bgcolor="'+ matchcolor +'">'+matchname+'</td>');
	document.writeln('	<td rowspan=2 nowrap>'+matchdate+'</td>');
	document.writeln('	<td rowspan=2 class="team"><span style="color:red; font: '+font_style+';">'+team1+'&nbsp;'+homeaway+'&nbsp;</span><br>'+team2+'</td>');
	
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	
	/* Print 让球 */
	if(xenial == 'H'){
		document.writeln('		<tr>');
		document.writeln('		<td class="hdp" id="hdp'+matchindex+'a">'+giveup+'</td>');
		document.writeln('		<td class="odds" id="odds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,ubkah" target="bettingLeftFrame">'+giveup1+'</a></td>');
		document.writeln('		</tr>');
	}else{
		document.writeln('		<tr>');
		document.writeln('		<td class="hdp" id="hdp'+matchindex+'a">&nbsp;</td>');
		document.writeln('		<td class="odds" id="odds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,ubkah" target="bettingLeftFrame">'+giveup1+'</a></td>');
		document.writeln('		</tr>');
	}
	document.writeln('		</table>');
	document.writeln('	</td>');	
	
	/* Print 大小*/
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	document.writeln('			<tr>');
	document.writeln('			<td class="hdp">'+bigsmall1+'</td>');
	document.writeln('			<td class="odds" id="oeodds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,ubkoe" target="bettingLeftFrame">'+bigpl+'</a></td>');
	document.writeln('			</tr>');
	document.writeln('		</table>');
	document.writeln('	</td>');
	
	//print 单
	document.writeln('<td class="odds" id="dsodds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,ubkds" target="bettingLeftFrame">'+bsingle+'</a></td>');
	document.writeln('</tr>');
	
	
	
	document.writeln('<tr id="tr'+matchindex+'b" '+danger_tr_class+' >');

	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');	
	if(xenial == 'H'){
		document.writeln('		<tr>');
		document.writeln('			<td class="hdp" id="hdp'+matchindex+'b">&nbsp;</td>');
		document.writeln('			<td class="odds" id="odds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,ubkah" target="bettingLeftFrame">'+giveup2+'</a></td>');
		document.writeln('		</tr>');
	}else{
		document.writeln('		<tr>');
		document.writeln('			<td class="hdp" id="hdp'+matchindex+'b">'+giveup+'</td>');
		document.writeln('			<td class="odds" id="odds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,ubkah" target="bettingLeftFrame">'+giveup2+'</a></td>');
		document.writeln('		</tr>');
	}	
	document.writeln('		</table>');
	document.writeln('	</td>');
		
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	document.writeln('			<tr>');
	document.writeln('			<td class="hdp" id="oehdp'+matchindex+'b">&nbsp;</td>');
	document.writeln('			<td class="odds" id="oeodds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,ubkoe" target="bettingLeftFrame">'+smallpl+'</a></td>');
	document.writeln('			</tr>');
	document.writeln('		</table>');
	document.writeln('	</td>');
	
	//双
	document.writeln('<td class="odds" id="dsodds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,ubkds" target="bettingLeftFrame">'+btwin+'</a></td>');

	document.writeln('</tr>');
	document.writeln('<tr id="sp'+matchindex+'"><td colspan=6 class="spacer"></td></tr>');
}



//下半场

function dMD(matchindex, matchdate, team1, homeaway, team2, xenial, giveup, giveup1, giveup2, bigsmall1, bigpl, smallpl, bsingle, btwin, matchname, matchcolor)
{
	var setting_danger_highlight = 'style="background-color:#ffc4c4"';
	
	danger_tr_class = 'class="nodanger"';
	danger_class = 'wager'

	
	/* Print handicap wager */
	document.writeln('<tr id="tr'+matchindex+'a" '+danger_tr_class+' >');
	
	//document.writeln('	<td rowspan=2 bgcolor="'+ matchcolor +'">'+matchname+'</td>');
	document.writeln('	<td rowspan=2 nowrap>'+matchdate+'</td>');
	document.writeln('	<td rowspan=2 class="team"><span style="color:red; font: '+font_style+';">'+team1+'&nbsp;'+homeaway+'&nbsp;</span><br>'+team2+'</td>');
	
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	
	/* Print 让球 */
	if(xenial == 'H'){
		document.writeln('		<tr>');
		document.writeln('		<td class="hdp" id="hdp'+matchindex+'a">'+giveup+'</td>');
		document.writeln('		<td class="odds" id="odds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,dbkah" target="bettingLeftFrame">'+giveup1+'</a></td>');
		document.writeln('		</tr>');
	}else{
		document.writeln('		<tr>');
		document.writeln('		<td class="hdp" id="hdp'+matchindex+'a">&nbsp;</td>');
		document.writeln('		<td class="odds" id="odds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,dbkah" target="bettingLeftFrame">'+giveup1+'</a></td>');
		document.writeln('		</tr>');
	}
	document.writeln('		</table>');
	document.writeln('	</td>');	
	
	/* Print 大小*/
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	document.writeln('			<tr>');
	document.writeln('			<td class="hdp">'+bigsmall1+'</td>');
	document.writeln('			<td class="odds" id="oeodds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,dbkoe" target="bettingLeftFrame">'+bigpl+'</a></td>');
	document.writeln('			</tr>');
	document.writeln('		</table>');
	document.writeln('	</td>');
	
	//print 单
	document.writeln('<td class="odds" id="dsodds'+matchindex+'a"><a href="betting-entry-bk.aspx?m='+matchindex+',1,dbkds" target="bettingLeftFrame">'+bsingle+'</a></td>');
	document.writeln('</tr>');
	
	//--------------------------------------------------下面是第二行-----------------------------------------------------------
	
	document.writeln('<tr id="tr'+matchindex+'b" '+danger_tr_class+' >');

	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');	
	if(xenial == 'H'){
		document.writeln('		<tr>');
		document.writeln('			<td class="hdp" id="hdp'+matchindex+'b">&nbsp;</td>');
		document.writeln('			<td class="odds" id="odds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,dbkah" target="bettingLeftFrame">'+giveup2+'</a></td>');
		document.writeln('		</tr>');
	}else{
		document.writeln('		<tr>');
		document.writeln('			<td class="hdp" id="hdp'+matchindex+'b">'+giveup+'</td>');
		document.writeln('			<td class="odds" id="odds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,dbkah" target="bettingLeftFrame">'+giveup2+'</a></td>');
		document.writeln('		</tr>');
	}	
	document.writeln('		</table>');
	document.writeln('	</td>');
		
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	document.writeln('			<tr>');
	document.writeln('			<td class="hdp" id="oehdp'+matchindex+'b">&nbsp;</td>');
	document.writeln('			<td class="odds" id="oeodds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,dbkoe" target="bettingLeftFrame">'+smallpl+'</a></td>');
	document.writeln('			</tr>');
	document.writeln('		</table>');
	document.writeln('	</td>');
	
	//双
	document.writeln('<td class="odds" id="dsodds'+matchindex+'b"><a href="betting-entry-bk.aspx?m='+matchindex+',2,dbkds" target="bettingLeftFrame">'+btwin+'</a></td>');

	document.writeln('</tr>');
	document.writeln('<tr id="sp'+matchindex+'"><td colspan=6 class="spacer"></td></tr>');
}


/*-------------------------------------------------/
	Language Caption
/-------------------------------------------------*/
function setLanguageCaption() {
	if(thisLanguage=="english"){
		select_league_cap = "Select League";
		o_cap = "<span style=\"font-family: arial; font-size: 11px;\">o</span>";
		
	}else if(thisLanguage=="traditional"){
		select_league_cap = "匡拒羛辽";
		o_cap = "<span style=\"font-family: arial; font-size: 11px;\"></span>";

	}else if(thisLanguage=="simplified"){
		select_league_cap = "选择联赛";
		o_cap = "<span style=\"font-family: arial; font-size: 11px;\">大</span>";

	}
}