<?php
	//前一天日期
	$yesterday = date("Y-m-d",strtotime("-1 day"));
	$fromTime = strtotime($yesterday.' 00:00:00');
	$toTime = strtotime($yesterday.' 24:00:00');
	//$toTime = time();
	// 加载系统设置
	// and betAmount > ".floatval($this->settings['conCommissionBase1'])."
	$this->getSystemSettings();
	//echo floatval($this->settings['conCommissionBase1']);
	//exit;
	$sql="select u.username, u.coin, u.uid, u.type, u.parentId, sum(b.mode * b.beiShu * b.actionNum) betAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 and b.actionTime between $fromTime and $toTime where 1 and u.parentId <> 0 and u.conCommStatus = 0 group by u.uid HAVING betAmount > ".floatval($this->settings['conCommissionBase1']);
	$data=$this->getPage($sql, $this->page, $this->pageSize);
	//echo '<pre>';
	//print_r($data);
	//echo '</pre>';
	//exit;
	//echo get_class($this);
?>
<article class="module width_full">
    <header>
		<h3 class="tabs_involved">消费佣金发放列表
		<div class="submit_link wz">
			<form action="/admin778899.php/Commission/updateCommStatus" class="submit_link wz" target="ajax" datatype="html" call="conCommHandle">
              	<input type="hidden" name="commStatusName" value="conCommStatus" />
				<input type="submit" class="alt_btn" value="更新发放状态" />
            </form>
		</div>
		</h3>
    </header>
    <div class="tab_content">
	<table class="tablesorter" cellspacing="0"> 
	<thead> 
		<tr> 
			<th>用户名</th> 
			<th>UserId</th>
			<th>类型</th>
			<th>昨日消费金额</th> 
			<th>操作</th> 
		</tr> 
	</thead> 
	<tbody>
    <!--picmin 小图片	picmax 大图片	intoTime 加入时间	restriction 限制单人兑换件数	sum 商品总数	surplus 兑换件数	startTime 开始时间	stopTime 结束时间	score 积分	price 价值	enable-->
	<?php if($data['data']) foreach($data['data'] as $var){ 
	?>
		<tr> 
			<td><?=$var['username']?></td> 
			<td><?=$var['uid']?></td> 
			<td><?php if($var['type']){echo'代理';}else{echo '会员';}?></td>
			<td><?=$var['betAmount']?></td>
			<td>
				<a href="/admin778899.php/Commission/conComSingle/<?=$var['uid']?>" target="ajax" call="conCommHandle" dataType="html">发放佣金</a>
            </td>
		</tr> 
	<?php }else{ ?>
		<tr>
			<td colspan="9" align="center">已没有可发放消费佣金的用户。</td>
		</tr>
	<?php } ?>
	</tbody> 
    </table>
	<footer>
	<?php
		$rel=get_class($this).'/conCommissionList-{page}?'.http_build_query($_GET,'','&');
		$this->display('inc/page.php', 0, $data['total'], $rel, 'betLogSearchPageAction'); 
	?>
	</footer>
    </div><!-- end of .tab_container -->
</article><!-- end of content manager article -->
