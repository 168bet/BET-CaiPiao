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
var pageLoading = {
		show: function () {
			if ($("#loadpop").length) {
				$("#loadpop").show();
			} else {
				$(document.body).append($('<div class="loadpop" id="loadpop"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>'));
			}
		},
		hide: function () {
			setTimeout(function () {
				$("#loadpop").fadeOut();
			}, 150);
		}
};
var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, .1e3);
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
var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag){
			$('#dAlert p').html(msg);
			tag && $('#dAlert a.bfb').html(tag) || $('#dAlert a.bfb').html('确定');
			$("#dAlert").show();
			$("#zhezhao").show();
			$('#dAlert a.bfb').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$('#dAlert').hide();
				$("#zhezhao").hide();
			});
		},
		confirm:function(msg, fn, tag){
			$('#dConfirm p').html(msg);
			tag && $('#dConfirm div.zfTrue a:eq(0)').html(tag) || $('#dConfirm div.zfTrue a:eq(0)').html('确定');
			$('#dConfirm').show();
			$("#zhezhao").show()
			$('#dConfirm a:eq(0)').one('click',function(){//取消
				if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
			});
			$('#dConfirm a:eq(1)').one('click',function(){//确定
				//if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
				$("#zhezhao").hide();
			});
		},
		
		confirm_login:function(msg,fn,fn1,tag,tag1){
			$('#dConfirm_login p').html(msg);
			tag && $('#dConfirm_login div.zfTrue a:eq(0)').html(tag) || $('#dConfirm div.zfTrue a:eq(0)').html('确定');
			tag1 && $('#dConfirm_login div.zfTrue a:eq(1)').html(tag1) || $('#dConfirm div.zfTrue a:eq(0)').html('取消');
			$('#dConfirm_login').show();
			$("#zhezhao").show()
			$('#dConfirm_login a:eq(0)').one('click',function(){//取消
				if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
				$("#zhezhao").hide();
			});
			$('#dConfirm_login a:eq(1)').one('click',function(){//确定
				if(typeof(fn1) == "function"){fn1();}
				$('#dConfirm').hide();
				$("#zhezhao").hide();
			});
		}
};

var CP={};

CP.MobileVer = (function ($) {
	var tag = location.search.getParam('tag') || false;//ios 判断版本 不为false调他们的充值页面 否则弹窗提示
	var u = navigator.userAgent;
	var obj = {
		android: false,
		ios: false,
		ios7: false,
		ipad: false
	};
	obj.android = (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1);
	obj.ios = (!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/));
	obj.ipad = u.indexOf('iPad') > -1;
	if (obj.ios) {
		if (u.indexOf('7_') > -1) {
			obj.ios7 = true;
		}
	}
	return obj;
})();

CP.ZLK=(function(){
	var date_ = '';
	var lg={
		"0":"bslogo",
		"1":"brlogo",
		"2":"rmelogo",
		"3":"hmlogo",
		"4":"mllogo",
		"5":"qexlogo",
		"6":"tuslogo"
	}
	
	var lgname={
			"0":"巴萨",
			"1":"拜仁",
			"2":"圣日耳曼",
			"3":"皇马",
			"4":"曼联",
			"5":"切尔西",
			"6":"尤文图斯"
		}
	
	//初始化方法
	var init=function(){
		tokenLogin();
		bindEvent();
	};
	
	
	var bindEvent=function(){
		
		//关闭登录层
		$(".clock").bind("click",function(){
			$("#dConfirm_login").hide();
			$(".zhezhao").hide();
		})
		
		$("#rules").bind("click",function(){
			$("#rulesCont").toggleClass("cur");
			$("body").scrollTop(999999);
		});
		
		//愉悦手下
		$(".popup").bind("click",function(){
			$(this).hide();
			$(".zhezhao").hide();
		})
		
		$(".popup2").bind("click",function(){
			$(this).hide();
			$(".zhezhao").hide();
		})
		
		//领取礼包
		$("#openlb").bind("click",function(){
			var rewardTotalValue = parseInt($("#rewardTotal").html());//总共发放的红包
			//var countValue = parseInt($("#count").html());//今日还剩下的次数
			/***
			if($(this).hasClass("gray")){
				return false;
			}
			***/
			//pageLoading.show();//隐藏讨厌的菊花
			alert('加载中...','true');
			$.ajax({
				url:"/activity/getNewYearPresent.go",
				dataType:'xml',
				cache:true,
				success: function(xml) {
					remove_alert();
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code=="0"){//成功
						var rows= R.find("rows");
						var ptype = rows.attr("ptype");
						var money = rows.attr("money");
						var cardid = rows.attr("cardid");
						var times = parseInt(rows.attr("times"));
						/***
						if(times==3){
							$("#openlb").addClass("gray");
						}else{
							$("#openlb").removeClass("gray");
						}
						***/
						if(ptype=="0"){//0：红包
							$("#hb cite#money").html(money+"元");
							$("#hb").show();
							$("#kp").hide();
							$("#zhezhao").show();
							//pageLoading.hide();//隐藏讨厌的菊花
						}else{//1:卡片
							$("#hb").hide();
							$("#kp").show();
							var c = lg[cardid];
							$("."+c).show();
							$("."+c).siblings().hide();
							$("#zhezhao").show();
							//pageLoading.hide();//隐藏讨厌的菊花
							
						}
						rewardTotalValue=rewardTotalValue+1
						$("#openlb").next().html("今日还剩"+(3-times)+"次机会");
						$("#rewardTotal").html(rewardTotalValue);
					}else if(code=="1"){//未登录
						//如果未登录,此时需要用户去登录，登录的时候要判断是去IOS/安卓,5
						//var url = "login.html";
						/***
						D.confirm('参与"礼包天天送活动"，需先登录;点击去登录，立即进入登录！',function(){
							if(CP.MobileVer.android){//android
								try {
									window.caiyiandroid.clickAndroid(3, '');//100是这个活动需要的
								} catch (e){
									window.location.href = url;
								}
							}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
								try {
									//WebViewJavascriptBridge.callHandler('clickIosLottery');
									WebViewJavascriptBridge.callHandler('clickIosLogin');
								} catch (e){
									window.location.href = url;
								}
							}else{//4g
								window.location.href = url;
							}
						},"去登录");
						***/
						
						D.confirm_login("参与活动前,需先登录!",function(){
							if(CP.MobileVer.android){//android
								try {
									window.caiyiandroid.clickAndroid(3, '');
								} catch (e){
									window.location.href = "login.html";
								}
							}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
								try {
									//WebViewJavascriptBridge.callHandler('clickIosLottery');
									WebViewJavascriptBridge.callHandler('clickIosLogin');
								} catch (e){
									window.location.href = "login.html";
								}
							}else{//4g
								window.location.href = "login.html";
							}
						},function(){//注册
							if(CP.MobileVer.android){//android
								try {
									window.caiyiandroid.clickAndroid(4, '');
								} catch (e){
									window.location.href = "register.html";
								}
							}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
								try {
									//WebViewJavascriptBridge.callHandler('clickIosLottery');
									WebViewJavascriptBridge.callHandler('clickIosRegister');
								} catch (e){
									window.location.href = "register.html";
								}
							}else{//4g
								window.location.href = "register.html";
							}
						},"登录","注册");
						//pageLoading.hide();//隐藏讨厌的菊花
					}else if(code=="-1"){//未知一场
						D.alert(desc);
					}else if(code=="-2"){//未绑定手机
						D.confirm("参与活动前,需先绑定手机号!",function(){
							window.location.href="phone.html";
						},"去绑定");
						//pageLoading.hide();//隐藏讨厌的菊花
					}else if(code=="-3"){//未绑定身份证
						D.confirm("参与活动前,需先完善实名认证!",function(){
							window.location.href="idcard.html";
						},"去认证")
					}else if(code=="-4"){//其他条件不符合
						D.alert(desc);
						//pageLoading.hide();//隐藏讨厌的菊花
					}
				},
				error:function(){
					remove_alert();
					alert("数据加载异常")
				}
			});
		})
	};
	
	
	//我的礼包
	$("#myPackage").bind("click",function(){
		$.ajax({
			url:"/activity/queryMyNewYearPresent.go",
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code=="0"){//成功
					window.location.href="my.html";//进入我的礼包页面
				}else if(code=="1"){//未登录
					//如果未登录,此时需要用户去登录，登录的时候要判断是去IOS/安卓,5
					/***
					D.confirm("参与活动前,需先登录!",function(){
						window.location.href="login.html";
					},"去登录");
					***/
					
					D.confirm_login("参与活动前,需先登录!",function(){
						if(CP.MobileVer.android){//android
							try {
								window.caiyiandroid.clickAndroid(3, '');
							} catch (e){
								window.location.href = "login.html";
							}
						}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
							try {
								//WebViewJavascriptBridge.callHandler('clickIosLottery');
								WebViewJavascriptBridge.callHandler('clickIosLogin');
							} catch (e){
								window.location.href = "login.html";
							}
						}else{//4g
							window.location.href = "login.html";
						}
					},function(){//注册
						if(CP.MobileVer.android){//android
							try {
								window.caiyiandroid.clickAndroid(4, '');
							} catch (e){
								window.location.href = "register.html";
							}
						}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
							try {
								//WebViewJavascriptBridge.callHandler('clickIosLottery');
								WebViewJavascriptBridge.callHandler('clickIosRegister');
							} catch (e){
								window.location.href = "register.html";
							}
						}else{//4g
							window.location.href = "register.html";
						}
					},"登录","注册");
				}
			},
		});
	});
	
	//判断用户是否登录
	
	var tokenLogin=function(){
		var allcookies = document.cookie;
		if(allcookies.indexOf('TOKEN')!='-1'){
			alert('加载中..','load');
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
					success:function(xml){
						$.ajax({
							url:'/user/query.go?flag=6',
							type:'POST',
							dataType:'xml',
							success: function(xml) {
								var R = $(xml).find('Resp');
								var c = R.attr('code');
								if(c == '0'){//已登录
									remove_alert();
									loadCont();
								}else{//未登录
									location.href='login.html';
								}
								o.against();
							}
						});
					}
				});
			},.3e3);
		}else{
			loadCont();
		}
	};
	
	
	//判断用户是否绑定手机
	var chekcMobile = function(){
		
	};
	
	//判断用户是否绑定身份证
	var checkIdenty=function(){
		
	};
	
	
	//加载首页内容
	var loadCont=function(){
		var rewardHTML = "";
		$.ajax({
			url:"/activity/presentIndex.go",
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var date_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
				date_ = (date_.getMonth()+1)+''+date_.getDate();
				var R = $(xml).find("Resp");
				var rows = R.find("rows");
				var times = parseInt(rows.attr("times"));//礼包领取次数
				var total = rows.attr("total");//累计已送礼包
				var islogin = rows.attr("islogin");
				/***
				if(times==3){
					$("#openlb").addClass("gray");
				}else{
					$("#openlb").removeClass("gray");
				}
				***/
				var r = rows.find("row");
				r.each(function(){
					var nickid=$(this).attr("nickid");//用户名
					var ptype=$(this).attr("ptype");//礼包类型,0：红包,1:卡片
					var money=$(this).attr("money");//红包金额
					var cardid=$(this).attr("cardid");//卡片ID
					if(ptype=="0"){
						rewardHTML+='<li>'+nickid+'<cite>'+money+'</cite>元红包</li>';
					}else if(ptype=="1"){
						rewardHTML+='<li>'+nickid+'<cite>1</cite>张'+lgname[cardid]+'卡</li>';
					}
					
				});
				$("#reward").html(rewardHTML);
				$("#rewardTotal").html(total);
				var tag1 = '每日有3次打开礼包机会';
				if(parseInt(date_)>=218){
					if(islogin!="0"){//已登录
						tag1 = "今日还剩"+(3-times)+"次机会";
					}
				}
				$("#openlb").next().html(tag1);
				
				
			   var speed=50
			   var demo = document.getElementById("demo");
			   var reward = document.getElementById("reward");
			   var demo2 = document.getElementById("demo2");
			   demo2.innerHTML=reward.innerHTML
			   function Marquee(){
				   if(demo2.offsetTop-demo.scrollTop<=0){
					   demo.scrollTop-=reward.offsetHeight;
				   }
				   else{
					   demo.scrollTop++
				   }
			   }
			   var MyMar=setInterval(Marquee,speed)
			   demo.onmouseover=function() {clearInterval(MyMar)}
			   demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)}
			},
		});
	};
	
	return {
		init:init
	};
})();
$(function(){
	CP.ZLK.init();
})