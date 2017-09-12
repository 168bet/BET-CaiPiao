/*Author: weige 
Date: 2014-4-29*/
(function(){
	$('.moneyNum').focus();
	var agent = localStorage.getItem('from');
	
	//var comeFrom = location.search.getParam('comeFrom');
	
	
	//
	if(agent == 'azcp'){
		$("#pay_con1 a:eq(5)").show();
		$("#pay_con1 a:eq(5)").siblings().hide();
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
	
	
	//金额切换设置充钱金额
	$("#tab li").bind("click",function(){
		var val = $_Y.getInt($(this).html());
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		$(".moneyNum").val(val);
	});
	
	var cd_type = {
			"0":"全部",
			"2":"借记卡",
			"3":"信用卡"
	};
	
	//连连支付
	//点击快捷支付列，如果有签约的则显示银行列表层，如果没有绑定身份证
	$("#pay_con1 a:eq(2)").bind("click",function(){
		//获取$("#is_bind_card")下面的li的length
		var money = $('.moneyNum').val();
		if(!money || money<1){
			D.alert('最小充值1元');
			return;
		}else{
			//zfb_pay('0',money);
		}
		var len = $("#is_bind_card li").length;
		if(len>1){
			$("#is_bind_card").toggle();
		}else{//说明没有签约的银行卡
			$("#is_bind_card").hide();
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
						
						if(rname.length>2 && idcard.length>10){//绑定了身份证
							window.location.href="/useraccount/kjrecharge.html?money="+money
						}else{//没有绑定身份证
							D.confirm("充值前请先绑定身份证,确保账户安全", function(){
								window.location.href="/useraccount/setup/idbin.html?flag=llp?money="+money;
							});
						}
					}else{
						D.alert(desc);
					}
				}
			});
		}
	});
	
	//点击签约银行
	$("#is_bind_card").delegate('li:not(:last-child)','click', function(){
		var money = $('.moneyNum').val();
		var bankid = $(this).attr("bankid");
		var bankCode = $(this).attr("bankCode");
		var dealid = $(this).attr("dealid");
		window.location.href="/user/addmoney.go?bankid="+bankid+"&bankCode="+bankCode+"&dealid="+dealid+"&addmoney="+money
	});
	//点击添加银行
	$("#is_bind_card").delegate("li#addBank","click",function(){
		var money = $('.moneyNum').val();
		window.location.href="/useraccount/kjrecharge.html?money="+money;
	})
	
	var ll_init=function(){//连连支付初始化,判断是否有银行卡签约,如果有签约则加载其内容
		$.ajax({
			url : "/user/getuseragreebanklist.go",
			type : "POST",
			dataType : "JSON",
			async : false,
			data : "rnd=" + Math.random(),
			success : function(data) {
				var ret_code = data["ret_code"];
				if(ret_code == "0000"){
					var oldHTML = $("#is_bind_card").html();
					var html = "";
					var agreement_list = data["agreement_list"];
					for(var i=0;i<agreement_list.length;i++){
						var bank_name = agreement_list[i]["bank_name"];//银行名称
						var bank_code = agreement_list[i]["bank_code"];//银行编号
						var cd = agreement_list[i]["card_type"];//卡号类型
						var dealid = agreement_list[i]["no_agree"];//卡号类型
						//var cd = agreement_list[i]["card_type"];//卡号类型
						if(cd=="2"){
							cd="2056";
						}else if(cd=="3"){
							cd="2057";
						}
						var card_type = cd_type[agreement_list[i]["card_type"]];
						var card_no = agreement_list[i]["card_no"];
						var no_agree = agreement_list[i]["no_agree"];
						html +='<li bankid="'+cd+'" bankCode="'+bank_code+'" dealid="'+dealid+'">'
						html +='<p><span>'+bank_name+'</span><em>'+card_type+'</em></p>'
						html +='<p><cite>**** **** ****</cite> <cite>'+card_no+'</cite></p>'
						html +='</li>'
					}
					html = html+oldHTML;
					$("#is_bind_card").html(html)
				}
			}
		})
	};
	
	ll_init();
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
				if(bankid == '3014'){
					notifyUrl = 'http://mopay.9188.com  /user/zfbwaptouch_notify_eastday.go';
				}
				window.location.href='/user/addmoney.go?sessionId1='+one+'&sessionId2='+one+'&addmoney='+m+'&bankid='+bankid+'&tkType='+tkType+'&notifyUrl='+notifyUrl+'&callbackUrl=http://4g.9188.com/useraccount/&merchantUrl=http://4g.9188.com/useraccount/';
			},
			error:function(){
				window.location.href='/user/addmoney.go?sessionId1='+one+'&sessionId2='+one+'&addmoney='+m+'&bankid='+bankid+'&tkType='+tkType+'&notifyUrl='+notifyUrl+'&callbackUrl=http://4g.9188.com/useraccount/&merchantUrl=http://4g.9188.com/useraccount/';
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
		var comeFrom = localStorage.getItem('comeFrom');
		
		//支付宝网页版
		$('#pay_con1 a:eq(0)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else{
				zfb_pay('0',money);
			}
		});
		
		//微信充值
		$('#pay_con1 a:eq(1)').bind('click',function(){
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
		
		//储蓄卡-支付宝
		$('#pay_con1 a:eq(3)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else if(money>2000){
				D.alert('单笔单日不能超过2000元');
			}else{
				zfb_pay('1',money);
			}	
		});
		
		//信用卡快捷-支付宝
		$('#pay_con1 a:eq(4)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else if(money>2000){
				D.alert('单笔单日不能超过2000元');
			}else{
				zfb_pay('2',money);
			}
		});
		
		//储蓄卡电话充值
		$('#pay_con2 a:eq(0)').bind('click',function(){
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
		$('#pay_con1 a:eq(5)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else if(money>1000){
				D.alert('单笔不能超过1000元');
			}else{
				window.location.href='/user/addmoney.go?bankid=2070&addmoney='+money;
			}
		});
		
		//建行充值
		$('#pay_con1 a:eq(6)').bind('click',function(){
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
		$('#pay_con1 a:eq(7)').bind('click',function(){
			var money = $.trim($('.moneyNum').val());
			if(money == '' || money<1){
				D.alert('最小充值1元');
			}else{
				window.location.href='/user/addmoney.go?bankid=20&addmoney='+money;
			}
		});
		
		if(comeFrom=="cib"){//兴业充值
			$('#pay_con1 a:eq(7)').show();
			$('#pay_con1 a:eq(7)').siblings().hide();
		}else if(comeFrom=="ccb"){//建行充值
			$('#pay_con1 a:eq(6)').show();
			$('#pay_con1 a:eq(6)').siblings().hide();
		}else{
			$('#pay_con1 a:eq(6)').hide();
			$('#pay_con1 a:eq(7)').hide();
			$('#pay_con1 a').not("a:eq(6)").not("a:eq(7)").show();
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