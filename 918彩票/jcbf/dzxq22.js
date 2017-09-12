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
			
		},
		//绑定事件
		bindEvent:function(){
			var l = $('.downline').offset().left;
			$('.jsbfTab li').click(function(){
				var liindex = $(this).index();//获取当前li的索引值
				$(this).addClass('cur').siblings().removeClass('cur');
				var liWidth = $(this).width();//获取当前li的宽度
				$('.downline').stop(false,true).animate({'left' : liindex * liWidth+l+ 'px'},300);
				
				$('#content>article').hide();
				$('#content>article:eq('+$(this).index()+')').show();
			});
			
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
			
			$("#opl div.pdTop1 ul li").bind("click",function(){
				var index = $(this).index();
				$(this).addClass("cur");
				$(this).siblings().removeClass("cur");
				$("#ocont div.sjlist:eq('"+index+"')").show();
				$("#ocont div.sjlist:eq('"+index+"')").siblings().hide();
			});
			
			$("#ypl div.pdTop1 ul li").bind("click",function(){
				var index = $(this).index();
				$(this).addClass("cur");
				$(this).siblings().removeClass("cur");
				$("#ycont div.sjlist:eq('"+index+"')").show();
				$("#ycont div.sjlist:eq('"+index+"')").siblings().hide();
			});
			
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
									$(".dzxqBf ul li:eq(1)").find("cite").html(st);
								}
							});
						},1000)
						
					}else if(type==2){
						st = "中";
						$(".dzxqBf ul li:eq(1)").find("cite").html(st);
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
									$(".dzxqBf ul li:eq(1)").find("cite").html(st);
								}
							});
						},1000)
						//st = 45+parseInt((serverTime-htime)/60000);
					}
					
					
					
					$(".dzxqBf ul li:eq(0)").html('<span>'+hn+'</span><cite>(主)</cite>');
					//$(".dzxqBf ul li:eq(1)").html(str);
					$(".dzxqBf ul li:eq(2)").html('<span>'+gn+'</span><cite>(客)</cite>');
					//$(".dzxqBf ul").next("p").html(T+"开赛");
					
					if(type==17){
						$(".dzxqBf ul li:eq(1) span").html(str);
						$(".dzxqBf ul li:eq(1)").find("cite").html("未开赛");
						//$(".dzxqBf ul").next("p").find("img").hide();
						//$(".dzxqBf ul").next("p").show();
					}else if(type==4){
						$(".dzxqBf ul li:eq(1) span").html(str);
						$(".dzxqBf ul li:eq(1)").find("cite").html("已完赛");
						//$(".dzxqBf ul").next("p").find("img").hide();
						//$(".dzxqBf ul").next("p").show();
					}else if(type==1 || type==2 || type==3){
						if(type==2){
							$(".dzxqBf ul").next("p").find("img").hide();
						}
						$(".dzxqBf ul li:eq(1) span").html(str);
						//$(".dzxqBf ul").next("p").html(st);
						$(".dzxqBf ul").next("p").show();
					}
				}
			});
		},
		loadCont:function(){
			XX.ss();
			XX.zj();
			XX.opl();
			XX.ypl();
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
							html+='<p class="top">0&prime;</p>'
							
							row.each(function(){
								var pn = $(this).attr("pn");//球员名字
								var time = $(this).attr("time");//进球时间
								var eventType = $(this).attr("eventType");//时间类型
								var teamType = $(this).attr("teamType");//0主队，-1客队
								if(teamType==0){//主队
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
									}else if(eventType==6){//换人，都好分割的字符串,第一位换上,第二位换下
										var xpn = pn.split(",")[0];
										var spn = pn.split(",")[1];
										html+='<div class="timeleft timetwo"><span><strong>'+xpn+'<i>&darr;</i></strong><strong>'+spn+'<i>&uarr;</i></strong></span><b>'+time+'&prime;</b></div>';
									}
								}else{//客队
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
									}else if(eventType==6){
										var xpn = pn.split(",")[0];
										var spn = pn.split(",")[1];
										html+='<div class="timeright timetwo timetwo2"><b>'+time+'&prime;</b><span><strong><i>&darr;</i>'+xpn+'</strong><strong><i>&uarr;</i>'+spn+'</strong></span></div>'
									}
								}
							})
							if(XX.type==17){
								html+='<p class="timeIco">已完赛</p>';
							}else if(XX.type==1 || XX.type==2 || XX.type==3){
								html+="";
							}else if(XX.type==4){
								html+='<p class="timeIco">已完赛</p>';
							}
							
							$("#bssj").html(html);
					}else{
						$("#bssj").parents("div").hide();
						$("#bssj").parents("div").next().hide();
					}
				}
			})
		},
		//伤员名单
		symd:function(){
			var syhtmlA="";
			var syhtmlB="";
			var sfhtmlA=$("#sfmd ul:eq(0)").html();;
			var sfhtmlB=$("#sfmd ul:eq(1)").html();
			var tbhtmlA=$("#tbmd ul:eq(0)").html();
			var tbhtmlB=$("#tbmd ul:eq(1)").html();
			
			var tvlivehtml = "";
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
					
					var tvlive = row.attr("tvlive");//直播源
					
					
					//加载直播源信息
					if(tvlive){
						var objtvlive = JSON.parse(tvlive);
						for(var i=0;i<objtvlive.length;i++){
							var liveFrom = objtvlive[i]["liveFrom"];//视频来源
							var liveUrl = objtvlive[i]["liveUrl"];//视频地址
							var zbURL = objtvlive[i]["liveUrl"];//视频地址
							
							var zburl = "";
							
							if(type==1 || type==2 || type==3){
								zburl=liveUrl;
							}else if(type==17){
								zburl=zbURL;
							}
							
							tvlivehtml += '<a href="'+zburl+'">'
							tvlivehtml += '<dl><dt></dt><dd>'+liveFrom+'</dd></dl>'
							tvlivehtml += '<i class="rightArrow"></i>'
							tvlivehtml += '</a>'
						}
						tvlivehtml+='<p>仅提供视频的网站地址链接点击，版权归视频网站所有。</p>';
						$("#zbcont").html(tvlivehtml);
					}else{
						$("#zbcont").html("暂无数据")
					}
					
					//伤员
					
					//首发
					if(SFPlayerA){
						var SFPlayerAarr = SFPlayerA.split(",");
						for(var i=0;i<SFPlayerAarr.length;i++){
							var sub = SFPlayerAarr[i].split("-");
							
							var zwz = sub[1].substring(sub[1].indexOf("(")+1,sub[1].indexOf(")"));
							
							var zxm = sub[1].substring(0,sub[1].indexOf("("));
							
							
							var zhm = sub[0]
							
							sfhtmlA += '<li><em>'+zwz+'</em><cite>'+zhm+'  '+zxm+'</cite></li>';
						}
						$("#sfmd ul:eq(0)").html(sfhtmlA)
					}else{
						$("#sfmd ul:eq(0)").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>")
						//$("#sfmd .dzxqList ul:eq(0)").hide();
						//$("#sfmd .dzxqList ul:eq(0)").prev().hide();
					}
					
					if(SFPlayerB){
						var SFPlayerBarr = SFPlayerB.split(",");
						for(var i=0;i<SFPlayerBarr.length;i++){
							var sub = SFPlayerBarr[i].split("-");
							
							var kwz = sub[1].substring(sub[1].indexOf("(")+1,sub[1].indexOf(")"));
							
							var kxm = sub[1].substring(0,sub[1].indexOf("("));
							
							
							var khm = sub[0]
							
							sfhtmlB += '<li><em>'+kwz+'</em><cite>'+khm+'  '+kxm+'</cite></li>';
						}
						$("#sfmd ul:eq(1)").html(sfhtmlB)
					}else{
						$("#sfmd ul:eq(1)").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>")
						//$("#sfmd .dzxqList ul:eq(1)").hide();
						//$("#sfmd").hide();
					}					
					if((!SFPlayerA) && (!SFPlayerB)){
						$("#sfmd").hide();	
						//$("#sfmd").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>")
						//$("#sfmd").parent().prev().hide();
					} //若两方均无数据，隐藏
					
					//替补
					if(TBPlayerA){
						var TBPlayerAarr = TBPlayerA.split(",");
						for(var i=0;i<TBPlayerAarr.length;i++){
							var sub = TBPlayerAarr[i].split("-");
							
							var zwz = sub[1].substring(sub[1].indexOf("(")+1,sub[1].indexOf(")"));
							
							var zxm = sub[1].substring(0,sub[1].indexOf("("));
							
							
							var zhm = sub[0]
							
							tbhtmlA += '<li><em>'+zwz+'</em><cite>'+zhm+'  '+zxm+'</cite></li>';
						}
						$("#tbmd ul:eq(0)").html(tbhtmlA)
					}else{
						$("#tbmd ul:eq(0)").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>")
						//$("#tbmd .dzxqList ul:eq(0)").hide();
						//$("#tbmd .dzxqList ul:eq(0)").prev().hide()
					}
					
					if(TBPlayerB){
						var TBPlayerBarr = TBPlayerB.split(",");
						for(var i=0;i<TBPlayerBarr.length;i++){
							var sub = TBPlayerBarr[i].split("-");
							var zwz = sub[1].substring(sub[1].indexOf("(")+1,sub[1].indexOf(")"));
							
							var zxm = sub[1].substring(0,sub[1].indexOf("("));
							
							
							var zhm = sub[0]
							
							tbhtmlB += '<li><em>'+zwz+'</em><cite>'+zhm+'  '+zxm+'</cite></li>';
						}
						$("#tbmd ul:eq(1)").html(tbhtmlB)
					}else{
						$("#tbmd ul:eq(1)").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>")
						//$("#tbmd .dzxqList ul:eq(1)").hide();
						//$("#tbmd").hide();
					}
					if((!TBPlayerA) && (!TBPlayerB)){
						//$("#tbmd").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>")
						$("#tbmd").hide();		
						//$("#tbmd").parent().prev().hide();	
					}
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
						//获取li标签下span的宽度
						var liWidth = $("#jstj").eq(0).find("span:eq(0)").width();
						var shootNum__A = $(row).attr("shootNum__A");//主队射门次数
						var shootNum__B = $(row).attr("shootNum__B");//客队射门次数
						
						/***
						var zcwd = (parseInt(shootNum__A)/(parseInt(shootNum__A + shootNum__B)))*liWidth;
						var kcwd = (parseInt(shootNum__B)/(parseInt(shootNum__A + shootNum__B)))*liWidth;
						
						
						$(list).eq(0).find("span:eq(0) cite").width(zcwd)
						$("#jstj").eq(0).find("span:eq(0)").addClass("cur");
						$(list).eq(0).find("span:eq(1) cite").width(kcwd)
						$("#jstj").eq(0).find("span:eq(1)").addClass("cur");
						***/
						
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
						$(list).eq(0).find("span:eq(0) cite").html(shootNum__A)
						$(list).eq(0).find("span:eq(1) cite").html(shootNum__B)
						$(list).eq(1).find("span:eq(0) cite").html(shotsonGoal__A)
						$(list).eq(1).find("span:eq(1) cite").html(shotsonGoal__B)
						$(list).eq(2).find("span:eq(0) cite").html(foulNum__A)
						$(list).eq(2).find("span:eq(1) cite").html(foulNum__B)
						$(list).eq(3).find("span:eq(0) cite").html(cornerkickNum__A)
						$(list).eq(3).find("span:eq(1) cite").html(cornerkickNum__B)
						$(list).eq(4).find("span:eq(0) cite").html(offsideNum__A)
						$(list).eq(4).find("span:eq(1) cite").html(offsideNum__B)
						$(list).eq(5).find("span:eq(0) cite").html(redCardNum__A)
						$(list).eq(5).find("span:eq(1) cite").html(redCardNum__B)
						$(list).eq(6).find("span:eq(0) cite").html(yellowCardNum__A)
						$(list).eq(6).find("span:eq(1) cite").html(yellowCardNum__B)
						$(list).eq(7).find("span:eq(0) cite").html(saves__A)
						$(list).eq(7).find("span:eq(1) cite").html(saves__B)
					}else{
						var list = $("#jstj").find("li");
						$(list).eq(0).find("span:eq(0) cite").html(0)
						$(list).eq(0).find("span:eq(1) cite").html(0)
						$(list).eq(1).find("span:eq(0) cite").html(0)
						$(list).eq(1).find("span:eq(0) cite").html(0)
						$(list).eq(2).find("span:eq(0) cite").html(0)
						$(list).eq(2).find("span:eq(1) cite").html(0)
						$(list).eq(3).find("span:eq(0) cite").html(0)
						$(list).eq(3).find("span:eq(1) cite").html(0)
						$(list).eq(4).find("span:eq(0) cite").html(0)
						$(list).eq(4).find("span:eq(1) cite").html(0)
						$(list).eq(5).find("span:eq(0) cite").html(0)
						$(list).eq(5).find("span:eq(1) cite").html(0)
						$(list).eq(6).find("span:eq(0) cite").html(0)
						$(list).eq(6).find("span:eq(1) cite").html(0)
						$(list).eq(7).find("span:eq(0) cite").html(0)
						$(list).eq(7).find("span:eq(1) cite").html(0)
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
			var jfpmhtml="";
			var zlsjfhtml=$("#zList").html();//主队
			var klsjfhtml=$("#kList").html();//客队
			var htmlA=$("#zdzj").html();
			var htmlB=$("#kdzj").html();
			
			var zwlschtml=$("#zwlsc").html();
			var kwlschtml=$("#kwlsc").html();
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
					var vsrow = rows.find("vsrow");//交锋节点
					var Comming = rows.find("Comming");//赛程节点
					var Creditinfo = rows.find("Creditinfo");//积分排名节点
					
					//积分排名
					
					if(Creditinfo.length){
						Creditinfo.each(function(){
							var teamname = $(this).attr("teamname")//球队名称
							var teamId = $(this).attr("teamId");//球队ID
							var rank = $(this).attr("rank");//积分排名
							var points = $(this).attr("points");//当前积分
							var all = $(this).attr("all");//
							var host = $(this).attr("host");
							var guest = $(this).attr("guest");
							
							
							var allArr = all.split(",");
							var hostArr = host.split(",");
							var guestArr = guest.split(",");//27,12,9,6,39,29,10,45,5
							
							jfpmhtml += '<p>'+teamname+'&nbsp;&nbsp;&nbsp;联赛排名'+rank+'&nbsp;&nbsp;&nbsp;总积分'+points+'</p>'
							jfpmhtml += '<ul id="jfpmCont">'
							jfpmhtml += '<li>'
							jfpmhtml += '<span class="jsbflong">主客</span>'
							jfpmhtml += '<span>赛</span>'
							jfpmhtml += '<span>胜</span>'
							jfpmhtml += '<span>平</span>'
							jfpmhtml += '<span>负</span>'
							jfpmhtml += '<span>进</span>'
							jfpmhtml += '<span>失</span>'
							jfpmhtml += '<span>净</span>'
							jfpmhtml += '<span class="jsbflong">积分</span>'
							jfpmhtml += '<span class="jsbflong">排名</span>'
							jfpmhtml += '</li>'
					        
							jfpmhtml += '<li>'
							jfpmhtml += '<span class="jsbflong">全部</span>'
							jfpmhtml += '<span>'+allArr[0]+'</span>'
							jfpmhtml += '<span>'+allArr[1]+'</span>'
							jfpmhtml += '<span>'+allArr[2]+'</span>'
							jfpmhtml += '<span>'+allArr[3]+'</span>'
							jfpmhtml += '<span>'+allArr[4]+'</span>'
							jfpmhtml += '<span>'+allArr[5]+'</span>'
							jfpmhtml += '<span>'+allArr[6]+'</span>'
							jfpmhtml += '<span class="jsbflong">'+allArr[7]+'</span>'
							jfpmhtml += '<span class="jsbflong">'+allArr[8]+'</span>'
							jfpmhtml += '</li>'
							jfpmhtml += '<li>'
								
							jfpmhtml += '<span class="jsbflong">主场</span>'
							jfpmhtml += '<span>'+hostArr[0]+'</span>'
							jfpmhtml += '<span>'+hostArr[1]+'</span>'
							jfpmhtml += '<span>'+hostArr[2]+'</span>'
							jfpmhtml += '<span>'+hostArr[3]+'</span>'
							jfpmhtml += '<span>'+hostArr[4]+'</span>'
							jfpmhtml += '<span>'+hostArr[5]+'</span>'
							jfpmhtml += '<span>'+hostArr[6]+'</span>'
							jfpmhtml += '<span class="jsbflong">'+hostArr[7]+'</span>'
							jfpmhtml += '<span class="jsbflong">'+hostArr[8]+'</span>'
							jfpmhtml += '</li>'
							jfpmhtml += '<li>'
								
							jfpmhtml += '<span class="jsbflong">客场</span>'
							jfpmhtml += '<span>'+guestArr[0]+'</span>'
							jfpmhtml += '<span>'+guestArr[1]+'</span>'
							jfpmhtml += '<span>'+guestArr[2]+'</span>'
							jfpmhtml += '<span>'+guestArr[3]+'</span>'
							jfpmhtml += '<span>'+guestArr[4]+'</span>'
							jfpmhtml += '<span>'+guestArr[5]+'</span>'
							jfpmhtml += '<span>'+guestArr[6]+'</span>'
							jfpmhtml += '<span class="jsbflong">'+guestArr[7]+'</span>'
							jfpmhtml += '<span class="jsbflong">'+guestArr[8]+'</span>'
							jfpmhtml += '</li>'
							jfpmhtml += '</ul>'
						})
					}
					$("#jfpm").html(jfpmhtml);
					
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
							
							var flag = "";
							var cl=""
							if(hsc>asc){
								flag="主胜"
								cl="red"
							}else if(hsc<asc){
								flag="主负"
								cl="green";
							}else if(hsc==asc){
								flag="平"
								cl="blue"
							}
							if(hn==hname){
								zlsjfhtml += '<li><b><cite>'+ln+'</cite>'+time+'</b><span class="'+cl+'">'+hn+'</span><em>'+hsc+':'+asc+'</em><span>'+gn+'</span><em class="'+cl+'">'+flag+'</em></li>';	
							}else if(hn==gname){
								klsjfhtml +='<li><b><cite>'+ln+'</cite>'+time+'</b><span class="'+cl+'">'+hn+'</span><em>'+hsc+':'+asc+'</em><span>'+gn+'</span><em class="'+cl+'">'+flag+'</em></li>'
							}
							
							
							//主队近期战绩
							if(hn==hname){
								if(hsc==asc){
									pnum++;
								}
								if(hn==hname){
									if(hsc>asc){
										snum++;
										zsnum++;
									}else if(hsc<asc){
										fnum++;
										zfnum++
									}else if(hsc==asc){
										psnum++
									}
								}
							};
							
							//客队近期战绩
							if(hn==gname){
								if(hsc==asc){
									kpnum++;
								}
								if(hn==gname){
									if(hsc>asc){
										ksnum++;
										kksnum++;
									}else if(hsc<asc){
										kfnum++;
									}else if(hsc==asc){
										kkpnum++;
									}
								}
							}
							
						})
						//<span class="red">'+hname+'</span>胜<cite class="red">'+snum+'</cite>平'+pnum+'负<cite class="green">'+fnum+'</cite>'+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;主场:胜<cite class='red'>"+zsnum+"</cite>平"+psnum+"负<cite class='blue'>"+zfnum+"</cite>"
						$("#zList").prev("div").html('<p>'+hname+'<cite class="red pdLeft1">'+snum+'胜</cite><cite class="blue">'+pnum+'平</cite><cite class="green">'+fnum+'负</cite>，主场'+psnum+'平'+zfnum+'负</p>')
						$("#zList").html(zlsjfhtml);
						$("#kList").prev("div").html('<p>'+gname+'<cite class="red pdLeft1">'+ksnum+'胜</cite><cite class="blue">'+kpnum+'平</cite><cite class="green">'+kfnum+'负</cite>，主场'+kkpnum+'平'+kfnum+'负</p>')
						$("#kList").html(klsjfhtml);
					}
					else{
						//$("#zj div:eq(0)").hide();
						$("#lsjf").hide();
						$("#lsjf").next().hide();
					}
					
					
					//未来赛程
					if(Comming.length){
						Comming.each(function(){
							var match = $(this).attr("match");
							var time = $(this).attr("time");
							var teamId = $(this).attr("teamId");
							var host = $(this).attr("host");
							var guest = $(this).attr("guest");
							var teamHId = $(this).attr("teamHId");
							var teamAId = $(this).attr("teamAId");
							var later = $(this).attr("later");
							if(time.length==19)
							time = time.substring(0,10);
							
							if(hname==host){
								zwlschtml+='<li><b><cite>'+match+'</cite>'+time+'</b><span class="cur">'+host+'</span><span>'+guest+'</span><em>'+later+'</em></li>'
							}else if(hname==guest){
								zwlschtml+='<li><b><cite>'+match+'</cite>'+time+'</b><span>'+host+'</span><span class="cur">'+guest+'</span><em>'+later+'</em></li>'
							}
							
							if(gname==host){
								kwlschtml+='<li><b><cite>'+match+'</cite>'+time+'</b><span class="cur">'+host+'</span><span>'+guest+'</span><em>'+later+'</em></li>'
							}else if(gname==guest){
								kwlschtml+='<li><b><cite>'+match+'</cite>'+time+'</b><span>'+host+'</span><span class="cur">'+guest+'</span><em>'+later+'</em></li>'
							}
						})
						
						$("#zwlsc").html(zwlschtml);
						$("#zwlsc").prev().html("主队："+hname)
						$("#kwlsc").html(kwlschtml);
						$("#kwlsc").prev().html("客队："+gname)
					}
					
				}
			});
		},
		
		opl:function(){
			var zxplhtml=""
			var zxzshtml=""
			var zxglhtml=""
				
			var cpyidObj={};
			$.ajax({
				url:'/zlk/jsbf/jc/oudata/'+XX.itemid+'.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var rows = $(xml).find("rows");
					var row = rows.find("row");//赔率节点
					var klzsrow = rows.find("klzsrow");//凯利指数节点
					var slrow = rows.find("slrow");//概率节点
					
					//赔率
					if(row.length>0){
						row.each(function(){
							var company = $(this).attr("company");//公司名称
							var cpyid = $(this).attr("cpyid");
							var old__p1 = $(this).attr("old__p1");
							var old__p2 = $(this).attr("old__p2");
							var old__p3 = $(this).attr("old__p3");
							var new__p1 = $(this).attr("new__p1");
							var new__p2 = $(this).attr("new__p2");
							var new__p3 = $(this).attr("new__p3");
							var return__rate = $(this).attr("return__rate");
							
							cpyidObj[cpyid]=company
							
							zxplhtml += '<ul cpyid="'+cpyid+'" qc="'+qc+'" itemid="'+itemid+'">'
							zxplhtml += '<li>'+company+'</li>'
							zxplhtml += '<li><span>'+old__p1+'</span><span>'+old__p2+'</span><span>'+old__p3+'</span></li>'
							zxplhtml += '<li><span class="'+XX.disFlagClass(old__p1, new__p1)+'">'+new__p1+''+XX.disFlag(old__p1, new__p1)+'</span><span class="'+XX.disFlagClass(old__p2, new__p2)+'">'+new__p2+''+XX.disFlag(old__p2, new__p2)+'</span><span class="'+XX.disFlagClass(old__p3,new__p3)+'">'+new__p3+''+XX.disFlag(old__p3, new__p3)+'</span></li>'
							zxplhtml += '<li>'+return__rate+'%</li>'
							zxplhtml += '</ul>'
							
						})
						
						$("#zxpl").html(zxplhtml);
					}else{
						$("#pl").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>");
					}
					
					//点击最新赔率的ul标签
					$("#zxpl ul").bind("click",function(){
						var id = $(this).attr("cpyid");
						window.location.href="/jcbf/pl.html?cpyid="+id;
						localStorage.setItem("cpyidObj",JSON.stringify(cpyidObj));
					})
					
					
					//凯利指数
					if(klzsrow.length){
						klzsrow.each(function(){
							var company=$(this).attr("company");
							var cpyid=$(this).attr("cpyid");
							var old__p1__klzs=$(this).attr("old__p1__klzs");
							var old__p2__klzs=$(this).attr("old__p2__klzs");
							var old__p3__klzs=$(this).attr("old__p3__klzs");
							var new__p1__klzs=$(this).attr("new__p1__klzs");
							var new__p2__klzs=$(this).attr("new__p2__klzs");
							var new__p3__klzs=$(this).attr("new__p3__klzs");
							var return__rate = $(this).attr("return__rate");
							zxzshtml += '<ul>'
							zxzshtml += '<li>'+company+'</li>'
							zxzshtml += '<li><span>'+old__p1__klzs+'</span><span>'+old__p2__klzs+'</span><span>'+old__p3__klzs+'</span></li>'
							zxzshtml += '<li><span class="'+XX.disFlagClass(old__p1__klzs, new__p1__klzs)+'">'+new__p1__klzs+''+XX.disFlag(old__p1__klzs, new__p1__klzs)+'</span><span class="'+XX.disFlagClass(old__p2__klzs, new__p2__klzs)+'">'+new__p2__klzs+''+XX.disFlag(old__p2__klzs, new__p2__klzs)+'</span><span class="'+XX.disFlagClass(old__p3__klzs,new__p3__klzs)+'">'+new__p3__klzs+''+XX.disFlag(old__p3__klzs,new__p3__klzs)+'</span></li>'
							zxzshtml += '<li>'+return__rate+'%</li>'
							zxzshtml += '</ul>'
						})
						$("#zxzs").html(zxzshtml);
					}else{
						
					}
					
					//概率
					if(slrow.length){
						slrow.each(function(){
							var company=$(this).attr("company");
							var cpyid=$(this).attr("cpyid");
							var old__p1__sl=$(this).attr("old__p1__sl");
							var old__p2__sl=$(this).attr("old__p2__sl");
							var old__p3__sl=$(this).attr("old__p3__sl");
							var new__p1__sl=$(this).attr("new__p1__sl");
							var new__p2__sl=$(this).attr("new__p2__sl");
							var new__p3__sl=$(this).attr("new__p3__sl");
							var return__rate = $(this).attr("return__rate");
							
							zxglhtml += '<ul>'
							zxglhtml += '<li>'+company+'</li>'
							zxglhtml += '<li><span>'+old__p1__sl+'</span><span>'+old__p2__sl+'</span><span>'+old__p3__sl+'</span></li>'
							zxglhtml += '<li><span class="'+XX.disFlagClass(old__p1__sl, new__p1__sl)+'">'+new__p1__sl+''+XX.disFlag(old__p1__sl, new__p1__sl)+'</span><span class="'+XX.disFlagClass(old__p2__sl, new__p2__sl)+'">'+new__p2__sl+''+XX.disFlag(old__p2__sl, new__p2__sl)+'</span><span class="'+XX.disFlagClass(old__p3__sl, new__p3__sl)+'">'+new__p3__sl+''+XX.disFlag(old__p3__sl, new__p3__sl)+'</span></li>'
							zxglhtml += '<li>'+return__rate+'%</li>'
							zxglhtml += '</ul>'
						})
						$("#zxgl").html(zxglhtml);
					}else{
						
					}
					
				}
			})
		},
		
		ypl:function(){
			var yzxplhtml=""
			var yzxzshtml=""
			var yzxglhtml=""
			$.ajax({
				url:'/zlk/jsbf/jc/yadata/'+XX.itemid+'.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					var rows = $(xml).find("rows");
					var row = rows.find("row");//赔率节点
					var klzsrow = rows.find("klzsrow");//凯利指数节点
					var slrow = rows.find("slrow");//概率节点
					
					//赔率
					if(row.length>0){
						row.each(function(){
							var company = $(this).attr("company");//公司名称
							var cpyid = $(this).attr("cpyid");
							var old__p1 = $(this).attr("old__p1");
							var old__p2 = $(this).attr("old__p2");
							var old__p3 = $(this).attr("old__p3");
							var new__p1 = $(this).attr("new__p1");
							var new__p2 = $(this).attr("new__p2");
							var new__p3 = $(this).attr("new__p3");
							var return__rate = $(this).attr("return__rate");
							
							
							
							yzxplhtml += '<ul>'
							yzxplhtml += '<li>'+company+'</li>'
							yzxplhtml += '<li><span>'+old__p1+'</span><span>'+old__p3+'</span><span>'+old__p2+'</span></li>'
							yzxplhtml += '<li><span class="'+XX.disFlagClass(old__p1, new__p1)+'">'+new__p1+''+XX.disFlag(old__p1, new__p1)+'</span><span class="">'+new__p3+'</span><span class="'+XX.disFlagClass(old__p2, new__p2)+'">'+new__p2+''+XX.disFlag(old__p2, new__p2)+'</span></li>'
							yzxplhtml += '<li>'+return__rate+'%</li>'
							yzxplhtml += '</ul>'
							
						})
						
						$("#yzxpl").html(yzxplhtml);
					}else{
						$("#pl").html("<div style='text-align:center;height:100px;padding-top:50px;'>暂无数据</div>");
					}
					
					
					//凯利指数
					if(klzsrow.length){
						klzsrow.each(function(){
							var company=$(this).attr("company");
							var cpyid=$(this).attr("cpyid");
							var old__p1__klzs=$(this).attr("old__p1__klzs");
							var old__p2__klzs=$(this).attr("old__p2__klzs");
							var old__p3__klzs=$(this).attr("old__p3__klzs");
							var new__p1__klzs=$(this).attr("new__p1__klzs");
							var new__p2__klzs=$(this).attr("new__p2__klzs");
							var new__p3__klzs=$(this).attr("new__p3__klzs");
							var return__rate = $(this).attr("return__rate");
							yzxzshtml += '<ul>'
							yzxzshtml += '<li>'+company+'</li>'
							yzxzshtml += '<li><span>'+old__p1__klzs+'</span><span>'+old__p2__klzs+'</span><span>'+old__p3__klzs+'</span></li>'
							yzxzshtml += '<li><span class="'+XX.disFlagClass(old__p1__klzs, new__p1__klzs)+'">'+new__p1__klzs+''+XX.disFlag(old__p1__klzs, new__p1__klzs)+'</span><span class="">'+new__p2__klzs+''+XX.disFlag(old__p2__klzs, new__p2__klzs)+'</span><span class="'+XX.disFlagClass(old__p2__klzs, new__p2__klzs)+'">'+new__p3__klzs+'</span></li>'
							yzxzshtml += '<li>'+return__rate+'%</li>'
							yzxzshtml += '</ul>'
						})
						$("#yzxzs").html(yzxzshtml);
					}else{
						
					}
					
					
					//概率
					if(slrow.length){
						slrow.each(function(){
							var company=$(this).attr("company");
							var cpyid=$(this).attr("cpyid");
							var old__p1__sl=$(this).attr("old__p1__sl");
							var old__p2__sl=$(this).attr("old__p2__sl");
							var old__p3__sl=$(this).attr("old__p3__sl");
							var new__p1__sl=$(this).attr("new__p1__sl");
							var new__p2__sl=$(this).attr("new__p2__sl");
							var new__p3__sl=$(this).attr("new__p3__sl");
							var return__rate = $(this).attr("return__rate");
							
								yzxglhtml += '<ul>'
								yzxglhtml += '<li>'+company+'</li>'
								yzxglhtml += '<li><span>'+old__p1__sl+'</span><span>'+old__p2__sl+'</span><span>'+old__p3__sl+'</span></li>'
								yzxglhtml += '<li><span class="">'+new__p1__sl+'</span><span class="">'+new__p2__sl+'</span><span class="">'+new__p3__sl+'</span></li>'
								yzxglhtml += '<li>'+return__rate+'%</li>'
								yzxglhtml += '</ul>'
						})
						$("#yzxgl").html(yzxglhtml);
					}else{
						
					}
				}
			})
		},
		disFlag:function(old__p1,new__p1){
			var flag1="";
			if(old__p1<new__p1){
				flag1="&uarr;";
			}else if(old__p1>new__p1){
				flag1="&darr;";
			}else{
				flag1="";
			}
			return flag1;
		},
		disFlagClass:function(old__p1,new__p1){
			var c="";
			if(old__p1<new__p1){
				//flag1="&darr;";
				c="red"
			}else if(old__p1>new__p1){
				//flag1="&uarr;";
				c="green"
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