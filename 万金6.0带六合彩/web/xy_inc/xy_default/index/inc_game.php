<!--div class="content1" style="margin-top:-20px; id="gameBody"-->
<div class="content1" id="gameBody" style="margin-top:-20px";>
<div class="title mainHeader" id="groupList">
	<ul>
	<?php
		if($_COOKIE['mode']){
			$mode=$_COOKIE['mode'];
		}else{
			$mode=2.000;
		}
		$this->getSystemSettings();
		$this->getTypes();
		$sql="select id, groupName, enable from {$this->prename}played_group where enable=1 and type=? order by sort";
		$groups=$this->getObject($sql, 'id', $this->types[$this->type]['type']);
		if($this->groupId && !$groups[$this->groupId]) unset($this->groupId);
		if($groups) foreach($groups as $key=>$group){
			if(!$this->groupId) $this->groupId=$group['id'];
	?>	
	<li<?=($this->groupId==$group['id'])?' class="on"':''?>><a href="#" tourl="/index.php/index/group/<?=$this->type .'/'.$group['id']?>"><?=$group['groupName']?></a></li>
	<?php } ?>
	</ul>
 </div>	
 <div class="mainBody">
  <div id="playList">
  <?php $this->display('index/inc_game_played.php'); ?>
  </div>
  <div class="jiangjin" id="game-dom">
  	<div class="fandian-k fl">
	
				<input type="button" class="min" value="" step="-0.1"/>
				<input type="button" class="max" value="" step="0.1"/>
				<strong>奖金/返点：</strong>
				<div id="slider-range-min" value="<?=$this->ifs($_COOKIE['fanDian'], 0)?>" data-bet-count="<?=$this->settings['betMaxCount']?>" data-bet-zj-amount="<?=$this->settings['betMaxZjAmount']?>" max="<?=$this->user['fanDian']?>" game-fan-dian="<?=$this->settings['fanDianMax']?>" fan-dian="<?=$this->user['fanDian']?>" game-fan-dian-bdw="<?=$this->settings['fanDianBdwMax']?>" fan-dian-bdw="<?=$this->user['fanDianBdw']?>" min="0" step="0.1" slideCallBack="gameSetFanDian" class="tiao slider"></div>
				<span id="fandian-value" class="fdmoney"><?=$maxPl?>/0%</span>
	</div>
				<div class="fl">
					<strong class="mo">模式：</strong>
					<?php if($this->settings['yuanmosi']==1){?>
					<b value="2.000" data-max-fan-dian="<?=$this->settings['betModeMaxFanDian0']?>" class="danwei dwon">元</b><?}?>
					<?php if($this->settings['jiaomosi']==1){?>
					<b value="0.200" data-max-fan-dian="<?=$this->settings['betModeMaxFanDian1']?>" class="danwei">角</b><?}?>
					<?php if($this->settings['fenmosi']==1){?>
					<b value="0.020" data-max-fan-dian="<?=$this->settings['betModeMaxFanDian2']?>" class="danwei">分</b><?}?>
					<?php if($this->settings['limosi']==1){?>
					<b value="0.002" data-max-fan-dian="<?=$this->settings['betModeMaxFanDian2']?>" class="danwei">厘</b><?}?>
				</div>
				<div class="fl">
                <strong class="bei">倍数：</strong><img src="/skin/images/jian.jpg" class="surbeishu" /><input id="beishu" value="<?=$this->ifs($_COOKIE['beishu'],1)?>" class="bei1"/><img src="/skin/images/jia.jpg" class="addbeishu" />
                </div>  
                <div class="fr">
				<strong class="ge"></strong><span class="tian" onclick="gameActionAddCode()"></span><span class="qing" onclick="gameActionRemoveCode()"></span>
			</div>
			<div class="clear"></div>
        	<div class="prompt" id="game-tip-dom"></div>
    </div>
			
  <div class="touzhu-cont" >
    <table width="100%" cellpadding="0" cellspacing="0">
        
    </table>

			</div>
			<div class="touzhu-bottom">
				<div class="tz-tongji">总投注数：<span id="all-count">0</span>注&nbsp;&nbsp;&nbsp;&nbsp;购买金额：<span id="all-amount">0.00</span>元</div>
				<div class="tz-true-btn"><span class="tou" id="btnPostBet">确定投注</span></div>
				<div class="tz-buytype">
					<label class="zhui"><input type="checkbox" name="zhuiHao" value="1" /></label>
				</div>
				<div class="clear"></div>     
			</div>
</div>
<div class="mainFooter"></div>
</div>		
<div class="content2 wjcont" id="gameFooter">
	<div class="title">
	<ul><li class="t1">单号</li><li class="t2">投注时间</li><li class="t3">彩种</li><li class="t4">玩法</li><li class="t5">期号</li><li class="t6">投注号码</li><li class="t7">倍数</li><li class="t8">金额（元）</li><li class="t9">模式</li><li class="t10">奖金（元）</li><li class="t11">操作</li></ul>
	<div class="clear"></div>
	</div>
	<div class="shuju body" id="order-history"><?php $this->display('index/inc_game_order_history.php'); ?></div>
	<div class="foot"></div>
</div>