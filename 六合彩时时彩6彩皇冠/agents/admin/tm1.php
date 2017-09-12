<? if(!defined('PHPYOU')) {
	exit('非法进入');
}
session_start();
if ($_GET['username']!=""){
$_SESSION['guan']=$_GET['username'];
}

 $vvvv=" and guan='".$_SESSION['guan']."' and username<>'".$_SESSION['guan']."' ";
 $vbbb=" count(*) as re,SUM(sum_m) As sum_money,SUM(sum_m*(guan_ds-zong_ds)/100) As sum_ds,SUM(0-sum_m*rate*guan_zc/10) As sum_m3,SUM(sum_m*guan_zc/10) As sum_m4,SUM(0-sum_m*rate) As sum_m5,SUM(0-sum_m*(guan_ds-zong_ds)/100*guan_zc/10) As sum_ds1 ";
//echo $vvvv;
?>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?


$resultbb=mysql_query("select * from ka_kithe  order by nn desc  LIMIT 1");
$rst = mysql_fetch_array($resultbb);

if ($rst['nn']==""){$Current_Kithe_Num=0;}else{$Current_Kithe_Num=$rst['nn'];}
if ($_GET['save']=="save"){
$exe=mysql_query("update ka_guan set jifei='".$_POST['jifei']."' Where kauser='".$_SESSION['guan']."'");
	$jifei=$_POST['jifei'];
}

$result=mysql_query("select * from ka_guan where kauser='".$_SESSION['guan']."'  order by id"); 
$row=mysql_fetch_array($result);

$jifei=$row['jifei'];	


if ($_GET['kithe']==""){
$kithe=$Current_Kithe_Num;
}else{
$kithe=$_GET['kithe'];
}


if ($_GET['tm']==""){
$tm=0;
}else{
$tm=$_GET['tm'];
}
if ($_GET['tm1']==""){
$tm1=0;
}else{
$tm1=$_GET['tm1'];
}
if ($_GET['tm2']==""){
$tm2=0;
}else{
$tm2=$_GET['tm2'];
}


if ($tm2=="0"){
$zf="预计盈利";
}else{
$zf="走飞";
}

$result=mysql_query("Select rate,class3,class1,class2 from ka_bl where class2='特A' Order By ID");
$d_ShowTable = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
array_push($d_ShowTable,$image);
}

for ($i=1;$i<=49;$i=$i+1){

$sum_tm1[$i]=$i;
$result1=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='特码' and  class3='".$i."'  ".$vvvv." "); 

$rs5=mysql_fetch_array($result1);
if ($rs5['sum_money']!=""){$sum_money=$rs5['sum_money'];}else{$sum_money=0;}
if ($rs5['re']!=""){$re=$rs5['re'];}else{$re=0;}
if ($rs5['sum_ds']!=""){$sum_ds=$rs5['sum_ds'];}else{$sum_ds=0;}
if ($rs5['sum_m3']!=""){$sum_m3=$rs5['sum_m3'];}else{$sum_m3=0;}
if ($rs5['sum_m4']!=""){$sum_m4=$rs5['sum_m4'];}else{$sum_m4=0;}
if ($rs5['sum_m5']!=""){$sum_m5=$rs5['sum_m5'];}else{$sum_m5=0;}
if ($rs5['sum_ds1']!=""){$sum_ds1=$rs5['sum_ds1'];}else{$sum_ds1=0;}



if ($tm==0){
$sum_money1[$i]=$sum_money;
$sum_zq[$i]=$sum_m5;
$sum_dsds[$i]=$sum_ds;

}else{
   $sum_money1[$i]=$sum_m4;
   $sum_zq[$i]=$sum_m3;
$sum_dsds[$i]=$sum_ds1;

}
$sum_zm[$i]=$sum_money1[$i]*$jifei/100  ;
$sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);

if ($tm1==1){

  
//单
  
$result2=mysql_query("Select count(*) as re,SUM(sum_m) As sum_money,SUM(0-sum_m*guan_ds/100) As sum_ds,SUM(0-sum_m*rate*dagu_zc/10) As sum_m3,SUM(sum_m*dagu_zc/10) As sum_m4,SUM(0-sum_m*rate) As sum_m5,SUM(0-sum_m*guan_ds/100*dagu_zc/10) As sum_ds1  from ka_tan where Kithe='".$kithe."' and  class1='特码' and  class3='单' ".$vvvv." ");

$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
  if ($i%2==1){

if ($tm==0){

  $sum_money1[$i]=$sum_money1[$i]+$sum_money/25;
  
  }else{
   $sum_money1[$i]=$sum_money1[$i]+$sum_m4/25;
   
}
  
  if ($tm==0){
   $sum_zq[$i]=$sum_zq[$i]+$sum_m5;
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds/25;
   }else{
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds1/25;
   $sum_zq[$i]=$sum_zq[$i]+$sum_m3;
  }
   
  $sum_zm[$i]=$sum_money1[$i]*$jifei/100;
  $sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);
}
  
}

//双

$result2=mysql_query("Select count(*) as re,SUM(sum_m) As sum_money,SUM(0-sum_m*guan_ds/100) As sum_ds,SUM(0-sum_m*rate*dagu_zc/10) As sum_m3,SUM(sum_m*dagu_zc/10) As sum_m4,SUM(0-sum_m*rate) As sum_m5,SUM(0-sum_m*guan_ds/100*dagu_zc/10) As sum_ds1  from ka_tan where Kithe='".$kithe."' and  class1='特码' and  class3='双' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
  if ($i%2==0){

if ($tm==0){
  $sum_money1[$i]=$sum_money1[$i]+$sum_money/24;
  }else{
   $sum_money1[$i]=$sum_money1[$i]+$sum_m4/24;
}
  
  if ($tm==0){
   $sum_zq[$i]=$sum_zq[$i]+$sum_m5;
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds/24;
   }else{
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds1/24;
   $sum_zq[$i]=$sum_zq[$i]+$sum_m3;
  }
   
  $sum_zm[$i]=$sum_money1[$i]*$jifei/100;
  $sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);
}
  
}

  //大

$result2=mysql_query("Select count(*) as re,SUM(sum_m) As sum_money,SUM(0-sum_m*guan_ds/100) As sum_ds,SUM(0-sum_m*rate*dagu_zc/10) As sum_m3,SUM(sum_m*dagu_zc/10) As sum_m4,SUM(0-sum_m*rate) As sum_m5,SUM(0-sum_m*guan_ds/100*dagu_zc/10) As sum_ds1  from ka_tan where Kithe='".$kithe."' and  class1='特码' and  class3='大' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
  if ($i>=25){

if ($tm==0){
  $sum_money1[$i]=$sum_money1[$i]+$sum_money/25;
  }else{
   $sum_money1[$i]=$sum_money1[$i]+$sum_m4/25;
}
  
  if ($tm==0){
   $sum_zq[$i]=$sum_zq[$i]+$sum_m5;
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds/25;
   }else{
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds1/25;
   $sum_zq[$i]=$sum_zq[$i]+$sum_m3;
  }
   
  $sum_zm[$i]=$sum_money1[$i]*$jifei/100;
  $sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);
}
  
}

 //小

$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='特码' and  class3='小' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
  if ($i<=24){

if ($tm==0){
  $sum_money1[$i]=$sum_money1[$i]+$sum_money/24;
  }else{
   $sum_money1[$i]=$sum_money1[$i]+$sum_m4/24;
}
  
  if ($tm==0){
   $sum_zq[$i]=$sum_zq[$i]+$sum_m5;
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds/24;
   }else{
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds1/24;
   $sum_zq[$i]=$sum_zq[$i]+$sum_m3;
  }
   
  $sum_zm[$i]=$sum_money1[$i]*$jifei/100;
  $sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);
}
  
}

  //合单

$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='特码' and  class3='合单' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
  if ((($i%10)+intval($i/10))%2==1){

if ($tm==0){
  $sum_money1[$i]=$sum_money1[$i]+$sum_money/25;
  }else{
   $sum_money1[$i]=$sum_money1[$i]+$sum_m4/25;
}
  
  if ($tm==0){
   $sum_zq[$i]=$sum_zq[$i]+$sum_m5;
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds/25;
   }else{
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds1/25;
   $sum_zq[$i]=$sum_zq[$i]+$sum_m3;
  }
   
  $sum_zm[$i]=$sum_money1[$i]*$jifei/100;
  $sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);
}
  
}
 //合双

$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='特码' and  class3='合双' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
  if ((($i%10)+intval($i/10))%2==0){

if ($tm==0){
  $sum_money1[$i]=$sum_money1[$i]+$sum_money/24;
  }else{
   $sum_money1[$i]=$sum_money1[$i]+$sum_m4/24;
}
  
  if ($tm==0){
   $sum_zq[$i]=$sum_zq[$i]+$sum_m5;
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds/24;
   }else{
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds1/24;
   $sum_zq[$i]=$sum_zq[$i]+$sum_m3;
  }
   
  $sum_zm[$i]=$sum_money1[$i]*$jifei/100;
  $sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);
}
  
}



 //红波

$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='特码' and  class3='红波' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
  if (ka_Color_s($i)=="红波"){

if ($tm==0){
  $sum_money1[$i]=$sum_money1[$i]+$sum_money/17;
  }else{
   $sum_money1[$i]=$sum_money1[$i]+$sum_m4/17;
}
  
  if ($tm==0){
   $sum_zq[$i]=$sum_zq[$i]+$sum_m5;
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds/17;
   }else{
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds1/17;
   $sum_zq[$i]=$sum_zq[$i]+$sum_m3;
  }
   
  $sum_zm[$i]=$sum_money1[$i]*$jifei/100;
  $sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);
}
  
}
  

 //蓝波

$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='特码' and  class3='蓝波' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
  if (ka_Color_s($i)=="蓝波"){

if ($tm==0){
  $sum_money1[$i]=$sum_money1[$i]+$sum_money/16;
  }else{
   $sum_money1[$i]=$sum_money1[$i]+$sum_m4/16;
}
  
  if ($tm==0){
   $sum_zq[$i]=$sum_zq[$i]+$sum_m5;
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds/16;
   }else{
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds1/16;
   $sum_zq[$i]=$sum_zq[$i]+$sum_m3;
  }
   
  $sum_zm[$i]=$sum_money1[$i]*$jifei/100;
  $sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);
}
  
}


 //绿波

$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='特码' and  class3='绿波' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
  if (ka_Color_s($i)=="绿波"){

if ($tm==0){
  $sum_money1[$i]=$sum_money1[$i]+$sum_money/16;
  }else{
   $sum_money1[$i]=$sum_money1[$i]+$sum_m4/16;
}
  
  if ($tm==0){
   $sum_zq[$i]=$sum_zq[$i]+$sum_m5;
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds/16;
   }else{
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds1/16;
   $sum_zq[$i]=$sum_zq[$i]+$sum_m3;
  }
   
  $sum_zm[$i]=$sum_money1[$i]*$jifei/100;
  $sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);
}
  
}


}
  
}

if ($tm1==1){

//家禽
$sx1sx="狗,猪,鸡,羊,马,牛";

 $nsx2=explode(",",$sx1sx);
	 $mxmxmx="1";
	 $bbsb=count($nsx2);
for ($i=0;$i<$bbsb;$i=$i+1) {
  $result7 = mysql_query("Select id,m_number  from ka_sxnumber   where  sx='".$nsx2[$i]."'");
$Rs7 = mysql_fetch_array($result7);
	$mxmxmx=$mxmxmx.",".$Rs7['m_number'];
}

$nsx1=explode(",",$mxmxmx);
$xxm=count($nsx1)+1;
$vmvmn22=intval($nsx1[0]);

$result2=mysql_query("Select ".$vbbb."   from ka_tan where Kithe='".$kithe."' and  class1='特码' and    class3='家禽' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
 for ($i=1;$i<$xxm;$i=$i+1){
 $bibi=intval($nsx1[$i]);

if ($tm==0){
  $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_money/($xxm-2);
  }else{
   $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_m4/($xxm-2);
}
  
  if ($tm==0){
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m5;
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds/($xxm-2);
   }else{
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds1/($xxm-2);
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m3;
  }
   
  $sum_zm[$bibi]=$sum_money1[$bibi]*$jifei/100;
  $sum_zf[$bibi]=$sum_money1[$bibi]*(1-$jifei/100);
}
  
}

//野兽
$sx1sx="鼠,虎,猴,龙,蛇,兔";

 $nsx2=explode(",",$sx1sx);
	 $mxmxmx="1";
	 $bbsb=count($nsx2);
for ($i=0;$i<$bbsb;$i=$i+1) {
  $result7 = mysql_query("Select id,m_number  from ka_sxnumber   where  sx='".$nsx2[$i]."'");
$Rs7 = mysql_fetch_array($result7);
	$mxmxmx=$mxmxmx.",".$Rs7['m_number'];
}


$nsx1=explode(",",$mxmxmx);
$xxm=count($nsx1)+1	;
$vmvmn22=intval($nsx1[0]);

$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='特码' and    class3='野兽' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
 for ($i=1;$i<$xxm;$i=$i+1){
 $bibi=intval($nsx1[$i]);

if ($tm==0){
  $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_money/($xxm-2);
  }else{
   $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_m4/($xxm-2);
}
  
  if ($tm==0){
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m5;
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds/($xxm-2);
   }else{
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds1/($xxm-2);
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m3;
  }
   
  $sum_zm[$bibi]=$sum_money1[$bibi]*$jifei/100;
  $sum_zf[$bibi]=$sum_money1[$bibi]*(1-$jifei/100);
}
  
}

//特肖
$resultw1 = mysql_query("select distinct(class3),class1,class2   from   ka_tan where Kithe='".$kithe."' and  class1='生肖'  and class2='特肖'  order by class3 desc");   
$ii=0;
while($rsw = mysql_fetch_array($resultw1)){

$result7 = mysql_query("select *  from ka_sxnumber where sx='".$rsw['class3']."'");
$Rs7 = mysql_fetch_array($result7);
$nsx1=explode(",",$Rs7['m_number']);
$xxm=count($nsx1)+2	;
$vmvmn22=intval($nsx1[0]);
$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='生肖' and  class2='特肖'  and  class3='".$rsw['class3']."' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
 for ($i=$vmvmn22;$i<=49;$i=$i+12){


if ($tm==0){
  $sum_money1[$i]=$sum_money1[$i]+$sum_money/($xxm-2);
  }else{
   $sum_money1[$i]=$sum_money1[$i]+$sum_m4/($xxm-2);
}
  
  if ($tm==0){
   $sum_zq[$i]=$sum_zq[$i]+$sum_m5;
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds/($xxm-2);
   }else{
    $sum_dsds[$i]=$sum_dsds[$i]+$sum_ds1/($xxm-2);
   $sum_zq[$i]=$sum_zq[$i]+$sum_m3;
  }
   
  $sum_zm[$i]=$sum_money1[$i]*$jifei/100;
  $sum_zf[$i]=$sum_money1[$i]*(1-$jifei/100);
}
  
}
}




//半波
$resultw = mysql_query("select distinct(class3),class1,class2   from   ka_tan where Kithe='".$kithe."' and  class1='半波'  and class2='半波'  order by class3 desc");   
$ii=0;
while($rsw = mysql_fetch_array($resultw)){



$result7 = mysql_query("Select id,m_number  from ka_sxnumber   where  sx='".$rsw['class3']."'");
$Rs7 = mysql_fetch_array($result7);
$nsx1=explode(",",$Rs7['m_number']);
$xxm=count($nsx1)+2	;
$vmvmn22=intval($nsx1[0]);
$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='半波' and  class2='半波'  and  class3='".$rsw['class3']."' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
 for ($i=0;$i<$xxm;$i=$i+1){
 $bibi=intval($nsx1[$i]);


if ($tm==0){
  $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_money/($xxm-2);
  }else{
   $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_m4/($xxm-2);
}
  
  if ($tm==0){
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m5;
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds/($xxm-2);
   }else{
    $sum_dsds[$bibi]=$sum_dsds[$i]+$sum_ds1/($xxm-2);
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m3;
  }
   
  $sum_zm[$bibi]=$sum_money1[$bibi]*$jifei/100;
  $sum_zf[$bibi]=$sum_money1[$bibi]*(1-$jifei/100);
}
  
}
}


//六肖
$resultw = mysql_query("select distinct(class3),class1,class2   from   ka_tan where Kithe='".$kithe."' and  class1='生肖'  and class2='六肖'  order by class3 desc");   
$ii=0;
while($rsw = mysql_fetch_array($resultw)){

 $nsx2=explode(",",$rsw['class3']);
	 $mxmxmx="1";
	 $bbsb=count($nsx2);
for ($i=0;$i<$bbsb;$i=$i+1) {
  $result7 = mysql_query("Select id,m_number  from ka_sxnumber   where  sx='".$nsx2[$i]."'");
$Rs7 = mysql_fetch_array($result7);
	$mxmxmx=$mxmxmx.",".$Rs7['m_number'];
}


$nsx1=explode(",",$mxmxmx);
$xxm=count($nsx1)	;
$vmvmn22=intval($nsx1[0]);
$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='生肖' and  class2='六肖'  and  class3='".$rsw['class3']."'  ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
 for ($i=1;$i<$xxm;$i=$i+1){
 $bibi=intval($nsx1[$i]);

if ($tm==0){
  $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_money/($xxm-2);
  }else{
   $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_m4/($xxm-2);
}
  
  if ($tm==0){
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m5;
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds/($xxm-2);
   }else{
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds1/($xxm-2);
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m3;
  }
   
  $sum_zm[$bibi]=$sum_money1[$bibi]*$jifei/100;
  $sum_zf[$bibi]=$sum_money1[$bibi]*(1-$jifei/100);
}
  
}
}



//四肖
$resultw = mysql_query("select distinct(class3),class1,class2   from   ka_tan where Kithe='".$kithe."' and  class1='生肖'  and class2='四肖'  order by class3 desc");   
$ii=0;
while($rsw = mysql_fetch_array($resultw)){

 $nsx2=explode(",",$rsw['class3']);
	 $mxmxmx="1";
	 $bbsb=count($nsx2);
for ($i=0;$i<$bbsb;$i=$i+1) {
  $result7 = mysql_query("Select id,m_number  from ka_sxnumber   where  sx='".$nsx2[$i]."'");
$Rs7 = mysql_fetch_array($result7);
	$mxmxmx=$mxmxmx.",".$Rs7['m_number'];
}


$nsx1=explode(",",$mxmxmx);
$xxm=count($nsx1)	;
$vmvmn22=intval($nsx1[0]);
$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='生肖' and  class2='四肖'  and  class3='".$rsw['class3']."' ".$vvvv." ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
 for ($i=1;$i<$xxm;$i=$i+1){
 
 $bibi=intval($nsx1[$i]);


if ($tm==0){
  $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_money/($xxm-2);
  }else{
   $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_m4/($xxm-2);
}
  
  if ($tm==0){
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m5;
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds/($xxm-2);
   }else{
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds1/($xxm-2);
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m3;
  }
   
  $sum_zm[$bibi]=$sum_money1[$bibi]*$jifei/100;
  $sum_zf[$bibi]=$sum_money1[$bibi]*(1-$jifei/100);
}
  
}
}



//五肖
$resultw = mysql_query("select distinct(class3),class1,class2   from   ka_tan where Kithe='".$kithe."' and  class1='生肖'  and class2='五肖'  order by class3 desc");   
$ii=0;
while($rsw = mysql_fetch_array($resultw)){

 $nsx2=explode(",",$rsw['class3']);
	 $mxmxmx="1";
	 $bbsb=count($nsx2);
for ($i=0;$i<$bbsb;$i=$i+1) {
  $result7 = mysql_query("Select id,m_number  from ka_sxnumber   where  sx='".$nsx2[$i]."'");
$Rs7 = mysql_fetch_array($result7);
	$mxmxmx=$mxmxmx.",".$Rs7['m_number'];
}


$nsx1=explode(",",$mxmxmx);
$xxm=count($nsx1)	;
$vmvmn22=intval($nsx1[0]);
$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='生肖' and  class2='五肖'  and  class3='".$rsw['class3']."' ");
$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
 for ($i=1;$i<$xxm;$i=$i+1){
 $bibi=intval($nsx1[$i]);

if ($tm==0){
  $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_money/($xxm-2);
  }else{
   $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_m4/($xxm-2);
}
  
  if ($tm==0){
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m5;
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds/($xxm-2);
   }else{
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds1/($xxm-2);
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m3;
  }
   
  $sum_zm[$bibi]=$sum_money1[$bibi]*$jifei/100;
  $sum_zf[$bibi]=$sum_money1[$bibi]*(1-$jifei/100);
}
  
}
}

//五行
$resultw = mysql_query("select distinct(class3),class1,class2   from   ka_tan where Kithe='".$kithe."' and  class1='五行'  and class2='五行'  order by class3 desc");   
$ii=0;
while($rsw = mysql_fetch_array($resultw)){



$result7 = mysql_query("Select id,m_number  from ka_sxnumber   where  sx='".$rsw['class3']."'");
$Rs7 = mysql_fetch_array($result7);
$nsx1=explode(",",$Rs7['m_number']);
$xxm=count($nsx1)+2	;
$vmvmn22=intval($nsx1[0]);




$result2=mysql_query("Select ".$vbbb."  from ka_tan where Kithe='".$kithe."' and  class1='五行' and  class2='五行'  and  class3='".$rsw['class3']."' ".$vvvv." ");


$rs3=mysql_fetch_array($result2);
if ($rs3['sum_money']!=""){$sum_money=$rs3['sum_money'];}else{$sum_money=0;}
if ($rs3['re']!=""){$re=$rs3['re'];}else{$re=0;}
if ($rs3['sum_ds']!=""){$sum_ds=$rs3['sum_ds'];}else{$sum_ds=0;}
if ($rs3['sum_m3']!=""){$sum_m3=$rs3['sum_m3'];}else{$sum_m3=0;}
if ($rs3['sum_m4']!=""){$sum_m4=$rs3['sum_m4'];}else{$sum_m4=0;}
if ($rs3['sum_m5']!=""){$sum_m5=$rs3['sum_m5'];}else{$sum_m5=0;}
if ($rs3['sum_ds1']!=""){$sum_ds1=$rs3['sum_ds1'];}else{$sum_ds1=0;}


 if ($re>0){
 for ($i=0;$i<$xxm;$i=$i+1){
 $bibi=intval($nsx1[$i]);


if ($tm==0){
  $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_money/($xxm-2);
  }else{
   $sum_money1[$bibi]=$sum_money1[$bibi]+$sum_m4/($xxm-2);
}
  
  if ($tm==0){
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m5;
    $sum_dsds[$bibi]=$sum_dsds[$bibi]+$sum_ds/($xxm-2);
   }else{
    $sum_dsds[$bibi]=$sum_dsds[$i]+$sum_ds1/($xxm-2);
   $sum_zq[$bibi]=$sum_zq[$bibi]+$sum_m3;
  }
   
  $sum_zm[$bibi]=$sum_money1[$bibi]*$jifei/100;
  $sum_zf[$bibi]=$sum_money1[$bibi]*(1-$jifei/100);
}
  
}
}

}




$sum_sum=0;
$sum_sumds=0;

$sum_zmzm=0;

$sum_re=0;
$sum_zfzf=0;
$zm_num="";
if ($_GET['zm_num']!=""){$zm_num=$_GET['zm_num'];}else{

if ($_POST['zm_num']!=""){$zm_num=$_POST['zm_num'];}

}


if ($zm_num!=""){
for ($i=1;$i<=49;$i=$i+1){
if ($sum_zm[$i]>$zm_num){
$sum_zm[$i]=$zm_num;
$sum_zf[$i]=$sum_money1[$i]-$sum_zm[$i];
}
}
}




for ($i=1;$i<=49;$i=$i+1){

$sum_sum=$sum_sum+$sum_money1[$i];
$sum_sumds=$sum_sumds+$sum_dsds[$i];
$sum_zmzm=$sum_zmzm+$sum_zm[$i];
}

for ($i=1;$i<=49;$i=$i+1){


$sum_zf1[$i]=$sum_sum+$sum_sumds+$sum_zq[$i];
if ($sum_zf1[$i]<0){
$sum_re=$sum_re+1;
}
if ($tm2==0){
$sum_zf[$i]=$sum_sum+$sum_sumds+$sum_zq[$i];
}
}
if ($_GET['zm_num']!=""){$zm_num=$_GET['zm_num'];}else{
if ($_POST['zm_num']!=""){$zm_num=$_POST['zm_num'];}
}

if ($_GET['rake']!=""){$rake=$_GET['rake'];}else{
if ($_POST['rake']!=""){$rake=$_POST['rake'];}
}
if ($_GET['zm_num']!=""){$zm_num=$_GET['zm_num'];}else{
if ($_POST['zm_num']!=""){$zm_num=$_POST['zm_num'];}
}
if ($_GET['ds']!=""){$ds=$_GET['ds'];}else{
if ($_POST['ds']!=""){$ds=$_POST['ds'];}
}


if ($zf_num!="" and $rake!=""  and  $zm_num==""){
$zf_num=$zf_num;
$sum_zmzm=0;
if ($ds!=""){
$ds=$ds/100;
}else{
$ds=0;
}
$rake=$rake;
if ($rake>49){
$rake=49;
}




for ($i=1;$i<=49;$i=$i+1){


if (((0-$sum_zf1[$i]-$zf_num)/$rake)>1){


$sum_zm[$i]=$sum_zm[$i]-intval(((0-$sum_zf1[$i])-intval($zf_num))/$rake);

if ($tm2==0){
}else{
$sum_zf[$i]=$sum_money1[$i]-$sum_zm[$i];
}
}
$sum_zmzm=$sum_zmzm+$sum_zm[$i];
}
$zm_num=intval(($sum_zmzm+$zf_num)/$rake);
}





if ($_GET['zm_num']!=""){$zm_num=$_GET['zm_num'];}else{
if ($_POST['zm_num']!=""){$zm_num=$_POST['zm_num'];}
}

if ($_GET['rake']!=""){$rake=$_GET['rake'];}else{
if ($_POST['rake']!=""){$rake=$_POST['rake'];}
}
if ($_GET['zm_num']!=""){$zm_num=$_GET['zm_num'];}else{
if ($_POST['zm_num']!=""){$zm_num=$_POST['zm_num'];}
}
if ($_GET['ds']!=""){$ds=$_GET['ds'];}else{
if ($_POST['ds']!=""){$ds=$_POST['ds'];}
}

if ($_GET['tm']!=""){$tm=$_GET['tm'];}else{
if ($_POST['tm']!=""){$tm=$_POST['tm'];}
}

if ($_GET['tm1']!=""){$tm1=$_GET['tm1'];}else{
if ($_POST['tm1']!=""){$tm1=$_POST['tm1'];}
}

if ($_GET['tm2']!=""){$tm2=$_GET['tm2'];}else{
if ($_POST['tm2']!=""){$tm2=$_POST['tm2'];}
}

?>
<link rel="stylesheet" href="images/xp.css" type="text/css">
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>
<script language="JavaScript">

</script>

<style type="text/css">
<!--
.STYLE2 {color: #FFFFFF}
.STYLE3 {color: #333333}
-->
</style>
<body >
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>

<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">


<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="6%"><font color="#FFFFFF">[<?=$_SESSION['guan']?>]走飞</font></td>
    <td width="94%"><table border="0" align="center" cellspacing="0" cellpadding="1" bordercolor="888888" bordercolordark="#FFFFFF" width="98%">
      <tr>
        <td width="42%" nowrap><span class="STYLE2"> 期数
            <SELECT name=kithe class=zaselect_ste id="kithe" onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}">
			
			
			<?
		$result = mysql_query("select * from ka_kithe order by nn desc");   
while($image = mysql_fetch_array($result)){
			     echo "<OPTION value=index.php?action=tm1&tm=".$tm."&tm2=".$tm2."&tm1=".tm1."&zm_num=".$zm_num."&kithe=".$image['nn'];
				 if ($kithe!="") {
				 if ($kithe==$image['nn']) {
				  echo " selected=selected ";
				  }				
				}
				 echo ">第".$image['nn']."期</OPTION>";
			  }
		?>
			
			
              
            </SELECT>
          占成:
          <SELECT onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}" name="menu2">
            <OPTION value="index.php?action=tm1&zm_num=<?=$zm_num?>&kithe=<?=$kithe?>&tm2=<?=$tm2?>&tm1=<?=$tm1?>&tm=0"  <? if ($tm==0){?>selected<? }?>>全部</OPTION>
            <OPTION value="index.php?action=tm1&zm_num=<?=$zm_num?>&kithe=<?=$kithe?>&tm2=<?=$tm2?>&tm1=<?=$tm1?>&tm=1" <? if ($tm==1){?>selected<? }?>>成数</OPTION>
          </SELECT>
          出货/成数:
          <SELECT onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}" name="menu1">
            <OPTION value="index.php?action=tm1&zm_num=<?=$zm_num?>&kithe=<?=$kithe?>&tm2=<?=$tm2?>&tm=<?=$tm?>&tm1=0" <? if ($tm1==0){?>selected<? }?>>特码</OPTION>
            <OPTION value="index.php?action=tm1&zm_num=<?=$zm_num?>&kithe=<?=$kithe?>&tm2=<?=$tm2?>&tm=<?=$tm?>&tm1=1" <? if ($tm1==1){?>selected<? }?>>全部</OPTION>
          </SELECT>
          查看方式:
          <SELECT onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}" name="select">
            <OPTION value="index.php?action=tm1&zm_num=<?=$zm_num?>&kithe=<?=$kithe?>&tm=<?=$tm?>&tm1=<?=$tm1?>&tm2=1" <<? if ($tm2==1){?>selected<? }?>>吃码</OPTION>
            <OPTION value="index.php?action=tm1&zm_num=<?=$zm_num?>&kithe=<?=$kithe?>&tm=<?=$tm?>&tm1=<?=$tm1?>&tm2=0" <? if ($tm2==0){?>selected<? }?>>预计盈利</OPTION>
          </SELECT> 股东:
          <SELECT onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}" name="menu2">
           
		   
		    <OPTION value="index.php?action=tm&zm_num=<?=$zm_num?>&kithe=<?=$kithe?>&tm2=<?=$tm2?>&tm1=<?=$tm1?>&tm=0"  >全部</OPTION>
				<?
		$result = mysql_query("select * from ka_guan where lx=1 order by id desc");   
while($image = mysql_fetch_array($result)){
?>
            <OPTION value="index.php?action=tm1&username=<?=$image['kauser']?>&kithe=<?=$kithe?>" <? if ($_SESSION['guan']==$image['kauser']){?>selected<? }?>><?=$image['kauser']?></OPTION>
			<? }?>
          </SELECT>
        </span></td>
        <form name="form2" method="post" action="index.php?action=tm1&save=save&tm=<?=$tm?>&kithe=<?=$kithe?>&tm1=<?=$tm1?>&tm2=<?=$tm2?>&zm_num=<?=$zm_num?>">
          <td width="37%" nowrap><span class="STYLE2"> 吃码占成
              <input id="jifei" maxlength="3" size="4" value="<?=$jifei?>" name="jifei">
            %
            <INPUT type="submit" value="设置" name="Submit">
          
 
         
          </span></td>
        </form>
        <td width="21%"><div align="right">
            <button onClick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle">刷新</button>
          <button onClick="javascript:window.print();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/asp.gif" width="16" height="16" align="absmiddle" />打印</button>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr >
    <td height="5"></td>
    <td></td>
  </tr>
</table>
<form name="setform" method="post" action="index.php?action=tm1&kithe=<?=$kithe?>&tm=<?=$tm?>&tm1=<?=$tm1?>&tm2=<?=$tm2?>">
  <table   border="1" align="center" cellspacing="1" cellpadding="2" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="98%">
    <tr>
      <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 金额 </td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">吃码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><?=$zf?> </td>
      <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">金额</td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">吃码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><?=$zf?> </td>
      <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 金额 </td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">吃码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><?=$zf?> </td>
      <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 金额 </td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">吃码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><?=$zf?> </td>
      <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 金额 </td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">吃码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><?=$zf?> </td>
    </tr>
    <?
	
	
	for ($I=1; $I<=49; $I=$I+1){
  $result6 = mysql_query("Select * from m_color   where   id=".$I." order by id Desc");
$rskf = mysql_fetch_array($result6);
if ($rskf['color']=="r") {
$sum_color[$I]="ff0000";
}elseif ($rskf['color']=="b"){$sum_color[$I]="0000FF";}elseif ($rskf['color']=="g"){$sum_color[$I]="00FF00";}


}

 $sumzfzf=0;
for($b=1;$b<=49;$b++){
$sumzfzf+=$sum_zf[$i];
}

	
	for($b=1;$b<=49;$b++)
{
$i=1;
for($i=1;$i<=48;$i++)
{
if ($sumzfzf!=0){
$bbs=$sum_zf[$i];
$bbs1=$sum_zf[$i+1];
}else{
$bbs=$sum_money1[$i+1];
$bbs1=$sum_money1[$i];
}
if($bbs>$bbs1){

         $tmp=$sum_tm1[$i+1];
	$sum_tm1[$i+1]=$sum_tm1[$i];
		 $sum_tm1[$i]=$tmp;
		 
		  $tmp=$sum_color[$i+1];
	$sum_color[$i+1]=$sum_color[$i];
		 $sum_color[$i]=$tmp;
		 
		 
		   $tmp=$sum_zf[$i+1];
	$sum_zf[$i+1]=$sum_zf[$i];
		 $sum_zf[$i]=$tmp;
		 
		  $tmp=$sum_money1[$i+1];
	$sum_money1[$i+1]=$sum_money1[$i];
		 $sum_money1[$i]=$tmp;
		 
		 $tmp=$sum_zm[$i+1];
	$sum_zm[$i+1]=$sum_zm[$i];
		 $sum_zm[$i]=$tmp;
		

}


}


}
	 for($i=1;$i<=10;$i=$i+1){?>
    <tr>
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sum_color[$i]?>"><?=$sum_tm1[$i]?></font></td>
      <td height="25" align="center" nowrap bordercolor="cccccc"><?=round($sum_money1[$i],2)?></td>
      <td height="25" align="center" nowrap bordercolor="cccccc">
	  <?=round($sum_zm[$i],2)?></td>
      <td align="center" nowrap bordercolor="cccccc">
	  
	  <? if ($tm2==0){?>
          <font <? if ($sum_zf[$i]<0) {?>color=ff0000<? }else{ ?>color=#494949<? }?> ><?=round($sum_zf[$i],2)?></font>
          <? }else{?>
          <font <? if ($sum_zf[$i]>0) {?>color=ff0000<? }else{?>color=#494949<? }?> ><?=round($sum_zf[$i],2)?></font>
          <? }?>      </td>
	  
	<td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sum_color[$i+10]?>"><?=$sum_tm1[$i+10]?></font></td>
      <td height="25" align="center" nowrap bordercolor="cccccc"><?=round($sum_money1[$i+10],2)?></td>
      <td height="25" align="center" nowrap bordercolor="cccccc">
	  <?=round($sum_zm[$i+10],2)?></td>
      <td align="center" nowrap bordercolor="cccccc">
	  
	  <? if ($tm2==0){?>
          <font <? if ($sum_zf[$i+10]<0) {?>color=ff0000<? }else{ ?>color=#494949<? }?> ><?=round($sum_zf[$i+10],2)?></font>
          <? }else{?>
          <font <? if ($sum_zf[$i+10]>0) {?>color=ff0000<? }else{?>color=#494949<? }?> ><?=round($sum_zf[$i+10],2)?></font>
          <? }?>      </td>
	  
	 
	<td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sum_color[$i+20]?>"><?=$sum_tm1[$i+20]?></font></td>
      <td height="25" align="center" nowrap bordercolor="cccccc"><?=round($sum_money1[$i+20],2)?></td>
      <td height="25" align="center" nowrap bordercolor="cccccc">
	  <?=round($sum_zm[$i+20],2)?></td>
      <td align="center" nowrap bordercolor="cccccc">
	  
	  <? if ($tm2==0){?>
          <font <? if ($sum_zf[$i+20]<0) {?>color=ff0000<? }else{ ?>color=#494949<? }?> ><?=round($sum_zf[$i+20],2)?></font>
          <? }else{?>
          <font <? if ($sum_zf[$i+20]>0) { ?>color=ff0000<? }else{?>color=#494949<? }?> ><?=round($sum_zf[$i+20],2)?></font>
          <? }?>      </td>
	  
	  
	<td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sum_color[$i+30]?>"><?=$sum_tm1[$i+30]?></font></td>
      <td height="25" align="center" nowrap bordercolor="cccccc"><?=round($sum_money1[$i+30],2)?></td>
      <td height="25" align="center" nowrap bordercolor="cccccc">
	  <?=round($sum_zm[$i+30],2)?></td>
      <td align="center" nowrap bordercolor="cccccc">
	  
	  <? if ($tm2==0){?>
          <font <? if ($sum_zf[$i+30]<0) {?>color=ff0000<? }else{ ?>color=#494949<? }?> ><?=round($sum_zf[$i+30],2)?></font>
          <? }else{?>
          <font <? if ($sum_zf[$i+30]>0) { ?>color=ff0000<? }else{?>color=#494949<? }?> ><?=round($sum_zf[$i+30],2)?></font>
          <? }?>      </td>
	  
	  
	  
	  	 <? if ($i!=10) {?> 
	 <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sum_color[$i+40]?>"><?=$sum_tm1[$i+40]?></font></td>
      <td height="25" align="center" nowrap bordercolor="cccccc"><?=round($sum_money1[$i+40],2)?></td>
      <td height="25" align="center" nowrap bordercolor="cccccc">
	  <?=round($sum_zm[$i+40],2)?></td>
      <td align="center" nowrap bordercolor="cccccc">
	  
	  <? if ($tm2==0){?>
          <font <? if ($sum_zf[$i+40]<0) {?>color=ff0000<? }else{ ?>color=#494949<? }?> ><?=round($sum_zf[$i+40],2)?></font>
          <? }else{?>
          <font <? if ($sum_zf[$i+40]>0) {?>color=ff0000<? }else{?>color=#494949<? }?> ><?=round($sum_zf[$i+40],2)?></font>
          <? }?>      </td>
	  <? }else{?>
	   <td height="25" align="center" bordercolor="cccccc">&nbsp;</td>
      <td height="25" align="center" bordercolor="cccccc">&nbsp;</td>
      <td height="25" align="center" bordercolor="cccccc">&nbsp;</td>
      <td align="center" bordercolor="cccccc">&nbsp;</td>
	  
	  <? }?>
	  
	  
    </tr>
    <? }?>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="88">&nbsp;</td>
    </tr>
    <tr>
      <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="42%" height="31" valign="bottom" nowrap><div align="center"><span class="style2 STYLE3">赢余个数:<?=49-$sum_re?>　亏损个数:<?=$sum_re?>　吃码总额:<?=round($sum_zmzm,2)?>　走飞总额:<?=round($sum_sum-$sum_zmzm,2)?></span></div></td>
          <td width="58%" valign="bottom" nowrap><span class="style4"> 　走飞赔率:<span class="style3">
            <input name="rake" type="text" id="rake" onKeyPress="setform.zm_num.value='';" value="<?=$rake?>" size="2" maxlength="5">
            </span> 走飞退水:<span class="style3">
              <input name="ds" type="text" id="ds" onKeyPress="setform.zm_num.value='';" value="<?=$ds?>" size="2" maxlength="5">
              </span>最大负数:<span class="style3">
                <input name="zf_num" type="text" id="zf_num" onKeyPress="setform.zm_num.value='';" value="<?=$zf_num?>" size="6" maxlength="10">
                </span></span><span class="style3"><strong>平均吃码:
                  <input name="zm_num" type="text" id="zm_num" onKeyPress="setform.zf_num.value='';" value="<?=$zm_num?>" size="6" maxlength="10">
                  <input type="submit" name="Submit2" value="确定">
                  <!-- <a href="#" title="精算之前先设置最大负数,再设置吃码占成百分比,然后再点精算!"><input type="button" name="Submit" value="精算" onclick="window.location='?js=1&out=1&become=0&vtm=0&setpr=100&dates=057';"></a>-->
                </strong></span></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
