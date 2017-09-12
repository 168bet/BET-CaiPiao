<?php
	$para=$_GET;
	// 取当前彩种开奖时间表
	$sql="select t.*,b.title typeName from {$this->prename}data_time t left join {$this->prename}type b on b.id=t.type where t.type={$this->type} order by t.actionNo";
	$times=$this->getPage($sql, $this->page, $this->pageSize);
	
?>
<article class="module width_full">
<input type="hidden" value="<?=$this->user['username']?>" />
	<header>
		<h3 class="tabs_involved">彩种时间设置</h3>
	</header>

	<table class="tablesorter" cellspacing="0">
		<thead>
			<tr>
				<th>彩种</th>
				<th>期数</th>
				<th>开奖时间</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php
	
				foreach($times['data'] as $var){
					
			?>
			<tr>
				<td><?=$var['typeName']?></td>
				<td><?=$var['actionNo']?></td>
                <td><input type="text" name="actionTime"   value="<?=$var['actionTime']?>"/></td>
				<td><a href="/admin778899.php/time/updateTime/<?=$var['type']?>/<?=$var['id']?>" target="ajax" method="POST" onajax="sysBeforeUpdateTime" call="sysUpdateTime">保存修改</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<footer>
	<?php
		//$rel=$args[0]['id'];
		if($para){
			$rel.='?'.http_build_query($para,'','&');
		}
		$rel=$this->controller.'/'.$this->action .'-{page}/'.$this->type.'?'.http_build_query($_GET,'','&');
		$this->display('inc/page.php', 0, $times['total'], $rel, 'dataPageAction');
	?>
	</footer>
</article>