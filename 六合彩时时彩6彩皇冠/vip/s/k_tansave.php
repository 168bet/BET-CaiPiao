<? if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}

if ($_GET['class2']==""){echo "<script>alert('�Ƿ�����!');parent.parent.mem_order.location.href='index.php?action=k_tm.asp';window.location.href='index.php?action=left';</script>"; 
exit;}


function ka_memdaids($i,$b){
$dai=ka_memuser("dan");
$result=mysql_query("Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username='".$dai."' order by id");
$drop_guands = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
array_push($drop_guands,$image);
}
return $drop_guands[$i][$b];
}

function ka_memzongds($i,$b){
$zong=ka_memuser("zong");
$result=mysql_query("Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username='".$zong."' order by id");
$drop_guands = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
array_push($drop_guands,$image);
}
return $drop_guands[$i][$b];
}
function ka_memguands($i,$b){
$guan=ka_memuser("guan");
//echo "Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username='".$guan."' order by id";
$result=mysql_query("Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username='".$guan."' order by id");
$drop_guands = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
array_push($drop_guands,$image);
}
return $drop_guands[$i][$b];
}




switch ($_GET['class2']){

        case "��A":
	
$XF=11;
$mumu=0;
$urlurl="index.php?action=k_tm&ids=��A";
$numm=66;
break;
        case "��B" : 
		      
$XF=11;
$mumu=58;
$numm=66;
$urlurl="index.php?action=k_tm&ids=��B";

break;
 case "��A":
$XF=15;
 $mumu=464;
   $urlurl="index.php?action=k_zm&ids=��A";
   $numm=58;
break;
 case "��B":  
$XF=15;
$mumu=517;
$numm=58;
$urlurl="index.php?action=k_zm&ids=��B";
break;

case "��1��":
$XF=13;
$mumu=116;
$urlurl="index.php?action=k_zt&ids=��1��";
$numm=60;
break;

case "��2��":
$XF=13;
$mumu=174;
$urlurl="index.php?action=k_zt&ids=��2��";
$numm=60;
break;

case "��3��":
$XF=13;
$mumu=232;
$urlurl="index.php?action=k_zt&ids=��3��";
$numm=60;
break;

case "��4��":
$XF=13;
$mumu=290;
$urlurl="index.php?action=k_zt&ids=��4��";
$numm=60;
break;

case "��5��":
$XF=13;
$mumu=348;
$urlurl="index.php?action=k_zt&ids=��5��";
$numm=60;
break;

case "��6��":
$XF=13;
$mumu=406;
$urlurl="index.php?action=k_zt&ids=��6��";
$numm=60;
break;

case "��1-6":
$XF=13;
$mumu=570;
$urlurl="index.php?action=k_zm6&ids=��1-6";
$numm=78;
break;

case "����":
$XF=17;
$mumu=712;
$urlurl="index.php?action=k_wx&ids=����";
$numm=5;

break;

case "�벨":
$XF=25;
$mumu=661;
$urlurl="index.php?action=k_bb&ids=�벨";
$numm=18;
break;
case "��벨":
$XF=25;
$mumu=751;
$urlurl="index.php?action=k_bbb&ids=��벨";
$numm=12;
break;

case "��Ф":
$XF=25;
$mumu=782;
$urlurl="index.php?action=k_qsb&ids=��Ф";
$numm=12;
break;
case "��ɫ��":
$XF=25;
$mumu=778;
$urlurl="index.php?action=k_qsb&ids=��Ф";
$numm=4;
break;

case "β��":
$XF=27;
$mumu=689;
$urlurl="index.php?action=k_ws&ids=β��";
$numm=79;
break;
case "��Ф":
$XF=23;
$mumu=673;
$urlurl="index.php?action=k_sx&ids=��Ф";
$numm=12;
break;

case "һФ":
$XF=23;
$mumu=699;
$urlurl="index.php?action=k_sxp&ids=һФ";
$numm=12;
break;

case "����β��":
$XF=23;
$mumu=768;
$urlurl="index.php?action=k_sxp&ids=һФ";
$numm=12;
break;

case "����":
$XF=19;
break;
case "����":
$XF=21;

break;
    default:
$mumu=0;
$numm=58;
$urlurl="index.php?action=k_tm&ids=��A";

$XF=11;
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


<noscript>
<iframe scr=��*.htm��></iframe>
</noscript>
<?
if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=cb4619><font color=ffff00>������....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"�뿪\" name=\"btnCancel\" /></font></td>          </tr>      </table>"; 
  exit;
}


?>
<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=230 border=0>
    <tr>
      <td valign="top" class="Left_Place"><TABLE class=t_list cellSpacing=1 cellPadding=0 width=210 border=0>
        <tr>
          <td height="28" colspan="3" align="center" bordercolor="#cccccc" bgcolor="#5A79C6" style="LINE-HEIGHT: 23px"><span class="STYLE3">��ע�ɹ�</span></td>
          </tr>
        <tr>
          <td height="22" align="center"class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">����</span></td>
          <td align="center" class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">����</span></td>
          <td align="center" class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">��ע���</span></td>
        </tr>
       <? $sum_sum=0;
 

 for ($r=0;$r<=$numm;$r++){
 if ($_POST['Num_'.$r]!=""){		
 $sum_sum=$sum_sum+$_POST['Num_'.$r];
 }
if ($sum_sum>ka_memuser("ts")){
echo "<script Language=Javascript>alert('�Բ�����ע�ܶ�ܴ��ڿ������ö�');parent.parent.mem_order.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
exit;
}
}
 
 
  for ($r=0;$r<=$numm;$r++){
 
 
		
		if ($_POST['Num_'.$r]!=""){		

$sum_sum=$sum_sum+$_POST['Num_'.$r];


if ($r==59 or $r==60){
if ($_POST['class2']=="��A"){$rate_id=$r+687;}else{
switch($_GET['class2']){

case "��1��"://1034
  $rate_id=$r+975;
  break;
case "��2��"://1045
  $rate_id=$r+1023;
  if($r==59){$rate_id=$r+986;}
  break;
case "��3��"://1044
  $rate_id=$r+1024;
  if($r==59){$rate_id=$r+985;}
  break;
case "��4��"://1043
  $rate_id=$r+1025;
  if($r==59){$rate_id=$r+984;}
  break;
case "��5��"://1042
  $rate_id=$r+1026;
  if($r==59){$rate_id=$r+983;}
  break;
case "��6��"://1041
  $rate_id=$r+1027;
  if($r==59){$rate_id=$r+982;}
  break;
default:
  $rate_id=$r+689;
}

}
}else{
if ($_GET['class2']=="�벨" && $r>=13){
$rate_id=$r+705;
}else{
$rate_id=$r+$mumu;
}
}
if($r==61){
  if($_GET['class2']=="��A"){$rate_id=795;}else{$rate_id=801;}
}
if($r==62){
  if($_GET['class2']=="��A"){$rate_id=796;}else{$rate_id=802;}
}
if($r==63){
  if($_GET['class2']=="��A"){$rate_id=797;}else{$rate_id=803;}
}
if($r==64){
  if($_GET['class2']=="��A"){$rate_id=798;}else{$rate_id=804;}
}
if($r==65){
  if($_GET['class2']=="��A"){$rate_id=799;}else{$rate_id=805;}
}
if($r==66){
  if($_GET['class2']=="��A"){$rate_id=800;}else{$rate_id=806;}
}
if ($_GET['class2']=="��1-6"){
//echo $r."<br>";
if ($r>=1&&$r<=7){
$rate_id=$r+$mumu;
}elseif ($r>=14&&$r<=20){
$rate_id=($r-6)+$mumu;
}elseif ($r>=27&&$r<=33){
$rate_id=($r-12)+$mumu;
}elseif ($r>=40&&$r<=46){
$rate_id=($r-18)+$mumu;
}elseif ($r>=53&&$r<=59){
$rate_id=($r-24)+$mumu;
}elseif ($r>=66&&$r<=72){
$rate_id=($r-30)+$mumu;
}elseif ($r>=8&&$r<=13){
$rate_id=$r+1039;
}elseif ($r>=21&&$r<=26){
$rate_id=($r-7)+1039;
}elseif ($r>=34&&$r<=39){
$rate_id=($r-14)+1039;
}elseif ($r>=47&&$r<=52){
$rate_id=($r-21)+1039;
}elseif ($r>=60&&$r<=65){
$rate_id=($r-28)+1039;
}elseif ($r>=73&&$r<=78){
$rate_id=($r-35)+1039;
}


/*
if ($r<=9){
$rate_id=$r+$mumu;
}elseif($r<=18){
$rate_id=$r+214;
}elseif($r<=27){
$rate_id=$r+263;
}elseif($r<=36){
$rate_id=$r+312;
}elseif($r<=45){
$rate_id=$r+361;
}elseif($r<=54){
$rate_id=$r+410;
}*/
}

 
 
 switch (ka_bl($rate_id,"class1")){
case "����":

switch (ka_bl($rate_id,"class3")){
	case "��":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=2;
$drop_sort="��˫";
break;
	
	case "˫":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=2;
$drop_sort="��˫";
break;
	
	case "����":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=24;
$drop_sort="����Ұ��";
break;

case "Ұ��":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=24;
$drop_sort="����Ұ��";
break;

case "β��":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=32;
$drop_sort="β��βС";
break;

case "βС":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=32;
$drop_sort="β��βС";
break;

case "��":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=33;
$drop_sort="��С��";
break;

case "С��":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=33;
$drop_sort="��С��";
break;

case "��˫":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=34;
$drop_sort="��˫С˫";
break;

case "С˫":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=34;
$drop_sort="��˫С˫";
break;


	case "��":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=3;
$drop_sort="��С";
break;
	
	case "С":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=3;
$drop_sort="��С";
break;

	case "�ϵ�":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=4;
$drop_sort="������˫ ";
break;
	
	case "��˫":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=4;
$drop_sort="������˫ ";
break;
	
	case "�첨":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=10;
$drop_sort="��ɫ";
	
	break;
	case "�̲�":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=10;
$drop_sort="��ɫ";
break;
	
	case "����":
	$bmmm=$btmdx;
$cmmm=$ctmdx;
$dmmm=$dtmdx;
$R=10;
$drop_sort="��ɫ";
	
break;
    default:
	$bmmm=$btm;
$cmmm=$ctm;
$dmmm=$dtm;
if (ka_bl($rate_id,"class2")=="��A"){
$R=0;}else{$R=1;}

$drop_sort="����";

break;
}
break;
case "����":
	switch (ka_bl($rate_id,"class3")){
	case "�ܵ�":
	$R=8;
$drop_sort="������˫";
$bmmm=$bzmdx;
$cmmm=$czmdx;
$dmmm=$dzmdx;
	break;
	
	case "��˫":
	$R=8;
$drop_sort="������˫";
$bmmm=$bzmdx;
$cmmm=$czmdx;
$dmmm=$dzmdx;
	break;
	
	case "�ܴ�":
	$R=9;
$drop_sort="������С";
	$bmmm=$bzmdx;
$cmmm=$czmdx;
$dmmm=$dzmdx;
	break;
	
	case "��С":
		$R=9;
$drop_sort="������С";
	$bmmm=$bzmdx;
$cmmm=$czmdx;
$dmmm=$dzmdx;
	
	break;
    default:
	
	if (ka_bl($rate_id,"class2")=="��A"){
$R=6;}else{$R=7;}

$drop_sort="����";

	$bmmm=$bzm;
$cmmm=$czm;
$dmmm=$dzm;
	break;
}
break;

case "����":
	$R=25;
$drop_sort="����";
$bmmm=$bzm6;
$cmmm=$czm6;
$dmmm=$dzm6;
	break;

case "��Ф":

switch (ka_bl($rate_id,"class2")){
	case "��Ф":
	$bmmm=$bsx;
$cmmm=$csx;
$dmmm=$dsx;
	$R=18;
$drop_sort="��Ф";
	
	break;
	case "��Ф":
	$bmmm=0;
$cmmm=0;
$dmmm=0;
	$R=19;
$drop_sort="��Ф";
break;
	
	case "��Ф":
	$bmmm=0;
$cmmm=0;
$dmmm=0;
	$R=20;
$drop_sort="��Ф";
break;
	
	case "��Ф":
	$bmmm=$bsx6;
$cmmm=$csx6;
$dmmm=$dsx6;
	$R=21;
$drop_sort="��Ф";
break;
	
	case "һФ":
	$bmmm=$bsxp;
$cmmm=$csxp;
$dmmm=$dsxp;
	$R=22;
$drop_sort="һФ";
break;

	case "����β��":
	$bmmm=$bsxp;
$cmmm=$csxp;
$dmmm=$dsxp;
	$R=29;
$drop_sort="����β��";
break;
	
	break;
    default:
		$R=18;
$drop_sort="��Ф";
		$bmmm=$bsxp;
$cmmm=$csxp;
$dmmm=$dsxp;
break;
}
	break;

case "�벨":
$bmmm=$bbb;
$cmmm=$cbb;
$dmmm=$dbb;
	$R=11;
$drop_sort="�벨";
break;
case "��벨":
$bmmm=$bbb;
$cmmm=$cbb;
$dmmm=$dbb;
	$R=11;
$drop_sort="��벨";
case "��Ф":
$bmmm=$bbb;
$cmmm=$cbb;
$dmmm=$dbb;
	$R=11;
$drop_sort="��Ф";
case "��ɫ��":
$bmmm=$bbb;
$cmmm=$cbb;
$dmmm=$dbb;
	$R=11;
$drop_sort="��ɫ��";
break;
case "����":
switch (ka_bl($rate_id,"class3")){
	case "��":
		$R=2;
$drop_sort="��˫";
	$bmmm=$bztdx;
$cmmm=$cztdx;
$dmmm=$dztdx;
break;
	
	case "˫":
		$R=2;
$drop_sort="��˫";
		$bmmm=$bztdx;
$cmmm=$cztdx;
$dmmm=$dztdx;
break;
	
	case "��":
		$R=3;
$drop_sort="��С";
		$bmmm=$bztdx;
$cmmm=$cztdx;
$dmmm=$dztdx;
break;
	
	case "С":
	$R=3;
$drop_sort="��С";
		$bmmm=$bztdx;
$cmmm=$cztdx;
$dmmm=$dztdx;
	
	break;
	case "�ϵ�":
	$R=4;
$drop_sort="������˫ ";
		$bmmm=$bztdx;
$cmmm=$cztdx;
$dmmm=$dztdx;
	
	break;
	case "��˫":
	$R=4;
$drop_sort="������˫ ";
		$bmmm=$bztdx;
$cmmm=$cztdx;
$dmmm=$dztdx;
break;
	
	case "�첨":
	$R=10;
$drop_sort="��ɫ";
		$bmmm=$bztdx;
$cmmm=$cztdx;
$dmmm=$dztdx;
break;
	
	case "�̲�":
		$R=10;
$drop_sort="��ɫ";
		$bmmm=$bztdx;
$cmmm=$cztdx;
$dmmm=$dztdx;
	
	break;
	case "����":
		$R=10;
$drop_sort="��ɫ";
		$bmmm=$bztdx;
$cmmm=$cztdx;
$dmmm=$dztdx;
	
break;
    default:
		$R=5;
$drop_sort="����";
$bmmm=$bzt;
$cmmm=$czt;
$dmmm=$dzt;
break;
	
}
break;


case "β��":
	$R=23;
$drop_sort="β��";
$bmmm=0;
$cmmm=0;
$dmmm=0;
break;

case "��1-6":
	$R=38;
$drop_sort="��1-6";
$bmmm=0;
$cmmm=0;
$dmmm=0;

break;

default:
	$R=23;
$drop_sort="β��";
$bmmm=0;
$cmmm=0;
$dmmm=0;
break;

}
	
	
	
//��������
if (ka_bl($rate_id,"class1")=="����" and $r<=49){
//��������
$result2=mysql_query("Select SUM(sum_m) As sum_m55 from ka_tan where Kithe='".$Current_Kithe_Num."' and  class1='".ka_bl($rate_id,"class1")."' and  class2='".ka_bl($rate_id,"class2")."' and class3='".ka_bl($rate_id,"class3")."' "); 
$rs5=mysql_fetch_array($result2);
if ($rs5['sum_m55']==""){$sum_m55=0;}else{$sum_m55=$rs5['sum_m55'];}
if (($sum_m55+$_POST['Num_'.$r])>ka_bl($rate_id,"xr") or ka_bl($rate_id,"locked")==1 ){
echo "<script Language=Javascript>alert('�Բ���[".ka_bl($rate_id,"class3")."��]��ͣ��ע.�뷴������ѡ��!');parent.parent.mem_order.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
exit;
}
}



//��������


$result2=mysql_query("Select SUM(sum_m) As sum_m from ka_tan where Kithe='".$Current_Kithe_Num."' and  class1='".ka_bl($rate_id,"class1")."' and  class2='".ka_bl($rate_id,"class2")."' and class3='".ka_bl($rate_id,"class3")."' and username='".$_SESSION['username']."' "); 
$rs5=mysql_fetch_array($result2);
if (($rs5['sum_m']+$_POST['Num_'.$r])>ka_memds($R,3) ){
echo "<script Language=Javascript>alert('�Բ���[".ka_bl($rate_id,"class3")."]���������޶�.�뷴��������ע!');parent.parent.mem_order.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
exit;
}	

if (ka_bl($rate_id,"locked")==1 ){
echo "<script Language=Javascript>alert('�Բ���[".ka_bl($rate_id,"class3")."��]��ͣ��ע.�뷴������ѡ��!');parent.parent.mem_order.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
exit;
}
						  
								  
	switch (ka_memuser("abcd")){							  

	case "A":
$rate5=ka_bl($rate_id,"rate");
$Y=1;
break;
	case "B":
$rate5=ka_bl($rate_id,"rate")-$bmmm;
$Y=4;
	break;
	case "C":
	$Y=5;
$rate5=ka_bl($rate_id,"rate")-$cmmm;
	break;
	case "D":
	$rate5=ka_bl($rate_id,"rate")-$dmmm;
$Y=6;
break;
	default:
	$Y=1;
$rate5=ka_bl($rate_id,"rate");
break;
}

$num=randStr();
$text=date("Y-m-d H:i:s");
$class11=ka_bl($rate_id,"class1");
$class22=ka_bl($rate_id,"class2");
$class33=ka_bl($rate_id,"class3");
$sum_m=$_POST['Num_'.$r];
$user_ds=ka_memds($R,1);
$dai_ds=ka_memdaids($R,$Y);
$zong_ds=ka_memzongds($R,$Y);
$guan_ds=ka_memguands($R,$Y);
$dai_zc=ka_memuser("dan_zc");
$zong_zc=ka_memuser("zong_zc");
$guan_zc=ka_memuser("guan_zc");
$dagu_zc=ka_memuser("dagu_zc");
$dai=ka_memuser("dan");
$zong=ka_memuser("zong");
$guan=ka_memuser("guan");

$danid=ka_memuser("danid");
$zongid=ka_memuser("zongid");
$guanid=ka_memuser("guanid");
$memid=ka_memuser("id");







$sql="INSERT INTO  ka_tan set num='".$num."',username='".$_SESSION['username']."',kithe='".$Current_Kithe_Num."',adddate='".$text."',class1='".$class11."',class2='".$class22."',class3='".$class33."',rate='".$rate5."',sum_m='".$sum_m."',user_ds='".$user_ds."',dai_ds='".$dai_ds."',zong_ds='".$zong_ds."',guan_ds='".$guan_ds."',dai_zc='".$dai_zc."',zong_zc='".$zong_zc."',guan_zc='".$guan_zc."',dagu_zc='".$dagu_zc."',bm=0,dai='".$dai."',zong='".$zong."',guan='".$guan."',danid='".$danid."',zongid='".$zongid."',guanid='".$guanid."',abcd='A',lx=0";
$exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");

//$sql="update ka_mem set ts=ts-".$sum_m." where kauser='".$_SESSION['username']."'";
$sql="update web_member_data set Money=Money-".$sum_m.",Credit=Credit-".$sum_m." where UserName='".$_SESSION['username']."'";
$exe=mysql_query($sql) or die ($sql);
	
 include 'ds.php';	

?>
		
		
        <tr>
          <td height="22" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><font color="#ff0000"><?=$class22?>��<font color=ff6600><?=$class33?></font></font></td>
          <td align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><?=$rate5?></td>
          <td align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><?=$sum_m?></td>
        </tr>
       
        <?
		}
		}
		?>
	      <tr>
          <td height="22" colspan="3" align="center" bordercolor="#cccccc" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="�뿪" name="btnCancel" />&nbsp;&nbsp;
		  <? if ($_GET['class2']=="��A" || $_GET['class2']=="��B") {?><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=n55&class2=<?=$_GET['class2']?>'" type="button" value="����" name="btnCancel" />
&nbsp;&nbsp;<? }?>
<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="javascript:window.print();" type="button" value="��ӡ"  name="btnSubmit" />&nbsp;&nbsp;<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="��ע�ɹ�" name="btnCancel" /></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="30" align="center">&nbsp;</td>
    </tr>
  </form>
</table>

<?
if ($urlurl!="") {
//echo "<script Language=Javascript>parent.parent.mem_order.location.href='".$urlurl."';</script>";
}?>
</BODY></HTML>
