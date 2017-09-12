<? if(!defined('PHPYOU')) {
	exit('非法进入');
}







if ($_GET['ids']!="") {$ids=$_GET['ids'];}else{$ids="正1特";}


if ($ids=="正1特") {
$z6color="000000";
$z5color="000000";
$z4color="000000";
$z3color="000000";
$z2color="000000";
$z1color="ff0000";
}elseif ($ids=="正2特"){
$z6color="000000";
$z5color="000000";
$z4color="000000";
$z3color="000000";
$z1color="000000";
$z2color="ff0000";

}elseif ($ids=="正3特"){
$z6color="000000";
$z5color="000000";
$z4color="000000";
$z2color="000000";
$z1color="000000";
$z3color="ff0000";
}elseif ($ids=="正4特"){
$z6color="000000";
$z5color="000000";
$z2color="000000";
$z3color="000000";
$z1color="000000";
$z4color="ff0000";
}elseif ($ids=="正5特"){
$z6color="000000";
$z2color="000000";
$z4color="000000";
$z3color="000000";
$z1color="000000";
$z5color="ff0000";
}elseif ($ids=="正6特"){
$z2color="000000";
$z5color="000000";
$z4color="000000";
$z3color="000000";
$z1color="000000";
$z6color="ff0000";
}

$XF=13;

$xc=5;
function ka_kk1($i){   
   $result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='正特' and class2='".$ids."' and class3='".$i."' order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
return $ka_guanuserkk1[0];
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

	if (eval(document.all.allgold.innerHTML)<=0 )
	{
		alert("请输入下注金额!!");
	    document.all.btnSubmit.disabled = false;
		return false;
	}
		document.all.gold_all.value=eval(document.all.allgold.innerHTML)
        document.lt_form.submit();
       document.all.allgold.innerHTML=0;
			document.all.Num_1.value='';
			document.all.Num_2.value='';
			document.all.Num_3.value='';
			document.all.Num_4.value='';
			document.all.Num_5.value='';
			document.all.Num_6.value='';
			document.all.Num_7.value='';
			document.all.Num_8.value='';
			document.all.Num_9.value='';
			document.all.Num_10.value='';
			document.all.Num_11.value='';
			document.all.Num_12.value='';
			document.all.Num_13.value='';
			document.all.Num_14.value='';
			document.all.Num_15.value='';
			document.all.Num_16.value='';
			document.all.Num_17.value='';
			document.all.Num_18.value='';
			document.all.Num_19.value='';
			document.all.Num_20.value='';
			document.all.Num_21.value='';
			document.all.Num_22.value='';
			document.all.Num_23.value='';
			document.all.Num_24.value='';
			document.all.Num_25.value='';
			document.all.Num_26.value='';
			document.all.Num_27.value='';
			document.all.Num_28.value='';
			document.all.Num_29.value='';
			document.all.Num_30.value='';
			document.all.Num_31.value='';
			document.all.Num_32.value='';
			document.all.Num_33.value='';
			document.all.Num_34.value='';
			document.all.Num_35.value='';
			document.all.Num_36.value='';
			document.all.Num_37.value='';
			document.all.Num_38.value='';
			document.all.Num_39.value='';
			document.all.Num_40.value='';
			document.all.Num_41.value='';
			document.all.Num_42.value='';
			document.all.Num_43.value='';
			document.all.Num_44.value='';
			document.all.Num_45.value='';
			document.all.Num_46.value='';
			document.all.Num_47.value='';
			document.all.Num_48.value='';
			document.all.Num_49.value='';
			document.all.Num_50.value='';
			document.all.Num_51.value='';
			document.all.Num_52.value='';
			document.all.Num_53.value='';
			document.all.Num_54.value='';
			document.all.Num_55.value='';
			document.all.Num_56.value='';
			document.all.Num_57.value='';
			document.all.Num_58.value='';
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
		
		if (rtype=='SP' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds($xc,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds($xc,3)?>!!"); return false;}
		
		if (rtype=='SP' && (eval(goldvalue) > <?=ka_memds($xc,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds($xc,2)?>!!"); return false;}
		
		
		if (rtype=='dx' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(2,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(2,3)?>!!"); return false;}
		
		if (rtype=='dx' && (eval(goldvalue) > <?=ka_memds(2,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds(2,2)?>!!"); return false;}
		
		
		if (rtype=='ds' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(3,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(3,3)?>!!"); return false;}
		if (rtype=='ds' && (eval(goldvalue) > <?=ka_memds(3,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds(3,2)?>!!"); return false;}
		
		if (rtype=='hd' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(4,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(4,3)?>!!"); return false;}
		if (rtype=='hd' && (eval(goldvalue) > <?=ka_memds(4,2)?>)) {gold.focus(); alert("对不起,单注限额最高限制 : <?=ka_memds(4,2)?>!!"); return false;}
		
		if (rtype=='sb' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(10,2)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(10,3)?>!!"); return false;}
		if (rtype=='sb' && (eval(goldvalue) > <?=ka_memds(10,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds(10,2)?>!!"); return false;}
		
		
		
		
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
-->
 </style>
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<TABLE  border="0" cellpadding="2" cellspacing="1" bordercolordark="#f9f9f9" bgcolor="#CCCCCC"width=650 >
  <TR class="tbtitle">
    <TD ><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td height=25><SPAN id=Lottery_Type_Name>当前期数: </SPAN>【第<?=$Current_Kithe_Num?>期】 <span id=allgold style="display:none">0</span></TD>
    <TD align=right colSpan=3>
     <button onclick="javascript:location.href='index.php?action=k_zt&amp;ids=正1特';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><span id="rtm1" style='color:<?=$z1color?>;'>正1特</span></button><button onclick="javascript:location.href='index.php?action=k_zt&amp;ids=正2特';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><span id="rtm2" style='color:<?=$z2color?>;'>正2特</span></button><button onclick="javascript:location.href='index.php?action=k_zt&amp;ids=正3特';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><span id="rtm2" style='color:<?=$z3color?>;'>正3特</span></button><button onclick="javascript:location.href='index.php?action=k_zt&amp;ids=正4特';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><span id="rtm2" style='color:<?=$z4color?>;'>正4特</span></button><button onclick="javascript:location.href='index.php?action=k_zt&amp;ids=正5特';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><span id="rtm2" style='color:<?=$z5color?>;'>正5特</span></button><button onclick="javascript:location.href='index.php?action=k_zt&amp;ids=正6特';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" /><span id="rtm2" style='color:<?=$z6color?>;'>正6特</span></button>
	<button onClick="javascript:parent.mem_order.location.href='index.php?action=n55&class2=<?=$ids?>&ids=<?=$ids?>';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ;><img src="imgs/refer-1.gif" width="16" height="16" align="absmiddle" /><span id="Span2" style='color:000000;'>快速投注</span></button>&nbsp;
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
      id=Update_Time></SPAN>&nbsp;<INPUT class="but_c1" style="LEFT: 0px; WIDTH: 64px; POSITION: relative; TOP: 0px; HEIGHT: 18px" onfocus=this.blur() onclick="beginrefresh();" type=button value=重新整理 name=LoadingPL>&nbsp;</TD></TR></TBODY></TABLE></td>
  </tr>
      </table>




<form target="mem_order" name="lt_form"  method="post" action="index.php?action=n1&class2=<?=$ids?>" style="height:580px;">
<TABLE cellSpacing=1 cellPadding=0 width=650 border=0 class="Ball_List" >  

     <tr class="tbtitle">
      <td width="28" class=td_caption_1 height="28" align="center" nowrap="nowrap"><span class="STYLE54 STYLE1"> 号码</span></td>
      <td width="44" class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1">赔率</span></td>
      <td class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1">金额</span></td>
      <td width="28" class=td_caption_1 height="28" align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1"> 号码</span></td>
      <td width="44" class=td_caption_1 align="center" nowrap="nowrap"><span class="STYLE54 STYLE1">赔率</span></td>
      <td class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1">金额</span></td>
      <td width="28" class=td_caption_1 height="28" align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1"> 号码</span></td>
      <td width="44" class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1">赔率</span></td>
      <td class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1">金额</span></td>
      <td width="28" class=td_caption_1 height="28" align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1"> 号码</span></td>
      <td width="44" class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1">赔率</span></td>
      <td class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1">金额</span></td>
      <td width="28" class=td_caption_1 height="28" align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1"> 号码</span></td>
      <td width="44" class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1">赔率</span></td>
      <td class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1">金额</span></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#EFEFEF" class="ball_r"><img src="images/num01.gif" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl0> 0 </span><span> </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(1)?>','1');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_1" ID="Num_1"  />
          <input name="class3_1" value="1" type="hidden" >
          <input name="gb1" type="hidden"  value="0">
          <input name="xr_0" type="hidden" id="xr_0" value="0" >
          <input name="xrr_1" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num11.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl10> 0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(11)?>','11');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px"  class="input1" size="3" name="Num_11" id="Num_11"/>
          <input name="class3_11" value="11" type="hidden" >
          <input name="gb11" type="hidden"  value="0">
		    <input name="xr_10" type="hidden" id="xr_10" value="0" >
          <input name="xrr_11" type="hidden"  value="0" >		  </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num21.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl20>0 </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(21)?>','21');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_21"  id="Num_21"/>
          <input name="gb21" type="hidden"  value="0">
          <input name="class3_21" value="21" type="hidden" >
		   <input name="xr_20" type="hidden" id="xr_20" value="0" >
          <input name="xrr_21" type="hidden" id="xrr_21" value="0">		  </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num31.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl30> 0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(31)?>','31');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_31" id="Num_31"/>
          <input name="class3_31" value="31" type="hidden" >
          <input name="gb31" type="hidden"  value="0">
		   <input name="xr_30" type="hidden" id="xr_30" value="0" >
          <input name="xrr_31" type="hidden" id="xrr_31" value="0">		  </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num41.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl40> 0 </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(41)?>','41');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_41"  id="Num_41" />
          <input name="class3_41" value="41" type="hidden" >
          <input name="gb41" type="hidden"  value="0">
		   <input name="xr_40" type="hidden" id="xr_40" value="0" >
          <input name="xrr_41" type="hidden" id="xrr_41" value="0"></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#EFEFEF" class="ball_r"><img src="images/num02.gif" width="27" height="27" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl1> 0 </span><span> </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(2)?>','2');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_2" id="Num_2"/>
          <input name="class3_2" value="2" type="hidden" >
          <input name="gb2" type="hidden"  value="0">
		  
		   <input name="xr_1" type="hidden" id="xr_1" value="0" >
          <input name="xrr_2" type="hidden" id="xrr_2" value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num12.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl11> 0 </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(12)?>','12');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px"  class="input1" size="3" name="Num_12"  id="Num_12"/>
          <input name="class3_12" value="12" type="hidden" >
          <input name="gb12" type="hidden"  value="0">
		   <input name="xr_11" type="hidden" id="xr_11" value="0" >
          <input name="xrr_12" type="hidden" id="xrr_12" value="0" >		  </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num22.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl21> 0 </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(22)?>','22');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_22" id="Num_22"/>
          <input name="gb22" type="hidden"  value="0">
          <input name="class3_22" value="22" type="hidden" >
		   <input name="xr_21" type="hidden" id="xr_21" value="0" >
          <input name="xrr_22" type="hidden" id="xrr_22" value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num32.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl31> 0 </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(32)?>','32');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_32" id="Num_32"/>
          <input name="class3_32" value="32" type="hidden" >
          <input name="gb32" type="hidden"  value="0">
		  
		   <input name="xr_31" type="hidden" id="xr_31" value="0" >
          <input name="xrr_32" type="hidden" id="xrr_32" value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num42.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl41> 0 </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(42)?>','42');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_42" id="Num_42" />
          <input name="class3_42" value="42" type="hidden" >
          <input name="gb42" type="hidden"  value="0">
		   <input name="xr_41" type="hidden" id="xr_41" value="0" >
          <input name="xrr_42" type="hidden" id="xrr_42" value="0" ></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num03.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl2> 
	  0 </span><span> </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(3)?>','3');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_3" id="Num_3" />
          <input name="class3_3" value="3" type="hidden" >
          <input name="gb3" type="hidden"  value="0">
		   <input name="xr_2" type="hidden" id="xr_2" value="0" >
          <input name="xrr_3" type="hidden" id="xrr_3" value="0" >		  </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num13.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl12>  0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(13)?>','13');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px"  class="input1" size="3" name="Num_13"  id="Num_13"/>
          <input name="class3_13" value="13" type="hidden" >
          <input name="gb13" type="hidden"  value="0">
		  
		   <input name="xr_12" type="hidden" id="xr_12" value="0" >
          <input name="xrr_13" type="hidden" id="xrr_13" value="0" >		  </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num23.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl22>0 </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(23)?>','23');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_23" id="Num_23"/>
          <input name="gb23" type="hidden"  value="0">
          <input name="class3_23" value="23" type="hidden" >
		   <input name="xr_22" type="hidden" id="xr_22" value="0" >
          <input name="xrr_23" type="hidden" id="xrr_23" value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num33.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl32>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(33)?>','33');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_33" id="Num_33" />
          <input name="class3_33" value="33" type="hidden" >
          <input name="gb33" type="hidden"  value="0">
		   <input name="xr_32" type="hidden" id="xr_32" value="0" >
          <input name="xrr_33" type="hidden" id="xrr_33" value="0" >		  </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num43.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl42>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(43)?>','43');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_43" id="Num_43" />
          <input name="class3_43" value="43" type="hidden" >
          <input name="gb43" type="hidden"  value="0">
		  
		   <input name="xr_42" type="hidden" id="xr_42" value="0" >
          <input name="xrr_43" type="hidden" id="xrr_43" value="0" ></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num04.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl3>0</span><span> </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(4)?>','4');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_4" id="Num_4"/>
          <input name="class3_4" value="4" type="hidden" >
          <input name="gb4" type="hidden"  value="0">
		  
		   <input name="xr_3" type="hidden" id="xr_3" value="0" >
          <input name="xrr_4" type="hidden" id="xrr_4" value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num14.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl13>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(14)?>','14');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px"  class="input1" size="3" name="Num_14"  id="Num_14"/>
          <input name="class3_14" value="14" type="hidden" >
          <input name="gb14" type="hidden"  value="0">
		  
		  <input name="xr_13" type="hidden" id="xr_13" value="0" >
          <input name="xrr_14" type="hidden" id="xrr_14" value="0" >		  </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num24.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl23>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onkeypress="return CheckKey();" 
                        onblur="return CountGold(this,'blur','SP','<?=ka_kk1(24)?>','24');" 
                        onkeyup="return CountGold(this,'keyup');" 
                        onfocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_24"  id="Num_24" />
      <input name="gb24" type="hidden"  value="0">
          <input name="class3_24" value="24" type="hidden" >
		  <input name="xr_23" type="hidden" id="xr_23" value="0" >
          <input name="xrr_24" type="hidden" id="xrr_24" value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num34.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl33>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(34)?>','34');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_34" id="Num_34" />
          <input name="class3_34" value="34" type="hidden" >
          <input name="gb34" type="hidden"  value="0">
		  
		  <input name="xr_33" type="hidden" id="xr_33" value="0" >
          <input name="xrr_34" type="hidden" id="xrr_34" value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num44.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl43>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(44)?>','44');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_44" id="Num_44" />
          <input name="class3_44" value="44" type="hidden" >
          <input name="gb44" type="hidden"  value="0">
		  
		  <input name="xr_43" type="hidden" id="xr_43" value="0" >
          <input name="xrr_44" type="hidden" id="xrr_44" value="0" ></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#EFEFEF" class="ball_g"><span class="ball_r"><img src="images/num05.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl4>0</span><span> </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(5)?>','5');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_5" id="Num_5"/>
          <input name="class3_5" value="5" type="hidden" >
          <input name="gb5" type="hidden"  value="0">
		  <input name="xr_4" type="hidden"  value="0" >
          <input name="xrr_5" type="hidden"  value="0" >		  </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num15.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl14>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(15)?>','15');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px"  class="input1" size="3" name="Num_15"  id="Num_15" />
          <input name="class3_15" value="15" type="hidden" >
          <input name="gb15" type="hidden"  value="0">
		  
		    <input name="xr_14" type="hidden"  value="0" >
          <input name="xrr_15" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num25.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl24>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(25)?>','25');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_25" id="Num_25" />
          <input name="gb25" type="hidden"  value="0">
          <input name="class3_25" value="25" type="hidden" >
		    <input name="xr_24" type="hidden"  value="0" >
          <input name="xrr_25" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num35.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl34>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(35)?>','35');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_35" id="Num_35"  />
          <input name="class3_35" value="35" type="hidden" >
          <input name="gb35" type="hidden"  value="0">
		    <input name="xr_34" type="hidden"  value="0" >
          <input name="xrr_35" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num45.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl44>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(45)?>','45');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_45"  id="Num_45" />
          <input name="class3_45" value="45" type="hidden" >
          <input name="gb45" type="hidden"  value="0">
		  
		    <input name="xr_44" type="hidden"  value="0" >
          <input name="xrr_45" type="hidden"  value="0" ></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#EFEFEF" class="ball_g"><span class="ball_r"><img src="images/num06.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl5>0</span><span> </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(6)?>','6');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_6"  id="Num_6"/>
          <input name="class3_6" value="6" type="hidden" >
          <input name="gb6" type="hidden"  value="0">
          <input name="xr_5" type="hidden"  value="0" >
          <input name="xrr_6" type="hidden"  value="0" >     </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num16.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl15> 0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(16)?>','16');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px"  class="input1" size="3" name="Num_16" id="Num_16"/>
          <input name="class3_16" value="16" type="hidden" >
          <input name="gb16" type="hidden"  value="0">
		  
		    <input name="xr_15" type="hidden"  value="0" >
          <input name="xrr_16" type="hidden"  value="0" > </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num26.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl25>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(26)?>','26');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_26" id="Num_26" />
          <input name="gb26" type="hidden"  value="0">
          <input name="class3_26" value="26" type="hidden" >
		  
		    <input name="xr_25" type="hidden"  value="0" >
          <input name="xrr_26" type="hidden"  value="0" > </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num36.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl35>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(36)?>','36');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_36" id="Num_36" />
          <input name="class3_36" value="36" type="hidden" >
          <input name="gb36" type="hidden"  value="0">
		  
		    <input name="xr_35" type="hidden"  value="0" >
          <input name="xrr_36" type="hidden"  value="0" > </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_g"><span class="ball_r"><img src="images/num46.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl45>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(46)?>','46');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_46" id="Num_46" />
          <input name="class3_46" value="46" type="hidden" >
          <input name="gb46" type="hidden"  value="0">
		  
		    <input name="xr_45" type="hidden"  value="0" >
          <input name="xrr_46" type="hidden"  value="0" > </td>
    </tr>
    <tr>
      <td align="center" bgcolor="#EFEFEF" class="ball_r"><img src="images/num07.gif" width="27" height="27" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl6>0</span><span> </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(7)?>','7');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_7"  id="Num_7" />
          <input name="class3_7" value="7" type="hidden" >
          <input name="gb7" type="hidden"  value="0">
		  
		    <input name="xr_6" type="hidden"  value="0" >
          <input name="xrr_7" type="hidden"  value="0" > </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num17.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl16>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(17)?>','17');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px"  class="input1" size="3" name="Num_17"  id="Num_17"/>
          <input name="class3_17" value="17" type="hidden" >
          <input name="gb17" type="hidden"  value="0">
		  
		   <input name="xr_16" type="hidden"  value="0" >
          <input name="xrr_17" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num27.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl26>0 </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(27)?>','27');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_27" id="Num_27"/>
          <input name="gb27" type="hidden"  value="0">
          <input name="class3_27" value="27" type="hidden" >
          <input name="xr_26" type="hidden"  value="0" >
          <input name="xrr_27" type="hidden"  value="0" >    </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num37.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl36>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(37)?>','37');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_37"  id="Num_37"  />
          <input name="class3_37" value="37" type="hidden" >
          <input name="gb37" type="hidden"  value="0">
		  
		   <input name="xr_36" type="hidden"  value="0" >
          <input name="xrr_37" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num47.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl46>0 </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(47)?>','47');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_47" id="Num_47"  />
          <input name="class3_47" value="47" type="hidden" >
          <input name="gb47" type="hidden"  value="0">
		   <input name="xr_46" type="hidden"  value="0" >
          <input name="xrr_47" type="hidden"  value="0" ></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#EFEFEF" class="ball_r"><img src="images/num08.gif" width="27" height="27" /></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl7>0 </span><span> </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(8)?>','8');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_8"  id="Num_8"/>
          <input name="class3_8" value="8" type="hidden" >
          <input name="gb8" type="hidden"  value="0">
		  
		   <input name="xr_7" type="hidden"  value="0" >
          <input name="xrr_8" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num18.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl17>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(18)?>','18');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px"  class="input1" size="3" name="Num_18"  id="Num_18" />
          <input name="class3_18" value="18" type="hidden" >
          <input name="gb18" type="hidden"  value="0">
		  
		    <input name="xr_17" type="hidden"  value="0" >
          <input name="xrr_18" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num28.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl27>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(28)?>','28');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_28"  id="Num_28" />
          <input name="gb28" type="hidden"  value="0">
          <input name="class3_28" value="28" type="hidden" >
		  
		    <input name="xr_27" type="hidden"  value="0" >
          <input name="xrr_28" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num38.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl37>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(38)?>','38');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_38" id="Num_38" />
          <input name="class3_38" value="38" type="hidden" >
          <input name="gb38" type="hidden"  value="0">
		  
		    <input name="xr_37" type="hidden"  value="0" >
          <input name="xrr_38" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_r"><img src="images/num48.gif" width="27" height="27" /></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl47>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(48)?>','48');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_48" id="Num_48"  />
          <input name="class3_48" value="48" type="hidden" >
          <input name="gb48" type="hidden"  value="0">
		  
		    <input name="xr_47" type="hidden"  value="0" >
          <input name="xrr_48" type="hidden"  value="0" ></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#EFEFEF" class="ball_b"><span class="ball_r"><img src="images/num09.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl8>0</span><span> </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(9)?>','9');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_9" id="Num_9" />
          <input name="class3_9" value="9" type="hidden" >
          <input name="gb9" type="hidden"  value="0">
          <input name="xr_8" type="hidden"  value="0" >
          <input name="xrr_9" type="hidden"  value="0" >		       </td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num19.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl18>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(19)?>','19');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px"  class="input1" size="3" name="Num_19"  id="Num_19"/>
          <input name="class3_19" value="19" type="hidden" >
          <input name="gb19" type="hidden"  value="0">
		  
		   <input name="xr_18" type="hidden"  value="0" >
          <input name="xrr_19" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num29.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl28>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(29)?>','29');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_29" id="Num_29"/>
          <input name="gb29" type="hidden"  value="0">
          <input name="class3_29" value="29" type="hidden" >
		  
		   <input name="xr_28" type="hidden"  value="0" >
          <input name="xrr_29" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num39.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl38>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(39)?>','39');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_39" id="Num_39" />
          <input name="class3_39" value="39" type="hidden" >
          <input name="gb39" type="hidden"  value="0">
		  
		   <input name="xr_38" type="hidden"  value="0" >
          <input name="xrr_39" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num49.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl48>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(49)?>','49');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_49" id="Num_49" />
          <input name="class3_49" value="49" type="hidden" >
          <input name="gb49" type="hidden"  value="0">
		  
		   <input name="xr_48" type="hidden"  value="0" >
          <input name="xrr_49" type="hidden"  value="0" ></td>
    </tr>
    <tr>
      <td height="25" align="center" class="ball_b" bgcolor="#EFEFEF"><span class="ball_r"><img src="images/num10.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" valign="middle" bgcolor="#ffffff" class="ball_ff"><b><span id=bl9>0</span><span> </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(10)?>','10');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_10" id="Num_10" />
          <input name="class3_10" value="10" type="hidden" >
          <input name="gb10" type="hidden"  value="0">
		  
		  
		   <input name="xr_9" type="hidden"  value="0" >
          <input name="xrr_10" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num20.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl19>0 </span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(20)?>','20');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px"  class="input1" size="3" name="Num_20" id="Num_20" />
          <input name="class3_20" value="20" type="hidden" >
          <input name="gb20" type="hidden"  value="0">
		  
		  <input name="xr_19" type="hidden"  value="0" >
          <input name="xrr_20" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num30.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl29> 0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(30)?>','30');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_30" id="Num_30"/>
          <input name="gb30" type="hidden"  value="0">
          <input name="class3_30" value="30" type="hidden" >
		  <input name="xr_29" type="hidden"  value="0" >
          <input name="xrr_30" type="hidden"  value="0" ></td>
      <td align="center" bgcolor="#FFFFFF" class="ball_b"><span class="ball_r"><img src="images/num40.gif" width="27" height="27" /></span></td>
      <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><b><span id=bl39>0</span></b></td>
      <td height="25" align="center" bgcolor="#ffffff"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','SP','<?=ka_kk1(40)?>','40');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_40"  id="Num_40" />
          <input name="class3_40" value="40" type="hidden" >
          <input name="gb40" type="hidden"  value="0">
		  <input name="xr_39" type="hidden"  value="0" >
          <input name="xrr_40" type="hidden"  value="0" ></td>
      <td height="25" colspan="3" align="center" bgcolor="#ffffff"><table border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
    </tr>

       
    
    <INPUT type="hidden"  value=0 name=gold_all>
 
  
</table>

<table width="650" border="0" cellspacing="1" cellpadding="0">
<tr>
<td>
<TABLE class=Ball_List cellSpacing=1 cellPadding=0 width=216 border=0>
        <TBODY>
        <TR class=Ball_tr_H>
          <TD class=Jut_caption_1 width=78>单</TD>
          <TD  width=77><b><span id=bl49>0</span></b></TD>
          <TD  width=78  bgcolor="#F7F0FB"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','dx','<?=ka_kk1("单")?>');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_50"  id="Num_50" />
          <input name="gb50" type="hidden"  value="0">
          <input name="class3_50" value="单" type="hidden" >
          </TD></TR>
        <TR class=Ball_tr_H>
          <TD class=Jut_caption_1 width=78>双</TD>
          <TD  width=77><b><span id=bl50>0</span></b></TD>
          <TD  width=78  bgcolor="#F7F0FB"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','dx','<?=ka_kk1("双")?>');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_51" id="Num_51" />
          <input name="gb51" type="hidden"  value="0">
          <input name="class3_51" value="双" type="hidden" ></TD></TR>
        <TR class=Ball_tr_H>
          <TD class="Jut_caption_1 Font_R" width=78>红　波</TD>
          <TD  width=77><b><span id=bl55>0</span></b></TD>
          <TD  width=78  bgcolor="#F7F0FB"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','sb','<?=ka_kk1("红波")?>');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_56" id="Num_56" />
          <input name="gb56" type="hidden"  value="0">
          <input name="class3_56" value="红波" type="hidden" ></TD></TR>                          
          
        </TBODY></TABLE>
</td>
<td>
<TABLE class=Ball_List cellSpacing=1 cellPadding=0 width=216 border=0>
        <TBODY>
        <TR class=Ball_tr_H>
          <TD class=Jut_caption_1 width=78>大</TD>
          <TD  width=77><b><span id=bl51>0</span></b></TD>
          <TD  width=78  bgcolor="#F7F0FB"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','ds','<?=ka_kk1("大")?>');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_52" id="Num_52" />
          <input name="gb52" type="hidden"  value="0">
          <input name="class3_52" value="大" type="hidden" ></TD></TR>
        <TR class=Ball_tr_H>
          <TD class=Jut_caption_1 width=78>小</TD>
          <TD  width=77><b><span id=bl52>0</span></b></TD>
          <TD  width=78  bgcolor="#F7F0FB"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','ds','<?=ka_kk1("小")?>');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_53" id="Num_53" />
          <input name="gb53" type="hidden"  value="0">
          <input name="class3_53" value="小" type="hidden" ></TD></TR>
        <TR class=Ball_tr_H>
          <TD class="Jut_caption_1 Font_B" width=78>蓝　波</TD>
          <TD  width=77><b><span id=bl57>0</span></b></TD>
          <TD  width=78  bgcolor="#F7F0FB"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','sb','<?=ka_kk1("蓝波")?>');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="3" name="Num_58"  id="Num_58"/>
          <input name="gb58" type="hidden"  value="0">
          <input name="class3_58" value="蓝波" type="hidden" ></TD></TR>
  
                            
          
        </TBODY></TABLE>
</td>
<td>
<TABLE class=Ball_List cellSpacing=1 cellPadding=0 width=216 border=0>
        <TBODY>
        <TR class=Ball_tr_H>
          <TD class=Jut_caption_1 width=78>合数单</TD>
          <TD  width=77><b><span id=bl53>0</span></b></TD>
          <TD  width=78  bgcolor="#F7F0FB"><input 
			  
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','hd','<?=ka_kk1("合单")?>');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_54" id="Num_54" />
          <input name="gb54" type="hidden"  value="0">
          <input name="class3_54" value="合单" type="hidden" ></TD></TR>
        <TR class=Ball_tr_H>
          <TD class=Jut_caption_1 width=78>合数双</TD>
          <TD  width=77><b><span id=bl54>0</span></b></TD>
          <TD  width=78  bgcolor="#F7F0FB"><input 
			  
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','hd','<?=ka_kk1("合双")?>');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_55" id="Num_55" />
          <input name="gb55" type="hidden"  value="0">
          <input name="class3_55" value="合双" type="hidden" ></TD></TR>
        <TR class=Ball_tr_H>
          <TD class="Jut_caption_1 Font_G" width=78>绿　波</TD>
          <TD  width=77><b><span id=bl56>0</span></b></TD>
          <TD  width=78  bgcolor="#F7F0FB"><input 
			  onKeyPress="return CheckKey();" 
                        onBlur="this.className='inp1';return CountGold(this,'blur','sb','<?=ka_kk1("绿波")?>');" 
                        onKeyUp="return CountGold(this,'keyup');" 
                        onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';" 
      style="HEIGHT: 18px"  class="input1" size="3" name="Num_57"  id="Num_57" />
          <input name="gb57" type="hidden"  value="0">
          <input name="class3_57" value="绿波" type="hidden" ></TD></TR>                            
          
        </TBODY></TABLE>

</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="650">
    <tr>
        <td id="M_ConfirmClew" align="center" class="font_r">
        <input class='but_c1' name='reset' onclick="javascript:document.all.allgold.innerHTML =0;" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type='reset' value='重 填' />&nbsp;
        &nbsp;<input name="btnSubmit"   onclick="return ChkSubmit();" type="button"  class="but_c1" id="btnSubmit" value="下 注" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" /></td>
    </tr>
</table>

 </form>
<INPUT  type="hidden" value=0 name=total_gold>




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
		   for(var i=0;i<58;i++)
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
var sb=i+1
//document.all["xrr_"+sb].value = num5;
//}

if (num6==1){
MM_changeProp('num_'+sb,'','disabled','1','INPUT/text')}

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
		//alert(bl);
	document.all[bl].innerHTML= num2;}
<?	break;
case "B":?>
if (i<=48){
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$bzt*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$bzt*100?>")/100;}

}else{
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$bztdx*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$bztdx*100?>")/100;}

}
	<?
	break;
	case "C":?>
if (i<=48){
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+ eval(Math.round(num2*100)+"-<?=$czt*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$czt*100?>")/100;
}
}else{
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$cztdx*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$cztdx*100?>")/100;}

}
	<?
	break;
	case "D":?>


if (i<=48){if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$dzt*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$dzt*100?>")/100;
}
}else{
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$dztdx*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$dztdx*100?>")/100;}
}
	<? break;
    default:
	
	?>
	if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+num2+"</b></font></span>";
	}else{
		//alert(bl);
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

function beginrefresh(){
	 makeRequest('index.php?action=server&class1=正特&class2=<?=$ids?>');
}
</script>

<SCRIPT language=javascript>
 makeRequest('index.php?action=server&class1=正特&class2=<?=$ids?>')
 </script>
