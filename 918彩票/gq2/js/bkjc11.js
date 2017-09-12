var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		
		confirm_login:function(fn, tag1, tag2, fn1){
			tag1 && $('#popup2 div a:eq(0)').html(tag1) || $('#popup2 div a:eq(0)').html('取消');
			tag2 && $('#popup2 div a:eq(1)').html(tag2) || $('#popup2 div a:eq(1)').html('确定');
			$('.zhezhao, #popup2').show();
			$('#popup2 div a:eq(0)').off().bind('click',function(){//登录
				if(typeof(fn1) == "function"){fn1();}
				
				$('.zhezhao, #popup2').hide();
			});
			$('#popup2 div a:eq(1)').off().bind('click',function(){//注册
				if(typeof(fn) == "function"){fn();}
				
				$('.zhezhao, #popup2').hide();
			});
			
			$("#popup2 strong").bind("click",function(){
				$('.zhezhao, #popup2').hide();
			})
		}
};
var CP={}
CP.MobileVer = (function ($) {
	var u = navigator.userAgent;
	var obj = {
		android: false,
		ios: false,
		ios7: false,
		ipad: false,
		wp:false
	};
	obj.android = (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1);
	obj.ios = (!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/));
	obj.ipad = u.indexOf('iPad') > -1;
	obj.wp = u.indexOf("Windows Phone") > -1;
	if (obj.ios) {
		if (u.indexOf('7_') > -1) {
			obj.ios7 = true;
		}
	}
	return obj;
})();
String.prototype.getParam = function(n){
	var r = new RegExp("[\?\&]"+n+"=([^&?]*)(\\s||$)", "gi");
	var r1=new RegExp(n+"=","gi");
	var m=this.match(r);
	if(m==null){
		return "";
	}else{
		return typeof(m[0].split(r1)[1])=='undefined'?'':decodeURIComponent(m[0].split(r1)[1]);
	}
};

/***
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
***/
ZQ.JCZQ=(function(){
	
	var toLogin = function(){
		D.confirm_login(function(){
			var url='register.html';
			if(CP.MobileVer.android){//android
				try {
					window.caiyiandroid.clickAndroid(4, '');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
				try {
					alert("IOStoLogin")
					WebViewJavascriptBridge.callHandler('clickIosRegister');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.wp){
				try {
					window.external.notify('{"code":"22"}');
				} catch (e){
					window.location.href = url;
				}
			}else{//4g
				window.location.href = url;
			}
		},'登录','注册',function(){
			var url='login.html';
			if(CP.MobileVer.android){//android
				try {
					window.caiyiandroid.clickAndroid(3, '');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
				try {
					WebViewJavascriptBridge.callHandler('clickIosLogin');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.wp){
				try {
					window.external.notify('{"code":"21"}');
				} catch (e){
					window.location.href = url;
				}
			}else{//4g
				window.location.href = url;
			}
		});
	}
	
	
	
	//判断用户是否登录
	var tokenLogin=function(){
		var allcookies = document.cookie;
		if(allcookies.indexOf('TOKEN')!='-1'){
			//alert('加载中..','load');
			setTimeout(function(){
				allcookies = allcookies.split('&');
				var token = '',appid = '';
				$.each(allcookies,function(index, val){
					if(val.indexOf('TOKEN=')>=0){
						token = val.split('TOKEN=')[1];
					}
					if(val.indexOf('APPID=')>=0){
						appid = val.split('APPID=')[1];
					}
				});
				alert(appid)
				$.ajax({
					url:'/user/swaplogin.go',
					data:{
						logintype:'1',
						accesstoken:token,
						appid:appid
					},
					cache:false,
					type:'POST',
					success:function(xml){
						$.ajax({
							url:'/user/query.go?flag=6',
							type:'POST',
							dataType:'xml',
							success: function(xml) {
								var R = $(xml).find('Resp');
								var c = R.attr('code');
								alert(c)
								if(c == '0'){//已登录 
									alert(1)
									remove_alert();
								}else{//未登录
									alert(0)
									toLogin()
								}
								o.against();
							}
						});
					}
				});
			},.3e3);
		}else{
			toLogin();
		}
	};
	
	
	
	
	//查询所需参数
	var Queryparam={
			"mtype":"4",//终端类型    不能为空    安卓 1，iOS 2，WP 3，触屏 4
			"appversion":"",//客户端版本号   只有触屏可以为空
			"flag":"0",//操作类型标识  0-查询类标识   1-增删改类标识
			"qtype":"0",//查询类操作 标识   flag=0时不可为空
			"phtype":"",//排行榜类型  qtype=4时不可为空
			"utype":"",//增删改类操作标识 flag=1时不可为空
			"usepoint":"",//utype=1时不可为空
			"psize":"10",//每页显示记录数,可为空
			"pnum":"1",//当前页数,可为空
			"date1":"",//查询开始日期,可为空
			"date2":"",//查询截止日期,可为空
			"mid":"",//场次id  phtype=s时不可为空
			"ddstatus":"",//竞猜记录类型 可为空  1-有效竞猜   2-无效竞猜    空-全部竞猜
			"cgameid":""//彩种类型 可为空   1-足球  2-篮球   空-不区分彩种
	};
	
	//是否签到
	var is_qd = function(){
		Queryparam.flag=0;
		Queryparam.qtype=3;
		$.ajax({
			url:'/grounder/goldenbeanaccount.go',
			data:Queryparam,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				if(code==0){
					var row = R.find("row");
					var balance = row.attr("balance");//账户余额
					var nickid = row.attr("nickid");//用户名
					var isqd = row.attr("isqd");//是否签到 0-未签到 1-签到
					var sqdcs = row.attr("sqdcs");//是否签到 0-未签到 1-签到
					
					if(isqd==0){
						if(sqdcs==2){
							$("#lqjd").html("300金豆")
						}else if(sqdcs==6){
							$("#lqjd").html("500金豆")
						}else{
							$("#lqjd").html("100金豆")
						}
						
						$(".popup").show();
						$(".zhezhao").show();
					}else{
						//$("#sign").html("已签到");
					}
					
					$("#user_account").html(nickid+'<em>('+balance+'金豆)</em>');
				}else{
					//alert(desc);
				}
			}
		})

	}
	
	//事件
	var bindEvent = function(){
		$("#get_jd").bind("click",function(){
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
						alert("恭喜您，领取成功！");
						$(".popup").hide();
						$(".zhezhao").hide();
						//account_info();
					}else{
						alert(desc);
					}
				}
			});
		})
		
		$("#close").bind("click",function(){
			$(".popup").hide();
			$(".zhezhao").hide();
		})
	}
	
	//参与人数
	var read_num=function(){
		$.ajax({
			url:"/grounder/fgoldenbeanaccount.go?flag=0&qtype=6",
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){
					var cyrs = R.find("cyrs");
					var rs = cyrs.attr("cyrs");//参与人数
					$("#cyrs").html(rs);
					//account_info();
				}else{
					//alert(desc);
				}
			}
		});
	}
	var init = function(){
		
		var from = location.search.getParam("from");
		var appversion = location.search.getParam("appversion");
		appversion=appversion?parseInt(appversion.replace(/\./g,'')):"";
		
		if(from &&  (from=="android" || from=="ANDROID")){
			$("#back").hide();
			tokenLogin();
		}else if(from &&  (from=="wp" || from=="WP")){
			$("#back").hide();
			tokenLogin();
		}else if(from && (from=="IOS" || from=="ios")){
			if(appversion){
				//alert(appversion)
				if(appversion>325){
					tokenLogin();
					
				}else{
					$.ajax({
				        url: "/user/mchklogin.go",
				        type: "POST", 
				        success:function (data){
				     	    var R = $(data).find("Resp");
				 			var code = R.attr("code");
				 			if (code == "10001") {//已登录
				 				//bind_input();
				 			}else{
				 				D.confirm_login(function(){
				 					WebViewJavascriptBridge.callHandler('clickIosRegister');
				 				},'登录','注册',function(){
				 					WebViewJavascriptBridge.callHandler('clickIosLogin');
				 				});
				 			}
				        }
					});
				}
			}
		}else{
			$.ajax({
		        url: "/user/mchklogin.go",
		        type: "POST", 
		        success:function (data){
		     	    var R = $(data).find("Resp");
		 			var code = R.attr("code");
		 			if (code == "10001") {//已登录
		 				//bind_input();
		 			}else{
		 				D.confirm_login(function(){
		 					var url='register.html';
		 					//4g
		 				    window.location.href = url;
		 					
		 				},'登录','注册',function(){
		 					var url='login.html';
		 					window.location.href = url;
		 				});
		 			}
		        }
			});
		}
		is_qd();
		read_num();
		bindEvent();
	}


	
	
	
	return {
		init:init
	}
})()


$(function(){
	ZQ.JCZQ.init()
});