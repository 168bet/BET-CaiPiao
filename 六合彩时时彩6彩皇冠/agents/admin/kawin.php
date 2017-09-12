<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}


function Get_wxwx_Color($rrr){   
$result23=mysql_query("Select id,m_number,sx From ka_sxnumber where  m_number LIKE '%$rrr%'  and id<=29 and id>=25  Order By id LIMIT 1"); 
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
$sxsx=$row['sx'];

//结算特码
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$na."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and class3<>'".$na."'  and class3<>'单' and class3<>'双' and class3<>'大' and class3<>'小' and class3<>'合单' and class3<>'合双'and class3<>'红波' and class3<>'蓝波' and class3<>'绿波'  ");
$result1cc = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$na."'");
$Rs5 = @mysql_fetch_array($result1cc);
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
$Rs5 = @mysql_fetch_array($result1dd);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and class3='".$class31."'");
$result1ee = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1ee);
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
$Rs5 = @mysql_fetch_array($result1ff);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and class3='".$class31."'");
$result1gg = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1gg);
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
$Rs5 = @mysql_fetch_array($result1vv);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "特码合单合双结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//结算特码波色

$class3=ka_Color_s($na);

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and  (class3='红波' or class3='蓝波' or class3='绿波')");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "特码波色结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}

//结算家禽/野兽
if($sxsx=="狗" || $sxsx=="猪" || $sxsx=="鸡" || $sxsx=="羊" || $sxsx=="马" || $sxsx=="牛"){
$psx="家禽";
$psx1="野兽";
}else{
$psx="野兽";
$psx1="家禽";
}



if ($na==49){


mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='特码'  and ( class3='".$psx."' or  class3='".$psx1."' ) ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码'  and ( class3='".$psx."' or  class3='".$psx1."' )");
$Rs5 = @mysql_fetch_array($result1);
}else{
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and  class3='".$psx1."' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码'  and class3='".$psx."' ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码'  and class3='".$psx."'");
$Rs5 = @mysql_fetch_array($result1);
}
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}


if ($zwin!=0){
echo "家禽/野兽结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//结算尾大/尾小
$wdwx0=$na%10;
if($wdwx0>4){
 $class3 = "尾大";
 $class31 = "尾小";
}else{
 $class31 = "尾大";
 $class3 = "尾小";
}

if ($na == 49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='特码'  and (class3='尾大' or class3='尾小')");
$result1ff = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and (class3='尾大' or class3='尾小')");
$Rs5 = @mysql_fetch_array($result1ff);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}else{

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and class3='".$class31."'");
$result1gg = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1gg);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "尾大尾小结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//大单小单/大双小双
if($na<=25){
 if ($na%2==1){
  $ddxd = "小单";
  $ddxd1 = "小双";
 }else{
  $ddxd1 = "小单";
  $ddxd = "小双";
  }
}else{
 if ($na%2==1){
  $ddxd = "大单";
  $ddxd1 = "大双";
 }else{
   $ddxd1 = "大单";
   $ddxd = "大双";
  }
 }
if ($na < 50) {
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='特码' and class3='".$ddxd."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='特码' and bm<>0 and class3='".$ddxd1."'");
$resulddxd = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='特码' and class3='".$ddxd."'");
$Rs5 = @mysql_fetch_array($resulddxd);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo "大小单双结算成功：<font color=ff6600>".$zwin."注</font><br>";}

}

//结算正特
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
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//正特单双
if ($tmtm%2==1){
$class3="单";
$class31="双";
}else{
$class31="单";
$class3="双";}

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and (class3='单' or class3='双') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and (class3='单' or class3='双')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo $class2."单双结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//正特大小
if ($tmtm>=25){
$class3="大";
$class31="小";
}else{
$class31="大";
$class3="小";}

//echo $class2."<br>";

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and (class3='大' or class3='小') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and (class3='大' or class3='小')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo $class2."大小结算成功：<font color=ff6600>".$zwin."注</font><br>";}



//正特合单合双
if ((($tmtm%10)+intval($tmtm/10))%2==0){
$class3="合双";
$class31="合单";
}else{
$class31="合双";
$class3="合单";}

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and (class3='合单' or class3='合双') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and (class3='合单' or class3='合双')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}
if ($zwin!=0){
echo $class2."合单合双结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//正特合大合小
if ((($tmtm%10)+intval($tmtm/10))>6){
$class3="合大";
$class31="合小";
}else{
$class31="合大";
$class3="合小";}

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and (class3='合大' or class3='合小') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and (class3='合大' or class3='合小')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}
if ($zwin!=0){
echo $class2."合大合小结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//结算正特波色

$class3=ka_Color_s($tmtm);

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and bm<>0 and  (class3='红波' or class3='蓝波' or class3='绿波') ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."波色结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}

}

//结算正码1-6
for ($i=1;$i<=6;$i++){
if ($i==1){
$class2="正码1";
$tmtm=$n1;}
if ($i==2){
$class2="正码2";
$tmtm=$n2;}
if ($i==3){
$class2="正码3";
$tmtm=$n3;}
if ($i==4){
$class2="正码4";
$tmtm=$n4;}
if ($i==5){
$class2="正码5";
$tmtm=$n5;}
if ($i==6){
$class2="正码6";
$tmtm=$n6;}

//单双
if ($tmtm%2==1){
$class3="单";
$class31="双";
}else{
$class31="单";
$class3="双";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and bm<>0 and class3='".$class31."'");

if ($tmtm==49){
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and (class3='单' or class3='双')");
}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo $class2."单双结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//大小
if ($tmtm>=25){
$class3="大";
$class31="小";
}else{
$class31="大";
$class3="小";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and bm<>0 and class3='".$class31."'");

if ($tmtm==49){
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and (class3='大' or class3='小')");
}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo $class2."大小结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//合大合小
if ((($tmtm%10)+intval($tmtm/10))>6){
$class3="合大";
$class31="合小";
}else{
$class31="合大";
$class3="合小";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and bm<>0 and class3='".$class31."'");

if ($tmtm==49){
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and (class3='合大' or class3='合小')");
}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo $class2."合大合小结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//合单合双
if ((($tmtm%10)+intval($tmtm/10))%2==1){
$class3="合单";
$class31="合双";
}else{
$class31="合单";
$class3="合双";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and bm<>0 and class3='".$class31."'");

if ($tmtm==49){
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and (class3='合单' or class3='合双')");
}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo $class2."合单合双结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//尾大尾小
if ($tmtm%10>4){
$class3="尾大";
$class31="尾小";
}else{
$class31="尾大";
$class3="尾小";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and bm<>0 and class3='".$class31."'");

if ($tmtm==49){
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and (class3='尾大' or class3='尾小')");
}

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo $class2."尾大尾小结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//波色
$class3=ka_Color_s($tmtm);

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and bm<>0 and  (class3='红波' or class3='蓝波' or class3='绿波') ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."波色结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}

}

//正码
$class2="正码";
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正码' and  (class3='".$n1."' or class3='".$n2."'  or class3='".$n3."' or class3='".$n4."'  or class3='".$n5."'  or class3='".$n6."') ");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正码' and   bm<>0 and class3<>'".$n1."' and class3<>'".$n2."' and class3<>'".$n3."' and class3<>'".$n4."'  and class3<>'".$n5."'  and class3<>'".$n6."' and class3<>'总单' and class3<>'总双' and class3<>'总大' and class3<>'总小' ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正码'  and (class3='".$n1."' or class3='".$n2."'  or class3='".$n3."' or class3='".$n4."'  or class3='".$n5."'  or class3='".$n6."')");
$Rs5 = @mysql_fetch_array($result1);
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

//echo "update ka_tan set bm=1 where kithe=".$kithe." and class1='正码'  and class3='".$class3."'"."<br>";
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正码'  and class3='".$class3."'");
//echo "update ka_tan set bm=0 where kithe=".$kithe." and class1='正码'  and bm<>0 and class3='".$class31."'"."<br>";
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正码'  and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正码'  and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
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
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."总大总小结算成功：<font color=ff6600>".$zwin."注</font><br>";}






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
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "连码".$class2."结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}

$class2="三中二";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='连码' and class2='三中二' and Kithe='".$kithe."'");   
					  $t=0;
while($image = @mysql_fetch_array($result)){
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
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "连码".$class2."结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}


$class2="二全中";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='连码' and class2='二全中' and Kithe='".$kithe."'");   
					  $t=0;
while($image = @mysql_fetch_array($result)){
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
	if ($number5>1){
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "连码".$class2."结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}

$class2="二中特";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='连码' and class2='二中特' and Kithe='".$kithe."'");   
					  $t=0;
while($image = @mysql_fetch_array($result)){
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
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "连码".$class2."结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}
$class2="特串";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='连码' and class2='特串' and Kithe='".$kithe."'");   
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


$class2="四中一";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='连码' and class2='四中一' and Kithe='".$kithe."'");   
					  $t=0;
while($image = mysql_fetch_array($result)){
$number5=0;
	$class3=$image['class3'];
	$numberxz=explode(",",$class3);
	$ss1=count($numberxz);
	for ($i=0;$i<$ss1;$i++){
	if ($numberxz[$i]==$n1){$number5++;}
	if ($numberxz[$i]==$n2){$number5++;}
	if ($numberxz[$i]==$n3){$number5++;}
	if ($numberxz[$i]==$n4){$number5++;}
	if ($numberxz[$i]==$n5){$number5++;}
	if ($numberxz[$i]==$n6){$number5++;}
	}
	if ($number5>0){
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='连码' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "连码".$class2."结算成功：<font color=ff6600>".$zwin."注</font><br><hr>";}

//过关
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

	
	for ($i=0;$i<$ss2-1;$i++){
	
	
	if ($class22[$i]=="正码1"){$tmtm=$n1;}
	if ($class22[$i]=="正码2"){$tmtm=$n2;}
	if ($class22[$i]=="正码3"){$tmtm=$n3;}
	if ($class22[$i]=="正码4"){$tmtm=$n4;}
	if ($class22[$i]=="正码5"){$tmtm=$n5;}
	if ($class22[$i]=="正码6"){$tmtm=$n6;}
	$result=0;
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



//结算半波
$class2="半波";
$class3=ka_Color_s($na);
if ($class3=="红波"){
if ($na>=25){$class31="红大";}else{$class31="红小";}
if ($na%2==1){$class32="红单";}else{$class32="红双";}
if (($na%10+intval($na/10))%2==1){$class33="红合单";}else{$class33="红合双";}

}

if ($class3=="绿波"){
if ($na>=25){$class31="绿大";}else{$class31="绿小";}
if ($na%2==1){$class32="绿单";}else{$class32="绿双";}
if (($na%10+intval($na/10))%2==1){$class33="绿合单";}else{$class33="绿合双";}
}
if ($class3=="蓝波"){
if ($na>=25){$class31="蓝大";}else{$class31="蓝小";}
if ($na%2==1){$class32="蓝单";}else{$class32="蓝双";}
if (($na%10+intval($na/10))%2==1){$class33="蓝合单";}else{$class33="蓝合双";}
}

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='半波' and class2='".$class2."' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='半波' and class2='".$class2."' and (class3='".$class33."' or class3='".$class31."' or class3='".$class32."') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='半波' and class2='".$class2."' and (class3='".$class33."' or class3='".$class31."' or class3='".$class32."')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//结算半半波
$class2="半半波";
$class3=ka_Color_s($na);
if ($class3=="红波"){
    if ($na>=25){
        if ($na%2==1) $class31="红大单";else $class31="红大双";
    }
    else {
        if ($na%2==1) $class31="红小单";else $class31="红小双";
    }
}
if ($class3=="绿波"){
    if ($na>=25){
        if ($na%2==1) $class31="绿大单";else $class31="绿大双";
    }
    else {
        if ($na%2==1) $class31="绿小单";else $class31="绿小双";
    }
}
if ($class3=="蓝波"){
    if ($na>=25){
        if ($na%2==1) $class31="蓝大单";else $class31="蓝大双";
    }
    else {
        if ($na%2==1) $class31="蓝小单";else $class31="蓝小双";
    }
}

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='半半波' and class2='".$class2."' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='半半波' and class2='".$class2."' and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='半半波' and class2='".$class2."' and class3='".$class31."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//结算生肖
if ($na<10){$naa="0".$na;}else{$naa=$na;}
$sxsx=Get_sx_Color($naa);

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='生肖' and class2='特肖' and class3='".$sxsx."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='生肖' and class2='特肖' and bm<>0 and class3<>'".$sxsx."'   ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='生肖' and class2='特肖' and class3='".$sxsx."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "特肖结算成功：<font color=ff6600>".$zwin."注</font><br>";}



//结算合肖
if ($na<10){$naa="0".$na;}else{$naa=$na;}
$sxsx=Get_sx_Color($naa);

if ($na==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='生肖' and (class2='二肖'  or class2='三肖'  or class2='四肖' or class2='五肖'  or class2='六肖' or class2='七肖'  or class2='八肖' or class2='九肖'  or class2='十肖' or class2='十一肖' ) ");
$result1dd = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='生肖' and (class2='二肖'  or class2='三肖'  or class2='四肖' or class2='五肖'  or class2='六肖'  or class2='七肖'  or class2='八肖' or class2='九肖'  or class2='十肖' or class2='十一肖' )");
$Rs5 = mysql_fetch_array($result1dd);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='生肖' and (class2='二肖'  or class2='三肖'  or class2='四肖' or class2='五肖'  or class2='六肖'  or class2='七肖'  or class2='八肖' or class2='九肖'  or class2='十肖' or class2='十一肖' ) and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='生肖' and (class2='二肖'  or class2='三肖'  or class2='四肖' or class2='五肖'  or class2='六肖'  or class2='七肖'  or class2='八肖' or class2='九肖'  or class2='十肖' or class2='十一肖' ) and class3 LIKE '%$sxsx%' ");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='生肖' and (class2='二肖'  or class2='三肖'  or class2='四肖' or class2='五肖'  or class2='六肖'  or class2='七肖'  or class2='八肖' or class2='九肖'  or class2='十肖' or class2='十一肖') and class3 LIKE '%$sxsx%' ");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "合肖结算成功：<font color=ff6600>".$zwin."注</font><br>";}



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
if ($n3<10){$naa="0".$n3;
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



mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='生肖' and class2='一肖' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='生肖' and class2='一肖' and (class3='".$sxsx0."' or class3='".$sxsx1."' or class3='".$sxsx2."' or class3='".$sxsx3."' or class3='".$sxsx4."' or class3='".$sxsx5."' or class3='".$sxsx6."'  )");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='生肖' and class2='一肖' and (class3='".$sxsx0."' or class3='".$sxsx1."' or class3='".$sxsx2."' or class3='".$sxsx3."' or class3='".$sxsx4."' or class3='".$sxsx5."' or class3='".$sxsx6."')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "一肖结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//结算正肖

//if ($na<10){$naa="0".$na;
//$sxsx0=Get_sx_Color($naa);
//}else{$naa=$na;
//$sxsx0=Get_sx_Color($naa);}

if ($n1<10){$naa="0".$n1;
$sxsx1=Get_sx_Color($naa);
}else{$naa=$n1;
$sxsx1=Get_sx_Color($naa);}
if ($n2<10){$naa="0".$n2;
$sxsx2=Get_sx_Color($naa);
}else{$naa=$n2;
$sxsx2=Get_sx_Color($naa);}
if ($n3<10){$naa="0".$n3;
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


//if ($sxsx0 == "鼠") {$sss["鼠"] = $sss["鼠"]+1;}
//if ($sxsx0 == "虎") {$sss["虎"] = $sss["虎"]+1;}
//if ($sxsx0 == "龙") {$sss["龙"] = $sss["龙"]+1;}
//if ($sxsx0 == "马") {$sss["马"] = $sss["马"]+1;}
//if ($sxsx0 == "猴") {$sss["猴"] = $sss["猴"]+1;}
//if ($sxsx0 == "狗") {$sss["狗"] = $sss["狗"]+1;}
//if ($sxsx0 == "牛") {$sss["牛"] = $sss["牛"]+1;}
//if ($sxsx0 == "兔") {$sss["兔"] = $sss["兔"]+1;}
//if ($sxsx0 == "蛇") {$sss["蛇"] = $sss["蛇"]+1;}
//if ($sxsx0 == "羊") {$sss["羊"] = $sss["羊"]+1;}
//if ($sxsx0 == "鸡") {$sss["鸡"] = $sss["鸡"]+1;}
//if ($sxsx0 == "猪") {$sss["猪"] = $sss["猪"]+1;}

if ($sxsx1 == "鼠") {$sss["鼠"] = $sss["鼠"]+1;}
if ($sxsx1 == "虎") {$sss["虎"] = $sss["虎"]+1;}
if ($sxsx1 == "龙") {$sss["龙"] = $sss["龙"]+1;}
if ($sxsx1 == "马") {$sss["马"] = $sss["马"]+1;}
if ($sxsx1 == "猴") {$sss["猴"] = $sss["猴"]+1;}
if ($sxsx1 == "狗") {$sss["狗"] = $sss["狗"]+1;}
if ($sxsx1 == "牛") {$sss["牛"] = $sss["牛"]+1;}
if ($sxsx1 == "兔") {$sss["兔"] = $sss["兔"]+1;}
if ($sxsx1 == "蛇") {$sss["蛇"] = $sss["蛇"]+1;}
if ($sxsx1 == "羊") {$sss["羊"] = $sss["羊"]+1;}
if ($sxsx1 == "鸡") {$sss["鸡"] = $sss["鸡"]+1;}
if ($sxsx1 == "猪") {$sss["猪"] = $sss["猪"]+1;}

if ($sxsx2 == "鼠") {$sss["鼠"] = $sss["鼠"]+1;}
if ($sxsx2 == "虎") {$sss["虎"] = $sss["虎"]+1;}
if ($sxsx2 == "龙") {$sss["龙"] = $sss["龙"]+1;}
if ($sxsx2 == "马") {$sss["马"] = $sss["马"]+1;}
if ($sxsx2 == "猴") {$sss["猴"] = $sss["猴"]+1;}
if ($sxsx2 == "狗") {$sss["狗"] = $sss["狗"]+1;}
if ($sxsx2 == "牛") {$sss["牛"] = $sss["牛"]+1;}
if ($sxsx2 == "兔") {$sss["兔"] = $sss["兔"]+1;}
if ($sxsx2 == "蛇") {$sss["蛇"] = $sss["蛇"]+1;}
if ($sxsx2 == "羊") {$sss["羊"] = $sss["羊"]+1;}
if ($sxsx2 == "鸡") {$sss["鸡"] = $sss["鸡"]+1;}
if ($sxsx2 == "猪") {$sss["猪"] = $sss["猪"]+1;}

if ($sxsx3 == "鼠") {$sss["鼠"] = $sss["鼠"]+1;}
if ($sxsx3 == "虎") {$sss["虎"] = $sss["虎"]+1;}
if ($sxsx3 == "龙") {$sss["龙"] = $sss["龙"]+1;}
if ($sxsx3 == "马") {$sss["马"] = $sss["马"]+1;}
if ($sxsx3 == "猴") {$sss["猴"] = $sss["猴"]+1;}
if ($sxsx3 == "狗") {$sss["狗"] = $sss["狗"]+1;}
if ($sxsx3 == "牛") {$sss["牛"] = $sss["牛"]+1;}
if ($sxsx3 == "兔") {$sss["兔"] = $sss["兔"]+1;}
if ($sxsx3 == "蛇") {$sss["蛇"] = $sss["蛇"]+1;}
if ($sxsx3 == "羊") {$sss["羊"] = $sss["羊"]+1;}
if ($sxsx3 == "鸡") {$sss["鸡"] = $sss["鸡"]+1;}
if ($sxsx3 == "猪") {$sss["猪"] = $sss["猪"]+1;}

if ($sxsx4 == "鼠") {$sss["鼠"] = $sss["鼠"]+1;}
if ($sxsx4 == "虎") {$sss["虎"] = $sss["虎"]+1;}
if ($sxsx4 == "龙") {$sss["龙"] = $sss["龙"]+1;}
if ($sxsx4 == "马") {$sss["马"] = $sss["马"]+1;}
if ($sxsx4 == "猴") {$sss["猴"] = $sss["猴"]+1;}
if ($sxsx4 == "狗") {$sss["狗"] = $sss["狗"]+1;}
if ($sxsx4 == "牛") {$sss["牛"] = $sss["牛"]+1;}
if ($sxsx4 == "兔") {$sss["兔"] = $sss["兔"]+1;}
if ($sxsx4 == "蛇") {$sss["蛇"] = $sss["蛇"]+1;}
if ($sxsx4 == "羊") {$sss["羊"] = $sss["羊"]+1;}
if ($sxsx4 == "鸡") {$sss["鸡"] = $sss["鸡"]+1;}
if ($sxsx4 == "猪") {$sss["猪"] = $sss["猪"]+1;}

if ($sxsx5 == "鼠") {$sss["鼠"] = $sss["鼠"]+1;}
if ($sxsx5 == "虎") {$sss["虎"] = $sss["虎"]+1;}
if ($sxsx5 == "龙") {$sss["龙"] = $sss["龙"]+1;}
if ($sxsx5 == "马") {$sss["马"] = $sss["马"]+1;}
if ($sxsx5 == "猴") {$sss["猴"] = $sss["猴"]+1;}
if ($sxsx5 == "狗") {$sss["狗"] = $sss["狗"]+1;}
if ($sxsx5 == "牛") {$sss["牛"] = $sss["牛"]+1;}
if ($sxsx5 == "兔") {$sss["兔"] = $sss["兔"]+1;}
if ($sxsx5 == "蛇") {$sss["蛇"] = $sss["蛇"]+1;}
if ($sxsx5 == "羊") {$sss["羊"] = $sss["羊"]+1;}
if ($sxsx5 == "鸡") {$sss["鸡"] = $sss["鸡"]+1;}
if ($sxsx5 == "猪") {$sss["猪"] = $sss["猪"]+1;}

if ($sxsx6 == "鼠") {$sss["鼠"] = $sss["鼠"]+1;}
if ($sxsx6 == "虎") {$sss["虎"] = $sss["虎"]+1;}
if ($sxsx6 == "龙") {$sss["龙"] = $sss["龙"]+1;}
if ($sxsx6 == "马") {$sss["马"] = $sss["马"]+1;}
if ($sxsx6 == "猴") {$sss["猴"] = $sss["猴"]+1;}
if ($sxsx6 == "狗") {$sss["狗"] = $sss["狗"]+1;}
if ($sxsx6 == "牛") {$sss["牛"] = $sss["牛"]+1;}
if ($sxsx6 == "兔") {$sss["兔"] = $sss["兔"]+1;}
if ($sxsx6 == "蛇") {$sss["蛇"] = $sss["蛇"]+1;}
if ($sxsx6 == "羊") {$sss["羊"] = $sss["羊"]+1;}
if ($sxsx6 == "鸡") {$sss["鸡"] = $sss["鸡"]+1;}
if ($sxsx6 == "猪") {$sss["猪"] = $sss["猪"]+1;}

mysql_query("update ka_tan set rate2=rate where kithe=".$kithe." and class1='正肖' and class2='正肖' and bm=0 ");

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正肖' and class2='正肖' and bm<>0 ");

if ($sss["鼠"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["鼠"]."-(".$sss["鼠"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='鼠' ");
if ($sss["虎"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["虎"]."-(".$sss["虎"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='虎' ");
if ($sss["龙"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["龙"]."-(".$sss["龙"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='龙' ");
if ($sss["马"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["马"]."-(".$sss["马"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='马' ");
if ($sss["猴"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["猴"]."-(".$sss["猴"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='猴' ");
if ($sss["狗"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["狗"]."-(".$sss["狗"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='狗' ");
if ($sss["牛"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["牛"]."-(".$sss["牛"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='牛' ");
if ($sss["兔"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["兔"]."-(".$sss["兔"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='兔' ");
if ($sss["蛇"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["蛇"]."-(".$sss["蛇"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='蛇' ");
if ($sss["羊"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["羊"]."-(".$sss["羊"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='羊' ");
if ($sss["鸡"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["鸡"]."-(".$sss["鸡"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='鸡' ");
if ($sss["猪"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["猪"]."-(".$sss["猪"]."-1) where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='猪' ");

echo $sss["牛"]."<br>";
if ($sss["牛"]==1 && ($n1=="49" || $n2=="49" || $n3=="49" || $n4=="49" || $n5=="49" || $n6=="49")) {

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正肖' and class2='正肖' and class3='牛'");

}

//if ($na=="49") {

//mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='正肖' and class2='正肖'");

//}

$www = "";
if ($sss["鼠"] > 0) $www .= " or class3='鼠' ";
if ($sss["虎"] > 0) $www .= " or class3='虎' ";
if ($sss["龙"] > 0) $www .= " or class3='龙' ";
if ($sss["马"] > 0) $www .= " or class3='马' ";
if ($sss["猴"] > 0) $www .= " or class3='猴' ";
if ($sss["狗"] > 0) $www .= " or class3='狗' ";
if ($sss["牛"] > 0) $www .= " or class3='牛' ";
if ($sss["兔"] > 0) $www .= " or class3='兔' ";
if ($sss["蛇"] > 0) $www .= " or class3='蛇' ";
if ($sss["羊"] > 0) $www .= " or class3='羊' ";
if ($sss["鸡"] > 0) $www .= " or class3='鸡' ";
if ($sss["猪"] > 0) $www .= " or class3='猪' ";

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正肖' and class2='正肖' and (1=1 ".$www.")");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo "正肖结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//结算头数
$wsws0=floor($na/10);
//$wsws1=floor($n1/10);
//$wsws2=floor($n2/10);
//$wsws3=floor($n3/10);
//$wsws4=floor($n4/10);
//$wsws5=floor($n5/10);
//$wsws6=floor($n6/10);


mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='头数' and class2='头数' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='头数' and class2='头数' and class3='".$wsws0."'");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='头数' and class2='头数' and class3='".$wsws0."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "特码头数结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//结算尾数
$wsws0=$na%10;
//$wsws1=$n1%10;
//$wsws2=$n2%10;
//$wsws3=$n3%10;
//$wsws4=$n4%10;
//$wsws5=$n5%10;
//$wsws6=$n6%10;


mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='尾数' and class2='尾数' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='尾数' and class2='尾数' and class3='".$wsws0."'");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='尾数' and class2='尾数' and class3='".$wsws0."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "特码尾数结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//结算正特尾数
$wsws0=$na%10;
$wsws1=$n1%10;
$wsws2=$n2%10;
$wsws3=$n3%10;
$wsws4=$n4%10;
$wsws5=$n5%10;
$wsws6=$n6%10;


mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='正特尾数' and class2='正特尾数' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='正特尾数' and class2='正特尾数' and (class3='".$wsws0."' or class3='".$wsws1."' or class3='".$wsws2."' or class3='".$wsws3."' or class3='".$wsws4."' or class3='".$wsws5."' or class3='".$wsws6."'  )");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='正特尾数' and class2='正特尾数' and (class3='".$wsws0."' or class3='".$wsws1."' or class3='".$wsws2."' or class3='".$wsws3."' or class3='".$wsws4."' or class3='".$wsws5."' or class3='".$wsws6."') ");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "正特尾数结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//结算七色波
$wsws0=ka_Color_s($na);
$wsws1=ka_Color_s($n1);
$wsws2=ka_Color_s($n2);
$wsws3=ka_Color_s($n3);
$wsws4=ka_Color_s($n4);
$wsws5=ka_Color_s($n5);
$wsws6=ka_Color_s($n6);

$hongbo_na = 0;
$lvbo_na = 0;
$lanbo_na = 0;
$hongbo = 0;
$lvbo = 0;
$lanbo = 0;
$hongbo_z = 0;
$lvbo_z = 0;
$lanbo_z = 0;
if ($wsws0 == "红波") $hongbo_na = $hongbo_na + 1.5; else if ($wsws0 == "绿波") $lvbo_na = $lvbo_na + 1.5; else if ($wsws0 == "蓝波") $lanbo_na = $lanbo_na + 1.5;

if ($wsws1 == "红波") $hongbo = $hongbo + 1; else if ($wsws1 == "绿波") $lvbo = $lvbo + 1; else if ($wsws1 == "蓝波") $lanbo = $lanbo + 1;
if ($wsws2 == "红波") $hongbo = $hongbo + 1; else if ($wsws2 == "绿波") $lvbo = $lvbo + 1; else if ($wsws2 == "蓝波") $lanbo = $lanbo + 1;
if ($wsws3 == "红波") $hongbo = $hongbo + 1; else if ($wsws3 == "绿波") $lvbo = $lvbo + 1; else if ($wsws3 == "蓝波") $lanbo = $lanbo + 1;
if ($wsws4 == "红波") $hongbo = $hongbo + 1; else if ($wsws4 == "绿波") $lvbo = $lvbo + 1; else if ($wsws4 == "蓝波") $lanbo = $lanbo + 1;
if ($wsws5 == "红波") $hongbo = $hongbo + 1; else if ($wsws5 == "绿波") $lvbo = $lvbo + 1; else if ($wsws5 == "蓝波") $lanbo = $lanbo + 1;
if ($wsws6 == "红波") $hongbo = $hongbo + 1; else if ($wsws6 == "绿波") $lvbo = $lvbo + 1; else if ($wsws6 == "蓝波") $lanbo = $lanbo + 1;

$hongbo_z = $hongbo_na + $hongbo;
$lvbo_z = $lvbo_na + $lvbo;
$lanbo_z = $lanbo_na + $lanbo;

if ($hongbo_z > $lvbo_z && $hongbo_z > $lanbo_z) $qsbgo = "红波";
if ($lvbo_z > $hongbo_z && $lvbo_z > $lanbo_z) $qsbgo = "绿波";
if ($lanbo_z > $hongbo_z && $lanbo_z > $lvbo_z) $qsbgo = "蓝波";

if ($hongbo_z==3 && $lvbo_z==3 && $wsws0 == "蓝波") $qsbgo = "合局";
if ($lvbo_z==3 && $lanbo_z==3 && $wsws0 == "红波") $qsbgo = "合局";
if ($hongbo_z==3 && $lanbo_z==3 && $wsws0 == "绿波") $qsbgo = "合局";

if ($qsbgo=="合局") {
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='七色波' and class2='七色波' and bm<>0 ");

mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='七色波' and class2='七色波' and class3<>'合局'");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='七色波' and class2='七色波' and class3='合局'");

$result1dd = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='七色波' and class2='七色波' and class3='合局'");
$Rs5 = @mysql_fetch_array($result1dd);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='七色波' and class2='七色波' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='七色波' and class2='七色波' and class3='".$qsbgo."' ");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='七色波' and class2='七色波' and class3 ='".$qsbgo."' ");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "七色波结算成功：<font color=ff6600>".$zwin."注</font><br>";}



//结算五行
if ($na<10){$wxwx="0".$na;}else{$wxwx=$na;}

$wxwxwx=Get_wxwx_Color($wxwx);
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='五行' and class2='五行' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='五行' and class2='五行' and class3='".$wxwxwx."' ");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='五行' and class2='五行' and class3='".$wxwxwx."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "五行结算成功：<font color=ff6600>".$zwin."注</font><br>";}

//全不中
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='全不中'");
$result1kk=mysql_query("select class3 from ka_tan where kithe=".$kithe." and class1='全不中'");
explode(",",$class3);
while($image = mysql_fetch_array($result1kk)){
$class3=$image[0];
$numberxz=explode(",",$class3);
	$ss1=count($numberxz);
	for ($i=0;$i<$ss1;$i++){
	  if ($numberxz[$i]==$na||$numberxz[$i]==$n1||$numberxz[$i]==$n2||$numberxz[$i]==$n3||$numberxz[$i]==$n4||$numberxz[$i]==$n5||$numberxz[$i]==$n6){mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='全不中' and class3 like '%".$class3."%'");}
	}
}

//echo $na;
$zxbz=mysql_query("select * from ka_tan where kithe=".$kithe." and class1='全不中' and bm=1");
$re = @mysql_num_rows($zxbz);
if ($Rs5!=""){$zwin=$re;}else{$zwin=0;}
if ($zwin!=0){
echo "全不中结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//生肖连	
if (intval($n1)<10) $n1="0".$n1;
if (intval($n2)<10) $n2="0".$n2;
if (intval($n3)<10) $n3="0".$n3;
if (intval($n4)<10) $n4="0".$n4;
if (intval($n5)<10) $n5="0".$n5;
if (intval($n6)<10) $n6="0".$n6;
if (intval($na)<10) $na="0".$na;
 			
$lx_sx1=Get_sx_Color($n1);
$lx_sx2=Get_sx_Color($n2);
$lx_sx3=Get_sx_Color($n3);
$lx_sx4=Get_sx_Color($n4);
$lx_sx5=Get_sx_Color($n5);
$lx_sx6=Get_sx_Color($n6);
$lx_sx7=Get_sx_Color($na);
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='生肖连'");
//echo $lx_sx1."<br>";
//echo $lx_sx2."<br>";
//echo $lx_sx3."<br>";
//echo $lx_sx4."<br>";
//echo $lx_sx5."<br>";
//echo $lx_sx6."<br>";
//echo $lx_sx7."<br>";

$result = mysql_query("Select id,class2,class3  from ka_tan where kithe=".$kithe." and class1='生肖连'");   
					  //$t=0;
while($image = mysql_fetch_array($result)){
$Rs_id=$image['id'];
$class2=$image['class2'];
$class3=$image['class3'];
$numberxz=explode(",",$class3);
$cont=0;
	$ss1=count($numberxz);
	for ($i=0;$i<$ss1;$i++){
	    if($lx_sx1==$numberxz[$i]||$lx_sx2==$numberxz[$i]||$lx_sx3==$numberxz[$i]||$lx_sx4==$numberxz[$i]||$lx_sx5==$numberxz[$i]||$lx_sx6==$numberxz[$i]||$lx_sx7==$numberxz[$i]){$cont+=1;continue;}
}		
    if($cont==$ss1 && ( $class2=="二肖连中" || $class2=="三肖连中" || $class2=="四肖连中"  || $class2=="五肖连中" )){mysql_query("update ka_tan set bm=1 where id=".$Rs_id);}
    if($cont==0 && ( $class2=="二肖连不中" || $class2=="三肖连不中" || $class2=="四肖连不中" )){mysql_query("update ka_tan set bm=1 where id=".$Rs_id);}



}

//mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='生肖连' and (class3 like '%".$lx_sx1."%' and class3 like '%".$lx_sx2."%' and  class3 like '%".$lx_sx3."%' and  class3 like '%".$lx_sx4."%' and  class3 like '%".$lx_sx5."%' and class3 like '%".$lx_sx6."%' and class3 like '%".$lx_sx7."%')");


$lxbz=mysql_query("select * from ka_tan where kithe=".$kithe." and class1='生肖连' and bm=1");
$re = @mysql_num_rows($lxbz);
if ($Rs5!=""){$zwin=$re;}else{$zwin=0;}
if ($zwin!=0){
echo "生肖连结算成功：<font color=ff6600>".$zwin."注</font><br>";}




//尾数连	
//if (intval($n1)<10) $n1="0".$n1;
//if (intval($n2)<10) $n2="0".$n2;
//if (intval($n3)<10) $n3="0".$n3;
//if (intval($n4)<10) $n4="0".$n4;
//if (intval($n5)<10) $n5="0".$n5;
//if (intval($n6)<10) $n6="0".$n6;
//if (intval($na)<10) $na="0".$na;
 			
//$lx_sx1=Get_sx_Color($n1);
//$lx_sx2=Get_sx_Color($n2);
//$lx_sx3=Get_sx_Color($n3);
//$lx_sx4=Get_sx_Color($n4);
//$lx_sx5=Get_sx_Color($n5);
//$lx_sx6=Get_sx_Color($n6);
//$lx_sx7=Get_sx_Color($na);
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='尾数连'");
//echo $lx_sx1."<br>";
//echo $lx_sx2."<br>";
//echo $lx_sx3."<br>";
//echo $lx_sx4."<br>";
//echo $lx_sx5."<br>";
//echo $lx_sx6."<br>";
//echo $lx_sx7."<br>";

$result = mysql_query("Select id,class2,class3  from ka_tan where kithe=".$kithe." and class1='尾数连'");   
					  //$t=0;
while($image = mysql_fetch_array($result)){
$Rs_id=$image['id'];
$class2=$image['class2'];
$class3=$image['class3'];
$numberxz=explode(",",$class3);
$cont=0;
	$ss1=count($numberxz);
	for ($i=0;$i<$ss1;$i++){
	    if(substr($n1,-1)==$numberxz[$i]||substr($n2,-1)==$numberxz[$i]||substr($n3,-1)==$numberxz[$i]||substr($n4,-1)==$numberxz[$i]||substr($n5,-1)==$numberxz[$i]||substr($n6,-1)==$numberxz[$i]||substr($na,-1)==$numberxz[$i]){$cont+=1;continue;}
}		
    if($cont==$ss1 && ( $class2=="二尾连中" || $class2=="三尾连中" || $class2=="四尾连中" )){mysql_query("update ka_tan set bm=1 where id=".$Rs_id);}
    if($cont==0 && ( $class2=="二尾连不中" || $class2=="三尾连不中" || $class2=="四尾连不中" )){mysql_query("update ka_tan set bm=1 where id=".$Rs_id);}



}



$lxbz=mysql_query("select * from ka_tan where kithe=".$kithe." and class1='尾数连' and bm=1");
$re = @mysql_num_rows($lxbz);
if ($Rs5!=""){$zwin=$re;}else{$zwin=0;}
if ($zwin!=0){
echo "尾数连结算成功：<font color=ff6600>".$zwin."注</font><br>";}


//结束
}
echo "<font color=ff0000>第".$kithe."期结算成功</font>";
$result = mysql_query("Select *  from ka_tan where kithe='".$kithe."' and checked=0");  
while($rs = mysql_fetch_array($result)){
	/*if($rs['bm']==1){		//会员中奖
		$z_user=($rs['sum_m']*$rs['rate']+$rs['sum_m']*abs($rs['user_ds'])/100)+$rs['sum_m'];
	}else{					//未中奖退水
		$z_user=$rs['sum_m']*abs($rs['user_ds'])/100;
	}*/
	if($rs['bm']==1){		//会员中奖
		$z_user=($rs['sum_m']*$rs['rate']-$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100)+$rs['sum_m'];
		//中奖退水
		$z_user+=$rs['sum_m']*abs($rs['user_ds'])/100;
				 //$rs['sum_m']*$rs['rate']-$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100
	}else{					//未中奖退水
		$z_user=$rs['sum_m']*abs($rs['user_ds'])/100;
		   //echo $rs['sum_m']*abs($rs['user_ds'])/100
	}
	//echo $rs['sum_m']."-".$rs['user_ds']."-".$rs['rate']."-".$z_user."<br>";
	mysql_query("update ka_tan set checked=1 where id='".$rs['id']."'");
	mysql_query("update web_member_data set Credit=Credit+".$z_user.",Money=Money+".$z_user." where UserName='".$rs['username']."'");
}

mysql_query("update ka_kithe set score=1 where nn='".$_GET['kithe']."'");

?></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
