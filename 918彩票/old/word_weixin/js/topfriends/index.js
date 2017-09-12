var openid = localStorage.getItem("openid");
//openid = 'oxRU4uNaBxtX41qP_cnNWH_hYnZo';


$(function(){
	if(document.addEventListener){
		document.addEventListener('WeixinJSBridgeReady', sendMessage, false);  
	}else if(document.attachEvent){
		document.attachEvent('WeixinJSBridgeReady'   , sendMessage);	
		document.attachEvent('onWeixinJSBridgeReady' , sendMessage);  
	}
	
	
	$('#title_tab li').bind('click',function(){
		if($(this).hasClass('cur')){
			return;
		}
		$('#rangking').html('');
		$('.loading').show();
		
		$(this).addClass('cur').siblings().removeClass('cur');
		WX.initial($(this).attr('w'));
	});
	
	
	WX.initial('teamlist');
});
var WX = {
		initial:function(cs){
			$.ajax({
				url:'/wechat/queryDatas.go',
				type:'POST',
				dataType:'xml',
				data:{
					func: cs,
					openid: openid
				},
				success:function(xml){
					$('.loading').hide();
					var R = $(xml).find('Resp');
					var code = R.attr('code');
					var desc = R.attr('desc');
					if(code == 0){
						var r = R.find('row');
						var html = '';
						r.each(function(aa){
							aa++;
							var copenid = $(this).attr('copenid');
							var cname = $(this).attr('cname');
							var headimg = $(this).attr('headimg');
							var iteamid = $(this).attr('iteamid');
							var joinnum = $(this).attr('joinnum');
							if(headimg == ''){
								headimg = '/word_weixin/img/WOYO.png';
							}
							if(cs == 'teamlist'){
								html +='<li onclick="weige(\''+copenid+','+iteamid+','+joinnum+'\')" class="'+(openid == copenid?"cur":"")+'">';
							}else{
								html +='<li class="'+(openid == copenid?"cur":"")+'">';
							}
							html +='<b>'+aa+'</b><span><em class="admiIco"><img src="'+headimg+'" /></em>'+cname+'</span>';
							if(cs == 'friendlist'){
								html +='<cite>'+$(this).attr('winmoney')+'元</cite></li>';
							}else if(cs == 'bosslist'){
								html +='<cite>'+$(this).attr('sendmoney')+'元</cite></li>';
							}else if(cs == 'teamlist'){
								html +='<cite>'+$(this).attr('teammoney')+'元</cite><i></i></li>';
							}
						});
						
						$('#rangking').html(html);
					}else{
						WW.tx(desc);
					}
				}
			});
		}
};
function weige(aaa){
	aaa= aaa.split(',');
	var copenid = aaa[0];
	var iteamid = aaa[1];
	var joinState = aaa[2];
	if(!copenid || !iteamid || !joinState ){
		return;
	}
	window.location.href='/word_weixin/free/success.html?teamid='+iteamid+'&openid='+openid+'&shareOpenId='+copenid+'&joinState='+joinState;
}