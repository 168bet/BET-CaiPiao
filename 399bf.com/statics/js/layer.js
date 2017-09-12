/**
 * Created by Administrator on 2016/9/2.
 */
$(function(){
    var li=$('.data-content-li');
    $(li).on('mouseenter',function(e){

        var $layer=$(this).find('.layer');
        //判断元素是否靠近浏览器边框
        var isMinBottom=$(window).height() - e.clientY <= this.clientHeight + 180,
            isMinRight=$(window).width() - e.clientX <= this.clientWidth + 170;

        isMinRight ? $layer.css({
            left:"auto",
            right:"157px"
        }) : $layer.css({
            left:"157px",
            right:"auto"
        });

        $layer.css({'display':'block'});

    });
    $(li).on('mouseleave',function(){
        $(this).find('.layer').css({'display':'none'});
    })
});