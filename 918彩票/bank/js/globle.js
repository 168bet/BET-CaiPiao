var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);
	} else {
		$('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
		$('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
		$('#mask').show();
	}
};
var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};

//银行ID   银行卡ID  经纬度     城市名




var bankID_IMG={
		"14":{"img":"images/gongshang.png","c":"gongshang","rate":""},
		"4":{"img":"images/nongye.png","c":"nongye","rate":""},
		"15":{"img":"images/zhongguo.png","c":"zhongguo","rate":""},
		"13":{"img":"images/jianshe.png","c":"jianshe","rate":""},
		"16":{"img":"images/jiaotong.png","c":"jiaotong","rate":""},
		"11":{"img":"images/minsheng.png","c":"minsheng","rate":""},
		"3":{"img":"images/guangda.png","c":"guangda","rate":""},
		"2":{"img":"images/zhongxin.png","c":"zhongxin","rate":""},
		
		"21":{"img":"images/zhaoshang.png","c":"zhaoshang","rate":""},
		"10":{"img":"images/xingye.png","c":"xingye","rate":""},
		"9":{"img":"images/pufa.png","c":"pufa","rate":""},
		"1":{"img":"images/guangfa.png","c":"guangfa","rate":""},
		"7":{"img":"images/pingan.png","c":"pingan","rate":""},
		"8":{"img":"images/huaxia.png","c":"huaxia","rate":""},
		"99":{"img":"images/youzheng.png","c":"youzheng","rate":""}
};

//计算利息所需参数
var rate_param={
		bankid:"",
		qc:"",
		money:"",
		type:"",
		periods:""
};

var P={};

var XHC={};
XHC.XYK=(function(){
	var init=function(){
		init_bank_qc();
	};
	
	//初始化银行信息,期次信息
	var init_bank_qc=function(){
		var bankhtml="";
		var qchtml="";
		$.ajax({
			url:'/news/ad/78.xml',
			type: 'get',
			dataType: 'xml',
			success: function(xml){
				var R = $(xml).find("Resp");
				
				var r = R.find("row");
				r.each(function(i){
					var bankid=$(this).attr("bankid");
					var bankname=$(this).attr("bankname");
					var type=$(this).attr("type");
					var rate=$(this).attr("rate");
					var partner=$(this).attr("partner");
					var periods = $(this).attr("periods");
					var periods_arr=periods.split(",")
					var rate_arr=rate.split(",")
					bankID_IMG[bankid]["rate"]=rate;
					
					P[bankid] = {};
					for(var j =0;j<rate_arr.length;j++){
						P[bankid][periods_arr[j]]=rate_arr[j];
					}
					
					bankhtml+='<div class="clearfix bankInfo" periods="'+periods+'" bankid="'+bankid+'" bankname="'+bankname+'" rate="'+rate+'" type="'+type+'" partner="'+partner+'">';
					bankhtml+='<div class="bankIconDiv">';
					bankhtml+='<img src="'+bankID_IMG[bankid]["img"]+'" class="bankIcon">';
					bankhtml+='</div>';
					bankhtml+='<div class="bankTxt">'+bankname+'</div>';
					bankhtml+='</div>';
				});
				$(".bankList").html(bankhtml);
				
				bindEvent();
			}
		});
	};
	
	//绑定银行选值，期次选值事件
	var bindEvent=function(){
		$("#f_bankSelect").click(function(e){
			$(".mask").show();
			$(".bankList").show();
			$(".mask").click(function(){$(".mask").hide();$(".bankList").hide();})
			e.stopPropagation();
		});
		
		$("#s_repaymentSelect").click(function(e){
				var qchtml="";
				if(rate_param.bankid&&rate_param.bankid!=null){
					if(rate_param.periods&&rate_param.periods!=null){
						var periods_arr = rate_param.periods.split(",");
						
						//P[bankid] = {};
						for(var j =0;j<periods_arr.length;j++){
							//P[bankid][periods_arr[j]]=rate_arr[j];
							qchtml +='<div class="repaymentTxt">'+periods_arr[j]+' 期</div>';
						}
						$(".repaymentList").html(qchtml);
						$(".mask").show();
						$(".repaymentList").show();
					}else{
						alert("请您先选择银行");
					}
				}else{
					alert("请您先选择银行");
				}

			
			$(".mask").click(function(){$(".mask").hide();$(".repaymentList").hide();})
			e.stopPropagation();
		});	
		
		//选值银行
		$(".bankList").delegate("div.bankInfo","click",function(){
			var bankname = $(this).attr("bankname");
			var bankid = $(this).attr("bankid");
			var type = $(this).attr("type");
			var partner = $(this).attr("partner");
			var periods = $(this).attr("periods");
			
			
			$(this).find("div.bankTxt").html(bankname);
			
			$("#bankSelect").attr("class","");
			$("#bankSelect").attr("bankid","bankid");
			$("#bankSelect").addClass(bankID_IMG[bankid]["c"]).text(bankname);
			
			rate_param.bankid=bankid;
			rate_param.periods=periods;
			
			rate_param.qc="";
			
			$("#repaymentSelect").text("选择期数");
			//首次付清
			if(partner==1){
				$("#feeType").show();
				rate_param.type=null;
			}else{//分期付
				$("#feeType").hide();
				rate_param.type=type;
				
			}
			summary(rate_param);
			$(".mask").hide();$(".bankList").hide();
		});
		
		//选值期次
		$(".repaymentList").delegate("div.repaymentTxt","click",function(e){
			$("#repaymentSelect").text($(this).text()).css("color","#212121");
			rate_param.qc=parseInt($(this).text());
			
			
			summary(rate_param);
			$(".mask").hide();$(".repaymentList").hide();
			e.stopPropagation();
		});
		
		/***
		$(".inputMoney").keyup(function(){
			rate_param.money=$(this).val();
			summary(rate_param);
		});
		***/
		
		$(".inputMoney").bind("input propertychange",function(){
			rate_param.money=$(this).val();
			summary(rate_param);
		});
		
		
		$("#zhaoshangSelect").click(function(e){
			$(".ZhaoshangInfo").show();
			$(document).click(function(){$(".ZhaoshangInfo").hide();})
			e.stopPropagation();
		});
		
		
		$(".ZhaoshangInfo").delegate("div.zhaoshangTxt","click",function() {
			var index = $(this).index();
			if(index==0){
				rate_param.type="2";
			}else{
				rate_param.type="1";
			}
			//$("#zhaoshangSelect").text($(this).text()).css("color","#212121");
			
			summary(rate_param);
			
			$("#zhaoshangSelect").text($(this).text()).css("color","#212121");
			$(".ZhaoshangInfo").hide();
		});
		
		
		$("#bj").bind("click",function(){
			if($(this).hasClass("active")){
				rate_param.money=$(".inputMoney").val();
				window.location.href="price.html";
				localStorage.setItem("rate_param", JSON.stringify(rate_param));
				localStorage.setItem("P", JSON.stringify(P));
			}
		});
	};
	
	
	
	var summary=function(obj){
		var first_money,poundage,per_money,sum_money;
		var money = parseFloat($(".inputMoney").val());
		if(obj.bankid&&obj.qc&&P[obj.bankid][obj.qc]!="--"&&P[obj.bankid][obj.qc]!=null){
			if(obj.bankid!=null && obj.qc!=null && obj.type!=null && money){
				if(obj.type=="2"){//分期付款(每期收取手续费)
					first_money=parseFloat(money/obj.qc+money*P[obj.bankid][obj.qc]/obj.qc).toFixed(2);//首次还款(分期)
					poundage=parseFloat(money*P[obj.bankid][obj.qc]).toFixed(2);
					
					per_money = parseFloat(money/obj.qc+money*P[obj.bankid][obj.qc]/obj.qc).toFixed(2);//以后每期还款数
					sum_money = parseFloat(money+money*P[obj.bankid][obj.qc]).toFixed(2);//总还款数
					
					
				}else if(obj.type=="1"){//一次性收取手续费
					first_money=parseFloat(money/obj.qc+money*P[obj.bankid][obj.qc]).toFixed(2);//首次还款(一次性)
					poundage=parseFloat(money*P[obj.bankid][obj.qc]).toFixed(2);//手续费
					
					per_money = parseFloat(money/obj.qc).toFixed(2);//以后每期还款数
					sum_money = parseFloat(money+money*P[obj.bankid][obj.qc]).toFixed(2);//总还款数
				}
				$(".scope .info dl:eq(0) dd").html(first_money);
				$(".scope .info dl:eq(1) dd").html(poundage);
				
				$(".scope .info dl:eq(2) dd").html(per_money);
				$(".scope .info dl:eq(3) dd").html(sum_money);
				
				$("#bj").addClass("active");
			}else{
				$(".scope .info dl:eq(0) dd").html("0.00");
				$(".scope .info dl:eq(1) dd").html("0.00");
				
				$(".scope .info dl:eq(2) dd").html("0.00");
				$(".scope .info dl:eq(3) dd").html("0.00");
				
				$("#bj").removeClass("active");
			}
		}else{
			$(".scope .info dl:eq(0) dd").html("0.00");
			$(".scope .info dl:eq(1) dd").html("0.00");
			
			$(".scope .info dl:eq(2) dd").html("0.00");
			$(".scope .info dl:eq(3) dd").html("0.00");
			$("#bj").removeClass("active");
		}
		
		
	};
	
	return {
		init:init
	};
})();

$(function(){
	XHC.XYK.init();
})
