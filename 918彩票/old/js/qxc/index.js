/*
 * Author: weige
 * Date:  2014-08-20
 */
/**
 * @namespace 七星彩投注页类
 * @name Qxc
 * @author wangwei
 * @memberOf CP
 */
CP.Qxc = function () {
	var a = {
			sdkj : $('.p5kj'),
			kj_code : $('#kj_code'),
			qxc : $('#qxc'),
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
				  a.qxc.find('b').Touch(function(){
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
						
						var zs = parseInt($('#zs_ cite:eq(0)').html());
						if(zs == 0){
							c.Wobble();
						}else{
							var code = '';
							code = c.code(zs);
							var qxcSelectNum = localStorage.getItem('qxc_SelectNum');
							(qxcSelectNum && (qxcSelectNum += code)) || (qxcSelectNum = code);
							localStorage.setItem('qxc_SelectNum',qxcSelectNum);
							location.href = '#class=url&xo=qxc/ture.html';
						}
					});
			  },
			  code : function (zs) {
				  var code = '',wf,c1='',c2='',c3='',c4='',c5='',c6='',c7='';
				  wf = '直选';
				  a.qxc.find('div:eq(0)').find('.red').each(function(){
					  	c1 +=  $(this).html()+'';
				  });
				  a.qxc.find('div:eq(1)').find('.red').each(function(){
					  	c2 +=  $(this).html()+'';
				  });
				  a.qxc.find('div:eq(2)').find('.red').each(function(){
					  	c3 +=  $(this).html()+'';
				  });
				  a.qxc.find('div:eq(3)').find('.red').each(function(){
					  	c4 +=  $(this).html()+'';
				  });
				  a.qxc.find('div:eq(4)').find('.red').each(function(){
					  	c5 +=  $(this).html()+'';
				  });
				  a.qxc.find('div:eq(5)').find('.red').each(function(){
					  	c6 +=  $(this).html()+'';
				  });
				  a.qxc.find('div:eq(6)').find('.red').each(function(){
					  	c7 +=  $(this).html()+'';
				  });
				  code = c1+' '+c2+' '+c3+' '+c4+' '+c5+' '+c6+' '+c7;
				  code = '<p v='+zs+' w='+wf+'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+code+'</span><b>'+wf+' &nbsp;共'+zs+'注'+2*zs+'元</b></span></p>'
				  return code;
			  },
			  Wobble : function () {
				  	  var m1,m2,m3,m4,m5,m6,m7;
					  try{
						  navigator.vibrate(300);
					  }catch(e){};
					  c.clean_();
					  m1 = c.Random(10)[5]-1;
					  m2 = c.Random(10)[7]-1;
					  m3 = c.Random(10)[2]-1;
					  m4 = c.Random(10)[5]-1;
					  m5 = c.Random(10)[7]-1;
					  m6 = c.Random(10)[2]-1;
					  m7 = c.Random(10)[5]-1;
					  a.qxc.find('div:eq(0)').find('b').eq(m1).addClass('red');
					  a.qxc.find('div:eq(1)').find('b').eq(m2).addClass('red');
					  a.qxc.find('div:eq(2)').find('b').eq(m3).addClass('red');
					  a.qxc.find('div:eq(3)').find('b').eq(m4).addClass('red');
					  a.qxc.find('div:eq(4)').find('b').eq(m5).addClass('red');
					  a.qxc.find('div:eq(5)').find('b').eq(m6).addClass('red');
					  a.qxc.find('div:eq(6)').find('b').eq(m7).addClass('red');
					  c.count();
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
					a.qxc.find('b').removeClass('red');
					$('#zs_ cite').html('0');
					$('#deleted').html('机选');
			  },
			  count : function(){
				  var zs = 0,c1,c2,c3,c4,c5,c6,c7;
				  c1 = a.qxc.find('div.jxsscxhBall').eq(0).find('.red').length;
				  c2 = a.qxc.find('div.jxsscxhBall').eq(1).find('.red').length;
				  c3 = a.qxc.find('div.jxsscxhBall').eq(2).find('.red').length;
				  c4 = a.qxc.find('div.jxsscxhBall').eq(3).find('.red').length;
				  c5 = a.qxc.find('div.jxsscxhBall').eq(4).find('.red').length;
				  c6 = a.qxc.find('div.jxsscxhBall').eq(5).find('.red').length;
				  c7 = a.qxc.find('div.jxsscxhBall').eq(6).find('.red').length;
				  zs = c1*c2*c3*c4*c5*c6*c7;
				  if(!!a.qxc.find('.red').length){
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
							var a = R.attr('atime');//当前期截止时间
							$('#c_expect').html(p.substr(-3)+'期 '+a.substr(5,5)+' <em class="yellow">'+a.substr(11,5)+'</em>').parent().show();
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
				  
			  }
			
	};
	var d = function () {
        c.bindEvent();
    };
    var e = function () {c.Wobble();};
    var clean = function () {c.clean_();};
    return {init: d,wobble: e,clean: clean};
}();
CP.Qxc.init();