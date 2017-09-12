<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '推广链接 - 代理中心'); ?>
<!--//复制程序 flash+js-->
<script type="text/javascript" src="/skin/js/swfobject.js"></script>
<script language="JavaScript">
function Alert(msg) {
	alert(msg);
}
function thisMovie(movieName) {
	 if (navigator.appName.indexOf("Microsoft") != -1) {   
		 return window[movieName];   
	 } else {   
		 return document[movieName];   
	 }   
 } 
function copyFun(ID) {
	thisMovie(ID[0]).getASVars($("#"+ID[1]).attr('value'));
}
</script>
</head>  
<body>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
 <div class="title"><span>推广链接</span></div>
 <div class="body">
 <div class="youxi1">
	<h2>
    <input class="an" type="submit" value="添加链接" onclick="window.location='/index.php/team/addlink'">
    </h2>  
    <div class="biao-cont">
    <?php
	$sql="select * from {$this->prename}links where enable=1 and uid={$this->user['uid']}";
	if($_GET['uid']=$this->user['uid']) unset($_GET['uid']);
	$data=$this->getPage($sql, $this->page, $this->pageSize);
	?>
<table width="900" border="0" cellspacing="0" cellpadding="0">
		<tr class="top">
			<td>编号</td>
            <td>类型</td>
			<td>返点</td>
			<td>操作</td>
		</tr>
	<?php if($data['data']) foreach($data['data'] as $var){ ?>
		<tr>
			<td><?=$var['lid']?></td>
			<td><?php if($var['type']){echo'代理';}else{echo '会员';}?></td>
			<td><?=$var['fanDian']?>%</td>
			<td><a href="/index.php/team/linkUpdate/<?=$var['lid']?>" style="color:#333;" target="modal"  width="420" title="修改注册链接" modal="true" button="确定:dataAddCode|取消:defaultCloseModal">修改</a> | <a href="/index.php/team/getLinkCode/<?=$var['lid']?>" style="color:#333;" target="modal" width="420"  title="获取链接" modal="true" button="取消:defaultCloseModal">获取链接</a> | <a  href="/index.php/team/linkDelete/<?=$var['lid']?>" button="确定删除:dataAddCode" modal="true" title="删除注册链接" width="420" target="modal"  style="color:#333;">删除</a> </td>
           
		</tr>
	<?php } ?>
</table>
	<?php 
        $this->display('inc_page.php',0,$data['total'],$this->pageSize, '/index.php/team/linkList-{page}');
    ?>
    </div>
</div>
</div>
<div class="foot"></div>
</div>
<?php $this->display('inc_footer.php'); ?> 
</body>
</html>