var CP={};
CP.ZLK=(function(){
	var g={
			"1":"一等奖",
			"2":"二等奖",
			"3":"三等奖",
			"4":"四等奖",
			"5":"五等奖",
			"6":"六等奖",
	};
	
	var init=function(){
		loadZJ();//中奖排行
		loadZB();//总榜排行
		bindEvent();
	};
	
	var bindEvent = function(){
		
		$(".myAccount li").bind("click",function(){
			var index=$(this).index();
			$(this).addClass("cur").siblings().removeClass("cur");
			$("article.list:eq("+index+")").show().siblings("article.list").hide();
		});
	};
	
	//上期中奖
	var loadZJ=function(){
		var zjhtml=$("#zj").html();
		$.ajax({
			url:"/data/huodong/freeguess/last_period_list.xml",
			type:'get',
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				if(code=="0"){
					var rows = R.find("rows");
					var size = parseInt(rows.attr("size"));
					if(size>0){
						var row = rows.find("row");
						row.each(function(i){
							if(i<20){
								var ranking = parseInt($(this).attr("ranking"));
								var nickid = $(this).attr("nickid");
								var bonus = $(this).attr("bonus");
								var grade = $(this).attr("grade");
								zjhtml+='<ul class="'+(ranking%2==0?"":"graybg")+'">';
								zjhtml+='<li>';
								if(ranking>3){
									zjhtml+=ranking;
								}else{
									zjhtml+="<em>"+ranking+"</em>";
								}
								zjhtml+='</li>';
								zjhtml+='<li class="long">'+nickid+'</li>';
								zjhtml+='<li>'+g[grade]+'</li>';
								zjhtml+='<li>'+bonus+'</li>';
								zjhtml+='</ul>';
							}
						});
						$("#zj").html(zjhtml);
					}else{
						$("#zj").html("暂无数据");
					}
				}else{
					alert(desc);
				}
			}
		});
	};
	
	//累计中奖
	var loadZB=function(){
		var zbhtml=$("#zb").html();
		$.ajax({
			url:"/data/huodong/freeguess/all_list.xml",
			type:'get',
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				if(code=="0"){
					var rows = R.find("rows");
					var size = parseInt(rows.attr("size"));
					
					if(size>0){
						var row = rows.find("row");
						row.each(function(i){
							if(i<20){
								var ranking = parseInt($(this).attr("ranking"));
								var nickid = $(this).attr("nickid");
								var bonus = $(this).attr("bonus");
								zbhtml+='<ul class="'+(ranking%2==0?"":"graybg")+'">';
								zbhtml+='<li>';
								if(ranking>3){
									zbhtml+=ranking;
								}else{
									zbhtml+="<em>"+ranking+"</em>";
								}
								zbhtml+='</li>';
								zbhtml+='<li>'+nickid+'</li>';
								zbhtml+='<li>'+bonus+'</li>';
								zbhtml+='</ul>';
							}
						});
						$("#zb").html(zbhtml);
					}else{
						$("#zb").html("暂无数据");
					}
				}else{
					alert(desc);
				}
			}
		});
	};
	
	return {
		init:init
	};
})();

$(function(){
	CP.ZLK.init();
});