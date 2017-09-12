var kd_ = "-" + $(window).width() + "px";
var minMacthCount = function () {
    switch (gameCode.toLowerCase()) {
        case "jczq":
        case "jclq":
            return 2;
        case "ctzq":
            switch (type.toLowerCase()) {
                case "t14c":
                    return 14;
                case "tr9":
                    return 9;
                case "t6bqc":
                    return 12;
                case "t4cjq":
                    return 8;
            }
            return 14;
        case "bjdc":
            return 1;
        default:
            return 2;
    }

};


var tz = {
    initial: function () {
        var html = localStorage.getItem(gameCode.toLowerCase() + type.toLowerCase() + "_SelectNum");
        if (html)
            $("#content").html(html);

        fun[gameCode.toLowerCase()].inittype();

    },
    getFhref: function () {
        switch (gameCode.toLowerCase()) {
            case "jczq":
                return "jingcai";
            case "jclq":
                return "jingcaibasket";
            case "bjdc":
                return "danchang";
            case "ctzq":
                return "toto";
            default: return "jingcai";

        }

    }

};
var ele = {
    multiple: $("#bs_"), //倍数
    items: $("#count_ cite:eq(0)"), //注数
    sum: $("#count_ cite:eq(1)"),
    selectTb: $("#content")
};
var fun = {
    jctz: {
        initgg: function () {
            fun.jctz.cleargg();
            fun.BindEvent();
        },
        cleargg: function () {
            switch (gameCode.toLowerCase()) {
                case "bjdc":
                    $("#selectPlay").attr("value", "单关");
                    $("#selectPlay").val("单关");
                    $("#selectPlay").attr("v", "1_1");
                    break;
                case "jczq":
                case "jclq":
                    $("#selectPlay").attr("value", "2串1");
                    $("#selectPlay").val("2串1");
                    $("#selectPlay").attr("v", "2_1");
                    break;
            }
            $("#chuan_ div.ww_").find(".cur").removeClass("cur");
            $("#chuan_ div.ww_ span").eq(0).addClass("cur");
        },
        getgg: function () {
            var ggmode = [];
            var gg = $("#selectPlay").attr("v");
            if (gg != "") {
                var s_ = gg.split(',');
                for (var i = 0; i < s_.length; i++) {
                    ggmode.push(s_[i]);
                }
            }
            return { ggmode_: ggmode };
        },
        getmatch: function () {
            //得到选中的比赛
            var m = 0, b = 0;
            var con = $("#content li[v=y]");

            con.each(function () {
                if ($(this).attr("c"))
                    m += 1;

                if ($(this).attr("b"))
                    b += 1;

                if (type.toLowerCase() == "hh") {
                    m += 1;
                }


            });
            //m = m.substr(0, m.length - 1);
            if (b != 0) {

                m = m + b;
            }

            return { match: m };
        },
        showmoney: function (result) {
            var count = 0, total = 0, radix = gameCode.toLowerCase() == "bjdc" ? 1.30 : 2;
            if (result.zhu > 9999) {
                Box.alert("投注注数不能大于9999");
                return false;
            } else {
                var bs = parseInt($("#bs_").val());
                count = result.zhu;
                total = count * 2 * bs;

                $("#count_").html('共<cite class="yellow">' + count + '</cite>注<cite class="yellow" id="CTZQ_Money">' + total + "</cite>元");
                if (gameCode.toLowerCase() == "ctzq") {
                    $("#selectPlay").remove();
                    $(".spfjj").remove();
                    $("#bs_").parent().attr("class", "left");
                } else {

                    var minMoney = isFinite(result.minBonus) ? result.minBonus * radix * bs : 0;
                    var maxMonwy = isFinite(result.maxBonus) ? result.maxBonus * radix * bs : 0;
                    $(".spfjj").show();
                    $(".spfjj em").html(fix(minMoney) + "~" + fix(maxMonwy));
                }

            }
        },
        Check: function () {
            var min = minMacthCount();
            var l = $("#content li[v=y]").length;
            if (l < min) {
                Box.tx("亲，至少选择" + min + "场比赛");
            }
        },
        href_: function (u) {
            var c = "",
                d = "",
                g = $("#selectPlay").attr("v");
            var dan = false, matchid, div, t, codes = [], code = [];
            if (type.toLowerCase() == "hh") {
                $("#content li[v=y] span.cur").each(function () {

                    var id = $(this).attr("id") == "rf" ? "rfsf" : $(this).attr("id") == "jqs" ? "zjq" : $(this).attr("id");
                    matchid = $(this).parent().parent().attr("t");
                    var jc = { jczq: { brqspf: [], spf: [], zjq: [], bf: [], bqc: [] }, jclq: { sf: [], rfsf: [], sfc: [], dxf: []} };
                    $(this).find("cite").each(function () {
                        var v = $(this).html();
                        jc[gameCode.toLowerCase()][id].push(v);
                    });
                    if (jc[gameCode.toLowerCase()][id].length > 0) {
                        codes.push(dan + "-" + matchid + "-" + jc[gameCode.toLowerCase()][id].join(",") + "-" + id);
                    }
                });
                c = codes.join("#");

                if (g != "" && g != null && c != "") {
                    g = g.split(",");
                    for (var n = 0; n < g.length; n++) {
                        d += g[n] + ",";
                    }
                    d = d.substr(0, d.length - 1);
                    c += "|" + d;
                }
            }
            else if (type.toLowerCase() == "tr9") {
                $("#content li").each(function () {
                    if ($(this).attr("v"))
                        c += $(this).attr("t") + "=" + $(this).attr("c").replace(/,/g, "/") + ",";
                    else
                        c += $(this).attr("t") + "=*,";

                });
                c = c.substr(0, c.length - 1);

            } else {
                $("#content li[v=y]").each(function () {

                    if ($(this).attr("b") && $(this).attr("c"))
                        c += $(this).attr("t") + "=" + $(this).attr("c").replace(/,/g, "/") + ";b:" + $(this).attr("b").replace(/,/g, "/") + ",";
                    else if (!$(this).attr("b"))
                        c += $(this).attr("t") + "=" + $(this).attr("c").replace(/,/g, "/") + ",";
                    else
                        c += $(this).attr("t") + "=b:" + $(this).attr("b").replace(/,/g, "/") + ",";
                });

                c = c.substr(0, c.length - 1);

                if (g != "" && g != null && c != "") {
                    g = g.split(",");
                    for (var n = 0; n < g.length; n++) {
                        d += g[n] + ",";
                    }
                    d = d.substr(0, d.length - 1);
                    c += "|" + d;
                }
            }
            // console.log(c);
            localStorage.setItem(gameCode.toLowerCase() + type.toLowerCase() + "_PollNum", c);
            location.href = u;
        },
        bindlocalStorage: function () {
            var c = $("#content").html();
            localStorage.setItem(gameCode.toLowerCase() + type.toLowerCase() + "_SelectNum", c);
        }
    },
    BindEvent: function () {
        $("#content div.spfzpk").find("span").bind("click", function () {

            //只有比分，混投，半全场 和 胜分差才有弹出框
            if (type.toLowerCase() == "bf") {
                $(this).parent().parent().next().css("marginTop", "-100px");
                $(this).parent().parent().next().show();
                $(".zhezhao").show();

            } else if (type.toLowerCase() == "hh") {

                var idx = $(this).attr("id");
                $(this).parent().parent().nextAll("div." + idx + "_:eq(0)").show();
                $(".zhezhao").show();
            }
            else if (type.toLowerCase() == "bqc") {
                var c = $(window).height();
                var d = $(this).parent().parent().next().height();
                var t = "-" + c / 2 + "px";
                if (c > d) {
                    t = "-" + d / 2 + "px";
                }
                $(this).parent().parent().next().css("marginTop", t);
                $(this).parent().parent().next().show();
                $(".zhezhao").show();

            } else if (type.toLowerCase() == "sfc") {
                $(".zhezhao").show();
                $(this).parent().parent().next().show();
            } else {
                var self = $(this);
                fun.publickfun.publick(self);
                fun[gameCode.toLowerCase()].showCount();
            }

        });
        //比分，半全场，混合弹出框取消按钮
        $(".bfPop").find("a:eq(0)").click(function () {
            $(this).parent().parent().find(".cur").removeClass("cur");
            $(".zhezhao").hide();
            $(this).parent().parent().hide();
            fun.publickfun[type.toLowerCase()]($(this).parent().parent());
            fun.jctz.cleargg();
            fun[gameCode.toLowerCase()].showCount();
        });
        $(".bfPop").find("a:eq(1)").click(function () {
            $(".zhezhao").hide();
            $(this).parent().parent().hide();
            fun.publickfun[type.toLowerCase()]($(this).parent().parent());
            //fun[gameCode.toLowerCase()].showCount();
        });
        $(".bfPop").find("div.competitions span").click(function () {
            $(this).toggleClass("cur");
            var cs = $(this).closest("div.bfPop").attr("class").replace("bfPop", "");

            if (gameCode.toLowerCase() == "jczq" && ((type.toLowerCase() == "hh" && (cs.indexOf("bqc") > -1 || cs.indexOf("bf") > -1)) || (type.toLowerCase() == "bf" && cs.indexOf("bf") > -1))) {
                fun.publickfun[type.toLowerCase()]($(this).parent().parent().parent());
            } else {

                fun.publickfun[type.toLowerCase()]($(this).parent().parent());
            }

            fun[gameCode.toLowerCase()].showCount();
        });

        $(".bfPop").find("div.competitions1 span").click(function () {
            $(this).toggleClass("cur");
            fun.publickfun[type.toLowerCase()]($(this).parent().parent());
            fun[gameCode.toLowerCase()].showCount();
        });

        $("#selectPlay").Touch(function () {
            var a = $("#content li[v=y]").length;
            var chuan = $("#chuan_ div.ww_ span").length;

            switch (gameCode.toLowerCase()) {
                case "bjdc":
                    if (!a) {
                        $("#chuan_ div.ww_ span").hide();
                        $("#chuan_ div.ww_ span").eq(0).show();
                    } else {

                        for (var n = 0; n < chuan; n++) {
                            if (n < a) {
                                $("#chuan_ div.ww_ span").eq(n).show();
                            } else {
                                $("#chuan_ div.ww_ span").eq(n).hide();
                                $("#chuan_ div.ww_ span").eq(n).removeClass("cur");
                            }
                        }
                    }
                    break;
                case "jclq":
                    if (!a) {
                        $("#chuan_ div.ww_ span").hide();
                        $("#chuan_ div.ww_ span").eq(0).show();
                    } else if (a < 2) {
                        $("#chuan_ div.ww_ span").hide();
                        $("#chuan_ div.ww_ span").eq(0).show();
                    } else {
                        var mm = 8;
                        var sfcCount = 0;
                        if (type.toLowerCase() == "hh") {
                            $("#content li[v=y] span.cur").each(function () {
                                var Id = $(this).attr("id");
                                if (Id.toLowerCase() == "sfc") {
                                    sfcCount++;
                                }
                            });
                            if (sfcCount > 0) {
                                mm = 4;
                            }
                        } else if (type.toLowerCase() == "sfc") {
                            mm = 4;
                        }
                        a = mm > a ? a : mm;
                        for (var n = 0; n <= chuan; n++) {
                            if (n < a - 1) {
                                $("#chuan_ div.ww_ span").eq(n).show();
                            } else {
                                $("#chuan_ div.ww_ span").eq(n).hide();
                                $("#chuan_ div.ww_ span").eq(n).removeClass("cur");
                            }
                        }
                    }
                    break;
                case "jczq":
                    if (!a) {
                        $("#chuan_ div.ww_ span").hide();
                        $("#chuan_ div.ww_ span").eq(0).show();
                    } else if (a < 2) {
                        $("#chuan_ div.ww_ span").hide();
                        $("#chuan_ div.ww_ span").eq(0).show();
                    } else {

                        var mm = 8;
                        var bfCount = 0;
                        var bqcCount = 0;
                        var zjqCount = 0;
                        if (type.toLowerCase() == "hh") {
                            $("#content li[v=y] span.cur").each(function () {

                                var Id = $(this).attr("id");
                                if (Id.toLowerCase() == "jqs") {
                                    zjqCount++;
                                }
                                if (Id.toLowerCase() == "bqc") {
                                    bqcCount++;
                                }
                                if (Id.toLowerCase() == "bf") {
                                    bfCount++;
                                }
                            });
                            if (bqcCount > 0 || bfCount > 0) {
                                mm = 4;
                            } else if (zjqCount > 0) {
                                mm = 6;
                            }
                        }
                        a = mm > a ? a : mm;
                        for (var n = 0; n <= chuan; n++) {
                            if (n < a - 1) {
                                $("#chuan_ div.ww_ span").eq(n).show();
                            } else {
                                $("#chuan_ div.ww_ span").eq(n).hide();
                                $("#chuan_ div.ww_ span").eq(n).removeClass("cur");
                            }
                        }
                    }
                    break;
            }

            $("#chuan_").show();
            $("#chuan_").css({
                marginTop: "-" + $("#chuan_").height() / 2 + "px"
            });
            $("#Mask_chuan").show();
            fun[gameCode.toLowerCase()].showCount();

        });
        $(".chuan_ div.ww_ span").click(function () {
            alert(123)
            if ($("#chuan_ div.ww_ span.cur").length == 1 && $(this).hasClass("cur")) return;
            $(this).toggleClass("cur");
            var v = "",
                v1 = "";
            $(this).parent().find(".cur").each(function () {
                v += $(this).attr("v") + ",";
                v1 += $(this).html() + ",";
            });
            $("#selectPlay").val(v1.substr(0, v1.length - 1));
            $("#selectPlay").attr("v", v.substr(0, v.length - 1));
            fun[gameCode.toLowerCase()].showCount();
        });
        $(".chuan_ a").click(function () {
            var v = "",
                v1 = "";
            $(this).parent().find(".cur").each(function () {
                v += $(this).attr("v") + ",";
                v1 += $(this).html() + ",";
            });
            $("#selectPlay").val(v1.substr(0, v1.length - 1));
            $("#selectPlay").attr("v", v.substr(0, v.length - 1));
            $("#chuan_").hide();
            $("#Mask_chuan").hide();
            fun[gameCode.toLowerCase()].showCount();
        });
        $("#clearTab").Touch(function () {
            if (type.toLowerCase() == "bqc" || type.toLowerCase() == "bf" || type.toLowerCase() == "sfc") {
                $("#content li[v=y]").removeAttr("v").removeAttr("c").removeAttr("b").find(".cur").removeClass("cur").html("立即投注");
                $("#content div.bfPop[a=c]").removeAttr("a").find("span.cur").removeClass("cur");
            }
            if (type.toLowerCase() == "hh") {
                $("#content li[v=y]").find("div.spfzpk span.cur").each(function () {
                    var id = $(this).attr("id");
                    var m = {
                        "sf": "胜负",
                        "rf": "让分胜负",
                        "dxf": "大小分",
                        "sfc": "胜负差",
                        "brqspf": "胜平负",
                        "spf": "让球胜平负",
                        "jqs": "总进球",
                        "bqc": "半全场",
                        "bf": "比分"
                    }[id] || "";
                    $(this).html(m);
                    $(this).parent().parent().nextAll("div." + id + "_:first").removeAttr("a").find("span.cur").removeClass("cur");
                });
                $("#content li[v=y]").find("div.spfzpk span.cur").removeClass("cur");

            }

            localStorage.removeItem(gameCode.toLowerCase() + type.toLowerCase() + "_PollNum");
            $("#content li[v=y]").removeAttr("v").removeAttr("c").removeAttr("b").find(".cur").removeClass("cur");
            fun.jctz.cleargg();

            fun.jctz.Check();
            fun.jctz.bindlocalStorage();
            fun[gameCode.toLowerCase()].showCount();
        });
        $(".error2").Touch(function () {
            $(this).parent().parent().animate({
                left: kd_
            },
                500,
                function () {

                    if (type.toLowerCase() == "bqc" || type.toLowerCase() == "bf" || type.toLowerCase() == "sfc")
                        $(this).next().remove();

                    $(this).remove();
                    fun.jctz.cleargg();
                    fun.jctz.Check();
                    fun.jctz.bindlocalStorage();
                    fun[gameCode.toLowerCase()].showCount();
                });
        });
        $("#tjss").Touch(function () {

            fun.jctz.href_("/buy/" + tz.getFhref() + "/" + type.toLowerCase());
        });

        $("#bs_").blur(function () {
            if ($(this).val() == "" || $(this).val() == "0") {
                $(this).val("1");
                fun[gameCode.toLowerCase()].showCount();
            }

        }).keyup(function () {
            this.value = this.value.replace(/\D/gi, '');
            if (parseInt($(this).val()) == 0 || $(this).val() == "") {
                $(this).val("");
                return;
            } else if ($(this).val().indexOf("0") == 0) {
                $(this).val("1");
            } else {
                if (parseInt($(this).val()) > 99999) {
                    Box.alert("最大可投倍数99999", function () {
                        $("#bs_").val("99999");
                        fun[gameCode.toLowerCase()].showCount();

                    });
                } else {
                    fun[gameCode.toLowerCase()].showCount();
                }
            }
        });
        $("#payment").click(function () {
            if ($(this).hasClass("true_disabled")) return;
            var m = fun.jctz.getmatch();
            var gamecode_ = gameCode;
            var len_ = m.match;

            var gg_ = "";
            if (!$("#selectPlay")) {
                gg_ = null;
            } else {
                gg_ = $("#selectPlay").attr("v");
            }
            if (len_ < minMacthCount()) {
                Box.alert("亲,最少选择" + minMacthCount() + "场比赛");
                return;
            } else if (gg_ == "") {
                Box.alert("请选择过关方式");
                return "";
            } else {
                var zs = $("#count_ cite:eq(0)").html();
                var z = $("#count_ cite:eq(1)").html();
                var bs = $("#bs_").val();
                var ctzq_money = $("#CTZQ_Money").text();
                var selectPlay = $("#selectPlay").val();
                if (gamecode_ == "CTZQ") {
                    //if (ctzq_money >= 8) {
                        if ($("#issues").length > 0) {
                            fun.jctz.href_("/pay/" + gameCode.toLowerCase() + "?gametype=" + type + "&notes=" + zs + "&multiple=" + bs + "&countMoney=" + z + "&issues=" + $("#issues").attr("value"));
                        } else {
                            fun.jctz.href_("/pay/" + gameCode.toLowerCase() + "?gametype=" + type + "&notes=" + zs + "&multiple=" + bs + "&countMoney=" + z);
                        }
                    /*}else {
                        Box.alert("投注金额不能小于8元.");
                        return false;
                    } */
                }
                else {
                        if ($("#issues").length > 0) {
                            fun.jctz.href_("/pay/" + gameCode.toLowerCase() + "?gametype=" + type + "&notes=" + zs + "&multiple=" + bs + "&countMoney=" + z + "&issues=" + $("#issues").attr("value"));
                        } else {
                            fun.jctz.href_("/pay/" + gameCode.toLowerCase() + "?gametype=" + type + "&notes=" + zs + "&multiple=" + bs + "&countMoney=" + z);
                        }
                }
            }
        });

            $("#fqhm").click(function () {
                if ($(this).hasClass("true_disabled"))return;
            var len_ = fun.jctz.getmatch();
            //$("#content").find("li[v=y]").length;
            var gg = "";
            if (!$("#selectPlay")) {
                gg = null;
            } else {
                gg = $("#selectPlay").attr("v");
            }
            if (len_.match < minMacthCount()) {
                Box.alert("亲，最少选择" + minMacthCount() + "场比赛");
            } else if (gg == "") {
                Box.alert("请选择过关方式");
            } else {
                var zs = $("#count_ cite:eq(0)").html();
                var z = $("#count_ cite:eq(1)").html();
                var bs = $("#bs_").val();
                var selectPlay = $("#selectPlay").val();
                if ($("#issues").length > 0) {
                    fun.jctz.href_("/buy/hm/" + gameCode.toLowerCase() + "?gametype=" + type + "&notes=" + zs + "&multiple=" + bs + "&countMoney=" + z + "&issues=" + $("#issues").attr("value"));

                } else {
                    fun.jctz.href_("/buy/hm/" + gameCode.toLowerCase() + "?gametype=" + type + "&notes=" + zs + "&multiple=" + bs + "&countMoney=" + z);
                }

            }
        });
        //奖金优化
        $('#optimization').click(function () {
          fun.jczq.optimize();
        });
    },
    publickfun: {
        publick: function (obj) {
            obj.toggleClass("cur");
            var l_ = obj.parent().parent().find(".cur").length;

            if (l_) {
                var c = "", b = "";
                if (type.toLowerCase() == "t6bqc" || type.toLowerCase() == "t4cjq") {
                    obj.parent().parent().find("div:eq(1) span.cur").each(function () {
                        c += $(this).attr("v") + ",";
                    });
                    obj.parent().parent().find("div:eq(2) span.cur").each(function () {
                        b += $(this).attr("v") + ",";
                    });
                    b = b.substring(0, b.length - 1);
                    if (b != "")
                        obj.parent().parent().attr("b", b);
                    else
                        obj.parent().parent().removeAttr("b");

                } else if (type.toLowerCase() == "zjq") {
                    obj.parent().parent().find("span.cur").each(function () {
                        c += $(this).attr("v") + ",";
                    });
                } else {

                    obj.parent().find("span.cur").each(function () {
                        c += $(this).attr("v") + ",";
                    });
                }
                c = c.substring(0, c.length - 1);
                if (c != "") obj.parent().parent().attr("c", c);
                else obj.parent().parent().removeAttr("c");

                obj.parent().parent().attr("v", "y");
                if (obj.parent().parent().find(".cur").length == 0 && l_ == 1) {
                    fun.jctz.cleargg();
                    fun.jctz.Check();
                }

            } else {
                obj.parent().parent().removeAttr("v");
                obj.parent().parent().removeAttr("c");

                if (obj.parent().parent().attr("b"))
                    obj.parent().parent().removeAttr("b");
                fun.jctz.cleargg();
                fun.jctz.Check();
            }
            fun.jctz.bindlocalStorage();
        },
        bqc: function (obj) {
            var l = obj.find("div.competitions  span.cur").length;
            var n = 5;
            if (l) {

                obj.prev().attr("v", "y");
                var c = "", h = "", k = "";
                if (l > n) {
                    h = "已选" + l + "项";
                }
                obj.find("div.competitions span.cur").each(function () {
                    //                    c += $(this).attr("value") + ",";
                    var s = $(this).find("strong").html();
                    var sp = $(this).find("em").html();
                    k = {
                        "胜胜": "33",
                        "胜平": "31",
                        "胜负": "30",
                        "平胜": "13",
                        "平平": "11",
                        "平负": "10",
                        "负胜": "03",
                        "负平": "01",
                        "负负": "00"
                    }[s.replace(":", "")] || s;
                    h += "<cite " + (l > n ? "style='display:none'" : "") + " sp='" + sp + "' v='" + k + "'>" + s.replace(":", "") + "</cite>";
                    c += k + ",";
                });
                c = c.substring(0, c.length - 1);
                obj.attr("a", "c");
                obj.prev().attr("c", c);
                obj.prev().find("div:eq(1) span").html(h);
                obj.prev().find("div:eq(1) span").addClass("cur");

                l == 1 && fun.jctz.Check();
            } else {
                obj.removeAttr("a");
                obj.prev().removeAttr("v");
                obj.prev().removeAttr("c");
                obj.prev().find("div:eq(1) span").html("立即投注");
                obj.prev().find("div:eq(1) span").removeClass("cur");
                fun.jctz.Check();
            }

            fun.jctz.bindlocalStorage();

        },
        bf: function (obj) {

            var l_ = obj.find("div.competitions span.cur").length;
            if (l_) {
                var n = 5, h = "", code = "", c = "";
                if (l_ > n) {
                    h = "已选" + l_ + "项";
                }
                obj.find("div.competitions span.cur").each(function () {
                    var s = $(this).find("strong").html();
                    var sp = $(this).find("em").html();
                    c = {
                        "胜其它": "X0",
                        "平其它": "XX",
                        "负其它": "0X"
                    }[s] || s;
                    code += c.replace(":", "") + ",";
                    h += "<cite " + (l_ > n ? "style='display:none'" : "") + "v='" + c.replace(":", "") + "' sp='" + sp + "' " + (s == "胜其它" || s == "负其它" || s == "平其它" ? 'class="sqt"' : "") + ">" + s + "</cite>";
                });
                obj.attr("a", "c");
                code = code.substring(0, code.length - 1);
                obj.prev().find("div:eq(1) span").html(h);
                obj.prev().find("div:eq(1) span").addClass("cur");
                obj.prev().attr("v", "y");
                obj.prev().attr("c", code);
                l_ == 1 && fun.jctz.Check();
            } else {
                obj.removeAttr("a");
                obj.prev().removeAttr("v");
                obj.prev().removeAttr("c");
                obj.prev().find("div:eq(1) span").html("立即投注");
                obj.prev().find("div:eq(1) span").removeClass("cur");

                fun.jctz.Check();
            }
            fun.jctz.bindlocalStorage();
        },
        hh: function (obj) {
            var l = obj.find("div.bfcom span.cur").length;
            var this_attr = obj.attr("class");
            var this_attr_hou = this_attr.substring(this_attr.indexOf(" "), this_attr.length - 1);
            var spanobj = obj.prevAll("li:first").find("div:eq(1) span#" + this_attr_hou.trim());
            var m = "";
            if (l) {

                obj.attr("a", "c");
                obj.find("div:eq(1) span.cur").each(function () {
                    var s = $(this).attr("v");
                    var sp = $(this).attr("sp");
                    m += "<cite sp=\" " + sp + "\" style='display:none'>" + s + "</cite> ";
                });
                obj.prevAll("li:first").attr("v", "y");
                spanobj.html("已选" + m);
                spanobj.addClass("cur");

            } else {
                obj.removeAttr("a");
                switch (gameCode.toLowerCase()) {
                    case "jczq":
                        var spf = obj.prevAll("li:first").nextAll("div.spf_").eq(0);
                        var brqspf = obj.prevAll("li:first").nextAll("div.brqspf_").eq(0);
                        var bf = obj.prevAll("li:first").nextAll("div.bf_").eq(0);
                        var jqs = obj.prevAll("li:first").nextAll("div.jqs_").eq(0);
                        var bqc = obj.prevAll("li:first").nextAll("div.bqc_").eq(0);
                        if (!spf.attr("a") && !brqspf.attr("a") && !bf.attr("a") && !jqs.attr("a") && !bqc.attr("a")) {
                            obj.prevAll("li:first").removeAttr("v");
                        }
                        break;
                    case "jclq":
                        var sf = obj.prevAll("li:first").nextAll("div.sf_").eq(0);
                        var sfc = obj.prevAll("li:first").nextAll("div.sfc_").eq(0);
                        var dxf = obj.prevAll("li:first").nextAll("div.dxf_").eq(0);
                        var rf = obj.prevAll("li:first").nextAll("div.rf_").eq(0);
                        if (!sf.attr("a") && !sfc.attr("a") && !dxf.attr("a") && !rf.attr("a")) {
                            obj.prevAll("li:first").removeAttr("v");
                        }
                        break;
                }
                m = {
                    "sf": "胜负",
                    "rf": "让分胜负",
                    "dxf": "大小分",
                    "sfc": "胜负差",
                    "brqspf": "胜平负",
                    "spf": "让球胜平负",
                    "jqs": "总进球",
                    "bqc": "半全场",
                    "bf": "比分"
                }[this_attr_hou.trim()] || m;

                spanobj.html(m);
                spanobj.removeClass("cur");
            }
            fun.jctz.bindlocalStorage();
        },
        sfc: function (obj) {
            var l = obj.find("span.cur").length;
            if (l) {
                obj.attr("a", "c");
                var m = "", k = "";
                if (l > 5) {
                    m += "已选" + l + "项";
                }
                obj.find("span.cur").each(function () {
                    var sp = $(this).attr("sp");
                    var v = $(this).attr("v");
                    var h = $(this).find("em:eq(0)").html();
                    k += v + ",";
                    m += "<cite " + (l > 5 ? "style='display:none'" : "") + " sp='" + sp + "' v='" + v + "'>" + h + v + "</cite>";
                });
                obj.prev().attr("v", "y");
                obj.prev().attr("c", k.substring(0, k.length - 1));
                obj.prev().find("div.spfzpk span").addClass("cur").html(m);

            } else {
                obj.removeAttr("a");
                obj.prev().removeAttr("v").removeAttr("c").find("span.cur").removeClass("cur").html("立即投注");
            }

        }
    },

    jclq: {
        inittype: function () {
            fun.jctz.initgg();
            fun.jclq.showCount();
        },
        showCount: function () {
            var m = fun.jctz.getmatch(), n = fun.jctz.getgg();
            if (n.ggmode_ == "" || m.match == 0) {
                $("#count_").html('共<cite class="yellow">0</cite>注<cite class="yellow">0</cite>元');
                $(".spfjj").hide();
            } else {
                var o = fun.jclq.getDTG();
                jc.game = gameCode.toLowerCase();
                jc.jclq.play = type.toLowerCase();
                jc.jclq.chuan = n.ggmode_;
                jc.jclq.selfOpt = o.details.tuo;
                jc.jclq.selfDan = o.details.dan;
                jc.jclq.codeList = o.maxRec;
                var result = jc.jclq.getMoney();
                fun.jctz.showmoney(result);
            }
        },
        getDTG: function () {
            //胆,拖,过关方式

            var play = type.toUpperCase(); //玩法
            var obj = {};
            obj.tuo = []; //拖
            obj.dan = []; //胆
            obj.ggmode = []; //过关方式
            obj.maxRec = [];
            obj.isShowhhgy = false; //不显示单一玩法
            var detail = [], //投注详情
                details = {}; //奖金明细
            details.dan = [], details.tuo = [];
            //过关方式
            $("#content li[v=y]").each(function () {

                var sfstr = 0, rfsfstr = 0, sfcstr = 0, dxfstr = 0;
                var sp, selectedtype, idx = $(this).attr("t");
                var sf = [], rfsf = [], sfc = [], dxf = [], tzselect = [], maxMin = [], bid;
                var maxRec = {
                    isdan: false,
                    polygoal: 0,
                    sf: { type: "sf", prize: [], code: [] },
                    rfsf: { type: "rfsf", prize: [], code: [] },
                    dxf: { type: "dxf", prize: [], code: [] },
                    sfc: { type: "sfc", prize: [], code: [] }
                };
                var cs = type.toLowerCase() == "hh" || type.toLowerCase() == "sfc" ? ".spfzpk span.cur cite" : ".spfzpk span.cur";
                $(this).find(cs).each(function () {

                    sp = $(this).attr("sp");
                    selectedtype = $(this).attr("v"); // 3、1、0
                    var p = type.toLowerCase() == "hh" ? $(this).parent().attr("id") : type.toLowerCase(); //玩法 spf,brqspf
                    p = "rf" ? "rfsf" : p;
                    if (p == "sf") {
                        sfstr++;
                        sf[sf.length] = "sf-" + selectedtype + '#' + sp;
                        var ab = selectedtype == 3 ? "主胜" : "客胜";
                        tzselect[tzselect.length] = ab + "(" + sp + ")"; //投注选项（SP值）
                        maxRec.sf.prize.push(sp);
                        maxRec.sf.code.push(selectedtype);
                    } else if (p == "rfsf") {
                        rfsfstr++;
                        rfsf[rfsf.length] = "rfsf-" + selectedtype + '%undefined#' + sp;
                        ab = selectedtype == 3 ? "让分主胜" : "让分客胜";
                        tzselect[tzselect.length] = ab + "(" + sp + ")"; //投注选项（SP值）
                        maxRec.rfsf.prize.push(sp);
                        maxRec.rfsf.code.push(selectedtype);
                    } else if (p == "dxf") {
                        dxfstr++;
                        dxf[dxf.length] = "dxf-" + selectedtype + '#' + sp;
                        tzselect[tzselect.length] = $(this).text() + "(" + sp + ")"; //投注选项（SP值）
                        maxRec.dxf.prize.push(sp);
                        maxRec.dxf.code.push(selectedtype);
                    } else if (p == "sfc") {
                        sfcstr++;
                        sfc[sfc.length] = "sfc-" + selectedtype + '#' + sp;
                        tzselect[tzselect.length] = $(this).text() + "(" + sp + ")"; //投注选项（SP值）
                        maxRec.sfc.prize.push(sp);
                        maxRec.sfc.code.push(selectedtype);
                    }
                    maxMin[maxMin.length] = sp;
                });
                var item = [];
                if (sfstr > 0) item.push("sf" + idx + "_" + sfstr);
                if (rfsfstr > 0) item.push("rfsf_" + idx + "_" + rfsfstr);
                if (sfcstr > 0) item.push("sfc_" + idx + "_" + sfcstr);
                if (dxfstr > 0) item.push("dxf_" + idx + "_" + dxfstr);
                var isDan = false;
                //            if (!jcpage.var_.isDg) {
                //                isDan = play == "SPF" || play == "X21" ? $(this).find("td:last input").attr("checked") : $(this).find("td:last input").attr("checked");
                //            }
                isDan ? obj.dan.push(item) : obj.tuo.push(item);

                var item2 = [];
                if (sf.length > 0) item2[item2.length] = sf.length + "-sf";
                if (rfsf.length > 0) item2[item2.length] = rfsf.length + "-rfsf";
                if (sfc.length > 0) item2[item2.length] = sfc.length + "-sfc";
                if (dxf.length > 0) item2[item2.length] = dxf.length + "-dxf";
                isDan ? details.dan.push(item2) : details.tuo.push(item2);
                maxRec.isdan = isDan;
                var tr = $("#" + idx);
                maxMin.sort(function compare(a, b) { return b - a; });
                obj.maxRec.push(maxRec);
            });
            obj.detail = detail;
            obj.details = details;

            return obj;
        }
    },
    jczq: {
        inittype: function () {
            fun.jctz.initgg();
            fun.jczq.showCount();
        },
        showCount: function () {
            //得到串关
            var m = fun.jctz.getmatch(), n = fun.jctz.getgg();
            if (n.ggmode_ == "" || m.match == "") {
                $("#count_").html('共<cite class="yellow">0</cite>注<cite class="yellow">0</cite>元');
                $(".spfjj").hide();
            } else {
                var o = fun.jczq.getDTG();
                jc.game = gameCode.toLowerCase();
                jc.jczq.play = type.toLowerCase();
                jc.jczq.chuan = n.ggmode_; //得到过关方式
                jc.jczq.selfOpt = o.details.tuo;
                jc.jczq.selfDan = o.details.dan;
                jc.jczq.codeList = o.maxRec;
                var result = jc.jczq.getMoney();
                fun.jctz.showmoney(result);
            }
        },
        getDTG: function() {
            //胆,拖,过关方式
            var play = type.toUpperCase(); //玩法
            var obj = {};
            obj.tuo = []; //拖
            obj.dan = []; //胆
            obj.ggmode = []; //过关方式
            obj.maxRec = [];
            obj.isShowhhgy = false; //不显示单一玩法
            var detail = [], //投注详情
                details = {}; //奖金明细
            details.dan = [], details.tuo = [];
            $("#content").find("li[v=y]").each(function() {

                var LetBall = $(this).find(".spfzpk span:eq(0) em i").attr("r");
                var brqspfstr = 0, spfstr = 0, zjqstr = 0, bqcstr = 0, bfstr = 0;
                var sp, seletetype, idx = $(this).attr("t");
                var brqspf = [], spf = [], zjq = [], bf = [], bqc = [], tzselect = [], maxMin = [], bid;
                var maxRec = {
                    isdan: false,
                    polygoal: 0,
                    brqspf: { type: "brqspf", prize: [], code: [] },
                    spf: { type: "spf", prize: [], code: [] },
                    bf: { type: "bf", prize: [], code: [] },
                    bqc: { type: "bqc", prize: [], code: [] },
                    zjq: { type: "zjq", prize: [], code: [] }
                };
                var oobjcte = type.toLowerCase() == "hh" || type.toLowerCase() == "bf" || type.toLowerCase() == "bqc" ? $(this).find(".spfzpk span.cur cite") : $(this).find(".spfzpk span.cur");
                oobjcte.each(function() {
                    var p = "";
                    if (type.toLowerCase() == "hh") {

                        var id = $(this).parent().attr("id");
                        p = id == "jqs" ? "zjq" : id;
                        sp = $(this).attr("sp");
                        seletetype = $(this).html();
                    } else if (type.toLowerCase() == "bf") {
                        p = type.toLowerCase();
                        sp = $(this).attr("sp");
                        seletetype = $(this).html().replace(":", "");
                        seletetype = {
                            "胜其它": "X0",
                            "平其它": "XX",
                            "负其它": "0X"

                        }[seletetype] || seletetype;
                    } else {
                        sp = $(this).attr("sp");
                        seletetype = $(this).attr("v"); // 3、1、0
                        p = type.toLowerCase() == "jqs" ? "zjq" : type.toLowerCase(); //玩法 spf,brqspf
                    }

                    if (p == "brqspf") {
                        brqspfstr++;
                        brqspf[brqspf.length] = "spf-" + seletetype + '#' + sp;
                        var ab = seletetype == 3 ? "胜" : seletetype == 1 ? "平" : "负";
                        tzselect[tzselect.length] = ab + "(" + sp + ")"; //投注选项（SP值）
                        maxRec.brqspf.prize.push(sp);
                        maxRec.brqspf.code.push(seletetype == 3 ? 1 : seletetype == 1 ? 2 : 4);
                    } else if (p == "spf") {
                        spfstr++;
                        spf[spf.length] = "rq-" + seletetype + '%' + LetBall + '#' + sp;
                        ab = seletetype == 3 ? "胜" : seletetype == 1 ? "平" : "负";
                        tzselect[tzselect.length] = "让" + ab + "(" + sp + ")"; //投注选项（SP值）
                        maxRec.spf.prize.push(sp);
                        maxRec.spf.code.push(seletetype == 3 ? 1 : seletetype == 1 ? 2 : 4);
                    } else if (p == "bf") {
                        bfstr++;
                        bf[bf.length] = "bf-" + seletetype + '#' + sp;
                        tzselect[tzselect.length] = $(this).text() + "(" + sp + ")"; //投注选项（SP值）
                        maxRec.bf.prize.push(sp);
                        maxRec.bf.code.push(seletetype);
                    } else if (p == "bqc") {
                        bqcstr++;
                        zjq[zjq.length] = "bqc-" + seletetype + '#' + sp;
                        tzselect[tzselect.length] = $(this).text() + "(" + sp + ")"; //投注选项（SP值）
                        maxRec.bqc.prize.push(sp);
                        maxRec.bqc.code.push(seletetype);
                    } else if (p == "zjq") {
                        zjqstr++;
                        zjq[zjq.length] = "zjq-" + seletetype + '#' + sp;
                        tzselect[tzselect.length] = $(this).text() + "(" + sp + ")"; //投注选项（SP值）
                        maxRec.zjq.prize.push(sp);
                        maxRec.zjq.code.push(seletetype);
                    }
                    maxMin[maxMin.length] = sp;
                });


                var item = [];
                if (brqspfstr > 0) item.push("spf_" + idx + "_" + brqspfstr);
                if (spfstr > 0) item.push("rq_" + idx + "_" + spfstr);
                if (zjqstr > 0) item.push("zjq_" + idx + "_" + zjqstr);
                if (bfstr > 0) item.push("cbf_" + idx + "_" + bfstr);
                if (bqcstr > 0) item.push("bqc_" + idx + "_" + bqcstr);
                var isDan = false;
                isDan ? obj.dan.push(item) : obj.tuo.push(item);

                var item2 = [];
                if (brqspf.length > 0) item2[item2.length] = brqspf.length + "-brqspf";
                if (spf.length > 0) item2[item2.length] = spf.length + "-spf";


                if (zjq.length > 0) item2[item2.length] = zjq.length + "-zjq";
                if (bf.length > 0) item2[item2.length] = bf.length + "-bf";
                if (bqc.length > 0) item2[item2.length] = bqc.length + "-bqc";
                isDan ? details.dan.push(item2) : details.tuo.push(item2);
                maxRec.isdan = isDan;
                maxMin.sort(function compare(a, b) { return b - a; });

                obj.maxRec.push(maxRec);
            });

            obj.detail = detail;
            obj.details = details;

            return obj;
        },
        optimize: function() { //奖金优化数据
            if (!this.valdateOptimize()) return;
            var content = [], cobj = $("input[id=selectPlay]").attr("v");
            ele.selectTb.find("li[v=y]").each(function (i, tr) {
                var $tr = $(tr), obj = { id: 0, dan: false }, abbr = $tr.attr("abbr"), matchid = $tr.attr("t");
                obj.id = matchid;
                var spt = abbr.split("|");
                    obj.week = spt[0]; //获得周四003
                    obj.host = spt[1]; //找到主队
                    obj.visit = spt[2]; //找到客队
                    obj.lose = spt[3]; //让球
                    obj.stoptime = spt[4]; //2012-07-25 17:45:00
                    var items = {}, v, stype,sp;
                    $tr.find("span.cur").each(function (j, a) {
                        stype = $(a).attr("id");
                        if (type.toLowerCase() == "hh") {
                            $(a).find("cite").each(function() {
                                sp = $(this).attr("sp");
                                v = $(this).html();
                                if (items[stype] == undefined) items[stype] = {};
                                items[stype][v] = sp;
                            });
                        } else {
                            v = $(a).attr("v");
                            sp = $(a).attr("sp");
                            if (items[stype] == undefined) items[stype] = {};
                            items[stype][v] = sp;
                        }
                    });
                var line = [];
                for (var k in items) {
                    var combine = k, options = [];
                    var selected = items[k];
                    for (var l in selected) {
                        options[options.length] = l + "-" + selected[l];
                    }
                    combine = combine + "^" + options.join(",");
                    line[line.length] = combine;
                }
                obj.items = line.join("|");
                content[content.length] = obj;
            });
            $('#op_multiple').val($("#bs_").val()); //倍数
            $('#op_pass').val(cobj); //串["P2_1","P3_1"]
            //$('#op_period').val(this.issue);
            var sum = parseInt($("#count_ cite:eq(1)").html(), 10),
                zs = parseInt($("#count_ cite:eq(0)").html(), 10);
            $('#op_units').val(zs); //注数
            $('#op_schemecost').val(sum); //金额
            //$('#op_playtype').val(this.lotKey);
            $('#op_items').val(JSONstringify(content));
            $('#optimize').submit();
        },
        valdateOptimize: function() {
            var betNum = ele.selectTb.find("li[v=y]").length;
            var chuan = $("input[id=selectPlay]").attr("v"),
                sum = parseInt($("#count_ cite:eq(1)").html(), 10),
                items = parseInt($("#count_ cite:eq(0)").html(), 10);

            if (betNum < 1 ) {
                Box.alert('请选择您要优化的比赛。');
            } else if (chuan.length==0) {
                 Box.alert('请选择好您要优化的过关方式。');
             } else if (sum <= 0) {
                 Box.alert('您好，优化的总金额不能为0元。');
             } else if (items > 100) {
                 Box.alert('您好，单倍优化的总注数不能超过100注。');
            } else {
                return true;
            }
            return false;
        }
    },
    bjdc: {
        inittype: function () {
            fun.jctz.initgg();
            fun.bjdc.showCount();
        },
        showCount: function () {
            //得到串关
            var m = fun.jctz.getmatch(), n = fun.jctz.getgg();
            if (n.ggmode_ == "" || m.match == "") {
                $("#count_").html('共<cite class="yellow">0</cite>注<cite class="yellow">0</cite>元');
                $(".spfjj").hide();
            } else {
                var o = fun.bjdc.getDTG();
                dc.play = type.toLowerCase();
                dc.chuan = n.ggmode_;
                dc.selfOpt = o.details.tuo;
                dc.selfDan = o.details.dan;
                dc.codeList = o.maxRec;
                var result = dc.getMoney();
                fun.jctz.showmoney(result);
            }

        },
        getDTG: function () {//胆,拖,过关方式
            var play = type.toLowerCase(); //玩法
            var obj = {};
            obj.tuo = []; //拖
            obj.dan = []; //胆
            obj.ggmode = []; //过关方式
            obj.maxRec = [];
            obj.isShowhhgy = false; //不显示单一玩法
            var detail = [], //投注详情
					details = {}; //奖金明细
            details.dan = [], details.tuo = [];

            $("#content").find("li[v=y]").each(function () {
                var spfstr = 0, zjqstr = 0, sxdsstr = 0, bfstr = 0, bqcstr = 0;
                var sp, selectedtype, idx = $(this).attr("t");
                var spf = [], zjq = [], sxds = [], bf = [], bqc = [], tzselect = [], maxMin = [], bid;
                var maxRec = { isdan: false, polygoal: 0,
                    spf: { type: "spf", prize: [], code: [] },
                    zjq: { type: "zjq", prize: [], code: [] },
                    sxds: { type: "sxds", prize: [], code: [] },
                    bf: { type: "bf", prize: [], code: [] },
                    bqc: { type: "bqc", prize: [], code: [] }
                };
                var css = type.toLowerCase() == "bf" || type.toLowerCase() == "bqc" ? "span.cur cite" : "span.cur";
                $(this).find(css).each(function () {
                    // var info = bid.split("_");

                    sp = $(this).attr("sp");
                    selectedtype = $(this).attr("v"); // 3、1、0
                    var p = type.toLowerCase(); //玩法 rfsf,sf
                    if (p == "spf") {
                        spfstr++;
                        spf[spf.length] = "spf-" + selectedtype + '#' + sp;
                        maxRec.spf.prize.push(sp);
                        maxRec.spf.code.push(selectedtype);
                    } else if (p == "zjq") {
                        zjqstr++;
                        zjq[zjq.length] = "zjq-" + selectedtype + '#' + sp;
                        maxRec.zjq.prize.push(sp);
                        maxRec.zjq.code.push(selectedtype);
                    } else if (p == "sxds") {
                        sxdsstr++;
                        sxds[sxds.length] = "sxds-" + selectedtype + '#' + sp;
                        maxRec.sxds.prize.push(sp);
                        maxRec.sxds.code.push(selectedtype);
                    } else if (p == "bf") {
                        bfstr++;
                        bf[bf.length] = "bf-" + selectedtype + '#' + sp;
                        maxRec.bf.prize.push(sp);
                        maxRec.bf.code.push(selectedtype);
                    } else if (p == "bqc") {
                        bqcstr++;
                        bqc[bqc.length] = "bqc-" + selectedtype + '#' + sp;
                        maxRec.bqc.prize.push(sp);
                        maxRec.bqc.code.push(selectedtype);
                    }
                    tzselect[tzselect.length] = $(this).text() + "(" + sp + ")"; //投注选项（SP值）
                    maxMin[maxMin.length] = sp;
                });
                var item = [];
                if (spfstr > 0) item.push("spf" + idx + "_" + spfstr);
                if (zjqstr > 0) item.push("zjq" + idx + "_" + zjqstr);
                if (sxdsstr > 0) item.push("sxds_" + idx + "_" + sxdsstr);
                if (bfstr > 0) item.push("bf_" + idx + "_" + bfstr);
                if (bqcstr > 0) item.push("bqc_" + idx + "_" + bqcstr);
                var isDan = false;
                isDan ? obj.dan.push(item) : obj.tuo.push(item);

                var item2 = [];
                if (spf.length > 0) item2[item2.length] = spf.length + "-spf";
                if (zjq.length > 0) item2[item2.length] = zjq.length + "-zjq";
                if (sxds.length > 0) item2[item2.length] = sxds.length + "-sxds";
                if (bf.length > 0) item2[item2.length] = bf.length + "-bf";
                if (bqc.length > 0) item2[item2.length] = bqc.length + "-bqc";
                isDan ? details.dan.push(item2) : details.tuo.push(item2);
                maxRec.isdan = isDan;
                maxMin.sort(function compare(a, b) { return b - a; });
                obj.maxRec.push(maxRec);
            });
            obj.detail = detail;
            obj.details = details;

            return obj;
        }
    },
    ctzq: {
        inittype: function () {
            fun.jctz.initgg();
            fun.ctzq.showCount();
        },
        showCount: function () {

            var m = fun.jctz.getmatch();
            $("#selectPlay").remove();
            $(".spfjj").remove();
            $("#bs_").parent().attr("class", "left");
            if (m.match == 0 || m.match < minMacthCount()) {
                $("#count_").html('共<cite class="yellow">0</cite>注<cite class="yellow">0</cite>元');
                $(".spfjj").hide();
            } else {
                var result = "";
                if (type.toLowerCase() == "tr9")
                    result = fun.ctzq.calToto9();
                else
                    result = fun.ctzq.calToto();
                fun.jctz.showmoney(result);
            }

        },
        calToto: function () {
            var betUnits = 1; //注数
            var lotstr = $("#content li div.spfzpk ");
            var j;
            lotstr.each(function (index, item) {
                j = $(item).find("span.cur").length;
                betUnits = betUnits * j;
            });
            return { zhu: betUnits };
        },
        calToto9: function () {
            var matchCount = $("#content li[v=y]").length;
            sumzhu = 0;
            if (matchCount >= 9) {
                fun.ctzq.getCount();

            }
            return { zhu: sumzhu };
        },
        getCount: function () {
            var j = 0x0;
            var betItems = new Array();
            $("#content li").each(function (index, item) {
                j = 0x0;

                if ($(item).find("div:eq(0) span:eq(0)").attr("class") == "cur") {
                    j += 0x1;
                }
                if ($(item).find("div:eq(0) span:eq(1)").attr("class").indexOf("cur") > -1) {
                    j += 0x1 << 1;
                }
                if ($(item).find("div:eq(0) span:eq(2)").attr("class") == "cur") {
                    j += 0x1 << 2;
                }
                betItems[index] = j;
            });
            var save = new Array();
            save.push(betItems);
            for (var i = 0; i < save.length; i++) {
                fun.ctzq.combine(save[i]);
            }
        },
        combine: function (content) {
            var c = 0;
            for (i = 0; i < content.length; i++) {
                if (content[i] == 0) c++;
            }
            if (5 - c != 0) {
                fun.ctzq.comvertPoly(content, 0, 5 - c);
            } else {
                fun.ctzq.polyCount(content);
            }
        },
        comvertPoly: function (betItems, start, count) {
            if (count == 0) {
                return;
            }
            var tempindex = -1;
            var tempvalue = 0;
            for (var i = start; i < betItems.length; i++) {
                if (betItems[i] == 0 || (betItems[i] & (0x1 << 3)) != 0) {
                    continue;
                }
                if (tempindex != -1) {
                    betItems[tempindex] = tempvalue;
                }
                tempvalue = betItems[i];
                tempindex = i;
                betItems[i] = 0;
                if (count == 1) {
                    fun.ctzq.polyCount(betItems);
                } else {
                    var newBetItems = fun.ctzq.cloneArray(betItems);
                    fun.ctzq.comvertPoly(newBetItems, i + 1, count - 1);
                }
            }

        },
        cloneArray: function (arr) {
            var newArray = new Array();
            var i = 0;
            for (i = 0; i < arr.length; i++) {
                newArray[i] = arr[i];
            }
            return newArray;
        },
        polyCount: function (polyBet) {
            var mult = 1;
            for (var j = 0; j < polyBet.length; j++) {
                var size = 0;
                if ((polyBet[j] & 0x1 << 0) != 0) {
                    size++;
                }
                if ((polyBet[j] & 0x1 << 1) != 0) {
                    size++;
                }
                if ((polyBet[j] & 0x1 << 2) != 0) {
                    size++;
                }
                if (size == 0) {
                    size++;
                }
                mult *= size;
            }
            sumzhu += mult;

        }
    }
};
// JSON转换为字符串
function JSONstringify(json) {
//    $.browser.mozilla =
///firefox/.test(navigator.userAgent.toLowerCase()); $.browser.webkit =
///webkit/.test(navigator.userAgent.toLowerCase()); $.browser.opera =
///opera/.test(navigator.userAgent.toLowerCase()); $.browser.msie =
///msie/.test(navigator.userAgent.toLowerCase());
    if (/msie/.test(navigator.userAgent.toLowerCase())) {
        if (jQuery.browser.version == "7.0" || jQuery.browser.version == "6.0") {
            var result = jQuery.parseJSON(json);
        } else {
            result = JSON.stringify(json);
        }
    } else {
        result = JSON.stringify(json);
        }
    return result;
}
$(function () {
    tz.initial();
});