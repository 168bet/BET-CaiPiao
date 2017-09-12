$(function(){
	
	
	$("#modify").bind("click",function(){
		event.preventDefault();
		modifyCode();
	})
	
	
	
	function modifyCode(){
		var orignalCode = $("#orignalCode").val();
		var newCode = $("#newCode").val();
		var reCode = $("#reCode").val();
		if(newCode != reCode){
			alert("两次输入不一致");
			return false;
		}
		alert(orignalCode+"~~"+newCode);
		$.ajax({
	        url:$_user.modify.pwd,
	        //type:"post",
	        data:"newValue="+newCode+"&upwd="+orignalCode,
	        success:function (xml){
	        	var R = $(xml).find("Resp")
	        	var code = R.attr("code");
	        	var desc = R.attr("desc");
	        	if(code=="0"){
	        		alert("修改成功")
	        		window.history.back(-1);
	        	}else{
	        		alert(desc)
	        	}
	        }
		})
	}
	
})