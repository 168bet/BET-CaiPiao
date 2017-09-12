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
var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		
		
		/***
		 * 缺少金豆弹窗
		 * 
		 * 活动结束弹窗
		 */
		alert:function(msg, fn, tag){
			$('#dAlert a.que_dou_1').html(msg);
			tag && $('#dAlert div.sure').html(tag) || $('#dAlert div.sure').html('确定');
			$("#dAlert").show();
			$(".zhezhao").show();
			$('#dAlert div.sure').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				
				$(".egg_1_zhong_hongbao,.egg_2_zhong_hongbao,.egg_3_zhong_hongbao").hide();
				$(".egg_1,.egg_2,.egg_3").show();
				$("#chuizi_1,#chuizi_2,#chuizi_3").hide();
				
				//$(".egg_1,.egg_2,.egg_3").addClass("animation")
				$(".egg_1").removeClass("animation");
				$(".egg_2,.egg_3").removeClass("animation_1");
				$("#layer").hide();
				$("#run").show();

				
				$('#dAlert').hide();
				$(".zhezhao").hide();
			});
			
			$('#dAlert div.guanbi_dou').one('click',function(){
				if(typeof(fn1) == "function"){fn1();}
				
				$(".egg_1_zhong_hongbao,.egg_2_zhong_hongbao,.egg_3_zhong_hongbao").hide();
				$(".egg_1,.egg_2,.egg_3").show();
				$("#chuizi_1,#chuizi_2,#chuizi_3").hide();
				
				//$(".egg_1,.egg_2,.egg_3").addClass("animation")
				$(".egg_1").removeClass("animation");
				$(".egg_2,.egg_3").removeClass("animation_1");
				$("#layer").hide();
				$("#run").show();

				//$('#dConfirm').hide();
				$('#dAlert').hide();
				$(".zhezhao").hide();
			});
		},
		
		/***
		 * 绑定手机号
		 * 完善信息
		 * 实名认证
		 */
		confirm:function(msg, fn, tag){
			$('#dConfirm .md_3').html(msg);
			tag && $('#dConfirm div.md_close').html("关闭") || $('#dConfirm div.md_sure').html(tag);
			$('#dConfirm').show();
			$(".zhezhao").show();
			$('#dConfirm div.md_sure').one('click',function(){//确定
				if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
				$(".zhezhao").hide();
			});
			$('#dConfirm div.md_close').one('click',function(){//关闭
				//if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
				$(".zhezhao").hide();
			});
		},
		
		
		/***
		 * 
		 * @param msg
		 * @param fn:注册方法
		 * @param fn1:登录方法
		 * @param tag:注册按钮
		 * @param tag1:登录按钮
		 * 
		 * 登录注册
		 */
		
		confirm_login:function(fn,fn1){
			$('#dConfirm_login').show();
			$(".zhezhao").show();
			$('#dConfirm_login div.md_close').one('click',function(){//注册
				if(typeof(fn) == "function"){fn();}
				$('#dConfirm_login').hide();
				$(".zhezhao").hide();
			});
			$('#dConfirm_login div.md_sure').one('click',function(){//登录
				if(typeof(fn1) == "function"){fn1();}
				$('#dConfirm_login').hide();
				$(".zhezhao").hide();
			});
			
			$('#dConfirm_login div.guanbi_dou').one('click',function(){//注册
				//if(typeof(fn1) == "function"){fn1();}
				
				$(".egg_1_zhong_hongbao,.egg_2_zhong_hongbao,.egg_3_zhong_hongbao").hide();
				$(".egg_1,.egg_2,.egg_3").show();
				$("#chuizi_1,#chuizi_2,#chuizi_3").hide();
				
				//$(".egg_1,.egg_2,.egg_3").addClass("animation")
				$(".egg_1").removeClass("animation");
				$(".egg_2,.egg_3").removeClass("animation_1");
				$("#layer").hide();
				$("#run").show();

				$('#dConfirm_login').hide();
				$(".zhezhao").hide();
			});
		},
		
		
		//中红包弹窗提示
		alert_hb:function(msg, fn){
			$('#dAlert_hb em a').html(msg);
			setTimeout(function(){
				$("#dAlert_jd").show();
				$(".zhezhao").show();
			},500)
			$('#dAlert_hb div.guanbi').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$(".egg_1_zhong_hongbao,.egg_2_zhong_hongbao,.egg_3_zhong_hongbao").hide();
				$(".egg_1,.egg_2,.egg_3").show();
				$("#chuizi_1,#chuizi_2,#chuizi_3").hide();
				$(".egg_1").removeClass("animation");
				$(".egg_2,.egg_3").removeClass("animation_1");
				$("#layer").hide();
				$("#run").show();

				$('#dAlert_hb').hide();
				$(".zhezhao").hide();
			});
		},
		
		//中金豆弹窗提示
		alert_jd:function(msg, fn){
			$('#dAlert_jd em a').html(msg);
			setTimeout(function(){
				$("#dAlert_jd").show();
				$(".zhezhao").show();
			},500)
			
			$('#dAlert_jd div.guanbi').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$(".egg_1_zhong_jindou,.egg_2_zhong_jindou,.egg_3_zhong_jindou").hide();
				$(".egg_1,.egg_2,.egg_3").show();
				$("#chuizi_1,#chuizi_2,#chuizi_3").hide();
				$(".egg_1").removeClass("animation");
				$(".egg_2,.egg_3").removeClass("animation_1");
				$("#layer").hide();
				$("#run").show();

				$('#dAlert_jd').hide();
				$(".zhezhao").hide();
			});
		},
};

var XHC={};
  
XHC.HIT_EGG=(function(){
	var from = location.search.getParam("from");
	var appversion = location.search.getParam("appversion");
	appversion=appversion?parseInt(appversion.replace(/\./g,'')):"";
	
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
									//loadCont();
								}else{//未登录
									//location.href='login.html';
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
		},function(){
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

	

	
	
	
	
	
	var init=function(){
		
		if(from &&  (from=="android" || from=="ANDROID")){
			$("#back").hide();
			tokenLogin();
		}else if(from &&  (from=="wp" || from=="WP")){
			$("#back").hide();
			tokenLogin();
		}else if(from && (from=="IOS" || from=="ios")){
			//alert(appversion)
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
				 				},function(){
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
		 					
		 				},function(){
		 					var url='login.html';
		 					window.location.href = url;
		 				});
		 			}
		        }
			});
		}
		
		
		bindEvent();
		loadCont();
		my_jd_info();
	};
	
	
	var type={
			"1":"金豆",
			"2":"红包"
	};
	
	//格式化金额20000=>20,000
	var fomatStr = function(s,type) {
	    if (/[^0-9\.]/.test(s)){return "0";};
	    if (s == null || s == ""){return "0";};
	    s = s.toString().replace(/^(\d*)$/, "$1.");
	    s = (s + "00").replace(/(\d*\.\d\d)\d*/, "$1");
	    s = s.replace(".", ",");
	    var re = /(\d)(\d{3},)/;
	    while(re.test(s))
	    {
	        s = s.replace(re, "$1,$2"); 
	    }
	    s = s.replace(/,(\d\d)$/, ".$1");  
	    if (type == 0) 
	    {
	        var a = s.split(".");
	        if (a[1] == "00") 
	        {
	            s = a[0];
	        }
	    }
	    return s;
	}
	
	//加载首页内容:滚动内容
	var loadCont=function(){
		var html="";
		$.ajax({
			url:"/activity/eggfrenzylist.go",
			dataType:'xml',
			cache:true,
			success:function(xml){
				var R = $(xml).find("Resp");
				var desc = R.attr("desc");
				var code = R.attr("code");
				var rows = R.find("rows");
				if(code==0){
					var row = rows.find("row");
					row.each(function(){
						var nickid = $(this).attr("nickid");
						var money = $(this).attr("money");
						
						
						
						money=parseInt(parseFloat(money));
						
						
						
						var biztype = $(this).attr("biztype");
						if(biztype==1){
							html+='<li>'+nickid+'敲中了'+money+type[biztype]+'</li>';
						}else if(biztype==2){
							html+='<li>'+nickid+'敲中了'+money+'元'+type[biztype]+'</li>';
						}
					})
					
					$("#scroll_Cont").html(html);
					
					var speed=50
					   var demo = document.getElementById("demo");
					   var scroll_Cont = document.getElementById("scroll_Cont");
					   var demo2 = document.getElementById("demo2");
					   demo2.innerHTML=scroll_Cont.innerHTML
					   function Marquee(){
						   if(demo2.offsetTop-demo.scrollTop<=0){
							   demo.scrollTop-=scroll_Cont.offsetHeight;
						   }
						   else{
							   demo.scrollTop++
						   }
					   }
					   var MyMar=setInterval(Marquee,speed)
					   demo.onmouseover=function() {clearInterval(MyMar)}
					   demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)}
				}
			}
		})
	}
	
	//我的金豆信息
	var my_jd_info=function(){
		var html="";
		$.ajax({
			url:"/activity/eggfrenzybeancount.go",
			dataType:'xml',
			cache:true,
			success:function(xml){
				var R = $(xml).find("Resp");
				var desc = R.attr("desc");
				var code = R.attr("code");
				
				if(code==0){
					var row = R.find("row");
					var money = row.attr("money");
					money = fomatStr(money,00)
					var nickid = row.attr("nickid");
					$("#my_jd_info").show();
					$("#my_jd_info").html(nickid+'   可用砸蛋金豆：<span class="white">'+money+'</span>')
				}else{
					$("#my_jd_info").hide();
				}
			}
		})
	}
	//砸蛋方法
	var hit_egg=function(num){
		$.ajax({
			url:"/activity/eggfrenzy.go?type="+num,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				
				var row = R.find("row");
				var bindflag = row.attr("bindflag");
				var type = row.attr("type");
				var index = row.attr("index");
				
				if(code=="0"){//抽奖成功
					if(type==2 && index==1){//100金豆
						$(".egg_1_zhong_jindou em").html("1000金豆");
						$(".egg_1_zhong_jindou").show();
						$(".egg_1").hide()
						D.alert_jd("1000金豆");
					}else if(type==2 && index==2){
						$(".egg_1_zhong_jindou em").html("20000金豆");
						$(".egg_1_zhong_jindou").show()
						$(".egg_1").hide()
						D.alert_jd("20000金豆");
					}else if(type==2 && index==3){
						$(".egg_1_zhong_jindou em").html("50000金豆");
						$(".egg_1_zhong_jindou").show()
						$(".egg_1").hide()
						D.alert_jd("50000金豆");
					}else if(type==2 && index==4){
						$(".egg_1_zhong_jindou em").html("100000金豆");
						$(".egg_1_zhong_jindou").show()
						$(".egg_1").hide()
						D.alert_jd("100000金豆");
					}else if(type==2 && index==5){
						$(".egg_1_zhong_hongbao em").html("88元红包");
						$(".egg_1_zhong_hongbao").show()
						$(".egg_1").hide()
						D.alert_hb("88元红包");
					}else if(type==0 && index==1){
						$(".egg_3_zhong_jindou em").html("10金豆");
						$(".egg_3_zhong_jindou").show();
						$(".egg_3").hide()
						D.alert_jd("10金豆");
					}else if(type==0 && index==2){
						$(".egg_3_zhong_jindou em").html("200金豆");
						$(".egg_3_zhong_jindou").show();
						$(".egg_3").hide()
						D.alert_jd("200金豆");
					}else if(type==0 && index==3){
						$(".egg_3_zhong_jindou em").html("500金豆");
						$(".egg_3_zhong_jindou").show()
						$(".egg_3").hide()
						D.alert_jd("500金豆");
					}else if(type==0 && index==4){
						$(".egg_3_zhong_jindou em").html("2000金豆");
						$(".egg_3_zhong_jindou").show()
						$(".egg_3").hide()
						$(".egg_3").hide()
						D.alert_jd("2000豆金豆");
					}else if(type==0 && index==5){
						$(".egg_3_zhong_hongbao em").html("1元红包");
						$(".egg_3_zhong_hongbao").show()
						$(".egg_3").hide()
						D.alert_hb("1元红包");
					}else if(type==1 && index==1){
						$(".egg_2_zhong_jindou em").html("100金豆");
						$(".egg_2_zhong_jindou").show();
						$(".egg_2").hide()
						D.alert_jd("100金豆");
					}else if(type==1 && index==2){
						$(".egg_2_zhong_jindou em").html("2000金豆");
						$(".egg_2_zhong_jindou").show();
						$(".egg_2").hide()
						D.alert_jd("2000金豆");
					}else if(type==1 && index==3){
						$(".egg_2_zhong_jindou em").html("5000金豆");
						$(".egg_2_zhong_jindou").show()
						$(".egg_2").hide()
						D.alert_jd("5000金豆");
					}else if(type==1 && index==4){
						$(".egg_2_zhong_jindou em").html("10000金豆");
						$(".egg_2_zhong_jindou").show()
						$(".egg_2").hide()
						$(".egg_2").hide()
						D.alert_jd("10000金豆");
					}else if(type==1 && index==5){
						$(".egg_2_zhong_hongbao em").html("8元红包");
						$(".egg_2_zhong_hongbao").show()
						$(".egg_2").hide()
						D.alert_hb("8元红包");
					}
					
					$("#chuizi_1,#chuizi_2,#chuizi_3").hide();
					//移动锤子方法
					//movement($(".chuizi"));
					my_jd_info()
				}else if(code=="1"){
					
				}else if(code=="-1"){//抽奖失败
					/***
					$(".egg_1_zhong_hongbao,.egg_2_zhong_hongbao,.egg_3_zhong_hongbao").hide();
					$(".egg_1,.egg_2,.egg_3").show();
					$("#chuizi_1,#chuizi_2,#chuizi_3").hide();
					***/
					if(desc=="金豆不足"){
						D.alert("您的金豆余额不足，请去赚点金豆再来吧！");
					}else if(desc=="盈利不足"){
						D.alert("<span class='green'>您的可用砸蛋金豆不足！</span>&nbsp;&nbsp可用砸蛋金豆值为参与赛事竞猜您当天、当月和历史总盈利中最大的一个,每砸一次可用金豆相应减少。")

					}
					else{
						D.alert(desc)
					}
					if(bindflag=="0"){//两项均已绑定
						//alert(desc);
					}else if(bindflag=="2"){//未绑定身份证
						
					}else if(bindflag=="3"){//未绑定手机号
						
					}else if(bindflag=="5"){//两项均未绑定
						
					}
					
				}
				//移动锤子方法
				//movement($(".chuizi"));
				
			},
			error:function(){
				D.alert("期次和投注类型不正确");
			}
		});
	}
	
	
	/***
	 * 移动锤子方法
	 */
	//left:46.5%  top:-16.5
	var movement = function(elm){
		
		
		$(elm).animate({left:"46.5%",top:"-16.5rem"},2000,function(){
			//$(elm).animate({left:old_left,top:old_top})
		})
	}
	var movement1 = function(elm,obj){
		var l = $(elm).offset().left;
		var h = $(elm).offset().top;
		
		$(obj).animate({left:l,top:h},2000,function(){
			//$(elm).animate({left:old_left,top:old_top})
		})
	}
	
	var bindEvent=function(){
		
		$(".wen").bind("click",function(){
			$(".tishi").show();
			$(".zhezhao").show();
		});
		
		$(".tishi .close").bind("click",function(){
			$(".tishi").hide();
			$(".zhezhao").hide();
		})
		
		$("#layer").bind("click",function(){
			$("#layer").hide();
			$("#run").show();

			$(".egg_1").removeClass("animation");
			$(".egg_2,.egg_3").removeClass("animation_1");
		})
		//拿起锤子砸蛋
		$("#hit_egg").bind("click",function(){
			//movement($(".chuizi"))
			
			$.ajax({
				url:"/activity/bindinfocheck.go",
				dataType:'xml',
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code==0){//两项均已绑定
						$("#layer").show();
						$("#run").hide();
						$(".egg_1").addClass("animation");
						$(".egg_2,.egg_3").addClass("animation_1");
					}else if(code==2){//未绑定身份证
						D.confirm(desc, function(){
							window.location.href = "idcard.html";
						}, "去认证");
					}else if(code==3){//未绑定手机号
						D.confirm(desc, function(){
							window.location.href = "phone.html";
						}, "去绑定");
					}else if(code==5){//两项均未绑定
						D.confirm(desc, function(){
							window.location.href = "idcard.html";
						}, "去认证");
					}else if(code==1){//未登录
						//未登录
						//调用登录方法
						D.confirm_login("参与活动前,需先登录!",function(){
							if(CP.MobileVer.android){//android
								try {
									window.caiyiandroid.clickAndroid(3, '');
								} catch (e){
									window.location.href = "login.html";
								}
							}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
								try {
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
									WebViewJavascriptBridge.callHandler('clickIosRegister');
								} catch (e){
									window.location.href = "register.html";
								}
							}else{//4g
								window.location.href = "register.html";
							}
						},"登录","注册");
					}
				}
			})
			
		});
		
		
		
		//中间
		$("ul.eg_box .egg_1").bind("click",function(){
			$(".egg_2,.egg_3").removeClass("animation_1");
			if($(this).hasClass("animation")){
				$(this).removeClass("animation");
				$("#chuizi_1").show();
				setTimeout(function(){
					hit_egg("2");
				},10)
			}
		});
		
		//右边
		$("ul.eg_box .egg_2").bind("click",function(){
			$(".egg_3").removeClass("animation_1");
			$(".egg_1").removeClass("animation");
			if($(this).hasClass("animation_1")){
				$(this).removeClass("animation_1");
				$("#chuizi_2").show();
				setTimeout(function(){
					hit_egg("1");
				},10)
			}
		});
		
		
		//左边
		$("ul.eg_box .egg_3").bind("click",function(){
			$(".egg_1").removeClass("animation");
			$(".egg_2").removeClass("animation_1");
			if($(this).hasClass("animation_1")){
				$(this).removeClass("animation_1");
				$("#chuizi_3").show();
				setTimeout(function(){
					hit_egg("0");
				},10)
			}
		});
	};
	
	
	
	
	
	return {
		init:init
	};
})();

$(function(){
	XHC.HIT_EGG.init();
});

  