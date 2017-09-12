
var XHC={};
var CP={};
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



XHC.CGJ=(function(){
	/***
	var data = {
			gname:"太阳",
			hname:"快船",
			godds:"1.50",
			hodds:"1.80",
			gtzl:"20%",
			htzl:"80%",
			mid:"20142015002",
			status:"1",
	}
	***/
	
	//投注所需要的参数对象
	var dodata={
			mtype:4,//终端类型 no
			appversion:"",//客户端版本号，触屏可为空
			ccodes:3,//投注内容  3/0
			cperiodid:"",//期次编号
			cquizname:"",//竞猜名称
			itmoney:0,//投注金额
			oddsid:"12345",//盘口赔率表id
			section:"5",//投注节数 第1，2，3，4节，或5-全场
			type:"1",//玩法让分 1，总分 2，奇偶 3
			hTName:"",//主队名
			vTName:""//客队名称
	};
	if(CP.MobileVer.android){//android
		try {
			dodata.mtype=1;
		} catch (e){
			
		}
	}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
		try {
			dodata.mtype=2;
		} catch (e){
			
		}
	}else if(CP.MobileVer.wp){//ios
		try {
			dodata.mtype=3;
		} catch (e){
			
		}
	}else{//4g
		dodata.mtype=4;
	}
	
	
	var title={
		20142015002: '猜NBA东部冠军?',
		20142015001: '猜NBA西部冠军?',
		20142015000: '猜NBA总冠军?'
	}

	
	
	var socket = io.connect('210.14.67.5:8185');//210.14.67.5:8185  192.168.1.240:8185
	
	//socket.emit('changeMid', 20142015002);//东部冠军
	//socket.emit('changeMid', 20142015001);//西部冠军
	var o = {//公用的对象
		node : function(){
			socket.on('loadMatch', function(data){//拉取单场全部赔率(主队请求)
				if(data["mid"]==20142015002){
					render(data,$("#east"),$("#bfb_east"));
				}else{
					render(data,$("#west"),$("#bfb_west"));
				}
				
			});
			//猜冠军
			socket.on('guanjun', function(data){
				//render(data);
				if(data["mid"]==20142015002){
					render(data,$("#east"),$("#bfb_east"));
				}else{
					render(data,$("#west"),$("#bfb_west"));
				}
				});
			}
	
		};
	
	//去字符串中的逗号
	var delFH = function(str){
		str = str.replace(/,/g,'');
		return str;
	};
	
	//将整数转为带两个小数点的小树
	var turn_decimal = function(num){
		var tem =0;
		if(num.indexOf(".")!=-1){
			var len = num.split(".")[1].length;
			if(len==1){
				tem=num+"0";
			}else{
				tem=num
			}
			
		}else{
			tem=num+".00";
		}
		return tem;
	}
	
	
	var load_east_content=function(){
		$.ajax({
			url:"/nbajc/matchs/dzinfo.xml?1431747059662",
			dataType:'xml',
			cache:true,
			success:function(xml){
				var Resp = $(xml).find("Resp");
				var code = Resp.attr("code");
				var utime = Resp.attr("utime");
				var desc = Resp.attr("desc");
				
				var rows = Resp.find("row");
				if(rows.length){
					rows.each(function(){
						var mid = $(this).attr("mid");
						var mname = $(this).attr("mname");
						var hn = $(this).attr("hname");
						var gn = $(this).attr("gname");
						var hid = $(this).attr("hid");
						var gid = $(this).attr("gid");
						var tzl = $(this).attr("tzl");
						
						var jctype = $(this).attr("jctype");
						var jcname = $(this).attr("jcname");
						
						var tzcs = $(this).attr("tzcs");
						
						var sp = $(this).attr("sp");
						var godds = turn_decimal(sp.split(",")[0]);
						var hodds = turn_decimal(sp.split(",")[1]);
						var cyrs = $(this).attr("cyrs");
						
						var isale = $(this).attr("isale");
						var score = $(this).attr("score");
						
						var g1 = $(this).attr("g1");
						var g2 = $(this).attr("g2");
						
						var g3 = $(this).attr("g3");
						var g4 = $(this).attr("g4");
						
						var g5 = $(this).attr("g5");
						var g6 = $(this).attr("g6");
						var g7 = $(this).attr("g7");
					    if(mid==20142015000){
							$("#east_W").show();
							$("#west_cgjxz").show();
							//西区
							$("#head_west li:eq(0)").html('<p><img src="nbalogo/t_'+gid+'.png"></p><strong>'+gn+'</strong>')
							$("#head_west li:eq(1)").html('<b>'+score+'</b><span>总比分</span>')
							$("#head_west li:eq(2)").html('<p><img src="nbalogo/t_'+hid+'.png"></p><strong>'+hn+'</strong>')
							
							$("#west").attr("mid",mid)
							$("#west").find("li:eq(0)").attr("gn",gn);
							$("#west").find("li:eq(0)").attr("hn",hn);
							
							$("#west").find("li:eq(1)").attr("gn",gn);
							$("#west").find("li:eq(1)").attr("hn",hn);
							
							//初始化队名赔率
							$("#west").find("li:eq(0)").html('<cite>'+gn+'</cite><span><em>胜</em> '+godds+'</span>');//客
							$("#west").find("li:eq(1)").html('<cite>'+hn+'</cite><span><em>胜</em>  '+hodds+'</span>');//主
							
							
							
							var sum = parseInt(tzl.split(",")[0]) + parseInt(tzl.split(",")[1]);
							sum = sum==0?1:sum;
							
							var gbl = Math.round(parseInt(tzl.split(",")[0])*100/sum) + '%';
							var hbl = Math.round(parseInt(tzl.split(",")[1])*100/sum) + '%';
							
							$("#bfb_west").find("article span").css({width:gbl});
							$("#bfb_west").find("p span").html(gbl+"支持");
							$("#bfb_west").find("p cite").html(hbl+"支持");
							
							
							if(isale==1){
								$("#west li").attr("disable",true);
								$("#west_cgjxz").addClass("stop");
								$("#west_cgjxz p").show();
								
								$("#west li").unbind("click");
							}
						
							if(g5){
								
								$("#w5 li:eq(1) span").html(gn);
								$("#w5 li:eq(2) span").html(hn);
								
								$("#w5 li:eq(1) cite:eq(0)").html(g1.split(":")[0]||"&nbsp;");
								$("#w5 li:eq(2) cite:eq(0)").html(g1.split(":")[1]||"&nbsp;");
								
								$("#w5 li:eq(1) cite:eq(1)").html(g2.split(":")[0]||"&nbsp;");
								$("#w5 li:eq(2) cite:eq(1)").html(g2.split(":")[1]||"&nbsp;");
								
								$("#w5 li:eq(1) cite:eq(2)").html(g3.split(":")[0]||"&nbsp;");
								$("#w5 li:eq(2) cite:eq(2)").html(g3.split(":")[1]||"&nbsp;");
								
								$("#w5 li:eq(1) cite:eq(3)").html(g4.split(":")[0]||"&nbsp;");
								$("#w5 li:eq(2) cite:eq(3)").html(g4.split(":")[1]||"&nbsp;");
								
								$("#w5 li:eq(1) cite:eq(4)").html(g5.split(":")[0]||"&nbsp;");
								$("#w5 li:eq(2) cite:eq(4)").html(g5.split(":")[1]||"&nbsp;");
								$("#w5").show();
								
								$("#w5").siblings("ul").hide();
							}else if(g6){
								$("#w6 li:eq(1) span").html(gn);
								$("#w6 li:eq(2) span").html(hn);
								
								$("#w6 li:eq(1) cite:eq(0)").html(g1.split(":")[0]||"&nbsp;");
								$("#w6 li:eq(2) cite:eq(0)").html(g1.split(":")[1]||"&nbsp;");
								
								$("#w6 li:eq(1) cite:eq(1)").html(g2.split(":")[0]||"&nbsp;");
								$("#w6 li:eq(2) cite:eq(1)").html(g2.split(":")[1]||"&nbsp;");
								
								$("#w6 li:eq(1) cite:eq(2)").html(g3.split(":")[0]||"&nbsp;");
								$("#w6 li:eq(2) cite:eq(2)").html(g3.split(":")[1]||"&nbsp;");
								
								$("#w6 li:eq(1) cite:eq(3)").html(g4.split(":")[0]||"&nbsp;");
								$("#w6 li:eq(2) cite:eq(3)").html(g4.split(":")[1]||"&nbsp;");
								
								$("#w6 li:eq(1) cite:eq(4)").html(g5.split(":")[0]||"&nbsp;");
								$("#w6 li:eq(2) cite:eq(4)").html(g5.split(":")[1]||"&nbsp;");
								
								$("#w6 li:eq(1) cite:eq(5)").html(g6.split(":")[0]||"&nbsp;");
								$("#w6 li:eq(2) cite:eq(5)").html(g6.split(":")[1]||"&nbsp;");
								$("#w6").show();
								
								$("#w6").siblings("ul").hide();
							}else if(g7){
								$("#w7 li:eq(1) span").html(gn);
								$("#w7 li:eq(2) span").html(hn);
								
								$("#w7 li:eq(1) cite:eq(0)").html(g1.split(":")[0]||"&nbsp;");
								$("#w7 li:eq(2) cite:eq(0)").html(g1.split(":")[1]||"&nbsp;");
								
								$("#w7 li:eq(1) cite:eq(1)").html(g2.split(":")[0]||"&nbsp;");
								$("#w7 li:eq(2) cite:eq(1)").html(g2.split(":")[1]||"&nbsp;");
								
								$("#w7 li:eq(1) cite:eq(2)").html(g3.split(":")[0]||"&nbsp;");
								$("#w7 li:eq(2) cite:eq(2)").html(g3.split(":")[1]||"&nbsp;");
								
								$("#w7 li:eq(1) cite:eq(3)").html(g4.split(":")[0]||"&nbsp;");
								$("#w7 li:eq(2) cite:eq(3)").html(g4.split(":")[1]||"&nbsp;");
								
								$("#w7 li:eq(1) cite:eq(4)").html(g5.split(":")[0]||"&nbsp;");
								$("#w7 li:eq(2) cite:eq(4)").html(g5.split(":")[1]||"&nbsp;");
								
								$("#w7 li:eq(1) cite:eq(5)").html(g6.split(":")[0]||"&nbsp;");
								$("#w7 li:eq(2) cite:eq(5)").html(g6.split(":")[1]||"&nbsp;");
								
								$("#w7 li:eq(1) cite:eq(6)").html(g7.split(":")[0]||"&nbsp;");
								$("#w7 li:eq(2) cite:eq(6)").html(g7.split(":")[1]||"&nbsp;");
								$("#w7").show();
								
								$("#w7").siblings("ul").hide();
							}else{
								$("#w4 li:eq(1) span").html(gn);
								$("#w4 li:eq(2) span").html(hn);
								
								$("#w4 li:eq(1) cite:eq(0)").html(g1.split(":")[0]||"&nbsp;");
								$("#w4 li:eq(2) cite:eq(0)").html(g1.split(":")[1]||"&nbsp;");
								
								$("#w4 li:eq(1) cite:eq(1)").html(g2.split(":")[0]||"&nbsp;");
								$("#w4 li:eq(2) cite:eq(1)").html(g2.split(":")[1]||"&nbsp;");
								
								$("#w4 li:eq(1) cite:eq(2)").html(g3.split(":")[0]||"&nbsp;");
								$("#w4 li:eq(2) cite:eq(2)").html(g3.split(":")[1]||"&nbsp;");
								
								$("#w4 li:eq(1) cite:eq(3)").html(g4.split(":")[0]||"&nbsp;");
								$("#w4 li:eq(2) cite:eq(3)").html(g4.split(":")[1]||"&nbsp;");
							}
						
						}
					});
				}else{
					//$("#gj").hide()
				}
			}
		});
	};
	
	
	//确认竞猜
	var confirmQuiz=function(){
		var data=dodata;
		$.ajax({
			url:"/grounder/buyviagoldenbean.go",
			dataType:'xml',
			data:data,
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){//投注成功
					alert("参与竞猜成功");
					$(".cgjxz li.spfzpk").removeClass("cur")
					$("#in_golden").val("50");
					
					var pl = $("#pkCont span").text();
					pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
					pl=parseFloat(pl);
					
					$("#fh").html(50*pl);
					$("#tzCont ul.clearfix li").removeClass("cur");
					$("#sjd").hide();
					$("#pop").hide();
					$(".mask").hide();
					$("#qrjc").html("确认竞猜");
				}else if(code==1){
					window.location.href="login.html";
				}else if(code==-1){
					if(desc=="竞猜过期"){
						$("#pkCont").next().show();
						/***
						setTimeout(function(){
							$("#pkCont").next().hide();
						},1000);
						***/
						$("#qrjc").html("继续竞猜")
					}else{
						alert(desc);
					}
				}else{
					alert(desc);
				}
			}
		});
	};
	
	//mid变化时重新渲染页面
	var render=function(data,obj,obj1){
		var hname = data["hname"];
		var gname = data["gname"];
		var htzl = data["htzl"];
		var gtzl = data["gtzl"];
		var mid = data["mid"];
		var status = data["status"];
		var godds = data["godds"];
		var hodds = data["hodds"];
		
		$(obj).find("li:eq(0)").html('<cite>'+gname+'</cite><span><em>胜</em> '+godds+'</span>');//客
		$(obj).find("li:eq(1)").html('<cite>'+hname+'</cite><span><em>胜</em>  '+hodds+'</span>');//主
		
		
		$(obj).find("li:eq(0)").attr("gn",gname);
		$(obj).find("li:eq(0)").attr("hn",hname);
		$(obj).find("li:eq(1)").attr("hn",hname);
		$(obj).find("li:eq(1)").attr("gn",gname);
		$(obj).find("li:eq(0)").attr("code",0);
		$(obj).find("li:eq(1)").attr("code",3);
		$(obj).attr("mid",mid);
		
		
		var sum = parseInt(data.gtzcs) + parseInt(data.htzcs);
		sum = sum==0?1:sum;
		
		data.gbl = Math.round(parseInt(data.gtzcs)*100/sum) + '%';
		data.hbl = Math.round(parseInt(data.htzcs)*100/sum) + '%';
		
		$(obj).find("article span").css({width:data.gbl});
		$(obj).find("p span").html(data.gbl+"支持");
		$(obj).find("p cite").html(data.hbl+"支持");
	
	};
	
	var bindEvent=function(){
		
		//积分切换
		$("#tzCont ul li:not(:first)").bind("click",function(){
			$(this).addClass("cur").siblings().removeClass("cur")
			setTimeout(function(){
				$("#tzCont ul li").removeClass("cur")
			},1000);
			var num = parseInt($("#in_golden").val())||0;
			var remain_jd = parseInt(delFH($("#jdyue").html()));
			var v = $(this).html();
			if(v=="全押"){
				if(remain_jd>200000){
					alert("单次竞猜最大投入200000金豆");
					$("#in_golden").val(200000);
				}else{
					$("#in_golden").val(remain_jd);
				}
				
				$("#sjd").hide();
			}else{
				if(parseInt(v)+num>200000){
					alert("单次竞猜最大投入200000金豆");
					$("#in_golden").val(200000);
				}else{
					if(remain_jd>parseInt(v)+num){
						$("#in_golden").val(parseInt(v)+num);
						$("#sjd").hide();
					}else{
						$("#in_golden").val(parseInt(v)+num);
						$("#sjd").show();
					}
				}
			}
			
			var newnum = parseInt($("#in_golden").val())||0;
			
			if(newnum>200000){
				alert("单次竞猜最大投入200000金豆");
				return;
			}
			
			var pl = $("#pkCont span").text();
			pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
			pl=parseFloat(pl);
			$("#fh").html(Math.ceil(newnum*pl));

			
			
		});
		
		//关闭购买层
		$("#close").bind("click",function(){
			$(".cgjxz li.spfzpk").removeClass("cur")
			$("#in_golden").val("50");
			
			var pl = $("#pkCont span").text();
			pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
			pl=parseFloat(pl);
			
			$("#fh").html(Math.ceil(50*pl));
			$("#ulCont li").removeClass("cur");
			$("#sjd").hide();
			$("#pop").hide();
			$(".mask").hide();
			
		});
		
		
		
		
		
		//弹出购买层
		$(".cgjxz li.spfzpk").bind("click",function(){
			$(this).addClass("cur").siblings().removeClass("cur");
			
			var wfhtml = $(this).html();
			
		
			
			$("#pkCont").html(''+wfhtml);
			
			dodata.ccodes = $(this).attr("code");//投注内容    如:3  0
			dodata.hTName=encodeURIComponent($(this).attr("hn"));
			dodata.vTName=encodeURIComponent($(this).attr("gn"));
			dodata.cperiodid=$(this).parent().attr("mid");
			dodata.cquizname=encodeURIComponent(title[dodata.cperiodid]);
			
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
						var balance = r.attr("balance");//金豆账户余额
						var daward = r.attr("daward");//当日盈亏
						var taward = r.attr("taward");//总盈利
						var dpm = r.attr("dpm");//当日排名
						var tpm = r.attr("tpm");//总排名
						var isqd = r.attr("isqd");//是否签到
						var nickid = r.attr("nickid")||"用户名";//用户名
						
						
						$("#jdyue").html(balance);
						
						$("#pop").show();
						$(".mask").show();
						
						var newnum = parseInt($("#in_golden").val())||0;
						var pl = $("#pkCont span").text();
						pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
						pl=parseFloat(pl);
						
						$("#fh").html(Math.ceil(newnum*pl));
					
					}else{//未登录
						var url = window.location.href;
						if(url.indexOf("?")!=-1){
							var it = url.split("?")[1];
							if(it){
								window.location.href="login.html"+"?"+it;
							}else{
								window.location.href="login.html";
							}
						}else{
							window.location.href="login.html";
						}
						//window.location.href="login.html";
					}
					
				}
			})
		});
		
		
		//确认投注
		$(".ture").bind("click",function(){
			var remain_jd = delFH($("#jdyue").html());
			var tMoney=parseInt($("#in_golden").val())||0;
			
			dodata.itmoney=tMoney;
			
			
			if(!tMoney){
				alert("输入金豆");
				return;
			}
			
			if(tMoney<50){
				alert("请至少输入50个金豆");
				return;
			}
			
			if(remain_jd>=tMoney){
				confirmQuiz();
			}else{
				$("#sjd").show();
			}
		})
		
	}
	
	
	var init=function(){
		
		load_east_content();
		bindEvent();
		//render(data)
		//o.node();
		/**
		if(data.mid==20142015001){
			render(data,$("#east"),$("#bfb_east"));
		}else{
			render(data,$("#west"),$("#bfb_west"));
		}
		**/
	};
	return {
		init:init
	}
})()

$(function(){
	XHC.CGJ.init();
})