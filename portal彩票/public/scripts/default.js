function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return "";
}
$(function () {
    TouchSlide({
        slideCell: "#focus",
        titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell: ".bd ul",
        effect: "left",
        autoPlay: true, //自动播放
        autoPage: true, //自动分页
        switchLoad: "_src" //切换加载，真实图片路径为"_src" 
    });

    function o(n) {
        $(n).animate({
            marginTop: "-28px"
        },
            500,
            function () {
                $(this).css("margin-top", 0),
                    $(this).find("li").eq(0).appendTo($(this).find("ul"));
            });
    }

    setInterval(function () {
        o(".zj_tipBox");
    },
        4e3);
    $.get("/user/indexinfo?pid=" + getQueryString("pid") + "&r=" + Math.random(), function (response) {
        var loged = $("#div_logined");
        var notlog = $("#div_not_login");
        if (response.IsSuccess) {
            loged.show();
            $("#div_logined_uname").html(response.uname);
            notlog.hide();
        } else {
            loged.hide();
            notlog.show();
        }
    });
});
//滚动
//$(window).scroll(function () {
//    if ($('.fllist')) {
//        var n = $('.index_nav_').offset().top;
//        $(this).scrollTop() > n + 70 ? $('.fllist').show() : $('.fllist').hide();
//    }
//});
