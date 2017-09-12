/*
 * Author: weige
 * Date: 2014-7-17
 */
var re_bs = '500';
var price = 2;//单注
var exhz = {//二星和值 对面注数
		'0': 1,'1': 1,'2': 2,'3': 2,'4': 3,'5': 3,'6': 4,'7': 4,'8': 5,'9': 5,'10': 5,'11': 4,'12': 4,'13': 3,'14': 3,'15': 2,'16': 2,'17': 1,'18': 1
};
var Jxssc_t = {
		local : function(){
			var jxsscSelectNum = localStorage.getItem('jxsscSelectNum');//临时
			var jxssc_PollNum = localStorage.getItem('jxssc_PollNum');//永久
			if(!jxssc_PollNum){jxssc_PollNum = (jxsscSelectNum?jxsscSelectNum:'');}else{jxssc_PollNum += (jxsscSelectNum?';'+jxsscSelectNum:'');}
			
			if(jxssc_PollNum){
				var a = jxssc_PollNum.split(';');
				var h_ = '';
				for(var n=0; n<a.length; n++){
					n_ = a[n].split('_');
					h_ += '<p v=\''+n_[2]+'\' w=\''+n_[1]+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+n_[0]+'</span><b>'+n_[1]+' &nbsp;共'+n_[2]+'注'+parseInt(n_[2])*2+'元</b></span></p>';
				}
				$('#code_list').html(h_);
				
			}
			
			if(jxssc_PollNum.indexOf('五星')!=-1){
				re_bs = '10';
			}else if(jxssc_PollNum.indexOf('三星直选')!=-1){
				re_bs = '100';
			}
			!!jxssc_PollNum && localStorage.setItem('jxssc_PollNum',jxssc_PollNum);
			localStorage.removeItem('jxsscSelectNum');
			$('#qs_').val('1');$('#bs_').val('1');
			Jxssc_t.count_();
			
			$("#code_list p cite.errorBg").bind('click',function(){//delete line
				$(this).parent().animate({left:'-1600px'},300,function(){
					$(this).remove();
					Jxssc_t.count_();//更新注数
					Jxssc_t.local_();//更新localStorage
				});
			});
//			$("#code_list p span.revise_ww").bind('click',function(){//revise line暂时弃掉修改功能
//				var t = $(this).find('span').html()+'_'+$(this).parent().attr('w')+'_'+$(this).parent().attr('v');
//				localStorage.setItem('jxsscSelectNum',t);
//				$(this).parent().remove();
//				Jxssc_t.local_(true);
//			});
		},
		initial	:function(){
			Jxssc_t.local();
			Jxssc_t.bind();
		},
		count_ :function(){
			var zs = 0;
			if($('#code_list p')){
				$('#code_list p').each(function(){
					zs += parseInt($(this).attr('v'));
				});
			}
			var bs = parseInt($('#bs_').val());
			var qs = parseInt($('#qs_').val());
			Jxssc_t.count_finally(zs,qs,bs);
		},
		bind :function(){
			$('#qs_').keyup(function(){//最大期数155
				this.value=this.value.replace(/\D/g,'');
				var qs = parseInt($(this).val());
				if($(this).val() == ''){
					qs = 1;
				}else if($(this).val() == 0){
					$(this).val('');
					qs = 1;
				}
				var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
				var bs = parseInt($('#bs_').val());
				Jxssc_t.count_finally(zs,qs,bs);
				if(zs>0 && qs>1){
					$('.zjStop').fadeIn();
				}else{
					$('.zjStop').fadeOut();
				}
				if(qs>155){
					D.alert('最大可买期数155',function(){
						qs = 155;
						$('#qs_').val(qs);
						Jxssc_t.count_finally(zs,qs,bs);
					});
				}
			});
			$('#qs_').blur(function(){
				var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
				(zs<=0 || parseInt($(this).val())<=1 || $(this).val() == '') && $('.zjStop').fadeOut();
				if($(this).val() == ''){
					var qs = 1;
					$(this).val(qs);
					var bs = parseInt($('#bs_').val());
					Jxssc_t.count_finally(zs,qs,bs);
				}
			});
			
			$('#bs_').keyup(function(){//最大倍数500
				this.value=this.value.replace(/\D/g,'');
				var bs = parseInt($(this).val());
				if($(this).val() == ''){
					bs = 1;
				}else if($(this).val() == 0){
					$(this).val('');
					bs = 1;
				}
				var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
				var qs = parseInt($('#qs_').val());
				Jxssc_t.count_finally(zs,qs,bs);
				if(bs>re_bs){
					D.alert('最大可投倍数'+re_bs,function(){
						bs = re_bs;
						$('#bs_').val(bs);
						Jxssc_t.count_finally(zs,qs,bs);
					});
				}
			});
			$('#bs_').blur(function(){//最大倍数500
				if($(this).val() == ''){
					var bs = 1;
					$(this).val(bs);
					var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
					var qs = parseInt($('#qs_').val());
					Jxssc_t.count_finally(zs,qs,bs);
				}
			});
			$('#zj_stop').click(function(){
				$(this).toggleClass('nocheck');
			});
			$('#random_').bind('click',function(){
				var t = '';
				if($('#code_list').html()){
					t = $('#code_list p').length;
					t = $('#code_list p').eq(t-1).attr('w');
				}
				jixuan_(t);
			});
			$('#isOk_').click(function(){
					var q,b,z,j,bk,zflag,playId;
					
					q = parseInt($('#qs_').val());
					b = parseInt($('#bs_').val());
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
						
						/*
						 * notes:  注数
						 * multiple:     倍数
						 * issue:     期数
						 * countMoney: 总金额
						 * pattern:     0自购  2追号
						 * zflag:  0中奖不停止   1中奖停止 
						 * gid  :  彩种id
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
		jz:function(n,m){
			for(var k in n){
				 if(k == m){
					 return n[k];
				 }
			};
		},
		local_ :function(n){
			var l = '';
			$('#code_list p').each(function(){
				l += $(this).find('span.revise_ww span').html()+'_'+$(this).attr('w')+'_'+$(this).attr('v')+';';
			});
			
			l = l.substring(0,l.length-1);
			if(!!l){localStorage.setItem('jxssc_PollNum',l);}else{localStorage.removeItem('jxssc_PollNum');}
			
			if(l.indexOf('五星')!=-1){
				re_bs = '10';
				if(parseInt($('#bs_').val()) > 10){
					$('#bs_').val('10');
					var qs = parseInt($('#qs_').val());
					var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
					Jxssc_t.count_finally(zs,qs,re_bs);
				}
			}else if(l.indexOf('三星直选')!=-1){
				re_bs = '100';
				if(parseInt($('#bs_').val()) > 100){
					$('#bs_').val('100');
					var qs = parseInt($('#qs_').val());
					var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
					Jxssc_t.count_finally(zs,qs,re_bs);
				}
			}else{
				re_bs = '500';
			}
			n && window.location.replace('/jxssc/');
		},
		count_finally :function(z,q,b){//注数 期数 倍数
			var j = z*q*b*price;//总金额
			$('#zs_list').find('cite:eq(0)').html(z);
			$('#zs_list').find('cite:eq(1)').html(j);
		}
		
};

function jixuan_(t){
	var b ,h_='', a1, b1, c1, d1, e1, v=1;
	
	if(!t){
		var op_ = ['大小单双','一星直选','二星直选','三星直选','五星直选','五星通选','二星组选','三星组三','三星组六','二星和值'];
		t = op_[Random(10)[5]-1];
	}
	var kd_ = '-'+$(window).width()+'px';
	if(t == '大小单双'){
		var hz_ = ['大','小','单','双'];
		h_ = Random(4);
		h_ = hz_[h_[0]-1]+' '+hz_[h_[2]-1];
	}else if(t == '一星直选'){
		h_ = Random(10)[8]-1;
	}else if(t == '二星直选'){
		a1 = Random(10);
		b1 = Random(10);
		h_ = (a1[8]-1) +' '+ (b1[3]-1);
	}else if(t == '三星直选'){
		a1 = Random(10);
		b1 = Random(10);
		c1 = Random(10);
		h_ = (a1[8]-1) +' '+ (b1[3]-1) +' '+ (c1[5]-1);
	}else if(t == '五星直选' || t == '五星通选'){
		a1 = Random(10);
		b1 = Random(10);
		c1 = Random(10);
		d1 = Random(10);
		e1 = Random(10);
		h_ = (a1[8]-1) +' '+ (b1[3]-1) +' '+ (c1[5]-1) +' '+ (d1[2]-1) +' '+ (e1[6]-1);
	}else if(t == '二星组选'){
		a1 = Random(10);
		h_ = (a1[3]-1)+' '+(a1[8]-1);
	}else if(t == '三星组三'){//2
		a1 = Random(10);
		h_ = (a1[3]-1)+' '+(a1[8]-1);
		v = 2;
	}else if(t == '三星组六'){
		a1 = Random(10);
		h_ = (a1[3]-1)+' '+(a1[8]-1)+' '+(a1[5]-1);
	}else if(t == '二星和值'){
		h_ = Random(18)[8]-1;
		v = Jxssc_t.jz(exhz,h_);
	}
	b = h_ +'_'+t+'_1'; 
	h_ = '<p v=\''+v+'\' w=\''+t+'\' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>'+t+' &nbsp;共'+v+'注'+2*v+'元</b></span></p>';
	$('#code_list').append(h_);
	
	$('#code_list p').eq($('#code_list p').length-1).animate({left: 0}, 300);
	
	var jxssc_PollNum = localStorage.getItem('jxssc_PollNum');
	if(jxssc_PollNum){
		jxssc_PollNum += (b?';'+b:'');
	}else{
		jxssc_PollNum = (b?b:'');
	}
	
	localStorage.setItem('jxssc_PollNum',jxssc_PollNum);
	
	Jxssc_t.count_();//更新注数
	
	$("#code_list p cite.errorBg").bind('click',function(){//delete line
		$(this).parent().animate({left:'-1600px'},300,function(){
			$(this).remove();
			Jxssc_t.count_();//更新注数
			Jxssc_t.local_();//更新localStorage
		});
	});
//	$("#code_list p span.revise_ww").bind('click',function(){//revise line
//		var t = $(this).find('span').html()+'_'+$(this).parent().attr('w')+'_'+$(this).parent().attr('v');
//		localStorage.setItem('jxsscSelectNum',t);
//		$(this).parent().remove();
//		Jxssc_t.local_(true);
//	});
}
Jxssc_t.initial();