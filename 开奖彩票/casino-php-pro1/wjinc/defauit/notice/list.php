<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '会员中心 - 站内公告'); ?>
</head> 
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
    <div class="display biao-cont">
    
    	 <table width="100%" class='table_b'>
        <thead>
            <thead>
            <tr class="table_b_th">
                <td>编号</td>
                <td>公告标题</td>
                <td>发布时间</td>
            </tr>
            </thead>
            <tbody class="table_b_tr">
           <?php
			$cout=0;
            $styles=array('tr_line_2_a','tr_line_2_b');
            if($args[0]) foreach($args[0]['data'] as $var){
			$cout+=1;
			$mod=$cout%2;
        ?>
            <tr>
            	<td><?=$var['id']?></td>
            	<td class="tl"><a href="/index.php/notice/view/<?=$var['id']?>"  title="<?=$var['title']?>" ><?=$var['title']?></a></td>
            	<td class="tl"><?=date('Y-m-d H:i:s', $var['addTime'])?></td>
            </tr>
            <?php }else{ ?>
            <tr>
                <td colspan="3" align="center">没有记录</td>
            </tr>
            <?php } ?>
            </tbody>
            
        </table>
        <?php $this->display('inc_page.php', 0, $args[0]['total'], $this->pageSize, "/index.php/notice/info-{page}", 0); ?>
    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 