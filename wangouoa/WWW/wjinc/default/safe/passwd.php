<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '会员中心－密码管理'); ?>

</head> 
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
	
    <div class="display biao-cont">
    	<form action="/index.php/safe/setPasswd" method="post" target="ajax" onajax="safeBeforSetPwd" call="safeSetPwd">
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>

    <tr height=25 class='table_b_th'>
      <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>登录密码管理</td> 
    </tr>
    <tr height=25 class='table_b_tr_b'>
      <td align="right" width="25%" style="font-weight:bold;">原始密码：</td>
      <td align="left" width="75%"><input type="password" name="oldpassword" /></td> 
    </tr> 
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">新密码：</td>
      <td align="left" ><input type="password" name="newpassword" /></td> 
    </tr> 
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">确认新密码：</td>
      <td align="left" ><input type="password"   class="confirm"/></td> 
    </tr>  
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;"></td>
      <td align="left"><input type="button" id='put_button_pass' class="btn" value="修改密码" onclick="$(this).closest('form').submit()" > 
        <input type="reset" value="重置" onClick="this.form.reset()"  class="btn"/> </td> 
    </tr> 

</table>
</form> 

		
<?php if($args[0]){ ?>
<form action="/index.php/safe/setCoinPwd2" method="post" target="ajax" onajax="safeBeforSetCoinPwd2" call="safeSetPwd">
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
    <tr class='table_b_th'>
      <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>资金密码管理</td> 
    </tr>
    <tr height=25 class='table_b_tr_b'>
      <td align="right" width="25%" style="font-weight:bold;">原始密码：</td>
      <td align="left" width="75%"><input type="password" name="oldpassword"  /></td> 
    </tr> 
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">新密码：</td>
      <td align="left" ><input type="password" name="newpassword"  /></td> 
    </tr> 
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">确认密码：</td>
      <td align="left" ><input type="password" class="confirm"  /></td> 
    </tr>  
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;"></td>
      <td align="left"><input type="button" id='put_button_pass' class="btn" value="修改密码"  onclick="$(this).closest('form').submit()"> 
        <input type="reset" value="重置" onClick="this.form.reset()"  class="btn"/> </td> 
    </tr> 
</table> 
</form>
<?php }else{?>
<form action="/index.php/safe/setCoinPwd" method="post" target="ajax" onajax="safeBeforSetCoinPwd" call="safeSetPwd">
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
    <tr class='table_b_th'>
      <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>设置资金密码</td> 
    </tr>
    <tr height=25 class='table_b_tr_b'>
      <td align="right" width="25%" style="font-weight:bold;"><font color=#777777>温馨提示：</font></td>
      <td align="left" width="75%"><div class='font_line_2'>资金密码：提款、充值、还有积分兑换等都要求必须输入资金密码！</div></td> 
    </tr> 
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">密码：</td>
      <td align="left" ><input type="password" name="newpassword"  /></td> 
    </tr> 
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;">确认密码：</td>
      <td align="left" ><input type="password" class="confirm"/></td> 
    </tr>  
    <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;"></td>
      <td align="left"><input type="button" id='put_button_pass' class="btn" value="设置密码"  onclick="$(this).closest('form').submit()"> 
        <input type="reset" value="重置" onClick="this.form.reset()"  class="btn"/> </td> 
    </tr> 
</table> 
</form>
<?php }?>

		
    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 