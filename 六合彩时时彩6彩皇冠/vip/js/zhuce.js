// JavaScript Document
function inputFocus(self,e){
	
	self.style.background = "#EBE9E9";
	
	var d = document.getElementById("zhuce_top").getElementsByTagName("span");
	d[e].className = "zhuce_06"
	switch(e){
		case 0 :
		d[e].innerHTML = "您在网站的登录帐户，5-12个英文或数字组成";
		break;
		
		case 1 :
		d[e].innerHTML = "密码由5-12位字母、数字或符号组成"
		break;
		
		case 2 :
		d[e].innerHTML = "请重复密码,须与上面输入的密码一致!"
		break;
		
		case 3 :
		d[e].innerHTML = "请输入您的真实姓名!"
		break;
		
		case 4 :
		d[e].innerHTML = "请填写您正确的电话号码!"
		break;
		
	}
	
}

function inputBlur(self,e){
	self.style.background = "#ffffff";
	var d = document.getElementById("zhuce_top").getElementsByTagName("span");
	
	if(self.value == ""){
		d[e].className = "zhuce_03333";
		switch(e){
			case 0 :
			d[e].innerHTML = "<img src='/images/wenhao.gif'><font color='#ff6600'>请输入用户帐号!</font>";
			self.pd = "no";
			break;
			
			case 1 :
			d[e].innerHTML = "<img src='/images/wenhao.gif'><font color='#ff6600'>请输入用户密码!</font>";
			self.pd = "no";
			break;
			
			case 2 :
			d[e].innerHTML = "<img src='/images/wenhao.gif'><font color='#ff6600'>请确认密码!</font>";
			self.pd = "no";
			break;
			
			case 3 :
			d[e].innerHTML = "<img src='/images/wenhao.gif'><font color='#ff6600'>请输入真实的姓名!</font>";
			self.pd = "no";
			break;
			
			case 4 :
			d[e].innerHTML = "<img src='/images/wenhao.gif'><font color='#ff6600'>请填写电话!</font>";
			self.pd = "no";
			break;
			
		}
	}else{
		switch(e){
			case 0 : 
			var zz = /^[0-9a-zA-Z]{5,12}$/;
			if(!zz.test(self.value)){
				d[e].className = "zhuce_0333";
				d[e].innerHTML = "<img src=/images/dele.gif><font color='#ff6600'>您在网站的登录帐户，5-12个英文或数字组成!</font>";
				self.pd = "no";
			}else{
				d[e].className = "zhuce_077";
			d[e].innerHTML = "<img src=/images/ture.gif>";
			self.pd = "yes";
			break;
			}
			break;
			
			case 1 : 
			var zz = /^.{5,12}$/;
			if(!zz.test(self.value)){
				d[e].className = "zhuce_03333";
				d[e].innerHTML = "<img src=/images/dele.gif><font color='red'>请输入密码，由5-12位字母、数字或符号组成!</font>";
				self.pd = "no";
			}else{
				d[e].className = "zhuce_077";
				d[e].innerHTML = "<img src=/images/ture.gif>";
				self.pd = "yes";
			}
			break;
			
			
			case 2 : 
			var xx = /^.{5,12}$/;
			if(self.value != document.getElementById("pwd1").value || !xx.test(self.value)){
				d[e].className = "zhuce_03333";
				d[e].innerHTML = "<img src=/images/dele.gif><font color='red'>密码格式有误或和上面输入的密码不一致,请检查!</font>";
				self.pd = "no";
			}else{
				d[e].className = "zhuce_077";
				d[e].innerHTML = "<img src=/images/ture.gif>";
				self.pd = "yes";
			}
			break;
			
			case 3 : 
			if(self.value.length > 20 ){
				d[e].className = "zhuce_03333";
				d[e].innerHTML = "<img src=/images/dele.gif><font color='red'>用户名长度不应超过20个字符!</font>";
				self.pd = "no";
			}else{
				if(isNoChinese(self.value)){
					d[e].className = "zhuce_077";
					d[e].innerHTML = "<img src=/images/ture.gif>";
					self.pd = "yes";
				}else{
					d[e].className = "zhuce_03333";
					d[e].innerHTML = "<img src=/images/dele.gif><font color='red'>真实名字只能为中文!</font>";
					self.pd = "no";
				}
			}
			break;
			
			case 4 : 
			if(self.value.length > 20 ){
				d[e].className = "zhuce_03333";
				d[e].innerHTML = "<img src=/images/dele.gif><font color='red'>电话长度不应超过20个字符!</font>";
				self.pd = "no";
			}else{
				d[e].className = "zhuce_077";
				d[e].innerHTML = "<img src=/images/ture.gif>";
				self.pd = "yes";
			}
			break;
			
					}
	}
	
}

function formsubmit(obja){
	var d = document.getElementById("zhuce_top").getElementsByTagName("span");
	var bool = true;
	for(i=0; i<obja.length; i++){
		if(obja.elements[i].value == ""){
			obja.elements[i].style.background = "#EBE9E9";
			d[i].className = "zhuce_033333";
			d[i].innerHTML = "<img src=/images/dele.gif border=0><font color='red'>此项不能为空</font>";
			bool = false;
			//return ;
		}
	}
	if(!bool) return false;
	for(i=0; i<obja.length; i++){
		if(obja.elements[i].pd == "no"){
			obja.elements[i].style.background = "#DDFFDE";
			d[i].className = "zhuce_03";
			bool = false;
			////return false;
		}
	}
	if(!bool) return false;
	if(obja.zccheck.checked == false){
		alert("如果您已满十八岁而且同意本站[条款及规则],请在该项打勾");
		return false;
	}
}

function change_zc_yzm(id){
	document.getElementById(id).src = "zc_yzm.php?"+Math.random();
	return false;
	
}

function getreturn(){
	if (xmlhttp.readyState == 4) {//如果已经获取到完整数据
		if (xmlhttp.status == 200) {
			var text = xmlhttp.responseText;
			
			if(text == "y"){
				document.getElementById("nameid").className = "zhuce_077";
				document.getElementById("nameid").innerHTML = "<img src=/images/ture.gif>";
				document.getElementById("zcusername").pd = "yes";
			}else{
				document.getElementById("nameid").className = "zhuce_03333";
				document.getElementById("nameid").innerHTML = "<img src=/images/dele.gif><font color='red'>抱歉,用户名已经被占用!</font>";
				document.getElementById("zcusername").pd = "no";
			}
			
		} else {
			    document.getElementById("nameid").className = "zhuce_077";
				document.getElementById("nameid").innerHTML = "<img src=/images/ture.gif>";
				document.getElementById("zcusername").pd = "yes";
		}
	}
}

function isNoChinese(v){
	var reg=/[\u4E00-\u9FA5]|[\uFE30-\uFFA0]/gi;
	if (reg.test(v)) return true;
	else return false;
}
