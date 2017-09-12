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

<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="10"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3"></td>
  </tr>
</table>
<table   border="1" align="center" cellspacing="1" cellpadding="2" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
   <form name=form1 action=index.php?action=xt_kk&save=save method=post> <tr >
      <td width="26%" height="28" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">开奖日期</span></td>
      </tr>
    
    <tr>
      <td height="30" bordercolor="cccccc"><?=ka_config('a2')?></td>
    </tr></form >
</table>
  <br>

