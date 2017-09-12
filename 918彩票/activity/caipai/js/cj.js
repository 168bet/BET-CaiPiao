var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag){
			if(msg.length>20){
				$('#calert p').removeClass();
			}else{
				$('#calert p').addClass('cg_cs');
			}
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
CP.CJ = (function(){
	var click=false;
	var g = {
			login:true,//是否登录
			chance_draw : 0,//可抽次数
			point : 0,//当前彩豆
			money:0,//可兑换金额
			nickid:''//用户名
	};
	var o = {
			getStrLen : function(str) {// 含中文的字符串长度
				var len = 0;
				var cnstrCount = 0;
				for ( var i = 0; i < str.length; i++) {
					if (str.charCodeAt(i) > 255)
						cnstrCount = cnstrCount + 1;
				}
				len = str.length + cnstrCount;
				return len;
			},
			cs: function(){//填写次数
				var info = '';
				if(o.getStrLen(g.nickid)>12){
					info = g.nickid+'，您今日可抽奖<span>'+g.chance_draw+'</span>次，目前可兑奖彩豆为'+g.point;
				}else{
					info = g.nickid+'，您今日可抽奖<span>'+g.chance_draw+'</span>次<br>目前可兑奖彩豆为'+g.point;
				}
				$('#detail').html(info);
			},
			toLogin : function(){
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
			}
	};
	var lottery={
			index:-1, //当前转动到哪个位置，起点位置
			count:0, //总共有多少个位置
			timer:0, //setTimeout的ID，用clearTimeout清除
			speed:20, //初始转动速度
			times:0, //转动次数
			cycle:50, //转动基本次数：即至少需要转动多少次再进入抽奖环节
			prize:-1, //中奖位置
			init:function(id){
				if ($("#"+id).find(".lottery-unit").length>0) {
					$lottery = $("#"+id);
					$units = $lottery.find(".lottery-unit");
					this.obj = $lottery;
					this.count = $units.length;
					$lottery.find(".lottery-unit-"+this.index).addClass("cpcj_red");
				};
			},
			roll:function(){
				var index = this.index;
				var count = this.count;
				var lottery = this.obj;
				$(lottery).find(".lottery-unit-"+index).removeClass("cpcj_red");
				index += 1;
				if (index>count-1) {
					index = 0;
				};
				$(lottery).find(".lottery-unit-"+index).addClass("cpcj_red");
				this.index=index;
				return false;
			},
			stop:function(index){
				this.prize=index;
				return false;
			}
	};
	var roll = function(){
		lottery.times += 1;
		lottery.roll();
		if (lottery.times > lottery.cycle+10 && lottery.prize==lottery.index) {
			clearTimeout(lottery.timer);//停止
			lottery.prize=-1;//中奖位置
			lottery.times=0;//转动次数
			setTimeout(function(){
				click=false;
				D.alert('恭喜你获得'+$('.cpcj_red').html());
				o.cs();
			},.5e3);
		}else{
			if (lottery.times<lottery.cycle) {
				lottery.speed -= 10;
			}
//			else if(lottery.times==lottery.cycle) {
//				var index = Math.random()*(lottery.count)|0;
//				lottery.prize = index;
//			}
			else{
				if (lottery.times > lottery.cycle+10 && ((lottery.prize==0 && lottery.index==7) || lottery.prize==lottery.index+1)) {
					lottery.speed += 110;
				}else{
					lottery.speed += 20;
				}
			}
			if (lottery.speed<50) {
				lottery.speed=50;
			};
//			console.log(lottery.times+'^^^^^^'+lottery.speed+'^^^^^^^'+lottery.prize+'^^^^^^^'+lottery.index);
			lottery.timer = setTimeout(roll,lottery.speed);
		}
		return false;
	}
	var bind = function(){
		$("#lottery .cpcj_wyhb").click(function(){
			if (click) {
				return false;
			}else{
				alert('加载中...','load');
				$.ajax({//开始抽奖
					url:'/activity/startdraw.go',
					type:'GET',
					success:function(xml){
						remove_alert();
						var R = $(xml).find('Resp');
						var c = R.attr('code');
						var d = R.attr('desc');
						if(c == 0){
							var r = R.find('row');
							var result = r.attr('result');
							g.chance_draw = r.attr('chance_draw');
							g.point = r.attr('point');
							g.money = r.attr('money');
							var ret = {'1441':'6',
										'1442':'9',
										'1443':'7',
										'1444':'0',
										'1445':'4',
										'1446':'2',
										'1447':'5',
										'1001':'8',
										'1003':'1',
										'1005':'3'}[result];
							lottery.prize = ret;
							lottery.speed=200;
							roll();
							click=true;
							return false;
						}else if(c == 1){//未登录
							o.toLogin();
						}else{
							if(d.indexOf('赶快去闯关')>=0){
								D.confirm(d,function(){
									location.href='index.html';
								},'关闭','去闯关');
							}else{
								D.alert(d)
							}
						}
					}
				});
			}
		});
		
		$('#exchange').bind('click',function(){
			if(!g.login){
				o.toLogin();
			}else{
				if(g.point<20){
					D.alert('萌萌哒，您目前的彩豆暂不足兑换一元红包哦～')
				}else{
					D.confirm('您目前的彩豆可兑换'+g.money+'元红包，确认兑换？',function(){
						$.ajax({//彩豆兑换
							url:'/activity/pointexchange.go',
							type:'GET',
							success:function(xml){
								var R = $(xml).find('Resp');
								var c = R.attr('code');
								var d = R.attr('desc');
								if(c == 0){
									var r = R.find('row');
									g.point = r.attr('point');
									g.money = r.attr('money');
									o.cs();
									var redpacket = r.attr('redpacket');//已兑换红包金额
									D.alert('你已成功兑换'+redpacket+'元红包')
								}else{
									D.alert(d)
								}
							}
						});
					},'取消','确认');
				}
			}
		});
		$('.cpcj_hqhb').bind('click',function(){//如何获取抽奖机会
			$('#clue,#mask').show();
		});
		$('.cpcj_hqhb ').bind('click',function(){//如何获取抽奖机会
			$('#clue,#mask').show();
		});
		$('.clock').bind('click', function(){//关闭弹窗
			$('#mask').hide();
			$('.clock').parent().hide();
		});
		$('#login').bind('click', function(){//登录
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
		$('#enroll').bind('click', function(){//注册
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
		});
	}
	var init = function(){
		alert('加载中...','load');
		$.ajax({//查询用户抽奖信息
			url:'/activity/drawhomepage.go',
			type:'GET',
			success:function(xml){
				remove_alert();
				var R = $(xml).find('Resp');
				var c = R.attr('code');
				var d = R.attr('desc');
				if(c == 0){
					$('.cpcj_cjcs').show();
					$('.cpcj_dlzc').hide();
					var r = R.find('row');
					g.chance_draw = r.attr('chance_draw');//可抽奖次数
					g.point = r.attr('point');//当前可用彩豆数
					g.money = r.attr('money');//可兑换红包金额
					g.nickid = r.attr('nickid');
					o.cs();
				}else if(c == 1){//未登录
					$('.cpcj_cjcs').hide();
					$('.cpcj_dlzc').show();
					g.login = false;
				}else{
					D.alert(d);
				}
			},error:function(){
				remove_alert();
				alert('网络异常，刷新重试');
			}
		});
		lottery.init('lottery');
		bind();
		localStorage.setItem('huodong',window.location.href);
	}
	init();
})();