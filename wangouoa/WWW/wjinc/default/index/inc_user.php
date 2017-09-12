<?php $this->freshSession();
		$ngrade=$this->getValue("select max(level) from {$this->prename}member_level where minScore <= {$this->user['scoreTotal']} limit 1");
		if($ngrade>$this->user['grade']){
			$sql="update ssc_members set grade={$ngrade} where uid=?";
			$this->update($sql, $this->user['uid']);
		}else{$ngrade=$this->user['grade'];}
		$date=strtotime('00:00:00');
?>
	<div class="bodytop">
    <div id="money">
        <tr>
        <td>昵称：<em><?=$this->user['nickname']?></em></td>
        <td>余额：</td>
        <td><strong>￥<?=$this->user['coin']?><a href="#"  onclick="reloadMemberInfo()"><img src="/images/common/ref.png" alt="刷新余额"></a></strong></td>
        <td>
        <a href="/index.php/cash/recharge">充值</a>
        <a href="/index.php/cash/toCash">提款</a>
		<!--签到有奖-->
        <?php
           if(floatval($this->settings['huoDongSign'])){
        ?>
           <a href="/index.php/display/sign" dataType="json" call="indexSign" target="ajax">签到</a>
        <?php }?>
        <!--签到有奖-->
        <a href="/index.php/user/logout">退出</a>
        </td>
        </tr>
	</div>
</div>