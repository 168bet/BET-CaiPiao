//var serverTime = {
//    stime: {},
//    init: function () {
//        if (serverTime.stime.timeStr1 == undefined) {
//            $.ajax({
//                type: 'POST',
//                url: '/home/getServerTime',
//                cache: false,
//                async: false,
//                dataType: 'json',
//                success: function (response) {
//                    serverTime.stime = response;
//                }
//            });
//        }
//    }
//};

/*
当前时间
*/
var servertime;
if (typeof (nowtime) != "undefined") {
    servertime = new Date(nowtime);
} else {
    servertime = new Date();
}
var y, month, d, h, m, s;
window.setInterval(function () {
    y = servertime.getFullYear();
    month = servertime.getMonth();
    d = servertime.getDate();
    h = servertime.getHours();
    m = servertime.getMinutes();
    s = servertime.getSeconds();
    servertime = new Date(y, month, d, h, m, s + 1);
}, 1000);
//serverTime.init();
/**
* @namespace 截止时间倒计时
*/
var Timer = function (difftime, awardtime) {
    //this.serverTime = CP.getServerTime() || new Date().getTime(); //服务器时间
    this.endTime = difftime || 0;
    this.awardTime = awardtime || 0;
    this.endTimeArr = [];
    this.time; //定时器
};
Timer.prototype = {
    /**
    * @description 倒计时
    * @param {Number} endTime 时间戳
    * @param {Function} callback 每次间隔执行
    * @param {Number} speed 频率
    * @example var t=new Timer();
    t.countDown(1349411500000,function(obj){
    if(obj){
    //{d: d, h: h, m: m, s: s, ms: ms, text: str}
    }else{

    clearInterval(t2.time)
    }
    },1000);
    * @memberOf Timer
    */
    countDown: function (callback, speed) {
        var self = this;
        speed = speed || 1000;
        self.time = window.setInterval(function () {
            callback && callback(self.run());
        }, speed);
    },
    run: function () {
        var difftime = this.endTime, obj;
        if (difftime >= 0) {
            var d = parseInt(difftime / 60 / 60 / 24, 10);
            var h = parseInt(difftime / 60 / 60 % 24, 10);
            var m = parseInt(difftime / 60 % 60, 10);
            var s = difftime % 60;
            d < 10 && (d = '0' + d);
            h < 10 && (h = '0' + h);
            m < 10 && (m = '0' + m);
            s < 10 && (s = '0' + s);
            obj = { d: d.toString(), h: h.toString(), m: m.toString(), s: s.toString() };
        } else {
            obj = false;
        }
        return obj;
    },
    /**
    * @description 多个倒计时
    * @param {Array} endTimeArr 时间戳
    * @param {Function} callback 每次间隔执行
    * @param {Number} speed 频率
    * @example var t=new Timer();
    t.countDownArr(1349411500000,function(arr){
    if(arr[0]){
    //{d: d, h: h, m: m, s: s, ms: ms, text: str}
    }else{

    clearInterval(t2.time)
    }
    },1000);
    * @memberOf Timer
    */
    currentTime: function (container, speed) {
        var self = this;
        speed = speed || 1000;
        self.time = window.setInterval(function () {
            var t = servertime;
            var y = t.getFullYear();
            var month = t.getMonth() + 1;
            var d = t.getDate();
            var h = t.getHours();
            var m = t.getMinutes();
            var s = t.getSeconds();
            if (month < 10) month = "0" + month;
            if (d < 10) d = "0" + d;
            if (h < 10) h = "0" + h;
            if (m < 10) m = "0" + m;
            if (s < 10) s = "0" + s;
            container.html(y + '年' + month + "月" + d + "日 " + h + ":" + m + ":" + s);
        }, speed);
    }
};

function timeFormatter(value) {
    return eval("new " + value.substr(1, value.length - 2));
}
function stringToDateTime(value) {
    return new Date(value.replace(/-/g, "/"));
}
function fix(value, v) {
    if (typeof v !== 'undefined') {
        return parseFloat(value).toFixed(v);
    }
    return parseFloat(value).toFixed(2);
}
var CP = {
    Util: {
        filterScript: function (str) {
            str = str || "";
            str = decodeURIComponent(str);
            str = str.replace(/<.*>/g, "");
            str = str.replace(/(java|vb|action)script/gi, "");
            str = str.replace(/[\"\'][\s ]*([^=\"\'\s ]+[\s ]*=[\s ]*[\"\']?[^\"\']+[\"\']?)+/gi, "");
            str = str.replace(/[\s ]/g, "&nbsp;");
            return str
        },
        getPara: function (name, url, num) {
            var para = typeof url == "undefined" ? window.location.search : url;
            para = para.split("?");
            if (!!num) {
                para = para[num] ? para[num] : para[para.length - 1]
            } else {
                para = typeof para[1] == "undefined" ? para[0] : para[1]
            }
            para = para.split("&");
            for (var i = 0; para[i]; i++) {
                para[i] = para[i].split("=");
                if (para[i][0] == name) {
                    try {
                        return this.filterScript(para[i][1])
                    } catch (e) { }
                }
            }
            return ""
        },
        getParaHash: function (name, url) {
            var para = typeof url == "undefined" ? window.location.href : url;
            para = para.split("?");
            para = typeof para[1] == "undefined" ? para[0] : para[1];
            para = para.split("&");
            for (var i = 0; para[i]; i++) {
                para[i] = para[i].split("=");
                if (para[i][0] == name) {
                    try {
                        return this.filterScript(para[i][1])
                    } catch (e) { }
                }
            }
            return ""
        }
    }
}
var alert1 = '<section id="dAlert" class="zfPop weige_" style="position: fixed;z-index: 1000">' + '<h4>提示</h4><p class="pdTop03 center"></p>' + '<a href="javascript:;" class="tureBtn">确定</a></section>';
var Mask1 = '<div id="Mask" style="position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; background: none repeat scroll 0% 0% gray; opacity: 0.5; z-index: 999;"></div>';
var load1 = '<div class="loadpop" id="rotate_load"><em class="rotate_load"></em></div><div class="zhezhao3"></div>';
var diglog1 = '<section id="dAlert" class="zfPop weige_" style="position: fixed;z-index: 1000">' + '<h4>提示</h4><p class="pdTop03 center"></p>' + '<a href="/" class="tureBtn">去首页</a></section>';
var Box = {
    load: function(close) {
        if (close) {
            $("#rotate_load,.zhezhao3").hide()
        } else {
            if ($("#rotate_load").html() != undefined) {
                $("#rotate_load,.zhezhao3").show()
            } else {
                $("body").append(load1)
            }
        }
    },
         alertNoMsg: function(msg, fn, tag) {
        if ($("#dAlert").html() != undefined) {
            $("#Mask").show();
            $("#dAlert").show();
        } else {
        
            $("body").append(alert1);
            if ($("#Mask").html() != undefined) {
                $("#Mask").show();
            } else {
                $("body").append(Mask1);
            }
        }
        if (tag != undefined) {
            $("#dAlert a.tureBtn").html(tag);
        } else {
            $("#dAlert a.tureBtn").html("");
        }
        $("#dAlert p.center").html(msg);
        $("#dAlert").css({
            left: "50%",
            top: "50%",
            marginLeft: "-9rem",
            marginTop: "-" + $("#dAlert").height() / 2 + "px"
        });
        $("#dAlert a.tureBtn").one("click",
            function() {
                if (typeof fn == "function") {
                    fn();
                }
                $("#dAlert").hide();
                $("#Mask").hide();
            });
    },
    alert: function(msg, fn, tag) {
        if ($("#dAlert").html() != undefined) {
            $("#Mask").show();
            $("#dAlert").show();
        } else {
        
            $("body").append(alert1);
            if ($("#Mask").html() != undefined) {
                $("#Mask").show();
            } else {
                $("body").append(Mask1);
            }
        }
        if (tag != undefined) {
            $("#dAlert a.tureBtn").html(tag);
        } else {
            $("#dAlert a.tureBtn").html("确定");
        }
        $("#dAlert p.center").html(msg);
        $("#dAlert").css({
            left: "50%",
            top: "50%",
            marginLeft: "-9rem",
            marginTop: "-" + $("#dAlert").height() / 2 + "px"
        });
        $("#dAlert a.tureBtn").one("click",
            function() {
                if (typeof fn == "function") {
                    fn();
                }
                $("#dAlert").hide();
                $("#Mask").hide();
            });
    },
    confirm: function(msg, fn) {
        $("#Mask").show();
        $("#dConfirm").show();
        $("#dConfirm div.center").html(msg);
        $("#dConfirm").css({
            left: parseInt(document.documentElement.clientWidth / 2 - $(".zfPop").width() / 2),
            top: parseInt(document.documentElement.clientHeight / 2 - $(".zfPop").height())
        });
        $("#dConfirm #zfqx").one("click", function() {
           // if (typeof fn2 == "function") {
              //  fn2();
          //  }
            $("#dConfirm").hide();
            $("#Mask").hide();
        });

        $("#dConfirm #zfqd").unbind("click").one("click", function() {
            //if (typeof fn == "function") {
                fn();
            //}
            $("#Mask").hide();
            $("#dConfirm").hide();
        });

    },
    msg: function(msg) {
        clearTimeout(window.alert.time);
        var obj = $('<div class="alertBox">' + msg + "</div>");
        $("body").append(obj);
        window.alert.time = setTimeout(function() {
            $(".alertBox").remove()
        },
        2e3)
    },
    tx: function(msg) {
        var tx_speed = "1500";
        var tx_ml = "-5rem";
        if (msg.length > 8) {
            $("#tx_c").css({
                width: "16rem"
            });
            tx_speed = "2500";
            tx_ml = "-8rem";
        }
        $("#tx_c").html("&nbsp;&nbsp;" + msg + "&nbsp;&nbsp;");
        $("#tx_c").show();
        $("#tx_c").css({
            left: "50%",
            marginLeft: tx_ml
        });
        setTimeout(function() {
                $("#tx_c").slideUp();
            },
            tx_speed);
    },
    diglog:function(msg, fn, tag){
      if ($("#dAlert").html() != undefined) {
            $("#Mask").show();
          $("#dAlert").show();
      } else {
            $("body").append(diglog1);
            if ($("#Mask").html() != undefined) {
                $("#Mask").show();
            } else {
                $("body").append(Mask1);
            }
        }
        $("#dAlert p.center").html(msg);
        $("#dAlert").css({
            left: "50%",
            top: "50%",
            marginLeft: "-9rem",
            marginTop: "-" + $("#dAlert").height() / 2 + "px"
        });
    }
};
var jc = {
    game: "",
    algorithm_: {
        al: function (A) {
            var B = 0,
            C = [],
            D = [],
            _;
            $(A, B);

            function $(A, B) {
                if (_ || B >= A.length) {
                    C.push(D.slice());
                    D.length = B - 1;
                } else {
                    var E = A[B];
                    for (var G = 0,
                    F = E.length; G < F; G++) {
                        D.push(E[G]);
                        $(A, B + 1);
                    }
                    if (B) D.length = B - 1;
                }
            }

            return C;
        },
        cl: function (_, A, C) {
            var $ = [];
            B([], _, A);
            return $;

            function B(_, D, E) {
                if (E === 0 || C && $.length == C) return $[$.length] = _;
                for (var G = 0,
                F = D.length - E; G <= F; G++)
                    if (!C || $.length < C) {
                        var A = _.slice();
                        A.push(D[G]);
                        B(A, D.slice(G + 1), E - 1);
                    }
            };
        },
        math: function (a, $, b, i) {
            var f = [], h = [], c = b - $.length, e = this;
            if (!$.length) {
                h = e.cl(a, c, i);
                for (var d in h) {
                    f = f.concat(e.al(h[d]));
                }
                return f;
            } else {
                var g = e.al($);
                if (c == 1) _([], a, i);
                else {
                    h = e.cl(a, c, i);
                    for (d in h) f = f.concat(e.al(h[d]));
                }
                return J(e.al([f, g]));
            }

            function _($, A, D) {
                for (var E = 0,
                B = A.length; E <= B; E++)
                    if (A[E] instanceof Array)
                        for (var C in A[E])
                            if (!D || f.length < D) {
                                var _ = $.slice();
                                _.push(A[E][C]);
                                f[f.length] = _;
                            }
            }

            function J(B) {
                var A = [],
                $,
                _ = [];
                for (var E = 0,
                C = B.length; E < C; E++)
                    if (B[E] instanceof Array) {
                        $ = B[E],
                    _ = $[0].slice();
                        for (var D = 1; D < $.length; D++) _ = _.concat($[D]);
                        A[E] = _
                    }
                return A;
            }
        },
        dl: function (A, $, B, I) {
            var F = [],
            H = [],
            C = B - $.length,
            E = this;
            if (!$.length) {
                H = E.cl(A, C, I);
                for (var D in H) {
                    if (typeof (H[D]) == "function") break;
                    F = F.concat(E.al(H[D]));
                }
                return F;
            } else {
                var G = E.al($);
                if (C == 1) _([], A, I);
                else {
                    H = E.cl(A, C, I);
                    for (D in H) {
                        if (typeof (H[D]) == "function") break;
                        F = F.concat(E.al(H[D]));
                    }
                }
                return J(E.al([F, G]));
            }

            function _($, A, D) {
                for (var E = 0,
                B = A.length; E <= B; E++)
                    if (A[E] instanceof Array)
                        for (var C in A[E]) {
                            if (typeof (A[E][C]) == "function") break;

                            if (!D || F.length < D) {
                                var _ = $.slice();
                                _.push(A[E][C]);
                                F[F.length] = _;
                            }
                        }
            }

            function J(B) {
                var A = [],
                $,
                _ = [];
                for (var E = 0,
                C = B.length; E < C; E++)
                    if (B[E] instanceof Array) {
                        $ = B[E],
                    _ = $[0].slice();
                        for (var D = 1; D < $.length; D++) _ = _.concat($[D]);
                        A[E] = _;
                    }
                return A;
            }
        },
        arrayEach: function (B, _, C) {
            if (C) {
                for (var D = 0,
                A, $ = B.length; D < $; D++) (A = _(B[D], D)) != undefined && C.push(A);
            } else for (D = B.length - 1; D >= 0; D--) (B[D] = _(B[D], D)) == undefined && B.splice(D, 1);
            return C || B;
        },
        each: function ($, A) {
            for (var _ = [], B = 0; B < $; B++) _[B] = A(B);
            return _;
        }
    },
    passType: {//过关以及场次关系
        '2*1': [2],
        '3*1': [3],
        '4*1': [4],
        '5*1': [5],
        '6*1': [6],
        '7*1': [7],
        '8*1': [8],
        '3*3': [2],
        '3*4': [2, 3],
        '4*4': [3],
        '4*5': [3, 4],
        '4*6': [2],
        '4*11': [2, 3, 4],
        '5*5': [4],
        '5*6': [4, 5],
        '5*10': [2],
        '5*16': [3, 4, 5],
        '5*20': [2, 3],
        '5*26': [2, 3, 4, 5],
        '6*6': [5],
        '6*7': [5, 6],
        '6*15': [2],
        '6*20': [3],
        '6*22': [4, 5, 6],
        '6*35': [2, 3],
        '6*42': [3, 4, 5, 6],
        '6*50': [2, 3, 4],
        '6*57': [2, 3, 4, 5, 6],
        '7*7': [6],
        '7*8': [6, 7],
        '7*21': [5],
        '7*35': [4],
        '7*120': [2, 3, 4, 5, 6, 7],
        '8*8': [7],
        '8*9': [7, 8],
        '8*28': [6],
        '8*56': [5],
        '8*70': [4],
        '8*247': [2, 3, 4, 5, 6, 7, 8]
    },
    jczq: {
        play: "",
        killRepeat: false,
        codeList: {},
        chuan: [],
        selfOpt: [],
        selfDan: [],
        checkSingleType: function (a) {//检查单一玩法
            return /^[\d\.]+\-(\w+)(?:,[\d\.]+\-\1)+$/.test(a.join(','));
        },
        getMoney: function () {
            var zhuShuVal = 0, minBonusVal = 0, maxBonusVal = 0, minBonusValArr = [];
            for (var i = 0, il = this.chuan.length; i < il; i++) {
                var guoGuan = this.chuan[i].replace('串', '_');
                if (this.chuan[i] == '单关') guoGuan = '1_1';
                var c = jc.getZhuShu(guoGuan);
                zhuShuVal += c;
                var bonus = jc.jczq.getBonus(guoGuan);
                if (c > 0) maxBonusVal += bonus[0];
                var minArr = bonus[1];
                for (var j = 0, jl = minArr.length; j < jl; j++) {
                    if (minArr[j] >= 0) {
                        if (!minBonusValArr[j]) minBonusValArr[j] = 0;
                        minBonusValArr[j] += minArr[j];
                    }
                }
            }
            for (i = 0, il = minBonusValArr.length; i < il; i++) {
                if (minBonusValArr[i]) {
                    minBonusVal = minBonusValArr[i];
                    break;
                }
            }
            return { zhu: zhuShuVal, maxBonus: maxBonusVal, minBonus: minBonusVal };
        },
        getBonus: function (ggType) {
            var prizes = [], danPrize = [], minSp = [], danMinSp = [];
            for (var l = 0, ll = this.codeList.length; l < ll; l++) {
                if (typeof (this.codeList[l]) == "function") break;
                var item = this.codeList[l];
                var maxVal = [], minVal = [], rq = item.polygoal;
                var maxRec = { isdan: item.isdan, rq: [], nrq: [], bf: [], bqq: [], jqs: [] };
                for (var i in item) {
                    if (i == "isdan" || i == "polygoal") continue;
                    if (item[i].prize.length > 0 && item[i].code.length > 0) {
                        var sp = $.grep(item[i].prize, function (n) {
                            return n > 0;
                        });
                        var nbcode = item[i]['code'], nbprize = item[i]['prize'], recrq = maxRec.nrq;
                        switch (i) {
                            case 'spf': recrq = maxRec.rq; break;
                            case 'bf': recrq = maxRec.bf; break;
                            case 'bqc': recrq = maxRec.bqq; break;
                            case 'zjq': recrq = maxRec.jqs;
                        }
                        for (var x in nbcode) {
                            if (typeof (nbcode[x]) == "function") break;
                            recrq.push({ sp: nbprize[x], val: nbcode[x] });
                        }
                        if (recrq.length > 1) {
                            maxRec[i] = recrq.sort(function (o1, o2) {
                                return o2.sp - o1.sp > 0 ? 1 : -1;
                            }).slice(0, 1);
                        }
                        minVal.push(Math.min.apply(Math, sp) + '-' + item[i].type);
                    }
                }
                var rqtype;
                if (this.play == "spf" || this.play == "hh") {
                    delete maxRec.brqspf;
                    delete maxRec.spf;
                    delete maxRec.zjq;
                    this.filterGooder(maxRec, rq - 0);
                    for (var j in maxRec) {
                        rqtype = 'spf';
                        switch (j) {
                            case 'nrq': rqtype = 'brqspf'; break;
                            case 'bf': rqtype = 'bf'; break;
                            case 'bqq': rqtype = 'bqc'; break;
                            case 'jqs': rqtype = 'zjq'; break;
                        }
                        maxRec[j][0] > 0 && maxVal.push(Math.max.apply([], maxRec[j]) + '-' + rqtype);
                    }
                } else {
                    rqtype = this.play;
                    if (this.play == "zjq") {
                        rqtype = "jqs";
                    } else if (this.play == "bqc") {
                        rqtype = "bqq";
                    } else if (this.play == "brqspf") {
                        rqtype = "nrq";
                    }
                    maxVal.push(maxRec[rqtype][0].sp + "-" + this.play);
                }
                if (item.isdan) {
                    danPrize.push(maxVal);
                    danMinSp.push(minVal);
                }
                else {
                    prizes.push(maxVal);
                    minSp.push(minVal);
                }
            }
            var maxPrize = jc.getZhuShu(ggType, [prizes, danPrize]);
            var minArr = jc.getMinBonus(ggType, minSp, danMinSp);
            return [parseFloat(maxPrize), minArr];
        },
        filterGooder: function (rec, r, isMin) {//每个玩法只留下一个选项
            var rq = rec.rq, nrq = rec.nrq, isUn = isMin ? -1 : 1;
            var frqspfSum = (rec.bf[0] && +rec.bf[0].sp || 0) + (rec.bqq[0] && +rec.bqq[0].sp || 0) + (rec.jqs[0] && +rec.jqs[0].sp || 0);
            function sortDn(a, b) { return isUn * (parseFloat(a.sp) > parseFloat(b.sp) ? -1 : 1); }
            if (rq.length === 0) { nrq.sort(sortDn).splice(1, 99); }
            else if (nrq.length === 0) {
                rq.sort(sortDn).splice(1, 99);
            } else {
                var goodArr = jc.algorithm_.al([nrq, rq]);
                var g = $.grep(goodArr, function (z) {
                    var a = z[0].val, b = z[1].val;
                    if (z[0].sp == '0' || z[1].sp == '0') { return false; }
                    if (a === 1) { return r > 0 ? b === 1 : (r !== -1 || b !== 4); }
                    else if (a === 4) { return r < 0 ? b === 4 : (r !== 1 || b !== 1); }
                    else if (a === 2) { return r > 0 ? b === 1 : b === 4; }
                });
                g.sort(function (a, b) { return isUn * (parseFloat(a[0].sp) + parseFloat(a[1].sp) > parseFloat(b[0].sp) + parseFloat(b[1].sp) ? -1 : 1); });
                if (g.length === 0) {//
                    nrq.sort(sortDn).splice(1, 99);
                    rq.sort(sortDn).splice(1, 99);
                    if (isMin) { if (nrq[0].sp < rq[0].sp) { rq.length = 0; } else { nrq.length = 0; } }
                    else { if (nrq[0].sp > rq[0].sp) { rq.length = 0; } else { nrq.length = 0; } }
                } else {
                    rq.length = 0;
                    nrq.length = 0;
                    nrq.push(g[0][0]);
                    rq.push(g[0][1]);
                }
            }
            rec.sp_sum = (nrq[0] ? parseFloat(nrq[0].sp) : 0) + (rq[0] ? parseFloat(rq[0].sp) : 0) + frqspfSum;
            var temp;
            for (var j in rec) {
                if (j == 'bf' || j == 'bqq' || j == 'jqs') {
                    if (rec[j][0] && rec[j][0].sp) {
                        temp = rec[j][0].sp;
                        rec[j].length = 0;
                        rec[j].push(temp);
                        // for (var i = rec[j].length; i--; ) { rec[j][i] = rq[i].sp; }
                    }
                    //rec[j][0] = rec[j][0] && rec[j][0].sp || 0;
                }
            }
            for (var i = rq.length; i--; ) { rq[i] = rq[i].sp; }
            for (i = nrq.length; i--; ) { nrq[i] = nrq[i].sp; }
        }
    },
    jclq: {
        play: "",
        killRepeat: false,
        codeList: {},
        chuan: [],
        selfOpt: [],
        selfDan: [],
        checkSingleType: function (a) {//检查单一玩法
            return /^[\d\.]+\-(\w+)(?:,[\d\.]+\-\1)+$/.test(a.join(','));
        },
        getMoney: function () {
            var zhuShuVal = 0, minBonusVal = 0, maxBonusVal = 0, minBonusValArr = [];
            for (var i = 0, il = this.chuan.length; i < il; i++) {
                var guoGuan = this.chuan[i].replace('串', '_');
                if (this.chuan[i] == '单关') guoGuan = '1_1';
                var c = jc.getZhuShu(guoGuan);
                zhuShuVal += c;
                var bonus = jc.jclq.getBonus(guoGuan);
                if (c > 0) maxBonusVal += bonus[0];
                var minArr = bonus[1];
                for (var j = 0, jl = minArr.length; j < jl; j++) {
                    if (minArr[j] >= 0) {
                        if (!minBonusValArr[j]) minBonusValArr[j] = 0;
                        minBonusValArr[j] += minArr[j];
                    }
                }
            }
            for (i = 0, il = minBonusValArr.length; i < il; i++) {
                if (minBonusValArr[i]) {
                    minBonusVal = minBonusValArr[i];
                    break;
                }
            }
            return { zhu: zhuShuVal, maxBonus: maxBonusVal, minBonus: minBonusVal };
        },
        getBonus: function (ggType) {
            var prizes = [], danPrize = [], minSp = [], danMinSp = [];
            for (var k in this.codeList) {
                if (typeof (this.codeList[k]) == "function") break;

                var maxVal = [], minVal = [], nb = this.codeList[k];
                for (var i in nb) {
                    if (i == "isdan" || i == "polygoal") continue;
                    if (nb[i].prize.length > 0 && nb[i].code.length > 0) {
                        var sp = $.grep(nb[i].prize, function (n) {
                            return n > 0;
                        });
                        maxVal.push(Math.max.apply(Math, sp) + '-' + nb[i].type); // 最大sp值
                        minVal.push(Math.min.apply(Math, sp) + '-' + nb[i].type); // 最小sp值
                    }
                }
                if (nb.isdan) {
                    danPrize.push(maxVal);
                    danMinSp.push(minVal);
                }
                else {
                    prizes.push(maxVal);
                    minSp.push(minVal);
                }
            }
            var maxPrize = jc.getZhuShu(ggType, [prizes, danPrize]); //把它转换成注数的计算模式
            var minArr = jc.getMinBonus(ggType, minSp, danMinSp); //最小奖金
            return [parseFloat(maxPrize), minArr];
        }
    },
    getZhuShu: function (ggWay, prize, min) {
        var game = jc.game;
        var count = 0, sels = jc[game].selfOpt, dan = jc[game].selfDan, n = parseInt(ggWay, 10), kill = jc[game].checkSingleType, isMix = jc[game].killRepeat, group, math = jc.algorithm_;
        //sels = [["3-fspf", "3-spf"], ["3-fspf", "3-spf"]];
        //dan = [];
        if (prize) group = math.dl(prize[0], prize[1], n); //计算奖金
        else group = math.dl(sels, dan, n);
        var singleGroup = group;
        if (isMix) singleGroup = $.grep(group, function (h) {//只收集不干掉的
            return !kill(h);
        });
        if (!min) {
            $.each(singleGroup, function (i, g) {
                var zs = jc.mixCal(ggWay, g); //([1,2,2], '3串4')
                count += zs;
            });
            return count;
        } else {
            var retPrizeArr = [];
            $.each(singleGroup, function (j, gh) {
                var zs = jc.mixCal(ggWay, gh); //([1,2,2], '3串4')
                retPrizeArr.push(zs);
            });
            return retPrizeArr;
        }
    },
    getMinBonus: function (ggType, sa, dan) {
        var rb = [], cn = this.calcuteMN(ggType);
        var d = cn - dan.length, minBonus = -1;
        var fa = function (a, b) {
            if (parseFloat(a[0]) > parseFloat(b[0])) return 1;
            else return -1;
        };
        sa.sort(fa);
        $.each(sa, function (j, n) {
            if (j >= d) n[0] = n[0].replace(/^[\d\.]+/i, '0');
        });
        var prizeArr = this.getZhuShu(ggType, [sa, dan], 1); //把它转换成注数的计算模式
        jc.algorithm_.arrayEach(prizeArr.sort(function (a, b) { return a > b ? 1 : -1; }), function (n) {
            if (n == 0) return;
            if (minBonus == -1) minBonus = n;
            else if (minBonus > n) minBonus = n;
        });
        rb[cn - 1] = minBonus == -1 ? 0 : minBonus;
        return rb;
    },
    mixCal: function (gg, arr) {
        arr.unshift(gg);
        return this.calcuteWC.apply(null, arr);
    },
    calcuteWC: function (passtype, a, b, c, d, e, f, g, h, i, j, k, l, m, n, o) {
        var re = 0;
        a = a == null ? 0 : parseFloat(a);
        b = b == null ? 0 : parseFloat(b);
        c = c == null ? 0 : parseFloat(c);
        d = d == null ? 0 : parseFloat(d);
        e = e == null ? 0 : parseFloat(e);
        f = f == null ? 0 : parseFloat(f);
        g = g == null ? 0 : parseFloat(g);
        h = h == null ? 0 : parseFloat(h);
        i = i == null ? 0 : parseFloat(i);
        j = j == null ? 0 : parseFloat(j);
        k = k == null ? 0 : parseFloat(k);
        l = l == null ? 0 : parseFloat(l);
        m = m == null ? 0 : parseFloat(m);
        n = n == null ? 0 : parseFloat(n);
        o = o == null ? 0 : parseFloat(o);
        switch (passtype) {
            case "1_1":
                re = a;
                break;
            case "2_1":
                re = a * b;
                break;
            case "2_3":
                re = (a + 1) * (b + 1) - 1;
                break;
            case "3_1":
                re = a * b * c;
                break;
            case "3_3":
                re = a * b + a * c + b * c;
                break;
            case "3_4":
                re = a * b * c + a * b + a * c + b * c;
                break;
            case "3_7":
                re = (a + 1) * (b + 1) * (c + 1) - 1;
                break;
            case "4_1":
                re = a * b * c * d;
                break;
            case "4_4":
                re = a * b * c + a * b * d + a * c * d + b * c * d;
                break;
            case "4_5":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) - (a * (b + c + d + 1) + b * (c + d + 1) + (c + 1) * (d + 1));
                break;
            case "4_6":
                re = a * b + a * c + a * d + b * c + b * d + c * d;
                break;
            case "4_11":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) - (a + b + c + d + 1);
                break;
            case "4_15":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) - 1;
                break;
            case "5_1":
                re = a * b * c * d * e;
                break;
            case "5_5":
                re = a * b * c * d + a * b * c * e + a * b * d * e + a * c * d * e + b * c * d * e;
                break;
            case "5_6":
                re = a * b * c * d * e + a * b * c * d + a * b * c * e + a * b * d * e + a * c * d * e + b * c * d * e;
                break;
            case "5_10":
                re = a * b + a * c + a * d + a * e + b * c + b * d + b * e + c * d + c * e + d * e;
                break;
            case "5_16":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) - (a * (b + c + d + e + 1) + b * (c + d + e + 1) + c * (d + e + 1) + (d + 1) * (e + 1));
                break;
            case "5_20":
                re = a * b * c + a * b * d + a * b * e + a * c * d + a * c * e + a * d * e + b * c * d + b * c * e + b * d * e + c * d * e + a * b + a * c + a * d + a * e + b * c + b * d + b * e + c * d + c * e + d * e;
                break;
            case "5_26":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) - (a + b + c + d + e + 1);
                break;
            case "5_31":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) - 1;
                break;
            case "6_1":
                re = a * b * c * d * e * f;
                break;
            case "6_6":
                re = a * b * c * d * e + a * b * c * d * f + a * b * c * e * f + a * b * d * e * f + a * c * d * e * f + b * c * d * e * f;
                break;
            case "6_7":
                re = a * b * c * d * e * f + a * b * c * d * e + a * b * c * d * f + a * b * c * e * f + a * b * d * e * f + a * c * d * e * f + b * c * d * e * f;
                break;
            case "6_15":
                re = a * b + a * c + a * d + a * e + a * f + b * c + b * d + b * e + b * f + c * d + c * e + c * f + d * e + d * f + e * f;
                break;
            case "6_20":
                re = a * b * c + a * b * d + a * b * e + a * b * f + a * c * d + a * c * e + a * c * f + a * d * e + a * d * f + a * e * f + b * c * d + b * c * e + b * c * f + b * d * e + b * d * f + b * e * f + c * d * e + c * d * f + c * e * f + d * e * f;
                break;
            case "6_22":
                re = a * b * c * d * e * f + a * b * c * d * e + a * b * c * d * f + a * b * c * e * f + a * b * d * e * f + a * c * d * e * f + b * c * d * e * f + a * b * c * d + a * b * c * e + a * b * c * f + a * b * d * e + a * b * d * f + a * b * e * f + a * c * d * e + a * c * d * f + a * c * e * f + a * d * e * f + b * c * d * e + b * c * d * f + b * c * e * f + b * d * e * f + c * d * e * f;
                break;
            case "6_35":
                re = a * b * c + a * b * d + a * b * e + a * b * f + a * c * d + a * c * e + a * c * f + a * d * e + a * d * f + a * e * f + b * c * d + b * c * e + b * c * f + b * d * e + b * d * f + b * e * f + c * d * e + c * d * f + c * e * f + d * e * f + a * b + a * c + a * d + a * e + a * f + b * c + b * d + b * e + b * f + c * d + c * e + c * f + d * e + d * f + e * f;
                break;
            case "6_42":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) - (a * (b + c + d + e + f + 1) + b * (c + d + e + f + 1) + c * (d + e + f + 1) + d * (e + f + 1) + (e + 1) * (f + 1));
                break;
            case "6_50":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) - (a + b + c + d + e + f + 1) - (a * b * c * d * e + a * b * c * d * f + a * b * c * e * f + a * b * d * e * f + a * c * d * e * f + b * c * d * e * f + a * b * c * d * e * f);
                break;
            case "6_57":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) - (a + b + c + d + e + f + 1);
                break;
            case "6_63":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) - 1;
                break;
            case "7_1":
                re = a * b * c * d * e * f * g;
                break;
            case "7_7":
                re = a * b * c * d * e * f + a * b * c * d * e * g + a * b * c * d * f * g + a * b * c * e * f * g + a * b * d * e * f * g + a * c * d * e * f * g + b * c * d * e * f * g;
                break;
            case "7_8":
                re = a * b * c * d * e * f * g + a * b * c * d * e * f + a * b * c * d * e * g + a * b * c * d * f * g + a * b * c * e * f * g + a * b * d * e * f * g + a * c * d * e * f * g + b * c * d * e * f * g;
                break;
            case "7_21":
                re = a * b * c * d * e + a * b * c * d * f + a * b * c * d * g + a * b * c * e * f + a * b * c * e * g + a * b * c * f * g + a * b * d * e * f + a * b * d * e * g + a * b * d * f * g + a * b * e * f * g + a * c * d * e * f + a * c * d * e * g + a * c * d * f * g + a * c * e * f * g + a * d * e * f * g + b * c * d * e * f + b * c * d * e * g + b * c * d * f * g + b * c * e * f * g + b * d * e * f * g + c * d * e * f * g;
                break;
            case "7_35":
                re = a * b * c * d + a * b * c * e + a * b * c * f + a * b * c * g + a * b * d * e + a * b * d * f + a * b * d * g + a * b * e * f + a * b * e * g + a * b * f * g + a * c * d * e + a * c * d * f + a * c * d * g + a * c * e * f + a * c * e * g + a * c * f * g + a * d * e * f + a * d * e * g + a * d * f * g + a * e * f * g + b * c * d * e + b * c * d * f + b * c * d * g + b * c * e * f + b * c * e * g + b * c * f * g + b * d * e * f + b * d * e * g + b * d * f * g + b * e * f * g + c * d * e * f + c * d * e * g + c * d * f * g + c * e * f * g + d * e * f * g;
                break;
            case "7_120":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) * (g + 1) - (a + b + c + d + e + f + g + 1);
                break;
            case "8_1":
                re = a * b * c * d * e * f * g * h;
                break;
            case "8_8":
                re = a * b * c * d * e * f * g + a * b * c * d * e * f * h + a * b * c * d * e * g * h + a * b * c * d * f * g * h + a * b * c * e * f * g * h + a * b * d * e * f * g * h + a * c * d * e * f * g * h + b * c * d * e * f * g * h;
                break;
            case "8_9":
                re = a * b * c * d * e * f * g * h + a * b * c * d * e * f * g + a * b * c * d * e * f * h + a * b * c * d * e * g * h + a * b * c * d * f * g * h + a * b * c * e * f * g * h + a * b * d * e * f * g * h + a * c * d * e * f * g * h + b * c * d * e * f * g * h;
                break;
            case "8_28":
                re = a * b * c * d * e * f + a * b * c * d * e * g + a * b * c * d * e * h + a * b * c * d * f * g + a * b * c * d * f * h + a * b * c * d * g * h + a * b * c * e * f * g + a * b * c * e * f * h + a * b * c * e * g * h + a * b * c * f * g * h + a * b * d * e * f * g + a * b * d * e * f * h + a * b * d * e * g * h + a * b * d * f * g * h + a * b * e * f * g * h + a * c * d * e * f * g + a * c * d * e * f * h + a * c * d * e * g * h + a * c * d * f * g * h + a * c * e * f * g * h + a * d * e * f * g * h + b * c * d * e * f * g + b * c * d * e * f * h + b * c * d * e * g * h + b * c * d * f * g * h + b * c * e * f * g * h + b * d * e * f * g * h + c * d * e * f * g * h;
                break;
            case "8_56":
                re = a * b * c * d * e + a * b * c * d * f + a * b * c * d * g + a * b * c * d * h + a * b * c * e * f + a * b * c * e * g + a * b * c * e * h + a * b * c * f * g + a * b * c * f * h + a * b * c * g * h + a * b * d * e * f + a * b * d * e * g + a * b * d * e * h + a * b * d * f * g + a * b * d * f * h + a * b * d * g * h + a * b * e * f * g + a * b * e * f * h + a * b * e * g * h + a * b * f * g * h + a * c * d * e * f + a * c * d * e * g + a * c * d * e * h + a * c * d * f * g + a * c * d * f * h + a * c * d * g * h + a * c * e * f * g + a * c * e * f * h + a * c * e * g * h + a * c * f * g * h + a * d * e * f * g + a * d * e * f * h + a * d * e * g * h + a * d * f * g * h + a * e * f * g * h + b * c * d * e * f + b * c * d * e * g + b * c * d * e * h + b * c * d * f * g + b * c * d * f * h + b * c * d * g * h + b * c * e * f * g + b * c * e * f * h + b * c * e * g * h + b * c * f * g * h + b * d * e * f * g + b * d * e * f * h + b * d * e * g * h + b * d * f * g * h + b * e * f * g * h + c * d * e * f * g + c * d * e * f * h + c * d * e * g * h + c * d * f * g * h + c * e * f * g * h + d * e * f * g * h;
                break;
            case "8_70":
                re = a * b * c * d + a * b * c * e + a * b * c * f + a * b * c * g + a * b * c * h + a * b * d * e + a * b * d * f + a * b * d * g + a * b * d * h + a * b * e * f + a * b * e * g + a * b * e * h + a * b * f * g + a * b * f * h + a * b * g * h + a * c * d * e + a * c * d * f + a * c * d * g + a * c * d * h + a * c * e * f + a * c * e * g + a * c * e * h + a * c * f * g + a * c * f * h + a * c * g * h + a * d * e * f + a * d * e * g + a * d * e * h + a * d * f * g + a * d * f * h + a * d * g * h + a * e * f * g + a * e * f * h + a * e * g * h + a * f * g * h + b * c * d * e + b * c * d * f + b * c * d * g + b * c * d * h + b * c * e * f + b * c * e * g + b * c * e * h + b * c * f * g + b * c * f * h + b * c * g * h + b * d * e * f + b * d * e * g + b * d * e * h + b * d * f * g + b * d * f * h + b * d * g * h + b * e * f * g + b * e * f * h + b * e * g * h + b * f * g * h + c * d * e * f + c * d * e * g + c * d * e * h + c * d * f * g + c * d * f * h + c * d * g * h + c * e * f * g + c * e * f * h + c * e * g * h + c * f * g * h + d * e * f * g + d * e * f * h + d * e * g * h + d * f * g * h + e * f * g * h;
                break;
            case "8_247":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) * (g + 1) * (h + 1) - (a + b + c + d + e + f + g + h + 1);
                break;
            case "9_1":
                re = a * b * c * d * e * f * g * h * i;
                break;
            case "10_1":
                re = a * b * c * d * e * f * g * h * i * j;
                break;
            case "11_1":
                re = a * b * c * d * e * f * g * h * i * j * k;
                break;
            case "12_1":
                re = a * b * c * d * e * f * g * h * i * j * k * l;
                break;
            case "13_1":
                re = a * b * c * d * e * f * g * h * i * j * k * l * m;
                break;
            case "14_1":
                re = a * b * c * d * e * f * g * h * i * j * k * l * m * n;
                break;
            case "15_1":
                re = a * b * c * d * e * f * g * h * i * j * k * l * m * n * o;
                break;
            default:
                break;
        }
        return re;
    },
    calcuteMN: function (passtype) {
        var re = 0;
        switch (passtype) {
            case "1_1":
            case "2_3":
            case "3_7":
            case "5_31":
            case "6_63":
                re = 1;
                break;
            case "2_1":
            case "3_3":
            case "3_4":
            case "4_6":
            case "4_11":
            case "4_15":
            case "5_10":
            case "5_20":
            case "5_26":
            case "6_15":
            case "6_35":
            case "6_50":
            case "6_57":
            case "7_120":
            case "8_247":
                re = 2;
                break;
            case "3_1":
            case "4_4":
            case "4_5":
            case "5_16":
            case "6_20":
            case "6_42":
                re = 3;
                break;
            case "4_1":
            case "5_5":
            case "5_6":
            case "6_22":
            case "7_35":
            case "8_70":
                re = 4;
                break;
            case "5_1":
            case "6_6":
            case "6_7":
            case "7_21":
            case "8_56":
                re = 5;
                break;
            case "6_1":
            case "7_7":
            case "7_8":
            case "8_28":
                re = 6;
                break;
            case "7_1":
            case "8_8":
            case "8_9":
                re = 7;
                break;
            case "8_1":
                re = 8;
                break;
            case "9_1":
                re = 9;
                break;
            case "10_1":
                re = 10;
                break;
            case "11_1":
                re = 11;
                break;
            case "12_1":
                re = 12;
                break;
            case "13_1":
                re = 13;
                break;
            case "14_1":
                re = 14;
                break;
            case "15_1":
                re = 15;
                break;
            default:
                break;
        }
        return re;
    }
};
var dc = {
    play: "",
    killRepeat: false,
    codeList: {},
    chuan: [],
    selfOpt: [],
    selfDan: [],
    checkSingleType: function (a) {//检查单一玩法
        return /^[\d\.]+\-(\w+)(?:,[\d\.]+\-\1)+$/.test(a.join(','));
    },
    passType: {
        '1*1': [1],
        '2*1': [2],
        '2*3': [1, 2],
        '3*1': [3],
        '3*4': [2, 3],
        '3*7': [1, 2, 3],
        '4*1': [4],
        '4*5': [3, 4],
        '4*11': [2, 3, 4],
        '4*15': [1, 2, 3, 4],
        '5*1': [5],
        '5*6': [4, 5],
        '5*16': [3, 4, 5],
        '5*26': [2, 3, 4, 5],
        '5*31': [1, 2, 3, 4, 5],
        '6*1': [6],
        '6*7': [5, 6],
        '6*22': [4, 5, 6],
        '6*42': [3, 4, 5, 6],
        '6*57': [2, 3, 4, 5, 6],
        '6*63': [1, 2, 3, 4, 5, 6],
        '7*1': [7],
        '8*1': [8],
        '9*1': [9],
        '10*1': [10],
        '11*1': [11],
        '12*1': [12],
        '13*1': [13],
        '14*1': [14],
        '15*1': [15]
    },
    getMoney: function () {
        var zhuShuVal = 0, minBonusVal = 0, maxBonusVal = 0, minBonusValArr = [];
        for (var i = 0, il = this.chuan.length; i < il; i++) {
            var guoGuan = this.chuan[i].replace('串', '_');
            if (this.chuan[i] == '单关') guoGuan = '1_1';
            var c = this.getZhuShu(guoGuan);
            zhuShuVal += c;
            var bonus = this.getBonus(guoGuan);
            if (c > 0) maxBonusVal += bonus[0];
            var minArr = bonus[1];
            for (var j = 0, jl = minArr.length; j < jl; j++) {
                if (minArr[j] >= 0) {
                    if (!minBonusValArr[j]) minBonusValArr[j] = 0;
                    minBonusValArr[j] += minArr[j];
                }
            }
        }
        for (i = 0, il = minBonusValArr.length; i < il; i++) {
            if (minBonusValArr[i]) {
                minBonusVal = minBonusValArr[i];
                break;
            }
        }
        return { zhu: zhuShuVal, maxBonus: maxBonusVal, minBonus: minBonusVal };
    },
    getBonus: function (ggType) {
        var prizes = [], danPrize = [], minSp = [], danMinSp = [];
        for (var k in this.codeList) {
            if (typeof (this.codeList[k]) == "function") break;

            var maxVal = [], minVal = [], nb = this.codeList[k];
            for (var i in nb) {
                if (i == "isdan" || i == "polygoal") continue;
                if (nb[i].prize.length > 0 && nb[i].code.length > 0) {
                    var sp = $.grep(nb[i].prize, function (n) {
                        return n > 0;
                    });
                    maxVal.push(Math.max.apply(Math, sp) + '-' + nb[i].type); // 最大sp值
                    minVal.push(Math.min.apply(Math, sp) + '-' + nb[i].type); // 最小sp值
                }
            }
            if (nb.isdan) {
                danPrize.push(maxVal);
                danMinSp.push(minVal);
            }
            else {
                prizes.push(maxVal);
                minSp.push(minVal);
            }
        }
        var maxPrize = this.getZhuShu(ggType, [prizes, danPrize]); //把它转换成注数的计算模式
        var minArr = this.getMinBonus(ggType, minSp, danMinSp); //最小奖金
        return [parseFloat(maxPrize), minArr];
    },
    getZhuShu: function (ggWay, prize, min) {
        var count = 0, sels = this.selfOpt, dan = this.selfDan, n = parseInt(ggWay, 10), kill = this.checkSingleType, isMix = this.killRepeat, group, math = jc.algorithm_;
        //sels = [["3-fspf", "3-spf"], ["3-fspf", "3-spf"]];
        //dan = [];
        if (prize) group = math.dl(prize[0], prize[1], n); //计算奖金
        else group = math.dl(sels, dan, n);
        var singleGroup = group;
        if (isMix) singleGroup = $.grep(group, function (h) {//只收集不干掉的
            return !kill(h);
        });
        if (!min) {
            $.each(singleGroup, function (i, g) {
                var zs = jc.mixCal(ggWay, g); //([1,2,2], '3串4')
                count += zs;
            });
            return count;
        } else {
            var retPrizeArr = [];
            $.each(singleGroup, function (j, gh) {
                var zs = jc.mixCal(ggWay, gh); //([1,2,2], '3串4')
                retPrizeArr.push(zs);
            });
            return retPrizeArr;
        }
    },
    getMinBonus: function (ggType, sa, dan) {
        var rb = [], cn = this.calcuteMN(ggType);
        var d = cn - dan.length, minBonus = -1;
        var fa = function (a, b) {
            if (parseFloat(a[0]) > parseFloat(b[0])) return 1;
            else return -1;
        };
        sa.sort(fa);
        $.each(sa, function (j, n) {
            if (j >= d) n[0] = n[0].replace(/^[\d\.]+/i, '0');
        });
        var prizeArr = this.getZhuShu(ggType, [sa, dan], 1); //把它转换成注数的计算模式
        jc.algorithm_.arrayEach(prizeArr.sort(function (a, b) { return a > b ? 1 : -1; }), function (n) {
            if (n == 0) return;
            if (minBonus == -1) minBonus = n;
            else if (minBonus > n) minBonus = n;
        });
        rb[cn - 1] = minBonus == -1 ? 0 : minBonus;
        return rb;
    },
    mixCal: function (gg, arr) {
        arr.unshift(gg);
        return this.calcuteWC.apply(null, arr);
    },
    calcuteWC: function (passtype, a, b, c, d, e, f, g, h, i, j, k, l, m, n, o) {
        var re = 0;
        a = a == null ? 0 : parseFloat(a);
        b = b == null ? 0 : parseFloat(b);
        c = c == null ? 0 : parseFloat(c);
        d = d == null ? 0 : parseFloat(d);
        e = e == null ? 0 : parseFloat(e);
        f = f == null ? 0 : parseFloat(f);
        g = g == null ? 0 : parseFloat(g);
        h = h == null ? 0 : parseFloat(h);
        i = i == null ? 0 : parseFloat(i);
        j = j == null ? 0 : parseFloat(j);
        k = k == null ? 0 : parseFloat(k);
        l = l == null ? 0 : parseFloat(l);
        m = m == null ? 0 : parseFloat(m);
        n = n == null ? 0 : parseFloat(n);
        o = o == null ? 0 : parseFloat(o);
        switch (passtype) {
            case "1_1":
                re = a;
                break;
            case "2_1":
                re = a * b;
                break;
            case "2_3":
                re = (a + 1) * (b + 1) - 1;
                break;
            case "3_1":
                re = a * b * c;
                break;
            case "3_3":
                re = a * b + a * c + b * c;
                break;
            case "3_4":
                re = a * b * c + a * b + a * c + b * c;
                break;
            case "3_7":
                re = (a + 1) * (b + 1) * (c + 1) - 1;
                break;
            case "4_1":
                re = a * b * c * d;
                break;
            case "4_4":
                re = a * b * c + a * b * d + a * c * d + b * c * d;
                break;
            case "4_5":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) - (a * (b + c + d + 1) + b * (c + d + 1) + (c + 1) * (d + 1));
                break;
            case "4_6":
                re = a * b + a * c + a * d + b * c + b * d + c * d;
                break;
            case "4_11":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) - (a + b + c + d + 1);
                break;
            case "4_15":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) - 1;
                break;
            case "5_1":
                re = a * b * c * d * e;
                break;
            case "5_5":
                re = a * b * c * d + a * b * c * e + a * b * d * e + a * c * d * e + b * c * d * e;
                break;
            case "5_6":
                re = a * b * c * d * e + a * b * c * d + a * b * c * e + a * b * d * e + a * c * d * e + b * c * d * e;
                break;
            case "5_10":
                re = a * b + a * c + a * d + a * e + b * c + b * d + b * e + c * d + c * e + d * e;
                break;
            case "5_16":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) - (a * (b + c + d + e + 1) + b * (c + d + e + 1) + c * (d + e + 1) + (d + 1) * (e + 1));
                break;
            case "5_20":
                re = a * b * c + a * b * d + a * b * e + a * c * d + a * c * e + a * d * e + b * c * d + b * c * e + b * d * e + c * d * e + a * b + a * c + a * d + a * e + b * c + b * d + b * e + c * d + c * e + d * e;
                break;
            case "5_26":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) - (a + b + c + d + e + 1);
                break;
            case "5_31":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) - 1;
                break;
            case "6_1":
                re = a * b * c * d * e * f;
                break;
            case "6_6":
                re = a * b * c * d * e + a * b * c * d * f + a * b * c * e * f + a * b * d * e * f + a * c * d * e * f + b * c * d * e * f;
                break;
            case "6_7":
                re = a * b * c * d * e * f + a * b * c * d * e + a * b * c * d * f + a * b * c * e * f + a * b * d * e * f + a * c * d * e * f + b * c * d * e * f;
                break;
            case "6_15":
                re = a * b + a * c + a * d + a * e + a * f + b * c + b * d + b * e + b * f + c * d + c * e + c * f + d * e + d * f + e * f;
                break;
            case "6_20":
                re = a * b * c + a * b * d + a * b * e + a * b * f + a * c * d + a * c * e + a * c * f + a * d * e + a * d * f + a * e * f + b * c * d + b * c * e + b * c * f + b * d * e + b * d * f + b * e * f + c * d * e + c * d * f + c * e * f + d * e * f;
                break;
            case "6_22":
                re = a * b * c * d * e * f + a * b * c * d * e + a * b * c * d * f + a * b * c * e * f + a * b * d * e * f + a * c * d * e * f + b * c * d * e * f + a * b * c * d + a * b * c * e + a * b * c * f + a * b * d * e + a * b * d * f + a * b * e * f + a * c * d * e + a * c * d * f + a * c * e * f + a * d * e * f + b * c * d * e + b * c * d * f + b * c * e * f + b * d * e * f + c * d * e * f;
                break;
            case "6_35":
                re = a * b * c + a * b * d + a * b * e + a * b * f + a * c * d + a * c * e + a * c * f + a * d * e + a * d * f + a * e * f + b * c * d + b * c * e + b * c * f + b * d * e + b * d * f + b * e * f + c * d * e + c * d * f + c * e * f + d * e * f + a * b + a * c + a * d + a * e + a * f + b * c + b * d + b * e + b * f + c * d + c * e + c * f + d * e + d * f + e * f;
                break;
            case "6_42":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) - (a * (b + c + d + e + f + 1) + b * (c + d + e + f + 1) + c * (d + e + f + 1) + d * (e + f + 1) + (e + 1) * (f + 1));
                break;
            case "6_50":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) - (a + b + c + d + e + f + 1) - (a * b * c * d * e + a * b * c * d * f + a * b * c * e * f + a * b * d * e * f + a * c * d * e * f + b * c * d * e * f + a * b * c * d * e * f);
                break;
            case "6_57":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) - (a + b + c + d + e + f + 1);
                break;
            case "6_63":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) - 1;
                break;
            case "7_1":
                re = a * b * c * d * e * f * g;
                break;
            case "7_7":
                re = a * b * c * d * e * f + a * b * c * d * e * g + a * b * c * d * f * g + a * b * c * e * f * g + a * b * d * e * f * g + a * c * d * e * f * g + b * c * d * e * f * g;
                break;
            case "7_8":
                re = a * b * c * d * e * f * g + a * b * c * d * e * f + a * b * c * d * e * g + a * b * c * d * f * g + a * b * c * e * f * g + a * b * d * e * f * g + a * c * d * e * f * g + b * c * d * e * f * g;
                break;
            case "7_21":
                re = a * b * c * d * e + a * b * c * d * f + a * b * c * d * g + a * b * c * e * f + a * b * c * e * g + a * b * c * f * g + a * b * d * e * f + a * b * d * e * g + a * b * d * f * g + a * b * e * f * g + a * c * d * e * f + a * c * d * e * g + a * c * d * f * g + a * c * e * f * g + a * d * e * f * g + b * c * d * e * f + b * c * d * e * g + b * c * d * f * g + b * c * e * f * g + b * d * e * f * g + c * d * e * f * g;
                break;
            case "7_35":
                re = a * b * c * d + a * b * c * e + a * b * c * f + a * b * c * g + a * b * d * e + a * b * d * f + a * b * d * g + a * b * e * f + a * b * e * g + a * b * f * g + a * c * d * e + a * c * d * f + a * c * d * g + a * c * e * f + a * c * e * g + a * c * f * g + a * d * e * f + a * d * e * g + a * d * f * g + a * e * f * g + b * c * d * e + b * c * d * f + b * c * d * g + b * c * e * f + b * c * e * g + b * c * f * g + b * d * e * f + b * d * e * g + b * d * f * g + b * e * f * g + c * d * e * f + c * d * e * g + c * d * f * g + c * e * f * g + d * e * f * g;
                break;
            case "7_120":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) * (g + 1) - (a + b + c + d + e + f + g + 1);
                break;
            case "8_1":
                re = a * b * c * d * e * f * g * h;
                break;
            case "8_8":
                re = a * b * c * d * e * f * g + a * b * c * d * e * f * h + a * b * c * d * e * g * h + a * b * c * d * f * g * h + a * b * c * e * f * g * h + a * b * d * e * f * g * h + a * c * d * e * f * g * h + b * c * d * e * f * g * h;
                break;
            case "8_9":
                re = a * b * c * d * e * f * g * h + a * b * c * d * e * f * g + a * b * c * d * e * f * h + a * b * c * d * e * g * h + a * b * c * d * f * g * h + a * b * c * e * f * g * h + a * b * d * e * f * g * h + a * c * d * e * f * g * h + b * c * d * e * f * g * h;
                break;
            case "8_28":
                re = a * b * c * d * e * f + a * b * c * d * e * g + a * b * c * d * e * h + a * b * c * d * f * g + a * b * c * d * f * h + a * b * c * d * g * h + a * b * c * e * f * g + a * b * c * e * f * h + a * b * c * e * g * h + a * b * c * f * g * h + a * b * d * e * f * g + a * b * d * e * f * h + a * b * d * e * g * h + a * b * d * f * g * h + a * b * e * f * g * h + a * c * d * e * f * g + a * c * d * e * f * h + a * c * d * e * g * h + a * c * d * f * g * h + a * c * e * f * g * h + a * d * e * f * g * h + b * c * d * e * f * g + b * c * d * e * f * h + b * c * d * e * g * h + b * c * d * f * g * h + b * c * e * f * g * h + b * d * e * f * g * h + c * d * e * f * g * h;
                break;
            case "8_56":
                re = a * b * c * d * e + a * b * c * d * f + a * b * c * d * g + a * b * c * d * h + a * b * c * e * f + a * b * c * e * g + a * b * c * e * h + a * b * c * f * g + a * b * c * f * h + a * b * c * g * h + a * b * d * e * f + a * b * d * e * g + a * b * d * e * h + a * b * d * f * g + a * b * d * f * h + a * b * d * g * h + a * b * e * f * g + a * b * e * f * h + a * b * e * g * h + a * b * f * g * h + a * c * d * e * f + a * c * d * e * g + a * c * d * e * h + a * c * d * f * g + a * c * d * f * h + a * c * d * g * h + a * c * e * f * g + a * c * e * f * h + a * c * e * g * h + a * c * f * g * h + a * d * e * f * g + a * d * e * f * h + a * d * e * g * h + a * d * f * g * h + a * e * f * g * h + b * c * d * e * f + b * c * d * e * g + b * c * d * e * h + b * c * d * f * g + b * c * d * f * h + b * c * d * g * h + b * c * e * f * g + b * c * e * f * h + b * c * e * g * h + b * c * f * g * h + b * d * e * f * g + b * d * e * f * h + b * d * e * g * h + b * d * f * g * h + b * e * f * g * h + c * d * e * f * g + c * d * e * f * h + c * d * e * g * h + c * d * f * g * h + c * e * f * g * h + d * e * f * g * h;
                break;
            case "8_70":
                re = a * b * c * d + a * b * c * e + a * b * c * f + a * b * c * g + a * b * c * h + a * b * d * e + a * b * d * f + a * b * d * g + a * b * d * h + a * b * e * f + a * b * e * g + a * b * e * h + a * b * f * g + a * b * f * h + a * b * g * h + a * c * d * e + a * c * d * f + a * c * d * g + a * c * d * h + a * c * e * f + a * c * e * g + a * c * e * h + a * c * f * g + a * c * f * h + a * c * g * h + a * d * e * f + a * d * e * g + a * d * e * h + a * d * f * g + a * d * f * h + a * d * g * h + a * e * f * g + a * e * f * h + a * e * g * h + a * f * g * h + b * c * d * e + b * c * d * f + b * c * d * g + b * c * d * h + b * c * e * f + b * c * e * g + b * c * e * h + b * c * f * g + b * c * f * h + b * c * g * h + b * d * e * f + b * d * e * g + b * d * e * h + b * d * f * g + b * d * f * h + b * d * g * h + b * e * f * g + b * e * f * h + b * e * g * h + b * f * g * h + c * d * e * f + c * d * e * g + c * d * e * h + c * d * f * g + c * d * f * h + c * d * g * h + c * e * f * g + c * e * f * h + c * e * g * h + c * f * g * h + d * e * f * g + d * e * f * h + d * e * g * h + d * f * g * h + e * f * g * h;
                break;
            case "8_247":
                re = (a + 1) * (b + 1) * (c + 1) * (d + 1) * (e + 1) * (f + 1) * (g + 1) * (h + 1) - (a + b + c + d + e + f + g + h + 1);
                break;
            case "9_1":
                re = a * b * c * d * e * f * g * h * i;
                break;
            case "10_1":
                re = a * b * c * d * e * f * g * h * i * j;
                break;
            case "11_1":
                re = a * b * c * d * e * f * g * h * i * j * k;
                break;
            case "12_1":
                re = a * b * c * d * e * f * g * h * i * j * k * l;
                break;
            case "13_1":
                re = a * b * c * d * e * f * g * h * i * j * k * l * m;
                break;
            case "14_1":
                re = a * b * c * d * e * f * g * h * i * j * k * l * m * n;
                break;
            case "15_1":
                re = a * b * c * d * e * f * g * h * i * j * k * l * m * n * o;
                break;
            default:
                break;
        }
        return re;
    },
    calcuteMN: function (passtype) {
        var re = 0;
        switch (passtype) {
            case "1_1":
            case "2_3":
            case "3_7":
            case "5_31":
            case "6_63":
                re = 1;
                break;
            case "2_1":
            case "3_3":
            case "3_4":
            case "4_6":
            case "4_11":
            case "4_15":
            case "5_10":
            case "5_20":
            case "5_26":
            case "6_15":
            case "6_35":
            case "6_50":
            case "6_57":
            case "7_120":
            case "8_247":
                re = 2;
                break;
            case "3_1":
            case "4_4":
            case "4_5":
            case "5_16":
            case "6_20":
            case "6_42":
                re = 3;
                break;
            case "4_1":
            case "5_5":
            case "5_6":
            case "6_22":
            case "7_35":
            case "8_70":
                re = 4;
                break;
            case "5_1":
            case "6_6":
            case "6_7":
            case "7_21":
            case "8_56":
                re = 5;
                break;
            case "6_1":
            case "7_7":
            case "7_8":
            case "8_28":
                re = 6;
                break;
            case "7_1":
            case "8_8":
            case "8_9":
                re = 7;
                break;
            case "8_1":
                re = 8;
                break;
            case "9_1":
                re = 9;
                break;
            case "10_1":
                re = 10;
                break;
            case "11_1":
                re = 11;
                break;
            case "12_1":
                re = 12;
                break;
            case "13_1":
                re = 13;
                break;
            case "14_1":
                re = 14;
                break;
            case "15_1":
                re = 15;
                break;
            default:
                break;
        }
        return re;
    }
};
var bet = {
    //机选
    Random: function (count) {
        var original = new Array;
        for (var i = 0; i < count; i++) {
            original[i] = i + 1
        }
        original.sort(function () {
            return .5 - Math.random()
        });
        var arrayList = new Array;
        for (var i = 0; i < count; i++) {
            arrayList[i] = original[i]
        }
        return arrayList
    },

}
function Set() {
    this.elements = new Array();
    this.size = function () {
        return this.elements.length;
    };
    this.showAll = function () {
        var result = "";
        for (var i = 0, il = this.elements.length; i < il; i++) {
            result += this.elements[i];
        }
        return result;
    };
    this.isEmpty = function () {
        return (this.elements.length < 1);
    };

    this.clear = function () {
        this.elements = new Array();
    };
    this.add = function (value) {
        if (!this.contain(value)) {
            this.elements.push(value);
            this.elements.sort();
        }
    };
    this.push = function (value) {
        if (!this.contain(value)) {
            this.elements.push(value);
        }
    };
    this.remove = function (value) {
        try {
            for (var i = 0, il = this.elements.length; i < il; i++) {
                if (this.elements[i] == value) {
                    this.elements.splice(i, 1);
                    return true;
                }
            }
        } catch (e) {
            return false;
        }
        return false;
    };
    this.contain = function (value) {
        for (var i = 0, il = this.elements.length; i < il; i++) {
            if (this.elements[i] == value) {
                return true;
            }
        }
        return false;
    };
}
function showCountDownTime(id, stoptime) {
    ClockNowTime = servertime;
    ClockDiff = new Date() - ClockNowTime;
    StopTime = new Date(stoptime);
    LeaveClock = document.getElementById(id);
    setInterval('funClock2()', 1000);
}
function funClock2() {
    var leave = StopTime - servertime + ClockDiff;
    var day = Math.floor(leave / (1000 * 60 * 60 * 24));
    var hour = Math.floor(leave / (1000 * 3600)) - (day * 24);
    var minute = Math.floor(leave / (1000 * 60)) - (day * 24 * 60) - (hour * 60);
    var second = Math.floor(leave / (1000)) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
    if (hour < 10) hour = "0" + hour;
    if (minute < 10) minute = "0" + minute;
    if (second < 10) second = "0" + second;

    if (leave > 0)  //还未截止
        LeaveClock.innerHTML = "还剩：" + day + "天 " + hour + ":" + minute + ":" + second + ""
    else  //已截止
        LeaveClock.innerHTML = " 已截止 "
}
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    var sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    var cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' +
		num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num + '.' + cents);
}
function transform(params) {
    var transform = $("#transForm");
    if (transform) transform.remove();

    var deparams = Base64.decode(params);
    if (deparams) {
        var paramsarray = deparams.split("|");
        var otherparams = paramsarray[1].split("&");
        var h = [], p;
        h[h.length] = "<form id=\"transForm\" name=\"transForm\" method=\"post\" action=\"" + paramsarray[0] + "\" target=\"_blank\">";
        for (var i = 0, il = otherparams.length; i < il; i++) {
            p = otherparams[i].split("~");
            h[h.length] = "<input type=\"hidden\" name=\"" + decodeURIComponent(p[0]) + "\" value=\"" + decodeURIComponent(p[1]) + "\"/>";
        }
        h[h.length] = "</form>";
        $("body").append(h.join(""));
        transform = $("#transForm");
        transform.submit();
        return false;
    }
    return false;
}
var Base64 = {

    // private property
    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

    // public method for encoding
    encode: function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;

        input = Base64._utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output +
	            this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
	            this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

        }

        return output;
    },

    // public method for decoding
    decode: function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {

            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }

        }

        output = Base64._utf8_decode(output);

        return output;

    },

    // private method for UTF-8 encoding
    _utf8_encode: function (string) {
        string = string.replace(/\r\n/g, "\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {

            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if ((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    },

    // private method for UTF-8 decoding
    _utf8_decode: function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;

        while (i < utftext.length) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if ((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i + 1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i + 1);
                c3 = utftext.charCodeAt(i + 2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }
        return string;
    }
};
function getAjax(url, state, datas, types, callbackName, Fun, async) {
    var obj, callbackFunName = '';
    state = state == 'post' ? 'post' : 'get';
    var data = (datas && typeof (datas) != "undefined") ? datas : '';
    var type = (types && typeof (types) != "undefined") ? types : 'xml';
    if (types == 'jsonp') callbackFunName = callbackName;
    async = async ? async : false;
    $.ajax({
        url: url,
        type: state,
        data: data,
        dataType: type,
        jsonpCallback: callbackFunName,
        async: async, //同步
        cache: false, //(默认: true) 设置为 false 将不缓存此页面。
        timeout: 10000,
        error: function (xml) {
            //if(msg == 'undefined')msg=xml;
            //alert(xml);
        },
        success: function (xml) {
            if (types == 'jsonp') {
                if (Fun instanceof Function) return Fun(xml);
            } else {
                obj = xml;
            }
        }
    });
    return obj;
}
$.extend(jQuery.easing, {
    def: "easeOutQuad",
    easeOutCubic: function (e, f, a, h, g) {
        return h * ((f = f / g - 1) * f * f + 1) + a;
    },
    easeOutBounce: function (e, f, a, h, g) {
        if ((f /= g) < (1 / 2.75)) {
            return h * (7.5625 * f * f) + a;
        } else {
            if (f < (2 / 2.75)) {
                return h * (7.5625 * (f -= (1.5 / 2.75)) * f + 0.75) + a;
            } else {
                if (f < (2.5 / 2.75)) {
                    return h * (7.5625 * (f -= (2.25 / 2.75)) * f + 0.9375) + a;
                } else {
                    return h * (7.5625 * (f -= (2.625 / 2.75)) * f + 0.984375) + a;
                }
            }
        }
    }
});
var start_ev = "ontouchstart" in window ? "touchstart": "mousedown";
var end_ev = "ontouchend" in window ? "touchend": "mouseup";
var move_ev = "ontouchend" in window ? "touchmove": "mousemove";
$.fn.Touch = function(a) {
    var b = move_ev;
    this.each(function() {
        var c = $(this).eq(0);
        var d = false;
        var e = 0;
        c.on(b,
        function() {
            d = true;
            clearTimeout(e);
            e = setTimeout(function() {
                d = false
            },
            250)
        });
        if (a.children) {
            c.on(end_ev, a.children,
            function(f) {
                if (d && end_ev == "touchend") {
                    d = false;
                    f.stopPropagation();
                    return false
                }
                a.fun.call(this, this)
            })
        } else {
            c.on(end_ev,
            function(f) {
                if (d && end_ev == "touchend") {
                    d = false;
                    f.stopPropagation();
                    return 0
                }
                a.apply(this, [this, f])
            })
        }
    })
};
function game(gameCode){
switch (gameCode) {
case "jczq":
return "jingcai";
break;
case"bjdc":
return "danchang";
break;
        
}
}
//获取url中的参数
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}
