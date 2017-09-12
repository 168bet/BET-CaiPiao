<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class letgoal_model extends model {
    public $table_name = '';

    public $team_arr;

    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'win007.com';
        $this->table_name = 'letgoal';
        parent::__construct();
    }

    public function standings($where)
    {
        $info = $stats = array();
        //联赛数据
        $schedule_db = pc_base::load_model('bt_schedule_model');
        $schedule_info = $schedule_db->select($where, '`scheduleid`,`hometeamid`,`guestteamid`,`homename_cn`,`guestname_cn`,`homescore`,`guestscore`', '', '', '', 'scheduleid');
        if (count($schedule_info)) {
            $schedule_ids = array_keys($schedule_info);
            //默认易胜博
            $company = 2;
            $raw = $this->select('`scheduleid` IN (' . join(',', $schedule_ids) . ') AND `companyid`=' . $company, '`scheduleid`,`letgoal_f`', '', '', '', 'scheduleid');
            if (count($raw)) {
                //基本统计
                foreach ($schedule_info as $id => $schedule) {
                    $let_goal = $raw[$id];
                    //球队信息
                    $info['total'][$schedule['hometeamid']]['name'] = $schedule['homename_cn'];
                    $info['total'][$schedule['guestteamid']]['name'] = $schedule['guestname_cn'];
                    $info['home'][$schedule['hometeamid']]['name'] = $schedule['homename_cn'];
                    $info['guest'][$schedule['guestteamid']]['name'] = $schedule['guestname_cn'];
                    $info['total'][$schedule['hometeamid']]['id'] = $schedule['hometeamid'];
                    $info['total'][$schedule['guestteamid']]['id'] = $schedule['guestteamid'];
                    $info['home'][$schedule['hometeamid']]['id'] = $schedule['hometeamid'];
                    $info['guest'][$schedule['guestteamid']]['id'] = $schedule['guestteamid'];
                    $this->team_arr[$schedule['hometeamid']] = $schedule['homename_cn'];
                    $this->team_arr[$schedule['guestteamid']] = $schedule['guestname_cn'];
                    //开赛场次
                    $info['total'][$schedule['hometeamid']]['total'] += 1;
                    $info['total'][$schedule['guestteamid']]['total'] += 1;
                    $info['home'][$schedule['hometeamid']]['total'] += 1;
                    $info['guest'][$schedule['guestteamid']]['total'] += 1;
                    //上下盘
                    if ($let_goal['letgoal_f'] >= 0) {
                        $info['total'][$schedule['hometeamid']]['up'] += 1;
                        $info['total'][$schedule['guestteamid']]['down'] += 1;
                        $info['home'][$schedule['hometeamid']]['up'] += 1;
                        $info['guest'][$schedule['guestteamid']]['down'] += 1;
                    } else {
                        $info['total'][$schedule['hometeamid']]['down'] += 1;
                        $info['total'][$schedule['guestteamid']]['up'] += 1;
                        $info['home'][$schedule['hometeamid']]['down'] += 1;
                        $info['guest'][$schedule['guestteamid']]['up'] += 1;
                    }
                    //盘路
                    $plate = get_plate($schedule['homescore'], $schedule['guestscore'], $let_goal['letgoal_f']);
//                    $info['total'][$schedule['hometeamid']][$plate[0]] += 1;
//                    $info['total'][$schedule['guestteamid']][$plate[0]] += 1;
//                    $info['home'][$schedule['hometeamid']][$plate[0]] += 1;
//                    $info['guest'][$schedule['guestteamid']][$plate[0]] += 1;
                    switch ($plate[0]) {
                        case 'win':
                            $info['total'][$schedule['hometeamid']]['win'] += 1;
                            $info['total'][$schedule['guestteamid']]['lose'] += 1;
                            $info['home'][$schedule['hometeamid']]['win'] += 1;
                            $info['guest'][$schedule['guestteamid']]['lose'] += 1;
                            break;
                        case 'lose';
                            $info['total'][$schedule['hometeamid']]['lose'] += 1;
                            $info['total'][$schedule['guestteamid']]['win'] += 1;
                            $info['home'][$schedule['hometeamid']]['lose'] += 1;
                            $info['guest'][$schedule['guestteamid']]['win'] += 1;
                            break;
                        case 'equal':
                            $info['total'][$schedule['hometeamid']]['equal'] += 1;
                            $info['total'][$schedule['guestteamid']]['equal'] += 1;
                            $info['home'][$schedule['hometeamid']]['equal'] += 1;
                            $info['guest'][$schedule['guestteamid']]['equal'] += 1;
                            break;
                        default:
                            break;
                    }
                }
                //净胜，概率统计
                foreach ($info as $type => &$_data) {
                    foreach ($_data as $id => &$_value) {
                        //净胜
                        $_value['net'] = $_value['win'] - $_value['lose'];
                        //胜率
                        $_value['win_rate'] = round(($_value['win'] / $_value['total']) * 100, 1);
                        //败率
                        $_value['lose_rate'] = round(($_value['lose'] / $_value['total']) * 100, 1);
                        //走率
                        $_value['draw_rate'] = round(($_value['equal'] / $_value['total']) * 100, 1);
                    }
                }
                //主场赢盘
                $stats['win']['home'] = array_sum(array_column($info['home'], 'win'));
                $stats['win']['home_avg'] = round(array_sum(array_column($info['home'], 'total')) / $stats['win']['home'], 1);
                //和局走水
                $stats['draw_min'] = min(array_column($info['total'], 'draw_rate'));
                $stats['draw_max'] = max(array_column($info['total'], 'draw_rate'));
                $stats['draw']['total'] = array_sum(array_column($info['total'], 'equal'));
                $stats['draw']['avg'] = round(array_sum(array_column($info['home'], 'equal')) / array_sum(array_column($info['home'], 'total')), 1);
                //客场赢盘
                $stats['win']['guest'] = array_sum(array_column($info['guest'], 'win'));
                $stats['win']['guest_avg'] = round(array_sum(array_column($info['guest'], 'total')) / $stats['win']['guest'], 1);
                //最佳投注
                $stats['win_max']['total'] = max(array_column($info['total'], 'win_rate'));
                //避免投注
                $stats['win_min']['total'] = min(array_column($info['total'], 'win_rate'));
                foreach ($info['total'] as $value) {
                    if ($value['win_rate'] == $stats['win_max']['total']) {
                        $stats['best']['total'][$value['id']] = $value['name'];
                    }
                    if ($value['win_rate'] == $stats['win_min']['total']) {
                        $stats['weak']['total'][$value['id']] = $value['name'];
                    }
                    if ($value['draw_rate'] == $stats['draw_min']) {
                        $stats['draw']['min'][$value['id']] = $value['name'];
                    }
                    if ($value['draw_rate'] == $stats['draw_max'] && $stats['draw_max']) {
                        $stats['draw']['max'][$value['id']] = $value['name'];
                    }
                }
                //主场最佳
                $stats['win_max']['home'] = max(array_column($info['home'], 'win_rate'));
                //客场最佳
                $stats['win_max']['guest'] = max(array_column($info['guest'], 'win_rate'));
                //主场最差
                $stats['win_min']['home'] = min(array_column($info['home'], 'win_rate'));
                //客场最差
                $stats['win_min']['guest'] = min(array_column($info['guest'], 'win_rate'));
                foreach ($info['home'] as $value) {
                    if ($value['win_rate'] == $stats['win_max']['home']) {
                        $stats['best']['home'][$value['id']] = $value['name'];
                    }
                    if ($value['win_rate'] == $stats['win_min']['home']) {
                        $stats['weak']['home'][$value['id']] = $value['name'];
                    }
                }
                foreach ($info['guest'] as $value) {
                    if ($value['win_rate'] == $stats['win_max']['guest']) {
                        $stats['best']['guest'][$value['id']] = $value['name'];
                    }
                    if ($value['win_rate'] == $stats['win_min']['guest']) {
                        $stats['weak']['guest'][$value['id']] = $value['name'];
                    }
                }
                //重新排序
                foreach ($info as $type => &$_data) {
                    $_data = sort_by($_data, 'win_rate', 'desc');
                }
            }
        }
        return array($info, $stats);
    }
}
?>