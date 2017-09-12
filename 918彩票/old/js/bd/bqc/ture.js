/*
 * Author: weige
 * Date: 2014-10-31
 */
var kd_ = '-'+$(window).width()+'px';
var pid = '';
pid = decodeURIComponent(CP.Util.getParaHash("pid"));
var Bjdc_bqc_t = {
		initial: function(){
			var html = localStorage.getItem('bd_bqc_SelectNum');
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
				 Bjdc_bqc_t.c();//初始化注数
			}
			Bjdc_bqc_t.bind();//初始化的一些绑定事件
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
		public_bf: function(t,bl){//t 当前选的比分弹层   
			var l = t.find('div.competitions span.cur').length;
			if(l){//有选择的时候
				var n = 6 , k = '';
				t.attr('a','c');//比分的div
				t.prev().attr('v','y');//ul
				t.prev().find('div:eq(1) span').addClass('cur');
				if(l>n){
					t.prev().find('div:eq(1) span').html('已选'+l+'项');
				}else{
					var m = '';
					t.find('div.competitions span.cur').each(function(aa){
						if(aa<n){
							var s = $(this).find('strong').html();
							m += '<cite>'+s+'</cite>';
						}
					});
					
					t.prev().find('div:eq(1) span').html(m);
				}
				t.find('div.competitions span.cur').each(function(aa){
						var s = $(this).attr('value');
						k += s+',';
				});
				k = k.substr(0,k.length-1);
				t.prev().attr('c',k);
				
				(bl && l == 1) && Bjdc_bqc_t.gg_();
			}else{//没选择的时候
				t.removeAttr('a');
				t.prev().removeAttr('v');//ul 当前行是否有投注
				t.prev().removeAttr('c');//ul 投注内容
				t.prev().find('div:eq(1) span').html('立即投注');
				t.prev().find('div:eq(1) span').removeClass('cur');
				
				Bjdc_bqc_t.gg_();
			}
			
			Bjdc_bqc_t.c();
			Bjdc_bqc_t.local_();
		},
		bind: function(){
			jQuery('#content div.spfzpk').find('span').click(function(){//打开比分选项
				var c = $(window).height();
				var d = $(this).parent().parent().next().height();
				var t = '-'+(c/2)+'px';
				if(c>d){
					t = '-'+(d/2)+'px';
				}
				$(this).parent().parent().next().css('marginTop',t);
				$(this).parent().parent().next().show();
				jQuery('.zhezhao').show();
			});
			jQuery('.bf_').find('a:eq(0)').click(function(){//取消比分层
				$(this).parent().parent().find('.cur').removeClass('cur');
				
				jQuery('.zhezhao').hide();
				$(this).parent().parent().hide();
				
				Bjdc_bqc_t.public_bf($(this).parent().parent());
			});
			jQuery('.bf_').find('a:eq(1)').click(function(){//确定比分层
				jQuery('.zhezhao').hide();
				$(this).parent().parent().hide();
				
				Bjdc_bqc_t.public_bf($(this).parent().parent());
			});
			jQuery('.bf_ div.competitions span').click(function(){//选择比分
				var bl = false;
				if($(this).parent().parent().find('.cur').length == 0) bl = true;
				
				$(this).toggleClass('cur');
				
				Bjdc_bqc_t.public_bf($(this).parent().parent(),bl);
			});
			jQuery('#clearTab').Touch(function(){//清空
				localStorage.removeItem('bd_bqc_PollNum');
				jQuery('#content li[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur').html('立即投注');
				jQuery('#content div.bf_[a=c]').removeAttr('a').find('.cur').removeClass('cur');//清空之前比分层里面的cur
				
				jQuery('#selectPlay').val('单关');
				jQuery('#selectPlay').attr('v','1');
				jQuery('#chuan_ div.ww_').find('.cur').removeClass('cur');
				jQuery('#chuan_ div.ww_ span').eq(0).addClass('cur');
				
				Bjdc_bqc_t.gg_();
				Bjdc_bqc_t.c();
				Bjdc_bqc_t.local_();
			});
			jQuery('.error2').Touch(function(){//删除一条
				$(this).parent().parent().animate({left:kd_},500,function(){
					$(this).next().remove();
					$(this).remove();
					
					Bjdc_bqc_t.gg_();
					Bjdc_bqc_t.c();
					Bjdc_bqc_t.local_();
				});
			});
			jQuery('#tjss').click(function(){//添加赛事
				Bjdc_bqc_t.href_('#class=url&xo=bjdc/bqc/index.html');
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
					Bjdc_bqc_t.href_('#class=url&xo=trade/buyconfirm.html&zs='+zs+'&bs='+bs+'&money='+m+'&bk=1&gid='+lotid+'&pid='+pid);
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
						Bjdc_bqc_t.href_('#class=url&xo=trade/paybd.html&notes='+zs+'&bs='+bs+'&countMoney='+z+'&bk=0&gid='+gid+'&pid='+pid);
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
				jQuery('.zhezhao').show();
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
				
				Bjdc_bqc_t.c();
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
				jQuery('.zhezhao').hide();
				
				Bjdc_bqc_t.c();
			});
			jQuery('.zhezhao').click(function(){
				jQuery('#chuan_').hide();
				jQuery('.zhezhao').hide();
			});
			$('#bs_').keyup(function(){//最大倍数50000
				this.value=this.value.replace(/\D/g,'');
				if($(this).val() == 0 || $(this).val() == ''){
					$(this).val('');
				}else{
					if($(this).val()>50000){
						D.alert('最大可投倍数50000',function(){
							$('#bs_').val('50000');
							Bjdc_bqc_t.c();
						});
					}else{
						Bjdc_bqc_t.c();
					}
				}
			});
			$('#bs_').blur(function(){//最大倍数500
				if($(this).val() == ''){
					var bs = 1;
					$(this).val(bs);
					Bjdc_bqc_t.c();
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
			
			localStorage.setItem('bd_bqc_PollNum',c);
			location.href=u;
		},
		local_: function(){//bd_bqc_SelectNum重新赋值
			var c = jQuery('#content').html();
			localStorage.setItem('bd_bqc_SelectNum',c);
		},
		c: function(){
			var n = jQuery('#selectPlay').attr('v');//过关方式
			var m = '';
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
					sp = [].slice.call($(o).next().find('.cur')).map(function(t){
						var xo = $(t).find('em').html();
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
Bjdc_bqc_t.initial();//初始化