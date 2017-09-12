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
function doLogin(){
	if(validateForm()){
		var loginName = $('input[name=loginName]').val();
		var loginPwd = $('input[name=loginPwd]').val();
		var ValidateCode = $('input[name=ValidateCode]').val();
		$.ajax({
			data:{'loginName':loginName,'loginPwd':loginPwd,'ValidateCode':ValidateCode},
			url:'/',
			type:'post',
			success:function(data){
				if(data=='0'){
					var banben=1;
					$(':radio').each(function(){
						if(this.checked) banben=this.value;					  
					}) 
					document.forms['lform'].banben.value = banben;
					document.forms['lform'].loginName.value = loginName;
					document.forms['lform'].loginPwd.value = loginPwd;
					document.forms['lform'].submit();
				}else if(data=='1'){
					alert('用户名或者密码错误');	
					$('input[name=loginName]')[0].select();
					$('input[name=loginPwd]').val('');
					rvcode();
				}else if(data=='2'){
					alert('验证码错误');
					rvcode();
					$('input[name=ValidateCode]')[0].select();
				}else{
					alert(data);
					rvcode();
				}
			}
		})	
	}	
}

function validateForm() {//表单验证准则
	 
	var form = document.forms['login_form'];
	var name = form.loginName.value.trim();
	form.name.value = name;
	var loginPwd = form.loginPwd.value.trim();
	var vcode = form.ValidateCode.value.trim();
	form.loginPwd.value = loginPwd;
	if (!(/^[a-z0-9A-Z][a-z0-9A-Z_]{0,11}$/.test(name))) {
		alert('账号由1-12位英文字母、数字、下划线组成，且第一位不能是下划线');
		form.loginName.focus();
		return false;
	}
	if (!(/^[0-9a-zA-Z]{6,16}$/.test(loginPwd))) {
		alert('密码由6-16位英文字母、数字字符组成');
		form.loginPwd.focus();
		return false;
	}
	if (vcode.length != 4) {
		alert('验证码由4位数字组成');
		form.ValidateCode.focus();
		return false;
	}
	if (!(/^\d{4}$/.test(vcode))) {
		alert('验证码由4位数字组成');
		form.ValidateCode.focus();
		return false;
	}
	return true;
}	

function initValidatePage(){
	var dialog = $.dialog({
		title: '历史公告',
		content: 'url:/loadHistory.php',
		lock : true,
		max : false,
		min : false,
		 
		button: [{
			name: '确定',
			callback: function () { 
				return true;
			},
			focus: false
		}]
	}); 
	
	$('#agree').bind('click',function(){ 
		document.form1.submit();
		return false;
	})
	$('#disagree').bind('click',function(){
		top.location='/userlib/quit.php';
		return false;
	})
}
$(document).keydown(function(event) { 
	if (event.keyCode == 13) { 
		try{$('#loginBtn').trigger('click');}catch(E){}
	} 
});