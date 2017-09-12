/*----------------------------------------------------------------------------------------------/
	Script	: function-no-status-msg.js
	Updates	: 26/08/2003 - (Eugene) added better function in cloaking href status
/----------------------------------------------------------------------------------------------*/
function noStatusMsg() {
	if (document.getElementsByTagName) {
		var linkList = document.getElementsByTagName('A');
		for (var i=0; i<linkList.length; i++){
			linkList[i].onmouseover = function () { window.status = ""; return true; }
		}
	} 
	else if (document.links) {
		for (var i=0; i<document.links.length; i++){
			document.links[i].onmouseover = function () { window.status = ""; return true; }
		}
	}
}

function hidestatus(){ 
window.status='' 
return true 
} 
if (document.layers) 
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT) 
document.onmouseover=hidestatus 
document.onmouseout=hidestatus 


/*----------------------------------------------------------------------------------------------*/