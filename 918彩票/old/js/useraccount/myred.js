$(function(){
	
	ky()
	
	$("#ky").bind("click",function(){
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		$("#kmcontent").hide();
		ky()
	})
	
	$("#yyw").bind("click",function(){
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		$("#kmcontent").hide();
		yyw()
	})
	
	$("#gq").bind("click",function(){
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		$("#kmcontent").hide();
		
		gq()
	})
	
		$("#km").bind("click",function(){
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		$("#redContent").hide();
		$("#kmcontent").show();
		//km();
		})
	
	function ky(){
		$.ajax({
			url:"/user/queryRedPacketList.go?flag=1&istate=1&limit=1&pn=1&ps=10&rnd="+Math.random(),
			success  : function (xml){
				var R = $(xml).find("rows");
				var r = R.find("row");
				if(r.length>0){
					var html="";
					r.each(function(){
						var imoney = $(this).attr("imoney");//红包总金额
						var irmoney = $(this).attr("irmoney");//红包余额
						var cdeaddate = $(this).attr("cdeaddate");//红包过期时间
						var cadddate = $(this).attr("cadddate");//红包添加时间
						var crpname = $(this).attr("crpname");//红包名称
						var rcmemo = $(this).attr("rcmemo");//红包名称
						var rid = $(this).attr("rid");
						
						html+='<a href="#class=url&xo=useraccount/tryred.html&cupacketid='+rid+'" class="myred">';
						html+='<img src="/img/account/myred.png" alt="">';
						html+='<p><span class="left gray">'+crpname+","+rcmemo+'</span><span class="right">总额:'+imoney+'元</span></p>';
						html+='<div class="myredNum">';
						html+='<cite>余额   '+irmoney+'元</cite>';
						html+='<span><em class="timeIco"></em>'+cadddate+'~'+cdeaddate+'</span>';
						html+='</div>';
						html+='<em class="arrow"></em>';
						html+='</a>';
					})
					$("#redContent").html(html)
				}else{
					$("#redContent").html("暂无可用红包")
				}
				
			}
		})
	}
	
	
	function yyw(){
		$.ajax({
			url:"/user/queryRedPacketList.go?flag=1&istate=2&limit=1&pn=1&ps=10&rnd="+Math.random(),
			success  : function (xml){
				var R = $(xml).find("rows");
				var r = R.find("row");
				if(r.length>0){
					var html="";
					r.each(function(){
						var imoney = $(this).attr("imoney");//红包总金额
						var irmoney = $(this).attr("irmoney");//红包余额
						var cdeaddate = $(this).attr("cdeaddate");//红包过期时间
						var cadddate = $(this).attr("cadddate");//红包添加时间
						var crpname = $(this).attr("crpname");//红包名称
						var rcmemo = $(this).attr("rcmemo");//红包名称
						var rid = $(this).attr("rid");
						html+='<a href="#class=url&xo=useraccount/tryred.html&cupacketid='+rid+'" class="myred">';
						html+='<img src="/img/account/myred.png" alt="">';
						html+='<p><span class="left gray">'+crpname+","+rcmemo+'</span><span class="right">总额:'+imoney+'元</span></p>';
						html+='<div class="myredNum myredNum2">';
						html+='<cite>余额   '+irmoney+'元</cite>';
						html+='<span><em class="timeIco"></em>'+cadddate+'~'+cdeaddate+'</span>';
						html+='</div>';
						html+='<em class="arrow"></em>';
						html+='</a>';
					})
					$("#redContent").html(html)
				}else{
					$("#redContent").html("暂无已用完红包")
				}
			}
		})
	}
	
	function gq(){
		$.ajax({
			url:"/user/queryRedPacketList.go?flag=2&limit=1&pn=1&ps=10&rnd="+Math.random(),
			success  : function (xml){
				var R = $(xml).find("rows");
				var r = R.find("row");
				if(r.length){
					var html="";
					r.each(function(){
						var imoney = $(this).attr("imoney");//红包总金额
						var irmoney = $(this).attr("irmoney");//红包余额
						var cdeaddate = $(this).attr("cdeaddate");//红包过期时间
						var cadddate = $(this).attr("cadddate");//红包添加时间
						var crpname = $(this).attr("crpname");//红包名称
						var rcmemo = $(this).attr("rcmemo");//红包备注
						var rid = $(this).attr("rid");
						html+='<a href="#class=url&xo=useraccount/tryred.html&cupacketid='+rid+'" class="myred">';
						html+='<img src="/img/account/myred.png" alt="">';
						html+='<p><span class="left gray">'+crpname+","+rcmemo+'</span><span class="right">总额:'+imoney+'元</span></p>';
						html+='<div class="myredNum myredNum2">';
						html+='<cite>余额   '+irmoney+'元</cite>';
						html+='<span><em class="timeIco"></em>'+cadddate+'~'+cdeaddate+'</span>';
						html+='</div>';
						html+='<em class="arrow"></em>';
						html+='</a>';
					})
					$("#redContent").html(html)
				}else{
					$("#redContent").html("暂无过期红包")
				}
			}
		})
	}
})

$("#redok").bind("click",function(){	
	var tmp1=$("#rednum").val().substr(0,10);
	var tmp2=$("#rednum").val().substr(10,8);
	var data = {
			ccardid: tmp1,
			ccardpwd: tmp2
	};
	$.ajax({
		url:"/user/cardChongzhi.go",
		type:"POST",
	     dataType:'xml',
		//data:/user/queryRedPacketDetail.go?ccardid=JSAB2223GH&ccardpwd=95ccadf07bc1",
        data:data,
		success:function (xml){
	//		alert("111111");
			
			if($(xml).find("code")=="0")
				D.alert("恭喜您兑换成功！");
			else
				{
			var re=$(xml).find("Resp").attr("desc");
			D.alert(re);
				}
		}	
			});
});
	
$('#rednum').focus(function(){
	$(this).parent().parent().addClass('s3cur');
	if($("#rednum").val().substr(0,1)=="请")
	$("#rednum").val("");
});





