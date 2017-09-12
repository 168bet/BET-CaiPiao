CP.SSC = (function (){
	var lotteryType = $('#content_home').children().eq(0).attr('id').replace('buy_','');//彩种简称 
	var hasTouch = 'ontouchstart' in window;
	var start_ev = hasTouch ? 'touchstart' : 'mousedown';
	var end_ev = hasTouch ? 'touchend' : 'mouseup';
	var s = {
		'cqssc':{'lot_id':'04','name':'时时彩'}
	};
	var g = {
		cur : 1,//默认显示一星直选
		curtab:0,//只有3种 只是切换的记下 其它地方没用到
		fps :1000,
		gid : s[lotteryType].lot_id,
		zhushu : 0,//选号页面注数
		money : 0,//选号页面总金额
		totalMoney : 0,//列表页面总金额
		count_zs : 0,//列表页面总金额
		beishu : 1,
		qishu : 1,
		buyType : 1,
		codes : '',
		qihao_id : '',//当前期号
		exhz:{//二星和值对应的注数
			'0': 1,'1': 1,'2': 2,'3': 2,'4': 3,'5': 3,'6': 4,'7': 4,'8': 5,'9': 5,'10': 5,'11': 4,'12': 4,'13': 3,'14': 3,'15': 2,'16': 2,'17': 1,'18': 1
		},
		id:{'0':'dxds','1':'yzx','2':'ezx','3':'szx','4':'wzx','5':'wtx','6':'ezux','7':'szs','8':'szl','9':'ehz'},
		jiang : {//各玩法的奖金
				0 : '<div>猜中十位、个位属性,奖金<em class="yellow">4</em>元</div>',
				1 : '<div>猜中个位号码，奖金<em class="yellow">10</em>元</div>',
				2 : '<div>按顺序猜中十位、个位，奖金<em class="yellow">100</em>元</div>',
				3 : '<div>按顺序猜中百位、十位、个位，奖金<em class="yellow">1000</em>元</div>',
				4 : '<div>按顺序猜中全部5位，奖金<em class="yellow">100000</em>元</div>',
				5 : '<div class="jxssctitle"><p>按顺序猜中全部5位，奖金<em class="yellow">20440</em>元</p><p>按顺序猜中全部前3位或后3位，奖金<em class="yellow">220</em>元</p><p>按顺序猜中前2位或后2位，奖金<em class="yellow">20</em>元</p></div>',
				6 : '<div class="jxssctitle"><p>选2个号,猜中后2位组合(顺序不限)，奖金<em class="yellow">50</em>元</p></div>',
				7 : '<div class="jxssctitle"><p>选2个号,猜中后3位组三号码，奖金<em class="yellow">320</em>元</p><p>组三:3个号码中有2个相同，如:353</p></div>',
				8 : '<div class="jxssctitle"><p>选3个号,猜中后3位组六号码，奖金<em class="yellow">160</em>元</p><p>组六:3个号码各不相同，如:865</p></div>',
				9 : '<div class="jxssctitle"><p>&nbsp;&nbsp;猜中十位、个位之和,奖金<em class="yellow">50</em>元</p><p>（若开奖号后2位相同，中奖<em class="yellow">100</em>元）</p></div>'
		},
		s : {'0':'1','1':'2','2':'3','3':'4','4':'5','5':'6','6':'7','7':'8','10':'2','11':'3'},//玩法对应的最小选球个数
		wf : {'0':'大小单双','1':'一星直选','2':'二星直选','3':'三星直选','4':'五星直选','5':'五星通选','6':'二星组选','7':'三星组三','8':'三星组六','9':'二星和值'}//玩法对应的最小选球个数
	};
	var o = {
			//页面跳转
			pageGo: {
				goBack: function () {
					TopAnch.init({
						title:s[lotteryType].name,
						prevShow:true,
						prevFun:function(){//左侧按钮绑定事件
							window.location.href = '#type=index';
						},
						menu:[{'name':'投注选号','url':'javascript:;','cur':true},
						      {'name':'开奖结果','url':'#type=url&p=kj/result.html?in_='+s[lotteryType].lot_id,'cur':false},
						      {'name':'玩法帮助','url':'#type=url&p=wf/'+lotteryType+'.html','cur':false}],
						      style:false
					});
				}
			},
	        /*滑动[[*/
	        slide : function(_obj){
	        	console.log(_obj)
	            var menu = $(_obj.menu);//菜单点击滑动DOM li
	            var con = $(_obj.con);//内容滑动DOM
	            var cur = _obj.cur || g.cur;//默认第一个选中(注意11选五只有0到2)
	            var Q = $(window).width();//单个内容块宽度
	            $('#bonus_ article').html(g.jiang[cur]);
	            con.each(function(i){
	            	$(this).show();
                    $(this).css({'left': i<cur ? -Q : (i>cur ? Q:'') });
                    i==cur?$(this).css({'left':1 }):'' ;
                });
	            
 	            menu.click(function(){
	                var index= $(this).index();//当前位置
	                var conW=  con.width();//单个内容块宽度
	                $(this).addClass('cur').siblings().removeClass('cur');
	                con.each(function(i){
	                    if(g.cur == i){//上一次
	                		$(this).stop(true,false).animate({'left': i<index ? -conW : (i>index ? conW:'') }, _obj.conSpeed||300,_obj.effect||'');
	                	}else if(i!=index){
	                		$(this).css({'left':i<index ? -conW : (i>index ? conW:'')});
	                	}else{
	                		$(this).stop(true,false).animate({'left':0 } , _obj.conSpeed||300,_obj.effect||'')
	                	}
	                });
	                g.cur = index;//记下当前操作的是哪个玩法 下面很多地方会用到
	                o.change(index, $(this));
	            });
	        },
	        /*滑动]]*/
			change : function (index, el) {
				var Q = el.prev() .length ? el.prev() .last() [0] : el[0];
				navScroll.scrollToElement(Q,300);
				$('#bonus_ article').html(g.jiang[index]);
				o.color_();
				o.clear();
			},
			
			color_: function(){//切换历史开奖号码的颜色
				var n = g.cur;
				$('#kj_code div.k3kjlist ul').each(function(){
					$(this).find('li.jxsscdice').find('b').each(function(aa){
						if(n == '0' || n == '2' || n == '6' || n == '9'){//2
							if(aa == 3 || aa == 4){
								!$(this).hasClass('red') && $(this).addClass('red');
							}else{
								$(this).hasClass('red') && $(this).removeClass('red');
							}
						}else if(n == '1'){//1
							if(aa == 4){
								!$(this).hasClass('red') && $(this).addClass('red');
							}else{
								$(this).hasClass('red') && $(this).removeClass('red');
							}
						}else if(n == '3' || n == '7' || n == '8'){//3
							if(aa == 2 || aa == 3 || aa == 4){
								!$(this).hasClass('red') && $(this).addClass('red');
							}else{
								$(this).hasClass('red') && $(this).removeClass('red');
							}
						}else if(n == '4' || n == '5'){//5
							!$(this).hasClass('red') && $(this).addClass('red');
						}
					});
				});
				$('#kj_ssc div.jxsscball b').each(function(aa){
					if(n == '0' || n == '2' || n == '6' || n == '9'){//2
						if(aa == 3 || aa == 4){
							!$(this).hasClass('red') && $(this).addClass('red');
						}else{
							$(this).hasClass('red') && $(this).removeClass('red');
						}
					}else if(n == '1'){//1
						if(aa == 4){
							!$(this).hasClass('red') && $(this).addClass('red');
						}else{
							$(this).hasClass('red') && $(this).removeClass('red');
						}
					}else if(n == '3' || n == '7' || n == '8'){//3
						if(aa == 2 || aa == 3 || aa == 4){
							!$(this).hasClass('red') && $(this).addClass('red');
						}else{
							$(this).hasClass('red') && $(this).removeClass('red');
						}
					}else if(n == '4' || n == '5'){//5
						!$(this).hasClass('red') && $(this).addClass('red');
					}
				});
				$('#kj_ssc p cite').html(g.wf[n]);
			},
			
			/*点击球[[*/
			clickBall : function(_this, on){
				if($(_this).hasClass(on)){
					$(_this).removeClass(on);
				}else{
					if(g.cur == '0'){//大小单双
						$(_this).parent().parent().find('.red').removeClass('red');
					}
					if(g.cur == '1' && $('#yzx .red').length>=4){//一星直选4
						alert('一星直选最多选4个球');
					}else if(g.cur == '6' && $('#ezux .red').length>=6){//二星组选6
						alert('二星组选最多选6个球');
					}else if(g.cur == '8' && $('#szl .red').length>=8){//三星组六8
						alert('三星组六最多选8个球');
					}else{
						$(_this).addClass(on);//添加类名
					}
				}
				o.countTotal();//计算注数、金额
			},
			/*点击球]]*/
			
			//选球页面统计
			countTotal : function(){
				g.zhushu = 0;
				if(g.cur == '0'){//大小单双
					g.zhushu = $('#dxds').find('.red').length == 2 && '1' || 0;
				}else if(g.cur == '1' || g.cur == '2' || g.cur == '3' || g.cur == '4' || g.cur == '5'){//一星直选 & 二星直选 & 三星直选 & 五星直选 & 五星通选
					var Q = {'4':'5'}[g.cur] || parseInt(g.cur);
					g.zhushu = '1';
					for(var i = 0; i<Q; i++){
						g.zhushu *= $('#'+g.id[g.cur]).find('.jxsscxhBall:eq('+i+') .red').length;
					}
				}else if(g.cur == '6'){//二星组选
					var Q = $('#ezux').find('.red').length;
					if(Q==2){
						g.zhushu = 1;
					}else if(Q>2){
						g.zhushu = CP.math.C(Q, 2)+Q;//计算注数 cp.math.c(已选球数,最低球数)
					}
				}else if(g.cur == '7'){//三星组三
					var Q = $('#szs').find('.red').length;
					if(Q>=2){
						g.zhushu = CP.math.C(Q,2)*2;
					}
				}else if(g.cur == '8'){//三星组六
					var Q = $('#szl').find('.red').length;
					if(Q>=3){
						g.zhushu = CP.math.C(Q,3);
					}
				}else if(g.cur == '9'){//二星和值
					var Q = $('#ehz').find('.red');
					Q.each(function(){
						g.zhushu += g.exhz[$(this).html()];
					});
				}
				g.money = 2*g.zhushu;
				$('#Notes').html(g.zhushu);
				$('#Money').html(g.money);
				if(g.zhushu){
					$('#Notes').addClass('red');
					$('#Money').addClass('red');
				} else {
					$('#Notes').removeClass('red');
					$('#Money').removeClass('red');
				}
			},
			
			/*高亮球 [[*/
			highLight : function(_arr,dom){
				o.clear($(dom+' b'));//清除原有高亮球
				for(var j=0,l1=_arr.length;j<l1;j++){
					$(dom+' b').eq(parseInt(_arr[j],10)-1).addClass('red');
				}
			},
			/*高亮球 ]]*/
			
			/*清楚所有选号[[*/
			clear : function(){
				$('#content_kp').find('.red').removeClass();
				o.countTotal();//计算注数、金额
			},
			/*清楚所有选号]]*/
			
			/*机选[[*/
			jxNum : function(n,type){//n机选注数 type true投注列表/false选球区 
				if(type){
					for(var i=1;i<=n;i++){
						var _code = '';
						var Q = 1;//注数
						if(g.cur == '0'){
							_code = CP.math.random(1, 4, 2,true).join(',').replace(/2/g,'大').replace(/3/g,'小').replace(/4/g,'单').replace(/1/g,'双');
						}else if(g.cur == '1'){
							_code = CP.math.random(0, 9, 1).join('');
						}else if(g.cur == '6'){
							_code = CP.math.random(0, 9, 2,false).join(',');
						}else if(g.cur == '7'){
							Q = 2;
							_code = CP.math.random(0, 9, 2,false).join(',');
						}else if(g.cur == '8'){
							_code = CP.math.random(0, 9, 3,false).join(',');
						}else if(g.cur == '9'){
							_code = CP.math.random(0, 18, 1).join('');
							Q = g.exhz[_code];
						}else{//2-5
							var Q1 = {'4':'5'}[g.cur] || g.cur;
							_code = CP.math.random(0, 9, Q1).join(',');
						}
						o.addToList([_code, Q]);//添加到投注列表
						o.countAll();//统计总金额 注数
					}
					window.scrollTo(0,1);
					o.setLocal();
				}else{//选球区 
					var Q ,Q1;
					o.clear();
					if(g.cur=='0'){//大小单双
						Q = CP.math.random(0, 3, 2, false);
						$('#dxds .jxsscxhBall').find('b:eq('+Q[0]+')').addClass('red');
						$('#dxds .jxsscxhBall').find('b:eq('+(Q[1]+4)+')').addClass('red');
					}else if(g.cur == '1' || g.cur == '2' || g.cur == '3' || g.cur == '4' || g.cur == '5'){//一星直选 & 二星直选 & 三星直选 & 五星直选 & 五星通选
						Q1 = {'4':'5'}[g.cur] || parseInt(g.cur);
						Q = CP.math.random(0, 9, Q1, false);
						for(var i = 0,l=Q.length; i<l; i++){
							$('#'+g.id[g.cur]).find('.jxsscxhBall:eq('+i+') b:eq('+Q[i]+')').addClass('red');
						}
					}else if(g.cur == '6' || g.cur == '7'){//二星组选 & 三星组三
						Q = CP.Util.padArray(CP.math.random(0, 9, 2,false)).sort(function(a,b){return a-b;});
						o.highLight(Q,'#'+g.id[g.cur]);//高亮红球
					}else if(g.cur == '8'){//三星组六
						Q = CP.Util.padArray(CP.math.random(0, 9, 3,false)).sort(function(a,b){return a-b;});
						o.highLight(Q,'#szl');//高亮红球
					}else if(g.cur == '9'){//二星和值
						Q = CP.Util.padArray(CP.math.random(0, 18, 1,false)).sort(function(a,b){return a-b;});
						o.highLight(Q,'#ehz');//高亮红球
					}
					o.countTotal();
				}
			},
			/*机选]]*/
			
			/*列表页面统计总金额 总注数[[*/
			countAll : function(){
				var zhushu = 0;
				g.beishu = $('#tbox_beishu').val();
				g.qishu = $('#tbox_qishu').val();
				var codes=[];
				var wx_10 = false;//检测列表里面有木有五星玩法 默认木有
				$('#bet_list .bet-num').each(function(e){
					zhushu += parseInt($(this).val());//计算投注区域总注数
					codes.push($(this).next().val());
					if($(this).next().val().split('_')[0] == 4 || $(this).next().val().split('_')[0] == 5){wx_10 = true;}
				});
				g.codes=codes.join(";");
				$('#countNotes').html((g.count_zs=zhushu));
				if(wx_10){
					if(g.beishu>10){//五星玩法 倍数不能大于10
						g.beishu = '10';
						$('#tbox_beishu').val('10');
					}
					$('#countMoney').html(g.totalMoney=g.count_zs*2* g.beishu*g.qishu);
				}else{
					$('#countMoney').html(g.totalMoney=g.count_zs*2* g.beishu*g.qishu);
				}
			},
			/*统计总金额 总注数]]*/
			
			/*获取号码区号码 组合成一注 [[*/
			getCode : function(dom){
				var _arr=[];
				for(var i=0;i<dom.find('.red').length;i++){//遍历选中红球
					_arr[i] = dom.find('.red').eq(i).text();
				}
				return _arr;
			},
			/*获取号码区号码 组合成一注 ]]*/
			
			/*添加到投注列表[[*/
			addList : function(){
				if(!g.qihao_id){
					alert('期号获取失败!请刷新页面');return false;
				}else if(g.zhushu == '0'){//小于最小红球数
					alert('至少选择一注');
					return false;
				}else{
					var _code = '';
					if(g.cur == '0'){//大小单双
						_code = o.getCode($('#dxds'))+'';
					}else if(g.cur == '1'){//一星直选
						_code = o.getCode($('#yzx'))+'';
					}else if(g.cur == '2'){//二星直选
						_code = o.getCode($('#ezx .jxsscxhBall:eq(0)')).join('')+','+o.getCode($('#ezx .jxsscxhBall:eq(1)')).join('');
					}else if(g.cur == '3'){//三星直选
						_code = o.getCode($('#szx .jxsscxhBall:eq(0)')).join('')+','+o.getCode($('#szx .jxsscxhBall:eq(1)')).join('')+','+o.getCode($('#szx .jxsscxhBall:eq(2)')).join('');
					}else if(g.cur == '4'){//五星直选
						_code = o.getCode($('#wzx .jxsscxhBall:eq(0)')).join('')+','+o.getCode($('#wzx .jxsscxhBall:eq(1)')).join('')+','+
						o.getCode($('#wzx .jxsscxhBall:eq(2)')).join('')+','+o.getCode($('#wzx .jxsscxhBall:eq(3)')).join('')+','+o.getCode($('#wzx .jxsscxhBall:eq(4)')).join('');
					}else if(g.cur == '5'){//五星通选
						_code = o.getCode($('#wtx .jxsscxhBall:eq(0)')).join('')+','+o.getCode($('#wtx .jxsscxhBall:eq(1)')).join('')+','+
						o.getCode($('#wtx .jxsscxhBall:eq(2)')).join('')+','+o.getCode($('#wtx .jxsscxhBall:eq(3)')).join('')+','+o.getCode($('#wtx .jxsscxhBall:eq(4)')).join('');
					}else if(g.cur == '6'){//二星组选
						_code = o.getCode($('#ezux'))+'';
					}else if(g.cur == '7'){//三星组三
						_code = o.getCode($('#szs'))+'';
					}else if(g.cur == '8'){//三星组六
						_code = o.getCode($('#szl'))+'';
					}else if(g.cur == '9'){//三星和值
						_code = o.getCode($('#ehz'))+'';
					}
					o.addToList([_code, g.zhushu]);
					window.location.href = "#type=fun&fun=CP.SSC.openList";
					o.setLocal();
				}
			},
			/*添加到投注列表]]*/
			
			/*组成号码到投注列表[[*/
			addToList : function(arr, wf, cur){//wf cur 这两个参数只有fromLocal方法过来的才有
				var _html = '';
				_html = '<div class="ssqtzNum">';
				_html += '<cite class="errorBg"><em class="error2"></em></cite>';
				_html += '<span><em>'+arr[0].replace(/,/g,' ')+'</em>';
				_html += '</span><p>'+(wf || g.wf[g.cur])+'&nbsp;&nbsp;&nbsp;'+arr[1]+'注'+2*arr[1]+'元</p>';
				_html += '<input type="hidden" value="'+arr[1]+'" name="bet_num" class="bet-num">';
				_html += '<input type="hidden" value="'+(cur || g.cur)+'_'+arr[0]+'" name="bet" class="bet">';
				_html += '</div>';
				!wf && $('#bet_list').prepend(_html) || $('#bet_list').append(_html);
				o.clear();//清除原有高亮球
				$('#Notes').html(0);//投注注数金额为0
				$('#Money').html(g.zhushu=0);//投注注数金额为0
			},
			/*]]组成号码到投注列表*/
			
			//获取期次信息
			info : function (){//填充开奖号码列表
				function main () {
					$.ajax({
						url : CP.Data.apps+'/trade/lotteryInfo.go?gid='+g.gid+'&fflag=1',
						type : "POST",
						dataType : "xml",
						success : function(xml) {
							var R = $(xml).find("rowc");//当前期
							var p = R.attr('p');//当前期次
							var t = R.attr('t');//当前期截止时间
							var a = R.attr('a');//上一期的开奖时间
							
							g.qihao_id = p;
							$('#jxssc').html('<p>距'+p.substr(7)+'期截止</p><strong></strong>');
							var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
							expect_change(n_, t);//n_当前时间  a截止时间
							
							var r = $(xml).find('row');
							var dice = ['onedice','twodice','threedice','fourdice','fivedice','sixdice'];
							var html = '';
							r.each(function(aa) {
								var tn = $(this).attr('tn');//10 成功且中奖 9成功未中奖 6成功未开奖 8失败且中奖 7 失败未中奖 5失败未开奖 0 用户未投注
								var p = $(this).attr('p');//期号
								var t = $(this).attr('t');//截止时间
								var c = $(this).attr('c');//开奖号码
								p = p.substr(-2);
								a = R.attr('a')
								if(aa == 0){
									clearInterval(window.timer1);
									if(c){
										console.log('cqss')
										var hz = 0, bb ='';
										c = c.split(',');
										for(var n = 0; n<c.length; n++){
											bb +='<b '+(n==c.length-1?'class="red"':'')+'>'+c[n]+'</b>';
										}
										$('#kj_ssc').html('<p>'+p+'期开奖 <cite>一星直选</cite></p>\
												<div class="jxsscball pdTop03 clearfix">'+bb+'<em id=\'kjup\' class="kjup kjdown"></em></div>');
									}else{
										/*$('#kj_').html('<p>'+p+'期开奖</p>\
												<div class="pdTop03 k3waitkj clearfix">\
												<cite class="k3time"></cite><span class="left">\
														等待开奖</span><em id=\'kjup\' class="kjup kjdown"></em></div>');*/
										
										/*n_ = Number(n_)+1000;*/
										console.log(1+'cqss')
										
										console.log(a)
										lottery_time(n_, a, p);
//										$('#kj_ p').html('<p class="pdLeft06">'+p+'期开奖中…</p>');
									}
								}else{
									html +='<ul><li class="wb20">'+p+'期</li>';
									html +='<li class="jxsscdice jxsscwb18">';
									if(c!=''){
										c = c.split(',');
										var decade,unit,hundreds,a,bb,c1;
										a = c[2];//百位
										bb = c[3];//十位
										c1 = c[4];//个位
										
										for(var n = 0; n<c.length; n++){
											html +='<b '+(n==c.length-1?'class="red"':'')+'>'+c[n]+'</b>';
										}
										decade = c_(bb);
										unit = c_(c1);
										hundreds = cc_(a,bb,c1);
										html +='</li><li class="wb21">'+decade+'</li><li class="wb21">'+unit+'</li><li class="wb19">'+hundreds+'</li></ul>';
									}else{
										html +='<b>-</b><b>-</b><b>-</b><b>-</b><b>-</b></li><li class="wb21">-</li>';
										html +='<li class="wb21">-</li><li class="wb19">-</li></ul>';
									}
								}
							});
							$('#kj_code div.k3kjlist').html(html);
						},
						error : function() {
							alert('期号获取失败');
							return false;
						}
					});
				}
				function diffToString(num, iscn) {
					var unit = [8.64E+7,3.6E+6,6E+4,1E+3,1], date = [], cnDate = [];
					var cn = '\u5929,\u65f6,\u5206,\u79d2,\u6beb\u79d2'.split(',');
					for (var i = 0, l = unit.length; i < l; i++) {
						date[i] = parseInt(num / unit[i]);
						cnDate[i] = date[i] + cn[i];
						num %= unit[i];
					}
					return iscn ? cnDate : date;
				}
				function eachClock(){
					this.now += g.fps;
					var diff = this.endtime_ - this.now;
					var msg = '';
					if(diff >= 0){
						var timeout = diffToString(diff,false);
						msg = timeout[1]+''+timeout[2]+':'+CP.Util.pad(timeout[3],2);
						$('#jxssc>strong').html(msg);
					}else{
						msg = '已截止';
						$('#jxssc>strong').html(msg);
						clearInterval(this.timer);
						setTimeout(function(){
							o.info();
						},2000);
					}
				}
				function expect_change(now, endtime){
					this.now = now.getTime();
					this.endtime_ = new Date(endtime.replace(/-/g , '/'));
					clearInterval(this.timer);
					this.timer = setInterval(function (){
						
						eachClock();
					}, g.fps); 
					eachClock();
				}
				var  lottime= function(p){
					this.now1 += g.fps;
					var diff = this.endtime1_ - this.now1;
					var msg = '';
					if(diff >= 0){
						var timeout = diffToString(diff,false);
						 msg = timeout[1]+''+timeout[2]+':'+CP.Util.pad(timeout[3],2);
						$('#kj_ssc').html('<p>'+p+'期开奖</p>\
						<div class="pdTop03 k3waitkj clearfix">\
						<cite class="k3time"></cite><span class="left">\
								'+msg+'</span><em id=\'kjup\' class="kjup kjdown"></em></div>');
					}else{
						clearInterval(this.timer1);
						setTimeout(function(){
							o.info();
						},2000);
					}
				}
				var  lottery_time= function(now, endtime ,p){
//					clearInterval(timer4); //清除新快三的定时器
					this.now1 = now.getTime();
					this.endtime1_ = new Date(endtime.replace(/-/g , '/'));
					clearInterval(this.timer1);
					this.timer1 = setInterval(function (){
						console.log(1)
						lottime(p);
					}, g.fps); 
					lottime(p)
				}
				function c_(x){
					var a = '';
					if(x>4){
						if(x%2 == 0){
							a = '大双';
						}else{
							a = '大单';
						}
					}else{
						if(x%2 == 0){
							a = '小双';
						}else{
							a = '小单';
						}
					}
					return a;
				}
				function cc_(x,o,y){
					var a = '';
					if(x == o && x == y && o == y){
						a = '豹子';
					}else{
						if(x == o || x == y || o == y){
							a = '组三';
						}else{
							a = '组六';
						}
					}
					return a;
				}
				main();
			},
			init : function () {
				
				o.info();//获取期次 遗漏
				
			},
			openList : function(){
				/*设置导航左右按钮 [[*/
				$("#betball").hide();
				$("#betlist").show();
				$('#lot_footer').removeClass('fo_basket').addClass('fo_buy');//显示购买区块

				/*设置导航左右按钮 [[*/
				TopAnch.init({
					title:'投注列表',
					prevShow:true,
					prevFun:function(){//左侧按钮绑定事件					
						window.location.href = '#type=url&p=list/'+lotteryType+'.html';
					},
					isBack:true,
					nextShow:false,
					style:false
				});
				o.countAll();//统计总金额 注数
				window.scrollTo(0,1);
			},
			//存储在本地
			setLocal : function(){
				var codes=[];
				$("#bet_list .bet:input").each(function(){
					codes.push($(this).val());
				});
				g.codes=codes.join(";");
				CP.Storage.set(lotteryType,g.codes,true); //存list(json)到sessionStorage
			},
			//sessionStorage数据恢复到投注列表
			fromLocal : function(){
				var _json = CP.Storage.get(lotteryType,true);
				if(_json)
				{
					try{
						g.codes = _json;
						var codes = _json.split(";");

						for(var i=0,l=codes.length;i<l;i++)
						{
							var Q = codes[i].split('_');
							var Q1 = '';
							if(Q[0] == '0'){//大小单双
								Q1 = 1;
							}else if(Q[0] == '1'){//一星直选
								Q1 = Q[1].split(',').length;
							}else if(Q[0] == '6'){//二星组选
								Q1 = Q[1].split(',').length;
								if(Q1==2){
									Q1 = 1;
								}else if(Q1>2){
									Q1 = CP.math.C(Q1,2)+Q1;
								}
							}else if(Q[0] == '7'){//三星组三
								Q1 = Q[1].split(',').length;
								if(Q1>=2){
									Q1 = CP.math.C(Q1,2)*2;
								}
							}else if(Q[0] == '8'){//三星组六
								Q1 = Q[1].split(',').length;
								if(Q1>=3){
									Q1 = CP.math.C(Q1,3);
								}
							}else if(Q[0] == '9'){//二星和值
								var Q2 = Q[1].split(',');
								Q1 = 1;
								for(var ii=0,l=Q2.length; ii<l; i++){
									Q1 *= g.exhz[Q2[ii]];
								}
							}else{//2-5
								var Q2 = Q[1].split(',');
								Q1 = 1;
								for(var ii=0,l=Q2.length; ii<l; ii++){
									Q1 *= Q2[ii].split('').length;
								}
							}
							o.addToList([Q[1], Q1], g.wf[Q[0]], Q[0]);
						}
						o.countAll();
					}
					catch(e){
						sessionStorage.removeItem(lotteryType);
					}
				}
			},
			/*获取购买的各种参数 [[*/
			getArgument : function(t){
				var buy = {};
				var code = CP.Util.joinString(s[lotteryType].lot_id, g.codes);
				switch(t){
					/* 1:自购 2:合买 3:追号 */
					case 1:
						buy = {//投注参数
								payUrl:    '/trade/pcast.go',//投注接口
								gid:       s[lotteryType].lot_id,//彩种id
								pid:       g.qihao_id,//期号
								codes:     code,//投注内容
								muli:      g.beishu,//倍数
								countMoney:g.totalMoney,//方案金额
								orderType:'dg'//代购
						};
						break;
					case 3:
						var muli = '', pid = g.qihao_id;
						for(var i=0;i<g.qishu;i++){muli += g.beishu+',';pid += ',';}
						pid = pid.substring(0, pid.length-1);
						muli = muli.substring(0, muli.length-1);
						buy = {//投注参数
							payUrl:    '/trade/zcast.go',//投注接口
							gid:       s[lotteryType].lot_id,//彩种id
							pid:       pid,//期号串
							codes:     code,//投注内容
							muli:      muli,//倍数串
							countMoney:g.totalMoney,//追号总金额
							zflag : $('.zjStop em').hasClass('nocheck')? '0' : '1',//中奖标识0  中奖不停止  1  中奖停止  3 盈利停止
							orderType:'zh'//追号
						};
						break;
				}
				return buy;
			},
			/*获取购买的各种参数 ]]*/

			/*拼凑购买弹窗需要的参数[[*/
			dopay : function(){
				g.qishu=parseInt($('#tbox_qishu').val());
				g.qishu>1? g.buyType=3 : g.buyType=1;//追号、自购
				var _obj = o.getArgument(g.buyType);
				var cMoney = g.totalMoney;
				var data = {//支付弹框参数
						gid:     s[lotteryType].lot_id,//彩种id
						cMoney:  cMoney,//需支付金额
						payPara: _obj//jQuery.param(param)
				};
				alert('提交中，请稍后！','loading');
				CP.User.info(function(options){
					remove_alert();
					if (options) {jQuery.extend(data, options);}
					CP.Popup.buybox(data);
				});
				sessionStorage.removeItem(lotteryType);//购买的时候情况sessionstorage
			},
			/*购买弹窗]]*/
			
			/*购买验证[[*/
			dobuy : function(){
				var info = '';
				if(g.count_zs<1){//投注列表没有内容
					info = '请至少选择一注彩票';
				}else if(!g.qishu){
					info = '请输入期数';
				}else if(!g.beishu){
					info = '请输入倍数';
				}
				if(info!=''){alert(info);return}
				o.dopay();
			}
			/*购买验证]]*/
	};
	var bind = function () {
		$('#content_kp').find('.jxsscxhBall b').Touch({fun:function(el){ o.clickBall(el,'red');}});
		$('#deleted').bind(start_ev,function(){o.clear($('#rx .ssqBall cite, #qe .ssqBall cite, #qs .ssqBall cite'));});//清空
		$('#shake').bind(start_ev,function(){o.jxNum(1,0);});//机选1注
		$('#jxbtn').bind(start_ev,function(){o.jxNum(1,1);});//机选1注|投注列表机选
		$('#addlist').bind("click",function(){o.addList();});//添加到投注列表
		$('#hand').bind(start_ev,function(){location.href='#type=url&p=list/'+lotteryType+'.html';});
		$('#dobuy').bind(start_ev,function(){o.dobuy();});//代购
		$('#clearAll').bind(start_ev,function(){//清空投注列表
			$('#bet_list').html('');
			$("#tbox_qishu").val("1");
			$("#tbox_beishu").val("1");
			CP.Storage.remove(lotteryType,true);
			o.countAll();//统计总金额 注数
			if(g.qishu>1){
				$('#dohm').addClass('fqhmGray');
				$('.zjStop').show();
			}else{
				$('#dohm').removeClass('fqhmGray');
				$('.zjStop').hide();
			}
		});
		$('#bet_list').delegate('.errorBg',end_ev,function(){//删除单注
			$(this).parent().remove();
			o.countAll();
			o.setLocal();
		});
		
		/*绑定倍数、期数初始值[[*/
        var buyTimes = 1;
        var zuiqishuNum = 1;
		$('#tbox_beishu').KeyBoard({
			val : buyTimes,
			max : 999,
			min : 1,
			num : 1,
			tag : '倍',
			fn  : function(){g.beishu=$(this.ts).val();o.countAll();}
		});
		$('#tbox_qishu').KeyBoard({
			val : zuiqishuNum,
			max : 100,
			min : 1,
			num : 1,
			tag : '期',
			fn  : function(){
				g.qishu=$(this.ts).val();
				g.qishu>1 ? $('.zjStop').show() : $('.zjStop').hide();
				o.countAll();
			}
		});
		/*]]绑定倍数、期数初始值*/
		
		$('.zjStop').bind(start_ev, function () {
			$(this).find('em').toggleClass('nocheck check');
		});
		
		/*显示历史开奖[[*/
		$('.k3kj').bind(start_ev, function(){
			$(this).find('.kjup').toggleClass('kjdown');
			$('#kj_code').toggle();
		});
		$('#kj_code').bind(start_ev, function(){
			$(this).toggle();
			$('.k3kj').find('.kjup').toggleClass('kjdown');
		});
        /*]]显示历史开奖*/
		
		/*摇一摇[[*/
		Shake.run(function(){
			o.jxNum(1,0);
		});
		/*摇一摇]]*/
	};
	var init = function () {
		o.fromLocal();
		o.pageGo.goBack();
		//玩法切换
        o.slide({
            'effect':'swing',//切换效果
            'menuSpeed':200,//菜单滑动时间
            'conSpeed':350,//内容滑动时间
            'menu':'#play_tabs li',//点击tab切换
            'con':'#content_kp article'//对应的内容块
        });
        setTimeout(function(){
 		   navScroll = new iScroll('secNav', {
 		        snap: 'li',
 		        hScrollbar: false,
 		        hScroll: true,
 		        vScroll: false
 		    });
 		},100 );
 
        o.init();
        bind();
	};
	return {init:init,
			openList : o.openList,
			pageGo : o.pageGo
		};
})();
CP.SSC.init();
function resetPage(){
	CP.SSC.pageGo.goBack();
	$("#betball").show();
	$("#betlist").hide();
	$('#lot_footer').removeClass('fo_buy').addClass('fo_basket');//显示手动选号区块
}