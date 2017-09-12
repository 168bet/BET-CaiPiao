var pn = 1;
$(function(){
	$(".hmTit").bind("click",function(){
		$(".hmPull").toggle();
	})
	zjmxDetails();
	function zjmxDetails(){
		$.ajax({
			url:"/user/queryAccount.go?pn=1&ps=10&flag=17",
			success  : function (xml){
				var R = $(xml).find("rows");
				var r = R.find("row");
				var tp = R.attr("tp")
				if(tp=="1"){
					$("#moresult1").hide();
				}else{
					$("#moresult1").show();
				}
				//var desc = resp.attr("desc");
				if(r.length>0){
					//var R = $(xml).find("rows");
					//var r = R.find("row");
					var html="";
						
					r.each(function(){
						var money = Number($(this).attr("money"));
						money=money.toFixed(2);
						var cashid = $(this).attr("cashid")
						var type = $(this).attr("type")
						var cadddate = $(this).attr("cadddate")
						var memo = $(this).attr("memo")
						var gid = $(this).attr("gid")
						var hid = $(this).attr("hid")
						
						if(hid.indexOf('ZH') >=0){
							html+='<a href="/useraccount/zhxq.html?gid='+gid+'&tid='+hid+'">'
						}else{
							html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+hid+'">'
						}
						html+='<span>'
						html+='<cite class="yellow">+'+money+'</cite>'
						html+='<em>'+type+'</em>'
						html+='</span>'
						html+='<span class="number">'
						html+='<cite>'+memo+'</cite>'
						html+='<em>'+cadddate+'</em>'
						html+='</span>'
						html+='<i class="rightArrow"></i>'
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
	$(window).bind("click",function(){
		pn++;
		var flag = parseInt(location.search.getParam("flag"));
		//alert(flag)
		description(flag);
	})
})