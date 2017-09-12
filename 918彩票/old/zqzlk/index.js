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
var CP = {};
CP.MobileVer = (function ($) {
	//var tag = location.search.getParam('tag') || false;//ios 判断版本 不为false调他们的充值页面 否则弹窗提示
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
	
	var from = location.search.getParam("from");
	
	var g={
			"1":"英超",
			"2":"意甲",
			"3":"德甲",
			"4":"法甲",
			"5":"西甲",
			"135":"欧冠",
			"10":"足球资料库",
			"19":"瑞士超",
			"25":"葡超",
			"59":"瑞典甲",
			"63":"法乙",
			"64":"德乙",
			"66":"英冠",
			"72":"英甲",
			"185":"欧罗巴",
			"263":"解放者杯",
			"367":"荷甲",
			"368":"荷乙",
			"381":"苏超",
			"690":"中超",
			"693":"日联",
			"703":"日乙",
			"843":"美联",
			"844":"巴甲",
			"845":"阿甲",
			"846":"智甲",
			"877":"墨联"
	}
	
	var init=function(){
		toggleTitle();
		bindEvent();
	};
	
	var bindEvent = function(){
		$(".all a").bind("click",function(){
			var v=$(this).attr("v");
			if(v !=135 && v != 185 && v != 263){
				if(CP.MobileVer.android){//android
					if(from && from=="androidapp"){
						try {
							window.location.href="/app/zqzlk/jif.html?id="+v+"&from="+from;
							window.caiyiandroid.clickAndroid(9, g[v]);//跳转
						} catch (e){
							//window.location.href = url;
						}
					}else{
						window.location.href="/app/zqzlk/jif.html?id="+v;
					}
					
				}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
					if(from && from=="iosapp"){
						try {
							window.location.href="/app/zqzlk/jif.html?id="+v+"&from="+from;
							WebViewJavascriptBridge.callHandler('callbackios_01',g[v]);
						} catch (e){
							//window.location.href = url;
						}
					}else{
						window.location.href="/app/zqzlk/jif.html?id="+v;
					}
					
				}else{//4g
					window.location.href="/app/zqzlk/jif.html?id="+v;
					return;
				}
			}else{
				if(CP.MobileVer.android){//android
					if(from && from=="androidapp"){
						try {
							window.location.href="/app/zqzlk/league.html?id="+v+"&from="+from;
							window.caiyiandroid.clickAndroid(9, g[v]);//跳转
						} catch (e){
							//window.location.href = url;
						}
					}else{
						window.location.href="/app/zqzlk/league.html?id="+v;
					}
					
				}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
					if(from && from=="iosapp"){
						try {
							window.location.href="/app/zqzlk/league.html?id="+v+"&from="+from;
							WebViewJavascriptBridge.callHandler('callbackios_01',g[v]);
						} catch (e){
							//window.location.href = url;
						}
					}else{
						window.location.href="/app/zqzlk/league.html?id="+v;
					}
				}else{//4g
					window.location.href="/app/zqzlk/league.html?id="+v;
					return;
				}
			}
			
		});
		
		/***
		$(".all a:last").bind("click",function(){
			var v=$(this).attr("v");
			if(CP.MobileVer.android){//android
				if(from && from=="androidapp"){
					try {
						window.location.href="/app/zqzlk/league.html?id="+v+"&from="+from;
						window.caiyiandroid.clickAndroid(9, g[v]);//跳转
					} catch (e){
						//window.location.href = url;
					}
				}else{
					window.location.href="/app/zqzlk/league.html?id="+v;
				}
				
			}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
				if(from && from=="iosapp"){
					try {
						window.location.href="/app/zqzlk/league.html?id="+v+"&from="+from;
						WebViewJavascriptBridge.callHandler('callbackios_01',g[v]);
					} catch (e){
						//window.location.href = url;
					}
				}else{
					window.location.href="/app/zqzlk/league.html?id="+v;
				}
			}else{//4g
				window.location.href="/app/zqzlk/league.html?id="+v;
				return;
			}
		});
		***/
	};
	
	
	
	var toggleTitle=function(){
		if(CP.MobileVer.android){//android
			if(from && from=="androidapp"){
				try {
					$(".tzHeader").hide();
					//window.caiyiandroid.clickAndroid(9, g["10"]);//跳转
				} catch (e){
					//window.location.href = url;
				}
			}else{
				$(".tzHeader").show();
			}
		}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
			if(from && from=="iosapp"){
				try {
					//window.location.href="/app/zqzlk/jif.html?id="+v+"&from="+from;
					//WebViewJavascriptBridge.callHandler('callbackios_01',g[v]);
					$(".tzHeader").hide();
				} catch (e){
					//window.location.href = url;
				}
			}else{
				$(".tzHeader").show();
			}
		}else{//4g
			return;
		}
	};
	
	return {
		init:init
	};
})()
CP.ZLK.init();
$(function(){
	
})