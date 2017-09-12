/**
 * Created by Administrator on 2016/7/28.
 */
$(document).ready(function () {
    //联赛筛选
    $('[data-action="competition-filter"]').on('click', function () {
        $($(this).data('target')).trigger('complete');
    });
    //场次筛选
    $('[data-action="size-filter"]').each(function () {
        var table = $($(this).data('target')),
            show = $($(this).data('show'));
        $(this).find('li[data-value]').on('click', function () {
            var value = $(this).data('value');
            show.html(value);
            //选中的单位增加checked属性
            $(this).siblings().removeAttr('checked');
            $(this).attr('checked', true);
            //触发complete事件
            table.trigger('complete');
        });
    });
    //过滤，统计表格
    $('[data-action="stats-table"]').on('complete', function () {
        var table = $(this),
            target = $(table.data('target')),
            size = $('[data-action="size-filter"]').find('li[data-value][checked]').data('value'),
            stats = {
                count: 0,
                result: {
                    win: 0,
                    equal: 0,
                    lose: 0
                },
                plate: {
                    win: 0,
                    waste: 0,
                    lose: 0
                },
                size: {
                    big: 0,
                    little: 0
                },
                half_size: {
                    big: 0,
                    little: 0
                },
                single_double: {
                    single: 0,
                    double: 0
                }
            };
        //先过滤联赛
        $('[data-action="competition-filter"]').each(function () {
            var value = $(this).data('value'),
                checked = this.checked,
                selector = 'tbody tr[data-competition="' + value + '"]';
            if (checked) {
                table.find(selector).show();
            } else {
                table.find(selector).hide();
            }
        });
        //过滤场次
        table.find('tbody tr:visible').each(function (index, obj) {
            if (Number(index) >= Number(size)) {
                $(obj).hide();
            } else {
                $(obj).show();
            }
        });
        //统计表格
        table.find('tbody tr:visible').each(function () {
            var result = $(this).data('result'),
                size = $(this).data('size'),
                half_size = $(this).data('half-size'),
                single_double = $(this).data('single-double'),
                plate = $(this).data('plate');
            //场次
            stats.count += 1;
            //胜负
            stats.result[result] += 1;
            //盘路
            stats.plate[plate] += 1;
            //大小
            stats.size[size] += 1;
            //半场大小
            stats.half_size[half_size] += 1;
            //单双
            stats.single_double[single_double] += 1;
        });
        //统计概率
        stats.result.win_rate = Number((stats.result.win / stats.count) * 100).toFixed(2) + '%';
        stats.result.equal_rate = Number((stats.result.equal / stats.count) * 100).toFixed(2) + '%';
        stats.result.lose_rate = Number((stats.result.lose / stats.count) * 100).toFixed(2) + '%';
        stats.plate.win_rate = Number((stats.plate.win / stats.count) * 100).toFixed(2) + '%';
        stats.plate.waste_rate = Number((stats.plate.waste / stats.count) * 100).toFixed(2) + '%';
        stats.plate.lose_rate = Number((stats.plate.lose / stats.count) * 100).toFixed(2) + '%';
        //更新统计数据
        if (stats) {
            for (key in stats) {
                var value = stats[key];
                if ($.type(value) == 'object') {
                    //父节点
                    var node = target.find('[data-type="' + key + '"]');
                    //子节点
                    for (name in value) {
                        node.find('[data-stats="' + name + '"]').html(value[name]);
                    }
                } else {
                    target.find('[data-stats="' + key + '"]').html(value);
                }
            }
        }
    });
    //初始化页面
    $('[data-action="size-filter"]').find('li[data-value]:first').trigger('click');
});