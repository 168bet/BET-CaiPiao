var _url = "../ajax/Default.ajax_nc.php?3";
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
	clickXG();
	$('.lianmatab',win).bind('click',function(){
		$('.lianmatab',win).removeClass('kon');
		$(this).addClass('kon');
		$(":radio",win).attr('checked','');
		$(this).find(':radio').attr('checked','checked');
		myReset(); 
		
	})
	$('#reset',win).bind('click',function(){myReset()});
});

function myReset(){
	$('.ballno-t-t,.chkbox',win).removeClass('onBg').removeClass('bc');
	$(":checkbox",win).attr('checked','');
	$(":checkbox",win).attr('disabled','');
	$('.bulk-amount-times',win).hide();
	$('#kuaisuamount',win).val('');
	
	$(":radio",win).each(function () {
		if ($(this).attr("checked")) { 
			var v = $(this).val(); 
			if(v=='t1'){ 
				$('#t19',win).attr('disabled','disabled');	
				$('#t20',win).attr('disabled','disabled');	 
			}else if(  v=='t2' ){
				for(var i=1;i<=18;i++)$('#t'+i,win).attr('disabled','disabled');	
			} 
		}
	});	
	
	
}

function clickXG(){
	$('.ballno-t-t',win).bind('click',function(){ 
		if( $(this).attr('class').indexOf('onBg')>=0 ){
			$(this).removeClass('onBg');
			$(this).next().removeClass('onBg');
			$(this).next().find('input[type=checkbox]').attr('checked','');
			rm();
		}else{
			if($(this).next().find('input[type=checkbox]').attr('disabled')!="")return; 
			$(this).addClass('onBg');
			$(this).next().addClass('onBg');
			$(this).next().find('input[type=checkbox]').attr('checked','checked');
			rm();	
		}
	})	
	$('.chkbox',win).bind('click',function(){
		if( $(this).attr('class').indexOf('onBg')>=0 ){
			$(this).removeClass('onBg');
			$(this).prev().removeClass('onBg');
			$(this).find('input[type=checkbox]').attr('checked','');
			rm();
		}else{
			if($(this).find('input[type=checkbox]').attr('disabled')!="")return; 
			$(this).addClass('onBg');
			$(this).prev().addClass('onBg');
			$(this).find('input[type=checkbox]').attr('checked','checked');
			rm();	
		}
	})	
	$('.ballno-t-t,.chkbox',win).bind('mouseenter',function(){
		if( $(this).attr('class').indexOf('onBg')>=0 )return;
		$(this).addClass('bc');
		if( $(this).attr('class').indexOf('ballno-t-t')>=0 ){$(this).next().addClass('bc');}else{$(this).prev().addClass('bc');}
	})
	$('.ballno-t-t,.chkbox',win).bind('mouseleave',function(){
		if( $(this).attr('class').indexOf('onBg')>=0 )return;
		$(this).removeClass('bc');
		if( $(this).attr('class').indexOf('ballno-t-t')>=0 ){$(this).next().removeClass('bc');}else{$(this).prev().removeClass('bc');}
	})
}

 
function rm(){
	$(":radio",win).each(function () {
		if ($(this).attr("checked")) {
			check($(this).val());
			zhushu( $(this).val() );
		}
	});	
}
function getC($count){
	switch ($count) {
		case "t1" : $count = 1 ;break;
		case "t2" : $count = 1 ;break;
		case "t3" : $count = 2 ;break;
		case "t4" : $count = 2 ;break;
		case "t5" : $count = 2 ;break;
		case "t6" : $count = 3 ;break;
		case "t7" : $count = 4 ;break;
		case "t8" : $count = 5 ;break;
	}
	return $count;
}
function zhushu($count){
	var che = $(":checkbox",win);
	var $Number = new Array(); 
	che.each(function () {
		if ($(this).attr("checked")) {
			$Number.push( $(this).val() ); 
		}
	}); 
	$count = getC($count);
	$('#selectedlist',win).html( $Number.join(',') );
	if($Number.length>=$count){
		$s = parent.subArr($Number,$count,0);
	}else{
		$s=0;	
	}
	$('#selectedAmount',win).html($s);
}

function check(value) {
	
	var c = 0;
	var che = $(":checkbox",win)
	che.each(function () {
		if ($(this).attr("checked")) {
			c++; 
		}
	}); 
	
	if(c>0){ 
		$('.bulk-amount-times',win).show();
	}
	if(c>=10){
		atts(che,"disabled");	
	}else{
		atts(che,"");		
	}
	if (value == "t1") {
		$('#t19',win).attr('disabled','disabled');	
		$('#t20',win).attr('disabled','disabled');	
	} else if (value == "t2") {
		for(var i=1;i<=18;i++)$('#t'+i,win).attr('disabled','disabled');
	}
}
function atts (che,value) {
	che.each(function () {
		if (!$(this).attr("checked")) {
			$(this).attr("disabled",value);
		}
	});
}

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

 

function smlen() { //兩面長龍
	$.post (_url, {typeId : "sumball_s", href : _href}, function (data) { 
		if (data.row_1 != ""){
			 
			var row_1Html = new Array();
			for (var key in data.row_1){
				row_1Html.push("<tr>" + "<td class=\"cl_1 inner_text\">" + key + "</td>" + "<td class=\"align-c red\" style=\"width:33%;\">" + data.row_1[key] + "期</td>" + "</tr>");
			}
			$("#cl", win).html('<tbody> <tr>  <th colspan="2">两面长龙排行</th></tr></tbody><tbody id="changlong">' + row_1Html.join("") + "</tbody>");  
		} 
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
	 
	$.post(_url, {typeId : 'action',nid:'k2'}, function(data){ 
	 
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
			$.post(_url, {typeId : 'action',nid:'k2'}, function(data){
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
	var odds, link, _urls;
	if (oddslist == null || oddslist == "" || endtime <1) {
		$("span.o",win).html("-");
		return false;
	}
	for (var n=0; n<oddslist.length; n++){
		for (var i in oddslist[n]){
			odds = oddslist[n][i];  
			$("span[id=" + i + "]", win).html(odds); 
		}
	}
}

/**
 * 加載輸入框
 */
function loadinput(endtime){
	 
    if (endtime < 1)  $(":checkbox", win).attr('disabled','disabled');
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

 
function submitforms(sender){  
		$.post("../ajax/Default.ajax_nc.php", { typeId : "sessionId"}, function(){});
		var money =  $('#kuaisuamount',win).val();
		if(parent.yzOrderMoney( money )==false){
			return false;
		}
		money=parseInt(money); 
		var names = new Array();
		names.push(parent.getH());
		var sArray = ""; 
		var $count="";
		var wanfa = "";
		var peilv = "";
		var tt="";
		$(":radio",win).each(function(){
			if( $(this).attr("checked") ){
				tt=$count = $(this).val();	
				wanfa = $(this).parent().find('label').html();
				peilv = $(this).parent().find('span.o').html();
			}						   
		})
		if($count=="" || wanfa==""){
			parent.showAlert("請至少選擇一種玩法");
			return ;
		}
		var che = $(":checkbox",win);
		var $Number = new Array(); 
		che.each(function () {
			if ($(this).attr("checked")){
				$Number.push( $(this).val() ); 
			}
		}); 
		$count = getC($count); 
		var s = 0; 
		if($Number.length<$count){ 
			parent.showAlert("你选择的球号数量不够，此玩法最少选择"+$count+"个球号！");
			return ;
		}else{
			s = parent.subArr($Number,$count,0); 
		}
		var n="<td class='xz_ball_1'><span class='xz_ball_11'>" + wanfa + "</span>  <span class='xz_ball_12'>"+ $Number.join(',') +"</span></td> ";  
		n+="<td class='xz_peilv'>"+peilv+"</td>";
		n+="<td class='xz_money'>"+money+"</td>"; 
		names.push(n);
		var countmoney = parseInt(s)*money; 
		names.push(parent.getB(s,countmoney)); 
		myReset();
		var html='<input type="hidden" name="actions" value="fn2" />'+
				'<input type="hidden" name="gtypes" value="1" />'+
				'<input type="hidden" name="s_type" value="'+tt+'" />'+
				'<input type="hidden" name="s_number" value="'+$('#o',win).html()+'" />'+
				'<input type="hidden" name="s_ball" value="'+$Number.join('、')+'" />'+
				'<input type="hidden"  name="s_money"  value="'+money+'" />';  
		parent.showQueRen(names.join(""),doOK,html);
		return false;
	 
}
 

function doOK(html){  
	$('form[name=postform]',win).attr('action','./inc/DataProcessingnc.php');
	$('form[name=postform]',win).html(html);
	$('form[name=postform]',win)[0].submit();
	parent.showXZLoading();
	return true;
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
		case "梅兰菊竹" : return setResult[5];
		case "中發白" : return setResult[6];
		case "總和大小" : return setResult[7];
		case "總和單雙" : return setResult[8];
		case "總和尾數大小" : return setResult[9];
		case "家禽野兽" : return setResult[10];
	}
}





