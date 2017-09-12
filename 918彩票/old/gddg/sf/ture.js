/*
 * @Author:wangwei
 * @date:2014.10.16 14:33
 */

CP.Gddg = {};
CP.Gddg.Sf_t = function(){
	var dom = {
			item:$('#item'),//内容
			jjyhFloat:$('.jjyhFloat'),//批量  理论奖金
			jjyhdouble2:$('.jjyhdouble2'),//批量设置层
			gddgFloat:$('.gddgFloat'),//合买 自购
			jjyhinput:$('.jjyhinput')//添加赛事 清空
	};
	var w = {
			init : function(){
				var html = localStorage.getItem('dg_spf_SelectNum');
				!!html && dom.item.html(html);
				
				w.select();
				w.c();
			},
			select : function(){
				dom.jjyhinput.find('input:eq(0)').val('添加赛事(已选'+dom.item.find('article[v=y]').length+'场)');
			},
			batch : function(z){//批量调整金额
				dom.item.find('.jjyhbuy').each(function(){
					var t = parseFloat($(this).find('strong').attr('sp'));
					$(this).find('input').val(z);
					$(this).find('i').html((t*z).toFixed('1'));
				});
				w.c();
			},
			c : function(){//计算投注金额
				var t = 0,max = 0,min = 10000000;
				dom.item.find('article[v=y]').each(function(){
					var z2 = 0;
					$(this).find('strong[class=cur]').each(function(){
						var z = '',z1 = '';
						if($(this).next().find('input').val() == ''){
							z = 0;
						}else{
							z = parseInt($(this).next().find('input').val());
						}
						z1 = parseFloat($(this).parent().find('i').html());
						min = (min<z1)?min:z1;
						t += z;
						z2 = (z2>z1)?z2:z1;
					});
					max += z2;
				});
				if(t == '0'){
					dom.gddgFloat.find('a:eq(1)').attr('v',0);
					dom.gddgFloat.find('a:eq(1)').html('猜中比赛结果即获奖');
					dom.jjyhFloat.hide();
				}else{
					max = max.toFixed('2');
					dom.gddgFloat.find('a:eq(1)').attr('v',t);
					dom.gddgFloat.find('a:eq(1)').html('立即付款  '+t+'元');
					dom.jjyhFloat.show();
					if(min == max){
						dom.jjyhFloat.find('em').html(min);
					}else{
						dom.jjyhFloat.find('em').html(min+'~'+max);
					}
				}
			},
			href_ : function(go){
				var t = '',tt = '',ttt = '';
				dom.item.find('article[v=y]').each(function(){
					var t1 = $(this).attr('t');//编号
					ttt += t1 +'[';
					$(this).find('.jjyhbuy .cur').each(function(){
						var t2 = parseInt($(this).next().find('input').val())/2;
						t += 'SPF|'+ t1 +'='+ $(this).attr('v') +'|1*1_'+ t2 +';';//拼code
						ttt += $(this).attr('v') +',';
					});
					ttt = ttt.substring(0, ttt.length-1) +']/';
					tt += t1 +',';
				});
				t = t.substring(0, t.length-1);
				tt = tt.substring(0, tt.length-1);
				ttt = ttt.substring(0, ttt.length-1);
				t = t +'$'+ tt +'$'+ ttt;
				if(t == '$$'){
					t = '';
				}
				localStorage.setItem('dg_spf_PollNum',t);
				location.href = go;
			}
	};
	var bind = function(){
		dom.item.on('click','.jjyhbuy strong',function(){//选择投注内容
			if($(this).hasClass('cur')){
				$(this).removeClass('cur');
				$(this).parent().addClass('grayBg2').next().hide();
				if($(this).parent().parent().find('.jjyhbuy .cur').length == '0'){
					$(this).parent().parent().removeAttr('v');
				} 
			}else{
				$(this).addClass('cur');
				$(this).parent().removeClass('grayBg2');
				$(this).parent().parent().attr('v','y');
			}
			w.select();
			w.c();
		}).on('click','.jjyhdouble .jian',function(){//减
			var t = parseInt($(this).next().val());
			if($(this).parent().parent().parent().find('strong').hasClass('cur')){
				dom.item.find('.ssqzh').hide();
				if(t == '4' || t == '2'){
					$(this).parent().parent().parent().next().hide();
    			}else{
    				$(this).parent().parent().parent().next().show().find('.cur').removeClass('cur');
    			}
        	}
        	if(t == '3'){
        		$(this).next().val('2');
        	}else if(t <= '2'){
        		D.msg('最少2元');
        	}else{
        		$(this).next().val(t-2);
        	}
        	var sp = parseFloat($(this).parent().parent().prev().attr('sp'));
        	$(this).parent().parent().next().html((sp*$(this).next().val()).toFixed(1));
        	w.c();
        }).on('click','.jjyhdouble .jia',function(){//加
        	if($(this).parent().parent().parent().find('strong').hasClass('cur')){
        		dom.item.find('.ssqzh').hide();
    			$(this).parent().parent().parent().next().show().find('.cur').removeClass('cur');
        	}
        	var t = parseInt($(this).prev().val());
        	$(this).prev().val(t+2);
        	var sp = parseFloat($(this).parent().parent().prev().attr('sp'));
        	$(this).parent().parent().next().html((sp*$(this).prev().val()).toFixed(1));
        	w.c();
        }).on('keyup','.jjyhdouble span input',function(){//购买多少元
			this.value=this.value.replace(/\D/g,'');
			var sp = parseFloat($(this).parent().parent().prev().attr('sp'));
        	$(this).parent().parent().next().html((sp*$(this).val()).toFixed(1));
			w.c();
		}).on('focus','.jjyhdouble span input',function(){//购买多少元
			if($(this).parent().parent().parent().find('strong').hasClass('cur')){
				dom.item.find('.ssqzh').hide();
				$(this).parent().parent().parent().next().show().find('.cur').removeClass('cur');
        	}
		}).on('blur','.jjyhdouble span input',function(){//购买多少元
        	var t = parseInt($(this).val());
        	if($(this).val() == '' || t == '0' || t % 2 != '0'){
        		if($(this).val() == '' || t == '0'){
        			D.msg('最少2元');
            		$(this).val('2');
        		}else{
        			D.msg('必须是双数');
            		$(this).val(t+1);
        		}
        		var sp = parseFloat($(this).parent().parent().prev().attr('sp'));
            	$(this).parent().parent().next().html((sp*$(this).val()).toFixed(1));
            	w.c();
        	}
		}).on('click','.ssqzh li',function(){//购买多少元
			if($(this).hasClass('cur')){
				return
			}
			$(this).addClass('cur').siblings().removeClass('cur');
			var t = parseInt($(this).attr('v'));//多少元
			var sp = parseFloat($(this).parent().prev().find('strong').attr('sp'));
			$(this).parent().prev().find('input').val(t);
			$(this).parent().prev().find('i').html((t*sp).toFixed('1'));
			w.c();
		});
		dom.jjyhFloat.on('click','.plsz',function(){//批量设置金额
			dom.jjyhdouble2.toggle();
		}).on('click','.jjyh',function(){//奖金优化
			D.msg('敬请期待！');
		});
		dom.jjyhdouble2.on('click','em:eq(0)',function(){//批量减
			var t = parseInt($(this).next().val());
        	if(t == '3'){
        		$(this).next().val('2');
        	}else if(t <= '2'){
        		D.msg('最少2元');
        	}else{
        		$(this).next().val(t-2);
        	}
        	var z = $(this).next().val();
        	w.batch(z);
		}).on('click','em:eq(1)',function(){//批量加
			var t = parseInt($(this).prev().val());
			var z = t+2;
        	$(this).prev().val(z);
        	w.batch(z);
		}).on('keyup','input',function(){//批量手动输入
			this.value=this.value.replace(/\D/g,'');
			var z = $(this).val();
        	w.batch(z);
		}).on('blur','input',function(){
			var t = parseInt($(this).val());
        	if($(this).val() == '' || t == '0'){
        		D.msg('最少2元');
        		$(this).val('2');
        	}else{
        		if(t % 2 == '0'){
            		$(this).val(t);
            	}else{
            		D.msg('必须是双数');
            		$(this).val(t+1);
            	}
        	}
        	var z = $(this).val();
        	w.batch(z);
		});
		
		dom.jjyhinput.on('click','input:eq(0)',function(){//添加赛事
			w.href_('#class=url&xo=gddg/sf/more.html');
		}).on('click','input:eq(1)',function(){//清空
			dom.jjyhdouble2.hide();
			dom.jjyhdouble2.find('input').val('2');
			dom.jjyhFloat.hide();
			dom.gddgFloat.find('a:eq(1)').attr('v',0);
			dom.gddgFloat.find('a:eq(1)').html('猜中比赛结果即获奖');
			dom.item.find('.ssqzh').hide().find('.cur').removeClass('cur');
			dom.item.find('article').removeAttr('v');
			dom.jjyhinput.find('input:eq(0)').val('添加赛事(已选0场)');
			dom.item.find('.jjyhbuy .cur').removeClass('cur');
			dom.item.find('.jjyhbuy').addClass('grayBg2');
			dom.item.find('.jjyhdouble input').each(function(){
				$(this).val('2');
				var sp = parseFloat($(this).parent().parent().prev().attr('sp'));
				$(this).parent().parent().next().html((sp*2).toFixed('1'));
			});
		});
		dom.gddgFloat.on('click','a:eq(0)',function(){//合买
			var m = dom.gddgFloat.find('a:eq(1)').attr('v');
			var l = dom.item.find('article[v=y]').length;
			if(l<=0){
        		D.msg('请先选择一场比赛');
        	}else if(m <2){
        		D.msg('购买金额最少2元');
        	}else{
        		w.href_('/#class=url&xo=gddg/pay/dg_fqhm.html&money='+m+'&gid=72');
        	}
		}).on('click','a:eq(1)',function(){//代购
			var m = dom.gddgFloat.find('a:eq(1)').attr('v');
			var l = dom.item.find('article[v=y]').length;
			if(l<=0){
        		D.msg('请先选择一场比赛');
        	}else if(m <2){
        		D.msg('购买金额最少2元');
        	}else{
				w.href_('/#class=url&xo=gddg/pay/paydg.html&money='+m+'&bk=0&gid=72');
        	}
		});
		$('.fcbackIco2').on('click',function(){
			localStorage.removeItem('dg_spf_PollNum');
			history.go(-1);
		});
	};
	var init = function(){
		w.init();
		dom.jjyhdouble2.find('input').val('2');
		bind();
	};
	init();
	return{};
}();