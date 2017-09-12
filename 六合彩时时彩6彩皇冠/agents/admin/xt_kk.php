<? if(!defined('PHPYOU')) {
	exit('非法进入');
}


if ($_GET['save']=="save") {

$exe=mysql_query("Update config Set a2='".$_POST['a2']."' where id=1");

print "<script language='javascript'>alert('修改成功！');window.location.href='index.php?action=xt_kk';</script>";
exit();
}?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<style type="text/css">
<!--
.STYLE2 {color: #FF0000}
-->
</style><noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<body >

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
  <table   border="1" align="center" cellspacing="1" cellpadding="2" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
   <form name=form1 action=index.php?action=xt_kk&save=save method=post> <tr >
      <td width="26%" height="28" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">开奖日期</span></td>
      <td width="74%" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" ><span class="STYLE2">内容</span></td>
    </tr>
    <tr>
      <td align="center" bordercolor="cccccc">开奖日期</td>
      <td bordercolor="cccccc"><TEXTAREA id=a2 name=a2 rows=20 cols=90><?=ka_config('a2')?>
  </TEXTAREA></td>
    </tr>
    
    <tr>
      <td align="center" bordercolor="cccccc">&nbsp;</td>
      <td height="30" bordercolor="cccccc"><button onClick="javascript:location.href='index.php?action=sm'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22";><img src="images/icon_21x21_info.gif" align="absmiddle" />重填</button>
          <button onClick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" align="absmiddle" />确认修改</button>
      <button onClick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button></td>
    </tr></form >
  </table>
  <br>

