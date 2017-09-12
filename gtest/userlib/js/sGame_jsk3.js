var win = window.parent.document;
var setResultcq = new Array();
var   _endtime, _opentime, _refreshtime, _openNumber, _lock=false;		
(function(){ 
	$(function(){
		//$("#dp").attr("action","./inc/DataProcessingjsk3.php?idt="+encodeURI($("#tys").html())); 
		loadGameInfo(false);
		loadDayInfo();
		getnum();
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
		$.post("/ajax/jsk3Json.php", { typeid : 1}, function(data){ 
			_Number (data.number, data.ballArr);
			//openNumberCount(data, bool);
			sy.html(data.winMoney);
		}, "json");
	}
	
	function loadDayInfo(){  
		$.post("/ajax/jsk3Json.php", { typeid : 2}, function(data){
			openNumber(data.Phases);
			opentimes(data.openTime);
			endtimes(data.endTime);
			refreshTimes(data.refreshTime);
			loadodds(data.oddslist, data.endTime, data.Phases);
			loadinput(data.endTime);
		}, "json");
	}
	
	function loadinput(endtime){
		var id = $("td.amount", win);
		id.each(function() {
			if ($(this).attr("scope") != "") {
				var tt = $(this).attr("scope").replace('N','M'); 
				if (endtime > 1) $(this).html('<input class="amount-input" type="text" maxlength="9" name="' + tt  + '" />');
				 
			}
		}); 
	}
	
	function loadodds(oddslist, endtime, number){
		 

		var a = ["a","b","c","d","e"];
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
					loadinput(-1);
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
				$.post("/ajax/jsk3Json.php", {typeid : 2}, function(data){
					if (_lock == true){
						endtimes(data.endTime);
						opentimes(data.openTime);
						loadinput(data.endTime);
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
	
	function setOpnumberTirem(){ 	getnum();
		var opnumber = $("#number",win).html();
		var nownumer = $("#o",win).html();
		if (opnumber != ""){
			var _nownumber = parseInt(nownumer);
			var sum = _nownumber -  parseInt(opnumber);
			if (sum == 2 || sum == 882) {
				var interval = setInterval(function(){
					$.post("/ajax/jsk3Json.php", {typeid : 3}, function(data){
						var a = _nownumber - parseInt(data);
						if (a == 1 || a == 881){
							clearInterval(interval);
							loadGameInfo(true);
								getnum();
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
		var idArr = ["#a","#b","#c"];
		$("#number",win).html(number); 
		 
		$('span.number',win).css('visibility','visible');
		for (var i = 0; i < ballArr.length; i++) {
			Clss = "num" + ballArr[i];
			$(idArr[i], win).attr('class','number');
		    $(idArr[i], win).addClass(Clss);
		}
	}
	
	
	
	function getnum(){
	
$.post("/ajax/jsk3Json.php", {typeid : 4}, function(data){
		getnumlist(data);//
	}, "json");

}

function getnumlist(data){

if (data.number != ""){
		var row_1Html = new Array();
		for (var key in data.number){
			row_1Html.push("<tr bgcolor=\"#fff\" height=\"22\"><td style=\" background:#ffffff; text-align:center\">"+data.number[key]+"期</td><td style=\"background:#ffffff;  width:101px;   text-align:center\">"+data.ballArr[key]+" </td><td style=\"background:#ffffff;    text-align:center\">"+data.ball_count[key]+" </td><td style=\"background:#ffffff;   text-align:center\">"+data.numberList[key]+" </td></tr>");
		}
		var cHtml = '<tr class="t_list_caption"><th colspan="4">近期開獎結果</th></tr>';
		$("#cl",win).html(cHtml+row_1Html.join(""));
	}
}
	
	function openNumberCount(row, bool){   
		var rowHtml3 = new Array();   
		if (row.row1 != ""){
			for (var key in row.row1){
				rowHtml3.push(row.row1[key]);
			}
			var cHtml = '<tbody><tr><th colspan="6">近期开奖结果</th></tr> </tbody>';
			$("#cl",win).html(cHtml+rowHtml3.join(""));
		}
		if (bool == true) { 
			$("#look",win).html("<embed width=\"0\" height=\"0\" src=\"js/c.swf\" type=\"application/x-shockwave-flash\" hidden=\"true\" />"); 
		}
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


 

function digitOnly ($this) {
	var n = $($this);
	var r = /^\+?[1-9][0-9]*$/;
	if (!r.test(n.val())) {
		n.val("");
	}
}


function getHtml($obj){
	var input = $obj.find('input'); 
	var s = input.attr("name").split("M") ;
	 
	z = nameformatcq(s[0]);   
	m =  nameformatcq1(s[1]);  
	o = $("td[scope="+s[1]+"]",win).html();  
	 
	 n =  '<span class="ks_ball_1">' + z + "</span>" + '<span class="ks_ball_2">' + m + "</span> <span class='ks_art'>@</span>  <span class='ks_peilv'>" + o + "</span> <span class='ks_x'>x</span> ";
	var nm = 'JL_'+input.attr("name");
	$('#kuashuorder',win).remove();
	$('#'+nm,win).remove();
	return n+ '<span class="ks_input"><input id="kuashuorder" type="text" style="width:60px" maxlength="9"></input><input name="kuashuorder_next" type=hidden id="'+nm+'" /></span>';
}

function kuaisuXiaZhu(){ 
	$.post("../ajax/Default.ajax_pk3.php", {
			typeid: "sessionId"
		},
		function() {}); 
	var money = $('#kuashuorder',win).val();
	if(parent.yzOrderMoney( money )==false){
		return false;
	}
	money=parseInt(money);
	var s =$('input[name=kuashuorder_next]',win).attr('id').replace('JL_','').split('M');
	
	z = nameformatcq(s[0]);   
	m =  nameformatcq1(s[1]);  
	var sArray = z + ";" + m + ";" + o + ";" + money + "|";
	sArray = sArray.replace(',',';');
	doOK(sArray);
	return true;
}

function kuaijie(sender){
	 $.post("../ajax/Default.ajax_pk3.php", {
			typeid: "sessionId"
		},
		function() {}); 
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
		var s = $(objArr[i]).attr("abbr").split("N") ;
		z = nameformatcq(s[0]);   
		m =  nameformatcq1(s[1]);  
		o = $("td[scope="+s[1]+"]",win).html();  
		n = "<td class='xz_ball_1'><span class='xz_ball_11'>" + z + "</span> <span class='xz_ball_12'>"+ m +"</span></td> ";  
		n+="<td class='xz_peilv'>"+o+"</td>";
		n+="<td class='xz_money'>"+money+"</td>";
		names.push("<tr>"+n+"</tr>");
		sArray += z + ";" + m +";"+o+";"+money+"|"; 
		countmoney+=money;
		count++;
	}
	names.push(parent.getB(count,countmoney)); 
	parent.doReset();
	parent.showQueRen(names.join(""),doOK,sArray); 
}

function submitforms(sender){
	$.post("../ajax/Default.ajax_pk3.php", {
			typeid: "sessionId"
		},
		function() {}); 
	if( $('body',win).attr('nav')=='odds' ){
		kuaijie(sender);
	}else{
		$.post("../ajax/Default.ajax_pk3.php", {
			typeid: "sessionId"
		},
		function() {}); 
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
				var s =$(this).attr("name").split("M");
				z = nameformatcq(s[0]);   
				m =  nameformatcq1(s[1]);  
				o = $("td[scope="+s[1]+"]",win).html();   
				n = "<td class='xz_ball_1'><span class='xz_ball_11'>" + z + "</span> <span class='xz_ball_12'>"+ m +"</span></td> ";  
				n+="<td class='xz_peilv'>"+o+"</td>";
				n+="<td class='xz_money'>"+value+"</td>";
				names.push("<tr>"+n+"</tr>");
				sArray += z + ";" + m + ";" + o +";"+value +"|"; 
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
	 
	$('form[name=postform]',win).attr('action','./inc/DataProcessingjsk3.php');
	$('form[name=postform]',win).html(s_type);
	$('form[name=postform]',win)[0].submit();
	parent.showXZLoading();
	return true;
}

 
function nameformatcq(str){
	switch(str){ 
		case "Ball_1" : return "三軍";
		case "Ball_2" : return "圍骰、全骰";
		case "Ball_3" : return "點數";
		case "Ball_4" : return "長牌";
		case "Ball_5" : return "短牌"; 
	}
}
function nameformatcq1(str){
	 
	var Arr = str.split('h');
	var ch = Arr[0];
	var xh = Arr[1];
	switch(ch){
		case 'a':
			if(xh==7) return "大";
			if(xh==8) return "小";
			return xh;
		case 'b':
			if(xh==7) return "全骰";	
			return xh;
		case 'c':
			$arr = new Array(4,5,6,7,8,9,10,11,12,13,14,15,16,17);
			return $arr[ xh-1 ]+'點';
		case 'd':
			$arr=new Array(12,13,14,15,16,23,24,25,26,34,35,36,45,46,56); 
			return $arr[xh-1].toString().substring(0,1)+'+'+$arr[xh-1]%10;
		case 'e':
			$arr=new Array(1,2,3,4,5,6);
			return $arr[xh-1]+'+'+$arr[xh-1]; 
	}
}