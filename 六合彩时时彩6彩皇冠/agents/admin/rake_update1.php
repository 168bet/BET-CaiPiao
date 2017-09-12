<?
require_once dirname(__FILE__).'/conjunction.php';
///开奖期数   
  
  $Current_Kithe_Num=1;
  $result=mysql_query("Select ID,NN,ND,NA,N1,N2,N3,N4,N5,N6,lx,kitm,kitm1,kizt,kizt1,kizm,kizm1,kizm6,kizm61,kigg,kigg1,kilm,kilm1,kisx,kisx1,kibb,kibb1,kiws,kiws1,zfb,zfbdate,zfbdate1,best From ka_Kithe where na=0 Order By ID Desc LIMIT 1"); 

$Current_KitheTable=mysql_fetch_array($result);
	$Current_Kithe_Num=$Current_KitheTable[1];
///波色  
 
function Get_bs_Color($i){   
   $result=mysql_query("Select ID,color From ka_color where id=".$i." Order By ID"); 
$ka_configg=mysql_fetch_array($result); 
return $ka_configg['color'];
   }
if ($admin_info!="1"){
echo "<script>alert('请先登录!');top.location.href='index.php';</script>"; 
exit;
}
 $text=date("Y-m-d H:i:s");
$commandName=$_GET['commandName'];
$class1=$_GET['class1'];
//$class2=$_GET['class2'];
$ids=$_GET['ids'];
//$sqq=$_GET['sqq'];
$class3=$_GET['class3'];
$qtqt=$_GET['qtqt'];
$lxlx=$_GET['lxlx'];

if ($lxlx==1){  //加
if ($class1=="特码" or $class1=="正码"){

if ($class3=="前十五"){
if ($class1=="正码"){require_once 's_zm.php';}else{
require_once 's_tm.php';}
$css=$_GET['css'];
$arr=explode(",",$css);

for($i=0;$i<15;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$arr[$i]."' ");
}

}elseif ($class3=="前十"){
if ($class1=="正码"){require_once 's_zm.php';}else{
require_once 's_tm.php';}
$css=$_GET['css'];
$arr=explode(",",$css);

for($i=0;$i<10;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$arr[$i]."' ");
}

}elseif ($class3=="前五"){
if ($class1=="正码"){require_once 's_zm.php';}else{
require_once 's_tm.php';}
$css=$_GET['css'];
$arr=explode(",",$css);

for($i=0;$i<5;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$arr[$i]."' ");
}

}elseif ($class3=="前三"){
if ($class1=="正码"){require_once 's_zm.php';}else{
require_once 's_tm.php';}
$css=$_GET['css'];
$arr=explode(",",$css);

for($i=0;$i<3;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$arr[$i]."' ");
}

}
for ($tt=1; $tt<=49; $tt++) {
if ($class3=="all"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}elseif ($class3=="单"){
if ($tt%2==1){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="双"){
if ($tt%2==0){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="大"){
if ($tt>=25){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="小"){
if ($tt<=24){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="合单"){
if ((($tt%10)+intval($tt/10))%2==1){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."'  and  class3='".$tt."'");
}
}elseif ($class3=="合双"){
if ((($tt%10)+intval($tt/10))%2==0){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="红"){
if (Get_bs_Color($tt)=="r"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="蓝"){
if (Get_bs_Color($tt)=="b"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="绿"){
if (Get_bs_Color($tt)=="g"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}

}//for
}else{ ///正特


if ($class3=="前十五"){
require_once 's_zt.php';
for($i=0;$i<15;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class3='".$sum_tm[$i]."' ");
}

}elseif ($class3=="前十"){
require_once 's_zt.php';
for($i=0;$i<10;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."'  and  class2='".$ids."' and  class3='".$sum_tm[$i]."' ");
}

}elseif ($class3=="前五"){
require_once 's_zt.php';
for($i=0;$i<5;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$sum_tm[$i]."' ");
}

}elseif ($class3=="前三"){
require_once 's_zt.php';
for($i=0;$i<3;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$sum_tm[$i]."' ");
}

}
for ($tt=1; $tt<=49; $tt++) {



if ($class3=="all"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."' and class3='".$tt."' ");
}elseif ($class3=="单"){
if ($tt%2==1){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}elseif ($class3=="双"){
if ($tt%2==0){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}elseif ($class3=="大"){
if ($tt>=25){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}
elseif ($class3=="小"){
if ($tt<=24){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}elseif ($class3=="合单"){
if ((($tt%10)+intval($tt/10))%2==1){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."'  and  class3='".$tt."'");
}
}elseif ($class3=="合双"){
if ((($tt%10)+intval($tt/10))%2==0){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."'and  class2='".$ids."'  and  class3='".$tt."' ");
}
}elseif ($class3=="红"){
if (Get_bs_Color($tt)=="r"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}elseif ($class3=="蓝"){
if (Get_bs_Color($tt)=="b"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}elseif ($class3=="绿"){
if (Get_bs_Color($tt)=="g"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate+".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}

}
}

}



}else{  //减

if ($class1=="特码" or $class1=="正码"){
if ($class3=="前十五"){
if ($class1=="正码"){require_once 's_zm.php';}else{
require_once 's_tm.php';}
$css=$_GET['css'];
$arr=explode(",",$css);

for($i=0;$i<15;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$arr[$i]."' ");
}

}elseif ($class3=="前十"){
if ($class1=="正码"){require_once 's_zm.php';}else{
require_once 's_tm.php';}
$css=$_GET['css'];
$arr=explode(",",$css);

for($i=0;$i<10;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$arr[$i]."' ");
}

}elseif ($class3=="前五"){
if ($class1=="正码"){require_once 's_zm.php';}else{
require_once 's_tm.php';}
$css=$_GET['css'];
$arr=explode(",",$css);

for($i=0;$i<5;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$arr[$i]."' ");
}

}elseif ($class3=="前三"){
if ($class1=="正码"){require_once 's_zm.php';}else{
require_once 's_tm.php';}
$css=$_GET['css'];
$arr=explode(",",$css);

for($i=0;$i<3;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$arr[$i]."' ");

}

}

for ($tt=1; $tt<=49; $tt++) {
if ($class3=="all"){

$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");

}elseif ($class3=="单"){
if ($tt%2==1){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}

}elseif ($class3=="双"){
if ($tt%2==0){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="大"){
if ($tt>=25){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}
elseif ($class3=="小"){
if ($tt<=24){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="合单"){
if ((($tt%10)+intval($tt/10))%2==1){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."'  and  class3='".$tt."'");
}
}elseif ($class3=="合双"){
if ((($tt%10)+intval($tt/10))%2==0){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="红"){
if (Get_bs_Color($tt)=="r"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="蓝"){
if (Get_bs_Color($tt)=="b"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}
}elseif ($class3=="绿"){
if (Get_bs_Color($tt)=="g"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$tt."' ");
}

}
}

}else{ ///正特


if ($class3=="前十五"){
require_once 's_zt.php';
for($i=0;$i<15;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class3='".$sum_tm[$i]."' ");
}

}elseif ($class3=="前十"){
require_once 's_zt.php';
for($i=0;$i<10;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."'  and  class2='".$ids."' and  class3='".$sum_tm[$i]."' ");
}

}elseif ($class3=="前五"){
require_once 's_zt.php';
for($i=0;$i<5;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$sum_tm[$i]."' ");
}

}elseif ($class3=="前三"){
require_once 's_zt.php';
for($i=0;$i<3;$i++)
{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$sum_tm[$i]."' ");
}

}
for ($tt=1; $tt<=49; $tt++) {
if ($class3=="all"){

$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."' and class3='".$tt."' ");

}elseif ($class3=="单"){
if ($tt%2==1){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}

}elseif ($class3=="双"){
if ($tt%2==0){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}elseif ($class3=="大"){
if ($tt>=25){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}
elseif ($class3=="小"){
if ($tt<=24){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}elseif ($class3=="合单"){
if ((($tt%10)+intval($tt/10))%2==1){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."'  and  class3='".$tt."'");
}
}elseif ($class3=="合双"){
if ((($tt%10)+intval($tt/10))%2==0){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."'and  class2='".$ids."'  and  class3='".$tt."' ");
}
}elseif ($class3=="红"){
if (Get_bs_Color($tt)=="r"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}elseif ($class3=="蓝"){
if (Get_bs_Color($tt)=="b"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");
}
}elseif ($class3=="绿"){
if (Get_bs_Color($tt)=="g"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=rate-".$qtqt." where class1='".$class1."' and  class2='".$ids."' and  class3='".$tt."' ");

}
}
}
}


}

echo "ok";



?>
