/*
* Author: weige
* Date : 2014-04-28
*/ 
(function(){
	$(".zhuceOpen2").bind("click",function(){
		$(this).parent(".relative").find('input').attr("type","text");
		$(this).hide();
		$(this).parent(".relative").find('.zhuceOpen').show();
	});
	$(".zhuceOpen").bind("click",function(){
		$(this).parent(".relative").find('input').attr("type","password");
		$(this).hide();
		$(this).parent(".relative").find('.zhuceOpen2').show();
	});
	$('.pdLfrt09 input').keyup(function(){
		this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'');
	});
	
	
})();
function changepass(){
	var initp = $.trim($('#initp').val());
	var newp = $.trim($('#newp').val());
	var newpr = $.trim($('#newpr').val());
	if(initp == ''){
		D.alert('请输入原密码');
	}else if(initp.length >20 || initp.length <4){
		D.alert('原密码长度4-20个字符');
	}else if(newp == ''){
		D.alert('请输入新密码');
	}else if(newp.length >20 || newp.length <4){
		D.alert('新密码长度4-20个字符');
	}else if(newpr == ''){
		D.alert('请重复输入新密码');
	}else if(newp != newpr){
		D.alert('两次新密码输入不一样');
	}else{
		var data = {
				newValue:newp,
				upwd:initp
		};
		$.ajax({
			url:'/user/modify.go?flag=2',
			type:'POST',
			data:data,
			success:function(xml){
				var R = $(xml).find('Resp');
				var c = R.attr('code');
				var d = R.attr('desc');
				if(c == 0){
					D.alert(d,function(){
						window.location.href='/useraccount/';
					});
				}else{
					D.alert(d.replace('老','原'));
					
				}
			}
		});
	}
}