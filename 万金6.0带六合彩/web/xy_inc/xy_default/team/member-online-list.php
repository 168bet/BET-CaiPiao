<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '在线会员 - 代理中心'); ?>
</head> 
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
 <div class="title"><span>在线会员</span></div>
 <div class="body">
 <div class="youxi1">

<?php $this->display('/team/online-list.php'); ?> 
 
</div>
</div>
<div class="foot"></div>
</div>
<?php $this->display('inc_footer.php'); ?> 
</body>
</html>