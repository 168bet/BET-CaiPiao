/**
 * Created by Administrator on 2017/5/5.
 */
$(document).ready(function() {
    var water_container = $('#main-img');
    var win = $('.content');
    var opt = {
        container: water_container,
        pin: '.box'
    };

    //初始化瀑布流
    waterfall.init(opt);

    echo.init({
        content: water_container.get(0),
        offset: 100,
        throttle: 0,
        unload: false,
        callback: function (element, op) {
            //console.log(element, 'has been', op + 'ed');

            //解决因图片未加载时，瀑布流js无法获取准确高度导致布局bug
            setTimeout(function () {
            $('.box').removeClass('oldbox');
            waterfall.layout();

            }, 100);
        }
    });


    // 加载时暂停请求
    var loadover = false;
    var $load_tip = $('.scroll-alert');

    win.on("scroll", function (e) {


        if (!loadover && checkScrollSide()) {

            loadover = true;

            $.ajax({
                type: "get",
                url: "/index.php?m=wap&c=index&a=next_lists&catid=" + catid + "&page=" + page,
                success: function (result) {

                    result = JSON.parse(result);

                    if (result.code === 1) {
                        $load_tip.text('正在加载...').show();

                        page++;
                        var list = result.lists;
                        var html = "";
                        var len = list.length;
                        for (var i = 0; i < len; i++) {
                            var it = list[i];
                            var img = new Image();
                            img.src = it.thumb;
                            html = '<div class="box newbox" >' +
                                '<div class="pic"><a href="' + it.url + '">' +
                                '<img style="opacity:0" src="' + it.thumb + '" alt="' + it.title + '" ></a></div>' +
                                '</div>';
                            $("#main-img").append(html);

                        }

                        //加载结束
                        setTimeout(function () {
                            $('.newbox img').css('opacity', 1);
                            waterfall.layout();
                            $load_tip.text('加载完成！');

                            // 1s后可进行再次加载，并隐藏提示信息
                            setTimeout(function () {
                                $load_tip.hide();
                                loadover = false;
                            }, 500);

                        }, 500);


                    }


                }
            });
        }
    });

    //检查是否触发ajax加载
    function checkScrollSide() {

        var scroll = 100;

        var scrollT = win.get(0).scrollTop;

        var docH = win.get(0).clientHeight;

        var scrollH = win.get(0).scrollHeight - 150;


        //当滚动条离底部高度小于100时加载
        return scrollH - scrollT - docH < scroll ? true : false;

    }
});


