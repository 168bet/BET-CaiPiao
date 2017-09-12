<? if(!defined('PHPYOU')) {
	exit('非法进入');
}





$ids="自选";

$xc=18;

$XF=23;
function ka_kk1($i){   
   $result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='自选' and class2='".$ids."' and class3='".$i."' order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
return $ka_guanuserkk1[0];
   }



?>

<link rel="stylesheet" href="images/xp.css" type="text/css">

<?

if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#FDF4CA bgcolor=#FDF4CA>          <tr>            <td height=28 align=center bgcolor=0000ff><font color=ffff00>封盘中....</font></td>          </tr>      </table>"; 
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
	

		if ( (eval(goldvalue) < <?=ka_memuser("xy")?>) && (goldvalue!='')) {gold.focus(); alert("下注金额不可小於最低限度:<?=ka_memuser("xy")?>!!"); return false;}

		

		if (rtype=='SP' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds($xc,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds($xc,3)?>!!"); return false;}

		

		if (rtype=='SP' && (eval(goldvalue) > <?=ka_memds($xc,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds($xc,2)?>!!"); return false;}

		
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

}



var type_nums = 6;  //预设为 3中2

var type_min = 6;

var cb_num = 1;

var mess1 =  '最少选择';

var mess11 = '个号';

var mess2 =  '最多选择6个';

var mess = mess2;





  

function SubChk(obj) {







s1="rrtype"

var rrlx=document.all[s1].value

if (rrlx!=1){

if (rrlx==0){

alert("请选择类别");

 return false;

 }





type_nums = document.all[s1].value;

type_min = document.all[s1].value;  

var checkCount = 0;

var checknum = obj.elements.length;

var rtypechk = 0;	

	

	for(i=0; i<checknum; i++) {

		if (obj.elements[i].checked) {

			checkCount ++;

		}

	}

	

	if (eval(document.all.allgold.innerHTML)<=0 || eval(total_gold.value)<=0)

	{

		alert("请输入下注金额!!");

	    document.all.btnSubmit.disabled = false;

		return false;



	}	

	

	

	if (checkCount > (type_nums+1)) {

		alert("最多选择"+type_nums+"个");

		return false;

	}if(checkCount <= (type_min)){

		alert(mess1+type_min+mess11);

		return false;

	}else{

	

		return true;

	}

	

	 



	}

}



function SubChkBox(obj,bmbm) {

var sxsx6="sxsx6"+bmbm



s1="rrtype"



var rrlx=document.all[s1].value



if (rrlx==0){

alert("请选择类别");

obj.checked = false;

 return false;

 }

	if(obj.checked == false)

	{

	

		cb_num--;


	}




var mm=0





	if(obj.checked == true)

	{

		if ( cb_num > rrlx ) 

		{

			alert("最多选择"+rrlx+"个");

			cb_num--;

			obj.checked = false;

		}

		

		

		cb_num++;

	}



}



function select_types(type,i) {



cb_num=1



s1="rrtype"

document.all[s1].value = type;

	if (type == 1 ) {

		for(i=1; i<50; i++) {

				

			MM_changeProp('num'+i,'','disabled','0','INPUT/CHECKBOX')

			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');

			

			MM_changeProp('num'+i,'','disabled','disabled','INPUT/CHECKBOX')

			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');

		}

	} 

	

	if (type == 5 || type == 6  || type == 7 || type == 8 || type == 9 || type == 10 || type == 11 || type == 12 ) {

		for(i=1; i<50; i++) {

				

			MM_changeProp('num'+i,'','disabled','0','INPUT/CHECKBOX')

			MM_changeProp('num'+i,'','checked','0','INPUT/CHECKBOX');

			

			

		}

	} 

	

}  

</SCRIPT>

 <style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
}
.STYLE1 {color: #FFFFFF}
.STYLE4 {color: #333333; font-weight: bold; }
.CB_TABLE {
	color: #FFF;
}
-->
 </style>
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <tr>
    <td height="2"></td>
  </tr></table>
<table width="640"   border="0" cellpadding="2" cellspacing="1" bordercolordark="#f9f9f9" bgcolor="#CCCCCC">
  <form target="mem_order" name="forms"  method="post" onSubmit="return SubChk(this);" action="index.php?action=zx_n1&class2=<?=$ids?>">
    <tr class="tbtitle">
      <td width="292" height="28" align="center" nowrap="nowrap"><table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="600">&nbsp;&nbsp;<font color=ffffff><font color=ffff00 size="3"><b><?=$ids?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;封盘倒计时:<font color="#FFff00"><strong><span id="span_dt_dt"></span></strong></font>
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
</SCRIPT>&nbsp;&nbsp;下注金额:<span id=allgold>0</span></font></td>
          </tr>
      </table></td>
    </tr>
	 	<tr>
	  <td height="35" align="center"  bgcolor="#FFFFFF"><TABLE width=673 class="CB_TABLE">
<TR class="CB_ITEM_CENTER" height=20>
    <TD width=50 align="center" bgcolor="#006600"><span class="CB_TABLE">
        项目
    </span></TD>
    <TD width=81 bgcolor="#006600"><span class="CB_TABLE">
      <INPUT TYPE="RADIO" NAME="lx" onClick="select_types(5);" value="<?=$drop_table[0][0]?>" >
        五不中
    </span></TD>
    <TD width=81 bgcolor="#006600"><span class="CB_TABLE">
      <INPUT TYPE="RADIO" NAME="lx" onClick="select_types(6);" value="<?=$drop_table[1][0]?>" >
        六不中
    </span></TD>
    <TD width=81 bgcolor="#006600"><span class="CB_TABLE">
      <INPUT TYPE="RADIO" NAME="lx" onClick="select_types(7);" value="<?=$drop_table[2][0]?>" >
        七不中
    </span></TD>
    <TD width=81 bgcolor="#006600"><span class="CB_TABLE">
      <INPUT TYPE="RADIO" NAME="lx" onClick="select_types(8);" value="<?=$drop_table[3][0]?>" >
        八不中
    </span></TD>
    <TD width=81 bgcolor="#006600"><span class="CB_TABLE">
      <INPUT TYPE="RADIO" NAME="lx" onClick="select_types(9);" value="<?=$drop_table[4][0]?>" >
        九不中
    </span></TD>
    <TD width=81 bgcolor="#006600"><span class="CB_TABLE">
      <INPUT TYPE="RADIO" NAME="lx" onClick="select_types(10);" value="<?=$drop_table[5][0]?>" >
        十不中
    </span></TD>
    <TD width=81 bgcolor="#006600"><span class="CB_TABLE">
      <INPUT TYPE="RADIO" NAME="lx" onClick="select_types(11);" value="<?=$drop_table[6][0]?>" >
        十一不中
    </span></TD>
    <TD width=81 bgcolor="#006600"><span class="CB_TABLE">
      <INPUT TYPE="RADIO" NAME="lx" onClick="select_types(12);" value="<?=$drop_table[7][0]?>" >
        十二不中
    </span></TD>
</TR>
<TR class="CB_RATE_CENTER" height="30">
            <td height="35" align="center" bgcolor="#FDF4CA" ><strong>赔率</strong></td>
            <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><span id=bl0>0</span></td>
            <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><span id=bl1>0</span></td>
            <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><span id=bl2>0</span></td>
            <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><span id=bl3>0</span></td>
            <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><span id=bl4>0</span></td>
            <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><span id=bl5>0</span></td>
            <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><span id=bl6>0</span></td>
            <td height="25" align="center" bgcolor="#ffffff" class="ball_ff"><span id=bl7>0</span></td>
        </TR>
<tr>
    <td colspan="9">
      <TABLE width="100%" class="CB_TABLE"  cellpadding="5" >
        <TR class="CB_ITEM_CENTER" height=20>
          <TD width=32 bgcolor="#006600"><font color='#FFFFFF'>号码</font></TD>
          <TD bgcolor="#006600"><font color='#FFFFFF'>勾选</font></TD>
          <TD width=32 bgcolor="#006600"><font color='#FFFFFF'>号码</font></TD>
          <TD bgcolor="#006600"><font color='#FFFFFF'>勾选</font></TD>
          <TD width=32 bgcolor="#006600"><font color='#FFFFFF'>号码</font></TD>
          <TD bgcolor="#006600"><font color='#FFFFFF'>勾选</font></TD>
          <TD width=32 bgcolor="#006600"><font color='#FFFFFF'>号码</font></TD>
          <TD bgcolor="#006600"><font color='#FFFFFF'>勾选</font></TD>
          <TD width=32 bgcolor="#006600"><font color='#FFFFFF'>号码</font></TD>
          <TD bgcolor="#006600"><font color='#FFFFFF'>勾选</font></TD>
          </TR>
        <TR class="CB_RATE_CENTER">
          
          <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR="#000000" size=3>01</FONT></B></TD>
          <TD><input onClick="SubChkBox(this,1)" name="num1" value="1" type="checkbox"></TD>
          
          <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>11</FONT></B></TD>
          <TD><input onClick="SubChkBox(this,11)" name="num11" value="11" type="checkbox"></TD>
          
          <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>21</FONT></B></TD>
          <TD><input onClick="SubChkBox(this,21)" name="num21" value="21" type="checkbox"></TD>
          
          <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>31</FONT></B></TD>
          <TD><input onClick="SubChkBox(this,31)" name="num31" value="31" type="checkbox"></TD>
          
          <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>41</FONT></B></TD>
          <TD><input onClick="SubChkBox(this,41)" name="num41" value="41" type="checkbox"></TD>
  </TR><TR class="CB_RATE_CENTER">
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR="#000000" size=3>02</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,2)" name="num2" value="2" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>12</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,12)" name="num12" value="12" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>22</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,22)" name="num22" value="22" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>32</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,32)" name="num32" value="32" type="checkbox"></TD>
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>42</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,42)" name="num42" value="42" type="checkbox"></TD>
  </TR><TR class="CB_RATE_CENTER">
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR="#000000" size=3>03</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,3)" name="num3" value="3" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>13</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,13)" name="num13" value="13" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>23</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,23)" name="num23" value="23" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>33</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,33)" name="num33" value="33" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>43</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,43)" name="num43" value="43" type="checkbox"></TD>
  </TR><TR class="CB_RATE_CENTER">
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR="#000000" size=3>04</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,4)" name="num4" value="4" type="checkbox"></TD>
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>14</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,14)" name="num14" value="14" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>24</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,24)" name="num24" value="24" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>34</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,34)" name="num34" value="34" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>44</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,44)" name="num44" value="44" type="checkbox"></TD>
  </TR><TR class="CB_RATE_CENTER">
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR="#000000" size=3>05</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,5)" name="num5" value="5" type="checkbox"></TD>
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>15</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,15)" name="num15" value="15" type="checkbox"></TD>
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>25</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,25)" name="num25" value="25" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>35</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,35)" name="num35" value="35" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>45</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,45)" name="num45" value="45" type="checkbox"></TD>
  </TR><TR class="CB_RATE_CENTER">
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR="#000000" size=3>06</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,6)" name="num6" value="6" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>16</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,16)" name="num16" value="16" type="checkbox"></TD>
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>26</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,26)" name="num26" value="26" type="checkbox"></TD>
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>36</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,36)" name="num36" value="36" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>46</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,46)" name="num46" value="46" type="checkbox"></TD>
  </TR><TR class="CB_RATE_CENTER">
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR="#000000" size=3>07</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,7)" name="num7" value="7" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>17</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,17)" name="num17" value="17" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>27</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,27)" name="num27" value="27" type="checkbox"></TD>
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>37</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,37)" name="num37" value="37" type="checkbox"></TD>
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>47</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,47)" name="num47" value="47" type="checkbox"></TD>
  </TR><TR class="CB_RATE_CENTER">
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR="#000000" size=3>08</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,8)" name="num8" value="8" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>18</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,18)" name="num18" value="18" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>28</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,28)" name="num28" value="28" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>38</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,38)" name="num38" value="38" type="checkbox"></TD>
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>48</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,48)" name="num48" value="48" type="checkbox"></TD>
  </TR><TR class="CB_RATE_CENTER">
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR="#000000" size=3>09</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,9)" name="num9" value="9" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>19</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,19)" name="num19" value="19" type="checkbox"></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>29</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,29)" name="num29" value="29" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>39</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,39)" name="num39" value="39" type="checkbox"></TD>
    
    <TD height=32 background='../images/G.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>49</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,49)" name="num49" value="49" type="checkbox"></TD>
  </TR><TR class="CB_RATE_CENTER">
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>10</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,10)" name="num10" value="10" type="checkbox"></TD>
    
    <TD height=32 background='../images/B.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>20</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,20)" name="num20" value="20" type="checkbox" /></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>30</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,30)" name="num30" value="30" type="checkbox" /></TD>
    
    <TD height=32 background='../images/R.jpg' bgcolor="#FDF4CA"><B><FONT COLOR=#000000 size=3>40</FONT></B></TD>
    <TD><input onClick="SubChkBox(this,40)" name="num40" value="40" type="checkbox" /></TD>
  <TD colspan=2>&nbsp;</TD>
  </TR>
        
        </TABLE>
    </td>    
    </tr>
<input type='hidden' name='txtDan'>
<input type='hidden' name='txtTuo'>

<TR>
<td colspan="12" align="center" bgcolor="#ffffff" height="25"><table align="center" border="0" cellpadding="2" cellspacing="2">

        <tbody><tr>

          <td align="center">下注金额：

            <input name="Num_0" class="input1" id="Num_0" style="height: 18px;" onFocus="CountGold(this,'focus');this.value='';" onBlur="return CountGold(this,'blur','SP');" onKeyPress="return CheckKey();" onKeyUp="return CountGold(this,'keyup');" size="10"></td>

          <td align="center"><input name="btnSubmit"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" id="btnSubmit" value="提交" type="submit"></td>

            <td align="center"><input onClick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit3" value="重设" type="button"></td>

            <td><input name="rrtype" id="rrtype" value="0" type="hidden"></td>

          </tr>

      </tbody></table></td>
</TR>

</TABLE></td>
    </tr>
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
		   for(var i=0;i<8;i++)
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
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$bzx*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$bzx*100?>")/100;}

	<?
	break;
	case "C":?>
if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$czx*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$czx*100?>")/100;}

	<?
	break;
	case "D":?>


if (num2!=num3){
	document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$dzx*100?>")/100+"</b></font></span>";
	}else{
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$dzx*100?>")/100;}

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


</script>

<SCRIPT language=javascript>
 makeRequest('index.php?action=server&class1=自选&class2=<?=$ids?>')
 </script>
