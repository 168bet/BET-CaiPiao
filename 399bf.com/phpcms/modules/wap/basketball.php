<?php
//win007.com 篮球数据控制器
defined('IN_PHPCMS') or exit('No permission resources.');
//模块缓存路径
define('CACHE_SPORTSDATA_PATH', CACHE_PATH . 'caches_wap' . DIRECTORY_SEPARATOR . 'caches_data' . DIRECTORY_SEPARATOR);
//加载模块全局函数
pc_base::load_app_func('global');
pc_base::load_app_func('global', 'sportsdata');

class basketball
{
    //比赛状态
    private $status_arr = [
        -5 => '推迟',
        -4 => '取消',
        -3 => '中断',
        -2 => '待定',
        -1 => '完场',
        0 => '未开赛',
        1 => '第一节',
        2 => '第二节',
        3 => '第三节',
        4 => '第四节',
        5 => '1\'OT',
        6 => '2\'OT',
        7 => '3\'OT',
        8 => '4\'OT',
        9 => '5\'OT',
        50 => '中场',
        11 => '上半场',
        13 => '下半场',
    ];
        private $arr_sclasscategory = [
        1 => '季前赛',
        2 => '常规赛',
        3 => '季后赛',
    ];

    private $sclasstype_arr = [
        1 => '联赛',
        2 => '杯赛',
    ];

    private $sclasscategory_arr = [
        1 => '季前赛',
        2 => '常规赛',
        3 => '季后赛',
    ];

    //公司
    private $company_arr = [
        // 让分, 大小分, 欧赔(皇冠无数据,默认为bet365)
        1 => [8, 11, 281], // Bet365 => bet 365(英国)
        2 => [3, 6, 545],  // 皇冠 => SB
        3 => [1, 4, 80],  // 澳门 => Macauslot(澳门)
        4 => [2, 5, 90],  // 易胜博 => 易胜博(安提瓜和巴布达)
        5 => [9, 12, 81], // 韦德 => 伟德(直布罗陀)
    ];

    private $company = [
        1 => 'Bet365',
        2 => '皇冠',
        3 => '澳门',
        4 => '易胜博',
        5 => '韦德'
    ];

    private $c_asia = [
        8 => 1,
        3 => 2,
        1 => 3,
        2 => 4,
        9 => 5
    ];

    private $c_ou = [
        11 => 1,
        6 => 2,
        4 => 3,
        5 => 4,
        12 => 5
    ];

    private $c_euro = [
        281 => 1,
        545 => 2,
        80 => 3,
        90 => 4,
        81 => 5
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
        $this->db = pc_base::load_model('live_schedule_model');
        $this->eu_db = pc_base::load_model('europeodds_model');
        $this->let_db = pc_base::load_model('letgoal_model');
        $this->total_db = pc_base::load_model('totalscore_model');
        $this->sclass_db = pc_base::load_model('sclass_model');
        $this->schedule_db = pc_base::load_model('schedule_model');
        $this->standings_db = pc_base::load_model('team_standings_model');
        $this->lineup_db = pc_base::load_model('lineup_model');
        $this->technic_db = pc_base::load_model('team_technic_model');

        $this->let_detail_db = pc_base::load_model('letgoal_detail_model');
        $this->total_detail_db = pc_base::load_model('totalscore_detail_model');
        $this->company_db = pc_base::load_model('bt_company_model');
        $this->eu_company_db = pc_base::load_model('bt_euro_company_model');
        $this->eu_detail_db = pc_base::load_model('bt_europeodds_detail_model');

        $this->team_db   = pc_base::load_model('bt_team_model');
        $this->player_db = pc_base::load_model('bt_player_model');
    }

    //资料库
    public function event()
    {
        $SEO['title'] = '篮球数据库';
        $SEO['keyword'] = '篮球数据库';
        $SEO['description'] = '399彩迷网拥有全网最齐全的篮球资料库，覆盖全世界所有的球队和联赛，包含球员情况、球队资料、赛程安排、积分排行、对战历史、伤停情报、盘赔变化等所有你需要的购彩情报！';

        $area = [
            //欧洲
            'euro' => [
                //国家
                'country' => [3, 6, 7, 8, 9, 11, 12, 13, 24, 28, 25, 26, 27, 57, 29, 35, 32, 36, 31, 30, 33, 37, 39, 40,
                    41, 43, 44, 46, 38, 47, 48, 49, 53, 54, 55, 59],
                //洲际
                'zone' => [16],
                'name' => '欧洲赛事'
            ],
            //美洲
            'america' => [
                'country' => [1, 45, 34, 51],
                'zone' => [18],
                'name' => '美洲赛事'
            ],
            //亚洲
            'asia' => [
                'country' => [2, 10, 22, 23, 42, 58, 61, 84, 85],
                'zone' => [17],
                'name' => '亚洲赛事'
            ],
            //国际
            'world' => [
                'country' => [19],
                'zone' => [20],
                'name' => '国际赛事'
            ],
        ];

        $raw = $this->sclass_db->select();

        $stat = [];

        foreach ($raw as $r) {
            $sclass_info = ['sclassid' => $r['sclassid'], 'name' => $r['name_s']];

            foreach ($area as $key => $value) {
                if (in_array($r['countryid'], $value['country'])) {
                    $stat[$key]['country']['countryname'][$r['countryid']] = ['countryid' => $r['countryid'], 'countryname' => $r['countryname']];
                    $stat[$key]['country']['sclass'][$r['countryid']][] = $sclass_info;
                    break;
                }

                if (in_array($r['countryid'], $value['zone'])) {
                    $stat[$key]['zone'][] = $sclass_info;
                    break;
                }
            }
        }

        include template('wap', 'bt_event');
    }

    //即时比分
    public function live_schedule()
    {
        $SEO['title'] = '篮球即时比分';
        $SEO['keyword'] = '篮球即时比分';
        $SEO['description'] = '399彩迷网为彩迷提供全网最新的篮球比分直播。赛事赛程安排、篮球完场比分、比分盘赔指数等服务涵盖了世界范围内的所有篮球联赛，为大家提供最精准的篮球即时比分！';
        // 5小时前
        $companyId = (int)$_REQUEST['company_id'];

        if ($companyId <= 0) {
            $companyId = 2;
        }

        $companyIdArr = $this->company_arr[$companyId];

        $idArr = ['-1', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '50'];
        $where = to_sqls($idArr, '', '`status`');
        $data = $this->db->select($where . ' AND `date` >' . (SYS_TIME - 86400), 'sclasspart,sclassid,hometeamid,guestteamid,scheduleid,sclassname_cn,sclasscolor,date,status,remaintime,
        homename_cn,guestname_cn,homescore,guestscore,homeone,guestone,hometwo,guesttwo,homethree,guestthree,homefour,
        guestfour', '', 'date');

        //总场数
        $total = count($data);

        $inWhere = to_sqls(array_column($data, 'scheduleid'), '', '`scheduleid`');

        //欧赔
        $euData = $this->eu_db->select($inWhere . ' AND companyid=' . $companyIdArr[2], '*', '', '', '', 'scheduleid');

        //让分
        $letData = $this->let_db->select($inWhere . ' AND companyid=' . $companyIdArr[0], '*', '', '', '', 'scheduleid');

        // 大小分
        $totalData = $this->total_db->select($inWhere . ' AND companyid=' . $companyIdArr[1], '*', '', '', '', 'scheduleid');

        // 获取赛事数据
        $sclassidWhere = to_sqls(array_column($data, 'sclassid'), '', '`sclassid`');
        $sclassidData = $this->sclass_db->select($sclassidWhere, 'sclassid,name_s', '', '', '', 'sclassid');

        foreach ($data as $item) {
            $status = (int)$item['status'];
            $id = $item['scheduleid'];

            if ($item['sclasspart'] === '2' && ($item['status'] ==1 || $item['status']==3)) {
                $item['status'] = $this->status_arr[$status+10];
            } else {
                $item['status'] = $this->status_arr[$status];
            }

            $matchTime = $item['date'];
//            $item['date'] = date('H:i', $item['date']);
            $item['home_logo'] = '/uploadfile/win007.com/basketball/team/' . $item['hometeamid'] . '.jpg';
            $item['guest_logo'] = '/uploadfile/win007.com/basketball/team/' . $item['guestteamid'] . '.jpg';

            // 全场 和差
            $item['wholeSum'] = $item['homescore'] + $item['guestscore'];
            $item['wholeDiff'] = $item['homescore'] - $item['guestscore'];

            // 上下
            $item['homeFirstHalf'] = $item['homeone'] + $item['hometwo'];
            $item['homeSecondHalf'] = $item['homethree'] + $item['homefour'];
            $item['guestFirstHalf'] = $item['guestone'] + $item['guesttwo'];
            $item['guestSecondHalf'] = $item['guestthree'] + $item['guestfour'];

            // 半场 和差
            $item['halfSum'] = $item['homeFirstHalf'] + $item['guestFirstHalf'];
            $item['halfDiff'] = $item['homeFirstHalf'] - $item['guestFirstHalf'];

            if ($status === 0) { // 未开始
                $item['homewin_f'] = isset($euData[$id]['homewin_f']) ? rtrim0($euData[$id]['homewin_f']) : '';
                $item['guestwin_f'] = isset($euData[$id]['guestwin_f']) ? rtrim0($euData[$id]['guestwin_f']) : '';

                $item['homeodds_f'] = isset($letData[$id]['homeodds_f']) ? rtrim0($letData[$id]['homeodds_f']) : '';
                $item['guestodds_f'] = isset($letData[$id]['guestodds_f']) ? rtrim0($letData[$id]['guestodds_f']) : '';
                $item['letgoal_f'] = isset($letData[$id]['letgoal_f']) ? rtrim0($letData[$id]['letgoal_f']) : '';

                $item['highodds_f'] = isset($totalData[$id]['highodds_f']) ? rtrim0($totalData[$id]['highodds_f']) : '';
                $item['lowodds_f'] = isset($totalData[$id]['lowodds_f']) ? rtrim0($totalData[$id]['lowodds_f']) : '';
                $item['totalscore_f'] = isset($totalData[$id]['totalscore_f']) ? rtrim0($totalData[$id]['totalscore_f']) : '';

                $item['flag'] = 'notstarted';

                $return['not_started'][] = $item;
            } elseif ($status === -1) { //已结束
                $item['homewin'] = isset($euData[$id]['homewin']) ? rtrim0($euData[$id]['homewin']) : '';
                $item['guestwin'] = isset($euData[$id]['guestwin']) ? rtrim0($euData[$id]['guestwin']) : '';

                if (isset($letData[$id]['goal_r']) && $letData[$id]['goal_r'] !== '0.00' ) {
                    $item['letgoal'] = rtrim0($letData[$id]['goal_r']);
                } else {
                    $item['letgoal'] = isset($letData[$id]['letgoal']) ? rtrim0($letData[$id]['letgoal']) : '';
                }

                if (isset($letData[$id]['homeodds_r']) && $letData[$id]['homeodds_r'] !== '0.000' ) {
                    $item['homeodds'] = rtrim0($letData[$id]['homeodds_r']);
                } else {
                    $item['homeodds'] = isset($letData[$id]['homeodds']) ? rtrim0($letData[$id]['homeodds']) : '';
                }

                if (isset($letData[$id]['guestodds_r']) && $letData[$id]['guestodds_r'] !== '0.000' ) {
                    $item['guestodds'] = rtrim0($letData[$id]['guestodds_r']);
                } else {
                    $item['guestodds'] = isset($letData[$id]['guestodds']) ? rtrim0($letData[$id]['guestodds']) : '';
                }

                $agvs = ['highodds', 'lowodds', 'totalscore'];

                foreach ($agvs as $agv) {
                    $agv_r = $agv . '_r';

                    if (isset($totalData[$id][$agv_r]) && $totalData[$id][$agv_r] !== '0.00' && $totalData[$id][$agv_r] !=='0.000') {
                        $item[$agv] = rtrim0($totalData[$id][$agv_r]);
                    } else {
                        $item[$agv] = isset($totalData[$id][$agv]) ? rtrim0($totalData[$id][$agv]) : '';
                    }
                }

                $item['flag'] = 'finished';

                $return['finished'][] = $item;
            } elseif ($status > 0) { // 进行中
                $item['homewin'] = isset($euData[$id]['homewin']) ? rtrim0($euData[$id]['homewin']) : '';
                $item['guestwin'] = isset($euData[$id]['guestwin']) ? rtrim0($euData[$id]['guestwin']) : '';

                if (isset($letData[$id]['goal_r']) && $letData[$id]['goal_r'] !== '0.00' ) {
                    $item['letgoal'] = rtrim0($letData[$id]['goal_r']);
                } else {
                    $item['letgoal'] = isset($letData[$id]['letgoal']) && !empty($letData[$id]['letgoal']) ? rtrim0($letData[$id]['letgoal']) : '';
                }

                if (isset($letData[$id]['homeodds_r']) && $letData[$id]['homeodds_r'] !== '0.000' ) {
                    $item['homeodds'] = rtrim0($letData[$id]['homeodds_r']);
                } else {
                    $item['homeodds'] = isset($letData[$id]['homeodds']) && !empty($letData[$id]['homeodds']) ? rtrim0($letData[$id]['homeodds']) : '';
                }

                if (isset($letData[$id]['guestodds_r']) && $letData[$id]['guestodds_r'] !== '0.000' ) {
                    $item['guestodds'] = rtrim0($letData[$id]['guestodds_r']);
                } else {
                    $item['guestodds'] = isset($letData[$id]['guestodds']) && !empty($letData[$id]['guestodds']) ? rtrim0($letData[$id]['guestodds']) : '';
                }

                $agvs = ['highodds', 'lowodds', 'totalscore'];

                foreach ($agvs as $agv) {
                    $agv_r = $agv . '_r';

                    if (isset($totalData[$id][$agv_r]) && $totalData[$id][$agv_r] !== '0.00' && $totalData[$id][$agv_r] !=='0.000') {
                        $item[$agv] = rtrim0($totalData[$id][$agv_r]);
                    } else {
                        $item[$agv] = isset($totalData[$id][$agv]) && !empty($totalData[$id][$agv]) ? rtrim0($totalData[$id][$agv]) : '';
                    }
                }

                $item['flag'] = 'inprogress';

                $return['in_progress'][] = $item;
            }

            //按赛事
            $return['match'][$item['sclassid']][] = $item;
        }

        include template('wap', 'bt_live_schedule');
    }

    /**
     * 比赛最新数据
     * @return bool
     */
    public function schedule_data()
    {
        $sclassid = $_POST['schedule_id'];

        if (empty($sclassid) || !is_array($sclassid)) {
            $this->error('传递数值有误');
            return false;
        }

        $idArr = array_map('intval', $sclassid);
        $where = to_sqls($idArr, '', '`scheduleid`');

        $data = $this->db->select($where, 'sclasspart,scheduleid,sclassid,status,remaintime,homescore,guestscore,homeone,
        guestone,hometwo,guesttwo,homethree,guestthree,homefour,guestfour');
        $return = [];

        foreach ($data as $item) {
            $status = (int)$item['status'];

            if ($status === -1) {
                $item['is_over'] = true;
                $return['finish_id'][] = ['sclassid' => $item['sclassid'], 'scheduleid' => $item['scheduleid']];
            }

            $item['date'] = date('H:i', $item['date']);

            if ($item['sclasspart'] === '2' && ($item['status'] ==1 || $item['status']==3)) {
                $item['status'] = $this->status_arr[$status+10];
            } else {
                $item['status'] = $this->status_arr[$status];
            }

            $item['hometwo'] = $item['hometwo'] != 0 ? $item['hometwo'] : '-';
            $item['guesttwo'] = $item['guesttwo'] != 0 ? $item['guesttwo'] : '-';
            $item['homethree'] = $item['homethree'] != 0 ? $item['homethree'] : '-';
            $item['guestthree'] = $item['guestthree'] != 0 ? $item['guestthree'] : '-';
            $item['homefour'] = $item['homefour'] != 0 ? $item['homefour'] : '-';
            $item['guestfour'] = $item['guestfour'] != 0 ? $item['guestfour'] : '-';

            // 全场 和差
            $item['wholeSum'] = $item['homescore'] + $item['guestscore'];
            $item['wholeDiff'] = $item['homescore'] - $item['guestscore'];

            // 上下
            $item['homeFirstHalf'] = $item['homeone'] + $item['hometwo'];
            $item['homeSecondHalf'] = $item['homethree'] + $item['homefour'];
            $item['guestFirstHalf'] = $item['guestone'] + $item['guesttwo'];
            $item['guestSecondHalf'] = $item['guestthree'] + $item['guestfour'];

            // 半场 和差
            $item['halfSum'] = $item['homeFirstHalf'] + $item['guestFirstHalf'];
            $item['halfDiff'] = $item['homeFirstHalf'] - $item['guestFirstHalf'];

            $return['in_progress'][] = $item;
        }

        $this->response($return);
    }

    /**
     * 赔率最新数据
     * @return bool
     */
    public function rate_data()
    {
        $scheduleId = $_POST['schedule_id'];
        $companyId = (int)$_POST['company_id'];

        if (empty($scheduleId) || !is_array($scheduleId)) {
            $this->error('传递数值有误');
            return false;
        }

        if ($companyId <= 0) {
            $companyId = 2;
        }

        $companyIdArr = $this->company_arr[$companyId];

        if (!isset($companyIdArr)) {
            $this->error('传递数值有误');
            return false;
        }

        $return = [];
        $idArr = array_map('intval', $scheduleId);
        $where = to_sqls($idArr, '', 'scheduleid');
        $data = $this->db->select($where, 'scheduleid,status,homescore,guestscore');

        $inWhere = to_sqls(array_column($data, 'scheduleid'), '', '`scheduleid`');

        //欧赔
        $euData = $this->eu_db->select($inWhere . ' AND companyid=' . $companyIdArr[2], '*', '', '', '', 'scheduleid');

        //让分
        $letData = $this->let_db->select($inWhere . ' AND companyid=' . $companyIdArr[0], '*', '', '', '', 'scheduleid');

        // 大小分
        $totalData = $this->total_db->select($inWhere . ' AND companyid=' . $companyIdArr[1], '*', '', '', '', 'scheduleid');

        foreach ($data as $item) {
            $status = (int)$item['status'];
            $id = $item['scheduleid'];

            if ($status === 0) { // 未开始
                $item['homewin_f'] = isset($euData[$id]['homewin_f']) ? rtrim0($euData[$id]['homewin_f']) : '';
                $item['guestwin_f'] = isset($euData[$id]['guestwin_f']) ? rtrim0($euData[$id]['guestwin_f']) : '';

                $item['homeodds_f'] = isset($letData[$id]['homeodds_f']) ? rtrim0($letData[$id]['homeodds_f']) : '';
                $item['guestodds_f'] = isset($letData[$id]['guestodds_f']) ? rtrim0($letData[$id]['guestodds_f']) : '';
                $item['letgoal_f'] = isset($letData[$id]['letgoal_f']) ? rtrim0($letData[$id]['letgoal_f']) : '';

                $item['highodds_f'] = isset($totalData[$id]['highodds_f']) ? rtrim0($totalData[$id]['highodds_f']) : '';
                $item['lowodds_f'] = isset($totalData[$id]['lowodds_f']) ? rtrim0($totalData[$id]['lowodds_f']) : '';
                $item['totalscore_f'] = isset($totalData[$id]['totalscore_f']) ? rtrim0($totalData[$id]['totalscore_f']) : '';

                $return['not_started'][] = $item;
            } elseif ($status !== 0) { // 进行中
                $item['homewin'] = isset($euData[$id]['homewin']) ? rtrim0($euData[$id]['homewin']) : '';
                $item['guestwin'] = isset($euData[$id]['guestwin']) ? rtrim0($euData[$id]['guestwin']) : '';

                if (isset($letData[$id]['goal_r']) && $letData[$id]['goal_r'] !== '0.00') {
                    $item['letgoal'] = rtrim0($letData[$id]['goal_r']);
                } else {
                    $item['letgoal'] = isset($letData[$id]['letgoal']) ? rtrim0($letData[$id]['letgoal']) : '';
                }

                if (isset($letData[$id]['homeodds_r']) && $letData[$id]['homeodds_r'] !== '0.000' ) {
                    $item['homeodds'] = rtrim0($letData[$id]['homeodds_r']);
                } else {
                    $item['homeodds'] = isset($letData[$id]['homeodds']) ? rtrim0($letData[$id]['homeodds']) : '';
                }

                if (isset($letData[$id]['guestodds_r']) && $letData[$id]['guestodds_r'] !== '0.000' ) {
                    $item['guestodds'] = rtrim0($letData[$id]['guestodds_r']);
                } else {
                    $item['guestodds'] = isset($letData[$id]['guestodds']) ? rtrim0($letData[$id]['guestodds']) : '';
                }

                $agvs = ['highodds', 'lowodds', 'totalscore'];

                foreach ($agvs as $agv) {
                    $agv_r = $agv . '_r';

                    if (isset($totalData[$id][$agv_r]) && $totalData[$id][$agv_r] !== '0.00' && $totalData[$id][$agv_r] !=='0.000') {
                        $item[$agv] = rtrim0($totalData[$id][$agv_r]);
                    } else {
                        $item[$agv] = isset($totalData[$id][$agv]) ? rtrim0($totalData[$id][$agv]) : '';
                    }
                }

                unset($item['status']);
                $return['in_progress'][] = $item;
            }
        }

        $this->response($return);
    }

    private function error($msg = '')
    {
        $resource = [
            'status' => false,
            'msg' => (string)$msg,
        ];

        header('Content-type: application/json; charset=utf-8');
        echo \json_encode($resource);

        return false;
    }

    private function response($data = [])
    {
        $resource = [
            'status' => true,
            'data' => $data,
        ];

        header('Content-type: application/json; charset=utf-8');
        echo \json_encode($resource);

        return false;
    }

    //完场比分
    public function end_schedule()
    {
        $SEO['title'] = '篮球比分网_完场';
        $SEO['keyword'] = '篮球比分网';
        $SEO['description'] = '399彩迷网提供最全的NBA完场比分、最为详细的篮球比分查询，即时为彩民提供篮球完场比分数据。';

        //Bet365
        $let_companyid = 8;     //让分、欧赔
        $total_companyid = 11;  //大小总分

        $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $week = [1 => '一', 2 => '二', 3 => '三', 4 => '四', 5 => '五', 6 => '六', 7 => '天'];
        $starttime = strtotime($date . ' 00:00:00');
        $endtime = strtotime($date . ' 23:59:59');
        $date_text = date('m月d日', $endtime) . ' 星期' . $week[date('N', $endtime)];
        $today = date('Y-m-d');

        foreach ($week as $key => $value) {
            $time = SYS_TIME - ($key - 1) * 24 * 60 * 60;
            $arr_date[] = [
                'date' => date('Y-m-d', $time),
                'date_text' => date('m.d', $time),
                'week_text' => $key == 1 ? '今日' : '周' . $week[date('N', $time)],
                'active' => date('Y-m-d', $time) == $date ? 1 : 0,
            ];
        }

        //状态 -1完场
        $status = [-1];
        $where = to_sqls($status, '', '`status`');
        $end_schedule = $this->db->select($where . ' AND `date` >=' . $starttime . ' AND `date` <=' . $endtime, 'scheduleid,sclassid,sclassname_cn,sclasspart,sclasscolor,date,status,remaintime,
        hometeamid,guestteamid,homename_cn,guestname_cn,homescore,guestscore,homeone,guestone,hometwo,guesttwo,homethree,guestthree,homefour,
        guestfour,addtime,homeaddtime1,guestaddtime1,homeaddtime2,guestaddtime2,homeaddtime3,guestaddtime3', '', 'date');

        //比赛id
        $condition = to_sqls(array_column($end_schedule, 'scheduleid'), '', '`scheduleid`');

        //总场数
        $total = count($end_schedule);

        //欧赔
        $euro_odds = $this->eu_db->select('`companyid`=' . $let_companyid . ' AND ' . $condition, '*', '', '', '', 'scheduleid');

        //让分盘
        $let_odds = $this->let_db->select('`companyid`=' . $let_companyid . ' AND ' . $condition, '*', '', '', '', 'scheduleid');

        //大小分
        $total_odds = $this->total_db->select('`companyid`=' . $total_companyid . ' AND ' . $condition, '*', '', '', '', 'scheduleid');

        foreach ($end_schedule as &$item) {
            $id = $item['scheduleid'];
            $status = (int)$item['status'];

            if ($item['sclasspart'] === '2' && ($item['status'] ==1 || $item['status']==3)) {
                $item['status'] = $this->status_arr[$status+10];
            } else {
                $item['status'] = $this->status_arr[$status];
            }

            $item['date'] = date('H:i', $item['date']);

            //赛事选择
            $sclass_data[$item['sclassid']]['sclassid'] = $item['sclassid'];
            $sclass_data[$item['sclassid']]['sclassname'] = $item['sclassname_cn'];

            //球队队标
            $item['homelogo'] = BT_TEAM_PATH . $item['hometeamid'] . '.jpg';
            $item['guestlogo'] = BT_TEAM_PATH . $item['guestteamid'] . '.jpg';

            // 全场 和差
            $item['wholeSum'] = $item['homescore'] + $item['guestscore'];
            $item['wholeDiff'] = $item['homescore'] - $item['guestscore'];

            // 上下
            $item['homeFirstHalf'] = $item['homeone'] + $item['hometwo'];
            $item['homeSecondHalf'] = $item['homethree'] + $item['homefour'];
            $item['guestFirstHalf'] = $item['guestone'] + $item['guesttwo'];
            $item['guestSecondHalf'] = $item['guestthree'] + $item['guestfour'];

            // 半场 和差
            $item['halfSum'] = $item['homeFirstHalf'] + $item['guestFirstHalf'];
            $item['halfDiff'] = $item['homeFirstHalf'] - $item['guestFirstHalf'];

            $item['homewin'] = isset($euro_odds[$id]['homewin']) ? rtrim0($euro_odds[$id]['homewin']) : '';
            $item['guestwin'] = isset($euro_odds[$id]['guestwin']) ? rtrim0($euro_odds[$id]['guestwin']) : '';

            $item['homeodds'] = isset($let_odds[$id]['homeodds']) ? rtrim0($let_odds[$id]['homeodds']) : '';
            $item['guestodds'] = isset($let_odds[$id]['guestodds']) ? rtrim0($let_odds[$id]['guestodds']) : '';
            $item['letgoal'] = isset($let_odds[$id]['letgoal']) ? rtrim0($let_odds[$id]['letgoal']) : '';

            $item['highodds'] = isset($total_odds[$id]['highodds']) ? rtrim0($total_odds[$id]['highodds']) : '';
            $item['lowodds'] = isset($total_odds[$id]['lowodds']) ? rtrim0($total_odds[$id]['lowodds']) : '';
            $item['totalscore'] = isset($total_odds[$id]['totalscore']) ? rtrim0($total_odds[$id]['totalscore']) : '';
        }
        ksort($sclass_data);

        include template('wap', 'bt_end_schedule');
    }

    //下日赛程
    public function future_schedule()
    {
        $SEO['title'] = '竞彩篮球推荐_下日';
        $SEO['keyword'] = '竞彩篮球,竞彩篮球推荐';
        $SEO['description'] = '399彩迷网为您提供最即时，最全的篮球赛事、NBA赛事预告，以及竞彩篮球推荐、最准确的NBA赛程，每一场不容错过的NBA比赛赛事。';

        //Bet365
        $let_companyid = 8;       //让分、欧赔
        $total_companyid = 11;    //大小总分

        $date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d", strtotime("+1 day"));
        $week = [1 => '一', 2 => '二', 3 => '三', 4 => '四', 5 => '五', 6 => '六', 7 => '天'];
        $starttime = strtotime($date . ' 00:00:00');
        $endtime = strtotime($date . ' 23:59:59');
        $date_text = date('m月d日', $endtime) . ' 星期' . $week[date('N', $endtime)];
        $today = date('Y-m-d');

        foreach ($week as $key => $value) {
            $time = SYS_TIME + $key * 24 * 60 * 60;
            $arr_date[] = [
                'date' => date('Y-m-d', $time),
                'date_text' => date('m.d', $time),
                'week_text' => $key == 1 ? '明日' : '周' . $week[date('N', $time)],
                'active' => date('Y-m-d', $time) == $date ? 1 : 0,
            ];
        }

        //状态 0未开赛
        $status = [0];
        $where = to_sqls($status, '', '`status`');
        $future_schedule = $this->schedule_db->select($where . ' AND `date` >=' . $starttime . ' AND `date` <=' . $endtime, 'scheduleid,sclassid,sclassname_cn,sclasspart,sclasscolor,date,status,remaintime,
        hometeamid,guestteamid,homename_cn,guestname_cn,homescore,guestscore,homeone,guestone,hometwo,guesttwo,homethree,guestthree,homefour,
        guestfour,addtime,homeaddtime1,guestaddtime1,homeaddtime2,guestaddtime2,homeaddtime3,guestaddtime3', '', 'date');

        //比赛id
        $condition = to_sqls(array_column($future_schedule, 'scheduleid'), '', '`scheduleid`');

        //总场数
        $total = count($future_schedule);

        //欧赔
        $euro_odds = $this->eu_db->select('`companyid`=' . $let_companyid . ' AND ' . $condition, '*', '', '', '', 'scheduleid');

        //让分盘
        $let_odds = $this->let_db->select('`companyid`=' . $let_companyid . ' AND ' . $condition, '*', '', '', '', 'scheduleid');

        //大小分
        $total_odds = $this->total_db->select('`companyid`=' . $total_companyid . ' AND ' . $condition, '*', '', '', '', 'scheduleid');

        foreach ($future_schedule as &$item) {
            $scheduleid = $item['scheduleid'];
            $status = (int)$item['status'];

            if ($item['sclasspart'] === '2' && ($item['status'] ==1 || $item['status']==3)) {
                $item['status'] = $this->status_arr[$status+10];
            } else {
                $item['status'] = $this->status_arr[$status];
            }

            $item['date'] = date('H:i', $item['date']);

            //赛事选择
            $sclass_data[$item['sclassid']]['sclassid'] = $item['sclassid'];
            $sclass_data[$item['sclassid']]['sclassname'] = $item['sclassname_cn'];

            //球队队标
            $item['homelogo'] = BT_TEAM_PATH . $item['hometeamid'] . '.jpg';
            $item['guestlogo'] = BT_TEAM_PATH . $item['guestteamid'] . '.jpg';

            // 全场 和差
            $item['wholeSum'] = $item['homescore'] + $item['guestscore'];
            $item['wholeDiff'] = $item['homescore'] - $item['guestscore'];

            // 上下
            $item['homeFirstHalf'] = $item['homeone'] + $item['hometwo'];
            $item['homeSecondHalf'] = $item['homethree'] + $item['homefour'];
            $item['guestFirstHalf'] = $item['guestone'] + $item['guesttwo'];
            $item['guestSecondHalf'] = $item['guestthree'] + $item['guestfour'];

            // 半场 和差
            $item['halfSum'] = $item['homeFirstHalf'] + $item['guestFirstHalf'];
            $item['halfDiff'] = $item['homeFirstHalf'] - $item['guestFirstHalf'];
            // 欧赔
            $item['homewin_f'] = isset($euro_odds[$scheduleid]['homewin_f']) ? rtrim0($euro_odds[$scheduleid]['homewin_f']) : '';
            $item['guestwin_f'] = isset($euro_odds[$scheduleid]['guestwin_f']) ? rtrim0($euro_odds[$scheduleid]['guestwin_f']) : '';
            // 让分
            $item['homeodds_f'] = isset($let_odds[$scheduleid]['homeodds_f']) ? rtrim0($let_odds[$scheduleid]['homeodds_f']) : '';
            $item['guestodds_f'] = isset($let_odds[$scheduleid]['guestodds_f']) ? rtrim0($let_odds[$scheduleid]['guestodds_f']) : '';
            $item['letgoal_f'] = isset($let_odds[$scheduleid]['letgoal_f']) ? rtrim0($let_odds[$scheduleid]['letgoal_f']) : '';
            // 大小分
            $item['highodds_f'] = isset($total_odds[$scheduleid]['highodds_f']) ? rtrim0($total_odds[$scheduleid]['highodds_f']) : '';
            $item['lowodds_f'] = isset($total_odds[$scheduleid]['lowodds_f']) ? rtrim0($total_odds[$scheduleid]['lowodds_f']) : '';
            $item['totalscore_f'] = isset($total_odds[$scheduleid]['totalscore_f']) ? rtrim0($total_odds[$scheduleid]['totalscore_f']) : '';

        }

        ksort($sclass_data);

        include template('wap', 'bt_future_schedule');
    }

    //综合指数
    public function odds()
    {
        $SEO['title'] = '篮球赔率';
        $SEO['keyword'] = '篮球盘口，篮球赔率';
        $SEO['description'] = '看篮球即时赔率，首选399彩迷网！399彩迷网为广大彩迷提供各大欧洲赔率公司和亚洲盘口的篮球初始赔率、即时赔率数据，提供赔率分析和盘口走势分析等盘赔数据查询！';

        $company = $this->company;
        $companyid = isset($_GET['companyid']) ? (int)$_GET['companyid'] : 1;

        #-------------即时比分------------
        $field = '`scheduleid`,`sclassid`,`sclassname_cn`,`sclasscolor`,`hometeamid`,`homename_cn`,`guestteamid`,`guestname_cn`,`date`,`homerank`,`guestrank`,`homescore`,`guestscore`,`status`';
        $where = '`date`>' . (SYS_TIME - 12 * 60 * 60) . ' AND `date`<' . (SYS_TIME + 48 * 60 * 60);

        $live_schedule = $this->db->select($where, $field, '', '`date` ASC', '', 'scheduleid');

        #-------------指数部分------------
        $schedule_ids = to_sqls(array_column($live_schedule, 'scheduleid'), '', 'scheduleid');

        //让分
        $where = '`companyid`=' . $this->company_arr[$companyid][0] . ' AND ' . $schedule_ids;
        $field = '`scheduleid`,`letgoal`,`homeodds`,`guestodds`,`letgoal_f`,`homeodds_f`,`guestodds_f`';
        $odds_asia = $this->let_db->select($where, $field);

        if ($odds_asia) {
            foreach ($odds_asia as $odds) {
                $live_schedule[$odds['scheduleid']] = array_merge($live_schedule[$odds['scheduleid']], $odds);
            }
        }

        //总分
        $where = '`companyid`=' . $this->company_arr[$companyid][1] . ' AND ' . $schedule_ids;
        $field = '`scheduleid`,`totalscore`,`highodds`,`lowodds`,`totalscore_f`,`highodds_f`,`lowodds_f`';
        $odds_ou = $this->total_db->select($where, $field);

        if ($odds_ou) {
            foreach ($odds_ou as $odds) {
                $live_schedule[$odds['scheduleid']] = array_merge($live_schedule[$odds['scheduleid']], $odds);
            }
        }

        //欧赔
        $where = '`companyid`=' . $this->company_arr[$companyid][2] . ' AND ' . $schedule_ids;
        $field = '`scheduleid`,`homewin`,`guestwin`,`homewin_f`,`guestwin_f`';
        $odds_euro = $this->eu_db->select($where, $field);

        if ($odds_euro) {
            foreach ($odds_euro as $odds) {
                $odds['return'] = round(1 / (1 + $odds['homewin'] / $odds['guestwin']) * 100 * $odds['homewin'], 2);
                $odds['return_f'] = round(1 / (1 + $odds['homewin_f'] / $odds['guestwin_f']) * 100 * $odds['homewin'], 2);
                $live_schedule[$odds['scheduleid']] = array_merge($live_schedule[$odds['scheduleid']], $odds);
            }
        }

        #-------------赛事选择------------
        $sclass = [];

        foreach ($live_schedule as $schedule) {
            $sclass[$schedule['sclassid']] = $schedule['sclassname_cn'];
        }

         include template('wap', 'bt_odds');
    }

    //赛程赛果
    public function sclass_schedule(){
        //联赛ID(标识1 NBA、2 WNBA、 3 CBA)
        $sclassid = isset($_GET['sclassid']) ? (int)$_GET['sclassid'] : 1;
        $where = '`sclassid`=' . $sclassid;
        $sclass_info = $this->sclass_db->get_one($where);
        //seo
        $SEO['title'] = ' 篮球赛程赛果_篮球即时比分网';
        $SEO['keyword'] = '篮球比分网';
        $SEO['description'] = '399彩迷网提供最全的NBA完场比分、最为详细的篮球比分查询，即时为彩民提供篮球完场比分数据。';
        //赛季
        $season_arr = $this->_season_info($sclassid);
        $season = $_REQUEST['season'] ? $_REQUEST['season'] : $season_arr[0];
        $where .= ' AND `sclasscategory`<>0 AND `sclassseason`="' . $season . '"';
        $field = '`scheduleid`,`sclassid`,`date`,`hometeamid`,`homename_cn`,`guestteamid`,`guestname_cn`,`homescore`,`guestscore`,`homeone`,`hometwo`,`guestone`,`guesttwo`,`sclassseason`,`sclasscategory`,`category`,`subcategory`';
        //基本信息
        $raw = $this->schedule_db->select($where, $field, '', '', '', 'scheduleid');
        if (count($raw)) {
            $info = $team_arr = $category_arr = array();
            $schedule_ids = array_keys($raw);
            $season_arr = array_unique(array_column($raw, 'sclassseason'));
            $group = $this->arr_sclasscategory;
            //中文日期
            $date_replace = array(
                array('(1)', '(2)', '(3)', '(4)', '(5)', '(6)', '(7)'),
                array('一', '二', '三', '四', '五', '六', '日')
            );
            //整合数据
            foreach ($raw as $key => $value) {
                //球队信息
                $team_arr[$value['hometeamid']] = $value['homename_cn'];
                $team_arr[$value['guestteamid']] = $value['guestname_cn'];
                //分组
                $date = str_replace($date_replace[0], $date_replace[1], date('Y-m-d 星期(N)', $value['date']));
               
                $info[$value['sclasscategory']][$date][] = $value;

                //类别整理
//                if ($value['category']) {
//                    $category_arr[$value['sclasscategory']][$value['category']][] = $value['subcategory'];
//                }


            }
            
            //按日期排序
            foreach ($info as &$_info) {
                ksort($_info);
            }
        }
        include template('wap', 'bt_sclass_schedule');
    }

    //积分排名
    public function sclass_standings() {
        
        //联赛ID(标识1 NBA、2 WNBA、 3 CBA)
        $sclassid = isset($_GET['sclassid']) ? (int)$_GET['sclassid'] : 1;
        $where = '`sclassid`=' . $sclassid;
        //seo
        $SEO['title'] = ' 篮球积分排名_篮球即时比分网';
        $SEO['keyword'] = '篮球比分网';
        $SEO['description'] = '399彩迷网提供最全的NBA完场比分、最为详细的篮球比分查询，即时为彩民提供篮球完场比分数据。';
        //赛季
        $season_arr = $this->_season_info($sclassid);
        $season = str_replace('赛季', '', ($_REQUEST['season'] ? $_REQUEST['season'] : $season_arr[0]));
        $where .= $season ? ' AND `season`="' . $season . '"' : '';
        $standings_info = $this->standings_db->standings($where);
        include template('wap', 'bt_sclass_standings');
    }

    //球队技术统计
    public function sclass_technic_team(){
              //联赛ID(标识1 NBA、2 WNBA、 3 CBA)
        $sclassid = isset($_GET['sclassid']) ? (int)$_GET['sclassid'] : 1;
        //联赛信息
        $sclass_info = $this->sclass_db->get_one(['sclassid' => $sclassid]);

        //seo
        $SEO['title'] = ' 篮球积球队技术统计_篮球即时比分网';
        $SEO['keyword'] = '篮球比分网';
        $SEO['description'] = '399彩迷网提供最全的NBA完场比分、最为详细的篮球比分查询，即时为彩民提供篮球完场比分数据。';

        if (strpos($sclass_info['currseason'], '-') !== false) {
            $tmp_arr = explode('-', $sclass_info['currseason']);
            $sclass_info['season'] = '20' . $tmp_arr[0] . '-20' . $tmp_arr[1];
            $season = $sclass_info['currseason'] . '赛季';
        } else {
            $sclass_info['season'] = '20' . $sclass_info['currseason'];
            $season = $sclass_info['currseason'] . '   赛季';
        }

        #---------------------当前赛季----------------
        $sql = "SELECT a.*,
                  b.homename_cn,
                  b.guestname_cn,
                  b.sclasscategory AS `cat`
                FROM bt_team_technic a
                INNER JOIN bt_schedule b ON a.scheduleid = b.scheduleid
                WHERE b.sclassid = '$sclassid' AND b.sclassseason = '$season'";

        $rst = $this->technic_db->query($sql);
        $raw = $this->technic_db->fetch_array($rst, MYSQLI_ASSOC);

        //联盟阶段
        $cat_arr = [
            0 => '全部',
            1 => '季前赛',
            2 => '常规赛',
            3 => '季后赛'
        ];

        $cat_now = []; //目前所有联盟阶段
        $stat = [];

        foreach ($raw as $r) {
            if (!$cat_now[$r['cat']]) {
                $cat_now[$r['cat']] = ['name' => $cat_arr[$r['cat']]];
            }

            $tmp = $stat[$r['cat']][$r['teamid']];

            if ($tmp) {
                $tmp['total'] += 1;
                $tmp['score'] += $r['score'];
                $tmp['lossscore'] += $r['lossscore'];
                $tmp['shoot'] += $r['shoot'];
                $tmp['shoot_hit'] += $r['shoot_hit'];
                $tmp['threemin'] += $r['threemin'];
                $tmp['threemin_hit'] += $r['threemin_hit'];
                $tmp['punishball'] += $r['punishball'];
                $tmp['punishball_hit'] += $r['punishball_hit'];
                $tmp['attack'] += $r['attack']; //进攻篮板
                $tmp['defend'] += $r['defend']; //防守篮板
                $tmp['helpattack'] += $r['helpattack'];
                $tmp['cover'] += $r['cover'];
                $tmp['rob'] += $r['rob'];
                $tmp['misplay'] += $r['misplay'];
                $tmp['foul'] += $r['foul'];
            } else {
                $tmp['teamid'] = $r['teamid'];
                $tmp['teamname'] = $r['ishome'] ? $r['homename_cn'] : $r['guestname_cn'];
                $tmp['total'] = 1;
                $tmp['score'] = $r['score'];
                $tmp['lossscore'] = $r['lossscore'];
                $tmp['shoot'] = $r['shoot'];
                $tmp['shoot_hit'] = $r['shoot_hit'];
                $tmp['threemin'] = $r['threemin'];
                $tmp['threemin_hit'] = $r['threemin_hit'];
                $tmp['punishball'] = $r['punishball'];
                $tmp['punishball_hit'] = $r['punishball_hit'];
                $tmp['attack'] = $r['attack']; //进攻篮板
                $tmp['defend'] = $r['defend']; //防守篮板
                $tmp['helpattack'] = $r['helpattack'];
                $tmp['cover'] = $r['cover'];
                $tmp['rob'] = $r['rob'];
                $tmp['misplay'] = $r['misplay'];
                $tmp['foul'] = $r['foul'];
            }

            $stat[$r['cat']][$r['teamid']] = $tmp;
        }

        foreach ($stat as $cat => &$team_info) {
            foreach ($team_info as $teamid => &$r) {
                $r['avg_score'] = round($r['score'] / $r['total'], 1);
                $r['avg_lossscore'] = round($r['lossscore'] / $r['total'], 1);
                $r['shoot_hit_rate'] = (round($r['shoot_hit'] / $r['shoot'], 3) * 100) . '%';
                $r['threemin_hit_rate'] = (round($r['threemin_hit'] / $r['threemin'], 3) * 100) . '%';
                $r['punishball_hit_rate'] = (round($r['punishball_hit'] / $r['punishball'], 3) * 100) . '%';
                $r['avg_attack_defend'] = round(($r['attack'] + $r['defend']) / $r['total'], 1);
                $r['avg_helpattack'] = round($r['helpattack'] / $r['total'], 1);
                $r['avg_cover'] = round($r['cover'] / $r['total'], 1);
                $r['avg_rob'] = round($r['rob'] / $r['total'], 1);
                $r['avg_misplay'] = round($r['misplay'] / $r['total'], 1);
                $r['avg_foul'] = round($r['foul'] / $r['total'], 1);
            }
        }
        unset($r);
        foreach ($cat_now as &$r) {
            $r['style'] = 'active';
            break;
        }

        unset($r);

        include template('wap', 'bt_sclass_technic_team');
    }

    //球员技术统计
    public function sclass_technic_player() {
      //联赛ID(标识1 NBA、2 WNBA、 3 CBA)
        $sclassid = isset($_GET['sclassid']) ? (int)$_GET['sclassid'] : 1;
        //联赛信息
        $sclass_info = $this->sclass_db->get_one(['sclassid' => $sclassid]);

        //seo
        $SEO['title'] = ' 篮球球员技术统计_篮球即时比分网';
        if (strpos($sclass_info['currseason'], '-') !== false) {
            $tmp_arr = explode('-', $sclass_info['currseason']);
            $sclass_info['season'] = '20' . $tmp_arr[0] . '-20' . $tmp_arr[1];
            $season = $sclass_info['currseason'] . '赛季';
        } else {
            $sclass_info['season'] = '20' . $sclass_info['currseason'];
            $season = $sclass_info['currseason'] . '   赛季';
        }

        #---------------------当前赛季----------------
        $sql = "SELECT a.*,
                  IF(a.score>=10,1,0) + IF(a.attack>=10,1,0) + IF(a.helpattack>=10,1,0) + IF(a.cover>=10,1,0) + IF(a.rob>=10,1,0) AS `tag`,
                  b.hometeamid,
                  b.homename_cn,
                  b.guestname_cn,
                  b.sclasscategory AS `cat`
                FROM bt_player_technic a
                INNER JOIN bt_schedule b ON a.scheduleid = b.scheduleid
                WHERE b.sclassid = '$sclassid' AND b.sclassseason = '$season'";

        $rst = $this->technic_db->query($sql);
        $raw = $this->technic_db->fetch_array($rst, MYSQLI_ASSOC);

        //球员信息
        $where = to_sqls(array_column($raw, 'playerid'), '', '`playerid`');
        $player_info = $this->player_db->select($where, '`playerid`,`name_cn`', '', '', '', 'playerid');

        //联盟阶段
        $cat_arr = [
            0 => '全部',
            1 => '季前赛',
            2 => '常规赛',
            3 => '季后赛'
        ];

        $cat_now = []; //目前所有联盟阶段
        $stat = [];

        foreach ($raw as $r) {
            if (!$cat_now[$r['cat']]) {
                $cat_now[$r['cat']] = ['name' => $cat_arr[$r['cat']]];
            }

            $tmp = $stat[$r['cat']][$r['playerid']];

            if ($tmp) {
                $tmp['total'] += 1;
                $tmp['score'] += $r['score'];
                $tmp['shoot'] += $r['shoot'];
                $tmp['shoot_hit'] += $r['shoot_hit'];
                $tmp['threemin'] += $r['threemin'];
                $tmp['threemin_hit'] += $r['threemin_hit'];
                $tmp['punishball'] += $r['punishball'];
                $tmp['punishball_hit'] += $r['punishball_hit'];
                $tmp['attack'] += $r['attack']; //进攻篮板
                $tmp['defend'] += $r['defend']; //防守篮板
                $tmp['helpattack'] += $r['helpattack'];
                $tmp['cover'] += $r['cover'];
                $tmp['rob'] += $r['rob'];
                $tmp['misplay'] += $r['misplay'];
                $tmp['foul'] += $r['foul'];
                $tmp['double_2'] += (int) $r['tag'] === 2 ? 1 : 0; //两双
                $tmp['double_3'] += (int) $r['tag'] === 3 ? 1 : 0; //三双
            } else {
                $tmp['playerid'] = $r['playerid'];
                $tmp['playername'] = $player_info[$r['playerid']]['name_cn'];
                $tmp['teamid'] = $r['teamid'];
                $tmp['teamname'] = $r['teamid'] === $r['hometeamid'] ? $r['homename_cn'] : $r['guestname_cn'];
                $tmp['total'] = 1;
                $tmp['score'] = $r['score'];
                $tmp['shoot'] = $r['shoot'];
                $tmp['shoot_hit'] = $r['shoot_hit'];
                $tmp['threemin'] = $r['threemin'];
                $tmp['threemin_hit'] = $r['threemin_hit'];
                $tmp['punishball'] = $r['punishball'];
                $tmp['punishball_hit'] = $r['punishball_hit'];
                $tmp['attack'] = $r['attack']; //进攻篮板
                $tmp['defend'] = $r['defend']; //防守篮板
                $tmp['helpattack'] = $r['helpattack'];
                $tmp['cover'] = $r['cover'];
                $tmp['rob'] = $r['rob'];
                $tmp['misplay'] = $r['misplay'];
                $tmp['foul'] = $r['foul'];
                $tmp['double_2'] = (int) $r['tag'] === 2 ? 1 : 0; //两双
                $tmp['double_3'] = (int) $r['tag'] === 3 ? 1 : 0; //三双
            }

            $stat[$r['cat']][$r['playerid']] = $tmp;
        }

        foreach ($stat as $cat => &$team_info) {
            foreach ($team_info as $teamid => &$r) {
                $r['avg_score'] = round($r['score'] / $r['total'], 1);
                $r['shoot_hit_rate'] = (round($r['shoot_hit'] / $r['shoot'], 3) * 100) . '%';
                $r['threemin_hit_rate'] = (round($r['threemin_hit'] / $r['threemin'], 3) * 100) . '%';
                $r['punishball_hit_rate'] = (round($r['punishball_hit'] / $r['punishball'], 3) * 100) . '%';
                $r['attack_defend'] = $r['attack'] + $r['defend'];
                $r['avg_attack_defend'] = round(($r['attack'] + $r['defend']) / $r['total'], 1);
                $r['avg_helpattack'] = round($r['helpattack'] / $r['total'], 1);
                $r['avg_cover'] = round($r['cover'] / $r['total'], 1);
                $r['avg_rob'] = round($r['rob'] / $r['total'], 1);
                $r['avg_misplay'] = round($r['misplay'] / $r['total'], 1);
                $r['avg_foul'] = round($r['foul'] / $r['total'], 1);
            }
        }

        unset($r);

        foreach ($cat_now as &$r) {
            $r['style'] = 'active';
            break;
        }

        unset($r);

        include template('wap', 'bt_sclass_technic_player');
    }


    //比赛：数据分析
    public function schedule_analyse(){
          if (!$_GET['scheduleid']) {
            showmessage(L('schedule_not_exists'), 'blank');
        }

        //比赛信息
        $sclassid = $_GET['scheduleid'];
        $scheduleData = $this->db->get_one('scheduleid=' . $sclassid, '*', 'scheduleid DESC');
        if (empty($scheduleData)) {
            showmessage(L('schedule_not_exists'), 'blank');
        }
        //seo
        $SEO['title'] = $scheduleData['homename_cn'] . '队 VS ' . $scheduleData['guestname_cn'] . '队_篮球数据统计分析';
        $SEO['keyword'] = $scheduleData['homename_cn'] . '队 VS ' . $scheduleData['guestname_cn'] . '队，篮球数据统计分析';
        $SEO['description'] = '399彩迷网提供权威的NBA数据分析,世界篮球联赛排名，以及为您直观的统计NBA战绩,篮球数据统计分析。';

        $scheduleDataDetail = $this->schedule_db->get_one('scheduleid=' . $sclassid, '*', 'scheduleid DESC');

        if (!empty($scheduleDataDetail)) {
            $scheduleData['stadium'] = $scheduleDataDetail['stadium'];
            $scheduleData['sclassseason'] = $scheduleDataDetail['sclassseason'];
        }

        if (empty($scheduleData)) {
            showmessage(L('schedule_not_exists'), 'blank');
        }
        $scheduleData['status_cn'] = $this->status_arr[$scheduleData['status']];
        $scheduleData['sclasscategory_cn'] = $this->arr_sclasscategory[2];
        $scheduleData['homehalfscore'] = $scheduleData['homeone'] + $scheduleData['hometwo'];
        $scheduleData['guesthalfscore'] = $scheduleData['guestone'] + $scheduleData['guesttwo'];

        // 联赛
        $sclassData = $this->sclass_db->get_one('sclassid=' . $scheduleData['sclassid']);
        $hometeamid = $scheduleData['hometeamid'];
        $guestteamid = $scheduleData['guestteamid'];

        // 联赛积分排名
        $homeScheduleArr = $this->getRank($hometeamid, $guestteamid, $scheduleData['sclassseason']);
        // 以往战绩
        $beforeSchedule = $this->getBeforeSchedule($hometeamid, $guestteamid);
        // 近期战绩
        $recentSchedule = $this->getRecentSchedule($hometeamid, $guestteamid);
         // 让分盘路比较
        $letCompare = $this->getCompare($recentSchedule, $hometeamid, $guestteamid);
   
         include template('wap', 'bt_schedule_analyse');
    }

    //比赛：让分
    public function schedule_asia() {
        
        $sclassid = $_GET['scheduleid'];
        if (!$sclassid) {
            showmessage('参数传递有误');
        }
        //状态
        $arr_status = $this->status_arr;
        //比赛信息
        $schedule_info = $this->_schedule_info($sclassid);
        //seo
        $SEO['title'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队_让分赔率比较_篮球初盘分析_即时数据分析_历史资料';
        $SEO['keyword'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队，让分赔率比较,篮球初盘分析,即时数据分析,历史资料';
        $SEO['description'] = '399彩迷网提供让分赔率比较,蓝球历史资料，精心为您分析篮球初盘分析,即时数据分析等数据分析。';
        //让分赔率公司
        $company = $this->company_db->select('`kind`=1', '`companyid`,`name`', '', '', '', 'companyid');
        //让球初盘，即时盘
        $let_goal = $this->let_db->select('`scheduleid`=' . $sclassid . ' AND `companyid` IN (' . join(',', array_keys($company)) . ')', '`scheduleid`,`companyid`,`letgoal_f`,`homeodds_f`,`guestodds_f`,`letgoal`,`homeodds`,`modifytime`,`guestodds`');
        //让球变化
//        $let_goal_detail = $this->let_detail_db->select('`scheduleid`=' . $schedule_id . ' AND `companyid` IN (' . join(',', array_keys($company)) . ') AND `type` IN (6,7)', '`scheduleid`,`companyid`,`letgoal`,`homeodds`,`guestodds`,`modifytime`,`type`', '', '`modifytime` DESC');
         include template('wap', 'bt_schedule_asia');
    }

    //比赛：总分
    public function schedule_ou(){
        $sclassid = $_REQUEST['scheduleid'];

        if (!$sclassid) {
            showmessage('参数传递有误');
        }

        //状态
        $arr_status = $this->status_arr;
        //比赛信息
        $schedule_info = $this->_schedule_info($sclassid);
        //seo
        $SEO['title'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队_蓝球总分盘_初盘分析_篮球即时数据比较';
        $SEO['keyword'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队，篮球总分盘,初盘分析,篮球即时数据比较';
        $SEO['description'] = '查看篮球总分盘，上399彩迷网，专业为您提供权威的NBA初盘分析,篮球即时数据比较等篮球数据分析查看等。';
        //总分赔率公司
        $company = $this->company_db->select('`kind`=2', '`companyid`,`name`', '', '', '', 'companyid');
        //总分初盘，即时盘
        $totalscore = $this->total_db->select('`scheduleid`=' . $sclassid . ' AND `companyid` IN (' . join(',', array_keys($company)) . ')', '`scheduleid`,`companyid`,`totalscore_f`,`highodds_f`,`lowodds_f`,`totalscore`,`highodds`,`lowodds`,`modifytime`');
        //总分变化
//        $totalscore_detail = $this->total_detail_db->select('`scheduleid`=' . $schedule_id . ' AND `companyid` IN (' . join(',', array_keys($company)) . ') AND `type` IN (6,7)', '`scheduleid`,`companyid`,`totalscore`,`highodds`,`lowodds`,`modifytime`,`type`', '', '`modifytime` DESC');
         include template('wap', 'bt_schedule_ou');
    }

    //比赛：欧赔
    public function schedule_euro() {
        $sclassid = $_GET['scheduleid'];
        if (!$sclassid) {
            showmessage('参数传递有误');
        }
        //状态
        $arr_status = $this->status_arr;
        //比赛信息
        $schedule_info = $this->_schedule_info($sclassid);
        //seo
        $SEO['title'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队_蓝球欧赔分析_凯利指数分析_返还率分析';
        $SEO['keyword'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队，篮球欧赔分析,凯利指数分析,返还率分析';
        $SEO['description'] = '399彩迷网为您提供精准的篮球欧赔分析,凯利指数分析,篮球返还率分析等相关的篮球数据分析。';
        //欧赔公司
        $company = $this->eu_company_db->select('', '`companyid`,`name_cn`', '', '', '', 'companyid');
        //初盘，即时盘
        $euro = $this->eu_db->select('`scheduleid`=' . $sclassid, '*', '', '', '', 'companyid');
        //赔率变化
        $euro_detail = $this->eu_detail_db->select('`scheduleid`=' . $sclassid, '*', '', '`modifytime` DESC');

        //整理即时盘数据
        if (count($euro)) {
            $homewin_f = array_column($euro, 'homewin_f');
            $guestwin_f = array_column($euro, 'guestwin_f');
            $homewin = array_column($euro, 'homewin');
            $guestwin = array_column($euro, 'guestwin');
            $probability_hf = array_column($euro, 'probability_h0');
            $probability_gf = array_column($euro, 'probability_g0');
            $probability_tf = array_column($euro, 'probability_t0');
            $probability_h = array_column($euro, 'probability_h1');
            $probability_g = array_column($euro, 'probability_g1');
            $probability_t = array_column($euro, 'probability_t1');
            //最大值
            $max_odds = array(
                'homewin' => max($homewin),
                'homewin_f' => max($homewin_f),
                'homewin_trend' => max($homewin) - max($homewin_f),
                'guestwin' => max($guestwin),
                'guestwin_f' => max($guestwin_f),
                'guestwin_trend' => max($guestwin) - max($guestwin_f),
                'probability_h' => max($probability_h),
                'probability_g' => max($probability_g),
                'probability_t' => max($probability_t),
                'probability_hf' => max($probability_hf),
                'probability_gf' => max($probability_gf),
                'probability_tf' => max($probability_tf),
            );
            //最小值
            $min_odds = array(
                'homewin' => min($homewin),
                'homewin_f' => min($homewin_f),
                'homewin_trend' => min($homewin) - min($homewin_f),
                'guestwin' => min($guestwin),
                'guestwin_f' => min($guestwin_f),
                'guestwin_trend' => min($guestwin) - min($guestwin_f),
                'probability_h' => min($probability_h),
                'probability_g' => min($probability_g),
                'probability_t' => min($probability_t),
                'probability_hf' => min($probability_hf),
                'probability_gf' => min($probability_gf),
                'probability_tf' => min($probability_tf),
            );
            //平均值
            $avg_odds = array(
                'homewin' => avg($homewin),
                'homewin_f' => avg($homewin_f),
                'homewin_trend' => avg($homewin) - avg($homewin_f),
                'guestwin' => avg($guestwin),
                'guestwin_f' => avg($guestwin_f),
                'guestwin_trend' => avg($guestwin) - avg($guestwin_f),
                'probability_h' => avg($probability_h),
                'probability_g' => avg($probability_g),
                'probability_t' => avg($probability_t),
                'probability_hf' => avg($probability_hf),
                'probability_gf' => avg($probability_gf),
                'probability_tf' => avg($probability_tf),
            );
            //计算凯利指数
            $max_odds['kelly_h'] = get_kelly($max_odds['homewin'], $max_odds['probability_h']);
            $max_odds['kelly_g'] = get_kelly($max_odds['guestwin'], $max_odds['probability_g']);
            $min_odds['kelly_h'] = get_kelly($min_odds['homewin'], $min_odds['probability_h']);
            $min_odds['kelly_g'] = get_kelly($min_odds['guestwin'], $min_odds['probability_g']);
            $avg_odds['kelly_h'] = get_kelly($avg_odds['homewin'], $avg_odds['probability_h']);
            $avg_odds['kelly_g'] = get_kelly($avg_odds['guestwin'], $avg_odds['probability_g']);
            //开盘的公司
            $company_list = array();
            foreach ($euro as $value) {
                if (!in_array($value['companyid'], $company_list)) {
                    $company_list[] = $value['companyid'];
                } else {
                    continue;
                }
            }
        }

        //整理赔率变化数据
        if (count($euro_detail) && isset($avg_odds['probability_h']) && isset($avg_odds['probability_g'])) {
            foreach ($euro_detail as &$value) {
                //赔率公司的初盘
                $first = $euro[$value['companyid']];
                $value['homewin_f'] = $first['homewin_f'];
                $value['guestwin_f'] = $first['guestwin_f'];
                $value['probability_hf'] = $first['probability_h0'];
                $value['probability_gf'] = $first['probability_g0'];
                $value['probability_tf'] = $first['probability_t0'];
                //凯利指数
                $value['kelly_h'] = get_kelly($value['homewin'], $avg_odds['probability_h']);
                $value['kelly_g'] = get_kelly($value['guestwin'], $avg_odds['probability_g']);
                //变化趋势
                $value['homewin_trend'] = $value['homewin'] - $value['homewin_f'];
                $value['guestwin_trend'] = $value['guestwin'] - $value['guestwin_f'];
            }
        }

         include template('wap', 'bt_schedule_euro');
    }

    //获取联赛赛季
    private function _season_info($sclass_id)
    {
        return array_column($this->schedule_db->select('`sclassid`=' . $sclass_id, 'DISTINCT `sclassseason`', '', '`sclassseason`'), 'sclassseason');
    }

    private function getRank($hometeamid, $guestteamid, $sclassseason)
    {
        $homeWhere = '(hometeamid=' . $hometeamid . ' OR ' . 'guestteamid=' . $hometeamid . ') AND status=-1';
        $guestWhere = '(hometeamid=' . $guestteamid . ' OR ' . 'guestteamid=' . $guestteamid . ') AND status=-1';

        if (!empty($sclassseason)) {
            $homeWhere .= ' AND sclassseason="' . $sclassseason . '"';
            $guestWhere .= ' AND sclassseason="' . $sclassseason . '"';
        }

        $homeScheduleData = $this->schedule_db->select(
            $homeWhere, '*', 100, 'date DESC'
        );

        $guestScheduleData = $this->schedule_db->select(
            $guestWhere, '*', 100, 'date DESC'
        );

        $homeScheduleArr = [];
        $rankDataArr = [
            $homeScheduleData,
            $homeScheduleData,
            $guestScheduleData,
            $guestScheduleData,
        ];

        foreach ($rankDataArr as $id => $rankData) {
            if ($id < 2) {
                $homeId = $hometeamid;
            } else {
                $homeId = $guestteamid;
            }

            if ($id % 2 == 0) {
                foreach ($rankData as $key => $item) {
                    if ($homeId == $item['hometeamid']) {
                        // 主-赛
                        $homeScheduleArr[$id][1][0] += 1;

                        if ((int)$item['homescore'] > (int)$item['guestscore']) {
                            $homeScheduleArr[$id][1][1] += 1; // 主场-胜
                        } else {
                            $homeScheduleArr[$id][1][2] += 1; // 主场-负
                        }

                        $homeScheduleArr[$id][1][3] += $item['homescore'];  // 主场-得
                        $homeScheduleArr[$id][1][4] += $item['guestscore']; // 主场-失
                    } elseif ($homeId == $item['guestteamid']) {
                        // 客-赛
                        $homeScheduleArr[$id][2][0] += 1;

                        if ((int)$item['homescore'] < (int)$item['guestscore']) {
                            $homeScheduleArr[$id][2][1] += 1; // 客场-胜
                        } else {
                            $homeScheduleArr[$id][2][2] += 1; // 客场-负
                        }

                        $homeScheduleArr[$id][2][3] += $item['guestscore']; // 客场-得
                        $homeScheduleArr[$id][2][4] += $item['homescore']; // 客场-失
                    }
                    // 前六场
                    if ($key <= 5) {
                        if ($homeId == $item['hometeamid']) {
                            if ((int)$item['homescore'] > (int)$item['guestscore']) {
                                $homeScheduleArr[$id][3][1] += 1; // 胜
                            } else {
                                $homeScheduleArr[$id][3][2] += 1; // 负
                            }

                            $homeScheduleArr[$id][3][3] += $item['homescore'];  // 得
                            $homeScheduleArr[$id][3][4] += $item['guestscore']; // 失
                        } elseif ($homeId == $item['guestteamid']) {
                            if ((int)$item['homescore'] < (int)$item['guestscore']) {
                                $homeScheduleArr[$id][3][1] += 1; // 胜
                            } else {
                                $homeScheduleArr[$id][3][2] += 1; // 负
                            }

                            $homeScheduleArr[$id][3][3] += $item['guestscore'];  // 得
                            $homeScheduleArr[$id][3][4] += $item['homescore']; // 失
                        }
                    }
                }
            } else { // 半场
                foreach ($rankData as $key => $item) {
                    $homeHalfScore = $item['homeone'] + $item['hometwo'];
                    $guestHalfScore = $item['guestone'] + $item['guesttwo'];

                    if ($homeId == $item['hometeamid']) {
                        // 主-赛
                        $homeScheduleArr[$id][1][0] += 1;

                        if ((int)$homeHalfScore > (int)$guestHalfScore) {
                            $homeScheduleArr[$id][1][1] += 1; // 主场-胜
                        } elseif ((int)$homeHalfScore < (int)$guestHalfScore) {
                            $homeScheduleArr[$id][1][2] += 1; // 主场-负
                        }

                        $homeScheduleArr[$id][1][3] += $homeHalfScore;  // 主场-得
                        $homeScheduleArr[$id][1][4] += $guestHalfScore; // 主场-失
                    } elseif ($homeId == $item['guestteamid']) {
                        // 客-赛
                        $homeScheduleArr[$id][2][0] += 1;

                        if ((int)$homeHalfScore < (int)$guestHalfScore) {
                            $homeScheduleArr[$id][2][1] += 1; // 客场-胜
                        } elseif ((int)$homeHalfScore > (int)$guestHalfScore) {
                            $homeScheduleArr[$id][2][2] += 1; // 客场-负
                        }

                        $homeScheduleArr[$id][2][3] += $guestHalfScore; // 客场-得
                        $homeScheduleArr[$id][2][4] += $homeHalfScore; // 客场-失
                    }
                    // 前六场
                    if ($key <= 5) {
                        if ($homeId == $item['hometeamid']) {
                            if ((int)$homeHalfScore > (int)$guestHalfScore) {
                                $homeScheduleArr[$id][3][1] += 1; // 胜
                            } elseif ((int)$homeHalfScore < (int)$guestHalfScore) {
                                $homeScheduleArr[$id][3][2] += 1; // 负
                            }

                            $homeScheduleArr[$id][3][3] += $homeHalfScore;  // 得
                            $homeScheduleArr[$id][3][4] += $guestHalfScore; // 失
                        } elseif ($homeId == $item['guestteamid']) {
                            if ((int)$homeHalfScore < (int)$guestHalfScore) {
                                $homeScheduleArr[$id][3][1] += 1; // 胜
                            } elseif ((int)$homeHalfScore > (int)$guestHalfScore) {
                                $homeScheduleArr[$id][3][2] += 1; // 负
                            }

                            $homeScheduleArr[$id][3][3] += $guestHalfScore;  // 得
                            $homeScheduleArr[$id][3][4] += $homeHalfScore; // 失
                        }
                    }
                }
            }


            // 近6场
            $homeScheduleArr[$id][3][0] = $homeScheduleArr[$id][3][1] + $homeScheduleArr[$id][3][2];
            $homeScheduleArr[$id][3][3] = round($homeScheduleArr[$id][3][3] / $homeScheduleArr[$id][3][0], 1);
            $homeScheduleArr[$id][3][4] = round($homeScheduleArr[$id][3][4] / $homeScheduleArr[$id][3][0], 1);
            $homeScheduleArr[$id][3][6] = '';

            // 全场-总-胜
            $homeScheduleArr[$id][0][1] = $homeScheduleArr[$id][1][1] + $homeScheduleArr[$id][2][1];
            // 全场-总-负
            $homeScheduleArr[$id][0][2] = $homeScheduleArr[$id][1][2] + $homeScheduleArr[$id][2][2];
            // 赛-总
            $homeScheduleArr[$id][0][0] = ($homeScheduleArr[$id][1][0] + $homeScheduleArr[$id][2][0]);

            // 全场-总-得
            $homeScheduleArr[$id][0][3] = round(($homeScheduleArr[$id][1][3] + $homeScheduleArr[$id][2][3]) / $homeScheduleArr[$id][0][0], 1);
            $homeScheduleArr[$id][0][4] = round(($homeScheduleArr[$id][1][4] + $homeScheduleArr[$id][2][4]) / $homeScheduleArr[$id][0][0], 1);
            $homeScheduleArr[$id][1][3] = round($homeScheduleArr[$id][1][3] / $homeScheduleArr[$id][1][0], 1);
            $homeScheduleArr[$id][1][4] = round($homeScheduleArr[$id][1][4] / $homeScheduleArr[$id][1][0], 1);
            // 全场-总-失

            $homeScheduleArr[$id][2][3] = round($homeScheduleArr[$id][2][3] / $homeScheduleArr[$id][2][0], 1);
            $homeScheduleArr[$id][2][4] = round($homeScheduleArr[$id][2][4] / $homeScheduleArr[$id][2][0], 1);

            // 净
            $homeScheduleArr[$id][1][5] = round($homeScheduleArr[$id][1][3] - $homeScheduleArr[$id][1][4], 1);
            $homeScheduleArr[$id][2][5] = round($homeScheduleArr[$id][2][3] - $homeScheduleArr[$id][2][4], 1);
            $homeScheduleArr[$id][0][5] = round($homeScheduleArr[$id][0][3] - $homeScheduleArr[$id][0][4], 1);
            $homeScheduleArr[$id][3][5] = round($homeScheduleArr[$id][3][3] - $homeScheduleArr[$id][3][4], 1);

            // 胜率
            $homeScheduleArr[$id][1][7] = round($homeScheduleArr[$id][1][1] / $homeScheduleArr[$id][1][0], 3) * 100 . '%';
            $homeScheduleArr[$id][2][7] = round($homeScheduleArr[$id][2][1] / $homeScheduleArr[$id][2][0], 3) * 100 . '%';
            $homeScheduleArr[$id][0][7] = round($homeScheduleArr[$id][0][1] / $homeScheduleArr[$id][0][0], 3) * 100 . '%';
            $homeScheduleArr[$id][3][7] = round($homeScheduleArr[$id][3][1] / $homeScheduleArr[$id][3][0], 3) * 100 . '%';

            ksort($homeScheduleArr[$id]);
        }

        $homeRank = $this->standings_db->get_one('teamid=' . $hometeamid);
        $guestRank = $this->standings_db->get_one('teamid=' . $guestteamid);
        //var_dump($guestRank);die();
        $homeScheduleArr[0][0][6] = $homeRank['totalrank'];
        $homeScheduleArr[0][1][6] = $homeRank['homerank'];
        $homeScheduleArr[0][2][6] = $homeRank['guestrank'];

        $homeScheduleArr[2][0][6] = $guestRank['totalrank'];
        $homeScheduleArr[2][1][6] = $guestRank['homerank'];
        $homeScheduleArr[2][2][6] = $guestRank['guestrank'];

        return $homeScheduleArr;
    }

    private function getBeforeSchedule($hometeamid, $guestteamid)
    {
        $matchResult = [0, 0, 0, 0, 0, 0, 0];
        $sclassData = $this->schedule_db->select('((hometeamid=' . $hometeamid . ' AND guestteamid=' . $guestteamid .
            ') OR (hometeamid=' . $guestteamid . ' AND guestteamid=' . $hometeamid . ')) AND status=-1', '*', 20, 'date DESC');


        $matchResult[2] = round($matchResult[1] / $matchResult[0], 1) * 100 . '%';

        foreach ($sclassData as $key => $item) {
            $scheduleIdArr[] = (int)$item['scheduleid'];
            $matchResult[0] += 1;

            if ((int)$item["homescore"] > (int)$item["guestscore"]) {
                $sclassData[$key]['result'] = '胜';
            } else {
                $sclassData[$key]['result'] = '负';
            }

            $sclassData[$key]['homehalfscore'] = $item['homeone'] + $item['hometwo'];
            $sclassData[$key]['guesthalfscore'] = $item['guestone'] + $item['guesttwo'];
            $sclassData[$key]['poor'] = $item['homescore'] - $item['guestscore'];
            $sclassData[$key]['total_points'] = $item['homescore'] + $item['guestscore'];
        }

        // 让分
        $scheduleidIn = to_sqls($scheduleIdArr, '', 'scheduleid');

        if (empty($scheduleidIn)) {
            return '';
        }

        $letdbData = $this->let_db->select($scheduleidIn . ' AND companyid=3');
        // 大小分
        $totalscoreData = $this->total_db->select($scheduleidIn . ' AND companyid=6');

        foreach ($letdbData as $item) {
            $letdb[$item['scheduleid']] = $item;
        }

        foreach ($totalscoreData as $item) {
            $totalscore[$item['scheduleid']] = $item;
        }

        foreach ($sclassData as $key => $item) {
            $sclassData[$key]['letgoal'] = isset($letdb[$item['scheduleid']]) ? $letdb[$item['scheduleid']]['letgoal'] : '';
            $sclassData[$key]['totalscore'] = isset($totalscore[$item['scheduleid']]) ? $totalscore[$item['scheduleid']]['totalscore'] : '';
            $scoreMinute = (int)$item["homescore"] - (int)$item["guestscore"] - (int)$sclassData[$key]['letgoal'];

            if (!empty($sclassData[$key]['letgoal'])) {
                if (($hometeamid == $item['hometeamid'] && $scoreMinute > 0) || ($hometeamid == $item['guestteamid'] && $scoreMinute < 0)) {
                    $sclassData[$key]['let_plate'] = '赢';
                    $matchResult[5] += 1;
                } else {
                    $sclassData[$key]['let_plate'] = '输';
                }
            } else {
                $sclassData[$key]['let_plate'] = '';
            }

            if (!empty($sclassData[$key]['totalscore'])) {
                if ((int)$sclassData[$key]['total_points'] > (int)$sclassData[$key]['totalscore']) {
                    $sclassData[$key]['total_plate'] = '大';
                    $matchResult[6] += 1;
                } else {
                    $sclassData[$key]['total_plate'] = '小';
                }
            } else {
                $sclassData[$key]['total_plate'] = '';
            }
        }

        $matchResult[3] = round($matchResult[5] / $matchResult[0], 1) * 100 . '%';
        $matchResult[4] = round($matchResult[6] / $matchResult[0], 1) * 100 . '%';

        return ['match' => $matchResult, 'sclass' => $sclassData];
    }

    private function getRecentSchedule($hometeamid, $guestteamid)
    {
        $sclassData = $this->schedule_db->select('((hometeamid=' . $hometeamid . ' OR guestteamid=' . $hometeamid .
            ') OR (hometeamid=' . $guestteamid . ' OR guestteamid=' . $guestteamid . ')) AND status=-1', '*', 150, 'date DESC');

        foreach ($sclassData as $key => $item) {
            $scheduleIdArr[] = (int)$item['scheduleid'];

            $sclassData[$key]['homehalfscore'] = $item['homeone'] + $item['hometwo'];
            $sclassData[$key]['guesthalfscore'] = $item['guestone'] + $item['guesttwo'];
            $sclassData[$key]['poor'] = $item['homescore'] - $item['guestscore'];
            $sclassData[$key]['total_points'] = $item['homescore'] + $item['guestscore'];
        }

        // 让分
        $scheduleidIn = to_sqls($scheduleIdArr, '', 'scheduleid');
        $letdbData = $this->let_db->select($scheduleidIn . ' AND companyid=3');
        $scheduleData = [];

        foreach ($letdbData as $item) {
            $letdb[$item['scheduleid']] = $item;
        }

        // 大小分
        $totalscoreData = $this->total_db->select($scheduleidIn . ' AND companyid=6');

        foreach ($totalscoreData as $item) {
            $totalscore[$item['scheduleid']] = $item;
        }

        foreach ($sclassData as $key => $item) {
            $sclassData[$key]['letgoal'] = isset($letdb[$item['scheduleid']]) ? $letdb[$item['scheduleid']]['letgoal'] : '';
            // 大小分
            $sclassData[$key]['totalscore'] = isset($totalscore[$item['scheduleid']]) ? $totalscore[$item['scheduleid']]['totalscore'] : '';
        }

        foreach ($sclassData as $key => $item) {
            $scoreMinute = (int)$item["homescore"] - (int)$item["guestscore"] - (int)$item['letgoal'];

            if (!empty($item['letgoal'])) {
                if (($hometeamid == $item['hometeamid'] && $scoreMinute > 0) || ($hometeamid == $item['guestteamid'] && $scoreMinute < 0)) {
                    $item['let_plate'] = '赢';
                } else {
                    $item['let_plate'] = '输';
                }
            } else {
                $item['let_plate'] = '';
            }

            // 大小盘
            $totalMinus = (int)$item['total_points'] - (int)$item['totalscore'];

            if ($totalMinus > 0) {
                $item['total_result'] = '大';
            } elseif ($totalMinus < 0) {
                $item['total_result'] = '小';
            } else {
                $item['total_result'] = '走';
            }

            if ($item['hometeamid'] == $hometeamid || $item['guestteamid'] == $hometeamid) { // 主队(左)
                if (($item['hometeamid'] == $hometeamid && $item['poor'] > 0)
                    || ($item['guestteamid'] == $hometeamid && $item['poor'] < 0)
                ) {
                    $item['result'] = '胜';
                } else {
                    $item['result'] = '负';
                }

                $scheduleData['home'][] = $item;
            } elseif ($item['hometeamid'] == $guestteamid || $item['guestteamid'] == $guestteamid) { // 主队(右)
                if (($item['hometeamid'] == $guestteamid && $item['poor'] > 0)
                    || ($item['guestteamid'] == $guestteamid && $item['poor'] < 0)
                ) {
                    $item['result'] = '胜';
                } else {
                    $item['result'] = '负';
                }

                $scheduleData['guest'][] = $item;
            }
        }

        return $scheduleData;
    }

    /**
     * @param $recentSchedule
     * @param $hometeamid
     * @param $guestteamid
     * @param $isTotal int 1为大小分,0为让分
     * @return array
     */
    private function getCompare($recentSchedule, $hometeamid, $guestteamid, $isTotal = 0)
    {
        #---------------------------------------------------------------------------------------------------
        // 让分盘路比较
        /*
        全场
 	            赛	      赢盘	    走水	    输盘	       赢盘率
            总	38[0][0]  18[0][1]	2[0][2]	18[0][3]  47.4%[0][4]
            主	20[1][0]   8[1][1]	2[1][2]	10[1][3]  44.4%[1][4]
            客	18[2][0]  10[2][1]	0[2][2]	 8[2][3]  55.6%[2][4]
           近6场	 6[3][0] 	输 输 输 输 赢 输	          16.7%
        */
        $dataArr = [
            $recentSchedule['home'],
            $recentSchedule['home'],
            $recentSchedule['guest'],
            $recentSchedule['guest'],
        ];

        $scheduleIdArr1 = array_column($recentSchedule['home'], 'scheduleid');
        $scheduleIdArr2 = array_column($recentSchedule['guest'], 'scheduleid');
        $scheduleIdArr = array_unique(array_merge($scheduleIdArr1, $scheduleIdArr2));
        $scheduleidIn = to_sqls($scheduleIdArr, '', 'scheduleid');

        if (empty($scheduleidIn)) {
            return '';
        }

        if ($isTotal === 1) {
            $odds = $this->total_db->select($scheduleidIn . ' AND companyid=6');

            foreach ($odds as $item) {
                $oddsData[$item['scheduleid']] = $item;
            }
        } else {
            $odds = $this->let_db->select($scheduleidIn . ' AND companyid=3');

            foreach ($odds as $item) {
                $oddsData[$item['scheduleid']] = $item;
            }
        }

        $resultMapper = [
            ['<span class="red">赢</span> ', '<span class="orange">走</span> ', '<span class="green">输</span> '],
            ['<span class="red">大</span> ', '<span class="orange">走</span> ', '<span class="green">小</span> '],
        ];

        foreach ($dataArr as $id => $rankData) {
            $homeLetArr[$id] = [
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
            ];

            if ($id < 2) {
                $homeId = $hometeamid;
            } else {
                $homeId = $guestteamid;
            }

            if ($id % 2 == 0) {
                foreach ($rankData as $key => $item) {
                    $scheduleId = (int)$item['scheduleid'];
                    $oddsScore = $oddsData[$scheduleId]['letgoal'];

                    if ($isTotal === 1) {
                        $oddsScore = $oddsData[$scheduleId]['totalscore'];
                    }

                    //if (empty($letScore)) {
                    //    continue;
                    //}
                    $homeLetArr[$id][0][0] += 1; // 比赛总数

                    if ($homeId == $item['hometeamid']) {
                        // 主-赛
                        $homeLetArr[$id][1][0] += 1;

                        $letCount = $this->getLetCount((int)$item['homescore'], (int)$item['guestscore'], $oddsScore, $isTotal);

                        if ($letCount > 0) {
                            $homeLetArr[$id][1][1] += 1; // 主场-胜
                        } elseif ($letCount == 0) {
                            $homeLetArr[$id][1][2] += 1; // 主场-负
                        } else {
                            $homeLetArr[$id][1][3] += 1; // 主场-负
                        }

                    } elseif ($homeId == $item['guestteamid']) {
                        // 客-赛
                        $homeLetArr[$id][2][0] += 1;
                        $letCount = $this->getLetCount((int)$item['homescore'], (int)$item['guestscore'], $oddsScore, $isTotal);

                        if ($letCount < 0) {
                            $homeLetArr[$id][2][1] += 1; // 客场-胜
                        } elseif ($letCount == 0) {
                            $homeLetArr[$id][2][2] += 1; // 客场-负
                        } else {
                            $homeLetArr[$id][2][3] += 1; // 客场-负
                        }
                    }

                    // 5/10/20场时对应数据
                    if ($homeLetArr[$id][0][0] == 5) {
                        $homeLetArr[$id + 4] = $this->getLetCal($homeLetArr[$id]);
                    } elseif ($homeLetArr[$id][0][0] == 10) {
                        $homeLetArr[$id + 8] = $this->getLetCal($homeLetArr[$id]);
                    } elseif ($homeLetArr[$id][0][0] == 20) {
                        $homeLetArr[$id + 12] = $this->getLetCal($homeLetArr[$id]);
                    }

                    // 前六场
                    if ($key <= 5) {
                        $homeLetArr[$id][3][0] += 1;
                        $letCount = $this->getLetCount((int)$item['homescore'], (int)$item['guestscore'], $oddsScore, $isTotal);

                        if ($homeId == $item['hometeamid']) {
                            if ($letCount > 0) {
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][0]; // 主场-胜
                                $homeLetArr[$id][3][3] += 1;
                            } elseif ($letCount == 0) {
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][1]; // 主场-负
                            } else {
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][2]; // 主场-负
                            }
                        } elseif ($homeId == $item['guestteamid']) {
                            if ($letCount < 0) {
                                $homeLetArr[$id][3][3] += 1;
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][0]; // 客场-胜
                            } elseif ($letCount == 0) {
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][1]; // 客场-负
                            } else {
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][2]; // 客场-负
                            }
                        }
                    }
                }
            } else { // 半场
                foreach ($rankData as $key => $item) {
                    $scheduleId = (int)$item['scheduleid'];
                    $oddsScore = $oddsData[$scheduleId]['letgoal'];

                    //if (empty($letScore)) {
                    //    continue;
                    //}

                    $homeLetArr[$id][0][0] += 1; // 比赛总数
                    $homeHalfScore = (int)$item['homehalfscore'];
                    $guestHalfScore = (int)$item['guesthalfscore'];

                    if ($homeId == $item['hometeamid']) {
                        // 主-赛
                        $homeLetArr[$id][1][0] += 1;

                        $letCount = $this->getLetCount((int)$homeHalfScore, (int)$guestHalfScore, $oddsScore, $isTotal);

                        if ($letCount > 0) {
                            $homeLetArr[$id][1][1] += 1; // 主场-胜
                        } elseif ($letCount == 0) {
                            $homeLetArr[$id][1][2] += 1; // 主场-负
                        } else {
                            $homeLetArr[$id][1][3] += 1; // 主场-负
                        }
                    } elseif ($homeId == $item['guestteamid']) {
                        // 客-赛
                        $homeLetArr[$id][2][0] += 1;
                        //$homeLetArr[$id][1][0] += 1;
                        $letCount = $this->getLetCount((int)$item['homescore'], (int)$item['guestscore'], $oddsScore, $isTotal);

                        if ($letCount < 0) {
                            $homeLetArr[$id][2][1] += 1; // 主场-胜
                        } elseif ($letCount == 0) {
                            $homeLetArr[$id][2][2] += 1; // 主场-负
                        } else {
                            $homeLetArr[$id][2][3] += 1; // 主场-负
                        }
                    }

                    // 5/10/20场时对应数据
                    if ($homeLetArr[$id][0][0] == 5) {
                        $homeLetArr[$id + 4] = $this->getLetCal($homeLetArr[$id]);
                    } elseif ($homeLetArr[$id][0][0] == 10) {
                        $homeLetArr[$id + 8] = $this->getLetCal($homeLetArr[$id]);
                    } elseif ($homeLetArr[$id][0][0] == 20) {
                        $homeLetArr[$id + 12] = $this->getLetCal($homeLetArr[$id]);
                    }

                    // 前六场
                    if ($key <= 5) {
                        $homeLetArr[$id][3][0] += 1;
                        $oddsCount = $this->getLetCount((int)$item['homehalfscore'], (int)$item['guesthalfscore'], $oddsScore, $isTotal);

                        if ($homeId == $item['hometeamid']) {
                            if ($oddsCount > 0) {
                                $homeLetArr[$id][3][3] += 1;
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][0]; // 主场-胜
                            } elseif ($oddsCount == 0) {
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][1]; // 主场-平
                            } else {
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][2]; // 主场-负
                            }
                        } elseif ($homeId == $item['guestteamid']) {
                            if ($oddsCount < 0) {
                                $homeLetArr[$id][3][3] += 1;
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][0]; // 客场-胜
                            } elseif ($oddsCount == 0) {
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][1]; // 客场-平
                            } else {
                                $homeLetArr[$id][3][1] .= $resultMapper[$isTotal][2]; // 客场-负
                            }
                        }
                    }
                }
            }

            // 近6场赢盘率
            $homeLetArr[$id][3][2] = round($homeLetArr[$id][3][3] / $homeLetArr[$id][3][0], 3) * 100 . '%';
            $homeLetArr[$id] = $this->getLetCal($homeLetArr[$id]);

            // 近6场数据不变
            $homeLetArr[$id + 4][3] = $homeLetArr[$id + 8][3] = $homeLetArr[$id + 12][3] = $homeLetArr[$id][3];
            // 当总数不够5/10/20时, 赋值
            if ($homeLetArr[$id][0][0] < 5) {
                $homeLetArr[$id + 12] = $homeLetArr[$id + 8] = $homeLetArr[$id + 4] = $homeLetArr[$id];
            } elseif ($homeLetArr[$id][0][0] < 10) {
                $homeLetArr[$id + 12] = $homeLetArr[$id + 8] = $homeLetArr[$id];
            } elseif ($homeLetArr[$id][0][0] < 20) {
                $homeLetArr[$id + 12] = $homeLetArr[$id];
            }

            ksort($homeLetArr[$id]);
        }

        return $homeLetArr;
    }

    private function getLetCount($homescore, $guestscore, $score, $isTotal = 0)
    {
        if ($isTotal === 1) { // 大小分
            $plus = (int)$homescore + (int)$guestscore - (int)$score;

            if ($plus - $score === 0) {
                return 0;
            } elseif ($plus > 0) {
                return 1;
            }

            return -1;
        } else { // 让分
            $minus = (int)$homescore - (int)$guestscore - (int)$score;

            if ($minus === 0) {
                return 0;
            } elseif ($minus > 0) {
                return 1;
            }

            return -1;
        }
    }

    private function getLetCal($letArr)
    {
        $letArr[0][1] = $letArr[1][1] + $letArr[2][1];
        $letArr[0][2] = $letArr[1][2] + $letArr[2][2];
        $letArr[0][3] = $letArr[1][3] + $letArr[2][3];
        //$homeLetArr[$id][0][0] = ($homeLetArr[$id][1][0] + $homeLetArr[$id][2][0]);

        // 胜率
        $letArr[1][4] = round($letArr[1][1] / $letArr[1][0], 3) * 100 . '%';
        $letArr[2][4] = round($letArr[2][1] / $letArr[2][0], 3) * 100 . '%';
        $letArr[0][4] = round($letArr[0][1] / $letArr[0][0], 3) * 100 . '%';

        return $letArr;
    }

    private function _schedule_info($schedule_id)
    {
        //除赛季、分类、场所外，其他信息从即时比分表读取
        $sql = "SELECT l.scheduleid,
                          l.sclassid,
                          s.sclassseason,
                          s.sclasscategory,
                          s.category,
                          s.stadium,
                          l.sclassname_cn,
                          l.date,
                          l.status,
                          l.hometeamid,
                          l.homename_cn,
                          l.guestteamid,
                          l.guestname_cn,
                          l.homerank,
                          l.guestrank,
                          l.homescore,
                          l.guestscore,
                          l.homeone,
                          l.guestone,
                          l.hometwo,
                          l.guesttwo
                FROM `bt_live_schedule` AS l
                LEFT JOIN `bt_schedule` AS s ON l.scheduleid = s.scheduleid
                WHERE 1=1 AND l.scheduleid = $schedule_id LIMIT 1";

        $info = $this->db->fetch_array($this->db->query($sql), MYSQLI_ASSOC)[0];

        //所有信息从赛程表读取
        if (!$info) {
            $field = '`scheduleid`,
                          `sclassid`,
                          `sclassseason`,
                          `sclasscategory`,
                          `category`,
                          `stadium`,
                          `sclassname_cn`,
                          `date`,
                          `status`,
                          `hometeamid`,
                          `homename_cn`,
                          `guestteamid`,
                          `guestname_cn`,
                          `homerank`,
                          `guestrank`,
                          `homescore`,
                          `guestscore`,
                          `homeone`,
                          `guestone`,
                          `hometwo`,
                          `guesttwo`';

            $info = $this->schedule_db->get_one('`scheduleid`=' . $schedule_id, $field);
        }

        #----------------------联赛阶段-------------------
        $sclasscategory_arr = [
            0 => '全部',
            1 => '常规赛',
            2 => '季后赛',
            3 => '季前赛'
        ];

        $info['sclasscategory_cn'] = $sclasscategory_arr[$info['sclasscategory']];

        #----------------------半场比分------------------
        $info['homehalfscore'] = $info['homeone'] + $info['hometwo'];
        $info['guesthalfscore'] = $info['guestone'] + $info['guesttwo'];

        return $info;
    }
}