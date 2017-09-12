<?php
	if(!$this->types) $this->getTypes();
	if(!$this->playeds) $this->getPlayeds();
	$modes=array(
	    '0.002'=>'厘',
		'0.020'=>'分',
		'0.200'=>'角',
		'2.000'=>'元'
	);
	$toTime=strtotime('00:00:00');
	$sql="select id,wjorderId,actionNo,actionTime,fpEnable,playedId,type,actionData,beiShu,mode,actionNum,lotteryNo,bonus,isDelete,kjTime from {$this->prename}bets where  isDelete=0 and uid={$this->user['uid']} and actionTime>{$toTime} order by id desc limit 10";
	if($list=$this->getRows($sql, $actionNo['actionNo'])){
	foreach($list as $var){
?>
	<tr data-code='<?=json_encode($var)?>'>
		<td><a href="/index.php/record/betInfo/<?=$var['id']?>" width="800" title="投注信息" button="关闭:defaultModalCloase" target="modal"><?=$var['wjorderId']?></a></td>
		<td><?=date('H:i:s', $var['actionTime'])?></td>
		<td><?=$this->types[$var['type']]['shortName']?></td>
		<td><?=$this->playeds[$var['playedId']]['name']?></td>
		<td><?=$var['actionNo']?></td>
		<td class="code-list pointer"><?=Object::CsubStr($var['actionData'],0,10)?></td>
		<td><?=$var['beiShu']?>倍</td>
		<td><?=$modes[$var['mode']]?></td>
        <td><?=$var['beiShu']*$var['mode']*$var['actionNum']?></td>
		<td><?=$this->iff($var['lotteryNo'], number_format($var['bonus'], 3), '0.00')?></td>
		<td>
		<?php if($var['lotteryNo'] || $var['isDelete']==1 || $var['kjTime']<$this->time){ ?>
            --
        <?php }else{ ?>
             <a target="ajax" call="gameFreshOrdered"  onajax="confirmCancel" dataType="json" href="/index.php/game/deleteCode/<?=$var['id']?>">撤单</a>
        <?php } ?>
        </td>
	</tr>
<?php } }else{ ?>
<tr>
	<td colspan="12" height="28" style="text-align:center;">暂无投注数据</td>
</tr>
<?php } 
?>