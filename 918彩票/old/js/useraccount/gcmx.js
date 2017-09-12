var pn = 1;


$(function(){
	
	$(".hmTit").bind("click",function(){
		$(".hmPull").toggle();
	})
	czmxDetails();
	function czmxDetails(){
		$.ajax({
			url:"/user/queryAccount.go?pn=1&ps=10&flag=16",
			success  : function (xml){
				var resp = $(xml).find("Resp")
				
				var R = $(xml).find("rows")
				var r = R.find("row");
				//var desc = resp.attr("desc");
				if(r.length>0){
					var R = $(xml).find("rows");
					var tp = R.attr("tp")
					if(tp=="1"){
						$("#moresult1").hide();
					}else{
						$("#moresult1").show();
					}
					
					var r = R.find("row");
					var html="";
					
					r.each(function(){
						var money = Number($(this).attr("money"));
						money=money.toFixed(2);
						
						var type = $(this).attr("type")
						var memo = $(this).attr("memo")
						var cadddate = $(this).attr("cadddate")
						
						var gid = $(this).attr("gid")
						var hid = $(this).attr("hid")
						
						html+="<a href='/useraccount/zhxq.html?gid="+gid+"&tid="+hid+"'>"
						html+='<span>'
						html+='<cite>-'+money+'</cite>'
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
		description(flag);
	})
	
	
})

