<? if(!defined('PHPYOU')) {
	exit('非法进入');
}





$ids="五肖连中";

$xc=51;

$XF=23;
function ka_kk1($i){   
   $result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='生肖连' and class2='".$ids."' and class3='".$i."' order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
return $ka_guanuserkk1[0];
   }



?>

<link rel="stylesheet" href="images/xp.css" type="text/css">

<?

if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#FDF4CA bgcolor=#FDF4CA>          <tr>            <td height=28 align=center bgcolor=0000FF><font color=ffff00>封盘中....</font></td>          </tr>      </table>"; 
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
</SCRIPT>


 <SCRIPT language=JAVASCRIPT>
<!--
var count_win=false;
//window.setTimeout("self.location='quickinput2.php'", 180000);
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
body {
	margin-left: 10px;
	margin-top: 10px;
}
.STYLE1 {color: #FFFFFF}
.STYLE4 {color: #333333; font-weight: bold; }
-->
 </style>
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <tr>
    <td height="2"></td>
  </tr></table>
<table width="680"   border="1" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bordercolordark="#f9f9f9" bgcolor="#FFFFFF">
  <form target="mem_order" name="lt_form"  method="post"  onSubmit="return SubChk(this);" action="index.php?action=k_sxt2save&class2=<?=$ids?>">
    <tr>
      <td height="28" colspan="8" align="center" nowrap="nowrap"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20%"><font color=ff0000 size="3"><b><?=$ids?></b></font></td>
		  <td width="20%"><font color=000000>封盘时间: <?=substr($Current_KitheTable[30],10,9)?> </font></td>
	      <td width="60%" ><div align="right">
            &nbsp;<button onClick="javascript:location.href='index.php?action=k_sxt2&ids=二肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:000000;'>二肖连中</span></button>&nbsp;<button onClick="javascript:location.href='index.php?action=k_sxt3&ids=三肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:000000;'>三肖连中</span></button>&nbsp;<button onClick="javascript:location.href='index.php?action=k_sxt4&ids=四肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:000000;'>四肖连中</span></button>
&nbsp;<button onClick="javascript:location.href='index.php?action=k_sxt5&ids=五肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:ff0000;'>五肖连中</span></button>            </div></td>
        </tr>
      </table></td>
    </tr>
     <tr class="tbtitle">
      <td width="41" height="28" align="center" nowrap="nowrap"><span class="STYLE54 STYLE1 STYLE1"> 号码</span></td>
      <td width="50" align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1 STYLE1">赔率</span></td>
      <td width="55" align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1 STYLE1">勾选</span></td>
      <td height="28" align="center" nowrap="nowrap" ><span class="STYLE1">号码</span></td>
	   <td width="41" height="28" align="center" nowrap="nowrap"><span class="STYLE54 STYLE1 STYLE1"> 号码</span></td>
      <td width="50" align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1 STYLE1">赔率</span></td>
      <td width="55" align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1 STYLE1">勾选</span></td>
      <td height="28" align="center" nowrap="nowrap" ><span class="STYLE1">号码</span></td>
    </tr>
    <?

for ($I=0; $I<=5; $I=$I+1)
{

	
	?>
	<tr>
      <td width="41" height="35" align="center"  bgcolor="#FDF4CA"><span class="STYLE4"><?=$drop_table[$I][0]?></span></td>
      <td width="50" height="25" align="center" valign="middle" class="ball_ff"><b><span id=bl<?=$I?>> 0 </span><span> </span></b></td>
      <td width="55" height="25" align="center" bgcolor="#FFFFFF"><input type="checkbox" name="num<?=$I+1?>" value="<?=$drop_table[$I][0]?>">
</td>
      <td height="25" bgcolor="f1f1f1"  ><table align=left><tr>
						<?
						
						
$result=mysql_query("Select m_number from ka_sxnumber where sx='".$drop_table[$I][0]."' order by id");
$image = mysql_fetch_array($result);
						
		$xxm=explode(",",$image['m_number']);	
		$ssc=count($xxm);
		for ($j=0; $j<$ssc; $j=$j+1){			
				
					
					?>
    						<td align=middle   height="32" width="32" class="ball_<?=Get_bs_Color(intval($xxm[$j]))?>"><img src="images/num<?=$xxm[$j]?>.gif" /></td>
    					<? } ?>
	</tr></table>	</td>
	
	
	
	
	<td width="41" height="35" align="center"  bgcolor="#FDF4CA"><span class="STYLE4"><?=$drop_table[$I+6][0]?></span></td>
      <td width="50" height="25" align="center" valign="middle" class="ball_ff"><b><span id=bl<?=$I+6?>> 0 </span><span> </span></b></td>
      <td width="55" height="25" align="center" bgcolor="#FFFFFF"><input type="checkbox" name="num<?=$I+7?>" value="<?=$drop_table[$I+6][0]?>"></td>
      <td height="25" bgcolor="f1f1f1"  ><table align=left><tr>
						<?
						
						
$result=mysql_query("Select m_number from ka_sxnumber where sx='".$drop_table[$I+6][0]."' order by id");
$image = mysql_fetch_array($result);
						
		$xxm=explode(",",$image['m_number']);	
		$ssc=count($xxm);
		for ($j=0; $j<$ssc; $j=$j+1){			
				
					
					?>
    						<td align=middle   height="32" width="32" class="ball_<?=Get_bs_Color(intval($xxm[$j]))?>"><img src="images/num<?=$xxm[$j]?>.gif" /></td>
    					<? } ?>
	</tr></table>	</td>
	
	
	
    </tr>
	
	
	

	
	<?
	

	 }?>
	 	<tr>
	  <td height="35" colspan="8" align="center"  bgcolor="#FFFFFF"><table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center">下注金额：</td>
          <td width="44" align="left"><input name="Num_1"  class="input1" id="Num_1" 
      style="HEIGHT: 18px" 
                        onfocus="CountGold(this,'focus');this.value='';" 
                        onblur="return CountGold(this,'blur','SP');" onkeypress="return CheckKey();" 
                        onkeyup="return CountGold(this,'keyup');" size="8" /></td>
          <td width="88" align="center"><input name="btnSubmit"    type="submit"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" id="btnSubmit" value="提交" /></td>
          <td width="88" align="center"><input type="button"  onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit3" value="重设" /></td>
        </tr>
      </table></td>
    </tr><INPUT type=hidden value=0 name=gold_all>
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
		   for(var i=0;i<12;i++)
{	   
		   arrTmp = arrResult[i].split("@@@");
		   


num1 = arrTmp[0]; //字段num1的值
num2 = arrTmp[1]; //字段num2的值
num3 = arrTmp[2]; //字段num1的值
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
	document.all[bl].innerHTML= num2;
	}
	
<?	break;
case "B":?>

if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$bsxp*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$bsxp*100?>")/100;}

	<?
	break;
	case "C":?>
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$csxp*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$csxp*100?>")/100;}

	<?
	break;
	case "D":?>

if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$dsxp*100?>")/100+"</b></font></span>";
	}else{

document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$dsxp*100?>")/100;}

	<? break;
    default:
	
	?>if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+num2+"</b></font></span>";
	}else{
	document.all[bl].innerHTML= num2;
	}
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
 makeRequest('index.php?action=server&class1=生肖连&class2=<?=$ids?>')
 </script>
