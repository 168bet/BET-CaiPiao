/*Author: weige 
Date: 2014-4-29*/
(function(){
	$('.moneyNum').focus();
	var agent = localStorage.getItem('from');
	
	var comeFrom;
	comeFrom=localStorage.getItem('comeFrom');
	
	if(agent == 'azcp'){
		$('#pay_con1 a:eq(0)').hide();
		$('#pay_con1 a:eq(1)').hide();
		$('#pay_con1 a:eq(2)').show();
		
		$('#wxts p:eq(1)').hide();
		$('#wxts p:eq(2)').hide();
		$('#wxts p:eq(3)').show();
		$('#pay1 cite').html('安智充值');
		$('#pay2').hide();
		$('#pay3').hide();
		$('#pay4').hide();
	}
	var isWeiXin=function(){
	    var ua = window.navigator.userAgent.toLowerCase();
	    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
	        return true;
	    }else{
	        return false;
	    }
	}
	var flg = isWeiXin();
	
	if(flg && comeFrom!="lhmwechat"){
		$('#pay_con4 a:eq(1)').show();
	}else{
		$('#pay_con4 a:eq(1)').hide();
	}
	
	
	
	$('.moneyNum').bind('keyup',function(){
		this.value=this.value.replace(/\D/g,'');
	});
	
	var inital,bind,zfb_pay;
	inital = function(){
		$('.moneyNum').val('');
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
					bind(bank,idcard,mobile,code);
				} else {
					if(desc.indexOf('未登录') != -1){
						D.tx('请先登录',function(){
							localStorage.removeItem('callback');
							var agent = localStorage.getItem('from');
			 				if(agent == 'azcp'){
			 					window.location.href="http://4g.9188.com/user/allylogin.go?type=10";
			 				}else{
			 					window.location.href='#class=url&xo=login/index.html';
			 				}
						});
					}else{
						D.alert(desc);
					}
				}
			}
		});
	};
	zfb_pay = function(tkType,m){
		var bankid = '9014';
		var notifyUrl = 'http://mopay.9188.com  /user/zfbwaptouch_notify.go';//默认9014
		var one = getcookie("JSESSIONID-CLUSTER-RBC");
		$.ajax({
			url : "/data/info/config/pay/xml/bankconfig.xml",
			type : "GET",
			dataType : "xml",
			success : function(xml) {
				var rows = $(xml).find('rows');
				var r = rows.find('row');
				r.each(function(){
					var bankvalue = $(this).attr('bankvalue');
					var bankconfig = $(this).attr('bankconfig');
					if(bankvalue=="32"){//支付宝wap(4g触屏)
						bankid = bankconfig;
					}
				});
				var huodong = sessionStorage.getItem('huodong');
				var callbackUrl = 'http://4g.9188.com/useraccount/';
				if(!!huodong){
					callbackUrl = huodong;
				}
				if(bankid == '3014'){
					notifyUrl = 'http://mopay.9188.com  /user/zfbwaptouch_notify_eastday.go';
				}
				window.location.href='/user/addmoney.go?sessionId1='+one+'&sessionId2='+one+'&addmoney='+m+'&bankid='+bankid+'&tkType='+tkType+'&notifyUrl='+notifyUrl+'&callbackUrl='+callbackUrl+'&merchantUrl='+callbackUrl;
			},
			error:function(){
				window.location.href='/user/addmoney.go?sessionId1='+one+'&sessionId2='+one+'&addmoney='+m+'&bankid='+bankid+'&tkType='+tkType+'&notifyUrl='+notifyUrl+'&callbackUrl='+callbackUrl+'&merchantUrl='+callbackUrl;
			}
		});
		
		
	};//callbackUrl充值成功   merchantUrl充值失败返回
	
	
	var Cookies = {};
	Cookies.get = function(name){
	    var arg = name + "=";   
	    var alen = arg.length;   
	    var clen = document.cookie.length;   
	    var i = 0;   
	    var j = 0;   
	    while(i < clen){   
	        j = i + alen;   
	        if (document.cookie.substring(i, j) == arg)   
	            return Cookies.getCookieVal(j);   
	        i = document.cookie.indexOf(" ", i) + 1;   
	        if(i == 0)   
	            break;   
	    }   
	    return null;   
	};
	
	
    
    
	
	bind = function(b,i,m,c){
		comeFrom = localStorage.getItem('comeFrom');
		//储蓄卡-支付宝
		$('#pay_con1 a:eq(0)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else if(money>2000){
				D.alert('单笔单日不能超过2000元');
			}else{
				zfb_pay('1',money);
			}	
		});
		//储蓄卡电话充值
		$('#pay_con1 a:eq(1)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<21){
				D.alert('最小充值21元');
			}else if(money>1000){
				D.alert('单笔不能超过1000元');
			}else{
				if(i == '' && b == ''){
					D.alert('银联电话充值前先绑定真实身份证和银行卡，确保账户安全',function(){
						window.location.href='/useraccount/setup/idbin.html';
					},'绑定身份证');
				}else if(i == '' && b != ''){
					D.alert('银联电话充值前先绑定真实身份证和银行卡，确保账户安全',function(){
						window.location.href='/useraccount/setup/idbin.html';
					},'绑定身份证');
				}else if(b == '' && i != ''){
					D.alert('银联电话充值前先绑定真实身份证和银行卡，确保账户安全',function(){
						window.location.href='/useraccount/setup/bcardbin.html';
					},'绑定银行卡');
				}else{
					if(c!="2" && c!="3" && c!="10" && c!="11" && c!="23" && c!="1" && c!="6" && c!="8" && c!="9" && c!="13" && c!="1001" && c!="1000" && c!="1002" && c!="15"){
						D.alert('仅支持工行、建行、农行、招行、中信、兴业、交行、民生、光大、平安、华夏、广发、广州银行、广州农信社14家银行借记卡');
					}else{
						$.ajax({
							url : "/user/dna_check.go",
							type : "POST",
							dataType : "xml",
							data : "rnd=" + Math.random(),
							success : function(xml) {
								code = $(xml).find("Resp").attr("code");
								d = $(xml).find("Resp").attr("desc");
								if(code=="0"){
									window.location.href='/useraccount/add_ylpay.html?payMoney='+money;
								}else{
									D.alert(d);
								}
							},
							error : function() {
								D.alert('不支持的卡');
							}
						});
					}
				}
			}
		});
		//安智充值
		$('#pay_con1 a:eq(2)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else if(money>1000){
				D.alert('单笔不能超过1000元');
			}else{
				window.location.href='/user/addmoney.go?bankid=2070&addmoney='+money;
			}
		});
		//信用卡快捷-支付宝
		$('#pay_con2 a:eq(0)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else if(money>2000){
				D.alert('单笔单日不能超过2000元');
			}else{
				zfb_pay('2',money);
			}
		});
		//支付宝网页版
		$('#pay_con3 a:eq(0)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else{
				zfb_pay('0',money);
			}
		});
		
		//微信充值
		$('#pay_con4 a:eq(1)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			var sxmoney = money*0.01;
			var sjmoney = money - money*0.01;
			if(!money || money<1){
				D.alert('最小充值1元');
				return;
			}else{
				//zfb_pay('0',money);
			}
			D.confirm("实际到账<cite style='color:red'>"+sjmoney+"元</cite>"+","+"手续费<cite style='color:red'>"+sxmoney+"元<cite>",function(){
				window.location.href='/user/addmoney.go?bankid=3000&addmoney='+money;
			})
		});
		
		
		
		//建行充值
		$('#ccb a').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else if(money>500){
				D.alert('单笔不能超过500元');
			}else{
				window.location.href='/user/addmoney.go?bankid=19&addmoney='+money;
			}
		});
		
		//兴业银行充值
		$('#cib a').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else{
				window.location.href='/user/addmoney.go?bankid=20&addmoney='+money;
			}
		});
		
		if(comeFrom=="cib"){//兴业充值
			$("#cib").show();
			$("#cib").siblings("div.recharge2").hide();
		}else if(comeFrom=="ccb"){//建行充值
			$("#ccb").show();
			$("#ccb").siblings("div.recharge2").hide();
		}else{
			$("#cib").hide();
			$("#ccb").hide();
			$("div.recharge2").not("div#ccb").not("div#cib").show();
		}
	};
	inital();
})();


function setTab(name,num,n){
	for(var i=1;i<=n;i++){
		var menu=document.getElementById(name+i);
		var con=document.getElementById(name+"_"+"con"+i);
		menu.className=i==num?"cur":"";
  		con.style.display=i==num?"block":"none"; 
	}
}