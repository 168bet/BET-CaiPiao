var CP={}
CP.MobileVer = (function ($) {
	var u = navigator.userAgent;
	var obj = {
		android: false,
		ios: false,
		ios7: false,
		ipad: false,
		wp:false
	};
	obj.android = (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1);
	obj.ios = (!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/));
	obj.ipad = u.indexOf('iPad') > -1;
	obj.wp = u.indexOf("Windows Phone") > -1;
	if (obj.ios) {
		if (u.indexOf('7_') > -1) {
			obj.ios7 = true;
		}
	}
	return obj;
})();

var D = {};

var XHC={};

XHC.HIT_EGG=(function(){
	var noGame  = '<div style="text-align:center; padding: 50px;">暂无数据</div>';
	var init = function(){
		loadCont();
		bindEvent();
	}
	var pob={
			pn:1,
			ps:10
	}
	
	var type={
			"1":"金豆",
			"2":"红包"
	}
	
	var bindEvent=function(){
		//查看更多(竞猜记录分页内容)
		$("#jdMore").bind("click",function(){
			loadCont();
		});
		
		$(".ret").bind("click",function(){
			window.location.href="index.html";
		})
	}
	//奖品列表
	
	var loadCont = function(){
		var html=$("#jp_list").html();
		$.ajax({
			url:"/activity/myeggfrenzy.go",
			dataType:'xml',
			data:pob,
			cache:true,
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var rows = R.find("rows");
				 //ps="10" pn="1" tr="6" tp="1"
				var ps = rows.attr("ps")
				var pn = rows.attr("pn")
				var tr = rows.attr("tr")//总行数
				var tp = rows.attr("tp")//总页数
				var row = rows.find("row");
				
				if(code==0){
					if(tr==0){
						$("#jp_list").html(noGame);
						$("#jdMore").hide();
					}else{
						if(pob.pn<=tp){
							row.each(function(){
								var money = $(this).attr("money");
								money = money.substring(0,money.indexOf("."))
								var biztype = $(this).attr("biztype");
								var createtime = $(this).attr("createtime");
								html += '<ul class="main1">';
								html += '<li class="'+(biztype==1?"jp_left":"jp_left1")+'"></li>';//jp_left jp_left1
								html += '<li class="jp_right">';
								html += '<span class="jp_wz">';
								html += '<a class="lj"><span class="jindou">'+money+type[biztype]+'</span></a>';
								html += '<a class="shijan">获得时间'+createtime+'</a>';
								html += '</span>';
								html += '</li>';
								html += '</ul>';
							});
							$("#jp_list").html(html);
							$("#jdMore").show().css("display","block");
							
							if(tp==pob.pn){
								$("#jdMore").hide();
							}else{
								$("#jdMore").show().css("display","block");
							}
							pob.pn++;
						}else{
							$("#jdMore").hide();
							return;
						}
						
					}
				}else{
					$("#jp_list").html(noGame);
					$("#jdMore").hide();
				}
				
				//$("#jp_list").html(html);
			}
		})
	}
	
	
	
	return {
		init:init
	};
})();

$(function(){
	XHC.HIT_EGG.init();
});

  