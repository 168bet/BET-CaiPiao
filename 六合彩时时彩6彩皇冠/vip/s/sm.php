<? if(!defined('PHPYOU')) {
	exit('非法进入');
}


if ($_GET['save']=="save") {

$exe=mysql_query("Update config Set a1='".$_POST['a1']."',a3='".$_POST['a3']."' where id=1");

print "<script language='javascript'>alert('修改成功！');window.location.href='index.php?action=sm';</script>";
exit();
}?>

<link href="imgs/main_n1.css" rel="stylesheet" type="text/css">
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
<table border="0" cellpadding="0" cellspacing="0" width="650">
        <tr>
            <td align="left" colspan="2" height="29">
                <strong class="words_color_blue_a">规则说明</strong></td>
            <td width="1">
            </td>
        </tr>
        <tr>
            <td width="15">&nbsp;
                </td>
            <td width="650">
<?=ka_config('a1')?>
                        </td>
                    </tr>
        
    </table>
</body>
</html>