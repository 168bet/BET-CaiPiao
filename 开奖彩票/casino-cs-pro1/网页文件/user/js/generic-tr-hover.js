/*---------------------------------------------------------------------*/
/* Hover effect */
/*---------------------------------------------------------------------*/
var highColor = '#ffffcc';
var lowColor = 'white';		
var trs = document.getElementsByTagName('tr');

onload = function(){
	var row, i = 0;
	while (row = trs.item(i++)){
		 if (row.className == 'hover') {
			row.onmouseover = function() { this.style.background = highColor; }
			row.onmouseout = function() { this.style.background = lowColor;}
		 }else if(row.className == 'hover2'){
			row.onmouseover = function() { this.style.background = highColor; }
			row.onmouseout = function() { this.style.background = "#dcdcdc";}
		 }else if(row.className == 'hover3'){
			row.onmouseover = function() { this.style.background = highColor; }
			row.onmouseout = function() { this.style.background = "#eee8aa";}
		 }
	}
}
/*---------------------------------------------------------------------*/