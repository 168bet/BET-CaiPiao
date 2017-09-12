<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '积分兑换 - 活动中心'); $good=$args[0]; ?>
<script type="text/javascript">
function scoreBeforeSwapGood(){
	if(!this.getcount.value) throw('请填写兑换数量');
	if(isNaN(this.getcount.value)) throw('兑换数量必须为整数');
	if(!this.coinpwd.value) throw('请填写资金密码');
}
function scoreSwapGood(err, data){
	if(err){
		alert(err);
	}else{
		this.reset();
		reloadMemberInfo();
		alert(data);
	}
}
$(function(){
	$('input[name=number]').keypress(function(event){
		event.keyCode=event.keyCode||event.charCode;
		
		return !!(
			// 数字键
			(event.keyCode>=48 && event.keyCode<=57)
			|| event.keyCode==13
			|| event.keyCode==8
			|| event.keyCode==46
			|| event.keyCode==9
		)
	});
});
</script>
</head> 
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
 <div class="title"><span>积分兑换</span></div>
 <div class="body">
 <div class="mima1">
		<?php if($good['price']>0){ ?>
        <form action="/index.php/score/swapGood" method="post" target="ajax" onajax="scoreBeforeSwapGood2" call="scoreSwapGood">
        <input type="hidden" name="goodId" value="<?=$good['id']?>"/>
     <h2><em><?=$good['score']?></em>积分=<em><?=$good['price']?></em>元,请确认此次兑换</h2>
     <ul class="score">
     <li style="font-size:16px"><span></span>此次兑换：<em><?=$good['score']?></em>积分=<em><?=$good['price']?></em>元</li>
     <li style="font-size:16px"><span></span>此次兑换将扣除您<em><?=$good['score']?></em>积分！</li>
	 <li><span>兑换数量：</span><input type="text" name="number" style="width:110px;"class="text4" value="1"/></li>
     <li><span>资金密码：</span><input type="password" name="coinpwd" class="text4" /></li>
     
     <li class="tijiao"><input id="addmenber" class="an" type="submit" value="确认兑换" ><input type="button" id="button" class="an" value="等等再说" onClick="history.back()" /></li>
    </ul>
     </form>
        <?php }else{?>
        <form action="/index.php/score/swapGood" method="post" target="ajax" onajax="scoreBeforeSwapGood2" call="scoreSwapGood">
        <input type="hidden" name="goodId" value="<?=$good['id']?>"/>
     <h2><em><?=$good['score']?></em>积分=<em><?=$good['price']?></em>元,请确认此次兑换</h2>
     <ul class="score">
     <li style="font-size:16px"><span></span>此次兑换：<em><?=$good['score']?></em>积分=<em><?=$good['price']?></em>元</li>
     <li style="font-size:16px"><span></span>此次兑换将扣除您<em><?=$good['score']?></em>积分！</li>
	 <li><span>兑换数量：</span><input type="text" name="number" style="width:110px;"class="text4" value="1"/></li>
     <li><span>资金密码：</span><input type="password" name="coinpwd" class="text4" /></li>
     
     <li class="tijiao"><input id="addmenber" class="an" type="submit" value="确认兑换" ><input type="button" id="button" class="an" value="等等再说" onClick="history.back()" /></li>
    </ul>
     </form>
        <?php }?>
    </div>
 <div class="bank"></div>
</div>
<div class="foot"></div>
</div>
<?php $this->display('inc_footer.php'); ?> 
</body>
</html>