<?php
/**
 * 足球数据控制器
 */

defined('IN_PHPCMS') or exit('No permission resources.');
// 模块缓存路径
define('CACHE_SPORTSDATA_PATH',CACHE_PATH.'caches_sportsdata'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
// 加载模块全局函数
pc_base::load_app_func('global');

class football
{
    //比赛状态
    private $arr_status = [
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

    //指数状态
    private $odds_status_arr = [
        1 => '即时指数',
        2 => '已开赛',
        3 => '历史',
        4 => '早盘'
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
    }

    /**
     * 足球直播
     */
    public function live()
    {
        $siteid = $GLOBALS['siteid'] = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
        define('SITEID', $siteid);
        $page = $_GET['page'];
        //SEO
        $SEO = seo($siteid);
        $sitelist  = getcache('sitelist','commons');
        //URL规则
        $urlrule = 'live/~live/{$page}/';
        //where条件
        $where = 'a.status NOT IN (4,10) AND a.date >= ' . strtotime($_POST['date'] ? $_POST['date'] : date('Y-m-d', time()));
        //sql
        $sql = "SELECT a.gameid AS `gameid`,
                       a.competitionid AS `competitionid`,
                       a.competitionshortname as `competitionshortname`,
                       a.hometeamid AS `hometeamid`,
                       a.homeshortname AS `homeshortname`,
                       a.awayteamid AS `awayteamid`,
                       a.awayshortname AS `awayshortname`,
                       a.date AS `date`,
                       b.mode AS `mode`,
                       b.period AS `period`,
                       b.group AS `group`,
                       b.round AS `round`,
                       c.content AS `content`,
                       d.islive AS `islive`
                FROM ft_game a
                INNER JOIN ft_wlive_list d ON a.gameid=d.gameid
                LEFT JOIN ft_competition_schedule b ON a.gameid=b.gameid
                LEFT JOIN ft_game_forecast c ON a.gameid=c.gameid
                WHERE " . $where . "
                ORDER BY a.date ASC";

        //有直播的七天日期
        $date_sql = 'SELECT a.date
                     FROM ft_game a
                     INNER JOIN ft_wlive_list b ON a.gameid=b.gameid
                     WHERE ' . $where .'
                     ORDER BY a.date ASC;';


        $model = pc_base::load_model('game_model');
        $model->query($date_sql);
        $date_info = $model->fetch_array();

        //完场场次统计
        $end_count_sql = 'SELECT COUNT(1) AS `count`
                     FROM ft_game a
                     INNER JOIN ft_wlive_list b ON a.gameid=b.gameid
                     WHERE a.status IN (4,10) AND a.date < ' . strtotime($_POST['date'] ? $_POST['date'] : date('Y-m-d', time())) . ';';

        $model->query($end_count_sql);
        $end_count_info = $model->fetch_array();

        //场次统计
        $live_count = count($date_info);

        if ($live_count) {
            $date_arr = array();
            foreach ($date_info as $row) {
                $row['date_format'] = date('Y年m月d日', $row['date']);
                if (!array_key_exists($row['date_format'], $date_arr) && count($date_arr) < 7) {
                    //星期数替换中文
                    $search_list = array('(1)', '(2)', '(3)', '(4)', '(5)', '(6)', '(7)');
                    $replace_list = array('(一)', '(二)', '(三)', '(四)', '(五)', '(六)', '(日)');
                    $date_arr[$row['date_format']] = array(
                        'format' => str_replace($search_list, $replace_list, date('m月d日(N)', $row['date'])),
                        'date' => date('Y-m-d', $row['date'])
                    );
                }
            }
        }


        $default_style = $sitelist[$siteid]['default_style'];
        include template('sportsdata', 'ft_live', $default_style);
    }

    //完场直播
    public function end_live()
    {
        $siteid = $GLOBALS['siteid'] = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
        define('SITEID', $siteid);
        $page = $_GET['page'];
        //SEO
        $SEO = seo($siteid);
        $sitelist  = getcache('sitelist','commons');
        //URL规则
        $urlrule = 'end_live/~end_live/{$page}/';
        //where条件
        $where = 'a.status IN (4,10) AND a.date < ' . strtotime($_POST['date'] ? $_POST['date'] : date('Y-m-d', time()));
        //sql
        $sql = "SELECT a.gameid AS `gameid`,
                       a.competitionid AS `competitionid`,
                       a.competitionshortname as `competitionshortname`,
                       a.hometeamid AS `hometeamid`,
                       a.homeshortname AS `homeshortname`,
                       a.awayteamid AS `awayteamid`,
                       a.awayshortname AS `awayshortname`,
                       a.date AS `date`,
                       b.mode AS `mode`,
                       b.period AS `period`,
                       b.group AS `group`,
                       b.round AS `round`,
                       c.content AS `content`,
                       d.islive AS `islive`
                FROM ft_game a
                INNER JOIN ft_wlive_list d ON a.gameid=d.gameid
                LEFT JOIN ft_competition_schedule b ON a.gameid=b.gameid
                LEFT JOIN ft_game_forecast c ON a.gameid=c.gameid
                WHERE " . $where . "
                ORDER BY a.date DESC";

        //完场场次统计
        $end_count_sql = 'SELECT COUNT(1) AS `count`
                     FROM ft_game a
                     INNER JOIN ft_wlive_list b ON a.gameid=b.gameid
                     WHERE ' . $where . ';';

        $model = pc_base::load_model('game_model');
        $model->query($end_count_sql);
        $end_count_info = $model->fetch_array();

        //直播赛事统计
        $live_count_sql = 'SELECT COUNT(1) AS `count`
                           FROM ft_game a
                           INNER JOIN ft_wlive_list b ON a.gameid=b.gameid
                           WHERE a.status NOT IN (4,10) AND a.date >= ' . strtotime($_POST['date'] ? $_POST['date'] : date('Y-m-d', time())) . ';';

        $model->query($live_count_sql);
        $live_count_info = $model->fetch_array();

        $default_style = $sitelist[$siteid]['default_style'];
        include template('sportsdata', 'ft_end_live', $default_style);
    }

    /**
     * 足球比分
     * 提供当前时间2小时前至36小时内赛事
     */
    public function live_game()
    {
        //SEO
        $SEO['title'] = '足彩比分直播_足球即时比分网-399彩迷';
        $SEO['keyword'] = '足彩比分,足彩比分直播,即时比分,即时比分网,足球即时比分';
        $SEO['description'] = '399彩迷网为彩迷提供全网最新的足球比分直播。赛事赛程安排、足球完场比分、比分盘赔指数等服务涵盖了世界范围内的所有足球联赛，为大家提供最精准的足球即时比分！';
        //即时比分赛事时间范围
        $starttime = SYS_TIME - 12 * 60 * 60; //开始时间
        $endtime = SYS_TIME + 36 * 60 * 60;  //结束时间
        //比赛状态数组
        $arr_status = $this->arr_status;

        //指数公司
        $company_sql = "SELECT
                          `companyid`,
                          `name` companyname
                        FROM ft_company
                        WHERE `area` = '亚指公司'
                        ORDER BY `companyid` ASC";
        $this->db->query($company_sql);
        $companies = $this->db->fetch_array();
        //特殊选项
        $companies[] = array('companyid' => -1, 'companyname' => '完整');
        //将companyid作为$companies的key
        foreach ($companies as $key => $company) {
            $companies[$company['companyid']] = $company;
            unset($companies[$key]);
        }

        //选择指数公司
        if (isset($_POST['dosubmit']))
        {
            $companyid = $_POST['companyid'];
            $companyname = '盘口';
            //完整选项
            $is_clear = true;   //是否清除未开盘比赛
            $is_all = false;    //是否获取所有公司的指数
            if ($companyid == -1) {
                $is_clear = true;
                $is_all = true;
                $companyid = 400000;  //S2
                $companyname = $companies[$companyid]['companyname'];
            }

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
            //将gameid作为$live_game_data的key
            //生成以competitionid为key，competitionshortname为value的数组$competitions
            foreach ($live_game_data as $key => $game) {
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

                //角球
                if ($game['stat']) {
                    $stat = json_decode($game['stat'], true);
                    foreach ($stat as $stats) {
                        if ($stats['Name'] == '角球次数') {
                            $game['homecorner'] = $stats['Home'];
                            $game['awaycorner'] = $stats['Away'];
                        }
                    }
                }

                $live_game_data[$game['gameid']] = $game;
                $competitions[$game['competitionid']] = $game['competitionshortname'];
                unset($live_game_data[$key]);
            }

            //获取亚盘指数
            $game_condition = to_sqls(array_column($live_game_data, 'gameid'), '', 'gameid');
            $this->db->table_name = 'ft_odds_asia';
            if ($is_all) {
                //所有公司
                $odds_asia = $this->db->select("1=1 AND $game_condition", '`gameid`,`up`,`down`,`give`,`isrun`,`fup`,`fdown`,`fgive`', '', '', '', 'gameid');
            } else {
                //指定公司
                $odds_asia = $this->db->select("1=1 AND companyid = '$companyid' AND $game_condition", '`gameid`,`up`,`down`,`give`,`isrun`,`fup`,`fdown`,`fgive`', '', '', '', 'gameid');
            }
            //将亚盘指数合并到$live_game_data
            if (!empty($odds_asia)) {
                foreach ($odds_asia as $odds) {
                    $live_game_data[$odds['gameid']]['up'] = $odds['up'];
                    $live_game_data[$odds['gameid']]['down'] = $odds['down'];
                    $live_game_data[$odds['gameid']]['give'] = $odds['give'];
                    $live_game_data[$odds['gameid']]['fup'] = $odds['fup'];
                    $live_game_data[$odds['gameid']]['fdown'] = $odds['fdown'];
                    $live_game_data[$odds['gameid']]['fgive'] = $odds['fgive'];
                    $live_game_data[$odds['gameid']]['isrun'] = $odds['isrun'];
                }
            }
            unset($odds_asia);

            //获取大小球指数
            $this->db->table_name = 'ft_odds_ou';
            if ($is_all) {
                $odds_ou = $this->db->select("1=1 AND $game_condition", '`gameid`,`big`,`small`,`total`,`fbig`,`fsmall`,`ftotal`', '', '', '', 'gameid');
            } else {
                $odds_ou = $this->db->select("1=1 AND companyid = '$companyid' AND $game_condition", '`gameid`,`big`,`small`,`total`,`fbig`,`fsmall`,`ftotal`', '', '', '', 'gameid');
            }
            //将大小球指数合并到$live_game_data
            if (!empty($odds_ou)) {
                foreach ($odds_ou as $odds) {
                    $live_game_data[$odds['gameid']]['big'] = $odds['big'];
                    $live_game_data[$odds['gameid']]['small'] = $odds['small'];
                    $live_game_data[$odds['gameid']]['total'] = $odds['total'];
                    $live_game_data[$odds['gameid']]['fbig'] = $odds['fbig'];
                    $live_game_data[$odds['gameid']]['fsmall'] = $odds['fsmall'];
                    $live_game_data[$odds['gameid']]['ftotal'] = $odds['ftotal'];
                }
            }
            unset($odds_ou);

            //获取欧赔指数
            $asia2euro = asia2euro();
            $euro_companyid = $asia2euro[$companyid];
            $this->db->table_name = 'ft_odds_euro';
            if ($is_all) {
                $odds_euro = $this->db->select("1=1 AND $game_condition", '`gameid`,`homewin`,`draw`,`awaywin`,`fhomewin`,`fdraw`,`fawaywin`', '', '', '', 'gameid');
            } else {
                $odds_euro = $this->db->select("1=1 AND companyid = '$euro_companyid' AND $game_condition", '`gameid`,`homewin`,`draw`,`awaywin`,`fhomewin`,`fdraw`,`fawaywin`', '', '', '', 'gameid');
            }
            //将欧赔指数合并到$live_game_data
            if (!empty($odds_euro)) {
                foreach ($odds_euro as $odds) {
                    $live_game_data[$odds['gameid']]['homewin'] = $odds['homewin'];
                    $live_game_data[$odds['gameid']]['draw'] = $odds['draw'];
                    $live_game_data[$odds['gameid']]['awaywin'] = $odds['awaywin'];
                    $live_game_data[$odds['gameid']]['fhomewin'] = $odds['fhomewin'];
                    $live_game_data[$odds['gameid']]['fdraw'] = $odds['fdraw'];
                    $live_game_data[$odds['gameid']]['fawaywin'] = $odds['fawaywin'];
                }
            }
            unset($odds_euro);

            //获取文字直播比赛标识
            $this->db->table_name = 'ft_wlive_list';
            $wlive_list = $this->db->select('1=1 AND ' . $game_condition, '`gameid`,`islive`');
            if (!empty($wlive_list)) {
                foreach ($wlive_list as $game) {
                    $live_game_data[$game['gameid']]['islive'] = $game['islive'];
                }
                unset($wlive_list);
            }

            //清除未开盘的比赛
            //处理特殊选项，不清除未开盘的比赛
            if ($is_clear) {
                foreach ($live_game_data as $key => $game) {
                    if (!isset($game['give']) && !isset($game['total'])) unset($live_game_data[$key]);
                }
            }

            //赛事选择
            $tmp = array_count_values(array_column($live_game_data, 'competitionid'));
            foreach ($tmp as $key => $value) {
                $competition_data[$key]['competitionid'] = $key;
                $competition_data[$key]['competitionshortname'] = $competitions[$key];
                $competition_data[$key]['count'] = $value;
            }
            unset($competitions);

            //盘口选择
            $tmp = array_count_values(array_column($live_game_data, 'give'));
            //完整选项
            if (!$is_clear) {
                $handicap_data['diff']['give'] = null;
                $handicap_data['diff']['count'] = count($live_game_data) - array_sum($tmp);
            }
            foreach ($tmp as $key => $value) {
                $handicap_data[$key]['give'] = $key;
                $handicap_data[$key]['count'] = $value;
            }
            unset($tmp);

        }
        //默认
        else
        {
            //S2公司
            $companyid = 400000;
            $companyname = $companies[$companyid]['companyname'];

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
            //将gameid作为$live_game_data的key
            //生成以competitionid为key，competitionshortname为value的数组$competitions
            foreach ($live_game_data as $key => $game) {
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

                //角球
                if ($game['stat']) {
                    $stat = json_decode($game['stat'], true);
                    foreach ($stat as $stats) {
                        if ($stats['Name'] == '角球次数') {
                            $game['homecorner'] = $stats['Home'];
                            $game['awaycorner'] = $stats['Away'];
                        }
                    }
                }

                $live_game_data[$game['gameid']] = $game;
                $competitions[$game['competitionid']] = $game['competitionshortname'];
                unset($live_game_data[$key]);
            }

            //获取亚盘指数
            $game_condition = to_sqls(array_column($live_game_data, 'gameid'), '', 'gameid');
            $this->db->table_name = 'ft_odds_asia';
            $odds_asia = $this->db->select("1=1 AND companyid = '$companyid' AND $game_condition", '`gameid`,`up`,`down`,`give`,`isrun`,`fup`,`fdown`,`fgive`', '', '', '', 'gameid');
            //将亚盘指数合并到$live_game_data
            if (!empty($odds_asia)) {
                foreach ($odds_asia as $odds) {
                    $live_game_data[$odds['gameid']]['up'] = $odds['up'];
                    $live_game_data[$odds['gameid']]['down'] = $odds['down'];
                    $live_game_data[$odds['gameid']]['give'] = $odds['give'];
                    $live_game_data[$odds['gameid']]['isrun'] = $odds['isrun'];
                    $live_game_data[$odds['gameid']]['fup'] = $odds['fup'];
                    $live_game_data[$odds['gameid']]['fdown'] = $odds['fdown'];
                    $live_game_data[$odds['gameid']]['fgive'] = $odds['fgive'];
                }
            }
            unset($odds_asia);

            //获取大小球指数
            $this->db->table_name = 'ft_odds_ou';
            $odds_ou = $this->db->select("1=1 AND companyid = '$companyid' AND $game_condition", '`gameid`,`big`,`small`,`total`,`fbig`,`fsmall`,`ftotal`', '', '', '', 'gameid');
            //将大小球指数合并到$live_game_data
            if (!empty($odds_ou)) {
                foreach ($odds_ou as $odds) {
                    $live_game_data[$odds['gameid']]['big'] = $odds['big'];
                    $live_game_data[$odds['gameid']]['small'] = $odds['small'];
                    $live_game_data[$odds['gameid']]['total'] = $odds['total'];
                    $live_game_data[$odds['gameid']]['fbig'] = $odds['fbig'];
                    $live_game_data[$odds['gameid']]['fsmall'] = $odds['fsmall'];
                    $live_game_data[$odds['gameid']]['ftotal'] = $odds['ftotal'];
                }
            }
            unset($odds_ou);

            //获取欧赔指数
            $asia2euro = asia2euro();
            $euro_companyid = $asia2euro[$companyid];
            $this->db->table_name = 'ft_odds_euro';
            $odds_euro = $this->db->select("1=1 AND companyid = '$euro_companyid' AND $game_condition", '`gameid`,`homewin`,`draw`,`awaywin`,`fhomewin`,`fdraw`,`fawaywin`', '', '', '', 'gameid');
            //将欧赔指数合并到$live_game_data
            if (!empty($odds_euro)) {
                foreach ($odds_euro as $odds) {
                    $live_game_data[$odds['gameid']]['homewin'] = $odds['homewin'];
                    $live_game_data[$odds['gameid']]['draw'] = $odds['draw'];
                    $live_game_data[$odds['gameid']]['awaywin'] = $odds['awaywin'];
                    $live_game_data[$odds['gameid']]['fhomewin'] = $odds['fhomewin'];
                    $live_game_data[$odds['gameid']]['fdraw'] = $odds['fdraw'];
                    $live_game_data[$odds['gameid']]['fawaywin'] = $odds['fawaywin'];
                }
            }
            unset($odds_euro);

            //获取文字直播比赛标识
            $this->db->table_name = 'ft_wlive_list';
            $wlive_list = $this->db->select('1=1 AND ' . $game_condition, '`gameid`,`islive`');
            if (!empty($wlive_list)) {
                foreach ($wlive_list as $game) {
                    $live_game_data[$game['gameid']]['islive'] = $game['islive'];
                }
                unset($wlive_list);
            }

            //清除未开盘的比赛
            //foreach ($live_game_data as $key => $game) {
            //    if (!isset($game['give']) && !isset($game['total'])) unset($live_game_data[$key]);
            //}

            //赛事选择
            $tmp = array_count_values(array_column($live_game_data, 'competitionid'));
            foreach ($tmp as $key => $value) {
                $competition_data[$key]['competitionid'] = $key;
                $competition_data[$key]['competitionshortname'] = $competitions[$key];
                $competition_data[$key]['count'] = $value;
            }
            unset($competitions);

            //盘口选择
            $tmp = array_count_values(array_column($live_game_data, 'give'));
            $handicap_data['diff']['give'] = null;
            $handicap_data['diff']['count'] = count($live_game_data) - array_sum($tmp);
            foreach ($tmp as $key => $value) {
                $handicap_data[$key]['give'] = $key;
                $handicap_data[$key]['count'] = $value;
            }
            unset($tmp);

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

        include template('sportsdata', 'ft_live_game');
    }

    //足球指数：综合指数
    public function odds()
    {
        list($arr_status, $option_cid, $companies, $odds_status, $date, $date_text, $live_games) = $this->_odds_prework();

        $SEO['title'] = '足球盘口_足球赔率_' . $this->odds_status_arr[$odds_status] . '-399彩迷';
        $SEO['keyword'] = '足球盘口,足球赔率';
        $SEO['description'] = '看足球即时赔率，首选399彩迷网！399彩迷网为广大彩迷提供各大欧洲赔率公司和亚洲盘口的足球初始赔率、即时赔率数据，提供赔率分析和盘口走势分析等盘赔数据查询！';

        //亚盘指数
        $company_condition = to_sqls($option_cid, '', 'companyid');
        $game_condition = to_sqls(array_column($live_games, 'gameid'), '', 'gameid');
        $asia_sql = "SELECT
                      companyid,
                      companyname,
                      gameid,
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
        foreach ($option_cid as $cid) {
            $euro_option_cid[] = $aisa2euro[$cid];
        }
        $euro_company_condition = to_sqls($euro_option_cid, '', 'companyid');
        $euro_sql = "SELECT
                      companyid,
                      companyname,
                      gameid,
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
            if (count($game['odds']) < count($option_cid)) {
                $diff = array_diff($option_cid, array_keys($game['odds']));
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
            $competitions[$game['competitionid']] = $game['competitionshortname'];
        }

        include template('sportsdata', 'ft_odds');
    }

    //足球赛事资料
    public function event() {
        $SEO['title'] = '足球资料_足球数据库-399彩迷';
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

        //最新赛事
        $hot_sql = 'SELECT a.gameid,
                           a.competitionid,
                           a.competitionshortname,
                           a.hometeamid,
                           a.homeshortname,
                           a.homename,
                           a.awayteamid,
                           a.awayshortname,
                           a.awayname,
                           a.date,
                           b.homescore,
                           b.awayscore
                    FROM `ft_live_game` a LEFT JOIN `ft_live_game_data` b ON a.gameid=b.gameid
                    ORDER BY a.date DESC
                    LIMIT 6';
        $this->db->query($hot_sql);
        $hot_data = $this->db->fetch_array(MYSQLI_ASSOC);

        include template('sportsdata', 'ft_event');
    }

    //赛程赛果
    public function competition_schedule()
    {
        $competitionid = $id = $_GET['competitionid'] ? (int)$_GET['competitionid'] : 92;

        $siteid = $GLOBALS['siteid'] = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
        define('SITEID', $siteid);
        $sitelist  = getcache('sitelist','commons');
        $default_style = $sitelist[$siteid]['default_style'];

        //数据库
        $this->game_db = pc_base::load_model("game_model");

        //联赛信息
        $info = $this->_competition_info($competitionid, '`name`,`shortname`,`system`,`startdate`');
        $shortname = $info['shortname'];
        $keywords = $info['name'] . ' ' . $shortname;
        //本赛季开始时间
        $start_date = $info['startdate'];

//        if (! $info) {
//            showmessage(L('competition_not_exists'), 'blank');
//        }

        //seo
        $SEO['title'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '_比赛数据-399彩迷网';
        $SEO['keyword'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '，比赛数据资料';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($info['shortname'] ? $info['shortname'] : $info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        //联赛轮次、分组、阶段情况
        $competition_category_where = $start_date ? '`competitionid`=' . $competitionid . ' AND `date`>=' . $start_date : '`competitionid`=' . $competitionid;
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
            $where = "`round`='" . $_GET['round'] . "'";
        } elseif($_GET['group']) {
            $where = "`group`='" . $_GET['group'] . "'";
        } elseif($_GET['period']) {
            $where = "`period`='" . $_GET['period'] . "'";
        } else {
            //默认数据
            foreach ($competition_category as $key => $value) {
                if (!isset($where)) {
                    $where = "`" . $value . "`='" . $key . "'";
                    $_GET[$value] = $key;
                } else {
                    break;
                }
            }
        }
        $competition_category = array_chunk($competition_category, 15, true);

        //获取当前阶段的比赛编号
        $where = $where ? ' AND ' . $where : $where;
        $where .= $start_date ? ' AND `date`>=' . $start_date : '';
        $gameid_sql = "SELECT `gameid`,
                              `hometeamid`,
                              `awayteamid`
                       FROM ft_competition_schedule
                       WHERE `competitionid`=" . $competitionid . $where . ";";

        $this->game_db->query($gameid_sql);
        $temp = $this->game_db->fetch_array();
        foreach ($temp as $row) {
            $gameid[] = $row['gameid'];
            $team_ids[] = $row['hometeamid'];
            $team_ids[] = $row['awayteamid'];
        }

        //球队信息
        if (count($team_ids)) {
            array_unique($team_ids);
            $team_db = pc_base::load_model('team_model');
            $team_info = $team_db->select('`teamid` IN (' . join(',', $team_ids) . ')', '`teamid` as `id`,if(`shortname` <> "",`shortname`,`name`) as `name`', '', '', '', 'id');
        }

        //积分榜
        $standings_db = pc_base::load_model('standings_stats_model');
        $standings = $standings_db->standings($competitionid);

        //列表数据
        if (count($gameid)) {
            //筛选
            $where = 'a.gameid IN (' . join(',', $gameid) . ')';
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

            //更新时间
            $this->game_db->query('SELECT `update_time` FROM information_schema.tables WHERE `table_name`="ft_game"');
            $update_time = $this->game_db->fetch_array()[0]['update_time'];

        }

        include template("sportsdata", "ft_competition_schedule", $default_style);
    }

    //积分排名
    public function competition_standing()
    {
        $competitionid = $id = $_GET['competitionid'] ? (int)$_GET['competitionid'] : 92;

        $type = $_REQUEST['type'];
        $siteid = $GLOBALS['siteid'] = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
        define('SITEID', $siteid);
        $sitelist  = getcache('sitelist','commons');
        $default_style = $sitelist[$siteid]['default_style'];

        //联赛信息
        $info = $this->_competition_info($competitionid, '`name`,`shortname`,`system`,`startdate`');
        //seo
        $SEO['title'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '_积分表-399彩迷网';
        $SEO['keyword'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . ',积分表';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($info['shortname'] ? $info['shortname'] : $info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        //积分榜
        $this->db = pc_base::load_model('standings_stats_model');
        list($standings, $stat) = $this->db->standings($competitionid, '', true);

        //更新时间
        $this->db->query('SELECT `update_time` FROM information_schema.tables WHERE `table_name`="ft_standings_stats"');
        $update_time = $this->db->fetch_array()[0]['update_time'];

        include template('sportsdata', 'ft_competition_standing', $default_style);
    }

    //波胆分布统计
    public function competition_correct_score()
    {
        $competitionid = $id = $_GET['competitionid'] ? (int)$_GET['competitionid'] : 92;

        //联赛
        $competition = $this->_competition_info($competitionid, '`name`,`shortname`');
        //seo
        $SEO['title'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '_波胆分布-399彩迷网';
        $SEO['keyword'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . ',波胆分布';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        //波胆分布统计
        $correct_score_sql = "SELECT
                                *
                              FROM ft_correctscore_stats
                              WHERE `competitionid` = '$competitionid'";

        //积分榜
        $standings_db = pc_base::load_model('standings_stats_model');
        $standings = $standings_db->standings($competitionid);

        //更新时间
        $standings_db->query('SELECT `update_time` FROM information_schema.tables WHERE `table_name`="ft_correctscore_stats"');
        $update_time = $standings_db->fetch_array()[0]['update_time'];

        include template('sportsdata', 'ft_competition_correct_score');
    }

    //盘路统计
    public function competition_oddsway()
    {
        $competitionid = $id = $_GET['competitionid'] ? (int)$_GET['competitionid'] : 92;

        //联赛信息
        $info = $this->_competition_info($competitionid, '`name`,`shortname`,`system`,`startdate`');
        //seo
        $SEO['title'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '_盘路统计-399彩迷网';
        $SEO['keyword'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '，盘路统计';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($info['shortname'] ? $info['shortname'] : $info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        //盘路信息
        $oddsway_db = pc_base::load_model('oddsway_stats_model');
        list($oddsway, $stat) = $oddsway_db->oddsway($competitionid, '', true);

        //积分榜
        $standings_db = pc_base::load_model('standings_stats_model');
        $standings = $standings_db->standings($competitionid);

        //更新时间
        $standings_db->query('SELECT `update_time` FROM information_schema.tables WHERE `table_name`="ft_oddsway_stats"');
        $update_time = $standings_db->fetch_array()[0]['update_time'];

        include template('sportsdata', 'ft_competition_oddsway');
    }

    //上/下半场入球较多统计
    public function competition_hsscores()
    {
        $id = $_GET['id'] ? (int)$_GET['id'] : 92;

        $info = $this->_competition_info($id, '`name`,`shortname`,`startdate`,`enddate`');
        $info['logo'] = PHOTO_PATH . 'competition/' . $id . '.jpg';
        $info['season'] = date('Y', $info['startdate']) . '-' . date('Y', $info['enddate']) . '赛季';
        //seo
        $SEO['title'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '_上下半场入球-399彩迷网';
        $SEO['keyword'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . ',上下半场入球';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($info['shortname'] ? $info['shortname'] : $info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        $db = pc_base::load_model('hsscores_stats_model');
        $result = $db->select(['competitionid' => $id]);

        $_data = [];
        foreach ($result as $r) {
            $teamid = $r['teamid'];

            $_data[$teamid]['teamname'] = $r['teamname'];
            $_data[$teamid]['teamshortname'] = $r['teamshortname'];

            switch ($r['type']) {
                case 'total':
                    $_data[$teamid]['total_upmore'] = $r['upmore'];
                    $_data[$teamid]['total_updownsame'] = $r['updownsame'];
                    $_data[$teamid]['total_downmore'] = $r['downmore'];
                    break;

                case 'home':
                    $_data[$teamid]['home_upmore'] = $r['upmore'];
                    $_data[$teamid]['home_updownsame'] = $r['updownsame'];
                    $_data[$teamid]['home_downmore'] = $r['downmore'];
                    break;

                case 'away':
                    $_data[$teamid]['away_upmore'] = $r['upmore'];
                    $_data[$teamid]['away_updownsame'] = $r['updownsame'];
                    $_data[$teamid]['away_downmore'] = $r['downmore'];
                    break;

                default:
                    break;
            }
        }

        $standing_info = $this->_competition_standing($id);

        include template('sportsdata', 'ft_competition_hsscores');
    }

    //上、下盘全场入球统计
    public function competition_overunder()
    {
        $id = $_GET['id'] ? (int)$_GET['id'] : 92;

        $info = $this->_competition_info($id, '`name`,`shortname`,`startdate`,`enddate`');
        $info['logo'] = PHOTO_PATH . 'competition/' . $id . '.jpg';
        $info['season'] = date('Y', $info['startdate']) . '-' . date('Y', $info['enddate']) . '赛季';
        //seo
        $SEO['title'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '_上下盘全场入球-399彩迷网';
        $SEO['keyword'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . ',上下盘全场入球';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($info['shortname'] ? $info['shortname'] : $info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        $db = pc_base::load_model('overunder_stats_model');
        $_data = $db->select(['competitionid' => $id]);

        $standing_info = $this->_competition_standing($id);

        include template('sportsdata', 'ft_competition_overunder');

    }

    //半全场统计
    public function competition_hfstat()
    {
        $id = $_GET['id'] ? (int)$_GET['id'] : 92;

        $info = $this->_competition_info($id, '`name`,`shortname`,`startdate`,`enddate`');
        $info['logo'] = PHOTO_PATH . 'competition/' . $id . '.jpg';
        $info['season'] = date('Y', $info['startdate']) . '-' . date('Y', $info['enddate']) . '赛季';
        //seo
        $SEO['title'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '_半全场统计-399彩迷网';
        $SEO['keyword'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . ',半全场统计';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($info['shortname'] ? $info['shortname'] : $info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        $db = pc_base::load_model('halffull_stats_model');
        $result = $db->select(['competitionid' => $id]);

        $_data = [];
        foreach ($result as $r) {
            $_data[$r['type']][] = $r;
        }

        $standing_info = $this->_competition_standing($id);

        include template('sportsdata', 'ft_competition_hfstat');
    }

    //入球总数及单双数统计
    public function competition_oddeven()
    {
        $id = $_GET['id'] ? (int)$_GET['id'] : 92;

        $info = $this->_competition_info($id, '`name`,`shortname`,`startdate`,`enddate`');
        $info['logo'] = PHOTO_PATH . 'competition/' . $id . '.jpg';
        $info['season'] = date('Y', $info['startdate']) . '-' . date('Y', $info['enddate']) . '赛季';
        //seo
        $SEO['title'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '_入球总数及单双数-399彩迷网';
        $SEO['keyword'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . ',入球总数及单双数';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($info['shortname'] ? $info['shortname'] : $info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        $db = pc_base::load_model('oddeven_stats_model');
        $_data = $db->select(['competitionid' => $id]);

        $standing_info = $this->_competition_standing($id);

        include template('sportsdata', 'ft_competition_oddeven');
    }

    //球队总入球数统计
    public function competition_team_scores(){
        $id = (int)$_GET['id'];

        if ($id <= 0) {
            return false;
        }

        $teamMapper          = [];
        $competition         = $this->competition_db->get_one('competitionid=' . $id);
        $competition['date'] = date('Y', $competition['startdate']) . '-' . date('Y', $competition['enddate']) . '赛季';
        $competition['logo'] = PHOTO_PATH . 'competition/' . $id . '.jpg';
        //seo
        $SEO['title'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '_球队总入球数-399彩迷网';
        $SEO['keyword'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . ',球队总入球数';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        $teamStats = $this->teamscores_stats_db->select('competitionid=' . $id);

        $teamIds = array_column($teamStats, 'teamid');
        $where   = to_sqls($teamIds, '', '`teamid`');
        $team    = $this->team_db->select($where, 'teamid, name');

        foreach ($team as $item) {
            $teamMapper[$item['teamid']] = $item['name'];
        }

        foreach ($teamStats as $item) {
            $item['name']                               = $teamMapper[$item['teamid']];
            $teamScores[$item['type']][$item['teamid']] = $item;
        }

        ksort($teamScores);

        //-----------积分排行-------------
        $standingsStats = $this->standings_stats_db->select('competitionid=' . $id . ' AND type="total"', '*', 15, 'score DESC');

        include template('sportsdata', 'ft_competition_team_scores');
    }

    //最常见赛果统计
    public function competition_frequent_results(){
        $id = (int)$_GET['id'];

        if ($id <= 0) {
            return false;
        }

        $competition         = $this->competition_db->get_one('competitionid=' . $id);
        $competition['date'] = date('Y', $competition['startdate']) . '-' . date('Y', $competition['enddate']) . '赛季';
        $competition['logo'] = PHOTO_PATH . 'competition/' . $id . '.jpg';
        //seo
        $SEO['title'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '_最常见赛果-399彩迷网';
        $SEO['keyword'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . ',最常见赛果';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        $fResults = $this->frequentresults_db->get_one('competitionid=' . $id);

        foreach (['rank', 'result', 'no', 'percentage'] as $item) {
            $fResults[$item] = ltrim($fResults[$item], '[');
            $fResults[$item] = rtrim($fResults[$item], ']');
            $fResults[$item] = explode(',', $fResults[$item]);
        }

        //-----------积分排行-------------
        $standingsStats = $this->standings_stats_db->select('competitionid=' . $id . ' AND type="total"', '*', 15, 'score DESC');

        include template('sportsdata', 'ft_competition_frequent_results');
    }

    //攻守统计
    public function competition_getmiss(){
        $id = (int)$_GET['id'];

        if ($id <= 0) {
            return false;
        }

        $competition         = $this->competition_db->get_one('competitionid=' . $id);
        $competition['date'] = date('Y', $competition['startdate']) . '-' . date('Y', $competition['enddate']) . '赛季';
        $competition['logo'] = PHOTO_PATH . 'competition/' . $id . '.jpg';
        //seo
        $SEO['title'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '_攻守统计-399彩迷网';
        $SEO['keyword'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . ',攻守统计';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        //-----------积分排行-------------
        $standingsStats = $this->standings_stats_db->select('competitionid=' . $id . ' AND type="total"', '*', 15, 'score DESC');

        //-----------攻守统计-------------
        $getmiss = $this->getmiss_db->select('competitionid=' . $id);

        foreach ($getmiss as $item) {
            $getmissData[$item['type1']][$item['type2']][$item['teamid']] = $item;
        }

        ksort($getmissData);

        include template('sportsdata', 'ft_competition_getmiss');
    }

    //射手榜
    public function competition_shooter(){
        $id = (int)$_GET['id'];

        if ($id <= 0) {
            return false;
        }

        $competition         = $this->competition_db->get_one('competitionid=' . $id);
        $competition['date'] = date('Y', $competition['startdate']) . '-' . date('Y', $competition['enddate']) . '赛季';
        $competition['logo'] = PHOTO_PATH . 'competition/' . $id . '.jpg';
        //seo
        $SEO['title'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '_神射手榜-399彩迷网';
        $SEO['keyword'] = ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . ',神射手榜';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($competition['shortname'] ? $competition['shortname'] : $competition['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        //-----------积分排行-------------
        $standingsStats = $this->standings_stats_db->select('competitionid=' . $id . ' AND type="total"', '*', 15, 'score DESC');

        $shooter = $this->shooter_db->select('competitionid=' . $id, '*', 50, 'rank');

        include template('sportsdata', 'ft_competition_shooter');
    }

    //进球时间分布统计
    public function competition_goaltime()
    {
        $id = $_GET['id'] ? (int)$_GET['id'] : 92;

        $info = $this->_competition_info($id, '`name`,`shortname`,`startdate`,`enddate`');
        $info['logo'] = PHOTO_PATH . 'competition/' . $id . '.jpg';
        $info['season'] = date('Y', $info['startdate']) . '-' . date('Y', $info['enddate']) . '赛季';
        //seo
        $SEO['title'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '_进球时间分布-399彩迷网';
        $SEO['keyword'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . ',进球时间分布';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($info['shortname'] ? $info['shortname'] : $info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        $db = pc_base::load_model('goaltime_stats_model');
        $result = $db->select(['competitionid' => $id]);

        $_data = [];
        foreach ($result as $r) {
            $_data[$r['type']][] = $r;
        }

        $standing_info = $this->_competition_standing($id);

        include template('sportsdata', 'ft_competition_goaltime');
    }

    //最先入球、失球统计
    public function competition_fgetmiss()
    {
        $id = $_GET['id'] ? (int)$_GET['id'] : 92;

        $info = $this->_competition_info($id, '`name`,`shortname`,`startdate`,`enddate`');
        $info['logo'] = PHOTO_PATH . 'competition/' . $id . '.jpg';
        $info['season'] = date('Y', $info['startdate']) . '-' . date('Y', $info['enddate']) . '赛季';
        //seo
        $SEO['title'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . '_进球时间分布-399彩迷网';
        $SEO['keyword'] = ($info['shortname'] ? $info['shortname'] : $info['name']) . ',进球时间分布';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . ($info['shortname'] ? $info['shortname'] : $info['name']) . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        $db = pc_base::load_model('fgetmiss_stats_model');
        $_data = $db->select(['competitionid' => $id]);

        $standing_info = $this->_competition_standing($id);

        include template('sportsdata', 'ft_competition_fgetmiss');
    }

    /**
     * 积分排名
     * @param int $id 联赛id
     * @return array
     */
    private function _competition_standing($id, $num = 15, $type = 'total')
    {
        $db = pc_base::load_model('standings_stats_model');
        $result = $db->select(['competitionid' => $id, 'type' => $type], '*', $num, '`score` DESC');

        $rank = 1;
        foreach ($result as &$r) {
            $r['rank'] = $rank;
            ++$rank;
        }

        return $result;
    }

    /**
     * 赛事详情
     * 1、比赛基本信息
     * 2、比赛预测、阵容
     * 3、球队近两年塞绩、未来赛程、历史统计
     */
    public function game()
    {
        if (! $_GET['gameid']) {
            showmessage(L('competition_not_exists'),'blank');
        }
        $gameid = $_GET['gameid'];
        ## 赛事基本资料
        $game_data = $this->_gameinfo($gameid);
        //比赛状态数组
        $arr_status = $this->arr_status;
        ##比赛预测
        if(!empty($game_data))
        {
            $this->db = pc_base::load_model('game_forecast_model');
            $forecast_where ="gameid ={$gameid}";
            $forecast_data=$this->db->get_one($forecast_where,"homeplayers, awayplayers, homerecenttendency, awayrecenttendency, homeoddswinlose, awayoddswinlose, confidence, resultsofthematch, content");
            $forecast_data['homerecenttendency'] = $this->db->value_replace($forecast_data['homerecenttendency']);
            $forecast_data['awayrecenttendency'] = $this->db->value_replace($forecast_data['awayrecenttendency']);
            $forecast_data['homeoddswinlose'] = $this->db->value_replace($forecast_data['homeoddswinlose']);
            $forecast_data['awayoddswinlose'] = $this->db->value_replace($forecast_data['awayoddswinlose']);
//            $forecast_data['homeplayers']=$this->db->object_to_array(json_decode($forecast_data['homeplayers']));
//            $forecast_data['awayplayers']=$this->db->object_to_array(json_decode($forecast_data['awayplayers']));
//            foreach($forecast_data['homeplayers'] as $homeplayers_key =>$homeplayers_data)
//            {
//                if($homeplayers_data['Status']==3)
//                {
//                    $forecast_home_first[$homeplayers_key]['Id']=$homeplayers_data['Id'];
//                    $forecast_home_first[$homeplayers_key]['Name']=$homeplayers_data['Name'];
//                    $forecast_home_first[$homeplayers_key]['ShitNo']=$homeplayers_data['ShitNo'];
//                    $forecast_home_first[$homeplayers_key]['Pos']=$this->db->val_pos($homeplayers_data['Pos']);
//                    $forecast_home_first[$homeplayers_key]['Status']=$homeplayers_data['Status'];
//                }
//                if($homeplayers_data['Status']==0)
//                {
//                    $forecast_home_reserve[$homeplayers_key]['Id']=$homeplayers_data['Id'];
//                    $forecast_home_reserve[$homeplayers_key]['Name']=$homeplayers_data['Name'];
//                    $forecast_home_reserve[$homeplayers_key]['ShitNo']=$homeplayers_data['ShitNo'];
//                    $forecast_home_reserve[$homeplayers_key]['Pos']=$this->db->val_pos($homeplayers_data['Pos']);
//                    $forecast_home_reserve[$homeplayers_key]['Status']=$homeplayers_data['Status'];
//                }
//                if($homeplayers_data['Status']==1)
//                {
//                    $forecast_home_stop[$homeplayers_key]['Id']=$homeplayers_data['Id'];
//                    $forecast_home_stop[$homeplayers_key]['Name']=$homeplayers_data['Name'];
//                    $forecast_home_stop[$homeplayers_key]['ShitNo']=$homeplayers_data['ShitNo'];
//                    $forecast_home_stop[$homeplayers_key]['Pos']=$this->db->val_pos($homeplayers_data['Pos']);
//                    $forecast_home_stop[$homeplayers_key]['Status']=$homeplayers_data['Status'];
//                }
//                if($homeplayers_data['Status']==2)
//                {
//                    $forecast_home_injuries[$homeplayers_key]['Id']=$homeplayers_data['Id'];
//                    $forecast_home_injuries[$homeplayers_key]['Name']=$homeplayers_data['Name'];
//                    $forecast_home_injuries[$homeplayers_key]['ShitNo']=$homeplayers_data['ShitNo'];
//                    $forecast_home_injuries[$homeplayers_key]['Pos']=$this->db->val_pos($homeplayers_data['Pos']);
//                    $forecast_home_injuries[$homeplayers_key]['Status']=$homeplayers_data['Status'];
//                }
//                if($homeplayers_data['Status']==4)
//                {
//                    $forecast_home_other[$homeplayers_key]['Id']=$homeplayers_data['Id'];
//                    $forecast_home_other[$homeplayers_key]['Name']=$homeplayers_data['Name'];
//                    $forecast_home_other[$homeplayers_key]['ShitNo']=$homeplayers_data['ShitNo'];
//                    $forecast_home_other[$homeplayers_key]['Pos']=$this->db->val_pos($homeplayers_data['Pos']);
//                    $forecast_home_other[$homeplayers_key]['Status']=$homeplayers_data['Status'];
//                }
//            }
//            foreach($forecast_data['awayplayers'] as $awayplayers_key =>$awayplayers_data)
//            {
//                if($awayplayers_data['Status']==3)
//                {
//                    $forecast_away_first[$awayplayers_key]['Id']=$awayplayers_data['Id'];
//                    $forecast_away_first[$awayplayers_key]['Name']=$awayplayers_data['Name'];
//                    $forecast_away_first[$awayplayers_key]['ShitNo']=$awayplayers_data['ShitNo'];
//                    $forecast_away_first[$awayplayers_key]['Pos']=$this->db->val_pos($awayplayers_data['Pos']);
//                    $forecast_away_first[$awayplayers_key]['Status']=$awayplayers_data['Status'];
//                }
//                if($awayplayers_data['Status']==0)
//                {
//                    $forecast_away_reserve[$awayplayers_key]['Id']=$awayplayers_data['Id'];
//                    $forecast_away_reserve[$awayplayers_key]['Name']=$awayplayers_data['Name'];
//                    $forecast_away_reserve[$awayplayers_key]['ShitNo']=$awayplayers_data['ShitNo'];
//                    $forecast_away_reserve[$awayplayers_key]['Pos']=$this->db->val_pos($awayplayers_data['Pos']);
//                    $forecast_away_reserve[$awayplayers_key]['Status']=$awayplayers_data['Status'];
//                }
//                if($awayplayers_data['Status']==1)
//                {
//                    $forecast_away_stop[$awayplayers_key]['Id']=$awayplayers_data['Id'];
//                    $forecast_away_stop[$awayplayers_key]['Name']=$awayplayers_data['Name'];
//                    $forecast_away_stop[$awayplayers_key]['ShitNo']=$awayplayers_data['ShitNo'];
//                    $forecast_away_stop[$awayplayers_key]['Pos']=$this->db->val_pos($awayplayers_data['Pos']);
//                    $forecast_away_stop[$awayplayers_key]['Status']=$awayplayers_data['Status'];
//                }
//                if($awayplayers_data['Status']==2)
//                {
//                    $forecast_away_injuries[$awayplayers_key]['Id']=$awayplayers_data['Id'];
//                    $forecast_away_injuries[$awayplayers_key]['Name']=$awayplayers_data['Name'];
//                    $forecast_away_injuries[$awayplayers_key]['ShitNo']=$awayplayers_data['ShitNo'];
//                    $forecast_away_injuries[$awayplayers_key]['Pos']=$this->db->val_pos($awayplayers_data['Pos']);
//                    $forecast_away_injuries[$awayplayers_key]['Status']=$awayplayers_data['Status'];
//                }
//                if($awayplayers_data['Status']==4)
//                {
//                    $forecast_away_other[$awayplayers_key]['Id']=$awayplayers_data['Id'];
//                    $forecast_away_other[$awayplayers_key]['Name']=$awayplayers_data['Name'];
//                    $forecast_away_other[$awayplayers_key]['ShitNo']=$awayplayers_data['ShitNo'];
//                    $forecast_away_other[$awayplayers_key]['Pos']=$this->db->val_pos($awayplayers_data['Pos']);
//                    $forecast_away_other[$awayplayers_key]['Status']=$awayplayers_data['Status'];
//                }
//            }
        }


        $this->db = pc_base::load_model('game_stats_model');
        $ranking_sql ="select * from ft_game_stats where gameid={$gameid}";
        $ranking_rel=$this->db->query($ranking_sql);
        $ranking_data=$this->db->fetch_array($ranking_rel);
        ##联赛
        $league_datas=$this->db->object_to_array(json_decode($ranking_data[0]['competition']));
        ##球队
        $team_datas=$this->db->object_to_array(json_decode($ranking_data[0]['team']));
        ##排名统计
        $ranking_datas=$this->db->object_to_array(json_decode($ranking_data[0]['standings']));
        ##近两年战绩
        $record_datas=$this->db->object_to_array(json_decode($ranking_data[0]['teamhistory']));
        $record_home=$record_datas['Home'];
        foreach($record_home as $home_key =>$home_data)
        {
            $record_home[$home_key]['plate']=get_plate($home_data['Score'][0],$home_data['Score'][1]);
        }
        $record_away=$record_datas['Away'];
        foreach($record_away as $away_key =>$away_data)
        {
            $record_away[$away_key]['plate']=get_plate($away_data['Score'][0],$away_data['Score'][1]);
        }

        ##进球单双统计
        $ds_datas=$this->db->object_to_array(json_decode($ranking_data[0]['teamstats']));
        $ds_home=$ds_datas['Home']['TotalGoal'];
        $ds_away=$ds_datas['Away']['TotalGoal'];
        ##进球统计
        $goal_home=$ds_datas['Home']['Goal'];
        $goal_away=$ds_datas['Away']['Goal'];
        ##盘路统计
        $plate_home=$ds_datas['Home']['Odds'];
        $plate_away=$ds_datas['Away']['Odds'];
        ##未来赛程
        $game_datas=$this->db->object_to_array(json_decode($ranking_data[0]['teamfixture']));
        $game_home=$game_datas['Home'];
        foreach($game_home as $game_key => $game_info)
        {
            $game_home[$game_key]['Date']=date('Y-m-d H:i:s', floor($game_info['Date'] / 1000));
        }
        $game_away=$game_datas['Away'];
        foreach($game_away as $game_key => $game_info)
        {
            $game_away[$game_key]['Date']=date('Y-m-d H:i:s', floor($game_info['Date'] / 1000));
        }
        //统计类别
        $type = array(
            'Total' => '总',
            'Home' => '主',
            'Neutral' => '中',
            'Away' => '客',
            'Last6Game' => '近六轮'
        );

        $siteid = $GLOBALS['siteid'] = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
        define('SITEID', $siteid);
        //SEO
        $SEO = seo($siteid);
        $sitelist  = getcache('sitelist','commons');
        $default_style = $sitelist[$siteid]['default_style'];
        include template('sportsdata', 'ft_game', $default_style);
    }

    /**
     * 过往战绩(分析每场比赛两支球队过往情况)
     * 1、比赛基本信息
     * 2、比赛往绩数据
     */
    public function game_analyse()
    {
        if (! $_GET['gameid']) {
            showmessage(L('game_not_exists'),'blank');
        }
        $gameid = $_GET['gameid'];
        $where = "gameid=" . $gameid;
        $siteid = $GLOBALS['siteid'] = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
        define('SITEID', $siteid);
        $sitelist  = getcache('sitelist','commons');
        $default_style = $sitelist[$siteid]['default_style'];

        //数据库
        $this->game_db = pc_base::load_model("game_model");

        //当场比赛
        $gameinfo = $this->_gameinfo($gameid);
        //seo
        $SEO['title'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队_足球数据统计赔分析预测-399彩迷网';
        $SEO['keyword'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队，足球数据统计赔分析预测';
        $SEO['description'] = '399彩迷提供权威的足球数据统计,足彩数据分析，包括足球的欧洲指数,亚洲盘口,大小球指数,球赛数据统计，以及足彩分析预测。';

        $tag_analyse = 1;

        //比赛状态数组
        $arr_status = $this->arr_status;

        //过往战绩
        $this->game_db->table_name = "ft_game_stats";
        $stats_info = $this->game_db->get_one($where);
        //联赛信息
        $competition = json_decode($stats_info['competition'], true);
        //球队信息
        $team = json_decode($stats_info['team'], true);
        $temp = $team_stats = $meeting = $team_fixture = $team_history = $total = $competition_list = array();
        //表格记录条数
        $size_list = array(10, 20, 30);

        //交锋往绩
        if (isset($stats_info['meeting'])) {
            $temp['meeting'] = json_decode($stats_info['meeting'], true);
            foreach ($temp['meeting'] as $data) {

                //联赛列表  以下过滤数据都不能使用break跳出循环，会导致联赛列表数据不足
                $meeting_competition_id[$data['Id'][1]] = $competition[$data['Id'][1]]['ShortName'];

                $row = array();
                $row['is_home'] = $gameinfo['hometeamid'] == $data['Id'][2] ? 1 : 0;
                $row['main_home_score'] = $row['is_home'] ? $data['Score'][0] : $data['Score'][1];  //统计以game_info中的主队为主
                $row['main_away_score'] = $row['is_home'] ? $data['Score'][1] : $data['Score'][0];  //统计以game_info的主队为主
                $row['gameid'] = $data['Id'][0];
                $row['competitionid'] = $data['Id'][1];
                $row['competition_name'] = $competition[$data['Id'][1]]['ShortName'];
                $row['competition_color'] = $competition[$data['Id'][1]]['Color'];
                $row['date'] = date('Y-m-d', floor($data['Date'] / 1000));
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
            }
        }

        //比赛预测
        if(!empty($gameinfo))
        {
            $this->db = pc_base::load_model('game_forecast_model');
            $forecast_where ="gameid ={$gameid}";
            $forecast_data=$this->db->get_one($forecast_where,"homeplayers, awayplayers, homerecenttendency, awayrecenttendency, homeoddswinlose, awayoddswinlose, confidence, resultsofthematch, content");
            $forecast_data['homerecenttendency'] = $this->db->value_replace($forecast_data['homerecenttendency']);
            $forecast_data['awayrecenttendency'] = $this->db->value_replace($forecast_data['awayrecenttendency']);
            $forecast_data['homeoddswinlose'] = $this->db->value_replace($forecast_data['homeoddswinlose']);
            $forecast_data['awayoddswinlose'] = $this->db->value_replace($forecast_data['awayoddswinlose']);

            //预测阵容
            $lineup = $this->db->lineup_by_pos($gameid);

            //球队平均年龄
            $this->db = pc_base::load_model('team_model');
            $team_age = $this->db->select('`teamid` IN (' . $gameinfo['hometeamid'] . ',' . $gameinfo['awayteamid'] .  ')', '`teamid`,`playerageavg`', '', '', '', 'teamid');
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
                    if ($gameinfo[$category . 'teamid'] == $history['Id'][2]) {    //作为主队
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
                    //联赛列表  以下过滤数据都不能使用break跳出循环，会导致联赛列表数据不足
                    $competition_list[$category][$history['Id'][1]] = $competition[$history['Id'][1]]['ShortName'];
                    //列表数据
                    $row = array();
                    $row['is_home'] = $gameinfo[$category . 'teamid'] == $history['Id'][2] ? 1 : 0;
                    $row['neutral'] = $history['N'] ? 1 : 0;
                    $row['main_home_score'] = $row['is_home'] ? $history['Score'][0] : $history['Score'][1];  //统计以game_info中的主队为主
                    $row['main_away_score'] = $row['is_home'] ? $history['Score'][1] : $history['Score'][0];  //统计以game_info的主队为主
                    $row['competitionid'] = $history['Id'][1];
                    $row['competition_name'] = $competition[$history['Id'][1]]['ShortName'];
                    $row['competition_color'] = $competition[$history['Id'][1]]['Color'];
                    $row['date'] = date('Y-m-d', $history['Date']);
                    $row['homescore'] = $history['Score'][0];
                    $row['awayscore'] = $history['Score'][1];
                    $row['result'] = $gameinfo[$category . 'teamid'] == $history['Id'][2] ? get_result($history['Score']) : get_result($row['awayscore'], $row['homescore']);
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

        //统计数据
        if (isset($stats_info['teamstats'])) {
            $temp['team_stats'] = json_decode($stats_info['teamstats'], true);
            foreach ($temp['team_stats'] as $name => $stats) {
                $category = strtolower($name);
                //进球数、单双统计
                $team_stats[$category]['total_goal'] = $stats['TotalGoal'];
                //进球数统计
                foreach ($stats['Goal'] as $key => $data) {
                    $sum = array_sum($data);
                    foreach ($data as $value) {
                        $rate = round(($value / $sum) * 100, 2) . "%";
                        $team_stats[$category]['goal'][strtolower($key)]['number'][] = $value;
                        $team_stats[$category]['goal'][strtolower($key)]['rate'][] = $rate;
                    }
                }
                //以往盘路
                foreach ($stats['Odds'] as $key => $data) {
                    $sum = array_sum($data);
                    foreach ($data as $value) {
                        $rate = round(($value / $sum) * 100, 2) . "%";
                        $team_stats[$category]['odds'][strtolower($key)]['number'][] = $value;
                        $team_stats[$category]['odds'][strtolower($key)]['rate'][] = $rate;
                    }
                }
            }
        }

        //排名统计
        if (isset($stats_info['standings'])) {
            $temp['standings'] = json_decode($stats_info['standings'], true);
        }

        //未来赛程
        if (isset($stats_info['teamfixture'])) {
            $temp['team_fixture'] = json_decode($stats_info['teamfixture'], true);
            foreach ($temp['team_fixture'] as $name => $fixtures) {
                $category = strtolower($name);
                foreach ($fixtures as $fixture) {
                    $row = array();
                    $row['competitionid'] = $fixture['Id'][1];
                    $row['competition_name'] = $competition[$fixture['Id'][1]]['ShortName'];
                    $row['competition_color'] = $competition[$fixture['Id'][1]]['Color'];
                    $row['hometeamid'] = $fixture['Id'][2];
                    $row['awayteamid'] = $fixture['Id'][3];
                    $row['homename'] = $team[$fixture['Id'][2]]['Name'];
                    $row['awayname'] = $team[$fixture['Id'][3]]['Name'];
                    $row['date'] = date('Y-m-d H:i', floor($fixture['Date'] / 1000));
                    $team_fixture[$category][] = $row;
                }
            }
        }

        //盘路走势
        $this->db = pc_base::load_model('oddsway_stats_model');
        $temp['oddsway_info'] = $this->db->select('`competitionid`=' . $gameinfo['competitionid'], '*', '', '`win` DESC');

        $this->db->query("select  update_time  from information_schema.tables where table_name ='ft_oddsway_stats' ;");
        $oddsway_last_update_time = $this->db->fetch_array()[0];

        if ($temp['oddsway_info']) {
            $oddsway_info = $oddsway_stats = $team_ids = array();
            foreach ($temp['oddsway_info'] as $row) {
                $oddsway_info[$row['type']][] = $row;
                $team_ids[] = $row['teamid'];
            }

            //统计
            $total_sum = array_sum(array_column($oddsway_info['total'], 'total'));
            $home_sum = array_sum(array_column($oddsway_info['home'], 'total'));
            $away_sum = array_sum(array_column($oddsway_info['away'], 'total'));
            $max_draw = max(array_column($oddsway_info['total'], 'draw'));
            $max_win['total'] = max(array_column($oddsway_info['total'], 'win'));
            $max_win['home'] = max(array_column($oddsway_info['home'], 'win'));
            $max_win['away'] = max(array_column($oddsway_info['away'], 'win'));
            $min_win['total'] = min(array_column($oddsway_info['total'], 'win'));
            $min_win['home'] = min(array_column($oddsway_info['home'], 'win'));
            $min_win['away'] = min(array_column($oddsway_info['away'], 'win'));

            //主场赢盘
            $oddsway_stats['home_win'] = array_sum(array_column($oddsway_info['home'], 'win'));
            $oddsway_stats['home_win_rate'] = round(($oddsway_stats['home_win'] / $home_sum) * 100, 2) . "%";

            //客场赢盘
            $oddsway_stats['away_win'] = array_sum(array_column($oddsway_info['away'], 'win'));
            $oddsway_stats['away_win_rate'] = round(($oddsway_stats['away_win'] / $away_sum) * 100, 2) . "%";

            //和局走水
            $oddsway_stats['draw'] = array_sum(array_column($oddsway_info['total'], 'draw'));
            $oddsway_stats['draw_rate'] = round(($oddsway_stats['draw'] / $total_sum) * 100, 2) . "%";

            foreach ($oddsway_info as $type => $info) {
                foreach ($info as $row) {
                    //赢盘最多
                    if ($row['win'] == $max_win[$type]) {
                        $best_win[$type][] = array(
                            'id' => $row['teamid'],
                            'name' => $row['teamname']
                        );
                        $best_win_rate[$type] = $row['winrate'] . '%';
                    }
                    //赢盘最少
                    if ($row['win'] == $min_win[$type]) {
                        $weak_win[$type][] = array(
                            'id' => $row['teamid'],
                            'name' => $row['teamname']
                        );
                        $weak_win_rate[$type] = $row['winrate'] . '%';
                    }
                    //走水最多
                    if ($row['draw'] == $max_draw) {
                        $best_draw[] = array(
                            'id' => $row['teamid'],
                            'name' => $row['teamname']
                        );
                        $max_draw_rate = round(($row['draw'] / $row['total']) * 100, 2) . "%";
                    }
                }
            }

            //最近八场统计
            if (count($team_ids)) {
                //取该联赛全部完场记录，因为盘路表包含了联赛的所有球队
                $this->game_db->table_name = 'ft_game';
                $all_game_info = $this->game_db->select('`status` IN (4,10) AND `competitionid`=' . $gameinfo['competitionid'], '`homescore`,`awayscore`,`handicap`,`hometeamid`,`awayteamid`', '', '`date` DESC');

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
            }
        }

        //积分榜
        $this->db = pc_base::load_model('standings_stats_model');
        $temp['standings_info'] = $this->db->select('`competitionid`=' . $gameinfo['competitionid'], '*', '', '`type`,`score` DESC');

        $this->db->query("select  update_time  from information_schema.tables where table_name ='ft_standings_stats' ;");
        $standings_last_update_time = $this->db->fetch_array()[0];

        if ($temp['standings_info']) {
            $standings_info = $standings_stats = array();
            foreach ($temp['standings_info'] as $row) {
                $standings_info[$row['type']][] = $row;
            }

            //开赛，未开赛场次
            $this->db->table_name = 'ft_game';
            $total_game = $this->db->count('`competitionid`=' . $gameinfo['competitionid']);
            $ready_game = $this->db->count('`status`=17 AND `competitionid`=' . $gameinfo['competitionid']);
            $has_start_game = $total_game - $ready_game;
            $has_start_game_rate = round(($has_start_game / $total_game) * 100, 2) . "%";
            $ready_game_rate = round(($ready_game / $total_game) * 100, 2) . "%";

            //统计
            $total_sum = array_sum(array_column($standings_info['total'], 'total'));
            $home_sum = array_sum(array_column($standings_info['home'], 'total'));
            $away_sum = array_sum(array_column($standings_info['away'], 'total'));
            $max_goal['total'] = max(array_column($standings_info['total'], 'goal'));
            $max_goal['home'] = max(array_column($standings_info['home'], 'goal'));
            $max_goal['away'] = max(array_column($standings_info['away'], 'goal'));
            $min_goal['total'] = min(array_column($standings_info['total'], 'goal'));
            $min_goal['home'] = min(array_column($standings_info['home'], 'goal'));
            $min_goal['away'] = min(array_column($standings_info['away'], 'goal'));
            $max_nongoal['total'] = max(array_column($standings_info['total'], 'nongoal'));
            $max_nongoal['home'] = max(array_column($standings_info['home'], 'nongoal'));
            $max_nongoal['away'] = max(array_column($standings_info['away'], 'nongoal'));
            $min_nongoal['total'] = min(array_column($standings_info['total'], 'nongoal'));
            $min_nongoal['home'] = min(array_column($standings_info['home'], 'nongoal'));
            $min_nongoal['away'] = min(array_column($standings_info['away'], 'nongoal'));

            //主场胜出
            $standings_stats['home_win'] = array_sum(array_column($standings_info['home'], 'win'));
            $standings_stats['home_win_rate'] = round(($standings_stats['home_win'] / $home_sum) * 100, 2) . "%";

            //平局(平局只能以主客其中一组数据统计，不能以总统计)
            $standings_stats['draw'] = array_sum(array_column($standings_info['home'], 'draw'));
            $standings_stats['draw_rate'] = round(($standings_stats['draw'] / $home_sum) * 100, 2) . "%";

            //客场胜出
            $standings_stats['away_win'] = array_sum(array_column($standings_info['away'], 'win'));
            $standings_stats['away_win_rate'] = round(($standings_stats['away_win'] / $away_sum) * 100, 2) . "%";

            //总进球数
            $standings_stats['total_goal'] = array_sum(array_column($standings_info['total'], 'goal'));
            $standings_stats['total_goal_per'] = round(($standings_stats['total_goal'] / $total_sum), 2);

            //主场进球数
            $standings_stats['home_goal'] = array_sum(array_column($standings_info['home'], 'goal'));
            $standings_stats['home_goal_per'] = round(($standings_stats['home_goal'] / $home_sum), 2);

            //客场进球数
            $standings_stats['away_goal'] = array_sum(array_column($standings_info['away'], 'goal'));
            $standings_stats['away_goal_per'] = round(($standings_stats['away_goal'] / $away_sum), 2);

            //攻守能力
            foreach ($standings_info as $type => $info) {
                foreach ($info as $row) {
                    //最佳攻击力
                    if ($row['goal'] == $max_goal[$type]) {
                        $best_attack[$type][] = array(
                            'id' => $row['teamid'],
                            'name' => $row['teamname']
                        );
                    }
                    //最差攻击力
                    if ($row['goal'] == $min_goal[$type]) {
                        $weak_attack[$type][] = array(
                            'id' => $row['teamid'],
                            'name' => $row['teamname']
                        );
                    }
                    //最差防守
                    if ($row['nongoal'] == $max_nongoal[$type]) {
                        $weak_defence[$type][] = array(
                            'id' => $row['teamid'],
                            'name' => $row['teamname']
                        );
                    }
                    //最佳防守
                    if ($row['nongoal'] == $min_nongoal[$type]) {
                        $best_defence[$type][] = array(
                            'id' => $row['teamid'],
                            'name' => $row['teamname']
                        );
                    }
                }
            }
        }

        unset($temp);

        include template("sportsdata", "ft_game_analyse", $default_style);
    }

    //比赛亚指
    public function game_odds_asia()
    {
        if (isset($_REQUEST['gameid']) && !empty($_REQUEST['gameid'])) {
            $gameid = intval($_REQUEST['gameid']);
        } else {
            showmessage('比赛ID不正确');
        }

        //基本信息
        $gameinfo = $this->_gameinfo($gameid);
        //seo
        $SEO['title'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队_足球亚洲盘口赔率分析-399彩迷网';
        $SEO['keyword'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队，足球亚洲盘口赔率分析';
        $SEO['description'] = '足球亚洲盘口,足球亚洲赔率分析,亚盘数据分析，399彩迷网为您提供最为价值权威的数据以及数据预测。';

        $tag_asia = 1;

        //状态
        $arr_status = $this->arr_status;

        //即时指数
        $this->db->table_name = 'ft_odds_asia';
        $company_id           = [3000048, 3000181, 3000271, 3000368, 3000379, 3000390, 3000471];
        $where                = to_sqls($company_id, '', '`companyid`');
        $odds                 = $this->db->select("`gameid` ='$gameid' AND " . $where, '`companyid`,`companyname`,`up`,`down`,`give`,`fup`,`fdown`,`fgive`,`oddsdate`', '', '', '', 'companyid');

        //指数变化
        $tmp = $this->db->select("`gameid` = '$gameid' AND " . $where, '`up`,`down`,`give`,`oddsdate`,`companyid`', '', '`oddsdate` DESC');

        //合并
        foreach ($tmp as $r) {
            $odds_all[$r['oddsdate']][$r['companyid']] = $r;
        }

        unset($tmp);
        include template('sportsdata', 'ft_game_odds_asia');
    }

    //比赛欧赔
    public function game_odds_euro()
    {
        if (isset($_REQUEST['gameid']) && !empty($_REQUEST['gameid'])) {
            $gameid = intval($_REQUEST['gameid']);
        } else {
            showmessage('比赛ID不正确');
        }

        //基本信息
        $gameinfo = $this->_gameinfo($gameid);
        //seo
        $SEO['title'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队_足球欧洲指数赔率分析-399彩迷网';
        $SEO['keyword'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队，足球欧洲指数赔率分析';
        $SEO['description'] = '足球欧洲指数,即时赔率,足球赔率分析，399彩迷网为您提供最为价值权威的数据以及数据预测。';

        //状态
        $arr_status = $this->arr_status;

        $tag_euro = 1;

        //指数变化
        $this->db->table_name = 'ft_odds_euro';
        $odds_all = $this->db->select("`gameid` = '$gameid'", '`homewin`,`draw`,`awaywin`,`homewinrate`,`drawrate`,`awaywinrate`,`returnrate`,`fhomewin`,`fdraw`,`fawaywin`,`fhomewinrate`,`fdrawrate`,`fawaywinrate`,`freturnrate`,`companyname`,`oddsdate`,`companyid`', '', '`oddsdate` DESC');

        //公司合计
        $company_num = count(array_unique(array_column($odds_all, 'companyid')));

        //最高值、最小值、平均值
        $total = count($odds_all);
        $odds_stat[] = array(
            'max_homewin' => max(array_column($odds_all, 'homewin')),
            'max_draw' => max(array_column($odds_all, 'draw')),
            'max_awaywin' => max(array_column($odds_all, 'awaywin')),
            'max_homewinrate' => max(array_column($odds_all, 'homewinrate')),
            'max_drawrate' => max(array_column($odds_all, 'drawrate')),
            'max_awaywinrate' => max(array_column($odds_all, 'awaywinrate')),
            'max_returnrate' => max(array_column($odds_all, 'returnrate')),
            'max_fhomewin' => max(array_column($odds_all, 'fhomewin')),
            'max_fdraw' => max(array_column($odds_all, 'fdraw')),
            'max_fawaywin' => max(array_column($odds_all, 'fawaywin')),
            'max_fhomewinrate' => max(array_column($odds_all, 'fhomewinrate')),
            'max_fdrawrate' => max(array_column($odds_all, 'fdrawrate')),
            'max_fawaywinrate' => max(array_column($odds_all, 'fawaywinrate')),
            'max_freturnrate' => max(array_column($odds_all, 'freturnrate')),
            'min_homewin' => min(array_column($odds_all, 'homewin')),
            'min_draw' => min(array_column($odds_all, 'draw')),
            'min_awaywin' => min(array_column($odds_all, 'awaywin')),
            'min_homewinrate' => min(array_column($odds_all, 'homewinrate')),
            'min_drawrate' => min(array_column($odds_all, 'drawrate')),
            'min_awaywinrate' => min(array_column($odds_all, 'awaywinrate')),
            'min_returnrate' => min(array_column($odds_all, 'returnrate')),
            'min_fhomewin' => min(array_column($odds_all, 'fhomewin')),
            'min_fdraw' => min(array_column($odds_all, 'fdraw')),
            'min_fawaywin' => min(array_column($odds_all, 'fawaywin')),
            'min_fhomewinrate' => min(array_column($odds_all, 'fhomewinrate')),
            'min_fdrawrate' => min(array_column($odds_all, 'fdrawrate')),
            'min_fawaywinrate' => min(array_column($odds_all, 'fawaywinrate')),
            'min_freturnrate' => min(array_column($odds_all, 'freturnrate')),
            'avg_homewin' => array_sum(array_column($odds_all, 'homewin'))/$total,
            'avg_draw' => array_sum(array_column($odds_all, 'draw'))/$total,
            'avg_awaywin' => array_sum(array_column($odds_all, 'awaywin'))/$total,
            'avg_homewinrate' => array_sum(array_column($odds_all, 'homewinrate'))/$total,
            'avg_drawrate' => array_sum(array_column($odds_all, 'drawrate'))/$total,
            'avg_awaywinrate' => array_sum(array_column($odds_all, 'awaywinrate'))/$total,
            'avg_returnrate' => array_sum(array_column($odds_all, 'returnrate'))/$total,
            'avg_fhomewin' => array_sum(array_column($odds_all, 'fhomewin'))/$total,
            'avg_fdraw' => array_sum(array_column($odds_all, 'fdraw'))/$total,
            'avg_fawaywin' => array_sum(array_column($odds_all, 'fawaywin'))/$total,
            'avg_fhomewinrate' => array_sum(array_column($odds_all, 'fhomewinrate'))/$total,
            'avg_fdrawrate' => array_sum(array_column($odds_all, 'fdrawrate'))/$total,
            'avg_fawaywinrate' => array_sum(array_column($odds_all, 'fawaywinrate'))/$total,
            'avg_freturnrate' => array_sum(array_column($odds_all, 'freturnrate'))/$total
        );

        include template('sportsdata', 'ft_game_odds_euro');
    }

    //比赛大小指数
    public function game_odds_ou()
    {
        if (isset($_REQUEST['gameid']) && !empty($_REQUEST['gameid'])) {
            $gameid = intval($_REQUEST['gameid']);
        } else {
            showmessage('比赛ID不正确');
        }

        $tag_ou = 1;

        //基本信息
        $gameinfo   = $this->_gameinfo($gameid);
        $company_id = [3000048, 3000181, 3000271, 3000368, 3000379, 3000390, 3000471];
        $where      = to_sqls($company_id, '', '`companyid`');
        //seo
        $SEO['title'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队_足球大小指数分析-399彩迷网';
        $SEO['keyword'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队，足球大小指数分析';
        $SEO['description'] = '足球大小指数,大小球盘口分析,足球指数分析，399彩迷网为您提供最为价值权威的数据以及数据预测。';

        //状态
        $arr_status = $this->arr_status;

        //即时指数
        $this->db->table_name = 'ft_odds_ou';
        $odds                 = $this->db->select("`gameid` ='$gameid' AND " . $where, '`companyid`,`companyname`,`big`,`small`,`total`,`fbig`,`fsmall`,`ftotal`,`oddsdate`', '', '', '', 'companyid');

        //指数变化
        $tmp = $this->db->select("`gameid` = '$gameid' AND " . $where, '`big`,`small`,`total`,`oddsdate`,`companyid`', '', '`oddsdate` DESC');

        //合并
        foreach ($tmp as $r) {
            $odds_all[$r['oddsdate']][$r['companyid']] = $r;
        }
        unset($tmp);

        include template('sportsdata', 'ft_game_odds_ou');
    }

    //实况直播
    public function game_live()
    {
        if (isset($_REQUEST['gameid']) && !empty($_REQUEST['gameid'])) {
            $gameid = intval($_REQUEST['gameid']);
        } else {
            showmessage('比赛ID不正确');
        }

        //基本信息
        $gameinfo = $this->_gameinfo($gameid);
        //seo
        $SEO['title'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队_实况图文直播-399彩迷网';
        $SEO['keyword'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队，实况图文直播';
        $SEO['description'] = '399彩迷网提供实时的足球比赛,实况直播,实况足球,足球比赛文字直播，让您即时在线看足球比分。';

        $tag_stat = 1;

        //状态
        $arr_status = $this->arr_status;

        include template('sportsdata', 'ft_game_live');
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

    /**
     * 球队详情
     */
    public function team()
    {
        if (! $_GET['teamid']) {
            showmessage(L('team_not_exists'), 'blank');
        }
        $teamid = $_GET['teamid'];
        $siteid = $GLOBALS['siteid'] = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
        define('SITEID', $siteid);
        $sitelist  = getcache('sitelist','commons');
        $default_style = $sitelist[$siteid]['default_style'];

        //数据库
        $this->db = pc_base::load_model("team_model");

        //球队信息
        $team_info = $this->db->get_one("`teamid`=" . $teamid);
        //seo
        $SEO['title'] = $team_info['name'] . '球队详细数据资料信息—399彩迷';
        $SEO['keyword'] = $team_info['name'] . '球队';
        $SEO['description'] = '399彩迷为您提供最全最详细的' . $team_info['name'] . '球队资料,球队数据，包括联赛数据,球队球员信息等相关数据资料。';

        //如果没有数据库没有球队信息抛出提示
//        if (!$team_info) {
//            showmessage(L('team_not_exists'), 'blank');
//        }

        $full_name = $team_info['name'] . ($team_info['enname'] ? "(" . $team_info['enname'] . ")" : "");
        $short_name = $team_info['shortname'] ? $team_info['shortname'] : $team_info['name'];
        $players = json_decode($team_info['players'], true);
        $coaches = json_decode($team_info['coaches'], true);

        $temp = array();
        if (count($players)) {
            //按位置重组数据
            foreach ($players as $player) {
                $temp['players'][$player['Position']][] = $player;
            }
            $players = $temp['players'];
        }

        //球队历史统计、未来赛程
        $this->db->table_name = "ft_team_stats";
        $team_stats = $this->db->get_one('`teamid`=' . $teamid);

        $temp['stats'] = json_decode($team_stats['stats'], true);
        $temp['fixtures'] = json_decode($team_stats['fixtures'], true);
        $temp['histories'] = json_decode($team_stats['historys'], true);
        $stats = $fixtures = array();

        //以往战绩
        if (count($temp['histories'])) {
            $histories = array();
            $total = array(
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
            foreach ($temp['histories'] as $history) {
                //重组数据
                list($row['gameid'], $row['competitionid'], $row['hometeamid'], $row['awayteamid']) = $history['Id'];
                list($row['homescore'], $row['awayscore']) = $history['Score'];
                $row['half'] = $history['Half'];
                $row['result'] = $row['hometeamid'] == $teamid ? get_result($row['homescore'], $row['awayscore']) : get_result($row['awayscore'], $row['homescore']);
                $row['plate'] = get_plate($row['homescore'], $row['awayscore'], $history['Handicap']);
                $row['size'] = score_size($row['homescore'], $row['awayscore']);
                $row['half_size'] = score_size($row['homescore'], $row['awayscore'], 1);
                $row['single_double'] = single_double($row['homescore'], $row['awayscore']);
                $row['handicap'] = get_handicap($history['Handicap']);
                $row['date'] = date('Y-m-d', floor($history['Date'] / 1000));
                $histories[$row['gameid']] = $row;
                $temp['team_ids'][] = $row['hometeamid'];
                $temp['team_ids'][] = $row['awayteamid'];
                $temp['competition_ids'][] = $row['competitionid'];
                $join_competition[] = $row['competitionid'];
                //总合计
                if ($teamid == $row['hometeamid']) {    //作为主队
                    if ($row['neutral']) {
                        //中立场
                        $total['neutral_' . get_result($row['homescore'], $row['awayscore'])] += 1;
                    } else {
                        $total['home_' . get_result($row['homescore'], $row['awayscore'])] += 1;
                    }
                } else {    //作为客队
                    if ($row['neutral']) {
                        //中立场
                        $total['neutral_' . get_result($row['awayscore'], $row['homescore'])] += 1;
                    } else {
                        $total['away_' . get_result($row['awayscore'], $row['homescore'])] += 1;
                    }
                }
            }
            $join_competition = array_unique($join_competition);
            //统计比例
            $temp['histories_sum'] = count($temp['histories']);
            $total['win'] = $total['home_win'] + $total['away_win'] + $total['neutral_win'];
            $total['equal'] = $total['home_equal'] + $total['away_equal'] + $total['neutral_equal'];
            $total['lose'] = $total['home_lose'] + $total['away_lose'] + $total['neutral_lose'];
        }

        //总进球
        $stats['total_goal'] = $temp['stats']['TotalGoal'];
        //进球数统计
        if (count($temp['stats']['Goal'])) {
            foreach ($temp['stats']['Goal'] as $key => $value) {
                $stats['goal'][strtolower($key)] = stats_rate($value);
            }
        }
        //盘路统计
        if (count($temp['stats']['Odds'])) {
            foreach ($temp['stats']['Odds'] as $key => $value) {
                $stats['odds'][strtolower($key)] = stats_rate($value);
            }
        }
        //未来赛程
        if (count($temp['fixtures'])) {
            foreach ($temp['fixtures'] as $value) {
                if (count($fixtures) >= 6) {
                    break;
                }
                //球队编号
                $temp['team_ids'][] = $value['Id'][2];
                $temp['team_ids'][] = $value['Id'][3];
                //联赛编号
                $temp['competition_ids'][] = $value['Id'][1];
                //重组数据
                $row = array();
                $row['gameid'] = $value['Id'][0];
                $row['competitionid'] = $value['Id'][1];
                $row['date'] = date('Y-m-d H:i', floor($value['Date'] / 1000));
                $row['hometeamid'] = $value['Id'][2];
                $row['awayteamid'] = $value['Id'][3];
                $fixtures[] = $row;
            }

            //未来赛程中使用的球队，联赛
            $temp['team_ids'] = array_unique($temp['team_ids']);
            $temp['competition_ids'] = array_unique($temp['competition_ids']);
            $this->db->table_name = 'ft_team';
            $team_list = $this->db->select('`teamid` IN (' . join(',', $temp['team_ids']) . ')', '`teamid`,if(`shortname`<>"",`shortname`,`name`) as `name`', '', '', '', 'teamid');

            $this->db->table_name = 'ft_competition';
            $competition_list = $this->db->select('`competitionid` IN (' . join(',', $temp['competition_ids']) .')', '`competitionid`,if(`shortname`<>"",`shortname`,`name`) as `name`,`color`', '', '', '', 'competitionid');
        }

        include template("sportsdata", "ft_team", $default_style);
    }

    //球员详情
    public function player()
    {
        $playerid = (int)$_GET['playerid'];

        //球员信息
        $player_db = pc_base::load_model('player_model');
        $player_info = $player_db->get_one(['playerid' => $playerid]);

//        if (!$player_info) {
//           showmessage(L('player_not_exists'));
//        }
        //seo
        $SEO['title'] = $player_info['name'] . '球员详细数据资料信息-399彩迷';
        $SEO['keyword'] = $player_info['name'] . '球员';
        $SEO['description'] = '399彩迷为您提供最全最详细的' . $player_info['name'] . '球员资料,球员数据，包括球员联赛数据等相关资料。';

        $player_info['photo'] = PHOTO_PATH . 'player/' . $playerid . '.jpg';

        #--------------------效力球队、队友---------------------
        $team_info = $this->team_db->get_one(['name' => $player_info['club']]);

//        if (!$team_info) {
//            showmessage(L('team_not_exists'));
//        }

        $team_info['players'] = json_decode($team_info['players'], true);

        $players_info = [];
        foreach ($team_info['players'] as $r) {
            $players_info[$r['Position']][] = [
                'playerid' => $r['Id'],
                'name' => $r['Name'],
                'photo' => PHOTO_PATH . 'player/' . $r['Id'] . '.jpg'
            ];
        }

        #--------------------曾经效力的球队---------------------
        $onceclub_arr = explode(',', str_replace(['[租借]'], '', $player_info['onceclub']));
        $onceclub_arr[] = $player_info['club'];

        $where = to_sqls($onceclub_arr, '', '`name`');
        $teams_info = $this->team_db->select($where, '`teamid`,`name`');

        foreach ($teams_info as &$r) {
            $r['photo'] = PHOTO_PATH . 'team/' . $r['teamid'] . '.jpg';
        }
        unset($r);

        #--------------------个人近两年比赛数据统计---------------------
        $stats_db = pc_base::load_model('player_stats_model');
        $stats_info = $stats_db->select(['playerid' => $playerid], '*', '', '`date` DESC');

        include template('sportsdata', 'ft_player');
    }

    /*
     * 获取联赛信息   add by lxt 2016.08.16
     * 参数：competitionid 联赛编号；
     *       default_where 搜索条件，默认是联赛编号；
     *       default_field 查询字段，默认是联赛简称；
     */
    private function _competition_info($competitionid, $default_field = '`shortname`', $default_where = false)
    {
        if ($competitionid) {
            $this->db->table_name = 'ft_competition';
            $where = $default_where ? $default_where : '`competitionid`=' . $competitionid;
            $field = $default_field ? $default_field : '`shortname`';
            $competition = $this->db->get_one($where, $field);
            return $competition;
        }

        return false;
    }

    /**
     * 获取赛事区域和赛区所有赛事
     */
    private function _competition_all()
    {
        //全部赛事
        $competittion_sql = "SELECT `eventid` AS `competitionid`,
                                    `eventname` AS `competitionname`,
                                    `zonename`,
                                    `zoneid`
                            FROM ft_event;";

        $this->db->query($competittion_sql);
        $temp = $this->db->fetch_array();
        foreach ($temp as $row) {
            if (!isset($competition_list[$row['zoneid']])) {
                $competition_list[$row['zoneid']] = $row['zonename'];
            }
            $competition_info[$row['zoneid']][] = $row;
        }
        return array($competition_list, $competition_info);
    }

    //异步获取即时比分
    public function ajax_live_game_data()
    {
        if ($_POST['gameids']) {
            $state = true;
            $where = 'a.gameid IN (' . join(',', $_POST['gameids']) . ')';
            $model = pc_base::load_model('live_game_data_model');
            //比赛状态数组
            $status_list = $this->arr_status;
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
                        $value['time'] = $time > 45 ? '45+' : $time;
                        $value['state_tag'] = true;
                        $value['run_tag'] = true;
                        break;
                    case 3:
                        //下半场如果超过90分钟，改为显示90+
                        $time = $value['tstarttime'] ? ceil((45 * 60 + time() - $value['tstarttime']) / 60) : ceil((time() - $value['date']) / 60);
                        $value['time'] = $time > 90 ? '90+' : $time;
                        $value['state_tag'] = true;
                        $value['run_tag'] = true;
                        break;
                    default:
                        //完场比赛标志
                        if (in_array($value['status'], array(4, 10))) {
                            $value['is_over'] = true;
                        }
                        //其他状态直接显示，不计算时间
                        $value['time'] = array_key_exists($value['status'], $status_list) ? $status_list[$value['status']] : '';
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

    /*
     * 异步亚盘，欧赔，大小球
     * 参数: 1.gameids 必须，比赛编号；
     *       2.companyid 非必须，公司编号，默认S2公司；
     *       3.first 非必须，是否只带初盘数据，用来更新为开赛的赛事数据；
     */
    public function ajax_odds()
    {
        if ($_POST['gameids']) {
            $state = true;
            $where = '`gameid` IN (' . join(',', $_POST['gameids']) . ')';
            $model = pc_base::load_model('odds_asia_model');
            $info = array();
            //亚盘公司，默认S2
            $companyid = $_POST['companyid'] ? $_POST['companyid'] : 400000;
            //欧赔指数
            $asia2euro = asia2euro();
            $euro_companyid = $asia2euro[$companyid];
            //亚盘
            $asia_field = $_POST['first'] ? '`gameid`,`fup` AS `up`,`fdown` AS `down`,`fgive` AS `give`' : '`gameid`,`up`,`down`,`give`,`isrun`,`fup`,`fdown`,`fgive`';
            $asia_info = $model->select($where . ' AND `companyid`=' . $companyid, $asia_field, '', '', '', 'gameid');
            //欧指
            $model->table_name = 'ft_odds_euro';
            $euro_field = $_POST['first'] ? '`gameid`,`fhomewin` AS `homewin`,`fawaywin` AS `awaywin`,`fdraw` AS `draw`' : '`gameid`,`homewin`,`draw`,`awaywin`,`fhomewin`,`fdraw`,`fawaywin`';
            $euro_info = $model->select($where . ' AND `companyid`=' . $euro_companyid, $euro_field, '', '', '', 'gameid');
            //大小球
            $model->table_name = 'ft_odds_ou';
            $ou_field = $_POST['first'] ? '`gameid`,`fbig` AS `big`,`fsmall` AS `small`,`ftotal` AS `total`' : '`gameid`,`big`,`small`,`total`,`fbig`,`fsmall`,`ftotal`';
            $ou_info = $model->select($where . ' AND `companyid`=' . $companyid, $ou_field, '', '', '', 'gameid');

            //合并亚盘数据
            if(!empty($asia_info)){
                foreach($asia_info as $id => $odds){
                    //让球转换语言包
                    if ($odds['give']) {
                        $odds['handicap'] = get_handicap($odds['give']);
                    }
                    if ($odds['fgive']) {
                        $odds['fhandicap'] = get_handicap($odds['fgive']);
                    }
                    //让球变化
                    if (isset($odds['give']) && isset($odds['fgive'])) {
                        $odds['handicap_change'] = $odds['give'] - $odds['fgive'];
                    }
                    //上盘变化
                    if (isset($odds['up']) && isset($odds['fup'])) {
                        $odds['up_change'] = $odds['up'] - $odds['fup'];
                    }
                    //下盘变化
                    if (isset($odds['down']) && isset($odds['fdown'])) {
                        $odds['down_change'] = $odds['down'] - $odds['fdown'];
                    }
                    $info[$id]['asia'] = $odds;
                }
            }
            //合并大小球数据
            if(!empty($ou_info)){
                foreach($ou_info as $id => $odds){
                    //大球变化
                    if (isset($odds['big']) && isset($odds['fbig'])) {
                        $odds['big_change'] = $odds['big'] - $odds['fbig'];
                    }
                    //小球变化
                    if (isset($odds['small']) && isset($odds['fsmall'])) {
                        $odds['small_change'] = $odds['small'] - $odds['fsmall'];
                    }
                    //总变化
                    if (isset($odds['total']) && isset($odds['ftotal'])) {
                        $odds['total_ou_change'] = $odds['total'] - $odds['ftotal'];
                    }
                    //总语言包转换
                    $odds['total_ou'] = handicap_ou($odds['total']);
                    if (isset($odds['ftotal'])) {
                        $odds['ftotal_ou'] = handicap_ou($odds['ftotal']);
                    }
                    $info[$id]['ou'] = array_map('rtrim0', $odds);
                }
            }
            //合并欧指数据
            if(!empty($euro_info)){
                foreach($euro_info as $id => $odds){
                    //主胜变化
                    if (isset($odds['homewin']) && isset($odds['fhomewin'])) {
                        $odds['homewin_change'] = $odds['homewin'] - $odds['fhomewin'];
                    }
                    //客胜变化
                    if (isset($odds['awaywin']) && isset($odds['fawaywin'])) {
                        $odds['awaywin_change'] = $odds['awaywin'] - $odds['fawaywin'];
                    }
                    //平变化
                    if (isset($odds['draw']) && isset($odds['fdraw'])) {
                        $odds['draw_change'] = $odds['draw'] - $odds['fdraw'];
                    }
                    $info[$id]['euro'] = $odds;
                }
            }

            //保证数据格式完整
            foreach ($info as &$row) {
                $value_arr = array_pad(array(), 6, ' ');
                if (!isset($row['asia'])) {
                    $key_arr = array('up', 'fup', 'down', 'fdown', 'give', 'fgive');
                    $row['asia'] = array_combine($key_arr, $value_arr);
                }
                if (!isset($row['euro'])) {
                    $key_arr = array('homewin', 'fhomewin', 'awaywin', 'fawaywin', 'draw', 'fdraw');
                    $row['euro'] = array_combine($key_arr, $value_arr);
                }
                if (!isset($row['ou'])) {
                    $key_arr = array('big', 'fbig', 'small', 'fsmall', 'total', 'ftotal');
                    $row['ou'] = array_combine($key_arr, $value_arr);
                }
                ksort($row);
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

    /**
     * 完场比分
     */
    public function end_game()
    {
        //SEO
        $SEO['title'] = '足球比分网_完场比分-399彩迷';
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

        //比赛状态
        $arr_status = $this->arr_status;

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
        foreach ($end_game as $key => $game) {
            $game['note'] = str_replace('"', '', $game['note']);
            $end_game[$game['gameid']] = $game;
            $competitions[$game['competitionid']] = $game['competitionshortname'];
            unset($end_game[$key]);
        }

        //亚指 公司S2
        $companyid = 400000;
        $game_condition = to_sqls(array_column($end_game, 'gameid'), '', 'gameid');
        $this->db->table_name = 'ft_odds_asia';
        $odds_asia = $this->db->select("1=1 AND $game_condition AND companyid = '$companyid'", '`gameid`,`give`,`isrun`', '', '', '', 'gameid');

        //合并亚指
        if (!empty($odds_asia)) {
            foreach ($odds_asia as $odds) {
                $end_game[$odds['gameid']]['give'] = $odds['give'];
                $end_game[$odds['gameid']]['isrun'] = $odds['isrun'];
            }
        }
        unset($odds_asia);

        //大小球
        $this->db->table_name = 'ft_odds_ou';
        $odds_ou = $this->db->select("1=1 AND $game_condition AND companyid = '$companyid'", '`gameid`,`total`', '', '', '', 'gameid');

        //合并大小球
        if (!empty($odds_ou)) {
            foreach ($odds_ou as $odds) {
                $end_game[$odds['gameid']]['total'] = $odds['total'];
            }
        }
        unset($odds_ou);

        //赛事选择
        $tmp = array_count_values(array_column($end_game, 'competitionid'));
        foreach ($tmp as $key => $value) {
            $competition_data[$key]['competitionid'] = $key;
            $competition_data[$key]['competitionshortname'] = $competitions[$key];
            $competition_data[$key]['count'] = $value;
        }
        unset($competitions);
        unset($tmp);

        include template('sportsdata', 'ft_end_game');
    }

    //未来一周赛程
    public function future_game()
    {
        //SEO
        $SEO['title'] = '足球赛事_下日比分-399彩迷';
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

        //比赛状态
        $arr_status = $this->arr_status;

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

        //比赛id作为key
        foreach ($future_game as $key => $game) {
            $game['note'] = str_replace('"', '', $game['note']);
            $future_game[$game['gameid']] = $game;
            $competitions[$game['competitionid']] = $game['competitionshortname'];
            unset($future_game[$key]);
        }

        //赛事选择
        $tmp = array_count_values(array_column($future_game, 'competitionid'));
        foreach ($tmp as $key => $value) {
            $competition_data[$key]['competitionid'] = $key;
            $competition_data[$key]['competitionshortname'] = $competitions[$key];
            $competition_data[$key]['count'] = $value;
        }
        unset($competitions);
        unset($tmp);
        include template('sportsdata', 'ft_future_game');
    }

    /**
     * 比赛数据统计
     */
    public function game_stats()
    {
        if (! $_GET['gameid']) {
            showmessage(L('game_not_exists'),'blank');
        }

        //比赛信息
        $gameid = $_GET['gameid'];
        $gameinfo = $this->_gameinfo($gameid);
        //seo
        $SEO['title'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队_技术统计-399彩迷网';
        $SEO['keyword'] = $gameinfo['homename'] . '队 VS ' . $gameinfo['awayname'] . '队，球赛技术统计';
        $SEO['description'] = '399彩迷网提供最全的球赛技术统计,足球数据统计，足球比分直播,足球动画比分直播上399彩迷网观看。';

        $tag_stat = 1;

        //双方阵容
        $forecast_model = pc_base::load_model('game_forecast_model');
        $lineup = $forecast_model->lineup($gameid);

        //数据统计
        $goal_stats_model = pc_base::load_model('live_game_goal_stats_model');
        $stat_info = $goal_stats_model->stat_info($gameid);
        //换人统计
        $substitution_info = $goal_stats_model->substitution_info();
        //事件统计
        $goal_info = $goal_stats_model->goal_info();

        if ($lineup) {
            //将事件绑定到球员上
            if ($goal_info) {
                foreach ($goal_info as $row) {
                    $type = $row['Type'] == 1 ? 'home' : 'away';
                    //首发
                    if (isset($lineup[$type]['starter'][$row['Pid']])) {
                        $lineup[$type]['starter'][$row['Pid']]['Event'] = $row['Class'];
                    }
                    //替补
                    if (isset($lineup[$type]['reserve'][$row['Pid']])) {
                        $lineup[$type]['reserve'][$row['Pid']]['Event'] = $row['Class'];
                    }
                }
            }
            //将换人绑定到球员上
            if ($substitution_info) {
                $substitution_players = array();
                foreach ($substitution_info as $row) {
                    $up = array(
                        'Type' => $row['Type'],
                        'Id' => $row['Upid'],
                        'Class' => 'substitute'
                    );
                    $down = array(
                        'Type' => $row['Type'],
                        'Id' => $row['Downid'],
                        'Class' => 'substitute'
                    );
                    $substitution_players[] = $up;
                    $substitution_players[] = $down;
                }

                foreach ($substitution_players as $row) {
                    $type = $row['Type'] == 1 ? 'home' : 'away';
                    //首发
                    if (isset($lineup[$type]['starter'][$row['Id']])) {
                        $lineup[$type]['starter'][$row['Id']]['Substitution'] = $row['Class'];
                    }
                    //替补
                    if (isset($lineup[$type]['reserve'][$row['Id']])) {
                        $lineup[$type]['reserve'][$row['Id']]['Substitution'] = $row['Class'];
                    }
                }
            }
        }

        //统计角球和开球
        if ($stat_info) {
            foreach ($stat_info as $row) {
                if ($row['Name'] == '角球次数') {
                    $corner = array(
                        'home' => $row['Home'],
                        'away' => $row['Away']
                    );
                }
                if ($row['Name'] == '开球') {
                    $open = $row['Home'] ? $gameinfo['homename'] : $gameinfo['awayname'];
                }
            }
        }

        //进球时间统计
        $goal_time_stats_model = pc_base::load_model('goaltime_stats_model');
        if ($gameinfo) {
            $goal_time_stats_info = $goal_time_stats_model->goal_time_stats($gameinfo['competitionid'], array($gameinfo['hometeamid'], $gameinfo['awayteamid']));
            //保证主队在左，客队在右
            $goal_time_stats_info = array(
                $gameinfo['homename'] => $goal_time_stats_info[$gameinfo['hometeamid']],
                $gameinfo['awayname'] => $goal_time_stats_info[$gameinfo['awayteamid']]
            );
        }

        //半场落后追回统计
        $game_model = pc_base::load_model('game_model');
        if ($gameinfo) {
            $anti_kill = $game_model->anti_kill($gameinfo['hometeamid'], $gameinfo['awayteamid']);
        }

        include template('sportsdata', 'ft_game_stats');
    }

    /**
     * 异步更新数据统计页面的事件、换人统计
     * 参数：1.gameid    比赛编号，必须
     *       2.minute    最后事件时间，非必须，默认0，用来过滤事件
     *       3.type      类型，必须，1 => 事件统计；2 => 换人统计
     */
    public function ajax_goal_stats_info()
    {
        $state = false;

        if ($_POST['gameid'] && $_POST['type']) {
            $gameid = $_POST['gameid'];
            $minute = $_POST['minute'] ? intval($_POST['minute']) : 0;
            $type = $_POST['type'];

            //比赛基本信息
            $gameinfo = $this->_gameinfo($gameid);

            //事件统计
            $model = pc_base::load_model('live_game_goal_stats_model');
            $goal_info = $type == 1 ? $model->goal_info($gameid) : $model->substitution_info($gameid);

            //过滤数据
            if ($goal_info) {
                $data = array();
                foreach ($goal_info as $row) {
                    //只获取传递过来的时间之后的数据
                    if (intval($row['Minute']) > $minute) {
                        $data[] = $row;
                        $state = true;
                    }
                }
            }
        }

        $result = array(
            'state' => $state,
            'data' => isset($data) ? $data : '',
            'game_info' => isset($gameinfo) ? array(
                'status' => in_array($gameinfo['status'], array(1, 2, 3)) ? true : false,
                'home_score' => $gameinfo['homescore'],
                'away_score' => $gameinfo['awayscore']
            ) : ''
        );

        exit(json_encode($result));
    }


    /*
     * 异步更新数据统计页面的数据统计
     */
    public function ajax_stat_info()
    {
        $state = false;

        if ($_POST['gameid']) {
            $gameid = $_POST['gameid'];

            //比赛基本信息
            $gameinfo = $this->_gameinfo($gameid);

            //数据统计
            $model = pc_base::load_model('live_game_goal_stats_model');
            $stat_info = $model->stat_info($gameid);
        }

        $result = array(
            'state' => $stat_info ? true : false,
            'data' => $stat_info,
            'status' => in_array($gameinfo['status'], array(1, 2, 3)) ? true : false
        );

        exit(json_encode($result));
    }

    //亚指
    public function odds_asia()
    {
        list($arr_status, $option_cid, $companies, $odds_status, $date, $date_text, $live_games) = $this->_odds_prework();

        $SEO['title'] = '亚盘指数-' . $this->odds_status_arr[$odds_status] . '-399彩迷';
        $SEO['keyword'] = '亚盘';
        $SEO['description'] = '399彩迷网作为足球指数中心，为彩民提供足球盘口、足球赔率数据，供足球欧赔、亚盘、大小球、即时盘口分析查询等数据';

        $company_condition = to_sqls($option_cid, '', 'companyid');
        $game_condition = to_sqls(array_column($live_games, 'gameid'), '', 'gameid');

        $asia_sql = "SELECT
                      companyid,
                      companyname,
                      gameid,
                      up,
                      down,
                      give,
                      fup,
                      fgive,
                      fdown
                    FROM ft_odds_asia
                    WHERE 1=1 AND $game_condition AND $company_condition
                    GROUP BY gameid, companyid
                    ORDER BY oddsdate ASC";
        $this->db->query($asia_sql);
        $odds_asia = $this->db->fetch_array();

        if (!empty($odds_asia)) {
            foreach ($odds_asia as $odds) {
                $live_games[$odds['gameid']]['odds'][$odds['companyid']] = $odds;
            }
        }

        //如果某场比赛无亚指，则删除它
        foreach ($live_games as $key => $game) {
            if (!isset($game['odds'])) {
                unset($live_games[$key]);
            }
        }

        //添加亚指公司
        $cid2cname = cid2cname();
        foreach ($live_games as $gameid => $game) {
            if (count($game['odds']) < count($option_cid)) {
                $diff = array_diff($option_cid, array_keys($game['odds']));
                foreach ($diff as $cid) {
                    $live_games[$gameid]['odds'][$cid]['companyid'] = $cid;
                    $live_games[$gameid]['odds'][$cid]['companyname'] = $cid2cname[$cid];
                    $live_games[$gameid]['odds'][$cid]['gameid'] = $gameid;
                }
            }
        }

        //按公司编号排序
        foreach ($live_games as $key => $game) {
            ksort($live_games[$key]['odds']);
            $competitions[$game['competitionid']] = $game['competitionshortname'];
        }

        include template('sportsdata', 'ft_odds_asia');
    }

    //大小对比
    public function odds_ou()
    {
        list($arr_status, $option_cid, $companies, $odds_status, $date, $date_text, $live_games) = $this->_odds_prework();

        $SEO['title'] = '大小球-' . $this->odds_status_arr[$odds_status] . '-399彩迷';
        $SEO['keyword'] = '大小球';
        $SEO['description'] = '399彩迷网作为足球指数中心，为彩民提供足球盘口、足球赔率数据，供足球欧赔、亚盘、大小球、即时盘口分析查询等数据';

        $company_condition = to_sqls($option_cid, '', 'companyid');
        $game_condition = to_sqls(array_column($live_games, 'gameid'), '', 'gameid');
        $ou_sql = "SELECT
                      companyid,
                      companyname,
                      gameid,
                      big,
                      total,
                      small,
                      fbig,
                      ftotal,
                      fsmall
                    FROM ft_odds_ou
                    WHERE 1=1 AND $game_condition AND $company_condition
                    GROUP BY gameid, companyid
                    ORDER BY oddsdate ASC";
        $this->db->query($ou_sql);
        $odds_ou = $this->db->fetch_array();

        if (!empty($odds_ou)) {
            foreach ($odds_ou as $odds) {
                $live_games[$odds['gameid']]['odds'][$odds['companyid']] = $odds;
            }
        }

        //如果某场比赛无大小指数，则删除它
        foreach ($live_games as $key => $game) {
            if (!isset($game['odds'])) {
                unset($live_games[$key]);
            }
        }

        //添加大小指数公司
        $cid2cname = cid2cname();
        foreach ($live_games as $gameid => $game) {
            if (count($game['odds']) < count($option_cid)) {
                $diff = array_diff($option_cid, array_keys($game['odds']));
                foreach ($diff as $cid) {
                    $live_games[$gameid]['odds'][$cid]['companyid'] = $cid;
                    $live_games[$gameid]['odds'][$cid]['companyname'] = $cid2cname[$cid];
                    $live_games[$gameid]['odds'][$cid]['gameid'] = $gameid;
                }
            }
        }

        //按公司编号排序
        foreach ($live_games as $key => $game) {
            ksort($live_games[$key]['odds']);
            $competitions[$game['competitionid']] = $game['competitionshortname'];
        }

        include template('sportsdata', 'ft_odds_ou');
    }

    //欧赔
    public function odds_euro()
    {
        list($arr_status, $option_cid, $companies, $odds_status, $date, $date_text, $live_games) = $this->_odds_prework();

        $SEO['title'] = '百家欧赔-' . $this->odds_status_arr[$odds_status] . '-399彩迷';
        $SEO['keyword'] = '欧赔,百家欧赔';
        $SEO['description'] = '399彩迷网作为足球指数中心，为彩民提供足球盘口、足球赔率数据，供足球欧赔、亚盘、大小球、即时盘口分析查询等数据';

        $game_condition = to_sqls(array_column($live_games, 'gameid'), '', 'gameid');
        $aisa2euro = asia2euro();               //亚指公司映射到欧指公司
        $euro2asia = array_flip($aisa2euro);    //欧指公司映射到亚指公司
        $cid2cname = cid2cname();               //亚指公司编号映射到公司名

        //获取对应的欧指公司的$euro_company_condition
        $euro_option_cid = array();
        foreach ($option_cid as $cid) {
            $euro_option_cid[] = $aisa2euro[$cid];
        }
        $euro_company_condition = to_sqls($euro_option_cid, '', 'companyid');

        $euro_sql = "SELECT
                      companyid,
                      companyname,
                      gameid,
                      homewin,
                      draw,
                      awaywin,
                      returnrate,
                      fhomewin,
                      fdraw,
                      fawaywin
                    FROM ft_odds_euro
                    WHERE 1=1 AND $game_condition AND $euro_company_condition
                    GROUP BY gameid, companyid
                    ORDER BY oddsdate ASC";
        $this->db->query($euro_sql);
        $odds_euro = $this->db->fetch_array();

        if (!empty($odds_euro)) {
            foreach ($odds_euro as $odds) {
                $cid = $euro2asia[$odds['companyid']];
                $live_games[$odds['gameid']]['odds'][$cid]['companyid'] = $cid;
                $live_games[$odds['gameid']]['odds'][$cid]['companyname'] = $cid2cname[$cid];
                $live_games[$odds['gameid']]['odds'][$cid]['gameid'] = $odds['gameid'];
                $live_games[$odds['gameid']]['odds'][$cid]['homewin'] = $odds['homewin'];
                $live_games[$odds['gameid']]['odds'][$cid]['draw'] = $odds['draw'];
                $live_games[$odds['gameid']]['odds'][$cid]['awaywin'] = $odds['awaywin'];
                $live_games[$odds['gameid']]['odds'][$cid]['returnrate'] = $odds['returnrate'];
                $live_games[$odds['gameid']]['odds'][$cid]['fhomewin'] = $odds['fhomewin'];
                $live_games[$odds['gameid']]['odds'][$cid]['fdraw'] = $odds['fdraw'];
                $live_games[$odds['gameid']]['odds'][$cid]['fawaywin'] = $odds['fawaywin'];
            }
        }

        //如果某场比赛无欧赔指数，则删除它
        foreach ($live_games as $key => $game) {
            if (!isset($game['odds'])) {
                unset($live_games[$key]);
            }
        }

        //添加欧指公司
        foreach ($live_games as $gameid => $game) {
            if (count($game['odds']) < count($option_cid)) {
                $diff = array_diff($option_cid, array_keys($game['odds']));
                foreach ($diff as $cid) {
                    $live_games[$gameid]['odds'][$cid]['companyid'] = $cid;
                    $live_games[$gameid]['odds'][$cid]['companyname'] = $cid2cname[$cid];
                    $live_games[$gameid]['odds'][$cid]['gameid'] = $gameid;
                }
            }
        }

        //按公司编号排序
        foreach ($live_games as $key => $game) {
            ksort($live_games[$key]['odds']);
            $competitions[$game['competitionid']] = $game['competitionshortname'];
        }

        include template('sportsdata', 'ft_odds_euro');
    }

    private function _odds_prework()
    {
        //比赛状态数组
        $arr_status = $this->arr_status;
        //指数公司条件
        list($option_cid, $companies) = $this->_odds_company();
        //指数状态、日期、日期文本、where
        list($odds_status, $date, $date_text, $where) = $this->_odds_status();
        //即时比分赛事
        $live_games = $this->_odds_live_game($where);
        return array($arr_status, $option_cid, $companies, $odds_status, $date, $date_text, $live_games);
    }

    private function _odds_company()
    {
        //指数公司条件
        if (isset($_POST['dosubmit']) && !empty($_POST['companyid'])) {
            $option_cid = $_POST['companyid'];
        } else {
            //默认指数公司
            $option_cid = array(
                3000271, //10Bet
                3000181, //Bet365
                400000   //S2
            );
        }
        //全部亚指公司
        $this->db->table_name = 'ft_company';
        $companies = $this->db->select("`area`='亚指公司'", '`companyid`,`name` companyname', '', '`companyid` ASC');
        //添加checked
        foreach ($companies as $key => $c) {
            if (in_array($c['companyid'], $option_cid)) {
                $companies[$key]['checked'] = true;
            }
        }
        return array($option_cid, $companies);
    }

    private function _odds_status()
    {
        $starttime = SYS_TIME - 2 * 60 * 60; //开始时间
        $endtime = SYS_TIME + 36 * 60 * 60;  //结束时间
        //指数状态(1即时指数；2已开赛；3历史；4早盘)
        $odds_status = isset($_REQUEST['odds_status']) ? intval($_REQUEST['odds_status']) : 1;
        //日期条件(3历史；4早盘)
        $date = isset($_POST['date']) ? $_POST['date'] : ($odds_status == 3 ? date('Y-m-d', SYS_TIME - 24*60*60) : date('Y-m-d'));
        //日期文本
        $week = array(1 => '一', 2 => '二', 3 => '三', 4 => '四', 5 => '五', 6 => '六', 7 => '天');
        $date_text = date('Y年n月j日', strtotime($date)) . '(星期.' . $week[date('N', strtotime($date))] . ')';
        $where = 'WHERE 1=1';
        switch ($odds_status) {
            //即时指数
            case 1:
                $where .= " AND g.date > '$starttime' AND g.date < '$endtime'";
                break;
            //已开赛
            case 2:
                $where .= " AND g.date > '$starttime' AND g.date < '$endtime'".
                    " AND d.status IN(1, 2, 3, 4)";
                break;
            //历史
            case 3:
                $where .= " AND g.date > '".strtotime("$date 00:00:00")."' AND g.date < '".strtotime("$date 23:59:59")."'";
                break;
            //早盘
            case 4:
                $where .= " AND d.status IS NULL ";
                if (isset($_POST['date'])) {
                    $where .= " AND g.date > '".strtotime("$date 00:00:00")."' AND g.date < '".strtotime("$date 23:59:59")."'";
                } else {
                    $where .= " AND g.date > '$starttime' AND g.date < '$endtime'";
                }
                break;
            default:
                break;
        }
        return array($odds_status, $date, $date_text, $where);
    }

    private function _odds_live_game($where)
    {
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
        return $live_games;
    }

    /**
     * 异步获取即时比分事件统计(如:进球、红牌、黄牌等)
     * 参数：1.gameid    比赛编号，必须
     *       2.minute    最后事件时间，非必须，默认0，用来过滤事件
     */
    public function ajax_event_stats()
    {
        $state = false;

        if ($_POST['gameid'] && $_POST['companyid']) {
            $gameid = $_POST['gameid'];
            $companyid = $_POST['companyid'];

            //亚盘初盘
            $this->db->table_name = 'ft_odds_asia';
            $odds = $this->db->get_one("`gameid`='$gameid' AND `companyid`='$companyid'", '`fgive`', '`oddsdate` DESC');

            //事件统计
            $model = pc_base::load_model('live_game_goal_stats_model');
            $events = $model->events($gameid);

            //过滤数据
            if ($events) {
                $state = true;
                foreach ($events as $row) {
                    $data[] = $row;
                }
            }
        }

        $result = array(
            'state' => $state,
            'fhandicap' => $odds ? get_handicap($odds['fgive']) : '',
            'data' => isset($data) ? $data : ''
        );

        exit(json_encode($result));
    }

    /**
     * 预测赛事、过往战绩
     * 功能：盘路，进球统计，排名统计，单双统计，未来赛程保留预测赛事部分、近两年战绩保留过往战绩部分
     */
    public function game_data()
    {
        if (! $_GET['gameid']) {
            showmessage(L('game_not_exists'),'blank');
        }
        $gameid = $_GET['gameid'];
        $where = "gameid=" . $gameid;
        $siteid = $GLOBALS['siteid'] = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
        define('SITEID', $siteid);
        $sitelist  = getcache('sitelist','commons');
        $default_style = $sitelist[$siteid]['default_style'];

        //SEO
        $SEO = seo($siteid);

        //当场比赛
        $gameinfo = $this->_gameinfo($gameid);
        //比赛状态数组
        $arr_status = $this->arr_status;
        //比赛预测
        if(!empty($gameinfo))
        {
            $this->db = pc_base::load_model('game_forecast_model');
            $forecast_where ="gameid ={$gameid}";
            $forecast_data=$this->db->get_one($forecast_where,"homeplayers, awayplayers, homerecenttendency, awayrecenttendency, homeoddswinlose, awayoddswinlose, confidence, resultsofthematch, content");
            $forecast_data['homerecenttendency'] = $this->db->value_replace($forecast_data['homerecenttendency']);
            $forecast_data['awayrecenttendency'] = $this->db->value_replace($forecast_data['awayrecenttendency']);
            $forecast_data['homeoddswinlose'] = $this->db->value_replace($forecast_data['homeoddswinlose']);
            $forecast_data['awayoddswinlose'] = $this->db->value_replace($forecast_data['awayoddswinlose']);
        }


        $this->db = pc_base::load_model('game_stats_model');
        $ranking_sql ="select * from ft_game_stats where gameid={$gameid}";
        $ranking_rel=$this->db->query($ranking_sql);
        $ranking_data=$this->db->fetch_array($ranking_rel);
        //联赛
        $league_datas=$this->db->object_to_array(json_decode($ranking_data[0]['competition']));
        //球队
        $team_datas=$this->db->object_to_array(json_decode($ranking_data[0]['team']));
        //排名统计
        $ranking_datas=$this->db->object_to_array(json_decode($ranking_data[0]['standings']));

        //进球单双统计
        $ds_datas=$this->db->object_to_array(json_decode($ranking_data[0]['teamstats']));
        $ds_home=$ds_datas['Home']['TotalGoal'];
        $ds_away=$ds_datas['Away']['TotalGoal'];
        //进球统计
        $goal_home=$ds_datas['Home']['Goal'];
        $goal_away=$ds_datas['Away']['Goal'];
        //盘路统计
        $plate_home=$ds_datas['Home']['Odds'];
        $plate_away=$ds_datas['Away']['Odds'];
        //未来赛程
        $game_datas=$this->db->object_to_array(json_decode($ranking_data[0]['teamfixture']));
        $game_home=$game_datas['Home'];
        foreach($game_home as $game_key => $info)
        {
            $game_home[$game_key]['Date']=date('Y-m-d H:i:s', floor($info['Date'] / 1000));
        }
        $game_away=$game_datas['Away'];
        foreach($game_away as $game_key => $info)
        {
            $game_away[$game_key]['Date']=date('Y-m-d H:i:s', floor($info['Date'] / 1000));
        }
        //统计类别
        $type = array(
            'Total' => '总',
            'Home' => '主',
            'Neutral' => '中',
            'Away' => '客',
            'Last6Game' => '近六轮'
        );

        //数据库
        $this->game_db = pc_base::load_model("game_model");

        //过往战绩
        $this->game_db->table_name = "ft_game_stats";
        $stats_info = $this->game_db->get_one($where);
        //联赛信息
        $competition = json_decode($stats_info['competition'], true);
        //球队信息
        $team = json_decode($stats_info['team'], true);
        $temp = $team_stats = $meeting = $team_fixture = $team_history = $total = $competition_list = array();

        //交锋往绩
        if (isset($stats_info['meeting'])) {
            $temp['meeting'] = json_decode($stats_info['meeting'], true);
            $total = array(
                'win' => 0,
                'equal' => 0,
                'lose' => 0,
                'big' => 0,
                'little' => 0,
                'win_plate' => 0,
                'waste_plate' => 0,
                'lose_plate' => 0,
                'goal' => 0,
                'lost' => 0
            );
            foreach ($temp['meeting'] as $data) {
                $row = array();
                $game_home_score = $gameinfo['hometeamid'] == $data['Id'][2] ? $data['Score'][0] : $data['Score'][1];  //统计以game_info中的主队为主
                $game_away_score = $gameinfo['awayteamid'] == $data['Id'][3] ? $data['Score'][1] : $data['Score'][0];  //统计以game_info的主队为主
                $row['gameid'] = $data['Id'][0];
                $row['competitionid'] = $data['Id'][1];
                $row['competition_name'] = $competition[$data['Id'][1]]['ShortName'];
                $row['competition_color'] = $competition[$data['Id'][1]]['Color'];
                $row['date'] = date('Y-m-d', floor($data['Date'] / 1000));
                $row['hometeamid'] = $data['Id'][2];
                $row['awayteamid'] = $data['Id'][3];
                $row['homename'] = $team[$data['Id'][2]]['Name'];
                $row['homescore'] = $data['Score'][0];
                $row['awayscore'] = $data['Score'][1];
                $row['awayname'] = $team[$data['Id'][3]]['Name'];
                $row['redcard'] = join('-', $data['RedCard']);
                $row['half'] = $data['Half'];
                $row['handicap'] = get_handicap($data['Handicap']);
                $row['plate'] = get_plate($data['Score'][0], $data['Score'][1], $data['Handicap']);
                $meeting[] = $row;
                //统计
                $total[get_result($game_home_score, $game_away_score)] += 1;    //胜负
                $total[score_size($row['homescore'], $row['awayscore'])] += 1;  //大小球
                $total[$row['plate'][0] . '_plate'] += 1;                       //盘路
                $total['goal'] += $game_home_score;                             //game_info中的主队进球
                $total['lost'] += $game_away_score;                             //game_info中的主队失球
            }
        }

        //近两年战绩数据
        if (isset($stats_info['teamhistory'])) {
            $temp['team_history'] = json_decode($stats_info['teamhistory'], true);
            foreach ($temp['team_history'] as $name => $histories) {
                $category = strtolower($name);
                $tag = $_POST[$category . '_tag'] ? $_POST[$category . '_tag'] : false;
                $page = $_POST[$category . '_page'] ? $_POST[$category . '_page'] : 10;
                $filter = $_POST[$category . '_competition_id'] ? $_POST[$category . '_competition_id'] : array();
                $list_total = array(
                    'win' => 0,
                    'equal' => 0,
                    'lose' => 0,
                    'win_plate' => 0,
                    'waste_plate' => 0,
                    'lose_plate' => 0,
                    'single' => 0,
                    'double' => 0,
                    'big' => 0,
                    'little' => 0,
                    'half_big' => 0,
                    'half_little' => 0
                );
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
                    if ($gameinfo[$category . 'teamid'] == $history['Id'][2]) {    //作为主队
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
                    //联赛列表  以下过滤数据都不能使用break跳出循环，会导致联赛列表数据不足
                    $competition_list[$category][$history['Id'][1]] = $competition[$history['Id'][1]]['ShortName'];
                    //过滤非主场数据
                    if ($tag && $history['Id'][2] != $tag) {
                        continue;
                    }
                    //过滤联赛数据
                    if (count($filter) && !in_array($history['Id'][1], $filter)) {
                        continue;
                    }
                    //过滤记录条数
                    if (count($team_history[$category]) >= $page) {
                        continue;
                    }
                    //列表数据
                    $row = array();
                    $row['competitionid'] = $history['Id'][1];
                    $row['competition_name'] = $competition[$history['Id'][1]]['ShortName'];
                    $row['competition_color'] = $competition[$history['Id'][1]]['Color'];
                    $row['date'] = date('Y-m-d', $history['Date']);
                    $row['homescore'] = $history['Score'][0];
                    $row['awayscore'] = $history['Score'][1];
                    $row['result'] = get_result($history['Score']);
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
                    //列表统计
                    $list_total[$row['result']] += 1;
                    $list_total[$row['plate'][0] . '_plate'] += 1;
                    $list_total[$row['full_size']] += 1;
                    $list_total['half_' . $row['half_size']] += 1;
                    $list_total[$row['single_double']] += 1;
                }
                //列表统计比例
                $list_number = count($team_history[$category]);
                foreach ($list_total as $key => $value) {
                    if (in_array($key, array('win', 'equal', 'lose', 'win_plate', 'waste_plate', 'lose_plate'))) {
                        $list_total[$key . '_rate'] = round(($value / $list_number) * 100, 2) . "%";
                    }
                }
                $team_history['list_total'][$category] = $list_total;

                //总合计比例
                $history_total['win'] = $history_total['home_win'] + $history_total['neutral_win'] + $history_total['away_win'];        //总胜
                $history_total['equal'] = $history_total['home_equal'] + $history_total['neutral_equal'] + $history_total['away_equal'];//总平
                $history_total['lose'] = $history_total['home_lose'] + $history_total['neutral_lose'] + $history_total['away_lose'];    //总负
                $history_number = count($histories);
                foreach ($history_total as $key => $value) {
                    $history_total[$key . '_rate'] = round(($value / $history_number) * 100, 2) . "%";
                }
                $team_history['total'][$category] = $history_total;
            }
        }

        unset($temp);

        include template("sportsdata", "ft_game_data", $default_style);
    }

    /**
     * ajax更新首页最新指数
     */
    public function ajax_live_game_odds_data()
    {
        if ($_POST['gameid']) {
            //需要排除的编号
            $game_id = $_POST['gameid'];
            session_start();
            $_SESSION['game_ids'][] = $game_id;
            //最新指数
            $company_ids = array(3000271,3000181,400000);
            //开始时间
            $start_time = SYS_TIME - 2 * 60 * 60;
            //结束时间
            $end_time = SYS_TIME + 36 * 60 * 60;
            $where = "a.gameid NOT IN (" . join(',', $_SESSION['game_ids']) . ") AND a.date > '$start_time' AND a.date < '$end_time'";
            $live_game_odds_sql = 'SELECT a.gameid,
									  IF(a.competitionshortname<>"",a.competitionshortname,a.competitionname) AS `competition`,
									  IF(a.homeshortname<>"",a.homeshortname,a.homename) AS `home`,
									  IF(a.awayshortname<>"",a.awayshortname,a.awayname) AS `away`,
									  a.date AS `date`,
									  IFNULL(b.homescore, 0) AS homescore,
									  IFNULL(b.awayscore, 0) AS awayscore
							   FROM ft_live_game a
							   INNER JOIN ft_live_game_data b ON a.gameid=b.gameid
							   INNER JOIN ft_odds_asia c ON a.gameid=c.gameid
							   INNER JOIN ft_odds_euro d ON a.gameid=d.gameid
							   INNER JOIN ft_odds_ou e ON a.gameid=e.gameid
							   WHERE ' . $where . '
							   ORDER BY a.date DESC
							   LIMIT 1';
            $this->db->query($live_game_odds_sql);
            $live_game_data = $this->db->fetch_array(MYSQLI_ASSOC)[0];

            $odds_data = array();
            if ($live_game_data) {
                $live_game_data['link'] = '<a href="' . APP_PATH . 'game/' . $live_game_data['gameid'] . '/analyse/" target="_blank">析</a>';
                $live_game_data['score'] = $live_game_data['homescore'] . '-' . $live_game_data['awayscore'];
                $live_game_data['date'] = date('H:i', $live_game_data['date']);
                $live_game_data['home'] = str_cut($live_game_data['home'], 12, '');
                $live_game_data['away'] = str_cut($live_game_data['away'], 12, '');
                //亚盘
                $asia_where = '`gameid`=' . $live_game_data['gameid'] . ' AND `companyid` IN (' . join(',', $company_ids) . ')';
                $odds_asia_db = pc_base::load_model('odds_asia_model');
                $odds_asia_info = $odds_asia_db->select($asia_where, '`companyid`,`companyname`,`gameid`,`up`,`down`,`give`', '', 'oddsdate DESC');
                if (count($odds_asia_info)) {
                    foreach ($odds_asia_info as $odds) {
                        $odds_data['asia'][$odds['companyid']]['up'] = $odds['up'];
                        $odds_data['asia'][$odds['companyid']]['down'] = $odds['down'];
                        $odds_data['asia'][$odds['companyid']]['give'] = get_handicap($odds['give']);
                    }
                }

                //欧赔
                $aisa2euro = asia2euro();           //亚指公司映射到欧指公司
                $euro2asia = array_flip($aisa2euro); //欧指公司映射到亚指公司
                $cid2cname = cid2cname();           //亚指公司编号映射到公司名
                //获取对应的欧指公司的$euro_company_condition
                $euro_option_cid = array();
                foreach ($company_ids as $cid) {
                    $euro_option_cid[] = $aisa2euro[$cid];
                }
                $euro_where = '`gameid`=' . $live_game_data['gameid'] . ' AND `companyid` IN (' . join(',', $euro_option_cid) . ')';
                $odds_euro_db = pc_base::load_model('odds_euro_model');
                $odds_euro_info = $odds_euro_db->select($euro_where, '`companyid`,`companyname`,`homewin`,`awaywin`,`draw`');
                if (count($odds_euro_info)) {
                    foreach ($odds_euro_info as $odds) {
                        $cid = $euro2asia[$odds['companyid']];
                        $odds_data['euro'][$cid]['homewin'] = $odds['homewin'];
                        $odds_data['euro'][$cid]['draw'] = $odds['draw'];
                        $odds_data['euro'][$cid]['awaywin'] = $odds['awaywin'];
                    }
                }

                //大小球
                $ou_where = '`gameid`=' . $live_game_data['gameid'] . ' AND `companyid` IN (' . join(',', $company_ids) . ')';
                $odds_ou_db = pc_base::load_model('odds_ou_model');
                $odds_ou_info = $odds_ou_db->select($ou_where, '`companyid`,`companyname`,`gameid`,`big`,`total`,`small`', '', 'oddsdate DESC');
                if (count($odds_ou_info)) {
                    foreach ($odds_ou_info as $odds) {
                        $odds_data['ou'][$odds['companyid']]['big'] = rtrim0($odds['big']);
                        $odds_data['ou'][$odds['companyid']]['total'] = handicap_ou($odds['total']);
                        $odds_data['ou'][$odds['companyid']]['small'] = rtrim0($odds['small']);
                    }
                }
                //响应数据
                $response = array(
                    'state' => true,
                    'info' => $live_game_data,
                    'odds' => $odds_data,
                    'history' => join(',', $_SESSION['game_ids'])
                );
            } else {
                $response = array(
                    'state' => false
                );
            }
        } else {
            $response = array(
                'state' => false
            );
        }

        exit(json_encode($response));
    }
    //关联赛事
   // http://www.399cm.com/index.php?m=admin&c=index
    public function connect_games() {
        //即时比分赛事时间范围
        $title = $_GET['title'];
        
        $starttime = SYS_TIME - 12 * 60 * 60; //开始时间
        $endtime = SYS_TIME + 36 * 60 * 60;  //结束时间
        //比赛状态数组
        $arr_status = $this->arr_status;

        //指数公司
        $company_sql = "SELECT
                          `companyid`,
                          `name` companyname
                        FROM ft_company
                        WHERE `area` = '亚指公司'
                        ORDER BY `companyid` ASC";
        $this->db->query($company_sql);
        $companies = $this->db->fetch_array();
        //特殊选项
        $companies[] = array('companyid' => -1, 'companyname' => '完整');
        //将companyid作为$companies的key
        foreach ($companies as $key => $company) {
            $companies[$company['companyid']] = $company;
            unset($companies[$key]);
        }

        //选择指数公司
        if (isset($_POST['dosubmit'])) {
            $companyid = $_POST['companyid'];
            $companyname = '盘口';
            //完整选项
            $is_clear = true;   //是否清除未开盘比赛
            $is_all = false;    //是否获取所有公司的指数
            if ($companyid == -1) {
                $is_clear = true;
                $is_all = true;
                $companyid = 400000;  //S2
                $companyname = $companies[$companyid]['companyname'];
            }

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
  
            //获取亚盘指数
            $game_condition = to_sqls(array_column($live_game_data, 'gameid'), '', 'gameid');
            $this->db->table_name = 'ft_odds_asia';
            if ($is_all) {
                //所有公司
                $odds_asia = $this->db->select("1=1 AND $game_condition", '`gameid`,`up`,`down`,`give`,`isrun`,`fup`,`fdown`,`fgive`', '', '', '', 'gameid');
            } else {
                //指定公司
                $odds_asia = $this->db->select("1=1 AND companyid = '$companyid' AND $game_condition", '`gameid`,`up`,`down`,`give`,`isrun`,`fup`,`fdown`,`fgive`', '', '', '', 'gameid');
            }


            //清除未开盘的比赛
            //处理特殊选项，不清除未开盘的比赛
            if ($is_clear) {
                foreach ($live_game_data as $key => $game) {
                    if (!isset($game['give']) && !isset($game['total']))
                        unset($live_game_data[$key]);
                }
            }

            //赛事选择
            $tmp = array_count_values(array_column($live_game_data, 'competitionid'));
            foreach ($tmp as $key => $value) {
                $competition_data[$key]['competitionid'] = $key;
                $competition_data[$key]['competitionshortname'] = $competitions[$key];
                $competition_data[$key]['count'] = $value;
            }
            unset($competitions);

            //盘口选择
            $tmp = array_count_values(array_column($live_game_data, 'give'));
            //完整选项
            if (!$is_clear) {
                $handicap_data['diff']['give'] = null;
                $handicap_data['diff']['count'] = count($live_game_data) - array_sum($tmp);
            }
            foreach ($tmp as $key => $value) {
                $handicap_data[$key]['give'] = $key;
                $handicap_data[$key]['count'] = $value;
            }
            unset($tmp);
        }
        //默认
        else {
            //S2公司
            $companyid = 400000;
            $companyname = $companies[$companyid]['companyname'];

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
            //将gameid作为$live_game_data的key
            //生成以competitionid为key，competitionshortname为value的数组$competitions
            foreach ($live_game_data as $key => $game) {
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
            }
            //清除未开盘的比赛
            //foreach ($live_game_data as $key => $game) {
            //    if (!isset($game['give']) && !isset($game['total'])) unset($live_game_data[$key]);
            //}
            //赛事选择
            $tmp = array_count_values(array_column($live_game_data, 'competitionid'));
            foreach ($tmp as $key => $value) {
                $competition_data[$key]['competitionid'] = $key;
                $competition_data[$key]['competitionshortname'] = $competitions[$key];
                $competition_data[$key]['count'] = $value;
            }
            unset($competitions);

            //盘口选择
            $tmp = array_count_values(array_column($live_game_data, 'give'));
            $handicap_data['diff']['give'] = null;
            $handicap_data['diff']['count'] = count($live_game_data) - array_sum($tmp);
            foreach ($tmp as $key => $value) {
                $handicap_data[$key]['give'] = $key;
                $handicap_data[$key]['count'] = $value;
            }
            unset($tmp);
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
        include template('sportsdata', 'connect_games');
    }

}
