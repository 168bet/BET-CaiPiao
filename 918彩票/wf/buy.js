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
				'90':['竞彩-让球', 'jczq', '1'],
				'91':['竞彩-比分', 'jczq', '1'],
				'92':['竞彩-半全场', 'jczq', '1'],
				'93':['竞彩-总进球', 'jczq', '1'],
				'70':['竞彩-混投', 'jczq', '1'],
				'72':['竞彩-胜平负', 'jczq', '1'],
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



//玩法类型
var playType={
		"SPF":"胜平负",
		"RQSPF":"让球",
		"JQS":"总进球",
		"CBF":"猜比分",
		"BQC":"半全场"
}

var hid = location.search.getParam("hid");
var gid = hid.substring(0,2);
var agentFrom = location.search.getParam("agentFrom");

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
			gain: function(){
				
				$.ajax({
					url:'/trade/godShareDetail.go?hid='+hid,//70DG2016102662723016  70DG2016102562722892  70DG2016102762723104
					type:'POST',
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
						var userNum = itemdetail.attr("userNum");//跟投人数
						var projState = itemdetail.attr("projState");//方案状态
						
						//projState=0
						
						if(projState==1){//方案进行中
							$("#buy_box").show();
							$("#end").hide();
						}else {//方案已截止
							$("#buy_box").hide();
							$("#end").show();
						}
						var godDetail = R.find("godDetail");
						var nickid = godDetail.attr("nickid");//分享人
						var uptype = godDetail.attr("uptype");//上榜几日类型
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
						if(isGod==1){//是大神
							$("#nickidContent").show()
						}else{
							$("#nickidContent").hide()
						}
						$("#tmoney").html(tmoney+'元');//发起人投注金额
						if(projState==1){
							$("#endtime").html(endtime+'截止');//截止时间
						}else{
							$("#endtime").html(endtime+'已截止');//截止时间
						}
						$("#averageMoney").html(averageMoney+"元");//起投金额
						$("#wrate").html('打赏'+wrate)//打赏比例
						$("#nickid").html(nickid)//发起人名称
						$("#imgUrl").attr("src",imgUrl);
						
						$("#pMoney").html(averageMoney+"元");
						$("#fdwrate").html(wrate);
						var infohtml="";
						
						infohtml+='<div class="swiper-wrapper" id="">'
						
						
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
						infohtml+='<div class="swiper-pagination"></div>'
						$("#nickidContent").html(infohtml)	
						var swiper = new Swiper('.swiper-container', {
								pagination: '.swiper-pagination',
								paginationClickable: true,
								loop : true,
								autoplayDisableOnInteraction : false,
								autoplay : 3000,
								speed:300
						});
						
						
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
						var gg ="" ;
							gg = rows.attr("gg")||"";//过关方式
						var minRatio = rows.attr("minRatio");
						var ipay = rows.attr("ipay");
						var upay = rows.attr("upay");
						var shareGod = rows.attr("shareGod");
						var sharedNickid = rows.attr("sharedNickid");
						var hideSharedNickid = rows.attr("hideSharedNickid");
						var visible = rows.attr("visible");
						var jindu = rows.find("jindu");
						var jjyh = rows.find("jjyh")||"";
						
						var tt_;
						if(jjyh && jjyh!="1"){
							var matchs  = rows.find('matchs ')
							var detail = rows.find("detail")
							gg = detail.attr("gg");
							gg = gg.replace(/\*/g, "串").replace(/1串1/g, "单关");
							tt_ = matchs.find("row ");
						}else{
							var tt_ = rows.find('row')
						}
						
						console.log(tt_.length);
						var html = '';
						if(tt_.length){
							tt_.each(function(i ,v ){
	//							id="161025001" name="周二001" hn="墨尔本胜利" 
	//							gn="墨尔本城" hs="" gs="" hhs="" hgs="" 
	//							lose="1" isdan="0" jsbf="" 
	//						ccodes="HH|SPF=3_2.67,SPF=1_3.45,RQSPF=0_4.35,JQS=2_3.95"
								//ccodes="BQC|3-0_25.00+CBF|5:2_80.00,0:5_400.0"
								
								var id = $(this).attr('id');//
								var name = $(this).attr('name');//
								var hn = $(this).attr('hn');//
								var gn = $(this).attr('gn');//
								var hs = $(this).attr('hs');//
								var gs = $(this).attr('gs');//
								
								var hhs = $(this).attr('hhs');//
								var hgs = $(this).attr('hgs');//
								var lose = $(this).attr('lose')||$(this).attr('close');//
								var isdan = $(this).attr('isdan');//
								var jsbf = $(this).attr('jsbf');//
								var ccodes = $(this).attr('ccodes');//
								
								var rq = '';//让球样式
								if(lose!=0 && lose !=""){
									if(lose.indexOf('-')!=-1){
										rq="(<font color='green'>"+lose+"</font>)";
									}else{
										rq="(<font color='red'>"+lose+"</font>)";
									}
								}
								
								//是否设胆
								var dan="";
								if(isdan==1){
									dan='<span class="span14">胆</span>'
								}
							
	//							hhs=2,hgs=1,hs=3,gs=4;
								
								var tmp = ccodes.split()
								var obj = {}
								//ccodes="HH|SPF=3_2.67,SPF=1_3.45,RQSPF=0_4.35,JQS=2_3.95" 串关
								//ccodes="BQC|3-0_25.00    +      CBF|5:2_80.00,0:5_400.0" 
								//ccodes="SPF|3_5.70,1_3.85"
								if(showCode=="true"){
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
									}else {//ccodes="SPF|3_5.70,1_3.85"
										var ccodes2 = ccodes.split("|");
										obj[ccodes2[0]]=ccodes2[1].split(",");
									}
									
									
									console.info(obj)
									html += '<tr>\
										<td class="width1" rowspan="'+(o.length(obj)+1)+'"><p>'+name.substring(0,2)+'</p><p>'+name.substring(2,name.length)+'</p></td>\
										<td class="width2"><p class="c_gray">'+hn+rq+' VS '+gn+dan+'</p></td>\
										<td class="width3">半'+((hhs==""&&hgs=="")?"--":hhs+':'+hgs)+'/全'+((hs==""&&gs=="")?"--":hs+':'+gs)+'</td>\
										</tr>'
									for(var i in obj){
										var obj2 = obj[i]
										//console.log(obj2)
										html+='<tr>'
										if(obj2.length>1){
											html += '<td align="left">'
											for(var j = 0; j<obj2.length; j++){
												var type = obj2[j].split('_')[0]
												html+='<span>'+playType[i]+':'+o.checkPlayName(i,type)+'('+obj2[j].split('_')[1]+')</span><br />'
											}
											html += '</td>'
										}else{
											var type=obj2[0].split('_')[0]
											html+='<td align="left"><span>'+playType[i]+':'+o.checkPlayName(i,type)+'('+obj2[0].split('_')[1]+')</span></td>'
										}
										
										html+='<td>'
											html+=o.checkResult(i,hs,gs,hhs,hgs,lose)
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
										html+='<td><p>周一</p><p>001</p></td>'
										html+='<td><p class="c_gray">'+hn+rq+' VS '+gn+dan+'</p></td>'
										html+='</tr>'
									}
								}
								
							})
								html +='<tr><td colspan="3"  class="width4"><p>过关方式：'+gg+'</p></td></tr>'
						}else{
							html = '<div class="empty_user"><p>暂无内容</p></div>'
						}
						
						$('#bettingInfo').html(html);
						var tabsSwiper = new Swiper('.swiper-container1',{
							autoHeight: true,
						    onSlideChangeStart: function(){
						      $(".tab_title .active").removeClass('active')
						      $(".tab_title span").eq(tabsSwiper.activeIndex).addClass('active')  
						    }
						  })
						$(".table_icon").bind("click",function(){
							$('#mask').show();
							$('#queren').show();
						})
						$('#mask').bind('click touchmove' , function(event){
							event.stopPropagation();
							$('#mask').hide();
							$('#queren').hide();
						})
						$('.ok').bind('click touchstart' , function(event){
							event.stopPropagation();
							$('#mask').hide();
							$('#queren').hide();
						})
						
					},
					error:function(){
						alert("网络异常")
					}
					
					
				})
			},
			//比分/彩果
			checkResult:function(type,hs,gs,hhs,hgs,lose){
				var hs=Number(hs)
				var gs=Number(gs)
				var hhs=Number(hhs)
				var hgs=Number(hgs)
				var lose=Number(lose)
				var str='';
				switch (type) {
				case 'SPF':
					if(hs>gs){
						str='<label>主胜</label>';
					}else if(hs==gs){
						str='<label>平</label>'
					}else if(hs<gs){
						str='<label>客胜</label>'
					}else{
						str='<label>--</label>'
					}
					break;
				case 'RQSPF':
					if((hs == 0 || hs) && (gs == 0 || gs)){
						if(lose>0){
							if(hs+lose>gs){
								str='<label>让胜</label>'
							}else if(hs+lose==gs){
								str='<label>让平</label>'
							}else if(hs+lose<gs){
								str='<label>让负</label>'
							}else{
								str='<label>--</label>'
							}
						}else if(lose<0){
							lose = Math.abs(lose);
							if(hs-lose>gs){
								str='<label>让胜</label>'
							}else if(hs-lose==gs){
								str='<label>让平</label>'
							}else if(hs-lose<gs){
								str='<label>让负</label>'
							}else{
								str='<label>--</label>'
							}
						}
					}else{
						str='<label>--</label>'
					}
					break;
				//胜胜，胜平，胜负,平胜，平平，平负，负胜，负平，负负
				case 'BQC':
					if((hs == 0 || hs) && (gs == 0 || gs)&&(hhs == 0 || hhs) && (hgs == 0 || hgs)){
						if(hs>gs && hhs>hgs){
							str='<label>胜胜</label>'
						}else if(hhs>hgs && hs==gs){
							str='<label>胜平</label>'
						}else if(hhs>hgs && hs<gs){
							str='<label>胜负</label>'
						}else if(hhs==hgs && hs>gs){
							str='<label>平胜</label>'
						}else if(hhs==hgs && hs==gs){
							str='<label>平平</label>'
						}else if(hhs==hgs && hs<gs){
							str='<label>平负</label>'
						}else if(hhs<hgs && hs>gs){
							str='<label>负胜</label>'
						}else if(hhs<hgs && hs==gs){
							str='<label>负平</label>'
						}else if(hhs<hgs && hs<gs){
							str='<label>负负</label>'
						}else{
							str='<label>--</label>'
						}
					}else{
						str='<label>--</label>'
					}
					break;
				case 'JQS':
					if((hs == 0 || hs) && (gs == 0 || gs)){
						str='<label>'+(hs+gs)+'</label>'
					}else{
						str='<label>--</label>'
					}
					break;
				case 'CBF':
					if((hs == 0 || hs) && (gs == 0 || gs)){
						str='<label>'+hs+":"+gs+'</label>'
					}else{
						str='<label>--</label>'
					}
					break;
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
							$("#followInfo").html('当前'+followNum+'人已跟买，累计跟买'+tmoney+'元')
							$("#btn2").html("跟买用户("+followNum+")");
						}else{
							$("#followInfo").html('当前0人已跟买，累计跟买0元')
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
								html+='<li class="line_gray">'
								html+='<div class="div1">'
								if(imgUrl){
									html+='<img src="'+imgUrl+'">'
								}else{
									html+='<img src=/sdjc/img/zwtp.png>'
								}
								html+='<span>'+uid+'</span></div>'
								html+='<div class="div2">'+buymoney+'元</div><div class="div3">'+addtime+'</div>'
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
			bindEvent:function(){
				$("#reduce").bind("click",function(){
					//获取起头金额
					var averageMoney = parseInt($("#averageMoney").html());
					var val = $("#bs").val();
					val--;
					if(val<0){
						val=0
					}
					$("#bs").val(val);
					if(val == 0){
						$('.buy_btn').attr('disabled','true');
						$('.buy_btn').css({'background':'#eee'})
					}
					$("#pMoney").html(averageMoney*parseInt(val)+"元")
				});
				
				$("#plus").bind("click",function(){
					//获取起头金额
					var averageMoney = parseInt($("#averageMoney").html());
					var val = $("#bs").val();
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
					var averageMoney = parseInt($("#averageMoney").html());
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
					CP.Checked();	
				})
			},
			
			init: function(){
				$("#gameType").html(tname)
				this.gain();
				this.followUser();
				this.bindEvent();
				
			}
	}
	
	return o
})()

var CP = {};
var t = {}


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
/*拼凑购买弹窗需要的参数[[*/
var dopay = function(a){
	var data = {//支付弹框参数
			"comboid": hid,//套餐
			"gid":     gid,//彩种id
			"cMoney":  parseInt($("#pMoney").html()),//需支付金额
			"muli": parseInt($("#bs").val()),
			"payUrl": '/trade/fgpcast.go'
	};
	alert('提交中，请稍后！','loading');
	CP.Popup.buybox(data);
}
CP.Checked = function(){
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
				if(!isBindIdCard){
					location.href = '/alone/idcard.html';
				}else if(isBindMobile != '1'){
					location.href = '/alone/phone.html';
				}else{
					dopay();
				}
			}else{
				alert("购买套餐前请先登录账户")
				//location.href = '/#type=fun&fun=CP.Home.openLogin'
				location.href="login.html?agentFrom="+agentFrom;
			}
		},error : function () {
			remove_alert();
			alert('网络异常请刷新重试');
		}
	})
}

CP.info=function(){
	$.ajax({
		url:'/user/query.go?flag=6',
		type:'GET',
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			if(c == '0'){
				var r = R.find('row');
				t.usermoney = r.attr('usermoeny');//余额
				t.ipacketmoney = r.attr('ipacketmoney');//红包余额
			}
		},
		error : function () {
			remove_alert();
			alert('网络异常请刷新重试');
		}
	});
}()
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
					usermoney:     '',//账户余额 不可空
					payPara:		'',
			};
			if (options) {
				o.usermoney = parseFloat(t.usermoney);
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
					'muli':     opt.muli
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
			}
		});
	};
	return {
		init: init
	};
}();

SD.init();
var browser={
	    versions:function(){
	        var u = navigator.userAgent, app = navigator.appVersion;
	        return {
	        	trident: u.indexOf('Trident') > -1, //IE内核
	            presto: u.indexOf('Presto') > -1, //opera内核
	            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
	            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,//火狐内核
	            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
	            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
	            android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1 || u.indexOf('Linux') > -1, //android终端
	        };
	    }(),
}
var showDownload=function(){
    if(!$("#downloadDiv").length){	
    	var ua = navigator.userAgent;
        var _d = document;
        var _b = _d.body;
        
        var downloadDiv = _d.createElement("div");
        downloadDiv.setAttribute("id","downloadDiv");
        _b.appendChild(downloadDiv);
        
        $(downloadDiv).addClass("download_android");
        
       if(ua.indexOf('Android') > -1 || ua.indexOf('Linux') > -1){ //android
    	   $(downloadDiv).addClass("download_android");
        } else if(ua.indexOf('iPhone') > -1 || ua.indexOf('iPad') > -1 || ua.indexOf('iPod') > -1){ // ios
        	 $(downloadDiv).addClass("download_iphone");
        }
        
    }
    $("#downloadDiv").fadeIn(function(){
        $(this).bind("click touchstart",function(){
            $(this).fadeOut();
        });
    });
}
var appRet = function(scheme,pageid,extend){
	var config = {
			 /*scheme:必须*/
            scheme_IOS: 'caiyi9188Lottery15697game',
            scheme_Adr: 'lotterystartapp',
            download_url: 'http://t.9188.com  /',
            timeout: 1000
        };
	var now = Date.now();
    var ifr = $('.head_btn');
    var typefrom = location.search.getParam("type_from");
//    alert(typefrom +' '+ browser.versions.ios + " "+(location.search.getParam("page")));
    if(browser.versions.android && typefrom == 'android'){
    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(browser.versions.ios && typefrom == 'ios'){
    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(typefrom == 'android' && browser.versions.ios){
    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(typefrom == 'ios' && browser.versions.android){
    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid+'&extend='+extend)
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
	if(!(location.search.getParam("source"))){
		$('#heah_h').addClass('height_h');
		$('.head_load').show();
	}
	$('.head_close').bind('click' ,function(){
		$('#heah_h').removeClass('height_h');
		$('.head_load').hide();
	})
	$('.head_btn').bind('click' , function(){
		try{
			var page = location.search.getParam("page");
			if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 ){//微信
    			showDownload();
            }else{
            	page && (appRet(page,34,hid));
            }
		}catch(e){}
	})
	$('.table_icon').bind('click' , function(){
		$('#mask').hide();
	})
	document.addEventListener('touchmove', function(event){ //微信出现遮罩层后禁止冒泡
        		/* document.documentElement.style.height = window.innerHeight + 'px'; */
        		if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 && ($("#downloadDiv").css('display') == 'block')){
        			var ev = event || window.event;
   				 	ev.preventDefault();
   				 	document.body.style.overflow=" hidden";
            	}
	})
})

