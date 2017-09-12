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
	$sql="select id,wjorderId,actionNo,actionTime,playedId,type,actionData,beiShu,mode,actionNum,lotteryNo,bonus,isDelete,kjTime from {$this->prename}bets where  isDelete=0 and uid={$this->user['uid']} and actionTime>{$toTime} order by id desc limit 10";
	if($list=$this->getRows($sql, $actionNo['actionNo'])){
	foreach($list as $var){
?>
	<ul data-code="<?=json_encode($var)?>">
		<li class="t1"><a href="/index.php/record/betInfo/<?=$var['id']?>" width="800" title="投注信息" button="关闭:defaultModalCloase" target="modal"><?=$var['wjorderId']?></a></li>
		<li class="t2"><?=date('H:i:s', $var['actionTime'])?></li>
		<li class="t3"><?=$this->types[$var['type']]['shortName']?></li>
		<li class="t4"><?=$this->playeds[$var['playedId']]['name']?></li>
		<li class="t5"><?=$var['actionNo']?></li>
		<li class="t6"><?=Object::CsubStr($var['actionData'],0,10)?></li>
		<li class="t7"><?=$var['beiShu']?>倍</li>
		<li class="t8"><?=$var['beiShu']*$var['mode']*$var['actionNum']?></li>
        <li class="t9"><?=$modes[$var['mode']]?></li>
		<li class="t10"><?=$this->iff($var['lotteryNo'], number_format($var['bonus'], 2), '0.00')?></li>
		<li class="t11">
		<?php if($var['lotteryNo'] || $var['isDelete']==1 || $var['kjTime']<$this->time){ ?>
            --
        <?php }else{ ?>
            <a target="ajax" call="gameFreshOrdered"  onajax="confirmCancel" dataType="json" href="/index.php/game/deleteCode/<?=$var['id']?>">撤单</a>
        <?php } ?>
        </li>
	</ul>
<div class="clear"></div>
<?php } }else{ ?>
<li colspan="12" height="10">暂无投注数据</li>
<?php } 
?>