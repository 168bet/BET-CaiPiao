<?php
/**
 * win007.com 篮球数据控制器
 */

defined('IN_PHPCMS') or exit('No permission resources.');
// 模块缓存路径
define('CACHE_SPORTSDATA_PATH', CACHE_PATH . 'caches_sportsdata' . DIRECTORY_SEPARATOR . 'caches_data' . DIRECTORY_SEPARATOR);
// 加载模块全局函数
pc_base::load_app_func('global');

class basketball
{
    //比赛状态
    private $arr_status = [
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

    private $arr_sclasstype = [
        1 => '联赛',
        2 => '杯赛',
    ];

    private $arr_sclasscategory = [
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

    /**
     * 即时比分
     */
    public function live_schedule()
    {
        $SEO['title'] = '篮球即时比分-399彩迷';
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
                $item['status'] = $this->arr_status[$status+10];
            } else {
                $item['status'] = $this->arr_status[$status];
            }

            $matchTime = $item['date'];
            $item['date'] = date('H:i', $item['date']);
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

        include template('sportsdata', 'bt_live_schedule');
    }

    public function schedule_change()
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

        $idArr = array_map('intval', $scheduleId);
        $where = to_sqls($idArr, '', 'scheduleid');

        $where .= ' AND status>0';

        $return = [];
        $data = $this->db->select($where, 'sclasspart,scheduleid,sclassname_cn,sclasscolor,date,status,remaintime,
        homename_cn,guestname_cn,homescore,guestscore,homeone,guestone,hometwo,guesttwo,homethree,guestthree,homefour,
        guestfour', '', 'date');

        $inWhere = to_sqls($idArr, '', 'scheduleid');

        //欧赔
        $euData = $this->eu_db->select($inWhere . ' AND companyid=' . $companyIdArr[2], '*', '', '', '', 'scheduleid');

        //让分
        $letData = $this->let_db->select($inWhere . ' AND companyid=' . $companyIdArr[0], '*', '', '', '', 'scheduleid');

        // 大小分
        $totalData = $this->total_db->select($inWhere . ' AND companyid=' . $companyIdArr[1], '*', '', '', '', 'scheduleid');

        foreach ($data as $item) {
            $id = $item['scheduleid'];
            $status = (int)$item['status'];

            if ($item['sclasspart'] === '2' && ($item['status'] ==1 || $item['status']==3)) {
                $item['status'] = $this->arr_status[$status+10];
            } else {
                $item['status'] = $this->arr_status[$status];
            }

            $item['date'] = date('H:i', $item['date']);

            $item['hometwo'] = empty($item['hometwo']) ? $item['hometwo'] : '-';
            $item['guesttwo'] = empty($item['guesttwo']) ? $item['guesttwo'] : '-';
            $item['homethree'] = empty($item['homethree']) ? $item['homethree'] : '-';
            $item['guestthree'] = empty($item['guestthree']) ? $item['guestthree'] : '-';
            $item['homefour'] = empty($item['homefour']) ? $item['homefour'] : '-';
            $item['guestfour'] = empty($item['guestfour']) ? $item['guestfour'] : '-';

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

            $item['homewin'] = isset($euData[$id]['homewin']) ? rtrim0($euData[$id]['homewin']) : '';
            $item['guestwin'] = isset($euData[$id]['guestwin']) ? rtrim0($euData[$id]['guestwin']) : '';

            if (isset($letData[$id]['goal_r']) && $letData[$id]['goal_r'] !== '0.00') {
                $item['letgoal'] = rtrim0($letData[$id]['goal_r']);
            } else {
                $item['letgoal'] = isset($letData[$id]['letgoal']) ? rtrim0($letData[$id]['letgoal']) : '';
            }

            if (isset($letData[$id]['homeodds_r']) && $letData[$id]['homeodds_r'] !== '0.000') {
                $item['homeodds'] = rtrim0($letData[$id]['homeodds_r']);
            } else {
                $item['homeodds'] = isset($letData[$id]['homeodds']) ? rtrim0($letData[$id]['homeodds']) : '';
            }

            if (isset($letData[$id]['guestodds_r']) && $letData[$id]['guestodds_r'] !== '0.000') {
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

            $return['in_progress_id'][] = $item['scheduleid'];
            $return['in_progress_data'][] = $item;
        }

        $this->response($return);
    }

    /**
     * 比赛最新数据
     * @return bool
     */
    public function schedule_data()
    {
        $scheduleId = $_POST['schedule_id'];

        if (empty($scheduleId) || !is_array($scheduleId)) {
            $this->error('传递数值有误');
            return false;
        }

        $idArr = array_map('intval', $scheduleId);
        $where = to_sqls($idArr, '', '`scheduleid`');

        $data = $this->db->select($where, 'sclasspart,scheduleid,sclassid,status,remaintime,homescore,guestscore,homeone,
        guestone,hometwo,guesttwo,homethree,guestthree,homefour,guestfour');
        $return = [];

        foreach ($data as $item) {
            $status = (int)$item['status'];

            if ($status === -1) {
                $return['finish_id'][] = ['sclassid' => $item['sclassid'], 'scheduleid' => $item['scheduleid']];
            }

            $item['date'] = date('H:i', $item['date']);
            
            if ($item['sclasspart'] === '2' && ($item['status'] ==1 || $item['status']==3)) {
                $item['status'] = $this->arr_status[$status+10];
            } else {
                $item['status'] = $this->arr_status[$status];
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
        $SEO['title'] = '篮球比分网_完场-399彩迷';
        $SEO['keyword'] = '篮球比分网';
        $SEO['description'] = '399彩迷网提供最全的NBA完场比分、最为详细的篮球比分查询，即时为彩民提供篮球完场比分数据。';
        $week = [
            1 => '一',
            2 => '二',
            3 => '三',
            4 => '四',
            5 => '五',
            6 => '六',
            7 => '天'
        ];

        //url
        $url = APP_PATH . 'lqwanchang/?';

        //Bet365
        $let_companyid = 8;     //让分、欧赔
        $total_companyid = 11;  //大小总分

        //日期
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Y-m-d');

        //开始时间和结束时间
        $starttime = strtotime($date . ' 00:00:00');
        $endtime = strtotime($date . ' 23:59:59');

        //日期文本
        $date_text = date('m月d日', $endtime) . ' 星期' . $week[date('N', $endtime)];

        //一周日期及文本
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
                $item['status'] = $this->arr_status[$status+10];
            } else {
                $item['status'] = $this->arr_status[$status];
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

        include template('sportsdata', 'bt_end_schedule');
    }

    //赛程
    public function future_schedule()
    {
        $SEO['title'] = '竞彩篮球推荐_下日-399彩迷';
        $SEO['keyword'] = '竞彩篮球,竞彩篮球推荐';
        $SEO['description'] = '399彩迷网为您提供最即时，最全的篮球赛事、NBA赛事预告，以及竞彩篮球推荐、最准确的NBA赛程，每一场不容错过的NBA比赛赛事。';
        $week = [
            1 => '一',
            2 => '二',
            3 => '三',
            4 => '四',
            5 => '五',
            6 => '六',
            7 => '天',
        ];

        //Bet365
        $let_companyid = 8;       //让分、欧赔
        $total_companyid = 11;      //大小总分

        //日期
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date("Y-m-d", strtotime("+1 day"));

        //开始时间和结束时间
        $starttime = strtotime($date . ' 00:00:00');
        $endtime = strtotime($date . ' 23:59:59');

        //日期文本
        $date_text = date('m月d日', $endtime) . ' 星期' . $week[date('N', $endtime)];

        //一周日期及文本
        foreach ($week as $key => $value) {
            $time = SYS_TIME + $key * 24 * 60 * 60;
            $arr_date[] = [
                'date' => date('Y-m-d', $time),
                'date_text' => date('m.d', $time),
                'week_text' => $key == 1 ? '明日' : '星期' . $week[date('N', $time)],
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
                $item['status'] = $this->arr_status[$status+10];
            } else {
                $item['status'] = $this->arr_status[$status];
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

        include template('sportsdata', 'bt_future_schedule');
    }

    //比赛：数据分析
    public function schedule_analyse()
    {
        if (!$_GET['scheduleid']) {
            showmessage(L('schedule_not_exists'), 'blank');
        }

        //比赛信息
        $scheduleId = $_GET['scheduleid'];
        $scheduleData = $this->schedule_db->get_one('scheduleid=' . $scheduleId, '*', 'scheduleid DESC');
        if (empty($scheduleData)) {
            showmessage(L('schedule_not_exists'), 'blank');
        }
        //seo
        $SEO['title'] = $scheduleData['homename_cn'] . '队 VS ' . $scheduleData['guestname_cn'] . '队_篮球数据统计分析-399彩迷网';
        $SEO['keyword'] = $scheduleData['homename_cn'] . '队 VS ' . $scheduleData['guestname_cn'] . '队，篮球数据统计分析';
        $SEO['description'] = '399彩迷网提供权威的NBA数据分析,世界篮球联赛排名，以及为您直观的统计NBA战绩,篮球数据统计分析。';

        $scheduleDataDetail = $this->schedule_db->get_one('scheduleid=' . $scheduleId, '*', 'scheduleid DESC');

        if (!empty($scheduleDataDetail)) {
            $scheduleData['stadium'] = $scheduleDataDetail['stadium'];
            $scheduleData['sclassseason'] = $scheduleDataDetail['sclassseason'];
        }

        if (empty($scheduleData)) {
            showmessage(L('schedule_not_exists'), 'blank');
        }

        $scheduleData['status_cn'] = $this->arr_status[$scheduleData['status']];
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


        #-----------------------------------------------------------------------------------------------------
        // 让分盘路比较
        $letCompare = $this->getCompare($recentSchedule, $hometeamid, $guestteamid);

        $letData = $this->let_db->get_one('scheduleid=' . $scheduleId . ' AND companyid=3', 'letgoal');
        $letGoal = $letData['letgoal'];

        foreach (['home', 'guest'] as $value) {
            $letSameData[$value] = [];
            $schedule = array_column($recentSchedule[$value], 'scheduleid');

            if (empty($schedule)) {
                continue;
            }

            $where = to_sqls($schedule, '', 'scheduleid');

            $letData = $this->let_db->select($where . ' AND companyid=3 AND letgoal="' . $letGoal . '"', 'scheduleid', 100, 'modifytime DESC');
            $letData = array_flip(array_column($letData, 'scheduleid'));

            foreach ($recentSchedule[$value] as $item) {
                if (array_key_exists($item['scheduleid'], $letData)) {
                    $letSameData[$value][] = $item;
                }
            }
        }
        #-----------------------------------------------------------------------------------------------------
        // 总分盘路比较
        $totalCompare = $this->getCompare($recentSchedule, $hometeamid, $guestteamid, true);

        $totalData = $this->total_db->get_one('scheduleid=' . $scheduleId . ' AND companyid=6', 'totalscore');
        $totalScore = $totalData['totalscore'];

        foreach (['home', 'guest'] as $value) {
            $letSameData[$value] = [];
            $schedule = array_column($recentSchedule[$value], 'scheduleid');

            if (empty($schedule)) {
                continue;
            }

            $where = to_sqls($schedule, '', 'scheduleid');

            $totalData = $this->total_db->select($where . ' AND companyid=6 AND totalscore="' . $totalScore . '"', 'scheduleid', 100, 'modifytime DESC');
            $totalData = array_flip(array_column($totalData, 'scheduleid'));

            foreach ($recentSchedule[$value] as $item) {
                if (array_key_exists($item['scheduleid'], $totalData)) {
                    $item['totalscore'] = $totalScore; // 将大小分设置为同一值
                    $minus = (int)$item['total_points'] - (int)$item['totalscore'];

                    if ($minus > 0) {
                        $item['total_result'] = '大';
                    } elseif ($minus < 0) {
                        $item['total_result'] = '小';
                    } else {
                        $item['total_result'] = '走';
                    }

                    $totalSameData[$value][] = $item;
                }
            }
        }

        #-----------------------------------------------------------------------------------------------------
        // 平均得分/失分对比
        $getLossScore = $this->getScore($recentSchedule, $hometeamid, $guestteamid);
        #-----------------------------------------------------------------------------------------------------
        // 球队入球分数/单双统计
        $teamScore = $this->getTeamScore($recentSchedule, $hometeamid, $guestteamid);
        #-----------------------------------------------------------------------------------------------------
        // 总分统计
        $totalScore = $this->getTotalScore($recentSchedule, $hometeamid, $guestteamid);

        #-----------------------------------------------------------------------------------------------------
        // 全半场
        $halfTotal = $this->getHalfTotal($recentSchedule, $hometeamid, $guestteamid);
        #-----------------------------------------------------------------------------------------------------
        // 技术统计
        $technic = $this->getTechnic($recentSchedule, $hometeamid, $guestteamid);

        #-----------------------------------------------------------------------------------------------------
        // 赛程分析
        $afterSixSchedule['home'] = $this->schedule_db->select('(hometeamid=' . $hometeamid . ' OR guestteamid=' . $hometeamid . ') AND date>' . $scheduleData['date'], '*', 6, 'date');
        $afterSixSchedule['guest'] = $this->schedule_db->select('(hometeamid=' . $guestteamid . ' OR guestteamid=' . $guestteamid . ') AND date>' . $scheduleData['date'], '*', 6, 'date');

        if (!empty($afterSixSchedule['home'])) {
            foreach ($afterSixSchedule['home'] as $key => $item) {
                $afterSixSchedule['home'][$key]['days'] = ceil(($item['date'] - $scheduleData['date']) / 86400);
            }
        }

        if (!empty($afterSixSchedule['guest'])) {
            foreach ($afterSixSchedule['guest'] as $key => $item) {
                $afterSixSchedule['guest'][$key]['days'] = ceil(($item['date'] - $scheduleData['date']) / 86400);
            }
        }

        foreach ($recentSchedule['home'] as $key => $item) {
            $recentSchedule['home'][$key]['days'] = ceil(($item['date'] - $scheduleData['date']) / 86400);
        }

        foreach ($recentSchedule['guest'] as $key => $item) {
            $recentSchedule['guest'][$key]['days'] = ceil(($item['date'] - $scheduleData['date']) / 86400);
        }

        foreach ([0, 1, 2] as $item) {
            if (isset($recentSchedule['home'][$item])) {
                $beforeThreeSchedule['home'][] = $recentSchedule['home'][$item];
            }

            if (isset($recentSchedule['guest'][$item])) {
                $beforeThreeSchedule['guest'][] = $recentSchedule['guest'][$item];
            }
        }

        foreach ([0, 1, 2] as $item) {
            if (isset($afterSixSchedule['home'][$item])) {
                $beforeThreeSchedule['home'][] = $afterSixSchedule['home'][$item];
            }

            if (isset($afterSixSchedule['guest'][$item])) {
                $beforeThreeSchedule['guest'][] = $afterSixSchedule['guest'][$item];
            }
        }

        #-----------------------------------------------------------------------------------------------------
        // 伤停
        $lineup = $this->lineup_db->get_one('scheduleid=' . $scheduleId);
        $lineup['injury'] = json_decode($lineup['injury']);
        $lineup['homelineup'] = json_decode($lineup['homelineup']);
        $lineup['homebackup'] = json_decode($lineup['homebackup']);
        $lineup['guestlineup'] = json_decode($lineup['guestlineup']);
        $lineup['guestbackup'] = json_decode($lineup['guestbackup']);

        $lineup['homenear6'] = str_replace(['W', 'L'], ['<span class="red">W</span>', '<span class="green">L</span>'], $lineup['homenear6']);
        $lineup['guestnear6'] = str_replace(['W', 'L'], ['<span class="red">W</span>', '<span class="green">L</span>'], $lineup['guestnear6']);
        $lineup['homeodds'] = str_replace(['W', 'L'], ['<span class="red">W</span>', '<span class="green">L</span>'], $lineup['homeodds']);
        $lineup['guestodds'] = str_replace(['W', 'L'], ['<span class="red">W</span>', '<span class="green">L</span>'], $lineup['guestodds']);
        $lineup['homeou'] = str_replace(['U', 'O'], ['<span class="red">U</span>', '<span class="green">O</span>'], $lineup['homeou']);
        $lineup['guestou'] = str_replace(['U', 'O'], ['<span class="red">U</span>', '<span class="green">O</span>'], $lineup['guestou']);

        unset($lineup['injury'][0]);
        #-----------------------------------------------------------------------------------------------------
        include template('sportsdata', 'bt_schedule_analyse');
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

    private function getScore($recentSchedule, $hometeamid, $guestteamid)
    {
        #---------------------------------------------------------------------------------------------------
        // 让分盘路比较
        /*
            场次	第一节	第二节	第三节	第四节	加时	    全场
                得	失	得	失	得	失	得	失	得	失	得	失
        总	34	27	25	26	26	24	24	24	25	        102	99[0][12]
        主	17	28	24	26	26	25	23	22	26		    101	99
        客	17	27	26	27	26	24	25	25	24		    102	100
        */
        $dataArr = [
            $recentSchedule['home'],
            $recentSchedule['guest'],
        ];

        foreach ($dataArr as $id => $rankData) {
            $return[$id] = [
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0],
            ];

            if ($id == 0) {
                $homeId = $hometeamid;
            } else {
                $homeId = $guestteamid;
            }

            foreach ($rankData as $key => $item) {
                $scheduleId = (int)$item['scheduleid'];
                $return[$id][0][0] += 1; // 比赛总数

                if ($homeId == $item['hometeamid']) {
                    // 主-赛
                    $return[$id][1][0] += 1;
                    $return[$id][1][1] += $item['homeone'];  // 第一节
                    $return[$id][1][2] += $item['guestone'];
                    $return[$id][1][3] += $item['hometwo'];  // 第二节
                    $return[$id][1][4] += $item['guesttwo'];
                    $return[$id][1][5] += $item['homethree']; // 第三节
                    $return[$id][1][6] += $item['guestthree'];
                    $return[$id][1][7] += $item['homefour']; // 第四节
                    $return[$id][1][8] += $item['guestfour'];
                    $return[$id][1][9] += ($item['homeaddtime1'] + $item['homeaddtime2'] + $item['homeaddtime3']); // 加时
                    $return[$id][1][10] += ($item['guestaddtime1'] + $item['guestaddtime2'] + $item['guestaddtime3']);
                    $return[$id][1][11] += $item['homescore']; // 总分
                    $return[$id][1][12] += $item['guestscore'];
                } elseif ($homeId == $item['guestteamid']) {
                    // 客-赛
                    $return[$id][2][0] += 1;
                    $return[$id][2][1] += $item['homeone'];  // 第一节
                    $return[$id][2][2] += $item['guestone'];
                    $return[$id][2][3] += $item['hometwo'];  // 第二节
                    $return[$id][2][4] += $item['guesttwo'];
                    $return[$id][2][5] += $item['homethree']; // 第三节
                    $return[$id][2][6] += $item['guestthree'];
                    $return[$id][2][7] += $item['homefour']; // 第四节
                    $return[$id][2][8] += $item['guestfour'];
                    $return[$id][2][9] += ($item['homeaddtime1'] + $item['homeaddtime2'] + $item['homeaddtime3']); // 加时
                    $return[$id][2][10] += ($item['guestaddtime1'] + $item['guestaddtime2'] + $item['guestaddtime3']);
                    $return[$id][2][11] += $item['homescore']; // 总分
                    $return[$id][2][12] += $item['guestscore'];
                }

                // 5/10/20场时对应数据
                if ($return[$id][0][0] == 5) {
                    $return[$id + 4] = $this->getScoreCal($return[$id]);
                } elseif ($return[$id][0][0] == 10) {
                    $return[$id + 8] = $this->getScoreCal($return[$id]);
                } elseif ($return[$id][0][0] == 20) {
                    $return[$id + 12] = $this->getScoreCal($return[$id]);
                }
            }

            $return[$id] = $this->getScoreCal($return[$id]);

            // 当总数不够5/10/20时, 赋值
            if ($return[$id][0][0] < 5) {
                $return[$id + 12] = $return[$id + 8] = $return[$id + 4] = $return[$id];
            } elseif ($return[$id][0][0] < 10) {
                $return[$id + 12] = $return[$id + 8] = $return[$id];
            } elseif ($return[$id][0][0] < 20) {
                $return[$id + 12] = $return[$id];
            }

            ksort($return[$id]);
        }

        return $return;
    }

    private function getTeamScore($recentSchedule, $hometeamid, $guestteamid)
    {
        #---------------------------------------------------------------------------------------------------
        // 让分盘路比较
        /*
             赛	70-	71-80	81-90	91-100	101-110	111-120	120+	单	双
        总	20	1	 0	    3	    8	    6	    2	    0	    13	7[0,9]
        主	12	1	 0	    2	    4	    3	    2	    0	    7	5[1,9]
        客	8	0	 0	    1	    4	    3	    0	    0	    6	2
        */
        $dataArr = [
            $recentSchedule['home'],
            $recentSchedule['guest'],
        ];
        $return = [];

        foreach ($dataArr as $id => $rankData) {
            $return[$id] = [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            ];

            if ($id == 0) {
                $homeId = $hometeamid;
            } else {
                $homeId = $guestteamid;
            }

            foreach ($rankData as $key => $item) {
                //$scheduleId = (int)$item['scheduleid'];
                $return[$id][0][0] += 1; // 比赛总数

                if ($homeId == $item['hometeamid']) {
                    // 主-赛
                    $return[$id][1][0] += 1;
                    $homeScore = (int)$item['homescore'];

                    if ($homeScore <= 70) {
                        $return[$id][1][1] += 1;
                    } elseif ($homeScore >= 71 && $homeScore <= 80) {
                        $return[$id][1][2] += 1;
                    } elseif ($homeScore >= 81 && $homeScore <= 90) {
                        $return[$id][1][3] += 1;
                    } elseif ($homeScore >= 91 && $homeScore <= 100) {
                        $return[$id][1][4] += 1;
                    } elseif ($homeScore >= 101 && $homeScore <= 110) {
                        $return[$id][1][5] += 1;
                    } elseif ($homeScore >= 111 && $homeScore <= 120) {
                        $return[$id][1][6] += 1;
                    } elseif ($homeScore >= 121) {
                        $return[$id][1][7] += 1;
                    }

                    if ($homeScore % 2 === 1) {
                        $return[$id][1][8] += 1;
                    } else {
                        $return[$id][1][9] += 1;
                    }
                } elseif ($homeId == $item['guestteamid']) {
                    // 客-赛
                    $return[$id][2][0] += 1;
                    $guestScore = (int)$item['guestscore'];

                    if ($guestScore <= 70) {
                        $return[$id][2][1] += 1;
                    } elseif ($guestScore >= 71 && $guestScore <= 80) {
                        $return[$id][2][2] += 1;
                    } elseif ($guestScore >= 81 && $guestScore <= 90) {
                        $return[$id][2][3] += 1;
                    } elseif ($guestScore >= 91 && $guestScore <= 100) {
                        $return[$id][2][4] += 1;
                    } elseif ($guestScore >= 101 && $guestScore <= 110) {
                        $return[$id][2][5] += 1;
                    } elseif ($guestScore >= 111 && $guestScore <= 120) {
                        $return[$id][2][6] += 1;
                    } elseif ($guestScore >= 121) {
                        $return[$id][2][7] += 1;
                    }

                    if ($guestScore % 2 === 1) {
                        $return[$id][2][8] += 1;
                    } else {
                        $return[$id][2][9] += 1;
                    }
                }

                // 5/10/20场时对应数据
                if ($return[$id][0][0] == 5) {
                    $return[$id + 4] = $this->getTeamScoreCal($return[$id]);
                } elseif ($return[$id][0][0] == 10) {
                    $return[$id + 8] = $this->getTeamScoreCal($return[$id]);
                } elseif ($return[$id][0][0] == 20) {
                    $return[$id + 12] = $this->getTeamScoreCal($return[$id]);
                }
            }

            $return[$id] = $this->getTeamScoreCal($return[$id]);

            // 当总数不够5/10/20时, 赋值
            if ($return[$id][0][0] < 5) {
                $return[$id + 12] = $return[$id + 8] = $return[$id + 4] = $return[$id];
            } elseif ($return[$id][0][0] < 10) {
                $return[$id + 12] = $return[$id + 8] = $return[$id];
            } elseif ($return[$id][0][0] < 20) {
                $return[$id + 12] = $return[$id];
            }

            ksort($return[$id]);
        }

        return $return;
    }

    private function getTotalScore($recentSchedule, $hometeamid, $guestteamid)
    {
        #---------------------------------------------------------------------------------------------------
        // 让分盘路比较
        /*
             赛	70-	71-80	81-90	91-100	101-110	111-120	120+	单	双
        总	20	1	 0	    3	    8	    6	    2	    0	    13	7[0,9]
        主	12	1	 0	    2	    4	    3	    2	    0	    7	5[1,9]
        客	8	0	 0	    1	    4	    3	    0	    0	    6	2
        */
        $dataArr = [
            $recentSchedule['home'],
            $recentSchedule['guest'],
        ];
        $return = [];

        foreach ($dataArr as $id => $rankData) {
            $return[$id] = [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            ];

            if ($id == 0) {
                $homeId = $hometeamid;
            } else {
                $homeId = $guestteamid;
            }

            foreach ($rankData as $key => $item) {
                //$scheduleId = (int)$item['scheduleid'];
                $return[$id][0][0] += 1; // 比赛总数

                if ($homeId == $item['hometeamid']) {
                    // 主-赛
                    $return[$id][1][0] += 1;
                    $totalScore = (int)$item['total_points'];

                    if ($totalScore <= 70) {
                        $return[$id][1][1] += 1;
                    } elseif ($totalScore >= 161 && $totalScore <= 170) {
                        $return[$id][1][2] += 1;
                    } elseif ($totalScore >= 171 && $totalScore <= 180) {
                        $return[$id][1][3] += 1;
                    } elseif ($totalScore >= 181 && $totalScore <= 190) {
                        $return[$id][1][4] += 1;
                    } elseif ($totalScore >= 191 && $totalScore <= 200) {
                        $return[$id][1][5] += 1;
                    } elseif ($totalScore >= 201 && $totalScore <= 210) {
                        $return[$id][1][6] += 1;
                    } elseif ($totalScore >= 211 && $totalScore <= 220) {
                        $return[$id][1][7] += 1;
                    } elseif ($totalScore >= 221 && $totalScore <= 230) {
                        $return[$id][1][8] += 1;
                    } elseif ($totalScore >= 231) {
                        $return[$id][1][9] += 1;
                    }
                } elseif ($homeId == $item['guestteamid']) {
                    // 客-赛
                    $return[$id][2][0] += 1;
                    $totalScore = (int)$item['total_points'];

                    if ($totalScore <= 70) {
                        $return[$id][2][1] += 1;
                    } elseif ($totalScore >= 161 && $totalScore <= 170) {
                        $return[$id][2][2] += 1;
                    } elseif ($totalScore >= 171 && $totalScore <= 180) {
                        $return[$id][2][3] += 1;
                    } elseif ($totalScore >= 181 && $totalScore <= 190) {
                        $return[$id][2][4] += 1;
                    } elseif ($totalScore >= 191 && $totalScore <= 200) {
                        $return[$id][2][5] += 1;
                    } elseif ($totalScore >= 201 && $totalScore <= 210) {
                        $return[$id][2][6] += 1;
                    } elseif ($totalScore >= 211 && $totalScore <= 220) {
                        $return[$id][2][7] += 1;
                    } elseif ($totalScore >= 221 && $totalScore <= 230) {
                        $return[$id][2][8] += 1;
                    } elseif ($totalScore >= 231) {
                        $return[$id][2][9] += 1;
                    }
                }

                // 5/10/20场时对应数据
                if ($return[$id][0][0] == 5) {
                    $return[$id + 4] = $this->getTeamScoreCal($return[$id]);
                } elseif ($return[$id][0][0] == 10) {
                    $return[$id + 8] = $this->getTeamScoreCal($return[$id]);
                } elseif ($return[$id][0][0] == 20) {
                    $return[$id + 12] = $this->getTeamScoreCal($return[$id]);
                }
            }

            $return[$id] = $this->getTeamScoreCal($return[$id]);

            // 当总数不够5/10/20时, 赋值
            if ($return[$id][0][0] < 5) {
                $return[$id + 12] = $return[$id + 8] = $return[$id + 4] = $return[$id];
            } elseif ($return[$id][0][0] < 10) {
                $return[$id + 12] = $return[$id + 8] = $return[$id];
            } elseif ($return[$id][0][0] < 20) {
                $return[$id + 12] = $return[$id];
            }

            ksort($return[$id]);
        }

        return $return;
    }

    private function getHalfTotal($recentSchedule, $hometeamid, $guestteamid)
    {
        #---------------------------------------------------------------------------------------------------
        // 让分盘路比较
        /*
             赛	70-	71-80	81-90	91-100	101-110	111-120	120+	单	双
        总	20	1	 0	    3	    8	    6	    2	    0	    13	7[0,9]
        主	12	1	 0	    2	    4	    3	    2	    0	    7	5[1,9]
        客	8	0	 0	    1	    4	    3	    0	    0	    6	2
        */
        $dataArr = [
            $recentSchedule['home'],
            $recentSchedule['guest'],
        ];
        $return = [];

        foreach ($dataArr as $id => $rankData) {
            $return[$id] = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
            ];

            if ($id == 0) {
                $homeId = $hometeamid;
            } else {
                $homeId = $guestteamid;
            }

            foreach ($rankData as $key => $item) {
                $return[$id][0][0] += 1; // 比赛总数

                if ($homeId == $item['hometeamid']) {
                    // 主-赛
                    $return[$id][1][0] += 1;

                    $minus = (int)$item['homescore'] - (int)$item['guestscore'];
                    $halfMinus = (int)$item['homehalfscore'] - (int)$item['guesthalfscore'];

                    if ($halfMinus > 0 && $minus > 0) {
                        $return[$id][1][1] += 1;
                    } elseif ($halfMinus > 0 && $minus < 0) {
                        $return[$id][1][2] += 1;
                    } elseif ($halfMinus === 0 && $minus > 0) {
                        $return[$id][1][3] += 1;
                    } elseif ($halfMinus === 0 && $minus < 0) {
                        $return[$id][1][4] += 1;
                    } elseif ($halfMinus < 0 && $minus > 0) {
                        $return[$id][1][5] += 1;
                    } elseif ($halfMinus < 0 && $minus < 0) {
                        $return[$id][1][6] += 1;
                    }
                } elseif ($homeId == $item['guestteamid']) {
                    // 客-赛
                    $return[$id][2][0] += 1;
                    $minus = (int)$item['guestscore'] - (int)$item['homescore'];
                    $halfMinus = (int)$item['guesthalfscore'] - (int)$item['homehalfscore'];

                    if ($halfMinus > 0 && $minus > 0) {
                        $return[$id][1][1] += 1;
                    } elseif ($halfMinus > 0 && $minus < 0) {
                        $return[$id][1][2] += 1;
                    } elseif ($halfMinus === 0 && $minus > 0) {
                        $return[$id][1][3] += 1;
                    } elseif ($halfMinus === 0 && $minus < 0) {
                        $return[$id][1][4] += 1;
                    } elseif ($halfMinus < 0 && $minus > 0) {
                        $return[$id][1][5] += 1;
                    } elseif ($halfMinus < 0 && $minus < 0) {
                        $return[$id][1][6] += 1;
                    }
                }

                // 5/10/20场时对应数据
                if ($return[$id][0][0] == 5) {
                    $return[$id + 4] = $this->getHalfTotalCal($return[$id]);
                } elseif ($return[$id][0][0] == 10) {
                    $return[$id + 8] = $this->getHalfTotalCal($return[$id]);
                } elseif ($return[$id][0][0] == 20) {
                    $return[$id + 12] = $this->getHalfTotalCal($return[$id]);
                }
            }

            $return[$id] = $this->getHalfTotalCal($return[$id]);

            // 当总数不够5/10/20时, 赋值
            if ($return[$id][0][0] < 5) {
                $return[$id + 12] = $return[$id + 8] = $return[$id + 4] = $return[$id];
            } elseif ($return[$id][0][0] < 10) {
                $return[$id + 12] = $return[$id + 8] = $return[$id];
            } elseif ($return[$id][0][0] < 20) {
                $return[$id + 12] = $return[$id];
            }

            ksort($return[$id]);
        }

        return $return;
    }

    private function getTechnic($recentSchedule, $hometeamid, $guestteamid)
    {
        /*
        犹他爵士
            投篮命中率	三分命中率	平均篮板	平均助攻	平均抢断	平均失误
      季前赛	45.0	    32.5	    44.5	17.8	9.0	    17.8
      常规赛	46.7	    36.2	    42.3	19.1	6.2	    13.2
      近10场	47.2	    36.6	    42.2	19.6	6.1	    16.6
        费城76人
            投篮命中率	三分命中率	平均篮板	平均助攻	平均抢断	平均失误
      季前赛	40.5	    26.3	    45.3	18.9	8.1	    19.7
      常规赛	43.6	    35.7	    43.0	22.6	7.8	    16.5
      近10场	44.5	    34.0	    42.5	22.7	7.9	    16.5
        */
        $dataArr = [
            'home' => $recentSchedule['home'],
            'guest' => $recentSchedule['guest'],
        ];
        $sclassCategoryArr = $return = [];

        foreach ($dataArr as $key => $rankData) {
            if ($key == 'home') {
                $homeId = $hometeamid;
            } else {
                $homeId = $guestteamid;
            }

            $where = to_sqls(array_column($rankData, 'scheduleid'), '', '`scheduleid`');

            if (empty($where)) {
                continue;
            }

            $technic = $this->technic_db->select($where . ' AND teamid=' . $homeId);

            foreach ($technic as $item) {
                $technicData[$item['scheduleid']] = $item;
            }

            if (empty($technicData)) {
                continue;
            }

            $tmp = [];

            foreach ($rankData as $item) {
                $sclassCategory = (int)$item['sclasscategory'];

                if ($sclassCategory !== 1 && $sclassCategory !== 2) {
                    continue;
                }

                if (!isset($technicData[$item['scheduleid']])) {
                    continue;
                }

                $sclassCategoryArr[$sclassCategory] = '1';

                if ($homeId == $item['hometeamid']) {
                    // 主-赛
                    $tData = $technicData[$item['scheduleid']];
                    $tmp[$sclassCategory][1] += $tData['shoot_hit']; // 某场球赛投篮的命中个数
                    $tmp[$sclassCategory][2] += $tData['shoot'];     // 某场球赛投篮的个数
                    $tmp[$sclassCategory][3] += $tData['threemin_hit']; // 某场球赛投三分球的命中个数
                    $tmp[$sclassCategory][4] += $tData['threemin'];     // 某场球赛投三分球的个数

                    $tmp[$sclassCategory][5] += ($tData['attack'] + $tData['defend']); // 某场球赛进攻/防守篮板的总数
                    $tmp[$sclassCategory][6] += $tData['helpattack'];  // 某场球赛助攻篮板的总数
                    $tmp[$sclassCategory][7] += $tData['rob'];         // 某场球赛抢断篮板的总数
                    $tmp[$sclassCategory][8] += $tData['misplay'];     // 某场球赛失误的总数

                    $tmp[$sclassCategory][0] += 1;     // 总数
                } elseif ($homeId == $item['guestteamid']) {
                    // 客-赛
                    $tData = $technicData[$item['scheduleid']];
                    $tmp[$sclassCategory][1] += $tData['shoot_hit']; // 某场球赛投篮的命中个数
                    $tmp[$sclassCategory][2] += $tData['shoot'];     // 某场球赛投篮的个数
                    $tmp[$sclassCategory][3] += $tData['threemin_hit']; // 某场球赛投三分球的命中个数
                    $tmp[$sclassCategory][4] += $tData['threemin'];     // 某场球赛投三分球的个数

                    $tmp[$sclassCategory][5] += ($tData['attack'] + $tData['defend']); // 某场球赛进攻/防守篮板的总数
                    $tmp[$sclassCategory][6] += $tData['helpattack'];  // 某场球赛助攻篮板的总数
                    $tmp[$sclassCategory][7] += $tData['rob'];         // 某场球赛抢断篮板的总数
                    $tmp[$sclassCategory][8] += $tData['misplay'];     // 某场球赛失误的总数

                    $tmp[$sclassCategory][0] += 1;     // 总数
                }

                // 10场时对应数据
                if ($tmp[$sclassCategory][0] == 10) {
                    $return[$key][3][0] = round($tmp[$sclassCategory][1] / $tmp[$sclassCategory][2], 3) * 100;
                    $return[$key][3][1] = round($tmp[$sclassCategory][3] / $tmp[$sclassCategory][4], 3) * 100;
                    $return[$key][3][2] = round($tmp[$sclassCategory][5] / $tmp[$sclassCategory][0], 1);
                    $return[$key][3][3] = round($tmp[$sclassCategory][6] / $tmp[$sclassCategory][0], 1);
                    $return[$key][3][4] = round($tmp[$sclassCategory][7] / $tmp[$sclassCategory][0], 1);
                    $return[$key][3][5] = round($tmp[$sclassCategory][8] / $tmp[$sclassCategory][0], 1);
                }
            }

            foreach ($sclassCategoryArr as $item => $value) {
                $return[$key][$item][0] = round($tmp[$item][1] / $tmp[$item][2], 3) * 100;
                $return[$key][$item][1] = round($tmp[$item][3] / $tmp[$item][4], 3) * 100;
                $return[$key][$item][2] = round($tmp[$item][5] / $tmp[$item][0], 1);
                $return[$key][$item][3] = round($tmp[$item][6] / $tmp[$item][0], 1);
                $return[$key][$item][4] = round($tmp[$item][7] / $tmp[$item][0], 1);
                $return[$key][$item][5] = round($tmp[$item][8] / $tmp[$item][0], 1);
            }

            if (isset($tmp[1][0]) && $tmp[1][0] < 10) {
                $return[$key][3] = $return[$key][1];
            } elseif (isset($tmp[2][0]) && $tmp[2][0] < 10) {
                $return[$key][3] = $return[$key][2];
            }

            unset($tmp);
            ksort($return[$key]);
        }

        return $return;
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

    private function getScoreCal($return)
    {
        $array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        foreach ($array as $value) {
            $return[0][$value] = $return[1][$value] + $return[2][$value];
            $return[1][$value] = round($return[1][$value] / $return[1][0]);
            $return[2][$value] = round($return[2][$value] / $return[2][0]);
            $return[0][$value] = round($return[0][$value] / $return[0][0]);
        }

        return $return;
    }


    private function getTeamScoreCal($return)
    {
        $array = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        foreach ($array as $value) {
            $return[0][$value] = $return[1][$value] + $return[2][$value];
        }

        return $return;
    }

    private function getHalfTotalCal($return)
    {
        $array = [0, 1, 2, 3, 4, 5, 6];

        foreach ($array as $value) {
            $return[0][$value] = $return[1][$value] + $return[2][$value];
        }

        return $return;
    }

    /*
        -0-
       全场	赛0	      胜1	    负2	    得3	        失4	        净5	        排名6       胜率7
        0总	11[0][0]  5[0][1]	6[0][2]	64.1[0][3]	65.0[0][4]	-0.9[0][5]	220[0][6]  45.5%[0][7]
        1主	5 [1][0]  3[1][1]	2[1][2]	69.4[1][3]	57.2[1][4]	12.2[1][5]	228[1][6]  60.0%[0][7]
        2客	6 [2][0]  2[2][1]	4[2][2]	59.7[2][3]	71.5[2][4]	-11.8[2][5]	120[2][6]  33.3%[0][7]
       近6场	6 [3][0]  2[3][1]	4[3][2]	62.5[3][3]	69.5[3][4]	-7.0[3][5]	           33.3%[0][7]
        -1-
        半场	赛	胜	负	得	    失	    净	 	胜率
        0总	11	4	5	28.9	29.1	-0.2	36.4%
        1主	5	3	1	36.2	26.0	10.2	60.0%
        2客	6	1	4	22.8	31.7	-8.8	16.7%
       近6场	6	2	3	29.3	29.5	-0.2	33.3%
        */
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

    //比赛：欧赔
    public function schedule_euro()
    {
        $schedule_id = $_REQUEST['scheduleid'];

        if (!$schedule_id) {
            $this->error('参数传递有误！');
            return false;
        }

        //状态
        $arr_status = $this->arr_status;
        //比赛信息
        $schedule_info = $this->_schedule_info($schedule_id);
        //seo
        $SEO['title'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队_蓝球欧赔分析_凯利指数分析_返还率分析-399彩迷网';
        $SEO['keyword'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队，篮球欧赔分析,凯利指数分析,返还率分析';
        $SEO['description'] = '399彩迷网为您提供精准的篮球欧赔分析,凯利指数分析,篮球返还率分析等相关的篮球数据分析。';
        //欧赔公司
        $company = $this->eu_company_db->select('', '`companyid`,`name_cn`', '', '', '', 'companyid');
        //初盘，即时盘
        $euro = $this->eu_db->select('`scheduleid`=' . $schedule_id, '*', '', '', '', 'companyid');
        //赔率变化
        $euro_detail = $this->eu_detail_db->select('`scheduleid`=' . $schedule_id, '*', '', '`modifytime` DESC');

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

        include template('sportsdata', 'bt_schedule_euro');
    }

    //比赛：让分
    public function schedule_asia()
    {
        $schedule_id = $_REQUEST['scheduleid'];

        if (!$schedule_id) {
            showmessage('比赛id不正确');
        }

        //状态
        $arr_status = $this->arr_status;
        //比赛信息
        $schedule_info = $this->_schedule_info($schedule_id);
        //seo
        $SEO['title'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队_让分赔率比较_篮球初盘分析_即时数据分析_历史资料-399彩迷网';
        $SEO['keyword'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队，让分赔率比较,篮球初盘分析,即时数据分析,历史资料';
        $SEO['description'] = '399彩迷网提供让分赔率比较,蓝球历史资料，精心为您分析篮球初盘分析,即时数据分析等数据分析。';
        //让分赔率公司
        $company = $this->company_db->select('`kind`=1', '`companyid`,`name`', '', '', '', 'companyid');
        //让球初盘，即时盘
        $let_goal = $this->let_db->select('`scheduleid`=' . $schedule_id . ' AND `companyid` IN (' . join(',', array_keys($company)) . ')', '`scheduleid`,`companyid`,`letgoal_f`,`homeodds_f`,`guestodds_f`,`letgoal`,`homeodds`,`guestodds`');
        //让球变化
        $let_goal_detail = $this->let_detail_db->select('`scheduleid`=' . $schedule_id . ' AND `companyid` IN (' . join(',', array_keys($company)) . ') AND `type` IN (6,7)', '`scheduleid`,`companyid`,`letgoal`,`homeodds`,`guestodds`,`modifytime`,`type`', '', '`modifytime` DESC');

        include template('sportsdata', 'bt_schedule_asia');
    }

    //比赛：总分
    public function schedule_ou()
    {
        $schedule_id = $_REQUEST['scheduleid'];

        if (!$schedule_id) {
            showmessage('比赛id不正确');
        }

        //状态
        $arr_status = $this->arr_status;
        //比赛信息
        $schedule_info = $this->_schedule_info($schedule_id);
        //seo
        $SEO['title'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队_蓝球总分盘_初盘分析_篮球即时数据比较-399彩迷网';
        $SEO['keyword'] = $schedule_info['homename_cn'] . '队 VS ' . $schedule_info['guestname_cn'] . '队，篮球总分盘,初盘分析,篮球即时数据比较';
        $SEO['description'] = '查看篮球总分盘，上399彩迷网，专业为您提供权威的NBA初盘分析,篮球即时数据比较等篮球数据分析查看等。';
        //总分赔率公司
        $company = $this->company_db->select('`kind`=2', '`companyid`,`name`', '', '', '', 'companyid');
        //总分初盘，即时盘
        $totalscore = $this->total_db->select('`scheduleid`=' . $schedule_id . ' AND `companyid` IN (' . join(',', array_keys($company)) . ')', '`scheduleid`,`companyid`,`totalscore_f`,`highodds_f`,`lowodds_f`,`totalscore`,`highodds`,`lowodds`,`modifytime`');
        //总分变化
        $totalscore_detail = $this->total_detail_db->select('`scheduleid`=' . $schedule_id . ' AND `companyid` IN (' . join(',', array_keys($company)) . ') AND `type` IN (6,7)', '`scheduleid`,`companyid`,`totalscore`,`highodds`,`lowodds`,`modifytime`,`type`', '', '`modifytime` DESC');

        include template('sportsdata', 'bt_schedule_ou');
    }

    //比赛基本信息
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

    //欧赔表格
    public function schedule_euro_excel()
    {
        $schedule_id = $_REQUEST['scheduleid'];
        $company_id = $_REQUEST['companyid'];
        $time = $_REQUEST['time'];

        if (!$schedule_id) {
            $this->error('参数传递有误！');
            return false;
        }

        $where = '`scheduleid`=' . $schedule_id;

        //比赛信息
        $schedule_info = $this->_schedule_info($schedule_id);
        //欧赔公司
        $company = $this->eu_company_db->select('', '`companyid`,`name_cn`', '', '', '', 'companyid');
        //初盘，即时盘
        $euro = $this->eu_db->select($where, '*', '', '', '', 'companyid');
        //赔率变化
        $where .= $company_id ? ' AND `companyid` IN (' . $company_id . ')' : '';
        $where .= $time ? ' AND `modifytime` IN (' . $time . ')' : '';
        $euro_detail = $this->eu_detail_db->select($where, '*', '', '`modifytime` DESC');

        //excel表格
        pc_base::load_sys_class('PHPExcel');
        $excel = new PHPExcel();
        //文件名
        $file_name = date('Y-m-d', $schedule_info['date']) . ' ' . $schedule_info['sclassname_cn'] . ' ' . $schedule_info['homename_cn'] . ' VS ' . $schedule_info['guestname_cn'] . '.xls';
        //标题
        $title = array(
            array('序号', '博彩公司', '主', '客', '主', '客', '主', '客', '值', '主', '客')
        );
        $excel->getActiveSheet()->mergeCells('C1:D1')->setCellValue('C1', '初盘')
            ->mergeCells('E1:F1')->setCellValue('E1', '即时盘')
            ->mergeCells('G1:H1')->setCellValue('G1', '最新概率')
            ->setCellValue('I1', '返回率')
            ->mergeCells('J1:K1')->setCellValue('J1', '最新凯利指数')
            ->fromArray($title, null, 'A2');
        //颜色边框
        $cell = array('A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'D1', 'D2', 'E1', 'E2', 'F1', 'F2', 'G1', 'G2', 'H1', 'H2', 'I1', 'I2', 'J1', 'J2', 'K1', 'K2');
        foreach ($cell as $value) {
            //边框
            $excel->getActiveSheet()->getStyle($value)->getBorders()->applyFromArray(array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                )
            ));
            //颜色
            $excel->getActiveSheet()->getStyle($value)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('99CCFF');
            //字体
            $excel->getActiveSheet()->getStyle($value)->getFont()->setSize(12)->setBold(true);
        }

        //即时盘数据
        if (count($euro)) {
            $homewin_f = array_column($euro, 'homewin_f');
            $guestwin_f = array_column($euro, 'guestwin_f');
            $homewin = array_column($euro, 'homewin');
            $guestwin = array_column($euro, 'guestwin');
            $probability_h = array_column($euro, 'probability_h1');
            $probability_g = array_column($euro, 'probability_g1');
            $probability_t = array_column($euro, 'probability_t1');
            //最大值
            $max_odds = array(
                'order' => '',
                'name' => '最大值',
                'homewin_f' => max($homewin_f),
                'guestwin_f' => max($guestwin_f),
                'homewin' => max($homewin),
                'guestwin' => max($guestwin),
                'probability_h' => max($probability_h),
                'probability_g' => max($probability_g),
                'probability_t' => max($probability_t),
            );
            //最小值
            $min_odds = array(
                'order' => '',
                'name' => '最小值',
                'homewin' => min($homewin),
                'homewin_f' => min($homewin_f),
                'guestwin' => min($guestwin),
                'guestwin_f' => min($guestwin_f),
                'probability_h' => min($probability_h),
                'probability_g' => min($probability_g),
                'probability_t' => min($probability_t),
            );
            //平均值
            $avg_odds = array(
                'order' => '',
                'name' => '平均值',
                'homewin' => avg($homewin),
                'homewin_f' => avg($homewin_f),
                'guestwin' => avg($guestwin),
                'guestwin_f' => avg($guestwin_f),
                'probability_h' => avg($probability_h),
                'probability_g' => avg($probability_g),
                'probability_t' => avg($probability_t),
            );
            //计算凯利指数
            $max_odds['kelly_h'] = get_kelly($max_odds['homewin'], $max_odds['probability_h']);
            $max_odds['kelly_g'] = get_kelly($max_odds['guestwin'], $max_odds['probability_g']);
            $min_odds['kelly_h'] = get_kelly($min_odds['homewin'], $min_odds['probability_h']);
            $min_odds['kelly_g'] = get_kelly($min_odds['guestwin'], $min_odds['probability_g']);
            $avg_odds['kelly_h'] = get_kelly($avg_odds['homewin'], $avg_odds['probability_h']);
            $avg_odds['kelly_g'] = get_kelly($avg_odds['guestwin'], $avg_odds['probability_g']);

            $excel->getActiveSheet()->fromArray(array(
                $max_odds,
                $min_odds,
                $avg_odds
            ), null, 'A3');
        }

        //赔率变化数据
        if (count($euro_detail) && isset($avg_odds['probability_h']) && isset($avg_odds['probability_g'])) {
            $data = array();
            foreach ($euro_detail as $key => $value) {
                //赔率公司的初盘
                $first = $euro[$value['companyid']];

                $data[] = array(
                    'order' => $key + 1,
                    'company' => $company[$value['companyid']]['name_cn'],
                    'homewin_f' => $first['homewin_f'],
                    'guestwin_f' => $first['guestwin_f'],
                    'homewin' => $value['homewin'],
                    'guestwin' => $value['guestwin'],
                    'probability_h' => $value['probability_h'],
                    'probability_g' => $value['probability_g'],
                    'probability_t' => $value['probability_t'],
                    'kelly_h' => get_kelly($value['homewin'], $avg_odds['probability_h']),
                    'kelly_g' => get_kelly($value['guestwin'], $avg_odds['probability_g'])
                );
            }

            $excel->getActiveSheet()->fromArray($data, null, 'A6');
        }

        //表格下载
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $writer->save('php://output');

    }

    //综合指数
    public function odds()
    {
        list($arr_status, $option_cid, $companies, $odds_status, $date, $date_text, $live_games) = $this->odds_prework();

        $SEO['title'] = '篮球赔率-' . $this->odds_status_arr[$odds_status] . '-399彩迷';
        $SEO['keyword'] = '篮球盘口，篮球赔率';
        $SEO['description'] = '看篮球即时赔率，首选399彩迷网！399彩迷网为广大彩迷提供各大欧洲赔率公司和亚洲盘口的篮球初始赔率、即时赔率数据，提供赔率分析和盘口走势分析等盘赔数据查询！';

        //比赛id
        $game_condition = to_sqls(array_column($live_games, 'scheduleid'), '', 'scheduleid');

        //公司
        foreach ($option_cid as $id) {
            $c_asia[] = $this->company_arr[$id][0];
            $c_ou[] = $this->company_arr[$id][1];
            $c_euro[] = $this->company_arr[$id][2];
        }

        //亚盘
        $c_asia = to_sqls($c_asia, '', 'companyid');
        $odds_asia = $this->let_db->select($c_asia . ' AND ' . $game_condition, '`companyid`,`scheduleid`,`letgoal`,`homeodds`,`guestodds`');

        if ($odds_asia) {
            foreach ($odds_asia as $odds) {
                $cid = $this->c_asia[$odds['companyid']];
                $odds['companyname'] = $this->company[$cid];
                $live_games[$odds['scheduleid']]['odds'][$cid] = $odds;
            }
        }

        //总分
        $c_ou = to_sqls($c_ou, '', 'companyid');
        $odds_ou = $this->total_db->select($c_ou . ' AND ' . $game_condition, '`companyid`,`scheduleid`,`totalscore`,`highodds`,`lowodds`');

        if ($odds_ou) {
            foreach ($odds_ou as $odds) {
                $id = $odds['scheduleid'];
                $cid = $this->c_ou[$odds['companyid']];
                $live_games[$id]['odds'][$cid]['companyid'] = $cid;
                $live_games[$id]['odds'][$cid]['companyname'] = $this->company[$cid];
                $live_games[$id]['odds'][$cid]['scheduleid'] = $id;
                $live_games[$id]['odds'][$cid]['highodds'] = $odds['highodds'];
                $live_games[$id]['odds'][$cid]['totalscore'] = $odds['totalscore'];
                $live_games[$id]['odds'][$cid]['lowodds'] = $odds['lowodds'];
            }
        }

        //欧赔
        $c_euro = to_sqls($c_euro, '', 'companyid');
        $odds_euro = $this->eu_db->select($c_euro . ' AND ' . $game_condition, '`companyid`,`scheduleid`,`homewin`,`guestwin`');

        if ($odds_euro) {
            foreach ($odds_euro as $odds) {
                $id = $odds['scheduleid'];
                $cid = $this->c_euro[$odds['companyid']];
                $live_games[$id]['odds'][$cid]['companyid'] = $cid;
                $live_games[$id]['odds'][$cid]['companyname'] = $this->company[$cid];
                $live_games[$id]['odds'][$cid]['scheduleid'] = $id;
                $live_games[$id]['odds'][$cid]['homewin'] = $odds['homewin'];
                $live_games[$id]['odds'][$cid]['guestwin'] = $odds['guestwin'];
                $live_games[$id]['odds'][$cid]['return'] = round(1 / (1 + $odds['homewin'] / $odds['guestwin']) * 100 * $odds['homewin'], 2);
            }
        }

        //如果某场比赛没有指数，则删除
        foreach ($live_games as $key => $game) {
            if (!isset($game['odds'])) {
                unset($live_games[$key]);
            }
        }

        //添加空值
        foreach ($live_games as $gameid => $game) {
            if (count($game['odds']) < count($option_cid)) {
                $diff = array_diff($option_cid, array_keys($game['odds']));
                foreach ($diff as $cid) {
                    $live_games[$gameid]['odds'][$cid]['companyid'] = $cid;
                    $live_games[$gameid]['odds'][$cid]['companyname'] = $this->company[$cid];
                    $live_games[$gameid]['odds'][$cid]['gameid'] = $gameid;
                }
            }
        }

        //按公司编号排序
        foreach ($live_games as $key => $game) {
            ksort($live_games[$key]['odds']);
        }

        // 获取赛事数据
        $sclassidWhere = to_sqls(array_column($live_games, 'sclassid'), '', '`sclassid`');
        $sclassidData = $this->sclass_db->select($sclassidWhere, 'sclassid,name_s', '', '', '', 'sclassid');

        include template('sportsdata', 'bt_odds');
    }

    //欧赔
    public function odds_euro()
    {
        list($arr_status, $option_cid, $companies, $odds_status, $date, $date_text, $live_games) = $this->odds_prework();

        $SEO['title'] = '篮球欧洲指数-' . $this->odds_status_arr[$odds_status] . '-399彩迷';
        $SEO['keyword'] = '篮球欧洲指数';
        $SEO['description'] = '399彩迷网作为足球指数中心，为彩民提供足球盘口、足球赔率数据，供足球欧赔、亚盘、大小球、即时盘口分析查询等数据';

        //比赛id
        $game_condition = to_sqls(array_column($live_games, 'scheduleid'), '', 'scheduleid');

        //公司
        foreach ($option_cid as $id) {
            $c_euro[] = $this->company_arr[$id][2];
        }

        //欧赔
        $c_euro = to_sqls($c_euro, '', 'companyid');
        $odds_euro = $this->eu_db->select($c_euro . ' AND ' . $game_condition, '`companyid`,`scheduleid`,`homewin`,`guestwin`,`homewin_f`,`guestwin_f`');

        if ($odds_euro) {
            foreach ($odds_euro as $odds) {
                $id = $odds['scheduleid'];
                $cid = $this->c_euro[$odds['companyid']];
                $odds['companyname'] = $this->company[$cid];
                $odds['return'] = round(1 / (1 + $odds['homewin'] / $odds['guestwin']) * 100 * $odds['homewin'], 2);
                $odds['return_f'] = round(1 / (1 + $odds['homewin_f'] / $odds['guestwin_f']) * 100 * $odds['homewin_f'], 2);
                $live_games[$id]['odds'][$cid] = $odds;
            }
        }

        //如果某场比赛没有指数，则删除
        foreach ($live_games as $key => $game) {
            if (!isset($game['odds'])) {
                unset($live_games[$key]);
            }
        }

        //添加空值
        foreach ($live_games as $gameid => $game) {
            if (count($game['odds']) < count($option_cid)) {
                $diff = array_diff($option_cid, array_keys($game['odds']));
                foreach ($diff as $cid) {
                    $live_games[$gameid]['odds'][$cid]['companyid'] = $cid;
                    $live_games[$gameid]['odds'][$cid]['companyname'] = $this->company[$cid];
                    $live_games[$gameid]['odds'][$cid]['gameid'] = $gameid;
                }
            }
        }

        //按公司编号排序
        foreach ($live_games as $key => $game) {
            ksort($live_games[$key]['odds']);
        }

        // 获取赛事数据
        $sclassidWhere = to_sqls(array_column($live_games, 'sclassid'), '', '`sclassid`');
        $sclassidData = $this->sclass_db->select($sclassidWhere, 'sclassid,name_s', '', '', '', 'sclassid');

        include template('sportsdata', 'bt_odds_euro');

    }

    //让分
    public function odds_asia()
    {
        list($arr_status, $option_cid, $companies, $odds_status, $date, $date_text, $live_games) = $this->odds_prework();

        $SEO['title'] = '篮球亚洲指数-' . $this->odds_status_arr[$odds_status] . '-399彩迷';
        $SEO['keyword'] = '篮球亚洲指数';
        $SEO['description'] = '399彩迷网作为足球指数中心，为彩民提供足球盘口、足球赔率数据，供足球欧赔、亚盘、大小球、即时盘口分析查询等数据';

        //比赛id
        $game_condition = to_sqls(array_column($live_games, 'scheduleid'), '', 'scheduleid');

        //公司
        foreach ($option_cid as $id) {
            $c_asia[] = $this->company_arr[$id][0];
        }

        //亚盘
        $c_asia = to_sqls($c_asia, '', 'companyid');
        $odds_asia = $this->let_db->select($c_asia . ' AND ' . $game_condition, '`companyid`,`scheduleid`,`letgoal`,`homeodds`,`guestodds`,`letgoal_f`,`homeodds_f`,`guestodds_f`');

        if ($odds_asia) {
            foreach ($odds_asia as $odds) {
                $cid = $this->c_asia[$odds['companyid']];
                $odds['companyname'] = $this->company[$cid];
                $live_games[$odds['scheduleid']]['odds'][$cid] = $odds;
            }
        }

        //如果某场比赛没有指数，则删除
        foreach ($live_games as $key => $game) {
            if (!isset($game['odds'])) {
                unset($live_games[$key]);
            }
        }

        //添加空值
        foreach ($live_games as $gameid => $game) {
            if (count($game['odds']) < count($option_cid)) {
                $diff = array_diff($option_cid, array_keys($game['odds']));
                foreach ($diff as $cid) {
                    $live_games[$gameid]['odds'][$cid]['companyid'] = $cid;
                    $live_games[$gameid]['odds'][$cid]['companyname'] = $this->company[$cid];
                    $live_games[$gameid]['odds'][$cid]['gameid'] = $gameid;
                }
            }
        }

        //按公司编号排序
        foreach ($live_games as $key => $game) {
            ksort($live_games[$key]['odds']);
        }

        // 获取赛事数据
        $sclassidWhere = to_sqls(array_column($live_games, 'sclassid'), '', '`sclassid`');
        $sclassidData = $this->sclass_db->select($sclassidWhere, 'sclassid,name_s', '', '', '', 'sclassid');

        include template('sportsdata', 'bt_odds_asia');
    }

    //总分
    public function odds_ou()
    {
        list($arr_status, $option_cid, $companies, $odds_status, $date, $date_text, $live_games) = $this->odds_prework();

        $SEO['title'] = '篮球大小球盘口-' . $this->odds_status_arr[$odds_status] . '-399彩迷';
        $SEO['keyword'] = '篮球大小球';
        $SEO['description'] = '399彩迷网作为足球指数中心，为彩民提供足球盘口、足球赔率数据，供足球欧赔、亚盘、大小球、即时盘口分析查询等数据';

        //比赛id
        $game_condition = to_sqls(array_column($live_games, 'scheduleid'), '', 'scheduleid');

        //公司
        foreach ($option_cid as $id) {
            $c_ou[] = $this->company_arr[$id][1];
        }

        //总分
        $c_ou = to_sqls($c_ou, '', 'companyid');
        $odds_ou = $this->total_db->select($c_ou . ' AND ' . $game_condition, '`companyid`,`scheduleid`,`totalscore`,`highodds`,`lowodds`,`totalscore_f`,`highodds_f`,`lowodds_f`');

        if ($odds_ou) {
            foreach ($odds_ou as $odds) {
                $id = $odds['scheduleid'];
                $cid = $this->c_ou[$odds['companyid']];
                $odds['companyname'] = $this->company[$cid];
                $live_games[$id]['odds'][$cid] = $odds;
            }
        }

        //如果某场比赛没有指数，则删除
        foreach ($live_games as $key => $game) {
            if (!isset($game['odds'])) {
                unset($live_games[$key]);
            }
        }

        //添加空值
        foreach ($live_games as $gameid => $game) {
            if (count($game['odds']) < count($option_cid)) {
                $diff = array_diff($option_cid, array_keys($game['odds']));
                foreach ($diff as $cid) {
                    $live_games[$gameid]['odds'][$cid]['companyid'] = $cid;
                    $live_games[$gameid]['odds'][$cid]['companyname'] = $this->company[$cid];
                    $live_games[$gameid]['odds'][$cid]['gameid'] = $gameid;
                }
            }
        }

        //按公司编号排序
        foreach ($live_games as $key => $game) {
            ksort($live_games[$key]['odds']);
        }

        // 获取赛事数据
        $sclassidWhere = to_sqls(array_column($live_games, 'sclassid'), '', '`sclassid`');
        $sclassidData = $this->sclass_db->select($sclassidWhere, 'sclassid,name_s', '', '', '', 'sclassid');

        include template('sportsdata', 'bt_odds_ou');

    }

    private function odds_prework()
    {
        //状态
        $arr_status = $this->arr_status;

        //公司
        list($option_cid, $companies) = $this->odds_company();

        //指数状态、日期、日期文本、where
        list($odds_status, $date, $date_text, $where) = $this->odds_status();

        //即时比分
        $live_games = $this->odds_schedule($where);

        return [$arr_status, $option_cid, $companies, $odds_status, $date, $date_text, $live_games];
    }

    private function odds_company()
    {
        if (isset($_POST['dosubmit']) && !empty($_POST['companyid'])) {
            $option_cid = $_POST['companyid'];
        } else { //默认
            $option_cid = [1, 2, 3]; //Bet365、皇冠、澳门
        }

        //所有公司
        $companies = [];

        //添加checked
        foreach ($this->company as $id => $name) {
            $companies[$id] = ['companyid' => $id, 'name' => $name];

            if (in_array($id, $option_cid)) {
                $companies[$id]['checked'] = true;
            }
        }

        return [$option_cid, $companies];
    }

    private function odds_status()
    {
        $starttime = SYS_TIME - 12 * 60 * 60; //开始时间
        $endtime = SYS_TIME + 48 * 60 * 60;  //结束时间

        //指数状态(1即时指数；2已开赛；3历史；4早盘)
        $odds_status = isset($_REQUEST['odds_status']) ? intval($_REQUEST['odds_status']) : 1;

        //日期条件(3历史；4早盘)
        $date = isset($_POST['date']) ? $_POST['date'] : ($odds_status == 3 ? date('Y-m-d', SYS_TIME - 24 * 60 * 60) : date('Y-m-d'));

        //日期文本
        $week = array(1 => '一', 2 => '二', 3 => '三', 4 => '四', 5 => '五', 6 => '六', 7 => '天');
        $date_text = date('Y年n月j日', strtotime($date)) . '(星期.' . $week[date('N', strtotime($date))] . ')';

        $where = 'WHERE 1=1';
        switch ($odds_status) {
            //即时指数
            case 1:
                $where .= " AND date > '$starttime' AND date < '$endtime'";
                break;
            //已开赛
            case 2:
                $where .= " AND date > '$starttime' AND date < '$endtime'" .
                    " AND status > 0";
                break;
            //历史
            case 3:
                $where .= " AND date > '" . strtotime("$date 00:00:00") . "' AND date < '" . strtotime("$date 23:59:59") . "'";
                break;
            //早盘
            case 4:
                $where .= " AND status = 0 ";
                if (isset($_POST['date'])) {
                    $where .= " AND date > '" . strtotime("$date 00:00:00") . "' AND date < '" . strtotime("$date 23:59:59") . "'";
                } else {
                    $where .= " AND date > '$starttime' AND date < '$endtime'";
                }
                break;
            default:
                break;
        }

        return [$odds_status, $date, $date_text, $where];
    }

    private function odds_schedule($where)
    {
        //即时比分
        $live_sql = "SELECT
                            scheduleid,
                            sclassid,
                            sclassname_cn,
                            sclasscolor,
                            hometeamid,
                            homename_cn,
                            guestteamid,
                            guestname_cn,
                            date,
                            homerank,
                            guestrank,
                            homescore,
                            guestscore,
                            status
                        FROM bt_live_schedule
                        $where
                        ORDER BY date ASC";
        $this->db->query($live_sql);
        $live_games = $this->db->fetch_array();

        //合并
        foreach ($live_games as $key => $game) {
            $live_games[$game['scheduleid']] = $game;
            unset($live_games[$key]);
        }

        return $live_games;
    }

    //球队数据
    public function team(){
        $teamId           = (int)$_GET['teamid'];
        $teamData         = $this->team_db->get_one(['teamid' => $teamId]);
        $teamData['logo'] = BT_TEAM_PATH . $teamId . '.jpg';
        $technicData      = $this->technic_db->select(['teamid' => $teamId]);
        $inWhere          = to_sqls(array_column($technicData, 'scheduleid'), '', '`scheduleid`');
        $seasonData       = $this->schedule_db->select($inWhere, 'scheduleid, sclassseason, sclasscategory, addtime');
        $seasonMapper     = $technicCountData = $letMapper = $totalMapper = [];

        //seo
        $SEO['title'] = $teamData['name_s'] . '球队详细数据资料信息-399彩迷';
        $SEO['keyword'] = $teamData['name_s'] . '球队';
        $SEO['description'] = '399彩迷为您提供最全最详细的' . $teamData['name_s'] . '球队资料,球队数据，包括联赛数据,球队球员信息等相关数据资料。';

        $sclass_info = $this->sclass_db->get_one(['sclassid' => $teamData['sclassid']]);

        foreach ($seasonData as $item) {
            $seasonMapper[$item['scheduleid']] = [
                str_replace('赛季', '', $item['sclassseason']) . '-' . $this->arr_sclasscategory[$item['sclasscategory']],
                $item['addtime'],
                $item['sclasscategory'],
            ];
        }

        foreach ($technicData as $item) {
            $season = $seasonMapper[$item['scheduleid']][0];

            if (!isset($technicCountData[$season])) {
                $technicCountData[$season] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $seasonMapper[$item['scheduleid']][2]];
            }

            // 场数
            $technicCountData[$season][21] += 1;

            if ($seasonMapper[$item['scheduleid']][1] === '0') { // 常规
                if ($item['score'] > $item['lossscore']) {
                    $technicCountData[$season][0] += 1;
                } else {
                    $technicCountData[$season][1] += 1;
                }
            } else { // 加时
                if ($item['score'] > $item['lossscore']) {
                    $technicCountData[$season][2] += 1;
                } else {
                    $technicCountData[$season][3] += 1;
                }
            }

            // 投篮 | 总(场均) 进(场均) 命中率
            $technicCountData[$season][4] += $item['shoot'];
            $technicCountData[$season][5] += $item['shoot_hit'];

            // 三分
            $technicCountData[$season][7] += $item['threemin'];
            $technicCountData[$season][8] += $item['threemin_hit'];

            // 罚球
            $technicCountData[$season][10] += $item['punishball'];
            $technicCountData[$season][11] += $item['punishball_hit'];

            // 篮板 | 进攻 防守 总计
            $technicCountData[$season][13] += $item['attack'];
            $technicCountData[$season][14] += $item['defend'];

            // 助攻 抢断	盖帽	犯规	失误
            $technicCountData[$season][16] += $item['helpattack'];
            $technicCountData[$season][17] += $item['rob'];
            $technicCountData[$season][18] += $item['cover'];
            $technicCountData[$season][19] += $item['foul'];
            $technicCountData[$season][20] += $item['misplay'];
        }

        foreach ($technicCountData as $key => $item) {
            $technicCountData[$key][4] = $technicCountData[$key][4] . '(' . round($technicCountData[$key][4] / $technicCountData[$key][21]) . ')';
            $technicCountData[$key][5] = $technicCountData[$key][5] . '(' . round($technicCountData[$key][5] / $technicCountData[$key][21]) . ')';
            $technicCountData[$key][6] = round($technicCountData[$key][5] / $technicCountData[$key][4], 3) * 100 . '%';

            $technicCountData[$key][7] = $technicCountData[$key][7] . '(' . round($technicCountData[$key][7] / $technicCountData[$key][21]) . ')';
            $technicCountData[$key][8] = $technicCountData[$key][8] . '(' . round($technicCountData[$key][8] / $technicCountData[$key][21]) . ')';
            $technicCountData[$key][9] = round($technicCountData[$key][8] / $technicCountData[$key][7], 3) * 100 . '%';

            $technicCountData[$key][10] = $technicCountData[$key][10] . '(' . round($technicCountData[$key][10] / $technicCountData[$key][21]) . ')';
            $technicCountData[$key][11] = $technicCountData[$key][11] . '(' . round($technicCountData[$key][11] / $technicCountData[$key][21]) . ')';
            $technicCountData[$key][12] = round($technicCountData[$key][11] / $technicCountData[$key][10], 3) * 100 . '%';

            $technicCountData[$key][15] = $technicCountData[$key][13] + $technicCountData[$key][14];
        }

        // 队员
        $player      = $this->player_db->select(['teamid' => $teamId]);
        $sumBirthday = 0;

        foreach ($player as $item) {
            if ($item['place'] === '教练') {
                if ($item['tallness'] != 0) {
                    $foot = (string)round($item['tallness'] / 30.48, 1);

                    if (strpos($foot, '.') === false) {
                        $item['tall_foot'] = $foot . '尺';
                    } else {
                        $footArr           = explode('.', $foot);
                        $item['tall_foot'] = $footArr[0] . '尺' . $footArr[1] . '寸';
                    }

                    $item['tallness'] = $item['tallness'] . 'cm/';
                } else {
                    $item['tallness'] = '';
                }

                if ($item['weight'] != 0) {
                    $pound                = round($item['weight'] / 0.4536);
                    $item['weight_pound'] = $pound . '磅';

                    $item['weight'] = $item['weight'] . 'kg/';
                } else {
                    $item['weight'] = '';
                }

                $coachData          = $item;
                $coachData['photo'] = BT_PLAYER_PATH . $item['playerid'] . '.jpg';
            } else {
                $item['photo']                = BT_PLAYER_PATH . $item['playerid'] . '.jpg';
                $playerData[$item['place']][] = [
                    mb_substr($item['name_cn'], 0, 6),
                    $item['photo'],
                    $item['playerid']
                ];
            }

            $sumBirthday += $item['birthday'];
        }

        $avgBirthday         = round($sumBirthday / count($player));
        $teamData['avg_age'] = $this->age($avgBirthday);

        #--------------------让分--------------------
        $sclass     = $this->sclass_db->get_one(['sclassid' => 1], 'currseason');
        $currseason = $sclass['currseason'];

        if (strpos($currseason, '-') === false) {
            $currseason .= '   ';
        }

        $currseason .= '赛季';

        $currseasonData = $this->schedule_db->select('sclassseason="' . $currseason . '" AND sclassid=1 AND status=-1 AND (guestteamid=' . $teamId . ' OR ' . 'hometeamid=' . $teamId . ')', 'scheduleid,hometeamid,homescore,guestscore');

        $inWhere = to_sqls(array_column($currseasonData, 'scheduleid'), '', '`scheduleid`');
        $let     = $this->let_db->select($inWhere . ' AND companyid=3');

        foreach ($let as $item) {
            $letMapper[$item['scheduleid']] = $item;
        }

        $letData = [
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        foreach ($currseasonData as $item) {
            if ($item['hometeamid'] == $teamId) {
                $letData[0][0] += 1;
                $letData[1][0] += 1;

                if ((float)$letMapper[$item['scheduleid']]['letgoal_f'] < 0) {
                    $letData[0][2] += 1;  // 下盘
                    $letData[1][2] += 1;  // 主场下盘
                } else {
                    $letData[0][1] += 1;  // 上盘
                    $letData[1][1] += 1;  // 主场上盘
                }

                $score    = isset($letMapper[$item['scheduleid']]) ? $letMapper[$item['scheduleid']]['letgoal'] : 0;
                $letCount = $this->getLetCount((int)$item['homescore'], (int)$item['guestscore'], $score);

                if ($letCount > 0) { // 主场-胜
                    $letData[0][3] += 1;
                    $letData[1][3] += 1;
                } elseif ($letCount == 0) { // 主场-走
                    $letData[0][4] += 1;
                    $letData[1][4] += 1;
                } else { // 主场-负
                    $letData[0][5] += 1;
                    $letData[1][5] += 1;
                }
            } else {
                $letData[0][0] += 1;
                $letData[2][0] += 1;

                if ((float)$letMapper[$item['scheduleid']]['letgoal_f'] < 0) {
                    $letData[0][2] += 1;  // 下盘
                    $letData[2][2] += 1;  // 主场下盘
                } else {
                    $letData[0][1] += 1;  // 上盘
                    $letData[2][1] += 1;  // 主场上盘
                }

                $score    = isset($letMapper[$item['scheduleid']]) ? $letMapper[$item['scheduleid']]['letgoal'] : 0;
                $letCount = $this->getLetCount((int)$item['homescore'], (int)$item['guestscore'], $score);

                if ($letCount < 0) { // 主场-胜
                    $letData[0][3] += 1;
                    $letData[2][3] += 1;
                } elseif ($letCount == 0) { // 主场-走
                    $letData[0][4] += 1;
                    $letData[2][4] += 1;
                } else { // 主场-负
                    $letData[0][5] += 1;
                    $letData[2][5] += 1;
                }
            }
        }

        // 净
        $letData[0][6] = $letData[0][3] - $letData[0][5];
        $letData[1][6] = $letData[1][3] - $letData[1][5];
        $letData[2][6] = $letData[2][3] - $letData[2][5];

        // 胜
        $letData[0][7] = round($letData[0][3] / $letData[0][0], 3) * 100;
        $letData[1][7] = round($letData[1][3] / $letData[1][0], 3) * 100;
        $letData[2][7] = round($letData[2][3] / $letData[2][0], 3) * 100;

        // 走
        $letData[0][8] = round($letData[0][4] / $letData[0][0], 3) * 100;
        $letData[1][8] = round($letData[1][4] / $letData[1][0], 3) * 100;
        $letData[2][8] = round($letData[2][4] / $letData[2][0], 3) * 100;

        // 负
        $letData[0][9] = 100 - $letData[0][7] - $letData[0][8];
        $letData[1][9] = 100 - $letData[1][7] - $letData[1][8];
        $letData[2][9] = 100 - $letData[2][7] - $letData[2][8];

        #----------------大小分----------------
        $inWhere = to_sqls(array_column($currseasonData, 'scheduleid'), '', '`scheduleid`');
        $total   = $this->total_db->select($inWhere . ' AND companyid=6');

        foreach ($total as $item) {
            $totalMapper[$item['scheduleid']] = $item;
        }

        $totalData = [
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        foreach ($currseasonData as $item) {
            if ($item['hometeamid'] == $teamId) {
                $totalData[0][0] += 1;
                $totalData[1][0] += 1;

                $score      = isset($totalMapper[$item['scheduleid']]) ? $totalMapper[$item['scheduleid']]['totalscore'] : 0;
                $totalCount = $this->getLetCount((int)$item['homescore'], (int)$item['guestscore'], $score, 1);

                if ($totalCount > 0) { // 主场-胜
                    $totalData[0][1] += 1;
                    $totalData[1][1] += 1;
                } elseif ($totalCount == 0) { // 主场-走
                    $totalData[0][2] += 1;
                    $totalData[1][2] += 1;
                } else { // 主场-负
                    $totalData[0][3] += 1;
                    $totalData[1][3] += 1;
                }
            } else {
                $totalData[0][0] += 1;
                $totalData[2][0] += 1;

                $score      = isset($totalMapper[$item['scheduleid']]) ? $totalMapper[$item['scheduleid']]['totalscore'] : 0;
                $totalCount = $this->getLetCount((int)$item['homescore'], (int)$item['guestscore'], $score, 1);

                if ($totalCount < 0) { // 主场-胜
                    $totalData[0][1] += 1;
                    $totalData[2][1] += 1;
                } elseif ($totalCount == 0) { // 主场-走
                    $totalData[0][2] += 1;
                    $totalData[2][2] += 1;
                } else { // 主场-负
                    $totalData[0][3] += 1;
                    $totalData[2][3] += 1;
                }
            }
        }

        // 净
        $totalData[0][6] = $totalData[0][3] - $totalData[0][5];
        $totalData[1][6] = $totalData[1][3] - $totalData[1][5];
        $totalData[2][6] = $totalData[2][3] - $totalData[2][5];

        // 胜
        $totalData[0][4] = round($totalData[0][1] / $totalData[0][0], 3) * 100;
        $totalData[1][4] = round($totalData[1][1] / $totalData[1][0], 3) * 100;
        $totalData[2][4] = round($totalData[2][1] / $totalData[2][0], 3) * 100;

        // 走
        $totalData[0][5] = round($totalData[0][2] / $totalData[0][0], 3) * 100;
        $totalData[1][5] = round($totalData[1][2] / $totalData[1][0], 3) * 100;
        $totalData[2][5] = round($totalData[2][2] / $totalData[2][0], 3) * 100;

        // 负
        $totalData[0][6] = 100 - $totalData[0][4] - $totalData[0][5];
        $totalData[1][6] = 100 - $totalData[1][4] - $totalData[1][5];
        $totalData[2][6] = 100 - $totalData[2][4] - $totalData[2][5];


        include template('sportsdata', 'bt_team');
    }

    private function age($birthday) {
        $age = $birthday;

        list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age));
        list($y2,$m2,$d2) = explode("-",date("Y-m-d",time()));
        $age = $y2 - $y1;

        if((int)($m2.$d2) < (int)($m1.$d1)) {
            $age -= 1;
        }

        return $age;
    }

    //球队赛程
    public function team_schedule()
    {
        $teamid = $_GET['teamid'];
        $page   = $_GET['page'] ? (int)$_GET['page'] : 1;

        //球队信息
        $team_db                = pc_base::load_model('bt_team_model');
        $team_info              = $team_db->get_one(['teamid' => $teamid]);
        $team_info['logo']      = BT_TEAM_PATH . $teamid . '.jpg';
        $team_info['joinyear']  = $team_info['joinyear'] ? $team_info['joinyear'] . '年' : '&nbsp;';

        //球员、教练信息
        $player_db  = pc_base::load_model('bt_player_model');
        $players    = $player_db->select(['teamid' => $teamid]);

        $drillmaster_info   = [];
        $player_info        = [];
        foreach ($players as $player) {
            $player['photo'] = BT_PLAYER_PATH . $player['playerid'] . '.jpg';

            if ($player['place'] === '教练') {
                $player['birthday'] = $player['birthday'] ? date('Y-m-d', $player['birthday']) : '';

                //身高 1英寸(inch)= 2.54厘米(cm) 1英尺(foot)= 12英寸 = 30.48厘米
                if ($player['tallness']) {
                    $foot               = floor($player['tallness'] / 30.48);
                    $inch               = floor(($player['tallness'] - $foot * 30.48) / 2.54);
                    $player['tallness'] = $player['tallness'] . 'cm/' . ($inch ? $foot . '尺' . $inch . '寸' : $foot . '尺');
                } else {
                    $player['tallness'] = '';
                }

                //体重 1英磅=16盎司=0.454千克(公斤)=0.907市斤
                if ($player['weight']) {
                    $pound            = floor($player['weight'] / 0.454);
                    $player['weight'] = $player['weight'] . 'kg/' . $pound . '磅';
                } else {
                    $player['weight'] = '';
                }

                $drillmaster_info = $player;
            } else {
                $player_info[$player['place']][] = $player;
            }
        }

        $team_info['avg_age'] = abs((int)date('Y', array_sum(array_column($players, 'birthday')) / count($players)) - (int)date('Y'));

        //联赛信息
        $sclassid    = $team_info['sclassid'];
        $sclass_info = $this->sclass_db->get_one(['sclassid' => $sclassid]);

        //球队赛程
        $schedule_info = $this->schedule_db->listinfo('`hometeamid`=' . $teamid . ' OR `guestteamid`=' . $teamid, '`date` DESC', $page, 30);
        $pages = $this->schedule_db->pages;

        foreach ($schedule_info as &$info) {
            $info['date'] = date('Y/m/d H:i', $info['date']);
            $info['whole'] = $info['homescore'] ? $info['homescore'] . '-' . $info['guestscore'] : '';
            $info['homehalf'] = $info['homeone'] + $info['hometwo'];
            $info['guesthalf'] = $info['guestone'] + $info['guesttwo'];
            $info['half'] = $info['homehalf'] ? $info['homehalf'] . '-' . $info['guesthalf'] : '';
        }

        include template('sportsdata', 'bt_team_schedule');
    }

    //球队阵容
    public function team_lineup()
    {
        $teamid = $_GET['teamid'];

        //球队信息
        $team_db                = pc_base::load_model('bt_team_model');
        $team_info              = $team_db->get_one(['teamid' => $teamid]);
        $team_info['logo']      = BT_TEAM_PATH . $teamid . '.jpg';
        $team_info['joinyear']  = $team_info['joinyear'] ? $team_info['joinyear'] . '年' : '&nbsp;';

        //球员、教练信息
        $player_db  = pc_base::load_model('bt_player_model');
        $players    = $player_db->select(['teamid' => $teamid]);

        $drillmaster_info   = [];
        $player_info        = [];
        foreach ($players as $player) {
            $player['photo'] = BT_PLAYER_PATH . $player['playerid'] . '.jpg';

            if ($player['place'] === '教练') {
                $player['birthday'] = $player['birthday'] ? date('Y-m-d', $player['birthday']) : '';

                //身高 1英寸(inch)= 2.54厘米(cm) 1英尺(foot)= 12英寸 = 30.48厘米
                if ($player['tallness']) {
                    $foot = floor($player['tallness'] / 30.48);
                    $inch = floor(($player['tallness'] - $foot * 30.48) / 2.54);
                    $player['tallness'] = $player['tallness'] . 'cm/' . ($inch ? $foot . '尺' . $inch . '寸' : $foot . '尺');
                } else {
                    $player['tallness'] = '';
                }

                //体重 1英磅=16盎司=0.454千克(公斤)=0.907市斤
                if ($player['weight']) {
                    $pound = floor($player['weight'] / 0.454);
                    $player['weight'] = $player['weight'] . 'kg/' . $pound . '磅';
                } else {
                    $player['weight'] = '';
                }

                $drillmaster_info = $player;
            } else {
                $player_info[$player['place']][] = $player;
            }
        }

        $team_info['avg_age'] = abs((int)date('Y', array_sum(array_column($players, 'birthday')) / count($players)) - (int)date('Y'));

        //联赛信息
        $sclassid    = $team_info['sclassid'];
        $sclass_info = $this->sclass_db->get_one(['sclassid' => $sclassid]);

        foreach ($players as &$player) {
            $player['birthday'] = date('Y-m-d', $player['birthday']);
            $player['number'] = $player['number'] ? $player['number'] : '';
        }

        include template('sportsdata', 'bt_team_lineup');
    }

    //球员转会
    public function team_transfer()
    {
        $teamid = $_GET['teamid'];

        //球队信息
        $team_db                = pc_base::load_model('bt_team_model');
        $team_info              = $team_db->get_one(['teamid' => $teamid]);
        $team_info['logo']      = BT_TEAM_PATH . $teamid . '.jpg';
        $team_info['joinyear']  = $team_info['joinyear'] ? $team_info['joinyear'] . '年' : '&nbsp;';

        //球员、教练信息
        $player_db  = pc_base::load_model('bt_player_model');
        $players    = $player_db->select(['teamid' => $teamid]);

        $drillmaster_info   = [];
        $player_info        = [];
        foreach ($players as $player) {
            $player['photo'] = BT_PLAYER_PATH . $player['playerid'] . '.jpg';

            if ($player['place'] === '教练') {
                $player['birthday'] = $player['birthday'] ? date('Y-m-d', $player['birthday']) : '';

                //身高 1英寸(inch)= 2.54厘米(cm) 1英尺(foot)= 12英寸 = 30.48厘米
                if ($player['tallness']) {
                    $foot = floor($player['tallness'] / 30.48);
                    $inch = floor(($player['tallness'] - $foot * 30.48) / 2.54);
                    $player['tallness'] = $player['tallness'] . 'cm/' . ($inch ? $foot . '尺' . $inch . '寸' : $foot . '尺');
                } else {
                    $player['tallness'] = '';
                }

                //体重 1英磅=16盎司=0.454千克(公斤)=0.907市斤
                if ($player['weight']) {
                    $pound = floor($player['weight'] / 0.454);
                    $player['weight'] = $player['weight'] . 'kg/' . $pound . '磅';
                } else {
                    $player['weight'] = '';
                }

                $drillmaster_info = $player;
            } else {
                $player_info[$player['place']][] = $player;
            }
        }

        $team_info['avg_age'] = abs((int)date('Y', array_sum(array_column($players, 'birthday')) / count($players)) - (int)date('Y'));

        //联赛信息
        $sclassid    = $team_info['sclassid'];
        $sclass_info = $this->sclass_db->get_one(['sclassid' => $sclassid]);

        //球员转会
        $transfer_db = pc_base::load_model('bt_transfer_model');
        $transfer_info = $transfer_db->select('`srcteamid`=' . $teamid . ' OR `destteamid`=' . $teamid, '*', '', '`date` DESC');
        $transfer_players = $player_db->select(to_sqls(array_column($transfer_info, 'playerid'), '', '`playerid`'), '*', '', '', '', 'playerid');

        $transfer_type = [
            0 => '空或未知',
            1 => '交易',
            2 => '续约',
            3 => '解约',
            4 => '自由签约',
            5 => '选秀'
        ];

        foreach ($transfer_info as &$info) {
            $info['type'] = $transfer_type[$info['type']];
            $info['place'] = $transfer_players[$info['playerid']]['place'];
            $info['name'] = $transfer_players[$info['playerid']]['name_s'];
        }

        include template('sportsdata', 'bt_team_transfer');
    }

    //球员
    public function player()
    {
        $playerid = $_GET['playerid'];

        $playerinfo = $this->player_db->get_one(['playerid' => $playerid]);

        //seo
        $SEO['title'] = $playerinfo['name_s'] . '球员详细数据资料信息-399彩迷';
        $SEO['keyword'] = $playerinfo['name_s'] . '球员';
        $SEO['description'] = '399彩迷为您提供最全最详细的' . $playerinfo['name_s'] . '球员资料,球员数据，包括球员联赛数据等相关资料。';

        $playerinfo['photo'] = BT_PLAYER_PATH . $playerid . '.jpg';
        $playerinfo['birthday'] = $playerinfo['birthday'] ? date('Y-m-d', $playerinfo['birthday']) : '';

        $playerinfo['tallness'] = $playerinfo['tallness'] . 'cm';
        $playerinfo['weight'] = $playerinfo['weight'] . 'kg';

        //球队信息
        $teamid     = $playerinfo['teamid'];
        $team_info  = $this->team_db->get_one(['teamid' => $teamid]);

        //球员、教练信息
        $players    = $this->player_db->select(['teamid' => $teamid]);

        $drillmaster_info   = [];
        $player_info        = [];
        foreach ($players as $player) {
            $player['photo'] = BT_PLAYER_PATH . $player['playerid'] . '.jpg';

            if ($player['place'] === '教练') {
                $player['birthday'] = $player['birthday'] ? date('Y-m-d', $player['birthday']) : '';

                if ($player['tallness']) {
                    $foot = floor($player['tallness'] / 30.48);
                    $inch = floor(($player['tallness'] - $foot * 30.48) / 2.54);
                    $player['tallness'] = $player['tallness'] . 'cm/' . ($inch ? $foot . '尺' . $inch . '寸' : $foot . '尺');
                } else {
                    $player['tallness'] = '';
                }

                if ($player['weight']) {
                    $pound = floor($player['weight'] / 0.454);
                    $player['weight'] = $player['weight'] . 'kg/' . $pound . '磅';
                } else {
                    $player['weight'] = '';
                }

                $drillmaster_info = $player;
            } else {
                $player_info[$player['place']][] = $player;
            }
        }

        //联赛信息
        $sclassid    = $team_info['sclassid'];
        $sclass_info = $this->sclass_db->get_one(['sclassid' => $sclassid]);

        #-----------------技术统计---------------
        $sql = "SELECT a.*,
                       b.hometeamid,
                       b.guestteamid,
                       b.homescore,
                       b.guestscore,
                       b.sclassseason AS season,
                       b.sclasscategory AS category
                FROM bt_player_technic a
                LEFT JOIN bt_schedule b ON a.scheduleid=b.scheduleid
                WHERE a.playerid = $playerid";

        $rst = $this->db->query($sql);
        $raw = $this->db->fetch_array($rst, MYSQLI_ASSOC);

        $team_ids = array_unique(array_column($raw, 'teamid'));
        $team_infos = $this->team_db->select(to_sqls($team_ids, '', '`teamid`'), '`teamid`,`name_cn`', '', '', '', 'teamid');

        $category = [
            0 => '赛季',
            1 => '常规赛',
            2 => '季后赛',
            3 => '季前赛'
        ];

        $style = [
            1 => 'normal',  //常规赛
            2 => 'back',    //季后赛
            3 => 'front'    //季前赛
        ];

        $stat = [];
        foreach ($raw as $r) {
            $cat = str_replace([' ', '赛季'], '', $r['season']) . $category[$r['category']];

            if ($stat[$cat]) {
                $stat[$cat]['total'] += 1;
                $stat[$cat]['first'] += $r['firstjoin'] ? 1 : 0;
                $stat[$cat]['first_win'] += $r['firstjoin'] ? ($this->win($r) ? 1 : 0) : 0;         //首发赢的次数
                $stat[$cat]['reserve'] += $r['firstjoin'] ? 0 : 1;
                $stat[$cat]['reserve_win'] += $r['firstjoin'] ? 0 : ($this->win($r) ? 1 : 0);       //替补赢的次数

                $stat[$cat]['playtime'] += $r['playtime'];

                $stat[$cat]['shoot'] += $r['shoot'];
                $stat[$cat]['shoot_hit'] += $r['shoot_hit'];
                $stat[$cat]['threemin'] += $r['threemin'];
                $stat[$cat]['threemin_hit'] += $r['threemin_hit'];
                $stat[$cat]['punishball'] += $r['punishball'];
                $stat[$cat]['punishball_hit'] += $r['punishball_hit'];

                $stat[$cat]['attack'] += $r['attack'];
                $stat[$cat]['defend'] += $r['defend'];
                $stat[$cat]['attack_defend'] += $r['attack'] + $r['defend'];

                $stat[$cat]['helpattack'] += $r['helpattack'];
                $stat[$cat]['rob'] += $r['rob'];
                $stat[$cat]['cover'] += $r['cover'];
                $stat[$cat]['misplay'] += $r['misplay'];
                $stat[$cat]['foul'] += $r['foul'];
                $stat[$cat]['score'] += $r['score'];
            } else {
                $stat[$cat]['teamid'] = $r['teamid'];
                $stat[$cat]['name_cn'] = $team_infos[$r['teamid']]['name_cn'];

                $stat[$cat]['style'] = $style[$r['category']]; //样式类名

                $stat[$cat]['total'] = 1;
                $stat[$cat]['first'] = $r['firstjoin'] ? 1 : 0;
                $stat[$cat]['first_win'] = $r['firstjoin'] ? ($this->win($r) ? 1 : 0) : 0;         //首发赢的次数
                $stat[$cat]['reserve'] = $r['firstjoin'] ? 0 : 1;
                $stat[$cat]['reserve_win'] = $r['firstjoin'] ? 0 : ($this->win($r) ? 1 : 0);       //替补赢的次数

                $stat[$cat]['playtime'] = $r['playtime'];

                $stat[$cat]['shoot'] = $r['shoot'];
                $stat[$cat]['shoot_hit'] = $r['shoot_hit'];
                $stat[$cat]['threemin'] = $r['threemin'];
                $stat[$cat]['threemin_hit'] = $r['threemin_hit'];
                $stat[$cat]['punishball'] = $r['punishball'];
                $stat[$cat]['punishball_hit'] = $r['punishball_hit'];

                $stat[$cat]['attack'] = $r['attack'];
                $stat[$cat]['defend'] = $r['defend'];
                $stat[$cat]['attack_defend'] = $r['attack'] + $r['defend'];

                $stat[$cat]['helpattack'] = $r['helpattack'];
                $stat[$cat]['rob'] = $r['rob'];
                $stat[$cat]['cover'] = $r['cover'];
                $stat[$cat]['misplay'] = $r['misplay'];
                $stat[$cat]['foul'] = $r['foul'];
                $stat[$cat]['score'] = $r['score'];
            }
        }

        foreach ($stat as &$r) {
            $r['first_win_rate'] = (round($r['first_win'] / $r['first'], 3) * 100) . '%'; //首发胜率
            $r['reserve_win_rate'] = (round($r['reserve_win'] / $r['reserve'], 3) * 100) . '%'; //替补胜率

            $r['avg_playtime'] = round($r['playtime']/$r['total'], 1); //平均时长

            $r['shoot_hit_rate'] = (round($r['shoot_hit'] / $r['shoot'], 3) * 100) . '%'; //投篮命中率
            $r['threemin_hit_rate'] = (round($r['threemin_hit'] / $r['threemin'], 3) * 100) . '%'; //三分命中率
            $r['punishball_hit_rate'] = (round($r['punishball_hit'] / $r['punishball'], 3) * 100) . '%'; //罚球命中率

            $r['avg_attack'] = round($r['attack']/$r['total'], 1); //平均进攻篮板
            $r['avg_defend'] = round($r['defend']/$r['total'], 1); //平均防守篮板
            $r['avg_attack_defend'] = round($r['attack_defend']/$r['total'], 1); //平均进攻防守篮板

            $r['avg_helpattack'] = round($r['helpattack']/$r['total'], 1); //平均助攻
            $r['avg_rob'] = round($r['rob']/$r['total'], 1); //平均抢断
            $r['avg_cover'] = round($r['cover']/$r['total'], 1); //平均盖帽
            $r['avg_misplay'] = round($r['misplay']/$r['total'], 1); //平均失误
            $r['avg_foul'] = round($r['foul']/$r['total'], 1); //平均犯规
            $r['avg_score'] = round($r['score']/$r['total'], 1); //平均得分
        }

        #---------------当前赛季-------------
        $currseason = $sclass_info['currseason'].'常规赛';

        if ($stat[$currseason]) {
            $playerinfo['avg_score'] = $stat[$currseason]['avg_score'];
            $playerinfo['avg_helpattack'] = $stat[$currseason]['avg_helpattack'];
            $playerinfo['avg_attack_defend'] = $stat[$currseason]['avg_attack_defend'];
        }

        include template('sportsdata', 'bt_player');
    }

    private function win($r)
    {
        if($r['teamid'] === $r['hometeamid']){
            return $r['homescore'] > $r['guestscore'] ? true : false;
        }else{
            return $r['homescore'] > $r['guestscore'] ? false : true;
        }
    }

    //资料库
    public function event()
    {
        $SEO['title'] = '篮球数据库-399彩迷';
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
                    $stat[$key]['country'][$r['countryname']][] = $sclass_info;
                    break;
                }

                if (in_array($r['countryid'], $value['zone'])) {
                    $stat[$key]['zone'][] = $sclass_info;
                    break;
                }
            }
        }

        #--------------------赛事推荐-----------------
        $hot_event = $this->db->select('`status` >= 0 AND `date` > ' . SYS_TIME, '`scheduleid`,`hometeamid`,
        `homename_cn`,`guestteamid`,`guestname_cn`,`date`,`homescore`,`guestscore`', 6, '`date` ASC');

        if (!$hot_event) {
            $hot_event = $this->schedule_db->select('`status` >= 0 AND `date` > ' . SYS_TIME, '`scheduleid`,`hometeamid`,
        `homename_cn`,`guestteamid`,`guestname_cn`,`date`,`homescore`,`guestscore`', 6, '`date` ASC');

        }

        foreach ($hot_event as &$r) {
            $r['home_logo'] = BT_TEAM_PATH . $r['hometeamid'] . '.jpg';
            $r['guest_logo'] = BT_TEAM_PATH . $r['guestteamid'] . '.jpg';
            $r['home_url'] = APP_PATH . 'lq/team/' . $r['hometeamid'] . '/';
            $r['guest_url'] = APP_PATH . 'lq/team/' . $r['guestteamid'] . '/';
            $r['url'] = APP_PATH . 'schedule/' . $r['scheduleid'] . '/analyse/';

            foreach (['homename' => $r['homename_cn'], 'guestname' => $r['guestname_cn']] as $name => $val) {
                if (mb_strlen($val, 'utf-8') > 6) {
                    $r[$name] = mb_substr($val, 0, 6, 'utf-8');
                } else {
                    $r[$name] = $val;
                }
            }
        }

        unset($r);

        include template('sportsdata', 'bt_event');
    }

    //赛程赛果
    public function sclass_schedule(){
        //树形菜单
        $tree = $this->_event();
        //联赛
        $sclass_id = $id = $_REQUEST['sclassid'];
        $where = '`sclassid`=' . $sclass_id;
        $sclass_info = $this->sclass_db->get_one($where);
        //seo
        $SEO['title'] = $sclass_info['name_s'] . '_比赛数据-399彩迷网';
        $SEO['keyword'] = $sclass_info['name_s'] . '，比赛数据资料';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . $sclass_info['name_s'] . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';
        //赛季
        $season_arr = $this->_season_info($sclass_id);
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
            //默认公司
            $company_id = 2;
            $other_where = '`scheduleid` IN (' . join(',', $schedule_ids) . ') AND `companyid`=' . $company_id;
            //让分
            $let_goal_info = $this->let_db->select($other_where, '`scheduleid`,`letgoal`', '', '`modifytime` DESC', '', 'scheduleid');
            //总分
            $total_score_info = $this->total_db->select($other_where, '`scheduleid`,`totalscore`', '', '`modifytime` DESC', '', 'scheduleid');
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
                //让分
                $value['letgoal'] = $let_goal_info[$key]['letgoal'];
                //总分
                $value['totalscore'] = $total_score_info[$key]['totalscore'];
                //半场
                $value['half']['home'] = $value['homeone'] + $value['hometwo'];
                $value['half']['guest'] = $value['guestone'] + $value['guesttwo'];
                //分组
                $date = str_replace($date_replace[0], $date_replace[1], date('Y-m-d 星期(N)', $value['date']));
                $info[$value['sclasscategory']][$date][] = $value;
                //类别整理
                if ($value['category']) {
                    $category_arr[$value['sclasscategory']][$value['category']][] = $value['subcategory'];
                }
            }
            //按日期排序
            foreach ($info as &$_info) {
                ksort($_info);
            }
            //类别重新处理
            foreach ($category_arr as $key => $category) {
                foreach ($category as $type => $subcategory) {
                    $category_arr[$key][$type] = array_unique($subcategory);
                }
            }
        }

        include template('sportsdata', 'bt_sclass_schedule');
    }

    //联盟排名
    public function sclass_standings(){
        //树形菜单
        $tree = $this->_event();
        //联赛
        $sclass_id = $id = $_REQUEST['sclassid'];
        $where = '`sclassid`=' . $sclass_id;
        $sclass_info = $this->sclass_db->get_one($where);
        //seo
        $SEO['title'] = $sclass_info['name_s'] . '_积分表-399彩迷网';
        $SEO['keyword'] = $sclass_info['name_s'] . '，积分表';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . $sclass_info['name_s'] . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';
        //赛季
        $season_arr = $this->_season_info($sclass_id);
        $season = str_replace('赛季', '', ($_REQUEST['season'] ? $_REQUEST['season'] : $season_arr[0]));
        $where .= $season ? ' AND `season`="' . $season . '"' : '';
        $standings_info = $this->standings_db->standings($where);
        //更新时间
        $update_time = $this->_update_time('bt_team_standings');
        include template('sportsdata', 'bt_sclass_standings');
    }

    //让球盘路榜
    public function sclass_letgoal(){
        //树形菜单
        $tree = $this->_event();
        //联赛
        $sclass_id = $id =  $_REQUEST['sclassid'];
        $where = '`sclassid`=' . $sclass_id;
        $sclass_info = $this->sclass_db->get_one($where);
        //seo
        $SEO['title'] = $sclass_info['name_s'] . '_让球盘路榜-399彩迷网';
        $SEO['keyword'] = $sclass_info['name_s'] . '，让球盘路榜';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . $sclass_info['name_s'] . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';
        //赛季
        $season_arr = $this->_season_info($sclass_id);
        $season = $_REQUEST['season'] ? $_REQUEST['season'] : $season_arr[0];
        $where .= $season ? ' AND `status`=-1 AND `sclasscategory`=2 AND `sclassseason`="' . $season . '"' : ' AND `status`=-1 AND `sclasscategory`=2 ';
        list($standings_info, $stats) = $this->let_db->standings($where);
        //球队信息
        $team_arr = $this->let_db->team_arr;
        //更新时间
        $update_time = $this->_update_time('bt_letgoal');
        include template('sportsdata', 'bt_sclass_letgoal');
    }

    //大小盘路榜
    public function sclass_totalscore(){
        //树形菜单
        $tree = $this->_event();
        //联赛
        $sclass_id = $id = $_REQUEST['sclassid'];
        $where = '`sclassid`=' . $sclass_id;
        $sclass_info = $this->sclass_db->get_one($where);
        //seo
        $SEO['title'] = $sclass_info['name_s'] . '_大小盘路榜-399彩迷网';
        $SEO['keyword'] = $sclass_info['name_s'] . '，大小盘路榜';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . $sclass_info['name_s'] . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';
        //赛季
        $season_arr = $this->_season_info($sclass_id);
        $season = $_REQUEST['season'] ? $_REQUEST['season'] : $season_arr[0];
        $where .= $season ? ' AND `status`=-1 AND `sclasscategory`=2 AND `sclassseason`="' . $season . '"' : ' AND `status`=-1 AND `sclasscategory`=2 ';
        list($standings_info, $stats) = $this->total_db->standings($where);
        //球队信息
        $team_arr = $this->total_db->team_arr;
        //更新时间
        $update_time = $this->_update_time('bt_totalscore');
        include template('sportsdata', 'bt_sclass_totalscore');
    }

    //单双统计
    public function sclass_single_double()
    {
        $sclassid = $id = $_GET['sclassid'] ? (int)$_GET['sclassid'] : 1;

        //赛事菜单
        $event_menu = $this->_event();

        //联赛信息
        $sclass_info = $this->sclass_db->get_one(['sclassid' => $sclassid]);

        //seo
        $SEO['title'] = $sclass_info['name_s'] . '_单双统计-399彩迷网';
        $SEO['keyword'] = $sclass_info['name_s'] . '，单双统计';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . $sclass_info['name_s'] . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        if (strpos($sclass_info['currseason'], '-') !== false) {
            $tmp_arr = explode('-', $sclass_info['currseason']);
            $sclass_info['season'] = '20' . $tmp_arr[0] . '-20' . $tmp_arr[1];
            $season = $sclass_info['currseason'] . '赛季';
        } else {
            $sclass_info['season'] = '20' . $sclass_info['currseason'];
            $season = $sclass_info['currseason'] . '   赛季';
        }

        #---------------------当前赛季----------------
        $data = $this->schedule_db->select(['sclassid' => $sclassid, 'sclassseason' => $season]);

        $stat = [];
        foreach ($data as $r) {
            //主队
            if ($stat[$r['hometeamid']]) {
                $stat[$r['hometeamid']]['total'] += 1;
                $stat[$r['hometeamid']]['full_single'] += $this->single($r['homescore']) ? 1 : 0;
                $stat[$r['hometeamid']]['half_single'] += $this->single($r['homeone'] + $r['hometwo']) ? 1 : 0;

            } else {
                $stat[$r['hometeamid']]['teamid'] = $r['hometeamid'];
                $stat[$r['hometeamid']]['teamname'] = $r['homename_cn'];
                $stat[$r['hometeamid']]['total'] = 1;
                $stat[$r['hometeamid']]['full_single'] = $this->single($r['homescore']) ? 1 : 0;
                $stat[$r['hometeamid']]['half_single'] = $this->single($r['homeone'] + $r['hometwo']) ? 1 : 0;
            }

            //客队
            if ($stat[$r['guestteamid']]) {
                $stat[$r['guestteamid']]['total'] += 1;
                $stat[$r['guestteamid']]['full_single'] += $this->single($r['guestscore']) ? 1 : 0;
                $stat[$r['guestteamid']]['half_single'] += $this->single($r['guestone'] + $r['guesttwo']) ? 1 : 0;

            } else {
                $stat[$r['guestteamid']]['teamid'] = $r['guestteamid'];
                $stat[$r['guestteamid']]['teamname'] = $r['guestname_cn'];
                $stat[$r['guestteamid']]['total'] = 1;
                $stat[$r['guestteamid']]['full_single'] = $this->single($r['guestscore']) ? 1 : 0;
                $stat[$r['guestteamid']]['half_single'] = $this->single($r['guestsone'] + $r['guesttwo']) ? 1 : 0;
            }
        }

        foreach ($stat as $teamid => $r) {
            $stat[$teamid]['full_double'] = $r['total'] - $r['full_single'];
            $stat[$teamid]['half_double'] = $r['total'] - $r['half_single'];

            $stat[$teamid]['full_single_rate'] = round($r['full_single'] / $r['total'], 3) * 100;
            $stat[$teamid]['full_double_rate'] = round($stat[$teamid]['full_double'] / $r['total'], 3) * 100;
            $stat[$teamid]['half_single_rate'] = round($r['half_single'] / $r['total'], 3) * 100;
            $stat[$teamid]['half_double_rate'] = round($stat[$teamid]['half_double'] / $r['total'], 3) * 100;
        }

        include template('sportsdata', 'bt_sclass_single_double');
    }

    private function single($number)
    {
        return (int)$number % 2 === 0 ? false : true;
    }

    private function _event()
    {
        $area = [
            '欧洲赛事' => [3, 6, 7, 8, 9, 11, 12, 13, 24, 28, 25, 26, 27, 57, 29, 35, 32, 36, 31, 30, 33, 37, 39, 40,
                41, 43, 44, 46, 38, 47, 48, 49, 53, 54, 55, 59],
            '美洲赛事' => [1, 45, 34, 51],
            '亚洲赛事' => [2, 10, 22, 23, 42, 58, 61, 84, 85],
            '国际赛事' => [16, 17, 18, 19, 20]
        ];

        $raw = $this->sclass_db->select('', '*', '', '`countryid` ASC');

        $stat = [];

        foreach ($raw as $r) {
            $sclass_info = ['sclassid' => $r['sclassid'], 'name' => $r['name_s']];

            foreach ($area as $name => $value) {
                if (in_array($r['countryid'], $value)) {
                    $stat[$name][$r['countryname']][] = $sclass_info;
                    break;
                }
            }
        }

        return $stat;
    }

    //球队技术统计
    public function sclass_technic_team()
    {
        $sclassid = $id = $_GET['sclassid'] ? (int)$_GET['sclassid'] : 1;

        //赛事菜单
        $event_menu = $this->_event();

        //联赛信息
        $sclass_info = $this->sclass_db->get_one(['sclassid' => $sclassid]);

        //seo
        $SEO['title'] = $sclass_info['name_s'] . '_球队技术统计-399彩迷网';
        $SEO['keyword'] = $sclass_info['name_s'] . '，球队技术统计';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . $sclass_info['name_s'] . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

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

        include template('sportsdata', 'bt_sclass_technic_team');
    }

    //球员技术统计
    public function sclass_technic_player()
    {
        $sclassid = $id = $_GET['sclassid'] ? (int)$_GET['sclassid'] : 1;

        //赛事菜单
        $event_menu = $this->_event();

        //联赛信息
        $sclass_info = $this->sclass_db->get_one(['sclassid' => $sclassid]);

        //seo
        $SEO['title'] = $sclass_info['name_s'] . '_球员技术统计-399彩迷网';
        $SEO['keyword'] = $sclass_info['name_s'] . '，球员技术统计';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . $sclass_info['name_s'] . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

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
                $tmp['double_2'] += (int)$r['tag'] === 2 ? 1 : 0; //两双
                $tmp['double_3'] += (int)$r['tag'] === 3 ? 1 : 0; //三双
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
                $tmp['double_2'] = (int)$r['tag'] === 2 ? 1 : 0; //两双
                $tmp['double_3'] = (int)$r['tag'] === 3 ? 1 : 0; //三双
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
        include template('sportsdata', 'bt_sclass_technic_player');
    }

    //球队资料
    public function sclass_team()
    {
        $sclassid = $id = $_GET['sclassid'] ? (int)$_GET['sclassid'] : 1;

        //赛事菜单
        $event_menu = $this->_event();

        //联赛信息
        $sclass_info = $this->sclass_db->get_one(['sclassid' => $sclassid]);

        //seo
        $SEO['title'] = $sclass_info['name_s'] . '_球队资料-399彩迷网';
        $SEO['keyword'] = $sclass_info['name_s'] . '，球队资料';
        $SEO['description'] = '399彩迷为您提供，专业精准的' . $sclass_info['name_s'] . '赛事数据统计，包括积分数据统计,球场数据统计,进球失球详细说明，以及每日波胆发布等。';

        if (strpos($sclass_info['currseason'], '-') !== false) {
            $tmp_arr = explode('-', $sclass_info['currseason']);
            $sclass_info['season'] = '20' . $tmp_arr[0] . '-20' . $tmp_arr[1];
        } else {
            $sclass_info['season'] = '20' . $sclass_info['currseason'];
        }

        $team_info = $this->team_db->select(['sclassid'=>$sclassid], '`teamid`,`name_cn`');

        foreach ($team_info as &$r) {
            $r['logo'] = BT_TEAM_PATH . $r['teamid'] . '.jpg';
            $r['url'] = APP_PATH . 'lq/team/' . $r['teamid'] . '/';
        }

        unset($r);

        include template('sportsdata', 'bt_sclass_team');
    }

    //获取联赛赛季
    private function _season_info($sclass_id)
    {
        return array_column($this->schedule_db->select('`sclassid`=' . $sclass_id, 'DISTINCT `sclassseason`', '', '`sclassseason`'), 'sclassseason');
    }

    //获取表更新时间
    private function _update_time($table)
    {
        $this->db->query('SELECT `update_time` FROM information_schema.tables WHERE `table_name`="' . $table . '"');
        $update_time = $this->db->fetch_array()[0]['update_time'];
        return $update_time;
    }
}