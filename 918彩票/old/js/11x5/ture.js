/*
 * Author: weige
 * Date: 2014-09-04
 */

/**
 * @namespace 11x5过度页类
 * @name Sx5_Over
 * @author wangwei
 * @memberOf CP
 */
CP.Sx5_Over = function () {
		var a = {
				qs : $('#qs_'),
				bs : $('#bs_'),
				list : $('#code_list'),
				random : $('#random_'),
				pay : $('#isOk_')
		};
		var b = {
				max_qs : 155,
				max_bs : 2000
		};
		var c = {
			local : function(){
				var sx5SelectNum = localStorage.getItem('11x5_SelectNum');//永久
				sx5SelectNum && a.list.html(sx5SelectNum);
				c.count_();
				
				a.list.find('div cite.errorBg').bind('click',function(){//delete line
					$(this).parent().animate({left:'-1600px'},300,function(){
						$(this).remove();
						c.count_();//更新注数
						c.local_();//更新localStorage
					});
				});
			},bindEvent : function () {
				a.qs.val('1');
				a.bs.val('1');
				c.local();

				a.qs.keyup(function(){//最大期数
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
					}else{
						$('.zjStop').fadeOut();
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
				a.qs.next().on('click',function(){//+
					if(parseInt(a.qs.val()) >=b.max_qs){D.alert('最大可买期数'+b.max_qs);}else{
						var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
						var bs = parseInt(a.bs.val());
						var qs = (parseInt(a.qs.val())+1);
						a.qs.val(qs);
						c.count_finally(zs,qs,bs);
						if(zs>0 && qs>1){
							$('.zjStop').fadeIn();
						}else{
							$('.zjStop').fadeOut();
						}
					}
				});
				a.qs.prev().on('click',function(){//-
					if(parseInt(a.qs.val()) >1){
						var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
						var bs = parseInt(a.bs.val());
						var qs = (parseInt(a.qs.val())-1);
						a.qs.val(qs);
						c.count_finally(zs,qs,bs);
						if(zs>0 && qs>1){
							$('.zjStop').fadeIn();
						}else{
							$('.zjStop').fadeOut();
						}
					}
				});
				a.bs.next().on('click',function(){
					if(parseInt(a.bs.val()) >=b.max_bs){D.alert('最大可投倍数'+b.max_bs);}else{
						var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
						var qs = parseInt(a.qs.val());
						var bs = (parseInt(a.bs.val())+1);
						a.bs.val(bs);
						c.count_finally(zs,qs,bs);
					}
				});
				a.bs.prev().on('click',function(){
					if(parseInt(a.bs.val()) >1){
						var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
						var qs = parseInt(a.qs.val());
						var bs = (parseInt(a.bs.val())-1);
						a.bs.val(bs);
						c.count_finally(zs,qs,bs);
					}
				});
				a.bs.keyup(function(){//最大倍数
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
				a.bs.blur(function(){//最大倍数
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
						t = a.list.find('div').length;
						t = a.list.find('div').eq(t-1).attr('w');
					}
					c.jixuan_(t);
				});
				$('#clearAll').Touch(function(){
					a.list.html('');c.count_();c.local_();
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
				a.list.find('div').each(function(){
					l += $(this).find('span.revise_ww span').html()+'_'+$(this).attr('w')+'_'+$(this).attr('v')+';';
				});
				l = l.substring(0,l.length-1);
				localStorage.setItem('11x5_PollNum',l);
			},count_ : function () {
				var zs = 0;
				if(a.list.find('div').length){
					a.list.find('div').each(function(){
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
				localStorage.setItem('11x5_SelectNum',l);
			},jixuan_ : function (t) {
				var h_ = '';
				if(!t){
					var op_ = ['前一直选','任选二','前二直选','前二组选','任选三','前三直选','前三组选','任选四','任选五','任选六','任选七','任选八'];
					t = op_[Random(11)[3]-1];
				}
				var t1 = {'前一直选':'1','任选三':'3','前三直选':'3','前三组选':'3','任选四':'4','任选五':'5','任选六':'6','任选七':'7','任选八':'8'}[t]||'2';
				var kd_ = '-'+$(window).width()+'px';
				if(t == '前二直选'){
					var zx2 = Random(11);
					h_ = (zeroStr(zx2[4],2))+'|'+(zeroStr(zx2[9],2));
				}else if(t == '前三直选'){
					var zx3 = Random(11);
					h_ = (zeroStr(zx3[4],2))+'|'+(zeroStr(zx3[9],2))+'|'+(zeroStr(zx3[1],2));
				}else{
					var rx = Random(11);
					for(var n=0; n<t1; n++){h_ += zeroStr(rx[n],2)+' ';}
					h_ = h_.substr(0,h_.length-1);
				}
				h_ = '<div class="ssqtzNum" v=\'1\' w='+t+' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><p>'+t+'&nbsp;&nbsp;&nbsp;1注2元</p></span></div>';
				a.list.append(h_);
				a.list.find('div').eq($('#code_list div').length-1).animate({left: 0}, 300 ,function(){
					c.local_();
				});
				c.count_();//更新注数
				a.list.find('div cite.errorBg').bind('click',function(){//delete line
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
CP.Sx5_Over.init();