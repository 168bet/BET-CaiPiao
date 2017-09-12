$(document).ready(function () {
    //每隔60s刷新即将开始赛事
    setInterval(function() {
        var ready_to_start = $('#ready-list').find('.card[data-status-id="0"]'),
            start_list = $('#start-list').find('.list-container'),
            current_time = new Date().getTime();
        $(ready_to_start).each(function() {
            var start_time = $(this).data('startTime') * 1000;
            if (start_time - current_time <= 60000) {
                $(this).attr('ajax-status-tag', true);
                start_list.append($(this).detach());
            }
        });
    }, 1000 * 60);

    //每隔10s请求ajax_live_game_data接口刷新比赛基本数据
    setInterval(function(){
        var game_ids = [],
            start_list = $('#start-list'),
        //需要提交请求的tr，通过ajax-status-tag判断
            need_to_request_tr = start_list.find('.card[ajax-status-tag]');

        //本次请求的比赛编号
        need_to_request_tr.each(function(){
            game_ids.push($(this).data('gameId'));
        });

        if(game_ids.length > 0){
            $.ajax({
                data: {
                    gameids: game_ids
                },
                url: WAP_PATH + 'index.php?m=wap&c=football&a=ajax_live_game_data',
                type: 'post',
                dataType: 'json',
                success: function(result){
                    if (result.state) {
                        var data = result.data,
                            //audio_tag = $('#audio-btn').get(0).checked,
                            //alert_tag = $('#alert-btn').get(0).checked,
                            //audio = $('#audio').get(0),
                            end_list = $('#end-list').find('.list-container'),
                            animate = $('<img src="' + IMG_PATH + 'icon/score-goal.gif">');
                        //需要更新的数据：比赛进行时间，主队得分，客队得分，半场比分，红黄牌，角球数
                        key_arr = ['homescore', 'awayscore', 'homeredcard', 'awayredcard', 'homeyellowcard', 'awayyellowcard', 'homecorner', 'awaycorner', 'text'];

                        //遍历需要更新数据的tr
                        $(data).each(function(){
                            var target = start_list.find('.card[data-game-id="' + this.gameid + '"]'),
                                value = this;

                            //更新比赛状态
                            target.attr('data-status-id', value.status);
                            //if (value.state_tag == true) {
                            //    target.find('.table-status').addClass('add');
                            //} else {
                            //    target.find('.table-status').removeClass('add');
                            //}

                            //走地
                            //if (target.data('runTag') == true) {
                            //    if (value.run_tag == true) {
                            //        target.find('.is_run').removeClass('zd1 zd2').addClass('zd2').attr('title', '正在走地');
                            //    } else {
                            //        target.find('.is_run').removeClass('zd1 zd2').addClass('zd1').attr('title', '有走地赛事');
                            //    }
                            //}

                            //页面上通过data-key记录数据的对应关系
                            $(key_arr).each(function() {
                                var need_to_update = target.find('[data-key="' + this + '"]');

                                //如果发生进球，进球球队高亮
                                if ((this == 'homescore' || this == 'awayscore') && (Number(value[this]) != Number(need_to_update.text())) && Number(value[this]) > 0) {
                                    //球队高亮，比分红色，进球动画
                                    target.find('.' + need_to_update.data('target')).addClass('has-goal');
                                    target.find(need_to_update.data('animate')).html(animate);
                                    need_to_update.addClass('score-goal');

                                    //如果进球音勾选，则播放音频
                                    //if(audio_tag){
                                    //    audio.play();
                                    //}

                                    //进球弹窗提示
                                    //if(alert_tag){
                                    //    var alert_data = {
                                    //        competition_name: target.find('[competition-name]').text(),
                                    //        home_score: value.homescore,
                                    //        away_score: value.awayscore,
                                    //        status: value.time,
                                    //        home_team: target.find('.home-link').text(),
                                    //        away_team: target.find('.away-link').text(),
                                    //        goal_team: need_to_update.data('role'),
                                    //        color: target.find('[competition-name]').parents('td').css('backgroundColor')
                                    //    };
                                    //    createAlert(alert_data);
                                    //}

                                    //30s后清除高亮效果
                                    setTimeout(function() {
                                        target.find('.' + need_to_update.data('target')).removeClass('has-goal');
                                        need_to_update.removeClass('score-goal');
                                    }, 1000 * 30);

                                    //60s后清除进球动画
                                    setTimeout(function () {
                                        target.find(need_to_update.data('animate')).empty();
                                    }, 1000 * 30);

                                }

                                //红黄牌样式
                                if (this == 'homeredcard' || this == 'awayredcard' || this == 'homeyellowcard' || this == 'awayyellowcard') {
                                    //红黄牌0不处理
                                    if (value[this] != undefined && value[this] != 0) {
                                        need_to_update.addClass(need_to_update.data('style'));
                                    } else {
                                        value[this] = '';
                                    }
                                }

                                //填充数据
                                need_to_update.text(value[this]);

                                //如果比赛完场，则把本场比赛从请求中移除，不再更新数据
                                if (value.is_over == true) {
                                    target.removeAttr('ajax-status-tag');
                                    end_list.append(target.detach());
                                }
                            });
                        });

                        data = alert_tag = audio_tag = audio = key_arr = null;
                    }
                }
            });
        }
    },1000 * 10);
});