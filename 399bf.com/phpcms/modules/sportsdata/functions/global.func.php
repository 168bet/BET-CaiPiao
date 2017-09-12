<?php
/*
 * 根据比分获取当场赛事结果
 * author lxt
 * date 2016.05.18
 * 参数：1.只有一个参数，只能是数组，第一位为主队得分，第二位为客场得分；
 *       2.两个参数，第一个为主队得分，第二个为客场得分；
 * 返回：各模块的语言包中的“胜”、“负”、“平”
 */
function get_result()
{
    $params = func_get_args();
    $score = $result = false;
    //因为让球数会出现半球，所以计算均不采用整数计算
    switch (count($params)) {
        case 1:
            $score = is_array($params[0]) ? $params[0][0] - $params[0][1] : false;
            break;
        case 2:
            $score = $params[0] - $params[1];
            break;
        default :
            break;
    }
    if ($score !== false) {
        if ($score > 0) {
            $result = 'win';
        } elseif ($score == 0) {
            $result = 'equal';
        } else {
            $result = 'lose';
        }
    }
    return $result;
}

/*
 * 根据比分获取单双
 * author lxt
 * date 2016.05.18
 * 参数：1.只有一个参数，只能是数组，第一位为主队得分，第二位为客场得分；
 *       2.两个参数，第一个为主队得分，第二个为客场得分；
 * 返回：各模块的语言包中的“单”、“双”
 */
function single_double()
{
    $params = func_get_args();
    $total = $result = false;
    switch (count($params)) {
        case 1:
            $total = is_array($params[0]) ? array_sum($params[0]) % 2 : false;
            break;
        case 2:
            $total = array_sum($params) % 2;
            break;
        default :
            break;
    }
    if ($total !== false) {
        $result = $total === 0 ? 'double' : 'single';
    }
    return $result;
}

/*
 * 根据比分获取比分大小
 * author lxt
 * date 2016.05.18
 * 参数：1.$home   主队得分；
 *       2.$away   客队得分；
 *       3.$type   0：全球大小；1：半球大小
 */
function score_size($home, $away, $type = 0)
{
    $line = $type ? 0.75 : 2.5;
    $total = intval($home) + intval($away);
    $result = $total > $line ? 'big' : 'little';
    return $result;
}

/*
 * 盘路结果
 * author lxt
 * date 2016.05.18
 */
function get_plate($home, $away, $handicap)
{
    $plate = array();
    switch (abs($handicap)) {
        //平手、半球
        case 0.25:
            //此为特殊情况，要先计算第二个盘口，否则会出现平一半的错误结果    edit by lxt 2016.07.13
            $handicap_arr = array($handicap > 0 ? 0.5 : -0.5, 0);
            break;
        //半球、一球
        case 0.75:
            $handicap_arr = array($handicap > 0 ? 0.5 : -0.5, $handicap > 0 ? 1 : -1);
            break;
        //一球、球半
        case 1.25:
            $handicap_arr = array($handicap > 0 ? 1 : -1, $handicap > 0 ? 1.5 : -1.5);
            break;
        //球半、两球
        case 1.75:
            $handicap_arr = array($handicap > 0 ? 1.5 : -1.5, $handicap > 0 ? 2 : -2);
            break;
        //两球、两球半
        case 2.25:
            $handicap_arr = array($handicap > 0 ? 2 : -2, $handicap > 0 ? 2.5 : -2.5);
            break;
        //两球半、三球
        case 2.75:
            $handicap_arr = array($handicap > 0 ? 2.5 : -2.5, $handicap > 0 ? 3 : -3);
            break;
        //三球、三球半
        case 3.25:
            $handicap_arr = array($handicap > 0 ? 3 : -3, $handicap > 0 ? 3.5 : -3.5);
            break;
        //三球半、四球
        case 3.75:
            $handicap_arr = array($handicap > 0 ? 3.5 : -3.5, $handicap > 0 ? 4 : -4);
            break;
        default:
            //如果不是以上让球的话，说明只有一个盘口，但是平局在盘口中成为走水，故替换语言包
            $plate = array(get_result($home + $handicap, $away) == 'equal' ? 'waste' : get_result($home + $handicap, $away), '');
            break;
    }
    //如果存在两个盘口，则要综合两个盘口的结果判断是否出现“一半”的结果
    if (isset($handicap_arr)) {
        $result = array(get_result($home + $handicap_arr[0], $away), get_result($home + $handicap_arr[1], $away));
        //防止出现“负一半”或者“平一半”
        $plate = $result[0] === $result[1] ? array($result[0], '') : array($result[0] == 'equal' ? $result[1] : $result[0], 'half');
    }
    return $plate;
}

/*
 * 将让球数据转换为语言包
 * author lxt
 * date 2016.05.18
 */
function get_handicap($handicap)
{
    if(!isset($handicap)) return L('not_handicap', '', 'sportsdata');
    $result = strpos($handicap, '-') === false ? '' : L('receive', '', 'sportsdata');
    switch (abs($handicap)) {
        case 0:
            $message = 'handicap_0';
            break;
        case 0.25:
            $message = 'handicap_0_25';
            break;
        case 0.5:
            $message = 'handicap_0_50';
            break;
        case 0.75:
            $message = 'handicap_0_75';
            break;
        case 1:
            $message = 'handicap_1';
            break;
        case 1.25:
            $message = 'handicap_1_25';
            break;
        case 1.5:
            $message = 'handicap_1_50';
            break;
        case 1.75:
            $message = 'handicap_1_75';
            break;
        case 2:
            $message = 'handicap_2';
            break;
        case 2.25:
            $message = 'handicap_2_25';
            break;
        case 2.5:
            $message = 'handicap_2_50';
            break;
        case 2.75:
            $message = 'handicap_2_75';
            break;
        case 3:
            $message = 'handicap_3';
            break;
        case 3.25:
            $message = 'handicap_3_25';
            break;
        case 3.5:
            $message = 'handicap_3_50';
            break;
        case 3.75:
            $message = 'handicap_3_75';
            break;
        case 4:
            $message = 'handicap_4';
            break;
        case 4.25:
            $message = 'handicap_4_25';
            break;
        case 4.5:
            $message = 'handicap_4_50';
            break;
        case 4.75:
            $message = 'handicap_4_75';
            break;
        case 5:
            $message = 'handicap_5';
            break;
        default:
            $message = '';
            break;
    }
    return $result . L($message, '', 'sportsdata');
}

/*
 * 赛事数据统计
 * author lxt
 * date 2016.05.19
 */
function game_stat($data)
{
    $result = array(
        'open' => $data[0]['Home'] ? true : false,
        'home_corner' => $data[4]['Home'],
        'away_corner' => $data[4]['Away']
    );
    return $result;
}

/*
 * 便捷获取球队名称
 * author lxt
 * date 2016.05.19
 */
function get_team_name($id)
{
    if ($id) {
        $info = football_api::getteaminfo($id);
        return $info['TeamInfo']['Name'];
    }
    return false;
}

function get_competition_name($id)
{
    if ($id) {
        $info = football_api::getcompetitioninfo($id);
        return $info['ShortName'];
    }
    return false;
}

/**
 * 获取赛事直播sql
 * 这部分数据调取即时比分
 * 即时比分定义为当前时间2小时之前至36小时内的赛事
 *
 * @param int $competitionid 联赛id
 * @param int $catid 栏目id
 * @return string sql
 */
function get_hot_sql($competitionid='', $catid='')
{
    //联赛直播时间范围
    $starttime = SYS_TIME - 2*60*60;    //开始时间
    $endtime = SYS_TIME + 4*7*24*60*60; //结束时间
    //栏目id映射为联赛id
    if(empty($competitionid) && !empty($catid)){
        $competitionid = catid2competitionid($catid);
    }
    //获取某个联赛的赛事
    if(!empty($competitionid))
    {
        $hot_sql = "SELECT
                  gameid,
                  hometeamid,
                  homeshortname,
                  awayteamid,
                  awayshortname,
                  homescore,
                  awayscore,
                  date
                FROM ft_game
                WHERE 1=1 AND competitionid = '$competitionid'
                  AND date > '$starttime' AND date < '$endtime'
                ORDER BY date ASC";
    }
    //获取热门赛事
    else
    {
        $hot_sql = "SELECT
                  a.gameid,
                  a.hometeamid,
                  a.homeshortname,
                  a.awayteamid,
                  a.awayshortname,
                  b.homescore,
                  b.awayscore,
                  a.date
                FROM ft_live_game a
                LEFT JOIN ft_live_game_data b ON a.gameid=b.gameid
                WHERE 1=1 AND a.date > '$starttime' AND a.date < '$endtime'
                ORDER BY a.date ASC";
    }
    return $hot_sql;
}

/**
 * 栏目id到联赛id的映射
 *
 * @param int $catid 栏目id
 * @return int 联赛id
 */
function catid2competitionid($catid)
{
    switch($catid)
    {
        //中超
        case 9:
            $competitionid = 152;
            break;

        //亚冠(亚洲联赛冠军杯)
        case 10:
            $competitionid = 139;
            break;

        //国足(中国足协杯)
        case 11:
            $competitionid = 123;
            break;

        //欧洲杯(欧洲超级杯)
        case 12:
            $competitionid = 86;
            break;

        //欧冠(欧洲联赛冠军杯)
        case 13:
            $competitionid = 74;
            break;

        //英超
        case 14:
            $competitionid = 92;
            break;

        //西甲
        case 15:
            $competitionid = 85;
            break;

        //意甲
        case 16:
            $competitionid = 34;
            break;

        //德甲
        case 17:
            $competitionid = 39;
            break;

        //法甲
        case 18:
            $competitionid = 93;
            break;

        default:
            $competitionid = '';
            break;
    }
    return $competitionid;

}

/**
 * 去除小数点右侧无意义(在无精度要求的情况下)的零
 *
 * @param mixed $value
 * @return string 去除小数点右侧零后的字符串值
 */
function rtrim0($value)
{
    $result = trim(strval($value));
    if (preg_match('/^-?\d+?\.0+$/', $result)) {
        return preg_replace('/^(-?\d+?)\.0+$/','$1',$result);
    }
    if (preg_match('/^-?\d+?\.[0-9]+?0+$/', $result)) {
        return preg_replace('/^(-?\d+\.[0-9]+?)0+$/','$1',$result);
    }
    return $result;
}

/**
 * 将7M接口返回的大小球指数总分转换成盘口
 *
 * @pram float $total 总分
 * @return string 盘口
 */
function handicap_ou($total)
{
    $result = '';
    switch($total)
    {
        case 0.25:
            $result = '0/0.5';
            break;

        case 0.75:
            $result = '0.5/1';
            break;

        case 1.25:
            $result = '1/1.5';
            break;

        case 1.75:
            $result = '1.5/2';
            break;

        case 2.25:
            $result = '2/2.5';
            break;

        case 2.75:
            $result = '2.5/3';
            break;

        case 3.25:
            $result = '3/3.5';
            break;

        case 3.75:
            $result = '3.5/4';
            break;

        case 4.25:
            $result = '4/4.5';
            break;

        case 4.75:
            $result = '4.5/5';
            break;

        case 5.25:
            $result = '5/5.5';
            break;

        case 5.75:
            $result = '5.5/6';
            break;

        case 6.25:
            $result = '6/6.5';
            break;

        case 6.75:
            $result = '6.5/7';
            break;

        case 7.25:
            $result = '7/7.5';
            break;

        case 7.75:
            $result = '7.5/8';
            break;

        case 8.25:
            $result = '8/8.5';
            break;

        case 8.75:
            $result = '8.5/9';
            break;

        default:
            $result = rtrim0($total);
            break;
    }
    return $result;
}

/**
 * 亚指公司与欧指公司的映射关系
 * 1、亚指公司编号映射到欧指公司编号
 * 2、亚指公司Mansion88暂未提供对应欧指公司
 *
 * @return array 映射数组
 */
function asia2euro()
{
    return array(
        3000271 => 1,       //10Bet
        3000471 => 117,     //12BET
        3000343 => 253,     //188Bet
        3000181 => 17,      //Bet365
        3000068 => 254,     //Ladbrokes
        3000248 => 250,     //Macauslot
        3000379 => 251,     //Mansion88
        3000368 => 172,     //SBOBET
        3000048 => 256,     //Victor Chandler
        3000021 => 255,     //William Hill
        3000390 => 257,     //YSB 88
        400000 => 308       //S2
    );
}

/**
 * 亚指公司编号到公司名映射
 *
 * @return array 映射数组
 */
function cid2cname()
{
    return array(
        3000271 => '10Bet',                 //10Bet
        3000471 => '12BET',                 //12BET
        3000343 => '188Bet',                //188Bet
        3000181 => 'Bet365',                //Bet365
        3000068 => 'Ladbrokes',             //Ladbrokes
        3000248 => 'Macauslot',             //Macauslot
        3000379 => 'Mansion88',             //Mansion88
        3000368 => 'SBOBET',                //SBOBET
        3000048 => 'Victor Chandler',       //Victor Chandler
        3000021 => 'William Hill',          //William Hill
        3000390 => 'YSB 88',                //YSB 88
        400000 => 'S2'                      //S2
    );
}

/**
 * 计算统计数据的比例
 * author lxt
 * date 2016.07.29
 * @param $list
 * @return array|bool
 */
function stats_rate($list)
{
    if (count($list)) {
        $result = array();
        $sum = array_sum($list);
        foreach ($list as $value) {
            $rate = round(($value / $sum) * 100, 2) . "%";
            $result[] = array(
                'number' => $value,
                'rate' => $rate
            );
        }
        return $result;
    }
    return false;
}

/*
 * 计算数组平均值
 */
function avg($array, $decimal = 2)
{
    if (is_array($array)) {
        return round((array_sum($array) / count($array)), $decimal);
    }

    return false;
}

/*
 * 凯利指数
 * 参数：$value => 主胜赔率或者客胜赔率
 *       $rate => 即时平均值的主胜率或者客胜率
 */
function get_kelly($value, $rate)
{
    return round($value * ($rate / 100), 2);
}

/**
 * http get 请求
 * @param string $api_url API地址
 * @return array 返回的数据
 */
function http_get($api_url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $return = curl_exec($ch);
    curl_close($ch);
    return json_decode($return, true);
}

/**
 * 转换竞猜比赛的结果
 * @param $type :   竞猜类型,注意：是guess表中的type,而不是guess_game中的type
 * @param $result   :   用户竞猜的结果（未转换）
 */
function guess_result($type, $result)
{
    //竞猜结果映射表
    $result_map = array(
        //足球大小
        1	=>	array(
            2	=>	'小',
            3	=>	'大'
        ),
        //足球胜负
        2	=>	array(
            -1	=>	'主队负',
            0	=>	'平',
            1	=>	'主队胜'
        ),
        //足球比分
        3	=>	array(),
        //足球上半场
        4   =>  array(
            -1	=>	'主队负',
            0	=>	'平',
            1	=>	'主队胜'
        ),
        //篮球胜负
        5   =>  array(
            -1	=>	'主队负',
            1	=>	'主队胜'
        ),
        //篮球让分胜负
        6   =>  array(
            -1	=>	'主队负',
            1	=>	'主队胜'
        ),
        //篮球剩分差
        7   =>  array(),
        //篮球大小分
        8   =>  array(
            0   =>  '小',
            1   =>  '大'
        )
    );
    //足球比分和篮球分差没有预设值
    return isset($result_map[$type][$result]) ? $result_map[$type][$result] : $result;
}

//股票大盘数据
function get_dapan_data()
{
    $appkey = '626088cf5b0d2d65d83474a635a80a4f';
    $apiurl = 'http://web.juhe.cn:8080/finance/stock/';
    $result = [];

    $urls = [
        //上证指数
        'sh' => [
            'name' => '上证指数',
            'url' => $apiurl . 'hs?key=' . $appkey . '&type=0'
        ],
        //深证指数
        'hz' => [
            'name' => '深证指数',
            'url' => $apiurl . 'hs?key=' . $appkey . '&type=1'
        ],
        //恒生指数
        'hk' => [
            'name' => '恒生指数',
            'url' => $apiurl . 'hk?key=' . $appkey . '&num=00001'
        ]
    ];

    foreach ($urls as $key => $value) {
        $return = http_get($value['url']);

        if ((int)$return['error_code'] === 0) {
            if ($key === 'hk') {
                $result[$key] = $tmp = $return['result'][0]['hengsheng_data'];
                $result[$key]['nowpri'] = round($tmp['lastestpri'], 2);
                $result[$key]['increPer'] = round($tmp['limit'], 2);
                $result[$key]['increase'] = round($tmp['uppic'], 2);
            } else {
                $result[$key] = $tmp = $return['result'];
                $result[$key]['nowpri'] = round($tmp['nowpri'], 2);
                $result[$key]['increPer'] = round($tmp['increPer'], 2);
                $result[$key]['increase'] = round($tmp['increase'], 2);
            }

            $result[$key]['name'] = $value['name'];
        }
    }

    return $result;
}

//数组内部根据某一项排序
function sort_by($array, $column, $sort = 'asc')
{
    $tmp = array();
    $column_arr = array_unique(array_column($array, $column));
    switch (strtolower($sort)) {
        case 'asc':
            sort($column_arr);
            break;
        case 'desc':
            rsort($column_arr);
            break;
        default:
            break;
    }
    foreach ($array as $value) {
        $tmp[array_search($value[$column], $column_arr)][] = $value;
    }
    ksort($tmp);
    return $tmp;
}



