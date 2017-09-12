$(document).ready(function () {

    $(".swiper-container").swiper({
        pagination : '.swiper-pagination',
        loop: true,
        autoplay:5000,
        autoplayDisableOnInteraction: false

    });
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
                url: WAP_PATH + 'index.php?m=wap&c=index&a=ajax_live_game_data',
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
         

                            //页面上通过data-key记录数据的对应关系
                            $(key_arr).each(function() {
                                var need_to_update = target.find('[data-key="' + this + '"]');

                                //如果发生进球，进球球队高亮
                                if ((this == 'homescore' || this == 'awayscore') && (Number(value[this]) != Number(need_to_update.text())) && Number(value[this]) > 0) {
                                    //球队高亮，比分红色，进球动画
                                    target.find('.' + need_to_update.data('target')).addClass('has-goal');
                                    target.find(need_to_update.data('animate')).html(animate);
                                    need_to_update.addClass('score-goal');

                    
                                    setTimeout(function() {
                                        target.find('.' + need_to_update.data('target')).removeClass('has-goal');
                                        need_to_update.removeClass('score-goal');
                                    }, 1000 * 30);

                                    //60s后清除进球动画
                                    setTimeout(function () {
                                        target.find(need_to_update.data('animate')).empty();
                                    }, 1000 * 30);

                                }
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
                            });
                        });

                        data = alert_tag = audio_tag = audio = key_arr = null;
                    }
                }
            });
        }
    },1000 * 10);
});