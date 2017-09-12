/*
 * Author: weige
 * Date: 2014-08-19
 */

/**
 * @namespace 3d过度页类
 * @name Sd_Over
 * @author wangwei
 * @memberOf CP
 */
CP.Sd_Over = function () {
		var a = {
				qs : $('#qs_'),
				bs : $('#bs_'),
				list : $('#code_list'),
				random : $('#random_'),
				pay : $('#isOk_')
		};
		var b = {
				max_qs : 30,
				max_bs : 99
		};
		var c = {
			local : function(){
				var sdSelectNum = localStorage.getItem('sd_SelectNum');//永久
				sdSelectNum && a.list.html(sdSelectNum);
				c.count_();
				
				a.list.find('p cite.errorBg').bind('click',function(){//delete line
					$(this).parent().animate({left:'-1600px'},300,function(){
						$(this).remove();
						c.count_();//更新注数
						c.local_();//更新localStorage
					});
				});
			},bindEvent : function () {
				a.qs.val('1');
				a.bs.val('1');
				$('#fqhm').removeAttr('disabled');
				c.local();

				a.qs.keyup(function(){//最大期数30
					this.value=this.value.replace(/\D/g,'');
					var qs = parseInt($(this).val());
					if($(this).val() == ''){
						qs = 1;
					}else if($(this).val() == 0){
						$(this).val('');
						qs = 1;
					}
					var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
					var bs = parseInt(a.bs.val());
					c.count_finally(zs,qs,bs);
					if(zs>0 && qs>1){
						$('.zjStop').fadeIn();
						$(".fqhm").attr("disabled",true).addClass("fqhmGray").removeClass("fqhm");
					}else{
						$('.zjStop').fadeOut();
						$("#fqhm").attr("disabled",false).removeClass("fqhmGray").addClass("fqhm");
					}
					if(qs>b.max_qs){
						D.alert('最大可买期数'+b.max_qs,function(){
							qs = b.max_qs;
							a.qs.val(qs);
							c.count_finally(zs,qs,bs);
						});
					}
				});
				a.qs.blur(function(){
					var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
					(zs<=0 || parseInt($(this).val())<=1 || $(this).val() == '') && $('.zjStop').fadeOut();
					if($(this).val() == ''){
						var qs = 1;
						$(this).val(qs);
						var bs = parseInt(a.bs.val());
						c.count_finally(zs,qs,bs);
					}
				});
				
				a.bs.keyup(function(){//最大倍数99
					this.value=this.value.replace(/\D/g,'');
					var bs = parseInt($(this).val());
					if($(this).val() == ''){
						bs = 1;
					}else if($(this).val() == 0){
						$(this).val('');
						bs = 1;
					}
					var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
					var qs = parseInt(a.qs.val());
					c.count_finally(zs,qs,bs);
					if(bs>b.max_bs){
						D.alert('最大可投倍数'+b.max_bs,function(){
							bs = b.max_bs;
							a.bs.val(bs);
							c.count_finally(zs,qs,bs);
						});
					}
				});
				a.bs.blur(function(){//最大倍数99
					if($(this).val() == ''){
						var bs = 1;
						$(this).val(bs);
						var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
						var qs = parseInt(a.qs.val());
						c.count_finally(zs,qs,bs);
					}
				});
				$('#zj_stop').Touch(function(){//中奖后停止
					$(this).toggleClass('nocheck');
				});
				a.random.bind('click',function(){
					var t = '';
					if(a.list.html()){
						t = a.list.find('p').length;
						t = a.list.find('p').eq(t-1).attr('w');
					}
					c.jixuan_(t);
				});
				$('#fqhm').click(function(){//发起合买
						var q,b,z,j,bk,zflag,playId;
						q = parseInt(a.qs.val());
						b = parseInt(a.bs.val());
						z = parseInt($('#zs_list cite:eq(0)').html());
						j = parseInt($('#zs_list cite:eq(1)').html());
						playId = $('#lotid').val();
						
						if(q == '' || q == '0' || q == null){
							D.alert('亲，请正确填写期数');
							return;
						}else if(b == '' || b == '0' || b == null){
							D.alert('亲，请正确填写倍数数');
							return;
						}else if(z <=0){
							D.alert('亲，你还没选号码');
							return;
						}else{
							c.poll_();
							/*
							 * notes:  注数
							 * multiple:     倍数
							 * pid:     当前期号
							 * countMoney: 总金额
							 * pattern:     0自购  1合买 2追号
							 * gid  :  彩种id
							 */
							
							location.href = '#class=url&xo=trade/fqhm.html&notes='+z+'&multiple='+b+'&countMoney='+j+'&gid='+playId;
						}
				});
				a.pay.click(function(){
						var q,b,z,j,bk,zflag,playId;
						q = parseInt(a.qs.val());
						b = parseInt(a.bs.val());
						z = parseInt($('#zs_list cite:eq(0)').html());
						j = parseInt($('#zs_list cite:eq(1)').html());
						playId = $('#lotid').val();
						
						if(q == '' || q == '0' || q == null){
							D.alert('亲，请正确填写期数');
							return;
						}else if(b == '' || b == '0' || b == null){
							D.alert('亲，请正确填写倍数数');
							return;
						}else if(z <=0){
							D.alert('亲，你还没选号码');
							return;
						}else{
							c.poll_();
							/*
							 * notes:  注数
							 * issue: 期数
							 * multiple:     倍数
							 * pid:     当前期号
							 * countMoney: 总金额
							 * pattern:     0自购   1合买 2追号
							 * gid  :  彩种id
							 * zflag:  0中奖不停止   1中奖停止 
							 */
							bk = 0;
							if(q>1){
								bk = 2;
								zflag = 1;
								if($('#zj_stop').hasClass('nocheck')){
									zflag = 0;
								}
								window.location.href = '#class=url&xo=trade/defrayal.html&notes='+z+'&multiple='+b+'&issue='+q+'&countMoney='+j+'&pattern='+bk+'&zflag='+zflag+'&gid='+playId;
							}else{
								window.location.href = '#class=url&xo=trade/defrayal.html&notes='+z+'&multiple='+b+'&issue='+q+'&countMoney='+j+'&pattern='+bk+'&gid='+playId;
							}
						}
					});
			},poll_ : function () {
				var l = '';
				a.list.find('p').each(function(){
					l += $(this).find('span.revise_ww span').html()+'_'+$(this).attr('w')+'_'+$(this).attr('v')+';';
				});
				l = l.substring(0,l.length-1);
				localStorage.setItem('sd_PollNum',l);
			},count_ : function () {
				var zs = 0;
				if(a.list.find('p').length){
					a.list.find('p').each(function(){
						zs += parseInt($(this).attr('v'));
					});
				}
				var bs = parseInt(a.bs.val());
				var qs = parseInt(a.qs.val());
				c.count_finally(zs,qs,bs);
			},count_finally :function(z,q,b){//注数 期数 倍数
				var j = z*q*b*2;//总金额
				$('#zs_list').find('cite:eq(0)').html(z);
				$('#zs_list').find('cite:eq(1)').html(j);
			},local_ :function(){
				var l = '';
				l = a.list.html();
				localStorage.setItem('sd_SelectNum',l);
			},jixuan_ : function (t) {
				var h_ = '';
				if(!t){
					var op_ = ['直选','组三','和值','组三包号','组六包号'];
					t = op_[Random(5)[3]-1];
				}
				var kd_ = '-'+$(window).width()+'px';
				if(t == '直选'){//zx
					var zx1 = Random(10);
					var zx2 = Random(10);
					var zx3 = Random(10);
					h_ = (zx1[2]-1)+','+(zx2[5]-1)+','+(zx3[9]-1);
					h_ = '<p v=\'1\' w='+t+' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>'+t+'&nbsp;共1注2元</b></span></p>';
				}else if(t == '组三'){//zs
					var zs = Random(10);
					h_ = (zs[3]-1)+','+(zs[3]-1)+','+(zs[6]-1);
					h_ = '<p v=\'1\' w='+t+' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>'+t+'&nbsp;共1注2元</b></span></p>';
				}else if(t == '和值'){//hz
					var hz = Random(28),zs;
					h_ = (hz[12]-1);
					zs = {'0': 1,'1': 3,'2': 6,'3': 10,'4': 15,'5': 21,'6': 28,'7': 36,'8': 45,'9': 55,'10': 63,'11': 69,'12': 73,'13': 75,'14': 75,
							'15': 73,'16': 69,'17': 63,'18': 55,'19': 45,'20': 36,'21': 28,'22': 21,'23': 15,'24': 10,'25': 6,'26': 3,'27': 1}[h_];
					h_ = '<p v='+zs+' w='+t+' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>'+t+'&nbsp;共'+zs+'注'+2*zs+'元</b></span></p>';
				}else if(t == '组三包号'){//zsbh
					var zsbh = Random(10);
					h_ = (zsbh[3]-1)+','+(zsbh[9]-1);
					h_ = '<p v=\'2\' w='+t+' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>'+t+'&nbsp;共2注4元</b></span></p>';
				}else if(t == '组六包号'){//zlbh
					var zlbh = Random(10);
					h_ = (zlbh[2]-1)+','+(zlbh[5]-1)+','+(zlbh[9]-1);
					h_ = '<p v=\'1\' w='+t+' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>'+t+'&nbsp;共1注2元</b></span></p>';
				}
				a.list.append(h_);
				a.list.find('p').eq($('#code_list p').length-1).animate({left: 0}, 300 ,function(){
					c.local_();
				});
				c.count_();//更新注数
				a.list.find('p cite.errorBg').bind('click',function(){//delete line
					$(this).parent().animate({left:'-1600px'},300,function(){
						$(this).remove();
						c.count_();//更新注数
						c.local_();//更新localStorage
					});
				});
			}
		};
		var d = function () {
				c.bindEvent();
		};
		var j = function () {c.local();};
		return {init : d,local : j};
}();
CP.Sd_Over.init();