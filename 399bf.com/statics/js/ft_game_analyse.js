/**
 * Created by lxt on 2016/12/27.
 */
$(document).ready(function () {
    //通过联赛过滤表格数据
    $('[data-action="competition-filter"]').each(function () {
        var target = $(this).data('target'),
            table = $('#' + target);
        $(this).find('li[data-value]').on('click', function () {
            //选中的单位增加checked属性
            $(this).siblings().removeAttr('checked');
            $(this).attr('checked', true);
            //触发complete事件
            table.trigger('complete');
        });
    });

    //通过场次过滤表格数据
    $('[data-action="size-filter"]').each(function () {
        var target = $(this).data('target'),
            table = $('#' + target);
        $(this).find('li[data-value]').on('click', function () {
            var size = $(this).data('value');
            //选中的单位增加checked属性
            $(this).siblings().removeAttr('checked');
            $(this).attr('checked', true);
            //触发complete事件
            table.trigger('complete');
        });
    });

    //全部赛事
    $('[data-action="table-recover"]').on('click', function () {
        var target = $(this).data('target'),
            table = $('#' + target);
        //清除指向目标表格的过滤条件
        $('[data-target="' + target + '"]').find('li[data-value][checked]').removeAttr('checked');
        table.find('tbody tr').show();
        //触发complete事件
        table.trigger('complete');
    });

    //过滤、统计表格数据
    $('[data-action="stats"]').on('complete', function () {
        var table = $(this),
            table_id = table.attr('id'),
            size = Number($('[data-action="size-filter"][data-target="' + table_id + '"]').find('li[data-value][checked]').data('value')),
            competition = $('[data-action="competition-filter"][data-target="' + table.attr('id') + '"]').find('li[data-value][checked]').data('value'),
            selector = competition ? '[data-competition="' + competition + '"]' : false;
        //先过滤联赛
        if (selector) {
            table.find('tbody tr').not(selector).hide();
            table.find('tbody tr' + selector).show();
        } else {
            table.find('tbody tr').show();
        }
        //再过滤场次
        if (size) {
            table.find('tbody tr:visible').each(function (index, obj) {
                if (Number(index) >= size) {
                    $(obj).hide()
                } else {
                    $(obj).show();
                }
            });
        }
        //统计
        switch (table_id) {
            //交锋
            case 'meet-table':
                var stats = {
                    count: 0,
                    //主队
                    main: {
                        win: 0,
                        draw: 0,
                        lose: 0
                    },
                    //主场
                    as_home: {
                        win: 0,
                        draw: 0,
                        lose: 0
                    },
                    //盘路
                    plate: {
                        win: 0,
                        waste: 0,
                        lose: 0
                    },
                    //大小
                    size: {
                        big: 0,
                        little: 0
                    },
                    //单双
                    single_double: {
                        single: 0,
                        double: 0
                    }
                };
                table.find('tbody tr:visible').each(function () {
                    var main = Number($(this).data('main-home-score')) - Number($(this).data('main-away-score')),
                        is_home = $(this).data('is-home'),
                        plate = $(this).data('plate'),
                        size = $(this).data('size'),
                        single_double = $(this).data('single-double');
                    //场次
                    stats.count += 1;
                    //主队
                    if (main > 0) {
                        stats.main.win += 1;
                    } else if (main < 0) {
                        stats.main.lose += 1;
                    } else {
                        stats.main.draw += 1;
                    }
                    //主场
                    if (is_home) {
                        var home = Number($(this).data('home-score')) - Number($(this).data('away-score'));
                        if (home > 0) {
                            stats.as_home.win += 1;
                        } else if (home < 0) {
                            stats.as_home.lose += 1;
                        } else {
                            stats.as_home.draw += 1;
                        }
                    }
                    //盘路
                    stats.plate[plate] += 1;
                    //大小
                    stats.size[size] += 1;
                    //单双
                    stats.single_double[single_double] += 1;
                });
                break;
            //主客历史战绩
            case 'history-home-table':
            case 'history-away-table':
                var stats = {
                    count: 0,
                    result: {
                        win: 0,
                        win_rate: 0,
                        draw: 0,
                        draw_rate: 0,
                        lose: 0,
                        lose_rate: 0
                    },
                    plate: {
                        win: 0,
                        win_rate: 0,
                        waste: 0,
                        waste_rate: 0,
                        lose: 0,
                        lose_rate: 0
                    },
                    single_double: {
                        single: 0,
                        double: 0
                    },
                    size: {
                        big: 0,
                        little: 0
                    },
                    half_size: {
                        big: 0,
                        little: 0
                    }
                };
                table.find('tbody tr:visible').each(function () {
                    var result = Number($(this).data('main-home-score')) - Number($(this).data('main-away-score')),
                        is_home = $(this).data('is-home'),
                        neutral = $(this).data('neutral'),
                        plate = $(this).data('plate'),
                        size = $(this).data('size'),
                        half_size = $(this).data('half-size'),
                        single_double = $(this).data('single-double');
                    //场次
                    stats.count += 1;
                    //赛果
                    if (result > 0) {
                        stats.result.win += 1;
                    } else if (result < 0) {
                        stats.result.lose += 1;
                    } else {
                        stats.result.draw += 1;
                    }
                    //盘路
                    stats.plate[plate] += 1;
                    //全场大小
                    stats.size[size] += 1;
                    //半场大小
                    stats.half_size[half_size] += 1;
                    //单双
                    stats.single_double[single_double] += 1;
                });
                stats.result.win_rate = Number((stats.result.win / stats.count) * 100).toFixed(2) + '%';
                stats.result.draw_rate = Number((stats.result.draw / stats.count) * 100).toFixed(2) + '%';
                stats.result.lose_rate = Number((stats.result.lose / stats.count) * 100).toFixed(2) + '%';
                stats.plate.win_rate = Number((stats.plate.win / stats.count) * 100).toFixed(2) + '%';
                stats.plate.waste_rate = Number((stats.plate.waste / stats.count) * 100).toFixed(2) + '%';
                stats.plate.lose_rate = Number((stats.plate.lose / stats.count) * 100).toFixed(2) + '%';
                break;
            default:
                break;
        }
        //更新统计数据
        if (stats) {
            for (key in stats) {
                var stats_node = $('[stats-target="' + table_id + '"]'),
                    value = stats[key];
                if ($.type(value) == 'object') {
                    //父节点
                    var node = stats_node.find('[data-stats="' + key + '"]');
                    //子节点
                    for (name in value) {
                        node.find('[data-stats="' + name + '"]').html(value[name]);
                    }
                } else {
                    stats_node.find('[data-stats="' + key + '"]').html(value);
                }
            }
        }
    });

    //标签页
    $('[data-action="tab"]').on('click', function () {
        var target = $(this).data('target');
        $('#' + target).addClass('active').siblings('.tab-item').removeClass('active');
    });

    //初始化页面
    $('[data-action="size-filter"]').find('li[data-value]:first').trigger('click');
});