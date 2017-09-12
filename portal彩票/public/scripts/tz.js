var GetLength = function() {
    var Ballinfo = {
        SelectedLength_r: 0,
        MaxBallLength_r: 0,
        SelectedLength_b: 0,
        MaxBallLength_b: 0
    }
    switch (gameCode) {
        case "SSQ":
            Ballinfo.SelectedLength_r = 6;
            Ballinfo.MaxBallLength_r = 33;
            Ballinfo.SelectedLength_b = 1;
            Ballinfo.MaxBallLength_b = 16;
            break;
        case "DLT":
            Ballinfo.SelectedLength_r = 5;
            Ballinfo.MaxBallLength_r = 35;
            Ballinfo.SelectedLength_b = 2;
            Ballinfo.MaxBallLength_b = 12;
            break;
    }
    return Ballinfo;
};
var lottery = {
    award: {},
    init: function() {
        this.award = gameBallInfo.get(gameCode);
    }
};
//双色球大乐透
var tz = {
    //大乐透追加时为2元+1元
    singleBetMoney:2,
    sum: "",
    //投注号码
    number: new Array(),
    //总注数
    sumcount: 0,
    //倍数
    amount: 0,
    //总金额
    summoney: 0,
    type: "",
    init_info: function () {
        $("#againtz").removeAttr("checked");
        tz.loadCont();
        tz.bindEvent();
        tz.loadFun()
    },
    loadFun: function () {
        if (parseInt($("input[name='qs']").val()) == 0) {
            $(".zjStop").hide();
        } else if (parseInt($("input[name='qs']").val()) > 1) {
            if (parseInt($("input[name='qs']").val()) <= 100) {
                $(".fqhm").attr("disabled", true);
                $(".fqhm").addClass("fqhmGray");
                $(".fqhm").removeClass("fqhm");
                $(".zjStop").show();
                $(".ssqzh").show();
            } else {
                Box.alert("最多只能追100期", function () {
                    $("input[name='qs']").val("100");
                    $(".ssqzh").show();
                    tz.loadMoney();
                });

            }
        } else if (parseInt($("input[name='qs']").val()) == 1) {
            $("#fqhm").attr("disabled", false);
            $("#fqhm").removeClass("fqhmGray");
            $("#fqhm").addClass("fqhm");
            $(".zjStop").hide();
            $(".ssqzh").hide();
        }
        tz.loadMoney();
    },
    bindEvent: function () {
        //机选一注
        $("#jxbtn").bind("click", function () {
                CC.machineSelect();
                var antecode = localStorage.getItem(gameCode);
                if (!antecode) {
                    antecode = "";
                    var jxred = $("#Red_BallValue").val();
                    var tjxred = jxred.replace(/,/g, " ");
                    tjxred = $.trim(tjxred);
                    var jxblue = $("#Blue_BallValue").val();
                    var tjxblue = jxblue.replace(/,/g, " ");
                    tjxblue = $.trim(tjxblue);
                    var tmpstr = antecode + "#" + tz.type + "." + jxred + "|" + jxblue;
                    localStorage.setItem(gameCode, tmpstr.substring(1, tmpstr.length))
                } else {
                    var jxred = $("#Red_BallValue").val();
                    var tjxred = jxred.replace(/,/g, " ");
                    tjxred = $.trim(tjxred);
                    var jxblue = $("#Blue_BallValue").val();
                    var tjxblue = jxblue.replace(/,/g, " ");
                    tjxblue = $.trim(tjxblue);
                    var tmpstr = antecode + "#" + tz.type + "." + jxred + "|" + jxblue;
                    localStorage.setItem(gameCode, tmpstr);
                }
                var obdiv = '<div class="ssqtzNum" gametype=' + tz.type + '><cite class="errorBg"><em class="error2"></em></cite><span><em>' + tjxred + "</em><cite>" + tjxblue + "</cite></span><p>普通投注&nbsp;&nbsp;&nbsp;1注2元</p></div>";
                $(".ssqNum").append(obdiv);
                tz.loadMoney();
                $(".error2").bind("click",
                    function() {
                        $(this).parents("div.ssqtzNum").remove();
                        var str = tz.joinValue();
                        localStorage.setItem(gameCode, str);
                        tz.loadMoney();
                    });
            });
        $("input[name='bs']").bind("keyup", function() {
            var val = $(this).val();
            var reg = /^\d*$/;
            if (!reg.test(val)) {
                $(this).val("1");
            }
            if (val.indexOf("0") == 0) {
                $(this).val("1");
            }
            if (parseInt(val) > 0) {
                if (parseInt($("input[name='bs']").val()) > 99999) {
                    Box.alert("最多只能投99999倍", function() {
                        $("input[name='bs']").val("99999");
                        tz.loadMoney();
                    });
                } else {
                    tz.loadMoney();
                }
            }
        });
        $("input[name='qs']").bind("keyup", function() {
            var val = $(this).val();
            var reg = /^\d*$/;
            if (!reg.test(val)) {
                $(this).val("1");
            }
            if (val == "") {
                $(this).val("");
            }
            if (val.indexOf("0") == 0) {
                $(this).val("1");
            }
            if (parseInt($("input[name='qs']").val()) == 0) {
                $(".zjStop").hide();
            } else if (parseInt($("input[name='qs']").val()) > 1) {
                if (parseInt($("input[name='qs']").val()) <= 100) {
                    $(".fqhm").attr("disabled", true);
                    $(".fqhm").addClass("fqhmGray");
                    $(".zjStop").show();
                    $(".ssqzh").show();
                    tz.loadMoney();
                } else {
                    Box.alert("最多只能追100期", function() {

                        $("input[name='qs']").val("100");
                        $(".ssqzh").show();
                        $(".fqhm").attr("disabled", true);
                        tz.loadMoney();
                    });
                }
            } else if (parseInt($("input[name='qs']").val()) == 1) {
                $("#fqhm").attr("disabled", false);
                $("#fqhm").removeClass("fqhmGray");
                $("#fqhm").addClass("fqhm");
                $(".zjStop").hide();
                $(".ssqzh").hide();
                tz.loadMoney();
            }

        });
        $("input[name='bs']").blur(function() {
            if ($(this).val() == "" || parseInt($(this).val()) == 0) {
                $(this).val("1");
                tz.loadMoney();
            }
        });
        $("input[name='qs']").blur(function() {
            if ($(this).val() == "" || parseInt($(this).val()) == 0) {
                $(this).val("1");
                tz.loadMoney();
            }
        });
        //清空所有号码
        $("#clearAll").bind("click",function () {
            localStorage.removeItem(gameCode);
            $(".ssqNum").html("");
            Box.tx("请至少选择一注进行投注");
            tz.loadMoney();
        });
        //追号期数加减
        $(".qplus").bind("click",function () {
            $(".ssqzh li").removeClass("cur");
            var p = parseInt($("input[name='qs']").val());
            p++;
            $("input[name='qs']").val(p);
            tz.loadMoney();
            if ($("input[name='qs']").val() == 1) {
                $(".zjStop").hide();
                $(".ssqzh").hide();
                $("#fqhm").attr("disabled", false);
                $("#fqhm").removeClass("fqhmGray");
                if (!$("#fqhm").hasClass("fqhm")) {
                    $("#fqhm").addClass("fqhm");
                }
            } else if ($("input[name='qs']").val() > 1 && $("input[name='qs']").val() <= 100) {
                $(".zjStop").show();
                $(".ssqzh").show();
                $("#fqhm").attr("disabled", true);
                $("#fqhm").addClass("fqhmGray");
            } else {
                Box.alert("最多只能追100期", function () {
                    $("input[name='qs']").val("100");
                    tz.loadMoney();
                });

            }
        });
        $(".qminus").bind("click", function () {
            $(".ssqzh li").removeClass("cur");
            var p = parseInt($("input[name='qs']").val());
            p--;
            if (p < 1) {
                p = 1;
                $("#fqhm").removeClass("fqhmGray")
            }
            $("input[name='qs']").val(p);
            tz.loadMoney();
            if ($("input[name='qs']").val() == 1) {
                $(".zjStop").hide();
                $(".ssqzh").hide();
                $("#fqhm").removeClass("fqhmGray");
                $("#fqhm").removeAttr("disabled");
                if (!$("#fqhm").hasClass("fqhm")) {
                    $("#fqhm").addClass("fqhm");
                }
            } else {
                $(".zjStop").show();
                $(".ssqzh").show();
                $("#fqhm").attr("disabled", true)
                $("#fqhm").addClass("fqhmGray");
            }
        });
        //投注倍数加减
        $(".bplus").bind("click",
            function () {
                var b = parseInt($("input[name='bs']").val());
                b++;
                $("input[name='bs']").val(b);
                if (parseInt($("input[name='bs']").val()) > 99999) {
                    Box.alert("最多只能投99999倍")
                }
                tz.loadMoney()
            });
        $(".bminus").bind("click",
            function () {
                var b = parseInt($("input[name='bs']").val());
                b--;
                if (b < 1) {
                    b = 1
                }
                $("input[name='bs']").val(b);
                tz.loadMoney()
            });
        //追号期数
        $(".ssqzh li").bind("click",
            function () {
                $(this).toggleClass("cur");
                $(this).siblings().removeClass("cur");
                var q = $(this).attr("q");
                $("input[name='qs']").val(q);
                tz.loadMoney();
                if ($("input[name='qs']").val() == 1) {
                    $(".zjStop").hide();
                    $(".fqhm").attr("disabled", false);
                    $(".fqhm").removeClass("fqhmGray")
                } else {
                    $(".zjStop").show();
                    $(".fqhm").attr("disabled", true);
                    $(".fqhm").addClass("fqhmGray")
                }
            });
        //中奖后停止追号
        var zflag = 1;
        $(".zjStop em").bind("click",
            function () {

                if ($(this).hasClass("check")) {
                    $(this).removeClass("check");
                    $(this).addClass("nocheck");
                    zflag = 0
                } else {
                    $(this).removeClass("nocheck");
                    $(this).addClass("check");
                    zflag = 1
                }
            });
        //提交
        $("#pay").bind("click", function () {
            if ($(this).hasClass("true_disabled")) return;
            var q, b, z, j, bk, zflag, playId;
            q = parseInt($("input[name='qs']").val());
            b = parseInt($("input[name='bs']").val());
            z = parseInt($("#count_Notes").html());
            j = parseInt($("#count_Money").html());
            // playId = $("#Play_ID").val();
            if (q == "" || q == "0" || q == null) {
                Box.tx("亲，请正确填写期数");
                return
            } else if (b == "" || b == "0" || b == null) {
                Box.tx("亲，请正确填写倍数");
                return
            } else if (z <= 0) {
                Box.tx("亲，你还没选号码");
                return
            } else if (j > 2e5) {
                Box.tx("您的购买金额不能超过20万");
                return false
            } else if (q > 100) {
                Box.tx("最多只能追100期");
            } else if (b > 99999) {
                Box.tx("最大购买99999倍");
            } else {
                var zflag = $(".zjStop em").hasClass("check") ? 1 : 0;
                var url = "/pay/" + gameCode.toLowerCase() + "?notes=" + z + "&multiple=" + b + "&qs=" + q + "&countMoney=" + j + "&zflag=" + zflag;
                if ("dlt" == gameCode.toLowerCase()) {
                    url += "&isappend=" + ($("#againtz").is(":checked") ? 1 : 0);
                }
                window.location.href = url;
            }
        });
        //发起合买
        $(".fqhm").bind("click", function () {
            if ($(this).hasClass("true_disabled")) return;
            var q, b, z, j;
            q = parseInt($("input[name='qs']").val());
            b = parseInt($("input[name='bs']").val());
            z = parseInt($("#count_Notes").html());
            j = parseInt($("#count_Money").html());
            if (q == "" || q == "0" || q == null) {
                Box.tx("亲，请正确填写期数");
                return
            } else if (b == "" || b == "0" || b == null) {
                Box.tx("亲，请正确填写倍数");
                return
            } else if (z <= 0) {
                Box.tx("亲，你还没选号码");
                return
            } else {
                location.href = "/buy/hm/" + gameCode.toLowerCase() + "?notes=" + z + "&multiple=" + b + "&countMoney=" + j;
            }
        });
    },
    loadCont: function () {
        this.sum = new Array;
        var html = "";
        var antecode = localStorage.getItem(gameCode);
        if (!antecode) {
            return false
        }
        var ssqArr = antecode.split("#");
        var len = ssqArr.length;
        for (var i = 0; i < len; i++) {
            tz.number = new Array();
            var type = ssqArr[i].toString().split('.').length > 1 ? ssqArr[i].toString().split('.')[0] : "DS";
            var number = ssqArr[i].toString().split('.').length > 1 ? ssqArr[i].toString().split('.')[1] : ssqArr[i];
            tz.type = type;
            tz.number.push([number]);
            var arr = number.split("|");
            if (arr.length == 2) {
                var redValue = arr[0].replace(/,/g, " ");
                var blueValue = arr[1].replace(/,/g, " ");
                var rArr = arr[0].split(",");
                var bArr = arr[1].split(",");
                var n = CC.count_Money();
                var m = n * tz.singleBetMoney;
                html += '<div class="ssqtzNum" gametype=' + tz.type + '>';
                html += '<cite class="errorBg"><em class="error2"></em></cite>';
                html += "<span><em>" + redValue + "</em><cite>" + blueValue + "</cite></span>";
                html += "<p>普通投注&nbsp;&nbsp;&nbsp;" + n + "注" + m + "元</p>";
                html += "</div>";
                this.sum.push(n)

            } else {
                var dredValue = arr[0].replace(/,/g, " ");
                var tredValue = arr[1].replace(/,/g, " ");
                var dtblueValue = arr[2].replace(/,/g, " ");
                var drArr = arr[0].split(",");
                var trArr = arr[1].split(",");
                var dtArr = arr[2].split(",");
                var n = CC.count_Money();
                var m = n * tz.singleBetMoney;
                html += '<div class="ssqtzNum" gametype=' + tz.type + '>';
                html += '<cite class="errorBg"><em class="error2"></em></cite>';
                html += "<span>(<em>" + dredValue + "</em>) <em>" + tredValue + "</em><cite>" + dtblueValue + "</cite></span>";
                html += "<p>胆拖投注&nbsp;&nbsp;&nbsp;" + n + "注" + m + "元</p>";
                html += "</div>";
                this.sum.push(n)
            }
        }
        $(".ssqNum").html(html);
        tz.loadMoney();
        $(".error2").bind("click",function () {
            $(this).parents("div.ssqtzNum").remove();
            var str = tz.joinValue();
            localStorage.setItem(gameCode, str);
            tz.loadMoney()
        })
    },
    loadMoney: function () {
        this.sum = new Array;
        var antecode = localStorage.getItem(gameCode);
        if (!antecode) {
            $("#count_Notes").html(0);
            $("#count_Money").html(0);
            return
        }
        var ssqArr = antecode.split("#");

        var len = ssqArr.length;
        for (var i = 0; i < len; i++) {
            tz.number = new Array();
            var type = ssqArr[i].toString().split('.')[0];
            var number = ssqArr[i].toString().split('.')[1];

            tz.type = type;
            tz.number.push([number]);
            var arr = ssqArr[i].split("|");
            if (arr.length == 2) {
                var rArr = arr[0].split(",");
                var bArr = arr[1].split(",");
                var n = CC.count_Money();
                var m = n  * tz.singleBetMoney;
                this.sum.push(n)
            } else {
                var drArr = arr[0].split(",");
                var trArr = arr[1].split(",");
                var dtArr = arr[2].split(",");
                var n = CC.count_Money();
                var m = n * tz.singleBetMoney;
                this.sum.push(n)
            }
        }
        var count = CC.sumCount(this.sum);
        var money = CC.sumMoney(this.sum);
        //总注数
        tz.sumcount = count;
        //总倍数
        tz.amount = $("input[name='bs']").val();
        tz.summoney = money;
        $("#count_Notes").html(count);
        $("#count_Money").html(money);

    },
    joinValue: function () {
        var arr = [];
        var str = "";
        var tmp = $(".ssqNum").find("div.ssqtzNum");
        tmp.each(function () {
            var len = $(this).find("span em").length;
            if (len == 1) {
                var r = $(this).find("span em").html();
                r = r.split(" ").join(",");
                var b = $(this).find("span cite").html();
                b = b.split(" ").join(",");
                var type = $(this).attr("gametype");
                arr.push(type + "." + r + "|" + b)
            } else {
                var r = $(this).find("span em:eq(0)").html();
                r = r.split(" ").join(",");
                var t = $(this).find("span em:eq(1)").html();
                t = t.split(" ").join(",");
                var b = $(this).find("span cite").html();
                b = b.split(" ").join(",");
                arr.push(type + "." + r + "|" + t + "|" + b)
            }
        });
        str = arr.join("#");
        return str
    },
    //大乐透追加投注
    appendBet: function (obj) {
        var self = $(obj);
        if (self.is(":checked") && "DLT" == gameCode) {
            tz.singleBetMoney = 3;
        } else {
            tz.singleBetMoney = 2;
        }
        tz.loadMoney();
    }
};
CC = {
    cur: {
        min: 0,
        max: 0
    },
    type: "",
    count_Money: function () {
        var count = 0;
        $(tz.number).each(function (k, v) {
            var inf = codeInfo(gameCode, tz.type, v[0]);
            v.length < 3 ? v.push(inf.count) : v[2] = inf.count;
            count += inf.count;
        })
        return count;
    },
    sumCount: function (m) {
        var tmp = 0;
        for (var i = 0; i < m.length; i++) {
            tmp += m[i];
        }
        return tmp

    },
    sumMoney: function (m) {
        var bs = parseInt($("input[name='bs']").val());
        var qs = parseInt($("input[name='qs']").val());
        var sum = this.sumCount(m) * bs * qs * tz.singleBetMoney;
        return sum;
    },
    machineSelect: function () {
        var itype = GetLength();
        tz.type = "DS";
        var selectlength_r = itype.SelectedLength_r;
        var maxlength_r = itype.MaxBallLength_r;
        var redNum = bet.Random(maxlength_r);

        //        for (var i = 0; i < maxlength_r; i++) $("#xzhq .ssqBall cite").eq(i).removeClass("redBall");
        $("#Red_BallValue").attr("value", "");
        var redvalue = "";
        for (var i = 0; i < selectlength_r; i++) {
            //            $("#xzhq .ssqBall cite").eq(redNum[i] - 1).attr("class", "redBall");
            redvalue += (redNum[i] < 10 ? "0" + redNum[i].toString() : redNum[i]) + ","
        }
        if (redvalue != "") {
            redvalue = redvalue.substring(0, redvalue.length - 1);
            $("#Red_BallValue").attr("value", redvalue)
        }
        var selectlength_b = itype.SelectedLength_b;
        var maxlength_b = itype.MaxBallLength_b;
        var blueNum = bet.Random(maxlength_b);
        //        for (var i = 0; i < maxlength_b; i++) $("#xzlq .ssqBall cite").eq(i).removeClass("blueBall");
        $("#Blue_BallValue").attr("value", "");
        var bluevalue = "";
        for (var i = 0; i < selectlength_b; i++) {
            //            $("#xzlq .ssqBall cite").eq(blueNum[i] - 1).attr("class", "blueBall");
            bluevalue += (blueNum[i] < 10 ? "0" + blueNum[i].toString() : blueNum[i]) + ","
        }
        if (bluevalue != "") {
            bluevalue = bluevalue.substring(0, bluevalue.length - 1);
            $("#Blue_BallValue").attr("value", bluevalue)
        }
    },
    jixuan_: function (t) {
        var h_ = "";
        if (!t) {
            var op_ = ["直选", "组三", "和值"];
            t = op_[bet.Random(3)[2] - 1]
        }
        var kd_ = "-" + $(window).width() + "px";
        if (t == "直选") {
            var zx1 = bet.Random(10);
            var zx2 = bet.Random(10);
            var zx3 = bet.Random(10);
            h_ = zx1[2] - 1 + "," + (zx2[5] - 1) + "," + (zx3[9] - 1);
            h_ = "<p v='1' w=" + t + " gametype='FS' style='left:" + kd_ + '\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>' + h_ + "</span><b>" + t + "&nbsp;共1注2元</b></span></p>"
        } else if (t == "组三") {
            var zs = bet.Random(10);
            h_ = zs[3] - 1 + "," + (zs[3] - 1) + "," + (zs[6] - 1);
            h_ = "<p v='1'  gametype='ZX3DS' w=" + t + " style='left:" + kd_ + '\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>' + h_ + "</span><b>" + t + "&nbsp;共1注2元</b></span></p>"
        } else if (t == "和值") {
            var hz = bet.Random(28),
                zs;
            h_ = hz[12] - 1;
            zs = {
                0: 1,
                1: 3,
                2: 6,
                3: 10,
                4: 15,
                5: 21,
                6: 28,
                7: 36,
                8: 45,
                9: 55,
                10: 63,
                11: 69,
                12: 73,
                13: 75,
                14: 75,
                15: 73,
                16: 69,
                17: 63,
                18: 55,
                19: 45,
                20: 36,
                21: 28,
                22: 21,
                23: 15,
                24: 10,
                25: 6,
                26: 3,
                27: 1
            }[h_];
            h_ = "<p gametype='HZ'  v=" + zs + " w=" + t + " style='left:" + kd_ + '\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>' + h_ + "</span><b>" + t + "&nbsp;共" + zs + "注" + 2 * zs + "元</b></span></p>"
        }
        ele.list.append(h_);
        ele.list.find("p").eq($("#code_list p").length - 1).animate({
                left: 0
            },
            300,
            function () {
                fun.Showlocal_()
            });
        fun.calCount();
        ele.list.find("p cite.errorBg").bind("click",
            function () {
                $(this).parent().animate({
                        left: "-1600px"
                    },
                    300,
                    function () {
                        $(this).remove();
                        fun.calCount();
                        fun.Showlocal_()
                    })
            })
    },
    nrandom: function (type) {
        var zs = 1;
        var kd_ = "-" + $(window).width() + "px";
        if (!type) {
            var op = [];
            if (gameCode == "CQSSC") {
                op = ["DXDS", "1XDX", "2XDX", "2XZXFS", "3XDX", "5XDX", "5XTX"];
            } else {
                op = ["RX2", "RX3", "RX4", "RX5", "RX6", "RX7", "Q2ZHIX","Q2ZUX","Q3ZHIX","Q3ZUX"];
            }
            type = op[bet.Random(op.length)[5] - 1];

        }
        CC.type = type;
        $.extend(CC.cur, typeInfo(gameCode, CC.type));
        var number = lottery.award.arr_red.randomN(CC.cur.min).sort();
        if (type == "DXDS") {
            number = ["1", "2", "4", "5"].randomN(CC.cur.min).sort();
        }
        number = CC.convertNumberDisplay(number).join(",");
        var itype = typeInfo(gameCode, type);
        if (gameCode == "CQSSC") {
            var h_ = "<p gametype='" + type + "' v='" + zs + "' w='" + itype.typeName + "' style='left:" + kd_ + '\'><cite class="errorBg"><em class="error2"></em></cite><span class="revise_ww"><span>' + number + "</span><b>" + itype.typeName + " &nbsp;共" + zs + "注" + (parseInt(2 * zs)) + "元</b></span></p>";
            ele.list.append(h_);
            ele.list.find("p:last").animate({ left: 0 }, 300);
            cqssc.calCount_();
            cqssc.local_();
            ele.list.find("p cite.errorBg").bind("click",
                function() {
                    $(this).parent().animate({
                            left: "-1600px"
                        },
                        300,
                        function() {
                            $(this).remove();
                            cqssc.calCount_();
                            cqssc.local_();
                        });
                });
        } else {
            var h_ = "<div class=\"ssqtzNum\" gametype='" + CC.type + "' v='" + zs + "' style='left:"+kd_+"'  w='" + itype.typeName + "'><cite class=\"errorBg\"><em class=\"error2\"></em></cite><span class=\"revise_ww\"><span>"+number+"</span>";
            h_ += "<p>" + itype.typeName + " 共" + zs + "注" + (zs * 2) + "元</p></span></div>";
            $(".ssqNum").append(h_);
            $(".ssqNum").find("div:last").animate({ left: 0 }, 300);
            jx11x5.calCount();
            jx11x5.local_();
            $(".ssqNum").find("div .error2").bind("click", function() {
                $(this).parents("div.ssqtzNum").animate({
                        left: "-" + $(window).width() + "px"
                    }, 300,
                    function() {
                        $(this).remove();
                        jx11x5.calCount();
                        jx11x5.local_();
                    });
            });

        }






    },
    //大小单双号码显示-传入数组
    convertNumberDisplay: function (numArray) {
        if (CC.type == "DXDS") {
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
        }
        else {
            return numArray;
        }
    }
};
//排列3 福彩3D
var ele = {
    list: $("#code_list"),
    qs: $("#qs_"),
    bs: $("#bs_"),
    random: $("#random_"),
    pay: $("#isOk_")
};
var fun = {
    init_info: function() {
        var sdSelectNum = localStorage.getItem(gameCode);
        sdSelectNum && ele.list.html(sdSelectNum);
        fun.calCount();
        fun.bindEvent();
        ele.list.find("p cite.errorBg").bind("click",
            function() {
                $(this).parent().animate({
                        left: "-1600px"
                    },
                    300,
                    function() {
                        $(this).remove();
                        fun.calCount();
                        fun.Showlocal_();
                    });
            });
    },
    bindEvent: function() {
        ele.bs.keyup(function() {

            var val = $(this).val();
            var reg = /^\d*$/;
            var bs = parseInt(val);
            if (!reg.test(val)) {
                $(this).val("1");
                bs = 1;
            }
            if (val.indexOf("0") == 0) {
                $(this).val("1");
                bs = 1;
            }
            if (val == "") {
                bs = 1;
            }
            var zs = parseInt($("#zs_list").find("cite:eq(0)").html());
            var qs = parseInt(ele.qs.val());

            if (bs > 99999) {
                Box.alert("最大可投倍数99999",
                    function() {
                        bs = 99999;
                        ele.bs.val(bs);
                        fun.count_finally(zs, qs, bs);
                    });
            } else {
                fun.count_finally(zs, qs, bs);
            }
        });
        ele.bs.blur(function() {
            if ($(this).val() == "") {
                var bs = 1;
                $(this).val(bs);
                var zs = parseInt($("#zs_list").find("cite:eq(0)").html());
                var qs = parseInt(ele.qs.val());
                fun.count_finally(zs, qs, bs);
            }
        });
        ele.qs.keyup(function() {
            this.value = this.value.replace(/\D/g, "");
            var qs = parseInt($(this).val());
            if ($(this).val() == "") {
                qs = 1
            } else if ($(this).val() == 0) {
                $(this).val("");
                qs = 1;
            }
            var zs = parseInt($("#zs_list").find("cite:eq(0)").html());
            var bs = parseInt(ele.bs.val());

            if (zs > 0 && qs > 1) {
                $(".zjStop").fadeIn();
                $(".fqhm").attr("disabled", true).addClass("fqhmGray").removeClass("fqhm")
            } else {
                $(".zjStop").fadeOut();
                $("#fqhm").attr("disabled", false).removeClass("fqhmGray").addClass("fqhm")
            }
            if (qs > 100) {
                Box.alert("最大可买期数100",
                    function() {
                        qs = 100;
                        ele.qs.val(qs);
                        fun.count_finally(zs, qs, bs);
                    });
            } else {
                fun.count_finally(zs, qs, bs);
            }
        });
        ele.qs.blur(function() {
            var zs = parseInt($("#zs_list").find("cite:eq(0)").html());
            (zs <= 0 || parseInt($(this).val()) <= 1 || $(this).val() == "") && $(".zjStop").fadeOut();
            if ($(this).val() == "") {
                var qs = 1;
                $(this).val(qs);
                var bs = parseInt(ele.bs.val());
                fun.count_finally(zs, qs, bs);
            }
        });
        $("#zj_stop").Touch(function() {
            $(this).toggleClass("nocheck");
        });
        ele.random.bind("click", function() {
            var t = "";
            if (ele.list.html()) {
                t = ele.list.find("p").length;
                t = ele.list.find("p").eq(t - 1).attr("w");
            }
            CC.jixuan_(t)
        });
        ele.pay.bind("click", function() {
            if ($(this).hasClass("true_disabled")) return;
            var q, b, z, j, bk, zflag, playId;
            q = parseInt(ele.qs.val());
            b = parseInt(ele.bs.val());
            z = parseInt($("#zs_list cite:eq(0)").html());
            j = parseInt($("#zs_list cite:eq(1)").html());
            if (q == "" || q == "0" || q == null) {
                Box.alert("亲，请正确填写期数");
                return
            } else if (b == "" || b == "0" || b == null) {
                Box.alert("亲，请正确填写倍数数");
                return
            } else if (z <= 0) {
                Box.alert("亲，你还没选号码");
                return;
            } else {
                fun.poll_();
                zflag = $("#zj_stop").hasClass("nocheck") ? 0 : 1;
                window.location.href = "/pay/" + gameCode.toLowerCase() + "?notes=" + z + "&multiple=" + b + "&qs=" + q + "&countMoney=" + j + "&zflag=" + zflag;
            }
        });
        //发起合买
        $(".fqhm").bind("click", function() {
            if ($(this).hasClass("true_disabled")) return;
            var q, b, z, j;
            q = parseInt(ele.qs.val());
            b = parseInt(ele.bs.val());
            z = parseInt($("#zs_list cite:eq(0)").html());
            j = parseInt($("#zs_list cite:eq(1)").html());
            if (q == "" || q == "0" || q == null) {
                Box.tx("亲，请正确填写期数");
                return;
            } else if (b == "" || b == "0" || b == null) {
                Box.tx("亲，请正确填写倍数");
                return;
            } else if (z <= 0) {
                Box.tx("亲，你还没选号码");
                return;
            } else {
                fun.poll_();
                location.href = "/buy/hm/" + gameCode.toLowerCase() + "?notes=" + z + "&multiple=" + b + "&countMoney=" + j;
            }
        });
    },
    poll_: function() {
        var l = "";
        ele.list.find("p").each(function() {
            l += $(this).attr("gametype") + "_" + $(this).find("span.revise_ww span").html() + "_" + $(this).attr("w") + "_" + $(this).attr("v") + ";";
        });
        l = l.substring(0, l.length - 1);
        localStorage.setItem(gameCode + "_PollNum", l);
    },
    calCount: function() {
        var zs = 0;
        if (ele.list.find("p").length) {
            ele.list.find("p").each(function() {
                zs += parseInt($(this).attr("v"));
            });
        }
        var bs = parseInt(ele.bs.val());
        var qs = parseInt(ele.qs.val());
        fun.count_finally(zs, qs, bs);
    },
    Showlocal_: function() {
        var l = "";
        l = ele.list.html();
        localStorage.setItem(gameCode, l);
    },
    count_finally: function(z, q, b) {
        var j = z * q * b * 2;
        $("#zs_list").find("cite:eq(0)").html(z);
        $("#zs_list").find("cite:eq(1)").html(j);
    }
};
//重庆时时彩
var cqssc = {
    init_info: function() {
        var cqsscSelectNum = localStorage.getItem(gameCode);
        var cqssc_PollNum = localStorage.getItem(gameCode + "_PollNum");
        var h = [];
        if (!cqssc_PollNum) {
            cqssc_PollNum = cqsscSelectNum ? cqsscSelectNum : "";
        } else {
            cqssc_PollNum += cqsscSelectNum ? ";" + cqsscSelectNum : "";
        }
        if (cqssc_PollNum) {
            var p = cqssc_PollNum.split(';');
            for (var i = 0; i < p.length; i++) {
                var n_ = p[i].split('_');
                //            DXDS_小 大_大小单双_1
                h[h.length] = "<p w='" + n_[2] + "' v='" + n_[3] + "' gametype='" + n_[0] + "'>";
                h[h.length] = "<cite class=\"errorBg\">";
                h[h.length] = "<em class=\"error2\"></em>";
                h[h.length] = "</cite>";
                h[h.length] = "<span class=\"revise_ww\">";
                h[h.length] = "<span>" + n_[1] + "</span>";
                h[h.length] = "<b>" + n_[2] + "  共" + n_[3] + "注" + (parseInt(n_[3]) * 2) + "元</b>";
                h[h.length] = "</span>";
                h[h.length] = "</p>";
            }
        }
        localStorage.setItem(gameCode + "_PollNum", cqssc_PollNum);
        localStorage.removeItem(gameCode);

        ele.list.html(h.join("").toString());
        cqssc.calCount_();
        cqssc.bindEvent_();
        ele.list.find("p cite.errorBg").bind("click",
            function() {
                $(this).parent().animate({
                        left: "-1600px"
                    },
                    300,
                    function() {
                        $(this).remove();
                        cqssc.calCount_();
                        cqssc.local_();
                    });
            });
    },
    local_: function() {
        var h = "";
        $("#code_list").find("p").each(function() {
            h += $(this).attr("gametype") + "_" + $(this).find("span.revise_ww span").html() + "_";
            h += $(this).attr("w") + "_";
            h += $(this).attr("v") + ";";
        });
        h = h.substring(0, h.length - 1);
        if (!!h) {
            localStorage.setItem(gameCode + "_PollNum", h);
        } else {
            localStorage.removeItem(gameCode + "_PollNum");
        }

    },
    calCount_: function() {
        var bs = parseInt(ele.bs.val()), zs = 0, qs = parseInt(ele.qs.val());
        ele.list.find("p").each(function() {
            zs += parseInt($(this).attr("v"));
        });
        $("#zs_list cite:eq(0)").html(zs);
        $("#zs_list cite:eq(1)").html(zs * bs * qs * 2);
    },
    bindEvent_: function() {
        ele.qs.keyup(function() {
            var reg = /^\d*$/;
            var qs = $(this).val();
            if (!reg.test(qs)) {
                $(this).val("1");
            }
            if (qs == "") {
                $(this).val("");
            }
            if (qs.indexOf("0") == 0) {
                $(this).val("1");
            }
            if (qs > 1) {
                $(".zjStop").fadeIn();
            } else {
                $(".zjStop").fadeOut();
            }

            if (parseInt(qs) > 100) {
                Box.alert("最大可买期数100期", function() {
                    ele.qs.val(100);
                    cqssc.calCount_();
                });
            } else {
                cqssc.calCount_();
            }

        });
        ele.qs.blur(function() {
            if ($(this).val() == "" || parseInt($(this).val()) == 0) {
                $(this).val("1");
                cqssc.calCount_();
            }
        });
        ele.bs.keyup(function() {
            var reg = /^\d*$/;
            var bs = $(this).val();
            if (!reg.test(bs)) {
                $(this).val("1");
            }
            if (bs.indexOf("0") == 0) {
                $(this).val("1");
            }
            if (bs == "") {
                $(this).val("");
            }
            if (parseInt(bs) > 99999) {
                Box.alert("最大可投倍数99999", function() {
                    ele.bs.val(99999);
                    cqssc.calCount_();
                });
            } else {
                cqssc.calCount_();
            }

        });
        ele.bs.blur(function() {
            if ($(this).val() == "" || parseInt($(this).val()) == 0) {
                $(this).val("1");
                cqssc.calCount_();
            }
        });
        ele.random.click(function() {
            var type = "";
            if ($("#code_list").html()) {
                type = $("#code_list").find("p:last").attr("gametype");
            }
            CC.nrandom(type);
        });
        $("#zj_stop").click(function() {
            $(this).toggleClass("nocheck");
        });
        $("#isOk_").click(function() {
            var q, b, z, j, bk, zflag, playId;
            q = parseInt(ele.qs.val());
            b = parseInt(ele.bs.val());
            z = parseInt($("#zs_list cite:eq(0)").html());
            j = parseInt($("#zs_list cite:eq(1)").html());
            if (q == "" || q == "0" || q == null) {
                Box.tx("亲，请正确填写期数");
                return
            } else if (b == "" || b == "0" || b == null) {
                Box.tx("亲，请正确填写倍数");
                return
            } else if (z <= 0) {
                Box.tx("亲，你还没选号码");
                return
            } else if (j > 2e5) {
                Box.tx("您的购买金额不能超过20万");
                return false
            } else if (q > 100) {
                Box.tx("最多只能追100期");
            } else if (b > 99999) {
                Box.tx("最大购买99999倍");
            } else {

                var zflag = $(".zjStop em").hasClass("nocheck") ? 0 : 1;
                window.location.href = "/pay/" + gameCode.toLowerCase() + "?notes=" + z + "&multiple=" + b + "&qs=" + q + "&countMoney=" + j + "&zflag=" + zflag;
            }
        });

    }
};
var jx11x5 = {
    init_info: function() {
        var jx11x5SelectedNum = localStorage.getItem(gameCode);
        var jx11x5_PolloNum = localStorage.getItem(gameCode + "_PollNum");
        var h = [];
        if (!jx11x5_PolloNum) {
            jx11x5_PolloNum = jx11x5SelectedNum ? jx11x5SelectedNum : "";
        } else {
            jx11x5_PolloNum += jx11x5SelectedNum ? ";"+jx11x5SelectedNum : "";
        }
        if (jx11x5_PolloNum) {
            var p = jx11x5_PolloNum.split(";");

            for (var i = 0; i < p.length; i++) {
                var n_ = p[i].split('_');
                h[h.length] = "<div class=\"ssqtzNum\" w='" + n_[2] + "' v='" + n_[3] + "' gametype='" + n_[0] + "'>";
                h[h.length] = "<cite class=\"errorBg\">";
                h[h.length] = "<em class=\"error2\"></em>";
                h[h.length] = "</cite>";
                h[h.length] = "<span class=\"revise_ww\">";
                h[h.length] = "<span>" + n_[1] + "</span>";
                h[h.length] = "<p>" + n_[2] + "  共" + n_[3] + "注" + (parseInt(n_[3]) * 2) + "元</p>";
                h[h.length] = "</span>";
                h[h.length] = "</div>";
            }
        }
        $(".ssqNum").html(h.join(""));
        jx11x5.local_();
        jx11x5.calCount();
        jx11x5.bindEvent();
        localStorage.removeItem(gameCode);

        $(".ssqNum").find(".ssqtzNum  .error2").bind("click", function() {
            $(this).parents("div.ssqtzNum").animate({
                    left: "-" + $(window).width() + "px"
                },
                300,
                function() {
                    $(this).remove();
                    jx11x5.local_();
                    jx11x5.calCount();
                });
        });
    },
    local_: function() {
        var h = "";
        // var h = $(".ssqNum").html();  str = n + "_" + codes.join(",") + "_" + h + "_" + "_" + zs;
        $(".ssqNum").find(".ssqtzNum").each(function() {
            var type = $(this).attr("gametype");
            var w = $(this).attr("w");
            var zs = $(this).attr("v");
            var code = $(this).find("span.revise_ww span").html();
            h += type + "_" + code + "_" + w + "_" + zs + ";";

        });
        h = h.substring(0, h.length - 1);
        if (!!h) {
            localStorage.setItem(gameCode + "_PollNum", h);
        } else {
            localStorage.removeItem(gameCode + "_PollNum");
        }

    },
    calCount: function() {
        var zs = 0, bs = parseInt($("input[name='bs']").val()), qs = parseInt($("input[name='qs']").val());
        $(".ssqNum .ssqtzNum").each(function() {
            zs += parseInt($(this).attr("v"));

        });
        $("#count_Notes").html(zs);
        $("#count_Money").html(zs * 2 * bs * qs);
    },
    bindEvent: function () {
        $("#jxbtn").bind("click", function() {
            var type = "";
            if ($(".ssqNum").html()) {
                type = $(".ssqNum").find("div:last").attr("gametype");
            }
            CC.nrandom(type);
        });
        $("input[name='bs']").bind("keyup",
            function() {
                var val = $(this).val();
                var reg = /^\d*$/;
                if (!reg.test(val)) {
                    $(this).val("1");
                }
                if (val.indexOf("0") == 0) {
                    $(this).val("1");
                }
                if (parseInt($("input[name='bs']").val()) > 0) {
                    if (parseInt($("input[name='bs']").val()) > 99999) {
                        Box.alert("最多只能投99999倍", function() {
                            $("input[name='bs']").val("99999");
                            jx11x5.calCount();
                        });
                    } else {
                        jx11x5.calCount();
                    }
                }


            });
        $("input[name='bs']").blur(function() {
            if ($(this).val() == "" || parseInt($(this).val()) == 0) {
                $(this).val("1");
                jx11x5.calCount();
            }
        });
        $("input[name='qs']").bind("keyup",
            function() {
                var val = $(this).val();
                var reg = /^\d*$/;
                if (!reg.test(val)) {
                    $(this).val("1");
                }
                if (val.indexOf("0") == 0) {
                    $(this).val("1");
                }
                if (parseInt($("input[name='qs']").val()) == 0) {
                    $(".zjStop").hide();
                } else if (parseInt($("input[name='qs']").val()) > 1) {
                    if (parseInt($("input[name='qs']").val()) <= 100) {
                        $(".fqhm").attr("disabled", true);
                        $(".fqhm").addClass("fqhmGray");
                        $(".zjStop").show();
                        $(".ssqzh").show();
                        jx11x5.calCount();
                    } else {

                        Box.alert("最多只能追100期", function() {

                            $("input[name='qs']").val("100");
                            $(".ssqzh").show();
                            $(".fqhm").attr("disabled", true);
                            jx11x5.calCount();
                        });

                    }
                } else if (parseInt($("input[name='qs']").val()) == 1) {
                    $("#fqhm").attr("disabled", false);
                    $("#fqhm").removeClass("fqhmGray");
                    $("#fqhm").addClass("fqhm");
                    $(".zjStop").hide();
                    $(".ssqzh").hide();
                }

            });
        $("input[name='qs']").blur(function() {
            if ($(this).val() == "" || parseInt($(this).val()) == 0) {
                $(this).val("1");
                jx11x5.calCount();
            }
        });
        //清空所有号码
        $("#clearAll").bind("click",
            function () {
                localStorage.removeItem(gameCode);
                $(".ssqNum").html("");
                Box.tx("请至少选择一注进行投注");
                jx11x5.calCount();
                jx11x5.local_();
            });
        //追号期数加减
        $(".qplus").bind("click",
            function () {
                $(".ssqzh li").removeClass("cur");
                var p = parseInt($("input[name='qs']").val());
                p++;
                $("input[name='qs']").val(p);
                jx11x5.calCount();
                if ($("input[name='qs']").val() == 1) {
                    $(".zjStop").hide();
                    $(".ssqzh").hide();
                    $("#fqhm").attr("disabled", false);
                    $("#fqhm").removeClass("fqhmGray");
                    if (!$("#fqhm").hasClass("fqhm")) {
                        $("#fqhm").addClass("fqhm");
                    }
                } else if ($("input[name='qs']").val() > 1 && $("input[name='qs']").val() <= 100) {
                    $(".zjStop").show();
                    $(".ssqzh").show();
                    $("#fqhm").attr("disabled", true);
                    $("#fqhm").addClass("fqhmGray");
                } else {
                    Box.alert("最多只能追100期", function () {
                        $("input[name='qs']").val("100");
                        jx11x5.calCount();
                    });

                }
            });
        $(".qminus").bind("click",
            function () {
                $(".ssqzh li").removeClass("cur");
                var p = parseInt($("input[name='qs']").val());
                p--;
                if (p < 1) {
                    p = 1;
                    $("#fqhm").removeClass("fqhmGray");
                }
                $("input[name='qs']").val(p);
                jx11x5.calCount();
                if ($("input[name='qs']").val() == 1) {
                    $(".zjStop").hide();
                    $(".ssqzh").hide();
                    $("#fqhm").removeClass("fqhmGray");
                    $("#fqhm").removeAttr("disabled");
                    if (!$("#fqhm").hasClass("fqhm")) {
                        $("#fqhm").addClass("fqhm");
                    }
                } else {
                    $(".zjStop").show();
                    $(".ssqzh").show();
                    $("#fqhm").attr("disabled", true);
                    $("#fqhm").addClass("fqhmGray");
                }
            });
        //投注倍数加减
        $(".bplus").bind("click",
            function () {
                var b = parseInt($("input[name='bs']").val());
                b++;
                $("input[name='bs']").val(b);
                if (parseInt($("input[name='bs']").val()) > 99999) {
                    Box.alert("最多只能投99999倍");
                }
                jx11x5.calCount();
            });
        $(".bminus").bind("click",
            function () {
                var b = parseInt($("input[name='bs']").val());
                b--;
                if (b < 1) {
                    b = 1;
                }
                $("input[name='bs']").val(b);
                jx11x5.calCount();
            });
        //追号期数
        $(".ssqzh li").bind("click",
            function () {
                $(this).toggleClass("cur");
                $(this).siblings().removeClass("cur");
                var q = $(this).attr("q");
                $("input[name='qs']").val(q);
                jx11x5.calCount();
                if ($("input[name='qs']").val() == 1) {
                    $(".zjStop").hide();
                    $(".fqhm").attr("disabled", false);
                    $(".fqhm").removeClass("fqhmGray");
                } else {
                    $(".zjStop").show();
                    $(".fqhm").attr("disabled", true);
                    $(".fqhm").addClass("fqhmGray");
                }
            });
        //中奖后停止追号
        var zflag = 1;
        $(".zjStop em").bind("click",
            function () {

                if ($(this).hasClass("check")) {
                    $(this).removeClass("check");
                    $(this).addClass("nocheck");
                    zflag = 0;
                } else {
                    $(this).removeClass("nocheck");
                    $(this).addClass("check");
                    zflag = 1;
                }
            });
        //提交
        $("#pay").bind("click", function () {
            //debugger;
            var q, b, z, j, bk, playId;
            q = parseInt($("input[name='qs']").val());
            b = parseInt($("input[name='bs']").val());
            z = parseInt($("#count_Notes").html());
            j = parseInt($("#count_Money").html());
            // playId = $("#Play_ID").val();
            if (q == "" || q == "0" || q == null) {
                Box.tx("亲，请正确填写期数");
                return;
            } else if (b == "" || b == "0" || b == null) {
                Box.tx("亲，请正确填写倍数");
                return;
            } else if (z <= 0) {
                Box.tx("亲，你还没选号码");
                return;
            } else if (j > 2e5) {
                Box.tx("您的购买金额不能超过20万");
                return false;
            } else if (q > 100) {
                Box.tx("最多只能追100期");
            } else if (b > 99999) {
                Box.tx("最大购买99999倍");
            } else {
                zflag = $(".zjStop em").hasClass("check") ? 1 : 0;
                window.location.href = "/pay/" + gameCode.toLowerCase() + "?notes=" + z + "&multiple=" + b + "&qs=" + q + "&countMoney=" + j + "&zflag=" + zflag;

            }
        });
        //发起合买
        $(".fqhm").bind("click", function () {
            var q, b, z, j;
            q = parseInt($("input[name='qs']").val());
            b = parseInt($("input[name='bs']").val());
            z = parseInt($("#count_Notes").html());
            j = parseInt($("#count_Money").html());
            if (q == "" || q == "0" || q == null) {
                Box.tx("亲，请正确填写期数");
                return;
            } else if (b == "" || b == "0" || b == null) {
                Box.tx("亲，请正确填写倍数");
                return;
            } else if (z <= 0) {
                Box.tx("亲，你还没选号码");
                return;
            } else {
                location.href = "/buy/hm/" + gameCode.toLowerCase() + "?notes=" + z + "&multiple=" + b + "&countMoney=" + j;
            }
        });
    },
};

$(function () {
    lottery.init();
    //投注页面
    switch (gameCode.toLowerCase()) {
        case "ssq":
        case "dlt":
            tz.init_info();
            break;
        case "fc3d":
        case "pl3":
            fun.init_info();
            break;
        case "cqssc":
            cqssc.init_info();
            break;
        case "jx11x5":
            jx11x5.init_info();
    }
});