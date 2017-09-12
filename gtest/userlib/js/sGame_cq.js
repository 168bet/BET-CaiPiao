var win = window.parent.document;
var _endtime, _opentime, _refreshtime, _openNumber, _lock=false;
var setResultcq = new Array();
(function(){
	var _hiden, _endtime, _opentime, _refreshtime, _openNumber, _lock=false;			
	$(function(){
		//$("#dp").attr("action","./inc/DataProcessingcq.php?idt="+encodeURI($("#tys").html()));
		_hiden = $("#hiden",win).val();
		_hiden = _hiden.replace("g","");
		loadGameInfo(false);
		loadDayInfo();
		setOpnumberTirem(); 
		$('#firstball', win).find('th').bind('click',
		function() {
			getResult(this, $('#firstball', win))
		});
		$('#submit_top,#submit',win).bind('click',function(){submitforms(this)}); 
	});
	
	function loadGameInfo(bool){
		var number = $("#number",win);
		var sy = $("#sy",win);
		 
		$.post("/ajax/cqJson.php", { typeid : 1, mid : _hiden}, function(data){
																		 
			_Number (data.number, data.ballArr);
			openNumberCount(data, bool);
			sy.html(data.winMoney);
		}, "json");
	}
	
	function loadDayInfo(){
		$.post("/ajax/cqJson.php", { typeid : 2, mid : _hiden}, function(data){
			openNumber(data.Phases);
			opentimes(data.openTime);
			endtimes(data.endTime);
			refreshTimes(data.refreshTime);
			loadodds(data.oddslist, data.endTime, data.Phases);
			loadinput(data.endTime, _hiden);
		}, "json");
	}
	
	function loadinput(endtime, id){
		var id = $("td.amount", win);
		id.each(function() {
			if ($(this).attr("scope")!=null && $(this).attr("scope") != "") { 
				var tt = $(this).attr("scope").replace('_','m').replace('t','Ball_');
				if (endtime > 1) $(this).html('<input class="amount-input" type="text" maxlength="9" name="' + tt + '" />');
				 
			}
		}); 
	}
	
	function loadodds(oddslist, endtime, number){
		var $hid;
		switch(_hiden){
			case "1":$hid="a";break;
			case "2":$hid="b";break;
			case "3":$hid="c";break;
			case "4":$hid="d";break;
			case "5":$hid="e";break;
			}
		var a = [$hid,"f","g","h","i"];
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
	
	function openNumber(numberId){
		$("#o",win).html(numberId);
	}
	
	function opentimes(opentime){
		var openTime = $("#endTimes",win);
		_opentime = opentime;
		if (_opentime >1)
			openTime.html(settime(_opentime));
		var interval = setInterval(function(){
			if (_opentime <= 1) {
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
	
	function endtimes(endtime){ 
		var endTime = $("#endTime",win);
		_endtime = endtime;
		if (_endtime >1)
			endTime.html(settime(_endtime));
		var interval = setInterval(function(){
				if (_endtime<10&&_endtime>0){ 
					$("#look",win).html("<embed width=\"0\" height=\"0\" src=\"js/d.swf\" type=\"application/x-shockwave-flash\" hidden=\"true\" />");	 
				}	
			if (_endtime <= 1) {
				clearInterval(interval);
				endTime.html("00:00");
				loadodds(null, endtime, null);
				loadinput(-1, _hiden);
				return false;
			}
			_endtime--;
			endTime.html(settime(_endtime));
		}, 1000);
	}
	
	function refreshTimes(refreshtime){
		_refreshtime = refreshtime;
		var refreshTime = $("#endTimea",win);
		refreshTime.html(_refreshtime);
		var interval = setInterval(function(){
			if (_refreshtime <= 1) {
				refreshTime.html("加載中...");
				clearInterval(interval);
				$.post("/ajax/cqJson.php", {typeid : 2, mid : _hiden}, function(data){
					if (_lock == true){
						endtimes(data.endTime);
						opentimes(data.openTime);
						loadinput(data.endTime, _hiden);
						 openNumber(data.Phases);
						 setOpnumberTirem();
						_lock = false;
					}
					 _endtime =data.endTime;
					 _opentime =data.openTime;
					 _refreshtime =data.refreshTime;
					 loadodds(data.oddslist, _endtime, data.Phases);
					 refreshTimes(_refreshtime);
				}, "json");
				return false;
			}
			_refreshtime--;
			refreshTime.html(_refreshtime);
		}, 1000);
	}
	
	function setOpnumberTirem(){
		var opnumber = $("#number",win).html();
		var nownumer = $("#o",win).html();
		if (opnumber != ""){
			var _nownumber = parseInt(nownumer);
			var sum = _nownumber -  parseInt(opnumber);
			if (sum == 2 || sum == 882) {
				var interval = setInterval(function(){
					$.post("/ajax/cqJson.php", {typeid : 3}, function(data){
						var a = _nownumber - parseInt(data);
						if (a == 1 || a == 881){
							clearInterval(interval);
							loadGameInfo(true);
							return false;
						}
					}, "text");
				}, 2000);
			}
		} else {
			setTimeout(setOpnumberTirem, 1000);
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
		for (var i in row.row1){ 
			rowHtml1.push("<td><span class='red fontweight'>"+row.row1[i]+"</span></td>");
		}
		 
		$("#su",win).html(rowHtml1.join(''));
		 
		for (var k in row.row2){
			rowHtml2.push(row.row2[k]);
		}
		$("#z_cl",win).html(rowHtml2.join(''));
		$(".z_cl:even",win).addClass("hhg");
		if (row.row8 != ""){
			for (var key in row.row8){
				rowHtml3.push("<tr>" + "<td class=\"cl_1 inner_text\">" + key + "</td>" + "<td class=\"align-c red\" style=\"width:33%;\">" + row.row8[key] + "期</td>" + "</tr>");
			}
			$("#cl",win).html('<tbody> <tr>  <th colspan="2">两面长龙排行</th></tr></tbody><tbody id="changlong">' + rowHtml3.join("") + "</tbody>");
		}
		if (bool == true) { 
			$("#look",win).html("<embed width=\"0\" height=\"0\" src=\"js/c.swf\" type=\"application/x-shockwave-flash\" hidden=\"true\" />");
		} 
		setResultcq[0] = row.row2;
		setResultcq[1] = row.row3;
		setResultcq[2] = row.row4;
		setResultcq[3] = row.row5;
		setResultcq[4] = row.row6;
		setResultcq[5] = row.row7;
		loadResult();
	}
	
	function loadResult(){
		$.post("../ajax/loadResult.php", { gameType : "cq"}, function(data){ 
			$('#history').html(data);														  
		})	
	}


	function settime(time){
		var MinutesRound = Math.floor(time / 60);
		var SecondsRound = Math.round(time - (60 * MinutesRound));
		var Minutes = MinutesRound.toString().length <= 1 ? "0"+MinutesRound : MinutesRound;
		var Seconds = SecondsRound.toString().length <= 1 ? "0"+SecondsRound : SecondsRound;
		var strtime = Minutes + ":" + Seconds;
		return strtime;
	}
})();

function getResult(sender, element){
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
	if (str == "第一球" || str == "第二球" || str == "第三球" || str == "第四球" || str == "第五球")
		return setResultcq[0];
	switch (str){
		case "大小" : return setResultcq[1];
		case "單雙" : return setResultcq[2];
		case "總和大小" : return setResultcq[3];
		case "總和單雙" : return setResultcq[4];
		case "龍虎和" : return setResultcq[5];
	}
}

function digitOnly ($this) {
	var n = $($this);
	var r = /^\+?[1-9][0-9]*$/;
	if (!r.test(n.val())) {
		n.val("");
	}
}

function getHtml($obj){
	 
	var input = $obj.find('input'); 
	var ss=$(input).attr("name").split("m"); 
	var s = nameformat(ss); 
	s[2] = $("td[scope=" + s[2] + "]", win).html();
	if (s[0] == "總和、龍虎") n = '<span class="ks_ball_1">'+s[1] + "</span> <span class='ks_art'>@</span> <span class='ks_peilv'>" + s[2] + "</span> <span class='ks_x'>x</span> ";
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
	var sArray = nameformat2($('input[name=kuashuorder_next]',win).attr('id').replace('JL_','').split('m')) + "," + money + "|";
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
		ss=$(objArr[i]).attr("abbr").replace('_','m').replace('t','Ball_').split("m"); 
		ss2 = nameformat2(ss);
		sArray += ss2+","+money+"|"; 
		s = nameformat(ss);
		s[2] = $("td[scope=" + s[2] + "]", win).html();
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
		$.post("../ajax/Default.ajax.php", { typeid : "sessionId"}, function(){});
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
				
				s[2] = $("td[scope=" + s[2] + "]", win).html();
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



