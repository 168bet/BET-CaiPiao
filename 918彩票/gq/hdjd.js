var XHC={};

//公用弹出层和加载层
var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);
	} else {
		$('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
		$('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
		$('#mask').show();
	}
};
var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};


XHC.ZLK=(function(){
	var init=function(){
		bindEvent();
		init_jf_jd();
	};
	
	//初始化金豆积分
	var init_jf_jd=function(  ){
		//账户信息
			$.ajax({
				url:"/grounder/goldenbeanaccount.go?flag=0&qtype=3",
				dataType:'xml',
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					
					
					if(code==0){//查询成功
						var r = R.find("row");
						var balance = r.attr("balance");//金豆账户余额
						var isqd = r.attr("isqd");
						var sqdcs = r.attr("sqdcs");//连续签到次数

						if( isqd==0 ){
						if(sqdcs<2){
							$("#text").html('今日可领<em class="red">100</em>金豆');
						}else if(sqdcs==2){
							$("#text").html('今日可领<em class="red">100+300</em>金豆');
						}else if(sqdcs>=3 && sqdcs<6){
							$("#text").html('今日可领<em class="red">100</em>金豆');
						}else if(sqdcs==6){
							$("#text").html('今日可领<em class="red">100+700</em>金豆');
						}else{
							$("#text").html('今日可领<em class="red">100</em>金豆');
						}
						}else if(isqd==1 || isqd==2){
						if(sqdcs==2 || sqdcs==1){
							$("#text").html('已领<em class="red">'+sqdcs+'</em>天,再领<em class="red">'+(3-sqdcs)+'</em>天加送<em class="red">300</em>金豆');
						}else if(sqdcs>=3 && sqdcs<7){
							$("#text").html('已领<em class="red">'+sqdcs+'</em>天,再领<em class="red">'+(7-sqdcs)+'</em>天加送<em class="red">500</em>金豆');
						}else if(sqdcs==7 || sqdcs==0){
							$("#text").html('今日已领取<em class="red">100+700</em>金豆');
						}							
						}
					
							
					
						if(isqd==1 || isqd==2){
							$('.qiandao').html("已领取")
						}else{
							
						}
						var point = r.attr("point");//积分						
					
						$("#jfye").html(point);
						$("#jdye").html(balance);
					
					}else if(code==1){
						window.location.href="login.html";
					}else{
						alert(desc)
					}
					
				}
			})
		
	};
	
	var bindEvent=function(){
		//签到
		$(".qiandao").bind("click",function(){
			sign();
		});
		
		//积分切换
		$("#qhtab li").bind("click",function(){
			var v = $(this).html();
			v=v=="全部兑换"?$("#jfye").html():v;
			$(this).addClass("cur").siblings().removeClass("cur")
			$("#integral").val(v);
		});
		
		//兑换积分
		$("#exchange_tab").bind("click",function(){
			var v = $("#integral").val();
			var reg = /^[0-9]*$/;
			if(!reg.test(v)){
				alert("请输入积分");
				return;
			}
			if(v<1){
				alert("至少输入1个积分");
				return;
			}
			exchange();
		});
		
		$("#integral").focus(function(){
			var v = $(this).val();
			if(v==this.defaultValue){
				$(this).val("");
			}
		});
		
		$("#integral").blur(function(){
			var v = $(this).val();
			if(!v){
				$(this).val(this.defaultValue);
			}
		});
		
		$("#integral").keyup(function(){
			var v = parseInt($(this).val());
			if(v>=100000){
				$(this).val(99999);
			}
		})
	};
	//签到
	var sign = function(){
		$.ajax({
			url:"/grounder/goldenbeanaccount.go?flag=1&utype=0&qtype=0",
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){
					var row = R.find("row");
					var balance = row.attr("balance");//账户余额
					var daward = row.attr("daward");//当日盈利
					var taward = row.attr("taward");//总盈利
					var dpm = row.attr("dpm");//当日排名
					var tpm = row.attr("tpm");//总排行
					var isqd = row.attr("isqd");//是否签到
					$('.qiandao').html("已领取");
					alert("恭喜您，领取成功！");
					init_jf_jd();
				}else{
					alert(desc);
				}
			}
		});
	};
	//积分兑换
	var exchange=function(){
		var usepoint = $("#integral").val();
		$.ajax({
			url:"/grounder/goldenbeanaccount.go?flag=1&utype=1&usepoint="+usepoint+"&qtype=0",
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){
					var row = R.find("row");
					var balance = row.attr("balance");//账户余额
					var daward = row.attr("daward");//当日盈利
					var taward = row.attr("taward");//总盈利
					var dpm = row.attr("dpm");//当日排名
					var tpm = row.attr("tpm");//总排行
					var isqd = row.attr("isqd");//是否签到
					
					$("#integral").val("");
					$("#qhtab li").removeClass("cur")
					alert(desc)
					init_jf_jd();
				}else{
					alert(desc);
				}
			}
		})
	};
	return {
		init:init
	}
})();

$(function(){
	XHC.ZLK.init();
})