//----------------------------------------------//
// Set default_timeout (1000 = 1 sec) //
//----------------------------------------------//
var default_timeout = '10000';
var refreshTimer = 0;

function fetchNewData(timer){
	document.frames['iframe'].location.href = 'betting-matches-ahht-refresh.aspx?'+document.myForm.form_url.value;
	refreshTimer = timer;
	setTimeout('fetchNewData2()',refreshTimer);
}		

function fetchNewData2(){
	document.frames['iframe'].location.href = 'betting-matches-ahht-refresh.aspx?'+document.myForm.form_url.value;
	setTimeout('fetchNewData2()',refreshTimer);
}		

function loadingDone(){
	document.getElementById('downloading').style.display = 'none';
}

function timeOut(){
	var refresh_timer = document.myForm.form_refresh_timer.value;
	
	if(refresh_timer=="0"){
		document.myForm.form_refresh_timer.value=default_timeout;
		setTimeout('timeOut()',default_timeout);
	}else{
		// refresh_minute = parseInt(refresh_timer)/60000;
		// parent.document.getElementById('timeout').style.display = '';
		// parent.document.getElementById('minute').innerHTML = refresh_minute;
		document.myForm.form_refresh_timer.value= parseInt(default_timeout) + parseInt(refresh_timer);
		setTimeout('timeOut()',default_timeout);
	}
}

