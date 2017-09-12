<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

if ($_GET['kithe']!=""){$kithe=$_GET['kithe'];}else{$kithe=$Current_Kithe_Num;}
$bb=$_GET['id'];

$id=$_GET['id'];
 switch ($bb)
  {
    case 1:
      $class1="特码";
      break;
	 case 3:
 $class1="正特";
 $class2=$_GET['class2'];
  break;
 case 2:
 $class1="正码";
  break;
	case 4:
 $class1="五行";
 $class2=$_GET['class2'];
  break;
	case 5:
 $class1="生肖";
 $class2=$_GET['class2'];
  break;
case 6:
 $class1="半波";
 $class2=$_GET['class2'];
  break;
case 7:
 $class1="尾数";
 $class2=$_GET['class2'];
  break;
case 8:
 $class1="连码";
 $class2=$_GET['class2'];
  break;
case 9:
 $class1="过关";
 $class2=$_GET['class2'];
  break;
case 10:
 $class1=$_GET['class1'];
 $class2=$_GET['class2'];
  break;
    default:

     $class1="特码";
      break;
  } 
  
  
  
?>

<link rel="stylesheet" href="xp.css" type="text/css">

<title>[<? if ($class1=="特码" or $class1=="正码" ){?><?=$class1?>:<?=$_GET['class3']?><? }else{?><?=$class1?>/<?=$_GET['class2']?>:<?=$_GET['class3']?><? }?>]下注明细</title>
<? if ($_GET['act']==""){?>
<style type="text/css">
<!--
.STYLE1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<iframe id=frmRight 
      style="Z-INDEX: 1; VISIBILITY: inherit; WIDTH: 100%; HEIGHT: 100%" 
      name=right src="index.php?action=look1&act=main&lx=<?=$_GET['lx'];?>&username=<?=$_GET['username']?>&kithe=<?=$kithe?>&id=<?=$_GET['id'];?>&class1=<?=$_GET['class1'];?>&class2=<?=$_GET['class2'];?>&class3=<?=$_GET['class3'];?>" frameborder=0></iframe>
	  
<? }?>

<? if ($_GET['act']=="main"){?>
<body scroll=yes leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onkeydown="return false";>


<table id="tb"  border="1" align="center" cellspacing="1" cellpadding="3" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="100%">
  <tr class="tbtitle">
    <td height="28" colspan="12" nowrap="nowrap" bordercolor="cccccc"><font color="#FFFFFF">&nbsp;<strong>[<?=$_GET['username']?>]&nbsp;[
        <? if ($class1=="特码" or $class1=="正码" ){?>
      <?=$class1?>
      :
      <?=$_GET['class3']?>
      <? }else{?>
      <?=$class1?>
      /
      <?=$_GET['class2']?>
      :
      <?=$_GET['class3']?>
      <? }?>
      ]下注明细</strong></font></td>
  </tr>
  <tr >
    <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">序号</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">订单号</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">下单时间</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">期数</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">会员</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">下注总额</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">佣金</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">代%</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">总%</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">股%</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">公%</span></td>
  </tr>
  <?

$a=1;
 if ($class1=="特码" or $class1=="正码" ){
$result = mysql_query("select * from ka_tan where kithe='".$kithe."' and class1='".$class1."' and class3='".$_GET['class3']."' and username='".$_GET['username']."'  order by id desc"); }else {
$result = mysql_query("select * from ka_tan where kithe='".$kithe."' and class2='".$class2."' and class1='".$class1."' and class3='".$_GET['class3']."' and username='".$_GET['username']."'  order by id desc"); }

 
while($rs = mysql_fetch_array($result)){
?>
  <? if ($rs['class2']=="特B" or $rs['class2']=="正B" ){?>
  <tr bgColor="#E8E4D0" onMouseOver="javascript:this.bgColor='#FDF4CA'" onMouseOut="javascript:this.bgColor='#E8E4D0'">
    <? }else{?>
  <tr bgColor="#ffffff" onMouseOver="javascript:this.bgColor='#FDF4CA'" onMouseOut="javascript:this.bgColor='#ffffff'">
	<? }?>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=$a?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['num']?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['adddate']?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['kithe']?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['username']?>
      .
        <?=$rs['abcd']?>
      .
      <?=abs($rs['user_ds'])?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><font color=ff6600>
      <?=$rs['sum_m']?>
    </font></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['rate']?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['sum_m']*$rs['user_ds']/100?></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['dai_zc']*10?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['zong_zc']*10?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['guan_zc']*10?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['dagu_zc']*10?></td>
  </tr>
  <?
			$sum_m+=$rs['sum_m'];
			$user_ds+=$rs['sum_m']*$rs['user_ds']/100;
$a=$a+1;
}?>
  <tr bgColor="#E0DCC0" >
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF"><font color=ff6600>总计</font></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF"><font color=ff6600>
      <?=$sum_m?>
    </font></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF"><font color=ff6600>
      <?=$user_ds?>
    </font></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgColor="#E0DCC0" >
    <td height="28" colspan="12" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70"><div align="left"> </div></td>
        <td><div align="right" disabled><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle"> 提示：淡黄色的是[
                 <? if  ($class1=="正码") {?>
          正B
          <? }else{?>
          特B
          <? }?>
          ]下注明细!</div></td>
      </tr>
    </table></td>
  </tr>
</table>
<? }?>
