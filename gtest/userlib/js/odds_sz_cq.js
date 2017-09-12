var win = window.parent.document;
var _url = "../ajax/cqoddsJsonsz_u.php";
var _endtime, _opentime, _refreshtime, _openNumber, _lock=false;
var setResultcq = new Array();
$(function (){ 
	loadInfo(false);
	loadTime();
	setOpnumberTirem();
	$('#firstball', win).find('th').bind('click',
    function() {
        getResult(this, $('#firstball', win))
    });
	$('#submit_top,#submit',win).bind('click',function(){submitforms(this)});
	$('.qzh-list',win).bind('click',function(){
		$(this).parent().find($(this).attr('tagName')).removeClass('kon');		
		$(this).addClass('kon');
		$('#qiansan_t,#zhongsan_t,#housan_t',win).hide();
		switch( $(this).attr('id') ){
			case '111':
				$('#qiansan_t',win).show();break;
			case '222':
				$('#zhongsan_t',win).show();break;
			case '333':
				$('#housan_t',win).show();break;
		}
	})
	
	$('#firstball1',win).find('th').bind('click',function(){
		var rowHtml3 = new Array();
		var html = $(this).html( );
		var myData = stringByInt1( html )
		for (var k in myData){
			rowHtml3.push(myData[k]);
		}
		$("#z_cl",win).html(rowHtml3.join(''));
		$(".z_cl:even",win).addClass("hhg");   
		$('#firstball1',win).find('th').removeClass('kon');
		$(this).addClass('kon');
	})
});

/**
 * 開出號碼須加載
 */
function loadInfo(bool){
	var sy = $("#sy",win); 
	var number = $("#number",win); //開獎期數 
	 
	$.post(_url, {tid : 1}, function(data){   
		_Number (data.number, data.ballArr); //開獎號碼
		openNumberCount(data, bool);//雙面長龍
		sy.html(data.winMoney); //今天輸贏
	}, "json");
	if (bool == true) { 
		$("#look",win).html("<embed width=\"0\" height=\"0\" src=\"js/c.swf\" type=\"application/x-shockwave-flash\" hidden=\"true\" />"); 
	}
}
function _Number (number, ballArr) {
	var Clss = null;
	var idArr = ["#a","#b","#c","#d","#e"];
	$("#number",win).html(number); 
	 
	$('span.number',win).css('visibility','visible'); 
    for (var i = 0; i < ballArr.length; i++) {
        Clss = "num" + ballArr[i];
        $(idArr[i], win).attr('class','number');
		$(idArr[i], win).addClass(Clss);
    }
}
function openNumberCount(row, bool){ 
	var rowHtml1 = new Array();
	var rowHtml2 = new Array();
	var rowHtml3 = new Array();
	for (var i in row.result1){
		rowHtml1.push("<td><span class='red fontweight'>"+row.result1[i]+"</span></td>");
	}
	$("#su",win).html(rowHtml1.join('')); 
	$("#su",win).find('td').last().addClass('td-last');
	for (var k in row.result1HM){
		rowHtml2.push(row.result1HM[k]);
	}
	$("#z_cl",win).html(rowHtml2.join(''));
	$(".z_cl:even",win).addClass("hhg");
	if (row.row8 != ""){
		for (var key in row.resultCL){ 
			rowHtml3.push("<tr>" + "<td class=\"cl_1 inner_text\">" + key + "</td>" + "<td class=\"align-c red\" style=\"width:33%;\">" + row.resultCL[key] + "期</td>" + "</tr>");
		} 
		$("#cl",win).html('<tbody> <tr>  <th colspan="2">两面长龙排行</th></tr></tbody><tbody id="changlong">' + rowHtml3.join("") + "</tbody>");
	}
	setResultcq[0]=new Array(); 
	setResultcq[0][0]=row.result1;
	setResultcq[0][1]=row.result1HM;
	setResultcq[0][2]=row.result1DX;
	setResultcq[0][3]=row.result1DS;
	setResultcq[1]=new Array(); 
	setResultcq[1][0]=row.result2;
	setResultcq[1][1]=row.result2HM;
	setResultcq[1][2]=row.result2DX;
	setResultcq[1][3]=row.result2DS;
	setResultcq[2]=new Array(); 
	setResultcq[2][0]=row.result3;
	setResultcq[2][1]=row.result3HM;
	setResultcq[2][2]=row.result3DX;
	setResultcq[2][3]=row.result3DS;
	setResultcq[3]=new Array(); 
	setResultcq[3][0]=row.result4;
	setResultcq[3][1]=row.result4HM;
	setResultcq[3][2]=row.result4DX;
	setResultcq[3][3]=row.result4DS;
	setResultcq[4]=new Array(); 
	setResultcq[4][0]=row.result5;
	setResultcq[4][1]=row.result5HM;
	setResultcq[4][2]=row.result5DX;
	setResultcq[4][3]=row.result5DS;
	setResultcq[5] = row.resultZHDX;
	setResultcq[6] = row.resultZHDS;
	setResultcq[7] = row.resultZHLH;
	$('#firstball',win).find('th.kon').trigger('click');
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
	var a = ["a","b","c","d","e","f","g","h","i"];
	var odds, link, urls;
	 
	if (oddslist == null || oddslist == "" || endtime <1) {
		 
		$('.fontBlue,td.o,span.amount',win).addClass('huiseBg');
		$('span.o,span.amount',win).html('');	
		return false;
	}
	$('.fontBlue,td.o,span.amount',win).removeClass('huiseBg');
	for (var n=0; n<oddslist.length; n++){
		for (var i in oddslist[n]){
			odds = oddslist[n][i]; 
			$("span[scope=" + a[n] + i + "]", win).html(odds); 
		}
	}
}
function bc(str){
		switch (str){
			case "a" : return "Ball_1";
			case "b" : return "Ball_2";
			case "c" : return "Ball_3";
			case "d" : return "Ball_4";
			case "e" : return "Ball_5";
			case "f" : return "Ball_6";
			case "g" : return "Ball_7";
			case "h" : return "Ball_8";
			case "i" : return "Ball_9";
		}
	}
/**
 * 加載輸入框
 */
function loadinput(endtime){ 
	var id = $("span.amount", win);
    id.each(function() {
        if ($(this).attr("scope")!=null && $(this).attr("scope") != "") { 
            var tt = $(this).attr("scope").replace('_','m').replace('t','Ball_');
            if (endtime > 1) $(this).html('<input class="amount-input" type="text" maxlength="9" name="' + tt + '" />'); 
        }
    }); 
}

function getHtml($obj){
	var input = $obj.find('input'); 
	var ss=$(input).attr("name").split("m");
	 
	var s = nameformat(ss); 
	s[2] = $("span[scope=" + s[2] + "]", win).html();
	if (s[0] == "總和、龍虎") n = '<span class="ks_ball_1">'+s[1] + "</span> <span class='ks_art'>@</span> <span class='ks_peilv'>" + s[2] + "</span> <span class='ks_x'>x</span> ";
	else n =  '<span class="ks_ball_1">' + s[0] + "</span>" + '<span class="ks_ball_2">' + s[1] + "</span> <span class='ks_art'>@</span>  <span class='ks_peilv'>" + s[2] + "</span> <span class='ks_x'>x</span> ";
	var nm = 'JL_'+input.attr("name");
	$('#kuashuorder',win).remove();
	$('#'+nm,win).remove();
	return n+ '<span class="ks_input"><input id="kuashuorder" type="text" style="width:60px" maxlength="9"></input><input name="kuashuorder_next" type=hidden id="'+nm+'" /></span>';
}
function kuaisuXiaZhu(){
	 
	var money = $('#kuashuorder',win).val();
	if(parent.yzOrderMoney( money )==false){
		return false;
	}
	money=parseInt(money);
	var sArray = nameformat2($('input[name=kuashuorder_next]',win).attr('id').replace('JL_','').split('m')) + "," + money + "|";
	doOK(sArray);
	return true;
}

function kuaijie(sender){
	 
	var objArr = parent.getSelectedCollect_zh(); 
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
		ss=$(objArr[i]).find("input").attr('name').split("m"); 
		s = nameformat(ss);  
		ss2 = nameformat2(ss);
		sArray += ss2+","+money+"|"; 
		s[2] = $("span[scope=" + s[2] + "]", win).html();
		if (s[0] == "總和、龍虎"){
			n = "<td class='xz_ball_1'><span class='xz_ball_11'>" + s[1] + "</span> </td> ";  
		}else{
			n = "<td class='xz_ball_1'><span class='xz_ball_11'>" + s[0] + "</span> <span class='xz_ball_12'>"+ s[1] +"</span></td> "; 
		}
		n+="<td class='xz_peilv'>"+s[2]+"</td>";
		n+="<td class='xz_money'>"+money+"</td>";
		names.push("<tr>"+n+"</tr>"); 
		countmoney+=money;
		count++;
	}
	names.push(parent.getB(count,countmoney)); 
	parent.doReset();
	parent.showQueRen(names.join(""),doOK,sArray); 
}

function submitforms(sender) {  
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
				 
				ss=$(this).attr("name").split("m"); 
				ss2 = nameformat2(ss);
				sArray += ss2+","+value+"|"; 
				s = nameformat(ss);
				
				s[2] = $("span[scope=" + s[2] + "]", win).html();
				if (s[0] == "總和、龍虎"){
					n = "<td class='xz_ball_1'><span class='xz_ball_11'>" + s[1] + "</span> </td> ";  
				}else{
					n = "<td class='xz_ball_1'><span class='xz_ball_11'>" + s[0] + "</span> <span class='xz_ball_12'>"+ s[1] +"</span></td> "; 
				}
				n+="<td class='xz_peilv'>"+s[2]+"</td>";
				n+="<td class='xz_money'>"+value+"</td>";
				names.push("<tr>"+n+"</tr>"); 
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
	var s_type = '<input type="hidden" name="s_cq" value="' + sArray + '"><input type="hidden" name="s_number" value="' + number + '">';
	s_type += '<input type="hidden" name="actions" value="fn3" />';
	 
	$('form[name=postform]',win).attr('action','./inc/DataProcessingcqsz.php');
	$('form[name=postform]',win).html(s_type);
	$('form[name=postform]',win)[0].submit();
	parent.showXZLoading();
	return true;
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


 



function nameformat(array){
	var arr = new Array(), h='';
	switch (array[0]){
		case "Ball_1" : h="a"; arr[0] = "第一球"; break;
		case "Ball_2" : h="b"; arr[0] = "第二球"; break;
		case "Ball_3" : h="c"; arr[0] = "第三球"; break;
		case "Ball_4" : h="d"; arr[0] = "第四球"; break;
		case "Ball_5" : h="e"; arr[0] = "第五球"; break;
		case "Ball_6" : 
			arr[0] = "總和、龍虎"; 
			 
			switch (array[1]) {
				case 'h1':arr[1] = '總和大'; arr[2]='f'+array[1]; break;
				case 'h2':arr[1] = '總和小'; arr[2]='f'+array[1]; break;
				case 'h3':arr[1] = '總和單'; arr[2]='f'+array[1]; break;
				case 'h4':arr[1] = '總和雙'; arr[2]='f'+array[1]; break;
				case 'h5':arr[1] = '龍'; arr[2]='f'+array[1]; break;
				case 'h6':arr[1] = '虎'; arr[2]='f'+array[1]; break;
				case 'h7':arr[1] = '和'; arr[2]='f'+array[1]; break;
			}
			break;
		case "Ball_7" : 
			arr[0] = "前三";  
			switch (array[1]) {
				case 'h1':arr[1] = '豹子'; arr[2]='g'+array[1]; break;
				case 'h2':arr[1] = '順子'; arr[2]='g'+array[1]; break;
				case 'h3':arr[1] = '對子'; arr[2]='g'+array[1]; break;
				case 'h4':arr[1] = '半順'; arr[2]='g'+array[1]; break;
				case 'h5':arr[1] = '雜六'; arr[2]='g'+array[1]; break; 
			} 
			break;
		case "Ball_8" : 
			arr[0] = "中三"; 
			switch (array[1]) {
				case 'h1':arr[1] = '豹子'; arr[2]='h'+array[1]; break;
				case 'h2':arr[1] = '順子'; arr[2]='h'+array[1]; break;
				case 'h3':arr[1] = '對子'; arr[2]='h'+array[1]; break;
				case 'h4':arr[1] = '半順'; arr[2]='h'+array[1]; break;
				case 'h5':arr[1] = '雜六'; arr[2]='h'+array[1]; break; 
			}  
			break;
		case "Ball_9" : 
			arr[0] = "后三"; 
			switch (array[1]) {
				case 'h1':arr[1] = '豹子'; arr[2]='i'+array[1]; break;
				case 'h2':arr[1] = '順子'; arr[2]='i'+array[1]; break;
				case 'h3':arr[1] = '對子'; arr[2]='i'+array[1]; break;
				case 'h4':arr[1] = '半順'; arr[2]='i'+array[1]; break;
				case 'h5':arr[1] = '雜六'; arr[2]='i'+array[1]; break; 
			}  
			break;
	}
	if(h!=''){
		 
		switch (array[1]) {
			case "h1": arr[1] = '0'; arr[2]=h+"h1"; break;
			case "h2": arr[1] = '01'; arr[2]=h+"h3"; break;
			case "h3": arr[1] = '02'; arr[2]=h+"h5"; break;
			case "h4": arr[1] = '03'; arr[2]=h+"h6"; break;
			case "h5": arr[1] = '04'; arr[2]=h+"h2"; break;
			case "h6": arr[1] = '05'; arr[2]=h+"h4"; break;
			case "h7": arr[1] = '06'; arr[2]=h+"h7"; break;
			case "h8": arr[1] = '07'; arr[2]=h+"h8"; break;
			case "h9": arr[1] = '08'; arr[2]=h+"h9"; break;
			case "h10": arr[1] = '09'; arr[2]=h+"h10"; break;
			
			case "h11": arr[1] = '大'; arr[2]=h+"h11"; break;
			case "h12": arr[1] = '小'; arr[2]=h+"h12"; break;
			case "h13": arr[1] = '單'; arr[2]=h+"h13"; break;
			case "h14": arr[1] = '雙'; arr[2]=h+"h14"; break;
		}
	} 
	return arr;
}


function nameformat2(array){
	var arr = new Array(), h;
	switch (array[0]){
		case "Ball_1" : h="a"; arr[0] = "Ball_1"; break;
		case "Ball_2" : h="b"; arr[0] = "Ball_2"; break;
		case "Ball_3" : h="c"; arr[0] = "Ball_3"; break;
		case "Ball_4" : h="d"; arr[0] = "Ball_4"; break;
		case "Ball_5" : h="e"; arr[0] = "Ball_5"; break;
		case "Ball_6" : h="f"; arr[0] = "Ball_6"; break;
		case "Ball_7" : h="g"; arr[0] = "Ball_7"; break;
		case "Ball_8" : h="h"; arr[0] = "Ball_8"; break;
		case "Ball_9" : h="i"; arr[0] = "Ball_9"; break;
	
	}
 	 arr[1]=h+array[1]; 
	return arr;
}



function getResult(sender, element){
	element.find('th').removeClass('kon');
    $(sender).addClass('kon');
    var rowHtml = new Array();
	var rowHtml2 = new Array();
    var data = stringByInt($(sender).html()); 
	for (var k in data[0]){
		rowHtml.push("<td><span class='red fontweight'>"+data[0][k]+"</span></td>");
	}
	$("#su",win).html(rowHtml.join('')); 
	$("#su",win).find('td').last().addClass('td-last');  
	
	for (var k in data[1]){
		rowHtml2.push(data[1][k]);
	}
	$("#z_cl",win).html(rowHtml2.join(''));
	$(".z_cl:even",win).addClass("hhg");   
	$('#firstball1',win).find('th').first().html( $(sender).html() );
	$('#firstball1',win).find('th').removeClass('kon') 
	$('#firstball1',win).find('th').first().addClass('kon');
}

function stringByInt (str){
	switch (str){
		case "第一球" : return setResultcq[0];
		case "第二球" : return setResultcq[1];
		case "第三球" : return setResultcq[2];
		case "第四球" : return setResultcq[3];
		case "第五球" : return setResultcq[4];
	}
}

function stringByInt1 (str){
	var h = $('#firstball1',win).find('th').first().html();
	var $i = stringByInt(h);
	switch (str){
		case "大小" : return $i[2];
		case "單雙" : return $i[3];
		case "總和大小" : return setResultcq[5];
		case "總和單雙" : return setResultcq[6];
		case "龍虎和" : return setResultcq[7];
		default:return  $i[1];
	}
}






