var CP={};
/**
 * 定义全局事件
 */
var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
var end_ev = ('ontouchend' in window ) ? 'touchend' : 'mouseup';
var move_ev = ('ontouchend' in window ) ? 'touchmove' : 'mousemove';

var o = {
	cptype:'',
	momey:'',
	cptime:'',
	usermomey:'',//余额
	ipacketmoney:''//红包余额
}

var g = {
		'zhushu' : 0,//注数
		'beishu' : 1,//倍数
		'qishu' : 1,//追号期数
		'totalMoney' : 0,//投注总金额
		'zhuijia' : 2,//是否追加 追加为3 不追加为2
		'codes' : '',//投注号码
		'buyType' : 1,//1:自购 2:合买3:追号
		'loty_id' : '', //彩种id
		'qihao_id' : '',//当前期号
		'hmMoney' : '',//合买应付金额
		'comboid' : ''//套餐
	};

/**
 * @description 获取手机系统
 * @return {object}
 * @example browser.versions.android;
 * @memberOf CP
 */
var browser={
	    versions:function(){
	        var u = navigator.userAgent, app = navigator.appVersion;
	        return {
	        	trident: u.indexOf('Trident') > -1, //IE内核
	            presto: u.indexOf('Presto') > -1, //opera内核
	            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
	            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,//火狐内核
	            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
	            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
	            android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1 || u.indexOf('Linux') > -1, //android终端
	        };
	    }(),
}

//倒计时
var ShowCountDown = function (year,month,day,divname) { 
        var now = new Date(); 
        var endDate = new Date(year, month-1, day); 
        var leftTime=endDate.getTime()-now.getTime(); 
        var leftsecond = parseInt(leftTime/1000); 
        //var day1=parseInt(leftsecond/(24*60*60*6)); 
        var day1=Math.floor(leftsecond/(60*60*24)); 
        var hour=Math.floor((leftsecond-day1*24*60*60)/3600); 
        var minute=Math.floor((leftsecond-day1*24*60*60-hour*3600)/60); 
        var second=Math.floor(leftsecond-day1*24*60*60-hour*3600-minute*60); 
        var cc = divname ;
        cc.html("距离结束仅剩：<i>"+day1+"</i>天<i>"+hour+"</i>小时<i>"+minute+"</i>分<i>"+second+"</i>秒");
	} 
    var time = setInterval(function(){
        	ShowCountDown(2016,10,9,$(".gq_time"));   	
    } , 1000);
    /* 套餐活动数据 */
    var AC={
    	init :function(){
    		$.ajax({
    			url: '/activity/queryComboStatus.go',
    			type:'POST',
    			success:function(xml){
    				var R = $(xml).find('Resp');
    				var c = R.attr('code');
    				var sq =$(xml).find('row').eq(0);
    				var dt =$(xml).find('row').eq(1);
    				var sale1 = sq.attr('salePercent');
    				var sale2 = dt.attr('salePercent');
    				if(c == '0'){
    					$(".gq_jdt:eq(0) span").html('已售'+sale1)
    					$(".gq_jdt:eq(1) span").html('已售'+sale2)
    					$(".gq_progress:eq(0) div").css({"width":sale1})
    					$(".gq_progress:eq(1) div").css({"width":sale2})
    					//g.totalMoney = sq.attr('comboRealPrice');
    					if(sq.attr("saleStatus") == 'N'){
    						$(".gq_btn").eq(0).html("已售罄");
    					}else if(sq.attr("overStatus") == 'Y'){
    						$(".gq_btn").eq(0).html("已截止");
    						clearInterval(time);
    						$(".gq_time").html("距离结束仅剩：<i>0</i>天<i>0</i>小时<i>0</i>分<i>0</i>秒");
    					}
    					if(dt.attr("saleStatus") == 'N'){
    						$(".gq_btn").eq(1).html("已售罄");
    					}else if(dt.attr("overStatus") == 'Y'){
    						$(".gq_btn").eq(1).html("已截止");
    						clearInterval(time);
    						$(".gq_time").html("距离结束仅剩：<i>0</i>天<i>0</i>小时<i>0</i>分<i>0</i>秒");
    					}
    				}
    			}
    		})
    	}
    }
    AC.init()

//原生接口
CP.AppJiek = {
    appLogin:function(){//原生登录接口
    	if(browser.versions.android){//登录调用原生接口
			window.caiyiandroid.clickAndroid(3, '');
		}
		if(browser.versions.ios){
			WebViewJavascriptBridge.callHandler('clickIosLogin');
		}
    },
    moBind:function(){
    	if(browser.versions.android){//绑定手机号调用原生接口
			window.caiyiandroid.clickAndroid(5,'');
		}
		if(browser.versions.ios){
			WebViewJavascriptBridge.callHandler('callBackIOS','1');
		}
    },
    cardBind:function(){
    	if(browser.versions.android){//绑定身份证调用原生接口
			window.caiyiandroid.clickAndroid(6,'');
		}
		if(browser.versions.ios){
			WebViewJavascriptBridge.callHandler('callBackIOS','2');
		}
    },
    ChargeMoney:function(){
    	if(browser.versions.android){
			window.caiyiandroid.clickAndroid(7, '');
		}
		if(browser.versions.ios){
			WebViewJavascriptBridge.callHandler('callBackIOS','3');
		}
    }
    		
}
    

//公共弹出层alert

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
//引导窗口
var con = function(a){
	a == 0?$('#queren .que_ss').html("身份证"):$('#queren .que_ss').html("手机号")
	$("#click_bg").show();
	$("#queren").show();
	$('#queren .ok').one(start_ev,function(){
		$('#click_bg').hide();
		$("#queren").hide();
		a == 0? CP.AppJiek.cardBind(): CP.AppJiek.moBind();
	});
};

//
var appRet = function(){
	var config = {
            /*scheme:必须*/
            scheme_IOS: 'caiyi9188Lottery15661://',
            scheme_Adr: 'caiyi://mobilelottery',
            download_url: 'http://t.9188.com  /',
            timeout: 1000
        };
	var now = Date.now();
    var ifr = document.createElement('iframe');
    browser.versions.ios ? ifr.src =config.scheme_IOS :ifr.src= config.scheme_Adr;
    ifr.style.display = 'none';
    document.body.appendChild(ifr);
    alert("参与活动，需先下载9188彩票客户端")
    var t = setTimeout(function() {
        var endTime = Date.now();
        if (Date.now() - now < config.timeout + 800) {
        	document.body.removeChild(ifr);
            window.location.href= config.download_url;
        } else {    
        }
    }, config.timeout);
}
$(".gq_btn:eq(0)").on("click" , function(){//点击双色球购买
	var type =$(this).attr("type");
	type ==	"ssq"?  g.comboid ='81' : g.comboid ='82' ;
		CP.Checked(0,"81");
})
$(".gq_btn:eq(1)").on("click" , function(){//点击大乐透购买
	var appCheked = location.href.split("&")[3];
	var type =$(this).attr("type");
	type ==	"ssq"?  g.comboid ='81' : g.comboid ='82' ;
//	if(appCheked){
		CP.Checked(1,"82");
//	}else{
//		appRet();
//	}
		
})
/**
 * @description 获取数据类型
 * @author lilian
 * @return {String} 如：null
 */
CP.getType = function (o) {
	var _t;
	return ((_t = typeof(o)) == "object" ? o == null && "null" || Object.prototype.toString.call(o).slice(8, -1) : _t).toLowerCase();
};
//检查用户是否登录
CP.Checked = function(i,type){
	var allcookies = document.cookie;
	if(allcookies.indexOf('TOKEN')!='-1'){
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
//		alert(token+" "+appid);
		setTimeout(function(){
		$.ajax({
			url:'/user/swaplogin.go',
			data:{
				logintype:'1',
				accesstoken:token,
				appid:appid
			},
			type:'POST',
			success:function(){
			$.ajax({
				url:'/user/query.go?flag=2',
				type:'GET',
				dataType:'xml',
				success:function(xml){
					var R = $(xml).find('Resp');
					var c = R.attr('code');
					var isBindIdCard = R.find('row').attr('idcard');
					var isBindMobile = R.find('row').attr('mobbind');
					//alert(isBindIdCard+"~~"+isBindMobile)
					if(c == '0'){
						o.usermoney = R.attr('usermoeny');//余额
						o.ipacketmoney = R.attr('ipacketmoney');//红包余额
						var t = $(".gq_btn").eq(i).attr("type");
						if(!isBindIdCard){
							con(0)
						}else if(isBindMobile != '1'){
							con(1)
						}else if(t =='ssq'){
							window.location.href="/activity/gp16/ssq.html?type="+t
						}else if(t =='dlt' ){
							window.location.href="/activity/gp16/dlt.html?type="+t
						}
					}else{
						alert("购买套餐前请先登录账户")
						CP.AppJiek.appLogin();
					}
				},error : function () {
					remove_alert();
					alert('网络异常请刷新重试');
				}
			})
		}
	})},300);
}else{
	$.ajax({
		url:'/user/query.go?flag=2',
		type:'POST',
		dataType:'xml',
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			var isBindIdCard = R.find('row').attr('idcard');
			var isBindMobile = R.find('row').attr('mobbind');
			if(c == '0'){
				o.usermoney = R.attr('usermoeny');//余额
				//o.ipacketmoney = R.attr('ipacketmoney');//红包余额
				var t = $(".gq_btn").eq(i).attr("type");
				if(!isBindIdCard){//1身份证已绑定
					con(0)
					
				}else if(isBindMobile != '1'){//1手机号已绑定
					con(1)
				}else if(t =='ssq'){
					window.location.href="/activity/gp16/ssq.html?type="+t
				}else if(t =='dlt' ){
					window.location.href="/activity/gp16/dlt.html?type="+t
				}
			}else{
				alert("购买套餐前请先登录账户");
				CP.AppJiek.appLogin();
			}
		},error : function () {
			remove_alert();
			alert('网络异常请刷新重试');
		}
	})
}
}
	
//判断用户是否购买
CP.Buyju=function(a,b){
	var allcookies = document.cookie;
	if(allcookies.indexOf('TOKEN')!='-1'){
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
		setTimeout(function(){
		$.ajax({
			url:'/user/swaplogin.go',
			data:{
				logintype:'1',
				accesstoken:token,
				appid:appid
			},
			type:'POST',
		success:function(){
		$.ajax({
		url:'/activity/buyComboStatus.go',
		type:'GET',
		data:{
			fflag: a
		},
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			var at = $(".gq_btn").eq(b).html();
			if(at !="已售罄" && at !="已截止"){
				$(".gq_btn").eq(b).removeAttr("disabled");
			}
			if(c == '1000'){
				$(".gq_btn").eq(b).html("已购");
				if(!$(".gq_btn").eq(b).attr("disabled")){
					$(".gq_btn").eq(b).attr("disabled","disabled");
				}
			}
		},error : function () {
			remove_alert();
			alert('网络异常请刷新重试');
		}
	});
	}
	})},300);
}else{
	$.ajax({
		url:'/activity/buyComboStatus.go',
		type:'GET',
		data:{
			fflag: a
		},
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			var at = $(".gq_btn").eq(b).html();
			if(at !="已售罄" && at !="已截止"){
				$(".gq_btn").eq(b).removeAttr("disabled");
			}
			if(c == '1000'){
				$(".gq_btn").eq(b).html("已购");
				if(!$(".gq_btn").eq(b).attr("disabled")){
					$(".gq_btn").eq(b).attr("disabled","disabled");
				}
			}
		},error : function () {
			remove_alert();
			alert('网络异常请刷新重试');
		}
	});
}
}

CP.info=function(fn,fn2){
		var t = {};
		$.ajax({
			url:'/user/query.go?flag=6',
			type:'GET',
			success:function(xml){
				var R = $(xml).find('Resp');
				var c = R.attr('code');
				if(c == '0'){
					var r = R.find('row');
					t.usermoney = r.attr('usermoeny');//余额
					t.ipacketmoney = r.attr('ipacketmoney');//红包余额
					fn(t);
				}else{
	                if(typeof fn2 == "function"){
	                	fn2()
	                }else{
	                	if(browser.versions.android){
							window.caiyiandroid.clickAndroid(3, '');
						}
						if(browser.versions.ios){
							WebViewJavascriptBridge.callHandler('clickIosLogin');
						}
	                }
				}
			},error : function () {
				remove_alert();
				alert('网络异常请刷新重试');
			}
		});
}
/*
 * 触屏版touch插件
 * @param {Object} [children:".ball",fun:function(){}];
 $("body").Touch(function(){
 $('#lot_title').html('你好')
 })
 */
$.fn.Touch = function (obj) {
	var moveEvent = move_ev;
	if (CP.getType(obj) == 'function') {
		obj.fun = obj;
	}

	this.each(function () {
		var $dom = $(this).eq(0);//转为dom对象
		var ifMove = false;
		var t = 0;
		$dom.on(moveEvent, function () {
			ifMove = true;
			clearTimeout(t);
			t = setTimeout(function () {
				ifMove = false
			}, 250);
		})
		if (obj.children) {
			$dom.on(end_ev, obj.children, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return false;
				}
				obj.fun.call(this, this);
			})
		}
		else {
			$dom.on(end_ev, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return 0;
				}
				obj.fun.apply(this, [this, e]);
			})
		}
	});
};

//计算时间间隔
//1分钟内不可重复投注相同内容
CP.timeCell = function(t){
	var da =new Date();
	var time = da.getTime();
	var incoti = {"codes":g.codes,"time":time};
	var lo = localStorage.getItem(t);
	if(lo){
		var tre = time - JSON.parse(lo).time ;
		if(tre/60000 < 1 && JSON.parse(lo).codes == g.codes){
			alert("1分钟内不可重复投注相同内容");
			return false
		}else{
			localStorage.setItem(t ,JSON.stringify(incoti));
			return true
		}
	}else{
		localStorage.setItem(t ,JSON.stringify(incoti));
		return true
	}
}

/*
 * 弹窗类
 */
CP.Popup = {
		/*
		 * 购买弹窗
		 */
		buybox : function(options){

			var o = {//弹窗的参数初始化
					gid:           '',//彩种id 不可空
					cMoney:        '',//需支付金额 不可空
					bonus:         '',//理论奖金
					usermoney:     '',//账户余额 不可空
					ipacketmoney:  '',//红包余额
					payPara:       '', //投注参数
					cupacketid:    '',//红包id
					redpacket_money: ''//使用红包金额
			};
			var payData = {
					"comboid" : g.comboid,
					"gid" : g.loty_id,
					"codes"	: g.codes
			}
			if (options) {
				jQuery.extend(o, options);//后面补充前面不足
			} else {
				alert('参数获取异常！');
				return
			}
			if(!o.gid || !o.cMoney || !o.usermoney){
				alert('参数获取失败请刷新重试');
				return
			}
			var main = function(o){
				var tag = true;//是否充值的标识 默认去充值
				o.usermoney = parseFloat(o.usermoney);
				o.cMoney = parseFloat(o.cMoney);
				if (o.usermoney>=o.cMoney) {//余额不足的时候显示去充值
					tag = false;
					$('#buy_box .zfTrue a:eq(1)').hide().siblings().show();
				} else {
					$('#buy_box .zfTrue a:eq(2)').hide().siblings().show();
				}
				$('#buy_box').removeClass('zfpopCur');//默认隐藏红包列表层
				$('#buy_reveal p:eq(0) cite').html(o.cMoney+'元');//初始化投注金额
				if(o.bonus){//如果是竞彩显示奖金范围
					$('#buy_reveal p:eq(1)').hide();
				}else{
					$('#buy_reveal p:eq(1)').hide();
				}
				$('#buy_reveal p:eq(2) cite').html(o.usermoney+'元');//初始化余额
				$("#click_bg").show();
				$('#buy_box,#mask').show();//弹支付框
				$('#buy_hide').html('');//清空红包列表
				$('#buy_box').animate({'margin-top':'-'+$('#buy_box').height()/2+'px'});//使层垂直居中
				$('#buy_box').off('click.pop').on('click.pop','.zfTrue a:eq(0)',function(){//取消按钮
					$('#buy_box,#mask').hide();
					$("#click_bg").hide();
				}).on('click.pop','.zfTrue a:eq(1)',function(){//充值按钮
					CP.AppJiek.ChargeMoney();
					$('#buy_box,#mask').hide();
					$("#click_bg").hide();
					$('#buy_box,#mask').hide();
				}).on('click.pop','.zfTrue a:eq(2)',function(){//确定按钮
					o.cupacketid = '';o.redpacket_money = '';
					$("#click_bg").hide();
					if ($('#buy_hide').is(':visible') && $('#buy_hide div.cur').length) {
						if($('#buy_hide div.cur').attr('kymoney') != '0'){
							o.cupacketid = $('#buy_hide div.cur').attr('cptid');
							o.redpacket_money = $('#buy_hide div.cur').attr('kymoney');
						}
					}
					$('#buy_box,#mask').hide();
					console.log(o.fun);
					if(!o.fun){
						CP.Pay.init(o);//支付方法
					}else{
						var fun = o.fun.split('.');
						window[fun[0]][fun[1]][fun[2]](o);
					}
				})
			}
			if (o.usermoney>=o.cMoney) {//余额足的时候  
					$.ajax({
						url:'/user/yydbidcard.go',//是否登录
						type:'get',
						success:function(xml){
							var Resp = $(xml).find('Resp')
							if(Resp.attr('code') == '0'){
								var isBindIdCard = Resp.find('row').attr('isBindIdCard');
								var isBindMobile = Resp.find('row').attr('isBindMobile');
								if(isBindIdCard != '1'){//1身份证已绑定
									CP.AppJiek.cardBind();
								}
								if(isBindMobile != '1'){//1手机号已绑定
									CP.AppJiek.moBind();
								}
							}
							main(o);
						}
					})
					return;
			}
			main(o);
		}
};
//支付
CP.Pay = function () {
	var init = function (opt) {
		var opt_ = opt.payPara || {};
		var data = {};
			data = {
					"comboid":   opt_. comboid,//套餐
					"gid":     opt_.gid,//彩种编号
					"codes":    opt_.codes//号码
			};
		$.ajax({
			url: opt_.payUrl,
			type:'POST',
			data: data,
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
					if(CP.timeCell(t)){
						var projid = '';
						var r;
						r = R.find('row');
						projid = r.attr('tid');//方案编号
						var tr = {"codes":g.codes};
						localStorage.setItem("tr" ,JSON.stringify(tr));
						location.href='/#type=url&p=user/success.html?projid='+projid;
					}
				}else{
					alert(desc);
				}
			}
		});
	};
	return {
		init: init
	};
}();


$(function(){
	//页面刷新判断是否已购买
		CP.Buyju("81",0);
		CP.Buyju("82",1);
		var allcookies = document.cookie;
		if(allcookies.indexOf('TOKEN')!='-1'){
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
				}
			})
		}
})


function share() {
	$.ajax({
				url : '/requestService.go',
				type : 'POST',
				data : {
					action : 'getShareParam',
					shareurl : location.href
				},
				success : function(xml) {
					var R = $(xml).find('Resp');
					var r = R.find('row');
					var appId = r.attr('appId');
					var timestamp = r.attr('timestamp');
					var nonceStr = r.attr('nonceStr');
					var signature = r.attr('signature');
					wx.config({
						debug : false,// 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
						appId : appId, // 必填，公众号的唯一标识
						timestamp : timestamp, // 必填，生成签名的时间戳
						nonceStr : nonceStr, // 必填，生成签名的随机串
						signature : signature,// 必填，签名，见附录1
						jsApiList : [ 'onMenuShareTimeline',
								'onMenuShareAppMessage',
								'onMenuShareQQ', 'onMenuShareWeibo' ]
					// 必填，需要使用的JS接口列表，所有JS接口列表见附录2

					});
					wx.ready(function() {
								var title = '国庆双色球、大乐透套餐特惠'; // 分享标题
								var desc = '休假也不错过千万大奖，1.双色球、大乐透套餐特惠活动限时：即日起至2016年10月8日；2.活动期间，双色球，大乐透套餐各限售10000份，先到先得，售完即止；双色球、大乐透套餐，每人各只有一次购买机会'; // 分享描述
								var link = location.href; // 分享链接
								var imgUrl = 'http://5.9188.com /activity/gp16/img/banner.png'; // 分享图标
								var dataUrl = location.href;// 如果type是music或video，则要提供数据链接，默认为空

								wx.onMenuShareAppMessage({//分享给朋友
									title : title,
									desc : desc,
									link : link, // 分享链接
									imgUrl : imgUrl, // 分享图标
									type : 'link', // 分享类型,music、video或link，不填默认为link
									dataUrl : dataUrl, // 如果type是music或video，则要提供数据链接，默认为空
									success : function() {
										// 用户确认分享后执行的回调函数
									},
									cancel : function() {
										// 用户取消分享后执行的回调函数
									}
								});
								wx.onMenuShareTimeline({//分享到朋友圈
									title : title, // 分享标题
									link : link, // 分享链接
									imgUrl : imgUrl, // 分享图标
									success : function() {
										// 用户确认分享后执行的回调函数
									},
									cancel : function() {
										// 用户取消分享后执行的回调函数
									}
								});

								wx.onMenuShareQQ({//分享到QQ
									title : title, // 分享标题
									desc : desc, // 分享描述
									link : link, // 分享链接
									imgUrl : imgUrl, // 分享图标
									success : function() {
										// 用户确认分享后执行的回调函数
									},
									cancel : function() {
										// 用户取消分享后执行的回调函数
									}
								});

								wx.onMenuShareWeibo({//分享到腾讯微博
									title : title, // 分享标题
									desc : desc, // 分享描述
									link : link, // 分享链接
									imgUrl : imgUrl, // 分享图标
									success : function() {
										// 用户确认分享后执行的回调函数
									},
									cancel : function() {
										// 用户取消分享后执行的回调函数
									}
								});
								// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
							});

				}
			});
}
share();