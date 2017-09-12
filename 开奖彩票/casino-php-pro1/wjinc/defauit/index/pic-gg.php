<script type="text/javascript">
$('<div><img width="290" height="160" src="<?=$this->settings['picGG']?>"/></div>').dialog({
	title:<?=json_encode($this->settings['picGGTitle'])?>,
	width:320,
	height:210,
	resizable:false,
	position:['right','bottom']
});
</script>