$(function(){
	$("#modifyyzm").bind("click",function(){
		var oldValue = $("#oldValue").val();
		var newValue = $("#newValue").val();
			
		$.ajax({
			url : $_user.url.bindyz+"?flag=1&newValue="+newValue+"&oldValue="+oldValue,
			type : "POST",
			dataType : "xml",
			
			success : function(xml) {
				var R = $(xml).find("Resp")
				var code = $(R).attr("code")
				var desc = $(R).attr("desc")
				if(code=="0"){
					window.location.href="/useraccount/setup/bindtel11.html?phoneValue="+newValue;
				}else if(code=="1001"){
					alert(desc);
				}
			}
		})
	})
})