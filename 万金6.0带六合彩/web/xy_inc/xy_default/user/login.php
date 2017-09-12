<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->display('inc_skin_lr.php',0,'用户登录'); ?>
</head>

<body id="bg">
<div class="denglu1">
<div class="wjlogo"><a href="#" title=""><img src="/skin/images/logo.png"></a></div>
<form action="/index.php/user/logined" method="post" onajax="userBeforeLogin" enter="true" call="userLogin" target="ajax">

  <ul>
   <li><span>用户名：</span><input name="username" type="text" id="username" value="" class="text1" /></li>
   <li><span>密　码：</span><input name="password" type="password"  id="password" value="" class="text2" /></li>
   <li><span>验证码：</span><input name="vcode" type="text" id="vcode" class="text3" /><img width="89" height="32" border="0" style="cursor:pointer;" align="absmiddle" src="/index.php/user/vcode/<?=$this->time?>" title="看不清楚，换一张图片" onclick="this.src='/index.php/user/vcode/'+(new Date()).getTime()"/></li>
  </ul>
  <b><a href="#" onclick="$(this).closest('form').submit();return false;">登陆</a></b>
  </form>
</div>
</body>
</html>