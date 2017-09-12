<?
require_once dirname(__FILE__).'/conjunction.php';
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
if ($commandName=="MODIFYRATE"){

if ($lxlx==1){
/*
//正1-6
if ($class1=="正1-6"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate+".$qtqt.",2) where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}

//过关
if ($class1=="过关"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate+".$qtqt.",2)  where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}

//连码
if ($class1=="连码"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate+".$qtqt.",2)  where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}

//自选
if ($class1=="自选"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate+".$qtqt.",2)  where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}
*/

if ($class1=="特码" or $class1=="正码"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate+".$qtqt.",2)  where class1='".$class1."'  and   class3='".$class3."'");
}else{


if ($class1=="正特"){

   if ($ids=="正1特"){ $class22="正码1"; }
  if ($ids=="正2特"){ $class22="正码2"; }
   if ($ids=="正3特"){ $class22="正码3"; }
    if ($ids=="正4特"){ $class22="正码4"; }
	 if ($ids=="正5特"){ $class22="正码5"; }
	  if ($ids=="正6特"){ $class22="正码6"; }
	  if ($class3=="单" || $class3=="双" || $class3=="大" || $class3=="小" || $class3=="红波" || $class3=="蓝波" || $class3=="绿波" ){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate+".$qtqt.",2)  where class1='过关' and class2='".$class22."'  and   class3='".$class3."'");
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate+".$qtqt.",2)  where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}else{

$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate+".$qtqt.",2)  where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}


}else{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate+".$qtqt.",2)  where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");}


}


}else{
/*
//正1-6
if ($class1=="正1-6"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate-".$qtqt.",2) where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}

//过关
if ($class1=="过关"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate-".$qtqt.",2) where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}

//连码
if ($class1=="连码"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate-".$qtqt.",2) where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}

//自选
if ($class1=="自选"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate-".$qtqt.",2) where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}
*/

if ($class1=="特码" or $class1=="正码"){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate-".$qtqt.",2) where class1='".$class1."'  and   class3='".$class3."'");
}else{



if ($class1=="正特"){

   if ($ids=="正1特"){ $class22="正码1"; }
  if ($ids=="正2特"){ $class22="正码2"; }
   if ($ids=="正3特"){ $class22="正码3"; }
    if ($ids=="正4特"){ $class22="正码4"; }
	 if ($ids=="正5特"){ $class22="正码5"; }
	  if ($ids=="正6特"){ $class22="正码6"; }
	  if ($class3=="单" || $class3=="双" || $class3=="大" || $class3=="小" || $class3=="红波" || $class3=="蓝波" || $class3=="绿波" ){
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate-".$qtqt.",2) where class1='过关' and class2='".$class22."'  and   class3='".$class3."'");
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate-".$qtqt.",2) where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}else{

$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate-".$qtqt.",2) where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
}


}else{
$exe=mysql_query("update ka_bl set adddate='". $text."',rate=round(rate-".$qtqt.",2) where class1='".$class1."' and class2='".$ids."' and   class3='".$class3."'");}
}
}



$result3 = mysql_query("select * from ka_bl where  class1='".$class1."' and class2='".$ids."' and class3='".$class3."' order by id"); 
$image = mysql_fetch_array($result3);
$rate=$image['rate'];
echo $rate;
exit;
}
if ($commandName=="LOCK"){
$lock=$_GET['lock'];
if ($lock=="true"){$lock1=1;}else{$lock1=0;}
$exe=mysql_query("update ka_bl set locked=".$lock1." where class1='".$class1."' and class2='".$ids."' and   class3='".$class3."'");
echo $lock1;
exit;


}


?>

