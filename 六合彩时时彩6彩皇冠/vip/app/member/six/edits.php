<?php
require_once 'conjunction.php';
require_once 'config.php';
if (ka_config("opwww")==1){
echo "<script>alert('�Բ���,ϵͳά����!');top.location.href='op.php';</script>"; 
exit;}
if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}



//�޸���Ϣ
if ($_GET['act']=="���") {


if (empty($_POST['kapassword'])) {
       
  echo "<script>alert('���벻��Ϊ��!');window.history.go(-1);</script>"; 
  exit;
    }
	

	
if ($_POST['kapassword']!=$_POST['kapassword1']){
echo "<script>alert('�������벻һ��!');window.history.go(-1);</script>"; 
  exit;
}

  $pass = md5($_POST['kapassword']);
  $sql="update  ka_mem set kapassword='".$pass."' where id='".$_GET['id']."'  order by id desc";	
$exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");





	







echo "<script>alert('�����޸ĳɹ�!');window.location.href='look.php';</script>"; 
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
 <form name=testFrm onSubmit="return SubChk()" method="post" action="?action=edit&act=���&id=<?=$row2['id']?>"> 
   <tr>
     <td height="30" colspan="2" align="left" bordercolor="#CCCCCC" bgcolor="#FDF4CA">��һ�ε�¼�����޸�����</td>
     </tr>
   <tr>
    <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">�û�����</td>
    <td bordercolor="#CCCCCC"><font color="ff6600">
      <?=$row2['kauser']?>
      <input name="danid" type="hidden" value="<?=$row2['danid']?>" />
    </font></td>
    </tr>
   <tr>
     <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">�����룺</td>
     <td nowrap="nowrap" bordercolor="#CCCCCC"><input name="kapassword" type="password" class="input1"  id="kapassword" /></td>
   </tr>
  <tr>
    <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">ȷ�����룺</td>
    <td nowrap="nowrap" bordercolor="#CCCCCC"><input name="kapassword1" type="password" class="input1"  id="kapassword1" /></td>
    </tr>
  
  <tr>
    <td height="30" colspan="2" align="center" bordercolor="#CCCCCC"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="6"></td>
      </tr>
    </table>
      <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="�޸�����" />
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
