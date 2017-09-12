/*
 * @Author:wangwei
 * @date:2014.10.16 14:33
 */

CP.Gddg = {};
CP.Gddg.Bf_t = function(){
	var dom = {
			item:$('#item'),//内容
			jjyhFloat:$('.jjyhFloat'),//批量  理论奖金
			jjyhdouble2:$('.jjyhdouble2'),//批量设置层
			gddgFloat:$('.gddgFloat'),//合买 自购
			jjyhinput:$('.jjyhinput')//添加赛事 清空
	};
	var w = {
			init : function(){
				var html = localStorage.getItem('dg_bf_SelectNum');
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
					if(parseInt($(".jjyhbuy .cur").length)<2)
					{ 
					$(".jjyhdouble3").hide();
					$(".jjyhFloat .jjyh").hide();
					}
					else
						{
						$(".jjyhFloat .jjyh").show();
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
						var t3 = $(this).attr('v');
						t3 = {'胜其它':'9:0','负其它':'0:9','平其它':'9:9'}[t3]||t3;
						t += 'CBF|'+ t1 +'='+ t3 +'|1*1_'+ t2 +';';//拼code
						ttt += t3 +',';
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
				localStorage.setItem('dg_bf_PollNum',t);
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
			$(".jjyhdouble3").hide();
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
			$(".jjyhdouble3").hide();
s
        	w.c();
        }).on('keyup','.jjyhdouble span input',function(){//购买多少元
			this.value=this.value.replace(/\D/g,'');
			var sp = parseFloat($(this).parent().parent().prev().attr('sp'));
        	$(this).parent().parent().next().html((sp*$(this).val()).toFixed(1));
			$(".jjyhdouble3").hide();

			w.c();
		}).on('focus','.jjyhdouble span input',function(){//购买多少元
			if($(this).parent().parent().parent().find('strong').hasClass('cur')){
				dom.item.find('.ssqzh').hide();
				$(this).parent().parent().parent().next().show().find('.cur').removeClass('cur');
				$(".jjyhdouble3").hide();

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
				$(".jjyhdouble3").hide();

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
			$(".jjyhdouble3").hide();

			w.c();
		});
		dom.jjyhFloat.on('click','.plsz',function(){//批量设置金额
			dom.jjyhdouble2.toggle();
			$(".jjyhdouble3").hide();

		}).on('click','.jjyh',function(){//奖金优化
			//D.msg('敬请！');
			var jjj=parseInt($(".clearfix  .ture").attr("v"));
			var kkk=parseInt($("#put").val());
			alert(jjj-kkk);
			//alert("下面    "+$(".clearfix  .ture").attr("v"));
			//alert(parseInt($("#put").val()));
						
			$("#put").val(4*$(".jjyhbuy .cur").length);		
			if(jjj>kkk)
			{	
				alert("11111111111111");

				$("#put").val(jjj);}
			else
				{
				$("#put").val(4*$(".jjyhbuy .cur").length);
				if(jjj<kkk)
				{D.tx("至少买"+4*$(".jjyhbuy .cur").length+"元才方便奖金优化");}
				}
			
			$(".jjyhdouble3 ").toggle();
		//	$(".jjyhdouble3 span:eq(0)").click();
			
			
			
//			if(!(".jjyhdouble3 ").style.display=="none")
//				{
//				$("#put").val("555");
//				}
				
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
			w.href_('#class=url&xo=gddg/bf/more.html');
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
        		w.href_('/#class=url&xo=gddg/pay/dg_fqhm.html&money='+m+'&gid=91');
        	}
		}).on('click','a:eq(1)',function(){
			var m = dom.gddgFloat.find('a:eq(1)').attr('v');
			var l = dom.item.find('article[v=y]').length;
			if(l<=0){
        		D.msg('请先选择一场比赛');
        	}else if(m <2){
        		D.msg('购买金额最少2元');
        	}else{
				w.href_('/#class=url&xo=gddg/pay/paydg.html&money='+m+'&bk=0&gid=91');
        	}
		});
		$('.fcbackIco2').on('click',function(){
			localStorage.removeItem('dg_bf_PollNum');
			history.go(-1);
		});
	};
	var init = function(){
		w.init();
		dom.jjyhdouble2.find('input').val('2');
		bind();
	};
	init();
	return{c:w.c};
}();
CP.Gddg.Bf_t .c();




 function sumsp(){
	var spsum = new Array();
	var k=0;
$(".jjyhbuy .cur cite").each(function(){	
//	alert();
	//alert($(this).html());
	spsum[k] = parseInt($(this).html());	
	k++;
});
return spsum;
};

$(".jjyhdouble3 span:eq(0)").click(function(){

	
	var money=parseInt($("#put").val());
	$(".jjyhdouble3 span:eq(1)").removeClass("cur");
	$(".jjyhdouble3 span:eq(2)").removeClass("cur");
	$(".jjyhdouble3 span:eq(0)").addClass("cur");
	var diapl=sum(sumsp(),money);
//	alert(diapl);
	var jk=0;
	$(".jjyhbuy .cur").each(function(){
		//alert($(this).parent().find("input").length);
//		$(this).parent().find("input").attr("value",diapl[jk]*2);
		$(this).parent().find("input").val(diapl[jk]*2);
		$(this).parent().find("i").html((diapl[jk]*parseFloat($(this).find("cite").html())*2).toFixed('1'));
		jk++;
	});
	CP.Gddg.Bf_t .c();

});
$(".jjyhdouble3 span:eq(1)").click(function(){
	$(".ssqzh li").removeClass("cur");
	var money=parseInt($("#put").val());
	$(".jjyhdouble3 span:eq(2)").removeClass("cur");
	$(".jjyhdouble3 span:eq(0)").removeClass("cur");
	$(".jjyhdouble3 span:eq(1)").addClass("cur");
	var diap2=sum_minsp(sumsp(),money);
//alert(diap2);
	var jk=0;
	$(".jjyhbuy .cur").each(function(){
		$(".ssqzh li").removeClass("cur");
		//alert($(this).parent().find("input").length);
//		$(this).parent().find("input").attr("value",diap2[jk]*2);
		$(this).parent().find("input").val(diap2[jk]*2);
		$(this).parent().find("i").html((diap2[jk]*parseFloat($(this).find("cite").html())*2).toFixed('1'));
		jk++;
	});
	CP.Gddg.Bf_t .c();

});
$(".jjyhdouble3 span:eq(2)").click(function(){
	$(".ssqzh li").removeClass("cur");
	var money=parseInt($("#put").val());
	$(".jjyhdouble3 span:eq(0)").removeClass("cur");
	$(".jjyhdouble3 span:eq(1)").removeClass("cur");
	$(".jjyhdouble3 span:eq(2)").addClass("cur");
	var diap3=sum_maxsp(sumsp(),money);
//	alert(diap3);
	var jk=0;
	$(".jjyhbuy .cur").each(function(){
		//alert($(this).parent().find("input").length);
//		$(this).parent().find("input").attr("value",diap3[jk]*2);
		$(this).parent().find("input").val(diap3[jk]*2);
		$(this).parent().find("i").html((diap3[jk]*parseFloat($(this).find("cite").html())*2).toFixed('1'));
		jk++;
	});
	CP.Gddg.Bf_t .c();

});


//平均优化 sp数组  money 总金额
function sum(sp,money){	
	var s=1;
	var sum=0;		
	for(var i=0;i<sp.length;i++)
	{s=s*sp[i];
	}	
	var sp_tmp = new Array();	
		for(var j=0;j<sp.length;j++)
	{
		sp_tmp[j]=s/sp[j]; 
		sum=sum+sp_tmp[j];	
	}	
	var sp_re = new Array();
	var money_tmp=money/2;
	for(var k=0;k<sp.length;k++)
	{
		if(k<sp.length-1)
		{sp_re[k]=Math.round(sp_tmp[k]/sum*money/2);
		money_tmp=money_tmp-sp_re[k];
		}
		else
			sp_re[k]=money_tmp;				
	}
	return sp_re;
}

function sum_minsp(sp,money)
{
	var sort_sp = sp;
	var sp_min_num=0;
	
	for(var j=1;j<sp.length;j++)
	{	if(sp[j]<sp[sp_min_num])
		sp_min_num=j;
	}
		var sp_re = new Array();
		var tmp_sum=0;
	for(var i=0;i<sp.length;i++)
	{
		if(i!=sp_min_num)
		{
			sp_re[i]=Math.ceil((money+0.0)/sp[i]/2);
			tmp_sum=tmp_sum+sp_re[i];
		}					
		
		if(i==sp.length-1)
			sp_re[sp_min_num]=money/2-tmp_sum;
			
	}
	return sp_re;
}

function sum_maxsp(sp,money)
{
	var sort_sp = sp;
	var sp_min_num=0;
	
	for(var j=1;j<sp.length;j++)
	{	if(sp[j]>sp[sp_min_num])
		sp_min_num=j;
	}
		var sp_re = new Array();
		var tmp_sum=0;
	for(var i=0;i<sp.length;i++)
	{
		if(i!=sp_min_num)
		{
			sp_re[i]=Math.ceil((money+0.0)/sp[i]/2);
			tmp_sum=tmp_sum+sp_re[i];
		}					
		
		if(i==sp.length-1)
			sp_re[sp_min_num]=money/2-tmp_sum;
			
	}
	return sp_re;
}


$("#put").blur(function(){

	if(parseInt($("#put").val())<4*$(".jjyhbuy .cur").length)
	{	
		D.alert("至少购买"+4*$(".jjyhbuy .cur").length+"元");
	$("#put").val(4*$(".jjyhbuy .cur").length);
	}

	if(parseInt($("#put").val())%2==1)
	{
		D.alert("购买金额必须为单数");
	$("#put").val(parseInt($("#put").val())+1);
	}
	
	if($(".jjyhdouble3 .cur").html()=="平稳盈利")
		$(".jjyhdouble3 span:eq(0)").click();
	else if($(".jjyhdouble3 .cur").html()=="中奖优先")
		$(".jjyhdouble3 span:eq(1)").click();
	else if($(".jjyhdouble3 .cur").html()=="奖金优先")
		$(".jjyhdouble3 span:eq(2)").click();
	
	});


$("#put").val(parseInt($(".clearfix  .ture").attr("v")));
alert("最后：   "+ parseInt($(".clearfix  .ture").attr("v")));
