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


var tmp = JSON.parse(localStorage.getItem("tmp"));

var XHC={};
XHC.XYK=(function(){
	var init=function(){
		load_city();
		var v = parseInt($("#num_1").val());
		if(tmp&&tmp!=null&&v){
			$("#s_repaymentSelect cite").html(tmp.city)
			summary(v,tmp);
		}else{
			$("#s_repaymentSelect cite").html("请选择城市")
		}
		
		bindEvent();
	};
	
	//初始化银行信息,期次信息
	var init_bank=function(){
		
	};
	
	//绑定银行选值，期次选值事件
	var bindEvent=function(){
		$(".mask,.repaymentList").click(function(e){
			$(".mask").hide();
			$(".repaymentList").hide();
			e.stopPropagation();
		})
		
		
		$("#s_repaymentSelect").bind("click",function(e){
			//var t = $(document).height();
			//$(".repaymentList").height(t)
			
			$(".repaymentList").show();
			$(".mask").show();
			
			e.stopPropagation();
			//load_city();
			
		});
		
		
		
		$(".repaymentList").delegate("div ul li","click",function(e){
			tmp = JSON.parse($(this).attr("p"));
			var t = $(this).html();
			$("#s_repaymentSelect cite").html(t);
			$(".mask").hide();
			$(".repaymentList").hide();
			
			var v = parseInt($("#num_1").val());
			summary(v,tmp);
			e.stopPropagation();
		});
		
		$("#num_1").keyup(function(){
			var v = $(this).val();
			var exp = /^[0-9]*[1-9][0-9]*$/;
			if(exp.test(v)){
				if(parseInt(v)>=10000000){
					v=9999999;
					$(this).val(v)
				}
				summary(v,tmp);
			}
			
		});
		
		$("#btn").bind("click",function(){
			var t=$("#num_1").val()
			localStorage.setItem("tmp",JSON.stringify(tmp));
			localStorage.setItem("sum",$("#num_1").val());
			if(tmp && tmp!=null && t){
				window.location.href="jsmx.html";
			}
		})
		
	};
	
	var load_city=function(){
		var t = $(document).height();
		$(".repaymentList").height(t)
		var html="";
		$.ajax({
			url:'/news/ad/82.xml',
			type: 'get',
			dataType: 'xml',
			success: function(xml){
				var R = $(xml).find("Resp");
				var row = R.find("row");
				
				row.each(function(){
					var type = $(this).attr("type");
					var hot = $(this).find("hot");
					
					html+='<div>'
					html+='<span>'+type+'</span>'
					html+='<ul class="cslist">'
						hot.each(function(){
							var t={};
							var single_pension = t.single_pension = $(this).attr("single_pension");
							var single_company =t.single_company = $(this).attr("single_company");
							var single_medical = t.single_medical = $(this).attr("single_medical");
							var company_medical = t.company_medical =  $(this).attr("company_medical");
							var single_unemployment = t.single_unemployment = $(this).attr("single_unemployment");
							var company_unemployment =t.company_unemployment = $(this).attr("company_unemployment");
							var company_injury = t.company_injury = $(this).attr("company_injury");
							var company_bear = t.company_bear = $(this).attr("company_bear");
							var company_CIB = t.company_CIB = $(this).attr("company_CIB");
							var company_CPF = t.company_CPF = $(this).attr("company_CPF");
							var single_CPF = t.single_CPF = $(this).attr("single_CPF");
							
							var pension_max = t.pension_max = $(this).attr("pension_max");
							var pension_min = t.pension_min = $(this).attr("pension_min");
							var medical_max = t.medical_max = $(this).attr("medical_max");
							var medical_min = t.medical_min = $(this).attr("medical_min");
							var unemploy_max = t.unemploy_max = $(this).attr("unemploy_max");
							var unemploy_min = t.unemploy_min = $(this).attr("unemploy_min");
							var injury_max = t.injury_max = $(this).attr("injury_max");
							var injury_min = t.injury_min = $(this).attr("injury_min");
							var fertility_max = t.fertility_max = $(this).attr("fertility_max");
							var fertility_min = t.fertility_min = $(this).attr("fertility_min");
							var provident_max = t.provident_max = $(this).attr("provident_max");
							var provident_min = t.provident_min = $(this).attr("provident_min");
							
							var city =t.city = $(this).attr("city");
							html+='<li p='+JSON.stringify(t)+'>'+city+'</li>'
						});
					html+='</ul>'
					html+='</div>'
				})
				
				
				$(".repaymentList").html(html);
				
			}
		})
	}
	
	var summary=function(money,obj){
		//var v = $("#num_1").val();
		
		if(money && money>999 && obj!=null){
			var sq_salary = money;//税前工资
			$(".info dl:eq(0) dd").html(sq_salary);
			
			var single_pension_num;
			
			if(parseInt(money)>=obj.pension_max){
				single_pension_num = turn_per(obj.pension_max,obj.single_pension);//个人养老
			}else if(parseInt(money)<obj.pension_min){
				single_pension_num = turn_per(obj.pension_min,obj.single_pension);//个人养老
			}else{
				single_pension_num = turn_per(money,obj.single_pension);//个人养老
			}
			
			var single_company_num;
			if(parseInt(money)>=obj.pension_max){
				single_company_num = turn_per(obj.pension_max,obj.single_company);//个人养老
			}else if(parseInt(money)<obj.pension_min){
				single_company_num = turn_per(obj.pension_min,obj.single_company);//个人养老
			}else{
				single_company_num = turn_per(money,obj.single_company);//个人养老
			}
			
			//var single_company_num = turn_per(money,obj.single_company);//单位养老
			
			var single_medical_num;
			if(parseInt(money)>=obj.medical_max){
				single_medical_num = turn_per(obj.medical_max,obj.single_medical);//个人养老
			}else if(parseInt(money)<obj.medical_min){
				single_medical_num = turn_per(obj.medical_min,obj.single_medical);//个人养老
			}else{
				single_medical_num = turn_per(money,obj.single_medical);//个人养老
			}
			
			var company_medical_num;
			if(parseInt(money)>=obj.medical_max){
				var company_medical_num = turn_per(obj.medical_max,obj.company_medical);//个人养老
			}else if(parseInt(money)<obj.medical_min){
				var company_medical_num = turn_per(obj.medical_min,obj.company_medical);//个人养老
			}else{
				var company_medical_num = turn_per(money,obj.company_medical);//个人养老
			}
			
			//var single_unemployment_num = turn_per(money,obj.single_unemployment);//个人养老
			var single_unemployment_num;
			if(parseInt(money)>=obj.unemploy_max){
				single_unemployment_num = turn_per(obj.unemploy_max,obj.single_unemployment);//个人养老
			}else if(parseInt(money)<obj.unemploy_min){
				single_unemployment_num = turn_per(obj.unemploy_min,obj.single_unemploymen);//个人养老
			}else{
				single_unemployment_num = turn_per(money,obj.single_unemployment);//个人养老
			}
			
			//var company_unemployment_num = turn_per(money,obj.company_unemployment);//个人养老
			var company_unemployment_num;
			if(parseInt(money)>=obj.unemploy_max){
				company_unemployment_num = turn_per(obj.unemploy_max,obj.company_unemployment);//个人养老
			}else if(parseInt(money)<obj.unemploy_min){
				company_unemployment_num = turn_per(obj.unemploy_min,obj.company_unemployment);//个人养老
			}else{
				company_unemployment_num = turn_per(money,obj.company_unemployment);//个人养老
			}
			
			//var company_injury_num = turn_per(money,obj.company_injury);//个人养老
			var company_injury_num
			if(parseInt(money)>=obj.injury_max){
				company_injury_num = turn_per(obj.injury_max,obj.company_injury);//个人养老
			}else if(parseInt(money)<obj.injury_min){
				company_injury_num = turn_per(obj.injury_min,obj.company_injury);//个人养老
			}else{
				company_injury_num = turn_per(money,obj.company_injury);//个人养老
			}
			
			//var company_bear_num = turn_per(money,obj.company_bear);//个人养老
			var company_bear_num;
			if(parseInt(money)>=obj.fertility_max){
				company_bear_num = turn_per(obj.fertility_max,obj.company_bear);//个人养老
			}else if(parseInt(money)<obj.fertility_min){
				company_bear_num = turn_per(obj.fertility_min,obj.company_bear);//个人养老
			}else{
				company_bear_num = turn_per(money,obj.company_bear);//个人养老
			}
			
			var company_CIB_num = turn_per(money,obj.company_CIB);//个人养老
			
			//var company_CPF_num = turn_per(money,obj.company_CPF);//个人养老
			var company_CPF_num;
			if(parseInt(money)>=obj.provident_max){
				company_CPF_num = turn_per(obj.provident_max,obj.company_CPF);//个人养老
			}else if(parseInt(money)<obj.provident_min){
				company_CPF_num = turn_per(obj.provident_min,obj.company_CPF);//个人养老
			}else{
				company_CPF_num = turn_per(money,obj.company_CPF);//个人养老
			}
			
			//var single_CPF_num = turn_per(money,obj.single_CPF);//个人养老
			var single_CPF_num;
			if(parseInt(money)>=obj.provident_max){
				single_CPF_num = turn_per(obj.provident_max,obj.single_CPF);//个人养老
			}else if(parseInt(money)<obj.provident_min){
				single_CPF_num = turn_per(obj.provident_min,obj.single_CPF);//个人养老
			}else{
				single_CPF_num = turn_per(money,obj.single_CPF);//个人养老
			}
			
			
			
			//五险一金(个人)
			var wxyj = (single_pension_num+single_medical_num+single_unemployment_num+single_CPF_num).toFixed(2);
			$(".info dl:eq(2) dd").html(wxyj);
			
			//交个人所得税额=(工资5800元-个人交五险一金金额1044元-个人所得税扣除额3500(元)*税率3%-速算扣除数0元=37.68元。
			//应纳税额=6000 - 6000 x (8% + 2% + 1% + 8%) - 3500 = 1360（元）
			//应缴个人所得税
			var y_num=0;
			var y=money-wxyj-3500;
			if(y<1500&&y>=0){
				y_num=y*0.03;
			}else if(y>=1500&&y<4500){
				y_num=y*0.1-105
			}else if(y>=4500&&y<9000){
				y_num=y*0.2-555
			}else if(y>=9000&&y<35000){
				y_num=y*0.25-1005
			}else if(y>=35000&&y<55000){
				y_num=y*0.3-2755
			}else if(y>=55000&&y<80000){
				y_num=y*0.35-5505
			}else if(y>=80000){
				y_num=y*0.45-13505
			}else{
				y_num=0;
			}
			$(".info dl:eq(3) dd").html(y_num.toFixed(2));
			
			$(".info dl:eq(1) dd").html((money-wxyj-y_num).toFixed(2));
			
			$(".bottomDiv").show();
		}else{
			$(".info dl:eq(3) dd").html("0.00");
			
			$(".info dl:eq(1) dd").html("0.00");
			$(".info dl:eq(2) dd").html("0.00");
			$(".info dl:eq(0) dd").html("0.00");
			$(".bottomDiv").hide();
		}
		
	};
	
	var turn_per=function(money,percent){
		var sum=0;
		if(percent){
			if(percent.indexOf("+")!=-1){
				var arr = percent.split("+");
				var m = arr[0];
				var n = arr[1];
				
				if(m.indexOf("%")!=-1){
					var m_arr = m.split("%");
					var m_num=(parseFloat(m_arr[0]/100));
					
					sum = (money*m_num+parseFloat(n));
				}
				
				if(n.indexOf("%")!=-1){
					var n_arr = n.split("%");
					var n_num=(parseFloat(n_arr[0]/100));
					
					sum = money*n_num+paseFloat(m);
				}
				
			}else{
				var p_arr = percent.split("%")
				var p_num=(parseFloat(p_arr[0]/100));
				sum = money*p_num;
			}
		}
		
		
		return sum;
	};
	
	return {
		init:init
	};
})();

$(function(){
	XHC.XYK.init();
})
