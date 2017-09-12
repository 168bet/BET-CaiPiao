<?
if(!defined('PHPYOU')) {
	exit('非法进入');
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
	
	


if ($_GET['save']=="save") {
	
	
	
 
 
//股东设置

$ygid=$_POST['ygid'];
$yg=$_POST['m'];
$ygb=$_POST['ygb'];
$ygc=$_POST['ygc'];
$ygd=$_POST['ygd'];
$xx=$_POST['mm'];
$xxx=$_POST['mmm'];

for ($I=0; $I<=count($ygid); $I=$I+1)
{

$exe=mysql_query("Update ka_guands Set yg='".$yg[$I]."',ygb='".$ygb[$I]."',ygc='".$ygc[$I]."',ygd='".$ygd[$I]."',xx='".$xx[$I]."',xxx='".$xxx[$I]."' where ID=".$ygid[$I]);

} 

print "<script language='javascript'>alert('设置成功！');window.location.href='index.php?action=xt_ds';</script>";
exit();

}








$result=mysql_query("Select ID,drop_sort,drop_value,drop_unit,low_drop from ka_drop order by ID");
$drop_table = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
array_push($drop_table,$image);

}

$drop_count=$y-1;


 ?>

	

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<style type="text/css">
<!--
.STYLE2 {color: #FF0000}
-->
</style>

<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="51%"><? require_once '2top.php';?></td>
  </tr>
  <tr >
    <td height="5"></td>
  </tr>
</table>
 <? if (strpos($_SESSION['flag'],'10') ){}else{ 
echo "<center>你没有该权限功能!</center>";
exit;}?>

  <table width="99%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="f1f1f1">
   <form name=form1 action=index.php?action=xt_ds&save=save method=post> <tr>
      <td width="90" height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">类型</span> </td>
      <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">佣金%A</td>
      <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" >佣金%B</td>
      <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" >佣金%C</td>
      <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" >佣金%D</td>
      <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" >单注限额</td>
      <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" >单项(号)限额</td>
    </tr>
    <?  $t=0;
				 $result=mysql_query("select * from  ka_guands where lx=0 and style='六合彩' order by id"); 
while($rst = mysql_fetch_array($result)){
    if ($rst['ds'] == "五行") continue;
$t++;?>
    <tr>
      <td height="20" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><?=$rst['ds']?>
          <input name="ds[]" type="hidden" id="ds[]" value="<?=$rst['ds']?>" />
      <input name="ygid[]" type="hidden" id="ygid[]" value="<?=$rst['id']?>" /></td>
      <td align="center" bordercolor="cccccc"><input name="m[]" class="input1" id="m[]" value='<?=$rst['yg']?>' size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="ygb[]" class="input1" id="mm[]" value='<?=$rst['ygb']?>' size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="ygc[]" class="input1" id="ygc[]" value='<?=$rst['ygc']?>' size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="ygd[]" class="input1" id="ygd[]" value='<?=$rst['ygd']?>' size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="mm[]" class="input1" id="mm[]" value='<?=$rst['xx']?>' size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="mmm[]" class="input1" id="mmm[]" value='<?=$rst['xxx']?>' size="10" /></td>
    </tr>
    
    <? }?>
	<tr>
      <td height="20" colspan="7" align="center" bordercolor="cccccc"><button onclick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" align="absmiddle" />确认修改</button>
      <button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button></td>
    </tr>  </form >
</table>

