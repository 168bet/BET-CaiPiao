<? if(!defined('PHPYOU')) {
	exit('非法进入');
}







$xc=20;

$XF=21;

$ids="连码";


function Get_sx_nx($rrr){   
$result=mysql_query("Select id,m_number,sx From ka_sxnumber where  id='".$rrr."' Order By ID LIMIT 1"); 
$ka_Color1=mysql_fetch_array($result); 
$xxmnx=explode(",",$ka_Color1['m_number']);
return intval($xxmnx[0]);
}
 
?>
<link href="imgs/main_n1.css" rel="stylesheet" type="text/css">
<link href="imgs/ball1.css" rel="stylesheet" type="text/css">
<SCRIPT type="text/javascript" src="imgs/activeX_Embed.js"></SCRIPT>

<?

if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
?>
<script language="javascript">
Make_FlashPlay('imgs/T0.swf','T','650','500');
</script>
<?
exit;
}



$result=mysql_query("Select class3,rate from ka_bl where class1='连码' order by ID");
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
</SCRIPT>


 <style type="text/css">
<!--
.STYLE2 {color: #FFFFFF}
.STYLE3 {color: #000}
body {
	margin-left: 10px;
	margin-top: 10px;
}
-->
 </style>
 <body oncontextmenu="return false"   onselect="document.selection.empty()" oncopy="document.selection.empty()" 
>
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>

<SCRIPT language=javascript>
<!--
if(self == top) location = '/';
var type_nums = 10;  //预设为 3中2
var type_min = 3;
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

	if (type == 1 || type == 2 || type == 6) {
		type_nums = 10;
		type_min = 3;
		
		for(i=1; i<13; i++) {
				
			MM_changeProp('pan1'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan1'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','checked','0','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan3'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','checked','0','INPUT/CHECKBOX')
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
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan3'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','checked','0','INPUT/CHECKBOX')
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
	if (type == 1 || type == 2  || type == 6) {
	
	for(i=1; i<50; i++) {
				
			MM_changeProp('num'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
		for(i=1; i<13; i++) {
				
			MM_changeProp('pan1'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','disabled','disabled','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan3'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','checked','0','INPUT/CHECKBOX')
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
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('pan3'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','checked','0','INPUT/CHECKBOX')
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
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','0','INPUT/CHECKBOX')
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
	
	if (type == 5 ) {
	
		for(i=1; i<50; i++) {
				
			MM_changeProp('num'+i,'','disabled','disabled','INPUT/CHECKBOX')
			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		
	for(i=1; i<13; i++) {
				
			MM_changeProp('pan1'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','disabled','disabled','INPUT/CHECKBOX')
			
			MM_changeProp('pan1'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan2'+i,'','checked','0','INPUT/CHECKBOX')
			//MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');
		}
		for(i=0; i<10; i++) {
				
			MM_changeProp('pan3'+i,'','disabled','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','disabled','disabled','INPUT/CHECKBOX')
			
			MM_changeProp('pan3'+i,'','checked','0','INPUT/CHECKBOX')
			MM_changeProp('pan4'+i,'','checked','0','INPUT/CHECKBOX')
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
//-->
</SCRIPT>

<TABLE  border="0" cellpadding="2" cellspacing="1" bordercolordark="#f9f9f9" bgcolor="#CCCCCC"width=650 >
  <TBODY>
  <TR class="tbtitle">
    <TD ><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td height=25><SPAN id=Lottery_Type_Name>当前期数: </SPAN>【第<?=$Current_Kithe_Num?>期】 <span id=allgold style="display:none">0</span></TD>
    <TD align=right colSpan=3>
            
    </TD></TR>
  <TR vAlign=bottom class="tbtitle">
    <TD width="25%" height=17><B class=font_B><?=$ids?></B></TD>
    <TD align=middle width="25%">开奖时间：<?=date("H:i:s",strtotime($Current_KitheTable['nd'])) ?></TD>
    <TD align=middle width="35%">距离封盘时间：
    
      <span id="span_dt_dt"></span>
      <SCRIPT language=javascript> 
      function show_student163_time(){ 
      window.setTimeout("show_student163_time()", 1000); 
      BirthDay=new Date("<?=date("m-d-Y H:i:s",strtotime($Current_KitheTable[12]))?>");
      today=new Date("<?=date('m-d-Y H:i:s',time())?>"); 
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
      span_dt_dt.innerHTML=daysold+"天"+hrsold+":"+minsold+":"+seconds ; 
      }else if(hrsold>0){
      span_dt_dt.innerHTML=hrsold+":"+minsold+":"+seconds ; 
      }else if(minsold>0){
      span_dt_dt.innerHTML=minsold+":"+seconds ;  
      }else{
      span_dt_dt.innerHTML=seconds+"秒" ; 
      
      }
      if (daysold<=0 && hrsold<=0  && minsold<=0 && seconds<=0)
      window.setTimeout("self.location='index.php?action=kq'", 1);
      } 
      show_student163_time(); 
      </SCRIPT>
    </TD>
    <TD align=right width="25%"><SPAN class=Font_B 
      id=Update_Time></SPAN>&nbsp;</TD></TR></TBODY></TABLE></td>
  </tr>
      </table>


<form  method="post" onSubmit="return SubChk();"  action="index.php?action=k_lmsave" name="lt_form" target="mem_order"  style="height:580px;">
<table  width="650" border=0 cellPadding=2 cellSpacing=1 bgcolor="#cccccc">
                                <TBODY>
                                  <tr class="tbtitle">
                                    <TD width="16%" align=center><span class="STYLE3">
                                    <input name="rrtype" type="hidden" id="rrtype" value="">
                                      <INPUT name=rtype
                        type=radio onclick=select_types(2); value="三全中" >
                                    三全中</span></TD>
                                    <TD width="16%" align=center><span class="STYLE3">
                                    <INPUT onclick=select_types(1); 
                        type=radio value="三中二" name=rtype>
                                    三中二</span></TD>
                                    <TD width="16%" align=center><span class="STYLE3">
                                    <INPUT onclick=select_types(3); 
                        type=radio value="二全中" name=rtype>
                                    二全中</span></TD>
                                    <TD width="16%" align=center><span class="STYLE3">
                                    <INPUT onclick=select_types(4); 
                        type=radio value="二中特" name=rtype>
                                    二中特</span></TD>
                                    <TD width="16%" align=center><span class="STYLE3">
                                    <INPUT onclick=select_types(5); 
                        type=radio value="特串" name=rtype>
                                    特串</span></TD>
                                    <TD width="16%" align=center><span class="STYLE3">
                                    <INPUT onclick=select_types(6); 
                        type=radio value="四中一" name=rtype>
                                    四中一</span></TD>
                                  </TR>
                                  <TR  class="Ball_tr_H">
                                    <TD width="16%" align="center" bgcolor="ffffff">三全中 <FONT color=#0000ff><B><?=round($drop_table[4][1],2)?></B></FONT></TD>
                                    <TD width="16%" align="center" bgcolor="ffffff">中二 <FONT color=#0000ff><B><?=round($drop_table[5][1],2)?></B></FONT><BR>
                                    中三 <FONT 
                        color=#0000ff><B><?=round($drop_table[6][1],2)?></B></FONT></TD>
                                    <TD width="16%" align="center" bgcolor="ffffff">二全中 <FONT color=#0000ff><B><?=round($drop_table[0][1],2)?></B></FONT></TD>
                                    <TD width="16%" align="center" bgcolor="ffffff">中特 <FONT color=#0000ff><B><?=round($drop_table[1][1],2)?></B></FONT><BR>
                                    中二 <FONT 
                        color=#0000ff><B><?=round($drop_table[2][1],2)?></B></FONT></TD>
                                    <TD width="16%" align="center" bgcolor="ffffff">特串 <FONT 
                    color=#0000ff><B><?=round($drop_table[3][1],2)?></B></FONT></TD>
                                    <TD width="16%" align="center" bgcolor="ffffff">四中一 <FONT 
                    color=#0000ff><B><?=round($drop_table[7][1],2)?></B></FONT></TD>
                                  </TR>
                                </TBODY>
                            </TABLE>
       
          <TABLE width="650"  border=0 cellPadding=0 cellSpacing=1  class="Ball_List">
            <TBODY>
							   
							   
                               <tr class="tbtitle">
                                  <TD width=28 height="28" align="center" class="td_caption_1"><span class="STYLE2">号码</span></TD>
                                  <TD width=110 align="center" class="td_caption_1"><span class="STYLE2">勾选</span></TD>
                                  <TD width=28 align="center" class="td_caption_1"><span class="STYLE2">号码</span></TD>
                                  <TD width=110 align="center" class="td_caption_1"><span class="STYLE2">勾选</span></TD>
                                  <TD width=28 align="center" class="td_caption_1"><span class="STYLE2">号码</span></TD>
                                  <TD width=110 align="center" class="td_caption_1"><span class="STYLE2">勾选</span></TD>
                                  <TD width=28 align="center" class="td_caption_1"><span class="STYLE2">号码</span></TD>
                                  <TD width=110 align="center" class="td_caption_1"><span class="STYLE2">勾选</span></TD>
                                  <TD width=28 align="center" class="td_caption_1"><span class="STYLE2">号码</span></TD>
                                  <TD width=110 align="center" class="td_caption_1"><span class="STYLE2">勾选</span></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_r"><img src="images/num01.gif" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,1) 
                        type=checkbox value=01 name=num1 id=num1></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num11.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,11) 
                        type=checkbox value=11 name=num11></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num21.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,21) 
                        type=checkbox value=21 name=num21></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num31.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,31) 
                        type=checkbox value=31 name=num31></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num41.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,41) 
                        type=checkbox value=41 name=num41></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_r"><img src="images/num02.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT name=num2 
                        type=checkbox onclick=SubChkBox(this,2) value=02 ></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num12.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,12) 
                        type=checkbox value=12 name=num12></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num22.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,22) 
                        type=checkbox value=22 name=num22></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num32.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,32) 
                        type=checkbox value=32 name=num32></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num42.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,42) 
                        type=checkbox value=42 name=num42></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num03.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,3) 
                        type=checkbox value=03 name=num3></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num13.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,13) 
                        type=checkbox value=13 name=num13></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num23.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,23) 
                        type=checkbox value=23 name=num23></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num33.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,33) 
                        type=checkbox value=33 name=num33></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num43.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,43) 
                        type=checkbox value=43 name=num43></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num04.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,4) 
                        type=checkbox value=04 name=num4></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num14.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,14) 
                        type=checkbox value=14 name=num14></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num24.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,24) 
                        type=checkbox value=24 name=num24></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num34.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,34) 
                        type=checkbox value=34 name=num34></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num44.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,44) 
                        type=checkbox value=44 name=num44></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_g"><span class="ball_r"><img src="images/num05.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,5) 
                        type=checkbox value=05 name=num5></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num15.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,15) 
                        type=checkbox value=15 name=num15></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num25.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,25) 
                        type=checkbox value=25 name=num25></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num35.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,35) 
                        type=checkbox value=35 name=num35></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num45.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,45) 
                        type=checkbox value=45 name=num45></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_g"><span class="ball_r"><img src="images/num06.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,6) 
                        type=checkbox value=06 name=num6></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num16.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,16) 
                        type=checkbox value=16 name=num16></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num26.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,26) 
                        type=checkbox value=26 name=num26></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num36.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,36) 
                        type=checkbox value=36 name=num36></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num46.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,46) 
                        type=checkbox value=46 name=num46></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_r"><img src="images/num07.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,7) 
                        type=checkbox value=07 name=num7></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num17.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,17) 
                        type=checkbox value=17 name=num17></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num27.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,27) 
                        type=checkbox value=27 name=num27></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num37.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,37) 
                        type=checkbox value=37 name=num37></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num47.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,47) 
                        type=checkbox value=47 name=num47></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_r"><img src="images/num08.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,8) 
                        type=checkbox value=08 name=num8></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num18.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,18) 
                        type=checkbox value=18 name=num18></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num28.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,28) 
                        type=checkbox value=28 name=num28></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num38.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,38) 
                        type=checkbox value=38 name=num38></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_r"><img src="images/num48.gif" width="27" height="27" /></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,48) 
                        type=checkbox value=48 name=num48></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num09.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,9) 
                        type=checkbox value=09 name=num9></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num19.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,19) 
                        type=checkbox value=19 name=num19></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num29.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,29) 
                        type=checkbox value=29 name=num29></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num39.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,39) 
                        type=checkbox value=39 name=num39></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num49.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,49) 
                        type=checkbox value=49 name=num49></TD>
                                </TR>
                                <TR>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num10.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,10) 
                        type=checkbox value=10 name=num10></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num20.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,20) 
                        type=checkbox value=20 name=num20></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num30.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT onclick=SubChkBox(this,30) 
                        type=checkbox value=30 name=num30></TD>
                                  <td align="center" bordercolordark="#f9f9f9" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num40.gif" width="27" height="27" /></span></td>
                                  <TD align=middle bgcolor="ffffff"><INPUT  onclick=SubChkBox(this,40) 
                        type=checkbox value=40 name=num40></TD>
                                  <TD colSpan=2 align=middle bgcolor="#FFFFFF">                                  </TD>
                                </TR>
                              </TBODY>
                          </TABLE>
                              
                            <DIV id=a2 style="DISPLAY:none ">
                                <table width="650" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
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
                                        肖串尾
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
                                <table width="650" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
                                  <tbody>
                                    <tr align="middle">
                                      <td align="center" class="Jut_caption_1">
                                         鼠
                                        <input name="pan1<?=Get_sx_nx(1)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(1)?>);javascript:ra_select('pan1','<?=Get_sx_nx(1)?>')" value="<?=Get_sx_nx(1)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">牛
                                        <input name="pan1<?=Get_sx_nx(7)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(7)?>);javascript:ra_select('pan1','<?=Get_sx_nx(7)?>')"  value="<?=Get_sx_nx(7)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">虎
                                        <input name="pan1<?=Get_sx_nx(2)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(2)?>);javascript:ra_select('pan1','<?=Get_sx_nx(2)?>')" value="<?=Get_sx_nx(2)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">兔
                                        <input name="pan1<?=Get_sx_nx(8)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(8)?>);javascript:ra_select('pan1','<?=Get_sx_nx(8)?>')"   value="<?=Get_sx_nx(8)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">龙
                                        <input name="pan1<?=Get_sx_nx(3)?>" type="radio"  onclick="r_pan1(<?=Get_sx_nx(3)?>);javascript:ra_select('pan1','<?=Get_sx_nx(3)?>')" value="<?=Get_sx_nx(3)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">蛇
                                        <input name="pan1<?=Get_sx_nx(9)?>" type="radio"  onclick="r_pan1(<?=Get_sx_nx(9)?>);javascript:ra_select('pan1','<?=Get_sx_nx(9)?>')"  value="<?=Get_sx_nx(9)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">马
                                        <input name="pan1<?=Get_sx_nx(4)?>" type="radio"  onclick="r_pan1(<?=Get_sx_nx(4)?>);javascript:ra_select('pan1','<?=Get_sx_nx(4)?>')"  value="<?=Get_sx_nx(4)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">羊
                                        <input name="pan1<?=Get_sx_nx(10)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(10)?>);javascript:ra_select('pan1','<?=Get_sx_nx(10)?>')"  value="<?=Get_sx_nx(10)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">猴
                                        <input name="pan1<?=Get_sx_nx(5)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(5)?>);javascript:ra_select('pan1','<?=Get_sx_nx(5)?>')"  value="<?=Get_sx_nx(5)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">鸡
                                        <input name="pan1<?=Get_sx_nx(11)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(11)?>);javascript:ra_select('pan1','<?=Get_sx_nx(11)?>')"  value="<?=Get_sx_nx(11)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">狗
                                        <input name="pan1<?=Get_sx_nx(6)?>" type="radio" onClick="r_pan1(<?=Get_sx_nx(6)?>);javascript:ra_select('pan1','<?=Get_sx_nx(6)?>')"  value="<?=Get_sx_nx(6)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">猪
                                      <input name="pan1<?=Get_sx_nx(12)?>" type="radio"  onclick="r_pan1(<?=Get_sx_nx(12)?>);javascript:ra_select('pan1','<?=Get_sx_nx(12)?>')" value="<?=Get_sx_nx(12)?>" />
                                          <input name="pan1" type="hidden" value="">
                                      </td>
                                    </tr>
                                    <tr align="middle">
                                      <td align="center" class="Jut_caption_1"><input name="pan2" type="hidden" value="">
                                        鼠
                                        <input name="pan2<?=Get_sx_nx(1)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(1)?>);javascript:ra_select('pan2','<?=Get_sx_nx(1)?>')" value="<?=Get_sx_nx(1)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">牛
                                        <input name="pan2<?=Get_sx_nx(7)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(7)?>);javascript:ra_select('pan2','<?=Get_sx_nx(7)?>')"  value="<?=Get_sx_nx(7)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">虎
                                        <input name="pan2<?=Get_sx_nx(2)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(2)?>);javascript:ra_select('pan2','<?=Get_sx_nx(2)?>')" value="<?=Get_sx_nx(2)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">兔
                                        <input name="pan2<?=Get_sx_nx(8)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(8)?>);javascript:ra_select('pan2','<?=Get_sx_nx(8)?>')"   value="<?=Get_sx_nx(8)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">龙
                                        <input name="pan2<?=Get_sx_nx(3)?>" type="radio"  onclick="r_pan2(<?=Get_sx_nx(3)?>);javascript:ra_select('pan2','<?=Get_sx_nx(3)?>')" value="<?=Get_sx_nx(3)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">蛇
                                        <input name="pan2<?=Get_sx_nx(9)?>" type="radio"  onclick="r_pan2(<?=Get_sx_nx(9)?>);javascript:ra_select('pan2','<?=Get_sx_nx(9)?>')"  value="<?=Get_sx_nx(9)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">马
                                        <input name="pan2<?=Get_sx_nx(4)?>" type="radio"  onclick="r_pan2(<?=Get_sx_nx(4)?>);javascript:ra_select('pan2','<?=Get_sx_nx(4)?>')"  value="<?=Get_sx_nx(4)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">羊
                                        <input name="pan2<?=Get_sx_nx(10)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(10)?>);javascript:ra_select('pan2','<?=Get_sx_nx(10)?>')"  value="<?=Get_sx_nx(10)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">猴
                                        <input name="pan2<?=Get_sx_nx(5)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(5)?>);javascript:ra_select('pan2','<?=Get_sx_nx(5)?>')"  value="<?=Get_sx_nx(5)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">鸡
                                        <input name="pan2<?=Get_sx_nx(11)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(11)?>);javascript:ra_select('pan2','<?=Get_sx_nx(11)?>')"  value="<?=Get_sx_nx(11)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">狗
                                        <input name="pan2<?=Get_sx_nx(6)?>" type="radio" onClick="r_pan2(<?=Get_sx_nx(6)?>);javascript:ra_select('pan2','<?=Get_sx_nx(6)?>')"  value="<?=Get_sx_nx(6)?>" />
                                      </td>
                                      <td align="center"class="Jut_caption_1">猪
                                      <input name="pan2<?=Get_sx_nx(12)?>" type="radio"  onclick="r_pan2(<?=Get_sx_nx(12)?>);javascript:ra_select('pan2','<?=Get_sx_nx(12)?>')" value="<?=Get_sx_nx(12)?>" /></td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                            <DIV id=a4 style="DISPLAY:none ">
                                <table width="650" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
                                  <tbody>
                                    <tr align="middle">
                                      <td align="center" class="Jut_caption_1"><input name="pan3" type="hidden" value="22">
                                        0尾
                                        <input name="pan30" type="radio" onClick="r_pan3(0);javascript:ra_select('pan3','0')"  value="0" />                                      </td>
                                      <td align="center" class="Jut_caption_1">1尾
                                      <input name="pan31" type="radio"  onclick="r_pan3(1);javascript:ra_select('pan3','1')"  value="1" />                                      </td>
                                      <td align="center" class="Jut_caption_1">2尾
                                      <input name="pan32" type="radio" onClick="r_pan3(2);javascript:ra_select('pan3','2')"  value="2" />                                      </td>
                                      <td align="center" class="Jut_caption_1">3尾
                                      <input name="pan33" type="radio" onClick="r_pan3(3);javascript:ra_select('pan3','3')"  value="3" />                                      </td>
                                      <td align="center" class="Jut_caption_1">4尾
                                      <input name="pan34" type="radio" onClick="r_pan3(4);javascript:ra_select('pan3','4')"  value="4" />                                      </td>
                                      <td align="center" class="Jut_caption_1">5尾
                                      <input name="pan35" type="radio"  onclick="r_pan3(5);javascript:ra_select('pan3','5')" value="5" />                                      </td>
                                      <td align="center" class="Jut_caption_1">6尾
                                      <input name="pan36" type="radio"  onclick="r_pan3(6);javascript:ra_select('pan3','6')" value="6" />                                      </td>
                                      <td align="center" class="Jut_caption_1">7尾
                                      <input name="pan37" type="radio" onClick="r_pan3(7);javascript:ra_select('pan3','7')"  value="7" />                                      </td>
                                      <td align="center" class="Jut_caption_1">8尾
                                      <input name="pan38" type="radio" onClick="r_pan3(8);javascript:ra_select('pan3','8')"  value="8" />                                      </td>
                                      <td align="center" class="Jut_caption_1">9尾
                                      <input name="pan39" type="radio" onClick="r_pan3(9);javascript:ra_select('pan3','9')"  value="9" />                                      </td>
                                    </tr>
                                    <tr align="middle">
                                      <td align="center"class="Jut_caption_1"><input name="pan4" type="hidden" value="11">
                                        0尾
                                        <input name="pan40" type="radio"  onclick="r_pan4(0);javascript:ra_select('pan4','0')" value="0" />                                      </td>
                                      <td align="center"class="Jut_caption_1">1尾
                                      <input name="pan41" type="radio" onClick="r_pan4(1);javascript:ra_select('pan4','1')"   value="1" />                                      </td>
                                      <td align="center"class="Jut_caption_1">2尾
                                      <input name="pan42" type="radio"  onclick="r_pan4(2);javascript:ra_select('pan4','2')" value="2" />                                      </td>
                                      <td align="center"class="Jut_caption_1">3尾
                                      <input name="pan43" type="radio" onClick="r_pan4(3);javascript:ra_select('pan4','3')"  value="3" />                                      </td>
                                      <td align="center"class="Jut_caption_1">4尾
                                      <input name="pan44" type="radio" onClick="r_pan4(4);javascript:ra_select('pan4','4')"  value="4" />                                      </td>
                                      <td align="center"class="Jut_caption_1">5尾
                                      <input name="pan45" type="radio" onClick="r_pan4(5);javascript:ra_select('pan4','5')" value="5" />                                      </td>
                                      <td align="center"class="Jut_caption_1">6尾
                                      <input name="pan46" type="radio" onClick="r_pan4(6);javascript:ra_select('pan4','6')"  value="6" />                                      </td>
                                      <td align="center"class="Jut_caption_1">7尾
                                      <input name="pan47" type="radio"  onclick="r_pan4(7);javascript:ra_select('pan4','7')" value="7" />                                      </td>
                                      <td align="center"class="Jut_caption_1">8尾
                                      <input name="pan48" type="radio" onClick="r_pan4(8);javascript:ra_select('pan4','8')"  value="8" />                                      </td>
                                      <td align="center"class="Jut_caption_1">9尾
                                      <input name="pan49" type="radio" onClick="r_pan4(9);javascript:ra_select('pan4','9')"  value="9" /></td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div></TD>
                        </TR>
                      </TBODY>
                    </TABLE>
                </TD>
              </TR>
            
            </TBODY>
            
</TABLE>
    </td>
  </tr>
</table>
<table width="650" border="0" cellpadding="0" cellspacing="1">
                                  <tbody>
                                    <tr align="middle">
                                      <td width="76%" bgcolor="ffffff">

                                      <INPUT type=submit value="投注"  class=but_c1 onMouseOver="this.className='but_c1M'"  onMouseOut="this.className='but_c1'" name=btnSubmit>
                                      <input type="reset" onClick="javascript:document.all.allgold.innerHTML =0;" class=but_c1 onMouseOver="this.className='but_c1M'"  onMouseOut="this.className='but_c1'" name="Submit3" value="重设" />
                                      </FORM>
                                      </td>
                                      </tr>
                                      </tbody>
                                      </table>