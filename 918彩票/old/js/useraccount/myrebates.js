$(function(){
	$.ajax({
        url: $_user.url.base,
        success:function (data){
        	var R = $(data).find("Resp");
        	var c = R.attr('code');
        	if(c == '0'){
        		var U = R.find("row");
        		/***
	        	var rb = U.attr("ipacketmoney");//红包
	        	var n = U.attr("nickid");//用户名
	        	var m = U.attr("usermoeny");//账户余额
	        	var s = U.attr("safe");
	        	***/
	        	var isdl = U.attr("isdl");//返利标识
	        	var vmoney = U.attr("vmoney");//返利金钱
	        	$("#remaining").text(vmoney+"元")
	        	
	        	$(".payment").bind("click",function(){
					if(vmoney == 0){
						D.alert('余额不足，无法转账');
					}else{
						$(".zfPop").slideToggle(400);
						var str="";
						str+='<div class="zfPop" style="position:absolute;z-index:1000;display:block">';
						str+='<h4>提示</h4>';
						str+='<p class="pdTop06 center">是否将返利余额转到购彩账户</p>';
						str+='<div class="zfTrue clearfix">'
						str+='<a href="javascript:;" class="zfqx" onclick="closeWindow()">否</a>';
						str+='<a href="javascript:;" onclick="closeInfoWindow()">是</a>';
						str+="</div>"
						str+='</div>';
																
						var $d = $("<div id='zhezhao' style='position:fixed;left:0;top:0;width:100%;height:100%;display:block'></div>");
							
							
							
						$d.css({background:"gray",opacity:0.5,zIndex:999})
							
							
						//$(".zfPop").css({left:"200px",top:"150px"});
						$("body").append(str);
						$("body").append($d);
						$(".zfPop").css({left:parseInt($("#zhezhao").width()/2-$(".zfPop").width()/2),top:parseInt($("#zhezhao").height()/2-$(".zfPop").height()/2)})
					
					}
				})
        	}
        }
	})
	
	
	
})


	function closeInfoWindow(){
		$.ajax({
	        url: "/user/transfer.go?rnd="+Math.random(),
	        success:function (data){
	        	var R = $(data).find("Resp");
	        	var c = R.attr('code');
	        	var desc = R.attr('desc');
	        	if(c == '0'){
	        		window.location.href="/useraccount/"
	        	}else{
	        		alert(desc);
	        	}
	        }
		})
		$(".zfPop").hide();
		$(".zfPop").remove();
		$("#zhezhao").hide();
		$("#zhezhao").remove();
	}
	
	function closeWindow(){
		$(".zfPop").hide();
		$(".zfPop").remove();
		$("#zhezhao").hide();
		$("#zhezhao").remove();
	}