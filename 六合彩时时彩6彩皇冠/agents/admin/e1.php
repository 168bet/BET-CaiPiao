<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

 if (strpos($_SESSION['flag'],'03') ){}else{ 
echo "<center>你没有该权限功能!</center>";
exit;}


$ids="特A";

if ($_GET['zsave']=="zsave") {

if ($_POST['tm']=="") {       
  echo "<script>alert('预计亏损不能为空，请输入数字!');window.history.go(-1);</script>"; 
  exit;
}
if ($_POST['ttm1']=="") {       
  echo "<script>alert('退水不能为空，请输入数字!');window.history.go(-1);</script>"; 
  exit;
}

$exe=mysql_query("update adad set tm='".$_POST['tm']."',tm1='".$_POST['ttm1']."'  Where id=1");
}
$result=mysql_query("select * from adad order by id"); 
$row=mysql_fetch_array($result);

$best=$row['best'];	
	$zm=$row['zm'];
	$zm6=$row['zm6'];
	$lm=$row['lm'];	
	$zlm=$row['zlm'];
	$ys=$row['ys'];
	$ls=$row['ls'];
	$dx=$row['dx'];
	$tm=$row['tm'];
	$spx=$row['spx'];
	$bb=$row['bb'];
	$zmt=$row['zmt'];
	$ws=$row['ws'];
	$zm1=$row['zm1'];
	$zm61=$row['zm61'];
	$lm1=$row['lm1'];	
	$zlm1=$row['zlm1'];
	$ys1=$row['ys1'];
	$ls1=$row['ls1'];
	$dx1=$row['dx1'];
	$tm1=$row['tm1'];
	$spx1=$row['spx1'];
	$bb1=$row['bb1'];
	$zmt1=$row['zmt1'];
	$ws1=$row['ws1'];
	$ps1=$row['ps1'];
	$ps=$row['ps'];	
$zds=$tm1;
if ($_GET['kithe']!=""){$kithe=$_GET['kithe'];}else{$kithe=$Current_Kithe_Num;}

if ($kithe!=$Current_Kithe_Num){$ftime=20000000;}



$result = mysql_query("select class3,class1,rate,class2   from   ka_bl where   class1='特码' and class2='特A'  order by id");   
$ii=0;
while($rs = mysql_fetch_array($result)){

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='".$rs['class1']."' and class3='".$rs['class3']."' and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
//$RsB = mysql_fetch_array($result4);
//一条记录用"###"隔开.每列数据用"@@@"隔开. 这是以只有两个列数据的情况.
if ($ii<49){
$result6 = mysql_query("Select * from m_color   where   id=".$rs['class3']." order by id Desc");
$rskf = mysql_fetch_array($result6);
if ($rskf['color']=="r") {
$sum_color[$ii]="ff0000";
}else if ($rskf['color']=="b"){$sum_color[$ii]="0000FF";}else if ($rskf['color']=="g"){$sum_color[$ii]="00FF00";}
}else{
$sum_color[$ii]="ff0000";
}
$sum_tm[$ii]=$rs['class3'];
if ($Rs5['sum_m']!=""){
$sum_m[$ii] = $Rs5['sum_m'];}else{$sum_m[$ii] =0;}
if ($rs['rate']!=""){
$sum_mbl[$ii]=$rs['rate'];
}else{
$sum_mbl[$ii]=0;
}
$tmzr+=$sum_m[$ii];
$ii++;


}






$result = mysql_query("select class3,class1,rate,class2   from   ka_bl where   class1='正码' and class2='正A'  order by id");   
$ii=0;
while($rs = mysql_fetch_array($result)){

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='".$rs['class1']."' and class3='".$rs['class3']."' and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
//$RsB = mysql_fetch_array($result4);
//一条记录用"###"隔开.每列数据用"@@@"隔开. 这是以只有两个列数据的情况.
if ($ii<49){
$result6 = mysql_query("Select * from m_color   where   id=".$rs['class3']." order by id Desc");
$rskf = mysql_fetch_array($result6);
if ($rskf['color']=="r") {
$sumzm_color[$ii]="ff0000";
}else if ($rskf['color']=="b"){$sum_color[$ii]="0000FF";}else if ($rskf['color']=="g"){$sum_color[$ii]="00FF00";}
}else{
$sumzm_color[$ii]="ff0000";
}
$sumzm_tm[$ii]=$rs['class3'];
if ($Rs5['sum_m']!=""){
$sumzm_m[$ii] = $Rs5['sum_m'];}else{$sumzm_m[$ii] =0;}
if ($rs['rate']!=""){
$sumzm_mbl[$ii]=$rs['rate'];
}else{
$sumzm_mbl[$ii]=0;
}

$zmzr+=$sumzm_m[$ii];
$ii++;
}


//正1特

$result = mysql_query("select class3,class1,rate,class2   from   ka_bl where   class1='正特' and class2='正1特'  order by id");   
$ii=0;
while($rs = mysql_fetch_array($result)){

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='".$rs['class1']."' and  class2='".$rs['class2']."' and class3='".$rs['class3']."' and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
//$RsB = mysql_fetch_array($result4);
//一条记录用"###"隔开.每列数据用"@@@"隔开. 这是以只有两个列数据的情况.
if ($ii<49){
$result6 = mysql_query("Select * from m_color   where   id=".$rs['class3']." order by id Desc");
$rskf = mysql_fetch_array($result6);
if ($rskf['color']=="r") {
$sumzt1_color[$ii]="ff0000";
}else if ($rskf['color']=="b"){$sumzt1_color[$ii]="0000FF";}else if ($rskf['color']=="g"){$sumzt1_color[$ii]="00FF00";}
}else{
$sumzt1_color[$ii]="ff0000";
}
$sumzt1_tm[$ii]=$rs['class3'];
if ($Rs5['sum_m']!=""){
$sumzt1_m[$ii] = $Rs5['sum_m'];}else{$sumzt1_m[$ii] =0;}
if ($rs['rate']!=""){
$sumzt1_mbl[$ii]=$rs['rate'];
}else{
$sumzt1_mbl[$ii]=0;
}
$zt1zr+=$sumzt1_m[$ii];
$ii++;
}



//正2特

$result = mysql_query("select class3,class1,rate,class2   from   ka_bl where   class1='正特' and class2='正2特'  order by id");   
$ii=0;
while($rs = mysql_fetch_array($result)){

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='".$rs['class1']."' and  class2='".$rs['class2']."' and class3='".$rs['class3']."' and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
//$RsB = mysql_fetch_array($result4);
//一条记录用"###"隔开.每列数据用"@@@"隔开. 这是以只有两个列数据的情况.
if ($ii<49){
$result6 = mysql_query("Select * from m_color   where   id=".$rs['class3']." order by id Desc");
$rskf = mysql_fetch_array($result6);
if ($rskf['color']=="r") {
$sumzt2_color[$ii]="ff0000";
}else if ($rskf['color']=="b"){$sumzt2_color[$ii]="0000FF";}else if ($rskf['color']=="g"){$sumzt2_color[$ii]="00FF00";}
}else{
$sumzt2_color[$ii]="ff0000";
}
$sumzt2_tm[$ii]=$rs['class3'];
if ($Rs5['sum_m']!=""){
$sumzt2_m[$ii] = $Rs5['sum_m'];}else{$sumzt2_m[$ii] =0;}
if ($rs['rate']!=""){
$sumzt2_mbl[$ii]=$rs['rate'];
}else{
$sumzt2_mbl[$ii]=0;
}
$zt2zr+=$sumzt2_m[$ii];
$ii++;
}


//正3特

$result = mysql_query("select class3,class1,rate,class2   from   ka_bl where   class1='正特' and class2='正3特'  order by id");   
$ii=0;
while($rs = mysql_fetch_array($result)){

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='".$rs['class1']."' and  class2='".$rs['class2']."' and class3='".$rs['class3']."' and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
//$RsB = mysql_fetch_array($result4);
//一条记录用"###"隔开.每列数据用"@@@"隔开. 这是以只有两个列数据的情况.
if ($ii<49){
$result6 = mysql_query("Select * from m_color   where   id=".$rs['class3']." order by id Desc");
$rskf = mysql_fetch_array($result6);
if ($rskf['color']=="r") {
$sumzt3_color[$ii]="ff0000";
}else if ($rskf['color']=="b"){$sumzt3_color[$ii]="0000FF";}else if ($rskf['color']=="g"){$sumzt3_color[$ii]="00FF00";}
}else{
$sumzt3_color[$ii]="ff0000";
}
$sumzt3_tm[$ii]=$rs['class3'];
if ($Rs5['sum_m']!=""){
$sumzt3_m[$ii] = $Rs5['sum_m'];}else{$sumzt3_m[$ii] =0;}
if ($rs['rate']!=""){
$sumzt3_mbl[$ii]=$rs['rate'];
}else{
$sumzt3_mbl[$ii]=0;
}
$zt3zr+=$sumzt3_m[$ii];
$ii++;
}


//正4特

$result = mysql_query("select class3,class1,rate,class2   from   ka_bl where   class1='正特' and class2='正4特'  order by id");   
$ii=0;
while($rs = mysql_fetch_array($result)){

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='".$rs['class1']."' and  class2='".$rs['class2']."' and class3='".$rs['class3']."' and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
//$RsB = mysql_fetch_array($result4);
//一条记录用"###"隔开.每列数据用"@@@"隔开. 这是以只有两个列数据的情况.
if ($ii<49){
$result6 = mysql_query("Select * from m_color   where   id=".$rs['class3']." order by id Desc");
$rskf = mysql_fetch_array($result6);
if ($rskf['color']=="r") {
$sumzt4_color[$ii]="ff0000";
}else if ($rskf['color']=="b"){$sumzt4_color[$ii]="0000FF";}else if ($rskf['color']=="g"){$sumzt4_color[$ii]="00FF00";}
}else{
$sumzt4_color[$ii]="ff0000";
}
$sumzt4_tm[$ii]=$rs['class3'];
if ($Rs5['sum_m']!=""){
$sumzt4_m[$ii] = $Rs5['sum_m'];}else{$sumzt4_m[$ii] =0;}
if ($rs['rate']!=""){
$sumzt4_mbl[$ii]=$rs['rate'];
}else{
$sumzt4_mbl[$ii]=0;
}
$zt4zr+=$sumzt4_m[$ii];
$ii++;
}


//正5特

$result = mysql_query("select class3,class1,rate,class2   from   ka_bl where   class1='正特' and class2='正5特'  order by id");   
$ii=0;
while($rs = mysql_fetch_array($result)){

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='".$rs['class1']."' and  class2='".$rs['class2']."' and class3='".$rs['class3']."' and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
//$RsB = mysql_fetch_array($result4);
//一条记录用"###"隔开.每列数据用"@@@"隔开. 这是以只有两个列数据的情况.
if ($ii<49){
$result6 = mysql_query("Select * from m_color   where   id=".$rs['class3']." order by id Desc");
$rskf = mysql_fetch_array($result6);
if ($rskf['color']=="r") {
$sumzt5_color[$ii]="ff0000";
}else if ($rskf['color']=="b"){$sumzt5_color[$ii]="0000FF";}else if ($rskf['color']=="g"){$sumzt5_color[$ii]="00FF00";}
}else{
$sumzt5_color[$ii]="ff0000";
}
$sumzt5_tm[$ii]=$rs['class3'];
if ($Rs5['sum_m']!=""){
$sumzt5_m[$ii] = $Rs5['sum_m'];}else{$sumzt5_m[$ii] =0;}
if ($rs['rate']!=""){
$sumzt5_mbl[$ii]=$rs['rate'];
}else{
$sumzt5_mbl[$ii]=0;
}

$zt5zr+=$sumzt5_m[$ii];
$ii++;
}

//正1特

$result = mysql_query("select class3,class1,rate,class2   from   ka_bl where   class1='正特' and class2='正6特'  order by id");   
$ii=0;
while($rs = mysql_fetch_array($result)){

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='".$rs['class1']."' and  class2='".$rs['class2']."' and class3='".$rs['class3']."' and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
//$RsB = mysql_fetch_array($result4);
//一条记录用"###"隔开.每列数据用"@@@"隔开. 这是以只有两个列数据的情况.
if ($ii<49){
$result6 = mysql_query("Select * from m_color   where   id=".$rs['class3']." order by id Desc");
$rskf = mysql_fetch_array($result6);
if ($rskf['color']=="r") {
$sumzt6_color[$ii]="ff0000";
}else if ($rskf['color']=="b"){$sumzt6_color[$ii]="0000FF";}else if ($rskf['color']=="g"){$sumzt6_color[$ii]="00FF00";}
}else{
$sumzt6_color[$ii]="ff0000";
}
$sumzt6_tm[$ii]=$rs['class3'];
if ($Rs5['sum_m']!=""){
$sumzt6_m[$ii] = $Rs5['sum_m'];}else{$sumzt6_m[$ii] =0;}
if ($rs['rate']!=""){
$sumzt6_mbl[$ii]=$rs['rate'];
}else{
$sumzt6_mbl[$ii]=0;
}
$zt6zr+=$sumzt6_m[$ii];
$ii++;
}

?>

<link rel="stylesheet" href="images/xp.css" type="text/css">

<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<body  >
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>

<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">
<table   border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="800">
  <tr>
    <td width="83%" height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><table width="600" border="0" align="left" cellpadding="2" cellspacing="1">
      <tr>
        <td width="160" nowrap>[<?=$_GET['username']?>]-打印统计[
          <?=$kithe?>期]</td>
        <td width="14" align="right" nowrap>&nbsp;</td>
        <td width="63" align="right" nowrap>&nbsp;</td>
        <td width="36" nowrap>&nbsp;</td>
        <form name=form55 action="index.php?action=dy&zsave=zsave&kithe=<?=$kithe?>&ids=<?=$ids?>" method=post>
          </form>
        <td width="458"><input name="lm" type="hidden" id="lm" value="0"></td>
        <td width="458"><button onClick="javascript:window.print();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/asp.gif" width="16" height="16" align="absmiddle" />打印</button></td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>
<DIV id=rs_window style="DISPLAY: none; POSITION: absolute">
 <form action="index.php?action=pz_tm&save=save&ids=<?=$ids?>&kithe=<?=$kithe?>"    method="post" name="form1" > <?
include("d1.php");
?>
</form>
</div>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="f1f1f1">
  <tr>
    <td bordercolor="cccccc" bgcolor="#FFFFFF">
	<?
	$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='生肖' and  class2='一肖'  and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5['sum_m']!=""){
$yszr = $Rs5['sum_m'];}else{$yszr =0;}

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='生肖' and  class2='特肖'  and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5['sum_m']!=""){
$tszr = $Rs5['sum_m'];}else{$tszr =0;}

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='生肖' and  (class2='二肖' or class2='三肖'  or class2='四肖'  or class2='五肖'  or class2='六肖')  and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5['sum_m']!=""){
$dszr = $Rs5['sum_m'];}else{$dszr =0;}

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='尾数' and  class2='尾数'  and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5['sum_m']!=""){
$wszr = $Rs5['sum_m'];}else{$wszr =0;}

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='五行' and  class2='五行'  and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5['sum_m']!=""){
$wxzr = $Rs5['sum_m'];}else{$wxzr =0;}

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='过关'   and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5['sum_m']!=""){
$ggzr = $Rs5['sum_m'];}else{$ggzr =0;}

$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe='".$kithe."' and  class1='连码'  and username='".$_GET['username']."'");
$Rs5 = mysql_fetch_array($result1);
if ($Rs5['sum_m']!=""){
$lmzr = $Rs5['sum_m'];}else{$lmzr =0;}
?>
	
	特码:<span class="STYLE1">
      <?=$tmzr?>
    </span>&nbsp;&nbsp;&nbsp;&nbsp;特码单双:<span class="STYLE1">
    <?=$sum_m[49]+$sum_m[50]?>
    </span>&nbsp;&nbsp;&nbsp;&nbsp;特码大小:<span class="STYLE1">
    <?=$sum_m[51]+$sum_m[52]?>
    </span>
	&nbsp;&nbsp;&nbsp;&nbsp;特码合单合双:<span class="STYLE1">
    <?=$sum_m[53]+$sum_m[54]?>
    </span>
	&nbsp;&nbsp;&nbsp;&nbsp;特码色波:<span class="STYLE1">
    <?=$sum_m[55]+$sum_m[56]+$sum_m[57]?>
    </span>
	&nbsp;&nbsp;&nbsp;&nbsp;特码家禽:<span class="STYLE1">
    <?=$sum_m[58]+$sum_m[59]?>
    </span>
	
	&nbsp;&nbsp;&nbsp;&nbsp;一肖:<span class="STYLE1">
    <?=$yszr?>
    </span>
	<br>多肖:<span class="STYLE1">
    <?=$dszr?>
    </span>
	
	&nbsp;&nbsp;&nbsp;&nbsp;特肖:<span class="STYLE1">
    <?=$tszr?>
    </span>
	
		&nbsp;&nbsp;&nbsp;&nbsp;尾数:<span class="STYLE1">
    <?=$wszr?>
		
    </span>
	&nbsp;&nbsp;&nbsp;&nbsp;五行:<span class="STYLE1">
    <?=$wxzr?>
    </span>
	&nbsp;&nbsp;&nbsp;&nbsp;连码:<span class="STYLE1">
    <?=$lmzr?>
    </span>
	
	&nbsp;&nbsp;&nbsp;&nbsp;过关:<span class="STYLE1">
    <?=$ggzr?>
    </span>
	</td>
  </tr>
</table>
<table   width="800" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1" bgcolor="cccccc" >
  <tr >
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
  </tr>
  <? for ($I=1; $I<=10; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sum_color[$I-1]?>"><?=$sum_tm[$I-1]?></font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sum_mbl[$I-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sum_m[$I-1]!=0 ){echo "<font color=ff0000>";}?>
	 <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[$I-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sum_m[$I-1]?>
	</button>
	
	<? if ($sum_m[$I-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sum_color[$I+10-1]?>"><?=$sum_tm[$I+10-1]?></font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sum_mbl[$I+10-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sum_m[$I+10-1]!=0 ){echo "<font color=ff0000>";}?>
	 <button onMouseOver="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[$I+10-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" class="headtd3">
	<?=$sum_m[$I+10-1]?>
	</button>
	
	<? if ($sum_m[$I+10-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><font color="<?=$sum_color[$I+20-1]?>"><?=$sum_tm[$I+20-1]?></font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><?=$sum_mbl[$I+20-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sum_m[$I+20-1]!=0 ){echo "<font color=ff0000>";}?>
	<button onMouseOver="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[$I+20-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" class="headtd3">
	<?=$sum_m[$I+20-1]?>
	</button>
	
	<? if ($sum_m[$I+20-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sum_color[$I+30-1]?>"><?=$sum_tm[$I+30-1]?></font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sum_mbl[$I+30-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sum_m[$I+30-1]!=0 ){echo "<font color=ff0000>";}?>
	<button onMouseOver="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[$I+30-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" class="headtd3">
	<?=$sum_m[$I+30-1]?>
	</button><? if ($sum_m[$I+30-1]!=0 ){echo "</font>";}?></td>
	
	<? if ($I<=9 ){?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1" class="ballf_ff"><font color="<?=$sum_color[$I+40-1]?>"><?=$sum_tm[$I+40-1]?></font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sum_mbl[$I+40-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sum_m[$I+40-1]!=0 ){echo "<font color=ff0000>";}?><button onMouseOver="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[$I+40-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" class="headtd3">
	<?=$sum_m[$I+40-1]?>
	</button><? if ($sum_m[$I+40-1]!=0 ){echo "</font>";}?></td>
	<? }else{?>
	<td align="center" bordercolor="cccccc" bgcolor="#F1F1F1">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
	<? }?>
  </tr>
    <? }?>
  <? for ($I=1; $I<=2; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sum_color[$I+48]?>"><?=$sum_tm[$I+48]?></font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sum_mbl[$I+48]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sum_m[$I+48]!=0 ){echo "<font color=ff0000>";}?><button onMouseOver="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[$I+48]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" class="headtd3">
	<?=$sum_m[$I+48]?>
	</button><? if ($sum_m[$I+48]!=0 ){echo "</font>";}?></td>
	  <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sum_color[$I+50]?>"><?=$sum_tm[$I+50]?></font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sum_mbl[$I+50]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sum_m[$I+50]!=0 ){echo "<font color=ff0000>";}?><button onMouseOver="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[$I+50]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" class="headtd3">
	<?=$sum_m[$I+50]?>
	</button><? if ($sum_m[$I+50]!=0 ){echo "</font>";}?></td>
	
     <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1"  ><font color="<?=$sum_color[$I+52]?>"><?=$sum_tm[$I+52]?></font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sum_mbl[$I+52]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sum_m[$I+52]!=0 ){echo "<font color=ff0000>";}?><button onMouseOver="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[$I+52]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" class="headtd3">
	<?=$sum_m[$I+52]?>
	</button><? if ($sum_m[$I+52]!=0 ){echo "</font>";}?></td>
      <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sum_color[$I+54]?>"><?=$sum_tm[$I+54]?></font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sum_mbl[$I+54]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sum_m[$I+54]!=0 ){echo "<font color=ff0000>";}?><button onMouseOver="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[$I+54]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" class="headtd3">
	<?=$sum_m[$I+54]?>
	</button><? if ($sum_m[$I+54]!=0 ){echo "</font>";}?></td>
      <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sum_color[$I+56]?>"><?=$sum_tm[$I+56]?></font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sum_mbl[$I+56]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sum_m[$I+56]!=0 ){echo "<font color=ff0000>";}?><button onMouseOver="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[$I+56]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" class="headtd3">
	<?=$sum_m[$I+56]?>
	</button><? if ($sum_m[$I+56]!=0 ){echo "</font>";}?></td>
  </tr>
  <? }?>
  <tr >
    <td colspan="11" align="center" bordercolor="cccccc" bgcolor="#FFFF99"   >特码总额:<span class="STYLE1">
      <?=$tmzr?></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sum_color[59]?>">
      <?=$sum_tm[59]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sum_mbl[59]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sum_m[59]!=0 ){echo "<font color=ff0000>";}?>
       <button onMouseOver="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=1&amp;class3=<?=$sum_tm[59]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" class="headtd3">
	<?=$sum_m[59]?>
	</button>
      <? if ($sum_m[59]!=0 ){echo "</font>";}?></td>
  </tr>
</table>
<table   width="800" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1" bgcolor="cccccc" >
  <tr >
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
  </tr>
  <? for ($I=1; $I<=10; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sumzm_color[$I-1]?>">
      <?=$sumzm_tm[$I-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzm_mbl[$I-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzm_m[$I-1]!=0 ){echo "<font color=ff0000>";}?>
       <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=2&amp;class3=<?=$sumzm_tm[$I-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzm_m[$I-1]?>
	</button>
	

	 
        <? if ($sumzm_m[$I-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzm_color[$I+10-1]?>">
      <?=$sumzm_tm[$I+10-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzm_mbl[$I+10-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzm_m[$I+10-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=2&amp;class3=<?=$sumzm_tm[$I+10-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzm_m[$I+10-1]?>
	</button>
        <? if ($sumzm_m[$I+10-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><font color="<?=$sumzm_color[$I+20-1]?>">
      <?=$sumzm_tm[$I+20-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><?=$sumzm_mbl[$I+20-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzm_m[$I+20-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=2&amp;class3=<?=$sumzm_tm[$I+20-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzm_m[$I+20-1]?>
	</button>
        <? if ($sumzm_m[$I+20-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzm_color[$I+30-1]?>">
      <?=$sumzm_tm[$I+30-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzm_mbl[$I+30-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzm_m[$I+30-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=2&amp;class3=<?=$sumzm_tm[$I+30-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzm_m[$I+30-1]?>
	</button>
        <? if ($sumzm_m[$I+30-1]!=0 ){echo "</font>";}?></td>
    <? if ($I<=9 ){?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1" class="ballf_ff"><font color="<?=$sumzm_color[$I+40-1]?>">
      <?=$sumzm_tm[$I+40-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzm_mbl[$I+40-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzm_m[$I+40-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=2&amp;class3=<?=$sumzm_tm[$I+40-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzm_m[$I+40-1]?>
	</button>
        <? if ($sumzm_m[$I+40-1]!=0 ){echo "</font>";}?></td>
    <? }else{?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <? }?>
  </tr>
  <? }?>
  <tr >
    <? for ($I=1; $I<=4; $I=$I+1)
{

?>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzm_color[$I+48]?>">
      <?=$sumzm_tm[$I+48]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzm_mbl[$I+48]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzm_m[$I+48]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=2&amp;class3=<?=$sumzm_tm[$I+48]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzm_m[$I+48]?>
	</button>
        <? if ($sumzm_m[$I+48]!=0 ){echo "</font>";}?></td>
    <? }?>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  >&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" >&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff">&nbsp;</td>
  </tr>
  <tr >
    <td colspan="15" align="center" bordercolor="cccccc" bgcolor="#FFFF99"   >正码总额:<span class="STYLE1">
      <?=$zmzr?>
    </span></td>
  </tr>
</table>
<table   width="800" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1" bgcolor="cccccc" >
  <tr >
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
  </tr>
  <? for ($I=1; $I<=10; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sumzt1_color[$I-1]?>">
      <?=$sumzt1_tm[$I-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt1_mbl[$I-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt1_m[$I-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正1特&class3=<?=$sumzt1_tm[$I-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzt1_m[$I-1]?>
	</button>
        <? if ($sumzt1_m[$I-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt1_color[$I+10-1]?>">
      <?=$sumzt1_tm[$I+10-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt1_mbl[$I+10-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt1_m[$I+10-1]!=0 ){echo "<font color=ff0000>";}?>
      <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正1特&class3=<?=$sumzt1_tm[$I+10-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzt1_m[$I+10-1]?>
	</button>
        <? if ($sumzt1_m[$I+10-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><font color="<?=$sumzt1_color[$I+20-1]?>">
      <?=$sumzt1_tm[$I+20-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><?=$sumzt1_mbl[$I+20-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt1_m[$I+20-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正1特&class3=<?=$sumzt1_tm[$I+20-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzt1_m[$I+20-1]?>
	</button>
        <? if ($sumzt1_m[$I+20-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt1_color[$I+30-1]?>">
      <?=$sumzt1_tm[$I+30-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt1_mbl[$I+30-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt1_m[$I+30-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正1特&class3=<?=$sumzt1_tm[$I+30-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzt1_m[$I+30-1]?>
	</button>
        <? if ($sumzt1_m[$I+30-1]!=0 ){echo "</font>";}?></td>
    <? if ($I<=9 ){?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1" class="ballf_ff"><font color="<?=$sumzt1_color[$I+40-1]?>">
      <?=$sumzt1_tm[$I+40-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt1_mbl[$I+40-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt1_m[$I+40-1]!=0 ){echo "<font color=ff0000>";}?>
         <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正1特&class3=<?=$sumzt1_tm[$I+40-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzt1_m[$I+40-1]?>
	</button>
        <? if ($sumzt1_m[$I+40-1]!=0 ){echo "</font>";}?></td>
    <? }else{?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <? }?>
  </tr>
  <? }?>
  <? for ($I=1; $I<=2; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt1_color[$I+48]?>">
      <?=$sumzt1_tm[$I+48]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt1_mbl[$I+48]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt1_m[$I+48]!=0 ){echo "<font color=ff0000>";}?>
         <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正1特&class3=<?=$sumzt1_tm[$I+48]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzt1_m[$I+48]?>
	</button>
        <? if ($sumzt1_m[$I+48]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt1_color[$I+50]?>">
      <?=$sumzt1_tm[$I+50]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt1_mbl[$I+50]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt1_m[$I+50]!=0 ){echo "<font color=ff0000>";}?>
         <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正1特&class3=<?=$sumzt1_tm[$I+50]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzt1_m[$I+50]?>
	</button>
        <? if ($sumzt1_m[$I+50]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1"  ><font color="<?=$sumzt1_color[$I+52]?>">
      <?=$sumzt1_tm[$I+52]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt1_mbl[$I+52]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt1_m[$I+52]!=0 ){echo "<font color=ff0000>";}?>
         <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正1特&class3=<?=$sumzt1_tm[$I+52]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzt1_m[$I+52]?>
	</button>
        <? if ($sumzt1_m[$I+52]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt1_color[$I+54]?>">
      <?=$sumzt1_tm[$I+54]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt1_mbl[$I+54]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt1_m[$I+54]!=0 ){echo "<font color=ff0000>";}?>
         <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正1特&class3=<?=$sumzt1_tm[$I+54]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzt1_m[$I+54]?>
	</button>
        <? if ($sumzt1_m[$I+54]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt1_color[$I+56]?>">
      <?=$sumzt1_tm[$I+56]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt1_mbl[$I+56]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt1_m[$I+56]!=0 ){echo "<font color=ff0000>";}?>
      <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正1特&class3=<?=$sumzt1_tm[$I+56]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
	<?=$sumzt1_m[$I+56]?>
	</button>
        <? if ($sumzt1_m[$I+56]!=0 ){echo "</font>";}?></td>
  </tr>
  <? }?>
  <tr >
    <td colspan="15" align="center" bordercolor="cccccc" bgcolor="#FFFF99"   >正1特总额:<span class="STYLE1">
      <?=$zt1zr?>
    </span></td>
  </tr>
</table>
<table   width="800" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1" bgcolor="cccccc" >
  <tr >
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
  </tr>
  <? for ($I=1; $I<=10; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sumzt2_color[$I-1]?>">
      <?=$sumzt2_tm[$I-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt2_mbl[$I-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt2_m[$I-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正2特&class3=<?=$sumzt2_tm[$I-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt2_m[$I-1]?>
        </button>
      <? if ($sumzt2_m[$I-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt2_color[$I+10-1]?>">
      <?=$sumzt2_tm[$I+10-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt2_mbl[$I+10-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt2_m[$I+10-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正2特&class3=<?=$sumzt2_tm[$I+10-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt2_m[$I+10-1]?>
        </button>
      <? if ($sumzt2_m[$I+10-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><font color="<?=$sumzt2_color[$I+20-1]?>">
      <?=$sumzt2_tm[$I+20-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><?=$sumzt2_mbl[$I+20-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt2_m[$I+20-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正2特&class3=<?=$sumzt2_tm[$I+20-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt2_m[$I+20-1]?>
        </button>
      <? if ($sumzt2_m[$I+20-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt2_color[$I+30-1]?>">
      <?=$sumzt2_tm[$I+30-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt2_mbl[$I+30-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt2_m[$I+30-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正2特&class3=<?=$sumzt2_tm[$I+30-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt2_m[$I+30-1]?>
        </button>
      <? if ($sumzt2_m[$I+30-1]!=0 ){echo "</font>";}?></td>
    <? if ($I<=9 ){?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1" class="ballf_ff"><font color="<?=$sumzt2_color[$I+40-1]?>">
      <?=$sumzt2_tm[$I+40-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt2_mbl[$I+40-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt2_m[$I+40-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正2特&class3=<?=$sumzt2_tm[$I+40-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt2_m[$I+40-1]?>
        </button>
      <? if ($sumzt2_m[$I+40-1]!=0 ){echo "</font>";}?></td>
    <? }else{?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <? }?>
  </tr>
  <? }?>
  <? for ($I=1; $I<=2; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt2_color[$I+48]?>">
      <?=$sumzt2_tm[$I+48]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt2_mbl[$I+48]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt2_m[$I+48]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正2特&class3=<?=$sumzt2_tm[$I+48]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt2_m[$I+48]?>
        </button>
      <? if ($sumzt2_m[$I+48]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt2_color[$I+50]?>">
      <?=$sumzt2_tm[$I+50]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt2_mbl[$I+50]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt2_m[$I+50]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正2特&class3=<?=$sumzt2_tm[$I+50]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt2_m[$I+50]?>
        </button>
      <? if ($sumzt2_m[$I+50]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1"  ><font color="<?=$sumzt2_color[$I+52]?>">
      <?=$sumzt2_tm[$I+52]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt2_mbl[$I+52]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt2_m[$I+52]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正2特&class3=<?=$sumzt2_tm[$I+52]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt2_m[$I+52]?>
        </button>
      <? if ($sumzt2_m[$I+52]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt2_color[$I+54]?>">
      <?=$sumzt2_tm[$I+54]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt2_mbl[$I+54]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt2_m[$I+54]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正2特&class3=<?=$sumzt2_tm[$I+54]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt2_m[$I+54]?>
        </button>
      <? if ($sumzt2_m[$I+54]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt2_color[$I+56]?>">
      <?=$sumzt2_tm[$I+56]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt2_mbl[$I+56]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt2_m[$I+56]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正2特&class3=<?=$sumzt2_tm[$I+56]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt2_m[$I+56]?>
        </button>
      <? if ($sumzt2_m[$I+56]!=0 ){echo "</font>";}?></td>
  </tr>
  <? }?>
  <tr >
    <td colspan="15" align="center" bordercolor="cccccc" bgcolor="#FFFF99"   >正2特总额:<span class="STYLE1">
      <?=$zt2zr?>
    </span></td>
  </tr>
</table>
<table   width="800" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1" bgcolor="cccccc" >
  <tr >
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
  </tr>
  <? for ($I=1; $I<=10; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sumzt3_color[$I-1]?>">
      <?=$sumzt3_tm[$I-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt3_mbl[$I-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt3_m[$I-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正3特&class3=<?=$sumzt3_tm[$I-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt3_m[$I-1]?>
        </button>
      <? if ($sumzt3_m[$I-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt3_color[$I+10-1]?>">
      <?=$sumzt3_tm[$I+10-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt3_mbl[$I+10-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt3_m[$I+10-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正3特&class3=<?=$sumzt3_tm[$I+10-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt3_m[$I+10-1]?>
        </button>
      <? if ($sumzt3_m[$I+10-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><font color="<?=$sumzt3_color[$I+20-1]?>">
      <?=$sumzt3_tm[$I+20-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><?=$sumzt3_mbl[$I+20-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt3_m[$I+20-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正3特&class3=<?=$sumzt3_tm[$I+20-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt3_m[$I+20-1]?>
        </button>
      <? if ($sumzt3_m[$I+20-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt3_color[$I+30-1]?>">
      <?=$sumzt3_tm[$I+30-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt3_mbl[$I+30-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt3_m[$I+30-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正3特&class3=<?=$sumzt3_tm[$I+30-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt3_m[$I+30-1]?>
        </button>
      <? if ($sumzt3_m[$I+30-1]!=0 ){echo "</font>";}?></td>
    <? if ($I<=9 ){?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1" class="ballf_ff"><font color="<?=$sumzt3_color[$I+40-1]?>">
      <?=$sumzt3_tm[$I+40-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt3_mbl[$I+40-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt3_m[$I+40-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正3特&class3=<?=$sumzt3_tm[$I+40-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt3_m[$I+40-1]?>
        </button>
      <? if ($sumzt3_m[$I+40-1]!=0 ){echo "</font>";}?></td>
    <? }else{?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <? }?>
  </tr>
  <? }?>
  <? for ($I=1; $I<=2; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt3_color[$I+48]?>">
      <?=$sumzt3_tm[$I+48]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt3_mbl[$I+48]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt3_m[$I+48]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正3特&class3=<?=$sumzt3_tm[$I+48]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt3_m[$I+48]?>
        </button>
      <? if ($sumzt3_m[$I+48]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt3_color[$I+50]?>">
      <?=$sumzt3_tm[$I+50]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt3_mbl[$I+50]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt3_m[$I+50]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正3特&class3=<?=$sumzt3_tm[$I+50]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt3_m[$I+50]?>
        </button>
      <? if ($sumzt3_m[$I+50]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1"  ><font color="<?=$sumzt3_color[$I+52]?>">
      <?=$sumzt3_tm[$I+52]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt3_mbl[$I+52]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt3_m[$I+52]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正3特&class3=<?=$sumzt3_tm[$I+52]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt3_m[$I+52]?>
        </button>
      <? if ($sumzt3_m[$I+52]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt3_color[$I+54]?>">
      <?=$sumzt3_tm[$I+54]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt3_mbl[$I+54]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt3_m[$I+54]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正3特&class3=<?=$sumzt3_tm[$I+54]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt3_m[$I+54]?>
        </button>
      <? if ($sumzt3_m[$I+54]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt3_color[$I+56]?>">
      <?=$sumzt3_tm[$I+56]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt3_mbl[$I+56]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt3_m[$I+56]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正3特&class3=<?=$sumzt3_tm[$I+56]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt3_m[$I+56]?>
        </button>
      <? if ($sumzt3_m[$I+56]!=0 ){echo "</font>";}?></td>
  </tr>
  <? }?>
  <tr >
    <td colspan="15" align="center" bordercolor="cccccc" bgcolor="#FFFF99"   >正3特总额:<span class="STYLE1">
      <?=$zt3zr?>
    </span></td>
  </tr>
</table>
<table   width="800" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1" bgcolor="cccccc" >
  <tr >
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
  </tr>
  <? for ($I=1; $I<=10; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sumzt4_color[$I-1]?>">
      <?=$sumzt4_tm[$I-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt4_mbl[$I-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt4_m[$I-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正4特&class3=<?=$sumzt4_tm[$I-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt4_m[$I-1]?>
        </button>
      <? if ($sumzt4_m[$I-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt4_color[$I+10-1]?>">
      <?=$sumzt4_tm[$I+10-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt4_mbl[$I+10-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt4_m[$I+10-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正4特&class3=<?=$sumzt4_tm[$I+10-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt4_m[$I+10-1]?>
        </button>
      <? if ($sumzt4_m[$I+10-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><font color="<?=$sumzt4_color[$I+20-1]?>">
      <?=$sumzt4_tm[$I+20-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><?=$sumzt4_mbl[$I+20-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt4_m[$I+20-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正4特&class3=<?=$sumzt4_tm[$I+20-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt4_m[$I+20-1]?>
        </button>
      <? if ($sumzt4_m[$I+20-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt4_color[$I+30-1]?>">
      <?=$sumzt4_tm[$I+30-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt4_mbl[$I+30-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt4_m[$I+30-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正4特&class3=<?=$sumzt4_tm[$I+30-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt4_m[$I+30-1]?>
        </button>
      <? if ($sumzt4_m[$I+30-1]!=0 ){echo "</font>";}?></td>
    <? if ($I<=9 ){?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1" class="ballf_ff"><font color="<?=$sumzt4_color[$I+40-1]?>">
      <?=$sumzt4_tm[$I+40-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt4_mbl[$I+40-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt4_m[$I+40-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正4特&class3=<?=$sumzt4_tm[$I+40-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt4_m[$I+40-1]?>
        </button>
      <? if ($sumzt4_m[$I+40-1]!=0 ){echo "</font>";}?></td>
    <? }else{?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <? }?>
  </tr>
  <? }?>
  <? for ($I=1; $I<=2; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt4_color[$I+48]?>">
      <?=$sumzt4_tm[$I+48]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt4_mbl[$I+48]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt4_m[$I+48]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正4特&class3=<?=$sumzt4_tm[$I+48]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt4_m[$I+48]?>
        </button>
      <? if ($sumzt4_m[$I+48]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt4_color[$I+50]?>">
      <?=$sumzt4_tm[$I+50]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt4_mbl[$I+50]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt4_m[$I+50]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正4特&class3=<?=$sumzt4_tm[$I+50]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt4_m[$I+50]?>
        </button>
      <? if ($sumzt4_m[$I+50]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1"  ><font color="<?=$sumzt4_color[$I+52]?>">
      <?=$sumzt4_tm[$I+52]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt4_mbl[$I+52]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt4_m[$I+52]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正4特&class3=<?=$sumzt4_tm[$I+52]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt4_m[$I+52]?>
        </button>
      <? if ($sumzt4_m[$I+52]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt4_color[$I+54]?>">
      <?=$sumzt4_tm[$I+54]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt4_mbl[$I+54]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt4_m[$I+54]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正4特&class3=<?=$sumzt4_tm[$I+54]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt4_m[$I+54]?>
        </button>
      <? if ($sumzt4_m[$I+54]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt4_color[$I+56]?>">
      <?=$sumzt4_tm[$I+56]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt4_mbl[$I+56]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt4_m[$I+56]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正4特&class3=<?=$sumzt4_tm[$I+56]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt4_m[$I+56]?>
        </button>
      <? if ($sumzt4_m[$I+56]!=0 ){echo "</font>";}?></td>
  </tr>
  <? }?>
  <tr >
    <td colspan="15" align="center" bordercolor="cccccc" bgcolor="#FFFF99"   >正4特总额:<span class="STYLE1">
      <?=$zt4zr?>
    </span></td>
  </tr>
</table>
<table   width="800" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1" bgcolor="cccccc" >
  <tr >
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
  </tr>
  <? for ($I=1; $I<=10; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sumzt5_color[$I-1]?>">
      <?=$sumzt5_tm[$I-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt5_mbl[$I-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt5_m[$I-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正5特&class3=<?=$sumzt5_tm[$I-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt5_m[$I-1]?>
        </button>
      <? if ($sumzt5_m[$I-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt5_color[$I+10-1]?>">
      <?=$sumzt5_tm[$I+10-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt5_mbl[$I+10-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt5_m[$I+10-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正5特&class3=<?=$sumzt5_tm[$I+10-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt5_m[$I+10-1]?>
        </button>
      <? if ($sumzt5_m[$I+10-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><font color="<?=$sumzt5_color[$I+20-1]?>">
      <?=$sumzt5_tm[$I+20-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><?=$sumzt5_mbl[$I+20-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt5_m[$I+20-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正5特&class3=<?=$sumzt5_tm[$I+20-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt5_m[$I+20-1]?>
        </button>
      <? if ($sumzt5_m[$I+20-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt5_color[$I+30-1]?>">
      <?=$sumzt5_tm[$I+30-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt5_mbl[$I+30-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt5_m[$I+30-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正5特&class3=<?=$sumzt5_tm[$I+30-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt5_m[$I+30-1]?>
        </button>
      <? if ($sumzt5_m[$I+30-1]!=0 ){echo "</font>";}?></td>
    <? if ($I<=9 ){?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1" class="ballf_ff"><font color="<?=$sumzt5_color[$I+40-1]?>">
      <?=$sumzt5_tm[$I+40-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt5_mbl[$I+40-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt5_m[$I+40-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正5特&class3=<?=$sumzt5_tm[$I+40-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt5_m[$I+40-1]?>
        </button>
      <? if ($sumzt5_m[$I+40-1]!=0 ){echo "</font>";}?></td>
    <? }else{?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <? }?>
  </tr>
  <? }?>
  <? for ($I=1; $I<=2; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt5_color[$I+48]?>">
      <?=$sumzt5_tm[$I+48]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt5_mbl[$I+48]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt5_m[$I+48]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正5特&class3=<?=$sumzt5_tm[$I+48]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt5_m[$I+48]?>
        </button>
      <? if ($sumzt5_m[$I+48]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt5_color[$I+50]?>">
      <?=$sumzt5_tm[$I+50]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt5_mbl[$I+50]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt5_m[$I+50]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正5特&class3=<?=$sumzt5_tm[$I+50]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt5_m[$I+50]?>
        </button>
      <? if ($sumzt5_m[$I+50]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1"  ><font color="<?=$sumzt5_color[$I+52]?>">
      <?=$sumzt5_tm[$I+52]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt5_mbl[$I+52]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt5_m[$I+52]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正5特&class3=<?=$sumzt5_tm[$I+52]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt5_m[$I+52]?>
        </button>
      <? if ($sumzt5_m[$I+52]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt5_color[$I+54]?>">
      <?=$sumzt5_tm[$I+54]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt5_mbl[$I+54]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt5_m[$I+54]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正5特&class3=<?=$sumzt5_tm[$I+54]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt5_m[$I+54]?>
        </button>
      <? if ($sumzt5_m[$I+54]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt5_color[$I+56]?>">
      <?=$sumzt5_tm[$I+56]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt5_mbl[$I+56]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt5_m[$I+56]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正5特&class3=<?=$sumzt5_tm[$I+56]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt5_m[$I+56]?>
        </button>
      <? if ($sumzt5_m[$I+56]!=0 ){echo "</font>";}?></td>
  </tr>
  <? }?>
  <tr >
    <td colspan="15" align="center" bordercolor="cccccc" bgcolor="#FFFF99"   >正5特总额:<span class="STYLE1">
      <?=$zt5zr?>
    </span></td>
  </tr>
</table>
<table   width="800" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1" bgcolor="cccccc" >
  <tr >
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
  </tr>
  <? for ($I=1; $I<=10; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><font color="<?=$sumzt6_color[$I-1]?>">
      <?=$sumzt6_tm[$I-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt6_mbl[$I-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt6_m[$I-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正6特&class3=<?=$sumzt6_tm[$I-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt6_m[$I-1]?>
        </button>
      <? if ($sumzt6_m[$I-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt6_color[$I+10-1]?>">
      <?=$sumzt6_tm[$I+10-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt6_mbl[$I+10-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt6_m[$I+10-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正6特&class3=<?=$sumzt6_tm[$I+10-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt6_m[$I+10-1]?>
        </button>
      <? if ($sumzt6_m[$I+10-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><font color="<?=$sumzt6_color[$I+20-1]?>">
      <?=$sumzt6_tm[$I+20-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><?=$sumzt6_mbl[$I+20-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt6_m[$I+20-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正6特&class3=<?=$sumzt6_tm[$I+20-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt6_m[$I+20-1]?>
        </button>
      <? if ($sumzt6_m[$I+20-1]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><font color="<?=$sumzt6_color[$I+30-1]?>">
      <?=$sumzt6_tm[$I+30-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt6_mbl[$I+30-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt6_m[$I+30-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正6特&class3=<?=$sumzt6_tm[$I+30-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt6_m[$I+30-1]?>
        </button>
      <? if ($sumzt6_m[$I+30-1]!=0 ){echo "</font>";}?></td>
    <? if ($I<=9 ){?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1" class="ballf_ff"><font color="<?=$sumzt6_color[$I+40-1]?>">
      <?=$sumzt6_tm[$I+40-1]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$sumzt6_mbl[$I+40-1]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><? if ($sumzt6_m[$I+40-1]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正6特&class3=<?=$sumzt6_tm[$I+40-1]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt6_m[$I+40-1]?>
        </button>
      <? if ($sumzt6_m[$I+40-1]!=0 ){echo "</font>";}?></td>
    <? }else{?>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF">&nbsp;</td>
    <? }?>
  </tr>
  <? }?>
  <? for ($I=1; $I<=2; $I=$I+1)
{

?>
  <tr >
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt6_color[$I+48]?>">
      <?=$sumzt6_tm[$I+48]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt6_mbl[$I+48]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt6_m[$I+48]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正6特&class3=<?=$sumzt6_tm[$I+48]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt6_m[$I+48]?>
        </button>
      <? if ($sumzt6_m[$I+48]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt6_color[$I+50]?>">
      <?=$sumzt6_tm[$I+50]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt6_mbl[$I+50]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt6_m[$I+50]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正6特&class3=<?=$sumzt6_tm[$I+50]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt6_m[$I+50]?>
        </button>
      <? if ($sumzt6_m[$I+50]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc" bgcolor="#F1F1F1"  ><font color="<?=$sumzt6_color[$I+52]?>">
      <?=$sumzt6_tm[$I+52]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt6_mbl[$I+52]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt6_m[$I+52]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正6特&class3=<?=$sumzt6_tm[$I+52]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt6_m[$I+52]?>
        </button>
      <? if ($sumzt6_m[$I+52]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt6_color[$I+54]?>">
      <?=$sumzt6_tm[$I+54]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt6_mbl[$I+54]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt6_m[$I+54]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正6特&class3=<?=$sumzt6_tm[$I+54]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt6_m[$I+54]?>
        </button>
      <? if ($sumzt6_m[$I+54]!=0 ){echo "</font>";}?></td>
    <td align="center" bordercolor="cccccc"  bgcolor="#F1F1F1"  ><font color="<?=$sumzt6_color[$I+56]?>">
      <?=$sumzt6_tm[$I+56]?>
    </font></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><?=$sumzt6_mbl[$I+56]?></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><? if ($sumzt6_m[$I+56]!=0 ){echo "<font color=ff0000>";}?>
        <button class="headtd3"  onmouseover="this.className='headtd3';window.status='特码';" onClick="ops('index.php?action=look1&amp;kithe=<?=$kithe?>&username=<?=$_GET['username']?>&amp;lx=0&amp;id=3&amp;class2=正6特&class3=<?=$sumzt6_tm[$I+56]?>',400,700)" onMouseOut="this.className='headtd4';window.status='特码';return" >
        <?=$sumzt6_m[$I+56]?>
        </button>
      <? if ($sumzt6_m[$I+56]!=0 ){echo "</font>";}?></td>
  </tr>
  <? }?>
  <tr >
    <td colspan="15" align="center" bordercolor="cccccc" bgcolor="#FFFF99"   >正6特总额:<span class="STYLE1">
      <?=$zt6zr?>
    </span></td>
  </tr>
</table>
