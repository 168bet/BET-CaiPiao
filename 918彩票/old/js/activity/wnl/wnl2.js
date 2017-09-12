$(function(){
	XX.init_info();
});

var XX={
	flag:true,
	init_info:function(){
		var callbacks = $.Callbacks();
		//callbacks.add();
		callbacks.add(XX.bindEvent);
		callbacks.fire();
	},
	inter:"",
	wait:30,
	countDown:function(){
		if (this.wait == 0) {
			$("#getyzm").attr("disabled",false);			
			$("#getyzm").val("重新发送");
			this.wait = 60;
		}else{
			$("#getyzm").attr("disabled", true);
			$("#getyzm").val("重新发送(" + this.wait + ")");
			this.wait--;
			this.inter=setTimeout(function() {
				XX.countDown();
			},
			1000);
		}
	},


	//重新发送验证码
	zeroDownAjax:function(){
		var val = $("#phone").val();
		$.ajax({
			url : "/user/sendWnlYzm.go?mobileNo="+val,
			dataType : "xml",
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = $(R).attr("code");
				var desc = $(R).attr("desc");
				if(code=="0"){
					//window.location.reload();
				}
			}
		});
	},
	bindEvent:function(){
		//验证手机号码
		$("#phone").blur(function(){
			var val = $(this).val();
			if(val){
				$.ajax({
					url : "/user/checkWnlAuthor.go?mobileNo="+val,
					type : "POST",
					dataType : "xml",
					success : function(xml) {
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if(code != "0"){
							tx(desc);//说明已经注册了
							$("#phone").focus();
						}else{
							XX.flag=false;//说明还没有注册
						}
					}
				})
			}
		});
		
		//获取验证码
		$("#getyzm").bind("click",function(){
			var val = $("#phone").val();
//			if(XX.flag){
//				return false;
//			}
			$(this).attr("disabled",true);
			$.ajax({
				url : "/user/sendWnlYzm.go?mobileNo="+val,
				type : "POST",
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code != "0"){
						window.clearTimeout(XX.inter);
						$("#getyzm").attr("disabled",false);
						tx(desc);
					}else{
						XX.countDown();
						$("#getyzm").attr("disabled",false);
					}
				}
			})
		});
		
		//注册
		$("#sure").bind("click",function(){
			var comeFrom = localStorage.getItem("comeFrom")?localStorage.getItem("comeFrom"):"";
			var bankCode = localStorage.getItem("bankCode")?localStorage.getItem("bankCode"):"";
			var gid = $("#gid").val();
			var yzm = $("#yzm").val();
			var phone = $("#phone").val();
			var pwd = $("#pwd").val();
			if(!phone || !yzm || !pwd){
				tx("请输入正确的信息");
				return false;
			}
			var data = {};
			data = {
	             	gid:     gid,//彩种编号
	             	bankCode:   bankCode,//投注内容
	             	comeFrom:  comeFrom,//方案来源
	             	yzm:    yzm,//是否订单支付
	             	mobileNo:phone,//手机号码
	             	pwd:pwd
	             };
			$.ajax({
				url : "/user/registerWnlUser.go",
				type : "POST",
				dataType : "xml",
				data : data,
				success : function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code == "0"){
						window.location.href="/activity/wnl/wnl3.html"
					}else{
						tx(desc);
					}
				}
			})
		})
	}
};

function tx(msg){
	var tx_speed =  '1500';
	var tx_ml = '-5rem';
	if(msg.length>8){
		$('#tx_c').css({width:'16rem'});
		tx_speed = '2500';
		tx_ml = '-8rem';
	}
	
	$('#tx_c').html('&nbsp;&nbsp;'+msg+'&nbsp;&nbsp;');
	$('#tx_c').show();
	
	$('#tx_c').css({left:'50%',marginLeft:tx_ml});
	setTimeout(function(){
	  	$('#tx_c').slideUp();
    },tx_speed);
}




$("#yzm").focus(function(){
	if($(this).val()=="请输入手机收到的验证码"){
		$(this).val("");
	}
});