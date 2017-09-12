<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class totalscore_model extends model {
    public $table_name = '';

    public $team_arr;

    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'win007.com';
        $this->table_name = 'totalscore';
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
            $raw = $this->select('`scheduleid` IN (' . join(',', $schedule_ids) . ') AND `companyid`=' . $company, '`scheduleid`,`totalscore_f`', '', '', '', 'scheduleid');
            if (count($raw)) {
                //基本统计
                foreach ($schedule_info as $id => $schedule) {
                    $total_score = $raw[$id];
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
                    //大小球
                    if (($schedule['homescore'] + $schedule['guestscore']) > $total_score['totalscore_f']) {
                        $info['total'][$schedule['hometeamid']]['big'] += 1;
                        $info['total'][$schedule['guestteamid']]['big'] += 1;
                        $info['home'][$schedule['hometeamid']]['big'] += 1;
                        $info['guest'][$schedule['guestteamid']]['big'] += 1;
                    } elseif (($schedule['homescore'] + $schedule['guestscore']) < $total_score['totalscore_f']) {
                        $info['total'][$schedule['hometeamid']]['small'] += 1;
                        $info['total'][$schedule['guestteamid']]['small'] += 1;
                        $info['home'][$schedule['hometeamid']]['small'] += 1;
                        $info['guest'][$schedule['guestteamid']]['small'] += 1;
                    } else {
                        $info['total'][$schedule['hometeamid']]['run'] += 1;
                        $info['total'][$schedule['guestteamid']]['run'] += 1;
                        $info['home'][$schedule['hometeamid']]['run'] += 1;
                        $info['guest'][$schedule['guestteamid']]['run'] += 1;
                    }
                }
                //概率统计
                foreach ($info as $type => &$_data) {
                    foreach ($_data as $id => &$_value) {
                        //大球率
                        $_value['big_rate'] = round(($_value['big'] / $_value['total']) * 100, 1);
                        //小球率
                        $_value['small_rate'] = round(($_value['small'] / $_value['total']) * 100, 1);
                        //走率
                        $_value['run_rate'] = round(($_value['run'] / $_value['total']) * 100, 1);
                    }
                }
                //大球
                $stats['big']['total'] = array_sum(array_column($info['total'], 'big'));
                $stats['big_rate'] = round(($stats['big']['total'] / array_sum(array_column($info['total'], 'total'))) * 100, 1);
                $stats['big_max']['total'] = max(array_column($info['total'], 'big_rate'));
                $stats['big_max']['home'] = max(array_column($info['home'], 'big_rate'));
                $stats['big_max']['guest'] = max(array_column($info['guest'], 'big_rate'));
                //小球
                $stats['small']['total'] = array_sum(array_column($info['total'], 'small'));
                $stats['small_rate'] = round(($stats['small']['total'] / array_sum(array_column($info['total'], 'total'))) * 100, 1);
                $stats['small_max']['total'] = max(array_column($info['total'], 'small_rate'));
                $stats['small_max']['home'] = max(array_column($info['home'], 'small_rate'));
                $stats['small_max']['guest'] = max(array_column($info['guest'], 'small_rate'));
                //走地
                $stats['run']['total'] = array_sum(array_column($info['total'], 'run'));
                $stats['run_rate'] = round(($stats['run']['total'] / array_sum(array_column($info['total'], 'total'))) * 100, 1);
                foreach ($info['home'] as $value) {
                    if ($value['big_rate'] == $stats['big_max']['home']) {
                        $stats['best']['big']['home'][$value['id']] = $value['name'];
                    }
                    if ($value['small_rate'] == $stats['small_max']['home']) {
                        $stats['best']['small']['home'][$value['id']] = $value['name'];
                    }
                }
                foreach ($info['guest'] as $value) {
                    if ($value['big_rate'] == $stats['big_max']['guest']) {
                        $stats['best']['big']['guest'][$value['id']] = $value['name'];
                    }
                    if ($value['small_rate'] == $stats['small_max']['guest']) {
                        $stats['best']['small']['guest'][$value['id']] = $value['name'];
                    }
                }
                foreach ($info['total'] as $value) {
                    if ($value['big_rate'] == $stats['big_max']['total']) {
                        $stats['best']['big']['total'][$value['id']] = $value['name'];
                    }
                    if ($value['small_rate'] == $stats['small_max']['total']) {
                        $stats['best']['small']['total'][$value['id']] = $value['name'];
                    }
                }
                //重新排序
                foreach ($info as $type => &$_data) {
                    $_data = sort_by($_data, 'big_rate', 'desc');
                }
            }
        }
        return array($info, $stats);
    }
}
?>