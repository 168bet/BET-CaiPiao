<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '帐变列表'); ?>
<script type="text/javascript">
$(function(){
	$('.search form input[name=username]')
	.focus(function(){
		if(this.value=='用户名') this.value='';
	})
	.blur(function(){
		if(this.value=='') this.value='用户名';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest('form').submit();
	});

	$('.chazhao').click(function(){
		$(this).closest('form').submit();
	});

	$('.bottompage a[href]').live('click', function(){
		$('.biao-cont').load($(this).attr('href'));
		return false;
	});
});
function searchCoinLog(err, data){
	if(err){
		alert(err);
	}else{
		$('.biao-cont').html(data);
	}
}
</script>
</head> 
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
	<div class="search">
  	  <form action="/index.php/team/searchCoin" dataType="html" target="ajax" call="searchCoinLog">
       <select name="liqType">
            <option value="">所有帐变类型</option>
            <option value="1">账户充值</option>
            <option value="2">游戏返点</option>
            <option value="6">奖金派送</option>
            <option value="7">撤单返款</option>
            <option value="106">账户提现</option>
            <option value="8">提现失败</option>
            <option value="107">提现成功</option>
            <option value="9">系统充值</option>
            <option value="51">活动礼金</option>
            <option value="53">消费佣金</option>
            <option value="101">投注扣款</option>
            <option value="102">追号扣款</option>
			<option value="109">上级充值</option>
			<option value="110">给下级充值扣款</option>
        </select>
        <select name="userType">
            <option value="1">我自己</option>
            <option value="2" selected>直属下线</option>
             <option value="3">所有下线</option> 
       </select>
        <input height="20" value="用户名" name="username"/>
        <input type="text" name="fromTime" class="datainput"  value="<?=$this->iff($_REQUEST['fromTime'],$_REQUEST['fromTime'],date('Y-m-d',$GLOBALS['fromTime']))?>"/>至<input type="text" name="toTime"  class="datainput" value="<?=$this->iff($_REQUEST['toTime'],$_REQUEST['toTime'],date('Y-m-d',$GLOBALS['toTime']))?>"/>
         
      <input type="button" value="查 询" class="btn chazhao">
  </form> 
    </div>
    <div class="display biao-cont">
        <?
            $this->display('team/coin-log.php');
        ?>
    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 