<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '积分兑换 - 活动中心'); $good=$args[0]; ?>
<script type="text/javascript">
function scoreBeforeSwapGood(){
	if(!this.address.value) throw('请填写邮寄地址');
	if(!this.mobile.value) throw('请填写收件电话');
	if(!this.coinpwd.value) throw('请填写资金密码');
}
function scoreBeforeSwapGood2(){
	
	if(!this.number.value) throw('请填写兑换数量');
	if(isNaN(this.number.value)) throw('兑换数量必须为整数');
	if(!this.coinpwd.value) throw('请填写资金密码');
}
function scoreSwapGood(err, data){
	if(err){
		alert(err);
	}else{
		this.reset();
		alert(data);
		reloadMemberInfo();
	}
}

</script>
</head> 
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
    <div class="display biao-cont">
    	<div class="tips">
        	<p><strong><?=$this->settings['scoreRule']?></strong></p>
        </div>
		<?php if($good['price']>0){ ?>
        <form action="/index.php/score/swapGood" method="post" target="ajax" onajax="scoreBeforeSwapGood2" call="scoreSwapGood">
        <input type="hidden" name="goodId" value="<?=$good['id']?>"/>
        
        <table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
        <tr class='table_b_th'>
        <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>请确认此次兑换</td> 
        </tr>
        <tr height=25 class='table_b_tr_b'>
        <td align="right" width="25%" style="font-weight:bold;"></td>
        <td align="left" width="75%" height="40"><div class="spn11">此次兑换：<span class="spn16"><?=$good['score']?></span>积分=<span class="spn16"><?=$good['price']?></span>元</div></td> 
        </tr> 
        <tr height=25 class='table_b_tr_b'>
        <td align="right" style="font-weight:bold;"></td>
        <td align="left"n height="40" ><div class="spn11">此次兑换将扣除您<span class="spn16"><?=$good['score']?></span>积分！</div></td> 
        </tr> 
        <tr height=25 class='table_b_tr_b'>
        <td align="right" style="font-weight:bold;">兑换数量：</td>
        <td align="left" ><input type="text" name="number" value="1" /></td> 
        </tr>  
        <tr height=25 class='table_b_tr_b'>
        <td align="right" style="font-weight:bold;">资金密码：</td>
        <td align="left" ><input type="password" name="coinpwd" value="" /></td> 
        </tr>  
        <tr height=25 class='table_b_tr_b'>
        <td align="right" style="font-weight:bold;"></td>
        <td align="left"><input type="submit" id='put_button_pass' class="btn" value="确认兑换" > 
        <input type="button" value="等等再说" onClick="history.back()"  class="btn"/> </td> 
        </tr> 
        </table> 
        </form>
        <?php }else{?>
        <form action="/index.php/score/swapGood" method="post" target="ajax" onajax="scoreBeforeSwapGood" call="scoreSwapGood">
        <input type="hidden" name="goodId" value="<?=$good['id']?>"/>
        <table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
        <tr class='table_b_th'>
        <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>请填写您的邮寄收件信息</td> 
        </tr>
        <tr height=25 class='table_b_tr_b'>
        <td align="right" width="25%" style="font-weight:bold;"></td>
        <td align="left" width="75%" height="60"><div class="spn11">此次兑换将扣除您<span class="spn16"><?=$good['score']?></span>积分！</div></td> 
        </tr> 
        <tr height=25 class='table_b_tr_b'>
        <td align="right" style="font-weight:bold;">邮寄地址：</td>
        <td align="left" ><input type="text" name="address" value="<?=$this->user['province'].$this->user['city'].$this->user['address']?>" /></td> 
        </tr> 
        <tr height=25 class='table_b_tr_b'>
        <td align="right" style="font-weight:bold;">收件电话：</td>
        <td align="left" ><input type="text" name="mobile" value="<?=$this->user['mobile']?>" /></td> 
        </tr> 
        <tr height=25 class='table_b_tr_b'>
        <td align="right" style="font-weight:bold;">资金密码：</td>
        <td align="left" ><input type="password" name="coinpwd" value="" /></td> 
        </tr>  
        <tr height=25 class='table_b_tr_b'>
        <td align="right" style="font-weight:bold;"></td>
        <td align="left"><input type="submit" id='put_button_pass' class="btn" value="确认兑换" > 
        <input type="button" value="等等再说" onClick="history.back()"  class="btn"/> </td> 
        </tr>
        </table> 
        </form>
        <?php }?>
    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 