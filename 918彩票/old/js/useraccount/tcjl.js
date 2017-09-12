$(function(){

	var date = new Date();
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	var etime = y+"-"+m+"-"+d
	
	
	var y1 = date.setFullYear(y-1);
	var oldDate = new Date(y1);
	var y1 = oldDate.getFullYear();
	var m1 = oldDate.getMonth();
	var d1 = oldDate.getDate();
	var stime = y1+"-"+m1+"-"+d1;
	
	var pn=1;
	var id = $(".myAccount li.cur").attr("id");
	
	var st = new Array();
	//0 未完成 1  已完成  2 中奖停止 3 用户手工停止
	st.push("未完成");
	st.push("已完成");
	st.push("中奖停止");
	st.push("用户手动停止");
	
	getAll(id);
	$("#all").bind("click",function(){
		id = $(this).attr("id")
		pn=1;
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		getAll(id)
	})
	
	$("#jxz").bind("click",function(){
		id = $(this).attr("id")
		pn=1;
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		getAll(id)
	})
	$("#yjtz").bind("click",function(){
		id = $(this).attr("id")
		pn=1;
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		getAll(id)
	})
	
	
	function getAll(id){
		$(".myRecord").html("");
		var url;
		if(id=="all"){
			url = "/user/query.go?flag=43&stime="+stime+"&etime="+etime+"&pn=1&ps=10&limit=1"
		}else if(id=="jxz"){
			url = "/user/query.go?flag=43&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&qtype=0&limit=1"
		}else if(id=="yjtz"){
			url = "/user/query.go?flag=43&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&qtype=1&limit=1"
		}
		$.ajax({
			//url:"/user/query.go?flag=43&stime="+stime+"&etime="+etime+"&pn=1&ps=10&limit=1",
			url:url,
			success  : function (xml){
				
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var rows = R.find("rows");
				var tp = rows.attr("tp");
				var ps = rows.attr("ps");
				if(code==0){
					var r = R.find("row");
					var html="";
					if(r){
						if(r.length<ps){
							$("#moresult1").hide();
							
							r.each(function(){

								var tmoney=$(this).attr("tmoney");
								var gid=$(this).attr("gid");
								var pnums=$(this).attr("pnums");
								var success=$(this).attr("success");
								var pid=$(this).attr("zhid");
								var reason=$(this).attr("reason");
								var adddate = $(this).attr("adddate");
								
								//var cancel=$(this).attr("cancel");
								html+='<a href="/useraccount/tcxq.html?gid='+gid+'&tid='+pid+'" style="border-bottom:none">'
								html+='<p class="gray"><em class="fontSize092">'+anyName(gid,$_sys.lot)+'</em><em class="accountLine"></em><em class="fontSize07">'+adddate+' 起</em></p>'
								html+='<div class="myCz">'
								html+='<cite>'+tmoney+'元</cite>'
								html+='<p>总额</p>'
								html+='</div>'
								html+='<div class="myQs">'
								html+='<cite>'+pnums+'期/'+success+'期</cite>'
								html+='<p>总/已追</p>'
								html+='</div>'
								html+='<div class="myZt">'
								html+='<cite>'+st[reason]+'</cite>'
								html+='<p>状态</p>'
								html+='</div>'
								html+='<i class="hmArrow"></i>'
								html+='</a>'
							
							})
							
							
							$(".myRecord").html(html);
							$("#moresult1").hide();
						}else{
							r.each(function(){

								var tmoney=$(this).attr("tmoney");
								var gid=$(this).attr("gid");
								var pnums=$(this).attr("pnums");
								var success=$(this).attr("success");
								var pid=$(this).attr("zhid");
								var reason=$(this).attr("reason");
								var adddate = $(this).attr("adddate");
								
								//var cancel=$(this).attr("cancel");
								html+='<a href="/useraccount/tcxq.html?gid='+gid+'&tid='+pid+'" style="border-bottom:none">'
								html+='<p class="gray"><em class="fontSize092">'+anyName(gid,$_sys.lot)+'</em><em class="accountLine"></em><em class="fontSize07">'+adddate+' 起</em></p>'
								html+='<div class="myCz">'
								html+='<cite>'+tmoney+'元</cite>'
								html+='<p>总额</p>'
								html+='</div>'
								html+='<div class="myQs">'
								html+='<cite>'+pnums+'期/'+success+'期</cite>'
								html+='<p>总/已追</p>'
								html+='</div>'
								html+='<div class="myZt">'
								html+='<cite>'+st[reason]+'</cite>'
								html+='<p>状态</p>'
								html+='</div>'
								html+='<i class="hmArrow"></i>'
								html+='</a>'
							
							})
							
							
							$(".myRecord").html(html);
							$("#moresult1").show();
						}
						
						
						
					}else{
						$("#moresult1").hide();
						$(".myRecord").html("暂无数据");
						
					}
				}else{
					$("#moresult1").hide();
					$(".myRecord").html("暂无数据");
					
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
		dyna(id);
	})
	
	function dyna(id){
		
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		var oldhtml = $(".myRecord").html();
		//if(scrollTop + windowHeight >= scrollHeight){
			pn++;
			var url;
			/***
			if(id=="all"){
				url = "/user/query.go?flag=43&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10"
			}else if(id=="jxz"){
				url = "/user/query.go?flag=43&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&qtype=0"
			}else if(id=="yjtz"){
				url = "/user/query.go?flag=43&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&qtype=1"
			}
			***/
			if(id=="all"){
				url = "/user/query.go?flag=43&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&limit=1"
			}else if(id=="jxz"){
				url = "/user/query.go?flag=43&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&qtype=0&limit=1"
			}else if(id=="yjtz"){
				url = "/user/query.go?flag=43&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&qtype=1&limit=1"
			}
			$("#moresult1").hide();
			$(".loading").show()
			$.ajax({
				url:url,
				success  : function (xml){
					
					var R = $(xml).find("Resp");
					var rows = R.find("rows");
					var tp = rows.attr("tp")
					var pn = rows.attr("pn")
					var r = R.find("row");
					var code = R.attr("code")
					if(code=='0'){
						var html="";
						html+=oldhtml;
						r.each(function(){
							var tmoney=$(this).attr("tmoney");
							var gid=$(this).attr("gid");
							var pnums=$(this).attr("pnums");
							var success=$(this).attr("success");
							var pid=$(this).attr("zhid");
							var reason=$(this).attr("reason");
							var adddate = $(this).attr("adddate");
							
							//var cancel=$(this).attr("cancel");
							html+='<a href="/useraccount/tcxq.html?gid='+gid+'&tid='+pid+'" style="border-bottom:none">'
							html+='<p class="gray"><em class="fontSize092">'+anyName(gid,$_sys.lot)+'</em><em class="accountLine"></em><em class="fontSize07">'+adddate+' 起</em></p>'
							html+='<div class="myCz">'
							html+='<cite>'+tmoney+'元</cite>'
							html+='<p>总额</p>'
							html+='</div>'
							html+='<div class="myQs">'
							html+='<cite>'+pnums+'期/'+success+'期</cite>'
							html+='<p>总/已追</p>'
							html+='</div>'
							html+='<div class="myZt">'
							html+='<cite>'+st[reason]+'</cite>'
							html+='<p>状态</p>'
							html+='</div>'
							html+='<i class="hmArrow"></i>'
							html+='</a>'
						})
						if(pn==tp){
							$("#moresult1").hide();
							$(".loading").hide()
						}else{
							$("#moresult1").show();
							$(".loading").hide()
						}
								
						$(".myRecord").html(html);
					}else{
						$("#moresult1").hide();
						$(".loading").hide()
					}
					
				}
			});
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