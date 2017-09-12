<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}

	
	


if ($_GET['save']=="save") {
	
	for ($i=1;$i<=49;$i=$i+1){
	
	$xr=$_POST['Num_'.$i];
	$class3=$_POST['class3_'.$i];
$exe=mysql_query("update ka_bl set xr=".$xr." where class2='特A' and  class3='".$class3."'");
$exe=mysql_query("update ka_bl set xr=".$xr." where class2='特B' and  class3='".$class3."'");

}
print "<script language='javascript'>alert('设置成功！');window.location.href='index.php?action=xt_nn';</script>";
exit();

}










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


function quick0()
{
	var mm = document.all.money.value;
	
	
	for (var i=1; i<50; i++) {
	
				document.all["Num_"+i].value = mm;
			
		}
		
	

	
	
}

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

<? $result=mysql_query("Select xr, class3 from ka_bl where class2='特A' order by ID");
$drop_table = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
//echo $image['class3'];
array_push($drop_table,$image);

}
?>
  <table   border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
    
	   <form name=form1 action=index.php?action=xt_nn&save=save method=post> <tr >
      <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">限额</td>
      <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">限额</td>
      <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">限额</td>
      <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">限额</td>
      <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
      <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">限额</td>
    </tr>
    <?

for ($I=1; $I<=10; $I=$I+1)
{

	
	?>
    <tr>
      <td height="25" align="center" bordercolor="cccccc"><img src="images/num<?=$I?>.gif" /></td>
      <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="8" value="<?=$drop_table[$I-1][0]?>" name="Num_<?=$I?>" />
      <input name="class3_<?=$I?>" value="<?=$drop_table[$I-1][1]?>" type="hidden"></td>
      <td height="25" align="center" bordercolor="cccccc"><img src="images/num<?=$I+10?>.gif" /></td>
      <td height="25" align="center" bordercolor="cccccc"><input      style="HEIGHT: 18px"  class="input1" maxlength="6" size="8" value="<?=$drop_table[$I+10-1][0]?>" name="Num_<?=$I+10?>" />
      <input name="class3_<?=$I+10?>" value="<?=$drop_table[$I+10-1][1]?>" type="hidden"></td>
      <td height="25" align="center" bordercolor="cccccc"><img src="images/num<?=$I+20?>.gif" /></td>
      <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="8" value="<?=$drop_table[$I+20-1][0]?>" name="Num_<?=$I+20?>" />
      <input name="class3_<?=$I+20?>" value="<?=$drop_table[$I+20-1][1]?>" type="hidden"></td>
      <td height="25" align="center" bordercolor="cccccc"><img src="images/num<?=$I+30?>.gif" /></td>
      <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="8" value="<?=$drop_table[$I+30-1][0]?>" name="Num_<?=$I+30?>" />
      <input name="class3_<?=$I+30?>" value="<?=$drop_table[$I+30-1][1]?>" type="hidden"></td>
      <? if ($I!=10){?>
      <td height="25" align="center" bordercolor="cccccc"><img src="images/num<?=$I+40?>.gif" /></td>
      <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="8" value="<?=$drop_table[$I+40-1][0]?>" name="Num_<?=$I+40?>" />
      <input name="class3_<?=$I+40?>" value="<?=$drop_table[$I+40-1][1]?>" type="hidden"></td>
      <? }else{ ?>
      <td height="25" align="center" bordercolor="cccccc">&nbsp;</td>
      <td height="25" align="center" bordercolor="cccccc">&nbsp;</td>
      <? }?>
    </tr>
    <? }?>

    <tr>
      <td height="25" colspan="12" align="center" bordercolor="cccccc">&nbsp;<font color="ff0000">统计修改</font>
          <input class="input1" size="4" name="money" />
        &nbsp;
      <input name="button2" class="button_c" type="button" onclick="quick0()" value="轉送" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" align="absmiddle" />确认修改</button>
      <button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button></td>
    </tr>
		</form>
  </table>
  
