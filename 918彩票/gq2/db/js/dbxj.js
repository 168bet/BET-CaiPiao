
var itype=location.search.getParam("itype")
var periodid=location.search.getParam("periodid")
var username = localStorage.getItem("username")
var XHC={};
XHC.DB=(function(){
	var init=function(){
		news_cont();
		bindEvent();
	};
	
	var bindEvent=function(){
		//头部导航切换
		$("#z_more").bind("click",function(){
			news_cont();
		})
	};
	
	
	//查询某期的投注方案
	var query_case={
			flag:"7",
			cnickid:username,
			periodid:periodid,
			itype:itype,
			psize:10,
			pnum:1
	}
	var news_cont=function(){
		var html=$(".myRecord").html();
		$.ajax({
			url : '/grounder/takeinaccout.go',
			data:query_case,
			dataType:'xml',
			cache:true,
			success:function(xml){
				var R = $(xml).find("Resp");
				var desc = R.attr("desc");
				var code = R.attr("code");
				var total = R.attr("total");
				var tpage = R.attr("tpage");
				if(code==0){
					var row = R.find("row");
					if(row.length==0){
						$("#z_more").hide();				
					}else{
						row.each(function(a){
							 var cnickid = $(this).attr("cnickid");     // 用户名
							   var ccodes =$(this).attr("ccodes")	 //投注内容
							   var tzmoney  =$(this).attr("tzmoney")     //投注金额/筹码
							   var bonus  =$(this).attr("bonus")       //中奖金额/筹码
							   var jctm  =$(this).attr("jctm")       // 竞猜题目
							   var status =  $(this).attr("status")    // 订单状态
							   var tzxx  =   $(this).attr("tzxx")     //投注选项
							   var isjj  =   $(this).attr("isjj")       // 是否计奖
							   var ispj  =   $(this).attr("ispj")       // 是否派奖
							   var jctime   =   $(this).attr("jctime")    // 竞猜时间
							   var relwin   =   $(this).attr("relwin")     // 输赢情况(1-全赢 2-输半 3-赢半 4-全输 5-走水)
							   var relresult  =   $(this).attr("relresult")   //   输赢情况描述
							   var sp   =   $(this).attr("sp")        // 赔率
							   var xxcg   =   $(this).attr("xxcg")      //  赛果描述
							   var award   =   $(this).attr("award")     // 中奖描述
							   
							   html+='<ul>';
							   html+='<li>';
							   html+='<p><span>'+jctm+'</span><br><span>'+tzxx+'</span><cite>'+sp+'</cite></p>';
							   html+='<p><b>投入'+tzmoney+'</b><em>--</em></p>';
							   html+='</li>';
							   html+='<li>';
							   html+='<p>'+jctime+'</p>';
							   if(ispj==0){
								   html+='<p>未派奖</p>'; 
							   }else if(ispj==1){
								   html+='<p>正在派</p>'; 
							   }else if(ispj==2){
								   html+='<p>已派奖</p>'; 
							   }
							   
							   html+='</li>';
							   html+='</ul>';
						});
						if(query_case.pnum<tpage){
							$("#z_more").show();	
						}else{
							$("#z_more").hide();
						}
						query_case.pnum++;
						
					}
					$(".myRecord").html(html);
				}else{
					$("#z_more").hide();
					$(".myRecord").html(desc);
				}
			}
		});
	}
	
	return {
		init:init
	};
})();


$(function(){
	XHC.DB.init();
})

