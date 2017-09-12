<?php
$arr=array('1','3','5','12','14','26');
if(in_array($this->type,$arr)){?>
<table border='0' cellspacing='0' cellpadding='0' width=100%>
	<tr><th><a target="modal" button="关闭:defaultModalCloase" title="历史开奖" href="/index.php/index/historyList/<?=$this->type?>">历史记录</a></th><th>号码</th><th>后二</th><th>后三</th></tr>
<?php }else{?>
<table border='0' cellspacing='0' cellpadding='0' width=100%>
	<tr><th><a target="modal" button="关闭:defaultModalCloase" title="历史开奖" href="/index.php/index/historyList/<?=$this->type?>">历史记录</a></th><th>号码</th></tr>
<?php }?>
<?php $this->display('index/inc_data_history_get.php', 0, 4); ?>
</table>