var XHC={};
var D={};
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
			$('#popup2 div a:eq(0)').off().bind('click',function(){//取消
				if(typeof(fn1) == "function"){fn1();}
				
				$('.zhezhao, #popup2').hide();
			});
			$('#popup2 div a:eq(1)').off().bind('click',function(){//确定
				if(typeof(fn) == "function"){fn();}
				
				$('.zhezhao, #popup2').hide();
			});
		}
};
var noGame  = '<div style="text-align: center; padding: 50px;">暂无数据</div>';
//公用弹出层和加载层

/***

var win_alert = alert;

window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 3000);
	} else {
		$('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
		$('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
		$('#mask').show();
	}
};

**/
alert("从2月1号起，排行榜暂停奖券奖励");

var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};

var cutStr= function(n){
	   var b=parseInt(n).toString();
	   var len=b.length;
	   if(len<=3){return b;}
	   var r=len%3;
	   return r>0?b.slice(0,r)+","+b.slice(r,len).match(/\d{3}/g).join(","):b.slice(r,len).match(/\d{3}/g).join(",");
	 } 
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



CP.Util={
	pad:function(source, length) {
		var pre = "",
		negative = (source < 0),
		string = String(Math.abs(source));
		if (string.length < length) {
			pre = (new Array(length - string.length + 1)).join('0');
		}
		return (negative ? "-" : "") + pre + string;
	}	
}


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


	var init=function(){
		o.main();
		bind();
		is_qd();
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
		 					var url='../login.html';
		 					window.location.href = url;
		 				});
		 			}
		        }
			});
		}
		
		
	};
	
	
	
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

	

	var from = location.search.getParam("from");
	var appversion = location.search.getParam("appversion");
	appversion=appversion?parseInt(appversion.replace(/\./g,'')):"";
	
	if(from){
		localStorage.setItem("from", from);
	}else{
		//localStorage.setItem("from", "");
	}
	
	
	var remove_header=function(){
		var arg = localStorage.getItem("from");
		if(arg){
			$(".tzHeader").hide();
		}else{
			$(".tzHeader").show();
		}
	}
	//document.cookie="userId=TOKEN"
	//判断用户是否登录

	var tokenLogin=function(){
		var allcookies = document.cookie;
		//alert(allcookies)
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
				$.ajax({
					url:'/user/swaplogin.go',
					data:{
						logintype:'1',
						accesstoken:token,
						appid:appid
					},
					cache:false,
					type:'POST',
					success:function(data){
						var Resp = $(data).find("Resp");
						var code = Resp.attr("code");
						var sc = Resp.attr("desc");
						//alert(code+"---"+sc);
						$.ajax({
							url:'/user/mchklogin.go',
							type:'POST',
							dataType:'xml',
							timeout:3000,
							success: function(xml) {
								var R = $(xml).find('Resp');
								var c = R.attr('code');
								var desc = R.attr("desc")
								//alert(c)
								if(c == '10001'){//已登录 
									remove_alert();
								}else{//未登录
									//location.href='login.html';

									toLogin();
								}
							}
						});
					}
				});
			},.7e3);
		}else{

			toLogin();
		}
	};
	//取签到弹窗状态显示
	var is_qd = function(){
	$.ajax({
		url:'/grounder/fgoldenbeanaccount.go?flag=0&qtype=3',
		dataType:'xml',
		cache:true,
		success: function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			
			var row = R.find("row");
			
			var fbzjcs3 = row.attr("fbzjcs3");
			var fbzjcs10 = row.attr("fbzjcs10");//中奖次数，领取字段
			
			var zjcs3 = row.attr("zjcs3");
			var zjcs10 = row.attr("zjcs10");//中奖次数，领取字段
			
			//足球
			var fbyjdtrjl = row.attr("fbyjdtrjl");//中奖次数，领取字段
			var fbphbpj = row.attr("fbphbpj");//中奖次数，领取字段
			var fbyphbpj = row.attr("fbyphbpj");//中奖次数，领取字段
			var fbyjdtr = row.attr("fbyjdtr");//足球昨日累计竞猜金豆
			
			var fbjdtrjl = row.attr("fbjdtrjl");//足球金豆投入，领取字段
			
			//篮球
			var yjdtrjl = row.attr("yjdtrjl");//中奖次数，领取字段
			var jdtrjl = row.attr("jdtrjl");//中奖次数，领取字段
			var phbpj = row.attr("phbpj");//中奖次数，领取字段
			var yphbpj = row.attr("yphbpj");//中奖次数，领取字段
			var yjdtr = row.attr("yjdtr");//篮球昨日累计竞猜金豆
			
			
			var fbyzjcs3 = row.attr("fbyzjcs3" );
			var fbyzjcs10 = row.attr("fbyzjcs10");
			
			var yzjcs3 = row.attr("yzjcs3");
			var yzjcs10 = row.attr("yzjcs10");
			
			var fbymzcs = row.attr("fbymzcs");
			var ymzcs = row.attr("ymzcs");
			var remainday = row.attr("remainday");//签到失效剩余天数
	
			
			var ctype = row.attr("ctype");//当前用户翻倍卡状态
			if(ctype==0){				
				$("#qdsx").html("购买“翻倍卡”,签到得<em style='color:red'>1000</em>倍金豆");
			}else if(ctype==1||ctype==2){
				$("#qdsx").html('正在使用“签到千倍卡”,<i class="red" >'+remainday+'</i>天后失效。');
			}else if(ctype==3||ctype==4){
				$("#qdsx").html("您购买的“签到翻倍卡”,次日开始生效");

			}

			
				var nickid = row.attr("cnickid");//用户名
				var balance = row.attr("balance");//用户名
				$("#user_account").html(nickid+'<i>('+balance+'金豆)</i>');
				var sqdcs = parseInt(row .attr("sqdcs"));//签到次数
				var isqd = 1;//是否签到 0-未签到 1-签到
									
				sqdcs=(sqdcs>=7&&isqd==0)?0:sqdcs;
				
				var mzcs = row.attr("mzcs");//篮球中奖次数
				var fbmzcs = row.attr("fbmzcs");//足球中奖次数
			
				var fbjdtr = parseInt(row.attr("fbjdtr"));//足球今日累计竞猜金豆3
				var jdtr = parseInt(row.attr("jdtr"));//篮球今日累计竞猜金豆3
				
			if(code==0){
				var jdstr = row.attr("jdstr").split(",");//签到乘以的倍数
				$(".jdtext li:eq(0) span").html("+"+(jdstr[0]==1?100:((parseInt(jdstr[0])*100)/10000+"万")));
				$(".jdtext li:eq(1) span").html("+"+(jdstr[1]==1?150:((parseInt(jdstr[1])*150)/10000+"万")));
				$(".jdtext li:eq(2) span").html("+"+(jdstr[2]==1?200:((parseInt(jdstr[2])*200)/10000+"万")));
				$(".jdtext li:eq(3) span").html("+"+(jdstr[3]==1?250:((parseInt(jdstr[3])*250)/10000+"万")));
				$(".jdtext li:eq(4) span").html("+"+(jdstr[4]==1?300:((parseInt(jdstr[4])*300)/10000+"万")));
				$(".jdtext li:eq(5) span").html("+"+(jdstr[5]==1?350:((parseInt(jdstr[5])*350)/10000+"万")));
				$(".jdtext li:eq(6) span").html("+"+(jdstr[6]==1?400:((parseInt(jdstr[6])*400)/10000+"万")));
				
				$("#ftr_t_jd dl dd:eq(0) cite").html(fbjdtr);
				$("#ftr_y_jd dl dd:eq(0) cite").html(fbyjdtr);
				
				
				$("#ltr_t_jd dl dd:eq(0) cite").html(jdtr);
				$("#ltr_y_jd dl dd:eq(0) cite").html(yjdtr);
				
				//签到送金豆
				if(isqd==0){//未签到
					if(sqdcs<4){
						if(sqdcs==0){
							$(".jdtext ul:eq(0) li:eq(0)").addClass("wqd");
						}else{
							$(".jdtext ul:eq(0) li:lt("+sqdcs+")").addClass("yqd");
							$(".jdtext ul:eq(0) li:eq("+(sqdcs)+")").addClass("wqd");
						}
					}else{
						var temp = sqdcs-4
						$(".jdtext ul:eq(0) li").addClass("yqd");
						if(sqdcs==4){
							$(".jdtext ul:eq(1) li:eq("+temp+")").addClass("wqd")
						}else{
							$(".jdtext ul:eq(1) li:lt("+temp+")").addClass("yqd");
							$(".jdtext ul:eq(1) li:eq("+(temp)+")").addClass("wqd");
						}
						
					}
					$('#jd,#ceng').show();

				}else{
					if(sqdcs<4){
						$(".jdtext ul:eq(0) li:lt("+sqdcs+")").addClass("yqd");
					}else{
						var temp = sqdcs-4
						$(".jdtext ul:eq(0) li").addClass("yqd");
						$(".jdtext ul:eq(1) li:lt("+temp+")").addClass("yqd");
					}
					$("#get_jd").addClass("graybg");
					$("#get_jd").html("已签到");
					$("#get_jd").unbind("click")
				}
				//$("#cyrs").html(new_cyrs);
				//$("#user_account").html(nickid+'<em>('+balance+'金豆)</em>');
				//$("#qdnum").html(sqdcs+"天");
			}else if(code==1){
				//window.location.href="/gq2/login.html";
				}
			}
		})
	
	}
	
	var g={
			qid:"",//期次id
			fps :1000
	};
	
	function diffToString(num, iscn) {
		var unit = [8.64E+7,3.6E+6,6E+4,1E+3,1], date = [], cnDate = [];
		var cn = '\u5929,\u65f6,\u5206,\u79d2,\u6beb\u79d2'.split(',');
		for (var i = 0, l = unit.length; i < l; i++) {
			date[i] = parseInt(num / unit[i]);
			cnDate[i] = date[i] + cn[i];
			num %= unit[i];
		}
		return iscn ? cnDate : date;
	}
	
	
	//江苏快3
	function expect_change_js(now_js, etime,obj){
		this.now_js = now_js.getTime();
		this.js_etime_ = new Date(etime.replace(/-/g , '/'));
		//this.atime_ = new Date(atime.replace(/-/g , '/'));
		clearInterval(this.timer); 
		this.timer_js = setInterval(function(){
			eachClock_js(obj);
		}, g.fps); 
		eachClock_js(obj);
	}
	
	function eachClock_js(obj){
		this.now_js += g.fps;
		var diff_js = this.js_etime_ - this.now_js;
		var msg = '';
		if(diff_js >= 0){
			var timeout = diffToString(diff_js,false);
			msg = timeout[1]+''+timeout[2]+':'+CP.Util.pad(timeout[3],2);
			$(obj).html(msg);
		}else{
			msg = '已截止';
			$(obj).html(msg);
			
			clearInterval(this.timer_js);
			kjTimer_js = setInterval(function(){
				o.js_k3_info();
			}, 5e3);
		}
	}
	
	
	//安徽快3
	function expect_change_ah(now_ah, etime,obj){
		this.now_ah = now_ah.getTime();
		this.ah_etime_ = new Date(etime.replace(/-/g , '/'));
		//this.atime_ = new Date(atime.replace(/-/g , '/'));
		clearInterval(this.timer); 
		this.timer_ah = setInterval(function(){
			eachClock_ah(obj);
		}, g.fps); 
		eachClock_ah(obj);
	}
	
	function eachClock_ah(obj){
		this.now_ah += g.fps;
		var diff_ah = this.ah_etime_ - this.now_ah;
		var msg = '';
		if(diff_ah >= 0){
			var timeout = diffToString(diff_ah,false);
			msg = timeout[1]+''+timeout[2]+':'+CP.Util.pad(timeout[3],2);
			$(obj).html(msg);
		}else{
			msg = '已截止';
			$(obj).html(msg);
			
			clearInterval(this.timer_ah);
			kjTimer_ah = setInterval(function(){
				o.ah_k3_info();
			}, 5e3);
		}
	}
	
	//福彩快3
	function expect_change_fc(now_fc, etime,obj){
		this.now_fc = now_fc.getTime();
		this.fc_etime_ = new Date(etime.replace(/-/g , '/'));
		//this.atime_ = new Date(atime.replace(/-/g , '/'));
		clearInterval(this.timer);
		this.timer_fc = setInterval(function(){
			eachClock_fc(obj);
		}, g.fps); 
		eachClock_fc(obj);
	}
	
	function eachClock_fc(obj){
		this.now_fc += g.fps;
		var diff_fc = this.fc_etime_ - this.now_fc;
		var msg = '';
		if(diff_fc >= 0){
			var timeout = diffToString(diff_fc,false);
			msg = timeout[1]+''+timeout[2]+':'+CP.Util.pad(timeout[3],2);
			$(obj).html(msg);
		}else{
			msg = '已截止';
			$(obj).html(msg);
			
			clearInterval(this.timer_fc);
			kjTimer_fc = setInterval(function(){
				o.fc_k3_info();
			}, 5e3);
		}
	}
	
	var o={
			main:function(){
				this.js_k3_info();
				this.ah_k3_info();
				this.fc_k3_info();
			},
			js_k3_info:function(){//江苏快3
				$.ajax({
					url : '/grounder/kpgoldbeanaccout.go?flag=0&iscurrent=1&qtype=2&cgameid=09',
					type : "POST",
					dataType : "xml",
					success : function(xml) {
						var R = $(xml).find("Resp");
						var row = R.find("row");
						
						var id = row.attr("id");
						var cgameid = row.attr("cgameid");//彩种id
						var cperiodid = row.attr("cperiodid");//期次id
						cperiodid=cperiodid.substr(-3);
						var etime = row.attr("etime");//期次截止时间
						var atime = row.attr("atime");//期次开奖时间
						var kjcodes = row.attr("kjcodes");//开奖号码
						var iscurrent = row.attr("iscurrent");//是否是当前期，为1表示是当前期
						
						var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
						
						$("#cg_type span:eq(2)").html('<label>距'+cperiodid+'期截止还剩  <i></i></label>');
						
						var t = $("#cg_type span:eq(2) i")
						
						expect_change_js(n_,etime,t);
					}
				})
			},
			fc_k3_info:function(){//江苏快3
				$.ajax({
					url : '/grounder/kpgoldbeanaccout.go?flag=0&iscurrent=1&qtype=2&cgameid=08',
					type : "POST",
					dataType : "xml",
					success : function(xml) {
						var R = $(xml).find("Resp");
						var row = R.find("row");
						
						var id = row.attr("id");
						var cgameid = row.attr("cgameid");//彩种id
						var cperiodid = row.attr("cperiodid");//期次id
						cperiodid=cperiodid.substr(-3);
						var etime = row.attr("etime");//期次截止时间
						var atime = row.attr("atime");//期次开奖时间
						var kjcodes = row.attr("kjcodes");//开奖号码
						var iscurrent = row.attr("iscurrent");//是否是当前期，为1表示是当前期
						
						var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
						
						$("#cg_type span:eq(1)").html('<label>距'+cperiodid+'期截止还剩  <i></i></label>');
						
						var t = $("#cg_type span:eq(1) i")
						
						expect_change_fc(n_,etime,t);
					}
				})
			},
			ah_k3_info:function(){//江苏快3
				$.ajax({
					url : '/grounder/kpgoldbeanaccout.go?flag=0&iscurrent=1&qtype=2&cgameid=06',
					type : "POST",
					dataType : "xml",
					success : function(xml) {
						var R = $(xml).find("Resp");
						var row = R.find("row");
						
						var id = row.attr("id");
						var cgameid = row.attr("cgameid");//彩种id
						var cperiodid = row.attr("cperiodid");//期次id
						cperiodid=cperiodid.substr(-3);
						var etime = row.attr("etime");//期次截止时间
						var atime = row.attr("atime");//期次开奖时间
						var kjcodes = row.attr("kjcodes");//开奖号码
						var iscurrent = row.attr("iscurrent");//是否是当前期，为1表示是当前期
						
						var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
						
						$("#cg_type span:eq(0)").html('<label>距'+cperiodid+'期截止还剩  <i></i></label>');
						
						var t = $("#cg_type span:eq(0) i")
						
						expect_change_ah(n_,etime,t);
					}
				})
			},
	}

	var count_down={
		ah_k3:function(){
			
		}
	}
	
	//签到按钮
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
					var isqd = 1;//是否签到
					
					if($(".jdtext ul:eq(0) li").hasClass("wqd")){
						var index = $(".jdtext ul:eq(0) li.wqd").index();
						
						$(".jdtext ul:eq(0) li:eq("+index+")").removeClass("wqd");
						$(".jdtext ul:eq(0) li:eq("+index+")").addClass("yqd");
	
					}else if($(".jdtext ul:eq(1) li").hasClass("wqd")){
						var index = $(".jdtext ul:eq(1) li.wqd").index();
						
						$(".jdtext ul:eq(1) li:eq("+index+")").removeClass("wqd");
						$(".jdtext ul:eq(1) li:eq("+index+")").addClass("yqd");
	
					}
					
					$("#get_jd").addClass("graybg");
					$("#get_jd").html("已签到");
					$("#get_jd").unbind("click");
					alert("恭喜您，领取成功，赶快参与竞猜吧！");
					$("#jd").hide();
					$(".mask").hide();
					$('#jd,#ceng').hide();
	
				}else{
					alert(desc);
				}
			}
		});
	})

	
	var bind=function(){
		
		$("#close").bind("click",function(){
			$("#jd").hide();
			$(".mask").hide();

		})
		
		$("#card_href").bind("click",function(){
			window.location.href="/gq2/sign/qdfb.html"

		})	
		
		$("#a_open").bind("click",function(){
			
			$(".ceng_k3").show();
			$("#a_open").hide();
			$(".rules_main_k3").show();
			$("#a_close").show();

		})
		
		$("#a_close").bind("click",function(){
			
			$(".ceng_k3").hide();
			$("#a_open").show();
			$(".rules_main_k3").hide();
			$("#a_close").hide();

		})
		
		
	}
	
	
	
	init();