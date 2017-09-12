/**
 * Created by Administrator on 2016/7/27.
 */
(function($){
    var defaults={
        src:'/statics/images/scrolltop.png',//图片路径
        top:1200,//滚动条滚动多少距离出现按钮
        speed:200//滚动速度
    };

    $.fn.returnTop=function(options){
        var option= $.extend(defaults,options);
        var cssStyle=
            'position:fixed;' +
            'z-index:100;' +
            'right:100px;' +
            'display:none;' +
            'top:80%;' +
            'width: 35px;' +
            'height: 35px;' +
            'text-align: center;' +
            'overflow:hidden;' +
            'background: url("'+option.src+'") center center no-repeat;'+
            'background-size:100% 100%';
        var topBtn=$('<div id="returnTop"></div>').attr('style',cssStyle);
        $(topBtn).appendTo("body");
        $(window).scroll(function(){
            if($(window).scrollTop()>option.top){
                $("#returnTop").fadeIn();
            }else {
                $("#returnTop").fadeOut();
            }
        });
        $("#returnTop").click(function(){
            $('body,html').animate({ scrollTop: 0 }, option.speed);
        })
    };

})(jQuery);