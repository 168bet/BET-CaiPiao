
/**
 * @namespace 首页类
 * @name Home
 * @author wangwei
 * @memberOf CP
 */
$prev = '/#class=home';
$current = '';
CP.Home = function () {
		var j_ = '';
		var n_ = new Date();//服务器时间
		var tag = 'ssq';
		var a = {
				jxNum: function(obj, tag){
					if(tag == 'ssq'){
						var ssq = Random(33),i;
						ssq = ssq.slice(0,6).sort(function(a,b){return a-b;});
						for(i=0; i<6; i++){
							obj[i].innerHTML=zeroStr(ssq[i],2);
						}
						var ssq_b = Random(16);
						obj[6].innerHTML=zeroStr(ssq_b[6],2);
					}else{
						var dlt = Random(35),i;
						dlt = dlt.slice(0,5).sort(function(a,b){return a-b;});
						for(i=0; i<5; i++){
							obj[i].innerHTML=zeroStr(dlt[i],2);
						}
						var dlt_b = Random(12);
						dlt_b = dlt_b.slice(0,2).sort(function(a,b){return a-b;});
						obj[5].innerHTML=zeroStr(dlt_b[0],2);
						obj[6].innerHTML=zeroStr(dlt_b[1],2);
					}
				},
				setJx: function () {//机选一注
	                clearInterval(j_);
	                var g = 0,
	                q = 100;
	                $('#ball em').addClass('rotate_jx');
	                a.jxNum($('#ball em'),tag);
	                j_ = setInterval(function () {
	                    $('#ball em:eq(' + g + ')').removeClass('rotate_jx');
	                    g++;
	                    if (g > 6) {return false;}
	                }, q);
				},
		};
		var b = {
				init: function(){
					b.bindEvent();
					var t = n_.getHours();
					var wk = n_.getDay();
					t = (t>=18 && 'Hi,晚上好!') || (t>=14 && 'Hi,下午好!') || (t>=11 && 'Hi,中午好!') || (t>=5 && 'Hi,早上好!') || 'Hi,晚上好!';
					$('#say_hi').html(t);
					if(wk == '2' || wk == '4' || wk == '0' || wk == '5'){//
						$('#handy strong').html('双色球');
						(wk != '5') && $('#tag_01').find('em').eq(0).addClass('jrkjico');//今日开奖
					}else{
						tag = 'dlt';
						$('#handy strong').html('大乐透');
						$('#handy div:eq(1)').find('em').eq(5).addClass('blue');
						$('#tag_50').find('em').eq(0).addClass('jrkjico');
					}
					a.setJx();
					$('#handy').on('click','div:eq(0)',function(){//机选一注
						a.setJx();
					});
					$('#ball').on('click','a',function(){//购买
						var n = $('#ball em').length,i;
						var lot_ = {'ssq':'01','dlt':'50'}[tag];
						if(tag == 'ssq'){
							var ssq = '';
							$('#ball').find('em').each(function(a){
								if(a<5){
									ssq += $(this).html()+',';
								}
								if(a == 5){
									ssq += $(this).html()+'|';
								}
								if(a==6){
									ssq += $(this).html();
								}
							});
							localStorage.setItem('ssq',ssq);
						}else{
							var dlt = '';
							$('#ball').find('em').each(function(a){
								if(a<4){
									dlt += $(this).html()+',';
								}
								if(a == 4){
									dlt += $(this).html()+'|';
								}
								if(a>4){
									dlt += $(this).html()+',';
								}
							});
							dlt = dlt.substr(0,dlt.length-1);
							localStorage.setItem('dlt',dlt);
						}

						window.location.href='/#class=url&xo=trade/defrayal.html&notes=1&multiple=1&issue=1&countMoney=2&pattern=0&gid='+lot_;
					});
					$(window).scroll(function () {
					    if ($('.fllist')) {
					        var n = $('.index_nav_').offset().top;
					        $(this).scrollTop() > n + 70 ? $('.fllist').show()  : $('.fllist').hide();
					    }
					});
				},
				bindEvent: function(){
					var agent = localStorage.getItem('from');
					var agent1 = localStorage.getItem('comeFrom');
					(agent == 'zxhuoc1') && (document.title = '智行彩票网-网上买彩票/竞彩/足彩/快频彩/福利彩票/体育彩票-最安全的网上购彩平台');
					(agent1 == 'zxhuoc1') && (document.title = '智行彩票网-网上买彩票/竞彩/足彩/快频彩/福利彩票/体育彩票-最安全的网上购彩平台');
					if(!!agent || !!agent1){
						$('.inheader').hide();
					}
					$("#apk").on('click',function(){
				    	var agent1 = localStorage.getItem('comeFrom');
				    	window.location.href = 'http://mobile.9188.com  /jsp/download.jsp?id='+agent1;
					});
					$('.popup,.zhezhao2').on('click',function(){
						$('.popup,.zhezhao2').hide();
					});
					$('#my_lottery,#my_lottery2').on('click',function(){

						 window.location.href = '#class=url&xo=useraccount/index.html';
					});
				},
		};
		return {init: b.init};
}();
CP.Data.slideBox = '';
var hashchange = function () {
	var hash_ = null;
	var url_title = {
			'ssq/index.html':'【双色球】',
			'ssq/ture.html':'【双色球-投注】',
			'dlt/index.html':'【大乐透】',
			'dlt/ture.html':'【大乐透-投注】',
			'jczq/index.html':'【竞彩胜平负】',
			'jczq/ture.html':'【竞彩胜平负-投注】',
			'jczq/rqspf/index.html':'【竞彩让球胜平负】',
			'jczq/rqspf/ture.html':'【竞彩让球胜平负-投注】',
			'jczq/bf/index.html':'【竞彩比分】',
			'jczq/bf/ture.html':'【竞彩比分-投注】',
			'jczq/bqc/index.html':'【竞彩半全场】',
			'jczq/bqc/ture.html':'【竞彩半全场-投注】',
			'jczq/hh/index.html':'【竞彩混投】',
			'jczq/hh/ture.html':'【竞彩混投-投注】',
			'bjdc/index.html':'【北单胜平负】',
			'bjdc/ture.html':'【北单胜平负-投注】',
			'bjdc/bf/index.html':'【北单比分】',
			'bjdc/bf/ture.html':'【北单比分-投注】',
			'bjdc/bqc/index.html':'【北单半全场】',
			'bjdc/bqc/ture.html':'【北单半全场-投注】',
			'bjdc/sx/index.html':'【北单上下单双】',
			'bjdc/sx/ture.html':'【北单上下单双-投注】',
			'bjdc/jq/index.html':'【北单总进球】',
			'bjdc/jq/ture.html':'【北单总进球-投注】',
			'ahk3/index.html':'【快3】',
			'ahk3/ture.html':'【快3-投注】',
			'r9/index.html':'【任九】',
			'r9/ture.html':'【任九-投注】',
			'11x5/index.html':'【11选五】',
			'11x5/ture.html':'【11选五-投注】',
			'jxssc/index.html':'【新时时彩】',
			'jxssc/ture.html':'【新时时彩-投注】',
			'sfc/index.html':'【胜负彩】',
			'sfc/ture.html':'【胜负彩-投注】',
			'jclq/index.html':'【篮彩让分胜负】',
			'jclq/ture.html':'【篮彩让分胜负-投注】',
			'jclq/sf/index.html':'【篮彩胜负】',
			'jclq/sf/ture.html':'【篮彩胜负-投注】',
			'jclq/dxf/index.html':'【篮彩大小分】',
			'jclq/dxf/ture.html':'【篮彩大小分-投注】',
			'jclq/hh/index.html':'【篮彩混投】',
			'jclq/hh/ture.html':'【篮彩混投-投注】',
			'sfgg/index.html':'【胜负过关】',
			'sfgg/ture.html':'【胜负过关-投注】',
			'pk3/index.html':'【快乐扑克3】',
			'pk3/ture.html':'【快乐扑克3-投注】',
			'3d/index.html':'【福彩3D】',
			'3d/ture.html':'【福彩3D-投注】',
			'p3/index.html':'【排列三】',
			'p3/ture.html':'【排列三-投注】',
			'p5/index.html':'【排列五】',
			'p5/ture.html':'【排列五-投注】',
			'qxc/index.html':'【七星彩】',
			'qxc/ture.html':'【七星彩-投注】',
			'qlc/index.html':'【七乐彩】',
			'qlc/ture.html':'【七乐彩-投注】',
			'11ydj/index.html':'【十一运夺金】',
			'11ydj/ture.html':'【十一运夺金-投注】',
			'hm/index.html':'【合买中心】',
			'kj/index.html':'【开奖结果】',
			'trade/fqhm.html':'【发起合买】',
			'trade/buyconfirm.html':'【发起合买】',
			'gddg/pay/dg_fqhm.html':'【发起合买】'
	};
	//需要加背景色的页面
	var url_Array = ['viewpath/payment.html','useraccount/setup.html','useraccount/withdrawal.html','trade/buyconfirm.html',
	                 'trade/defrayal.html','trade/paybd.html','r9/hm/index.html','trade/fqhm.html','useraccount/recharge.html',
	                 'gddg/pay/dg_fqhm.html','gddg/pay/paydg.html'];
	var is_inArray = function(url){
		if($.inArray(url,url_Array)>=0){
			return true;
		}else{
			return false;
		}
	};
	var change = function() {
		$current = location.hash;
		$('#tm_c').hide();//右上角的遮罩层很有可能没关 在这里关掉
		var type = CP.Util.getParaHash("class") || "home";
        var url = decodeURIComponent(CP.Util.getParaHash("xo"));
        if (type.indexOf("home") > -1) {
            type = "home";
        }
        switch (type) {
        case "home":
        case "url":
        	D.load(close);
            if (type == "url" && url) {
            	$("#home_page").hide();
                $('#content_home').html('');
                $('#load_home').show();
            }else{
            		$('#slideBox .bd').html('');
            		$.ajax({
    					url:"/data/app/latest-lottery-touch-brief.xml",
    					success  : function (xml){
    						var brief = $(xml).find('brief');
    						var html = '<ul>';
    						brief.each(function(){
    							var g_ = $(this).attr('gid');
    							var b_ = $(this).attr('brief');//彩种简介
    							var addtional = $(this).attr('addtional');//是否加奖 yes是 no否
    							var banneraddress = $(this).attr('banneraddress');//图片链接
    							var descfont = $(this).attr('descfont');//图片地址
    							
    							$('#tag_'+g_).find('p').html(b_);
    							if(addtional === 'yes'){
    								$('#tag_'+g_).find('em').eq(0).addClass('jjico');
    							}
    							
    							if(!!descfont){
    								html += '<li><a href="'+banneraddress+'" class="pic"><img src="'+descfont+'"></a></li>';
    							}
    						});
    						html += '</ul>';
    						$('#slideBox .bd').html(html);
    						var tag = $('#slideBox .bd ul').find('li').length;
    						if(!!tag){
    							$('#slideBox').show();
    							tag = (tag == 1 ?false:true);
    							TouchSlide({ slideCell:"#slideBox",
    								titCell:".hd2 ul",
    								mainCell:".bd ul",effect:"leftLoop",autoPage:true,autoPlay:tag});
    						}
    					}
    				});
            		if($('#yuce').html() == ''){
            			$.ajax({
    						url:'/trade/forecast.go?name=html5yuce',
    						type:'POST',
    						dateType:'xml',
    						success : function(data){
    							var r = $(data).find('row');
    							r.each(function(){
    								var name = $(this).attr('name');
    								var title = $(this).attr('title');
    								var arcurl = $(this).attr('arcurl');
    								var gid = $(this).attr('gid');
    								if(gid != 50 && gid != 'null'){
    									var local=window.location.href.split("/");																	
    									var t = {'01':'ssq/index.html','70':'jczq/index.html','71':'jclq/index.html','85':'bjdc/index.html','80':'sfc/index.html'}[gid]||'';
    									var tname = {'01':'双色球','70':'竞彩','71':'篮彩','85':'北单','80':'足彩'}[gid]||'';							
    									$('<a href="http://mobile.9188.com  '+arcurl+'?phone=4g&url='+local[0]+"//"+local[1]+local[2]+'/#class=url&xo='+t+'"><span><em>['+tname+']</em>'+title+'</span><i class="rightArrow"></i></a>').appendTo($('#yuce'));
    								}
    							});
    						}
    					});
            		}
            }
            url = url || "home";
            getPage(url);
            break;
        }
    };
    var getPage = function(url) {
        if (url.indexOf("?") > -1) {
            url = url.substring(0, url.indexOf("?"));
        }
        if ($("#home_page").length && url == "home") {
        	$("body").removeClass('grayBg');
            $("#content_home").html("");
            $("#content_home").hide();
            $('#load_home').hide();
            $("#home_page").show();
            document.title = '购彩大厅';
        } 
        else {
        	var SG = true;
        	if (CP.Storage.get(url) && CP.Storage.get(url) != "") {
        		(url.indexOf('ture.html')>-1) && $("body").addClass('grayBg') || $("body").removeClass('grayBg');
        		success(CP.Storage.get(url));
        		SG = false;
        	}
            $.ajaxSetup({global: false,cache: true});
            jQuery.ajax({type: "GET",dataType: "text",cache: true,url: '/'+url,success: function(html) {
	            	if(url.indexOf('ture.html')>-1 || url.indexOf('login')>-1 || is_inArray(url)){
	            		$("body").addClass('grayBg');
	            	}else{
	            		$("body").removeClass('grayBg');
	            	}
                    CP.Storage.set(url, html);
                    SG && success(html);
                    document.title  = url_title[url]||'【购彩大厅】';
                },error: function(e) {
                    window.location.href = "/#class=home";
                    return
                }});
        }
        function success(html) {
        	$('#load_home').hide();
            $("#home_page").hide();
            $("#content_home").show();
            $("#content_home").html(html);
            window.scrollTo(0, 1);
            var t = $prev;
            $('.fcbackIco2,.backLink,.backIco2').one('click',function(){
            	 if(/ipad|iphone|mac/i.test(navigator.userAgent)){
            		 ($(this).attr('href').indexOf('javascript') >-1) && $(this).attr('href',t);
            	 }
    		});
            $prev = $current;
        }
	};
	var init = function() {
		if (window.DeviceMotionEvent) {
		    window.addEventListener('devicemotion',deviceMotionHandler, false);
		}
		CP.Home.init();
		if (window.location.hash == "") {
	        window.location.replace("/#class=home");
	    }else{
	    	change();
	    }
		if ("onhashchange" in window) {
	        window.addEventListener ? window.addEventListener("hashchange", change, false) : window.attachEvent("onhashchange", change);
	    } else {
	        setInterval(function() {
	            if (hash_ != window.location.hash) {hash_ = window.location.hash;change();}
	        }, 500);
	    }
	};
	init();
}();

var SHAKE_THRESHOLD = 500;      
var last_update = 0;
var x=y=z=last_x=last_y=last_z=0;
function deviceMotionHandler(eventData) {
    var i =eventData.accelerationIncludingGravity;    
    var curTime = new Date().getTime();   
	    if ((curTime - last_update)> 200) {
	        var diffTime = curTime -last_update;      
	        last_update = curTime;          
	        x = i.x;   
	        y = i.y;     
	        z = i.z;     
	        var speed = Math.abs(x +y + z - last_x - last_y - last_z) / diffTime * 10000;     
	          
	        if (speed > SHAKE_THRESHOLD) {
	        	if($("#shake").is(":visible")){
	        		stealth();
	        		$('#shake').click();
	        	}
	        }      
	        last_x = x;      
	        last_y = y;      
	        last_z = z;
	    }
}

var TouchSlide = function (a) {
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
    if (0 == p && (p = n), v) {
        p = n,
        o = o[0],
        o.innerHTML = '';
        var Q = '';
        if (1 == b.autoPage || 'true' == b.autoPage) for (var R = 0; p > R; R++) Q += '<li></li>';
         else for (var R = 0; p > R; R++) Q += b.autoPage.replace('$', R + 1);
        o.innerHTML = Q,
        o = o.children
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
            T()
        }, s);
        for (var c = 0; p > c; c++) h(o[c], b.titOnClassName),
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
