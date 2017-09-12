// JavaScript Document
var xmlhttp;

function xhr(url){
	xmlhttp = false;
    if (window.XMLHttpRequest) { // 判定浏览器类型为Mozilla, Safari,...
	    xmlhttp = new XMLHttpRequest();
	    if (xmlhttp.overrideMimeType) {
		    xmlhttp.overrideMimeType('text/xml');
    	}
    } else if (window.ActiveXObject) {
	    try{
	    	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	    } catch (e) {
		    try {
			    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		    } catch (e) {}
	    }
    }

	
	if (!xmlhttp) {//初始化xmlhttp组件
		alert('您的浏览器不支持 ajax！');
		return false;
	}
	xmlhttp.open("GET",url,true);
	xmlhttp.onreadystatechange = getreturn;
	xmlhttp.send(null);
}


