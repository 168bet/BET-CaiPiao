<?
if(!defined('PHPYOU_VER')) {
	exit('�Ƿ�����');
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
      <td bordercolor="cccccc" bgcolor="#FDF4CA">��<?=$_GET['kithe']?>�ڿ�������</td>
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

//��������
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class3='".$na."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and bm<>0 and class3<>'".$na."'  and class3<>'��' and class3<>'˫' and class3<>'��' and class3<>'С' and class3<>'�ϵ�' and class3<>'��˫'and class3<>'�첨' and class3<>'����' and class3<>'�̲�'  ");
$result1cc = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class3='".$na."'");
$Rs5 = @mysql_fetch_array($result1cc);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "�������ɹ���<font color=ff6600>".$zwin."ע</font><br>";}

//���뵥˫
if ($na%2==1){
$class3="��";
$class31="˫";
}else{
$class31="��";
$class3="˫";}

if ($na==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='����' and (class3='��' or class3='˫') ");
$result1dd = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and (class3='��' or class3='˫')");
$Rs5 = @mysql_fetch_array($result1dd);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and bm<>0 and class3='".$class31."'");
$result1ee = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1ee);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "���뵥˫����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//�����С
if ($na>=25){
$class3="��";
$class31="С";
}else{
$class31="��";
$class3="С";}

if ($na==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='����' and (class3='��' or class3='С') ");
$result1ff = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and (class3='��' or class3='С')");
$Rs5 = @mysql_fetch_array($result1ff);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and bm<>0 and class3='".$class31."'");
$result1gg = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1gg);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "�����С����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}



//�ϵ���˫
if ((($na%10)+intval($na/10))%2==0){
$class3="��˫";
$class31="�ϵ�";
}else{
$class31="��˫";
$class3="�ϵ�";}

if ($na==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='����' and (class3='�ϵ�' or class3='��˫') ");
$result1vv = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and (class3='�ϵ�' or class3='��˫')");
$Rs5 = @mysql_fetch_array($result1vv);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "����ϵ���˫����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}

//�������벨ɫ

$class3=ka_Color_s($na);

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and bm<>0 and  (class3='�첨' or class3='����' or class3='�̲�')");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class3='".$class3."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "���벨ɫ����ɹ���<font color=ff6600>".$zwin."ע</font><br><hr>";}

//�������/Ұ��
if($sxsx=="��" || $sxsx=="��" || $sxsx=="��" || $sxsx=="��" || $sxsx=="��" || $sxsx=="ţ"){
$psx="����";
$psx1="Ұ��";
}else{
$psx="Ұ��";
$psx1="����";
}



if ($na==49){


mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='����'  and ( class3='".$psx."' or  class3='".$psx1."' ) ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����'  and ( class3='".$psx."' or  class3='".$psx1."' )");
$Rs5 = @mysql_fetch_array($result1);
}else{
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and  class3='".$psx1."' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����'  and class3='".$psx."' ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����'  and class3='".$psx."'");
$Rs5 = @mysql_fetch_array($result1);
}
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}


if ($zwin!=0){
echo "����/Ұ�޽���ɹ���<font color=ff6600>".$zwin."ע</font><br>";}

//����β��/βС
$wdwx0=$na%10;
if($wdwx0>4){
 $class3 = "β��";
 $class31 = "βС";
}else{
 $class31 = "β��";
 $class3 = "βС";
}

if ($na == 49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='����'  and (class3='β��' or class3='βС')");
$result1ff = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and (class3='β��' or class3='βС')");
$Rs5 = @mysql_fetch_array($result1ff);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}else{

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and bm<>0 and class3='".$class31."'");
$result1gg = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1gg);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "β��βС����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//��С��/��˫С˫
if($na<=25){
 if ($na%2==1){
  $ddxd = "С��";
  $ddxd1 = "С˫";
 }else{
  $ddxd1 = "С��";
  $ddxd = "С˫";
  }
}else{
 if ($na%2==1){
  $ddxd = "��";
  $ddxd1 = "��˫";
 }else{
   $ddxd1 = "��";
   $ddxd = "��˫";
  }
 }
if ($na < 50) {
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class3='".$ddxd."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and bm<>0 and class3='".$ddxd1."'");
$resulddxd = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class3='".$ddxd."'");
$Rs5 = @mysql_fetch_array($resulddxd);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo "��С��˫����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}

}

//��������
for ($i=1;$i<=6;$i++){
if ($i==1){
$class2="��1��";
$tmtm=$n1;}
if ($i==2){
$class2="��2��";
$tmtm=$n2;}
if ($i==3){
$class2="��3��";
$tmtm=$n3;}
if ($i==4){
$class2="��4��";
$tmtm=$n4;}
if ($i==5){
$class2="��5��";
$tmtm=$n5;}
if ($i==6){
$class2="��6��";
$tmtm=$n6;}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$tmtm."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and bm<>0 and class3<>'".$tmtm."'  and class3<>'��' and class3<>'˫' and class3<>'��' and class3<>'С' and class3<>'�ϵ�' and class3<>'��˫'and class3<>'�첨' and class3<>'����' and class3<>'�̲�'  ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$tmtm."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}

//���ص�˫
if ($tmtm%2==1){
$class3="��";
$class31="˫";
}else{
$class31="��";
$class3="˫";}

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='����' and class2='".$class2."' and (class3='��' or class3='˫') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and (class3='��' or class3='˫')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo $class2."��˫����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//���ش�С
if ($tmtm>=25){
$class3="��";
$class31="С";
}else{
$class31="��";
$class3="С";}

//echo $class2."<br>";

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='����' and class2='".$class2."' and (class3='��' or class3='С') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and (class3='��' or class3='С')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo $class2."��С����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}



//���غϵ���˫
if ((($tmtm%10)+intval($tmtm/10))%2==0){
$class3="��˫";
$class31="�ϵ�";
}else{
$class31="��˫";
$class3="�ϵ�";}

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='����' and class2='".$class2."' and (class3='�ϵ�' or class3='��˫') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and (class3='�ϵ�' or class3='��˫')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}
if ($zwin!=0){
echo $class2."�ϵ���˫����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//���غϴ��С
if ((($tmtm%10)+intval($tmtm/10))>6){
$class3="�ϴ�";
$class31="��С";
}else{
$class31="�ϴ�";
$class3="��С";}

if ($tmtm==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='����' and class2='".$class2."' and (class3='�ϴ�' or class3='��С') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and (class3='�ϴ�' or class3='��С')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}
if ($zwin!=0){
echo $class2."�ϴ��С����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}

//�������ز�ɫ

$class3=ka_Color_s($tmtm);

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and bm<>0 and  (class3='�첨' or class3='����' or class3='�̲�') ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."��ɫ����ɹ���<font color=ff6600>".$zwin."ע</font><br><hr>";}

}

//��������1-6
for ($i=1;$i<=6;$i++){
if ($i==1){
$class2="����1";
$tmtm=$n1;}
if ($i==2){
$class2="����2";
$tmtm=$n2;}
if ($i==3){
$class2="����3";
$tmtm=$n3;}
if ($i==4){
$class2="����4";
$tmtm=$n4;}
if ($i==5){
$class2="����5";
$tmtm=$n5;}
if ($i==6){
$class2="����6";
$tmtm=$n6;}

//��˫
if ($tmtm%2==1){
$class3="��";
$class31="˫";
}else{
$class31="��";
$class3="˫";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and bm<>0 and class3='".$class31."'");

if ($tmtm==49){
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and (class3='��' or class3='˫')");
}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo $class2."��˫����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//��С
if ($tmtm>=25){
$class3="��";
$class31="С";
}else{
$class31="��";
$class3="С";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and bm<>0 and class3='".$class31."'");

if ($tmtm==49){
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and (class3='��' or class3='С')");
}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo $class2."��С����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//�ϴ��С
if ((($tmtm%10)+intval($tmtm/10))>6){
$class3="�ϴ�";
$class31="��С";
}else{
$class31="�ϴ�";
$class3="��С";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and bm<>0 and class3='".$class31."'");

if ($tmtm==49){
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and (class3='�ϴ�' or class3='��С')");
}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo $class2."�ϴ��С����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}

//�ϵ���˫
if ((($tmtm%10)+intval($tmtm/10))%2==1){
$class3="�ϵ�";
$class31="��˫";
}else{
$class31="�ϵ�";
$class3="��˫";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and bm<>0 and class3='".$class31."'");

if ($tmtm==49){
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and (class3='�ϵ�' or class3='��˫')");
}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo $class2."�ϵ���˫����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//β��βС
if ($tmtm%10>4){
$class3="β��";
$class31="βС";
}else{
$class31="β��";
$class3="βС";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and bm<>0 and class3='".$class31."'");

if ($tmtm==49){
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and (class3='β��' or class3='βС')");
}

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo $class2."β��βС����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//��ɫ
$class3=ka_Color_s($tmtm);

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and bm<>0 and  (class3='�첨' or class3='����' or class3='�̲�') ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��1-6' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."��ɫ����ɹ���<font color=ff6600>".$zwin."ע</font><br><hr>";}

}

//����
$class2="����";
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and  (class3='".$n1."' or class3='".$n2."'  or class3='".$n3."' or class3='".$n4."'  or class3='".$n5."'  or class3='".$n6."') ");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and   bm<>0 and class3<>'".$n1."' and class3<>'".$n2."' and class3<>'".$n3."' and class3<>'".$n4."'  and class3<>'".$n5."'  and class3<>'".$n6."' and class3<>'�ܵ�' and class3<>'��˫' and class3<>'�ܴ�' and class3<>'��С' ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����'  and (class3='".$n1."' or class3='".$n2."'  or class3='".$n3."' or class3='".$n4."'  or class3='".$n5."'  or class3='".$n6."')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}



$sum_number=$n1+$n2+$n3+$n4+$n5+$n6+$na;


$class2="����";

if ($sum_number%2==1){
$class3="�ܵ�";
$class31="��˫";
}else{
$class31="�ܵ�";
$class3="��˫";}

//echo "update ka_tan set bm=1 where kithe=".$kithe." and class1='����'  and class3='".$class3."'"."<br>";
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����'  and class3='".$class3."'");
//echo "update ka_tan set bm=0 where kithe=".$kithe." and class1='����'  and bm<>0 and class3='".$class31."'"."<br>";
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����'  and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����'  and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."�ܵ���˫����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}

$class2="����";

if ($sum_number<=174){
$class3="��С";
$class31="�ܴ�";
}else{
$class31="��С";
$class3="�ܴ�";}

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����'  and class3='".$class3."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����'  and bm<>0 and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����'  and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."�ܴ���С����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}






///����
$class2="��ȫ��";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='����' and class2='��ȫ��' and Kithe='".$kithe."'");   
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
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "����".$class2."����ɹ���<font color=ff6600>".$zwin."ע</font><br><hr>";}

$class2="���ж�";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='����' and class2='���ж�' and Kithe='".$kithe."'");   
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
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}elseif ($number5==2){
	mysql_query("update ka_tan set bm=1,rate=rate2 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "����".$class2."����ɹ���<font color=ff6600>".$zwin."ע</font><br><hr>";}


$class2="��ȫ��";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='����' and class2='��ȫ��' and Kithe='".$kithe."'");   
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
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "����".$class2."����ɹ���<font color=ff6600>".$zwin."ע</font><br><hr>";}

$class2="������";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='����' and class2='������' and Kithe='".$kithe."'");   
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
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}elseif ($number4==1 and $number5==1){
	mysql_query("update ka_tan set bm=1,rate=rate2 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "����".$class2."����ɹ���<font color=ff6600>".$zwin."ע</font><br><hr>";}
$class2="�ش�";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='����' and class2='�ش�' and Kithe='".$kithe."'");   
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
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "����".$class2."����ɹ���<font color=ff6600>".$zwin."ע</font><br><hr>";}


$class2="����һ";
$zwin=0;
$result = mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='����' and class2='����һ' and Kithe='".$kithe."'");   
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
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "����".$class2."����ɹ���<font color=ff6600>".$zwin."ע</font><br><hr>";}

//����
$class2="����";
$zwin=0;

$result55= mysql_query("Select distinct(class3),class1,class2 from ka_tan where class1='����' and Kithe='".$kithe."'");   

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
	
	
	if ($class22[$i]=="����1"){$tmtm=$n1;}
	if ($class22[$i]=="����2"){$tmtm=$n2;}
	if ($class22[$i]=="����3"){$tmtm=$n3;}
	if ($class22[$i]=="����4"){$tmtm=$n4;}
	if ($class22[$i]=="����5"){$tmtm=$n5;}
	if ($class22[$i]=="����6"){$tmtm=$n6;}
	$result=0;
	switch ($class33[$k])
  {
    case "��":
	
     if ($tmtm>=25){$result=1;}
      break;
	 case "С":
if ($tmtm<25){$result=1;}
  break;
 case "��":
if ($tmtm%2==1){$result=1;}
  break;
	case "˫":
 if ($tmtm%2==0){$result=1;}
  break;
	case "�첨":
if (ka_Color_s($tmtm)=="�첨"){$result=1;}
  break;
case "����":
if (ka_Color_s($tmtm)=="����"){$result=1;}

  break;
case "�̲�":
if (ka_Color_s($tmtm)=="�̲�"){$result=1;}
  break;

    default:
	$result=0;
      break;
  } 
	if ($result==0){$result2=0;}
$k+=2;
}
	
	
	if ($result2==1){
	mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}else{
	mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
	}
	
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='".$class2."' and class3='".$class3."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5!=""){$zwin+=$Rs5['re'];}
	

}
if ($zwin!=0){
echo "���ؽ���ɹ���<font color=ff6600>".$zwin."ע</font><br><hr>";}



//����벨
$class2="�벨";
$class3=ka_Color_s($na);
if ($class3=="�첨"){
if ($na>=25){$class31="���";}else{$class31="��С";}
if ($na%2==1){$class32="�쵥";}else{$class32="��˫";}
if (($na%10+intval($na/10))%2==1){$class33="��ϵ�";}else{$class33="���˫";}

}

if ($class3=="�̲�"){
if ($na>=25){$class31="�̴�";}else{$class31="��С";}
if ($na%2==1){$class32="�̵�";}else{$class32="��˫";}
if (($na%10+intval($na/10))%2==1){$class33="�̺ϵ�";}else{$class33="�̺�˫";}
}
if ($class3=="����"){
if ($na>=25){$class31="����";}else{$class31="��С";}
if ($na%2==1){$class32="����";}else{$class32="��˫";}
if (($na%10+intval($na/10))%2==1){$class33="���ϵ�";}else{$class33="����˫";}
}

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='�벨' and class2='".$class2."' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='�벨' and class2='".$class2."' and (class3='".$class33."' or class3='".$class31."' or class3='".$class32."') ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='�벨' and class2='".$class2."' and (class3='".$class33."' or class3='".$class31."' or class3='".$class32."')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//�����벨
$class2="��벨";
$class3=ka_Color_s($na);
if ($class3=="�첨"){
    if ($na>=25){
        if ($na%2==1) $class31="���";else $class31="���˫";
    }
    else {
        if ($na%2==1) $class31="��С��";else $class31="��С˫";
    }
}
if ($class3=="�̲�"){
    if ($na>=25){
        if ($na%2==1) $class31="�̴�";else $class31="�̴�˫";
    }
    else {
        if ($na%2==1) $class31="��С��";else $class31="��С˫";
    }
}
if ($class3=="����"){
    if ($na>=25){
        if ($na%2==1) $class31="����";else $class31="����˫";
    }
    else {
        if ($na%2==1) $class31="��С��";else $class31="��С˫";
    }
}

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��벨' and class2='".$class2."' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��벨' and class2='".$class2."' and class3='".$class31."'");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��벨' and class2='".$class2."' and class3='".$class31."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo $class2."����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//������Ф
if ($na<10){$naa="0".$na;}else{$naa=$na;}
$sxsx=Get_sx_Color($naa);

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='".$sxsx."'");
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and bm<>0 and class3<>'".$sxsx."'   ");
$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='".$sxsx."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "��Ф����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}



//�����Ф
if ($na<10){$naa="0".$na;}else{$naa=$na;}
$sxsx=Get_sx_Color($naa);

if ($na==49) {
mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='��Ф' and (class2='��Ф'  or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='ʮФ' or class2='ʮһФ' ) ");
$result1dd = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��Ф' and (class2='��Ф'  or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='��Ф'  or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='ʮФ' or class2='ʮһФ' )");
$Rs5 = mysql_fetch_array($result1dd);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��Ф' and (class2='��Ф'  or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='��Ф'  or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='ʮФ' or class2='ʮһФ' ) and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��Ф' and (class2='��Ф'  or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='��Ф'  or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='ʮФ' or class2='ʮһФ' ) and class3 LIKE '%$sxsx%' ");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��Ф' and (class2='��Ф'  or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='��Ф'  or class2='��Ф'  or class2='��Ф' or class2='��Ф'  or class2='ʮФ' or class2='ʮһФ') and class3 LIKE '%$sxsx%' ");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "��Ф����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}



//����ƽФ

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



mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��Ф' and class2='һФ' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��Ф' and class2='һФ' and (class3='".$sxsx0."' or class3='".$sxsx1."' or class3='".$sxsx2."' or class3='".$sxsx3."' or class3='".$sxsx4."' or class3='".$sxsx5."' or class3='".$sxsx6."'  )");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��Ф' and class2='һФ' and (class3='".$sxsx0."' or class3='".$sxsx1."' or class3='".$sxsx2."' or class3='".$sxsx3."' or class3='".$sxsx4."' or class3='".$sxsx5."' or class3='".$sxsx6."')");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "һФ����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//������Ф

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


//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}
//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}
//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}
//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}
//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}
//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}
//if ($sxsx0 == "ţ") {$sss["ţ"] = $sss["ţ"]+1;}
//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}
//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}
//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}
//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}
//if ($sxsx0 == "��") {$sss["��"] = $sss["��"]+1;}

if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx1 == "ţ") {$sss["ţ"] = $sss["ţ"]+1;}
if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx1 == "��") {$sss["��"] = $sss["��"]+1;}

if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx2 == "ţ") {$sss["ţ"] = $sss["ţ"]+1;}
if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx2 == "��") {$sss["��"] = $sss["��"]+1;}

if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx3 == "ţ") {$sss["ţ"] = $sss["ţ"]+1;}
if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx3 == "��") {$sss["��"] = $sss["��"]+1;}

if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx4 == "ţ") {$sss["ţ"] = $sss["ţ"]+1;}
if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx4 == "��") {$sss["��"] = $sss["��"]+1;}

if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx5 == "ţ") {$sss["ţ"] = $sss["ţ"]+1;}
if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx5 == "��") {$sss["��"] = $sss["��"]+1;}

if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx6 == "ţ") {$sss["ţ"] = $sss["ţ"]+1;}
if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}
if ($sxsx6 == "��") {$sss["��"] = $sss["��"]+1;}

mysql_query("update ka_tan set rate2=rate where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and bm=0 ");

mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and bm<>0 ");

if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");
if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");
if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");
if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");
if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");
if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");
if ($sss["ţ"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["ţ"]."-(".$sss["ţ"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='ţ' ");
if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");
if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");
if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");
if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");
if ($sss["��"] > 0) mysql_query("update ka_tan set bm=1,rate=rate2*".$sss["��"]."-(".$sss["��"]."-1) where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='��' ");

echo $sss["ţ"]."<br>";
if ($sss["ţ"]==1 && ($n1=="49" || $n2=="49" || $n3=="49" || $n4=="49" || $n5=="49" || $n6=="49")) {

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and class3='ţ'");

}

//if ($na=="49") {

//mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='��Ф' and class2='��Ф'");

//}

$www = "";
if ($sss["��"] > 0) $www .= " or class3='��' ";
if ($sss["��"] > 0) $www .= " or class3='��' ";
if ($sss["��"] > 0) $www .= " or class3='��' ";
if ($sss["��"] > 0) $www .= " or class3='��' ";
if ($sss["��"] > 0) $www .= " or class3='��' ";
if ($sss["��"] > 0) $www .= " or class3='��' ";
if ($sss["ţ"] > 0) $www .= " or class3='ţ' ";
if ($sss["��"] > 0) $www .= " or class3='��' ";
if ($sss["��"] > 0) $www .= " or class3='��' ";
if ($sss["��"] > 0) $www .= " or class3='��' ";
if ($sss["��"] > 0) $www .= " or class3='��' ";
if ($sss["��"] > 0) $www .= " or class3='��' ";

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��Ф' and class2='��Ф' and (1=1 ".$www.")");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

if ($zwin!=0){
echo "��Ф����ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//����ͷ��
$wsws0=floor($na/10);
//$wsws1=floor($n1/10);
//$wsws2=floor($n2/10);
//$wsws3=floor($n3/10);
//$wsws4=floor($n4/10);
//$wsws5=floor($n5/10);
//$wsws6=floor($n6/10);


mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='ͷ��' and class2='ͷ��' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='ͷ��' and class2='ͷ��' and class3='".$wsws0."'");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='ͷ��' and class2='ͷ��' and class3='".$wsws0."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "����ͷ������ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//����β��
$wsws0=$na%10;
//$wsws1=$n1%10;
//$wsws2=$n2%10;
//$wsws3=$n3%10;
//$wsws4=$n4%10;
//$wsws5=$n5%10;
//$wsws6=$n6%10;


mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='β��' and class2='β��' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='β��' and class2='β��' and class3='".$wsws0."'");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='β��' and class2='β��' and class3='".$wsws0."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "����β������ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//��������β��
$wsws0=$na%10;
$wsws1=$n1%10;
$wsws2=$n2%10;
$wsws3=$n3%10;
$wsws4=$n4%10;
$wsws5=$n5%10;
$wsws6=$n6%10;


mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����β��' and class2='����β��' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����β��' and class2='����β��' and (class3='".$wsws0."' or class3='".$wsws1."' or class3='".$wsws2."' or class3='".$wsws3."' or class3='".$wsws4."' or class3='".$wsws5."' or class3='".$wsws6."'  )");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����β��' and class2='����β��' and (class3='".$wsws0."' or class3='".$wsws1."' or class3='".$wsws2."' or class3='".$wsws3."' or class3='".$wsws4."' or class3='".$wsws5."' or class3='".$wsws6."') ");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "����β������ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//������ɫ��
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
if ($wsws0 == "�첨") $hongbo_na = $hongbo_na + 1.5; else if ($wsws0 == "�̲�") $lvbo_na = $lvbo_na + 1.5; else if ($wsws0 == "����") $lanbo_na = $lanbo_na + 1.5;

if ($wsws1 == "�첨") $hongbo = $hongbo + 1; else if ($wsws1 == "�̲�") $lvbo = $lvbo + 1; else if ($wsws1 == "����") $lanbo = $lanbo + 1;
if ($wsws2 == "�첨") $hongbo = $hongbo + 1; else if ($wsws2 == "�̲�") $lvbo = $lvbo + 1; else if ($wsws2 == "����") $lanbo = $lanbo + 1;
if ($wsws3 == "�첨") $hongbo = $hongbo + 1; else if ($wsws3 == "�̲�") $lvbo = $lvbo + 1; else if ($wsws3 == "����") $lanbo = $lanbo + 1;
if ($wsws4 == "�첨") $hongbo = $hongbo + 1; else if ($wsws4 == "�̲�") $lvbo = $lvbo + 1; else if ($wsws4 == "����") $lanbo = $lanbo + 1;
if ($wsws5 == "�첨") $hongbo = $hongbo + 1; else if ($wsws5 == "�̲�") $lvbo = $lvbo + 1; else if ($wsws5 == "����") $lanbo = $lanbo + 1;
if ($wsws6 == "�첨") $hongbo = $hongbo + 1; else if ($wsws6 == "�̲�") $lvbo = $lvbo + 1; else if ($wsws6 == "����") $lanbo = $lanbo + 1;

$hongbo_z = $hongbo_na + $hongbo;
$lvbo_z = $lvbo_na + $lvbo;
$lanbo_z = $lanbo_na + $lanbo;

if ($hongbo_z > $lvbo_z && $hongbo_z > $lanbo_z) $qsbgo = "�첨";
if ($lvbo_z > $hongbo_z && $lvbo_z > $lanbo_z) $qsbgo = "�̲�";
if ($lanbo_z > $hongbo_z && $lanbo_z > $lvbo_z) $qsbgo = "����";

if ($hongbo_z==3 && $lvbo_z==3 && $wsws0 == "����") $qsbgo = "�Ͼ�";
if ($lvbo_z==3 && $lanbo_z==3 && $wsws0 == "�첨") $qsbgo = "�Ͼ�";
if ($hongbo_z==3 && $lanbo_z==3 && $wsws0 == "�̲�") $qsbgo = "�Ͼ�";

if ($qsbgo=="�Ͼ�") {
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��ɫ��' and class2='��ɫ��' and bm<>0 ");

mysql_query("update ka_tan set bm=2 where kithe=".$kithe." and class1='��ɫ��' and class2='��ɫ��' and class3<>'�Ͼ�'");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��ɫ��' and class2='��ɫ��' and class3='�Ͼ�'");

$result1dd = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��ɫ��' and class2='��ɫ��' and class3='�Ͼ�'");
$Rs5 = @mysql_fetch_array($result1dd);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}

}else{
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��ɫ��' and class2='��ɫ��' and bm<>0 ");
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��ɫ��' and class2='��ɫ��' and class3='".$qsbgo."' ");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='��ɫ��' and class2='��ɫ��' and class3 ='".$qsbgo."' ");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
}

if ($zwin!=0){
echo "��ɫ������ɹ���<font color=ff6600>".$zwin."ע</font><br>";}



//��������
if ($na<10){$wxwx="0".$na;}else{$wxwx=$na;}

$wxwxwx=Get_wxwx_Color($wxwx);
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='����' and class2='����' and bm<>0 ");

mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='����' and class2='����' and class3='".$wxwxwx."' ");

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=".$kithe." and class1='����' and class2='����' and class3='".$wxwxwx."'");
$Rs5 = @mysql_fetch_array($result1);
if ($Rs5!=""){$zwin=$Rs5['re'];}else{$zwin=0;}
if ($zwin!=0){
echo "���н���ɹ���<font color=ff6600>".$zwin."ע</font><br>";}

//ȫ����
mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='ȫ����'");
$result1kk=mysql_query("select class3 from ka_tan where kithe=".$kithe." and class1='ȫ����'");
explode(",",$class3);
while($image = mysql_fetch_array($result1kk)){
$class3=$image[0];
$numberxz=explode(",",$class3);
	$ss1=count($numberxz);
	for ($i=0;$i<$ss1;$i++){
	  if ($numberxz[$i]==$na||$numberxz[$i]==$n1||$numberxz[$i]==$n2||$numberxz[$i]==$n3||$numberxz[$i]==$n4||$numberxz[$i]==$n5||$numberxz[$i]==$n6){mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='ȫ����' and class3 like '%".$class3."%'");}
	}
}

//echo $na;
$zxbz=mysql_query("select * from ka_tan where kithe=".$kithe." and class1='ȫ����' and bm=1");
$re = @mysql_num_rows($zxbz);
if ($Rs5!=""){$zwin=$re;}else{$zwin=0;}
if ($zwin!=0){
echo "ȫ���н���ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//��Ф��	
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
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='��Ф��'");
//echo $lx_sx1."<br>";
//echo $lx_sx2."<br>";
//echo $lx_sx3."<br>";
//echo $lx_sx4."<br>";
//echo $lx_sx5."<br>";
//echo $lx_sx6."<br>";
//echo $lx_sx7."<br>";

$result = mysql_query("Select id,class2,class3  from ka_tan where kithe=".$kithe." and class1='��Ф��'");   
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
    if($cont==$ss1 && ( $class2=="��Ф����" || $class2=="��Ф����" || $class2=="��Ф����"  || $class2=="��Ф����" )){mysql_query("update ka_tan set bm=1 where id=".$Rs_id);}
    if($cont==0 && ( $class2=="��Ф������" || $class2=="��Ф������" || $class2=="��Ф������" )){mysql_query("update ka_tan set bm=1 where id=".$Rs_id);}



}

//mysql_query("update ka_tan set bm=1 where kithe=".$kithe." and class1='��Ф��' and (class3 like '%".$lx_sx1."%' and class3 like '%".$lx_sx2."%' and  class3 like '%".$lx_sx3."%' and  class3 like '%".$lx_sx4."%' and  class3 like '%".$lx_sx5."%' and class3 like '%".$lx_sx6."%' and class3 like '%".$lx_sx7."%')");


$lxbz=mysql_query("select * from ka_tan where kithe=".$kithe." and class1='��Ф��' and bm=1");
$re = @mysql_num_rows($lxbz);
if ($Rs5!=""){$zwin=$re;}else{$zwin=0;}
if ($zwin!=0){
echo "��Ф������ɹ���<font color=ff6600>".$zwin."ע</font><br>";}




//β����	
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
mysql_query("update ka_tan set bm=0 where kithe=".$kithe." and class1='β����'");
//echo $lx_sx1."<br>";
//echo $lx_sx2."<br>";
//echo $lx_sx3."<br>";
//echo $lx_sx4."<br>";
//echo $lx_sx5."<br>";
//echo $lx_sx6."<br>";
//echo $lx_sx7."<br>";

$result = mysql_query("Select id,class2,class3  from ka_tan where kithe=".$kithe." and class1='β����'");   
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
    if($cont==$ss1 && ( $class2=="��β����" || $class2=="��β����" || $class2=="��β����" )){mysql_query("update ka_tan set bm=1 where id=".$Rs_id);}
    if($cont==0 && ( $class2=="��β������" || $class2=="��β������" || $class2=="��β������" )){mysql_query("update ka_tan set bm=1 where id=".$Rs_id);}



}



$lxbz=mysql_query("select * from ka_tan where kithe=".$kithe." and class1='β����' and bm=1");
$re = @mysql_num_rows($lxbz);
if ($Rs5!=""){$zwin=$re;}else{$zwin=0;}
if ($zwin!=0){
echo "β��������ɹ���<font color=ff6600>".$zwin."ע</font><br>";}


//����
}
echo "<font color=ff0000>��".$kithe."�ڽ���ɹ�</font>";
$result = mysql_query("Select *  from ka_tan where kithe='".$kithe."' and checked=0");  
while($rs = mysql_fetch_array($result)){
	/*if($rs['bm']==1){		//��Ա�н�
		$z_user=($rs['sum_m']*$rs['rate']+$rs['sum_m']*abs($rs['user_ds'])/100)+$rs['sum_m'];
	}else{					//δ�н���ˮ
		$z_user=$rs['sum_m']*abs($rs['user_ds'])/100;
	}*/
	if($rs['bm']==1){		//��Ա�н�
		$z_user=($rs['sum_m']*$rs['rate']-$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100)+$rs['sum_m'];
		//�н���ˮ
		$z_user+=$rs['sum_m']*abs($rs['user_ds'])/100;
				 //$rs['sum_m']*$rs['rate']-$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100
	}else{					//δ�н���ˮ
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
