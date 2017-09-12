<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '会员中心 - 站内公告'); ?>
</head> 
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
 <div class="title"><span>首页公告</span></div>
 <div class="body">
 <?php 
	$cout=0;
	$styles=array('tr_line_2_a','tr_line_2_b');
	if($args[0]['data']){
 ?>
 <div class="content3l noticeL">
    <ul>
	<?php
		
		$bool = true;
		foreach($args[0]['data'] as $var){
			if($bool){
				$bool = false;
				$val=$var;
			}
			$cout+=1;
			$mod=$cout%2;
	?>
		<li><a href="#" tourl="/index.php/notice/view/<?=$var['id']?>"  title="<?=$var['title']?>" ><span><?=date('Y-m-d', $var['addTime'])?></span><?=$var['title']?></a></li>
	<?php }?>
	</ul>
 </div>
 <div class="content3r" id="noticeV">
    <tr>
		<h2><?=$val['title']?></h2>
		<p><?=nl2br($val['content'])?></p>
	</tr>
 </div>
 <?php }else{ ?>
		<center>暂时没有相关没有记录</center>
 <?php } ?>
 <div class="clear"></div>
</div>
<div class="foot"></div>
</div>
<?php $this->display('inc_footer.php'); ?>
<script>
	$(function(){
		$(".noticeL a")	.live("click",function(){
			var tourl=$(this).attr("tourl");
			$('#noticeV').load(tourl);
			return false;
		})
	})
</script>
</body>
</html>