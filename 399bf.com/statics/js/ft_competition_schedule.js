/**
 * Created by Administrator on 2017/2/16.
 */
$(document).ready(function () {
    //筛选
    $('[data-action="filter"]').each(function () {
        //隐藏域
        var target = $($(this).data('target')),
            show = $($(this).data('show')),
            type = $(this).data('type'),
            table = $('#data-table');
        //绑定点击事件
        $(this).find('li').on('click', function () {
            var value = $(this).data('value'),
                selector = '';
            //切换选中
            target.attr('value', value);
            show.html($(this).html());
            //筛选
            switch (type) {
                case 'all':
                    selector = 'tbody tr[data-home="' + value + '"],tbody tr[data-away="' + value + '"]';
                    table.find('tbody tr').hide();
                    table.find(selector).show();
                    break;
                default:
                    selector = 'tbody tr[data-' + type + '="' + value + '"]';
                    table.find('tbody tr').hide();
                    table.find(selector).show();
                    break;
            }
        });
    });
    //链接
    $('[data-action="link"]').on('click', function () {
        var base = $(this).data('base'),
            team_id = $('#teamid').val(),
            home_id = $('#hometeamid').val(),
            away_id = $('#awayteamid').val(),
            url = '';
        url = team_id ? base + 'teamid/' + team_id + '/' : base;
        url += home_id ? 'hometeamid/' + home_id + '/' : '';
        url += away_id ? 'awayteamid/' + away_id + '/' : '';
        window.location.assign(url);
    })
});
