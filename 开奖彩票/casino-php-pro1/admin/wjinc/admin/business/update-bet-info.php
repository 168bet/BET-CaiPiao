<?php
    $this->gettypes();
	$this->getPlayeds();
	$bet=$this->getRow("select * from {$this->prename}bets where id=?", $args[0]);
	
	if(!$bet) throw new Exception('单号不存在');
	
	$modeName=array('2.00'=>'元', '0.20'=>'角', '0.02'=>'分');
	$weiShu=$bet['weiShu'];
	if($weiShu){
		$w=array(16=>'万', 8=>'千', 4=>'百', 2=>'十',1=>'个');
		foreach($w as $p=>$v){
			if($weiShu & $p) $wei.=$v;
		}
		$wei.=':';
	}
	$betCont=$bet['mode'] * $bet['beiShu'] * $bet['actionNum'] * ($bet['fpEnable']+1);
?>
<div>
<input type="hidden" value="<?=$this->user['username']?>" />
<form action="/admin778899.php/business/betinfoUpdateed" target="ajax" method="post" call="betinfoDataSubmitCode" onajax="betinfoDataBeforeSubmitCode" dataType="html">
	<input type="hidden" name="betid" value="<?=$args[0]?>"/>
    <input type="hidden" name="uid" value="<?=$bet['uid']?>"/>
    <input type="hidden" name="username" value="<?=$bet['username']?>"/>
   
<div class="bet-info popupModal">
	<table cellpadding="0" cellspacing="0" width="480">
		<tr>
			<td align="right">号码：</td>
			<td colspan="3"><textarea cols="45" name="actionData" rows="5"><?=$wei.$bet['actionData']?></textarea></td>
		</tr>
		<tr>
			<td width="80" align="right">单号：</td>
			<td width="160"><?=$bet['wjorderId']?></td>
			<td width="80" align="right">投注数量：</td>
			<td width="160"><?=$bet['actionNum']?></td>
		</tr>
		<tr>
			<td align="right">发起人：</td>
			<td><?=$bet['username']?></td>
			<td align="right">模式：</td>
			<td><?=$modeName[$bet['mode']]?></td>
		</tr>
		<tr>
			<td align="right">倍数：</td>
			<td><?=$bet['beiShu']?></td>
			<td align="right">中奖注数：</td>
			<td><?=$this->iff($bet['lotteryNo'], $bet['zjCount'], '－')?></td>
		</tr>
		<tr>
			<td align="right">彩种：</td>
			<td><?=$this->types[$bet['type']]['title']?></td>
			<td align="right">奖金－返点：</td>
			<td><?=number_format($bet['bonusProp'], 2)?>－<?=number_format($bet['fanDian'],1)?>%</td>
		</tr>
		<tr>
			<td align="right">期号：</td>
			<td><?=$bet['actionNo']?></td>
			<td align="right">玩法：</td>
			<td>
<?php
		$sql="select * from {$this->prename}played where enable=1 and type=?";
		$plays=$this->getRows($sql,$bet['type']);
		if($plays){
?>
<select name="playedId">
<?php
		foreach($plays as $play){
		?>
		<option value="<?=$play['id']?>" <?=$this->iff($play['id']==$bet['playedId'], 'selected="selected"')?>><?=$play['name']?></option>
<?php } ?>
</select>		
		<?php } ?>
</td>
		</tr>
		<tr>
			<td align="right">开奖号：</td>
			<td><?=$this->ifs($bet['lotteryNo'], '－')?></td>
			<td align="right">投注时间：</td>
			<td><?=date('m-d H:i:s',$bet['actionTime'])?></td>
		</tr>
		<tr>
			<td align="right">订单状态：</td>
			<td>
			<?php
				if($bet['isDelete']==1){
					echo '<font color="#999999">已撤单</font>';
				}elseif(!$bet['lotteryNo']){
					echo '<font color="#009900">未开奖</font>';
				}elseif($bet['zjCount']){
					echo '<font color="red">已派奖</font>';
				}else{
					echo '未中奖';
				}
			?>
			</td>
            <td align="right">来源：</td>
            <td colspan="3"><?php if($bet['betType']==0){echo 'web';}else if($bet['betType']==1){echo '手机';}else{echo '--';}?></td><?php if($bet['betType']==0){echo 'web端';}else if($bet['betType']==1){echo '手机端';}else if($bet['betType']==2){echo '客户端';}?>
        </tr>
		<!-- 投注开始 -->
		<tr>
			<td align="right">投注：</td>
			<td><?=number_format($betCont, 2)?>元</td>
			<td align="right">中奖：</td>
			<td><?=$this->iff($bet['lotteryNo'], number_format($bet['bonus'], 2) .'元', '－')?></td>
		</tr>
		<tr>
			<td align="right">返点：</td>
			<td><?=$this->iff($bet['lotteryNo'], number_format($bet['fanDianAmount'], 2). '元', '－')?></td>
			<td align="right">个人盈亏：</td>
			<td><?=$this->iff($bet['lotteryNo'], number_format($bet['bonus'] - $betCont + $bet['fanDianAmount'], 2) . '元', '－')?></td>
		</tr>
		<!-- 投注结束 -->
	</table>
</div>
   </form>
</div>