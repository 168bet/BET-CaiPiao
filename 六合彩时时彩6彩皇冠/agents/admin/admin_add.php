<?
if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}

//�޸���Ϣ
if ($_GET['act']=="���") {

if (empty($_POST['username'])) {
       
  echo "<script>alert('�û�����Ϊ��!');window.history.go(-1);</script>"; 
  exit;
    }
if (empty($_POST['pass'])){
  echo "<script>alert('���벻��Ϊ�˿�!');window.history.go(-1);</script>"; 
  exit;
    }

$flag22=$_POST['flag22'];
	$flag221="";
for ($I=0; $I<count($flag22); $I=$I+1)
{
$flag221=$flag221.",".$flag22[$I];}


$result=mysql_query("select * from ka_admin where username='".$_POST['username']."'   order by id"); 
$row11=mysql_fetch_array($result);
if ($row11!=""){
 echo "<script>alert('�Բ�����һ�û��Ѵ��ڣ�����������!');window.history.go(-1);</script>"; 
  exit;
exit;

}
 $pass = md5($_POST['pass']);




	
	$sql="INSERT INTO  ka_admin set username='".$_POST['username']."',password='".$pass."',look=0,flag='".$flag221."'";
	
$exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");
	


	echo "<script>alert('�û���ӳɹ�!');window.location.href='index.php?action=admin_add';</script>"; 
exit;
}
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
	for (var i=0;i<document.form1.flag22.length;i++) {
		var e=document.form1.flag22[i];
		e.checked=!e.checked;
	}
}
function SelectAllAdm() {
	for (var i=0;i<document.form1.flag22.length;i++) {
		var e=document.form1.flag22[i];
		e.checked=!e.checked;
	}
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="91%"><? require_once '2top.php';?></td>
    <td width="9%"><div align="right">
      <button onclick="javascript:location.href='index.php?action=admin_add'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" />����û�</button>
    </div></td>
  </tr>
  <tr >
    <td height="5" colspan="2"></td>
  </tr>
</table>
<table width="99%"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="f1f1f1">
 <form name="form1" method="post" action="index.php?action=admin_add&act=���"> <tr>
    <td height="30" colspan="2" bordercolor="cccccc" bgcolor="#FDF4CA">��Ӻ�̨�û�</td>
    </tr>
  <tr>
    <td width="16%" height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">�û�����</td>
    <td width="84%" bordercolor="cccccc"><input name="username" type="text" class="input1"  id="username" /></td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">���룺</td>
    <td bordercolor="cccccc"><input name="pass" type="password" class="input1"  id="pass" />
        <span class="forumRow"></span></td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">Ȩ�ޣ�</td>
    <td bordercolor="cccccc"><table border="0" cellpadding="3" cellspacing="3">
      <tr>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='01' checked="checked" />
        �̿ڹ���</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='02' checked="checked" />
          ��������</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='03' checked="checked" />
          ��ʱע��</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='04' checked="checked" />
          �߷�</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='05' checked="checked" />
          �ɶ�</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='06' checked="checked" />
          �ܴ�</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='07' checked="checked" />
          ����</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='08' checked="checked" />
          ��Ա</td>
        </tr>
      <tr>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='09' checked="checked" />
          ����</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='10' checked="checked" />
          ϵͳά��</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='11' checked="checked" />
          ע����ѯ</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='12' checked="checked" />
          ����ͳ��</td>
        <td class="forumRow"><input name='flag22[]2' type='checkbox' value='13' checked="checked" />
��̨����</td>
        <td class="forumRow">&nbsp;</td>
        <td class="forumRow">&nbsp;</td>
        <td class="forumRow">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
    <td bordercolor="cccccc"><br />
        <table width="100" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="6"></td>
          </tr>
        </table>
      <button onclick="javascript:location.href='index.php?action=admin_add'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22";><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle" />����</button><button onclick="submit();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" width="16" height="16" align="absmiddle" />�����Ա</button><button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle" />ˢ��</button>
      <br />
        <table width="100" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10"></td>
          </tr>
      </table></td>
  </tr>  </form>
</table>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div align="left"> </div></td>
    <td height="35"><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> ������ʾ��������ǳ�����Ա�벻Ҫѡ��</div></td>
  </tr>
</table>
</div>
