<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class oddsway_stats_model extends model {
    public $table_name = '';
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'sportsdt';
        $this->table_name = 'oddsway_stats';
        parent::__construct();
    }

    public function oddsway($competitionid, $type = 'total', $stat = false)
    {
        $info = $stat_info = $count = array();
        if ($competitionid) {
            if ($type) {
                $where = '`competitionid`=' . $competitionid . ' AND `type`="' . $type . '"';
                $raw = $this->select($where);
                if (count($raw)) {
                    //排名
                    $win_arr = array_unique(array_column($raw, 'win'));
                    rsort($win_arr);
                    foreach ($raw as $value) {
                        $rank = array_search($value['win'], $win_arr) + 1;
                        $info[$rank][] = $value;
                    }
                    //逆序排名
                    ksort($info);
                }
            } else {
                $where = '`competitionid`=' . $competitionid;
                $raw = $this->select($where);
                if (count($raw)) {
                    //按类型分组
                    $tmp = array();
                    foreach ($raw as $value) {
                        $tmp[$value['type']][] = $value;
                    }
                    //统计排名
                    foreach ($tmp as $key => $group) {
                        //统计
                        if ($stat) {
                            $count[$key]['sum'] = array_sum(array_column($group, 'total'));
                            $count[$key]['win'] = array_column($group, 'win');
                            $count[$key]['draw'] = array_column($group, 'draw');
                            $count[$key]['lose'] = array_column($group, 'lose');
                        }
                        //积分排名
                        $win_arr = array_unique(array_column($group, 'win'));
                        rsort($win_arr);
                        foreach ($group as $value) {
                            $rank = array_search($value['win'], $win_arr) + 1;
                            $info[$key][$rank][] = $value;
                        }
                        //分组内部逆序排名
                        ksort($info[$key]);
                    }
                    //统计
                    if ($stat && count($info)) {
                        $max_draw = max($count['total']['draw']);
                        $stat_info['max_win']['total'] = max($count['total']['win']);
                        $stat_info['max_win']['home'] = max($count['home']['win']);
                        $stat_info['max_win']['away'] = max($count['away']['win']);
                        $stat_info['min_win']['total'] = min($count['total']['win']);
                        $stat_info['min_win']['home'] = min($count['home']['win']);
                        $stat_info['min_win']['away'] = min($count['away']['win']);

                        //主场赢盘
                        $stat_info['home_win'] = array_sum($count['home']['win']);
                        $stat_info['home_win_rate'] = round(($stat_info['home_win'] / $count['home']['sum']) * 100, 2) . "%";

                        //客场赢盘
                        $stat_info['away_win'] = array_sum($count['away']['win']);
                        $stat_info['away_win_rate'] = round(($stat_info['away_win'] / $count['away']['sum']) * 100, 2) . "%";

                        //和局走水
                        $stat_info['draw'] = array_sum($count['total']['draw']);
                        $stat_info['draw_rate'] = round(($stat_info['draw'] / $count['total']['sum']) * 100, 2) . "%";

                        foreach ($info as $key => $group) {
                            foreach ($group as $value) {
                                foreach ($value as $row) {
                                    //赢盘最多
                                    if ($row['win'] == $stat_info['max_win'][$key]) {
                                        $stat_info['best_win'][$key][] = array(
                                            'id' => $row['teamid'],
                                            'name' => $row['teamname']
                                        );
                                        $stat_info['best_win_rate'][$key] = $row['winrate'] . '%';
                                    }
                                    //赢盘最少
                                    if ($row['win'] == $stat_info['min_win'][$key]) {
                                        $stat_info['weak_win'][$key][] = array(
                                            'id' => $row['teamid'],
                                            'name' => $row['teamname']
                                        );
                                        $stat_info['weak_win_rate'][$key] = $row['winrate'] . '%';
                                    }
                                    //走水最多
                                    if ($row['draw'] == $max_draw) {
                                        $stat_info['best_draw'][] = array(
                                            'id' => $row['teamid'],
                                            'name' => $row['teamname']
                                        );
                                        $stat_info['max_draw_rate'] = round(($row['draw'] / $row['total']) * 100, 2) . "%";
                                    }
                                }
                            }
                        }

                        return array($info, $stat_info);
                    }
                }
            }
        }

        return $info;
    }
}
?>