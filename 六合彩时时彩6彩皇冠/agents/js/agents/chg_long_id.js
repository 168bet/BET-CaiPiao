function SubChk(){
	var Numflag = 0;
	var Letterflag = 0;
	var pwd = document.all.loginname.value;

	if (document.all.loginname.value == ""){
		document.all.loginname.focus();
		alert(top.str_input_longin_id);
		return false;
	}
	
	if (pwd.length < 6 || pwd.length > 12) {
		alert(top.str_longin_limit1);
		return false;
	}
	for (idx = 0; idx < pwd.length; idx++) {
		//====== 密碼只可使用字母(不分大小寫)與數字
		if(!((pwd.charAt(idx)>= "a" && pwd.charAt(idx) <= "z") || (pwd.charAt(idx)>= 'A' && pwd.charAt(idx) <= 'Z') || (pwd.charAt(idx)>= '0' && pwd.charAt(idx) <= '9'))){
			alert(top.str_longin_limit1);
			return false;
		}
		if ((pwd.charAt(idx)>= "a" && pwd.charAt(idx) <= "z") || (pwd.charAt(idx)>= 'A' && pwd.charAt(idx) <= 'Z')){
			Letterflag = 1;
		}
		if ((pwd.charAt(idx)>= '0' && pwd.charAt(idx) <= '9')){
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
function ChkAG(){
	var D=document.all.loginname.value;
	var uid =document.all.uid.value;
	document.getElementById('getData').src='ag_chk.php?uid='+uid+'&username='+D;
}