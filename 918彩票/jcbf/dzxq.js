var itemid = location.search.getParam("itemid");
var qc = location.search.getParam("qc");
var type = location.search.getParam("type");
var flag = location.search.getParam("flag");
$(function(){
	XX.init_info();
});

var XX = {
		itemid:itemid,
		type:type,
		qc:qc,
		serverTime:"",
		//初始化信息加载
		tmpID:"",
		init_info:function(){
			
			var callbacks = $.Callbacks();
			callbacks.add(XX.loadHeader);
			callbacks.add(XX.loadCont);
			callbacks.add(XX.bindEvent);
			callbacks.fire();
			
			/***
			XX.loadHeader();
			XX.loadCont();
			XX.bindEvent();
			***/
			var l = $('.downline').offset().left;
			var liindex = $('.jsbfTab ul.clearfix li[st=zj]').index();//获取当前li的索引值
			var liWidth = $(".jsbfTab ul.clearfix li").width();//获取当前li的宽度
			$('.downline').stop(false,true).animate({'left' : liindex * liWidth+l+ 'px'},300);
		},
		//绑定事件
		bindEvent:function(){
			var l = $('.downline').offset().left;
			$('.jsbfTab ul.clearfix li').click(function(){
				var liindex = $(this).index();//获取当前li的索引值
				$(this).addClass('cur').siblings().removeClass('cur');
				var liWidth = $(this).width();//获取当前li的宽度
				$('.downline').stop(false,true).animate({'left' : liindex * liWidth+l+ 'px'},300);
				if($(this).attr("st")=="ss"){
					$("#ss").show();
					$("#zj").hide();
					$("#pl").hide();
				}else if($(this).attr("st")=="zj"){
					$("#ss").hide();
					$("#zj").show();
					$("#pl").hide();
				}else if($(this).attr("st")=="pl"){
					$("#ss").hide();
					$("#zj").hide();
					$("#pl").show();
				}
			});
			
			/***
			$(".up").bind("click",function(){
				$(this).toggleClass("down");
				$(this).parent().next().toggle();
			});
			***/
			$(".zhezhao").bind("click",function(){
				$(".zfPop").hide();
				$(".zhezhao").hide();
			});
			
			$(".zfPop .jsbfTktt em").bind("click",function(){
				$(".zfPop").hide();
				$(".zhezhao").hide();
			});
			$('.fcbackIco2').bind('click',function(){
				if(flag){
					window.location.href="/jcbf/?flag="+flag;
				}else{
					if (history.length == 0) {
						return false;
					} else {
						history.go(-1);
					}
				}
			});
		},
		getServerTime:function(){
			//var serverTime="";
			window.setInterval(function(){
				$.ajax({
					url:'/zlk/jsbf/jc/changerounddata/changeRound.xml',
					type:'GET',
					DataType:'XML',
					success: function(xml){
						var rows = $(xml).find("rows");
						var time = rows.attr("time");
						XX.serverTime=time;
					}
				});
			},1000)
			//return serverTime;
		},
		//实时更新正在进行中的对阵
		update:function(sid){
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
							if(type==1 || type==2 || type==3){
								var hg = $(this).attr("hg");
								var ag = $(this).attr("ag");
								var time = new Date($(this).attr("time").replace(/-/g,"/"));
								st = parseInt((serverTime-time)/60000);
								if(type==1){
									var sid = $(this).attr("sid");
									if(st<=45){
										st = parseInt((serverTime-time)/60000);
									}else{
										st = "45+";
									}
									XX.updateTime(sid,arrsid,hg,ag,st)
								}else if(type==2){
									var sid = $(this).attr("sid");
									st="中";
								}else if(type==3){
									var sid = $(this).attr("sid");
									if(st<=45){
										st = 45+parseInt((serverTime-time)/60000);
									}else{
										st = "90+";
									}
								}
							}
						})
					}
				})
			},2000)
		},
		//比赛的头部信息
		loadHeader:function(){
			var serverTime;
			//XX.getServerTime();
			$.ajax({
				url:'/zlk/jsbf/jc/onerounddata/'+XX.itemid+".xml",
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var row = $(xml).find("row");
					var hn = row.attr("hn");
					hn=hn.substring(0,6)
					var gn = row.attr("gn");
					gn=gn.substring(0,6)
					var hid = row.attr("hid");
					var gid = row.attr("gid");
					var time = new Date(row.attr("time").replace(/-/g,"/"));//比赛时间
					var htime = new Date(row.attr("htime").replace(/-/g,"/"));//实际的上下半场开赛时间
					var hsc = row.attr("hsc");//主队得分
					var asc = row.attr("asc");//客队得分
					var type = row.attr("type");
					//var asc = row.attr("asc");
					//serverTime = XX.serverTime;
					//serverTime = new Date(serverTime.replace(/-/g,"/"));
					var str = hsc+" - "+asc;
					var T;
					if(htime){
						T=htime;
					}else{
						//T=time.substring(5);
						T=time
					}
					
					var st
					
					if(type==1){
						window.setInterval(function(){
							$.ajax({
								url:'/zlk/jsbf/jc/changerounddata/changeRound.xml',
								type:'GET',
								DataType:'XML',
								success: function(xml){
									var rows = $(xml).find("rows");
									var serverTime = new Date(rows.attr("time").replace(/-/g,"/"));
									//serverTime = time
									st = parseInt((serverTime-T)/60000);
									if(st>45){
										st="45+"
									}
									$(".dzxqBf ul").next("p").find("cite").html(st);
								}
							});
						},1000)
						
					}else if(type==2){
						st = "中";
						$(".dzxqBf ul").next("p").find("cite").html(st);
					}else if(type==3){
						window.setInterval(function(){
							$.ajax({
								url:'/zlk/jsbf/jc/changerounddata/changeRound.xml',
								type:'GET',
								DataType:'XML',
								success: function(xml){
									var rows = $(xml).find("rows");
									var serverTime = new Date(rows.attr("time").replace(/-/g,"/"));
									//serverTime = time
									st = 45+parseInt((serverTime-T)/60000);
									if(st>90){
										st="90+"
									}
									$(".dzxqBf ul").next("p").find("cite").html(st);
								}
							});
						},1000)
						//st = 45+parseInt((serverTime-htime)/60000);
					}
					
					
					
					$(".dzxqBf ul li:eq(0)").html(hn);
					//$(".dzxqBf ul li:eq(1)").html(str);
					$(".dzxqBf ul li:eq(2)").html(gn);
					//$(".dzxqBf ul").next("p").html(T+"开赛");
					
					if(type==17){
						//$(".dzxqBf ul").find("cite").html("未开赛");
						$(".dzxqBf ul li:eq(1)").html(str);
						/***
						$(".dzxqBf ul").next("p").find("img").hide();
						$(".dzxqBf ul").next("p").find("cite").show();
						***/
						$(".dzxqBf ul").next("p").find("cite").html("未开赛");
						$(".dzxqBf ul").next("p").find("img").hide();
						$(".dzxqBf ul").next("p").show();
					}else if(type==4){
						$(".dzxqBf ul li:eq(1)").html(str);
						$(".dzxqBf ul").next("p").find("cite").html("已完赛");
						$(".dzxqBf ul").next("p").find("img").hide();
						$(".dzxqBf ul").next("p").show();
					}else if(type==1 || type==2 || type==3){
						if(type==2){
							$(".dzxqBf ul").next("p").find("img").hide();
						}
						$(".dzxqBf ul li:eq(1)").html(str);
						//$(".dzxqBf ul").next("p").html(st);
						$(".dzxqBf ul").next("p").show();
					}
				}
			});
		},
		loadCont:function(){
			XX.ss();
			XX.zj();
			XX.pl();
		},
		ss:function(){
			XX.symd();
			XX.bssj();
			XX.jstj();
		},
		//比赛事件
		bssj:function(){
			var html="";
			$.ajax({
				url:'/zlk/jsbf/jc/oneroundeventdata/'+XX.itemid+".xml",
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var rows = $(xml).find("rows");
					var row = $(xml).find("row");
					if(row.length>0){
						html+='<i class="timeIco"></i>'
							row.each(function(){
								var pn = $(this).attr("pn");//球员名字
								var time = $(this).attr("time");//进球时间
								var eventType = $(this).attr("eventType");//时间类型
								var teamType = $(this).attr("teamType");//0主队，-1客队
								if(teamType==0){
									if(eventType==0){//进球
										html+='<div class="timeleft"><span><em>'+pn+'</em><cite class="jqico"></cite></span><b>'+time+'&prime;</b></div>';//主队进球
									}else if(eventType==1){//点球
										html+='<div class="timeleft"><span><em>'+pn+'</em><cite class="dqico"></cite></span><b>'+time+'&prime;</b></div>'
									}else if(eventType==2){//乌龙球
										html+='<div class="timeleft"><span><em>'+pn+'</em><cite class="wlico"></cite></span><b>'+time+'&prime;</b></div>'
									}else if(eventType==3){//黄牌
										html+='<div class="timeleft"><span><em>'+pn+'</em><cite class="hpico"></cite></span><b>'+time+'&prime;</b></div>'
									}else if(eventType==4){//红牌
										html+='<div class="timeleft"><span><em>'+pn+'</em><cite class="redico"></cite></span><b>'+time+'&prime;</b></div>'
									}else if(eventType==5){//两黄变红
										html+='<div class="timeleft"><span><em>'+pn+'</em><cite class="lhbhico"></cite></span><b>'+time+'&prime;</b></div>'
									}
								}else{
									if(eventType==0){//进球
										html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="jqico"></cite>'+pn+'</span></div>';
									}else if(eventType==1){//点球
										html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="dqico"></cite>'+pn+'</span></div>';
									}else if(eventType==2){//乌龙球
										html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="wlico"></cite>'+pn+'</span></div>';
									}else if(eventType==3){//黄牌
										html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="hpico"></cite>'+pn+'</span></div>';
									}else if(eventType==4){//红牌
										html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="redico"></cite>'+pn+'</span></div>';
									}else if(eventType==5){//两黄变红
										html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="lhbhico"></cite>'+pn+'</span></div>';
									}
								}
							})
							if(XX.type==17){
								html+='<div class="timeright timeright2"><b>90&prime;</b><p>完赛</p></div>';
							}else if(XX.type==1 || XX.type==2 || XX.type==3){
								html+="";
							}else if(XX.type==4){
								html+='<div class="timeright timeright2"><b>90&prime;</b><p>完赛</p></div>';
							}
							
							$("#bssj").html(html);
					}else{
						$("#bssj").parents("div").hide();
						$("#bssj").parents("div").prev().hide();
					}
				}
			})
		},
		//伤员名单
		symd:function(){
			var syhtmlA="";
			var syhtmlB="";
			var sfhtmlA="";
			var sfhtmlB="";
			var tbhtmlA="";
			var tbhtmlB="";
			$.ajax({
				url:'/zlk/jsbf/jc/roundPlayerdata/'+XX.itemid+'.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var rows = $(xml).find("rows");
					var row = rows.find("row");
					var weakPlayerA = row.attr("weakPlayerA");//主队伤员名单
					var weakPlayerB = row.attr("weakPlayerB");//客队伤员名单
					
					var SFPlayerA = row.attr("SFPlayerA");//主队首发名单
					var SFPlayerB = row.attr("SFPlayerB");//客队首发名单
					
					var TBPlayerA = row.attr("TBPlayerA");//替补首发名单
					var TBPlayerB = row.attr("TBPlayerB");//替补首发名单
					//var weakPlayerAarr = weakPlayerA.split(",");
					var weakPlayerBarr = weakPlayerB.split(",");
					
					
					//伤员
					if(!weakPlayerA){
						//$("#symd").prev().hide();
						//$("#symd ul:eq(0)").hide();
						$("#symd ul:eq(0)").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>");
					}else{
						var weakPlayerAarr = weakPlayerA.split(",");
						for(var i = 0;i<weakPlayerAarr.length;i++){
							var subA = weakPlayerAarr[i].split("-")
							syhtmlA += '<li>'+subA[1]+'<b>'+subA[0]+'</b></li>';
						}
						$("#symd ul:eq(0)").html(syhtmlA);
						$("#symd").prev().show();
						$("#symd ul:eq(0)").show();
					}
					if(!weakPlayerB){
						//$("#symd").prev().hide();
						//$("#symd ul:eq(1)").hide();
						$("#symd ul:eq(1)").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>");
					}else{
						var weakPlayerBarr = weakPlayerB.split(",");
						for(var i = 0;i<weakPlayerBarr.length;i++){
							var subB = weakPlayerBarr[i].split("-")
							syhtmlB += '<li><em>'+subB[0]+'</em>'+subB[1]+'</li>';
						}
						$("#symd ul:eq(1)").html(syhtmlB);
						$("#symd").prev().show();
						$("#symd ul:eq(1)").show();
					}
					
					if(!weakPlayerA && !weakPlayerB){
						$("#symd").prev().hide();
						$("#symd ul:eq(0)").hide();
						$("#symd ul:eq(1)").hide();
					}else{
						$("#symd").prev().show();
						$("#symd ul:eq(0)").show();
						$("#symd ul:eq(1)").show();
					}
					
					//首发
					if(SFPlayerA){
						var SFPlayerAarr = SFPlayerA.split(",");
						for(var i=0;i<SFPlayerAarr.length;i++){
							var sub = SFPlayerAarr[i].split("-");
							sfhtmlA += '<li>'+sub[1]+'<b>'+sub[0]+'</b></li>';
						}
						$("#sfmd .dzxqList ul:eq(0)").html(sfhtmlA)
					}else{
						$("#sfmd .dzxqList ul:eq(0)").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>")
						//$("#sfmd .dzxqList ul:eq(0)").hide();
						//$("#sfmd .dzxqList ul:eq(0)").prev().hide();
					}
					
					if(SFPlayerB){
						var SFPlayerBarr = SFPlayerB.split(",");
						for(var i=0;i<SFPlayerBarr.length;i++){
							var sub = SFPlayerBarr[i].split("-");
							sfhtmlB += '<li><em>'+sub[0]+'</em>'+sub[1]+'</li>';
						}
						$("#sfmd .dzxqList ul:eq(1)").html(sfhtmlB)
					}else{
						$("#sfmd .dzxqList ul:eq(1)").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>")
						//$("#sfmd .dzxqList ul:eq(1)").hide();
						//$("#sfmd").hide();
					}					
					if((!SFPlayerA) && (!SFPlayerB)) //若两方均无数据，隐藏
						$("#sfmd").hide();										
					
					//替补
					if(TBPlayerA){
						var TBPlayerAarr = TBPlayerA.split(",");
						for(var i=0;i<TBPlayerAarr.length;i++){
							var sub = TBPlayerAarr[i].split("-");
							tbhtmlA += '<li>'+sub[1]+'<b>'+sub[0]+'</b></li>';
						}
						$("#tbmd .dzxqList ul:eq(0)").html(tbhtmlA)
					}else{
						$("#tbmd .dzxqList ul:eq(0)").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>")
						//$("#tbmd .dzxqList ul:eq(0)").hide();
						//$("#tbmd .dzxqList ul:eq(0)").prev().hide()
					}
					
					if(TBPlayerB){
						var TBPlayerBarr = TBPlayerB.split(",");
						for(var i=0;i<TBPlayerBarr.length;i++){
							var sub = TBPlayerBarr[i].split("-");
							tbhtmlB += '<li><em>'+sub[0]+'</em>'+sub[1]+'</li>';
						}
						$("#tbmd .dzxqList ul:eq(1)").html(tbhtmlB)
					}else{
						$("#tbmd .dzxqList ul:eq(1)").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>")
						//$("#tbmd .dzxqList ul:eq(1)").hide();
						//$("#tbmd").hide();
					}
					if((!TBPlayerA) && (!TBPlayerB)) //若两方均无数据，隐藏
						$("#tbmd").hide();		
					
				}
			})
		},
		
		//技术统计
		jstj:function(){
			//var html="";
			$.ajax({
				url:'/zlk/jsbf/jc/oneroundjstjdata/'+XX.itemid+'.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var rows = $(xml).find("rows");
					var row = $(xml).find("row");
					if(row){
						var shootNum__A = $(row).attr("shootNum__A");//主队射门次数
						var shootNum__B = $(row).attr("shootNum__B");//客队射门次数
						var shotsonGoal__A = row.attr("shotsonGoal__A");//主队射正球门次数
						var shotsonGoal__B = row.attr("shotsonGoal__B");//客队射正球门次数
						var foulNum__A = row.attr("foulNum__A");//主队射门次数
						var foulNum__B = row.attr("foulNum__B");//主队射门次数
						var cornerkickNum__A = row.attr("cornerkickNum__A");//主队射门次数
						var cornerkickNum__B = row.attr("cornerkickNum__B");//主队射门次数
						var offsideNum__A = row.attr("offsideNum__A");//主队射门次数
						var offsideNum__B = row.attr("offsideNum__B");//主队射门次数
						var yellowCardNum__A = row.attr("yellowCardNum__A");//主队射门次数
						var yellowCardNum__B = row.attr("yellowCardNum__B");//主队射门次数
						var redCardNum__A = row.attr("redCardNum__A");//主队射门次数
						var redCardNum__B = row.attr("redCardNum__B");//主队射门次数
						var saves__A = row.attr("saves__A");//主队射门次数
						var saves__B = row.attr("saves__B");//主队射门次数
						var list = $("#jstj").find("li");
						$(list).eq(0).find("span:eq(0)").html(shootNum__A)
						$(list).eq(0).find("span:eq(1)").html(shootNum__B)
						$(list).eq(1).find("span:eq(0)").html(shotsonGoal__A)
						$(list).eq(1).find("span:eq(1)").html(shotsonGoal__B)
						$(list).eq(2).find("span:eq(0)").html(foulNum__A)
						$(list).eq(2).find("span:eq(1)").html(foulNum__B)
						$(list).eq(3).find("span:eq(0)").html(cornerkickNum__A)
						$(list).eq(3).find("span:eq(1)").html(cornerkickNum__B)
						$(list).eq(4).find("span:eq(0)").html(offsideNum__A)
						$(list).eq(4).find("span:eq(1)").html(offsideNum__B)
						$(list).eq(5).find("span:eq(0)").html(redCardNum__A)
						$(list).eq(5).find("span:eq(1)").html(redCardNum__B)
						$(list).eq(6).find("span:eq(0)").html(yellowCardNum__A)
						$(list).eq(6).find("span:eq(1)").html(yellowCardNum__B)
						$(list).eq(7).find("span:eq(0)").html(saves__A)
						$(list).eq(7).find("span:eq(1)").html(saves__B)
					}else{
						var list = $("#jstj").find("li");
						$(list).eq(0).find("span:eq(0)").html(0)
						$(list).eq(0).find("span:eq(1)").html(0)
						$(list).eq(1).find("span:eq(0)").html(0)
						$(list).eq(1).find("span:eq(0)").html(0)
						$(list).eq(2).find("span:eq(0)").html(0)
						$(list).eq(2).find("span:eq(1)").html(0)
						$(list).eq(3).find("span:eq(0)").html(0)
						$(list).eq(3).find("span:eq(1)").html(0)
						$(list).eq(4).find("span:eq(0)").html(0)
						$(list).eq(4).find("span:eq(1)").html(0)
						$(list).eq(5).find("span:eq(0)").html(0)
						$(list).eq(5).find("span:eq(1)").html(0)
						$(list).eq(6).find("span:eq(0)").html(0)
						$(list).eq(6).find("span:eq(1)").html(0)
						$(list).eq(7).find("span:eq(0)").html(0)
						$(list).eq(7).find("span:eq(1)").html(0)
					}
					
				}
			})
		},
		//战绩信息
		zj:function(){
			XX.lsjf();
		},
		//历史交锋
		lsjf:function(){
			var lsjfhtml="";
			var htmlA=$("#zdzj").html();
			var htmlB=$("#kdzj").html();
			var snum=0;
			var fnum=0;
			var pnum=0;
			
			var zsnum=0;
			var psnum=0;
			var zfnum=0
			
			var ksnum=0;
			var kfnum=0;
			var kpnum=0;
			
			var kksnum=0;
			var kkpnum=0;
			var kkfnum=0;
			$.ajax({
				url:'/zlk/jsbf/jc/zjdata/'+XX.itemid+'.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var rows = $(xml).find("rows");
					var hidAndName = rows.attr("hidAndName");
					var gidAndName = rows.attr("gidAndName");
					var hname = hidAndName.split("-")[1];
					var gname = gidAndName.split("-")[1];
					var row = rows.find("row");
					var vsrow = rows.find("vsrow");
					//历史交锋
					if(vsrow.length){
						vsrow.each(function(){
							var ln = $(this).attr("ln");//交锋的赛事名称
							var time = $(this).attr("time");//历史交锋时间
							if(time.length==19)
							time = time.substring(0,10);
							var hn = $(this).attr("hn");//主队名称
							var gn = $(this).attr("gn");//客队名称
							var hsc = $(this).attr("hsc");//主队进球数
							var asc = $(this).attr("asc");//客队进球数
							
							lsjfhtml += '<li><b>'+time+'</b><span>'+hn+'</span><em>'+hsc+':'+asc+'</em><span>'+gn+'</span></li>';
						})
						$("#lsjf").html(lsjfhtml);
					}
					else{
						$("#zj div:eq(0)").hide();
					}
					
					var c="";
					row.each(function(){
						var hn = $(this).attr("hn");
						var gn = $(this).attr("gn");
						var hsc = $(this).attr("hsc");
						var asc = $(this).attr("asc");
						var ln = $(this).attr("ln");
						var time = $(this).attr("time")
						if(time.length==19)
							time = time.substring(0,10);
						var sf="";
						
						/***
						if(hsc>asc){
							sf="主胜";
							c="red";
						}else if(hsc<asc){
							sf="主负";
							c="green2"
						}else{
							sf="平";
							c=""
						}
						***/
						//主队近期战绩
						if(hn==hname || gn==hname){
							if(hsc==asc){
								pnum++;
							}
							if(hn==hname){
								if(hsc>asc){
									snum++;
									zsnum++;
									sf="胜";
									c="red";
								}else if(hsc<asc){
									fnum++;
									zfnum++
									sf="负";
									c="green2";
								}else if(hsc==asc){
									psnum++
									sf="平";
									c=""
								}
								htmlA+='<li><b><cite>'+ln+'</cite>'+time+'</b><span class="red">'+hn.substring(0,6)+'</span><em>'+hsc+':'+asc+'</em><span class="">'+gn.substring(0,6)+'</span><em class='+c+'>'+sf+'</em></li>';
							}else if(gn==hname){
								if(hsc<asc){
									snum++;
									sf="胜";
									c="red";
								}else if(hsc>asc){
									fnum++;
									sf="负";
									c="green2";
								}else{
									sf="平";
									c=""
								}
								htmlA+='<li><b><cite>'+ln+'</cite>'+time+'</b><span class="">'+hn.substring(0,6)+'</span><em>'+hsc+':'+asc+'</em><span class="red">'+gn.substring(0,6)+'</span><em class='+c+'>'+sf+'</em></li>';
							}
						};
						
						
						//客队近期战绩
						if(hn==gname || gn==gname){
							if(hsc==asc){
								kpnum++;
							}
							if(hn==gname){
								if(hsc>asc){
									ksnum++;
									//kksnum++;
									sf="胜";
									c="red";
								}else if(hsc<asc){
									kfnum++;
									sf="负";
									c="green2";
								}else if(hsc==asc){
									kkpnum++;
									sf="平";
									c=""
								}
								htmlB+='<li><b><cite>'+ln+'</cite>'+time+'</b><span class="blue">'+hn.substring(0,6)+'</span><em>'+hsc+':'+asc+'</em><span class="">'+gn.substring(0,6)+'</span><em class='+c+'>'+sf+'</em></li>';
							}else if(gn==gname){
								if(hsc<asc){
									ksnum++;
									kksnum++;
									sf="胜";
									c="red";
								}else if(hsc>asc){
									kfnum++;
									kkfnum++;
									sf="负";
									c="green2";
								}else{
									sf="平";
									c="";
								}
								htmlB+='<li><b><cite>'+ln+'</cite>'+time+'</b><span class="">'+hn.substring(0,6)+'</span><em>'+hsc+':'+asc+'</em><span class="blue">'+gn.substring(0,6)+'</span><em class='+c+'>'+sf+'</em></li>';
							}
						}
						
					});
					$("#zzjxq").html('<span class="red">'+hname+'</span>胜<cite class="red">'+snum+'</cite>平'+pnum+'负<cite class="green">'+fnum+'</cite>'+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;主场:胜<cite class='red'>"+zsnum+"</cite>平"+psnum+"负<cite class='blue'>"+zfnum+"</cite>");
					$("#kzjxq").html('<span class="blue">'+gname+'</span>胜<cite class="red">'+ksnum+'</cite>平'+kpnum+'负<cite class="green">'+kfnum+'</cite>'+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;客场:胜<cite class='red'>"+kksnum+"</cite>平"+kkpnum+"负<cite class='blue'>"+kkfnum+"</cite>");
					$("#zdzj").html(htmlA);
					$("#kdzj").html(htmlB);
				}
			});
		},
		
		pl:function(){
			var html =$("#pl").html();
			$.ajax({
				url:'/zlk/jsbf/jc/oudata/'+XX.itemid+'.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var rows = $(xml).find("rows");
					var row = rows.find("row");
					if(row.length>0){
						html+='<div>';
						html+='<ul class="plspf clearfix">';
						 html+='<li>&nbsp;</li>';
			             html+='<li>胜</li>';
			             html+='<li>平</li>';
			             html+='<li>负</li>';
			            html+='</ul>';
						row.each(function(){
							var company = $(this).attr("company");
							var old__p1 = parseFloat($(this).attr("old__p1"));
							var old__p2 = parseFloat($(this).attr("old__p2"));
							var old__p3 = parseFloat($(this).attr("old__p3"));
							var new__p1 = parseFloat($(this).attr("new__p1"));
							var new__p2 = parseFloat($(this).attr("new__p2"));
							var new__p3 = parseFloat($(this).attr("new__p3"));
							html+='<ul class="plxq clearfix">'
							html+='<li><span>'+company+'</span><em company="'+company+'">[详]</em></li>'
							html+='<li>'
							html+='<ul>'
							html+='<li>初陪</li>'
							html+='<li>'+old__p1+'</li>'
							html+='<li>'+old__p2+'</li>'
							html+='<li>'+old__p3+'</li>'
							html+='</ul>'
							html+='<ul>'
							html+='<li>即陪</li>'
							html+=' <li class="'+XX.disFlagClass(new__p1,old__p1)+'">'+new__p1+XX.disFlag(old__p1,new__p1)+'</li>'
							html+='<li class="'+XX.disFlagClass(new__p2,old__p2)+'">'+new__p2+XX.disFlag(old__p2,new__p2)+'</li>'
							html+='<li class="'+XX.disFlagClass(new__p3,old__p3)+'">'+new__p3+XX.disFlag(old__p3,new__p3)+'</li>'
							html+='</ul>'
							html+='</li>'
							html+='</ul>'
						})
						html+='</div>';
						$("#pl").html(html);
						
						$(".up").bind("click",function(){
							$(this).toggleClass("down");
							$(this).parent().next().toggle();
						});
					}else{
						$("#pl").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>");
					}
					
					
					$("#pl ul li em").bind("click",function(){
						var html="";
						var comp = $(this).attr("company");
						var v = XX.getValue(comp);
						$.ajax({
							url:'/zlk/jsbf/jc/odds/'+XX.qc+'/OP/'+XX.itemid+'/'+XX.itemid+'_'+v+'.xml',
							type:'GET',
							DataType:'XML',
							success: function(xml){
								var Rows = $(xml).find("Rows");
								var row = Rows.find("row");
								var len = row.length;
								for(var i=len-1;i>=0;i--){
									var p1 = $(row[i]).attr("p1");
									var p2 = $(row[i]).attr("p2");
									var p3 = $(row[i]).attr("p3");
									var time = $(row[i]).attr("time");
									var oldp1 = $(row[i+1]).attr("p1");
									var oldp2 = $(row[i+1]).attr("p2");
									var oldp3 = $(row[i+1]).attr("p3");
									/**
									var t = new Date(time);
									var m = t.getMonth()+1;
									if(m<10){
										m="0"+m;
									}
									var d = t.getDate();
									if(d<10){
										d="0"+d;
									}
									var h = t.getHours();
									var minutes = t.getMinutes();
									var tmp = m+"-"+d+" "+h+":"+minutes;
									***/
									var tmp = time.substring(5,16)
									html+='<li><span>'+tmp+'</span><span class="'+XX.disFlagClass(p1,oldp1)+'">'+p1+XX.disFlag(oldp1,p1)+'</span><span class="'+XX.disFlagClass(p2,oldp2)+'">'+p2+XX.disFlag(oldp2,p2)+'</span><span class="'+XX.disFlagClass(p3,oldp3)+'">'+p3+XX.disFlag(oldp3,p3)+'</span></li>';
								}
								$(".zfPop div.jsbfTktt span").html(comp);
								$(".zfPop ul.jsbfTklist").html(html)
								$(".zfPop ul.jsbfTklist li:first span:eq(0)").html("初赔");
								var t = $(".jsbfTklist").html();
								if(!t){
									D.tx("暂无赔率变化");
									$(".zfPop").hide();
									$(".zhezhao").hide();
								}else{
									$(".zfPop").show();
									$(".zhezhao").show();
								}
								
							}
						});
					})
					
				}
			})
		},
		disFlag:function(old__p1,new__p1){
			var flag1="";
			if(old__p1>new__p1){
				flag1="&darr;";
			}else if(old__p1<new__p1){
				flag1="&uarr;";
			}else{
				flag1="";
			}
			return flag1;
		},
		disFlagClass:function(old__p1,new__p1){
			var c="";
			if(old__p1>new__p1){
				//flag1="&darr;";
				c="red"
			}else if(old__p1<new__p1){
				//flag1="&uarr;";
				c="green2"
			}else if(old__p1==new__p1){
				c="";
			}
			return c;
		},
		MainCPMap:[["威廉希尔",1],["立博",2],["澳门",3],["Bet365",4],["bwin",5],["伟德",6],["Interwetten",7],["SANI",8],["易博胜",9],["皇冠",10],["利记",11],["Oddset",12],["10BET",13],["Coral",14]],
		getValue:function(n){
			var t = '';
			t = {'威廉希尔':'1',
					'立博':'2',
					'澳门':'3',
					'Bet365':'4',
					'bet 365':'4',
					'bwin':'5',
					'BWin':'5',
					'伟德':'6',
					'interwetten':'7',
					'Interwetten':'7',
					'sani':'8',
					'SNAI':'8',
					'易博胜':'9',
					'易胜博':'9',
					'皇冠':'10',
					'利记':'11',
					'Oddset':'12',
					'10BET':'13',
					'Coral':'14'
			}[n];
			return t;
		}
}