var match_cap = "";

function dOM(matchindex, matchdate, h1_0, h2_0, h2_1, h3_0, h3_1, h3_2, h4_0, h4_1, h4_2, h4_3, d0_0, d1_1, d2_2, d3_3, d4_4, d5Up,
				a1_0, a2_0, a2_1, a3_0, a3_1, a3_2, a4_0, a4_1, a4_2, a4_3, a5Up, teama, homeaway, teamb)
{

	document.writeln('<tr>');
	document.writeln('<td rowspan=2>'+matchdate+'</td>');	
	document.writeln('<td rowspan=2 class="team">'+teama+'('+homeaway+')&nbsp<br>'+teamb+'&nbsp</td>');		
				
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,1_0">'+h1_0+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,2_0">'+h2_0+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,2_1">'+h2_1+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,3_0">'+h3_0+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,3_1">'+h3_1+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,3_2">'+h3_2+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,4_0">'+h4_0+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,4_1">'+h4_1+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,4_2">'+h4_2+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,4_3">'+h4_3+'</a></td>');


	document.writeln('<td class="cs" rowspan=2><a href="betting-entry.aspx?cs='+matchindex+',d,0_0">'+d0_0+'</a></td>');
	document.writeln('<td class="cs" rowspan=2><a href="betting-entry.aspx?cs='+matchindex+',d,1_1">'+d1_1+'</a></td>');
	document.writeln('<td class="cs" rowspan=2><a href="betting-entry.aspx?cs='+matchindex+',d,2_2">'+d2_2+'</a></td>');
	document.writeln('<td class="cs" rowspan=2><a href="betting-entry.aspx?cs='+matchindex+',d,3_3">'+d3_3+'</a></td>');
	document.writeln('<td class="cs" rowspan=2><a href="betting-entry.aspx?cs='+matchindex+',d,4_4">'+d4_4+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',h,up5">'+d5Up+'</a></td>');

	document.writeln('<tr>');

	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,1_0">'+a1_0+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,2_0">'+a2_0+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,2_1">'+a2_1+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,3_0">'+a3_0+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,3_1">'+a3_1+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,3_2">'+a3_2+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,4_0">'+a4_0+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,4_1">'+a4_1+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,4_2">'+a4_2+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,4_3">'+a4_3+'</a></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?cs='+matchindex+',a,up5">'+a5Up+'</a></td>');	

	document.writeln('<tr class="spacer"><td colspan=21></td></tr>');	

}

function dOMP(matchindex, matchdate, h1_0, h2_0, h2_1, h3_0, h3_1, h3_2, h4_0, h4_1, h4_2, h4_3, d0_0, d1_1, d2_2, d3_3, d4_4, d5Up,
				a1_0, a2_0, a2_1, a3_0, a3_1, a3_2, a4_0, a4_1, a4_2, a4_3, a5Up, teama, homeaway, teamb)
{

	document.writeln('<tr>');
	document.writeln('<td rowspan=2>'+matchdate+'</td>');	
	document.writeln('<td rowspan=2 class="team">'+teama+'('+homeaway+')&nbsp<br>'+teamb+'&nbsp</td>');		
				
	document.writeln('<td class="csp" id="hh1_0_'+matchindex+'"><input type="radio" value="h1_0" name="fr_'+matchindex+'" onClick="highLight(\'hh1_0\','+matchindex+',this)"><br>'+h1_0+'</td>');
	document.writeln('<td class="csp" id="hh2_0_'+matchindex+'"><input type="radio" value="h2_0" name="fr_'+matchindex+'" onClick="highLight(\'hh2_0\','+matchindex+',this)"><br>'+h2_0+'</td>');
	document.writeln('<td class="csp" id="hh2_1_'+matchindex+'"><input type="radio" value="h2_1" name="fr_'+matchindex+'" onClick="highLight(\'hh2_1\','+matchindex+',this)"><br>'+h2_1+'</td>');
	document.writeln('<td class="csp" id="hh3_0_'+matchindex+'"><input type="radio" value="h3_0" name="fr_'+matchindex+'" onClick="highLight(\'hh3_0\','+matchindex+',this)"><br>'+h3_0+'</td>');
	document.writeln('<td class="csp" id="hh3_1_'+matchindex+'"><input type="radio" value="h3_1" name="fr_'+matchindex+'" onClick="highLight(\'hh3_1\','+matchindex+',this)"><br>'+h3_1+'</td>');
	document.writeln('<td class="csp" id="hh3_2_'+matchindex+'"><input type="radio" value="h3_2" name="fr_'+matchindex+'" onClick="highLight(\'hh3_2\','+matchindex+',this)"><br>'+h3_2+'</td>');
	document.writeln('<td class="csp" id="hh4_0_'+matchindex+'"><input type="radio" value="h4_0" name="fr_'+matchindex+'" onClick="highLight(\'hh4_0\','+matchindex+',this)"><br>'+h4_0+'</td>');
	document.writeln('<td class="csp" id="hh4_1_'+matchindex+'"><input type="radio" value="h4_1" name="fr_'+matchindex+'" onClick="highLight(\'hh4_1\','+matchindex+',this)"><br>'+h4_1+'</td>');
	document.writeln('<td class="csp" id="hh4_2_'+matchindex+'"><input type="radio" value="h4_2" name="fr_'+matchindex+'" onClick="highLight(\'hh4_2\','+matchindex+',this)"><br>'+h4_2+'</td>');
	document.writeln('<td class="csp" id="hh4_3_'+matchindex+'"><input type="radio" value="h4_3" name="fr_'+matchindex+'" onClick="highLight(\'hh4_3\','+matchindex+',this)"><br>'+h4_3+'</td>');


	document.writeln('<td class="csp" rowspan=2 id="dd0_0_'+matchindex+'"><input type="radio" value="d0_0" name="fr_'+matchindex+'" onClick="highLight(\'dd0_0\','+matchindex+',this)"><br>'+d0_0+'</td>');
	document.writeln('<td class="csp" rowspan=2 id="dd1_1_'+matchindex+'"><input type="radio" value="d1_1" name="fr_'+matchindex+'" onClick="highLight(\'dd1_1\','+matchindex+',this)"><br>'+d1_1+'</td>');
	document.writeln('<td class="csp" rowspan=2 id="dd2_2_'+matchindex+'"><input type="radio" value="d2_2" name="fr_'+matchindex+'" onClick="highLight(\'dd2_2\','+matchindex+',this)"><br>'+d2_2+'</td>');
	document.writeln('<td class="csp" rowspan=2 id="dd3_3_'+matchindex+'"><input type="radio" value="d3_3" name="fr_'+matchindex+'" onClick="highLight(\'dd3_3\','+matchindex+',this)"><br>'+d3_3+'</td>');
	document.writeln('<td class="csp" rowspan=2 id="dd4_4_'+matchindex+'"><input type="radio" value="d4_4" name="fr_'+matchindex+'" onClick="highLight(\'dd4_4\','+matchindex+',this)"><br>'+d4_4+'</td>');
	document.writeln('<td class="csp" id="hh5_5_'+matchindex+'"><input type="radio" value="h5_5" name="fr_'+matchindex+'" onClick="highLight(\'hh5_5\','+matchindex+',this)"><br>'+d5Up+'</td>');

	document.writeln('<tr>');

	document.writeln('<td class="csp" id="cc1_0_'+matchindex+'"><input type="radio" value="c1_0" name="fr_'+matchindex+'" onClick="highLight(\'cc1_0\','+matchindex+',this)"><br>'+a1_0+'</td>');
	document.writeln('<td class="csp" id="cc2_0_'+matchindex+'"><input type="radio" value="c2_0" name="fr_'+matchindex+'" onClick="highLight(\'cc2_0\','+matchindex+',this)"><br>'+a2_0+'</td>');
	document.writeln('<td class="csp" id="cc2_1_'+matchindex+'"><input type="radio" value="c2_1" name="fr_'+matchindex+'" onClick="highLight(\'cc2_1\','+matchindex+',this)"><br>'+a2_1+'</td>');
	document.writeln('<td class="csp" id="cc3_0_'+matchindex+'"><input type="radio" value="c3_0" name="fr_'+matchindex+'" onClick="highLight(\'cc3_0\','+matchindex+',this)"><br>'+a3_0+'</td>');
	document.writeln('<td class="csp" id="cc3_1_'+matchindex+'"><input type="radio" value="c3_1" name="fr_'+matchindex+'" onClick="highLight(\'cc3_1\','+matchindex+',this)"><br>'+a3_1+'</td>');
	document.writeln('<td class="csp" id="cc3_2_'+matchindex+'"><input type="radio" value="c3_2" name="fr_'+matchindex+'" onClick="highLight(\'cc3_2\','+matchindex+',this)"><br>'+a3_2+'</td>');
	document.writeln('<td class="csp" id="cc4_0_'+matchindex+'"><input type="radio" value="c4_0" name="fr_'+matchindex+'" onClick="highLight(\'cc4_0\','+matchindex+',this)"><br>'+a4_0+'</td>');
	document.writeln('<td class="csp" id="cc4_1_'+matchindex+'"><input type="radio" value="c4_1" name="fr_'+matchindex+'" onClick="highLight(\'cc4_1\','+matchindex+',this)"><br>'+a4_1+'</td>');
	document.writeln('<td class="csp" id="cc4_2_'+matchindex+'"><input type="radio" value="c4_2" name="fr_'+matchindex+'" onClick="highLight(\'cc4_2\','+matchindex+',this)"><br>'+a4_2+'</td>');
	document.writeln('<td class="csp" id="cc4_3_'+matchindex+'"><input type="radio" value="c4_3" name="fr_'+matchindex+'" onClick="highLight(\'cc4_3\','+matchindex+',this)"><br>'+a4_3+'</td>');
	document.writeln('<td class="csp" id="cc5_5_'+matchindex+'"><input type="radio" value="c5_5" name="fr_'+matchindex+'" onClick="highLight(\'cc5_5\','+matchindex+',this)"><br>'+a5Up+'</td>');	

	document.writeln('<tr class="spacer"><td colspan=21></td></tr>');	

}

function dOMS(matchdate, teama, homeaway, teamb, matchindex, homewinodds, awaywinodds, odd, even, tg01odds, tg23odds, 
				tg456odds, tg7odds, DRAW2, drawodds)
{
	document.writeln('<tr>');
	document.writeln('<td rowspan=2>'+matchdate+'</td>');
	document.writeln('<td rowspan=1 class="team" nowrap>'+teama+ '('+homeaway+')&nbsp;<br>'+teamb);
	document.writeln('</td><td rowspan=1>');
	document.writeln('<table cellpadding=0 cellspacing=0 class="wager">');
	document.writeln('<tr><td style="text-align:center"><a href="betting-entry.aspx?1x2='+matchindex+',1">'+homewinodds+'</a><br></td></tr>');
	document.writeln('<tr><td style="text-align:center"><a href="betting-entry.aspx?1x2='+matchindex+',2">'+awaywinodds+'</a><br></td></tr>');
	document.writeln('</table>');
	document.writeln('</td>');
	document.writeln('<td rowspan=2 class="cs"><a href="betting-entry.aspx?oe=1&m='+matchindex+',1,OE">'+odd+'</a></td>');
	document.writeln('<td rowspan=2 class="cs"><a href="betting-entry.aspx?oe=1&m='+matchindex+',2,OE">'+even+'</a></td>');
	document.writeln('<td rowspan=2 class="cs"><a href="betting-entry.aspx?tg='+matchindex+',01">'+tg01odds+'</a></td>');
	document.writeln('<td rowspan=2 class="cs"><a href="betting-entry.aspx?tg='+matchindex+',23">'+tg23odds+'</a></td>');
	document.writeln('<td rowspan=2 class="cs"><a href="betting-entry.aspx?tg='+matchindex+',456">'+tg456odds+'</a></td>');
	document.writeln('<td rowspan=2 class="cs"><a href="betting-entry.aspx?tg='+matchindex+',7">'+tg7odds+'</a></td>');
	document.writeln('</tr><tr>');
	document.writeln('<td class="team"><span style="color:maroon">'+DRAW2+'</span></td>');
	document.writeln('<td class="cs"><a href="betting-entry.aspx?1x2='+matchindex+',x">'+drawodds+'</a></td>');
	document.writeln('</tr>');
	document.writeln('<tr class="spacer"><td colspan=21></td></tr>');
}


function dParlay(matchdatetimecaption, teama, matchindex, homewinodds, drawodds, awaywinodds, teamb)
{
	document.writeln('<tr>');
	document.writeln('<td>'+matchdatetimecaption+'</td>');
	document.writeln('<td>'+teama+'</td>');
	document.writeln('<td id="1_'+matchindex+'" class="1x">'+homewinodds+'<input type="radio" value="1" name="fr_'+matchindex+'" onClick="highLight(1,'+matchindex+',this)"></td>');
	document.writeln('<td id="x_'+matchindex+'" class="xx">'+drawodds+'<input type="radio" value="x" name="fr_'+matchindex+'" onClick="highLight(\'x\','+matchindex+',this)"></td>');
	document.writeln('<td id="2_'+matchindex+'" class="1x">'+awaywinodds+'<input type="radio" value="2" name="fr_'+matchindex+'" onClick="highLight(2,'+matchindex+',this)"></td>');
	document.writeln('<td>'+teamb+'</td>');
	document.writeln('</tr>');
}


function dAhParlay(matchdatetimecaption, teamacaption, matchindex, teamaodds, teamaindex, handicap, teambodds, teambindex, teambcaption, teamahomeawaycap, teambhomeawaycap){
	document.writeln('<tr>');
	document.writeln('<td>'+matchdatetimecaption+'</td>');
	document.writeln('<td>'+teamacaption+teamahomeawaycap+'</td>');
	document.writeln('<td id="teama_'+matchindex+'" class="ta">'+teamaodds+'<input type="radio" value="'+teamaindex+'" name="fr_'+matchindex+'" onClick="highLight(\'teama\','+matchindex+',this)"></td>');
	document.writeln('<td class="hdp">'+handicap+'</td>');
	document.writeln('<td id="teamb_'+matchindex+'" class="ta">'+teambodds+' <input type="radio" value="'+teambindex+'" name="fr_'+matchindex+'" onClick="highLight(\'teamb\','+matchindex+',this)"></td>');
	document.writeln('<td>'+teambcaption+teambhomeawaycap+'</td>');
	document.writeln('</tr>');
				 
}

function dHhParlay(balltime,matchindex,team1,team2,xenial,giveup,giveup1,giveup2,bigsmall,bigpl,smallpl,signpl,twinpl,homeway)
{
	document.writeln('<tr>');
	document.writeln('<td align=center>'+balltime+'</td>');
	if(xenial == "H")
		document.writeln('<td class=tb1>'+team1+homeway+'<br>'+team2+'</td>');
	else
		document.writeln('<td class=tb1>'+team2+'<br>'+team1+homeway+'</td>');
	document.writeln('<td width=55 align=center class="hdp">'+giveup+'</td>');
	document.writeln('<td width=84 align=center>');
	if(giveup1 == "" && giveup2 == "")
	{
		if(xenial == "H")
			document.writeln('<table border="0" cellpadding="0" cellspacing="0"><tr><td id="ah1'+matchindex+'" class="ta">&nbsp;</td></tr></table></td>');
		else
			document.writeln('<table border="0" cellpadding="0" cellspacing="0"><tr><td id="ah1'+matchindex+'" class="ta">&nbsp;</td></tr></table></td>');
	}
	else
	{
		if(xenial == "H")
			document.writeln('<table border="0" cellpadding="0" cellspacing="0"><tr><td id="ah1'+matchindex+'" class="ta">'+giveup1+'<input type="radio" name="fr_'+matchindex+'" value="AH_H" onClick="highLight(\'ah1\','+matchindex+',this)"></td></tr><tr><td id="ah2'+matchindex+'" class="ta">'+giveup2+'<input type="radio" name="fr_'+matchindex+'" value="AH_C" onClick="highLight(\'ah2\','+matchindex+',this)"></td></tr></table></td>');
		else
			document.writeln('<table border="0" cellpadding="0" cellspacing="0"><tr><td id="ah1'+matchindex+'" class="ta">'+giveup1+'<input type="radio" name="fr_'+matchindex+'" value="AH_C" onClick="highLight(\'ah1\','+matchindex+',this)"></td></tr><tr><td id="ah2'+matchindex+'" class="ta">'+giveup2+'<input type="radio" name="fr_'+matchindex+'" value="AH_H" onClick="highLight(\'ah2\','+matchindex+',this)"></td></tr></table></td>');
	}
	document.writeln('<td width="58" align="center" class="hdp" style="line-height:20px;">')
	
	if(bigpl != "" && smallpl != "" && parseFloat(bigpl) > 0 && parseFloat(smallpl) > 0)
		document.writeln('大 '+bigsmall+'<br>小 '+bigsmall);
	
	document.writeln('</td><td width="91" align="center" class="ta">');
	
	if(bigpl != "" && smallpl != "" && parseFloat(bigpl) > 0 && parseFloat(smallpl) > 0)
		document.writeln('<table border="0" cellpadding="0" cellspacing="0"><tr><td id="dx1'+matchindex+'" class="ta">'+bigpl+'<input type="radio" name="fr_'+matchindex+'" value="DX_D" onClick="highLight(\'dx1\','+matchindex+',this)"></td></tr><tr><td class=ta id="dx2'+matchindex+'">'+smallpl+'<input type="radio" name="fr_'+matchindex+'" value="DX_X" onClick="highLight(\'dx2\','+matchindex+',this)"></td></tr></table>');
	
	document.writeln('</td><td width="57" align="center" class="hdp" style="line-height:20px;">');
	if(signpl != "" && twinpl != "" && parseFloat(signpl)>0 && parseFloat(twinpl)>0)
		document.writeln('单<br>双');
	document.writeln('</td>');
	document.writeln('<td width="88" align="center">');
	if(signpl != "" && twinpl != "" && parseFloat(signpl)>0 && parseFloat(twinpl)>0)
		document.writeln('<table border="0" cellpadding="0" cellspacing="0"><tr><td id="ds1'+matchindex+'" class="ta">'+signpl+'<input type="radio" name="fr_'+matchindex+'" value="DS_S" onClick="highLight(\'ds1\','+matchindex+',this)"></td></tr><tr><td class=ta id="ds2'+matchindex+'">'+twinpl+'<input type="radio" name="fr_'+matchindex+'" value="DS_X" onClick="highLight(\'ds2\','+matchindex+',this)"></td></tr></table>');
	document.writeln('</td></tr>');
				 
}

function HtParlay(balltime,matchindex,team1,team2,xenial,giveup,giveup1,giveup2,bigsmall,bigpl,smallpl,homeway)
{
	document.writeln('<tr>');
	document.writeln('<td align=center>'+balltime+'</td>');
	if(xenial == "H")
		document.writeln('<td class=tb1>'+team1+homeway+'<br>'+team2+'</td>');
	else
		document.writeln('<td class=tb1>'+team2+'<br>'+team1+homeway+'</td>');
	document.writeln('<td width=55 align=center class="hdp">'+giveup+'</td>');
	document.writeln('<td width=84 align=center>');
		if(xenial == "H")
		document.writeln('<table border="0" cellpadding="0" cellspacing="0"><tr><td id="ah1'+matchindex+'" class="ta">'+giveup1+'<input type="radio" name="fr_'+matchindex+'" value="AH_H" onClick="highLight(\'ah1\','+matchindex+',this)"></td></tr><tr><td id="ah2'+matchindex+'" class="ta">'+giveup2+'<input type="radio" name="fr_'+matchindex+'" value="AH_C" onClick="highLight(\'ah2\','+matchindex+',this)"></td></tr></table></td>');
	else
		document.writeln('<table border="0" cellpadding="0" cellspacing="0"><tr><td id="ah1'+matchindex+'" class="ta">'+giveup1+'<input type="radio" name="fr_'+matchindex+'" value="AH_C" onClick="highLight(\'ah1\','+matchindex+',this)"></td></tr><tr><td id="ah2'+matchindex+'" class="ta">'+giveup2+'<input type="radio" name="fr_'+matchindex+'" value="AH_H" onClick="highLight(\'ah2\','+matchindex+',this)"></td></tr></table></td>');
	document.writeln('<td width="58" align="center" class="hdp" style="line-height:20px;">');
	if(bigpl != "" && smallpl != "" && parseFloat(bigpl) > 0 && parseFloat(smallpl) > 0)
		document.writeln('大 '+bigsmall+'<br>小 '+bigsmall);
	document.writeln('</td><td width="91" align="center" class="ta">');
	if(bigpl != "" && smallpl != "" && parseFloat(bigpl) > 0 && parseFloat(smallpl) > 0)
		document.writeln('<table border="0" cellpadding="0" cellspacing="0"><tr><td id="dx1'+matchindex+'" class="ta">'+bigpl+'<input type="radio" name="fr_'+matchindex+'" value="DX_D" onClick="highLight(\'dx1\','+matchindex+',this)"></td></tr><tr><td class=ta id="dx2'+matchindex+'">'+smallpl+'<input type="radio" name="fr_'+matchindex+'" value="DX_X" onClick="highLight(\'dx2\','+matchindex+',this)"></td></tr></table>');
	document.writeln('</td></tr>');
				 
}


function dBK(matchdatetimecaption, teamacaption, matchindex, teamaodds, teamaindex, handicap, teambodds, teambindex, teambcaption)
{
	document.writeln('<tr>');
	document.writeln('<td>'+matchdatetimecaption+'</td>');
	document.writeln('<td>'+teamacaption+'</td>');
	document.writeln('<td id="teama_'+matchindex+'" class="ta">'+teamaodds+' <input type="radio" value="'+teamaindex+'" name="fr_'+matchindex+'" onClick="highLight(\'teama\','+matchindex+',this)"></td>');
	document.writeln('<td class="hdp">'+handicap+'</td>');
	document.writeln('<td id="teamb_'+matchindex+'" class="ta">'+teambodds+' <input type="radio" value="'+teambindex+'" name="fr_'+matchindex+'" onClick="highLight(\'teamb\','+matchindex+',this)"></td>');						
	document.writeln('<td>'+teambcaption+'</td>');
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
