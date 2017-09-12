var XHC={};
//公用弹出层和加载层
var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);
	} else {
		$('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
		$('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
		$('#mask').show();
	}
};
var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};

String.prototype.getParam = function(n){
	var r = new RegExp("[\?\&]"+n+"=([^&?]*)(\\s||$)", "gi");
	var r1=new RegExp(n+"=","gi");
	var m=this.match(r);
	if(m==null){
		return "";
	}else{
		return typeof(m[0].split(r1)[1])=='undefined'?'':decodeURIComponent(m[0].split(r1)[1]);
	}
};

var mid = location.search.getParam("mid");
var gn = location.search.getParam("gn");
var hn = location.search.getParam("hn");

XHC.load=(function(){
	var noGame  = '<div style="text-align: center; padding: 50px;">暂无数据</div>';
	var pob={
			flag:"0",
			qtype:"3",
			psize:10,
			pnum:1
	};
	
	var t={
			0:"d",//日榜
			1:"m",//
			2:"t"
	};
	
	
	var init = function(){
		if(hn&&gn){
			$("#dz").html(gn+" vs "+hn);
		}else{
			//$("#dz").html(noGame);
			$("#dz").hide();
			$(".lastts").hide();
		}
		
		bindEvent();
		
		load_t_content();
		
	};
	
	var bindEvent=function(){
		$(".myAccount li").bind("click",function(){
			var index = $(this).index();
			$(this).addClass("cur").siblings().removeClass("cur");
			$("article.list:eq('"+index+"')").show();
			$("article.list:eq('"+index+"')").siblings("article.list").hide();
		});
		
		//右侧下拉框
		$('.pullIco').bind('click', function(){
			$('.pullDown').toggleClass('pullHover');
			$('.pullText').toggle();
		});
	};
	
	
	var yzArr=[];
	
	//单场排行
	var load_t_content=function(){
		var html=$("#dc_list").html();
		//data.phtype=t[2];
		$.ajax({
			url:"/grounder/goldenbeanaccount.go?flag=0&qtype=4&phtype=s&mid="+mid,
			dataType:'xml',
			//data:data,
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var phrecords = R.find("phrecords");
				var total = phrecords.attr("total");//总条数
				var tpage = phrecords.attr("tpage");//总页数
				
				var row = phrecords.find("row");
				
				var dcphinfo = R.find("dcphinfo");
				var d_code=dcphinfo.attr("code");
				var d_desc=dcphinfo.attr("desc");

				if(d_code==0){
					var d_jdyl=dcphinfo.attr("jdyl");
					if(d_jdyl>0){
						$(".red").html(d_jdyl);
					}else{
						$(".red").html(0);
					}
				}else{
					$("#ly").hide();
				}
				
				if(code==0){//投注成功
					if(row.length){
						row.each(function(i){
							var c = i%2==0?"":"graybg";
							var uname = $(this).attr("uname");
							var rank = $(this).attr("rank");
							var jdtr = $(this).attr("jdtr");
							var jdjl = $(this).attr("jdjl");
							var jdyl = $(this).attr("jdyl");
							var jccs = $(this).attr("jccs");
							var mzcs = $(this).attr("mzcs");
							var hbjl = $(this).attr("hbjl");
							var ispj = $(this).attr("ispj");
							if(ispj==1){
								yzArr.push(ispj);
							}
							html+='<ul class="'+c+'">';
							if(rank==1 || rank==2 || rank==3){
								html+='<li><em>'+rank+'</em></li>';
							}else{
								html+='<li>'+rank+'</li>';
							}
							
							html+='<li>'+uname+'</li>';
							html+='<li>'+jdyl+'</li>';
							html+='<li>'+hbjl+'</li>';
							html+='</ul>';
						})
						$("#dc_list").html(html)
						//var yzStr = yzArr.join(",")
						if(yzArr.length>=10){
							$("#yz").show();
						}else{
							$("#yz").hide();
						}
					}else{
						$("#dc_list").html(noGame);
						$("#dz").hide();
						$(".lastts").hide();
					}
				}else{
					alert(desc);
				}
			}
		})
	}
	
	return {
		init:init
	};
})();

$(function(){
	XHC.load.init();
})