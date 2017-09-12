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
XHC.load=(function(){
	var noGame  = '<div style="text-align: center; padding: 50px;">暂无数据</div>';
	var pob={
			flag:"0",
			qtype:"3",
			psize:10,
			pnum:1
	};
	
	var t={
			0:"d",
			1:"m",
			2:"t"
	};
	var data = {
			mtype:4,//终端类型
			appversion:"",//客户端版本
			flag:0,//操作类标识
			qtype:4,//查询操作类标识
			phtype:t[1],//排行榜类型
			utype:"",//增删改操作类标识
			usepoint:"",//兑换积分数
			visit:3000+1000*Math.random(),//3000~4000之间的随机数
			vskeys:"",//加密字符串
			psize:30,//每页显示记录数
			pnum:"",//当前页
			date1:"",
			date2:"",
	};
	
	var init = function(){
		bindEvent();
		load_d_content();
		load_m_content();
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
	
	
	
	
	
	
	//日榜
	var load_d_content=function(){
		data.phtype=t[0];
		var html = $("#d_list").html();
		$.ajax({
			url:"/grounder/goldenbeanaccount.go",
			dataType:'xml',
			data:data,
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var phrecords = R.find("phrecords");
				var total = phrecords.attr("total");//总条数
				var tpage = phrecords.attr("tpage");//总页数
				
				var r = phrecords.find("row");
				
				if(code==0){//投注成功
					if(r.length){
						r.each(function(i){
							var c = i%2==0?"graybg":"";
							var uname = $(this).attr("uname");
							var jdyl = $(this).attr("jdyl");
							var rank = $(this).attr("rank");
							var hbjl = $(this).attr("hbjl");
							var ispj = $(this).attr("ispj");
							if(ispj==1){
								dyzArr.push(ispj);
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
						});
						$("#d_list").html(html);
						
						var dyzStr = dyzArr.join(",")
						if(dyzArr.length>=10){
							$("#dyz").show();
						}else{
							$("#dyz").hide();
						}
					}else{
						$("#d_list").html(noGame);
					}
				}else{
					alert(desc);
				}
			}
		})
	};
	
	var myzArr=[];
	var dyzArr=[];
	
	//月榜
	var load_m_content=function(){
		data.phtype=t[1];
		var html = $("#m_list").html();
		$.ajax({
			url:"/grounder/goldenbeanaccount.go",
			dataType:'xml',
			data:data,
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var phrecords = R.find("phrecords");
				var total = phrecords.attr("total");//总条数
				var tpage = phrecords.attr("tpage");//总页数
				
				var r = phrecords.find("row");
				
				if(code==0){//投注成功
					if(r.length){
						r.each(function(i){
							var c = i%2==0?"graybg":"";
							var uname = $(this).attr("uname");
							var jdyl = $(this).attr("jdyl");
							var rank = $(this).attr("rank");
							var hbjl = $(this).attr("hbjl");
							var ispj = $(this).attr("ispj");
							if(ispj==1){
								myzArr.push(ispj);
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
						});
						$("#m_list").html(html);
						//var myzStr = myzArr.join(",")
						if(myzArr.length>=10){
							$("#myz").show();
						}else{
							$("#myz").hide();
						}
					}else{
						$("#m_list").html(noGame);
					}
				}else{
					alert(desc);
				}
			}
		})
	}
	
	//总榜
	var load_t_content=function(){
		var html=$("#t_list").html();
		data.phtype=t[2];
		$.ajax({
			url:"/grounder/goldenbeanaccount.go",
			dataType:'xml',
			data:data,
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var phrecords = R.find("phrecords");
				var total = phrecords.attr("total");//总条数
				var tpage = phrecords.attr("tpage");//总页数
				
				var row = phrecords.find("row");
				
				if(code==0){//投注成功
					if(row.length){
						row.each(function(i){
							var c = i%2==0?"graybg":"";
							var uname = $(this).attr("uname");
							var rank = $(this).attr("rank");
							var jdtr = $(this).attr("jdtr");
							var jdjl = $(this).attr("jdjl");
							var jdyl = $(this).attr("jdyl");
							var jccs = $(this).attr("jccs");
							var mzcs = $(this).attr("mzcs");
							var hbjl = $(this).attr("hbjl");
							html+='<ul class="'+c+'">';
							if(rank==1 || rank==2 || rank==3){
								html+='<li><em>'+rank+'</em></li>';
							}else{
								html+='<li>'+rank+'</li>';
							}
							html+='<li>'+uname+'</li>';
							html+='<li>'+jdyl+'</li>';
							html+='<li>'+((mzcs/jccs)*100).toFixed(2)+'%</li>';
							html+='</ul>';
						})
						$("#t_list").html(html)
					}else{
						$("#t_list").html(noGame);
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