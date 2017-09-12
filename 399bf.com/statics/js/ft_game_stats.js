/**
 * Created by Administrator on 2016/9/20.
 */
$(function(){
    streak($('[role="streak"]'),true);
    streak($('[role="streak_"]'));

    function setProgress(){

        $('#table-content').find('.table-progress').each(function() {

            var size = $(this).data('size');

            $(this).css({
                width: size + 'px'
            })

        });
    }

    setProgress();

    $('#event-table').on('rebuild', function () {
        $(this).find('.event-row:odd').addClass('black');
    }).trigger('rebuild');

    $('#stat-table').on('rebuild', function () {
        streak($('[role="streak_"]'));
        setProgress();
    });

    $('#substitution-table').on('rebuild', function () {
        streak($('[role="streak_"]'));
    });

    //每60s更新事件统计
    setInterval(function() {
        if (EVENT_TAG) {
            var event_table = $('#event-table'),
                minute = event_table.find('.event-row').last().data('minute');

            //请求数据
            $.ajax({
                url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_goal_stats_info',
                type: 'post',
                dataType: 'json',
                data: {
                    gameid: GAME_ID,
                    minute: minute,
                    type: 1
                },
                success: function (result) {
                    if (result.state == true) {
                        var game_info = result.game_info,
                            data = result.data,
                            format_player = $('#home-player,#away-player');

                        //更新标签
                        EVENT_TAG = game_info.status;

                        $(data).each(function () {
                            var value = this,
                                event_row = $('<tr class="event-row" data-minute="' + value.Minute + '"></tr>'),
                                home_event = $('<td></td>'),
                                away_event = $('<td></td>'),
                                time = $('<td></td>'),
                                time_style = $('<span class="blockBG second"></span>'),
                                style = $('<span class="blockBG ' + value.Class + '"></span>'),
                                player_style = $('<span class="blockBG ' + value.Class + '"></span>'),
                                score = value.hasOwnProperty('Score') ? value.Score : '';

                            //主客队事件
                            switch (Number(value.Type)) {
                                case 1:
                                    home_event.append(score, value.Pname, style);
                                    break;
                                case 2:
                                    away_event.append(style, value.Pname, score);
                                    break;
                                default:
                                    break;
                            }

                            //时间
                            var overtime = value.hasOwnProperty('Overtime') ? value.Overtime : '';
                            time.append(value.Minute, overtime, time_style);

                            event_row.append(home_event, time, away_event);

                            //插入节点
                            event_table.append(event_row);

                            //如果有预测阵容，则将事件绑定到球员上
                            format_player.find('[data-id="' + value.Pid + '"]').after(player_style);

                            //释放内存
                            value = event_row = home_event = away_event = time = time_style = style = score = player_style = null;
                        });

                        //如果完场要生成完场比分
                        if (game_info.status == false) {
                            $('#game-end').html('全场结束 ' + game_info.home_score + ':' + game_info.away_score);
                        }

                        //触发样式事件
                        event_table.trigger('rebuild');

                        //释放内存
                        game_info = data = format_player = over_score_row = over_score = null;
                    }
                }
            });
        }
    }, 1000 * 60);

    //每隔120s更新换人数据
    setInterval(function () {
        if (SUBSTITUTION_TAG) {
            var substitution_table = $('#substitution-table'),
                minute = substitution_table.find('.substitution-row').last().data('minute');

            //请求数据
            $.ajax({
                url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_goal_stats_info',
                type: 'post',
                dataType: 'json',
                data: {
                    gameid: GAME_ID,
                    minute: minute ? minute : 0,
                    type: 2
                },
                success: function (result) {
                    if (result.state == true) {
                        var game_info = result.game_info,
                            data = result.data,
                            format_player = $('#home-player,#away-player');

                        //更新标签
                        SUBSTITUTION_TAG = game_info.status;

                        $(data).each(function () {
                            var value = this,
                                substitution_row = $('<tr class="substitution-row" data-minute="' + value.Minute + '"></tr>'),
                                blank = $('<td></td><td></td><td></td>'),
                                icon = $('<td><span class="icon-substitute"></span></td>'),
                                style = $('<span class="blockBG substitute"></span>'),
                                time = $('<td></td>').append(value.Minute),
                                up = $('<td><a href="' + APP_PATH + 'player/' + value.Upid + '/" target="_blank"><span class="red">' +  value.Upname + '<i class="submen red"></i></span></a></td>'),
                                down = $('<td><a href="' + APP_PATH + 'player/' + value.Downid + '/" target="_blank"><span class="red">' +  value.Downname + '<i class="submen red"></i></span></a></td>');

                            //主客队换人
                            switch (Number(value.Type)) {
                                case 1:
                                    substitution_row.append(up, icon, down, time, blank);
                                    break;
                                case 2:
                                    substitution_row.append(blank, time, up, icon, down);
                                    break;
                                default:
                                    break;
                            }

                            //插入节点
                            substitution_table.append(substitution_row);

                            //如果有预测阵容，则将换人事件绑定到球员上
                            format_player.find('[data-id="' + value.Upid + '"]').after(style);
                            format_player.find('[data-id="' + value.Downid + '"]').after(style);

                            //释放内存
                            value = substitution_row = up = down = blank = icon = style = time = null;
                        });

                        //触发样式事件
                        substitution_table.trigger('rebuild');

                        //释放内存
                        game_info = data = format_player = null;
                    }
                }
            });
        }
    }, 1000 * 60 * 2);

    //每隔120s更新数据统计信息
    setInterval(function () {
        if (STAT_TAG) {
            var stat_table = $('#stat-table');

            //请求数据
            $.ajax({
                url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_stat_info',
                type: 'post',
                dataType: 'json',
                data: {
                    gameid: GAME_ID
                },
                success: function (result) {
                    if (result.state == true) {
                        var data = result.data,
                            stat_row_temp = stat_table.empty();

                        //更新标签
                        STAT_TAG = result.status;

                        $(data).each(function () {
                            var value = this,
                                stat_row = $('<tr class="stat-row"></tr>'),
                                home = $('<td class="text-right border"></td>'),
                                home_progress = $('<span class="table-progress orange" data-size="' + value.Home + '"></span>'),
                                away = $('<td class="text-left"></td>'),
                                away_progress = $('<span class="table-progress red" data-size="' + value.Away + '"></span>'),
                                name = $('<td class="border"></td>').html(value.Name);

                            //插入节点
                            home.append(value.Home, home_progress);
                            away.append(away_progress, value.Away);
                            stat_row.append(home, name, away);
                            //先不直接插入目标表格，统一填充到缓存对象中，全部循环结束之后再一次性插入到正式表格
                            stat_row_temp.append(stat_row);

                            //释放内存
                            value = stat_row = home = home_progress = away = away_progress = name = null;
                        });

                        stat_table = stat_row_temp;

                        //触发样式事件
                        stat_table.trigger('rebuild');

                        //释放内存
                        data = stat_row_temp = null;
                    }
                }
            });
        }
    }, 1000 * 60 * 2);

});