/*
 * use : 汽车贷款计算
 * author : tanyecheng
 */
function clearNoNum(obj,min,max)
{
	if(obj.value < min || obj.value > max){
		alert('请输入'+min+'到'+max+'之间的值');
	}else{
		obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符
		obj.value = obj.value.replace(/^\./g,"");  //验证第一个字符是数字而不是.
		obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的.
		obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
	}
}
//公用弹出层和加载层
var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);
	} else {
		$('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
		$('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
	}
};
/**var remove_alert = function () {
	$('.alertBox').remove();
};*/

var TYC = {};
TYC.CarLoan = (function(){
	var init = function(){
		//load();
		bindEvent();
		year_wrap($('.year_wrap li').eq(2));
		computeRate($('.year_wrap li:eq(2)').attr('data').split('_'));
	};
	var compute = function(){
		var lm = $('#loanMoney').val();//本金
		var ly = $('#loanYear').attr('data-value');//年限
		var lr = $('#loanRate').attr('data-value');//年利率
		var pm = $('#payMethod').attr('data-value');//还款方式
		if(lm < 1 || lm > 9999){
			alert('贷款金额范围1万~9999万');
			return false;
		}
		var mi = ((lr/100)/12);//月利率
		lm = lm * 10000;
		var repayment,interest;
		if(pm == 0){//等额本息
			repayment = (lm * mi * Math.pow( (1 + mi),(ly*12))) / (Math.pow((1 + mi),(ly*12))-1);//月供
			interest = repayment * ly * 12 - lm;//总利息
			$('#repayment').prev().text("月供：");
			$('#decline').hide();
		}else if(pm == 1){//等额本金
			mp = lm / (ly*12);//每月还款本金
			ml = lm * mi;//首月利息
			var decline = mp * mi;//每月递减
			repayment = mp + ml;//首月月供
			interest = (lm * mi / 2) * (ly*12+1);//总利息
			$('#repayment').prev().text("首月月供：");
			$('#decline').show().children('cite').text(decline.toFixed(2));
		}
		$('#repayment').text(repayment.toFixed(2));
		$('#interest').text(interest.toFixed(2));
		$('.txt-money').show();
	};
	var computeRate = function(disc){
		var rebate = [0.7,0.8,0.83,0.85,0.88,0.9,0.95,1.1,1.2];
		$('#rebate li').each(function(i, v){
			var rate = Math.round(disc[1]*rebate[i]*100)/100;
			$(v).html(function(){
				return arguments[1].replace(/^(.*（).*(）)/, '$1'+rate+'%$2');
			}).data('data', rate);
		});
		$('#rebate li').removeClass('cur');
		$('.prompt').next().addClass('cur');
	};
	var year_wrap = function(current){
		var disc = current.attr('data').split('_');
		if(disc[1] != $('.year_wrap li[class="cur"]').attr('data').split('_')[1]){//若当前选择年限的利率和上一次利率不同
			computeRate(disc);
		}
		$('#loanRate').html(disc[1]+'%').attr('data-value',disc[1]);
		current.addClass('cur').siblings().removeClass('cur');
		$('#loanYear').html(disc[0] >= 1 ? disc[0]+'年' : '6个月').attr('data-value',disc[0]);
		$('.prompt i').html(disc[1]);//商贷利率层——"提示"
		$('.prompt').next().data('data', disc[1]).children('i').html(disc[1]);//商贷利率层——无折扣
	};
	var rate_wrap = function(current){
		$('.rate_wrap li').removeClass('cur');
		current.addClass('cur');
		if(current.is('.prompt')){
			return false;
		//}else if($(this).index() == $('#rebate').next().index()){//若当前点击li的索引位置是“其他”
		}else if(current.text() == '其他'){
			$('.dk-wrap').slideUp();
			$('.other_wrap').slideDown();
			return false;//renturn 阻止执行到后序代码将遮罩层关闭
		}else{
			$('#loanRate').html(current.data('data')+'%').attr('data-value',current.data('data'));
		}
	};
	var bindEvent = function(){
		//贷款年限
		$('#loanYear').on('touchstart mousedown',function(e){
			e.preventDefault(); // 阻止浏览器默认行为
			$('.mask').fadeIn();
			$('.year_wrap').slideDown();
		});
		//商贷利率
		$('#loanRate').on('touchstart mousedown',function(e){
			e.preventDefault(); // 阻止浏览器默认行为
			$('.mask').fadeIn();
			$('.rate_wrap').slideDown();
		});
		//还款方式
		$('#payMethod').on('touchstart mousedown',function(e){
			e.preventDefault(); // 阻止浏览器默认行为
			$('.mask').fadeIn();
			$('.method_wrap').slideDown();
		});
		
		//选择选项
		$('.dk-wrap li').on('touchstart mousedown',function(e){
			e.preventDefault(); // 阻止浏览器默认行为
			var parent = $(this).parent().parent();
			//贷款年限	year_wrap
			if(parent.is('.year_wrap')){year_wrap($(this));}
			//商贷利率	rate_wrap
			if(parent.is('.rate_wrap') || parent.parent().is('.rate_wrap')){rate_wrap($(this));}
			//还款方式	method_wrap
			if(parent.is('.method_wrap')){
				$(this).addClass('cur').siblings().removeClass('cur');
				$('#payMethod').html($(this).html()).attr('data-value',$(this).index());
			}
			$('.mask').fadeOut();
			$('.dk-wrap').slideUp();
		});
		$('.mask').on('touchstart mousedown',function(e){
			e.preventDefault(); // 阻止浏览器默认行为
			$('.mask').fadeOut();
			$('.dk-wrap').slideUp();
		});
		//其他-层关闭
		$('.other_wrap i').on('touchstart mousedown',function(e){
			e.preventDefault(); // 阻止浏览器默认行为
			$('.mask').fadeOut();
			$('.other_wrap').slideUp();
		});
		//其他-层确定
		$('.other_wrap button').click(function(){
			var other = $('.other_wrap input').val();
			if(other < 1 || other > 20){
				alert("请输入1~20之间的利率");
				return false;
			}else{
				$('#loanRate').html(other+'%').attr('data-value',other);
			}
			$('.mask').fadeOut();
			$('.other_wrap').slideUp();
		});
		//计算
		$('#btnCal').click(function(){
			$(this).addClass('cur');
			setTimeout(function(){
				$(this).removeClass('cur');
			},100);
			compute();
		});
	};
	return{init:init};
})();
$(function(){
	TYC.CarLoan.init();
});