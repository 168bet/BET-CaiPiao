(function () {

    //为页面增加回到顶部按钮只需要设置var IMG_PATH = '{IMG_PATH}';作为图片路径
    //然后引用js即可

    //判断是否第一次创建
    var isCreate = true;

    //创建按钮
    function createBtn() {
        var returnTop = $('<div id="returnTop"><img src="' + IMG_PATH + '/top.png"></div>');
        $(returnTop).css({
            width: 55 + 'px',
            height: 55 + 'px',
            position: 'fixed',
            left: '89%',
            top: '80%'
        });
        $(returnTop).click(function () {
            $('html,body').animate({ scrollTop: 0 }, 500);
            $(returnTop).fadeOut();
        });
        $('body').append(returnTop);
        isCreate = false;
    }

    //滚动监听
    $(window).scroll(function () {
        if ($(window).scrollTop() > 2000) {
            if (isCreate) {
                createBtn();
            }
            $('#returnTop').fadeIn();
        }else{
            $('#returnTop').fadeOut();
        }
    });
})();