
var SIGN={};
var point=0;
var remainday=0;

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


SIGN=(function(){
	

	var keycolor=function(){//根据当前购买的翻倍卡类型确定按钮是否为灰不可点击
		$.ajax({
			url:"/grounder/fgoldenbeanaccount.go?flag=0&qtype=3	",
			dataType:'xml',
			cache:true,
			success: function(data) {				
	     	    var R = $(data).find("Resp");
	     	    var zhrecords=R.find("zhrecords");
	     	    var row=zhrecords.find("row");
	     	    var ctype=row.attr("ctype");
	     	    var ibuy=row.attr("ibuy");	
	     	    remainday=row.attr("remainday");//有效期剩余天数	     	    

	     	   
	     	   
	     	   if(ibuy==0  ){ //不购买可以
	     		  $("#bcard").removeClass("gm");
	     		  $("#bcard").addClass("y_gm");		  
	     		  $("#kcard").removeClass("gm");
	     		  $("#kcard").addClass("y_gm");  	
	     		 // alert("您已经购买'签到翻倍卡了'")
	     	   }else{
		     	 $("#bcard").removeClass("y_gm");
		     	 $("#bcard").addClass("gm");
		     	 $("#kcard").removeClass("y_gm");
		     	 $("#kcard").addClass("gm");	     	   	     	   
	     	   }    
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
		     	    $(".integral span").html(point);  
	     	   }


				
			}
		});			
		
	};
	
	
	

	
	
	var buy=function(ctype){ //购买翻倍卡	
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
		     		  $("#bcard").removeClass("gm");
		     		  $("#bcard").addClass("y_gm");
		     		  $("#kcard").removeClass("gm");
		     		  $("#kcard").addClass("y_gm"); 
				}else if(code=="3"){
					alert("您已经购买过翻倍卡了,有效期还剩"+remainday+"天")
				}else{
					alert(desc);

				}
				
				$(".ceng").hide();	
				$("#b_buy").hide();	
				$("#k_buy").hide();	

			}
		});
		
		
	};
	

	
	var bind=function(){//绑定事件
			
		$("#bcard").bind("click",function(){//百倍卡点击出现弹窗
			if($("#bcard").hasClass("gm")){
				
				if(point>=14000){	//		if(point>=14000){			
					$("#b_buy").show();	
				}else{				
					$("#czms").html("积分余额不足，还差 <span style='color:#60c081'>"+(14000-point)+"</span> 积分，请充值~");					
					$("#b_cz").show();	
				}
				$(".ceng").show();				

			}else{
				alert("您已经购买过翻倍卡了,有效期还剩"+remainday+"天")
			}

		})		
		$("#bsure_buy").bind("click",function(){	//百倍卡弹窗确定购买		
			buy(1);
		})
		$("#bclose").bind("click",function(){	//百倍卡弹窗取消		

			$("#b_buy").hide();	
			$(".ceng").hide();	

		})

		
		$("#kcard").bind("click",function(){//千倍卡点击出现弹窗	
			if($("#kcard").hasClass("gm")){
				
				if(point>=120000){					
					$("#b_buy").show();	
				}else{				
					$("#czms").html("积分余额不足，还差 <span style='color:#60c081'>"+(120000-point)+"</span> 积分，请充值~");					
					$("#b_cz").show();	
				}
				$(".ceng").show();				

			}else{
				alert("您已经购买过翻倍卡了,有效期还剩"+remainday+"天")
			}
	
		})		
		$("#ksure_buy").bind("click",function(){	//千倍卡弹窗确定购买		
			buy(2);
		})
		$("#kclose").bind("click",function(){	//千倍卡弹窗取消		

			$("#k_buy").hide();	
			$(".ceng").hide();	

			
		})		
		
		
		$("#czclose").bind("click",function(){	//请充值 弹窗取消		
			$("#b_cz").hide();	
			$(".ceng").hide();				
		})	
		$("#cz_go").bind("click",function(){	//请充值 弹窗取消		
			window.location.href="/user/jfcz.html";			
		})	
		


	
	
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