

var LoadPage = {

    Bind_Bonus: function () {
        var gamecode = $("#gamecode").val();
        var issue = $("#issue").val();
        var bonsurl = dres + gamecode + "/" + gamecode + "_" + issue + ".json";
        var h = "", a = [];
        $.getScript(bonsurl, function () {
            if (data) {
                h = "<p>本期销量:￥" + data.TotalSellMoney + "元";
                h += "<p class='pdTop03'>奖池滚存：￥";
                h += "<cite class='yellow'>" + data.TotalPrizePoolMoney + "元</cite></p>";
                var gradelist = data.GradeList;
                $.each(gradelist, function (index, item) {
                    a[a.length] = "<li><em>" + item.GradeName + "</em>";
                    a[a.length] = "<cite>" + item.BonusCount + "</cite>";
                    a[a.length] = "<span>" + item.BonusMoney + "</span>";
                    a[a.length] = "</li>";
                });
                $("#bonus").html(h);
                $("#bonuslist").html(a.join('').toString());
            }
        });
    }

}
$(function () {
    LoadPage.Bind_Bonus();

});