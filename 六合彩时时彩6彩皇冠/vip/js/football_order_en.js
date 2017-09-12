var count_win=false;
if (self==top) 	self.location.href="http://"+document.domain;
window.setTimeout("Win_Redirect()", 45000);
function Win_Redirect(){
	var i=document.all.uid.value;
	self.location='../select.php?uid='+i;
}

function CheckKey(){
	if(event.keyCode == 13) return false;
	//if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金額僅能輸入數字!!"); return false;}
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("only accept numbers on wager amount!!"); return false;}
	//if (isNaN(event.keyCode) == true)){alert("下注金額僅能輸入數字!!"); return false;}
}

function SubChk()
{
 if(document.all.gold.value=='')
 {
  document.all.gold.focus();
  alert("please key in wager amount!!");//請輸入下注金額
  return false;
 }
 if(isNaN(document.all.gold.value) == true)
 {
  document.all.gold.focus();
  alert("only numbers acceptable!!");//只能輸入數字
  return false;
 }

     if(eval(document.all.gold.value*1) < eval(document.all.gmin_single.value))
    {
     document.all.gold.focus();
     alert("Your wager amount cannot be under the minimum wager amount!!");
     return false;
     }
    if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value))
    {
     document.all.gold.focus();
      alert("Sorry,you have exceeded your maximum wager limit "+document.all.gmax_single.value+"!!Please key your wager again!!");
     return false;
     }
  if (document.all.pay_type.value!='1') //不檢查現金顧客
  {
    if(eval(document.all.gold.value*1) > eval(document.all.singleorder.value))
    {
     document.all.gold.focus();
     alert("You are not allowed to place wager more than your maximum wager limitation!!");
     return false;
    }
    if((eval(document.all.restsinglecredit.value)+eval(document.all.gold.value*1)) > eval(document.all.singlecredit.value))
    {
     document.all.gold.focus();
     if (eval(document.all.restsinglecredit.value)==0)
     {
       alert("Exceeded your maximum wager limitation!!");
     }else{
      alert("The total of your wager on this game: "+document.all.restsinglecredit.value+"\n has exceeded your maximum wager limitation!!");
     }
     return false;
    }
 }
    if(eval(document.all.gold.value*1) > eval(document.all.restcredit.value))
    {
     document.all.gold.focus();
    alert("You are not allowed to place wager more than your credit limit!!");//下注金額不可大於可用額度
     return false;
    }

//if(!confirm("可贏金額："+tmp_var+"\n\n是否確定下注?")){return false;}
//if (document.all.pc.innerHTML!='0'){
//	if(!confirm("To Estimated: " + document.all.pc.innerHTML + "\n\n confirm your wager?")){return false;}
//}else{
//	if(!confirm("confirm your wager?")){return false;}
//}
Open_div();		
document.all.btnCancel.disabled = true;
document.all.Submit.disabled = true;
document.all.gold.readOnly=true;
//document.forms[0].submit();
return false;

}
function CountWinGold(){
	if(document.all.gold.value==''){
		document.all.gold.focus();
		document.all.pc.innerHTML="0";
		alert('Please key in the Amount!!!');//未輸入下注金額
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
		alert('Please key in the Amount!!!');//未輸入下注金額
	}else{
		var tmp_var=document.all.gold.value * document.all.ioradio_r_h.value;
        tmp_var=tmp_var-document.all.gold.value;
        tmp_var=Math.round(tmp_var*100);
        tmp_var=tmp_var/100;
		document.all.pc.innerHTML=tmp_var;
		count_win=true;
	}
}
function Open_div(){
	var show_str;
	if (document.all.pc.innerHTML!='0'){
		show_str="To Estimated: " + document.all.pc.innerHTML + "<br> confirm your wager?";
	}else{	
		show_str="confirm your wager?<br>";
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