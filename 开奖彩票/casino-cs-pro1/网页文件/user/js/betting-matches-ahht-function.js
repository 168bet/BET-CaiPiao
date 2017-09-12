/*--------------------------------------------------------------------------------------------/
	Script	: betting-matches-function.js
	Usage	: user betting matches functions
	Author	: Eugene KH Lau
	Updates	: 04/07/2003 - Support changed color for newly changed odds
			  06/07/2003 - Added new function to clear new changed odds indicator
			  26/01/2004 - (Benny) Favourite team color.
/--------------------------------------------------------------------------------------------*/

/* Set new changes odds style */
var setting_changes_highlight = 'style="background-color:yellow"';

/* Refresh Asian Handicap Wager */
function refreshAsianHandicapWager(favourite, handicapCaption, odds1, odds2, bettype, changes){
	
	/* Set changes highlight - 04/07/2003 Eugene */
	if(changes=='1'){
		changes_highlight = setting_changes_highlight;
	}else{
		changes_highlight = '';
	}
	
	/* Print favourite at top */
	if(favourite=='H'){
		thisObj.getElementById('hdp'+thisActiveIndex+'C').innerHTML = '';
		if(odds1 == 0 || odds2 == 0){
			thisObj.getElementById('hdp'+thisActiveIndex+'H').innerHTML = '&nbsp;';
			thisObj.getElementById('odds'+thisActiveIndex+'H').innerHTML = '&nbsp;';
			thisObj.getElementById('odds'+thisActiveIndex+'C').innerHTML = '&nbsp;';
		}else{
			thisObj.getElementById('hdp'+thisActiveIndex+'H').innerHTML = handicapCaption;
			if(odds1 != thisObj.getElementById('odds'+thisActiveIndex+'H').outerText)
				thisObj.getElementById('odds'+thisActiveIndex+'H').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',1,'+bettype+'" '+changes_highlight+'>'+odds1+'</a>';
			else
				thisObj.getElementById('odds'+thisActiveIndex+'H').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',1,'+bettype+'">'+odds1+'</a>';
			if(odds2 != thisObj.getElementById('odds'+thisActiveIndex+'C').outerText)
				thisObj.getElementById('odds'+thisActiveIndex+'C').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',2,'+bettype+'" '+changes_highlight+'>'+odds2+'</a>';
			else
				thisObj.getElementById('odds'+thisActiveIndex+'C').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',2,'+bettype+'">'+odds2+'</a>';
		}
	
	/* Print favourite at top */
	}else{
		thisObj.getElementById('hdp'+thisActiveIndex+'H').innerHTML = '';
		if(odds1 == 0 || odds2 == 0){
			thisObj.getElementById('hdp'+thisActiveIndex+'C').innerHTML = '&nbsp;';
			thisObj.getElementById('odds'+thisActiveIndex+'H').innerHTML = '&nbsp;';
			thisObj.getElementById('odds'+thisActiveIndex+'C').innerHTML = '&nbsp;';
		}else{
			thisObj.getElementById('hdp'+thisActiveIndex+'C').innerHTML = handicapCaption;
			if(odds2 != thisObj.getElementById('odds'+thisActiveIndex+'H').outerText)
				thisObj.getElementById('odds'+thisActiveIndex+'H').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',1,'+bettype+'" '+changes_highlight+'>'+odds2+'</a>';
			else
				thisObj.getElementById('odds'+thisActiveIndex+'H').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',1,'+bettype+'">'+odds2+'</a>';
			if(odds1 != thisObj.getElementById('odds'+thisActiveIndex+'C').outerText)
				thisObj.getElementById('odds'+thisActiveIndex+'C').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',2,'+bettype+'" '+changes_highlight+'>'+odds1+'</a>';
			else
				thisObj.getElementById('odds'+thisActiveIndex+'C').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',2,'+bettype+'">'+odds1+'</a>';
		}
	}
}

/* Refresh Over Under Wager */
function refreshOverUnderWager(handicapCaption, odds1, odds2, bettype, changes){

	/* Set changes highlight - 04/07/2003 Eugene */
	if(changes=='1'){
		changes_highlight = setting_changes_highlight;
	}else{
		changes_highlight = '';
	}
	
	/* Print overunder odds */
	if(odds1 == 0 || odds2 == 0){
		thisObj.getElementById('ouhdp'+thisActiveIndex+'H').innerHTML = '&nbsp;';
		
		thisObj.getElementById('ouodds'+thisActiveIndex+'H').innerHTML = '&nbsp;';
		thisObj.getElementById('ouodds'+thisActiveIndex+'C').innerHTML = '&nbsp;';
	}else{
		thisObj.getElementById('ouhdp'+thisActiveIndex+'H').innerHTML = handicapCaption;
		if(odds1 != thisObj.getElementById('ouodds'+thisActiveIndex+'H').outerText)
			thisObj.getElementById('ouodds'+thisActiveIndex+'H').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',1,'+bettype+'" '+changes_highlight+'>'+odds1+'</a>';
		else
			thisObj.getElementById('ouodds'+thisActiveIndex+'H').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',1,'+bettype+'">'+odds1+'</a>';
		if(odds2 != thisObj.getElementById('ouodds'+thisActiveIndex+'C').outerText)
			thisObj.getElementById('ouodds'+thisActiveIndex+'C').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',2,'+bettype+'" '+changes_highlight+'>'+odds2+'</a>';
		else
			thisObj.getElementById('ouodds'+thisActiveIndex+'C').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',2,'+bettype+'">'+odds2+'</a>';
	}
}

/* Clear Asian Handicap Change Indicator - Eugene 06/07/2003 */
function clearAsianHandicapChange(matchIndex, odds1, odds2, bettype, favourite){
	thisActiveIndex = matchIndex;
	
	/* Hide odds if zero */
	if(odds1 == 0 || odds2 == 0){
		thisObj.getElementById('hdp'+thisActiveIndex+'H').innerHTML = '&nbsp;';
		thisObj.getElementById('hdp'+thisActiveIndex+'C').innerHTML = '&nbsp;';
		thisObj.getElementById('odds'+thisActiveIndex+'H').innerHTML = '&nbsp;';
		thisObj.getElementById('odds'+thisActiveIndex+'C').innerHTML = '&nbsp;';
	}else{
		/* Favourite odds at top */
		if(favourite=='H'){
			thisObj.getElementById('odds'+thisActiveIndex+'H').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',1,'+bettype+'">'+odds1+'</a>';
			thisObj.getElementById('odds'+thisActiveIndex+'C').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',2,'+bettype+'">'+odds2+'</a>';
		
		/* Favourite odds at bottom */
		}else{
			thisObj.getElementById('odds'+thisActiveIndex+'H').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',1,'+bettype+'">'+odds2+'</a>';
			thisObj.getElementById('odds'+thisActiveIndex+'C').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',2,'+bettype+'">'+odds1+'</a>';		
		}
	}
}

/* Clear Over Under Change Indicator - Eugene 06/07/2003 */
function clearOverUnderChange(matchIndex, odds1, odds2, bettype){
	thisActiveIndex = matchIndex;

	/* Hide odds if zero */
	if(odds1 == 0 || odds2 == 0){
		thisObj.getElementById('ouhdp'+thisActiveIndex+'H').innerHTML = '&nbsp;';
		thisObj.getElementById('ouodds'+thisActiveIndex+'H').innerHTML = '&nbsp;';
		thisObj.getElementById('ouodds'+thisActiveIndex+'C').innerHTML = '&nbsp;';
	/* Clear Change indicator */
	}else{
		thisObj.getElementById('ouodds'+thisActiveIndex+'H').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',1,'+bettype+'">'+odds1+'</a>';
		thisObj.getElementById('ouodds'+thisActiveIndex+'C').innerHTML = '<a href="betting-entry.aspx?ahht=1&m='+thisActiveIndex+',2,'+bettype+'">'+odds2+'</a>';
	}
}


/* Refresh Score */
function refreshScore(scoreCaption){
	if(element = thisObj.getElementById('tr'+thisActiveIndex+'H')){
		thisObj.getElementById('scr'+thisActiveIndex).innerHTML = scoreCaption;
	}
}

/* Refresh team and recoluring team according to sysparameter */
function refreshTeam(teama, teamb, homeaway, fav){
	
	/* Print team with team colouring */
	if(thisTeamColouring=='favourite'){
		if(fav=="a"){
			teamcaption = '<span style="color:red;font: '+font_style+';">'+teama+'&nbsp;('+homeaway+')</span>&nbsp;<br>'+teamb+'';
		}else{
			teamcaption = teama+'&nbsp;('+homeaway+')&nbsp;<br><span style="color:red; font: '+font_style+';">'+teamb+'</span>';
		}
	}else if(thisTeamColouring=='home'){
		teamcaption = '<span style="color:red; font: '+font_style+';">'+teama+'&nbsp;('+homeaway+')</span>&nbsp;<br>'+teamb+'';
	}else{
		teamcaption = ''+teama+'&nbsp;('+homeaway+')&nbsp;<br>'+teamb+'';
	}	
	
	thisObj.getElementById('team'+thisActiveIndex).innerHTML = teamcaption;
}