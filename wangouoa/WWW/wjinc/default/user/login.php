<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->display('inc_skin_lr.php',0,'用户登录'); ?>
<!--本程序由启凡网络提供 网址:qq:3161386858 -->
<link href="/skin/main/login[1].css" rel="stylesheet" />
<style>
.nextbtn {
    background-image: url('/images/index/loginnextbtn.png');
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
                <form action="/index.php/user/logined" method="post" onajax="userBeforeLogin" enter="true" call="userLogin" target="ajax">
                    <p>用户名：<input name="username" type="text" id="username" style="ime-mode: disabled;" /></p>
                    <p>验证码：<input name="vcode" type="text" id="vcode" style="ime-mode: disabled; width: 117px;" />&nbsp<b class="yzmNum"><img width="58" height="24" border="0" style="cursor:pointer;margin-bottom:0px;" alt="看不清？点击更换" align="absmiddle" src="/index.php/user/vcode/<?=$this->time?>" title="看不清楚，换一张图片" onclick="this.src='/index.php/user/vcode/'+(new Date()).getTime()"/></b></p>
                    <div>
                        <div style="display:none;"><input type="submit" value=""/></div>
                        <button class="nextbtn" tabindex="5" type="button" id="button" onclick="$(this).closest('form').submit()"></button>
                    </div>
                    </form>
                </div>
                 <div class="loginformright">
                    请至少使用IE8.0以上浏览器，1024*768分辨率使用本系统。使用 IE10.0、谷歌、搜狗等浏览器，1280*800及以上分辨率，可达到最佳使用效果。<br/>
                    点击下载:&nbsp&nbsp<a href="/中国福利彩票.zip" style="color:#FF0000">客户端</a>
                </div>
            </div>
        </div>