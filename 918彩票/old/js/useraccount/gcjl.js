$(function(){
	var date = new Date();
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	var etime = y+"-"+m+"-"+d
	var m1 = date.setMonth(m-3);
	var oldDate = new Date(m1);
	var y1 = oldDate.getFullYear();
	var m1 = oldDate.getMonth();
	var d1 = oldDate.getDate();
	var stime = y1+"-"+m1+"-"+d1;
	var pn=1;
	var id = $(".myAccount li.cur").attr("id");
	var arrTy = new Array();
	arrTy.push("自购");
	arrTy.push("发起合买");
	arrTy.push("合买跟单");
	var arrCancel=new Array();
	arrCancel.push("未撤销");
	arrCancel.push("本人撤销");
	arrCancel.push("系统撤销");
	gcjlAll(id);
	$("#all").bind("click",function(){
		id = $(this).attr("id");
		$(".myRecord").html("");
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		gcjlAll(id);
		pn=1;
	})
	$("#zj").bind("click",function(){
		id = $(this).attr("id");
		pn=1;
		$(".myRecord").html("");
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		gcjlAll(id);
	})
	$("#wzj").bind("click",function(){
		id = $(this).attr("id");
		pn=1;
		$(".myRecord").html("");
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		gcjlAll(id);
	})
	$("#hm").bind("click",function(){
		id = $(this).attr("id");
		pn=1;
		$(".myRecord").html("");
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		gcjlAll(id);
	})
	function gcjlAll(id){
		var url;
		if(id=="all"){
			url = "/user/query.go?flag=40&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10"
		}else if(id=="zj"){
			url = "/user/query.go?flag=40&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&aid=0"
		}else if(id=="wzj"){
			url = "/user/query.go?flag=40&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&rid=0"
		}else if(id=="hm"){
			url = "/user/query.go?flag=40&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&newValue=HM"
		}
		$("#moresult1").hide();
		$(".loading").show();
		$.ajax({
			url:url,
			success  : function (xml){
				var R = $(xml).find("Resp");
				var rows = R.find("rows");
				var tp = rows.attr("tp");
				if(tp=="1"){
					$("#moresult1").hide();
					var r = R.find("row");
					var html="";
					r.each(function(){
						var rmoney=$(this).attr("rmoney");
						var gid=$(this).attr("gid");
						var ty=$(this).attr("ty");
						var money=$(this).attr("money");
						var pid=$(this).attr("pid");
						var buydate=$(this).attr("buydate");
						buydate = buydate.substring(0,10)
						var projid=$(this).attr("projid");
						var status=$(this).attr("status");
						var cancel=$(this).attr("cancel");
						html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+projid+'">'
			            html+='<div class="myCz">'
			            html+='<p><em class="fontSize092">'+$_sys.getlotname(gid)+'</em><em class="accountLine"></em><em class="fontSize07">'+arrTy[ty]+'</em></p>'
			            html+='<cite>'+money+'元</cite>'
			            html+='</div>'
			            html+='<div class="myQs">'
			            html+='<p>第'+pid+'期&nbsp;&nbsp;'+buydate+'</p>'
			            if(rmoney>0){
			            	html+='<cite class="yellow">已中奖'+rmoney+'元</cite>'
			            }else{
			            	html+='<cite>'+status+'</cite>'
			            }
			            html+='</div>'
			            html+='<i class="hmArrow"></i>'
			            html+='</a>'
					})
					$(".loading").hide();
					$(".myRecord").html(html);
				}else{
					$("#moresult1").hide();
					var r = R.find("row");
					var html="";
					r.each(function(){
						var rmoney=$(this).attr("rmoney");
						var gid=$(this).attr("gid");
						var ty=$(this).attr("ty");
						var money=$(this).attr("money");
						var pid=$(this).attr("pid");
						var buydate=$(this).attr("buydate");
						buydate = buydate.substring(0,10)
						var projid=$(this).attr("projid");
						var status=$(this).attr("status");
						var cancel=$(this).attr("cancel");
						html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+projid+'">'
			            html+='<div class="myCz">'
			            html+='<p><em class="fontSize092">'+$_sys.getlotname(gid)+'</em><em class="accountLine"></em><em class="fontSize07">'+arrTy[ty]+'</em></p>'
			            html+='<cite>'+money+'元</cite>'
			            html+='</div>'
			            html+='<div class="myQs">'
			            html+='<p>第'+pid+'期&nbsp;&nbsp;'+buydate+'</p>'
			            if(rmoney>0){
			            	html+='<cite class="yellow">已中奖'+rmoney+'元</cite>'
			            }else{
			            	html+='<cite>'+status+'</cite>'
			            }
			            html+='</div>'
			            html+='<i class="hmArrow"></i>'
			            html+='</a>'
					})
					$(".loading").hide();
					$("#moresult1").show();
					$(".myRecord").html(html);
				}
					
				
				
			}
		})
	}
	/***
	$(window).scroll(function(){
		dyna(id);
	});
	***/
	
	$("#moresult1").bind("click",function(){
		dyna(id)
	})
	function dyna(id){
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		var oldhtml = $(".myRecord").html();
		//if(scrollTop + windowHeight >= scrollHeight){
			pn++;
			var url;
			if(id=="all"){
				url = "/user/query.go?flag=40&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10"
			}else if(id=="zj"){
				url = "/user/query.go?flag=40&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&aid=0"
			}else if(id=="wzj"){
				url = "/user/query.go?flag=40&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&rid=0"
			}else if(id=="hm"){
				url = "/user/query.go?flag=40&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&newValue=HM"
			}
			$(".loading").show();
			$.ajax({
				url:url,
				success  : function (xml){
					var R = $(xml).find("Resp");
					var rows = R.find("rows");
					var tp = rows.attr("tp");
					if(pn<=tp){
						var r = R.find("row");
						var html="";
						html+=oldhtml;
						r.each(function(){
							var rmoney=$(this).attr("rmoney");
							var gid=$(this).attr("gid");
							var ty=$(this).attr("ty");
							var money=$(this).attr("money");
							var pid=$(this).attr("pid");
							var buydate=$(this).attr("buydate");
							buydate = buydate.substring(0,10)
							var projid=$(this).attr("projid");
							var status=$(this).attr("status");
							
							var cancel=$(this).attr("cancel");
							
							html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+projid+'">'
				            html+='<div class="myCz">'
				            html+='<p><em class="fontSize092">'+$_sys.getlotname(gid)+'</em><em class="accountLine"></em><em class="fontSize07">'+arrTy[ty]+'</em></p>'
				            html+='<cite>'+money+'元</cite>'
				            html+='</div>'
				            html+='<div class="myQs">'
				            html+='<p>第'+pid+'期&nbsp;&nbsp;'+buydate+'</p>'
				            if(rmoney>0){
				            	html+='<cite class="yellow">已中奖'+rmoney+'元</cite>'
				            }else{
				            	html+='<cite>'+status+'</cite>'
				            }
				            
				            html+='</div>'
				            html+='<i class="hmArrow"></i>'
				            html+='</a>'
						})	
						$(".loading").hide();		
						$(".myRecord").html(html);
					}
					
				}
			})
		//}

	}
})
//根据id判断是哪个彩种
function anyName(gid,arr){
	for(var i=0;i<arr.length;i++){
		if(arr[i][0]==gid){
			var str = arr[i][1];
			return str;
		}
	}
}