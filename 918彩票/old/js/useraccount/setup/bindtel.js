$(function(){
	
	//var mobile;
	var tag = location.search.getParam("tag");
	if(tag){
		$("#bindPhone4").show();
	}else{
		$.ajax({
			url : "/user/querybind.go",
			type : "POST",
			dataType : "xml",
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code")
				
				if(code=="0"){
					var r = R.find("row");
					var mobile = r.attr("mobile");
					var mobbind = r.attr("mobbind");
					if(mobbind=="1"){//已绑定
						$("#bindphone").text(mobile);
						$("#bindPhone3").show();
						$("#bindPhone1").hide();
						$("#bindPhone2").hide();
						$("#bindPhone4").hide();
					}else if(mobbind=="0"){//未绑定
						$("#bindPhone3").hide();
						$("#bindPhone1").show();
						$("#bindPhone2").hide();
						$("#bindPhone4").hide();
					}
				}
			}
		})
	}
	
	
	var inter;
	var wait=60;
	function countDown(){
		if (wait == 0) {
			$("#resend").attr("disabled",false);			
			$("#resend").val("重新发送");
			zeroDownAjax();
			wait = 60;
		} else {
			$("#resend").attr("disabled", true);
			$("#resend").val("重新发送(" + wait + ")");
			wait--;
			inter=setTimeout(function() {
				countDown();
			},
			1000)
		}
	}
	
	$("#yzm").focus(function(){
		if($(this).val()=="请输入手机收到的验证码"){
			$(this).val("");
		}
	});
	
	
	$("#phone").focus(function(){
		if($(this).val()=="请输入您的手机号码"){
			$(this).val("");
		}
	});
	
	//输入手机号发送验证码(第一步：根据手机号发送验证码)
	$("#fasong").bind("click",function(){
		if($("#phone").val()==""){
			D.alert("请输入有效的手机号码")
			return false;
		}
		var phoneValue = $("#phone").val();
		$.ajax({
			url : $_user.url.bind,
			type : "POST",
			dataType : "xml",
			data:"flag=1&newValue="+phoneValue,
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code")
				var desc = R.attr("desc")
				if(code=="0"){
					
					$("#bindPhone1").hide();
					$("#bindPhone2").show();
					$("#bindPhone2").siblings("div").hide();
					$("#pho").val($("#phone").val());
					//$("#yzm").val("请输入手机收到的验证码");
					if($("#bindPhone2").is(":visible")){
						countDown();
					}else{
						window.clearTimeout(inter);
					}
				}else{
					D.alert(desc);
				}
				
			}
		})
		
	})
	
	
	//重新发送验证码
	function zeroDownAjax(){
		$.ajax({
			url : $_user.url.bind,
			dataType : "xml",
			data:"flag=1&newValue="+$("#phone").val(),
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = $(R).attr("code")
				var desc = $(R).attr("desc")
				if(code=="1002"){
					//alert(desc)
				}else if(code=="1000"){
					//alert(desc)
				}else if(code=="0"){
					//window.location.reload();
				}
			}
		})
	}
	
	
	
	
	
	
	//重新发送
	$("#resend").bind("click",function(){
		countDown();
	})
	
	
	//提交(第二步:根据输入的验证码提交)
	$("#sendyzm").bind("click",function(){
		event.preventDefault();
		var yzmValue = $("#yzm").val();
		if(yzmValue==""){
			D.alert("请输入验证码");
			return false;
		}
		var data="flag=1&yzm="+yzmValue;
		$.ajax({
			url : $_user.url.bindyz,
			type : "POST",
			dataType : "xml",
			data:data,
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = $(R).attr("code");
				var desc = $(R).attr("desc");
				if(code=="0"){
					$("#bindPhone2").hide();
					window.clearTimeout(inter);//bindPhone2隐藏以后,移除inter,不让其重新发送验证码
					var phoneValue = $("#pho").val();
					var bindcode = phoneValue.substring(0,3)+"****"+phoneValue.substring(7);
					$("#bindphone").text(bindcode);
					$("#bindPhone3").show();
					("#bindPhone3").siblings("div").hide();
					wait=60;
					window.clearTimeout(inter);
				}else if(code=="1001"){
					
					D.alert(desc,function(){
						return false;
					})
				}
			}
		})
	})
	
	
	$("#modify").bind("click",function(){
		$("#bindPhone3").hide();
		$("#bindPhone4").show();
		$("#bindPhone4").siblings("div").hide();
	})
	
	
	//修改绑定，发送验证码
	$("#modifyyzm").bind("click",function(){
		var oldValue = $("#oldValue").val();
		var newValue = $("#newValue").val();
		if(oldValue==""||newValue==""){
			D.alert("请输入正确的手机号码");
			return false;
		}
		$.ajax({
			url : $_user.url.bind,
			type : "POST",
			dataType : "xml",
			data:"flag=1&newValue="+$("#newValue").val()+"&mobileNo="+oldValue,
			success : function(xml) {
				var R = $(xml).find("Resp")
				var code = R.attr("code")
				var desc = R.attr("desc")
				if(code=="0"){
					$("#bindPhone2").show();
					$("#bindPhone2").siblings("div").hide();
					$("#bindPhone4").hide();
					$("#yzm").val("请输入手机收到的验证码");
					
					wait=60;
					
					$("#pho").val($("#newValue").val());
					
						countDown();
					
					
				}else {
					D.alert(desc);
				}
			}
		})
		
	})
})