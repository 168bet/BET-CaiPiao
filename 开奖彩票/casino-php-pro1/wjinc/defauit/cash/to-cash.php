<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '会员中心 - 申请提现'); ?>
<script type="text/javascript">
function beforeToCash(){
	if(!this.amount.value) throw('请填写提现金额');
	if(!this.amount.value.match(/^[0-9]*[1-9][0-9]*$/)) throw('提现金额错误');
	showPaymentFee()
	var amount=parseInt(this.amount.value);
	if($('input[name=bankId]').val()==2||$('input[name=bankId]').val()==3){
		if(amount<parseFloat(<?=json_encode($this->settings['cashMin1'])?>)) throw('支付宝/财付通提现最小限额为<?=$this->settings['cashMin1']?>元');
		if(amount>parseFloat(<?=json_encode($this->settings['cashMax1'])?>)) throw('支付宝/财付通提现最大限额为<?=$this->settings['cashMax1']?>元');
		showPaymentFee()
	}else{
		if(amount<parseFloat(<?=json_encode($this->settings['cashMin'])?>)) throw('提现最小限额为<?=$this->settings['cashMin']?>元');
		if(amount>parseFloat(<?=json_encode($this->settings['cashMax'])?>)) throw('提现最大限额为<?=$this->settings['cashMax']?>元');
		showPaymentFee()
	}
	if(!this.coinpwd.value) throw('请输入资金密码');
	if(this.coinpwd.value<6) throw('资金密码至少6位');
	showPaymentFee()
}

function toCash(err, data){
	if(err){
		alert(err)
	}else{
		reloadMemberInfo();
		$(':password').val('');
		$('input[name=amount]').val('');
		window.location.href="/index.php/cash/toCashResult";
		//alert(data);
		//$.messager.lays(200, 100);
	    //$.messager.anim('fade', 1000);
	    //$.messager.show("<strong>系统提示</strong>", "提款成功！<br />将在10分钟内到账！",0);

	}
}
$(function(){
	$('input[name=amount]').keypress(function(event){
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
	
	//var form=$('form')[0];
	//form.account.value='';
	//form.username.value='';
});
</script>
<script type="text/javascript">
function showPaymentFee() {
   $("#ContentPlaceHolder1_txtMoney").val($("#ContentPlaceHolder1_txtMoney").val().replace(/\D+/g, ''));
   jQuery("#chineseMoney").html(changeMoneyToChinese($("#ContentPlaceHolder1_txtMoney").val()));
        }
</script>
 <?php
	$bank=$this->getRow("select m.*,b.logo logo, b.name bankName from {$this->prename}member_bank m, {$this->prename}bank_list b where m.bankId=b.id and b.isDelete=0 and m.uid=? limit 1", $this->user['uid']);
	$this->freshSession(); 
    $date=strtotime('00:00:00');
	$date2=strtotime('00:00:00');
	$time=strtotime(date('Y-m-d', $this->time));
	$cashAmout=0;
		$rechargeAmount=0;
		$rechargeTime=strtotime('00:00');
		if($this->settings['cashMinAmount']){
			$cashMinAmount=$this->settings['cashMinAmount']/100;
			$gRs=$this->getRow("select sum(case when rechargeAmount>0 then rechargeAmount else amount end) as rechargeAmount from {$this->prename}member_recharge where  uid={$this->user['uid']} and state in (1,2,9) and isDelete=0 and rechargeTime>=".$rechargeTime);
			if($gRs){
				$rechargeAmount=$gRs["rechargeAmount"];
			}
		}
	$cashAmout=$this->getValue("select sum(mode*beiShu*actionNum) from {$this->prename}bets where actionTime>={$rechargeTime} and uid={$this->user['uid']} and isDelete=0");
	$times=$this->getValue("select count(*) from {$this->prename}member_cash where actionTime>=$time and uid=?", $this->user['uid']);
?>
</head> 
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
    <div class="display biao-cont">
 	<?php if($bank['bankId']){?>
<form action="/index.php/cash/ajaxToCash" method="post" target="ajax" datatype="json" onajax="beforeToCash" call="toCash">
<?php
	$key='9cc1ab94e49d22ff';
    $timess=md5(time());
    $token=md5($key.$timess);
?>
	<input name="CANKIF_BOK" type="hidden" value="<?=$timess?>" />
	<input name="TOLKEASF_ASH" type="hidden" value="<?=$token?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="4" class='table_b'>
    <tr class='table_b_th'>
      <td align="left" style="font-weight:bold;padding-left:10px;" colspan=2>提款申请</td> 
    </tr>
    
    <tr height=25 class='table_b_tr_b' >
      <td align="right" class="copys" height="80" style="color:red;">提示信息：</td>
      <td align="left" ><p>您是尊贵的&nbsp&nbsp<strong style="font-size:16px;color:red;">VIP<?=$this->user['grade']?></strong>&nbsp&nbsp客户，每天限提&nbsp&nbsp<strong style="font-size:16px;color:red;"><?=$this->getValue("select maxToCashCount from {$this->prename}member_level where level=?", $this->user['grade'])?></strong>&nbsp&nbsp次,今天您已经成功发起了&nbsp&nbsp<strong style="font-size:16px;color:green"><?=$times?></strong>&nbsp&nbsp次提现申请</p>
	                    <p>每天的提现处理时间为：<strong style="font-size:16px;color:red;" >
    早上 <?=$this->settings['cashFromTime']?> 至 晚上
    <?=$this->settings['cashToTime']?></strong></p>
	                    <p>提现10分钟内到账。(如遇高峰期，可能需要延迟到三十分钟内到帐)</p>
	                    <p style="color:blue;">银行卡用户每日最小提现&nbsp&nbsp 
    <strong style="color:green;font-size:16px;"><?=$this->settings['cashMin']?></strong>&nbsp&nbsp元，最大提提现&nbsp&nbsp 
    <strong style="color:green;font-size:16px;"><?=$this->settings['cashMax']?></strong>&nbsp&nbsp元。财付通/支付宝用户,最小提现&nbsp&nbsp<strong style="color:green;font-size:16px;"><?=$this->settings['cashMin1']?></strong>&nbsp&nbsp元，最大提现&nbsp&nbsp<strong style="color:green;font-size:16px;"><?=$this->settings['cashMax1']?></strong>&nbsp&nbsp元。
	</td> 
    </tr>
	<tr height=25 class='table_b_tr_b' >
      <td align="right" class="copys">今日消费：</td>
      <td align="left">今日投注：&nbsp&nbsp<?=$this->iff($cashAmout,$cashAmout,0)?> &nbsp&nbsp今天充值：&nbsp&nbsp<?=$this->iff($rechargeAmount,$rechargeAmount,0)?> &nbsp&nbsp您今日消费比例已达到：&nbsp<strong style="color:red" id="bili"><?=$this->iff($rechargeAmount,round($cashAmout/$rechargeAmount*100,1),100)?>&nbsp%</strong>&nbsp&nbsp</td> 
    </tr>
	<tr height=25 class='table_b_tr_b' >
      <td align="right" class="copys">消费比例说明：</td>
      <td align="left"><p>计算公式：今日消费比例=今日投注量/今日充值额</p>
	                   <p>(消费比例未达到系统设置的&nbsp&nbsp<strong style="color:red" id="sysbili"><?=$this->settings['cashMinAmount']?></strong>&nbsp&nbsp%，则不能提款.)</p>
					   <p><strong style="color:red">如果今日未充值，则消费比例自动为100%，即使未投注也可随时提款。</strong></p>
                       <p>系统是从当天凌晨0点至第二天凌晨0点算一天。</p></td> 
    </tr>
	<tr height=25 class='table_b_tr_b' >
      <td align="right" class="copys" >银行类型：</td>
      <td align="left" ><img class="bankimg" src="/<?=$bank['logo']?>" title="<?=$bank['bankName']?>"/>
                            </td> 
    </tr>
    <tr height=25 class='table_b_tr_b' >
      <td align="right" class="copys" >银行账号：</td>
      <td align="left" ><input  readonly value="<?=preg_replace('/^.*(\w{4})$/', '***\1', $bank['account'])?>" /></td> 
    </tr>
     <tr height=25 class='table_b_tr_b'>
      <td align="right" class="copys">账户名：</td>
      <td align="left" ><input readonly value="<?=preg_replace('/^(\w).*$/', '\1**', $bank['username'])?>" /></td> 
    </tr>
     <tr height=25 class='table_b_tr_b'>
      <td align="right" class="copys">提款金额：</td>
      <td align="left" ><input name="amount" class="spn9"  value="" id="ContentPlaceHolder1_txtMoney" onkeyup="showPaymentFee();"/>
      <div class="spn12" style="display:inline;" >( 单笔提现限额：最低：&nbsp<strong style="color:red"><?=$this->settings['cashMin']?></strong>&nbsp元， 最高：&nbsp<strong style="color:red"><?=$this->settings['cashMax']?></strong>&nbsp元 )</div>
      </td> 
    </tr>
	<tr height=25 class='table_b_tr_b'>
      <td align="right" class="copys">提款金额(大写)：</td>
      <td align="left" ><strong style="color:red;margin-left:10px" id="chineseMoney"></strong></td> 
    </tr>
    <tr height=25 class='table_b_tr_b'>
      <td align="right" class="copys">资金密码：</td>
      <td align="left" ><input name="coinpwd" type="password" value="" /></td> 
    </tr>
     <tr height=25 class='table_b_tr_b'>
      <td align="right" style="font-weight:bold;"></td>
      <td align="left"><input type="button" id='put_button_pass' class="btn darwingbtn" value="提交申请"  onclick="$(this).closest('form').submit()">
        <input type="reset" value="重置" class="btn"/> </td> 
    </tr> 

   
</table> 

</form>
    <!--div class="tips">
        <dl>
            <dt>提现说明：</dt>
            <dd>1.每天最多可以申请<strong class="red"><?=$this->getValue("select maxToCashCount from {$this->prename}member_level where level=?", $this->user['grade'])?></strong>次提现，最大提现金额<strong class="red"><?=$this->settings['cashMax']?></strong>元;</dd>
            <dd>2.提现10分钟内到账。(如遇高峰期，可能需要延迟到三十分钟内到帐);</dd>
            <dd>3.每天提现时间在<strong class="red"><?=$this->settings['cashFromTime']?>—<?=$this->settings['cashToTime']?></strong>;</dd>
            <dd>4.财付通用户,最小提现<strong class="red"><?=$this->settings['cashMin1']?></strong>元，最大提现<strong class="red"><?=$this->settings['cashMax1']?></strong>元。</dd>
        </dl>
    </div-->
  		<?php }else{?>
            <div style=" margin-top:30px; text-align:center;">尚未设置您的银行账户！&nbsp;&nbsp;<a href="/index.php/safe/info" style="color:#F00; text-decoration:none;">马上设置>></a></div>
        <?php }?>

    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 