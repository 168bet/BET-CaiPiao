$(function(){
	var cupacketid = location.search.getParam("cupacketid");
	
	
	var arrTy = new Array();
	arrTy.push("自购");
	arrTy.push("发起合买");
	arrTy.push("合买跟单");
	
	var ib={
			200:"用户充值",
			201:"自购中奖",
			202:"跟单中奖",
			203:"中奖提成",
			204:"追号中奖",
			210:"自购撤单返款",
			211:"认购撤单返款",
			212:"追号撤销返款",
			213:"提现撤销返款",
			214:"提款失败转款",
			215:"保底返款",
			216:"红包派送",
			300:"转款",
			100:"自购",
			101:"认购",
			102:"追号",
			103:"保底认购",
			104:"提现",
			105:"保底冻结",
			99:"转账",
			98:"套餐追号"

	}
	
	
	var html="";
	$.ajax({
		url:"/user/queryRedPacketDetail.go",
		type:"post",
		data:"cupacketid="+cupacketid+"&flag=31"+"&pn="+pn+"&ps=18",
		success  : function (xml){
			var R = $(xml).find("rows");
			var tp = R.attr("tp");
			var r = R.find("row");
			if(tp>1){
				$("#moresult1").show();
			}else{
				$("#moresult1").hide();
			}
				r.each(function(){
					var gid = $(this).attr("gid");
					var itype = $(this).attr("itype")>0?true:false;
					var ibalance = $(this).attr("ibalance");
					var imoney = $(this).attr("imoney");
					var hid = $(this).attr("hid");
					var cadddate = $(this).attr("cadddate");
					var ibiztype = $(this).attr("ibiztype");
					html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+hid+'">'
					html+='<p class="gray"><em class="fontSize092">'+$_sys.getlotname(gid)+'</em><em class="accountLine"></em><em class="fontSize07">'+ib[ibiztype]+'</em>&nbsp;&nbsp;<em class="fontSize07">'+cadddate+'</em></p>'
					html+='<div class="clearfix pdTop03 tryred">'
					if(itype){
						html+='<span class="myCz"><i class="redpack"></i>-'+imoney+'</span>'
					}else{
						html+='<span class="myCz redtj"><i class="redpack"></i>+'+imoney+'</span>'
					}
					
					html+='<span class="myQs">余额:'+ibalance+'</span>'
					html+='</div>'
					html+='<i class="hmArrow"></i>'
					html+='</a>'
				})
				$(".myRecord").html(html);
			
			
			
		}
	})
	
	
	var pn=1;
	/***
	$(window).scroll(function(){
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		if(scrollTop + windowHeight >= scrollHeight){
			dyna();
		}
		
	});
	***/
	$("#moresult1").bind("click",function(){
		dyna();
		
	})
	function dyna(){
		/***
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		***/
		var oldhtml = $(".myRecord").html();
		//if(scrollTop + windowHeight >= scrollHeight){
			pn++;
			var url="/user/queryRedPacketDetail.go?cupacketid="+cupacketid+"&flag=31"+"&pn="+pn+"&ps=18";
			//$(".myRecord").html("加载中...");
			$.ajax({
				url:url,
				success  : function (xml){
					
					var R = $(xml).find("rows");
					var tp = R.attr("tp");
					if(pn==tp){
						$("#moresult1").hide();
					}
					var r = R.find("row");
					
					var html="";
					html+=oldhtml;
					r.each(function(){
						var gid = $(this).attr("gid");
						var itype = $(this).attr("itype")>0?true:false;
						var ibalance = $(this).attr("ibalance");
						var imoney = $(this).attr("imoney");
						var hid = $(this).attr("hid");
						var cadddate = $(this).attr("cadddate");
						var ibiztype = $(this).attr("ibiztype");
						html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+hid+'">'
						html+='<p class="gray"><em class="fontSize092">'+$_sys.getlotname(gid)+'</em><em class="accountLine"></em><em class="fontSize07">'+ib[ibiztype]+'</em>&nbsp;&nbsp;<em class="fontSize07">'+cadddate+'</em></p>'
						html+='<div class="clearfix pdTop03 tryred">'
						if(itype){
							html+='<span class="myCz"><i class="redpack"></i>-'+imoney+'</span>'
						}else{
							html+='<span class="myCz redtj"><i class="redpack"></i>+'+imoney+'</span>'
						}
						html+='<span class="myQs">余额:'+ibalance+'</span>'
						html+='</div>'
						html+='<i class="hmArrow"></i>'
						html+='</a>'
					})
						
					$(".myRecord").html(html);
				}
			});
		//}

	}
})