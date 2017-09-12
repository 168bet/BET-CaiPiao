// 判断浏览器
var isIE = (document.all ? true : false);
// 初始月份及各月份天数数组
var months = new Array("一　月", "二　月", "三　月", "四　月", "五　月", "六　月", "七　月", "八　月", "九　月", "十　月", "十一月", "十二月");
var MonthsDay = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
//用于显示在层中的月份和年份，初值取当前日期
var dispLayerMonth = new Date().getMonth();
var dispLayerYear = new Date().getFullYear();
//取得图像、层和文本框的名字
var IMGName;
var LayerName;
var textElement;

function DatePicker(imgName, divName, formAndText,initYear,initMonth) {
//============================================================ 
// 在图像上按下鼠标左键时，调用此函数
// 参数imgName, divName, formAndText。类型number
//============================================================ 
	var x = formAndText.indexOf('.');
	var formName = formAndText.substring(0,x);
	var textName = formAndText.substring(x+1);
	if (isIE && LayerName) {
		document.all[LayerName].style.visibility = 'hidden'; 
	} else if (LayerName){
		document.layers[LayerName].visibility = 'hide';
	}
	if (!isIE) document.layers[divName].visibility = 'hide';
	LayerName = divName;
	IMGName = imgName;
	textElement = document.forms[formName].elements[textName];
	initYear = initYear ? initYear : -1;
	initMonth = initMonth ? initMonth-1 : -1;
	initCal(initYear,initMonth);
	setCalendar();
	showLayer();
}

function initCal(iYear,iMonth){
//============================================================ 
// 按照给定的日期设置dispLayerYear，dispLayerMonth
//============================================================ 
	var setYear = parseInt(iYear);
	var setMonth = parseInt(iMonth);
	if (setYear > 2100 || setYear < 1900){
		dispLayerYear = new Date().getFullYear();
	} else {
		dispLayerYear = setYear;
	}
	if (setMonth > 11 || setMonth < 0){
		dispLayerMonth = new Date().getMonth();
	} else {
		dispLayerMonth = setMonth;
	}
}

function setCalendar() {
//============================================================ 
// 设置年、月。制作显示的表。显示。
//============================================================ 
	var setCal = new Date(dispLayerYear,dispLayerMonth,1);
	var chapel = setCal.getDay();
	var daysInMon = daysInMonth(setCal.getMonth(), setCal.getFullYear());

	var calendarGUI = makeCalendar(chapel,daysInMon,setCal)
	if (isIE) {
		var Layer = document.all[LayerName];
		Layer.innerHTML = calendarGUI;
	} else {
		var Layer = document.layers[LayerName].document;
		Layer.open();
		Layer.write(calendarGUI);
		Layer.close();
	}
}

function makeCalendar(chapel, daysInMon,setCal) {
//============================================================ 
// 制作用于显示的日期表格
//============================================================ 
	var calGUI='';
	var month = setCal.getMonth();
	var year = setCal.getFullYear();
	var isThisMonth = new Date().getMonth();
	var isThisYear = new Date().getFullYear();
	var isThisDay = new Date().getDate();
	
	calGUI = '<table class=styleCalend width="150" cellspacing="1" bgcolor="#CCCCCC"';
	!isIE ? calGUI += ' border=1' : calGUI += '';
	calGUI += '><tr align = middle><td bgcolor="#FFFFFF" colspan="7" nowrap>'
	//============================================================
	calGUI += '<a href="javascript:chgYear(-1)"><<</a>';
	if (year == isThisYear){
		calGUI += '<font color=red><b>' + year + '</b></font>';
	} else {
		calGUI += '<b>' + year + '</b>';
	}
	calGUI += '<a href="javascript:chgYear(1)">>></a>&nbsp;&nbsp;';
	//============================================================
	calGUI += '<a href="javascript:chgMonth(-1)"><<</a>';
	if (month == isThisMonth && year == isThisYear){
		calGUI += '<font color=red><b>';
		isIE ? calGUI += months[month] + '</b></font>' : calGUI += month+1 + '</b></font>';
	} else {
		calGUI += '<b>';
		isIE ? calGUI += months[month] + '</b>' : calGUI += month+1 + '</b>';
	}
	calGUI += '<a href="javascript:chgMonth(1)">>></a>&nbsp;';
	//============================================================
	calGUI += '<a href="javascript:hideLayer()"><font color=red size=1>关闭</font></a>';
	calGUI += '</td></tr>';
	calGUI += '<tr align="right" bgcolor="#CCCCCC" height="19">';
	if (isIE){
		calGUI += '<td class=styleCal><b>日</b></td>';
		calGUI += '<td class=styleCal><b>一</b></td>';
		calGUI += '<td class=styleCal><b>二</b></td>';
		calGUI += '<td class=styleCal><b>三</b></td>';
		calGUI += '<td class=styleCal><b>四</b></td>';
		calGUI += '<td class=styleCal><b>五</b></td>';
		calGUI += '<td class=styleCal><b>六</b></td>';
	} else {
		calGUI += '<td class=styleCal><b>Sun</b></td>';
		calGUI += '<td class=styleCal><b>Mon</b></td>';
		calGUI += '<td class=styleCal><b>Tue</b></td>';
		calGUI += '<td class=styleCal><b>Wed</b></td>';
		calGUI += '<td class=styleCal><b>Thu</b></td>';
		calGUI += '<td class=styleCal><b>Fri</b></td>';
		calGUI += '<td class=styleCal><b>Sat</b></td>';
	}
	calGUI += '</tr>';
	
	calGUI += '<tr align="right" height="19" bgcolor="#FFFFFF">';
	var place;
	var day;
	for (place = 0; place < chapel; place++){
		calGUI += '<td>&nbsp;</td>';			
	}
	for (day = 1; day <= daysInMon; day++){
		if (day == isThisDay && month == isThisMonth && year == isThisYear){
			calGUI += '<td><a href="javascript:setDay(' + day +')" style="color:red">' + day + '</a></td>';
		} else {
			calGUI += '<td><a href="javascript:setDay(' + day +')">' + day + '</a></td>';
		}
		if ((day + chapel)% 7 == 0 && day < daysInMon){
			calGUI += '</tr><tr align="right" height="19" bgcolor="#FFFFFF">';
		} else if ((day + chapel)% 7 == 0){
			calGUI += '</tr>';
		}
	}
	for (place = (day + chapel); place % 7 != 1; place++){
		if (place % 7 == 0){
			calGUI += '<td>&nbsp;</td></tr>';
		} else {
			calGUI += '<td>&nbsp;</td>';
		}
	}
	calGUI += '</table>';
	return calGUI;
}

function daysInMonth(month, year) {
//============================================================
// 根据year month确定该月的天数
//============================================================
	if (month == 1)
		return  ((year % 4 == 0) && ((year % 100) != 0)) ||    (0 == year % 400) ? 29 : 28;
	else
		return  MonthsDay[month];
}

function chgMonth(chg) {
//============================================================ 
// 改变月份时
//============================================================ 
	dispLayerMonth += chg;
	if (dispLayerMonth > 11) {
		dispLayerMonth = 0;
		chgYear(1);
	} else if (dispLayerMonth <= -1) {
		dispLayerMonth = 11;
		chgYear(-1);
	} else {
		setCalendar();
	}
}

function chgYear(chg) {
//============================================================ 
// 改变年份时
//============================================================ 
	dispLayerYear = dispLayerYear + chg;
	setCalendar();
}

function setDay(day) {
//============================================================ 
// 选中日期时，在文本框中显示
//============================================================ 
	var month = dispLayerMonth + 1;
	var txtYear = dispLayerYear + "";
	var txtMonth = month + "";
	var txtDay = day + "";
	
	if (txtYear.length < 4) {
	    var n = 4-txtYear.length;
	    for (var i=0;i<n;i++) 
	      txtYear = "0" + txtYear;
	}
	if (txtMonth.length < 2) {
	    var n = 2-txtMonth.length;
	    for (var i=0;i<n;i++) 
	      txtMonth = "0" + txtMonth;
	}
	if (txtDay.length < 2) {
	    var n = 2-txtDay.length;
	    for (var i=0;i<n;i++) 
	      txtDay = "0" + txtDay;
	}
	
	textElement.value = txtYear + "-" + txtMonth + "-" + txtDay;
	hideLayer();
}

function hideLayer() { 
//============================================================ 
// 改变窗口大小、关闭层或选中日期时隐藏层
//============================================================ 
	if (isIE) {
		document.all[LayerName].style.visibility = 'hidden'; 
	} else {
		document.layers[LayerName].visibility = 'hide';
	}
}

function showLayer() {
//============================================================ 
// 在图像上单击鼠标左键时显示层
//============================================================ 
	var element;
	if (isIE) {
		element = document.all[LayerName].style
		if (element.visibility == 'visible'){
			element.visibility = 'hidden';
		} else {
			setPosition();
			element.visibility = 'visible';
		}
	} else {
		element = document.layers[LayerName]
		if (element.visibility == 'show'){
			element.visibility = 'hide';
		} else {
			setPosition();
			element.visibility = 'show';
		}
	}
}

function setPosition() {
//=========================================================== 
// 设置层的位置
//============================================================ 
	var tmpElement;
	if (isIE) {
		tmpElement = document.all[IMGName];
		var xPos = 0;
		var yPos = 0;
		while (tmpElement != null){
			xPos += tmpElement.offsetLeft;
			yPos += tmpElement.offsetTop;
			tmpElement = tmpElement.offsetParent;
		}
		document.all[LayerName].style.left = xPos;
		document.all[LayerName].style.top = yPos;
	} else {
		tmpElement = document.images[IMGName];
		document.layers[LayerName].left = tmpElement.x;
		document.layers[LayerName].top = tmpElement.y;
	}
}
