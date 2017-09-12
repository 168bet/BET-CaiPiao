window.alert = function(msg){
	if(document.querySelectorAll('.alertBox').length){
		clearTimeout(window.alert.time);
		document.querySelector('.alertBox').remove();
	}
	var obj = document.createElement('div')
	obj.setAttribute('class', 'alertBox');
	obj.innerHTML = msg;
	document.body.appendChild(obj);
	window.alert.time = setTimeout(function () {
		document.querySelector('.alertBox').remove();
	}, 1500);
}
var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		confirm:function(msg,fn,c){
			$('#setCont').html(msg);
			//tag && $('#dConfirm div.zfTrue a:eq(0)').html(tag) || $('#dConfirm div.zfTrue a:eq(0)').html('确定');
			c && $("#setCl i").eq(1).removeClass();
			c && $("#setCl i").eq(1).addClass(c);
			$('.xryl_mask').show();
			$("#setC").show();
			$('body').addClass('noscroll')
			$('#setCl').click(function(){
				if(typeof(fn) == "function"){fn();}
				$('#setC').hide();
				$(".xryl_mask").hide();
				$('body').removeClass('noscroll')
			});
		}
};


var SHB = (function(){
	var getParam = function(name)
	{
	     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	     var r = window.location.search.substr(1).match(reg);
	     if(r!=null)return  unescape(r[2]); return null;
	}
	var g = {
			token:'',
			appid:'',
			source: getParam('source') || '1000',
			imei: getParam('imei'),
			islogin:{
				tag:false,
				desc:''
			},
			isphone:{
				tag:false,
				desc:''
			},
			iscard:{
				tag:false,
				desc:''
			},
			olduser:{
				tag:false,
				desc:''
			},
			flag:false
	}
	var bind=function(){
		$("#st1").on('touchend',function(){
			if(g.flag){
				return;
			}
			g.flag=true;
			getRedPacket();
		})//领取红包
		$("#st4").on('touchend',function(){//立即充值
			var UA = navigator.userAgent;
			if(g.islogin.tag){//用户未登录
				if(/i(phone|os|pad)/i.test(UA)){
					try {
						WebViewJavascriptBridge.callHandler('clickIosLogin');
					} catch (e){
						window.location.href = 'login.html';
					}
				}else if(/android/i.test(UA)){
					try {
						window.caiyiandroid.clickAndroid(3, '');
					} catch (e){
						window.location.href = 'login.html';
					}
				}else{
					window.location.href="login.html";
				}
				return ;
			}
			if(g.isphone.tag && g.iscard.tag){//两个都未绑定
				D.confirm(g.isphone.desc,function(){
					window.location.href="idcard.html";
				},"btn_ljbd")
				return ;
			}
			if(g.isphone.tag){//未绑定手机号
				D.confirm(g.isphone.desc,function(){
					window.location.href="phone.html";
				},"btn_ljbd")
				return ;
			}
			if(g.iscard.tag){//未绑定身份证号码
				D.confirm(g.iscard.desc,function(){
					window.location.href="idcard.html";
				},"btn_ljbd")
				return ;
			}
			if(g.olduser.tag){
				D.confirm(g.olduser.desc)
				return ;
			}
			if(/iphone/i.test(UA)){
				try {
					WebViewJavascriptBridge.callHandler('callBackIOS','3');
				} catch (e){
					window.location.href = '/#type=url&p=user/charge.html';
				}
			}else if(/android/i.test(UA)){
				try {
					window.caiyiandroid.clickAndroid(7, '');
				} catch (e){
					window.location.href = '/#type=url&p=user/charge.html';
				}
			}
		})
	};5851
	//领取红包
	var getRedPacket=function(){
		$.ajax({
			url:"/activity/getRedpacket.go",
			type:'post',
			data:{
				source:g.source,
				accesstoken: g.token,
				appid: g.appid,
				imei: g.imei,
				logintype:'1'
			},
			dataType : "xml",
			success : function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				if(code==0){//领取红包成功
					
					alert('领取成功')
					setTimeout(function(){
						location.reload();
					}, 1000)
				}else if(code==-1){
					D.confirm(desc)
				}else if(code == '1005'){
					D.confirm(desc,function(){
						window.location.href="phone.html";
					},"btn_ljbd")
				}else if(code == '1006'||code == '1007'){
					D.confirm(desc,function(){
						window.location.href="idcard.html";
					},"btn_ljbd")
				}else{
					D.confirm(desc);
				}
				setTimeout(function(){
					g.flag=false;
				}, 1e3)
			}
		})
	}
	
	//检查各种状态（）
	var checkLogin=function(){
		$.ajax({
			url:"/activity/queryStatesOfSend10.go",
			type:'post',
			data:{
				source:g.source,
				accesstoken: g.token,
				appid: g.appid,
				imei: g.imei,
				logintype:'1'
			},
			dataType : "xml",
			success : function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				$("#st1,#st2,#st3,#st4").hide()
				if(code == '1' || code == '9007'){
					g.islogin.tag = true
					g.islogin.desc = desc
				}
				if(code == '1005'){
					g.isphone.tag = true
					g.isphone.desc = desc
				}
				if(code == '1006'){
					g.iscard.tag = true
					g.iscard.desc = desc
				}
				if(code == '1007'){
					g.isphone.tag = true;
					g.iscard.tag = true;
					g.isphone.desc = desc
				}
				if(code == '-1'){
					g.olduser.tag = true;
					g.olduser.desc = desc;
				}
				if(code=="0"){//显示领取红包页面
					$("#st1").show()
				}else if(code=="-2"){//红包已领取
					$("#st2").show()
				}else if(code=="-3"){//显示已参加过活动页面
					$("#st3").show()
				}else{//立即充值
					$("#st4").show()
				}
			}
		})
	};
	var init = function(){
		var allcookies = document.cookie;
		if(allcookies.indexOf('TOKEN')!='-1'){
				allcookies = allcookies.split('&');
				$.each(allcookies,function(index, val){
					if(val.indexOf('TOKEN=')>=0){
						g.token = val.split('TOKEN=')[1];
					}
					if(val.indexOf('APPID=')>=0){
						g.appid = val.split('APPID=')[1];
					}
				});
				checkLogin();
				setTimeout(function(){
					$.ajax({
						url:'/user/swaplogin.go',
						data:{
							logintype:'1',
							accesstoken:g.token,
							appid:g.appid
						},
						type:'POST',
						success:function(){
						},
						error:function(){
							alert('网络异常，请重新打开页面');
						}
					});
				},300)
		}else{
//			checkLogin();
			//如果非客户端进来的 跳转到下载页面
			if(g.token == ''){
				$("#st1,#st2,#st3,#st4").hide()
				$("#st5").show()
				$("#st5").on('touchend', function(){
					location.href='http://t.9188.com  '
				})
			}
			
		}
		bind();
	}
	return {
		init :init,
		g:g
	}
})()
SHB.init();