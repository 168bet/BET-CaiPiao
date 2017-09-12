var count_win=false;
//alert(self.name);
window.setTimeout("Win_Redirect()", 45000);
function Win_Redirect(){
	var i=document.all.uid.value;
	var pdate=document.all.pdate.value;
	var page=document.URL;
	go_page="../select.php?uid="+i;
	self.location=go_page;
}
function delteams(teamid){
	eval("TR"+teamid+".style.display='none'");
	document.all.teamcount.value=document.all.teamcount.value-1;
	scripts[teamid-1][0]="0";
	LoadSelect();
}

function LoadSelect(){
	if(rtype=="P"){
	   var mode = 0;				
	} else if(rtype=="PR") {
		var mode = 1;
	} else if(rtype=="P3"){
		var mode = 3;
	}
 //if (top.paramData.length == 0){ 
//	 top.paramData=scripts;
 //}else if (top.paramData.length==scripts.length){
 //alert(top.paramData.length+"=="+scripts.length);
 //if (top.paramData.length==scripts.length){
 //top.paramData=scripts;
 	for (s=0;s < scripts.length ;s++){
 		for (i=0;i < parent.paramData.length ;i++){
 			//先判斷GID
 			if (parent.paramData[i][0]==scripts[s][0]){
 				if (parent.paramData[i][3]!=scripts[s][3]||parent.paramData[i][4]!=scripts[s][4]||parent.paramData[i][5]!=scripts[s][5]){
 					eval("document.getElementById('P"+(s+1)+"').style.background='#FFDFDF'");
 					//帶金額過去
 					if(document.all.gold.value==""){
						document.all.gold.value=parent.goldData;
						document.all.gold.focus();
						CountWinGold(iorstr,mode);
				 	}
 				}	
 			}
 		}
 	}
 	parent.paramData=new Array();
 //}
 
	document.all.wteam.style.display="none"
	if(document.all.teamcount.value <= 1){
		document.all.btnCancel.disabled = true;
		document.all.SUBMIT.disabled = true;
		document.all.wkind.style.display="none"
		document.all.wstar.style.display="none"
		document.all.gold.style.display="none"
	}else{
		document.all.wstar.length = 1;
		document.all.wstar.options[0]=new Option(document.all.teamcount.value+"串1",document.all.teamcount.value);
	}
}

function chiang_wkind(){
	if(document.all.wkind.value == 'M'){
		document.all.wstar.length = document.all.teamcount.value-2;
		for(i=2; i<document.all.teamcount.value; i++)
			document.all.wstar.options[i-2]=new Option(i+"串1",i);
			document.all.wteam.style.display="block";
			document.all.wteam.length = 1;
			var count=0;
			var start=eval(document.all.wstar.value)+1;
			document.all.wteam.options[count++]=new Option(document.all.teamcount.value+"隊聯碰",document.all.teamcount.value)
	}else{
		document.all.wstar.length = 1;
		document.all.wstar.options[0]=new Option(document.all.teamcount.value+"串1",document.all.teamcount.value);
		document.all.wteam.style.display="none";
	}
}

function chiang_wstar(){
	if(document.all.wkind.value == 'M'){
		document.all.wteam.style.display="block";
		document.all.wteam.length = 1;
		var count=0;
		var start=eval(document.all.wstar.value)+1;
		document.all.wteam.options[0]=new Option(document.all.teamcount.value+"隊聯碰",document.all.teamcount.value)
	}else{
		document.all.wteam.style.display="none";
	}
}

function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金額僅能輸入數字!!"); return false;}
}


function CheckSubmit(){
// if((document.all.teamcount.value <= 1 && scripts[0][4].length ==1))
// {
//  alert("您至少必須選擇2個隊伍,否則不能下注!!");
//  return false;
// }
 	//將資料放到佔存

 	//alert("aaa==>"+parent.paramData.length);
	if (parent.paramData.length == 0||(""+parent.paramData.length=="undefined")){ 
		parent.paramData=scripts;
		//alert("aaa==>"+parent.paramData+"==bbb===>"+scripts);
	}
	if(document.all.teamcount.value <= (minlimit*1-1)){
		alert("您必須選擇至少"+minlimit+"個隊伍,否則不能下注!!");
		return false;
	}
	//alert(document.all.teamcount.value+"-"+maxlimit);
	if(document.all.teamcount.value > maxlimit*1){
		alert("不接受" + document.all.teamcount.value + "串過關投注!!");
		return false;
	}
 if(document.all.gold.value=='')
 {
  alert("請輸入欲下注金額!!");
  document.all.gold.focus();
  return false;
 }
 if(eval(document.all.gold.value*1) < eval(document.all.gmin_single.value))
 {
  document.all.gold.focus();
  alert("下注金額不可小於最低下注金額!!");
  return false;
 }
 if (document.all.pay_type.value =='1') //檢查現金顧客
{
	 if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value))
 {
  document.all.gold.focus();
  alert("已超過某場次之過關注單限額!!");
  return false;
  }
}
//if (document.all.pay_type.value !='1') //檢查信用顧客
//{
//	var sc=document.all.sc.value;
//       	if (sc==''){
//       		alert ('檢查參數不得空白');
//       		return false;
//       	}
//	sc=sc.split(' ');
//	counttmp=document.all.teamcount.value;
//	tmp_gold=parseInt(document.all.gold.value);
//	if(counttmp>1){
//		tmp=1;
//		for(var q=0;q<counttmp;q++){
//			var tmp_count=tmp_gold+parseInt(sc[q]);
//			if (tmp_count > eval(document.all.singlecredit.value) ){
//			  alert("下注金額已超過會員單場限額!!");
//			  return false;
//			  //self.location=document.location+'&active=4';;
//			}
//		}
//	}
//if (document.all.pay_type.value !='1') //檢查信用顧客
//{
//	if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value))
//	{
//	document.all.gold.focus();
//	alert("已超過某場次之過關注單限額!!");
//	return false;
//	}
//}
// if((eval(document.all.wagerstotal.value)+eval(document.all.gold.value*1)) >= eval(document.all.singlecredit.value))
// {
//  document.all.gold.focus();
//  alert("過關注單累計共: "+document.all.wagerstotal.value+"\n金額已超過過關注單限額!!");
//  return false;
// }
//}//檢查信用顧客結束---------------------------------
 if(eval(document.all.gold.value*1) > eval(document.all.restcredit.value))
 {
  document.all.gold.focus();
  alert("下注金額不可大於信用額度!!");
  return false;
  }

  if(!confirm("可贏金額："+document.all.pc.innerHTML+"\n\n是否確定下注?")){return false;}
  document.all.btnCancel.disabled = true;
  document.all.SUBMIT.disabled = true;
  document.all.wagerDatas.value="";
  for (kk=0;kk<scripts.length;kk++){
  	if (scripts[kk][0]!="0")  document.all.wagerDatas.value+=scripts[kk].toString()+"|";
  }
 	//將金額放到暫存
	parent.goldData=gold1;
  document.forms[0].submit();
}

//計算彩金
function CountWinGold(chk,mode){
   /*------------------------------------------------
   * edit date --- 2005/7/14						*
   * From anson										*
   * Content --- from 202 to 206					*
   -------------------------------------------------*/
	
	chk=chk.split(' ');
	var iortmp="";
	if(document.all.gold.value==''){
		document.all.gold.focus();
		document.all.pc.innerHTML="0";
		alert('未輸入下注金額!!!');
	}else{
		counttmp=document.all.tcount.value;
		gold1=document.all.gold.value;
		if(counttmp>1){
			tmp=1;
			for(q=0;q<counttmp;q++){
				if (scripts[q][0] != "0"){
					if(mode=="3"||mode=="1"){
						//20090203本金已計算
						//if(scripts[q][1]=="PRH"||scripts[q][1]=="PRC"||scripts[q][1]=="HPRH"||scripts[q][1]=="HPRC"||scripts[q][1]=="POUH"||scripts[q][1]=="POUC"||scripts[q][1]=="HPOUH"||scripts[q][1]=="HPOUC"){
							
						//	tmp*=(1+(parseFloat(chk[q])));
						//}else{
							tmp*=((parseFloat(chk[q])));	
						//}
					}else{	
						tmp*=(mode+(parseFloat(chk[q])));
					}
				}
			}
	        	var tmp_var=gold1*tmp-gold1;
	        	tmp_var=Math.round(tmp_var*100);
	        	tmp_var=tmp_var/100;
			document.all.pc.innerHTML=tmp_var;
		}
	}
}

