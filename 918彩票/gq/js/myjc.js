var XHC={};
//公用弹出层和加载层


var delFH = function(str) {
	str = str.replace(/,/g, '');
	return str;
}

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
			pnum:1,
			pnum2:1
	}
	var init = function(){
		bindEvent();
		load_account();
		load_jcjl();//竞猜记录
		load_jdjl();//金豆记录
	};
	
	var bindEvent=function(){
		
		$("#rk1").bind("click",function(){
			
			window.location.href="/activity/gq/egg/index.html";
		});
		
		$("#rk2").bind("click",function(){
			
			window.location.href="/h5game/blackjack/pages/start.html";
		});
		
		
		
		$('.pullIco').bind('click', function(){
			$('.pullDown').toggleClass('pullHover');
			$('.pullText').toggle();
		});
		
		$('#tcan').bind('click', function(){
			$("#tc").show();
			$("#mask").show();
		});	
		
		
		$('#tc_true').bind('click', function(){
			$("#tc").hide();
			$("#mask").hide();

		});	
		
		//查看更多(竞猜记录分页内容)
		$("#jlMore").bind("click",function(){
			load_jcjl();
		});
		
		//查看更多(竞猜记录分页内容)
		$("#jdMore").bind("click",function(){
			load_jdjl();
		});
		
		//竞猜记录和金豆记录相互切换
		$(".myAccount li").bind("click",function(){
			var index = $(this).index();
			$(this).addClass("cur").siblings().removeClass("cur");
			$(".jlCont:eq('"+index+"')").show().siblings("article").hide();
		})
	};
	
	
	
	//账户信息
	var load_account=function(){
		$.ajax({
			url:"/grounder/goldenbeanaccount.go?flag=0&qtype=3",
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				
				if(code==0){//查询成功
					var r = R.find("row");
					if(r.length){
						var balance = r.attr("balance");//金豆账户余额
						var daward = r.attr("daward");//当日盈亏
						var taward = r.attr("taward");//总盈利
						var dpm = r.attr("dpm");//当日排名
						var tpm = r.attr("tpm");//总排名
						var isqd = r.attr("isqd");//是否签到
						var nickid = r.attr("nickid")||"用户名";//用户名
						var mzcs = r.attr("mzcs")||"用户名";//今日中奖次数
						var sqdcs = r.attr("sqdcs")||"用户名";//已签到次数
						var jdtr = r.attr("jdtr");//今日投注金豆
						
						var jdtr_tmp=parseInt(delFH(jdtr));
						var daward=parseInt(delFH(daward));

						
						if(jdtr_tmp>=10000 && jdtr_tmp<50000){
							jdtr_back=100;
						}else if(jdtr_tmp>=50000 && jdtr_tmp<100000){
							jdtr_back=500;
						}else if(jdtr_tmp>=100000 && jdtr_tmp<500000){
							jdtr_back=1000;
						}else if(jdtr_tmp>=500000 && jdtr_tmp<1000000){
							jdtr_back=5000;
						}else if (jdtr_tmp>=1000000 ){
							jdtr_back=jdtr_back*0.01;
						}else{
							jdtr_back=0
						}
						
						
						
						jdtr_back
						
						
						
						//fomatStr()
						
						$("#zjcs").html(mzcs);
						
					
						$("#nick").html(nickid+"<em>("+balance+"金豆)</em>");
						
						if(mzcs>0 && mzcs<3){
							var scroll_str="<span>今日已中奖<em>"+mzcs+"</em>次,累计中奖3次加奖300金豆&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
						}else if(mzcs>=3 && mzcs<10){
							var scroll_str="<span>今日已中奖<em>"+mzcs+"</em>次,累计中奖10次再加奖500金豆&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
						}else if( mzcs>=10){
							var scroll_str="<span>今日已中奖<em>"+mzcs+"</em>次,累计加奖<em>300+500</em>金豆&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
						}else{
							var scroll_str="";
						}
							
							
													
						if(jdtr_tmp>10000){
							scroll_str=scroll_str+"<span>今日累计投注<em>"+ jdtr+"</em>金豆,比赛全部结束后将返还您<em>"+jdtr_back+"</em>金豆&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>"
						}
						
						if(daward>0){
							var scroll_str=scroll_str+"<span>今日盈利<em>"+daward+"</em>金豆，排名<em>"+dpm+"</em>名</span>";
						}
						if(scroll_str){
							$("#scl").show();
							$("#demo1").html(scroll_str);
							$("#demo2").html(scroll_str);	
						}

						//$("#yk li:eq(0) cite").html(daward)//当日盈亏
						//$("#yk li:eq(1) cite").html(dpm)//当日排名
						//$("#yk li:eq(2) cite").html(taward)//总盈利
						//$("#yk li:eq(3) cite").html(tpm)//总排名
						
						
						//点击获得金豆
						$(".qiandao").bind("click",function(){
							window.location.href="hdjd.html?isqd="+isqd;
						});
					}else{
						$("#nick").html("用户名<em>(0金豆)</em>");
						//$("#yk li:eq(0) cite").html(0)//当日盈亏
						//$("#yk li:eq(1) cite").html(0)//当日排名
						//$("#yk li:eq(2) cite").html(0)//总盈利
						//$("#yk li:eq(3) cite").html(0)//总排名
						$(".qiandao").bind("click",function(){
							window.location.href="hdjd.html?isqd="+isqd;
						});
					}
					
				}else if(code==1){
					window.location.href="login.html";
				}else{
					alert(desc);
				}
				
			}
		})
	}
	
	//竞猜记录
	var load_jcjl=function(){
		var jcjlHTML = $("#jcRecord").html();
		//调用一次页数加1
		$.ajax({
			url:"/grounder/goldenbeanaccount.go?flag=0&qtype=1&psize="+pob.psize+"&pnum="+pob.pnum,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var jcrecords = R.find("jcrecords");
				var total = jcrecords.attr("total");//总数据条数
				var tpage = jcrecords.attr("tpage");//总页数
				if(total==0){
					$("#jcRecord").html(noGame);
					$("#jlMore").hide();
				}else{
					if(pob.pnum<=tpage){
						var row = jcrecords.find("row");
						
						row.each(function(){
							var month = $(this).attr("month");
							var day = $(this).attr("day");
							var jctm = $(this).attr("jctm");//竞猜题目
							var section = $(this).attr("section");//比赛进度
							var wftype = $(this).attr("wftype");//投注玩法
							var tzxx = $(this).attr("tzxx");//投注选项
							var tzjd = $(this).attr("tzjd");//投注金豆
							var result = $(this).attr("result");//是否中奖01
							var isjj = $(this).attr("isjj");//是否记奖 01
							var award = $(this).attr("award");//奖金
							var sp = $(this).attr("sp");//sp
							var jctime = $(this).attr("jctime").substr(11,8);//竞猜时间

							
							
							jcjlHTML+='<a href="javascript:;">';
							jcjlHTML+='<span>';
							jcjlHTML+='<em>'+month+day+'日</em>';
							jcjlHTML+='<cite>'+jctime+'</cite>';
							jcjlHTML+='</span>';
							jcjlHTML+='<div class="myCz">';
							jcjlHTML+='<p><em>'+jctm+'</em></p>';
							jcjlHTML+='<cite>'+tzxx+'</cite><i></i><em>'+sp+'</em>';
							jcjlHTML+='</div>';
							jcjlHTML+='<div class="myQs">';
							jcjlHTML+='<p>投入'+tzjd+'</p>';
							
							jcjlHTML+='<cite class="'+((result!="0")?"red":"")+'">'+((result!="0")?("返还"+award):award)+'</cite>';
							
							jcjlHTML+='</div>';
							jcjlHTML+='</a>';
						});
						//jcjlHTML+='<a href="javascript:;" class="myMore" id="jcjl_more">查看更多</a>';
						//alert(jcjlHTML);
						$("#jcRecord").html(jcjlHTML);
						
						if(tpage==pob.pnum){
							$("#jlMore").hide()
						}else{
							$("#jlMore").show().css("display","block");
						}
						
						pob.pnum++;
						
						
						
						
					}else{
						$("#jlMore").hide();
						return;
					}
				}
			}
		})
	};
	
	//金豆记录
	var load_jdjl=function(){
		var jdjlHTML = $("#jdRecord").html();

		//调用一次页数加1
		$.ajax({
			url:"/grounder/goldenbeanaccount.go?flag=0&qtype=2&psize="+pob.psize+"&pnum="+pob.pnum2,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var jdrecords = R.find("jdrecords");
				var total = jdrecords.attr("total");//总数据条数
				var tpage = jdrecords.attr("tpage");//总页数

				if(total==0){
					$("#jdRecord").html(noGame);
					$("#jdMore").hide();
				}else{
					if(pob.pnum2<=tpage){
						var row = jdrecords.find("row");
						
						row.each(function(){
							var month = $(this).attr("month");
							var day = $(this).attr("day");
							var money = $(this).attr("money");//消费或收入金豆
							var isincome = $(this).attr("isincome");//金豆消费或收入
							var bizdesc = $(this).attr("bizdesc");//金豆账户流水类型
							var isincome = $(this).attr("isincome");// 金豆消费或收入
							var time = $(this).attr("time").substr(11,8);//竞猜时间

							
							jdjlHTML+='<a href="javascript:;">';
							jdjlHTML+='<span>';
							jdjlHTML+='<em>'+month+day+'日</em>';
							jdjlHTML+='<cite>'+time+'</cite>';
							jdjlHTML+='</span>';
							if(isincome=='0'){
								jdjlHTML+='<div class="myCz red">+'+money+'</div>';	
							}
							else{
								jdjlHTML+='<div class="myCz ">-'+money+'</div>';	
							}
							jdjlHTML+='<div class="myQs">'+bizdesc+'</div>';
							jdjlHTML+='</a>';
						});
						//jcjlHTML+='<a href="javascript:;" class="myMore" id="jcjl_more">查看更多</a>';
						$("#jdRecord").html(jdjlHTML);
						$("#jdMore").show().css("display","block");
						
						if(tpage==pob.pnum2){
							$("#jdMore").hide();
						}else{
							$("#jdMore").show().css("display","block");
						}
						
						pob.pnum2++;
					}else{
						$("#jdMore").hide();
						return;
					}
				}
			}
		})
	};
	
	return {
		init:init
	};
})();

$(function(){
	XHC.load.init();
})
