<? if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}





$ids="����";

$xc=25;

$XF=17;
function ka_kk1($i){   
   $result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='����' and class2='".$ids."' and class3='".$i."' order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
return $ka_guanuserkk1[0];
   }



?>

<link rel="stylesheet" href="images/xp.css" type="text/css">

<?

if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#FDF4CA bgcolor=#FDF4CA>          <tr>            <td height=28 align=center bgcolor=0000ff><font color=ffff00>������....</font></td>          </tr>      </table>"; 
  exit;
}




?>




<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>



 <SCRIPT language=JAVASCRIPT>
<!--
var count_win=false;
//window.setTimeout("self.location='quickinput2.php'", 180000);
function CheckKey(){
	if(event.keyCode == 13) return true;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("��ע��������������!!"); return false;}
}

function ChkSubmit(){
    //�趨��ȷ������Ϊ���� 
	document.all.btnSubmit.disabled = true;

	if (eval(document.all.allgold.innerHTML)<=0 )
	{
		alert("��������ע���!!");
	    document.all.btnSubmit.disabled = false;
		return false;

	}

       // if (!confirm("�Ƿ�ȷ����ע")){
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
//if (rtype=='SP' && (eval(eval(goldvalue)+eval(t_big1)) >eval(t_big2) )) {gold.focus(); alert("�޸�����!!"); return false;}
//}
		
		if ( (eval(goldvalue) < <?=ka_memuser("xy")?>) && (goldvalue!='')) {gold.focus(); alert("��ע����С�����޶�:<?=ka_memuser("xy")?>!!"); return false;}
		
		if (rtype=='SP' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds($xc,3)?>)) {gold.focus(); alert("�Բ���,ֹ�ű�����ע���������� : <?=ka_memds($xc,3)?>!!"); return false;}
		
		if (rtype=='SP' && (eval(goldvalue) > <?=ka_memds($xc,2)?>)) {gold.focus(); alert("�Բ���,��ע����ѳ�����ע�޶� : <?=ka_memds($xc,2)?>!!"); return false;}
		
	
		
		
		total_gold.value = document.all.allgold.innerHTML;
	  	if (eval(document.all.allgold.innerHTML) > <?=ka_memuser("ts")?>)   {gold.focus(); alert("��ע���ɴ�춿������ö��!!");    return false;}
		
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
body {
	margin-left: 10px;
	margin-top: 10px;
}
.STYLE1 {color: #FFFFFF}
.STYLE4 {color: #333333; font-weight: bold; }
-->
 </style>
<noscript>
<iframe scr=��*.htm��></iframe>
</noscript>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <tr>
    <td height="2"></td>
  </tr></table>
<table width="640"   border="1" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bordercolordark="#f9f9f9" bgcolor="#FFFFFF">
  <form target="mem_order" name="lt_form"  method="post" action="index.php?action=n1&class2=<?=$ids?>">
    <tr>
      <td height="28" colspan="4" align="center" nowrap="nowrap"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
     <td width="27%"><font color=ff0000 size="3"><b><?=$ids?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000">��ע���:<span id=allgold>0</span></font></td> <td width="18%" align="right" ><span class="STYLE1"><font color=000000>���̵���ʱ:</font></span></td>
<td width="25%" ><font color="#FF0000"><strong><span id="span_dt_dt"></span></strong></font>
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
span_dt_dt.innerHTML=daysold+"��"+hrsold+"Сʱ"+minsold+"��"+seconds+"��" ; 
}else if(hrsold>0){
span_dt_dt.innerHTML=hrsold+"Сʱ"+minsold+"��"+seconds+"��" ; 
}else if(minsold>0){
span_dt_dt.innerHTML=minsold+"��"+seconds+"��" ; 
}else{
span_dt_dt.innerHTML=seconds+"��" ; 

}
if (daysold<=0 && hrsold<=0  && minsold<=0 && seconds<=0)
window.setTimeout("self.location='index.php?action=stop'", 1);
} 
show_student163_time(); 
</SCRIPT></font></td>
          <td ><div align="right">
          </div></td>
        </tr>
      </table></td>
    </tr>
     <tr class="tbtitle">
      <td width="41" height="28" align="center" nowrap="nowrap"><span class="STYLE54 STYLE1 STYLE1"> ����</span></td>
      <td width="50" align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1 STYLE1">����</span></td>
      <td width="55" align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1 STYLE1">���</span></td>
      <td width="473" height="28" align="center" nowrap="nowrap" ><span class="STYLE1">����</span></td>
    </tr>
    <tr>
      <td width="41" height="35" align="center"  bgcolor="#FDF4CA"><span class="STYLE4">��</span></td>
      <td width="50" height="25" align="center" valign="middle" class="ball_ff"><b><span id=bl0> 0 </span><span> </span></b></td>
      <td width="55" height="25" align="center" bgcolor="#FFFFFF"><input onKeyPress="return CheckKey();" 
                        onBlur="return CountGold(this,'blur','SP','<?=ka_kk1("��")?>','1');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="4" name="Num_1" />
          <input name="class3_1" value="1" type="hidden" >
          <input name="gb1" type="hidden"  value="0">
          <input name="xr_0" type="hidden" id="xr_0" value="0" >
          <input name="xrr_1" type="hidden"  value="0" ></td>
      <td height="25" bgcolor="f1f1f1"  ><table align=left><tr>
						<?
						
						
$result=mysql_query("Select m_number from ka_sxnumber where id=25 order by id");
$image = mysql_fetch_array($result);
						
		$xxm=explode(",",$image['m_number']);	
		$ssc=count($xxm);
		for ($j=0; $j<$ssc; $j=$j+1){			
				
					
					?>
    						<td align=middle   height="32" width="32" class="ball_<?=Get_bs_Color(intval($xxm[$j]))?>"><img src="images/num<?=$xxm[$j]?>.gif" /></td>
    					<? } ?>
	</tr></table>
	
	
	</td>
    </tr>
    <tr>
      <td width="41" height="35" align="center"  bgcolor="#FDF4CA"><span class="STYLE4">ľ</span></td>
      <td width="50" height="25" align="center" valign="middle" class="ball_ff"><b><span id=bl1> 0 </span><span> </span></b></td>
      <td width="55" height="25" align="center" bgcolor="#FFFFFF"><input onKeyPress="return CheckKey();" 
                        onBlur="return CountGold(this,'blur','SP','<?=ka_kk1("ľ")?>','2');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="4" name="Num_2" />
          <input name="class3_2" value="2" type="hidden" >
          <input name="gb2" type="hidden"  value="0">
		  
		   <input name="xr_1" type="hidden" id="xr_1" value="0" >
          <input name="xrr_2" type="hidden" id="xrr_2" value="0" ></td>
      <td height="25" bgcolor="f1f1f1"  ><table align="left">
        <tr>
          <?
						
						
$result=mysql_query("Select m_number from ka_sxnumber where id=26 order by id");
$image = mysql_fetch_array($result);
						
		$xxm=explode(",",$image['m_number']);	
		$ssc=count($xxm);
		for ($j=0; $j<$ssc; $j=$j+1){			
				
					
					?>
          <td align="middle"   height="32" width="32" class="ball_<?=Get_bs_Color(intval($xxm[$j]))?>"><img src="images/num<?=$xxm[$j]?>.gif" /></td>
          <? } ?>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td width="41" height="35" align="center"  bgcolor="#FDF4CA"><span class="STYLE4">ˮ</span></td>
      <td width="50" height="25" align="center" valign="middle" class="ball_ff"><b><span id=bl2> 
	  0 </span><span> </span></b></td>
      <td width="55" height="25" align="center" bgcolor="#FFFFFF"><input onKeyPress="return CheckKey();" 
                        onBlur="return CountGold(this,'blur','SP','<?=ka_kk1("ˮ")?>','3');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="4" name="Num_3" />
          <input name="class3_3" value="3" type="hidden" >
          <input name="gb3" type="hidden"  value="0">
		   <input name="xr_2" type="hidden" id="xr_2" value="0" >
          <input name="xrr_3" type="hidden" id="xrr_3" value="0" >		  </td>
      <td height="25" bgcolor="f1f1f1"  ><table align="left">
        <tr>
          <?
						
						
$result=mysql_query("Select m_number from ka_sxnumber where id=27 order by id");
$image = mysql_fetch_array($result);
						
		$xxm=explode(",",$image['m_number']);	
		$ssc=count($xxm);
		for ($j=0; $j<$ssc; $j=$j+1){			
				
					
					?>
          <td align="middle"   height="32" width="32" class="ball_<?=Get_bs_Color(intval($xxm[$j]))?>"><img src="images/num<?=$xxm[$j]?>.gif" /></td>
          <? } ?>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td width="41" height="35" align="center"  bgcolor="#FDF4CA"><span class="STYLE4">��</span></td>
      <td width="50" height="25" align="center" valign="middle" class="ball_ff"><b><span id=bl3>0</span><span> </span></b></td>
      <td width="55" height="25" align="center" bgcolor="#FFFFFF"><input onKeyPress="return CheckKey();" 
                        onBlur="return CountGold(this,'blur','SP','<?=ka_kk1("��")?>','4');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="4" name="Num_4" />
          <input name="class3_4" value="4" type="hidden" >
          <input name="gb4" type="hidden"  value="0">
		  
		   <input name="xr_3" type="hidden" id="xr_3" value="0" >
          <input name="xrr_4" type="hidden" id="xrr_4" value="0" ></td>
      <td height="25" bgcolor="f1f1f1"  ><table align="left">
        <tr>
          <?
						
						
$result=mysql_query("Select m_number from ka_sxnumber where id=28 order by id");
$image = mysql_fetch_array($result);
						
		$xxm=explode(",",$image['m_number']);	
		$ssc=count($xxm);
		for ($j=0; $j<$ssc; $j=$j+1){			
				
					
					?>
          <td align="middle"   height="32" width="32" class="ball_<?=Get_bs_Color(intval($xxm[$j]))?>"><img src="images/num<?=$xxm[$j]?>.gif" /></td>
          <? } ?>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td width="41" height="35" align="center"  bgcolor="#FDF4CA"><span class="STYLE4">��</span></td>
      <td width="50" height="25" align="center" valign="middle" class="ball_ff"><b><span id=bl4>0</span><span> </span></b></td>
      <td width="55" height="25" align="center" bgcolor="#FFFFFF"><input onKeyPress="return CheckKey();" 
                        onBlur="return CountGold(this,'blur','SP','<?=ka_kk1("��")?>','5');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="4" name="Num_5" />
          <input name="class3_5" value="5" type="hidden" >
          <input name="gb5" type="hidden"  value="0">
		  <input name="xr_4" type="hidden"  value="0" >
          <input name="xrr_5" type="hidden"  value="0" >		  </td>
      <td height="25" bgcolor="f1f1f1"  ><table align="left">
        <tr>
          <?
						
						
$result=mysql_query("Select m_number from ka_sxnumber where id=29 order by id");
$image = mysql_fetch_array($result);
						
		$xxm=explode(",",$image['m_number']);	
		$ssc=count($xxm);
		for ($j=0; $j<$ssc; $j=$j+1){			
				
					
					?>
          <td align="middle"   height="32" width="32" class="ball_<?=Get_bs_Color(intval($xxm[$j]))?>"><img src="images/num<?=intval($xxm[$j])?>.gif" /></td>
          <? } ?>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td height="25" colspan="4" align="center" bgcolor="#FFFFFF"><table border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td align="center"><input name="btnSubmit"   onclick="return ChkSubmit();" type="submit"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" id="btnSubmit" value="�ύ" /></td>
            <td align="center"><input type="reset" onclick="javascript:document.all.allgold.innerHTML =0;"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit3" value="����" /></td>
            <td>&nbsp;</td>
          </tr>
            </table></td>
      <INPUT type="hidden"  value=0 name=gold_all>
  </form>
  <INPUT  type="hidden" value=0 name=total_gold>
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
		   for(var i=0;i<5;i++)
{	   
		   arrTmp = arrResult[i].split("@@@");
		   


num1 = arrTmp[0]; //�ֶ�num1��ֵ
num2 = parseFloat(arrTmp[1]).toFixed(2); //�ֶ�num2��ֵ
num3 = parseFloat(arrTmp[2]).toFixed(2); //�ֶ�num1��ֵ
num4 = arrTmp[3]; //�ֶ�num2��ֵ
num5 = arrTmp[4]; //�ֶ�num2��ֵ
num6 = arrTmp[5]; //�ֶ�num2��ֵ


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
document.all[bl].innerHTML= "ͣ";
}else{
<? $bb=ka_memuser("abcd");
 switch ($bb){
	case "A": ?>
	if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+num2+"</b></font></span>";
	}else{
	document.all[bl].innerHTML= num2;}
	
<?	break;
case "B":?>if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$bzm6*100?>")/100+"</b></font></span>";
	}else{

document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$bzm6*100?>")/100;}

	<?
	break;
	case "C":?>
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$czm6*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$czm6*100?>")/100;}

	<?
	break;
	case "D":?>


if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$dzm6*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$dzm6*100?>")/100;}

	<? break;
    default:
	
	?>
	if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$dzm6*100?>")/100+"</b></font></span>";
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
	//���ܣ���pageURLҳ�淢�����ݣ�����ΪstrPara
	//���ش����������ص�����
	var oBao = new ActiveXObject("Microsoft.XMLHTTP");
	//�����ַ���+,%,&,=,?�ȵĴ������취.�ַ�������escape�����.
	oBao.open("GET",pageURL+"?commandName="+commandName+"&"+strPara,false);
	oBao.send();
	//�������˴����ص��Ǿ���escape������ַ���.
	var strResult = unescape(oBao.responseText);
	return strResult;
}


</script>

<SCRIPT language=javascript>
 makeRequest('index.php?action=server&class1=����&class2=<?=$ids?>')
 </script>
