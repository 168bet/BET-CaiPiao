<?php
//sportsdt.com 足球数据控制器
defined('IN_PHPCMS') or exit('No permission resources.');
//模块缓存路径
define('CACHE_SPORTSDATA_PATH',CACHE_PATH.'caches_wap'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
//加载模块全局函数
pc_base::load_app_func('global');
pc_base::load_app_func('global', 'sportsdata');

class football
{
    //比赛状态
    private $status_arr = [
        0 => '未开始',
        1 => '上',
        2 => '中',
        3 => '下',
        4 => '完',
        5 => '断',
        6 => '取',
        7 => '加',
        8 => '加',
        9 => '加',
        10 => '完',
        11 => '点',
        12 => '全',
        13 => '延',
        14 => '斩',
        15 => '待',
        16 => '金',
        17 => '未开始'
    ];

    public function __construct()
    {
        $this->db                  = pc_base::load_model('live_game_model');
        $this->team_db             = pc_base::load_model('team_model');
        $this->event_db            = pc_base::load_model('event_model');
        $this->competition_db      = pc_base::load_model('competition_model');
        $this->shooter_db          = pc_base::load_model('shooter_stats_model');
        $this->teamscores_stats_db = pc_base::load_model('teamscores_stats_model');
        $this->standings_stats_db  = pc_base::load_model('standings_stats_model');
        $this->frequentresults_db  = pc_base::load_model('frequentresults_stats_model');
        $this->getmiss_db          = pc_base::load_model('getmiss_stats_model');
        $this->game_db             = pc_base::load_model('game_model');
        $this->game_stats_db       = pc_base::load_model('game_stats_model');
        $this->oddsway_stats_db    = pc_base::load_model('oddsway_stats_model');
        $this->goal_stats_db       = pc_base::load_model('live_game_goal_stats_model');
        $this->forecast_db         = pc_base::load_model('game_forecast_model');
        $this->odds_asia_db        = pc_base::load_model('odds_asia_model');
        $this->odds_euro_db        = pc_base::load_model('odds_euro_model');
        $this->odds_ou_db          = pc_base::load_model('odds_ou_model');
        $this->company_db          = pc_base::load_model('company_model');
        $this->hfstat_db           = pc_base::load_model('halffull_stats_model');
    }

    //资料库
    public function event(){
        //seo
        $SEO['title'] = '足球资料_足球数据库';
        $SEO['keyword'] = '足球资料，足球数据库';
        $SEO['description'] = '399彩迷网拥有全网最齐全的足球资料库，覆盖全世界所有的球队和联赛，包含球员情况、球队资料、赛程安排、积分排行、对战历史、伤停情报、盘赔变化等所有你需要的购彩情报！';

        $event = $this->event_db->select();

        foreach ($event as $item) {
            if($item['eventtype'] == 2) { // 国家赛事
                // 最多显示4个中文
                if (mb_strlen($item['countryname']) > 4) {
                    $item['countryname'] = mb_substr($item['countryname'], 0, 4, 'utf-8');
                }

                $data['countrylogo'] = PHOTO_PATH . 'country/' . $item['countryid'] . '.jpg';
                $data['countryname'] = $item['countryname'];

                if (!isset($eventData[$item['zoneid']][$item['eventtype']][$item['countryname']])) {
                    $eventData[$item['zoneid']][$item['eventtype']][$item['countryname']] = $data;
                    $eventData[$item['zoneid']][$item['eventtype']][$item['countryname']]['event'][] = [
                        'eventid' => $item['eventid'],
                        'eventname' => $item['eventname']
                    ];
                } else {
                    $eventid_arr = array_column($eventData, 'eventid');
                    if (!in_array($item['eventid'], $eventid_arr)) {
                        $eventData[$item['zoneid']][$item['eventtype']][$item['countryname']]['event'][] = [
                            'eventid' => $item['eventid'],
                            'eventname' => $item['eventname']
                        ];
                    }
                }
            } elseif ($item['eventtype'] == 1) { // 国际赛事
                $data['id'] = $item['eventid'];
                $data['name'] = $item['eventname'];
                $eventData[$item['zoneid']][$item['eventtype']][$item['countryname']] = $data;
            }

        }
        include template('wap', 'ft_event');
    }

    //足球指数
    public function odds(){
        //seo
        $SEO['title'] = '足球盘口_足球赔率_' . $this->odds_status_arr[$odds_status];
        $SEO['keyword'] = '足球盘口,足球赔率';
        $SEO['description'] = '看足球即时赔率，首选399彩迷网！399彩迷网为广大彩迷提供各大欧洲赔率公司和亚洲盘口的足球初始赔率、即时赔率数据，提供赔率分析和盘口走势分析等盘赔数据查询！';
        //日期
        $starttime = SYS_TIME - 2 * 60 * 60; //开始时间
        $endtime = SYS_TIME + 36 * 60 * 60;  //结束时间
        $where = "WHERE 1=1 AND g.date > '$starttime' AND g.date < '$endtime'";
        //公司
        $company_ids = $_REQUEST['companyid'] ? $_REQUEST['companyid'] : array(3000271,3000181,400000);
        $company_info = $this->company_db->select("`area`='亚指公司'", '`companyid`,`name` companyname', '', '`companyid` ASC');
        if (count($company_info)) {
            foreach ($company_info as $key => $c) {
                if (in_array($c['companyid'], $company_ids)) {
                    $company_info[$key]['checked'] = true;
                }
            }
        }
        //即时比分赛事
        $live_game_sql = "SELECT
                            g.gameid,
                            g.competitionid,
                            g.competitionshortname,
                            g.competitioncolor,
                            g.hometeamid,
                            g.homeshortname,
                            g.awayteamid,
                            g.awayshortname,
                            g.date,
                            g.homerank,
                            g.awayrank,
                            d.homescore,
                            d.awayscore,
                            d.tstarttime,
                            d.status,
                            w.islive
                        FROM ft_live_game g
                        LEFT JOIN ft_live_game_data d ON g.gameid = d.gameid
                        LEFT JOIN ft_wlive_list w ON g.gameid = w.gameid
                        $where
                        ORDER BY g.date ASC";
        $this->db->query($live_game_sql);
        $live_games = $this->db->fetch_array();
        //将gameid作为$live_games的key
        foreach($live_games as $key => $game){
            //上、下半场时间处理
            switch ($game['status']) {
                case 1:
                    $time = $game['tstarttime'] ? ceil((time() - $game['tstarttime']) / 60) : ceil((time() - $game['date']) / 60);
                    $game['time'] = $time > 45 ? '45+' : $time;
                    break;
                case 3:
                    //下半场如果超过90分钟，改为显示90+
                    $time = $game['tstarttime'] ? ceil((45 * 60 + time() - $game['tstarttime']) / 60) : ceil((time() - $game['date']) / 60);
                    $game['time'] = $time > 90 ? '90+' : $time;
                    break;
                default:
                    break;
            }
            $live_games[$game['gameid']] = $game;
            unset($live_games[$key]);
        }

        //亚盘指数
        $company_condition = to_sqls($company_ids, '', 'companyid');
        $game_condition = to_sqls(array_column($live_games, 'gameid'), '', 'gameid');
        $asia_sql = "SELECT
                      companyid,
                      companyname,
                      gameid,
                      fup,
                      fdown,
                      fgive,
                      up,
                      down,
                      give
                    FROM ft_odds_asia
                    WHERE 1=1 AND $game_condition AND $company_condition
                    GROUP BY gameid, companyid
                    ORDER BY oddsdate ASC";
        $this->db->query($asia_sql);
        $odds_asia = $this->db->fetch_array();
        //将亚盘指数合并到$live_games
        if (!empty($odds_asia)) {
            foreach ($odds_asia as $odds) {
                $live_games[$odds['gameid']]['odds'][$odds['companyid']] = $odds;
            }
        }

        //大小球指数
        $ou_sql = "SELECT
                      companyid,
                      companyname,
                      gameid,
                      fbig,
                      ftotal,
                      fsmall,
                      big,
                      total,
                      small
                    FROM ft_odds_ou
                    WHERE 1=1 AND $game_condition AND $company_condition
                    GROUP BY gameid, companyid
                    ORDER BY oddsdate ASC";
        $this->db->query($ou_sql);
        $odds_ou = $this->db->fetch_array();
        //将大小球指数合并到$live_games
        if (!empty($odds_ou)) {
            foreach ($odds_ou as $odds) {
                $live_games[$odds['gameid']]['odds'][$odds['companyid']]['companyid'] = $odds['companyid'];
                $live_games[$odds['gameid']]['odds'][$odds['companyid']]['companyname'] = $odds['companyname'];
                $live_games[$odds['gameid']]['odds'][$odds['companyid']]['gameid'] = $odds['gameid'];
                $live_games[$odds['gameid']]['odds'][$odds['companyid']]['big'] = $odds['big'];
                $live_games[$odds['gameid']]['odds'][$odds['companyid']]['total'] = $odds['total'];
                $live_games[$odds['gameid']]['odds'][$odds['companyid']]['small'] = $odds['small'];
            }
        }

        //欧盘指数
        $aisa2euro = asia2euro();           //亚指公司映射到欧指公司
        $euro2asia = array_flip($aisa2euro); //欧指公司映射到亚指公司
        $cid2cname = cid2cname();           //亚指公司编号映射到公司名
        //获取对应的欧指公司的$euro_company_condition
        $euro_option_cid = array();
        foreach ($company_ids as $cid) {
            $euro_option_cid[] = $aisa2euro[$cid];
        }
        $euro_company_condition = to_sqls($euro_option_cid, '', 'companyid');
        $euro_sql = "SELECT
                      companyid,
                      companyname,
                      gameid,
                      fhomewin,
                      fdraw,
                      fawaywin,
                      homewin,
                      draw,
                      awaywin
                    FROM ft_odds_euro
                    WHERE 1=1 AND $game_condition AND $euro_company_condition
                    GROUP BY gameid, companyid
                    ORDER BY oddsdate ASC";
        $this->db->query($euro_sql);
        $odds_euro = $this->db->fetch_array();
        //将欧盘指数合并到$live_games
        if (!empty($odds_euro)) {
            foreach ($odds_euro as $odds) {
                $cid = $euro2asia[$odds['companyid']];
                $live_games[$odds['gameid']]['odds'][$cid]['companyid'] = $cid;
                $live_games[$odds['gameid']]['odds'][$cid]['companyname'] = $cid2cname[$cid];
                $live_games[$odds['gameid']]['odds'][$cid]['gameid'] = $odds['gameid'];
                $live_games[$odds['gameid']]['odds'][$cid]['homewin'] = $odds['homewin'];
                $live_games[$odds['gameid']]['odds'][$cid]['draw'] = $odds['draw'];
                $live_games[$odds['gameid']]['odds'][$cid]['awaywin'] = $odds['awaywin'];
            }
        }

        //如果所选择的公司都未提供某场比赛的指数(包括亚指、欧赔、大小球)
        //则去除该场比赛
        foreach ($live_games as $key => $game) {
            //未定义$game['odds']则表示该场比赛没有任何指数提供
            if (!isset($game['odds'])) {
                unset($live_games[$key]);
            }
        }

        //对剩余的比赛补充未提供任何指数(包括亚指、欧赔、大小球)的公司(在所选择的公司内)
        //便于模板输出时进行数据遍历
        foreach ($live_games as $gameid => $game) {
            if (count($game['odds']) < count($company_ids)) {
                $diff = array_diff($company_ids, array_keys($game['odds']));
                foreach ($diff as $cid) {
                    $live_games[$gameid]['odds'][$cid]['companyid'] = $cid;
                    $live_games[$gameid]['odds'][$cid]['companyname'] = $cid2cname[$cid];
                    $live_games[$gameid]['odds'][$cid]['gameid'] = $gameid;
                }
            }
        }

        //将比赛指数按公司编号自然顺序排序
        foreach ($live_games as $key => $game) {
            ksort($live_games[$key]['odds']);
        }
        include template('wap', 'ft_odds');
    }

    //即时比分
    public function live_game(){
        //seo
        $SEO['title'] = '足彩比分直播_足球即时比分网';
        $SEO['keyword'] = '足彩比分,足彩比分直播,即时比分,即时比分网,足球即时比分';
        $SEO['description'] = '399彩迷网为彩迷提供全网最新的足球比分直播。赛事赛程安排、足球完场比分、比分盘赔指数等服务涵盖了世界范围内的所有足球联赛，为大家提供最精准的足球即时比分！';
        //即时比分赛事时间范围
        $starttime = SYS_TIME - 12 * 60 * 60; //开始时间
        $endtime = SYS_TIME + 36 * 60 * 60;  //结束时间
        //获取即时比分赛事
        $live_game_sql = "SELECT
                                g.gameid,
                                g.competitionid,
                                g.competitionshortname,
                                g.competitioncolor,
                                g.date,
                                g.hometeamid,
                                g.homeshortname,
                                g.awayteamid,
                                g.awayshortname,
                                g.neutral,
                                g.homerank,
                                g.awayrank,
                                d.homescore,
                                d.awayscore,
                                d.half,
                                d.tstarttime,
                                d.status,
                                d.homeredcard,
                                d.awayredcard,
                                d.homeyellowcard,
                                d.awayyellowcard,
                                s.stat
                            FROM ft_live_game g
                            LEFT JOIN ft_live_game_data d ON g.gameid = d.gameid
                            LEFT JOIN ft_live_game_goal_stats s ON g.gameid=s.gameid
                            WHERE 1=1 AND g.date > $starttime AND g.date < $endtime
                            ORDER BY g.date ASC ";
        $this->db->query($live_game_sql);
        $live_game_data = $this->db->fetch_array();
        if (count($live_game_data)) {
            foreach ($live_game_data as &$_data) {
                //状态文本
                $_data['status_text'] = $this->status_arr[$_data['status']];
                //上、下半场时间处理
                switch ($_data['status']) {
                    case 1:
                        $time = $_data['tstarttime'] ? ceil((time() - $_data['tstarttime']) / 60) : ceil((time() - $_data['date']) / 60);
                        $_data['status_text'] = ($time > 45 ? '45+' : $time) . '\'';
                        break;
                    case 3:
                        //下半场如果超过90分钟，改为显示90+
                        $time = $_data['tstarttime'] ? ceil((45 * 60 + time() - $_data['tstarttime']) / 60) : ceil((time() - $_data['date']) / 60);
                        $_data['status_text'] = ($time > 90 ? '90+' : $time) . '\'';
                        break;
                    default:
                        break;
                }
                //角球
                if ($_data['stat']) {
                    $stat = json_decode($_data['stat'], true);
                    foreach ($stat as $stats) {
                        if ($stats['Name'] == '角球次数') {
                            $_data['homecorner'] = $stats['Home'];
                            $_data['awaycorner'] = $stats['Away'];
                        }
                    }
                }
            }

            $data_list = array();
            foreach ($live_game_data as $id => $data) {
                //未开始
                if (in_array($data['status'], array(0, 17))) {
                    $data_list['ready'][$id] = $data;
                    //结束
                } elseif (in_array($data['status'], array(4, 13, 14, 15))) {
                    $data_list['end'][$id] = $data;
                    //正在进行
                } else {
                    $data_list['start'][$id] = $data;
                }
            }
        }
        include template('wap', 'ft_live_game');
    }

    //异步获取即时比分
    public function ajax_live_game_data()
    {
        if ($_POST['gameids']) {
            $state = true;
            $where = 'a.gameid IN (' . join(',', $_POST['gameids']) . ')';
            $model = pc_base::load_model('live_game_data_model');
            //比赛状态数组
            $status_list = $this->status_arr;
            //即时比分数据
            $sql = 'SELECT a.*,
                           b.date,
                           c.stat
                    FROM ft_live_game_data a
                    LEFT JOIN ft_live_game b ON a.gameid=b.gameid
                    LEFT JOIN ft_live_game_goal_stats c ON a.gameid=c.gameid
                    WHERE ' . $where . ';';

            $model->query($sql);
            $info = $model->fetch_array();

            foreach ($info as &$value) {
                //上、下半场时间处理
                switch ($value['status']) {
                    case 1:
                        //下半场如果超过45分钟，改为显示45+
                        $time = $value['tstarttime'] ? ceil((time() - $value['tstarttime']) / 60) : ceil((time() - $value['date']) / 60);
                        $value['text'] = ($time > 45 ? '45+' : $time) . '\'';
                        $value['state_tag'] = true;
                        $value['run_tag'] = true;
                        break;
                    case 3:
                        //下半场如果超过90分钟，改为显示90+
                        $time = $value['tstarttime'] ? ceil((45 * 60 + time() - $value['tstarttime']) / 60) : ceil((time() - $value['date']) / 60);
                        $value['text'] = ($time > 90 ? '90+' : $time) . '\'';
                        $value['state_tag'] = true;
                        $value['run_tag'] = true;
                        break;
                    default:
                        //完场比赛标志
                        if (in_array($value['status'], array(4, 10))) {
                            $value['is_over'] = true;
                        }
                        //其他状态直接显示，不计算时间
                        $value['text'] = array_key_exists($value['status'], $status_list) ? $status_list[$value['status']] : '';
                        $value['state_tag'] = false;
                        $value['run_tag'] = $value['status'] == 2 ? true : false;
                        break;
                }

                //角球
                if ($value['stat']) {
                    $stat = json_decode($value['stat'], true);
                    foreach ($stat as $stats) {
                        if ($stats['Name'] == '角球次数') {
                            $value['homecorner'] = $stats['Home'];
                            $value['awaycorner'] = $stats['Away'];
                        }
                    }
                }
            }

            $result = array(
                'state' => $state,
                'data' => $info
            );
        } else {
            $state = false;
            $result = array(
                'state' => $state
            );
        }

        exit(json_encode($result));
    }

    //完场比分
    public function end_game(){
        //seo
        $SEO['title'] = '足球比分网_完场比分';
        $SEO['keyword'] = '足球比分网';
        $SEO['description'] = '399彩迷网提供最全的足球完场比分、详细的足球比分查询，每一场足球完场比分结束后，都会即时的为彩民提供完场球赛比分数据，不错过每一场精彩瞬间。';

        $week = [
            1 => '一',
            2 => '二',
            3 => '三',
            4 => '四',
            5 => '五',
            6 => '六',
            7 => '天'
        ];

        //日期
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Y-m-d');

        //开始时间和结束时间
        $starttime = strtotime($date . ' 00:00:00');
        $endtime = strtotime($date . ' 23:59:59');

        //日期文本
        $date_text = date('m月d日', $endtime) . ' 星期' . $week[date('N', $endtime)];

        //一周日期及文本
        $arr_date = array();
        foreach ($week as $key => $value) {
            if (count($arr_date) <= 6) {
                $time = SYS_TIME - ($key - 1) * 24 * 60 * 60;
                $arr_date[] = array(
                    'date' => date('Y-m-d', $time),
                    'date_text' => date('m.d', $time),
                    'day' => date('Y-m-d', $time) == date('Y-m-d') ? '今日' : '周' . $week[date('N', $time)]
                );
            }
        }

        //显示的状态
        $status = [
            4,  //完
            6,  //取消
            13, //延期
            14, //腰斩
            15  //待定
        ];
        $status_condition = to_sqls($status, '', 'd.status');

        //获取完场比赛
        $end_sql = "SELECT
                      g.gameid,
                      g.competitionid,
                      g.competitionshortname,
                      g.competitioncolor,
                      g.date,
                      g.hometeamid,
                      g.homeshortname,
                      g.awayteamid,
                      g.awayshortname,
                      g.homerank,
                      g.awayrank,
                      d.status,
                      d.homescore,
                      d.awayscore,
                      d.half,
                      d.homeredcard,
                      d.awayredcard,
                      d.homeyellowcard,
                      d.awayyellowcard,
                      d.note,
                      w.islive
                    FROM ft_live_game g
                    INNER JOIN ft_live_game_data d ON g.gameid = d.gameid
                    LEFT JOIN ft_wlive_list w ON g.gameid = w.gameid
                    WHERE 1=1 AND g.date >= '$starttime' AND g.date <= '$endtime' AND $status_condition
                    GROUP BY g.competitionid, g.gameid";
        $this->db->query($end_sql);
        $end_game = $this->db->fetch_array();

        //比赛id作为key
        if (count($end_game)) {
            foreach ($end_game as &$_data) {
                $_data['note'] = str_replace('"', '', $_data['note']);
                $_data['status_text'] = $this->status_arr[$_data['status']];
            }
        }
        include template('wap', 'ft_end_game');
    }

    //下日赛程
    public function future_game(){
        //SEO
        $SEO['title'] = '足球赛事_下日比分';
        $SEO['keyword'] = '足球赛事';
        $SEO['description'] = '399彩迷网为您提供最即时，最全的全球足球赛事、足球赛事时间，以及英超赛程、德甲赛程、西甲赛程、意甲赛程等五大联赛足球赛程查询。';

        $week = [
            1 => '一',
            2 => '二',
            3 => '三',
            4 => '四',
            5 => '五',
            6 => '六',
            7 => '天'
        ];

        //日期
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Y-m-d', strtotime('tomorrow'));

        //开始时间和结束时间
        $starttime = strtotime($date . ' 00:00:00');
        $endtime = strtotime($date . ' 23:59:59');

        //日期文本
        $date_text = date('m月d日', $endtime) . ' 星期' . $week[date('N', $endtime)];

        //一周日期及文本
        $arr_date = array();
        foreach ($week as $key => $value) {
            if (count($arr_date) <= 6) {
                $time = SYS_TIME + $key * 24 * 60 * 60;
                $arr_date[] = array(
                    'date' => date('Y-m-d', $time),
                    'date_text' => date('m.d', $time),
                    'day' => date('Y-m-d', $time) == date('Y-m-d', strtotime('+1 day')) ? '明日' : '周' . $week[date('N', $time)]
                );
            }
        }

        //获取未来比赛
        $future_sql = "SELECT
                      g.gameid,
                      g.competitionid,
                      g.competitionshortname,
                      g.competitioncolor,
                      g.date,
                      g.hometeamid,
                      g.homeshortname,
                      g.awayteamid,
                      g.awayshortname,
                      g.homerank,
                      g.awayrank,
                      g.status,
                      g.homescore,
                      g.awayscore,
                      g.half,
                      g.homeredcard,
                      g.awayredcard,
                      g.homeyellowcard,
                      g.awayyellowcard,
                      g.note,
                      w.islive
                    FROM ft_game g
                    LEFT JOIN ft_wlive_list w ON g.gameid = w.gameid
                    WHERE 1=1 AND g.date >= '$starttime' AND g.date <= '$endtime'
                    GROUP BY g.competitionid, g.gameid";
        $this->db->query($future_sql);
        $future_game = $this->db->fetch_array();

        if (count($future_game)) {
            foreach ($future_game as &$_data) {
                $_data['status_text'] = $this->status_arr[$_data['status']];
                $_data['note'] = str_replace('"', '', $_data['note']);
            }
        }
        include template('wap', 'ft_future_game');
    }

    //资料库 赛程赛果
    public function competition_schedule(){
        //联赛信息
        $competitionid = $_REQUEST['competitionid'];
        $competition_info = $this->_competition_info($competitionid);
        if (! $competition_info) {
            showmessage(L('competition_not_exists'), 'blank');
        }

        //seo
        $SEO['title'] = ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . '_比赛数据';
        $SEO['keyword'] = ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . '，比赛数据资料';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        //联赛轮次、分组、阶段情况
        $competition_category_where = $competition_info['startdate'] ? '`competitionid`=' . $competitionid . ' AND `date`>=' . $competition_info['startdate'] : '`competitionid`=' . $competitionid;
        $competition_category_sql = "SELECT `round`,`group`,`period`
                                     FROM ft_competition_schedule
                                     WHERE " . $competition_category_where . "
                                     GROUP BY `round`,`group`,`period`;";

        $this->game_db->query($competition_category_sql);
        $temp = $this->game_db->fetch_array();
        foreach ($temp as $row) {
            if ($row['round']) {
                $competition_category[$row['round']] = 'round';
            } elseif ($row['group']) {
                $competition_category[$row['group']] = 'group';
            } else {
                $competition_category[$row['period']] = 'period';
            }
        }
        ksort($competition_category);

        //当前阶段数据
        if ($_GET['round']) {
            $current = '第' . $_GET['round'] . '轮';
            $where = "`round`='" . $_GET['round'] . "'";
        } elseif($_GET['group']) {
            $current = $_GET['group'];
            $where = "`group`='" . $_GET['group'] . "'";
        } elseif($_GET['period']) {
            $current = $_GET['period'] . '阶段';
            $where = "`period`='" . $_GET['period'] . "'";
        } else {
            //默认数据
            foreach ($competition_category as $key => $value) {
                if (!isset($where)) {
                    $where = "`" . $value . "`='" . $key . "'";
                    $_GET[$value] = $key;
                    switch ($value) {
                        case 'period':
                            $current = $key . '阶段';
                            break;
                        case 'group':
                            $current = $key;
                            break;
                        default:
                            $current = '第' . $key . '轮';
                            break;
                    }
                } else {
                    break;
                }
            }
        }

        //获取当前阶段的比赛编号
        $where .= $competition_info['startdate'] ? ' AND `date`>=' . $competition_info['startdate'] : '';
        $game_sql = "SELECT `gameid`,
                              `hometeamid`,
                              `awayteamid`
                       FROM ft_competition_schedule
                       WHERE `competitionid`=" . $competitionid . "
                       AND " . $where . ";";

        $this->game_db->query($game_sql);
        $temp = $this->game_db->fetch_array();
        foreach ($temp as $row) {
            $game_ids[] = $row['gameid'];
            $team_ids[] = $row['hometeamid'];
            $team_ids[] = $row['awayteamid'];
        }

        //球队信息
        if (count($team_ids)) {
            $team_ids = array_unique($team_ids);
            $team_db = pc_base::load_model('team_model');
            $team_info = $team_db->select('`teamid` IN (' . join(',', $team_ids) . ')', '`teamid` as `id`,if(`shortname` <> "",`shortname`,`name`) as `name`', '', '', '', 'id');
        }

        //列表数据
        if (count($game_ids)) {
            //筛选
            $where = 'a.gameid IN (' . join(',', $game_ids) . ')';
            $where .= $_GET['teamid'] ? ' AND (a.hometeamid=' . $_GET['teamid'] . ' OR a.awayteamid=' . $_GET['teamid'] . ')' : '';
            $where .= $_GET['hometeamid'] ? ' AND a.hometeamid=' . $_GET['hometeamid'] : '';
            $where .= $_GET['awayteamid'] ? ' AND a.awayteamid=' . $_GET['awayteamid'] : '';
            //比赛数据
            $list_sql = "SELECT a.gameid,
                                a.competitionid,
                                a.competitionshortname,
                                a.hometeamid,
                                a.homeshortname,
                                a.awayteamid,
                                a.awayshortname,
                                a.date,
                                a.neutral,
                                a.homescore,
                                a.awayscore,
                                a.half,
                                a.handicap,
                                b.islive
                     FROM ft_game a
                     LEFT JOIN ft_wlive_list b ON a.gameid=b.gameid
                     WHERE " . $where;

            $this->game_db->query($list_sql);
            $temp = $this->game_db->fetch_array();
            foreach ($temp as $row) {
                $row['plate'] = get_plate($row['homescore'], $row['awayscore'], $row['handicap']);
                $row['result'] = get_result($row['homescore'], $row['awayscore']);
                $list[$row['gameid']] = $row;
            }
        }
//        dump($competition_category);
        include template('wap', 'ft_competition_schedule');
    }

    //资料库 积分排名
    public function competition_standings(){
        //联赛信息
        $competitionid = $_REQUEST['competitionid'];
        $competition_info = $this->_competition_info($competitionid);
        if (! $competition_info) {
            showmessage(L('competition_not_exists'), 'blank');
        }

        //seo
        $SEO['title'] = ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . '_积分表';
        $SEO['keyword'] = ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . ',积分表';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        //积分榜
        $type = $_REQUEST['type'] ? $_REQUEST['type'] : 'total';
        $standings_info = $this->standings_stats_db->standings($competitionid, $type);
        include template('wap', 'ft_competition_standings');
    }

    //资料库 盘路统计
    public function competition_oddsway(){
        //联赛信息
        $competitionid = $_REQUEST['competitionid'];
        $competition_info = $this->_competition_info($competitionid);
        if (! $competition_info) {
            showmessage(L('competition_not_exists'), 'blank');
        }

        //seo
        $SEO['title'] = ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . '_盘路统计';
        $SEO['keyword'] = ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . '，盘路统计';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        //让球
        $type = $_REQUEST['type'] ? $_REQUEST['type'] : 'total';
        $oddsway_info = $this->oddsway_stats_db->oddsway($competitionid, $type);
        include template('wap', 'ft_competition_oddsway');
    }

    //资料库 半全场统计
    public function competition_hfstat(){
        //联赛信息
        $competitionid = $_REQUEST['competitionid'];
        $competition_info = $this->_competition_info($competitionid);
        if (! $competition_info) {
            showmessage(L('competition_not_exists'), 'blank');
        }

        //seo
        $SEO['title'] = ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . '_半全场统计';
        $SEO['keyword'] = ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . ',半全场统计';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($competition_info['shortname'] ? $competition_info['shortname'] : $competition_info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        $result = $this->hfstat_db->select('`competitionid`=' . $competitionid);
        if (count($result)) {
            $hfstat_info = array();
            foreach ($result as $value) {
                $hfstat_info[$value['type']][] = $value;
            }
        }
        include template('wap', 'ft_competition_hfstat');
    }

    //资料库 射手榜
    public function competition_shooter()
    {
        $competitionid = $_REQUEST['competitionid'];

        if ($competitionid <= 0) {
            return false;
        }

        $competition         = $this->competition_db->get_one('competitionid=' . $competitionid);
        $competition['date'] = date('Y', $competition['startdate']) . '-' . date('Y', $competition['enddate']) . '赛季';
        $competition['logo'] = PHOTO_PATH . 'competition/' . $competitionid . '.jpg';
        //seo
        $SEO['title'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '_神射手榜';
        $SEO['keyword'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . ',神射手榜';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        $shooter = $this->shooter_db->select('competitionid=' . $competitionid, '*', 50, 'rank');

        include template('wap', 'ft_competition_shooter');
    }

    //比赛 分析
    public function game_analyse(){
        //比赛基本信息
        $gameid = $_REQUEST['gameid'];
        if (! $gameid) {
            showmessage(L('game_not_exists'),'blank');
        }
        $game_info = $this->_gameinfo($gameid);
        $team_ids = array($game_info['hometeamid'], $game_info['awayteamid']);
        //seo
        $SEO['title'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队_足球数据统计赔分析预测';
        $SEO['keyword'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队，足球数据统计赔分析预测';
        $SEO['description'] = '399彩迷提供权威的足球数据统计,足彩数据分析，包括足球的欧洲指数,亚洲盘口,大小球指数,球赛数据统计，以及足彩分析预测。';

        //过往战绩
        $where = '`gameid`=' . $gameid;
        $stats_info = $this->game_stats_db->get_one($where);
        //联赛信息
        $competition = json_decode($stats_info['competition'], true);
        //球队信息
        $team = json_decode($stats_info['team'], true);

        //积分
        $temp['standings_info'] = $this->standings_stats_db->select('`competitionid`=' . $game_info['competitionid']);
        if (count($temp['standings_info'])) {
            $standings_tmp = $rank_tmp = array();
            foreach ($temp['standings_info'] as $value) {
                $standings_tmp[$value['type']][] = $value;
            }
            foreach ($standings_tmp as $key => $value) {
                $rank_tmp[$key] = sort_by($value, 'score', 'desc');
            }
            foreach ($rank_tmp as $type => $list) {
                foreach ($list as $rank => $data) {
                    foreach ($data as $value) {
                        if (in_array($value['teamid'], $team_ids)) {
                            $value['rank'] = $rank + 1;
                            $value['net'] = $value['goal'] - $value['nongoal'];
                            $standings_info[$value['teamid']][$type] = $value;
                        }
                    }
                }
            }
        }

        //交锋往绩
        if (isset($stats_info['meeting'])) {
            $meeting = $meeting_stats = array();
            $temp['meeting'] = json_decode($stats_info['meeting'], true);
            foreach ($temp['meeting'] as $data) {
                $row = array();
                $row['is_home'] = $game_info['hometeamid'] == $data['Id'][2] ? 1 : 0;
                $row['main_home_score'] = $row['is_home'] ? $data['Score'][0] : $data['Score'][1];  //统计以game_info中的主队为主
                $row['main_away_score'] = $row['is_home'] ? $data['Score'][1] : $data['Score'][0];  //统计以game_info的主队为主
                $row['gameid'] = $data['Id'][0];
                $row['competitionid'] = $data['Id'][1];
                $row['competition_name'] = $competition[$data['Id'][1]]['ShortName'];
                $row['competition_color'] = $competition[$data['Id'][1]]['Color'];
                $row['date'] = date('y/m/d', floor($data['Date'] / 1000));
                $row['hometeamid'] = $data['Id'][2];
                $row['awayteamid'] = $data['Id'][3];
                $row['homename'] = $team[$data['Id'][2]]['Name'];
                $row['homescore'] = $data['Score'][0];
                $row['awayscore'] = $data['Score'][1];
                $row['awayname'] = $team[$data['Id'][3]]['Name'];
                $row['redcard'] = join('-', $data['RedCard']);
                $row['full_size'] = score_size($row['homescore'], $row['awayscore']);
                $row['half_size'] = score_size($row['homescore'], $row['awayscore'], 1);
                $row['single_double'] = single_double($row['homescore'], $row['awayscore']);
                $row['half'] = $data['Half'];
                $row['handicap'] = get_handicap($data['Handicap']);
                $row['plate'] = get_plate($data['Score'][0], $data['Score'][1], $data['Handicap']);
                $meeting[] = $row;
                //统计
                $meeting_stats[get_result($row['main_home_score'], $row['main_away_score'])] += 1;
                $meeting_stats['goal'] += $row['main_home_score'];
                $meeting_stats['nongoal'] += $row['main_away_score'];
            }
            $meeting_stats['win_rate'] = round(($meeting_stats['win'] / count($meeting)) * 100, 2) . '%';
        }

        //近两年战绩数据
        if (isset($stats_info['teamhistory'])) {
            $temp['team_history'] = json_decode($stats_info['teamhistory'], true);
            foreach ($temp['team_history'] as $name => $histories) {
                $category = strtolower($name);
                $history_total = array(
                    'home_win' => 0,
                    'home_equal' => 0,
                    'home_lose' => 0,
                    'neutral_win' => 0,
                    'neutral_equal' => 0,
                    'neutral_lose' => 0,
                    'away_win' => 0,
                    'away_equal' => 0,
                    'away_lose' => 0
                );
                foreach ($histories as $history) {
                    //总合计
                    if ($game_info[$category . 'teamid'] == $history['Id'][2]) {    //作为主队
                        if ($history['N']) {
                            //中立场
                            $history_total['neutral_' . get_result($history['Score'])] += 1;
                        } else {
                            $history_total['home_' . get_result($history['Score'])] += 1;
                        }
                    } else {    //作为客队
                        if ($history['N']) {
                            //中立场
                            $history_total['neutral_' . get_result($history['Score'][1], $history['Score'][0])] += 1;
                        } else {
                            $history_total['away_' . get_result($history['Score'][1], $history['Score'][0])] += 1;
                        }
                    }
                    //列表数据
                    $row = array();
                    $row['is_home'] = $game_info[$category . 'teamid'] == $history['Id'][2] ? 1 : 0;
                    $row['neutral'] = $history['N'] ? 1 : 0;
                    $row['main_home_score'] = $row['is_home'] ? $history['Score'][0] : $history['Score'][1];  //统计以game_info中的主队为主
                    $row['main_away_score'] = $row['is_home'] ? $history['Score'][1] : $history['Score'][0];  //统计以game_info的主队为主
                    $row['competitionid'] = $history['Id'][1];
                    $row['competition_name'] = $competition[$history['Id'][1]]['ShortName'];
                    $row['competition_color'] = $competition[$history['Id'][1]]['Color'];
                    $row['date'] = date('y/m/d', $history['Date']);
                    $row['homescore'] = $history['Score'][0];
                    $row['awayscore'] = $history['Score'][1];
                    $row['result'] = $game_info[$category . 'teamid'] == $history['Id'][2] ? get_result($history['Score']) : get_result($row['awayscore'], $row['homescore']);
                    $row['hometeamid'] = $history['Id'][2];
                    $row['awayteamid'] = $history['Id'][3];
                    $row['homename'] = $team[$history['Id'][2]]['Name'];
                    $row['awayname'] = $team[$history['Id'][3]]['Name'];
                    $row['handicap'] = get_handicap($history['Handicap']);
                    $row['plate'] = get_plate($row['homescore'], $row['awayscore'], $history['Handicap']);
                    $row['full_size'] = score_size($row['homescore'], $row['awayscore']);
                    $row['half'] = $history['Half'];
                    $half_score = explode('-', $row['half']);
                    $row['half_size'] = score_size($half_score[0], $half_score[1], 1);
                    $row['single_double'] = single_double($history['Score']);
                    $team_history[$category][] = $row;
                }
                //总合计比例
                $history_total['win'] = $history_total['home_win'] + $history_total['neutral_win'] + $history_total['away_win'];        //总胜
                $history_total['equal'] = $history_total['home_equal'] + $history_total['neutral_equal'] + $history_total['away_equal'];//总平
                $history_total['lose'] = $history_total['home_lose'] + $history_total['neutral_lose'] + $history_total['away_lose'];    //总负
                $history_number = count($histories);
                foreach ($history_total as $key => $value) {
                    $history_total[$key . '_rate'] = round(($value / $history_number) * 100, 2) . "%";
                }
                $history_stats[$category] = $history_total;
            }
        }

        //盘路
        $temp['oddsway_stats'] = $this->oddsway_stats_db->select('`competitionid`=' . $game_info['competitionid'] . ' AND `teamid` IN (' . join(',', $team_ids) . ')');
        if (count($temp['oddsway_stats'])) {
            foreach ($temp['oddsway_stats'] as $value) {
                $oddsway_info[$value['teamid']][$value['type']] = $value;
            }
        }

        //最近八场统计
        $all_game_info = $this->game_db->select('`status` IN (4,10) AND `competitionid`=' . $game_info['competitionid'], '`homescore`,`awayscore`,`handicap`,`hometeamid`,`awayteamid`', '', '`date` DESC');

        $recent_info = array();
        //遍历全部记录，给每只球队分配进八场盘路情况
        foreach ($all_game_info as $row) {
            //如果本条记录中的主客都不在team_ids中，说明本条记录的主客两队的近八场盘路统计已满，跳过此条记录
            if (! in_array($row['hometeamid'], $team_ids) && ! in_array($row['awayteamid'], $team_ids)) {
                continue;
            }
            //如果本条记录中的主客球队盘路未满8条，则添加记录，否则从team_ids中删除球队编号，以此跳过不必要的循环
            if (count($recent_info[$row['hometeamid']]) < 8) {
                $recent_info[$row['hometeamid']][] = get_plate($row['homescore'], $row['awayscore'], $row['handicap']);
            } else {
                unset($team_ids[array_search($row['hometeamid'], $team_ids)]);
            }
            if (count($recent_info[$row['awayteamid']]) < 8) {
                $recent_info[$row['awayteamid']][] = get_plate($row['homescore'], $row['awayscore'], $row['handicap']);
            } else {
                unset($team_ids[array_search($row['awayteamid'], $team_ids)]);
            }
        }

        include template('wap', 'ft_game_analyse');
    }

    //比赛 事件
    public function game_event(){
        //比赛基本信息
        $gameid = $_REQUEST['gameid'];
        if (! $gameid) {
            showmessage(L('game_not_exists'),'blank');
        }
        $game_info = $this->_gameinfo($gameid);
        //seo
        $SEO['title'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队_技术统计';
        $SEO['keyword'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队，球赛技术统计';
        $SEO['description'] = '399彩迷网提供最全的球赛技术统计,足球数据统计，足球比分直播,足球动画比分直播上399彩迷网观看。';

        //数据统计
        $stat_info = $this->goal_stats_db->stat_info($gameid);
        //换人统计
        $substitution_info = $this->goal_stats_db->substitution_info();
        //事件统计
        $goal_info = $this->goal_stats_db->goal_info();
        //合并换人统计到数据统计
        $event_info = array();
        foreach ($goal_info as $value) {
            $event_info[$value['Minute']] = $value;
        }
        foreach ($substitution_info as $value) {
            $value['replace'] = true;
            $value['Class'] = 'replace';
            $event_info[$value['Minute']] = $value;
        }
        ksort($event_info);

        include template('wap', 'ft_game_event');
    }

    //比赛 阵容
    public function game_lineup(){
        //比赛基本信息
        $gameid = $_REQUEST['gameid'];
        if (! $gameid) {
            showmessage(L('game_not_exists'),'blank');
        }
        $game_info = $this->_gameinfo($gameid);
        //seo
        $SEO['title'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队_技术统计';
        $SEO['keyword'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队，球赛技术统计';
        $SEO['description'] = '399彩迷网提供最全的球赛技术统计,足球数据统计，足球比分直播,足球动画比分直播上399彩迷网观看。';

        //双方阵容
        $lineup = $this->forecast_db->lineup($gameid);

        include template('wap', 'ft_game_lineup');
    }

    //比赛 亚盘
    public function game_odds_asia(){
        //比赛基本信息
        $gameid = $_REQUEST['gameid'];
        if (! $gameid) {
            showmessage(L('game_not_exists'),'blank');
        }
        $game_info = $this->_gameinfo($gameid);
        //seo
        $SEO['title'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队_足球亚洲盘口赔率分析';
        $SEO['keyword'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队，足球亚洲盘口赔率分析';
        $SEO['description'] = '足球亚洲盘口,足球亚洲赔率分析,亚盘数据分析，399彩迷网为您提供最为价值权威的数据以及数据预测。';

        //亚盘
        $company_id = [3000048, 3000181, 3000271, 3000368, 3000379, 3000390, 3000471];
        $where = to_sqls($company_id, '', '`companyid`');
        $odds = $this->odds_asia_db->select("`gameid` ='$gameid' AND " . $where, '`companyid`,`companyname`,`up`,`down`,`give`,`fup`,`fdown`,`fgive`,`oddsdate`', '', '', '', 'companyid');
        //变化趋势
        if (count($odds)) {
            foreach ($odds as &$_value) {
                $_value['up_trend'] = $_value['up'] - $_value['fup'] > 0 ? 'up' : ($_value['up'] - $_value['fup'] < 0 ? 'down' : '');
                $_value['give_trend'] = $_value['give'] - $_value['fgive'] > 0 ? 'up' : ($_value['give'] - $_value['fgive'] < 0 ? 'down' : '');
                $_value['down_trend'] = $_value['down'] - $_value['fdown'] > 0 ? 'up' : ($_value['down'] - $_value['fdown'] < 0 ? 'down' : '');
            }
        }

        include template('wap', 'ft_game_odds_asia');
    }

    //比赛 大小
    public function game_odds_ou(){
        //比赛基本信息
        $gameid = $_REQUEST['gameid'];
        if (! $gameid) {
            showmessage(L('game_not_exists'),'blank');
        }
        $game_info = $this->_gameinfo($gameid);
        //seo
        $SEO['title'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队_足球大小指数分析';
        $SEO['keyword'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队，足球大小指数分析';
        $SEO['description'] = '足球大小指数,大小球盘口分析,足球指数分析，399彩迷网为您提供最为价值权威的数据以及数据预测。';

        $company_id = [3000048, 3000181, 3000271, 3000368, 3000379, 3000390, 3000471];
        $where = to_sqls($company_id, '', '`companyid`');
        $odds = $this->odds_ou_db->select("`gameid` ='$gameid' AND " . $where, '`companyid`,`companyname`,`big`,`small`,`total`,`fbig`,`fsmall`,`ftotal`,`oddsdate`', '', '', '', 'companyid');
        //变化趋势
        if (count($odds)) {
            foreach ($odds as &$_value) {
                $_value['big_trend'] = $_value['big'] - $_value['fbig'] > 0 ? 'up' : ($_value['big'] - $_value['fbig'] < 0 ? 'down' : '');
                $_value['total_trend'] = $_value['total'] - $_value['ftotal'] > 0 ? 'up' : ($_value['total'] - $_value['ftotal'] < 0 ? 'down' : '');
                $_value['small_trend'] = $_value['small'] - $_value['fsmall'] > 0 ? 'up' : ($_value['small'] - $_value['fsmall'] < 0 ? 'down' : '');
            }
        }

        include template('wap', 'ft_game_odds_ou');
    }

    //比赛 欧赔
    public function game_odds_euro(){
        //比赛基本信息
        $gameid = $_REQUEST['gameid'];
        if (! $gameid) {
            showmessage(L('game_not_exists'),'blank');
        }
        $game_info = $this->_gameinfo($gameid);
        //seo
        $SEO['title'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队_足球欧洲指数赔率分析';
        $SEO['keyword'] = $game_info['homename'] . '队 VS ' . $game_info['awayname'] . '队，足球欧洲指数赔率分析';
        $SEO['description'] = '足球欧洲指数,即时赔率,足球赔率分析，399彩迷网为您提供最为价值权威的数据以及数据预测。';

        //指数变化
        $odds = $this->odds_euro_db->select("`gameid` = '$gameid'", '`homewin`,`draw`,`awaywin`,`fhomewin`,`fdraw`,`fawaywin`,`companyname`,`oddsdate`,`companyid`', '', '`oddsdate` DESC');
        if (count($odds)) {
            foreach ($odds as &$_value) {
                $_value['home_trend'] = $_value['homewin'] - $_value['fhomewin'] > 0 ? 'up' : ($_value['homewin'] - $_value['fhomewin'] < 0 ? 'down' : '');
                $_value['draw_trend'] = $_value['draw'] - $_value['fdraw'] > 0 ? 'up' : ($_value['draw'] - $_value['fdraw'] < 0 ? 'down' : '');
                $_value['away_trend'] = $_value['awaywin'] - $_value['fawaywin'] > 0 ? 'up' : ($_value['awaywin'] - $_value['fawaywin'] < 0 ? 'down' : '');
            }
        }
        //最高值、最小值、平均值
        $total = count($odds);
        $odds_stat['max'] = array(
            'homewin' => max(array_column($odds, 'homewin')),
            'draw' => max(array_column($odds, 'draw')),
            'awaywin' => max(array_column($odds, 'awaywin')),
            'fhomewin' => max(array_column($odds, 'fhomewin')),
            'fdraw' => max(array_column($odds, 'fdraw')),
            'fawaywin' => max(array_column($odds, 'fawaywin'))
        );
        $odds_stat['avg'] = array(
            'homewin' => round(array_sum(array_column($odds, 'homewin')) / $total, 2),
            'draw' => round(array_sum(array_column($odds, 'draw')) / $total, 2),
            'awaywin' => round(array_sum(array_column($odds, 'awaywin')) / $total, 2),
            'fhomewin' => round(array_sum(array_column($odds, 'fhomewin')) / $total, 2),
            'fdraw' => round(array_sum(array_column($odds, 'fdraw')) / $total, 2),
            'fawaywin' => round(array_sum(array_column($odds, 'fawaywin')) / $total, 2),
        );
        $odds_stat['min'] = array(
            'homewin' => min(array_column($odds, 'homewin')),
            'draw' => min(array_column($odds, 'draw')),
            'awaywin' => min(array_column($odds, 'awaywin')),
            'fhomewin' => min(array_column($odds, 'fhomewin')),
            'fdraw' => min(array_column($odds, 'fdraw')),
            'fawaywin' => min(array_column($odds, 'fawaywin')),
        );

        include template('wap', 'ft_game_odds_euro');
    }

    /**
     * 获取比赛基本信息
     *
     * @param int $gameid 比赛id
     * @return array 比赛基本信息
     */
    private function _gameinfo($gameid)
    {
        $sql = "SELECT
                  g.competitionid,
                  g.competitionname,
                  g.competitionshortname,
                  g.hometeamid,
                  g.homename,
                  g.homeshortname,
                  g.awayteamid,
                  g.awayname,
                  g.awayshortname,
                  g.date,
                  g.neutral,
                  g.homerank,
                  g.awayrank,
                  g.weather,
                  d.status,
                  d.homescore,
                  d.awayscore,
                  d.half,
                  d.homeredcard,
                  d.awayredcard,
                  w.islive,
                  ginfo.stadium,
                  ginfo.gameid
                FROM ft_live_game g
                LEFT JOIN ft_live_game_data d ON g.gameid = d.gameid
                LEFT JOIN ft_wlive_list w ON g.gameid=w.gameid
                LEFT JOIN ft_game ginfo ON g.gameid=ginfo.gameid
                WHERE 1=1 AND g.gameid = '$gameid'";
        $this->db->query($sql);
        $gameinfo = $this->db->fetch_array()[0];
        //从ft_game表获取额外信息
        $extra_sql = 'SELECT a.competitionid,
                             a.competitionname,
                             a.hometeamid,
                             a.homename,
                             a.awayteamid,
                             a.awayname,
                             a.date,
                             a.neutral,
                             a.homerank,
                             a.awayrank,
                             a.weather,
                             a.status,
                             a.homescore,
                             a.awayscore,
                             a.half,
                             a.homeredcard,
                             a.awayredcard,
                             a.localtime,
                             a.handicap,
                             a.stadium,
                             a.referee,
                             a.capacity,
                             a.spectator,
                             a.channel,
                             b.islive
                     FROM ft_game a
                     LEFT JOIN ft_wlive_list b ON a.gameid=b.gameid
                     WHERE a.gameid=' . $gameid . ';';
        $this->db->query($extra_sql);
        $extrainfo = $this->db->fetch_array()[0];

        //处理比赛基本信息
        if ($gameinfo && $extrainfo) {
            if (!isset($gameinfo['status'])) $gameinfo['status'] = $extrainfo['status'];
            if (!isset($gameinfo['homescore'])) $gameinfo['homescore'] = $extrainfo['homescore'];
            if (!isset($gameinfo['awayscore'])) $gameinfo['awayscore'] = $extrainfo['awayscore'];
            if (!isset($gameinfo['half'])) $gameinfo['half'] = $extrainfo['half'];
            if (!isset($gameinfo['homeredcard'])) $gameinfo['homeredcard'] = $extrainfo['homeredcard'];
            if (!isset($gameinfo['awayredcard'])) $gameinfo['awayredcard'] = $extrainfo['awayredcard'];
            $gameinfo['localtime'] = $extrainfo['localtime'];
            $gameinfo['handicap'] = $extrainfo['handicap'];
            $gameinfo['stadium'] = $extrainfo['stadium'];
            $gameinfo['referee'] = $extrainfo['referee'];
            $gameinfo['capacity'] = $extrainfo['capacity'];
            $gameinfo['spectator'] = $extrainfo['spectator'];
            $gameinfo['channel'] = $extrainfo['channel'];
        } elseif (!$gameinfo && $extrainfo) {
            $gameinfo = $extrainfo;
        } else {
            //TODO
        }

        //赛季
        $gameinfo['season'] = date('Y', $gameinfo['date']) . '-' . (date('Y', $gameinfo['date']) + 1);
        //比赛状态
        $gameinfo['status_text'] = $this->status_arr[$gameinfo['status']];

        //亚盘让球
        $asia_sql = 'SELECT `give`,
                            `fgive`
                     FROM ft_odds_asia
                     WHERE `companyid`=400000 AND `gameid`=' . $gameid . ';';
        $this->db->query($asia_sql);
        $asia_info = $this->db->fetch_array()[0];

        $gameinfo['handicap'] = in_array($gameinfo['status'], array(4, 17)) ? get_handicap($asia_info['give']) : get_handicap($asia_info['fgive']);

        #-----------------------天气--------------------
        $weather_arr = [
            1 => ['晴天', '晴'],
            2 => ['少云', '阴天', '多云', '阴', '云'],
            3 => ['大雨', '中到大雨'],
            4 => ['大风'],
            5 => ['晴间多云'],
            6 => ['小雨', '中雨', '零星小雨', '细雨'],
            7 => ['雷暴', '小阵雨', '雷阵雨', '小雷雨'],
            8 => ['小雪', '小阵雪', '雨加雪', '中雪', '低空飘雪'],
            9 => ['阵雪', '大阵雪'],
            10 => ['汽雾', '冻雾', '风尘']
        ];

        if ($gameinfo['weather']) {
            $tmp_arr = explode('　', $gameinfo['weather']);

            foreach ($weather_arr as $key => $value) {
                if (in_array($tmp_arr[0], $value)) {
                    $gameinfo['weather_style'] = 'weather-' . $key;
                    break;
                }
            }

            if (!$gameinfo['weather_style']) {
                $gameinfo['weather_style'] = 'weather-1';
            }

        } else {
            $gameinfo['weather_style'] = 'weather-1';
        }

        return $gameinfo;
    }

    /*
     * 获取联赛信息
     * 参数：competitionid 联赛编号；
     *       extra_where 额外搜索条件；
     *       field 查询字段，默认是联赛简称；
     */
    private function _competition_info($competitionid, $field = '`shortname`,`startdate`', $extra_where = false)
    {
        if ($competitionid) {
            $where = '`competitionid`=' . $competitionid . $extra_where;
            $competition = $this->competition_db->get_one($where, $field);
            //时间区间
            if ($competition['startdate']) {
                $competition['range'] = date('Y', $competition['startdate']) . '-' . (date('Y', $competition['startdate']) + 1);
            }
            return $competition;
        }

        return false;
    }

}