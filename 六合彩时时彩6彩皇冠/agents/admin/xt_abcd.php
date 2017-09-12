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
	
	
	
	$exe=mysql_query("Update config Set btm='".$_POST['btm']."',ctm='".$_POST['ctm']."',dtm='".$_POST['dtm']."',btmdx='".$_POST['btmdx']."',ctmdx='".$_POST['ctmdx']."',dtmdx='".$_POST['dtmdx']."',bzt='".$_POST['bzt']."',czt='".$_POST['czt']."',dzt='".$_POST['dzt']."',bztdx='".$_POST['bztdx']."',cztdx='".$_POST['cztdx']."',dztdx='".$_POST['dztdx']."',bzm='".$_POST['bzm']."',czm='".$_POST['czm']."',dzm='".$_POST['dzm']."',bzmdx='".$_POST['bzmdx']."',czmdx='".$_POST['czmdx']."',dzmdx='".$_POST['dzmdx']."',bzm6='".$_POST['bzm6']."',czm6='".$_POST['czm6']."',dzm6='".$_POST['dzm6']."',bbb='".$_POST['bbb']."',cbb='".$_POST['cbb']."',dbb='".$_POST['dbb']."',bsx='".$_POST['bsx']."',csx='".$_POST['csx']."',dsx='".$_POST['dsx']."',bsx6='".$_POST['bsx6']."',csx6='".$_POST['csx6']."',dsx6='".$_POST['dsx6']."',bsxp='".$_POST['bsxp']."',csxp='".$_POST['csxp']."',dsxp='".$_POST['dsxp']."',bth='".$_POST['bth']."',cth='".$_POST['cth']."',dth='".$_POST['dth']."',bzx='".$_POST['bzx']."',czx='".$_POST['czx']."',dzx='".$_POST['dzx']."',blx='".$_POST['blx']."',clx='".$_POST['clx']."',dlx='".$_POST['dlx']."' where id=1");

print "<script language='javascript'>alert('设置成功！');window.location.href='index.php?action=xt_abcd';</script>";
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
   <form name=form1 action=index.php?action=xt_abcd&save=save method=post> <tr >
      <td width="8%" height="25" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">项目</span></td>
      <td width="32%" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" >B盘</td>
      <td width="30%" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">C盘</span></td>
      <td width="30%" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" ><span class="STYLE2">D盘</span></td>
    </tr>
    <tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">特码</span></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc">码
        <input name="btm" type="text" id="btm" value="<?=$btm?>" size="8" />
        双面
      <input name="btmdx" type="text" id="btmdx" value="<?=$btmdx?>" size="8" /></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc">码
        <input name="ctm" type="text" id="ctm" value="<?=$ctm?>" size="10" />
        双面
      <input name="ctmdx" type="text" id="ctmdx" value="<?=$ctmdx?>" size="10" /></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc">码
        <input name="dtm" type="text" id="dtm" value="<?=$dtm?>" size="10" />
        双面
      <input name="dtmdx" type="text" id="dtmdx" value="<?=$dtmdx?>" size="10" /></td>
    </tr>
    <tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">正特</span></td>
      <td align="center" bordercolor="cccccc">码
        <input name="bzt" type="text" id="bzt" value="<?=$bzt?>" size="8" />
        双面
      <input name="bztdx" type="text" id="bztdx" value="<?=$bztdx?>" size="8" /></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc">码
        <input name="czt" type="text" id="czt" value="<?=$czt?>" size="10" />
        双面
      <input name="cztdx" type="text" id="cztdx" value="<?=$cztdx?>" size="10" /></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc">码
        <input name="dzt" type="text" id="dzt" value="<?=$dzt?>" size="10" />
        双面
      <input name="dztdx" type="text" id="dztdx" value="<?=$dztdx?>" size="10" /></td>
    </tr>
    <tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">正码</span></td>
      <td align="center" bordercolor="cccccc">码
        <input name="bzm" type="text" id="bzm" value="<?=$bzm?>" size="8" />
        双面
      <input name="bzmdx" type="text" id="bztdx" value="<?=$bzmdx?>" size="8" /></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc">码
        <input name="czm" type="text" id="czt" value="<?=$czm?>" size="10" />
        双面
      <input name="czmdx" type="text" id="cztdx" value="<?=$czmdx?>" size="10" /></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc">码
        <input name="dzm" type="text" id="dzt" value="<?=$dzm?>" size="10" />
        双面
      <input name="dzmdx" type="text" id="dztdx" value="<?=$dzmdx?>" size="10" /></td>
    </tr>
    <tr>
      <td height="25" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">五行</span></td>
      <td align="center" bordercolor="cccccc"><input name="bzm6" type="text" id="bzm6" value="<?=$bzm6?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="czm6" type="text" id="czm6" value="<?=$czm6?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="dzm6" type="text" id="dzm6" value="<?=$dzm6?>" size="10" /></td>
    </tr>
    <tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">半波</span></td>
      <td align="center" bordercolor="cccccc"><input name="bbb" type="text" id="bbb" value="<?=$bbb?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="cbb" type="text" id="cbb" value="<?=$cbb?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="dbb" type="text" id="dbb" value="<?=$dbb?>" size="10" /></td>
    </tr>
    <tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">特肖</span></td>
      <td align="center" bordercolor="cccccc"><input name="bsx" type="text" id="bsx" value="<?=$bsx?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="csx" type="text" id="csx" value="<?=$csx?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="dsx" type="text" id="dsx" value="<?=$dsx?>" size="10" /></td>
    </tr>
    <tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">六肖</span></td>
      <td align="center" bordercolor="cccccc"><input name="bsx6" type="text" id="bsx6" value="<?=$bsx6?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="csx6" type="text" id="csx6" value="<?=$csx6?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="dsx6" type="text" id="dsx6" value="<?=$dsx6?>" size="10" /></td>
    </tr>
    <tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">一肖</span></td>
      <td align="center" bordercolor="cccccc"><input name="bsxp" type="text" id="bsxp" value="<?=$bsxp?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="csxp" type="text" id="csxp" value="<?=$csxp?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="dsxp" type="text" id="dsxp" value="<?=$dsxp?>" size="10" /></td>
    </tr>
	<tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">半半波</span></td>
      <td align="center" bordercolor="cccccc"><input name="bth" type="text" id="bth" value="<?=$bth?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="cth" type="text" id="cth" value="<?=$cth?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="dth" type="text" id="dth" value="<?=$dth?>" size="10" /></td>
    </tr>
    <tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">全不中</span></td>
      <td align="center" bordercolor="cccccc"><input name="bzx" type="text" id="bzx" value="<?=$bzx?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="czx" type="text" id="czx" value="<?=$czx?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="dzx" type="text" id="dzx" value="<?=$dzx?>" size="10" /></td>
    </tr>
    <tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">生肖连</span></td>
      <td align="center" bordercolor="cccccc"><input name="blx" type="text" id="blx" value="<?=$blx?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="clx" type="clx" id="clx" value="<?=$clx?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="dlx" type="dlx" id="dlx" value="<?=$dlx?>" size="10" /></td>
    </tr>
	<!--<tr>
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">半半波</span></td>
      <td align="center" bordercolor="cccccc"><input name="bsxp" type="text" id="bsxp" value="<?=$bthdx?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="csxp" type="text" id="csxp" value="<?=$cthdx?>" size="10" /></td>
      <td align="center" bordercolor="cccccc"><input name="dsxp" type="text" id="dsxp" value="<?=$dthdx?>" size="10" /></td>
    </tr>-->
    <tr>
      <td height="25" colspan="4" align="center" bordercolor="cccccc">
          <button onclick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" align="absmiddle" />确认修改</button>
      <button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button></td>
    </tr></form >
</table>

