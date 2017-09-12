<input type="hidden" name="playedGroup" value="<?=$this->groupId?>" />
<input type="hidden" name="playedId" value="<?=$this->played?>" />
<input type="hidden" name="type" value="<?=$this->type?>" />
<div class="pp pp11" action="lhc_5bz" length="5" random="lhcRandom">
	<input type="button" value="01" class="code min d" />
	<input type="button" value="02" class="code min s" />
	<input type="button" value="03" class="code min d" />
	<input type="button" value="04" class="code min s" />
	<input type="button" value="05" class="code min d" />
	<input type="button" value="06" class="code min s" />
	<input type="button" value="07" class="code min d" />
	<input type="button" value="08" class="code min s" />
	<input type="button" value="09" class="code min d" />
	<input type="button" value="10" class="code min s" />
	<input type="button" value="11" class="code min d" />
	<input type="button" value="12" class="code min s" />
	<input type="button" value="13" class="code min d" />
	<input type="button" value="14" class="code min s" />
	<input type="button" value="15" class="code min d" />
	<div class="clearfix"></div><span class="title2"></span>
	<input type="button" value="16" class="code min s" />
	<input type="button" value="17" class="code min d" />
	<input type="button" value="18" class="code min s" />
	<input type="button" value="19" class="code min d" />
	<input type="button" value="20" class="code min s" />
	<input type="button" value="21" class="code min d" />
	<input type="button" value="22" class="code min s" />
	<input type="button" value="23" class="code min d" />
	<input type="button" value="24" class="code min s" />
	<input type="button" value="25" class="code min d" />
	<input type="button" value="26" class="code max s" />
	<input type="button" value="27" class="code max d" />
	<input type="button" value="28" class="code max s" />
	<input type="button" value="29" class="code max d" />
	<input type="button" value="30" class="code max s" />
	<div class="clearfix"></div><span class="title2"></span>
	<input type="button" value="31" class="code max d" />
	<input type="button" value="32" class="code max s" />
	<input type="button" value="33" class="code max d" />
	<input type="button" value="34" class="code max s" />
	<input type="button" value="35" class="code max d" />
	<input type="button" value="36" class="code max s" />
	<input type="button" value="37" class="code max d" />
	<input type="button" value="38" class="code max s" />
	<input type="button" value="39" class="code max d" />
	<input type="button" value="40" class="code max s" />
	<input type="button" value="41" class="code max d" />
	<input type="button" value="42" class="code max s" />
	<input type="button" value="43" class="code max d" />
	<input type="button" value="44" class="code max s" />
	<input type="button" value="45" class="code max d" />
	<div class="clearfix"></div><span class="title2"></span>
	<input type="button" value="46" class="code max s" />
	<input type="button" value="47" class="code max d" />
	<input type="button" value="48" class="code max s" />
	<input type="button" value="49" class="code max d" />
</div>
<?php $maxPl=$this->getPl($this->type, $this->played); ?>
<script type="text/javascript">
$(function(){
	gameSetPl(<?=json_encode($maxPl)?>);
})
</script>
