<?php 
$sql="select simpleInfo, info, example  from {$this->prename}played where id=?";
$playeds=$this->getRows($sql, $args[0]);
?>
<p class="wjhelps">玩法说明：<?=$playeds[0]["simpleInfo"]?><span action="lt_example" class="showeg help1">范例</span><span action="lt_help" class="showeg help2">玩法介绍</span>
</p>
<div id="lt_example" class="game_eg"><?=$playeds[0]["example"]?></div>
<div id="lt_help" class="game_eg"><?=$playeds[0]["info"]?></div>