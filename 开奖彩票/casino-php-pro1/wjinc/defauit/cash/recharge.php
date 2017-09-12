<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '会员中心 - 在线充值'); ?>
<script type="text/javascript">
$(function(){
	$('form').trigger('reset');
	$(':radio').click(function(){
		var data=$(this).data('bank'),
		box=$('#display-dom');
		
		$('#bank-type-icon', box).attr('src', '/'+data.logo);
		//$('#bank-link', box).attr('href', data.home);
		//$('#bank-account', box).val(data.account);
		//$('#bank-username', box).val(data.username);
		//$('.example2', box).attr('rel', data.rechargeDemo);
		
		if($.cookie('rechargeBank')!=data.id) $.cookie('rechargeBank', data.id, 360*24);
	});
	
	var bankId=$.cookie('rechargeBank')||$(':radio').attr('value');
	$(':radio[value='+bankId+']').click();
	
	$('.copy').click(function(){
		var text=document.getElementById($(this).attr('for')).value;
		if(!CopyToClipboard(text, function(){
			alert('复制成功');
		}));
	});
	
	$('.example2').click(function(){
		var src='/'+$(this).attr('rel');
		if(src) $('<div>').append($('<img>',{src:src,width:'640px',height:'480px'})).dialog({width:630,height:500,title:'充值演示'});
	});
});

function checkRecharge(){
	if(!this.amount.value) throw('请填写充值金额');
	showPaymentFee();
	//if(isNaN(amount)) throw('充值金额错误');
	//if(!this.amount.value.match(/^\d+(\.\d{0,2})?$/)) throw('充值金额错误');
	showPaymentFee();
	var amount=parseInt(this.amount.value),
	$this=$('input[name=amount]',this),
	min=parseInt($this.attr('min')),
	max=parseInt($this.attr('max'));
	min1=parseInt($this.attr('min1')),
	max1=parseInt($this.attr('max1'));
	
	if($('input[name=mBankId]').val()==2||$('input[name=mBankId]').val()==3){
		if(amount<min1) throw('支付宝/财付通充值金额最小为'+min1+'元');
		if(amount>max1) throw('支付宝/财付通充值金额最多限额为'+max1+'元');
		showPaymentFee();
	}else{
		if(amount<min) throw('充值金额最小为'+min+'元');
		if(amount>max) throw('充值金额最多限额为'+max+'元');
		showPaymentFee();

	}
	if(!this.vcode.value) throw('请输入验证码');
	if(this.vcode.value<4) throw('验证码至少4位');
	showPaymentFee();
}
function toCash(err, data){
	//console.log(err);
	if(err){
		alert(err)
		$("#vcode").trigger("click");
	}else{
		$(':password').val('');
		$('input[name=amount]').val('');
		$('.biao-cont').html(data);
	}
}
$(function(){
	$('input[name=amount]').keypress(function(event){
		//console.log(event);
		event.keyCode=event.keyCode || event.charCode;
		return !!(
			// 数字键
			(event.keyCode>=48 && event.keyCode<=57)
			|| event.keyCode==13
			|| event.keyCode==8
			|| event.keyCode==9
			|| event.keyCode==46
		)
	});
});
</script>
<script type="text/javascript">
$(function(){
	$('.example2').click(function(){
		var src='/'+$(this).attr('rel');
		if(src) $('<img>',{src:src}).css({width:'640px',height:'480px'}).dialog({width:660,height:500,title:'充值演示'});
	});
	
	//$('.copy').click(function(){
	//	var text=document.getElementById($(this).attr('for')).value;
	//	if(!CopyToClipboard(text, function(){
	//		alert('复制成功');
	//	}));
	//});
});
</script>

<!--//复制程序 flash+js-->

<script language="JavaScript">
function Alert(msg) {
	alert(msg);
}
function thisMovie(movieName) {
	 if (navigator.appName.indexOf("Microsoft") != -1) {   
		 return window[movieName];   
	 } else {   
		 return document[movieName];   
	 }   
 } 
function copyFun(ID) {
	thisMovie(ID[0]).getASVars($("#"+ID[1]).attr('value'));
}
</script>
<script type="text/javascript" src="/skin/js/swfobject.js"></script>
<script type="text/javascript">
function showPaymentFee() {
   $("#ContentPlaceHolder1_txtMoney").val($("#ContentPlaceHolder1_txtMoney").val().replace(/\D+/g, ''));
   jQuery("#chineseMoney").html(changeMoneyToChinese($("#ContentPlaceHolder1_txtMoney").val()));
        }
</script>
<style type="text/css">
		 .table_b td input
        {
	        height:24px;
	        line-height:24px;
	        padding:2px;
	        border:1px #ddd solid
        }
        .table_b td input:focus
        {
	        border:1px #e29898 solid;
	        background-color:#ffecec
        }
</style>
</head> 
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
	
    <div class="display biao-cont">
        <form action="/index.php/cash/inRecharge" method="post" target="ajax" onajax="checkRecharge" call="toCash" dataType="html">
        <?php
				$sql="select * from {$this->prename}bank_list b, {$this->prename}sysadmin_bank m where m.admin=1 and m.enable=1 and b.isDelete=0 and b.id=m.bankId";
				$banks=$this->getRows($sql);
					
				if($banks){?>
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
    <tr class='table_b_th'>
      <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>在线充值</td> 
    </tr>

	<tr height=25 class='table_b_tr_b' >
      <td align="center" class="copys" height="80"><div style="display:inline;color:#FF0000">自动充值须知：<div></td>
      <td align="left" >
	  <p>每天的充值处理时间为：<b style="display:inline;color:#FF0000;">早上 &nbsp 6:00 &nbsp 至  次日凌晨 &nbsp 3:00</b></p>
	  <p></p>
	  <p>充值后，<b style="display:inline;color:#FF0000;">请手动刷新&nbsp&nbsp</b>你的余额及查看相关账变信息，若超过5分钟未上分，请于客服联系</p>
	  <p></p>
	  <p>选择充值银行，填写充值金额，点击[下一步]后，将有详细的文字说明</p>
      </td> 
    </tr>
    
    <tr height=25 class='table_b_tr_b' >
      <td align="center" class="copys">选择充值银行：</td>
      <td align="left" ><?php
								
								$set=$this->getSystemSettings();
								if($banks) foreach($banks as $bank){
							?>
							<div class="bankchoice">
								<label><input value="<?=$bank['id']?>" type="radio" name="mBankId" data-bank='<?=json_encode($bank)?>' style="width:auto;" /><span style="background:url(/<?=$bank['logo']?>);" ></span></label>
							</div>
							<?php } ?>
                            <div class="clear"></div>
                            </td> 
    </tr>
    <tr height=25 class='table_b_tr_b' id="display-dom">
      <td align="center" class="copys" height="100">银行类型：</td>
      <td align="left" ><img id="bank-type-icon" class="bankimg" src="" title=""/><div class="clear"></div></td> 
    </tr>
    <tr height=25 class='table_b_tr_b'>
      <td align="center" class="copys">充值金额：</td>
      <td align="left" ><input name="amount" id="ContentPlaceHolder1_txtMoney" min="<?=$set['rechargeMin']?>" max="<?=$set['rechargeMax']?>" min1="<?=$set['rechargeMin1']?>" max1="<?=$set['rechargeMax1']?>" value="" onkeyup="showPaymentFee();"/><div style="display:inline;" class="spn12">(  单笔充值限额   最低： <b style="color:#FF0000"><?=$set['rechargeMin']?></b>  元，最高：  <b style="color:#FF0000"><?=$set['rechargeMax']?></b>  元 )</div></td>
    </tr>
	<tr height=25 class='table_b_tr_b'>
      <td align="center" class="copys">充值金额(大写)：</td>
      <td align="left" ><strong style="color:#FF0000;margin-left:10px" id="chineseMoney"></strong></td>
    </tr>
	<tr height=25 class='table_b_tr_b'>
      <td align="center" class="copys">验证码：</td>
      <td align="left" ><input name="vcode" type="text" style="ime-mode: disabled; width: 75px;" /><b class="yzmNum"><img width="58" height="24" border="0" style="cursor:pointer;margin-bottom:0px;" id="vcode" alt="看不清？点击更换" align="absmiddle" src="/index.php/user/vcode/<?=$this->time?>" title="看不清楚，换一张图片" onclick="this.src='/index.php/user/vcode/'+(new Date()).getTime()"/></b></td>
    </tr>
     <tr height=25 class='table_b_tr_b'>
      <td align="center" style="font-weight:bold;"></td>
      <td align="left"><input type="button" id='put_button_pass' class="btn darwingbtn" value="下一步"  onclick="$(this).closest('form').submit()">
        <input type="reset" value="重置" class="btn"/> </td> 
    </tr> 
</table> 
                <?php }else{ ?>
                <div style=" margin-top:30px; text-align:center;color:#F00;">
					充值暂停！
                </div>
                <?php }?>
</form>
    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 