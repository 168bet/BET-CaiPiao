/*
 * Author:weige
 * Date: 2014.9.26 16:53
 */
String.prototype.getParam = function(n){
	var r = new RegExp("[\?\&]"+n+"=([^&?]*)(\\s||$)", "gi");
	var r1=new RegExp(n+"=","gi");
	var m=this.match(r);
	if(m==null){
		return "";
	}else{
		return typeof(m[0].split(r1)[1])=='undefined'?'':decodeURIComponent(m[0].split(r1)[1]);
	}
};
var from = location.search.getParam('from');//android ios 4g
/**
 * @namespace 活动类
 * @name HD
 */

var Date_ = new Date();
var myDate = Date_.getDate();//获取当前日(1-31)
var myMonth = Date_.getMonth()+1;
var HD = {};
HD.Nrb = function ($){
	var c = {
		bindEvent : function(){
			$('#rule_c p:eq(1)').html('1、活动时间：<br>2014年10月13日-2014年11月2日。(参与活动前,需先绑定手机号)');
			$('#hqhb p:eq(1)').html('2、当日在手机累计代购竞足满10元即可再抽2次，代购越多，抽奖越多。');
			$('#hqhb p:eq(0)').html('1用户连续登录2天即可抽1次，若连续登录的第2天不抽，不可累计到第三天，需重新计算。(参与活动前,需先绑定手机号)');	
			$('#rule_c p:eq(4)').html('4、当日累计代购竞足满10元即可再抽2次，代购越多，抽奖越多，但因代购而获得的抽奖机会每天不超过6次。当日满足代购条件未抽红包，次日抽红包机会将清零，不可累计。');
			$('#unlisted').html('<p style="padding:1.2rem 0 0 1rem; font-size:.85rem">参与活动前，需先绑定手机号。</p><span id="login">登录</span><span id="enroll">注册</span>');
        	//<p style="padding:1.2rem 0 0 1rem; font-size:.85rem">参与活动前，需先绑定手机号。</p>
			c.bind();
			c.load();
		},
		load : function(){
			$.ajax({
				url : '/activity/nrbhomepage.go',
				type : "GET",
				cache:false,
				async: false,
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("Resp");
					var c = R.attr('code');
					var d = R.attr('desc');
					if(c == '2000'){//未登录
						$('#unlisted').show();
					}else if(c == '0'){//查询成功
						var r = R.find('row');
						var chance_login = r.attr('chance_login');//连续登录可抽奖次数
						var chance_dg = r.attr('chance_dg');//竞彩足球代购可抽奖次数
						var point = r.attr('point');//当前可用积分数
						var money = r.attr('money');//当前可用积分数
						var uid = r.attr('uid');//用户名
						$('#money').val(money);//可兑换的红包金额
						$('#chance_login').val(chance_login);
						var count = parseInt(chance_login)+parseInt(chance_dg);
						$('#count').val(count);
						$('#already').show();
						$('#already label:eq(0)').html(uid);
						$('#already em').html(count);
						$('#already label:eq(1)').html(point);
					}else{//-1 查询失败
						$('#unlisted').show();
						msg(d);
					}
				}
			});
			myDate = c.zeroStr(myDate,2);
			var dd = parseInt(myMonth+''+myDate);
			if(dd>=1013 && dd<=1102){
				var num = '';
				if(myMonth == '11'){
					num = 3; 
				}else{
					num = (myDate>=27 && 3) || (myDate>=20 && 2) || 1; 
				}
				var url = '/data/huodong/jczqphb/week_'+num+'_win.xml';
				$.ajax({
					url : url,
					type : "GET",
					dataType : "xml",
					success : function(xml) {
						var r = $(xml).find("row");
						var html = '',  html2 = '';
						html += '<li class="green"><span>9188账号</span><em>中奖金额</em></li>';
						var t = {'1':'冠军','2':'亚军','3':'季军','4':'第4名','5':'第5名','6':'第6名','7':'第7名','8':'第8名','9':'第9名','10':'第10名'
							,'11':'第11名','12':'第12名','13':'第13名','14':'第14名','15':'第15名','16':'第16名','17':'第17名','18':'第18名','19':'第19名','20':'第20名'};
						r.each(function(a){
//							var gid = $(this).attr('gid');//彩种   00是竞彩足球
//							var pid = $(this).attr('pid');//排行榜统计日期
							var cnickid = $(this).attr('cnickid');//用户名
							var bonus = $(this).attr('bonus');//中奖金额
							var hdbonus = $(this).attr('hdbonus');//奖励红包金额
							var rank = $(this).attr('rank');//排名
							if(a<3){
								html += '<li class='+(a%2==0?'':'green')+'><span>'+cnickid+'</span><em>'+Math.round(bonus)+'元</em></li>';
							}
							if(a>19){//双冠王
							}else{
								html2 += '<li><strong>'+t[rank]+'</strong><span>'+cnickid+'</span><cite>'+Math.round(bonus)+'元</cite></li>';
							}
						});
						$('#bznrb').html(html);
						$('#rank2 div.scroll ul').html(html2);
					},error:function(){
						$('#bznrb').html('最新中奖排行打盹中，稍后显示。');
						$('#rank2 div.scroll ul').html('最新中奖排行打盹中，稍后显示。');
					}
				});
			}else if(dd>1102){//活动结束
				$('#bznrb').html('活动已结束，中奖不再计入牛人排行。');
				$('#rank2 div.scroll ul').html('活动已结束，中奖不再计入牛人排行。');
			}else{
				$('#bznrb').html('活动未开始，敬请期待。');
				$('#rank2 div.scroll ul').html('活动未开始，敬请期待。');
			}
			
			$.ajax({
				url : '/activity/getMyAwardPhb.go',
				type : "GET",
				async: false,
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("Resp");
					var c = R.attr('code');
					var d = R.attr('desc');
					if(c == '0'){
						var r = R.find('row');
						var money = r.attr('money');
						$('#jc_money').html('您本周竞足中奖 <em style="width:3.5rem; margin:0 .2rem" >'+money+'</em>元，继续冲刺吧');
					}
				}
			});
		},
		last : function(num){
			var url = '/data/huodong/jczqphb/week_'+(num-1)+'_win.xml';
			$.ajax({
				url : url,
				type : "GET",
				dataType : "xml",
				success : function(xml) {
					var r = $(xml).find("row");
					var html = '';
					var t = {'1':'冠军','2':'亚军','3':'季军','4':'第4名','5':'第5名','6':'第6名','7':'第7名','8':'第8名','9':'第9名','10':'第10名'
						,'11':'第11名','12':'第12名','13':'第13名','14':'第14名','15':'第15名','16':'第16名','17':'第17名','18':'第18名','19':'第19名','20':'第20名'};
					r.each(function(a){
//						var gid = $(this).attr('gid');//彩种   00是竞彩足球
//						var pid = $(this).attr('pid');//排行榜统计日期
						var cnickid = $(this).attr('cnickid');//用户名
						var bonus = $(this).attr('bonus');//中奖金额
//						var hdbonus = $(this).attr('hdbonus');//奖励红包金额
						var rank = $(this).attr('rank');//排名
						if(a<20){
							html += '<li><strong>'+t[rank]+'</strong><span>'+cnickid+'</span><cite>'+Math.round(bonus)+'元</cite></li>';
						}
					});
					$('#rank div.scroll ul').html(html);
					
				}
			});
		},
		bind : function(){
			$('#award').on('click',function(){//更多奖品
				$('#more_award,.zhezhao').show();
			});
			$('#last_week').on('click',function(){//上周排行
				var num = '';
				if(myMonth == '11'){
					if(myDate>=3){
						num = 4;
					}else{
						num = 3;
					}
				}else{
					num = (myDate>=27 && 3) || (myDate>=20 && 2) || (myDate>=13 && 1) || 0; 
				}
				if(num == 1){
					msg('本周为第一周，故暂无上一期排行。');
				}else if(num == 0){
					msg('活动未开始，敬请期待。');
				}else{
					$('#rank,.zhezhao').show();
					c.last(num);
				}
			});
			$('#more_rank').on('click',function(){//更多排行
				$('#rank2,.zhezhao').show();
			});
			$('.hqhb').on('click',function(){//如何获取红包
				$('#hqhb,.zhezhao').show();
			});
			$('#rule').on('click',function(){//活动规则
				$('#rule_c,.zhezhao').show();
			});
			$('#exchange').on('click',function(){//兑换红包
				var already = $('#already label:eq(0)').html();
				if(!!already){//检测有木有登录
					var money = $('#money').val();
					if(money != '0' && money != ''){
						$('#cash,.zhezhao').show();
						$('#cash .jfdhtk').html('您目前的积分可兑换<em style="color:red">'+money+'</em><br>个1元红包，确认兑换？');
					}else{
						$('#lose,.zhezhao').show();
					}
				}else{
					$('.zhezhao,#login_c').show();
				}
			});
			$('#cash').on('click','span:eq(0)',function(){
				$('#cash,.zhezhao').hide();
			});
			$('#cash').on('click','span:eq(1)',function(){
				$.ajax({
					url : '/activity/jifenduihuan.go',
					type : "GET",
					dataType : "xml",
					success : function(xml) {
						var R = $(xml).find("Resp");
						var c = R.attr('code');
						var d = R.attr('desc');
						if(c == '0'){
							var r = R.find('row');
							var point = r.attr('point');
							$('#already label:eq(1)').html(point);
							$('#money').val(0);
							$('#cash,.zhezhao').hide();
							msg('恭喜您兑换红包成功');
						}else{
							msg(d);
						}
					}
				});
			});
			$('#login,#login2').on('click',function(){//登录
				if(from == 'android'){
					window.caiyiandroid.clickAndroid(3, '');
				}else if(from == 'ios'){
					WebViewJavascriptBridge.callHandler('clickIosLogin');
				}else{
//					location.href='http://t2014.9188.com  /#class=url&xo=login/index.html';
					location.href='http://4g.9188.com/#class=url&xo=login/index.html';
				}
			});
			$('#football').on('click',function(){//投竞彩足球
				if(from == 'android'){
					window.caiyiandroid.clickAndroid(0, '70');
				}else if(from == 'ios'){
					WebViewJavascriptBridge.callHandler('clickIosLottery','70');
				}else{
//					location.href='http://t2014.9188.com  /#class=url&xo=jczq/index.html';
					location.href='http://4g.9188.com/#class=url&xo=jczq/index.html';
				}
			});
			$('#enroll').on('click',function(){
				if(from == 'android'){
					window.caiyiandroid.clickAndroid(4, '');
				}else if(from == 'ios'){
					WebViewJavascriptBridge.callHandler('clickIosRegister');
				}else{
					location.href='http://4g.9188.com/#class=url&xo=login/register.html';
				}
			});
			$('.zhezhao').on('click',function(){
				$(this).hide();
				$('#hqhb,#rule_c,#more_award,#rank,#rank2,#login_c,#lose,#cash,#outcome').hide();
			});
			$('#outcome').on('click','span',function(){
				$('.zhezhao,#outcome').hide();
			});
			$('#login_c').on('click','.ture',function(){
				$('.zhezhao,#login_c').hide();
			});
			$('#lose').on('click','.ture',function(){
				$('.zhezhao,#lose').hide();
			});
			$('.popup').on('click','.clock',function(){
				$(this).parent().hide();
				$('.zhezhao').hide();
			});
			$('.popup2').on('click','.clock2',function(){
				$(this).parent().hide();
				$('.zhezhao').hide();
			});
		},zeroStr : function(num, n) {
		    var len = num.toString().length;
		    while(len < n) {
		        num = "0" + num;
		        len++;
		    }
		    return num;
		}
	};
	var d = function (){
        c.bindEvent();
    };
    return {init: d};
}(jQuery);

var N = new Array();//按顺序取每个标签
 N[0]=$(".cjlist span").eq(0) ;
 N[1]=$(".cjlist span").eq(1) ;
 N[2]=$(".cjlist span").eq(2) ;
 N[3]=$(".cjlist span").eq(3) ;
 N[4]=$(".cjlist span").eq(7) ;
 N[5]=$(".cjlist span").eq(11);
 N[6]=$(".cjlist span").eq(10) ;
 N[7]=$(".cjlist span").eq(9) ;
 N[8]=$(".cjlist span").eq(8) ;
 N[9]=$(".cjlist span").eq(4) ;
//var j;
var oo=1;
var clock=0;//计时器时间
$(".yellow").removeClass("yellow");
//跑的每一步
function run(){
	N[oo].removeClass("yellow");
	if(oo==9)
		N[0].addClass("yellow");
	else
		N[oo+1].addClass("yellow");
	if(oo==9)
		oo=0;
	else
		oo++;
}
//每个匀速阶段
function SM(start,end,time,per_time){// 开始编号+1，截止编号，循环的圈数，每移动一格时间
//i=start-1;
	var T = '',j;
	if(start<=end)
		T=end-start+time*10;
	else
		T=10-start+end+time*10;
	for(j=0;j<=T;j++){
		clock=clock+per_time;
		setTimeout(function(){
			run();
		},clock);
	}
}
//先快后满再快
function finish(set_start,set_end){//设定起始（set_start）   &   结束编号（set_end）
	oo=1;
	clock=0;//计时器时间
	var order=4;
	SM(set_start,(set_start+order)%10,0,300);
	SM((set_start+order+1)%10,(set_start+order+2)%10,0,200);
	SM((set_start+order+3)%10,(set_start+order+4)%10,0,150);
	SM((set_start+order+5)%10,(set_start+order+6)%10,0,100);
	SM((set_start+order+7)%10,(set_end+100-order-7)%10,5,50);
	SM((set_end+100-order-6)%10,(set_end+100-order-5)%10,0,100);
	SM((set_end+100-order-4)%10,(set_end+100-order-3)%10,0,150);
	SM((set_end+100-order-2)%10,(set_end+100-order-1)%10,0,200);
	SM((set_end+100-order)%10,set_end,0,300);
}
function msg(msg){
	clearTimeout(window.alert.time);
    var obj = $('<div class="alertBox">'+msg+'</div>');
    $("body").append(obj);
    window.alert.time = setTimeout(function() {
        $(".alertBox").remove();
    }, 2000);
}
HD.Nrb.init();


$(document).ready(function(){
	$("#wyhb").click(function(){
		$('.yellow').removeClass('yellow');
		$("#wyhb2").show();
		$("#wyhb").hide();
		var already = $('#already label:eq(0)').html();
		if(!!already){//检测有木有登录
				var bnum = '';
				var count = $('#count').val();
				if(count>0){
					var chance_login = $('#chance_login').val();
					if(!!chance_login && chance_login != '0'){
						bnum = '1';
					}else{
						bnum = '2';
					}
					var t = {'0':'9','1':'4','3':'7','5':'5','8':'0','10':'8','18':'2','118':'3'
						,'10001':'6','10005':'1'};
					var t1 = {'0':'再来','1':'1元','3':'3元','5':'5元','8':'8元','10':'10元','18':'18元','118':'118元'
						,'10001':'1积分','10005':'5积分'};
					$.ajax({
						url : '/activity/chouhongbao.go',
						type : "GET",
						data : {
							bnum : bnum
						},	
						async: false,
						dataType : "xml",
						success : function(xml) {
							var R = $(xml).find("Resp");
							var c = R.attr('code');
							var d = R.attr('desc');
							if(c == '0'){//查询成功
								var r = R.find('row');
								var chance_login = r.attr('chance_login');//连续登录可抽奖次数
								var chance_dg = r.attr('chance_dg');//竞彩足球代购可抽奖次数
								var point = r.attr('point');//当前可用积分数
								var result = r.attr('result');//抽取结果
								var money = r.attr('money');
								$('#money').val(money);
								if(result){
									var tr = t[result];
									finish(0,parseInt(tr));//设定起始&结束编号
									setTimeout(function(){
										var t = t1[result];
										if(t=='再来'){
											$('#outcome p').html('萌萌哒，好运在下次！');
											$('#outcome,.zhezhao').show();
										}else{
											$('#outcome p').html('恭喜您获得了'+t+'！');
											$('#outcome,.zhezhao').show();
										}
										$("#wyhb2").hide();
										$("#wyhb").show();
										$('#already label:eq(1)').html(point);
									},'8500');
									
									$('#chance_login').val(chance_login);
									var count = parseInt(chance_login)+parseInt(chance_dg);
									$('#count').val(count);
									$('#already em').html(count);
								}else{
									msg('出错啦！请重试');
								}
							}else{//-1 抽取失败
								msg(d);
							}
						}
					});
				}else{
					msg('尊敬的用户，您目前暂无抽红包机会哦。');
					$("#wyhb2").hide();
					$("#wyhb").show();
				}
		}else{
			$("#wyhb2").hide();
			$("#wyhb").show();
			$('.zhezhao,#login_c').show();
		}
	});
});