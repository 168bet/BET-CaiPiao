;
(function($) {

	// btnSendCode
	var InterValObj, //timer变量，控制时间
		count = 60, //间隔函数，1秒执行
		curCount, //当前剩余秒数
		code = "", //验证码
		codeLength = 6; //验证码长度


	function sendMessage(btn) {
		this.btn = btn;

		this.init();
	}


	sendMessage.prototype = {
		init: function() {
			console.log(this.html)
			curCount = count;
			var dealType; //验证方式
			var uid = $("#uid").text(); //用户uid
			if ($("#phone").attr("checked") == true) {
				dealType = "phone";
			} else {
				dealType = "email";
			}
			//产生验证码
			for (var i = 0; i < codeLength; i++) {
				code += parseInt(Math.random() * 9).toString();
			}
			//设置button效果，开始计时
			this.btn.attr("disabled", "true");
			this.btn.text(+curCount + "秒");
			InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
			//向后台发送处理数据
			$.ajax({
				type: "POST", //用POST方式传输
				dataType: "text", //数据格式:JSON
				url: 'Login.ashx', //目标地址
				data: "dealType=" + dealType + "&uid=" + uid + "&code=" + code,
				error: function(XMLHttpRequest, textStatus, errorThrown) {},
				success: function(msg) {}
			});

			var BTN =this.btn;

			//timer处理函数
			function SetRemainTime() {

				if (curCount == 0) {
					window.clearInterval(InterValObj); //停止计时器
					BTN.removeAttr("disabled"); //启用按钮
					BTN.text("重新发送");
					code = ""; //清除验证码。如果不清除，过时间后，输入收到的验证码依然有效    
				} else {
					curCount--;
					BTN.text(+curCount + "秒");
				}
			}


		},



	}



	$.fn.sendCheckcode = function() {

		this.click(function() {
			new sendMessage($(this));
		});
	}

})(jQuery)