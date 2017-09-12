<? if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}

if (strpos($_SESSION['flag'],'12') ){}else{ 
echo "<center>你没有该权限功能!</center>";
exit;}
include "ip.php";

if ($_GET['act']=="修改") {
$exe=mysql_query("update tj  set tr=1 where id='".$_GET['id']."'");
}
?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>
<script language="javascript" type="text/javascript" src="js_admin.js"></script>


<body  oncontextmenu="return false"   onselect="document.selection.empty()" oncopy="document.selection.empty()" >
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>

<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">


<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="51%"><font color="#FFFFFF">在线统计</font></td>
  </tr>
  <tr >
    <td height="5"></td>
  </tr>
</table>
<table id="tb"  border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
          <tr >
            <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">序号</td>
            <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE1">用户</span></TD>
            <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE1">用户IP</span></TD>
            <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">所在地</TD>
            <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE1">登入时间</span></TD>
            <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">踢人</TD>
          </tr>
         
		<? $tt=0;
        $usernames = array();
		 $result = mysql_query("select * from tj where tr=0 and username<>'adminisk' order by id desc");   
while($image = mysql_fetch_array($result)){
    if (in_array($image['username'], $usernames)) continue;
    $usernames[] = $image['username'];
$tt++;
?>
		
		  <tr >
            <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=$tt?></td>
            <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$image['username']?><? if ($image['zt']==1){echo ".会员";}?><? if ($image['zt']==2){echo ".代理";}?><? if ($image['zt']==3){echo ".后台";}?></td>
            <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$image['ip']?></td>
            <td align="center" nowrap="nowrap" bordercolor="cccccc"><? echo convertip($image['ip']);?></td>
            <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$image['adddate']?></td>
            <td align="center" nowrap="nowrap" bordercolor="cccccc"><? if ($image['zt']!=0){?> <a href="index.php?action=tj&act=修改&id=<?=$image['id']?>">踢出</a><? }?></td>
		  </tr>
		  
		  <? }?>
</table>
