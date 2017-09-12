/*
 * Author: weige
 * Date: 2014-10-31
 */
var kd_ = '-'+$(window).width()+'px';
var pid = '';
pid = decodeURIComponent(CP.Util.getParaHash("pid"));
var Bjdc_sx_t = {
		initial: function(){
			var html = localStorage.getItem('bd_sxp_SelectNum');
			!!html && jQuery('#content').html(html);
			
			var c = jQuery('#content li[v=y]').length;
			if(c == '0'){
				jQuery('#selectPlay').attr('v','');
			}else{
				 c = (c>6 && 6)||c;
				 if(c == '1'){
					  jQuery('#selectPlay').val('单关');
				 }else{
					  jQuery('#selectPlay').val(c+'串1');
				 }
				 jQuery('#chuan_ div.ww_ span').eq(c-1).addClass('cur');
				 jQuery('#selectPlay').attr('v',c);
				 Bjdc_sx_t.c();//初始化注数
			}
			Bjdc_sx_t.bind();//初始化的一些绑定事件
		},
		gg_: function(){//一些事件触发改变过关方式
			var l = $('#content li[v=y]').length;
			if(!l){
				D.tx('亲，至少选择一场');
			}else{
				l = (l>6 && 6)||l;
				var ll = {'1':'单关','2':'2串1','3':'3串1','4':'4串1','5':'5串1','6':'6串1'}[l];
				$('#selectPlay').val(ll);
				$('#selectPlay').attr('v',l);
				$('#chuan_ div.ww_ span').removeClass('cur');
				$('#chuan_ div.ww_ span').eq(l-1).addClass('cur');
			}
		},
		bind: function(){
			jQuery('#content div.spfzpk').find('span').Touch(function(){//选择投注内容
				var bl = false;
				if($(this).parent().find('.cur').length == 0) bl = true;
				$(this).toggleClass('cur');
				
				var l_ = $(this).parent().find('.cur').length;
				if(l_){
					var c = '';
					$(this).parent().find('span.cur').each(function(){
						c += $(this).attr('v')+',';
						
					});
					c = c.substring(0, c.length-1);
					$(this).parent().parent().attr('c',c);//投注号码
					
					$(this).parent().parent().attr('v','y');//当前行是否有选投注号码
					(bl && l_ == 1) && Bjdc_sx_t.gg_();
				}else{
					$(this).parent().parent().removeAttr('v');
					$(this).parent().parent().removeAttr('c');
					
					Bjdc_sx_t.gg_();
				}
				Bjdc_sx_t.c();
				Bjdc_sx_t.local_();
			});
			
			jQuery('#clearTab').Touch(function(){//清空
				localStorage.removeItem('bd_sxp_PollNum');
				jQuery('#content li[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur');
				
				jQuery('#selectPlay').val('单关');
				jQuery('#selectPlay').attr('v','1');
				jQuery('#chuan_ div.ww_').find('.cur').removeClass('cur');
				jQuery('#chuan_ div.ww_ span').eq(0).addClass('cur');
				
				Bjdc_sx_t.gg_();	
				Bjdc_sx_t.c();
				Bjdc_sx_t.local_();
			});
			jQuery('.error2').Touch(function(){//删除一条
				$(this).parent().parent().animate({left:kd_},500,function(){
					$(this).remove();
					Bjdc_sx_t.gg_();
					Bjdc_sx_t.c();
					Bjdc_sx_t.local_();
				});
			});
			jQuery('#tjss').click(function(){//添加赛事
				Bjdc_sx_t.href_('#class=url&xo=bjdc/sx/index.html');
			});
			jQuery('#fqhm').click(function(){//发起合买
				var c = jQuery('#content li[v=y]').length;
				var g = jQuery('#selectPlay').attr('v');
				if(c == '0'){
					D.alert('亲，最少选择一场比赛');
				}else if(g == ''){
					D.alert('请选择过关方式');
				}else{
					var zs = jQuery('#count_ cite:eq(0)').html();
					var bs = jQuery('#bs_').val();
					var m = jQuery('#count_ cite:eq(1)').html();
					var lotid =jQuery('#lotid').val();
					Bjdc_sx_t.href_('/#class=url&xo=trade/buyconfirm.html&zs='+zs+'&bs='+bs+'&money='+m+'&bk=1&gid='+lotid+'&pid='+pid);
				}
			});
			jQuery('#payment').click(function(){//代购
					var c = jQuery('#content li[v=y]').length;
					var g = jQuery('#selectPlay').attr('v');
					if(c == '0'){
						D.alert('亲，最少选择一场比赛');
					}else if(g == ''){
						D.alert('请选择过关方式');
					}else{
						var zs = $('#count_ cite:eq(0)').html();
						var z = $('#count_ cite:eq(1)').html();
						var bs = $('#bs_').val();
						var gid = $('#lotid').val();
						Bjdc_sx_t.href_('/#class=url&xo=trade/paybd.html&notes='+zs+'&bs='+bs+'&countMoney='+z+'&bk=0&gid='+gid+'&pid='+pid);
					}
			});
			jQuery('#selectPlay').click(function(){//打开关闭过关方式层
				var a = jQuery('#content li[v=y]').length;
				var b = jQuery('#chuan_ div.ww_ span').length;
				if(!a){
					jQuery('#chuan_ div.ww_ span').hide();
					jQuery('#chuan_ div.ww_ span').eq(0).show();
				}else{
					for(var n = 0; n<b; n++){
						if(n<a){
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
				Bjdc_sx_t.c();
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
				Bjdc_sx_t.c();
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
							Bjdc_sx_t.c();
						});
					}else{
						Bjdc_sx_t.c();
					}
				}
			});
			$('#bs_').blur(function(){//最大倍数500
				if($(this).val() == ''){
					var bs = 1;
					$(this).val(bs);
					Bjdc_sx_t.c();
				}
			});
		},
		href_: function(u){
			var c = '',d= '',g= jQuery('#selectPlay').attr('v');
			jQuery('#content li[v=y]').each(function(){
				c += $(this).attr('t')+'='+$(this).attr('c').replace(/,/g,'/')+',';
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
			localStorage.setItem('bd_sxp_PollNum',c);
			location.href=u;
		},
		local_: function(){//bd_sxp_SelectNum重新赋值
			var c = jQuery('#content').html();
			localStorage.setItem('bd_sxp_SelectNum',c);
		},
		c: function(){
			var n = jQuery('#selectPlay').attr('v');//过关方式
			var m = '',
			con = jQuery('#content li[v=y]');
			con.each(function(){
				m += $(this).attr('c').split(',').length+',';
			});
			m = m.substr(0,m.length-1);
			if(n == '' || m == ''){
				jQuery('#count_').html('共<cite class="yellow">0</cite>注<cite class="yellow">0</cite>元');
				$('.spfjj').hide();
			}else{
				var zs_ = Count.c(n,m);
				var bs_ = parseInt(jQuery('#bs_').val());
				jQuery('#count_').html('共<cite class="yellow">'+zs_+'</cite>注<cite class="yellow">'+2*zs_*bs_+'</cite>元');
				var data = [].slice.call(con).map(function(o) {
					var sp,division = {};
					sp = [].slice.call($(o).find('.cur')).map(function(t){
						var xo = $(t).find('cite').html();
						xo = !!parseInt(xo) && xo || '1';
						return xo;
					});
					division['max'] = Count.division(sp,'true');
					division['min'] = Count.division(sp);
			        return division;
			    });
				var prix = Count.prix(data,n);
				$('.spfjj').show();
				var min = (prix.min*0.65*bs_).toFixed(2);
				var max = (prix.max*0.65*bs_).toFixed(2);
				prix = (min == max)?max:(min+'~'+max);
				$('.spfjj em').html(prix);
			}
		}
};
Bjdc_sx_t.initial();//初始化