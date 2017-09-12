/*
* Author: weige
* Date : 2014-04-28
*/ 
var payMoney = location.search.getParam('payMoney');
(function(){
	if (payMoney == "") {
		if (history.length == 0) {
			window.opener = "";
			window.close();
		} else {
			history.go(-1);
		}
		return false;
	}
	var P = {};
	P.inital = function(){
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
					var bank = r.attr('bank');//银行卡号
					var idcard = r.attr('idcard');//身份证
					var mobile = r.attr('mobile');//手机
					var code = r.attr('code');//银行
					var rname = r.attr('rname');//真实姓名
					var prov = r.attr('prov');
					var city = r.attr('city');
					var name = r.attr('name');//支行
					
					var yh="";
					if(code=="1"){
						yh="招商银行";
					}else if(code=="2"){
						yh="工商银行";
					}else if(code=="3"){
						yh="建设银行";
					}else if(code=="8"){
						yh="中信银行";
					}else if(code=="9"){
						yh="兴业银行";
					}else if(code=="6"){
						yh="交通银行";
					}else if(code=="13"){
						yh="农业银行";
					}else if(code=="1001"){
						yh="深圳发展银行";
					}else if(code=="10"){
						yh="光大银行";
					}else if(code=="11"){
						yh="华夏银行";
					}else if(code=="23"){
						yh="平安银行";						
					}else if(code=="25"){
						yh="中国邮政储蓄银行";
					}else if(code=="1000"){
						yh="广东发展银行";
					}else if(code=="1002"){
						yh="广州银行";
					}else if(code=="15"){
						yh="农信社";
					}
					
					$('#con p:eq(0) cite').html(rname);
					$('#con p:eq(1) cite').html(idcard);
					$('#con p:eq(2) cite').html(prov+','+city);
					$('#con p:eq(3) cite').html(yh+(name != ''?'('+name+')':''));
					$('#con p:eq(4) cite').html(bank);
					$('#con p:eq(5) cite').html(payMoney);//充值金额
					
					 if(payMoney>=100){
						 var handmoney = parseInt(payMoney)/100;
						 $('#con p:eq(6) cite').html(handmoney);//手续费
						 $('#con p:eq(7) cite').html(payMoney-handmoney);//实际到账
					 }else if(payMoney>=21 && payMoney<100){
						 $('#con p:eq(6) cite').html("1");//手续费
						 $('#con p:eq(7) cite').html(payMoney*1-1);//实际到账
					 }
					 
					 $('#nextStep').click(function(){
						 var phone = $.trim($('#phone').val());
						 if(phone == ''){
							 D.alert('请输入您绑定银行卡的手机号码');
						 }else{
							 $.ajax({
								 url : "/user/addmoney.go",
									type : "GET",
									dataType : "xml",
									data:{
										 addmoney:payMoney,
										 bankid:'9007',
										 cardpass:phone
									},
									success : function(xml) {
										var R = $(xml).find('Resp');
										var c = R.attr('code');
										var d = R.attr('desc');
										if(c == 0){
											 $('#con').hide();
											 $('#success').show();
										}else{
											D.alert(d);
										}
									}
							 });
						 }
					 });
					 
				} else {
					if(desc.indexOf('未登录') != -1){
						D.alert('请先登录',function(){
							window.location.href='/login/';
						});
					}else{
						D.alert(desc);
					}
				}
			}
		});
	};
	
	
	
	P.inital();
})();