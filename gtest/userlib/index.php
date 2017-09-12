<?php 

define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/script.php';
if(isset($_GET['guid'])&&isset($_GET['gname'])){
	setcookie("g_user", $_GET['gname'], 0, "/");
	setcookie("g_uid",  $_GET['guid'], 0, "/");
	href ("/userlib/");
	
}else{

include_once ROOT_PATH.'function/global.php';
include_once ROOT_PATH.'function/cheCookie.php';
$ConfigModel = configModel("`g_mix_money`");
$db=new DB();
$text = $db->query("SELECT g_text FROM g_news WHERE g_number_alert_show = 1 ORDER BY g_id DESC LIMIT 1 ", 0);
if ($text){
	$n = strip_tags($text[0][0]);
}

$name = base64_decode($_COOKIE['g_user']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<TITLE><?php echo $Title?>  Welcome</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link	href="/webssc/css/all_f.css" type="text/css" rel="stylesheet"></link>
<!--[if IE 6]>
<script language="javascript" type="text/javascript" src="/webssc/js/DD_belatedPNG.js"></script>
<script language="javascript" type="text/javascript">
	DD_belatedPNG.fix(".imglogo");//IE6下PNG图片透明；
</script>
<![endif]--> 
</head>
<body class="skin_brown" nav="odds">
<input type="hidden" id="mix" value="<?php echo$ConfigModel['g_mix_money']?>" />
<div id="header" class="header header-bg"  >
  <div class="logo">  </div>
  <div class="main-nav"> <span> <a nav="status" href="javascript:void(0)" id="Report" class="ajaxload">下注状况</a> </span> | <span> <a nav="history" href="javascript:void(0)" title="" id="Repore" class="ajaxload">账户历史</a> </span> | <span> <a nav="result" href="javascript:void(0)" id="result"  class="ajaxload">开奖结果</a> </span> | <span> <a nav="infop" href="javascript:void(0)" title="" id="topMenu"  class="ajaxload">个人资讯</a> </span> | <span> <a nav="rule" id="rule" class="ajaxload" href="javascript:void(0)" title="">游戏规则</a> </span> | <span> <a nav="changePassword" href="javascript:void(0)" title="" id="UpPwd" class="ajaxload">修改密码</a> </span> |
    <div id="skinChange"> <a href="javascript:void(0)" title="" class="skinHandler w4em">更换皮肤▼</a>
      <div class="inner" style="display:none">
        <div class="option"><i class="sBrown"></i><a href="javascript:void(0)" skintag="3" skinclass="skin_brown">棕色</a></div>
        <div class="option"><i class="sBlue"></i><a href="javascript:void(0)" skintag="1" skinclass="skin_blue">蓝色</a></div>
        <div class="option"><i class="sRed"></i><a href="javascript:void(0)" skintag="2" skinclass="skin_red">红色</a></div>
      </div>
    </div>
    | <span> <a id="lineSelect" href="javascript:void(0)" title="">线路选择</a> </span> | <span> <a href="quit.php" id="logout" class="logout-link w2em">退出</a> </span> </div>
  <!--用户信息 开关盘-->
  <div class="header-op">
    <div class="top-op" id="select_sys"><a href="javascript:void(0)" class="switch nav_longstring" id="klc_sys">廣東快樂十分</a><a href="javascript:void(0)" class="switch nav_longstring" id="ssc_sys">重庆时时彩</a><a href="javascript:void(0)" class="switch nav_longstring switch-on" id="pk10_sys">北京赛车(PK10)</a><a href="javascript:void(0)" class="switch nav_longstring" id="nc_sys">幸运农场</a><a href="javascript:void(0)" class="switch nav_longstring" id="ks_sys">江苏骰宝（快3）</a></div>
  </div>
  <!--用户信息 开关盘 end-->
  <div class="sub-nav"><div class="elem_groupFilter" id="Type_List"></div></div>
</div>
 
<div id="layout" class="container">
	<div style="display: block;" class="sidebar" id="leftLoader">
	  <div id="side_left" class="side_left">
		<table class="struct_table_accountInfo  bg_white dataArea" cellspacing="0">
		  <colgroup>
			<col class="col1">
			<col class="col2">
		</colgroup>
		  <thead>
			<tr>
			  <th colspan="2" class="inner_text info_account">账户信息</th>
			</tr>
		  </thead>
		  <tbody>
			<tr class="t1">
			  <td class="inner_text">會員帳戶：</td>
			  <td id="account"><?php echo $user[0]['g_name']?>(<label id="pls" ><?php echo strtoupper($user[0]['g_panlus'])?></label>盘)</td>
			</tr>
			<!--<tr class="t1">
				<td class="inner_text">可用额度：</td>
				  <td id="credit"></td>
			</tr>-->
			<tr class="t1">
			  <td class="inner_text">可用余额：</td>
			  <td class="bold" id="re_credit"></td>
			</tr>
			<tr class="t1">
			  <td class="inner_text">已下金额：</td>
			  <td id="total_amount"></td>
			</tr>
			<tr>
			<!--<td colspan="2">
				<table border="0" cellpadding="0" cellspacing="1" width="100%" class="t_list">
                    <tr>
                        <td class="JZRCB"><a class="ajaxload" id="chongzhi"  href="#this"   style="color:#FFFFFF;">在线充值</a></td>
                   
                        <td class="JZRCB"><a class="ajaxload" id="qukuan" href="#this"    style="color:#FFFFFF;">在线取款</a></td>
                    </tr>
				</table>
			</td>     -->       
            </tr>
			<tr>
			  <th id="classic_img"  onclick="goUrl()" colspan="2" style="cursor:pointer"></th>
			</tr>
						<tr id="klc_office_site" class="playtype">
			  <th colspan="2"><a onclick="window.open('klc/order/ShowFlash','广东快乐十分','width=320,height=370,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no');" href="javascript:void(0);">"广东快乐十分"开奖网</a></th>
			</tr>
									<tr id="ssc_office_site" class="playtype">
			  <th colspan="2"><a target="_blank" href="http://www.shishicai.cn/cqssc/touzhu/">"重庆时时彩"开奖网</a></th>
			</tr>
				  
				
			<tr id="pk10_office_site" class="playtype">
			  <th colspan="2"><a target="_blank" href="http://www.bwlc.net/buy/trax/">"北京赛车(PK10)"官网</a></th>
			</tr>
									<tr id="nc_office_site" class="playtype">
			  <th colspan="2"><a target="_blank" href="http://www.16cp.com/gamedraw/lucky/open.shtml">"幸运农场"官网</a></th>
			</tr>
				 
				
			<tr id="ks_office_site" class="playtype">
			  <th colspan="2"><a target="_blank" href="http://www.cailele.com/lottery/k3/">"江苏骰宝（快3）"开奖网</a></th>
			</tr>
									<tr style="display: none;" class="hide-successinfo">
			  <td style="text-align:center;text-indent:0;" colspan="2"><a class="btn_m elem_btn" href="javascript:void(0)" id="sideLeftBack">返回</a></td>
			</tr>
			<tr style="display: none;" id="left_times_title" class="t1">
			  <th colspan="2"><h3 class="red-title center"><span id="g_left_qihao">2013091320</span>&nbsp;期</h3></th>
			</tr>
		  </tbody>
		</table>
	  </div>
	  <div id="newOrder" class="box new-order">
		<ul id="refresh_title">
		  <li class="new_fresh_title">最新注单</li>
		  <li class="rushBtn"><a id="rushBtn" class=" btn_r elem_btn btn" href="javascript:void(0)" onclick="getinfo2()">刷新</a></li>
		</ul>
		<div class="neworderListBox">
		  <table class="struct_table_newOrder" cellspacing="0"  >
			<colgroup>
			<col class="col1">
			<col class="col2">
			<col class="col3">
			<col class="col4">
			</colgroup>
			<thead>
			  <tr class="sub_title bg_deep_blue">
				<td>号码</td>
				<td>赔率</td>
				<td>金额</td>
				<td>时间</td>
			  </tr>
			</thead>
			<tbody>
			</tbody>
		  </table>
		</div>
	  </div>
	   
	  <div style="display: none;" id="successinfo" class="success-info">
		<ul> 
		  <li class="success">
			<table class="t1 bg_white dataArea">
			  <thead style="visibility:hidden;">
				<tr>
				  <td></td>
				  <td></td>
				  <td></td>
				</tr>
			  </thead>
			  <tbody id="s-list">
			  </tbody>
			  <tfoot>
				<tr>
				  <td class="inner_text td_h" colspan="2" style="width:75px">下注笔数</td>
				  <td class="db-bg" style="width:147px"><span class="black suc_zhus">3笔</span></td>
				</tr>
				<tr>
				  <td class="inner_text td_h" colspan="2" style="width:75px">合计注额</td>
				  <td class="db-bg"><b class="reder suc_t_amount">1000</b></td>
				</tr>
			  </tfoot>
			</table>
		  </li>
		</ul>
	  </div>
	</div> 
	<div style="display: block;" class="main-content bet-content" dom="layoutright" id="layoutright">
    </div>
  </div>
</div>
</div>  </div>
</div>
<div class="floor"> 
	<div class="marquee">
		<a href="javascript:void(0)" class="more more_announcement" id="moreNotice">更多</a>
		<p class="marqueeBox"><marquee id="marqueeBox" scrollamount="2"><?php echo trim($n); ?></marquee></p>
	</div> 
</div>
 
<div id="htmlBox" style="display:none"></div>
<iframe name="jsFrame"   style="display:none"  ></iframe>
<iframe name="orderFrame" style="display:none"  ></iframe> 
<form name="postform"   style="display:none"  target="orderFrame"  method="post"></form>
<div id="loadWaiting" style=" position:absolute;right:20px; bottom:60px; width:120px; display:none"> 
	<div style="display: block;" class="g-dialog-win elem-dialog g-loading">
	  <div class="pop-border">
		<div dom="head" class="pop-hd">
		  <h4 dom="title">Dialog</h4>
		  <a href="javascript:void(0)" dom="headico" class="headico"></a><a href="javascript:void(0)" dom="close" class="close"></a><a style="display: none;" href="javascript:void(0)" dom="toggleSize" class="maxsize"></a></div>
		<div class="pop-bd">
		  <div dom="container" class="pop-container"><span class="loading"></span><span>数据加载中...</span></div>
		</div>
		<div class="pop-ft"></div>
	  </div>
	</div>
</div> 
<div id="look"  ></div> 
<script language="javascript" src="/js/jquery.js"></script>
<script language="javascript">var htmlCollect = new Array()</script> 
<script language="javascript" src="/webssc/js/main.js" ></script> 
<script language="javascript" src="/webssc/js/dominit.js" ></script>  
<script language="javascript" src="/webssc/js/dlg.js?self=true&skin=skin_brown"></script> 
<script language="javascript" src="/userlib/js/TopMenu.js"></script>
 
<div class="g-dialog-win elem-dialog normalsize hide" style="z-index: 999999999; position: absolute; left: 720px; top: 40px; " id="lineSelectBox">
  <div class="pop-border">
    <style type="text/css">
			#lineSelectBox ul{width:100%;}
			#lineSelectBox ul li{text-align:center;line-height:24px;margin:2px 0px;clear:both;}
			#lineSelectBox ul li span{float:left}
			#lineSelectBox ul li .timebox{border:1px solid #E9BA84;width:160px;text-align:left;line-height: 21px;}
			#lineSelectBox ul li input{height:24px;float:left;width:40px}
		</style>
    <div class="pop-bd">
      <div class="pop-container" dom="container" style="width: 270px;">
        <div class="pop_loader" style="display: block;">
          <div style="height:auto;color: #000;" class="requestData">
            <ul>
			                <li><span>线路1:&nbsp;</span><span class="timebox">反应时间:<font style="color: red;" class="klkl" id="1m"></font></span>
                <input line="http://" value="选择" height="24" name="cscscs" type="button">
              </li>
			                <li><span>线路2:&nbsp;</span><span class="timebox">反应时间:<font style="color: red;" class="klkl" id="2m"></font></span>
                <input line="http://" value="选择" height="24" name="cscscs" type="button">
              </li>
			                <li><span>线路3:&nbsp;</span><span class="timebox">反应时间:<font style="color: red;" class="klkl" id="3m"></font></span>
                <input line="http://" value="选择" height="24" name="cscscs" type="button">
              </li>
			                <li><span>线路4:&nbsp;</span><span class="timebox">反应时间:<font style="color: red;" class="klkl" id="4m"></font></span>
                <input line="http://" value="选择" height="24" name="cscscs" type="button">
              </li>
			                <li><span>线路5:&nbsp;</span><span class="timebox">反应时间:<font style="color: red;" class="klkl" id="5m"></font></span>
                <input line="http://" value="选择" height="24" name="cscscs" type="button">
              </li>
			   
            </ul>
            <div style="clear: both;"><font color="red">提示:</font>反应时间越小，网速越快。</div>
          </div>
          <div class="btn-line">
            <div class="inner">
              <button tabindex="1" id="lineTestSudu" class="yellow-btn btn_m elem_btn" style="border-bottom:none;border-top:none">测速</button>
              <span tabindex="2" id="lineSelClose" class="white-btn btn_m elem_btn">关闭</span> </div>
          </div>
        </div>
      </div>
    </div>
    <div class="pop-ft" ></div>
	<div id="tempcunchu" class="hide"></div>
  </div>
</div> 
<script language="javascript"> 
var tim=1;
var it=null;
var b=1;  
var autourl=new Array();
$('input[name=cscscs]').each(function(){
	autourl[b++]=$(this).attr('line'); 
})
function cesu(){ 
	tim=1;
	it=setInterval(function(){tim++},1)
	b=1;
	$('#lineTestSudu').attr('disabled','disabled');
	$('.klkl').html('');
	function run(){
		for(var i=1;i<autourl.length;i++){   
			$('#tempcunchu').append("<img src="+autourl[i]+"/?"+Math.random()+" width=1 height=1 class='hide' onerror='_auto("+i+")'/>");
		}
	}
	run();
} 
function _auto(i){   
	if(tim>1000){
		$('#'+i+'m').html("链接超时");
	}else{
		$('#'+i+'m').html("时间"+tim+"毫秒");
	}  
	p=true;
	$('.klkl').each(function(){
		if( $(this).html()=='' )p=false;
	})
	if(p){clearInterval(it);$('#lineTestSudu').attr('disabled','');}
}
$('#lineTestSudu').bind('click',function(){ cesu();return false })
$('#lineSelClose').bind('click',function(){ $('#lineSelectBox').hide();try{clearInterval(it);}catch(E){} return false; })
$('input[name=cscscs]').bind('click',function(){
	parent.location.href=$(this).attr('line')+"/userlib/?guid=<?=$_COOKIE['g_uid']?>&gname=<?=$_COOKIE['g_user']?>&redirect=1&skin="+$('body').attr('class')+"&src="+escape(document.domain);
})
function goUrl(){
	parent.location.href="/?redirect=1&skin="+$('body').attr('class')+"&src="+escape(document.domain);
}
</script> 
</body>
</html>

<?php }?>