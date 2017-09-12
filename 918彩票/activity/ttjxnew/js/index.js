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
/* 友盟统计  */
var ClickCont = function(a){
	var u = navigator.userAgent;
	var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1;	//判断Android终端
	var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);	//IOS终端
		try{
			_czc.push(['_trackEvent',a ,'H5天天推球', '天天推球',1,'点击次数'])
		}catch(e){}	
}
$(function(){
	HH.init_();
	
	var from = location.search.getParam('from');
	if(from == 'app'){
		$('header').hide().css({'paddingBottom':0});
		$('.fixed-top').css({'top': 0});
		$('#ZqlistDate').css({'top': 5.05+'rem'})
		$('#LqlistDate').css({'top': 5.05+'rem'})
	}
	
	$('#nav span').on('touchstart' , function(){
		var el = $(this);
		if(!el.hasClass('active')){
			el.parent().find('span').removeClass('active');
			el.addClass('active');
			if(el.index() == 0){
				ClickCont('竞彩足球')
				$('#jclq').hide();
				$('#jczq').fadeIn();
				HH.jctype = 'jczq';
				$('#Lqtm').hide()
				$('#Zqtm').show()
			}else{
				ClickCont('竞彩篮球')
				$('#jczq').hide();
				$('#jclq').fadeIn();
				HH.jctype = 'jclq';
				$('#Zqtm').hide()
				$('#Lqtm').show()
			}
		}
	})
	$('#returnIndex').on('touchstart' , function(){
		location.href = '/'
	})
});


var HH = {
		//初始化方法
		wdArr:[],
		jctype:'jczq',
		init_:function(){
			
			var t = HH.setVal();
			var tt = t.substring(0,2)+t.substring(3,5)+t.substring(6,8)
			$("#ZqtxtBirthday").attr('indexId',tt)
			$("#LqtxtBirthday").attr('indexId',tt)
			var ttt = t.substring(3,t.length)
			$("#ZqtxtBirthday").html(ttt);
			$("#LqtxtBirthday").html(ttt);
			this.getjcSpf();
			this.ZqgetMessage(tt);//初始化加载第一个日期
			this.LqgetMessage(tt)
			this.getHistoryDate();
			this.bind_();
		},
		//绑定各种事件
		bind_:function(){
			$('#Zqtm').on('touchstart',function(event){
				var ev = event || window.event;
				ev.stopPropagation();
				ClickCont('竞彩足球往期')
				HH.showHistoryPeriod();
			});
			$('#Lqtm').on('touchstart',function(event){
				var ev = event || window.event;
				ev.stopPropagation();
				ClickCont('竞彩篮球往期')
				HH.showHistoryPeriod();
			});
			$('.daily_mask').bind('touchstart' , function(event){
				var ev = event || window.event;
				ev.stopPropagation();
				$('#ZqlistDate').hide();
				$('#LqlistDate').hide();
				$('.daily_mask').hide();
			})
		},
		
		/*
		 * 足球临场推荐、天天精选
		 */
		//临场推荐
		Zqlctj:function(D,url){
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
				$("#zqlctj .title p").html(count)
			}
			
			if(obj && obj!=null){
				for(var i in obj){
					var teamA = obj[i].teamA;//主队名字
					teamA = teamA.substring(0,5)
					var teamB = obj[i].teamB;//客队名字
					teamB = teamB.substring(0,5)
					var teamAUrl = url+obj[i].imgA;
					var teamBUrl = url+obj[i].imgB;
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
						lctjHTML+='<div class="daily_main-wu">'
						lctjHTML+='<img src="img/wu.png"/>'
						lctjHTML+='</div>'
						$("#Zqlc").hide();
					}else{
						lctjHTML += '<div class="daily_main-vs">\
										<div class="daily_main-l">\
										<img src='+teamAUrl+' >\
									</div>\
									<div class="daily_main-c">\
										<div class="daily_main-h1"><span>'+teamA+'</span>'
						lctjHTML +='<em class="daily_green">'+str+'</em>'			
						lctjHTML += '<i> VS </i><span>'+teamB+'</span>'
						lctjHTML += '</div><div class="daily_main-h2">'+name+"&nbsp;"+time+'开赛</div></div>\
									<div class="daily_main-r">\
										<img src='+teamBUrl+' >\
									</div>\
								</div>'
							lctjHTML += '<table class="daily_match"><tbody>'
							if(title=="本场可锁定主胜"||title=="本场可锁定让球胜"){
								lctjHTML += '<tr><th class="daily_bgred">主胜</th><th style="width: 25%;">平</th>\
									<th >客胜</th>\
								</tr>'
							}else if(title=="本场可锁定平局"||title=="本场可锁定让球平"){
								lctjHTML += '<tr><th >主胜</th><th style="width: 25%;" class="daily_bgred">平</th>\
									<th >客胜</th>\
								</tr>'
							}else if(title=="本场可锁定客胜"||title=="本场可锁定让球负"){
								lctjHTML += '<tr><th >主胜</th><th style="width: 25%;" >平</th>\
									<th class="daily_bgred">客胜</th>\
								</tr>'
							}else if(title=="本场可锁定主胜或客胜"){
								lctjHTML += '<tr><th class="daily_bgred">主胜</th><th style="width: 25%;" >平</th>\
									<th class="daily_bgred">客胜</th>\
								</tr>'
							}else if(title=="本场可锁定平局或客胜"){
								lctjHTML += '<tr><th >主胜</th><th style="width: 25%;" class="daily_bgred">平</th>\
									<th class="daily_bgred">客胜</th>\
								</tr>'
							}else{
								lctjHTML += '<tr><th class="daily_bgred">主胜</th><th style="width: 25%;" class="daily_bgred">平</th>\
									<th >客胜</th>\
								</tr>'
							}
						if(spfArr.length <= 1){
							if($(HH.xml).find('row[itemid='+itemid+']').attr('spf')){
								spfArr =  $(HH.xml).find('row[itemid='+itemid+']').attr('spf').split(',');
							}
						}
						lctjHTML+='<tr>\
									  <td>赔率'+(spfArr[0]||'')+'</td>\
									  <td>赔率'+(spfArr[1]||'')+'</td>\
									  <td>赔率'+(spfArr[2]||'')+'</td>\
								   </tr>\
								</tbody></table>'
						if(c){
							lctjHTML += '<div class="daily_main-zhong"></div>'
						}
						$("#Zqlc").show();
					}
				}
			}
			$("#Zqlc .daily_explain p").html(doc);
			
			$("#ZqlctjCont").html(lctjHTML);
			
		},
		//天天稳胆
		Zqttwd:function(D,url){
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
				$("#zqttwd .title p").html(count)
			}
			
			if(obj && obj!=null){
				//ttwdHTML+='<div class="downText">';
				for(var i in obj){
					var teamA = obj[i].teamA;//主队名字
					teamA = teamA.substring(0,5)
					var teamB = obj[i].teamB;//客队名字
					teamB = teamB.substring(0,5)
					var teamAUrl = url+obj[i].imgA;
					var teamBUrl = url+obj[i].imgB;
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
					
					

					ttwdHTML += '<div class="daily_main-vs">\
									<div class="daily_main-l">\
									<img src='+teamAUrl+' >\
								</div>\
								<div class="daily_main-c">\
									<div class="daily_main-h1"><span>'+teamA+'</span>'
									ttwdHTML +='<em class="daily_green">'+str+'</em>'			
					ttwdHTML += '<i> VS </i><span>'+teamB+'</span>'
					ttwdHTML += '</div><div class="daily_main-h2">'+name+"&nbsp;"+time+'开赛</div></div>\
								<div class="daily_main-r">\
									<img src='+teamBUrl+' >\
								</div>\
							</div>'
					ttwdHTML += '<table class="daily_match"><tbody>'
						
						if(title=="本场可锁定主胜"||title=="本场可锁定让球胜"){
							ttwdHTML += '<tr><th class="daily_bgred">主胜</th><th style="width: 25%;">平</th>\
								<th >客胜</th>\
							</tr>'
						}else if(title=="本场可锁定平局"||title=="本场可锁定让球平"){
							ttwdHTML += '<tr><th >主胜</th><th style="width: 25%;" class="daily_bgred">平</th>\
								<th >客胜</th>\
							</tr>'
						}else if(title=="本场可锁定客胜"||title=="本场可锁定让球负"){
							ttwdHTML += '<tr><th >主胜</th><th style="width: 25%;" >平</th>\
								<th class="daily_bgred">客胜</th>\
							</tr>'
						}else if(title=="本场可锁定主胜或客胜"){
							ttwdHTML += '<tr><th class="daily_bgred">主胜</th><th style="width: 25%;" >平</th>\
								<th class="daily_bgred">客胜</th>\
							</tr>'
						}else if(title=="本场可锁定平局或客胜"){
							ttwdHTML += '<tr><th >主胜</th><th style="width: 25%;" class="daily_bgred">平</th>\
								<th class="daily_bgred">客胜</th>\
							</tr>'
						}else{
							ttwdHTML += '<tr><th class="daily_bgred">主胜</th><th style="width: 25%;" class="daily_bgred">平</th>\
								<th >客胜</th>\
							</tr>'
						}
					if(spfArr.length <= 1){
						if($(HH.xml).find('row[itemid='+itemid+']').attr('spf')){
							spfArr =  $(HH.xml).find('row[itemid='+itemid+']').attr('spf').split(',');
						}
					}
					ttwdHTML+='<tr>\
						  <td>赔率'+(spfArr[0]||'')+'</td>\
						  <td>赔率'+(spfArr[1]||'')+'</td>\
						  <td>赔率'+(spfArr[2]||'')+'</td>\
					   </tr>\
					</tbody></table>'
					if(c){
						ttwdHTML += '<div class="daily_main-zhong"></div>'
					}
					var ttwdTd = ''
					ttwdTd+='<p><strong>提点：</strong><br>';
					for(var j=0;j<news.length;j++){
						ttwdTd+=(j+1)+'. '+news[j]+'<br><br>';
					}
					ttwdTd+='</p><br /><br />';
				}
			}
			$("#ZqttwdCont").html(ttwdHTML);
			$("#Zqtt .daily_explain").html(ttwdTd);
			$("#Zqtt").show();
			localStorage.setItem("wd",JSON.stringify(HH.wdArr));
		},
		//获取远程JS文件,根据时间获取数据信息
		
		/*
		 * 篮球临场推荐、天天精选
		 */
		Lqlctj:function(D,url){
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
				$("#lqlctj .title p").html(count)
			}
			
			if(obj && obj!=null){
				for(var i in obj){
					var teamA = obj[i].teamA;//主队名字
					teamA = teamA.substring(0,5)
					var teamB = obj[i].teamB;//客队名字
					teamB = teamB.substring(0,5)
					var teamAUrl = url+obj[i].imgA;
					var teamBUrl = url+obj[i].imgB;
					var time = obj[i].time;//时间
					var itemid = obj[i].itemId;
					var date = obj[i].date;
					var title = obj[i].title;
					var ballCount = obj[i].ballCount;//让球数
					var str = ballCount?"("+ballCount+")":"";
					var doc = obj[i].doc;//
					var result = obj[i].result;//是否命中
					var dxf = obj[i].dxf;//
					var c = result=="命中"?"tzHit":"";
					var realResult = obj[i].realResult;
					var name = obj[i].name;
					var play = obj[i].play;
					var sf = obj[i].sf || '';//胜平负sp
					var spfArr = sf.split(",") || [];
					
					//拼接HTML字符串
					if(date && date != null){
						lctjHTML+='<div class="daily_main-wu">'
						lctjHTML+='<img src="img/wu_lan.png"/>'
						lctjHTML+='</div>'
						$("#Lqlc").hide();
					}else{
						lctjHTML += '<div class="daily_main-vs">\
										<div class="daily_main-l">\
										<img src='+teamBUrl+' >\
									</div>\
									<div class="daily_main-c">\
										<div class="daily_main-h1"><span>'+teamB+'</span>'			
						lctjHTML += '<i> VS </i><span>'+teamA+'</span>'
						lctjHTML +='<em class="daily_green">'+str+'</em>'
						lctjHTML += '</div><div class="daily_main-h2">'+name+"&nbsp;"+time+'开赛</div></div>\
									<div class="daily_main-r">\
										<img src='+teamAUrl+' >\
									</div>\
								</div>'
							lctjHTML += '<table class="daily_match"><tbody>'
						if(play == '让分胜负' || play == '胜负'){
							if(title=="本场可锁定主胜"||title=="本场可锁定让分胜"){
								lctjHTML += '<tr><th >客胜</th>\
									<th class="daily_bgred">主胜</th>\
								</tr>'
							}else if(title=="本场可锁定客胜"||title=="本场可锁定让分负"){
								lctjHTML += '<tr><th class="daily_bgred">客胜</th>\
									<th >主胜</th>\
								</tr>'
							}else{
								lctjHTML += '<tr><th >客胜</th>\
									<th class="daily_bgred">主胜</th>\
								</tr>'
							}
						}else if(play == '大小分'){
							if(title=="本场可锁定小分"||title=="本场可锁定让球胜"){
								lctjHTML += '<tr><th >总分大于'+dxf+'</th>\
									<th class="daily_bgred">总分小于'+dxf+'</th>\
								</tr>' 
							}else if(title=="本场可锁定大分"||title=="本场可锁定让球负"){
								lctjHTML += '<tr><th class="daily_bgred">总分大于'+dxf+'</th>\
									<th >总分小于'+dxf+'</th>\
								</tr>'
							}
						}
						/*if(spfArr.length <= 1){
							if($(HH.xml).find('row[itemid='+itemid+']').attr('spf')){
								spfArr =  $(HH.xml).find('row[itemid='+itemid+']').attr('spf').split(',');
							}
						}*/
						lctjHTML+='<tr>\
									  <td>赔率'+(spfArr[1]||'')+'</td>\
									  <td>赔率'+(spfArr[0]||'')+'</td>\
								   </tr>\
								</tbody></table>'
						if(c){
							lctjHTML += '<div class="daily_main-zhong"></div>'
						}
						$("#Lqlc").show();
					}
				}
			}
			$("#Lqlc .daily_explain p").html(doc);
			
			$("#LqlctjCont").html(lctjHTML);
			
		
		},
		Lqttwd:function(D,url){

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
				$("#lqttwd .title p").html(count)
			}
			
			if(obj && obj!=null){
				for(var i in obj){
					var teamA = obj[i].teamA;//主队名字
					teamA = teamA.substring(0,5)
					var teamB = obj[i].teamB;//客队名字
					teamB = teamB.substring(0,5)
					var teamAUrl = url+obj[i].imgA;
					var teamBUrl = url+obj[i].imgB;
					var time = obj[i].time;//时间
					var itemid = obj[i].itemId;
					var date = obj[i].date;
					var news = obj[i].news;
					var title = obj[i].title;
					var ballCount = obj[i].ballCount;//让球数
					var str = ballCount?"("+ballCount+")":"";
					var doc = obj[i].doc;//
					var result = obj[i].result;//是否命中
					var c = result=="命中"?"tzHit":"";
					var realResult = obj[i].realResult;
					var name = obj[i].name;
					var sf = obj[i].sf || '';//胜平负sp
					var spfArr = sf.split(",") || [];
					
					//拼接HTML字符串
					if(date && date != null){
						lctjHTML+='<div class="daily_main-wu">'
						lctjHTML+='<img src="img/wu_lan.png"/>'
						lctjHTML+='</div>'
						$("#Lqtt").hide();
					}else{
						lctjHTML += '<div class="daily_main-vs">\
										<div class="daily_main-l">\
										<img src='+teamBUrl+' >\
									</div>\
									<div class="daily_main-c">\
										<div class="daily_main-h1"><span>'+teamB+'</span>'			
						lctjHTML += '<i> VS </i><span>'+teamA+'</span>'
						lctjHTML +='<em class="daily_green">'+str+'</em>'
						lctjHTML += '</div><div class="daily_main-h2">'+name+"&nbsp;"+time+'开赛</div></div>\
									<div class="daily_main-r">\
										<img src='+teamAUrl+' >\
									</div>\
								</div>'
							lctjHTML += '<table class="daily_match"><tbody>'
							if(title=="本场可锁定主胜"||title=="本场可锁定让分胜"){
								lctjHTML += '<tr><th >客胜</th>\
									<th class="daily_bgred">主胜</th>\
								</tr>'
							}else if(title=="本场可锁定客胜"||title=="本场可锁定让分负"){
								lctjHTML += '<tr><th class="daily_bgred">客胜</th>\
									<th >主胜</th>\
								</tr>'
							}else if(title=="本场可锁定主胜或客胜"){
								lctjHTML += '<tr><th class="daily_bgred">客胜</th>\
									<th class="daily_bgred">主胜</th>\
								</tr>'
							}else{
								lctjHTML += '<tr><th >客胜</th>\
									<th class="daily_bgred">主胜</th>\
								</tr>'
							}
						/*if(spfArr.length <= 1){
							if($(HH.xml).find('row[itemid='+itemid+']').attr('spf')){
								spfArr =  $(HH.xml).find('row[itemid='+itemid+']').attr('spf').split(',');
							}
						}*/
						lctjHTML+='<tr>\
									  <td>赔率'+(spfArr[1]||'')+'</td>\
									  <td>赔率'+(spfArr[0]||'')+'</td>\
								   </tr>\
								</tbody></table>'
						if(c){
							lctjHTML += '<div class="daily_main-zhong"></div>'
						}
						
						var ttwdTd = ''
						ttwdTd+='<p><strong>提点：</strong><br>';
						for(var j=0;j<news.length;j++){
							ttwdTd+=(j+1)+'. '+news[j]+'<br><br>';
						}
						ttwdTd+='</p>';
						$("#Lqtt").show();
					}
				}
			}
			$("#Lqtt .daily_explain").html(ttwdTd);
			
			$("#LqttwdCont").html(lctjHTML);
			
		},
		ZqgetMessage:function(date){
			$("#ZqtxtBirthday").attr('indexId',date)
			$.ajax({
				 url: '/zlk/jcsp/jcsp_'+date+'.js',
				 type: "GET",
				 dataType: "script",
				 timeout: 1000,
				 success: function(){
					 
						var data = query();//返回的数据是个方法
						HH.Zqlctj(data.lctj,data.url);//临场推荐
						HH.Zqttwd(data.ttwd,data.url);//天天稳胆 
						/*$(".zwtj").hide();
						$("#cont_").show();*/
				 },
				 error:  function(){
					 $("#Zqtt").hide();
					 $("#Zqlc").hide();
					 $("#ZqttwdCont").html('<div class="daily_main-wu"><img src="img/wu_no.png"/></div>')
					 $("#ZqlctjCont").html('<div class="daily_main-wu"><img src="img/wu_no.png"/></div>');
					/*$(".zwtj").show();
					$("#cont_").hide();*/
				 }	
				});
		},
		
		LqgetMessage:function(date){
			$("#LqtxtBirthday").attr('indexId',date)
			$.ajax({
				 url: '/lqzlk/jcsp/lq_jcsp_'+date+'.js',
				 type: "GET",
				 dataType: "script",
				 timeout: 1000,
				 success: function(){
					 
						var data = query();//返回的数据是个方法
						HH.Lqlctj(data.lctj,data.url);//临场推荐
						HH.Lqttwd(data.ttwd,data.url);//天天稳胆 
						/*$(".zwtj").hide();
						$("#cont_").show();*/
				 },
				 error:  function(){
					 $("#Lqtt").hide();
					 $("#Lqlc").hide();
					 $("#LqttwdCont").html('<div class="daily_main-wu"><img src="img/wu_lan_no.png"/></div>')
					 $("#LqlctjCont").html('<div class="daily_main-wu"><img src="img/wu_lan_no.png"/></div>');
					/*$(".zwtj").show();
					$("#cont_").hide();*/
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
				 },
				 error:  function(){
						/*$(".zwtj").show();
						$("#cont_").hide();*/
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
			var show_day=new Array('星期一','星期二','星期三','星期四','星期五','星期六','星期日');
			var y = d.getFullYear().toString();
			y=y.substring(2);//2014
			var m = d.getMonth()+1;
			if(m<10){
				m="0"+m;
			}
			var r = d.getDate();
			var w	= d.getDay();
			var updata = new Date(d.getFullYear()+'/'+m+'/'+r+' '+'10:30').getTime();
			var nowdata = new Date(d).getTime();
			if(nowdata >= updata){
				r = r
			}else{
				r = r -1;
				w = w - 1;
			}
			if(r<10){
				r="0"+r;
			}
			if(w == 0){
				w = 7
				w= " " + show_day[w-1];
			}else if(w == -1){
				w = 6
				w += " " + show_day[w-1];
			}else{
				w= " " + show_day[w-1];
			}
			str=y+'-'+m+'-'+r+''+w;
			return str;
		},
		getFormatDate:function(day){
			var show_day=new Array('星期一','星期二','星期三','星期四','星期五','星期六','星期日');
			var Year = 0;
			var Month = 0;
			var Day = 0;
			var CurrentDate = "";
			// 初始化时间
			// Year= day.getYear();//有火狐下2008年显示108的bug
			Year = day.getFullYear();// ie火狐下都可以
			Month = day.getMonth() + 1;
			Day = day.getDate();
			Week	= day.getDay();
			var updata = new Date(Year+'/'+Month+'/'+Day+' '+'10:30').getTime();
			var nowdata = new Date(day).getTime();
			if(nowdata >= updata){
				Day = Day
			}else{
				Day = Day -1;
				Week = Week - 1;
			}
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
			if(Week == 0){
				Week = 7
				CurrentDate += " " + show_day[Week-1];
			}else if(Week == -1){
				Week = 6
				CurrentDate += " " + show_day[Week-1];
			}else{
				CurrentDate += " " + show_day[Week-1];
			}
			
			
			return CurrentDate;
		},
		//获取过去十天的时间
		getHistoryDate:function(){
			var nowTime = new Date();
			var listring = "";
			for(var i=0;i<7;i++){
				var newTime = new Date(nowTime.getTime()-i*24*60*60*1000);
				if(newTime.getTime()>1412784000000){
					var newDate = HH.getFormatDate(newTime);
					var newDate1 = newDate.substring(2,4)+newDate.substring(5,7)+newDate.substring(8,10);
					listring += '<li id='+newDate1+'>'+ newDate.substring(5,newDate.length) +'</li>';
				}
			}
			
			$('#ZqlistDate').html(listring);
			$('#LqlistDate').html(listring);
			
			$('#ZqlistDate li').on('touchend', function(){
				$('#ZqlistDate').hide()
				$('.daily_mask').hide()
				$("#ZqtxtBirthday").html($(this).html());
				if($(this).hasClass('active'))return;
				$(this).addClass('active').siblings().removeClass('active')
				var id = $(this).attr('id')
				if(HH.jctype == 'jczq'){
					HH.ZqgetMessage(id)
				}
			})
			$('#LqlistDate li').on('touchend', function(){
				$('#LqlistDate').hide()
				$('.daily_mask').hide()
				$("#LqtxtBirthday").html($(this).html());
				if($(this).hasClass('active'))return;
				$(this).addClass('active').siblings().removeClass('active')
				var id = $(this).attr('id')
				if(HH.jctype == 'jclq'){
					HH.LqgetMessage(id,$(this).html())
				}
			})
			
			var t = $("#ZqtxtBirthday").attr('indexId');
			$('#ZqlistDate li[id='+t+']').addClass("active");
			var tt = $("#LqtxtBirthday").attr('indexId');
			$('#LqlistDate li[id='+t+']').addClass("active");
		},
		showHistoryPeriod:function(){
			if(HH.jctype == 'jczq'){
				if($('#ZqlistDate').css('display') == 'none'){
					$('#ZqlistDate').show();
					$('.daily_mask').show();
				}else{
					$('#ZqlistDate').hide();
					$('.daily_mask').hide();
				}
			}else{
				if($('#LqlistDate').css('display') == 'none'){
					$('#LqlistDate').show();
					$('.daily_mask').show();
				}else{
					$('#LqlistDate').hide();
					$('.daily_mask').hide();
				}
			}
			
		}

		
}