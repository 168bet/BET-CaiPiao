$(document).ready(function () {
    //每隔20s刷新即将开始赛事
    setInterval(function() {
        var ready_to_start = $('#ready-list').find('.data-item[data-schedule-id]'),
            start_list = $('#start-list').find('.list-container'),
            current_time = new Date().getTime();
        $(ready_to_start).each(function() {
            var start_time = $(this).data('startTime') * 1000;
            if (start_time - current_time <= 60000) {
                start_list.append($(this).detach());
            }
        });
    }, 1000 * 20);

    //每隔10s请求schedule_data接口刷新比赛基本数据,rate_date接口更新赔率
    setInterval(function(){
        var schedule_ids = [],
            start_list = $('#start-list'),
        //需要提交请求的tr，通过data-schedule-id判断
            need_to_request_tr = start_list.find('.data-item[data-schedule-id]');

        //本次请求的比赛编号
        need_to_request_tr.each(function(){
            schedule_ids.push($(this).data('scheduleId'));
        });

        if(schedule_ids.length > 0){
            $.ajax({
                data: {
                    schedule_id: schedule_ids
                },
                url: WAP_PATH + 'index.php?m=wap&c=basketball&a=schedule_data',
                type: 'post',
                dataType: 'json',
                success: function(result){
                    if (result.status) {
                        var data = result.data.in_progress,
                        //audio_tag = $('#audio-btn').get(0).checked,
                        //alert_tag = $('#alert-btn').get(0).checked,
                        //audio = $('#audio').get(0),
                            end_list = $('#end-list').find('.list-container'),
                            //animate = $('<img src="' + IMG_PATH + 'icon/score-goal.gif">');
                        //需要更新的数据
                        key_arr = ['date', 'status', 'remaintime', 'homeone', 'hometwo', 'homethree', 'homefour', 'guestone', 'guesttwo', 'guestthree', 'guestfour', 'homescore', 'guestscore'];

                        //遍历需要更新数据的
                        $(data).each(function(){
                            var target = start_list.find('.data-item[data-schedule-id="' + this.scheduleid + '"]'),
                                value = this;

                            //页面上通过data-key记录数据的对应关系
                            $(key_arr).each(function() {
                                var need_to_update = target.find('[data-key="' + this + '"]');

                                //如果发生进球，进球球队高亮
                                if ((this == 'homescore' || this == 'guestscore') && (Number(value[this]) != Number(need_to_update.text())) && Number(value[this]) > 0) {
                                    //球队高亮，比分红色，进球动画
                                    target.find('.' + need_to_update.data('target')).addClass('has-goal');
                                    //target.find(need_to_update.data('animate')).html(animate);
                                    //need_to_update.addClass('red');

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
                                        //need_to_update.removeClass('red');
                                    }, 1000 * 30);

                                    //60s后清除进球动画
                                    //setTimeout(function () {
                                    //    target.find(need_to_update.data('animate')).empty();
                                    //}, 1000 * 30);

                                }


                                //填充数据
                                need_to_update.text(value[this]);

                                //如果比赛完场，则把本场比赛从请求中移除，不再更新数据
                                if (value.is_over == true) {
                                    //target.removeAttr('ajax-status-tag');
                                    end_list.append(target.detach());
                                }
                            });
                        });

                        data = alert_tag = audio_tag = audio = key_arr = null;
                    }
                }
            });
            //赔率
            $.ajax({
                data: {
                    schedule_id: schedule_ids
                },
                type: 'post',
                dataType: 'json',
                url: WAP_PATH + 'index.php?m=wap&c=basketball&a=rate_data',
                success: function (result) {
                    if (result.status) {
                        var data = result.data.in_progress,
                            end_list = $('#end-list').find('.list-container');
                        //遍历数据
                        $(data).each(function () {
                            var target = start_list.find('.data-item[data-schedule-id="' + this.scheduleid + '"]'),
                                need_to_update = this.letgoal >= 0 ? target.find('[data-key="home-letgoal"]') : target.find('[data-key="guest-letgoal"]'),
                                value = Math.abs(this.letgoal);
                            //赔率变化趋势
                            if (Number(value) > Number(need_to_update.html())) {
                                //上升todo
                                need_to_update.addClass('up');

                            } else if(Number(value) < Number(need_to_update.html())){
                                //下降todo
                                need_to_update.addClass('down');
                            } else {
                                //无变化
                            }
                            target.find('[data-key="home-letgoal"],[data-key="guest-letgoal"]').empty();
                            need_to_update.html(value);
                            //3s后清除变化样式
                            setTimeout(function(){
                                need_to_update.removeClass('up').removeClass('down');
                            },3000);
                        });


                        //释放资源
                        data = target = value = need_to_update = null;
                    }
                }
            });
        }
    },1000 * 10);
});