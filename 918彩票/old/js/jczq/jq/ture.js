/*
 * Author: weige
 * Date: 2014-7-2
 */
var kd_ = '-'+$(window).width()+'px';
if(window.location.pathname == '/m/'){
	pid = decodeURIComponent(CP.Util.getParaHash("pid"));
}else{
	pid = location.search.getParam('pid');//期号
}
var Jczq_jq_t = {
		initial: function(){
			var html = localStorage.getItem('jczq_jq_SelectNum');
			!!html && jQuery('#content').html(html);
			jQuery('#selectPlay').val('2串1');
			jQuery('#selectPlay').attr('v','2');
			jQuery('#chuan_ div.ww_ span').eq(0).addClass('cur');
			Jczq_jq_t.c();//初始化注数
			Jczq_jq_t.bind();//初始化的一些绑定事件
		},
		gg_: function(){//一些事件触发改变过关方式
			var l = $('#content li[v=y]').length;
			if(l<2){
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
				if($(this).parent().parent().find('.cur').length == 0) bl = true;
				
				$(this).toggleClass('cur');
				var l_ = $(this).parent().parent().find('.cur').length;
				if(l_){
					var c = '';
					$(this).parent().parent().find('span.cur').each(function(){
						c += $(this).attr('v')+',';
						
					});
					c = c.substring(0, c.length-1);
					$(this).parent().parent().attr('c',c);//投注号码
					
					$(this).parent().parent().attr('v','y');//当前行是否有选投注号码
					(bl && l_ == 1) && Jczq_jq_t.gg_();
				}else{
					$(this).parent().parent().removeAttr('v');
					$(this).parent().parent().removeAttr('c');
					
					Jczq_jq_t.gg_();
				//	Jczq_jq_t.initial();
				}
				
				Jczq_jq_t.c();
				Jczq_jq_t.local_();
			});
			jQuery('#clearTab').Touch(function(){//清空
				localStorage.removeItem('jczq_jq_PollNum');
				jQuery('#content li[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur');
				
				jQuery('#selectPlay').val('2串1');
				jQuery('#selectPlay').attr('v','1');
				jQuery('#chuan_ div.ww_').find('.cur').removeClass('cur');
				jQuery('#chuan_ div.ww_ span').eq(0).addClass('cur');
					
				Jczq_jq_t.gg_();
				Jczq_jq_t.c();
				Jczq_jq_t.local_();
				D.tx("至少选择2场比赛");
			});
			jQuery('.error2').Touch(function(){//删除一条
				$(this).parent().parent().animate({left:kd_},500,function(){
					$(this).remove();
					
					Jczq_jq_t.gg_();
					Jczq_jq_t.c();
					Jczq_jq_t.local_();
				});
			//	if (jQuery('#content li[v=y]').length<=2)
			//		D.tx("至少选择2场比赛");
			});
			jQuery('#tjss').click(function(){//添加赛事
				Jczq_jq_t.href_('#class=url&xo=jczq/jq/index.html');
			});
			jQuery('#fqhm').click(function(){//发起合买
				var c = jQuery('#content li[v=y]').length;
				var g = jQuery('#selectPlay').attr('v');
				if(c == '0'){
					D.tx('亲，最少选择两场比赛');
				}else if(g == ''){
					D.tx('请选择过关方式');
				}else{
					var zs = jQuery('#count_ cite:eq(0)').html();
					var bs = jQuery('#bs_').val();
					var m = jQuery('#count_ cite:eq(1)').html();
					var lotid =jQuery('#lotid').val();
					var z = $('#count_ cite:eq(1)').html();//总金额
					var gid = $('#lotid').val();//彩种id
					if(zs>0)
					Jczq_jq_t.href_('#class=url&xo=trade/buyconfirm.html&bk=1'+'&gid=93'+'&zs='+zs+'&bs='+bs+'&money='+z);
					else
					D.tx('亲，最少选择两场比赛');
				}
			});
			jQuery('#payment').click(function(){//代购
					var c = jQuery('#content li[v=y]').length;
					var g = jQuery('#selectPlay').attr('v');
					if(c == '0'){
						D.tx('亲，最少选择两场比赛');
					}else if(g == ''){
						D.tx('请选择过关方式');
					}else{
						var zs = $('#count_ cite:eq(0)').html();//注数
						var z = $('#count_ cite:eq(1)').html();//总金额
						var bs = $('#bs_').val();//倍投数
						var gid = $('#lotid').val();//彩种id
						if(zs>0)	
						Jczq_jq_t.href_('#class=url&xo=trade/paybd.html&bk=0'+'&gid=93'+'&notes='+zs+'&issue=1'+'&bs='+bs+'&countMoney='+z);
						else
						D.tx('亲，最少选择两场比赛');
					}
			});
			jQuery('#selectPlay').click(function(){//打开关闭过关方式层
				var a = jQuery('#content li[v=y]').length;
				var zs2 = jQuery('#count_ cite:eq(0)').html();
				if(zs2>0)
					{
				var b = jQuery('#chuan_ div.ww_ span').length;

				if(!a){
					jQuery('#chuan_ div.ww_ span').hide();
					jQuery('#chuan_ div.ww_ span').eq(0).show();
				}else{
					for(var n = 0; n<b; n++){
						if(n<a-1){
							jQuery('#chuan_ div.ww_ span').eq(n).show();
							if(jQuery("#selectPlay").attr("v").indexOf(n+2)!=-1){
							jQuery('#chuan_ div.ww_ span').eq(n).addClass('cur');
							}
						}else{
							jQuery('#chuan_ div.ww_ span').eq(n).hide();
							jQuery('#chuan_ div.ww_ span').eq(n).removeClass('cur');
						}
					}
				}
				jQuery('#chuan_').show();
				jQuery('#chuan_').css({marginTop:'-'+($('#chuan_').height()/2)+'px'});
				jQuery('#Mask_chuan').show();
					}
				else
					D.tx('亲，最少选择两场比赛');
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
				Jczq_jq_t.c();
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
				Jczq_jq_t.c();
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
						D.tx('最大可投倍数50000',function(){
							$('#bs_').val('50000');
							Jczq_jq_t.c();
						});
					}else{
						Jczq_jq_t.c();
					}
				}
			});
			$('#bs_').blur(function(){//最大倍数500
				if($(this).val() == ''){
					var bs = 1;
					$(this).val(bs);
					Jczq_jq_t.c();
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
			localStorage.setItem('jczq_jq_PollNum',c);
			location.href=u;
		},
		local_: function(){//jczq_spf_SelectNum重新赋值
			var c = jQuery('#content').html();
			localStorage.setItem('jczq_jq_SelectNum',c);
		},
		c: function(){
			var n = jQuery('#selectPlay').attr('v');//过关方式
			var m = '';
			con = jQuery('#content li[v=y]');
			if (con.length>1)
			{
			con.each(function(){
				m += $(this).attr('c').split(',').length+',';
			});
			m = m.substr(0,m.length-1);
			if(n == '' || m == ''){
				jQuery('#count_').html('共<cite class="yellow">0</cite>注<cite class="yellow">0</cite>元');
				$('.spfjj').hide();
			}else{
				var zs_ = Count.c(n,m);s
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
			else{
			jQuery('#count_').html('共<cite class="yellow">0</cite>注<cite class="yellow">0</cite>元');
			$(".spfjj").hide();
			}
		}
};
Jczq_jq_t.initial();//初始化