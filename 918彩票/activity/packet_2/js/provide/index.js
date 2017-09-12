define(function (){
	//验证手机有效性
	var isPhoneOk = function (tel){
		var reg = 	/^((13[0-9])|(15[^4,\\d])|(18[0-9])|(14[0-9])|(17[0-9]))\d{8}$/;
		if(reg.test(tel)){
			return true;
		}
		return false;
	};

	var bindEvent=function(){
		$("#cellphone").keyup(function(){
			this.value = this.value.replace(/\D/g, " ").replace(/(\d{3})(\d{4})(\d{4})/,'$1 $2 $3');
		});
		
		$("#firstNext").bind("click",function(){
			var phone = $("#cellphone").val();
			phone=phone.replace(/['\t]/g,'').replace(/\s*/g, '');
			
			if(!(isPhoneOk($.trim(phone)))){
		    	 alert('对不起，请输入正确的手机号码');
		    	 return;
		     }
			
		});
	};

	var init = function(){
		bindEvent();
		};
　　　
	return {
       init:init
　　　};
　　});