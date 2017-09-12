$(function () {
    var i = 0;
    var count = 0;
    var gametype = $("#gametype").val();
    $("#moresult1").click(function () {
        i = $("#issue").val();
        count = $("#gamecode").val();
        i++;
        if (i > count) {
            Box.alert("没有更多数据");
            i--;
        }
        if (gametype == "CQSSC" || gametype == "JX11X5") {
            location.href = "?gamecode=" + gametype + "&&pageIndex=" + i;
        } else {
            location.href = "?gametype=" + gametype + "&&pageIndex=" + i;
        }
    })
    $("#wanfa_").Touch(function () {
        $(this).toggleClass("hmTit");
        $(this).next().toggle()
    });
    $(".a").removeClass("cur");
    $("#" + gametype).addClass("cur");
    //数字彩
    $("#newkj").click(function () {
        $("#historykj").removeClass("cur");
        $("#newkj").addClass("cur");
    })
    $("#historykj").click(function () {
        $("#newkj").removeClass("cur");
        $("#historykj").addClass("cur");
    })
    $("#newkj").click(function () {
        $("#newinfo").css('display', 'block');
        $("#historyList").css('display', 'none');
    })
    $("#historykj").click(function () {
        $("#newinfo").css('display', 'none');
        $("#historyList").css('display', 'block');
    })
})