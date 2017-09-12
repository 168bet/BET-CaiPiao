$(function(){
	var lotid = decodeURIComponent(CP.Util.getParaHash("lotid"));
	var projid = decodeURIComponent(CP.Util.getParaHash("projid"));
	if(lotid=="01"||lotid=="50"){
		$(".great span").show();
		$.ajax({
	    	 url: $_trade.url.pinfo,
	         type:'POST',
	         data: "hid="+projid+"&gid="+lotid+"&state=1",
	         success:function(xml){
	        	var R = $(xml).find("Resp");
				var code = R.attr("code");
				if (code == "0") {
					var jindu = R.find("jindu");
					var kjtime = jindu.attr("kjtime");
					kjtime=kjtime.replace("\(","");
					kjtime=kjtime.replace("\)","");
					var kjstr = kjtime+"开奖";
					
					var pjtime = jindu.attr("pjtime");
					pjtime=pjtime.replace("\(","");
					pjtime=pjtime.replace("\)","");
					
					pjtime=pjtime.substring(pjtime.indexOf(":")+1);
					
					var pjstr = "&nbsp"+pjtime+"派奖";
					$(".great span").html(kjstr+pjstr);
				}else{
					$(".great span").hide();
				}
	         }
		 });
	}else{
		$(".great span").hide();
	}
	$("#gobuy").bind("click",function(){
		var t = {'720':'gddg/sf/more.html','900':'gddg/rq/more.html','910':'gddg/bf/more.html'
			,'920':'gddg/bqc/more.html','930':'gddg/jq/more.html'}[lotid]||0;
		var path = '';
		if(t != 0){//单关
			path = '#class=url&xo='+t;
		}else{
			path = '#class=url&xo='+$_sys.getlotdir(lotid).substr(1)+'index.html';
		}
		location.href = path;
	});
})