var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag1, tag2, fn1){
			$('#popup3 p').html(msg);
			tag1 && $('#popup3 a:eq(0)').html(tag1) || $('#popup3 a:eq(0)').html('取消');
			tag2 && $('#popup3 a:eq(1)').html(tag2) || $('#popup3 a:eq(1)').html('确定');
			$('.zhezhao, #popup3').show();
			$('#popup3 a:eq(0)').off().bind('click',function(){//取消
				if(typeof(fn1) == "function"){fn1();}
				$('.zhezhao, #popup3').hide();
			});
			$('#popup3 a:eq(1)').off().bind('click',function(){//确定
				if(typeof(fn) == "function"){fn();}
				$('.zhezhao, #popup3').hide();
			});
		},
		confirm:function(msg, fn, tag1, tag2, fn1){
			$('#popup2 p').html(msg);
			tag1 && $('.qxbtn a:eq(0)').html(tag1) || $('.qxbtn a:eq(0)').html('取消');
			tag2 && $('.qxbtn a:eq(1)').html(tag2) || $('.qxbtn a:eq(1)').html('确定');
			$('.zhezhao, #popup2').show();
			$('.qxbtn a:eq(0)').off().bind('click',function(){//取消
				if(typeof(fn1) == "function"){fn1();}
				$('.zhezhao, #popup2').hide();
			});
			$('.qxbtn a:eq(1)').off().bind('click',function(){//确定
				if(typeof(fn) == "function"){fn();}
				$('.zhezhao, #popup2').hide();
			});
		},
		confirm_login:function(fn, tag1, tag2, fn1){
			tag1 && $('#popup a:eq(0)').html(tag1) || $('#popup a:eq(0)').html('取消');
			tag2 && $('#popup a:eq(1)').html(tag2) || $('#popup a:eq(1)').html('确定');
			$('.zhezhao, #popup').show();
			$('#popup a:eq(0)').off().bind('click',function(){//取消
				if(typeof(fn1) == "function"){fn1();}
				$('.zhezhao, #popup').hide();
			});
			$('#popup a:eq(1)').off().bind('click',function(){//确定
				if(typeof(fn) == "function"){fn();}
				$('.zhezhao, #popup').hide();
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
		}, 2000);
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

var user = {
		mobileno:"",

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


var from = location.search.getParam("from")
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

var bindEvent=function(){
	$("input").bind("click",function(){
		var value = $(this).val();
		if(value == "请输入您的手机号" || value == "输入验证码"){
			$(this).val("");
		}
	});
	//开售提醒手机号
	$("#btn").off().bind('click',function(){
		var tel = $("#tel").val();
		var re = /^[0-9]*$/;
		if(tel.length!=11 || !re.test(tel)){
			alert('请输入正确的手机号码！');
			$("#tel").focus();
		}else{
			user.mobileno = $("#tel").val();
			submit();
		}
	});
}

$(function(){
	bindEvent();
	//tokenLogin();
	
	if(from &&  (from=="android" || from=="ANDROID")){
		tokenLogin();
	}else if(from &&  (from=="WP" || from=="wp")){
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
	 					var url='register.html';
	 					//4g
	 				    window.location.href = url;
	 					
	 				},'登录','注册',function(){
	 					var url='login.html';
	 					window.location.href = url;
	 				});
	 			}
	        }
		});
	}
	
	
})

/***
$(function(){
	$.ajax({
        url: "/user/mchklogin.go",
        type: "POST", 
        success:function (data){
     	    var R = $(data).find("Resp");
 			var code = R.attr("code");
 			if (code == "10001") {//已登录
 				//bind_input();
 				alert("登录")
 			}else{
 				alert("未登录")
 				setTimeout(toLogin,1000);
 			}
        }
	});
});
***/

//提交
var submit = function() {
	$.ajax({
		url:'/activity/submitnoticephone.go',
		type:'POST',
		data:{
			mobileno:user.mobileno
		},
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			var d = R.attr('desc');
			var r = R.find('row');
			var newmobileno = r.attr('newmobileno');//新号码
			if(c == 0){//新老手机号一致
				window.location.href = "great.html";
				
			}else if(c == 1){//未登录
				tokenLogin();
				
			}else if(c == 2){//未绑定手机号
				D.alert("萌萌哒！ 您账户将绑定的手机号<span>为 "+$("#tel").val()+"？</span>",function(){
					$(".text").hide();
					$(".text2").show();
					$("#bdtel").val($("#tel").val());
					yzm();
				}),"取消","确定";
				
			}else if(c == 3){//新老手机号不一致
				D.confirm('您已绑定的手机号与当前提交的开售通知电话不一致，<span>是否修改您绑定的手机号为 <strong>'+$("#tel").val()+'</strong></span>?',function(){
					$(".text3").show().prevUntil("img").hide();
					$("#newtel").val($("#tel").val());
					yzm();
				},'取消','确认修改');
			}
		}
	});
};
var wait=60;
var yzm = function(){
	function countDown(){
		if (wait == 0) {		
			$(".input span").html("重新发送");
			wait = 60;
		} else {
			$(".input span").html("重新发送(" + wait + ")");
			wait--;
			setTimeout(function() {
				countDown();
			}, 1000);
		}
	}
	//输入手机号发送验证码(第一步：根据手机号发送验证码)
	$("#yzm").next().bind("click",function(){
		if($("#bdtel").val()==""){
			alert('请输入有效的手机号码！');
			return false;
		}
		var phoneValue = $("#bdtel").val();
		alert('提交中', 'load');
		$.ajax({
			url:'/user/userbind.go?flag=1&newValue='+phoneValue,
			type:"POST",
			success:function(xml) {
				remove_alert();
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code=="0"){
					countDown();
				}else{
					alert(desc);
				}
			}
		});
	});
	//重新发送验证码
	function zeroDownAjax(){
		$.ajax({
			url : '/user/userbind.go',
			dataType : "xml",
			data:"flag=1&newValue="+$("#phone").val(),
			success : function(xml) {
				var R = $(xml).find("Resp");
				var desc = $(R).attr("desc");
				alert(desc);
			}
		});
	}
	//提交(第二步:根据输入的验证码提交)
	$("#bdbtn").bind("click",function(){
		var yzmValue = $("#yzm").val().replace("输入验证码","");
		if(yzmValue==""){
			alert('请输入验证码！');
			return false;
		}
		var data="flag=1&yzm="+yzmValue;

		alert('提交中', 'load');
		$.ajax({
			url : '/user/userbindyz.go',
			type : "POST",
			dataType : "xml",
			data:data,
			success : function(xml) {
				remove_alert();
				var R = $(xml).find("Resp");
				var code = $(R).attr("code");
				var desc = $(R).attr("desc");
				if(code=="0"){
					window.location.href = "great.html";
				}else{
					alert(desc);
				}
			}
		});
	});
	//修改绑定，发送验证码
	$("#yzm2").next().bind("click",function(){
		var oldValue = $("#tel2").val();
		var newValue = $("#newtel").val();
		if(oldValue==""||newValue==""){
			alert('请输入正确的手机号码！');
			return false;
		}
		$.ajax({
			url : '/user/userbind.go',
			type : "POST",
			dataType : "xml",
			data:"flag=1&newValue="+$("#newtel").val()+"&mobileNo="+oldValue,
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code=="0"){
					countDown();
				}else {
					alert(desc);
				}
			}
		});
	});
	//修改绑定
	$("#upbtn").bind("click",function(){
		var yzmValue = $("#yzm2").val().replace("输入验证码","");
		if(yzmValue==""){
			alert('请输入验证码！');
			return false;
		}
		var data="flag=1&yzm="+yzmValue;
		alert('提交中', 'load');
		$.ajax({
			url : '/user/userbindyz.go',
			type : "POST",
			dataType : "xml",
			data:data,
			success : function(xml) {
				remove_alert();
				var R = $(xml).find("Resp");
				var code = $(R).attr("code");
				var desc = $(R).attr("desc");
				if(code=="0"){
					window.location.href = "great.html";
				}else{
					alert(desc);
				}
			}
		});
	});
};
