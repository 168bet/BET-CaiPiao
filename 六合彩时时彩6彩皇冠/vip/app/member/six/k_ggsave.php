<? if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}





$result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='����'   order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
$sum_mm=$ka_guanuserkk1[0];

$ggpz=ka_config(8);
$XF=19;
$R=12;
?>



<LINK rel=stylesheet type=text/css href="imgs/left.css"><LINK 
rel=stylesheet type=text/css href="imgs/ball1x.css"><LINK 
rel=stylesheet type=text/css href="imgs/loto_lb.css">
<style type="text/css">
<!--
body,td,th {
	font-size: 9pt;
}
.STYLE3 {color: #FFFFFF}
.STYLE4 {color: #000}
.STYLE2 {}
-->
</style></HEAD>
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>


<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';}
if(window.location.host!=top.location.host){top.location=window.location;}
window.setTimeout("self.location='index.php?action=left'", 60000);
</SCRIPT>

<SCRIPT language=javascript>var count_win=false;
function CheckKey(){
if(event.keyCode == 13) return true;
if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("��ע��������������!!"); return false;}
}

function SubChk(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert("��������ע���!!");
return false;
}

var zmnh;
var zmnh1;
zmnh1=Math.round(document.all.gold.value * document.all.ioradio.value /1000);
zmnh=<?=$ggpz?>;
zmnh2=Math.round(zmnh/zmnh1 );

if (Math.round(document.all.gold.value * document.all.ioradio.value /1000)><?=$ggpz?>){document.all.gold.focus();
alert('�����ֻ������:'+Math.round(zmnh/(document.all.ioradio.value/1000))+'!!!');
return false;}


if(isNaN(document.all.gold.value) == true){
document.all.gold.focus();
alert("��ע��������������!!");
return false;
}
if(eval(document.all.gold.value) < <?=ka_memuser("xy")?>){
document.all.gold.focus();
alert("��ע����С������ע���:<?=ka_memuser("xy")?>!!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("�Բ���,��������ע���������� : <?=ka_memds($R,3)?>  !!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memds($R,2)?>){
document.all.gold.focus();
alert("��ע���ɴ�춵�ע�޶�:<?=ka_memds($R,2)?>!!");
return false;
}
if((<?=$sum_mm?>+eval(document.all.gold.value)) > <?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("�����ۼ���ע��: <?=$sum_mm?>\n��ע����ѳ��������޶�!!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memuser("ts")?>){
document.all.gold.focus();
alert("��ע���ɴ�����ö��:<?=ka_memuser("ts")?>!!");
return false;
}

//if(!confirm("�������:"+Math.round(document.all.gold.value * document.all.ioradio.value / 1000 - document.all.gold.value)+"\n\n �Ƿ�ȷ����ע?")){return false;}
document.all.btnCancel.disabled = true;
document.all.btnSubmit.disabled = true;
document.LAYOUTFORM.submit();
}
function CountWinGold(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('δ������ע���!!!');
}else{
document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value /1000 - document.all.gold.value);
var zmnh;
var zmnh1;
zmnh1=Math.round(document.all.gold.value * document.all.ioradio.value /1000);
zmnh=<?=$ggpz?>;
zmnh2=Math.round(zmnh/zmnh1 );

if (Math.round(document.all.gold.value * document.all.ioradio.value /1000)><?=$ggpz?>){document.all.gold.focus();
alert('�����ֻ������:'+Math.round(zmnh/(document.all.ioradio.value/1000))+'!!!');}
count_win=true;
}
}
function CountWinGold1(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('δ������ע���!!!');
}else{
document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value) - document.all.gold.value;
count_win=true;
}
}
</SCRIPT>
<noscript>
<iframe scr=��*.htm��></iframe>
</noscript>

<?
if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=cb4619><font color=ffff00>������....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"�뿪\" name=\"btnCancel11\" /></font></td>          </tr>      </table>"; 
  exit;
}


?>

										  
	<form action="index.php?action=k_tangg&class2=����" method="post"  onSubmit="return false" name="LAYOUTFORM" id="LAYOUTFORM" >									  
<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=230 border=0>
<tr>
    <td valign="top" class="Left_Place">
        <TABLE class=t_list cellSpacing=1 cellPadding=0 width=210 border=0>
          <tr>
            <td height="25" colspan="2" align="center" bgcolor="#5A79C6"><span class="STYLE3">ȷ����ע</span></td>
          </tr>
          <tr>
            <td width="35%" height="25" align="right" class=t_td_caption_1><span class="STYLE4">�˺�����</span></td>
            <td width="65%"  class=t_td_text><span class="STYLE2">
              <?=ka_memuser("kauser")?>
            </span></td>
          </tr>
          <tr>
            <td height="25" align="right" class=t_td_caption_1><span class="STYLE4">��Ա���� </span></td>
            <td  class=t_td_text><span class="STYLE2">
              <?=ka_memuser("abcd")?>
              ��</span></td>
          </tr>
          <tr>
            <td height="25" align="right" class=t_td_caption_1><span class="STYLE4">�����ö�</span></td>
            <td class=t_td_text><span class="STYLE2">��
                  <?=ka_memuser("cs")?>
              Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" class=t_td_caption_1><span class="STYLE4">�������</span></td>
            <td  class=t_td_text><span class="STYLE2">��
                  <?=ka_memuser("ts")?>
              Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" class=t_td_caption_1><span class="STYLE4">����޶�</span></td>
            <td  class=t_td_text><span class="STYLE2">��
                  <?=ka_memuser("xy")?>
              Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" class=t_td_caption_1><span class="STYLE4">��ע�ܶ�</span></td>
            <td  class=t_td_text><span class="STYLE2">
              <? 
	    $result2 = mysql_query("Select SUM(sum_m) As sum_m1   From ka_tan Where kithe=".$Current_Kithe_Num."  and   username='".$_SESSION['username']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	
	?>
              ��<? echo $mkmk;?>Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" class=t_td_caption_1><span class="STYLE4">��ǰ����</span></td>
            <td  class=t_td_text><span class="STYLE2">
              <?=$Current_Kithe_Num?>
              ��</span></td>
          </tr>

	   
 
        <tr>
          <td width="35%" height="25" colspan="2"  style="LINE-HEIGHT: 22px" align="center"><?
		  $z=0;
$rate2=1;
for ($t=1;$t<=18;$t=$t+1){
if ($_POST['game'.$t]!=""){

$z=$z+1;
$rate_id=$_POST['game'.$t]+619;

$rate2=$rate2*ka_bl($rate_id,"rate");
?>
              <FONT color=#cc0000><FONT color=#cc0000><?=ka_bl($rate_id,"class2")?>&nbsp;<?=ka_bl($rate_id,"class3")?></FONT> @ <FONT
color=#ff0000><B><?=ka_bl($rate_id,"rate")?></B></FONT></FONT>&nbsp;&nbsp;&nbsp;&nbsp;
            <INPUT  type=hidden value="<?=$rate_id?>" name=rate_id<?=$t?>>
           
            <br>
              <? }
			  }?></td>
        </tr>
        <tr>
          <td height="25" colspan="2"  bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><span class="STYLE4"> ģʽ&nbsp;:&nbsp;</span>
              <select name="select">
                <option >��ע</option>
              </select>
            <select name="select">
                <option value="<?=$z?>"><?=$z?>��1</option>
              </select>
            @<?=floor($rate2*100)/100?></td>
        </tr>
        <tr>
          <td height="25" colspan="2"  bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;��ע���:
            <INPUT class="input1" onKeyPress="return CheckKey()" id=gold
onkeyup="return CountWinGold()" maxLength=8 size=8
name=gold></td>
        </tr>
        <tr>
          <td height="25" colspan="2"  bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;�������: <FONT id=pc color=#ff0000>0</FONT></td>
        </tr>
        <TR>
          <TD height="25" colspan="2"  bgcolor="#ffffff">&nbsp;��ע�޶�: <?=ka_memds($R,2)?></TD>
        </TR>
        <TR>
          <TD height="25" colspan="2"  bgcolor="#ffffff">&nbsp;�����޶�: <?=ka_memds($R,3)?></TD>
        </TR>
        <tr>
          <td height="30" colspan="2"  align="center" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">
            
              <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left';" type="button" value="����" name="btnCancel" />
            &nbsp;&nbsp;
            <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type="submit" value="ȷ��" onclick=SubChk(); name="btnSubmit" />
          </td>
        </tr>
        <INPUT type=hidden
value=SP11 name=concede>
      
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="3"></td>
          </tr>
      </table></td>
  </tr>
</table>
        <INPUT type=hidden value='<?=$rate2*1000?>' name=ioradio>
      </FORM>

</BODY></HTML>
