<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}


//修改信息
if ($_GET['act']=="添加") {


if (empty($_POST['pass'])){
  echo "<script>alert('密码不能为了空!');window.history.go(-1);</script>"; 
  exit;
    }
if ($_POST['pass']!=$_POST['pass2']){
  echo "<script>alert('你输入的两次密码不一样!');window.history.go(-1);</script>"; 
  exit;
    }
	
	 $pass = md5($_POST['pass']);
	 $sql="update  ka_admin set password='".$pass."' where username='".$_SESSION['jxadmin666']."'";
	
$exe=mysql_query($sql) or  die("数据库修改出错");
	


	echo "<script>alert('用户修改成功!');window.location.href='index.php?action=modify_pass';</script>"; 
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
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
<form name="form1" method="post" action="index.php?action=modify_pass&act=添加">
    <tr> 
      <td valign="top"><fieldset>
      <legend>后台用户修改</legend> 
      <br>
        <div align="center"> 
          <table border="1" align="center" cellspacing="0" cellpadding="5" bordercolor="888888" bordercolordark="#FFFFFF" width="98%">
            <tr> 
              <td> 
                <div align="right"></div>
                <div align="right">
				 <button onClick="javascript:location.href='index.php?action=admin_main'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle">用户管理</button>              
  &nbsp;<button onClick="javascript:location.href='index.php?action=admin_add'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle">添加用户</button>              

                </div>
              </td>
            </tr>
          </table>
          <br>
          <table border="1" align="center" cellspacing="0" cellpadding="5" bordercolor="888888" bordercolordark="#FFFFFF" width="98%">
            <tr> 
              <td> 
                <div align="left">
				
				
                  <table width="100%"  border="0" cellspacing="2" cellpadding="2">
                    <tr>
                      <td width="16%" height="30" align="right">用户名：</td>
                      <td width="84%"><?=$_SESSION['jxadmin666']?></td>
                    </tr>
                    <tr>
                      <td height="30" align="right">密码：</td>
                      <td><input name="pass" type="password" id="pass">
                        <span class="forumRow"></span></td>
                    </tr>
                    <tr>
                      <td height="30" align="right">在次输入密码：</td>
                      <td><input name="pass2" type="password" id="pass2"></td>
                    </tr>
                    <tr>
                      <td height="30">&nbsp;</td>
                      <td><br>
                        <table width="100" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td height="6"></td>
                          </tr>
                        </table>
                                         <button onClick="javascript:location.href='index.php?action=modify_pass&act=main'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22";><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle">重填</button>
                                         &nbsp;<button onClick="submit();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" width="16" height="16" align="absmiddle">保存会员</button>
                                      &nbsp;<button onClick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" width="16" height="16" align="absmiddle">刷新</button>
                        <br>
                        <table width="100" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td height="10"></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
</div>
                
              </td>
            </tr>
          </table>
          <br>
          <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr> 
              <td> 
                <div align="left"> </div>
              </td>
              <td> 
                <div align="right" disabled><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle"> 
                  操作提示：如果修改密码,输入的两个密码必须一样。</div>
              </td>
            </tr>
          </table>
          <table width="100" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td height="10"></td>
            </tr>
          </table> 
        </div></fieldset>
      </td>
    </tr>
  </form></table>

</div>