<?
if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}
if($_GET['style']=="����3D"){
$result = mysql_query("select * from 3dka_kithe where n1<>0  order by id Desc LIMIT 1"); 

$image = mysql_fetch_array($result);

echo "<font color=ff0000><b>��".$image['nn']. "�ڿ������</b></font>@@@<img src=images/num".$image['n1'].".gif>@@@<img src=images/num".$image['n2'].".gif>@@@<img src=images/num".$image['n3'].".gif>@@@ @@@ @@@ @@@###";
}else if($_GET['style']=="���PL3"){
$result = mysql_query("select * from pl3ka_kithe where n1<>0  order by id Desc LIMIT 1"); 

$image = mysql_fetch_array($result);

echo "<font color=ff0000><b>��".$image['nn']. "�ڿ������</b></font>@@@<img src=images/num".$image['n1'].".gif>@@@<img src=images/num".$image['n2'].".gif>@@@<img src=images/num".$image['n3'].".gif>@@@ @@@ @@@ @@@###";
}else{

$result = mysql_query("select * from ka_kithe where n1<>0  order by id Desc LIMIT 1"); 

$image = mysql_fetch_array($result);

echo "<font color=ff0000><b>��".$image['nn']. "�ڿ������</b></font>@@@<img src=images/num".$image['n1'].".gif>@@@<img src=images/num".$image['n2'].".gif>@@@<img src=images/num".$image['n3'].".gif>@@@<img src=images/num".$image['n4'].".gif>@@@<img src=images/num".$image['n5'].".gif>@@@<img src=images/num".$image['n6'].".gif>@@@<img src=images/num".$image['na'].".gif>###";
}




?>
