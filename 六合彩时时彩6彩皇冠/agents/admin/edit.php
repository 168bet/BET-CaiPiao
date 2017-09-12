<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}


//修改信息
if ($_GET['act']=="添加") {


	
	



	 $pass = md5($_POST['pass']);
	 if ($_POST['pass']!=""){
	 $sql="update  ka_admin set password='".$pass."' where username='".$_SESSION['jxadmin666']."'";
	 $exe=mysql_query($sql) or  die("数据库修改出错");}

	


	echo "<script>alert('用户修改成功!');window.location.href='index.php?action=edit&id=".$_GET['id']."';</script>"; 
exit;
}
	

$result=mysql_query("select * from ka_admin where username='".$_SESSION['jxadmin666']."' order by id desc LIMIT 1"); 
$row=mysql_fetch_array($result);	

?>



<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script language="JavaScript" src="tip.js"></script>
<style type="text/css">
<!--
.style1 {
	color: #666666;
	font-weight: bold;
}
.style2 {color: #FF0000}
-->
</style>
<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script src="inc/forms.js"></script>
<script language="JavaScript" type="text/JavaScript">
function SelectAllPub() {
	for (var i=0;i<document.form1.flag.length;i++) {
		var e=document.form1.flag[i];
		e.checked=!e.checked;
	}
}
function SelectAllAdm() {
	for (var i=0;i<document.form1.flag.length;i++) {
		var e=document.form1.flag[i];
		e.checked=!e.checked;
	}
}
</script>
<table width="99%"  border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="f1f1f1">
 <form name="form1" method="post" action="index.php?action=edit&act=添加&id=<?=$_GET['id']?>"> <tr>
    <td height="30" colspan="2" bordercolor="cccccc" bgcolor="#FDF4CA">修改后台用户密码</td>
    </tr>
  <tr>
    <td width="16%" height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">用户名：</td>
    <td width="84%" bordercolor="cccccc"><?=$row['username']?></td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">密码：</td>
    <td bordercolor="cccccc"><input name="pass"  class="input1" type="password" id="pass" /></td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">登录次数：</td>
    <td bordercolor="cccccc"><?=$row['look']?>
      次</td>
  </tr>
  
  <tr>
    <td height="30" bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
    <td bordercolor="cccccc"><br />
        <table width="100" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="6"></td>
          </tr>
        </table>
      <button onclick="javascript:location.href='index.php?action=edit'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22";><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle" />重填</button> <button onclick="submit();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" width="16" height="16" align="absmiddle" />保存会员</button> <button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle" />刷新</button>
      <br />
        <table width="100" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10"></td>
          </tr>
      </table></td>
  </tr>
</table>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div align="left"> </div></td>
    <td height="35"><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> 操作提示：不修改密码请留空。</div></td>
  </tr>
</table>
</div>
