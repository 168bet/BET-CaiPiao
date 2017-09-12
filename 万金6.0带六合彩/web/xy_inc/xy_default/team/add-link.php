<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->display('inc_skin.php', 0 , '添加链接－代理中心'); ?>
</head> 
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
<div class="title"><span>添加推广链接</span></div>
 <div class="body">
 <div class="mima1">
<form action="/index.php/team/insertLink" method="post" target="ajax" onajax="teamBeforeAddLink" call="teamAddLink">
<input name="uid" type="hidden" id="uid" value="<?=$this->user['uid']?>" />
   <h2>添加注册链接：</h2>
    <ul>
	 <li><span>账号类型：</span><label><input type="radio" name="type" value="1" title="代理" checked="checked" />代理</label>&nbsp;&nbsp;<label><input name="type" type="radio" value="0" title="会员" />会员</label></li>
     <li><span>返点：</span><input type="text" name="fanDian" max="<?=$this->user['fanDian']?>" class="text4" fanDianDiff=<?=$this->settings['fanDianDiff']?>  />&nbsp;&nbsp;0-<?=$this->user['fanDian']?>%</li>
     <li class="tijiao"><input id="addlink" class="an" type="submit" value="增加链接" ><input type="reset" id="resetlink" class="an" value="重置" onClick="this.form.reset()" /></li>
    </ul>
</form>
  </div>
  <div class="bank"></div>
</div>
<div class="foot"></div>
</div>
<?php $this->display('inc_footer.php'); ?> 
</body>
</html>