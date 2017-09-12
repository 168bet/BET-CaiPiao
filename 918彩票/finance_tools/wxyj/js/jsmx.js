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
var money = localStorage.getItem("sum");

var XHC={};
XHC.XYK=(function(){
	var init=function(){
		
		load_city();
		bindEvent();
	};
	
	//初始化银行信息,期次信息
	var init_bank=function(){
		
	};
	
	//绑定银行选值，期次选值事件
	var bindEvent=function(){
		
	};
	
	var load_city=function(){
		$(".mxlist li:eq(1) span:eq(1)").html(tmp.single_pension);
		$(".mxlist li:eq(1) span:eq(2)").html(tmp.single_company);
		
		$(".mxlist li:eq(2) span:eq(1)").html(tmp.single_medical);
		$(".mxlist li:eq(2) span:eq(2)").html(tmp.company_medical);
		
		$(".mxlist li:eq(3) span:eq(1)").html(tmp.single_unemployment);
		$(".mxlist li:eq(3) span:eq(2)").html(tmp.company_unemployment);
		
		$(".mxlist li:eq(4) span:eq(1)").html(0);
		$(".mxlist li:eq(4) span:eq(2)").html(tmp.company_injury);
		
		$(".mxlist li:eq(5) span:eq(1)").html(0);
		$(".mxlist li:eq(5) span:eq(2)").html(tmp.company_bear);
		
		$(".mxlist li:eq(6) span:eq(1)").html(tmp.single_CPF);
		$(".mxlist li:eq(6) span:eq(2)").html(tmp.company_CPF);
		
		
		var single_pension_num;
		
		if(parseInt(money)>=tmp.pension_max){
			single_pension_num = turn_per(tmp.pension_max,tmp.single_pension);//个人养老
		}else if(parseInt(money)<tmp.pension_min){
			single_pension_num = turn_per(tmp.pension_min,tmp.single_pension);//个人养老
		}else{
			single_pension_num = turn_per(money,tmp.single_pension);//个人养老
		}
		
		var single_company_num;
		if(parseInt(money)>=tmp.pension_max){
			single_company_num = turn_per(tmp.pension_max,tmp.single_company);//个人养老
		}else if(parseInt(money)<tmp.pension_min){
			single_company_num = turn_per(tmp.pension_min,tmp.single_company);//个人养老
		}else{
			single_company_num = turn_per(money,tmp.single_company);//个人养老
		}
		
		//var single_company_num = turn_per(money,tmp.single_company);//单位养老
		
		var single_medical_num;
		if(parseInt(money)>=tmp.medical_max){
			single_medical_num = turn_per(tmp.medical_max,tmp.single_medical);//个人养老
		}else if(parseInt(money)<tmp.medical_min){
			single_medical_num = turn_per(tmp.medical_min,tmp.single_medical);//个人养老
		}else{
			single_medical_num = turn_per(money,tmp.single_medical);//个人养老
		}
		
		var company_medical_num;
		if(parseInt(money)>=tmp.medical_max){
			var company_medical_num = turn_per(tmp.medical_max,tmp.company_medical);//个人养老
		}else if(parseInt(money)<tmp.medical_min){
			var company_medical_num = turn_per(tmp.medical_min,tmp.company_medical);//个人养老
		}else{
			var company_medical_num = turn_per(money,tmp.company_medical);//个人养老
		}
		
		//var single_unemployment_num = turn_per(money,tmp.single_unemployment);//个人养老
		var single_unemployment_num;
		if(parseInt(money)>=tmp.unemploy_max){
			single_unemployment_num = turn_per(tmp.unemploy_max,tmp.single_unemployment);//个人养老
		}else if(parseInt(money)<tmp.unemploy_min){
			single_unemployment_num = turn_per(tmp.unemploy_min,tmp.single_unemploymen);//个人养老
		}else{
			single_unemployment_num = turn_per(money,tmp.single_unemployment);//个人养老
		}
		
		//var company_unemployment_num = turn_per(money,tmp.company_unemployment);//个人养老
		var company_unemployment_num;
		if(parseInt(money)>=tmp.unemploy_max){
			company_unemployment_num = turn_per(tmp.unemploy_max,tmp.company_unemployment);//个人养老
		}else if(parseInt(money)<tmp.unemploy_min){
			company_unemployment_num = turn_per(tmp.unemploy_min,tmp.company_unemployment);//个人养老
		}else{
			company_unemployment_num = turn_per(money,tmp.company_unemployment);//个人养老
		}
		
		//var company_injury_num = turn_per(money,tmp.company_injury);//个人养老
		var company_injury_num
		if(parseInt(money)>=tmp.injury_max){
			company_injury_num = turn_per(tmp.injury_max,tmp.company_injury);//个人养老
		}else if(parseInt(money)<tmp.injury_min){
			company_injury_num = turn_per(tmp.injury_min,tmp.company_injury);//个人养老
		}else{
			company_injury_num = turn_per(money,tmp.company_injury);//个人养老
		}
		
		//var company_bear_num = turn_per(money,tmp.company_bear);//个人养老
		var company_bear_num;
		if(parseInt(money)>=tmp.fertility_max){
			company_bear_num = turn_per(tmp.fertility_max,tmp.company_bear);//个人养老
		}else if(parseInt(money)<tmp.fertility_min){
			company_bear_num = turn_per(tmp.fertility_min,tmp.company_bear);//个人养老
		}else{
			company_bear_num = turn_per(money,tmp.company_bear);//个人养老
		}
		
		var company_CIB_num = turn_per(money,tmp.company_CIB);//个人养老
		
		//var company_CPF_num = turn_per(money,tmp.company_CPF);//个人养老
		var company_CPF_num;
		if(parseInt(money)>=tmp.provident_max){
			company_CPF_num = turn_per(tmp.provident_max,tmp.company_CPF);//个人养老
		}else if(parseInt(money)<tmp.provident_min){
			company_CPF_num = turn_per(tmp.provident_min,tmp.company_CPF);//个人养老
		}else{
			company_CPF_num = turn_per(money,tmp.company_CPF);//个人养老
		}
		
		//var single_CPF_num = turn_per(money,tmp.single_CPF);//个人养老
		var single_CPF_num;
		if(parseInt(money)>=tmp.provident_max){
			single_CPF_num = turn_per(tmp.provident_max,tmp.single_CPF);//个人养老
		}else if(parseInt(money)<tmp.provident_min){
			single_CPF_num = turn_per(tmp.provident_min,tmp.single_CPF);//个人养老
		}else{
			single_CPF_num = turn_per(money,tmp.single_CPF);//个人养老
		}
		
		
		var wxyj = (single_pension_num+single_medical_num+single_unemployment_num+single_CPF_num).toFixed(2);
		$(".mxlist li:eq(7) span:eq(1)").html(wxyj);
		
		
		var c_wxyj=(single_company_num+company_medical_num+company_unemployment_num+company_injury_num+company_bear_num+company_CPF_num).toFixed(2)
		$(".mxlist li:eq(7) span:eq(2)").html(c_wxyj);
		
		var y= (money-wxyj-3500).toFixed(2)
		if(money-wxyj>3500){
			//y= (money-wxyj-3500).toFixed(2)
			$("#ns p:eq(0)").html('应缴纳所得额='+money+' - '+wxyj+' - 3500 = '+y)
		}else{
			$("#ns p:eq(0)").html('不需要缴纳个人所得税')
		}
		
		
		
		
		
		
		var y_num=0;
		if(y<1500&&y>=0){
			y_num=y*0.03;
			$("#ns p:eq(1)").html('应纳税额='+y+' x 3% ='+y_num.toFixed(2))
		}else if(y>=1500&&y<4500){
			y_num=y*0.1-105
			$("#ns p:eq(1)").html('应纳税额='+y+' x 10% - 105 = '+y_num.toFixed(2))
		}else if(y>=4500&&y<9000){
			y_num=y*0.2-555
			$("#ns p:eq(1)").html('应纳税额='+y+' x 20% - 555 = '+y_num.toFixed(2))
		}else if(y>=9000&&y<35000){
			y_num=y*0.25-1005
			$("#ns p:eq(1)").html('应纳税额='+y+' x 25% - 1005 = '+y_num.toFixed(2))
		}else if(y>=35000&&y<55000){
			y_num=y*0.3-2755
			$("#ns p:eq(1)").html('应纳税额='+y+' x 30% - 2755 = '+y_num.toFixed(2))
		}else if(y>=55000&&y<80000){
			y_num=y*0.35-5505
			$("#ns p:eq(1)").html('应纳税额='+y+' x 35% - 5505 = '+y_num.toFixed(2))
		}else if(y>=80000){
			y_num=y*0.45-13505
			$("#ns p:eq(1)").html('应纳税额='+y+' x 45% - 13505 = '+y_num.toFixed(2))
		}else{
			y_num=0;
			$("#ns p:eq(1)").html('不需要缴纳个人所得税')
		}
		
		
		$("#gz").html('税后工资 = '+money+' - '+wxyj+' - '+y_num.toFixed(2)+' = '+(money-wxyj-y_num).toFixed(2));
		
	}
	
	var summary=function(money,obj){
		//var v = $("#num_1").val();
		var sq_salary = money;//税前工资
		$(".info dl:eq(0) dd").html(sq_salary);
		
		var single_pension_num = turn_per(money,obj.single_pension);//个人养老
		var single_company_num = turn_per(money,obj.single_company);//单位养老
		var single_medical_num = turn_per(money,obj.single_medical);//
		var company_medical_num = turn_per(money,obj.company_medical);//个人养老
		var single_unemployment_num = turn_per(money,obj.single_unemployment);//个人养老
		var company_unemployment_num = turn_per(money,obj.company_unemployment);//个人养老
		var company_injury_num = turn_per(money,obj.company_injury);//个人养老
		var company_bear_num = turn_per(money,obj.company_bear);//个人养老
		var company_CIB_num = turn_per(money,obj.company_CIB);//个人养老
		var company_CPF_num = turn_per(money,obj.company_CPF);//个人养老
		var single_CPF_num = turn_per(money,obj.single_CPF);//个人养老
		
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
