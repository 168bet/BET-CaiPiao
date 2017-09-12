/*
 * Author: weige
 * Date: 2014-08-20
 */

/**
 * @namespace 排列五过度页类
 * @name Plw_Over
 * @author wangwei
 * @memberOf CP
 */
CP.Plw_Over = function () {
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
				var plwSelectNum = localStorage.getItem('plw_SelectNum');//永久
				plwSelectNum && a.list.html(plwSelectNum);
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
					c.jixuan_();
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
					l += $(this).find('span.revise_ww span').html().replace(/ /g,',')+'_'+$(this).attr('w')+'_'+$(this).attr('v')+';';
				});
				l = l.substring(0,l.length-1);
				localStorage.setItem('plw_PollNum',l);
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
				localStorage.setItem('plw_SelectNum',l);
			},jixuan_ : function () {
				var h_ = '',t = '直选';
				var kd_ = '-'+$(window).width()+'px';
				var zx1 = Random(10);
				var zx2 = Random(10);
				var zx3 = Random(10);
				var zx4 = Random(10);
				var zx5 = Random(10);
				h_ = (zx1[2]-1)+' '+(zx2[5]-1)+' '+(zx3[9]-1)+' '+(zx2[3]-1)+' '+(zx3[8]-1);
				h_ = '<p v=\'1\' w='+t+' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>'+t+'&nbsp;共1注2元</b></span></p>';
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
		var j = function () {c.local()};
		return {init : d,local : j};
}();
CP.Plw_Over.init();