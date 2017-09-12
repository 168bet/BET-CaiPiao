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
	
	var st = new Array();
	//0 未完成 1  已完成  2 中奖停止 3 用户手工停止
	st.push("未完成");
	st.push("已完成");
	st.push("中奖后停止");
	st.push("用户手动停止");
	
	/***
	var state ={
			"0":该方案自动跟单中，请等待
			"1":认购中
			"2":已满员 
			"3"系统已撤单
			"4":发起人已撤单
			"5":系统已撤单
			-1未支付

	}
	***/
	getAll(id)
	
	$("#all").bind("click",function(){
		id = $(this).attr("id")
		pn=1;
		//$(".myRecord").html(" ");
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		getAll(id)
	})
	
	$("#jxz").bind("click",function(){
		id = $(this).attr("id")
		pn=1;
		//$(".myRecord").html(" ");
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		getAll(id)
	})
	$("#yjtz").bind("click",function(){
		id = $(this).attr("id")
		pn=1;
		//$(".myRecord").html(" ");
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		getAll(id)
	})
	
	function getAll(id){
		$(".myRecord").html("");
		var url;
		if(id=="all"){
			url = "/user/query.go?flag=41&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10"
		}else if(id=="jxz"){
			url = "/user/query.go?flag=41&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&qtype=0"
		}else if(id=="yjtz"){
			url = "/user/query.go?flag=41&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&qtype=1"
		}
		
		$.ajax({
			url:url,
			success  : function (xml){
				var R = $(xml).find("Resp");
				var rows = R.find("rows");
				var tp = rows.attr("tp");
				var code = R.attr("code")
				if(code=="0"){
					if(tp=="1"){
						$("#moresult1").hide()
						var r = R.find("row");
						var html="";
						
						r.each(function(){
							var tmoney=$(this).attr("tmoney");
							var gid=$(this).attr("gid");
							var pnums=$(this).attr("pnums");
							var success=$(this).attr("success");
							var pid=$(this).attr("pid");
							var reason=$(this).attr("reason");
							var adddate = $(this).attr("adddate");
							var zhid = $(this).attr("zhid");
							var bonus = $(this).attr("bonus");
							
							//var cancel=$(this).attr("cancel");
							html+='<a href="/useraccount/zhxq.html?gid='+gid+'&tid='+zhid+'" style="border-bottom:none">'
							html+='<p class="gray"><em class="fontSize092">'+$_sys.getlotname($(this).attr("gid"))+'</em><em class="accountLine"></em><em class="fontSize07">'+adddate+' 起</em></p>'
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
							if(bonus=="0"){
								html+='<p>状态</p>'
							}else{
								html+='<p>'+bonus+'</p>'
							}
							html+='</div>'
							html+='<i class="hmArrow"></i>'
							html+='</a>'
						})	
								
						$(".myRecord").html(html);
					}else{
						$("#moresult1").show()
						var r = R.find("row");
						var html="";
						
						r.each(function(){
							var tmoney=$(this).attr("tmoney");
							var gid=$(this).attr("gid");
							var pnums=$(this).attr("pnums");
							var success=$(this).attr("success");
							var pid=$(this).attr("pid");
							var reason=$(this).attr("reason");
							var adddate = $(this).attr("adddate");
							var zhid = $(this).attr("zhid");
							var bonus = $(this).attr("bonus");
							
							//var cancel=$(this).attr("cancel");
							html+='<a href="/useraccount/zhxq.html?gid='+gid+'&tid='+zhid+'" style="border-bottom:none">'
							html+='<p class="gray"><em class="fontSize092">'+$_sys.getlotname($(this).attr("gid"))+'</em><em class="accountLine"></em><em class="fontSize07">'+adddate+' 起</em></p>'
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
							if(bonus=="0"){
								html+='<p>状态</p>'
							}else{
								html+='<p>'+bonus+'</p>'
							}
							html+='</div>'
							html+='<i class="hmArrow"></i>'
							html+='</a>'
						})	
								
						$(".myRecord").html(html);
					}
				}else{
					$("#moresult1").hide()
					$(".myRecord").html("暂无记录");
				
				}
				
				
			}
		});
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
				url = "/user/query.go?flag=41&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10"
			}else if(id=="jxz"){
				url = "/user/query.go?flag=41&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&qtype=0"
			}else if(id=="yjtz"){
				url = "/user/query.go?flag=41&stime="+stime+"&etime="+etime+"&pn="+pn+"&ps=10&qtype=1"
			}
			$("#moresult1").hide();
			$(".loading").show()
			$.ajax({
				url:url,
				success  : function (xml){
					
					var R = $(xml).find("Resp");
					var r = R.find("row");
					var html="";
					html+=oldhtml;
					r.each(function(){
						var tmoney=$(this).attr("tmoney");
						var gid=$(this).attr("gid");
						var pnums=$(this).attr("pnums");
						var success=$(this).attr("success");
						var pid=$(this).attr("pid");
						var reason=$(this).attr("reason");
						var adddate = $(this).attr("adddate");
						var zhid = $(this).attr("zhid");
						var bonus = $(this).attr("bonus");
						
						//var cancel=$(this).attr("cancel");
						html+='<a href="/useraccount/zhxq.html?gid='+gid+'&tid='+zhid+'" style="border-bottom:none">'
						html+='<p class="gray"><em class="fontSize092">'+$_sys.getlotname($(this).attr("gid"))+'</em><em class="accountLine"></em><em class="fontSize07">'+adddate+' 起</em></p>'
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
						if(bonus=="0"){
							html+='<p>状态</p>'
						}else{
							
							html+='<p class="yellow">中奖'+bonus+'元</p>'
						}
						
						html+='</div>'
						html+='<i class="hmArrow"></i>'
						html+='</a>'
					})	
					$("#moresult1").show();
					$(".loading").hide()		
					$(".myRecord").html(html);
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

