<?php
	$sql="select groupName from {$this->prename}played_group where id=?";
	$groupName=$this->getValue($sql, $this->groupId);

	$sql="select id, name, playedTpl, enable  from {$this->prename}played where enable=1 and groupId=? order by sort";
	$playeds=$this->getRows($sql, $this->groupId);
	if(!$playeds) {echo '<td colspan="7" align="center">暂无玩法</td>';return;} 
	if(!$this->played) $this->played=$playeds[0]['id'];
?>
<div class="fushi">
<ul>
	<?php
		if($playeds) foreach($playeds as $played){
			if($this->played==$played['id']) $tpl=$played['playedTpl'];
			if($played['enable']){
	?>
	<li<?=($played['id']==$this->played)?' class="on"':''?>><a data_id="<?=$played['id']?>" href="#" tourl="/index.php/index/played/<?=$this->type?>/<?=$played['id']?>"><?=$played['name']?></a></li>
	<? }} ?>
</ul>
</div>
<div class="fanli" id="game-helptips"><?php $this->display("index/inc_game_tips.php", 0 ,$this->played); ?></div>
<div class="num-table" id="num-select">
<?php 
	if(!$played['enable']) {echo '<td colspan="7" align="center">暂无玩法</td>';return;} 
	$this->display("index/game-played/$tpl.php"); ?>
<div class="clear"></div>	
</div> 