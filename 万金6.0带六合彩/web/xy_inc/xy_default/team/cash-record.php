<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '提现记录 - 代理中心'); ?>
<link rel="stylesheet" type="text/css" href="/skin/js/jquery.datetimepicker.css"/>
<script type="text/javascript">
$(function(){
	$('.chazhao').click(function(){
		$(this).closest('form').submit();
	});
	
	$('.search input[name=username]')
	.focus(function(){
		//console.log(this.value);
		if(this.value=='用户名') this.value='';
	})
	.blur(function(){
		if(this.value=='') this.value='用户名';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest('form').submit();
	});
	
	$('.bottompage a[href]').live('click', function(){
		$('.biao-cont').load($(this).attr('href'));
		return false;
	});
	
	$('.sure[id]').click(function(){
		var $this=$(this),
		cashId=$this.attr('id'),
		
		call=function(err, data){
			if(err){
				alert(err);
			}else{
				this.parent().text('已到帐');
			}
		}
		
		$.ajax('/index.php/cash/toCashSure/'+cashId,{
			dataType:'json',
			
			error:function(xhr, textStatus, errThrow){
				call.call($this, errThrow||textStatus);
			},
			
			success:function(data, textStatus, xhr){
				var errorMessage=xhr.getResponseHeader('X-Error-Message');
				if(errorMessage){
					call.call($this, decodeURIComponent(errorMessage), data);
				}else{
					call.call($this, null, data);
				}
			}
		});
	});
});
function teamBeforeSearchCashRecord(){}
function teamSearchCashRecord(err, data){
	if(err){
		alert(err);
	}else{
		$('.biao-cont').html(data);
	}
}
</script>
</head> 
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
 <div class="title"><span>提现记录</span></div>
 <div class="body">
 <div class="youxi1">
	<form action="/index.php/team/searchCashRecord" target="ajax" onajax="teamBeforeSearchCashRecord" call="teamSearchCashRecord" dataType="html">
       <h2>
       <select name="type" class="text5">
            <option value="0" selected>所有人</option>
            <option value="1">我自己</option>
            <option value="2">直属下线</option>
            <option value="3">所有下线</option>
        </select>
    <input type="text" value="用户名" name="username" class="text8" />
    <input type="text" name="fromTime" value="<?=$this->iff($_REQUEST['fromTime'],$_REQUEST['fromTime'],date('Y-m-d H:i',$GLOBALS['fromTime']))?>" id="datetimepicker" class="text7" />至<input type="text" name="toTime" value="<?=$this->iff($_REQUEST['toTime'],$_REQUEST['toTime'],date('Y-m-d H:i',$GLOBALS['toTime']))?>" id="datetimepicker4" class="text7" />
    <input class="an chazhao" type="submit" value="查询" >
	</h2>
  </form> 
    <div class="biao-cont">
    	<!--内容列表-->
        <?php $this->display('team/cash-record-list.php'); ?>
        <!--内容列表 end -->
    </div>
</div>
</div>
<div class="foot"></div>
</div>
<?php $this->display('inc_footer2.php'); ?>
</body>
</html>
  
   
 