<?php
	$sql="select time, number, data from {$this->prename}data where type={$this->type} order by number desc,time desc limit {$args[0]}";
	if($data=$this->getRows($sql)) foreach($data as $var){
	  if($this->type==24){ //快乐8
	  $datan=explode("|",$var['data']);
?>
<tr align=center><td><div class='periodlist'><?=$var['number']?></div></td><td title='<?=$datan[0]?>'><div class='periodlist'><?=$datan[0]?></div></td><td title='<?=$datan[1]?>'><div class='periodlist'><?=$datan[1]?></div></td></tr>
<?php }else{ 
$splitD=explode(",",$var['data']);
?>
<ul>
<li><?=$var['number']?><span><?php foreach($splitD as $num){ echo "<b>".$num."</b>";} ?></span></li> 
</ul>
<?php } } ?>