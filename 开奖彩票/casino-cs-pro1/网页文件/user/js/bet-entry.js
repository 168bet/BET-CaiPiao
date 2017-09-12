/*-----------------------------------------------------------------------------------
	Author	: Eugene KH Lau
	Usage	: Betting entry Js
	Updates	: 12/09/2003 - Added max payout validations
-----------------------------------------------------------------------------------*/

/* To format number in 1,000 */
function numberFormat(n) {
	var arr=new Array('0'), i=0; 
	var prefix = "";
	if(n<0){ n = n *-1; prefix = "-"; } //negative prefix
  	while (n>0) { arr[i]=''+n%1000; n=Math.floor(n/1000); i++; }
  	arr = arr.reverse();
  	for (var i in arr) if (i>0){ //padding zeros
    	while (arr[i].length<3){ arr[i]='0'+arr[i] };
	}
  	return prefix+arr.join();
  	return n;
}

/* Calculate Estimated Payout - altered to cater for multiple odds */
//function calculateEstPayout(oddstype,oddsvalue){
function calculateEstPayout(oddstype,estloss_flag){
	TimeOut();
	theOdds = parseFloat(document.myForm.fr_odds_cap.value);
	theStake = parseInt(document.myForm.fr_betamount.value);
	theCredit = parseInt(document.myForm.fr_credit.value);
	
	document.getElementById('betAmount').innerHTML = numberFormat(theStake);
	if (theOdds < 0 ){ // cater for malay odds situation
		document.getElementById('estPayout1').innerHTML = numberFormat(Math.round(theStake));
		document.getElementById('estPayout2').innerHTML = numberFormat(Math.round(theStake));
		if(estloss_flag == '1'){
			document.getElementById('estPayoutLoss').innerHTML = numberFormat(Math.round(theOdds * theStake));
			document.getElementById('estPayoutLoss2').innerHTML = numberFormat(Math.round(theOdds * theStake));
		}
		document.myForm.fr_estimate_payout.value = parseInt(theStake);
	}else{
		document.getElementById('estPayout1').innerHTML = numberFormat(Math.round(theOdds * theStake));
		document.getElementById('estPayout2').innerHTML = numberFormat(Math.round(theOdds * theStake));
		if(estloss_flag == '1'){
			document.getElementById('estPayoutLoss').innerHTML = numberFormat(Math.round(theStake));
			document.getElementById('estPayoutLoss2').innerHTML = numberFormat(Math.round(theStake));
		}
		document.myForm.fr_estimate_payout.value = parseInt(theOdds * theStake);
		//alert(fr_estimate_payout);
	}
	document.getElementById('creditAfterBet').innerHTML = numberFormat(theCredit - theStake);

	// change color when reach that value 
	thedigit = parseInt(theStake);
	if(thedigit < 1000){
		document.myForm.fr_betamount.style.color = 'black'; 
	}else if(thedigit >= 1000 && thedigit < 10000){
		document.myForm.fr_betamount.style.color = 'green'; 
	}else if(thedigit >= 10000 && thedigit < 100000){
		document.myForm.fr_betamount.style.color = 'blue'; 
	}else if(thedigit >= 100000){
		document.myForm.fr_betamount.style.color = 'red'; 
	}
}

/* Show Preview Screen */
function showPreviewScreen(){
	TimeOut();
	if(validateInput()){
		document.getElementById('errorScreen').style.display = 'none';
		document.getElementById('entryScreen').style.display = 'none';
		document.getElementById('previewScreen').style.display = '';
		document.myForm2.fr_submit.focus();
	}else{
		document.getElementById('errorScreen').style.display = '';
		document.getElementById('entryScreen').style.display = '';
		document.getElementById('previewScreen').style.display = 'none';
	}
	return false;
}

/* Show Preview Screen */
function showPreviewScreenZD(){
	TimeOut();
	if(validateInput()){
		document.getElementById('errorScreen').style.display = 'none';
		document.getElementById('entryScreen').style.display = 'none';
		document.getElementById('previewScreen').style.display = 'none';
		
		document.getElementById('delayScreen').style.display = '';
		//delaytime();
		
	}else{
		document.getElementById('errorScreen').style.display = '';
		document.getElementById('entryScreen').style.display = '';
		document.getElementById('previewScreen').style.display = 'none';
	}
	return false;
}

/*
var ii=0
function delaytime()
{	
　　ii++;　　
　　if(ii == 2)
　　{
　　　　document.getElementById('delayScreen').style.display = 'none';
　　　　document.getElementById('previewScreen').style.display = '';
　　　　document.myForm2.fr_submit.focus();
　　}
　　if(ii < 2)
　　{
　　	window.setTimeout("delaytime()",6000);
　　}
}
*/

/* Show Entry Screen */
function showEntryScreen(){
	TimeOut();
	document.getElementById('entryScreen').style.display = '';
	document.getElementById('errorScreen').style.display = 'none';
	document.getElementById('previewScreen').style.display = 'none';
}

/* Validate User Input */
function validateInput(){
	keyInBet = parseInt(document.myForm.fr_betamount.value);
	if(keyInBet > parseInt(document.myForm.fr_credit.value)){
		document.getElementById('errorMsg').innerHTML = returnCaption('You do not have sufficient fund for this bet');
		return false;
	}
	if(keyInBet < parseInt(document.myForm.fr_minbet.value) || isNaN(keyInBet)){
		document.getElementById('errorMsg').innerHTML = returnCaption('Minimum bet for this match is ')+numberFormat(document.myForm.fr_minbet.value);
		return false;
	}
	if(keyInBet > parseInt(document.myForm.fr_maxbet.value)){
		if(parseInt(document.myForm.fr_maxbet.value)>=0){
			document.getElementById('errorMsg').innerHTML = returnCaption('The maximum bet for this match is ')+numberFormat(document.myForm.fr_maxbet.value);
			return false;
		}
	}	
	if(parseInt(document.myForm.fr_maximum_payout.value) > 0){
		//if(parseInt(document.myForm.fr_estimate_payout.value) > parseInt(document.myForm.fr_maximum_payout.value)){
		if(parseInt(document.myForm.fr_estimate_payout.value) > parseInt(document.myForm.fr_maximum_payout.value)){
			document.getElementById('errorMsg').innerHTML = returnCaption('The maximum payout for this game is ')+numberFormat(document.myForm.fr_maximum_payout.value);//document.getElementById('max_payout_caption').innerHTML;
			return false;
		}
	}
	return true;
}

function cancelBet(){
	cancelTimeOut();
	self.location.href="betting-entry.aspx";
	//document.writeln('<meta http-equiv="refresh" content="0" url="betting-entry.aspx">');
}

function msgbox(msg) {
	alert(msg);
}

function disableButton(){
	submitObj = document.getElementById('fr_submit');
	submitObj.disabled = true;
	submitObj.onClick = null;
	
	submitObj = document.getElementById('fr_back');
	submitObj.disabled = true;
	submitObj.onClick = null;
	return false;
}

var timerId = 0;
var betType = "";
function TimeOut(){
	if(timerId){ 
		clearTimeout(timerId);
		timerId = 0;
	}
	
	if(betType == "running") {
		timerId = window.setTimeout('cancelBet()',9000);
	}
	else {
		timerId = window.setTimeout('cancelBet()',30000);
	}
}


function cancelTimeOut(){
	if(timerId){ 
		clearTimeout(timerId);
		timerId = 0;
	}
}

function doFormLoad() {
	TimeOut();
	doError();
	document.myForm.fr_betamount.focus();
}

/* Return action caption */
function returnCaption(caption){
	if(thisLanguage=="english"){
		if(caption =='You do not have sufficient fund for this bet'){
			return 'You do not have sufficient fund for this bet';
		}else if(caption =='Minimum bet for this match is '){
			return 'Minimum bet for this match is ';
		}else if(caption =='The maximum bet for this match is '){
			return 'The maximum bet for this match is ';
		}else if(caption =='The maximum payout for this game is '){
			return 'The maximum payout for this game is ';
		}
	}else if(thisLanguage=="simplified"){
		if(caption =='You do not have sufficient fund for this bet'){
			return '你的总注额超过你的信用额度';
		}else if(caption =='Minimum bet for this match is '){
			return '最低注额是 - ';
		}else if(caption =='The maximum payout for this game is '){
			return '最高赔额是 - ';
		}else if(caption == 'The maximum bet for this match is '){
			return '你的总注额超过你的信用额度 ';
		}
	}
}
