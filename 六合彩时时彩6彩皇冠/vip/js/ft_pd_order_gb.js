var count_win=false;
if (self==top) 	self.location.href="http://"+document.domain;
window.setTimeout("Win_Redirect()", 45000);
function Win_Redirect(){
	var i=document.all.uid.value;
	self.location='../select.php?uid='+i;
}
function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金额仅能输入数字!!"); return false;}
	//if (isNaN(event.keyCode) == true)){alert("下注金额仅能输入数字!!"); return false;}
}

function SubChk()
{
 if(document.all.gold.value=='')
 {
  document.all.gold.focus();
  alert("请输入下注金额!!");
  return false;
 }
 if(isNaN(document.all.gold.value) == true)
 {
  document.all.gold.focus();
  alert("只能输入数字!!");
  return false;
 }

    if(eval(document.all.gold.value*1) < eval(document.all.gmin_single.value))
    {
     document.all.gold.focus();
     alert("下注金额不可小于最低下注金额!!");
     return false;
     }
    //if (document.all.rtype.value=="ODD" || document.all.rtype.value=="EVEN")
    //{
      if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value))
      {
       document.all.gold.focus();
       alert("对不起,本场有下注金额最高: "+document.all.gmax_single.value+" 元限制!!");
       return false;
      }
    //}
  if (document.all.pay_type.value!='1') //不检查现金顾客
  {
      if(eval(document.all.gold.value*1) > eval(document.all.singleorder.value))
      {
       document.all.gold.focus();
       alert("下注金额不可大于单注限额!!");
       return false;
      }
    if((eval(document.all.restsinglecredit.value)+eval(document.all.gold.value*1)) > eval(document.all.singlecredit.value))
    {
     document.all.gold.focus();
     if (eval(document.all.restsinglecredit.value)==0)
     {
     	alert("下注金额已超过单场最高限额!!");
     }else{
     	alert("本场累计下注共: "+document.all.restsinglecredit.value+"\n下注金额已超过单场限额!!");
     }
     return false;
    }
  }
    if(eval(document.all.gold.value*1) > eval(document.all.restcredit.value))
    {
     document.all.gold.focus();
     alert("下注金额不可大于可用额度!!");
     return false;
    }


if(!confirm("可赢金额："+document.all.pc.innerHTML+"\n\n是否确定下注?")){return false;}
document.all.btnCancel.disabled = true;
document.all.Submit.disabled = true;
document.forms[0].submit();

}
function CountWinGold(){
	if(document.all.gold.value==''){
		document.all.gold.focus();
		document.all.pc.innerHTML="0";
		alert('未输入下注金额!!!');
	}else{
		var tmp_var=document.all.gold.value * document.all.ioradio_pd.value-document.all.gold.value;
		tmp_var=Math.round(tmp_var*100);
		tmp_var=tmp_var/100;
		document.all.pc.innerHTML=tmp_var;
		count_win=true;
	}
}