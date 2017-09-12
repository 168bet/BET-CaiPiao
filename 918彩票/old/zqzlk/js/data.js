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
	
var CP={};
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
	var tag = location.search.getParam('tag') || false;//ios 判断版本 不为false调他们的充值页面 否则弹窗提示
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
	var id=location.search.getParam("id");
	var from=location.search.getParam("from");
	var l = $('.downline').offset().left;
	var P={
		id:id,
		current_round:1,//当前轮次
		index:"0",
		flag:(this.index?this.index:"0")
	};
	
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
		//toggleTitle();
		load_ss();
		load_header(id);
		load_nav(P.index);
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
			case 1:load_jf();//积分舒服
			break;
			case 2:load_sf();//射手数据
			break;
			case 3:load_tj();//统计数据
			break;
			default:load_ss();
			}
			$("#ALL_CONT").children("div:eq('"+index+"')").show().siblings().hide();
		});
		
		
		$("#slideCont").delegate("article div.sfcTitle","click",function(){
			$(this).next().toggle();
			$(this).find("em").toggleClass("down");
		});
		
		$("#jfCont").delegate("article div.sfcTitle","click",function(){
			$(this).next().toggle();
			$(this).find("em").toggleClass("down");
		});
		
		$('#slideCont').delegate('a','click',function(){
			var itemId = $(this).attr("itemId");
			forwardURL(itemId);
		});
	};
	
	 /*滑动[[*/
    var slide=function(_obj){
        var menu = $(_obj.menu);//菜单点击滑动DOM
        var con = $(_obj.con);//内容滑动DOM
        var len = con.length;
        var cur = _obj.cur || P.current_round;//默认第一个选中(注意11选五只有0到2)
        var Q = con.width();//单个内容块宽度
        con.each(function(i){
        	$(this).show();
            $(this).css({'left': i<cur ? -Q : (i>cur ? Q:'') }) ;
            i==cur?$(this).css({'left':0 }):'' ;
        });
        menu.off().click(function(){
        	var index=0;
        	var $li_cont = $("#wdls ul li:eq(1)").html();
        	if($(this).index()){
        		index = parseInt($li_cont.substring(1,$li_cont.length-1))+1;
        	}else{
        		index = parseInt($li_cont.substring(1,$li_cont.length-1))-1;
        	}
        	//P.current_round = (index && index<len)?index:;
        	P.current_round=index
        	if(index>=1 && index<=len){
        		P.current_round=index;
        		$("#wdls .cur").html("第"+index+"轮")
            	index -= 1;
                var conW=  con.width();//单个内容块宽度
                con.each(function(i){
                	$(this).stop(true,false).animate({'left': i<index ? -conW : (i>index ? conW:'') }, _obj.conSpeed||300,_obj.effect||'') ;
                    i==index?$(this).stop(true,false).animate({'left':0 } , _obj.conSpeed||300,_obj.effect||''):'' ;
                });
        	}
//            setCurrent_Round(P.current_round);
            //o.change(index);
        });
    };
	
	//赛事数据
	var load_ss=function(){
		var html="";
		$.ajax({
			url:'/zlk/jsbf/match/sc_'+P.id+'.xml?'+Math.random(),
			type:'GET',
			DataType:'XML',
			success: function(xml){
				var sc=$(xml).find("sc");
				var currArr = sc.attr("currArr");//当前轮次
				var rows=sc.find("rows");
				rows.each(function(i){
					var runArr=$(this).attr("runArr");//每轮比赛对应的轮次
					var row = $(this).find("row");//当前比赛的轮次
					var len = row.length;
					
					
					if(currArr==runArr){
						setCurrent_Round(currArr);//设置当前轮次
						P.current_round=currArr-1;
//						alert(P.current_round)
					}
					html+='<div class="zlksaisList" style="position:absolute;width:100%;display:none">';
					row.each(function(){
						var time = $(this).attr("time");
						var teamA = $(this).attr("teamA");
						var teamB = $(this).attr("teamB");
						var score = $(this).attr("score");
						var itemId = $(this).attr("itemId");
						
						html+='<a href="javascript:;" class="gray" itemId="'+itemId+'">';
						html+='<em>'+time+'</em>';
						html+='<span>'+teamA.substring(0,5)+'</span>';
						if(score == "VS"){
							html+='<cite class="">'+score+'</cite>';
						}else{
							html+='<cite class="red">'+score+'</cite>';
						}
						
						html+='<span>'+teamB.substring(0,5)+'</span>';
						html+='</a>';
					});
					html+='</div>';
				});
				$("#slideCont").html(html);
				getCurrent_Round();
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
				//var R=$(xml).find("row");
				var row=$(xml).find("row");
				var len = row.length;
				if(len>0){
					row.each(function(i){
						var teamName = $(this).attr("teamName");//球队名称
						//var $matchCount = $(this).find("matchCount");//比完赛的场次数量
						
						var win = $(this).attr("win");//胜场
						var draw = $(this).attr("draw");//平场
						var lose = $(this).attr("lose");//负场
						
						var matchCount= parseInt(win)+parseInt(draw)+parseInt(lose)
						var integral = $(this).attr("integral");//积分
						
						html+='<li><strong><i>'+(i+1)+'</i></strong><cite>'+teamName.substring(0,5)+'</cite><em>'+matchCount+'</em><em>'+win+'</em><em>'+draw+'</em><em>'+lose+'</em><em>'+integral+'</em></li>';
					});
					$("#jfData").html(html);
				}else{
					$("#jfData").html("暂无积分排名");
				}
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
						playerName = playerName.substring(0,5);
						var rank = $(this).attr("rank");//比完赛的场次数量
						var teamName = $(this).attr("teamName");//胜场
						teamName = teamName.substring(0,5);
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
					$("#ssCont ul").html("暂无射手排名");
				}
			}
		});
	}
	
	//统计数据
	var load_tj=function(){
		var html="";
		$.ajax({
			url:'/zlk/jsbf/match/tj_'+P.id+'.xml?'+Math.random(),
			type:'GET',
			DataType:'XML',
			success: function(xml){
				var row=$(xml).find("row");
				var len = row.length;
				if(len>0){
					$(".zlkNO").hide();
					var snum = row.attr("snum");//已比赛的场次
					var unsnum = row.attr("unsnum");//未比赛的场次
					var sper = row.attr("sper");//已比赛占比
					var unsper = row.attr("unsper");//未比赛占比
					var zsnum = row.attr("zsnum");//主场胜出
					var zsper = row.attr("zsper");//主场胜出占比
					var ksnum = row.attr("ksnum");//客场胜出
					var ksper = row.attr("ksper");//客场胜出占比
					var zpnum = row.attr("zpnum");//平场
					var zpper = row.attr("zpper");//平局百分比
					var dqnum = row.attr("dqnum");//总进球数
					var dqavg = row.attr("dqavg");//总进球占比
					var zdqnum = row.attr("zdqnum");//主场进球数
					var zdqavg = row.attr("zdqavg");//主场进球数占比
					var kdqnum = row.attr("kdqnum");//客队进球数
					var kdqavg = row.attr("kdqavg");//客队进球数占比
					var gmaxTeam = row.attr("gmaxTeam");//攻击力最佳球队
					var gmax = row.attr("gmax");//攻击力最佳球队进球数
					var zgmaxTeam = row.attr("zgmaxTeam");//主场攻击力最佳球队
					var zgmax = row.attr("zgmax");//主场攻击力最佳球队进球数
					var kgmaxTeam = row.attr("kgmaxTeam");//客场攻击力最佳球队
					var kgmax = row.attr("kgmax");//客场攻击力最佳球队进球数
					var gminTeam = row.attr("gminTeam");//攻击力最差球队
					var gmin = row.attr("gmin");//攻击力最差球队进球数
					var zgminTeam = row.attr("zgminTeam");//主场攻击力最差球队
					var zgmin = row.attr("zgmin");//主场攻击力最差球队进球数
					var kgminTeam = row.attr("kgminTeam");//客场攻击力最差球队
					var kgmin = row.attr("kgmin");//客场攻击力最差球队进球数
					var kpmaxTeam = row.attr("kpmaxTeam");//防守最差球队
					var kpmax = row.attr("kpmax");//防守最差球队失球数
					var zkpmaxTeam = row.attr("zkpmaxTeam");//主场防守最差球队
					var zkpmax = row.attr("zkpmax");//主场防守最差球队失球数
					var kkpmaxTeam = row.attr("kkpmaxTeam");//客场防守最差球队
					var kkpmax = row.attr("kkpmax");//客场防守最差球队失球数
					var kpminTeam = row.attr("kpminTeam");//防守最佳球队
					var kpmin = row.attr("kpmin");//防守最佳球队失球数
					var zkpminTeam = row.attr("zkpminTeam");//主场防守最佳球队
					var zkpmin = row.attr("zkpmin");//主场防守最佳球队失球数
					var kkpminTeam = row.attr("kkpminTeam");//客场防守最佳球队
					var kkpmin = row.attr("kkpmin");//客场防守最佳球队失球数
					
					var updatetime= row.attr("updatetime");
					
					$("#tjCont ul li:eq(0)").find("p:eq(0) em").html(snum);
					$("#tjCont ul li:eq(0)").find("p:eq(0) span").html("占"+sper+"%");
					$("#tjCont ul li:eq(0)").find("p:eq(1) em").html(unsnum);
					$("#tjCont ul li:eq(0)").find("p:eq(1) span").html("占"+unsper+"%");
					
					$("#tjCont ul li:eq(1)").find("p:eq(0) em").html(zsnum);
					$("#tjCont ul li:eq(1)").find("p:eq(0) span").html("占"+zsper+"%");
					$("#tjCont ul li:eq(1)").find("p:eq(1) em").html(ksnum);
					$("#tjCont ul li:eq(1)").find("p:eq(1) span").html("占"+ksper+"%");
					
					$("#tjCont ul li:eq(2)").find("p:eq(0) em").html(zpnum);
					$("#tjCont ul li:eq(2)").find("p:eq(0) span").html("占"+zpper+"%");
					$("#tjCont ul li:eq(2)").find("p:eq(1) em").html(dqnum);
					$("#tjCont ul li:eq(2)").find("p:eq(1) span").html("平均"+dqavg+"球/场");
					
					$("#tjCont ul li:eq(3)").find("p:eq(0) em").html(zdqnum);
					$("#tjCont ul li:eq(3)").find("p:eq(0) span").html("平均"+zdqavg+"球/场");
					$("#tjCont ul li:eq(3)").find("p:eq(1) em").html(kdqnum);
					$("#tjCont ul li:eq(3)").find("p:eq(1) span").html("平均"+kdqavg+"球/场");
					
					$("#tjCont ul li:eq(4)").find("p:eq(0) em").html(gmaxTeam);
					$("#tjCont ul li:eq(4)").find("p:eq(0) span").html("得"+gmax+"球");
					$("#tjCont ul li:eq(4)").find("p:eq(1) em").html(gminTeam);
					$("#tjCont ul li:eq(4)").find("p:eq(1) span").html("得"+gmin+"球");
					
					$("#tjCont ul li:eq(5)").find("p:eq(0) em").html(zgmaxTeam);
					$("#tjCont ul li:eq(5)").find("p:eq(0) span").html("得"+zgmax+"球");
					$("#tjCont ul li:eq(5)").find("p:eq(1) em").html(zgminTeam);
					$("#tjCont ul li:eq(5)").find("p:eq(1) span").html("得"+zgmin+"球");
					
					$("#tjCont ul li:eq(6)").find("p:eq(0) em").html(kgmaxTeam);
					$("#tjCont ul li:eq(6)").find("p:eq(0) span").html("得"+kgmax+"球");
					$("#tjCont ul li:eq(6)").find("p:eq(1) em").html(kgminTeam);
					$("#tjCont ul li:eq(6)").find("p:eq(1) span").html("得"+kgmin+"球");
					
					$("#tjCont ul li:eq(7)").find("p:eq(0) em").html(kpminTeam);
					$("#tjCont ul li:eq(7)").find("p:eq(0) span").html("失"+kpmin+"球");
					$("#tjCont ul li:eq(7)").find("p:eq(1) em").html(kpmaxTeam);
					$("#tjCont ul li:eq(7)").find("p:eq(1) span").html("失"+kpmax+"球");
					
					$("#tjCont ul li:eq(8)").find("p:eq(0) em").html(zkpminTeam);
					$("#tjCont ul li:eq(8)").find("p:eq(0) span").html("失"+zkpmin+"球");
					$("#tjCont ul li:eq(8)").find("p:eq(1) em").html(zkpmaxTeam);
					$("#tjCont ul li:eq(8)").find("p:eq(1) span").html("失"+zkpmax+"球");
					
					$("#tjCont ul li:eq(9)").find("p:eq(0) em").html(kkpminTeam);
					$("#tjCont ul li:eq(9)").find("p:eq(0) span").html("失"+kkpmin+"球");
					$("#tjCont ul li:eq(9)").find("p:eq(1) em").html(kkpmaxTeam);
					$("#tjCont ul li:eq(9)").find("p:eq(1) span").html("失"+kkpmax+"球");
					
					$(".zlkFooter").html('<p class="fixedBt">最新更新时间：<em>'+dataFormat(updatetime)+'</em></p>')
					
				}else{
					$(".zlkNO").show();
				}
			}
		});
	};
	
	var load_nav=function(index){
		if(CP.MobileVer.android){//android
			if(from && from=="androidapp"){
				switch(index){
				case 0:$("#load_nav .zlksaisTitle").show().siblings().hide(),$("body header").removeClass("zlkHeader").removeClass("antjHeader").addClass("zlkssHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//赛事数据
				break;
				case 1:$("#load_nav").children("div").hide(),$("body header").removeClass("zlkssHeader").removeClass("anHeader").addClass("zlkHeader").addClass("antjHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//积分排名
				break;
				case 2:$("#load_nav .zlkssList").show().siblings().hide(),$("body header").removeClass("zlkssHeader").removeClass("antjHeader").addClass("zlkHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//射手数据
				break;
				case 3:$("#load_nav").children("div").hide(),$("body header").removeClass("zlkssHeader").removeClass("anHeader").addClass("zlkHeader").addClass("antjHeader"),$(".moreHeader").hide(),$(".zlkFooter").show();//统计数据
				break;
				default:$("#load_nav .zlksaisTitle").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();
				}
			}else{
				switch(index){
				case 0:$("#load_nav .zlksaisTitle").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();//赛事数据
				break;
				case 1:$("#load_nav").children("div").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").hide();//积分排名
				break;
				case 2:$("#load_nav .zlkssList").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();//射手数据
				break;
				case 3:$("#load_nav").children("div").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").show();//统计数据
				break;
				default:$("#load_nav .zlksaisTitle").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();
				}
			}
		}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
			if(from && from=="iosapp"){
				switch(index){
				case 0:$("#load_nav .zlksaisTitle").show().siblings().hide(),$("body header").removeClass("zlkHeader").removeClass("antjHeader").addClass("zlkssHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//赛事数据
				break;
				case 1:$("#load_nav").children("div").hide(),$("body header").removeClass("zlkssHeader").removeClass("anHeader").addClass("zlkHeader").addClass("antjHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//积分排名
				break;
				case 2:$("#load_nav .zlkssList").show().siblings().hide(),$("body header").removeClass("zlkssHeader").removeClass("antjHeader").addClass("zlkHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();//射手数据
				break;
				case 3:$("#load_nav").children("div").hide(),$("body header").removeClass("zlkssHeader").removeClass("anHeader").addClass("zlkHeader").addClass("antjHeader"),$(".moreHeader").hide(),$(".zlkFooter").show();//统计数据
				break;
				default:$("#load_nav .zlksaisTitle").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader").addClass("anHeader"),$(".moreHeader").hide(),$(".zlkFooter").hide();
				}
			}else{
				switch(index){
				case 0:$("#load_nav .zlksaisTitle").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();//赛事数据
				break;
				case 1:$("#load_nav").children("div").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").hide();//积分排名
				break;
				case 2:$("#load_nav .zlkssList").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();//射手数据
				break;
				case 3:$("#load_nav").children("div").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").show();//统计数据
				break;
				default:$("#load_nav .zlksaisTitle").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();
				}
			}
		}else{//4g
			switch(index){
			case 0:$("#load_nav .zlksaisTitle").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();//赛事数据
			break;
			case 1:$("#load_nav").children("div").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").hide();//积分排名
			break;
			case 2:$("#load_nav .zlkssList").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();//射手数据
			break;
			case 3:$("#load_nav").children("div").hide(),$("body header").removeClass("zlkssHeader").addClass("zlkHeader"),$(".zlkFooter").show();//统计数据
			break;
			default:$("#load_nav .zlksaisTitle").show().siblings().hide(),$("body header").removeClass("zlkHeader").addClass("zlkssHeader"),$(".zlkFooter").hide();
			}
			return;
		}
	};
	
	var load_header=function(id){
		if(id && id !=null){
			$(".moreHeader h1").html(g[id]);
		}else{
			return;
		}
		
	};
	
	var load_footer=function(index){
		
	};
	
	var forwardURL = function(itemId){
		var url = "/app/zqzlk/index.html";
		if(itemId){
			if(CP.MobileVer.android){//android
				if(from && from=="androidapp"){
					try {
						window.caiyiandroid.clickAndroid(8, itemId);//跳转
					} catch (e){
						window.location.href = url;
					}
				}else{
					return;
				}
				
			}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
				if(from && from=="iosapp"){
					try {
						WebViewJavascriptBridge.callHandler('callBackJSBF',itemId);
					} catch (e){
						window.location.href = url;
					}
				}else{
					return;
				}
				
			}else{//4g
				return;
			}
		}else{
			alert("暂无比赛详细数据")
			return;
		}
	}
	
	
	var dataFormat = function(d){
		var str = "";
		//var date = new Date(d).toString();
		date = d.replace(/-/g,"/");
		date = new Date(date);
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		m=(m<10?"0"+m:m);
		var d = date.getDate();
		d=(d<10?"0"+d:d);
		
		var H = date.getHours();
		H=(H<10?"0"+H:H);
		var M = date.getMinutes();
		M=(M<10?"0"+M:M);
		var S = date.getSeconds();
		S=(S<10?"0"+S:S);
		str=y+"年"+m+"月"+d+"日"+H+"时"+M+"分"+S+"秒";
		return str;
	}
	
	
	var setCurrent_Round=function(v){
		$("#wdls ul li:eq(1)").html("第"+v+"轮")
	}
	//获取当前轮次
	var getCurrent_Round=function(){
		slide({
            'effect':'swing',//切换效果
            'menuSpeed':200,//菜单滑动时间
            'conSpeed':350,//内容滑动时间
            'menu':'#wdls ul li:eq(2),#wdls ul li:eq(0)',//点击tab切换
            'con':'#slideCont .zlksaisList',//对应的内容块
        });
	};
	
	
	var toggleTitle=function(){
		if(CP.MobileVer.android){//android
			if(from && from=="androidapp"){
				try {
					$(".tzHeader .fixedTop .moreHeader").hide();
					//window.caiyiandroid.clickAndroid(9, g["135"]);//跳转
				} catch (e){
					//window.location.href = url;
				}
			}else{
				$(".tzHeader .fixedTop .moreHeader").show();
			}
		}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
			if(from && from=="iosapp"){
				try {
					//WebViewJavascriptBridge.callHandler('callBackJSBF',itemId);
					$(".tzHeader .fixedTop .moreHeader").hide();
				} catch (e){
					//window.location.href = url;
				}
			}
		}else{//4g
			return;
		}
	};
	
	
	return {
		init:init
	}
})();
CP.ZLK.init();
