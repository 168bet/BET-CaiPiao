<?php 

define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/cheCookie.php';
if ($user[0]['g_look'] == 2) exit(back($UserOut));
markPos("前台-修改密码-us");
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$aPwd = sha1($_POST['VIP_PWD_old']);
	$bPwd = sha1($_POST['VIP_PWD']);
	$cPwd = $_POST['VIP_PWD1'];
	$db = new DB();
	$sql = "SELECT `g_name` FROM `g_user` WHERE `g_password` = '{$aPwd}' and `g_name` = '{$user[0]['g_name']}' LIMIT 1 ";
	if (!$db->query($sql, 0)) exit(showAlert("原密碼错误!!!"));
	$sql = "UPDATE `g_user` SET `g_password` = '{$bPwd}' , g_pwd=0  WHERE `g_name` = '{$user[0]['g_name']}' ";
	if ($db->query($sql, 2))
	{
		showAlert_href("密碼更變成功，請從新登陸!!!", "quit.php");
		exit;
	}
}


if(isset($_GET['loadhtml']) && $_GET['loadhtml']==true)
{
?>
<DIV class=mains_corll>
<DIV id=rightLoader dom="right">
<DIV id=change_password class=dataArea>

<FORM method="post" name="uppwd_form" action="UpPwd.php" target="orderFrame">
<TABLE class=t1 width="100%">

<COLGROUP>
<COL class=col_single>
<COL></COLGROUP>
<THEAD>
<TR>
<TH colSpan=2>修改密码 </TH></TR></THEAD>
<TBODY>
<TR>
<TD height=28 width="30%">
<DIV class="t blueness">旧密码</DIV></TD>
<TD>
<DIV class=form><INPUT id=oldpassword class=input_t value="" maxLength=16 type=password name=VIP_PWD_old> <SPAN class=g-vd-status></SPAN></DIV></TD></TR>
<TR>
<TD height=28>
<DIV class="t blueness">新密码</DIV></TD>
<TD>
<DIV class=form><INPUT id=newpassword class=input_t value="" maxLength=16 type=password name=VIP_PWD> <SPAN class=g-vd-status></SPAN></DIV></TD></TR>
<TR>
<TD height=28>
<DIV class="t blueness">确认密码</DIV></TD>
<TD>
<DIV class=form><INPUT id=renewpassword class=input_t value="" maxLength=16 type=password name=VIP_PWD1> <SPAN class=g-vd-status></SPAN></DIV></TD></TR></TBODY></TABLE></FORM><SPAN class=blank></SPAN>
<DIV style="PADDING-BOTTOM: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 15px" class=align-c><A id=submit class="btn_m elem_btn" href="javascript:void(0)" type=button jQuery1387600939400="1">确 定</A> <A id=reset class="btn_m elem_btn" href="javascript:void(0)" type=reset value="取消" jQuery1387600939400="2">重置</A></DIV></DIV></DIV></DIV>
<?php
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"   >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/jquery.js"></script>
<script language="javascript">
var win = window.parent.document;
$('#submit',win).bind('click',function(){  
var oldpassword = $('#oldpassword',win).val();  
var newpassword = $('#newpassword',win).val(); 
 var renewpassword = $('#renewpassword',win).val();  
 if(oldpassword==''){   
 $('#oldpassword',win).next().addClass('g-vd-s-error');   
 $('#oldpassword',win)[0].focus();  
  return false;  
  }else{  
   $('#oldpassword',win).next().removeClass('g-vd-s-error'); 
    } 
	 if(newpassword==''){  
	  $('#newpassword',win).next().addClass('g-vd-s-error');  
	   $('#newpassword',win)[0].focus();  
	    return false; 
		 }else{  
		 $('#newpassword',win).next().removeClass('g-vd-s-error');  
		 } 
		  if(renewpassword==''){  
		   $('#renewpassword',win).next().addClass('g-vd-s-error');   
		   $('#renewpassword',win)[0].focus();   
		   return false;  
		   }else{  
		    $('#renewpassword',win).next().removeClass('g-vd-s-error'); 
			 }  
			 if(renewpassword!=newpassword){  
			  parent.showAlert("兩次密碼輸入不一致"); 
			   }else{  
			    parent.document.forms['uppwd_form'].submit();  
				}
				 }) 
				 $('#reset',win).bind('click',function(){ 
				  parent.document.forms['uppwd_form'].reset(); 
				  })
				  </script>
</head>
<body>
</body>
</html>
<?php }?>
