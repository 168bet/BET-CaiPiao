<script type="text/javascript">
$('<div><img width="600" height="400" src="<?=$this->settings['picGG']?>"/></div>').dialog({
	title:<?=json_encode($this->settings['picGGTitle'])?>,
	width:630,
	height:450,
	resizable:false,
	position:['center','center']
});
</script>