<?
if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}

$class1=$_GET['class1'];
$class2=$_GET['class2'];




if ($class1=="��1-6" or $class1=="����1-6" or $class1=="����" or $class1=="����"   or $class1=="�벨" or $class1=="β��" or $class1=="��˫��С" or $class1=="һ��" or $class1=="����" or $class1=="����" or $class1=="һ�ֹ���" or $class1=="���" or $class1=="��ѡ��" or $class1=="��ѡ��"){

if ($class1=="��1-6" ){
$result = mysql_query("select * from ka_bl where   class1='".$class1."'  order by class2,id");
}
else if ($class1=="����1-6" ){
$result = mysql_query("select * from ka_bl where   class1='��1-6'  order by class2,id");
}
else if ($class1=="��˫��С" ){
$result = mysql_query("select * from ka_bl where   (class3='��' or class3='˫' or class3='��' or class3='С' or  class3='�ϵ�' or class3='��˫' or class3='�첨' or class3='�̲�' or class3='����' or class3='�ܵ�' or class3='��˫' or class3='�ܴ�' or class3='��С') and (class2='��1��' or class2='��2��' or class2='��3��' or class2='��4��' or class2='��5��'  or class2='��6��' or class2='��A' or class2='��A')  order by class2,id");
}
else if ($class1=="β��" ){
$result = mysql_query("select * from ka_bl where class1='ͷ��' or class1='β��'  order by id");
}
else if ($class1=="һ��" or $class1=="����" or $class1=="����" or $class1=="һ�ֹ���" or $class1=="���" or $class1=="��ѡ��" or $class1=="��ѡ��" ){
$result = mysql_query("select * from 3dka_bl where class1='".$class1."' and class2='".$class2."' order by id");
}

else{
$result = mysql_query("select * from ka_bl where   class1='".$class1."'  order by id");
}

}else{
    if ($class1=="��Ф" && $class2=="һФ")
        $result = mysql_query("select * from ka_bl where  (class1='".$class1."' and class2='".$class2."') or (class1='����β��' and class2='����β��') order by id"); 
    else if ($class1=="��Ф" && $class2=="��Ф")
        $result = mysql_query("select * from ka_bl where  (class1='".$class1."' and class2='".$class2."') or (class1='��ɫ��' and class2='��ɫ��') order by id desc"); 
    else{//$blbl.="select * from ka_bl where  class1='".$class1."' and class2='".$class2."' order by id";
        $result = mysql_query("select * from ka_bl where  class1='".$class1."' and class2='".$class2."' order by id"); }

}

while($image = mysql_fetch_array($result)){


if ($class1=="����"){

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

if ($class1=="��Ф" || $class1=="��Ф") {
	$result = mysql_query("select * from mdrop where   class1='".$class1."' and class2='".$class2."'  order by id");
	while($image = mysql_fetch_array($result)){
		$blbl.=$image['class3']."@@@".$image['rate']."@@@x@@@x@@@x@@@x###";
	}
}




echo $blbl;
$ddf=date( "Y-m-d H:i:s",time()-20);
$exe=mysql_query("update ka_bl set blrate=rate where class1='".$class1."' and blrate<>rate and adddate<'".$ddf."'");


?>
