<? if(!defined('PHPYOU')) {
	exit('非法进入');
}


$XF=13;
if ($_GET['ids']!=""){$ids=$_GET['ids'];}else{$ids="正1-6";}

$xc=5;
function ka_kk1($i,$bbs){   
   $result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='正码' and class2='".$bbs."' and class3='".$i."' order by id desc"); 
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



$result=mysql_query("Select class3,rate,class2  from ka_bl where class1='正1-6'   Order By class2,ID");
$drop_table = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
//echo $image['class3'];
array_push($drop_table,$image);
$KA_BL[$image['class2']][$image['class3']]=$image['rate'];
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
	if((event.keyCode < 40 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金额仅能输入数字!!"); return false;}
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
		
		if (rtype=='SP' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds($xc,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds($xc,3)?>!!"); return false;}
		
		if (rtype=='SP' && (eval(goldvalue) > <?=ka_memds($xc,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds($xc,2)?>!!"); return false;}
		
		
		if (rtype=='dx' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(2,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(2,3)?>!!"); return false;}
		
		if (rtype=='dx' && (eval(goldvalue) > <?=ka_memds(2,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds(2,2)?>!!"); return false;}
		
		
		if (rtype=='ds' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(3,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(3,3)?>!!"); return false;}
		if (rtype=='ds' && (eval(goldvalue) > <?=ka_memds(3,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds(3,2)?>!!"); return false;}
		
		if (rtype=='hd' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(4,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(4,3)?>!!"); return false;}
		if (rtype=='hd' && (eval(goldvalue) > <?=ka_memds(4,2)?>)) {gold.focus(); alert("对不起,单注限额最高限制 : <?=ka_memds(4,2)?>!!"); return false;}
		
		if (rtype=='bs' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(10,2)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(10,3)?>!!"); return false;}
		if (rtype=='bs' && (eval(goldvalue) > <?=ka_memds(10,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds(10,2)?>!!"); return false;}
		
		
		
		
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
-->
</style>
<body >
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
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
      id=Update_Time></SPAN>&nbsp;<INPUT class="but_c1" style="LEFT: 0px; WIDTH: 64px; POSITION: relative; TOP: 0px; HEIGHT: 18px" onfocus=this.blur() onClick="beginrefresh();" type=button value=重新整理 name=LoadingPL>&nbsp;</TD></TR></TBODY></TABLE></td>
  </tr>
      </table>

<form target="mem_order" name="lt_form"  method="post" action="index.php?action=n1&class2=正1-6"  style="height:580px;">


<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table width="36" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
	  <tr><td width="36" class="td_caption_1">…</td></tr>
	  <tr>
        <td class="td_caption_1">类型</td>
      </tr>
      <tr class="Ball_tr_H">
        <td class="Jut_caption_1">单</td>
      </tr>  
      <tr class="Ball_tr_H">
        <td class="Jut_caption_1">双</td>
      </tr>  
      <tr class="Ball_tr_H">
        <td class="Jut_caption_1">大</td>
      </tr>  
      <tr class="Ball_tr_H">
        <td class="Jut_caption_1">小</td>
      </tr>  
     <tr class="Ball_tr_H">
        <td class="TD_R">红波</td>
      </tr>  
      <tr class="Ball_tr_H">
        <td class="TD_B">蓝波</td>
      </tr> 
      <tr class="Ball_tr_H">
        <td class="TD_G">绿波</td>
      </tr>  
     <tr class="Ball_tr_H">
        <td class="Jut_caption_1">合大</td>
      </tr>  
      <tr class="Ball_tr_H">
        <td class="Jut_caption_1">合小</td>
      </tr>
     <tr class="Ball_tr_H">
        <td class="Jut_caption_1">合单</td>
      </tr>  
      <tr class="Ball_tr_H">
        <td class="Jut_caption_1">合双</td>
      </tr>
     <tr class="Ball_tr_H">
        <td class="Jut_caption_1">尾大</td>
      </tr>  
      <tr class="Ball_tr_H">
        <td class="Jut_caption_1">尾小</td>
      </tr>            
    </table>
    </td>
    <td>
<table width="102" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
      <tr><td colspan="2" class="td_caption_1">正码一</td></tr>
      <tr>
        <td width="40" class="td_caption_1">赔率</td>
        <td width="62" class="td_caption_1">金额</td>
      </tr>
      <tr class="Ball_tr_H">
        <td ID="jeu_p_13_243"><span id=bl2>0</span></td>
        <td ID="jeu_m_13_243" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_3" />
<input name="class3_3" value="单" type="hidden" ><input name="class2_3" value="正码1" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_13_240"><span id=bl3>0</span></td>
        <td ID="jeu_m_13_240" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_4" />
<input name="class3_4" value="双" type="hidden" ><input name="class2_4" value="正码1" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_231"><span id=bl0>0</span><input name="class2_1" value="正码1" type="hidden" ></td>
        <td ID="jeu_m_12_231" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_1" />
<input name="class3_1" value="大" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_237"><span id=bl1>0</span></td>
        <td ID="jeu_m_12_237" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_2" />
<input name="class3_2" value="小" type="hidden" ><input name="class2_2" value="正码1" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_14_255"><span id=bl4>0</span></td>
        <td ID="jeu_m_14_255" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_5" />
<input name="class3_5" value="红波" type="hidden" ><input name="class2_5" value="正码1" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_261"><span id=bl6>0</span></td>
        <td ID="jeu_m_14_261" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_7" />
<input name="class3_7" value="蓝波" type="hidden" ><input name="class2_7" value="正码1" type="hidden" ></td>
      </tr> 
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_267"><span id=bl5>0</span></td>
        <td ID="jeu_m_14_267" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_6" />
<input name="class3_6" value="绿波" type="hidden" ><input name="class2_6" value="正码1" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_273"><span id=bl7>0</span></td>
        <td ID="jeu_m_15_273" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_8" />
<input name="class3_8" value="合大" type="hidden" ><input name="class2_8" value="正码1" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_279"><span id=bl8>0</span></td>
        <td ID="jeu_m_15_279" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_9" />
<input name="class3_9" value="合小" type="hidden" ><input name="class2_9" value="正码1" type="hidden" ></td>
      </tr>
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_273"><span id=bl9>0</span></td>
        <td ID="jeu_m_15_273" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_10" />
<input name="class3_10" value="合单" type="hidden" ><input name="class2_10" value="正码1" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_279"><span id=bl10>0</span></td>
        <td ID="jeu_m_15_279" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_11" />
<input name="class3_11" value="合双" type="hidden" ><input name="class2_11" value="正码1" type="hidden" ></td>
      </tr>
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_273"><span id=bl11>0</span></td>
        <td ID="jeu_m_15_273" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_12" />
<input name="class3_12" value="尾大" type="hidden" ><input name="class2_12" value="正码1" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_279"><span id=bl12>0</span></td>
        <td ID="jeu_m_15_279" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_13" />
<input name="class3_13" value="尾小" type="hidden" ><input name="class2_13" value="正码1" type="hidden" ></td>
      </tr>            
    </table>
    <td>
	<table width="102" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
      <tr>
        <td colspan="2" class="td_caption_1">正码二</td>
        </tr>
      <tr>
        <td width="40" class="td_caption_1">赔率</td>
        <td width="62" class="td_caption_1">金额</td>
      </tr>
      <tr class="Ball_tr_H">
        <td ID="jeu_p_13_244"><span id=bl15>0</span></td>
        <td ID="jeu_m_13_244" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_16" />
<input name="class3_16" value="单" type="hidden" ><input name="class2_16" value="正码2" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_13_250"><span id=bl16>0</span></td>
        <td ID="jeu_m_13_250" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_17" />
<input name="class3_17" value="双" type="hidden" ><input name="class2_17" value="正码2" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_232"><span id=bl13>0</span></td>
        <td ID="jeu_m_12_232" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_14" />
<input name="class3_14" value="大" type="hidden" ><input name="class2_14" value="正码2" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_238"><span id=bl14>0</span></td>
        <td ID="jeu_m_12_238" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_15" />
<input name="class3_15" value="小" type="hidden" ><input name="class2_15" value="正码2" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_14_256"><span id=bl17>0</span></td>
        <td ID="jeu_m_14_256" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_18" />
<input name="class3_18" value="红波" type="hidden" ><input name="class2_18" value="正码2" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_262"><span id=bl19>0</span></td>
        <td ID="jeu_m_14_262" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_20" />
<input name="class3_20" value="蓝波" type="hidden" ><input name="class2_20" value="正码2" type="hidden" ></td>
      </tr> 
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_268"><span id=bl18>0</span></td>
        <td ID="jeu_m_14_268" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_19" />
<input name="class3_19" value="绿波" type="hidden" ><input name="class2_19" value="正码2" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_274"><span id=bl20>0</span></td>
        <td ID="jeu_m_15_274" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_21" />
<input name="class3_21" value="合大" type="hidden" ><input name="class2_21" value="正码2" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_280"><span id=bl21>0</span></td>
        <td ID="jeu_m_15_280" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_22" />
<input name="class3_22" value="合小" type="hidden" ><input name="class2_22" value="正码2" type="hidden" ></td>
      </tr>
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_274"><span id=bl22>0</span></td>
        <td ID="jeu_m_15_274" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_23" />
<input name="class3_23" value="合单" type="hidden" ><input name="class2_23" value="正码2" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_280"><span id=bl23>0</span></td>
        <td ID="jeu_m_15_280" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_24" />
<input name="class3_24" value="合双" type="hidden" ><input name="class2_24" value="正码2" type="hidden" ></td>
      </tr>
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_274"><span id=bl24>0</span></td>
        <td ID="jeu_m_15_274" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_25" />
<input name="class3_25" value="尾大" type="hidden" ><input name="class2_25" value="正码2" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_280"><span id=bl25>0</span></td>
        <td ID="jeu_m_15_280" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_26" />
<input name="class3_26" value="尾小" type="hidden" ><input name="class2_26" value="正码2" type="hidden" ></td>
      </tr>            
    </table>
	</td>
    <td>
	<table width="102" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
      <tr>
        <td colspan="2" class="td_caption_1">正码三</td>
        </tr>
      <tr>
        <td width="40" class="td_caption_1">赔率</td>
        <td width="62" class="td_caption_1">金额</td>
      </tr>
      <tr class="Ball_tr_H">
        <td ID="jeu_p_13_245"><span id=bl28>0</span></td>
        <td ID="jeu_m_13_245" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_29" />
<input name="class3_29" value="单" type="hidden" ><input name="class2_29" value="正码3" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_13_251"><span id=bl29>0</span></td>
        <td ID="jeu_m_13_251" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_30" />
<input name="class3_30" value="双" type="hidden" ><input name="class2_30" value="正码3" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_233"><span id=bl26>0</span></td>
        <td ID="jeu_m_12_233" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_27" />
<input name="class3_27" value="大" type="hidden" ><input name="class2_27" value="正码3" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_239"><span id=bl27>0</span></td>
        <td ID="jeu_m_12_239" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_28" />
<input name="class3_28" value="小" type="hidden" ><input name="class2_28" value="正码3" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_14_257"><span id=bl30>0</span></td>
        <td ID="jeu_m_14_257" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_31" />
<input name="class3_31" value="红波" type="hidden" ><input name="class2_31" value="正码3" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_263"><span id=bl32>0</span></td>
        <td ID="jeu_m_14_263" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_33" />
<input name="class3_33" value="蓝波" type="hidden" ><input name="class2_33" value="正码3" type="hidden" ></td>
      </tr> 
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_269"><span id=bl31>0</span></td>
        <td ID="jeu_m_14_269" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_32" />
<input name="class3_32" value="绿波" type="hidden" ><input name="class2_32" value="正码3" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_275"><span id=bl33>0</span></td>
        <td ID="jeu_m_15_275" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_34" />
<input name="class3_34" value="合大" type="hidden" ><input name="class2_34" value="正码3" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_281"><span id=bl34>0</span></td>
        <td ID="jeu_m_15_281" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_35" />
<input name="class3_35" value="合小" type="hidden" ><input name="class2_35" value="正码3" type="hidden" ></td>
      </tr> 
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_275"><span id=bl35>0</span></td>
        <td ID="jeu_m_15_275" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_36" />
<input name="class3_36" value="合单" type="hidden" ><input name="class2_36" value="正码3" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_281"><span id=bl36>0</span></td>
        <td ID="jeu_m_15_281" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_37" />
<input name="class3_37" value="合双" type="hidden" ><input name="class2_37" value="正码3" type="hidden" ></td>
      </tr> 
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_275"><span id=bl37>0</span></td>
        <td ID="jeu_m_15_275" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_38" />
<input name="class3_38" value="尾大" type="hidden" ><input name="class2_38" value="正码3" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_281"><span id=bl38>0</span></td>
        <td ID="jeu_m_15_281" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_39" />
<input name="class3_39" value="尾小" type="hidden" ><input name="class2_39" value="正码3" type="hidden" ></td>
      </tr>             
    </table>
	</td>
    <td>
	<table width="102" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
      <tr>
        <td colspan="2" class="td_caption_1">正码四</td>
        </tr>
      <tr>
        <td width="40" class="td_caption_1">赔率</td>
        <td width="62" class="td_caption_1">金额</td>
      </tr>
      <tr class="Ball_tr_H">
        <td ID="jeu_p_13_246"><span id=bl41>0</span></td>
        <td ID="jeu_m_13_246" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_42" />
<input name="class3_42" value="单" type="hidden" ><input name="class2_42" value="正码4" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_13_252"><span id=bl42>0</span></td>
        <td ID="jeu_m_13_252" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_43" />
<input name="class3_43" value="双" type="hidden" ><input name="class2_43" value="正码4" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_234"><span id=bl39>0</span></td>
        <td ID="jeu_m_12_234" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_40" />
<input name="class3_40" value="大" type="hidden" ><input name="class2_40" value="正码4" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_240"><span id=bl40>0</span></td>
        <td ID="jeu_m_12_240" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_41" />
<input name="class3_41" value="小" type="hidden" ><input name="class2_41" value="正码4" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_14_258"><span id=bl43>0</span></td>
        <td ID="jeu_m_14_258" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_44" />
<input name="class3_44" value="红波" type="hidden" ><input name="class2_44" value="正码4" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_264"><span id=bl45>0</span></td>
        <td ID="jeu_m_14_264" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_46" />
<input name="class3_46" value="蓝波" type="hidden" ><input name="class2_46" value="正码4" type="hidden" ></td>
      </tr> 
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_270"><span id=bl44>0</span></td>
        <td ID="jeu_m_14_270" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_45" />
<input name="class3_45" value="绿波" type="hidden" ><input name="class2_45" value="正码4" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_276"><span id=bl46>0</span></td>
        <td ID="jeu_m_15_276" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_47" />
<input name="class3_47" value="合大" type="hidden" ><input name="class2_47" value="正码4" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_282"><span id=bl47>0</span></td>
        <td ID="jeu_m_15_282" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_40" />
<input name="class3_40" value="合小" type="hidden" ><input name="class2_40" value="正码4" type="hidden" ></td>
      </tr>
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_276"><span id=bl40>0</span></td>
        <td ID="jeu_m_15_276" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_40" />
<input name="class3_40" value="合单" type="hidden" ><input name="class2_40" value="正码4" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_282"><span id=bl40>0</span></td>
        <td ID="jeu_m_15_282" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_50" />
<input name="class3_50" value="合双" type="hidden" ><input name="class2_50" value="正码4" type="hidden" ></td>
      </tr>
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_276"><span id=bl50>0</span></td>
        <td ID="jeu_m_15_276" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_51" />
<input name="class3_51" value="尾大" type="hidden" ><input name="class2_51" value="正码4" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_282"><span id=bl51>0</span></td>
        <td ID="jeu_m_15_282" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_52" />
<input name="class3_52" value="尾小" type="hidden" ><input name="class2_52" value="正码4" type="hidden" ></td>
      </tr>            
    </table>
	</td>
    <td>
	<table width="102" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
      <tr>
        <td colspan="2" class="td_caption_1">正码五</td>
        </tr>
      <tr>
        <td width="40" class="td_caption_1">赔率</td>
        <td width="62" class="td_caption_1">金额</td>
      </tr>
      <tr class="Ball_tr_H">
        <td ID="jeu_p_13_247"><span id=bl54>0</span></td>
        <td ID="jeu_m_13_247" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_55" />
<input name="class3_55" value="单" type="hidden" ><input name="class2_55" value="正码5" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_13_253"><span id=bl55>0</span></td>
        <td ID="jeu_m_13_253" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_56" />
<input name="class3_56" value="双" type="hidden" ><input name="class2_56" value="正码5" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_235"><span id=bl52>0</span></td>
        <td ID="jeu_m_12_235" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_53" />
<input name="class3_53" value="大" type="hidden" ><input name="class2_53" value="正码5" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_241"><span id=bl53>0</span></td>
        <td ID="jeu_m_12_241" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_54" />
<input name="class3_54" value="小" type="hidden" ><input name="class2_54" value="正码5" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_14_259"><span id=bl56>0</span></td>
        <td ID="jeu_m_14_259" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_57" />
<input name="class3_57" value="红波" type="hidden" ><input name="class2_57" value="正码5" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_265"><span id=bl58>0</span></td>
        <td ID="jeu_m_14_265" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_59" />
<input name="class3_59" value="蓝波" type="hidden" ><input name="class2_59" value="正码5" type="hidden" ></td>
      </tr> 
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_271"><span id=bl57>0</span></td>
        <td ID="jeu_m_14_271" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_58" />
<input name="class3_58" value="绿波" type="hidden" ><input name="class2_58" value="正码5" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_277"><span id=bl59>0</span></td>
        <td ID="jeu_m_15_277" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_60" />
<input name="class3_60" value="合大" type="hidden" ><input name="class2_60" value="正码5" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_283"><span id=bl60>0</span></td>
        <td ID="jeu_m_15_283" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_61" />
<input name="class3_61" value="合小" type="hidden" ><input name="class2_61" value="正码5" type="hidden" ></td>
      </tr>
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_277"><span id=bl61>0</span></td>
        <td ID="jeu_m_15_277" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_62" />
<input name="class3_62" value="合单" type="hidden" ><input name="class2_62" value="正码5" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_283"><span id=bl62>0</span></td>
        <td ID="jeu_m_15_283" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_63" />
<input name="class3_63" value="合双" type="hidden" ><input name="class2_63" value="正码5" type="hidden" ></td>
      </tr>
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_277"><span id=bl63>0</span></td>
        <td ID="jeu_m_15_277" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_64" />
<input name="class3_64" value="尾大" type="hidden" ><input name="class2_64" value="正码5" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_283"><span id=bl64>0</span></td>
        <td ID="jeu_m_15_283" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_65" />
<input name="class3_65" value="尾小" type="hidden" ><input name="class2_65" value="正码5" type="hidden" ></td>
      </tr>            
    </table>
	</td>
    <td>
	<table width="102" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
      <tr>
        <td colspan="2" class="td_caption_1">正码六</td>
        </tr>
      <tr>
        <td width="40" class="td_caption_1">赔率</td>
        <td width="62" class="td_caption_1">金额</td>
      </tr>
      <tr class="Ball_tr_H">
        <td ID="jeu_p_13_240"><span id=bl67>0</span></td>
        <td ID="jeu_m_13_240" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_68" />
<input name="class3_68" value="单" type="hidden" ><input name="class2_68" value="正码6" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_13_254"><span id=bl68>0</span></td>
        <td ID="jeu_m_13_254" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','dx','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_69" />
<input name="class3_69" value="双" type="hidden" ><input name="class2_69" value="正码6" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_236"><span id=bl65>0</span></td>
        <td ID="jeu_m_12_236" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_66" />
<input name="class3_66" value="大" type="hidden" ><input name="class2_66" value="正码6" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_12_242"><span id=bl66>0</span></td>
        <td ID="jeu_m_12_242" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','ds','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_67" />
<input name="class3_67" value="小" type="hidden" ><input name="class2_67" value="正码6" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_14_260"><span id=bl69>0</span></td>
        <td ID="jeu_m_14_260" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_70" />
<input name="class3_70" value="红波" type="hidden" ><input name="class2_70" value="正码6" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_266"><span id=bl71>0</span></td>
        <td ID="jeu_m_14_266" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_72" />
<input name="class3_72" value="蓝波" type="hidden" ><input name="class2_72" value="正码6" type="hidden" ></td>
      </tr> 
      <tr class="Ball_tr_H">
        <td ID="jeu_p_14_272"><span id=bl70>0</span></td>
        <td ID="jeu_m_14_272" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','bs','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_71" />
<input name="class3_71" value="绿波" type="hidden" ><input name="class2_71" value="正码6" type="hidden" ></td>
      </tr>  
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_278"><span id=bl72>0</span></td>
        <td ID="jeu_m_15_278" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_73" />
<input name="class3_73" value="合大" type="hidden" ><input name="class2_73" value="正码6" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_284"><span id=bl73>0</span></td>
        <td ID="jeu_m_15_284" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_74" />
<input name="class3_74" value="合小" type="hidden" ><input name="class2_74" value="正码6" type="hidden" ></td>
      </tr>
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_278"><span id=bl74>0</span></td>
        <td ID="jeu_m_15_278" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_75" />
<input name="class3_75" value="合单" type="hidden" ><input name="class2_75" value="正码6" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_284"><span id=bl75>0</span></td>
        <td ID="jeu_m_15_284" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_76" />
<input name="class3_76" value="合双" type="hidden" ><input name="class2_76" value="正码6" type="hidden" ></td>
      </tr>
     <tr class="Ball_tr_H">
        <td ID="jeu_p_15_278"><span id=bl76>0</span></td>
        <td ID="jeu_m_15_278" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_77" />
<input name="class3_77" value="尾大" type="hidden" ><input name="class2_77" value="正码6" type="hidden" ></td>
      </tr>  
      <tr class="Ball_tr_H">
        <td ID="jeu_p_15_284"><span id=bl77>0</span></td>
        <td ID="jeu_m_15_284" bgcolor="#F7F0FB"><input
onKeyPress="return CheckKey();"
onBlur="this.className='inp1';return CountGold(this,'blur','','');"
onKeyUp="return CountGold(this,'keyup');"
onFocus="this.className='inp1m';CountGold(this,'focus');this.value='';"
style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" name="Num_78" />
<input name="class3_78" value="尾小" type="hidden" ><input name="class2_78" value="正码6" type="hidden" ></td>
      </tr>            
    </table>
	</td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="650">
    <tr>
        <td id="M_ConfirmClew" align="center" class="font_r">
        <input class='but_c1' name='reset' onClick="javascript:document.all.allgold.innerHTML =0;" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type='reset' value='重 填' />&nbsp;
        &nbsp;<input name="btnSubmit"   onclick="return ChkSubmit();" type="button"  class="but_c1" id="btnSubmit" value="下 注" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" /></td>
    </tr>
</table>

	<INPUT type="hidden"  value=0 name=gold_all>
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
			//alert(result);
           
            if(result==""){
           
                result = "Access failure ";
           
            }
           
		   var arrResult = result.split("###");	
		   for(var i=0;i<78;i++)
{	   
		   arrTmp = arrResult[i].split("@@@");
		   


num1 = arrTmp[0]; //字段num1的值
num2 = parseFloat(arrTmp[1]).toFixed(2); //字段num2的值
num3 = parseFloat(arrTmp[2]).toFixed(2); //字段num1的值
num4 = arrTmp[3]; //字段num2的值
num5 = arrTmp[4]; //字段num2的值
num6 = arrTmp[5]; //字段num2的值


//if (i<40){
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
	document.all[bl].innerHTML= num2;}
<?	break;
case "B":?>

if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$bztdx*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$bztdx*100?>")/100;}


	<?
	break;
	case "C":?>

if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$cztdx*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$cztdx*100?>")/100;}


	<?
	break;
	case "D":?>



if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$dztdx*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$dztdx*100?>")/100;}

	<? break;
    default:
	
	?>
	if (num2!=num3){
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
function beginrefresh(){
	 makeRequest('index.php?action=server&class1=正码1-6&class2=<?=$ids?>');
}

</script>

<SCRIPT language=javascript>
 makeRequest('index.php?action=server&class1=正码1-6')
 </script>
