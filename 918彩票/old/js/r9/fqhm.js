/*
*Author: weige
*Date: 2014.7.8
*/
var zs_ = decodeURIComponent(CP.Util.getParaHash("zs"));
var bs_ = decodeURIComponent(CP.Util.getParaHash("bs"));
var m_ = decodeURIComponent(CP.Util.getParaHash("money"));
var gid_ = decodeURIComponent(CP.Util.getParaHash("gid"));
var pid_ = decodeURIComponent(CP.Util.getParaHash("pid"));
var R9_hm = {
		initail: function(zs,bs,m,gid){
			jQuery('#detail cite:eq(0)').html(zs);
			jQuery('#detail cite:eq(1)').html(bs);
			jQuery('#detail cite:eq(2)').html(m);
			document.title = $_sys.getlotname(gid_)+'-发起合买';
			$('.buyHeader h1').html($_sys.getlotname(gid_)+'-发起合买');
			
			$("#rg").val(Math.ceil(m*0.05));
			$("#rg_bl").html(Math.floor(($('#rg').val()/m)*10000)/100+"%");
			$("#bd").attr('disabled',false);
			$("#bd").val('0');
			$("#bd_bl").html('0%');
			
			R9_hm.my_();//认购保底多少
			R9_hm.bind(parseInt(m));
		},
		bind: function(m){//m 方案总金额
			$('#ratio li,#isPublic li').Touch(function(){//提成   是否公开 点击事件
				!$(this).hasClass('cur') && $(this).toggleClass('cur');
				$(this).siblings().removeClass('cur');
			});
			
			$('#rg').keyup(function(){//认购 
				var bd_ = parseInt($('#bd').val());
				
				if($(this).val() >= m){
					$(this).val(m);
					$("#rg_bl").html("100%");
				}else{
					if($(this).val() == ''){
						$("#rg_bl").html("0%");
					}else{
						$("#rg_bl").html(Math.floor((parseInt($('#rg').val())/m)*10000)/100+"%");
					}
				}
				
				if(!$("#chk").hasClass("nocheck") || parseInt($(this).val())+bd_>m){
					if($(this).val() == ''){
						$('#bd').val(m);
						$("#bd_bl").html('100%');
					}else{
						$('#bd').val(m-parseInt($(this).val()));
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/m)*10000)/100+"%");
					}
				}
				R9_hm.my_();
			});
			$('#rg').change(function(){//认购 小于5% 提示
				var t = $(this).val();
				if(t == ''){
					t=0;
				}
				if(parseInt(t) < m*0.05){
					D.tx('认购金额不能小于5%');
					
					$(this).val(Math.ceil(m*0.05));
					$("#rg_bl").html(Math.floor((parseInt($("#rg").val())/m)*10000)/100+"%");
				}
				if(!$("#chk").hasClass("nocheck")){
					$('#bd').val(m-parseInt($(this).val()));
					$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/m)*10000)/100+"%");
				}
				R9_hm.my_();
			});
			$('#bd').keyup(function(){//保底 
				var rg_ = parseInt($('#rg').val());
				(parseInt($(this).val()) > m-rg_) && $(this).val(m-rg_);
				if($(this).val() == ''){
					$("#bd_bl").html("0%");
				}else{
					$(this).val(parseInt($(this).val()));
					$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/m)*10000)/100+"%");
				}
				
				R9_hm.my_();
			});
			$('#bd').change(function(){//保底等于空
				if($(this).val() == ''){
					$(this).val('0');
					$("#bd_bl").html("0%");
					R9_hm.my_();
				}
			});
			$('#chk').Touch(function(){
				var rg_ = parseInt($('#rg').val());
				$(this).toggleClass('nocheck');
				
				if(!$("#chk").hasClass("nocheck")){//全额保底
					$("#bd").attr('disabled',true);
					
					$("#bd").val(m-rg_);
					$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/m)*10000)/100+"%");
				}else{
					$("#bd").attr('disabled',false);
				}
				
				R9_hm.my_();
			});
			$('#my_').next().Touch(function(){
				var p = $('#isPublic li.cur').attr('v');
				var rg = $('#rg').val();
				var bd = $('#bd').val();
				var wrate = $('#ratio li.cur').attr('v');
				var desc = $('#desc').val();
				if(!desc){
					desc = '随缘！买彩票讲的是运气、缘分和坚持。';
				}
				location.href='#class=url&xo=trade/defrayal.html&notes='+zs_+'&multiple='+bs_+'&issue=1&isPublic='+p+'&countMoney='+m_+'&pattern=1&rg='+rg+'&bd='+bd+'&xyText='+desc+'&wrate='+wrate+'&gid='+gid_+'&pid='+pid_;
			});
		},
		my_: function(){
			var rg = $('#rg').val();
			var bd = $('#bd').val();
			var z = parseInt(rg)+parseInt(bd);			
			$('#my_ cite:eq(0)').html(rg);//认购
			$('#my_ cite:eq(1)').html(bd);//保底
			$('#my_ cite:eq(2)').html(z);//总金额
		}
}
$(function(){
	if(zs_ != '' && gid_ != '' && bs_ != ''){
		R9_hm.initail(zs_,bs_,m_,gid_);//初始化加载
	}else{
		history.go(-1);
	}
});
