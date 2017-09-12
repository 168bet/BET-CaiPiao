/*
* Author: weige
* Date : 2014-04-28
*/ 
(function(){
	checkLogin(function(){
		$.ajax({
			url : $_user.url.safe,
			type : "POST",
			dataType : "xml",
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
					var r = R.find('row');
					var bank = r.attr('bank');
					var rname =r.attr("rname");
					var idcard =r.attr("idcard");
					var mobbind = r.attr('mobbind');
					
					if(mobbind != 0){
						$('#bangding a:eq(0) em').attr('class','bind');
					}else{
						$('#bangding a:eq(0) em').attr('class','nobind');
					}
					if(rname.length>2 && idcard.length>10){
						$('#bangding a:eq(1) em').attr('class','bind');
					}else{
						$('#bangding a:eq(1) em').attr('class','nobind');
					}
					if(bank.length>10){
						$('#bangding a:eq(2) em').attr('class','bind');
					}else{
						$('#bangding a:eq(2) em').attr('class','nobind');
					}
				}else{
					D.alert(desc);
				}
			}
		});
	});
	
})();
function outLogin(){
	$.ajax({
		url : $_user.url.loginout,
		type : "POST",
		dataType : "xml",
		success : function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			if (code == "0") {
				D.alert('退出成功',function(){
					var agent = localStorage.getItem('from');
	 				if(agent == 'azcp'){
	 					window.location.href="/";
	 				}else{
	 					localStorage.setItem('callback', '#class=url&xo=useraccount/index.html');
	 					window.location.href='/#class=url&xo=login/index.html';
	 				}
				});
			}else{
				D.alert(desc);
			}
		}
	});
}