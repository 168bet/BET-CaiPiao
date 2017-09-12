var openid = location.search.getParam('openid');
var tab = location.search.getParam('tab');
//openid = 'oxRU4uBixqb0xpCRl5loeE82C2VA'//戈多

$(function(){
	if(openid != '' && openid != undefined){
		localStorage.setItem("openid", openid);
	}else{
		openid = localStorage.getItem("openid");
	}
	if(tab != '' && tab != undefined){
		window.location.href='/word_weixin/'+tab+'/';
	}
	
	//隐藏微信右上角分享图标
	if(document.addEventListener){
		document.addEventListener('WeixinJSBridgeReady', sendMessage, false);  
	}else if(document.attachEvent){
		document.attachEvent('WeixinJSBridgeReady'   , sendMessage);	
		document.attachEvent('onWeixinJSBridgeReady' , sendMessage);  
	}
	
	
	$('#dbind a:eq(1) ,#invite3').click(function(){
		$('#dbind').hide();
		$('#invite3').hide();
	});
	
	$.ajax({
		url:'/wechat/queryDatas.go?func=activematch',
		type:'post',
		dataType:'xml',
		success:function(xml){
			var R = $(xml).find('Resp');
			var code = R.attr('code');
			var desc = R.attr('desc');
			if(code == "0"){
				
				$('#hao').click(function(){
					$.ajax({
						url:'/wechat/isBind.go',
						dataType:'xml',
						data:{
							openid:openid
						},
						type:'POST',
						success:function(xml){
							var R = $(xml).find('Resp');
							var code = R.attr('code');
							var desc = R.attr('desc');
							if(code == 0){
								var r= R.find('row');
								var bindstate = r.attr('bindstate');//0未绑定1已绑定
								if(bindstate == '0'){
									$('#dbind').css({left:'50%',top:'50%',marginLeft:'-8.75rem',marginTop:'-'+$('#dbind').height()/2+'px'});
									$('#dbind').show();
									$('#invite3').show();
								}else{
									window.location.href='/word_weixin/tyrant/index.html';
								}
							}else{
								WW.tx(desc);
							}
						}
					});
				});
				$('#9188_hao').click(function(){
					window.location.href='/word_weixin/free/';
				});
				$('#hd').click(function(){
					window.location.href='/word_weixin/event.html';
				});
			}else if(code == "1000"){
				$('#9188_hao ,#hao ,#hd').click(function(){
					WW.tx('该场球赛活动已结束，敬请期待下场!');
				});
			}else{
				$('#9188_hao ,#hao ,#hd').click(function(){
					WW.tx(desc);
				});
			}
		}
	});
	
});

