
<? 
if(!defined('PHPYOU')) {
	exit('非法进入');
}

$zs=0;


if ($_POST['pabc']==1 or $_POST['pabc']==2 ){
$n=0;
for ($t=1;$t<=49;$t=$t+1){
if ($_POST['num'.$t]!=""){
$number1.=intval($_POST['num'.$t]).",";
$n=$n+1;
}
}
}



if ($_POST['pabc']==3){

switch ($_POST['pan1']){
case "12":
$n1=4;
$number1="12,24,36,48";
break;
case "11":
$n1=4;
$number1="11,23,35,47";
break;
case "10":
$n1=4;
$number1="10,22,34,46";
break;
case "9":
$n1=4;
$number1="9,21,33,45";
break;
case "8":
$n1=4;
$number1="8,20,32,44";
break;
case "7":
$n1=4;
$number1="7,19,31,43";
break;
case "6":
$n1=4;
$number1="6,18,30,42";
break;
case "5":
$n1=4;
$number1="5,17,29,41";
break;
case "4":
$n1=4;
$number1="4,16,28,40";
break;
case "3":
$n1=4;
$number1="3,15,27,39";
break;
case "2":
$n1=4;
$number1="2,14,26,38";
break;
case "1":
$number1="1,13,25,37,49";

$n1=5;
break;
default:
 break;
}

switch ($_POST['pan2']){
case "12":
$m1=4;
$number2="12,24,36,48";
break;
case "11":
$m1=4;
$number2="11,23,35,47";
break;
case "10":
$m1=4;
$number2="10,22,34,46";
break;
case "9":
$m1=4;
$number2="9,21,33,45";
break;
case "8":
$m1=4;
$number2="8,20,32,44";
break;
case "7":
$m1=4;
$number2="7,19,31,43";
break;
case "6":
$m1=4;
$number2="6,18,30,42";
break;
case "5":
$m1=4;
$number2="5,17,29,41";
break;
case "4":
$m1=4;
$number2="4,16,28,40";
break;
case "3":
$m1=4;
$number2="3,15,27,39";
break;
case "2":
$m1=4;
$number2="2,14,26,38";
break;
case "1":
$number2="1,13,25,37,49";

$m1=5;
break;
 default:
 break;
}
$n=$n1+$m1;
}

if ($_POST['pabc']==5){

switch ($_POST['pan1']){
case "12":
$n1=4;
$number1="12,24,36,48";
break;
case "11":
$n1=4;
$number1="11,23,35,47";
break;
case "10":
$n1=4;
$number1="10,22,34,46";
break;
case "9":
$n1=4;
$number1="9,21,33,45";
break;
case "8":
$n1=4;
$number1="8,20,32,44";
break;
case "7":
$n1=4;
$number1="7,19,31,43";
break;
case "6":
$n1=4;
$number1="6,18,30,42";
break;
case "5":
$n1=4;
$number1="5,17,29,41";
break;
case "4":
$n1=4;
$number1="4,16,28,40";
break;
case "3":
$n1=4;
$number1="3,15,27,39";
break;
case "2":
$n1=4;
$number1="2,14,26,38";
break;
case "1":
$number1="1,13,25,37,49";

$n1=5;
break;
default:
 break;
}

switch ($_POST['pan3']){
case "9":
$m1=5;

$number2="9,19,29,39,49";
 break; 
case "8":
$m1=5;

$number2="8,18,28,38,48";
 break;
case "7":
$m1=5;

$number2="7,17,27,37,47";
 break;
case "6":
$m1=5;

$number2="6,16,26,36,46";
 break;
case "5":
$m1=5;

$number2="5,15,25,35,45";
 break;
case "4":
$m1=5;

$number2="4,14,24,34,44";
 break;
case "3":
$m1=5;

$number2="3,13,23,33,43";
 break;
case "2":
$m1=5;

$number2="2,12,22,32,42";
 break;
case "1":
$number2="1,11,21,31,41";
$m1=5;
 break;
case "0":
$number2="10,20,30,40";
$m1=4;
 break;
 default:
 break;
}
$n=$n1+$m1;
}

if ($_POST['pabc']==4){

switch ($_POST['pan3']){
case "9":
$n1=5;

$number1="9,19,29,39,49";
 break; 
case "8":
$n1=5;

$number1="8,18,28,38,48";
 break;
case "7":
$n1=5;

$number1="7,17,27,37,47";
 break;
case "6":
$n1=5;

$number1="6,16,26,36,46";
 break;
case "5":
$n1=5;

$number1="5,15,25,35,45";
 break;
case "4":
$n1=5;

$number1="4,14,24,34,44";
 break;
case "3":
$n1=5;

$number1="3,13,23,33,43";
 break;
case "2":
$n1=5;

$number1="2,12,22,32,42";
 break;
case "1":
$number1="1,11,21,31,41";
$n1=5;
 break;
case "0":
$number1="10,20,30,40";
$n1=4;
 break;
 default:
 break;
}


switch ($_POST['pan4']){
case "9":
$m1=5;

$number2="9,19,29,39,49";
 break;
case "8":
$m1=5;

$number2="8,18,28,38,48";
 break;
case "7":
$m1=5;

$number2="7,17,27,37,47";
 break;
case "6":
$m1=5;

$number2="6,16,26,36,46";
 break;
case "5":
$m1=5;
$number2="5,15,25,35,45";
 break;
case "4":
$m1=5;

$number2="4,14,24,34,44";
 break;
case "3":
$m1=5;

$number2="3,13,23,33,43";
 break;
case "2":
$m1=5;

$number2="2,12,22,32,42";
 break;
case "1":
$number2="1,11,21,31,41";
$m1=5;
 break;
case "0":
$number2="10,20,30,40";
$m1=4;
 break;
 default:
 break;
}



$n=$n1+$m1;
}
$number3=$number1;

switch ($_POST['rtype']){


case "三全中":

if ($_POST['pabc']==2){


$mama="1,1,1";
$number2=$_POST['dm1'].",".$_POST['dm2'];
$mu=explode(",",$number1);

for ($t=0;$t<count($mu)-1;$t=$t+1){
$mama.="/".$mu[$t].",".$number2;
}


$ff=explode("/",$mama);
$zzz="/1,1,1";
for ($p=1;$p<=count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);


for ($k=0;$k<=2;$k=$k+1){

for ($t=0;$t<=1;$t=$t+1){

if (intval($un[$t])>intval($un[$t+1])){

$tmp=$un[$t+1];
$un[$t+1]=$un[$t];
$un[$t]=$tmp;
}
}
}
$x=$un[0].",".$un[1].",".$un[2];
$zzz=$zzz."/".$x;
}


}else{



$mu=explode(",",$number1);





$mamama="1,1,1";


for ($f=0;$f<count($mu)-1;$f=$f+1){
$t=0;
for ($t=0;$t<count($mu)-1;$t=$t+1){
if ($f!=$t and $f<$t){
$mama=$mama."/".$mu[$f].",".$mu[$t];
}
}
}


$ma=explode("/",$mama);




for ($f=0;$f<count($mu)-1;$f=$f+1){

for ($t=0;$t<count($ma)-1;$t=$t+1){

$ma11=explode(",",$ma[$t]);

if ($ma11[0]!=$mu[$f] and $ma11[1]!=$mu[$f]){
if ($f!=$t and $f<$t){
$mamama=$mamama."#".$ma[$t].",".$mu[$f];
}
}
}
}

$ff=explode("#",$mamama);
for ($p=0;$p<count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);
for ($k=0;$k<=2;$k=$k+1){
for ($f=0;$f<=1;$f=$f+1){
if ($un[$f]>$un[$f+1]){

$tmp=$un[$f+1];
$un[$f+1]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[1].",".$un[2];
}

for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){

}else{
$zzz=$zzz."/".$ff[$f];

}
}
}



break;


case "三中二":


if ($_POST['pabc']==2){


$mama="1,1,1";
$number2=$_POST['dm1'].",".$_POST['dm2'];
$mu=explode(",",$number1);

for ($t=0;$t<count($mu)-1;$t=$t+1){
$mama.="/".$mu[$t].",".$number2;
}


$ff=explode("/",$mama);
$zzz="/1,1,1";
for ($p=1;$p<=count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);


for ($k=0;$k<=2;$k=$k+1){

for ($t=0;$t<=1;$t=$t+1){

if (intval($un[$t])>intval($un[$t+1])){

$tmp=$un[$t+1];
$un[$t+1]=$un[$t];
$un[$t]=$tmp;
}
}
}
$x=$un[0].",".$un[1].",".$un[2];
$zzz=$zzz."/".$x;
}


}else{



$mu=explode(",",$number1);





$mamama="1,1,1";


for ($f=0;$f<count($mu)-1;$f=$f+1){
$t=0;
for ($t=0;$t<count($mu)-1;$t=$t+1){
if ($f!=$t and $f<$t){
$mama=$mama."/".$mu[$f].",".$mu[$t];
}
}
}


$ma=explode("/",$mama);




for ($f=0;$f<count($mu)-1;$f=$f+1){

for ($t=0;$t<count($ma)-1;$t=$t+1){

$ma11=explode(",",$ma[$t]);

if ($ma11[0]!=$mu[$f] and $ma11[1]!=$mu[$f]){
if ($f!=$t and $f<$t){
$mamama=$mamama."#".$ma[$t].",".$mu[$f];
}
}
}
}

$ff=explode("#",$mamama);
for ($p=0;$p<count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);
for ($k=0;$k<=2;$k=$k+1){
for ($f=0;$f<=1;$f=$f+1){
if ($un[$f]>$un[$f+1]){

$tmp=$un[$f+1];
$un[$f+1]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[1].",".$un[2];
}

for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){

}else{
$zzz=$zzz."/".$ff[$f];

}
}
}

break;

case "二全中":
if ($_POST['pabc']==1){
$mama="1,1";
$mu=explode(",",$number1);


for ($f=0;$f<count($mu)-1;$f=$f+1){
for ($t=0;$t<count($mu)-1;$t=$t+1){
if ($f!=$t and $f<$t){
$mama=$mama."/".$mu[$f].",".$mu[$t];
}
}
}

$ff=explode("/",$mama);

for ($p=0;$p<=count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);
if (intval($un[$f])>intval($un[$f+1])){

$tmp=$un[$f+1];
$un[$f+1]=$un[$f];
$un[$f]=$tmp;
}

$x=$un[0].",".$un[1];
$zzz=$zzz."/".$x;
}
}


if ($_POST['pabc']==2){
$mama="1,1";
$mu=explode(",",$number1);
$number2=$_POST['dm1'];

for ($f=0;$f<count($mu)-1;$f=$f+1){
$mama=$mama."/".$mu[$f].",".$_POST['dm1'];
}

$ff=explode("/",$mama);
$zzz="/1,1,1";
for ($p=1;$p<=count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
if ($un[0]>$un[1]){
$tmp=$un[1];
$un[1]=$un[0];
$un[0]=$tmp;
}
$x=$un[0].",".$un[1];
$zzz=$zzz."/".$x;

}
}

if ($_POST['pabc']==3 or $_POST['pabc']==4 or $_POST['pabc']==5){
$mu=explode(",",$number1);
$mu1=explode(",",$number2);
$mama="1,1";

for ($f=0;$f<=count($mu)-1;$f=$f+1){
for ($t=0;$t<=count($mu1)-1;$t=$t+1){

if ($mu[$f]!=$mu1[$t]){

$mama=$mama."/".$mu[$f].",".$mu1[$t];
}
}
}


$ff=explode("/",$mama);
$zzz="/1,1,1";
for ($p=1;$p<=count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);


if ($un[0]>$un[1]){
$tmp=$un[1];
$un[1]=$un[0];
$un[0]=$tmp;
}

$x=$un[0].",".$un[1];
$zzz=$zzz."/".$x;
}
}


break;

case "二中特":
if ($_POST['pabc']==1){


$mama="1,1";
$mu=explode(",",$number1);


for ($f=0;$f<count($mu)-1;$f=$f+1){
for ($t=0;$t<count($mu)-1;$t=$t+1){
if ($f!=$t and $f<$t){
$mama=$mama."/".$mu[$f].",".$mu[$t];
}
}
}

$ff=explode("/",$mama);

for ($p=0;$p<=count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);
if (intval($un[$f])>intval($un[$f+1])){

$tmp=$un[$f+1];
$un[$f+1]=$un[$f];
$un[$f]=$tmp;
}

$x=$un[0].",".$un[1];
$zzz=$zzz."/".$x;
}
}


if ($_POST['pabc']==2){
$mama="1,1";
$mu=explode(",",$number1);
$number2=$_POST['dm1'];

for ($f=0;$f<count($mu)-1;$f=$f+1){
$mama=$mama."/".$mu[$f].",".$_POST['dm1'];
}

$ff=explode("/",$mama);
$zzz="/1,1,1";
for ($p=1;$p<=count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
if ($un[0]>$un[1]){
$tmp=$un[1];
$un[1]=$un[0];
$un[0]=$tmp;
}
$x=$un[0].",".$un[1];
$zzz=$zzz."/".$x;

}
}

if ($_POST['pabc']==3 or $_POST['pabc']==4 or $_POST['pabc']==5){
$mu=explode(",",$number1);
$mu1=explode(",",$number2);
$mama="1,1";

for ($f=0;$f<=count($mu)-1;$f=$f+1){
for ($t=0;$t<=count($mu1)-1;$t=$t+1){

$mama=$mama."/".$mu[$f].",".$mu1[$t];
}
}

$ff=explode("/",$mama);
$zzz="/1,1,1";
for ($p=1;$p<=count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);


if ($un[0]>$un[1]){
$tmp=$un[1];
$un[1]=$un[0];
$un[0]=$tmp;
}

$x=$un[0].",".$un[1];
$zzz=$zzz."/".$x;
}
}


break;
case "特串":



if ($_POST['pabc']==1){


$mama="1,1";
$mu=explode(",",$number1);


for ($f=0;$f<count($mu)-1;$f=$f+1){
for ($t=0;$t<count($mu)-1;$t=$t+1){
if ($f!=$t and $f<$t){
$mama=$mama."/".$mu[$f].",".$mu[$t];
}
}
}

$ff=explode("/",$mama);

for ($p=0;$p<=count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);
if (intval($un[$f])>intval($un[$f+1])){

$tmp=$un[$f+1];
$un[$f+1]=$un[$f];
$un[$f]=$tmp;
}

$x=$un[0].",".$un[1];
$zzz=$zzz."/".$x;
}
}


if ($_POST['pabc']==2){
$mama="1,1";
$mu=explode(",",$number1);
$number2=$_POST['dm1'];

for ($f=0;$f<count($mu)-1;$f=$f+1){
$mama=$mama."/".$mu[$f].",".$_POST['dm1'];
}

$ff=explode("/",$mama);
$zzz="/1,1,1";
for ($p=1;$p<=count($ff);$p=$p+1){
$un=explode(",",$ff[$p]);
if ($un[0]>$un[1]){
$tmp=$un[1];
$un[1]=$un[0];
$un[0]=$tmp;
}
$x=$un[0].",".$un[1];
$zzz=$zzz."/".$x;

}
}

if ($_POST['pabc']==3 or $_POST['pabc']==4 or $_POST['pabc']==5){
$mu=explode(",",$number1);
$mu1=explode(",",$number2);
$mama="1,1";

for ($f=0;$f<=count($mu)-1;$f=$f+1){
for ($t=0;$t<=count($mu1)-1;$t=$t+1){

$mama=$mama."/".$mu[$f].",".$mu1[$t];
}
}

$ff=explode("/",$mama);
$zzz="/1,1,1";
for ($p=1;$p<=count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);


if ($un[0]>$un[1]){
$tmp=$un[1];
$un[1]=$un[0];
$un[0]=$tmp;
}

$x=$un[0].",".$un[1];
$zzz=$zzz."/".$x;
}
}


break;


case "四中一":

if ($_POST['pabc']==2){

$mama="1,1,1,1";
$number2=$_POST['dm1'].",".$_POST['dm2'];
$mu=explode(",",$number1);

for ($s=0;$s<count($mu)-2;$s=$s+1){
for ($t=$s+1;$t<count($mu)-1;$t=$t+1){
$mama.="/".$mu[$s].",".$mu[$t].",".$number2;
}
}

$ff=explode("/",$mama);
$zzz="/1,1,1,1";
for ($p=1;$p<=count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);


for ($k=0;$k<=3;$k=$k+1){

for ($t=0;$t<=2;$t=$t+1){

if (intval($un[$t])>intval($un[$t+1])){

$tmp=$un[$t+1];
$un[$t+1]=$un[$t];
$un[$t]=$tmp;
}
}
}
$x=$un[0].",".$un[1].",".$un[2].",".$un[3];
$zzz=$zzz."/".$x;
}


}else{

$mu=explode(",",$number1);

$mamama="1,1,1,1";

for ($d=0;$d<count($mu)-1;$d=$d+1){

for ($f=0;$f<count($mu)-1;$f=$f+1){
$t=0;
for ($t=0;$t<count($mu)-1;$t=$t+1){
if ( $d<$f  and $f<$t){
$mama=$mama."/".$mu[$d].",".$mu[$f].",".$mu[$t];
}
}
}
}

$ma=explode("/",$mama);

for ($d=0;$d<count($mu)-1;$d=$d+1){
for ($f=0;$f<count($mu)-1;$f=$f+1){

for ($t=0;$t<count($ma)-1;$t=$t+1){

$ma11=explode(",",$ma[$t]);

if ($ma11[0]!=$mu[$f] and $ma11[1]!=$mu[$f] and $ma11[2]!=$mu[$f] and $ma11[1]!=$mu[$d] and $ma11[2]!=$mu[$d] and $ma11[3]!=$mu[$d]){
if ( $f<$t and $d<$f){
$mamama=$mamama."#".$ma[$t].",".$mu[$f].",".$mu[$d];
}
}
}
}
}

$ff=explode("#",$mamama);
for ($p=0;$p<count($ff);$p=$p+1){

$un=explode(",",$ff[$p]);
for ($k=0;$k<=3;$k=$k+1){
for ($f=0;$f<=2;$f=$f+1){
if ($un[$f]>$un[$f+1]){

$tmp=$un[$f+1];
$un[$f+1]=$un[$f];
$un[$f]=$tmp;
}
}
}
$ff[$p]=$un[0].",".$un[1].",".$un[2].",".$un[3];
}

for ($f=0;$f<=count($ff);$f=$f+1){
if (strpos($zzz,$ff[$f])>0){

}else{
$zzz=$zzz."/".$ff[$f];
}
}
}
break;




}

$number1=$number1;


if ($_POST['pabc']==2){

if ($_POST['dm1']!=""){
$number1=$number1.",".$_POST['dm1'];
}
if ($_POST['dm2']!=""){
$number1=$number1.",".$_POST['dm2'];
}
}
if ($_POST['pabc']==3 or $_POST['pabc']==4 or $_POST['pabc']==5 ){
$number1=$number1.",".$number2;
}

switch ($_POST['rtype']){

case "三全中":
$rtype="三全中";
$rate_id=617;
if ($_POST['pabc']==2){
$zs=$n;
}else{
$zs=$n*($n-1)*($n-2)/6;
}
$R=14;
break;

case "四中一":
$rtype="四中一";
$rate_id=808;
if ($_POST['pabc']==2){
$zs=$n*($n-1)/2;
}else{
$zs=$n*($n-1)*($n-2)*($n-3)/24;
}
$R=45;
break;



case "三中二":
$R=15;
$rtype="三中二";

if ($_POST['pabc']==2){

$zs=$n;
}else{
$zs=$n*($n-1)*($n-2)/6;
}
$rate_id=619;
break;
case "二全中":
$R=13;
$rtype="二全中";
if ($_POST['pabc']==3 or $_POST['pabc']==4 or $_POST['pabc']==5){
$zs=$n1*$m1;
}elseif ($_POST['pabc']==2) {
$zs=$n;
}else{
$zs=$n*($n-1)/2;
}

$rate_id=613;
break;
case "二中特":
$R=16;


if ($_POST['pabc']==3 or $_POST['pabc']==4 or $_POST['pabc']==5){
$zs=$n1*$m1;
}elseif ($_POST['pabc']==2) {
$zs=$n;

}else{
$zs=$n*($n-1)/2;
}

$rate_id=615;
$rtype="二中特";
break;
case "特串":
$R=17;

if ($_POST['pabc']==3 or $_POST['pabc']==4 or $_POST['pabc']==5){
$zs=$n1*$m1;
}elseif ($_POST['pabc']==2) {
$zs=$n;

}else{
$zs=$n*($n-1)/2;
}
$rate_id=616;

$rtype="特串";
break;
}


$result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='连码' and class2='".$rtype."'  order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
$sum_money=$ka_guanuserkk1[0];



if ($zs==0){
echo "<script>alert('请选择相应码数!');parent.parent.mem_order.location.href='index.php?action=k_lm';window.location.href='index.php?action=left';</script>"; 
exit;
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
if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金额仅能输入数字!!"); return false;}
}

function SubChk(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert("请输入下注金额!!");
return false;
}
if(isNaN(document.all.gold.value) == true){
document.all.gold.focus();
alert("下注金额仅能输入数字!!");
return false;
}
if(eval(document.all.gold.value) < <?=ka_memuser("xy")?>){
document.all.gold.focus();
alert("下注金额不可小於最低下注金额:<?=ka_memuser("xy")?>!!");
return false;
}
if(eval(document.all.gold.value)*<?=$zs?> > <?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("对不起,本期有下注金额最高限制 : <?=ka_memds($R,3)?>  !!");
return false;
}
if(eval(document.all.gold.value)> <?=ka_memds($R,2)?>){
document.all.gold.focus();
alert("下注金额不可大於单注限额:<?=ka_memds($R,2)?>!!");
return false;
}
if((<?=$sum_money?>+eval(document.all.gold.value)*<?=$zs?>) ><?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("本期累计下注共: <?=$sum_money?>\n下注金额已超过单期限额!!");
return false;
}
if((eval(document.all.gold.value)*<?=$zs?>) > <?=ka_memuser("ts")?>){
document.all.gold.focus();
alert("下注金额不可大於信用额度!!");
return false;
}


document.all.btnCancel.disabled = true;
document.all.btnSubmit.disabled = true;
document.LAYOUTFORM.submit();
}
function CountWinGold(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('未输入下注金额!!!');
}else{
//document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value /1000 - document.all.gold.value);
document.all.pc1.innerHTML=Math.round(document.all.gold.value * document.all.ioradio1.value);
count_win=true;
}
}
function CountWinGold1(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('未输入下注金额!!!');
}else{
document.all.pc1.innerHTML=Math.round(document.all.gold.value * document.all.ioradio1.value);
count_win=true;
}
}
</SCRIPT>


<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<?

if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=cb4619><font color=ffff00>封盘中....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"离开\" name=\"btnCancel11\" /></font></td>          </tr>      </table>"; 
  exit;
}


?>

<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=230 border=0>

<tr>
  <td valign="top" class="Left_Place"><TABLE class=t_list cellSpacing=1 cellPadding=0 width=210 border=0>
      <tr>
        <td height="25" colspan="2" align="center" bgcolor="#5A79C6"><span class="STYLE1">确认下注</span></td>
      </tr>
      <tr>
        <td width="35%" height="25" align="right"  class=t_td_caption_1><span class="STYLE1">账号名称</span></td>
        <td width="65%"  class=t_td_text><span class="STYLE2">
          <?=ka_memuser("kauser")?>
        </span></td>
      </tr>
      <tr>
        <td height="25" align="right"  class=t_td_caption_1><span class="STYLE1">会员类型 </span></td>
        <td  class=t_td_text><span class="STYLE2">
          <?=ka_memuser("abcd")?>
          盘</span></td>
      </tr>
      <tr>
        <td height="25" align="right"  class=t_td_caption_1><span class="STYLE1">总信用额</span></td>
        <td  class=t_td_text><span class="STYLE2">￥
          <?=ka_memuser("cs")?>
          元</span></td>
      </tr>
      <tr>
        <td height="25" align="right"  class=t_td_caption_1><span class="STYLE1">可用余额</span></td>
        <td  class=t_td_text><span class="STYLE2">￥
          <?=ka_memuser("ts")?>
          元</span></td>
      </tr>
      <tr>
        <td height="25" align="right"  class=t_td_caption_1><span class="STYLE1">最低限额</span></td>
        <td  class=t_td_text><span class="STYLE2">￥
          <?=ka_memuser("xy")?>
          元</span></td>
      </tr>
      <tr>
        <td height="25" align="right"  class=t_td_caption_1><span class="STYLE1">下注总额</span></td>
        <td  class=t_td_text><span class="STYLE2">
          <? 
	    $result2 = mysql_query("Select SUM(sum_m) As sum_m1   From ka_tan Where kithe=".$Current_Kithe_Num."  and   username='".$_SESSION['username']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	
	?>
          ￥<? echo $mkmk;?>元</span></td>
      </tr>
      <tr>
        <td height="25" align="right"  class=t_td_caption_1><span class="STYLE1">当前期数</span></td>
        <td  class=t_td_text><span class="STYLE2">
          <?=$Current_Kithe_Num?>
          期</span></td>
      </tr>

      <FORM name=LAYOUTFORM  onSubmit="return false" action=index.php?action=k_tanlm method=post>
        <tr>
          <td width="35%" colspan="2" height="25" class=t_td_caption_1 align="center" style="LINE-HEIGHT: 22px"><div align="center"><FONT color=#cc0000>连码&nbsp;<?=ka_bl($rate_id,"class2")?>
                  <? if (ka_bl($rate_id,"class2")=="三中二" or ka_bl($rate_id,"class2")=="三中二") {
				  echo "之".ka_bl($rate_id,"class3");
				  }
				  
				  ?>
				  
          </FONT> @ <strong><FONT
color=#ff0000><?=ka_bl($rate_id,"rate")?></FONT></strong> </div>
<?=$number1?></td>
        </tr>
        <tr>
          <td height="25" colspan="2" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><div align="center"><strong>组合共&nbsp;<font color=ff0000><?=$zs?></font>&nbsp;组</strong></div></td>
        </tr>
        <tr>
          <td height="25" colspan="2" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;下注金额:
            <INPUT
name=gold id=gold onKeyPress="return CheckKey()"
onkeyup="return CountWinGold()" value="<?=$_POST['jq']?>" size=8 maxLength=8></td>
        </tr>
        <tr>
          <td height="25" colspan="2" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;总下注金额: <strong><FONT id=pc1 color=#ff0000><?=$_POST['jq']*$zs?>&nbsp;</FONT></strong></td>
        </tr>
        <TR>
          <TD height="25" colspan="2" bgcolor="#ffffff">&nbsp;单注限额: <?=ka_memds($R,2)?></TD>
        </TR>
        <TR>
          <TD height="25" colspan="2" bgcolor="#ffffff">&nbsp;单号限额: <?=ka_memds($R,3)?></TD>
        </TR>
        <tr>
          <td height="30" colspan="2" align="center" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><INPUT type='hidden' Name=rate_id value='<?=$rate_id?>'>
          
              <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="放弃" name="btnCancel" />
			  
            &nbsp;&nbsp;
            <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type="submit" value="确定" onclick=SubChk(); name="btnSubmit" />         </td>
        </tr>
        <INPUT type=hidden
value=SP11 name=concede>
        <INPUT type=hidden value='<?=ka_bl($rate_id,"rate")*1000?>' name=ioradio>
        <INPUT type=hidden value='<?=$zs?>' name=ioradio1>
        <INPUT type=hidden value='<?=$zzz?>' name=number1>

        <INPUT type=hidden value='<?=$number2?>' name=number2>
        <INPUT type=hidden value='<?=$number3?>' name=number3>
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
