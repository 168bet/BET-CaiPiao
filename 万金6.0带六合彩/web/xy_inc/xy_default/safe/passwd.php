<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '会员中心－密码管理'); ?>
</head>
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
 <div class="title"><span>密码管理</span></div>
 <div class="body">
 <div class="mima1">
 	<form action="/index.php/safe/setPasswd" method="post" target="ajax" onajax="safeBeforSetPwd" call="safeSetPwd">
 	<h2>登陆密码管理：</h2>
    <ul>
     <li><span>原始密码：</span><input type="password" name="oldpassword" class="text4" /></li>
     <li><span>新密码：</span><input type="password" name="newpassword" class="text4" /></li>
     <li><span>确认密码：</span><input type="password"  class="text4 confirm" /></li>
     <li class="tijiao"><input id="setpass" class="an" type="submit" value="修改密码" ><input type="reset" id="resetpass" class="an" value="重置" onClick="this.form.reset()" /></li>
    </ul>
    </form>
</div>
  <?php if($args[0]){ ?>
  <div class="mima1">		
  	<form action="/index.php/safe/setCoinPwd2" method="post" target="ajax" onajax="safeBeforSetCoinPwd2" call="safeSetPwd">
 	<h2>资金密码管理：</h2>
    <ul>
     <li><span>原始密码：</span><input type="password"  name="oldpassword" class="text4" /></li>
     <li><span>新密码：</span><input type="password" name="newpassword" class="text4" /></li>
     <li><span>确认密码：</span><input type="password" class="text4 confirm" /></li>
     <li class="tijiao"><input id="setcoinP2" class="an" type="submit" value="修改密码" ><input type="reset" id="resetcoinP2" class="an" value="重置" onClick="this.form.reset()" /></li>
    </ul>
    </form>
</div>	
<?php }else{?>
<div class="mima1">
 	<form action="/index.php/safe/setCoinPwd" method="post" target="ajax" onajax="safeBeforSetCoinPwd" call="safeSetPwd">
 	<h2>资金密码管理：</h2>
    <ul>
     <li><span>密码：</span><input type="password" name="newpassword" class="text4" /></li>
     <li><span>确认密码：</span><input type="password" class="text4 confirm" /></li>
     <li class="tijiao"><input id="setcoinP" class="an" type="submit" value="修改密码" ><input type="reset" id="resetcoinP" class="an" value="重置" onClick="this.form.reset()" /></li>
    </ul>
    </form>
</div> 
<?php }?>
<div class="bank"></div>
</div>
<div class="foot"></div>
</div>
<?php $this->display('inc_footer.php'); ?> 
</body>
</html>