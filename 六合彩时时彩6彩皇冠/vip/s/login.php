<?
if (ka_memuser("stat")==1){
echo "<script>alert('对不起,该用户已被禁止!');top.location.href='index.php?action=logout';</script>"; 
exit;}


if($_SESSION['username']!='guest' && $_SESSION['userid']!='0'){
	

$guanguan1=$_SESSION['username'];
$result = mysql_query("select count(*) from ka_mem  where kauser='".$guanguan1."'  order by id desc");   
//echo "select count(*) from ka_mem  where kauser='".$guanguan1."'  order by id desc";exit;
$num = mysql_result($result,"0");
if($num!=0){}else{
//print_r($_SESSION);exit;
   echo "<script>alert(1);top.location.href='/index.php?action=logout';</script>"; 
  exit;
}



$guanguan1=ka_memuser("guan");
 $result=mysql_query("select * from ka_guan where kauser='".$guanguan1."'  order by id"); 
$row=mysql_fetch_array($result);
if ($row['stat']==1){
echo "<script>alert('对不起,该上级用户已被禁止,有问题请联系你上级!');top.location.href='/index.php?action=logout';</script>"; 
exit;
}


$zongzong1=ka_memuser("zong");
 $result=mysql_query("select * from ka_guan where kauser='".$zongzong1."'  order by id"); 
$row=mysql_fetch_array($result);
if ($row['stat']==1){
echo "<script>alert('对不起,该上级用户已被禁止,有问题请联系你上级!');top.location.href='/index.php?action=logout';</script>"; 
exit;}


$dandan1=ka_memuser("dan");
 $result=mysql_query("select * from ka_guan where kauser='".$dandan1."'  order by id"); 
$row=mysql_fetch_array($result);
if ($row['stat']==1){
echo "<script>alert('对不起,该上级用户已被禁止,有问题请联系你上级!');top.location.href='/index.php?action=logout';</script>"; 
exit;}


$result=mysql_query("select * from tj where  username='".$_SESSION['username']."' and ip='".$ip."'  order by id"); 
$row=mysql_fetch_array($result);
if ($row['tr']==1){
echo "<script>top.location.href='index.php?action=logout';</script>"; 
exit;}


$resultff = mysql_query("select * from tj where username='".$_SESSION['username']."' and ip<>'".$ip."'  order by id");   
while($imageff = mysql_fetch_array($resultff)){
$exe=mysql_query("update tj set tr=1 where id='".$imageff['id']."' ");
}


}

?>
