/*--------------------------------------------------------------------------------------------/
	Script	: bk-betting-matches-function.js
	Usage	: user betting matches functions
	Author	: Eugene KH Lau
	Updates	: 04/07/2003 - Support changed color for newly changed odds
			  06/07/2003 - Added new function to clear new changed odds indicator
			  21/11/2003 - (SM) BASKETBALL !!
			  04/12/2003 - refreshOddsEvenWager();
			  			 - clearOddEvenChange();
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
	if(favourite=='a'){
		thisObj.getElementById('hdp'+thisActiveIndex+'b').innerHTML = '';
		if(odds1 == 0 || odds2 == 0){
			thisObj.getElementById('hdp'+thisActiveIndex+'a').innerHTML = '&nbsp;';
			thisObj.getElementById('odds'+thisActiveIndex+'a').innerHTML = '&nbsp;';
			thisObj.getElementById('odds'+thisActiveIndex+'b').innerHTML = '&nbsp;';
		}else{
			thisObj.getElementById('hdp'+thisActiveIndex+'a').innerHTML = handicapCaption;
			thisObj.getElementById('odds'+thisActiveIndex+'a').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',1,'+bettype+'&bk" '+changes_highlight+'>'+odds1+'</a>';
			thisObj.getElementById('odds'+thisActiveIndex+'b').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',2,'+bettype+'&bk" '+changes_highlight+'>'+odds2+'</a>';
		}
	
	/* Print favourite at top */
	}else{
		thisObj.getElementById('hdp'+thisActiveIndex+'a').innerHTML = '';
		if(odds1 == 0 || odds2 == 0){
			thisObj.getElementById('hdp'+thisActiveIndex+'b').innerHTML = '&nbsp;';
			thisObj.getElementById('odds'+thisActiveIndex+'a').innerHTML = '&nbsp;';
			thisObj.getElementById('odds'+thisActiveIndex+'b').innerHTML = '&nbsp;';
		}else{
			thisObj.getElementById('hdp'+thisActiveIndex+'b').innerHTML = handicapCaption;
			thisObj.getElementById('odds'+thisActiveIndex+'a').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',1,'+bettype+'&bk" '+changes_highlight+'>'+odds2+'</a>';
			thisObj.getElementById('odds'+thisActiveIndex+'b').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',2,'+bettype+'&bk" '+changes_highlight+'>'+odds1+'</a>';
		}
	}
}

/* Refresh OddEven Wager */
function refreshOddEvenWager(odds1, odds2, bettype, changes){

	/* Set changes highlight - 04/07/2003 Eugene */
	if(changes=='1'){
		changes_highlight = setting_changes_highlight;
	}else{
		changes_highlight = '';
	}
	
	/* Print overunder odds */
	if(odds1 == 1 || odds2 == 1){
		thisObj.getElementById('oeodds'+thisActiveIndex+'a').innerHTML = '&nbsp;';
		thisObj.getElementById('oeodds'+thisActiveIndex+'b').innerHTML = '&nbsp;';
	}else{
		thisObj.getElementById('oeodds'+thisActiveIndex+'a').innerHTML = '<a href="betting-entry.aspx?bkoe=1&m='+thisActiveIndex+',1,'+bettype+'&BKOE" '+changes_highlight+'>'+odds1+'</a>';
		thisObj.getElementById('oeodds'+thisActiveIndex+'b').innerHTML = '<a href="betting-entry.aspx?bkoe=1&m='+thisActiveIndex+',2,'+bettype+'&BKOE" '+changes_highlight+'>'+odds2+'</a>';
	}
}


/* Refresh Over Under Wager - 04/12/2003 Say Mun */
function refreshOverUnderWager(handicapCaption, odds1, odds2, bettype, changes){

	/* Set changes highlight - 04/07/2003 Eugene */
	if(changes=='1'){
		changes_highlight = setting_changes_highlight;
	}else{
		changes_highlight = '';
	}
	
	/* Print overunder odds */
	if(odds1 == 0 || odds2 == 0){
		thisObj.getElementById('ouhdp'+thisActiveIndex+'a').innerHTML = '&nbsp;';
		thisObj.getElementById('ouodds'+thisActiveIndex+'a').innerHTML = '&nbsp;';
		thisObj.getElementById('ouodds'+thisActiveIndex+'b').innerHTML = '&nbsp;';
	}else{
		thisObj.getElementById('ouhdp'+thisActiveIndex+'a').innerHTML = handicapCaption;
		thisObj.getElementById('ouodds'+thisActiveIndex+'a').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',1,'+bettype+'&bk" '+changes_highlight+'>'+odds1+'</a>';
		thisObj.getElementById('ouodds'+thisActiveIndex+'b').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',2,'+bettype+'&bk" '+changes_highlight+'>'+odds2+'</a>';
	}
}

/* Clear Asian Handicap Change Indicator - Eugene 06/07/2003 */
function clearAsianHandicapChange(matchIndex, odds1, odds2, bettype, favourite){
	thisActiveIndex = matchIndex;
	
	/* Hide odds if zero */
	if(odds1 == 0 || odds2 == 0){
		thisObj.getElementById('hdp'+thisActiveIndex+'a').innerHTML = '&nbsp;';
		thisObj.getElementById('hdp'+thisActiveIndex+'b').innerHTML = '&nbsp;';
		thisObj.getElementById('odds'+thisActiveIndex+'a').innerHTML = '&nbsp;';
		thisObj.getElementById('odds'+thisActiveIndex+'b').innerHTML = '&nbsp;';
	}else{
		/* Favourite odds at top */
		if(favourite=='a'){
			thisObj.getElementById('odds'+thisActiveIndex+'a').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',1,'+bettype+'&bk">'+odds1+'</a>';
			thisObj.getElementById('odds'+thisActiveIndex+'b').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',2,'+bettype+'&bk">'+odds2+'</a>';
		
		/* Favourite odds at bottom */
		}else{
			thisObj.getElementById('odds'+thisActiveIndex+'a').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',1,'+bettype+'&bk">'+odds2+'</a>';
			thisObj.getElementById('odds'+thisActiveIndex+'b').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',2,'+bettype+'&bk">'+odds1+'</a>';		
		}
	}
}

/* Clear Over Under Change Indicator - Say Mun 04/12/2003 */
function clearOddEvenChange(matchIndex, odds1, odds2, bettype){
	thisActiveIndex = matchIndex;

	/* Hide odds if zero */
	if(odds1 == 0 || odds2 == 0){
		thisObj.getElementById('oeodds'+thisActiveIndex+'a').innerHTML = '&nbsp;';
		thisObj.getElementById('oeodds'+thisActiveIndex+'b').innerHTML = '&nbsp;';
	/* Clear Change indicator */
	}else{
		thisObj.getElementById('oeodds'+thisActiveIndex+'a').innerHTML = '<a href="betting-entry.aspx?bkoe=1&m='+thisActiveIndex+',1,'+bettype+'">'+odds1+'</a>';
		thisObj.getElementById('oeodds'+thisActiveIndex+'b').innerHTML = '<a href="betting-entry.aspx?bkoe=1&m='+thisActiveIndex+',2,'+bettype+'">'+odds2+'</a>';
	}
}

/* Clear Over Under Change Indicator - Eugene 06/07/2003 */
function clearOverUnderChange(matchIndex, odds1, odds2, bettype){
	thisActiveIndex = matchIndex;

	/* Hide odds if zero */
	if(odds1 == 0 || odds2 == 0){
		thisObj.getElementById('ouhdp'+thisActiveIndex+'a').innerHTML = '&nbsp;';
		thisObj.getElementById('ouodds'+thisActiveIndex+'a').innerHTML = '&nbsp;';
		thisObj.getElementById('ouodds'+thisActiveIndex+'b').innerHTML = '&nbsp;';
	/* Clear Change indicator */
	}else{
		thisObj.getElementById('ouodds'+thisActiveIndex+'a').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',1,'+bettype+'&bk">'+odds1+'</a>';
		thisObj.getElementById('ouodds'+thisActiveIndex+'b').innerHTML = '<a href="betting-entry.aspx?m='+thisActiveIndex+',2,'+bettype+'&bk">'+odds2+'</a>';
	}
}


/* Refresh Score */
function refreshScore(scoreCaption){
	if(element = thisObj.getElementById('tr'+thisActiveIndex+'a')){
		thisObj.getElementById('scr'+thisActiveIndex).innerHTML = scoreCaption;
	}
}