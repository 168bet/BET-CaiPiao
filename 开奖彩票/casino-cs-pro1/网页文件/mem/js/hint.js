var x0, y0;
var bMove = 0;
var div_offset_x = 10, div_offset_y = 10;
var shadow_offset_x = 8, shadow_offset_y = 8;

											  											   
function ShowHint(pageurl,control,date_start,date_end)
{
	
	var url = pageurl + "?control="+control+"&date_start=" + date_start + "&date_end=" + date_end;
	
		//url = "b.htm";	

	window.open(url, "winHint");
	
	var left = window.event.x + div_offset_x, top = window.event.y + div_offset_y;
	
	if (left < 0)
		left = 0;
	else if (left+divHint.clientWidth+2*(parseInt(divHint.style.borderWidth))+shadow_offset_x >= document.body.clientWidth)
	{
		left = document.body.clientWidth - divHint.clientWidth - 2 * (parseInt(divHint.style.borderWidth)) - shadow_offset_x;
		if (left < 0)
			left = 0;
	}
	
	if (top < 0)
		top = 0;
	else if (top+divHint.clientHeight+2*(parseInt(divHint.style.borderWidth))+shadow_offset_y >= document.body.clientHeight)
	{
		top = document.body.clientHeight - divHint.clientHeight - 2 * (parseInt(divHint.style.borderWidth)) - shadow_offset_y;
		if (top < 0)
			top = 0;
	}
	divHint.style.display = 'block';
	divHint.style.left = left;
	divHint.style.top = top;
	event.cancelBubble = true;
	//divHint.style.visibility = "visible";
	
	
}


function SetHintSize(width, height)
{
	divHint.style.width = width;
	divHint.style.height = height;
	winHint.width = width;
	winHint.height = height;
	//divHint.style.visibility = "visible";//visibility
}

function CloseHint()
{
	//divHint.style.visibility="hidden";
	document.all['divHint'].style.display= 'none';
}

function Hint_OnMouseDown()
{
	x0 = window.event.x;
	y0 = window.event.y;
	//bMove = 1;
}

function Hint_OnDblClick()
{
	parent.CloseHint();
}

function SetBodySize(width, height)
{
	window.resizeTo(width, height);//由于嵌入到IFRAME中，所以这里设置窗口大小时即为BODY大小
	parent.SetHintSize(width, height)
}

var div = "<div id=divHint name=divHint style=\"POSITION:  absolute; TOP:  0px; HEIGHT:  10px;Z-INDEX:  200;display:none;BACKGROUND-COLOR:  transparent\" ms_positioning=\"FlowLayout\">";
div = div + "<iframe id=\"winHint\" name=\"winHint\" scrolling=\"yes\" style=\"BORDER-RIGHT: 0px; BORDER-TOP: 0px; LEFT: 0px; BORDER-LEFT: 0px; WIDTH: 450px; BORDER-BOTTOM: 0px; TOP: 0px; HEIGHT: 300px; BACKGROUND-COLOR: transparent\" align=\"middle\" marginWidth=\"0\" hspace=\"0\" vspace=\"0\" marginHeight=\"0\" frameBorder=\"0\"></iframe>";
div = div + "</DIV>";





