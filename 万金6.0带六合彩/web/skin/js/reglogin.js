function registerBeforSubmit(){
	var type=$('[name=type]:checked',this).val();
	if(!this.username.value) throw('没有输入用户名');
	if(!/^\w{4,16}$/.test(this.username.value)) throw('用户名由4到16位的字母、数字及下划线组成');
	if(!this.password.value) throw('请输入密码');
	if(this.password.value.length<6) throw('密码至少6位');
	if(!this.cpasswd.value) throw('请输入确认密码');
	if(this.cpasswd.value!=this.password.value) throw('两次输入密码不一样');
	if(!this.qq.value) throw('请输入QQ号做为以后找回密码的重要依据,请认真填写!');
	if(this.qq.value.length<5) throw('QQ号至少5位');
}	
function registerSubmit(err,data){
	if(err){
		alert(err);
		$("#vcode").trigger("click");
	}else{
		alert(data);
		location='/index.php/user/login';
	}
}
//}}}
//{{{ 登录相关
function userBeforeLogin(){
	var u=this.username.value;
	var p=this.password.value;
	var v=this.vcode.value;
	if(!u){alert("请输入用户名");}
	else if(!p){alert("请输入密码");}
	else if(!v){alert("请输入验证码");}
	else{return true;}
	return false;
}
function userLogin(err, data){
	if(err){
		alert(err);
		$('input[name=vcode]')
		.val('')
		.closest('div')
		.find('img')
		.click();
	}else{
		location='/';
	}
}
//}}}
