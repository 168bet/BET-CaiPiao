var _url = "../ajax/Default.ajax.php?3";
var _endtime, _opentime, _refreshtime, _openNumber, _lock=false,_href;
var setResult = new Array(); 
var win = window.parent.document;
_href = $('#gid',win).val();
$(function (){
	//$("#dp").attr("action","./inc/DataProcessing.php?t="+encodeURI($("#tys").html()));
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
	$.post(_url, {typeId : 1}, function(data){ 	
		_Number (data.number, data.ballArr); //開獎號碼
		smlen();//雙面長龍
		sy.html(data.winMoney); //今天輸贏
		cqs();
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

function cqs() { //出球率與無出期數 
	$.post (_url, {typeId : "sumball", gid : _href}, function (data) {
		//alert(data);return;
		var th1 = '<td class="nv">出&nbsp;球&nbsp;率</th>';
		var th2 = '<td class="nv">無出期數</th>';
		var row_1Html = new Array();
		var row_2Html = new Array();
		 
		for (var i in data.row_1){
			row_1Html.push("<td>"+data.row_1[i]+"</td>");
			row_2Html.push("<td>"+data.row_2[i]+"</td>");
		}
		$("#su",win).html(th1+row_1Html.join(''));
		$("#se",win).html(th2+row_2Html.join('')); 
	}, "json");
	 
};

function smlen() { //兩面長龍
	$.post (_url, {typeId : "sumball_s", href : _href}, function (data) {
																 
		if (data.row_1 != ""){
			 
			var row_1Html = new Array();
			for (var key in data.row_1){
				row_1Html.push("<tr>" + "<td class=\"cl_1 inner_text\">" + key + "</td>" + "<td class=\"align-c red\" style=\"width:33%;\">" + data.row_1[key] + "期</td>" + "</tr>");
			}
			$("#cl", win).html('<tbody> <tr>  <th colspan="2">两面长龙排行</th></tr></tbody><tbody id="changlong">' + row_1Html.join("") + "</tbody>"); 
			
		}
		setResult[0] = data.row_2; //號碼
		setResult[1] = data.row_3; //大小
		setResult[2] = data.row_4; //單雙
		setResult[3] = data.row_5; //尾數大小
		setResult[4] = data.row_6; //合數單雙
		setResult[5] = data.row_7; //方位
		setResult[6] = data.row_8; //中發白
		setResult[7] = data.row_9; //總和大小
		setResult[8] = data.row_10; //總和單雙
		setResult[9] = data.row_11; //總和尾數大小
		setResult[10] = data.row_12; //龍虎
		var row_2Html = new Array();
		for (var k in data.row_2){
			row_2Html.push(data.row_2[k]);
		}
		$("#z_cl",win).html(row_2Html.join(''));
		$(".z_cl:even",win).addClass("hhg"); 
		loadResult();
	},'json')
}

function loadResult(){
	$.post("../ajax/loadResult.php", { gameType : "gd"}, function(data){ 
		$('#history').html(data);														  
	})	
}

function loadTime(){
	_openNumber = $("#o",win);

	$.post(_url, {typeId : 'action',nid:'g'+_href}, function(data){ 

		_openNumber.html(data.Phases);
		endtimes(data.endTime);
		opentimes(data.openTime);
		refreshTimes(data.refreshTime);
		loadodds(data.odds, data.endTime, data.Phases);
		loadinput(data.endTime);
	}, "json");
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
			$.post(_url, {typeId : 'action',nid:'g'+_href}, function(data){
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
				 loadodds(data.odds, _endtime, data.Phases);
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
	var odds, link, _urls;
	if (oddslist == null || oddslist == "" || endtime <1) {
		parent.doFengPan(); 
		return false;
	}
	parent.doKaiPan();
	for (var n=0; n<oddslist.length; n++){
		for (var i in oddslist[n]){
			odds = oddslist[n][i];  
			$("td[scope=" + i + "]", win).html(odds); 
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
				$.post(_url, {typeId : 3}, function(data){
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
	$.post("../ajax/Default.ajax.php", {
        typeId: "sessionId"
    },
    function() {});
	var money = $('#kuashuorder',win).val();
	if(parent.yzOrderMoney( money )==false){
		return false;
	}
	money=parseInt(money);
	var sArray = nameformat($('input[name=kuashuorder_next]',win).attr('id').replace('JL_','').split('_')) + "," + money + "|";
	doOK(sArray);
	parent.hideLoading();
	return true;
}

function kuaijie(sender){
	$.post("../ajax/Default.ajax.php", { typeId : "sessionId"}, function(){});
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
	parent.hideLoading();
}

function submitforms(sender){
	if( $('body',win).attr('nav')=='odds' ){
		kuaijie(sender);
	}else{
		$.post("../ajax/Default.ajax.php", { typeId : "sessionId"}, function(){});
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
		parent.hideLoading();
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
		case "t1" : h="a"; arr[0] = "第一球"; break;
		case "t2" : h="b"; arr[0] = "第二球"; break;
		case "t3" : h="c"; arr[0] = "第三球"; break;
		case "t4" : h="d"; arr[0] = "第四球"; break;
		case "t5" : h="e"; arr[0] = "第五球"; break;
		case "t6" : h="f"; arr[0] = "第六球"; break;
		case "t7" : h="g"; arr[0] = "第七球"; break;
		case "t8" : h="h"; arr[0] = "第八球"; break;
		case "t9" : arr[0] = "總和"; break;
	}
	switch (array[1]) {
		case "h1": arr[1] = '01'; arr[2]="h1"; break;
		case "h2": arr[1] = '02'; arr[2]="h2"; break;
		case "h3": arr[1] = '03'; arr[2]="h3"; break;
		case "h4": arr[1] = '04'; arr[2]="h4"; break;
		case "h5": arr[1] = '05'; arr[2]="h5"; break; 
		case "h6": arr[1] = '06'; arr[2]="h6"; break; 
		
		case "h7": arr[1] = '07'; arr[2]="h7"; break;
		case "h8": arr[1] = '08'; arr[2]="h8"; break;
		case "h9": arr[1] = '09'; arr[2]="h9"; break;
		case "h10": arr[1] = '10'; arr[2]="h10"; break;
		case "h11": arr[1] = '11'; arr[2]="h11"; break; 
		case "h12": arr[1] = '12'; arr[2]="h12"; break; 
		
		case "h13": arr[1] = '13'; arr[2]="h13"; break;
		case "h14": arr[1] = '14'; arr[2]="h14"; break;
		case "h15": arr[1] = '15'; arr[2]="h15"; break;
		case "h16": arr[1] = '16'; arr[2]="h16"; break;
		case "h17": arr[1] = '17'; arr[2]="h17"; break; 
		case "h18": arr[1] = '18'; arr[2]="h18"; break; 
		case "h19": arr[1] = '19'; arr[2]="h19"; break; 
		case "h20": arr[1] = '20'; arr[2]="h20"; break; 
		
		
		case "h21": arr[1] = '大'; arr[2]=array[1]; break;
		case "h22": arr[1] = '小'; arr[2]=array[1]; break;
		case "h23": arr[1] = '單'; arr[2]=array[1]; break;
		case "h24": arr[1] = '雙'; arr[2]=array[1]; break;
		case "h25": arr[1] = '尾大'; arr[2]=array[1]; break;
		case "h26": arr[1] = '尾小'; arr[2]=array[1]; break;
		case "h27": arr[1] = '合數單'; arr[2]=array[1]; break;
		case "h28": arr[1] = '合數雙'; arr[2]=array[1]; break;
		
		case "h29": arr[1] = '東'; arr[2]=array[1]; break;
		case "h30": arr[1] = '南'; arr[2]=array[1]; break;
		case "h31": arr[1] = '西'; arr[2]=array[1]; break;
		case "h32": arr[1] = '北'; arr[2]=array[1]; break;
		
		case "h33": arr[1] = '中'; arr[2]=array[1]; break;
		case "h34": arr[1] = '發'; arr[2]=array[1]; break;
		case "h35": arr[1] = '白'; arr[2]=array[1]; break;
		
		case "h36": arr[1] = '龍'; arr[2]=array[1]; break;
		case "h37": arr[1] = '虎'; arr[2]=array[1]; break;
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
	if (str == "第1球" || str == "第2球" || str == "第3球" || str == "第4球" || str == "第5球" || str == "第6球" || str == "第7球" || str == "第8球")
		return setResult[0];
	switch (str){
		case "大小" : return setResult[1];
		case "單雙" : return setResult[2];
		case "尾數大小" : return setResult[3];
		case "合數單雙" : return setResult[4];
		case "方位" : return setResult[5];
		case "中發白" : return setResult[6];
		case "總和大小" : return setResult[7];
		case "總和單雙" : return setResult[8];
		case "總和尾數大小" : return setResult[9];
		case "龍虎" : return setResult[10];
		default:return setResult[0];
	}
}






