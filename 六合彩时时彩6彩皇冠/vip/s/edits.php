<?php
require_once 'conjunction.php';
require_once 'config.php';
if (ka_config("opwww")==1){
echo "<script>alert('对不起,系统维护中!');top.location.href='op.php';</script>"; 
exit;}
if(!defined('PHPYOU')) {
	exit('非法进入');
}



//修改信息
if ($_GET['act']=="添加") {


if (empty($_POST['kapassword'])) {
       
  echo "<script>alert('密码不能为空!');window.history.go(-1);</script>"; 
  exit;
    }
	

	
if ($_POST['kapassword']!=$_POST['kapassword1']){
echo "<script>alert('两次密码不一样!');window.history.go(-1);</script>"; 
  exit;
}

  $pass = md5($_POST['kapassword']);
  $sql="update  ka_mem set kapassword='".$pass."' where id='".$_GET['id']."'  order by id desc";	
$exe=mysql_query($sql) or  die("数据库修改出错");





	







echo "<script>alert('密码修改成功!');window.location.href='look.php';</script>"; 
exit;
	
	
	}
	
	
	
	
$result2=mysql_query("select *  from ka_mem where  id=".ka_memuser("id")." order by id"); 
$row2=mysql_fetch_array($result2);
	
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
.STYLE3 {	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script src="inc/forms.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="10"></td>
  </tr>
</table>
  <table width="400"  border="1" cellpadding="2" cellspacing="1" bordercolor="f1f1f1">
 <form name=testFrm onSubmit="return SubChk()" method="post" action="?action=edit&act=添加&id=<?=$row2['id']?>"> 
   <tr>
     <td height="30" colspan="2" align="left" bordercolor="#CCCCCC" bgcolor="#FDF4CA">第一次登录请先修改密码</td>
     </tr>
   <tr>
    <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">用户名：</td>
    <td bordercolor="#CCCCCC"><font color="ff6600">
      <?=$row2['kauser']?>
      <input name="danid" type="hidden" value="<?=$row2['danid']?>" />
    </font></td>
    </tr>
   <tr>
     <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">新密码：</td>
     <td nowrap="nowrap" bordercolor="#CCCCCC"><input name="kapassword" type="password" class="input1"  id="kapassword" /></td>
   </tr>
  <tr>
    <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">确认密码：</td>
    <td nowrap="nowrap" bordercolor="#CCCCCC"><input name="kapassword1" type="password" class="input1"  id="kapassword1" /></td>
    </tr>
  
  <tr>
    <td height="30" colspan="2" align="center" bordercolor="#CCCCCC"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="6"></td>
      </tr>
    </table>
      <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="修改密码" />
      <br />
      <table width="100" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="10"></td>
        </tr>
      </table></td>
  </tr>
  </form>
</table>
</div>
