var LCSlide=function(a){a=a||{};var b={slideCell:a.slideCell||'#touchSlide',titCell:a.titCell||'.hd li',mainCell:a.mainCell||'.bd',effect:a.effect||'left',autoPlay:a.autoPlay||!1,delayTime:a.delayTime||200,interTime:a.interTime||2500,defaultIndex:a.defaultIndex||0,titOnClassName:a.titOnClassName||'cur',autoPage:a.autoPage||!1,prevCell:a.prevCell||'.prev',nextCell:a.nextCell||'.next',pageStateCell:a.pageStateCell||'.pageState',pnLoop:'undefined '==a.pnLoop?!0:a.pnLoop,startFun:a.startFun||null,endFun:a.endFun||null,switchLoad:a.switchLoad||null},c=document.getElementById(b.slideCell.replace('#',''));if(!c)return!1;var d=function(a,b){a=a.split(' ');var c=[];b=b||document;var d=[b];for(var e in a)0!=a[e].length&&c.push(a[e]);for(var e in c){if(0==d.length)return!1;var f=[];for(var g in d)if('#'==c[e][0])f.push(document.getElementById(c[e].replace('#','')));else if('.'==c[e][0])for(var h=d[g].getElementsByTagName('*'),i=0;i<h.length;i++){var j=h[i].className;j&&-1!=j.search(new RegExp('\\b'+c[e].replace('.','')+'\\b'))&&f.push(h[i])}else for(var h=d[g].getElementsByTagName(c[e]),i=0;i<h.length;i++)f.push(h[i]);d=f}return 0==d.length||d[0]==b?!1:d},e=function(a,b){var c=document.createElement('div');c.innerHTML=b,c=c.children[0];var d=a.cloneNode(!0);return c.appendChild(d),a.parentNode.replaceChild(c,a),m=d,c},g=function(a,b){!a||!b||a.className&&-1!=a.className.search(new RegExp('\\b'+b+'\\b'))||(a.className+=(a.className?' ':'')+b)},h=function(a,b){!a||!b||a.className&&-1==a.className.search(new RegExp('\\b'+b+'\\b'))||(a.className=a.className.replace(new RegExp('\\s*\\b'+b+'\\b','g'),''))},i=b.effect,j=d(b.prevCell,c)[0],k=d(b.nextCell,c)[0],l=d(b.pageStateCell)[0],m=d(b.mainCell,c)[0];if(!m)return!1;var N,O,n=m.children.length,o=d(b.titCell,c),p=o?o.length:n,q=b.switchLoad,r=parseInt(b.defaultIndex),s=parseInt(b.delayTime),t=parseInt(b.interTime),u='false'==b.autoPlay||0==b.autoPlay?!1:!0,v='false'==b.autoPage||0==b.autoPage?!1:!0,w='false'==b.pnLoop||0==b.pnLoop?!1:!0,x=r,y=null,z=null,A=null,B=0,C=0,D=0,E=0,G=/hp-tablet/gi.test(navigator.appVersion),H='ontouchstart'in window&&!G,I=H?'touchstart':'mousedown',J=H?'touchmove':'',K=H?'touchend':'mouseup',M=m.parentNode.clientWidth,P=n;'leftLoop'==i&&(P+=2,m.appendChild(m.children[0].cloneNode(!0)),m.insertBefore(m.children[n-1].cloneNode(!0),m.children[0])),N=e(m,'<div class="tempWrap" style="overflow:hidden; position:relative;"></div>'),m.style.cssText='width:'+P*M+'px;'+'position:relative;overflow:hidden;padding:0;margin:0;';for(var R=0;P>R;R++)m.children[R].style.cssText='display:table-cell;vertical-align:top;width:'+M+'px';var S=function(){'function'==typeof b.startFun&&b.startFun(r,p)},T=function(){'function'==typeof b.endFun&&b.endFun(r,p)},U=function(a){var b=('leftLoop'==i?r+1:r)+a,c=function(a){for(var b=m.children[a].getElementsByTagName('img'),c=0;c<b.length;c++)b[c].getAttribute(q)&&(b[c].setAttribute('src',b[c].getAttribute(q)),b[c].removeAttribute(q))};if(c(b),'leftLoop'==i)switch(b){case 0:c(n);break;case 1:c(n+1);break;case n:c(0);break;case n+1:c(1)}},V=function(){M=N.clientWidth,m.style.width=P*M+'px';for(var a=0;P>a;a++)m.children[a].style.width=M+'px';var b='leftLoop'==i?r+1:r;W(-b*M,0)};window.addEventListener('resize',V,!1);var W=function(a,b,c){c=c?c.style:m.style,c.webkitTransitionDuration=c.MozTransitionDuration=c.msTransitionDuration=c.OTransitionDuration=c.transitionDuration=b+'ms',c.webkitTransform='translate('+a+'px,0)'+'translateZ(0)',c.msTransform=c.MozTransform=c.OTransform='translateX('+a+'px)'},X=function(a){switch(i){case'left':r>=p?r=a?r-1:0:0>r&&(r=a?0:p-1),null!=q&&U(0),W(-r*M,s),x=r;break;case'leftLoop':null!=q&&U(0),W(-(r+1)*M,s),-1==r?(z=setTimeout(function(){W(-p*M,0)},s),r=p-1):r==p&&(z=setTimeout(function(){W(-M,0)},s),r=0),x=r}S(),A=setTimeout(function(){CP.LCDG.render(r);T()},s);c==r&&g(o[c],b.titOnClassName);0==w&&(h(k,'nextStop'),h(j,'prevStop'),0==r?g(j,'prevStop'):r==p-1&&g(k,'nextStop')),l&&(l.innerHTML='<span>'+(r+1)+'</span>/'+p)};if(X(),u&&(y=setInterval(function(){r++,X()},t)),o)for(var R=0;p>R;R++)!function(){var a=R;o[a].addEventListener('click',function(){clearTimeout(z),clearTimeout(A),r=a,X()})}();k&&k.addEventListener('click',function(){(1==w||r!=p-1)&&(clearTimeout(z),clearTimeout(A),r++,X())}),j&&j.addEventListener('click',function(){(1==w||0!=r)&&(clearTimeout(z),clearTimeout(A),r--,X())});var Y=function(a){clearTimeout(z),clearTimeout(A),O=void 0,D=0;var b=H?a.touches[0]:a;B=b.pageX,C=b.pageY,m.addEventListener(J,Z,!1),m.addEventListener(K,$,!1)},Z=function(a){if(!H||!(a.touches.length>1||a.scale&&1!==a.scale)){var b=H?a.touches[0]:a;if(D=b.pageX-B,E=b.pageY-C,'undefined'==typeof O&&(O=!!(O||Math.abs(D)<Math.abs(E))),!O){switch(a.preventDefault(),u&&clearInterval(y),i){case'left':(0==r&&D>0||r>=p-1&&0>D)&&(D=0.4*D),W(-r*M+D,0);break;case'leftLoop':W(-(r+1)*M+D,0)}null!=q&&Math.abs(D)>M/3&&U(D>-0?-1:1)}}},$=function(a){0!=D&&(a.preventDefault(),O||(Math.abs(D)>M/10&&(D>0?r--:r++),X(!0),u&&(y=setInterval(function(){r++,X()},t))),m.removeEventListener(J,Z,!1),m.removeEventListener(K,$,!1))};m.addEventListener(I,Y,!1)};
var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
var end_ev = ('ontouchend' in window ) ? 'touchend' : 'mouseup';
var move_ev = ('ontouchend' in window ) ? 'touchmove' : 'mousemove';
var agent = location.search.getParam('lol') || '4g';
var CP = {};
CP.Data = {
		source : '3000'//投注source值
};
CP.getType = function (o) {
	var _t;
	return ((_t = typeof(o)) == "object" ? o == null && "null" || Object.prototype.toString.call(o).slice(8, -1) : _t).toLowerCase();
};
$.fn.Touch = function (obj) {
	var moveEvent = move_ev;
	if (CP.getType(obj) == 'function') {
		obj.fun = obj;
	}

	this.each(function () {
		var $dom = $(this).eq(0);//转为dom对象
		var ifMove = false;
		var t = 0;
		$dom.on(moveEvent, function () {
			ifMove = true;
			clearTimeout(t);
			t = setTimeout(function () {
				ifMove = false
			}, 250);
		})
		if (obj.children) {
			$dom.on(end_ev, obj.children, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return false;
				}
				obj.fun.call(this, this);
			})
		}
		else {
			$dom.on(end_ev, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return 0;
				}
				obj.fun.apply(this, [this, e]);
			})
		}
	});
};
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
					payPara:       '', //投注参数
					cupacketid:    '',//红包id
					redpacket_money: ''//使用红包金额
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
			if (o.usermoney>o.cMoney) {//余额不足的时候显示去充值
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
				if(agent == '4g'){
					window.location.href='/#class=url&xo=useraccount/recharge.html';
				}else{
					$('#buy_box').hide();
					$('#recharge,#mask').show();
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
				CP.Pay.init(o);
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
									if((rPack + o.usermoney)>o.cMoney){
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
					if(rPack && (parseFloat(rPack) + o.usermoney)>o.cMoney){
						$('#gocz').hide().siblings().show();
					}else{
						$('#isok').hide().siblings().show();
					}
				}
			});
		}
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
						remove_alert();
						if(agent == 'ios'){
							try {
								WebViewJavascriptBridge.callHandler('clickIosLogin');
							} catch (e){
								window.location.href = 'login.html';
							}
						}else{
							location.href = 'login.html';
						}
						alert('请先登录');
					}
				},error : function () {
					remove_alert();
					alert('网络异常请刷新重试');
				}
			});
		}
}
//支付
CP.Pay = function () {
	var init = function (opt) {
		var opt_ = opt.payPara || {};
		var data = {};
		if (opt_.orderType == 'dg') {//代购
			data = {
					gid:     opt.gid,//彩种编号
					pid:     opt_.pid,//期号
					play:    '1',//玩法 复式1   单式0
					codes:   opt_.codes,//投注内容
					muli:    opt_.muli,//方案倍数
					fflag:   '0',//是否文件上传 0  非文件上传  1 文件上传
					type:    '0 ',//方案类型0 代购   1合买
					name:    '自购',//方案宣传标题
					desc:    '自购',//方案宣传内容
					money:   opt_.countMoney,//方案金额
					tnum:    '1',//方案总份数
					bnum:    '1',//购买份数
					pnum:    '0',//保底份数
					oflag:   '0',//方案查权限0 公开  1 截止后公开 2对参与者公开  3对参与者截止后公开
					wrate:   '0',//提成比例
					comeFrom:'',//用户来源
					source:  CP.Data.source,//方案来源 
					endTime: '',//方案截止时间
					upay:    '',//是否订单支付
					cupacketid: opt.cupacketid,//红包id
					redpacket_money: opt.redpacket_money//使用红包金额
			};
		}else if(opt.payPara.orderType == 'hm'){//合买
			data = {
					gid:     opt.gid,//彩种编号
					pid:     opt_.pid,//期号
					play:    '1',//玩法 复式1   单式0
					codes:   opt_.codes,//投注内容
					muli:    opt_.muli,//方案倍数
					fflag:   '0',//是否文件上传 0  非文件上传  1 文件上传
					type:    '1',//方案类型0 代购   1合买
					name:    '合买',//方案宣传标题
					desc:    opt_.desc,//方案宣传内容
					money:   opt_.countMoney,//方案金额
					tnum:    opt_.countMoney,//方案总份数
					bnum:    opt_.bnum,//购买份数
					pnum:    opt_.pnum,//保底份数
					oflag:   opt_.oflag,//方案查权限0 公开  1 截止后公开 2对参与者公开  3对参与者截止后公开
					wrate:   opt_.wrate,//提成比例
					comeFrom:'',//用户来源
					source:  CP.Data.source,//方案来源
					endTime: '',//方案截止时间
					upay:    '',//是否订单支付
					cupacketid: opt.cupacketid,//红包id
					redpacket_money: opt.redpacket_money//使用红包金额
			};
		}
		$.ajax({
			url: opt_.payUrl,
			type:'POST',
			data: data,
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
					var projid = '';
					if(opt_.hid){
						projid = opt_.hid;
					}else{
						r = R.find('result');
						projid = r.attr('projid');//方案编号
					}
					if(agent == '4g'){
						window.location.replace('/#class=url&xo=success/great.html&lotid='+projid.substr(0,2)+'&projid='+projid);
					}else{
						$('#record,#mask').show();
					}
				} else {
					alert(desc);
				}
			}
		});
	};
	return {
		init: init
	};
}();
CP.LCDG = (function(){
	//单关列表信息
	var dgData = [];
	var g = {
		bs:'5',//倍数
		money:'10',//总金额
		hmMoney:0,//合买金额
		zs:0,//注数
		codes : '',//投注code
		buyType:'1',//1自购 2合买
		bonus:0,
		pid:''
	};
	var o = {
			/*渲染对阵信息[[*/
			render : function(xo){//滑动过来的 代表索引
				var Q = xo || 0;
				if(!dgData.length){
					$('.nobs').show();
					$('#lcScroll').hide();
				}else{
					var t = dgData[Q];
					var _out = [];
					_out.push('<li t=rf><cite>猜让分<br>胜负</cite><span my-data=0 v='+t.rf.split(',')[0]+'><strong>'+t.gn+'</strong>胜</span><span my-data=3 v='+t.rf.split(',')[1]+'><strong>'+t.hn+'<i>('+t.close+'分)</i></strong>胜</span></li>');
					_out.push('<li><cite class="lcpl">&nbsp;</cite><em>赔率'+t.rf.split(',')[0]+'</em><em>赔率'+t.rf.split(',')[1]+'</em></li>');
					_out.push('<li t=dxf><cite>猜两队<br>总分</cite><span my-data=3 v='+t.dxf.split(',')[0]+'><strong>大于</strong>'+t.zclose+'分</span><span my-data=0 v='+t.dxf.split(',')[1]+'><strong>小于</strong>'+t.zclose+'分</span></li>');
					_out.push('<li><cite class="lcpl">&nbsp;</cite><em>赔率'+t.dxf.split(',')[0]+'</em><em>赔率'+t.dxf.split(',')[1]+'</em></li>');
					$('#content').html(_out.join(''));
					$('#content').attr('item',t.itemid);
					o.count();
				}
			},
			/*]]渲染对阵信息*/
			
			/*获取投注列表信息[[*/
			gain : function(){
				function main(){
					$.ajax({
	    				url : '/data/app/jclq/new_jclq_hh.xml',
	    				type:'GET',
	    				dataType:'xml',
	    				success:function(xml){
	    					var R = $(xml).find('Resp');
	    					var r = R.find('row');
	    					var _out = [];
	    					var i = 0;
	    					r.each(function(){
	    						var t = {};
	    						t.itemid = $(this).attr('itemid');
    							t.hn = $(this).attr('hn').substr(0,5);//主队
    							t.gn = $(this).attr('gn').substr(0,5);//客队
    							t.mt = $(this).attr('mt');//比赛
    							t.mname = $(this).attr('mname');//联赛名
    							t.name = $(this).attr('name');//周几
    							t.close = $(this).attr('close');//让球数
    							t.isale = $(this).attr('isale');//停售
    							t.zclose = $(this).attr('zclose');//大小分
    							t.mid = $(this).attr('mid');
    							t.sf = $(this).attr('sf');
    							t.rf = $(this).attr('rfsf');
    							t.dxf = $(this).attr('dxf');
    							t.sfc = $(this).attr('sfc');
    							
    							if((32 & t.isale) > 0){//让分胜负 单关
    								dgData[i++] = t;
        							_out.push('<li><div><cite>'+t.gn+'</cite><i>vs</i><span>'+t.hn+'</span></div><p>'+t.mname+' '+t.mt+'开赛</p></li>');
    							}
	    					});
	    					o.render();
	    					$('#wapper').html(_out.join(''));
	    					LCSlide({slideCell:"#lcScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
	    					if(_out.length =='1'){
	    						$('.next').addClass('nextStop');
	    					}
	    				}
	    			});
				}
				main();
			},
			/*]]获取投注列表信息*/
			
			count : function(){
				var Q = $('#money input').val();
				g.bs = Q/2;//倍数
	        	g.zs = $('#content').find('.cur').length;
	        	if(Q == '' || parseInt(Q)<2 || g.zs == '0'){
	        		$('#dobuy').html('猜中比赛结果即获奖');
	        		$('#dobuy').removeAttr('v');
	        		g.money = 0;
	        		$('#yc').hide();
	        	}else{
	        		g.bonus = 0;
	        		if(g.zs=='1'){
	        			g.bonus = parseFloat($('#content .cur').attr('v'))*100*Q/100;
	        		}else{
	        			var max = 0,min = 10000;
	        			$('#content .cur').each(function(){
	        				var t = parseFloat($(this).attr('v'))*100;
	        				max += t*Q;
	        				if(min>t){min = t;}
		        		});
	        			min *= Q;
	        			g.bonus = min/100+'~'+max/100;
	        		}
	        		g.money = Q*g.zs;
	        		$('#yc').show().html('预测奖金<em class="red">'+g.bonus+'</em>元');
	        		$('#dobuy').html('立即付款   '+g.money+'元');
	        		$('#dobuy').attr('v',g.money);
	        	}
	        },
	        hm : function(){
	        	$('#back').off().bind('click', function(){
	        		$('#bethm').hide();
		        	$('#bet_list').show();
		        	$('.tzHeader').removeClass('fcHeader');
		        	$('#back').prev().html('竞彩-买一场');
		        	$('#back').off().bind('click',function(){
		        		window.location.href='/';
		        	});
	        	});
	        	$('.tzHeader').addClass('fcHeader');
	        	$('#back').prev().html('发起合买');
	        	$('#bethm').show();
	        	$('#bet_list').hide();
	        	$('#hmDet').html('本方案共<cite class="yellow">'+g.zs+'</cite>注<cite class="yellow">'+g.bs+'</cite>倍，总金额<cite class="yellow">'+g.money+'</cite>元');
				$("#rg").val(Math.ceil(g.money*0.05));
				$("#rg_bl").html(Math.floor(($('#rg').val()/g.money)*10000)/100+"%");
				$("#bd").removeAttr('disabled');
				$("#bd").val('0');
				$("#bd_bl").html('0%');
				o.hmDet();
	        },
	        /*认购保底多少[[*/
			hmDet : function () {
				var rg = parseInt($('#rg').val() || 0);
				var bd = parseInt($('#bd').val() || 0);
				var z = rg+bd;
				g.hmMoney = z;
				$('#hm_m').html('认购'+rg+'元 保底'+bd+'元 共<cite class="red">'+z+'</cite>元');
			},
			/*]]认购保底多少*/
			
	        /*获取购买的各种参数 [[*/
			getArgument : function(t){
				var buy = {};
				switch(t){
					/* 1:自购 2:合买  */
					case 1:
						buy = {//投注参数
								payUrl:    '/trade/jcast.go',//投注接口
								gid:       '71',//彩种id
								pid:       g.pid,//期号
								codes:     g.codes,//投注内容
								muli:      g.bs,//倍数
								countMoney:g.money,//方案金额
								orderType:'dg'//代购
						};
						break;
					case 2:
						buy = {//投注参数
							payUrl:    '/trade/jcast.go',//投注接口
							gid:       '71',//彩种id
							pid:       g.pid,//期号
							codes:     g.codes,//投注内容
							muli:      g.bs,//倍数
							desc:      $('#hmDesc').val() || '快乐购彩、欧耶！',//方案宣传
							countMoney:g.money,//方案金额
							bnum:      $('#rg').val(),//认购
							pnum:      $('#bd').val(),//保底
							oflag:     $('#isPublic .cur').attr('v') || 0,//公开状态
							wrate:     $('#ratio .cur').attr('v') || 5,//提成比例
							orderType:'hm'//代购
						};
						break;
				}
				return buy;
			},
			/*获取购买的各种参数 ]]*/
			
	        dobuy : function(Q){
            	if(g.zs<=0){
            		alert('请先选择一场比赛');
            	}else if(g.money <2){
            		alert('购买金额最少2元');
            	}else{
            		var codes = 'HH|'+$('#content').attr('item')+'>';
            		
            		var rf = [];
            		$('#content li[t=rf] .cur').each(function(){
            			rf.push($(this).attr('my-data'));
            		});
            		if(rf.length){
            			rf='RFSF='+rf.join('/');
            			codes += rf;
            		}
            		var dxf = [];
            		$('#content li[t=dxf] .cur').each(function(){
            			dxf.push($(this).attr('my-data'));
            		});
            		if(dxf.length){
            			dxf = 'DXF='+dxf.join('/');
            			if(rf.length){
            				codes += '+'+dxf;
            			}else{
            				codes += dxf;
            			}
            		}
            		codes += '|1*1';
            		g.codes = codes;
            		if(Q){o.hm();}else{o.dopay();}
            	}
	        },
	        dopay : function(t){
	        	t ? g.buyType=2 : g.buyType=1;//合买、自购
				var _obj = o.getArgument(g.buyType);
				var cMoney = '';
				t ? cMoney = g.hmMoney : cMoney = g.money;//应付金额
				var data = {//支付弹框参数
						gid:     '71',//彩种id
						cMoney:  cMoney,//需支付金额
						payPara: _obj,//$.param(param)
						bonus:   g.bonus//奖金范围
				};
				alert('提交中，请稍后！','loading');
				CP.User.info(function(options){
					remove_alert();
					if (options) {$.extend(data, options);}
					CP.Popup.buybox(data);
				});
	        },
			bind : function(){
				$('#dobuy').Touch({fun:function(){o.dobuy();}});
				$('#dohm').Touch({fun:function(){o.dobuy('hm');}});
				$('#hmSubmit').Touch({fun:function(){o.dopay('hm');}});
				$('#content').delegate('span', start_ev, function(){
					if($(this).hasClass('cur')){
						$(this).removeClass('cur');
					}else{
						$(this).parent().find('.cur').removeClass('cur');
						$(this).addClass('cur');
					}
					o.count();
				});
				$('#money').on('blur','input',function(){
		        	var t = parseInt($(this).val());
		        	if($(this).val() == '' || t == '0'){
		        		alert('最少2元');
		        		$(this).val('2');
		        	}else{
		        		if(t % 2 == '0'){
		            		$(this).val(t);
		            	}else{
		            		alert('购买金额必须为双数');
		            		$(this).val(t+1);
		            	}
		        	}
		        	o.count();
		        }).on('keyup','input',function(){
		        	this.value=this.value.replace(/\D/g,'');
		        	if(this.value>199998){
		        		this.value = '199998';
		        	}
		        	o.count();
		        });
				$('#jian').bind(start_ev, function(){//减
					var t = parseInt($('#money input').val());
		        	if(t <= '3'){
		        		alert('最少2元');
		        	}else{
		        		$('#money input').val(t-2);
		        	}
		        	o.count();
				});
				$('#jia').bind(start_ev, function(){//加
					var t = parseInt($('#money input').val());
		        	if(t>=19998){
		        		return;
		        	}
		        	$('#money input').val(t+2);
		        	o.count();
				});
				$('#back').bind('click',function(){
	        		window.location.href='/';
	        	});
				
				/*合买事件[[*/
				$('#rg').on('keyup',function(){//认购 
					var bd_ = parseInt($('#bd').val());
					if($(this).val() >= g.money){
						$(this).val(g.money);
						$("#rg_bl").html("100%");
					}else{
						if($(this).val() == ''){
							$("#rg_bl").html("0%");
						}else{
							$("#rg_bl").html(Math.floor((parseInt($('#rg').val())/g.money)*10000)/100+"%");
						}
					}
					if(!$("#chk").hasClass("nocheck") || parseInt($(this).val())+bd_>g.money){
						if($(this).val() == ''){
							$('#bd').val(g.money);
							$("#bd_bl").html('100%');
						}else{
							$('#bd').val(g.money-parseInt($(this).val()));
							$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.money)*10000)/100+"%");
						}
					}
					o.hmDet();
				}).on('change',function(){//认购 小于5% 提示
					var t = $(this).val();
					if(t == ''){t=0;}
					if(parseInt(t) < g.money*0.05){
						alert('认购金额不能小于5%');
						$(this).val(Math.ceil(g.money*0.05));
						$("#rg_bl").html(Math.floor((parseInt($("#rg").val())/g.money)*10000)/100+"%");
					}
					if(!$("#chk").hasClass("nocheck")){
						$('#bd').val(g.money-parseInt($(this).val()));
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.money)*10000)/100+"%");
					}
					o.hmDet();
				});
				$('#bd').on('keyup',function(){//保底 
					var rg_ = parseInt($('#rg').val());
					(parseInt($(this).val()) > g.money-rg_) && $(this).val(g.money-rg_);
					if($(this).val() == ''){
						$("#bd_bl").html("0%");
					}else{
						$(this).val(parseInt($(this).val()));
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.money)*10000)/100+"%");
					}
					o.hmDet();
				}).on('change',function(){//保底等于空
					if($(this).val() == ''){
						$(this).val('0');
						$("#bd_bl").html("0%");
						o.hmDet();
					}
				});
				$('#chk').bind(start_ev,function(){
					var rg_ = parseInt($('#rg').val());
					$(this).toggleClass('nocheck');
					if(!$("#chk").hasClass("nocheck")){//全额保底
						$("#bd").attr('disabled',true);
						$("#bd").val(g.money-rg_);
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.money)*10000)/100+"%");
					}else{
						$("#bd").removeAttr('disabled');
					}
					o.hmDet();
				});
				$('#ratio li,#isPublic li').on(start_ev, function(){//提成   是否公开 点击事件
					!$(this).hasClass('cur') && $(this).toggleClass('cur');
					$(this).siblings().removeClass('cur');
				});
				/*]]合买事件*/
			},
			init : function(){//android 登录
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
							
						}
					});
				}
			}
	};
	
	var init = function(){
		$('#money input').val('10');
		$('.bfb').click(function(){
			$(this).parent().parent().hide();
			$('#mask').hide();
		});
		if(agent != '4g'){
			localStorage.setItem('banner','yes');
		}
		o.init();
		o.gain();
		o.bind();
	};
	return {init:init,
			render:o.render
		};
})();
CP.LCDG.init();