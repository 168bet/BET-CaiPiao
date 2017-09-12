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

var jfdhjl=0;//金豆充值今日是否奖励

XHC.ZLK=(function(){
	var init=function(){
		remove_header()
		bindEvent();
		init_jf_jd();
		czjli();
	};
	
	//初始化金豆积分
	var init_jf_jd=function(  ){//查积分
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

						var point = r.attr("point");//积分						
					
						$("#jfye").html(point);
					
					}else if(code==1){
						window.location.href="login.html";
					}else{
						alert(desc)
					}
					
				}
			})
		
	};
	
	
	var czjli=function(){//查询是否奖励
		$.ajax({
			url:"/grounder/fgoldenbeanaccount.go?flag=0&qtype=3",
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				if(code==0){//查询成功
					var r = R.find("row");
					jfdhjl = r.attr("jfdhjl");//金豆充值是否今日已领取  1已领取 0未领取
					
				}
				
				
			}
		})	
		
	}
	
	
	
	var bindEvent=function(){

		
		//积分切换
		$("#qhtab li").bind("click",function(){
			var v = $(this).html();
			v=v=="全部兑换"?$("#jfye").html():v;
			$(this).addClass("cur").siblings().removeClass("cur")
			$("#integral").val(v);
			$("#integral").keyup();
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
			var a = $("#jfye").html();
			v=v>a?a:v;
			
			if(jfdhjl==1 || v<10000){//已领取
				$("#fh").html(v*10);
			}else{//未领取
				if(v>=10000 && v<50000){
					$("#fh").html(v*10+"+5000");
				}else if(v>=50000 && v<=200000){
					$("#fh").html(v*10+"+"+v);
				}else if(v>200000){
					$("#fh").html(v*10+"+200000");
				}
			}
			if(v>=1000000){
				$(this).val(999999);
				if(jfdhjl==1){
					$("#fh").html(9999990);
				}else{
					$("#fh").html(9999990+"+"+200000);		
				}
			}
		})
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

					var point = row.attr("point");//积分
					$("#jfye").html(point);
					
					
					$("#integral").val("");
					$("#qhtab li").removeClass("cur")
					$("#fh").html("0");

					alert(desc)
					czjli();
					//init_jf_jd();
				}else{
					alert(desc);
				}
			}
		})
	};
	var remove_header=function(){
		var arg = localStorage.getItem("from");
		if(arg){
			$(".tzHeader").hide();
		}else{
			$(".tzHeader").show();
		}
	}
	return {
		init:init
	}
})();

$(function(){
	XHC.ZLK.init();
})