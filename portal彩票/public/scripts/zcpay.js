var ponum = localStorage.getItem(gameCode.toLowerCase() + gametype.toLowerCase() + "_PollNum");
var hemai = {
    isHemai: false,
    //初始化追号对象
    init: function () {
        hemai.isHemai = true;
    }
};
var jc = {
    amount: 0,
    totalMoney: 0,
    AmountPay: 0,
    isDg:false,
    initail: function () {
        if (ponum == null || ponum == "") {
            location.go(-1);
            //alert("/buy/" + jc.getFhref(gameCode.toLowerCase()))
            //window.location = "/buy/" + jc.getFhref(gameCode.toLowerCase());
        } else {
            var isDg = decodeURIComponent(CP.Util.getParaHash("isDg"));
            if (isDg && isDg == "1") {
                jc.isDg = true;
            }
            jc.firstStep();
            jc.Show();
        }
        $("#slideLoop").bind("click", function () {
            $(this).toggleClass("downHover");
            $("#updownContent").slideToggle(400);
        });
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

    },
    firstStep: function () {
        var notes = decodeURIComponent(CP.Util.getParaHash("notes"));
        var multiple = decodeURIComponent(CP.Util.getParaHash("multiple"));
        var cMoney = decodeURIComponent(CP.Util.getParaHash("countMoney"));
        var pattern = decodeURIComponent(CP.Util.getParaHash("pattern"));
        var issues = decodeURIComponent(CP.Util.getParaHash("issues"));
        if (issues) $("#slideLoop p:eq(0) cite:eq(1)").html("第" + issues + "期");
        jc.amount = multiple;
        jc.totalMoney = cMoney; //总金额
        jc.AmountPay = cMoney; //应付金额
        if (pattern == 1) {
            hemai.init();
            var rg = decodeURIComponent(CP.Util.getParaHash("rg"));
            var bd = decodeURIComponent(CP.Util.getParaHash("bd"));
            var z = parseInt(rg) + parseInt(bd);
            jc.AmountPay = z;//应付金额
            $("#slideLoop p:eq(1) cite").html(z);
            $("#updownContent p:eq(0) cite").html("方案总额" + cMoney + "元,认购" + rg + "元,保底" + bd + "元(" + notes + "注" + multiple + "倍)");
        } else {

            $("#slideLoop p:eq(1) cite").html(cMoney);
            $("#updownContent p:eq(0) cite").html(notes + "注" + multiple + "倍");
        }

        var chuan = ponum.split('|')[1];
        if (!chuan) {
            $("#updownContent div:eq(0)").remove();
        } else {
            var gg = chuan == "1_1" ? "单关" : chuan.replace(/\_/g, "串");
            $("#mp_content").html("&nbsp;" + gg);

        }
        if ($("#rgspn").length == 1) {
            var maxbanlance = $("#maxbanlance");
            var ratio = maxbanlance.attr("data-ratio");
            maxbanlance.html((cMoney * ratio).toFixed(2));
        }
    },
    delyObj: function () {
        if (!ponum) {
            return location.href = "/";
        }
        var totalMoney = jc.totalMoney;
        var matchcount, playtype, matchlist;
        var issuse = decodeURIComponent(CP.Util.getParaHash("issues"));
        var sp_ = ponum.split('|');
        if (sp_.length == 2) {
            //比赛场数
            matchlist = gametype.toLowerCase() == "hh" ? ponum.split('|')[0].split('#') : ponum.split('|')[0].split(',');
            matchcount = matchlist.length;
            //玩法2_1
            playtype = ponum.split('|')[1].split(',');
        } else {
            Box.alert("投注内容不正确，请重新投注");
        }

        var chuan = [];
        for (var i = 0; i < playtype.length; i++) {
            chuan.push(playtype[i]);
        }
        var betObj = {
            game: gameCode.toLowerCase(),
            stopTime: "",
            playType: chuan.join(','),
            gameType: gametype.toLowerCase(),
            issuseNumber: issuse.length > 0 ? issuse : "",
            antecode: "",
            amount: jc.amount,
            totalMoney: totalMoney,
            matchcount: matchcount,
            activityType: "2",
            rbmoney: $("#kybanlance").val()
        };
        var code = [], codes = [], dan = false, selectedcode = [], matchid;

        if (jc.isDg) {
            betObj.attach = localStorage.getItem("ItemAttch");
            betObj.orgMoney = betObj.attach != "" || betObj.attach != null ? betObj.attach.split(',').length * 2 : 0;
            betObj.hhdg = true;
        }
        if (gametype.toLowerCase() == "hh") {
            code = ponum.split('|')[0].replace(/-/g, "|");
            codes = code;
            betObj.antecode = codes;
        } else {
            selectedcode = matchlist;
            $.each(selectedcode, function(j, k) {
                matchid = k.split('=')[0];
                code = k.split('=')[1].replace(/\//g, ",");
                codes.push(dan + "|" + matchid + "|" + code + "|" + gametype.toLowerCase() + "");
            });
            betObj.antecode = codes.join("#");
        }
        //资金密码
        betObj.balancepwd = $("#pwd").val();
        //方案保密性
        var ser = 1;
        if (decodeURIComponent(CP.Util.getParaHash("isPublic"))) {
            ser = decodeURIComponent(CP.Util.getParaHash("isPublic"));
        }
        betObj.sercurity = ser;
        if (hemai.isHemai) {
            betObj.rbmoney = 0;
            var splitCount = totalMoney;
            var splitper = splitCount > 0 ? totalMoney / splitCount : 0;
            var rg = decodeURIComponent(CP.Util.getParaHash("rg"));
            var bd = decodeURIComponent(CP.Util.getParaHash("bd"));
            var wrate = decodeURIComponent(CP.Util.getParaHash("wrate"));

            var hm = {
                isHemai: true,
                totalCount: splitCount,
                price: splitper,
                subscription: rg,
                guarantees: bd,
                bonusdeduct: wrate,
                joinpwd: ""
            };
            //添加了标题和描述，必填字段
            var title = decodeURIComponent(CP.Util.getParaHash("title"));
            if (title == "") {
                hm.title = title;
            } else {
                if (title.length > 20) {
                    hm.title = title.substring(0, 20);
                } else {
                    hm.title = title;
                }
            }

            var description = decodeURIComponent(CP.Util.getParaHash("xyText"));
            if (description == "") {
                hm.description = title;
            } else {
                if (description.length > 150) {
                    hm.description = description.substring(0, 150);
                } else {
                    hm.description = description;
                }
            }
            $.extend(betObj, hm);

        }
        return betObj;
    },
    submit: function () {
        $("#pay").addClass("payment_disabled");
        var betObj = jc.delyObj();
        var url = jc.isDg ? "/buy/OptSportBuy" : "/buy/bet_sports";
        function callback(result) {
            $("#pay").removeClass("payment_disabled");
            if (result.IsSuccess) {
                localStorage.removeItem(gameCode.toLowerCase() + gametype.toLowerCase() + "_PollNum");
                localStorage.removeItem(gameCode.toLowerCase() + gametype.toLowerCase() + "_SelectNum");
                if (jc.isDg)localStorage.removeItem("ItemAttch");
                var value = result.ReturnValue;
                var msg = "<div style='text-align:left;padding:0 0.2rem 0 0.4rem'><b class='big yellow'>您的方案已提交成功！</b><br/>方案编号：<a class='blue under' href='/user/scheme/" + result.ReturnValue.split("|")[0] + "' target='_black'>" + result.ReturnValue.split("|")[0] + "</a><br/><br/><em class='gray'>提示：您可以在会员中心查看订单。</em></div>";
                Box.alert(msg,
                    function() {
                        window.location.href = "/buy/buysuccess/" + gameCode.toLowerCase() + "?ReturnValue=" + value;
                    });
            } else {
                if (result.Message == "Repeat") {
                    Box.confirm("检测到投注内容重复，您确定要再次购买吗？", function () {
                        betObj.IsRepeat = true;
                        $.post(url, betObj, function(result2) {
                            callback(result2);
                        });
                    });
                } else {
                    Box.alert(result.Message);
                }

            }
        }
        $.post(url, betObj, function (result) {
            callback(result);
        });
    },
    ctzqsubmit: function () {
        $("#pay").addClass("payment_disabled");
        var issuse = decodeURIComponent(CP.Util.getParaHash("issues"));
        var bs = decodeURIComponent(CP.Util.getParaHash("multiple"));
        var totalmoney = decodeURIComponent(CP.Util.getParaHash("countMoney"));
        totalmoney = parseInt(totalmoney);
        bs = parseInt(bs);
        var isUpload = false;
        //投注对象
        var betObj = {
            GameCode: gameCode.toLowerCase(),
            isUpload: isUpload,
            gameType: gametype.toLowerCase(),
            IssuseNumber: issuse + "|" + bs + "|" + totalmoney,
            Number: "",
            amount: bs,
            totalMoney: totalmoney,
            activityType: "2",
            rbmoney: $("#kybanlance").val()
        };
        var codes = [], li, dans = [];
        var selectedCode = ponum.split(',');
        $.each(selectedCode, function (k, v) {

            codes.push(v.replace(";b:", ",").split("=")[1].replace(/\//g, ""));
        });
        betObj.Number = gametype + "." + codes.join(",") + (dans.length > 0 ? "|" + dans.join(",") : "");
        //方案保密性
        var ser = 1;
        if (decodeURIComponent(CP.Util.getParaHash("isPublic"))) {
            ser = decodeURIComponent(CP.Util.getParaHash("isPublic"));
        }
        betObj.sercurity = ser;
        //资金密码
        betObj.balancepwd = $("#pwd").val();
        if (hemai.isHemai) {
            betObj.rbmoney = 0;
            var splitCount = totalmoney;
            var splitper = splitCount > 0 ? totalmoney / splitCount : 0;
            var rg = decodeURIComponent(CP.Util.getParaHash("rg"));
            var bd = decodeURIComponent(CP.Util.getParaHash("bd"));
            var wrate = decodeURIComponent(CP.Util.getParaHash("wrate"));
            var hm = {
                isHemai: true,
                totalCount: splitCount,
                price: 1,
                subscription: rg,
                guarantees: bd,
                bonusdeduct: wrate,
                joinpwd: ""
            };
            //添加了标题和描述，必填字段
            var title = decodeURIComponent(CP.Util.getParaHash("title"));
            if (title == "") {
                hm.title = " 一起玩,一起中大奖";
            } else {
                if (title.length > 20) {
                    hm.title = title.substring(0, 20);
                } else {
                    hm.title = title;
                }
            }
            var description = decodeURIComponent(CP.Util.getParaHash("xyText"));
            if (description == "") {
                hm.description = "一起玩，一起中大奖";
            } else {
                if (description.length > 150) {
                    hm.description = description.substring(0, 150);
                } else {
                    hm.description = description;
                }
            }
            $.extend(betObj, hm);
        }

        function callback(result) {
            $("#pay").removeClass("payment_disabled");
            if (result.IsSuccess) {
                localStorage.removeItem(gameCode.toLowerCase() + gametype.toLowerCase() + "_PollNum");
                localStorage.removeItem(gameCode.toLowerCase() + gametype.toLowerCase() + "_SelectNum");
                var value = result.ReturnValue;
                var msg = "<div style='text-align:left;padding:0 0.2rem 0 0.4rem'><b class='big yellow'>您的方案已提交成功！</b><br/>方案编号：<a class='blue under' href='/user/scheme/" + result.ReturnValue.split("|")[0] + "' target='_black'>" + result.ReturnValue.split("|")[0] + "</a><br/><br/><em class='gray'>提示：您可以在会员中心查看订单。</em></div>";
                Box.alert(msg,
                    function() {
                        window.location.href = "/buy/buysuccess/" + gameCode.toLowerCase() + "?ReturnValue=" + value;
                    });
            } else {
                if (result.Message == "Repeat") {
                    Box.confirm("检测到投注内容重复，您确定要再次购买吗？", function () {
                        betObj.IsRepeat = true;
                        $.post("/buy/order", betObj, function (result2) {
                            callback(result2);
                        });
                    });
                } else {
                    Box.alert(result.Message);
                    return;
                }
            }
        }

        $.post("/buy/order", betObj, function (result) {
            callback(result);
        });
    },
    Show: function () {
        var yue = Number($("#hideyue").attr("value"));
        var needmoney = jc.AmountPay;
        if (yue >= needmoney) {
            $("#pay").show();
            $("#cz").hide();
            $("#chae").parent().hide();
            $("#recharge").hide();
        } else {
            $("#cz").show();
            $("#pay").hide();
            $("#chae").parent().show();
            var ce = Math.ceil(needmoney - (yue));
            $("#chae").html(ce);
        }

    }
};

$(function () {
    jc.initail();
    $("#pay").unbind("click").bind("click", function (event) {
        if ($(this).hasClass("payment_disabled")) return false;
        switch (gameCode.toLowerCase()) {
            case "jczq":
            case "jclq":
            case "bjdc":
                jc.submit();
                break; ;
            case "ctzq":
                jc.ctzqsubmit();
                break; ;
        }
    });
});
