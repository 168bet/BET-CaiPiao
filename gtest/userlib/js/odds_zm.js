var _url = "../ajax/oddsJsonzm.php";
var _endtime, _opentime, _refreshtime, _openNumber, _lock=false;
var setResults = new Array();
var win = window.parent.document;
$(function (){ 
	loadInfo(false);
	loadTime();
	setOpnumberTirem();
	$('#firstball', win).find('th').bind('click',
    function() {
        getResult(this, $('#firstball', win))
    });
	$('#submit_top,#submit',win).bind('click',function(){submitforms(this)});
}); 
/**
 * 開出號碼須加載
 */
function loadInfo(bool){
	var sy = $("#sy",win);
	var number = $("#number",win); //開獎期數 
	$.post(_url, {tid : 1}, function(data){
		_Number (data.number, data.ballArr); //開獎號碼
		smlen(data);//雙面長龍
		sy.html(data.winMoney); //今天輸贏 
	}, "json");
	if (bool == true) { 
		$("#look",win).html("<embed width=\"0\" height=\"0\" src=\"js/c.swf\" type=\"application/x-shockwave-flash\" hidden=\"true\" />"); 
	}
}
function _Number (number, ballArr) { 
	var Clss = null;
	var idArr = ["#a","#b","#c","#d","#e","#f","#g","#h"];
	$("#number",win).html(number);
	 
	$('span.number',win).css('visibility','visible');
	for (var i = 0; i < ballArr.length; i++) {
        Clss = "num" + ballArr[i];
        $(idArr[i], win).attr('class','number');
		$(idArr[i], win).addClass(Clss);
    }
}
function smlen(data) { //兩面長龍
	if (data.num_arr != ""){
		var row_1Html = new Array();
		for (var key in data.num_arr){
			row_1Html.push("<tr>" + "<td class=\"cl_1 inner_text\">" + key + "</td>" + "<td class=\"align-c red\" style=\"width:33%;\">" + data.num_arr[key] + "期</td>" + "</tr>");
		}
		$("#cl", win).html('<tbody> <tr>  <th colspan="2">两面长龙排行</th></tr></tbody><tbody id="changlong">' + row_1Html.join("") + "</tbody>"); 
	}
	setResults[0] = data.row_1; //總和大小
	setResults[1] = data.row_2; //總和單雙
	setResults[2] = data.row_3; //總和尾數大小 
	var row_2Html = new Array();
	for (var k in data.row_1){
		row_2Html.push(data.row_1[k]);
	}
	$("#z_cl",win).html(row_2Html.join(''));
	$(".z_cl:even",win).addClass("hhg"); 
	loadResult();
}

function loadResult(){
	$.post("../ajax/loadResult.php", { gameType : "gd"}, function(data){ 
		$('#history').html(data);														  
	})	
}

function loadTime(){
	_openNumber = $("#o",win);
	$.post(_url, {tid : 2}, function(data){   
		_openNumber.html(data.Phases);
		endtimes(data.endTime);
		opentimes(data.openTime);
		refreshTimes(data.refreshTime);
		loadodds(data.oddsList, data.endTime, data.Phases);
		loadinput(data.endTime);
	},"json");
}

/**
 * 封盤時間
 */
function endtimes(endtime){
	var endTime = $("#endTime",win); //封盤時間
	_endtime = endtime;
	if (_endtime >1)
		endTime.html(settime(_endtime));
	var interval = setInterval(function(){ 
		if (_endtime<10&&_endtime>0){ 
			$("#look",win).html("<embed width=\"0\" height=\"0\" src=\"js/d.swf\" type=\"application/x-shockwave-flash\" hidden=\"true\" />");	 
		}	 			
		if (_endtime <= 1) { //封盤時間結束
			clearInterval(interval);
			endTime.html("00:00");
			loadodds(null, endtime, null);		//關閉賠率
			loadinput(-1); 				//關閉輸入框
			return false;
		}
		_endtime--;
		endTime.html(settime(_endtime));
	}, 1000);
}

/**
 * 開獎時間
 */
function opentimes(opentime){
	var openTime = $("#endTimes",win); //開獎時間
	_opentime = opentime;
	if (_opentime >1)
		openTime.html(settime(_opentime));
	var interval = setInterval(function(){
		if (_opentime <= 1) { //開獎時間結束
			clearInterval(interval);
			_lock = true;
			_refreshtime = 5;
			openTime.html("00:00");
			return false;
		}
		_opentime--;
		openTime.html(settime(_opentime));
	}, 1000);
}

/**
 * 90秒刷新
 */
function refreshTimes(refreshtime){
	_refreshtime = refreshtime;
	var refreshTime = $("#endTimea",win); //刷新時間
	refreshTime.html(_refreshtime);
	var interval = setInterval(function(){
		if (_refreshtime <= 1) { //刷新時間結束
			clearInterval(interval);
			$.post(_url, {tid : 2}, function(data){
				if (_lock == true){
					endtimes(data.endTime);
					opentimes(data.openTime);
					loadinput(data.endTime);
					 _openNumber.html(data.Phases);
					 setOpnumberTirem();//加載開獎號碼
					_lock = false;
				}
				 _endtime =data.endTime;
				 _opentime =data.openTime;
				 _refreshtime =data.refreshTime;
				 loadodds(data.oddsList, _endtime, data.Phases);
				 refreshTimes(_refreshtime);
			}, "json");
			return false;
		}
		_refreshtime--;
		refreshTime.html(_refreshtime);
	}, 1000);
}

/**
 * 加載賠率
 */
function loadodds(oddslist, endtime, number){
	var a = ["i","k"];
	var odds, link, urls;
	if (oddslist == null || oddslist == "" || endtime <1) {
		parent.doFengPan(); 
		return false;
	}
	parent.doKaiPan();
	for (var n=0; n<oddslist.length; n++){
		for (var i in oddslist[n]){
			odds = oddslist[n][i]; 
			$("td[scope=" + a[n] + i + "]", win).html(odds); 
		}
	}
}

/**
 * 加載輸入框
 */
function loadinput(endtime){
	var id = $("td.amount", win);
    id.each(function() {
        if ($(this).attr("scope") != "") {
            var tt = $(this).attr("scope").split("_")[0];
            var temp = $(this).attr("scope").split("_")[1];
            if (endtime > 1) $(this).html('<input class="amount-input" type="text" maxlength="9" name="' + tt + '_' + temp + '" />');
            
        }
    });
}

function settime(time){
	var MinutesRound = Math.floor(time / 60);
	var SecondsRound = Math.round(time - (60 * MinutesRound));
	var Minutes = MinutesRound.toString().length <= 1 ? "0"+MinutesRound : MinutesRound;
	var Seconds = SecondsRound.toString().length <= 1 ? "0"+SecondsRound : SecondsRound;
	var strtime = Minutes + ":" + Seconds;
	return strtime;
}

function digitOnly ($this) {
	var n = $($this);
	var r = /^\+?[1-9][0-9]*$/;
	if (!r.test(n.val())) {
		n.val("");
	}
}

function setOpnumberTirem(){
	var opnumber = $("#number",win).html();
	var nownumer = $("#o",win).html();
	if (opnumber != ""){
		var _nownumber = parseInt(nownumer);
		var sum = _nownumber -  parseInt(opnumber);
		if (sum == 2) {
			var interval = setInterval(function(){
				$.post(_url, {tid : 3}, function(data){
					if (_nownumber - parseInt(data) == 1){
						clearInterval(interval);
						loadInfo(true);
						return false;
					}
				}, "text");
			}, 3000);
		}
	} else {
		setTimeout(setOpnumberTirem, 1000);
	}
}

function getHtml($obj){
	var input = $obj.find('input'); 
	var s = nameformat(input.attr("name").split("_"));
	s[2] = $("td[scope=" + s[2] + "]", win).html();
	if (s[0] == "總和") n = '<span class="ks_ball_1">'+s[1] + "</span> <span class='ks_art'>@</span> <span class='ks_peilv'>" + s[2] + "</span> <span class='ks_x'>x</span> ";
	else n =  '<span class="ks_ball_1">' + s[0] + "</span>" + '<span class="ks_ball_2">' + s[1] + "</span> <span class='ks_art'>@</span>  <span class='ks_peilv'>" + s[2] + "</span> <span class='ks_x'>x</span> ";
	var nm = 'JL_'+input.attr("name");
	$('#kuashuorder',win).remove();
	$('#'+nm,win).remove();
	return n+ '<span class="ks_input"><input id="kuashuorder" type="text" style="width:60px" maxlength="9"></input><input name="kuashuorder_next" type=hidden id="'+nm+'" /></span>';
}

function kuaisuXiaZhu(){ 
$.post("../ajax/Default.ajax.php", { typeid : "sessionId"}, function(){});
	var money = $('#kuashuorder',win).val();
	if(parent.yzOrderMoney( money )==false){
		return false;
	}
	money=parseInt(money);
	var sArray = nameformat($('input[name=kuashuorder_next]',win).attr('id').replace('JL_','').split('_')) + "," + money + "|";
	doOK(sArray);
	return true;
}

function kuaijie(sender){
	  $.post("../ajax/Default.ajax.php", { typeid : "sessionId"}, function(){});
	var objArr = parent.getSelectedCollect(); 
	if(objArr.length<1)return false;
	var money = $(sender).attr('id').indexOf('_top')>=0 ? $('#kuaisuamount_top',win).val() : $('#kuaisuamount',win).val();
	if(parent.yzOrderMoney( money )==false){
		return false;
	}
	money=parseInt(money);
	var count = 0;
    var countmoney = 0;
	var names = new Array();
	names.push(parent.getH());
    var sArray = "";
	for(var i=0;i<objArr.length;i++){ 
		s = nameformat($(objArr[i]).attr("abbr").split("_")); 
		s[2] = $("td[scope=" + s[2] + "]", win).html();
		if (s[0] == "總和"){
			n = "<td class='xz_ball_1'><span class='xz_ball_11'>" + s[1] + "</span> </td> ";  
		}else{
			n = "<td class='xz_ball_1'><span class='xz_ball_11'>" + s[0] + "</span> <span class='xz_ball_12'>"+ s[1] +"</span></td> "; 
		}
		n+="<td class='xz_peilv'>"+s[2]+"</td>";
		n+="<td class='xz_money'>"+money+"</td>";
		names.push("<tr>"+n+"</tr>");
		sArray += s + "," + money + "|"; 
		countmoney+=money;
		count++;
	}
	names.push(parent.getB(count,countmoney)); 
	parent.doReset();
	parent.showQueRen(names.join(""),doOK,sArray); 
}

function submitforms(sender){
	if( $('body',win).attr('nav')=='odds' ){
		kuaijie(sender);
	}else{ 
		var mixmoney = parseInt($("#mix", win).val()); //最低下注金額
		var input = $("input.amount-input", win); 
		var c = true,
		s, n;
		var count = 0;
		var countmoney = 0;
		var upmoney = 0;
		var names = new Array();
		names.push(parent.getH());
		var sArray = "";
		input.each(function() {
			var value = $(this).val();
			if (value != "") {
				value = parseInt(value);
				if (value < mixmoney) c = false;
				count++;
				countmoney += value;
				s = nameformat($(this).attr("name").split("_"));
				s[2] = $("td[scope="+s[2]+"]",win).html();
				if (s[0] == "總和"){
					n = "<td class='xz_ball_1'><span class='xz_ball_11'>" + s[1] + "</span> </td> ";  
				}else{
					n = "<td class='xz_ball_1'><span class='xz_ball_11'>" + s[0] + "</span> <span class='xz_ball_12'>"+ s[1] +"</span></td> "; 
				}
				n+="<td class='xz_peilv'>"+s[2]+"</td>";
				n+="<td class='xz_money'>"+value+"</td>";
				names.push("<tr>"+n+"</tr>");
				sArray += s + "," + value + "|";
			}
		}); 
		if (count == 0) {
			parent.showAlert("您输入类型不正确或没有输入实际金额！");
			return false;
		}
		if (c == false) {
			parent.showAlert("你输入的金额低于单注最低("+mixmoney+")的限制！");
			return false;
		}
		 
		names.push(parent.getB(count,countmoney)); 
		parent.doReset();
		parent.showQueRen(names.join(""),doOK,sArray);
		return false;
	}
}
 

function doOK(sArray){ 
	var number = $("#o", win).html(); 
	 
	var s_type = '<input type="hidden" name="sm_arr" value="' + sArray + '"><input type="hidden" name="s_number" value="' + number + '">';
	s_type += '<input type="hidden" name="actions" value="fn3" />'; 
	$('form[name=postform]',win).attr('action','./inc/DataProcessing.php');
	$('form[name=postform]',win).html(s_type);
	$('form[name=postform]',win)[0].submit();
	parent.showXZLoading();
	return true;
}

function nameformat(array){
	var arr = new Array(), h;
	switch (array[0]){ 
		case "t9" : arr[0] = "總和"; break;
		case "t11" : arr[0] = "正碼"; break;
	}
	 
	if(arr[0]=="正碼"){
		switch (array[1]) {
			case "h1": arr[1] = '01'; arr[2]="kh1"; break;
			case "h2": arr[1] = '02'; arr[2]="kh2"; break;
			case "h3": arr[1] = '03'; arr[2]="kh3"; break;
			case "h4": arr[1] = '04'; arr[2]="kh4"; break;
			case "h5": arr[1] = '05'; arr[2]="kh5"; break; 
			case "h6": arr[1] = '06'; arr[2]="kh6"; break; 
			
			case "h7": arr[1] = '07'; arr[2]="kh7"; break;
			case "h8": arr[1] = '08'; arr[2]="kh8"; break;
			case "h9": arr[1] = '09'; arr[2]="kh9"; break;
			case "h10": arr[1] = '10'; arr[2]="kh10"; break;
			case "h11": arr[1] = '11'; arr[2]="kh11"; break; 
			case "h12": arr[1] = '12'; arr[2]="kh12"; break; 
			
			case "h13": arr[1] = '13'; arr[2]="kh13"; break;
			case "h14": arr[1] = '14'; arr[2]="kh14"; break;
			case "h15": arr[1] = '15'; arr[2]="kh15"; break;
			case "h16": arr[1] = '16'; arr[2]="kh16"; break;
			case "h17": arr[1] = '17'; arr[2]="kh17"; break; 
			case "h18": arr[1] = '18'; arr[2]="kh18"; break; 
			case "h19": arr[1] = '19'; arr[2]="kh19"; break; 
			case "h20": arr[1] = '20'; arr[2]="kh20"; break;  
		} 
	}
	if(arr[0]=="總和"){
		switch (array[1]) {
			case "h1": arr[1] = '總和大'; arr[2]="ih1"; break;
			case "h2": arr[1] = '總和單'; arr[2]="ih2"; break;
			case "h3": arr[1] = '總和小'; arr[2]="ih3"; break;
			case "h4": arr[1] = '總和雙'; arr[2]="ih4"; break;
			case "h5": arr[1] = '總和尾大'; arr[2]="ih5"; break; 
			case "h7": arr[1] = '總和尾小'; arr[2]="ih7"; break;  
		}
	}
	
	return arr;
}

function getResult(sender, element) {
	element.find('th').removeClass('kon');
    $(sender).addClass('kon');
	var rowHtml = new Array();
	var data = stringByInt ($(sender).html());
	for (var k in data){
		rowHtml.push(data[k]);
	}
	$("#z_cl",win).html(rowHtml.join(''));
	$(".z_cl:even",win).addClass("hhg");
}

function stringByInt (str){
	switch (str){
		case "總和大小" : return setResults[0];
		case "總和單雙" : return setResults[1];
		case "總和尾數大小" : return setResults[2]; 
	}
}






