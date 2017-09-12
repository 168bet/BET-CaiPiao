String.prototype.trim = function() {
				return this.replace(/(^\s*)|(\s*$)/g, '');
			}
function loadbg(){
	var imgstr='';
	for (var c = 0; c < 1; c++) {
		imgstr += "<img src='" + LoginPic[c] + "' />"
	}
	$('#bg').html(imgstr);
	$('#img').html('<img src=/yzm.php  />');
}
function rvcode(){
	$('#img').html('<img src=/yzm.php?'+escape(new Date())+' />');	
} 

function validateForm() {//表单验证准则 
	var form = document.forms['login_form'];
	var name = form.loginName.value.trim();
	form.loginName.value = name;
	var password = form.loginPwd.value.trim();
	var vcode = form.VerifyCode.value.trim();
	form.loginPwd.value = password;
	if (!(/^[a-z0-9A-Z][a-z0-9A-Z_]{0,11}$/.test(name))) {
		alert('账号由1-12位英文字母、数字、下划线组成，且第一位不能是下划线');
		form.loginName.focus();
		return false;
	}
	if (!(/^[0-9a-zA-Z]{5,16}$/.test(password))) {
		alert('密码由5-16位英文字母、数字字符组成');
		form.loginPwd.focus();
		return false;
	}
	if (vcode.length != 4) {
		alert('验证码由4位数字组成');
		form.VerifyCode.focus();
		return false;
	}
	if (!(/^\d{4}$/.test(vcode))) {
		alert('验证码由4位数字组成');
		form.VerifyCode.focus();
		return false;
	}
 
	return true;
}	 