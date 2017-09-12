<!doctype html>
<html>
<input type="hidden" value="<?=$this->user['username']?>" />
<head>
<meta content="IE=EmulateIE8" http-equiv="X-UA-Compatible" />
<meta charset="utf-8"/>
<title>后台管理</title>
<!--本程序由启凡网络提供 网址:http://www.10xf.com/ -->
<link rel="stylesheet" href="/skin/admin/layout.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="/skin/js/jqueryui/skin/smoothness/jquery-ui-1.8.23.custom.css" />
<!--[if IE]>
	<link rel="stylesheet" href="/skin/admin/ie.css" type="text/css" />
	<script src="/skin/js/html5.js"></script>
<![endif]-->
<script src="/skin/js/jquery-1.8.3.min.js"></script>
<script src="/skin/admin/onload.js"></script>
<script src="/skin/admin/wjevent.js"></script>
<script src="/skin/admin/function.js"></script>
<script src="/skin/js/Array.ext.js"></script>
<script src="/skin/js/jqueryui/jquery-ui-1.8.23.custom.min.js"></script>
<script src="/skin/js/jqueryui/i18n/jquery.ui.datepicker-zh-CN.js"></script>
<script src="/skin/js/jquery.messager.js"></script>
<script src="/skin/js/jquery.cookie.js"></script>
<script type="text/javascript">
$(function(){
	$('.quick_search input[name=username]')
	.focus(function(){
		if(this.value=='查找会员') this.value='';
	})
	.blur(function(){
		if(this.value=='') this.value='查找会员';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest('form').submit();
	});
});
function searchUserSubmit(err,data){
	if(err){
		error(err);
	}else{
		$('#main').html(data);
	}
}
var TIP=true;
</script>
</head>

<body>
	<header id="header">
		<hgroup>
			<h1 class="site_title">后台管理系统</h1>
			<h2 class="section_title"><a class="tjgk bq load" href="business/betLog">普通投注</a><a class="tjgk bq load" href="member/index">用户列表</a><a class="tjgk bq load" onclick="rechargModal()" value="充值">账号充值</a><a class="tjgk bq load" method="post" target="ajax" call="clearDataSuccess" title="即将清空程序缓存，是否继续！" dataType="json" href="/admin778899.php/clear/rmfile">清空缓存</a>
            </h2>
            <div class="btn_view_site"><a href="/admin778899.php/user/logout">安全退出</a></div>
		</hgroup>
	</header>
	
	<section id="secondary_bar">
		<div class="user">
			<p>欢迎：<?=$this->user['username']?></p>
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><a>当前位置：<strong>首页</strong></a> <div class="breadcrumb_divider"></div> <span id="position"><a class="current">统计概况</a></span></article>
		</div>
	</section>
	<aside id="sidebar" class="column">
		<form action="/admin778899.php/member/listUser" class="quick_search" call="searchUserSubmit" dataType="html" target="ajax">
		  <input name="username" type="search" placeholder="查找会员" value="查找会员"/>
	    </form>
		<hr/>
		<h3>业务流水<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
			<li><a class="bq yw_b_1" href="business/cash">提现请求</a></li>
			<li><a class="bq yw_b_2" href="business/cashLog">提现记录</a></li>
			<li><a class="bq yw_b_3" href="business/rechargeLog">充值记录</a></li>
			<li><a class="bq yw_b_4" href="business/betLog">普通投注</a></li>
			<li><a class="bq yw_b_7" href="business/coinLog">帐变明细</a></li>
		</ul>
		<h3>开奖数据<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
		<?php foreach($this->getRows("select id,title from {$this->prename}type where enable=1 and isDelete=0 order by sort") as $type){ ?>
			<li><a href="data/index/<?=$type['id']?>" class="k_b_1 bq"><?=$type['title']?></a></li>
		<?php } ?>
		</ul>
        <h3>时间管理<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
			<?php foreach($this->getRows("select id,title from {$this->prename}type where enable=1 and isDelete=0 order by sort") as $type){ ?>
			<li><a href="time/index/<?=$type['id']?>" class="k_b_1 bq"><?=$type['title']?></a></li>
			<?php } ?>
		</ul>
		<h3>数据统计<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
			<li><a href="countData/index" class="s_b_1 bq current">统计概况</a></li>
			<li><a href="countData/betDate" class="s_b_2 bq">综合统计</a></li>
			<li><a href="kjdatas/tests" class="s_b_2 bq">开奖检测</a></li>
		</ul>
		<h3>用户管理<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
			<li><a href="member/add" class="yh_b_1 bq">增加会员</a></li>
			<li><a href="member/index" class="yh_b_2 bq">用户列表</a></li>
            <li><a href="member/bank" class="yh_b_4 bq">银行信息</a></li>
            <li><a href="member/loginLog" class="yh_b_5 bq">登录日志</a></li>
            <li><a href="member/userCountSetting" class="yh_b_5 bq">用户限额设置</a></li>
            
		</ul>
		<h3>管理人员<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
			<li><a href="manage/index" class="g_b_1 bq">管理员列表</a></li>
            <li><a href="manage/controlLog" class="g_b_3 bq">操作日志</a></li>
            <li><a href="manage/loginLog" class="g_b_4 bq">登录日志</a></li>
		</ul>
        <h3><span>佣金管理</span><a>＋</a></h3>
		<ul class="toggle" style="display:none;">
        	<li><a href="commission/conCommissionList" class="bq jf_b_2">消费佣金发放</a></li>
        	<li><a href="commission/lossCommissionList" class="bq jf_b_2">亏损佣金发放</a></li>
		</ul>
		<h3><span>分红管理</span><a>＋</a></h3>
		<ul class="toggle" style="display:none;">
        	<li><a href="bonus/shareBonus" class="bq jf_b_2">分红发放</a></li>
        	<li><a href="bonus/bonusLog" class="bq jf_b_2">分红发放记录</a></li>
		</ul>
		<h3>系统设置<a>＋</a></h3>
		<ul class="toggle" style="display:none;">
			<li><a href="system/settings" class="bq t_b_4">系统设置</a></li>
			<li><a href="system/notice" class="bq t_b_3">公告中心</a></li>
			<li><a href="system/bank" class="bq t_b_5">收款设置</a></li>
			<!--li><a href="system/sysbanklist" class="bq t_b_5">银行管理</a></li-->
			<li><a href="system/type" class="bq t_b_8">彩种管理</a></li>
			<li><a href="system/played" class="bq t_b_9">玩法管理</a></li>
			<li><a href="member/level" class="yh_b_6 bq">等级设置</a></li>
			<li><a href="database/backup" class="g_b_4 bq">数据备份</a></li>
			<!--li><a href="pays/index" class="bq jf_b_2">接口管理</a></li-->
		</ul>
		<h3><span>积分兑换管理</span><a>＋</a></h3>
		<ul class="toggle"  style="display:none;">
        	<li><a href="Score/goodsList" class="bq jf_b_2">兑换管理</a></li>
			<li><a href="Score/pointList" class="bq jf_b_1">兑换记录</a></li>
		</ul>
		
		<ul class="toggle"></ul>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 香雨娱乐后台管理系统</strong></p>
		</footer>
	</aside><!-- end of sidebar -->

	<section id="message-tip"></section>
	<section id="main" class="column"><?php $this->display('count/index.php'); ?></section>
</body>
</html>
