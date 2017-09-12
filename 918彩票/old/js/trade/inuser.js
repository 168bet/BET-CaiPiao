/*
* Author: weige
* Date : 2014-04-28
*/ 
var lotid = decodeURIComponent(CP.Util.getParaHash("lotid"));
var projid = decodeURIComponent(CP.Util.getParaHash("projid"));
var ititle = decodeURIComponent(CP.Util.getParaHash("title"));
var page = 0;
var cacheHTML = "";
var zys = 1;
var chedan = '1';
$(function(){
	if (lotid == "" || projid == "") {
		if (history.length == 0) {
			window.opener = "";
			window.close();
		} else {
			history.go(-1);
		}
		return false;
	}
	chedan = decodeURIComponent(CP.Util.getParaHash('chedan'));
	if(ititle == 'partake'){
		$('#iTitle').html('参与用户');
		LoadList();
		$("#moresult1").bind("click",function () {
				$("#loading").show();
				$("#moresult1").hide();
				LoadList();
		});
	}else if(ititle == 'myRecord'){
		$('#iTitle').html('我的认购');
		$("#loading").show();
		myLoadList();
	}
});
function LoadList(){
	
	page++;
	if(page>zys){
		$("#loading").hide();
		return false;
	}
	var postData = "hid="+projid+"&gid="+lotid+"&state="+chedan+"&pn="+page+"&ps=20";
	$.ajax({
		url: $_trade.url.jlist,
		type: "POST",
		data: postData,
		success: function(data) {
			var R = $(data).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			var count = R.find("count");
			var tp = count.attr("tp");
			var pn = count.attr("pn");
			if (code == "0") {
				var r = R.find("row");
				var c = R.find('count');
				var rs = c.attr('rc');
				zys = c.attr('tp');
				var html = '';
				if(page == 1){
					html = '<li><span class="inFirst">用户('+rs+')</span><span>认购金额(元)</span><span style="border-right:none;width:26%">购买时间</span></li>';
				}
				r.each(function(a,b){
					var nickid = $(this).attr("nickid");//用户名 
					var bmoney = $(this).attr("bmoney");//认购金额
					var buydate = $(this).attr("buydate");//认购时间
					html +='<li><span class="inFirst">'+nickid+'</span><span class="red">'+bmoney+'</span><span class="inLast"><em>'+buydate.substring(2,10)+'</em><cite>'+buydate.substring(11,19)+'</cite></span></li>';
				});
				if($("#inUser").html()=="")cacheHTML="";
				cacheHTML += html;
				$('.inUser').html(cacheHTML);
				if(tp==pn){
					
	    			$("#loading").hide();
	    			$("#moresult1").hide();
				}else{
					$("#loading").hide();
	    			$("#moresult1").show();
				}
    			
			}else{
				$("#loading").hide();
    			$("#moresult1").hide();
				D.alert(desc);
				return;
			}
		},
	});
}
function myLoadList(){
	var data = '';
	data = "gid=" + encodeURIComponent(lotid) + "&hid=" + encodeURIComponent(projid) + "&state="+chedan+"&rnd=" + Math.random();
	$.ajax({
		url: $_trade.url.pinfo,
		type: "POST",
		dataType : "xml",
		data: data,
		success: function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			if (code == "0") {
				var M = R.find("myjoins");//发起人的的认购记录
				var m = M.find("myjoin");
				
				var html = '<li><span>认购金额(元)</span><span>奖金(元)</span><span style="border-right:none">购买时间</span></li>';
				var n = m.length;
				if(n == 0){
					$("#moresult1").hide();
					html +='<li class="yellow" style="text-align:center;border-bottom:none;">亲!木有你的认购记录耶</li>';
				}else{
					m.each(function(a,b){
						var buydate = $(this).attr("buydate");// 认购时间
						var bmoney = $(this).attr("bmoney");// 认购金额
//						var cancel = $(this).attr("cancel");// 是否撤销(0 未撤销 1 本人撤销 2 系统撤销）
						var award = $(this).attr("award");// 计奖标志（0 未计奖 1 已计奖),
						var rmoney = $(this).attr("rmoney");// 认购派奖金额
						var rpmoney = $(this).attr("rpmoney");//红包认购金额
						if(rpmoney == '' || rpmoney == '0'){
							rpmoney = '0';
						}
						var money = '';
						if(award == 0){
							money = '-';
						}else if(award == 1){
							if(rmoney > 0){
								money = rmoney;
							}else{
								money = '-';
							}
						}
						html +='<li style="'+((a+1) == n? "border-bottom:none;" : "")+'"><span class="yellow">'+bmoney+(rpmoney == '0'? "":"(含红包"+rpmoney+"元)" )+'</span><span class="yellow">'+rmoney+'</span><span class="inLast"><em>'+buydate.substring(2,10)+'</em><cite>'+buydate.substring(11,19)+'</cite></span></li>';
					});
				}
				$('.inUser').html(html);
    			$("#loading").hide();
    			$("#moresult1").hide();
			}else{
				$("#loading").hide();
    			$("#moresult1").hide();
				D.alert(desc);
				return;
			}
		},
	});
}
function goTo(){
	history.go(-1);
 }