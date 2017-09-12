/*
 * Author: weige
 * Date:  2014-08-20
 */
var c_ = '<div id="c" style="position: absolute; z-index: 99999; top: 454px;  background: none repeat scroll 0% 0% rgb(240, 61, 61); opacity: 0.15; width:2rem; line-height:2rem; border-radius:2rem; -webkit-border-radius:2rem; -moz-border-radius:2rem"></div>';
var speed_ = '200';
var f_Wobble = '0';
var curTime_ = new Date().getTime();
/**
 * @namespace 排列五投注页类
 * @name Plw
 * @author wangwei
 * @memberOf CP
 */
CP.Plw = function () {
	var a = {
			sdkj : $('.p5kj'),
			kj_code : $('#kj_code'),
			plw : $('#plw'),
			zs_ : $('#zs_'),
			Wobble : $('.shakeOmit'),
			pay_ : $('#pay_'),
			gid : $('#lotid')
	};
	var c = {
			  bindEvent: function () {
				  D.load();
				  c.info();
				  
				  
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
				  a.plw.find('div.jxsscxhBall').eq(0).find('b').click(function(){//直选  - 万位
					  var o = $(this),
					  e_ = $('#plw li:eq(0)');
					  if($(this).hasClass('red')){
						  $(this).removeClass('red');
						  c.remove_(o, e_);
					  }else{
						  $(this).addClass('red');
						  c.move_(o, e_);
					  }
					  c.count();
				  });
				  a.plw.find('div.jxsscxhBall').eq(1).find('b').click(function(){//直选  - 千位
					  var o = $(this),
					  e_ = $('#plw li:eq(1)');
					  if($(this).hasClass('red')){
						  $(this).removeClass('red');
						  c.remove_(o, e_);
					  }else{
						  $(this).addClass('red');
						  c.move_(o, e_);
					  }
					  c.count();
				  });
				  a.plw.find('div.jxsscxhBall').eq(2).find('b').click(function(){//直选  - 百位
					  var o = $(this),
					  e_ = $('#plw li:eq(2)');
					  if($(this).hasClass('red')){
						  $(this).removeClass('red');
						  c.remove_(o, e_);
					  }else{
						  $(this).addClass('red');
						  c.move_(o, e_);
					  }
					  c.count();
				  });
				  a.plw.find('div.jxsscxhBall').eq(3).find('b').click(function(){//直选  - 十位
					  var o = $(this),
					  e_ = $('#plw li:eq(3)');
					  if($(this).hasClass('red')){
						  $(this).removeClass('red');
						  c.remove_(o, e_);
					  }else{
						  $(this).addClass('red');
						  c.move_(o, e_);
					  }
					  c.count();
				  });
				  a.plw.find('div.jxsscxhBall').eq(4).find('b').click(function(){//直选  - 个位
					  var o = $(this),
					  e_ = $('#plw li:eq(4)');
					  if($(this).hasClass('red')){
						  $(this).removeClass('red');
						  c.remove_(o, e_);
					  }else{
						  $(this).addClass('red');
						  c.move_(o, e_);
					  }
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
						var zs = parseInt($('#zs_ cite:eq(0)').html());
						if(zs == 0){
							c.Wobble();
						}else{
							var code = '';
							code = c.code(zs);
							var plwSelectNum = localStorage.getItem('plw_SelectNum');
							(plwSelectNum && (plwSelectNum += code)) || (plwSelectNum = code);
							localStorage.setItem('plw_SelectNum',plwSelectNum);
							location.href = '#class=url&xo=p5/ture.html';
						}
				  });
			  },
			  code : function (zs) {
				  var code = '',wf,c1='',c2='',c3='',c4='',c5='';
				  wf = '直选';
				  a.plw.find('div:eq(0)').find('.red').each(function(){
					  	c1 +=  $(this).html()+'';
				  });
				  a.plw.find('div:eq(1)').find('.red').each(function(){
						c2 +=  $(this).html()+'';
				  });
				  a.plw.find('div:eq(2)').find('.red').each(function(){
						c3 +=  $(this).html()+'';
				  });
				  a.plw.find('div:eq(3)').find('.red').each(function(){
						c4 +=  $(this).html()+'';
				  });
				  a.plw.find('div:eq(4)').find('.red').each(function(){
						c5 +=  $(this).html()+'';
				  });
				  code = c1+' '+c2+' '+c3+' '+c4+' '+c5;
				  code = '<p v='+zs+' w='+wf+'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+code+'</span><b>'+wf+' &nbsp;共'+zs+'注'+2*zs+'元</b></span></p>'
				  return code;
			  },
			  Wobble : function () {
				  var curTime_2 = new Date().getTime(),
				  m1,m2,m3,m4,m5;
				  sp = '2500';
				  if(curTime_2-curTime_ > sp || f_Wobble == '0'){
					  f_Wobble++;
					  try{
						  navigator.vibrate(300);
					  }catch(e){};
					  c.clean_();
					  
					  m1 = c.Random(10)[5]-1;
					  m2 = c.Random(10)[7]-1;
					  m3 = c.Random(10)[2]-1;
					  m4 = c.Random(10)[1]-1;
					  m5 = c.Random(10)[9]-1;
					  a.plw.find('div:eq(0)').find('b').eq(m1).click();
					  setTimeout(function(){
						  a.plw.find('div:eq(1)').find('b').eq(m2).click();
					  },500);
					  setTimeout(function(){
						  a.plw.find('div:eq(2)').find('b').eq(m3).click();
					  },1000);
					  setTimeout(function(){
						  a.plw.find('div:eq(3)').find('b').eq(m4).click();
					  },1500);
					  setTimeout(function(){
						  a.plw.find('div:eq(4)').find('b').eq(m5).click();
					  },2000);
					  
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
					a.plw.find('b').removeClass('red');
					a.plw.find('li[m=y]').each(function(){
						$(this).find('span').html($(this).attr('v'));
						$(this).attr('class','cur');
					});
					$('#zs_ cite').html('0');
					$('#deleted').html('机选');
			  },
			  count : function(){
				  var zs = 0,c1,c2,c3,c4,c5;
				  c1 = a.plw.find('div.jxsscxhBall').eq(0).find('.red').length;
				  c2 = a.plw.find('div.jxsscxhBall').eq(1).find('.red').length;
				  c3 = a.plw.find('div.jxsscxhBall').eq(2).find('.red').length;
				  c4 = a.plw.find('div.jxsscxhBall').eq(3).find('.red').length;
				  c5 = a.plw.find('div.jxsscxhBall').eq(4).find('.red').length;
				  zs = c1*c2*c3*c4*c5;
				  if(!!a.plw.find('.red').length){
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
									html +='<li class="wb25 red">'+c+'</li></ul>';
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
			  }
			
	};
	var d = function () {
        c.bindEvent();
    };
    var e = function () {c.Wobble();};
    var clean = function () {c.clean_();};
    return {init: d,wobble: e,clean: clean};
}();
CP.Plw.init();