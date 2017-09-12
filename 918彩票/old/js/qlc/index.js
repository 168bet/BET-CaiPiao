/*
 * Author: weige
 * Date:  2014-08-25
 */
var nn = '0';
var f_Wobble = '0';
var curTime_ = new Date().getTime();
/**
 * @namespace 七乐彩投注页类
 * @name Qlc
 * @author wangwei
 * @memberOf CP
 */
CP.Qlc = function () {
	var a = {
			sdkj : $('.p5kj'),
			kj_code : $('#kj_code'),
			qlc : $('#qlc'),
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
				  a.qlc.find('b').Touch(function(){
					  $(this).toggleClass('red').removeClass('wei_');
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
							var qlcSelectNum = localStorage.getItem('qlc_SelectNum');
							(qlcSelectNum && (qlcSelectNum += code)) || (qlcSelectNum = code);
							localStorage.setItem('qlc_SelectNum',qlcSelectNum);
							location.href = '#class=url&xo=qlc/ture.html';
						}
					});
			  },
			  code : function (zs) {
				  var code = '',wf;
				  wf = '直选';
				  a.qlc.find('.red').each(function(){
					  code +=  $(this).html()+' ';
				  });
				  code = code.substr(0,code.length-1);
				  code = '<p v='+zs+' w='+wf+'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+code+'</span><b>'+wf+' &nbsp;共'+zs+'注'+2*zs+'元</b></span></p>'
				  return code;
			  },
			  Wobble : function () {
				  	var curTime_2 = new Date().getTime();
				  	if(curTime_2-curTime_ > '1000' || f_Wobble == '0'){
				  		f_Wobble++;
				  		try{
							navigator.vibrate(300);
						}catch(e){};
						nn = 0;
				        var selectlength_r = '7';//双色球红球必选6个
				        var maxlength_r = '30';//双色球红球有33个
				        var redNum = c.Random(maxlength_r);//打乱顺序之后的33个红球
				        c.clean_();
				    	
				        var redNum_ = [];
				        for (var i = 0; i < selectlength_r; i++) {
				            redNum_[i] = redNum[i+i*3];
				        }
				        redNum_.sort(function(a,b){return a>b?1:-1;});
				        c.red_scale(redNum_,parseInt(selectlength_r));
				        curTime_ = new Date().getTime();
				  	}
			  },
			  red_scale : function (redNum_,selectlength_r) {
				    if(nn<selectlength_r) {
				    	setTimeout(function(){
				    		a.qlc.find('b').eq(redNum_[nn]-1).addClass('red wei_');
				    		nn++;
				    		c.red_scale(redNum_,selectlength_r);
				    	},100);
				    }else{
				    	c.count();
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
					a.qlc.find('b').removeClass('red').removeClass('wei_');
					$('#zs_ cite').html('0');
					$('#deleted').html('机选');
			  },
			  count : function(){
				  var zs = 0,c1;
				  c1 = a.qlc.find('.red').length;
				  zs = $_sys.C(c1,7);
				  if(!!c1){
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
								c = c.split('|');
								p = p.substr(-3);
								
								if(aa == 0){
									$('#kj_').html(c[0]);
									$('#kj_').next().html(c[1]);
								}else{
									html += '<ul><li class="wb20">'+p+'期</li>';
									html += '<li class="wb50"><em class="red">'+c[0]+'</em> <cite class="blue">'+c[1]+'</cite></li></ul>';
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
CP.Qlc.init();