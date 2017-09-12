/*
 * Author: weige
 * Date:  2014-09-03
 */
var fps = 1000;
var curTime_ = new Date().getTime();
/**
 * @namespace 十一选五投注页类
 * @name Sx5
 * @author wangwei
 * @memberOf CP
 */
var omit = {};
CP.Sx5 = function () {
	var a = {
			k3kj : $('.k3kj'),
			kj_code : $('#kj_code'),
			play_tabs : $('#play_tabs'),
			content : $('#content'),
			rx : $('#rx'),
			qe : $('#qe'),
			qs : $('#qs'),
			zs_ : $('#zs_'),
			Wobble : $('.shakeomit'),
			pay_ : $('#pay_'),
			gid : $('#lotid')
	};
	var c = {
			  bindEvent: function () {
				  topNavInit();
				  D.load();c.info();c.init();
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
				 // 显示隐藏开奖
				  a.k3kj.Touch(function(){
					  $(this).find('.kjup').toggleClass('kjdown');
					  a.kj_code.toggle();
				  });
				  a.kj_code.Touch(function(){
					  $(this).toggle();
					  a.k3kj.find('.kjup').toggleClass('kjdown');
				  });
				  
				  a.play_tabs.on('click','li',function(){
						if($(this).hasClass('cur')){return;}
						$(this).addClass('cur').siblings().removeClass('cur');
						!$('.kjup').hasClass('kjdown') &&  $('#kj_code').slideUp(); $('.kjup').addClass('kjdown');
						c.clean_();
						var index=a.play_tabs.find('li').index(this);
						$('#bonus_ .shakeomit').siblings().slideUp();
						$('#bonus_ div').eq(index).slideDown();
						var v = $(this).attr('v');
						var t3 = {'qe':'1','qs':'2'}[v]||'0';
						a.content.animate({left:'-'+$(window).width()*t3+'px'},250);
						var o = $(this).prev() .length ? $(this).prev() .last() [0] : $(this)[0];
						navScroll.scrollToElement(o,1200);
						
						var v1 = v.indexOf('rx')>=0 && 'rx' || v;
						if($('#yl').hasClass('red')){
							c.omit_(v);
							$('#'+v1).find('.omitnum').show();
						}else{
							var v1 = v.indexOf('rx')>=0 && 'rx' || v;
							$('#'+v1).find('.omitnum').hide();
						}
						
				  });
				  /*
				   * @description 选号事件
				   */
				  a.rx.find('.ssqBall cite').Touch(function(){
					  $(this).toggleClass('redBall');
					  c.count();
				  });
				  a.qe.find('.ssqBall:eq(0) cite').Touch(function(){//前二
					  $(this).toggleClass('redBall');
					  var index=a.qe.find('.ssqBall:eq(0)').find('cite').index(this);
					  a.qe.find('.ssqBall:eq(1) cite').eq(index).removeClass('redBall');
					  c.count();
				  });
				  a.qe.find('.ssqBall:eq(1) cite').Touch(function(){
					  $(this).toggleClass('redBall');
					  var index=a.qe.find('.ssqBall:eq(1)').find('cite').index(this);
					  a.qe.find('.ssqBall:eq(0) cite').eq(index).removeClass('redBall');
					  c.count();
				  });
				  a.qs.find('.ssqBall:eq(0) cite').Touch(function(){//前三
					  $(this).toggleClass('redBall');
					  var index=a.qs.find('.ssqBall:eq(0)').find('cite').index(this);
					  a.qs.find('.ssqBall:eq(1) cite').eq(index).removeClass('redBall');
					  a.qs.find('.ssqBall:eq(2) cite').eq(index).removeClass('redBall');
					  c.count();
				  });
				  a.qs.find('.ssqBall:eq(1) cite').Touch(function(){//前三
					  $(this).toggleClass('redBall');
					  var index=a.qs.find('.ssqBall:eq(1)').find('cite').index(this);
					  a.qs.find('.ssqBall:eq(0) cite').eq(index).removeClass('redBall');
					  a.qs.find('.ssqBall:eq(2) cite').eq(index).removeClass('redBall');
					  c.count();
				  });
				  a.qs.find('.ssqBall:eq(2) cite').Touch(function(){//前三
					  $(this).toggleClass('redBall');
					  var index=a.qs.find('.ssqBall:eq(2)').find('cite').index(this);
					  a.qs.find('.ssqBall:eq(1) cite').eq(index).removeClass('redBall');
					  a.qs.find('.ssqBall:eq(0) cite').eq(index).removeClass('redBall');
					  c.count();
				  });
				  $('#deleted').Touch(function(){//机选/清空
					  if($(this).html() == '机选'){
						  c.Wobble();
					  }else{
						  c.clean_();
					  }
				  });
				  $('#shake').click(function(){//摇一摇
					  c.Wobble();
				  });
				  $('#yl').Touch(function(){
					  var v = a.play_tabs.find('.cur').attr('v');
					  var v1 = v.indexOf('rx')>=0 && 'rx' || v;
					  if($(this).hasClass('gray')){
						  $(this).removeClass('gray').addClass('red');
						  $('.omitico').addClass('omitico2');
						  $('#'+v1).find('.omitnum').show();
					  }else{
						  $(this).addClass('gray').removeClass('red');
						  $('.omitico').removeClass('omitico2');
						  $('#'+v1).find('.omitnum').hide();
					  }
					  c.omit_(v);
				  });
				  a.pay_.on('click',function(){//投注
						var zs = parseInt($('#zs_ cite:eq(0)').html());
						if(zs == 0){
							c.Wobble();
						}else{
							var code = '';
							code = c.code(zs);
							var sx5SelectNum = localStorage.getItem('11x5_SelectNum');
							(sx5SelectNum && (sx5SelectNum += code)) || (sx5SelectNum = code);
							localStorage.setItem('11x5_SelectNum',sx5SelectNum);
							location.href = '#class=url&xo=11x5/ture.html';
						}
					});
				  jQuery(window).resize(function(){c.init();});//当浏览器大小变化时 自适应宽度
			  },
			  code : function (zs) {
				  var code = '',wf;
				  var v = a.play_tabs.find('.cur').attr('v'),
				  wf = {'rx1':'前一直选','rx2':'任选二','rx3':'任选三','rx4':'任选四','rx5':'任选五','rx6':'任选六',
					  'rx7':'任选七','rx8':'任选八','qe':'前二直选','qs':'前三直选','rxz2':'前二组选','rxz3':'前三组选'}[v];
				  v = v.indexOf('rx')>=0 && 'rx'||v;
				  if(v == 'qe'){
					  $('#'+v).find('.ssqBall:eq(0) .redBall').each(function(){
						  code +=  $(this).html()+' ';
					  });
					  code = code.substr(0,code.length-1)+'|';
					  $('#'+v).find('.ssqBall:eq(1) .redBall').each(function(){
						  code +=  $(this).html()+' ';
					  });
				  }else if(v == 'qs'){
					  $('#'+v).find('.ssqBall:eq(0) .redBall').each(function(){
						  code +=  $(this).html()+' ';
					  });
					  code = code.substr(0,code.length-1)+'|';
					  $('#'+v).find('.ssqBall:eq(1) .redBall').each(function(){
						  code +=  $(this).html()+' ';
					  });
					  code = code.substr(0,code.length-1)+'|';
					  $('#'+v).find('.ssqBall:eq(2) .redBall').each(function(){
						  code +=  $(this).html()+' ';
					  });
				  }else{
					  $('#'+v).find('.redBall').each(function(){
						  code +=  $(this).html()+' ';
					  });
				  }
				  code = code.substr(0,code.length-1);
				  code = '<div class="ssqtzNum" v='+zs+' w='+wf+'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+code+'</span><p>'+wf+' &nbsp;&nbsp;&nbsp;'+zs+'注'+2*zs+'元</p></span></div>'
				  return code;
			  },
			  Wobble : function () {
				  curTime_2 = new Date().getTime();
				  if(curTime_2-curTime_ > '800'){
			  		try{
						navigator.vibrate(300);
					}catch(e){};
			        c.clean_();
			        var v = a.play_tabs.find('.cur').attr('v'),
			        m1,m2,m3,m4;
			        var n_ = {'rx2':'2','rxz2':'2','rx3':'3','rxz3':'3','rx4':'4','rx5':'5','rx6':'6','rx7':'7','rx8':'8'}[v]||'1';
			        if(v == 'qe'){
			        	m1 = c.Random(11);
			        	m2 = m1[5]-1;
			        	m3 = m1[10]-1;
			        	a.qe.find('.ssqBall:eq(0) cite').eq(m3).addClass('redBall');
			        	a.qe.find('.ssqBall:eq(1) cite').eq(m2).addClass('redBall');
			        }else if(v == 'qs'){
			        	m1 = c.Random(11);
			        	m2 = m1[5]-1;
			        	m3 = m1[10]-1;
			        	m4 = m1[1]-1;
			        	a.qs.find('.ssqBall:eq(0) cite').eq(m3).addClass('redBall');
			        	a.qs.find('.ssqBall:eq(1) cite').eq(m2).addClass('redBall');
			        	a.qs.find('.ssqBall:eq(2) cite').eq(m4).addClass('redBall');
			        }else{
			        	m1 = c.Random(11);
			        	for(var n=0; n<n_; n++){
			        		a.rx.find('.ssqBall cite').eq(m1[n]-1).addClass('redBall');
			        	}
			        }
			        c.count();
			        curTime_ = new Date().getTime();  
				  }
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
				  $('#'+v).find('cite').removeClass('redBall');
				  $('#zs_ cite').html('0');
				  $('#deleted').html('机选');
			  },
			  count : function(){
				  var zs = 0,c1,c2,c3;
				  var v = a.play_tabs.find('.cur').attr('v');
				  var n = {'rx2':'2','rxz2':'2','rx3':'3','rxz3':'3','rx4':'4','rx5':'5','rx6':'6','rx7':'7','rx8':'8'}[v]||'1';
				  if(v == 'qe'){
					  c1 = a.qe.find('.ssqBall:eq(0)').find('.redBall').length;
					  c2 = a.qe.find('.ssqBall:eq(1)').find('.redBall').length;
					  zs = c1*c2;
				  }else if(v == 'qs'){
					  c1 = a.qs.find('.ssqBall:eq(0)').find('.redBall').length;
					  c2 = a.qs.find('.ssqBall:eq(1)').find('.redBall').length;
					  c3 = a.qs.find('.ssqBall:eq(2)').find('.redBall').length;
					  zs = c1*c2*c3;
				  }else{//rx
					  c1 = a.rx.find('.redBall').length;
					  zs = $_sys.C(c1,n);
				  }
				  v = v.indexOf('rx')>=0 && 'rx' || v;
				  if($('#'+v).find('.redBall').length){
					  $('#deleted').html('清空');
				  }else{
					  $('#deleted').html('机选');
				  }
				  a.zs_.find('cite:eq(0)').html(zs);
				  a.zs_.find('cite:eq(1)').html(zs*2);
			  },
			  omit_ : function (v){
				  if(v == 'rxz2'){
					  var m2 = omit.m2.split(',');
					  a.rx.find('.omitnum cite').each(function(aa){
							$(this).html(m2[aa]);
					  });
				  }else if(v == 'rxz3'){
					  var m3 = omit.m3.split(',');
					  a.rx.find('.omitnum cite').each(function(aa){
							$(this).html(m3[aa]);
					  });
				  }else if(v == 'qe'){
					  var m1 = omit.m1.split(',');
					  var m4 = omit.m4.split(',');
					  a.qe.find('.omitnum:eq(0) cite').each(function(aa){
							$(this).html(m1[aa]);
					  });
					  a.qe.find('.omitnum:eq(1) cite').each(function(aa){
							$(this).html(m4[aa]);
					  });
				  }else if(v == 'qs'){
					  var m1 = omit.m1.split(',');
					  var m4 = omit.m4.split(',');
					  var m5 = omit.m5.split(',');
					  a.qs.find('.omitnum:eq(0) cite').each(function(aa){
							$(this).html(m1[aa]);
					  });
					  a.qs.find('.omitnum:eq(1) cite').each(function(aa){
							$(this).html(m4[aa]);
					  });
					  a.qs.find('.omitnum:eq(2) cite').each(function(aa){
							$(this).html(m5[aa]);
					  });
				  }else{
					  var m = (v=='rx1') && omit.m1.split(',') || omit.m0.split(',');
					  a.rx.find('.omitnum cite').each(function(aa){
							$(this).html(m[aa]);
					  });
				  }
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
							
							var rp = $(xml).find('rowp');//遗漏
							var m0 = rp.attr('m0');//任选
							var m1 = rp.attr('m1');//前一
							var m2 = rp.attr('m2');//前二组选
							var m3 = rp.attr('m3');//前三组选
							var m4 = rp.attr('m4');//前二
							var m5 = rp.attr('m5');//前三
							omit = {'m0':m0,'m1':m1,'m2':m2,'m3':m3,'m4':m4,'m5':m5};
							
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
										h += '<p class="center">'+p+'期开奖</p>';
										h += '<div class="kjdice pdTop03 clearfix"><b>'+code[0]+'</b><b>'+code[1]+'</b><b>'+code[2]+'</b><b>'+code[3]+'</b><b>'+code[4]+'</b><em class="kjup kjdown"></em></div>'
									}else{
										h += '<p class="pdLeft06">'+p+'期开奖中…</p>';
										h += '<div class="pdTop03 k3waitkj clearfix"><cite class="k3time"></cite><span class="left">等待开奖</span><em class="kjup kjdown"></em></div>';
									}
									$('.k3kjtext').html(h);
								}else{
									html += '<ul><li class="first">'+p+'期</li><li><span class="red">'+cc.replace(/,/g,' ')+'</span></li><li class="last">';
									if(tn == 10){
										html += '<span class="zjbtn"><cite></cite>中奖</span>';
									}else if(tn == 9){
										html += '<span class="wzjbtn"><cite></cite>未中</span>';
									}
									html += '</li></ul>';
								}
							});
							$('#kj_code').html(html);
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
					$('#11x5>strong').html(msg);
				  }else{
					  msg = '已截止';
					  $('#11x5>strong').html(msg);
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
			  init : function (){//设置每个玩法宽度
				  var w = $(window).width()+'px';
				  a.rx.css('width',w);
				  a.rx.find('.omitnum').css('width',w);
				  a.qe.css('width',w);
				  a.qe.find('.omitnum').css('width',w);
				  a.qs.css('width',w);
				  a.qs.find('.omitnum').css('width',w);
				  a.content.parent().css('width',w);
				  
				  var cur = a.play_tabs.find('.cur').attr('v');//当前玩法位置
				  cur = {'qe':'1','qs':'2'}[cur]||'0';
				  a.content.animate({left:'-'+$(window).width()*cur+'px'},200);
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
    var e = function () {c.Wobble();};
    var clean = function () {c.clean_();};
    return {init: d,wobble: e,clean: clean};
}();

function topNavInit() {
	setTimeout(function(){
		 var k = $('#secNav ul');
		    var f = 0;
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
CP.Sx5.init();