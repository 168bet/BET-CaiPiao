var XHC={}

XHC.JCZQ=(function(){
	var noGame  = '<div style="text-align: center; padding: 50px;">暂无数据</div>';
	var bindEvent=function(){
		$(".more").bind("click",function(){
			loadCont();
		})
	
	};
	//查询所需参数
	var Queryparam={
			"flag":"0",//操作类型标识  0-查询类标识   1-增删改类标识
			"qtype":"2",//查询类操作 标识   flag=0时不可为空
			"psize":"10",//每页显示记录数,可为空
			"pnum":"1"//当前页数,可为空
	};
	
	var loadCont=function(){
		var html = $(".details").html();
		$.ajax({
			url:'/grounder/goldenbeanaccount.go',
			dataType:'xml',
			data:Queryparam,
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				//month="06月" day="15" money="1,000" isincome="1" bizdesc="投注" time="2015-06-15 16:01:38"
				if(code==0){//查询成功
					var jdrecords = R.find("jdrecords");
					var total = jdrecords.attr("total");
					var tpage = jdrecords.attr("tpage");
					
					var row = jdrecords.find("row");
					if(total==0){
						$(".details").html(noGame);
						$(".more").hide();
					}else{
						if(Queryparam.pnum<=tpage){
							row.each(function(){
								var month = $(this).attr("month");
								var money = $(this).attr("money");
								var isincome = $(this).attr("isincome");//金豆消费和收入0-收入  1-消费
								var bizdesc = $(this).attr("bizdesc");
								var time = $(this).attr("time");
								
								html += '<li>';
								html += '<p class="'+(isincome=="0"?"red":"green")+'">'+(isincome=="0"?"+"+money:"-"+money)+'</p>';
								html += '<span>';
								html += '<cite>'+bizdesc+'</cite>';
								html += '<em>'+time+'</em>';
								html += '</span>';
								html += '</li>';
							})
							
							$(".details").html(html);
							if(tpage==Queryparam.pnum){
								$(".more").hide()
							}else{
								$(".more").show().css("display","block");
							}
							Queryparam.pnum++;
						}
					}
				}
			}
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
	//初始化
	var init = function(){
		remove_header()
		loadCont();
		bindEvent();
	};
	
	
	
	return {
		init:init
	}
})()

$(function(){
	XHC.JCZQ.init();
});