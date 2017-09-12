(function($){

	//$('#jicai').on('click','.jicai-item',function(){
    //
	//	$(this).addClass('active').siblings('li').removeClass('active');
	//});

	$('.banner').Xbanner({

        startIndex:0,
        isAuto:true
        
    });

    $('#tuku').slideBar();
    $('#video').slideBar();


    $(".table-star").click(function(){
        var i = $(this).find('i');
        val = $(this).closest("tr").find('input').val();
        val_arr = val.split('|');
        post_data = {"type": val_arr[0], "gameid": val_arr[1]};
        $.ajax({
            type: 'POST',
            url: '/index.php?m=member&c=index&a=collect',
            data: post_data,
            dataType: 'json',
            success: function (jsonData) {
                if (jsonData.status == true) {
                    if (jsonData.data[0]=='success') {
                        i.removeClass("icon-star-empty");
                        i.addClass("icon-star");
                    } else if(jsonData.data[0]=='cancel')  {
                        i.addClass("icon-star-empty");
                        i.removeClass("icon-star");
                    }

                }
            },
            error: function () {
            }
        })
    });
    //彩票特殊处理样式
    $('[data-action="lottery-list"]').each(function () {
        var type = $(this).data('type');
        switch (type) {
            //七星彩：后三位蓝色
            case 'qxc':
                $(this).find('.circle:gt(3)').addClass('special');
                break;
            //六合彩分红波，蓝波，绿波
            case 'xglhc':
                var red = [1,2,7,8,12,13,18,19,23,24,29,30,34,35,40,45,46],
                    blue = [3,4,9,10,14,15,20,25,26,31,36,37,41,42,47,48],
                    green = [5,6,11,16,17,21,22,27,28,32,33,38,39,43,44,49];
                $(this).find('.circle').each(function () {
                    var number = Number($(this).html());
                    if ($.inArray(number, red) > 0) {
                        $(this).addClass('circle-red');
                    } else if ($.inArray(number, blue) > 0) {
                        $(this).addClass('circle-blue');
                    } else {
                        $(this).addClass('circle-green');
                    }
                });
                //特码之前的“+”处理
                $(this).find('.circle:last').before('<span>&nbsp;+&nbsp;</span>');
                break;
            //其余彩种通过css控制
            default:
                break;
        }
    });
    //即时比赛每30请求一次事件
    setInterval(function () {
        $('[data-action="live-game-stats"][data-status!="true"]').each(function () {
            var dom = $(this),
                gameid = dom.data('game-id'),
                minute = dom.attr('data-minute'),
                src = IMG_PATH,
                delay = 1000 * 10;
            $.ajax({
                url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_goal_stats_info',
                type: 'post',
                data: {
                    gameid: gameid,
                    type: 1,
                    minute: minute
                },
                dataType: 'json',
                success: function (response) {
                    if (response.state) {
                        //事件
                        $(response.data).each(function () {
                            var event = dom.find('[data-stats="event"][data-type="' + this.Type + '"]');
                            //更新事件时间
                            dom.attr('data-minute', this.Minute);
                            //触发事件
                            switch (this.Event) {
                                case 0:
                                    src += 'goal.gif';
                                    delay = 1000 * 20;
                                    break;
                                case 1:
                                    src += 'point.gif';
                                    break;
                                case 2:
                                    src += 'own-goal.gif';
                                    break;
                                case 3:
                                    src += 'yellow-card.gif';
                                    break;
                                case 4:
                                    src += 'red-card.gif';
                                    break;
                                case 5:
                                    src += 'yr-merge.gif';
                                    break;
                                default:
                                    break;
                            }
                            event.addClass('active').html('<img src="' + src + '">');
                            setTimeout(function () {
                                event.removeClass('active');
                            }, delay);
                        });
                        //比分
                        dom.find('[data-stats="homescore"]').html(response.game_info.home_score);
                        dom.find('[data-stats="awayscore"]').html(response.game_info.away_score);
                        //比赛结束不再发送请求
                        if (response.game_info.status == false) {
                            dom.attr('data-status', true);
                        }
                    }
                }
            });
        });
    }, 1000 * 30);

    $('[data-action="link"]').on('click', function () {
        var url = $(this).data('url');
        window.open(url);
    });

    //重试次数限制
    var retry_limit = 0;
    //最新指数刷新
    $('[data-action="refresh"]').on('click', function () {
        var me = $(this),
            game_id = me.attr('data-id'),
            target = $(me.data('target'));
        $.ajax({
            url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_live_game_odds_data',
            data: {
                gameid: game_id
            },
            type: 'post',
            dataType: 'json',
            success: function (response) {
                if (response.state == true) {
                    var info = response.info,
                        odds = response.odds,
                        info_dom = target.find('#game-data'),
                        odds_dom = target.find('#odds-data'),
                        info_key = ['competition', 'home', 'away', 'score', 'link', 'date'],
                        odds_map = {
                            asia: ['up', 'give', 'down'],
                            euro: ['homewin', 'draw', 'awaywin'],
                            ou: ['big', 'total', 'small']
                        };
                    //更新比赛编号
                    me.attr('data-id', info.gameid);
                    //更新比赛基本信息
                    $.each(info_key, function () {
                        var need_to_update = info_dom.find('[data-key="' + this + '"]'),
                            value = info[this];
                        need_to_update.html(value);
                        //释放内存
                        need_to_update = value = null;
                    });
                    //更新指数
                    odds_dom.find('[data-key][data-company]').empty();
                    for (type in odds_map) {
                        if (odds.hasOwnProperty(type)) {
                            var odds_key = odds_map[type],
                                odds_list = odds[type];
                            for (company in odds_list) {
                                $.each(odds_key, function () {
                                    var odds_item = odds_dom.find('[data-key="' + this + '"][data-company="' + company + '"]'),
                                        odds_value = odds_list[company][this];
                                    odds_item.html(odds_value);
                                })
                            }
                        }
                        //释放内存
                        odds_item = odds_value = odds_list = odds_key = null;
                    }
                    //一旦请求成功，重置重试次数
                    retry_limit = 0;
                } else {
                    //如果重试次数限制超过3次
                    if (retry_limit < 3) {
                        //重置sessions保存的最新指数排除的比赛编号，防止sessions过期时间过长，导致用户长时间无法刷新最新指数数据
                        $.ajax({
                            url: APP_PATH + 'index.php?m=content&c=index&a=ajax_reset_sessions_data',
                            dataType: 'json',
                            data: {
                                field: 'game_ids'
                            },
                            type: 'post',
                            success: function (response) {
                                if (response.state == true) {
                                    console.log('success');
                                } else {
                                    console.log('fail');
                                }
                            }
                        });
                        //重新触发事件
                        me.trigger('click');
                        //重试限制+1
                        retry_limit += 1;
                    }
                }
            }
        });
    });

    //每隔10s刷新一次最新指数
    setInterval(function () {
        $('[data-action="refresh"]').trigger('click');
    }, 1000 * 10);

    //每隔4s切换一次首页图库推荐
    var album = [$('#basketball-baby'), $('#sports-beauty'), $('#football-baby')];
    setInterval(function () {
        var current = album.shift();
        current.trigger('click');
        album.push(current);
        current = null;
    }, 1000 * 4);

})(jQuery);

