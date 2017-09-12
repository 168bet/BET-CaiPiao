function nocontextmenu(){
	event.cancelBubble = true
	event.returnValue = false;
	return false;
}
function norightclick(e) {
    if (window.Event) {
        if (e != undefined && (e.which == 2 || e.which == 3))
            return false;
    } else if (event.button == 2 || event.button == 3) {
        event.cancelBubble = true
        event.returnValue = false;
        return false;
    }
}

function forbid_key(){ 
    if(event.keyCode==116){
        event.keyCode=0;
        event.returnValue=false;
    }
    
//    if(event.shiftKey){
//        event.returnValue=false;
//    }
    //½ûÖ¹shift
    
    if(event.altKey){
        event.returnValue=false;
    }
    //½ûÖ¹alt
    
    if(event.ctrlKey){
        event.returnValue=false;
    }
    //½ûÖ¹ctrl
    return true;
}

function printr(str) {
    if (confirm(str)) {
        window.print();
    }
    return false;
}
document.oncontextmenu = nocontextmenu; // for IE5+
document.onmousedown = norightclick; // for all others
//document.onkeydown=forbid_key;