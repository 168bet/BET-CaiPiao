function SubChk(){
	var Numflag = 0;
	var Letterflag = 0;
	var pwds = document.all.password_safe.value;
	var pwd = document.all.password.value;
	var user = document.all.username.value;
	if(pwds == ""){
		document.all.password_safe.focus();
		alert(top.str_input_longin_id);
		return false;
	}
	if(pwd == ""){
		document.all.password.focus();
		alert(top.str_input_pwd);
		return false;
	}
	if (pwds.length < 6 || pwds.length > 12) {
		alert(top.str_longin_limit1);
		return false;
	}
	for (idx = 0; idx < pwds.length; idx++) {
		//====== 密碼只可使用字母(不分大小寫)與數字
		if(!((pwds.charAt(idx)>= "a" && pwds.charAt(idx) <= "z") || (pwds.charAt(idx)>= 'A' && pwds.charAt(idx) <= 'Z') || (pwds.charAt(idx)>= '0' && pwds.charAt(idx) <= '9'))){
			alert(top.str_longin_limit1);
			return false;
		}
		if ((pwds.charAt(idx)>= "a" && pwds.charAt(idx) <= "z") || (pwds.charAt(idx)>= 'A' && pwds.charAt(idx) <= 'Z')){
			Letterflag = 1;
		}
		if ((pwds.charAt(idx)>= '0' && pwds.charAt(idx) <= '9')){
			Numflag = 1;
		}
	}
	//====== 密碼需使用字母加上數字
	if (Numflag == 0 || Letterflag == 0) {
		alert(top.str_longin_limit2);
		return false;
	}
	ChgPwdForm.submit();
}

function ChkMem(){
	var D=document.all.password_safe.value;
	var uid =document.all.uid.value;
	document.getElementById('getData').src='mem_chk.php?uid='+uid+'&langx='+langx+'&username='+D;
}