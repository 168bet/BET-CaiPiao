<?
require_once dirname(__FILE__).'/conjunction.php';
if ($admin_info!="1"){
echo "<script>alert('ÇëÏÈµÇÂ¼!');top.location.href='index.php';</script>"; 
exit;
}

$commandName=$_GET['commandName'];
$class1=$_GET['class1'];
//$class2=$_GET['class2'];
$ids=$_GET['ids'];
//$sqq=$_GET['sqq'];
$class3=$_GET['class3'];
$qtqt=$_GET['qtqt'];
$lxlx=$_GET['lxlx'];
if ($commandName=="MODIFYRATE"){

    if ($class1=="ÉúĞ¤" || $class1=="Á¬Ğ¤"){
        if($lxlx==1)
	    $exe=mysql_query("update mdrop set rate=rate+".$qtqt." where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
	    else
	    $exe=mysql_query("update mdrop set rate=rate-".$qtqt." where class1='".$class1."' and class2='".$ids."'  and   class3='".$class3."'");
	}else{}

$result3 = mysql_query("select rate from mdrop where  class1='".$class1."' and class2='".$ids."' and class3='".$class3."' order by id"); 
$image = mysql_fetch_array($result3);
$rate=$image['rate'];
echo $rate;
exit;
}
if ($commandName=="LOCK"){
$lock=$_GET['lock'];
if ($lock=="true"){$lock1=1;}else{$lock1=0;}
//$exe=mysql_query("update ka_bl set locked=".$lock1." where class1='".$class1."' and class2='".$ids."' and   class3='".$class3."'");
echo $lock1; 
exit;


}


?>

