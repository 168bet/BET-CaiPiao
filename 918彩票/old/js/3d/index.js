/*
 * Author: weige
 * Date:  2014-08-15
 */

var c_ = '<div id="c" style="position: absolute; z-index: 99999; top: 454px;  background: none repeat scroll 0% 0% rgb(240, 61, 61); opacity: 0.15; width:2rem; line-height:2rem; border-radius:2rem; -webkit-border-radius:2rem; -moz-border-radius:2rem"></div>';
var speed_ = '200';
var f_Wobble = '0';
var curTime_ = new Date().getTime();
/**
 * @namespace 3d投注页类
 * @name Sd
 * @author wangwei
 * @memberOf CP
 */
CP.Sd = function () {
	var a = {
			nav : $('.sdTab ul'),
			nav_c : $('.sdTab .downline'),
			content : $('#content'),
			sdkj : $('.p5kj'),
			kj_code : $('#kj_code'),
			zx : $('#zx'),
			zs : $('#zs'),
			hz : $('#hz'),
			zsbh : $('#zsbh'),
			zlbh : $('#zlbh'),
			zs_ : $('#zs_'),
			Wobble : $('.shakeOmit'),
			pay_ : $('#pay_')
	};
	var b = {//和值 对应注数
			'0': 1,'1': 3,'2': 6,'3': 10,'4': 15,'5': 21,'6': 28,'7': 36,'8': 45,'9': 55,'10': 63,'11': 69,'12': 73,'13': 75,'14': 75,
			'15': 73,'16': 69,'17': 63,'18': 55,'19': 45,'20': 36,'21': 28,'22': 21,'23': 15,'24': 10,'25': 6,'26': 3,'27': 1
	};
	var c = {
			  bindEvent: function () {
				  D.load();
				  c.init();
				  c.info();
				  
				 //切换玩法
				  a.nav.find('li').Touch(function(){
					  var cc = $(this);
					  if($(this).hasClass('cur')){
						  return;
					  }
					  var t =$(this).offset().left;
					  var t1 = $(this).width();
					  a.nav_c.animate({left:t+'px',width:t1+'px'},300,function(){cc.addClass('cur').siblings().removeClass('cur');});
					  
					  var v = $(this).attr('v');
					  var t3 = {'zx':'0','zs':'1','hz':'2','zsbh':'3','zlbh':'4'}[v]||'0';
					  v = {'zx':'0','zs':'1','hz':'2','zsbh':'3','zlbh':'4'}[v]||'0';
					  $('#bonus_details .shakeOmit').siblings().slideUp();
					  $('#bonus_details div').eq(v).slideDown();
					  a.content.animate({left:'-'+$(window).width()*t3+'px'},300);
					  
					  !a.sdkj.find('.p5kjup').hasClass('p5kjdown') && a.sdkj.find('.p5kjup').addClass('p5kjdown');//收起开奖列表
					  a.kj_code.slideUp(300);
					  c.clean_();//左下角清空
				  });
				  
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
				  //显示隐藏开奖
				  a.sdkj.Touch(function(){
					  $(this).find('.p5kjup').toggleClass('p5kjdown');
					  a.kj_code.slideToggle(200);
				  });
				  a.kj_code.Touch(function(){
					  $(this).slideToggle(200);
					  a.sdkj.find('.p5kjup').toggleClass('p5kjdown');
				  });
				  
				  
				  /*
				   * @description 选号事件
				   */
				  a.zx.find('div.jxsscxhBall').eq(0).find('b').click(function(){//直选  - 百位
					  var o = $(this),
					  e_ = $('#zx li:eq(0)');
					  if($(this).hasClass('red')){
						  $(this).removeClass('red');
						  c.remove_(o, e_);
					  }else{
						  $(this).addClass('red');
						  c.move_(o, e_);
					  }
					  c.count();
				  });
				  a.zx.find('div.jxsscxhBall').eq(1).find('b').click(function(){//直选  - 十位
					  var o = $(this),
					  e_ = $('#zx li:eq(1)');
					  if($(this).hasClass('red')){
						  $(this).removeClass('red');
						  c.remove_(o, e_);
					  }else{
						  $(this).addClass('red');
						  c.move_(o, e_);
					  }
					  c.count();
				  });
				  a.zx.find('div.jxsscxhBall').eq(2).find('b').click(function(){//直选  - 个位
					  var o = $(this),
					  e_ = $('#zx li:eq(2)');
					  if($(this).hasClass('red')){
						  $(this).removeClass('red');
						  c.remove_(o, e_);
					  }else{
						  $(this).addClass('red');
						  c.move_(o, e_);
					  }
					  c.count();
				  });
				  a.zs.find('div.jxsscxhBall').eq(0).find('b').Touch(function(){//组三  - 同号
					  if($(this).hasClass('red')){
						  $(this).toggleClass('red');
						  c.count();
					  }else{
						  if(!$(this).parent().find('.red').length){
							  if(!$(this).hasClass('red')){
								  var m = $(this).html();
								  m = {'00':'0','11':'1','22':'2','33':'3','44':'4','55':'5','66':'6','77':'7','88':'8','99':'9'}[m]||'0';
								  a.zs.find('div.jxsscxhBall').eq(1).find('b').eq(m).removeClass('red');
							  }
							  $(this).toggleClass('red');
						  }else{
							  $(this).addClass('red').siblings().removeClass('red');
							  var m = $(this).html();
							  m = {'00':'0','11':'1','22':'2','33':'3','44':'4','55':'5','66':'6','77':'7','88':'8','99':'9'}[m]||'0';
							  a.zs.find('div.jxsscxhBall').eq(1).find('b').eq(m).removeClass('red');
						  }
						  c.count();
					  }
				  });
				  a.zs.find('div.jxsscxhBall').eq(1).find('b').Touch(function(){//组三  - 不同号
					  if($(this).hasClass('red')){
						  $(this).toggleClass('red');
						  c.count();
					  }else{
						  if(!$(this).parent().find('.red').length){
							  if(!$(this).hasClass('red')){
								    var m = $(this).html();
									a.zs.find('div.jxsscxhBall').eq(0).find('b').eq(m).removeClass('red');
							  }
							  $(this).toggleClass('red');
						  }else{
							  $(this).addClass('red').siblings().removeClass('red');
							  var m = $(this).html();
								a.zs.find('div.jxsscxhBall').eq(0).find('b').eq(m).removeClass('red');
						  }
						  c.count();
					  }
				  });
				  a.hz.find('b').Touch(function(){//和值
					  $(this).toggleClass('red');
					  c.count();
				  });
				  a.zsbh.find('b').Touch(function(){//组三包号
					  $(this).toggleClass('red');
					  c.count();
				  });
				  a.zlbh.find('b').Touch(function(){//组六包号
					  $(this).toggleClass('red');
					  c.count();
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
						var n = a.nav.find('.cur').attr('v');
						
						var zs = parseInt($('#zs_ cite:eq(0)').html());
						if(zs == 0){
							c.Wobble();
						}else{
							var code = '';
							code = c.code(n,zs);
							var sdSelectNum = localStorage.getItem('sd_SelectNum');
							(sdSelectNum && (sdSelectNum += code)) || (sdSelectNum = code);
							localStorage.setItem('sd_SelectNum',sdSelectNum);
							location.href = '#class=url&xo=3d/ture.html';
						}
					});
				  jQuery(window).resize(function(){c.init();});//当浏览器大小变化时 自适应宽度
			  },
			  code : function (n,zs) {
				  var code = '',wf,c1='',c2='',c3='';
				  wf = {'zx':'直选','hz':'和值','zs':'组三','zsbh':'组三包号','zlbh':'组六包号'}[n];
				  if(n == 'zx'){
					  $('#'+n).find('div:eq(0)').find('.red').each(function(){
						  	c1 +=  $(this).html()+' ';
					  });
					  c1 = c1.substr(0,c1.length-1);
					  $('#'+n).find('div:eq(1)').find('.red').each(function(){
							c2 +=  $(this).html()+' ';
					  });
					  c2 = c2.substr(0,c2.length-1);
					  $('#'+n).find('div:eq(2)').find('.red').each(function(){
							c3 +=  $(this).html()+' ';
					  });
					  c3 = c3.substr(0,c3.length-1);
					  code = c1+','+c2+','+c3;
				  }else if(n == 'zs'){
					  c1 = $('#'+n).find('div:eq(0)').find('.red').html();
					  c2 = $('#'+n).find('div:eq(1)').find('.red').html();
					  code = c1.split('')+','+c2;
				  }else if(n == 'hz'){
					  $('#'+n).find('.red').each(function(){
						  c1 += $(this).html()+',';
					  });
					  code = c1.substr(0,c1.length-1);
				  }else if(n == 'zsbh' || n == 'zlbh'){
					  $('#'+n).find('.red').each(function(){
						  c1 += $(this).html();
					  });
					  code = c1.split('');
				  }
				  code = '<p v='+zs+' w='+wf+'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+code+'</span><b>'+wf+' &nbsp;共'+zs+'注'+2*zs+'元</b></span></p>'
				  return code;
			  },
			  Wobble : function () {
				  curTime_2 = new Date().getTime();
				  var n = a.nav.find('.cur').attr('v'),
				  m1,m2,m3;
				  sp = {'zx':'1500'}[n]||'500';
				  if(curTime_2-curTime_ > sp || f_Wobble == '0'){
					  f_Wobble++;
					  try{
						  navigator.vibrate(300);
					  }catch(e){};
					  c.clean_();
					  
					  if(n == 'zx'){
						  m1 = c.Random(10)[5]-1;
						  m2 = c.Random(10)[7]-1;
						  m3 = c.Random(10)[2]-1;
						  $('#'+n).find('div:eq(0)').find('b').eq(m1).click();
						  setTimeout(function(){
							  $('#'+n).find('div:eq(1)').find('b').eq(m2).click();
						  },500);
						  setTimeout(function(){
							  $('#'+n).find('div:eq(2)').find('b').eq(m3).click();
						  },1000);
					  }else if(n == 'zs'){
						  m3 = c.Random(10);
						  m1 = m3[7]-1;
						  m2 = m3[2]-1;
						  $('#'+n).find('div:eq(0)').find('b').eq(m1).addClass('red');
						  $('#'+n).find('div:eq(1)').find('b').eq(m2).addClass('red');
					  }else if(n == 'hz'){
						  m1 = c.Random(28)[12]-1;
						  $('#'+n).find('b').eq(m1).addClass('red');
					  }else if(n == 'zsbh'){
						  m3 = c.Random(10);
						  m1 = m3[7]-1;
						  m2 = m3[2]-1;
						  $('#'+n).find('b').eq(m1).addClass('red');
						  $('#'+n).find('b').eq(m2).addClass('red');
					  }else if(n == 'zlbh'){
						  m4 = c.Random(10);
						  m1 = m4[5]-1;
						  m2 = m4[9]-1;
						  m3 = m4[2]-1;
						  $('#'+n).find('b').eq(m1).addClass('red');
						  $('#'+n).find('b').eq(m2).addClass('red');
						  $('#'+n).find('b').eq(m3).addClass('red');
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
				  	var n = a.nav.find('.cur').attr('v');
					$('#'+n).find('b').removeClass('red');
					if(n == 'zx'){
						$('#'+n).find('li[m=y]').each(function(){
							$(this).find('span').html($(this).attr('v'));
							$(this).attr('class','cur');
						});
					}
					$('#zs_ cite').html('0');
					$('#deleted').html('机选');
			  },
			  count : function(){
				  var wf = a.nav.find('.cur').attr('v');
				  var zs = 0,one,two,three;
				  if(wf == 'zx'){
					  one = $('#'+wf).find('div.jxsscxhBall').eq(0).find('.red').length;
					  two = $('#'+wf).find('div.jxsscxhBall').eq(1).find('.red').length;
					  three = $('#'+wf).find('div.jxsscxhBall').eq(2).find('.red').length;
					  zs = one*two*three;
				  }else if(wf == 'zs'){
					  one = $('#'+wf).find('div.jxsscxhBall').eq(0).find('.red').length;
					  two = $('#'+wf).find('div.jxsscxhBall').eq(1).find('.red').length;
					  zs = one*two;
				  }else if(wf == 'hz'){
					  var n = $('#'+wf).find('.red');
					  n.each(function(){
						  zs += parseInt(c.jz(b,$(this).html()));
					  });
				  }else if(wf == 'zsbh'){
					  one = $('#'+wf).find('.red').length;
					  zs = $_sys.C(one,2)*2;
				  }else if(wf == 'zlbh'){
					  one = $('#'+wf).find('.red').length;
					  zs = $_sys.C(one,3);
				  }
				  if(!!$('#'+wf).find('.red').length){
					  $('#deleted').html('清空');
				  }else{
					  $('#deleted').html('机选');
				  }
				  a.zs_.find('cite:eq(0)').html(zs);
				  a.zs_.find('cite:eq(1)').html(zs*2);
			  },
			  move_: function(star,end){
					$('#c').show();
					var w = star.width();
					var h = star.height();
					var o = star.offset();
					var t = parseInt(o.top);
					var l = parseInt(o.left);
					$('body').append(c_);
					$('#c').css({left:l,top:t,width:w,height:h});
					
					//-------------------------------------------------
					var w_ = end.width();
					var h_ = end.height();
					var o_ = end.offset();
					var t_ = parseInt(o_.top);
					var l_ = parseInt(o_.left);
					t_ += (h_-h);
					l_ += (w_-w)/2;
					$('#c').animate({left:l_,top:t_},speed_,function(){
						$('#c').remove();
						
						var red = star.parent().find('.red');
						var cl_ = red.length;
						cl_ = (cl_>8 && 'cur2 jxssclist3')||(cl_>4 && 'cur2 jxssclist2')||(cl_>0 && 'cur2')||'cur';
						end.attr('class',cl_);
						var html = '';
						red.each(function(){
							html+='<em>'+$(this).html()+'</em>';
						});
						end.find('span').html(html);
					});
			  },
			  remove_: function(star,end){
				  var red = star.parent().find('.red');
				  var cl_ = red.length;
				  cl_ = (cl_>8 && 'cur2 jxssclist3')||(cl_>4 && 'cur2 jxssclist2')||(cl_>0 && 'cur2')||'cur';
				  end.attr('class',cl_);
				  if(!red.length){
					  end.find('span').html(end.attr('v'));
				  }else{
					  var html = '';
					  red.each(function(){
						  html+='<em>'+$(this).html()+'</em>';
					  });
					  end.find('span').html(html);
				  }
			  },
			  init : function (){//设置每个玩法宽度
				  var w = $(window).width()+'px';
				  a.zx.css('width',w);
				  a.zs.css('width',w);
				  a.hz.css('width',w);
				  a.zsbh.css('width',w);
				  a.zlbh.css('width',w);
				  a.content.parent().css('width',w);
				  
				  var cur = a.nav.find('.cur');//当前玩法位置
				  var t = cur.offset().left;
				  var t1 = cur.width();
				  a.nav_c.animate({left:t+'px',width:t1+'px'},200,function(){cur.addClass('cur').siblings().removeClass('cur');});
				  var v = cur.attr('v');
				  var t3 = {'zx':'0','zs':'1','hz':'2','zsbh':'3','zlbh':'4'}[v]||'0';
				  a.content.animate({left:'-'+$(window).width()*t3+'px'},200);
			  },
			  info : function(){//填充开奖号码列表
				  $.ajax({
						url : '/trade/info.go?gid=03',
						type : "POST",
						dataType : "xml",
						success : function(xml) {
							D.load(close);
							var severtime=new Date(arguments[2].getResponseHeader("Date"));//服务器时间
							severtime = zeroStr(severtime.getHours(),2)+''+severtime.getMinutes();
							parseInt(severtime) >= 2030 && $('#c_date').html('明晚');
							var R = $(xml).find("rows");//当前期
							var p = R.attr('pid');//当前期次
							var a = R.attr('atime');//当前期开奖时间
							$('#c_expect').html(p.substr(-3)).parent().show();
							$('#expect').val(p);
							
							var r = R.find('rowp');
							
							var html = '';
							r.each(function(aa) {
								var tn = $(this).attr('tn');//10 成功且中奖 9成功未中奖 6成功未开奖 8失败且中奖 7 失败未中奖 5失败未开奖 0 用户未投注
								var p = $(this).attr('pid');//期号
								var c = $(this).attr('acode');//开奖号码
								c = c.replace(/,/g,'  ');
								p = p.substr(-3);
								
								if(aa == 0){
									$('#kj_').html(c);
								}else{
									html +='<ul><li class="wb20">'+p+'期</li>';
									html +='<li class="wb16 red">'+c+'</li>';
									var t = '';
									if(c){
										var c = c.split('  ');
										if(c[0] == c[1] && c[0] == c[2] && c[1] == c[2]){
											t = '豹子';
										}else if(c[0] == c[1] || c[0] == c[2] || c[1] == c[2]){
											t = '组三';
										}else{
											t = '组六';
										}
									}
									html +='<li class="wb21">'+t+'</li></ul>';
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
CP.Sd.init();