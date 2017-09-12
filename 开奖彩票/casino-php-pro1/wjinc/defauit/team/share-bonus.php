<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '代理分红'); ?>
</head> 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop">
<style type="text/css">
#bonusButton{
display:inline-block;
background:red;
color:#fff;
width:100px;
}
</style>
</div>
<div class="pagemain">
<div id="shareBonusInfo">
<?php $this->display('team/share-bonus-info.php'); ?> 
</div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
