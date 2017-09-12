$(function(){
    //var MatchNarTop = $('div.eventDetailNav').offset().top;
    //$(window).scroll(function() {
    //    new isDoFixed($('div.eventDetailNav'),MatchNarTop).doFixed();
    //})
});

//赛事页 导航固定
function isDoFixed(NavBar, top) {

    var scrollT = $(document).scrollTop(),
        w = $('div.container').innerWidth();

    this.doFixed = function() {
        if (scrollT >= top) {
            NavBar.addClass('isFixed').css({
                width: w + "px"
            });

        } else {
            NavBar.removeClass('isFixed');
        }
    }

}