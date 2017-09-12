<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}


function Get_wxwx_Color($rrr){   
$result23=mysql_query("Select id,m_number,sx From ka_sxnumber where  m_number LIKE '%$rrr%'  and id<=28 and id>=25  Order By ID LIMIT 1"); 
$ka_Color231=mysql_fetch_array($result23); 
return $ka_Color231['sx'];
}


?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script language="JavaScript" src="tip.js"></script>

<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>

<div align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr class="tbtitle">
      <td width="29%"><? require_once '1top.php';?></td>
      <td width="34%">&nbsp;</td>
      <td width="37%">&nbsp;</td>
    </tr>
    <tr >
      <td height="5" colspan="3"></td>
    </tr>
  </table>
  <table width="99%" border="1" cellpadding="5" cellspacing="1" bordercolor="f1f1f1">
    <tr>
      <td bordercolor="cccccc" bgcolor="#FDF4CA">第<?=$_GET['kithe']?>期开奖结算</td>
    </tr>
    <tr>
      <td bordercolor="cccccc"><table width="90%" border="0" cellspacing="0" cellpadding="5" align="center" class="about">
        <tr> 
          <td>
		  <? if ($_GET['kithe']!=""){
		  
$resultbb=mysql_query("select * from ka_kithe where nn=".$_GET['kithe']." order by id desc LIMIT 1"); 
$row=mysql_fetch_array($resultbb);
$kithe=$row['nn'];
$na=$row['na'];
$n1=$row['n1'];
$n2=$row['n2'];
$n3=$row['n3'];
$n4=$row['n4'];
$n5=$row['n5'];
$n6=$row['n6'];

//结算特码
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$na."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and class3<>'".$na."'  and class3<>'单' and class3<>'双' and class3<>'大' and class3<>'小' and class3<>'合单' and class3<>'合双'and class3<>'红波' and class3<>'蓝波' and class3<>'绿波'  ");
$result1cc = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$na."'");
$Rs5 = mysql_fetch_array($result1cc);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "特码结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//特码单双
if ($na%2==1){
$class3="单";
$class31="双";
}else{
$class31="单";
$class3="双";}

if ($na==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='特码' and (class3='单' or class3='双') ");
$result1dd = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and (class3='单' or class3='双')");
$Rs5 = mysql_fetch_array($result1dd);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and class3='".$class31."'");
$result1ee = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1ee);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "特码单双结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//特码大小
if ($na>=25){
$class3="大";
$class31="小";
}else{
$class31="大";
$class3="小";}

if ($na==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='特码' and (class3='大' or class3='小') ");
$result1ff = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and (class3='大' or class3='小')");
$Rs5 = mysql_fetch_array($result1ff);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and class3='".$class31."'");
$result1gg = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1gg);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "特码大小结算成功：<font color=ff6600>".$zwin."注</font><br>";}



//合单合双
if ((($na%10)+intval($na/10))%2==0){
$class3="合双";
$class31="合单";
}else{
$class31="合双";
$class3="合单";}

if ($na==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='特码' and (class3='合单' or class3='合双') ");
$result1vv = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and (class3='合单' or class3='合双')");
$Rs5 = mysql_fetch_array($result1vv);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}
if ($zwin!=0){
echo "特码合单合双结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//结算特码波色

$class3=ka_Color_s($na);

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and  (class3='红波' or class3='蓝波' or class3='绿波')");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "特码波色结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}



//结算正1特
for ($i=1;$i<=6;$i++){
if ($i==1){
$class2="正1特";
$tmtm=$n1;}
if ($i==2){
$class2="正2特";
$tmtm=$n2;}
if ($i==3){
$class2="正3特";
$tmtm=$n3;}
if ($i==4){
$class2="正4特";
$tmtm=$n4;}
if ($i==5){
$class2="正5特";
$tmtm=$n5;}
if ($i==6){
$class2="正6特";
$tmtm=$n6;}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$tmtm."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and bm<>0 and class3<>'".$tmtm."'  and class3<>'单' and class3<>'双' and class3<>'大' and class3<>'小' and class3<>'合单' and class3<>'合双'and class3<>'红波' and class3<>'蓝波' and class3<>'绿波'  ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$tmtm."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//特码单双
if ($tmtm%2==1){
$class3="单";
$class31="双";
}else{
$class31="单";
$class3="双";}

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and (class3='单' or class3='双') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and (class3='单' or class3='双')");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo $class2."单双结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//特码大小
if ($tmtm>=25){
$class3="大";
$class31="小";
}else{
$class31="大";
$class3="小";}

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and (class3='大' or class3='小') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and (class3='大' or class3='小')");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo $class2."大小结算成功：<font color=ff6600>".$zwin."注</font><br>";}



//合单合双
if ((($tmtm%10)+intval($tmtm/10))%2==0){
$class3="合双";
$class31="合单";
}else{
$class31="合双";
$class3="合单";}

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and (class3='合单' or class3='合双') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and (class3='合单' or class3='合双')");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}
if ($zwin!=0){
echo $class2."合单合双结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//结算特码波色

$class3=ka_Color_s($tmtm);

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and bm<>0 and  (class3='红波' or class3='蓝波' or class3='绿波') ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."波色结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}

}

//正码
$class2="正码";
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正码' and  (class3='".$n1."' or class3='".$n2."'  or class3='".$n3."' or class3='".$n4."'  or class3='".$n5."'  or class3='".$n6."') ");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正码' and   bm<>0 and class3<>'".$n1."' and class3<>'".$n2."' and class3<>'".$n3."' and class3<>'".$n4."'  and class3<>'".$n5."'  and class3<>'".$n6."' and class3<>'总单' and class3<>'总双' and class3<>'总大' and class3<>'总小' ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正码'  and (class3='".$n1."' or class3='".$n2."'  or class3='".$n3."' or class3='".$n4."'  or class3='".$n5."'  or class3='".$n6."')");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."结算成功：<font color=ff6600>".$zwin."注</font><br>";}



$sum_number=$n1+$n2+$n3+$n4+$n5+$n6+$na;


$class2="正码";

if ($sum_number%2==1){
$class3="总单";
$class31="总双";
}else{
$class31="总单";
$class3="总双";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正码'  and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正码'  and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正码'  and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."总单总双结算成功：<font color=ff6600>".$zwin."注</font><br>";}

$class2="正码";

if ($sum_number<=174){
$class3="总小";
$class31="总大";
}else{
$class31="总小";
$class3="总大";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正码'  and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正码'  and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正码'  and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."总单总双结算成功：<font color=ff6600>".$zwin."注</font><br>";}






///连码
$class2="三全中";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='连码' and class2='三全中' and Kithe='".$kithe."'");   
					  $t=0;
while($image = mysql_fetch_array($result)){
$number5=0;
	$class3=$image['class3'];
	$numberxz=explode(",",$class3);
	$ss1=count($numberxz);
	for ($i=0;$i<=$ss1;$i++){
	if ($numberxz[$i]==$n1){$number5++;}
	if ($numberxz[$i]==$n2){$number5++;}
	if ($numberxz[$i]==$n3){$number5++;}
	if ($numberxz[$i]==$n4){$number5++;}
	if ($numberxz[$i]==$n5){$number5++;}
	if ($numberxz[$i]==$n6){$number5++;}
	}
	if ($number5>2){
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "连码".$class2."结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}

$class2="三中二";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='连码' and class2='三中二' and Kithe='".$kithe."'");   
					  $t=0;
while($image = mysql_fetch_array($result)){
$number5=0;
	$class3=$image['class3'];
	$numberxz=explode(",",$class3);
	$ss1=count($numberxz);
	for ($i=0;$i<=$ss1;$i++){
	if ($numberxz[$i]==$n1){$number5++;}
	if ($numberxz[$i]==$n2){$number5++;}
	if ($numberxz[$i]==$n3){$number5++;}
	if ($numberxz[$i]==$n4){$number5++;}
	if ($numberxz[$i]==$n5){$number5++;}
	if ($numberxz[$i]==$n6){$number5++;}
	}
	if ($number5>2){
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}elseif ($number5==2){
	mysql_query("update ka_tan set bm=1,rate=rate2 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "连码".$class2."结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}



$class2="二中特";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='连码' and class2='二中特' and Kithe='".$kithe."'");   
					  $t=0;
while($image = mysql_fetch_array($result)){
$number5=0;
$number4=0;
	$class3=$image['class3'];
	$numberxz=explode(",",$class3);
	$ss1=count($numberxz);
	for ($i=0;$i<=$ss1;$i++){
	if ($numberxz[$i]==$n1){$number5++;}
	if ($numberxz[$i]==$n2){$number5++;}
	if ($numberxz[$i]==$n3){$number5++;}
	if ($numberxz[$i]==$n4){$number5++;}
	if ($numberxz[$i]==$n5){$number5++;}
	if ($numberxz[$i]==$n6){$number5++;}
	if ($numberxz[$i]==$na){$number4++;}
	}
	if ($number5>1){
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}elseif ($number4==1 and $number5==1){
	mysql_query("update ka_tan set bm=1,rate=rate2 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "连码".$class2."结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}
$class2="特串";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='连码' and class2='二中特' and Kithe='".$kithe."'");   
					  $t=0;
while($image = mysql_fetch_array($result)){
$number5=0;
$number4=0;
	$class3=$image['class3'];
	$numberxz=explode(",",$class3);
	$ss1=count($numberxz);
	for ($i=0;$i<=$ss1;$i++){
	if ($numberxz[$i]==$n1){$number5++;}
	if ($numberxz[$i]==$n2){$number5++;}
	if ($numberxz[$i]==$n3){$number5++;}
	if ($numberxz[$i]==$n4){$number5++;}
	if ($numberxz[$i]==$n5){$number5++;}
	if ($numberxz[$i]==$n6){$number5++;}
	if ($numberxz[$i]==$na){$number4++;}
	}
	if ($number4==1 and $number5==1){
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "连码".$class2."结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}




$class2="过关";
$zwin=0;

$result55= mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='过关' and Kithe='".$kithe."'");   

while($image = mysql_fetch_array($result55)){


$number5=0;
$number4=0;
	$class3=$image['class3'];
	$class2=$image['class2'];
	$class33=explode(",",$class3);
	$class22=explode(",",$class2);
	$ss1=count($class33);
	$ss2=count($class22);
	
	
	$k=0;
	$result=0;
	$result2=1;

	
	for ($i=0;$i<=$ss2;$i++){
	
	
	if ($class22[$i]=="正码1"){$tmtm=$n1;}
	if ($class22[$i]=="正码2"){$tmtm=$n2;}
	if ($class22[$i]=="正码3"){$tmtm=$n3;}
	if ($class22[$i]=="正码4"){$tmtm=$n4;}
	if ($class22[$i]=="正码5"){$tmtm=$n5;}
	if ($class22[$i]=="正码6"){$tmtm=$n6;}
	
	switch ($class33[$k])
  {
    case "大":
	
     if ($tmtm>=25){$result=1;}
      break;
	 case "小":
if ($tmtm<25){$result=1;}
  break;
 case "单":
if ($tmtm%2==1){$result=1;}
  break;
	case "双":
 if ($tmtm%2==0){$result=1;}
  break;
	case "红波":
if (ka_Color_s($tmtm)=="红波"){$result=1;}
  break;
case "蓝波":
if (ka_Color_s($tmtm)=="蓝波"){$result=1;}

  break;
case "绿波":
if (ka_Color_s($tmtm)=="绿波"){$result=1;}
  break;

    default:
	$result=0;
      break;
  } 
	if ($result==0){$result2=0;}
$k+=2;
}
	
	
	if ($result2==1){
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='过关' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='过关' and class2='".$class2."' and class3='".$class3."'");
	}
	
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='过关' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "过关结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}



$class2="半波";
$class3=ka_Color_s($na);
if ($class3=="红波"){
if ($na>=25){$class31="红大";}else{$class31="红小";}
if ($na%2==1){$class32="红单";}else{$class32="红双";}
}

if ($class3=="绿波"){
if ($na>=25){$class31="绿大";}else{$class31="绿小";}
if ($na%2==1){$class32="绿单";}else{$class32="绿双";}
}
if ($class3=="蓝波"){
if ($na>=25){$class31="蓝大";}else{$class31="蓝小";}
if ($na%2==1){$class32="蓝单";}else{$class32="蓝双";}
}

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='半波' and class2='".$class2."' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='半波' and class2='".$class2."' and (class3='".$class31."' or class3='".$class32."') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='半波' and class2='".$class2."' and (class3='".$class31."' or class3='".$class32."')");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//结算生肖
if ($na<10){$naa="0".$na;}else{$naa=$na;}
$sxsx=Get_sx_Color($naa);

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='生肖' and class2='生肖' and class3='".$sxsx."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='生肖' and class2='生肖' and bm<>0 and class3<>'".$sxsx."'   ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='生肖' and class2='生肖' and class3='".$sxsx."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "生肖结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//结算四肖
if ($na<10){$naa="0".$na;}else{$naa=$na;}
$sxsx=Get_sx_Color($naa);
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='生肖' and class2='四肖' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='生肖' and class2='四肖' and class3 LIKE '%$sxsx%' ");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='生肖' and class2='四肖' and class3 LIKE '%$sxsx%' ");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "四肖结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//结算五肖
if ($na<10){$naa="0".$na;}else{$naa=$na;}
$sxsx=Get_sx_Color($naa);
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='生肖' and class2='五肖' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='生肖' and class2='五肖' and class3 LIKE '%$sxsx%' ");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='生肖' and class2='五肖' and class3 LIKE '%$sxsx%' ");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "五肖结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//结算六肖
if ($na<10){$naa="0".$na;}else{$naa=$na;}
$sxsx=Get_sx_Color($naa);
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='生肖' and class2='六肖' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='生肖' and class2='六肖' and class3 LIKE '%$sxsx%' ");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='生肖' and class2='六肖' and class3 LIKE '%$sxsx%' ");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "六肖结算成功：<font color=ff6600>".$zwin."注</font><br>";}



//结算平肖

if ($na<10){$naa="0".$na;
$sxsx0=Get_sx_Color($naa);
}else{$naa=$na;
$sxsx0=Get_sx_Color($naa);}

if ($n1<10){$naa="0".$n1;
$sxsx1=Get_sx_Color($naa);
}else{$naa=$n1;
$sxsx1=Get_sx_Color($naa);}
if ($n2<10){$naa="0".$n2;
$sxsx2=Get_sx_Color($naa);
}else{$naa=$n2;
$sxsx2=Get_sx_Color($naa);}
if ($n1<10){$naa="0".$n3;
$sxsx3=Get_sx_Color($naa);
}else{$naa=$n3;
$sxsx3=Get_sx_Color($naa);}
if ($n4<10){$naa="0".$n4;
$sxsx4=Get_sx_Color($naa);
}else{$naa=$n4;
$sxsx4=Get_sx_Color($naa);}
if ($n5<10){$naa="0".$n5;
$sxsx5=Get_sx_Color($naa);
}else{$naa=$n5;
$sxsx5=Get_sx_Color($naa);}
if ($n6<10){$naa="0".$n6;
$sxsx6=Get_sx_Color($naa);
}else{$naa=$n6;
$sxsx6=Get_sx_Color($naa);}

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='生肖' and class2='平肖' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='生肖' and class2='平肖' and (class3='".$sxsx0."' or class3='".$sxsx1."' or class3='".$sxsx2."' or class3='".$sxsx3."' or class3='".$sxsx4."' or class3='".$sxsx5."' or class3='".$sxsx6."'  )");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='生肖' and class2='平肖' and (class3='".$sxsx0."' or class3='".$sxsx1."' or class3='".$sxsx2."' or class3='".$sxsx3."' or class3='".$sxsx4."' or class3='".$sxsx5."' or class3='".$sxsx6."')");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "平肖结算成功：<font color=ff6600>".$zwin."注</font><br>";}




//结算尾数
$wsws0=$na%10;
$wsws1=$n1%10;
$wsws2=$n2%10;
$wsws3=$n3%10;
$wsws4=$n4%10;
$wsws5=$n5%10;
$wsws6=$n6%10;


mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='尾数' and class2='尾数' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='尾数' and class2='尾数' and (class3='".$wsws0."' or class3='".$wsws1."' or class3='".$wsws2."' or class3='".$wsws3."' or class3='".$wsws4."' or class3='".$wsws5."' or class3='".$wsws6."'  )");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='尾数' and class2='尾数' and (class3='".$wsws0."' or class3='".$wsws1."' or class3='".$wsws2."' or class3='".$wsws3."' or class3='".$wsws4."' or class3='".$wsws5."' or class3='".$wsws6."') ");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "尾数结算成功：<font color=ff6600>".$zwin."注</font><br>";}



//结算五行
if ($na<10){$wxwx="0".$na;}else{$wxwx=$na;}

$wxwxwx=Get_wxwx_Color($wxwx);
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='五行' and class2='五行' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='五行' and class2='五行' and class3='".$wxwxwx."' ");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='五行' and class2='五行' and class3='".$wxwxwx."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "五行结算成功：<font color=ff6600>".$zwin."注</font><br>";}






}

echo "<font color=ff0000>第".$kithe."期结算成功</font>";

?></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
