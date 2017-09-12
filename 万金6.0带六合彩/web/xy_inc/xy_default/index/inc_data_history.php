<?php
    if($this->type==24){ //快乐8
?>
	<div class="hao"><span>最近期号</span><b>开奖号码</b><b>快乐飞盘</b></div>
<?php }else{ ?>
	<div class="hao"><span>最近期号</span><b>开奖号码</b></div>
<?php }  ?>
      
<?php $this->display('index/inc_data_history_get.php', 0, 4); ?>