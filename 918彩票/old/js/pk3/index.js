/*
 * Author: weige
 * Date:  2014-08-26
 */
var fps = 1000;
/**
 * @namespace 七乐彩投注页类
 * @name Pk3
 * @author wangwei
 * @memberOf CP
 */
CP.Pk3 = function () {
	var a = {
			k3kj : $('.k3kj'),
			kj_code : $('#kj_code'),
			play_tabs : $('#play_tabs'),
			content : $('#content'),
			rx : $('#rx'),
			dz : $('#dz'),
			bz : $('#bz'),
			sz : $('#sz'),
			th : $('#th'),
			ths : $('#ths'),
			zs_ : $('#zs_'),
			Wobble : $('.shakeomit'),
			pay_ : $('#pay_'),
			gid : $('#lotid')
	};
	var b = {//必选个数
		'rx1' : [5,1],
		'rx2' : [33,2],
		'rx3' : [116,3],
		'rx4' : [46,4],
		'rx5' : [22,5],
		'rx6' : [12,6],
		'dz' : [88,1],
		'sz' : [400,1],
		'bz' : [6400,1],
		'th' : [90,1],
		'ths' : [2150,1],
		'dzbx' : [7,1],
		'szbx' : [33,1],
		'bzbx' : [500,1],
		'thbx' : [22,1],
		'thsbx' : [535,1]
	};
	var c = {
			  bindEvent: function () {
				  topNavInit();
//				  D.load();
				  c.info();
//				  c.init();
				  
				  //右上角菜单显示或隐藏
				  $("#pullIco").Touch(function(){
					  if($("#pullText").is(':hidden')){
						  $("#tm_c").show();
					  }else{
						  $("#tm_c").hide();
					  }
					  $(this).parent().toggleClass("pullHover");
					  $("#pullText").toggle();
				  });
				  $('#tm_c').click(function(){
					  $(this).toggle();
					  $('#pullIco').parent().toggleClass("pullHover");
					  $("#pullText").toggle();
					
				  });
//				  显示隐藏开奖
				  a.k3kj.Touch(function(){
					  $(this).find('.kjup').toggleClass('kjdown');
					  a.kj_code.toggle();
				  });
				  a.kj_code.Touch(function(){
					  $(this).toggle();
					  a.k3kj.find('.kjup').toggleClass('kjdown');
				  });
				  
				  a.play_tabs.on('click','li',function(){
					  	var v = $(this).attr('v'),v1;
						if($(this).hasClass('cur')){
							return;
						}
						$('#zj_detail').hide();
						$(this).addClass('cur').siblings().removeClass('cur');
						$('#rx,#dz,#bz,#sz,#th,#ths').hide();
						v1 = v.indexOf('rx') >=0 && 'rx' || v;
						$('#'+v1).show();
//						!$('.kjup').hasClass('kjdown') &&  $('#kj_code').slideUp(); $('.kjup').addClass('kjdown');
						c.clean_();
						
						var index=a.play_tabs.find('li').index(this);
						$('#bouns_ div').hide();
						a.Wobble.show();
						$('#bouns_ div:eq('+index+')').show();
//						 var v = $(this).attr('v');
//						 var t3 = {'dz':'1','bz':'2','sz':'3','th':'4','ths':'5'}[v]||'0';
//						 a.content.animate({left:'-'+$(window).width()*t3+'px'},300);
						 
						 
						 
//						 v = {'zx':'0','zs':'1','hz':'2','zsbh':'3','zlbh':'4'}[v]||'0';
//						 $('#bonus_details .shakeOmit').siblings().slideUp();
//						 $('#bonus_details div').eq(v).slideDown();
						 
						
						
//						$('#bonus_ div').hide();
//						var n_ = {'dxds':0,'yzx':1,'ezx':2,'szx':3,'wzx':4,'wtx':5,'ezux':6,'szs':7,'szl':8,'ehz':9}[v];
						
//						var o = $(this).prev() .length ? $(this).prev() .last() [0] : $(this)[0];
//						navScroll.scrollToElement(o,1500);
//						$('#bonus_ div').eq(n_).show();
//						WW.color_();
				  });
				  /*
				   * @description 选号事件
				   */
				  a.rx.find('li').Touch(function(){
					  $(this).toggleClass('cur');
					  c.count();
					  c.winner();
				  });
				  a.dz.find('li').Touch(function(){
					  $(this).toggleClass('cur');
					  c.count();
					  c.winner();
				  });
				  a.bz.find('li').Touch(function(){
					  $(this).toggleClass('cur');
					  c.count();
					  c.winner();
				  });
				  a.sz.find('li').Touch(function(){
					  $(this).toggleClass('cur');
					  c.count();
					  c.winner();
				  });
				  a.th.find('li').Touch(function(){
					  $(this).toggleClass('cur');
					  c.count();
					  c.winner();
				  });
				  a.ths.find('li').Touch(function(){
					  $(this).toggleClass('cur');
					  c.count();
					  c.winner();
				  });
				  $('#shake').click(function(){//摇一摇
					  c.Wobble();
				  });
				  $('#deleted').Touch(function(){//机选/清空
					  if($(this).html() == '机选'){
						  c.Wobble();
					  }else{
						  c.clean_();
					  }
				  });
				  a.pay_.on('click',function(){//投注
						var zs = parseInt($('#zs_ cite:eq(0)').html());
						if(zs == 0){
							c.Wobble();
						}else{
							var code = '';
							code = c.code(zs);
							var pk3SelectNum = localStorage.getItem('pk3_SelectNum');
							(pk3SelectNum && (pk3SelectNum += code)) || (pk3SelectNum = code);
							localStorage.setItem('pk3_SelectNum',pk3SelectNum);
							location.href = '#class=url&xo=pk3/ture.html';
						}
					});
			  },
			  winner : function () {
				  var msg = '', arr = [];
				  var v = a.play_tabs.find('.cur').attr('v');
				  if(v == 'rx1'){
					  var rx1 = a.rx.find('.cur').length;
					  (rx1>=3) && arr.push('15');
					  (rx1>=2) && arr.push('10');
					  (rx1>=1) && arr.push('5');
				  }else if(v == 'rx2'){
					  var rx2 = a.rx.find('.cur').length;
					  (rx2>=3) && arr.push('99');
					  (rx2>=2) && arr.push('33');
				  }else if(v == 'rx3'){
					  var rx3 = a.rx.find('.cur').length;
					  (rx3>=3) && arr.push('116');
					  (rx3>3) && arr.push($_sys.C((rx3-1), (2))*116);
				  }else if (v == 'rx4') {
					  var rx4 = a.rx.find('.cur').length;
					  if(rx4>=4){
						  arr.push($_sys.C((rx4-1), (3))*46);
						  arr.push($_sys.C((rx4-3), (1))*46);
					  }
				  }else if (v == 'rx5'){
					  var rx5 = a.rx.find('.cur').length;
					  if(rx5>=5){
						  arr.push($_sys.C((rx5-1), (4))*22);
						  arr.push($_sys.C((rx5-3), (2))*22);
					  }
				  }else if (v == 'rx6'){
					  var rx6 = a.rx.find('.cur').length;
					  if(rx6>=6){
						  arr.push($_sys.C((rx6-1), (5))*12);
						  arr.push($_sys.C((rx6-3), (3))*12);
					  }
				  }else if (v == 'dz') {
					  var dz = a.dz.find('.cur').length;
					  if(a.dz.find('.pkbzbx').find('.cur').length){
						  (dz > 1) && arr.push('95') || arr.push('7');
					  }else if(dz){
						  arr.push('88');
					  }
				  }else if (v == 'bz') {
					  var bz = a.bz.find('.cur').length;
					  if(a.bz.find('.pkbzbx').find('.cur').length){
						  (bz > 1) && arr.push('6900') || arr.push('500');
					  }else if(bz){
						  arr.push('6400');
					  }
				  }else if (v == 'sz') {
					  var sz = a.sz.find('.cur').length;
					  if(a.sz.find('.pkbzbx').find('.cur').length){
						  (sz > 1) && arr.push('433') || arr.push('33');
					  }else if(sz){
						  arr.push('400');
					  }
				  }else if (v == 'th') {
					  var th = a.th.find('.cur').length;
					  if(a.th.find('.pkbzbx').find('.cur').length){
						  (th > 1) && arr.push('112') || arr.push('22');
					  }else if(th){
						  arr.push('90');
					  }
				  }else if (v == 'ths') {
					  var ths = a.ths.find('.cur').length;
					  if(a.ths.find('.pkbzbx').find('.cur').length){
						  (ths > 1) && arr.push('2685') || arr.push('535');
					  }else if(ths){
						  arr.push('2150');
					  }
				  }
				  if(arr.length){
						var a1,b;
						arr.sort(function(a,b){return a-b;});
						a1 = arr[0],b=arr[arr.length-1];//a 最小 b最大
						
						if(a1 == b){
							msg = '若中奖,奖金 '+a1+'元';
						}else{
							msg = '若中奖,奖金 '+a1+'元~'+b+'元';
						}
						
						
						!$('#zj_detail').html() && $('#zj_detail').slideToggle('fast');
						$('#zj_detail').html(msg);
					}else{
						$('#zj_detail').html('');
						$('#zj_detail').hide();
					}
			  },
			  code : function (zs) {
				  var code = '',wf;
				  var v = a.play_tabs.find('.cur').attr('v'),
				  wf = {'rx1':'选一','rx2':'选二','rx3':'选三','rx4':'选四','rx5':'选五','rx6':'选六','dz':'对子','bz':'豹子','sz':'顺子','th':'同花','ths':'同花顺'}[v];
				  v = v.indexOf('rx')>=0 && 'rx'||v;
				  $('#'+v).find('.cur').each(function(){
					  code +=  $(this).attr('v')+' ';
				  });
				  code = code.substr(0,code.length-1);
				  code = '<p v='+zs+' w='+wf+'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+code+'</span><b>'+wf+' &nbsp;共'+zs+'注'+2*zs+'元</b></span></p>'
				  return code;
			  },
			  Wobble : function () {
			  		try{
						navigator.vibrate(300);
					}catch(e){};
			        c.clean_();
			        var v = a.play_tabs.find('.cur').attr('v'),
			        m1,m2,m3,m4,m5,m6;
			        if(v == 'rx1'){
			        	m1 = c.Random(13)[5]-1;
			        	a.rx.find('li').eq(m1).addClass('cur');
			        }else if(v == 'rx2'){
			        	m1 = c.Random(13);
			        	m2 = m1[6]-1;
			        	a.rx.find('li').eq(m2).addClass('cur');
			        	m2 = m1[2]-1;
			        	a.rx.find('li').eq(m2).addClass('cur');
			        }else if(v == 'rx3'){
			        	m1 = c.Random(13);
			        	m2 = m1[6]-1;
			        	a.rx.find('li').eq(m2).addClass('cur');
			        	m2 = m1[2]-1;
			        	a.rx.find('li').eq(m2).addClass('cur');
			        	m3 = m1[12]-1;
			        	a.rx.find('li').eq(m3).addClass('cur');
			        }else if(v == 'rx4'){
			        	m1 = c.Random(13);
			        	m2 = m1[6]-1;
			        	a.rx.find('li').eq(m2).addClass('cur');
			        	m2 = m1[2]-1;
			        	a.rx.find('li').eq(m2).addClass('cur');
			        	m3 = m1[12]-1;
			        	a.rx.find('li').eq(m3).addClass('cur');
			        	m4 = m1[1]-1;
			        	a.rx.find('li').eq(m4).addClass('cur');
			        }else if(v == 'rx5'){
			        	m1 = c.Random(13);
			        	m2 = m1[6]-1;
			        	a.rx.find('li').eq(m2).addClass('cur');
			        	m2 = m1[2]-1;
			        	a.rx.find('li').eq(m2).addClass('cur');
			        	m3 = m1[12]-1;
			        	a.rx.find('li').eq(m3).addClass('cur');
			        	m4 = m1[1]-1;
			        	a.rx.find('li').eq(m4).addClass('cur');
			        	m5 = m1[3]-1;
			        	a.rx.find('li').eq(m5).addClass('cur');
			        }else if(v == 'rx6'){
			        	m1 = c.Random(13);
			        	m2 = m1[6]-1;
			        	a.rx.find('li').eq(m2).addClass('cur');
			        	m2 = m1[2]-1;
			        	a.rx.find('li').eq(m2).addClass('cur');
			        	m3 = m1[12]-1;
			        	a.rx.find('li').eq(m3).addClass('cur');
			        	m4 = m1[1]-1;
			        	a.rx.find('li').eq(m4).addClass('cur');
			        	m5 = m1[3]-1;
			        	a.rx.find('li').eq(m5).addClass('cur');
			        	m6 = m1[8]-1;
			        	a.rx.find('li').eq(m6).addClass('cur');
			        }else if(v == 'dz'){
			        	m1 = c.Random(13)[5]-1;
			        	a.dz.find('li').eq(m1).addClass('cur');
			        }else if(v == 'sz'){
			        	m1 = c.Random(12)[5]-1;
			        	a.sz.find('li').eq(m1).addClass('cur');
			        }else if(v == 'bz'){
			        	m1 = c.Random(13)[5]-1;
			        	a.bz.find('li').eq(m1).addClass('cur');
			        }else if(v == 'th'){
			        	m1 = c.Random(4)[3]-1;
			        	a.th.find('li').eq(m1).addClass('cur');
			        }else if(v == 'ths'){
			        	m1 = c.Random(4)[2]-1;
			        	a.ths.find('li').eq(m1).addClass('cur');
			        }
			        c.count();
			        c.winner();
			  },
			  Random : function (count) {
				    var original = new Array; //原始数组 
				    //给原始数组original赋值 
					for (var i = 0; i < count; i++) {
				        original[i] = i + 1;
				    }
				    original.sort(function() { return 0.5 - Math.random(); });
				    var arrayList = new Array();
				    for (var i = 0; i < count; i++) {
				        arrayList[i] = original[i];
				    }
				    return arrayList;
			  },
			  clean_ : function () {
				  var v = a.play_tabs.find('.cur').attr('v');
				  v = v.indexOf('rx') >=0 && 'rx'|| v;
				  $('#'+v).find('li').removeClass('cur');
				  $('#zs_ cite').html('0');
				  $('#deleted').html('机选');
				  $('#zj_detail').html('');
				  $('#zj_detail').hide();
			  },
			  count : function(){
				  var zs = 0,c1;
				  var v = a.play_tabs.find('.cur').attr('v');
				  if(v == 'rx1'){
					  c1 = a.rx.find('.cur').length;
					  zs = c1;
				  }else if(v == 'rx2'){
					  c1 = a.rx.find('.cur').length;
					  zs = $_sys.C(c1,2);
				  }else if(v == 'rx3'){
					  c1 = a.rx.find('.cur').length;
					  zs = $_sys.C(c1,3);
				  }else if(v == 'rx4'){
					  c1 = a.rx.find('.cur').length;
					  zs = $_sys.C(c1,4);
				  }else if(v == 'rx5'){
					  c1 = a.rx.find('.cur').length;
					  zs = $_sys.C(c1,5);
				  }else if(v == 'rx6'){
					  c1 = a.rx.find('.cur').length;
					  zs = $_sys.C(c1,6);
				  }else{
					  c1 = $('#'+v).find('.cur').length;
					  zs = c1;
				  }
				  v = v.indexOf('rx')>=0 && 'rx' || v;
				  if($('#'+v).find('.cur').length){
					  $('#deleted').html('清空');
				  }else{
					  $('#deleted').html('机选');
				  }
				  a.zs_.find('cite:eq(0)').html(zs);
				  a.zs_.find('cite:eq(1)').html(zs*2);
			  },
			  info : function(){//填充开奖号码列表
				  $.ajax({
						url : '/trade/info.go?gid='+a.gid.val(),
						type : "POST",
						dataType : "xml",
						success : function(xml) {
							D.load(close);
							var R = $(xml).find("rowc");//当前期
							var p = R.attr('p');//当前期次
							var at = R.attr('t');//当前期截止时间
							$('.k3kjnum').html('<p>距'+p.substr(8)+'期截止</p><strong></strong>');
							var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
							c.expect_change(n_, at);//n_当前时间  a截止时间
							
							var rp = $(xml).find('rowp');
							var m_th = rp.attr('m0').split(',');
							var m_ths = rp.attr('m1').split(',');
							var m_sz = rp.attr('m2').split(',');
							var m_bz = rp.attr('m3').split(',');
							var m_dz = rp.attr('m4').split(',');
							var m_rx = rp.attr('m5').split(',');
							a.rx.find('.pkyl em').each(function(o){
								$(this).html(m_rx[o]);
							});
							a.dz.find('.pkyl2 em').html(m_dz[0]);
							a.dz.find('.pkyl em').each(function(o){
								$(this).html(m_dz[o+1])
							});
							a.bz.find('.pkyl2 em').html(m_bz[0]);
							a.bz.find('.pkyl em').each(function(o){
								$(this).html(m_bz[o+1]);
							});
							a.sz.find('.pkyl2 em').html(m_sz[0]);
							a.sz.find('.pkyl em').each(function(o){
								$(this).html(m_sz[o+1]);
							});
							a.th.find('.pkyl2 em').html(m_th[0]);
							a.th.find('.pkyl em').each(function(o){
								$(this).html(m_th[o+1]);
							});
							a.ths.find('.pkyl2 em').html(m_ths[0]);
							a.ths.find('.pkyl em').each(function(o){
								$(this).html(m_ths[o+1]);
							});
							
							var r = $(xml).find('row');
							var html = '';
							r.each(function(aa) {
								var tn = $(this).attr('tn');//10 成功且中奖 9成功未中奖 6成功未开奖 8失败且中奖 7 失败未中奖 5失败未开奖 0 用户未投注
								var p = $(this).attr('p');//期号
								p = p.substr(8);
								var cc = $(this).attr('c');//开奖号码
								code = cc.split(',');
								if(aa == 0){
									var h = '';
									if(cc != ''){
										var t = code[0],t1,t2;
										t1 = {'1':'spade','2':'heart','3':'club','4':'box'}[t.substr(0,1)];//黑红梅方
										t2 = {'heart':'class=red','box':'class=red'}[t1]||'';
										t = t.substr(1);
										t = {'01':'A','11':'J','12':'Q','13':'K'}[t]||parseInt(t);
										h += '<p>'+p+'期开奖</p>';
										h += '<div class="pkkjCard clearfix">';
										h += '<span><em '+t2+'>'+t+'</em><cite class='+t1+'></cite></span>';
										t = code[1];
										t1 = {'1':'spade','2':'heart','3':'club','4':'box'}[t.substr(0,1)];//黑红梅方
										t2 = {'heart':'class=red','box':'class=red'}[t1]||'';
										t = t.substr(1);
										t = {'01':'A','11':'J','12':'Q','13':'K'}[t]||parseInt(t);
										h += '<span><em '+t2+'>'+t+'</em><cite class='+t1+'></cite></span>';
										t = code[2];
										t1 = {'1':'spade','2':'heart','3':'club','4':'box'}[t.substr(0,1)];//黑红梅方
										t2 = {'heart':'class=red','box':'class=red'}[t1]||'';
										t = t.substr(1);
										t = {'01':'A','11':'J','12':'Q','13':'K'}[t]||parseInt(t);
										h += '<span><em '+t2+'>'+t+'</em><cite class='+t1+'></cite></span><em class="kjup kjdown"></em></div>';
									}else{
										h += '<p class="pdLeft06">'+p+'期开奖中…</p>';
										h += '<div class="pdTop03 k3waitkj clearfix"><cite class="k3time"></cite><span class="left">等待开奖</span><em class="kjup kjdown"></em></div>';
									}
									$('.k3kjtext').html(h);
								}else{
									html += '<ul><li class="wb20">'+p+'期</li>';
									var t = code[0],t1,t2;
									t1 = {'1':'spade','2':'heart','3':'club','4':'box'}[t.substr(0,1)];//黑红梅方
									t2 = {'heart':'class=red','box':'class=red'}[t1]||'';
									t = t.substr(1);
									t = {'01':'A','11':'J','12':'Q','13':'K'}[t]||parseInt(t);
									html += '<li class="kjdice"><span><cite class='+t1+'></cite><em '+t2+'>'+t+'</em></span>';
									t = code[1];
									t1 = {'1':'spade','2':'heart','3':'club','4':'box'}[t.substr(0,1)];//黑红梅方
									t2 = {'heart':'class=red','box':'class=red'}[t1]||'';
									t = t.substr(1);
									t = {'01':'A','11':'J','12':'Q','13':'K'}[t]||parseInt(t);
									html += '<span><cite class='+t1+'></cite><em '+t2+'>'+t+'</em></span>';
									t = code[2];
									t1 = {'1':'spade','2':'heart','3':'club','4':'box'}[t.substr(0,1)];//黑红梅方
									t2 = {'heart':'class=red','box':'class=red'}[t1]||'';
									t = t.substr(1);
									t = {'01':'A','11':'J','12':'Q','13':'K'}[t]||parseInt(t);
									html += '<span><cite class='+t1+'></cite><em '+t2+'>'+t+'</em></span></li>';
									t = c.kjtype(code);
									html += '<li class="wb16">'+t+'</li></ul>';
								}
							});
							$('#kj_code div.k3kjlist').html(html);
						},
						error : function() {
							D.load(close);
							D.tx('期号获取失败');
							return false;
						}
					});
			  },
			  expect_change:function(now, endtime){
					 this.now = now.getTime();
					 this.endtime_ = new Date(endtime.replace(/-/g , '/'));
					 clearInterval(this.timer);
					 this.timer = setInterval(function (){
						 c.eachClock();
					 }, fps); 
					 c.eachClock();
			  },
			  eachClock:function(){//Countdown
				  this.now += fps;
				  var diff = this.endtime_ - this.now;
				  var msg = '';
				  if(diff >= 0){
					  timeout = c.diffToString(diff,false);
					  msg = timeout[1]+''+timeout[2]+':'+zeroStr(timeout[3],2);
					  $('#pk3>strong').html(msg);
				  }else{
					  msg = '已截止';
					  $('#pk3>strong').html(msg);
					  clearInterval(this.timer);
					  setTimeout(function(){
						  c.info();
					  },2000);
				  }
			  },
			  diffToString : function(num, iscn) {
				    var unit = [8.64E+7,3.6E+6,6E+4,1E+3,1], date = [], cnDate = [];
				    var cn = '\u5929,\u65f6,\u5206,\u79d2,\u6beb\u79d2'.split(',');
				    for (var i = 0, l = unit.length; i < l; i++) {
				        date[i] = parseInt(num / unit[i]);
				        cnDate[i] = date[i] + cn[i];
				        num %= unit[i];
				    }
				    return iscn ? cnDate : date;
			  },
			  kjtype: function (d) {
			    	if(d != '' && d.length == 3){
						var a = d[0],b = d[1],c = d[2];
						var a1 = a.substr(0,1);//第一个开奖号码的花色
						var a2 = a.substr(1);//第一个开奖号码的点数
						var b1 = b.substr(0,1);
						var b2 = b.substr(1);
						var c1 = c.substr(0,1);
						var c2 = c.substr(1);
						var sz = [];
						sz[0] = parseInt(a2);
						sz[1] = parseInt(b2);
						sz[2] = parseInt(c2);
						if(a1 == b1 && b1 == c1 && a1 == c1){
							sz = $_sys.sort(sz,'desc');
							if(sz.indexOf(13) >= 0 && sz.indexOf(1) >= 0){
								if(sz.indexOf(12) >= 0 || sz.indexOf(2) >= 0){
									return '同花顺';
								}else{
									return '同花';
								}
							}else{
								if(sz[0] + 1 != sz[1]){
									return '同花';
								}else{
									if(sz[1] + 1 != sz[2]){
										return '同花';
									}else{
										return '同花顺';
									}
								}
							}
						}else{
							if(a2 != b2 || b2 !=c2 || c2 != a2){
								if(a2 == b2 || b2 ==c2 || c2 == a2){
									return '对子';
									
								}else{
									sz = $_sys.sort(sz,'desc');
									if(sz.indexOf(13) >= 0 && sz.indexOf(1) >= 0){
										if(sz.indexOf(12) >= 0){
											return '顺子';
										}else{
											return '';
										}
									}else{
										if(sz[0] + 1 != sz[1]){
											return '';
										}else{
											if(sz[1] + 1 != sz[2]){
												return '';
											}else{
												return '顺子';
											}
										}
									}
								}
							}else{
								return '豹子';
							}
						}
			    	}
			    },
			    init : function (){//设置每个玩法宽度
			    	var w = $(window).width()+'px';
			    	a.rx.css('width',w);
			    	a.dz.css('width',w);
			    	a.bz.css('width',w);
			    	a.sz.css('width',w);
			    	a.th.css('width',w);
			    	a.ths.css('width',w);
			    	a.content.parent().css('width',w);
			  
//			    	var cur = a.nav.find('.cur');//当前玩法位置
//			    	var v = cur.attr('v');
//			    	var t3 = {'zx':'0','zs':'1','hz':'2','zsbh':'3','zlbh':'4'}[v]||'0';
//			    	a.content.animate({left:'-'+$(window).width()*t3+'px'},200);
			    },
			    jz:function(n,m){
					for(var k in n){
						 if(k == m){
							 return n[k];
						 }
					};
			    }
			
	};
	var d = function () {
        c.bindEvent();
    };
    var e = function () {
    	c.Wobble();
    };
    return {init: d, wobble: e};
}();
function topNavInit() {
	setTimeout(function(){
		 var k = $('#secNav ul');
		    var f = 0;
//		    $('#secNav li') .each(function () {
//		        f += $(this) .width() + parseInt($(this).css('margin-left') .replace('px', ''))*2+2;
//		    });
//		    k.width(f);
		    navScroll = new iScroll('secNav', {
		        snap: 'li',
		        hScrollbar: false,
		        hScroll: true,
		        vScroll: false
		    });
	},100 );
}

//数组，数字排序
$_sys.sort= function(a, ad){
	var f = ad!="desc" ? function(a,b){return a-b} : function(a,b){return b-a};
	return a.sort(f);
};
CP.Pk3.init();