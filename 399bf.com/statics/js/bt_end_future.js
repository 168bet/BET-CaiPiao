//选择赛事
(function(){
    //高亮
    $('.date-item').mouseover(function(){
        $(this).addClass('active');
    }).mouseout(function(){
        $(this).removeClass('active');
    });

    //完整 NBA CBA WNBA EURO
    $('.hot-item').click(function(){

        var id = $(this).data('id');

        $('.hot-item').removeClass('active');

        $(this).addClass('active');


        if ( id == '0' ) { //完整

            $('#hidden').text(0);

            $('.data-item').show();

        } else {

            var $allItem = $('.data-item');

            var $showItem = $(".data-item[data-id='" + id + "']");

            $('#hidden').text($allItem.length - $showItem.length);

            $allItem.hide();

            $showItem.show();

        }

    });

    //var event=document.getElementById('event');
    //var raceL=event.getElementsByClassName('racelist')[0];
    //event.onmouseover=function(){
    //    raceL.style.display='block';
    //};
    //event.onmouseout=function(){
    //    raceL.style.display='none';
    //};
    //全选
    $('[data-action="check-all"]').on('click', function () {
        var target = $(this).data('target'),
            elem = $('[data-name="' + target + '"]');
        $(elem).each(function (index) {
            elem[index].checked = true;
        });
    });

    //模糊弹出层确定按钮
    $('[data-action="submit"]').on('click', function () {
        var target = $(this).data('target'),
            elem = $('[data-name="' + target + '"]:checked'),
            value = [];
        elem.each(function () {
            value.push(Number($(this).attr('value')));
        });
        var count=0;
        if (value.length > 0) {
            $('.data-item').each(function () {
                var item = $(this),
                    val = Number(item.data(target));
                if ($.inArray(val, value) < 0) {
                    item.hide();
                    count++;
                } else {
                    item.show();
                }
            });
        } else {
            $('.data-item').show();
        }
        $('#hidden').text(count);
    });

    //全不选
    $('[data-action="check-clear"]').on('click', function () {
        var target = $(this).data('target'),
            elem = $('[data-name="' + target + '"]');
        $(elem).each(function (index) {
            elem[index].checked = false;
        });
    });

})();