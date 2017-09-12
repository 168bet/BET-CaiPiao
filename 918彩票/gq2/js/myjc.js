var XHC={}
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

var nodata='<article class="list" style="display:"><article class="lqend" style="display: ;"><figure><img align="" src="img/lqend.png" width="100%"></figure><p>暂无数据</p></article>';
XHC.JCZQ=(function(){
	
	//查询所需参数
	var Queryparam={
			"mtype":"4",//终端类型    不能为空    安卓 1，iOS 2，WP 3，触屏 4
			"appversion":"",//客户端版本号   只有触屏可以为空
			"flag":"0",//操作类型标识  0-查询类标识   1-增删改类标识
			"qtype":"0",//查询类操作 标识   flag=0时不可为空
			"phtype":"",//排行榜类型  qtype=4时不可为空
			"utype":"",//增删改类操作标识 flag=1时不可为空
			"usepoint":"",//utype=1时不可为空
			"psize":"10",//每页显示记录数,可为空
			"pnum":"1",//当前页数,可为空
			"date1":"",//查询开始日期,可为空
			"date2":"",//查询截止日期,可为空
			"mid":"",//场次id  phtype=s时不可为空
			"ddstatus":"",//竞猜记录类型 可为空  1-有效竞猜   2-无效竞猜    空-全部竞猜
			"cgameid":""//彩种类型 可为空   1-足球  2-篮球   空-不区分彩种
	};
	
	
	
	var bindEvent=function(){
		var urlArr={
				"0":"bkbc.html",
				"1":"phb.html",
				"2":"fx.html",
				"3":"myjc.html",
		};
		
		$(".kcfooter li").bind("click",function(){
			
			var index=$(this).index();
			
			window.location.href=urlArr[index];
		})
		
		$(".up").bind("click",function(){
			$(this).parent().next().toggle();
			$(this).toggleClass("down");
		});
		
		
		$("#tab1").bind("click",function(){
			window.location.href="/gq2/hdjd.html";
		});
		$("#tab2").bind("click",function(){
			
			window.location.href="/gq2/jdmx.html";
		});
		$("#tab3").bind("click",function(){
			
			window.location.href="/gq2/jpzx/";
		});
		
		$("#sign").bind("click",function(){
			if($(this).html()=="签到领金豆"){
				$.ajax({
					url:"/grounder/goldenbeanaccount.go?flag=1&utype=0&qtype=0",
					dataType:'xml',
					cache:true,
					success: function(xml) {
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if(code==0){
							var row = R.find("row");
							var balance = row.attr("balance");//账户余额
							var daward = row.attr("daward");//当日盈利
							var taward = row.attr("taward");//总盈利
							var dpm = row.attr("dpm");//当日排名
							var tpm = row.attr("tpm");//总排行
							var isqd = row.attr("isqd");//是否签到
							$('#sign').html("已领取");
							alert("恭喜您，领取成功！");
							account_info();
							
	
					}else{
							alert(desc);
						}
					}
				});
			}else if($(this).html()=="已签到"){
				return;
			}
		})
		
		$("#betting_nav li").bind("click",function(){
			Queryparam.pnum=1
			$(".myRecord").html("");
			var index = $(this).index();
			$(this).addClass("cur").siblings().removeClass("cur");
			
			if($(".myAccount2 li:eq(0)").hasClass("cur")){
				z_bet_list(index);
			}else{
				l_bet_list(index);
			}
			
		});
		
		$(".myAccount2 li").bind("click",function(){
			Queryparam.pnum=1
			$(".myRecord").html("");
			$("#betting_nav li:first").addClass("cur").siblings().removeClass("cur");
			$(this).addClass("cur").siblings().removeClass("cur");
			if($(this).index()==0){
				$("#betting_nav li:eq(1)").html("有效竞猜");
				$("#betting_nav li:eq(2)").html("无效竞猜");
				z_bet_list(0);
			}else{
				$("#betting_nav li:eq(1)").html("已结算竞猜");
				$("#betting_nav li:eq(2)").html("未结算竞猜");
				l_bet_list(0);
			}
		});
		
		$(".more").bind("click",function(){
			
			var index=$("#betting_nav li.cur").index();
			if($(".myAccount2 li:eq(0)").hasClass("cur")){
				z_bet_list(index);
			}else{
				l_bet_list(index);
			}
		});
		
		/***
		$("#z_more").bind("click",function(){
			
			var index=$("#betting_nav li.cur").index();
			if($(".myAccount2 li:eq(0)").hasClass("cur")){
				z_bet_list(index);
			}
		});
		
		$("#l_more").bind("click",function(){
			
			var index=$("#betting_nav li.cur").index();
			if($(".myAccount2 li:eq(0)").hasClass("cur")){
				z_bet_list(index);
			}
		});
		***/
	};
	
	
	
	//初始化
	var init = function(){
		account_info();
		z_bet_list(0);
		//l_bet_list(0)
		bindEvent();
	};
	
	
	
	//sqdcs="0" mzcs="0" jdtr="0" fbmzcs="0" fbjdtr="0" balance="10,400" daward="0" taward="0"
	//dpm="100+" tpm="100+" isqd="0" nickid="墨家乙" point="1020"
	//账户信息
	var account_info=function(){
		Queryparam.flag=0;
		Queryparam.qtype=3;
		$.ajax({
			url:'/grounder/goldenbeanaccount.go',
			data:Queryparam,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				if(code==0){
					var row = R.find("row");
					var balance = row.attr("balance");//账户余额
					var nickid = row.attr("nickid");//用户名
					var isqd = row.attr("isqd");//是否签到 0-未签到 1-签到
					
					var daward = row.attr("daward");
					var dpm = row.attr("dpm");

					if(daward!=0){
						//$("#pm").show();
						$("#pm").html("<div> <span>&nbsp;&nbsp;您今日盈利<em>"+daward+"</em>金豆，排第<em>"+dpm+"</em>名<span></div>");
					}else{
						$("#pm").hide();
					}

					
					if(isqd==0){
						$("#sign").html("签到领金豆");
					}else{
						$("#sign").html("已签到");
					}
					
					$("#user_account").html(nickid+'<em>('+balance+'金豆)</em>');
				}else if(code==1){
					
				}else{
					alert(desc);
				}
			}
		})

	}
	
	
	//投注记录
	//足球记录
	var z_bet_list=function(index){
		var html=$(".myRecord").html();
		url = '/grounder/fgoldenbeanaccount.go';
		Queryparam.qtype=1;
		
		if(index==0){
			Queryparam.ddstatus="";//全部方案
		}else if(index==1){
			Queryparam.ddstatus="1";//有效竞猜
		}else if(index==2){
			Queryparam.ddstatus="2";//无效竞猜
		}
		
		$.ajax({
			url:url,
			data:Queryparam,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var jcrecords = R.find("jcrecords");
				var total = jcrecords.attr("total");
				var tpage = jcrecords.attr("tpage");
				
				
				if(total==0){
					$(".myRecord").html(nodata);
					$(".more").hide();
				}else{
					if(code==0){
						var row = R.find("row");
						var len = row.length;
						if(Queryparam.pnum<=tpage){
							row.each(function(){
								var jctime = $(this).attr("jctime").substr(5);
								var jctm = $(this).attr("jctm");
								var tzxx = $(this).attr("tzxx");
								var wftype = $(this).attr("wftype");
								var section = $(this).attr("section");
								var tzjd = $(this).attr("tzjd");
								var result = $(this).attr("result");
								var isjj = $(this).attr("isjj");
								var ispj = $(this).attr("ispj");
								var sp = $(this).attr("sp");
								var xxcg = $(this).attr("xxcg");
								var award = $(this).attr("award");
								var cretdate = $(this).attr("cretdate");
								var relwin = $(this).attr("relwin");
								//var relwin_text=(relwin==1)?"赢":(relwin==2)?"输一半":(relwin==3)?"赢一半":(relwin==4)?"输":(relwin==5)?"不输不赢":"--";
								var relwin_text="--";
								var c="red";
								if(relwin==1){
									relwin_text="赢"
										c="red";
								}else if(relwin==2){
									relwin_text="输一半"
										c="red"
								}else if(relwin==3){
									relwin_text="赢一半"
										c="red";
								}else if(relwin==4){
									relwin_text="输"
								}else if(relwin==5){
									relwin_text="不输不赢"
								}else{
									relwin_text="&nbsp;"
								}
								
								html += '<ul>';
								html += '<li>';
								html += '<p><span>'+jctm+'</span><br><span>'+tzxx+'</span><cite>'+sp+'</cite></p>';
								html += '<p><b>投入'+tzjd+'</b><em>'+relwin_text+'</em></p>';
								html += '</li>';
								html += '<li>';
								html += '<p>'+jctime+'</p>';//02/07 12:11:28
								if(xxcg!="--"){
									html += '<p>比分:'+xxcg+'</p>';//02/07 12:11:28
								}else{
									html += '<p>&nbsp;</p>';//02/07 12:11:28

								}
								award = award.replace(/,/g,"");
								/**
								if(isNaN(award)){
									html += '<p>'+award+'</p>';
								}else{
									html += '<p class="'+c+'">返还'+award+'</p>';
								}
								***/
								if(relwin==1||relwin==3){
									html += '<p class="'+c+'">返还'+award+'</p>';
								}else if(relwin==2||relwin==5){
									html += '<p>返还'+award+'</p>';
								}else{
									html += '<p>'+award+'</p>';
								}
								
								html += '</li>';
								html += '</ul>';
							});
							
							if(tpage==Queryparam.pnum){
								$(".more").hide()
							}else{
								$(".more").show().css("display","block");
							}
							Queryparam.pnum++;
						}else{
							$(".more").hide();
							return;
						}
					}
					
					$(".myRecord").html(html);
				}
				
			}
		})
		
		
		//分类信息
		//dist(index);
	};
	
	
	//篮球记录
	var l_bet_list=function(index){
		var html=$(".myRecord").html();
		url = '/grounder/goldenbeanaccount.go';
		Queryparam.qtype=1;
		
		if(index==0){
			Queryparam.ddstatus="";//全部方案
		}else if(index==1){
			Queryparam.ddstatus="1";//有效竞猜
		}else if(index==2){
			Queryparam.ddstatus="2";//无效竞猜
		}
		
		$.ajax({
			url:url,
			data:Queryparam,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var jcrecords = R.find("jcrecords");
				var total = jcrecords.attr("total");
				var tpage = jcrecords.attr("tpage");
				if(total==0){
					$(".myRecord").html(nodata);
					$(".more").hide();
				}else{
					if(code==0){
						var jcrecords = R.find("jcrecords");
						var row = jcrecords.find("row");
						var len = row.length;
						if(len>0){
							row.each(function(){
								var month = $(this).attr("month");
								var day = $(this).attr("day");
								var jctm = $(this).attr("jctm");
								var section = $(this).attr("section");
								var wftype = $(this).attr("wftype");
								var tzxx = $(this).attr("tzxx");
								var sp = $(this).attr("sp");
								var tzjd = $(this).attr("tzjd");
								var result = $(this).attr("result");
								var isjj = $(this).attr("isjj");
								var award = $(this).attr("award");
								var jctime = $(this).attr("jctime").substr(5);
								
								
								html += '<ul>';
								html += '<li>';
								html += '<p><span>'+jctm+'</span><br><span>'+tzxx+'</span><cite>'+sp+'</cite></p>';
								html += '<p><b>投入'+tzjd+'</b><em>&nbsp;</em></p>';
								html += '</li>';
								html += '<li>';
								html += '<p>'+jctime+'</p>';//02/07 12:11:28
								award = award.replace(/,/g,"");
								if(isNaN(award)){
									html += '<p>'+award+'</p>';
								}else{
									html += '<p class="red">返还'+award+'</p>';
								}
								html += '</li>';
								html += '</ul>';
							});
							
							if(tpage==Queryparam.pnum){
								$(".more").hide()
							}else{
								$(".more").show().css("display","block");
							}
							Queryparam.pnum++;
						}else{
							$(".more").hide();
							return;
						}
					}
					
					$(".myRecord").html(html);
				}
				
			}
		})
	};
	
	
	
	var dist=function(index){
		if(index==0){
			Queryparam.ddstatus="";//全部方案
		}else if(index==1){
			Queryparam.ddstatus="1";//有效竞猜
		}else if(index==2){
			Queryparam.ddstatus="2";//无效竞猜
		}
		
		Queryparam.qtype=1;
		
		$.ajax({
			url:url,
			data:Queryparam,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				
			}
		})
	};
	
	
	return {
		init:init
	}
})()

$(function(){
	XHC.JCZQ.init();
});

var remove_header=function(){
	var arg = localStorage.getItem("from");
	if(arg){
		$(".tzHeader").hide();
	}else{
		$(".tzHeader").show();
	}
}
remove_header();