<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

$XF=19;
$ids="过关";


$result=mysql_query("Select class3,rate,locked from ka_bl where class1='过关' order by ID");
$drop_table = array();
$y=0;
while($image = mysql_fetch_array($result)){
//$y++;
//echo $image['class3'];
//echo $image['rate']."<br>";
$image['rate']=round($image['rate'],2);
//echo $image['rate']."<br>";
array_push($drop_table,$image);
if($image['locked']==1){
$drop_table[$y][1]="停";
$drop_table[$y][2]="disabled";
}else{
$drop_table[$y][1]=$image['rate'];
$drop_table[$y][2]="";
}

$y++;
}
?>

<link href="imgs/main_n1.css" rel="stylesheet" type="text/css">
<link href="imgs/ball1.css" rel="stylesheet" type="text/css">
<SCRIPT type="text/javascript" src="imgs/activeX_Embed.js"></SCRIPT>

<?
if ($Current_KitheTable[29]==0 ) {   
?>
<script language="javascript">
Make_FlashPlay('imgs/T0.swf','T','650','500');
</script>
<?
exit;								
}else{
if ($Current_KitheTable[19]==0 ) {  
?>
<script language="javascript">
Make_FlashPlay('imgs/T2.swf','T','650','500');
</script>
<?
exit;
}


}

 
?>

<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
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
 <body oncontextmenu="return false"   onselect="document.selection.empty()" oncopy="document.selection.empty()" 
>
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
      id=Update_Time></SPAN></TD></TR></TBODY></TABLE></td>
  </tr>
      </table>
<FORM name=lt_form_138 onSubmit="return SubChk(this);" 
        action="index.php?action=k_ggsave" method="post" target=mem_order style="height:580px;"> 
<table width="650" border="0" cellpadding="0" cellspacing="1" class="Ball_List">
  <tr>
    <td width="140" class="td_caption_1" >正码过关</td>
    <td width="80" class="td_caption_1">单</td>
    <td width="80" class="td_caption_1">双</td>
    <td width="80" class="td_caption_1">大</td>
    <td width="80" class="td_caption_1">小</td>
    <td width="80" class="td_caption_1 Font_R">红波</td>
    <td width="80" class="td_caption_1 Font_B">蓝波</td>
    <td width="80" class="td_caption_1 Font_G">绿波</td>
  </tr>
  <tr class="Ball_tr_H">
    <td class="Jut_caption_1">正码一</td>
    <td ID="jeu_p_243"><INPUT type=radio <?=$drop_table[0][2]?> value=1 name=game1>
                  <FONT 
                        color=#0000ff><B><?=$drop_table[0][1]?>
						
						</B></FONT></td>
    <td ID="jeu_p_249"><INPUT type=radio <?=$drop_table[1][2]?> value=2 name=game1>
                  <FONT 
                        color=#0000ff><B><?=$drop_table[1][1]?></B></FONT></td>
    <td ID="jeu_p_231"><INPUT type=radio <?=$drop_table[2][2]?> value=3 name=game2>
                 <FONT 
                        color=#0000ff><B><?=$drop_table[2][1]?></B></FONT></td>
    <td ID="jeu_p_237"><INPUT type=radio <?=$drop_table[3][2]?> value=4 name=game2>
                  <FONT 
                        color=#0000ff><B><?=$drop_table[3][1]?></B></FONT></td>
    <td ID="jeu_p_255"><INPUT type=radio <?=$drop_table[4][2]?> value=5 name=game3>
                <FONT 
                        color=#0000ff><B><?=$drop_table[4][1]?></B></FONT></td>
    <td ID="jeu_p_261"><INPUT type=radio <?=$drop_table[6][2]?> value=7 name=game3>
                <FONT 
                        color=#0000ff><B><?=$drop_table[6][1]?></B></FONT></td>
    <td ID="jeu_p_267"><INPUT type=radio <?=$drop_table[5][2]?> value=6 name=game3>
                <FONT 
                        color=#0000ff><B><?=$drop_table[5][1]?></B></FONT></td>
  </tr>
  <tr class="Ball_tr_H">
    <td class="Jut_caption_1">正码二</td>
    <td ID="jeu_p_244"><INPUT type=radio <?=$drop_table[7][2]?> value=8 name=game4>
                  <FONT 
                        color=#0000ff><B><?=$drop_table[7][1]?></B></FONT></td>
    <td ID="jeu_p_250"><INPUT type=radio <?=$drop_table[8][2]?> value=9 name=game4>
                  <FONT 
                        color=#0000ff><B><?=$drop_table[8][1]?></B></FONT></td>
    <td ID="jeu_p_232"><INPUT type=radio <?=$drop_table[9][2]?> value=10 name=game5>
                 <FONT 
                        color=#0000ff><B><?=$drop_table[9][1]?></B></FONT></td>
    <td ID="jeu_p_238"><INPUT type=radio <?=$drop_table[10][2]?> value=11 name=game5>
                 <FONT 
                        color=#0000ff><B><?=$drop_table[10][1]?></B></FONT></td>
    <td ID="jeu_p_256"><INPUT type=radio <?=$drop_table[11][2]?> value=12 name=game6>
                <FONT 
                        color=#0000ff><B><?=$drop_table[11][1]?></B></FONT></td>
    <td ID="jeu_p_262"><INPUT type=radio <?=$drop_table[13][2]?> value=14 name=game6>
               <FONT 
                        color=#0000ff><B><?=$drop_table[13][1]?></B></FONT></td>
    <td ID="jeu_p_268"><INPUT type=radio <?=$drop_table[12][2]?> value=13 name=game6>
                <FONT 
                        color=#0000ff><B><?=$drop_table[12][1]?></B></FONT></td>
  </tr>
  <tr class="Ball_tr_H">
    <td class="Jut_caption_1">正码三</td>
    <td ID="jeu_p_245"><INPUT type=radio <?=$drop_table[14][2]?> value=15 name=game7>
                  <FONT 
                        color=#0000ff><B><?=$drop_table[14][1]?></B></FONT></td>
    <td ID="jeu_p_251"><INPUT type=radio <?=$drop_table[15][2]?> value=16 name=game7>
                 <FONT 
                        color=#0000ff><B><?=$drop_table[15][1]?></B></FONT></td>
    <td ID="jeu_p_233"><INPUT type=radio <?=$drop_table[16][2]?> value=17 name=game8>
                  <FONT 
                        color=#0000ff><B><?=$drop_table[16][1]?></B></FONT></td>
    <td ID="jeu_p_239"><INPUT type=radio <?=$drop_table[17][2]?> value=18 name=game8>
                 <FONT 
                        color=#0000ff><B><?=$drop_table[17][1]?></B></FONT></td>
    <td ID="jeu_p_257"><INPUT type=radio <?=$drop_table[18][2]?> value=19 name=game9>
               <FONT 
                        color=#0000ff><B><?=$drop_table[18][1]?></B></FONT></td>
    <td ID="jeu_p_263"><INPUT type=radio <?=$drop_table[20][2]?> value=21 name=game9>
                <FONT 
                        color=#0000ff><B><?=$drop_table[20][1]?></B></FONT></td>
    <td ID="jeu_p_269"><INPUT type=radio <?=$drop_table[19][2]?> value=20 name=game9>
                <FONT 
                        color=#0000ff><B><?=$drop_table[19][1]?></B></FONT></td>
  </tr>
  <tr class="Ball_tr_H">
    <td class="Jut_caption_1">正码四</td>
    <td ID="jeu_p_246"><INPUT type=radio <?=$drop_table[21][2]?> value=22 name=game10>
                  <FONT 

                        color=#0000ff><B><?=$drop_table[21][1]?></B></FONT></td>
    <td ID="jeu_p_252"><INPUT type=radio <?=$drop_table[22][2]?> value=23 name=game10>
                  <FONT 
                        color=#0000ff><B><?=$drop_table[22][1]?></B></FONT></td>
    <td ID="jeu_p_234"><INPUT type=radio <?=$drop_table[23][2]?> value=24 name=game11>
                 <FONT 
                        color=#0000ff><B><?=$drop_table[23][1]?></B></FONT></td>
    <td ID="jeu_p_240"><INPUT type=radio <?=$drop_table[24][2]?> value=25 name=game11>
                 <FONT color=#0000ff><B><?=$drop_table[24][1]?></B></FONT></td>
    <td ID="jeu_p_258"><INPUT type=radio <?=$drop_table[25][2]?> value=26 name=game12>
               <FONT 
                        color=#0000ff><B><?=$drop_table[25][1]?></B></FONT></td>
    <td ID="jeu_p_264"><INPUT type=radio <?=$drop_table[27][2]?> value=28 name=game12>
                <FONT 
                        color=#0000ff><B><?=$drop_table[27][1]?></B></FONT></td>
    <td ID="jeu_p_270"><INPUT type=radio <?=$drop_table[26][2]?> value=27 name=game12>
                <FONT 
                        color=#0000ff><B><?=$drop_table[26][1]?></B></FONT></td>
  </tr>
  <tr class="Ball_tr_H">
    <td class="Jut_caption_1">正码五</td>
    <td ID="jeu_p_247"><INPUT type=radio <?=$drop_table[28][2]?> value=29 name=game13>
                   <FONT 
                        color=#0000ff><B><?=$drop_table[28][1]?></B></FONT></td>
    <td ID="jeu_p_253"><INPUT type=radio <?=$drop_table[29][2]?> value=30 name=game13>
                  <FONT 
                        color=#0000ff><B><?=$drop_table[29][1]?></B></FONT></td>
    <td ID="jeu_p_235"><INPUT type=radio <?=$drop_table[30][2]?> value=31 name=game14>
                  <FONT 
                        color=#0000ff><B><?=$drop_table[30][1]?></B></FONT></td>
    <td ID="jeu_p_241"><INPUT type=radio <?=$drop_table[31][2]?> value=32 name=game14>
                 <FONT color=#0000ff><B><?=$drop_table[31][1]?></B></FONT></td>
    <td ID="jeu_p_259"><INPUT type=radio <?=$drop_table[32][2]?> value=33 name=game15>
                 <FONT 
                        color=#0000ff><B><?=$drop_table[32][1]?></B></FONT></td>
    <td ID="jeu_p_265"><INPUT type=radio <?=$drop_table[34][2]?> value=35 name=game15>
                <FONT 
                        color=#0000ff><B><?=$drop_table[34][1]?></B></FONT></td>
    <td ID="jeu_p_271"><INPUT type=radio <?=$drop_table[33][2]?> value=34 name=game15>
                <FONT 
                        color=#0000ff><B><?=$drop_table[33][1]?></B></FONT></td>
  </tr>
  <tr class="Ball_tr_H">
    <td class="Jut_caption_1">正码六</td>
    <td ID="jeu_p_248"><INPUT type=radio <?=$drop_table[35][2]?> value=36 name=game16>
                 <FONT 
                        color=#0000ff><B><?=$drop_table[35][1]?></B></FONT></td>
    <td ID="jeu_p_254"><INPUT type=radio <?=$drop_table[36][2]?> value=37 name=game16>
                 <FONT 
                        color=#0000ff><B><?=$drop_table[36][1]?></B></FONT></td>
    <td ID="jeu_p_236"><INPUT type=radio <?=$drop_table[37][2]?> value=38 name=game17>
                 <FONT 
                        color=#0000ff><B><?=$drop_table[37][1]?></B></FONT></td>
    <td ID="jeu_p_242"><INPUT type=radio <?=$drop_table[38][2]?> value=39 name=game17>
                 <FONT color=#0000ff><B><?=$drop_table[38][1]?></B></FONT></td>
    <td ID="jeu_p_260"><INPUT type=radio <?=$drop_table[39][2]?> value=40 name=game18>
               <FONT 
                        color=#0000ff><B><?=$drop_table[39][1]?></B></FONT></td>
    <td ID="jeu_p_266"><INPUT type=radio <?=$drop_table[41][2]?> value=42 name=game18>
                <FONT 
                        color=#0000ff><B><?=$drop_table[41][1]?></B></FONT></td>
    <td ID="jeu_p_272"><INPUT type=radio <?=$drop_table[40][2]?> value=41 name=game18>
                <FONT 
                        color=#0000ff><B><?=$drop_table[40][1]?></B></FONT></td>
  </tr>
</table>
<INPUT type=hidden value=过关 name=Current_items>
<table border="0" cellpadding="0" cellspacing="0" width="650" style="margin-top:15px;">
    <tr>
        <td id="M_ConfirmClew" align="center" class="font_r">
        <input class='but_c1' type="reset"  name="Submit3" value="重 填" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" />

        &nbsp;<input name="btnSubmit"  type="submit"  class="but_c1" id="btnSubmit" value="下 注" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" /></td>
    </tr>
</table>
</FORM>
<SCRIPT language=javascript>
if(self == top) location = '/';


var mess1 =  '请先下注!';
var mess2 =  '请选择二组以上玩法，若只要单一下注请前往正特投注!' ;
var mess3 =  '超出下注范围!';
function SubChk(obj) {
	var checkCount = 0;
	var checknum = obj.elements.length;
	
	for( i=0; i < checknum; i++ ) {
		if (obj.elements[i].checked) {
			checkCount ++;
		}
	}
	
	if (checkCount == 0)
	{
		alert(mess1);
		return false;
	}
	if (checkCount == 1)
	{
		alert(mess2);
		return false;
	}
	if (checkCount > 9)
	{
		alert(mess3);
		return false;
		//alert(checkCount);
		//document.lt_form.submit();
	}
	if (checkCount >= 2)
	{
		return true;
		//alert(checkCount);
		//document.lt_form.submit();
	}
}
</SCRIPT>
