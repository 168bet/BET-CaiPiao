<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '会员中心 - 提现记录'); ?>
<link rel="stylesheet" type="text/css" href="/skin/js/jquery.datetimepicker.css"/>
<script type="text/javascript">
$(function(){
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
</script>
</head> 
<body id="bg">
<?php $this->display('inc_header.php'); ?>
<div class="content3 wjcont">
 <div class="title"><span>提现记录</span></div>
 <div class="body">
 <div class="youxi1">
 <form action="/index.php/cash/toCashLog" method="get">
  		<h2>
        <input type="text" name="fromTime" value="<?=$this->iff($_REQUEST['fromTime'],$_REQUEST['fromTime'],date('Y-m-d H:i',$GLOBALS['fromTime']))?>" id="datetimepicker" class="text7" />至<input type="text" name="toTime" value="<?=$this->iff($_REQUEST['toTime'],$_REQUEST['toTime'],date('Y-m-d H:i',$GLOBALS['toTime']))?>" id="datetimepicker4" class="text7" />
        <input type="submit" class="an chazhao" value="查 询">
		</h2>
  </form> 
    <div class="biao-cont">
        <!--下注列表-->
        <table width="900" border="0" cellspacing="0" cellpadding="0">
            <tr class="top">
                <td>提现金额</td>
                <td>申请时间</td>
                <td>提现银行</td>
                <td>银行尾号</td>
                <td>状态</td>
            </tr>
            <?php
                $sql="select c.*, b.name bankName from {$this->prename}member_cash c, {$this->prename}bank_list b where b.isDelete=0 and c.isDelete=0 and c.bankId=b.id and uid={$this->user['uid']}";
                if($_GET['fromTime'] && $_GET['endTime']){
                    $fromTime=strtotime($_GET['fromTime']);
                    $endTime=strtotime($_GET['endTime']);
                    $sql.=" and actionTime between $fromTime and $endTime";
                }elseif($_GET['fromTime']){
                    $sql.=' and actionTime>='.strtotime($_GET['fromTime']);
                }elseif($_GET['endTime']){
                    $sql.=' and actionTime<'.(strtotime($_GET['endTime']));
                }else{
					
					if($GLOBALS['fromTime'] && $GLOBALS['toTime']) $sql.=' and actionTime between '.$GLOBALS['fromTime'].' and '.$GLOBALS['toTime'].' ';
				}
                
                $stateName=array('已到帐', '正在办理', '已取消', '已支付', '失败');
                
                $list=$this->getPage($sql, $this->page, $this->pageSize);
                if($list['data']) foreach($list['data'] as $var){
            ?>
            <tr>
                <td><?=$var['amount']?></td>
                <td><?=date('m-d H:i:s', $var['actionTime'])?></td>
                <td><?=$var['bankName']?></td>
                <td><?=preg_replace('/^.*(.{4})$/', "$1", $var['account'])?></td>
                <td>
                <?php
                    if($var['state']==3){
                        echo '<div class="sure" id="', $var['id'], '"></div>';
                    }else if($var['state']==4){
                        echo '<span title="'.$var['info'].'" style="cursor:pointer; color:#f00;">'.$stateName[$var['state']].'</span>';
                    }else{
                        echo $stateName[$var['state']];
                    }
                ?>
                </td>
            </tr>
			<?php }else{ ?>
            <tr>
                <td colspan="7" align="center">没有提现记录</td>
            </tr>
          <?php } ?>
        </table>
        <?php
            $this->display('inc_page.php', 0, $list['total'], $this->pageSize, "/index.php/cash/toCashLog-{page}?fromTime={$_GET['fromTime']}&endTime={$_GET['endTime']}");
        ?>
        <!--下注列表 end -->
    </div>
</div>
</div>
<div class="foot"></div>
</div>
<?php $this->display('inc_footer2.php'); ?> 
</body>
</html>