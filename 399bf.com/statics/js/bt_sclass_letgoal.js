$(document).ready(function () {
    $('#treeMenu').treeCreate();
    //赛季
    $('[data-action="link"]').on('click', function () {
        window.location.assign($(this).data('url'));
    });
    //球队过滤
    $('[data-action="filter"]').find('li[data-value]').on('click', function () {
        var table = $($(this).parent('ul').data('target')),
            show = $($(this).parent('ul').data('show'));
        $(this).siblings().removeAttr('selected');
        $(this).attr('selected', true);
        show.html($(this).html());
        table.trigger('complete');
    });
    //过滤数据
    $('.standings-table').on('complete', function () {
        var team = $('[data-filter="team"]').find('li[data-value][selected]').data('value'),
            selector = team != false ? 'tbody tr[data-team="' + team + '"]' : 'tbody tr',
            not_selector = team != false ? 'tbody tr[data-team!="' + team + '"]' : false;
        $(this).find(selector).show();
        if (not_selector != false) {
            $(this).find(not_selector).hide();
        }
    });
});