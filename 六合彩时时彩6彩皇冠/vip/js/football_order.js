var count_win=false;
if (self==top) 	self.location.href="http://"+document.domain;
window.setTimeout("Win_Redirect()", 45000);
function Win_Redirect(){
	var i=document.all.uid.value;
	self.location='../select.php?uid='+i;
}

function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金額僅能輸入數字!!"); return false;}
	//if (isNaN(event.keyCode) == true)){alert("下注金額僅能輸入數字!!"); return false;}
}
function SubChk()
{
 if(document.all.gold.value=='')
 {
  document.all.gold.focus();
  alert("請輸入下注金額!!");
  return false;
 }
 if(isNaN(document.all.gold.value) == true)
 {
  document.all.gold.focus();
  alert("只能輸入數字!!");
  return false;
 }

    if(eval(document.all.gold.value*1) < eval(document.all.gmin_single.value))
    {
     document.all.gold.focus();
     alert("下注金額不可小於最低下注金額!!");
     return false;
     }
    if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value))
    {
     document.all.gold.focus();
     alert("對不起,本場有下注金額最高: "+document.all.gmax_single.value+" 元限制!!");
     return false;
     }
  if (document.all.pay_type.value!='1') //不檢查現金顧客
  {
    if(eval(document.all.gold.value*1) > eval(document.all.singleorder.value))
    {
     document.all.gold.focus();
     alert("下注金額不可大於單注限額!!");
     return false;
    }
    if((eval(document.all.restsinglecredit.value)+eval(document.all.gold.value*1)) > eval(document.all.singlecredit.value))
    {
     document.all.gold.focus();
     if (eval(document.all.restsinglecredit.value)==0)
     {
       alert("下注金額已超過單場最高限額!!");
     }else{
       alert("本場累計下注共: "+document.all.restsinglecredit.value+"\n下注金額已超過單場限額!!");
     }
     return false;
    }
 }
    if(eval(document.all.gold.value*1) > eval(document.all.restcredit.value))
    {
     document.all.gold.focus();
     alert("下注金額不可大於可用額度!!");
     return false;
    }

// if (document.all.pc.innerHTML!='0'){
// 	if(!confirm("可贏金額："+document.all.pc.innerHTML+"\n\n是否確定下注?")){return false;}
// 	return false;	
// }else{
// 	if(!confirm("是否確定下注?")){return false;}
// 	return false;
// }
Open_div();	
document.all.btnCancel.disabled = true;
document.all.Submit.disabled = true;
document.all.gold.readOnly=true;
return false;
//document.forms[0].submit();
}
function CountWinGold(){
	if(document.all.gold.value==''){
		document.all.gold.focus();
		document.all.pc.innerHTML="0";
		alert('未輸入下注金額!!!');
	}else{
		var tmpior =document.all.ioradio_r_h.value;
		if(document.all.odd_f_type.value == "E") tmpior -=1;
	    	var tmp_var=document.all.gold.value * ((tmpior < 0)? 1 : tmpior);
		tmp_var=Math.round(tmp_var*100);
		tmp_var=tmp_var/100;
		document.all.pc.innerHTML=tmp_var;
		count_win=true;
	}
}
function CountWinGold1(){
	if(document.all.gold.value==''){
		document.all.gold.focus();
		document.all.pc.innerHTML="0";
		alert('未輸入下注金額!!!');
	}else{
		var tmp_var=document.all.gold.value * document.all.ioradio_r_h.value;
        tmp_var=tmp_var-document.all.gold.value;
        tmp_var=Math.round(tmp_var*100);
        tmp_var=tmp_var/100;
		//alert("bbb===>"+tmp_var);
		document.all.pc.innerHTML=tmp_var;
		count_win=true;
	}
}
function Open_div(){
	var show_str;
	//alert("aaa===>"+document.all.pc.innerHTML);
	//alert('sadfasdf');
	if (document.all.pc.innerHTML!='0'){
		show_str="可贏金額："+document.all.pc.innerHTML+"<br>是否確定下注?";
	}else{	
		show_str="是否確定下注?<br>";
	}
	var obj_show_table = document.getElementById('line_window');	
	var obj_gWager = document.getElementById('gWager');
	obj_gWager.innerHTML='';
	obj_gWager.innerHTML=obj_show_table.innerHTML;
	obj_gWager.innerHTML=obj_gWager.innerHTML.replace("*SHOW_STR*",show_str);	
	document.all['gWager'].style.display = "block";
}
function Close_div(){
	document.all['gWager'].style.display = "none";
	document.all.btnCancel.disabled = false;
	document.all.Submit.disabled = false;
	document.all.gold.readOnly=false;
	return false;
}
function Sure_wager(){
	document.all['gWager'].style.display = "none";
	document.forms[0].submit();
}