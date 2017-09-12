$(function(){
	
	$.ajax({
        url: $_user.url.base,
        success:function (data){
        	var R = $(data).find("Resp");
        	var c = R.attr('code');
        	if(c == '0'){
        		var U = R.find("row");
	        	var rb = U.attr("ipacketmoney");//红包
	        	var n = U.attr("nickid");//用户名
	        	$("#username").val(n);
        	}
        }
	});
	
	
	
	//检查用户名是否存在
	$("#btn_tj").click(function(){
		if($("#username").val()==""){
			D.alert("请输入用户名",function(){
				return false;
			});
		}
		checkUserForm();
	});
	
	//发送验证码
	$("#btn_tj2").click(function(){
		if(!$("#mobile").val()){//输入号码为空时，不予验证
			D.alert("请输入有效手机号码");
			return false;
		}
		var data ="uid="+ encodeURIComponent($("#username").val())+"&mobileNo="+ encodeURIComponent($("#mobile").val());
		$.ajax({
			url : "/user/forgetpwd.go",
			type : "POST",
			dataType : "xml",
			data : data,
			success : function(xml) {
				
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
					getyzmCode();
					
				}else{
					D.alert("手机号码不匹配,请检查是否正确");
				}
			}
		})
	});
	
	
	
	var pass;
	//获取验证码方法
	function getyzmCode(){
		var data ="uid=" + encodeURIComponent($("#username").val())+"&flag=1";
		$.ajax({
			url : "/user/usergetpwd.go",
			type : "POST",
			dataType : "xml",
			data : data,
			success : function(xml) {
				var R = $(xml).find("Resp");
				var r = $(R).find("row");
				var code = R.attr("code");
				var desc = R.attr("desc");
				pass = r.attr("pass");
				if (code == "0") {
					$("#forgotpass3").show();
					if($("#forgotpass3").is(":visible")){
						
						countDown();
					}else{
						window.clearTimeout(inter);
					}
					$("#forgotpass3").siblings("div").hide();
					
				} else if(code=="1005"){
					D.alert("对不起，您的忘记密码请求次数已超过每天限制次数(3次)！")
				}
				
				
			},
			
		});
	}
	
	
	//提交验证码获取密码
	
	$("#tjyzm").click(function(){
		var data ="uid=" + encodeURIComponent($("#username").val())+"&flag=1&yzm=" + $("#yzm").val();
		
		$.ajax({
			url : "/user/usergetpwdyz.go",
			type : "POST",
			dataType : "xml",
			data : data,
			success : function(xml) {
				var R = $(xml).find("Resp");
				var r = $(R).find("row");
				var code = R.attr("code");
				var desc = R.attr("desc");
				pass = r.attr("pass");
				if (code == "0") {
					//$("#forgotpass5").show();
					//$("#forgotpass5").siblings("div").hide();
					D.alert("您的新密码为:"+pass,function(){
						window.location.href="/#class=url&xo=login/index.html";
					},"跳转到登录页面");
					
					
				} else {
					D.alert(desc);
				}
				
				
			},
			
		});
		
	});
	
	//检查用户名是否存在
	function checkUserForm(){
		if($('#username').val()){
			var data ="uid=" + encodeURIComponent($("#username").val());
			$.ajax({
				url : "/user/forgetpwd.go",
				type : "POST",
				dataType : "xml",
				data : data,
				success : function(xml) {
					var R = $(xml).find("Resp");
					var row = R.find("row");
					var code = R.attr("code");
					var desc = R.attr("desc");
					var mobbind = row.attr("mobbind");
					if (code == "0") {//用户名存在
						if(mobbind=="1"){//已经绑定手机号码
							showStep2();
						}else{
							D.alert("您未绑定手机号码")
						}
						
					}else if(code=="2000"){
						D.alert("您的用户名不存在")
					}else if(code=="2001"){
						D.alert("手机号不匹配")
					}		
				}
			})
		}
	}
	
	
	function showStep2(){
		$("#forgotpass2").show();
		$("#forgotpass2").siblings("div").hide();
	}
	
	
	
	//重新发送
	$("#resend").bind("click",function(){
		countDown();
	})
	
	var inter;
	var wait=60;
	function countDown(){
		if(wait == 0) {
			$("#resend").attr("disabled",false);			
			$("#resend").val("重新发送");
			zeroDownAjax();
			wait = 60;
		}else{
			$("#resend").attr("disabled", true);
			$("#resend").val("重新发送(" + wait + ")");
			wait--;
			inter=setTimeout(function() {
				countDown();
			},
			1000)
		}
	}
	
	//重新发送验证码
	function zeroDownAjax(){
		var data ="uid=" + encodeURIComponent($("#username").val())+"&flag=1";
		$.ajax({
			url : "/user/usergetpwd.go",
			dataType : "xml",
			data:data,
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = $(R).attr("code")
				var desc = $(R).attr("desc")
				if(code=="1002"){
					//D.alert(desc)
				}else if(code=="1000"){
					//D.alert(desc)
				}else if(code=="0"){
					//window.location.reload();
				}else if(code=="1005"){
					D.alert(desc);
				}
				
			}
		})
	}
	
	

	/***
	$("#btn_tj5").click(function(){
		var pass1 = $("#pass1").val();
		var pass2 = $("#pass1").val();
		
			if(pass1==pass2){
				var data = 'flag=2&newValue='+pass1+'&upwd='+pass
				$.ajax({
					url : "/user/modify.go",
					type : "POST",
					dataType : "xml",
					data : data,
					success : function(xml) {
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if (code == "0") {
							D.alert("修改密码成功,请重新登录",function(){
								window.location.href="/login/index.html";
							});
						}		
					}
				});
			}else{
				D.alert("两次输入的号码不一样");
			}
		})
	
	***/

})


function bdMobileLink(){
		event.preventDefault();
		$(".zfPop").hide();
		$(".zfPop").remove();
		$("#zhezhao").hide();
		$("#zhezhao").remove();
		//window.location.href="/useraccount/setup/bindtel.html";
	}