
(function(){
	if(document.addEventListener){
		document.addEventListener('WeixinJSBridgeReady', sendMessage, false);  
	}else if(document.attachEvent){
		document.attachEvent('WeixinJSBridgeReady'   , sendMessage);	
		document.attachEvent('onWeixinJSBridgeReady' , sendMessage);  
	}
	
	
	$('#step1').bind('click',function(){
		var mphone = $('#phone').val();
		if(mphone == ''){
			WW.tx('请先输入手机号');
		}else{
			step_one(mphone);
		}
		
	});
	function step_one(mphone){
		$.ajax({
			url:'/wechat/isExistUid.go',
			dataType:'xml',
			data:{
				mphone:mphone
			},
			type:'POST',
			success:function(xml){
				var R = $(xml).find('Resp');
				var code = R.attr('code');
				var desc = R.attr('desc');
				if(code == 0){
					var r = R.find('row');
					var b = r.attr('bindstate');//是否绑定1绑定0未绑定
					var m = r.attr('mobilephone');//用户手机号
					
					localStorage.setItem("mphone", m);
					if(b == '1'){
						window.location.href='/word_weixin/myrecord/accountbind.html';
					}else{
						window.location.href='/word_weixin/myrecord/telbind2.html';
					}
				}else{
					WW.tx(desc);
				}
			}
		});
		
		
	}
	
})();
