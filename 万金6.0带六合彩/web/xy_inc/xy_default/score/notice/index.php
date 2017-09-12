<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->display('inc_skin.php',0,'系统公告－会员中心'); ?>
</head>
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
 <div class="title"><span>系统公告</span></div>
 <div class="body">
 <div class="content3l noticeL">
   <ul>
   <?php
	$sql="select * from {$this->prename}content where enable=1 and nodeId=1 order by addTime desc";
	if($data=$this->getRows($sql)){
		$nTitle=$data[0]['title'];
		$nContent=nl2br($data[0]['content']);
		foreach($data as $var){
	  		echo "<li><a href=\"#\" tourl=\"/index.php/notice/view/".$var['id']."\"  title=\"".$var['title']."\" ><span>".date('Y-m-d', $var['addTime'])."</span>".$var['title']."</a></li>
";
		}
	}
?>
   </ul>
 </div>
 <div class="content3r" id="noticeV">
    <h2><?=$nTitle?></h2>
    <p><?=$nContent?>
   <!-- <br /><br />
    <span>万金娱乐平台</span><br />
    <span>2014-08-12</span>-->
    </p>
 </div>
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
