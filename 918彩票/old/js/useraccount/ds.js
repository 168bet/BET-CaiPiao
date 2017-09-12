//各种明细
function description(flag,obj){
		var url;
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		var oldhtml = $(".myRecord").html();
			
		var oldhtml =$(".all").html(); 
		switch(flag){
			case 16:
				url="/user/queryAccount.go?pn="+pn+"&ps=10&flag=16";//够彩明细
				$(".loading").show();
				$("#moresult1").hide();
				
				$.ajax({
					url:url,
					success  : function (xml){
						var R = $(xml).find("rows");
						var tp = R.attr("tp");
						var r = R.find("row");
						var html="";
						html+=oldhtml;
						if(pn<=tp){
							r.each(function(){
								var money = Number($(this).attr("money"));
								money=money.toFixed(2);
								
								var type = $(this).attr("type")
								var memo = $(this).attr("memo")
								var cadddate = $(this).attr("cadddate")
								
								var gid = $(this).attr("gid")
								var hid = $(this).attr("hid")
								
								if(hid.indexOf('ZH') >=0){
									html+='<a href="/useraccount/zhxq.html?gid='+gid+'&tid='+hid+'">'
								}else{
									html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+hid+'">'
								}
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
							$(".loading").hide();
							$("#moresult1").show();
							$(".all").html(html);
						}
					}
				})
			break;
			case 15:
				url="/user/queryAccount.go?pn="+pn+"&ps=10&flag=15";//提款明细
				$(".loading").show();
				$("#moresult1").hide();
				$.ajax({
					url:url,
					success  : function (xml){
						var Resp = $(xml).find("Resp")
						var R = $(xml).find("rows");
						var r = R.find("row");
						var html="";
						html+=oldhtml;
						if(r.length>0){
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
						}else{
							//html+=Resp.attr("desc");
							$(".all").html("暂无记录");
						}
						
						$(".loading").hide();
						$("#moresult1").show();
						$(".all").html(html);
					}
				})
			break;
			case 17:
				url="/user/queryAccount.go?pn="+pn+"&ps=10&flag=17";//中奖明细
				$(".loading").show();
				$("#moresult1").hide();
				$.ajax({
					url:url,
					success  : function (xml){
						var Resp = $(xml).find("Resp")
						var R = $(xml).find("rows");
						var r = R.find("row");
						var html="";
						html+=oldhtml;
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
						
						$(".loading").hide();
							$("#moresult1").show();
						
						$(".all").html(html);
					}
				})
			break;
			case 14:
				url="/user/queryAccount.go?pn="+pn+"&ps=10&flag=14";//充值明细
				$(".loading").show();
				$(".moresult1").hide();
				$.ajax({
					url:url,
					success  : function (xml){
						var R = $(xml).find("rows");
						var r = R.find("row");
						var html="";
						html+=oldhtml;
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
						$(".loading").hide();
						$(".moresult1").show();
						$(".all").html(html);
					}
				})
			break;
			case 13:
				url="/user/queryAccount.go?pn="+pn+"&ps=10&flag=13";//账户明细
				$(".loading").show();
				$("#moresult1").hide();
				$.ajax({
					url:url,
					success  : function (xml){
						var R = $(xml).find("rows");
						var r = R.find("row");
						var html="";
						html+=oldhtml;
						r.each(function(){
							var imoney = $(this).attr("imoney")
							var ibiztype = $(this).attr("ibiztype")
							var itype = $(this).attr("itype")
							var wf = $(this).attr("wf")
							var cadddate = $(this).attr("cadddate")
							var bh = $(this).attr("bh")
							var gid = bh.substring(0,2);
							if(itype==1){
								imoney="-"+imoney;
							}
							
							var sss=$_sys.showcmemo(ibiztype,wf);
							if(bh.indexOf('HM')>0 || bh.indexOf('DG')>0){
								html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+bh+'">';
							}else if (bh.indexOf('ZH')>0){
								html+='<a href="/useraccount/zhxq.html?flag=39&gid='+gid+'&tid='+bh+'">';
							}else{
								html+='<a href="javascript:;">';
							} 
							html+='<span>'
							html+='<cite>'+imoney+'</cite>'
							html+='<em>'+obj[ibiztype]+'</em>'
							html+='</span>'
							html+='<span class="number">'
							html+='<cite>'+$_sys.getlotname(wf)+'</cite>'
							html+='<em>'+cadddate+'</em>'
							html+='</span>'
							if(bh.indexOf('HM')>0 || bh.indexOf('DG')>0 || bh.indexOf('ZH')>0){
								html+='<i class="rightArrow"></i>';
							}
							html+='</a>'
						})
						$(".loading").hide();
						$("#moresult1").show();
						$(".all").html(html);
					}
				})
			break;
			default:
				return;
		}
	//}	
}