/**
 * Created by Administrator on 2017/5/10.
 */
$(function(){
        //精彩图片浮动固定
        $(window)[0].addEventListener("scroll",function(){
            var scrollHeight = $(".right .side").eq(1).offset().top + $(".right .side").eq(1).outerHeight();
            if($(window).scrollTop() >= scrollHeight){
                var left = $(".left").offset().left + $(".left").outerWidth() + 10;
                var top = 50 ;
                $(".right .side").eq(2).addClass("top_fixed").css({"left":left,"top": top});
            }else{
                $(".right .side").eq(2).removeClass("top_fixed").css({"left":"","top": ""});
            }
        },false);

    //猜你喜欢tab自动切换
    var timer;
    var patt  =  new RegExp("guessLike");
    var patt2  =  new RegExp("active");
    timer = setInterval(function(){
    if(patt.test($("#guess li").get(0).className)){
            var tab = $(".guessLike a").attr("href");
            if(patt2.test($(".guessLike").get(0).className)){
                $(".guessLike").removeClass("active").siblings().addClass("active");
                $(tab).removeClass("active fade in").siblings().addClass("active fade in");
            }else{
                $(".guessLike").addClass("active").siblings().removeClass("active");
                $(tab).addClass("active fade in").siblings().removeClass("active fade in");

            }

    }else{
        clearInterval(timer);
    }
    },5000);

})