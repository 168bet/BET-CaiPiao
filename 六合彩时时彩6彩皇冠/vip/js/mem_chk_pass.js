function SubChk(){
	var Numflag = 0;
	var Letterflag = 0;
	var pwd = document.all.password.value;

	if (pwd == pass) {
		alert(top.str_pwd_NoChg);
		return false;
	}
	if (document.all.password.value==''){
		document.all.password.focus();
		alert(top.str_input_pwd);
		return false;
	}
	if (document.all.REpassword.value==''){
		document.all.REpassword.focus();
		alert(top.str_input_repwd);
		return false;
	}
	if (pwd.length < 6 || pwd.length > 12) {
		alert(top.str_pwd_limit);
		return false;
	}
	if(document.all.password.value != document.all.REpassword.value){
		document.all.password.focus();
		alert(top.str_err_pwd);
		return false;
	}
	for (idx = 0; idx < pwd.length; idx++) {
		//====== 密碼只可使用字母(不分大小寫)與數字
		if(!((pwd.charAt(idx)>= "a" && pwd.charAt(idx) <= "z") || (pwd.charAt(idx)>= 'A' && pwd.charAt(idx) <= 'Z') || (pwd.charAt(idx)>= '0' && pwd.charAt(idx) <= '9'))){
			alert(top.str_pwd_limit);
			return false;
		}
		if ((pwd.charAt(idx)>= "a" && pwd.charAt(idx) <= "z") || (pwd.charAt(idx)>= 'A' && pwd.charAt(idx) <= 'Z')){
			Letterflag++;
		}
		if ((pwd.charAt(idx)>= "0" && pwd.charAt(idx) <= "9")){
			Numflag++;
		}
	}
	//====== 密碼需使用字母加上數字
	var msg = "";
	if (Numflag == 0 || Letterflag == 0) {
		alert(top.str_pwd_limit2);
		return false;
	} else if (Letterflag >= 1 && Letterflag <= 3) {
		msg = "1";
	} else if (Letterflag >= 4 && Letterflag <= 8) {
		msg = "2";
	} else if (Letterflag >= 9 && Letterflag <= 11) {
		msg = "3";
	} else {
		return false;
	}
	window.showModalDialog("/app/member/chg_pass_msg.php?msg="+msg+"_"+LS+"&str_meta="+str_meta, "", "dialogHeight=130px;dialogWidth=280px;center=yes;status=no;help=no;statusbar=no;scroll=no;");
	return true;
}