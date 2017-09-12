<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}

$class1=$_GET['class1'];
$class2=$_GET['class2'];




if ($class1=="正1-6" or $class1=="正码1-6" or $class1=="过关" or $class1=="连码"   or $class1=="半波" or $class1=="尾数" or $class1=="单双大小" or $class1=="一字" or $class1=="二字" or $class1=="三字" or $class1=="一字过关" or $class1=="跨度" or $class1=="组选三" or $class1=="组选六"){

if ($class1=="正1-6" ){
$result = mysql_query("select * from ka_bl where   class1='".$class1."'  order by class2,id");
}
else if ($class1=="正码1-6" ){
$result = mysql_query("select * from ka_bl where   class1='正1-6'  order by class2,id");
}
else if ($class1=="单双大小" ){
$result = mysql_query("select * from ka_bl where   (class3='单' or class3='双' or class3='大' or class3='小' or  class3='合单' or class3='合双' or class3='红波' or class3='绿波' or class3='蓝波' or class3='总单' or class3='总双' or class3='总大' or class3='总小') and (class2='正1特' or class2='正2特' or class2='正3特' or class2='正4特' or class2='正5特'  or class2='正6特' or class2='特A' or class2='正A')  order by class2,id");
}
else if ($class1=="尾数" ){
$result = mysql_query("select * from ka_bl where class1='头数' or class1='尾数'  order by id");
}
else if ($class1=="一字" or $class1=="二字" or $class1=="三字" or $class1=="一字过关" or $class1=="跨度" or $class1=="组选三" or $class1=="组选六" ){
$result = mysql_query("select * from 3dka_bl where class1='".$class1."' and class2='".$class2."' order by id");
}

else{
$result = mysql_query("select * from ka_bl where   class1='".$class1."'  order by id");
}

}else{
    if ($class1=="生肖" && $class2=="一肖")
        $result = mysql_query("select * from ka_bl where  (class1='".$class1."' and class2='".$class2."') or (class1='正特尾数' and class2='正特尾数') order by id"); 
    else if ($class1=="正肖" && $class2=="正肖")
        $result = mysql_query("select * from ka_bl where  (class1='".$class1."' and class2='".$class2."') or (class1='七色波' and class2='七色波') order by id desc"); 
    else{//$blbl.="select * from ka_bl where  class1='".$class1."' and class2='".$class2."' order by id";
        $result = mysql_query("select * from ka_bl where  class1='".$class1."' and class2='".$class2."' order by id"); }

}

while($image = mysql_fetch_array($result)){


if ($class1=="连码"){

$result1=mysql_query("Select SUM(sum_m) As sum_m from ka_tan where Kithe='".$Current_Kithe_Num."' and  class1='".$image['class1']."' and  class2='".$image['class2']."' and username='".$_SESSION['username']."' "); 
$rs5=mysql_fetch_array($result1);
}else{
$result2=mysql_query("Select SUM(sum_m) As sum_m from ka_tan where Kithe='".$Current_Kithe_Num."' and  class1='".$image['class1']."' and  class2='".$image['class2']."' and class3='".$image['class3']."' "); 
$rs5=mysql_fetch_array($result2);
}
if ($rs5['sum_m']==""){$sum_m=0;}else{$sum_m=$rs5['sum_m'];}





$rate=$image['rate'];




$blbl.=$image['class3']."@@@".$rate."@@@".$image['blrate']."@@@".$sum_m."@@@".$image['xr']."@@@".$image['locked']."###";





}

if ($class1=="生肖" || $class1=="连肖") {
	$result = mysql_query("select * from mdrop where   class1='".$class1."' and class2='".$class2."'  order by id");
	while($image = mysql_fetch_array($result)){
		$blbl.=$image['class3']."@@@".$image['rate']."@@@x@@@x@@@x@@@x###";
	}
}




echo $blbl;
$ddf=date( "Y-m-d H:i:s",time()-20);
$exe=mysql_query("update ka_bl set blrate=rate where class1='".$class1."' and blrate<>rate and adddate<'".$ddf."'");


?>
