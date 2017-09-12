<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '会员管理 - 代理中心'); ?>
<script type="text/javascript">
$(function(){
	$('.search select').change(function(){
		//this.form.submit();
		$(this).closest('form').submit();
	});
	$('.chazhao').click(function(){
		$(this).closest('form').submit();
	});
	
	$('.search input[name=username]')
	.focus(function(){
		if(this.value=='用户名') this.value='';
	})
	.blur(function(){
		if(this.value=='') this.value='用户名';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest('form').submit();
	});
	
	$('.bottompage a[href], .caozuo').live('click', function(){
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
function teamBeforeSearchMember(){}
function teamSearchMember(err, data){
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
  		<form action="/index.php/team/searchMember" dataType="html" target="ajax" method="get" onajax="teamBeforeSearchMember" call="teamSearchMember">
  		
  		<select name="type">
            <option value="0">所有人</option>
            <option value="1">我自己</option>
            <option value="2" selected>直属下线</option>
            <option value="3">所有下线</option>
        </select>
       <input height="20" value="用户名" name="username"/>         
      <input type="button" value="查 询" class="btn chazhao">
      <input type="button" value="添加会员" class="btn" onclick="window.location='/index.php/team/addMember'">
      
  </form> 
    </div>
    <div class="display biao-cont">
    	<!--内容列表-->
         <?php $_GET['type']=2; $this->display('team/member-search-list.php'); ?>
        <!--内容列表 end -->
    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 