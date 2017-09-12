
var SIGN={};
var point=0;
var remainday_fb=0;
var remainday_vip=0;
/**
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

**/



SIGN=(function(){
	

	var keycolor=function(){//根据当前购买的翻倍卡类型确定按钮是否为灰不可点击
		$.ajax({
			url:"/grounder/fgoldenbeanaccount.go?flag=0&qtype=9	",
			dataType:'xml',
			cache:true,
			success: function(data) {				
	     	    var R = $(data).find("Resp");
	     	    var cardinfo =R.find("cardinfo");
	     	    var row=cardinfo.find("row");
     	    
	     	    
				if(row.length>0){
					row.each(function(i){

						var type  = $(this).attr("type");
						var remainday  = $(this).attr("remainday");

						if(type==1 || type==2){//翻倍卡不可以购买
							remainday_fb=remainday;							
				     		  $("#bcard").removeClass("gm1");
				     		  $("#bcard").addClass("y_gm1");		  
				     		  $("#kcard").removeClass("gm1");
				     		  $("#kcard").addClass("y_gm1")								
						}else if(type==3 || type==4 || type==5){
							remainday_vip=remainday;	
				     		  $("#vip1").removeClass("gm1");
				     		  $("#vip1").addClass("y_gm1");		  
				     		  $("#vip2").removeClass("gm1");
				     		  $("#vip2").addClass("y_gm1");	
				     		  $("#vip3").removeClass("gm1");
				     		  $("#vip3").addClass("y_gm1");	
						}
						
						
					})
				}else{
					remainday_fb=0;
					remainday_vip=0;
				}
	     	    
     	    
	  	    /**
	     	    var ctype=row.attr("ctype");
	     	    var ibuy=row.attr("ibuy");	
	     	    remainday=row.attr("remainday");//有效期剩余天数	     	    

	     	   
	     	   
	     	   if(ibuy==0  ){ //不购买可以
	     		  $("#bcard").removeClass("gm1");
	     		  $("#bcard").addClass("y_gm1");		  
	     		  $("#kcard").removeClass("gm1");
	     		  $("#kcard").addClass("y_gm1");  	
	     		 // alert("您已经购买'签到翻倍卡了'")
	     	   }else{
		     	 $("#bcard").removeClass("y_gm");
		     	 $("#bcard").addClass("gm");
		     	 $("#kcard").removeClass("y_gm");
		     	 $("#kcard").addClass("gm");	     	   	     	   
	     	   }   
	     	   **/
			}
		});				
	};
	
	
	var mypoint=function(){//取积分余额
		$.ajax({
			url:"/user/mlottery.go?flag=40",
			dataType:'xml',
			cache:true,
			success: function(data) {
				var R = $(data).find("Resp");     	   
	     	   code=parseInt(R.attr("code"));
	     	   
	     	   if(code==1){
	     		   window.location.href="/gq2/login.html"
	     	   }else{
		     	   	point=parseInt(R.attr("point"));
		     	    $(".result").html(point);  
	     	   }


				
			}
		});			
		
	};
	
	
	

	
	
	var buy=function(ctype){ //购买道具	
		$.ajax({
			url:"/grounder/goldenbeanaccount.go?flag=1&utype=5&ctype="+ctype,
			dataType:'xml',
			cache:true,
			success: function(data) {
				
	     	    var R = $(data).find("Resp");
				var code = R.attr('code');
				var desc = R.attr('desc');

				if(code=="0"){
					alert("恭喜您，购买成功！");
					mypoint();
					keycolor();
				}else if(code=="3"){
					alert("您已经购买过翻倍卡了,有效期还剩"+remainday_fb+"天")
				}else{
					alert(desc);

				}
				
				$(".ceng").hide();	
				$("#b_buy").hide();	
				$("#k_buy").hide();	
				$("#vip1_buy").hide();	
				$("#vip2_buy").hide();	
				$("#vip3_buy").hide();	

				

			}
		});
		
		
	};
	

	
	var bind=function(){//绑定事件
		
		//***********************************************************************		
		$("#bcard").bind("click",function(){//百倍卡点击出现弹窗
			if($("#bcard").hasClass("gm1")){
				
				if(point>=14000){	//		if(point>=14000){	888888		
					$("#b_buy").show();	
				}else{				
					$("#czms").html("积分余额不足，还差 <span style='color:#60c081'>"+(14000-point)+"</span> 积分，请充值~");					
					$("#b_cz").show();	
				}
				$(".ceng").show();				

			}else{
				alert("您已经购买过翻倍卡了,有效期还剩"+remainday_fb+"天")
			}

		})		
		$("#bsure_buy").bind("click",function(){	//百倍卡弹窗确定购买		
			buy(1);
		})
		$("#bclose").bind("click",function(){	//百倍卡弹窗取消		

			$("#b_buy").hide();	
			$(".ceng").hide();	

		})

		$("#czclose").bind("click",function(){	//请充值 弹窗取消		
			$("#b_cz").hide();	
			$(".ceng").hide();				
		})	
		$("#cz_go").bind("click",function(){	//请充值 弹窗取消		
			window.location.href="/user/jfcz.html";			
		})
		//***********************************************************************
		$("#kcard").bind("click",function(){//千倍卡点击出现弹窗	
			if($("#kcard").hasClass("gm1")){
				
				if(point>=120000){				//88888888	 point>=120000)
					$("#k_buy").show();	
				}else{				
					$("#kczms").html("积分余额不足，还差 <span style='color:#60c081'>"+(120000-point)+"</span> 积分，请充值~");					
					$("#k_cz").show();	
				}
				$(".ceng").show();				

			}else{
				alert("您已经购买过翻倍卡了,有效期还剩"+remainday_fb+"天")
			}
	
		})		
		$("#ksure_buy").bind("click",function(){	//千倍卡弹窗确定购买		
			buy(2);
		})
		$("#kclose").bind("click",function(){	//千倍卡弹窗取消		

			$("#k_buy").hide();	
			$(".ceng").hide();	

			
		})	
		
		$("#kczclose").bind("click",function(){	//请充值 弹窗取消		
			$("#k_cz").hide();	
			$(".ceng").hide();				
		})	
		$("#kcz_go").bind("click",function(){	//请充值 弹窗取消		
			window.location.href="/user/jfcz.html";			
		})
		
		//***********************************************************************
		$("#vip1").bind("click",function(){//vip卡点击出现弹窗
			if($("#vip1").hasClass("gm1")){
				
				if(point>=150000){	//		if(point>=14000){	888888		
					$("#vip1_buy").show();	
				}else{				
					$("#vip1_ms").html("积分余额不足，还差 <span style='color:#60c081'>"+(150000-point)+"</span> 积分，请充值~");					
					$("#vip1_cz").show();	
				}
				$(".ceng").show();				

			}else{
				alert("您已经购买过会员卡了,有效期还剩"+remainday_vip+"天")
			}

		})		
		$("#vip1_buy span:eq(2)").bind("click",function(){	//vip卡弹窗确定购买		
			buy(3);
		})
		$("#vip1_buy span:eq(1)").bind("click",function(){	//vip卡弹窗取消		

			$("#vip1_buy").hide();	
			$(".ceng").hide();	

		})

		$("#vip1_cz span:eq(0)").bind("click",function(){	//请充值 弹窗取消		
			$("#vip1_cz").hide();	
			$(".ceng").hide();				
		})	
		$("#vip1_cz span:eq(1)").bind("click",function(){	//请充值 		
			window.location.href="/user/jfcz.html";			
		})
		//***********************************************************************

		$("#vip2").bind("click",function(){//vip2卡点击出现弹窗
			if($("#vip2").hasClass("gm1")){
				
				if(point>=330000){	//		if(point>=14000){	888888		
					$("#vip2_buy").show();	
				}else{				
					$("#vip2_ms").html("积分余额不足，还差 <span style='color:#60c081'>"+(330000-point)+"</span> 积分，请充值~");					
					$("#vip2_cz").show();	
				}
				$(".ceng").show();				

			}else{
				alert("您已经购买过会员卡了,有效期还剩"+remainday_vip+"天")
			}

		})		
		$("#vip2_buy span:eq(2)").bind("click",function(){	//vip2卡弹窗确定购买		
			buy(4);
		})
		$("#vip2_buy span:eq(1)").bind("click",function(){	//vip2卡弹窗取消		

			$("#vip2_buy").hide();	
			$(".ceng").hide();	

		})

		$("#vip2_cz span:eq(0)").bind("click",function(){	//请充值 弹窗取消		
			$("#vip2_cz").hide();	
			$(".ceng").hide();				
		})	
		$("#vip2_cz span:eq(1)").bind("click",function(){	//请充值 		
			window.location.href="/user/jfcz.html";			
		})
		//***********************************************************************
			
		$("#vip3").bind("click",function(){//vip3卡点击出现弹窗
			if($("#vip3").hasClass("gm1")){
				
				if(point>=880000){	//		if(point>=14000){	888888		
					$("#vip3_buy").show();	
				}else{				
					$("#vip3_ms").html("积分余额不足，还差 <span style='color:#60c081'>"+(880000-point)+"</span> 积分，请充值~");					
					$("#vip3_cz").show();	
				}
				$(".ceng").show();				

			}else{
				alert("您已经购买过会员卡了,有效期还剩"+remainday_vip+"天")
			}

		})		
		$("#vip3_buy span:eq(2)").bind("click",function(){	//vip3卡弹窗确定购买		
			buy(5);
		})
		$("#vip3_buy span:eq(1)").bind("click",function(){	//vip3卡弹窗取消		

			$("#vip3_buy").hide();	
			$(".ceng").hide();	

		})

		$("#vip3_cz span:eq(0)").bind("click",function(){	//请充值 弹窗取消		
			$("#vip3_cz").hide();	
			$(".ceng").hide();				
		})	
		$("#vip3_cz span:eq(1)").bind("click",function(){	//请充值 		
			window.location.href="/user/jfcz.html";			
		})
		//***********************************************************************
		
		
	

		


	
	
	};
	var remove_header=function(){
		var arg = localStorage.getItem("from");
		if(arg){
			$(".tzHeader").hide();
		}else{
			$(".tzHeader").show();
		}
	}
	
	var init=function(){
		remove_header();
		bind();
		keycolor();
		mypoint();
	};	
	
	
	return {
		init:init
	}
	
})()





$(function(){
	SIGN.init();
})




/**


		$("#sign").bind("click",function(){
			if($(this).html()=="签到领金豆"){
				$.ajax({
					url:"/grounder/goldenbeanaccount.go?flag=1&utype=0&qtype=0",
					dataType:'xml',
					cache:true,
					success: function(xml) {
						
					}
				});
			}else if($(this).html()=="已签到"){
				return;
			}
		})

*/