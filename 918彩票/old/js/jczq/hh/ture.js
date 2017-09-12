/*
 * Author: weige
 * Date: 2014-7-2
 */
var kd_ = '-'+$(window).width()+'px';
function sortNumber(a,b)
{
return a - b
}

var Jczq_hh_t = {
		initial: function(){
			var html = localStorage.getItem('jc_hh_SelectNum');
			!!html && jQuery('#content').html(html);
			
			jQuery('#selectPlay').val('2串1');
			jQuery('#selectPlay').attr('v','2');
			jQuery('#chuan_ div.ww_ span').eq(0).addClass('cur');
			Jczq_hh_t.c();//初始化注数
			Jczq_hh_t.bind();//初始化的一些绑定事件
		},
		gg_: function(){//一些事件触发改变过关方式
			var l = $('#content li[v=y]').length;
			
			if(!l || l<2){
				D.tx('亲，至少选择两场');
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
				var t = $(this).text();
				//$(this).toggleClass('cur');
				if(t=="--" || t=="未开售"){
					return ;
				}else{
					$(this).toggleClass('cur');
				}
				
				var l_ = $(this).parent().parent().find('.cur').length;
				if(l_){
					var c = '',d = '';
					$(this).parent().parent().find('div:eq(1)').find('span.cur').each(function(){
						c += $(this).attr('v')+',';
					});
					c = c.substr(0,c.length-1);
					$(this).parent().parent().find('div:eq(2)').find('span.cur').each(function(){
						d += $(this).attr('v')+',';
					});
					d = d.substr(0,d.length-1);
					$(this).parent().parent().attr('c',c);
					$(this).parent().parent().attr('d',d);
					
					$(this).parent().parent().attr('v','y');//当前行是否有选投注号码
					(bl && l_ == 1) && Jczq_hh_t.gg_();
				}else{
					$(this).parent().parent().removeAttr('v');//ul
					$(this).parent().parent().removeAttr('c');// 让分
					$(this).parent().parent().removeAttr('d');// 大小分
					
					Jczq_hh_t.gg_();
				}
				Jczq_hh_t.c();
				Jczq_hh_t.local_();
			});
			jQuery('#clearTab').Touch(function(){//清空
				jQuery('#content').html('');
				jQuery('#selectPlay').val('2串1');
					
				Jczq_hh_t.gg_();
				Jczq_hh_t.c();
				Jczq_hh_t.local_();
			});
			
			jQuery('.error2').Touch(function(){//删除一条
				$(this).parent().parent().animate({left:kd_},10,function(){
					$(this).remove();
					
					Jczq_hh_t.gg_();
					Jczq_hh_t.c();
					Jczq_hh_t.local_();
				});
			});
			
			jQuery('#tjss').click(function(){//添加赛事
				Jczq_hh_t.href_('#class=url&xo=jczq/hh/index.html');
			});
			jQuery('#fqhm').click(function(){//发起合买
				var c = jQuery('#content li[v=y]').length;
				var g = jQuery('#selectPlay').attr('v');
				if(c < 2){
					D.alert('亲，最少选择两场比赛');
				}else if(g == ''){
					D.alert('请选择过关方式');
				}else{
					var zs = jQuery('#count_ cite:eq(0)').html();
					var bs = jQuery('#bs_').val();
					var m = jQuery('#count_ cite:eq(1)').html();
					var lotid =jQuery('#PlayID').val();
					var selectPlay =jQuery('#selectPlay').val();
					Jczq_hh_t.href_('#class=url&xo=trade/buyconfirm.html&zs='+zs+'&bs='+bs+'&money='+m+'&bk=1&gid='+lotid);
				}
			});
			jQuery('#payment').click(function(){//代购
				var c = jQuery('#content li[v=y]').length;
				var g = jQuery('#selectPlay').attr('v');
				if(c < 2){
					D.alert('亲，最少选择两场比赛');
					return false;
				}
					if(c < 2){
						D.alert('亲，最少选择2场比赛');
						return false;
					}else if(g == ''){
						D.alert('请选择过关方式');
					}else{
						var zs = $('#count_ cite:eq(0)').html();
						var z = $('#count_ cite:eq(1)').html();
						var bs = $('#bs_').val();
						var gid = $('#PlayID').val();
						var selectPlay = $('#selectPlay').val();
						Jczq_hh_t.href_('#class=url&xo=trade/paybd.html&notes='+zs+'&bs='+bs+'&countMoney='+z+'&bk=0&gid='+gid);
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
				
				Jczq_hh_t.c();
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
				
				Jczq_hh_t.c();
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
							Jczq_hh_t.c();
						});
					}else{
						Jczq_hh_t.c();
					}
				}
			});
			$('#bs_').blur(function(){//最大倍数500
				if($(this).val() == ''){
					var bs = 1;
					$(this).val(bs);
					Jczq_hh_t.c();
				}
			});
		},
		href_: function(u){
			var c = '',d= '',g= jQuery('#selectPlay').attr('v'),
			rf,
			dx;
			
			jQuery('#content li[v=y]').each(function(){
				rf = $(this).attr('c').replace(/,/g,'/');
				dx = $(this).attr('d').replace(/,/g,'/');
				c += $(this).attr('t')+'>'+(rf != ''?'SPF='+rf+(dx!=''?'+':''):'')+(dx!=''?'RQSPF='+dx:'')+',';
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
			localStorage.setItem('jczq_hh_PollNum',c);
			location.href=u;
		},
		local_: function(){//bd_spf_SelectNum重新赋值
			var c = jQuery('#content').html();
			localStorage.setItem('jc_hh_SelectNum',c);
			localStorage.removeItem("jczq_hh_PollNum");
		},
		
		NzeroMin: function(num1,num2,num3){
			var L = new Array();	
			L[0]=parseFloat(num1);
			L[1]=parseFloat(num2);
			L[2]=parseFloat(num3);					
			var Lsort=L.sort(sortNumber);
			if(Lsort[0]!=0)
				return Lsort[0];
			else if(Lsort[1]!=0)
				return Lsort[1];
			else
				return Lsort[2];					
		},
		
		c: function(){
			var n = jQuery('#selectPlay').attr('v');//过关方式
			var m = '';
			con = jQuery('#content li[v=y]');
			jQuery('#content li[v=y]').each(function(){
				var i= $(this).attr('c').split(',').length;
				var j = $(this).attr('d').split(',').length;
				i = ($(this).attr('c') != '' && i) || 0;
				j = ($(this).attr('d') != '' && j) || 0;
				m += (i+j)+',';
			});
			m = m.substr(0,m.length-1);
			if(n == '' || m == ''){
				jQuery('#count_').html('共<cite class="yellow" id="sumCount">0</cite>注<cite class="yellow" id="sumMoney">0</cite>元');
				$('.spfjj').hide();
			}else{
				var zs_ = Count.c(n,m);
				var bs_ = parseInt(jQuery('#bs_').val());
				jQuery('#count_').html('共<cite class="yellow" id="sumCount">'+zs_+'</cite>注<cite class="yellow" id="sumMoney">'+2*zs_*bs_+'</cite>元');
				var data = [].slice.call(con).map(function(o) {
					var sp,sp1,sum,sumi,division = {},
					sp_max,sp1_max,sp_min,sp1_min;
					
					sp = [].slice.call($(o).find('div:eq(1)').find('span')).map(function(t){//让分
						if($(t).hasClass("cur")){
							var xo = $(t).find('cite').html();
							xo = !!parseInt(xo) && xo || '1';	
						}else{
							xo='0';
						}
						return xo;
					});
					
					sp1 = [].slice.call($(o).find('div:eq(2)').find('span')).map(function(t){//猜总分
						if($(t).hasClass("cur")){
							var xo = $(t).find('cite').html();
							xo = !!parseInt(xo) && xo || '1';	
						}else{
							xo='0';
						}
						return xo;
					});
	
				//	alert( ($(o).attr("close"));
					
		//	alert( "sp      "+$(t).parent.parent.attr("close") );
			
			
					//var sp_tmp=sp.split(",");
				//	var sp1_tmp=sp1.split(",");
				
					if(	$(o).attr("close") =='1'  ){	
					var N = new Array();			
					var Mi=new Array();
				 N[0]=parseFloat(sp[0])+parseFloat(sp1[0]);
				 N[1]=parseFloat(sp[1])+parseFloat(sp1[0]);
				 N[2]=parseFloat(sp[2])+parseFloat(sp1[1]);
				 N[3]=parseFloat(sp[2])+parseFloat(sp1[2]);
				 N[4]=parseFloat(sp[0]);
				 N[5]=parseFloat(sp[1]);
				 N[6]=parseFloat(sp[2]);
				 N[7]=parseFloat(sp1[0]);
				 N[8]=parseFloat(sp1[1]);
				 N[9]=parseFloat(sp1[2]);
				 
				 
				// if(sp[0]!=0 && sp1[0]!=0)
				 Mi[0]=Jczq_hh_t.NzeroMin(parseFloat(sp[0])+parseFloat(sp1[0]),parseFloat(sp[1])+parseFloat(sp1[0]),sp[2]);	 
				 Mi[1]=Jczq_hh_t.NzeroMin(Jczq_hh_t.NzeroMin( parseFloat(sp[0])+parseFloat(sp1[0]),parseFloat(sp[1])+parseFloat(sp1[0]),'9999'),sp1[1],sp1[2]);
		//		 else
//				 {Mi[0]=Jczq_hh_t.NzeroMin(sp[0],sp[1],sp[2]);	 
//				 Mi[1]=Jczq_hh_t.NzeroMin(sp1[0],sp1[1],sp1[2]);}
				
				// alert(Mi);
				 
				 // if((parseFloat(sp[2])+parseFloat(sp1[0]))!=0)
				 Mi[2]=Jczq_hh_t.NzeroMin(
						 Jczq_hh_t.NzeroMin( parseFloat(sp[0])+parseFloat(sp1[0]),parseFloat(sp[1])+parseFloat(sp1[0]),'9999'),
						 sp[2],
						 '9999');
				 //Mi[2]=parseFloat(sp[2])+parseFloat(sp1[0]);				 				
				 
		//		 alert(Mi);
				 var  MAX_w=N.sort(sortNumber)[9];
				 var  MIN_w=Jczq_hh_t.NzeroMin(Mi[0],Mi[1],Mi[2]);
					}else if(  $(o).attr("close") =='-1' ){
						var N = new Array();	
						var Mi=new Array();
						
						 N[0]=parseFloat(sp[0])+parseFloat(sp1[0]);
						 N[1]=parseFloat(sp[0])+parseFloat(sp1[1]);
						 N[2]=parseFloat(sp[1])+parseFloat(sp1[2]);
						 N[3]=parseFloat(sp[2])+parseFloat(sp1[2]);
						 N[4]=parseFloat(sp[0]);
						 N[5]=parseFloat(sp[1]);
						 N[6]=parseFloat(sp[2]);
						 N[7]=parseFloat(sp1[0]);
						 N[8]=parseFloat(sp1[1]);
						 N[9]=parseFloat(sp1[2]);	
	
						 Mi[0]=Jczq_hh_t.NzeroMin(parseFloat(sp[0])+parseFloat(sp1[0]),parseFloat(sp[1])+parseFloat(sp1[0]),sp[2]);	 
						 Mi[1]=Jczq_hh_t.NzeroMin(Jczq_hh_t.NzeroMin( parseFloat(sp[0])+parseFloat(sp1[0]),parseFloat(sp[1])+parseFloat(sp1[0]),'9999'),sp1[1],sp1[2]);						 
						
						 Mi[0]=Jczq_hh_t.NzeroMin(sp[0],parseFloat(sp[1])+parseFloat(sp1[2]),parseFloat(sp[2])+parseFloat(sp1[2]));						 
						 Mi[1]=Jczq_hh_t.NzeroMin(sp1[0],sp1[1]+sp[2],Jczq_hh_t.NzeroMin( parseFloat(sp[2])+parseFloat(sp1[2]),parseFloat(sp[1])+parseFloat(sp1[2]),'9999'));	 					 
						 Mi[2]=Jczq_hh_t.NzeroMin(
								 Jczq_hh_t.NzeroMin( parseFloat(sp[2])+parseFloat(sp1[2]),parseFloat(sp[1])+parseFloat(sp1[2]),'9999'),
								 sp[0],
								 '9999');					 
		//				 alert(Mi);
//						 if(sp[0]!=0 && sp1[2]!=0)
//						 {	Mi[0]=Jczq_hh_t.NzeroMin(0,sp[1],sp[2]); 
//						 Mi[1]=Jczq_hh_t.NzeroMin(sp1[0],sp1[1],0);}
//						 else
//							 {
	//						 Mi[0]=Jczq_hh_t.NzeroMin(sp[0],sp[1],sp[2]+sp1[2]);						 
		//					 Mi[1]=Jczq_hh_t.NzeroMin(sp1[0],sp1[1]+sp[2],sp[2]+sp1[2]);	 
	//						 }

						// if((parseFloat(sp[0])+parseFloat(sp1[2]))!=0)
						 
				//		 Mi[2]=parseFloat(sp[0])+parseFloat(sp1[2]);	
						 
						 var  MAX_w=N.sort(sortNumber)[9];	
						// alert(N);
						// alert("MAX_w   "+MAX_w);
						 var  MIN_w=Jczq_hh_t.NzeroMin(Mi[0],Mi[1],Mi[2]);
						 
					}else if( $(o).attr("close") =='2' || $(o).attr("close") =='3' || $(o).attr("close") =='4'  || $(o).attr("close") =='5'  || $(o).attr("close") =='6'  || $(o).attr("close") =='7'  ){
						var N = new Array();	 
						var Mi=new Array();
						N[0]=parseFloat(sp[0])+parseFloat(sp1[0]);
						 N[1]=parseFloat(sp[1])+parseFloat(sp1[0]);
						 N[2]=parseFloat(sp[2])+parseFloat(sp1[1]);
						 N[3]=parseFloat(sp[2])+parseFloat(sp1[2]);
						 N[4]=parseFloat(sp[0]);
						 N[5]=parseFloat(sp[1]);
						 N[6]=parseFloat(sp[2]);
						 N[7]=parseFloat(sp1[0]);
						 N[8]=parseFloat(sp1[1]);
						 N[9]=parseFloat(sp1[2]);
						 N[10]=parseFloat(sp[2])+parseFloat(sp1[0]);		
						 
						 Mi[0]=Jczq_hh_t.NzeroMin(sp[0],sp[1],sp[2]);
						 Mi[1]=Jczq_hh_t.NzeroMin(sp1[0],sp1[1],sp1[2]);
						 var  MIN_w=Jczq_hh_t.NzeroMin(Mi[0],Mi[1],"9999");
						 
						 var  MAX_w=N.sort(sortNumber)[10];						
					}else if($(o).attr("close") =='-2' || $(o).attr("close") =='-3' || $(o).attr("close") =='-4' || $(o).attr("close") =='-5'|| $(o).attr("close") =='-6'|| $(o).attr("close") =='-7'){
						var N = new Array();	
						var Mi=new Array();
						 N[0]=parseFloat(sp[0])+parseFloat(sp1[0]);
						 N[1]=parseFloat(sp[0])+parseFloat(sp1[1]);
						 N[2]=parseFloat(sp[1])+parseFloat(sp1[2]);
						 N[3]=parseFloat(sp[2])+parseFloat(sp1[2]);
						 N[4]=parseFloat(sp[0]);
						 N[5]=parseFloat(sp[1]);
						 N[6]=parseFloat(sp[2]);
						 N[7]=parseFloat(sp1[0]);
						 N[8]=parseFloat(sp1[1]);
						 N[9]=parseFloat(sp1[2]);
						 N[10]=parseFloat(sp[0])+parseFloat(sp1[2]);	
						 
						 Mi[0]=Jczq_hh_t.NzeroMin(sp[0],sp[1],sp[2]);
						 Mi[1]=Jczq_hh_t.NzeroMin(sp1[0],sp1[1],sp1[2]);
						 var  MIN_w=Jczq_hh_t.NzeroMin(Mi[0],Mi[1],"9999");
						 
						 var  MAX_w=N.sort(sortNumber)[10];													
					}
					
					
				 
	
					sp3 = [].slice.call($(o).find('div:eq(1)').find('.cur')).map(function(t){//让分
					      var xo = $(t).find('cite').html();
					      xo = !!parseInt(xo) && xo || '1';
					      return xo;
					     });
					     sp4 = [].slice.call($(o).find('div:eq(2)').find('.cur')).map(function(t){//猜总分
					      var xo = $(t).find('cite').html();
					      xo = !!parseInt(xo) && xo || '1';
					      return xo;
					     });

					
					
			//		alert("Max        " +N.sort(sortNumber)[9]);
			//alert("sp   "  + sp);
					//alert("sp1   "+sp1);
					//sp_max = (sp.length)?Count.division(sp,'true'):0;
					//sp1_max = (sp1.length)?Count.division(sp1,'true'):0;
					sp3_min = (sp3.length)?Count.division(sp3):0;
					sp4_min = (sp4.length)?Count.division(sp4):0;
					if(!sp3_min || !sp4_min){
						sumi = !!sp3_min && sp3_min || sp4_min;
					}else{
						sumi=Math.min(sp3_min,sp4_min);
					}
					//sum = parseFloat(sp_max)+parseFloat(sp1_max);
				//	alert("MAX    "+MAX_w);
				//	alert("MIN    "+sumi);
					division['max'] = MAX_w;
					
			//		alert(MIN_w);
					division['min'] = MIN_w;
			        return division;
			    });
				
			//	alert(data);
				var prix = Count.prix(data,n);
				$('.spfjj').show();
				var min = (prix.min*1*bs_).toFixed(2);
				var max = (prix.max*1*bs_).toFixed(2);
				prix = (min == max)?max:(min+'~'+max);
					
				
				$('.spfjj em').html(prix);
			}
		}
};
Jczq_hh_t.initial();//初始化