var CP = CP || {};
var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
var end_ev = ('ontouchend' in window ) ? 'touchend' : 'mouseup';
var move_ev = ('ontouchend' in window ) ? 'touchmove' : 'mousemove';
//公用弹出层和加载层
var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 1e3);
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
/**
 * @description 获取数据类型
 * @author lilian
 * @return {String} 如：null
 */
CP.getType = function (o) {
	var _t;
	return ((_t = typeof(o)) == "object" ? o == null && "null" || Object.prototype.toString.call(o).slice(8, -1) : _t).toLowerCase();
};
/*
 * 用户状态、信息
 */
CP.User = {
		//查询用户登录名、用户余额、冻结款、用户类型
		info : function(fn){
			var t = {};
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
						fn(t);
					}else{
						alert('请先登录');
					}
				},error : function () {
					remove_alert();
					alert('网络异常请刷新重试');
				}
			});
		}
}
/*
 * 触屏版touch插件
 * @param {Object} [children:".ball",fun:function(){}];
 */
$.fn.Touch = function (obj) {
	var moveEvent = move_ev;
	if (CP.getType(obj) == 'function') {
		obj.fun = obj;
	}
	this.each(function () {
		var $dom = $(this).eq(0);
		var ifMove = false;
		var t = 0;
		$dom.on(moveEvent, function () {
			ifMove = true;
			clearTimeout(t);
			t = setTimeout(function () {
				ifMove = false;
			}, 250);
		});
		if (obj.children) {
			$dom.on(end_ev, obj.children, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return false;
				}
				obj.fun.call(this, this);
			});
		}
		else {
			$dom.on(end_ev, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return 0;
				}
				obj.fun.apply(this, [this, e]);
			});
		}
	});
};
/**
 * @description 获取手机系统
 * @return {object}
 * @example CP.MobileVer.android;
 * @memberOf CP
 */
CP.MobileVer = (function ($) {
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
var ios_ = location.search.getParam('lol') || false;//ios 判断版本 不为false调他们的充值页面 否则弹窗提示
CP.Popup = {
		/*
		 * 购买弹窗
		 */
		buybox : function(options){
			var o = {//弹窗的参数初始化
					gid:           '',//彩种id 不可空
					cMoney:        '',//需支付金额 不可空
					bonus:         '',//理论奖金
					usermoney:     '',//账户余额 不可空
					ipacketmoney:  '',//红包余额
					cupacketid:    '',//红包id
					redpacket_money: '',//使用红包金额
					ac : true//是否活动购买
			};
			if (options) {
				$.extend(o, options);
			} else {
				alert('参数获取异常！');
				return
			}
			if(!o.gid || !o.cMoney || !o.usermoney){
				alert('参数获取失败请刷新重试');
				return
			}
			var tag = true;//是否充值的标识 默认去充值
			o.usermoney = parseFloat(o.usermoney);
			o.cMoney = parseFloat(o.cMoney);
			if (o.usermoney>=o.cMoney) {//余额不足的时候显示去充值
				tag = false;
				$('#gocz').hide().siblings().show();
			} else {
				$('#isok').hide().siblings().show();
			}
			$('#buy_box').removeClass('zfpopCur');//默认隐藏红包列表层
			$('#tzmoney').html(o.cMoney+'元');//初始化投注金额
			if(o.bonus){//如果是竞彩显示奖金范围
				$('#bouns').html(o.bonus+'元');
			}else{
				$('#bouns').hide();
			}
			if(o.ipacketmoney == '0'){//木有红包的时候隐藏红包按钮
				$('#buy_reveal .popuseRed span').hide();
			}else{
				$('#buy_reveal .popuseRed span').show();
			}
			$('#yue').html(o.usermoney+'元');//初始化余额
			$('#buy_box,#mask').show();//弹支付框
			$('#buy_hide').html('');//清空红包列表
			$('#buy_box').animate({'margin-top':'-'+$('#buy_box').height()/2+'px'});//使层垂直居中
			
			$('#cancle').off().bind('click',function(){
				$('#buy_box,#mask').hide();
			});
			$('#gocz').off().bind('click',function(){//充值
				remove_alert();
				$('#buy_box').hide();
				var url = '/#class=url&xo=useraccount/recharge.html';
				if(location.host == '5.9188.com '){
					url = '/#type=url&p=user/charge.html';
				}
				if(CP.MobileVer.android){//android
					try {
						window.caiyiandroid.clickAndroid(7, '');//充值
					} catch (e){
						window.location.href = url;
					}
				}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
					if(!ios_){
						window.location.href = url;
					}else{
						try {
							WebViewJavascriptBridge.callHandler('callBackIOS','3');
						} catch (e){
							window.location.href = url;
						}
					}
				}else{//4g
					window.location.href = url;
				}
			});
			$('#isok').off().bind('click',function(){//确认购买
				o.cupacketid = '';o.redpacket_money = '';
				if (document.getElementById("buy_hide").style.display!='none' && $('#buy_hide div.cur').length) {
					if($('#buy_hide div.cur').attr('kymoney') != '0'){
						o.cupacketid = $('#buy_hide div.cur').attr('cptid');
						o.redpacket_money = $('#buy_hide div.cur').attr('kymoney');
					}
				}
				$('#buy_box,#mask').hide();
				CP.BFB.dobuy(o);
			});
			
			$('#redpack').off().bind('click',function(){//使用红包按钮
				$('#buy_box').toggleClass('zfpopCur');
				if($('#buy_box').hasClass('zfpopCur')){
					$('#buy_hide').html('<div style="padding:8px;"><em class="rotate_load" style="margin:auto"></em></div>');
					$.ajax({
						url:'/user/queryRpinfo.go',
						type:'post',
						dataType:'xml',
						data:{
							trade_gameid : o.gid,
							trade_imoney : o.cMoney,
							trade_isource:'0'
						},
						success:function(xml){
							var R = $(xml).find('rows');
							var r = R.find('row');
							if(r.length){//判断有木有红包可使用
								var html = '';
								r.each(function(i){
									var cptid = $(this).attr('cptid');//红包编号
									var crpname = $(this).attr('crpname');//红包名
									var irmoney = $(this).attr('irmoney');//红包余额
									var cddate = $(this).attr('cddate');//红包过期时间
									var kymoney = $(this).attr('kymoney');//可用红包
									kymoney = kymoney||'0';
									html += '<div kymoney="'+kymoney+'" cptid="'+cptid+'" class="clearfix pdLeft1 '+(i==0? 'cur' : 'pdTop1' )+'"><em class="left nocheck"></em><div class="redText">';
									html += '<p>【'+crpname+'】余额'+irmoney+'元，本次可用<cite class="red">'+kymoney+'元</cite></p><p class="pdTop03">过期时间：'+(cddate == '' ? '无限制':cddate)+'</p></div></div>';
								});
								$('#buy_hide').html(html);
								var rPack = parseFloat($('#buy_hide .cur').attr('kymoney'));
								if(tag){
									if((rPack + o.usermoney)>=o.cMoney){
										$('#gocz').hide().siblings().show();
									}
								}
							}else{
								$('#buy_hide').html('<div style="text-align:center;">您本次无红包可以使用</div>');
							}
						}
					});
				} else {
					if(tag){
						$('#isok').hide().siblings().show();
					}
				}
				$('#buy_box').animate({'margin-top':'-'+$('#buy_box').height()/2+'px'});
			});
			$('#buy_hide').off().delegate('.pdLeft1','click',function(){
				$(this).toggleClass('cur').siblings().removeClass('cur');
				var rPack = $('#buy_hide .cur').attr('kymoney');
				if(tag){
					if(rPack && (parseFloat(rPack) + o.usermoney)>=o.cMoney){
						$('#gocz').hide().siblings().show();
					}else{
						$('#isok').hide().siblings().show();
					}
				}
			});
		}
};
CP.BFB = (function($){
	var date1 = new Date().getTime();
	var g = {
			userName : '',//用户名
			yue : 0,//用户余额（含红包）
			date : '',//默认日期为空
			gid : '',//胜平负 72 让球90
			codes : '',
			itemid : '',
			bonus : ''//奖金范围
	};
	var BFBZJ = {};
	var o = {
			gain : function () {
				var allcookies = document.cookie;
				if(allcookies.indexOf('TOKEN')!='-1'){
					allcookies = allcookies.split('&');
					var token = '',appid = '';
					$.each(allcookies,function(index, val){
						if(val.indexOf('TOKEN=')>=0){
							token = val.split('TOKEN=')[1];
						}
						if(val.indexOf('APPID=')>=0){
							appid = val.split('APPID=')[1];
						}
					});
					$.ajax({
						url:'/user/swaplogin.go',
						data:{
							logintype:'1',
							accesstoken:token,
							appid:appid
						},
						type:'POST',
						success:function(){
							$.ajax({
								url:'/user/query.go?flag=6',
								type:'POST',
								dataType:'xml',
								success: function(xml) {
									var R = $(xml).find('Resp');
									var c = R.attr('code');
									if(c == '0'){//已登录
										var r = R.find('row');
										g.userName = r.attr('nickid');
										g.yue = parseFloat(r.attr('usermoeny'))+parseFloat(r.attr('ipacketmoney'));
										$('#hasLogin').show().find('em').html(g.userName);
										$('#noLogin').hide();
									}else{//未登录
										$('#noLogin').show();
										$('#hasLogin').hide();
									}
									o.against();
								}
							});
						}
					});
				}else{
					$.ajax({
						url:'/user/query.go?flag=6',
						type:'POST',
						dataType:'xml',
						success: function(xml) {
							var R = $(xml).find('Resp');
							var c = R.attr('code');
							if(c == '0'){//已登录
								var r = R.find('row');
								g.userName = r.attr('nickid');
								g.yue = parseFloat(r.attr('usermoeny'))+parseFloat(r.attr('ipacketmoney'));
								$('#hasLogin').show().find('em').html(g.userName);
								$('#noLogin').hide();
							}else{//未登录
								$('#noLogin').show();
								$('#hasLogin').hide();
							}
							o.against();
						}
					});
				}
			},
			/*渲染投注内容-*/
			render : function(opt_){
				var opt = BFBZJ[opt_];
				/* @param status
				 * 暂未参与，可立即参与  1
				 * 已参与，未截止       2
				 * 已参与，已截止 等待开奖      7
				 * 未参与，已截止 等待开奖 8
				 * 场次过期，未参与      3
				 * 已参与，且中奖        4
				 * 已参与，未中奖        5
				 * 当天无场次            6
				 */
				var Q = opt.status;
				if(Q != '6'){
					var _out = [];
					if(Q == '1' || Q == '2'){//当天的 可以选胜平负的
						/*判断显示让球还是不让球*/
						var isRQ = [];
						if((512 & opt.isale) > 0){//单关胜平负是否停售512
							isRQ.push('spf');
						}
						if((32 & opt.isale) > 0){//单关让球是否停售
							isRQ.push('rqspf');
						}
						if(isRQ.length > 0){//有开售的情况
							if(isRQ.length == 1){
								isRQ = isRQ.join('');
							}else if(isRQ.length == 2){//两个都开售比较sp 看谁的平滑
								var spfsp = opt.spf.split(',');//胜平负赔率
								var rqspfsp = opt.rqspf.split(',');//胜平负赔率
								if( (spfsp[2]-spfsp[0]) > (rqspfsp[2]-rqspfsp[0]) ){
									isRQ = 'rqspf';
								}else{
									isRQ = 'spf';
								}
							}
							$('#con').removeClass();
							var scale = [];//胜平负投注比例
							var sp = [];//胜平负赔率
							if(isRQ == 'spf'){
								g.gid = '72';
								scale = opt.spfscale.split(',');
								sp = opt.spf.split(',');
							}else{
								g.gid = '90';
								scale = opt.rqspfscale.split(',');
								sp = opt.rqspf.split(',');
							}
							g.itemid = opt.itemid;
							var z = parseInt(scale[0]);var p = parseInt(scale[1]);var k = parseInt(scale[2]);
							_out.push('<div class="gddgScroll"><div><cite>'+opt.hn+(isRQ=='rqspf'?'('+opt.close+')':'')+'</cite><i>vs</i><em>'+opt.gn+'</em></div><p>'+opt.mname+'&nbsp;'+opt.mt+'开赛</p></div>\
									<div class="gddgxhList">\
									<div class="gddghot">\
									<p><span><em>'+scale[0]+'人气</em><i v='+z+' style="height:0rem"></i></span></p>\
									<p><span><em>'+scale[1]+'人气</em><i v='+p+' style="height:0rem"></i></span></p>\
									<p><span><em>'+scale[2]+'人气</em><i v='+k+' style="height:0rem"></i></span></p>\
									</div>\
									<ul><li class="select"><span v='+sp[0]+' c=3>胜<i>'+(isRQ=='rqspf'?'('+opt.close+')':'')+'</i><cite>'+opt.hn+'</cite></span><span v='+sp[1]+' c=1>平<cite>双方</cite></span><span v='+sp[2]+' c=0>胜<cite>'+opt.gn+'</cite></span></li>\
									<li><em>赔率'+sp[0]+'</em><em>赔率'+sp[1]+'</em><em>赔率'+sp[2]+'</em></li></ul></div>\
									<div class="buy"><a href="javascript:;" class="cbuy gray" v='+Q+'>立即购买</a><p style="height:.7rem"></p>'+(isRQ=='rqspf'?'<u>胜(-1)/胜(+1)是什么？</u>':'')+'</div>');
							$('#con').html(_out.join('')).show();
							$('#nobs, #loading, #wait').hide();
						}else{//两个都停售
							$('#nobs').show();
							$('#con, #loading, #wait').hide();
						}
					}else if(Q == '3' || Q == '4' || Q == '5'){//历史的
						$('#con').addClass('nobs');
						var tu = '';
						if(g.userName != ''){
							tu = '<em class="tb '+(Q=='3'?'wcy':(Q=='4'?'yzj':'wzj'))+' scale_"></em>';	
						}
						var win = (opt.hs>opt.gs) && opt.h+'<em style="color:red">胜</em>' || (opt.hs == opt.gs && '<em style="color:red">打平</em>' || opt.g+'<em style="color:red">胜</em>');
						_out.push('<div class="notitle">历史赛果：'+win+'</div>'+tu+'\
								<div class="novs"><div><cite style="font-size:1.1rem">'+opt.hn+'</cite><i>'+opt.hs+'-'+opt.gs+'</i><em style="font-size:1.1rem">'+opt.gn+'</em></div><p>'+opt.mname+' 已完赛</p></div>\
								<div class="jion"><span>参与人数：<cite>'+(parseInt(opt.headcount)+500)+'</cite>人</span></div>');
						$('#con').html(_out.join('')).show();
						$('#nobs, #loading, #wait').hide();
					}else if(Q == '7' || Q == '8'){
						_out.push('<em class="wait"></em><div class="notitle">历史赛果：</div>\
								<div class="novs"><div><cite>'+opt.hn+'</cite><i>--：--</i><em>'+opt.gn+'</em></div></div>\
								<div class="jion"><span>参与人数：<cite>'+opt.headcount+'</cite>人</span></div>');
						$('#wait').html(_out.join('')).show();
						$('#nobs, #loading, #con').hide();
					}
					/*人气上升的效果*/
					setTimeout(function(){
						$('#con .gddghot').find('i').each(function(){
							var Q1 = $(this).attr('v') || '0';
							$(this).css({'height':(3*Q1/100)+'rem'});
						});
					},.2e3);
					/*人气上升的效果*/
				}else{
					$('#nobs').show();
					$('#con, #loading, #wait').hide();
				}
				if(document.getElementById("nobs").style.display!='none'){
					var info = '当天暂无比赛开售！';
					var t = opt_.replace(/-/g,'');
					if(parseInt(t)>20150203){
						info = '囧～活动已结束！';
					}
					$('#nobs span').html(info);
				}
			},
			/*-渲染投注内容*/
			against : function () {
				//活动场次信息读取
				$.ajax({
					url:'/activity/getcertainwin.go',
					data:{
						uid:decodeURIComponent(g.userName)
					},
					type:'POST',
					dataType:'xml',
					success: function(xml){
						var R = $(xml).find('Resp');
						var code = R.attr('code');
						if(code == '0'){
							var r = R.find('row');
							var Q = r.length;
							var out_ = [];
							r.each(function(aa){
								var t = {};
								t.status = $(this).attr('status');//是否有比赛 6木有比赛
								var adddate = $(this).attr('adddate');//比赛日期
								if(t.status != 6){
									t.mname = $(this).attr('mname');//英超
									t.itemid = $(this).attr('itemid');//141226010
									t.isale = $(this).attr('isale');//511
									t.h = $(this).attr('hn');//曼彻斯特联
									t.g = $(this).attr('gn');//纽卡斯尔联
									t.hn = t.h.substr(0,5);
									t.gn = t.g.substr(0,5);
									t.et = $(this).attr('et');//2014-12-26 22:40:00
									t.mt = $(this).attr('mt');//2014-12-26 23:00:00
									t.close = $(this).attr('close');//-1
									t.htid = $(this).attr('htid');//239
									t.gtid = $(this).attr('gtid');//200
									t.spf = $(this).attr('spf');//1.28,4.75,7.55
									t.rqspf = $(this).attr('rqspf');//1.86,3.65,2.97
									t.spfscale = $(this).attr('spfscale');//81.1%,12.1%,6.8%
									t.rqspfscale = $(this).attr('rqspfscale');//73.9%,23.7%,2.4%
									t.headcount = $(this).attr('headcount') || 'XXX';//参与人数
									t.status = $(this).attr('status');//1
									t.hs = $(this).attr('hs');//主队进球
									t.gs = $(this).attr('gs');//客队进球
								}
								var dateAlias = $(this).attr('dateAlias');//今天明天标识
								BFBZJ[adddate] = t;
								if(Q-aa>2){
									out_.push('<li mydata='+adddate+'>'+(dateAlias || adddate.substr(5,2)+'.'+adddate.substr(8,2))+'</li>');
								}else{//最后2个
									if(Q-aa == 2){//倒数第二个
										if(dateAlias == '今天'){//如果是今天
											if(t.status == '1' || t.status == '2'){//今天未截至
												out_.push('<li class="last" mydata='+adddate+'>今天</li>');
												Q--;
											}else{
												out_.push('<li mydata='+adddate+'>今天</li>');
											}
										}else{
											out_.push('<li mydata='+adddate+'>'+(dateAlias || adddate.substr(5,2)+'.'+adddate.substr(8,2))+'</li>');
										}
									}else if(Q-aa == 1){//倒数第一个
										if(dateAlias == '今天'){//如果最后一天是今天
											out_.push('<li class="last" mydata='+adddate+'>'+(dateAlias || '今天')+'</li>');
										}else{//明天
											Q--;
										}
									}
								}
							});
							/*填充日期列表 和加载滑动效果*/
							$('#play_tabs').prepend(out_.join(''));
							if(!$('#play_tabs').find('.last').length){//如果最后一天是明天并且给隐藏掉了的情况
								$('#play_tabs li').each(function(aaa){
									if((aaa+1) == Q){
										$(this).addClass('last');//给今天加上last样式
									}
								});
							}
							var cur_w = $(window).width()/4;
							$('#play_tabs').find('li').css({'width':cur_w});
							$('#play_tabs .last').css({'width':2*cur_w});
							$('#play_tabs').css({'width':(Q+1)*cur_w});
							o.bind();
							setTimeout(function(){
								navScroll = new iScroll('secNav', {
									snap: 'li',
									hScrollbar: false,
									hScroll: true,
									vScroll: false
								});
							},.1e3 );
							setTimeout(function(){
								$('#secNav .last').click();
							},.5e3 );
							/*填充日期列表 和加载滑动效果*/
						}else{
							var desc = R.attr('desc');
							alert(desc);
						}
					}
				});
			},
			dobuy : function(opt){
				var Q = {'72':'SPF','90':'RQSPF'}[g.gid];
				var Q1 = $('#con .select').find('.cur').attr('c');
				g.codes = Q+'|'+g.itemid+'='+Q1+'|1*1_1';
				var data = {
						gid : g.gid,
						play : '1',
						codes : g.codes,
						beishu : 1,
						zhushu : 1,
						content : '自购',
						title : '自购',
						ishm : 0,
						sgtypename : '单关固赔',
						extendtype : '13',
						money : 2,
						ffag :0,
						muli :1,
						type : 0,
						bnum :1,
						tnum:1,
						oflag:0,
						isshow:0,
						source:'3000',
						cupacketid: opt.cupacketid,//红包id
						redpacket_money: opt.redpacket_money//使用红包金额
				};
				opt.ac && (data.activityflag = 1);
				$.ajax({
					url: '/trade/jcast.go',
					type:'POST',
					data: data,
					success:function(xml){
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if (code == "0") {
							var projid = R.find('result').attr('projid');
							var lotid = projid.substr(0,2);
							alert('购买成功！');
							setTimeout(function(){
								if(location.host == '5.9188.com '){
									window.location.href='/#type=url&p=user/viewpath.html?hid='+projid;
								}else{
									window.location.href='/#class=url&xo=viewpath/index.html&lotid='+lotid+'&projid='+projid;
								}
							},1e3);
						} else {
							alert(desc);
						}
					}
				});
			},
			
			/*去投注-*/
			gobuy : function(){
					alert('正在检查支付环境','load');
					$.ajax({
						url:'/activity/buycertainwin.go',
						data:{
							uid:decodeURIComponent(g.userName),
							af:g.itemid
						},
						type:'POST',
						dataType:'xml',
						success:function(xml){
							remove_alert();
							var R = $(xml).find('Resp');
							var code = R.attr('code');
							var desc = R.attr('desc');
							(code != '0') && remove_alert();
							if(code == '0'){//可正常参与
								var data = {//支付弹框参数
										gid:     g.gid,//彩种id
										cMoney:  '2',//需支付金额
										bonus:   g.bonus//奖金范围
								};
								CP.User.info(function(options){
									remove_alert();
									if (options) {$.extend(data, options);}
									CP.Popup.buybox(data);
								});
							}else if(code == '1'){//未登录
								$('#ts_2,#mask').show();
							}else if(code == '2'){//已参加过当前场次
								$('#ts_7,#mask').show();
								$('#ts_7').off().on('click', 'span', function(){
									$('#ts_7,#mask').hide();
								});
							}else if(code == '7'){//中过奖
								$('#ts_3,#mask').show();
							}else if(code == '3' || code == '9'){//3未绑定手机号 9两个都没绑
								var Q_ = '';
								if(code == '9'){
									if(g.yue<2){
										Q_ = '101';
									}else{
										Q_ = '102';
									}
								}else{
									if(g.yue<2){
										Q_ = '103';
									}
								}
								$('#ts_6 p').html(desc);
								$('#ts_6,#mask').show();
								$('#ts_6').off().on('click', 'span', function(){
									$('#ts_6,#mask').hide();
								}).on('click', 'a', function(){
									var url = 'phone.html';
									if(CP.MobileVer.android){//android
										try {
											window.caiyiandroid.clickAndroid(5, Q_);//绑定手机
										} catch (e){
											window.location.href = url;
										}
									}else{//4g & ios
										window.location.href = url;
									}
								});
							}else if(code == '4'){//未实名认证
								var Q_ = (g.yue<2) && '103' || '';
								$('#ts_6 p').html(desc);
								$('#ts_6,#mask').show();
								$('#ts_6').off().on('click', 'span', function(){
									$('#ts_6,#mask').hide();
								}).on('click', 'a', function(){
									var url = 'idcard.html';
									if(CP.MobileVer.android){//android
										try {
											window.caiyiandroid.clickAndroid(6, Q_);//绑定省份证
										} catch (e){
											window.location.href = url;
										}
									}else{//4g & ios
										window.location.href = url;
									}
								});
							}else{
								$('#ts_4 p').html(desc);
								$('#ts_4,#mask').show();
								$('#ts_4 span').off().bind('click',function(){
									$('#ts_4,#mask').hide();
								});
							}
						},error:function(){
							remove_alert();
						}
					});
			},
			/*-去投注*/
			
			bind : function () {
				$('#goon,#goon2').Touch({fun:function(){
					var data = {//支付弹框参数
							gid:     g.gid,//彩种id
							cMoney:  '2',//需支付金额
							bonus:   g.bonus,//奖金范围
							ac:false//不是活动购买
					};
					CP.User.info(function(options){
						remove_alert();
						if (options) {$.extend(data, options);}
						CP.Popup.buybox(data);
					});
					$('#ts_7').hide();
				}});
				$('#login,#login2').bind(end_ev, function(){//#enroll,#enroll2
					var url = 'login.html';
					sessionStorage.setItem('callback',location.href);
					if(CP.MobileVer.android){//android
						try {
							window.caiyiandroid.clickAndroid(4, '100');//100是这个活动需要的
						} catch (e){
							window.location.href = url;
						}
					}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
						try {
							WebViewJavascriptBridge.callHandler('clickIosRegister');
						} catch (e){
							window.location.href = url;
						}
					}else{//4g
						window.location.href = url;
					}
				});
				/*-登录注册*/
				
				/*切换日期-*/
				$('#play_tabs li').click(function () {
					date2 = new Date().getTime();
					if(date2-date1 > '400'){
						$(this).addClass('cur').siblings().removeClass('cur');
						var Q = $(this).prev().length ? $(this).prev().last() [0] : $(this)[0];
						navScroll.scrollToElement(Q,800);
						o.render($(this).attr('mydata'));
						date1 = new Date().getTime();
					}
				});
				/*-切换日期*/
				
				/*去挑战高手场-*/
				$('#gobuy, #gobuy2, #gobuy3').bind(start_ev, function () {
					var url = '/#class=url&xo=jczq/index.html';
					if(location.host == '5.9188.com '){
						url = '/#type=url&p=list/jczq.html';
					}
					if(CP.MobileVer.android){//android
						try {
							window.caiyiandroid.clickAndroid(0, '70');
						} catch (e){
							window.location.href = url;
						}
					}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
						try {
							WebViewJavascriptBridge.callHandler('clickIosLottery','70');
						} catch (e){
							window.location.href = url;
						}
					}else{//4g
						window.location.href = url;
					}
				});
				/*-去挑战高手场*/
				
				/*选择赛果 立即投注-*/
				$('#con').delegate('.cbuy','click',function(){
					if(!g.userName){//提示去登录
						$('#ts_2,#mask').show();
					}else{
						if(!$(this).is('.gray')){
							o.gobuy();
						}else{
							alert('请选择一个赛果');
						}
					}
				}).delegate('.select span', end_ev, function(){
					$(this).toggleClass('cur').siblings().removeClass();
					if($(this).parent().find('.cur').length){
						$('.cbuy').removeClass('gray');
						g.bonus = 2*$(this).attr('v');
						$('.cbuy').next().html('预计奖金<em>'+g.bonus+'</em>元，应付2元');
					}else{
						g.bonus = 0;
						$('.cbuy').addClass('gray');
						$('.cbuy').next().html('');
					}
				}).delegate('u', 'click', function(){//什么是让球
					$('#isrq,#mask').show();
				});
				/*-选择赛果 立即投注*/
				
				/*关闭弹窗-*/
				$('.clock').bind(end_ev, function () {
					$(this).parent().hide();
					$('#mask').hide();
				});
				/*-关闭弹窗*/
			},
			init : function (){
				$('.hdgz').Touch({children:'span',fun:function(){
					$('.hdgz section').toggle(); 
					window.scrollTo(0, $('#content').height());
				}});
				o.gain();
			}
	};
	var init = function () {
		var agent = location.search.getParam('agent') || false;
		agent && localStorage.setItem('agent',agent);
		sessionStorage.setItem('huodong',window.location.href);
		o.init();
	};
	init();
	return {dobuy : o.dobuy};
})(window.Zepto);