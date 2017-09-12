var nid = '' ;      
var ye = 0;//余额
var source = 3000;
var money = 2;
var jj = 0;//理论奖金

var flag_spf=0;
var flag_rqspf=0;

var sf_num = 0;//胜平负场次总数
var rq_num = 0;//让球胜平负场次总数
var $sf=[],$rq=[];//对阵xml
var sf_id = 1;//当前胜平负对阵排名
var rq_id = 1;//当前让球对阵排名
var nowCur = 0;//胜平负

var flag_ok=0;
var msize = 0;

var dom= {
        'dg_sf':$('#dg_sf'),//胜负
        'dg_rq':$('#dg_rq')//让分
};
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

if(location.search.getParam('back')=="yes")
	{
	$("#bac").show();
	}

var from = location.search.getParam('from');//android ios 4g
var comeFrom=location.search.getParam('comeFrom');//代理商
if(comeFrom){
	localStorage.setItem('comeFrom',comeFrom);
}


initDatas();
$('#login,#toLogin').on('click',function(){//登录
		if(from == 'android'){
			window.caiyiandroid.clickAndroid(3, '');
		}else if(from == 'ios'){
			WebViewJavascriptBridge.callHandler('clickIosLogin');
		}else{
			location.href='http://4g.9188.com/#class=url&xo=login/index.html';
		}
});

$('#register,#toRegister').on('click',function(){//注册
	if(from == 'android'){
		window.caiyiandroid.clickAndroid(3, '');
	}else if(from == 'ios'){
		WebViewJavascriptBridge.callHandler('clickIosRegister');
	}else{
		location.href='http://4g.9188.com/#class=url&xo=login/register.html';
	}
});

$("#dg_sf").on('click','.tzxx span',function(){//胜负按钮
	if(sf_num==0){
		msg('暂无比赛，请稍后再试');
	}else{
		$(this).addClass('cur').siblings().removeClass('cur');
		var yjjj = $(this).attr("s")*2;
		yjjj = yjjj.toFixed(2);
		$("#yjjj").html(yjjj);
	}
});

$("#dg_rq").on('click','.tzxx span',function(){//让球
	if(rq_num==0){
		msg('暂无比赛，请稍后再试');
	}else{
		$(this).addClass('cur').siblings().removeClass('cur');
		var yjjj = $(this).attr("s")*2;
		yjjj = yjjj.toFixed(2);
		$("#yjjj").html(yjjj);
	}
});

$("#sf_cur").on('click',function(){//胜平负选项卡
	$(this).addClass('cur').siblings().removeClass('cur');
	GddgSlide({slideCell:"#sfScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
	GddgSlide({slideCell:"#rqScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
	$("#dg_sf").show();
	$("#dg_rq").hide();
	$("#rq_time").hide();
//	$("#sf_time").show();
	$("#rqdis").hide();
	$("#rqwhat").hide();
	nowCur = 0;
	if(sf_num == 0){
		$("#buy").addClass("gray");
	}else{
		$("#buy").removeClass("gray");
	}
	
});

$("#rq_cur").on('click',function(){//让球胜平负选项卡
	$(this).addClass('cur').siblings().removeClass('cur');
	GddgSlide({slideCell:"#sfScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
	GddgSlide({slideCell:"#rqScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
	$("#dg_rq").show();
	$("#dg_sf").hide();
	//$("#sf_time").hide();
	$("#rq_time").show();
	$("#rqwhat").show();
	nowCur = 1;
	if(rq_num == 0){
		$("#buy").addClass("gray");
	}else{
		$("#buy").removeClass("gray");
	}
});

$("#hdgzButton").on('click',function(){
	var dis = $("#hdgz").css('display');
	if(dis=='block'){
		$("#hdgz").hide();
	}else{
		$("#hdgz").show();
	}
});

$("#rqwhat").on('click',function(){
	$("#rqdis").show();
	$(".zhezhao").show();
});

$("#buy").on('click',function(){//购买彩票
	checkLogin();
	if(nid == ''){//未登录
		$("#loginYes").hide();
		$("#notLogin").show();
		$(".zhezhao").show();
		return ;
	}
	
	var codes = "";
	var prefix = "SPF";
	var gid = 72;
	if(nowCur==1){//让球胜负
		prefix = "RQSPF";
		gid = 90;
	}
	
	var t = $('#top_menu .cur').attr('v');
	var t1 = $('#dg_'+t).find('.tzxx').attr('v');
	var bs = 1;
	var c = '',c1='';

	$('#dg_'+t).find('.tzxx .cur').each(function(){
		c += prefix +'|'+ t1 +'='+ $(this).attr('v') +'|1*1';
	});
	codes = c ;
	jj = $("#yjjj").val();
	if(codes !=""){
		if(flag_ok==0)
			{		
		yfqCast(codes,gid);
			}
	}
	
});

//投注
function yfqCast(codes,gid){
	flag_ok=1;
	$.ajax({
        url: "/trade/dggpyfg.go",
        type: "POST",
        dataType:'xml',
        data:{
			"gid":gid,
			"money":2,
			"source":source,
			"imoneyrange":jj,
			"codes":codes
		},
        success:function (data){
        	flag_ok=0;
     	    var R = $(data).find("Resp");
 			var code = R.attr("code");
 			var desc = R.attr("desc");
 			if(code == 0){//购彩成功
 				var projid = R.find("row").attr("projid");
 				window.location.href="http://4g.9188.com/#class=url&xo=viewpath/index.html&lotid="+gid+"&projid="+projid;
 			}else if(code == 2003 || code == 1901){//已经有过购彩记录
 				$("#haveBuy").show();
 				$(".zhezhao").show();
 			}else if(code == 2002){//未绑定
 				$("#notBind").show();
 				$(".zhezhao").show();
 			}else if(code == 1){//未登录
 				$("#notLogin").show();
 				$(".zhezhao").show();
 			}else if(code == 2000){//已经参加过
 				$("#haveJoin").show();
 				$(".zhezhao").show();
 			}else if(code == 1001){//余额不足
 				$("#noMoney").show();
 				$(".zhezhao").show();
 			}else if(code == 1902){//没有充值记录
 				$("#noChongzhi").show();
 				$(".zhezhao").show();
 			}else if(code == 1903){//活动尚未开始
 				$("#notBegin").show();
 				$(".zhezhao").show();
 			}else if(code == 1904){//活动已经结束
 				$("#alreadyEnd").show();
 				$(".zhezhao").show();
 			}else if(code == 1909){//新加
 				$("#yebzw").show();
 				$(".zhezhao").show();
 			}else{
 				msg(desc);
 			}
        },
        error:function(){
        	msg("系统异常");
        }
	});
}


$("#notBindClose,#haveBuyClose,#haveJoinClose,#notBeginClose,#alreadyEndClose,#notLoginClose,#rqdisClose,#noMoneyClose,#noChongzhiClose,#yebzwClose").on('click',function(){//关闭按钮
	var spanId = $(this).attr("id")
	var divId = spanId.substring(0, spanId.length-5);//去掉close
	$("#"+divId).hide();
	$(".zhezhao").hide();
});



function checkLogin(){
	$.ajax({
        url: "/user/mchklogin.go",
        type: "POST", 
        success:function (data){
     	    var R = $(data).find("Resp");
 			var code = R.attr("code");
 			if (code == "10001") {//已登录
 				getUserInfo();
 			}else{
 				nid = '';
 			}
        }
	});
}

function getUserInfo(){
	$.ajax({
        url: "/user/query.go?flag=6",
    	dataType : "xml",
        success:function (data){
        	var R = $(data).find("Resp");
        	var c = R.attr('code');
        	var d = R.attr('desc');
        	if(c == '0'){
        		var U = R.find("row");
	        	var n = U.attr("nickid");//用户名
	        	var yy = U.attr("usermoney");//余额
	        	nid = n;
	        	ye = yy;
	        	$("#user").html(nid);
	    		$("#loginNo").hide();
	    		$("#loginYes").show();
        	}
        }
	});
}

function initDatas(){
	checkLogin();//判断是否登录
	parseMatch();
	phblist();//加载排行榜
	
}

function parseMatch(){
	$.ajax({
		url : '/data/app/jczq/new_jczq_hh.xml',
		type : 'get',
		dataType : 'xml',
		success:function(xml){
			var r = $(xml).find('row');
			!r.length && D.msg('暂无比赛数据'); 
			var html_spf = '', html_rq='',spf_a=0,rq_a=0;
			r.each(function(){
				var sf = {}, rq = {};
				var itemid = $(this).attr('itemid');//编号
				var hn = $(this).attr('hn').substr(0,5);//主队
				var gn = $(this).attr('gn').substr(0,5);//客队
				var mt = $(this).attr('mt');//比赛开始时间
				mt = mt.substring(0,mt.length-3);
				var et = $(this).attr('et');//购买截止时间
				var mname = $(this).attr('mname').substr(0,4);//赛事
				var close = $(this).attr('close');//让球数
				var isale = $(this).attr('isale');//是否停售
				var spf = $(this).attr('spf');//胜平负赔率
				var rqspf = $(this).attr('rqspf');//让球胜平负赔率
				var spfscale = $(this).attr('spfscale');//胜平负人气
				var rqspfscale = $(this).attr('rqspfscale');//让球胜平负人气
				if((512 & isale) > 0){//胜平负是否停售
//				if((32 & isale) > 0){//让球是否停售
//				if((2 & isale) > 0){//比分是否停售
					sf_num ++;
					sf.itemid = itemid;//编号
					sf.hn = hn;//主队
					sf.gn = gn;//客队
					sf.mt = mt;
					sf.spf = spf;//让球胜平负赔率
					sf.spfscale = spfscale;//人气
					$sf[spf_a] = sf;
					html_spf += '<li id="sf_'+sf_num+'"><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>';//明天凌晨
					spf_a++;
				}
				
				if((32 & isale) > 0){//让球是否停售
	//			if((256 & isale) > 0){//进球是否停售
					rq_num ++;
					rq.itemid = itemid;//编号
					rq.hn = hn;//主队
					rq.gn = gn;//客队
					rq.mt = mt;
					rq.close = close;//让球数
					if(close!=0&&close!='0'){
						if(close==1||close=='1'){
							close = "+"+close;
						}
						hn = hn+"("+close+")";
					}
					rq.close = close;
					
					rq.rqspf = rqspf;//让球胜平负赔率
					rq.rqspfscale = rqspfscale;//人气
					$rq[rq_a] = rq;
					html_rq += '<li id="rq_'+rq_num+'"><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>';//明天凌晨
					rq_a++;
				}
				
			});
			
			
			if(sf_num==0&&rq_num==0){
				msg('暂无比赛，敬请期待明天!');
			}else if(sf_num==0&&rq_num>0){
				$("#rq_cur").click();
			}else if(sf_num>0&&rq_num==0){
				$("#sf_cur").click();
			}else{
				$("#top_menu").show();
			}
		
			//if(sf_num>1 || rq_num>1)
//				{
//				$("#sf_prev,#sf_next,#rq_prev,#rq_next").css({
//					"margin-top":".75rem", 
//					"width":".75rem",
//					 "height":".75rem",
//					"border-right":".15rem solid #1c8101",
//					 "border-bottom":".15rem solid #1c8101"
//				});
//				}
				
				if(sf_num>1){
					$("#sf_prev,#sf_next").css({
						"margin-top":".75rem", 
						"width":".75rem",
						 "height":".75rem",
						"border-right":".15rem solid #1c8101",
						 "border-bottom":".15rem solid #1c8101"
					});		
				}
				if(rq_num>1){
					$("#rq_prev,#rq_next").css({
						"margin-top":".75rem", 
						"width":".75rem",
						 "height":".75rem",
						"border-right":".15rem solid #1c8101",
						 "border-bottom":".15rem solid #1c8101"
					});		
				}
				
				
				

			
			$("#sf_num").html(sf_num);
			$("#rq_num").html(rq_num);
			$("#spf_dz").html(html_spf);
			$("#rqspf_dz").html(html_rq);
			duizhen('0','rq');
			duizhen('0','sf');
			
			if(sf_num == 0){
				$("#buy").addClass("gray");
				$("#sf_prev").hide();
				$("#sf_next").hide();
			}else{
				$("#buy").removeClass("gray");
			}
			
			if(rq_num == 0){
				$("#rq_prev").hide();
				$("#rq_next").hide();
			}else{
				$("#buy").removeClass("gray");
			}
			
			
			GddgSlide({slideCell:"#sfScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
			GddgSlide({slideCell:"#rqScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
		}
	});

}


function duizhen(t,xo){
	var lot =  xo || $('#top_menu .cur').attr('v');
	if(lot == 'sf' && !!$sf.length){
		var x = $sf[t].spf.split(',');
		var x1 = x[0],x2 = x[1],x3 = x[2];
		dom.dg_sf.find('.tzxx').attr('v',$sf[t].itemid);//编号
		dom.dg_sf.find('.tzxx li:eq(0) span:eq(0)').attr('s',x1);//主队sp
		dom.dg_sf.find('.tzxx li:eq(0) span:eq(1)').attr('s',x2);//平
		dom.dg_sf.find('.tzxx li:eq(0) span:eq(2)').attr('s',x3);//客队sp
		dom.dg_sf.find('.tzxx li:eq(0) span:eq(0) cite').html($sf[t].hn);//主队
		dom.dg_sf.find('.tzxx li:eq(0) span:eq(2) cite').html($sf[t].gn);//客队
		dom.dg_sf.find('.tzxx li:eq(1) em:eq(0)').html('赔率'+x1);//主胜奖金
		dom.dg_sf.find('.tzxx li:eq(1) em:eq(1)').html('赔率'+x2);//平
		dom.dg_sf.find('.tzxx li:eq(1) em:eq(2)').html('赔率'+x3);//客胜
		var scale = $sf[t].spfscale.split(',');
		var z = parseInt(scale[0]);var p = parseInt(scale[1]);var k = parseInt(scale[2]);
		if(!isNaN(z)){
			dom.dg_sf.find('.gddghot p:eq(0) em').html(z+'%人气');//主人气
    		dom.dg_sf.find('.gddghot p:eq(0) i').css({'height':z*3/100+'rem'});
    		dom.dg_sf.find('.gddghot p:eq(1) em').html(p+'%人气');//平
    		dom.dg_sf.find('.gddghot p:eq(1) i').css({'height':p*3/100+'rem'});
    		dom.dg_sf.find('.gddghot p:eq(2) em').html((100-z-p)+'%人气');//客
    		dom.dg_sf.find('.gddghot p:eq(2) i').css({'height':k*3/100+'rem'});
		}
	}else if(lot == 'rq' && !!$rq.length){
		var x = $rq[t].rqspf.split(',');
		var x1 = x[0],x2 = x[1],x3 = x[2];
		dom.dg_rq.find('.tzxx').attr('v',$rq[t].itemid);
		dom.dg_rq.find('.tzxx li:eq(0) span:eq(0)').attr('s',x1);
		dom.dg_rq.find('.tzxx li:eq(0) span:eq(1)').attr('s',x2);
		dom.dg_rq.find('.tzxx li:eq(0) span:eq(2)').attr('s',x3);
		dom.dg_rq.find('.tzxx li:eq(0) span:eq(0) cite').html($rq[t].hn+'('+$rq[t].close+')');//主队
		dom.dg_rq.find('.tzxx li:eq(0) span:eq(2) cite').html($rq[t].gn);//客队
		dom.dg_rq.find('.tzxx li:eq(1) em:eq(0)').html('赔率'+x1);//主胜奖金
		dom.dg_rq.find('.tzxx li:eq(1) em:eq(1)').html('赔率'+x2);//平
		dom.dg_rq.find('.tzxx li:eq(1) em:eq(2)').html('赔率'+x3);//客胜
		var scale = $rq[t].rqspfscale.split(',');
		var z = parseInt(scale[0]);var p = parseInt(scale[1]);var k = parseInt(scale[2]);
		if(!isNaN(z)){
			dom.dg_rq.find('.gddghot p:eq(0) em').html(z+'%人气');//主人气
    		dom.dg_rq.find('.gddghot p:eq(0) i').css({'height':z*3/100+'rem'});
    		dom.dg_rq.find('.gddghot p:eq(1) em').html(p+'%人气');//平
    		dom.dg_rq.find('.gddghot p:eq(1) i').css({'height':p*3/100+'rem'});
    		dom.dg_rq.find('.gddghot p:eq(2) em').html((100-z-p)+'%人气');//客
    		dom.dg_rq.find('.gddghot p:eq(2) i').css({'height':k*3/100+'rem'});
		}
	}
}


var GddgSlide = function (a) {
	
    a = a || {
    };
    var b = {
        slideCell: a.slideCell || '#touchSlide',
        titCell: a.titCell || '.hd li',
        mainCell: a.mainCell || '.bd',
        effect: a.effect || 'left',
        autoPlay: a.autoPlay || !1,
        delayTime: a.delayTime || 200,
        interTime: a.interTime || 2500,
        defaultIndex: a.defaultIndex || 0,
        titOnClassName: a.titOnClassName || 'cur',
        autoPage: a.autoPage || !1,
        prevCell: a.prevCell || '.prev',
        nextCell: a.nextCell || '.next',
        pageStateCell: a.pageStateCell || '.pageState',
        pnLoop: 'undefined ' == a.pnLoop ? !0 : a.pnLoop,
        startFun: a.startFun || null,
        endFun: a.endFun || null,
        switchLoad: a.switchLoad || null
    },
    c = document.getElementById(b.slideCell.replace('#', ''));
    if (!c) return !1;
    var d = function (a, b) {
        a = a.split(' ');
        var c = [
        ];
        b = b || document;
        var d = [
            b
        ];
        for (var e in a) 0 != a[e].length && c.push(a[e]);
        for (var e in c) {
            if (0 == d.length) return !1;
            var f = [
            ];
            for (var g in d) if ('#' == c[e][0]) f.push(document.getElementById(c[e].replace('#', '')));
             else if ('.' == c[e][0]) for (var h = d[g].getElementsByTagName('*'), i = 0; i < h.length; i++) {
                var j = h[i].className;
                j && - 1 != j.search(new RegExp('\\b' + c[e].replace('.', '') + '\\b')) && f.push(h[i])
            } else for (var h = d[g].getElementsByTagName(c[e]), i = 0; i < h.length; i++) f.push(h[i]);
            d = f
        }
        return 0 == d.length || d[0] == b ? !1 : d
    },
    e = function (a, b) {
        var c = document.createElement('div');
        c.innerHTML = b,
        c = c.children[0];
        var d = a.cloneNode(!0);
        return c.appendChild(d),
        a.parentNode.replaceChild(c, a),
        m = d,
        c
    },
    g = function (a, b) {
        !a || !b || a.className && - 1 != a.className.search(new RegExp('\\b' + b + '\\b')) || (a.className += (a.className ? ' ' : '') + b)
    },
    h = function (a, b) {
        !a || !b || a.className && - 1 == a.className.search(new RegExp('\\b' + b + '\\b')) || (a.className = a.className.replace(new RegExp('\\s*\\b' + b + '\\b', 'g'), ''))
    },
    i = b.effect,
    j = d(b.prevCell, c) [0],
    k = d(b.nextCell, c) [0],
    l = d(b.pageStateCell) [0],
    m = d(b.mainCell, c) [0];
    if (!m) return !1;
    var N,
    O,
    n = m.children.length,
    o = d(b.titCell, c),
    p = o ? o.length : n,
    q = b.switchLoad,
    r = parseInt(b.defaultIndex),
    s = parseInt(b.delayTime),
    t = parseInt(b.interTime),
    u = 'false' == b.autoPlay || 0 == b.autoPlay ? !1 : !0,
    v = 'false' == b.autoPage || 0 == b.autoPage ? !1 : !0,
    w = 'false' == b.pnLoop || 0 == b.pnLoop ? !1 : !0,
    x = r,
    y = null,
    z = null,
    A = null,
    B = 0,
    C = 0,
    D = 0,
    E = 0,
    G = /hp-tablet/gi.test(navigator.appVersion),
    H = 'ontouchstart' in window && !G,
    I = H ? 'touchstart' : 'mousedown',
    J = H ? 'touchmove' : '',
    K = H ? 'touchend' : 'mouseup',
    M = m.parentNode.clientWidth,
    P = n;
    if(M!=0){
    	msize = M;
    }
    if(M==0){
    	M = msize;
    }
    'leftLoop' == i && (P += 2, m.appendChild(m.children[0].cloneNode(!0)), m.insertBefore(m.children[n - 1].cloneNode(!0), m.children[0])),
    N = e(m, '<div class="tempWrap" style="overflow:hidden; position:relative;"></div>'),
    m.style.cssText = 'width:' + P * M + 'px;' + 'position:relative;overflow:hidden;padding:0;margin:0;';
    for (var R = 0; P > R; R++) m.children[R].style.cssText = 'display:table-cell;vertical-align:top;width:' + M + 'px';
    var S = function () {
        'function' == typeof b.startFun && b.startFun(r, p)
    },
    T = function () {
        'function' == typeof b.endFun && b.endFun(r, p)
    },
    U = function (a) {
        var b = ('leftLoop' == i ? r + 1 : r) + a,
        c = function (a) {
            for (var b = m.children[a].getElementsByTagName('img'), c = 0; c < b.length; c++) b[c].getAttribute(q) && (b[c].setAttribute('src', b[c].getAttribute(q)), b[c].removeAttribute(q))
        };
        if (c(b), 'leftLoop' == i) switch (b) {
            case 0:
                c(n);
                break;
            case 1:
                c(n + 1);
                break;
            case n:
                c(0);
                break;
            case n + 1:
                c(1)
        }
    },
    V = function () {
        M = N.clientWidth,
        m.style.width = P * M + 'px';
        for (var a = 0; P > a; a++) m.children[a].style.width = M + 'px';
        var b = 'leftLoop' == i ? r + 1 : r;
        W( - b * M, 0)
    };
    window.addEventListener('resize', V, !1);
    var W = function (a, b, c) {
        c = c ? c.style : m.style,
        c.webkitTransitionDuration = c.MozTransitionDuration = c.msTransitionDuration = c.OTransitionDuration = c.transitionDuration = b + 'ms',
        c.webkitTransform = 'translate(' + a + 'px,0)' + 'translateZ(0)',
        c.msTransform = c.MozTransform = c.OTransform = 'translateX(' + a + 'px)'
    },
    X = function (a) {
        switch (i) {
            case 'left':
                r >= p ? r = a ? r - 1 : 0 : 0 > r && (r = a ? 0 : p - 1),
                null != q && U(0),
                W( - r * M, s),
                x = r;
                break;
            case 'leftLoop':
                null != q && U(0),
                W( - (r + 1) * M, s),
                - 1 == r ? (z = setTimeout(function () {
                    W( - p * M, 0)
                }, s), r = p - 1)  : r == p && (z = setTimeout(function () {
                    W( - M, 0)
                }, s), r = 0),
                x = r
        }
        S(),
        A = setTimeout(function () {
        	var id = "dg_sf";
        	if(nowCur==1){//当前是让球胜平负
        		duizhen(r,'rq');
        		id = "dg_rq";
        	}else{
        		duizhen(r,'sf');
        	}
        	countYjjj(id);
            T()
        }, s);
        c == r && g(o[c], b.titOnClassName);
        0 == w && (h(k, 'nextStop'), h(j, 'prevStop'), 0 == r ? g(j, 'prevStop')  : r == p - 1 && g(k, 'nextStop')),
        l && (l.innerHTML = '<span>' + (r + 1) + '</span>/' + p)
    };
    if (X(), u && (y = setInterval(function () {
        r++,
        X()
    }, t)), o) for (var R = 0; p > R; R++) !function () {
        var a = R;
        o[a].addEventListener('click', function () {
            clearTimeout(z),
            clearTimeout(A),
            r = a,
            X()
        })
    }();
    k && k.addEventListener('click', function () {
        (1 == w || r != p - 1) && (clearTimeout(z), clearTimeout(A), r++, X())
    }),
    j && j.addEventListener('click', function () {
        (1 == w || 0 != r) && (clearTimeout(z), clearTimeout(A), r--, X())
    });
    var Y = function (a) {
        clearTimeout(z),
        clearTimeout(A),
        O = void 0,
        D = 0;
        var b = H ? a.touches[0] : a;
        B = b.pageX,
        C = b.pageY,
        m.addEventListener(J, Z, !1),
        m.addEventListener(K, $, !1)
    },
    Z = function (a) {
        if (!H || !(a.touches.length > 1 || a.scale && 1 !== a.scale)) {
            var b = H ? a.touches[0] : a;
            if (D = b.pageX - B, E = b.pageY - C, 'undefined' == typeof O && (O = !!(O || Math.abs(D) < Math.abs(E))), !O) {
                switch (a.preventDefault(), u && clearInterval(y), i) {
                    case 'left':
                        (0 == r && D > 0 || r >= p - 1 && 0 > D) && (D = 0.4 * D),
                        W( - r * M + D, 0);
                        break;
                    case 'leftLoop':
                        W( - (r + 1) * M + D, 0)
                }
                null != q && Math.abs(D) > M / 3 && U(D > - 0 ? - 1 : 1)
            }
        }
    },
    $ = function (a) {
        0 != D && (a.preventDefault(), O || (Math.abs(D) > M / 10 && (D > 0 ? r-- : r++), X(!0), u && (y = setInterval(function () {
            r++,
            X()
        }, t))), m.removeEventListener(J, Z, !1), m.removeEventListener(K, $, !1))
    };
    m.addEventListener(I, Y, !1)
};


function zjlist(){
	   var speed=40;
	   var demo = $('#zjlist');
	   var demo1 = $('#zjlist1');
	   var demo2 = $('#zjlist2');
	   demo2.html(demo1.html());
	   function Marquee(){
		   if(demo2[0].offsetTop-demo[0].scrollTop<=0){
			   demo[0].scrollTop-=demo1[0].offsetHeight;
		   }else{
			   demo[0].scrollTop++;
		   }
	   }
	   var MyMar=setInterval(Marquee,speed);
	   demo[0].onmouseover=function() {clearInterval(MyMar);};
	   demo[0].onmouseout=function() {MyMar=setInterval(Marquee,speed);};
}

function phblist(){
	var dataurl = '/data/huodong/yfg/all_yfg.xml?rnd=' + Math.random();
//	var dataurl = '/activity/yfq/all_yfg.txt?rnd=' + Math.random();//测试使用txt
	$.ajax({
		url: dataurl,
		dataType : "xml",
		type : "get",
		cache:false,
		success : function(data) {
			var r = $(data).find("row");
			var cr = $(data).find("rows");
			var count = $(cr).attr("num");     //参与人数
			var html = "<ul>";
			var inner = "";
			r.each(function(i,row) {
				var cnickid = $(this).attr("cnickid"); //用户名
				var ibonus = $(this).attr("ibonus");   //奖金
				ibonus = parseFloat(ibonus).toFixed(2);
				var cprojid = $(this).attr("cprojid"); //方案编号
				var count = $(this).attr("count");     //参与人数
				var cbonus = ibonus;
				if(ibonus<10){
					cbonus = "&nbsp"+ibonus;
				}
				cnickid = cnickid.length>2?cnickid.substring(0,2)+"**":cnickid;
				
				inner+="<li><em>"+cnickid+"</em><cite>0.01元</cite><span>中<i>"+cbonus+"</i></span></li>";
				
			});
			$("#phbcount").html(count);
			if(inner == ""){
				
			}else{
				html+=inner;
				html+="</ul>";
				
				$("#zjlist1").html(html);
				$("#zjlist2").html($("#zjlist1").html());
				zjlist();
			}
		},
		error : function() {
			//Y.alert("您所请求的信息有异常！");
			return false;
		}					
	});
	
}

//设置预计奖金
function countYjjj(id){
	var max = $("#"+id).find('.tzxx .cur').attr('s');
	if(max!=undefined&&max!='undefined'){
		var yjjj = parseFloat(max)*2
		yjjj = yjjj.toFixed(2);
		$("#yjjj").html(yjjj);
	}
}
function msg(msg){
	clearTimeout(window.alert.time);
    var obj = $('<div class="alertBox">'+msg+'</div>');
    $("body").append(obj);
    window.alert.time = setTimeout(function() {
        $(".alertBox").remove();
    }, 2000);
}



