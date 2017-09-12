var CP={}
CP.JSBF=(function(){
	//初始化方法
	var init = function(){
		jxzCont();
		ywsCont();
		bindEvent();
	};
	
	
	var D={
		"0":"星期天",
		"1":"星期一",
		"2":"星期二",
		"3":"星期三",
		"4":"星期四",
		"5":"星期五",
		"6":"星期六"
	};
	//格式化时间(周几)
	var getD=function(t){
		var str = "";
		var d = new Date(t.replace(/-/g,"/"));
		
		var day = d.getDay();
		str = D[day];
		
		return str;
	};
	
	//格式化时间(几月几号)
	var getTimeStr=function(t){
		var str = "";
		var d = new Date(t.replace(/-/g,"/"));
		
		var m = d.getMonth()+1;
		//m=m<10?"0"+m:m;
		
		var dt = d.getDate();
		str = m+"月"+dt+"日";
		return str;
	}
	
	//绑定事件
	var bindEvent=function(){
		var l = $('.downline').offset().left;
		$('.clearfix li').click(function(){
			var liindex = $('.clearfix li').index(this);
			$(this).addClass('cur').siblings().removeClass('cur');
			var liWidth = $(this).width();
			$('.downline').stop(false,true).animate({'left' : liindex * liWidth+l + 'px'},300);
			if($(this).attr("st")=="wws"){
				$("#progress").show();
				$("#over").hide();
				jxzCont();
			}else if($(this).attr("st")=="yws"){
				window.clearInterval(serverId);
				$("#progress").hide();
				$("#over").show();
			}
		});
		$('#wanfa_').Touch(function(){
			$(this).toggleClass('hmTit');
			$(this).next().toggle();
		});
	};
	
	//进行中的比赛内容
	var jxzCont=function(){
		var flag = false;
		var jxzHTML="";
		var kstime;
		var arrsid = [];
		$.ajax({
			url:'/zlk/jsbf/jc/openrounddata/jcnew.xml',
			type:'GET',
			DataType:'XML',
			success: function(xml){
				var statge = $(xml).find("statge");
				statge.each(function(){
					var row = $(this).find("row");
					var len = row.length;
					var stime = $(this).attr("time");//每天比赛事件
					jxzHTML += '<section>';
					jxzHTML += '<div class="jsbfTitle jsbfTitle2">'+getTimeStr(stime)+' '+getD(stime)+'<em class="up"></em></div>';
					jxzHTML += '<div class="jsbjList">';
					
					row.each(function(){
						var type = $(this).attr("type");//比赛状态
						flag=true;
						var ln = $(this).attr("ln");//赛事级别
						var jn = $(this).attr("jn");//周三001
						jn = jn.substr(-3);
						var hn = $(this).attr("hn");//主队名称
						var gn = $(this).attr("gn");//客队名称
						
						var time = $(this).attr("time");//比赛显示用时间,如果开赛htime不为空,则用它来计算比赛进行时间
						var htime = $(this).attr("htime");//上半场和下半场的开赛时间
						kstime = htime?htime:time;
						var hsc = $(this).attr("hsc");//主队得分
						var asc = $(this).attr("asc");//客队得分
						var halfsc = $(this).attr("halfsc");//半场得分
						var csid = $(this).attr("sid");
						var timestr = time.substring(11,16);
						var itemid = $(this).attr("itemid");
						var qc = $(this).attr("qc");
						var roundItemId = $(this).attr("roundItemId");//每场比赛对应的id
						arrsid.push(csid);//将所有比赛的比赛id放入一个数组中
						//<img src="/img/in.gif" width="12" height="12" id="img_'+csid+'">;
						if(type==1 || type==2 || type==3){//上半场,中场,下半场
							
							/***
							jxzhtml += '<a href="dzxq.html?itemid='+roundItemId+'&type='+type+'&qc='+qc+'&flag=jxz'+'">';
							jxzhtml += '<p><cite>'+ln+'</cite><span>'+jn+' '+timestr+'</span></p>';
							jxzhtml += '<p>'+hn+'</p>';
							jxzhtml += '<p class="jsbfli"><cite class="red" id="up_'+csid+'">'+hsc+':'+asc+'</cite><span class="green" id="tid_'+csid+'"><cite id="m_'+csid+'">加载</cite><img src="/img/in.gif" width="12" height="12" id="img_'+csid+'"></span></p>';
							jxzhtml += '<p>'+gn+'</p>';
							jxzhtml += '<em class="hmArrow"></em>';
							jxzhtml += '</a>';
							***/
							 jxzHTML += '<a href="dzxq22.html?itemid='+roundItemId+'">';
							 jxzHTML += '<p>'+timestr+'</p>';
							 jxzHTML += '<p><span>'+jn+'  '+ln+'</span><cite>'+hn+' - '+gn+'</cite></p>';
							 jxzHTML += '<p><em id="m_'+csid+'">加载中...</em><cite class="red" id="up_'+csid+'">'+hsc+':'+asc+'</cite>';
							 jxzHTML += '<span><i class="lsico"></i>乐视网</span>';
							 jxzHTML += '</p>';
							 jxzHTML += '</a>';
						}else if(type==17){//未开赛
							/***
							var ln = $(this).attr("ln");//赛事级别
							var jn = $(this).attr("jn");//周三001
							jn = jn.substr(-3);
							var hn = $(this).attr("hn");//主队名称
							var gn = $(this).attr("gn");//客队名称
							
							var time = $(this).attr("time");//比赛显示用时间,如果开赛htime不为空,则用它来计算比赛进行时间
							var htime = $(this).attr("htime");//上半场和下半场的开赛时间
							kstime = htime?htime:time;
							var hsc = $(this).attr("hsc");//主队得分
							var asc = $(this).attr("asc");//客队得分
							var halfsc = $(this).attr("halfsc");//半场得分
							var csid = $(this).attr("sid");
							var timestr = time.substring(11,16);
							var itemid = $(this).attr("itemid");
							var qc = $(this).attr("qc");
							***/
							//var roundItemId = $(this).attr("roundItemId");//每场比赛对应的id
							 jxzHTML += '<a href="dzxq22.html?itemid='+roundItemId+'">';
							 jxzHTML += '<p>'+timestr+'</p>';
							 jxzHTML += '<p><span>'+jn+'  '+ln+'</span><cite>'+hn+' - '+gn+'</cite></p>';
							 jxzHTML += '<p class="wks">未开赛</p>';
							 jxzHTML += '</a>';
						}
					});
					/***
					if(!flag){
						jxzHTML="<div style='text-align:center;height:100px;padding-top:50px;'>暂无进行中的比赛</div>";
					}
					***/
					jxzHTML += '</div>';
					jxzHTML += '</section>';
				});
				$("#progress").html(jxzHTML);
				update(arrsid);
			}
		})
	};
	//实时更新正在进行中的对阵
	var update=function(arrsid){
		var st
		serverId=window.setInterval(function(){
			$.ajax({
				url:'/zlk/jsbf/jc/changerounddata/changeRound.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var rows = $(xml).find("rows");
					var stime = rows.attr("time");
					if(stime){
						var serverTime = new Date(rows.attr("time").replace(/-/g,"/"));//服务器时间
					}
					
					var row = rows.find("row");
					row.each(function(){
						var type = $(this).attr("type");
						//var sid = $(this).attr("sid");
						if(type==1 || type==2 || type==3){
							var hg = $(this).attr("hg");
							var ag = $(this).attr("ag");
							var time = new Date($(this).attr("time").replace(/-/g,"/"));//比赛开始时间
							st = parseInt((serverTime-time)/60000);
							if(type==1){//上半场
								var sid = $(this).attr("sid");
								if(st<=45){
									st = parseInt((serverTime-time)/60000);
									//$("#img_"+sid).show();
								}else{//上半场补时
									st = "45+";
									//$("#img_"+sid).hide();
								}
								$("#img_"+sid).show();
								updateTime(sid,arrsid,hg,ag,st)
							}else if(type==2){//中场
								var sid = $(this).attr("sid");
								st="中";
								$("#img_"+sid).hide();
								updateTime(sid,arrsid,hg,ag,st)
							}else if(type==3){//下半场
								var sid = $(this).attr("sid");
								if(st<=45){
									st = 45+parseInt((serverTime-time)/60000);
								}else{
									st = "90+";
								}
								$("#img_"+sid).show();
								updateTime(sid,arrsid,hg,ag,st);
							}
						}
					})
				}
			})
		},2000)
	};
	var updateTime=function(sid,arrsid,hg,ag,st){
		for(var i=0;i<arrsid.length;i++){
			if(sid==arrsid[i]){
				//$("#tid_"+sid).find("cite").html(st);
				$("#m_"+arrsid[i]).html(st);
				$("#up_"+arrsid[i]).html(hg+":"+ag);
				
			}
		}
	};
	
	//历史一期完赛的内容
	var lsfirstCont=function(){
		var firstywshtml=""
		var num = 0
		$.ajax({
			url:'/zlk/jsbf/jc/openrounddata/jcOldOne.xml',
			type:'GET',
			DataType:'XML',
			success: function(xml){
				var statge = $(xml).find("statge");
				statge.each(function(){
					var row = $(this).find("row");
					var len = row.length;
					var stime = $(this).attr("time");//每天比赛事件
					firstywshtml += '<div class="jsbfTitle jsbfTitle2">'+getTimeStr(stime)+' '+getD(stime)+'<em class="up"></em></div>';
					firstywshtml += '<div class="jsbjList jsbjList2">';
					
					row.each(function(){
						var ln = $(this).attr("ln");//赛事级别
						var jn = $(this).attr("jn");//周三001
						jn=jn.substr(-3);
						var hn = $(this).attr("hn");//主队名称
						var gn = $(this).attr("gn");//客队名称
						var type = $(this).attr("type");//比赛状态
						var time = $(this).attr("time");//比赛显示用时间,如果开赛htime不为空,则用它来计算比赛进行时间
						var htime = $(this).attr("htime");//上半场和下半场的开赛时间
						var hsc = $(this).attr("hsc");//主队得分
						var asc = $(this).attr("asc");//客队得分
						var halfsc = $(this).attr("halfsc");//半场得分
						var roundItemId = $(this).attr("roundItemId");//每场比赛对应的id
						var qc = $(this).attr("qc");
						var timestr = htime?htime.substring(11,16):time.substring(11,16);
						
						var zb = $(this).attr("zb");//是否有直播
						var tvlive = $(this).attr("tvlive");//对应的直播媒体
						if(type==4){//1:上半场,2:中场,3：下半场
							firstywshtml += '<a href="dzxq22.html?itemid='+roundItemId+'">';
							firstywshtml += '<p>'+timestr+'</p>';
							firstywshtml += '<p><span>'+jn+'  '+ln+'</span><cite>'+hn+' - '+gn+'</cite>';
							
							if(zb=="1"){
								firstywshtml += '<span>'+tvlive+'</span>';
							}else{
								firstywshtml += '';
							}
							firstywshtml += '</p>';
							
							firstywshtml += '<p>'+hsc+'-'+asc+'</p>';
							firstywshtml += '</a>';
						}
					});
					
					firstywshtml += '</div>';
					$("#lsfirstCont").html(firstywshtml);
					$("#lsfirstCont div.jsbfTitle").bind("click",function(){
						$(this).find("em.up").toggleClass("down");
						$(this).next().toggle();
					})
				});
			}
		})
	}
	
	//历史二期完赛的内容
	var lssecondCont=function(){
		var num=0
		var secontywshtml="";
		$.ajax({
			url:'/zlk/jsbf/jc/openrounddata/jcOldTwo.xml',
			type:'GET',
			DataType:'XML',
			success: function(xml){
				var statge = $(xml).find("statge");
				statge.each(function(){
					var row = $(this).find("row");
					var len = row.length;
					var stime = $(this).attr("time");//每天比赛事件
					
					secontywshtml += '<div class="jsbfTitle jsbfTitle2">'+getTimeStr(stime)+' '+getD(stime)+'<em class="up"></em></div>';
					secontywshtml += '<div class="jsbjList jsbjList2">';
					
					row.each(function(){
						var ln = $(this).attr("ln");//赛事级别
						var jn = $(this).attr("jn");//周三001
						jn=jn.substr(-3);
						var hn = $(this).attr("hn");//主队名称
						var gn = $(this).attr("gn");//客队名称
						var type = $(this).attr("type");//比赛状态
						var time = $(this).attr("time");//比赛显示用时间,如果开赛htime不为空,则用它来计算比赛进行时间
						var htime = $(this).attr("htime");//上半场和下半场的开赛时间
						var hsc = $(this).attr("hsc");//主队得分
						var asc = $(this).attr("asc");//客队得分
						var halfsc = $(this).attr("halfsc");//半场得分
						var roundItemId = $(this).attr("roundItemId");//每场比赛对应的id
						var qc = $(this).attr("qc");
						var timestr = htime?htime.substring(11,16):time.substring(11,16);
						var zb = $(this).attr("zb");//是否有直播
						var tvlive = $(this).attr("tvlive");//对应的直播媒体
						if(type==4){//1:上半场,2:中场,3：下半场
							secontywshtml += '<a href="dzxq22.html?itemid='+roundItemId+'">';
							secontywshtml += '<p>'+timestr+'</p>';
							secontywshtml += '<p><span>'+jn+'  '+ln+'</span><cite>'+hn+' - '+gn+'</cite>';
							if(zb=="1"){
								secontywshtml += '<span>'+tvlive+'</span>';
							}else{
								secontywshtml += '';
							}
							secontywshtml += '</p>';
							secontywshtml += '<p>'+hsc+'-'+asc+'</p>';
							secontywshtml += '</a>';
						}
					});
					
					secontywshtml += '</div>';
				});
				$("#lssecondCont").html(secontywshtml);
				$("#lssecondCont div.jsbfTitle").bind("click",function(){
					$(this).find("em.up").toggleClass("down");
					$(this).next().toggle();
				})
			}
		})
	}
	
	//已完赛
	var ywsCont=function(){
		var num=0;
		var ywshtml="";
		$.ajax({
			url:'/zlk/jsbf/jc/openrounddata/jcnew.xml',
			type:'GET',
			DataType:'XML',
			success: function(xml){
				var statge = $(xml).find("statge");
				statge.each(function(){
					var row = $(this).find("row");
					var len = row.length;
					var stime = $(this).attr("time");//每天比赛事件
					var oldStageNameOne = $(this).attr("oldStageNameOne");//每天比赛事件
					var oldStageNameTwo = $(this).attr("oldStageNameTwo");//每天比赛事件
					ywshtml+='<div class="jsbfTitle jsbfTitle2">'+getTimeStr(stime)+' '+getD(stime)+'<em class="up"></em></div>';
					ywshtml+='<div class="jsbjList jsbjList2">';
					
					
					row.each(function(){
						var ln = $(this).attr("ln");//赛事级别
						var jn = $(this).attr("jn");//周三001
						jn=jn.substr(-3);
						var hn = $(this).attr("hn");//主队名称
						var gn = $(this).attr("gn");//客队名称
						var type = $(this).attr("type");//比赛状态
						var time = $(this).attr("time");//比赛显示用时间,如果开赛htime不为空,则用它来计算比赛进行时间
						var htime = $(this).attr("htime");//上半场和下半场的开赛时间
						var hsc = $(this).attr("hsc");//主队得分
						var asc = $(this).attr("asc");//客队得分
						var halfsc = $(this).attr("halfsc");//半场得分
						var roundItemId = $(this).attr("roundItemId");//每场比赛对应的id
						var qc = $(this).attr("qc");
						var timestr = htime?htime.substring(11,16):time.substring(11,16);
						
						
						var zb = $(this).attr("zb");//是否有直播
						var tvlive = $(this).attr("tvlive");//对应的直播媒体
						if(type==4){//1:上半场,2:中场,3：下半场
							
							ywshtml += '<a href="dzxq22.html?itemid="'+roundItemId+'>';
							ywshtml += '<p>'+timestr+'</p>';
							ywshtml += '<p><span>'+jn+'  '+ln+'</span><cite>'+hn+' - '+gn+'</cite>';
							if(zb=="1"){
								ywshtml += '<span>'+tvlive+'</span>';
							}else{
								ywshtml += '';
							}
							
							ywshtml += '</p>';
							ywshtml += '<p>'+hsc+'-'+asc+'</p>';
							ywshtml += '</a>';
						}
					});
				});
				ywshtml += '</div>';
				$("#dq").html(ywshtml);
				
				lsfirstCont();
				var t = $("#dq div.jsbjList").html();
				if(!t){
					$("#dq").hide();
				}else{
					$("#dq").show();
				}
				lssecondCont();
				$("#over section .jsbfTitle").bind("click",function(){
					$(this).find("em.up").toggleClass("down");
					$(this).next().toggle();
				})
				
				
			}
		})
	}
	
	//未开赛、进行中
	return {
		init:init
	}
})()

CP.JSBF.init();