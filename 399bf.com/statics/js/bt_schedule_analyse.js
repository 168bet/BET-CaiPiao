(function($){

    var $jinqi = $('#jinqi');

    $jinqi.find('.table').each(function(){

        $(this).find('tbody tr:gt(10)').hide();
    });

    compute();

})(jQuery);


function homeLetCompare(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#homeLetCompareButton").text(text);
    $(".homeLetCompare1").hide();
    $(".homeLetCompare2").hide();
    $(".homeLetCompare3").hide();
    $(".homeLetCompare4").hide();
    $(".homeLetCompare" + value).show();
}

function guestLetCompare(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#guestLetCompareButton").text(text);
    $(".guestLetCompare1").hide();
    $(".guestLetCompare2").hide();
    $(".guestLetCompare3").hide();
    $(".guestLetCompare4").hide();
    $(".guestLetCompare" + value).show();
}

function homeTotalCompare(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#homeTotalCompareButton").text(text);
    $(".homeTotalCompare1").hide();
    $(".homeTotalCompare2").hide();
    $(".homeTotalCompare3").hide();
    $(".homeTotalCompare4").hide();
    $(".homeTotalCompare" + value).show();
}

function guestTotalCompare(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#guestTotalCompareButton").text(text);
    $(".guestTotalCompare1").hide();
    $(".guestTotalCompare2").hide();
    $(".guestTotalCompare3").hide();
    $(".guestTotalCompare4").hide();
    $(".guestTotalCompare" + value).show();
}

function homeSamePlate(value) {
    if (value == 1) {
        text = '近5场';
    } else if (value == 2) {
        text = '近10场';
    }

    $("#homeSamePlateButton").text(text);
}


function guestSamePlate(value) {
    if (value == 1) {
        text = '近5场';
    } else if (value == 2) {
        text = '近10场';
    }

    $("#guestSamePlateButton").text(text);
}

function homeSameTotal(value) {
    if (value == 1) {
        text = '近5场';
    } else if (value == 2) {
        text = '近10场';
    }

    $("#homeSameTotalButton").text(text);
}

function guestSameTotal(value) {
    if (value == 1) {
        text = '近5场';
    } else if (value == 2) {
        text = '近10场';
    }

    $("#guestSameTotalButton").text(text);
}
//----------------------

function homeAvgCompare(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#homeAvgCompareButton").text(text);
    $(".homeAvgCompare1").hide();
    $(".homeAvgCompare2").hide();
    $(".homeAvgCompare3").hide();
    $(".homeAvgCompare4").hide();
    $(".homeAvgCompare" + value).show();
}

function guestAvgCompare(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#guestAvgCompareButton").text(text);
    $(".guestAvgCompare1").hide();
    $(".guestAvgCompare2").hide();
    $(".guestAvgCompare3").hide();
    $(".guestAvgCompare4").hide();
    $(".guestAvgCompare" + value).show();
}

//----------------------
function homeTeamScore(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#homeTeamScoreButton").text(text);
    $(".homeTeamScore1").hide();
    $(".homeTeamScore2").hide();
    $(".homeTeamScore3").hide();
    $(".homeTeamScore4").hide();
    $(".homeTeamScore" + value).show();
}

function guestTeamScore(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#guestTeamScoreButton").text(text);
    $(".guestTeamScore1").hide();
    $(".guestTeamScore2").hide();
    $(".guestTeamScore3").hide();
    $(".guestTeamScore4").hide();
    $(".guestTeamScore" + value).show();
}
//----------------------------------------
function homeTotalScore(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#homeTotalScoreButton").text(text);
    $(".homeTotalScore1").hide();
    $(".homeTotalScore2").hide();
    $(".homeTotalScore3").hide();
    $(".homeTotalScore4").hide();
    $(".homeTotalScore" + value).show();
}

function guestTotalScore(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#guestTotalScoreButton").text(text);
    $(".guestTotalScore1").hide();
    $(".guestTotalScore2").hide();
    $(".guestTotalScore3").hide();
    $(".guestTotalScore4").hide();
    $(".guestTotalScore" + value).show();
}

//----------------------------------------
function homeHalfTotal(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#homeHalfTotalButton").text(text);
    $(".homeHalfTotal1").hide();
    $(".homeHalfTotal2").hide();
    $(".homeHalfTotal3").hide();
    $(".homeHalfTotal4").hide();
    $(".homeHalfTotal" + value).show();
}

function guestHalfTotal(value) {
    if (value == 1) {
        text = '总';
    } else if (value == 2) {
        text = '近5场';
    } else if (value == 3) {
        text = '近10场';
    } else if (value == 4) {
        text = '近20场';
    }

    $("#guestHalfTotalButton").text(text);
    $(".guestHalfTotal1").hide();
    $(".guestHalfTotal2").hide();
    $(".guestHalfTotal3").hide();
    $(".guestHalfTotal4").hide();
    $(".guestHalfTotal" + value).show();
}

//------------------------------------------
function homeAnalyze(value) {
    if (value == 1) {
        text = '前后6场';
    } else if (value == 2) {
        text = '未来6场';
    }

    $("#homeAnalyzeButton").text(text);
    $(".homeAnalyze1").hide();
    $(".homeAnalyze2").hide();
    $(".homeAnalyze" + value).show();
}

function guestAnalyze(value) {
    if (value == 1) {
        text = '前后6场';
    } else if (value == 2) {
        text = '未来6场';
    }

    $("#guestAnalyzeButton").text(text);
    $(".guestAnalyze1").hide();
    $(".guestAnalyze2").hide();
    $(".guestAnalyze" + value).show();
}

//------------------------------------------
function homeRecent(value) {
    $(".homeRecentAll").show();

    if ($('#recent_general').is(':checked')) {
        $(".category2").show();
    } else {
        $(".category2").hide();
    }

    if ($('#recent_season_before').is(':checked')) {
        $(".category1").show();
    } else {
        $(".category1").hide();
    }

    if ($('#recent_season_after').is(':checked')) {
        $(".category3").show();
    } else {
        $(".category3").hide();
    }


    if ($('#recent_home').is(':checked')) {
        $(".guestData").hide();

        data = $.trim($("#homeRecentButton").text());

        if (value == "" || value == undefined) {
            if (data == '总') {
                value = 1;
            } else if (data == '近5场') {
                value = 2;
            } else if (data == '近10场') {
                value = 3;
            } else if (data == '近20场') {
                value = 4;
            }
        }

        display(value);
    } else { // 场数变更
        data = $.trim($("#homeRecentButton").text());

        if (value == "" || value == undefined) {
            if (data == '总') {
                value = 1;
            } else if (data == '近5场') {
                value = 2;
            } else if (data == '近10场') {
                value = 3;
            } else if (data == '近20场') {
                value = 4;
            }
        }

        display(value);
    }

    //刷新正文统计
    compute();
}


function display(value) {
    var count = 0;

    if (value == 1) {
        count = 100;
        text = '总';
    } else if (value == 2) {
        count = 5;
        text = '近5场';
    } else if (value == 3) {
        count = 10;
        text = '近10场';
    } else if (value == 4) {
        count = 20;
        text  = '近20场';
    }

    var num = 0;

    $(".homeRecentAll").each(function (i, n) {
        if ($(this).css('display') == 'table-row') {
            num += 1;
            $(".homeRecent" + i).show();

            if (num > count) {
                $(".homeRecent" + i).hide();
            }
        }
    });

    $("#homeRecentButton").text(text);
}


function guestRecent(value) {
    $(".guestRecentAll").show();

    if ($('#guest_recent_general').is(':checked')) {
        $(".guest_category2").show();
    } else {
        $(".guest_category2").hide();
    }

    if ($('#guest_recent_season_before').is(':checked')) {
        $(".guest_category1").show();
    } else {
        $(".guest_category1").hide();
    }

    if ($('#guest_recent_season_after').is(':checked')) {
        $(".guest_category3").show();
    } else {
        $(".guest_category3").hide();
    }

    if ($('#guest_recent_home').is(':checked')) {
        $(".homeData").hide();

        data = $.trim($("#guestRecentButton").text());

        if (value == "" || value == undefined) {
            if (data == '总') {
                value = 1;
            } else if (data == '近5场') {
                value = 2;
            } else if (data == '近10场') {
                value = 3;
            } else if (data == '近20场') {
                value = 4;
            }
        }

        guest_display(value);
    } else { // 场数变更
        data = $.trim($("#guestRecentButton").text());

        if (value == "" || value == undefined) {
            if (data == '总') {
                value = 1;
            } else if (data == '近5场') {
                value = 2;
            } else if (data == '近10场') {
                value = 3;
            } else if (data == '近20场') {
                value = 4;
            }
        }

        guest_display(value);
    }

    //刷新下方统计
    compute();
}

function guest_display(value) {
    var count = 0;

    if (value == 1) {
        count = 100;
        text = '总';
    } else if (value == 2) {
        count = 5;
        text = '近5场';
    } else if (value == 3) {
        count = 10;
        text = '近10场';
    } else if (value == 4) {
        count = 20;
        text  = '近20场';
    }

    var num = 0;

    $(".guestRecentAll").each(function (i, n) {
        if ($(this).css('display') == 'table-row') {
            num += 1;
            $(".guestRecent" + i).show();

            if (num > count) {
                $(".guestRecent" + i).hide();
            }
        }
    });

    $("#guestRecentButton").text(text);
}

function compute(){

    var $jinqi = $('#jinqi'),
        $jinqi_table = $jinqi .find('.table'),

        //总场    主
        home_count = '[name="homecount"]',
        //胜场
        home_win = '[name="homewin"]',
        //负场
        home_lose = '[name="homelose"]',
        //胜率
        homewin_rate = '[name="homewin_rate"]',
        //赢盘率
        homedish_rate = '[name="homedish_rate"]',
        //大球率
        homeball_rate = '[name="homeball_rate"]',


        guest_count = '[name="guestcount"]',
        guest_win = '[name="guestwin"]',
        guest_lose = '[name="guestlose"]',
        guestwin_rate = '[name="guestwin_rate"]',
        guestdish_rate = '[name="guestdish_rate"]',
        guestball_rate = '[name="guestball_rate"]';


    // 获取 计算 各个值
    var $home_table = $jinqi_table.eq(0),
        $guest_table = $jinqi_table.eq(1),

        h_count = $home_table.find('tr.homeRecentAll:visible').length,
        g_count = $guest_table.find('tr.guestRecentAll:visible').length,
        h_win = $home_table.find('.win:visible').length,
        g_win = $guest_table.find('.win:visible').length,
        h_dish = $home_table.find('.gain:visible').length,
        g_dish = $guest_table.find('.gain:visible').length,
        h_big = $home_table.find('.big:visible').length,
        g_big = $guest_table.find('.big:visible').length,

        h_lose = h_count - h_win,
        g_lose = g_count - g_win,
        h_win_rate = h_win/h_count * 100,
        g_win_rate = g_win/g_count * 100,
        h_dish_rate = h_dish/h_count * 100,
        g_dish_rate = g_dish/g_count * 100,
        h_ball_rate = h_big/h_count * 100,
        g_ball_rate = g_big/g_count * 100;

    //格式化浮点数
    h_win_rate = h_win_rate.toString().indexOf('.') != -1 ? h_win_rate.toFixed(2) : h_win_rate;
    g_win_rate = g_win_rate.toString().indexOf('.') != -1 ? g_win_rate.toFixed(2) : g_win_rate;

    h_dish_rate = h_dish_rate.toString().indexOf('.') != -1 ? h_dish_rate.toFixed(2) : h_dish_rate;
    g_dish_rate = g_dish_rate.toString().indexOf('.') != -1 ? g_dish_rate.toFixed(2) : g_dish_rate;

    h_ball_rate = h_ball_rate.toString().indexOf('.') != -1 ? h_ball_rate.toFixed(2) : h_ball_rate;
    g_ball_rate = g_ball_rate.toString().indexOf('.') != -1 ? g_ball_rate.toFixed(2) : g_ball_rate;


    h_win_rate = h_win_rate || 0;
    g_win_rate = g_win_rate || 0;

    h_dish_rate = h_dish_rate || 0;
    g_dish_rate = g_dish_rate || 0;

    h_ball_rate = h_ball_rate || 0;
    g_ball_rate = g_ball_rate || 0;


    // 设置 各值
    $jinqi.find(home_count).text(h_count);
    $jinqi.find(guest_count).text(g_count);

    $jinqi.find(home_win).text(h_win);
    $jinqi.find(guest_win).text(g_win);

    $jinqi.find(home_lose).text(h_lose);
    $jinqi.find(guest_lose).text(g_lose);

    $jinqi.find(homewin_rate).text(h_win_rate + '%');
    $jinqi.find(guestwin_rate).text(g_win_rate + '%');

    $jinqi.find(homedish_rate).text(h_dish_rate + '%');
    $jinqi.find(guestdish_rate).text(g_dish_rate + '%');

    $jinqi.find(homeball_rate).text(h_ball_rate + '%');
    $jinqi.find(guestball_rate).text(g_ball_rate + '%');



}