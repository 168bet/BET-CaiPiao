// �ж������
var isIE = (document.all ? true : false);
// ��ʼ�·ݼ����·���������
var months = new Array("һ����", "������", "������", "�ġ���", "�塡��", "������", "�ߡ���", "�ˡ���", "�š���", "ʮ����", "ʮһ��", "ʮ����");
var MonthsDay = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
//������ʾ�ڲ��е��·ݺ���ݣ���ֵȡ��ǰ����
var dispLayerMonth = new Date().getMonth();
var dispLayerYear = new Date().getFullYear();
//ȡ��ͼ�񡢲���ı��������
var IMGName;
var LayerName;
var textElement;

function DatePicker(imgName, divName, formAndText,initYear,initMonth) {
//============================================================ 
// ��ͼ���ϰ���������ʱ�����ô˺���
// ����imgName, divName, formAndText������number
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
// ���ո�������������dispLayerYear��dispLayerMonth
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
// �����ꡢ�¡�������ʾ�ı���ʾ��
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
// ����������ʾ�����ڱ��
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
	calGUI += '<a href="javascript:hideLayer()"><font color=red size=1>�ر�</font></a>';
	calGUI += '</td></tr>';
	calGUI += '<tr align="right" bgcolor="#CCCCCC" height="19">';
	if (isIE){
		calGUI += '<td class=styleCal><b>��</b></td>';
		calGUI += '<td class=styleCal><b>һ</b></td>';
		calGUI += '<td class=styleCal><b>��</b></td>';
		calGUI += '<td class=styleCal><b>��</b></td>';
		calGUI += '<td class=styleCal><b>��</b></td>';
		calGUI += '<td class=styleCal><b>��</b></td>';
		calGUI += '<td class=styleCal><b>��</b></td>';
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
// ����year monthȷ�����µ�����
//============================================================
	if (month == 1)
		return  ((year % 4 == 0) && ((year % 100) != 0)) ||    (0 == year % 400) ? 29 : 28;
	else
		return  MonthsDay[month];
}

function chgMonth(chg) {
//============================================================ 
// �ı��·�ʱ
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
// �ı����ʱ
//============================================================ 
	dispLayerYear = dispLayerYear + chg;
	setCalendar();
}

function setDay(day) {
//============================================================ 
// ѡ������ʱ�����ı�������ʾ
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
// �ı䴰�ڴ�С���رղ��ѡ������ʱ���ز�
//============================================================ 
	if (isIE) {
		document.all[LayerName].style.visibility = 'hidden'; 
	} else {
		document.layers[LayerName].visibility = 'hide';
	}
}

function showLayer() {
//============================================================ 
// ��ͼ���ϵ���������ʱ��ʾ��
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
// ���ò��λ��
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
