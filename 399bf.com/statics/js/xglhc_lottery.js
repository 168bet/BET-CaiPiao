(function ($) {

    $('#treeMenu').treeCreate({
        toggleclass: ['icon-close', 'icon-open', 'icon-plus', 'icon-minus']
    });

    $('[data-action="link"]').on('click', function () {
        window.location.assign($(this).data('url'));
    });

    //遗漏
    $('#omission').click(function () {
        var bool = $(this).siblings('input').prop('checked');
        if (bool) {
            $(this).removeClass('checkbox-on').addClass('checkbox-off');
            $(this).siblings('input').prop('checked', false);
            $('.color').addClass('colorw');
        } else {
            $(this).removeClass('checkbox-off').addClass('checkbox-on');
            $(this).siblings('input').prop('checked', true);
            $('.color').removeClass('colorw');
        }
    });

    //遗漏分层
    $('#layer').click(function () {
        var bool = $(this).siblings('input').prop('checked'),
            tr = $('tr[data-row]');
        if (bool) {
            $(this).removeClass('checkbox-on').addClass('checkbox-off');
            $(this).siblings('input').prop('checked', false);
            $('td.lost-layer').removeClass('lost-layer');
        } else {
            $(this).removeClass('checkbox-off').addClass('checkbox-on');
            $(this).siblings('input').prop('checked', true);
            for (i = 1; i <= 49; i ++) {
                var index_selector = '[data-index="' + i + '"]',
                    td_arr = tr.find('td' + index_selector),
                    row = $(index_selector + '.on:last').parent('tr').data('row') == undefined ? $(index_selector + ':first').parent('tr').data('row') + 1 : $(index_selector + '.on:last').parent('tr').data('row');
                td_arr.each(function () {
                    if (Number($(this).parent('tr').data('row')) < Number(row)) {
                        $(this).addClass('lost-layer');
                    }
                })
            }
        }
    });


    //分隔线
    $('#splitLine').click(function () {
        var bool = $(this).siblings('input').prop('checked');
        if (bool) {
            $(this).removeClass('checkbox-on').addClass('checkbox-off');
            $(this).siblings('input').prop('checked', false);
            $('.trend table tr').css('border', 'none');
        } else {
            $(this).removeClass('checkbox-off').addClass('checkbox-on');
            $(this).siblings('input').prop('checked', true);
            for (var i = 6; i <= ($('.trend table tr').length - 8);) {
                $('.trend table tr').eq(i).css('border-bottom', '2px solid #D3D3D3');
                i = i + 5;
            }
        }
    });

    //计算柱状图高度
    var columnH=[];
    for(var i=0;i<$('.Histogram').length;i++){
        columnH.push($('.Histogram').eq(i).height());
    }
    var resultH=Math.max.apply(Math,columnH);
    $('.HistogramC').css('height',resultH+15);
})(jQuery);