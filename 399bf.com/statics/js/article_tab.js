$(function(){
    //图片侧栏
    var picGroup=$('.list-pic-container');
    var tabBtn=$('.list-btn');
    $(tabBtn).each(function(i){
        var that=$(this);
        $(this).click(function(){
            $(picGroup).each(function(){
                $(this).css('display','none');
            });
            $(picGroup).eq(i).css('display','block');
            $(that).addClass('active').siblings().removeClass('active');
        });
    });

    //资讯侧栏,热门焦点侧栏
    var infoGroup=$('.tab-info-wrap');
    var infoTabBtn=$('.info-list-btn');
    $(infoTabBtn).each(function(i){
        var that=$(this);
        $(this).click(function(){
            $(infoGroup).each(function(){
                $(this).css('display','none');
            });
            $(infoGroup).eq(i).css('display','block');
            $(that).addClass('active').siblings().removeClass('active');
        });
    });

    //固定浮层
    var main=$('#main');
    var share=$('#share');
    var mainLeft=$(main).offset().left;
    var shareLeft=mainLeft-$(share).width()-10;
    $(share).offset({top:'18%',left:shareLeft});

    $(window).resize(function() {
        var mainLeft=$(main).offset().left;
        var shareLeft=mainLeft-$(share).width()-10;
        $(share).offset({top:'18%',left:shareLeft});
    });
});