<? if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}

if ($_GET['class2']==""){echo "<script>alert('�Ƿ�����!');window.location.href='index.php?action=left';</script>"; 
exit;}

$n=0;
for ($t=0;$t<=12;$t=$t+1){

if ($_POST['num'.$t]!=""){	
$number1.=$_POST['num'.$t].",";
$n=$n+1;
}
}
$number3=$number1;

$result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='��Ф��' and class2='".$_GET['class2']."'  order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
$sum_mm=$ka_guanuserkk1[0];



switch ($_GET['class2']){
 

 case "��Ф����":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=48;	
$XF=23;
$rate_id=1401;
if ($n<2 or $n>8){echo "<script>alert('�Բ�����ѡ���-�˸���Ф!');window.location.href='index.php?action=left';</script>"; 
exit;}
$zs=$n*($n-1)/2;

$mu=explode(",",$number1);
$mama=$mu[0].",".$mu[1];
for ($f=0;$f<count($mu)-2;$f=$f+1){
for ($t=2;$t<count($mu)-1;$t=$t+1){
if ($f!=$t and $f<$t){
$mama=$mama."/".$mu[$f].",".$mu[$t];
}
}
}
break;

case "��Ф����":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=49;	
$XF=23;
$rate_id=1413;
if ($n<3 or $n>8){echo "<script>alert('�Բ�����ѡ����-�˸���Ф!');window.location.href='index.php?action=left';</script>"; 
exit;}
$zs=$n*($n-1)*($n-2)/6;


$mu=explode(",",$number1);
$mama=$mu[0].",".$mu[1].",".$mu[2];
for ($h=0;$h<count($mu)-3;$h=$h+1){
for ($f=1;$f<count($mu)-2;$f=$f+1){
for ($t=3;$t<count($mu)-1;$t=$t+1){
if ($h!=$f and $h<$f and $f!=$t and $f<$t){
$mama=$mama."/".$mu[$h].",".$mu[$f].",".$mu[$t];
}
}
}
}

break;

case "��Ф����":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=50;	
$XF=23;
$rate_id=1425;
if ($n<4 or $n>8){echo "<script>alert('�Բ�����ѡ����-�˸���Ф!');window.location.href='index.php?action=left';</script>"; 
exit;}
$zs=$n*($n-1)*($n-2)*($n-3)/24;



$mu=explode(",",$number1);
$mama=$mu[0].",".$mu[1].",".$mu[2].",".$mu[3];
for ($h=0;$h<count($mu)-4;$h=$h+1){
for ($f=1;$f<count($mu)-3;$f=$f+1){
for ($t=2;$t<count($mu)-2;$t=$t+1){
for ($s=4;$s<count($mu)-1;$s=$s+1){
if ($h!=$f and $h<$f and $f!=$t and $f<$t and $t!=$s and $t<$s){
$mama=$mama."/".$mu[$h].",".$mu[$f].",".$mu[$t].",".$mu[$s];
}
}
}
}
}

break;


case "��Ф����":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=51;	
$XF=23;
$rate_id=1473;
if ($n<5 or $n>8){echo "<script>alert('�Բ�����ѡ����-�˸���Ф!');window.location.href='index.php?action=left';</script>"; 
exit;}
$zs=$n*($n-1)*($n-2)*($n-3)*($n-4)/120;



$mu=explode(",",$number1);
$mama=$mu[0].",".$mu[1].",".$mu[2].",".$mu[3].",".$mu[4];
for ($h=0;$h<count($mu)-5;$h=$h+1){
for ($f=1;$f<count($mu)-4;$f=$f+1){
for ($t=2;$t<count($mu)-3;$t=$t+1){
for ($s=3;$s<count($mu)-2;$s=$s+1){
for ($u=5;$u<count($mu)-1;$u=$u+1){
if ($h!=$f and $h<$f and $f!=$t and $f<$t and $t!=$s and $t<$s and $s!=$u and $s<$u){
$mama=$mama."/".$mu[$h].",".$mu[$f].",".$mu[$t].",".$mu[$s].",".$mu[$u];
}
}
}
}
}
}
break;


 case "��Ф������":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=52;	
$XF=23;
$rate_id=1437;
if ($n<2 or $n>8){echo "<script>alert('�Բ�����ѡ���-�˸���Ф!');window.location.href='index.php?action=left';</script>"; 
exit;}
$zs=$n*($n-1)/2;

$mu=explode(",",$number1);
$mama=$mu[0].",".$mu[1];
for ($f=0;$f<count($mu)-2;$f=$f+1){
for ($t=2;$t<count($mu)-1;$t=$t+1){
if ($f!=$t and $f<$t){
$mama=$mama."/".$mu[$f].",".$mu[$t];
}
}
}

break;

case "��Ф������":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=53;	
$XF=23;
$rate_id=1449;
if ($n<3 or $n>8){echo "<script>alert('�Բ�����ѡ����-�˸���Ф!');window.location.href='index.php?action=left';</script>"; 
exit;}
$zs=$n*($n-1)*($n-2)/6;


$mu=explode(",",$number1);
$mama=$mu[0].",".$mu[1].",".$mu[2];
for ($h=0;$h<count($mu)-3;$h=$h+1){
for ($f=1;$f<count($mu)-2;$f=$f+1){
for ($t=3;$t<count($mu)-1;$t=$t+1){
if ($h!=$f and $h<$f and $f!=$t and $f<$t){
$mama=$mama."/".$mu[$h].",".$mu[$f].",".$mu[$t];
}
}
}
}
break;

case "��Ф������":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=50;	
$XF=23;
$rate_id=1461;
if ($n<4 or $n>8){echo "<script>alert('�Բ�����ѡ����-�˸���Ф!');window.location.href='index.php?action=left';</script>"; 
exit;}
$zs=$n*($n-1)*($n-2)*($n-3)/24;

$mu=explode(",",$number1);
$mama=$mu[0].",".$mu[1].",".$mu[2].",".$mu[3];
for ($h=0;$h<count($mu)-4;$h=$h+1){
for ($f=1;$f<count($mu)-3;$f=$f+1){
for ($t=2;$t<count($mu)-2;$t=$t+1){
for ($s=4;$s<count($mu)-1;$s=$s+1){
if ($h!=$f and $h<$f and $f!=$t and $f<$t and $t!=$s and $t<$s){
$mama=$mama."/".$mu[$h].",".$mu[$f].",".$mu[$t].",".$mu[$s];
}
}
}
}
}
break;

}

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

<SCRIPT language=javascript>
window.setTimeout("self.location='index.php?action=left'", 30000);
</SCRIPT>
<SCRIPT language=JAVASCRIPT>
if(self == top){location = '/';}

function ChkSubmit(){
    //�趨��ȷ������Ϊ���� 


		document.all.btnSubmit.disabled = true;
	
document.form1.submit();
	} 
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
if(eval(document.all.gold.value)*<?=$zs?> > <?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("�Բ���,��������ע���������� : <?=ka_memds($R,3)?>  !!");
return false;
}
if(eval(document.all.gold.value)> <?=ka_memds($R,2)?>){
document.all.gold.focus();
alert("��ע���ɴ�춵�ע�޶�:<?=ka_memds($R,2)?>!!");
return false;
}
if((<?=$sum_money?>+eval(document.all.gold.value)*<?=$zs?>) ><?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("�����ۼ���ע��: <?=$sum_money?>\n��ע����ѳ��������޶�!!");
return false;
}
if((eval(document.all.gold.value)*<?=$zs?>) > <?=ka_memuser("ts")?>){
document.all.gold.focus();
alert("��ע���ɴ�����ö��!!");
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
//document.all.pc1.innerHTML=Math.round(document.all.gold.value * document.all.ioradio1.value);
count_win=true;
}
}
//function CountWinGold1(){
//if(document.all.gold.value==''){
//document.all.gold.focus();
//alert('δ������ע���!!!');
//}
//else{
//document.all.pc1.innerHTML=Math.round(document.all.gold.value * document.all.ioradio1.value);
//count_win=true;
//}
//}
</SCRIPT>
<noscript>
<iframe scr=��*.htm��></iframe>
</noscript>

<?
if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=006600><font color=ffff00>������....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"�뿪\" name=\"btnCancel11\" /></font></td>          </tr>      </table>"; 
  exit;
}


?>

										  
										  
<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=230 border=0>
  <tr>
    <td valign="top" class="Left_Place">
                <TABLE class=t_list cellSpacing=1 cellPadding=0 width=210 border=0>
          <tr>
            <td height="25" colspan="2" align="center" bgcolor="#5A79C6"><span class="STYLE3">ȷ����ע</span></td>
          </tr>
          <tr>
            <td width="35%" height="25" align="right" class=t_td_caption_1><span class="STYLE4">�˺�����</span></td>
            <td width="65%" class=t_td_text><span class="STYLE2">
              <?=ka_memuser("kauser")?>
            </span></td>
          </tr>
          <tr>
            <td height="25" align="right" class=t_td_caption_1><span class="STYLE4">��Ա���� </span></td>
            <td class=t_td_text><span class="STYLE2">
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
            <td class=t_td_text><span class="STYLE2">��
                  <?=ka_memuser("ts")?>
              Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" class=t_td_caption_1><span class="STYLE4">����޶�</span></td>
            <td class=t_td_text><span class="STYLE2">��
                  <?=ka_memuser($R,7)?>
				  <?=ka_memuser("xy")?>
              Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" class=t_td_caption_1><span class="STYLE4">��ע�ܶ�</span></td>
            <td class=t_td_text><span class="STYLE2">
              <? 
	    $result2 = mysql_query("Select SUM(sum_m) As sum_m1   From ka_tan Where kithe=".$Current_Kithe_Num."  and   username='".$_SESSION['username']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	
	?>
              ��<? echo $mkmk;?>Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" class=t_td_caption_1><span class="STYLE4">��ǰ����</span></td>
            <td class=t_td_text><span class="STYLE2">
              <?=$Current_Kithe_Num?>
              ��</span></td>
          </tr>

          <form action="index.php?action=k_tansxt2&class2=<?=$_GET['class2']?>" method="post" name="LAYOUTFORM" id="form1" onsubmit="return false">
		

            <tr>
              <td width="35%" colspan="2" height="25" align="center" bgcolor="#F9F7D7" style="LINE-HEIGHT: 22px"><?=ka_bl($rate_id,"class2")?></FONT> 
                  </div><div align="center"><b><?=$number1?></b></div></td>
            </tr>
        <tr>
          <td height="25" bgcolor="#ffffff" colspan="2" style="LINE-HEIGHT: 23px"><div align="center"><strong>��Ϲ�&nbsp;<font color=ff0000><?=$zs?></font>&nbsp;��</strong></div></td>
        </tr>
            <tr>
              <td height="25" colspan="2" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;��ע���:
             <INPUT
name=gold id=gold onKeyPress="return CheckKey()"
onkeyup="return CountWinGold()" value="<?=$_POST['Num_1']?>" size=8 maxLength=8>
              </td>
            </tr>
        <tr>
          <td height="25" colspan="2" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;����ע���: <strong><FONT id=pc1 color=#ff0000><?=$_POST['Num_1']*$zs?>&nbsp;</FONT></strong></td>
        </tr>
            <tr>
              <td height="25" colspan="2" bgcolor="#ffffff">&nbsp;��ע�޶�: <?=ka_memds($R,2)?></td>
            </tr>
            <tr>
              <td height="25" colspan="2" bgcolor="#ffffff">&nbsp;�����޶�: <?=ka_memds($R,3)?></td>
            </tr>
            <tr>
              <td height="30" colspan="2" align="center" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><input type='hidden' name="rate_id" value='<?=$rate_id?>' />
              <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left';" type="button" value="����" name="btnCancel" />
                  
                &nbsp;&nbsp;
                <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type="submit" value="ȷ��" onclick="SubChk(<?=$zs?>);" name="btnSubmit" />
              </td>
            </tr>
            <input type="hidden"
value="SP11" name="concede" />
            <input type="hidden" value='<?=ka_bl($rate_id,"rate")*1000?>' name="ioradio" />
            <input type="hidden" value='<?=$zs?>' name="ioradio1" />
            <input type="hidden" value='<?=$mama?>' name="number1" />
            <INPUT type=hidden value='<?=$number3?>' name=number3>
          </form>
        </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="3"></td>
          </tr>
      </table></td>
  </tr>
</table>
</BODY></HTML>
