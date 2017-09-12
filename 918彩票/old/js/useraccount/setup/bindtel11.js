$(function(){
	var phoneValue = location.search.getParam("phoneValue");
	//重新发送
	$("#resend").bind("click",function(){
		countDown();
	})
	
	
	var wait=10;
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
			setTimeout(function() {
				countDown();
			},
			1000)
		}
	}
	
	
	
	
	//提交
	$("#sendyzm").bind("click",function(){
		var yzmValue = $("#yzm").val();
		
		$.ajax({
			url : $_user.url.bindyz+"?flag=1&yzm="+yzmValue,
			type : "POST",
			dataType : "xml",
			success : function(xml) {
				var R = $(xml).find("Resp")
				var code = $(R).attr("code")
				var desc = $(R).attr("desc")
				if(code=="0"){
					window.location.href="/useraccount/setup/bindtel2.html?code="+phoneValue;
				}else if(code=="1001"){
					alert(desc);
				}
			}
		})
	})
	
	//重新发送验证码
	function zeroDownAjax(){
		alert(phoneValue)
		$.ajax({
			url : $_user.url.bind,
			dataType : "xml",
			data:"flag=1&newValue="+phoneValue,
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = $(R).attr("code")
				var desc = $(R).attr("desc")
				if(code=="1002"){
					alert(desc)
				}else if(code=="1000"){
					alert(desc)
				}else if(code=="0"){
					window.location.reload();
				}
				
			}
		})
	}
})