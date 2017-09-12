var arg;
function popWin(ds1, ds2) {
    if (ds1 == "_a1") {
        ds1 = _a1;
    } else if (ds1 == "_a2") {
        ds1 = _a2;
    } else if (ds1 == "_a3") {
        ds1 = _a3;
    } else if (ds1 == "_a4") {
        ds1 = _a4;
    }
    var g = $("#G").val();
    var ds = ds1 || $("#typeTitle").html();
    var url = "../DetailsList.php?gid=" + g + "&number=" + encodeURIComponent(openNumber) + "&ds1=" + encodeURIComponent(ds) + "&ds2=" + encodeURIComponent(ds2);
    window.open(url);
}

function setOdds(s, id, p) {
    var obj = $("#" + id);
    var odds = parseFloat(obj.html());
    if (odds.toString() != "NaN") {
        var _s = s == "0" ? odds - 0.01 : odds + 0.01;
        var set = _s < 1.0 ? "-" : Base.ForDight(_s, 3);
        var gid = $("#G").val();
        var nid = $("#N").val();
        var ds1 = p || $("#typeTitle").html();
        var ds2 = id.split("_")[id.split("_").length - 1];
        ds2 = parseInt(ds2) + 1;
        obj.html(set);
        $.get("/Xml/Config.ashx", { id: 4, uid: nid, gid: gid, d1: ds1, d2: ds2, value: s, v: +new Date() }, function () { });
    }
}

function open_clews(obj, ds2, odds, maxMoney, s, ds1) {
    if (ds1 == "_a1") {
        ds1 = _a1;
    } else if (ds1 == "_a2") {
        ds1 = _a2;
    } else if (ds1 == "_a3") {
        ds1 = _a3;
    } else if (ds1 == "_a4") {
        ds1 = _a4;
    }
    var pop = $("#rPop");
    var $this = $(obj);
    var offsetTop = $this.offset().top + 15;
    var offsetLeft = $this.offset().left - 70;
    var _ds1 = ds1 || $("#typeTitle").html();
    var _ds2 = ds2;
    var _odds = $("#" + odds).html();
    var _maxMoney = $("#" + maxMoney).html();
    var _mixMoney = $("#mixMoney").val();
    var _comt = $("#Comt").val();
    var gid = $("#G").val();
    if (!Base.patrn.Decimal.exec(_odds)) return;
    arg = { gid: gid, ds1: _ds1, ds2: _ds2, odds: _odds, maxMoney: _maxMoney, mixMoney: _mixMoney, s: s }
    _maxMoney = parseInt(_maxMoney) < parseInt(_mixMoney) ? _mixMoney : _maxMoney;
    if (Base.patrn.Number.exec(_maxMoney) && _comt == "1") {
        if (Base.patrn.Number.exec(_ds2)) {
            $("#t_type").addClass("r_dd");
        } else {
            $("#t_type").removeClass("r_dd");
        }

        $("#t_type").html(_ds2);
        $("#t_odds").html(_odds);
        $("#t_n").html(_maxMoney);
        pop.css({ top: offsetTop, left: offsetLeft }).show();
    }
}

function open_clewr(obj, showId) {
    var pop = $("#" + showId);
    var $this = $(obj);
    var offsetTop = $this.offset().top - 285;
    var offsetLeft = $this.offset().left - 170;
    for (var i = 0; i < 20; i++) {
        $("#H_0_" + i + "_A").html($("#H_0_" + i).html());
    }
    pop.css({ top: offsetTop, left: offsetLeft }).show();
}

function GoPostEvt(obj) {
    var tn, value, ds2, odds, money, count = 0, sh = [];
    var gid = $("#G").val();
    var ds1 = $("#typeTitle").html();
    var mixMoney = parseInt($("#mixMoney").val());
    for (var i = 0; i < obj.length; i++) {
        if (obj[i].type == "text" && obj[i].value != "") {
            tn = parseInt($("#" + obj[i].name).html());
            value = parseInt(obj[i].value);
            count++;
            if (tn.toString() == "NaN" || value > tn) {
                alert("補貨金額已超出限額，請重新輸入!!!");
                return false;
            }
            if (value < mixMoney) {
                alert("起補金額最低：" + mixMoney + "元。");
                return false;
            }
            ds2 = parseInt(obj[i].name.split("C")[1]) + 1;  //内容
            ds2 = ds2.toString().length == 1 ? "0" + ds2 : ds2;
            money = obj[i].value;
            odds = $(obj[i]).parent().prev().html();
            sh.push(gid + "," + openNumber + "," + ds1 + "," + ds2 + "," + odds + "," + money + ",GD|");
        }
    }

    if (count == 0) {
        alert("請輸入補貨金額!!!");
        return false;
    }

    sh = sh.join('');
    sh = sh.substr(0, sh.length - 1);
    $("#submit").attr("disabled", "disabled");

    $.get("/Xml/DetailsData.ashx", { id: 1, value: sh, v: + +new Date() }, function (data) {
        $("#submit").attr("disabled", "");
        $("#vList").html(data);
        $("#kOddsPop").show();
        LoadInfo();
        setTimeout(function () {
            $("#kOddsPop").hide();
        }, 5000);
    });
    open_close('rPop2');
    return false;
}

function GoPost(obj) {
    var maxMoney = parseInt(arg.maxMoney);
    var mixMoney = parseInt(arg.mixMoney);
    var money = parseInt($("#t_money").val());
    var sh = [];
    if (money == "" || money.toString() == "NaN") {
        alert("請輸入補貨金額!!!");
        return false;
    }
    if (money < mixMoney) {
        alert("起補金額最低：" + mixMoney + "元。");
        return false;
    }
    if (money > maxMoney) {
        alert("最大補貨限額：" + maxMoney + "元。");
        return false;
    }

    sh.push(arg.gid + "," + openNumber + "," + arg.ds1 + "," + arg.ds2 + "," + arg.odds + "," + money + "," + arg.s);
    sh = sh.join('');
    obj.disabled = "disabled";

    $.get("/Xml/DetailsData.ashx", { id: 1, value: sh, v: + +new Date() }, function (data) {
        obj.disabled = "";
        $("#vList").html(data);
        $("#rPop").hide();
        $("#kOddsPop").show();
        $("#t_money").val("");
        LoadInfo();
        setTimeout(function () {
            $("#kOddsPop").hide();
        }, 5000);

    });
}

function open_close(strID) {
    $("#" + strID).hide();
    $(".cvd").val("");
}
function open_win() {
    window.open("/Fill.htm");
}