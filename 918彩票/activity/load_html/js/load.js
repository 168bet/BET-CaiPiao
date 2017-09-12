var CP={};
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


var XHC={};
XHC.loadPage=(function(){
	var init = function(){
		if(CP.MobileVer.android){//android
			try {
				$(".load_btn").show();
				$(".load_btn a.load_btn_a").addClass("load_btn_android");
				$(".load_btn a.load_btn_a").removeClass("load_btn_iphone");
				$(".load_btn a.load_btn_a").attr("href","http://www.baidu.com");
				$(".load_btn a.load_btn_a span.load_span").html("Android版下载");
			} catch (e){
				
			}
		}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
			try {
				$(".load_btn").show();
				$(".load_btn a.load_btn_a").addClass("load_btn_iphone");
				$(".load_btn a.load_btn_a").removeClass("load_btn_android");
				$(".load_btn a.load_btn_a").attr("href","http://www.hao123.com")
				$(".load_btn a.load_btn_a span.load_span").html("iPhone版下载");
			} catch (e){
				
			}
		}else if(CP.MobileVer.wp){//ios
			try {
				
			} catch (e){
				
			}
		}else{//4g
			$(".load_btn").show();
		}
	};
	
	
	return {
		init:init
	}
	
})();

$(function(){
	XHC.loadPage.init();
})