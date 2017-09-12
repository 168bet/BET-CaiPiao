/**
 * Created by Administrator on 2017/5/10.
 */
$(function(){
    if($(".left").outerHeight() <= $(window).height()/2 *3){
        return;
    }else{
        $(window)[0].addEventListener("scroll",function(){
            if($(window).scrollTop() >= $(window).height() / 3 *2){
                var left = $(".left").offset().left + $(".left").outerWidth() + 10;
                $(".right .side").eq(1).addClass("top_fixed").css({"left":left,"top": "50px"});
                var top = $(".right .side").eq(1).outerHeight() + 50 + 20;
                $(".right .side").eq(2).addClass("top_fixed").css({"left":left,"top": top});
            }else{
                $(".right .side").eq(1).removeClass("top_fixed").css({"left":"","top": ""});
                $(".right .side").eq(2).removeClass("top_fixed").css({"left":"","top": ""});
            }
        },false);
    }
})