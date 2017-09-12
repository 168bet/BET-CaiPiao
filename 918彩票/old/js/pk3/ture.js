/*
 * Author: weige
 * Date: 2014-08-27
 */

/**
 * @namespace 3d过度页类
 * @name Pk3_Over
 * @author wangwei
 * @memberOf CP
 */
CP.Pk3_Over = function () {
		var a = {
				qs : $('#qs_'),
				bs : $('#bs_'),
				list : $('#code_list'),
				random : $('#random_'),
				pay : $('#isOk_')
		};
		var b = {
				max_qs : 158,
				max_bs : 999
		};
		var c = {
			bindEvent : function () {
				a.qs.val('1');
				a.bs.val('1');
				$('#fqhm').removeAttr('disabled');
				
				var pk3SelectNum = localStorage.getItem('pk3_SelectNum');//永久
				pk3SelectNum && a.list.html(pk3SelectNum);
				c.count_();

				a.qs.keyup(function(){//最大期数30
					this.value=this.value.replace(/\D/g,'');
					var qs = parseInt($(this).val());
					if($(this).val() == ''){
						qs = 1;
					}else if($(this).val() == 0){
						$(this).val('');
						qs = 1;
					}
					var zs = parseInt($('#zs_').find('cite:eq(0)').html());
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
					var zs = parseInt($('#zs_').find('cite:eq(0)').html());
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
					var zs = parseInt($('#zs_').find('cite:eq(0)').html());
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
						var zs = parseInt($('#zs_').find('cite:eq(0)').html());
						var qs = parseInt(a.qs.val());
						c.count_finally(zs,qs,bs);
					}
				});
				$('#zj_stop').Touch(function(){//中奖后停止
					$(this).toggleClass('nocheck');
				});
				a.list.find('p cite.errorBg').bind('click',function(){//delete line
					$(this).parent().animate({left:'-1600px'},300,function(){
						$(this).remove();
						c.count_();//更新注数
						c.local_();//更新localStorage
					});
				});
				a.random.bind('click',function(){
					var t = '';
					if(a.list.html()){
						t = a.list.find('p').length;
						t = a.list.find('p').eq(t-1).attr('w');
					}
					c.jixuan_(t);
				});
				a.pay.click(function(){
						var q,b,z,j,bk,zflag,playId;
						q = parseInt(a.qs.val());
						b = parseInt(a.bs.val());
						z = parseInt($('#zs_ cite:eq(0)').html());
						j = parseInt($('#zs_ cite:eq(1)').html());
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
			},
			poll_ : function () {
				var l = '';
				a.list.find('p').each(function(){
					l += $(this).find('span.revise_ww span').html()+'_'+$(this).attr('w')+'_'+$(this).attr('v')+';';
				});
				l = l.substring(0,l.length-1);
				localStorage.setItem('pk3_PollNum',l);
			},
			count_ : function () {
				var zs = 0;
				if(a.list.find('p').length){
					a.list.find('p').each(function(){
						zs += parseInt($(this).attr('v'));
					});
				}
				var bs = parseInt(a.bs.val());
				var qs = parseInt(a.qs.val());
				c.count_finally(zs,qs,bs);
			},
			count_finally :function(z,q,b){//注数 期数 倍数
				var j = z*q*b*2;//总金额
				$('#zs_').find('cite:eq(0)').html(z);
				$('#zs_').find('cite:eq(1)').html(j);
			},
			local_ :function(){
				var l = '';
				l = a.list.html();
				localStorage.setItem('pk3_SelectNum',l);
			},
			jixuan_ : function (t) {
				var h_ = '',x1,x2,x3,x4,x5,x6,x7,x8;
				if(!t){
					var op_ = ['选一','选二','选三','选四','选五','选六','对子','豹子','顺子','同花','同花顺'];
					t = op_[Random(11)[3]-1];
				}
				var kd_ = '-'+$(window).width()+'px';
				x1 = ['A','2','3','4','5','6','7','8','9','10','J','Q','K'];
				if(t == '选一'){
					h_ = x1[Random(13)[8]-1];
				}else if(t == '选二'){
					x2 = Random(13);
					x3 = x2[2]-1;
					x4 = x2[8]-1;
					h_ = x1[x3]+' '+x1[x4];
				}else if(t == '选三'){
					x2 = Random(13);
					x3 = x2[2]-1;
					x4 = x2[8]-1;
					x5 = x2[11]-1;
					h_ = x1[x3]+' '+x1[x4]+' '+x1[x5];
				}else if(t == '选四'){
					x2 = Random(13);
					x3 = x2[2]-1;
					x4 = x2[8]-1;
					x5 = x2[11]-1;
					x6 = x2[5]-1;
					h_ = x1[x3]+' '+x1[x4]+' '+x1[x5]+' '+x1[x6];
				}else if(t == '选五'){
					x2 = Random(13);
					x3 = x2[2]-1;
					x4 = x2[8]-1;
					x5 = x2[11]-1;
					x6 = x2[5]-1;
					x7 = x2[3]-1;
					h_ = x1[x3]+' '+x1[x4]+' '+x1[x5]+' '+x1[x6]+' '+x1[x7];
				}else if(t == '选六'){
					x2 = Random(13);
					x3 = x2[2]-1;
					x4 = x2[8]-1;
					x5 = x2[11]-1;
					x6 = x2[5]-1;
					x7 = x2[3]-1;
					x8 = x2[7]-1;
					h_ = x1[x3]+' '+x1[x4]+' '+x1[x5]+' '+x1[x6]+' '+x1[x7]+' '+x1[x8];
				}else if(t == '对子'){
					x2 = x1[Random(13)[8]-1];
					h_ = x2+''+x2;
				}else if(t == '豹子'){
					x2 = x1[Random(13)[8]-1];
					h_ = x2+''+x2+''+x2;
				}else if(t == '顺子'){
					x1 = ['A23','234','345','456','567','678','789','8910','910J','10JQ','JQK','QKA'];
					x2 = x1[Random(12)[8]-1];
					h_ = x2;
				}else if(t == '同花'){
					x1 = ['黑桃','红桃','梅花','方片'];
					x2 = x1[Random(4)[2]-1];
					h_ = x2;
				}else if(t == '同花顺'){
					x1 = ['黑桃顺子','红桃顺子','梅花顺子','方片顺子'];
					x2 = x1[Random(4)[3]-1];
					h_ = x2;
				}
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
		return {init : d};
}();
CP.Pk3_Over.init();
