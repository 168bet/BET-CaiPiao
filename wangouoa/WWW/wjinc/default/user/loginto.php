<?php
if(!$_COOKIE['username']){
	exit('Access Denied');
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->display('inc_skin_lr.php',0,'用户登录'); ?>
<!--本程序由启凡网络提供 网址:http://www.dizhuhui918.com/ -->
<link href="/skin/main/login[1].css" rel="stylesheet" />
<style>
.okbtn {
    background-image: url('/images/index/loginokbtn.png');
    background-position: center center;
    background-repeat: no-repeat;
    width: 118px;
    height: 33px;
    border: 0;
    background-color: transparent;
    cursor: pointer;
    margin-right: 30px;
}
</style>
</head>
<body>
<div class="loginbox">
            <img class="logo" alt="" src="/images/index/loginlogo1.png">
            <div class="loginform">
                <div class="loginformleft">
				<form action="/index.php/user/loginedto" method="post" onajax="userBeforeLoginto" enter="true" call="userLoginto" target="ajax">
                    <p>用户名：<b><?=$_COOKIE['username']?></b><input  style="ime-mode: disabled;" name="username" type="hidden" id="username" value="<?=$_COOKIE['username']?>" /></p>
					<p>问候语：<strong><?=$_COOKIE['care']?><span>如果问候语与您的设置不一致，则为仿冒!不要输入密码!</span></strong>
                    <p>密&nbsp;&nbsp;码：<input style="ime-mode: disabled; width: 127px;" name="password" type="password"/></p>
                    <div>
					    <div style="display:none;"><input type="submit" value=""/></div>
					    <button class="okbtn" tabindex="5" type="button" onclick="$(this).closest('form').submit()"></button>
                    </div>
				</form>
                </div>
                 <div class="loginformright">
                    请至少使用IE8.0以上浏览器，1024*768分辨率使用本系统。使用 IE10.0、谷歌、搜狗等浏览器，1280*800及以上分辨率，可达到最佳使用效果。<br/>
					点击下载:&nbsp&nbsp<a href="/中国福利彩票.zip" style="color:#FF0000">中国福利彩票</a>
                </div>
            </div>
        </div>