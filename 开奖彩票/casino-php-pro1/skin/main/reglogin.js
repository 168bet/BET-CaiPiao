function registerBeforSubmit(){
	var type=$('[name=type]:checked',this).val();
	if(!this.username.value) throw('没有输入用户名');
	if(!/^\w{4,16}$/.test(this.username.value)) throw('用户名由4到16位的字母、数字及下划线组成');
	if(!this.password.value) throw('请输入密码');
	if(this.password.value.length<6) throw('密码至少6位');
	if(!this.cpasswd.value) throw('请输入确认密码');
	if(this.cpasswd.value!=this.password.value) throw('两次输入密码不一样');
}
function registerSubmit(err,data){
	if(err){
		alert(err);
	}else{
		alert(data);
		location='/index.php/user/login';
	}
	$("#vcode").trigger("click");
}
function userBeforeLogin(){
	var u=this.username.value;
	var v=this.vcode.value;
	if(!u || u=='帐号'){alert("请输入用户名");}
	else if(!v || v=='验证码'){alert("请输入验证码");}
	else{return true;}
	return false;
}
function userLogin(err, data){
	if(err){
		alert(err);
		$('input[name=vcode]')
		.val('')
		.closest('div')
		.find('.yzmNum img')
		.click();
		
	}else{
		location='/index.php/user/loginto';
	}
}
function userBeforLoginto(){
        var u=this.username.value;
	var p=this.password.value;
	if(!u || u=='帐号'){alert("请输入用户名");}
	else if(!p || p=='xx@x@x.x'){alert("请输入密码");}
	else{return true;}
	return false;
}
function userLoginto(err, data){
	if(err){
		alert(err);
		
	}else{
		location='/';
	}
}