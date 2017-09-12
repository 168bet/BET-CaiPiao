// JScript 文件
//alert('fff');
var t_LT
var t_GT;
var NO_count=0;
var inceptMID=0;

var t_Title="";

var No_Color=null;
var tNO_s=new Array();//号码集数组

function NtI(t_NO) {//号码To MID
	return Number(t_NO) + (inceptMID-1);
}
function ItN(t_MID) {//MID To 号码
	return Number(t_MID) - (inceptMID-1);
}


//加载下注号码表
function LoadJeuTab() {
	//加载号码集
	if (t_LT=="1"){//六
		NO_count=49;
		
		No_Color=new Array("","R","R","B","B","G","G","R","R","B","B","G","R","R","B","B","G","G","R","R","B","G","G","R","R","B","B","G","G","R","R","B","G","G","R","R","B","B","G","G","R","B","B","G","G","R","R","B","B","G");
		
		tNO_s[0]=new String("1,2,7,8,12,13,18,19,23,24,29,30,34,35,40,45,46").split(",");
		tNO_s[1]=new String("3,4,9,10,14,15,20,25,26,31,36,37,41,42,47,48").split(",");
		tNO_s[2]=new String("5,6,11,16,17,21,22,27,28,32,33,38,39,43,44,49").split(",");
		tNO_s[3]=new String("1,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41,43,45,47,49").split(",");
		tNO_s[4]=new String("2,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,46,48").split(",");
		tNO_s[5]=new String("25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49").split(",");
		tNO_s[6]=new String("1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24").split(",");
		tNO_s[7]=new String("1,3,5,7,9,10,12,14,16,18,21,23,25,27,29,30,32,34,36,38,41,43,45,47,49").split(",");
		tNO_s[8]=new String("2,4,6,8,11,13,15,17,19,20,22,24,26,28,31,33,35,37,39,40,42,44,46,48").split(",");
		
		tNO_s[21]=new String("").split(",");
		tNO_s[22]=new String("").split(",");
		tNO_s[23]=new String("").split(",");
		tNO_s[24]=new String("").split(",");
		
		tNO_s[39]=new String("5,6,7,8,9,15,16,17,18,19,25,26,27,28,29,35,36,37,38,39,45,46,47,48,49").split(",");
		tNO_s[40]=new String("1,2,3,4,10,11,12,13,14,20,21,22,23,24,30,31,32,33,34,40,41,42,43,44").split(",");
	}

    for(var i=1;i<=NO_count;i++) {
		//if (parent.mainFrame.Multiple_Array[NtI(i)]==""){//stop
			//document.getElementById("S_" + i).innerHTML="-";
			//document.getElementById("S_" + i).className="s_td_0"
		//} else {
			if (i < 10){var Left_NO="0"}else{var Left_NO=""}//补零
			document.getElementById("S_" + i).innerHTML="<a href='javascript:void(0)' onClick='ChoiceNO(" + i + ")' onFocus='this.blur()'><span class='Font_" + No_Color[i] + "'>&nbsp;" + Left_NO + i + "&nbsp;</span></a>";
		//}
    }
}
//选择号码
function ChoiceNO(t_NO) {
	
	if (document.getElementById("S_" + t_NO).className=="s_td_0"){
		document.getElementById("S_" + t_NO).className="s_td_1"
	} else {
		document.getElementById("S_" + t_NO).className="s_td_0"
	}
	document.L_JeuForm.JeuMoney.focus();
}
//选择相关号码
function ChoiceNO_S(t_ID) {
	//if (document.L_JeuForm.add_Jeu.disabled==true) return false;
	
	var tNOs=new Array();
		
	if (Number(t_ID)==21) {//家禽
	    tNOs=tNO_s[10];
    	tNOs=tNOs.concat(tNO_s[15]);
    	tNOs=tNOs.concat(tNO_s[16]);
    	tNOs=tNOs.concat(tNO_s[18]);
    	tNOs=tNOs.concat(tNO_s[19]);
    	tNOs=tNOs.concat(tNO_s[20]);
	} else if (Number(t_ID)==22) {//野兽
	    tNOs=tNO_s[9];
    	tNOs=tNOs.concat(tNO_s[11]);
    	tNOs=tNOs.concat(tNO_s[12]);
    	tNOs=tNOs.concat(tNO_s[13]);
    	tNOs=tNOs.concat(tNO_s[14]);
    	tNOs=tNOs.concat(tNO_s[17]);
	} else if (Number(t_ID)==23) {//大单
	    for(var i=0;i<tNO_s[3].length;i++) {
	        if (Number(tNO_s[3][i])>=25) tNOs.push(tNO_s[3][i]);
        }
	} else if (Number(t_ID)==24) {//小单
	    for(var i=0;i<tNO_s[3].length;i++) {
	        if (Number(tNO_s[3][i])<25) tNOs.push(tNO_s[3][i]);
        }
	} else if (Number(t_ID)==25) {//大双
	    for(var i=0;i<tNO_s[4].length;i++) {
	        if (Number(tNO_s[4][i])>=25) tNOs.push(tNO_s[4][i]);
        }
	} else if (Number(t_ID)==26) {//小双
	    for(var i=0;i<tNO_s[4].length;i++) {
	        if (Number(tNO_s[4][i])<25) tNOs.push(tNO_s[4][i]);
        }
	} else if (Number(t_ID)==27) {//红大===========================
	    for(var i=0;i<tNO_s[0].length;i++) {
	        if (Number(tNO_s[0][i])>=25) tNOs.push(tNO_s[0][i]);
        }
	} else if (Number(t_ID)==28) {//红小
	    for(var i=0;i<tNO_s[0].length;i++) {
	        if (Number(tNO_s[0][i])<25) tNOs.push(tNO_s[0][i]);
        }
	} else if (Number(t_ID)==29) {//红单
	    for(var i=0;i<tNO_s[0].length;i++) {
	        if ((Number(tNO_s[0][i]) % 2)!=0) tNOs.push(tNO_s[0][i]);
        }
	} else if (Number(t_ID)==30) {//红双
	    for(var i=0;i<tNO_s[0].length;i++) {
	        if ((Number(tNO_s[0][i]) % 2)==0) tNOs.push(tNO_s[0][i]);
        }
	} else if (Number(t_ID)==31) {//蓝大===========================
	    for(var i=0;i<tNO_s[1].length;i++) {
	        if (Number(tNO_s[1][i])>=25) tNOs.push(tNO_s[1][i]);
        }
	} else if (Number(t_ID)==32) {//蓝小
	    for(var i=0;i<tNO_s[1].length;i++) {
	        if (Number(tNO_s[1][i])<25) tNOs.push(tNO_s[1][i]);
        }
	} else if (Number(t_ID)==33) {//蓝单
	    for(var i=0;i<tNO_s[1].length;i++) {
	        if ((Number(tNO_s[1][i]) % 2)!=0) tNOs.push(tNO_s[1][i]);
        }
	} else if (Number(t_ID)==34) {//蓝双
	    for(var i=0;i<tNO_s[1].length;i++) {
	        if ((Number(tNO_s[1][i]) % 2)==0) tNOs.push(tNO_s[1][i]);
        }
	} else if (Number(t_ID)==35) {//绿大===========================
	    for(var i=0;i<tNO_s[2].length;i++) {
	        if (Number(tNO_s[2][i])>=25) tNOs.push(tNO_s[2][i]);
        }
	} else if (Number(t_ID)==36) {//绿小
	    for(var i=0;i<tNO_s[2].length;i++) {
	        if (Number(tNO_s[2][i])<25) tNOs.push(tNO_s[2][i]);
        }
	} else if (Number(t_ID)==37) {//绿单
	    for(var i=0;i<tNO_s[2].length;i++) {
	        if ((Number(tNO_s[2][i]) % 2)!=0) tNOs.push(tNO_s[2][i]);
        }
	} else if (Number(t_ID)==38) {//绿双
	    for(var i=0;i<tNO_s[2].length;i++) {
	        if ((Number(tNO_s[2][i]) % 2)==0) tNOs.push(tNO_s[2][i]);
        }
	} else {
        tNOs=tNO_s[Number(t_ID)]
	} 
	//alert(tNOs.length);
    for(var i=0;i<tNOs.length;i++) {
	    if (document.getElementById("S_" + Number(tNOs[i])).innerHTML!="-") {
		    if (document.getElementById("S_" + Number(tNOs[i])).className=="s_td_0"){
			    document.getElementById("S_" + Number(tNOs[i])).className="s_td_1"
		    } else {
			    document.getElementById("S_" + Number(tNOs[i])).className="s_td_0"
		    }
	    }
    }
	document.L_JeuForm.JeuMoney.focus();
	Ref_JeuInfo();
}
//反选号码
function ChoiceNO_IR() {
	///if (document.L_JeuForm.add_Jeu.disabled==true) return false;
	
	for(var i=1;i<=NO_count;i++) {
		if (document.getElementById("S_" + i).innerHTML!="-") {		
			if (document.getElementById("S_" + i).className=="s_td_0"){
				document.getElementById("S_" + i).className="s_td_1"
			} else {
				document.getElementById("S_" + i).className="s_td_0"
			}
		}
	}
	document.L_JeuForm.JeuMoney.focus();
	Ref_JeuInfo();
}
//取消悬置号码
function ChoiceNO_C() {
	//if (document.L_JeuForm.add_Jeu.disabled==true) return false;
	
	for(var i=1;i<=NO_count;i++) {
		document.getElementById("S_" + i).className="s_td_0"
	}
	document.L_JeuForm.JeuMoney.focus();
	Ref_JeuInfo();
}

//更新下注号码表
function UpadteJeuTab(t_ID,t_Multiple) {
	if (t_Multiple==""){ //stop
		document.getElementById("S_" + ItN(t_ID)).innerHTML="-";
		document.getElementById("S_" + ItN(t_ID)).className="s_td_0"
	} else {
		if (ItN(t_ID) < 10){var Left_NO="0"}else{var Left_NO=""}//补零
		document.getElementById("S_" + ItN(t_ID)).innerHTML="<a title='赔率：" + t_Multiple + "' href='javascript:void(0)' onClick='ChoiceNO(" + ItN(t_ID) + ")'><span class='Font_" + No_Color[ItN(t_ID)] + "'>&nbsp;" + Left_NO + ItN(t_ID) + "&nbsp;</span></a>";
	}
}

//限制只能输入数字
function digitOnly(evt) {
	if (evt.keyCode==13){//确认下注
		Add_JeuInfo();
	}
   if (!(evt.keyCode>=48 && evt.keyCode<=57)){
       evt.returnValue=false;
   }
}


//添加注单
function Ref_JeuInfo() {
 var Ttotal_XZ=0;//投注总额
 var K=0;
 var rmb=parseInt(document.L_JeuForm.JeuMoney.value);
 if(document.L_JeuForm.JeuMoney.value=='NaN' || document.L_JeuForm.JeuMoney.value=='' || document.L_JeuForm.JeuMoney.value==null){
	 rmb=0;
 }
	for(var i=1;i<=49;i++) {
		if(document.getElementById("S_"+i).className=='s_td_1'){
			 var ads=document.getElementById("t"+i).value;
			 if(ads=="") ads=0;
			document.getElementById("t"+i).value=parseFloat(rmb);		
			 Ttotal_XZ+=rmb;
			 K++;
		}else{
			 document.getElementById("t"+i).value="";	
		}
	}
	document.getElementById("Sum_Jeu_XZ").innerHTML=Ttotal_XZ;
	document.getElementById("Count_Jeu_XZ").innerHTML=K;
	
	
}
//删除注单
function Del_JeuInfo(obj,t_Jeu_XZ) {
	var obj_JeuList=document.getElementById('JeuList');	
	for (var i=0;i<obj_JeuList.rows.length;i++){
		if (obj_JeuList.rows[i]==obj){
			obj_JeuList.deleteRow(i);
			document.getElementById("Sum_Jeu_XZ").innerHTML=Number(document.getElementById("Sum_Jeu_XZ").innerHTML) - Number(t_Jeu_XZ);
			document.getElementById("Count_Jeu_XZ").innerHTML=Number(document.getElementById("Count_Jeu_XZ").innerHTML) - 1;
			break;
		}
	}
}

//清除注单
function clear_JeuInfo() {
	var obj_JeuList=document.getElementById('JeuList');	
	var j=obj_JeuList.rows.length-1;
	for (var i=0;i<=j;i++){
		obj_JeuList.deleteRow(j-i);
	}
	document.getElementById("Sum_Jeu_XZ").innerHTML=0;
	document.getElementById("Count_Jeu_XZ").innerHTML=0;
	Ref_JeuInfo();
}

//确定下注验证
function confirm_jeu() {
	var obj_JeuList=document.getElementById('JeuList');	
	if(obj_JeuList.rows.length==0){
		alert("请下注!!!");
		return false;
	}
	if(Number(document.getElementById("Sum_Jeu_XZ").innerHTML)>Number(document.getElementById("Money_KY").innerHTML)){
		alert("“总下注额”超过您账户上的可用金额，请减少部分下注！");
		return false;
	}
	
	var s_uPI_ID="",s_uPI_P="",s_uPI_M=""
	
	for (var i=0;i<obj_JeuList.rows.length;i++){
		var TR=obj_JeuList.rows(i);
		var TD1 = TR.cells(0), TD2 = TR.cells(1), TD3 = TR.cells(2)
        s_uPI_ID+="," + TD1.className;
        s_uPI_P+="," + TD3.className;
        s_uPI_M+="," + TD2.innerHTML;
	}
	
	if(!confirm("确定下注吗？")) {
		return false;
	} else {
	    document.L_JeuForm.uPI_ID.value=s_uPI_ID.substr(1);
	    document.L_JeuForm.uPI_P.value=s_uPI_P.substr(1);
	    document.L_JeuForm.uPI_M.value=s_uPI_M.substr(1);
		document.getElementById("confirm_clew").innerHTML="下注中，请稍候……";
		document.L_JeuForm.JeuMoney.disabled=true;
		document.L_JeuForm.add_Jeu.disabled=true;
		//return false;//测试不给提交 
	}
}

function But_MoreSet(){
	var MoreSet = document.getElementById("MoreSet");
	if (MoreSet.style.display=="block") {
    	MoreSet.style.display="none";
	} else {
	    MoreSet.style.display="block";
    }
}


function Check_Submit(obj){
 var Ttotal_XZ=0;//投注总额
 var K=0;
 var rmb=parseInt(document.L_JeuForm.JeuMoney.value);
 if(document.L_JeuForm.JeuMoney.value=='NaN' || document.L_JeuForm.JeuMoney.value=='' || document.L_JeuForm.JeuMoney.value==null){
	 rmb=0;
 } 
 if(rmb<10)
 {  
 	alert('投注金额最低为10 ');
	return false;
 }	
	for(var i=1;i<=49;i++) {
		if(document.getElementById("S_"+i).className=='s_td_1'){
			 var ads=document.getElementById("t"+i).value;
			 if(ads=="") ads=0;
			document.getElementById("t"+i).value=parseFloat(rmb);		
			 Ttotal_XZ+=rmb;
			 K++;
			 
		}else{
			 document.getElementById("t"+i).value="";	
		}
	}
	if(Number(document.getElementById("Sum_Jeu_XZ").innerHTML)>Number(document.getElementById("Money_KY").innerHTML)){
		alert("\"总下注额\"超过您账户上的可用金额，请减少部分下注！");
		return false;
	}
		
	return true;
}