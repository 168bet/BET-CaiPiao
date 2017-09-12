<? if(!defined('PHPYOU')) {
	exit('非法进入');
}
$xc=39;
$XF=21;
$ids=$_GET['ids'];
if ($ids<>"七不中") $ids="七不中";

function Get_sx_nx($rrr){   
$result=mysql_query("Select id,m_number,sx From ka_sxnumber where  id='".$rrr."' Order By ID LIMIT 1"); 
$ka_Color1=mysql_fetch_array($result); 
$xxmnx=explode(",",$ka_Color1['m_number']);
return intval($xxmnx[0]);
}
 
?>
<link rel="stylesheet" href="images/xp.css" type="text/css">

<?

if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#FDF4CA bgcolor=#FDF4CA>          <tr>            <td height=28 align=center bgcolor=FE5711><font color=ffff00>封盘中....</font></td>          </tr>      </table>"; 
  exit;
}



$result=mysql_query("Select class3,rate from ka_bl where class2='".$ids."' order by ID");
$drop_table = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
//echo $image['class3'];
array_push($drop_table,$image);

}

?>

<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 


function CheckKey(){
	if(event.keyCode == 13) return true;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金额仅能输入数字!!"); return false;}
}

function ChkSubmit(){
    //设定『确定』键为反白 
	document.all.btnSubmit.disabled = true;

	if (eval(document.all.allgold.innerHTML)<=0 )
	{
		alert("请输入下注金额!!");
	    document.all.btnSubmit.disabled = false;
		return false;

	}

       // if (!confirm("是否确定下注")){
	   // document.all.btnSubmit.disabled = false;
       // return false;
       // }        
		document.all.gold_all.value=eval(document.all.allgold.innerHTML)
        document.lt_form.submit();
}



function CountGold(gold,type,rtype,bb,ffb){
  switch(type) {
  	  case "focus":
  	  	goldvalue = gold.value;
  	  	if (goldvalue=='') goldvalue=0;
  	  	document.all.allgold.innerHTML = eval(document.all.allgold.innerHTML+"-"+goldvalue);
  	  	total_gold.value = document.all.allgold.innerHTML;
  	  	break;
  	  case "blur":
	  if (goldvalue!='')
  	  	{goldvalue = gold.value;
		
  	  	if (goldvalue=='') goldvalue=0;

  	  
//if (rtype=='SP') {
//var ffbb=ffb-1;
//var str1="xr_"+ffbb;
//var str2="xrr_"+ffb;

//var t_big2 = new Number(document.all[str2].value);
//var t_big1 = new Number(document.all[str1].value);
//if (rtype=='SP' && (eval(eval(goldvalue)+eval(t_big1)) >eval(t_big2) )) {gold.focus(); alert("修改数据!!"); return false;}
//}
		
		if ( (eval(goldvalue) < <?=ka_memuser("xy")?>) && (goldvalue!='')) {gold.focus(); alert("下注金额不可小於最低限度:<?=ka_memuser("xy")?>!!"); return false;}
		
	
		if (rtype=='SP' && (eval(goldvalue) > <?=ka_memds($xc,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds($xc,2)?>!!"); return false;}
		
		
		if (rtype=='dx' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(8,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(37,3)?>!!"); return false;}
		
		if (rtype=='dx' && (eval(goldvalue) > <?=ka_memds(8,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds(8,2)?>!!"); return false;}
		
		
		if (rtype=='ds' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(9,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(9,3)?>!!"); return false;}
		if (rtype=='ds' && (eval(goldvalue) > <?=ka_memds(9,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds(9,2)?>!!"); return false;}
		

		
		
		total_gold.value = document.all.allgold.innerHTML;
	  	if (eval(document.all.allgold.innerHTML) > <?=ka_memuser("ts")?>)   {gold.focus(); alert("下注金额不可大於可用信用额度!!");    return false;}
		
		}
		      break;
  	  case "keyup":
  	  	goldvalue = gold.value;
  	  	if (goldvalue=='') goldvalue=0;
  	  document.all.allgold.innerHTML = eval(total_gold.value+"\+"+ goldvalue);
  	  	break;
  }
  //alert(goldvalue);
}
//-->
</SCRIPT>

 <style type="text/css">
<!--
.STYLE2 {color: #FFFFFF}
body {
	margin-left: 10px;
	margin-top: 10px;
}
-->
 </style>
 <body 
>
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>

<div align="center">

<SCRIPT language=javascript>
<!--
if(self == top) location = '/';
var type_nums = 10;  //预设为 3中2
var type_min = 7;
var cb_num = 1;
var mess1 =  '最少选择';
var mess11 = '个数字';
var mess2 =  '最多选择10个数字';
var mess = mess2;

function select_types(type,i) {

cb_num=1

s1="rrtype"
document.all[s1].value = 1;


s2="dm1"
document.all[s2].value ="" ;

s3="dm2"
document.all[s3].value ="";

	if (type == 1 || type == 2) {
		type_nums = 10;
		type_min = 3;
		
		for(i=1; i<13; i++) {
				
			MM_changeProp('pan1'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan1'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan6'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan6'+i,'','checked','0','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan3'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','checked','0','INPUT/CHECKBOX')
			
			MM_changeProp('pan5'+i,'','disabled','disabled','INPUT/CHECKBOX')
			
			MM_changeProp('pan5'+i,'','checked','0','INPUT/CHECKBOX')
			
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		MM_changeProp('pabc3','','disabled','disabled','INPUT/RADIO')
		MM_changeProp('pabc4','','disabled','disabled','INPUT/RADIO')
		MM_changeProp('pabc5','','disabled','disabled','INPUT/RADIO')
		
		
		for(i=1; i<50; i++) {
				
			MM_changeProp('num'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		MM_changeProp('pabc','','checked','checked','INPUT/RADIO')
		   
		a2.style.display = ""; 
		a3.style.display = "none";
		a4.style.display = "none"; 
		a5.style.display = "none"; 
		   
	 for(i=1; i<6; i++) {
			if (i==1) {
			var pabc="pabc";
			document.all[pabc].value = 1;
			MM_changeProp('pabc'+i,'','checked','1','INPUT/RADIO')
			}else{
			MM_changeProp('pabc'+i,'','checked','0','INPUT/RADIO')
			}
			
			
		}
	
	
	
	} else {
	cb_num=1
	
	s1="rrtype"
document.all[s1].value = 2;

s2="dm1"
document.all[s2].value ="" ;

s3="dm2"
document.all[s3].value ="";

		type_nums = 10;
		type_min = 2;
		
		a2.style.display = ""; 
		a3.style.display = "";
		a4.style.display = ""; 
		a5.style.display = ""; 
		
		MM_changeProp('pabc3','','disabled','0','INPUT/RADIO')
		MM_changeProp('pabc4','','disabled','0','INPUT/RADIO')
		MM_changeProp('pabc5','','disabled','0','INPUT/RADIO')
		
		for(i=1; i<50; i++) {
				
			MM_changeProp('num'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
		for(i=1; i<13; i++) {
				
			MM_changeProp('pan1'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan1'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan6'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan6'+i,'','checked','0','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan3'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan5'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan5'+i,'','checked','0','INPUT/CHECKBOX')
			
			
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
		
		
		 for(i=1; i<6; i++) {
			if (i==1) {
			var pabc="pabc";
			document.all[pabc].value = 1;
			MM_changeProp('pabc'+i,'','checked','1','INPUT/RADIO')
			}else{
			MM_changeProp('pabc'+i,'','checked','0','INPUT/RADIO')
			}
			
			
		}
		
	}
	
	
	
}  

function select_types1(type) {
cb_num=1
s2="dm1"
document.all[s2].value ="" ;

s3="dm2"
document.all[s3].value ="";
	if (type == 1 || type == 2) {
	
	for(i=1; i<50; i++) {
				
			MM_changeProp('num'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
		for(i=1; i<13; i++) {
				
			MM_changeProp('pan1'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan6'+i,'','disabled','disabled','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan3'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan5'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan5'+i,'','disabled','disabled','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
	
	var i
		for(i=1; i<6; i++) {
			if (i==type) {
			
			}else{
			MM_changeProp('pabc'+i,'','checked','0','INPUT/RADIO')
			}
			
			
		}
			
		
		  
		   
	
	
	
	} 
	
	if (type == 3 ) {
		
		
		for(i=1; i<50; i++) {
				
			MM_changeProp('num'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
		for(i=1; i<13; i++) {
				
			MM_changeProp('pan1'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('pan6'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan6'+i,'','checked','0','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan3'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan5'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan5'+i,'','checked','0','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
		for(i=1; i<6; i++) {
			if (i==type) {
			
			}else{
			MM_changeProp('pabc'+i,'','checked','0','INPUT/RADIO')
			}
			
			
		}
		
		a3.style.display = "";
		a4.style.display = ""; 
		
	}
	
	
	if (type == 5 ) {
		
		
		for(i=1; i<50; i++) {
				
			MM_changeProp('num'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
		for(i=1; i<13; i++) {
				
			MM_changeProp('pan1'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan1'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan6'+i,'','disabled','0','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan3'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan5'+i,'','disabled','0','INPUT/CHECKBOX')
			
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
		for(i=1; i<6; i++) {
			if (i==type) {
			
			}else{
			MM_changeProp('pabc'+i,'','checked','0','INPUT/RADIO')
			}
			
			
		}
		
		a3.style.display = "";
		a4.style.display = ""; 
		a5.style.display = ""; 
		
	}
	
	if (type == 4 ) {
	
		for(i=1; i<50; i++) {
				
			MM_changeProp('num'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
	for(i=1; i<13; i++) {
				
			MM_changeProp('pan1'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','disabled','disabled','INPUT/CHECKBOX')
			
			MM_changeProp('pan1'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','checked','0','INPUT/CHECKBOX')
			
			MM_changeProp('pan6'+i,'','disabled','disabled','INPUT/CHECKBOX')			
			MM_changeProp('pan6'+i,'','checked','0','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('pan5'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan5'+i,'','checked','0','INPUT/CHECKBOX')
		
		
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
		a3.style.display = "";
		a4.style.display = ""; 
	for(i=1; i<6; i++) {
			if (i==type) {
			
			}else{
			MM_changeProp('pabc'+i,'','checked','0','INPUT/RADIO')
			}
			
			
		}
		
		
	}
	
	
	
}

function r_pan1(zizi) {

for(i=1; i<13; i++) {
			if (i==zizi) {
						
			
			}else{
			MM_changeProp('pan1'+i,'','checked','0','INPUT/RADIO')
			}
			
			
		}
var str1="pan1";

var str2="pan2";
if(document.all[str2].value ==zizi)

{
MM_changeProp('pan1'+zizi,'','checked','0','INPUT/RADIO')

document.all[str1].value = "";
alert("对不起!请重新选择两个不一样的！");

document.all.pan4.focus();
return false;
}

}
		
function r_pan2(zizi,zzz){
for(i=1; i<13; i++) {
			if (i==zizi) {
						
			
			}else{
			MM_changeProp('pan2'+i,'','checked','0','INPUT/RADIO')
			}
			
			
		}

var str1="pan2";

var str2="pan1";
if(document.all[str2].value ==zizi)

{
MM_changeProp('pan2'+zizi,'','checked','0','INPUT/RADIO')

document.all[str1].value = "";
alert("对不起!请重新选择两个不一样的！");

document.all.pan4.focus();
return false;
}
}
		

function r_pan3(zizi,zzz){
for(i=0; i<10; i++) {
			if (i==zizi) {
						
			
			}else{
			MM_changeProp('pan3'+i,'','checked','0','INPUT/RADIO')
			}
			
			
		}
var str1="pan3";
var str2="pan4";
if(document.all[str2].value ==zizi)
{
MM_changeProp('pan3'+zizi,'','checked','0','INPUT/RADIO')

 document.all[str1].value = "";
alert("对不起!请重新选择两个不一样的！");

document.all.pan3.focus();
return false;
}
}
function r_pan4(zizi,zzz){



for(i=0; i<13; i++) {
			if (i==zizi) {
						
			
			}else{
			MM_changeProp('pan4'+i,'','checked','0','INPUT/RADIO')
			}
			
			
		}
		
var str1="pan4";

var str2="pan3";
if(document.all[str2].value ==zizi)

{
MM_changeProp('pan4'+zizi,'','checked','0','INPUT/RADIO')

document.all[str1].value = "";
alert("对不起!请重新选择两个不一样的！");

document.all.pan4.focus();
return false;
}


}
	
	
function r_pan5(zizi,zzz){
for(i=0; i<13; i++) {
			if (i==zizi) {
						
			
			}else{
			MM_changeProp('pan5'+i,'','checked','0','INPUT/RADIO')
			}
		}
}	

function r_pan6(zizi,zzz){
for(i=0; i<13; i++) {
			if (i==zizi) {
						
			
			}else{
			MM_changeProp('pan6'+i,'','checked','0','INPUT/RADIO')
			}
		}
}	


function ra_select(str1,zz){

    
       
        document.all[str1].value = zz;
   

}


    
function SubChk(obj) {

if (document.all.rrtype.value == "") {
alert('请选择类别');
	  return false;
}


if (document.all.pabc.value == 3) {
if (document.all.pan1.value =="" || document.all.pan2.value ==""){
	  alert('请选择生肖');
	  return false;
	  }  
	  
}

if (document.all.pabc.value == 4) {
if (document.all.pan3.value =="" || document.all.pan4.value ==""){
	  alert('请选择尾数');
	  return false;
	  }  
	  
}


if (document.all.rrtype.value == 1) {
if (document.all.pabc.value == 2) {
if (document.all.dm1.value =="" || document.all.dm2.value ==""){
	  alert('请选择胆');
	  return false;
	  }  
	  
}
}
if (document.all.rrtype.value == 2) {
if (document.all.pabc.value == 2) {



if (document.all.dm1.value =="" ){
	  alert('请选择胆');
	  return false;
	  }  
	  
}
}





if (document.all.jq.value =="" ){
	  alert('请输入金额');
	  return false;
	  }  


 
	var checkCount = 0;
	var checknum = obj.elements.length;
	var rtypechk = 0;

	
	for(i=0; i<obj.rtype.length; i++) {
		if (obj.rtype[i].checked) {
			rtypechk ++;
		}
	}
	
	

	if (rtypechk == 0) {
	  alert('请选择类别');
	  return false;
	}
	
	for(i=0; i<checknum; i++) {
		if (obj.elements[i].checked) {
			checkCount ++;
		}
	}
	
	
	if (checkCount > (type_nums + 1)) {
		alert(mess2);
		return false;
	}if(checkCount < (type_min+1)){
		alert(mess1+type_min+mess11);
		return false;
	}else{
		return true;
	}
}

function SubChkBox(obj,bmbm) {




	if(obj.checked == false)
	{
		cb_num--;
		//obj.checked = false;
	}


	//alert (cb_num);


	if(obj.checked == true)
	{
		if ( cb_num > type_nums ) 
		{
			alert(mess);
			cb_num--;
			obj.checked = false;
		}
		cb_num++;
	}


var str1="pabc";
var str2="rrtype";
var str3="dm1";
var str4="dm2";

if(document.all[str1].value ==2)

{
if(document.all[str2].value ==1  )

{

if (document.all[str3].value ==""){
MM_changeProp('num'+bmbm,'','disabled','disabled','INPUT/CHECKBOX')
///MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
document.all[str3].value = bmbm;
MM_changeProp('dm1','','disabled','0','INPUT/text')
}else
{
if (document.all[str4].value ==""){
MM_changeProp('num'+bmbm,'','disabled','disabled','INPUT/CHECKBOX')
MM_changeProp('dm2','','disabled','0','INPUT/text')
///MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
document.all[str4].value = bmbm;
}
}


}else
{
if (document.all[str3].value ==""){
MM_changeProp('num'+bmbm,'','disabled','disabled','INPUT/CHECKBOX')
MM_changeProp('dm1','','disabled','0','INPUT/text')
///MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
document.all[str3].value = bmbm;
}

}


}



	
}


//-->
</SCRIPT>
<table  width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td>
  <TABLE height=96 cellSpacing=0 cellPadding=0 width="780" 
      border=0>
            <TBODY>
            <form  method="post" onSubmit="return SubChk();"  action="index.php?action=k_qbzsave" name="lt_form" target="mem_order" >
              <TR>
                <TD colSpan=3 height="100%">
                    <TABLE  cellSpacing=0 cellPadding=0 width=100% 
            border=0>
                      <TBODY>
                        <TR>
                          <TD colSpan=2></TD>
                        </TR>
                        <TR>
                          <TD colSpan=2><TABLE width="100%" border=1 cellPadding=2 cellSpacing=1 bordercolor="#CCCCCC" bgcolor="#FFFFFF">
                              <TBODY>
                               <tr >
                                 <TD height="28" colspan="15" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                   <tr>
                                  <td width="20%"><font color=ff0000 size="3"><b><?=$ids?></b></font></td>
									 <td width="40%"><font color=000000>封盘倒计时:</font><font color="#FF0000"><strong><span id="span_dt_dt"></span></strong></font>
<SCRIPT language=javascript> 
function show_student163_time(){ 
window.setTimeout("show_student163_time()", 1000); 
BirthDay=new Date("<?=date("m-d-Y H:i:s",strtotime($Current_KitheTable[14]))?>");
today=new Date(); 
timeold=(BirthDay.getTime()-today.getTime()); 
sectimeold=timeold/1000 
secondsold=Math.floor(sectimeold); 
msPerDay=24*60*60*1000 
e_daysold=timeold/msPerDay 
daysold=Math.floor(e_daysold); 
e_hrsold=(e_daysold-daysold)*24; 
hrsold=Math.floor(e_hrsold); 
e_minsold=(e_hrsold-hrsold)*60; 
minsold=Math.floor((e_hrsold-hrsold)*60); 
seconds=Math.floor((e_minsold-minsold)*60); 
if(daysold<0) 
{ 
daysold=0; 
hrsold=0; 
minsold=0; 
seconds=0; 
} 
if (daysold>0){
span_dt_dt.innerHTML=daysold+"天"+hrsold+"小时"+minsold+"分"+seconds+"秒" ; 
}else if(hrsold>0){
span_dt_dt.innerHTML=hrsold+"小时"+minsold+"分"+seconds+"秒" ; 
}else if(minsold>0){
span_dt_dt.innerHTML=minsold+"分"+seconds+"秒" ; 
}else{
span_dt_dt.innerHTML=seconds+"秒" ; 

}
if (daysold<=0 && hrsold<=0  && minsold<=0 && seconds<=0)
window.setTimeout("self.location='index.php?action=stop'", 1);
} 
show_student163_time(); 
</SCRIPT></td>
<td width="40%" align="right">
            &nbsp;<button onClick="javascript:location.href='index.php?action=k_wbz&ids=五不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:000000;'>五不中</span></button>
			&nbsp;<button onClick="javascript:location.href='index.php?action=k_wbz6&ids=六不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:000000;'>六不中</span></button>&nbsp;
			&nbsp;<button onClick="javascript:location.href='index.php?action=k_qbz&ids=七不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:ff0000;'>七不中</span></button>&nbsp;
          </td>       <td ><div align="right"> </div></td>
   </tr>
 </table></TD>
                               </TR>
                             <tr class="tbtitle">
                                  <TD width=82 height="28" align="center"><span class="STYLE2">号码</span></TD>
                                  <td width="40" align="center"><span class="STYLE2">赔率</span></td>
                                  <TD width=82 align="center"><span class="STYLE2">勾选</span></TD>
                                  <TD width=82 align="center"><span class="STYLE2">号码</span></TD>
                                  <td width="40" align="center"><span class="STYLE2">赔率</span></td>
                                  <TD width=82 align="center"><span class="STYLE2">勾选</span></TD>
                                  <TD width=82 align="center"><span class="STYLE2">号码</span></TD>
                                  <td width="40" align="center"><span class="STYLE2">赔率</span></td>
                                  <TD width=82 align="center"><span class="STYLE2">勾选</span></TD>
                                  <TD width=82 align="center"><span class="STYLE2">号码</span></TD>
                                  <td width="40" align="center"><span class="STYLE2">赔率</span></td>
                                  <TD width=82 align="center"><span class="STYLE2">勾选</span></TD>
                                  <TD width=82 align="center"><span class="STYLE2">号码</span></TD>
                                  <td width="40" align="center"><span class="STYLE2">赔率</span></td>
                                  <TD width=82 align="center"><span class="STYLE2">勾选</span></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_r"><img src="images/num01.gif" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl0> 0 </span><span> </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,1) 
                        type=checkbox value=01 name=num1 id=num1></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num11.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl10> 0</span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,11) 
                        type=checkbox value=11 name=num11></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num21.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl20>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,21) 
                        type=checkbox value=21 name=num21></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num31.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl30> 0</span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,31) 
                        type=checkbox value=31 name=num31></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num41.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl40> 0 </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,41) 
                        type=checkbox value=41 name=num41></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_r"><img src="images/num02.gif" width="27" height="27" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl1> 0 </span><span> </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT name=num2 
                        type=checkbox onclick=SubChkBox(this,2) value=02 ></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num12.gif" width="27" height="27" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl11> 0 </span><span> </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,12) 
                        type=checkbox value=12 name=num12></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num22.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl21>0 </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,22) 
                        type=checkbox value=22 name=num22></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num32.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl31>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,32) 
                        type=checkbox value=32 name=num32></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num42.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl41>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,42) 
                        type=checkbox value=42 name=num42></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num03.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl2> 0 </span><span> </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,3) 
                        type=checkbox value=03 name=num3></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num13.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl12> 0 </span><span> </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,13) 
                        type=checkbox value=13 name=num13></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num23.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl22>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,23) 
                        type=checkbox value=23 name=num23></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num33.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl32>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,33) 
                        type=checkbox value=33 name=num33></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num43.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl42>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,43) 
                        type=checkbox value=43 name=num43></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num04.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl3> 0 </span><span> </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,4) 
                        type=checkbox value=04 name=num4></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num14.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl13> 0 </span><span> </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,14) 
                        type=checkbox value=14 name=num14></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num24.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl23>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,24) 
                        type=checkbox value=24 name=num24></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num34.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl33>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,34) 
                        type=checkbox value=34 name=num34></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num44.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl43>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,44) 
                        type=checkbox value=44 name=num44></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_g"><span class="ball_r"><img src="images/num05.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl4> 0 </span><span> </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,5) 
                        type=checkbox value=05 name=num5></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num15.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl14> 0 </span><span> </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,15) 
                        type=checkbox value=15 name=num15></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num25.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl24>0 </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,25) 
                        type=checkbox value=25 name=num25></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num35.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl34>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,35) 
                        type=checkbox value=35 name=num35></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num45.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl44>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,45) 
                        type=checkbox value=45 name=num45></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_g"><span class="ball_r"><img src="images/num06.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl5> 0 </span><span> </span></b></td>
                                <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,6) 
                        type=checkbox value=06 name=num6></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num16.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl15> 0 </span><span> </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,16) 
                        type=checkbox value=16 name=num16></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num26.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl25>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,26) 
                        type=checkbox value=26 name=num26></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num36.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl35>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,36) 
                        type=checkbox value=36 name=num36></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num46.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl45>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><input onClick=SubChkBox(this,46) 
                        type=checkbox value=46 name=num46></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_r"><img src="images/num07.gif" width="27" height="27" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl6> 0 </span><span> </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,7) 
                        type=checkbox value=07 name=num7></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num17.gif" width="27" height="27" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl16> 0 </span><span> </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,17) 
                        type=checkbox value=17 name=num17></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num27.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl26>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,27) 
                        type=checkbox value=27 name=num27></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num37.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl36>0 </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,37) 
                        type=checkbox value=37 name=num37></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num47.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl46>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,47) 
                        type=checkbox value=47 name=num47></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_r"><img src="images/num08.gif" width="27" height="27" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl7> 0 </span><span> </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,8) 
                        type=checkbox value=08 name=num8></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num18.gif" width="27" height="27" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl17> 0 </span><span> </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,18) 
                        type=checkbox value=18 name=num18></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num28.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl27>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,28) 
                        type=checkbox value=28 name=num28></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num38.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl37>0 </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,38) 
                        type=checkbox value=38 name=num38></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num48.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl47>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,48) 
                        type=checkbox value=48 name=num48></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num09.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl8> 0 </span><span> </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,9) 
                        type=checkbox value=09 name=num9></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num19.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl18> 0 </span><span> </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,19) 
                        type=checkbox value=19 name=num19></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num29.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl28>0 </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,29) 
                        type=checkbox value=29 name=num29></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num39.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl38>0 </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,39) 
                        type=checkbox value=39 name=num39></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num49.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl48>0 </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,49) 
                        type=checkbox value=49 name=num49></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num10.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl9> 0 </span><span> </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,10) 
                        type=checkbox value=10 name=num10></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num20.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl19> 0 </span><span> </span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,20) 
                        type=checkbox value=20 name=num20></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num30.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl29>0 </span></b></td>
                                 <TD align="center" bgcolor="ffffff"><INPUT onclick=SubChkBox(this,30) 
                        type=checkbox value=30 name=num30></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num40.gif" width="27" height="27" /></span></td>
         <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl39>0</span></b></td>
                                  <TD align="center" bgcolor="ffffff"><INPUT  onclick=SubChkBox(this,40) 
                        type=checkbox value=40 name=num40></TD><input name="rtype" type="hidden" id="rtype" value="七不中">
								  <input name="rrtype" type="hidden" id="rrtype" value="6">
                                  <TD colSpan=3 align=middle bgcolor="#FFFFFF">金额:
                                    <input  onKeyPress="return CheckKey();" 
                        onBlur="return CountGold(this,'blur','SP');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px" class="input1" name="jq" type="text" id="jq" size="5">
                                    <INPUT type=submit value="确定"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  name=btnSubmit>
                                  <input type="button"  onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit3" value="重设" />                                  </TD>
                                </TR>
                              </TBODY>
                          </TABLE>
                             
                            <DIV id=a2 style="DISPLAY:none ">
                                <table width="100%" border="0" cellpadding="2" cellspacing="1" bordercolor="#0" bgcolor="ffcc99">
                                  <tbody>
                                    <tr align="middle">
                                      <td width="76%" bgcolor="ffffff"><input name="pabc1" type="radio" onClick="select_types1(1);javascript:ra_select('pabc','1')" value="1" checked  />
                                        正常
                                        <input name="pabc2" type="radio" onClick="select_types1(2);javascript:ra_select('pabc','2')" value="2" />
                                        胆拖
                                        <input name="pabc3" type="radio" onClick="select_types1(3);;javascript:ra_select('pabc','3')" value="3" />
                                        生肖对碰
                                        <input name="pabc4" type="radio" onClick="select_types1(4);;javascript:ra_select('pabc','4')" value="4" />
                                        尾数对碰
										 <input name="pabc5" type="radio" onClick="select_types1(5);;javascript:ra_select('pabc','5')" value="5" />
                                       生肖尾数对碰
                                      <input name="pabc" type="hidden" id="pabc" value="1"></td>
                                      <td width="9%" nowrap bgcolor="ffffff" id="hd1">胆1
                                      <input name="dm1" type="text" disabled="disabled" class="input1" id="dm1" size="4"></td>
                                      <td width="12%" nowrap bgcolor="ffffff" id="hd1">胆2
                                      <input name="dm2" type="text"  disabled="disabled"  class="input1" id="dm2" size="4"></td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                              <DIV id=a3 style="DISPLAY:none ">
                                <table width="100%" border="0" cellpadding="2" cellspacing="1" bordercolor="#0" bgcolor="ffcc99">
                                  <tbody>
                                    <tr align="middle">
                                      <td align="center" bgcolor="ffffff">
                                         鼠
                                        <input name="pan1<?=Get_sx_nx(1)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(1)?>);javascript:ra_select('pan1','<?=Get_sx_nx(1)?>')" value="<?=Get_sx_nx(1)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">牛
                                        <input name="pan1<?=Get_sx_nx(7)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(7)?>);javascript:ra_select('pan1','<?=Get_sx_nx(7)?>')"  value="<?=Get_sx_nx(7)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">虎
                                        <input name="pan1<?=Get_sx_nx(2)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(2)?>);javascript:ra_select('pan1','<?=Get_sx_nx(2)?>')" value="<?=Get_sx_nx(2)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">兔
                                        <input name="pan1<?=Get_sx_nx(8)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(8)?>);javascript:ra_select('pan1','<?=Get_sx_nx(8)?>')"   value="<?=Get_sx_nx(8)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">龙
                                        <input name="pan1<?=Get_sx_nx(3)?>" type="radio"  onclick="r_pan1(<?=Get_sx_nx(3)?>);javascript:ra_select('pan1','<?=Get_sx_nx(3)?>')" value="<?=Get_sx_nx(3)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">蛇
                                        <input name="pan1<?=Get_sx_nx(9)?>" type="radio"  onclick="r_pan1(<?=Get_sx_nx(9)?>);javascript:ra_select('pan1','<?=Get_sx_nx(9)?>')"  value="<?=Get_sx_nx(9)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">马
                                        <input name="pan1<?=Get_sx_nx(4)?>" type="radio"  onclick="r_pan1(<?=Get_sx_nx(4)?>);javascript:ra_select('pan1','<?=Get_sx_nx(4)?>')"  value="<?=Get_sx_nx(4)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">羊
                                        <input name="pan1<?=Get_sx_nx(10)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(10)?>);javascript:ra_select('pan1','<?=Get_sx_nx(10)?>')"  value="<?=Get_sx_nx(10)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">猴
                                        <input name="pan1<?=Get_sx_nx(5)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(5)?>);javascript:ra_select('pan1','<?=Get_sx_nx(5)?>')"  value="<?=Get_sx_nx(5)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">鸡
                                        <input name="pan1<?=Get_sx_nx(11)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(11)?>);javascript:ra_select('pan1','<?=Get_sx_nx(11)?>')"  value="<?=Get_sx_nx(11)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">狗
                                        <input name="pan1<?=Get_sx_nx(6)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(6)?>);javascript:ra_select('pan1','<?=Get_sx_nx(6)?>')"  value="<?=Get_sx_nx(6)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">猪
                                      <input name="pan1<?=Get_sx_nx(12)?>" type="radio"  onclick="r_pan1(<?=Get_sx_nx(12)?>);javascript:ra_select('pan1','<?=Get_sx_nx(12)?>')" value="<?=Get_sx_nx(12)?>" />
                                          <input name="pan1" type="hidden" value="">
                                      </td>
                                    </tr>
                                    <tr align="middle">
                                      <td align="center" bgcolor="#FFFF99"><input name="pan2" type="hidden" value="">
                                        鼠
                                        <input name="pan2<?=Get_sx_nx(1)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(1)?>);javascript:ra_select('pan2','<?=Get_sx_nx(1)?>')" value="<?=Get_sx_nx(1)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">牛
                                        <input name="pan2<?=Get_sx_nx(7)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(7)?>);javascript:ra_select('pan2','<?=Get_sx_nx(7)?>')"  value="<?=Get_sx_nx(7)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">虎
                                        <input name="pan2<?=Get_sx_nx(2)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(2)?>);javascript:ra_select('pan2','<?=Get_sx_nx(2)?>')" value="<?=Get_sx_nx(2)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">兔
                                        <input name="pan2<?=Get_sx_nx(8)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(8)?>);javascript:ra_select('pan2','<?=Get_sx_nx(8)?>')"   value="<?=Get_sx_nx(8)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">龙
                                        <input name="pan2<?=Get_sx_nx(3)?>" type="radio"  onclick="r_pan2(<?=Get_sx_nx(3)?>);javascript:ra_select('pan2','<?=Get_sx_nx(3)?>')" value="<?=Get_sx_nx(3)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">蛇
                                        <input name="pan2<?=Get_sx_nx(9)?>" type="radio"  onclick="r_pan2(<?=Get_sx_nx(9)?>);javascript:ra_select('pan2','<?=Get_sx_nx(9)?>')"  value="<?=Get_sx_nx(9)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">马
                                        <input name="pan2<?=Get_sx_nx(4)?>" type="radio"  onclick="r_pan2(<?=Get_sx_nx(4)?>);javascript:ra_select('pan2','<?=Get_sx_nx(4)?>')"  value="<?=Get_sx_nx(4)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">羊
                                        <input name="pan2<?=Get_sx_nx(10)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(10)?>);javascript:ra_select('pan2','<?=Get_sx_nx(10)?>')"  value="<?=Get_sx_nx(10)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">猴
                                        <input name="pan2<?=Get_sx_nx(5)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(5)?>);javascript:ra_select('pan2','<?=Get_sx_nx(5)?>')"  value="<?=Get_sx_nx(5)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">鸡
                                        <input name="pan2<?=Get_sx_nx(11)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(11)?>);javascript:ra_select('pan2','<?=Get_sx_nx(11)?>')"  value="<?=Get_sx_nx(11)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">狗
                                        <input name="pan2<?=Get_sx_nx(6)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(6)?>);javascript:ra_select('pan2','<?=Get_sx_nx(6)?>')"  value="<?=Get_sx_nx(6)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">猪
                                      <input name="pan2<?=Get_sx_nx(12)?>" type="radio"  onclick="r_pan2(<?=Get_sx_nx(12)?>);javascript:ra_select('pan2','<?=Get_sx_nx(12)?>')" value="<?=Get_sx_nx(12)?>" /></td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                            <DIV id=a4 style="DISPLAY:none ">
                                <table width="100%" border="0" cellpadding="2" cellspacing="1" bordercolor="#0" bgcolor="ffcc99">
                                  <tbody>
                                    <tr align="middle">
                                      <td align="center" bgcolor="ffffff"><input name="pan3" type="hidden" value="22">
                                        0尾
                                        <input name="pan30" type="radio" onClick="r_pan3(0);javascript:ra_select('pan3','0')"  value="0" />                                      </td>
                                      <td align="center" bgcolor="ffffff">1尾
                                      <input name="pan31" type="radio"  onclick="r_pan3(1);javascript:ra_select('pan3','1')"  value="1" />                                      </td>
                                      <td align="center" bgcolor="ffffff">2尾
                                      <input name="pan32" type="radio" onClick="r_pan3(2);javascript:ra_select('pan3','2')"  value="2" />                                      </td>
                                      <td align="center" bgcolor="ffffff">3尾
                                      <input name="pan33" type="radio" onClick="r_pan3(3);javascript:ra_select('pan3','3')"  value="3" />                                      </td>
                                      <td align="center" bgcolor="ffffff">4尾
                                      <input name="pan34" type="radio" onClick="r_pan3(4);javascript:ra_select('pan3','4')"  value="4" />                                      </td>
                                      <td align="center" bgcolor="ffffff">5尾
                                      <input name="pan35" type="radio"  onclick="r_pan3(5);javascript:ra_select('pan3','5')" value="5" />                                      </td>
                                      <td align="center" bgcolor="ffffff">6尾
                                      <input name="pan36" type="radio"  onclick="r_pan3(6);javascript:ra_select('pan3','6')" value="6" />                                      </td>
                                      <td align="center" bgcolor="ffffff">7尾
                                      <input name="pan37" type="radio" onClick="r_pan3(7);javascript:ra_select('pan3','7')"  value="7" />                                      </td>
                                      <td align="center" bgcolor="ffffff">8尾
                                      <input name="pan38" type="radio" onClick="r_pan3(8);javascript:ra_select('pan3','8')"  value="8" />                                      </td>
                                      <td align="center" bgcolor="ffffff">9尾
                                      <input name="pan39" type="radio" onClick="r_pan3(9);javascript:ra_select('pan3','9')"  value="9" />                                      </td>
                                    </tr>
                                    <tr align="middle">
                                      <td align="center" bgcolor="#FFFF99"><input name="pan4" type="hidden" value="11">
                                        0尾
                                        <input name="pan40" type="radio"  onclick="r_pan4(0);javascript:ra_select('pan4','0')" value="0" />                                      </td>
                                      <td align="center" bgcolor="#FFFF99">1尾
                                      <input name="pan41" type="radio" onClick="r_pan4(1);javascript:ra_select('pan4','1')"   value="1" />                                      </td>
                                      <td align="center" bgcolor="#FFFF99">2尾
                                      <input name="pan42" type="radio"  onclick="r_pan4(2);javascript:ra_select('pan4','2')" value="2" />                                      </td>
                                      <td align="center" bgcolor="#FFFF99">3尾
                                      <input name="pan43" type="radio" onClick="r_pan4(3);javascript:ra_select('pan4','3')"  value="3" />                                      </td>
                                      <td align="center" bgcolor="#FFFF99">4尾
                                      <input name="pan44" type="radio" onClick="r_pan4(4);javascript:ra_select('pan4','4')"  value="4" />                                      </td>
                                      <td align="center" bgcolor="#FFFF99">5尾
                                      <input name="pan45" type="radio" onClick="r_pan4(5);javascript:ra_select('pan4','5')" value="5" />                                      </td>
                                      <td align="center" bgcolor="#FFFF99">6尾
                                      <input name="pan46" type="radio" onClick="r_pan4(6);javascript:ra_select('pan4','6')"  value="6" />                                      </td>
                                      <td align="center" bgcolor="#FFFF99">7尾
                                      <input name="pan47" type="radio"  onclick="r_pan4(7);javascript:ra_select('pan4','7')" value="7" />                                      </td>
                                      <td align="center" bgcolor="#FFFF99">8尾
                                      <input name="pan48" type="radio" onClick="r_pan4(8);javascript:ra_select('pan4','8')"  value="8" />                                      </td>
                                      <td align="center" bgcolor="#FFFF99">9尾
                                      <input name="pan49" type="radio" onClick="r_pan4(9);javascript:ra_select('pan4','9')"  value="9" /></td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
							
							
							 <DIV id=a5 style="DISPLAY: none">
                                <table width="100%" border="0" cellpadding="2" cellspacing="1" bordercolor="#0" bgcolor="ffcc99">
                                  <tbody>
                                    <tr align="middle">
                                      <td align="center" bgcolor="ffffff"><input name="pan5" type="hidden" value="22">
                                        0尾
                                        <input name="pan50" type="radio" onClick="r_pan5(0);javascript:ra_select('pan5','0')"  value="0" />                                      </td>
                                      <td align="center" bgcolor="ffffff">1尾
                                      <input name="pan51" type="radio"  onclick="r_pan5(1);javascript:ra_select('pan5','1')"  value="1" />                                      </td>
                                      <td align="center" bgcolor="ffffff">2尾
                                      <input name="pan52" type="radio" onClick="r_pan5(2);javascript:ra_select('pan5','2')"  value="2" />                                      </td>
                                      <td align="center" bgcolor="ffffff">3尾
                                      <input name="pan53" type="radio" onClick="r_pan5(3);javascript:ra_select('pan5','3')"  value="3" />                                      </td>
                                      <td align="center" bgcolor="ffffff">4尾
                                      <input name="pan54" type="radio" onClick="r_pan5(4);javascript:ra_select('pan5','4')"  value="4" />                                      </td>
                                      <td align="center" bgcolor="ffffff">5尾
                                      <input name="pan55" type="radio"  onclick="r_pan5(5);javascript:ra_select('pan5','5')" value="5" />                                      </td>
                                      <td align="center" bgcolor="ffffff">6尾
                                      <input name="pan56" type="radio"  onclick="r_pan5(6);javascript:ra_select('pan5','6')" value="6" />                                      </td>
                                      <td align="center" bgcolor="ffffff">7尾
                                      <input name="pan57" type="radio" onClick="r_pan5(7);javascript:ra_select('pan5','7')"  value="7" />                                      </td>
                                      <td align="center" bgcolor="ffffff">8尾
                                      <input name="pan58" type="radio" onClick="r_pan5(8);javascript:ra_select('pan5','8')"  value="8" />                                      </td>
                                      <td align="center" bgcolor="ffffff">9尾
                                      <input name="pan59" type="radio" onClick="r_pan5(9);javascript:ra_select('pan5','9')"  value="9" />                                      </td>
									    <td align="center" bgcolor="ffffff">                                      </td>
										  <td align="center" bgcolor="ffffff">                                      </td>
                                    </tr>
                                   <tr align="middle">
                                      <td align="center" bgcolor="#FFFF99"><input name="pan6" type="hidden" value="">
                                        鼠
                                        <input name="pan6<?=Get_sx_nx(1)?>" type="radio" onClick="r_pan6(<?=Get_sx_nx(1)?>);javascript:ra_select('pan6','<?=Get_sx_nx(1)?>')" value="<?=Get_sx_nx(1)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">牛
                                        <input name="pan6<?=Get_sx_nx(7)?>" type="radio" onClick="r_pan6(<?=Get_sx_nx(7)?>);javascript:ra_select('pan6','<?=Get_sx_nx(7)?>')"  value="<?=Get_sx_nx(7)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">虎
                                        <input name="pan6<?=Get_sx_nx(2)?>" type="radio" onClick="r_pan6(<?=Get_sx_nx(2)?>);javascript:ra_select('pan6','<?=Get_sx_nx(2)?>')" value="<?=Get_sx_nx(2)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">兔
                                        <input name="pan6<?=Get_sx_nx(8)?>" type="radio" onClick="r_pan6(<?=Get_sx_nx(8)?>);javascript:ra_select('pan6','<?=Get_sx_nx(8)?>')"   value="<?=Get_sx_nx(8)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">龙
                                        <input name="pan6<?=Get_sx_nx(3)?>" type="radio"  onclick="r_pan6(<?=Get_sx_nx(3)?>);javascript:ra_select('pan6','<?=Get_sx_nx(3)?>')" value="<?=Get_sx_nx(3)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">蛇
                                        <input name="pan6<?=Get_sx_nx(9)?>" type="radio"  onclick="r_pan6(<?=Get_sx_nx(9)?>);javascript:ra_select('pan6','<?=Get_sx_nx(9)?>')"  value="<?=Get_sx_nx(9)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">马
                                        <input name="pan6<?=Get_sx_nx(4)?>" type="radio"  onclick="r_pan6(<?=Get_sx_nx(4)?>);javascript:ra_select('pan6','<?=Get_sx_nx(4)?>')"  value="<?=Get_sx_nx(4)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">羊
                                        <input name="pan6<?=Get_sx_nx(10)?>" type="radio" onClick="r_pan6(<?=Get_sx_nx(10)?>);javascript:ra_select('pan6','<?=Get_sx_nx(10)?>')"  value="<?=Get_sx_nx(10)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">猴
                                        <input name="pan6<?=Get_sx_nx(5)?>" type="radio" onClick="r_pan6(<?=Get_sx_nx(5)?>);javascript:ra_select('pan6','<?=Get_sx_nx(5)?>')"  value="<?=Get_sx_nx(5)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">鸡
                                        <input name="pan6<?=Get_sx_nx(11)?>" type="radio" onClick="r_pan6(<?=Get_sx_nx(11)?>);javascript:ra_select('pan6','<?=Get_sx_nx(11)?>')"  value="<?=Get_sx_nx(11)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">狗
                                        <input name="pan6<?=Get_sx_nx(6)?>" type="radio" onClick="r_pan6(<?=Get_sx_nx(6)?>);javascript:ra_select('pan6','<?=Get_sx_nx(6)?>')"  value="<?=Get_sx_nx(6)?>" />
                                      </td>
                                      <td align="center" bgcolor="#FFFF99">猪
                                      <input name="pan6<?=Get_sx_nx(12)?>" type="radio"  onclick="r_pan6(<?=Get_sx_nx(12)?>);javascript:ra_select('pan6','<?=Get_sx_nx(12)?>')" value="<?=Get_sx_nx(12)?>" /></td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div></TD>
                        </TR>
                      </TBODY>
                    </TABLE>
                </TD>
              </TR>
            </FORM>
            </TBODY>
            
</TABLE>
          <div align="center"><br>
        <br>
      </div>
    </td>
  </tr>
</table>




<script>

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}


function MM_changeProp(objName,x,theProp,theValue) { //v6.0
  var obj = MM_findObj(objName);
  if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
    if (theValue == true || theValue == false)
      eval("obj."+theProp+"="+theValue);
    else eval("obj."+theProp+"='"+theValue+"'");
  }
}



function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}



function makeRequest(url) {

    http_request = false;
   
    if (window.XMLHttpRequest) {
   
        http_request = new XMLHttpRequest();
   
        if (http_request.overrideMimeType){
   
            http_request.overrideMimeType('text/xml');
   
        }
   
    } else if (window.ActiveXObject) {
   
        try{
       
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
       
        } catch (e) {
       
            try {
           
                http_request = new ActiveXObject("Microsoft.XMLHTTP");
           
            } catch (e) {
       
            }
   
        }

     }
     if (!http_request) {
     
        alert("Your browser nonsupport operates at present, please use IE 5.0 above editions!");
       
        return false;
       
     }
 

//method init,no init();
 http_request.onreadystatechange = init;
 
 http_request.open('GET', url, true);

//Forbid IE to buffer memory
 http_request.setRequestHeader("If-Modified-Since","0");

//send count
 http_request.send(null);

//Updated every two seconds a page
 setTimeout("makeRequest('"+url+"')", <?=$ftime?>);

}


function init() {
 
    if (http_request.readyState == 4) {
   
        if (http_request.status == 0 || http_request.status == 200) {
       
            var result = http_request.responseText;
			
           
            if(result==""){
           
                result = "Access failure ";
           
            }
           
		   var arrResult = result.split("###");	
		   for(var i=0;i<49;i++)
{	   
		   arrTmp = arrResult[i].split("@@@");
		   


num1 = arrTmp[0]; //字段num1的值
num2 = parseFloat(arrTmp[1]).toFixed(2); //字段num2的值
num3 = parseFloat(arrTmp[2]).toFixed(2); //字段num1的值
num4 = arrTmp[3]; //字段num2的值
num5 = arrTmp[4]; //字段num2的值
num6 = arrTmp[5]; //字段num2的值


//if (i<49){
//document.all["xr_"+i].value = num4;
//var sb=i+1
//document.all["xrr_"+sb].value = num5;
//}

var sbbn=i+1
if (num6==1){
MM_changeProp('num_'+sbbn,'','disabled','1','INPUT/text')}


var bl;
bl="bl"+i;
if (num6==1){
document.all[bl].innerHTML= "停";
}else{
<? $bb=ka_memuser("abcd");
 switch ($bb){
	case "A": ?>
	if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+num2+"</b></font></span>";
	}else{
	document.all[bl].innerHTML= num2;}
	
<?	break;
case "B":?>
if (i<=48){
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$bzm*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$bzx*100?>")/100;
}
}else{
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$bzmdx*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$bzx*100?>")/100;}

}
	<?
	break;
	case "C":?>
if (i<=48){if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$czm*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$czx*100?>")/100;}

}else{
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$czmdx*100?>")/100+"</b></font></span>";
	}else{document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$czx*100?>")/100;}
	}
	<?
	break;
	case "D":?>


if (i<=48){
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$dzm*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$dtx*100?>")/100;
}
}else{
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$dzmdx*100?>")/100+"</b></font></span>";
	}else{document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$dzm*100?>")/100;}
	}
	<? break;
    default:
	
	?>if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+num2+"</b></font></span>";
	}else{
	document.all[bl].innerHTML= num2;}
	
<? break;
}?>
}



}
			
			
           
        } else {//http_request.status != 200
           
                alert("Request failed! ");
       
        }
   
    }
 
}



function sendCommand(commandName,pageURL,strPara)
{
	//功能：向pageURL页面发送数据，参数为strPara
	//并回传服务器返回的数据
	var oBao = new ActiveXObject("Microsoft.XMLHTTP");
	//特殊字符：+,%,&,=,?等的传输解决办法.字符串先用escape编码的.
	oBao.open("GET",pageURL+"?commandName="+commandName+"&"+strPara,false);
	oBao.send();
	//服务器端处理返回的是经过escape编码的字符串.
	var strResult = unescape(oBao.responseText);
	return strResult;
}


</script>

<SCRIPT language=javascript>
 makeRequest('index.php?action=server&class1=全不中&class2=<?=$ids?>')
 </script>
