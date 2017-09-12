var c_ = '<div id="c" style="position: absolute; z-index: 99999; top: 454px;  background: none repeat scroll 0% 0% rgb(240, 61, 61); opacity: 0.15; width:2rem; line-height:2rem; border-radius:2rem; -webkit-border-radius:2rem; -moz-border-radius:2rem"></div>';
var speed_ = "200";
var f_Wobble = "0";
var curTime_ = (new Date).getTime();


var fun = {
    publick: {
        topNavInit: function () {
            setTimeout(function () {
                var k = $("#secNav ul");
                var f = 0;
                $("#secNav li").each(function () {
                    f += $(this).width() + parseInt($(this).css("margin-left").replace("px", "")) * 2 + 2;
                });
                k.width(f);
                navScroll = new iScroll("secNav", {
                    snap: "li",
                    hScrollbar: false,
                    hScroll: true,
                    vScroll: false
                });
            },
                100);
        }
    },
    ssq: {
        bindBallClick: function () {
            //绑定历史开奖点击事件
            $("#lskj").bind("click", function () {
                $(this).find("em").toggleClass("ssqdown");
                $("." + gameCode.toLowerCase() + "kjlist").slideToggle(200);
            });
            $("#pullIco").click(function () {
                $(this).parent().toggleClass("pullHover");
                $("#pullText").toggle();
            });
            //双色球，大乐透
            //选中红球
            $("#xzhq .ssqBall>cite").Touch(function () {
                if ($(this).attr("class")) {
                    $(this).removeAttr("class");
                } else {
                    if (ballBox.cur.max > 0 && $("#xzhq .ssqBall cite.redBall").length >= ballBox.cur.max) {
                        Box.alert("最多只能选择" + ballBox.cur.max + "个红球");
                        return;
                    }
                    $(this).toggleClass("redBall");
                }
                var rebball = ballBox.selectRedBallValue();
                $("#RedBallValue").attr("value", rebball.replace(/,$/, ''));
                ballBox.calNumber();

            });
            //选中蓝球
            $("#xzlq .ssqBall>cite").Touch(function () {

                if ($(this).attr("class")) {
                    $(this).removeAttr("class");
                } else {
                    if (ballBox.cur.bluemax > 0 && $("#xzlq .ssqBall cite.blueBall").length >= ballBox.cur.bluemax) {
                        Box.alert("蓝球最大选球个数不能超过" + ballBox.cur.bluemax + "个");
                        return;
                    }
                    $(this).toggleClass("blueBall");
                }
                var blueball = ballBox.selectBlueBallValue();
                $("#BlueBallValue").attr("value", blueball.replace(/,$/, ''));
                ballBox.calNumber();
            });
            ///end
            //遗漏
            $("#yl").bind("click", function () {
                $(this).toggleClass("red").toggleClass("gray");
                $("#xzhq .omitnum").toggle();
                $("#xzlq .omitnum").toggle();
                $("#ylz").toggle();
                $(this).find("em").toggleClass("omitico2")
            });
            ///胆拖投注
            //胆码点击
            $("#dxzhq cite").bind("click", function () {

                if ($("#dxzhq cite.redBall").length >= (ballBox.cur.min - 1)) {
                    $("#dxzhq cite.redBall:eq(0)").removeClass("redBall");
                }
                var nowText = $(this).text();
                $.each($("#txzhq cite.redBall"), function (i, item) {
                    if ($(item).text() == nowText) {
                        $(item).removeAttr("class");

                    }
                });
                $(this).toggleClass("redBall");

                if ($("#txzhq cite.redBall").length == 0) {
                    $("#tRedBallValue").val("")
                } else {
                    var tRedBallValue = ballBox.tselectRedBallValue();
                    $("#tRedBallValue").attr("value", tRedBallValue)
                }
                if ($("#dxzhq cite.redBall").length > 0) {
                    var dRedBallValue = ballBox.dselectRedBallValue();
                    $("#dRedBallValue").attr("value", dRedBallValue.replace(/,$/, ''))
                } else {
                    $("#dRedBallValue").attr("value", "")
                }

                ballBox.calNumber();
            });
            //拖码点击  拖码的球不能和脱的球一样
            $("#txzhq cite").bind("click", function () {

                if (ballBox.cur.max > 0 && $("#txzhq cite.redBall").length >= ballBox.cur.max) {
                    //alert("[" + gameName + " " + ballBox.cur.typeName + "]拖码个数不能超过" + ballBox.cur.max + "个！");
                    Box.alert("拖码个数不能超过" + ballBox.cur.max + "个");
                    return;
                }
                var nowText = $(this).text();
                $.each($("#dxzhq cite.redBall"), function (i, item) {
                    if ($(item).text() == nowText) {
                        $(item).removeAttr("class");
                    }
                });
                $(this).toggleClass("redBall");
                if ($("#dxzhq cite.redBall").length > 0) {
                    var dRedBallValue = ballBox.dselectRedBallValue();
                    $("#dRedBallValue").attr("value", dRedBallValue.replace(/,$/, ''))
                } else {
                    $("#dRedBallValue").attr("value", "")
                }
                if ($("#txzhq cite.redBall").length == 0) {
                    $("#tRedBallValue").val("")
                } else {
                    var tRedBallValue = ballBox.tselectRedBallValue();
                    $("#tRedBallValue").attr("value", tRedBallValue.replace(/,$/, ''))
                }

                ballBox.calNumber();

            });
            //脱胆蓝球
            $("#dtxzlq cite").bind("click", function () {
                if (ballBox.cur.bluemax > 0 && $("#dtxzlq cite.blueBall").length >= ballBox.cur.bluemax) {
                    //alertTip("[" + gameName + " " + ballBox.cur.typeName + "]蓝球最大选球个数不能超过" + ballBox.cur.bluemax + "个！", "err");
                    Box.alert("蓝球最大选球个数不能超过" + ballBox.cur.bluemax + "个");
                    return;
                }
                $(this).toggleClass("blueBall");
                if ($("#dtxzlq cite.blueBall").length == 0) {
                    $("#dtBlueBallValue").val("")
                } else {
                    var dtBlueBallValue = ballBox.dtselectBlueBallValue();
                    $("#dtBlueBallValue").attr("value", dtBlueBallValue.replace(/,$/, ''))
                }

                ballBox.calNumber();
            });
            //清空选项
            $(".ssqdeleted").click(function () {

                ballBox.clean();
            });
            //摇一摇
            $("#shake").click(function () {
                c.Wobble();
            });
            //提交
            $(".ture").Touch(function () {
                if ($(this).hasClass("true_disabled")) return false;
                var type = ballBox.cur.type;
                var redValue = $("#RedBallValue").val();
                var blueValue = $("#BlueBallValue").val();
                var dredValue = $("#dRedBallValue").val();
                var tblueValue = $("#tRedBallValue").val();
                var dtblueValue = $("#dtBlueBallValue").val();

                if (ballBox.cur.way == 1) {
                    if (ballBox.count == 0) {
                        Box.tx("请选择" + ballBox.cur.min + "个红球" + ballBox.cur.bluemin + "个蓝球");
                        return false;
                    }
                    var redCountArr = redValue.split(",");
                    var blueCountArr = blueValue.split(",");
                    var k = localStorage.getItem(gameCode);
                    if (!k) {
                        localStorage.setItem(gameCode, type + "." + redValue + "|" + blueValue);
                    } else {
                        localStorage.setItem(gameCode, k + "#" + type + "." + redValue + "|" + blueValue);
                    }
                    /*url = "/buy/tz/" + gameCode.toLowerCase();
                    data = {
                        'type':type,'redValue':redValue,'blueValue':blueValue,'dredValue':dredValue,
                        'tblueValue':tblueValue,'dtblueValue':dtblueValue,
                    };
                    doAjaxSave(url,data);*/

                    window.location.href = "/cart/" + gameCode.toLowerCase();
                    //脱胆投注
                } else {
                    if (ballBox.count == 0) {
                        Box.tx("请选择" + (ballBox.cur.min + 1) + "个红球" + ballBox.cur.bluemin + "个蓝球");
                        return false;
                    }
                    if (dredValue && tblueValue && dtblueValue) {
                        var dredCountArr = dredValue.split(",");
                        var dredCountLen = dredCountArr.length;
                        var tredCountArr = tblueValue.split(",");
                        var tredCountLen = tredCountArr.length;
                        var dtblueCountArr = dtblueValue.split(",");
                        var dtblueCountLen = dtblueCountArr.length;
                        var k = localStorage.getItem(gameCode);
                        if (!k) {
                            localStorage.setItem(gameCode, type + "." + dredValue + "|" + tblueValue + "|" + dtblueValue);
                        } else {
                            localStorage.setItem(gameCode, k + "#" + type + "." + dredValue + "|" + tblueValue + "|" + dtblueValue);
                        }
                        /*url = "/buy/tz/" + gameCode.toLowerCase();
                        data = {
                            'type':type,'dredCountArr':dredCountArr,'dredCountLen':dredCountLen,'tredCountArr':tredCountArr,
                            'tredCountLen':tredCountLen,'dtblueCountArr':dtblueCountArr,'dtblueCountLen':dtblueCountLen
                        };
                        doAjaxSave(url,data);*/

                         window.location.href = "/cart/" + gameCode.toLowerCase();
                    } else {
                        Box.tx("请选择" + (ballBox.cur.min) + "个红球" + ballBox.cur.bluemin + "个蓝球");
                        return false;
                    }
                }

            });
        }
    },
    dlt: {
        bindBallClick: function () {
            //绑定历史开奖点击事件
            $("#lskj").bind("click", function () {
                $(this).find("em").toggleClass("ssqdown");
                $("." + gameCode.toLowerCase() + "kjlist").slideToggle(200);
            });
            $("#pullIco").click(function () {
                $(this).parent().toggleClass("pullHover");
                $("#pullText").toggle();
            });
            //双色球，大乐透
            //选中红球
            $("#xzhq .ssqBall>cite").bind("click", function () {
                if ($(this).attr("class")) {
                    $(this).removeAttr("class");
                } else {
                    if (ballBox.cur.max > 0 && $("#xzhq .ssqBall cite.redBall").length >= ballBox.cur.max) {
                        Box.alert("最多只能选择" + ballBox.cur.max + "个红球");
                        return;
                    }
                    $(this).toggleClass("redBall");
                }
                var rebball = ballBox.selectRedBallValue();
                $("#RedBallValue").attr("value", rebball.replace(/,$/, ''));
                ballBox.calNumber();

            });
            //选中蓝球
            $("#xzlq .ssqBall>cite").bind("click", function () {

                if ($(this).attr("class")) {
                    $(this).removeAttr("class");
                } else {
                    if (ballBox.cur.bluemax > 0 && $("#xzlq .ssqBall cite.blueBall").length >= ballBox.cur.bluemax) {
                        Box.alert("蓝球最大选球个数不能超过" + ballBox.cur.bluemax + "个");
                        return;
                    }
                    $(this).toggleClass("blueBall");
                }
                var blueball = ballBox.selectBlueBallValue();
                $("#BlueBallValue").attr("value", blueball.replace(/,$/, ''));
                ballBox.calNumber();
            });
            ///end
            //遗漏
            $("#yl").bind("click", function () {
                $(this).toggleClass("red").toggleClass("gray");
                $("#xzhq .omitnum").toggle();
                $("#xzlq .omitnum").toggle();
                $("#ylz").toggle();
                $(this).find("em").toggleClass("omitico2")
            });

            //清空选项
            $(".ssqdeleted").click(function () {
                $("#BlueBallValue").attr("value", "");
                $("#RedBallValue").attr("value", "");
                ballBox.clean();
            });
            //摇一摇
            $("#shake").click(function () {
                c.Wobble();
            });
            //提交
            $(".ture").Touch(function () {
                if ($(this).hasClass("true_disabled")) return false;
                var type = ballBox.cur.type;
                var redValue = $("#RedBallValue").val();
                var blueValue = $("#BlueBallValue").val();
                var dredValue = $("#dRedBallValue").val();
                var tblueValue = $("#tRedBallValue").val();
                var dtblueValue = $("#dtBlueBallValue").val();
                if (ballBox.cur.way == 1) {
                    if (ballBox.count == 0) {
                        Box.tx("请选择" + ballBox.cur.min + "个红球" + ballBox.cur.bluemin + "个蓝球");
                        return false;
                    }
                    var redCountArr = redValue.split(",");
                    var blueCountArr = blueValue.split(",");
                    var k = localStorage.getItem(gameCode);
                    if (!k) {
                        localStorage.setItem(gameCode, type + "." + redValue + "|" + blueValue)
                    } else {
                        localStorage.setItem(gameCode, k + "#" + type + "." + redValue + "|" + blueValue)
                    }
                    /*var url = "/buy/tz/" + gameCode.toLowerCase();
                    var data = {
                        'type':type,'redCountArr':redCountArr,'blueCountArr':blueCountArr
                    };
                    doAjaxSave(url,data);*/

                     window.location.href = "/cart/" + gameCode.toLowerCase();
                    //脱胆投注
                } else {
                    if (ballBox.count == 0) {
                        Box.tx("请选择" + (ballBox.cur.min + 1) + "个红球" + ballBox.cur.bluemin + "个蓝球");
                        return false;
                    }
                    if (dredValue && tblueValue && dtblueValue) {
                        var dredCountArr = dredValue.split(",");
                        var dredCountLen = dredCountArr.length;
                        var tredCountArr = tblueValue.split(",");
                        var tredCountLen = tredCountArr.length;
                        var dtblueCountArr = dtblueValue.split(",");
                        var dtblueCountLen = dtblueCountArr.length;
                        var k = localStorage.getItem(gameCode);
                        if (!k) {
                            localStorage.setItem(gameCode, type + "." + dredValue + "|" + tblueValue + "|" + dtblueValue)
                        } else {
                            localStorage.setItem(gameCode, k + "#" + type + "." + dredValue + "|" + tblueValue + "|" + dtblueValue)
                        }
                        /*var url = "/buy/tz/" + gameCode.toLowerCase();
                        var data = {
                            'type':type,'dredCountArr':dredCountArr,'dredCountLen':dredCountLen,'tredCountArr':tredCountArr,
                            'tredCountLen':tredCountLen,'dtblueCountArr':dtblueCountArr,'dtblueCountLen':dtblueCountLen
                        };
                        doAjaxSave(url,data);*/

                         window.location.href = "/cart/" + gameCode.toLowerCase();
                    } else {
                        Box.tx("请选择" + (ballBox.cur.min) + "个红球" + ballBox.cur.bluemin + "个蓝球");
                        return false;
                    }
                }

            });
        }
    },
    pl3: {
        bindBallClick: function () {
            //福彩3d ，排三 历史开奖
            $(".p5kj").bind("click", function () {
                $(this).find(".p5kjup").toggleClass("p5kjdown");
                $("#kj_code").slideToggle(200)
            });
            //直选百位
            $("#zx").find("div.jxsscxhBall").eq(0).find("b").click(function () {
                var o = $(this),
                    e_ = $("#zx li:eq(0)");
                if ($(this).hasClass("redBall")) {
                    $(this).removeClass("redBall");
                    c.remove_(o, e_)
                } else {
                    $(this).addClass("redBall");
                    c.move_(o, e_)
                }
                ballBox.calNumber();
            });
            //直选十位
            $("#zx").find("div.jxsscxhBall").eq(1).find("b").click(function () {
                var o = $(this),
                    e_ = $("#zx li:eq(1)");
                if ($(this).hasClass("redBall")) {
                    $(this).removeClass("redBall");
                    c.remove_(o, e_)
                } else {
                    $(this).addClass("redBall");
                    c.move_(o, e_)
                }
                ballBox.calNumber();
            });
            //直选各位
            $("#zx").find("div.jxsscxhBall").eq(2).find("b").click(function () {
                var o = $(this),
                    e_ = $("#zx li:eq(2)");
                if ($(this).hasClass("redBall")) {
                    $(this).removeClass("redBall");
                    c.remove_(o, e_)
                } else {
                    $(this).addClass("redBall");
                    c.move_(o, e_)
                }
                ballBox.calNumber();
            });
            //组三
            $("#zs").find("div.jxsscxhBall").eq(0).find("b").click(function () {
                if ($(this).hasClass("redBall")) {
                    $(this).toggleClass("redBall");
                    ballBox.calNumber();
                } else {
                    if (!$(this).parent().find(".redBall").length) {
                        if (!$(this).hasClass("redBall")) {
                            var m = $(this).html();
                            m = {
                                "00": "0",
                                11: "1",
                                22: "2",
                                33: "3",
                                44: "4",
                                55: "5",
                                66: "6",
                                77: "7",
                                88: "8",
                                99: "9"
                            }[m] || "0";
                            $("#zs").find("div.jxsscxhBall").eq(1).find("b").eq(m).removeClass("redBall")
                        }
                        $(this).toggleClass("redBall")
                    } else {
                        $(this).addClass("redBall").siblings().removeClass("redBall");
                        var m = $(this).html();
                        m = {
                            "00": "0",
                            11: "1",
                            22: "2",
                            33: "3",
                            44: "4",
                            55: "5",
                            66: "6",
                            77: "7",
                            88: "8",
                            99: "9"
                        }[m] || "0";
                        $("#zs").find("div.jxsscxhBall").eq(1).find("b").eq(m).removeClass("redBall");
                    }
                    ballBox.calNumber();
                }
            });
            $("#zs").find("div.jxsscxhBall").eq(1).find("b").click(function () {
                if ($(this).hasClass("redBall")) {
                    $(this).toggleClass("redBall");
                    ballBox.calNumber();
                } else {
                    if (!$(this).parent().find(".redBall").length) {
                        if (!$(this).hasClass("redBall")) {
                            var m = $(this).html();
                            $("#zs").find("div.jxsscxhBall").eq(0).find("b").eq(m).removeClass("redBall")
                        }
                        $(this).toggleClass("redBall")
                    } else {
                        $(this).addClass("redBall").siblings().removeClass("redBall");
                        var m = $(this).html();
                        $("#zs").find("div.jxsscxhBall").eq(0).find("b").eq(m).removeClass("redBall")
                    }
                    ballBox.calNumber();
                }
            });
            //和值
            $("#hz").find("b").click(function () {
                $(this).toggleClass("redBall");
                ballBox.calNumber();
            });

            //删除/机选
            $("#deleted").click(function () {
                if ($(this).text() == "机选") {
                    c.Wobble();
                } else {
                    ballBox.clean();
                    return;
                }
            });
            //摇一摇
            $("#shake").click(function () {
                c.Wobble();
            });
            //提交
            $("#pay_").Touch(function () {
                if ($(this).hasClass("true_disabled")) return false;
                var zs = parseInt($(".buyFooter span.gray cite:eq(0)").html());
                var n = $(".sdTab ul").find(".cur").attr("v");
                if (zs == 0) {
                    c.Wobble();
                } else {
                    var code = "";
                    code = c.code(n, zs);
                    var sdSelectNum = localStorage.getItem(gameCode);
                    sdSelectNum && (sdSelectNum += code) || (sdSelectNum = code);
                    localStorage.setItem(gameCode, sdSelectNum);
                    /*var data = {'sdSelectNum':sdSelectNum};
                    var url = "/buy/tz/" + gameCode.toLowerCase();
                    doAjaxSave(url,data);*/
                    location.href = "/cart/" + gameCode.toLowerCase();
                }
            });
        }
    },
    fc3d: {
        bindBallClick: function () {
            //福彩3d ，排三 历史开奖
            $(".p5kj").bind("click", function () {
                $(this).find(".p5kjup").toggleClass("p5kjdown");
                $("#kj_code").slideToggle(200)
            });
            //直选百位
            $("#zx").find("div.jxsscxhBall").eq(0).find("b").click(function () {
                var o = $(this),
                    e_ = $("#zx li:eq(0)");
                if ($(this).hasClass("redBall")) {
                    $(this).removeClass("redBall");
                    c.remove_(o, e_)
                } else {
                    $(this).addClass("redBall");
                    c.move_(o, e_)
                }
                ballBox.calNumber();
            });
            //直选十位
            $("#zx").find("div.jxsscxhBall").eq(1).find("b").click(function () {
                var o = $(this),
                    e_ = $("#zx li:eq(1)");
                if ($(this).hasClass("redBall")) {
                    $(this).removeClass("redBall");
                    c.remove_(o, e_)
                } else {
                    $(this).addClass("redBall");
                    c.move_(o, e_)
                }
                ballBox.calNumber();
            });
            //直选各位
            $("#zx").find("div.jxsscxhBall").eq(2).find("b").click(function () {
                var o = $(this),
                    e_ = $("#zx li:eq(2)");
                if ($(this).hasClass("redBall")) {
                    $(this).removeClass("redBall");
                    c.remove_(o, e_)
                } else {
                    $(this).addClass("redBall");
                    c.move_(o, e_)
                }
                ballBox.calNumber();
            });
            //组三
            $("#zs").find("div.jxsscxhBall").eq(0).find("b").click(function () {
                if ($(this).hasClass("redBall")) {
                    $(this).toggleClass("redBall");
                    ballBox.calNumber();
                } else {
                    if (!$(this).parent().find(".redBall").length) {
                        if (!$(this).hasClass("redBall")) {
                            var m = $(this).html();
                            m = {
                                "00": "0",
                                11: "1",
                                22: "2",
                                33: "3",
                                44: "4",
                                55: "5",
                                66: "6",
                                77: "7",
                                88: "8",
                                99: "9"
                            }[m] || "0";
                            $("#zs").find("div.jxsscxhBall").eq(1).find("b").eq(m).removeClass("redBall")
                        }
                        $(this).toggleClass("redBall")
                    } else {
                        $(this).addClass("redBall").siblings().removeClass("redBall");
                        var m = $(this).html();
                        m = {
                            "00": "0",
                            11: "1",
                            22: "2",
                            33: "3",
                            44: "4",
                            55: "5",
                            66: "6",
                            77: "7",
                            88: "8",
                            99: "9"
                        }[m] || "0";
                        $("#zs").find("div.jxsscxhBall").eq(1).find("b").eq(m).removeClass("redBall");
                    }
                    ballBox.calNumber();
                }
            });
            $("#zs").find("div.jxsscxhBall").eq(1).find("b").click(function () {
                if ($(this).hasClass("redBall")) {
                    $(this).toggleClass("redBall");
                    ballBox.calNumber();
                } else {
                    if (!$(this).parent().find(".redBall").length) {
                        if (!$(this).hasClass("redBall")) {
                            var m = $(this).html();
                            $("#zs").find("div.jxsscxhBall").eq(0).find("b").eq(m).removeClass("redBall")
                        }
                        $(this).toggleClass("redBall")
                    } else {
                        $(this).addClass("redBall").siblings().removeClass("redBall");
                        var m = $(this).html();
                        $("#zs").find("div.jxsscxhBall").eq(0).find("b").eq(m).removeClass("redBall")
                    }
                    ballBox.calNumber();
                }
            });
            //和值
            $("#hz").find("b").click(function () {
                $(this).toggleClass("redBall");
                ballBox.calNumber();
            });

            $("#zsbh").find("b").click(function () {
                $(this).toggleClass("redBall");
                ballBox.calNumber();
            });
            $("#zlbh").find("b").click(function () {
                $(this).toggleClass("redBall");
                ballBox.calNumber();
            });
            //删除/机选
            $("#deleted").click(function () {
                if ($(this).text() == "机选") {
                    c.Wobble();
                } else {
                    ballBox.clean();
                    return;
                }
            });
            //摇一摇
            $("#shake").click(function () {
                c.Wobble();
            });
            //提交
            //提交
            $("#pay_").Touch(function () {
                if ($(this).hasClass("true_disabled")) return false;
                var n = $(".sdTab ul").find(".cur").attr("v");
                var zs = parseInt($(".buyFooter span.gray cite:eq(0)").html());

                if (zs == 0) {
                    c.Wobble();
                } else {
                    var code = "";
                    code = c.code(n, zs);
                    var sdSelectNum = localStorage.getItem(gameCode);
                    sdSelectNum && (sdSelectNum += code) || (sdSelectNum = code);
                    localStorage.setItem(gameCode, sdSelectNum);
                    location.href = "/buy/p3tz/" + gameCode.toLowerCase();
                }
            });
        }
    },
    cqssc: {
        bindBallClick: function () {
            $("#c_c").click(function () {
                $("#kj_code").slideToggle();
                $("#kjup").toggleClass("kjdown");
            });
            $("#kj_code").click(function () {
                $("#kj_code").slideToggle();
                $("#kjup").addClass("kjdown");
            });

            $(".jxsscxhlist div.jxsscxhBall b").click(function () {
                var o = $(this), g = $(this).parent().parent().attr("v"), idx = $(this).parent().parent().attr("idx"), b = $("#" + g + " li:eq(" + idx + ")");
                if (g == "DXDS") {
                    if ($(this).hasClass("red")) {
                        $(this).removeClass("red");
                        fun.cqssc.delColor(o, b, g);
                        $(this).parent().parent().removeAttr("n");
                    } else {
                        $(this).parent().parent().find(".red").removeClass("red");
                        $(this).addClass("red");
                        fun.cqssc.addColor(o, b, g);
                        $(this).parent().parent().attr("n", "y");
                    }
                } else {
                    if ($(this).hasClass("red")) {
                        $(this).toggleClass("red");
                        fun.cqssc.delColor(o, b, g);
                    } else {
                        $(this).toggleClass("red");
                        fun.cqssc.addColor(o, b, g);
                    }
                }
                ballBox.calNumber();
            });
            //二星组选
            $(".jxsscxhBall2 b").click(function () {
                if (!$(this).hasClass("red") && $("#2XZXFS").find(".red").length >= ballBox.cur.max) {
                    Box.alert("亲,二星组选最多只能选择" + ballBox.cur.max + "个号码");
                    return;
                }
                $(this).toggleClass("red");
                ballBox.calNumber();
            });
            //组选三
            $(".jxsscxhBall3 b").click(function () {
                if (!$(this).hasClass("red") && $("#ZX3FS").find(".red").length >= ballBox.cur.max) {
                    Box.alert("亲,组选三最多只能选择" + ballBox.cur.max + "个号码");
                    return;
                }
                $(this).toggleClass("red");
                ballBox.calNumber();
            });
            //组选六
            $(".jxsscxhBall4 b").click(function () {
                if (!$(this).hasClass("red") && $("#ZX6").find(".red").length >= ballBox.cur.max) {
                    Box.alert("亲,组选六最多只能选择" + ballBox.cur.max + "个号码");
                    return;
                }
                $(this).toggleClass("red");
                ballBox.calNumber();
            });
            $("#2XHZ b").click(function () {
                $(this).toggleClass("red");
                ballBox.calNumber();
            });

            //摇一摇
            $("#shake").click(function () {
                c.Wobble();
            });
            //删除/机选
            $(".deleted").click(function () {
                ballBox.clean();
            });
            $("#isOk_").click(function () {
                if ($(this).hasClass("true_disabled")) return false;

                var n = $("#play_tabs li.cur").attr("val");
                var zs = parseInt($("#zs_ cite:eq(0)").html());
                var zs1 = $("#" + n).find("b.red").length;
                if (zs == 0 || zs1 == 0) {
                    //enter.random_()
                    Box.alert("请选择投注内容");
                    return;
                } else {
                    var code = "";
                    code = c.code1(n, zs);
                    localStorage.setItem(gameCode, code);
                    /*var data = {'code':code};
                    var url = "/cart/" + gameCode.toLowerCase();
                    doAjaxSave(url,data);*/
                    //location.href = "/buy/p3tz/" + gameCode.toLowerCase();
                }
            });
        },
        delColor: function (star, end, g) {
            if (g == "DXDS") {
                end.attr("class", "cur");
                end.find("span").html(end.attr("v"));
            } else {
                var red = star.parent().find(".red");
                var c_ = red.length > 0 && "cur2" || "cur";
                end.attr("class", c_);
                if (!red.length) {
                    end.find("span").html(end.attr("v"));
                } else {
                    var html = "";
                    red.each(function () {
                        html += "<em>" + $(this).html() + "</em>";
                    });
                    end.find("span").html(html);
                }
            }
        },
        addColor: function (star, end, g) {
            $("#c").show();
            var w = star.width();
            var h = star.height();
            var o = star.offset();
            var t = parseInt(o.top);
            var l = parseInt(o.left);
            $("body").append(c_);
            $("#c").css({
                left: l,
                top: t,
                width: w,
                height: h
            });
            var w_ = end.width();
            var h_ = end.height();
            var o_ = end.offset();
            var t_ = parseInt(o_.top);
            var l_ = parseInt(o_.left);
            t_ += h_ - h;
            l_ += (w_ - w) / 2;
            $("#c").animate({
                left: l_,
                top: t_
            },
                speed_,
                function () {
                    $("#c").remove();
                    if
                    (g == "DXDS") {
                        end.attr("class", "cur2");
                        end.find("span").html(star.html());
                    } else {
                        var red = star.parent().find(".red");
                        var cl_ = red.length;
                        cl_ = cl_ > 8 && "cur2 jxssclist3" || cl_ > 4 && "cur2 jxssclist2" || cl_ > 0 && "cur2" || "cur";
                        end.attr("class", cl_);
                        var html = "";
                        red.each(function () {
                            html += "<em>" + $(this).html() + "</em>";
                        });
                        end.find("span").html(html);
                    }
                });

        }

    },
    jx11x5: {
        bindBallClick: function () {
            //任选
            $("#rx .ssqBall cite").Touch(function () {
                $(this).toggleClass("redBall");
                ballBox.calNumber();
            });
            //前二
            $("#qe .relative:eq(0) .ssqBall cite").Touch(function () {
                $(this).toggleClass("redBall");
                var index_ = $("#qe .relative:eq(0) .ssqBall").find("cite").index(this);
                $("#qe .relative:eq(1) .ssqBall cite").eq(index_).removeClass("redBall");
                ballBox.calNumber();
            });
            $("#qe .relative:eq(1) .ssqBall cite").Touch(function () {
                $(this).toggleClass("redBall");
                var index_ = $("#qe .relative:eq(1) .ssqBall").find("cite").index(this);
                $("#qe .relative:eq(0) .ssqBall cite").eq(index_).removeClass("redBall");
                ballBox.calNumber();
            });
            //前三
            $("#qs .relative:eq(0) .ssqBall cite").Touch(function () {
                $(this).toggleClass("redBall");
                var index_ = $("#qs .relative:eq(0) .ssqBall").find("cite").index(this);
                $("#qs .relative:eq(1) .ssqBall cite").eq(index_).removeClass("redBall");
                $("#qs .relative:eq(2) .ssqBall cite").eq(index_).removeClass("redBall");
                ballBox.calNumber();
            });
            $("#qs .relative:eq(1) .ssqBall cite").Touch(function () {
                $(this).toggleClass("redBall");
                var index_ = $("#qs .relative:eq(1) .ssqBall").find("cite").index(this);
                $("#qs .relative:eq(0) .ssqBall cite").eq(index_).removeClass("redBall");
                $("#qs .relative:eq(2) .ssqBall cite").eq(index_).removeClass("redBall");
                ballBox.calNumber();
            });
            $("#qs .relative:eq(2) .ssqBall cite").Touch(function () {
                $(this).toggleClass("redBall");
                var index_ = $("#qs .relative:eq(2) .ssqBall").find("cite").index(this);
                $("#qs .relative:eq(1) .ssqBall cite").eq(index_).removeClass("redBall");
                $("#qs .relative:eq(0) .ssqBall cite").eq(index_).removeClass("redBall");
                ballBox.calNumber();
            });
            //删除
            $(".deleted").Touch(function () {
                ballBox.clean();
            });
            $("#isOk_").click(function () {
                if ($(this).hasClass("true_disabled")) return false;
                var zs = parseInt($("#zs_ cite:eq(0)").html());
                var n = $("#play_tabs li.cur").attr("val");
                var h = $("#play_tabs li.cur").html();
                if (zs == 0) {
                    Box.alert("请选择投注内容");
                } else {
                    var code = c.code2(n, zs, h);
                    localStorage.setItem(gameCode, code);
                    /*var data = {'code':code};
                    var url = "/buy/tz/" + gameCode.toLowerCase();
                    doAjaxSave(url,data);*/
                    window.location.href = "/cart/" + gameCode.toLowerCase();
                }
            });
            $("#shake").Touch(function () {
                c.Wobble();
            });
            $(".k3kj").Touch(function () {
                $("#kj_code").slideToggle();
                if ($(".k3waitkj em").hasClass("kjdown")) {
                    $(".k3waitkj em").removeClass("kjdown");
                } else {
                    $(".k3waitkj em").addClass("kjdown");
                }
            });
        }
    }
};


//玩法选择及号码点击处理
var ballBox = {
    //当前玩法信息
    cur: {
        //玩法编码 DS或者DT
        type: null,
        //选号方式。1：标准选号 2：胆拖选号 3：和值选号 4：手工录入
        way: 1,
        //红球/默认 - 最少选择号码个数
        min: 1,
        //红球/默认 - 最多选择号码个数
        max: 0,
        //蓝球 - 最少选择号码个数
        bluemin: 1,
        //蓝球 - 最多选择号码个数
        bluemax: 0,
        //选号前置符
        perch: "",
        //还原当前玩法信息
        reset: function () {
            this.type = null;
            this.way = 1;
            this.min = 1;
            this.max = 0;
            this.bluemin = 1;
            this.bluemax = 0;
            this.perch = "";
        }
    },
    //当前所选球注数
    count: 0,
    //所选号码数组，一个元素表示一组号码,每组号码又分别是一个数组，0：投注数据 1：显示数据
    numbers: new Array(),
    //初始化玩法选择
    initType: function () {

        //初始化玩法属性
        function initCur() {
            ballBox.cur.reset();
            var playId = $("#" + gameCode.toLowerCase() + "_tab ul li[class*='cur']").attr("playid");
            var val = $("#" + gameCode.toLowerCase() + "_tab ul li[class*='cur']").attr("val");
            ballBox.cur.way = playId == null || playId == "" ? 1 : parseInt(playId);
            ballBox.cur.type = val == null || val == "" ? "DS" : val;
            $.extend(ballBox.cur, typeInfo(gameCode, ballBox.cur.type));
            fun[gameCode.toLowerCase()].bindBallClick();
        }

        //加载第一层玩法
        function loadUrl() {
            if (ballBox.cur.way == 1) {
                $("#cpttz").show();
                $("#cdttz").hide();
            } else {
                $("#cpttz").hide();
                $("#cdttz").show();
            }
        }

        bindClick();
        //头部彩种选择事件
        function bindClick() {
            switch (gameCode) {
                case "SSQ":
                    //第一层玩法选择事件
                    /*var l = $(".downline").offset().left;
                    $(".clearfix li").click(function () {
                        ballBox.cleanBox();
                        ballBox.clean();
                        var liindex = $(".clearfix li").index(this);
                        $(this).addClass("cur").siblings().removeClass("cur");
                        ballBox.cur.way = parseInt($(this).attr("playid"));
                        ballBox.cur.type = $(this).attr("val");
                        var liWidth = $(this).width();
                        $(".downline").stop(false, true).animate({
                            left: liindex * liWidth + l + "px"
                        },
                        300);
                        loadUrl();

                    });
                    break;*/
                case "FC3D":
                case "PL3":
                    ballBox.initPlayType.p3();
                    $(".sdTab ul").find("li").bind("click", function () {
                        ballBox.cleanBox();
                        ballBox.clean();
                        var cc = $(this);
                        if ($(this).hasClass("cur")) {
                            return;
                        }
                        var t = $(this).offset().left;
                        var t1 = $(this).width();
                        ballBox.cur.type = $(this).attr("val");
                        $(".sdTab .downline").animate({
                            left: t + "px",
                            width: t1 + "px"
                        },
                        200,
                        function () {
                            cc.addClass("cur").siblings().removeClass("cur");
                        });
                        var v = $(this).attr("v");
                        var t3 = {
                            zx: "0",
                            zs: "1",
                            hz: "2",
							zsbh:"3",
							zlbh:"4"
                        }[v] || "0";
                        v = {
                            zx: "0",
                            zs: "1",
                            hz: "2",
							zsbh:"3",
							zlbh:"4"
                        }[v] || "0";
                        $("#bonus_details .shakeOmit").siblings().slideUp();
                        $("#bonus_details div").eq(v).slideDown();
                        $("#content").animate({
                            left: "-" + $(window).width() * t3 + "px"
                        },
                        200);
                        !$(".p5kj").find(".p5kjup").hasClass("p5kjdown") && $(".p5kj").find(".p5kjup").addClass("p5kjdown");
                        $("#kj_code").slideUp(200);


                    });
                    break;
                case "CQSSC":
                    $("#play_tabs li").click(function () {
                        var v = $(this).attr("val");
                        if ($(this).hasClass("cur")) {
                            return;
                        }
                        ballBox.cur.type = v;
                        $(this).addClass("cur").siblings().removeClass("cur");
                        $("#DXDS,#2XZXFS,#5XTX,#5XDX,#3XDX,#2XDX,#1XDX,#ZX3FS,#ZX6,#2XHZ").hide();
                        $("#" + v).show();
                        $("#kj_code").slideUp();
                        var len = $(this).index();

                        $("#bonus_ div").eq(len).show().siblings().hide();
                        $("#shake").show();
                        $.extend(ballBox.cur, typeInfo(gameCode, ballBox.cur.type));
                        ballBox.clean();
                    });
                    fun.publick.topNavInit();
                    break;
                case "JX11X5":
                    ballBox.initPlayType.jx11x5();
                    $("#play_tabs li").click(function () {
                        var v = $(this).attr("val");
                        ballBox.cur.type = v;
                        if ($(this).hasClass("cur")) {
                            return;
                        }
                        $(this).addClass("cur").siblings().removeClass("cur");
                        var leng = $("#play_tabs").find("li").index(this);
                        $("#bonus_ .shakeomit").siblings().slideUp();
                        $("#bonus_ div").eq(leng).slideDown();

                        var s = {
                            "Q2ZHIX": 1,
                            "Q3ZHIX": 2
                        }[v] || 0;
                        $("#content").animate({
                            left: "-" + $(window).width() * s + "px"
                        }, 250

                    );
                        $.extend(ballBox.cur, typeInfo(gameCode, ballBox.cur.type));
                        ballBox.clean();
                    });
                    fun.publick.topNavInit();
                    break;
            }
        }
        loadUrl();
        initCur();

    },
    initPlayType: {
        p3: function () {
            var w = $(window).width() + "px";

            $("#zx").css("width", w);
            $("#zs").css("width", w);
            $("#hz").css("width", w);
			$("#zsbh").css("width", w);
			$("#zlbh").css("width", w);
            $("#content").parent().css("width", w);
            var cur = $(".sdTab ul").find(".cur");
            if (cur.length > 0) {
                var t = cur.offset().left;
                var t1 = cur.width();
                $(".sdTab .downline").animate({
                    left: t + "px",
                    width: t1 + "px"
                },
                200,
                function () {
                    cur.addClass("cur").siblings().removeClass("cur");
                });
                var v = cur.attr("v");
                var t3 = {
                    zx: "0",
                    zs: "1",
                    hz: "2",
					zsbh: "3",
					zlbh: "4"
                }[v] || "0";
                $("#content").animate({
                    left: "-" + $(window).width() * t3 + "px"
                },
                200);
            }
        },
        jx11x5: function () {
            var w = $(window).width() + "px";
            $("#rx").css("width", w);
            $("#rx").find(".omitnum ").css("width", w);
            $("#qe").css("width", w);
            $("#qe").find(".omitnum ").css("width", w);
            $("#qs").css("width", w);
            $("#qs").find(".omitnum ").css("width", w);
            $("#content").parent().css("width", w);
            var cur = $("#play_tabs li").find("cur");
            var s = {
                "Q2ZHIX": 1,
                "Q3ZHIX": 2
            }[cur] || 0;
            $("#content").animate({
                left: "-" + $(window).width() * s + "px"
            }, 250
        );
        }
    },
    //清除选号数据
    cleanBox: function () {
        this.count = 0;
        this.numbers = new Array();
        $(".buyFloat span cite").text(0);
    },
    //给金额和注数加上颜色
    addColor: function () {
        if (ballBox.count > 0) {
            $("#countNotes").addClass("red");
            $("#countNotes").next().addClass("red");
        } else {
            $("#countNotes").removeClass("red");
            $("#countNotes").next().removeClass("red");
        }
    },
    //计算当前选号数据
    calNumber: function () {
        this.cleanBox();
        switch (gameCode) {
            case "SSQ":
                {
                    switch (ballBox.cur.way) {
                        case 1:
                            {
                                var redBall = $("#RedBallValue").attr("value");
                                var blueBall = $("#BlueBallValue").attr("value");
                                if (redBall != "" && redBall.split(',').length >= ballBox.cur.min && blueBall != "" && blueBall.split(',').length >= ballBox.cur.bluemin) {
                                    ballBox.numbers.push([ballBox.cur.perch + redBall + "|" + blueBall]);
                                }
                                switch (ballBox.cur.type) {
                                    case "DS":
                                        {
                                            //判断双色球选球个数，改变当前玩法编码
                                            var red = redBall.split(",");
                                            var blue = blueBall.split(",");
                                            if (red.length > ballBox.cur.min || blue.length > ballBox.cur.bluemin) {
                                                this.cur.type = "FS";
                                            } else {
                                                this.cur.type = "DS";
                                            }
                                        }
                                        break;
                                }
                            }
                            break;
                        case 2:
                            {
                                var dmObj = $("#dRedBallValue").attr("value");
                                var tmObj = $("#tRedBallValue").attr("value");
                                var blues = $("#dtBlueBallValue").attr("value");
                                var cr = Math.nCr(tmObj.split(',').length, (ballBox.cur.min - dmObj.split(',').length));

                                if (dmObj != "" && dmObj.split(',').length > 0 && cr > 0 && dmObj.split(',').length + tmObj.split(',').length >= ballBox.cur.min && blues != "" && blues.split(',').length >= ballBox.cur.bluemin) {
                                    var inum = dmObj + "|" + tmObj + "|" + blues;
                                    ballBox.numbers.push([inum, ""]);
                                }
                            }
                            break;
                    }
                }
                break;
            case "DLT":
                {
                    switch (ballBox.cur.type) {
                        case "12X2DS":
                            {
                                var selBalls = $(".ball li.numbers b.selected_red");
                                var ret = new Array();
                                $.each(selBalls, function (i, item) {
                                    ret.push($(selBalls[i]).text());
                                })
                                ballBox.numbers.push([ballBox.cur.perch + ret.join(","), ret.join(",")]);
                            }
                            break;
                        default:
                            {
                                var selBalls = $("#RedBallValue").attr("value");
                                var blueselBalls = $("#BlueBallValue").attr("value");
                                //判断大乐透选球个数，改变当前玩法编码
                                switch (ballBox.cur.type) {
                                    case "DS":
                                        {
                                            var red = selBalls.split(",");
                                            var blue = blueselBalls.split(",");
                                            if (selBalls.split(',').length > ballBox.cur.min || blueselBalls.split(',').length > ballBox.cur.bluemin) {
                                                this.cur.type = "FS";
                                            } else {
                                                this.cur.type = "DS";
                                            }
                                        }
                                        break;
                                }
                                if (selBalls.split(',').length >= ballBox.cur.min && blueselBalls.split(',').length >= ballBox.cur.bluemin) {
                                    ballBox.numbers.push([ballBox.cur.perch + selBalls + "|" + blueselBalls, selBalls + "|" + blueselBalls]);
                                }
                            }
                            break;
                    }
                }
                break;
            case "PL3":
            case "FC3D":
                {
                    switch (ballBox.cur.type) {
                        case "FS":
                            {
                                var retc = new Array();
                                $(".jxsscxhBall").each(function (k, v) {
                                    var selBalls = $(v).find("b.redBall");
                                    var ret = new Array();
                                    $.each(selBalls, function (i, item) {
                                        ret.push($(selBalls[i]).text());
                                    })
                                    retc.push(ret.join(""));
                                })

                                ballBox.numbers.push([ballBox.cur.perch + retc.join(","), retc.join(",")]);
                            }
                            break;
                        case "HZ":
                            {
                                var selBalls = $("#hz .jxsscxhBall b.redBall");
                                $(selBalls).each(function (k, v) {
                                    var code = $(v).text();
                                    ballBox.numbers.push([ballBox.cur.perch + code, code]);
                                })
                            }
                            break;
                        case "ZX3DS":
                            {
                                var m = {
                                    0: "0",
                                    11: "1",
                                    22: "2",
                                    33: "3",
                                    44: "4",
                                    55: "5",
                                    66: "6",
                                    77: "7",
                                    88: "8",
                                    99: "9"
                                };
                                var selBalls = $("#zs .jxsscxhBall b.redBall");
                                var ret = new Array();
                                $.each(selBalls, function (i, item) {
                                    if ($(selBalls[i]).text().length > 1) {
                                        for (var b = 0; b < 2; b++) {
                                            ret.push(m[parseInt($(selBalls[i]).text())]);
                                        }
                                    } else {
                                        ret.push($(selBalls[i]).text());
                                    }
                                })
                                if (ret.length == 3 && ret.distinctN().length == 2) {
                                    ballBox.numbers.push([ballBox.cur.perch + ret.join(","), ret.join(",")]);
                                }
                            }
                            break;
						case "ZSBH":
                            {
                                var selBalls = $("#zsbh .jxsscxhBall b.redBall");
                                $(selBalls).each(function (k, v) {
                                    var code = $(v).text();
                                    ballBox.numbers.push([ballBox.cur.perch + code, code]);
                                })
                            }
                            break;
						case "ZLBH":
                            {
                                var selBalls = $("#zlbh .jxsscxhBall b.redBall");
                                $(selBalls).each(function (k, v) {
                                    var code = $(v).text();
                                    ballBox.numbers.push([ballBox.cur.perch + code, code]);
                                })
                            }
                            break;
                    }
                    var wf = $(".sdTab ul").find(".cur").attr("v");
                    if ($("#" + wf).find(".redBall").length) {
                        $("#deleted").html("清空")
                    } else {
                        $("#deleted").html("机选")
                    }
                }
                break;
            case "CQSSC":
                switch (ballBox.cur.type) {
                    case "DXDS":
                        var selBalls = $("#DXDS div.jxsscxhBall div[n=y]");
                        var ret = new Array();
                        $.each(selBalls, function (i, item) {
                            ret.push($(selBalls[i]).find("b.red").attr("v"));
                        })
                        ballBox.numbers.push([ballBox.cur.perch + ret.join(","), ballBox.convertNumberDisplay(ret).join(",")]);
                        break;
                    case "1XDX":
                    case "2XDX":
                    case "3XDX":
                    case "5XDX":
                        var retc = new Array();
                        $("#" + ballBox.cur.type + " div.jxsscxhBall").each(function (k, v) {
                            var selBalls = $(v).find("p b.red");
                            var ret = new Array();
                            $.each(selBalls, function (i, item) {
                                ret.push($(selBalls[i]).text());
                            })
                            retc.push(ret.join(""));
                        })

                        ballBox.numbers.push([ballBox.cur.perch + retc.join(","), retc.join(",")]);
                        break;
                    case "5XTX":
                        var ret = new Array();
                        $.each($("#" + ballBox.cur.type + " div.jxsscxhBall"), function (k, v) {
                            var iret = new Array();
                            $($(v).find("p b.red")).each(function (b, j) {
                                iret.push($(j).text());
                            })
                            ret.push(iret);
                        })
                        Math.arrange(ret, function (item) {
                            ballBox.numbers.push([ballBox.cur.perch + item.join(","), item.join(",")]);
                        });
                        break;
                    case "2XZXFS":
                        var selBalls = $(".jxsscxhBall2 b.red");
                        var ret = new Array();
                        $.each(selBalls, function (i, item) {
                            ret.push($(selBalls[i]).text());
                        })
                        ballBox.numbers.push([ballBox.cur.perch + ret.join(","), ret.join(",")]);
                        break;
                    case "ZX3FS":
                        var selBalls = $(".jxsscxhBall3 b.red");
                        var ret = new Array();
                        $.each(selBalls, function (i, item) {
                            ret.push($(selBalls[i]).text());
                        })
                        ballBox.numbers.push([ballBox.cur.perch + ret.join(","), ret.join(",")]);
                        break;
                    case "2XHZ":
                        var selBalls = $("#2XHZ b.red");
                        var ret = new Array();
                        $.each(selBalls, function (i, item) {
                            ret.push($(selBalls[i]).text());
                        })
                        ballBox.numbers.push([ballBox.cur.perch + ret.join(","), ret.join(",")]);
                        break;
                    case "ZX6":
                        var selBalls = $(".jxsscxhBall4 b.red");
                        var ret = new Array();
                        $.each(selBalls, function (i, item) {
                            ret.push($(selBalls[i]).text());
                        })
                        ballBox.numbers.push([ballBox.cur.perch + ret.join(","), ret.join(",")]);
                        break;
                        break;
                }
                break;
            case "JX11X5":
                switch (ballBox.cur.type) {
                    case "RX1":
                    case "RX2":
                    case "RX3":
                    case "RX4":
                    case "RX5":
                    case "RX6":
                    case "RX7":
                    case "RX8":
                    case "Q2ZUX":
                    case "Q3ZUX":
                        var selBalls = $(".ssqBall cite.redBall");
                        var ret = new Array();
                        $.each(selBalls, function (i, item) {
                            ret.push($(selBalls[i]).text());
                        });
                        ballBox.numbers.push([ballBox.cur.perch + ret.join(","), ret.join(",")]);
                        break;
                    case "Q2ZHIX":

                        var ret = new Array();
                        $.each($("#qe .relative"), function (k, v) {
                            var iret = new Array();
                            $($(v).find(".ssqBall cite.redBall")).each(function (b, j) {
                                iret.push($(j).text());
                            });
                            if (iret.length > 0) {
                                ret.push(iret.join(" "));
                            }
                        });
                        if (ret.length == ballBox.cur.min) {
                            ballBox.numbers.push([ballBox.cur.perch + ret.join(","), ret.join(",")]);
                        }

                        break;
                    case "Q3ZHIX":

                        var ret = new Array();
                        $.each($("#qs .relative"), function (k, v) {
                            var iret = new Array();
                            $($(v).find(".ssqBall cite.redBall")).each(function (b, j) {
                                iret.push($(j).text());
                            });
                            if (iret.length > 0) {
                                ret.push(iret.join(" "));
                            }
                        });
                        if (ret.length == ballBox.cur.min) {
                            ballBox.numbers.push([ballBox.cur.perch + ret.join(","), ret.join(",")]);
                        }

                        break;
                }
                break;
        }

        //计算ballBox.numbers里投注号码的注数和总的投注注数
        ballBox.calNumberCount();
        //计算完号码数组后清除无效数据
        this.cleanUp();
        //输出到提示信息
        $(".buyFloat span cite:eq(0)").text(ballBox.count);
        $(".buyFloat span cite:eq(1)").text(ballBox.count * 2);
        ballBox.addColor();
    },
    selectRedBallValue: function () {
        var redBall = "";
        $("#xzhq .ssqBall cite.redBall").each(function () {
            redBall += $(this).text() + ","
        });
        //redBall = Xhc.reSort(redBall.substring(0, redBall.length - 1));
        return redBall;
    },
    selectBlueBallValue: function () {
        var blueBall = "";
        $("#xzlq .ssqBall cite.blueBall").each(function () {
            blueBall += $(this).text() + ","
        });
        //blueBall = Xhc.reSort(blueBall.substring(0, blueBall.length - 1));
        return blueBall
    },
    dselectRedBallValue: function () {
        var dredBall = "";
        $("#dxzhq cite.redBall").each(function () {
            dredBall += $(this).text() + ","
        });
        // dredBall = Xhc.reSort(dredBall.substring(0, dredBall.length - 1));
        return dredBall
    },
    tselectRedBallValue: function () {
        var tredBall = "";
        $("#txzhq cite.redBall").each(function () {
            tredBall += $(this).text() + ","
        });
        //tredBall = Xhc.reSort(tredBall.substring(0, tredBall.length - 1));
        return tredBall
    },
    dtselectBlueBallValue: function () {
        var dtblueBall = "";
        $("#dtxzlq cite.blueBall").each(function () {
            dtblueBall += $(this).text() + ","
        });
        // dtblueBall = Xhc.reSort(dtblueBall.substring(0, dtblueBall.length - 1));
        return dtblueBall
    },
    //根据投注号码数组里的号码来计算总注数和每一组号码的注数
    calNumberCount: function () {
        ballBox.count = 0;
        $(ballBox.numbers).each(function (k, v) {
            var inf = codeInfo(gameCode, ballBox.cur.type, v[0]);
            v.length < 3 ? v.push(inf.count) : v[2] = inf.count;
            ballBox.count += inf.count;
        });
    },
    //大小单双号码显示-传入数组
    convertNumberDisplay: function (numArray) {
        if (ballBox.cur.type == "DXDS") {
            var ret = new Array();
            $(numArray).each(function (k, v) {
                switch (v) {
                    case "1":
                        ret.push("小");
                        break;
                    case "2":
                        ret.push("大");
                        break;
                    case "4":
                        ret.push("双");
                        break;
                    case "5":
                        ret.push("单");
                        break;
                    default:
                        ret.push(v);
                }
            })
            return ret;
        } else {
            return numArray;
        }
    },
    //清空数据
    clean: function () {
        switch (gameCode) {
            case "SSQ":
            case "DLT":
                if (ballBox.cur.way == 1) {
                    $("#xzhq .ssqBall cite").removeClass("redBall");
                    $("#xzlq .ssqBall cite").removeClass("blueBall");
                    $("#BlueBallValue").attr("value", "");
                    $("#RedBallValue").attr("value", "");
                    ballBox.calNumber();

                } else {
                    $("#dxzhq cite").removeClass("redBall");
                    $("#txzhq cite").removeClass("redBall");
                    $("#dtxzlq cite").removeClass("blueBall");
                    $("#dRedBallValue").attr("value", "");
                    $("#tRedBallValue").attr("value", "");
                    $("#dtBlueBallValue").attr("value", "");
                    ballBox.calNumber();
                }
                break;
            case "FC3D":
            case "PL3":
                var n = $(".sdTab ul").find(".cur").attr("v");
                $("#" + n).find("b").removeClass("redBall");
                if (n == "zx") {
                    $("#" + n).find("li[m=y]").each(function () {
                        $(this).find("span").html($(this).attr("v"));
                        $(this).attr("class", "cur");
                    });
                }
                ballBox.calNumber();
                $("#deleted").html("机选");
                break;
            case "CQSSC":
                var n = $("#play_tabs li.cur").attr("val");
                $("#" + n).find("b").removeClass("red");
                $("#" + n).find("b").removeClass("red");
                $("#" + n).find("li[m=y]").each(function () {
                    $(this).find("span").html($(this).attr("v"));
                    $(this).attr("class", "cur");
                });
                $("#zs_ cite").html("0");
                break;
            case "JX11X5":
                $(".ssqBall cite").removeClass("redBall");
                ballBox.calNumber();
                break;
        }


    },
    //清除投注号码数组里无效数据
    cleanUp: function () {
        var ret = new Array();
        $(ballBox.numbers).each(function (k, v) {
            if (null != v[0] && null != v[1] && v[2] > 0) {
                ret.push(v);
            }
        });
        ballBox.numbers = ret;
    },
    //初始化玩法和号码选择区域
    init: function () {
        ballBox.initType();
    }
};
var c = {
    move_: function (star, end) {
        $("#c").show();
        var w = star.width();
        var h = star.height();
        var o = star.offset();
        var t = parseInt(o.top);
        var l = parseInt(o.left);
        $("body").append(c_);
        $("#c").css({
            left: l,
            top: t,
            width: w,
            height: h
        });
        var w_ = end.width();
        var h_ = end.height();
        var o_ = end.offset();
        var t_ = parseInt(o_.top);
        var l_ = parseInt(o_.left);
        t_ += h_ - h;
        l_ += (w_ - w) / 2;
        $("#c").animate({
            left: l_,
            top: t_
        },
            speed_,
            function () {
                $("#c").remove();
                var red = star.parent().find(".redBall");
                var cl_ = red.length;
                cl_ = cl_ > 8 && "cur2 jxssclist3" || cl_ > 4 && "cur2 jxssclist2" || cl_ > 0 && "cur2" || "cur";
                end.attr("class", cl_);
                var html = "";
                red.each(function () {
                    html += "<em>" + $(this).html() + "</em>"
                });
                end.find("span").html(html)
            })
    },
    remove_: function (star, end) {
        var red = star.parent().find(".redBall");
        var cl_ = red.length;
        cl_ = cl_ > 8 && "cur2 jxssclist3" || cl_ > 4 && "cur2 jxssclist2" || cl_ > 0 && "cur2" || "cur";
        end.attr("class", cl_);
        if (!red.length) {
            end.find("span").html(end.attr("v"))
        } else {
            var html = "";
            red.each(function () {
                html += "<em>" + $(this).html() + "</em>"
            });
            end.find("span").html(html)
        }
    },
    //机选
    Wobble: function () {
        curTime_2 = (new Date).getTime();
        switch (gameCode) {
            case "PL3":
            case "FC3D":
                var n = $(".sdTab ul").find(".cur").attr("v"),
                m1,
                m2,
                m3;
                sp = {
                    zx: "1500"
                }[n] || "500";
                if (curTime_2 - curTime_ > sp || f_Wobble == "0") {
                    f_Wobble++;
                    try {
                        navigator.vibrate(300);
                    } catch (e) {
                    }
                    ballBox.clean();
                    if (n == "zx") {
                        m1 = bet.Random(10)[5] - 1;
                        m2 = bet.Random(10)[7] - 1;
                        m3 = bet.Random(10)[2] - 1;
                        $("#" + n).find("div:eq(0)").find("b").eq(m1).click();
                        setTimeout(function () {
                            $("#" + n).find("div:eq(1)").find("b").eq(m2).click();
                        },
                        500);
                        setTimeout(function () {
                            $("#" + n).find("div:eq(2)").find("b").eq(m3).click();
                        },
                        1000);
                    } else if (n == "zs") {
                        m3 = bet.Random(10);
                        m1 = m3[7] - 1;
                        m2 = m3[2] - 1;
                        $("#" + n).find("div:eq(0)").find("b").eq(m1).addClass("redBall");
                        $("#" + n).find("div:eq(1)").find("b").eq(m2).addClass("redBall");
                    } else if (n == "hz") {
                        m1 = bet.Random(28)[12] - 1;
                        $("#" + n).find("b").eq(m1).addClass("redBall");
                    }else if (n == "zsbh") {
                        m1 = bet.Random(10)[5] - 1;
                        m2 = bet.Random(10)[7] - 1;
                        m3 = bet.Random(10)[2] - 1;
                        $("#" + n).find("b").eq(m1).addClass("redBall");
                        setTimeout(function () {
                                $("#" + n).find("b").eq(m2).addClass("redBall");
                            },
                            500
                        );

                    }else if (n == "zlbh") {
                        m1 = bet.Random(10)[5] - 1;
                        m2 = bet.Random(10)[7] - 1;
                        m3 = bet.Random(10)[2] - 1;
                        $("#" + n).find("b").eq(m1).addClass("redBall");
                        setTimeout(function () {
                                $("#" + n).find("b").eq(m2).addClass("redBall");
                            },500
                        );
                        setTimeout(function () {
                                $("#" + n).find("b").eq(m3).addClass("redBall");
                            },1000
                        );
                    }
                    ballBox.calNumber();
                    curTime_ = (new Date).getTime();
                }
                break;
            case "DLT":
            case "SSQ":
                if (curTime_2 - curTime_ > "1000") {
                    try {
                        navigator.vibrate(300);
                    } catch (e) {
                    }
                    nn = 0;
                    bb = 0;
                    var award = gameBallInfo.get(gameCode);
                    var number = award.arr_red.randomN(ballBox.cur.min).sort();
                    var bnumber = award.arr_blue.randomN(ballBox.cur.bluemin).sort();
                    $("#xzhq .ssqBall cite").removeClass("redBall");
                    $("#xzlq .ssqBall cite").removeClass("blueBall");
                    $("#RedBallValue").attr("value", "");
                    $("#RedBallValue").val(number);
                    $("#BlueBallValue").val(bnumber);
                    ballBox.numbers = (ballBox.cur.perch + number.join(",") + "|" + bnumber.join(","));
                    c.red_scale(number, bnumber);
                    curTime_ = (new Date).getTime();
                }
                break;
            case "CQSSC":
                var n = $(".sdTab ul").find(".cur").attr("v"),m1,m2,m3,m4,m5;
                sp = {zx: "1500"}[n] || "500";
                if (curTime_2 - curTime_ > sp || f_Wobble == "0") {
                    f_Wobble++;
                    try {
                        navigator.vibrate(300);
                    } catch (e) {
                    }
                    ballBox.clean();
                    if(n == "DXDS"){
                        m1 = bet.Random(4)[2] - 1;
                        m2 = bet.Random(4)[1] - 1;
                        $("#" + n+" .jxsscxhBall").find("div:eq(0)").find("b").eq(m1).click();
                        setTimeout(function () {
                                $("#" + n+" .jxsscxhBall").find("div:eq(1)").find("b").eq(m2).click();
                            },500
                        );
                    }
                    else if(n == "1XDX"){
                        m1 = bet.Random(10)[2] - 1;
                        $("#" + n).find("div:eq(0)").find("b").eq(m1).click();
                    }
                    else if(n == "2XDX"){
                        m1 = bet.Random(10)[5] - 1;
                        m2 = bet.Random(10)[8] - 1;
                        $("#" + n).find("div:eq(0)").find("b").eq(m1).click();
                        setTimeout(function () {
                                $("#" + n).find("div:eq(1)").find("b").eq(m2).click();
                            },500
                        );
                    }
                    else if(n == "3XDX"){
                        m1 = bet.Random(10)[5] - 1;
                        m2 = bet.Random(10)[7] - 1;
                        m3 = bet.Random(10)[2] - 1;
                        $("#" + n).find("div:eq(0)").find("b").eq(m1).click();
                        setTimeout(function () {
                                $("#" + n).find("div:eq(1)").find("b").eq(m2).click();
                            },
                            500);
                        setTimeout(function () {
                                $("#" + n).find("div:eq(2)").find("b").eq(m3).click();
                            },
                            1000);
                    }
                    else if(n == "5XDX" || n == "5XTX" ){
                        m1 = bet.Random(10)[5] - 1;
                        m2 = bet.Random(10)[7] - 1;
                        m3 = bet.Random(10)[2] - 1;
                        m4 = bet.Random(10)[6] - 1;
                        m5 = bet.Random(10)[3] - 1;
                        $("#" + n).find("div:eq(0)").find("b").eq(m1).click();
                        setTimeout(function () {
                                $("#" + n).find("div:eq(1)").find("b").eq(m2).click();
                            },300
                        );
                        setTimeout(function () {
                                $("#" + n).find("div:eq(2)").find("b").eq(m3).click();
                            },600
                        );
                        setTimeout(function () {
                                $("#" + n).find("div:eq(3)").find("b").eq(m4).click();
                            },900
                        );
                        setTimeout(function () {
                                $("#" + n).find("div:eq(4)").find("b").eq(m5).click();
                            },1200
                        );

                    }
                    else if(n == "2XZXFS" || n=="ZX3FS"){
                        m1 = bet.Random(10)[8] - 1;
                        m2 = bet.Random(10)[2] - 1;
                        $("#" + n).find("b").eq(m1).click();
                        setTimeout(function () {
                                $("#" + n).find("b").eq(m2).click();
                            },300
                        );
                    }
                    else if(n == "ZX6"){
                        m1 = bet.Random(10)[8] - 1;
                        m2 = bet.Random(10)[2] - 1;
                        m3 = bet.Random(10)[5] - 1;
                        $("#" + n).find("b").eq(m1).click();
                        setTimeout(function () {
                                $("#" + n).find("b").eq(m2).click();
                            },300
                        );
                        setTimeout(function () {
                                $("#" + n).find("b").eq(m3).click();
                            },300
                        );
                    }
                    else if (n == "2XHZ") {
                        m1 = bet.Random(18)[12] - 1;
                        $("#" + n).find("b").eq(m1).click();
                    }

                    ballBox.calNumber();
                    curTime_ = (new Date).getTime();
                }
                break;
            case "JX11X5":
                if (curTime_2 - curTime_ > "1000") {
                    try {
                        navigator.vibrate(300);
                    } catch (e) {
                    }
                    ballBox.clean();
                    var award = gameBallInfo.get(gameCode);
                    var number = award.arr_red.randomN(ballBox.cur.min).sort();
                    ballBox.numbers = number.join(",");
                    var n =
                {
                    "Q2ZHIX": "qe",
                    "Q3ZHIX": "qs"
                }[ballBox.cur.type] || "rx";
                    if (n == "qe") {
                        $("#" + n).find(".ssqBall:eq(0) cite:eq(" + (parseInt(number[0]) - 1) + ")").addClass("redBall");
                        $("#" + n).find(".ssqBall:eq(1) cite:eq(" + (parseInt(number[1]) - 1) + ")").addClass("redBall");
                    } else if (n == "qs") {
                        $("#" + n).find(".ssqBall:eq(0) cite:eq(" + (parseInt(number[0]) - 1) + ")").addClass("redBall");
                        $("#" + n).find(".ssqBall:eq(1) cite:eq(" + (parseInt(number[1]) - 1) + ")").addClass("redBall");
                        $("#" + n).find(".ssqBall:eq(2) cite:eq(" + (parseInt(number[2]) - 1) + ")").addClass("redBall");
                    } else {
                        for (var j = 0; j < number.length; j++) {
                            $("#" + n).find(".ssqBall cite:eq(" + (parseInt(number[j]) - 1) + ")").addClass("redBall");
                        }

                    }
                    ballBox.calNumber();
                    curTime_ = (new Date).getTime();
                }

                break;
        }

    },
    red_scale: function (redNum, blueNum) {
        if (nn < redNum.length) {
            setTimeout(function () {
                $("#xzhq .ssqBall cite").eq(redNum[nn] - 1).addClass("redBall");
                nn++;
                c.red_scale(redNum, blueNum);
            },
                    100);
        } else {
            if (bb < blueNum.length) {
                setTimeout(function () {

                    $("#xzlq .ssqBall cite").eq(blueNum[bb] - 1).addClass("blueBall");
                    bb++;
                    c.red_scale(redNum, blueNum);
                },
                            100);
            }
            ballBox.calNumber();
        }
    },
    code: function (n, zs) {
        var code = "",
            wf,
            c1 = "",
            gt = "",
            c2 = "",
            c3 = "";
        wf = {
            zx: "直选",
            hz: "和值",
            zs: "组三",
            zsbh: "组三包号",
            zlbh: "组六包号"
        }[n];
        if (n == "zx") {
            $("#" + n).find("div:eq(0)").find(".redBall").each(function () {
                c1 += $(this).html() + " "
            });
            c1 = c1.substr(0, c1.length - 1);
            $("#" + n).find("div:eq(1)").find(".redBall").each(function () {
                c2 += $(this).html() + " "
            });
            c2 = c2.substr(0, c2.length - 1);
            $("#" + n).find("div:eq(2)").find(".redBall").each(function () {
                c3 += $(this).html() + " "
            });
            c3 = c3.substr(0, c3.length - 1);
            gt = "FS";
            code = c1 + "," + c2 + "," + c3;
            code = "<p v=" + zs + " w=" + wf + ' gameType=' + gt + '><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>' + code + "</span><b>" + wf + " &nbsp;共" + zs + "注" + 2 * zs + "元</b></span></p>";
        } else if (n == "zs") {
            c1 = $("#" + n).find("div:eq(0)").find(".redBall").html();
            c2 = $("#" + n).find("div:eq(1)").find(".redBall").html();
            gt = "ZX3DS";
            code = c1.split("") + "," + c2;
            code = "<p v=" + zs + " w=" + wf + ' gameType=' + gt + '><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>' + code + "</span><b>" + wf + " &nbsp;共" + zs + "注" + 2 * zs + "元</b></span></p>";
        } else if (n == "hz") {
            gt = "HZ";
            $.each(ballBox.numbers, function (i, item) {
                var iType = typeInfo(gameCode, gt);
                code += "<p v=" + item[2] + " w=" + wf + ' gameType=' + gt + '><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>' + item[0] + "</span><b>" + wf + " &nbsp;共" + item[2] + "注" + (2 * item[2]) + "元</b></span></p>";
            });
        }

        return code;
    },
    code1: function (n, zs) {
        var Ball = "";
        if (n == "DXDS") {
            Ball += $("#" + n).find("div.jxsscxhBall").find("div:eq(0)").find(".red").html() + " ";
            Ball += $("#" + n).find("div.jxsscxhBall").find("div:eq(1)").find(".red").html();
            Ball += "_大小单双_" + zs;
        } else if (n == "1XDX") {
            $("#" + n).find("b.red").each(function () {
                //Ball += $(this).html() + " ";
                Ball += $(this).html();
            });

            //Ball = Ball.substring(0, Ball.length - 1);

            Ball += "_一星单选_" + zs;
        } else if (n == "2XDX") {
            $("#" + n).find("div:eq(0)").find(".red").each(function () {
                Ball += $(this).html() + ""
            });
            Ball += " ";
            $("#" + n).find("div:eq(1)").find(".red").each(function () {
                Ball += $(this).html() + ""
            });
            Ball += "_二星单选_" + zs;
        } else if (n == "3XDX") {
            $("#" + n).find("div:eq(0)").find(".red").each(function () {
                Ball += $(this).html() + ""
            });
            Ball += " ";
            $("#" + n).find("div:eq(1)").find(".red").each(function () {
                Ball += $(this).html() + ""
            });
            Ball += " ";
            $("#" + n).find("div:eq(2)").find(".red").each(function () {
                Ball += $(this).html() + ""
            });
            Ball += "_三星单选_" + zs;
        } else if (n == "5XDX" || n == "5XTX") {
            $("#" + n).find("div:eq(0)").find(".red").each(function () {
                Ball += $(this).html() + ""
            });
            Ball += " ";
            $("#" + n).find("div:eq(1)").find(".red").each(function () {
                Ball += $(this).html() + ""
            });
            Ball += " ";
            $("#" + n).find("div:eq(2)").find(".red").each(function () {
                Ball += $(this).html() + ""
            });
            Ball += " ";
            $("#" + n).find("div:eq(3)").find(".red").each(function () {
                Ball += $(this).html() + ""
            });
            Ball += " ";
            $("#" + n).find("div:eq(4)").find(".red").each(function () {
                Ball += $(this).html() + ""
            });
            Ball += (n == "5XDX" ? "_五星单选_" : "_五星通选_") + zs;
        } else if (n == "2XZXFS") {
            $("#" + n).find("b.red").each(function () {
                Ball += $(this).html() + " ";
            });
            Ball = Ball.substring(0, Ball.length - 1);
            Ball += "_二星组选复式_" + zs;
        } else if (n == "ZX3FS") {
            $("#" + n).find("b.red").each(function () {
                Ball += $(this).html() + " ";
            });
            Ball = Ball.substring(0, Ball.length - 1);
            Ball += "_组选3_" + zs;
        }
        else if (n == "ZX6") {
            $("#" + n).find("b.red").each(function () {
                Ball += $(this).html() + " ";
            });
            Ball = Ball.substring(0, Ball.length - 1);
            Ball += "_组选6_" + zs;
        }
        Ball = Ball.replace(/ /g, ",");
        return n + "_" + Ball;
    },
    code2: function (n, zs, h) {
        var codes = [], str = "";
        var k = {
            "Q3ZHIX": "qs",
            "Q2ZHIX": "qe"
        }[n] || "rx";
        if (k == "qs" || k == "qe") {
            $("#" + k).find(".relative").each(function () {
                var code = [];
                $(this).find(".ssqBall .redBall").each(function () {
                    code.push($(this).html());
                });
                codes.push(code.join(" "));
            });
        } else {
            $(".ssqBall .redBall").each(function () {
                codes.push($(this).html());
            });

        }
        str = n + "_" + codes.join(",") + "_" + h + "_" + zs;

        //str = '<div class="ssqtzNum" gameType="' + n + '" v=' + zs + ' w="' + h + '"><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>' + codes.join(",") + "</span><p>" + h + " &nbsp;&nbsp;&nbsp;" + zs + "注" + 2 * zs + "元</p></span></div>";
        return str;
    }
};
//开奖处理

var betTime = {
    //投注锁，锁定时停止取数据,true为锁定
    block: false,
    period: null, //当前期号
    stoptime: 0, //停售时间
    time: 0, //投注截止时间
    awardtime: 0, //开奖截止时间
    continueCountDownFlag: false,
    isturnball: false,
    init: function () {
        //        betTime.updateAward();
        betTime.loadTime();
        betTime.lastData();

    },
    //截止投注时间
    loadTime: function () {
        $.getJSON("/buy/curissuse/" + gameCode + "?ref=loadTime&r=" + Math.random().toFixed(5), function (data) {
            betTime.Time(data);
        });
    },

    //下期处理
    next: function () {
        setTimeout("betTime.loadTime()", 1000 * 10);

        if (this.isturnball) {
            this.isturnball = false;
            setTimeout("betTime.lastData()", 1000 * 10);
            betTime.updateAward();
        }
    },
    //投注倒计时处理
    outTime: function () {
        if (betTime.time < 1) {
            if (!betTime.continueCountDownFlag) {
                betTime.continueCountDownFlag = true;
                betTime.continueCountDown();
            }
            betTime.next();
        } else {
            betTime.time = betTime.time - 1;
            betTime.awardtime = betTime.awardtime - 1;
            setTimeout("betTime.outTime()", 1000);

            $(".k3kjnum>strong").html(this.timeFormatting(betTime.time));

            if (betTime.continueCountDownFlag) {
                clearTimeout(betTime.continueCountDown);
                betTime.continueCountDownFlag = false;

            }
        }
    },
    continueCountDown: function () {
        if (betTime.time < 1 && betTime.awardtime > 0) {
            betTime.awardtime = betTime.awardtime - 1;
            setTimeout("betTime.continueCountDown()", 1000);
            //var str = betTime.awardtime.toLeftTimeString();
            $(".k3kjnum>strong").html(this.timeFormatting(betTime.awardtime));
            $(".k3kjnum>strong").css("color", "red");
        } else {
            $(".k3kjnum>strong").removeAttr("style");
        }

    },
    Time: function (data) {
        betTime.period = data.issuse;
        betTime.stoptime = stringToDateTime(data.stoptime);
        betTime.time = data.bettime;
        betTime.awardtime = data.awardtime;
        switch (gameCode) {
            case "SSQ":
            case "DLT":
                $(".cp_" + gameCode.toLowerCase()).html(betTime.period.split('-')[1] + "期  " + betTime.stoptime.toFormatString("MM-dd HH:mm") + "  截止");
                break;
            case "FC3D":
            case "PL3":
                $("#c_expect").html(parseInt(betTime.period.split('-')[1]));
                break;
            case "CQSSC":
            case "JX11X5":
                $("#c_expect").html(parseInt(betTime.period.split('-')[1]));
                setTimeout("betTime.outTime()", 100);
                break;
        }

    },
    //开奖公告更新
    lastData: function (pageNo, pageSize) {
        var gametype = gameCode;
//        pageNo = pageNo ? pageNo : 0;
//        pageSize = pageSize ? pageSize : 10;
        var h = [];
        $.getJSON("/jsonData/lottery_new_open_list_" + gametype + ".json?r" + Math.random(), function (data) {
            if (data.length > 0) {
                switch (gameCode) {
                    case "SSQ":
                    case "DLT":
                        $.each(data, function (idx, it) {
                            h[h.length] = " <ul><li class=\"first\">" + it.IssuseNumber.split('-')[1] + "期</li><li><span class=\"red\">" + it.WinNumber.split('|')[0].replace(/,/g, "  ") + "</span>  <span class=\"blue\">" + it.WinNumber.split('|')[1] + "</span></li></ul>";
                        });
                        break;
                    case "FC3D":
                    case "PL3":
                        $.each(data, function (idx, it) {
                            if (idx == 0) {
                                $("#kj_").html(it.WinNumber.replace(/,/g, "  "));
                            } else {
                                var c = it.WinNumber.replace(/,/g, "  "), t;
                                if (c) {
                                    c = c.split("  ");
                                    if (c[0] == c[1] && c[0] == c[2] && c[1] == c[2]) {
                                        t = "豹子";
                                    } else if (c[0] == c[1] || c[0] == c[2] || c[1] == c[2]) {
                                        t = "组三";
                                    } else {
                                        t = "组六";
                                    }
                                }
                                h[h.length] = "<ul><li class=\"wb20\">" + it.IssuseNumber.split('-')[1] + "期</li><li class=\"wb16 red\">" + it.WinNumber.replace(/,/g, "  ") + "</li><li class=\"wb21\">" + t + "</li></ul>";
                            }
                        });
                        break;
                    case "CQSSC":
                        $.each(data, function (idx, it) {
                            var num = it.WinNumber.split(',');
                            h[h.length] = "<ul><li class=\"wb20\">" + it.IssuseNumber.split('-')[1] + "期</li><li class=\"jxsscdice jxsscwb18\">";
                            $.each(num, function (k, v) {

                                h[h.length] = "<b >" + v + "</b>";
                            });

                            h[h.length] = "</li><li class=\"wb21\">" + betTime.c_(num[3]) + "</li>";
                            h[h.length] = "<li class=\"wb21\">" + betTime.c_(num[4]) + "</li><li class=\"wb19\">" + betTime.cc_(num[2], num[3], num[4]) + "</li></ul>";
                        });
                        break;
                    case "JX11X5":
                        $.each(data, function (idx, it) {
                            h[h.length] = '<ul><li class="first">' + it.IssuseNumber.split('-')[1] + '期</li><li><span class="red">' + it.WinNumber.replace(/,/g, "  ") + '</span></li><li class="last"></li></ul>';
                        });
                        break;
                }
                $("." + gametype.toLowerCase() + "kjlist").html(h.join("").toString());
            }
        });
    },
    timeFormatting: function (time) {
        var d = parseInt(time / 60 / 60 / 24, 10);
        var h = parseInt(time / 60 / 60 % 24, 10);
        var m = parseInt(time / 60 % 60, 10);
        var s = time % 60;
        d = d > 0 ? d.toString() : "0" + d.toString();
        h = h > 9 ? h.toString() : "0" + h.toString();
        m = m > 9 ? m.toString() : "0" + m.toString();
        s = s > 9 ? s.toString() : "0" + s.toString();
        var tm = parseInt(d) * 24 * 60 + parseInt(h) * 60 + parseInt(m);
        if (m == 0 && s == 0) {
            return ("已截止");
        } else {
            return (tm + ":" + s);
        }
    },
    c_: function (x) {
        var a = "";
        if (x > 4) {
            if (x % 2 == 0) {
                a = "大双";
            } else {
                a = "大单";
            }
        } else {
            if (x % 2 == 0) {
                a = "小双";
            } else {
                a = "小单";
            }
        }
        return a
    },
    cc_: function (x, o, y) {
        var a = "";
        if (x == o && x == y && o == y) {
            a = "豹子";
        } else {
            if (x == o || x == y || o == y) {
                a = "组三";
            } else {
                a = "组六";
            }
        }
        return a
    }
};

//摇一摇
var SHAKE_THRESHOLD = 500;
var last_update = 0;
var x = y = z = last_x = last_y = last_z = 0;
function deviceMotionHandler(eventData) {
    var i = eventData.accelerationIncludingGravity;
    var curTime = new Date().getTime();
    if ((curTime - last_update) > 200) {
        var diffTime = curTime - last_update;
        last_update = curTime;
        x = i.x;
        y = i.y;
        z = i.z;
        var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 1e4;

        if (speed > SHAKE_THRESHOLD) {
            if ($("#shake").is(":visible")) {
                c.Wobble();
            }
        }
        last_x = x;
        last_y = y;
        last_z = z;
    }
}

$(function () {
    ballBox.init();
    betTime.init();
    if (window.DeviceMotionEvent) {
        window.addEventListener('devicemotion', deviceMotionHandler, false);
    }
});

//浏览器变化，
jQuery(window).resize(function () {

    if (gameCode == "PL3" || gameCode == "FC3D") {
        ballBox.initPlayType();
    }
});