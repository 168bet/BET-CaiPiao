/*
*Author: weige
*Date: 2014.8.20
*/

/*
 * @description : 发起合买页面  目的，把所有彩种的fqhm整合在这里面
 * @author : wangwei
 */

//?notes=3&multiple=1&countMoney=6&gid=03
var zs_ = decodeURIComponent(CP.Util.getParaHash("notes"));//注数
var bs_ = decodeURIComponent(CP.Util.getParaHash("multiple"));//倍数
var m_ = decodeURIComponent(CP.Util.getParaHash("countMoney"));//总金额
var gid_ = decodeURIComponent(CP.Util.getParaHash("gid"));//当前彩种id

/**
 * @namespace 发起合买类
 * @name Fqhm
 * @author wangwei
 * @memberOf CP
 */
CP.Fqhm = function () {
	var c = {
			initail : function (){
				if(zs_ != '' && gid_ != '' && bs_ != ''){
					c.initail2(zs_, bs_, m_, gid_);//初始化加载
				}else{
					history.go(-1);
				}
			},
			initail2 : function (zs, bs, m, gid) {
				jQuery('#detail cite:eq(0)').html(zs);
				jQuery('#detail cite:eq(1)').html(bs);
				jQuery('#detail cite:eq(2)').html(m);
				
				$("#rg").val(Math.ceil(m*0.05));
				$("#rg_bl").html(Math.floor(($('#rg').val()/m)*10000)/100+"%");
				$("#bd").attr('disabled',false);
				$("#bd").val('0');
				$("#bd_bl").html('0%');
				
				c.my_();//认购保底多少
				c.bindEvent(parseInt(m));
			},
			my_ : function () {
				var rg = $('#rg').val();
				var bd = $('#bd').val();
				var z = parseInt(rg)+parseInt(bd);			
				$('#my_ cite:eq(0)').html(rg);//认购
				$('#my_ cite:eq(1)').html(bd);//保底
				$('#my_ cite:eq(2)').html(z);//总金额
			},
			bindEvent : function (m) {//m 方案总金额
				$('#ratio li,#isPublic li').Touch(function(){//提成   是否公开 点击事件
					!$(this).hasClass('cur') && $(this).toggleClass('cur');
					$(this).siblings().removeClass('cur');
				});
				
				$('#rg').keyup(function(){//认购 
					var bd_ = parseInt($('#bd').val());
					
					if($(this).val() >= m){
						$(this).val(m);
						$("#rg_bl").html("100%");
					}else{
						if($(this).val() == ''){
							$("#rg_bl").html("0%");
						}else{
							$("#rg_bl").html(Math.floor((parseInt($('#rg').val())/m)*10000)/100+"%");
						}
					}
					
					if(!$("#chk").hasClass("nocheck") || parseInt($(this).val())+bd_>m){
						if($(this).val() == ''){
							$('#bd').val(m);
							$("#bd_bl").html('100%');
						}else{
							$('#bd').val(m-parseInt($(this).val()));
							$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/m)*10000)/100+"%");
						}
					}
					c.my_();
				});
				$('#rg').change(function(){//认购 小于5% 提示
					var t = $(this).val();
					if(t == ''){
						t=0;
					}
					if(parseInt(t) < m*0.05){
						D.tx('认购金额不能小于5%');
						
						$(this).val(Math.ceil(m*0.05));
						$("#rg_bl").html(Math.floor((parseInt($("#rg").val())/m)*10000)/100+"%");
					}
					if(!$("#chk").hasClass("nocheck")){
						$('#bd').val(m-parseInt($(this).val()));
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/m)*10000)/100+"%");
					}
					c.my_();
				});
				$('#bd').keyup(function(){//保底 
					var rg_ = parseInt($('#rg').val());
					(parseInt($(this).val()) > m-rg_) && $(this).val(m-rg_);
					if($(this).val() == ''){
						$("#bd_bl").html("0%");
					}else{
						$(this).val(parseInt($(this).val()));
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/m)*10000)/100+"%");
					}
					
					c.my_();
				});
				$('#bd').change(function(){//保底等于空
					if($(this).val() == ''){
						$(this).val('0');
						$("#bd_bl").html("0%");
						c.my_();
					}
				});
				$('#chk').Touch(function(){
					var rg_ = parseInt($('#rg').val());
					$(this).toggleClass('nocheck');
					
					if(!$("#chk").hasClass("nocheck")){//全额保底
						$("#bd").attr('disabled',true);
						
						$("#bd").val(m-rg_);
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/m)*10000)/100+"%");
					}else{
						$("#bd").attr('disabled',false);
					}
					
					c.my_();
				});
				$('#my_').next().Touch(function(){
					var p = $('#isPublic li.cur').attr('v');
					var rg = $('#rg').val();
					var bd = $('#bd').val();
					var wrate = $('#ratio li.cur').attr('v');
					var desc = $('#desc').val();
					if(!desc){
						desc = '随缘！买彩票讲的是运气、缘分和坚持。';
					}
					/*
					 * notes:  注数
					 * issue: 期数
					 * multiple:     倍数
					 * isPublic ： 是否公开
					 * countMoney: 总金额
					 * pattern:     0自购  2追号 1合买
					 * gid  :  彩种id
					 */
					location.href='#class=url&xo=trade/defrayal.html&notes='+zs_+'&multiple='+bs_+'&issue=1&isPublic='+p+'&countMoney='+m_+'&pattern=1&rg='+rg+'&bd='+bd+'&xyText='+desc+'&wrate='+wrate+'&gid='+gid_;
				});
			}
	};
	var d = function () {
		c.initail();
	};
	return {
		init : d
	};
}();
CP.Fqhm.init();
