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
$(function(){
	HH.init_();
	
	var from = location.search.getParam('from');
	from == 'app' && $('.header a:eq(0)').hide();
	function isWeiXin(){
	    var ua = window.navigator.userAgent.toLowerCase();
	    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
	        return true;
	    }else{
	        return false;
	    }
	}
	
	if(isWeiXin()){
		$("#share").show();
	}else{
		$("#share").hide();
	}
	
	//分享提示按钮
	$("#share").bind("click",function(){
		$(".show").show();
		$(".zhezhao").show();
	});
	
	//分享提示按钮
	$(".show").bind("click",function(){
		$(".show").hide();
		$(".zhezhao").hide();
	});
	
	//分享提示按钮
	$(".zhezhao").bind("click",function(){
		$(".show").hide();
		$(".zhezhao").hide();
	});
	
	try{
		_czc.push(['_trackEvent','旧版天天推球' ,'H5天天推球', '天天推球',1,'点击次数'])
	}catch(e){}	
});

var HH = {
		//初始化方法
		wdArr:[],
		init_:function(){
			var t = HH.setVal();
			$("#txtBirthday").val(t);
			this.getjcSpf();
			this.getMessage(t);//初始化加载第一个日期
			this.getHistoryDate();
			this.bind_();
		},
		//绑定各种事件
		bind_:function(){
			$('#command').on('touchend',function(){
				HH.showHistoryPeriod();
			});
			$("#fg").bind("click",function(){
				$('#listDate').hide();
			});
			$("#cont_").bind("click",function(){
				$('#listDate').hide();
			});
			$("#cont_ article.text section").bind("click",function(){
				$(this).parent().toggleClass("textHover");
			});
		},
		//临场推荐
		lctj:function(D){
			var lctjHTML = "";
			var obj = D.data || [];
			//data属性存在
			var count = D.count;
			var num1 = count.indexOf("平");
			var num2 = count.indexOf("返");
			var count1 = count.substring(0,num1);
			var count2 = count.substring(num2);
			count=count1+count2;
			if(count){
				$("#lctj section.title p").html(count)
			}
			
			if(obj && obj!=null){
				for(var i in obj){
					var teamA = obj[i].teamA;//主队名字
					teamA = teamA.substring(0,5)
					var teamB = obj[i].teamB;//客队名字
					teamB = teamB.substring(0,5)
					var time = obj[i].time;//时间
					var itemid = obj[i].itemId;
					var date = obj[i].date;
					var title = obj[i].title;
					var ballCount = obj[i].ballCount;//让球数
					var str = ballCount?"("+ballCount+")":"";
					var doc = obj[i].doc;//
					var result = obj[i].result;//是否命中
					var c = result=="命中"?"tzHit":"";
					var realResult = obj[i].realResult;
					var name = obj[i].name;
					var spf = obj[i].spf || '';//胜平负sp
					var spfArr = spf.split(",") || [];
					
					//拼接HTML字符串
					if(date && date != null){
						lctjHTML+='<article class="pd" style="margin-bottom:1rem">'
						lctjHTML+='<div class="tz">';
						lctjHTML+='<p class="time">'+date+'</p>';
						lctjHTML+='<p class="tdtime">预计推单时间</p>';
						lctjHTML+='</div>';
						lctjHTML+='</article>';
					}else{
						lctjHTML+='<article class="pd pd2">';
						lctjHTML+='<div class="tz '+c+'">';
						lctjHTML+='<p>'+name+"&nbsp;"+time+'开赛</p>';
						lctjHTML+='<div class="spfzpk">'
							if(title=="本场可锁定主胜"||title=="本场可锁定让球胜"){
								lctjHTML+='<span class="cur"><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
								lctjHTML+='<span class="spfvs"><em>VS</em><cite>平</cite></span>'
								lctjHTML+='<span><em>'+teamB+'</em><cite>胜</cite></span>';
							}else if(title=="本场可锁定平局"||title=="本场可锁定让球平"){
								lctjHTML+='<span><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
								lctjHTML+='<span class="spfvs cur"><em>VS</em><cite>平</cite></span>'
								lctjHTML+='<span><em>'+teamB+'</em><cite>胜</cite></span>';
							}else if(title=="本场可锁定客胜"||title=="本场可锁定让球负"){
								lctjHTML+='<span><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
								lctjHTML+='<span class="spfvs"><em>VS</em><cite>平</cite></span>'
								lctjHTML+='<span class="cur"><em>'+teamB+'</em><cite>胜</cite></span>';
							}else if(title=="本场可锁定主胜或客胜"){
								lctjHTML+='<span class="cur"><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
								lctjHTML+='<span class="spfvs"><em>VS</em><cite>平</cite></span>'
								lctjHTML+='<span class="cur"><em>'+teamB+'</em><cite>胜</cite></span>';
							}else if(title=="本场可锁定平局或客胜"){
								lctjHTML+='<span><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
								lctjHTML+='<span class="spfvs cur"><em>VS</em><cite>平</cite></span>'
								lctjHTML+='<span class="cur"><em>'+teamB+'</em><cite>胜</cite></span>';
							}else{
								lctjHTML+='<span class="cur"><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
								lctjHTML+='<span class="spfvs cur"><em>VS</em><cite>平</cite></span>'
								lctjHTML+='<span><em>'+teamB+'</em><cite>胜</cite></span>';
							}
						if(spfArr.length <= 1){
							if($(HH.xml).find('row[itemid='+itemid+']').attr('spf')){
								spfArr =  $(HH.xml).find('row[itemid='+itemid+']').attr('spf').split(',');
							}
						}
						lctjHTML+='</div>';
						lctjHTML+='<div class="spfpl"><span>赔率'+(spfArr[0]||'')+'</span><span class="spfvs">赔率'+(spfArr[1]||'')+'</span><span>赔率'+(spfArr[2]||'')+'</span></div>';
						lctjHTML+='<p><strong>解析：</strong>'+doc+'</p>';
						lctjHTML+='</div>';
						lctjHTML+='</article>';
					}
				}
			}
			$("#lctjCont").html(lctjHTML);
		},
		//天天稳胆
		ttwd:function(D){
			var ttwdHTML = "";
			var obj = D.data || [];
			//data属性存在
			var count = D.count;
			var num1 = count.indexOf("平");
			var num2 = count.indexOf("返");
			var count1 = count.substring(0,num1);
			var count2 = count.substring(num2);
			count=count1+count2;
			if(count){
				$("#ttwd section.title p").html(count)
			}
			
			if(obj && obj!=null){
				//ttwdHTML+='<div class="downText">';
				for(var i in obj){
					var teamA = obj[i].teamA;//主队名字
					teamA = teamA.substring(0,5)
					var teamB = obj[i].teamB;//客队名字
					teamB = teamB.substring(0,5)
					var time = obj[i].time;//时间
					var itemid = obj[i].itemId;
					var news = obj[i].news;
					var date = obj[i].date;
					var title = obj[i].title;
					var ballCount = obj[i].ballCount;//让球数
					var str = ballCount?"("+ballCount+")":"";
					var result = obj[i].result;//是否命中
					var c = result=="命中"?"tzHit":"";
					var realResult = obj[i].realResult;
					var name = obj[i].name;
					var spf = obj[i].spf||'';//胜平负sp
					var spfArr = spf.split(",")||[];
					
					var wx = teamA+"VS"+teamB;
					
					HH.wdArr.push(wx)
					
					
					ttwdHTML+='<article class="pd">';
					ttwdHTML+='<div class="tz '+c+'">';
					ttwdHTML+='<p>'+name+'&nbsp;'+time+'</p>';
					ttwdHTML+='<div class="spfzpk">';
					
					if(title=="本场可锁定主胜"){
						ttwdHTML+='<span class="cur"><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
						ttwdHTML+='<span class="spfvs"><em>VS</em><cite>平</cite></span>'
						ttwdHTML+='<span><em>'+teamB+'</em><cite>胜</cite></span>';
					}else if(title=="本场可锁定平局"){
						ttwdHTML+='<span><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
						ttwdHTML+='<span class="spfvs cur"><em>VS</em><cite>平</cite></span>'
						ttwdHTML+='<span><em>'+teamB+'</em><cite>胜</cite></span>';
					}else if(title=="本场可锁定客胜"){
						ttwdHTML+='<span><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
						ttwdHTML+='<span class="spfvs"><em>VS</em><cite>平</cite></span>'
						ttwdHTML+='<span class="cur"><em>'+teamB+'</em><cite>胜</cite></span>';
					}else if(title=="本场可锁定主胜或客胜"){
						ttwdHTML+='<span class="cur"><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
						ttwdHTML+='<span class="spfvs"><em>VS</em><cite>平</cite></span>'
						ttwdHTML+='<span class="cur"><em>'+teamB+'</em><cite>胜</cite></span>';
					}else if(title=="本场可锁定平局或客胜"){
						ttwdHTML+='<span><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
						ttwdHTML+='<span class="spfvs cur"><em>VS</em><cite>平</cite></span>'
						ttwdHTML+='<span class="cur"><em>'+teamB+'</em><cite>胜</cite></span>';
					}else{
						ttwdHTML+='<span class="cur"><em>'+teamA+'<i class="green">'+str+'</i></em><cite>胜</cite></span>'
						ttwdHTML+='<span class="spfvs cur"><em>VS</em><cite>平</cite></span>'
						ttwdHTML+='<span><em>'+teamB+'</em><cite>胜</cite></span>';
					}
					if(spfArr.length <= 1){
						if($(HH.xml).find('row[itemid='+itemid+']').attr('spf')){
							spfArr =  $(HH.xml).find('row[itemid='+itemid+']').attr('spf').split(',');
						}
					}
					ttwdHTML+='</div>';
					ttwdHTML+='<div class="spfpl"><span>赔率'+(spfArr[0]||'')+'</span><span class="spfvs">赔率'+(spfArr[1]||'')+'</span><span>赔率'+(spfArr[2]||'')+'</span></div>';
					ttwdHTML+='</div>';
					ttwdHTML+='<p><strong>提点：</strong><br>';
					for(var j=0;j<news.length;j++){
						ttwdHTML+=(j+1)+'.'+news[j]+'<br>';
					}
					ttwdHTML+='</p>';
				    ttwdHTML+='</article>';
				}
			}
			$("#ttwdCont").html(ttwdHTML);
			localStorage.setItem("wd",JSON.stringify(HH.wdArr));
		},
		//热门赛事
		rmss:function(D){
			var rmssHTML="";
			if(D && D!=null){
				for(var i in D){
					var teamA = D[i].teamA;
					teamA = teamA.substring(0,5)
					var teamB = D[i].teamB;
					teamB = teamB.substring(0,5)
					var time = D[i].time;
					var itemId = D[i].itemId;
					var news = D[i].news;//情报信息数组
					var title = D[i].title;
					var href = D[i].href;
					var name = D[i].name;
					
					
					rmssHTML+='<article class="pd">';
					rmssHTML+='<div class="tz">';
					rmssHTML+='<p class="vs">'+teamA+' <em>VS</em> '+teamB+'</p>';
					rmssHTML+='<p class="tdtime">'+name+"&nbsp;"+time+'开赛</p>';
					rmssHTML+='</div>';
					rmssHTML+='<p><strong>绿茵情报：</strong><br>';
					for(var j=0;j<news.length;j++){
						rmssHTML+=(j+1)+'.'+news[j]+'<br>';
					}
					rmssHTML+='</p>';
					rmssHTML+='</article>';
				}
			}
			$("#rmssCont").html(rmssHTML);
		},
		//获取远程JS文件,根据时间获取数据信息
		
		getMessage:function(date){
			$("#txtBirthday").val(date);
			$.ajax({
				 url: '/zlk/jcsp/jcsp_'+date+'.js',
				 type: "GET",
				 dataType: "script",
				 timeout: 1000,
				 success: function(){
						var data = query();//返回的数据是个方法
						HH.lctj(data.lctj);//临场推荐
						HH.rmss(data.rmss);//热门赛事
						HH.ttwd(data.ttwd);//天天稳胆 
						$(".zwtj").hide();
						$("#cont_").show();
				 },
				 error:  function(){
					$(".zwtj").show();
					$("#cont_").hide();
				 }
					
				});
			
		},
		
		// 由于天天稳胆会不返回spf，所以使用jc_hh.xml获取spf
		getjcSpf:function(){
			$.ajax({
				 url: '/data/jincai/jc_hh.xml',
				 type: "GET",
				 dataType: "xml",
				 timeout: 1000,
				 success: function(xml){
					HH.xml = xml;
				 }	
			});
		},
		
		//获取制定规则的时间字符串  如：141025
		getTimeStr:function(date){
			//t = date.replace()
			var str ="";
			var d = new Date(date);
			var y = d.getFullYear().toString();
			y=y.substring(2);//2014
			var m = d.getMonth()+1;
			if(m<10){
				m="0"+m;
			}
			var r = d.getDate();
			if(r<10){
				r="0"+r;
			}
			str=y+m+r;
			return str;
		},
		//给input设置初始化的值
		setVal:function(){
			var str=""
			var d = new Date();
			var y = d.getFullYear().toString();
			y=y.substring(2);//2014
			var m = d.getMonth()+1;
			if(m<10){
				m="0"+m;
			}
			var r = d.getDate();
			if(r<10){
				r="0"+r;
			}
			str=y+m+r;
			return str;
		},
		getFormatDate:function(day){
			var Year = 0;
			var Month = 0;
			var Day = 0;
			var CurrentDate = "";
			// 初始化时间
			// Year= day.getYear();//有火狐下2008年显示108的bug
			Year = day.getFullYear();// ie火狐下都可以
			Month = day.getMonth() + 1;
			Day = day.getDate();
			CurrentDate += Year + "-";
			if (Month >= 10) {
				CurrentDate += Month + "-";
			} else {
				CurrentDate += "0" + Month + "-";
			}
			if (Day >= 10) {
				CurrentDate += Day;
			} else {
				CurrentDate += "0" + Day;
			}
			return CurrentDate;
		},
		//获取过去十天的时间
		getHistoryDate:function(){
			var nowTime = new Date();
			var listring = "";
			for(var i=0;i<10;i++){
				var newTime = new Date(nowTime.getTime()-i*24*60*60*1000);
				if(newTime.getTime()>1412784000000){
					var newDate = HH.getFormatDate(newTime);
					var newDate1 = newDate.substring(2,4)+newDate.substring(5,7)+newDate.substring(8,10);
					listring += '<li id='+newDate1+'>'+ newDate +'</li>';
				}
			}
			
			$('#listDate').html(listring);
			
			$('#listDate li').on('touchend', function(){
				$('#listDate').hide()
				if($(this).hasClass('cur'))return;
				$(this).addClass('cur').siblings().removeClass('cur')
				var id = $(this).attr('id')
				HH.getMessage(id)
			})
			
			var t = $("#txtBirthday").val();
			$('#listDate li[id='+t+']').addClass("cur");
		},
		showHistoryPeriod:function(){
			if($('#listDate').is(':visible')){
				$('#listDate').hide();
			}else{
				$('#listDate').show();
			}
		}
}

//当微信内置浏览器完成内部初始化后会触发WeixinJSBridgeReady事件。
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	// 分享到朋友圈
	WeixinJSBridge.on('menu:share:timeline', function(argv){
		var wd = JSON.parse(localStorage.getItem("wd"));
		var str = wd.join(",");
		var desc = "天天精选,今日稳胆推荐:"+str;
        WeixinJSBridge.invoke('shareTimeline',{
 
				"appid":"",                                              //appid 设置空就好了。
				"img_url":	 "http://4g.9188.com/activity/ttjx/spf.jpg",                   //分享时所带的图片路径
				"img_width":	"120",                            //图片宽度
				"img_height":	"120",                            //图片高度
				"link": "http://4g.9188.com/activity/ttjx/",                                               //分享附带链接地址
				"desc":desc,                            //分享内容介绍
				"title":"再不中奖就老了,权威专家,带你一单回血!"
			}, function(res){/*** 回调函数，最好设置为空 ***/});
   });
	
	WeixinJSBridge.on('menu:share:appmessage', function(argv){
		var wd = JSON.parse(localStorage.getItem("wd"));
		var str = wd.join(",");
		var desc = "天天精选,今日稳胆推荐:"+str;
        WeixinJSBridge.invoke('sendAppMessage',{
 
				"appid":"",                                              //appid 设置空就好了。
				"img_url":	 "http://4g.9188.com/activity/ttjx/spf.jpg",                                   //分享时所带的图片路径
				"img_width":	"120",                            //图片宽度
				"img_height":	"120",                            //图片高度
				"link": "http://4g.9188.com/activity/ttjx/",                                               //分享附带链接地址
				"desc":desc,                            //分享内容介绍
				"title":"再不中奖就老了,权威专家,带你一单回血!"
			}, function(res){/*** 回调函数，最好设置为空 ***/});
   });
	
}, false);