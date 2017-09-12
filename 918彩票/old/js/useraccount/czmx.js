var pn = 1;
$(function(){
	$(".hmTit").bind("click",function(){
		$(".hmPull").toggle();
	})
	czmxDetails();
	function czmxDetails(){
		$.ajax({
			url:"/user/queryAccount.go?pn=1&ps=10&flag=14",
			success  : function (xml){
				var Resp = $(xml).find("Resp");
				var code = Resp.attr("code")
				
					var R = $(xml).find("rows");
					var tp = R.attr("tp")
					if(tp=="1"){
						$("#moresult1").hide()
					}else{
						$("#moresult1").show()
					}
					var r = R.find("row");
					if(r.length>0){
						var html="";
						
						r.each(function(){
							var money = Number($(this).attr("money"));
							money=money.toFixed(2);
							var applyid = $(this).attr("applyid")
							var type = $(this).attr("type")
							var confdate = $(this).attr("confdate")
							
							html+='<a href="javascript:;">'
					        html+='<span>'
					        html+='<cite class="yellow">+'+money+'</cite>'
					        html+='<em>订单号:'+applyid+'</em>'
					        html+='</span>'
					        html+='<span class="number">'
					        html+='<cite>'+type+'</cite>'
					        html+='<em>'+confdate+'</em>'
					        html+='</span>'
					        html+='</a>'
						})
						$(".all").html(html);
					}else{
						$("#moresult1").hide()
						$(".all").html("暂无记录");
					}
				
				
			}
		})
	}
	
	
	/***
	$(window).scroll(function(){
		var flag = parseInt(location.search.getParam("flag"));
		//alert(flag)
		description(flag,pn);
	})
	***/
	$("#moresult1").bind("click",function(){
		pn++;
		var flag = parseInt(location.search.getParam("flag"));
		//alert(flag)
		description(flag);
	})
})