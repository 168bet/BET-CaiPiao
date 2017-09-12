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




?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>
<script language="javascript" type="text/javascript" src="js_admin.js"></script>






<style type="text/css">
<!--
.STYLE2 {font-weight: bold}
.STYLE3 {
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
<table   border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
  <tr>
    <td width="83%" height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><table width="600" border="0" align="left" cellpadding="2" cellspacing="1">
      <tr>
        <td width="160" nowrap>打印统计[
          <?=$kithe?>期]</td>
        <td width="14" align="right" nowrap>&nbsp;</td>
        <td width="63" align="right" nowrap>选择期数： </td>
        <td width="36" nowrap><SELECT class=zaselect_ste name=temppid onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}">
          <?
		$result = mysql_query("select * from ka_kithe order by nn desc");   
while($image = mysql_fetch_array($result)){
			     echo "<OPTION value=index.php?action=dy&kithe=".$image['nn'];
				 if ($kithe!="") {
				 if ($kithe==$image['nn']) {
				  echo " selected=selected ";
				  }				
				}
				 echo ">第".$image['nn']."期</OPTION>";
			  }
		?>
        </SELECT></td>
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
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="10"><table width="600" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="f1f1f1">
      <tr>
        <td width="120" height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" style="BORDER-bottom: #E0E0E0 1px solid;BORDER-right: #E0E0E0 1px solid;BORDER-left: solid  #E0E0E0 1px ;BORDER-top: solid  #E0E0E0 1px ;">股东/占成</td>
        <td width="120" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" style="BORDER-bottom: #E0E0E0 1px solid;BORDER-right: #E0E0E0 1px solid;BORDER-top: solid  #E0E0E0 1px ;">总代/占成</td>
        <td width="120" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" style="BORDER-bottom: #E0E0E0 1px solid;BORDER-right: #E0E0E0 1px solid;BORDER-top: solid  #E0E0E0 1px ;">代理/占成</td>
        <td width="120" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" style="BORDER-bottom: #E0E0E0 1px solid;BORDER-right: #E0E0E0 1px solid;BORDER-top: solid  #E0E0E0 1px ;">会员</td>
        <td width="120" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" style="BORDER-bottom: #E0E0E0 1px solid;BORDER-right: #E0E0E0 1px solid;BORDER-top: solid  #E0E0E0 1px ;">总额</td>
      </tr>
      <?
		



$result = mysql_query("select distinct(guan)   from   ka_tan where kithe='".$kithe."'  order by guan desc");   
$ii=0;
$v1=mysql_num_rows($result);
while($rs = mysql_fetch_array($result)){



$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(sum_m*dagu_zc/10) as dagu_zc,sum(sum_m*guan_zc/10) as guan_zc,sum(sum_m*zong_zc/10) as zong_zc,sum(sum_m*dai_zc/10) as dai_zc from ka_tan   where kithe='".$kithe."' and guan='".$rs['guan']."'");

$Rs5 = mysql_fetch_array($result1);


$ii++;

?>
      <tr>
        <td width="120" height="25" align="center" bordercolor="cccccc" style="BORDER-bottom: #E0E0E0 1px solid;BORDER-right: solid  #E0E0E0 1px ;BORDER-left: solid  #E0E0E0 1px ;"><?=$rs['guan']?>
          /
            <font color="#FF0000"><?=$Rs5['guan_zc']?></font></td>
			
			
        <td colspan="4" align="center" bordercolor="cccccc" style="BORDER-bottom:solid  #E0E0E0 1px ;">
		
		<table border="0" cellspacing="0" cellpadding="0">
          
		  <? $result1 = mysql_query("select distinct(zong)   from   ka_tan where kithe='".$kithe."'  and guan='".$rs['guan']."' order by guan desc");   
$ii=0;
$v=mysql_num_rows($result1);
while($rs1= mysql_fetch_array($result1)){



$r1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(sum_m*dagu_zc/10) as dagu_zc,sum(sum_m*zong_zc/10) as guan_zc,sum(sum_m*zong_zc/10) as zong_zc,sum(sum_m*dai_zc/10) as dai_zc from ka_tan   where kithe='".$kithe."'  and zong='".$rs1['zong']."'");
$I=0;
$Rs6 = mysql_fetch_array($r1);
$I=I+1;
?><tr>
            <td width="119" height="25" align="center" style="<? if ($I<$v) {?>BORDER-bottom: #E0E0E0 1px solid;<? }?>BORDER-right: #E0E0E0 1px solid;"><?=$rs1['zong']?>/<font color="#FF0000"><?=$Rs6['guan_zc']?></font></td>
            <td align="center" <? if ($I<$v) {?>style="BORDER-bottom: #E0E0E0 1px solid;"<? }?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
			   <? $r5 = mysql_query("select distinct(dai)   from   ka_tan where kithe='".$kithe."'  and zong='".$rs1['zong']."' order by guan desc");   
$ii=0;
$II=0;
$vv=mysql_num_rows($r5);
while($rs2= mysql_fetch_array($r5)){
$II=$II=1;



$r2 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(sum_m*dagu_zc/10) as dagu_zc,sum(sum_m*dai_zc/10) as guan_zc,sum(sum_m*zong_zc/10) as zong_zc,sum(sum_m*dai_zc/10) as dai_zc from ka_tan   where kithe='".$kithe."'  and dai='".$rs2['dai']."'");

$Rs7 = mysql_fetch_array($r2);?><tr>
                <td width="119" height="25" align="center" style="<? if ($II<$vv) {?>BORDER-bottom: #E0E0E0 1px solid;<? }?>BORDER-right: #E0E0E0 1px solid;"><?=$rs2['dai']?>/<font color="#FF0000"><?=$Rs7['guan_zc']?></font></td>
                <td width="240"><table width="100%" border="0" cellspacing="0" cellpadding="0" <? if ($II<$vv) {?>style="BORDER-bottom: #E0E0E0 1px solid;"<? }?>>
                  <? $r6 = mysql_query("select distinct(username)  from   ka_tan where kithe='".$kithe."'  and dai='".$rs2['dai']."' order by guan desc");   
$ii=0;
$III=0;
$vvv=mysql_num_rows($r6);

while($rs3= mysql_fetch_array($r6)){

$III=$III+1;

$r8 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(sum_m*dagu_zc/10) as dagu_zc,sum(sum_m*dai_zc/10) as guan_zc,sum(sum_m*zong_zc/10) as zong_zc,sum(sum_m*dai_zc/10) as dai_zc from ka_tan   where kithe='".$kithe."'  and username='".$rs3['username']."'");

$Rs8 = mysql_fetch_array($r8);?>
				  <tr>
                    <td width="120" height="25" align="center" style="<? if ($III<$vvv) {?>BORDER-bottom: #E0E0E0 1px solid;<? }?>BORDER-right: #E0E0E0 1px solid;"><a href="index.php?action=e1&kithe=<?=$kithe?>&username=<?=$rs3['username']?>" target="_blank" >
                      <?=$rs3['username']?>
                      </a></td>
                    <td width="120" align="center" style="<? if ($III<$vvv) {?>BORDER-bottom: #E0E0E0 1px solid;<? }?>BORDER-right: #E0E0E0 1px solid;"><?=$Rs8['sum_m']?></td>
                  </tr>
				  <? }?>
                </table></td>
                </tr>
				<? }?>
            </table></td>
            </tr>
		  <? }?>
        </table></td>
		   
        </tr>
      <? }?>
    </table></td>
  </tr>
</table>

