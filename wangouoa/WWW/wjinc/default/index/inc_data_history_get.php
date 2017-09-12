<?php
	$sql="select time, number, data from {$this->prename}data where type={$this->type} order by number desc,time desc limit {$args[0]}";
	$arr=array(1,3,5,12,14,26);
	if(in_array($this->type,$arr)){
	    if($data=$this->getRows($sql)) foreach($data as $var){
	    $hao=explode(',',$var['data']);$h2='';
	    if($hao[2]!=$hao[3] && $hao[2]!=$hao[4] && $hao[3]!=$hao[4]) $h3='组六';
	    if($hao[2]==$hao[3] || $hao[2]==$hao[4] || $hao[3]==$hao[4]) $h3='组三';
	    if($hao[2]==$hao[3] && $hao[3]==$hao[4]) $h3='豹子';
	    if($hao[3]==$hao[4]) $h2='对子';
	    ?>

	    <tr align=center><td><div class='periodlist'><?=$var['number']?></div></td><td title='<?=$var['data']?>'><div class='periodlist'><?=$var['data']?></div></td><td><div class='periodlist' style='<?=$this->iff($h2=='对子','color:#FF00FF;','')?>'><?=$h2?></div></td><td><div class='periodlist' style='<?if($h3=='组六'){echo 'color:#009999;';}else if($h3=='组三'){echo 'color:#f60;';}else{echo 'color:#FF2626;';}?>'><?=$h3?></div></td></tr> 

<?php }else{}}else{
if($data=$this->getRows($sql)) foreach($data as $var){?>
     <tr align=center><td><div class='periodlist'><?=$var['number']?></div></td><td title='<?=$var['data']?>'><div class='periodlist'><?=$var['data']?></div></td></tr> 
<?php }

}?>