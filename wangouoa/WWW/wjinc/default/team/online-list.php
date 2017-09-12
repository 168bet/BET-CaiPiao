<?php
	$home_uid=$this->user['uid'];
	$childrenarr=$this->getRows("SELECT username,coin,parents,uid FROM {$this->prename}members where parents LIKE '%$home_uid%' and uid!=?",$home_uid);
?>

<table width="100%" class='table_b'>
	<thead>
		<tr class="table_b_th">
			<td>用户名</td>
            <td>可用金额</td>
			<td>最后登录</td>
		</tr>
	</thead>
	<tbody class="table_b_tr">
	<?php 
		$onlineNum = 0;
		foreach($childrenarr as $var){ 
			$login=$this->getRow("select * from {$this->prename}member_session where uid=? order by id desc limit 1", $var['uid']);
		if($login['isOnLine'] && ($this->time-$login['accessTime']<900)){
			$parents = explode(',',$var['parents']);
			rsort($parents);
			$index = 1;
			foreach($parents as $key=>$var2){
				$index++;
			}
	?>
		<tr>
			<td><?=$var['username']?></td>
			<td><?=$var['coin']?></td>
			<td><?=date('Y-m-d H:i:s', $login['loginTime'])?></td>
		</tr>
	<?php 
		$onlineNum++;
		} } 
	?>
	<tr><td colspan="4" align="left">在线总数：<?=$onlineNum?></td></tr>
	</tbody>
</table>
