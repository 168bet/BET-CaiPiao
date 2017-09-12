<?php 
	if($this->controller=='Index'){
		$wjControl="myIndex";
	}
	else if($this->controller=='Main'){
		$wjControl="myMain";
	}
	else if($this->controller=='Record'){
		$wjControl="myRecord";
	}
	else if($this->controller=='Report'){
		$wjControl="myReport";
	}
	else if($this->controller=='Team'){
		$wjControl="myTeam";
	}
	else if($this->controller=='Score'){
		$wjControl="myScore";
	}
	else{
		$wjControl="myAcount";
	}
?>	
<div class="head">
    <!--网站公告-->
    <?php if($this->settings['webGG']){ ?>
    <div class="notice">
        <marquee behavior="scroll" direction="left" height="30" style="line-height:30px;" loop="-1" scrollamount="2" scrolldelay="100" onMouseOut="this.start()" onMouseOver="this.stop()">
            <?=$this->settings['webGG']?>
            
        </marquee>
    </div>
    <?php } ?>
    <!--网站公告结束-->
    <div class="xiazai"><a href="#" title="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div>
	<div class="pifu changebg"><span>换肤：</span><a href="#" rel="d2e5f2 url(/skin/images/bg/bg1.jpg) no-repeat top center"><img src="/skin/images/fengge1.jpg" alt=""></a><a href="#" rel="d2e5f2 url(/skin/images/bg/bg2.jpg) no-repeat top center"><img src="/skin/images/fengge2.jpg" alt=""></a><a href="#" rel="d2e5f2 url(/skin/images/bg/bg3.jpg) no-repeat top center"><img src="/skin/images/fengge3.jpg" alt=""></a><a href="#" rel="d2e5f2 url(/skin/images/bg/bg4.jpg) no-repeat top center"><img src="/skin/images/fengge4.jpg" alt=""></a></div>
</div>
<div class="clear"></div>
<div class="top">
	<div class="logo"><a href="#" title=""><img src="/skin/images/logo.png" alt=""></a></div>
    <div class="denglu userInfo"><?php $this->display('index/inc_user.php'); ?></div>
    <div class="kefu"><a href="#" title="" class="kefu1" onclick="wjkf168();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div>
</div>
<div class="clear"></div>

<div class="navbg">
	<div class="inav">
		<ul id="nav" class="nav">
			<li class="nLi nlibg1 <?=$this->iff($wjControl=='myIndex', 'on')?>"><a href="#">购彩大厅</a>
					<ul class="sub reset" style="display: none;">
					    <li><a href="/index.php/index/game/5/72"><img src="/skin/images/n22.png" alt="" />香港一分彩</a></li>
					    <li><a href="/index.php/index/game/26/72"><img src="/skin/images/n21.png" alt="" />香港二分彩</a></li>
					    <li><a href="/index.php/index/game/14/72"><img src="/skin/images/n18.png" alt="" />香港五分彩</a></li>
					    <li><a href="/index.php/index/game/1/2"><img src="/skin/images/n19.png" alt="" />重庆时时彩</a></li>
                        <li><a href="/index.php/index/game/3/6"><img src="/skin/images/n19.png" alt="" />江西时时彩</a></li>
                        <li><a href="/index.php/index/game/12/6"><img src="/skin/images/n19.png" alt="" />新疆时时彩</a></li>
                        <li><a href="/index.php/index/game/35/6"><img src="/skin/images/n19.png" alt="" />天津时时彩</a></li>
                        <li><a href="/index.php/index/game/11/6"><img src="/skin/images/n16.png" alt="" />上海时时乐</a></li>
					    <li><a href="/index.php/index/game/55/10"><img src="/skin/images/n34.png" alt="" />快速六合彩</a></li>
					    <li><a href="/index.php/index/game/59/10"><img src="/skin/images/n34.png" alt="" />香港六合彩</a></li>
					    <li><a href="/index.php/index/game/6/10"><img src="/skin/images/n14.png" alt="" />广东11选5</a></li>
						<li><a href="/index.php/index/game/15/10"><img src="/skin/images/n15.png" alt="" />重庆11选5</a></li>
						<li><a href="/index.php/index/game/16/10"><img src="/skin/images/n16.png" alt="" />江西多乐彩</a></li>
						<li><a href="/index.php/index/game/7/10"><img src="/skin/images/n14.png" alt="" />山东11选5</a></li>
						<li><a href="/index.php/index/game/45/10"><img src="/skin/images/n15.png" alt="" />浙江11选5</a></li>
						<li><a href="/index.php/index/game/44/10"><img src="/skin/images/n16.png" alt="" />天津11选5</a></li>
						<li><a href="/index.php/index/game/43/10"><img src="/skin/images/n14.png" alt="" />江苏11选5</a></li>
						<li><a href="/index.php/index/game/42/10"><img src="/skin/images/n14.png" alt="" />吉林11选5</a></li>
						<li><a href="/index.php/index/game/41/10"><img src="/skin/images/n14.png" alt="" />湖北11选5</a></li>
						<li><a href="/index.php/index/game/40/10"><img src="/skin/images/n14.png" alt="" />贵州11选5</a></li>
						<li><a href="/index.php/index/game/22/10"><img src="/skin/images/n14.png" alt="" />上海11选5</a></li>
						<li><a href="/index.php/index/game/28/10"><img src="/skin/images/n14.png" alt="" />龙江11选5</a></li>
						<li><a href="/index.php/index/game/48/10"><img src="/skin/images/n14.png" alt="" />安徽11选5</a></li>
						<li><a href="/index.php/index/game/60/12"><img src="/skin/images/n33.png" alt="" />全天快3</a></li>	
						<li><a href="/index.php/index/game/25/12"><img src="/skin/images/n33.png" alt="" />江苏快3</a></li>	
						<li><a href="/index.php/index/game/30/12"><img src="/skin/images/n33.png" alt="" />吉林快3</a></li>
						<li><a href="/index.php/index/game/39/12"><img src="/skin/images/n33.png" alt="" />安徽快3</a></li>	
						<li><a href="/index.php/index/game/49/12"><img src="/skin/images/n33.png" alt="" />上海快3</a></li>	
						<li><a href="/index.php/index/game/50/12"><img src="/skin/images/n33.png" alt="" />湖北快3</a></li>
						<li><a href="/index.php/index/game/51/12"><img src="/skin/images/n33.png" alt="" />蒙古快3</a></li>	
						<li><a href="/index.php/index/game/52/12"><img src="/skin/images/n33.png" alt="" />广西快3</a></li>
					        <li><a href="/index.php/index/game/20/26"><img src="/skin/images/n17.png" alt="" />北京PK10</a></li>
						<li><a href="/index.php/index/game/9/12"><img src="/skin/images/n12.png" alt="" />福彩3D</a></li>
						<li><a href="/index.php/index/game/10/12"><img src="/skin/images/n13.png" alt="" />排列3P</a></li>		
						<li><a href="/index.php/index/game/53/12"><img src="/skin/images/n12.png" alt="" />排列五</a></li>
						<li><a href="/index.php/index/game/17/10"><img src="/skin/images/n15.png" alt="" />广快快乐十分</a></li>
						<li><a href="/index.php/index/game/18/10"><img src="/skin/images/n15.png" alt="" />重庆快乐十分</a></li>
						<li><a href="/index.php/index/game/27/10"><img src="/skin/images/n15.png" alt="" />湖南幸运农场</a></li>
						<li><a href="/index.php/index/game/46/10"><img src="/skin/images/n15.png" alt="" />天津快乐十分</a></li>
						<li><a href="/index.php/index/game/47/10"><img src="/skin/images/n15.png" alt="" />龙江快乐十分</a></li>
					</ul>
            </li>
            <li class="nLi nlibg2 <?=$this->iff($wjControl=='myRecord', 'on')?>"><a href="/index.php/record/search">游戏记录</a></li>
            <li class="nLi nlibg3 <?=$this->iff($wjControl=='myReport', 'on')?>"><a href="/index.php/report/count">盈亏报表</a></li>
            
			<li class="nLi nlibg4 <?=$this->iff($wjControl=='myAcount', 'on')?>"><a href="#">会员中心</a>
					<ul class="sub" style="display: none;">
						<li><a href="/index.php/safe/info"><img src="/skin/images/n11.png" alt="" />个人资料</a></li>
						<li><a href="/index.php/safe/passwd"><img src="/skin/images/n10.png" alt="" />密码管理</a></li>
						<li><a href="/index.php/record/search"><img src="/skin/images/n6.png" alt="" />游戏记录</a></li>
						<li><a href="/index.php/report/count"><img src="/skin/images/n5.png" alt="" />盈亏报表</a></li>
						<li><a href="/index.php/report/coin"><img src="/skin/images/n3.png" alt="" />账变记录</a></li>
						<li><a href="/index.php/cash/rechargeLog"><img src="/skin/images/n9.png" alt="" />充值记录</a></li>
						<li><a href="/index.php/cash/toCashLog"><img src="/skin/images/n2.png" alt="" />提现记录</a></li>
						<li><a href="/index.php/notice/info"><img src="/skin/images/n8.png" alt="" />系统公告</a></li>
                    </ul>
            </li>
            <?php if($this->user['type']){ ?>
			<li class="nLi nlibg5 <?=$this->iff($wjControl=='myTeam', 'on')?>"><a href="#">代理中心</a>
					<ul class="sub" style="display: none;">
						<li><a href="/index.php/team/memberList"><img src="/skin/images/n7.png" alt="" />会员管理</a></li>
						<li><a href="/index.php/team/gameRecord"><img src="/skin/images/n6.png" alt="" />游戏记录</a></li>
						<li><a href="/index.php/team/report"><img src="/skin/images/n5.png" alt="" />盈亏报表</a></li>
						<li><a href="/index.php/team/coinall"><img src="/skin/images/n4.png" alt="" />团队统计</a></li>
						<li><a href="/index.php/team/coin"><img src="/skin/images/n3.png" alt="" />账变记录</a></li>
                        <li><a href="/index.php/team/recharge"><img src="/skin/images/n2.png" alt="" />充值记录</a></li>
						<li><a href="/index.php/team/cashRecord"><img src="/skin/images/n2.png" alt="" />提现记录</a></li>
						<li><a href="/index.php/team/linkList"><img src="/skin/images/n1.png" alt="" />推广链接</a></li>
                        <li><a href="/index.php/team/shareBonus"><img src="/skin/images/n1.png" alt="" />代理分红</a></li>
                    </ul>
            </li>
            <?php } ?>
            <li class="nLi nlibg6 <?=$this->iff($wjControl=='Notice', 'on')?>"><a href="/index.php/notice/info">系统公告</a></li>
			<li class="nLi nlibg7 <?=$this->iff($wjControl=='myScore', 'on')?>"><a href="/index.php/score/goods">最新活动</a></li>
		</ul>
    </div>
</div>
<div class="clear"></div>

		<script id="jsID" type="text/javascript">
			 var ary = location.href.split("&");
			jQuery("#nav").slide({ type:"menu", titCell:".nLi", targetCell:".sub",effect:ary[1], delayTime:ary[2] , triggerTime:ary[3], defaultPlay:ary[4],returnDefault:ary[5],easing:ary[6] });

//在线客服
function wjkf168(){
	<?php if($this->settings['kefuStatus']){ ?>
	var newWin=window.open("<?=$this->settings['kefuGG']?>","","height=600, width=800, top=0, left=0,toolbar=no, menubar=no, scrollbars=no, resizable=no, location=n o, status=no");
	if(!newWin||!newWin.open||newWin.closed){newWin=window.open('about:blank');}else{return false;}
	<?php }else{?>
	alert("暂时还没开通");
	<?php }?>
	return false;
}
</script>
