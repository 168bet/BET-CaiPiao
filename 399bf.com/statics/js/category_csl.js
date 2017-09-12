$(document).ready(function(){
    imgLoad($('#banner').find('.banner-bd img'));//延迟显示大图

    silde_matchBar({
        sideBox: $(".matchBar_"),
        speed: 1,//滚动个数
        showNum: 3  //显示的li数目
    });
    tabList();
    hoverFunc($('[role="notice"]'));
    banner($("#banner"));

    $("body").addClass("csl");
    $('.noticeTable').find('tr:lt(4) .rank-icon').addClass('hot');

    checkSession($("#checkSession"),$('[role="select"]'),$("#session"));

    $('.selectBtn').first().trigger('click');

});