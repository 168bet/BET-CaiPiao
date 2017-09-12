<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="IE=EmulateIE8" http-equiv="X-UA-Compatible" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新用户注册－丽都娱乐平台</title>
<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="/skin/css/wjstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/skin/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/skin/js/onload.js"></script>
<script type="text/javascript" src="/skin/js/reglogin.js"></script>
<script type="text/javascript">window.onerror=function(){return true;}</script><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style type="text/css">
<!--
.service-tel {
    font-size:13px; 
    font-family:'微软雅黑';
    color: #fff;
    float: left;
    padding: 7px 0 0 10px;
}
.service-tel span {
    background-image: url("/skin/images/flag.jpg");
    background-repeat: no-repeat;
    display: inline-block;
    height: 21px;
    margin-right: 10px;
    vertical-align: middle;
    width: 32px;
}
.flag-img {
    background-position: left top;
}
.service-tel span {
    background-image: url("/skin/images/flag.jpg");
    background-repeat: no-repeat;
    display: inline-block;
    height: 21px;
    margin-right: 10px;
    vertical-align: middle;
    width: 32px;
}
.flag-img-se {
    background-position: left bottom;
    margin-left: 5px;
}
-->
</style></head>
<body id="bg">
<div class="zhuce">
 <div class="wjlogo" style="width:auto; height:auto;"><div class="flashlogo" style="margin-top:5px;"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="280" height="68">
  <param name="movie" value="/logo.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
  <embed src="/logo.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="280" height="68" wmode="transparent"></embed>
</object></div></div>
 <div class="zhucel">
  <p>　　客户端下载 - 为了保障用户利益，本平台特些声明如下：<br />　　请广大用户认准本娱乐平台唯一验证地址：<a href="http://tsinghuaren.net" style="color:#FF0000;text-decoration:underline;">tsinghuaren.net</a>  以免造成不必要的损失。</p>
  <!--b><a href="/down/" target="_blank">客户端下载</a></b-->
 </div>
 <div class="zhucer">
        <?php if($args[0]){ ?>
 <form action="/index.php/user/reg" method="post" onajax="registerBeforSubmit" enter="true" call="registerSubmit" target="ajax">
			<input type="hidden" name="codec" value="<?=$args[0]?>" />
  <ul>
   <li><span>用户名：</span><input type="text" onKeyUp="value=value.replace(/[\W]/g,'')" maxLength=15 name="username" id="username" value="" class="text1" /></li>
   <li><span>密码：</span><input type="password" onKeyUp="value=value.replace(/[\W]/g,'')" maxLength=13 name="password" id="password"  value="" class="text1" /></li>
   <li><span>确认密码：</span><input type="password" onKeyUp="value=value.replace(/[\W]/g,'')" maxLength=13 name="cpasswd"  id="cpasswd" value="" class="text1" /></li>
   <li><span>Q  Q：</span><input type="text" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9]/,'');}).call(this)" onblur="this.v();" maxLength=11 name="qq" id="qq"  value="" class="text1" /></li>
   <li><span>验证码：</span><input name="vcode"  onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9]/,'');}).call(this)" onblur="this.v();" maxLength=4 type="text" id="vcode" class="text2" /><img width="89" height="32" border="0" style="cursor:pointer;" align="absmiddle" src="/index.php/user/vcode/<?=$this->time?>" title="看不清楚，换一张图片" onclick="this.src='/index.php/user/vcode/'+(new Date()).getTime()"/></li>
  </ul>
  <b><a href="#" onclick="$(this).closest('form').submit()">注册</a></b>
  </form>
    <?php }else{?>
    <div style="text-align:center; margin-top:100px; line-height:60px; color:#ff0033; font-size:20px; font-weight:bold;">链接已失效！</div>
    <?php }?>
    <div class="service-tel"  style="margin-top:150px; margin-left:-120px;">电话客服：<span class="flag-img-se"></span>0063-90957 88888
</div>
 </div>
</div>
</body>
</html>