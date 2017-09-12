<input type="hidden" name="playedGroup" value="<?=$this->groupId?>" />
<input type="hidden" name="playedId" value="<?=$this->played?>" />
<input type="hidden" name="type" value="<?=$this->type?>" />
<?php foreach(array('选') as $var){ ?>
<div class="pp" action="lhctmdx" length="1" random="sscRandom">
	<div class="title"><?=$var?>择</div>
	&nbsp;
	&nbsp;
	<input type="button" value="单" class="code" />
	<input type="button" value="双" class="code" />
</div>
<?php
	}
	$maxPl=$this->getPl($this->type, $this->played);
?>
<script type="text/javascript">
$(function(){
	gameSetPl(<?=json_encode($maxPl)?>,false,<?=$this->user['fanDianBdw']?>);
})
</script>
