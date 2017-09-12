var lot=function (n, m){
		m = m || '0';
		n = parseInt(n);
		var lot = {
				'1': ['双色球', 'ssq', '6'],
				'3': ['福彩3D', '3d', '7'],
				'4': ['时时彩', 'ssc', ''],
				'5': ['新快3', 'k3', ''],
				'6': ['快3', 'ahk3', ''],
				'7': ['七乐彩', 'qlc', '8'],
				'8': ['福彩快3', 'nmk3', ''],
				'9': ['江苏快3', 'k3', ''],
				'10':['新快3', 'xk3', ''],
				'20':['新时时彩', 'jxssc', ''],
				'50':['大乐透', 'dlt', '9'],
				'51':['七星彩', 'qxc', '10'],
				'52':['排列五', 'p5', '12'],
				'53':['排列三', 'p3', '11'],
				'54':['11选5', '11x5', ''],
				'55':['广东11选5', 'gd11x5', ''],
				'56':['11运夺金', '11ydj', ''],
				'57':['上海11选5', 'sh11x5', ''],
				'58':['快乐扑克3', 'pk3', ''],
				'80':['胜负彩', 'sfc', '3'],
				'81':['任选九', 'r9', '4'],
				'82':['进球彩', 'jq', ''],
				'83':['半全场', 'bq', ''],
				'84':['单场-胜负过关', 'sfgg', '5'],
				'85':['单场-胜平负', 'bjdc', '5'],
				'86':['单场-比分', 'bjdc', '5'],
				'87':['单场-半全场', 'bjdc', '5'],
				'88':['单场-上下单双', 'bjdc', '5'],
				'89':['单场-总进球', 'bjdc', '5'],
				'90':['竞彩足球-让球', 'jczq', '1'],
				'91':['竞彩足球-比分', 'jczq', '1'],
				'92':['竞彩足球-半全场', 'jczq', '1'],
				'93':['竞彩足球-总进球', 'jczq', '1'],
				'70':['竞彩足球-混投', 'jczq', '1'],
				'72':['竞彩足球-胜平负', 'jczq', '1'],
				'94':['篮彩-胜负', 'jclq', '2'],
				'95':['篮彩-让分', 'jclq', '2'],
				'96':['篮彩-胜分差', 'jclq', '2'],
				'97':['篮彩-大小分', 'jclq', '2'],
				'98':['欧洲杯-猜冠军', 'cgj', '2'],
				'99':['欧洲杯-猜冠亚军', 'gyj', '2'],
				
				'71':['篮彩-混投', 'jclq', '2']
		};
		return lot[n][m];
	};


var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag){
			$('#dAlert p').html(msg);
			tag && $('#dAlert a.bfb').html(tag) || $('#dAlert a.bfb').html('知道了');
			$("#dAlert").show();
			$(".zhezhao").show();
			$('#dAlert a.bfb').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$('#dAlert').hide();
				$(".zhezhao").hide();
			});
		}
}



//玩法类型
var playType={
		"SPF":"胜平负",
		"RQSPF":"让球",
		"RSPF":"让球",
		"JQS":"总进球",
		"CBF":"猜比分",
		"BQC":"半全场"
}

var hid = location.search.getParam("hid");
var gid = hid.substring(0,2);
var agentFrom = location.search.getParam("agentFrom");
var dsd = location.search.getParam("dsd")||"";
var shareUserId = location.search.getParam("shareUserId")||"";
var fflag = location.search.getParam("fflag")||"";

//玩法结果
var results={
		"3":"胜","1":"平","0":"负",
}

var tname = lot(gid);

//投注需要参数
var g = {
       "hid":hid,
       "gid":gid,
       money:"",
       muli:"",
       cupacketid:"",
       redpacket_money:""
    };
$('#bs').val(1)
var SD = (function(){
	var o = {
			length:function(jsonObj) {
			    var Length = 0;
			    for (var item in jsonObj) {
			      Length++;
			    }
			    return Length;
		    },
		    cuter2 : function( str ){//abcd  
		        return str.replace( /\B(?=(?:\d{3})+$)/g, ',' );  
			 },
			gain: function(){
				
				$.ajax({
					url:'/trade/godShareDetail.go',//70DG2016102662723016  70DG2016102562722892  70DG2016102762723104
					type:'POST',
					data:{
						hid: hid,
						xzflag : shareUserId? 1: 0
					},
					success: function(xml){
						var R = $(xml).find('Resp');
						var code = R.attr("code");
						var desc = R.attr("desc");
						
						var itemdetail = R.find("itemdetail");
						
						var gameid = itemdetail.attr("gameid");//游戏id
						var projid = itemdetail.attr("projid");//方案编号
						var wrate = itemdetail.attr("wrate")||"";//打赏比例
						var endtime = itemdetail.attr("endtime")||"";//截止时间
						var tmoney = itemdetail.attr("tmoney")||"";//发起人投注金额
						var averageMoney = itemdetail.attr("averageMoney")||"";//起投金额
						SD.averageMoney = averageMoney
						var userNum = itemdetail.attr("userNum");//跟投人数
						var projState = itemdetail.attr("projState");//方案状态
						var limitMoney = itemdetail.attr("limitMoney")	// 限制跟投总金额	 
						var progress = itemdetail.attr("progress")	 //跟投百分比	 
						var finish = itemdetail.attr("finish")	//该单子是否完成
						
						//projState=0
						
						if(projState==1){//方案进行中
							$("#buy_box").show();
							$("#end").hide();
						}else {//方案已截止
							$("#buy_box").hide();
							$("#end").show();
						}
						var godDetail = R.find("godDetail");
						var realUid = godDetail.attr("realUid");//游戏id
						var nickid = godDetail.attr("nickid");//分享人
						var rank = godDetail.attr("rank");//排名
						var allnum = godDetail.attr("allnum");//发单总数
						var rednum = godDetail.attr("rednum");//红单数
						var shootrate = godDetail.attr("shootrate");// 命中率
						var returnrate = godDetail.attr("returnrate");//回报率
						var buymoney = godDetail.attr("buymoney");// 购买金额
						var winmoney = godDetail.attr("winmoney");//累积中奖金额
						var winrate = godDetail.attr("winrate");// 战胜人数比例
						var imgUrl = godDetail.attr("imgUrl")||"/sdjc/img/zwtp.png";//用户头像信息
						var isGod = godDetail.attr("isGod");//是否为大神
						
						var isOwner = godDetail.attr("isOwner")	 //是否是发单人本人 true 是 false 不是
						var showData = godDetail.attr("showData")	 //是否显示以下数据godDetail数据	 “0”-不显示“1”-显示
						
						var winmoney30 = godDetail.attr("winmoney30")	 //30日累计中奖金额	 
						var follownum30 = godDetail.attr("follownum30")	// 30日跟投总人数	 
						var followmoney30 = godDetail.attr("followmoney30")	 //30日跟投总金额
						
						var combo = godDetail.attr("combo")	 //连红数	 
						var shootrate7 = godDetail.attr("shootrate7")	/// 7日命中	 
						var returnrate7 = godDetail.attr("returnrate7")	// 7日回报
						
						var shootrate15 = godDetail.attr("shootrate15") //15日命中	 
						var returnrate15 = godDetail.attr("returnrate15")	// 15日回报
						
						var shootrate30 = godDetail.attr("shootrate30")	 //30日命中	 
						var returnrate30 = godDetail.attr("returnrate30")	 //30日回报
						
						$("#tmoney").html(o.cuter2(tmoney)+'元');//发起人投注金额
						
						$("#endtime").html(endtime+'截止');//截止时间
						
						$("#averageMoney").html(o.cuter2(averageMoney)+"元");//起投金额
						$("#wrate").html('打赏'+wrate)//打赏比例
						$("#nickid").html(nickid)//发起人名称
						$("#imgUrl").attr("src",imgUrl);
						
						$("#pMoney").html(averageMoney+"元");
						$("#fdwrate").html(wrate);
						
						//是否为本人分享
						if(fflag){  //新版本带fflag
							if(!shareUserId){  //本人分享带shareUserId
								if(isOwner == 'false'){  // 是否为本人
									$('.p_xg').html('限跟总额'+limitMoney+'元');
									if( parseFloat(progress) >= parseFloat('10%') && parseFloat(progress) < parseFloat('90%')){
										$('.js_progress').show();
										$('.js_progress').css('width',parseFloat(progress)+'%');
										$('.js_progress span').css('left',parseFloat(progress)+'%');
										$('.js_progress span').html(parseFloat(progress) + '%已跟');
									}else if(parseFloat(progress) >= parseFloat('90%') && parseFloat(progress) < parseFloat('100%')){
										$('.js_progress').show();
										$('.js_progress').css('width',parseFloat(progress)+'%');
										$('.js_progress span').css({'left':'auto','right':'15px'});
										$('.js_progress span').html(parseFloat(progress) + '%已跟');
									}else if(parseFloat(progress) >= parseFloat('100%')){
										if(projState == 1 ){
											$("#buy_box").hide();
											$("#endme").show();
										}
										$('.js_progress').show();
										$('.js_progress').css('width','100%');
										$('.js_progress span').css({'left':'auto','right':'15px'});
										$('.js_progress span').html('100%已跟');
									}
								}
							}
							/*if(isOwner == 'false'){
								$('.p_xg').html('限购总额'+limitMoney+'元');
								if( parseFloat(progress) >= parseFloat('10%') && parseFloat(progress) < parseFloat('100%')){
									var p = progress;
									(parseFloat(progress) > parseFloat('0%')) && (parseFloat(progress) <= parseFloat('10%')) && (p='10%');
									(parseFloat(progress) >= parseFloat('90%')) && (p='89%');
									$('.js_progress').show();
									$('.js_progress').css('width',parseFloat(p)+'%');
									
									$('.js_progress span').css('left',parseFloat(p)+'%');
									$('.js_progress span').html(progress + '%已跟');
								}else if(parseFloat(progress) >= parseFloat('100%')){
									var p = progress;
									(parseFloat(progress) >= parseFloat('100%')) && (p='90%');
									$("#buy_box").hide();
									$("#endme").show();
									$('.js_progress').show();
									$('.js_progress').css('width',parseFloat(p)+'%');
									$('.js_progress span').css('left',parseFloat(p)+'%');
									$('.js_progress span').html('已满额');
								}
							}*/
						}
						
						
						
						if(showData == 1){//是大神
							$("#nickidContent").show();
							
						var infohtml="";
						
						 infohtml += '<div class="swiper-wrapper">'
							 
						 infohtml += '<div class="swiper-slide swiper-slide1 swiper-slide-prev">'
						 infohtml += '<div class="swiper_l">'
						 infohtml += '<p class="p3">'+ winmoney30+'元</p><p><span class="span7">30日</span><span>累计中奖</span></p></div>'
						 infohtml += '<div class="swiper_r"><p>累计<span>'+follownum30+'</span>人已跟买</p><p>跟买总额<span>'+followmoney30+'</span>元</p></div>'
						 infohtml += '</div>'
							 
						 infohtml += '<div class="swiper-slide swiper-slide1">'
						 infohtml +='<ul class="swiper_ul4 clearfix">';
						 infohtml +='<li><p class="p_top">7日命中率</p>'
						 if(shootrate7 && parseFloat(shootrate7) > parseFloat('0%')){
						 infohtml +='<p class="p_bottom ">'+shootrate7+'</p></li>'
						 }else{
						 infohtml +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 infohtml +='<li><p class="p_top">15日命中率</p>'
						 if(shootrate15 && parseFloat(shootrate15) > parseFloat('0%')){
						 infohtml +='<p class="p_bottom ">'+shootrate15+'</p></li>'
						 }else{
						 infohtml +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 infohtml +='<li><p class="p_top">30日命中率</p>'
						 if(shootrate30 && parseFloat(shootrate30) > parseFloat('0%')){
						 infohtml +='<p class="p_bottom ">'+shootrate30+'</p></li>'
						 }else{
						 infohtml +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 infohtml +='<li><p class="p_top">最近连红</p>'
						 if(combo !=0){
						 infohtml +='<p class="p_bottom">'+combo+'连红</p>'
						 }else{
						 infohtml +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 infohtml +='</ul>'
						 infohtml +='</div>'
							 
						 infohtml +='<div class="swiper-slide swiper-slide1">'
					     infohtml +='<ul class="swiper_ul3 clearfix">'
						 infohtml +='<li><p class="p_top">7日回报率</p>'
						 if(returnrate7 && parseFloat(returnrate7) > parseFloat('0%')){
						 infohtml +='<p class="p_bottom ">'+returnrate7+'</p></li>'
						 }else{
						 infohtml +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 infohtml +='<li><p class="p_top">15日回报率</p>'
						 if(returnrate15 && parseFloat(returnrate15) > parseFloat('0%')){
						 infohtml +='<p class="p_bottom ">'+returnrate15+'</p></li>'
						 }else{
						 infohtml +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 infohtml +='<li><p class="p_top">30日回报率</p>'
						 if(returnrate30 && parseFloat(returnrate30) > parseFloat('0%')){
						 infohtml +='<p class="p_bottom ">'+returnrate30+'</p></li>'
						 }else{
						 infohtml +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 infohtml +='</ul>'
						 infohtml +='</div>'
							 
						
						 infohtml +='</div>'
						 infohtml+='<div class="swiper-pagination"></div>'
						
						
						
						/*infohtml+='<div class="swiper-wrapper" id="">'
						
						
						infohtml+='<div class="swiper-slide swiper-slide1">'
						infohtml+='<div class="swiper_l">'
						if(rank == 1){
							infohtml+='<img src="img/medal.png">'
						}else if(rank == 2){
							infohtml+='<img src="img/medal1.png">'
						}else if(rank == 3){
							infohtml+='<img src="img/medal2.png">'
						}else{
							infohtml+='<p style=font-size:1.5rem;font-weight:600;color:#000>'+rank+'</p>'
						}
						infohtml+='<p>盈利大神榜</p><p>综合排名</p></div>'
						infohtml+='<div class="swiper_r" id="">战胜<span>'+winrate+'</span>的发单人</div>'
						infohtml+='</div>'
						infohtml+='<div class="swiper-slide swiper-slide1">'
						infohtml+='<div class="swiper_l"><p class="p3" id="returnrate">'+returnrate+'</p><p><span class="span7" id="uptype">'+uptype+'日</span><span>回报率</span></p></div>'
						infohtml+='<div class="swiper_r" id=""><p>累计中奖    '+winmoney+' 元</p><p>累计投注    '+buymoney+'元</p></div>'
						infohtml+='</div>'
						infohtml+='<div class="swiper-slide swiper-slide1">'
						infohtml+='<div class="swiper_l"><p class="p3" id="">'+shootrate+'</p><p><span class="span7">'+uptype+'日</span><span>命中率</span></p></div>'
						infohtml+='<div class="swiper_r" id="">分享'+allnum+'单，盈利'+rednum+'单</div>'
						infohtml+='</div>'
						infohtml+='</div>'
						infohtml+='</div>'
						infohtml+='<div class="swiper-pagination"></div>'*/
						$("#nickidContent").html(infohtml)
						var mm = winmoney30.split('.')[0].length;
							if(mm <= 4){
								$('.p3').css({'font-size':'1.875rem'})
							}else if(mm >4 && mm <= 6){
								$('.p3').css({'font-size':'1.5rem'})
							}else if(mm >6 && mm <= 9){
								$('.p3').css({'font-size':'1.2rem'})
							}
						var swiper = new Swiper('.swiper-container', {
								pagination: '.swiper-pagination',
								paginationClickable: true,
								loop : true,
								autoplayDisableOnInteraction : false,
								autoplay : 3000,
								speed:300
						});
						}else{
							$("#nickidContent").hide();
						}
						
						//if(dsd &&dsd=="1"){
							//$("#nickid").after("<em></em>");
							$("#fdrInfo").bind("click",function(){
								if(fflag){
									if(shareUserId){
										if(agentFrom){
											window.location.href="/sdjc/details.html?loc="+realUid+'&agentFrom='+agentFrom+'&fflag='+fflag+'&locname='+shareUserId;
										}else{
											window.location.href="/sdjc/details.html?loc="+realUid+'&fflag='+fflag+'&locname='+shareUserId;
										}
									}else{
										if(agentFrom){
											window.location.href="/sdjc/details.html?loc="+realUid+'&agentFrom='+agentFrom+'&fflag='+fflag;
										}else{
											window.location.href="/sdjc/details.html?loc="+realUid+'&fflag='+fflag;
										}
									}
								}else{
									if(agentFrom){
										window.location.href="/sdjc/details.html?loc="+realUid+'&agentFrom='+agentFrom
									}else{
										window.location.href="/sdjc/details.html?loc="+realUid
									}
								}
								
								
							})
						//}
							
						//命中图片显示
						var result  = R.find('result');
						var flag = result.attr("flag");	//命中标识	 0-未命中 1-命中
						var bonus = result.attr("bonus");	 //中奖金额	 
						var followBonus = result.attr("followBonus");	 //跟投中奖金额	 
						var reward = result.attr("reward");	 //收到打赏金额
						if(flag == 1){
							$('.zhong_div_big').show();
							var html = '发单人中奖'+bonus+'元<br/>';
							reward != 0 && (html += '收到打赏'+reward+'元<br/>');
							followBonus != 0 && (html += '跟买中奖'+followBonus+'元'); 
							$('.zhong_div_big p').html(html);
						}
						//命中图片显示
						
						var rows = R.find('rows')
						var showCode = rows.attr("showCode");
						var cast = rows.attr("cast");
						var istate = rows.attr("istate");
						var mulity = rows.attr("mulity");
						var money = rows.attr("tmoney");
						var rmoney = rows.attr("rmoney");
						var tax = rows.attr("tax");
						var award = rows.attr("award");
						var rpmoney = rows.attr("rpmoney");
						var btime = rows.attr("btime");
						var imoneyrange = rows.attr("imoneyrange");
						var source = rows.attr("source");//不同souce表示不同过关方式
						var gg="";
						gg = rows.attr("gg");//过关方式
						var minRatio = rows.attr("minRatio");
						var ipay = rows.attr("ipay");
						var upay = rows.attr("upay");
						var shareGod = rows.attr("shareGod");
						var sharedNickid = rows.attr("sharedNickid");
						var hideSharedNickid = rows.attr("hideSharedNickid");
						var visible = rows.attr("visible");
						var jindu = rows.find("jindu");
						var node = jindu.attr("node");
						var percent = jindu.attr("percent");
						var jjyh = rows.attr("jjyh")||"";
						
						var tt_;
						if(jjyh && jjyh=="1" && (source == '6' || source == '14')){ //
							var matchs  = rows.find('matchs')
							var detail = rows.find('detail')
							gg = detail.attr('gg').replace(/\*/g,'串').replace(/1串1/g,'单关');
							tt_ = matchs.find("row");
							gg= gg + ",奖金优化"
						}else if(source == '15'){ //一场制胜
							var matchs  = rows.find('matchs')
							var detail = rows.find('detail')
							gg = detail.attr('gg').replace(/\*/g,'串').replace(/1串1/g,'单关');
							tt_ = matchs.find("row");
							gg= gg + ",一场制胜"
							$("#gameType").html('竞彩篮球-一场制胜')
						}else if(source == '8') { //2选1
							$("#gameType").html('竞彩-2选1')
							tt_ = rows.find('row')
						}else{
							tt_ = rows.find('row')
						}
						
							//var row = rows.find('row')
							var html = '';
							if(tt_.length){
								tt_.each(function(i ,v ){
									/***
									id="161025001" name="周二001" hn="墨尔本胜利" 
									gn="墨尔本城" hs="" gs="" hhs="" hgs="" 
									lose="1" isdan="0" jsbf="" 
									ccodes="HH|SPF=3_2.67,SPF=1_3.45,RQSPF=0_4.35,JQS=2_3.95"
									ccodes="BQC|3-0_25.00+CBF|5:2_80.00,0:5_400.0"
									***/
									
									var id = $(this).attr('id');//
									var name = $(this).attr('name');//
									var hn = $(this).attr('hn');//
									var gn = $(this).attr('gn');//
									var hs = $(this).attr('hs')||"";//
									var gs = $(this).attr('gs')||"";//
									
									var hhs = $(this).attr('hhs')||"";//
									var hgs = $(this).attr('hgs')||$(this).attr('hvs')||"";//
									var lose = $(this).attr('lose')||$(this).attr('close');//
									var isdan = $(this).attr('isdan');//
									var jsbf = $(this).attr('jsbf');//
									var ccodes = $(this).attr('ccodes');//
									
									var rq = '';//让球样式
									if(lose!=0 && lose !=""){
										if(lose.indexOf('-')!=-1){
											rq="(<font color=''>"+lose+"</font>)";
										}else{
										rq="(<font color=''>"+lose+"</font>)";
										}
									}
									
									//是否设胆
									var dan="";
									if(isdan==1){
										dan='<span class="span14">胆</span>'
									}
									var tmp = ccodes.split()
									var obj = {}
									/***
									ccodes="HH|SPF=3_2.67,SPF=1_3.45,RQSPF=0_4.35,JQS=2_3.95" 串关
									ccodes="BQC|3-0_25.00    +      CBF|5:2_80.00,0:5_400.0" 
									ccodes="SPF|3_5.70,1_3.85"
									***/
									if(showCode=="true"){//显示投注内容及投注信息
										if(gameid==70){//混合投注=》单关
											if(source==13 && gg=="单关"){//单关
												var ccodes2 = ccodes.split('+');
												for(var i = 0;i<ccodes2.length;i++){
													
													var a = ccodes2[i].split('|');
													var b = a[1].split(',');
													
													for(var j=0;j<b.length; j++){
														if(!obj[a[0]]){
															obj[a[0]] = [b[j]] 
														}else{
															var arr = obj[a[0]]
															arr.push(b[j])
															obj[a[0]] = arr;
														}
													}
												}
											}else{//混合
												if(jjyh==1){//奖金优化
													//sPF_0_3.65,RQSPF_3_4.05,CBF_5:1_150.0,CBF_9:0_100.0,CBF_0:9_250.0
													var ccodes2 = ccodes.split(",");
													for(var i = 0;i<ccodes2.length;i++){
														if(obj[ccodes2[i].split("_")[0]]){
															var arr = obj[ccodes2[i].split("_")[0]];
															arr.push([ccodes2[i].split("_")[1]]+"_"+[ccodes2[i].split("_")[2]])
															obj[ccodes2[i].split('_')[0]] = arr
														}else{
															obj[ccodes2[i].split('_')[0]] = [ccodes2[i].split('_')[1]+"_"+ccodes2[i].split('_')[2]]
														}
													}
												}else{
													var ccodes2 = ccodes.split('|')[1] || '',
													ccodes3 = ccodes2.split(',');
													
													for(var i = 0, l = ccodes3.length; i<l; i++){
														if(obj[ccodes3[i].split('=')[0]]){
															var arr = obj[ccodes3[i].split('=')[0]]
															arr.push(ccodes3[i].split('=')[1])
															obj[ccodes3[i].split('=')[0]] = arr
														}else{
															obj[ccodes3[i].split('=')[0]] = [ccodes3[i].split('=')[1]]
														}
													}
												}
											}
										}else {//ccodes="SPF|3_5.70,1_3.85"
											if(jjyh==1){//奖金优化
												//sPF_0_3.65,RQSPF_3_4.05,CBF_5:1_150.0,CBF_9:0_100.0,CBF_0:9_250.0
												var ccodes2 = ccodes.split(",");
												for(var i = 0;i<ccodes2.length;i++){
													if(obj[ccodes2[i].split("_")[0]]){
														var arr = obj[ccodes2[i].split("_")[0]];
														arr.push([ccodes2[i].split("_")[1]]+"_"+[ccodes2[i].split("_")[2]])
														obj[ccodes2[i].split('_')[0]] = arr
													}else{
														obj[ccodes2[i].split('_')[0]] = [ccodes2[i].split('_')[1]+"_"+ccodes2[i].split('_')[2]]
													}
												}
											}else{
												var ccodes2 = ccodes.split("|");
												obj[ccodes2[0]]=ccodes2[1].split(",");
											}
										}
										
										
										
										html += '<tr>\
											<td class="width1" rowspan="'+(o.length(obj)+1)+'"><p>'+name.substring(0,2)+'</p><p>'+name.substring(2,name.length)+'</p></td>\
											<td class="width2"><p class="c_gray">'+hn+rq+' VS '+gn+dan+'</p></td>'
										if(hhs == '-1' && hgs == '-1' && hs == '-1' && gs == '-1'){
											html += '<td class="width3">延</td>'
										}else{
											html += '<td class="width3">半'+((hhs==""&&hgs=="")?"--":hhs+':'+hgs)+'/全'+((hs==""&&gs=="")?"--":hs+':'+gs)+'</td>'
										}
										html += '</tr>'
										for(var i in obj){
											var arr=[];
											
											var obj2 = obj[i]
											//console.log(obj2)
											html+='<tr>'
											var Result = o.checkResult(i,hs,gs,hhs,hgs,lose)
											if(obj2.length>1){
												html += '<td align="left">'
												for(var j = 0; j<obj2.length; j++){
													var type = obj2[j].split('_')[0]
													arr.push(o.checkPlayName(i,type))
													if( Result == o.checkPlayName(i,type) || (Result=='让平' && o.checkPlayName(i,type)=='平') ){
														html+='<span>'+playType[i]+':<i class=red>'+o.checkPlayName(i,type)+'</i>('+obj2[j].split('_')[1]+')</span><br />'
													}else{
														html+='<span>'+playType[i]+':'+o.checkPlayName(i,type)+'('+obj2[j].split('_')[1]+')</span><br />'
													}
												}
												html += '</td>'
											}else{
												var type=obj2[0].split('_')[0]
												arr.push(o.checkPlayName(i,type))
												if(Result == o.checkPlayName(i,type) || (Result=='让平' && o.checkPlayName(i,type)=='平') ){
													html+='<td align="left"><span>'+playType[i]+':<i class=red>'+o.checkPlayName(i,type)+'</i>('+obj2[0].split('_')[1]+')</span></td>'
												}else{
													html+='<td align="left"><span>'+playType[i]+':'+o.checkPlayName(i,type)+'('+obj2[0].split('_')[1]+')</span></td>'
												}
												
											}
											console.log(arr)
											
											html+='<td>'
												if(hs!="" && gs!="" && hgs!="" && hhs!=""){
													if(arr.indexOf(Result)!=-1 || (arr.indexOf("平")!=-1 && Result=="让平")){
														html+="<i class='red'>"+o.checkResult(i,hs,gs,hhs,hgs,lose)+'</i>'
													}else{
														html+="<i>"+o.checkResult(i,hs,gs,hhs,hgs,lose)+'</i>'
													}
													
												}else{
													html+='--'
												}
												
											html+='</td></tr>'
										}
									}else{//未开赛
										if(i==0){
											html+='<tr>'
											html+='<td class="width1"><p>'+name.substring(0,2)+'</p><p>'+name.substring(2,name.length)+'</p></td>'
											html+='<td class="width2"><p class="c_gray">'+hn+rq+' VS '+gn+dan+'</p></td>'
											html+='<td class="width3" rowspan="'+tt_.length+'"><p>开赛后</p> <p>公开</p><img src="img/table.png" class="table_icon"></td>'
											html+='</tr>'
										}else{
											html+='<tr>'
											html+='<td><p>'+name.substring(0,2)+'</p><p>'+name.substring(2,name.length)+'</p></td>'
											html+='<td><p class="c_gray">'+hn+' VS '+gn+dan+'</p></td>'
											html+='</tr>'
										}
									}
								})
									html +='<tr><td colspan="3"  class="width4"><p>过关方式：'+gg+'</p>'
									if((showCode =='true') && node >= 1 && percent == 100){
										html +='<span class="icon_chup" id="icon_chup">出票明细</span></td></tr>'
									}else{
										html +='</td></tr>'
									}
							}else{
								html = '<div class="empty_user"><p>暂无内容</p></div>'
							}
						
						$('#bettingInfo').html(html);
						
						var h1 = $('#info').height();
				    	$('#swip_inse ').css('height',h1);
						$(".table_icon").bind("click",function(){
							$('#mask').show();
							$('#queren').show();
						})
						$("#endme img").bind("click",function(){
							$('#mask').show();
							$('#gmme').show();
						})
						$('#mask').bind('click touchmove' , function(event){
							event.stopPropagation();
							$('#mask').hide();
							$('#queren').hide();
							$('#buy').hide();
							$('#gmme').hide();
						})
						$('.ok').bind('click touchstart' , function(event){
							event.stopPropagation();
							$('#mask').hide();
							$('#queren').hide();
							$('#gmme').hide();
						})
						$('#icon_chup').bind('click' , function(event){
							event.stopPropagation();
							CP.Checked(function(){
								location.href = 'mingxi.html?hid='+hid
							},true);
							
						})
						
					},
					error:function(){
						alert("网络异常")
					}
					
					
				})
			},
			//比分/彩果
			checkResult:function(type,hs,gs,hhs,hgs,lose){
				var str='';
				if(hs==="" &&　 hhs===""　&& gs==="" && hgs===""){
						str='--'
				}
				else{
					var hs=Number(hs)
					var gs=Number(gs)
					var hhs=Number(hhs)
					var hgs=Number(hgs)
					var lose=Number(lose)
					switch (type) {
					case 'SPF':
						if(hs == '-1' && gs == '-1' && hhs == '-1' && hgs == '-1'){
							str=''
						}else if(hs>gs){
							str='主胜';
						}else if(hs==gs){
							str='平'
						}else if(hs<gs){
							str='客胜'
						}else{
							str='--'
						}
						break;
					case 'RQSPF':
						if(( hs||hs == 0 ) && (gs || gs == 0 )){
							if(lose>0){
								if(hs == '-1' && gs == '-1' && hhs == '-1' && hgs == '-1'){
									str=''
								}else if(hs+lose>gs){
									str='让胜'
								}else if(hs+lose==gs){
									str='让平'
								}else if(hs+lose<gs){
									str='让负'
								}else{
									str='--'
								}
							}else if(lose<0){
								lose = Math.abs(lose);
								if(hs == '-1' && gs == '-1' && hhs == '-1' && hgs == '-1'){
									str=''
								}if(hs-lose>gs){
									str='让胜'
								}else if(hs-lose==gs){
									str='让平'
								}else if(hs-lose<gs){
									str='让负'
								}else{
									str='--'
								}
							}
						}else{
							str='--'
						}
						break;
					//胜胜，胜平，胜负,平胜，平平，平负，负胜，负平，负负
					case 'BQC':
						if((hs == 0 || hs) && (gs == 0 || gs)&&(hhs == 0 || hhs) && (hgs == 0 || hgs)){
							if(hs == '-1' && gs == '-1' && hhs == '-1' && hgs == '-1'){
								str=''
							}else if(hs>gs && hhs>hgs){
								str='胜胜'
							}else if(hhs>hgs && hs==gs){
								str='胜平'
							}else if(hhs>hgs && hs<gs){
								str='胜负'
							}else if(hhs==hgs && hs>gs){
								str='平胜'
							}else if(hhs==hgs && hs==gs){
								str='平平'
							}else if(hhs==hgs && hs<gs){
								str='平负'
							}else if(hhs<hgs && hs>gs){
								str='负胜'
							}else if(hhs<hgs && hs==gs){
								str='负平'
							}else if(hhs<hgs && hs<gs){
								str='负负'
							}else{
								str='--'
							}
						}else{
							str='--'
						}
						break;
					case 'JQS':
						if(hs == '-1' && gs == '-1' && hhs == '-1' && hgs == '-1'){
							str=''
						}else if((hs == 0 || hs) && (gs == 0 || gs)){
							str=''+(hs+gs)+''
						}else{
							str='--'
						}
						break;
					case 'CBF':
						if(hs == '-1' && gs == '-1' && hhs == '-1' && hgs == '-1'){
							str=''
						}else if((hs == 0 || hs) && (gs == 0 || gs)){
							str=''+hs+":"+gs+''
						}else{
							str='--'
						}
						break;
					}
				}
				
				return str
			},
			//投注玩法
			checkPlayName:function(type,re){
				var str = "";
				if(type=="SPF" && re!=""){
					if(re==3){
						str="主胜"
					}else if(re==1){
						str="平"
					}else if(re==0){
						str="客胜"
					}
				}else if(type=="RQSPF" && re!=""){
					if(re==3){
						str="让胜"
					}else if(re==1){
						str="平"
					}else if(re==0){
						str="让负"
					}
				}else if(type=="JQS" && re!=""){
					str=re;
				}else if(type=="CBF" && re!=""){
					if(re=="9:0"){
						str="胜其他"
					}else if(re=="0:9"){
						str="负其他"
					}else if(re=="9:9"){
						str="平其他"
					}else{
						str=re;
					}
				}else if(type=="BQC" && re!=""){
					var reArr = re.split("-");
					str=results[reArr[0]]+""+results[reArr[1]]
				}
				return str;
			},
			//跟买用户列表
			followUser:function(){
				var html="";
				var data={
						"newValue":hid,
						"pn":1,
						"ps":5,
				};
				$.ajax({
					url:"/user/queryGodFollowList.go",
					data:data,
					dataType:"xml",
					success:function(xml){
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						
						var baseInfo = R.find("baseInfo");
						var tmoney = baseInfo.attr("tmoney");
						var followNum = baseInfo.attr("followNum");
						if(tmoney && followNum){
							$("#followInfo").html('当前已有'+followNum+'人跟买，累计跟买'+tmoney+'元')
							$("#btn2").html("跟买用户("+followNum+")");
						}else{
							$("#followInfo").html('当前已有0人跟买，累计跟买0元')
							$("#btn2").html("跟买用户");
						}
						
						
						var followlist = R.find("followlist");
						
						
						var followUser  = followlist.find("followUser ");
						var t = followUser.length
						//t=0
						if(t){
							followUser.each(function(i,v){
								var uid = $(this).attr("uid");
								var buymoney = $(this).attr("buymoney");
								var addtime = $(this).attr("addtime");
								var imgUrl = $(this).attr("imgUrl");
								var bonus=$(this).attr("bonus");
								
								bonus>0 && $("#tt_hid span:eq(2)").html("奖金")
								html+='<li class="line_gray">'
								html+='<div class="div1">'
								if(imgUrl){
									html+='<img src="'+imgUrl+'">'
								}else{
									html+='<img src=/sdjc/img/zwtp.png>'
								}
								html+='<span>'+uid+'</span></div>'
								html+='<div class="div2">'+buymoney+'元</div><div class='+(bonus>0?"red":"div3")+'>'+(bonus>0?(bonus+'元'):addtime)+'</div>'
								html+='</li>'
							})
							if(parseInt(t)==5){
								html+='<a href=/sdjc/user_list.html?loc='+hid+'  class=myMore id=mymore style=border-bottom: none;>查看更多</a>'
							}
							$("#user_list").html(html)
						}else{
							$('#followInfo').hide();
							$('#tt_hid').hide();
							$("#user_list").html('<div class="empty_user"><p>暂无跟买用户</p></div>')
						}
					}
				})
			},
			SomeDsd:function(){
				var data = {hid: hid,mtype:(shareUserId?'4':'')};
				$.ajax({
					url: '/trade/queryOtherItem.go',
					data:data,
					dataType: 'XML',
					type:'POST',
					success:function(xml){
						var R = $(xml).find('Resp');
						var code= R.attr('code');
						if(code == '0'){
							var shareItems = R.find('shareItems');
							var shareItem = shareItems.find('shareItem');
							if(shareItem.length > 0){
								$('.about_more').show();
								var html = '';
									shareItem.each(function(a,b){
										var realUid = $(this).attr('realUid');
										var projid = $(this).attr('projid');
										var endtime = $(this).attr('endtime');
										var tmoney = $(this).attr('tmoney');
										var averageMoney = $(this).attr('averageMoney');
										var wrate = $(this).attr('wrate');
										var matchNum = $(this).attr('matchNum');
										var guoguan = $(this).attr('guoguan').replace(/\,/g," ").replace(/1串1/g,'单关');
										var usernum = $(this).attr('usernum');
										var nickid = $(this).attr('nickid');
										html += '<li class="clearfix" projid ='+projid+'><div class="jcds_dsblit clearfix">'
										html += '<p class="jcds_dsbp3">'+endtime+'截止</p></div>';
										html += '<div class="jcds_dsblic clearfix"><p class="jcds_dsbp4">'+o.cuter2(tmoney)+'元</p>';
										html += '<p class="jcds_dsbp5"><em>起投</em><span>'+o.cuter2(averageMoney)+'元</span><i>打赏'+wrate+'</i></p></div>'
										html += '<div class="jcds_dsblib clearfix"><p class="jcds_dsbp6">发单人购买</p>'
										html += '<p class="jcds_dsbp7">'+matchNum+'场 '+guoguan+'</p>';
										if(usernum != 0){
											html += '<p class="jcds_dsbp8">'+usernum+'人跟买</p></div>';
										}
										html += '</li>' 
									})
									$('.jcds_dsbul').html(html);
								}else{
									$('.jcds_dsbul').html('<div class="empty_user"><p>暂无进行中方案</p></div>')
								}
								
							}
							
						}
					
				})
			},
			bindEvent:function(){
				$("#reduce").bind("click",function(){
					//获取起头金额
//					var averageMoney = parseInt($("#averageMoney").html());
					var averageMoney = SD.averageMoney
					var val = parseInt($("#bs").val());
					val--;
					if(val < 1){
						val=1
						$('.buy_btn').removeAttr('disabled');
						$('.buy_btn').css({'background':'rgb(255,85,46)'})
					}
					$("#bs").val(val);
					$("#pMoney").html(averageMoney*parseInt(val)+"元")
				});
				
				$("#plus").bind("click",function(){
					//获取起头金额
//					var averageMoney = parseInt($("#averageMoney").html());
					var averageMoney = SD.averageMoney
					var val = parseInt($("#bs").val());
					val++;
					if(val>9999){
						val = 9999
						$("#bs").val(9999)
					}
					$("#bs").val(val);
					if(val >= 1){
						$('.buy_btn').removeAttr('disabled');
						$('.buy_btn').css({'background':'rgb(255,85,46)'})
					}
					$("#pMoney").html(averageMoney*parseInt(val)+"元")
				});
				$('#bs').bind('input propertychange' , function(){
					//获取起头金额
//					var averageMoney = parseInt($("#averageMoney").html());
					var averageMoney = SD.averageMoney
					var val = $("#bs").val();
					var reg = /^[0-9]+$/g
					if(!reg.test(val)){
						$("#bs").val('');
						$('.buy_btn').attr('disabled','true');
						$("#pMoney").html(0+'元')
						$('.buy_btn').css({'background':'#eee'})
					}else{
						if(val > 0 && val <= 9999){
							$('.buy_btn').removeAttr('disabled');
							$('.buy_btn').css({'background':'rgb(255,85,46)'})
							$("#pMoney").html(averageMoney*parseInt(val)+"元")
						}else if(val == 0){
							$('.buy_btn').attr('disabled','true');
							$("#pMoney").html(0+'元')
							$('.buy_btn').css({'background':'#eee'})
						}else if(val > 9999){
							$("#bs").val(9999);
							alert('最大可选择9999倍')
							val = 9999;
							$("#pMoney").html(averageMoney*parseInt(val)+"元")
						}
					}
				})
				$(".buy_btn").bind("click",function(){
					CP.Checked(function(){
						dopay()
					},false);	
				})
				var tabsSwiper = new Swiper('.swiper-container1',{
					autoHeight:true,
				    onSlideChangeStart: function(){
				      $(".tab_title .active").removeClass('active')
				      $(".tab_title span").eq(tabsSwiper.activeIndex).addClass('active')  
				    }
				  })
				  $(".tab_title span").on('touchstart mousedown',function(e){
				    e.preventDefault()
				    $(".tab_title .active").removeClass('active')
				    $(this).addClass('active')
				    
				    tabsSwiper.slideTo( $(this).index())
				    if($(this).index() == 0){
				    	var h1 = $('#info').height();
				    	$('#swip_inse ').css('height',h1);
				    }else{
				    	var h1 = $('#sec').height();
				    	$('#swip_inse ').css('height',h1);
				    }
				  })
				  $(".tab_title span").click(function(e){
				    e.preventDefault()
				  })
				  $('.jcds_dsbul').delegate('li', 'click' ,function(){
					  var projid = $(this).attr('projid');
					  if(fflag){
						  if(shareUserId){
							  if(agentFrom){
								  location.href = '/sdjc/buy.html?hid='+projid+'&agentFrom='+agentFrom+'&fflag='+fflag+'&shareUserId='+shareUserId;
							  }else{
								  location.href = '/sdjc/buy.html?hid='+projid+'&fflag='+fflag+'&shareUserId='+shareUserId;
							  } 
						  }else{
							  if(agentFrom){
								  location.href = '/sdjc/buy.html?hid='+projid+'&agentFrom='+agentFrom+'&fflag='+fflag;
							  }else{
								  location.href = '/sdjc/buy.html?hid='+projid+'&fflag='+fflag;
							  } 
						  } 
					  }else{
						  if(agentFrom){
							  location.href = '/sdjc/buy.html?hid='+projid+'&agentFrom='+agentFrom
						  }else{
							  location.href = '/sdjc/buy.html?hid='+projid; 
						  }
					  }
					  
					  
				  })
			},
			
			init: function(){
				$("#gameType").html(tname)
				this.gain();
				this.followUser();
				this.SomeDsd();
				this.bindEvent();
				//$(".tab_title span:eq(0)").click();
			}
	}
	
	return o
})()

var CP = {};
var t = {}


/*拼凑购买弹窗需要的参数[[*/
var dopay = function(a){
	var data = {//支付弹框参数
			"comboid": hid,//套餐
			"gid":     gid,//彩种id
			"cMoney":  parseInt($("#pMoney").html()),//需支付金额
			"muli": parseInt($("#bs").val()),
			"payUrl": '/trade/fgpcast.go',
			'source':	3002,
			'shareUserId': shareUserId,
			'fflag':fflag,
			'cupacketid': '',
			'redpacket_money': ''
	};
	alert('提交中，请稍后！','loading');

	CP.info(function(options){
		remove_alert();
		if (options) {jQuery.extend(data, options);}
		CP.Popup.buybox(data);
	});
}
CP.Checked = function(fn,bool){
	$.ajax({
		url:'/user/query.go?flag=2',
		type:'GET',
		dataType:'xml',
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			var isBindIdCard = R.find('row').attr('idcard');
			var isBindMobile = R.find('row').attr('mobbind');
			if(c == '0'){
				if(!bool){
					if(!isBindIdCard){
						location.href = '/alone/idcard.html';
					}else if(isBindMobile != '1'){
						location.href = '/alone/phone.html';
					}else{
						fn();
					}
				}else{
					fn();
				}
			}else{
				alert("购买套餐前请先登录账户")
				//location.href = '/#type=fun&fun=CP.Home.openLogin'
				if(agentFrom){
					location.href="login.html?agentFrom="+agentFrom;
				}else{
					location.href="login.html"
				}
				
			}
		},error : function () {
			remove_alert();
			alert('网络异常请刷新重试');
		}
	})
}

CP.info=function(fn){
	var obj={};
	$.ajax({
		url:'/user/query.go?flag=6',
		type:'GET',
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			if(c == '0'){
				var r = R.find('row');
				obj.usermoney = r.attr('usermoeny');//余额
				obj.ipacketmoney = r.attr('ipacketmoney');//红包余额
				typeof fn=="function"?fn(obj):""
			}
		},
		error : function () {
			remove_alert();
			alert('网络异常请刷新重试');
		}
	});
}
/*
 * 弹窗类
 */
CP.Popup = {
		/*
		 * 购买弹窗
		 */
		buybox : function(options){
			var o = {//弹窗的参数初始化
					comboid:       '',
					gid:           '',//彩种id 不可空
					muli: 		   '',
					cMoney:        '',//需支付金额 不可空
					bonus:         '',//理论奖金
					usermoney:     parseFloat(t.usermoney),//账户余额 不可空
					payPara:		'',
					source:		''
			};
			if (options) {
				//o.usermoney = parseFloat(t.usermoney);
				jQuery.extend(o, options);//后面补充前面不足
			} else {
				alert('参数获取异常！');
				return
			}
			if(!o.gid || !o.cMoney || !o.usermoney){
				alert('参数获取失败请刷新重试');
				return
			}
			var main = function(o){
				var tag = true;//是否充值的标识 默认去充值
				o.cMoney = parseFloat(o.cMoney);
				if (o.usermoney>=o.cMoney) {//余额不足的时候显示去充值
					tag = false;
					$('#buy .zfTrue a:eq(1)').hide().siblings().show();
				} else {
					$('#buy .zfTrue a:eq(2)').hide().siblings().show();
				}
				$('#buy_reveal p:eq(0) cite').html(o.cMoney+'元');//初始化投注金额
				if(o.bonus){//如果是竞彩显示奖金范围
					$('#buy_reveal p:eq(1)').hide();
				}else{
					$('#buy_reveal p:eq(1)').hide();
				}
				remove_alert();
				$('#buy_reveal p:eq(2) cite').html(o.usermoney+'元');//初始化余额
				$('#buy,#mask').show();//弹支付框
				$('#buy').animate({'margin-top':'-'+$('#buy').height()/2+'px'});//使层垂直居中
				$('.zfTrue a:eq(0)').off('click').on('click',function(){//取消按钮
					$('.zfpop,#mask').hide();
				})
				$('.zfTrue a:eq(1)').off('click').on('click',function(){//充值按钮
					window.location.href='/#type=url&p=user/charge.html';
					$('.zfpop,#mask').hide();
				})
				$('.zfTrue a:eq(2)').off('click').on('click',function(){//确定按钮
					$('.zfpop,#mask').hide();
					CP.Pay.init(o);//支付方法
				})
			}
			main(o);
		}
};
//支付
CP.Pay = function () {
	var init = function (opt) {
		var data = {};
			data = {
					"hid":   opt. comboid,//套餐
					"gid":     opt.gid,//彩种编号
					"money":    opt.cMoney,//号码
					'muli':     opt.muli,
					'shareUserId':   opt.shareUserId,
					'fflag':    opt.fflag,
					'source':	opt.source
			};
		$.ajax({
			url: opt.payUrl,
			type:'POST',
			data: data,
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
						var projid = '';
						var r;
						r = R.find('result ');
						projid = r.attr('projid');//方案编号
						location.href='/#type=url&p=user/success.html?projid='+projid+'&sdjc=1';
				}else{
					alert(desc);
				}	
			},
			error : function () {
				remove_alert();
				alert('网络异常请刷新重试');
			}
		});
	};
	return {
		init: init
	};
}();

SD.init();

var appRet = function(scheme,pageid,extend){
	var config = {
            scheme_IOS: 'caiyi9188Lotterynomal',
            scheme_Adr: 'lotterystartapp',
            download_url: 'http://t.9188.com  /',
            timeout: 1000
        };
	var now = Date.now();
    var ifr = $('.head_btn');
    var typefrom = location.search.getParam("type_from");
    if(browser.versions.android && typefrom == 'android'){
    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(browser.versions.ios && typefrom == 'ios'){
    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(typefrom == 'android' && browser.versions.ios){
    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(typefrom == 'ios' && browser.versions.android){
    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(browser.versions.android){
    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(browser.versions.ios){
    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid+'&extend='+extend)
    }
    var t = setTimeout(function() {
        var endTime = Date.now();
        if (Date.now() - now < config.timeout+800){
        		window.location.href= config.download_url; 
        }
    }, config.timeout);
}
$(function(){
//	下载头部

	$('.head_btn').bind('click' , function(){
		try{
			var page = location.search.getParam("page");
			if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 ){//微信
    			showDownload();
            }else{
            	appRet(page,34,hid);
            }
		}catch(e){}
	})
	/*$('.table_icon').bind('click' , function(){
		$('#mask').hide();
	})*/
	document.addEventListener('touchmove', function(event){ //微信出现遮罩层后禁止冒泡
        		/* document.documentElement.style.height = window.innerHeight + 'px'; */
        		if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 && ($("#downloadDiv").css('display') == 'block')){
        			var ev = event || window.event;
   				 	ev.preventDefault();
   				 	document.body.style.overflow=" hidden";
            	}
	})
})

