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



var CP={};

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
var yqm = location.search.getParam("yqm");
CP.ZLK=(function(){
	var init=function(){
		loadCont();
		bindEvent();
	};
	
	var bindEvent=function(){
		$("#getReward").bind("click",function(){
			getReward();
		})
	}
	
	var loadCont=function(){
		if(yqm && yqm !=null){
			$("#yqm").html(yqm);
		}else{
			$("#yqm").html("");
		}
	};
	
	var getReward=function(){
		if(/android/i.test(navigator.userAgent)){
			window.location.href = "http://t.9188.com  ";
		}else if (/ipad|iphone|mac/i.test(navigator.userAgent)){
			window.location.href = "http://dwz.cn/F4uBp";
		}
	}
	
	return {
		init:init
	};
})();
$(function(){
	CP.ZLK.init();
})