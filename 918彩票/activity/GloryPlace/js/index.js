//公用弹出层和加载层
var win_alert = alert;
window['alert'] = function (msg, loading) {
    if (!loading) {
        clearTimeout(window.alert.time);
        var obj = $('<div class="alertBox">' + msg + '</div>');
        $('body').append(obj);
        window.alert.time = setTimeout(function () {
            $(".alertBox").remove();
        }, 2000);
    } else {
        $('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
        $('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
        $('#mask').show();
    }
};
var remove_alert = function () {
    $('.alertBox').remove();
    $('#mask').hide();
};

var PersonData={};
var BigMoney={};
var CP={};
var browser={
versions:function(){
    var u = navigator.userAgent, app = navigator.appVersion;
    return {
        trident: u.indexOf('Trident') > -1, //IE内核
        presto: u.indexOf('Presto') > -1, //opera内核
        webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
        gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,//火狐内核
        mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
        ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
        android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1 || u.indexOf('Linux') > -1, //android终端
        };
    }(),
}
BigMoney.AppJiek = {
    appLogin:function(){//原生登录接口
        if(browser.versions.android){//登录调用原生接口
            window.caiyiandroid.clickAndroid(3, '');
        }
        if(browser.versions.ios){
            WebViewJavascriptBridge.callHandler('clickIosLogin');
        }
    },
    moBind:function(){
        if(browser.versions.android){//绑定手机号调用原生接口
            window.caiyiandroid.clickAndroid(5,'');
        }
        if(browser.versions.ios){
            WebViewJavascriptBridge.callHandler('callBackIOS','1');
        }
    },
    cardBind:function(){
        if(browser.versions.android){//绑定身份证调用原生接口
            window.caiyiandroid.clickAndroid(6,'');
        }
        if(browser.versions.ios){
            WebViewJavascriptBridge.callHandler('callBackIOS','2');
        }
    },
    ChargeMoney:function(){
        if(browser.versions.android){
            window.caiyiandroid.clickAndroid(7, '');
        }
        if(browser.versions.ios){
            WebViewJavascriptBridge.callHandler('callBackIOS','3');
        }
    },
    GotoBuyssq:function(){
        //双色球 01 大乐透50
        if(browser.versions.android){
            window.caiyiandroid.clickAndroid(0, '01');
        }
        if(browser.versions.ios){
            WebViewJavascriptBridge.callHandler('clickIosLottery','01');
        }
    },
    DownLoadApk:function(){
        if(browser.versions.android){
            // 调用外部下载
            window.caiyiandroid.clickAndroid(12, '');
        }
    }
}
    /**
 * @namespace 数学计算类
 * @name math
 * @memberOf CP
 */
CP.math = {
    /**
     * @description 排列总数
     * @param {Int} n 总数
     * @param {Int} m 组合位数
     * @return {Int}
     * @example CP.math.C(6,5);
     * @memberOf CP.math
     */
    C: function (n, m) {
        var n1 = 1, n2 = 1;
        for (var i = n, j = 1; j <= m; n1 *= i--, n2 *= j++) {
        }
        return n1 / n2;
    },
    /**
     * @description 组合总数
     * @param {Int} n 总数
     * @param {Int} m 组合位数
     * @return {Int}
     * @example CP.math.P(5,3); 60
     * @memberOf CP.math
     */
    P: function (n, m) {
        var n1 = 1, n2 = 1;
        for (var i = n, j = 1; j <= m; n1 *= i--, n2 *= j++) {
        }
        return n1;
    },
    /**
     * @description 枚举数组算法
     * @param {Int} n 数组长度
     * @param {Int|Array} m 枚举位数
     * @return {Int}
     * @example CP.math.Cs(4,3);  [[1,2,3],[1,2,4],[1,3,4],[2,3,4]]
     * @memberOf CP.math
     */
    Cs: function (len, num) {
        var arr = [];
        if (typeof(len) == 'number') {
            for (var i = 0; i < len; i++) {
                arr.push(i + 1);
            }
        } else {
            arr = len;
        }
        var r = [];
        (function f(t, a, n) {
            if (n == 0) return r.push(t);
            for (var i = 0, l = a.length; i <= l - n; i++) {
                f(t.concat(a[i]), a.slice(i + 1), n - 1);
            }
        })([], arr, num);
        return r;
    },
    /**
     * @description 获取竞彩N串1注数
     * @param {Array} spArr [2,2,1] 每一场选中的个数
     * @param {Int} n n串1
     * @return {Int}
     * @example CP.math.N1([2,2,1],3);
     * @memberOf CP.math
     */
    N1: function (spArr, n) {
        var zhushu = 0;
        var m = spArr.length;//场次
        var arr = CP.math.Cs(m, n);
        for (var i = 0; i < arr.length; i++) {
            var iTotal = 1;//每场注数
            for (var j = 0; j < arr[i].length; j++) {
                iTotal *= spArr[arr[i][j] - 1]
            }
            zhushu += iTotal
        }
        return zhushu;
    },
    /**
     * @description 获取竞彩N串1胆拖注数
     * @param {Array} spArrd [[3,3,3,1,2],[1,1,1,1,0]] 选中5场，4场胆拖
     * @param {Int} n n串1
     * @return {Int}
     * @example CP.math.N1d([[3,3,3,1,2],[1,1,1,1,0]],5); 选中5场，4场胆拖，5串1玩法  return 54
     * @example CP.math.N1d([[3,3,3,1,2],[1,0,0,0,0]],3); 选中5场，1场胆拖，3串1玩法  return 87
     * @memberOf CP.math
     */
    N1d: function (spArrd, n) {
        var nArr = [], dArr = [];
        try {
            for (var i = 0; i < spArrd[1].length; i++) {
                if (spArrd[1][i] == 1) {
                    dArr.push(spArrd[0][i]);
                } else {
                    nArr.push(spArrd[0][i]);
                }
            }
        }catch (e) {
            return 0;
        }
        if (dArr.length <= n) {
            return CP.math.N1(nArr, n - dArr.length) * CP.math.N1(dArr, dArr.length);
        } else {
            return 0;
        }
    },
    /**
     * @description 机选号码
     * @param {Int} startNum   起始值
     * @param {Int} totalNum   总数长度
     * @param {Int} len        机选个数或者数组
     * @param {Int} a          是否重复，缺省不重复
     * @param {Array} rep      删除不需要的元素，定胆机选用
     * @param {String} con     幸运选号类型'彩种+玩法+类型+值'例如：dlcr5xz1
     * @param {String} hour    幸运选好保留时间
     * @return {Array}
     * @example CP.math.random(1,35,5); 机选1-35之间5不重复个数字 return [4,12,16,8,34,9]
     * @example CP.math.random(1,12,2,true); 机选 return [4,4]
     * @example CP.math.random(1,11,5,null,[],'dlcr5xz1') 幸运选号
     * @memberOf CP.math   1 10 5
     */
    random: function (startNum, totalNum, len, a, rep, con, hour) {
        var absNum = Math.abs(startNum - totalNum) + 1;
        var repL = 0;
        var luckCon = con && con.split('') || [];
        if (typeof(rep) == 'object') {
            repL = rep.length;
        }
        if (typeof len == "undefined" || len > absNum || len < 1 || len > absNum - repL) {
            return [];
        }

        var o = {}, _r = new Array(len), i = 0, s, j = 1;
        if (luckCon.length > 0 && CP.Cookie.get(con) !== '') {
            return CP.Cookie.get(con).split(',');
        } else {
            while (i < len) {
                s = parseInt(Math.random() * absNum + startNum);
                if (!a) {
                    s = function (a, s) {
                        for (var i = 0; i < a.length;) {
                            if (a[i++] == s)return null;
                            if (typeof(rep) == 'object') {
                                for (var j = 0; j < repL; j++) {
                                    if (s == rep[j])return null;
                                }
                            }
                        }
                        return s
                    }(_r, s);
                    s !== null && (_r[i++] = s);
                } else {
                    _r[i++] = s;
                }
            }
            if (luckCon.length > 0) {
                hour = (hour || 1) - (new Date().getMinutes()) / 60;
                CP.Cookie.set(con, _r.join(','), null, null, hour);
            }
        }
        return _r;
    }
};
CP.Util = {
    pad: function (source, length) {
        var pre = "",
            negative = (source < 0),
            string = String(Math.abs(source));
        if (string.length < length) {
            pre = (new Array(length - string.length + 1)).join('0');
        }
        return (negative ? "-" : "") + pre + string;
    }
}

BigMoney.Gotobuy=function(){
   $("#BuyGoly").click(function(e){
        e.stopPropagation();
        
        var getHost=window.location.origin;
        try
            {
               BigMoney.AppJiek.GotoBuyssq();
               ClickCont('大奖墙投注')
            }
        catch(err)
            { 	
                window.location=getHost+'/#type=url&p=list/ssq.html';
                sessionStorage.setItem('Reload',true)
            }
        if(navigator.userAgent.indexOf('UCBrowser') > -1) {
        	window.location=getHost+'/#type=url&p=list/ssq.html';
//            alert(windows.location)
        }
        
    })
}


BigMoney.share=function() {
    $.ajax({
        url : '/requestService.go',
        type : 'POST',
        data : {
            action : 'getShareParam',
            shareurl : location.href
        },
        success : function(xml) {
            var R = $(xml).find('Resp');
            var r = R.find('row');
            var appId = r.attr('appId');
            var timestamp = r.attr('timestamp');
            var nonceStr = r.attr('nonceStr');
            var signature = r.attr('signature');
            wx.config({
                debug : false,// 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                appId : appId, // 必填，公众号的唯一标识
                timestamp : timestamp, // 必填，生成签名的时间戳
                nonceStr : nonceStr, // 必填，生成签名的随机串
                signature : signature,// 必填，签名，见附录1
                jsApiList : [ 'onMenuShareTimeline',
                        'onMenuShareAppMessage',
                        'onMenuShareQQ', 'onMenuShareWeibo' ]
            // 必填，需要使用的JS接口列表，所有JS接口列表见附录2

            });
            wx.ready(function() {
                var title = '大奖荣誉墙'; // 分享标题
                var desc = '历史大奖巡礼，速速前来膜拜'; // 分享描述
                var link = location.href; // 分享链接
                var imgUrl = 'http://5.9188.com/NewVipRegister/img/sharelogo.png'; // 分享图标
                var dataUrl = location.href;// 如果type是music或video，则要提供数据链接，默认为空
                // alert(imgUrl)
                // location.host+'/activity/NewVipRegister/img/sharelogo.png'
                wx.onMenuShareAppMessage({//分享给朋友
                    title : title,
                    desc : desc,
                    link : link, // 分享链接
                    imgUrl : imgUrl, // 分享图标
                    type : 'link', // 分享类型,music、video或link，不填默认为link
                    dataUrl : dataUrl, // 如果type是music或video，则要提供数据链接，默认为空
                    success : function() {
                        // 用户确认分享后执行的回调函数
                    },
                    cancel : function() {
                        // 用户取消分享后执行的回调函数
                    }
                });
                wx.onMenuShareTimeline({//分享到朋友圈
                    title : title, // 分享标题
                    link : link, // 分享链接
                    imgUrl : imgUrl, // 分享图标
                    success : function() {
                        // 用户确认分享后执行的回调函数
                    },
                    cancel : function() {
                        // 用户取消分享后执行的回调函数
                    }
                });

                wx.onMenuShareQQ({//分享到QQ
                    title : title, // 分享标题
                    desc : desc, // 分享描述
                    link : link, // 分享链接
                    imgUrl : imgUrl, // 分享图标
                    success : function() {
                        // 用户确认分享后执行的回调函数
                    },
                    cancel : function() {
                        // 用户取消分享后执行的回调函数
                    }
                });

                wx.onMenuShareWeibo({//分享到腾讯微博
                    title : title, // 分享标题
                    desc : desc, // 分享描述
                    link : link, // 分享链接
                    imgUrl : imgUrl, // 分享图标
                    success : function() {
                        // 用户确认分享后执行的回调函数
                    },
                    cancel : function() {
                        // 用户取消分享后执行的回调函数
                    }
                });
                // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
            });
        }
    });
}
BigMoney.init=function(){
    var j_ = '';
    var n_ = new Date();//本地时间
    var tag = 'ssq';
    var url_ = '';
    var saveRollData=[];
    var a = {
            jxNum: function(obj, tag){
                if(tag == 'ssq'){//机选双色球
                    var ssq = CP.math.random(1,33,6),i;
                    ssq = ssq.slice(0,6).sort(function(a,b){return a-b;});
                    for(i=0; i<6; i++){
                        obj[i].innerHTML=CP.Util.pad(ssq[i],2);
                    }
                    var ssq_b = CP.math.random(1,16,1);//蓝球
                    obj[6].innerHTML=CP.Util.pad(ssq_b[0],2);
                }else{//大乐透
                    var dlt = CP.math.random(1,35,5),i;
                    dlt = dlt.slice(0,5).sort(function(a,b){return a-b;});
                    for(i=0; i<5; i++){
                        obj[i].innerHTML=CP.Util.pad(dlt[i],2);
                    }
                    var dlt_b = CP.math.random(1,12,2);
                    dlt_b = dlt_b.slice(0,2).sort(function(a,b){return a-b;});
                    obj[5].innerHTML=CP.Util.pad(dlt_b[0],2);
                    obj[6].innerHTML=CP.Util.pad(dlt_b[1],2);
                }
            },
            setJx: function () {//机选一注
                clearInterval(j_);
                var g = 0,
                q = 100;
                $('.kjball em').addClass('rotate_jx');
                a.jxNum($('.kjball em'),'ssq');
                j_ = setInterval(function () {
                    $('.kjball em:eq(' + g + ')').removeClass('rotate_jx');//给每个球添加动画效果
                    g++;
                    if (g > 6) {return false;}
                }, q);
         
            },
    };
    var s={
        SaveData:function(){
            $('.kjball em').each(function(i){
                saveRollData[i]=$(this).html()
            })
            sessionStorage.setItem('BigMoney',saveRollData)
        }
    }
    var b={
       init:function(){
    	   a.setJx();//双色球机选
           s.SaveData();
            $('#rollNew').on('click',function(){//机选一注
                a.setJx();
                s.SaveData();
            });
       }()
    }
    return {init:b.init};
}    
BigMoney.getContent=function(){
    $.ajax({
        url : "/data/app/HistoryAwardXml/HistoryAward.xml",  
//    	 url : "./HistoryAward.xml",  
        type:'GET',
        dataType:'xml',
        success:function(xml){
            var rows = $(xml).find("rows");
            var row = rows.find("row");
            var html=""
            if(row.length>0){
                row.each(function(){
                    var money = $(this).attr("cdisplay");

                    var caizhong = $(this).attr("cname");
                    var getQici=$(this).attr("cperiodid")||'';
                    var conent = $(this).attr("ddescribe");
                    var curl = $(this).attr("curl");
                    html +='<dl><dt>'
                    html +='<span>'+money+'</span>'
                    html +='<cite>'+caizhong
                    html +=getQici!=''?(getQici+'期次'):''+'</cite></dt>'
                    if(curl!=''){
                        html +='<dd><a href='+curl+' >'+conent+'</a></dd>'
                    }else{
                        html +='<dd>'+conent+'</dd>'
                    }
                    html +='</dl> '
                })
                $(".list").html(html);
            }
        },error:function(){
              alert('网络异常');
        }
    })
}
$(function(){
	if(JSON.parse(sessionStorage.getItem('Reload'))==true){
		top.window.location.reload();
		sessionStorage.setItem('Reload',false);
	}
	BigMoney.init();
    BigMoney.Gotobuy();
    BigMoney.getContent();
    BigMoney.share();
})
