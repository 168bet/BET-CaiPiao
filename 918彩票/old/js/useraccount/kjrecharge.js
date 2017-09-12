var money = location.search.getParam("money");
$(function(){
	var realMoney = money-money*0.01;
	var fee = money*0.01;
	$("#add cite:eq(0)").html(realMoney);
	$("#add cite:eq(1)").html(fee);
	$("#next").bind("click",function(){
		//获取银行卡信息
		var val = $("#No_card").val();//获取银行卡号
		if(!val){
			return;
		}
		//6217858000018625670
		$.ajax({
			url : "/user/getbankinfo.go?coupon="+val,
			type : "POST",
			dataType : "JSON",
			success:function(data){
				if(data && data !=null){
					var bank_code = data["bank_code"];//银行编号
					var bank_name = data["bank_name"];//银行名称
					var card_type = data["card_type"];//银行卡类型
					var ret_code = data["ret_code"];//查询结果代码
					var ret_msg = data["ret_msg"];//查询结果
					var sign = data["sign"];//查询结果签名
					var sign_type = data["sign_type"];//签名方式
					
					if(ret_code == "0000"){
						//获取连连支付是否支持某银行
						//url : "/user/isSpBankid.go?coupon=01040000&cardtype=2",
						$.ajax({
							url : "/user/isSpBankid.go?coupon="+bank_code+"&cardtype="+card_type,
							type : "POST",
							dataType : "xml",
							success:function(xml){
								var R = $(xml).find("Resp")
								var code = R.attr("code");
								var desc = R.attr("desc");
								if(code == "1"){//说明此卡支持连连支付
									//bankid:支付类型编号(2056:借记卡,2057:"信用卡")
									var bankid;
									if(card_type=="2"){//借记卡
										bankid="2056";
									}else if(card_type=="3"){//信用卡
										bankid="2057";
									}
									//bankCode:银行编号
									//coupon:银行卡号
									//addmoney:充值金额
									window.location.href="/user/addmoney.go?bankid="+bankid+"&bankCode="+bank_code+"&coupon="+val+"&addmoney="+money
								}else{
									D.alert("暂不支持");
								}
							}
						});
					}else{
						D.alert(ret_msg)
					}
				}
			}
		})
	})
})