$(document).ready(function () {
    $('#treeMenu').treeCreate();
    //赛季
    $('[data-action="link"]').on('click', function () {
        window.location.assign($(this).data('url'));
    });
    //过滤
    $('[data-action="filter"]').each(function () {
        var table = $($(this).data('target')),
            show = $($(this).data('show'));
        $(this).find('li[data-value]').on('click', function () {
            show.html($(this).html());
            $(this).siblings().removeAttr('selected');
            $(this).attr('selected', true);
            table.trigger('complete');
        });
    });
    //类别
    $('[data-action="category-filter"]').on('click', function () {
        var table = $($(this).data('target'));
        $(this).siblings('[data-action="category-filter"]').removeAttr('selected');
        $(this).attr('selected', true);
        table.trigger('complete');
    });
    //过滤数据
    $('.schedule-table').on('complete', function () {
        var team = {},
            category = $('[data-action="category-filter"][selected]'),
            selector = 'tbody tr',
            not_selector = '',
            value = false,
            table = $(this);
        //过滤类别
        if (category.length > 0) {
            table.find('tbody tr[data-' + category.data('filter') + '="' + category.data('value') + '"]').show();
            table.find('tbody tr[data-' + category.data('filter') + '!="' + category.data('value') + '"]').hide();
        }
        //过滤球队
        $('[data-action="filter"][data-type="team"]').each(function () {
            if ($(this).find('li[selected]').data('value') != undefined) {
                team[$(this).data('filter')] = $(this).find('li[selected]').data('value');
            }
        });
        for (key in team) {
            value = team[key];
            selector += value != false ? '[data-' + key + '="' + value + '"]' : '';
            if (value != false) {
                not_selector = 'tbody tr[data-' + key + '!="' + value + '"]';
                table.find(not_selector).hide();
            }
        }
        table.find(category.length > 0 ? selector + ':visible' : selector).show();
    });
});