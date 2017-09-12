var rate_param=JSON.parse(localStorage.getItem("rate_param"));
var P=JSON.parse(localStorage.getItem("P"));

var XHC={};
XHC.XYK=(function(){
	var init=function(){
		
		render();
	};
	
	//初始化银行信息,期次信息
	var render=function(){
		var current_poundage=parseFloat(rate_param.money*P[rate_param.bankid][rate_param.qc]).toFixed(2);//手续费
		var bankhtml=$(".scope1").html();
		$.ajax({
			url:'/news/ad/78.xml',
			type: 'get',
			dataType: 'xml',
			success: function(xml){
				var R = $(xml).find("Resp");
				var periods = R.attr("periods");
				var periods_arr=periods.split(",")
				
				var r = R.find("row");
				r.each(function(i){
					var bankid=$(this).attr("bankid");
					var bankname=$(this).attr("bankname");
					var rate=$(this).attr("rate");
					var type=$(this).attr("type");
					var cardaddr = $(this).attr("cardaddr");
					
					
					
					var c=""
					var f_money="0.00";var per_money="0.00";
					
					if(P[bankid][rate_param.qc]!="--"&&P[bankid][rate_param.qc]!=null){
						var poundage=parseFloat(rate_param.money*P[bankid][rate_param.qc]).toFixed(2);//手续费
						if(poundage<current_poundage){
							c="green";
						}else if(poundage>current_poundage){
							c="red";
						}
						
						if(type==1){//一次性收取
							f_money=parseFloat(rate_param.money/rate_param.qc+rate_param.money*P[bankid][rate_param.qc]).toFixed(2);//首次还款(一次性)
							per_money = parseFloat(rate_param.money/rate_param.qc).toFixed(2);
						}else{
							f_money=parseFloat(rate_param.money/rate_param.qc+rate_param.money*P[bankid][rate_param.qc]/rate_param.qc).toFixed(2);
							per_money = parseFloat(rate_param.money/rate_param.qc+rate_param.money*P[bankid][rate_param.qc]/rate_param.qc).toFixed(2);//以后每期还款数
						}
					}else{
						f_money="--";
						per_money="--";
					}
					
					var fl = "";
					if(P[bankid][rate_param.qc]!="--" && P[bankid][rate_param.qc]!=null){
						fl = parseFloat(P[bankid][rate_param.qc]*100).toFixed(2)+"%"
					}else{
						fl="--"
					}
					
					
					
					bankhtml+='<ul class="price1 clearfix" bankid="'+bankid+'">'
					bankhtml+='<li class="width_22">'+bankname+'</li>'
				    bankhtml+='<li class="width_20"><span class="'+c+'">'+fl+'</span></li>'
					bankhtml+='<li class="width_22"><span>'+f_money+'</span></li>'
					bankhtml+='<li class="width_22">'+per_money+'</li>'
					if(!cardaddr){
						bankhtml+='<li class="width_14"><a href="javascript:;" class="apply_a">--</a></li>'
					}else{
						bankhtml+='<li class="width_14"><a href="'+cardaddr+'" class="apply_a">申请</a></li>'
					}
					
					bankhtml+='</ul>'
				});
				$(".scope1").html(bankhtml);
				//var t = $(".scope1 div.price1['bankid'='"+rate_param.bankid+"']")
				var t = $(".scope1 ul:eq(0)")
				//$(".scope1 ul.price1:eq(1)").insetBefore(t);
				t.after($(".scope1 ul.price1[bankid='"+rate_param.bankid+"']"));
				
				console.log(rate_param.bankid);
			}
		});
	};
	
	//绑定银行选值，期次选值事件
	var bindEvent=function(){
		
	};
	
	
	
	
	var summary=function(obj){
		var first_money,poundage,per_money,sum_money;
		var money = parseFloat($(".inputMoney").val());
		if(P[obj.bankid][obj.qc]!="--"&&P[obj.bankid][obj.qc]!=null){
			if(obj.bankid!=null && obj.qc!=null && obj.type!=null && money!=null){
				if(obj.type=="1"){//分期付款(每期收取手续费)
					first_money=parseFloat(money/obj.qc+money*P[obj.bankid][obj.qc]/obj.qc).toFixed(2);//首次还款(分期)
					poundage=parseFloat(money*P[obj.bankid][obj.qc]).toFixed(2);
					
					per_money = parseFloat(money/obj.qc+money*P[obj.bankid][obj.qc]/obj.qc).toFixed(2);//以后每期还款数
					sum_money = parseFloat(money+money*P[obj.bankid][obj.qc]).toFixed(2);//总还款数
					
					
				}else if(obj.type=="2"){//一次性收取手续费
					first_money=parseFloat(money/obj.qc+money*P[obj.bankid][obj.qc]).toFixed(2);//首次还款(一次性)
					poundage=parseFloat(money*P[obj.bankid][obj.qc]).toFixed(2);//手续费
					
					per_money = parseFloat(money/obj.qc).toFixed(2);//以后每期还款数
					sum_money = parseFloat(money+money*P[obj.bankid][obj.qc]).toFixed(2);//总还款数
				}
				$(".scope .info dl:eq(0) dd").html(first_money);
				$(".scope .info dl:eq(1) dd").html(poundage);
				
				$(".scope .info dl:eq(2) dd").html(per_money);
				$(".scope .info dl:eq(3) dd").html(sum_money);
			}
		}
		
		
	};
	
	return {
		init:init
	};
})();

$(function(){
	XHC.XYK.init();
})

