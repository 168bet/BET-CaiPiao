var D={};
var D = {
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

var from = location.search.getParam("from");
var urlscheme = location.search.getParam("urlscheme");
var installed = location.search.getParam("installed");

if(from){
	localStorage.setItem("from", from);
}else{
	localStorage.setItem("from", "");
}

var init=function(){
	if(installed==1){
		$("#btn").html("打开");
	}else{
		$("#btn").html("下载");
	}
};
var opend=function(){
	if(from && (from=="android"||from=="ANDROID")){//检测android
		try {
			window.caiyiandroid.clickAndroid(11,"");//安卓打开客户端方法
		} catch (e){
			
		}
	}else if(from && (from=="ios"||from=="IOS")){//检测ios
		try {
			WebViewJavascriptBridge.callHandler('callbackios_02',urlscheme);
		} catch (e){
			
		}
	}
};

var toLogin = function(){
	D.confirm_login(function(){
		var url='register.html';
		if(from && from=="android"){//android
			try {
				window.caiyiandroid.clickAndroid(4, '');
			} catch (e){
				window.location.href = url;
			}
		}else if(from && from=="ios"){//ios
			try {
				WebViewJavascriptBridge.callHandler('clickIosRegister');
			} catch (e){
				window.location.href = url;
			}
		}
	},'登录','注册',function(){
		var url='login.html';
		if(from && from=="android"){//android
			try {
				window.caiyiandroid.clickAndroid(3, '');
			} catch (e){
				window.location.href = url;
			}
		}else if(from && from=="ios"){//ios
			try {
				WebViewJavascriptBridge.callHandler('clickIosLogin');
			} catch (e){
				window.location.href = url;
			}
		}
	});
};

//判断用户是否登录
var tokenLogin=function(){
	var allcookies = document.cookie;
	
	if(allcookies.indexOf('TOKEN')!='-1'){
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
								alert("登录")
								opend()
							}else{//未登录
								//location.href='login.html';
								alert("未登录")
								toLogin()
							}
							o.against();
						}
					});
				}
			});
		},.3e3);
	}else{
		$.ajax({
	        url: "/user/mchklogin.go",
	        type: "POST", 
	        success:function (data){
	     	    var R = $(data).find("Resp");
	 			var code = R.attr("code");
	 			if (code == "10001") {//已登录
	 				opend()
	 			}else{
	 				toLogin();
	 			}
	        }
		});
	}
};

$(function(){
	var bindEvent=function(){
		//下载
		$("#btn").bind("click",function(){
			if(installed==0){//下载
				if(from && (from=="android"||from=="ANDROID")){//android
					try {
						//window.caiyiandroid.clickAndroid(12,urlscheme);//安卓下载方法，参数url下载地址
						window.location.href="http://5.9188.com /h5game/blackjackclient/download/BlackJackClient-release-signed.apk"
					} catch (e){
						
					}
				}else if(from && (from=="ios"||from=="IOS")){//ios
					try {
						//调用IOS下载方法
						window.location.href = "http://5.9188.com /h5game/blackjack_1000737/pages/start.html?from=ios";
					} catch (e){
						
					}
				}else{//4g
					window.location.href="http://www.baidu.com"
				}
			}else{
				tokenLogin();
			}
		});
	};
	init();
	bindEvent();
});