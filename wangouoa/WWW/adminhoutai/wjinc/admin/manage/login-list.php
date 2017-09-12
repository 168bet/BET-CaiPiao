<?php
	$para=$_GET;
	// 用户名限制
	if($para['username']){
		$para['username']=wjStrFilter($para['username']);
		if(!ctype_alnum($para['username'])) throw new Exception('用户名包含非法字符,请重新输入');
		$userWhere=" and username='{$para['username']}'";
	}

	// IP限制
	if($para['ip']=ip2long($para['ip'])){
		$para['ip']=wjStrFilter($para['ip']);
		$ipWhere=" and loginIp='{$para['ip']}'";
	}
	
	// 时间限制
	if($_REQUEST['fromTime'] && $_REQUEST['toTime']){
		$fromTime=strtotime($_REQUEST['fromTime']);
		$toTime=strtotime($_REQUEST['toTime'])+24*3600;
		$timeWhere="and loginTime between $fromTime and $toTime";
	}elseif($_REQUEST['fromTime']){
		$fromTime=strtotime($_REQUEST['fromTime']);
		$timeWhere="and loginTime>=$fromTime";
	}elseif($_REQUEST['toTime']){
		$toTime=strtotime($_REQUEST['toTime'])+24*3600;
		$timeWhere="and loginTime<$fromTime";
	}

	$sql="select l.* from {$this->prename}sysadmim_session l, {$this->prename}sysmember u where u.uid=l.uid and admin=1 $timeWhere $userWhere $ipWhere order by loginTime desc";
	//echo $sql;exit;
	$data=$this->getPage($sql, $this->page, $this->pageSize);
?>
<article class="module width_full">
<input type="hidden" value="<?=$this->user['username']?>" />
    <header>
    	<h3 class="tabs_involved">登录日志
            <form action="/admin778899.php/manage/loginLog" target="ajax" dataType="html" call="defaultSearch" class="submit_link wz">
                会员名：<input type="text" class="alt_btn" style="width:100px;" name="username"/>&nbsp;&nbsp;
				IP：<input type="text" class="alt_btn" style="width:100px;" name="ip"/>&nbsp;&nbsp;
                时间：从 <input type="date" class="alt_btn" name="fromTime"/> 到 <input type="date" class="alt_btn" name="toTime"/>&nbsp;&nbsp;
                <input type="submit" value="查找" class="alt_btn">
            </form>
        </h3>
    </header>
	<table class="tablesorter" cellspacing="0">
	<thead>
		<tr>
			<td>ID</td>
			<td>用户名</td>
			<td>IP</td>
			<td>浏览器</td>
			<td>操作系统</td>
			<td>登录时间</td>
			<td>操作</td>
		</tr>
	</thead>
	<tbody id="nav01">
	<?php if($data['data']){
		foreach($data['data'] as $var){ ?>
		<tr>
			<td><?=$var['id']?></td>
			<td><?=$var['username']?></td>
			<td><?=long2ip($var['loginIP'])?></td>
			<td><?=$var['browser']?></td>
			<td><?=$var['os']?></td>
			<td><?=date('Y-m-d H:i:s', $var['loginTime'])?></td>
			<td><a href="member/loginLog?username=<?=$var['username']?>">只看此人</a></td>
		</tr>
	<?php }
		}else{
	 ?>
     	<tr>
			<td colspan="8">暂无</td>
		</tr>
     <?php
		}
	 ?>
	</tbody>
    </table>
	<footer>
	<?php
		$rel=get_class($this).'/loginLog-{page}?'.http_build_query($_GET,'','&');
		$this->display('inc/page.php', 0, $data['total'], $rel, 'defaultReplacePageAction');
	?>
	</footer>
</article>
<script type="text/javascript">  
ghhs("nav01","tr");  
</script>