<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}

$class1=$_GET['class1'];
$class2=$_GET['class2'];


if ($class1=="正1-6" or $class1=="过关" or $class1=="连码" or $class1=="生肖" or $class1=="半波" or $class1=="半半波" or $class1=="头数" or $class1=="尾数" or $class1=="正特尾数" or $class1=="七色波" or $class1=="正肖"){

$sql="select * from mdrop where   class1='".$class1."'";

if ($class1=="正特尾数")$sql.=" or (class1='生肖' and class2='一肖')";

if ($class1=="连码")
$sql.="  order by id";
else
$sql.="  order by class2,id";
$result = mysql_query($sql); //

}else{
if ($class1=="头尾数"){
$sql_ts="Select * from (Select * from mdrop where class1='头数'   Order By ID) as a";
$sql_ws="Select * from (Select * from mdrop where class1='尾数'   Order By ID) as b";
$sql="Select c.* from (".$sql_ts." union all ".$sql_ws.") as c";
$result = mysql_query($sql);

}elseif ($class1=="连生肖"){
$result = mysql_query("Select rate,class3,class2,locked,class1 from mdrop where (class1='生肖' and class2<>'一肖') or class1='连肖'   Order By ID");

}elseif ($class1=="正色波"){
$result = mysql_query("Select rate,class3,class2,locked,class1 from mdrop where class1='七色波' or class1='正肖'   Order By ID Desc");

}else{
$result = mysql_query("select * from mdrop where  class1='".$class1."' and class2='".$class2."' order by id"); }

}

while($image = mysql_fetch_array($result)){


if ($class1=="连码" || $image['class2'] =="四肖" || $image['class2'] =="五肖" || $image['class2'] =="六肖"  || $image['class2'] =="二肖"  || $image['class2'] =="三肖"){

$result1=mysql_query("Select SUM(sum_m) As sum_m from ka_tan where kithe='".$Current_Kithe_Num."' and  class1='".$image['class1']."' and  class2='".$image['class2']."'"); 
$rs5=mysql_fetch_array($result1);
}else{
$result2=mysql_query("Select SUM(sum_m) As sum_m from ka_tan where kithe='".$Current_Kithe_Num."' and  class1='".$image['class1']."' and  class2='".$image['class2']."' and class3='".$image['class3']."' "); 
$rs5=mysql_fetch_array($result2);
}
if ($rs5['sum_m']==""){$sum_m=0;}else{$sum_m=$rs5['sum_m'];}
$rate=$image['rate'];
if ($image['rate']!=$image['blrate']){
$blbl.=$image['class3']."@@@".$rate."@@@".$image['rate']."@@@".$sum_m."###";}else{
$blbl.=$image['class3']."@@@".$rate."@@@".$image['rate']."@@@".$sum_m."###";

}


}




echo $blbl;
$ddf=date( "Y-m-d H:i:s",time()-20);
if ($class1=="头尾数"){
$exe=mysql_query("update mdrop set blrate=rate where class1='头数' and blrate<>rate and adddate<'".$ddf."'");
$exe=mysql_query("update mdrop set blrate=rate where class1='尾数' and blrate<>rate and adddate<'".$ddf."'");
}else{
$exe=mysql_query("update mdrop set blrate=rate where class1='".$class1."' and blrate<>rate and adddate<'".$ddf."'");
}
?>
