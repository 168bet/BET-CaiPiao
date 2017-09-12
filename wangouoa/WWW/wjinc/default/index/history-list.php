<?php
	$sql="select type, time, number, data from ssc_data where type={$args[0]}";
	$sql=$sql." order by number desc";
	$data=$this->getPage($sql, $this->page, $this->pageSize);
    $typename=$this->getValue("select title from ssc_type where id=?",$args[0]);
?>
<div class="bet-info popupModal">
<table width="100%">
	<tbody class="ht-cont">
	<?php
	$arr=array(1,3,5,12,14,26);
	if(in_array($this->type,$arr)){?>
	<tr align=center><td style="font-weight:bold;">彩种</td><td style="font-weight:bold;">期数</td><td style="font-weight:bold;">号码</td><td style="font-weight:bold;">时间</td><td style="font-weight:bold;">后二</td><td style="font-weight:bold;">后三</td></tr>
	<?php }else{?>
	<tr align=center><td style="font-weight:bold;">彩种</td><td style="font-weight:bold;">期数</td><td style="font-weight:bold;">号码</td><td style="font-weight:bold;">时间</td>
	<?php }?>
	<?php
	$arr=array(1,3,5,12,14,26);
	if(in_array($this->type,$arr)){
	   if($data['data']) foreach($data['data'] as $var){
		$hao=explode(',',$var['data']);$h2='';
	    if($hao[2]!=$hao[3] && $hao[2]!=$hao[4] && $hao[3]!=$hao[4]) $h3='组六';
	    if($hao[2]==$hao[3] || $hao[2]==$hao[4] || $hao[3]==$hao[4]) $h3='组三';
	    if($hao[2]==$hao[3] && $hao[3]==$hao[4]) $h3='豹子';
	    if($hao[3]==$hao[4]) $h2='对子';
	    ?>
		<tr>
			<td align=center><?=$typename?></td>
			<td align=center><?=$var['number']?></td>
			<td align=center><?=$var['data']?></td>
			<td align=center><?=date('H:i', $var['time'])?></td>
			<td align=center style='<?=$this->iff($h2=='对子','color:#FF00FF;','')?>'><?=$h2?></td>
			<td align=center style='<?php if($h3=='组六'){echo 'color:#009999;';}else if($h3=='组三'){echo 'color:#f60;';}else{echo 'color:#FF2626;';}?>'><?=$h3?></td>
		</tr>
	<?php }else{}}else{
	   if($data['data']) foreach($data['data'] as $var){?>
		<tr>
			<td align=center><?=$typename?></td>
			<td align=center><?=$var['number']?></td>
			<td align=center><?=$var['data']?></td>
			<td align=center><?=date('H:i', $var['time'])?></td>
		</tr>
	<?php }}?>
	</tbody>
</table>
<?php 
	$this->display('inc_page.php',0,$data['total'],$this->pageSize, '/index.php/index/historyList-{page}/'.$args[0]);
?>
</div>