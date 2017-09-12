window.onload=function(){





    var $handler = $('#tiles li');

    var options = {
        autoResize: true,
        container: $('#main'),
        offset: 5,
        outerOffset: 10,
        itemWidth: 240
    };

    $handler.wookmark(options);

    echo.init({
        offset: 300,
        throttle: 0,
        unload: false,
        callback: function (element, op) {
            //console.log(element, 'has been', op + 'ed');

            //解决因图片未加载时，瀑布流js无法获取准确高度导致布局bug
            setTimeout(function(){
                $('#tiles').trigger('refreshWookmark');

            },300);
        }
    });
};