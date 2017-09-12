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
	
var noGame  = '<div style="text-align: center; padding: 50px;">暂无数据</div>';	
var CP={};
var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
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
CP.MobileVer = (function ($) {
	//var tag = location.search.getParam('tag') || false;//ios 判断版本 不为false调他们的充值页面 否则弹窗提示
	var u = navigator.userAgent;
	var obj = {
		android: false,
		ios: false,
		ios7: false,
		ipad: false
	};
	obj.android = (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1);
	obj.ios = (!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/));
	obj.ipad = u.indexOf('iPad') > -1;
	if (obj.ios) {
		if (u.indexOf('7_') > -1) {
			obj.ios7 = true;
		}
	}
	return obj;
})();

CP.ZLK=(function(){
	var date1 = new Date().getTime();
	var id=location.search.getParam("id");
	var from=location.search.getParam("from");
	var l = $('.downline').offset().left;
	var P={
		id:id,
		current_round:0,//当前轮次
		index:"0",
		flag:(this.index?this.index:"0")
	};
	var navScroll;
//	var g={
//			"1":"英超",
//			"2":"意甲",
//			"3":"德甲",
//			"4":"法甲",
//			"5":"西甲",
//			"135":"欧冠",
//			"10":"足球资料库"
//	}
	var g={
			"1":"英超",
			"2":"意甲",
			"3":"德甲",
			"4":"法甲",
			"5":"西甲",
			"135":"欧冠",
			"10":"足球资料库",
			"19":"瑞士超",
			"25":"葡超",
			"59":"瑞典甲",
			"63":"法乙",
			"64":"德乙",
			"66":"英冠",
			"72":"英甲",
			"185":"欧罗巴",
			"263":"解放者杯",
			"367":"荷甲",
			"368":"荷乙",
			"381":"苏超",
			"690":"中超",
			"693":"日联",
			"703":"日乙",
			"843":"美联",
			"844":"巴甲",
			"845":"阿甲",
			"846":"智甲",
			"877":"墨联"
	}
	var init = function(){
		load_header(id);
		load_nav(P.index);
		load_ss();
		bindEvent();
	};
	var bindEvent=function(){
		//点击积分tab
		$("#Play_Tab a").bind("click",function(){
			$(this).addClass("cur").siblings().removeClass("cur");
			var index = $(this).index();
			load_nav(index);//显示隐藏二级导航
			var liWidth = $(this).width();
			$('.downline').stop(false,true).animate({'left' : index * liWidth+l + 'px'},300);
			switch(index){
			case 0:load_ss();//赛事数据
			break;
			case 1:load_jf();//积分数据
			break;
			case 2:load_sf();//射手数据
			break;
			default:load_ss();
			}
			$("#ALL_CONT").children("div:eq('"+index+"')").show().siblings().hide();
		});
		
		$("#slideCont").delegate("article div.sfcTitle","click",function(){
			$(this).next().toggle();
			$(this).find("em").toggleClass("down");
		})
		
		$("#jfCont").delegate("article div.sfcTitle","click",function(){
			$(this).next().toggle();
			$(this).find("em").toggleClass("down");
		})
		
		$('#slideCont').delegate('a','click',function(){
			
			var itemId = $(this).attr("itemId");
			forwardURL(itemId);
		});
	};
	
	 /*滑动[[*/
    var slide=function(_obj){
        var menu = $(_obj.menu);//菜单点击滑动DOM
        var con = $(_obj.con);//内容滑动DOM
        var cur = _obj.cur || P.current_round;//默认第一个选中(注意11选五只有0到2)
        var Q = con.width();//单个内容块宽度
        con.each(function(i){
        	$(this).show();
            $(this).css({'left': i<cur ? -Q : (i>cur ? Q:'') }) ;
            i==cur?$(this).css({'left':0 }):'' ;
        });
        menu.bind(start_ev,function(){
        	var index=0;
			index=$(this).index();
			var h = $("#slideCont article:eq('"+index+"')").height();
			$("#slideCont").css({"height":h});
            var conW=  con.width();//单个内容块宽度
            con.each(function(i){
            	if(P.current_round == i){//上一次
            		$(this).stop(true,false).animate({'left': i<index ? -conW : (i>index ? conW:'') }, _obj.conSpeed||300,_obj.effect||'');
            	}else if(i!=index){
            		$(this).css({'left':i<index ? -conW : (i>index ? conW:'')});
            	}else{
            		$(this).stop(true,false).animate({'left':0 } , _obj.conSpeed||300,_obj.effect||'')
            	}
            });
            P.current_round = index;
        });
        
    };
  
	
	//设置赛事数据/导航数据
	var load_ss=function(){
		var ul_html="";
		var com_html="";
		$.ajax({
			url:'/zlk/jsbf/match/sc_'+P.id+'.xml?'+Math.random(),
			type:'GET',
			DataType:'XML',
			success: function(xml){
				var sc=$(xml).find("sc");
				var currArr = sc.attr("currArr");//轮次类型
				var rows=sc.find("rows");
				var Q = parseInt($(window).width()/3);
				$('#nav_ul').css({'width':Q*rows.length+'px'});
				
				if(rows.length){
					rows.each(function(i){
						var runArr = $(this).attr("runArr");
						
						if(currArr==runArr){
							//setCurrent_Round(currArr);//设置当前轮次
							P.current_round=i;
							
						}
						
						
						
						ul_html+='<li style="width:'+Q+'px">'+runArr+'</li>';					
						//if(runArr.indexOf("圈")>0){
						com_html+='<article style="position:absolute;width:100%;display:none">';
						com_html+='<div class="sfcTitle">'+runArr+'<em class="up"></em></div>';
						com_html+='<div class="zlksaisList">';
						var row = $(this).find("row");
						row.each(function(){
							var time = $(this).attr("time");
							var teamA = $(this).attr("teamA");
							var teamB = $(this).attr("teamB");
							var score = $(this).attr("score");
							var itemId = $(this).attr("itemId");
							com_html+='<a href="javascript:;" class="gray" itemId="'+itemId+'">';
							com_html+='<em>'+time+'</em>';
							com_html+='<span>'+teamA.substring(0,5)+'</span>';
							if(score=="VS"){
								com_html+='<cite>'+score+'</cite>';
							}else{
								com_html+='<cite class="red">'+score+'</cite>';
							}
							com_html+='<span>'+teamB.substring(0,5)+'</span>';
							com_html+='</a>';
						});
						com_html+='</div>';
						com_html+='</article>';
						//}
					});
					
					$("#nav_ul").html(ul_html)
					$("#slideCont").html(com_html);
					var h = $("#slideCont article:eq('"+P.current_round+"')").height();
					$("#slideCont").css({"height":h});
					$("#nav_ul li:eq(0)").addClass("cur");
					setTimeout(function(){
			   		    navScroll = new iScroll('wrapper', {
			   		        snap: 'li',
			   		        hScrollbar: false,
			   		        hScroll: true,
			   		        vScroll: false
			   		    });
			       },100);
					var tt = 0;
					$("#nav_ul li").click(function(){
						var date2 = new Date().getTime();
						if(date2-date1 >400){
							date1 = new Date().getTime();
							$(this).addClass('cur').siblings().removeClass('cur');
							var Q = $(this).prev() .length ? $(this).prev().last()[0] : $(this)[0];
							navScroll.scrollToElement(Q,300);
						}
					})
					
					getCurrent_Round();
					setTimeout(function(){
						$('#nav_ul li:eq('+P.current_round+')').click();
					},450);
				}else{
					$("#slideCont").html(noGame);
					$("#jfCont").html(noGame)
				}
			}
		});
	};
	//积分数据
	var load_jf=function(){
		$(".zlksaisTitle").hide();
		var html="";
		$.ajax({
			url:'/zlk/jsbf/match/jf_'+P.id+'.xml?'+Math.random(),
			type:'GET',
			DataType:'XML',
			success: function(xml){
				var Rows = $(xml).find("Rows");
				if(id==135){
					var group = Rows.find("group");
					group.each(function(){
						var row = $(this).find("row");
						var group = $(this).attr("group");
						html+='<article>';
						html+='<div class="sfcTitle">'+group+'组<em class="up"></em></div>';
						html+='<div style="display:">';
						html+='<div class="zlkjfList zlkssTitle">';
						html+='<strong>排名</strong><cite>球队</cite><em>场</em><em>胜</em><em>平</em><em>负</em><em>积分</em>';
						html+='</div>';
						html+='<ul class="zlkjfList" id="jfData">';
						row.each(function(i){
							var teamName = $(this).attr("teamName");
							var win = parseInt($(this).attr("win"));
							var draw = parseInt($(this).attr("draw"));
							var lose = parseInt($(this).attr("lose"));
							var matchCount = win+draw+lose;
							var integral = $(this).attr("integral");
							if(i==0||i==1){
								html+='<li><strong><i class="greenbg">'+(i+1)+'</i></strong><cite>'+teamName.substring(0,5)+'</cite><em>'+matchCount+'</em><em>'+win+'</em><em>'+draw+'</em><em>'+lose+'</em><em>'+integral+'</em></li>';
							}else{
								html+='<li><strong><i>'+(i+1)+'</i></strong><cite>'+teamName.substring(0,5)+'</cite><em>'+matchCount+'</em><em>'+win+'</em><em>'+draw+'</em><em>'+lose+'</em><em>'+integral+'</em></li>';
							}
						})
						
						html+='</ul>';
						html+='</div>';
						html+='</article>';
					});
				}else{
					//$(".zlksaisTitle").hide();
					$(".zlkFooter").hide();
					var html="";
					var row=$(xml).find("row");
					var len = row.length;
					if(len>0){
						html+='<article>';
						//html+='<div class="sfcTitle">'+group+'组<em class="up"></em></div>';
						html+='<div style="display:">';
						html+='<div class="zlkjfList zlkssTitle">';
						html+='<strong>排名</strong><cite>球队</cite><em>场</em><em>胜</em><em>平</em><em>负</em><em>积分</em>';
						html+='</div>';
						html+='<ul class="zlkjfList" id="jfData">';
						row.each(function(i){
							var teamName = $(this).attr("teamName");//球队名称
							//var $matchCount = $(this).find("matchCount");//比完赛的场次数量
							
							var win = $(this).attr("win");//胜场
							var draw = $(this).attr("draw");//平场
							var lose = $(this).attr("lose");//负场
							
							var matchCount= parseInt(win)+parseInt(draw)+parseInt(lose)
							var integral = $(this).attr("integral");//积分
							
							if(i==0||i==1){
								html+='<li><strong><i class="">'+(i+1)+'</i></strong><cite>'+teamName.substring(0,5)+'</cite><em>'+matchCount+'</em><em>'+win+'</em><em>'+draw+'</em><em>'+lose+'</em><em>'+integral+'</em></li>';
							}else{
								html+='<li><strong><i>'+(i+1)+'</i></strong><cite>'+teamName.substring(0,5)+'</cite><em>'+matchCount+'</em><em>'+win+'</em><em>'+draw+'</em><em>'+lose+'</em><em>'+integral+'</em></li>';
							}
							
							//html+='<li><strong><i>'+(i+1)+'</i></strong><cite>'+teamName.substring(0,5)+'</cite><em>'+matchCount+'</em><em>'+win+'</em><em>'+draw+'</em><em>'+lose+'</em><em>'+integral+'</em></li>';
						});
						html+='</ul>';
						html+='</div>';
						html+='</article>';
						//$("#jfData").html(html);
					}
				}
				
				$("#jfCont").html(html);
			},
			error:function(){
				$("#jfCont").html(noGame);
			}
		});
	};
	
	//射手数据
	var load_sf=function(){
		//$(".zlksaisTitle").hide();
		var html="";
		$.ajax({
			url:'/zlk/jsbf/match/ssb_'+P.id+'.xml?'+Math.random(),
			type:'GET',
			DataType:'XML',
			success: function(xml){
				var R=$(xml).find("Rows");
				var row=R.find("row");
				var len = row.length;
				if(len>0){
					row.each(function(i){
						var playerName = $(this).attr("playerName");//球队名称
						playerName = playerName.substring(0,5)
						var rank = $(this).attr("rank");//比完赛的场次数量
						var teamName = $(this).attr("teamName");//胜场
						teamName = teamName.substring(0,5)
						var goals = $(this).attr("goals");//平场
						if(rank=="1"){
							html+='<li><strong><i class="one">'+(rank<10?"0"+rank:rank)+'</i></strong><em>'+playerName+'</em><cite>'+teamName+'</cite><span>'+goals+'</span></li>';
						}else if(rank=="2"){
							html+='<li><strong><i class="two">'+(rank<10?"0"+rank:rank)+'</i></strong><em>'+playerName+'</em><cite>'+teamName+'</cite><span>'+goals+'</span></li>';
						}else if(rank=="3"){
							html+='<li><strong><i class="three">'+(rank<10?"0"+rank:rank)+'</i></strong><em>'+playerName+'</em><cite>'+teamName+'</cite><span>'+goals+'</span></li>';
						}else{
							html+='<li><strong><i class="">'+(rank<10?"0"+rank:rank)+'</i></strong><em>'+playerName+'</em><cite>'+teamName+'</cite><span>'+goals+'</span></li>';
						}
						
						
					});
					$("#ssCont ul").html(html);
				}else{
					$("#ssCont ul").html(noGame);
				}
			}
		});
	};
	
	
	
	var load_nav=function(index){
		if(CP.MobileVer.android){//android
			if(from && from=="androidapp"){
				switch(index){
				case 0:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").removeClass("antjHeader").addClass("zlkssHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//赛事数据
				break;
				case 1:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").removeClass("anHeader").addClass("zlkHeader").addClass("antjHeader"),$(".moreHeader").hide(),$(".zlkFooter").show();//积分排名
				break;
				case 2:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").removeClass("anHeader").addClass("zlkHeader").addClass("antjHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//射手数据
				break;
				default:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").removeClass("antjHeader").addClass("zlkssHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();
				}
			}else{
				
				
				switch(index){
				case 0:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();//赛事数据
				break;
				case 1:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").show();//积分排名
				break;
				case 2:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").hide();//射手数据
				break;
				default:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();
				}
				/***
				switch(index){
				case 0:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").removeClass("antjHeader").addClass("zlkssHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//赛事数据
				break;
				case 1:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").removeClass("anHeader").addClass("zlkHeader").addClass("antjHeader"),$(".moreHeader").hide(),$(".zlkFooter").show();//积分排名
				break;
				case 2:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").removeClass("anHeader").addClass("zlkHeader").addClass("antjHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//射手数据
				break;
				default:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").removeClass("antjHeader").addClass("zlkssHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();
				}
				***/
			}
		}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
			if(from && from=="iosapp"){
				switch(index){
				case 0:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").removeClass("antjHeader").addClass("zlkssHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//赛事数据
				break;
				case 1:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").removeClass("anHeader").addClass("zlkHeader").addClass("antjHeader"),$(".moreHeader").hide(),$(".zlkFooter").show();//积分排名
				break;
				case 2:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").removeClass("anHeader").addClass("zlkHeader").addClass("antjHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//射手数据
				break;
				default:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").removeClass("antjHeader").addClass("zlkssHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();
				}
			}else{
				switch(index){
				case 0:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();//赛事数据
				break;
				case 1:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").show();//积分排名
				break;
				case 2:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").hide();//射手数据
				break;
				default:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();
				}
			}
			
		}else{//4g
			switch(index){
			case 0:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();//赛事数据
			break;
			case 1:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").show();//积分排名
			break;
			case 2:$(".zlksaisTitle").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").hide();//射手数据
			break;
			default:$(".zlksaisTitle").show(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();
			}
		}
	};
	
	var load_header=function(id){
		if(id && id !=null){
			$(".moreHeader h1").html(g[id]);
		}else{
			return;
		}
		
	};
	
	var forwardURL = function(itemId){
		var url = "/app/zqzlk/index.html";
		if(itemId){
			if(CP.MobileVer.android){//android
				try {
					window.caiyiandroid.clickAndroid(8, itemId);//跳转
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
				try {
					WebViewJavascriptBridge.callHandler('callBackJSBF',itemId);
				} catch (e){
					window.location.href = url;
				}
			}else{//4g
				return;
			}
		}else{
			alert("暂无比赛详细数据")
			return;
		}
	}
	
	
	//获取当前轮次
	var getCurrent_Round=function(){
		slide({
            'effect':'swing',//切换效果
            'menuSpeed':200,//菜单滑动时间
            'conSpeed':350,//内容滑动时间
            'menu':'#nav_ul li',//点击tab切换
            'con':'#slideCont article',//对应的内容块
        });
	};
	
	return {
		init:init
	}
})();
$(function(){
	CP.ZLK.init();
})


