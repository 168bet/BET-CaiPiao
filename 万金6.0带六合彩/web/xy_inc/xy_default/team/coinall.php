<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '团队统计－代理中心'); 

$teamAll=$this->getRow("select sum(u.coin) coin, count(u.uid) count from {$this->prename}members u where u.isDelete=0 and concat(',', u.parents, ',') like '%,{$this->user['uid']},%'");
$teamAll2=$this->getRow("select count(u.uid) count from {$this->prename}members u where u.isDelete=0 and u.parentId={$this->user['uid']}");
?>
</head> 
 
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
 <div class="title"><span>团队统计</span></div>
 <div class="body">
 <div class="tuandui1">
<h2>团队金额：</h2>
    <ul>
     <li><span>账号类型：</span><b><?=$this->iff($this->user['type'], '代理', '会员')?></b></li>
     <li><span>我的账号：</span><b><?=$this->user['username']?></b></li>
     <li><span>可用余额：</span><b><?=$this->user['coin']?> 元</b></li>
     <li><span>团队余额：</span><b><?=$teamAll['coin']?> 元</b></li>
     <li><span>直属下级：</span><b><?=$teamAll2['count']?> 个</b></li>
     <li><span>所有下级：</span><b><?=($teamAll['count']-1)?> 个</b></li>
    </ul>
    <div class="clear"></div>
 </div>
</div>
 <div class="foot"></div>
</div>
<?php $this->display('inc_footer.php'); ?> 
</body>
</html>
  
   
 