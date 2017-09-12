<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}
if ($_GET['id']!=""){$ids=$_GET['ids'];}else{

  echo "<script>alert('非法进入!');window.history.go(-1);</script>"; 
  exit;
}

//修改信息
if ($_GET['act']=="添加") {

if (empty($_POST['username'])) {
       
  echo "<script>alert('用户不能为空!');window.history.go(-1);</script>"; 
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
	 $exe=mysql_query($sql) or  die("数据库修改出错");}
	 
 $sql="update  ka_admin set flag='".$flag221."',admin='".$isgl."' where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错");

	


	echo "<script>alert('用户修改成功!');window.location.href='index.php?action=editadmin&id=".$_GET['id']."';</script>"; 
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
      <button onclick="javascript:location.href='index.php?action=admin_add'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle" />添加用户</button>
    </div></td>
  </tr>
  <tr >
    <td height="5" colspan="2"></td>
  </tr>
</table>
<table width="99%"  border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="f1f1f1">
 <form name="form1" method="post" action="index.php?action=editadmin&act=添加&id=<?=$_GET['id']?>"> <tr>
    <td height="30" colspan="2" bordercolor="cccccc" bgcolor="#FDF4CA">修改后台用户</td>
    </tr>
  <tr>
    <td width="16%" height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">用户名：</td>
    <td width="84%" bordercolor="cccccc"><input name="username" class="input1"  type="text" id="username" value="<?=$row['username']?>" />    </td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">密码：</td>
    <td bordercolor="cccccc"><input name="pass"  class="input1" type="password" id="pass" />
        <span class="forumRow"><span class="style2">(密码不修改请留空)</span></span></td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">登录次数：</td>
    <td bordercolor="cccccc"><?=$row['look']?>
      次</td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">权限：</td>
    <td bordercolor="cccccc"><table border="0" cellpadding="3" cellspacing="3">
      <tr>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='01' <? if (strpos($row['flag'],'01')){ echo "checked=checked";}?>>
          盘口管理</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='02' <? if (strpos($row['flag'],'02')){ echo "checked=checked";}?>>
          赔率设置</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='03' <? if (strpos($row['flag'],'03')){ echo "checked=checked";}?>>
          即时注单</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='04' <? if (strpos($row['flag'],'04')){ echo "checked=checked";}?>>
          走飞</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='05' <? if (strpos($row['flag'],'05')){ echo "checked=checked";}?>>
          股东</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='06' <? if (strpos($row['flag'],'06')){ echo "checked=checked";}?>>
          总代</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='07' <? if (strpos($row['flag'],'07')){ echo "checked=checked";}?>>
          代理</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='08' <? if (strpos($row['flag'],'08')){ echo "checked=checked";}?>>
          会员</td>
      </tr>
      <tr>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='09' <? if (strpos($row['flag'],'09')){ echo "checked=checked";}?>>
          报表</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='10' <? if (strpos($row['flag'],'10')){ echo "checked=checked";}?>>
          系统维护</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='11' <? if (strpos($row['flag'],'11')){ echo "checked=checked";}?>>
          注单查询</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='12' <? if (strpos($row['flag'],'12')){ echo "checked=checked";}?>>
          在线统计</td>
        <td class="forumRow"><input name='flag22[]' type='checkbox' value='13' <? if (strpos($row['flag'],'13')){ echo "checked=checked";}?>>
          后台管理</td>
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
      <button onclick="javascript:location.href='index.php?action=editadmin'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22";><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle" />重填</button> <button onclick="submit();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" width="16" height="16" align="absmiddle" />保存会员</button> <button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle" />刷新</button>
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
