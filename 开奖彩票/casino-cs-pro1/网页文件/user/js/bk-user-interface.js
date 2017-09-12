

var match_cap = "";

function dBK(balltime, matchname, ballid, team1, team2, xenial, giveup, giveup1, giveup2, homeway)
{
	document.writeln('<tr>');
	document.writeln('<td>'+balltime+'</td>');
	if(xenial == 'H')
	{
		document.writeln('<td>'+ team1 + homeway +'</td>');
		document.writeln('<td id="teama_'+ ballid +'" class="ta">'+ giveup1 +' <input type="radio" value="a" name="fr_'+ ballid +'" onClick="highLight(\'teama\','+ballid+',this)"></td>');
		document.writeln('<td class="hdp">'+ giveup +'</td>');
		document.writeln('<td id="teamb_'+ ballid +'" class="ta">'+ giveup2 +' <input type="radio" value="b" name="fr_'+ ballid +'" onClick="highLight(\'teamb\','+ballid+',this)"></td>');
		document.writeln('<td>'+ team2 +'</td>');
	}
	else
	{
		document.writeln('<td>'+ team2 +'</td>');
		document.writeln('<td id="teama_'+ ballid +'" class="ta">'+ giveup2 +' <input type="radio" value="a" name="fr_'+ ballid +'" onClick="highLight(\'teama\','+ballid+',this)"></td>');
		document.writeln('<td class="hdp">'+ giveup +'</td>');
		document.writeln('<td id="teamb_'+ ballid +'" class="ta">'+ giveup1 +' <input type="radio" value="b" name="fr_'+ ballid +'" onClick="highLight(\'teamb\','+ballid+',this)"></td>');
		document.writeln('<td>'+ team1 + homeway +'</td>');
	}						
	document.writeln('</tr>');
}

function dHT(matchdate, teama, homeaway, teamb, matchindex, hhodds, hdodds, haodds, dhodds, ddodds, daodds, ahodds, adodds, aaodds)
{
	document.writeln('<tr>');
	document.writeln('<td rowspan=1>'+matchdate+'</td>');
	document.writeln('<td rowspan=1 class="team" nowrap>'+teama+ '('+homeaway+')&nbsp;<br>'+teamb+'</td>');
	document.writeln('<td rowspan=1 class="cs"><a href="betting-entry.aspx?ht='+matchindex+',hh">'+hhodds+'</a></td>');
	document.writeln('<td rowspan=1 class="cs"><a href="betting-entry.aspx?ht='+matchindex+',hd">'+hdodds+'</a></td>');
	document.writeln('<td rowspan=1 class="cs"><a href="betting-entry.aspx?ht='+matchindex+',ha">'+haodds+'</a></td>');
	document.writeln('<td rowspan=1 class="cs"><a href="betting-entry.aspx?ht='+matchindex+',dh">'+dhodds+'</a></td>');
	document.writeln('<td rowspan=1 class="cs"><a href="betting-entry.aspx?ht='+matchindex+',dd">'+ddodds+'</a></td>');
	document.writeln('<td rowspan=1 class="cs"><a href="betting-entry.aspx?ht='+matchindex+',da">'+daodds+'</a></td>');
	document.writeln('<td rowspan=1 class="cs"><a href="betting-entry.aspx?ht='+matchindex+',ah">'+ahodds+'</a></td>');
	document.writeln('<td rowspan=1 class="cs"><a href="betting-entry.aspx?ht='+matchindex+',ad">'+adodds+'</a></td>');
	document.writeln('<td rowspan=1 class="cs"><a href="betting-entry.aspx?ht='+matchindex+',aa">'+aaodds+'</a></td>');
	document.writeln('</tr>');
	document.writeln('<tr class="spacer"><td colspan=21></td></tr>');
}

