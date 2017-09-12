/*
 * Author: weige
 * Date: 2014-7-22
 */
var kd_ = '-'+$(window).width()+'px';

var Jclq_hh_t = {
		initial: function(){
			var html = localStorage.getItem('jclq_hh_SelectNum');
			!!html && jQuery('#content').html(html);
			jQuery('#selectPlay').val('2串1');
			jQuery('#selectPlay').attr('v','2');
			jQuery('#chuan_ div.ww_ span').eq(0).addClass('cur');
			Jclq_hh_t.c();//初始化注数
			Jclq_hh_t.bind();//初始化的一些绑定事件
		},
		gg_: function(){//一些事件触发改变过关方式
			var l = $('#content li[v=y]').length;
			if(l<2){
				jQuery('#selectPlay').attr('v','2');
				D.tx('亲，至少选择2场');
			}else{
				$('#selectPlay').val('2串1');
				$('#selectPlay').attr('v','2');
				$('#chuan_ div.ww_ span').removeClass('cur');
				$('#chuan_ div.ww_ span').eq(0).addClass('cur');
			}
		},
		bind: function(){
			jQuery('#content div.spfzpk').find('span').Touch(function(){//选择投注内容
				var bl = false;
				if($(this).parent().find('.cur').length == 0) bl = true;
				$(this).toggleClass('cur');
				
				var l_ = $(this).parent().parent().find('.cur').length;
				if(l_){
					var r = '',d = '';
					$(this).parent().parent().find('div:eq(0)').find('span.cur').each(function(){
						r += $(this).attr('v')+',';
					});
					r = r.substr(0,r.length-1);
					$(this).parent().parent().find('div:eq(1)').find('span.cur').each(function(){
						d += $(this).attr('v')+',';
					});
					d = d.substr(0,d.length-1);
					$(this).parent().parent().attr('r',r);
					$(this).parent().parent().attr('d',d);
					
					$(this).parent().parent().attr('v','y');//当前行是否有选投注号码
					(bl && l_ == 1) && Jclq_hh_t.gg_();
				}else{
					$(this).parent().parent().removeAttr('v');//ul
					$(this).parent().parent().removeAttr('r');// 让分
					$(this).parent().parent().removeAttr('d');// 大小分
					
					Jclq_hh_t.gg_();
				}
				Jclq_hh_t.c();
				Jclq_hh_t.local_();
			});

			jQuery('#clearTab').Touch(function(){//清空
				localStorage.removeItem('jclq_hh_PollNum');
				jQuery('#content li[v=y]').removeAttr('v').removeAttr('r').removeAttr('d').find('.cur').removeClass('cur');
				
				jQuery('#selectPlay').val('2串1');
				jQuery('#selectPlay').attr('v','2');
				jQuery('#chuan_ div.ww_').find('.cur').removeClass('cur');
				jQuery('#chuan_ div.ww_ span').eq(0).addClass('cur');
				
				Jclq_hh_t.gg_();	
				Jclq_hh_t.c();
				Jclq_hh_t.local_();
			});
			jQuery('.error2').Touch(function(){//删除一条
				$(this).parent().parent().animate({left:kd_},500,function(){
					$(this).remove();
					
					Jclq_hh_t.gg_();
					Jclq_hh_t.c();
					Jclq_hh_t.local_();
				});
			});
			jQuery('#tjss').click(function(){//添加赛事
		//		window.location.href='#class=url&xo=jclq/hh/index.html';
				Jclq_hh_t.href_('#class=url&xo=jclq/hh/index.html');
			});
			jQuery('#fqhm').click(function(){//发起合买
				var c = jQuery('#content li[v=y]').length;
				var g = jQuery('#selectPlay').attr('v');
				if(c < 2){
					D.alert('亲，最少选择2场比赛');
				}else if(g == ''){
					D.alert('请选择过关方式');
				}else{
					var zs = jQuery('#count_ cite:eq(0)').html();
					var bs = jQuery('#bs_').val();
					var m = jQuery('#count_ cite:eq(1)').html();
					var lotid =jQuery('#lotid').val();
					Jclq_hh_t.href_('#class=url&xo=trade/buyconfirm.html&zs='+zs+'&bs='+bs+'&money='+m+'&bk=1&gid='+lotid);
				}
				
			});
			jQuery('#payment').click(function(){//代购
					var c = jQuery('#content li[v=y]').length;
					var g = jQuery('#selectPlay').attr('v');
					if(c < 2){
						D.alert('亲，最少选择2场比赛');
					}else if(g == ''){
						D.alert('请选择过关方式');
					}else{
						var zs = $('#count_ cite:eq(0)').html();
						var z = $('#count_ cite:eq(1)').html();
						var bs = $('#bs_').val();
						var gid = $('#lotid').val();
						Jclq_hh_t.href_('#class=url&xo=trade/paybd.html&notes='+zs+'&bs='+bs+'&countMoney='+z+'&bk=0&gid='+gid);
					}
					
			});
			jQuery('#selectPlay').click(function(){//打开关闭过关方式层
				var a = jQuery('#content li[v=y]').length;
				var b = jQuery('#chuan_ div.ww_ span').length;
				if(a<2){
					jQuery('#chuan_ div.ww_ span').hide();
					jQuery('#chuan_ div.ww_ span').eq(0).show();
				}else{
					for(var n = 0; n<b; n++){
						if(n<(a-1)){
							jQuery('#chuan_ div.ww_ span').eq(n).show();
						}else{
							jQuery('#chuan_ div.ww_ span').eq(n).hide();
							jQuery('#chuan_ div.ww_ span').eq(n).removeClass('cur');
						}
					}
				}
				
				jQuery('#chuan_').show();
				jQuery('#chuan_').css({marginTop:'-'+($('#chuan_').height()/2)+'px'});
				jQuery('#Mask_chuan').show();
			});
			jQuery('#chuan_ div.ww_ span').Touch(function(){//选择过关方式
				if($('#chuan_ div.ww_ span.cur').length==1 && $(this).hasClass('cur'))return;
				
				$(this).toggleClass('cur');
				var v = '',v1 = '';
				$(this).parent().find('.cur').each(function(){
					v += $(this).attr('v')+',';
					v1 += $(this).html()+',';
				});
				v = v.substr(0,v.length-1);
				v1 = v1.substr(0,v1.length-1);
				jQuery('#selectPlay').attr('v',v);
				jQuery('#selectPlay').val(v1);
				
				Jclq_hh_t.c();
			});
			jQuery('#chuan_ a').click(function(){
				var v = '',v1 = '';
				$(this).parent().find('.cur').each(function(){
					v += $(this).attr('v')+',';
					v1 += $(this).html()+',';
				});
				v = v.substr(0,v.length-1);
				v1 = v1.substr(0,v1.length-1);
				jQuery('#selectPlay').attr('v',v);
				jQuery('#selectPlay').val(v1);
				
				
				jQuery('#chuan_').hide();
				jQuery('#Mask_chuan').hide();
				
				Jclq_hh_t.c();
			});
			jQuery('#Mask_chuan').click(function(){
				jQuery('#chuan_').hide();
				jQuery('#Mask_chuan').hide();
			});
			$('#bs_').keyup(function(){//最大倍数50000
				this.value=this.value.replace(/\D/g,'');
				if($(this).val() == 0 || $(this).val() == ''){
					$(this).val('');
				}else{
					if($(this).val()>50000){
						D.alert('最大可投倍数50000',function(){
							$('#bs_').val('50000');
							Jclq_hh_t.c();
						});
					}else{
						Jclq_hh_t.c();
					}
				}
			});
			$('#bs_').blur(function(){
				if($(this).val() == ''){
					var bs = 1;
					$(this).val(bs);
					Jclq_hh_t.c();
				}
			});
		},
		href_: function(u){
			var c = '',d= '',g= jQuery('#selectPlay').attr('v'),
			rf,
			dx;
			
			jQuery('#content li[v=y]').each(function(){
				rf = $(this).attr('r').replace(/,/g,'/');
				dx = $(this).attr('d').replace(/,/g,'/');
				c += $(this).attr('t')+'>'+(rf!=''?'RFSF='+rf+(dx!=''?'+':''):'')+(dx!=''?'DXF='+dx:'')+',';
			});
			c = c.substr(0,c.length-1);
			if(g != '' && c != ''){
				g = g.split(',');
				for(var n=0; n<g.length; n++){
					d += g[n]+'*1,';
				}
				d = d.substr(0,d.length-1);
				c += '|'+d;
			}
			localStorage.setItem('jclq_hh_PollNum',c);
			location.href=u;
		},
		local_: function(){//jclq_hh_SelectNum重新赋值
			var c = jQuery('#content').html();
			localStorage.setItem('jclq_hh_SelectNum',c);
		},
		c: function(){
			var n = jQuery('#selectPlay').attr('v');//过关方式
			var m = '';
			con = jQuery('#content li[v=y]');
			con.each(function(){
				var i= $(this).attr('r').split(',').length;
				var j = $(this).attr('d').split(',').length;
				i = ($(this).attr('r') != '' && i) || 0;
				j = ($(this).attr('d') != '' && j) || 0;
				m += (i+j)+',';
			});
			m = m.substr(0,m.length-1);
			if(n == '' || m == ''){
				jQuery('#count_').html('共<cite class="yellow">0</cite>注<cite class="yellow">0</cite>元');
				$('.spfjj').hidden();
			}else{
				var zs_ = Count.c(n,m);
				var bs_ = parseInt(jQuery('#bs_').val());
				jQuery('#count_').html('共<cite class="yellow">'+zs_+'</cite>注<cite class="yellow">'+2*zs_*bs_+'</cite>元');
				
				var data = [].slice.call(con).map(function(o) {
					var sp,sp1,sum,division = {};
					sp = [].slice.call($(o).find('div:eq(0)').find('.cur')).map(function(t){//让分
						var xo = $(t).find('cite').html();
						xo = !!parseInt(xo) && xo || '1';
						return xo;
					});
					sp1 = [].slice.call($(o).find('div:eq(1)').find('.cur')).map(function(t){//猜总分
						var xo = $(t).find('cite').html();
						xo = !!parseInt(xo) && xo || '1';
						return xo;
					});
					sp = (sp.length)?Count.division(sp,'true'):0;
					sp1 = (sp1.length)?Count.division(sp1,'true'):0;
					sum = parseFloat(sp)+parseFloat(sp1);
					division['max'] = sum;
					division['min'] = sum;
			        return division;
			    });
				
				var prix = Count.prix(data,n);
				$('.spfjj').show();
				var min = (prix.min*1*bs_).toFixed(2);
				var max = (prix.max*1*bs_).toFixed(2);
				prix = (min == max)?max:(min+'~'+max);
				$('.spfjj em').html(prix);
			}
		}
};
Jclq_hh_t.initial();//初始化
