<?php $this->freshSession(); 
		//更新级别
		$ngrade=$this->getValue("select max(level) from {$this->prename}member_level where minScore <= {$this->user['scoreTotal']}");
		if($ngrade>$this->user['grade']){
			$sql="update {$this->prename}members set grade={$ngrade} where uid=?";
			$this->update($sql, $this->user['uid']);
		}else{$ngrade=$this->user['grade'];}
		$date=strtotime('00:00:00');
?>
<p>用户：<span><?=$this->user['username']?></span>余额：<span><?=$this->user['coin']?></span><a href="#" title="刷新余额" onclick="reloadMemberInfo()"><img src="/skin/images/shuaxin.png" alt=""></a>&nbsp;&nbsp;<a href="/index.php/cash/recharge" title="充值"><img src="/skin/images/chongzhi.png" alt=""></a><a href="/index.php/cash/toCash" title="提款"><img src="/skin/images/tikuan.png" alt=""></a><a href="/index.php/user/logout" title="退出"><img src="/skin/images/tuichu.png" alt=""></a><a href="/down/" target="_blank" title="" class="air1">&nbsp;</a></p>
<div class="myair"><a href="/index.php/notice/huodong2" target="_self" title="" class="air1">&nbsp;</a></div>