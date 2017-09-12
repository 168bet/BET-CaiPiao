<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '团队统计－代理中心'); 

$teamAll=$this->getRow("select sum(u.coin) coin, count(u.uid) count from {$this->prename}members u where u.isDelete=0 and concat(',', u.parents, ',') like '%,{$this->user['uid']},%'");
$teamAll2=$this->getRow("select count(u.uid) count from {$this->prename}members u where u.isDelete=0 and u.parentId={$this->user['uid']}");
?>
</head> 
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
	
    <div class="display biao-cont">
    <table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
        <tr class='table_b_th'>
          <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>团队金额</td> 
        </tr>
        
        <tr height=25 class='table_b_tr_b'>
          <td align="right" style="font-weight:bold;">账号类型：</td>
          <td align="left" ><?=$this->iff($this->user['type'], '代理', '会员')?></td> 
        </tr>  
        <tr height=25 class='table_b_tr_b'>
          <td align="right" style="font-weight:bold;">我的账号：</td>
          <td align="left" ><?=$this->user['username']?></td> 
        </tr>  
         <tr height=25 class='table_b_tr_b'>
          <td align="right" style="font-weight:bold;">可用余额：</td>
          <td align="left" ><?=$this->user['coin']?> 元</td> 
        </tr> 
        <tr height=25 class='table_b_tr_b'>
          <td align="right" style="font-weight:bold;">团队余额：</td>
          <td align="left" ><?=$teamAll['coin']?> 元</td> 
        </tr>  
        <tr height=25 class='table_b_tr_b'>
          <td align="right" style="font-weight:bold;">直属下级：</td>
          <td align="left" ><?=$teamAll2['count']?> 个</td> 
        </tr>   
         <tr height=25 class='table_b_tr_b'>
          <td align="right" style="font-weight:bold;">所有下级：</td>
          <td align="left" ><?=($teamAll['count']-1)?> 个</td> 
        </tr>  
    </table> 
    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 