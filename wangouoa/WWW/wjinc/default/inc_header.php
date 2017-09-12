<script>
$(document).ready(function () {
    $('ul.nav li').has('div').append("<img class='navarrow' src='/images/common/arrow.png' />");
    $("ul.nav li").click(
     function(){
		  $(this).find("div").slideToggle(100);
          $(this).toggleClass("navtionhover");
		  $(this).siblings("li").removeClass("navtionhover").find(".subnav").hide();
		 } 
    );
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	jQuery.navlevel2 = function(level1,dytime) {
		
	  $(level1).mouseenter(function(){
		  varthis = $(this);
		  delytime=setTimeout(function(){
			varthis.find('div').slideDown();
		},dytime);
		
	  });
	  $(level1).mouseleave(function(){
		 clearTimeout(delytime);
		 $(this).find('div').slideUp();
	  });
	  
	};
  $.navlevel2("li.mainlevel",100);
});
</script>
<div id="header">
	<div id="bodytop">
    	<div class="bodytop">
        	<div class="fl changebg">
                换肤：
                <a href="#" rel="/images/bg1.jpg"><img src="/images/common/red.jpg" alt="红色风格"></a>
                <a href="#" rel="/images/bg2.jpg"><img src="/images/common/green.jpg" alt="绿色风格"></a>
                <a href="#" rel="/images/bg3.jpg"><img src="/images/common/blue.jpg" alt="蓝色风格"></a>
                <a href="#" rel="/images/bg4.jpg"><img src="/images/common/puple.jpg" alt="紫色风格"></a>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            </div>
			<div class="fl"><div class="fk"><a href="/Client/down.html" target="_blank">客户端下载</a></div></div>
	
        	<div class="clear"></div>
        </div>
    </div>
    <div id="page-header">
    	<div class="logomain">
        	<div class="fl"><img src="/images/common/logo.png" /></div>
            <div class="fm userInfo"><?php $this->display('index/inc_user.php'); ?></div>
			<div class="fx"><img src="/images/ad.jpg" /></div>
            <div class="fr"><img src="/images/common/service.png" class="mr10 contactus hand" onclick="wjkf168();"/>&nbsp&nbsp</div>
			<div class="fr"><a href="http://<?=$_SERVER['HTTP_HOST'];?>/help/default.htm" target="_blank"><img src="/images/common/help.png" /></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</div>
            <div class="clear"></div>
        </div>
    <div class="navtionbox">
    <ul class="nav">
        </li>
		<li><a href="/" >平台首页</a></li>
        <li class="mainlevel"><a href="#">选择彩种</a>
            <div class="subnav" style="width:325px">                
                <table><tr><th class="ssc">时时彩：</th></tr><tr><td><a href="/index.php/index/game/1/6" >重庆时时彩</a><a href="/index.php/index/game/3/6" >江西时时彩</a><a href="/index.php/index/game/12/6" >新疆时时彩</a></td></tr><tr><th class="x5">11选5：</th></tr><tr><td><a href="/index.php/index/game/7/10" >山东11选5</a><a href="/index.php/index/game/6/10" >广东11选5</a><a href="/index.php/index/game/15/10" >重庆11选5</a><a href="/index.php/index/game/16/10" >江西11选5</a></td></tr><th class="fc">福彩体彩：</th></tr><tr><td><a href="/index.php/index/game/9/16" >福彩3D</a><a href="/index.php/index/game/10/16" >排列三</a></td></tr><tr><th class="k8">其它：</th></tr><tr><td><a href="/index.php/index/game/20/29" ></a><a href="/index.php/index/game/30/81" ></a><a href="/index.php/index/game/14/72" >澳门五分彩</a><a href="/index.php/index/game/26/72" ></a><a href="/index.php/index/game/5/72" ></a></td></tr></table>  
            </div>

        <li><a href="/index.php/record/search" >游戏记录</a></li>
        <li><a href="/index.php/report/count" >盈亏报表</a></li>        
        <li><a href="#" onclick="return false;">会员中心</a><div class="subnav"><a href="/index.php/safe/info" ><img alt="" src="/images/icon/icon (29).png" ></img>个人资料</a><a href="/index.php/safe/passwd" ><img alt="" src="/images/icon/icon (7).png" ></img>密码管理</a><a href="/index.php/report/coin" ><img alt="" src="/images/icon/icon (14).png" ></img>帐变记录</a><a href="/index.php/cash/rechargeLog" ><img alt="" src="/images/icon/icon (18).png" ></img>充值记录</a><a href="/index.php/cash/toCashLog" ><img alt="" src="/images/icon/icon (8).png" ></img>提现记录</a><a href="/index.php/notice/info" ><img alt="" src="/images/icon/icon (20).png" ></img>系统公告</a></div></li>
        <?php if($this->user['type']){ ?>
        <li><a href="#" onclick="return false;">代理中心</a><div class="subnav"><a href="/index.php/team/memberList" ><img alt="" src="/images/icon/icon (17).png" ></img>会员管理</a><a href="/index.php/team/onlineMember"><img alt="" src="/images/icon/icon (17).png" ></img>在线会员</a><a href="/index.php/team/gameRecord" ><img alt="" src="/images/icon/icon (32).png" ></img>团队记录</a><a href="/index.php/team/report" ><img alt="" src="/images/icon/icon (19).png" ></img>团队盈亏</a><a href="/index.php/team/coinall" ><img alt="" src="/images/icon/icon (3).png" ></img>团队统计</a><a href="/index.php/team/coin" ><img alt="" src="/images/icon/icon (14).png" ></img>团队帐变</a><a href="/index.php/team/cashRecord" ><img alt="" src="/images/icon/icon (1).png" ></img>团队提现</a><a href="/index.php/team/linkList" ><img alt="" src="/images/icon/icon (33).png" ></img>推广链接</a>
		<?php 
				 if($this->user['fanDian'] == '13.0' || $this->user['fanDian'] == '12.9'){
			?>
				<a href="/index.php/team/shareBonus" ><img alt="" src="/images/icon/icon (1).png" ></img>代理分红</a>
			<?php } ?>
		</div></li>   
        <?php } ?>    
        <li class="wjpos"><a href="/index.php/score/goods/current" >最新活动</a></li>
    </ul>
</div>
    </div>
    <div class="clear"></div>
</div>
<script type='text/javascript'>
function wjkf168(){
	<?php if($this->settings['kefuStatus']){ ?>
	var newWin=window.open("<?=$this->settings['kefuGG']?>","","height=600, width=800, top=0, left=0,toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no");
	if(!newWin||!newWin.open||newWin.closed){newWin=window.open('about:blank');}else{return false;}
	<?php }else{?>
	alert("暂时还没开通");
	<?php }?>
	return false;
}
</script>