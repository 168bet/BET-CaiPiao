var pn = 1;
$(function(){
	$(".hmTit").bind("click",function(){
		$(".hmPull").toggle();
	})
	czmxDetails();
	function czmxDetails(){
		$.ajax({
			url:"/user/queryAccount.go?pn=1&ps=10&flag=15",
			success  : function (xml){
				var R = $(xml).find("rows");
				var r = R.find("row");
				var tp = R.attr("tp");
				if(r.length>0){
					if(tp=="1"){
						$("#moresult1").hide();
					}else{
						$("#moresult1").show();
					}
					var html="";
					r.each(function(){
						var money = Number($(this).attr("money"));
						money=money.toFixed(2);
						var cashid = $(this).attr("cashid")
						var state = $(this).attr("state")
						var cashdate = $(this).attr("cashdate")
						
						html+='<a href="#">'
				        html+='<span>'
				        html+='<cite>-'+money+'</cite>'
				        html+='<em>订单号:'+cashid+'</em>'
				        html+='</span>'
				        html+='<span class="number">'
				        html+='<cite>'+state+'</cite>'
				        html+='<em>'+cashdate+'</em>'
				        html+='</span>'
				        html+='</a>'
					})
					$(".all").html(html);
				}else{
					$("#moresult1").hide();
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