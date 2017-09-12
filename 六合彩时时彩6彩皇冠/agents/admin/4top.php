<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25"><font color="#FFFFFF">
&nbsp;<a href="#" onClick="javascript:location.href='index.php?action=right';"><font color=ffffff>网站设置</font></a>
<?php
if($_SESSION['stadmin666']==1){
?>
┊<a href="#" onClick="javascript:location.href='index.php?action=admin_main';"><font color=ffffff>后台管理</font></a>
<?php
}
?>
┊<a href="#" onClick="javascript:location.href='index.php?action=xt_abcd';"><font color=ffffff>会员盘赔率相差设置</font></a>
┊<a href="#" onClick="javascript:location.href='index.php?action=xt_stds';"><font color=ffffff>自动降水</font></a>
┊<a href="#" onClick="javascript:location.href='index.php?action=xt_nn';"><font color=ffffff>单期限额</font></a>
┊<a href="#" onClick="javascript:location.href='index.php?action=xt_ds';"><font color=ffffff>退水默认设置</font></a>
┊<a href="#" onClick="javascript:location.href='index.php?action=xt_copy';"><font color=ffffff>数据备份</font></a>
┊<a href="#" onClick="javascript:location.href='index.php?action=xt_bak';"><font color=ffffff>数据还原</font></a>
┊<a href="#" onClick="javascript:location.href='index.php?action=ka_del';"><font color=ffffff>清除数据</font></a>
┊<a href="#" onClick="javascript:location.href='index.php?action=ka_xxx';"><font color=ffffff>还原信用额</font></a>
┊<a href="#" onClick="javascript:location.href='index.php?action=sm';"><font color=ffffff>规则说明</font></a>
┊<a href="#" onClick="javascript:location.href='index.php?action=xt_kk';"><font color=ffffff>开奖日期</font></a>
</font></td>
  </tr>
</table>
