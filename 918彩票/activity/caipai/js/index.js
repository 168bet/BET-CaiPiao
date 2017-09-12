var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag){
			$('#calert p').html(msg);
			tag && $('#calert a').html(tag) || $('#calert a').html('确定');
			$('#mask, #calert').show();
			$('#calert a').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$('#calert,#mask').hide();
			});
		},
		confirm:function(msg, fn, tag1, tag2, fn1){
			$('#cconfirm p').html(msg);
			tag1 && $('#cconfirm a:eq(0)').html(tag1) || $('#cconfirm a:eq(0)').html('取消');
			tag2 && $('#cconfirm a:eq(1)').html(tag2) || $('#cconfirm a:eq(1)').html('确定');
			$('#mask, #cconfirm').show();
			$('#cconfirm a:eq(0)').off().bind('click',function(){//取消
				if(typeof(fn1) == "function"){fn1();}
				$('#cconfirm,#mask').hide();
			});
			$('#cconfirm a:eq(1)').off().bind('click',function(){//确定
				if(typeof(fn) == "function"){fn();}
				$('#cconfirm,#mask').hide();
			});
		}
};
//公用弹出层和加载层
var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 1e3);
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
var CP = {};
/**
 * @description 获取手机系统
 * @return {object}
 * @example CP.MobileVer.android;
 * @memberOf CP
 */
CP.MobileVer = (function ($) {
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
var adload;
var w = 320;
var h = 480;
var cw = 320;
var ch = 240;
/*
 * @param quan 一秒钟希望洗牌的次数
 * return 毫秒数
 */
var fps = function(quan){
	return 1e3/(7*quan);//这里7代表洗一次牌有7个步骤
};
var canvas, context, levelCount, imageSprite, timeout;
canvas = document.getElementById("canvas");
canvas.style.display = "block";
canvas.width = cw;
canvas.height = ch;
context = canvas.getContext("2d");
var strings = {
		witr: ["请记住中间自动翻开的这张牌哦！","萌萌哒，仔细看哦！","翻出那张牌（请选择）"],
		ok: ["我猜我猜我猜猜猜，BINGO！就是辣么厉害！", "太刺激了，又猜对了，来包辣条吧！", "乾坤大挪移也飞不出你的手掌心，太棒了！", "Duang!Duang!Duang!高手在此，谁与争锋！", "过关了，您就是偶滴神！",
		     "所向披靡，屡战屡胜！","靠实力也靠运气，兼得取胜便是极好的！","已经无法诠释鸡冻的小心灵！劲！","你这么屌，全世界造吗？","全能Get十关啦，您就是王中王！"]
};
//var imgArray;



var okArray,failArray;
var loadFile=function(){
	okArray = new Array("cppt_zq.png","cppt_ssq.png","cppt_lq.png");
	failArray = new Array("cppt_zq.png","cppt_ssq.png","cppt_lq.png");
	/*-------------------------------------------预加载图片----------------------------------------*/
	var txtNum=document.getElementById("loadImg");
	preloadimages(["paibg.png","cppt_zq.png","cppt_ssq.png","cppt_lq.png",
	               "img/tishi.png","img/cp_banner.png","img/passone.png","img/passtwo.png",
	               "img/passthree.png","img/pass4.png","img/pass5.png","img/pass6.png",
	               "img/pass7.png","img/pass8.png","img/pass9.png","img/pass10.png"]);
	function preloadimages(arr){
		var newimages=[], loadedimages=0;
		var arr=(typeof arr!="object")? [arr] : arr;
		function imageloadpost(){
			loadedimages++;
			txtNum.innerHTML="加载中"+loadedimages+"/"+arr.length;
			
			if (loadedimages==arr.length-1){
				$("#loadBg").hide();
				$("#loadImg").hide();
				imageSprite = new Image();
				imageSprite.src= "paibg.png";
//				init();
			}
		}
		for (var i=0; i<arr.length; i++){
			newimages[i]=new Image();
			newimages[i].src=arr[i];
			newimages[i].onload=function(){
				imageloadpost();
			};
			newimages[i].onerror=function(){
				imageloadpost();
			};
		}
	}
	/*-----------------------------------------------------------------------------------*/
};
//是否PC

var clickEvent;//触发事件
function IsPC() {
	var userAgentInfo = navigator.userAgent;
	var Agents = ["Android", "iPhone",
	              "SymbianOS", "Windows Phone",
	              "iPad", "iPod"];
	var flag = true;
	for (var v = 0; v < Agents.length; v++) {
		if (userAgentInfo.indexOf(Agents[v]) > 0) {
			flag = false;
			break;
		}
	}
	return flag;
}

if(IsPC()){
	clickEvent = "click";
}else{
	clickEvent = "touchstart";
}
var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
var user = {
		name:'',
		cishu:'',
		login:true
};

var toLogin = function(){
	D.confirm('参与活动前，需先登录！',function(){
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
		}else{//4g
			window.location.href = url;
		}
	});
};
$(function(){
	init();
});
var init = function() {
	function main(){
		$.ajax({
			url:'/activity/passhomepage.go',
			type:'GET',
			success:function(xml){
				var R = $(xml).find('Resp');
				var c = R.attr('code');
				var d = R.attr('desc');
				var r = R.find('row');
				var sum = r.attr('sum');//累计闯关人数
				$('#Cnum').html(sum);
				if(c == 0){
					user.name =  r.attr('uid');
					user.cishu = r.attr('chance_pass');//抽奖次数
					if(user.cishu < 0){//防止后端返回负数
						user.cishu = 0;
					}
					$('#life').html('您当前有'+user.cishu+'次闯关机会');//剩余生命
				}else if(c == 1){//未登录
					$('#life').html('每天有2次闯关机会');
					user.login = false;
				}else{
					$('#life').html('每天有2次闯关机会');
					D.alert(d);
				}
			}
		});
	}
	var allcookies = document.cookie;
	if(allcookies.indexOf('TOKEN')!='-1'){
		alert('加载中...','load');
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
				type:'POST',
				success:function(){
					remove_alert();
					main();
				},
				error:function(){
					alert('网络异常，请重新打开页面');
				}
			});
		},300);
	}else{
		main();
	}

	var start = $("#start");//开始层
	var btnstart = $("#btnstart");//开始按钮
	var View = $("#gameView");//游戏层
	btnstart.off().bind('click',function(){
		if(user.login){//已登录
			alert('加载中...','load');
			$.ajax({
				url:'/activity/startpass.go',//开始闯关
				type:'POST',
				data:{
					uid:user.name
				},
				success:function(xml){
					remove_alert();
					var R = $(xml).find('Resp');
					var c = R.attr('code');
					var d = R.attr('desc');
					
					if(c == 0){
						$('#headerImg').hide();
						start.hide();
						View.show();
						gameView();
					}else if(c == 1){
						toLogin();
					}else{//c==-1
						var r = R.find('row');
						var bindflag = r.attr('bindflag');
						var Q = '';
						if(bindflag == 3 || bindflag == 5){//未绑手机号 两个都没绑
							if(bindflag == 5){
								Q = '102';
							}
							D.confirm('参与活动请先验证手机号！',function(){
								var url = 'phone.html';
								if(CP.MobileVer.android){//android
									try {
										window.caiyiandroid.clickAndroid(5, Q);//绑定手机
									} catch (e){
										window.location.href = url;
									}
								}else{//4g & ios
									window.location.href = url;
								}
							},'取消','去认证');
						}else if(bindflag == 2){//未绑定身份证
							D.confirm('参与活动请先完成实名认证！',function(){
								var url = 'idcard.html';
								if(CP.MobileVer.android){//android
									try {
										window.caiyiandroid.clickAndroid(6, Q);//绑定省份证
									} catch (e){
										window.location.href = url;
									}
								}else{//4g & ios
									window.location.href = url;
								}
							},'取消','去认证');
							
						}else{
							D.alert(d);
						}
					}
				}
			});
		}else{
			toLogin();
		}
	});
	bind();
	localStorage.setItem('huodong',window.location.href);
};
var bind = function(){
	$('.clock').bind('click',function(){
		$(this).parent().hide();
		$('#mask').hide();
	});
};
var gameView = function() {

	//关卡、生命值
	levelCount = 1;
	livesCount = 1;

	var msg = document.getElementById("msg");//提示文字
	var hzb = document.getElementById("fhz_btn");//通关了重玩 抽奖
	var again = document.getElementById("again");//失败了重玩

	var o = 28;
	var u = 28;

	//洗牌次数
	var Shuffle = 10;//10
	var xi = 2;//默认洗牌一秒种一次
	var Shuffle_Count = 0;
	var lp = -1;
	var ln = 1;


	//正确牌的位置
	var l = 0;
	var c = 60;
	//牌的距离
	var h = 100;
	var p = 50;
	var d = 53;
	var v = 57;

	var m = function() {
		this.draw = function() {//第一步 填充矩形
			context.fillStyle = "#ffca77";
			context.fillRect(0, 0, cw, ch);
		};
	};
	var g = function(imageSprite) {

		this.draw = function(imageSprite) {
//			console.log("weiizhi-1",imageSprite);
			imageSprite.onload = function(){
				context.drawImage(imageSprite, 0, 0, 82, 111, c - 41, p, 82, 111);
			};
		};
	};
	var b = function(imageSprite) {

		this.draw = function(imageSprite) {
//			console.log("weiizhi-2",imageSprite);
			imageSprite.onload = function(){
				context.drawImage(imageSprite, 0, 0, 82, 111, c - 41 + h, p, 82, 111);
			};
		};
	};
	var w = function(imageSprite) {

		this.draw = function(imageSprite) {
//			console.log("weiizhi-3",imageSprite);
			imageSprite.onload = function(){
				context.drawImage(imageSprite, 0, 0, 82, 111, c - 41 + 2 * h, p, 82, 111);
			};
		};
	};
	var E = {
			bg: new m,
			coin: new g,
			coin1: new b,
			coin2: new w,
	};
	var msgs = function(e){
		if(e==0){
			msg.innerHTML = strings.witr[e];
		};
		if(e==1){
			msg.innerHTML = strings.witr[e];
		};
		if(e==2){
			msg.innerHTML = strings.witr[e];
		}
	};
	//选对 或者 选错的时候 提示语
	var msgsState = function(le,lv){//关数  生命数
		var msg1 = strings.ok[le-1];
		if(msg1.length>15){
			$('#msg').addClass('twoh');
		}else{
			$('#msg').removeClass('twoh');
		}
		msg.innerHTML = msg1;
	};
	//下一关文字显示方法
	var levelAction = function(levelCount){
		$('#lelv').attr('class','pass'+levelCount);
	};

	var cards = Array();
	var O = function(){
//		console.log("开始");
		//卡片筛选
		levelAction(levelCount);
		if(cards.length!=0){
			cards=[];
		}
		var okrandom=parseInt(Math.random()*3);
		var failrandom=parseInt(Math.random()*2);
		cards.push(okArray[okrandom]);
		cards.push(failArray[failrandom]);
		$('#msg').removeClass('twoh');
		msgs(0);

		imageSprite.src = "paibg.png";
		context.drawImage(imageSprite, 0, 0, 82, 111, c - 41, p, 82, 111);
		context.drawImage(imageSprite, 0, 0, 82, 111, c - 41 + h, p, 82, 111);
		context.drawImage(imageSprite, 0, 0, 82, 111, c - 41 + 2 * h, p, 82, 111);

//		E.coin.draw(imageSprite);
//		E.coin1.draw(imageSprite);
//		E.coin2.draw(imageSprite);
		setTimeout(function(){
//			console.log(cards[0]);
			imageSprite.src = cards[0];
			E.coin1.draw(imageSprite);
			setTimeout(function(){
				imageSprite.src = "paibg.png";
				E.coin1.draw(imageSprite);
				setTimeout(function(){
					msgs(1);
					M();
				},1e3);
			},1500);
		},2500);
	};
	O();
	//控制洗牌的 
	var M = function() {
		Shuffle_Count++;
		if (Shuffle_Count > Shuffle) {//计数大于 规定洗牌数 停止洗牌
			msgs(2);
			Click();
//			var t = {'0':'中间','1':'右边'}[l]||'左边';
//			console.log("l="+t)
//			alert(t);
			//mouseclick=utils.cpatureMousePosition(canvas);
			return;		//洗牌完成
		}
		//洗牌状态
		var e = Math.floor(Math.random() * 3);
		//洗牌方向
		var t = Math.floor(Math.random() * 2);
		var r = 0;
		if (t == 1) {
			r = 180;
		}
		var i = o;
		if (e == 2) {
			i = i * .8;
		}
		i *= t == 0 ? 1 : -1;
		var s, u, d, v, m, g, y, b;
		//半径
		var w = 24;
		var S = function() {
			var t = r + i;
			if (t > 180) {
				r = 180;
			} else if (t < 0) {
				r = 0;
			} else {
				r += i;
			}
			//重置背景
			E.bg.draw();
			y = deg2rad(r - 90);
			b = deg2rad(r + 90);

			//状态
			if (e == 0) {
				s = p + Math.cos(y) * w;
				u = p + Math.cos(b) * w;
				d = p;
				v = c + h / 2 + Math.sin(y) * (h / 2);
				m = c + h / 2 + Math.sin(b) * (h / 2);
				g = c + h * 2;

				if (s > u) {
					context.drawImage(imageSprite, 0, 0, 82, 111, m - 41, u, 82, 111);
					context.drawImage(imageSprite, 0, 0, 82, 111, v - 41, s, 82, 111);

				} else {
					context.drawImage(imageSprite, 0, 0, 82, 111, v - 41, s, 82, 111);
					context.drawImage(imageSprite, 0, 0, 82, 111, m - 41, u, 82, 111);
				}
				context.drawImage(imageSprite, 0, 0, 82, 111, g - 41, d, 82, 111);

			} else if (e == 1) {
				d = p + Math.cos(y) * w;
				u = p + Math.cos(b) * w;
				s = p;
				g = c + h / 2 + h + Math.sin(y) * (h / 2);
				m = c + h / 2 + h + Math.sin(b) * (h / 2);
				v = c;
				if (s > u) {
					context.drawImage(imageSprite, 0, 0, 82, 111, m - 41, u, 82, 111);
					context.drawImage(imageSprite, 0, 0, 82, 111, v - 41, s, 82, 111);
				} else {
					context.drawImage(imageSprite, 0, 0, 82, 111, v - 41, s, 82, 111);
					context.drawImage(imageSprite, 0, 0, 82, 111, m - 41, u, 82, 111);
				}
				context.drawImage(imageSprite, 0, 0, 82, 111, g - 41, d, 82, 111);

			} else if (e == 2) {
				s = p + Math.cos(y) * w * 1.3;
				d = p + Math.cos(b) * w * 1.3;
				u = p;
				v = c + h + Math.sin(y) * h;
				g = c + h + Math.sin(b) * h;
				m = c + h;
				if (s > u) {
					context.drawImage(imageSprite, 0, 0, 82, 111, g - 41, d, 82, 111);
					context.drawImage(imageSprite, 0, 0, 82, 111, m - 41, u, 82, 111);
					context.drawImage(imageSprite, 0, 0, 82, 111, v - 41, s, 82, 111);
				} else {
					context.drawImage(imageSprite, 0, 0, 82, 111, v - 41, s, 82, 111);
					context.drawImage(imageSprite, 0, 0, 82, 111, m - 41, u, 82, 111);
					context.drawImage(imageSprite, 0, 0, 82, 111, g - 41, d, 82, 111);
				}
			}
//			console.log(r);
			if (r >= 180 || r <= 0) { 						//牌的动画结束后

				//正确牌的位置

				if (e == 0) {
					if (l == -1 || l == 0) {
						l = l == -1 ? 0 : -1;
					}
				} else if (e == 1) {
					if (l == 1 || l == 0) {
						l = l == 1 ? 0 : 1;
					}
				} else if (e == 2) {
					if (l == 1 || l == -1) {
						l *= -1;
					}
				}
				r = 0;
//				console.log('l='+l);//正确答案
				M();
			} else {//控制牌的动画
				timeout = setTimeout(S, fps(xi));
			}
		};
		timeout = setTimeout(S, fps(xi));
	};
	//M();

	var CJ = function(xx, fn){//增加抽奖次数
		$.ajax({
			url:'/activity/savedrawchance.go',
			type:'POST',
			data:{
				bnum:xx
			},
			success: function(xml){
				var R = $(xml).find('Resp');
				var c = R.attr('code');
				var d = R.attr('desc');
				if(c == 0){
					if(typeof(fn) == "function"){fn();}
				}else if(c == 1){
					toLogin();
				}else{
					D.alert(d);
				}
			}
		});
	};
	
	//下一关
	var N = function(level){
		if(level<11){//最大关数5
			if(level==6){
				$('#fhz_btn2').show();
				
				$('#fhz_btn2').off();
				$('#fhz_btn2').on('click','a:eq(0)',function(){//抽奖
					CJ(1,function(){location.href='cj.html';});
				}).on('click','a:eq(1)',function(){//继续
					D.confirm("若继续闯关失败，您此次连闯5关获取的抽奖机会将清零。",function(){
						$('#fhz_btn2').hide();
						Shuffle_Count=0;
						l=0;
						//每过一关加 难道 (怎么转的次数)
						Shuffle += 2;
						xi++;
						setTimeout(O,1e3);
					},'取消闯关','确认挑战');
				});
			}else{
				Shuffle_Count=0;
				l=0;
				//每过一关加 难道 (怎么转的次数)
				Shuffle += 2;
				xi++;
				setTimeout(O,3e3);
			}
		}else{//通关了
			CJ(3);//最后一关的时候抽奖次数加3
			setTimeout(A,.3e3);
			hzb.setAttribute("style","display:block");
		}
	};
	//游戏结束
	var A = function(){
//		var botton1 = $("#cw");//通关重新闯关
//		var botton2 = $('#again');//失败重新闯关
		function Click(){
//			botton1.unbind(clickEvent);
			$("#cw,#again").off().bind(clickEvent,function(){
				alert('加载中...','load');
				//已登录
				$.ajax({
					url:'/activity/startpass.go',//开始闯关
					type:'POST',
					data:{
						uid:user.name
					},
					success:function(xml){
						remove_alert();
						var R = $(xml).find('Resp');
						var c = R.attr('code');
						var d = R.attr('desc');
						if(c == 0){
							$("#fhz_btn,#again").hide();
							gameView();
						}else{
							if(d.indexOf('机会已用完')>=0){
								D.alert(d,function(){
									window.location.reload();
								},'退出');
							}else{
								D.alert(d);
							}
						}
					}
				});
			});
		}
		Click();
	};

	//游戏结果判断方法
	var Single = function(e){
//		console.log('判断选择的和答案位置是否一致\n'+e+'='+l);
		if(e==l){//猜对了
			msgsState(levelCount,livesCount);
			levelCount++;
			//le.src="le"+levelCount+".png";
			//关卡加1
			N(levelCount);
		}else if(livesCount>0||e!=l){//猜错了
			msg.innerHTML = 'OUT（出局）了，悲剧呀！';
			again.setAttribute("style","display:block");
			setTimeout(A,.3e3);
		}
	};
	//添加鼠标点击事件
	var canvasOnclick=function(e){
//		console.log("el"+e+l);
//		console.log("cards:"+cards[1]);
		if(e==l){
			imageSprite.src = cards[0];
		}else {
			imageSprite.src = cards[1];
		};
//		console.log(imageSprite);
		if(e==-1){
			E.coin.draw(imageSprite);
			Single(e);
		}
		if(e==0){
			E.coin1.draw(imageSprite);
			Single(e);
		}
		if(e==1){
			E.coin2.draw(imageSprite);
			Single(e);
		}

	};
	var botton1 = $("#b1");
	var botton2 = $("#b2");
	var botton3 = $("#b3");
	function Click(){
		$("#b1").bind(start_ev,function(){
			canvasOnclick(-1);
			unbind();
		});
		$("#b2").bind(start_ev,function(){
			canvasOnclick(0);
			unbind();	
		});
		$("#b3").bind(start_ev,function(){
			canvasOnclick(1);
			unbind();
		});
	}
	function unbind(){
		botton1.off();
		botton2.off();
		botton3.off();
	}
};
var deg2rad = function(e) {
	return e * Math.PI / 180;
};