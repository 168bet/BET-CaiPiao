/*-----------------------------------------------------------------------------------------------------/
	Javascript for betting matches interface
	Author	: Ben Foo
	Updates	: 18/07/2003 Eugene - Hide overunder column when sysparameter overunder = off
						   		- Added Comments
			  01/08/2003 Eugene	- Fix odds2 hiding
			  13/08/2003 Ben	- Add danger feature
			  109/2003 SM		- Add the (o) at the over/under column
			  12/12/2003 Seng   - Add the simplified language
			  26/01/2004 - (Benny) Favourite team color.
/-----------------------------------------------------------------------------------------------------*/

/* Draw Title */
function dT(title, type, refresh, size){
	setLanguageCaption();
	if(size > 1){
		document.writeln('<div class="pageTitle" align=left>'+title+' <span id="countdown" style="font-weight:bold">'+countDownTime+'</span>&nbsp;<a href="?gt=ah" target="_self">'+refresh+'</a> <a href="select-league.aspx?kygl='+type+'" target="_self">'+select_league_cap+'</a></div>');
	}else{
		document.writeln('<div class="pageTitle" align=left>'+title+' <span id="countdown" style="font-weight:bold"></span>&nbsp;<a href="?gt='+type+'" target="_self">'+refresh+'</a> <a href="select-league.aspx?kygl='+type+'" target="_self">'+select_league_cap+'</a></div>');
	}
}

function MudT(title, type, refresh, size,thispage,tt){
	setLanguageCaption();
	if(size > 1){
		document.writeln('<div class="pageTitle" align=left>'+title+' <span id="countdown" style="font-weight:bold">'+countDownTime+'</span>&nbsp;<a href="?gt=ah&page='+thispage+'" target="_self">'+refresh+'</a> <a href="select-league.aspx?kygl='+type+'" target="_self">'+select_league_cap+'</a>');
			if(thispage == 'before')
				document.writeln('&nbsp;&nbsp;&nbsp;<a href=betting-matches.aspx?gt=ah&page=before target=_self><font color=blue><b>'+tt+'前球赛</b></font></a>&nbsp;&nbsp;&nbsp;<a href=betting-matches.aspx?gt=ah&page=after target=_self><font color=blue>'+tt+'后球赛</font></a>');	
			else
				document.writeln('&nbsp;&nbsp;&nbsp;<a href=betting-matches.aspx?gt=ah&page=before target=_self><font color=blue>'+tt+'前球赛</font></a>&nbsp;&nbsp;&nbsp;<a href=betting-matches.aspx?gt=ah&page=after target=_self><font color=blue><b>'+tt+'后球赛</b></font></a>');	
		document.writeln('</div>');
	}else{
		document.writeln('<div class="pageTitle" align=left>'+title+' <span id="countdown" style="font-weight:bold"></span>&nbsp;<a href="?gt='+type+'&page='+thispage+'" target="_self">'+refresh+'</a> <a href="select-league.aspx?kygl='+type+'" target="_self">'+select_league_cap+'</a>');
			if(thispage == 'before')
				document.writeln('&nbsp;&nbsp;&nbsp;<a href=betting-matches.aspx?gt=ah&page=before target=_self><font color=blue><b>'+tt+'前球赛</b></font></a>&nbsp;&nbsp;&nbsp;<a href=betting-matches.aspx?gt=ah&page=after target=_self><font color=blue>'+tt+'后球赛</font></a>');	
			else
				document.writeln('&nbsp;&nbsp;&nbsp;<a href=betting-matches.aspx?gt=ah&page=before target=_self><font color=blue>'+tt+'前球赛</font></a>&nbsp;&nbsp;&nbsp;<a href=betting-matches.aspx?gt=ah&page=after target=_self><b><font color=blue>'+tt+'后球赛</b></font></a>');	

		document.writeln('</div>');
	}
}

/* Draw Table Title */
function dTT(time, type, score, homeaway, ahhandicap, overunder, remark, browser, minute, connection){
	document.writeln('<table class="bet_screen" cellspacing=1>');
	document.writeln('	<tr>');
	document.writeln('		<th width=10% nowrap>'+league_cap+'</th>');
	document.writeln('		<th width=10% nowrap>'+time+'</th>');
	document.writeln('		<th ');	if(type != 'RAH'){document.writeln('style="display:none"');} document.writeln('  width=10%>'+score+'</th>');
	document.writeln('		<th width=31%>'+homeaway+'</th>');
	document.writeln('		<th width=19%>'+ahhandicap+'</th>');
	
	/* Over under caption */
	if(this_overunder=='1'){	document.writeln('		<th width=19%>'+overunder+'</th>');}
	
	/* Remark caption */
	if(type != 'RAH'){	document.writeln('<th width=11%>'+remark+'</th>');	}
	
	document.writeln('	</tr>');
	document.writeln('	<tr id="timeout" style="display:none"><td><br>'+browser+' <span id="minute">0</span> '+minute+'.<br><br>'+connection+'<br><br></td></tr>');
}




/* Draw League Title */
function dLT(leagueindex, league){
	document.writeln('<tr><td class="league" colspan=6 id="lea'+leagueindex+'">'+league+'</td></tr>');
}


/* Draw Main */
function dM(matchindex, matchdate, type, runningscorea, runningscoreb, teama, homeaway, teamb, favourite, handicap, odds, odds2, ouhandicap, outype, ouodds, closingtime, rb2, ouodds2, danger, leagueindex, league_short_cap, league_color){

	var setting_danger_highlight = 'style="background-color:#ffc4c4"';
	
	/* Danger status */
	if(danger == 1){
		danger_tr_class = 'class="danger"';
		danger_class = 'wager_danger'
	}else{
		danger_tr_class = 'class="nodanger"';
		danger_class = 'wager'
	}
	
	/* Print handicap wager */
	document.writeln('<tr id="tr'+matchindex+'H" '+danger_tr_class+' >');
	document.writeln('	<td rowspan=2 id="lea'+leagueindex+'" class="league2" style="background-color:'+league_color+'">'+league_short_cap+'</td>');
	document.writeln('	<td rowspan=2>'+matchdate+'</td>');
	document.writeln('	<td rowspan=2 id="scr'+matchindex+'" '); 
	if(type != 'RAH'){	document.writeln('style="display:none"');	} 
	if(type == 'RAH')
		document.writeln('><a href=history-goal.aspx?bid='+matchindex+' target=_self>'+runningscorea+'-'+runningscoreb+'</a></td>');
	else
		document.writeln('>'+runningscorea+'-'+runningscoreb+'</td>');

	/* Print team with team colouring */
	if(thisTeamColouring=='favourite'){
		if(favourite=="H"){
			document.writeln('<td class="team" rowspan=2 id="team'+matchindex+'"><span style="color:red; font: '+font_style+';">'+teama+'&nbsp;'+homeaway+'&nbsp;</span><br>'+teamb+'</td>');
		}else{
			document.writeln('<td class="team" rowspan=2 id="team'+matchindex+'">'+teama+'&nbsp;'+homeaway+'&nbsp;<br><span style="color:red; font: '+font_style+';">'+teamb+'</span></td>');
		}
	}else if(thisTeamColouring=='home'){
		document.writeln('<td class="team" rowspan=2 id="team'+matchindex+'"><span style="color:red; font: '+font_style+';">'+teama+'&nbsp;'+homeaway+'&nbsp;</span><br>'+teamb+'</td>');
	}else{
		document.writeln('<td class="team" rowspan=2 id="team'+matchindex+'">'+teama+'&nbsp;'+homeaway+'&nbsp;<br>'+teamb+'</td>');
	}
	
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');

	/* Hide ah odds if no odds */
	if(odds == 0 || odds2 == 0){
		handicap = '&nbsp;';
		odds = '&nbsp;';
		odds2 = '&nbsp;';
	}
	
	/* Hide ou odds if no odds */
	if(this_overunder=='1' && (ouodds == 0 || ouodds2 == 0)){
		ouhandicap = '&nbsp;';
		ouodds = '&nbsp;';
		ouodds2 = '&nbsp;';
		o_cap = '&nbsp;';
	}
	
	/* Print AH wager */
	if(favourite == 'H'){
		document.writeln('		<tr>');
		document.writeln('		<td class="hdp" id="hdp'+matchindex+'H">'+handicap+'</td>');
		document.writeln('		<td class="odds" id="odds'+matchindex+'H"><a href="betting-entry.aspx?m='+matchindex+',1,'+type+'">'+odds+'</a></td>');
		document.writeln('		</tr>');
	}else{
		document.writeln('		<tr>');
		document.writeln('		<td class="hdp" id="hdp'+matchindex+'H">&nbsp;</td>');
		document.writeln('		<td class="odds" id="odds'+matchindex+'H"><a href="betting-entry.aspx?m='+matchindex+',1,'+type+'">'+odds2+'</a></td>');
		document.writeln('		</tr>');
	}
	document.writeln('		</table>');
	document.writeln('	</td>');

	/* Print overunder wager a */
	if(this_overunder=='1'){
		document.writeln('	<td>');
		document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
		document.writeln('			<tr>');
		document.writeln('			<td class="hdp" id="ouhdp'+matchindex+'H">'+o_cap+''+ouhandicap+'</td>');
		document.writeln('			<td class="odds" id="ouodds'+matchindex+'H"><a href="betting-entry.aspx?m='+matchindex+',1,'+outype+'">'+ouodds+'</a></td>');
		document.writeln('			</tr>');
		document.writeln('		</table>');
		document.writeln('	</td>');
	}
	
	/* Remark data */
	if(type != 'RAH'){
		document.writeln('<td rowspan=2>');
		if(closingtime < 0){ document.writeln('<span style="background-color:#ff8284">'+rb2+'</span>'); }
		document.writeln('</td>');
	}		
	
	document.writeln('</tr>');
	document.writeln('<tr id="tr'+matchindex+'C" '+danger_tr_class+' >');
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');

	/* Ah favourite on top */
	if(favourite == 'H'){
		document.writeln('		<tr>');
		document.writeln('			<td class="hdp" id="hdp'+matchindex+'C">&nbsp;</td>');
		document.writeln('			<td class="odds" id="odds'+matchindex+'C"><a href="betting-entry.aspx?m='+matchindex+',2,'+type+'">'+odds2+'</a></td>');
		document.writeln('		</tr>');
		
	/* Ah favourite at bottom */
	}else{
		document.writeln('		<tr>');
		document.writeln('			<td class="hdp" id="hdp'+matchindex+'C">'+handicap+'</td>');
		document.writeln('			<td class="odds" id="odds'+matchindex+'C"><a href="betting-entry.aspx?m='+matchindex+',2,'+type+'">'+odds+'</a></td>');
		document.writeln('		</tr>');
	}
	
	document.writeln('		</table>');
	document.writeln('	</td>');
	
	/* Print overunder wager a */
	if(this_overunder=='1'){
		document.writeln('	<td>');
		document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
		document.writeln('			<tr>');
		document.writeln('			<td class="hdp" id="ouhdp'+matchindex+'C">&nbsp;</td>');
		document.writeln('			<td class="odds" id="ouodds'+matchindex+'C"><a href="betting-entry.aspx?m='+matchindex+',2,'+outype+'">'+ouodds2+'</a></td>');
		document.writeln('			</tr>');
		document.writeln('		</table>');
		document.writeln('	</td>');
	}
	document.writeln('</tr>');
	document.writeln('<tr id="sp'+matchindex+'"><td colspan=6 class="spacer"></td></tr>');
}




/* 走地 */

function dTT_Z(time, type, score, homeaway, ahhandicap, overunder, remark, browser, minute, connection){
	document.writeln('<table class="bet_screen" cellspacing=1>');
	document.writeln('	<tr>');
	document.writeln('		<th width=10% nowrap>'+league_cap+'</th>');
	document.writeln('		<th width=10% nowrap>'+time+'</th>');
	document.writeln('		<th width=23%>'+homeaway+'</th>');
	document.writeln('		<th ');	if(type != 'RAH'){document.writeln('style="display:none"');} document.writeln('  width=8%>'+score+'</th>');	
	document.writeln('		<th width=19%>'+ahhandicap+'</th>');
	
	/* Over under caption */
	if(this_overunder=='1'){	document.writeln('		<th width=19%>'+overunder+'</th>');}
	
	/* Remark caption */
	if(type == 'RAH'){	document.writeln('<th width=11%>'+remark+'</th>');	}
	
	document.writeln('	</tr>');
	document.writeln('	<tr id="timeout" style="display:none"><td><br>'+browser+' <span id="minute">0</span> '+minute+'.<br><br>'+connection+'<br><br></td></tr>');
}


function dM_Z(matchindex, matchdate, type, runningscorea, runningscoreb, teama, homeaway, teamb, favourite, handicap, odds, odds2, ouhandicap, outype, ouodds, closingtime, rb2, ouodds2, danger, leagueindex, league_short_cap, league_color,bsingle,btwin){

	var setting_danger_highlight = 'style="background-color:#ffc4c4"';
	
	/* Danger status */
	if(danger == 1){
		danger_tr_class = 'class="danger"';
		danger_class = 'wager_danger'
	}else{
		danger_tr_class = 'class="nodanger"';
		danger_class = 'wager'
	}
	
	/* Print handicap wager */
	document.writeln('<tr id="tr'+matchindex+'H" '+danger_tr_class+' >');
	document.writeln('	<td rowspan=2 id="lea'+leagueindex+'" class="league2" style="background-color:'+league_color+'">'+league_short_cap+'</td>');
	document.writeln('	<td rowspan=2>'+matchdate+'</td>');	
	
	/* Print team with team colouring */
	if(thisTeamColouring=='favourite'){
		if(favourite=="H"){
			document.writeln('<td class="team" rowspan=2 id="team'+matchindex+'"><span style="color:red; font: '+font_style+';">'+teama+'&nbsp;'+homeaway+'&nbsp;</span><br>'+teamb+'</td>');
		}else{
			document.writeln('<td class="team" rowspan=2 id="team'+matchindex+'">'+teama+'&nbsp;'+homeaway+'&nbsp;<br><span style="color:red; font: '+font_style+';">'+teamb+'</span></td>');
		}
	}else if(thisTeamColouring=='home'){
		document.writeln('<td class="team" rowspan=2 id="team'+matchindex+'"><span style="color:red; font: '+font_style+';">'+teama+'&nbsp;'+homeaway+'&nbsp;</span><br>'+teamb+'</td>');
	}else{
		document.writeln('<td class="team" rowspan=2 id="team'+matchindex+'">'+teama+'&nbsp;'+homeaway+'&nbsp;<br>'+teamb+'</td>');
	}
	
	
	document.writeln('	<td rowspan=2 id="scr'+matchindex+'" '); 
	if(type != 'RAH'){	document.writeln('style="display:none"');	} 
	if(type == 'RAH')
		//document.writeln('><a href=history-goal.aspx?bid='+matchindex+' target=_self>'+runningscorea+'-'+runningscoreb+'</a></td>');
		document.writeln('>'+runningscorea+'-'+runningscoreb+'</td>');
	else
		document.writeln('>'+runningscorea+'-'+runningscoreb+'</td>');
	
	
	
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');

	/* Hide ah odds if no odds */
	if(odds == 0 || odds2 == 0){
		handicap = '&nbsp;';
		odds = '&nbsp;';
		odds2 = '&nbsp;';
	}
	
	/* Hide ou odds if no odds */
	if(this_overunder=='1' && (ouodds == 0 || ouodds2 == 0)){
		ouhandicap = '&nbsp;';
		ouodds = '&nbsp;';
		ouodds2 = '&nbsp;';
		o_cap = '&nbsp;';
	}
	
	/* Print AH wager */
	if(favourite == 'H'){
		document.writeln('		<tr>');
		document.writeln('		<td class="hdp" id="hdp'+matchindex+'H">'+handicap+'</td>');
		document.writeln('		<td class="odds" id="odds'+matchindex+'H"><a href="betting-entry.aspx?m='+matchindex+',1,'+type+'">'+odds+'</a></td>');
		document.writeln('		</tr>');
	}else{
		document.writeln('		<tr>');
		document.writeln('		<td class="hdp" id="hdp'+matchindex+'H">&nbsp;</td>');
		document.writeln('		<td class="odds" id="odds'+matchindex+'H"><a href="betting-entry.aspx?m='+matchindex+',1,'+type+'">'+odds2+'</a></td>');
		document.writeln('		</tr>');
	}
	document.writeln('		</table>');
	document.writeln('	</td>');

	/* Print overunder wager a */
	if(this_overunder=='1'){
		document.writeln('	<td>');
		document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
		document.writeln('			<tr>');
		document.writeln('			<td class="hdp" id="ouhdp'+matchindex+'H">'+o_cap+''+ouhandicap+'</td>');
		document.writeln('			<td class="odds" id="ouodds'+matchindex+'H"><a href="betting-entry.aspx?m='+matchindex+',1,'+outype+'">'+ouodds+'</a></td>');
		document.writeln('			</tr>');
		document.writeln('		</table>');
		document.writeln('	</td>');
	}
	
	
	//单双 
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	document.writeln('			<tr>');
	if(bsingle=='')
		document.writeln('			<td class="odds" id="oeodds'+matchindex+'H"><a href="betting-entry.aspx?m='+matchindex+',1,ROE"></a></td>');
	else
		document.writeln('			<td class="odds" id="oeodds'+matchindex+'H"><a href="betting-entry.aspx?m='+matchindex+',1,ROE"><font color=blue>单</font>　'+bsingle+'</a></td>');
	document.writeln('			</tr>');
	document.writeln('		</table>');
	document.writeln('	</td>');
	
	
//=================================================================================================================================
	document.writeln('</tr>');
	document.writeln('<tr id="tr'+matchindex+'C" '+danger_tr_class+' >');
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');

	/* Ah favourite on top */
	if(favourite == 'H'){
		document.writeln('		<tr>');
		document.writeln('			<td class="hdp" id="hdp'+matchindex+'C">&nbsp;</td>');
		document.writeln('			<td class="odds" id="odds'+matchindex+'C"><a href="betting-entry.aspx?m='+matchindex+',2,'+type+'">'+odds2+'</a></td>');
		document.writeln('		</tr>');
		
	/* Ah favourite at bottom */
	}else{
		document.writeln('		<tr>');
		document.writeln('			<td class="hdp" id="hdp'+matchindex+'C">'+handicap+'</td>');
		document.writeln('			<td class="odds" id="odds'+matchindex+'C"><a href="betting-entry.aspx?m='+matchindex+',2,'+type+'">'+odds+'</a></td>');
		document.writeln('		</tr>');
	}
	
	document.writeln('		</table>');
	document.writeln('	</td>');
	
	/* Print overunder wager a */
	if(this_overunder=='1'){
		document.writeln('	<td>');
		document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
		document.writeln('			<tr>');
		document.writeln('			<td class="hdp" id="ouhdp'+matchindex+'C">&nbsp;</td>');
		document.writeln('			<td class="odds" id="ouodds'+matchindex+'C"><a href="betting-entry.aspx?m='+matchindex+',2,'+outype+'">'+ouodds2+'</a></td>');
		document.writeln('			</tr>');
		document.writeln('		</table>');
		document.writeln('	</td>');
	}	
	
	//单双 
	document.writeln('	<td>');
	document.writeln('		<table class="'+danger_class+'" cellspacing=0 cellpadding=0>');
	document.writeln('			<tr>');
	if(btwin=='')
		document.writeln('			<td class="odds" id="oeodds'+matchindex+'C"><a href="betting-entry.aspx?m='+matchindex+',2,ROE"></a></td>');
	else
		document.writeln('			<td class="odds" id="oeodds'+matchindex+'C"><a href="betting-entry.aspx?m='+matchindex+',2,ROE"><font color=blue>双</font>　'+btwin+'</a></td>');
	document.writeln('			</tr>');
	document.writeln('		</table>');
	document.writeln('	</td>');
	document.writeln('</tr>');
	
	document.writeln('<tr id="sp'+matchindex+'"><td colspan=7 class="spacer"></td></tr>');
}





/*-------------------------------------------------/
	Language Caption
/-------------------------------------------------*/
function setLanguageCaption() {
	if(thisLanguage=="english"){
		select_league_cap = "Select League";
		o_cap = "<span style=\"font-family: arial; font-size: 11px;\">o</span>";
		league_cap = "League";
		
	}else if(thisLanguage=="traditional"){
		select_league_cap = "匡拒羛辽";
		o_cap = "<span style=\"font-family: arial; font-size: 11px;\"></span>";
		league_cap = "羛辽";

	}else if(thisLanguage=="simplified"){
		select_league_cap = "选择联赛";
		//o_cap = "<span style=\"font-family: arial; font-size: 11px;\">大</span>";
		o_cap = "<span style=\"font-family: arial; font-size: 11px;\"></span>";
		league_cap = "联赛";

	}
}

self.status = '. . .';
