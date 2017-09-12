<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->display('inc_skin_lr.php',0,'新用户注册'); ?>
</head>

<body>

<div id="header">
    <div id="header-inner">
        <div class="logo">用户注册</div>
    </div>
    
</div>
<div id="content" class="clearfix">
    <div class="pic"><img src="/images/ads.jpg" width="435" height="276" alt="" /> </div>
    <div class="form">
        <div class="form-inner">
         <?php if($args[0] && $args[1]){
        
		$sql="select * from {$this->prename}links where lid=?";
		$linkData=$this->getRow($sql, $args[1]);
		$sql="select * from {$this->prename}members where uid=?";
		$userData=$this->getRow($sql, $args[0]);
	
		?>

		<form action="/index.php/user/registered" method="post" onajax="registerBeforSubmit" enter="true" call="registerSubmit" target="ajax">
        	<input type="hidden" name="parentId" value="<?=$args[0]?>" />
            <input type="hidden" name="lid" value="<?=$linkData['lid']?>"  />
          	<dl>
            	<dt>用户名：</dt>
                <dd><input name="username" type="text" id="username" class="login-text" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')"/></dd>
            </dl>
            <dl>
            	<dt>密  码：</dt>
                <dd><input name="password" type="password" id="password" class="login-text" /></dd>
            </dl>
             <dl>
            	<dt>确认密码：</dt>
                <dd><input name="cpasswd" type="password" id="cpasswd" class="login-text" /></dd>
            </dl>
             <dl>
            	<dt>Q  Q：</dt>
                <dd><input name="qq" type="test" id="qq" class="login-text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/></dd>
            </dl>
            <dl>
            	<dt>验证码：</dt>
                <dd style="position:relative;"><input name="vcode" type="text" class="login-text" /><div class="yzmNum"><img width="72" height="24" border="0" id="vcode" style="cursor:pointer;" align="absmiddle" src="/index.php/user/vcode/<?=$this->time?>" title="看不清楚，换一张图片" onclick="this.src='/index.php/user/vcode/'+(new Date()).getTime()"/></div></dd>
            </dl>
             <dl>
            	<dt class="hide"><input type="submit" value=""/></dt>
                <dd><button class="login-btn" tabindex="5" type="button" onclick="$(this).closest('form').submit()">注　册</button></dd>
            </dl>
          </form>
           <?php }else{?>
           <div style="text-align:center; line-height:50px; color:#FF0; font-size:20px; font-weight:bold;">链接失效！</div>
           <?php }?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div id="footer">Copyright &copy; <?=$this->settings['webName']?>  免责声明：本平台仅供娱乐!其它用途均与平台提供者无关! </div>
</body>
</html>
