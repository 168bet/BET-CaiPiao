<?
if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}
if ($_GET['id']!=""){$ids=$_GET['ids'];}else{

  echo "<script>alert('�Ƿ�����!');window.history.go(-1);</script>"; 
  exit;
}

//�޸���Ϣ
if ($_GET['act']=="���") {

if (empty($_POST['username'])) {
       
  echo "<script>alert('�û�����Ϊ��!');window.history.go(-1);</script>"; 
  exit;
    }
	
	

	
	$flag22=$_POST['flag22'];
	$flag221="";
	$isgl=0;
for ($I=0; $I<count($flag22); $I=$I+1)
{if($flag22[$I]==13)$isgl=1;
$flag221=$flag221.",".$flag22[$I];}

	 $pass = md5($_POST['pass']);
	 if ($_POST['pass']!=""){
	 $sql="update  ka_admin set password='".$pass."' where id=".$_GET['id'];
	 $exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");}
	 
 $sql="update  ka_admin set flag='".$flag221."',admin='".$isgl."' where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("���ݿ��޸ĳ���");

	


	echo "<script>alert('�û��޸ĳɹ�!');window.location.href='index.php?action=editadmin&id=".$_GET['id']."';</script>"; 
exit;
}
	

$result=mysql_query("select * from ka_admin where id=".$_GET['id']." order by id desc LIMIT 1"); 
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
<table width="99%"  border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="f1f1f1">
 <form name="form1" method="post" action="index.php?action=editadmin&act=���&id=<?=$_GET['id']?>"> <tr>
    <td height="30" colspan="2" bordercolor="cccccc" bgcolor="#FDF4CA">�޸ĺ�̨�û�</td>
    </tr>
  <tr>
    <td width="16%" height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">�û�����</td>
    <td width="84%" bordercolor="cccccc"><input name="username" class="input1"  type="text" id="username" value="<?=$row['username']?>" />    </td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">���룺</td>
    <td bordercolor="cccccc"><input name="pass"  class="input1" type="password" id="pass" />
        <span class="forumRow"><span class="style2">(���벻�޸�������)</span></span></td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">��¼������</td>
    <td bordercolor="cccccc"><?=$row['look']?>
      ��</td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">Ȩ�ޣ�</td>
    <td bordercolor="cccccc"><table border="0" cellpadding="3" cellspacing="3">
      <tr>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='01' <? if (strpos($row['flag'],'01')){ echo "checked=checked";}?>>
          �̿ڹ���</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='02' <? if (strpos($row['flag'],'02')){ echo "checked=checked";}?>>
          ��������</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='03' <? if (strpos($row['flag'],'03')){ echo "checked=checked";}?>>
          ��ʱע��</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='04' <? if (strpos($row['flag'],'04')){ echo "checked=checked";}?>>
          �߷�</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='05' <? if (strpos($row['flag'],'05')){ echo "checked=checked";}?>>
          �ɶ�</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='06' <? if (strpos($row['flag'],'06')){ echo "checked=checked";}?>>
          �ܴ�</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='07' <? if (strpos($row['flag'],'07')){ echo "checked=checked";}?>>
          ����</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='08' <? if (strpos($row['flag'],'08')){ echo "checked=checked";}?>>
          ��Ա</td>
      </tr>
      <tr>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='09' <? if (strpos($row['flag'],'09')){ echo "checked=checked";}?>>
          ����</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='10' <? if (strpos($row['flag'],'10')){ echo "checked=checked";}?>>
          ϵͳά��</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='11' <? if (strpos($row['flag'],'11')){ echo "checked=checked";}?>>
          ע����ѯ</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='12' <? if (strpos($row['flag'],'12')){ echo "checked=checked";}?>>
          ����ͳ��</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='13' <? if (strpos($row['flag'],'13')){ echo "checked=checked";}?>>
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
      <button onclick="javascript:location.href='index.php?action=editadmin'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22";><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle" />����</button> <button onclick="submit();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" width="16" height="16" align="absmiddle" />�����Ա</button> <button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle" />ˢ��</button>
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
    <td height="35"><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> ������ʾ�����޸����������ա�</div></td>
  </tr>
</table>
</div>
