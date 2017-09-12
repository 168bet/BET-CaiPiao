<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '游戏记录'); ?>
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
	
	$('.search form input[name=betId]')
	.focus(function(){
		if(this.value=='输入单号') this.value='';
	})
	.blur(function(){
		if(this.value=='') this.value='输入单号';
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
function recordSearch(err, data){
	if(err){
		alert(err);
	}else{
		$('.biao-cont').html(data);
	}
}
function recodeRefresh(){
	$('.biao-cont').load(
		$('.bottompage .pagecurrent').attr('href')
	);
}

function deleteBet(err, code){
	if(err){
		alert(err);
	}else{
		recodeRefresh();
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
    	<form action="/index.php/team/searchGameRecord/<?=$this->userType?>" dataType="html" call="recordSearch" target="ajax">
  		<select name="type" >
        	<option value="0" <?=$this->iff($_REQUEST['type']=='', 'selected="selected"')?>>全部彩种</option>
            <?php
                if($this->types) foreach($this->types as $var){ 
                    if($var['enable']){
            ?>
            <option value="<?=$var['id']?>" <?=$this->iff($_REQUEST['type']==$var['id'], 'selected="selected"')?>><?=$this->iff($var['shortName'], $var['shortName'], $var['title'])?></option>

            <?php }} ?>
        </select>
       <select name="state" >
            <option value="0" selected>所有状态</option>
            <option value="1">已派奖</option>
            <option value="2">未中奖</option>
            <option value="3">未开奖</option>
            <option value="4">追号</option>
            <option value="5">撤单</option>
        </select>
     <select name="mode" >
            <option value="" selected>全部模式</option>
            <option value="2.00">元</option>
            <option value="0.20">角</option>
            <option value="0.02">分</option>
        </select>
      
       <select name="utype" >
            <option value="0" selected>所有人</option>
            <option value="1">我自己</option>
            <option value="2">直属下线</option>
            <option value="3">所有下线</option>
        </select>
       
        <input height="20" value="用户名" name="username"/>
       <input height="20" value="输入单号" name="betId" />
      <input type="text" name="fromTime" class="datainput"  value="<?=$this->iff($_REQUEST['fromTime'],$_REQUEST['fromTime'],date('Y-m-d',$GLOBALS['fromTime']))?>"/>至<input type="text" name="toTime"  class="datainput" value="<?=$this->iff($_REQUEST['toTime'],$_REQUEST['toTime'],date('Y-m-d',$GLOBALS['toTime']))?>"/>
         
      <input type="button" value="查 询" class="btn chazhao">
  </form> 
    </div>
    <div class="display biao-cont">
    	<!--下注列表-->
        <?php $this->display('team/record-list.php'); ?>
        <!--下注列表 end -->
    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 