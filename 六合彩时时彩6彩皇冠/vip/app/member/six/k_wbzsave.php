<? 
if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}
$zs=0;

$n=0;
for ($t=1;$t<=49;$t=$t+1){
if ($_POST['num'.$t]!=""){
$number1.=intval($_POST['num'.$t]).",";
$n=$n+1;
}
}


switch ($_POST['rtype']){

case "�岻��":
$mu=explode(",",$number1);
$mamama="1,1,1,1,1";
for ($d=0;$d<count($mu)-5;$d=$d+1){
for ($f=$d+1;$f<count($mu)-4;$f=$f+1){
for ($t=$f+1;$t<count($mu)-3;$t=$t+1){
for ($u=$t+1;$u<count($mu)-2;$u=$u+1){
for ($v=$u+1;$v<count($mu)-1;$v=$v+1){

$mama=$mama."/".$mu[$d].",".$mu[$f].",".$mu[$t].",".$mu[$u].",".$mu[$v];
}
}
}
}
}
$ff=explode("/",$mama);
for ($p=0;$p<count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
for ($k=0;$k<=3;$k=$k+1){
for ($f=k+1;$f<=4;$f=$f+1){
if ($un[$k]>$un[$f]){
$tmp=$un[$k];
$un[$k]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[3].",".$un[2].",".$un[1].",".$un[4];
}

for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){

}else{
$zzz=$zzz."/".$ff[$f];
}
}
break;



case "������":

$mu=explode(",",$number1);
$mamama="1,1,1,1,1,1";
for ($d=0;$d<count($mu)-6;$d=$d+1){
for ($f=$d+1;$f<count($mu)-5;$f=$f+1){
for ($t=$f+1;$t<count($mu)-4;$t=$t+1){
for ($u=$t+1;$u<count($mu)-3;$u=$u+1){
for ($v=$u+1;$v<count($mu)-2;$v=$v+1){
for ($w=$v+1;$w<count($mu)-1;$w=$w+1){
$mama=$mama."/".$mu[$d].",".$mu[$f].",".$mu[$t].",".$mu[$u].",".$mu[$v].",".$mu[$w];
}
}
}
}
}
}
$ff=explode("/",$mama);
for ($p=0;$p<count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
for ($k=0;$k<=4;$k=$k+1){
for ($f=k+1;$f<=5;$f=$f+1){
if ($un[$k]>$un[$f]){
$tmp=$un[$k];
$un[$k]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[4].",".$un[3].",".$un[2].",".$un[1].",".$un[5];
}
for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){
}else{
$zzz=$zzz."/".$ff[$f];
}
}
break;


case "�߲���":

$mu=explode(",",$number1);
$mamama="1,1,1,1,1,1,1";
for ($d=0;$d<count($mu)-7;$d=$d+1){
for ($f=$d+1;$f<count($mu)-6;$f=$f+1){
for ($t=$f+1;$t<count($mu)-5;$t=$t+1){
for ($u=$t+1;$u<count($mu)-4;$u=$u+1){
for ($v=$u+1;$v<count($mu)-3;$v=$v+1){
for ($w=$v+1;$w<count($mu)-2;$w=$w+1){
for ($x=$w+1;$x<count($mu)-1;$x=$x+1){
$mama=$mama."/".$mu[$d].",".$mu[$f].",".$mu[$t].",".$mu[$u].",".$mu[$v].",".$mu[$w].",".$mu[$x];
}
}
}
}
}
}
}
$ff=explode("/",$mama);
for ($p=0;$p<count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
for ($k=0;$k<=5;$k=$k+1){
for ($f=k+1;$f<=6;$f=$f+1){
if ($un[$k]>$un[$f]){
$tmp=$un[$k];
$un[$k]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[5].",".$un[4].",".$un[3].",".$un[2].",".$un[1].",".$un[6];
}
for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){
}else{
$zzz=$zzz."/".$ff[$f];
}
}
break;



case "�˲���":

$mu=explode(",",$number1);
$mamama="1,1,1,1,1,1,1,1";
for ($d=0;$d<count($mu)-8;$d=$d+1){
for ($f=$d+1;$f<count($mu)-7;$f=$f+1){
for ($t=$f+1;$t<count($mu)-6;$t=$t+1){
for ($u=$t+1;$u<count($mu)-5;$u=$u+1){
for ($v=$u+1;$v<count($mu)-4;$v=$v+1){
for ($w=$v+1;$w<count($mu)-3;$w=$w+1){
for ($x=$w+1;$x<count($mu)-2;$x=$x+1){
for ($y=$x+1;$y<count($mu)-1;$y=$y+1){
$mama=$mama."/".$mu[$d].",".$mu[$f].",".$mu[$t].",".$mu[$u].",".$mu[$v].",".$mu[$w].",".$mu[$x].",".$mu[$y];
}
}
}
}
}
}
}
}

$ff=explode("/",$mama);
for ($p=0;$p<count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
for ($k=0;$k<=6;$k=$k+1){
for ($f=k+1;$f<=7;$f=$f+1){
if ($un[$k]>$un[$f]){
$tmp=$un[$k];
$un[$k]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[6].",".$un[5].",".$un[4].",".$un[3].",".$un[2].",".$un[1].",".$un[7];
}
for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){
}else{
$zzz=$zzz."/".$ff[$f];
}
}
break;

case "�Ų���":

$mu=explode(",",$number1);
$mamama="1,1,1,1,1,1,1,1,1";
for ($d=0;$d<count($mu)-9;$d=$d+1){
for ($f=$d+1;$f<count($mu)-8;$f=$f+1){
for ($t=$f+1;$t<count($mu)-7;$t=$t+1){
for ($u=$t+1;$u<count($mu)-6;$u=$u+1){
for ($v=$u+1;$v<count($mu)-5;$v=$v+1){
for ($w=$v+1;$w<count($mu)-4;$w=$w+1){
for ($x=$w+1;$x<count($mu)-3;$x=$x+1){
for ($y=$x+1;$y<count($mu)-2;$y=$y+1){
for ($z=$y+1;$z<count($mu)-1;$z=$z+1){
$mama=$mama."/".$mu[$d].",".$mu[$f].",".$mu[$t].",".$mu[$u].",".$mu[$v].",".$mu[$w].",".$mu[$x].",".$mu[$y].",".$mu[$z];
}
}
}
}
}
}
}
}
}
$ff=explode("/",$mama);
for ($p=0;$p<count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
for ($k=0;$k<=7;$k=$k+1){
for ($f=k+1;$f<=8;$f=$f+1){
if ($un[$k]>$un[$f]){
$tmp=$un[$k];
$un[$k]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[7].",".$un[6].",".$un[5].",".$un[4].",".$un[3].",".$un[2].",".$un[1].",".$un[8];
}
for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){
}else{
$zzz=$zzz."/".$ff[$f];
}
}
break;


case "ʮ����":

$mu=explode(",",$number1);
$mamama="1,1,1,1,1,1,1,1,1,1";
for ($d=0;$d<count($mu)-10;$d=$d+1){
for ($f=$d+1;$f<count($mu)-9;$f=$f+1){
for ($t=$f+1;$t<count($mu)-8;$t=$t+1){
for ($u=$t+1;$u<count($mu)-7;$u=$u+1){
for ($v=$u+1;$v<count($mu)-6;$v=$v+1){
for ($w=$v+1;$w<count($mu)-5;$w=$w+1){
for ($x=$w+1;$x<count($mu)-4;$x=$x+1){
for ($y=$x+1;$y<count($mu)-3;$y=$y+1){
for ($z=$y+1;$z<count($mu)-2;$z=$z+1){
for ($g=$z+1;$g<count($mu)-1;$g=$g+1){
$mama=$mama."/".$mu[$d].",".$mu[$f].",".$mu[$t].",".$mu[$u].",".$mu[$v].",".$mu[$w].",".$mu[$x].",".$mu[$y].",".$mu[$z].",".$mu[$g];
}
}
}
}
}
}
}
}
}
}

$ff=explode("/",$mama);
for ($p=0;$p<count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
for ($k=0;$k<=8;$k=$k+1){
for ($f=k+1;$f<=9;$f=$f+1){
if ($un[$k]>$un[$f]){
$tmp=$un[$k];
$un[$k]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[8].",".$un[7].",".$un[6].",".$un[5].",".$un[4].",".$un[3].",".$un[2].",".$un[1].",".$un[9];
}
for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){
}else{
$zzz=$zzz."/".$ff[$f];
}
}
break;

case "ʮһ����":

$mu=explode(",",$number1);
$mamama="1,1,1,1,1,1,1,1,1,1,1";
for ($d=0;$d<count($mu)-11;$d=$d+1){
for ($f=$d+1;$f<count($mu)-10;$f=$f+1){
for ($t=$f+1;$t<count($mu)-9;$t=$t+1){
for ($u=$t+1;$u<count($mu)-8;$u=$u+1){
for ($v=$u+1;$v<count($mu)-7;$v=$v+1){
for ($w=$v+1;$w<count($mu)-6;$w=$w+1){
for ($x=$w+1;$x<count($mu)-5;$x=$x+1){
for ($y=$x+1;$y<count($mu)-4;$y=$y+1){
for ($z=$y+1;$z<count($mu)-3;$z=$z+1){
for ($g=$z+1;$g<count($mu)-2;$g=$g+1){
for ($h=$g+1;$h<count($mu)-1;$h=$h+1){
$mama=$mama."/".$mu[$d].",".$mu[$f].",".$mu[$t].",".$mu[$u].",".$mu[$v].",".$mu[$w].",".$mu[$x].",".$mu[$y].",".$mu[$z].",".$mu[$g].",".$mu[$h];
}
}
}
}
}
}
}
}
}
}
}

$ff=explode("/",$mama);
for ($p=0;$p<count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
for ($k=0;$k<=9;$k=$k+1){
for ($f=k+1;$f<=10;$f=$f+1){
if ($un[$k]>$un[$f]){
$tmp=$un[$k];
$un[$k]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[9].",".$un[8].",".$un[7].",".$un[6].",".$un[5].",".$un[4].",".$un[3].",".$un[2].",".$un[1].",".$un[10];
}
for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){
}else{
$zzz=$zzz."/".$ff[$f];
}
}
break;


case "ʮ������":

$mu=explode(",",$number1);
$mamama="1,1,1,1,1,1,1,1,1,1,1,1";
for ($d=0;$d<count($mu)-12;$d=$d+1){
for ($f=$d+1;$f<count($mu)-11;$f=$f+1){
for ($t=$f+1;$t<count($mu)-10;$t=$t+1){
for ($u=$t+1;$u<count($mu)-9;$u=$u+1){
for ($v=$u+1;$v<count($mu)-8;$v=$v+1){
for ($w=$v+1;$w<count($mu)-7;$w=$w+1){
for ($x=$w+1;$x<count($mu)-6;$x=$x+1){
for ($y=$x+1;$y<count($mu)-5;$y=$y+1){
for ($z=$y+1;$z<count($mu)-4;$z=$z+1){
for ($g=$z+1;$g<count($mu)-3;$g=$g+1){
for ($h=$g+1;$h<count($mu)-2;$h=$h+1){
for ($i=$h+1;$i<count($mu)-1;$i=$i+1){
$mama=$mama."/".$mu[$d].",".$mu[$f].",".$mu[$t].",".$mu[$u].",".$mu[$v].",".$mu[$w].",".$mu[$x].",".$mu[$y].",".$mu[$z].",".$mu[$g].",".$mu[$h].",".$mu[$i];
}
}
}
}
}
}
}
}
}
}
}
}

$ff=explode("/",$mama);
for ($p=0;$p<count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
for ($k=0;$k<=10;$k=$k+1){
for ($f=k+1;$f<=11;$f=$f+1){
if ($un[$k]>$un[$f]){
$tmp=$un[$k];
$un[$k]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[10].",".$un[9].",".$un[8].",".$un[7].",".$un[6].",".$un[5].",".$un[4].",".$un[3].",".$un[2].",".$un[1].",".$un[11];
}
for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){
}else{
$zzz=$zzz."/".$ff[$f];
}
}
break;

}


switch ($_POST['rtype']){

case "�岻��":
$rtype="�岻��";
$rate_id=1101;
$zs=$n*($n-1)*($n-2)*($n-3)*($n-4)/120;
$R=37;
break;

case "������":
$rtype="������";
$rate_id=1151;
$zs=$n*($n-1)*($n-2)*($n-3)*($n-4)*($n-5)/720;
$R=38;
break;

case "�߲���":
$rtype="�߲���";
$rate_id=1201;
$zs=$n*($n-1)*($n-2)*($n-3)*($n-4)*($n-5)*($n-6)/5040;
$R=39;
break;

case "�˲���":
$rtype="�˲���";
$rate_id=1251;
$zs=$n*($n-1)*($n-2)*($n-3)*($n-4)*($n-5)*($n-6)*($n-7)/40320;
$R=40;
break;

case "�Ų���":
$rtype="�Ų���";
$rate_id=1501;
$zs=$n*($n-1)*($n-2)*($n-3)*($n-4)*($n-5)*($n-6)*($n-7)*($n-8)/362880;
$R=41;
break;

case "ʮ����":
$rtype="ʮ����";
$rate_id=1551;
$zs=$n*($n-1)*($n-2)*($n-3)*($n-4)*($n-5)*($n-6)*($n-7)*($n-8)*($n-9)/3628800;
$R=42;
break;

case "ʮһ����":
$rtype="ʮһ����";
$rate_id=1601;
$zs=$n*($n-1)*($n-2)*($n-3)*($n-4)*($n-5)*($n-6)*($n-7)*($n-8)*($n-9)*($n-10)/39916800;
$R=43;
break;

case "ʮ������":
$rtype="ʮ������";
$rate_id=1651;
$zs=$n*($n-1)*($n-2)*($n-3)*($n-4)*($n-5)*($n-6)*($n-7)*($n-8)*($n-9)*($n-10)*($n-11)/479001600;
$R=44;
break;

}


$result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='ȫ����' and class2='".$rtype."'  order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
$sum_money=$ka_guanuserkk1[0];


if ($zs==0){

if ($_POST['rtype']=="�岻��"){
echo "<script>alert('��ѡ������ʮ������!');window.location.href='index.php?action=left';</script>"; 
exit;
}
if ($_POST['rtype']=="������"){
echo "<script>alert('��ѡ������ʮ������!');window.location.href='index.php?action=left';</script>"; 
exit;
}
if ($_POST['rtype']=="�߲���"){
echo "<script>alert('��ѡ������ʮ������!');window.location.href='index.php?action=left';</script>"; 
exit;
}
if ($_POST['rtype']=="�˲���"){
echo "<script>alert('��ѡ�����ʮ������!');window.location.href='index.php?action=left';</script>"; 
exit;
}
if ($_POST['rtype']=="�Ų���"){
echo "<script>alert('��ѡ�����ʮһ������!');window.location.href='index.php?action=left';</script>"; 
exit;
}
if ($_POST['rtype']=="ʮ����"){
echo "<script>alert('��ѡ��ʮ��ʮ��������!');window.location.href='index.php?action=left';</script>"; 
exit;
}
if ($_POST['rtype']=="ʮһ����"){
echo "<script>alert('��ѡ��ʮһ��ʮ��������!');window.location.href='index.php?action=left';</script>"; 
exit;
}
if ($_POST['rtype']=="ʮ������"){
echo "<script>alert('��ѡ��ʮ����ʮ�ĸ�����!');window.location.href='index.php?action=left';</script>"; 
exit;
}





}

$XF=21;

?>
<HTML>
<HEAD>


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
</style><meta http-equiv="Content-Type" content="text/html; charset=gb2312"></HEAD>
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

function SubChk($zs){
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
if(eval(document.all.gold.value) > <?=ka_memds($R,2)?>){
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
//document.all.gold.focus();
alert("��ע���ɴ�����ö��!!");
return false;
}


document.all.btnCancel.disabled = true;
document.all.btnSubmit.disabled = true;
document.LAYOUTFORM.submit();
}
function CountWinGold(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('δ������ע���!!!');
}else{
//document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value /1000 - document.all.gold.value);
document.all.pc1.innerHTML=Math.round(document.all.gold.value * document.all.ioradio1.value);
count_win=true;
}
}
function CountWinGold1(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('δ������ע���!!!');
}else{
document.all.pc1.innerHTML=Math.round(document.all.gold.value * document.all.ioradio1.value);
count_win=true;
}
}
</SCRIPT>


<noscript>
<iframe scr=��*.htm��></iframe>
</noscript>
<?

if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=6fba2c><font color=ffff00>������....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"�뿪\" name=\"btnCancel11\" /></font></td>          </tr>      </table>"; 
  exit;
}


?>

<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=230 border=0>
  <tr>
    <td valign="top" class="Left_Place">
                <TABLE class=t_list cellSpacing=1 cellPadding=0 width=210 border=0>
      <tr>
        <td height="25" colspan="2" align="center" bgcolor="#5A79C6"><span class="STYLE1">ȷ����ע</span></td>
      </tr>
      <tr>
        <td width="35%" height="25" align="right" class=t_td_caption_1><span class="STYLE1">�˺�����</span></td>
        <td width="65%" class=t_td_text><span class="STYLE2">
          <?=ka_memuser("kauser")?>
        </span></td>
      </tr>
      <tr>
        <td height="25" align="right" class=t_td_caption_1><span class="STYLE1">��Ա���� </span></td>
        <td class=t_td_text><span class="STYLE2">
          <?=ka_memuser("abcd")?>
          ��</span></td>
      </tr>
      <tr>
        <td height="25" align="right" class=t_td_caption_1><span class="STYLE1">�����ö�</span></td>
        <td class=t_td_text><span class="STYLE2">��
          <?=ka_memuser("cs")?>
          Ԫ</span></td>
      </tr>
      <tr>
        <td height="25" align="right" class=t_td_caption_1><span class="STYLE1">�������</span></td>
        <td class=t_td_text><span class="STYLE2">��
          <?=ka_memuser("ts")?>
          Ԫ</span></td>
      </tr>
      <tr>
        <td height="25" align="right" class=t_td_caption_1><span class="STYLE1">��ע�ܶ�</span></td>
        <td class=t_td_text><span class="STYLE2">
          <? 
	    $result2 = mysql_query("Select SUM(sum_m) As sum_m1   From ka_tan Where kithe=".$Current_Kithe_Num."  and   username='".$_SESSION['username']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	
	?>
          ��<? echo $mkmk;?>Ԫ</span></td>
      </tr>
      <tr>
        <td height="25" align="right" class=t_td_caption_1><span class="STYLE1">��ǰ����</span></td>
        <td class=t_td_text><span class="STYLE2">
          <?=$Current_Kithe_Num?>
          ��</span></td>
      </tr>
      <FORM name=LAYOUTFORM onSubmit="return false" action=index.php?action=k_tanwbz method=post >
        <tr>
          <td width="35%" colspan="2" height="25" bgcolor="#ffffff" align="center" style="LINE-HEIGHT: 22px"><div align="center"><FONT color=#cc0000>&nbsp;<?=$_POST['rtype']?>  </FONT> </div><?=$number1?></td>
        </tr>
        <tr>
          <td height="25" colspan="2" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><div align="center"><strong>��Ϲ�&nbsp;<font color=ff0000><?=$zs?></font>&nbsp;��</strong></div></td>
        </tr>
        <tr>
          <td height="25" colspan="2" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;��ע���:<?=$_POST['jq']?>
            <INPUT type="hidden" name=gold id=gold  value="<?=$_POST['jq']?>" ></td>
        </tr>
        <tr>
          <td height="25" colspan="2" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;����ע���: <strong><FONT id=pc1 color=#ff0000><?=$_POST['jq']*$zs?>&nbsp;</FONT></strong></td>
        </tr>
        <TR>
          <TD height="25" colspan="2" bgcolor="#ffffff">&nbsp;��ע�޶�: <?=ka_memds($R,2)?></TD>
        </TR>
        <TR>
          <TD height="25" colspan="2" bgcolor="#ffffff">&nbsp;�����޶�: <?=ka_memds($R,3)?></TD>
        </TR>
        <tr>
          <td height="25" colspan="2" align="center" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><INPUT type='hidden' Name=rate_id value='<?=$rate_id?>'>
          
              <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="����" name="btnCancel" />
			  
            &nbsp;&nbsp;
            <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type="submit" value="ȷ��" onClick="SubChk(<?=$zs?>);" name="btnSubmit" /></td>
        </tr>
        <INPUT type=hidden value=SP11 name=concede>
        <INPUT type=hidden value='<?=ka_bl($rate_id,"rate")*1000?>' name=ioradio>
        <INPUT type=hidden value='<?=$zs?>' name=ioradio1>
        <INPUT type=hidden value='<?=$zzz?>' name=number1>
         <input name=rtype type=hidden id="rtype" value='<?=$_POST['rtype']?>'>
      </FORM>
     
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3"></td>
      </tr>
    </table></td>
</tr>
</table>
</BODY></HTML>
