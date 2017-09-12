/*
 * Author: weige
 * Date: 2014-6-26
 */

var price = 2;//单注

var Ank3_t = {
		local: function(){
			var ahk3SelectNum = localStorage.getItem('ahk3SelectNum');//临时
			var ahk3_PollNum = localStorage.getItem('ahk3_PollNum');//永久
			if(ahk3_PollNum){ahk3_PollNum += (ahk3SelectNum?';'+ahk3SelectNum:'');}else{ahk3_PollNum = (ahk3SelectNum?ahk3SelectNum:'');}
			if(ahk3_PollNum){
				var a = ahk3_PollNum.split(';');
				var h_ = '';
				for(var n=0; n<a.length; n++){
					n_ = a[n].split('_');
					h_ += '<p v=\''+n_[2]+'\' w=\''+n_[1]+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+n_[0]+'</span><b>'+n_[1]+' &nbsp;共'+n_[2]+'注'+parseInt(n_[2])*2+'元</b></span></p>';
				}
				$('#code_list').html(h_);
			}
			localStorage.setItem('ahk3_PollNum',ahk3_PollNum);
			localStorage.removeItem('ahk3SelectNum');
			Ank3_t.count_();
			$("#code_list p cite.errorBg").bind('click',function(){//delete line
				$(this).parent().animate({left:'-1600px'},300,function(){
					$(this).remove();
					Ank3_t.count_();//更新注数
					Ank3_t.local_();//更新localStorage
				});
			});
//			$("#code_list p span.revise_ww").bind('click',function(){//revise line
//				var t = $(this).find('span').html()+'_'+$(this).parent().attr('w')+'_'+$(this).parent().attr('v');
//				localStorage.setItem('ahk3SelectNum',t);
//				$(this).parent().remove();
//				Ank3_t.local_(true);
//			});
		},
		initial	:function(){
			$('#qs_').val('1');
			$('#bs_').val('1');
			Ank3_t.local();Ank3_t.bind();
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
			Ank3_t.count_finally(zs,qs,bs);
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
				Ank3_t.count_finally(zs,qs,bs);
				if(zs>0 && qs>1){
					$('.zjStop').fadeIn();
				}else{
					$('.zjStop').fadeOut();
				}
				if(qs>155){
					D.alert('最大可买期数155',function(){
						qs = 155;
						$('#qs_').val(qs);
						Ank3_t.count_finally(zs,qs,bs);
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
					Ank3_t.count_finally(zs,qs,bs);
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
				Ank3_t.count_finally(zs,qs,bs);
				if(bs>500){
					D.alert('最大可投倍数500',function(){
						bs = 500;
						$('#bs_').val(bs);
						Ank3_t.count_finally(zs,qs,bs);
					});
				}
			});
			$('#bs_').blur(function(){//最大倍数500
				if($(this).val() == ''){
					var bs = 1;
					$(this).val(bs);
					var zs = parseInt($('#zs_list').find('cite:eq(0)').html());
					var qs = parseInt($('#qs_').val());
					Ank3_t.count_finally(zs,qs,bs);
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
		local_ :function(n){
			var l = '';
			$('#code_list p').each(function(){
				l += $(this).find('span.revise_ww span').html()+'_'+$(this).attr('w')+'_'+$(this).attr('v')+';';
			});
			l = l.substring(0,l.length-1);
			if(!!l){localStorage.setItem('ahk3_PollNum',l);}else{localStorage.removeItem('ahk3_PollNum');}
			n && window.location.replace('/ahk3/');
		},
		count_finally :function(z,q,b){//注数 期数 倍数
			var j = z*q*b*price;//总金额
			$('#zs_list').find('cite:eq(0)').html(z);
			$('#zs_list').find('cite:eq(1)').html(j);
		}
		
};

function jixuan_(t){
	var b = '';
	var h_ = '';
	
	if(!t){
		var op_ = ['和值','三同号单选','二同号单选','三不同号','二不同号'];
		t = op_[Random(5)[3]-1];
	}
	var kd_ = '-'+$(window).width()+'px';
	if(t == '和值'){//hz
		var hz_ = [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
		h_ = hz_[Random(16)[0]-1];
		b = h_ +'_和值_1'; 
		h_ = '<p v=\'1\' w=\'和值\' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>和值 &nbsp;共1注2元</b></span></p>';
		$('#code_list').append(h_);
	}else if(t == '三同号单选' || t == '三同号通选'){//sth
		var sth_ = ['三同号单选','三同号通选'];
		h_ = sth_[Random(2)[0]-1];
//		if(h_ == '三同号通选'){
//			b = '111 222 333 444 555 666';
//			h_ = '<p v=\'1\' w=\'三同号通选\' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+b+'</span><b>三同号通选 &nbsp;共1注2元</b></span></p>';
//			b += '_三同号通选_1'; 
//		}else{
			var sthdx_ = [111,222,333,444,555,666];
			h_ = sthdx_[Random(6)[0]-1];
			b = h_ +'_三同号单选_1';
			h_ = '<p v=\'1\' w=\'三同号单选\' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>三同号单选 &nbsp;共1注2元</b></span></p>';
//		}
		$('#code_list').append(h_);
	}else if(t == '二同号单选' || t == '二同号复选'){//eth
		var eth_ = ['二同号单选','二同号复选'];
		h_ = eth_[Random(2)[0]-1];
		if(h_ == '二同号单选'){
			var ethdx_ = [1,2,3,4,5,6];
			var n = ethdx_[Random(6)[0]-1];//第一排
			var m = ethdx_[Random(6)[3]-1];//第二排
			h_ = n+''+n+'|'+m;
			b = h_+'_二同号单选_1';
			h_ = '<p v=\'1\' w=\'二同号单选\' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>二同号单选 &nbsp;共1注2元</b></span></p>';
		}else{
			var ethdx_ = [11,22,33,44,55,66];
			h_ = ethdx_[Random(6)[0]-1]+'*';
			b = h_+'_二同号复选_1';
			h_ = '<p v=\'1\' w=\'二同号复选\' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>二同号复选 &nbsp;共1注2元</b></span></p>';
		}
		$('#code_list').append(h_);
	}else if(t == '三不同号' || t == '三连号通选'){//sbth
		var sbth_ = ['三不同号','三连号通选'];
		h_ = sbth_[Random(2)[0]-1];
	//	if(h_ == '三连号通选'){
		//	b = '123 234 345 456';
		//	h_ = '<p v=\'1\' w=\'三连号通选\' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+b+'</span><b>三连号通选 &nbsp;共1注2元</b></span></p>';
		//	b += '_三连号通选_1'; 
	//	}else{
			var sbth_ = [1,2,3,4,5,6];
			var n=0;
			var m=0;
			var k=0;
			while(!(n!=m &&  m!=k  && n!=k)){
			 n = sbth_[Random(6)[0]-1];
			 m = sbth_[Random(6)[2]-1];
			 k = sbth_[Random(6)[4]-1];
			};
			
			h_ = n +' '+ m +' '+ k;
			b = h_+'_三不同号_1';
			h_ = '<p v=\'1\' w=\'三不同号\' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>三不同号 &nbsp;共1注2元</b></span></p>';
		//}
		
		$('#code_list').append(h_);
	}else if(t == '二不同号'){//ebth
		var ebth_ = [1,2,3,4,5,6];
		
		var n=0;
		var m=0;
		while(n==m){
			var n = ebth_[Random(6)[0]-1];
			var m = ebth_[Random(6)[3]-1];
		}
		h_ = n +' '+ m;
		b = h_+'_二不同号_1';
		h_ = '<p v=\'1\' w=\'二不同号\' style=\'left:'+kd_+'\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>'+h_+'</span><b>二不同号 &nbsp;共1注2元</b></span></p>';
		$('#code_list').append(h_);
	}
	
	$('#code_list p').eq($('#code_list p').length-1).animate({left: 0}, 300);
	
	var ahk3_PollNum = localStorage.getItem('ahk3_PollNum');
	if(ahk3_PollNum){
		ahk3_PollNum += (b?';'+b:'');
	}else{
		ahk3_PollNum = (b?b:'');
	}
	
	localStorage.setItem('ahk3_PollNum',ahk3_PollNum);
	
	Ank3_t.count_();//更新注数
	
	$("#code_list p cite.errorBg").bind('click',function(){//delete line
		$(this).parent().animate({left:'-1600px'},300,function(){
			$(this).remove();
			Ank3_t.count_();//更新注数
			Ank3_t.local_();//更新localStorage
		});
	});
}
Ank3_t.initial();