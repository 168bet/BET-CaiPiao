$(function(){
	
	XX.init_info();
});
var flag = location.search.getParam("flag");
var XX = {
		//初始化信息加载
		d:{
			"0":"星期天",
			"1":"星期一",
			"2":"星期二",
			"3":"星期三",
			"4":"星期四",
			"5":"星期五",
			"6":"星期六"
		},
		serverId:"",
		tmpID:"",
		oldStageNameFirst:"",
		oldStageNameSecond:"",
		init_info:function(){
			XX.wksCont();
			XX.jxz_info();
			XX.ywsCont();
			XX.bindEvent();
			
			var l = $('.downline').offset().left;
			var liWidth = $(".clearfix li").width();
			if(flag){
				if(flag=="jxz"){
					$('.downline').stop(false,true).animate({'left' : 0 * liWidth+l + 'px'},300);
					$(".clearfix li[st='jxz']").addClass('cur').siblings().removeClass('cur');
					$("#progress").show();
					$("#unstarting").hide();
					$("#over").hide();
				}else if(flag=="wks"){
					$('.downline').stop(false,true).animate({'left' : 1 * liWidth+l + 'px'},300);
					$(".clearfix li[st='wks']").addClass('cur').siblings().removeClass('cur');
					$("#progress").hide();
					$("#unstarting").show();
					$("#over").hide();
				}else if(flag=="yws"){
					$('.downline').stop(false,true).animate({'left' : 2 * liWidth+l + 'px'},300);
					$(".clearfix li[st='yws']").addClass('cur').siblings().removeClass('cur');
					$("#progress").hide();
					$("#unstarting").hide();
					$("#over").show();
				}else{
					$('.downline').stop(false,true).animate({'left' : 0 * liWidth+l + 'px'},300);
					$(".clearfix li[st='jxz']").addClass('cur').siblings().removeClass('cur');
					$("#progress").hide();
					$("#unstarting").show();
					$("#over").hide();
				}
			}else{
				$('.downline').stop(false,true).animate({'left' : 1 * liWidth+l + 'px'},300);
				$(".clearfix li[st='wks']").addClass('cur').siblings().removeClass('cur');
				$("#progress").hide();
				$("#unstarting").show();
				$("#over").hide();
			}
		},
		//绑定事件
		bindEvent:function(){
			var l = $('.downline').offset().left;
			$('.clearfix li').click(function(){
				var liindex = $('.clearfix li').index(this);
				$(this).addClass('cur').siblings().removeClass('cur');
				var liWidth = $(this).width();
				$('.downline').stop(false,true).animate({'left' : liindex * liWidth+l + 'px'},300);
				if($(this).attr("st")=="jxz"){
					$("#progress").show();
					$("#unstarting").hide();
					$("#over").hide();
				}else if($(this).attr("st")=="wks"){
					$("#progress").hide();
					$("#unstarting").show();
					$("#over").hide();
				}else if($(this).attr("st")=="yws"){
					$("#progress").hide();
					$("#unstarting").hide();
					$("#over").show();
				}
			});
			$('#wanfa_').Touch(function(){
				$(this).toggleClass('hmTit');
				$(this).next().toggle();
			});
			
		},
		loadCont:function(){
			
		},
		//未开赛的内容加载
		wksCont:function(){
			var wkshtml="";
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
						wkshtml += '<section>';
						//wkshtml += '<div class="sfcTitle">'+stime+'星期日 '+len+'场比赛<em class="up"></em></div>';
						wkshtml += '<div class="jsbjList">';
						
						row.each(function(){
							var ln = $(this).attr("ln");//赛事级别
							var jn = $(this).attr("jn");//周三001
							jn=jn.substr(-3)
							var hn = $(this).attr("hn");//主队名称
							var gn = $(this).attr("gn");//客队名称
							var type = $(this).attr("type");//比赛状态
							var time = $(this).attr("time");//比赛显示用时间,如果开赛htime不为空,则用它来计算比赛进行时间
							var htime = $(this).attr("htime");//上半场和下半场的开赛时间
							var hsc = $(this).attr("hsc");//主队得分
							var asc = $(this).attr("asc");//客队得分
							var halfsc = $(this).attr("halfsc");//半场得分
							var csid = $(this).attr("sid");//半场得分
							
							/***
							var tmptime = new Date(time);
							var tmpHours = tmptime.getHours();
							var tmpMinutes = tmptime.getMinutes();
							***/
							//tmpMinutes = tmpMinutes<10?"0"+tmpMinutes:tmpMinutes;
							//var tmp = tmpHours+":"+tmpMinutes;
							var timestr = htime?htime.substring(11,16):time.substring(11,16);
							var roundItemId = $(this).attr("roundItemId");//每场比赛对应的id
							
							var qc = $(this).attr("qc");
							if(type==17){//未开赛
								//wkshtml += '<a href="dzxq.html?itemid='+roundItemId+'&type='+type+'&qc='+qc+'">';
								wkshtml += '<a href="dzxq.html?itemid='+roundItemId+'&type='+type+'&qc='+qc+'&flag=wks'+'">';
								wkshtml += '<p><cite>'+ln+'</cite><span>'+jn+' '+timestr+'</span></p>';
								wkshtml += '<p>'+hn+'</p>';
								wkshtml += '<p class="jsbfli"><cite class="red">--</cite><span class="green">未开</span></p>';
								wkshtml += '<p>'+gn+'</p>';
								wkshtml += '<em class="hmArrow"></em>';
								wkshtml += '</a>';
							}
						});
						
						wkshtml += '</div>';
						wkshtml += '</section>';
					});
					$("#unstarting").html(wkshtml);
				}
			})
		},
		//加载正在进行中的对阵
		jxz_info:function(){
			var callbacks = $.Callbacks();
			callbacks.add(XX.jxzCont);
			callbacks.fire();
		},
		jxzCont:function(){
			var flag = false;
			var jxzhtml="";
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
						jxzhtml += '<section>';
						//jxzhtml += '<div class="sfcTitle">'+stime+'星期日 '+len+'场比赛<em class="up"></em></div>';
						jxzhtml += '<div class="jsbjList">';
						
						row.each(function(){
							var type = $(this).attr("type");//比赛状态
							if(type==1 || type==2 || type==3){
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
								/***
								var tmptime = new Date(time);
								var tmpHours = tmptime.getHours();
								var tmpMinutes = tmptime.getMinutes();
								tmpMinutes = tmpMinutes<10?"0"+tmpMinutes:tmpMinutes;
								var tmp = tmpHours+":"+tmpMinutes;
								var timestr = htime?(new Date(htime).getHours()+":"+new Date(htime).getMinutes()):tmp;
								***/
								//var timestr = htime?htime.substring(11,16):time.substring(11,16);
								var timestr = time.substring(11,16);
								var itemid = $(this).attr("itemid");
								var qc = $(this).attr("qc");
								var roundItemId = $(this).attr("roundItemId");//每场比赛对应的id
								arrsid.push(csid);
								jxzhtml += '<a href="dzxq.html?itemid='+roundItemId+'&type='+type+'&qc='+qc+'&flag=jxz'+'">';
								jxzhtml += '<p><cite>'+ln+'</cite><span>'+jn+' '+timestr+'</span></p>';
								jxzhtml += '<p>'+hn+'</p>';
								jxzhtml += '<p class="jsbfli"><cite class="red" id="up_'+csid+'">'+hsc+':'+asc+'</cite><span class="green" id="tid_'+csid+'"><cite id="m_'+csid+'">加载</cite><img src="/img/in.gif" width="12" height="12" id="img_'+csid+'"></span></p>';
								jxzhtml += '<p>'+gn+'</p>';
								jxzhtml += '<em class="hmArrow"></em>';
								jxzhtml += '</a>';
							}
						});
						if(!flag){
							jxzhtml="暂无进行中的比赛"
						}
						jxzhtml += '</div>';
						jxzhtml += '</section>';
					});
					$("#progress").html(jxzhtml);
					XX.update(arrsid);
				}
			})
		},
		//实时更新正在进行中的对阵
		update:function(arrsid){
			var st
			XX.serverId=window.setInterval(function(){
				$.ajax({
					url:'/zlk/jsbf/jc/changerounddata/changeRound.xml',
					type:'GET',
					DataType:'XML',
					success: function(xml){
						var rows = $(xml).find("rows");
						var serverTime = new Date(rows.attr("time").replace(/-/g,"/"));//服务器时间
						var row = rows.find("row");
						row.each(function(){
							var type = $(this).attr("type");
							//var sid = $(this).attr("sid");
							if(type==1 || type==2 || type==3){
								var hg = $(this).attr("hg");
								var ag = $(this).attr("ag");
								var time = new Date($(this).attr("time").replace(/-/g,"/"));
								st = parseInt((serverTime-time)/60000);
								if(type==1){
									var sid = $(this).attr("sid");
									if(st<=45){
										st = parseInt((serverTime-time)/60000);
										//$("#img_"+sid).show();
									}else{
										st = "45+";
										//$("#img_"+sid).hide();
									}
									$("#img_"+sid).show();
									XX.updateTime(sid,arrsid,hg,ag,st)
								}else if(type==2){
									var sid = $(this).attr("sid");
									st="中";
									$("#img_"+sid).hide();
									XX.updateTime(sid,arrsid,hg,ag,st)
								}else if(type==3){
									var sid = $(this).attr("sid");
									if(st<=45){
										st = 45+parseInt((serverTime-time)/60000);
									}else{
										st = "90+";
									}
									$("#img_"+sid).show();
									XX.updateTime(sid,arrsid,hg,ag,st)
								}
								/***
								for(var i=0;i<arrsid.length;i++){
									if(sid==arrsid[i]){
										//$("#tid_"+sid).find("cite").html(st);
										$("#m_"+sid).html("111111");
										$("#up_"+sid).html(hg+":"+ag);
										
									}
								}
								***/
							}
						})
					}
				})
			},2000)
		},
		updateTime:function(sid,arrsid,hg,ag,st){
			for(var i=0;i<arrsid.length;i++){
				if(sid==arrsid[i]){
					//$("#tid_"+sid).find("cite").html(st);
					$("#m_"+arrsid[i]).html(st);
					$("#up_"+arrsid[i]).html(hg+":"+ag);
					
				}
			}
		},
		//当期已经完赛的内容
		ywsCont:function(){
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
						XX.oldStageNameFirst=oldStageNameOne
						var oldStageNameTwo = $(this).attr("oldStageNameTwo");//每天比赛事件
						XX.oldStageNameSecond=oldStageNameTwo
						ywshtml += '<section>';
						ywshtml += '<div class="sfcTitle">'+stime+XX.getD(stime)+' '+'<cite>'+len+'</cite>场比赛<em class="up"></em></div>';
						ywshtml += '<div class="jsbjList">';
						
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
							/***
							var tmptime = new Date(time);
							var tmpHours = tmptime.getHours();
							var tmpMinutes = tmptime.getMinutes();
							var qc = $(this).attr("qc");
							tmpMinutes = tmpMinutes<10?"0"+tmpMinutes:tmpMinutes;
							var tmp = tmpHours+":"+tmpMinutes;
							***/
							var timestr = htime?htime.substring(11,16):time.substring(11,16);
							if(type==4){//1:上半场,2:中场,3：下半场
								//ywshtml += '<a href="dzxq.html?itemid='+roundItemId+'&type='+type+'&qc='+qc+'">';
								ywshtml += '<a href="dzxq.html?itemid='+roundItemId+'&type='+type+'&qc='+qc+'&flag=yws'+'">';
								ywshtml += '<p><cite>'+ln+'</cite><span>'+jn+' '+timestr+'</span></p>';
								ywshtml += '<p>'+hn+'</p>';
								ywshtml += '<p class="jsbfli"><cite class="red">'+hsc+':'+asc+'</cite><span class="green">已完</span></p>';
								ywshtml += '<p>'+gn+'</p>';
								ywshtml += '<em class="hmArrow"></em>';
								ywshtml += '</a>';
								num++
							}
						});
						
						ywshtml += '</div>';
						ywshtml += '</section>';
					});
					$("#dq").html(ywshtml);
					$("#dq section .sfcTitle cite").html(num);
					XX.lsfirstCont(XX.oldStageNameFirst);
					var t = $("#dq section .jsbjList").html();
					if(!t){
						$("#dq").hide();
					}else{
						$("#dq").show();
					}
					XX.lssecondCont(XX.oldStageNameSecond);
					$("#over section .sfcTitle").bind("click",function(){
						$(this).find("em.up").toggleClass("down");
						$(this).next().toggle();
					})
				}
			})
		},
		//历史一期完赛的内容
		lsfirstCont:function(obj1){
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
						//firstywshtml += '<section>';
						firstywshtml += '<div class="sfcTitle">'+stime+XX.getD(stime)+' '+'<cite>'+len+'</cite>场比赛<em class="up"></em></div>';
						firstywshtml += '<div class="jsbjList">';
						
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
							/***
							var tmptime = new Date(time);
							var tmpHours = tmptime.getHours();
							var tmpMinutes = tmptime.getMinutes();
							
							tmpMinutes = tmpMinutes<10?"0"+tmpMinutes:tmpMinutes;
							var tmp = tmpHours+":"+tmpMinutes;
							var timestr = htime?htime:tmp;
							***/
							var timestr = htime?htime.substring(11,16):time.substring(11,16);
							if(type==4){//1:上半场,2:中场,3：下半场
								//firstywshtml += '<a href="dzxq.html?itemid='+roundItemId+'&qc='+qc+'">';
								firstywshtml += '<a href="dzxq.html?itemid='+roundItemId+'&type='+type+'&qc='+qc+'&flag=yws'+'">';
								firstywshtml += '<p><cite>'+ln+'</cite><span>'+jn+' '+timestr+'</span></p>';
								firstywshtml += '<p>'+hn+'</p>';
								firstywshtml += '<p class="jsbfli"><cite class="red">'+hsc+':'+asc+'</cite><span class="green">已完</span></p>';
								firstywshtml += '<p>'+gn+'</p>';
								firstywshtml += '<em class="hmArrow"></em>';
								firstywshtml += '</a>';
								num++;
							}
						});
						
						firstywshtml += '</div>';
						//ywshtml += '</section>';
						$("#lsfirstCont").html(firstywshtml);
						$("#lsfirstCont section .sfcTitle cite").html(num);
						$("#lsfirstCont div.sfcTitle").bind("click",function(){
							$(this).find("em.up").toggleClass("down");
							$(this).next().toggle();
						})
					});
				}
			})
		},
		//历史二期完赛的内容
		lssecondCont:function(obj2){
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
						
						//secontywshtml += '<section>';
						secontywshtml += '<div class="sfcTitle">'+stime+XX.getD(stime)+' '+'<cite>'+len+'</cite>场比赛<em class="up"></em></div>';
						secontywshtml += '<div class="jsbjList">';
						
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
							/***
							var tmptime = new Date(time);
							var tmpHours = tmptime.getHours();
							var tmpMinutes = tmptime.getMinutes();
							
							tmpMinutes = tmpMinutes<10?"0"+tmpMinutes:tmpMinutes;
							var tmp = tmpHours+":"+tmpMinutes;
							var timestr = htime?htime:tmp;
							***/
							var qc = $(this).attr("qc");
							var timestr = htime?htime.substring(11,16):time.substring(11,16);
							if(type==4){//1:上半场,2:中场,3：下半场
								secontywshtml += '<a href="dzxq.html?itemid='+roundItemId+'&type='+type+'&qc='+qc+'&flag=yws'+'">';
								//secontywshtml += '<a href="dzxq.html?itemid='+roundItemId+'&qc='+qc+'">';
								secontywshtml += '<p><cite>'+ln+'</cite><span>'+jn+' '+timestr+'</span></p>';
								secontywshtml += '<p>'+hn+'</p>';
								secontywshtml += '<p class="jsbfli"><cite class="red">'+hsc+':'+asc+'</cite><span class="green">已完</span></p>';
								secontywshtml += '<p>'+gn+'</p>';
								secontywshtml += '<em class="hmArrow"></em>';
								secontywshtml += '</a>';
								num++
							}
						});
						
						secontywshtml += '</div>';
						//ywshtml += '</section>';
					});
					$("#lssecondCont").html(secontywshtml);
					$("#lssecondCont section .sfcTitle cite").html(num);
					$("#lssecondCont div.sfcTitle").bind("click",function(){
						$(this).find("em.up").toggleClass("down");
						$(this).next().toggle();
					})
				}
			})
		},
		getD:function(t){
			var str = "";
			var d = new Date(t.replace(/-/g,"/"));
			
			var day = d.getDay();
			str = XX.d[day];
			
			return str;
		}
		
}