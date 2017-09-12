<div class="fushi">
<ul>
<?php
	$sql="select * from {$this->prename}played_group where id=?";
	$group=$this->getRow($sql, $this->groupId);
	
	$sql="select id, name, playedTpl, enable from {$this->prename}played where groupId=? order by sort";
	$playeds=$this->getRows($sql, $this->groupId);
	if(!$this->played) $this->played=$playeds[0]['id'];
	
	if($playeds) foreach($playeds as $played){
		if($played['enable']){
?>
<li<?=($played['id']==$this->played)?' class="on"':''?>><a data_id="<?=$played['id']?>"  href="#" tourl="/index.php/index/played/<?=$this->type?>/<?=$played['id']?>"><?=$played['name']?></a></li>
<? }} ?>
</ul>
</div>
<?php 
$sql="select simpleInfo, info, example  from {$this->prename}played where id=?";
$playeds=$this->getRows($sql, $this->played);
?>
<div class="fanli" id="game-helptips">
	<p class="wjhelps">玩法说明：<?=$playeds[0]["simpleInfo"]?><span action="lt_example" class="showeg help1">范例</span><span action="lt_help" class="showeg help2">玩法介绍</span>
</p>
<div id="lt_example" class="game_eg"><?=$playeds[0]["example"]?></div>
<div id="lt_help" class="game_eg"><?=$playeds[0]["info"]?></div>
</div>
<div class="num-table" id="num-select">
<?php 
	$sql="select type, groupId, playedTpl from {$this->prename}played where id=?";
	$data=$this->getRow($sql, $this->played);
	if($data['playedTpl']){
		$this->groupId=$data['groupId'];
		//$this->type=$data['type'];
		$this->display("index/game-played/{$data['playedTpl']}.php");
	}else{
		$this->display('index/game-played/un-open.php');
	}
?>
<div class="clear"></div>
</div>