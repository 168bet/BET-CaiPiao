var wait = '60';
var mphone = localStorage.getItem("mphone");
var openid = localStorage.getItem("openid");

(function(){
	if(document.addEventListener){
		document.addEventListener('WeixinJSBridgeReady', sendMessage, false);  
	}else if(document.attachEvent){
		document.attachEvent('WeixinJSBridgeReady'   , sendMessage);	
		document.attachEvent('onWeixinJSBridgeReady' , sendMessage);  
	}
	
	 $(".zhuceOpen2").bind("click",function(){
		 $(this).hide();
		 $(".zhuceOpen").show();
		 $("#pwd").attr("type","text");
	 });
	 $(".zhuceOpen").bind("click",function(){
		 $(this).hide();
		 $(".zhuceOpen2").show();
		 $("#pwd").attr("type","password");
	 });
	 
	//重新发送
	$("#resend").bind("click",function(){
		zeroDownAjax();
		countDown();
	});
	$("#resend").click();
	
	function countDown(){
		if(wait == 0) {
			$("#resend").attr("disabled",false);
			$("#resend").val("重新发送");
			
			wait = 60;
		}else{
			$("#resend").attr("disabled", true);
			$("#resend").val("重新发送(" + wait + ")");
			wait--;
			inter=setTimeout(function() {
				countDown();
			},
			1000);
		}
	}
	function zeroDownAjax(){
		
		$.ajax({
			url:'/wechat/sendVerify.go',
			dataType:'xml',
			data:{
				mphone:mphone
			},
			type:'POST',
			success:function(xml){
				var R = $(xml).find('Resp');
				var code = R.attr('code');
				var desc = R.attr('desc');
				if(code == 0){
					
				}else{
					WW.tx(desc);
				}
			}
		});
	}
	function zhuce(yzm,uname,pwd){
		var verycode = yzm;
		var uid = uname;
		$.ajax({
			url:'/wechat/regeisterBindUid.go',
			dataType:'xml',
			data:{
				mphone:mphone,
				verycode:verycode,
				pwd:pwd,
				uid:uid,
				openid:openid
			},
			type:'POST',
			success:function(xml){
				var R = $(xml).find('Resp');
				var code = R.attr('code');
				var desc = R.attr('desc');
				if(code == 0){
					window.location.href='/word_weixin/myrecord/telbind3.html';
				}else{
					WW.tx(desc);
				}
			}
		});
	}
	$('#bd').click(function(){
		var yzm = $('#yzm').val();
		var uname = $('#uname').val();
		var pwd = $('#pwd').val();
		if(yzm == ''){
			WW.tx('请输入验证码');
		}else if(uname == ''){
			WW.tx('请输入用户名');
		}else if(pwd == ''){
			WW.tx('请输入密码');
		}else{
			zhuce(yzm,uname,pwd);
		}
	});
})();
