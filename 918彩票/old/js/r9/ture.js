/*
 * Author: weige
 * Date: 2014-07-29
 */
var kd_ = '-'+$(window).width()+'px',pid;
pid = decodeURIComponent(CP.Util.getParaHash("pid"));
var R9_t = {
		initial: function(){
			var html = localStorage.getItem('zc_r9_SelectNum');
			!!html && jQuery('#content').html(html);
			
			R9_t.c();//初始化注数
			R9_t.bind();//初始化的一些绑定事件
		},
		bind: function(){
			jQuery('#content div.spfzpk').find('span').Touch(function(){//选择投注内容
				$(this).toggleClass('cur');
				var l_ = $(this).parent().find('.cur').length;
				if(l_){
					var c = '';
					$(this).parent().find('.cur').each(function(){
						c += $(this).attr('v')+',';
					});
					c = c.substring(0, c.length-1);
					$(this).parent().parent().attr('c',c);//投注号码
					$(this).parent().parent().attr('v','y');//当前行是否有选投注号码
				}else{
					$(this).parent().parent().removeAttr('v');
					$(this).parent().parent().removeAttr('c');
				}
				
				R9_t.c();
				R9_t.local_();
			});

			jQuery('#clearTab').Touch(function(){//清空
				jQuery('#content li[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur');
				
				R9_t.c();
				R9_t.local_();
			});
			jQuery('.errorBg').Touch(function(){//删除一条
				if(jQuery('#content li').length == 9){
					D.tx('至少保留9场');
					return;
				}
				$(this).parent().animate({left:kd_},500,function(){
					$(this).remove();
					
					R9_t.c();
					R9_t.local_();
				});
				
			});
			jQuery('#tjss').click(function(){//添加赛事
				R9_t.href_('#class=url&xo=r9/index.html');
			});
			jQuery('#fqhm').click(function(){//发起合买
				var c = jQuery('#content li[v=y]').length;
				if(c <9){
					D.alert('亲，最少选择九场比赛');
				}else{
					var zs = jQuery('#count_ cite:eq(0)').html();
					var bs = jQuery('#bs_').val();
					var m = jQuery('#count_ cite:eq(1)').html();
					var lotid =jQuery('#lotid').val();
					R9_t.href_('#class=url&xo=r9/hm/index.html&zs='+zs+'&bs='+bs+'&money='+m+'&bk=1&gid='+lotid+'&pid='+pid);
				}
			});
			jQuery('#payment').click(function(){//代购
				var c = jQuery('#content li[v=y]').length;
				if(c <9){
					D.alert('亲，最少选择九场比赛');
				}else{
						var zs = $('#count_ cite:eq(0)').html();
						var z = $('#count_ cite:eq(1)').html();
						var bs = $('#bs_').val();
						var gid = $('#lotid').val();
						R9_t.href_('#class=url&xo=trade/defrayal.html&notes='+zs+'&multiple='+bs+'&countMoney='+z+'&pattern=0&gid='+gid+'&pid='+pid);
				}
			});
			$('#bs_').keyup(function(){//最大倍数50000
				this.value=this.value.replace(/\D/g,'');
				if($(this).val() == 0 || $(this).val() == ''){
					$(this).val('');
				}else{
					if($(this).val()>50000){
						D.alert('最大可投倍数50000',function(){
							$('#bs_').val('50000');
							R9_t.c();
						});
					}else{
						R9_t.c();
					}
				}
			});
			$('#bs_').blur(function(){
				if($(this).val() == ''){
					var bs = 1;
					$(this).val(bs);
					R9_t.c();
				}
			});
		},
		href_: function(u){
			var code = ['#','#','#','#','#','#','#','#','#','#','#','#','#','#'];
			
			jQuery('#content li[v=y]').each(function(){
				code[parseInt($(this).attr('t'))-1] = $(this).attr('c').replace(/,/g,'');
			});
			var c = pid+'|'+code;
			localStorage.setItem('zc_r9_PollNum',c);
			location.href=u;
		},
		local_: function(){//zc_r9_SelectNum重新赋值
			var c = jQuery('#content').html();
			localStorage.setItem('zc_r9_SelectNum',c);
		},
		c: function(){
			var n = '9';//过关方式
			var m = '';
			jQuery('#content li[v=y]').each(function(){
				m += $(this).attr('c').split(',').length+',';
			});
			m = m.substr(0,m.length-1);
			if($('#content li[v=y]').length<9 || m == ''){
				jQuery('#count_').html('共<cite class="yellow">0</cite>注<cite class="yellow">0</cite>元');
			}else{
				var zs_ = Count.c(n,m);
				var bs_ = parseInt(jQuery('#bs_').val());
				jQuery('#count_').html('共<cite class="yellow">'+zs_+'</cite>注<cite class="yellow">'+2*zs_*bs_+'</cite>元');
			}
		}
};
R9_t.initial();//初始化
