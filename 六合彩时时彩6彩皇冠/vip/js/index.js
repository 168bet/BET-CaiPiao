<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

var strChk_Number="";
function show(){
	//document.all.show_flash.style.position='absolute';
	//document.all.show_flash.style.visibility='visible';
	//window.setTimeout("close_flash()", 9000);
	//document.all.username.focus();
	//set_img();
}
function close_flash(){
	document.all.show_flash.style.visibility='hidden';
}
function chk_acc(){
	document.all.JE.value = navigator.javaEnabled();
	if(document.all.username.value==""){
		hr_info.innerHTML=top.account;
		document.all.username.focus();
		return false;
	}
	if(document.all.passwd.value==""){
		hr_info.innerHTML=top.password;
		document.all.passwd.focus();
		return false;
	}
	/*
	if(document.all.number.value==""){
		hr_info.innerHTML="請輸入檢查碼!!";
		document.all.number.focus();
		return false;
	}
	if(document.all.number.value!=strChk_Number.replace(" ","")){
		hr_info.innerHTML="檢查碼輸入錯誤請重新輸入!!";
		document.all.number.focus();
		return false;
	}
	*/
	//document.all.mac.value=top.aps.mac;
	//document.all.ver.value=top.aps.ver;
	return true;
}
/*
function set_img(){
	strChk_Number = (""+Math.random()).substr(2,4);
	intImg.innerHTML=strChk_Number;
	intDa= (1*strChk_Number) % 3 + 1;
	eval("document.getElementById('img_pic').background ='/images/member/chk_img0"+intDa+".gif'");
}
*/
//-->