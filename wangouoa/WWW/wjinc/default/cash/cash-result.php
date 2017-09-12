<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '会员中心 - 申请提现'); ?>
<?php
	$txcount=$this->getValue("select count(id) from {$this->prename}member_cash  where state=1")
?>
</head> 
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
	
    <div class="display biao-cont">

		<div class="tips">
        	<p>提现正在处理中，排队<strong class="red"><?=intval($txcount)+intval($this->settings['cashPersons'])?></strong></p>
        </div>

    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
 