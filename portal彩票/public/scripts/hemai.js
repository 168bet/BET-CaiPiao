function CheckLogin() {
    var userid = $("#username").val();
    var schemeid = $("#schemeid").val();
    var buy = $("#txt_" + schemeid).val();
    var price = $("#price_" + schemeid).val();
    var residue = $("residue").val();
    if (userid == "" || userid == null) {
        Box.alert("请先登录");
        return false;
    }
    else {
        if (isNaN(buy) || buy < 1 || buy > residue) {
            Box.alert("请输入正确的购买份数", "warning");
            return false;
        }
        var jpwd = $("#joinpwd").val();
        var bpwd = $("#balancepwd").val();
        var data = { buyCount: buy, joinpwd: jpwd, balancepwd: bpwd };
        $.post("/hemai/join_sports/" + schemeid, data, function (res) {
            if (res.IsSuccess) {
                Box.alert(res.Message, function () { location.href = location.href; }, function () { });
            }
            else {
                Box.alert(res.Message, "warning");
                return false;
            }
        });
    }
}
function bindClick() {
    //头部选项
    $(".pullDown").click(function () {
        if ($(".pullText").is(":visible")) {
            $(this).removeClass("pullHover");
            $(".pullText").hide();
        } else {
            $(this).addClass("pullHover");
            $(".pullText").show();
        }
    });
    //头部彩种
    $(".hmzxHeader .hmHeader h1").click(function () {
        if ($(".hmPull").is(":visible")) {
            $(this).removeClass("hmTit");
            $(".hmPull").hide();
        } else {
            $(this).addClass("hmTit");
            $(".hmPull").show();
        }
    });
    //排序
    $(".hmzxHeader .hmSort li").click(function () {
        $(this).addClass("cur");
        $(this).siblings().removeClass("cur");
    });
}

$(function () {
    bindClick();
});

function Checkstate() {
    var stoptime = $("#stoptime").val();
    var new_stoptime = new Date(Date.parse(stoptime.replace(/-/g, "/")));
    var datatime = $("#datatime").val();
    var new_datatime = new Date(Date.parse(datatime.replace(/-/g, "/")));
    var security = $("#security").val();
    var anteList = $("#antelist").val();
    var username = $("#username").val();
    var toginfoname = $("#toginfoname").val();
    if (username) {
        if (username != toginfoname) {
            if (security == "JoinPublic" && anteList != "1") {
                Box.alert("您不是跟单用户，不能查看投注详情");
                return false;
            }
            if (security == "CompletePublic" && new_stoptime > new_datatime) {
                Box.alert("方案未截止，不能查看投注详情");
                return false;
            }
            if (security == "KeepSecrecy") {
                Box.alert("方案永久保密，不能查看投注详情");
                return false;
            }
        }
    }
    else {
        Box.alert("请先登录！");
        return false;
    }
}
function CheckLogin_() {
    var username = $("#username").val();
    if (!username) {
        Box.alert("请先登录！");
        return false;
    }
}